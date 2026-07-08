(function ($) {
	window["cozyBlockScrollAnimationInit"] = (clientId) => {
		const { animate, onScroll, utils } = anime;

		const n = clientId.replace(/-/g, "_");
		const attributes = window[`cozyScrollAnimation_${n}`];

		const $container = $("#cozyBlock_" + n);

		const $items = $container.find(".cozy-block-scroll-item");

		if (
			attributes.layout === "default" &&
			attributes.scrollDirection === "vertical"
		) {
			function verticalAnimations() {
				if (
					attributes.verticalScroll.desktopOnly &&
					window.innerWidth <= 1024
				) {
					return;
				}

				switch (attributes.verticalScroll.animation) {
					case "opacity":
						$items.each(function (index) {
							if (index === $items.length - 1) return;

							animate(this, {
								opacity: 0,
								ease: "linear",
								autoplay: onScroll({
									target: this,
									enter: "top top",
									sync: 1,
								}),
							});
						});
						break;

					case "width-left":
						$items.each(function (index) {
							if (index === $items.length - 1) return;
							animate(this, {
								opacity: 0,
								scale: 0,
								x: "-100%",
								ease: "linear",
								autoplay: onScroll({
									target: this,
									enter: "top top",
									sync: 0.5,
								}),
							});
						});
						break;

					case "width-center":
						$items.each(function (index) {
							if (index === $items.length - 1) return;
							animate(this, {
								opacity: 0,
								scale: 0.8,
								ease: "linear",
								autoplay: onScroll({
									target: this,
									enter: "top top",
									sync: 0.5,
								}),
							});
						});
						break;

					case "width-right":
						$items.each(function (index) {
							if (index === $items.length - 1) return;
							animate(this, {
								opacity: 0,
								scale: 0,
								x: "100%",
								ease: "linear",
								autoplay: onScroll({
									target: this,
									enter: "top top",
									sync: 0.5,
								}),
							});
						});
						break;

					case "card-stack":
						$items.each(function (index) {
							if (index === 0 || index === $items.length - 1) return;

							$(this).css(
								"top",
								`calc(${index} * ${attributes.verticalScroll.stackOffset})`,
							);
						});
						break;

					default:
						break;
				}
			}
			$(window).on("resize", verticalAnimations);
			verticalAnimations();
		}

		if (
			attributes.layout === "default" &&
			attributes.scrollDirection === "horizontal"
		) {
			const swiper = new Swiper($container[0], {
				direction: "horizontal",
				slidesPerView: attributes.slider.slidesPerView,
				spaceBetween: attributes.slider.spaceBetween,
				virtualTranslate: true,
				loop: false,
				allowTouchMove: false, // stop Swiper from interpreting touch/drag as slide gestures
				simulateTouch: false, // stop Swiper from interpreting mouse drag either
				resistanceRatio: 0, // no edge resistance/rubber-banding to fight your transform
				speed: 0,
				freeMode: {
					enabled: true,
					sticky: true,
				},
				breakpoints: {
					100: {
						slidesPerView: 1,
					},
					767: {
						slidesPerView:
							attributes.slider.slidesPerView <= 2
								? attributes.slider.slidesPerView
								: 2,
					},
					1024: {
						slidesPerView:
							attributes.slider.slidesPerView <= 3
								? attributes.slider.slidesPerView
								: 3,
					},
					1180: {
						slidesPerView: attributes.slider.slidesPerView,
					},
				},
			});

			const swiperWrapper = $container.find(".swiper-wrapper")[0];
			const $outerWrapper = $(
				`.cozy-block-wrapper.block-wrapper-${clientId} .wp-block-cozy-block-scroll-animation`,
			);

			let scrollDistance = 0;
			let scrollObserver = null;
			let animation = null;
			let lastWidth = window.innerWidth;

			function getStableViewportHeight() {
				// visualViewport stays closer to the "toolbar hidden" max height on most mobile browsers,
				// preventing the pinned wrapper from being measured too short before the toolbar collapses
				return window.visualViewport
					? Math.max(window.visualViewport.height, window.innerHeight)
					: window.innerHeight;
			}

			function measure() {
				let stickyHeaderOffsetHeight = 0;
				if ($container.find(".cozy-block-sa-header-box").length > 0) {
					const stickyHeader = $container.find(".cozy-block-sa-header-box")[0];
					stickyHeaderOffsetHeight = stickyHeader.offsetHeight;
				}
				scrollDistance = Math.max(
					Math.round(swiperWrapper.scrollWidth - swiper.el.offsetWidth),
					0,
				);
				const outerHeight =
					getStableViewportHeight() + scrollDistance + stickyHeaderOffsetHeight;
				$outerWrapper.css("height", outerHeight + "px");
				return scrollDistance;
			}

			function setup() {
				measure();

				animation?.pause();
				scrollObserver?.revert?.();

				// ensure nothing but anime.js ever animates this element's transform
				swiperWrapper.style.transitionDuration = "0ms";
				swiperWrapper.style.transition = "none";

				scrollObserver = onScroll({
					target: $outerWrapper[0],
					enter: "top top",
					leave: "bottom bottom",
					sync: true,
					onEnter: () => {
						if (attributes.slider.alignMiddle)
							$container.css("transform", "translateY(50%)");
					},
					onLeave: () => {
						if (attributes.slider.alignMiddle) $container.css("transform", "");
					},
				});

				animation = animate(swiperWrapper, {
					x: -scrollDistance,
					ease: "linear",
					autoplay: scrollObserver,
				});
			}

			setup();

			// Only rebuild on genuine layout changes (orientation, real width resize) —
			// ignore mobile toolbar show/hide, which only changes innerHeight, not innerWidth
			let resizeTimer;
			function handleResize() {
				if (window.innerWidth !== lastWidth) {
					lastWidth = window.innerWidth;
					setup();
				}
			}
			$(window).on("resize orientationchange", function () {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(handleResize, 150);
			});

			// Catch layout shifts resize won't (images/webfonts loading late, Swiper reflow) —
			// debounced, and only rebuilds if scrollDistance actually changed meaningfully
			let roTimer;
			const ro = new ResizeObserver(() => {
				clearTimeout(roTimer);
				roTimer = setTimeout(() => {
					const prevDistance = scrollDistance;
					const newDistance = measure();
					if (Math.abs(newDistance - prevDistance) > 1) {
						setup();
					}
				}, 150);
			});
			ro.observe(swiperWrapper);
		}

		if (attributes.layout === "list") {
			let init = !attributes.listScroll.autoplay.enabled;
			let currentIndex = 0;
			let autoplayTimer, fadeTimer, rafId, startTime;
			const AUTOPLAY_DELAY = attributes.listScroll.autoplay.delay;
			const tabs = $container.find(".list-item__tab");

			function openPanel($panel) {
				if (!$panel.length) {
					return;
				}

				closeAllPanel($panel);

				const fullHeight = $panel[0].scrollHeight; // natural height before any collapse

				$panel.css("height", fullHeight + "px");

				$panel.one("transitionend", function () {
					// After transition, release the fixed height so content can reflow freely
					$panel.css("height", "auto");
					$panel.addClass("is-open");
				});
			}

			function closeAllPanel(except) {
				const $panels = $container.find(".list-item__tab .tab__description");
				if (!$panels.length) return;
				$panels.each(function () {
					const $panel = $(this);
					if (except && $panel.is(except)) return;
					$panel.off("transitionend"); // cancel any pending open-completion handler
					$panel.removeClass("is-open");
					$panel.css("height", $panel[0].scrollHeight + "px");
					$panel[0].offsetHeight; // force reflow
					$panel.css("height", "0");
				});
			}

			function activateTab(index) {
				// Cancel any in-progress fade before starting a new one
				clearTimeout(fadeTimer);

				const $current = $items.filter(":visible");

				tabs.removeClass("is-active");
				$(tabs[index]).addClass("is-active");
				currentIndex = index;

				if (attributes.listScroll.autoplay.progressBar) {
					startProgressBar(currentIndex);
				}

				if (init) {
					if (attributes.listScroll.collapse) {
						const subText = $(tabs[index]).find(".tab__description");
						openPanel(subText);
					}

					// Snap current item out immediately (no ghost)
					$current.css("opacity", "0.2");

					fadeTimer = setTimeout(() => {
						$($items[index]).css({ display: "block", opacity: "0.2" });
						$($items[index])[0].offsetHeight;
						$($items[index]).css("opacity", "1");
						$current.css("display", "none");
					}, 500);
				}

				init = true;
			}

			function startProgressBar(index) {
				// Reset all bars to 0 before starting the new one
				tabs.find(".progress").css("width", "0%"); // ← was "wdith"

				const $progress = $(tabs[index]).find(".progress");
				cancelAnimationFrame(rafId);
				startTime = performance.now();

				function tick(now) {
					const elapsed = now - startTime;
					const percentage = Math.min((elapsed / AUTOPLAY_DELAY) * 100, 100);
					$progress.css("width", percentage + "%");

					if (elapsed < AUTOPLAY_DELAY) {
						rafId = requestAnimationFrame(tick);
					}
				}

				rafId = requestAnimationFrame(tick);
			}

			function startAutoplay() {
				if (attributes.listScroll.autoplay.progressBar) {
					startProgressBar(currentIndex);
				}
				autoplayTimer = setInterval(function () {
					const nextIndex = (currentIndex + 1) % tabs.length; // wraps to 0
					activateTab(nextIndex);
				}, AUTOPLAY_DELAY);
			}

			function resetAutoplay() {
				clearInterval(autoplayTimer);
				cancelAnimationFrame(rafId); // cancel any previous loop

				startAutoplay();
			}

			switch (attributes.listScroll.variation) {
				case "click":
					tabs.each(function (index) {
						const $this = $(this);

						$this.click(function () {
							if (attributes.listScroll.autoplay.enabled) {
								activateTab(index);
								resetAutoplay();
							} else {
								activateTab(index);
							}
						});
					});
					if (attributes.listScroll.autoplay.enabled) {
						// Kick off autoplay
						activateTab(0);
						startAutoplay();
					}
					break;

				case "scroll":
					const $nav = $container.find(".list-item__tabs");
					const $links = $container.find(".list-item__tab");
					const $sections = $container.find(".cozy-block-scroll-item");
					let lastActiveId = null;
					let scrollTicking = false;

					function getNavHeight() {
						return $nav.outerHeight();
					}

					function setActiveTab(id) {
						$links
							.removeClass("is-active")
							.filter(`[id="${id}"]`)
							.addClass("is-active");
					}

					function onScroll() {
						const scrollTop = $(window).scrollTop();
						const navHeight = getNavHeight();
						const threshold = scrollTop + navHeight;
						let activeId = null;

						$sections.each(function () {
							if ($(this).offset().top <= threshold) {
								activeId = $(this).attr("id");
							}
						});

						if (!activeId || activeId === lastActiveId) return;

						lastActiveId = activeId;
						setActiveTab(activeId);
						const $activeTabItem = $links.filter(`[id="${activeId}"]`);
						const $panel = $activeTabItem.find(".tab__description");
						openPanel($panel);
					}

					function onScrollThrottled() {
						if (scrollTicking) return;
						scrollTicking = true;
						requestAnimationFrame(() => {
							onScroll();
							scrollTicking = false;
						});
					}

					// Bind scroll + trigger once on load
					$(window).on("scroll", onScrollThrottled);
					onScroll();
					break;

				default:
					break;
			}
		}
	};
})(jQuery);
