<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['clientId'] ) ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$header_box = array(
	'padding'   => isset( $attributes['headerBox']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['headerBox']['padding'] ) : '',
	'margin'    => isset( $attributes['headerBox']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['headerBox']['margin'] ) : '',
	'border'    => isset( $attributes['headerBox']['border'] ) ? cozy_render_TRBL( 'border', $attributes['headerBox']['border'] ) : '',
	'radius'    => isset( $attributes['headerBox']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['headerBox']['radius'] ) : '',
	'gap'       => isset( $attributes['headingGap'] ) ? cozy_addons_sanitize_dimension( $attributes['headingGap'] ) : '',
	'tab_align' => isset( $attributes['headerBox']['tabAlign'] ) ? esc_attr( sanitize_text_field( $attributes['headerBox']['tabAlign'] ) ) : '',
	'bg'        => isset( $attributes['headerBox']['color']['bg'] ) ? esc_attr( $attributes['headerBox']['color']['bg'] ) : '',
);

$heading = array(
	'padding'        => cozy_render_TRBL( 'padding', $attributes['headingStyles']['padding'] ),
	'border'         => isset( $attributes['headingStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['headingStyles']['border'] ) : '',
	'radius'         => cozy_render_TRBL( 'border-radius', $attributes['headingStyles']['radius'] ),
	'font'           => array(
		'size'   => isset( $attributes['headingStyles']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['headingStyles']['font']['size'] ) : '',
		'weight' => isset( $attributes['headingStyles']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['headingStyles']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['headingStyles']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['headingStyles']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['headingStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['headingStyles']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['headingStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['headingStyles']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['headingStyles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['headingStyles']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['headingStyles']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['headingStyles']['letterSpacing'] ) : '',
	'bg'             => isset( $attributes['headingStyles']['color']['bg'] ) ? esc_attr( $attributes['headingStyles']['color']['bg'] ) : '',
	'text'           => isset( $attributes['headingStyles']['color']['text'] ) ? esc_attr( $attributes['headingStyles']['color']['text'] ) : '',
	'clip_path'      => isset( $attributes['headingStyles']['clipPath'] ) ? esc_attr( $attributes['headingStyles']['clipPath'] ) : '',
);

$sub_heading = array(
	'padding'        => isset( $attributes['subHeading']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['subHeading']['padding'] ) : '',
	'border'         => isset( $attributes['subHeading']['border'] ) ? cozy_render_TRBL( 'border', $attributes['subHeading']['border'] ) : '',
	'radius'         => isset( $attributes['subHeading']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['subHeading']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['subHeading']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['subHeading']['font']['size'] ) : '',
		'weight' => isset( $attributes['subHeading']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['subHeading']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['subHeading']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['subHeading']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['subHeading']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['subHeading']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['subHeading']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['subHeading']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['subHeading']['lineHeight'] ) ? $attributes['subHeading']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['subHeading']['letterSpacing'] ) ? $attributes['subHeading']['letterSpacing'] : '',
	'text'           => isset( $attributes['subHeading']['color']['text'] ) ? $attributes['subHeading']['color']['text'] : '',
	'text_hover'     => isset( $attributes['subHeading']['color']['textHover'] ) ? $attributes['subHeading']['color']['textHover'] : '',
	'bg'             => isset( $attributes['subHeading']['color']['bg'] ) ? $attributes['subHeading']['color']['bg'] : '',
	'bg_hover'       => isset( $attributes['subHeading']['color']['bgHover'] ) ? $attributes['subHeading']['color']['bgHover'] : '',
	'border_hover'   => isset( $attributes['subHeading']['color']['borderHover'] ) ? $attributes['subHeading']['color']['borderHover'] : '',
);

$featured_styles = array(
	'col_gap' => isset( $attributes['featuredPostOptions']['columnGap'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['columnGap'] ) : '',
	'row_gap' => isset( $attributes['featuredPostOptions']['rowGap'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['rowGap'] ) : '',
);

$featured_image   = array(
	'margin' => isset( $attributes['featuredPostOptions']['image']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['featuredPostOptions']['image']['margin'] ) : '',
	'height' => isset( $attributes['featuredPostOptions']['image']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['image']['height'] ) : '',
	'radius' => isset( $attributes['featuredPostOptions']['image']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['image']['radius'] ) : '',
);
$featured_content = array(
	'wrapper'  => array(
		'vgap' => isset( $attributes['featuredPostOptions']['content']['outerVGap'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['content']['outerVGap'] ) : '',
		'hgap' => isset( $attributes['featuredPostOptions']['content']['outerHGap'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['content']['outerHGap'] ) : '',
	),
	'padding'  => isset( $attributes['featuredPostOptions']['content']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['featuredPostOptions']['content']['padding'] ) : '',
	'margin'   => array(
		'top'    => isset( $attributes['featuredPostOptions']['content']['margin']['top'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['content']['margin']['top'] ) : '',
		'bottom' => isset( $attributes['featuredPostOptions']['content']['margin']['bottom'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['content']['margin']['bottom'] ) : '',
	),
	'border'   => isset( $attributes['featuredPostOptions']['content']['border'] ) ? cozy_render_TRBL( 'border', $attributes['featuredPostOptions']['content']['border'] ) : '',
	'radius'   => isset( $attributes['featuredPostOptions']['content']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['content']['radius'] ) : '',
	'position' => isset( $attributes['featuredPostOptions']['content']['position'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostOptions']['content']['position'] ) ) : '',
	'align'    => isset( $attributes['featuredPostOptions']['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostOptions']['textAlign'] ) ) : '',
	'bg'       => isset( $attributes['featuredPostOptions']['content']['color']['bg'] ) ? $attributes['featuredPostOptions']['content']['color']['bg'] : '',
);

$featured_cat = array(
	'border'         => isset( $attributes['featuredPostCategories']['border'] ) ? cozy_render_TRBL( 'border', $attributes['featuredPostCategories']['border'] ) : '',
	'radius'         => isset( $attributes['featuredPostCategories']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostCategories']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['featuredPostCategories']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostCategories']['font']['size'] ) : '',
		'family' => isset( $attributes['featuredPostCategories']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostCategories']['font']['family'] ) ) : '',
		'weight' => isset( $attributes['featuredPostCategories']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostCategories']['font']['weight'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['featuredPostCategories']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostCategories']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['featuredPostCategories']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostCategories']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['featuredPostCategories']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostCategories']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['featuredPostCategories']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostCategories']['letterSpacing'] ) : '',
	'color'          => array(
		'text'         => isset( $attributes['featuredPostCategories']['color']['text'] ) ? esc_attr( $attributes['featuredPostCategories']['color']['text'] ) : '',
		'text_hover'   => isset( $attributes['featuredPostCategories']['color']['textHover'] ) ? esc_attr( $attributes['featuredPostCategories']['color']['textHover'] ) : '',
		'bg'           => isset( $attributes['featuredPostCategories']['color']['bg'] ) ? esc_attr( $attributes['featuredPostCategories']['color']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['featuredPostCategories']['color']['bgHover'] ) ? esc_attr( $attributes['featuredPostCategories']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['featuredPostCategories']['color']['borderHover'] ) ? esc_attr( $attributes['featuredPostCategories']['color']['borderHover'] ) : '',
	),
);

$featured_title = array(
	'margin'         => isset( $attributes['featuredPostOptions']['title']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['featuredPostOptions']['title']['margin'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['featuredPostOptions']['title']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['title']['font']['size'] ) : '',
		'weight' => isset( $attributes['featuredPostOptions']['title']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostOptions']['title']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['featuredPostOptions']['title']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostOptions']['title']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['featuredPostOptions']['title']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostOptions']['title']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['featuredPostOptions']['title']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['featuredPostOptions']['title']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['featuredPostOptions']['title']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['title']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['featuredPostOptions']['title']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredPostOptions']['title']['letterSpacing'] ) : '',
	'color'          => isset( $attributes['featuredPostOptions']['title']['color']['text'] ) ? esc_attr( $attributes['featuredPostOptions']['title']['color']['text'] ) : '',
	'color_hover'    => isset( $attributes['featuredPostOptions']['title']['color']['textHover'] ) ? esc_attr( $attributes['featuredPostOptions']['title']['color']['textHover'] ) : '',
);

$featured_read_more = array(
	'border'         => isset( $attributes['featuredReadMore']['border'] ) ? cozy_render_TRBL( 'border', $attributes['featuredReadMore']['border'] ) : '',
	'radius'         => isset( $attributes['featuredReadMore']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredReadMore']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['featuredReadMore']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredReadMore']['font']['size'] ) : '',
		'weight' => isset( $attributes['featuredReadMore']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['featuredReadMore']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['featuredReadMore']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['featuredReadMore']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['featuredReadMore']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['featuredReadMore']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['featuredReadMore']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['featuredReadMore']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['featuredReadMore']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredReadMore']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['featuredReadMore']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['featuredReadMore']['letterSpacing'] ) : '',
	'color'          => array(
		'text'         => isset( $attributes['featuredReadMore']['color']['text'] ) ? esc_attr( $attributes['featuredReadMore']['color']['text'] ) : '',
		'text_hover'   => isset( $attributes['featuredReadMore']['color']['textHover'] ) ? esc_attr( $attributes['featuredReadMore']['color']['textHover'] ) : '',
		'bg'           => isset( $attributes['featuredReadMore']['color']['bg'] ) ? esc_attr( $attributes['featuredReadMore']['color']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['featuredReadMore']['color']['bgHover'] ) ? esc_attr( $attributes['featuredReadMore']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['featuredReadMore']['color']['borderHover'] ) ? esc_attr( $attributes['featuredReadMore']['color']['borderHover'] ) : '',
	),
);

$post_styles = array(
	'align'  => isset( $attributes['postOptions']['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['postOptions']['textAlign'] ) ) : '',
	'column' => isset( $attributes['postOptions']['column'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['column'] ) : '',
	'gap'    => isset( $attributes['postOptions']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['gap'] ) : '',
);

$post_item = array(
	'padding'      => isset( $attributes['postBoxStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['postBoxStyles']['padding'] ) : '',
	'margin'       => isset( $attributes['postBoxStyles']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['postBoxStyles']['margin'] ) : '',
	'border'       => isset( $attributes['postBoxStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['postBoxStyles']['border'] ) : '',
	'radius'       => isset( $attributes['postBoxStyles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['postBoxStyles']['radius'] ) : '',
	'shadow'       => array(
		'horizontal' => isset( $attributes['postBoxStyles']['shadow']['horizontal'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['postBoxStyles']['shadow']['vertical'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['postBoxStyles']['shadow']['blur'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['postBoxStyles']['shadow']['spread'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['spread'] ) : '',
		'color'      => isset( $attributes['postBoxStyles']['shadow']['color'] ) ? esc_attr( $attributes['postBoxStyles']['shadow']['color'] ) : '',
		'position'   => isset( $attributes['postBoxStyles']['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['postBoxStyles']['shadow']['position'] ) ) : '',
	),
	'shadow_hover' => array(
		'horizontal' => isset( $attributes['postBoxStyles']['shadowHover']['horizontal'] ) ? esc_attr( $attributes['postBoxStyles']['shadowHover']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['postBoxStyles']['shadowHover']['vertical'] ) ? esc_attr( $attributes['postBoxStyles']['shadowHover']['vertical'] ) : '',
		'blur'       => isset( $attributes['postBoxStyles']['shadowHover']['blur'] ) ? esc_attr( $attributes['postBoxStyles']['shadowHover']['blur'] ) : '',
		'spread'     => isset( $attributes['postBoxStyles']['shadowHover']['spread'] ) ? esc_attr( $attributes['postBoxStyles']['shadowHover']['spread'] ) : '',
		'color'      => isset( $attributes['postBoxStyles']['shadowHover']['color'] ) ? esc_attr( $attributes['postBoxStyles']['shadowHover']['color'] ) : '',
		'position'   => isset( $attributes['postBoxStyles']['shadowHover']['position'] ) ? esc_attr( sanitize_text_field( $attributes['postBoxStyles']['shadowHover']['position'] ) ) : '',
	),
	'content_gap'  => isset( $attributes['postOptions']['content']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['content']['gap'] ) : '',
	'row_gap'      => isset( $attributes['postOptions']['content']['rowGap'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['content']['rowGap'] ) : '',
	'bg'           => isset( $attributes['postBoxStyles']['color']['bg'] ) ? esc_attr( $attributes['postBoxStyles']['color']['bg'] ) : '',
	'bg_hover'     => isset( $attributes['postBoxStyles']['color']['bgHover'] ) ? esc_attr( $attributes['postBoxStyles']['color']['bgHover'] ) : '',
	'border_hover' => isset( $attributes['postBoxStyles']['color']['borderHover'] ) ? esc_attr( $attributes['postBoxStyles']['color']['borderHover'] ) : '',
);

$post_image = array(
	'margin' => isset( $attributes['postOptions']['image']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['postOptions']['image']['margin'] ) : '',
	'width'  => isset( $attributes['postOptions']['image']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['image']['width'] ) : '',
	'height' => isset( $attributes['postOptions']['image']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['image']['height'] ) : '',
	'radius' => isset( $attributes['postOptions']['image']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['image']['radius'] ) : '',
);

$cat_item = array(
	'gap'            => isset( $attributes['postCategories']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['postCategories']['gap'] ) : '',
	'padding'        => isset( $attributes['postCategories']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['postCategories']['padding'] ) : '',
	'margin'         => isset( $attributes['postCategories']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['postCategories']['margin'] ) : '',
	'border'         => isset( $attributes['postCategories']['border'] ) ? cozy_render_TRBL( 'border', $attributes['postCategories']['border'] ) : '',
	'radius'         => isset( $attributes['postCategories']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['postCategories']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['postCategories']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['postCategories']['font']['size'] ) : '',
		'weight' => isset( $attributes['postCategories']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['postCategories']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['postCategories']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['postCategories']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['postCategories']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['postCategories']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['postCategories']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['postCategories']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['postCategories']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['postCategories']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['postCategories']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['postCategories']['letterSpacing'] ) : '',
	'text'           => isset( $attributes['postCategories']['color']['text'] ) ? esc_attr( $attributes['postCategories']['color']['text'] ) : '',
	'text_hover'     => isset( $attributes['postCategories']['color']['textHover'] ) ? esc_attr( $attributes['postCategories']['color']['textHover'] ) : '',
	'bg'             => isset( $attributes['postCategories']['color']['bg'] ) ? esc_attr( $attributes['postCategories']['color']['bg'] ) : '',
	'bg_hover'       => isset( $attributes['postCategories']['color']['bgHover'] ) ? esc_attr( $attributes['postCategories']['color']['bgHover'] ) : '',
	'border_hover'   => isset( $attributes['postCategories']['color']['borderHover'] ) ? esc_attr( $attributes['postCategories']['color']['borderHover'] ) : '',
);

$post_title = array(
	'margin'         => isset( $attributes['postOptions']['title']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['postOptions']['title']['margin'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['postOptions']['title']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['title']['font']['size'] ) : '',
		'weight' => isset( $attributes['postOptions']['title']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['postOptions']['title']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['postOptions']['title']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['postOptions']['title']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['postOptions']['title']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['postOptions']['title']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['postOptions']['title']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['postOptions']['title']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['postOptions']['title']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['title']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['postOptions']['title']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['postOptions']['title']['letterSpacing'] ) : '',
	'color'          => isset( $attributes['postOptions']['title']['color']['text'] ) ? esc_attr( $attributes['postOptions']['title']['color']['text'] ) : '',
	'color_hover'    => isset( $attributes['postOptions']['title']['color']['textHover'] ) ? esc_attr( $attributes['postOptions']['title']['color']['textHover'] ) : '',
);

$post_meta = array(
	'margin'         => isset( $attributes['postMeta']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['postMeta']['margin'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['postMeta']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) : '',
		'weight' => isset( $attributes['postMeta']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['postMeta']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['postMeta']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['postMeta']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['postMeta']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['postMeta']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['postMeta']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['postMeta']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['postMeta']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['postMeta']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['postMeta']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['postMeta']['letterSpacing'] ) : '',
	'featured'       => isset( $attributes['postMeta']['color']['featured'] ) ? esc_attr( $attributes['postMeta']['color']['featured'] ) : '',
	'featured_hover' => isset( $attributes['postMeta']['color']['featuredHover'] ) ? esc_attr( $attributes['postMeta']['color']['featuredHover'] ) : '',
	'text'           => isset( $attributes['postMeta']['color']['text'] ) ? esc_attr( $attributes['postMeta']['color']['text'] ) : '',
	'text_hover'     => isset( $attributes['postMeta']['color']['textHover'] ) ? esc_attr( $attributes['postMeta']['color']['textHover'] ) : '',
);

$read_more = array(
	'align'          => isset( $attributes['readMore']['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['readMore']['textAlign'] ) ) : '',
	'padding'        => isset( $attributes['readMore']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['readMore']['padding'] ) : '',
	'margin'         => isset( $attributes['readMore']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['readMore']['margin'] ) : '',
	'border'         => isset( $attributes['readMore']['border'] ) ? cozy_render_TRBL( 'border', $attributes['readMore']['border'] ) : '',
	'radius'         => isset( $attributes['readMore']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['readMore']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['readMore']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['readMore']['font']['size'] ) : '',
		'weight' => isset( $attributes['readMore']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['readMore']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['readMore']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['readMore']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['readMore']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['readMore']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['readMore']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['readMore']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['readMore']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['readMore']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['readMore']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['readMore']['letterSpacing'] ) : '',
	'text'           => isset( $attributes['readMore']['color']['text'] ) ? esc_attr( $attributes['readMore']['color']['text'] ) : '',
	'text_hover'     => isset( $attributes['readMore']['color']['textHover'] ) ? esc_attr( $attributes['readMore']['color']['textHover'] ) : '',
	'bg'             => isset( $attributes['readMore']['color']['bg'] ) ? esc_attr( $attributes['readMore']['color']['bg'] ) : '',
	'bg_hover'       => isset( $attributes['readMore']['color']['bgHover'] ) ? esc_attr( $attributes['readMore']['color']['bgHover'] ) : '',
	'border_hover'   => isset( $attributes['readMore']['color']['borderHover'] ) ? esc_attr( $attributes['readMore']['color']['borderHover'] ) : '',
);

$ajax_loader = array(
	'align'             => isset( $attributes['ajaxLoader']['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxLoader']['textAlign'] ) ) : '',
	'padding'           => isset( $attributes['ajaxLoader']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['ajaxLoader']['padding'] ) : '',
	'margin'            => isset( $attributes['ajaxLoader']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['ajaxLoader']['margin'] ) : '',
	'border'            => isset( $attributes['ajaxLoader']['border'] ) ? cozy_render_TRBL( 'border', $attributes['ajaxLoader']['border'] ) : '',
	'radius'            => isset( $attributes['ajaxLoader']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['ajaxLoader']['radius'] ) : '',
	'min_width'         => isset( $attributes['ajaxLoader']['minWidth'] ) ? cozy_addons_sanitize_dimension( $attributes['ajaxLoader']['minWidth'] ) : '',
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

$post_content = array(
	'padding' => cozy_render_TRBL( 'padding', $attributes['postOptions']['content']['padding'] ),
);

$column1 = $attributes['postOptions']['column'] <= 3 ? $attributes['postOptions']['column'] : 3;
$column2 = $attributes['postOptions']['column'] <= 2 ? $attributes['postOptions']['column'] : 2;

$block_styles = "
#$block_id .cozy-block-magazine-grid__header {
    {$header_box['padding']}
    {$header_box['margin']}
    {$header_box['border']}
    border-radius: {$header_box['radius']};
    background-color: {$header_box['bg']};
    gap: {$header_box['gap']};
	justify-content: {$header_box['tab_align']};
}

#$block_id .cozy-block-magazine-grid__heading {
    {$heading['padding']}
    {$heading['border']}
    {$heading['radius']}
    font-size: clamp(14px, 1.185rem + ((1vw - 3.2px) * 0.673), {$heading['font']['size']});
    font-weight: {$heading['font']['weight']};
    font-family: {$heading['font']['family']};
	text-transform: {$heading['letter_case']};
	text-decoration: {$heading['decoration']};
	line-height: {$heading['line_height']};
	letter-spacing: {$heading['letter_spacing']};
    background-color: {$heading['bg']};
    color: {$heading['text']};
	clip-path: {$heading['clip_path']};
}

#$block_id .cozy-block-magazine-grid__sub-heading {
    {$sub_heading['padding']}
    {$sub_heading['border']}
	border-radius: {$sub_heading['radius']};
    font-size: {$sub_heading['font']['size']};
    font-weight: {$sub_heading['font']['weight']};
    font-family: {$sub_heading['font']['family']};
	text-transform: {$sub_heading['letter_case']};
    text-decoration: {$sub_heading['decoration']};
    line-height: {$sub_heading['line_height']};
    letter-spacing: {$sub_heading['letter_spacing']};
    background-color: {$sub_heading['bg']};
}
#$block_id .cozy-block-magazine-grid__sub-heading, #$block_id .cozy-block-magazine-grid__sub-heading a {
	color: {$sub_heading['text']};
}
#$block_id .cozy-block-magazine-grid__sub-heading:hover { 
	background-color: {$sub_heading['bg_hover']};
	border-color: {$sub_heading['border_hover']};
}
#$block_id .cozy-block-magazine-grid__sub-heading:hover, #$block_id .cozy-block-magazine-grid__sub-heading:hover a {
	color: {$sub_heading['text_hover']};
}

#$block_id .cozy-block-magazine-grid__body.has-featured-post {
	column-gap: {$featured_styles['col_gap']};
}
@media only screen and (max-width: 767px) {
	#$block_id .cozy-block-magazine-grid__body.has-featured-post {
		row-gap: {$featured_styles['row_gap']};
	}
}

#$block_id .featured-post__image {
	{$featured_image['margin']}
	max-height: {$featured_image['height']};
	border-radius: {$featured_image['radius']};
}
#$block_id .featured-post__image img {
	height: {$featured_image['height']};
	border-radius: {$featured_image['radius']};
}
#$block_id .featured-post__content-overlay-wrapper {
	padding-top: {$featured_content['wrapper']['vgap']};
	padding-right: {$featured_content['wrapper']['hgap']};
	padding-bottom: {$featured_content['wrapper']['vgap']};
	padding-left: {$featured_content['wrapper']['hgap']};
	margin-top: {$featured_content['margin']['top']}px;
	margin-bottom: {$featured_content['margin']['bottom']};
}
#$block_id .featured-post__content-wrapper {
	{$featured_content['padding']}
	{$featured_content['border']}
	border-radius: {$featured_content['radius']};
	position: {$featured_content['position']};
	text-align: {$featured_content['align']};
	background-color: {$featured_content['bg']};
}

#$block_id .featured-post__category-item.post__category-item {
	{$featured_cat['border']}
	border-radius: {$featured_cat['radius']};
	font-size: {$featured_cat['font']['size']};
	font-weight: {$featured_cat['font']['weight']};
	font-family: {$featured_cat['font']['family']};
	text-transform: {$featured_cat['letter_case']};
	text-decoration: {$featured_cat['decoration']};
	line-height: {$featured_cat['line_height']};
	letter-spacing: {$featured_cat['letter_spacing']};
	color: {$featured_cat['color']['text']};
	background-color: {$featured_cat['color']['bg']};
}
#$block_id .featured-post__category-item.post__category-item:hover {
	color: {$featured_cat['color']['text_hover']};
	background-color: {$featured_cat['color']['bg_hover']};
	border-color: {$featured_cat['color']['border_hover']};
}

#$block_id .featured-post__title {
	{$featured_title['margin']}
	font-size: 	clamp(12px, 1.185rem + ((1vw - 3.2px) * 0.673), {$featured_title['font']['size']});
	font-weight: {$featured_title['font']['weight']};
	font-family: {$featured_title['font']['family']};
	text-transform: {$featured_title['letter_case']};
	line-height: {$featured_title['line_height']};
	letter-spacing: {$featured_title['letter_spacing']};
}
#$block_id .featured-post__title a {
	text-decoration: {$featured_title['decoration']};
	color: {$featured_title['color']};
}
#$block_id .featured-post__title:hover a {
	color: {$featured_title['color_hover']};
}

#$block_id .featured-post__meta.post__meta {
	justify-content: {$featured_content['align']};
}
#$block_id .featured-post__meta.post__meta .display-flex {
	color: {$post_meta['featured']};
}
#$block_id .featured-post__meta.post__meta svg {
	fill: {$post_meta['featured']};
}
#$block_id .featured-post__meta.post__meta .display-flex:hover p {
	color: {$post_meta['featured_hover']};
}
#$block_id .featured-post__meta.post__meta .display-flex:hover svg {
	fill: {$post_meta['featured_hover']};
}

#$block_id .featured-post__content .post__read-more-link {
	{$featured_read_more['border']}
	border-radius: {$featured_read_more['radius']};
	font-size: {$featured_read_more['font']['size']};
	font-weight: {$featured_read_more['font']['weight']};
	font-family: {$featured_read_more['font']['family']};
	text-transform: {$featured_read_more['letter_case']};
	text-decoration: {$featured_read_more['decoration']};
	line-height: {$featured_read_more['line_height']};
	letter-spacing: {$featured_read_more['letter_spacing']};
	color: {$featured_read_more['color']['text']};
	background-color: {$featured_read_more['color']['bg']};
}
#$block_id .featured-post__content .post__read-more-link:hover {
	color: {$featured_read_more['color']['text_hover']};
	background-color: {$featured_read_more['color']['bg_hover']};
	border-color: {$featured_read_more['color']['border_hover']};
}

#$block_id .cozy-block-magazine-grid__posts {
	text-align: {$post_styles['align']};
}
#$block_id .cozy-block-magazine-grid__posts:not(.has-masonry) {
	grid-template-columns: repeat({$post_styles['column']}, 1fr);
	gap: {$post_styles['gap']};
}
#$block_id .cozy-block-magazine-grid__posts.has-masonry {
	column-count: {$post_styles['column']};
	column-gap: {$post_styles['gap']};
}
#$block_id .cozy-block-magazine-grid__posts.has-masonry .cozy-block-magazine-grid__post-item {
	margin-bottom: {$post_styles['gap']};
}
@media only screen and (max-width: 1024px) {
	#$block_id .cozy-block-magazine-grid__posts:not(.has-masonry) {
		grid-template-columns: repeat({$column1}, 1fr) !important;
	}
	#$block_id .cozy-block-magazine-grid__posts.has-masonry {
		column-count: {$column1} !important;
	}
}
@media only screen and (max-width: 767px) {
	#$block_id .cozy-block-magazine-grid__posts:not(.has-masonry) {
		grid-template-columns: repeat({$column2}, 1fr) !important;
	}
	#$block_id .cozy-block-magazine-grid__posts.has-masonry {
		column-count: {$column2} !important;
	}
}
@media only screen and (max-width: 420px) {
	#$block_id .cozy-block-magazine-grid__posts:not(.has-masonry) {
		grid-template-columns: repeat(1, 1fr) !important;
	}
	#$block_id .cozy-block-magazine-grid__posts.has-masonry {
		column-count: 1 !important;
	}
}

