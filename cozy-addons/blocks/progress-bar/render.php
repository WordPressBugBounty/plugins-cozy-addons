<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozyProgressBar_' . str_replace( '-', '_', $client_id );
wp_localize_script( 'cozy-block--progress-bar--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--progress-bar--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockProgressBarInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$typography = array(
	'font'           => array(
		'size'   => isset( $attributes['typography']['fontSize'] ) ? esc_attr( $attributes['typography']['fontSize'] ) : '',
		'weight' => isset( $attributes['typography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['typography']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['typography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['typography']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['typography']['lineHeight'] ) ? esc_attr( $attributes['typography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['typography']['letterSpacing'] ) ? esc_attr( $attributes['typography']['letterSpacing'] ) : '',
);

$styles = array(
	'radius'        => array(
		'top'    => isset( $attributes['borderRadius']['top'] ) ? esc_attr( $attributes['borderRadius']['top'] ) : '',
		'right'  => isset( $attributes['borderRadius']['right'] ) ? esc_attr( $attributes['borderRadius']['right'] ) : '',
		'bottom' => isset( $attributes['borderRadius']['bottom'] ) ? esc_attr( $attributes['borderRadius']['bottom'] ) : '',
		'left'   => isset( $attributes['borderRadius']['left'] ) ? esc_attr( $attributes['borderRadius']['left'] ) : '',
	),
	'width'         => isset( $attributes['width'] ) ? esc_attr( $attributes['width'] ) : '',
	'height'        => isset( $attributes['height'] ) ? esc_attr( $attributes['height'] ) : '',
	'circumference' => isset( $attributes['layoutCircle']['circumference'] ) ? esc_attr( $attributes['layoutCircle']['circumference'] ) : '',
	'circle'        => array(
		'primary_color'   => isset( $attributes['layoutCircle']['primaryColor'] ) ? esc_attr( $attributes['layoutCircle']['primaryColor'] ) : '',
		'secondary_color' => isset( $attributes['layoutCircle']['secondaryColor'] ) ? esc_attr( $attributes['layoutCircle']['secondaryColor'] ) : '',
	),
	'progress'      => isset( $attributes['progress'] ) ? esc_attr( $attributes['progress'] ) : '',
);

$container       = array(
	'padding' => array(
		'top'    => isset( $attributes['containerStyles']['padding']['top'] ) ? esc_attr( $attributes['containerStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['containerStyles']['padding']['right'] ) ? esc_attr( $attributes['containerStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['containerStyles']['padding']['bottom'] ) ? esc_attr( $attributes['containerStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['containerStyles']['padding']['left'] ) ? esc_attr( $attributes['containerStyles']['padding']['left'] ) : '',
	),
	'border'  => array(
		'style'        => isset( $attributes['containerStyles']['border']['type'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['border']['type'] ) ) : '',
		'width_top'    => isset( $attributes['containerStyles']['border']['width']['top'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['top'] ) : '',
		'width_right'  => isset( $attributes['containerStyles']['border']['width']['right'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['right'] ) : '',
		'width_bottom' => isset( $attributes['containerStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['bottom'] ) : '',
		'width_left'   => isset( $attributes['containerStyles']['border']['width']['left'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['left'] ) : '',
	),
	'radius'  => array(
		'top'    => isset( $attributes['containerStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['top'] ) : '',
		'right'  => isset( $attributes['containerStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['right'] ) : '',
		'bottom' => isset( $attributes['containerStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['bottom'] ) : '',
		'left'   => isset( $attributes['containerStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['left'] ) : '',
	),
);
$container_color = array(
	'text'   => isset( $attributes['typography']['color'] ) ? esc_attr( $attributes['typography']['color'] ) : '',
	'bg'     => isset( $attributes['containerStyles']['bgColor'] ) ? esc_attr( $attributes['containerStyles']['bgColor'] ) : '',
	'border' => isset( $attributes['containerStyles']['border']['color'] ) ? esc_attr( $attributes['containerStyles']['border']['color'] ) : '',
);

$label_wrapper_circum = $attributes['layoutCircle']['circumference'] - $attributes['layoutCircle']['width'];
$label_color          = array(
	'text' => isset( $attributes['labelTypography']['color'] ) ? $attributes['labelTypography']['color'] : '',
);
$label_styles         = array(
	'gap'            => isset( $attributes['label']['gap'] ) ? esc_attr( $attributes['label']['gap'] ) : '',
	'margin'         => array(
		'bottom' => isset( $attributes['label']['marginBottom'] ) ? esc_attr( $attributes['label']['marginBottom'] ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['labelTypography']['fontSize'] ) ? esc_attr( $attributes['labelTypography']['fontSize'] ) : '',
		'weight' => isset( $attributes['labelTypography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['labelTypography']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['labelTypography']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['labelTypography']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['labelTypography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['labelTypography']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['labelTypography']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['labelTypography']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['labelTypography']['lineHeight'] ) ? esc_attr( $attributes['labelTypography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['labelTypography']['letterSpacing'] ) ? esc_attr( $attributes['labelTypography']['letterSpacing'] ) : '',
);

$bar_color = array(
	'bg' => isset( $attributes['bgColor'] ) ? $attributes['bgColor'] : '',
);

$block_styles = "
.cozy-block-wrapper.$block_id .label-wrapper .progress{
    font-size: {$typography['font']['size']}px;
    font-weight: {$typography['font']['weight']};
    font-family: {$typography['font']['family']};
    text-transform: {$typography['letter_case']};
    text-decoration: {$typography['decoration']};
    line-height: {$typography['line_height']};
    letter-spacing: {$typography['letter_spacing']};
    color: {$container_color['text']};
}
.cozy-block-wrapper.$block_id .label-wrapper.display-flex.justify-spread {
    margin-bottom: {$label_styles['margin']['bottom']}px;
    font-size: {$typography['font']['size']}px;
    font-weight: {$typography['font']['weight']};
    font-family: {$typography['font']['family']};
    text-transform: {$typography['letter_case']};
    text-decoration: {$typography['decoration']};
    line-height: {$typography['line_height']};
    letter-spacing: {$typography['letter_spacing']};
    color: {$container_color['text']};
}
.cozy-block-wrapper.$block_id .before-progress, .cozy-block-wrapper.$block_id .after-progress {
    font-size: {$label_styles['font']['size']}px;
    font-weight: {$label_styles['font']['weight']};
    font-family: {$label_styles['font']['family']};
    text-transform: {$label_styles['letter_case']};
    text-decoration: {$label_styles['decoration']};
    line-height: {$label_styles['line_height']};
    letter-spacing: {$label_styles['letter_spacing']};
    color: {$label_color['text']};
}

#$block_id {
    border-style: {$container['border']['style']};
    border-top-width: {$container['border']['width_top']}px;
    border-right-width: {$container['border']['width_right']}px;
    border-bottom-width: {$container['border']['width_bottom']}px;
    border-left-width: {$container['border']['width_left']}px;
    border-color: {$container_color['border']};
}
#$block_id:not(.layout-circle) {
    padding-top: {$container['padding']['top']}px;
    padding-right: {$container['padding']['right']}px;
    padding-bottom: {$container['padding']['bottom']}px;
    padding-left: {$container['padding']['left']}px;
    background-color: {$container_color['bg']};
    border-top-left-radius: {$container['radius']['top']}px;
    border-top-right-radius: {$container['radius']['right']}px;
    border-bottom-right-radius: {$container['radius']['bottom']}px;
    border-bottom-left-radius: {$container['radius']['left']}px;
}
#$block_id:not(.layout-circle) .cozy-progress-bar {
    background-color: {$bar_color['bg']};
    border-top-left-radius: {$styles['radius']['top']}px;
    border-top-right-radius: {$styles['radius']['right']}px;
    border-bottom-right-radius: {$styles['radius']['bottom']}px;
    border-bottom-left-radius: {$styles['radius']['left']}px;
}
#$block_id.layout-default .cozy-progress-bar {
    height: {$styles['height']}px;
}
#$block_id.layout-default:not(.label-align-spread) .label-wrapper{
    gap: {$label_styles['gap']}px;
}
#$block_id.layout-vertical {
    height: {$styles['height']}px;
}
#$block_id.layout-vertical .cozy-progress-bar {
    width: {$styles['width']}px;
}
#$block_id.layout-circle {
    width: {$styles['circumference']}px;
    height: {$styles['circumference']}px;
}
#$block_id.layout-circle .cozy-progress-bar {
    background: conic-gradient({$styles['circle']['primary_color']} 0%, {$styles['circle']['secondary_color']} {$styles['progress']}%);
    padding-top: {$container['padding']['top']}px;
    padding-right: {$container['padding']['right']}px;
    padding-bottom: {$container['padding']['bottom']}px;
    padding-left: {$container['padding']['left']}px;
}
#$block_id.layout-circle .cozy-progress-bar .label-wrapper {
    width: {$label_wrapper_circum}px;
    height: {$label_wrapper_circum}px;
    background-color: {$container_color['bg']};
}
";

$output = '';
if ( 'circle' === $attributes['layout'] ) {
	$output = '<div class="cozy-block-wrapper ' . esc_attr( $block_id ) . ' wp-block-cozy-block-progress-bar display-flex block-align-' . esc_attr( sanitize_html_class( $attributes['layoutCircle']['alignment'] ) ) . '">';
} else {
	$output = '<div class="cozy-block-wrapper ' . esc_attr( $block_id ) . ' ">';
}

$font_families = array();

if ( isset( $attributes['labelTypography']['fontFamily'] ) && ! empty( $attributes['labelTypography']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['labelTypography']['fontFamily'] );
}
if ( isset( $attributes['typography']['fontFamily'] ) && ! empty( $attributes['typography']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['typography']['fontFamily'] );
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

$output .= $content;
$output .= '</div>';

echo $output;
