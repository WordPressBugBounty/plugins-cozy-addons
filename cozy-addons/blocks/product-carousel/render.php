<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozyProductCarousel_' . str_replace( '-', '_', $client_id );

$currency_symbol                = get_woocommerce_currency_symbol();
$currency_position              = get_option( 'woocommerce_currency_pos' );
$attributes['currencySymbol']   = $currency_symbol;
$attributes['currencyPosition'] = $currency_position;

wp_localize_script( 'cozy-block--product-carousel--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--product-carousel--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockProductCarouselInit( "' . esc_html( $client_id ) . '" ) }) ' );

$width1 = $attributes['gridOptions']['displayColumn'] <= 3 ? esc_attr( $attributes['gridOptions']['displayColumn'] ) : 3;
$width2 = $attributes['gridOptions']['displayColumn'] <= 2 ? esc_attr( $attributes['gridOptions']['displayColumn'] ) : 2;

$grid = array(
	'column' => isset( $attributes['gridOptions']['displayColumn'] ) ? esc_attr( sanitize_text_field( $attributes['gridOptions']['displayColumn'] ) ) : '',
	'gap'    => isset( $attributes['gridOptions']['columnGap'] ) ? esc_attr( sanitize_text_field( $attributes['gridOptions']['columnGap'] ) ) : '',
);

