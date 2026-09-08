<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['clientId'] ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$attributes['isPremium'] = cozy_addons_premium_access();

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

$grid = array(
	'desktop' => array(
		'columns' => isset( $attributes['gridOptions']['desktop']['columns'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['desktop']['columns'] ) : '',
		'gap'     => isset( $attributes['gridOptions']['desktop']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['desktop']['gap'] ) : '',
	),
	'tablet'  => array(
		'columns' => isset( $attributes['gridOptions']['tablet']['columns'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['tablet']['columns'] ) : '',
		'gap'     => isset( $attributes['gridOptions']['tablet']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['tablet']['gap'] ) : '',
	),
	'mobile'  => array(
		'columns' => isset( $attributes['gridOptions']['mobile']['columns'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['mobile']['columns'] ) : '',
		'gap'     => isset( $attributes['gridOptions']['mobile']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['gridOptions']['mobile']['gap'] ) : '',
	),
);

$img_styles = array(
	'grayscale'        => isset( $attributes['imageStyles']['grayScale'] ) ? 'grayscale(' . floatval( cozy_addons_sanitize_dimension( $attributes['imageStyles']['grayScale'] ) ) . ')' : '',
	'brightness'       => isset( $attributes['imageStyles']['brightness'] ) ? 'brightness(' . floatval( cozy_addons_sanitize_dimension( $attributes['imageStyles']['brightness'] ) ) . ')' : '',
	'hover_grayscale'  => isset( $attributes['imageStyles']['hoverGrayScale'] ) ? 'grayscale(' . floatval( cozy_addons_sanitize_dimension( $attributes['imageStyles']['hoverGrayScale'] ) ) . ')' : '',
	'hover_brightness' => isset( $attributes['imageStyles']['hoverBrightness'] ) ? 'brightness(' . floatval( cozy_addons_sanitize_dimension( $attributes['imageStyles']['hoverBrightness'] ) ) . ')' : '',
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

#$block_id .cozy-block-grid-wrapper:not(.has-masonry) {
    grid-template-columns: repeat({$grid['desktop']['columns']}, 1fr);
    gap: {$grid['desktop']['gap']};
}
#$block_id .cozy-block-grid-wrapper.has-masonry {
    column-count: {$grid['desktop']['columns']};
    gap: {$grid['desktop']['gap']};

    & .cozy-block-grid {
        margin-bottom: {$grid['desktop']['gap']};
    }
}
@media (width <= 1024px) {
    #$block_id .cozy-block-grid-wrapper:not(.has-masonry) {
        grid-template-columns: repeat({$grid['tablet']['columns']}, 1fr);
        gap: {$grid['tablet']['gap']};
    }
    #$block_id .cozy-block-grid-wrapper.has-masonry {
        column-count: {$grid['tablet']['columns']};
        gap: {$grid['tablet']['gap']};

        & .cozy-block-grid {
            margin-bottom: {$grid['tablet']['gap']};
        }
    }
}
@media (width <= 767px) {
    #$block_id .cozy-block-grid-wrapper:not(.has-masonry) {
        grid-template-columns: repeat({$grid['mobile']['columns']}, 1fr);
        gap: {$grid['mobile']['gap']};
    }
    #$block_id .cozy-block-grid-wrapper.has-masonry {
        column-count: {$grid['mobile']['columns']};
        gap: {$grid['mobile']['gap']};

        & .cozy-block-grid {
            margin-bottom: {$grid['mobile']['gap']};
        }
    }
}

#$block_id.has-image-filter img {
	filter: {$img_styles['grayscale']} {$img_styles['brightness']};

	&:hover {
		filter: unset;
	}
}
#$block_id.has-image-hover-filter img:hover {
	filter: {$img_styles['hover_grayscale']} {$img_styles['hover_brightness']};
}

.cozy-block-wrapper.block-$block_id .swiper-button-prev::after,
.cozy-block-wrapper.block-$block_id .swiper-button-next::after {
    font-size: {$nav['size']};
}
.cozy-block-wrapper.block-$block_id .swiper-button-prev,
.cozy-block-wrapper.block-$block_id .swiper-button-next {
    width: {$nav['box_width']};
    height: {$nav['box_height']};
    {$nav['border']}
    border-radius: {$nav['radius']};
    color: {$nav['color']['icon']};
    background-color: {$nav['color']['bg']};
}
.cozy-block-wrapper.block-$block_id .swiper-button-prev:hover,
.cozy-block-wrapper.block-$block_id .swiper-button-next:hover {
    color: {$nav['color']['icon_hover']};
    background-color: {$nav['color']['bg_hover']};
    border-color: {$nav['color']['border_hover']};
}

