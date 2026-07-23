<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// 1. Core Data & Security Setup
$client_id = ! empty( $attributes['clientId'] ) ? cozy_remove_special_chars( $attributes['clientId'] ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$attributes['ajaxUrl']   = admin_url( 'admin-ajax.php' );
$attributes['cartNonce'] = wp_create_nonce( 'cozy_block_wishlist_add_to_cart' );
$toast_attributes        = $attributes['toast'];

// 2. Product Object & Link Logic
$product_id   = $block->context['postId'];
$product      = wc_get_product( $product_id );
$product_type = '';
$product_link = '';

if ( is_object( $product ) ) {
	$product_type = $product->get_type();
	// Logic: If External, get the affiliate link. Otherwise, get the site link.
	if ( 'external' === $product_type ) {
		$product_link = $product->get_product_url();
	} else {
		$product_link = $product->get_permalink();
	}
}

// 3. Tab Settings Logic
$open_in_new_tab_settings = isset( $attributes['openInNewTab'] ) ? $attributes['openInNewTab'] : array();
$should_open_new_tab      = ! empty( $open_in_new_tab_settings[ $product_type ] ) && true === $open_in_new_tab_settings[ $product_type ];
$link_target              = $should_open_new_tab ? ' target="_blank"' : '';

// 4. Style & Attribute Arrays
$button = array(
	'gap'            => isset( $attributes['button']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['button']['gap'] ) : '',
	'padding'        => isset( $attributes['button']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['button']['padding'] ) : '',
	'width'          => isset( $attributes['button']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['button']['width'] ) : '',
	'border'         => isset( $attributes['button']['border'] ) ? cozy_render_TRBL( 'border', $attributes['button']['border'] ) : '',
	'radius'         => isset( $attributes['button']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['button']['radius'] ) : '',
	'shadow_default' => array(
		'horizontal' => isset( $attributes['button']['shadow']['default']['horizontal'] ) ? esc_attr( $attributes['button']['shadow']['default']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['button']['shadow']['default']['vertical'] ) ? esc_attr( $attributes['button']['shadow']['default']['vertical'] ) : '',
		'blur'       => isset( $attributes['button']['shadow']['default']['blur'] ) ? esc_attr( $attributes['button']['shadow']['default']['blur'] ) : '',
		'spread'     => isset( $attributes['button']['shadow']['default']['spread'] ) ? esc_attr( $attributes['button']['shadow']['default']['spread'] ) : '',
		'color'      => isset( $attributes['button']['shadow']['default']['color'] ) ? esc_attr( $attributes['button']['shadow']['default']['color'] ) : '',
		'position'   => isset( $attributes['button']['shadow']['default']['position'] ) ? esc_attr( sanitize_text_field( $attributes['button']['shadow']['default']['position'] ) ) : '',
	),
	'shadow_hover'   => array(
		'horizontal' => isset( $attributes['button']['shadow']['hover']['horizontal'] ) ? esc_attr( $attributes['button']['shadow']['hover']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['button']['shadow']['hover']['vertical'] ) ? esc_attr( $attributes['button']['shadow']['hover']['vertical'] ) : '',
		'blur'       => isset( $attributes['button']['shadow']['hover']['blur'] ) ? esc_attr( $attributes['button']['shadow']['hover']['blur'] ) : '',
		'spread'     => isset( $attributes['button']['shadow']['hover']['spread'] ) ? esc_attr( $attributes['button']['shadow']['hover']['spread'] ) : '',
		'color'      => isset( $attributes['button']['shadow']['hover']['color'] ) ? esc_attr( $attributes['button']['shadow']['hover']['color'] ) : '',
		'position'   => isset( $attributes['button']['shadow']['hover']['position'] ) ? esc_attr( sanitize_text_field( $attributes['button']['shadow']['hover']['position'] ) ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['button']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['button']['font']['size'] ) : '',
		'weight' => isset( $attributes['button']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['button']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['button']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['button']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['button']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['button']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['button']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['button']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['button']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['button']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['button']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['button']['letterSpacing'] ) : '',
	'color'          => array(
		'text'         => isset( $attributes['button']['color']['text'] ) ? esc_attr( $attributes['button']['color']['text'] ) : '',
		'text_hover'   => isset( $attributes['button']['color']['textHover'] ) ? esc_attr( $attributes['button']['color']['textHover'] ) : '',
		'bg'           => isset( $attributes['button']['color']['bg'] ) ? esc_attr( $attributes['button']['color']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['button']['color']['bgHover'] ) ? esc_attr( $attributes['button']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['button']['color']['borderHover'] ) ? esc_attr( $attributes['button']['color']['borderHover'] ) : '',
	),
);

$icon = array(
	'margin'     => isset( $attributes['icon']['box']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['icon']['box']['margin'] ) : '',
	'box_width'  => isset( $attributes['icon']['box']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['box']['width'] ) : '',
	'box_height' => isset( $attributes['icon']['box']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['box']['height'] ) : '',
	'size'       => isset( $attributes['icon']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['size'] ) : '',
	'border'     => isset( $attributes['icon']['box']['border'] ) ? cozy_render_TRBL( 'border', $attributes['icon']['box']['border'] ) : '',
	'radius'     => isset( $attributes['icon']['box']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['box']['radius'] ) : '',
	'color'      => array(
		'text'         => isset( $attributes['icon']['color']['text'] ) && ! empty( $attributes['icon']['color']['text'] ) ? esc_attr( $attributes['icon']['color']['text'] ) : ( $button['color']['text'] ),
		'text_hover'   => isset( $attributes['icon']['color']['textHover'] ) && ! empty( $attributes['icon']['color']['textHover'] ) ? esc_attr( $attributes['icon']['color']['textHover'] ) : $button['color']['text_hover'],
		'bg'           => isset( $attributes['icon']['color']['bg'] ) && ! empty( $attributes['icon']['color']['bg'] ) ? esc_attr( $attributes['icon']['color']['bg'] ) : $button['color']['bg'],
		'bg_hover'     => isset( $attributes['icon']['color']['bgHover'] ) && ! empty( $attributes['icon']['color']['bgHover'] ) ? esc_attr( $attributes['icon']['color']['bgHover'] ) : $button['color']['bg_hover'],
		'border_hover' => isset( $attributes['icon']['color']['borderHover'] ) && ! empty( $attributes['icon']['color']['borderHover'] ) ? esc_attr( $attributes['icon']['color']['borderHover'] ) : $button['color']['border_hover'],
	),
);

$block_styles = "
#$block_id.has-label {
    {$button['padding']}
    width: {$button['width']};
    {$button['border']}
    border-radius: {$button['radius']};
    font-size: {$button['font']['size']};
    font-weight: {$button['font']['weight']};
    font-family: {$button['font']['family']};
    text-transform: {$button['letter_case']};
    text-decoration: {$button['decoration']};
    line-height: {$button['line_height']};
    letter-spacing: {$button['letter_spacing']};
    color: {$button['color']['text']};
    background-color: {$button['color']['bg']};
    gap: {$button['gap']};
    cursor: pointer;

	& a {
    	text-decoration: {$button['decoration']};
	}
}
#$block_id.has-label.has-box-shadow {
    box-shadow: {$button['shadow_default']['horizontal']}px {$button['shadow_default']['vertical']}px {$button['shadow_default']['blur']}px {$button['shadow_default']['spread']}px {$button['shadow_default']['color']} {$button['shadow_default']['position']};
}
#$block_id.has-label.has-hover-box-shadow:hover {
    box-shadow: {$button['shadow_hover']['horizontal']}px {$button['shadow_hover']['vertical']}px {$button['shadow_hover']['blur']}px {$button['shadow_hover']['spread']}px {$button['shadow_hover']['color']} {$button['shadow_hover']['position']};
}
#$block_id.has-label:hover {
    color: {$button['color']['text_hover']};
    background-color: {$button['color']['bg_hover']};
    border-color: {$button['color']['border_hover']};
}
#$block_id .cozy-block-add-to-cart__icon-wrapper {
	{$icon['margin']}
    width: {$icon['box_width']};
    height: {$icon['box_height']};
    {$icon['border']}
    border-radius: {$icon['radius']};
    background-color: {$icon['color']['bg']};
}
#$block_id .cozy-block-add-to-cart__icon-wrapper:hover, #$block_id.has-label:hover .cozy-block-add-to-cart__icon-wrapper {
    background-color: {$icon['color']['bg_hover']};
    border-color: {$icon['color']['border_hover']};
}
#$block_id .cozy-block-add-to-cart__icon-wrapper svg {
    width: {$icon['size']};
    height: {$icon['size']};
    fill: {$icon['color']['text']};
    color: {$icon['color']['text']};
    stroke: none;
}
#$block_id .cozy-block-add-to-cart__icon-wrapper:hover svg, #$block_id.has-label:hover svg {
    fill: {$icon['color']['text_hover']};
    color: {$icon['color']['text_hover']};
}
";