#$block_id .cozy-block-magazine-grid__post-item {
	{$post_item['padding']}
	{$post_item['margin']}
	{$post_item['border']}
	border-radius: {$post_item['radius']};
	background-color: {$post_item['bg']};
}
#$block_id .has-invert-layout .cozy-block-magazine-grid__post-item {
	gap: {$post_item['content_gap']};
	row-gap: {$post_item['row_gap']};
}
#$block_id .cozy-block-magazine-grid__post-item.has-box-shadow {
	box-shadow: {$post_item['shadow']['horizontal']}px {$post_item['shadow']['vertical']}px {$post_item['shadow']['blur']}px {$post_item['shadow']['spread']}px {$post_item['shadow']['color']} {$post_item['shadow']['position']}; 
}
#$block_id .cozy-block-magazine-grid__post-item:hover {
	background-color: {$post_item['bg_hover']};
	border-color: {$post_item['border_hover']};
}
#$block_id .cozy-block-magazine-grid__post-item.has-hover-box-shadow:hover {
	box-shadow: {$post_item['shadow_hover']['horizontal']}px {$post_item['shadow_hover']['vertical']}px {$post_item['shadow_hover']['blur']}px {$post_item['shadow_hover']['spread']}px {$post_item['shadow_hover']['color']} {$post_item['shadow_hover']['position']}; 
}

