<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['blockClientId'] ) ) : '';
$cozy_block_var = 'cozyScrollTop_' . str_replace( '-', '_', $client_id );
wp_localize_script( 'cozy-block--back-to-top--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--back-to-top--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockScrollTopInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$styles = array(
	'zindex'     => isset( $attributes['position']['zIndex'] ) ? esc_attr( $attributes['position']['zIndex'] ) : '',
	'box_width'  => isset( $attributes['styles']['boxWidth'] ) ? esc_attr( $attributes['styles']['boxWidth'] ) : '',
	'box_height' => isset( $attributes['styles']['boxHeight'] ) ? esc_attr( $attributes['styles']['boxHeight'] ) : '',
	'radius'     => isset( $attributes['styles']['borderRadius'] ) ? esc_attr( $attributes['styles']['borderRadius'] ) : '',
	'right'      => isset( $attributes['position']['right'] ) ? esc_attr( $attributes['position']['right'] ) : '',
	'bottom'     => isset( $attributes['position']['bottom'] ) ? esc_attr( $attributes['position']['bottom'] ) : '',
	'size'       => isset( $attributes['styles']['iconSize'] ) ? esc_attr( $attributes['styles']['iconSize'] ) : '',
);

$color = array(
	'bg'         => isset( $attributes['styles']['bgColor'] ) ? esc_attr( $attributes['styles']['bgColor'] ) : '',
	'bg_hover'   => isset( $attributes['styles']['bgColorHover'] ) ? esc_attr( $attributes['styles']['bgColorHover'] ) : '',
	'icon'       => isset( $attributes['styles']['iconColor'] ) ? esc_attr( $attributes['styles']['iconColor'] ) : '',
	'icon_hover' => isset( $attributes['styles']['iconColorHover'] ) ? esc_attr( $attributes['styles']['iconColorHover'] ) : '',
);

$block_styles = "
.cozy-block-back-to-top-zindex.position-fixed{
    z-index: {$styles['zindex']};
}
#$block_id {
    width: {$styles['box_width']}px;
    height: {$styles['box_height']}px;
    border-radius: {$styles['radius']}px;
    background-color: {$color['bg']};
    right: {$styles['right']}px;
    bottom: {$styles['bottom']}px;
}

#$block_id:hover {
    background-color: {$color['bg_hover']};
}

#$block_id svg {
    width: {$styles['size']}px;
    height: {$styles['size']}px;
    fill: {$color['icon']};
}

#$block_id:hover svg {
    fill: {$color['icon_hover']};
}
";

$output = '<div class="cozy-block-wrapper cozy-block-back-to-top-wrapper cozy-block-back-to-top-zindex position-fixed">';

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$output .= $content;
$output .= '</div>';

echo $output;