// 6. Output Construction (Fixed Escaping & Nesting)
$classes   = array();
$classes[] = 'cozy-block-add-to-cart';
$classes[] = $attributes['button']['enabled'] ? 'has-label' : '';
$classes[] = ( $attributes['button']['enabled'] && $attributes['button']['shadow']['default']['enabled'] ) ? 'has-box-shadow' : '';
$classes[] = ( $attributes['button']['enabled'] && $attributes['button']['shadow']['hover']['enabled'] ) ? 'has-hover-box-shadow' : '';

$escaped_classes = esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) );
$is_out_of_stock = is_object( $product ) && ! $product->is_in_stock();

$output = '';

if ( 'simple' !== $product_type || $is_out_of_stock ) {
	$output = sprintf(
		'<div class="%1$s" id="%2$s">
            <a href="%3$s"%4$s">',
		$escaped_classes,
		$block_id,
		esc_url( $product_link ),
		$link_target
	);
} else {
	$output = sprintf(
		'<div class="%1$s cozyBlock_productId_%3$d" id="%2$s" onClick="handleAddToCartClick(%3$d, \'%4$s\', \'%5$s\')">',
		$escaped_classes,
		$block_id,
		absint( $product_id ),
		esc_js( $client_id ),
		esc_js( is_object( $product ) ? $product->get_name() : '' )
	);
}
if ( ! empty( $attributes['postType'] ) && 'product' === $attributes['postType'] ) {

	if ( $attributes['button']['enabled'] && ! empty( $attributes['button']['font']['family'] ) ) {
		$output .= '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=' . esc_attr( $attributes['button']['font']['family'] ) . ':wght@100;200;300;400;500;600;700;800;900" />';
	}

	if ( ! empty( $attributes['toast']['font']['family'] ) ) {
		$output .= '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=' . esc_attr( $attributes['toast']['font']['family'] ) . ':wght@100;200;300;400;500;600;700;800;900" />';
	}

	if ( $attributes['icon']['enabled'] && 'left' === $attributes['icon']['position'] ) {
		$output  .= '<div class="cozy-block-add-to-cart__icon-wrapper" title="' . esc_html( 'Add To Cart' ) . '">';
		$view_box = implode( ' ', array( intval( $attributes['icon']['viewBox']['vx'] ), intval( $attributes['icon']['viewBox']['vy'] ), intval( $attributes['icon']['viewBox']['vw'] ), intval( $attributes['icon']['viewBox']['vh'] ) ) );
		$output  .= '<svg class="cozy-block-add-to-cart__cart-icon" viewBox="' . esc_attr( $view_box ) . '" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">';
		$output  .= '<path d="' . esc_attr( $attributes['icon']['path'] ) . '" />';
		$output  .= '</svg></div>';
	}

	if ( $attributes['button']['enabled'] ) {
		$output .= '<span class="cozy-block-add-to-cart__label">';
		if ( $product ) {
			$output .= esc_html( $product->add_to_cart_text() );
		} else {
			$output .= esc_html( $attributes['button']['label'] );
		}
		$output .= '</span>';
	}

	if ( $attributes['icon']['enabled'] && 'right' === $attributes['icon']['position'] ) {
		$output  .= '<div class="cozy-block-add-to-cart__icon-wrapper"title="' . esc_attr( 'Add To Cart' ) . '">';
		$view_box = implode( ' ', array( intval( $attributes['icon']['viewBox']['vx'] ), intval( $attributes['icon']['viewBox']['vy'] ), intval( $attributes['icon']['viewBox']['vw'] ), intval( $attributes['icon']['viewBox']['vh'] ) ) );
		$output  .= '<svg class="cozy-block-add-to-cart__cart-icon" viewBox="' . esc_attr( $view_box ) . '" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">';
		$output  .= '<path d="' . esc_attr( $attributes['icon']['path'] ) . '" />';
		$output  .= '</svg></div>';
	}
}