#$block_id .post__image {
	{$post_image['margin']}
	max-height: {$post_image['height']};
	border-radius: {$post_image['radius']};
}
#$block_id .cozy-block-magazine-grid__posts:not(.has-invert-layout) .post__image {
	max-width: {$post_image['width']};
}
#$block_id .cozy-block-magazine-grid__posts.has-invert-layout .post__image {
	min-width: {$post_image['width']};
	max-width: {$post_image['width']};
}
#$block_id .post__image img {
	height: {$post_image['height']};
	border-radius: {$post_image['radius']};
}
@media only screen and (max-width: 1024px) {
	#$block_id .cozy-block-magazine-grid__posts.has-invert-layout .post__image {
		max-width: 100%;
	}

	#$block_id .feature-post__image img {
		max-height: {$post_image['height']};
	}

	#$block_id .post__image img {
		max-height: {$post_image['height']};
	}
}

#$block_id .post__content-wrapper {
	{$post_content['padding']}
}

#$block_id .featured-post__categories.post__categories {
	justify-content: {$featured_content['align']};
}
#$block_id .post__categories {
	gap: {$cat_item['gap']};
	{$cat_item['margin']}
	justify-content: {$post_styles['align']};
}
#$block_id .post__category-item {
	{$cat_item['padding']}
	{$cat_item['border']}
	border-radius: {$cat_item['radius']};
	font-size: {$cat_item['font']['size']};
	font-weight: {$cat_item['font']['weight']};
	font-family: {$cat_item['font']['family']};
	text-transform: {$cat_item['letter_case']};
	text-decoration: {$cat_item['decoration']};
	line-height: {$cat_item['line_height']};
	letter-spacing: {$cat_item['letter_spacing']};
	color: {$cat_item['text']};
	background-color: {$cat_item['bg']};
}
#$block_id .post__category-item:hover {
	color: {$cat_item['text_hover']};
	background-color: {$cat_item['bg_hover']};
	border-color: {$cat_item['border_hover']};
}

