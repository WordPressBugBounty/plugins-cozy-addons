<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozyNewsTicker_' . str_replace( '-', '_', $client_id );
wp_localize_script( 'cozy-block--news-ticker--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--news-ticker--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockNewsTickerInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$styles = array(
	'height'     => isset( $attributes['height'] ) ? esc_attr( $attributes['height'] ) : '',
	'box_width'  => isset( $attributes['carouselOptions']['navigation']['iconBoxWidth'] ) ? esc_attr( $attributes['carouselOptions']['navigation']['iconBoxWidth'] ) : '',
	'box_height' => isset( $attributes['carouselOptions']['navigation']['iconBoxHeight'] ) ? esc_attr( $attributes['carouselOptions']['navigation']['iconBoxHeight'] ) : '',
	'margin'     => array(
		'top' => isset( $attributes['carouselOptions']['navigation']['verticalGap'] ) ? esc_attr( $attributes['carouselOptions']['navigation']['verticalGap'] ) : '',
	),
	'radius'     => isset( $attributes['carouselOptions']['navigation']['borderRadius'] ) ? esc_attr( $attributes['carouselOptions']['navigation']['borderRadius'] ) : '',
	'gap'        => isset( $attributes['carouselOptions']['navigation']['horizontalGap'] ) ? esc_attr( $attributes['carouselOptions']['navigation']['horizontalGap'] ) : '',
);

$nav       = array(
	'size' => isset( $attributes['carouselOptions']['navigation']['iconSize'] ) ? esc_attr( $attributes['carouselOptions']['navigation']['iconSize'] ) : '',
);
$nav_color = array(
	'bg'         => isset( $attributes['carouselOptions']['navigation']['backgroundColor'] ) ? $attributes['carouselOptions']['navigation']['backgroundColor'] : '',
	'icon'       => isset( $attributes['carouselOptions']['navigation']['color'] ) ? $attributes['carouselOptions']['navigation']['color'] : '',
	'bg_hover'   => isset( $attributes['carouselOptions']['navigation']['backgroundColorHover'] ) ? $attributes['carouselOptions']['navigation']['backgroundColorHover'] : '',
	'icon_hover' => isset( $attributes['carouselOptions']['navigation']['colorHover'] ) ? $attributes['carouselOptions']['navigation']['colorHover'] : '',
);

$block_styles = "
#$block_id .swiper-container {
    max-height: {$styles['height']}px;
}

#$block_id .swiper-button-prev::after,
#$block_id .swiper-button-next::after {
    font-size: {$nav['size']}px;
}
#$block_id .swiper-button-prev,
#$block_id .swiper-button-next {
    width: {$styles['box_width']}px;
    height: {$styles['box_height']}px;
    border-radius: {$styles['radius']}px;
    color: {$nav_color['icon']};
    background-color: {$nav_color['bg']};
    margin-top: {$styles['margin']['top']}px;
}
#$block_id .swiper-button-prev:hover,
#$block_id .swiper-button-next:hover {
    color: {$nav_color['icon_hover']};
    background-color: {$nav_color['bg_hover']};
}
#$block_id .swiper-button-prev {
    right: var(--swiper-navigation-sides-offset, {$styles['gap']}px);
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
