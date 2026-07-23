<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['blockClientId'] ) ) : '';
$cozy_block_var = 'cozyFeaturedContentBox_' . str_replace( '-', '_', $client_id );

$attributes['isPremium'] = cozy_addons_premium_access();

wp_localize_script( 'cozy-block--featured-content-box--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--featured-content-box--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockFeaturedContentBoxInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$width1 = $attributes['gridOptions']['columnCount'] <= 3 ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['columnCount'] ) : 3;
$width2 = $attributes['gridOptions']['columnCount'] <= 2 ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['columnCount'] ) : 2;

$styles = array(
	'margin' => array(
		'top'    => isset( $attributes['margin']['top'] ) ? esc_attr( $attributes['margin']['top'] ) : '',
		'right'  => isset( $attributes['margin']['right'] ) ? esc_attr( $attributes['margin']['right'] ) : '',
		'bottom' => isset( $attributes['margin']['bottom'] ) ? esc_attr( $attributes['margin']['bottom'] ) : '',
		'left'   => isset( $attributes['margin']['left'] ) ? esc_attr( $attributes['margin']['left'] ) : '',
	),
	'column' => isset( $attributes['gridOptions']['columnCount'] ) ? esc_attr( $attributes['gridOptions']['columnCount'] ) : '',
	'gap'    => isset( $attributes['gridOptions']['gap'] ) ? esc_attr( $attributes['gridOptions']['gap'] ) : '',
);

$stack_img = array(
	'bottom' => isset( $attributes['stackedImage']['verticalPosition'] ) ? esc_attr( $attributes['stackedImage']['verticalPosition'] ) : '',
);

$gallery       = array(
	'opacity' => isset( $attributes['galleryOptions']['overlayOpacity'] ) ? esc_attr( $attributes['galleryOptions']['overlayOpacity'] ) : '',
);
$gallery_color = array(
	'bg' => isset( $attributes['galleryOptions']['overlayColorHover'] ) ? $attributes['galleryOptions']['overlayColorHover'] : '',
);

$nav_styles = array(
	'box_width'  => isset( $attributes['navigation']['iconBoxWidth'] ) ? esc_attr( $attributes['navigation']['iconBoxWidth'] ) : '',
	'box_height' => isset( $attributes['navigation']['iconBoxHeight'] ) ? esc_attr( $attributes['navigation']['iconBoxHeight'] ) : '',
	'size'       => isset( $attributes['navigation']['iconSize'] ) ? esc_attr( $attributes['navigation']['iconSize'] ) : '',
	'border'     => isset( $attributes['navigation']['border'] ) ? cozy_render_TRBL( 'border', $attributes['navigation']['border'] ) : '',
	'radius'     => isset( $attributes['navigation']['borderRadius'] ) ? esc_attr( $attributes['navigation']['borderRadius'] ) : '',
);
$nav_color  = array(
	'icon'         => isset( $attributes['navigation']['color'] ) ? esc_attr( $attributes['navigation']['color'] ) : '',
	'bg'           => isset( $attributes['navigation']['backgroundColor'] ) ? esc_attr( $attributes['navigation']['backgroundColor'] ) : '',
	'icon_hover'   => isset( $attributes['navigation']['colorHover'] ) ? esc_attr( $attributes['navigation']['colorHover'] ) : '',
	'bg_hover'     => isset( $attributes['navigation']['backgroundColorHover'] ) ? esc_attr( $attributes['navigation']['backgroundColorHover'] ) : '',
	'border_hover' => isset( $attributes['navigation']['borderHover'] ) ? esc_attr( $attributes['navigation']['borderHover'] ) : '',
);

$bullet       = array(
	'bottom'        => isset( $attributes['pagination']['verticalPosition'] ) ? esc_attr( $attributes['pagination']['verticalPosition'] ) : '',
	'align'         => isset( $attributes['pagination']['align'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['align'] ) ) : 'center',
	'left'          => isset( $attributes['pagination']['align'], $attributes['pagination']['left'] ) && 'left' === $attributes['pagination']['align'] ? 'padding-left: ' . esc_attr( $attributes['pagination']['left'] ) . ';' : '',
	'right'         => isset( $attributes['pagination']['align'], $attributes['pagination']['right'] ) && 'right' === $attributes['pagination']['align'] ? 'padding-right: ' . esc_attr( $attributes['pagination']['right'] ) . ';' : '',
	'gap'           => isset( $attributes['pagination']['gap'] ) ? esc_attr( $attributes['pagination']['gap'] ) : 4,
	'width'         => isset( $attributes['pagination']['width'] ) ? esc_attr( $attributes['pagination']['width'] ) : '',
	'height'        => isset( $attributes['pagination']['height'] ) ? esc_attr( $attributes['pagination']['height'] ) : '',
	'radius'        => isset( $attributes['pagination']['borderRadius'] ) ? esc_attr( $attributes['pagination']['borderRadius'] ) : '',
	'active_width'  => isset( $attributes['pagination']['activeWidth'] ) ? esc_attr( $attributes['pagination']['activeWidth'] ) : 10,
	'active_height' => isset( $attributes['pagination']['activeHeight'] ) ? esc_attr( $attributes['pagination']['activeHeight'] ) : 10,
	'active_border' => isset( $attributes['pagination']['activeBorder'] ) ? cozy_render_TRBL( 'outline', $attributes['pagination']['activeBorder'] ) : '',
	'active_offset' => isset( $attributes['pagination']['activeOffset'] ) ? esc_attr( $attributes['pagination']['activeOffset'] ) : 'center',
	'active_radius' => isset( $attributes['pagination']['activeBorderRadius'] ) ? esc_attr( $attributes['pagination']['activeBorderRadius'] ) : '',
);
$bullet_color = array(
	'bg'                  => isset( $attributes['pagination']['color'] ) ? esc_attr( $attributes['pagination']['color'] ) : '',
	'active_bg'           => isset( $attributes['pagination']['activeColor'] ) ? esc_attr( $attributes['pagination']['activeColor'] ) : '',
	'bg_hover'            => isset( $attributes['pagination']['colorHover'] ) ? esc_attr( $attributes['pagination']['colorHover'] ) : '',
	'active_bg_hover'     => isset( $attributes['pagination']['activeColorHover'] ) ? esc_attr( $attributes['pagination']['activeColorHover'] ) : '',
	'active_border_hover' => isset( $attributes['pagination']['activeBorderHover'] ) ? esc_attr( $attributes['pagination']['activeBorderHover'] ) : '',
);

