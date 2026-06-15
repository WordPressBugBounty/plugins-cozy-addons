(function ($) {
	function renderTRBL(type, attributes) {
		const sides = ["top", "right", "bottom", "left"];
		const generateProperty = (prop, side) =>
			attributes[side] ? `${prop}-${side}: ${attributes[side]};` : "";

		switch (type) {
			case "border":
				if (attributes?.width || attributes?.style || attributes?.color) {
					return `
						${attributes?.width ? `border-width: ${attributes?.width};` : ""}
						${attributes?.style ? `border-style: ${attributes?.style};` : ""}
						${attributes?.color ? `border-color: ${attributes?.color};` : ""}
					`;
				} else if (
					attributes?.top ||
					attributes?.right ||
					attributes?.bottom ||
					attributes?.left
				) {
					return sides
						.map((side) =>
							attributes[side]?.width &&
							attributes[side]?.style &&
							attributes[side]?.color
								? `border-${side}: ${attributes[side].width} ${attributes[side].style} ${attributes[side].color};`
								: "",
						)
						.join("\n");
				}
				return "";

			case "padding":
				return sides
					.map((side) => generateProperty("padding", side))
					.join("\n");

			case "margin":
				return sides.map((side) => generateProperty("margin", side)).join("\n");

			default:
				return "";
		}
	}

	const fontFamily = (font) => {
		return font.replace(/\s+/g, "+");
	};

	const applyToastFont = (family) => {
		if (!family) return;
		const formatted = fontFamily(family);
		const linkId = "cozy-block-add-to-cart__toast-font";
		const href = `https://fonts.googleapis.com/css2?family=${formatted}:wght@100;200;300;400;500;600;700;800;900`;

		let $link = jQuery(`#${linkId}`);
		if (!$link.length) {
			jQuery("head").append(
				`<link id="${linkId}" rel="stylesheet" href="${href}" />`,
			);
		} else {
			$link.attr("href", href);
		}
	};

	window.cozyBlockAddToCartRegistry = window.cozyBlockAddToCartRegistry || {};

	window["cozyBlockAddToCartInit"] = (e) => {
		const n = e.replace(/-/gi, "_");
		const blockOptions = window[`cozyBlock_${n}`];
		if (!blockOptions || !blockOptions.toast) return;

		window.cozyBlockAddToCartRegistry[e] = blockOptions;

		if (!jQuery("body").find(".cozy-block-add-to-cart__toast").length) {
			jQuery("body").append(
				'<div class="cozy-block-add-to-cart__toast visibility-hidden"></div>',
			);
		}
	};

	window.cozyBlockApplyToastStyles = (clientId) => {
		const blockOptions = window.cozyBlockAddToCartRegistry[clientId];
		if (!blockOptions || !blockOptions.toast) return;

		applyToastFont(blockOptions.toast.font.family);

		const styleId = "cozy-block-add-to-cart__toast-styles";
		const css = `
			.cozy-block-add-to-cart__toast {
				${renderTRBL("padding", blockOptions.toast.padding)}
				${renderTRBL("border", blockOptions.toast.border)}
				border-radius: ${blockOptions.toast.radius};
				bottom: ${blockOptions.toast.position.vertical};
				right: ${blockOptions.toast.position.horizontal} !important;
				font-size: ${blockOptions.toast.font.size};
				font-weight: ${blockOptions.toast.font.weight};
				font-family: ${blockOptions.toast.font.family};
				text-transform: ${blockOptions?.toast?.letterCase};
				text-decoration: ${blockOptions?.toast?.decoration};
				line-height: ${blockOptions?.toast?.lineHeight};
				letter-spacing: ${blockOptions?.toast?.letterSpacing};
				color: ${blockOptions.toast.color.text};
				background-color: ${blockOptions.toast.color.bg};
			}
		`;

		let $style = jQuery(`#${styleId}`);
		if (!$style.length) {
			jQuery("head").append(`<style id="${styleId}">${css}</style>`);
		} else {
			$style.text(css);
		}
	};
})(jQuery);
