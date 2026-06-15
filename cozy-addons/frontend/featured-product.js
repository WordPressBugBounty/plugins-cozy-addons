(function ($) {
	window["cozyBlockFeaturedProduct"] = (e) => {
		const n = e.replace(/-/gi, "_");
		const attributes = window[`cozyBlock_${n}`];
		const blockID = `#cozyBlock_${n}`;
		let carousel = {};

		if (attributes.display === "carousel") {
			const carouselAttr = {
				init: true,
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
				effect: attributes.sliderOptions.effect,
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

			carousel = new Swiper(blockID + " .swiper-container", carouselAttr);
		}

		// ─── Shared helper: update count badge on ALL sidebar wishlist blocks ───
		function updateWishlistCount(count) {
			$(".cozy-block-wishlist.variation-sidebar").each(function () {
				const $countEl = $(this).find(".cozy-block-wishlist__count");
				if (count > 0) {
					if ($countEl.length) {
						$countEl.html(count);
					} else {
						$(this)
							.find(".sidebar__icon-wrapper")
							.append(
								`<span class="cozy-block-wishlist__count">${count}</span>`,
							);
					}
				} else {
					$countEl.remove();
				}
			});
		}

		/* Add to cart button */
		if (attributes.enableOptions.cartButton) {
			$(blockID + " .post__cart-button.product_type_simple").on(
				"click",
				function () {
					const productId = $(this).attr("data-product-id");
					const itemContainer = $(
						`.cozy-block-featured-product__post-item[data-product-id="${productId}"]`,
					);
					const loaderIcon = $(this).find(".loader-icon");
					const buttonLabel = $(this).find(".cart-button__label");

					$(buttonLabel).addClass("display-none");
					$(loaderIcon).removeClass("display-none");

					const $toast = $(
						`<div class="cozy-featured-product toast-message visibility-hidden" id="cozyBlock_${n}"></div>`,
					);

					$.ajax({
						url: attributes.ajaxUrl,
						method: "POST",
						data: {
							action: "cozy_block_wishlist_add_to_cart",
							cartNonce: attributes.cartNonce,
							productId: productId,
						},
						beforeSend: function () {
							$(".cozy-featured-product.toast-message").remove();
							$toast.appendTo("body");
						},
						success: function (response) {
							if (response.data.fragments) {
								$(document.body).trigger("added_to_cart", [
									response.data.fragments,
									response.data.cart_hash,
								]);
							}

							$(loaderIcon).addClass("display-none");
							$(buttonLabel).removeClass("display-none");

							if (response.success) {
								$toast.removeClass("visibility-hidden");
								$toast.text(
									`${response.data.product_name} has been added to cart`,
								);
							} else {
								$(itemContainer).find("#tick-icon").css("display", "none");
								$(itemContainer)
									.find(".post__toast")
									.removeClass("visibility-hidden");
								$(itemContainer).find(".post__toast").addClass("is-error");
								$(itemContainer)
									.find("#cross-icon")
									.css("display", "inline-flex");
								$(itemContainer)
									.find(".toast__message")
									.html("Sorry! Cannot purchase this product.");
							}
						},
						complete: function () {
							setTimeout(() => {
								$toast.addClass("visibility-hidden");
							}, 2500);
							setTimeout(() => {
								$toast.remove();
							}, 2800);
						},
						error: function (error) {
							console.log("Unable to add to cart...");
						},
					});
				},
			);
		}

		/* Icon Clicks */
		// Cart Icon
		if (attributes.enableOptions.cart) {
			$(
				blockID +
					" .cozy-block-featured-product__icon-wrapper.cart__icon-wrapper.product_type_simple",
			).on("click", function () {
				const productId = $(this).attr("data-product-id");
				const itemContainer = $(
					`.cozy-block-featured-product__post-item[data-product-id="${productId}"]`,
				);
				const cartIcon = `.cozy-block-featured-product__icon-wrapper.cart__icon-wrapper[data-product-id="${productId}"]`;
				const $toast = $(
					`<div class="cozy-featured-product toast-message visibility-hidden" id="cozyBlock_${n}"></div>`,
				);
				$.ajax({
					url: attributes.ajaxUrl,
					method: "POST",
					data: {
						action: "cozy_block_wishlist_add_to_cart",
						cartNonce: attributes.cartNonce,
						productId: productId,
					},
					beforeSend: function () {
						$(cartIcon).addClass("is-loading-spinner");
						$toast.appendTo("body");
					},
					success: function (response) {
						if (response.data.fragments) {
							$(document.body).trigger("added_to_cart", [
								response.data.fragments,
								response.data.cart_hash,
							]);
						}

						if (response.success) {
							$toast.removeClass("visibility-hidden");
							$toast.addClass("is-success");
							$toast.html(
								`${response.data.product_name} has been added to cart`,
							);
						} else {
							$(itemContainer).find("#tick-icon").css("display", "none");
							$(itemContainer)
								.find(".post__toast")
								.removeClass("visibility-hidden");
							$(itemContainer).find(".post__toast").addClass("is-error");
							$(itemContainer)
								.find("#cross-icon")
								.css("display", "inline-flex");
							$(itemContainer)
								.find(".toast__message")
								.html("Sorry! Cannot purchase this product.");
						}
					},
					complete: function () {
						$(cartIcon).removeClass("is-loading-spinner");
						setTimeout(() => {
							$toast.addClass("visibility-hidden");
						}, 2500);
						setTimeout(() => {
							$toast.remove();
						}, 2800);
					},
					error: function (error) {
						console.log("Unable to add to cart...");
					},
				});
			});
		}

		// Wishlist Icon
		if (attributes.enableOptions.wishlist) {
			function getLocalWishlist() {
				let wishlist =
					JSON.parse(localStorage.getItem("cozy_block_wishlist_data")) || [];
				return wishlist;
			}

			const rawData = $(".cozy-block-wishlist.variation-sidebar").attr(
				"wishlist-user-data",
			);
			const wishlistUserData = rawData ? JSON.parse(rawData) : {};

			if (!attributes.isUserLoggedIn) {
				const wishlistData = getLocalWishlist().map(Number);
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

			function updateSidebarRender(wishlistData) {
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
					error: function (error) {
						console.log("Unable to load data...");
					},
				});
			}

			function removeFromWishlist(el) {
				if (attributes.isUserLoggedIn) {
					const removeProductId = parseInt($(el).attr("data-product-id"));
					const wishlistIcon = $(
						`.wishlist__icon-wrapper[data-product-id="${removeProductId}"]`,
					);
					$.ajax({
						url: attributes.ajaxUrl,
						method: "POST",
						data: {
							action: "cozy_block_wishlist_update_user_wishlist",
							wishlistNonce: attributes.wishlistNonce,
							productId: removeProductId,
							userId: attributes.userID,
						},
						beforeSend: function () {
							$(el).addClass("is-loading-spinner");
							wishlistIcon.addClass("is-loading-spinner");
						},
						success: function (response) {
							if (response.data.user_wishlist.includes(removeProductId)) {
								$(
									'.wishlist__icon-wrapper[data-product-id="' +
										removeProductId +
										'"]',
								).addClass("is-active");
							} else {
								$(
									'.wishlist__icon-wrapper[data-product-id="' +
										removeProductId +
										'"]',
								).removeClass("is-active");
							}

							updateWishlistCount(response.data.user_wishlist.length);
							updateSidebarRender(response.data.user_wishlist);
						},
						complete: function () {
							$(el).removeClass("is-loading-spinner");
							wishlistIcon.removeClass("is-loading-spinner");
						},
						error: function (error) {
							console.log("Unable to update wishlist...");
						},
					});
				} else {
					// Guest: remove from localStorage and re-render
					const removeProductId = parseInt($(el).attr("data-product-id"));
					let wishlist = getLocalWishlist().map(Number);
					wishlist = wishlist.filter((id) => id !== removeProductId);
					localStorage.setItem(
						"cozy_block_wishlist_data",
						JSON.stringify(wishlist),
					);

					$(
						'.wishlist__icon-wrapper[data-product-id="' +
							removeProductId +
							'"]',
					).removeClass("is-active");
					updateWishlistCount(wishlist.length);
					updateSidebarRender(wishlist);
				}
			}

			$(
				blockID +
					" .cozy-block-featured-product__icon-wrapper.wishlist__icon-wrapper",
			).on("click", function () {
				const productId = parseInt($(this).attr("data-product-id"));
				const itemContainer = $(
					`.cozy-block-featured-product__post-item[data-product-id="${productId}"]`,
				);
				const wishlistIcon = $(
					`.wishlist__icon-wrapper[data-product-id="${productId}"]`,
				);

				const productName = $(this).attr("data-product-name");

				const $toast = $(
					`<div class="cozy-featured-product toast-message visibility-hidden" id="cozyBlock_${n}"></div>`,
				);

				function showToast(message) {
					$(".cozy-featured-product.toast-message").remove();
					$toast.appendTo("body");
					$toast.text(message);
					$toast.removeClass("visibility-hidden").addClass("is-success");
					setTimeout(() => {
						$toast.addClass("visibility-hidden");
					}, 2500);
					setTimeout(() => {
						$toast.remove();
					}, 2800);
				}

				if (!attributes.isUserLoggedIn) {
					wishlistIcon.addClass("is-loading-spinner");
					function updateLocalWishlist(productId) {
						let wishlist =
							JSON.parse(localStorage.getItem("cozy_block_wishlist_data")) ||
							[];
						if (wishlist.map(Number).includes(productId)) {
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
					const wishlistData = getLocalWishlist().map(Number);
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

					updateWishlistCount(wishlistData.length);

					showToast(
						`${productName} has been ${
							isAdded ? "added to" : "removed from"
						} the wishlist.`,
					);
					setTimeout(() => {
						wishlistIcon.removeClass("is-loading-spinner");
					}, 2000);
				} else {
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
							$(wishlistIcon).addClass("is-loading-spinner");
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

							updateWishlistCount(response.data.user_wishlist.length);
							updateSidebarRender(response.data.user_wishlist);
							
							showToast(
								`${productName} has been ${
									isAdded ? "added to" : "removed from"
								} the wishlist.`,
							);
						},
						complete: function () {
							$(wishlistIcon).removeClass("is-loading-spinner");
						},
						error: function (error) {
							console.log("Unable to update wishlist...");
						},
					});
				}
			});
		}

		// Quick View
		if (attributes.enableOptions.quickView) {
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

				// Get the render data
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

							const newQuantity = quantity + 1;

							if (newQuantity > 1) {
								$(blockID + " .quantity__decrease").removeClass("opacity-50");
							}
						});

						// Decrease quantity
						$(blockID + " .quantity__decrease").click(function () {
							let quantity = Math.abs(
								parseInt($(blockID + " .quick-view__quantity-input").val()),
							);
							const newQuantity = quantity - 1;

							if (newQuantity > 0) {
								$(blockID + " .quick-view__quantity-input").val(quantity - 1);
							} else {
								$(blockID + " .quick-view__quantity-input").val(1);
							}

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
									`<div class="cozy-featured-product toast-message visibility-hidden" id="cozyBlock_${n}"></div>`,
								);
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
									beforeSend: function () {
										$(".cozy-featured-product.toast-message").remove();
										$toast.appendTo("body");
									},
									success: function (response) {
										if (response.data.fragments) {
											$(document.body).trigger("added_to_cart", [
												response.data.fragments,
												response.data.cart_hash,
											]);
										}

										$(loaderIcon).addClass("display-none");
										$(buttonLabel).removeClass("display-none");

										if (response.success) {
											$toast.removeClass("visibility-hidden");
											$toast.addClass("is-success");
											$toast.html(
												`${response.data.product_name} has been added to cart`,
											);
											$(blockID + " .quick-view__cart-tooltip").removeClass(
												"is-error",
											);
											$(blockID + " .quick-view__cart-tooltip").removeClass(
												"visibility-hidden",
											);
											$(blockID + " .quick-view__cart-tooltip").addClass(
												"is-success",
											);
											$(blockID + " .quick-view__cart-tooltip").html(
												"Cart Updated!",
											);
											setTimeout(() => {
												$(blockID + " .quick-view__cart-tooltip").addClass(
													"visibility-hidden",
												);
											}, 2000);
										} else {
											$(blockID + " .quick-view__cart-tooltip").removeClass(
												"is-success",
											);
											$(blockID + " .quick-view__cart-tooltip").removeClass(
												"visibility-hidden",
											);
											$(blockID + " .quick-view__cart-tooltip").addClass(
												"is-error",
											);
											$(blockID + " .quick-view__cart-tooltip").html(
												"Sorry! Cannot purchase this product.",
											);
											setTimeout(() => {
												$(blockID + " .quick-view__cart-tooltip").addClass(
													"visibility-hidden",
												);
											}, 2000);
										}
									},
									complete: function () {
										setTimeout(() => {
											$toast.addClass("visibility-hidden");
										}, 2500);
										setTimeout(() => {
											$toast.remove();
										}, 2800);
									},
									error: function (error) {
										console.log("Unable to add to cart...");
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

						/* Rating Slider */
						const sliderAttr = {
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
						};

						const ratingSlider = new Swiper(swiperContainer, sliderAttr);
					},
					error: function (error) {
						console.log("Unable to add to cart...");
					},
				});
			});
		}
	};
})(jQuery);