.cozy-block-wrapper.block-$block_id .swiper-pagination {
    bottom: {$bullets['position']};
    text-align: {$bullets['align']};
    padding-left: {$bullets['left']};
    padding-right: {$bullets['right']};
}
.cozy-block-wrapper.block-$block_id .swiper-pagination-bullet {
    width: {$bullets['width']};
    height: {$bullets['height']};
    border-radius: {$bullets['radius']};
    background-color: {$bullets['color']['default']};
}
.cozy-block-wrapper.block-$block_id .swiper-pagination-horizontal .swiper-pagination-bullet {
    margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$bullets['gap']});
}
.cozy-block-wrapper.block-$block_id .swiper-pagination-bullet:hover {
    background-color: {$bullets['color']['default_hover']};
}
.cozy-block-wrapper.block-$block_id .swiper-pagination-bullet-active {
    width: {$bullets['active']['width']};
    height: {$bullets['active']['height']};
    border-radius: {$bullets['active']['radius']};
    {$bullets['active']['outline']}
    outline-offset: {$bullets['active']['outline_offset']};
    background-color: {$bullets['color']['active']};
}
.cozy-block-wrapper.block-$block_id .swiper-pagination-bullet-active:hover {
    background-color: {$bullets['color']['active_hover']};
}
";

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

wp_localize_script( 'cozy-block--brand-showcase--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--brand-showcase--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockBrandShowcase( "' . $client_id . '" ) }) ' );

$wrapper_attributes = get_block_wrapper_attributes();

$classes   = array();
$classes[] = 'cozy-block-wrapper';
$classes[] = 'cozy-block-brand-showcase-wrapper';
$classes[] = 'block-' . $block_id;
$classes[] = isset( $attributes['display'], $attributes['navigation']['enabled'], $attributes['navigation']['hoverShow'] ) && 'carousel' === $attributes['display'] && filter_var( $attributes['navigation']['enabled'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['navigation']['hoverShow'], FILTER_VALIDATE_BOOLEAN ) ? 'nav-hover-show' : '';
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
	<div <?php echo $wrapper_attributes; ?>>
		<?php
		$classes   = array();
		$classes[] = 'cozy-block-brand-showcase';
		$classes[] = isset( $attributes['display'] ) ? 'display-' . sanitize_text_field( $attributes['display'] ) : '';
		$classes[] = cozy_addons_premium_access() && isset( $attributes['display'], $attributes['styles']['fadeBg'] ) && 'carousel' === $attributes['display'] && filter_var( $attributes['styles']['fadeBg'], FILTER_VALIDATE_BOOLEAN ) ? 'has-fade-effect' : '';
		$classes[] = cozy_addons_premium_access() && isset( $attributes['display'], $attributes['carousel']['smoothTransition'] ) && 'carousel' === $attributes['display'] && filter_var( $attributes['carousel']['smoothTransition'], FILTER_VALIDATE_BOOLEAN ) ? 'has-smooth-transition' : '';
		$classes[] = isset( $attributes['imageStyles']['enableFilter'] ) && filter_var( $attributes['imageStyles']['enableFilter'], FILTER_VALIDATE_BOOLEAN ) ? 'has-image-filter' : '';
		$classes[] = isset( $attributes['imageStyles']['enableHoverFilter'] ) && filter_var( $attributes['imageStyles']['enableHoverFilter'], FILTER_VALIDATE_BOOLEAN ) ? 'has-image-hover-filter' : '';
		?>
		<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<?php
			$classes   = array();
			$classes[] = isset( $attributes['display'] ) ? 'cozy-block-' . sanitize_text_field( $attributes['display'] ) . '-wrapper' : '';
			$classes[] = isset( $attributes['display'], $attributes['gridOptions']['masonry'] ) && 'grid' === $attributes['display'] && filter_var( $attributes['gridOptions']['masonry'], FILTER_VALIDATE_BOOLEAN ) ? 'has-masonry' : '';
			$classes[] = isset( $attributes['display'] ) && 'carousel' === $attributes['display'] ? 'swiper-wrapper' : '';
			?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php echo $content; ?>
			</div>
		</div>

		<?php
		if ( isset( $attributes['display'] ) && 'carousel' === $attributes['display'] ) {
			if ( isset( $attributes['navigation']['enabled'] ) && filter_var( $attributes['navigation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
				?>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
				<?php
			}
			if ( isset( $attributes['pagination']['enabled'] ) && filter_var( $attributes['pagination']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
				?>
				<div class="swiper-pagination"></div>
				<?php
			}
		}
		?>
	</div>
</div>