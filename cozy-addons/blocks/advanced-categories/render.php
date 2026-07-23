<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['clientId'] ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

wp_localize_script( 'cozy-block--advanced-categories--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--advanced-categories--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockAdvancedCategories( "' . $client_id . '" ) }) ' );

$wrapper_attributes = get_block_wrapper_attributes();

$column1 = isset( $attributes['gridOptions']['columnCount'] ) && $attributes['gridOptions']['columnCount'] <= 3 ? esc_attr( sanitize_text_field( $attributes['gridOptions']['columnCount'] ) ) : 3;
$column2 = isset( $attributes['gridOptions']['columnCount'] ) && $attributes['gridOptions']['columnCount'] <= 2 ? esc_attr( sanitize_text_field( $attributes['gridOptions']['columnCount'] ) ) : 2;

$styles = array(
	'align'  => isset( $attributes['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['textAlign'] ) ) : '',
	'column' => isset( $attributes['gridOptions']['columnCount'] ) ? esc_attr( intval( $attributes['gridOptions']['columnCount'] ) ) : '',
	'gap'    => isset( $attributes['gridOptions']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['gap'] ) : '',
);

$list_styles = array(
	'gap'    => isset( $attributes['listOptions']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['listOptions']['gap'] ) : '',
	'height' => isset( $attributes['listOptions']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['listOptions']['height'] ) : '',
);

$item_div_padding        = cozy_render_TRBL( 'padding', $attributes['categoryItem']['padding'] );
$item_div_border         = isset( $attributes['categoryItem']['border'] ) ? cozy_render_TRBL( 'border', $attributes['categoryItem']['border'] ) : '';
$item_div_radius         = cozy_render_TRBL( 'border-radius', $attributes['categoryItem']['radius'] );
$item_styles             = array(
	'shadow'             => array(
		'horizontal' => isset( $attributes['categoryItem']['shadow']['horizontal'] ) ? esc_attr( $attributes['categoryItem']['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['categoryItem']['shadow']['vertical'] ) ? esc_attr( $attributes['categoryItem']['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['categoryItem']['shadow']['blur'] ) ? esc_attr( $attributes['categoryItem']['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['categoryItem']['shadow']['spread'] ) ? esc_attr( $attributes['categoryItem']['shadow']['spread'] ) : '',
		'position'   => isset( $attributes['categoryItem']['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['categoryItem']['shadow']['position'] ) ) : '',
	),
	'shadow_color'       => isset( $attributes['categoryItem']['shadow']['color'] ) ? esc_attr( $attributes['categoryItem']['shadow']['color'] ) : '',
	'bg_color'           => isset( $attributes['categoryItem']['bgColor'] ) ? esc_attr( $attributes['categoryItem']['bgColor'] ) : '',
	'bg_color_hover'     => isset( $attributes['categoryItem']['bgColorHover'] ) ? esc_attr( $attributes['categoryItem']['bgColorHover'] ) : '',
	'border_color_hover' => isset( $attributes['categoryItem']['borderColorHover'] ) ? esc_attr( $attributes['categoryItem']['borderColorHover'] ) : '',
);
$image_styles            = array(
	'width'        => isset( $attributes['image']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['image']['width'] ) : '',
	'height'       => isset( $attributes['image']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['image']['height'] ) : '',
	'border'       => isset( $attributes['image']['border'] ) ? cozy_render_TRBL( 'border', $attributes['image']['border'] ) : '',
	'radius'       => isset( $attributes['image']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['image']['radius'] ) : '',
	'overlay'      => isset( $attributes['image']['overlayColor'] ) ? esc_attr( $attributes['image']['overlayColor'] ) : '',
	'border_color' => isset( $attributes['image']['borderColorHover'] ) ? cozy_render_TRBL( 'border', $attributes['image']['borderColorHover'] ) : '',
);
$content_wrapper_padding = cozy_render_TRBL( 'padding', $attributes['contentBox']['padding'] );

$title_styles = array(
	'padding'        => isset( $attributes['title']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['title']['padding'] ) : '',
	'radius'         => isset( $attributes['title']['borderRadius'] ) ? cozy_addons_sanitize_dimension( $attributes['title']['borderRadius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['title']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['title']['fontSize'] ) : '',
		'weight' => isset( $attributes['title']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['title']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['title']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['title']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['title']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['title']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['title']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['title']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['title']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['title']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['title']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['title']['letterSpacing'] ) : '',
	'color'          => isset( $attributes['title']['color'] ) ? esc_attr( $attributes['title']['color'] ) : '',
	'bg'             => isset( $attributes['title']['background'] ) ? esc_attr( $attributes['title']['background'] ) : '',
	'color_hover'    => isset( $attributes['title']['colorHover'] ) ? esc_attr( $attributes['title']['colorHover'] ) : '',
	'bg_hover'       => isset( $attributes['title']['backgroundHover'] ) ? esc_attr( $attributes['title']['backgroundHover'] ) : '',
);

$icon_box_padding = isset( $attributes['iconBox']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['iconBox']['padding'] ) : '';
$icon_box_border  = isset( $attributes['iconBox']['border'] ) ? cozy_render_TRBL( 'border', $attributes['iconBox']['border'] ) : '';
$icon_box_styles  = array(
	'radius'             => isset( $attributes['iconBox']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['iconBox']['radius'] ) : '',
	'bg_color'           => isset( $attributes['iconBox']['bgColor'] ) ? esc_attr( $attributes['iconBox']['bgColor'] ) : '',
	'bg_color_hover'     => isset( $attributes['iconBox']['bgColorHover'] ) ? esc_attr( $attributes['iconBox']['bgColorHover'] ) : '',
	'border_color_hover' => isset( $attributes['iconBox']['borderColorHover'] ) ? esc_attr( $attributes['iconBox']['borderColorHover'] ) : '',
);

$icon_opacity = isset( $attributes['icon']['opacity'] ) ? number_format( floatval( $attributes['icon']['opacity'] / 100 ), 2 ) : '';
$icon_styles  = array(
	'size'        => isset( $attributes['icon']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['size'] ) : '',
	'gap'         => isset( $attributes['icon']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['gap'] ) : '',
	'color'       => isset( $attributes['icon']['color'] ) ? esc_attr( $attributes['icon']['color'] ) : $title_styles['color'],
	'color_hover' => isset( $attributes['icon']['colorHover'] ) ? esc_attr( $attributes['icon']['colorHover'] ) : $title_styles['color_hover'],
);

$count_padding = isset( $attributes['postCount']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['postCount']['padding'] ) : '';
$count_border  = isset( $attributes['postCount']['border'] ) ? cozy_render_TRBL( 'border', $attributes['postCount']['border'] ) : '';
$count_radius  = isset( $attributes['postCount']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['postCount']['radius'] ) : '';
$count_styles  = array(
	'color'    => isset( $attributes['postCount']['color'] ) ? esc_attr( $attributes['postCount']['color'] ) : '',
	'bg_color' => isset( $attributes['postCount']['bgColor'] ) ? esc_attr( $attributes['postCount']['bgColor'] ) : '',
);

$nav_border = isset( $attributes['navigation']['border'] ) ? cozy_render_TRBL( 'border', $attributes['navigation']['border'] ) : '';
$nav_styles = array(
	'size'               => isset( $attributes['navigation']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['navigation']['size'] ) : '',
	'box_width'          => isset( $attributes['navigation']['boxWidth'] ) ? cozy_addons_sanitize_dimension( $attributes['navigation']['boxWidth'] ) : '',
	'box_height'         => isset( $attributes['navigation']['boxHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['navigation']['boxHeight'] ) : '',
	'radius'             => isset( $attributes['navigation']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['navigation']['radius'] ) : '',
	'color'              => isset( $attributes['navigation']['color'] ) ? esc_attr( $attributes['navigation']['color'] ) : '',
	'color_hover'        => isset( $attributes['navigation']['colorHover'] ) ? esc_attr( $attributes['navigation']['colorHover'] ) : '',
	'bg_color'           => isset( $attributes['navigation']['bgColor'] ) ? esc_attr( $attributes['navigation']['bgColor'] ) : '',
	'bg_color_hover'     => isset( $attributes['navigation']['bgColorHover'] ) ? esc_attr( $attributes['navigation']['bgColorHover'] ) : '',
	'border_color_hover' => isset( $attributes['navigation']['borderColorHover'] ) ? esc_attr( $attributes['navigation']['borderColorHover'] ) : '',
);

$bullet         = array(
	'gap'                   => isset( $attributes['pagination']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['gap'] ) : '',
	'position'              => isset( $attributes['pagination']['verticalPosition'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['verticalPosition'] ) : '',
	'align'                 => isset( $attributes['pagination']['align'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['align'] ) ) : 'center',
	'left'                  => isset( $attributes['pagination']['align'], $attributes['pagination']['left'] ) && 'left' === $attributes['pagination']['align'] ? 'padding-left: ' . cozy_addons_sanitize_dimension( $attributes['pagination']['left'] ) . ';' : '',
	'right'                 => isset( $attributes['pagination']['align'], $attributes['pagination']['right'] ) && 'right' === $attributes['pagination']['align'] ? 'padding-right: ' . cozy_addons_sanitize_dimension( $attributes['pagination']['right'] ) . ';' : '',
	'width'                 => isset( $attributes['pagination']['default']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['default']['width'] ) : '',
	'height'                => isset( $attributes['pagination']['default']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['default']['height'] ) : '',
	'radius'                => isset( $attributes['pagination']['default']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['default']['radius'] ) : '',
	'width_active'          => isset( $attributes['pagination']['active']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['active']['width'] ) : '',
	'height_active'         => isset( $attributes['pagination']['active']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['active']['height'] ) : '',
	'radius_active'         => isset( $attributes['pagination']['active']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['active']['radius'] ) : '',
	'outline_offset_active' => isset( $attributes['pagination']['active']['offset'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['active']['offset'] ) : '',
);
$bullet_outline = isset( $attributes['pagination']['active']['border'] ) ? cozy_render_TRBL( 'outline', $attributes['pagination']['active']['border'] ) : '';
$bullet_styles  = array(
	'default_color'       => isset( $attributes['pagination']['default']['color'] ) ? esc_attr( $attributes['pagination']['default']['color'] ) : '',
	'default_color_hover' => isset( $attributes['pagination']['default']['colorHover'] ) ? esc_attr( $attributes['pagination']['default']['colorHover'] ) : '',
	'active_color'        => isset( $attributes['pagination']['active']['color'] ) ? esc_attr( $attributes['pagination']['active']['color'] ) : '',
	'active_color_hover'  => isset( $attributes['pagination']['active']['colorHover'] ) ? esc_attr( $attributes['pagination']['active']['colorHover'] ) : '',
);

// Block Styles START.
$block_styles = "
#$block_id {
    text-align: {$styles['align']};
}

#$block_id.display-grid .grid-wrapper {
    grid-template-columns: repeat({$styles['column']}, 1fr);
    gap: {$styles['gap']};
}
@media screen and (max-width: 1024px) {
    #$block_id.display-grid .grid-wrapper {
        grid-template-columns: repeat(
            $column1,
            1fr
        ) !important;
    }
}
@media screen and (max-width: 767px) {
    #$block_id.display-grid .grid-wrapper {
        grid-template-columns: repeat(
            $column2,
            1fr
        ) !important;
    }
}
@media screen and (max-width: 568px) {
    #$block_id.display-grid .grid-wrapper {
        grid-template-columns: repeat(
            1,
            1fr
        ) !important;
    }
}

#$block_id.display-list .list-wrapper .cozy-block-advanced-categories__category-item {
    margin-bottom: {$list_styles['gap']};
}
#$block_id .cozy-block-advanced-categories__category-item {
	{$item_div_padding}
	{$item_div_border}
	{$item_div_radius}
	background-color: {$item_styles['bg_color']};

	&.has-box-shadow {
		box-shadow: {$item_styles['shadow']['horizontal']}px {$item_styles['shadow']['vertical']}px {$item_styles['shadow']['blur']}px {$item_styles['shadow']['spread']}px {$item_styles['shadow_color']} {$item_styles['shadow']['position']};
	}
}
#$block_id .cozy-block-advanced-categories__category-item:hover {
	background-color: {$item_styles['bg_color_hover']};
	border-color: {$item_styles['border_color_hover']};
}
#$block_id.display-list .cozy-block-advanced-categories__category-item {
	height: {$list_styles['height']};
}
#$block_id.display-list .cozy-block-advanced-categories__image {
	{$image_styles['border']}
	max-height: {$list_styles['height']};
}
#$block_id.display-list .cozy-block-advanced-categories__image img {
	height: {$list_styles['height']};
}
#$block_id:not(.display-list) .cozy-block-advanced-categories__image {
	max-height: {$image_styles['height']};
	{$image_styles['border']}

}
#$block_id:not(.display-list) .cozy-block-advanced-categories__image img {
	width: {$image_styles['width']};
	height: {$image_styles['height']};
}
#$block_id .cozy-block-advanced-categories__image {
	{$image_styles['radius']};
}
#$block_id.layout-cover .cozy-block-advanced-categories__category-item:hover .cozy-block-advanced-categories__image{
	border-color: 	{$image_styles['border_color']};
}
#$block_id.layout-cover .cozy-block-advanced-categories__category-item:hover .cozy-block-advanced-categories__background {
	background-color: {$image_styles['overlay']};
}

