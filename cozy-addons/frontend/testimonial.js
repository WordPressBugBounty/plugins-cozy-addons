(function ($) {
	window["cozyBlockTestimonialInit"] = (e) => {
		const n = e.replace(/-/gi, "_");
		const attributes = window[`cozyTestimonial_${n}`];
		const blockId = `#cozyBlock_${n}`;

		if (attributes.layout === "carousel") {
			const carouselAttr = {
				init: true,
				loop: attributes.carouselOptions.sliderOptions.loop,
				speed: attributes.carouselOptions.sliderOptions.speed,
				centeredSlides: attributes.carouselOptions.sliderOptions.centeredSlides,
				slidesPerView: attributes.carouselOptions.sliderOptions.slidesPerView,
				spaceBetween: attributes.carouselOptions.sliderOptions.spaceBetween,
				navigation: {
					nextEl: `.block-cozyBlock_${n} .swiper-button-next.cozy-block-button-next`,
					prevEl: `.block-cozyBlock_${n} .swiper-button-prev.cozy-block-button-prev`,
				},
				pagination: {
					clickable: true,
					el: `.block-cozyBlock_${n} .swiper-pagination`,
				},
				breakpoints: {
					100: {
						slidesPerView: 1,
					},
					767: {
						slidesPerView:
							attributes.carouselOptions.sliderOptions.slidesPerView <= 2
								? attributes.carouselOptions.sliderOptions.slidesPerView
								: 2,
					},
					1024: {
						slidesPerView:
							attributes.carouselOptions.sliderOptions.slidesPerView <= 3
								? attributes.carouselOptions.sliderOptions.slidesPerView
								: 3,
					},
					1180: {
						slidesPerView:
							attributes.carouselOptions.sliderOptions.slidesPerView,
					},
				},
			};

			if (attributes.carouselOptions.sliderOptions.autoplay.enabled) {
				carouselAttr.autoplay = {
					...attributes.carouselOptions.sliderOptions.autoplay,
				};

				if (
					attributes.isPremium &&
					attributes.carouselOptions.sliderOptions?.reverseDirection
				) {
					carouselAttr.autoplay = {
						...carouselAttr.autoplay,
						reverseDirection: true,
					};
				} else {
					delete carouselAttr.autoplay.reverseDirection;
				}
			} else {
				delete carouselAttr.autoplay;
			}

			new Swiper(blockId + ".swiper-container", carouselAttr);
		}
	};
})(jQuery);
