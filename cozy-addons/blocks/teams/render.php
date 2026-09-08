<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$teams_var = 'cozyTeams_' . str_replace( '-', '_', $client_id );

$attributes['isPremium'] = cozy_addons_premium_access();

wp_localize_script( 'cozy-block--teams--frontend-script', $teams_var, $attributes );
wp_add_inline_script( 'cozy-block--teams--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockTeamsInit( "' . esc_html( $client_id ) . '" ) }) ' );

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

$bullet_styles = array(
	'gap'    => isset( $attributes['carouselOptions']['pagination']['gap'] ) ? esc_attr( $attributes['carouselOptions']['pagination']['gap'] ) : 4,
	'active' => array(
		'height' => isset( $attributes['carouselOptions']['pagination']['activeHeight'] ) ? esc_attr( $attributes['carouselOptions']['pagination']['activeHeight'] ) : 10,
		'border' => isset( $attributes['carouselOptions']['pagination']['activeBorder'] ) ? cozy_render_TRBL( 'outline', $attributes['carouselOptions']['pagination']['activeBorder'] ) : '',
		'offset' => isset( $attributes['carouselOptions']['pagination']['activeOffset'] ) ? esc_attr( $attributes['carouselOptions']['pagination']['activeOffset'] ) : '',
	),
	'color'  => array(
		'active_border_hover' => isset( $attributes['carouselOptions']['pagination']['activeBorderHover'] ) ? esc_attr( $attributes['carouselOptions']['pagination']['activeBorderHover'] ) : '',
	),
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

#$block_id.swiper-horizontal .swiper-pagination-bullets .swiper-pagination-bullet {
    margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$bullet_styles['gap']}px);
}
#$block_id .swiper-pagination-bullet-active {
    height: {$bullet_styles['active']['height']}px !important;
    {$bullet_styles['active']['border']}
    outline-offset: {$bullet_styles['active']['offset']}px;
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active:hover {
    outline-color: {$bullet_styles['color']['active_border_hover']};
}
";

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$wrapper_attributes = get_block_wrapper_attributes();

$classes   = array();
$classes[] = 'cozy-block-wrapper';
$classes[] = cozy_addons_premium_access() && 'carousel' === $attributes['layout'] && isset( $attributes['carouselOptions']['sliderOptions']['smoothTransition'] ) && $attributes['carouselOptions']['sliderOptions']['smoothTransition'] ? 'swiper__smooth-transition' : '';
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
	<div <?php echo $wrapper_attributes; ?>>
		<?php echo $content; ?>
	</div>
</div>
