<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = isset( $attributes['clientId'] ) ? str_replace( '-', '_', sanitize_key( wp_unslash( $attributes['clientId'] ) ) ) : '';

$block_id = 'cozyBlock_' . $client_id;

wp_localize_script( 'cozy-block--pricing-table--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--pricing-table--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockPricingTable( "' . esc_html( $block_id ) . '" ) }) ' );

$styles = array(
	'align'       => isset( $attributes['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['textAlign'] ) ) : '',
	'padding'     => isset( $attributes['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['padding'] ) : '',
	'margin'      => isset( $attributes['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['margin'] ) : '',
	'border'      => isset( $attributes['border'] ) ? cozy_render_TRBL( 'border', $attributes['border'] ) : '',
	'radius'      => isset( $attributes['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['radius'] ) : '',
	'shadow'      => array(
		'horizontal' => isset( $attributes['shadow']['horizontal'] ) ? esc_attr( $attributes['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['shadow']['vertical'] ) ? esc_attr( $attributes['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['shadow']['blur'] ) ? esc_attr( $attributes['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['shadow']['spread'] ) ? esc_attr( $attributes['shadow']['spread'] ) : '',
		'color'      => isset( $attributes['shadow']['color'] ) ? esc_attr( $attributes['shadow']['color'] ) : '',
		'position'   => isset( $attributes['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['shadow']['position'] ) ) : '',
	),
	'font'        => array(
		'size'   => isset( $attributes['typography']['font']['size'] ) ? esc_attr( $attributes['typography']['font']['size'] ) : '',
		'weight' => isset( $attributes['typography']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['typography']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['font']['family'] ) ) : '',
	),
	'letter_case' => isset( $attributes['typography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['letterCase'] ) ) : '',
	'color'       => array(
		'text' => isset( $attributes['color']['text'] ) ? sanitize_text_field( $attributes['color']['text'] ) : '',
		'bg'   => isset( $attributes['color']['bg'] ) ? sanitize_text_field( $attributes['color']['bg'] ) : '',
	),
);

$featured = array(
	'align'          => isset( $attributes['featured']['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['featured']['textAlign'] ) ) : '',
	'padding'        => isset( $attributes['featured']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['featured']['padding'] ) : '',
	'margin'         => isset( $attributes['featured']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['featured']['margin'] ) : '',
	'border'         => isset( $attributes['featured']['border'] ) ? cozy_render_TRBL( 'border', $attributes['featured']['border'] ) : '',
	'radius'         => isset( $attributes['featured']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['featured']['radius'] ) : '',
	'shadow'         => array(
		'horizontal' => isset( $attributes['featured']['shadow']['horizontal'] ) ? esc_attr( $attributes['featured']['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['featured']['shadow']['vertical'] ) ? esc_attr( $attributes['featured']['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['featured']['shadow']['blur'] ) ? esc_attr( $attributes['featured']['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['featured']['shadow']['spread'] ) ? esc_attr( $attributes['featured']['shadow']['spread'] ) : '',
		'color'      => isset( $attributes['featured']['shadow']['color'] ) ? esc_attr( $attributes['featured']['shadow']['color'] ) : '',
		'position'   => isset( $attributes['featured']['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['featured']['shadow']['position'] ) ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['featured']['font']['size'] ) ? esc_attr( $attributes['featured']['font']['size'] ) : '',
		'weight' => isset( $attributes['featured']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['featured']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['featured']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['featured']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['featured']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['featured']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['featured']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['featured']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['featured']['lineHeight'] ) ? esc_attr( $attributes['featured']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['featured']['letterSpacing'] ) ? esc_attr( $attributes['featured']['letterSpacing'] ) : '',
	'color'          => array(
		'text' => isset( $attributes['featured']['color']['text'] ) ? esc_attr( $attributes['featured']['color']['text'] ) : '',
		'bg'   => isset( $attributes['featured']['color']['bg'] ) ? esc_attr( $attributes['featured']['color']['bg'] ) : '',
	),
	'position'       => array(
		'top'   => isset( $attributes['featured']['position']['top'] ) ? esc_attr( $attributes['featured']['position']['top'] ) : '',
		'left'  => isset( $attributes['featured']['position']['left'] ) ? esc_attr( $attributes['featured']['position']['left'] ) : '',
		'right' => isset( $attributes['featured']['position']['right'] ) ? esc_attr( $attributes['featured']['position']['right'] ) : '',
	),
	'rotate'         => isset( $attributes['featured']['rotate'] ) ? esc_attr( $attributes['featured']['rotate'] ) : '',
);

$icon = array(
	'padding'    => isset( $attributes['icon']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['icon']['padding'] ) : '',
	'margin'     => isset( $attributes['icon']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['icon']['margin'] ) : '',
	'box_width'  => isset( $attributes['icon']['boxWidth'] ) ? esc_attr( $attributes['icon']['boxWidth'] ) : '',
	'box_height' => isset( $attributes['icon']['boxHeight'] ) ? esc_attr( $attributes['icon']['boxHeight'] ) : '',
	'viewBox'    => array(
		'vx' => isset( $attributes['icon']['viewBox']['vx'] ) ? intval( $attributes['icon']['viewBox']['vx'] ) : '',
		'vy' => isset( $attributes['icon']['viewBox']['vy'] ) ? intval( $attributes['icon']['viewBox']['vy'] ) : '',
		'vw' => isset( $attributes['icon']['viewBox']['vw'] ) ? intval( $attributes['icon']['viewBox']['vw'] ) : '',
		'vh' => isset( $attributes['icon']['viewBox']['vh'] ) ? intval( $attributes['icon']['viewBox']['vh'] ) : '',
	),
	'path'       => isset( $attributes['icon']['path'] ) ? $attributes['icon']['path'] : '',
	'size'       => isset( $attributes['icon']['size'] ) ? esc_attr( $attributes['icon']['size'] ) : '',
	'border'     => isset( $attributes['icon']['border'] ) ? cozy_render_TRBL( 'border', $attributes['icon']['border'] ) : '',
	'radius'     => isset( $attributes['icon']['radius'] ) ? esc_attr( $attributes['icon']['radius'] ) : '',
	'color'      => array(
		'text' => isset( $attributes['icon']['color']['text'] ) ? esc_attr( $attributes['icon']['color']['text'] ) : '',
		'bg'   => isset( $attributes['icon']['color']['bg'] ) ? esc_attr( $attributes['icon']['color']['bg'] ) : '',
	),
);

$heading = array(
	'margin'         => isset( $attributes['heading']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['heading']['margin'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['heading']['font']['size'] ) ? esc_attr( $attributes['heading']['font']['size'] ) : '',
		'weight' => isset( $attributes['heading']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['heading']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['heading']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['heading']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['heading']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['heading']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['heading']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['heading']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['heading']['lineHeight'] ) ? esc_attr( $attributes['heading']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['heading']['letterSpacing'] ) ? esc_attr( $attributes['heading']['letterSpacing'] ) : '',
	'color'          => array(
		'text' => isset( $attributes['heading']['color']['text'] ) ? esc_attr( $attributes['heading']['color']['text'] ) : '',
	),
);

$sub_heading = array(
	'margin'         => isset( $attributes['subHeading']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['subHeading']['margin'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['subHeading']['font']['size'] ) ? esc_attr( $attributes['subHeading']['font']['size'] ) : '',
		'weight' => isset( $attributes['subHeading']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['subHeading']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['subHeading']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['subHeading']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['subHeading']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['subHeading']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['subHeading']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['subHeading']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['subHeading']['lineHeight'] ) ? esc_attr( $attributes['subHeading']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['subHeading']['letterSpacing'] ) ? esc_attr( $attributes['subHeading']['letterSpacing'] ) : '',
	'color'          => array(
		'text' => isset( $attributes['subHeading']['color']['text'] ) ? esc_attr( $attributes['subHeading']['color']['text'] ) : '',
	),
);

$price = array(
	'margin'         => isset( $attributes['price']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['price']['margin'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['price']['font']['size'] ) ? esc_attr( $attributes['price']['font']['size'] ) : '',
		'weight' => isset( $attributes['price']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['price']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['price']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['price']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['price']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['price']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['price']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['price']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['price']['lineHeight'] ) ? esc_attr( $attributes['price']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['price']['letterSpacing'] ) ? esc_attr( $attributes['price']['letterSpacing'] ) : '',
	'separator'      => array(
		'margin'         => isset( $attributes['price']['separator']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['price']['separator']['margin'] ) : '',
		'font'           => array(
			'size'   => isset( $attributes['price']['separator']['font']['size'] ) ? esc_attr( $attributes['price']['separator']['font']['size'] ) : '',
			'weight' => isset( $attributes['price']['separator']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['price']['separator']['font']['weight'] ) ) : '',
			'family' => isset( $attributes['price']['separator']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['price']['separator']['font']['family'] ) ) : '',
		),
		'letter_case'    => isset( $attributes['price']['separator']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['price']['separator']['letterCase'] ) ) : '',
		'decoration'     => isset( $attributes['price']['separator']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['price']['separator']['decoration'] ) ) : '',
		'line_height'    => isset( $attributes['price']['separator']['lineHeight'] ) ? esc_attr( $attributes['price']['separator']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['price']['separator']['letterSpacing'] ) ? esc_attr( $attributes['price']['separator']['letterSpacing'] ) : '',
	),
	'color'          => array(
		'text'      => isset( $attributes['price']['color']['text'] ) ? esc_attr( $attributes['price']['color']['text'] ) : '',
		'separator' => isset( $attributes['price']['color']['separator'] ) ? esc_attr( $attributes['price']['color']['separator'] ) : '',
	),
);

$button = array(
	'align'          => isset( $attributes['button']['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['button']['textAlign'] ) ) : '',
	'width'          => isset( $attributes['button']['width'] ) ? sanitize_text_field( $attributes['button']['width'] ) : '',
	'padding'        => isset( $attributes['button']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['button']['padding'] ) : '',
	'margin'         => isset( $attributes['button']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['button']['margin'] ) : '',
	'border'         => isset( $attributes['button']['border'] ) ? cozy_render_TRBL( 'border', $attributes['button']['border'] ) : '',
	'radius'         => isset( $attributes['button']['radius'] ) ? esc_attr( $attributes['button']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['button']['font']['size'] ) ? esc_attr( $attributes['button']['font']['size'] ) : '',
		'weight' => isset( $attributes['button']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['button']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['button']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['button']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['button']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['button']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['button']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['button']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['button']['lineHeight'] ) ? esc_attr( $attributes['button']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['button']['letterSpacing'] ) ? esc_attr( $attributes['button']['letterSpacing'] ) : '',
	'color'          => array(
		'text'         => isset( $attributes['button']['color']['text'] ) ? esc_attr( sanitize_text_field( $attributes['button']['color']['text'] ) ) : '',
		'text_hover'   => isset( $attributes['button']['color']['textHover'] ) ? esc_attr( sanitize_text_field( $attributes['button']['color']['textHover'] ) ) : '',
		'bg'           => isset( $attributes['button']['color']['bg'] ) ? esc_attr( sanitize_text_field( $attributes['button']['color']['bg'] ) ) : '',
		'bg_hover'     => isset( $attributes['button']['color']['bgHover'] ) ? esc_attr( sanitize_text_field( $attributes['button']['color']['bgHover'] ) ) : '',
		'border_hover' => isset( $attributes['button']['color']['borderHover'] ) ? esc_attr( sanitize_text_field( $attributes['button']['color']['borderHover'] ) ) : '',
	),
);

$list = array(
	'padding'        => isset( $attributes['list']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['list']['padding'] ) : '',
	'margin'         => isset( $attributes['list']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['list']['margin'] ) : '',
	'border'         => isset( $attributes['list']['border'] ) ? cozy_render_TRBL( 'border', $attributes['list']['border'] ) : '',
	'radius'         => isset( $attributes['list']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['list']['radius'] ) : '',
	'item'           => array(
		'align'   => isset( $attributes['list']['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['list']['textAlign'] ) ) : '',
		'padding' => isset( $attributes['list']['item']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['list']['item']['padding'] ) : '',
		'border'  => isset( $attributes['list']['item']['border'] ) ? cozy_render_TRBL( 'border', $attributes['list']['item']['border'] ) : '',
		'radius'  => isset( $attributes['list']['item']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['list']['item']['radius'] ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['list']['font']['size'] ) ? esc_attr( $attributes['list']['font']['size'] ) : '',
		'weight' => isset( $attributes['list']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['list']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['list']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['list']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['list']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['list']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['list']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['list']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['list']['lineHeight'] ) ? esc_attr( $attributes['list']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['list']['letterSpacing'] ) ? esc_attr( $attributes['list']['letterSpacing'] ) : '',
	'gap'            => isset( $attributes['list']['gap'] ) ? esc_attr( $attributes['list']['gap'] ) : '',
	'icon'           => array(
		'box_width'  => isset( $attributes['list']['icon']['boxWidth'] ) ? esc_attr( $attributes['list']['icon']['boxWidth'] ) : '',
		'box_height' => isset( $attributes['list']['icon']['boxHeight'] ) ? esc_attr( $attributes['list']['icon']['boxHeight'] ) : '',
		'size'       => isset( $attributes['list']['icon']['size'] ) ? esc_attr( $attributes['list']['icon']['size'] ) : '',
		'box_border' => isset( $attributes['list']['icon']['boxBorder'] ) ? cozy_render_TRBL( 'border', $attributes['list']['icon']['boxBorder'] ) : '',
		'box_radius' => isset( $attributes['list']['icon']['boxRadius'] ) ? esc_attr( $attributes['list']['icon']['boxRadius'] ) : '',
	),
	'heading'        => array(
		'margin'         => isset( $attributes['list']['heading']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['list']['heading']['margin'] ) : '',
		'font'           => array(
			'size'   => isset( $attributes['list']['heading']['font']['size'] ) ? esc_attr( $attributes['list']['heading']['font']['size'] ) : '',
			'weight' => isset( $attributes['list']['heading']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['list']['heading']['font']['weight'] ) ) : '',
			'family' => isset( $attributes['list']['heading']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['list']['heading']['font']['family'] ) ) : '',
		),
		'letter_case'    => isset( $attributes['list']['heading']['lineHeight'] ) ? esc_attr( sanitize_text_field( $attributes['list']['heading']['lineHeight'] ) ) : '',
		'decoration'     => isset( $attributes['list']['heading']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['list']['heading']['decoration'] ) ) : '',
		'line_height'    => isset( $attributes['list']['heading']['lineHeight'] ) ? esc_attr( $attributes['list']['heading']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['list']['heading']['letterSpacing'] ) ? esc_attr( $attributes['list']['heading']['letterSpacing'] ) : '',
	),
	'loader'         => array(
		'padding'        => isset( $attributes['list']['ajaxLoader']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['list']['ajaxLoader']['padding'] ) : '',
		'margin'         => isset( $attributes['list']['ajaxLoader']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['list']['ajaxLoader']['margin'] ) : '',
		'border'         => isset( $attributes['list']['ajaxLoader']['border'] ) ? cozy_render_TRBL( 'border', $attributes['list']['ajaxLoader']['border'] ) : '',
		'radius'         => isset( $attributes['list']['ajaxLoader']['radius'] ) ? esc_attr( $attributes['list']['ajaxLoader']['radius'] ) : '',
		'font'           => array(
			'size'   => isset( $attributes['list']['ajaxLoader']['font']['size'] ) ? esc_attr( $attributes['list']['ajaxLoader']['font']['size'] ) : '',
			'weight' => isset( $attributes['list']['ajaxLoader']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['list']['ajaxLoader']['font']['weight'] ) ) : '',
			'family' => isset( $attributes['list']['ajaxLoader']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['list']['ajaxLoader']['font']['family'] ) ) : '',
		),
		'letter_case'    => isset( $attributes['list']['ajaxLoader']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['list']['ajaxLoader']['letterCase'] ) ) : '',
		'decoration'     => isset( $attributes['list']['ajaxLoader']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['list']['ajaxLoader']['decoration'] ) ) : '',
		'line_height'    => isset( $attributes['list']['ajaxLoader']['lineHeight'] ) ? esc_attr( $attributes['list']['ajaxLoader']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['list']['ajaxLoader']['letterSpacing'] ) ? esc_attr( $attributes['list']['ajaxLoader']['letterSpacing'] ) : '',
		'color'          => array(
			'text'         => isset( $attributes['list']['ajaxLoader']['color']['text'] ) ? esc_attr( sanitize_text_field( $attributes['list']['ajaxLoader']['color']['text'] ) ) : '',
			'text_hover'   => isset( $attributes['list']['ajaxLoader']['color']['textHover'] ) ? esc_attr( sanitize_text_field( $attributes['list']['ajaxLoader']['color']['textHover'] ) ) : '',
			'bg'           => isset( $attributes['list']['ajaxLoader']['color']['bg'] ) ? esc_attr( sanitize_text_field( $attributes['list']['ajaxLoader']['color']['bg'] ) ) : '',
			'bg_hover'     => isset( $attributes['list']['ajaxLoader']['color']['bgHover'] ) ? esc_attr( sanitize_text_field( $attributes['list']['ajaxLoader']['color']['bgHover'] ) ) : '',
			'border_hover' => isset( $attributes['list']['ajaxLoader']['color']['borderHover'] ) ? esc_attr( sanitize_text_field( $attributes['list']['ajaxLoader']['color']['borderHover'] ) ) : '',
		),

	),
	'color'          => array(
		'icon'      => isset( $attributes['list']['color']['icon'] ) ? esc_attr( sanitize_text_field( $attributes['list']['color']['icon'] ) ) : '',
		'icon_bg'   => isset( $attributes['list']['color']['iconBg'] ) ? esc_attr( sanitize_text_field( $attributes['list']['color']['iconBg'] ) ) : '',
		'heading'   => isset( $attributes['list']['color']['heading'] ) ? esc_attr( sanitize_text_field( $attributes['list']['color']['heading'] ) ) : '',
		'text'      => isset( $attributes['list']['color']['text'] ) ? esc_attr( sanitize_text_field( $attributes['list']['color']['text'] ) ) : '',
		'wrapper'   => isset( $attributes['list']['color']['wrapperBg'] ) ? esc_attr( sanitize_text_field( $attributes['list']['color']['wrapperBg'] ) ) : '',
		'list_item' => isset( $attributes['list']['color']['listBg'] ) ? esc_attr( sanitize_text_field( $attributes['list']['color']['listBg'] ) ) : '',
	),
);

$block_styles = "
#$block_id {
	{$styles['margin']}
	{$styles['border']}
	{$styles['radius']}
	font-size: {$styles['font']['size']};
	font-weight: {$styles['font']['weight']};
	font-family: {$styles['font']['family']};
	text-transform: {$styles['letter_case']};
	background-color: {$styles['color']['bg']};
	color: {$styles['color']['text']};
	text-align: {$styles['align']};
	overflow: {$attributes['overflow']};
}
#$block_id.has-box-shadow {
	box-shadow: {$styles['shadow']['horizontal']} {$styles['shadow']['vertical']} {$styles['shadow']['blur']} {$styles['shadow']['spread']} {$styles['shadow']['color']} {$styles['shadow']['position']};
}
#$block_id .pricing-table__wrap {
	{$styles['padding']}
}

#$block_id .pricing-table__featured {
	{$featured['padding']}
	{$featured['margin']}
	{$featured['border']}
	{$featured['radius']}
	font-size: {$featured['font']['size']};
	font-weight: {$featured['font']['weight']};
	font-family: {$featured['font']['family']};
	text-transform: {$featured['letter_case']};
	text-decoration: {$featured['decoration']};
	line-height: {$featured['line_height']};
	letter-spacing: {$featured['letter_spacing']};
	color: {$featured['color']['text']};
	background-color: {$featured['color']['bg']};
	text-align: {$featured['align']};	
}
#$block_id .pricing-table__featured.has-box-shadow {
	box-shadow: {$featured['shadow']['horizontal']} {$featured['shadow']['vertical']} {$featured['shadow']['blur']} {$featured['shadow']['spread']} {$featured['shadow']['color']} {$featured['shadow']['position']};
}
#$block_id .pricing-table__featured.position-absolute {
	top: {$featured['position']['top']};
	transform: rotate({$featured['rotate']}deg);
}
#$block_id .pricing-table__featured.position-absolute.align-left{
	left: {$featured['position']['left']};
}
#$block_id .pricing-table__featured.position-absolute.align-right{
	right: {$featured['position']['right']};
}

#$block_id .pricing-table__icon-wrap {
	{$icon['padding']}
	{$icon['margin']}
	width: {$icon['box_width']};
	height: {$icon['box_height']};
	{$icon['border']}
	border-radius: {$icon['radius']};
	background-color: {$icon['color']['bg']};
	color: {$icon['color']['text']};
}
#$block_id .pricing-table__icon-wrap svg {
	width: {$icon['size']};
	height: {$icon['size']};
}
#$block_id .pricing-table__img-wrap {
	{$icon['margin']}
	border-radius: {$icon['radius']};
	max-width: {$icon['size']};
	max-height: {$icon['size']};
}
#$block_id .pricing-table__img-wrap img {
	width: {$icon['size']};
	height: {$icon['size']};
	border-radius: {$icon['radius']};
}

#$block_id .pricing-table__heading {
	{$heading['margin']}
	font-size: {$heading['font']['size']};
	font-weight: {$heading['font']['weight']};
	font-family: {$heading['font']['family']};
	text-transform: {$heading['letter_case']};
	text-decoration: {$heading['decoration']};
	line-height: {$heading['line_height']};
	letter-spacing: {$heading['letter_spacing']};
	color: {$heading['color']['text']};
}

#$block_id .pricing-table__subheading {
	{$sub_heading['margin']}
	font-size: {$sub_heading['font']['size']};
	font-weight: {$sub_heading['font']['weight']};
	font-family: {$sub_heading['font']['family']};
	text-transform: {$sub_heading['letter_case']};
	text-decoration: {$sub_heading['decoration']};
	line-height: {$sub_heading['line_height']};
	letter-spacing: {$sub_heading['letter_spacing']};
	color: {$sub_heading['color']['text']};
}

#$block_id .pricing-table__price-wrap {
	{$price['margin']}
	font-size: {$price['font']['size']};
	font-weight: {$price['font']['weight']};
	font-family: {$price['font']['family']};
	text-transform: {$price['letter_case']};
	text-decoration: {$price['decoration']};
	line-height: {$price['line_height']};
	letter-spacing: {$price['letter_spacing']};
	color: {$price['color']['text']};
}
#$block_id .pricing-table__price-wrap .price__separator-label {
	{$price['separator']['margin']}
	font-size: {$price['separator']['font']['size']};
	font-weight: {$attributes['price']['separator']['font']['weight']};
	font-family: {$price['separator']['font']['family']};
	text-transform: {$price['separator']['letter_case']};
	text-decoration: {$price['separator']['decoration']};
	line-height: {$price['separator']['line_height']};
	letter-spacing: {$price['separator']['letter_spacing']};
	color: {$price['color']['separator']};
}

#$block_id .pricing-table__button-wrap {
	text-align: {$button['align']};
}
#$block_id .pricing-table__button {
	width: {$button['width']};
	{$button['padding']}
	{$button['margin']}
	{$button['border']}
	border-radius: {$button['radius']};
	font-size: {$button['font']['size']};
	font-weight: {$button['font']['weight']};
	font-family: {$button['font']['family']};
	text-transform: {$button['letter_case']};
	text-decoration: {$button['decoration']};
	line-height: {$button['line_height']};
	letter-spacing: {$button['letter_spacing']};
	background-color: {$button['color']['bg']};
	color: {$button['color']['text']};

}
#$block_id .pricing-table__button:hover {
	background-color: {$button['color']['bg_hover']};
	color: {$button['color']['text_hover']};
	border-color: {$button['color']['border_hover']};
}

