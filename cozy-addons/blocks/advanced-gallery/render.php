<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['clientId'] ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$attributes['ajaxUrl'] = admin_url( 'admin-ajax.php' );
$attributes['nonce']   = wp_create_nonce( 'cozy_block_advanced_gallery_load_more' );

$header_box = array(
	'padding' => isset( $attributes['headerBox']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['headerBox']['padding'] ) : '',
	'margin'  => isset( $attributes['headerBox']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['headerBox']['margin'] ) : '',
	'border'  => isset( $attributes['headerBox']['border'] ) ? cozy_render_TRBL( 'border', $attributes['headerBox']['border'] ) : '',
	'radius'  => isset( $attributes['headerBox']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['headerBox']['radius'] ) : '',
	'bg'      => isset( $attributes['headerBox']['color']['bg'] ) ? esc_attr( $attributes['headerBox']['color']['bg'] ) : '',
);

$tab_item = array(
	'gap'                  => isset( $attributes['tabOptions']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['tabOptions']['gap'] ) : '',
	'justify'              => isset( $attributes['tabOptions']['justifyTab'] ) ? esc_attr( sanitize_text_field( $attributes['tabOptions']['justifyTab'] ) ) : '',
	'padding'              => isset( $attributes['tabStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['tabStyles']['padding'] ) : '',
	'border'               => isset( $attributes['tabStyles']['default']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['default']['border'] ) : '',
	'radius'               => isset( $attributes['tabStyles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['tabStyles']['radius'] ) : '',
	'border_active'        => isset( $attributes['tabStyles']['active']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['active']['border'] ) : '',
	'font'                 => array(
		'size'   => isset( $attributes['tabStyles']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['tabStyles']['font']['size'] ) : '',
		'weight' => isset( $attributes['tabStyles']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['tabStyles']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['font']['family'] ) ) : '',
	),
	'letter_case'          => isset( $attributes['tabStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['letterCase'] ) ) : '',
	'decoration'           => isset( $attributes['tabStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['decoration'] ) ) : '',
	'line_height'          => isset( $attributes['tabStyles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['tabStyles']['lineHeight'] ) : '',
	'letter_spacing'       => isset( $attributes['tabStyles']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['tabStyles']['letterSpacing'] ) : '',
	'bg'                   => isset( $attributes['tabStyles']['color']['bg'] ) ? esc_attr( $attributes['tabStyles']['color']['bg'] ) : '',
	'bg_hover'             => isset( $attributes['tabStyles']['color']['bgHover'] ) ? esc_attr( $attributes['tabStyles']['color']['bgHover'] ) : '',
	'bg_active'            => isset( $attributes['tabStyles']['color']['bgActive'] ) ? esc_attr( $attributes['tabStyles']['color']['bgActive'] ) : '',
	'text'                 => isset( $attributes['tabStyles']['color']['text'] ) ? esc_attr( $attributes['tabStyles']['color']['text'] ) : '',
	'text_hover'           => isset( $attributes['tabStyles']['color']['textHover'] ) ? esc_attr( $attributes['tabStyles']['color']['textHover'] ) : '',
	'text_active'          => isset( $attributes['tabStyles']['color']['textActive'] ) ? esc_attr( $attributes['tabStyles']['color']['textActive'] ) : '',
	'shadow'               => array(
		'horizontal' => isset( $attributes['tabStyles']['default']['shadow']['horizontal'] ) ? esc_attr( $attributes['tabStyles']['default']['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['tabStyles']['default']['shadow']['vertical'] ) ? esc_attr( $attributes['tabStyles']['default']['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['tabStyles']['default']['shadow']['blur'] ) ? esc_attr( $attributes['tabStyles']['default']['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['tabStyles']['default']['shadow']['spread'] ) ? esc_attr( $attributes['tabStyles']['default']['shadow']['spread'] ) : '',
		'color'      => isset( $attributes['tabStyles']['default']['shadow']['color'] ) ? esc_attr( $attributes['tabStyles']['default']['shadow']['color'] ) : '',
		'position'   => isset( $attributes['tabStyles']['default']['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['default']['shadow']['position'] ) ) : '',
	),
	'shadow_active'        => array(
		'horizontal' => isset( $attributes['tabStyles']['active']['shadow']['horizontal'] ) ? esc_attr( $attributes['tabStyles']['active']['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['tabStyles']['active']['shadow']['vertical'] ) ? esc_attr( $attributes['tabStyles']['active']['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['tabStyles']['active']['shadow']['blur'] ) ? esc_attr( $attributes['tabStyles']['active']['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['tabStyles']['active']['shadow']['spread'] ) ? esc_attr( $attributes['tabStyles']['active']['shadow']['spread'] ) : '',
		'color'      => isset( $attributes['tabStyles']['active']['shadow']['color'] ) ? esc_attr( $attributes['tabStyles']['active']['shadow']['color'] ) : '',
		'position'   => isset( $attributes['tabStyles']['active']['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['active']['shadow']['position'] ) ) : '',
	),
	'active_margin_bottom' => isset( $attributes['tabStyles']['active']['marginBottom'] ) ? esc_attr( $attributes['tabStyles']['active']['marginBottom'] ) : '',

);

$grid = array(
	'column' => isset( $attributes['gridOptions']['column'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['column'] ) : '',
	'gap'    => isset( $attributes['gridOptions']['columnGap'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['columnGap'] ) : '',
);

$image = array(
	'width'  => isset( $attributes['image']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['image']['width'] ) : '',
	'height' => isset( $attributes['image']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['image']['height'] ) : '',
	'radius' => isset( $attributes['image']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['image']['radius'] ) : '',
	'title'  => array(
		'align'          => isset( $attributes['image']['title']['align'] ) ? esc_attr( sanitize_text_field( $attributes['image']['title']['align'] ) ) : '',
		'left'           => 'left' === $attributes['image']['title']['align'] ? cozy_addons_sanitize_dimension( $attributes['image']['title']['left'] ) : '',
		'right'          => 'right' === $attributes['image']['title']['align'] ? cozy_addons_sanitize_dimension( $attributes['image']['title']['right'] ) : '',
		'bottom'         => isset( $attributes['image']['title']['bottom'] ) ? cozy_addons_sanitize_dimension( $attributes['image']['title']['bottom'] ) : '',
		'font'           => array(
			'size'   => isset( $attributes['image']['title']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['image']['title']['font']['size'] ) : '',
			'weight' => isset( $attributes['image']['title']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['image']['title']['font']['weight'] ) ) : '',
			'family' => isset( $attributes['image']['title']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['image']['title']['font']['family'] ) ) : '',
		),
		'letter_case'    => isset( $attributes['image']['title']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['image']['title']['letterCase'] ) ) : '',
		'decoration'     => isset( $attributes['image']['title']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['image']['title']['decoration'] ) ) : '',
		'line_height'    => isset( $attributes['image']['title']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['image']['title']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['image']['title']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['image']['title']['letterSpacing'] ) : '',
	),
	'color'  => array(
		'text'    => isset( $attributes['image']['color']['text'] ) ? esc_attr( $attributes['image']['color']['text'] ) : '',
		'overlay' => isset( $attributes['image']['color']['overlay'] ) ? esc_attr( $attributes['image']['color']['overlay'] ) : '',
	),
);

$icon = array(
	'size'    => isset( $attributes['icon']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['size'] ) : '',
	'padding' => isset( $attributes['icon']['box']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['icon']['box']['padding'] ) : '',
	'border'  => isset( $attributes['icon']['box']['border'] ) ? cozy_render_TRBL( 'border', $attributes['icon']['box']['border'] ) : '',
	'radius'  => isset( $attributes['icon']['box']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['box']['radius'] ) : '',
	'color'   => array(
		'text'       => isset( $attributes['icon']['color']['text'] ) ? esc_attr( $attributes['icon']['color']['text'] ) : '',
		'text_hover' => isset( $attributes['icon']['color']['textHover'] ) ? esc_attr( $attributes['icon']['color']['textHover'] ) : '',
		'bg'         => isset( $attributes['icon']['color']['bg'] ) ? esc_attr( $attributes['icon']['color']['bg'] ) : '',
		'bg_hover'   => isset( $attributes['icon']['color']['bgHover'] ) ? esc_attr( $attributes['icon']['color']['bgHover'] ) : '',
	),
);

$lightbox     = array(
	'title' => array(
		'align'          => isset( $attributes['lightbox']['title']['align'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['title']['align'] ) ) : '',
		'margin_bottom'  => isset( $attributes['lightbox']['title']['bottom'] ) ? cozy_addons_sanitize_dimension( $attributes['lightbox']['title']['bottom'] ) : '',
		'left'           => 'left' === $attributes['lightbox']['title']['align'] ? cozy_addons_sanitize_dimension( $attributes['lightbox']['title']['left'] ) : '',
		'right'          => 'right' === $attributes['lightbox']['title']['align'] ? cozy_addons_sanitize_dimension( $attributes['lightbox']['title']['right'] ) : '',
		'font'           => array(
			'size'   => isset( $attributes['lightbox']['title']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['lightbox']['title']['font']['size'] ) : '',
			'weight' => isset( $attributes['lightbox']['title']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['title']['font']['weight'] ) ) : '',
			'family' => isset( $attributes['lightbox']['title']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['title']['font']['family'] ) ) : '',
		),
		'letter_case'    => isset( $attributes['lightbox']['title']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['title']['letterCase'] ) ) : '',
		'decoration'     => isset( $attributes['lightbox']['title']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['title']['decoration'] ) ) : '',
		'line_height'    => isset( $attributes['lightbox']['title']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['lightbox']['title']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['lightbox']['title']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['lightbox']['title']['letterSpacing'] ) : '',
	),
	'color' => array(
		'text' => isset( $attributes['lightbox']['title']['color']['text'] ) ? esc_attr( $attributes['lightbox']['title']['color']['text'] ) : '',
	),
);
$lightbox_nav = array(
	'box_width'  => isset( $attributes['lightbox']['navigation']['boxWidth'] ) ? cozy_addons_sanitize_dimension( $attributes['lightbox']['navigation']['boxWidth'] ) : '',
	'box_height' => isset( $attributes['lightbox']['navigation']['boxHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['lightbox']['navigation']['boxHeight'] ) : '',
	'size'       => isset( $attributes['lightbox']['navigation']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['lightbox']['navigation']['size'] ) : '',
	'border'     => isset( $attributes['lightbox']['navigation']['border'] ) ? cozy_render_TRBL( 'border', $attributes['lightbox']['navigation']['border'] ) : '',
	'radius'     => isset( $attributes['lightbox']['navigation']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['lightbox']['navigation']['radius'] ) : '',
	'color'      => array(
		'icon'         => isset( $attributes['lightbox']['navigation']['color']['icon'] ) ? esc_attr( $attributes['lightbox']['navigation']['color']['icon'] ) : '',
		'icon_hover'   => isset( $attributes['lightbox']['navigation']['color']['iconHover'] ) ? esc_attr( $attributes['lightbox']['navigation']['color']['iconHover'] ) : '',
		'bg'           => isset( $attributes['lightbox']['navigation']['color']['bg'] ) ? esc_attr( $attributes['lightbox']['navigation']['color']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['lightbox']['navigation']['color']['bgHover'] ) ? esc_attr( $attributes['lightbox']['navigation']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['lightbox']['navigation']['color']['borderHover'] ) ? esc_attr( $attributes['lightbox']['navigation']['color']['borderHover'] ) : '',
	),
);

$nav = array(
	'box_width'  => isset( $attributes['navigation']['boxWidth'] ) ? cozy_addons_sanitize_dimension( $attributes['navigation']['boxWidth'] ) : '',
	'box_height' => isset( $attributes['navigation']['boxHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['navigation']['boxHeight'] ) : '',
	'size'       => isset( $attributes['navigation']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['navigation']['size'] ) : '',
	'border'     => isset( $attributes['navigation']['border'] ) ? cozy_render_TRBL( 'border', $attributes['navigation']['border'] ) : '',
	'radius'     => isset( $attributes['navigation']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['navigation']['radius'] ) : '',
	'color'      => array(
		'icon'         => isset( $attributes['navigation']['color']['icon'] ) ? esc_attr( $attributes['navigation']['color']['icon'] ) : '',
		'icon_hover'   => isset( $attributes['navigation']['color']['iconHover'] ) ? esc_attr( $attributes['navigation']['color']['iconHover'] ) : '',
		'bg'           => isset( $attributes['navigation']['color']['bg'] ) ? esc_attr( $attributes['navigation']['color']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['navigation']['color']['bgHover'] ) ? esc_attr( $attributes['navigation']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['navigation']['color']['borderHover'] ) ? esc_attr( $attributes['navigation']['color']['borderHover'] ) : '',
	),
);

$bullets = array(
	'gap'      => isset( $attributes['pagination']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['gap'] ) : '',
	'position' => isset( $attributes['pagination']['bottom'] ) && ! empty( $attributes['pagination']['bottom'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['bottom'] ) : '0',
	'align'    => isset( $attributes['pagination']['align'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['align'] ) ) : '',
	'width'    => isset( $attributes['pagination']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['width'] ) : '',
	'height'   => isset( $attributes['pagination']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['height'] ) : '',
	'radius'   => isset( $attributes['pagination']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['radius'] ) : '',
	'active'   => array(
		'width'          => isset( $attributes['pagination']['active']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['active']['width'] ) : '',
		'height'         => isset( $attributes['pagination']['active']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['active']['height'] ) : '',
		'radius'         => isset( $attributes['pagination']['active']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['active']['radius'] ) : '',
		'outline'        => isset( $attributes['pagination']['active']['border'] ) ? cozy_render_TRBL( 'outline', $attributes['pagination']['active']['border'] ) : '',
		'outline_offset' => isset( $attributes['pagination']['active']['offset'] ) ? cozy_addons_sanitize_dimension( $attributes['pagination']['active']['offset'] ) : '',
	),
	'color'    => array(
		'default'       => isset( $attributes['pagination']['color']['default'] ) ? esc_attr( $attributes['pagination']['color']['default'] ) : '',
		'default_hover' => isset( $attributes['pagination']['color']['defaultHover'] ) ? esc_attr( $attributes['pagination']['color']['defaultHover'] ) : '',
		'active'        => isset( $attributes['pagination']['color']['active'] ) ? esc_attr( $attributes['pagination']['color']['active'] ) : '',
		'active_hover'  => isset( $attributes['pagination']['color']['activeHover'] ) ? esc_attr( $attributes['pagination']['color']['activeHover'] ) : '',
	),
	'left'     => isset( $attributes['pagination']['align'], $attributes['pagination']['left'] ) && 'left' === $attributes['pagination']['align'] ? cozy_addons_sanitize_dimension( $attributes['pagination']['left'] ) : '',
	'right'    => isset( $attributes['pagination']['align'], $attributes['pagination']['right'] ) && 'right' === $attributes['pagination']['align'] ? cozy_addons_sanitize_dimension( $attributes['pagination']['right'] ) : '',
);

$ajax_loader = array(
	'padding'           => isset( $attributes['ajaxLoader']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['ajaxLoader']['padding'] ) : '',
	'margin'            => isset( $attributes['ajaxLoader']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['ajaxLoader']['margin'] ) : '',
	'align'             => isset( $attributes['ajaxLoader']['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxLoader']['textAlign'] ) ) : '',
	'border'            => isset( $attributes['ajaxLoader']['border'] ) ? cozy_render_TRBL( 'border', $attributes['ajaxLoader']['border'] ) : '',
	'radius'            => isset( $attributes['ajaxLoader']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['ajaxLoader']['radius'] ) : '',
	'font'              => array(
		'size'   => isset( $attributes['ajaxLoader']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['ajaxLoader']['font']['size'] ) : '',
		'weight' => isset( $attributes['ajaxLoader']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxLoader']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['ajaxLoader']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxLoader']['font']['family'] ) ) : '',
	),
	'letter_case'       => isset( $attributes['ajaxLoader']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxLoader']['letterCase'] ) ) : '',
	'decoration'        => isset( $attributes['ajaxLoader']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxLoader']['decoration'] ) ) : '',
	'line_height'       => isset( $attributes['ajaxLoader']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['ajaxLoader']['lineHeight'] ) : '',
	'letter_spacing'    => isset( $attributes['ajaxLoader']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['ajaxLoader']['letterSpacing'] ) : '',
	'text'              => isset( $attributes['ajaxLoader']['color']['text'] ) ? esc_attr( $attributes['ajaxLoader']['color']['text'] ) : '',
	'text_hover'        => isset( $attributes['ajaxLoader']['color']['textHover'] ) ? esc_attr( $attributes['ajaxLoader']['color']['textHover'] ) : '',
	'bg'                => isset( $attributes['ajaxLoader']['color']['bg'] ) ? esc_attr( $attributes['ajaxLoader']['color']['bg'] ) : '',
	'bg_hover'          => isset( $attributes['ajaxLoader']['color']['bgHover'] ) ? esc_attr( $attributes['ajaxLoader']['color']['bgHover'] ) : '',
	'border_hover'      => isset( $attributes['ajaxLoader']['color']['borderHover'] ) ? esc_attr( $attributes['ajaxLoader']['color']['borderHover'] ) : '',
	'spinner_primary'   => isset( $attributes['ajaxLoader']['color']['spinnerPrimary'] ) ? esc_attr( $attributes['ajaxLoader']['color']['spinnerPrimary'] ) : '',
	'spinner_secondary' => isset( $attributes['ajaxLoader']['color']['spinnerSecondary'] ) ? esc_attr( $attributes['ajaxLoader']['color']['spinnerSecondary'] ) : '',
);

$col1 = isset( $attributes['gridOptions']['column'] ) && $attributes['gridOptions']['column'] <= 3 ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['column'] ) : 3;
$col2 = isset( $attributes['gridOptions']['column'] ) && $attributes['gridOptions']['column'] <= 2 ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['column'] ) : 2;

$block_styles = "
#$block_id .cozy-block-advanced-gallery__header {
    {$header_box['padding']}
    {$header_box['margin']}
    {$header_box['border']}
    border-radius: {$header_box['radius']};
    background-color: {$header_box['bg']};
}
	
#$block_id .cozy-block-advanced-gallery__tabs {
	gap: {$tab_item['gap']};
	justify-content: {$tab_item['justify']};
}

#$block_id .cozy-block-advanced-gallery__tab {
    {$tab_item['padding']}
    {$tab_item['border']}
    border-radius: {$tab_item['radius']};
    font-size: {$tab_item['font']['size']};
    font-weight: {$tab_item['font']['weight']};
    font-family: {$tab_item['font']['family']};
    text-transform: {$tab_item['letter_case']};
    text-decoration: {$tab_item['decoration']};
    line-height: {$tab_item['line_height']};
    letter-spacing: {$tab_item['letter_spacing']};
    background-color: {$tab_item['bg']};
    color: {$tab_item['text']};
}
#$block_id .item-has-default-shadow .cozy-block-advanced-gallery__tab {
    box-shadow: {$tab_item['shadow']['horizontal']}px {$tab_item['shadow']['vertical']}px {$tab_item['shadow']['blur']}px {$tab_item['shadow']['spread']}px {$tab_item['shadow']['color']} {$tab_item['shadow']['position']};
}
#$block_id .cozy-block-advanced-gallery__tab:hover {
    background-color: {$tab_item['bg_hover']};
    color: {$tab_item['text_hover']};
}
#$block_id .cozy-block-advanced-gallery__tab.active-tab {
    margin-bottom: {$tab_item['active_margin_bottom']}px;
    {$tab_item['border_active']}
    background-color: {$tab_item['bg_active']};
    color: {$tab_item['text_active']};
}
#$block_id .item-has-active-shadow .cozy-block-advanced-gallery__tab.active-tab {
    box-shadow: {$tab_item['shadow_active']['horizontal']}px {$tab_item['shadow_active']['vertical']}px {$tab_item['shadow_active']['blur']}px {$tab_item['shadow_active']['spread']}px {$tab_item['shadow_active']['color']} {$tab_item['shadow_active']['position']};
}

#$block_id .cozy-block-advanced-gallery__grid-wrapper:not(.has-masonry) {
	grid-template-columns: repeat({$grid['column']}, 1fr);
	gap: {$grid['gap']};
}
#$block_id .cozy-block-advanced-gallery__grid-wrapper.has-masonry {
	column-count: {$grid['column']};
	column-gap: {$grid['gap']};
}
#$block_id .has-masonry .cozy-block-advanced-gallery__item {
	margin-bottom: {$grid['gap']};
}
@media screen and (max-width: 1024px) {
	#$block_id .cozy-block-advanced-gallery__grid-wrapper:not(.has-masonry) {
		grid-template-columns: repeat({$col1}, 1fr) !important;
	}
	#$block_id .cozy-block-advanced-gallery__grid-wrapper.has-masonry {
		column-count: {$col1} !important;
	}
}
@media screen and (max-width: 767px) {
	#$block_id .cozy-block-advanced-gallery__grid-wrapper:not(.has-masonry) {
		grid-template-columns: repeat({$col2}, 1fr) !important;
	}
	#$block_id .cozy-block-advanced-gallery__grid-wrapper.has-masonry {
		column-count: {$col2} !important;
	}
}
@media screen and (max-width: 568px) {
	#$block_id .cozy-block-advanced-gallery__grid-wrapper:not(.has-masonry) {
		grid-template-columns: repeat(1, 1fr) !important;
	}
	#$block_id .cozy-block-advanced-gallery__grid-wrapper.has-masonry {
		column-count: 1 !important;
	}
}