#$block_id .cozy-block-advanced-categories__content-wrapper {
	{$content_wrapper_padding}
}

#$block_id .cozy-block-advanced-categories__title {
	justify-content: {$styles['align']};
	gap: {$icon_styles['gap']};
}

#$block_id .cozy-block-advanced-categories__icon-wrapper.view-stacked {
	{$icon_box_padding}
	{$icon_box_border}
	border-radius: {$icon_box_styles['radius']};
	background-color: {$icon_box_styles['bg_color']};
}
#$block_id .cozy-block-advanced-categories__category-item:hover .cozy-block-advanced-categories__icon-wrapper.view-stacked {
	background-color: {$icon_box_styles['bg_color_hover']};
	border-color: {$icon_box_styles['border_color_hover']};
}
#$block_id .cozy-block-advanced-categories__icon {
	width: {$icon_styles['size']};
	height: {$icon_styles['size']};
}
#$block_id .layout-fill .cozy-block-advanced-categories__icon {
	opacity: {$icon_opacity};
	fill: {$icon_styles['color']};
	stroke: none;
}
#$block_id .layout-outline .cozy-block-advanced-categories__icon {
	stroke: {$icon_styles['color']};
	fill: none;
}
#$block_id.layout-default .cozy-block-advanced-categories__category-item:hover .layout-fill .cozy-block-advanced-categories__icon {
	fill: {$icon_styles['color_hover']};
}
#$block_id.layout-default .cozy-block-advanced-categories__category-item:hover .layout-outline .cozy-block-advanced-categories__icon {
	stroke: {$icon_styles['color_hover']};
}
#$block_id.layout-cover .cozy-block-advanced-categories__content-wrapper:hover .layout-fill .cozy-block-advanced-categories__icon {
	fill: {$icon_styles['color_hover']};
}
#$block_id.layout-cover .cozy-block-advanced-categories__content-wrapper:hover .layout-outline .cozy-block-advanced-categories__icon {
	stroke: {$icon_styles['color_hover']};
}

