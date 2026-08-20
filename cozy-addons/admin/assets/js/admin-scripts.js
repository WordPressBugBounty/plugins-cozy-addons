(function ($) {
	"use strict";
	$(document).ready(function () {
		const {
			ajax_url,
			activeStatusNonce,
			isPremium,
			utilityFunctionNonce,
			themePluginNonce,
		} = ajax_object;

		const $dashboard = $(".cozy-blocks__dashboard");
		const $toast = $dashboard.find(".toast-message");
		const $tabs = $dashboard.find("#ct-dashboard-tabs");

		// Check if there's a saved active tab in localStorage
		const adminURL = window.location.href;
		const params = new URLSearchParams(adminURL);
		const allowedParams = [
			"dashboard",
			"blocks",
			"settings",
			"free-pro-comparison",
			"license",
		];

		function changeTab(slug) {
			const topLevelMenu = $("#toplevel_page__cozy_companions");
			if (slug !== "dashboard") {
				topLevelMenu.find(".wp-submenu li").removeClass("current");
				topLevelMenu.find(".wp-submenu li a").removeClass("current");
				const activeSubmenu = topLevelMenu.find(
					`.wp-submenu li:has(a[href="admin.php?page=_cozy_companions&tab=${slug}"])`,
				);
				activeSubmenu.addClass("current");
				activeSubmenu.find("a").addClass("current");
			} else {
				topLevelMenu.find(".wp-submenu li").removeClass("current");
				topLevelMenu.find(".wp-submenu li a").removeClass("current");
				const activeSubmenu = topLevelMenu.find(`.wp-submenu li.wp-first-item`);
				activeSubmenu.addClass("current");
				activeSubmenu.find("a").addClass("current");
			}

			// Get all tabs and tab contents
			var tabs = $(".ct-tab");
			var contents = $(".tab-content");

			// Remove active class from all tabs and contents
			tabs.removeClass("is-active");
			contents.removeClass("is-active");

			$(`.ct-tab[data-slug="${slug}"]`).addClass("is-active");
			$(`#${slug}.tab-content`).addClass("is-active");
		}

		const activeTab = params.get("tab");
		if (activeTab !== null && allowedParams.includes(activeTab)) {
			changeTab(activeTab);
		} else {
			changeTab("dashboard");
		}
		if (localStorage.getItem("activeTab")) {
			localStorage.removeItem("activeTab");
		}
		// Bind click event to tabs
		$dashboard.find(".ct-tab").click(function () {
			const tabSlug = $(this).data("slug");
			changeTab(tabSlug);
		});

		/* Setting sidebar tab click */
		$dashboard.find(".setting-tab-item").click(function () {
			const $this = $(this);
			const tabId = $this.attr("id");

			$dashboard.find(".setting-tab-item").removeClass("is-active");
			$dashboard.find(".setting-tab-content").removeClass("is-active");

			$this.addClass("is-active");
			$dashboard.find(`#${tabId}.setting-tab-content`).addClass("is-active");
		});

		//Cozy block upsell tooltip.
		$dashboard
			.find(".toggle-switcher.has-tooltip")
			.on("click", function (event) {
				event.preventDefault();
				const $this = $(this);

				if ($this.next(".cozy-block-upsell-tooltip").is(":visible")) {
					$this.next(".cozy-block-upsell-tooltip").hide();
					return;
				}
				$(".cozy-block-upsell-tooltip").hide();
				$this.next(".cozy-block-upsell-tooltip").show();
			});

		// Event listener for changes in any checkbox
		$dashboard.find(".cozy-block-active").change(function () {
			const blockName = $(this).attr("name");
			const isChecked = $(this).is(":checked");

			// Perform AJAX call to update the option value on checkbox change
			$.ajax({
				url: ajax_url,
				method: "POST",
				data: {
					action: "cozy_addons_update_block_active_status",
					block_name: blockName,
					checked: isChecked ? "1" : "0",
					nonce: activeStatusNonce,
				},
				success: function (response) {
					// console.log(`${blockName}: Active status(${isChecked})`);
				},
				error: function (xhr, status, error) {
					console.log("Error:", error);
				},
			});
		});

		// Block CPT enable/disable
		$dashboard.find(".ca__block-cpt").change(function () {
			if (!isPremium) {
				return;
			}

			const templateName = $(this).attr("name");
			const isChecked = $(this).is(":checked");

			$.ajax({
				url: ajax_url,
				method: "POST",
				data: {
					action: "cozy_addons_update_cpt_enabled_option",
					templateName: templateName,
					checked: isChecked ? "1" : "0",
					nonce: activeStatusNonce,
				},
				success: function (response) {
					// console.log(`${templateName}: Active status(${isChecked})`);
				},
				error: function (xhr, status, error) {
					console.log("Error:", error);
				},
			});
		});

		// Utility functions enable/disable
		$dashboard.find(".ca__utility-function").change(function () {
			const functionName = $(this).attr("name");
			const isChecked = $(this).is(":checked");

			$.ajax({
				url: ajax_url,
				method: "POST",
				data: {
					action: "cozy_addons_toggle_ca_utility_function_status",
					nonce: utilityFunctionNonce,
					functionName: functionName,
					checked: isChecked ? "1" : "0",
				},
				success: function (response) {
					// console.log(`${templateName}: Active status(${isChecked})`);
				},
				error: function (xhr, status, error) {
					console.log("Error:", error);
				},
			});
		});

		$(".cozy-addons-admin-notice").on("click", ".notice-dismiss", function () {
			$.ajax({
				url: ajax_url,
				data: {
					action: "cozy_addons_dismiss_welcome_notice",
				},
			});
		});

		$(".cozy-blocks-admin-notice").on("click", ".notice-dismiss", function () {
			$.ajax({
				url: ajax_url,
				data: {
					action: "cozy_blocks_dismissble_notice",
				},
			});
		});

		// Rollback btn
		const rollbackBtn = $("#cozy-addons-rollback-btn");
		$(".cozy-addons-rollback-version").change(function () {
			const selectedVal = $(this).val();

			let url = rollbackBtn.attr("href");

			let urlObj = new URL(url);
			urlObj.searchParams.set("version", selectedVal);

			const updatedURL = urlObj.toString();

			rollbackBtn.attr("href", updatedURL);
		});

		// Features list redirection
		$dashboard.find("#ca-features-list").on("click", function () {
			const lastTab = $(".ct-tab").last().data("index");

			changeTab(lastTab);
		});

		// FAQ Accordion
		$dashboard.find(".accordion-header").on("click", function () {
			var $item = $(this).closest(".accordion-item");
			var isActive = $item.hasClass("active");

			// close all others (remove this block if you want multiple open at once)
			$(".accordion-item").not($item).removeClass("active");

			$item.toggleClass("active", !isActive);
		});

		// Plugin Installation
		$dashboard.find(".activate-plugin").click(function (e) {
			e.preventDefault();
			const $this = $(this);

			const plugins =
				typeof $this.attr("data-plugins") === "object"
					? JSON.parse($this.attr("data-plugins"))
					: [$this.attr("data-plugins")];

			$.ajax({
				url: ajax_url,
				method: "POST",
				data: {
					action: "cozy_addons_install_activate_plugin",
					nonce: themePluginNonce,
					plugins: JSON.stringify(plugins),
				},
				beforeSend: function () {
					$dashboard.find(".activate-plugin").addClass("is-disabled");
					$tabs.addClass('is-disabled');
					$toast
						.addClass("is-active tone-info")
						.text("Hold on. Installing plugin!");
				},
				success: function (response) {
					$toast
						.removeClass("tone-info")
						.addClass("tone-success")
						.text("Plugin installed successfully.");
				},
				error: function () {
					$toast
						.removeClass("tone-info")
						.addClass("tone-error")
						.text("Oops! Something went wrong");
				},
				complete: function () {
					$tabs.removeClass('is-disabled');
					setTimeout(() => {
						$toast
							.removeClass(
								"is-active tone-info tone-success tone-warning tone-error",
							)
							.text("");

						$dashboard.find(".activate-plugin").addClass("is-disabled");
						window.location.href = window.location.href;
					}, 3000);
				},
			});
		});
	});
})(jQuery);