#$block_id .cozy-block-advanced-gallery__image-wrapper {
	max-width: {$image['width']};
	max-height: {$image['height']};
	border-radius: {$image['radius']};
}
#$block_id .cozy-block-advanced-gallery__image {
	height: {$image['height']};
	border-radius: {$image['radius']};
}
#$block_id .cozy-block-advanced-gallery__image-background {
	background-color: {$image['color']['overlay']};
}
@media only screen and (max-width: 1024px) {
	#$block_id .cozy-block-advanced-gallery__image {
		max-height: {$image['height']};
	}
}

#$block_id .cozy-block-advanced-gallery__image-caption {
	text-align: {$image['title']['align']};
	left: {$image['title']['left']};
	right: {$image['title']['right']};
	font-size: {$image['title']['font']['size']};
	font-weight: {$image['title']['font']['weight']};
	font-family: {$image['title']['font']['family']};
	text-transform: {$image['title']['letter_case']};
	text-decoration: {$image['title']['decoration']};
    line-height: {$image['title']['line_height']};
    letter-spacing: {$image['title']['letter_spacing']};
	color: {$image['color']['text']};
}
#$block_id .cozy-block-advanced-gallery__item.has-hover-caption:hover .cozy-block-advanced-gallery__image-caption {
	bottom: {$image['title']['bottom']};
}

