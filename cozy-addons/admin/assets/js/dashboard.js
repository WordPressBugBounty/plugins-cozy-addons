/**
 * Dashboard tab: persona picker, setup checklist and popup demo chips.
 */
(function () {
	"use strict";

	const root = document.querySelector(".cozy-blocks__dashboard .cbd");
	if (!root) {
		return;
	}

	const config = window.ajax_object || {};

	function save(data) {
		if (!config.ajax_url || !config.dashboardNonce) {
			return Promise.resolve(null);
		}

		const body = new URLSearchParams({
			action: "cozy_addons_dashboard_state",
			nonce: config.dashboardNonce,
			...data,
		});

		return fetch(config.ajax_url, {
			method: "POST",
			credentials: "same-origin",
			body,
		})
			.then((response) => response.json())
			.catch(() => null);
	}

	/* Persona picker */
	const personas = root.querySelectorAll(".cbd-persona");
	const tips = root.querySelectorAll("[data-persona-tip]");

	function selectPersona(button, persist) {
		const persona = button.dataset.persona;

		personas.forEach((item) => {
			const selected = item === button;
			item.classList.toggle("is-selected", selected);
			item.setAttribute("aria-checked", selected ? "true" : "false");
			item.tabIndex = selected ? 0 : -1;
		});

		tips.forEach((tip) => {
			tip.hidden = tip.dataset.personaTip !== persona;
		});

		root.dataset.persona = persona;

		if (persist) {
			save({ persona });
		}
	}

	personas.forEach((button, index) => {
		button.tabIndex = button.classList.contains("is-selected") ? 0 : -1;

		button.addEventListener("click", () => selectPersona(button, true));

		// Arrow keys move between options, as in a radio group.
		button.addEventListener("keydown", (event) => {
			const step = { ArrowRight: 1, ArrowDown: 1, ArrowLeft: -1, ArrowUp: -1 }[event.key];
			if (!step) {
				return;
			}
			event.preventDefault();
			const next = personas[(index + step + personas.length) % personas.length];
			next.focus();
			selectPersona(next, true);
		});
	});

	/* Setup checklist */
	const checklist = root.querySelector(".cbd-checklist");

	function refreshProgress() {
		if (!checklist) {
			return;
		}

		const total = Number(checklist.dataset.total) || 1;
		const done = checklist.querySelectorAll(".cbd-task.is-done").length;
		const ring = checklist.querySelector(".cbd-ring__value");

		checklist.querySelectorAll("[data-checklist-count]").forEach((node) => {
			node.textContent = String(done);
		});

		if (ring) {
			const length = Number(ring.getAttribute("stroke-dasharray")) || 0;
			ring.setAttribute("stroke-dashoffset", String(length * (1 - done / total)));
		}
	}

	if (checklist) {
		checklist.querySelectorAll(".cbd-task__status:not([disabled])").forEach((button) => {
			button.addEventListener("click", () => {
				const task = button.closest(".cbd-task");
				const done = !task.classList.contains("is-done");

				task.classList.toggle("is-done", done);
				button.setAttribute("aria-pressed", done ? "true" : "false");
				refreshProgress();

				save({ item: task.dataset.item, done: done ? "1" : "0" }).then((response) => {
					if (response && response.success === false) {
						// Roll back when the server refused the change.
						task.classList.toggle("is-done", !done);
						button.setAttribute("aria-pressed", !done ? "true" : "false");
						refreshProgress();
					}
				});
			});
		});
	}

	/* Popup Builder demo chips */
	const popupDemo = root.querySelector(".cbd-popup-demo");

	root.querySelectorAll(".cbd-chips--toggle .cbd-chip").forEach((chip, _, chips) => {
		chip.addEventListener("click", () => {
			chips.forEach((item) => {
				const active = item === chip;
				item.classList.toggle("is-active", active);
				item.setAttribute("aria-pressed", active ? "true" : "false");
			});

			if (popupDemo) {
				popupDemo.dataset.variant = chip.dataset.variant;
			}
		});
	});
})();