$sale_badge_font_size   = isset( $attributes['saleBadge']['typography']['fontSize'] ) ? esc_attr( $attributes['saleBadge']['typography']['fontSize'] ) : '';
$sale_badge_font_weight = isset( $attributes['saleBadge']['typography']['fontWeight'] ) ? esc_attr( $attributes['saleBadge']['typography']['fontWeight'] ) : '';
$sale_badge_font_family = isset( $attributes['saleBadge']['typography']['fontFamily'] ) ? esc_attr( $attributes['saleBadge']['typography']['fontFamily'] ) : '';
$sale_badge_font_color  = isset( $attributes['saleBadge']['typography']['color'] ) ? esc_attr( $attributes['saleBadge']['typography']['color'] ) : '';
$sale_badge             = array(
	'padding'        => array(
		'top'    => isset( $attributes['saleBadge']['padding']['top'] ) ? esc_attr( $attributes['saleBadge']['padding']['top'] ) : '',
		'right'  => isset( $attributes['saleBadge']['padding']['right'] ) ? esc_attr( $attributes['saleBadge']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['saleBadge']['padding']['bottom'] ) ? esc_attr( $attributes['saleBadge']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['saleBadge']['padding']['left'] ) ? esc_attr( $attributes['saleBadge']['padding']['left'] ) : '',
	),
	'margin'         => array(
		'bottom' => isset( $attributes['saleBadge']['marginBottom'] ) ? esc_attr( $attributes['saleBadge']['marginBottom'] ) : '',
	),
	'gap'            => isset( $attributes['saleBadge']['gap'] ) ? esc_attr( $attributes['saleBadge']['gap'] ) : '',
	'border'         => array(
		'width' => isset( $attributes['saleBadge']['borderWidth'] ) ? esc_attr( $attributes['saleBadge']['borderWidth'] ) : '',
		'style' => isset( $attributes['saleBadge']['borderType'] ) ? esc_attr( sanitize_text_field( $attributes['saleBadge']['borderType'] ) ) : '',
		'color' => isset( $attributes['saleBadge']['borderColor'] ) ? esc_attr( sanitize_text_field( $attributes['saleBadge']['borderColor'] ) ) : '',
	),
	'radius'         => isset( $attributes['saleBadge']['borderRadius'] ) ? esc_attr( $attributes['saleBadge']['borderRadius'] ) : '',
	'rotate'         => isset( $attributes['saleBadge']['rotate'] ) ? esc_attr( $attributes['saleBadge']['rotate'] ) : '',
	'top'            => isset( $attributes['saleBadge']['top'] ) ? esc_attr( $attributes['saleBadge']['top'] ) : '',
	'left'           => isset( $attributes['saleBadge']['left'] ) ? esc_attr( $attributes['saleBadge']['left'] ) : '',
	'right'          => isset( $attributes['saleBadge']['right'] ) ? esc_attr( $attributes['saleBadge']['right'] ) : '',
	'letter_case'    => isset( $attributes['saleBadge']['typography']['letterCase'] ) ? esc_attr( $attributes['saleBadge']['typography']['letterCase'] ) : '',
	'line_height'    => isset( $attributes['saleBadge']['typography']['lineHeight'] ) ? esc_attr( $attributes['saleBadge']['typography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['saleBadge']['typography']['letterSpacing'] ) ? esc_attr( $attributes['saleBadge']['typography']['letterSpacing'] ) : '',
);

$sale_badge_label = array(
	'font_size'      => isset( $attributes['saleBadge']['labelTypography']['fontSize'] ) ? esc_attr( $attributes['saleBadge']['labelTypography']['fontSize'] ) : '',
	'font_weight'    => isset( $attributes['saleBadge']['labelTypography']['fontWeight'] ) ? esc_attr( $attributes['saleBadge']['labelTypography']['fontWeight'] ) : '',
	'font_family'    => isset( $attributes['saleBadge']['labelTypography']['fontFamily'] ) ? esc_attr( $attributes['saleBadge']['labelTypography']['fontFamily'] ) : '',
	'letter_case'    => isset( $attributes['saleBadge']['labelTypography']['letterCase'] ) ? esc_attr( $attributes['saleBadge']['labelTypography']['letterCase'] ) : '',
	'line_height'    => isset( $attributes['saleBadge']['labelTypography']['lineHeight'] ) ? esc_attr( $attributes['saleBadge']['labelTypography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['saleBadge']['labelTypography']['letterSpacing'] ) ? esc_attr( $attributes['saleBadge']['labelTypography']['letterSpacing'] ) : '',
);

$sale_badge_color = array(
	'text' => isset( $attributes['saleBadge']['labelTypography']['color'] ) ? $attributes['saleBadge']['labelTypography']['color'] : '',
	'bg'   => isset( $attributes['saleBadge']['bgColor'] ) ? $attributes['saleBadge']['bgColor'] : '',
);

$read_more_color = array(
	'bg_hover'   => isset( $attributes['buttonHoverColor']['background'] ) ? $attributes['buttonHoverColor']['background'] : '',
	'text_hover' => isset( $attributes['buttonHoverColor']['text'] ) ? $attributes['buttonHoverColor']['text'] : '',
);

$rating = array(
	'size' => isset( $attributes['reviewStyles']['fontSize'] ) ? esc_attr( $attributes['reviewStyles']['fontSize'] ) : '',
);

$rating_color = array(
	'icon' => isset( $attributes['reviewStyles']['color'] ) ? $attributes['reviewStyles']['color'] : '',
);

$nav       = array(
	'box_width'  => isset( $attributes['navigation']['iconBoxWidth'] ) ? esc_attr( $attributes['navigation']['iconBoxWidth'] ) : '',
	'box_height' => isset( $attributes['navigation']['iconBoxHeight'] ) ? esc_attr( $attributes['navigation']['iconBoxHeight'] ) : '',
	'radius'     => isset( $attributes['navigation']['iconBoxRadius'] ) ? esc_attr( $attributes['navigation']['iconBoxRadius'] ) : '',
	'size'       => isset( $attributes['navigation']['iconSize'] ) ? esc_attr( $attributes['navigation']['iconSize'] ) : '',
	'border'     => isset( $attributes['navigation']['border'] ) ? cozy_render_TRBL( 'border', $attributes['navigation']['border'] ) : '',
);
$nav_color = array(
	'icon'         => isset( $attributes['navigation']['color'] ) ? $attributes['navigation']['color'] : '',
	'bg'           => isset( $attributes['navigation']['backgroundColor'] ) ? $attributes['navigation']['backgroundColor'] : '',
	'icon_hover'   => isset( $attributes['navigation']['colorHover'] ) ? $attributes['navigation']['colorHover'] : '',
	'bg_hover'     => isset( $attributes['navigation']['backgroundColorHover'] ) ? $attributes['navigation']['backgroundColorHover'] : '',
	'border_hover' => isset( $attributes['navigation']['borderHover'] ) ? $attributes['navigation']['borderHover'] : '',
);

$bullet       = array(
	'bottom' => isset( $attributes['pagination']['verticalPosition'] ) ? esc_attr( $attributes['pagination']['verticalPosition'] ) : '',
	'align'  => isset( $attributes['pagination']['align'] ) ? $attributes['pagination']['align'] : 'center',
	'left'   => isset( $attributes['pagination']['align'], $attributes['pagination']['left'] ) && 'left' === $attributes['pagination']['align'] ? 'padding-left: ' . $attributes['pagination']['left'] . ';' : '',
	'right'  => isset( $attributes['pagination']['align'], $attributes['pagination']['right'] ) && 'right' === $attributes['pagination']['align'] ? 'padding-right: ' . $attributes['pagination']['right'] . ';' : '',
	'width'  => isset( $attributes['pagination']['width'] ) ? esc_attr( $attributes['pagination']['width'] ) : '',
	'height' => isset( $attributes['pagination']['height'] ) ? esc_attr( $attributes['pagination']['height'] ) : '',
	'radius' => isset( $attributes['pagination']['borderRadius'] ) ? esc_attr( $attributes['pagination']['borderRadius'] ) : '',
	'active' => array(
		'width'  => isset( $attributes['pagination']['activeWidth'] ) ? esc_attr( $attributes['pagination']['activeWidth'] ) : '',
		'height' => isset( $attributes['pagination']['activeHeight'] ) ? esc_attr( $attributes['pagination']['activeHeight'] ) : '',
		'border' => isset( $attributes['pagination']['activeBorder'] ) ? cozy_render_TRBL( 'outline', $attributes['pagination']['activeBorder'] ) : '',
		'offset' => isset( $attributes['pagination']['activeOffset'] ) ? esc_attr( $attributes['pagination']['activeOffset'] ) : '',
		'radius' => isset( $attributes['pagination']['activeBorderRadius'] ) ? esc_attr( $attributes['pagination']['activeBorderRadius'] ) : '',
	),
	'gap'    => isset( $attributes['pagination']['gap'] ) ? esc_attr( $attributes['pagination']['gap'] ) : 4,
);
$bullet_color = array(
	'default'       => isset( $attributes['pagination']['color'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['color'] ) ) : '',
	'active'        => isset( $attributes['pagination']['activeColor'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['activeColor'] ) ) : '',
	'default_hover' => isset( $attributes['pagination']['colorHover'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['colorHover'] ) ) : '',
	'active_hover'  => isset( $attributes['pagination']['activeColorHover'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['activeColorHover'] ) ) : '',
);

$block_id     = 'cozyBlock_' . str_replace( '-', '_', $client_id );
$block_styles = "
#$block_id.layout-grid .cozy-layout-grid {
    grid-template-columns: repeat({$grid['column']}, 1fr);
    gap: {$grid['gap']}px;
}
@media screen and (max-width: 1024px) {
    #$block_id.layout-grid .cozy-layout-grid {
        grid-template-columns: repeat({$width1}, 1fr) !important;
    }
}
@media screen and (max-width: 767px) {
    #$block_id.layout-grid .cozy-layout-grid {
        grid-template-columns: repeat({$width2}, 1fr) !important;
    }
}
@media screen and (max-width: 400px) {
    #$block_id.layout-grid .cozy-layout-grid {
        grid-template-columns: repeat(1, 1fr) !important;
    }
}