#$block_id .cozy-block-advanced-gallery__icon-wrapper {
	{$icon['padding']}
	{$icon['border']}
	border-radius: {$icon['radius']};
	background-color: {$icon['color']['bg']};
}
#$block_id .cozy-block-advanced-gallery__icon-wrapper:hover {
	background-color: {$icon['color']['bg_hover']};
}
#$block_id .cozy-block-advanced-gallery__icon {
	width: {$icon['size']};
	height: {$icon['size']};
	fill: {$icon['color']['text']};
	stroke: none;
}
#$block_id .cozy-block-advanced-gallery__icon-wrapper:hover .cozy-block-advanced-gallery__icon {
	fill: {$icon['color']['text_hover']};
}

#$block_id .cozy-block-advanced-gallery__lightbox-caption {
	text-align: {$lightbox['title']['align']};
	margin-top: {$lightbox['title']['margin_bottom']}px;
	padding-left: {$lightbox['title']['left']};
	padding-right: {$lightbox['title']['right']};
	font-size: {$lightbox['title']['font']['size']};
	font-weight: {$lightbox['title']['font']['weight']};
	font-family: {$lightbox['title']['font']['family']};
	font-family: '{$attributes['lightbox']['title']['font']['family']}';
	text-transform: {$lightbox['title']['letter_case']};
	text-decoration: {$lightbox['title']['decoration']};
	line-height: {$lightbox['title']['line_height']};
	letter-spacing: {$lightbox['title']['letter_spacing']};
	color: {$lightbox['color']['text']};
}