#$block_id .cozy-block-advanced-categories__name {
	{$title_styles['padding']}
	border-radius:{$title_styles['radius']};
	font-size: {$title_styles['font']['size']};
	font-weight: {$title_styles['font']['weight']};
	font-family: {$title_styles['font']['family']};
	text-transform: {$title_styles['letter_case']};
	text-decoration: {$title_styles['decoration']};
	line-height: {$title_styles['line_height']};
	letter-spacing: {$title_styles['letter_spacing']};
	color: {$title_styles['color']};
	background-color:{$title_styles['bg']};

}
#$block_id.layout-cover .cozy-block-advanced-categories__category-item:hover .cozy-block-advanced-categories__name,
#$block_id.layout-default .cozy-block-advanced-categories__category-item:hover .cozy-block-advanced-categories__name {
	color: {$title_styles['color_hover']};
	background-color: {$title_styles['bg_hover']};
	}
#$block_id.layout-cover .cozy-block-advanced-categories__content-wrapper:hover .cozy-block-advanced-categories__name {
	color: {$title_styles['color_hover']};
	background-color: {$title_styles['bg_hover']};
}

#$block_id .cozy-block-advanced-categories__count {
	{$count_padding}
	{$count_border}
	{$count_radius}
	color: {$count_styles['color']};
	background-color: {$count_styles['bg_color']};
}
#$block_id.layout-default .cozy-block-advanced-categories__category-item:hover .cozy-block-advanced-categories__count {
	color: {$title_styles['color_hover']};
}
#$block_id.layout-cover .cozy-block-advanced-categories__content-wrapper:hover .cozy-block-advanced-categories__count {
	color: {$title_styles['color_hover']};
}