#$block_id .post__title {
	{$post_title['margin']};
	font-size: 	clamp(10px, 1.185rem + ((1vw - 3.2px) * 0.673), {$post_title['font']['size']});
	font-weight: {$post_title['font']['weight']};
	font-family: {$post_title['font']['family']};
	text-transform: {$post_title['letter_case']};
	line-height: {$post_title['line_height']};
	letter-spacing: {$post_title['letter_spacing']};
}
#$block_id .post__title a {
	text-decoration: {$post_title['decoration']};
	color: {$post_title['color']};
}
#$block_id .post__title:hover a {
	color: {$post_title['color_hover']};
}

#$block_id .post__meta {
	{$post_meta['margin']};
	justify-content: {$post_styles['align']};
	font-size: {$post_meta['font']['size']};
	font-weight: {$post_meta['font']['weight']};
	font-family: {$post_meta['font']['family']};
	text-transform: {$post_meta['letter_case']};
	line-height: {$post_meta['line_height']};
	letter_spacing: {$post_meta['letter_spacing']};
}
#$block_id .post__meta a {
	text-decoration: {$post_meta['decoration']};
}
#$block_id .post__meta .display-flex {
	color: {$post_meta['text']};
}
#$block_id .post__meta svg {
	fill: {$post_meta['text']};
}
#$block_id .post__meta .display-flex:hover p {
	color: {$post_meta['text_hover']};
}
#$block_id .post__meta .display-flex:hover svg {
	fill: {$post_meta['text_hover']};
}

#$block_id .post__read-more {
	{$read_more['margin']}
	text-align: {$read_more['align']};
}
#$block_id .post__read-more-link {
	{$read_more['padding']}
	{$read_more['border']}
	border-radius: {$read_more['radius']};
	font-size: {$read_more['font']['size']};
	font-weight: {$read_more['font']['weight']};
	font-family: {$read_more['font']['family']};
	text-transform: {$read_more['letter_case']};
	text-decoration: {$read_more['decoration']};
	line-height: {$read_more['line_height']};
	letter-spacing: {$read_more['letter_spacing']};
	color: {$read_more['text']};
	background-color: {$read_more['bg']};
}
#$block_id .post__read-more-link:hover {
	color: {$read_more['text_hover']};
	background-color: {$read_more['bg_hover']};
	border-color: {$read_more['border_hover']};
}

#$block_id .cozy-block-magazine-grid__ajax-loader-wrapper {
	{$ajax_loader['margin']}
	text-align: {$ajax_loader['align']};
}
#$block_id .cozy-block-magazine-grid__ajax-loader, #$block_id .scroll-spinner.has-loading-text {
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
	min-width: {$ajax_loader['min_width']};
}
#$block_id .cozy-block-magazine-grid__ajax-loader:hover {
	color: {$ajax_loader['text_hover']};
	background-color: {$ajax_loader['bg_hover']};
	border-color: {$ajax_loader['border_hover']};
}
#$block_id .cozy-block-magazine-grid__ajax-loader .spinner,
#$block_id .scroll-spinner {
	border-color: {$ajax_loader['spinner_secondary']};
	border-top-color: {$ajax_loader['spinner_primary']};
}
";

$valid_tags = array(
	'h1',
	'h2',
	'h3',
	'h4',
	'h5',
	'h6',
	'div',
	'p',
	'span',
);

$classes   = array();
$classes[] = 'cozy-block-magazine-grid';
$classes[] = ! $attributes['featuredPostOptions']['enabled'] && $attributes['ajaxLoader']['enabled'] && 'scroll' === $attributes['ajaxLoader']['type'] ? 'has-infinite-scroll' : '';

$output = '<div class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '" id="' . esc_attr( $block_id ) . '">';

if ( $attributes['enableOptions']['heading'] || $attributes['enableOptions']['subHeading'] ) {
	$output .= '<article class="cozy-block-magazine-grid__header">';
	if ( $attributes['enableOptions']['heading'] ) {
		$heading_tag = isset( $attributes['headingTag'] ) && in_array( $attributes['headingTag'], $valid_tags, true ) ? $attributes['headingTag'] : 'p';
		$output     .= sprintf( '<%1$s class="cozy-block-magazine-grid__heading">%2$s</%1$s>', esc_attr( $heading_tag ), $attributes['headingLabel'] );
	}
	if ( $attributes['enableOptions']['subHeading'] ) {
		$subheading_tag = isset( $attributes['subHeading']['tag'] ) && in_array( $attributes['subHeading']['tag'], $valid_tags, true ) ? $attributes['subHeading']['tag'] : 'p';
		$output        .= sprintf( '<%1$s class="cozy-block-magazine-grid__sub-heading">%2$s</%1$s>', esc_attr( $subheading_tag ), $attributes['subHeading']['label'] );
	}
	$output .= '</article>';
}

/* Fetch Posts */
if ( ! function_exists( 'get_cozy_block_magazine_grid_posts' ) ) {
	function get_cozy_block_magazine_grid_posts( $cozy_block_magazine_grid_args = array() ) {
		if ( ! empty( $cozy_block_magazine_grid_args ) ) {
			$latest_posts         = new \WP_Query( $cozy_block_magazine_grid_args );
			$additional_post_data = array();
			foreach ( $latest_posts->posts as $post ) {
				$post_id        = $post->ID;
				$post_image_url = get_the_post_thumbnail_url( $post_id );
				$post_link      = get_permalink( $post_id );

				$post_data                   = (array) $post; // Convert WP_Post object to an array.
				$post_data['post_image_url'] = $post_image_url;

				// Get categories and their links.
				$categories      = get_the_category( $post_id );
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

				$post_data['post_author_name']    = get_the_author_meta( 'display_name', $post->post_author ) ?? '';
				$post_data['post_author_url']     = get_author_posts_url( $post->post_author ) ?? '';
				$post_data['post_link']           = $post_link;
				$post_data['post_date_formatted'] = get_the_date( '', $post_id );
				$post_data['comment_link']        = get_comments_link( $post_id );
				$additional_post_data[]           = $post_data;
			}

			wp_reset_postdata();

			return $additional_post_data;
		}

		return array();
	}
}
/* Fetch Featured Post */
if ( ! function_exists( 'get_cozy_block_magazine_grid_featured_post' ) ) {
	function get_cozy_block_magazine_grid_featured_post( $post_id ) {
		$post_data            = get_post( $post_id );
		$additional_post_data = array();

		$post_image_url = get_the_post_thumbnail_url( $post_id );
		$post_link      = get_permalink( $post_id );

		$post_data                   = (array) $post_data; // Convert WP_Post object to an array.
		$post_data['post_image_url'] = $post_image_url;

		// Get categories and their links.
		$categories      = get_the_category( $post_id );
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

		$post_data['post_author_name']    = get_the_author_meta( 'display_name', $post_data['post_author'] ) ?? '';
		$post_data['post_author_url']     = get_author_posts_url( $post_data['post_author'] ) ?? '';
		$post_data['post_link']           = $post_link;
		$post_data['post_date_formatted'] = get_the_date( '', $post_id );
		$post_data['comment_link']        = get_comments_link( $post_id );
		$additional_post_data[]           = $post_data;

		wp_reset_postdata();

		return $additional_post_data;
	}
}

