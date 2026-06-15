(function ($) {
	window["cozyBlockProductTab"] = (e) => {
		const n = e.replace(/-/gi, "_");
		const attributes = window[`cozyBlock_${n}`];
		const blockID = `#cozyBlock_${n}`;

		function changeTab(index) {
			// Get all tabs and tab contents
			var tabs = $(blockID + " .cozy-block__product-tab");
			var contents = $(blockID + " .cozy-block-product-tab__body");

			// Remove active class from all tabs and contents
			tabs.removeClass("active-tab");
			contents.removeClass("active-content");

			// Add active class to the selected tab and content
			tabs.eq(index).addClass("active-tab");
			contents.eq(index).addClass("active-content");
		}

		// Bind click event to tabs
		$(blockID + " .cozy-block__product-tab").click(function () {
			var tabIndex = $(this).data("index");
			changeTab(tabIndex);
		});

		/* Add to cart button */
		if (attributes.enableOptions.cart) {
			// Cart button (post__cart-button) - handle link-based products
			$(blockID + " .post__cart-button").on("click", function () {
				const productType = $(this).attr("data-product-type");
				const productLink = $(this).attr("data-product-link");
				const linkTarget = $(this).attr("data-link-target");

				// Non-simple or out-of-stock: navigate to product page
				if (productLink) {
					if (linkTarget === "_blank") {
						window.open(productLink, "_blank");
					} else {
						window.location.href = productLink;
					}
					return;
				}

				// Simple + in stock: AJAX add to cart
				const productId = $(this).attr("data-product-id");
				const loaderIcon = $(this).find(".loader-icon");
				const buttonLabel = $(this).find(".cart-button__label");

				$(buttonLabel).addClass("display-none");
				$(loaderIcon).removeClass("display-none");

				const $toast = $(
					`<div class="cozy__product-showcase add-to-cart post__toast visibility-hidden" id="cozyBlock_${n}"></div>`,
				).appendTo("body");

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
							$toast.html(
								`${response.data.product_name} has been added to cart`,
							);
							$toast.removeClass("visibility-hidden").addClass("is-success");
						} else {
							$toast.html("Sorry! Cannot purchase this product.");
							$toast.removeClass("visibility-hidden").addClass("is-error");
						}
						setTimeout(() => {
							$toast
								.removeClass("is-success is-error")
								.addClass("visibility-hidden");
						}, 2500);
					},
					error: function () {
						console.log("Unable to add to cart...");
					},
					complete: function () {
						$(loaderIcon).addClass("display-none");
						$(buttonLabel).removeClass("display-none");
						setTimeout(() => $toast.remove(), 2500);
					},
				});
			});
		}

		/* Icon Clicks */
		// Cart Icon
		if (attributes.enableOptions.cart) {
			$(
				blockID + " .cozy-block-product-tab__icon-wrapper.cart__icon-wrapper",
			).on("click", function () {
				const productId = $(this).attr("data-product-id");
				const productType = $(this).attr("data-product-type");
				const productLink = $(this).attr("data-product-link");

				if (productType !== "simple") {
					const linkTarget = $(this).attr("data-link-target");
					if (linkTarget === "_blank") {
						window.open(productLink, "_blank");
					} else {
						window.location.href = productLink;
					}
					return;
				}

				const iconWrapper = $(this);
				iconWrapper.addClass("is-loading-spinner");

				const $toast = $(
					`<div class="cozy__product-showcase add-to-cart post__toast visibility-hidden" id="cozyBlock_${n}"></div>`,
				).appendTo("body");

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
							$toast.html(
								`${response.data.product_name} has been added to cart`,
							);
							$toast.removeClass("visibility-hidden").addClass("is-success");
							setTimeout(() => {
								$toast.addClass("visibility-hidden").removeClass("is-success");
							}, 2500);
						} else {
							$toast.html("Sorry! Cannot purchase this product.");
							$toast.removeClass("visibility-hidden").addClass("is-error");
							setTimeout(() => {
								$toast.addClass("visibility-hidden").removeClass("is-error");
							}, 2500);
						}
					},
					error: function () {
						console.log("Unable to add to cart...");
					},
					complete: function () {
						iconWrapper.removeClass("is-loading-spinner");
						setTimeout(() => $toast.remove(), 2500);
					},
				});
			});
		}

		// Wishlist Icon
		if (attributes.enableOptions.wishlist) {
			const rawData = $(".cozy-block-wishlist.variation-sidebar").attr(
				"wishlist-user-data",
			);
			const wishlistUserData = rawData ? JSON.parse(rawData) : {};

			function getLocalWishlist() {
				let wishlist =
					JSON.parse(localStorage.getItem("cozy_block_wishlist_data")) || [];
				return wishlist;
			}

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

			// Add/remove active class from the wishlist icon wrapper div local data.
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
						error: function (error) {
							console.log("Unable to load data...");
						},
					});
				}
			}

			$(
				blockID +
					" .cozy-block-product-tab__icon-wrapper.wishlist__icon-wrapper",
			).on("click", function () {
				const productId = parseInt($(this).attr("data-product-id"));
				const productName = $(this).attr("data-product-name");
				const wishlistIconWrapper = $(
					`.cozy-block-wrapper .wishlist__icon-wrapper[data-product-id="${productId}"]`,
				);

				if (!attributes.isUserLoggedIn) {
					wishlistIconWrapper.addClass("is-loading-spinner");

					let wishlist = getLocalWishlist();
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

					const wishlistData = getLocalWishlist().map(Number);
					const isNowActive = wishlistData.includes(productId);

					$('.wishlist__icon-wrapper[data-product-id="' + productId + '"]')[
						isNowActive ? "addClass" : "removeClass"
					]("is-active");

					wishlistIconWrapper.removeClass("is-loading-spinner");

					updateWishlistCount(wishlistData.length);

					const actionLabel = isNowActive ? "added to" : "removed from";
					const $toast = $(
						`<div class="cozy__product-showcase wishlist post__toast visibility-hidden" id="cozyBlock_${n}"></div>`,
					).appendTo("body");
					$toast
						.html(`${productName} has been ${actionLabel} Wishlist`)
						.removeClass("visibility-hidden")
						.addClass("is-success");
					setTimeout(() => {
						$toast.addClass("visibility-hidden").removeClass("is-success");
						setTimeout(() => $toast.remove(), 300);
					}, 2500);
				} else {
					wishlistIconWrapper.addClass("is-loading-spinner");

					$.ajax({
						url: attributes.ajaxUrl,
						method: "POST",
						data: {
							action: "cozy_block_wishlist_update_user_wishlist",
							wishlistNonce: attributes.wishlistNonce,
							productId: productId,
							userId: attributes.userID,
						},
						success: function (response) {
							const isNowActive =
								response.data.user_wishlist.includes(productId);

							$('.wishlist__icon-wrapper[data-product-id="' + productId + '"]')[
								isNowActive ? "addClass" : "removeClass"
							]("is-active");

							updateWishlistCount(response.data.user_wishlist.length);
							updateSidebarRender(response.data.user_wishlist);

							const actionLabel = isNowActive ? "added to" : "removed from";
							const $toast = $(
								`<div class="cozy__product-showcase wishlist post__toast visibility-hidden" id="cozyBlock_${n}"></div>`,
							).appendTo("body");
							$toast
								.html(`${productName} has been ${actionLabel} Wishlist`)
								.removeClass("visibility-hidden")
								.addClass("is-success");
							setTimeout(() => {
								$toast.addClass("visibility-hidden").removeClass("is-success");
								setTimeout(() => $toast.remove(), 300);
							}, 2500);
						},
						complete: function () {
							wishlistIconWrapper.removeClass("is-loading-spinner");
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
									`<div class="cozy__product-showcase add-to-cart post__toast visibility-hidden" id="cozyBlock_${n}"></div>`,
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

										$(loaderIcon).addClass("display-none");
										$(buttonLabel).removeClass("display-none");

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
									},
									complete: function () {
										setTimeout(() => $toast.remove(), 2500);
									},
								});
							},
						);

						const swiperContainer = document.querySelector(
							blockID + " .quick-view__rating.swiper__container",
						);
						const prev = document.querySelector(
							blockID + " .quick-view__lightbox-body .swiper-button-prev",
						);
						const next = document.querySelector(
							blockID + " .quick-view__lightbox-body .swiper-button-next",
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