#$block_id .swiper-button-prev::after,
#$block_id .swiper-button-next::after {
	font-size: {$nav_styles['size']};
}
#$block_id .swiper-button-prev,
#$block_id .swiper-button-next {
	width: {$nav_styles['box_width']};
	height: {$nav_styles['box_height']};
	{$nav_border}
	border-radius: {$nav_styles['radius']};
	color: {$nav_styles['color']};
	background-color: {$nav_styles['bg_color']};
}
#$block_id .swiper-button-prev:hover,
#$block_id .swiper-button-next:hover {
	color: {$nav_styles['color_hover']};
	background-color: {$nav_styles['bg_color_hover']};
	border-color: {$nav_styles['border_color_hover']};
}

#$block_id.swiper-container .swiper-pagination {
	bottom: {$bullet['position']}px;
	text-align: {$bullet['align']};
    {$bullet['left']}
    {$bullet['right']}
}
#$block_id.swiper-container .swiper-pagination .swiper-pagination-bullet {
	width: {$bullet['width']};
	height: {$bullet['height']};
	border-radius: {$bullet['radius']};
	background-color: {$bullet_styles['default_color']};
}
#$block_id.swiper-container .swiper-pagination .swiper-pagination-bullet-active {
	width: {$bullet['width_active']};
	height: {$bullet['height_active']};
	border-radius: {$bullet['radius_active']};
	background-color: {$bullet_styles['active_color']};
	{$bullet_outline}
	outline-offset: {$bullet['outline_offset_active']};
}
#$block_id.swiper-container .swiper-pagination .swiper-pagination-bullet:hover {
	background-color: {$bullet_styles['default_color_hover']};
}
#$block_id.swiper-container .swiper-pagination .swiper-pagination-bullet-active:hover {
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
$classes[] = 'cozy-block-advanced-categories';
$classes[] = 'display-' . $attributes['display'];
$classes[] = 'layout-' . $attributes['layout'];
$classes[] = 'cover' === $attributes['layout'] && $attributes['layoutHover'] ? 'has-layout-hover-effect' : '';
$classes[] = 'carousel' === $attributes['display'] ? 'swiper-container' : '';
$classes[] = 'carousel' === $attributes['display'] && $attributes['navigation']['hoverShow'] ? 'has-nav-hover-show' : '';
// Block Styles END.
$output = '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '" id="' . esc_attr( $block_id ) . '">';

