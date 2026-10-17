/* Cozy Blocks – Form block: validation, multi-step navigation and submission. */
(function () {
	"use strict";

	var FIELD_PREFIX = "cozy_addons_form_f";

	function clearErrors(form) {
		form.querySelectorAll(".cozy-form__error").forEach(function (node) {
			node.remove();
		});
		form.querySelectorAll("[aria-invalid]").forEach(function (node) {
			node.removeAttribute("aria-invalid");
		});
	}

	function showMessage(box, text, ok) {
		box.textContent = text;
		box.hidden = false;
		box.className = "cozy-form__message " + (ok ? "is-success" : "is-error");
		box.focus();
	}

	/** The input of a field, or the first box of a checkbox group. */
	function fieldInput(form, key) {
		var name = FIELD_PREFIX + "[" + key + "]";
		return form.querySelector('[name="' + name + '"], [name="' + name + '[]"]');
	}

	/**
	 * Messages the browser cannot produce by itself: the site's own message for a failed
	 * validation rule (Pro), "choose at least one" for a required checkbox group, and a file
	 * over the size limit.
	 */
	function prepareValidity(form, scope) {
		scope.querySelectorAll("[data-message]").forEach(function (input) {
			input.setCustomValidity("");
			var v = input.validity;
			if (v.patternMismatch || v.tooShort || v.tooLong || v.rangeUnderflow || v.rangeOverflow) {
				input.setCustomValidity(input.getAttribute("data-message"));
			}
		});
		// Too many or too large files are caught before the upload. The server checks again.
		scope.querySelectorAll('input[type="file"][data-max-size]').forEach(function (input) {
			var max = parseInt(input.getAttribute("data-max-size"), 10) || 0;
			var maxFiles = parseInt(input.getAttribute("data-max-files"), 10) || 1;
			var picked = Array.prototype.slice.call(input.files || []);
			var message = "";
			if (picked.length > maxFiles) {
				message = (form.getAttribute("data-too-many") || "").replace("%d", String(maxFiles));
			} else if (
				max &&
				picked.some(function (file) {
					return file.size > max;
				})
			) {
				message = form.getAttribute("data-too-large") || "";
			}
			input.setCustomValidity(message);
		});
		// A required signature pad that is still empty.
		scope.querySelectorAll(".cozy-form__sig-value").forEach(function (input) {
			input.setCustomValidity(input.required && !input.value ? input.getAttribute("data-sign") || "" : "");
		});
		scope.querySelectorAll('fieldset[data-required="true"]').forEach(function (group) {
			var boxes = group.querySelectorAll('input[type="checkbox"]');
			if (!boxes.length) {
				return;
			}
			var ticked = group.querySelector('input[type="checkbox"]:checked');
			boxes[0].setCustomValidity(ticked ? "" : form.getAttribute("data-choose") || "");
		});
	}

	/**
	 * Hidden value fields (Pro) that take their value from the page, e.g. ?utm_source=.
	 */
	function fillDynamic(form) {
		form.querySelectorAll("input[data-dynamic]").forEach(function (input) {
			var source = input.getAttribute("data-dynamic");
			var value = null;
			if (source === "page_url") {
				value = window.location.href;
			} else if (source === "page_title") {
				value = document.title;
			} else if (source === "referrer") {
				value = document.referrer;
			} else if (source === "query" && window.URLSearchParams) {
				value = new URLSearchParams(window.location.search).get(input.getAttribute("data-param") || "");
			}
			if (value) {
				input.value = value.slice(0, 300);
			}
		});
	}

	/**
	 * Conditional logic (Pro): shows or hides fields as visitors answer. Hidden fields are
	 * disabled, so they are neither validated nor sent. Same rules as
	 * cozy_addons_form_hidden_fields() on the server.
	 */
	function setupConditions(form) {
		var wrappers = Array.prototype.slice.call(form.querySelectorAll(".cozy-form__field[data-conditions]"));
		if (!wrappers.length) {
			return function () {};
		}
		var fields = [];
		wrappers.forEach(function (wrapper) {
			try {
				var c = JSON.parse(wrapper.getAttribute("data-conditions"));
				if (c && c.r && c.r.length) {
					fields.push({ wrapper: wrapper, name: wrapper.getAttribute("data-name"), c: c });
				}
			} catch (e) {
				// Leave the field as it is.
			}
		});

		function valueOf(name) {
			var values = [];
			form.querySelectorAll('[name="' + FIELD_PREFIX + "[" + name + ']"], [name="' + FIELD_PREFIX + "[" + name + '][]"]').forEach(
				function (input) {
					if ((input.type === "checkbox" || input.type === "radio") && !input.checked) {
						return;
					}
					var value = String(input.value || "").trim();
					if (value !== "") {
						values.push(value);
					}
				},
			);
			return values;
		}

		function matches(op, values, expected) {
			switch (op) {
				case "empty":
					return !values.length;
				case "not_empty":
					return values.length > 0;
				case "is":
					return values.indexOf(expected) > -1;
				case "is_not":
					return values.indexOf(expected) === -1;
				case "contains":
					return expected !== "" && values.join(", ").toLowerCase().indexOf(expected.toLowerCase()) > -1;
			}
			return false;
		}

		function apply() {
			var hidden = {};
			for (var pass = 0; pass < 5; pass++) {
				var changed = false;
				fields.forEach(function (field) {
					var results = field.c.r.map(function (rule) {
						return matches(rule[1], hidden[rule[0]] ? [] : valueOf(rule[0]), String(rule[2]));
					});
					var matched = field.c.m === "any" ? results.indexOf(true) > -1 : results.indexOf(false) === -1;
					var isHidden = field.c.a === "hide" ? matched : !matched;
					if (isHidden !== !!hidden[field.name]) {
						if (isHidden) {
							hidden[field.name] = true;
						} else {
							delete hidden[field.name];
						}
						changed = true;
					}
				});
				if (!changed) {
					break;
				}
			}
			fields.forEach(function (field) {
				var isHidden = !!hidden[field.name];
				field.wrapper.hidden = isHidden;
				field.wrapper.querySelectorAll("input, select, textarea").forEach(function (input) {
					input.disabled = isHidden;
				});
			});
		}

		form.addEventListener("input", apply);
		form.addEventListener("change", apply);
		apply();

		return apply;
	}

	/**
	 * Image upload fields (Pro): thumbnails of the chosen images, made in the browser only.
	 */
	function setupImagePreviews(form) {
		var inputs = Array.prototype.slice.call(form.querySelectorAll(".cozy-form__field--image input[type=\"file\"]"));

		function render(input) {
			var box = input.parentNode.querySelector(".cozy-form__previews");
			if (!box) {
				return;
			}
			box.querySelectorAll("img").forEach(function (img) {
				URL.revokeObjectURL(img.src);
			});
			box.textContent = "";
			Array.prototype.slice.call(input.files || []).forEach(function (file) {
				if (!/^image\//.test(file.type) || !window.URL || !URL.createObjectURL) {
					return;
				}
				var img = document.createElement("img");
				img.className = "cozy-form__preview";
				img.alt = file.name;
				img.src = URL.createObjectURL(file);
				box.appendChild(img);
			});
		}

		inputs.forEach(function (input) {
			input.addEventListener("change", function () {
				render(input);
			});
		});

		return function () {
			inputs.forEach(render);
		};
	}

	/**
	 * Signature fields (Pro): draw with a mouse, finger or pen. The drawing is kept as a PNG in
	 * the field's text input, which is what gets sent.
	 */
	function setupSignatures(form) {
		var pads = [];

		form.querySelectorAll(".cozy-form__field--signature").forEach(function (field) {
			var canvas = field.querySelector("canvas.cozy-form__pad");
			var input = field.querySelector(".cozy-form__sig-value");
			if (!canvas || !input || !canvas.getContext) {
				return;
			}
			var ctx = canvas.getContext("2d");
			if (!ctx) {
				return;
			}
			var clear = field.querySelector(".cozy-form__sig-clear");
			var height = parseInt(canvas.getAttribute("data-height"), 10) || 160;
			var drawing = false;
			var last = null;
			var width = 0;

			function size() {
				var ratio = window.devicePixelRatio || 1;
				var cssWidth = canvas.parentNode.clientWidth;
				// Pads in a hidden step have no width yet; they are sized when first used.
				if (!cssWidth || cssWidth === width) {
					return;
				}
				// Keep what was drawn when the pad changes size, e.g. on rotating a phone.
				var snapshot = input.value ? new window.Image() : null;
				if (snapshot) {
					snapshot.src = input.value;
				}
				width = cssWidth;
				canvas.style.height = height + "px";
				canvas.width = Math.round(cssWidth * ratio);
				canvas.height = Math.round(height * ratio);
				ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
				ctx.lineWidth = 2.2;
				ctx.lineCap = "round";
				ctx.lineJoin = "round";
				ctx.strokeStyle = "#111";
				if (snapshot) {
					snapshot.onload = function () {
						ctx.drawImage(snapshot, 0, 0, cssWidth, height);
					};
				}
			}

			function point(event) {
				var box = canvas.getBoundingClientRect();
				return { x: event.clientX - box.left, y: event.clientY - box.top };
			}

			function save() {
				input.value = canvas.toDataURL("image/png");
				input.setCustomValidity("");
				input.dispatchEvent(new Event("change", { bubbles: true }));
			}

			function reset() {
				ctx.save();
				ctx.setTransform(1, 0, 0, 1, 0, 0);
				ctx.clearRect(0, 0, canvas.width, canvas.height);
				ctx.restore();
				input.value = "";
			}

			canvas.addEventListener("pointerdown", function (event) {
				event.preventDefault();
				size();
				drawing = true;
				last = point(event);
				if (canvas.setPointerCapture) {
					canvas.setPointerCapture(event.pointerId);
				}
				// A tap leaves a dot.
				ctx.beginPath();
				ctx.arc(last.x, last.y, 1.1, 0, Math.PI * 2);
				ctx.fillStyle = "#111";
				ctx.fill();
			});
			canvas.addEventListener("pointermove", function (event) {
				if (!drawing) {
					return;
				}
				var next = point(event);
				ctx.beginPath();
				ctx.moveTo(last.x, last.y);
				ctx.lineTo(next.x, next.y);
				ctx.stroke();
				last = next;
			});
			["pointerup", "pointercancel", "pointerleave"].forEach(function (type) {
				canvas.addEventListener(type, function () {
					if (drawing) {
						drawing = false;
						save();
					}
				});
			});
			if (clear) {
				clear.addEventListener("click", function () {
					reset();
					input.dispatchEvent(new Event("change", { bubbles: true }));
				});
			}
			canvas.style.height = height + "px";
			window.addEventListener("resize", size);
			size();
			pads.push(reset);
		});

		return function () {
			pads.forEach(function (reset) {
				reset();
			});
		};
	}

	/**
	 * Google reCAPTCHA v2 (Pro): draws the "I'm not a robot" checkbox once Google's script is ready.
	 * The script is loaded with render=explicit after this one.
	 */
	function setupRecaptcha(form) {
		var boxes = Array.prototype.slice.call(form.querySelectorAll(".cozy-form__recaptcha[data-sitekey]"));
		if (!boxes.length) {
			return;
		}
		var tries = 0;
		(function draw() {
			if (!window.grecaptcha || typeof window.grecaptcha.render !== "function") {
				// Give up quietly after about 20 seconds; the server refuses the form without a token.
				if (tries++ < 100) {
					window.setTimeout(draw, 200);
				}
				return;
			}
			boxes.forEach(function (box) {
				if (!box.hasAttribute("data-widget-id")) {
					var id = window.grecaptcha.render(box, { sitekey: box.getAttribute("data-sitekey") });
					box.setAttribute("data-widget-id", String(id));
				}
			});
		})();
	}

	/**
	 * Google reCAPTCHA v3 (Pro): a fresh token for each attempt, as tokens expire after two minutes.
	 * Resolves either way; without a token the server refuses the form with a clear message.
	 */
	function recaptchaV3Token(form) {
		var input = form.querySelector("input.cozy-form__recaptcha-v3[data-sitekey]");
		if (!input || !window.grecaptcha || typeof window.grecaptcha.ready !== "function") {
			return Promise.resolve();
		}
		return new Promise(function (resolve) {
			window.grecaptcha.ready(function () {
				window.grecaptcha
					.execute(input.getAttribute("data-sitekey"), { action: input.getAttribute("data-action") || "cozy_form" })
					.then(function (token) {
						input.value = token;
						resolve();
					}, resolve);
			});
		});
	}

	function showFieldErrors(form, errors, stepper) {
		var first = null;
		Object.keys(errors || {}).forEach(function (key) {
			var input = fieldInput(form, key);
			if (!input) {
				return;
			}
			input.setAttribute("aria-invalid", "true");
			var note = document.createElement("span");
			note.className = "cozy-form__error";
			note.textContent = errors[key];
			var host = input.closest(".cozy-form__field") || input.parentNode;
			host.appendChild(note);
			if (!first) {
				first = input;
			}
		});
		if (first) {
			if (stepper) {
				stepper.showFieldStep(first);
			}
			first.focus();
		}
	}

	/**
	 * Multi-step forms: one step at a time with Back / Next and a progress indicator, either a
	 * bar or numbered steps. Only set up when the server marked the form with data-steps (Pro).
	 */
	function setupSteps(form) {
		if (!form.hasAttribute("data-steps")) {
			return null;
		}
		var steps = Array.prototype.slice.call(form.querySelectorAll(".cozy-form__step"));
		if (!steps.length) {
			return null;
		}
		var back = form.querySelector(".cozy-form__back");
		var next = form.querySelector(".cozy-form__next");
		var submit = form.querySelector(".cozy-form__submit");
		var progress = form.querySelector(".cozy-form__progress");
		var text = form.querySelector(".cozy-form__progress-text");
		var fill = form.querySelector(".cozy-form__progress-fill");
		var nav = form.querySelector(".cozy-form__step-nav");
		var navItems = nav ? Array.prototype.slice.call(nav.querySelectorAll(".cozy-form__step-nav-item")) : [];
		var pattern = form.getAttribute("data-step-label") || "Step %1$s of %2$s";
		var reduceMotion = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;
		var index = 0;

		function updateNav() {
			navItems.forEach(function (item, n) {
				var done = n < index;
				item.classList.toggle("is-current", n === index);
				item.classList.toggle("is-done", done);
				if (n === index) {
					item.setAttribute("aria-current", "step");
				} else {
					item.removeAttribute("aria-current");
				}
				// Completed steps can be revisited; later ones only through Next.
				if (done) {
					item.setAttribute("role", "button");
					item.tabIndex = 0;
				} else {
					item.removeAttribute("role");
					item.removeAttribute("tabindex");
				}
			});
		}

		function show(i, focus) {
			index = Math.max(0, Math.min(steps.length - 1, i));
			steps.forEach(function (step, n) {
				step.hidden = n !== index;
			});
			back.hidden = index === 0;
			next.hidden = index === steps.length - 1;
			submit.hidden = index !== steps.length - 1;
			if (progress) {
				progress.hidden = false;
			}
			if (nav) {
				nav.hidden = false;
			}
			updateNav();
			var title = steps[index].getAttribute("data-title") || "";
			if (text) {
				text.textContent =
					pattern.replace("%1$s", String(index + 1)).replace("%2$s", String(steps.length)) +
					(title ? " – " + title : "");
			}
			if (fill) {
				fill.style.width = ((index + 1) / steps.length) * 100 + "%";
			}
			if (focus) {
				// Bring the top of the form back into view on long steps.
				var top = form.getBoundingClientRect().top;
				if (top < 0 || top > window.innerHeight) {
					form.scrollIntoView({ behavior: reduceMotion ? "auto" : "smooth", block: "start" });
				}
				var first = steps[index].querySelector(
					'input:not([type="hidden"]):not(.cozy-form__sig-value):not(:disabled), select:not(:disabled), textarea:not(:disabled)',
				);
				if (first) {
					first.focus({ preventScroll: true });
				}
			}
		}

		function validCurrent() {
			prepareValidity(form, steps[index]);
			var fields = steps[index].querySelectorAll("input, select, textarea");
			for (var i = 0; i < fields.length; i++) {
				if (!fields[i].checkValidity()) {
					fields[i].reportValidity();
					return false;
				}
			}
			return true;
		}

		next.addEventListener("click", function () {
			if (validCurrent()) {
				show(index + 1, true);
			}
		});
		back.addEventListener("click", function () {
			show(index - 1, true);
		});
		navItems.forEach(function (item, n) {
			function revisit(event) {
				if (n < index && (event.type === "click" || event.key === "Enter" || event.key === " ")) {
					event.preventDefault();
					show(n, true);
				}
			}
			item.addEventListener("click", revisit);
			item.addEventListener("keydown", revisit);
		});
		// Enter inside a text field moves on instead of submitting early.
		form.addEventListener("keydown", function (event) {
			if (
				event.key === "Enter" &&
				index < steps.length - 1 &&
				event.target.tagName === "INPUT" &&
				event.target.type !== "checkbox" &&
				event.target.type !== "radio"
			) {
				event.preventDefault();
				next.click();
			}
		});
		show(0, false);

		return {
			showFieldStep: function (field) {
				var at = steps.indexOf(field.closest(".cozy-form__step"));
				if (at > -1) {
					show(at, false);
				}
			},
			reset: function () {
				show(0, false);
			},
		};
	}

	/**
	 * Product enquiries: copy the chosen variation, options and quantity from the product page.
	 * The server looks up the variation's SKU and price itself.
	 */
	function captureProduct(form) {
		var variationField = form.querySelector('[name="cozy_addons_form_variation_id"]');
		var cart = document.querySelector("form.variations_form, form.cart");
		if (!variationField || !cart) {
			return;
		}
		var optionsField = form.querySelector('[name="cozy_addons_form_product_options"]');
		var scope = form.closest(".cozy-block-form") || form;
		var variation = cart.querySelector('input[name="variation_id"]');
		var qtyInput = cart.querySelector('input.qty, input[name="quantity"]');
		var labels = cart.querySelectorAll("label");
		var parts = [];

		variationField.value = variation && variation.value && variation.value !== "0" ? variation.value : "";
		cart.querySelectorAll('select[name^="attribute_"]').forEach(function (select) {
			if (!select.value) {
				return;
			}
			var label = select.name.replace("attribute_", "").replace(/^pa_/, "");
			for (var i = 0; i < labels.length; i++) {
				if (select.id && labels[i].htmlFor === select.id) {
					label = labels[i].textContent.trim();
					break;
				}
			}
			var chosen = select.options[select.selectedIndex];
			parts.push(label + ": " + (chosen ? chosen.text.trim() : select.value));
		});
		if (optionsField) {
			optionsField.value = parts.join("; ");
		}
		var note = scope.querySelector(".cozy-form__product-options");
		if (note) {
			note.textContent = parts.join(" · ");
		}
		// Prefill the number field (Quantity in the preset) when the visitor has not typed one.
		var quantity = form.querySelector('.cozy-form__field--number input');
		if (quantity && !quantity.value && qtyInput && qtyInput.value) {
			quantity.value = qtyInput.value;
		}
	}

	/**
	 * Pop-up product enquiry: open and close the dialog.
	 */
	function setupDialog(wrapper) {
		var opener = wrapper.querySelector(".cozy-form__open");
		var dialog = wrapper.querySelector("dialog.cozy-form__dialog");
		if (!opener || !dialog) {
			return;
		}
		var form = dialog.querySelector("form.cozy-form__form");

		function closeDialog() {
			if (typeof dialog.close === "function") {
				dialog.close();
			} else {
				dialog.removeAttribute("open");
			}
			opener.focus();
		}

		opener.addEventListener("click", function () {
			if (form) {
				captureProduct(form);
			}
			if (typeof dialog.showModal === "function") {
				dialog.showModal();
			} else {
				dialog.setAttribute("open", "");
			}
		});
		var close = dialog.querySelector(".cozy-form__close");
		if (close) {
			close.addEventListener("click", closeDialog);
		}
		// Clicking the dimmed backdrop closes the pop-up.
		dialog.addEventListener("click", function (event) {
			var box = dialog.getBoundingClientRect();
			var outside =
				event.clientX < box.left ||
				event.clientX > box.right ||
				event.clientY < box.top ||
				event.clientY > box.bottom;
			if (event.target === dialog && outside && box.width > 0) {
				closeDialog();
			}
		});
	}

	function init(form) {
		var started = Date.now();
		var button = form.querySelector(".cozy-form__submit");
		var box = form.querySelector(".cozy-form__message");
		var busy = false;
		var stepper = setupSteps(form);
		var applyConditions = setupConditions(form);
		var resetPreviews = setupImagePreviews(form);
		var resetSignatures = setupSignatures(form);

		setupRecaptcha(form);

		fillDynamic(form);
		// Custom messages clear as soon as the visitor corrects the field.
		form.addEventListener("input", function () {
			prepareValidity(form, form);
		});
		form.addEventListener("change", function () {
			prepareValidity(form, form);
		});

		form.addEventListener("submit", function (event) {
			event.preventDefault();
			if (busy) {
				return;
			}
			prepareValidity(form, form);
			if (!form.checkValidity()) {
				form.reportValidity();
				return;
			}
			clearErrors(form);
			captureProduct(form);
			var oldDownload = form.querySelector(".cozy-form__download");
			if (oldDownload) {
				oldDownload.remove();
			}

			busy = true;
			button.disabled = true;
			button.setAttribute("aria-busy", "true");

			recaptchaV3Token(form)
				.then(function () {
					var data = new FormData(form);
					data.append("cozy_addons_form_el", String(Date.now() - started));
					data.append("cozy_addons_form_page", window.location.href);
					data.append("cozy_addons_form_title", document.title);

					return fetch(form.getAttribute("data-endpoint"), {
						method: "POST",
						body: data,
						credentials: "same-origin",
					});
				})
				.then(function (res) {
					return res
						.json()
						.catch(function () {
							return { ok: false };
						})
						.then(function (body) {
							return body || {};
						});
				})
				.then(function (body) {
					if (body.ok) {
						if (body.redirect) {
							window.location.assign(body.redirect);
							return;
						}
						form.classList.add("is-sent");
						showMessage(box, body.message || "", true);
						// Pro: the file promised by the form, e.g. a lead magnet's guide.
						if (body.download && /^https?:\/\//i.test(body.download.url || "")) {
							var link = document.createElement("a");
							link.className = "wp-element-button cozy-form__button cozy-form__download";
							link.href = body.download.url;
							link.target = "_blank";
							link.rel = "noopener";
							link.textContent = body.download.label || body.download.url;
							box.insertAdjacentElement("afterend", link);
						}
						form.reset();
						fillDynamic(form);
						resetPreviews();
						resetSignatures();
						applyConditions();
						if (stepper) {
							stepper.reset();
						}
						return;
					}
					if (body.errors && Object.keys(body.errors).length) {
						showFieldErrors(form, body.errors, stepper);
					}
					showMessage(box, body.message || form.getAttribute("data-error"), false);
				})
				.catch(function () {
					showMessage(box, form.getAttribute("data-error"), false);
				})
				.then(function () {
					busy = false;
					button.disabled = false;
					button.removeAttribute("aria-busy");
					// Turnstile and reCAPTCHA v2 tokens work once, so get a fresh one for the next attempt.
					var widget = form.querySelector(".cf-turnstile");
					if (widget && window.turnstile && typeof window.turnstile.reset === "function") {
						window.turnstile.reset(widget);
					}
					var recaptcha = form.querySelector(".cozy-form__recaptcha[data-widget-id]");
					if (recaptcha && window.grecaptcha && typeof window.grecaptcha.reset === "function") {
						window.grecaptcha.reset(parseInt(recaptcha.getAttribute("data-widget-id"), 10));
					}
				});
		});
	}

	function boot() {
		document.querySelectorAll(".cozy-block-form").forEach(setupDialog);
		document.querySelectorAll(".cozy-block-form form.cozy-form__form").forEach(init);
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", boot);
	} else {
		boot();
	}
})();