/* Posts Render */
if ( ! function_exists( 'render_cozy_block_magazine_grid_posts_data' ) ) {
	function render_cozy_block_magazine_grid_posts_data( $attributes, $post_data, &$output ) {
		$classes   = array();
		$classes[] = 'cozy-block-magazine-grid__post-item';
		$classes[] = $attributes['postBoxStyles']['hoverEffect'] ? 'has-hover-effect' : '';
		$classes[] = $attributes['postBoxStyles']['shadow']['enabled'] ? 'has-box-shadow' : '';
		$classes[] = $attributes['postBoxStyles']['shadowHover']['enabled'] ? 'has-hover-box-shadow' : '';
		$classes[] = $attributes['postOptions']['imageOverlay'] ? 'has-image-overlay' : '';
		$output   .= '<li class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '" data-post-id="' . esc_attr( $post_data['ID'] ) . '">';

		if ( $attributes['enableOptions']['postImage'] && ! empty( $post_data['post_image_url'] ) ) {
			$classes       = array();
			$classes[]     = 'post__image';
			$classes[]     = $attributes['postOptions']['image']['hoverEffect'] ? 'has-hover-effect' : '';
			$has_post_link = isset( $attributes['enableOptions']['imgLinkPost'] ) && $attributes['enableOptions']['imgLinkPost'] ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
			$open_new_tab  = isset( $attributes['enableOptions']['imgLinkPost'], $attributes['enableOptions']['imgLinkNewTab'] ) && $attributes['enableOptions']['imgLinkPost'] && $attributes['enableOptions']['imgLinkNewTab'] ? '_blank' : '';
			$output       .= '<figure class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener"><img src="' . esc_url( $post_data['post_image_url'] ) . '" /></a></figure>';
		}

		$output .= '<div class="post__content-wrapper">';

		if ( $attributes['enableOptions']['postCategories'] && ! empty( $post_data['post_categories'] ) ) {
			$output   .= '<div class="post__categories">';
			$classes   = array();
			$classes[] = 'post__category-item';
			$classes[] = $attributes['postCategories']['hoverEffect'] ? 'has-hover-effect' : '';

			$open_new_tab = isset( $attributes['enableOptions']['linkCat'], $attributes['enableOptions']['catNewTab'] ) && $attributes['enableOptions']['linkCat'] && $attributes['enableOptions']['catNewTab'] ? '_blank' : '';
			foreach ( $post_data['post_categories'] as $cat_data ) {
				$has_cat_link = isset( $attributes['enableOptions']['linkCat'] ) && $attributes['enableOptions']['linkCat'] ? 'href="' . esc_url( $cat_data['link'] ) . '"' : '';
				$output      .= '<a class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '" ' . $has_cat_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $cat_data['name'] ) . '</a>';
			}
			$output .= '</div>';
		}

		$has_post_link      = isset( $attributes['enableOptions']['titleLinkPost'] ) && $attributes['enableOptions']['titleLinkPost'] ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
		$open_new_tab       = isset( $attributes['enableOptions']['titleLinkPost'], $attributes['enableOptions']['titleLinkNewTab'] ) && $attributes['enableOptions']['titleLinkPost'] && $attributes['enableOptions']['titleLinkNewTab'] ? '_blank' : '';
		$classes            = array();
		$classes[]          = 'post__title';
		$additional_classes = isset( $attributes['postOptions']['title']['className'] ) ? $attributes['postOptions']['title']['className'] : '';
		if ( ! empty( $additional_classes ) ) {
			$classes = array_merge( $classes, explode( ' ', $additional_classes ) );
		}
		$output .= '<h4 class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $post_data['post_title'] ) . '</a></h4>';

		if ( $attributes['enableOptions']['postAuthor'] || $attributes['enableOptions']['postComments'] || $attributes['enableOptions']['postDate'] ) {
			$output .= '<div class="post__meta">';

			$has_meta_link = isset( $attributes['enableOptions']['linkPostMeta'] ) && $attributes['enableOptions']['linkPostMeta'] ? true : false;
			$open_new_tab  = isset( $attributes['enableOptions']['linkPostMeta'], $attributes['enableOptions']['postMetaNewTab'] ) && $attributes['enableOptions']['linkPostMeta'] && $attributes['enableOptions']['postMetaNewTab'] ? '_blank' : '';
			$show_icon     = isset( $attributes['enableOptions']['enableMetaIcon'] ) && $attributes['enableOptions']['enableMetaIcon'] ? true : false;
			if ( $attributes['enableOptions']['postAuthor'] ) {
				$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_author_url'] ) . '"' : '';
				$output   .= '<a class="post__author display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
				if ( $show_icon ) {
					$output .= '<svg
										width="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										height="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										xmlns="http://www.w3.org/2000/svg"
										aria-hidden="true"
										viewBox="0 0 12 15"
									>
										<path d="M11.2972 14.6667H0.630493V13.3333C0.630493 12.4493 0.981683 11.6014 1.6068 10.9763C2.23193 10.3512 3.07977 10 3.96383 10H7.96383C8.84788 10 9.69573 10.3512 10.3208 10.9763C10.946 11.6014 11.2972 12.4493 11.2972 13.3333V14.6667ZM5.96383 8.66667C5.43854 8.66667 4.9184 8.5632 4.43309 8.36218C3.94779 8.16117 3.50683 7.86653 3.1354 7.49509C2.76396 7.12366 2.46933 6.6827 2.26831 6.1974C2.06729 5.7121 1.96383 5.19195 1.96383 4.66667C1.96383 4.14138 2.06729 3.62124 2.26831 3.13593C2.46933 2.65063 2.76396 2.20967 3.1354 1.83824C3.50683 1.4668 3.94779 1.17217 4.43309 0.971148C4.9184 0.770129 5.43854 0.666666 5.96383 0.666666C7.02469 0.666666 8.04211 1.08809 8.79225 1.83824C9.5424 2.58838 9.96383 3.6058 9.96383 4.66667C9.96383 5.72753 9.5424 6.74495 8.79225 7.49509C8.04211 8.24524 7.02469 8.66667 5.96383 8.66667Z" />
									</svg>';
				}

				$output .= '<p>' . esc_html( $post_data['post_author_name'] ) . '</p>';
				$output .= '</a>';
			}

			if ( $attributes['enableOptions']['postComments'] && intval( $post_data['comment_count'] ) > 0 ) {
				$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['comment_link'] ) . '"' : '';
				$output   .= '<a class="post__comments display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
				if ( $show_icon ) {
					$output .= '<svg
										width="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										height="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										xmlns="http://www.w3.org/2000/svg"
										aria-hidden="true"
										viewBox="0 0 25 20"
									>
										<path d="M18.0556 6.94444C18.0556 3.10764 14.0148 0 9.02778 0C4.0408 0 0 3.10764 0 6.94444C0 8.43316 0.611979 9.80469 1.64931 10.9375C1.06771 12.2483 0.108507 13.2899 0.0954861 13.3029C0 13.4028 -0.0260417 13.5503 0.0303819 13.6806C0.0868056 13.8108 0.208333 13.8889 0.347222 13.8889C1.93576 13.8889 3.25087 13.355 4.19705 12.8038C5.59462 13.4852 7.24826 13.8889 9.02778 13.8889C14.0148 13.8889 18.0556 10.7812 18.0556 6.94444ZM23.3507 16.4931C24.388 15.3646 25 13.9887 25 12.5C25 9.59635 22.678 7.10937 19.388 6.07205C19.4271 6.35851 19.4444 6.6493 19.4444 6.94444C19.4444 11.5408 14.77 15.2778 9.02778 15.2778C8.55903 15.2778 8.1033 15.2431 7.65191 15.1953C9.0191 17.691 12.2309 19.4444 15.9722 19.4444C17.7517 19.4444 19.4054 19.0451 20.8029 18.3594C21.7491 18.9106 23.0642 19.4444 24.6528 19.4444C24.7917 19.4444 24.9175 19.362 24.9696 19.2361C25.026 19.1102 25 18.9627 24.9045 18.8585C24.8915 18.8455 23.9323 17.8082 23.3507 16.4931Z" />
									</svg>';
				}

				$output .= '<p>' . esc_html( $post_data['comment_count'] ) . '</p>';
				$output .= '</a>';
			}

			if ( $attributes['enableOptions']['postDate'] ) {
				$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
				$output   .= '<a class="post__date display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
				if ( $show_icon ) {
					$output .= '<svg
										width="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										height="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 16 18"
										aria-hidden="true"
									>
										<path d="M7.66699 10.6666C7.43088 10.6666 7.23296 10.5868 7.07324 10.427C6.91352 10.2673 6.83366 10.0694 6.83366 9.83329C6.83366 9.59718 6.91352 9.39927 7.07324 9.23954C7.23296 9.07982 7.43088 8.99996 7.66699 8.99996C7.9031 8.99996 8.10102 9.07982 8.26074 9.23954C8.42046 9.39927 8.50033 9.59718 8.50033 9.83329C8.50033 10.0694 8.42046 10.2673 8.26074 10.427C8.10102 10.5868 7.9031 10.6666 7.66699 10.6666ZM4.33366 10.6666C4.09755 10.6666 3.89963 10.5868 3.73991 10.427C3.58019 10.2673 3.50033 10.0694 3.50033 9.83329C3.50033 9.59718 3.58019 9.39927 3.73991 9.23954C3.89963 9.07982 4.09755 8.99996 4.33366 8.99996C4.56977 8.99996 4.76769 9.07982 4.92741 9.23954C5.08713 9.39927 5.16699 9.59718 5.16699 9.83329C5.16699 10.0694 5.08713 10.2673 4.92741 10.427C4.76769 10.5868 4.56977 10.6666 4.33366 10.6666ZM11.0003 10.6666C10.7642 10.6666 10.5663 10.5868 10.4066 10.427C10.2469 10.2673 10.167 10.0694 10.167 9.83329C10.167 9.59718 10.2469 9.39927 10.4066 9.23954C10.5663 9.07982 10.7642 8.99996 11.0003 8.99996C11.2364 8.99996 11.4344 9.07982 11.5941 9.23954C11.7538 9.39927 11.8337 9.59718 11.8337 9.83329C11.8337 10.0694 11.7538 10.2673 11.5941 10.427C11.4344 10.5868 11.2364 10.6666 11.0003 10.6666ZM7.66699 14C7.43088 14 7.23296 13.9201 7.07324 13.7604C6.91352 13.6007 6.83366 13.4027 6.83366 13.1666C6.83366 12.9305 6.91352 12.7326 7.07324 12.5729C7.23296 12.4132 7.43088 12.3333 7.66699 12.3333C7.9031 12.3333 8.10102 12.4132 8.26074 12.5729C8.42046 12.7326 8.50033 12.9305 8.50033 13.1666C8.50033 13.4027 8.42046 13.6007 8.26074 13.7604C8.10102 13.9201 7.9031 14 7.66699 14ZM4.33366 14C4.09755 14 3.89963 13.9201 3.73991 13.7604C3.58019 13.6007 3.50033 13.4027 3.50033 13.1666C3.50033 12.9305 3.58019 12.7326 3.73991 12.5729C3.89963 12.4132 4.09755 12.3333 4.33366 12.3333C4.56977 12.3333 4.76769 12.4132 4.92741 12.5729C5.08713 12.7326 5.16699 12.9305 5.16699 13.1666C5.16699 13.4027 5.08713 13.6007 4.92741 13.7604C4.76769 13.9201 4.56977 14 4.33366 14ZM11.0003 14C10.7642 14 10.5663 13.9201 10.4066 13.7604C10.2469 13.6007 10.167 13.4027 10.167 13.1666C10.167 12.9305 10.2469 12.7326 10.4066 12.5729C10.5663 12.4132 10.7642 12.3333 11.0003 12.3333C11.2364 12.3333 11.4344 12.4132 11.5941 12.5729C11.7538 12.7326 11.8337 12.9305 11.8337 13.1666C11.8337 13.4027 11.7538 13.6007 11.5941 13.7604C11.4344 13.9201 11.2364 14 11.0003 14ZM1.83366 17.3333C1.37533 17.3333 0.982964 17.1701 0.656576 16.8437C0.330187 16.5173 0.166992 16.125 0.166992 15.6666V3.99996C0.166992 3.54163 0.330187 3.14926 0.656576 2.82288C0.982964 2.49649 1.37533 2.33329 1.83366 2.33329H2.66699V0.666626H4.33366V2.33329H11.0003V0.666626H12.667V2.33329H13.5003C13.9587 2.33329 14.351 2.49649 14.6774 2.82288C15.0038 3.14926 15.167 3.54163 15.167 3.99996V15.6666C15.167 16.125 15.0038 16.5173 14.6774 16.8437C14.351 17.1701 13.9587 17.3333 13.5003 17.3333H1.83366ZM1.83366 15.6666H13.5003V7.33329H1.83366V15.6666Z" />
									</svg>';
				}

				$output .= '<p>' . esc_html( $post_data['post_date_formatted'] ) . '</p>';
				$output .= '</a>';
			}

			$output .= '</div>';
		}

		if ( $attributes['enableOptions']['postContent'] ) {
			$output .= '<div class="post__content">';
			$output .= '<div>';

			if ( isset( $post_data['post_excerpt'] ) && ! empty( $post_data['post_excerpt'] ) ) {
				$output .= cozy_create_excerpt( $post_data['post_excerpt'], $attributes['enableOptions']['postExcerpt'] );
			} else {
				$output .= cozy_create_excerpt( $post_data['post_content'], $attributes['enableOptions']['postExcerpt'] );
			}

			$output .= '</div>';

			if ( isset( $attributes['enableOptions']['contentVariation'] ) && 'excerpt' === $attributes['enableOptions']['contentVariation'] && $attributes['enableOptions']['readMore'] ) {
				$open_new_tab = isset( $attributes['enableOptions']['readMoreNewTab'] ) && $attributes['enableOptions']['readMoreNewTab'] ? '_blank' : '';
				$output      .= '<span class="post__read-more"><a class="post__read-more-link" href="' . esc_url( $post_data['post_link'] ) . '" target="' . $open_new_tab . '" rel="noopener">' . esc_html__( 'Read More', 'cozy-addons' ) . '</a></span>';
			}
			$output .= '</div>';
		}

		$output .= '</div>';

		$output .= '</li>';
	}
}
/* Featured Post Render */
if ( ! function_exists( 'render_cozy_block_magazine_grid_featured_data' ) ) {
	function render_cozy_block_magazine_grid_featured_data( $attributes, $post_data, &$output ) {
		if ( ! empty( $post_data ) ) {
			$output   .= '<div class="cozy-block-magazine-grid__featured-post-wrapper">';
			$classes   = array();
			$classes[] = 'cozy-block-magazine-grid__featured-post';
			$classes[] = $attributes['featuredPostOptions']['imageOverlay'] ? 'has-image-overlay' : '';
			$classes[] = $attributes['featuredPostOptions']['sticky'] ? 'is-sticky' : '';
			$output   .= '<div class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '">';

			if ( $attributes['enableOptions']['postImage'] && ! empty( $post_data['post_image_url'] ) ) {
				$classes       = array();
				$classes[]     = 'featured-post__image';
				$classes[]     = $attributes['postOptions']['image']['hoverEffect'] ? 'has-hover-effect' : '';
				$has_post_link = isset( $attributes['enableOptions']['imgLinkPost'] ) && $attributes['enableOptions']['imgLinkPost'] ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
				$open_new_tab  = isset( $attributes['enableOptions']['imgLinkPost'], $attributes['enableOptions']['imgLinkNewTab'] ) && $attributes['enableOptions']['imgLinkPost'] && $attributes['enableOptions']['imgLinkNewTab'] ? '_blank' : '';
				$output       .= '<figure class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener"><img src="' . esc_url( $post_data['post_image_url'] ) . '" /></a></figure>';
			}

			$output .= '<div class="featured-post__content-overlay-wrapper">';
			$output .= '<div class="featured-post__content-wrapper">';
			if ( isset( $attributes['enableOptions']['featuredPostCategories'] ) && $attributes['enableOptions']['featuredPostCategories'] && ! empty( $post_data['post_categories'] ) ) {
				$output   .= '<div class="featured-post__categories post__categories">';
				$classes   = array();
				$classes[] = 'featured-post__category-item';
				$classes[] = 'post__category-item';
				$classes[] = $attributes['postCategories']['hoverEffect'] ? 'has-hover-effect' : '';

				$open_new_tab = isset( $attributes['enableOptions']['linkCat'], $attributes['enableOptions']['catNewTab'] ) && $attributes['enableOptions']['linkCat'] && $attributes['enableOptions']['catNewTab'] ? '_blank' : '';
				foreach ( $post_data['post_categories'] as $cat_data ) {
					$has_cat_link = isset( $attributes['enableOptions']['linkCat'] ) && $attributes['enableOptions']['linkCat'] ? 'href="' . esc_url( $cat_data['link'] ) . '"' : '';
					$output      .= '<a class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '" ' . $has_cat_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $cat_data['name'] ) . '</a>';
				}
				$output .= '</div>';
			}

			$has_post_link      = isset( $attributes['enableOptions']['titleLinkPost'] ) && $attributes['enableOptions']['titleLinkPost'] ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
			$open_new_tab       = isset( $attributes['enableOptions']['titleLinkPost'], $attributes['enableOptions']['titleLinkNewTab'] ) && $attributes['enableOptions']['titleLinkPost'] && $attributes['enableOptions']['titleLinkNewTab'] ? '_blank' : '';
			$classes            = array();
			$classes[]          = 'featured-post__title';
			$additional_classes = isset( $attributes['featuredPostOptions']['title']['className'] ) ? $attributes['featuredPostOptions']['title']['className'] : '';
			if ( ! empty( $additional_classes ) ) {
				$classes = array_merge( $classes, explode( ' ', $additional_classes ) );
			}
			$output .= '<h4 class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $post_data['post_title'] ) . '</a></h4>';

			if ( ( isset( $attributes['enableOptions']['featuredPostAuthor'] ) && $attributes['enableOptions']['featuredPostAuthor'] ) || ( isset( $attributes['enableOptions']['featuredPostComments'] ) && $attributes['enableOptions']['featuredPostComments'] ) || ( isset( $attributes['enableOptions']['featuredPostDate'] ) && $attributes['enableOptions']['featuredPostDate'] ) ) {
				$output       .= '<div class="featured-post__meta post__meta">';
				$has_meta_link = isset( $attributes['enableOptions']['linkPostMeta'] ) && $attributes['enableOptions']['linkPostMeta'] ? true : false;
				$open_new_tab  = isset( $attributes['enableOptions']['linkPostMeta'], $attributes['enableOptions']['postMetaNewTab'] ) && $attributes['enableOptions']['linkPostMeta'] && $attributes['enableOptions']['postMetaNewTab'] ? '_blank' : '';
				$show_icon     = isset( $attributes['enableOptions']['enableFeaturedMetaIcon'] ) && $attributes['enableOptions']['enableFeaturedMetaIcon'] ? true : false;

				if ( isset( $attributes['enableOptions']['featuredPostAuthor'] ) && $attributes['enableOptions']['featuredPostAuthor'] ) {
					$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_author_url'] ) . '"' : '';
					$output   .= '<a class="featured-post__author display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
					if ( $show_icon ) {
						$output .= '<svg
										width="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										height="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										xmlns="http://www.w3.org/2000/svg"
										aria-hidden="true"
										viewBox="0 0 12 15"
									>
										<path d="M11.2972 14.6667H0.630493V13.3333C0.630493 12.4493 0.981683 11.6014 1.6068 10.9763C2.23193 10.3512 3.07977 10 3.96383 10H7.96383C8.84788 10 9.69573 10.3512 10.3208 10.9763C10.946 11.6014 11.2972 12.4493 11.2972 13.3333V14.6667ZM5.96383 8.66667C5.43854 8.66667 4.9184 8.5632 4.43309 8.36218C3.94779 8.16117 3.50683 7.86653 3.1354 7.49509C2.76396 7.12366 2.46933 6.6827 2.26831 6.1974C2.06729 5.7121 1.96383 5.19195 1.96383 4.66667C1.96383 4.14138 2.06729 3.62124 2.26831 3.13593C2.46933 2.65063 2.76396 2.20967 3.1354 1.83824C3.50683 1.4668 3.94779 1.17217 4.43309 0.971148C4.9184 0.770129 5.43854 0.666666 5.96383 0.666666C7.02469 0.666666 8.04211 1.08809 8.79225 1.83824C9.5424 2.58838 9.96383 3.6058 9.96383 4.66667C9.96383 5.72753 9.5424 6.74495 8.79225 7.49509C8.04211 8.24524 7.02469 8.66667 5.96383 8.66667Z" />
									</svg>';
					}

					$output .= '<p>' . esc_html( $post_data['post_author_name'] ) . '</p>';
					$output .= '</a>';
				}

				if ( isset( $attributes['enableOptions']['featuredPostComments'] ) && $attributes['enableOptions']['featuredPostComments'] && intval( $post_data['comment_count'] ) > 0 ) {
					$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['comment_link'] ) . '"' : '';
					$output   .= '<a class="featured-post__comments display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
					if ( $show_icon ) {
						$output .= '<svg
										width="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										height="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										xmlns="http://www.w3.org/2000/svg"
										aria-hidden="true"
										viewBox="0 0 25 20"
									>
										<path d="M18.0556 6.94444C18.0556 3.10764 14.0148 0 9.02778 0C4.0408 0 0 3.10764 0 6.94444C0 8.43316 0.611979 9.80469 1.64931 10.9375C1.06771 12.2483 0.108507 13.2899 0.0954861 13.3029C0 13.4028 -0.0260417 13.5503 0.0303819 13.6806C0.0868056 13.8108 0.208333 13.8889 0.347222 13.8889C1.93576 13.8889 3.25087 13.355 4.19705 12.8038C5.59462 13.4852 7.24826 13.8889 9.02778 13.8889C14.0148 13.8889 18.0556 10.7812 18.0556 6.94444ZM23.3507 16.4931C24.388 15.3646 25 13.9887 25 12.5C25 9.59635 22.678 7.10937 19.388 6.07205C19.4271 6.35851 19.4444 6.6493 19.4444 6.94444C19.4444 11.5408 14.77 15.2778 9.02778 15.2778C8.55903 15.2778 8.1033 15.2431 7.65191 15.1953C9.0191 17.691 12.2309 19.4444 15.9722 19.4444C17.7517 19.4444 19.4054 19.0451 20.8029 18.3594C21.7491 18.9106 23.0642 19.4444 24.6528 19.4444C24.7917 19.4444 24.9175 19.362 24.9696 19.2361C25.026 19.1102 25 18.9627 24.9045 18.8585C24.8915 18.8455 23.9323 17.8082 23.3507 16.4931Z" />
									</svg>';
					}

					$output .= '<p>' . esc_html( $post_data['comment_count'] ) . '</p>';
					$output .= '</a>';
				}

				if ( isset( $attributes['enableOptions']['featuredPostDate'] ) && $attributes['enableOptions']['featuredPostDate'] ) {
					$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
					$output   .= '<a class="featured-post__date display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
					if ( $show_icon ) {
						$output .= '<svg
										width="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										height="' . cozy_addons_sanitize_dimension( $attributes['postMeta']['font']['size'] ) . '"
										xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 16 18"
										aria-hidden="true"
									>
										<path d="M7.66699 10.6666C7.43088 10.6666 7.23296 10.5868 7.07324 10.427C6.91352 10.2673 6.83366 10.0694 6.83366 9.83329C6.83366 9.59718 6.91352 9.39927 7.07324 9.23954C7.23296 9.07982 7.43088 8.99996 7.66699 8.99996C7.9031 8.99996 8.10102 9.07982 8.26074 9.23954C8.42046 9.39927 8.50033 9.59718 8.50033 9.83329C8.50033 10.0694 8.42046 10.2673 8.26074 10.427C8.10102 10.5868 7.9031 10.6666 7.66699 10.6666ZM4.33366 10.6666C4.09755 10.6666 3.89963 10.5868 3.73991 10.427C3.58019 10.2673 3.50033 10.0694 3.50033 9.83329C3.50033 9.59718 3.58019 9.39927 3.73991 9.23954C3.89963 9.07982 4.09755 8.99996 4.33366 8.99996C4.56977 8.99996 4.76769 9.07982 4.92741 9.23954C5.08713 9.39927 5.16699 9.59718 5.16699 9.83329C5.16699 10.0694 5.08713 10.2673 4.92741 10.427C4.76769 10.5868 4.56977 10.6666 4.33366 10.6666ZM11.0003 10.6666C10.7642 10.6666 10.5663 10.5868 10.4066 10.427C10.2469 10.2673 10.167 10.0694 10.167 9.83329C10.167 9.59718 10.2469 9.39927 10.4066 9.23954C10.5663 9.07982 10.7642 8.99996 11.0003 8.99996C11.2364 8.99996 11.4344 9.07982 11.5941 9.23954C11.7538 9.39927 11.8337 9.59718 11.8337 9.83329C11.8337 10.0694 11.7538 10.2673 11.5941 10.427C11.4344 10.5868 11.2364 10.6666 11.0003 10.6666ZM7.66699 14C7.43088 14 7.23296 13.9201 7.07324 13.7604C6.91352 13.6007 6.83366 13.4027 6.83366 13.1666C6.83366 12.9305 6.91352 12.7326 7.07324 12.5729C7.23296 12.4132 7.43088 12.3333 7.66699 12.3333C7.9031 12.3333 8.10102 12.4132 8.26074 12.5729C8.42046 12.7326 8.50033 12.9305 8.50033 13.1666C8.50033 13.4027 8.42046 13.6007 8.26074 13.7604C8.10102 13.9201 7.9031 14 7.66699 14ZM4.33366 14C4.09755 14 3.89963 13.9201 3.73991 13.7604C3.58019 13.6007 3.50033 13.4027 3.50033 13.1666C3.50033 12.9305 3.58019 12.7326 3.73991 12.5729C3.89963 12.4132 4.09755 12.3333 4.33366 12.3333C4.56977 12.3333 4.76769 12.4132 4.92741 12.5729C5.08713 12.7326 5.16699 12.9305 5.16699 13.1666C5.16699 13.4027 5.08713 13.6007 4.92741 13.7604C4.76769 13.9201 4.56977 14 4.33366 14ZM11.0003 14C10.7642 14 10.5663 13.9201 10.4066 13.7604C10.2469 13.6007 10.167 13.4027 10.167 13.1666C10.167 12.9305 10.2469 12.7326 10.4066 12.5729C10.5663 12.4132 10.7642 12.3333 11.0003 12.3333C11.2364 12.3333 11.4344 12.4132 11.5941 12.5729C11.7538 12.7326 11.8337 12.9305 11.8337 13.1666C11.8337 13.4027 11.7538 13.6007 11.5941 13.7604C11.4344 13.9201 11.2364 14 11.0003 14ZM1.83366 17.3333C1.37533 17.3333 0.982964 17.1701 0.656576 16.8437C0.330187 16.5173 0.166992 16.125 0.166992 15.6666V3.99996C0.166992 3.54163 0.330187 3.14926 0.656576 2.82288C0.982964 2.49649 1.37533 2.33329 1.83366 2.33329H2.66699V0.666626H4.33366V2.33329H11.0003V0.666626H12.667V2.33329H13.5003C13.9587 2.33329 14.351 2.49649 14.6774 2.82288C15.0038 3.14926 15.167 3.54163 15.167 3.99996V15.6666C15.167 16.125 15.0038 16.5173 14.6774 16.8437C14.351 17.1701 13.9587 17.3333 13.5003 17.3333H1.83366ZM1.83366 15.6666H13.5003V7.33329H1.83366V15.6666Z" />
									</svg>';
					}

					$output .= '<p>' . esc_html( $post_data['post_date_formatted'] ) . '</p>';
					$output .= '</a>';
				}

				$output .= '</div>';
			}

			if ( isset( $attributes['enableOptions']['featuredPostContent'] ) && $attributes['enableOptions']['featuredPostContent'] ) {
				$output .= '<div class="featured-post__content">';
				$output .= '<div>';

				if ( isset( $post_data['post_excerpt'] ) && ! empty( $post_data['post_excerpt'] ) ) {
					$output .= cozy_create_excerpt( $post_data['post_excerpt'], $attributes['enableOptions']['postExcerpt'] );
				} else {
					$output .= cozy_create_excerpt( $post_data['post_content'], $attributes['enableOptions']['featuredPostExcerpt'] );
				}

				$output .= '</div>';
				if ( isset( $attributes['enableOptions']['featuredContentVariation'] ) && 'excerpt' === $attributes['enableOptions']['featuredContentVariation'] && isset( $attributes['enableOptions']['featuredReadMore'] ) && $attributes['enableOptions']['featuredReadMore'] ) {
					$open_new_tab = isset( $attributes['enableOptions']['readMoreNewTab'] ) && $attributes['enableOptions']['readMoreNewTab'] ? '_blank' : '';
					$output      .= '<span class="post__read-more"><a class="post__read-more-link" href="' . $post_data['post_link'] . '" target="_blank" rel="noopener">' . esc_html__( 'Read More', 'cozy-addons' ) . '</a></span>';
				}
				$output .= '</div>';
			}

			$output .= '</div>';
			$output .= '</div>';

			$output .= '</div>';
			$output .= '</div>';
		}
	}
}