$display_wrapper_classes   = array();
$display_wrapper_classes[] = 'carousel' === $attributes['display'] ? 'swiper-wrapper' : $attributes['display'] . '-wrapper';
$output                   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $display_wrapper_classes ) ) ) ) . '">';

// <-- Category Content -->
$args = array(
	'taxonomy'   => 'category',
	'hide_empty' => true,
	'number'     => -1 !== $attributes['perPage'] ? absint( $attributes['perPage'] ) : '',
	'order'      => isset( $attributes['order'] ) ? sanitize_text_field( $attributes['order'] ) : 'DESC',
	'orderby'    => isset( $attributes['orderBy'] ) ? sanitize_text_field( $attributes['orderBy'] ) : 'count',
	'exclude'    => isset( $attributes['excludeID'] ) ? array_map( 'absint', $attributes['excludeID'] ) : array(),
);

if ( isset( $attributes['showNestedCategory'] ) && ! filter_var( $attributes['showNestedCategory'], FILTER_VALIDATE_BOOLEAN ) ) {
	$args['parent'] = 0;
}

$categories = get_categories( $args );

// Function to find the index of an object with a specific id.
if ( ! function_exists( 'cozy_find_post_advanced_cat_index' ) ) {
	function cozy_find_post_advanced_cat_index( $cat_options, $id ) {
		foreach ( $cat_options as $index => $item ) {
			if ( $item['id'] === $id ) {
				return $index;
			}
		}
		return -1; // Return -1 if not found, similar to JavaScript's findIndex.
	}
}