#$block_id .swiper-button-prev.lightbox-button-prev::after,
#$block_id .swiper-button-next.lightbox-button-next::after {
    font-size: {$lightbox_nav['size']};
}
#$block_id .swiper-button-prev.lightbox-button-prev,
#$block_id .swiper-button-next.lightbox-button-next {
    width: {$lightbox_nav['box_width']};
    height: {$lightbox_nav['box_height']};
    {$lightbox_nav['border']}
    border-radius: {$lightbox_nav['radius']};
    color: {$lightbox_nav['color']['icon']};
    background-color: {$lightbox_nav['color']['bg']};
}
#$block_id .swiper-button-prev.lightbox-button-prev:hover,
#$block_id .swiper-button-next.lightbox-button-next:hover {
    color: {$lightbox_nav['color']['icon_hover']};
    background-color: {$lightbox_nav['color']['bg_hover']};
    border-color: {$lightbox_nav['color']['border_hover']};
}

#$block_id .swiper-button-prev::after,
#$block_id .swiper-button-next::after {
    font-size: {$nav['size']};
}
#$block_id .swiper-button-prev,
#$block_id .swiper-button-next {
    width: {$nav['box_width']};
    height: {$nav['box_height']};
    {$nav['border']}
    border-radius: {$nav['radius']};
    color: {$nav['color']['icon']};
    background-color: {$nav['color']['bg']};
}
#$block_id .swiper-button-prev:hover,
#$block_id .swiper-button-next:hover {
    color: {$nav['color']['icon_hover']};
    background-color: {$nav['color']['bg_hover']};
    border-color: {$nav['color']['border_hover']};
}

