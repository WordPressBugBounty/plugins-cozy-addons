<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozyModal_' . str_replace( '-', '_', $client_id );
wp_localize_script( 'cozy-block--modal--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--modal--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockModalInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$wrapper_styles = array(
	'margin'  => isset( $attributes['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['margin'] ) : '',
	'padding' => array(
		'top'    => isset( $attributes['padding']['top'] ) ? cozy_addons_sanitize_dimension( $attributes['padding']['top'] ) : '',
		'right'  => isset( $attributes['padding']['right'] ) ? esc_attr( $attributes['padding']['right'] ) : '',
		'bottom' => isset( $attributes['padding']['bottom'] ) ? esc_attr( $attributes['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['padding']['left'] ) ? esc_attr( $attributes['padding']['left'] ) : '',
	),
	'width'   => isset( $attributes['boxWidth'] ) ? esc_attr( $attributes['boxWidth'] ) : '',
);

$color = array(
	'bg'         => isset( $attributes['backgroundColor'] ) ? esc_attr( $attributes['backgroundColor'] ) : '',
	'icon'       => isset( $attributes['iconStyles']['iconColor'] ) ? esc_attr( $attributes['iconStyles']['iconColor'] ) : '',
	'icon_hover' => isset( $attributes['iconStyles']['iconColorHover'] ) ? esc_attr( $attributes['iconStyles']['iconColorHover'] ) : '',
);


$button_styles = array(
	'justify'        => isset( $attributes['clickButtonStyles']['justify'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['justify'] ) ) : 'center',
	'padding'        => array(
		'top'    => isset( $attributes['clickButtonStyles']['padding']['top'] ) ? esc_attr( $attributes['clickButtonStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['clickButtonStyles']['padding']['right'] ) ? esc_attr( $attributes['clickButtonStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['clickButtonStyles']['padding']['bottom'] ) ? esc_attr( $attributes['clickButtonStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['clickButtonStyles']['padding']['left'] ) ? esc_attr( $attributes['clickButtonStyles']['padding']['left'] ) : '',
	),
	'border'         => array(
		'width_top'    => isset( $attributes['clickButtonStyles']['borderWidth']['top'] ) ? esc_attr( $attributes['clickButtonStyles']['borderWidth']['top'] ) : '',
		'width_right'  => isset( $attributes['clickButtonStyles']['borderWidth']['right'] ) ? esc_attr( $attributes['clickButtonStyles']['borderWidth']['right'] ) : '',
		'width_bottom' => isset( $attributes['clickButtonStyles']['borderWidth']['bottom'] ) ? esc_attr( $attributes['clickButtonStyles']['borderWidth']['bottom'] ) : '',
		'width_left'   => isset( $attributes['clickButtonStyles']['borderWidth']['left'] ) ? esc_attr( $attributes['clickButtonStyles']['borderWidth']['left'] ) : '',
		'style'        => isset( $attributes['clickButtonStyles']['borderType'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['borderType'] ) ) : '',
		'color'        => isset( $attributes['clickButtonStyles']['borderColor'] ) ? $attributes['clickButtonStyles']['borderColor'] : '',
	),
	'radius'         => isset( $attributes['clickButtonStyles']['borderRadius'] ) ? esc_attr( $attributes['clickButtonStyles']['borderRadius'] ) : '',
	'text'           => isset( $attributes['clickButtonStyles']['color'] ) ? $attributes['clickButtonStyles']['color'] : '',
	'bg'             => isset( $attributes['clickButtonStyles']['bgColor'] ) ? $attributes['clickButtonStyles']['bgColor'] : '',
	'text_hover'     => isset( $attributes['clickButtonStyles']['colorHover'] ) ? $attributes['clickButtonStyles']['colorHover'] : '',
	'bg_hover'       => isset( $attributes['clickButtonStyles']['bgColorHover'] ) ? $attributes['clickButtonStyles']['bgColorHover'] : '',
	'font'           => array(
		'size'   => isset( $attributes['clickButtonStyles']['fontSize'] ) ? esc_attr( $attributes['clickButtonStyles']['fontSize'] ) : '',
		'weight' => isset( $attributes['clickButtonStyles']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['clickButtonStyles']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['clickButtonStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['clickButtonStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['clickButtonStyles']['lineHeight'] ) ? esc_attr( $attributes['clickButtonStyles']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['clickButtonStyles']['letterSpacing'] ) ? esc_attr( $attributes['clickButtonStyles']['letterSpacing'] ) : '',
	'img'            => array(
		'width'  => isset( $attributes['clickButtonStyles']['imgWidth'] ) ? esc_attr( $attributes['clickButtonStyles']['imgWidth'] ) : '100',
		'height' => isset( $attributes['clickButtonStyles']['imgHeight'] ) ? esc_attr( $attributes['clickButtonStyles']['imgHeight'] ) : '100',
		'radius' => isset( $attributes['clickButtonStyles']['imgRadius'] ) ? esc_attr( $attributes['clickButtonStyles']['imgRadius'] ) : '',
	),
);

$icon_styles = array(
	'display'    => ( isset( $attributes['iconStyles']['enabled'] ) && $attributes['iconStyles']['enabled'] ) || ! isset( $attributes['iconStyles']['enabled'] ) ? 'flex' : 'none',
	'box_width'  => isset( $attributes['iconStyles']['boxWidth'] ) ? esc_attr( $attributes['iconStyles']['boxWidth'] ) : '36',
	'box_height' => isset( $attributes['iconStyles']['boxHeight'] ) ? esc_attr( $attributes['iconStyles']['boxHeight'] ) : '36',
	'margin'     => array(
		'top'  => isset( $attributes['iconStyles']['verticalSpacing'] ) ? esc_attr( $attributes['iconStyles']['verticalSpacing'] ) : '',
		'hval' => isset( $attributes['iconStyles']['horizontalSpacing'] ) ? esc_attr( $attributes['iconStyles']['horizontalSpacing'] ) : '',
	),
	'radius'     => isset( $attributes['iconStyles']['radius'] ) ? esc_attr( $attributes['iconStyles']['radius'] ) : '100',
	'size'       => isset( $attributes['iconStyles']['iconSize'] ) ? esc_attr( $attributes['iconStyles']['iconSize'] ) : '',
	'color'      => array(
		'bg'       => isset( $attributes['iconStyles']['bg'] ) ? esc_attr( $attributes['iconStyles']['bg'] ) : '',
		'bg_hover' => isset( $attributes['iconStyles']['bgHover'] ) ? esc_attr( $attributes['iconStyles']['bgHover'] ) : '',
	),
);

$overlay_styles = array(
	'color' => array(
		'bg' => isset( $attributes['backgroundOverlayColor'] ) ? esc_attr( $attributes['backgroundOverlayColor'] ) : '',
	),
);

$block_styles = "
.cozy-block-wrapper[data-block='{$client_id}'] {
    text-align: {$button_styles['justify']};
	{$wrapper_styles['margin']}
}
.cozy-block-wrapper[data-block='{$client_id}'] .cozy-block-modal__overlay {
	background-color: {$overlay_styles['color']['bg']};
}
.cozy-modal-open[data-type='{$client_id}'] {
    padding-top: {$button_styles['padding']['top']}px;
    padding-right: {$button_styles['padding']['right']}px;
    padding-bottom: {$button_styles['padding']['bottom']}px;
    padding-left: {$button_styles['padding']['left']}px;
    border-style: {$button_styles['border']['style']};
    border-top-width: {$button_styles['border']['width_top']}px;
    border-right-width: {$button_styles['border']['width_right']}px;
    border-bottom-width: {$button_styles['border']['width_bottom']}px;
    border-left-width: {$button_styles['border']['width_left']}px;
    border-color: {$button_styles['border']['color']};
    border-radius: {$button_styles['radius']}px;
    font-size: {$button_styles['font']['size']}px;
    font-family: {$button_styles['font']['family']};
    font-weight: {$button_styles['font']['weight']};
    text-transform: {$button_styles['letter_case']};
    text-decoration: {$button_styles['decoration']};
    line-height: {$button_styles['line_height']};
    letter-spacing: {$button_styles['letter_spacing']};
    color: {$button_styles['text']};
    background-color: {$button_styles['bg']};
}
.cozy-modal-open[data-type='{$client_id}'] .cozy-modal-open__img {
    max-width: {$button_styles['img']['width']}px;
    max-height: {$button_styles['img']['height']}px;
    border-radius: {$button_styles['img']['radius']}px;
}
.cozy-modal-open[data-type='{$client_id}'] .cozy-modal-open__img img {
    border-radius: {$button_styles['img']['radius']}px;
}
.cozy-modal-open[data-type='{$client_id}']:hover {
    color: {$button_styles['text_hover']} !important;
    background-color: {$button_styles['bg_hover']} !important;
}
#$block_id {
    padding-top: {$wrapper_styles['padding']['top']}px;
    padding-right: {$wrapper_styles['padding']['right']}px;
    padding-bottom: {$wrapper_styles['padding']['bottom']}px;
    padding-left: {$wrapper_styles['padding']['left']}px;
    background-color: {$color['bg']};
}
#$block_id.type-default {
    width: {$wrapper_styles['width']}px;
}
#$block_id .modal-icon-wrapper {
    margin-top: {$icon_styles['margin']['top']}px;
    display: {$icon_styles['display']};
    width: {$icon_styles['box_width']}px;
    height: {$icon_styles['box_height']}px;
    border-radius: {$icon_styles['radius']}px;
    background-color: {$icon_styles['color']['bg']};
}
#$block_id.icon-align-left .modal-icon-wrapper {
    margin-left: {$icon_styles['margin']['hval']}px;
}
#$block_id.icon-align-right .modal-icon-wrapper {
    margin-right: {$icon_styles['margin']['hval']}px;
}
#$block_id .modal-icon-wrapper:hover {
    background-color: {$icon_styles['color']['bg_hover']};
}
#$block_id .modal-icon-wrapper svg {
    width: {$icon_styles['size']}px;
    height: {$icon_styles['size']}px;
    fill: {$color['icon']};
}
#$block_id .modal-icon-wrapper:hover svg {
    fill: {$color['icon_hover']};
}
";

$font_families = array();

if ( isset( $attributes['clickButtonStyles']['fontFamily'] ) && ! empty( $attributes['clickButtonStyles']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['clickButtonStyles']['fontFamily'] );
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

$output = '<div class="cozy-block-wrapper" data-block="' . esc_attr( $client_id ) . '">';

if ( 'default' === $attributes['modalType'] ) {
	$output .= '<div class="cozy-block-modal__overlay display-none"></div>';
}

$output .= $content;
$output .= '</div>';

echo $output;
