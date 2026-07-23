<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozyProductCategory_' . str_replace( '-', '_', $client_id );

wp_localize_script( 'cozy-block--product-category--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--product-category--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockProductCategoryInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$styles = array(
	'align' => isset( $attributes['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['textAlign'] ) ) : '',
);

$grid = array(
	'column' => isset( $attributes['gridOptions']['displayColumn'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['displayColumn'] ) : '',
	'gap'    => isset( $attributes['gridOptions']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['gap'] ) : '',
);

$width1 = $attributes['gridOptions']['displayColumn'] <= 3 ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['displayColumn'] ) : 3;
$width2 = $attributes['gridOptions']['displayColumn'] <= 2 ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['displayColumn'] ) : 2;

$wrapper_attributes = get_block_wrapper_attributes();

$item_padding = isset( $attributes['containerStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['containerStyles']['padding'] ) : '';
$item_border  = isset( $attributes['containerStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['containerStyles']['border'] ) : '';
$item_radius  = isset( $attributes['containerStyles']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['containerStyles']['radius'] ) : '';
$item_styles  = array(
	'content_gap'        => isset( $attributes['gridOptions']['contentGap'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['contentGap'] ) : '',
	'stack_layout'       => isset( $attributes['gridOptions']['stackLayout'] ) && filter_var( $attributes['gridOptions']['stackLayout'], FILTER_VALIDATE_BOOLEAN ) ? 'wrap' : '',
	'align_items'        => isset( $attributes['gridOptions']['alignItems'] ) ? esc_attr( sanitize_text_field( $attributes['gridOptions']['alignItems'] ) ) : '',
	'shadow'             => array(
		'horizontal' => isset( $attributes['containerStyles']['boxShadow']['horizontal'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['containerStyles']['boxShadow']['vertical'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['containerStyles']['boxShadow']['blur'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['blur'] ) : '',
		'spread'     => isset( $attributes['containerStyles']['boxShadow']['spread'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['spread'] ) : '',
		'position'   => isset( $attributes['containerStyles']['boxShadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['boxShadow']['position'] ) ) : '',
	),
	'font_size'          => isset( $attributes['containerStyles']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['containerStyles']['fontSize'] ) : '',
	'font_weight'        => isset( $attributes['containerStyles']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['fontWeight'] ) ) : '',
	'font_family'        => isset( $attributes['containerStyles']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['fontFamily'] ) ) : '',
	'letter_case'        => isset( $attributes['containerStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['letterCase'] ) ) : '',
	'decoration'         => isset( $attributes['containerStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['decoration'] ) ) : '',
	'line_height'        => isset( $attributes['containerStyles']['lineHeight'] ) ? esc_attr( $attributes['containerStyles']['lineHeight'] ) : '',
	'letter_spacing'     => isset( $attributes['containerStyles']['letterSpacing'] ) ? esc_attr( $attributes['containerStyles']['letterSpacing'] ) : '',
	'bg_color'           => isset( $attributes['containerStyles']['bgColor'] ) ? esc_attr( $attributes['containerStyles']['bgColor'] ) : '',
	'bg_color_hover'     => isset( $attributes['containerStyles']['bgColorHover'] ) ? esc_attr( $attributes['containerStyles']['bgColorHover'] ) : '',
	'border_color_hover' => isset( $attributes['containerStyles']['borderColorHover'] ) ? esc_attr( $attributes['containerStyles']['borderColorHover'] ) : '',
	'shadow_color'       => isset( $attributes['containerStyles']['boxShadow']['color'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['color'] ) : '',
);

$img = array(
	'margin' => array(
		'bottom' => isset( $attributes['featuredImage']['marginBottom'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredImage']['marginBottom'] ) : '',
	),
	'width'  => isset( $attributes['featuredImage']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredImage']['width'] ) : '',
	'height' => isset( $attributes['featuredImage']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredImage']['height'] ) : '',
	'radius' => isset( $attributes['featuredImage']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredImage']['radius'] ) : '',
);

$count_padding = isset( $attributes['productCount']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['productCount']['padding'] ) : '';
$count_border  = isset( $attributes['productCount']['border'] ) ? cozy_render_TRBL( 'border', $attributes['productCount']['border'] ) : '';
$count_radius  = isset( $attributes['productCount']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['productCount']['radius'] ) : '';
$count_styles  = array(
	'top'            => isset( $attributes['productCount']['top'] ) ? esc_attr( $attributes['productCount']['top'] ) : '',
	'left'           => isset( $attributes['productCount']['left'] ) ? esc_attr( $attributes['productCount']['left'] ) : '',
	'right'          => isset( $attributes['productCount']['right'] ) ? esc_attr( $attributes['productCount']['right'] ) : '',
	'margin'         => array(
		'top'    => isset( $attributes['productCount']['marginTop'] ) ? esc_attr( $attributes['productCount']['marginTop'] ) : '',
		'bottom' => isset( $attributes['productCount']['marginBottom'] ) ? esc_attr( $attributes['productCount']['marginBottom'] ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['productCount']['fontSize'] ) ? esc_attr( $attributes['productCount']['fontSize'] ) : '',
		'weight' => isset( $attributes['productCount']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['productCount']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['productCount']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['productCount']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['productCount']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['productCount']['letterCase'] ) ) : 'none',
	'decoration'     => isset( $attributes['productCount']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['productCount']['decoration'] ) ) : 'none',
	'line_height'    => isset( $attributes['productCount']['lineHeight'] ) ? esc_attr( $attributes['productCount']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['productCount']['letterSpacing'] ) ? esc_attr( $attributes['productCount']['letterSpacing'] ) : '',
	'color'          => isset( $attributes['productCount']['color'] ) ? esc_attr( sanitize_text_field( $attributes['productCount']['color'] ) ) : '',
	'bg_color'       => isset( $attributes['productCount']['bgColor'] ) ? esc_attr( sanitize_text_field( $attributes['productCount']['bgColor'] ) ) : '',
);

$nav_border = isset( $attributes['navigation']['border'] ) ? cozy_render_TRBL( 'border', $attributes['navigation']['border'] ) : '';
$nav        = array(
	'box_width'          => isset( $attributes['navigation']['boxWidth'] ) ? esc_attr( $attributes['navigation']['boxWidth'] ) : '',
	'box_height'         => isset( $attributes['navigation']['boxHeight'] ) ? esc_attr( $attributes['navigation']['boxHeight'] ) : '',
	'size'               => isset( $attributes['navigation']['size'] ) ? esc_attr( $attributes['navigation']['size'] ) : '',
	'radius'             => isset( $attributes['navigation']['radius'] ) ? esc_attr( $attributes['navigation']['radius'] ) : '',
	'color'              => isset( $attributes['navigation']['color'] ) ? $attributes['navigation']['color'] : '',
	'color_hover'        => isset( $attributes['navigation']['colorHover'] ) ? $attributes['navigation']['colorHover'] : '',
	'bg_color'           => isset( $attributes['navigation']['bgColor'] ) ? $attributes['navigation']['bgColor'] : '',
	'bg_color_hover'     => isset( $attributes['navigation']['bgColorHover'] ) ? $attributes['navigation']['bgColorHover'] : '',
	'border_color_hover' => isset( $attributes['navigation']['borderColorHover'] ) ? $attributes['navigation']['borderColorHover'] : '',
);

$bullet         = array(
	'gap'    => isset( $attributes['pagination']['gap'] ) ? esc_attr( $attributes['pagination']['gap'] ) : '',
	'bottom' => isset( $attributes['pagination']['verticalPosition'] ) ? esc_attr( $attributes['pagination']['verticalPosition'] ) : '',
	'align'  => isset( $attributes['pagination']['align'] ) ? $attributes['pagination']['align'] : 'center',
	'left'   => isset( $attributes['pagination']['align'], $attributes['pagination']['left'] ) && 'left' === $attributes['pagination']['align'] ? 'padding-left: ' . $attributes['pagination']['left'] . ';' : '',
	'right'  => isset( $attributes['pagination']['align'], $attributes['pagination']['right'] ) && 'right' === $attributes['pagination']['align'] ? 'padding-right: ' . $attributes['pagination']['right'] . ';' : '',
	'width'  => isset( $attributes['pagination']['default']['width'] ) ? esc_attr( $attributes['pagination']['default']['width'] ) : '',
	'height' => isset( $attributes['pagination']['default']['height'] ) ? esc_attr( $attributes['pagination']['default']['height'] ) : '',
	'radius' => isset( $attributes['pagination']['default']['radius'] ) ? esc_attr( $attributes['pagination']['default']['radius'] ) : '',
	'active' => array(
		'width'  => isset( $attributes['pagination']['active']['width'] ) ? esc_attr( $attributes['pagination']['active']['width'] ) : '',
		'height' => isset( $attributes['pagination']['active']['height'] ) ? esc_attr( $attributes['pagination']['active']['height'] ) : '',
		'radius' => isset( $attributes['pagination']['active']['radius'] ) ? esc_attr( $attributes['pagination']['active']['radius'] ) : '',
		'offset' => isset( $attributes['pagination']['active']['offset'] ) ? esc_attr( $attributes['pagination']['active']['offset'] ) : '',
	),
);
$bullet_outline = isset( $attributes['pagination']['active']['border'] ) ? cozy_render_TRBL( 'outline', $attributes['pagination']['active']['border'] ) : '';
$bullet_styles  = array(
	'default_color'       => isset( $attributes['pagination']['default']['color'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['default']['color'] ) ) : '',
	'default_color_hover' => isset( $attributes['pagination']['default']['colorHover'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['default']['colorHover'] ) ) : '',
	'active_color'        => isset( $attributes['pagination']['active']['color'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['active']['color'] ) ) : '',
	'active_color_hover'  => isset( $attributes['pagination']['active']['colorHover'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['active']['colorHover'] ) ) : '',
);

$block_styles = "
#$block_id {
	text-align: {$styles['align']};
}

#$block_id.display-grid .woo-product-category-wrapper {
    grid-template-columns: repeat({$grid['column']}, 1fr);
    row-gap: {$grid['gap']};
    column-gap: {$grid['gap']};
}
@media screen and (max-width: 1024px) {
    .cozy-block-product-category.display-grid .woo-product-category-wrapper {
        grid-template-columns: repeat({$width1}, 1fr) !important;
    }
}
@media screen and (max-width: 767px) {
    .cozy-block-product-category.display-grid .woo-product-category-wrapper {
        grid-template-columns: repeat({$width2}, 1fr) !important;
    }
}
@media screen and (max-width: 400px) {
    .cozy-block-product-category.display-grid .woo-product-category-wrapper {
        grid-template-columns: repeat(1, 1fr) !important;
    }
}

#$block_id .woo-product-category{
	{$item_padding}
	{$item_border}
	{$item_radius}
	background-color: {$item_styles['bg_color']};
}
#$block_id .woo-product-category .woo-product-category__link {
	font-size: {$item_styles['font_size']};
	font-weight: {$item_styles['font_weight']};
	font-family: {$item_styles['font_family']};
	text-transform: {$item_styles['letter_case']};
	text-decoration: {$item_styles['decoration']};
	line-height: {$item_styles['line_height']};
	letter-spacing: {$item_styles['letter_spacing']};
}
#$block_id.display-grid .woo-product-category.has-invert-layout  .woo-product-category__link {
	gap: {$item_styles['content_gap']};
	flex-wrap: {$item_styles['stack_layout']};
	align-items: {$item_styles['align_items']};
} 
#$block_id.has-box-shadow .woo-product-category {
    box-shadow: {$item_styles['shadow']['horizontal']}px {$item_styles['shadow']['vertical']}px {$item_styles['shadow']['blur']}px {$item_styles['shadow']['spread']}px {$item_styles['shadow_color']} {$item_styles['shadow']['position']};
}
#$block_id .woo-product-category:hover {
	background-color: {$item_styles['bg_color_hover']};
	border-color: {$item_styles['border_color_hover']};
}

#$block_id .cozy-block-product-category__image {
    margin-bottom: {$img['margin']['bottom']};
    max-height: {$img['height']};
    border-radius: {$img['radius']};
}
#$block_id .cozy-block-product-category__image img {
    width: {$img['width']};
    height: {$img['height']};
    border-radius: {$img['radius']};
}

#$block_id .woo-product-category .product-count {
	{$count_padding}
	margin-top: {$count_styles['margin']['top']};
	margin-bottom: {$count_styles['margin']['bottom']};
	{$count_border}
	{$count_radius}
	font-size: {$count_styles['font']['size']};
	font-family: {$count_styles['font']['family']};
	font-weight: {$count_styles['font']['weight']};
	text-transform: {$count_styles['letter_case']};
	text-decoration: {$count_styles['decoration']};
	line-height: {$count_styles['line_height']};
	letter-spacing: {$count_styles['letter_spacing']};
	color: {$count_styles['color']};
	background-color: {$count_styles['bg_color']};
}
#$block_id .cozy-block-product-category__stacked .product-count {
    top: {$count_styles['top']}px;
}
#$block_id.product-count-position-left .cozy-block-product-category__stacked .product-count {
    left: {$count_styles['left']}px;
    right: auto;
}
#$block_id.product-count-position-right .cozy-block-product-category__stacked .product-count {
    right: {$count_styles['right']}px;
    left: auto;
}

#$block_id .swiper-button-prev::after,
#$block_id .swiper-button-next::after {
	font-size: {$nav['size']};
}
#$block_id .swiper-button-prev,
#$block_id .swiper-button-next {
	width: {$nav['box_width']};
	height: {$nav['box_height']};
	{$nav_border}
	border-radius: {$nav['radius']};
	color: {$nav['color']};
	background-color: {$nav['bg_color']};
}
#$block_id .swiper-button-prev:hover,
#$block_id .swiper-button-next:hover {
	color: {$nav['color_hover']};
	background-color: {$nav['bg_color_hover']};
	border-color: {$nav['border_color_hover']};
}

#$block_id .swiper-pagination {
	bottom: {$bullet['bottom']}px;
	text-align: {$bullet['align']};
    {$bullet['left']}
    {$bullet['right']}
}
#$block_id .swiper-pagination .swiper-pagination-bullet {
	width: {$bullet['width']};
	height: {$bullet['height']};
	border-radius: {$bullet['radius']};
	background-color: {$bullet_styles['default_color']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active {
	width: {$bullet['active']['width']};
	height: {$bullet['active']['height']};
	border-radius: {$bullet['active']['radius']};
	background-color: {$bullet_styles['active_color']};
	{$bullet_outline}
	outline-offset: {$bullet['active']['offset']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet:hover {
	background-color: {$bullet_styles['default_color_hover']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active:hover {
	background-color: {$bullet_styles['active_color_hover']};
}
#$block_id.swiper-horizontal .swiper-pagination-bullets .swiper-pagination-bullet {
	margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$bullet['gap']});
}
#$block_id.swiper-vertical .swiper-pagination-bullets .swiper-pagination-bullet {
	margin: var(--swiper-pagination-bullet-vertical-gap, {$bullet['gap']}) 0;
}
";

$classes   = array();
$classes[] = 'cozy-block-product-category';
$classes[] = 'display-' . $attributes['display'];
$classes[] = 'cozy-product-category__swiper-container';
$classes[] = $attributes['navigation']['hoverShow'] ? 'hover-show' : '';
$classes[] = $attributes['containerStyles']['boxShadow']['enabled'] ? 'has-box-shadow' : '';
$classes[] = $attributes['featuredImage']['hoverEffect'] ? 'has-image-hover-effect' : '';
$classes[] = 'product-count-position-' . $attributes['productCount']['position'];

$output = '<div class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '" id="' . esc_attr( $block_id ) . '">';

$wrapper_classes   = array();
$wrapper_classes[] = 'woo-product-category-wrapper';
$wrapper_classes[] = 'carousel' === $attributes['display'] ? 'swiper-wrapper' : '';
$output           .= '<ul class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $wrapper_classes ) ) ) ) ) . '">';

// Loop through categories.
$args = array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'number'     => -1 != $attributes['perPage'] ? $attributes['perPage'] : 10,
	'order'      => 'DESC',
	'orderby'    => 'count',
);

$categories = get_terms( $args );
foreach ( $categories as $product_cat ) {
	$cat_item_classes   = array();
	$cat_item_classes[] = 'woo-product-category';
	$cat_item_classes[] = isset( $attributes['gridOptions']['invertLayout'] ) && filter_var( $attributes['gridOptions']['invertLayout'], FILTER_VALIDATE_BOOLEAN ) ? 'has-invert-layout' : '';
	$cat_item_classes[] = 'carousel' === $attributes['display'] ? 'swiper-slide' : '';
	$output            .= '<li class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $cat_item_classes ) ) ) ) ) . '">';
	$cat_link           = get_category_link( $product_cat->term_id );
	$open_new_tab       = isset( $attributes['enableOptions']['linkNewTab'] ) && $attributes['enableOptions']['linkNewTab'] ? '_blank' : '';
	$output            .= '<a class="woo-product-category__link" href="' . esc_url( $cat_link ) . '" target="' . $open_new_tab . '" rel="noopener">';

	$output      .= '<div class="cozy-block-product-category__stacked" style="position:relative">';
	$thumbnail_id = get_term_meta( $product_cat->term_id, 'thumbnail_id', true );
	// get the image URL.
	$image_url = wp_get_attachment_url( $thumbnail_id );
	if ( $attributes['enableOptions']['image'] && isset( $image_url ) && ! empty( $image_url ) ) {
		$output .= '<figure class="cozy-block-product-category__image">';
		$output .= '<img src="' . esc_url( $image_url ) . '" />';
		$output .= '</figure>';
	}
	if ( $attributes['enableOptions']['count'] && 'badge' === $attributes['productCount']['display'] ) {
		$output .= '<div class="product-count-wrapper">';
		$output .= '<span class="product-count">';
		$output .= esc_html( $attributes['productCount']['labelBefore'] ) . esc_html( $product_cat->count ) . esc_html( $attributes['productCount']['labelAfter'] );
		$output .= '</span>';
		$output .= '</div>';
	}
	$output .= '</div>';

	if ( $attributes['enableOptions']['name'] ) {
		$output .= '<div class="category-name">' . esc_html( $product_cat->name ) . '</div>';
	}

	if ( $attributes['enableOptions']['count'] && 'default' === $attributes['productCount']['display'] ) {
		$output .= '<div class="product-count-wrapper">';
		$output .= '<span class="product-count">';
		$output .= esc_html( $attributes['productCount']['labelBefore'] ) . esc_html( $product_cat->count ) . esc_html( $attributes['productCount']['labelAfter'] );
		$output .= '</span>';
		$output .= '</div>';
	}

	$output .= '</a>';
	$output .= '</li>';
}

$output .= '</ul>';

wp_reset_postdata();

// Swiper Pagination and Navigation.
if ( 'carousel' === $attributes['display'] ) {
	if ( $attributes['navigation']['enabled'] ) {
		$output .= '<div class="swiper-button-prev cozy-block-button-prev"></div>';
		$output .= '<div class="swiper-button-next cozy-block-button-next"></div>';
	}
	if ( $attributes['pagination']['enabled'] ) {
		$output .= '<div class="swiper-pagination cozy-pagination"></div>';
	}
}
$output .= '</div>';

$font_families = array();

if ( isset( $attributes['containerStyles']['fontFamily'] ) && ! empty( $attributes['containerStyles']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['containerStyles']['fontFamily'] );
}
if ( isset( $attributes['productCount']['fontFamily'] ) && ! empty( $attributes['productCount']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['productCount']['fontFamily'] );
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

$render = sprintf( '<div class="cozy-block-wrapper cozy-block-product-category-wrapper display-' . esc_attr( sanitize_html_class( $attributes['display'] ) ) . '"><div %1$s>%2$s</div></div>', $wrapper_attributes, $output );
echo $render;
