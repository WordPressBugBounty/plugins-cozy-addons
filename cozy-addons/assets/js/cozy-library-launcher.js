/**
 * Opens the Cozy Design Library when the editor is loaded with ?ca_library=templates|patterns.
 *
 * Used by the Dashboard "Import a starter template" and "Open patterns" links. It waits for
 * the library button that cozy-patterns.js adds to the editor toolbar, clicks it, then picks
 * the requested tab.
 */
(function () {
	"use strict";

	const target = new URLSearchParams(window.location.search).get("ca_library");
	const tabIndex = { patterns: 0, templates: 1 }[target];

	if (undefined === tabIndex) {
		return;
	}

	const TIMEOUT = 10000;
	const started = Date.now();

	function waitFor(selector, callback) {
		const found = document.querySelector(selector);

		if (found) {
			callback(found);
			return;
		}

		if (Date.now() - started > TIMEOUT) {
			return;
		}

		window.setTimeout(() => waitFor(selector, callback), 150);
	}

	function openLibrary() {
		waitFor(".cozy-addons__patterns-library .ca-patterns__modal-btn", (button) => {
			button.click();

			waitFor(".cozy-addons__patterns-modal .header__label", () => {
				const tabs = document.querySelectorAll(".cozy-addons__patterns-modal .header__label");

				if (tabs[tabIndex]) {
					tabs[tabIndex].click();
				}
			});
		});
	}

	if (window.wp && window.wp.domReady) {
		window.wp.domReady(openLibrary);
	} else {
		document.addEventListener("DOMContentLoaded", openLibrary);
	}
})();