#$block_id.on-sale .cozy-sale-badge {
    padding-top: {$sale_badge['padding']['top']}px;
    padding-right: {$sale_badge['padding']['right']}px;
    padding-bottom: {$sale_badge['padding']['bottom']}px;
    padding-left: {$sale_badge['padding']['left']}px;
    border-width: {$sale_badge['border']['width']}px;
	border-style: {$sale_badge['border']['style']};
	border-color: {$sale_badge['border']['color']};
    border-radius: {$sale_badge['radius']}px;
    background-color: {$sale_badge_color['bg']};
    transform: rotate({$sale_badge['rotate']}deg);
    top: {$sale_badge['top']}px;
    font-size: {$sale_badge_font_size}px;
    font-weight: {$sale_badge_font_weight};
    font-family: {$sale_badge_font_family};
	text-transform: {$sale_badge['letter_case']};
	line-height: {$sale_badge['line_height']};
	letter-spacing: {$sale_badge['letter_spacing']};
    color: {$sale_badge_font_color};
}
#$block_id.on-sale.sale-badge-display-block .cozy-sale-badge * {
    margin-bottom: {$sale_badge['margin']['bottom']}px;
}
#$block_id.on-sale.sale-badge-display-flex .cozy-sale-badge {
    gap: {$sale_badge['gap']}px;
}
#$block_id.on-sale.sale-badge-position-left .cozy-sale-badge{
    left: {$sale_badge['left']}px;
}
#$block_id.on-sale.sale-badge-position-right .cozy-sale-badge{
    right: {$sale_badge['right']}px;
}
#$block_id.on-sale .cozy-sale-badge .label-before,
#$block_id.on-sale .cozy-sale-badge .label-after {
    font-size: {$sale_badge_label['font_size']}px;
    font-weight: {$sale_badge_label['font_weight']};
    font-family: {$sale_badge_label['font_family']};
	text-transform: {$sale_badge_label['letter_case']};
	line-height: {$sale_badge_label['line_height']};
	letter-spacing: {$sale_badge_label['letter_spacing']};
    color: {$sale_badge_color['text']};
}

