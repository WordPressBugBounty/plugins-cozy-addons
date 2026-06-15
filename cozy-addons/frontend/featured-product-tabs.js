(function ($) {
	window["cozyBlockFeaturedProductTabs"] = (e) => {
		const n = e.replace(/-/gi, "_");
		const attributes = window[`cozyBlock_${n}`];
		const blockID = `#cozyBlock_${n}`;
		const element = document.querySelector(blockID);

		let carousel = {};

		function initializeTabSlider() {
			if (attributes.display === "carousel") {
				const carouselAttr = {
					init: true,
					direction: attributes.sliderOptions.direction,
					loop: attributes.sliderOptions.loop,
					autoplay: { ...attributes.sliderOptions.autoplay },
					speed: attributes.sliderOptions.speed,
					centeredSlides: attributes.sliderOptions.centeredSlides,
					slidesPerView: attributes.sliderOptions.slidesPerView,
					spaceBetween: attributes.sliderOptions.spaceBetween,
					navigation: {
						nextEl: `${blockID} .swiper-button-next`,
						prevEl: `${blockID} .swiper-button-prev`,
					},
					pagination: {
						clickable: true,
						el: `${blockID} .swiper-pagination`,
					},
					breakpoints: {
						100: {
							slidesPerView: 1,
						},
						767: {
							slidesPerView:
								attributes.sliderOptions.slidesPerView <= 2
									? attributes.sliderOptions.slidesPerView
									: 2,
						},
						1024: {
							slidesPerView:
								attributes.sliderOptions.slidesPerView <= 3
									? attributes.sliderOptions.slidesPerView
									: 3,
						},
						1180: {
							slidesPerView: attributes.sliderOptions.slidesPerView,
						},
					},
				};

				if (attributes.sliderOptions.autoplay.status) {
					carouselAttr.autoplay = { ...attributes.sliderOptions.autoplay };
				} else {
					delete carouselAttr.autoplay;
				}

				const swiperContainer = element.querySelector(
					blockID + ".display-carousel .active-content",
				);

				carousel = new Swiper(swiperContainer, carouselAttr);
			}
		}

		function changeTab(index) {
			// Get all tabs and tab contents
			var tabs = $(blockID + " .cozy-block-featured-product-tabs__tab");
			var contents = $(blockID + " .cozy-block-featured-product-tabs__body");

			// Remove active class from all tabs and contents
			tabs.removeClass("active-tab");
			contents.removeClass("active-content");

			// Add active class to the selected tab and content
			tabs.eq(index).addClass("active-tab");
			contents.eq(index).addClass("active-content");

			if (
				attributes.display === "carousel" &&
				Object.keys(carousel).length > 0
			) {
				carousel.destroy();
			}
			initializeTabSlider();
		}

		// Bind click event to tabs
		$(blockID + " .cozy-block-featured-product-tabs__tab").click(function () {
			var tabIndex = $(this).data("index");
			changeTab(tabIndex);
		});

		initializeTabSlider();

		/* Add to cart button */
		if (attributes.productOptions.cartButton) {
			$(blockID + " div.post__cart-button").on("click", function () {
				const productId = $(this).attr("data-product-id");
				const loaderIcon = $(this).find(".loader-icon");
				const buttonLabel = $(this).find(".cart-button__label");

				$(buttonLabel).addClass("display-none");
				$(loaderIcon).removeClass("display-none");

				const $toast = $(
					`<div class="cozy-featured-product-tabs toast-message visibility-hidden" id="cozyBlock_${n}"></div>`,
				).appendTo("body");

				function showToast(message, type) {
					$toast
						.html(message)
						.removeClass("visibility-hidden is-success is-error")
						.addClass(type);
					setTimeout(() => {
						$toast.addClass("visibility-hidden").removeClass(type);
					}, 2500);
				}

				$.ajax({
					url: attributes.ajaxUrl,
					method: "POST",
					data: {
						action: "cozy_block_wishlist_add_to_cart",
						cartNonce: attributes.cartNonce,
						productId: productId,
					},
					success: function (response) {
						if (response.data.fragments) {
							$(document.body).trigger("added_to_cart", [
								response.data.fragments,
								response.data.cart_hash,
							]);
						}

						if (response.success) {
							showToast(
								`${response.data.product_name} has been added to cart`,
								"is-success",
							);
						} else {
							showToast("Sorry! Cannot purchase this product.", "is-error");
						}
					},
					error: function () {
						console.log("Unable to add to cart...");
						showToast("Sorry! Cannot purchase this product.", "is-error");
					},
					complete: function () {
						$(loaderIcon).addClass("display-none");
						$(buttonLabel).removeClass("display-none");
						setTimeout(() => $toast.remove(), 2500);
					},
				});
			});
			// <a> tags (non-simple / out-of-stock) navigate naturally — no JS needed
		}

		/* Icon Clicks */
		// Cart Icon
		if (attributes.productOptions.cart) {
			$(
				blockID +
					" div.cozy-block-featured-product-tabs__util-icon-wrapper.cart__icon-wrapper",
			).on("click", function () {
				const productId = $(this).attr("data-product-id");
				const cartIcon = $(this);

				const $toast = $(
					`<div class="cozy-featured-product-tabs toast-message visibility-hidden" id="cozyBlock_${n}"></div>`,
				).appendTo("body");

				function showToast(message, type) {
					$toast
						.html(message)
						.removeClass("visibility-hidden is-success is-error")
						.addClass(type);
					setTimeout(() => {
						$toast.addClass("visibility-hidden").removeClass(type);
					}, 2500);
				}

				$.ajax({
					url: attributes.ajaxUrl,
					method: "POST",
					data: {
						action: "cozy_block_wishlist_add_to_cart",
						cartNonce: attributes.cartNonce,
						productId: productId,
					},
					beforeSend: function () {
						cartIcon.addClass("is-loading-spinner");
					},
					success: function (response) {
						if (response.data.fragments) {
							$(document.body).trigger("added_to_cart", [
								response.data.fragments,
								response.data.cart_hash,
							]);
						}

						if (response.success) {
							showToast(
								`${response.data.product_name} has been added to cart`,
								"is-success",
							);
						} else {
							showToast("Sorry! Cannot purchase this product.", "is-error");
						}
					},
					error: function () {
						console.log("Unable to add to cart...");
						showToast("Sorry! Cannot purchase this product.", "is-error");
					},
					complete: function () {
						cartIcon.removeClass("is-loading-spinner");
						setTimeout(() => $toast.remove(), 2500);
					},
				});
			});
			// <a> tags (non-simple / out-of-stock) navigate naturally — no JS needed
		}

		// Wishlist Icon
		if (attributes.productOptions.wishlist) {
			function getLocalWishlist() {
				let wishlist =
					JSON.parse(localStorage.getItem("cozy_block_wishlist_data")) || [];
				return wishlist;
			}

			if (!attributes.isUserLoggedIn) {
				const wishlistData = getLocalWishlist();
				wishlistData.forEach((productID) => {
					if (wishlistData.includes(productID)) {
						$(
							blockID +
								' .wishlist__icon-wrapper[data-product-id="' +
								productID +
								'"]',
						).addClass("is-active");
					} else {
						$(
							blockID +
								' .wishlist__icon-wrapper[data-product-id="' +
								productID +
								'"]',
						).removeClass("is-active");
					}
				});
			}

			$(
				blockID +
					" .cozy-block-featured-product-tabs__util-icon-wrapper.wishlist__icon-wrapper",
			).on("click", function () {
				const productId = parseInt($(this).attr("data-product-id"));
				const productName = $(this).attr("data-product-name");
				const wishlistIcon = $(
					".cozy-block-wrapper .wishlist__icon-wrapper[data-product-id='" +
						productId +
						"']",
				);
				const rawData = $(".cozy-block-wishlist.variation-sidebar").attr(
					"wishlist-user-data",
				);
				const wishlistUserData = rawData ? JSON.parse(rawData) : {};
				const $toast = $(
					`<div class="cozy-featured-product-tabs toast-message visibility-hidden" id="cozyBlock_${n}"></div>`,
				).appendTo("body");

				function showToast(message, type) {
					$toast
						.html(message)
						.removeClass("visibility-hidden is-success is-error")
						.addClass(type);
					setTimeout(() => {
						$toast.addClass("visibility-hidden").removeClass(type);
					}, 2500);
				}

				if (!attributes.isUserLoggedIn) {
					wishlistIcon.addClass("is-loading-spinner");

					function updateLocalWishlist(productId) {
						let wishlist =
							JSON.parse(localStorage.getItem("cozy_block_wishlist_data")) ||
							[];
						if (wishlist.includes(productId)) {
							wishlist = wishlist.filter(
								(id) => parseInt(id) !== parseInt(productId),
							);
						} else {
							wishlist.push(productId);
						}
						localStorage.setItem(
							"cozy_block_wishlist_data",
							JSON.stringify(wishlist),
						);
					}

					updateLocalWishlist(productId);

					const wishlistData = getLocalWishlist();
					const isAdded = wishlistData.includes(productId);

					if (isAdded) {
						$(
							'.wishlist__icon-wrapper[data-product-id="' + productId + '"]',
						).addClass("is-active");
					} else {
						$(
							'.wishlist__icon-wrapper[data-product-id="' + productId + '"]',
						).removeClass("is-active");
					}

					const wishlistCount = document.querySelector(
						".cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count",
					);
					if (wishlistCount) {
						wishlistCount.innerHTML = wishlistData.length;
					}

					wishlistIcon.removeClass("is-loading-spinner");

					showToast(
						`${productName} has been ${
							isAdded ? "added to" : "removed from"
						} the wishlist.`,
						"is-success",
					);

					setTimeout(() => $toast.remove(), 2500);
				} else {
					function removeFromWishlist(el) {
						if (attributes.isUserLoggedIn) {
							$.ajax({
								url: attributes.ajaxUrl,
								method: "POST",
								data: {
									action: "cozy_block_wishlist_update_user_wishlist",
									wishlistNonce: attributes.wishlistNonce,
									productId: productId,
									userId: attributes.userID,
								},
								beforeSend: function () {
									wishlistIcon.addClass("is-loading-spinner");
								},
								success: function (response) {
									if (
										response.data.user_wishlist.includes(parseInt(productId))
									) {
										$(
											'.wishlist__icon-wrapper[data-product-id="' +
												productId +
												'"]',
										).addClass("is-active");
									} else {
										$(
											'.wishlist__icon-wrapper[data-product-id="' +
												productId +
												'"]',
										).removeClass("is-active");
									}

									$(
										".cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count",
									).html(response.data.user_wishlist.length);

									if (response.data.user_wishlist.length <= 0) {
										$(".cozy-block-wishlist__sidebar-body").html("");
									}

									updateSidebarRender(response.data.user_wishlist);
								},
								complete: function () {
									wishlistIcon.removeClass("is-loading-spinner");
								},
								error: function () {
									console.log("Unable to update wishlist...");
								},
							});
						}
					}

					function updateSidebarRender(wishlistData) {
						if (wishlistData.length > 0) {
							$.ajax({
								url: attributes.ajaxUrl,
								method: "POST",
								data: {
									action: "cozy_block_wishlist_render_data_sidebar",
									sidebarNonce: attributes.sidebarNonce,
									wishlistData: JSON.stringify(wishlistData),
									beforeLabel: wishlistUserData.beforeLabel,
									afterLabel: wishlistUserData.afterLabel,
									alignment: wishlistUserData.alignment,
								},
								success: function (response) {
									if (response.data) {
										$(".cozy-block-wishlist__sidebar-body").html(
											response.data.render,
										);
									}
								},
								error: function () {
									console.log("Unable to load data...");
								},
							});
						}
					}

					$.ajax({
						url: attributes.ajaxUrl,
						method: "POST",
						data: {
							action: "cozy_block_wishlist_update_user_wishlist",
							wishlistNonce: attributes.wishlistNonce,
							productId: productId,
							userId: attributes.userID,
						},
						beforeSend: function () {
							wishlistIcon.addClass("is-loading-spinner");
						},
						success: function (response) {
							const isAdded = response.data.user_wishlist.includes(productId);

							if (isAdded) {
								$(
									'.wishlist__icon-wrapper[data-product-id="' +
										productId +
										'"]',
								).addClass("is-active");
							} else {
								$(
									'.wishlist__icon-wrapper[data-product-id="' +
										productId +
										'"]',
								).removeClass("is-active");
							}

							$(
								".cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count",
							).html(response.data.user_wishlist.length);

							updateSidebarRender(response.data.user_wishlist);

							showToast(
								`${productName} has been ${
									isAdded ? "added to" : "removed from"
								} the wishlist.`,
								"is-success",
							);
						},
						complete: function () {
							wishlistIcon.removeClass("is-loading-spinner");
							setTimeout(() => $toast.remove(), 2500);
						},
						error: function () {
							console.log("Unable to update wishlist...");
						},
					});
				}
			});
		}

		// Quick View
		if (attributes.productOptions.quickView) {
			$(blockID + " .quick-view__icon-wrapper").on("click", function () {
				const productId = parseInt($(this).attr("data-product-id"));

				$(blockID + " .spinner").removeClass("visibility-hidden");

				if (attributes.display === "carousel") {
					carousel.autoplay.stop();
				}

				let lightboxWrapper = $(blockID + " .quick-view__lightbox-wrapper");
				let body = $("body");
				lightboxWrapper.removeClass("visibility-hidden");
				body.addClass("overflow-hidden");

				$(blockID + " .quick-view__lightbox-body-wrapper").on(
					"click",
					function (event) {
						if (event.target === this) {
							$(blockID + " .quick-view__lightbox-wrapper").addClass(
								"visibility-hidden",
							);
							$("body").removeClass("overflow-hidden");
							$(blockID + " .quick-view__lightbox-body").html("");
						}
					},
				);

				$.ajax({
					url: attributes.ajaxUrl,
					method: "POST",
					data: {
						action: "cozy_block_quick_view_lightbox_render",
						quickViewNonce: attributes.quickViewNonce,
						productId: productId,
						attributes: JSON.stringify(attributes),
					},
					success: function (response) {
						$(blockID + " .spinner").addClass("visibility-hidden");
						$(blockID + " .quick-view__lightbox-body").html(
							response.data.render,
						);

						// Close lightbox
						$(blockID + " .lightbox__close-button").on("click", function () {
							lightboxWrapper.addClass("visibility-hidden");
							body.removeClass("overflow-hidden");
							$(blockID + " .quick-view__lightbox-body").html("");

							if (attributes.display === "carousel") {
								carousel.autoplay.start();
							}
						});

						// Increase quantity
						$(blockID + " .quantity__increase").on("click", function () {
							let quantity = Math.abs(
								parseInt($(blockID + " .quick-view__quantity-input").val()),
							);
							$(blockID + " .quick-view__quantity-input").val(quantity + 1);
							if (quantity + 1 > 1) {
								$(blockID + " .quantity__decrease").removeClass("opacity-50");
							}
						});

						// Decrease quantity
						$(blockID + " .quantity__decrease").on("click", function () {
							let quantity = Math.abs(
								parseInt($(blockID + " .quick-view__quantity-input").val()),
							);
							const newQuantity = quantity - 1;
							$(blockID + " .quick-view__quantity-input").val(
								newQuantity > 0 ? newQuantity : 1,
							);
							if (newQuantity <= 1) {
								$(this).addClass("opacity-50");
							} else {
								$(this).removeClass("opacity-50");
							}
						});

						// Add to cart
						$(blockID + " .quick-view__cart-button.product_type_simple").on(
							"click",
							function () {
								const loaderIcon = $(this).find(".loader-icon");
								const buttonLabel = $(this).find(".cart-button__label");

								$(loaderIcon).removeClass("display-none");
								$(buttonLabel).addClass("display-none");

								const $toast = $(
									`<div class="cozy-featured-product-tabs toast-message visibility-hidden" id="cozyBlock_${n}"></div>`,
								).appendTo("body");

								function showToast(message, type) {
									$toast
										.html(message)
										.removeClass("visibility-hidden is-success is-error")
										.addClass(type);
									setTimeout(() => {
										$toast.addClass("visibility-hidden").removeClass(type);
									}, 2500);
								}

								$.ajax({
									url: attributes.ajaxUrl,
									method: "POST",
									data: {
										action: "cozy_block_wishlist_add_to_cart",
										cartNonce: attributes.cartNonce,
										productId: productId,
										productQuantity: parseInt(
											$(blockID + " .quick-view__quantity-input").val(),
										),
									},
									success: function (response) {
										if (response.data.fragments) {
											$(document.body).trigger("added_to_cart", [
												response.data.fragments,
												response.data.cart_hash,
											]);
										}

										if (response.success) {
											showToast(
												`${response.data.product_name} has been added to cart`,
												"is-success",
											);
										} else {
											showToast(
												"Sorry! Cannot purchase this product.",
												"is-error",
											);
										}
									},
									error: function () {
										console.log("Unable to add to cart...");
										showToast(
											"Sorry! Cannot purchase this product.",
											"is-error",
										);
									},
									complete: function () {
										$(loaderIcon).addClass("display-none");
										$(buttonLabel).removeClass("display-none");
										setTimeout(() => $toast.remove(), 2500);
									},
								});
							},
						);

						const swiperContainer = document.querySelector(
							blockID + " .quick-view__rating.swiper__container",
						);
						const bullets = document.querySelector(
							blockID + " .quick-view__lightbox-body .swiper-pagination",
						);

						const ratingSlider = new Swiper(swiperContainer, {
							init: true,
							slidesPerView: 1,
							loop: true,
							autoplay: {
								delay: 1500,
								pauseOnMouseEnter: true,
							},
							speed: 2000,
							pagination: {
								el: bullets,
								clickable: true,
							},
						});
					},
					error: function () {
						console.log("Unable to load quick view data...");
					},
				});
			});
		}
	};
})(jQuery);