foreach ( $categories as $category ) {
	$cat_index = cozy_find_post_advanced_cat_index( $attributes['categoryOptions'], $category->term_id );
	$cat_data  = array();

	if ( -1 != $cat_index ) {
		$cat_data = $attributes['categoryOptions'][ $cat_index ];
	}

	$object_position_x     = ! empty( $cat_data ) && isset( $cat_data, $cat_data['focalPoint']['x'] ) ? floatval( $cat_data['focalPoint']['x'] ) * 100 . '%' : '';
	$object_position_y     = ! empty( $cat_data ) && isset( $cat_data, $cat_data['focalPoint']['y'] ) ? floatval( $cat_data['focalPoint']['y'] ) * 100 . '%' : '';
	$count_singular_styles = array(
		'color'         => ! empty( $cat_data ) && isset( $cat_data, $cat_data['color'] ) ? $cat_data['color'] : '',
		'bg_color'      => ! empty( $cat_data ) && isset( $cat_data, $cat_data['bgColor'] ) ? $cat_data['bgColor'] : '',
		'overlay_color' => ! empty( $cat_data ) && isset( $cat_data, $cat_data['overlayColor'] ) ? $cat_data['overlayColor'] : '',
	);

	$cat_styles = "
	#$block_id .cozy-block-advanced-categories__category-item[data-category-id='{$category->term_id}'] .cozy-block-advanced-categories__image img {
		object-position: {$object_position_x} {$object_position_y};
	}
	#$block_id .cozy-block-advanced-categories__category-item[data-category-id='{$category->term_id}'] .cozy-block-advanced-categories__background {
		background-color: {$count_singular_styles['overlay_color']};
	}
	#$block_id .cozy-block-advanced-categories__category-item[data-category-id='{$category->term_id}'] .cozy-block-advanced-categories__count {
		color: {$count_singular_styles['color']};
		background-color: {$count_singular_styles['bg_color']};
	}