#$block_id .pricing-table__list {
	{$list['padding']}
	{$list['margin']}
	{$list['border']}
	{$list['radius']}
	font-size: {$list['font']['size']};
	font-weight: {$list['font']['weight']};
	font-family: {$list['font']['family']};
	text-transform: {$list['letter_case']};
	text-decoration: {$list['decoration']};
	line-height: {$list['line_height']};
	letter-spacing: {$list['letter_spacing']};
	color: {$list['color']['text']};
	background-color: {$list['color']['wrapper']};
}
#$block_id .pricing-table__list .list__heading {
	{$list['heading']['margin']}
	font-size: {$list['heading']['font']['size']};
	font-weight: {$list['heading']['font']['weight']};
	font-family: {$list['heading']['font']['family']};
	text-transform: {$list['heading']['letter_case']};
	text-decoration: {$list['heading']['decoration']};
	line-height: {$list['heading']['line_height']};
	letter-spacing: {$list['heading']['letter_spacing']};
	color: {$list['color']['heading']};
}
#$block_id .pricing-table__list .pricing-table__list-item {
	{$list['item']['padding']}
	{$list['item']['border']}
	{$list['item']['radius']}
	justify-content: {$list['item']['align']};
	background-color: {$list['color']['list_item']};
}
#$block_id .pricing-table__list .pricing-table__list-item:not(:first-child) {
	margin-top: {$list['gap']};
}
#$block_id .pricing-table__list .pricing-table__list-icon {
	min-width: {$list['icon']['box_width']};
	min-height: {$list['icon']['box_height']};
	{$list['icon']['box_border']}
	border-radius: {$list['icon']['box_radius']};
	background-color: {$list['color']['icon_bg']};
}
#$block_id .pricing-table__list .pricing-table__list-icon svg {
	width: {$list['icon']['size']};
	height: {$list['icon']['size']};
	fill: {$list['color']['icon']};
}
#$block_id #feature-list__ajax-loader-wrap {
	text-align: {$attributes['list']['ajaxLoader']['align']};
}
#$block_id #feature-list__ajax-loader {
	{$list['loader']['padding']}
	{$list['loader']['margin']}
	{$list['loader']['border']}
	border-radius: {$list['loader']['radius']};
	font-size: {$list['loader']['font']['size']};
	font-weight: {$list['loader']['font']['weight']};
	font-family: {$list['loader']['font']['family']};
	text-transform: {$list['loader']['letter_case']};
	text-decoration: {$list['loader']['decoration']};
	line-height: {$list['loader']['line_height']};
	letter-spacing: {$list['loader']['letter_spacing']};
	background-color: {$list['loader']['color']['bg']};
	color: {$list['loader']['color']['text']};
}
#$block_id #feature-list__ajax-loader:hover {
	background-color: {$list['loader']['color']['bg_hover']};
	color: {$list['loader']['color']['text_hover']};
	border-color: {$list['loader']['color']['border_hover']};
}
";