#$block_id .swiper-pagination {
    bottom: {$bullets['position']}px;
    text-align: {$bullets['align']};
    padding-left: {$bullets['left']};
    padding-right: {$bullets['right']};
}
#$block_id .swiper-pagination-bullet {
    width: {$bullets['width']};
    height: {$bullets['height']};
    border-radius: {$bullets['radius']};
    background-color: {$bullets['color']['default']};
}
#$block_id .swiper-pagination-horizontal .swiper-pagination-bullet {
    margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$bullets['gap']});
}
#$block_id .swiper-pagination-bullet:hover {
    background-color: {$bullets['color']['default_hover']};
}
#$block_id .swiper-pagination-bullet-active {
    width: {$bullets['active']['width']};
    height: {$bullets['active']['height']};
    border-radius: {$bullets['active']['radius']};
    {$bullets['active']['outline']}
    outline-offset: {$bullets['active']['outline_offset']};
    background-color: {$bullets['color']['active']};
}
#$block_id .swiper-pagination-bullet-active:hover {
    background-color: {$bullets['color']['active_hover']};
}

#$block_id .cozy-block-advanced-gallery__ajax-loader-wrapper {
	{$ajax_loader['margin']}
	text-align: {$ajax_loader['align']};
}
#$block_id .cozy-block-advanced-gallery__ajax-loader, #$block_id .scroll-spinner.has-loading-text {
	{$ajax_loader['padding']}
	{$ajax_loader['border']}
	border-radius: {$ajax_loader['radius']};
	font-size: {$ajax_loader['font']['size']};
	font-weight: {$ajax_loader['font']['weight']};
	font-family: {$ajax_loader['font']['family']};
	text-transform: {$ajax_loader['letter_case']};
	text-decoration: {$ajax_loader['decoration']};
	line-height: {$ajax_loader['line_height']};
	letter-spacing: {$ajax_loader['letter_spacing']};
	color: {$ajax_loader['text']};
	background-color: {$ajax_loader['bg']};
	min-width: {$attributes['ajaxLoader']['minWidth']};
}
#$block_id .cozy-block-advanced-gallery__ajax-loader:hover {
	color: {$ajax_loader['text_hover']};
	background-color: {$ajax_loader['bg_hover']};
	border-color: {$ajax_loader['border_hover']};
}
#$block_id .cozy-block-advanced-gallery__ajax-loader .spinner,
#$block_id .scroll-spinner {
	border-color: {$ajax_loader['spinner_secondary']};
	border-top-color: {$ajax_loader['spinner_primary']};
}
";