$featured_post_id              = isset( $attributes['featuredPostOptions']['postID'] ) ? $attributes['featuredPostOptions']['postID'] : '';
$featured_post_enabled         = $attributes['featuredPostOptions']['enabled'] ? array( $featured_post_id ) : array();
$selected_category             = 'category' === $attributes['sortBy'] && isset( $attributes['selectedCategory'] ) ? array( $attributes['selectedCategory'] ) : array();
$cozy_block_magazine_grid_args = array(
	'post_type'           => 'post',
	'orderby'             => 'date',
	'order'               => 'DESC',
	'posts_per_page'      => $attributes['perPage'],
	'ignore_sticky_posts' => $attributes['enableOptions']['ignoreSticky'],
	'category__in'        => $selected_category,
	'post__not_in'        => array(),
	'post_status'         => 'publish',
);

$featured_post_data = array();

if ( $attributes['featuredPostOptions']['enabled'] ) {
	if ( 'default' === $attributes['featuredPostOptions']['source'] ) {
		$latest_args = array(
			'post_type'      => 'post',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => 1,
			'category__in'   => $selected_category,
			'post_status'    => 'publish',
		);
		$latest_post = get_cozy_block_magazine_grid_posts( $latest_args );
		if ( is_array( $latest_post ) && ! empty( $latest_post ) ) {
			$cozy_block_magazine_grid_args['post__not_in'] = array( $latest_post[0]['ID'] );
			$featured_post_data                            = $latest_post[0];
		}
	} else {
		$featured_post_data = get_cozy_block_magazine_grid_featured_post( $featured_post_id );
		if ( is_array( $featured_post_data ) ) {
			$cozy_block_magazine_grid_args['post__not_in'] = array( $featured_post_data[0]['ID'] );
			$featured_post_data                            = array_shift( $featured_post_data );
		}
	}
}

