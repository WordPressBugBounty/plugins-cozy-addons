<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozyTestimonial_' . str_replace( '-', '_', $client_id );

$attributes['isPremium'] = cozy_addons_premium_access();

wp_localize_script( 'cozy-block--testimonial--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--testimonial--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockTestimonialInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$width1 = $attributes['gridOptions']['displayColumn'] <= 3 ? esc_attr( $attributes['gridOptions']['displayColumn'] ) : 3;
$width2 = $attributes['gridOptions']['displayColumn'] <= 2 ? esc_attr( $attributes['gridOptions']['displayColumn'] ) : 2;

$styles = array(
	'desktop' => array(
		'padding' => isset( $attributes['styles']['desktop']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['styles']['desktop']['padding'] ) : '',
	),
	'tablet'  => array(
		'padding' => isset( $attributes['styles']['tablet']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['styles']['tablet']['padding'] ) : '',
	),
	'mobile'  => array(
		'padding' => isset( $attributes['styles']['mobile']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['styles']['mobile']['padding'] ) : '',
	),
	'margin'  => isset( $attributes['styles']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['styles']['margin'] ) : '',
);

$item_styles = array(
	'desktop' => array(
		'padding' => isset( $attributes['itemStyles']['desktop']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['itemStyles']['desktop']['padding'] ) : '',
	),
	'tablet'  => array(
		'padding' => isset( $attributes['itemStyles']['tablet']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['itemStyles']['tablet']['padding'] ) : '',
	),
	'mobile'  => array(
		'padding' => isset( $attributes['itemStyles']['mobile']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['itemStyles']['mobile']['padding'] ) : '',
	),
	'margin'  => isset( $attributes['itemStyles']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['itemStyles']['margin'] ) : '',
	'border'  => isset( $attributes['itemStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['itemStyles']['border'] ) : '',
	'radius'  => isset( $attributes['itemStyles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['itemStyles']['radius'] ) : '',
	'align'   => isset( $attributes['itemStyles']['align'] ) ? esc_attr( sanitize_text_field( $attributes['itemStyles']['align'] ) ) : '',
);

$post_img = array(
	'desktop' => array(
		'width'  => isset( $attributes['postImage']['desktop']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['postImage']['desktop']['width'] ) : '',
		'height' => isset( $attributes['postImage']['desktop']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['postImage']['desktop']['height'] ) : '',
	),
	'tablet'  => array(
		'width'  => isset( $attributes['postImage']['tablet']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['postImage']['tablet']['width'] ) : '',
		'height' => isset( $attributes['postImage']['tablet']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['postImage']['tablet']['height'] ) : '',
	),
	'mobile'  => array(
		'width'  => isset( $attributes['postImage']['mobile']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['postImage']['mobile']['width'] ) : '',
		'height' => isset( $attributes['postImage']['mobile']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['postImage']['mobile']['height'] ) : '',
	),
	'margin'  => isset( $attributes['postImage']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['postImage']['margin'] ) : '',
	'border'  => isset( $attributes['postImage']['border'] ) ? cozy_render_TRBL( 'border', $attributes['postImage']['border'] ) : '',
	'radius'  => isset( $attributes['postImage']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['postImage']['radius'] ) : '',
);

$post_title = array(
	'desktop'        => array(
		'font' => array(
			'size' => isset( $attributes['postTitle']['desktop']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['postTitle']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'         => array(
		'font' => array(
			'size' => isset( $attributes['postTitle']['tablet']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['postTitle']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'         => array(
		'font' => array(
			'size' => isset( $attributes['postTitle']['mobile']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['postTitle']['mobile']['font']['size'] ) : '',
		),
	),
	'margin'         => isset( $attributes['postTitle']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['postTitle']['margin'] ) : '',
	'font'           => array(
		'weight' => isset( $attributes['postTitle']['font']['weight'] ) ? cozy_addons_sanitize_dimension( $attributes['postTitle']['font']['weight'] ) : '',
		'family' => isset( $attributes['postTitle']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['postTitle']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['postTitle']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['postTitle']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['postTitle']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['postTitle']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['postTitle']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['postTitle']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['postTitle']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['postTitle']['letterSpacing'] ) : '',
	'color'          => isset( $attributes['postTitle']['color'] ) ? esc_attr( sanitize_text_field( $attributes['postTitle']['color'] ) ) : '',
);

$rating = array(
	'margin' => isset( $attributes['rating']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['rating']['margin'] ) : '',
	'size'   => isset( $attributes['rating']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['rating']['size'] ) : '',
	'color'  => array(
		'primary'   => isset( $attributes['rating']['color']['primary'] ) ? esc_attr( sanitize_text_field( $attributes['rating']['color']['primary'] ) ) : '',
		'secondary' => isset( $attributes['rating']['color']['secondary'] ) ? esc_attr( sanitize_text_field( $attributes['rating']['color']['secondary'] ) ) : '',
	),
);

$author_box = array(
	'desktop'     => array(
		'padding' => isset( $attributes['authorDetailsBox']['desktop']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['authorDetailsBox']['desktop']['padding'] ) : '',
	),
	'tablet'      => array(
		'padding' => isset( $attributes['authorDetailsBox']['tablet']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['authorDetailsBox']['tablet']['padding'] ) : '',
	),
	'mobile'      => array(
		'padding' => isset( $attributes['authorDetailsBox']['mobile']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['authorDetailsBox']['mobile']['padding'] ) : '',
	),
	'margin'      => isset( $attributes['authorDetailsBox']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['authorDetailsBox']['margin'] ) : '',
	'border'      => isset( $attributes['authorDetailsBox']['border'] ) ? cozy_render_TRBL( 'border', $attributes['authorDetailsBox']['border'] ) : '',
	'radius'      => isset( $attributes['authorDetailsBox']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['authorDetailsBox']['radius'] ) : '',
	'gap'         => isset( $attributes['authorDetailsBox']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['authorDetailsBox']['gap'] ) : '',
	'align_items' => isset( $attributes['authorDetailsBox']['alignItems'] ) ? esc_attr( sanitize_text_field( $attributes['authorDetailsBox']['alignItems'] ) ) : '',
);

$author_name = array(
	'desktop'        => array(
		'font' => array(
			'size' => isset( $attributes['authorName']['desktop']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['authorName']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'         => array(
		'font' => array(
			'size' => isset( $attributes['authorName']['tablet']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['authorName']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'         => array(
		'font' => array(
			'size' => isset( $attributes['authorName']['mobile']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['authorName']['mobile']['font']['size'] ) : '',
		),
	),
	'margin'         => isset( $attributes['authorName']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['authorName']['margin'] ) : '',
	'font'           => array(
		'weight' => isset( $attributes['authorName']['font']['weight'] ) ? cozy_addons_sanitize_dimension( $attributes['authorName']['font']['weight'] ) : '',
		'family' => isset( $attributes['authorName']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['authorName']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['authorName']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['authorName']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['authorName']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['authorName']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['authorName']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['authorName']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['authorName']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['authorName']['letterSpacing'] ) : '',
	'color'          => isset( $attributes['authorName']['color'] ) ? esc_attr( sanitize_text_field( $attributes['authorName']['color'] ) ) : '',
);

$author_role = array(
	'desktop'        => array(
		'font' => array(
			'size' => isset( $attributes['authorRole']['desktop']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['authorRole']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'         => array(
		'font' => array(
			'size' => isset( $attributes['authorRole']['tablet']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['authorRole']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'         => array(
		'font' => array(
			'size' => isset( $attributes['authorRole']['mobile']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['authorRole']['mobile']['font']['size'] ) : '',
		),
	),
	'margin'         => isset( $attributes['authorRole']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['authorRole']['margin'] ) : '',
	'font'           => array(
		'weight' => isset( $attributes['authorRole']['font']['weight'] ) ? cozy_addons_sanitize_dimension( $attributes['authorRole']['font']['weight'] ) : '',
		'family' => isset( $attributes['authorRole']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['authorRole']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['authorRole']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['authorRole']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['authorRole']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['authorRole']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['authorRole']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['authorRole']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['authorRole']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['authorRole']['letterSpacing'] ) : '',
	'color'          => isset( $attributes['authorRole']['color'] ) ? esc_attr( sanitize_text_field( $attributes['authorRole']['color'] ) ) : '',
);

$typography = array(
	'desktop'        => array(
		'font' => array(
			'size' => isset( $attributes['typography']['desktop']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['typography']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'         => array(
		'font' => array(
			'size' => isset( $attributes['typography']['tablet']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['typography']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'         => array(
		'font' => array(
			'size' => isset( $attributes['typography']['mobile']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['typography']['mobile']['font']['size'] ) : '',
		),
	),
	'font'           => array(
		'weight' => isset( $attributes['typography']['font']['weight'] ) ? cozy_addons_sanitize_dimension( $attributes['typography']['font']['weight'] ) : '',
		'family' => isset( $attributes['typography']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['typography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['typography']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['typography']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['typography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['typography']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['typography']['letterSpacing'] ) : '',
	'color'          => isset( $attributes['typography']['color'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['color'] ) ) : '',
);

$nav = array(
	'box_width'  => isset( $attributes['carouselOptions']['navigation']['iconBoxWidth'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['navigation']['iconBoxWidth'] ) : '',
	'box_height' => isset( $attributes['carouselOptions']['navigation']['iconBoxHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['navigation']['iconBoxHeight'] ) : '',
	'size'       => isset( $attributes['carouselOptions']['navigation']['iconSize'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['navigation']['iconSize'] ) : '',
	'border'     => array(
		'style' => isset( $attributes['carouselOptions']['navigation']['borderType'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['navigation']['borderType'] ) ) : '',
		'width' => isset( $attributes['carouselOptions']['navigation']['borderWidth'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['navigation']['borderWidth'] ) : '',
		'color' => isset( $attributes['carouselOptions']['navigation']['borderColor'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['navigation']['borderColor'] ) ) : '',
	),
	'radius'     => isset( $attributes['carouselOptions']['navigation']['borderRadius'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['navigation']['borderRadius'] ) : '',
	'color'      => array(
		'icon'         => isset( $attributes['carouselOptions']['navigation']['color'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['navigation']['color'] ) ) : '',
		'icon_hover'   => isset( $attributes['carouselOptions']['navigation']['colorHover'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['navigation']['colorHover'] ) ) : '',
		'bg'           => isset( $attributes['carouselOptions']['navigation']['backgroundColor'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['navigation']['backgroundColor'] ) ) : '',
		'bg_hover'     => isset( $attributes['carouselOptions']['navigation']['backgroundColorHover'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['navigation']['backgroundColorHover'] ) ) : '',
		'border_hover' => isset( $attributes['carouselOptions']['navigation']['borderColorHover'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['navigation']['borderColorHover'] ) ) : '',
	),
);

$bullet_styles = array(
	'gap'    => isset( $attributes['carouselOptions']['pagination']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['pagination']['gap'] ) : 4,
	'width'  => isset( $attributes['carouselOptions']['pagination']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['pagination']['width'] ) : '',
	'height' => isset( $attributes['carouselOptions']['pagination']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['pagination']['height'] ) : '',
	'radius' => isset( $attributes['carouselOptions']['pagination']['borderRadius'] ) ? esc_attr( $attributes['carouselOptions']['pagination']['borderRadius'] ) : '',
	'active' => array(
		'width'  => isset( $attributes['carouselOptions']['pagination']['activeWidth'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['pagination']['activeWidth'] ) : 10,
		'height' => isset( $attributes['carouselOptions']['pagination']['activeHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['pagination']['activeHeight'] ) : 10,
		'border' => isset( $attributes['carouselOptions']['pagination']['activeBorder'] ) ? cozy_render_TRBL( 'outline', $attributes['carouselOptions']['pagination']['activeBorder'] ) : '',
		'offset' => isset( $attributes['carouselOptions']['pagination']['activeOffset'] ) ? esc_attr( $attributes['carouselOptions']['pagination']['activeOffset'] ) : '',
		'radius' => isset( $attributes['carouselOptions']['pagination']['activeBorderRadius'] ) ? esc_attr( $attributes['carouselOptions']['pagination']['activeBorderRadius'] ) : '',
	),
	'align'  => isset( $attributes['carouselOptions']['pagination']['align'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['pagination']['align'] ) ) : '',
	'bottom' => isset( $attributes['carouselOptions']['pagination']['positionVertical'] ) ? cozy_addons_sanitize_dimension( $attributes['carouselOptions']['pagination']['positionVertical'] ) : '',
	'left'   => isset( $attributes['carouselOptions']['pagination']['align'], $attributes['carouselOptions']['pagination']['left'] ) && 'left' === $attributes['carouselOptions']['pagination']['align'] ? 'padding-left:' . cozy_addons_sanitize_dimension( $attributes['carouselOptions']['pagination']['left'] ) . ';' : '',
	'right'  => isset( $attributes['carouselOptions']['pagination']['align'], $attributes['carouselOptions']['pagination']['right'] ) && 'right' === $attributes['carouselOptions']['pagination']['align'] ? 'padding-right:' . cozy_addons_sanitize_dimension( $attributes['carouselOptions']['pagination']['right'] ) . ';' : '',
	'color'  => array(
		'default'       => isset( $attributes['carouselOptions']['pagination']['color'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['pagination']['color'] ) ) : '',
		'default_hover' => isset( $attributes['carouselOptions']['pagination']['colorHover'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['pagination']['colorHover'] ) ) : '',
		'active_color'  => isset( $attributes['carouselOptions']['pagination']['activeColor'] ) ? esc_attr( sanitize_text_field( $attributes['carouselOptions']['pagination']['activeColor'] ) ) : '',
	),
);

$grid = array(
	'column' => isset( $attributes['gridOptions']['displayColumn'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['displayColumn'] ) : '',
	'gap'    => isset( $attributes['gridOptions']['columnGap'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['columnGap'] ) : '',
);

$block_styles = "
#$block_id {
	{$styles['desktop']['padding']}
	{$styles['margin']}
}
@media (width <= 1024px) {
	#$block_id {
		{$styles['tablet']['padding']}
	}
}
@media (width <= 767px) {
	#$block_id {
		{$styles['mobile']['padding']}
	}
}

#$block_id.display-grid:not(.has-masonry) .cozy-block-grid-wrapper {
	grid-template-columns: repeat({$grid['column']}, 1fr);
	gap: {$grid['gap']}px;
}
#$block_id.display-grid.has-masonry .cozy-block-grid-wrapper {
	column-count: {$grid['column']};
	gap: {$grid['gap']}px;

	& .cozy-block-grid {
		margin-bottom: {$grid['gap']}px;
	}
}

#$block_id.source-cpt {
    font-size: {$typography['desktop']['font']['size']};
    font-weight: {$typography['font']['weight']};
    font-family: {$typography['font']['family']};
    text-transform: {$typography['letter_case']};
    text-decoration: {$typography['decoration']};
    line-height: {$typography['line_height']};
    letter-spacing: {$typography['letter_spacing']};
    color: {$typography['color']};
	text-align: {$item_styles['align']};
}
@media (width <= 1024px) {
    #$block_id.source-cpt {
        font-size: {$typography['tablet']['font']['size']};
    }
}
@media (width <= 767px) {
    #$block_id.source-cpt {
        font-size: {$typography['mobile']['font']['size']};
    }
}

#$block_id.source-cpt .cozy-block-{$attributes['layout']} {
	{$item_styles['desktop']['padding']}
	{$item_styles['margin']}
	{$item_styles['border']}
	border-radius: {$item_styles['radius']};
}
@media (width <= 1024px) {
	#$block_id.source-cpt .cozy-block-{$attributes['layout']} {
		{$item_styles['tablet']['padding']}
	}
}
@media (width <= 767px) {
	#$block_id.source-cpt .cozy-block-{$attributes['layout']} {
		{$item_styles['mobile']['padding']}
	}
}

#$block_id.source-cpt .post-title {
    {$post_title['margin']}
    font-size: {$post_title['desktop']['font']['size']};
    font-weight: {$post_title['font']['weight']};
    font-family: {$post_title['font']['family']};
    text-transform: {$post_title['letter_case']};
    text-decoration: {$post_title['decoration']};
    line-height: {$post_title['line_height']};
    letter-spacing: {$post_title['letter_spacing']};
    color: {$post_title['color']};
}
@media (width <= 1024px) {
    #$block_id.source-cpt .post-title {
        font-size: {$post_title['tablet']['font']['size']};
    }
}
@media (width <= 767px) {
    #$block_id.source-cpt .post-title {
        font-size: {$post_title['mobile']['font']['size']};
    }
}

#$block_id.source-cpt .star-rating {
    {$rating['margin']}
}

#$block_id.source-cpt.testimonials-block-5 .author-box,
#$block_id.source-cpt.testimonials-block-6 .author-box {
	justify-content: {$item_styles['align']};
}
#$block_id.source-cpt .author-box {
	{$author_box['desktop']['padding']}
	{$author_box['margin']}
	{$author_box['border']}
	border-radius: {$author_box['radius']};
	align-items: {$author_box['align_items']};
}
#$block_id.source-cpt .author-details {
	align-items: {$author_box['align_items']};
	justify-content: {$item_styles['align']};
}
@media (width <= 1024px) {
	#$block_id.source-cpt .author-details {
		{$author_box['tablet']['padding']}
	}
}
@media (width <= 767px) {
	#$block_id.source-cpt .author-details {
		{$author_box['mobile']['padding']}
	}
}

#$block_id.source-cpt .author-thumbnail {
    max-width: {$post_img['desktop']['width']};
    max-height: {$post_img['desktop']['height']};
    {$post_img['margin']}

    & img {
        width: {$post_img['desktop']['width']};
        height: {$post_img['desktop']['height']};
        {$post_img['border']}
        border-radius: {$post_img['radius']};
    }
}
@media (width <= 1024px) {
    #$block_id.source-cpt .author-thumbnail {
        max-width: {$post_img['tablet']['width']};
        max-height: {$post_img['tablet']['height']};

        & img {
            width: {$post_img['tablet']['width']};
            height: {$post_img['tablet']['height']};
        }
    }
}
@media (width <= 767px) {
    #$block_id.source-cpt .author-thumbnail {
        max-width: {$post_img['mobile']['width']};
        max-height: {$post_img['mobile']['height']};

        & img {
            width: {$post_img['mobile']['width']};
            height: {$post_img['mobile']['height']};
        }
    }
}

#$block_id.source-cpt .author-name {
    {$author_name['margin']}
    font-size: {$author_name['desktop']['font']['size']};
    font-weight: {$author_name['font']['weight']};
    font-family: {$author_name['font']['family']};
    text-transform: {$author_name['letter_case']};
    text-decoration: {$author_name['decoration']};
    line-height: {$author_name['line_height']};
    letter-spacing: {$author_name['letter_spacing']};
    color: {$author_name['color']};
}
@media (width <= 1024px) {
    #$block_id.source-cpt .author-name {
        font-size: {$author_name['tablet']['font']['size']};
    }
}
@media (width <= 767px) {
    #$block_id.source-cpt .author-name {
        font-size: {$author_name['mobile']['font']['size']};
    }
}

#$block_id.source-cpt .author-role {
    {$author_role['margin']}
    font-size: {$author_role['desktop']['font']['size']};
    font-weight: {$author_role['font']['weight']};
    font-family: {$author_role['font']['family']};
    text-transform: {$author_role['letter_case']};
    text-decoration: {$author_role['decoration']};
    line-height: {$author_role['line_height']};
    letter-spacing: {$author_role['letter_spacing']};
    color: {$author_role['color']};
}
#$block_id.source-cpt .author-details .separator {
    color: {$author_role['color']};
}
@media (width <= 1024px) {
    #$block_id.source-cpt .author-role {
        font-size: {$author_role['tablet']['font']['size']};
    }
}
@media (width <= 767px) {
    #$block_id.source-cpt .author-role {
        font-size: {$author_role['mobile']['font']['size']};
    }
}

@media screen and (max-width: 1024px) {
    #$block_id.display-grid:not(.has-masonry) .cozy-block-grid-wrapper {
        grid-template-columns: repeat(
            $width1,
            1fr
        ) !important;
    }
    #$block_id.display-grid.has-masonry .cozy-block-grid-wrapper {
        column-count: $width1 !important;
    }
}

@media screen and (max-width: 767px) {
    #$block_id.display-grid:not(.has-masonry) .cozy-block-grid-wrapper {
        grid-template-columns: repeat(
            $width2,
            1fr
        ) !important;
    }
    #$block_id.display-grid.has-masonry .cozy-block-grid-wrapper {
        column-count: $width2 !important;
    }
}

@media screen and (max-width: 568px) {
    #$block_id.display-grid:not(.has-masonry) .cozy-block-grid-wrapper {
        grid-template-columns: repeat(
            1,
            1fr
        ) !important;
    }
    #$block_id.display-grid.has-masonry .cozy-block-grid-wrapper {
        column-count: 1 !important;
    }
}

.block-$block_id .swiper-button-prev:after,
.block-$block_id .swiper-button-next:after {
	font-size: {$nav['size']}px;
}
.block-$block_id .swiper-button-prev,
.block-$block_id .swiper-button-next {
	width: {$nav['box_width']}px;
	height: {$nav['box_height']}px;
	border-style: {$nav['border']['style']};
	border-width: {$nav['border']['width']}px;
	border-color: {$nav['border']['color']};
	border-radius: {$nav['radius']}px;
	color: {$nav['color']['icon']};
	background-color: {$nav['color']['bg']};
}
.block-$block_id .swiper-button-prev:hover,
.block-$block_id .swiper-button-next:hover {
	color: {$nav['color']['icon_hover']};
	background-color: {$nav['color']['bg_hover']};
	border-color: {$nav['color']['border_hover']};
}

.block-$block_id .swiper-pagination-bullets .swiper-pagination-bullet {
    margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$bullet_styles['gap']}px);
}
.block-$block_id .swiper-pagination {
	bottom: {$bullet_styles['bottom']}px;
	{$bullet_styles['left']}
	{$bullet_styles['right']}
	text-align: {$bullet_styles['align']};
}
.block-$block_id .swiper-pagination-bullet {
	width: {$bullet_styles['width']}px;
	height: {$bullet_styles['height']}px;
	border-radius: {$bullet_styles['radius']}px;
	background-color: {$bullet_styles['color']['default']};

	&:hover {
		background-color: {$bullet_styles['color']['default_hover']};
	}
}
.block-$block_id .swiper-pagination-bullet-active {
    width: {$bullet_styles['active']['width']}px;
    height: {$bullet_styles['active']['height']}px;
    {$bullet_styles['active']['border']}
    outline-offset: {$bullet_styles['active']['offset']}px;
    border-radius: {$bullet_styles['active']['radius']}px;
	background-color: {$bullet_styles['color']['active_color']};
}
";

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$testimonials = array();