$classes   = array();
$classes[] = 'cozy-block-advanced-gallery';
$classes[] = 'display-' . $attributes['display'];
$classes[] = 'carousel' === $attributes['display'] && $attributes['navigation']['enabled'] && $attributes['navigation']['hoverShow'] ? 'has-nav-hover-show' : '';
$classes[] = 'grid' === $attributes['display'] && $attributes['enableOptions']['lightbox'] ? 'has-light-box' : '';
$classes[] = 'grid' === $attributes['display'] && $attributes['ajaxLoader']['enabled'] && 'scroll' === $attributes['ajaxLoader']['type'] ? 'has-infinite-scroll' : '';
$output    = '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '" id="' . esc_attr( $block_id ) . '">';

/* Header */
if ( 'grid' === $attributes['display'] && $attributes['enableOptions']['isotopeFilter'] ) {
	$classes   = array();
	$classes[] = 'cozy-block-advanced-gallery__header';
	$output   .= '<article class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';

	/* Tabs */
	$classes   = array();
	$classes[] = 'cozy-block-advanced-gallery__tabs';
	$classes[] = isset( $attributes['tabStyles']['default']['shadow']['enabled'] ) ? 'item-has-default-shadow' : '';
	$classes[] = isset( $attributes['tabStyles']['active']['shadow']['enabled'] ) ? 'item-has-active-shadow' : '';
	$output   .= '<ul class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
	if ( $attributes['tabOptions']['showDefaultTab'] ) {
		$output .= '<li class="cozy-block-advanced-gallery__tab active-tab" data-index="0" data-slug="">' . esc_html__( 'All', 'cozy-addons' ) . '</li>';
	}
	if ( ! empty( $attributes['tabsList'] ) ) {
		foreach ( (array) $attributes['tabsList'] as $index => $identifier ) {
			$classes    = array();
			$classes[]  = 'cozy-block-advanced-gallery__tab';
			$classes[]  = ! $attributes['tabOptions']['showDefaultTab'] && 0 === $index ? 'active-tab' : '';
			$data_index = $attributes['tabOptions']['showDefaultTab'] ? $index + 1 : $index;
			$output    .= '<li class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '" data-index="' . $data_index . '" data-slug="' . $identifier['id'] . '">';
			$output    .= esc_html( $identifier['title'] );
			$output    .= '</li>';
		}
	}
	$output .= '</ul>';
	/* End Tabs */

	$output .= '</article>';
}
/* End Header */

/*
Body */
/* All Tab Content Body */
if ( ( ( $attributes['tabOptions']['showDefaultTab'] && $attributes['enableOptions']['isotopeFilter'] && 'grid' === $attributes['display'] ) || ( ! $attributes['enableOptions']['isotopeFilter'] && 'grid' === $attributes['display'] ) || 'carousel' === $attributes['display'] ) && ! empty( $attributes['mediaCollection'] ) ) {
	$all_media = array();
	if ( intval( $attributes['perPage'] ) > 0 ) {
		$all_media = array_slice( (array) $attributes['mediaCollection'], 0, $attributes['perPage'] );
	} else {
		$all_media = $attributes['mediaCollection'];
	}
	$limit = count( (array) $attributes['mediaCollection'] ) - 1;

	$remaining_posts = array(); // Check if per page is -1.
	if ( intval( $attributes['perPage'] ) > 0 ) {
		$remaining_posts = array_slice( (array) $attributes['mediaCollection'], $attributes['perPage'], $limit );
	}


	$classes   = array();
	$classes[] = 'cozy-block-advanced-gallery__body';
	$classes[] = 'carousel' === $attributes['display'] ? 'swiper-container' : '';
	$classes[] = 'active-content';
	$classes[] = 'animation__fade-in';
	$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';

	$classes   = array();
	$classes[] = 'cozy-block-advanced-gallery__' . $attributes['display'] . '-wrapper';
	$classes[] = 'grid' === $attributes['display'] && $attributes['gridOptions']['masonry'] ? 'has-masonry' : '';
	$classes[] = 'carousel' === $attributes['display'] ? 'swiper-wrapper' : '';
	$output   .= '<ul class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
	/* Item */
	foreach ( $all_media as $media ) {
		\CozyAddons\Helpers\BlockRender::advanced_gallery_render( $attributes, $media, $output );
	}
	/* End Item */
	$output .= '</ul>';

	if ( ! empty( $remaining_posts ) && $attributes['ajaxLoader']['enabled'] ) {
		if ( 'default' === $attributes['ajaxLoader']['type'] ) {
			$classes   = array();
			$classes[] = 'cozy-block-advanced-gallery__ajax-loader';
			$output   .= '<div class="cozy-block-advanced-gallery__ajax-loader-wrapper">';
			$output   .= '<button class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '" data-slug="all">';
			$output   .= '<span>' . esc_html( $attributes['ajaxLoader']['label'] ) . '</span>';

			$classes   = array();
			$classes[] = 'spinner';
			$classes[] = isset( $attributes['ajaxLoader']['loadingText'] ) && ! empty( $attributes['ajaxLoader']['loadingText'] ) ? 'has-loading-text' : '';
			$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
			$output   .= esc_html( $attributes['ajaxLoader']['loadingText'] );
			$output   .= '<span class="cozy-block-advanced-gallery__dots"></span>';
			$output   .= '</div>';

			$output .= '</button>';
			$output .= '</div>';
		}

		if ( 'scroll' === $attributes['ajaxLoader']['type'] ) {
				$output .= '<div class="scroll-spinner-wrapper" style="text-align: center;"  data-slug="all">';
			$classes     = array();
			$classes[]   = 'scroll-spinner';
			$classes[]   = 'display-none';
			$classes[]   = isset( $attributes['ajaxLoader']['loadingText'] ) && ! empty( $attributes['ajaxLoader']['loadingText'] ) ? 'has-loading-text' : '';
			$output     .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
			if ( isset( $attributes['ajaxLoader']['loadingText'] ) && ! empty( $attributes['ajaxLoader']['loadingText'] ) ) {
				$output .= esc_html( $attributes['ajaxLoader']['loadingText'] );
				$output .= '<span class="cozy-block-advanced-gallery__dots"></span>';
			}
			$output .= '</div>';
			$output .= '</div>';
		}
	}
	$output .= '</div>';

	if ( 'carousel' === $attributes['display'] ) {
		if ( $attributes['navigation']['enabled'] ) {
			$output .= '<div class="swiper-button-prev carousel-btn-prev"></div>';
			$output .= '<div class="swiper-button-next carousel-btn-next"></div>';
		}
		if ( $attributes['pagination']['enabled'] ) {
			$output .= '<div class="swiper-pagination carousel-pagination"></div>';
		}
	}
	/* End All Tab Content Body */

}
/* End Body */