$excluded_post_ids = isset( $attributes['exclude'] ) ? explode( ',', sanitize_text_field( $attributes['exclude'] ) ) : array();
if ( is_array( $excluded_post_ids ) && ! empty( $excluded_post_ids ) ) {
	$cozy_block_magazine_grid_args['post__not_in'] = array_merge( $cozy_block_magazine_grid_args['post__not_in'], $excluded_post_ids );
}

if ( isset( $attributes['offset'] ) && ! empty( $attributes['offset'] ) ) {
	$cozy_block_magazine_grid_args['offset'] = $attributes['offset'];

	$offset_args     = array(
		'post_type'           => 'post',
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => $attributes['enableOptions']['ignoreSticky'],
		'category__in'        => $selected_category,
		'fields'              => 'ids',
		'posts_per_page'      => $attributes['offset'],
		'post_status'         => 'publish',
	);
	$offset_post_ids = get_posts( $offset_args );


	$attributes['exclude'] = $attributes['exclude'] . ',' . implode( ',', $offset_post_ids );
}

$additional_post_data = get_cozy_block_magazine_grid_posts( $cozy_block_magazine_grid_args );

$classes   = array();
$classes[] = 'cozy-block-magazine-grid__body';
$classes[] = $attributes['featuredPostOptions']['enabled'] ? 'has-featured-post' : '';
$output   .= '<div class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '">';
if ( $attributes['featuredPostOptions']['enabled'] && 'left' === $attributes['featuredPostOptions']['position'] ) {
	render_cozy_block_magazine_grid_featured_data( $attributes, $featured_post_data, $output );
}