$block_styles = "
#$block_id {
    margin-top: {$styles['margin']['top']}px;
    margin-right: {$styles['margin']['right']}px;
    margin-bottom: {$styles['margin']['bottom']}px;
    margin-left: {$styles['margin']['left']}px;
}

#$block_id.display-grid .cozy-grid-wrapper {
    gap: {$styles['gap']}px;
}
#$block_id.display-grid:not(.has-masonry) .cozy-grid-wrapper {
    grid-template-columns: repeat({$styles['column']}, 1fr);
}
#$block_id.display-grid.has-masonry .cozy-grid-wrapper {
    column-count: {$styles['column']};
}
#$block_id.display-grid.has-masonry .cozy-grid-wrapper .cozy-block-grid:not(:first-child) {
    margin-top: {$styles['gap']}px;
}
@media screen and (max-width: 1024px) {
    #$block_id.display-grid:not(.has-masonry) .cozy-grid-wrapper {
        grid-template-columns: repeat(
            $width1,
            1fr
        ) !important;
    }

    #$block_id.display-grid.has-masonry .cozy-grid-wrapper {
        column-count: $width1 !important;
    }
}

@media screen and (max-width: 767px) {
    #$block_id.display-grid:not(.has-masonry) .cozy-grid-wrapper {
        grid-template-columns: repeat(
            $width2,
            1fr
        ) !important;
    }

    #$block_id.display-grid.has-masonry .cozy-grid-wrapper {
        column-count: $width2 !important;
    }
}

@media screen and (max-width: 568px) {
    #$block_id.display-grid:not(.has-masonry) .cozy-grid-wrapper {
        grid-template-columns: repeat(
            1,
            1fr
        ) !important;
    }

    #$block_id.display-grid.has-masonry .cozy-grid-wrapper {
        column-count: 1 !important;
    }
}

#$block_id.layout-stacked .cozy-stacked-image {
    bottom: {$stack_img['bottom']}px;
}

#$block_id.layout-gallery .cozy-featured-content-box__layout-gallery:hover .wp-block-cover__background {
    background-color: {$gallery_color['bg']} !important;
    opacity: {$gallery['opacity']} !important;
}

#$block_id .swiper-button-prev::after,
#$block_id .swiper-button-next::after {
    font-size: {$nav_styles['size']}px;
}
#$block_id .swiper-button-prev,
#$block_id .swiper-button-next {
    width: {$nav_styles['box_width']}px;
    height: {$nav_styles['box_height']}px;
    {$nav_styles['border']}
    border-radius: {$nav_styles['radius']}px;
    color: {$nav_color['icon']};
    background-color: {$nav_color['bg']};
}
#$block_id .swiper-button-prev:hover,
#$block_id .swiper-button-next:hover {
    color: {$nav_color['icon_hover']};
    background-color: {$nav_color['bg_hover']};
    border-color: {$nav_color['border_hover']};
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
    background-color: {$bullet_color['bg']};
}
#$block_id.swiper-horizontal .swiper-pagination-bullets .swiper-pagination-bullet {
    margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$bullet['gap']}px);
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active {
    width: {$bullet['active_width']}px;
    height: {$bullet['active_height']}px;
    {$bullet['active_border']}
    outline-offset: {$bullet['active_offset']}px;
    border-radius: {$bullet['active_radius']}px;
    background-color: {$bullet_color['active_bg']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet:hover {
    background-color: {$bullet_color['bg_hover']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active:hover {
    background-color: {$bullet_color['active_bg_hover']};
    outline-color: {$bullet_color['active_border_hover']};
}
";

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$classes   = array();
$classes[] = 'cozy-block-wrapper';
$classes[] = cozy_addons_premium_access() && 'carousel' === $attributes['display'] && isset( $attributes['sliderOptions']['smoothTransition'] ) && $attributes['sliderOptions']['smoothTransition'] ? 'swiper__smooth-transition' : '';
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
	<?php echo $content; ?>
</div>