/* Tab Content Body */
if ( 'grid' === $attributes['display'] && $attributes['enableOptions']['isotopeFilter'] && ! empty( $attributes['tabsList'] ) ) {
	$attributes['tabRemainingData'] = array();
	foreach ( (array) $attributes['tabsList'] as $key => $gallery_tab ) {
		$tab_id = $gallery_tab['id'];
		$attributes['tabRemainingData'][ $tab_id ]['offset']       = '0';
		$attributes['tabRemainingData'][ $tab_id ]['isFetching']   = false;
		$attributes['tabRemainingData'][ $tab_id ]['hasNextChunk'] = true;

		$classes   = array();
		$classes[] = 'cozy-block-advanced-gallery__body';
		$classes[] = ! $attributes['tabOptions']['showDefaultTab'] && 0 === $key ? 'active-content' : '';
		$classes[] = ! $attributes['tabOptions']['showDefaultTab'] && 0 === $key ? 'animation__fade-in' : '';
		$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';

		$classes   = array();
		$classes[] = 'cozy-block-advanced-gallery__' . $attributes['display'] . '-wrapper';
		$classes[] = 'grid' === $attributes['display'] && $attributes['gridOptions']['masonry'] ? 'has-masonry' : '';
		$output   .= '<ul class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';

		$filtered_items = array_filter(
			(array) $attributes['mediaCollection'],
			function ( $item ) use ( $tab_id ) {
				return in_array( $tab_id, $item['categories'], true );
			}
		);

		$all_media = array();
		if ( $attributes['ajaxLoader']['enabled'] && 'default' === $attributes['ajaxLoader']['type'] && intval( $attributes['perPage'] ) > 0 ) {
			// if ( intval( $attributes['perPage'] ) > 0 ) {
			$all_media = array_slice( $filtered_items, 0, $attributes['perPage'] );
		} else {
			$all_media = $filtered_items;
		}
		$limit           = count( $filtered_items ) - 1;
		$remaining_posts = array(); // Check if per page is -1.
		if ( intval( $attributes['perPage'] ) > 0 ) {
			$remaining_posts = array_slice( $filtered_items, $attributes['perPage'], $limit );
		}
		if ( ! empty( $all_media ) ) {
			/* Item */
			foreach ( $all_media as $media ) {
				\CozyAddons\Helpers\BlockRender::advanced_gallery_render( $attributes, $media, $output );
			}
			/* End Item */
		}
		$output .= '</ul>';

		// Tab Ajax Loader.
		if ( ! empty( $remaining_posts ) && $attributes['ajaxLoader']['enabled'] ) {
			if ( 'default' === $attributes['ajaxLoader']['type'] ) {
				$classes   = array();
				$classes[] = 'cozy-block-advanced-gallery__ajax-loader';
				$output   .= '<div class="cozy-block-advanced-gallery__ajax-loader-wrapper">';
				$output   .= '<button class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '" data-slug="' . esc_attr( $tab_id ) . '">';
				$output   .= '<span>' . esc_html( $attributes['ajaxLoader']['label'] ) . '</span>';

				$classes   = array();
				$classes[] = 'spinner';
				$classes[] = isset( $attributes['ajaxLoader']['loadingText'] ) && ! empty( $attributes['ajaxLoader']['loadingText'] ) ? 'has-loading-text' : '';
				$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
				$output   .= esc_html( $attributes['ajaxLoader']['loadingText'] );
				$output   .= '<span class="cozy-block-advanced-gallery__dots"></span>';
				$output   .= '</div>';

				$output .= '</button>';
				$output .= '</div>';
			}

			if ( 'scroll' === $attributes['ajaxLoader']['type'] ) {
				$output   .= '<div class="scroll-spinner-wrapper" style="text-align: center;"  data-slug="' . esc_attr( $tab_id ) . '">';
				$classes   = array();
				$classes[] = 'scroll-spinner';
				$classes[] = 'display-none';
				$classes[] = isset( $attributes['ajaxLoader']['loadingText'] ) && ! empty( $attributes['ajaxLoader']['loadingText'] ) ? 'has-loading-text' : '';
				$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
				if ( isset( $attributes['ajaxLoader']['loadingText'] ) && ! empty( $attributes['ajaxLoader']['loadingText'] ) ) {
					$output .= esc_html( $attributes['ajaxLoader']['loadingText'] );
					$output .= '<span class="cozy-block-advanced-gallery__dots"></span>';
				}
				$output .= '</div>';
				$output .= '</div>';
			}
		}
		$output .= '</div>';
		/* End Tab Content */

	}
}
/* End Tab Content Body */

