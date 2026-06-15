(function ($) {
	window["cozyBlockWishlist"] = (e) => {
		const n = e.replace(/-/gi, "_");
		const attributes = window[`cozyBlock_${n}`];
		const blockID = `#cozyBlock_${n}`;

		function getLocalWishlist() {
			let wishlist =
				JSON.parse(localStorage.getItem("cozy_block_wishlist_data")) || [];
			return wishlist;
		}

		function removeLocalWishlist(productId) {
			let wishlist =
				JSON.parse(localStorage.getItem("cozy_block_wishlist_data")) || [];

			if (wishlist.includes(productId)) {
				wishlist = wishlist.filter(
					(id) => parseInt(id) !== parseInt(productId),
				);
			}

			localStorage.setItem(
				"cozy_block_wishlist_data",
				JSON.stringify(wishlist),
			);
		}

		function showToast(message) {
			const toastId = blockID.replace("#", "");
			$("body > #" + toastId + ".cozy-block-wishlist__toast").remove();
			$("body").append(
				'<div id="' +
					toastId +
					'" class="cozy-block-wishlist__toast visibility-hidden"></div>',
			);
			const $toast = $("body > #" + toastId + ".cozy-block-wishlist__toast");
			$toast.html(message).removeClass("visibility-hidden");
			setTimeout(() => {
				$toast.addClass("visibility-hidden");
			}, 2500);
			setTimeout(() => {
				$toast.remove();
			}, 2800);
		}

		function addToCart(el) {
			const productId = $(el).attr("data-product-id");
			$.ajax({
				url: attributes.ajaxUrl,
				method: "POST",
				data: {
					action: "cozy_block_wishlist_add_to_cart",
					cartNonce: attributes.cartNonce,
					productId: productId,
				},
				beforeSend: function () {
					$(el).addClass("is-loading-spinner");
				},
				success: function (response) {
					if (response.data.fragments) {
						$(document.body).trigger("added_to_cart", [
							response.data.fragments,
							response.data.cart_hash,
						]);
					}

					const productName = response.data.product_name;
					showToast(`${productName} has been added to cart.`);
				},
				complete: function () {
					$(el).removeClass("is-loading-spinner");
				},
				error: function (error) {
					console.log("Unable to add to cart...");
				},
			});
		}

		function arraysAreDifferent(array1, array2) {
			if (array1.length !== array2.length) {
				return true;
			}

			let set2 = new Set(array2);
			return (
				array1.some((item) => !set2.has(item)) ||
				array2.some((item) => !new Set(array1).has(item))
			);
		}

		if (attributes.variation === "sidebar") {
			function closeSidebar() {
				$(blockID + " .cozy-block-wishlist__sidebar-wrapper").addClass(
					"visibility-hidden",
				);
				$("body").removeClass("overflow-hidden");
			}

			function updateSidebarRender(wishlistData = []) {
				if (!attributes.isUserLoggedIn) {
					const wishlistData = getLocalWishlist();
					$.ajax({
						url: attributes.ajaxUrl,
						method: "POST",
						data: {
							action: "cozy_block_wishlist_render_data_sidebar",
							sidebarNonce: attributes.sidebarNonce,
							wishlistData: JSON.stringify(wishlistData),
							beforeLabel: attributes.sidebar.sidebarTitle.beforeText,
							afterLabel: attributes.sidebar.sidebarTitle.afterText,
							alignment: attributes.sidebar.sidebarTitle.alignment,
						},
						success: function (response) {
							if (response.data) {
								$(blockID + " .cozy-block-wishlist__sidebar-body").html(
									response.data.render,
								);

								if (attributes.sidebar.count.enabled) {
									const count = response.data.count || 0;
									if (count > 0) {
										if ($(blockID + " .cozy-block-wishlist__count").length) {
											$(blockID + " .cozy-block-wishlist__count").html(count);
										} else {
											$(blockID + " .sidebar__icon-wrapper").append(
												`<span class="cozy-block-wishlist__count">${count}</span>`,
											);
										}
									} else {
										$(blockID + " .cozy-block-wishlist__count").remove();
									}
								}
							}
						},
						error: function (error) {
							console.log("Unable to load data...");
						},
					});
				}

				if (attributes.isUserLoggedIn) {
					$.ajax({
						url: attributes.ajaxUrl,
						method: "POST",
						data: {
							action: "cozy_block_wishlist_render_data_sidebar",
							sidebarNonce: attributes.sidebarNonce,
							wishlistData: JSON.stringify(wishlistData),
							beforeLabel: attributes.sidebar.sidebarTitle.beforeText,
							afterLabel: attributes.sidebar.sidebarTitle.afterText,
							alignment: attributes.sidebar.sidebarTitle.alignment,
						},
						success: function (response) {
							if (response.data) {
								$(".cozy-block-wishlist__sidebar-body").html(
									response.data.render,
								);
								if (
									attributes.sidebar &&
									attributes.sidebar.count &&
									attributes.sidebar.count.enabled
								) {
									const count = response.data.count || 0;
									if (count > 0) {
										if ($(blockID + " .cozy-block-wishlist__count").length) {
											$(blockID + " .cozy-block-wishlist__count").html(count);
										} else {
											$(blockID + " .sidebar__icon-wrapper").append(
												`<span class="cozy-block-wishlist__count">${count}</span>`,
											);
										}
									} else {
										$(blockID + " .cozy-block-wishlist__count").remove();
									}
								}
							}
						},
						error: function (error) {
							console.log("Unable to load data...");
						},
					});
				}
			}

			function removeFromWishlist(el) {
				const productId = $(el).attr("data-product-id");
				const productName = $(el).attr("data-product-name");
				const wishlistIcon = $(
					`.wishlist__icon-wrapper[data-product-id="${productId}"]`,
				);

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
							$(el).addClass("is-loading-spinner");
							wishlistIcon.addClass("is-loading-spinner");
						},
						success: function (response) {
							if (response.data.user_wishlist.includes(parseInt(productId))) {
								wishlistIcon.addClass("is-active");
							} else {
								wishlistIcon.removeClass("is-active");
							}

							const isNowActive = response.data.user_wishlist.includes(
								parseInt(productId),
							);
							const actionLabel = isNowActive ? "added to" : "removed from";
							showToast(`${productName} has been ${actionLabel} Wishlist`);

							if (attributes.sidebar.count?.enabled) {
								if (response.data.user_wishlist.length > 0) {
									if (
										$(
											".cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count",
										).length
									) {
										$(
											".cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count",
										).html(response.data.user_wishlist.length);
									} else {
										$(
											".cozy-block-wishlist.variation-sidebar .sidebar__icon-wrapper",
										).append(
											`<span class="cozy-block-wishlist__count">${response.data.user_wishlist.length}</span>`,
										);
									}
								} else {
									$(
										".cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count",
									).remove();
								}
							}

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
					const $icon = $(
						'.cozy-block-wrapper .wishlist__icon-wrapper[data-product-id="' +
							productId +
							'"]',
					);
					$icon.addClass("is-loading-spinner");

					removeLocalWishlist(parseInt(productId));

					const updatedWishlist = getLocalWishlist();

					$(
						".cozy-block-wishlist.variation-wishlist .post-" + productId,
					).removeClass("is-active");
					$icon.removeClass("is-active").removeClass("is-loading-spinner");

					showToast(`${productName} has been removed from Wishlist`);

					updateSidebarRender(updatedWishlist);
				}
			}

			let oldWishlistData = getLocalWishlist();
			const initialWishlistData = attributes.isUserLoggedIn
				? attributes.userWishlistData || []
				: getLocalWishlist();
			updateSidebarRender(initialWishlistData);

			// Open Sidebar
			$(blockID + " .sidebar__icon-wrapper").click(function (e) {
				const updatedWishlistData = getLocalWishlist();
				if (arraysAreDifferent(oldWishlistData, updatedWishlistData)) {
					$(blockID + " .cozy-block-wishlist__sidebar-body").empty();
					oldWishlistData = updatedWishlistData;
					updateSidebarRender();
				}

				$(blockID + " .cozy-block-wishlist__sidebar-wrapper").removeClass(
					"visibility-hidden",
				);
				$("body").addClass("overflow-hidden");
			});

			// Close Sidebar
			$(
				blockID + " .cozy-block-wishlist__toolbar-button.sidebar-close-button",
			).click(function () {
				closeSidebar();
			});
			$(blockID + " .cozy-block-wishlist__sidebar-wrapper").on(
				"click",
				function (event) {
					if (event.target === event.currentTarget) {
						closeSidebar();
					}
				},
			);

			// Sidebar buttons
			// Add to Cart
			$(`${blockID} .cozy-block-wishlist__sidebar`).on(
				"click",
				`.cozy-block-wishlist__sidebar-button.add__cart`,
				function () {
					addToCart(this);
				},
			);

			// Remove from wishlist
			$(`${blockID} .cozy-block-wishlist__sidebar`).on(
				"click",
				`.cozy-block-wishlist__sidebar-button.remove__wishlist`,
				function (e) {
					$(this).addClass("opacity-50");
					removeFromWishlist(this);
				},
			);
		}
	};
})(jQuery);