#$block_id .cozy-template-two .wp-block-read-more:hover,
#$block_id .cozy-template-two .wp-block-button.wc-block-components-product-button:hover button,
#$block_id .cozy-template-two .wp-block-button.wc-block-components-product-button:hover a {
    background-color: {$read_more_color['bg_hover']} !important;
    color: {$read_more_color['text_hover']} !important;
    opacity: 1 !important;
}

#$block_id .wc-block-components-product-rating__stars {
    font-size: {$rating['size']}px;
    color: {$rating_color['icon']};
}

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

#$block_id .swiper-pagination-bullets .swiper-pagination-bullet {
	margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$bullet['gap']}px);
}
#$block_id .swiper-pagination {
    bottom: {$bullet['bottom']}px;
    text-align: {$bullet['align']};
    {$bullet['left']}
    {$bullet['right']}
}
#$block_id .swiper-pagination .swiper-pagination-bullet {
    width: {$bullet['width']}px;
    height: {$bullet['height']}px;
    border-radius: {$bullet['radius']}px;
    background-color: {$bullet_color['default']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active {
    width: {$bullet['active']['width']}px;
	height: {$bullet['active']['height']}px;
	{$bullet['active']['border']}
	outline-offset: {$bullet['active']['offset']}px;
    border-radius: {$bullet['active']['radius']}px;
    background-color: {$bullet_color['active']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet:hover {
    background-color: {$bullet_color['default_hover']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active:hover {
    background-color: {$bullet_color['active_hover']};
}
";

$output = '<div class="cozy-block-wrapper">';

/* Font Family */
$font_families = array();

if ( isset( $attributes['saleBadge']['typography']['fontFamily'] ) && ! empty( $attributes['saleBadge']['typography']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['saleBadge']['typography']['fontFamily'] );
}
if ( isset( $attributes['saleBadge']['labelTypography']['fontFamily'] ) && ! empty( $attributes['saleBadge']['labelTypography']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['saleBadge']['labelTypography']['fontFamily'] );
}
// Remove duplicate font families.
$font_families = array_unique( $font_families );
$font_query    = '';
// Add other fonts.
foreach ( $font_families as $key => $family ) {
	if ( 0 === $key ) {
		$font_query .= 'family=' . str_replace( ' ', '+', esc_attr( $family ) ) . ':wght@100;200;300;400;500;600;700;800;900';
	} else {
		$font_query .= '&family=' . str_replace( ' ', '+', esc_attr( $family ) ) . ':wght@100;200;300;400;500;600;700;800;900';
	}
}
if ( ! empty( $font_query ) ) {
	// Generate the inline style for the Google Fonts link.
	$google_fonts_url = 'https://fonts.googleapis.com/css2?' . $font_query . '&display=swap';

	echo '<link rel="stylesheet" href="' . $google_fonts_url . '"/>';
}

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$output .= $content;


$output .= '</div>';

echo $output;
