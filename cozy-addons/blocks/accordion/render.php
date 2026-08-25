<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id               = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['blockClientId'] ) ) : '';
$cozy_block_var          = 'cozyAccordion_' . str_replace( '-', '_', $client_id );
$attributes['isPremium'] = cozy_addons_premium_access();

wp_localize_script( 'cozy-block--accordion--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--accordion--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockAccordionInit( "' . $client_id . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$container_styles = array(
	'padding'      => array(
		'top'    => isset( $attributes['containerStyles']['padding']['top'] ) && ! empty( $attributes['containerStyles']['padding']['top'] ) ? esc_attr( $attributes['containerStyles']['padding']['top'] ) : '0',
		'right'  => isset( $attributes['containerStyles']['padding']['right'] ) && ! empty( $attributes['containerStyles']['padding']['right'] ) ? esc_attr( $attributes['containerStyles']['padding']['right'] ) : '0',
		'bottom' => isset( $attributes['containerStyles']['padding']['bottom'] ) && ! empty( $attributes['containerStyles']['padding']['bottom'] ) ? esc_attr( $attributes['containerStyles']['padding']['bottom'] ) : '0',
		'left'   => isset( $attributes['containerStyles']['padding']['left'] ) && ! empty( $attributes['containerStyles']['padding']['left'] ) ? esc_attr( $attributes['containerStyles']['padding']['left'] ) : '0',
	),
	'border_style' => isset( $attributes['containerStyles']['border']['type'] ) ? esc_attr( $attributes['containerStyles']['border']['type'] ) : '',
	'border_width' => array(
		'top'    => isset( $attributes['containerStyles']['border']['width']['top'] ) && ! empty( $attributes['containerStyles']['border']['width']['top'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['top'] ) : '0',
		'right'  => isset( $attributes['containerStyles']['border']['width']['right'] ) && ! empty( $attributes['containerStyles']['border']['width']['right'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['right'] ) : '0',
		'bottom' => isset( $attributes['containerStyles']['border']['width']['bottom'] ) && ! empty( $attributes['containerStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['bottom'] ) : '0',
		'left'   => isset( $attributes['containerStyles']['border']['width']['left'] ) && ! empty( $attributes['containerStyles']['border']['width']['left'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['left'] ) : '0',
	),
	'radius'       => array(
		'top'    => isset( $attributes['containerStyles']['borderRadius']['top'] ) && ! empty( $attributes['containerStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['top'] ) : '0',
		'right'  => isset( $attributes['containerStyles']['borderRadius']['right'] ) && ! empty( $attributes['containerStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['right'] ) : '0',
		'bottom' => isset( $attributes['containerStyles']['borderRadius']['bottom'] ) && ! empty( $attributes['containerStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['bottom'] ) : '0',
		'left'   => isset( $attributes['containerStyles']['borderRadius']['left'] ) && ! empty( $attributes['containerStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['left'] ) : '0',
	),
	'gap'          => isset( $attributes['rowGap'] ) && ! empty( $attributes['rowGap'] ) ? esc_attr( $attributes['rowGap'] ) : '',
);
$container_color  = array(
	'bg'     => isset( $attributes['containerStyles']['bgColor'] ) ? esc_attr( $attributes['containerStyles']['bgColor'] ) : '',
	'border' => isset( $attributes['containerStyles']['border']['color'] ) ? esc_attr( $attributes['containerStyles']['border']['color'] ) : '',
);

$layout        = array(
	'width'   => isset( $attributes['layout']['width'] ) ? esc_attr( sanitize_text_field( $attributes['layout']['width'] ) ) : '',
	'justify' => isset( $attributes['layout']['justify'] ) ? esc_attr( sanitize_text_field( $attributes['layout']['justify'] ) ) : '',
	'gap'     => isset( $attributes['layout']['gap'] ) ? esc_attr( sanitize_text_field( $attributes['layout']['gap'] ) ) : '',
);
$search_styles = array(
	'width'          => isset( $attributes['search']['width'] ) ? esc_attr( sanitize_text_field( $attributes['search']['width'] ) ) : '',
	'margin'         => isset( $attributes['search']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['search']['margin'] ) : '',
	'border'         => isset( $attributes['search']['border'] ) ? cozy_render_TRBL( 'border', $attributes['search']['border'] ) : '',
	'radius'         => isset( $attributes['search']['radius'] ) ? esc_attr( sanitize_text_field( $attributes['search']['radius'] ) ) : '',
	'font'           => array(
		'size'   => isset( $attributes['search']['font']['size'] ) ? esc_attr( sanitize_text_field( $attributes['search']['font']['size'] ) ) : '',
		'weight' => isset( $attributes['search']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['search']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['search']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['search']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['search']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['search']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['search']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['search']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['search']['lineHeight'] ) ? esc_attr( sanitize_text_field( $attributes['search']['lineHeight'] ) ) : '',
	'letter_spacing' => isset( $attributes['search']['letterSpacing'] ) ? esc_attr( sanitize_text_field( $attributes['search']['letterSpacing'] ) ) : '',
	'color'          => array(
		'text'          => isset( $attributes['search']['color']['text'] ) ? esc_attr( sanitize_text_field( $attributes['search']['color']['text'] ) ) : '',
		'text_active'   => isset( $attributes['search']['color']['textActive'] ) ? esc_attr( sanitize_text_field( $attributes['search']['color']['textActive'] ) ) : '',
		'bg'            => isset( $attributes['search']['color']['bg'] ) ? esc_attr( sanitize_text_field( $attributes['search']['color']['bg'] ) ) : '',
		'bg_active'     => isset( $attributes['search']['color']['bgActive'] ) ? esc_attr( sanitize_text_field( $attributes['search']['color']['bgActive'] ) ) : '',
		'border_active' => isset( $attributes['search']['color']['borderActive'] ) ? esc_attr( sanitize_text_field( $attributes['search']['color']['borderActive'] ) ) : '',
	),
);
$cat_styles    = array(
	'gap'            => isset( $attributes['category']['gap'] ) ? esc_attr( sanitize_text_field( $attributes['category']['gap'] ) ) : '',
	'padding'        => isset( $attributes['category']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['category']['padding'] ) : '',
	'margin'         => isset( $attributes['category']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['category']['margin'] ) : '',
	'border'         => isset( $attributes['category']['border'] ) ? cozy_render_TRBL( 'border', $attributes['category']['border'] ) : '',
	'border_active'  => isset( $attributes['category']['borderActive'] ) ? cozy_render_TRBL( 'border', $attributes['category']['borderActive'] ) : '',
	'radius'         => isset( $attributes['category']['radius'] ) ? esc_attr( sanitize_text_field( $attributes['category']['radius'] ) ) : '',
	'font'           => array(
		'size'   => isset( $attributes['category']['font']['size'] ) ? esc_attr( sanitize_text_field( $attributes['category']['font']['size'] ) ) : '',
		'weight' => isset( $attributes['category']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['category']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['category']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['category']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['category']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['category']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['category']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['category']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['category']['lineHeight'] ) ? esc_attr( sanitize_text_field( $attributes['category']['lineHeight'] ) ) : '',
	'letter_spacing' => isset( $attributes['category']['letterSpacing'] ) ? esc_attr( sanitize_text_field( $attributes['category']['letterSpacing'] ) ) : '',
	'color'          => array(
		'text'        => isset( $attributes['category']['color']['text'] ) ? esc_attr( sanitize_text_field( $attributes['category']['color']['text'] ) ) : '',
		'text_active' => isset( $attributes['category']['color']['textActive'] ) ? esc_attr( sanitize_text_field( $attributes['category']['color']['textActive'] ) ) : '',
		'bg'          => isset( $attributes['category']['color']['bg'] ) ? esc_attr( sanitize_text_field( $attributes['category']['color']['bg'] ) ) : '',
		'bg_active'   => isset( $attributes['category']['color']['bgActive'] ) ? esc_attr( sanitize_text_field( $attributes['category']['color']['bgActive'] ) ) : '',
	),
);

$item_styles = array(
	'padding'      => array(
		'top'    => isset( $attributes['accordionStyles']['padding']['top'] ) && ! empty( $attributes['accordionStyles']['padding']['top'] ) ? esc_attr( $attributes['accordionStyles']['padding']['top'] ) : '0',
		'right'  => isset( $attributes['accordionStyles']['padding']['right'] ) && ! empty( $attributes['accordionStyles']['padding']['right'] ) ? esc_attr( $attributes['accordionStyles']['padding']['right'] ) : '0',
		'bottom' => isset( $attributes['accordionStyles']['padding']['bottom'] ) && ! empty( $attributes['accordionStyles']['padding']['bottom'] ) ? esc_attr( $attributes['accordionStyles']['padding']['bottom'] ) : '0',
		'left'   => isset( $attributes['accordionStyles']['padding']['left'] ) && ! empty( $attributes['accordionStyles']['padding']['left'] ) ? esc_attr( $attributes['accordionStyles']['padding']['left'] ) : '0',
	),
	'border_style' => isset( $attributes['accordionStyles']['border']['type'] ) ? esc_attr( $attributes['accordionStyles']['border']['type'] ) : '',
	'border_width' => array(
		'top'    => isset( $attributes['accordionStyles']['border']['width']['top'] ) && ! empty( $attributes['accordionStyles']['border']['width']['top'] ) ? esc_attr( $attributes['accordionStyles']['border']['width']['top'] ) : '0',
		'right'  => isset( $attributes['accordionStyles']['border']['width']['right'] ) && ! empty( $attributes['accordionStyles']['border']['width']['right'] ) ? esc_attr( $attributes['accordionStyles']['border']['width']['right'] ) : '0',
		'bottom' => isset( $attributes['accordionStyles']['border']['width']['bottom'] ) && ! empty( $attributes['accordionStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['accordionStyles']['border']['width']['bottom'] ) : '0',
		'left'   => isset( $attributes['accordionStyles']['border']['width']['left'] ) && ! empty( $attributes['accordionStyles']['border']['width']['left'] ) ? esc_attr( $attributes['accordionStyles']['border']['width']['left'] ) : '0',
	),
	'radius'       => array(
		'top'    => isset( $attributes['accordionStyles']['borderRadius']['top'] ) && ! empty( $attributes['accordionStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['accordionStyles']['borderRadius']['top'] ) : '0',
		'right'  => isset( $attributes['accordionStyles']['borderRadius']['right'] ) && ! empty( $attributes['accordionStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['accordionStyles']['borderRadius']['right'] ) : '0',
		'bottom' => isset( $attributes['accordionStyles']['borderRadius']['bottom'] ) && ! empty( $attributes['accordionStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['accordionStyles']['borderRadius']['bottom'] ) : '0',
		'left'   => isset( $attributes['accordionStyles']['borderRadius']['left'] ) && ! empty( $attributes['accordionStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['accordionStyles']['borderRadius']['left'] ) : '0',
	),
);
$item_color  = array(
	'bg'     => isset( $attributes['accordionStyles']['bgColor'] ) ? esc_attr( $attributes['accordionStyles']['bgColor'] ) : '',
	'border' => isset( $attributes['accordionStyles']['border']['color'] ) ? esc_attr( $attributes['accordionStyles']['border']['color'] ) : '',
);

$title_styles = array(
	'margin'         => array(
		'top'    => isset( $attributes['titleTypography']['margin']['top'] ) && ! empty( $attributes['titleTypography']['margin']['top'] ) ? esc_attr( $attributes['titleTypography']['margin']['top'] ) : '',
		'bottom' => isset( $attributes['titleTypography']['margin']['bottom'] ) && ! empty( $attributes['titleTypography']['margin']['bottom'] ) ? esc_attr( $attributes['titleTypography']['margin']['bottom'] ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['titleTypography']['fontSize'] ) && ! empty( $attributes['titleTypography']['fontSize'] ) ? esc_attr( $attributes['titleTypography']['fontSize'] ) : '',
		'weight' => isset( $attributes['titleTypography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['titleTypography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['titleTypography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['titleTypography']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['titleTypography']['lineHeight'] ) && ! empty( $attributes['titleTypography']['lineHeight'] ) ? esc_attr( $attributes['titleTypography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['titleTypography']['letterSpacing'] ) && ! empty( $attributes['titleTypography']['letterSpacing'] ) ? esc_attr( $attributes['titleTypography']['letterSpacing'] ) : '',
);
$title_color  = array(
	'text'   => isset( $attributes['titleTypography']['color'] ) ? esc_attr( $attributes['titleTypography']['color'] ) : '',
	'active' => isset( $attributes['titleTypography']['colorActive'] ) ? esc_attr( $attributes['titleTypography']['colorActive'] ) : '',
);

$content_styles = array(
	'font'           => array(
		'size'   => isset( $attributes['typography']['fontSize'] ) && ! empty( $attributes['typography']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['typography']['fontSize'] ) : '',
		'weight' => isset( $attributes['typography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['typography']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['typography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['typography']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['typography']['lineHeight'] ) && ! empty( $attributes['typography']['lineHeight'] ) ? esc_attr( $attributes['typography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['typography']['letterSpacing'] ) && ! empty( $attributes['typography']['letterSpacing'] ) ? esc_attr( $attributes['typography']['letterSpacing'] ) : '',
);
$content_color  = array(
	'text' => isset( $attributes['typography']['color'] ) ? esc_attr( $attributes['typography']['color'] ) : '',
);

$icon_styles = array(
	'padding'       => array(
		'top'    => isset( $attributes['iconBoxStyles']['padding']['top'] ) && ! empty( $attributes['iconBoxStyles']['padding']['top'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['iconBoxStyles']['padding']['right'] ) && ! empty( $attributes['iconBoxStyles']['padding']['right'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['iconBoxStyles']['padding']['bottom'] ) && ! empty( $attributes['iconBoxStyles']['padding']['bottom'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['iconBoxStyles']['padding']['left'] ) && ! empty( $attributes['iconBoxStyles']['padding']['left'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['left'] ) : '',
	),
	'border'        => array(
		'width' => isset( $attributes['iconBoxStyles']['borderWidth'] ) && ! empty( $attributes['iconBoxStyles']['borderWidth'] ) ? esc_attr( $attributes['iconBoxStyles']['borderWidth'] ) : '',
		'style' => isset( $attributes['iconBoxStyles']['borderType'] ) ? esc_attr( $attributes['iconBoxStyles']['borderType'] ) : '',
	),
	'radius'        => isset( $attributes['iconBoxStyles']['borderRadius'] ) ? esc_attr( $attributes['iconBoxStyles']['borderRadius'] ) : '',
	'size'          => isset( $attributes['icon']['size'] ) && ! empty( $attributes['icon']['size'] ) ? esc_attr( $attributes['icon']['size'] ) : '',
	'gap'           => isset( $attributes['icon']['gap'] ) && ! empty( $attributes['icon']['gap'] ) ? esc_attr( $attributes['icon']['gap'] ) : '6px',
	'opacity'       => isset( $attributes['icon']['opacity'] ) ? esc_attr( $attributes['icon']['opacity'] ) : '',
	'rotate'        => isset( $attributes['icon']['rotate'] ) ? esc_attr( $attributes['icon']['rotate'] ) : '0',
	'rotate_active' => isset( $attributes['icon']['rotateActive'] ) ? esc_attr( $attributes['icon']['rotateActive'] ) : '',
);
$icon_color  = array(
	'bg'           => isset( $attributes['iconBoxStyles']['bgColor'] ) ? esc_attr( $attributes['iconBoxStyles']['bgColor'] ) : '',
	'border'       => isset( $attributes['iconBoxStyles']['borderColor'] ) ? esc_attr( $attributes['iconBoxStyles']['borderColor'] ) : '',
	'bg_hover'     => isset( $attributes['iconBoxStyles']['bgColorHover'] ) ? esc_attr( $attributes['iconBoxStyles']['bgColorHover'] ) : '',
	'border_hover' => isset( $attributes['iconBoxStyles']['borderColorHover'] ) ? esc_attr( $attributes['iconBoxStyles']['borderColorHover'] ) : '',
	'icon'         => isset( $attributes['icon']['color'] ) ? esc_attr( $attributes['icon']['color'] ) : '',
	'icon_hover'   => isset( $attributes['icon']['colorHover'] ) ? esc_attr( $attributes['icon']['colorHover'] ) : '',
);

$block_styles = "
#$block_id {
    padding-top: {$container_styles['padding']['top']}px;
    padding-right: {$container_styles['padding']['right']}px;
    padding-bottom: {$container_styles['padding']['bottom']}px;
    padding-left: {$container_styles['padding']['left']}px;
    border-style: {$container_styles['border_style']};
    border-top-width: {$container_styles['border_width']['top']}px;
    border-right-width: {$container_styles['border_width']['right']}px;
    border-bottom-width: {$container_styles['border_width']['bottom']}px;
    border-left-width: {$container_styles['border_width']['left']}px;
    border-color: {$container_color['border']};
    border-top-left-radius: {$container_styles['radius']['top']}px;
    border-top-right-radius: {$container_styles['radius']['right']}px;
    border-bottom-right-radius: {$container_styles['radius']['bottom']}px;
    border-bottom-left-radius: {$container_styles['radius']['left']}px;
    background-color: {$container_color['bg']};
}

#$block_id.layout-orientation-stack .accordion-header {
	text-align: {$layout['justify']};
}
#$block_id.layout-orientation-stack .category-tabs, #$block_id.layout-orientation-row .category-tab-item {
	justify-content: {$layout['justify']};
}
#$block_id.layout-orientation-row {
	gap: {$layout['gap']};
}
#$block_id.layout-orientation-row .accordion-header {
	max-width: {$layout['width']};
}

#$block_id .search-wrapper {
	{$search_styles['margin']}

	& #search-icon {
		color: {$search_styles['color']['text']};
	}
}
#$block_id #accordion-search {
	{$search_styles['border']}
	border-radius: {$search_styles['radius']};
	font-size: {$search_styles['font']['size']};
	font-weight: {$search_styles['font']['weight']};
	font-family: '{$search_styles['font']['family']}';
	text-transform: {$search_styles['letter_case']};
	text-decoration: {$search_styles['decoration']};
	line-height: {$search_styles['line_height']};
	letter-spacing: {$search_styles['letter_spacing']};
	color: {$search_styles['color']['text']};
	background-color: {$search_styles['color']['bg']};
}
#$block_id.layout-orientation-stack #accordion-search {
	max-width: {$search_styles['width']};
}
#$block_id #accordion-search:focus {
	color: {$search_styles['color']['text_active']};
	background-color: {$search_styles['color']['bg_active']};
	border-color: {$search_styles['color']['border_active']};
}

#$block_id .category-tabs {
	gap: {$cat_styles['gap']};
	{$cat_styles['margin']}
	font-size: {$cat_styles['font']['size']};
	font-weight: {$cat_styles['font']['weight']};
	font-family: '{$cat_styles['font']['family']}';
	text-transform: {$cat_styles['letter_case']};
	text-decoration: {$cat_styles['decoration']};
	line-height: {$cat_styles['line_height']};
	letter-spacing: {$cat_styles['letter_spacing']};
}
#$block_id .category-tab-item {
	{$cat_styles['padding']}
	{$cat_styles['border']}
	border-radius: {$cat_styles['radius']};
	color: {$cat_styles['color']['text']};
	background-color: {$cat_styles['color']['bg']};
}
#$block_id .category-tab-item.is-active {
	{$cat_styles['border_active']}
	color: {$cat_styles['color']['text_active']};
	background-color: {$cat_styles['color']['bg_active']};
}
#$block_id.layout-orientation-row .category-tab-item:not(first-child){
	margin-top: {$cat_styles['gap']};
}

#$block_id .cozy-accordion-wrapper {
    row-gap: {$container_styles['gap']}px;
}

#$block_id .cozy-block-accordion-item {
    padding-top: {$item_styles['padding']['top']}px;
    padding-right: {$item_styles['padding']['right']}px;
    padding-bottom: {$item_styles['padding']['bottom']}px;
    padding-left: {$item_styles['padding']['left']}px;
    border-style: {$item_styles['border_style']};
    border-top-width: {$item_styles['border_width']['top']}px;
    border-right-width: {$item_styles['border_width']['right']}px;
    border-bottom-width: {$item_styles['border_width']['bottom']}px;
    border-left-width: {$item_styles['border_width']['left']}px;
    border-color: {$item_color['border']};
    border-top-left-radius: {$item_styles['radius']['top']}px;
    border-top-right-radius: {$item_styles['radius']['right']}px;
    border-bottom-right-radius: {$item_styles['radius']['bottom']}px;
    border-bottom-left-radius: {$item_styles['radius']['left']}px;
    background-color: {$item_color['bg']};
}

#$block_id .cozy-block-accordion-item .cozy-accordion-title {
	gap: {$icon_styles['gap']};
}
#$block_id .cozy-block-accordion-item .cozy-accordion-title * {
    margin-top: {$title_styles['margin']['top']};
    margin-bottom: {$title_styles['margin']['bottom']};
    font-size: {$title_styles['font']['size']}px;
    font-weight: {$title_styles['font']['weight']};
    font-family: '{$title_styles['font']['family']}';
    text-transform: {$title_styles['letter_case']};
    text-decoration: {$title_styles['decoration']};
    line-height: {$title_styles['line_height']};
    letter-spacing: {$title_styles['letter_spacing']};
    color: {$title_color['text']};
}
#$block_id .cozy-block-accordion-item .cozy-accordion-title.active * {
    color: {$title_color['active']};
}

#$block_id .cozy-block-accordion-item .cozy-accordion-content {
    font-size: {$content_styles['font']['size']}px;
    font-weight: {$content_styles['font']['weight']};
    font-family: '{$content_styles['font']['family']}';
    text-transform: {$content_styles['letter_case']};
    text-decoration: {$content_styles['decoration']};
    line-height: {$content_styles['line_height']};
    letter-spacing: {$content_styles['letter_spacing']};
    color: {$content_color['text']};
}

#$block_id .cozy-accordion-title .accordion-icon-wrapper svg {
    width: {$icon_styles['size']}px;
    height: {$icon_styles['size']}px;
    opacity: {$icon_styles['opacity']};
    transform: rotate({$icon_styles['rotate']}deg);
}

#$block_id.icon-view-stacked .cozy-accordion-title .accordion-icon-wrapper {
    padding-top: {$icon_styles['padding']['top']}px;
    padding-right: {$icon_styles['padding']['right']}px;
    padding-bottom: {$icon_styles['padding']['bottom']}px;
    padding-left: {$icon_styles['padding']['left']}px;
    border-width: {$icon_styles['border']['width']}px 
    border-style: {$icon_styles['border']['style']}; 
    border-color: {$icon_color['border']};
    border-radius: {$icon_styles['radius']}px;
    background-color: {$icon_color['bg']};
}

#$block_id.icon-view-stacked .cozy-accordion-title.active .accordion-icon-wrapper {
    background-color: {$icon_color['bg_hover']};
    border-color: {$icon_color['border_hover']};
}

#$block_id.icon-layout-fill .cozy-accordion-title .accordion-icon-wrapper svg {
    fill: {$icon_color['icon']};
}

#$block_id.icon-layout-outline .cozy-accordion-title .accordion-icon-wrapper svg {
    stroke: {$icon_color['icon']};
    fill: none;
}

#$block_id.icon-layout-fill .cozy-accordion-title.active .accordion-icon-wrapper svg {
    fill: {$icon_color['icon_hover']};
    transform: rotate({$icon_styles['rotate_active']}deg);
}

#$block_id.icon-layout-outline .cozy-accordion-title.active .accordion-icon-wrapper svg {
    stroke: {$icon_color['icon_hover']};
    fill: none;
    transform: rotate({$icon_styles['rotate_active']}deg);
}
";

$font_families = array();

if ( isset( $attributes['category']['font']['family'] ) && ! empty( $attributes['category']['font']['family'] ) ) {
	$font_families[] = esc_attr( sanitize_text_field( $attributes['category']['font']['family'] ) );
}
if ( isset( $attributes['search']['font']['family'] ) && ! empty( $attributes['search']['font']['family'] ) ) {
	$font_families[] = esc_attr( sanitize_text_field( $attributes['search']['font']['family'] ) );
}
if ( isset( $attributes['titleTypography']['fontFamily'] ) && ! empty( $attributes['titleTypography']['fontFamily'] ) ) {
	$font_families[] = esc_attr( sanitize_text_field( $attributes['titleTypography']['fontFamily'] ) );
}
if ( isset( $attributes['typography']['fontFamily'] ) && ! empty( $attributes['typography']['fontFamily'] ) ) {
	$font_families[] = esc_attr( sanitize_text_field( $attributes['typography']['fontFamily'] ) );
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

$faqs = array();

if ( isset( $attributes['layout']['category'], $attributes['category']['allTab'] ) && filter_var( $attributes['layout']['category'], FILTER_VALIDATE_BOOLEAN ) && ! filter_var( $attributes['category']['allTab'], FILTER_VALIDATE_BOOLEAN ) ) {
	$args = array(
		'taxonomy'   => 'ca_faq_category',
		'hide_empty' => true,
		'number'     => 100,
	);

	$categories = get_categories( $args );

	$cat_ids = array_map(
		function ( $cat ) {
			return $cat->cat_ID;
		},
		$categories,
	);

	$args = array(
		'post_type'      => 'ca_faq',
		'post_status'    => 'publish',
		'posts_per_page' => '-1',
		'tax_query'      => array(
			array(
				'taxonomy' => 'ca_faq_category',
				'field'    => 'term_id',
				'terms'    => $cat_ids,
			),
		),
	);

	$faqs = get_posts( $args );

	wp_reset_postdata();
} elseif ( isset( $attributes['category']['allTab'] ) && filter_var( $attributes['category']['allTab'], FILTER_VALIDATE_BOOLEAN ) ) {
	$args = array(
		'post_type'      => 'ca_faq',
		'post_status'    => 'publish',
		'posts_per_page' => '-1',
	);

	$faqs = get_posts( $args );

	wp_reset_postdata();
} else {
	$category = isset( $attributes['query']['category'] ) && is_array( $attributes['query']['category'] ) ? $attributes['query']['category'] : array();
	// Dynamic faq cpt.
	$args = array(
		'post_type'      => 'ca_faq',
		'post_status'    => 'publish',
		'posts_per_page' => isset( $attributes['query']['perPage'], $attributes['layout']['category'] ) && ! filter_var( $attributes['layout']['category'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $attributes['query']['perPage'] ) ? intval( $attributes['query']['perPage'] ) : -1, // To retrieve all sticky posts.
		'order'          => isset( $attributes['query']['order'] ) && ! empty( $attributes['query']['order'] ) ? sanitize_text_field( wp_unslash( $attributes['query']['order'] ) ) : 'DESC',
		'orderby'        => isset( $attributes['query']['orderBy'] ) && ! empty( $attributes['query']['orderBy'] ) ? sanitize_text_field( $attributes['query']['orderBy'] ) : 'date',
	);

	if ( ! empty( $category ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'ca_faq_category',
				'field'    => 'term_id',
				'terms'    => $category,
			),
		);
	}

	$faqs = get_posts( $args );

	wp_reset_postdata();
}

$wrapper_attributes = get_block_wrapper_attributes();
$schema_main_entity = array();
if ( cozy_addons_premium_access() && isset( $attributes['generateSchema'] ) && filter_var( $attributes['generateSchema'], FILTER_VALIDATE_BOOLEAN ) ) {
	if ( ! isset( $attributes['source'] ) || empty( $attributes['source'] ) ) {
		$faq_items = cozy_addons_extract_faq_items_from_content( $content );
		if ( ! empty( $faq_items ) ) {
			foreach ( $faq_items as $schema ) {
				array_push(
					$schema_main_entity,
					array(
						'@type'          => 'Question',
						'name'           => $schema['question'],
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => $schema['answer'],
						),
					)
				);
			}
		}
	} elseif ( isset( $attributes['source'] ) && 'cpt' === $attributes['source'] && ! empty( $faqs ) ) {
		foreach ( $faqs as $faq ) {
			array_push(
				$schema_main_entity,
				array(
					'@type'          => 'Question',
					'name'           => $faq->post_title,
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => wp_strip_all_tags( strip_shortcodes( $faq->post_content ) ),
					),
				)
			);
		}
	}
}

if ( ! empty( $schema_main_entity ) ) {
	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $schema_main_entity,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>';
}

			$allowed_tags = array(
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'div',
				'p',
			);

			$title_tag = isset( $attributes['titleTag'] ) && in_array( $attributes['titleTag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['titleTag'] ) : 'h3';
			?>
<div class="cozy-block-wrapper">
	<div <?php echo $wrapper_attributes; ?>>
		<?php
		if ( ! isset( $attributes['source'] ) || empty( $attributes['source'] ) ) {
			echo $content;
		} elseif ( cozy_addons_premium_access() && isset( $attributes['source'] ) && 'cpt' === $attributes['source'] ) {
			if ( ! empty( $faqs ) ) {
				$classes   = array();
				$classes[] = 'cozy-block-accordion';
				$classes[] = cozy_addons_premium_access() && isset( $attributes['layout']['orientation'] ) && ! empty( $attributes['layout']['orientation'] ) ? 'layout-orientation-' . sanitize_text_field( $attributes['layout']['orientation'] ) : '';
				$classes[] = isset( $attributes['icon']['view'] ) ? 'icon-view-' . sanitize_text_field( $attributes['icon']['view'] ) : '';
				$classes[] = isset( $attributes['icon']['layout'] ) ? 'icon-layout-' . sanitize_text_field( $attributes['icon']['layout'] ) : '';
				$classes[] = cozy_addons_premium_access() && isset( $attributes['layout']['category'] ) && filter_var( $attributes['layout']['category'], FILTER_VALIDATE_BOOLEAN ) ? 'has-category-filter' : '';
				?>
		<div id="<?php echo esc_attr( $block_id ); ?>"
			class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php
				$active_cat_id = 0;
				if ( isset( $attributes['layout']['category'], $attributes['layout']['search'] ) && ( filter_var( $attributes['layout']['category'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['layout']['search'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					?>
			<div class="accordion-header">
					<?php
					$args = array(
						'taxonomy'   => 'ca_faq_category',
						'hide_empty' => true,
						'number'     => 100,
						'order'      => isset( $attributes['category']['order'] ) ? esc_attr( sanitize_text_field( $attributes['category']['order'] ) ) : '',
						'orderby'    => isset( $attributes['category']['orderby'] ) ? esc_attr( sanitize_text_field( $attributes['category']['orderby'] ) ) : '',
					);

					$categories = get_categories( $args );

					wp_reset_postdata();

					if ( filter_var( $attributes['layout']['search'], FILTER_VALIDATE_BOOLEAN ) ) {
						$placeholder = isset( $attributes['search']['placeholder'] ) ? sanitize_text_field( $attributes['search']['placeholder'] ) : '';
						?>
				<div class="search-wrapper">
					<svg version="1.1" id="search-icon"
						xmlns="http://www.w3.org/2000/svg"
						viewBox="0 0 119.828 122.88"
						fill="currentColor">
						<g>
							<path
								d="M48.319,0C61.662,0,73.74,5.408,82.484,14.152c8.744,8.744,14.152,20.823,14.152,34.166 c0,12.809-4.984,24.451-13.117,33.098c0.148,0.109,0.291,0.23,0.426,0.364l34.785,34.737c1.457,1.449,1.465,3.807,0.014,5.265 c-1.449,1.458-3.807,1.464-5.264,0.015L78.695,87.06c-0.221-0.22-0.408-0.46-0.563-0.715c-8.213,6.447-18.564,10.292-29.814,10.292 c-13.343,0-25.423-5.408-34.167-14.152C5.408,73.741,0,61.661,0,48.318s5.408-25.422,14.152-34.166C22.896,5.409,34.976,0,48.319,0 L48.319,0z M77.082,19.555c-7.361-7.361-17.53-11.914-28.763-11.914c-11.233,0-21.403,4.553-28.764,11.914 C12.194,26.916,7.641,37.085,7.641,48.318c0,11.233,4.553,21.403,11.914,28.764c7.36,7.361,17.53,11.914,28.764,11.914 c11.233,0,21.402-4.553,28.763-11.914c7.361-7.36,11.914-17.53,11.914-28.764C88.996,37.085,84.443,26.916,77.082,19.555 L77.082,19.555z" />
						</g>
					</svg>
					<input type="text" id="accordion-search" value=""
						placeholder="<?php echo esc_attr( $placeholder ); ?>" />
				</div>
						<?php
					}

					if ( filter_var( $attributes['layout']['category'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $categories ) ) {
						?>
				<ul class="category-tabs">
						<?php
						if ( isset( $attributes['category']['allTab'] ) && filter_var( $attributes['category']['allTab'], FILTER_VALIDATE_BOOLEAN ) ) {
							$all_label = isset( $attributes['category']['allTabPlaceholder'] ) && ! empty( $attributes['category']['allTabPlaceholder'] ) ? sanitize_text_field( $attributes['category']['allTabPlaceholder'] ) : '';
							?>
					<li id="all" class="category-tab-item is-active">
							<?php
								echo esc_html( $all_label );

							if ( isset( $attributes['layout']['count'] ) && filter_var( $attributes['layout']['count'], FILTER_VALIDATE_BOOLEAN ) ) {
								?>
						<span class="category-count">(<?php echo esc_html( count( $faqs ) ); ?>)</span>
								<?php
							}
							?>
					</li>
							<?php
						}
						foreach ( $categories as $index => $faq_cat ) {
							if ( ( ! isset( $attributes['category']['allTab'] ) || ! filter_var( $attributes['category']['allTab'], FILTER_VALIDATE_BOOLEAN ) ) && 0 === $index ) {
								$active_cat_id = $faq_cat->cat_ID;
							}

							$classes   = array();
							$classes[] = 'category-tab-item';
							$classes[] = ( ! isset( $attributes['category']['allTab'] ) || ! filter_var( $attributes['category']['allTab'], FILTER_VALIDATE_BOOLEAN ) ) && 0 === $index ? 'is-active' : '';
							?>
					<li id="<?php echo esc_attr( $faq_cat->slug ); ?>"
						class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>"
						data-cat-id="<?php echo esc_attr( $faq_cat->cat_ID ); ?>">
							<?php
								echo esc_html( $faq_cat->name );

							if ( isset( $attributes['layout']['count'] ) && filter_var( $attributes['layout']['count'], FILTER_VALIDATE_BOOLEAN ) ) {
								?>
						<span class="category-count">(<?php echo esc_html( $faq_cat->category_count ); ?>)</span>
								<?php
							}
							?>
					</li>
							<?php
						}
						?>
				</ul>
						<?php
					}
					?>
			</div>
					<?php
				}
				?>

			<div class="accordion-notice">
				<?php
				$not_found_text = isset( $attributes['category']['notFoundText'] ) ? sanitize_text_field( $attributes['category']['notFoundText'] ) : '';

				echo esc_html( $not_found_text );
				?>
			</div>

			<div class="cozy-accordion-wrapper">
				<?php
				foreach ( $faqs as $faq ) {
					$term_ids = wp_get_object_terms( $faq->ID, 'ca_faq_category', array( 'fields' => 'ids' ) );

					$classes   = array();
					$classes[] = 'cozy-block-accordion-item';
					$classes[] = ( ( ! isset( $attributes['category']['allTab'] ) || ! filter_var( $attributes['category']['allTab'], FILTER_VALIDATE_BOOLEAN ) ) && in_array( $active_cat_id, $term_ids, true ) ) || ( isset( $attributes['category']['allTab'] ) && filter_var( $attributes['category']['allTab'], FILTER_VALIDATE_BOOLEAN ) ) ? 'is-active' : '';
					?>
				<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>"
					data-post-title="<?php echo esc_attr( $faq->post_title ); ?>"
					data-post-content="<?php echo esc_html( wp_strip_all_tags( strip_shortcodes( $faq->post_content ) ) ); ?>"
					data-cat-ids="<?php echo esc_attr( wp_json_encode( $term_ids ) ); ?>">
					<div role="tab" aria-expanded="">
						<?php
						$el_styles   = array();
						$el_styles[] = 'display:flex';
						$el_styles[] = isset( $attributes['titleJustify'] ) ? 'justify-content:' . sanitize_text_field( $attributes['titleJustify'] ) : '';
						$el_styles[] = 'align-items:center';
						$el_styles[] = 'flex-direction:row';
						?>
						<div class="cozy-accordion-title"
							style="<?php echo esc_attr( trim( implode( ';', $el_styles ), ';' ) ); ?>">
							<?php
							$viewbox   = array();
							$viewbox[] = isset( $attributes['icon']['viewBox']['vx'] ) ? intval( $attributes['icon']['viewBox']['vx'] ) : '';
							$viewbox[] = isset( $attributes['icon']['viewBox']['vy'] ) ? intval( $attributes['icon']['viewBox']['vy'] ) : '';
							$viewbox[] = isset( $attributes['icon']['viewBox']['vw'] ) ? intval( $attributes['icon']['viewBox']['vw'] ) : '';
							$viewbox[] = isset( $attributes['icon']['viewBox']['vh'] ) ? intval( $attributes['icon']['viewBox']['vh'] ) : '';
							$icon_path = isset( $attributes['icon']['path'] ) ? sanitize_text_field( $attributes['icon']['path'] ) : '';
							$icon      = sprintf( '<div class="accordion-icon-wrapper"><svg width="16" height="16" viewBox="%s" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="%s" /></svg></div>', esc_attr( implode( ' ', $viewbox ) ), esc_attr( $icon_path ) );

							if ( isset( $attributes['icon']['position'] ) && 'left' === $attributes['icon']['position'] ) {
								echo $icon;
							}
							printf( '<%1$s>%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $faq->post_title ) );
							if ( isset( $attributes['icon']['position'] ) && 'right' === $attributes['icon']['position'] ) {
								echo $icon;
							}
							?>
						</div>
						<div class="cozy-accordion-content">
							<?php
							echo wp_kses(
								strip_shortcodes( $faq->post_content ),
								array(
									'a'      => array(
										'href'   => array(),
										'target' => array(),
										'rel'    => array(),
										'class'  => array(),
										'style'  => array(),
									),
									'div'    => array(
										'class' => array(),
										'style' => array(),
									),
									'p'      => array(
										'class' => array(),
										'style' => array(),
									),
									'figure' => array(
										'class' => array(),
										'style' => array(),
									),
									'img'    => array(
										'src'   => array(),
										'class' => array(),
										'style' => array(),
										'alt'   => array(),
									),
									'strong' => array(
										'class' => array(),
										'style' => array(),
									),
									'mark'   => array(
										'class' => array(),
										'style' => array(),
									),
									'span'   => array(
										'class' => array(),
										'style' => array(),
									),
									'i'      => array(
										'class' => array(),
										'style' => array(),
									),
									'u'      => array(
										'class' => array(),
										'style' => array(),
									),
								)
							);
							?>
						</div>
					</div>
				</div>
					<?php
				}
				?>
			</div>
		</div>
				<?php
			}
		}
		?>
	</div>
</div>