$font_families = array();

if ( isset( $attributes['typography']['font']['family'] ) && ! empty( $attributes['typography']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['typography']['font']['family'] );
}

if ( isset( $attributes['featured']['font']['family'] ) && ! empty( $attributes['featured']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['featured']['font']['family'] );
}

if ( isset( $attributes['heading']['font']['family'] ) && ! empty( $attributes['heading']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['heading']['font']['family'] );
}

if ( isset( $attributes['subHeading']['font']['family'] ) && ! empty( $attributes['subHeading']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['subHeading']['font']['family'] );
}

if ( isset( $attributes['price']['font']['family'] ) && ! empty( $attributes['price']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['price']['font']['family'] );
}

if ( isset( $attributes['price']['separator']['font']['family'] ) && ! empty( $attributes['price']['separator']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['price']['separator']['font']['family'] );
}

if ( isset( $attributes['button']['font']['family'] ) && ! empty( $attributes['button']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['button']['font']['family'] );
}

if ( isset( $attributes['list']['font']['family'] ) && ! empty( $attributes['list']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['list']['font']['family'] );
}

if ( isset( $attributes['list']['heading']['font']['family'] ) && ! empty( $attributes['list']['heading']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['list']['heading']['font']['family'] );
}

if ( isset( $attributes['list']['ajaxLoader']['font']['family'] ) && ! empty( $attributes['list']['ajaxLoader']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['list']['ajaxLoader']['font']['family'] );
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

$allowed_tags = array(
	'h1',
	'h2',
	'h3',
	'h4',
	'h5',
	'h6',
	'div',
	'p',
	'a',
	'span',
);

$wrapper_attributes = get_block_wrapper_attributes();

$classes   = array();
$classes[] = 'cozy-block-pricing-table';
$classes[] = $attributes['shadow']['enabled'] ? 'has-box-shadow' : '';
?>

<div class="cozy-block-wrapper">
	<div <?php echo $wrapper_attributes; ?>>
		<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<?php
			if ( cozy_addons_premium_access() && $attributes['enabled']['featured'] && ! empty( $attributes['featured']['content'] ) ) {
				$classes   = array();
				$classes[] = 'pricing-table__featured';
				$classes[] = 'position-' . $attributes['featured']['position']['type'];
				$classes[] = 'align-' . $attributes['featured']['position']['align'];
				$classes[] = isset( $attributes['featured']['shadow']['enabled'] ) && $attributes['featured']['shadow']['enabled'] ? 'has-box-shadow' : '';
				printf( '<%1$s class="%2$s">%3$s</%1$s>', esc_attr( in_array( $attributes['featured']['tag'], $allowed_tags, true ) ? $attributes['featured']['tag'] : 'p' ), esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ), esc_html( sanitize_text_field( $attributes['featured']['content'] ) ) );
			}

			$safe_values = array( 'heading', 'subHeading', 'price', 'description', 'button', 'list' );
			?>
			<div class="pricing-table__wrap">
			<?php
			foreach ( $attributes['order'] as $key ) {
				if ( 'list' === $key && $attributes['enabled'][ $key ] ) {
					?>
							<ul class="pricing-table__list">
					<?php

					if ( ! empty( $attributes['list']['heading']['content'] ) ) {
						printf( '<h4 class="list__heading">%1$s</h4>', esc_html( $attributes['list']['heading']['content'] ) );
					}


					if ( is_array( $attributes['list']['content'] ) && ! empty( $attributes['list']['content'] ) ) {
						$viewbox = implode( ' ', array_map( 'intval', array_values( $attributes['list']['icon']['viewBox'] ) ) );
						foreach ( $attributes['list']['content'] as $list_index => $list_item ) {
							$classes   = array();
							$classes[] = 'pricing-table__list-item';

							$count_index = $list_index + 1;

							if ( cozy_addons_premium_access() && isset( $attributes['list']['ajaxLoader']['enabled'], $attributes['list']['ajaxLoader']['showCount'] ) && $attributes['list']['ajaxLoader']['enabled'] && $count_index > $attributes['list']['ajaxLoader']['showCount'] ) {
								$classes[] = 'display-none';
							} else {
								$classes[] = 'show';
							}

							?>
											<li class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" data-index="<?php echo esc_attr( $list_index ); ?>">
								<?php
								if ( $attributes['list']['icon']['enabled'] && 'left' === $attributes['list']['icon']['position'] ) {
									?>
													<div class="pricing-table__list-icon">
														<svg
														viewBox="<?php echo esc_attr( $viewbox ); ?>"
														xmlns="http://www.w3.org/2000/svg"
														aria-hidden="true"
														>
															<path d="<?php echo esc_attr( $attributes['list']['icon']['path'] ); ?>" />	
														</svg>
													</div>
										<?php
								}
								?>
											<span><?php echo esc_html( $list_item ); ?></span>
									<?php
									if ( $attributes['list']['icon']['enabled'] && 'right' === $attributes['list']['icon']['position'] ) {
										?>
													<div class="pricing-table__list-icon">
														<svg
														viewbox="<?php echo esc_attr( $viewbox ); ?>"
														xmlns="http://www.w3.org/2000/svg"
														aria-hidden="true"
														>
															<path d="<?php echo esc_attr( $attributes['list']['icon']['path'] ); ?>" />	
														</svg>
													</div>
											<?php
									}
									?>
											</li>
									<?php
						}
					}

					if ( cozy_addons_premium_access() && $attributes['list']['ajaxLoader']['enabled'] && ( count( $attributes['list']['content'] ) > $attributes['list']['ajaxLoader']['showCount'] ) ) {
						?>
								<div id="feature-list__ajax-loader-wrap">
									<div id="feature-list__ajax-loader"><?php echo esc_html( sanitize_text_field( $attributes['list']['ajaxLoader']['label'] ) ); ?></div>
								</div>
							<?php
					}
					?>
							</ul>
					<?php
				} elseif ( 'list' !== $key && 'icon' !== $key && in_array( $key, $safe_values, true ) && $attributes['enabled'][ $key ] ) {
					if ( 'button' === $key || 'price' === $key ) {
						$classes   = array();
						$classes[] = 'pricing-table__' . $key . '-wrap';
						?>
						<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
						<?php
					}

					$classes = strtolower( $key );

					if ( 'price' === $key ) {
						$classes .= ' display-' . $attributes['price']['display'];
					}

					if ( 'button' === $key && isset( $attributes['button']['link']['url'] ) && ! empty( $attributes['button']['link']['url'] ) ) {
						$new_tab  = isset( $attributes['button']['link']['newtab'] ) && $attributes['button']['link']['newtab'] ? '_blank' : '';
						$nofollow = isset( $attributes['button']['link']['noFollow'] ) && $attributes['button']['link']['noFollow'] ? 'nofollow' : '';
						printf( '<%1$s class="pricing-table__%2$s" href="%4$s" target="%5$s" rel="%6$s">%3$s</%1$s>', esc_attr( in_array( $attributes[ $key ]['tag'], $allowed_tags, true ) ? $attributes[ $key ]['tag'] : 'p' ), esc_attr( $classes ), esc_html( $attributes[ $key ]['content'] ), esc_url( $attributes['button']['link']['url'] ), esc_attr( $new_tab ), esc_attr( $nofollow ) );
					} else {
						printf( '<%1$s class="pricing-table__%2$s">%3$s</%1$s>', esc_attr( in_array( $attributes[ $key ]['tag'], $allowed_tags, true ) ? $attributes[ $key ]['tag'] : 'p' ), esc_attr( $classes ), esc_html( $attributes[ $key ]['content'] ) );
					}

					if ( 'price' === $key && ! empty( $attributes['price']['separator']['content'] ) ) {
						printf( '<%1$s class="price__separator-label">%2$s</%1$s>', esc_attr( in_array( $attributes[ $key ]['tag'], $allowed_tags, true ) ? $attributes[ $key ]['tag'] : 'p' ), esc_html( $attributes['price']['separator']['content'] ) );
					}
					if ( 'button' === $key || 'price' === $key ) {
						?>
						</div>
						<?php
					}
				} elseif ( isset( $attributes['enabled']['icon'] ) && 'icon' === $key && $attributes['enabled'][ $key ] ) {
					if ( isset( $attributes['icon']['source'] ) && 'default' === $attributes['icon']['source'] ) {
						?>
						<div class="pricing-table__icon-wrap">
							<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="currentColor"
								viewBox="<?php echo esc_attr( implode( ' ', array_map( 'intval', array_values( $icon['viewBox'] ) ) ) ); ?>"
							>
								<path d="<?php echo esc_html( $icon['path'] ); ?>" />
							</svg>
						</div>
						<?php
					} elseif ( cozy_addons_premium_access() && isset( $attributes['icon']['source'] ) && 'media' === $attributes['icon']['source'] ) {
						$img_src = isset( $attributes['icon']['url'] ) ? sanitize_url( $attributes['icon']['url'] ) : '';
						$alt     = isset( $attributes['icon']['alt'] ) ? sanitize_text_field( $attributes['icon']['alt'] ) : '';
						?>
							<figure
								class="pricing-table__img-wrap"
							>
								<img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
							</figure>
						<?php
					}
				}
			}
			?>
			</div>
		</div>
	</div>
</div>

<?php