(($) => {
	window["cozyBlockBrandShowcase"] = (clientId) => {
		const blockId = "cozyBlock_" + clientId.replace(/-/gi, "_");

		const $wrapper = $(`.cozy-block-wrapper.block-${blockId}`);
		const $block = $wrapper.find(".cozy-block-brand-showcase");
		const attributes = window[blockId];

		if (attributes.display === "carousel") {
			let carouselAttr = {
				init: true,
				loop: attributes.carousel.loop,
				speed: attributes.carousel.speed,
				slidesPerView: attributes.carousel?.desktop?.slidesPerView,
				spaceBetween: attributes.carousel?.desktop?.spaceBetween,
				navigation: {
					nextEl: `.cozy-block-wrapper.block-${blockId} .swiper-button-next`,
					prevEl: `.cozy-block-wrapper.block-${blockId} .swiper-button-prev`,
				},
				pagination: {
					clickable: true,
					el: `.cozy-block-wrapper.block-${blockId} .swiper-pagination`,
				},
				breakpoints: {
					100: {
						slidesPerView: attributes.carousel?.mobile?.slidesPerView,
						spaceBetween: attributes.carousel?.mobile?.spaceBetween
							? attributes.carousel?.mobile?.spaceBetween
							: attributes?.carousel?.desktop?.spaceBetween,
					},
					767: {
						slidesPerView: attributes.carousel?.tablet?.slidesPerView,
						spaceBetween: attributes.carousel?.tablet?.spaceBetween
							? attributes.carousel?.tablet?.spaceBetween
							: attributes.carousel?.desktop?.spaceBetween,
					},
					1180: {
						slidesPerView: attributes.carousel?.desktop?.slidesPerView,
						spaceBetween: attributes.carousel?.desktop?.spaceBetween,
					},
				},
			};
			console.log(carouselAttr);

			if (attributes.isPremium) {
				carouselAttr = {
					...carouselAttr,
					centeredSlides: attributes.carousel.centeredSlides,
				};
			}
			if (attributes.carousel.autoplay.status) {
				carouselAttr = {
					...carouselAttr,
					autoplay: attributes.carousel.autoplay,
				};

				if (attributes.isPremium && attributes.carousel.reverseDirection) {
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

			new Swiper($block.get(0), carouselAttr);
		}
	};
})(jQuery);
