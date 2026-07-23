<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozyProductSlider_' . str_replace( '-', '_', $client_id );
wp_localize_script( 'cozy-block--product-slider--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--product-slider--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockProductSliderInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$nav       = array(
	'size'       => isset( $attributes['navigation']['iconSize'] ) ? esc_attr( $attributes['navigation']['iconSize'] ) : '',
	'box_width'  => isset( $attributes['navigation']['iconBoxWidth'] ) ? esc_attr( $attributes['navigation']['iconBoxWidth'] ) : '',
	'box_height' => isset( $attributes['navigation']['iconBoxHeight'] ) ? esc_attr( $attributes['navigation']['iconBoxHeight'] ) : '',
	'radius'     => isset( $attributes['navigation']['borderRadius'] ) ? esc_attr( $attributes['navigation']['borderRadius'] ) : '',
	'border'     => isset( $attributes['navigation']['border'] ) ? cozy_render_TRBL( 'border', $attributes['navigation']['border'] ) : '',
);
$nav_color = array(
	'icon'         => isset( $attributes['navigation']['color'] ) ? esc_attr( $attributes['navigation']['color'] ) : '',
	'bg'           => isset( $attributes['navigation']['backgroundColor'] ) ? esc_attr( $attributes['navigation']['backgroundColor'] ) : '',
	'icon_hover'   => isset( $attributes['navigation']['colorHover'] ) ? esc_attr( $attributes['navigation']['colorHover'] ) : '',
	'bg_hover'     => isset( $attributes['navigation']['backgroundColorHover'] ) ? esc_attr( $attributes['navigation']['backgroundColorHover'] ) : '',
	'border_hover' => isset( $attributes['navigation']['borderHover'] ) ? esc_attr( $attributes['navigation']['borderHover'] ) : '',
);

$bullet       = array(
	'bottom' => isset( $attributes['pagination']['verticalPosition'] ) ? esc_attr( $attributes['pagination']['verticalPosition'] ) : '',
	'align'  => isset( $attributes['pagination']['align'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['align'] ) ) : 'center',
	'left'   => isset( $attributes['pagination']['align'], $attributes['pagination']['left'] ) && 'left' === $attributes['pagination']['align'] ? 'padding-left: ' . esc_attr( $attributes['pagination']['left'] ) . ';' : '',
	'right'  => isset( $attributes['pagination']['align'], $attributes['pagination']['right'] ) && 'right' === $attributes['pagination']['align'] ? 'padding-right: ' . esc_attr( $attributes['pagination']['right'] ) . ';' : '',
	'width'  => isset( $attributes['pagination']['width'] ) ? esc_attr( $attributes['pagination']['width'] ) : '',
	'height' => isset( $attributes['pagination']['height'] ) ? esc_attr( $attributes['pagination']['height'] ) : '',
	'radius' => isset( $attributes['pagination']['borderRadius'] ) ? esc_attr( $attributes['pagination']['borderRadius'] ) : '',
	'active' => array(
		'width'  => isset( $attributes['pagination']['activeWidth'] ) ? esc_attr( $attributes['pagination']['activeWidth'] ) : '',
		'height' => isset( $attributes['pagination']['activeHeight'] ) ? esc_attr( $attributes['pagination']['activeHeight'] ) : '',
		'border' => isset( $attributes['pagination']['activeBorder'] ) ? cozy_render_TRBL( 'outline', $attributes['pagination']['activeBorder'] ) : '',
		'radius' => isset( $attributes['pagination']['activeBorderRadius'] ) ? esc_attr( $attributes['pagination']['activeBorderRadius'] ) : '',
		'offset' => isset( $attributes['pagination']['activeOffset'] ) ? esc_attr( $attributes['pagination']['activeOffset'] ) : '',
	),
	'gap'    => isset( $attributes['pagination']['gap'] ) ? esc_attr( $attributes['pagination']['gap'] ) : '',
);
$bullet_color = array(
	'default_bg'       => isset( $attributes['pagination']['color'] ) ? esc_attr( $attributes['pagination']['color'] ) : '',
	'active_bg'        => isset( $attributes['pagination']['activeColor'] ) ? esc_attr( $attributes['pagination']['activeColor'] ) : '',
	'default_bg_hover' => isset( $attributes['pagination']['colorHover'] ) ? esc_attr( $attributes['pagination']['colorHover'] ) : '',
	'active_bg_hover'  => isset( $attributes['pagination']['activeColorHover'] ) ? esc_attr( $attributes['pagination']['activeColorHover'] ) : '',
);

$block_styles = "
#$block_id .swiper-button-prev::after,
#$block_id .swiper-button-next::after {
    font-size: {$nav['size']}px;
}
#$block_id .swiper-button-prev,
#$block_id .swiper-button-next {
    width: {$nav['box_width']}px;
    height: {$nav['box_height']}px;
    {$nav['border']}
    border-radius: {$nav['radius']}px;
    color: {$nav_color['icon']};
    background-color: {$nav_color['bg']};
}
#$block_id .swiper-button-prev:hover,
#$block_id .swiper-button-next:hover {
    color: {$nav_color['icon_hover']};
    background-color: {$nav_color['bg_hover']};
    border-color: {$nav_color['border_hover']};
}

#$block_id .swiper-pagination {
    bottom: {$bullet['bottom']}px;
    text-align: {$bullet['align']};
    {$bullet['left']}
    {$bullet['right']}
}
#$block_id .swiper-pagination .swiper-pagination-bullet {
    margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$bullet['gap']}px);
}
#$block_id .swiper-pagination .swiper-pagination-bullet {
    width: {$bullet['width']}px;
    height: {$bullet['height']}px;
    border-radius: {$bullet['radius']}px;
    background-color: {$bullet_color['default_bg']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active {
    width: {$bullet['active']['width']}px;
    height: {$bullet['active']['height']}px;
    {$bullet['active']['border']}
    outline-offset: {$bullet['active']['offset']}px;
    border-radius: {$bullet['active']['radius']}px;
    background-color: {$bullet_color['active_bg']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet:hover {
    background-color: {$bullet_color['default_bg_hover']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active:hover {
    background-color: {$bullet_color['active_bg_hover']};
}
";

$output = '<div class="cozy-block-wrapper">';

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$output .= $content;
$output .= '</div>';

echo $output;