// 7. Close Structural Tags
if ( 'simple' !== $product_type || $is_out_of_stock ) {
	$output .= '</a></div>';
} else {
	$output .= '</div>';
}

$wrapper_attributes = get_block_wrapper_attributes();

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$render = sprintf( '<div class="cozy-block-wrapper cozy-block-add-to-cart-wrapper justify-' . esc_attr( $attributes['button']['justify'] ) . '"><div %1$s>%2$s</div></div>', $wrapper_attributes, $output );
echo $render;
wp_localize_script( 'cozy-block--add-to-cart--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--add-to-cart--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockAddToCartInit( "' . $client_id . '" ) }) ' );
?>

<script src="<?php echo esc_url( trailingslashit( COZY_ADDONS_PLUGIN_URL ) ) . 'vendor/jquery/jquery.js'; ?>"></script>
<script type="text/javascript">
	window.cozyCartQueue = window.cozyCartQueue || [];
	window.cozyCartBusy = window.cozyCartBusy || false;

	function processCartQueue() {
		if (window.cozyCartBusy || !window.cozyCartQueue.length) return;

		window.cozyCartBusy = true;
		const { productId, clientId, productName } = window.cozyCartQueue.shift();
		jQuery.ajax({
			url: "<?php echo esc_url( $attributes['ajaxUrl'] ); ?>",
			method: "POST",
			data: {
				action: "cozy_block_wishlist_add_to_cart",
				cartNonce: "<?php echo sanitize_key( $attributes['cartNonce'] ); ?>",
				productId: parseInt(productId),
			},
			success: function(response) {
				if (response.data.fragments) {
					$(document.body).trigger('added_to_cart', [response.data.fragments, response.data.cart_hash]);
				}

				const blockOptions = window.cozyBlockAddToCartRegistry?.[clientId];
				if (window.cozyBlockApplyToastStyles) {
					window.cozyBlockApplyToastStyles(clientId);
				}
				const $toast = jQuery('.cozy-block-add-to-cart__toast');
				$toast.html(`${productName} has been added to cart`).removeClass("visibility-hidden");
				setTimeout(() => $toast.addClass("visibility-hidden"), 2000);
			},
			error: function() {
				const blockOptions = window.cozyBlockAddToCartRegistry?.[clientId];
				const errorText = blockOptions?.toast?.errorText || '';
				if (window.cozyBlockApplyToastStyles) {
					window.cozyBlockApplyToastStyles(clientId);
				}
				const $toast = jQuery('.cozy-block-add-to-cart__toast');
				$toast.html(errorText).removeClass("visibility-hidden");
				setTimeout(() => $toast.addClass("visibility-hidden"), 2000);
			},
			complete: function() {
				jQuery(`.cozyBlock_productId_${productId}`)
					.removeClass('opacity-50');
				jQuery(`.cozyBlock_productId_${productId} .cozy-block-add-to-cart__cart-icon`)
					.removeClass('is-loading-spinner').removeClass('opacity-50');

				window.cozyCartBusy = false;
				processCartQueue();
			}
		});
	}

	function handleAddToCartClick(productId, clientId, productName) {
		jQuery(`.cozyBlock_productId_${productId}`)
			.addClass('opacity-50')
		jQuery(`.cozyBlock_productId_${productId} .cozy-block-add-to-cart__cart-icon`)
			.addClass('is-loading-spinner');
		window.cozyCartQueue.push({ productId, clientId, productName });
		processCartQueue();
	}
</script>