/*
Lightbox */
// if ( 'grid' === $attributes['display'] && $attributes['enableOptions']['lightbox'] && ! empty( $attributes['mediaCollection'] ) ) {
if ( $attributes['enableOptions']['lightbox'] && ! empty( $attributes['mediaCollection'] ) ) {
	$output .= '<div class="cozy-block-advanced-gallery__lightbox-wrapper display-none">';

	$output .= '<div class="cozy-block-advanced-gallery__toolbar-wrapper" style="display:flex;justify-content:space-between;position:relative;z-index:99999;">';
	$output .= '<div class="swiper-pagination lightbox-pagination"></div>';

	/* Toolbar Buttons */
	$output .= '<div style="padding:6px;display:flex;align-items:center;gap:22px;background-color:#4f4e4e;">';
	/* Full Screen Button */
	$output .= '<div class="cozy-block-advanced-gallery__toolbar-button lightbox-fullscreen-button">';
	$output .= '<svg width="20px" height="20px" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/" aria-hidden="true">';
	$output .= '<path d="M4.5 11H3v4h4v-1.5H4.5V11zM3 7h1.5V4.5H7V3H3v4zm10.5 6.5H11V15h4v-4h-1.5v2.5zM11 3v1.5h2.5V7H15V3h-4z" />';
	$output .= '</svg>';
	$output .= '</div>';
	/* End Full Screen Button */

	/* Close Button */
	$output .= '<div class="cozy-block-advanced-gallery__toolbar-button lightbox-close-button">';
	$output .= '<svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/" aria-hidden="true">';
	$output .= '<path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z" />';
	$output .= '</svg>';
	$output .= '</div>';
	/* End Close Button */
	$output .= '</div>';
	/* End Toolbar Buttons */

	$output .= '</div>';

	if ( ( $attributes['enableOptions']['isotopeFilter'] && $attributes['tabOptions']['showDefaultTab'] ) || ( ! $attributes['enableOptions']['isotopeFilter'] && 'grid' === $attributes['display'] ) || 'carousel' === $attributes['display'] ) {
		$output .= '<div class="cozy-block-advanced-gallery__lightbox active-gallery">';
		$output .= '<ul class="cozy-block-advanced-gallery__lightbox-swiper-wrapper swiper-wrapper active-content">';
		foreach ( (array) $attributes['mediaCollection'] as $media ) {
			$output .= '<li class="cozy-block-advanced-gallery__lightbox-item swiper-slide">';

			$classes   = array();
			$classes[] = 'cozy-block-advanced-gallery__lightbox-image-wrapper';
			$output   .= '<figure class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
			$output   .= '<img class="cozy-block-advanced-gallery__lightbox-image" src="' . esc_url( $media['url'] ) . '" alt="' . esc_attr( $media['alt'] ) . '" />';
			$output   .= '</figure>';

			if ( $attributes['enableOptions']['lightboxTitle'] ) {
				$output .= '<div class="cozy-block-advanced-gallery__lightbox-caption">';
				$output .= esc_html( $media['caption'] );
				$output .= '</div>';
			}

			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '</div>';
	}
	if ( $attributes['enableOptions']['isotopeFilter'] && ! empty( $attributes['tabsList'] ) ) {
		foreach ( (array) $attributes['tabsList'] as $key => $gallery_tab ) {
			$tab_id                 = $gallery_tab['id'];
			$gallery_filtered_items = array_filter(
				(array) $attributes['mediaCollection'],
				function ( $item ) use ( $tab_id ) {
					return in_array( $tab_id, $item['categories'], true );
				}
			);

			$classes   = array();
			$classes[] = 'cozy-block-advanced-gallery__lightbox';
			$classes[] = ! $attributes['tabOptions']['showDefaultTab'] && 0 === $key ? 'active-gallery' : '';
			$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';

			$classes   = array();
			$classes[] = 'cozy-block-advanced-gallery__lightbox-swiper-wrapper';
			$classes[] = 'swiper-wrapper';
			$classes[] = ! $attributes['tabOptions']['showDefaultTab'] && 0 === $key ? 'active-content' : '';
			$output   .= '<ul class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
			if ( ! empty( $gallery_filtered_items ) ) {
				foreach ( $gallery_filtered_items as $media ) {
					$output .= '<li class="cozy-block-advanced-gallery__lightbox-item swiper-slide">';

					$classes   = array();
					$classes[] = 'cozy-block-advanced-gallery__lightbox-image-wrapper';
					$output   .= '<figure class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
					$output   .= '<img class="cozy-block-advanced-gallery__lightbox-image" src="' . esc_url( $media['url'] ) . '" alt="' . esc_attr( $media['alt'] ) . '" />';
					$output   .= '</figure>';

					if ( $attributes['enableOptions']['lightboxTitle'] ) {
						$output .= '<div class="cozy-block-advanced-gallery__lightbox-caption">';
						$output .= esc_html( $media['caption'] );
						$output .= '</div>';
					}

					$output .= '</li>';
				}
			}
			$output .= '</ul>';

			$output .= '</div>';
		}
	}

	$output .= '<div class="swiper-button-prev lightbox-button-prev"></div>';
	$output .= '<div class="swiper-button-next lightbox-button-next"></div>';


	$output .= '</div>';
}
/* End Lightbox */

$output .= '</div>';

wp_localize_script( 'cozy-block--advanced-gallery--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--advanced-gallery--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockAdvancedGallery( "' . $client_id . '" ) }) ' );

$wrapper_attributes = get_block_wrapper_attributes();

$font_families = array();

if ( isset( $attributes['tabStyles']['font']['family'] ) && ! empty( $attributes['tabStyles']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['tabStyles']['font']['family'] );
}
if ( isset( $attributes['image']['title']['font']['family'] ) && ! empty( $attributes['image']['title']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['image']['title']['font']['family'] );
}
if ( isset( $attributes['lightbox']['title']['font']['family'] ) && ! empty( $attributes['lightbox']['title']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['lightbox']['title']['font']['family'] );
}
if ( isset( $attributes['ajaxLoader']['font']['family'] ) && ! empty( $attributes['ajaxLoader']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['ajaxLoader']['font']['family'] );
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

$render = sprintf( '<div class="cozy-block-wrapper"><div %1$s>%2$s</div></div>', $wrapper_attributes, $output );
echo $render;
