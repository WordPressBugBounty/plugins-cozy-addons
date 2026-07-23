<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['clientId'] ) ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$attributes['siteURL'] = site_url();

wp_add_inline_script( 'cozy-block--featured-post-tabs--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockFeaturedPostTabs( "' . esc_html( $client_id ) . '" ) }) ' );

$separator_padding = isset( $attributes['separatorStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['separatorStyles']['padding'] ) : '';
$separator_border  = isset( $attributes['separatorStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['separatorStyles']['border'] ) : '';
$separator_radius  = isset( $attributes['separatorStyles']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['separatorStyles']['radius'] ) : '';
$separator_styles  = array(
	'margin'   => array(
		'top'    => isset( $attributes['tabStyles']['marginTop'] ) ? cozy_addons_sanitize_dimension( $attributes['tabStyles']['marginTop'] ) : '',
		'bottom' => isset( $attributes['tabStyles']['marginTop'] ) ? cozy_addons_sanitize_dimension( $attributes['tabStyles']['marginBottom'] ) : '',
	),
	'justify'  => isset( $attributes['tabJustification'] ) ? esc_attr( sanitize_text_field( $attributes['tabJustification'] ) ) : '',
	'gap'      => isset( $attributes['tabGap'] ) ? cozy_addons_sanitize_dimension( $attributes['tabGap'] ) : '',
	'bg_color' => isset( $attributes['separatorStyles']['bgColor'] ) ? $attributes['separatorStyles']['bgColor'] : '',
);

$tab_padding        = isset( $attributes['tabStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['tabStyles']['padding'] ) : '';
$tab_border_radius  = isset( $attributes['tabStyles']['borderRadius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['tabStyles']['borderRadius'] ) : '';
$default_tab_border = isset( $attributes['tabStyles']['default']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['default']['border'] ) : '';
$active_tab_border  = isset( $attributes['tabStyles']['active']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['active']['border'] ) : '';
$tab_styles         = array(
	'font'             => array(
		'size'   => isset( $attributes['tabStyles']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['tabStyles']['fontSize'] ) : '',
		'weight' => isset( $attributes['tabStyles']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['tabStyles']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['fontFamily'] ) ) : '',
	),
	'letter_case'      => isset( $attributes['tabStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['letterCase'] ) ) : '',
	'decoration'       => isset( $attributes['tabStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['decoration'] ) ) : '',
	'line_height'      => isset( $attributes['tabStyles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['tabStyles']['lineHeight'] ) : '',
	'letter_spacing'   => isset( $attributes['tabStyles']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['tabStyles']['letterSpacing'] ) : '',
	'default_color'    => isset( $attributes['tabStyles']['default']['color'] ) ? esc_attr( $attributes['tabStyles']['default']['color'] ) : '',
	'default_bg_color' => isset( $attributes['tabStyles']['default']['bgColor'] ) ? esc_attr( $attributes['tabStyles']['default']['bgColor'] ) : '',
	'active_color'     => isset( $attributes['tabStyles']['active']['color'] ) ? esc_attr( $attributes['tabStyles']['active']['color'] ) : '',
	'active_bg_color'  => isset( $attributes['tabStyles']['active']['bgColor'] ) ? esc_attr( $attributes['tabStyles']['active']['bgColor'] ) : '',
);

$active_tab_overlay = isset( $attributes['separatorStyles']['border']['bottom']['width'] ) ? $attributes['separatorStyles']['border']['bottom']['width'] : '';

$icon_box_padding = isset( $attributes['iconBox']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['iconBox']['padding'] ) : '';
$icon_box_border  = isset( $attributes['iconBox']['border'] ) ? cozy_render_TRBL( 'border', $attributes['iconBox']['border'] ) : '';
$icon_box_styles  = array(
	'radius'              => isset( $attributes['iconBox']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['iconBox']['radius'] ) : '',
	'bg_color'            => isset( $attributes['iconBox']['bgColor'] ) ? $attributes['iconBox']['bgColor'] : '',
	'bg_color_active'     => isset( $attributes['iconBox']['bgColorActive'] ) ? $attributes['iconBox']['bgColorActive'] : '',
	'border_color_active' => isset( $attributes['iconBox']['borderColorActive'] ) ? $attributes['iconBox']['borderColorActive'] : '',
);
$icon_opacity     = number_format( ( floatval( $attributes['icon']['opacity'] ) / 100 ), 2 );
$icon_styles      = array(
	'size'           => isset( $attributes['icon']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['size'] ) : '',
	'stroke_width'   => 'outline' === $attributes['icon']['layout'] ? $attributes['icon']['strokeWidth'] : '',
	'stroke_opacity' => 'outline' === $attributes['icon']['layout'] ? number_format( floatval( $attributes['icon']['opacity'] / 100 ), 2 ) : '',
);

$styles = array(
	'column'   => isset( $attributes['gridOptions']['columnCount'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['columnCount'] ) : '',
	'gap'      => isset( $attributes['gridOptions']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['gap'] ) : '',
	'list_gap' => isset( $attributes['listOptions']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['listOptions']['gap'] ) : '',
);

$post_box_padding = isset( $attributes['postBoxStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['postBoxStyles']['padding'] ) : '';
$post_box_border  = isset( $attributes['postBoxStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['postBoxStyles']['border'] ) : '';
$post_box_styles  = array(
	'radius'             => isset( $attributes['postBoxStyles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['postBoxStyles']['radius'] ) : '',
	'shadow'             => array(
		'horizontal' => isset( $attributes['postBoxStyles']['shadow']['horizontal'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['postBoxStyles']['shadow']['vertical'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['postBoxStyles']['shadow']['blur'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['postBoxStyles']['shadow']['spread'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['spread'] ) : '',
		'color'      => isset( $attributes['postBoxStyles']['shadow']['color'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['color'] ) : '',
		'position'   => isset( $attributes['postBoxStyles']['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['postBoxStyles']['shadow']['position'] ) ) : '',
	),
	'bg_color'           => isset( $attributes['postBoxStyles']['bgColor'] ) ? $attributes['postBoxStyles']['bgColor'] : '',
	'bg_color_hover'     => isset( $attributes['postBoxStyles']['bgColorHover'] ) ? $attributes['postBoxStyles']['bgColorHover'] : '',
	'border_color_hover' => isset( $attributes['postBoxStyles']['borderColorHover'] ) ? $attributes['postBoxStyles']['borderColorHover'] : '',
);

$post_image = array(
	'width'  => isset( $attributes['imageStyles']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['imageStyles']['width'] ) : '',
	'height' => isset( $attributes['imageStyles']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['imageStyles']['height'] ) : '',
	'radius' => isset( $attributes['imageStyles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['imageStyles']['radius'] ) : '',
);

$cat_padding = isset( $attributes['categoryStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['categoryStyles']['padding'] ) : '';
$cat_border  = isset( $attributes['categoryStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['categoryStyles']['border'] ) : '';
$cat_styles  = array(
	'margin'             => array(
		'top'    => isset( $attributes['categoryStyles']['marginTop'] ) ? cozy_addons_sanitize_dimension( $attributes['categoryStyles']['marginTop'] ) : '',
		'bottom' => isset( $attributes['categoryStyles']['marginBottom'] ) ? cozy_addons_sanitize_dimension( $attributes['categoryStyles']['marginBottom'] ) : '',
	),
	'radius'             => isset( $attributes['categoryStyles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['categoryStyles']['radius'] ) : '',
	'gap'                => isset( $attributes['categoryStyles']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['categoryStyles']['gap'] ) : '',
	'font'               => array(
		'size'   => isset( $attributes['categoryStyles']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['categoryStyles']['fontSize'] ) : '',
		'weight' => isset( $attributes['categoryStyles']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['categoryStyles']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['categoryStyles']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['categoryStyles']['fontFamily'] ) ) : '',
	),
	'decoration'         => isset( $attributes['categoryStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['categoryStyles']['decoration'] ) ) : '',
	'letter_case'        => isset( $attributes['categoryStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['categoryStyles']['letterCase'] ) ) : '',
	'line_height'        => isset( $attributes['categoryStyles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['categoryStyles']['lineHeight'] ) : '',
	'letter_spacing'     => isset( $attributes['categoryStyles']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['categoryStyles']['letterSpacing'] ) : '',
	'color'              => isset( $attributes['categoryStyles']['color'] ) ? esc_attr( $attributes['categoryStyles']['color'] ) : '',
	'color_hover'        => isset( $attributes['categoryStyles']['colorHover'] ) ? esc_attr( $attributes['categoryStyles']['colorHover'] ) : '',
	'bg_color'           => isset( $attributes['categoryStyles']['bgColor'] ) ? esc_attr( $attributes['categoryStyles']['bgColor'] ) : '',
	'bg_color_hover'     => isset( $attributes['categoryStyles']['bgColorHover'] ) ? esc_attr( $attributes['categoryStyles']['bgColorHover'] ) : '',
	'border_color_hover' => isset( $attributes['categoryStyles']['borderColorHover'] ) ? esc_attr( $attributes['categoryStyles']['borderColorHover'] ) : '',
);

$title_styles = array(
	'margin'         => array(
		'top'    => isset( $attributes['titleStyles']['marginTop'] ) ? cozy_addons_sanitize_dimension( $attributes['titleStyles']['marginTop'] ) : '',
		'bottom' => isset( $attributes['titleStyles']['marginBottom'] ) ? cozy_addons_sanitize_dimension( $attributes['titleStyles']['marginBottom'] ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['titleStyles']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['titleStyles']['fontSize'] ) : '',
		'weight' => isset( $attributes['titleStyles']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['titleStyles']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['titleStyles']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['titleStyles']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['titleStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['titleStyles']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['titleStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['titleStyles']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['titleStyles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['titleStyles']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['titleStyles']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['titleStyles']['letterSpacing'] ) : '',
	'color'          => isset( $attributes['titleStyles']['color'] ) ? esc_attr( $attributes['titleStyles']['color'] ) : '',
	'color_hover'    => isset( $attributes['titleStyles']['colorHover'] ) ? esc_attr( $attributes['titleStyles']['colorHover'] ) : '',
);

$date_padding = isset( $attributes['dateStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['dateStyles']['padding'] ) : '';
$date_border  = isset( $attributes['dateStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['dateStyles']['border'] ) : '';
$date_styles  = array(
	'margin'             => array(
		'top'    => isset( $attributes['dateStyles']['marginTop'] ) ? cozy_addons_sanitize_dimension( $attributes['dateStyles']['marginTop'] ) : '',
		'bottom' => isset( $attributes['dateStyles']['marginBottom'] ) ? cozy_addons_sanitize_dimension( $attributes['dateStyles']['marginBottom'] ) : '',
	),
	'radius'             => isset( $attributes['dateStyles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['dateStyles']['radius'] ) : '',
	'font'               => array(
		'size'   => isset( $attributes['dateStyles']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['dateStyles']['fontSize'] ) : '',
		'weight' => isset( $attributes['dateStyles']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['dateStyles']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['dateStyles']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['dateStyles']['fontFamily'] ) ) : '',
	),
	'letter_case'        => isset( $attributes['dateStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['dateStyles']['letterCase'] ) ) : '',
	'decoration'         => isset( $attributes['dateStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['dateStyles']['decoration'] ) ) : '',
	'line_height'        => isset( $attributes['dateStyles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['dateStyles']['lineHeight'] ) : '',
	'letter_spacing'     => isset( $attributes['dateStyles']['letterSpacing'] ) ? esc_attr( sanitize_text_field( $attributes['dateStyles']['letterSpacing'] ) ) : '',
	'color'              => isset( $attributes['dateStyles']['color'] ) ? esc_attr( $attributes['dateStyles']['color'] ) : '',
	'color_hover'        => isset( $attributes['dateStyles']['colorHover'] ) ? esc_attr( $attributes['dateStyles']['colorHover'] ) : '',
	'bg_color'           => isset( $attributes['dateStyles']['bgColor'] ) ? esc_attr( $attributes['dateStyles']['bgColor'] ) : '',
	'bg_color_hover'     => isset( $attributes['dateStyles']['bgColorHover'] ) ? esc_attr( $attributes['dateStyles']['bgColorHover'] ) : '',
	'border_color_hover' => isset( $attributes['dateStyles']['borderColorHover'] ) ? esc_attr( $attributes['dateStyles']['borderColorHover'] ) : '',
);

$tag_box_padding = isset( $attributes['tagStyles']['boxPadding'] ) ? cozy_render_TRBL( 'padding', $attributes['tagStyles']['boxPadding'] ) : '';
$tag_padding     = isset( $attributes['tagStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['tagStyles']['padding'] ) : '';
$tag_border      = isset( $attributes['tagStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tagStyles']['border'] ) : '';
$tag_styles      = array(
	'gap'                => isset( $attributes['tagStyles']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['tagStyles']['gap'] ) : '',
	'font'               => array(
		'size'   => isset( $attributes['tagStyles']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['tagStyles']['fontSize'] ) : '',
		'weight' => isset( $attributes['tagStyles']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['tagStyles']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['tagStyles']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['tagStyles']['fontFamily'] ) ) : '',
	),
	'text_transform'     => isset( $attributes['tagStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['tagStyles']['letterCase'] ) ) : 'none',
	'decoration'         => isset( $attributes['tagStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['tagStyles']['decoration'] ) ) : '',
	'line_height'        => isset( $attributes['tagStyles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['tagStyles']['lineHeight'] ) : '',
	'letter_spacing'     => isset( $attributes['tagStyles']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['tagStyles']['letterSpacing'] ) : '',
	'color'              => isset( $attributes['tagStyles']['color'] ) ? esc_attr( $attributes['tagStyles']['color'] ) : '',
	'color_hover'        => isset( $attributes['tagStyles']['colorHover'] ) ? esc_attr( $attributes['tagStyles']['colorHover'] ) : '',
	'bg_color'           => isset( $attributes['tagStyles']['bgColor'] ) ? esc_attr( $attributes['tagStyles']['bgColor'] ) : '',
	'bg_color_hover'     => isset( $attributes['tagStyles']['bgColorHover'] ) ? esc_attr( $attributes['tagStyles']['bgColorHover'] ) : '',
	'border_color_hover' => isset( $attributes['tagStyles']['borderColorHover'] ) ? esc_attr( $attributes['tagStyles']['borderColorHover'] ) : '',
);

$column1 = $attributes['gridOptions']['columnCount'] <= 3 ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['columnCount'] ) : 3;
$column2 = $attributes['gridOptions']['columnCount'] <= 2 ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['columnCount'] ) : 2;

$block_styles = "
#$block_id .cozy-block-featured-post-tabs__tabs {
	{$separator_padding}
	{$separator_border}
	{$separator_radius}
    justify-content: {$separator_styles['justify']};
    gap: {$separator_styles['gap']};
	margin-top: {$separator_styles['margin']['top']};
	margin-bottom: {$separator_styles['margin']['bottom']};
	background-color: {$separator_styles['bg_color']};
}

#$block_id .cozy-block-featured-post-tabs__tab {
    {$tab_padding}
    {$tab_border_radius}
    {$default_tab_border}
    background-color: {$tab_styles['default_bg_color']};
    color: {$tab_styles['default_color']};
	font-size: {$tab_styles['font']['size']};
	font-weight: {$tab_styles['font']['weight']};
	font-family: {$tab_styles['font']['family']};
    text-transform: {$tab_styles['letter_case']};
    text-decoration: {$tab_styles['decoration']};
    line-height: {$tab_styles['line_height']};
    letter-spacing: {$tab_styles['letter_spacing']};
}
#$block_id .cozy-block-featured-post-tabs__tab.active-tab {
    {$active_tab_border}
    background-color: {$tab_styles['active_bg_color']};
    color: {$tab_styles['active_color']};
}
#$block_id.has-tab-overlay .cozy-block-featured-post-tabs__tab.active-tab {
    margin-bottom: -{$active_tab_overlay};
}

#$block_id .cozy-block-featured-post-tabs__icon-wrapper.view-stacked {
	{$icon_box_padding}
	{$icon_box_border}
    border-radius: {$icon_box_styles['radius']};
    background-color: {$icon_box_styles['bg_color']};
}
#$block_id .active-tab .cozy-block-featured-post-tabs__icon-wrapper.view-stacked {
    background-color: {$icon_box_styles['bg_color_active']};
    border-color: {$icon_box_styles['border_color_active']};
}
#$block_id .cozy-block-featured-post-tabs__icon {
    width: {$icon_styles['size']};
    height: {$icon_styles['size']};
}
#$block_id .layout-fill .cozy-block-featured-post-tabs__icon {
    opacity: {$icon_opacity};
    fill: {$tab_styles['default_color']};
    stroke: none;
}
#$block_id .layout-outline .cozy-block-featured-post-tabs__icon {
    stroke: {$tab_styles['default_color']};
    fill: none;
}
#$block_id .active-tab .layout-fill .cozy-block-featured-post-tabs__icon {
    fill: {$tab_styles['active_color']};
    stroke: none;
}
#$block_id .active-tab .layout-outline .cozy-block-featured-post-tabs__icon {
    stroke: {$tab_styles['active_color']};
    fill: none;
}

#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .latest-wrapper,
#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .popular-wrapper,
#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .trending-wrapper {
	grid-template-columns: repeat({$styles['column']}, 1fr);
	gap: {$styles['gap']};
}
@media screen and (max-width: 1024px) {
	#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .latest-wrapper,
	#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .popular-wrapper,
#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .trending-wrapper {
		grid-template-columns: repeat(
				$column1,
				1fr
			) !important;
	}
}

@media screen and (max-width: 767px) {
	#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .latest-wrapper,
	#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .popular-wrapper,
#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .trending-wrapper {
		grid-template-columns: repeat(
				$column2,
				1fr
			) !important;
	}
}

@media screen and (max-width: 400px) {
	#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .latest-wrapper,
	#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .popular-wrapper,
#{$block_id}.display-grid .cozy-block-featured-post-tabs__content-wrapper .trending-wrapper {
		grid-template-columns: repeat(
				1,
				1fr
			) !important;
	}
}

#{$block_id}.display-list .cozy-block-featured-post-tabs__content {
	margin-bottom: {$styles['list_gap']};
}

#{$block_id} .cozy-block-featured-post-tabs__content-wrapper .latest-wrapper .cozy-block-featured-post-tabs__content,
#{$block_id} .cozy-block-featured-post-tabs__content-wrapper .popular-wrapper .cozy-block-featured-post-tabs__content,
#{$block_id} .cozy-block-featured-post-tabs__content-wrapper .trending-wrapper .cozy-block-featured-post-tabs__content {
	{$post_box_padding}
	{$post_box_border}
	border-radius: {$post_box_styles['radius']};
	background-color: {$post_box_styles['bg_color']};
}
#{$block_id} .cozy-block-featured-post-tabs__content-wrapper .latest-wrapper .cozy-block-featured-post-tabs__content:hover,
#{$block_id} .cozy-block-featured-post-tabs__content-wrapper .popular-wrapper .cozy-block-featured-post-tabs__content:hover,
#{$block_id} .cozy-block-featured-post-tabs__content-wrapper .trending-wrapper .cozy-block-featured-post-tabs__content:hover {
	background-color: {$post_box_styles['bg_color_hover']};
	border-color: {$post_box_styles['border_color_hover']};
}
#{$block_id}.post-box-has-shadow .cozy-block-featured-post-tabs__content-wrapper .latest-wrapper .cozy-block-featured-post-tabs__content,
#{$block_id}.post-box-has-shadow .cozy-block-featured-post-tabs__content-wrapper .popular-wrapper .cozy-block-featured-post-tabs__content,
#{$block_id}.post-box-has-shadow .cozy-block-featured-post-tabs__content-wrapper .trending-wrapper .cozy-block-featured-post-tabs__content {
	box-shadow: {$post_box_styles['shadow']['horizontal']}px {$post_box_styles['shadow']['vertical']}px {$post_box_styles['shadow']['blur']}px {$post_box_styles['shadow']['spread']}px {$post_box_styles['shadow']['color']} {$post_box_styles['shadow']['position']};
}
  
#{$block_id} .cozy-block-featured-post-tabs__post-image  {
	max-height: {$post_image['height']};
	min-width: {$post_image['width']};
	max-width: {$post_image['width']};
	border-radius: {$post_image['radius']};
}
#{$block_id} .cozy-block-featured-post-tabs__post-image img {
	height: {$post_image['height']};
	border-radius: {$post_image['radius']};
}
@media only screen and (max-width: 1024px) {
	#{$block_id} .cozy-block-featured-post-tabs__post-image img {
		max-height: {$post_image['height']};
	}
}

#$block_id .cozy-block-featured-post-tabs__post-categories {
	gap: {$cat_styles['gap']};
	font-size: {$cat_styles['font']['size']};
	font-weight: {$cat_styles['font']['weight']};
	font-family: {$cat_styles['font']['family']};
	margin-top: {$cat_styles['margin']['top']};
	margin-bottom: {$cat_styles['margin']['bottom']};
	text-transform: {$cat_styles['letter_case']};
	text-decoration: {$cat_styles['decoration']};
	line-height: {$cat_styles['line_height']};
	letter-spacing: {$cat_styles['letter_spacing']};
}
#$block_id .cozy-block-featured-post-tabs__post-categories a {
	{$cat_padding}
	{$cat_border}
	border-radius: {$cat_styles['radius']};
	color: {$cat_styles['color']};
	background-color: {$cat_styles['bg_color']};
}
#$block_id .cozy-block-featured-post-tabs__post-categories a:hover {
	color: {$cat_styles['color_hover']};
	background-color: {$cat_styles['bg_color_hover']};
	border-color: {$cat_styles['border_color_hover']};
}

#$block_id .cozy-block-featured-post-tabs__post-title {
	margin-top: {$title_styles['margin']['top']};
	margin-bottom: {$title_styles['margin']['bottom']};
    font-size: clamp(16px, calc(3vw + 4px), {$title_styles['font']['size']});
    font-weight: {$title_styles['font']['weight']};
    font-family: {$title_styles['font']['family']};
	text-transform: {$title_styles['letter_case']};
	line-height: {$title_styles['line_height']};
	letter-spacing: {$title_styles['letter_spacing']};
}
#$block_id .cozy-block-featured-post-tabs__post-title a {
	text-decoration: {$title_styles['decoration']};
	color: {$title_styles['color']};
}
#$block_id .cozy-block-featured-post-tabs__post-title a:hover {
	color: {$title_styles['color_hover']};
}

#$block_id .cozy-block-featured-post-tabs__post-date {
	margin-top: {$date_styles['margin']['top']};
	margin-bottom: {$date_styles['margin']['bottom']};
}
#$block_id .cozy-block-featured-post-tabs__post-date a {
	{$date_padding}
	{$date_border}
	border-radius: {$date_styles['radius']};
	color: {$date_styles['color']};
	background-color: {$date_styles['bg_color']};
	font-size: {$date_styles['font']['size']};
	font-weight: {$date_styles['font']['weight']};
	font-family: {$date_styles['font']['family']};
	text-transform: {$date_styles['letter_case']};
	text-decoration: {$date_styles['decoration']};
	line-height: {$date_styles['line_height']};
	letter-spacing: {$date_styles['letter_spacing']};
}
#$block_id .cozy-block-featured-post-tabs__post-date a:hover {
	color: {$date_styles['color_hover']};
	background-color: {$date_styles['bg_color_hover']};
	border-color: {$date_styles['border_color_hover']};
}

#$block_id .tags-wrapper {
	gap: {$tag_styles['gap']};
	font-size: {$tag_styles['font']['size']};
	font-weight: {$tag_styles['font']['weight']};
	font-family: {$tag_styles['font']['family']};
	text-transform: {$tag_styles['text_transform']};
	line-height: {$tag_styles['line_height']};
	letter-spacing: {$tag_styles['letter_spacing']};
	{$tag_box_padding}
}
#$block_id .tags-wrapper a {
	{$tag_padding}
	{$tag_border}
	border-radius: {$attributes['tagStyles']['radius']};
	text-decoration: {$tag_styles['decoration']};
	color: {$tag_styles['color']};
	background-color: {$tag_styles['bg_color']};
}
#$block_id .tags-wrapper a:hover {
	color: {$tag_styles['color_hover']};
	background-color: {$tag_styles['bg_color_hover']};
	border-color: {$tag_styles['border_color_hover']};
}
";

$classes   = array();
$classes[] = 'cozy-block-featured-post-tabs';
$classes[] = 'display-' . $attributes['display'];
$classes[] = $attributes['tabStyles']['active']['tabOverlay'] ? 'has-tab-overlay' : '';
$classes[] = $attributes['postBoxStyles']['shadow']['enabled'] ? 'post-box-has-shadow' : '';
$output    = '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '" id="' . esc_attr( $block_id ) . '">';

// <-- Tabs -->.
$output                 .= '<article class="cozy-block-featured-post-tabs__tabs">';
$cozy_featured_post_tabs = array(
	'latest'   => esc_html__( 'Latest', 'cozy-addons' ),
	'popular'  => esc_html__( 'Popular', 'cozy-addons' ),
	'trending' => esc_html__( 'Trending', 'cozy-addons' ),
	'tags'     => esc_html__( 'Tags', 'cozy-addons' ),
	'comments' => esc_html__( 'Comments', 'cozy-addons' ),
);

$index = 0;
foreach ( $cozy_featured_post_tabs as $key => $label ) {
	if ( $attributes['enableOptions'][ $key ] ) {
		$active_class = 0 === $index ? ' active-tab' : '';

		$output .= '<div class="cozy-block-featured-post-tabs__tab' . $active_class . '" id="' . esc_attr( $key ) . '" data-index="' . $index . '">';
		if ( $attributes['icon']['enabled'] ) {
			$output .= '<div style="display:flex;flex-wrap:wrap;gap:' . cozy_addons_sanitize_dimension( $attributes['icon']['gap'] ) . ';align-items:center;">';
			if ( 'icon-only' === $attributes['icon']['position'] ) {
				$output .= '<div class="cozy-block-featured-post-tabs__icon-wrapper view-' . esc_attr( sanitize_html_class( $attributes['icon']['view'] ) ) . ' layout-' . esc_attr( sanitize_html_class( $attributes['icon']['layout'] ) ) . '">';
				$output .= '<svg class="cozy-block-featured-post-tabs__icon" xmlns="http://www.w3.org/2000/svg"	aria-hidden="true" viewBox="' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vx'] ) ) . ' ' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vy'] ) ) . ' ' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vw'] ) ) . ' ' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vh'] ) ) . '" stroke-width="' . cozy_addons_sanitize_dimension( $icon_styles['stroke_width'] ) . '" stroke-opacity="' . cozy_addons_sanitize_dimension( $icon_styles['stroke_opacity'] ) . '">';
				$output .= '<path d="' . esc_attr( $attributes['icon'][ $key ]['path'] ) . '"></path>';
				$output .= '</svg>';
				$output .= '</div>';
			} elseif ( 'before' === $attributes['icon']['position'] ) {
				$output .= '<div class="cozy-block-featured-post-tabs__icon-wrapper view-' . esc_attr( sanitize_html_class( $attributes['icon']['view'] ) ) . ' layout-' . esc_attr( sanitize_html_class( $attributes['icon']['layout'] ) ) . '">';
				$output .= '<svg class="cozy-block-featured-post-tabs__icon" xmlns="http://www.w3.org/2000/svg"	aria-hidden="true" viewBox="' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vx'] ) ) . ' ' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vy'] ) ) . ' ' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vw'] ) ) . ' ' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vh'] ) ) . '" stroke-width="' . cozy_addons_sanitize_dimension( $icon_styles['stroke_width'] ) . '" stroke-opacity="' . cozy_addons_sanitize_dimension( $icon_styles['stroke_opacity'] ) . '">';
				$output .= '<path d="' . esc_attr( $attributes['icon'][ $key ]['path'] ) . '"></path>';
				$output .= '</svg>';
				$output .= '</div>';
				$output .= '<p>' . $label . '</p>';
			} else {
				$output .= '<p>' . $label . '</p>';
				$output .= '<div class="cozy-block-featured-post-tabs__icon-wrapper view-' . esc_attr( sanitize_html_class( $attributes['icon']['view'] ) ) . ' layout-' . esc_attr( sanitize_html_class( $attributes['icon']['layout'] ) ) . '">';
				$output .= '<svg class="cozy-block-featured-post-tabs__icon" xmlns="http://www.w3.org/2000/svg"	aria-hidden="true" viewBox="' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vx'] ) ) . ' ' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vy'] ) ) . ' ' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vw'] ) ) . ' ' . esc_attr( intval( $attributes['icon'][ $key ]['viewBox']['vh'] ) ) . '" stroke-width="' . cozy_addons_sanitize_dimension( $icon_styles['stroke_width'] ) . '" stroke-opacity="' . cozy_addons_sanitize_dimension( $icon_styles['stroke_opacity'] ) . '">';
				$output .= '<path d="' . esc_attr( $attributes['icon'][ $key ]['path'] ) . '"></path>';
				$output .= '</svg>';
				$output .= '</div>';
			}
			$output .= '</div>';
		} else {
			$output .= esc_html( $label );
		}
		$output .= '</div>';

		++$index;

	}
}
$output .= '</article>';
// <-- Tabs /-->.

// <-- Post Content -->.
if ( ! function_exists( 'cozy_render_featured_post_tab_data' ) ) {
	function cozy_render_featured_post_tab_data( $post, $attributes ) {
		$output = '<div class="post__content-wrapper" style="display:flex;gap:' . esc_attr( $attributes['imageStyles']['gap'] ) . ';">';

		if ( $attributes['postOptions']['postImage'] && ! empty( $post['post_image_url'] ) ) {
			$has_post_link = isset( $attributes['postOptions']['imgLinkPost'] ) && $attributes['postOptions']['imgLinkPost'] ? 'href="' . esc_url( $post['post_link'] ) . '"' : '';
			$open_new_tab  = isset( $attributes['postOptions']['imgLinkPost'], $attributes['postOptions']['imgOpenLinkNewTab'] ) && $attributes['postOptions']['imgLinkPost'] && $attributes['postOptions']['imgOpenLinkNewTab'] ? '_blank' : '';
			$output       .= '<figure class="cozy-block-featured-post-tabs__post-image' . ( $attributes['imageStyles']['hoverEffect'] ? ' has-hover-effect' : '' ) . '">';
			$output       .= '<a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener"><img src="' . esc_url( $post['post_image_url'] ) . '" /></a>';
			$output       .= '</figure>';
		}

		$output .= '<div>';

		if ( $attributes['postOptions']['categories'] ) {
			$output .= '<div class="cozy-block-featured-post-tabs__post-categories' . ( $attributes['categoryStyles']['hoverEffect'] ? ' has-hover-effect' : '' ) . '">';
			if ( ! empty( $post['post_categories'] ) ) {
				$open_new_tab = isset( $attributes['postOptions']['linkCat'], $attributes['postOptions']['catLinkNewTab'] ) && $attributes['postOptions']['linkCat'] && $attributes['postOptions']['catLinkNewTab'] ? '_blank' : '';
				foreach ( $post['post_categories'] as $cat ) {
					$has_cat_link = isset( $attributes['postOptions']['linkCat'] ) && $attributes['postOptions']['linkCat'] ? 'href="' . esc_url( $cat['link'] ) . '"' : '';
					$output      .= '<a ' . $has_cat_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $cat['name'] ) . '</a>';
				}
			}
			$output .= '</div>';
		}

		$has_post_link      = isset( $attributes['postOptions']['titleLinkPost'] ) && $attributes['postOptions']['titleLinkPost'] ? 'href="' . esc_url( $post['post_link'] ) . '"' : '';
		$open_new_tab       = isset( $attributes['postOptions']['titleLinkPost'], $attributes['postOptions']['titleOpenLinkNewTab'] ) && $attributes['postOptions']['titleLinkPost'] && $attributes['postOptions']['titleOpenLinkNewTab'] ? '_blank' : '';
		$classes            = array();
		$classes[]          = 'cozy-block-featured-post-tabs__post-title';
		$additional_classes = isset( $attributes['titleStyles']['className'] ) ? $attributes['titleStyles']['className'] : '';
		if ( ! empty( $additional_classes ) ) {
			$classes = array_merge( $classes, explode( ' ', $additional_classes ) );
		}
		$output .= '<h4 class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $post['post_title'] ) . '</a></h4>';

		if ( $attributes['postOptions']['postContent'] ) {
			$output .= '<p class="cozy-block-featured-post-tabs__post-content">';
			if ( isset( $post['post_excerpt'] ) && ! empty( $post['post_excerpt'] ) ) {
				$output .= cozy_create_excerpt( $post['post_excerpt'], $attributes['postOptions']['excerpt'] );
			} else {
				$output .= cozy_create_excerpt( $post['post_content'], $attributes['postOptions']['excerpt'] );
			}
			$output .= '</p>';
		}

		if ( $attributes['postOptions']['postDate'] ) {
			$has_post_link = isset( $attributes['postOptions']['linkPostMeta'] ) && $attributes['postOptions']['linkPostMeta'] ? 'href="' . esc_url( $post['post_link'] ) . '"' : '';
			$open_new_tab  = isset( $attributes['postOptions']['linkPostMeta'], $attributes['postOptions']['postMetaOpenLinkNewTab'] ) && $attributes['postOptions']['linkPostMeta'] && $attributes['postOptions']['postMetaOpenLinkNewTab'] ? '_blank' : '';
			$output       .= '<p class="cozy-block-featured-post-tabs__post-date"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $post['post_date_formatted'] ) . '</a></p>';
		}

		$output .= '</div></div>';

		return $output;
	}
}

if ( ! function_exists( 'cozy_fetch_featured_post_tab_data' ) ) {

	/**
	 * Fetches featured post tab data.
	 *
	 * Retrieves the data needed to populate the featured post tab,
	 * including post information and metadata.
	 *
	 * @return array Featured post tab data.
	 */
	function cozy_fetch_featured_post_tab_data( $tab, $attributes ) {
		$data = array();

		switch ( $tab ) {
			case 'comments':
				global $wpdb;
				$per_page = intval( $attributes['perPage'][ $tab ] );
				// Get all approved comments.
				$all_comments = $wpdb->get_results(
					$wpdb->prepare(
						"
						SELECT c.comment_ID, c.comment_post_ID, c.comment_author, c.comment_author_email, c.comment_content, c.comment_date
						FROM $wpdb->comments c
						INNER JOIN $wpdb->posts p ON c.comment_post_ID = p.ID
						WHERE c.comment_approved = '1'
						AND p.post_type = 'post'
						ORDER BY c.comment_date DESC
						LIMIT %d
						",
						$per_page,
					)
				);

				$comments_formatted = array();

				// Get the total comment count for each comment's post.
				foreach ( $all_comments as $comment ) {
					$comment->comment_author_avatar = get_avatar_url( $comment->comment_author_email );
					$comment->link                  = get_comment_link( $comment->comment_ID );
					$comment->formatted_date        = gmdate( 'F j, Y', strtotime( $comment->comment_date ) );

					$comments_formatted[] = $comment;
				}

				// Get the top comments.
				$data = array_slice( $comments_formatted, 0, $per_page );

				wp_reset_postdata();
				break;

			case 'tags':
				$per_page     = intval( $attributes['perPage'][ $tab ] );
				$popular_tags = get_terms(
					array(
						'taxonomy'   => 'post_tag',
						'orderby'    => 'count',
						'order'      => 'DESC',
						'number'     => $per_page,
						'hide_empty' => true,
					)
				);

				$tags_with_links = array();
				foreach ( $popular_tags as $tag ) {
					$tag->link         = get_term_link( $tag );
					$tags_with_links[] = $tag;
				}

				wp_reset_postdata();
				$data = $tags_with_links;
				break;

			default:
				$per_page = intval( $attributes['perPage'][ $tab ] );
				$args     = array();

				switch ( $tab ) {
					case 'popular':
						$args = array(
							'post_type'           => 'post',
							'meta_key'            => 'cozy_post_views_count', // Replace with your popularity field.
							'orderby'             => 'meta_value_num',
							'order'               => 'DESC',
							'post_status'         => 'publish',
							'ignore_sticky_posts' => 1,
							'posts_per_page'      => $per_page, // Number of popular posts to retrieve.
						);
						break;

					case 'trending':
						$args = array(
							'post_type'           => 'post',
							'meta_key'            => 'cozy_trending_post_views', // Replace with your popularity field.
							'orderby'             => 'meta_value_num',
							'order'               => 'DESC',
							'post_status'         => 'publish',
							'ignore_sticky_posts' => 1,
							'posts_per_page'      => $per_page, // Number of popular posts to retrieve.
						);
						break;

					default:
						$args = array(
							'post_type'      => 'post',
							'orderby'        => 'date',
							'order'          => 'DESC',
							'post_status'    => 'publish',
							'posts_per_page' => $per_page, // Number of popular posts to retrieve.
						);
						if ( isset( $attributes['enableOptions']['excludeStickyPost'] ) && $attributes['enableOptions']['excludeStickyPost'] === true ) {
							$args['post__not_in'] = get_option( 'sticky_posts' );
						}
				}
				$latest_posts = new \WP_Query( $args );

				$additional_post_data = array();

				foreach ( $latest_posts->posts as $post ) {
					$post_image_url              = get_the_post_thumbnail_url( $post->ID );
					$post_link                   = get_permalink( $post->ID );
					$post_id                     = $post->ID;
					$post_data                   = (array) $post; // Convert WP_Post object to an array.
					$post_data['post_image_url'] = $post_image_url;

					// Get categories and their links.
					$categories      = get_the_category( $post->ID );
					$post_categories = array();
					foreach ( $categories as $category ) {
						$post_categories[] = array(
							'name'        => $category->name,
							'link'        => get_category_link( $category->term_id ),
							'count'       => $category->count,
							'description' => $category->description,
							'slug'        => $category->slug,
							'taxonomy'    => $category->taxonomy,
							'parent'      => $category->parent,
						);
					}
					$post_data['post_categories'] = $post_categories;

					$post_data['post_excerpt'] = get_the_excerpt( $post_id );

					$post_data['post_link']           = $post_link;
					$post_data['post_date_formatted'] = get_the_date( '', $post_id );
					$additional_post_data[]           = $post_data;
				}

				wp_reset_postdata();

				$data = $additional_post_data;
				break;
		}

		if ( empty( $data ) ) {
			return '';
		}

		$render_html = '';

		switch ( $tab ) {
			case 'tags':
				$open_new_tab = isset( $attributes['enableOptions']['tagsLinkNewTab'] ) && $attributes['enableOptions']['tagsLinkNewTab'] ? '_blank' : '';
				foreach ( $data as $tag ) {
					$render_html .= '<div class="cozy-block-featured-post-tabs__tag"><a href="' . esc_url( $tag->link ) . '" target="' . $open_new_tab . '" rel="noopener">' . esc_html( $tag->name ) . '</a></div>';
				}
				break;

			case 'comments':
				$cmt_open_new_tab = isset( $attributes['enableOptions']['commentsLinkNewTab'] ) && $attributes['enableOptions']['commentsLinkNewTab'] ? '_blank' : '';
				foreach ( $data as $comment ) {
					$render_html .= '<div class="cozy-block-featured-post-tabs__comment">
                      <p class="cozy-block-featured-post-tabs__comment-content">' . cozy_create_excerpt( $comment->comment_content ) . '</p>
                      <a href="' . esc_url( $comment->link ) . '" target="' . $cmt_open_new_tab . '" rel="noopener">
                        <div style="display:flex;gap:10px;margin-top:10px;">
                            <img class="cozy-block-featured-post-tabs__author-avatar" src="' . esc_url( $comment->comment_author_avatar ) . '" width="50" height="50" style="border-radius:100px;"/>
                            <div>
                              <p class="cozy-block-featured-post-tabs__comment-author">' . esc_html( $comment->comment_author ) . '</p>
                              <p class="cozy-block-featured-post-tabs__comment-date">' . esc_html( $comment->formatted_date ) . '</p>
                            </div>
                      </div>
                      </a>
                      </div>';
				}
				break;

			default:
				foreach ( $data as $post ) {
					$render_html .= '<div class="cozy-block-featured-post-tabs__content">' . cozy_render_featured_post_tab_data( $post, $attributes ) . '</div>';
				}
				break;
		}

		return '<div class="' . esc_attr( $tab ) . '-wrapper">' . $render_html . '</div>';
	}
}

$index = 0;
foreach ( $cozy_featured_post_tabs as $key => $label ) {
	if ( $attributes['enableOptions'][ $key ] ) {
		$classes   = array();
		$classes[] = 'cozy-block-featured-post-tabs__content-wrapper';
		$classes[] = 0 === $index ? 'active-content' : '';
		$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';

		$output .= cozy_fetch_featured_post_tab_data( $key, $attributes );

		$output .= '</div>';

		++$index;
	}
}
// <-- Post Content /-->.

$output .= '</div>';

$font_families = array();

if ( isset( $attributes['tabStyles']['fontFamily'] ) && ! empty( $attributes['tabStyles']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['tabStyles']['fontFamily'] );
}
if ( isset( $attributes['categoryStyles']['fontFamily'] ) && ! empty( $attributes['categoryStyles']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['categoryStyles']['fontFamily'] );
}
if ( isset( $attributes['titleStyles']['fontFamily'] ) && ! empty( $attributes['titleStyles']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['titleStyles']['fontFamily'] );
}
if ( isset( $attributes['dateStyles']['fontFamily'] ) && ! empty( $attributes['dateStyles']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['dateStyles']['fontFamily'] );
}
if ( isset( $attributes['tagStyles']['fontFamily'] ) && ! empty( $attributes['tagStyles']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['tagStyles']['fontFamily'] );
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

$wrapper_attributes = get_block_wrapper_attributes();

$render = sprintf( '<div class="cozy-block-wrapper"><div %1$s>%2$s</div></div>', $wrapper_attributes, $output );
echo $render;
