(($) => {
	window["cozyBlockModalInit"] = (n) => {
		// ---------------------------------------------------------------
		// Frequency control
		//
		// loadOnRefresh    -> show on every page load, nothing is stored.
		// once_per_session -> show once per browser session (sessionStorage).
		// once_per_visitor -> show once, then again only after cooldownInterval
		//                     has passed (localStorage). cooldownInterval is a
		//                     number of days: "0.010" = 15 min, "0.25" = 6 hours,
		//                     "1" = 1 day, "30" = 1 month.
		// ---------------------------------------------------------------
		const STORAGE_KEY = "COZY_POPUP_BUILDER";
		const DAY_MS = 24 * 60 * 60 * 1000;
		const DEFAULT_COOLDOWN_DAYS = 1; // block.json default
		const MAX_COOLDOWN_DAYS = 30; // longest option in the editor

		// wp_localize_script casts top-level booleans to "1" / "".
		function toBool(value) {
			return (
				value === true || value === 1 || value === "1" || value === "true"
			);
		}

		function getStorage(type) {
			try {
				const storage = window[type];
				const testKey = "__cozy_test__";
				storage.setItem(testKey, "1");
				storage.removeItem(testKey);
				return storage;
			} catch (err) {
				return null; // blocked, private mode, etc.
			}
		}

		function readStore(storage) {
			try {
				const data = JSON.parse(storage.getItem(STORAGE_KEY));
				return data && typeof data === "object" && !Array.isArray(data)
					? data
					: {};
			} catch (err) {
				return {};
			}
		}

		function writeStore(storage, data) {
			try {
				storage.setItem(STORAGE_KEY, JSON.stringify(data));
			} catch (err) {
				// Storage full or blocked, nothing else to do.
			}
		}

		const Frequency = {
			mode: function () {
				// Frequency controls are a premium feature. Free popups load on
				// every refresh, matching the locked toggle shown in the editor.
				if (!toBool(attributes.isPremium) || toBool(attributes.loadOnRefresh)) {
					return "always";
				}

				return attributes.frequencyControl === "once_per_visitor"
					? "once_per_visitor"
					: "once_per_session";
			},

			cooldownMs: function () {
				const days = parseFloat(attributes.cooldownInterval);

				return (days > 0 ? days : DEFAULT_COOLDOWN_DAYS) * DAY_MS;
			},

			// Should this popup be shown to the current visitor right now?
			canShow: function () {
				const mode = this.mode();

				if (mode === "always") {
					return true;
				}

				if (mode === "once_per_session") {
					const session = getStorage("sessionStorage");

					// Without storage nothing can be tracked, so the popup shows.
					return !session || !readStore(session)[n];
				}

				const local = getStorage("localStorage");
				if (!local) {
					return true;
				}

				const lastShown = parseInt(readStore(local)[n]?.lastShown, 10);
				if (!lastShown) {
					return true;
				}

				const elapsedMs = Date.now() - lastShown;

				// A negative value means the visitor's clock moved backwards.
				return elapsedMs < 0 || elapsedMs >= this.cooldownMs();
			},

			// Record that the popup was shown.
			markShown: function () {
				const mode = this.mode();

				if (mode === "always") {
					return;
				}

				if (mode === "once_per_session") {
					const session = getStorage("sessionStorage");
					if (session) {
						const data = readStore(session);
						data[n] = { lastShown: Date.now().toString() };
						writeStore(session, data);
					}
					return;
				}

				const local = getStorage("localStorage");
				if (local) {
					const data = readStore(local);
					data[n] = { lastShown: Date.now().toString() };
					writeStore(local, data);
				}
			},

			// Drop records older than the longest cooldown. Records are NOT removed
			// just because the popup is missing from the current page: with page
			// visibility rules a popup only renders on some pages, and its cooldown
			// has to survive visits to the others.
			prune: function () {
				const local = getStorage("localStorage");
				if (!local) {
					return;
				}

				const data = readStore(local);
				const maxAgeMs = MAX_COOLDOWN_DAYS * DAY_MS;
				let changed = false;

				Object.keys(data).forEach((id) => {
					const lastShown = parseInt(data[id]?.lastShown, 10);
					if (!lastShown || Date.now() - lastShown > maxAgeMs) {
						delete data[id];
						changed = true;
					}
				});

				if (changed) {
					writeStore(local, data);
				}
			},
		};

		const PopupData = {
			// ---- Config (override via init) ----
			threshold: 20, // px from top of viewport (desktop)
			delay: 800, // ms after load before it can arm (both)
			inactivityMs: 30000, // ms of inactivity before mobile fallback fires
			scrollUpThreshold: 100, // px from top to count as "back near top" (mobile)
			onExit: function () {}, // callback

			// ---- Internal state ----
			triggered: false,
			armed: false,
			_lastScrollTop: 0,
			_inactivityTimer: null,

			init: function (options) {
				let self = this;

				Frequency.prune();

				$.extend(this, options);

				if (!Frequency.canShow()) {
					return; // respect frequency rules, don't bind anything
				}

				setTimeout(function () {
					self.armed = true;
				}, this.delay);

				if (this._isMobile()) {
					this._initMobile();
				} else {
					this._initDesktop();
				}
			},

			destroy: function () {
				$(document).off(".exitIntent");
				$(window).off(".exitIntent");
				clearTimeout(this._inactivityTimer);
			},

			reset: function () {
				this.triggered = false;
			},

			// ---- Desktop strategy: mouseleave via top of viewport ----
			_initDesktop: function () {
				var self = this;

				if (
					attributes.isPremium &&
					attributes.modalType === "default" &&
					attributes.modalEvent === "load" &&
					attributes?.trigger === "exit"
				) {
					$(document).on("mouseleave.exitIntent", function (e) {
						if (self.triggered || !self.armed) {
							return;
						}
						if (e.clientY <= self.threshold && e.relatedTarget === null) {
							self._fireExitIntent();
						}
					});
				} else if (
					attributes.modalType === "notifier" ||
					(attributes.modalType === "default" &&
						attributes.modalEvent === "load" &&
						attributes?.trigger === "load")
				) {
					self._fire();
				}
			},

			// ---- Mobile strategy: back-button + fast scroll-up + inactivity ----
			_initMobile: function () {
				var self = this;

				if (
					attributes.isPremium &&
					attributes.modalType === "default" &&
					attributes.modalEvent === "load" &&
					attributes?.trigger === "exit"
				) {
					// 1. Back-button interception
					history.pushState({ exitIntentGuard: true }, "");
					$(window).on("popstate.exitIntent", function () {
						if (!self.triggered && self.armed) {
							self._fireExitIntent();
							// Re-push so the actual back navigation only happens
							// the *next* time they press back.
							history.pushState({ exitIntentGuard: true }, "");
						} else {
							// let them actually leave on subsequent back-press
							history.back();
						}
					});

					// 2. Fast scroll toward top after having scrolled down
					$(window).on("scroll.exitIntent", function () {
						var st = $(window).scrollTop();
						if (
							!self.triggered &&
							self.armed &&
							st < self._lastScrollTop &&
							st < self.scrollUpThreshold &&
							self._lastScrollTop > self.scrollUpThreshold
						) {
							self._fireExitIntent();
						}
						self._lastScrollTop = st;
					});

					// 3. Inactivity fallback
					var resetTimer = function () {
						clearTimeout(self._inactivityTimer);
						self._inactivityTimer = setTimeout(function () {
							if (!self.triggered && self.armed) {
								self._fireExitIntent();
							}
						}, self.inactivityMs);
					};
					$(document).on(
						"touchstart.exitIntent scroll.exitIntent click.exitIntent",
						resetTimer,
					);
					resetTimer();
				} else if (
					attributes.modalType === "notifier" ||
					(attributes.modalType === "default" &&
						attributes.modalEvent === "load" &&
						attributes?.trigger === "load")
				) {
					self._fire();
				}
			},

			_fire: function () {
				this.triggered = true;
				Frequency.markShown();

				if (typeof this.onExit === "function") {
					this.onExit();
				}
			},

			// ---- Shared ----
			_fireExitIntent: function () {
				this.triggered = true;

				$(document).trigger("exitIntent:triggered");
				Frequency.markShown();

				if (typeof this.onExit === "function") {
					this.onExit();
				}
			},

			_isMobile: function () {
				return (
					/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
						navigator.userAgent,
					) ||
					("ontouchstart" in window && navigator.maxTouchPoints > 0)
				);
			},
		};

		const blockId = n.replace(/-/gi, "_");
		const attributes = window[`cozyModal_${blockId}`];

		const $body = $("body");
		const elWrapper = $(`.cozy-block-wrapper.block-cozyBlock_${blockId}`);
		const element = $(`#cozyBlock_${blockId}`);
		const overlay = elWrapper.find(".cozy-block-modal__overlay");

		const closeIcon = $(`.block-cozyBlock_${blockId} .close-icon-wrapper`);

		// ---------------------------------------------------------------
		// Analytics
		//
		// Popups from the Popup Builder report three events to the REST route
		// in core/cpt/ca-popup-analytics.php. Each is sent at most once per
		// page view:
		//   impression -> the popup became visible
		//   click      -> a link or button inside it was clicked
		//   dismiss    -> it was closed without a click
		// render.php only provides popupId / trackUrl for Popup Builder
		// popups, and turns trackEvents off for logged-in editors.
		// ---------------------------------------------------------------
		const sentEvents = {};

		function track(eventName) {
			if (
				!toBool(attributes.trackEvents) ||
				!attributes.popupId ||
				!attributes.trackUrl ||
				sentEvents[eventName]
			) {
				return;
			}

			sentEvents[eventName] = true;

			try {
				const body = new URLSearchParams({
					id: String(attributes.popupId),
					event: eventName,
				});

				// sendBeacon survives the page being closed or navigated away from.
				if (
					navigator.sendBeacon &&
					navigator.sendBeacon(attributes.trackUrl, body)
				) {
					return;
				}

				fetch(attributes.trackUrl, {
					method: "POST",
					body: body,
					keepalive: true,
				}).catch(function () {});
			} catch (err) {
				// Tracking must never break the popup.
			}
		}

		// A popup hidden on this device by its responsive settings is not seen.
		function trackImpression() {
			if (elWrapper.css("display") !== "none") {
				track("impression");
			}
		}

		function trackDismiss() {
			if (sentEvents.impression && !sentEvents.click) {
				track("dismiss");
			}
		}

		element.on(
			"click",
			"a, button, input[type='submit'], input[type='button'], [role='button']",
			function () {
				if (sentEvents.impression) {
					track("click");
				}
			},
		);

		if (attributes.modalType === "notifier") {
			// The notifier is rendered visible, so it is hidden when the frequency
			// rules say this visitor has already seen it.
			Frequency.prune();
			if (Frequency.canShow()) {
				Frequency.markShown();
				trackImpression();
			} else {
				element.hide();
			}

			if (attributes?.iconStyles?.enabled) {
				closeIcon.on("click", function () {
					element.fadeOut(300);
					trackDismiss();
				});
			}
		}

		if (attributes.modalType === "default") {
			let popupOpen = false;

			function closeModal(state = true) {
				if (state) {
					if (!attributes?.iconStyles?.enabled) {
						return;
					}
					$body.removeClass("overflow-hidden");
					element.fadeOut().addClass("display-none");
					overlay.addClass("display-none");

					// Escape also lands here while the popup is closed.
					if (popupOpen) {
						popupOpen = false;
						trackDismiss();
					}
				} else {
					const windowWidth = $(window).width();

					/* if (
						(!attributes.isPremium || !attributes.allowScroll) &&
						windowWidth > 1025 &&
						attributes?.responsiveVisibility?.desktop
					) {
						$body.addClass("overflow-hidden");
					} */

					const vis = attributes?.responsiveVisibility || {};

					// Map the current viewport to the matching visibility key
					const device =
						windowWidth > 1025
							? "desktop"
							: windowWidth > 767
							? "tablet"
							: "mobile";

					const isVisibleOnDevice = !!vis[device];
					const scrollLocked = !attributes.isPremium || !attributes.allowScroll;

					if (scrollLocked && isVisibleOnDevice) {
						$body.addClass("overflow-hidden");
					}

					element.fadeIn().removeClass("display-none");
					overlay.removeClass("display-none");

					popupOpen = true;
					trackImpression();
				}
			}

			if (attributes.modalEvent === "load") {
				function getScrollPercent() {
					const scrollTop = $(window).scrollTop();
					const docHeight = $(document).height() - $(window).height();
					return docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
				}

				if (!attributes?.trigger || attributes?.trigger === "load") {
					const delay = attributes.isPremium
						? attributes?.loadCondition?.delay
						: 0;
					// Load Trigger
					function handleLoadTrigger() {
						const scrolledPercentage = getScrollPercent();
						const threshold = attributes.isPremium
							? parseInt(attributes?.loadCondition?.scroll, 10)
							: 0;

						if (scrolledPercentage >= threshold) {
							window.removeEventListener("scroll", handleLoadTrigger);
							setTimeout(() => {
								// closeModal(false);
								PopupData.init({
									onExit: function () {
										// Show modal.
										closeModal(false);
									},
								});
							}, delay * 1000);
						}
					}

					window.addEventListener("scroll", handleLoadTrigger);
					handleLoadTrigger();
				} else if (attributes.isPremium && attributes?.trigger === "exit") {
					// Exit Intent Trigger
					PopupData.init({
						onExit: function () {
							// Show modal.
							closeModal(false);
						},
					});
				}
			} else if (attributes.modalEvent === "click") {
				const $modalBtn = elWrapper.find(".cozy-modal-button");

				if (
					!attributes?.clickButtonStyles?.variation ||
					attributes?.clickButtonStyles?.variation === "default"
				) {
					$modalBtn.click(function () {
						closeModal(false);
					});
				} else if (attributes?.clickButtonStyles?.variation === "float") {
					$modalBtn.click(function () {
						element.fadeToggle().toggleClass("display-none");
					});
				}
			}

			// Close the modal
			closeIcon.on("click", closeModal);
			overlay.on("click", closeModal);
			$(document).on("keyup", function (e) {
				if (e.key === "Escape" || e.keyCode === 27) {
					closeModal();
				}
			});
		}
	};
})(jQuery);