$category = isset( $attributes['query']['category'] ) && is_array( $attributes['query']['category'] ) ? $attributes['query']['category'] : array();
// Dynamic testimonial cpt.
$args = array(
	'post_type'      => 'ca_testimonial',
	'post_status'    => 'publish',
	'posts_per_page' => isset( $attributes['query']['perPage'] ) && ! empty( $attributes['query']['perPage'] ) ? intval( $attributes['query']['perPage'] ) : 5, // To retrieve all sticky posts.
	'order'          => isset( $attributes['query']['order'] ) && ! empty( $attributes['query']['order'] ) ? sanitize_text_field( wp_unslash( $attributes['query']['order'] ) ) : 'DESC',
	'orderby'        => isset( $attributes['query']['orderBy'] ) && ! empty( $attributes['query']['orderBy'] ) ? sanitize_text_field( $attributes['query']['orderBy'] ) : 'date',
);

if ( ! empty( $category ) ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'ca_testimonial_category',
			'field'    => 'term_id',
			'terms'    => $category,
		),
	);
}

$testimonials = get_posts( $args );

wp_reset_postdata();

$avg_rating = 0;

$schema_review_body = array();

if ( cozy_addons_premium_access() && ! empty( $testimonials ) && isset( $attributes['generateSchema'] ) && filter_var( $attributes['generateSchema'], FILTER_VALIDATE_BOOLEAN ) ) {
	foreach ( $testimonials as $testimonial ) {
		$testimonial_rating = floatval( get_post_meta( $testimonial->ID, 'ca_testimonial_rating', true ) );
		$testimonial_name   = get_post_meta( $testimonial->ID, 'ca_testimonial_name', true );
		$testimonial_role   = get_post_meta( $testimonial->ID, 'ca_testimonial_role', true );

		$avg_rating += $testimonial_rating;

		$review_body = array(
			'@type'        => 'Review',
			'reviewRating' => array(
				'@type'       => 'Rating',
				'ratingValue' => $testimonial_rating,
			),
			'author'       => array(
				'@type' => 'Person',
				'name'  => $testimonial_name,
			),
			'reviewBody'   => wp_strip_all_tags( strip_shortcodes( $testimonial->post_content ) ),
		);

		array_push( $schema_review_body, $review_body );
	}

	$avg_rating = $avg_rating / count( $testimonials );
}

