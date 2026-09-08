(function ($) {
	"use strict";

	$(document).ready(function () {
		const { ajax_url, utilityFunctionNonce } = ajax_object;

		const $dashboard = $(".cozy-blocks__dashboard");
		const $toast = $dashboard.find(".toast-message");

		/* CPT Seeder */
		$(".ca-btn.cpt-seeder").click(function () {
			const $this = $(this);
			const postType = $this.attr("data-post-type");

			$.ajax({
				url: ajax_url,
				method: "POST",
				data: {
					action: "cozy_addons_seed_cpt",
					nonce: utilityFunctionNonce,
					postType: postType,
				},
				beforeSend: function () {
					$this.addClass("is-disabled");
					if ($this.hasClass("is-admin-notice-btn")) {
						$this.find(".spinner").addClass("show-spinner");
					} else {
						$toast
							.addClass("is-active tone-info")
							.text("Hold on. Generating dummy data.");
					}
				},
				success: function (response) {
					if (response.success) {
						console.log("Yaay! CPT Data generated");
						if (!$this.hasClass("is-admin-notice-btn")) {
							$toast
								.removeClass("tone-info")
								.addClass("tone-success")
								.text("Dummy data generated.");
						}
					} else {
						if (!$this.hasClass("is-admin-notice-btn")) {
							$toast
								.removeClass("tone-info")
								.addClass("tone-error")
								.text("Oops! Something went wrong");
						}
					}
				},
				error: function () {
					if (!$this.hasClass("is-admin-notice-btn")) {
						$toast
							.removeClass("tone-info")
							.addClass("tone-error")
							.text("Oops! Something went wrong");
					}
				},
				complete: function () {
					$this.removeClass("is-disabled");

					if ($this.hasClass("is-admin-notice-btn")) {
						$this.find(".spinner").removeClass("show-spinner");
						window.location.href = window.location.href;
					} else {
						setTimeout(() => {
							$toast
								.removeClass(
									"is-active tone-info tone-success tone-warning tone-error",
								)
								.text("");
						}, 3000);
					}
				},
			});
		});
	});
})(jQuery);
