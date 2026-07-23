<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id     = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['blockClientId'] ) ) : '';
$container_var = 'cozyContainer_' . str_replace( '-', '_', $client_id );

wp_localize_script( 'cozy-block--container--frontend-script', $container_var, $attributes );
wp_add_inline_script( 'cozy-block--container--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockContainerInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$background_image = $attributes['mediaUrl'] != '' ? 'url("' . esc_url( $attributes['mediaUrl'] ) . '")' : 'none';

$position = isset( $attributes['position'] ) ? esc_attr( sanitize_text_field( $attributes['position'] ) ) : '';

$styles = array(
	'zindex'         => isset( $attributes['zIndex'] ) ? esc_attr( $attributes['zIndex'] ) : '',
	'image_position' => isset( $attributes['imagePosition'] ) ? esc_attr( sanitize_text_field( $attributes['imagePosition'] ) ) : '',
	'top'            => isset( $attributes['top'] ) ? esc_attr( $attributes['top'] ) : '',
	'bottom'         => isset( $attributes['bottom'] ) ? esc_attr( $attributes['bottom'] ) : '',
);

$sticky = array(
	'bg_color' => isset( $attributes['stickyStyles']['bgColor'] ) ? esc_attr( $attributes['stickyStyles']['bgColor'] ) : '',
	'blur'     => isset( $attributes['stickyStyles']['backDropBlur'] ) ? esc_attr( $attributes['stickyStyles']['backDropBlur'] ) : '',
);

$shape_divider = array(
	'margin' => array(
		'top'    => isset( $attributes['shapeDivider']['margin']['top'] ) ? esc_attr( $attributes['shapeDivider']['margin']['top'] ) : '',
		'right'  => isset( $attributes['shapeDivider']['margin']['right'] ) ? esc_attr( $attributes['shapeDivider']['margin']['right'] ) : '',
		'bottom' => isset( $attributes['shapeDivider']['margin']['bottom'] ) ? esc_attr( $attributes['shapeDivider']['margin']['bottom'] ) : '',
		'left'   => isset( $attributes['shapeDivider']['margin']['left'] ) ? esc_attr( $attributes['shapeDivider']['margin']['left'] ) : '',
	),
	'height' => isset( $attributes['shapeDivider']['height'] ) ? esc_attr( $attributes['shapeDivider']['height'] ) : '',
	'color'  => isset( $attributes['shapeDivider']['color'] ) ? esc_attr( $attributes['shapeDivider']['color'] ) : '',
);

$block_styles = "
.cozy-block-wrapper.position-sticky {
    z-index: {$styles['zindex']};
}

#$block_id {
    background-image: {$background_image};
    background-position: {$styles['image_position']};
    position: {$position};
}

.cozy-block-wrapper.is-sticky.$block_id #$block_id {
    background-color: {$sticky['bg_color']};
    backdrop-filter: blur({$sticky['blur']});
}

#$block_id.fixed-placement-top {
    top: {$styles['top']}px;
}

#$block_id.fixed-placement-bottom {
    bottom: {$styles['bottom']}px;
}

#$block_id .cozy-shape-divider-wrapper svg {
    margin-top: {$shape_divider['margin']['top']}px;
    margin-right: {$shape_divider['margin']['right']}px;
    margin-bottom: {$shape_divider['margin']['bottom']}px;
    margin-left: {$shape_divider['margin']['left']}px;
    height: {$shape_divider['height']}px;
    fill: {$shape_divider['color']};
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
$classes[] = $block_id;
$classes[] = ( 'sticky' === $attributes['position'] || 'fixed' === $attributes['position'] ) ? 'position-' . $attributes['position'] : '';
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
	<?php echo $content; ?>
</div>