if ( cozy_addons_premium_access() && ! empty( $schema_review_body ) ) {
	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'Review',
		'itemReviewed'    => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
		),
		'aggregateRating' => array(
			'@type'       => 'AggregateRating',
			'ratingValue' => $avg_rating,
			'reviewCount' => count( $testimonials ),
		),
		'review'          => $schema_review_body,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>';
}

if ( ! empty( $font_query ) && cozy_addons_premium_access() && isset( $attributes['source'] ) && 'cpt' === $attributes['source'] ) {
	$font_families = array();

	if ( isset( $attributes['postTitle']['font']['family'] ) && ! empty( $attributes['postTitle']['font']['family'] ) ) {
		$font_families[] = sanitize_text_field( $attributes['postTitle']['font']['family'] );
	}

	if ( isset( $attributes['authorName']['font']['family'] ) && ! empty( $attributes['authorName']['font']['family'] ) ) {
		$font_families[] = sanitize_text_field( $attributes['authorName']['font']['family'] );
	}

	if ( isset( $attributes['authorRole']['family'] ) && ! empty( $attributes['authorRole']['family'] ) ) {
		$font_families[] = sanitize_text_field( $attributes['authorRole']['family'] );
	}

	if ( isset( $attributes['typography']['family'] ) && ! empty( $attributes['typography']['family'] ) ) {
		$font_families[] = sanitize_text_field( $attributes['typography']['family'] );
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
	// Generate the inline style for the Google Fonts link.
	$google_fonts_url = 'https://fonts.googleapis.com/css2?' . $font_query . '&display=swap';

	echo '<link rel="stylesheet" href="' . $google_fonts_url . '"/>';
}

$classes   = array();
$classes[] = 'cozy-block-wrapper';
$classes[] = 'cozy-block-testimonial-wrapper';
$classes[] = 'block-' . $block_id;
$classes[] = cozy_addons_premium_access() && 'carousel' === $attributes['layout'] && isset( $attributes['carouselOptions']['sliderOptions']['smoothTransition'] ) && $attributes['carouselOptions']['sliderOptions']['smoothTransition'] ? 'swiper__smooth-transition' : '';
$classes[] = cozy_addons_premium_access() && 'carousel' === $attributes['layout'] && isset( $attributes['carouselOptions']['fadeBg'] ) && filter_var( $attributes['carouselOptions']['fadeBg'], FILTER_VALIDATE_BOOLEAN ) ? 'has-fade-bg' : '';
$classes[] = 'carousel' === $attributes['layout'] && filter_var( $attributes['hoverShow'], FILTER_VALIDATE_BOOLEAN ) ? 'hover-show' : '';
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
	<?php
	if ( ! isset( $attributes['source'] ) || ! cozy_addons_premium_access() || ( isset( $attributes['source'] ) && 'default' === $attributes['source'] ) ) {
		echo $content;
	} elseif ( cozy_addons_premium_access() && isset( $attributes['source'] ) && 'cpt' === $attributes['source'] && ! empty( $testimonials ) ) {
		$classes   = array();
		$classes[] = 'cozy-block-testimonial';
		$classes[] = 'display-' . $attributes['layout'];
		$classes[] = 'grid' === $attributes['layout'] && filter_var( $attributes['gridOptions']['masonryEnabled'], FILTER_VALIDATE_BOOLEAN ) ? 'has-masonry' : '';
		$classes[] = 'carousel' === $attributes['layout'] ? 'swiper-container' : '';
		$classes[] = isset( $attributes['source'] ) && ! empty( $attributes['source'] ) ? 'source-' . $attributes['source'] : '';
		$classes[] = isset( $attributes['display'], $attributes['source'] ) && 'cpt' === $attributes['source'] ? $attributes['display'] : '';
		?>
		<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<?php
				$classes   = array();
				$classes[] = 'cozy-block-' . $attributes['layout'] . '-wrapper';
				$classes[] = 'carousel' === $attributes['layout'] ? 'swiper-wrapper' : '';
			?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php
				echo \CozyAddons\Helpers\BlockRender::generate_cpt_testimonial_layout( $testimonials, $attributes )
				?>
			</div>
		</div>
		<?php
		if ( 'carousel' === $attributes['layout'] ) {
			if ( filter_var( $attributes['carouselOptions']['navigation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
				?>
					<div class="swiper-button-prev cozy-block-button-prev"></div>
					<div class="swiper-button-next cozy-block-button-next"></div>
				<?php
			}
			if ( filter_var( $attributes['carouselOptions']['pagination']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
				?>
					<div class="swiper-pagination cozy-pagination"></div>
				<?php
			}
		}
	}
	?>
</div>

