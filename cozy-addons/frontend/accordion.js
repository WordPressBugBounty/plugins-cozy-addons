(function ($) {
	window["cozyBlockAccordionInit"] = (e) => {
		const n = e.replace(/-/gi, "_");
		const attributes = window[`cozyAccordion_${n}`];
		const accordionClass = `#cozyBlock_${n}`;
		const cozyAccordion = document.querySelector(accordionClass);

		const cozyAccordionItem = cozyAccordion.querySelectorAll(
			".cozy-block-accordion-item",
		);

		cozyAccordionItem.forEach((item) => {
			const title = item.querySelector(".cozy-accordion-title");
			const content = item.querySelector(".cozy-accordion-content");
			const icon = item.querySelector(".accordion-icon-wrapper svg");
			const iconPath = item.querySelector(".accordion-icon-wrapper svg path");

			title.addEventListener("click", () => {
				const isActive = title.classList.contains("active");

				// Close all accordions + reset icons
				cozyAccordionItem.forEach((el) => {
					el.querySelector(".cozy-accordion-title")?.classList.remove("active");
					el.querySelector(".cozy-accordion-content")?.classList.remove(
						"display-block",
					);

					const svg = el.querySelector(".accordion-icon-wrapper svg");
					const path = el.querySelector(".accordion-icon-wrapper svg path");

					if (svg && path) {
						svg.setAttribute(
							"viewBox",
							`${attributes.icon.viewBox.vx} ${attributes.icon.viewBox.vy} ${attributes.icon.viewBox.vw} ${attributes.icon.viewBox.vh}`,
						);
						path.setAttribute("d", attributes.icon.path);
					}
				});

				// Open clicked one if it wasn't active
				if (!isActive) {
					title.classList.add("active");
					content?.classList.add("display-block");

					icon.setAttribute(
						"viewBox",
						`${attributes.icon.activeViewBox.vx} ${attributes.icon.activeViewBox.vy} ${attributes.icon.activeViewBox.vw} ${attributes.icon.activeViewBox.vh}`,
					);
					iconPath.setAttribute("d", attributes.icon.activePath);
				}
			});
		});

		if (attributes.isPremium && attributes?.source === "cpt") {
			const $accordion = $(accordionClass);
			const $tab = $accordion.find(".category-tab-item");
			const $accordionHolder = $accordion.find(".cozy-accordion-wrapper");
			const $accordionItems = $accordion.find(".cozy-block-accordion-item");
			const $toast = $accordion.find(".accordion-notice");
			const $search = $accordion.find("#accordion-search");

			$tab.each(function () {
				const $this = $(this);
				const catID = $this.attr("data-cat-id");

				$this.click(function () {
					$tab.removeClass("is-active");
					$this.addClass("is-active");

					$accordionItems.removeClass("is-active");
					$accordion.find(".cozy-accordion-title").removeClass("active");
					$accordion
						.find(".cozy-accordion-content")
						.removeClass("display-block");

					$accordionItems.each(function () {
						const $item = $(this);
						const catIDs = JSON.parse($item.attr("data-cat-ids"));

						if (catID && catIDs.includes(parseInt(catID))) {
							$item.addClass("is-active");
							// $item.fadeIn();
						} else if (!catID && attributes?.category?.allTab) {
							$accordionItems.addClass("is-active");
						}
					});

					const val = $search.val();
					const query = String(val).toLowerCase().trim();

					handleSearchQuery(query);
				});
			});

			$search.on(
				"change input",
				debounce(function () {
					const $this = $(this);
					const val = $this.val();
					const query = String(val).toLowerCase().trim();

					handleSearchQuery(query);
				}, 250),
			);

			function handleSearchQuery(query = "") {
				if (query.length >= 3) {
					let matchCount = 0;

					$accordion
						.find(".cozy-block-accordion-item.is-active")
						.each(function () {
							const $item = $(this);
							const title = String(
								$item.attr("data-post-title") || "",
							).toLowerCase();
							const content = String(
								$item.attr("data-post-content") || "",
							).toLowerCase();

							const isMatch = title.includes(query) || content.includes(query);
							console.log(isMatch);

							$item.toggle(isMatch);

							if (isMatch) matchCount++;
						});

					if (matchCount <= 0) {
						$toast.addClass("is-active");
						$accordionHolder.hide();
					} else {
						$toast.removeClass("is-active");
						$accordionHolder.show();
					}
				} else {
					// reset - show all items when search is cleared/too short
					$accordion.find(".cozy-block-accordion-item.is-active").show();
					$toast.removeClass("is-active");
					$accordionHolder.show();
				}
			}
		}

		function debounce(func, delay) {
			let timeoutId;

			return function debounced(...args) {
				const context = this;

				clearTimeout(timeoutId);
				timeoutId = setTimeout(() => {
					func.apply(context, args);
				}, delay);
			};
		}
	};
})(jQuery);