if ( ! empty( $additional_post_data ) ) {
	$classes   = array();
	$classes[] = 'cozy-block-magazine-grid__posts';
	$classes[] = $attributes['postOptions']['invert'] ? 'has-invert-layout' : '';
	$classes[] = $attributes['postOptions']['masonry'] ? 'has-masonry' : '';
	$output   .= '<ul class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '">';
	foreach ( $additional_post_data as $key => $post_data ) {
		render_cozy_block_magazine_grid_posts_data( $attributes, $post_data, $output );
	}
	$output .= '</ul>';
}

if ( $attributes['featuredPostOptions']['enabled'] && 'right' === $attributes['featuredPostOptions']['position'] ) {
	render_cozy_block_magazine_grid_featured_data( $attributes, $featured_post_data, $output );
}
$output .= '</div>'; /* cozy-block-magazine-grid__body <<closing>> */
wp_reset_postdata();

if ( ! $attributes['featuredPostOptions']['enabled'] && $attributes['ajaxLoader']['enabled'] ) {
	if ( 'default' === $attributes['ajaxLoader']['type'] ) {
		$cozy_block_magazine_grid_args['posts_per_page'] = -1;
		$all_posts                                       = get_cozy_block_magazine_grid_posts( $cozy_block_magazine_grid_args );

		$remaining_posts = array_udiff(
			$all_posts,
			$additional_post_data,
			function ( $a, $b ) {
				return $a['ID'] - $b['ID'];
			}
		);

		$classes   = array();
		$classes[] = 'cozy-block-magazine-grid__ajax-loader';
		$classes[] = empty( $remaining_posts ) ? 'display-none' : '';
		$output   .= '<div class="cozy-block-magazine-grid__ajax-loader-wrapper">';
		$output   .= '<button class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '">';
		$output   .= '<span>' . esc_html( $attributes['ajaxLoader']['label'] ) . '</span>';

		$classes   = array();
		$classes[] = 'spinner';
		$classes[] = isset( $attributes['ajaxLoader']['loadingText'] ) && ! empty( $attributes['ajaxLoader']['loadingText'] ) ? 'has-loading-text' : '';
		$output   .= '<div class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '">';
		$output   .= esc_html( $attributes['ajaxLoader']['loadingText'] );
		$output   .= '<span class="cozy-block-magazine-grid__dots"></span>';
		$output   .= '</div>';

		$output .= '</button>';
		$output .= '</div>';
	}

	if ( 'scroll' === $attributes['ajaxLoader']['type'] ) {
		$output   .= '<div style="text-align: center;">';
		$classes   = array();
		$classes[] = 'scroll-spinner';
		$classes[] = 'display-none';
		$classes[] = isset( $attributes['ajaxLoader']['loadingText'] ) && ! empty( $attributes['ajaxLoader']['loadingText'] ) ? 'has-loading-text' : '';
		$output   .= '<div class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '">';
		if ( isset( $attributes['ajaxLoader']['loadingText'] ) && ! empty( $attributes['ajaxLoader']['loadingText'] ) ) {
			$output .= esc_html( $attributes['ajaxLoader']['loadingText'] );
			$output .= '<span class="cozy-block-magazine-grid__dots"></span>';
		}
		$output .= '</div>';
		$output .= '</div>';
	}
}

$output .= '</div>';

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$wrapper_attributes = get_block_wrapper_attributes();

$font_families = array();

if ( isset( $attributes['headingStyles']['font']['family'] ) && ! empty( $attributes['headingStyles']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['headingStyles']['font']['family'] );
}
if ( isset( $attributes['subHeading']['font']['family'] ) && ! empty( $attributes['subHeading']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['subHeading']['font']['family'] );
}
if ( isset( $attributes['featuredPostCategories']['font']['family'] ) && ! empty( $attributes['featuredPostCategories']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['featuredPostCategories']['font']['family'] );
}
if ( isset( $attributes['postCategories']['font']['family'] ) && ! empty( $attributes['postCategories']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['postCategories']['font']['family'] );
}
if ( isset( $attributes['featuredPostOptions']['title']['font']['family'] ) && ! empty( $attributes['featuredPostOptions']['title']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['featuredPostOptions']['title']['font']['family'] );
}
if ( isset( $attributes['postOptions']['title']['font']['family'] ) && ! empty( $attributes['postOptions']['title']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['postOptions']['title']['font']['family'] );
}
if ( isset( $attributes['postMeta']['font']['family'] ) && ! empty( $attributes['postMeta']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['postMeta']['font']['family'] );
}
if ( isset( $attributes['featuredReadMore']['font']['family'] ) && ! empty( $attributes['featuredReadMore']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['featuredReadMore']['font']['family'] );
}
if ( isset( $attributes['readMore']['font']['family'] ) && ! empty( $attributes['readMore']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['readMore']['font']['family'] );
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

$attributes['ajaxUrl'] = admin_url( 'admin-ajax.php' );
$attributes['nonce']   = wp_create_nonce( 'cozy_block_magazine_grid_load_more' );
wp_localize_script( 'cozy-block--magazine-grid--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--magazine-grid--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockMagazineGrid( "' . esc_html( $client_id ) . '" ) }) ' );

$render = sprintf( '<div class="cozy-block-wrapper"><div %1$s>%2$s</div></div>', $wrapper_attributes, $output );
echo $render;