";

	$cat_classes   = array();
	$cat_classes[] = 'cozy-block-advanced-categories__category-item';
	$cat_classes[] = 'carousel' === $attributes['display'] ? 'swiper-slide' : '';
	$cat_classes[] = isset( $attributes['categoryItem']['shadow']['enabled'] ) && $attributes['categoryItem']['shadow']['enabled'] ? 'has-box-shadow' : '';
	$output       .= '<style>' . esc_attr( $cat_styles ) . '</style>';
	$output       .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $cat_classes ) ) ) ) . '" data-category-id="' . esc_attr( $category->term_id ) . '">';

	$has_category_link = isset( $attributes['enableOptions']['linkCategory'] ) && $attributes['enableOptions']['linkCategory'] ? 'href="' . esc_url( get_category_link( $category->term_id ) ) . '"' : '';
	$open_new_tab      = isset( $attributes['enableOptions']['linkCategory'], $attributes['enableOptions']['openNewTab'] ) && $attributes['enableOptions']['linkCategory'] && $attributes['enableOptions']['openNewTab'] ? '_blank' : '';

	$output .= '<a ' . $has_category_link . ' target="' . $open_new_tab . '" rel="noopener">';
	if ( 'cover' === $attributes['layout'] ) {
		$output .= '<span class="cozy-block-advanced-categories__background"></span>';
	}
	if ( $attributes['enableOptions']['image'] && isset( $cat_data, $cat_data['mediaURL'] ) && ! empty( $cat_data ) ) {
		$img_classes   = array();
		$img_classes[] = 'cozy-block-advanced-categories__image';
		$img_classes[] = $attributes['image']['hoverEffect'] ? 'has-image-hover-effect' : '';
		$output       .= '<figure class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $img_classes ) ) ) ) . '">';
		$img_url       = isset( $cat_data['mediaURL'] ) && ! empty( $cat_data['mediaURL'] ) ? $cat_data['mediaURL'] : '';
		$output       .= '<img src="' . esc_url( $img_url ) . '" />';
		$output       .= '</figure>';
	}

	$content_wrapper_classes   = array();
	$content_wrapper_classes[] = 'cozy-block-advanced-categories__content-wrapper';
	$content_wrapper_classes[] = 'position-' . str_replace( ' ', '-', $attributes['contentPosition'] );
	$output                   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $content_wrapper_classes ) ) ) ) . '">';
	if ( $attributes['enableOptions']['name'] ) {
		$output .= '<div class="cozy-block-advanced-categories__title">';
		if ( $attributes['enableOptions']['icon'] ) {
			$icon_wrapper_classes   = array();
			$icon_wrapper_classes[] = 'cozy-block-advanced-categories__icon-wrapper';
			$icon_wrapper_classes[] = 'view-' . $attributes['icon']['view'];
			$icon_wrapper_classes[] = 'layout-' . $attributes['icon']['layout'];

			$icon_view_box   = array();
			$icon_view_box[] = $attributes['icon']['viewBox']['vx'];
			$icon_view_box[] = $attributes['icon']['viewBox']['vy'];
			$icon_view_box[] = $attributes['icon']['viewBox']['vw'];
			$icon_view_box[] = $attributes['icon']['viewBox']['vh'];

			$stroke_width   = 'outline' === $attributes['icon']['layout'] ? $attributes['icon']['strokeWidth'] : '';
			$stroke_opacity = 'outline' === $attributes['icon']['layout'] ? number_format( floatval( $attributes['icon']['opacity'] / 100 ), 2 ) : '';

			$output     .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $icon_wrapper_classes ) ) ) ) . '">';
			$output     .= '<svg class="cozy-block-advanced-categories__icon" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="' . esc_attr( implode( ' ', array_map( 'intval', $icon_view_box ) ) ) . '" stroke-width="' . esc_attr( $stroke_width ) . '" stroke-opacity="' . esc_attr( $stroke_opacity ) . '">';
				$output .= '<path d="' . esc_attr( $attributes['icon']['path'] ) . '" />';
			$output     .= '</svg>';
			$output     .= '</div>';
		}
		$output .= '<p class="cozy-block-advanced-categories__name">' . esc_html( $category->name ) . '</p>';
		$output .= '</div>';
	}

	if ( $attributes['enableOptions']['count'] ) {
		$output     .= '<p class="cozy-block-advanced-categories__count-wrapper">';
			$output .= '<span class="cozy-block-advanced-categories__count">' . esc_html( $category->count ) . '<span>';
		$output     .= '</p>';
	}
	$output .= '</div>'; // Content Wrapper div closing.

	$output .= '</a>';
	$output .= '</div>';
}

// <--/ Category Content -->

$output .= '</div>';
if ( 'carousel' === $attributes['display'] ) {

	if ( $attributes['navigation']['enabled'] ) {
		$output .= '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>';
	}

	if ( $attributes['pagination']['enabled'] ) {
		$output .= '<div class="swiper-pagination"></div>';
	}
}
$output .= '</div>';

/* Font Family enqueue */
$font_families = array();

if ( isset( $attributes['title']['fontFamily'] ) && ! empty( $attributes['title']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['title']['fontFamily'] );
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

$render = sprintf( '<div class="cozy-block-wrapper cozy-block-advanced-categories-wrapper"><div %1$s>%2$s</div></div>', $wrapper_attributes, $output );
echo $render;
