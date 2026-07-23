<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$styles = array(
	'align'          => isset( $attributes['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['textAlign'] ) ) : '',
	'gap'            => isset( $attributes['iconGap'] ) ? esc_attr( $attributes['iconGap'] ) : '',
	'width'          => isset( $attributes['containerStyles']['width'] ) ? esc_attr( $attributes['containerStyles']['width'] ) : '',
	'height'         => isset( $attributes['containerStyles']['height'] ) ? esc_attr( $attributes['containerStyles']['height'] ) : '',
	'radius'         => array(
		'top'    => isset( $attributes['containerStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['top'] ) : '',
		'right'  => isset( $attributes['containerStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['right'] ) : '',
		'bottom' => isset( $attributes['containerStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['bottom'] ) : '',
		'left'   => isset( $attributes['containerStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['left'] ) : '',
	),
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

$container = array(
	'gap' => isset( $attributes['containerStyles']['gap'] ) ? esc_attr( $attributes['containerStyles']['gap'] ) : '',
);

$color                   = isset( $attributes['typography']['color'] ) ? $attributes['typography']['color'] : '';
$color_hover             = isset( $attributes['typography']['colorHover'] ) ? $attributes['typography']['colorHover'] : '';
$item_padding_top        = isset( $attributes['containerStyles']['padding']['top'] ) ? $attributes['containerStyles']['padding']['top'] : '';
$item_padding_right      = isset( $attributes['containerStyles']['padding']['right'] ) ? $attributes['containerStyles']['padding']['right'] : '';
$item_padding_bottom     = isset( $attributes['containerStyles']['padding']['bottom'] ) ? $attributes['containerStyles']['padding']['bottom'] : '';
$item_padding_left       = isset( $attributes['containerStyles']['padding']['left'] ) ? $attributes['containerStyles']['padding']['left'] : '';
$item_border_width       = isset( $attributes['containerStyles']['borderWidth'] ) ? $attributes['containerStyles']['borderWidth'] : '';
$item_border_type        = isset( $attributes['containerStyles']['borderType'] ) ? $attributes['containerStyles']['borderType'] : '';
$item_border_color       = isset( $attributes['containerStyles']['borderColor'] ) ? $attributes['containerStyles']['borderColor'] : '';
$item_border_color_hover = isset( $attributes['containerStyles']['borderColorHover'] ) ? $attributes['containerStyles']['borderColorHover'] : '';
$item_bg_color           = isset( $attributes['containerStyles']['bgColor'] ) ? $attributes['containerStyles']['bgColor'] : '';
$item_bg_color_hover     = isset( $attributes['containerStyles']['bgColorHover'] ) ? $attributes['containerStyles']['bgColorHover'] : '';

$icon_box_bg_color_hover = isset( $attributes['iconBoxStyles']['bgColorHover'] ) ? $attributes['iconBoxStyles']['bgColorHover'] : '';

$icon_styles = array(
	'size'    => isset( $attributes['iconSize'] ) ? esc_attr( $attributes['iconSize'] ) : '',
	'padding' => array(
		'top'    => isset( $attributes['iconBoxStyles']['padding']['top'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['iconBoxStyles']['padding']['right'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['iconBoxStyles']['padding']['bottom'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['iconBoxStyles']['padding']['left'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['left'] ) : '',
	),
	'border'  => array(
		'width' => isset( $attributes['iconBoxStyles']['borderWidth'] ) ? esc_attr( $attributes['iconBoxStyles']['borderWidth'] ) : '',
		'style' => isset( $attributes['iconBoxStyles']['borderType'] ) ? esc_attr( sanitize_text_field( $attributes['iconBoxStyles']['borderType'] ) ) : '',
	),
	'radius'  => isset( $attributes['iconBoxStyles']['borderRadius'] ) ? esc_attr( $attributes['iconBoxStyles']['borderRadius'] ) : '',
	'rotate'  => isset( $attributes['iconRotate'] ) ? esc_attr( $attributes['iconRotate'] ) : '',
	'opacity' => isset( $attributes['iconOpacity'] ) ? esc_attr( $attributes['iconOpacity'] ) : '',
);
$icon_color  = array(
	'default'        => isset( $attributes['iconColor'] ) ? $attributes['iconColor'] : '',
	'default_bg'     => isset( $attributes['iconBoxStyles']['bgColor'] ) ? $attributes['iconBoxStyles']['bgColor'] : '',
	'default_border' => isset( $attributes['iconBoxStyles']['borderColor'] ) ? $attributes['iconBoxStyles']['borderColor'] : '',
	'hover'          => isset( $attributes['iconColorHover'] ) ? $attributes['iconColorHover'] : '',
	'hover_border'   => isset( $attributes['iconBoxStyles']['borderColorHover'] ) ? $attributes['iconBoxStyles']['borderColorHover'] : '',
);

$block_styles = "
#$block_id .cozy-block-list-item {
    width: {$styles['width']}px;
    height: {$styles['height']}px;
    border-top-left-radius: {$styles['radius']['top']}px;
    border-top-right-radius: {$styles['radius']['right']}px;
    border-bottom-right-radius: {$styles['radius']['bottom']}px;
    border-bottom-left-radius: {$styles['radius']['left']}px;
    background-color: {$item_bg_color};
    font-size: {$styles['font']['size']}px;
    font-weight: {$styles['font']['weight']};
    font-family: {$styles['font']['family']};
    text-transform: {$styles['letter_case']};
    text-decoration: {$styles['decoration']};
	line-height: {$styles['line_height']};
	letter-spacing: {$styles['letter_spacing']};
    color: {$color};
    text-align: {$styles['align']};
    padding: {$item_padding_top}px {$item_padding_right}px {$item_padding_bottom}px {$item_padding_left}px;
    border-width: {$item_border_width}px;
    border-style: {$item_border_type};
    border-color: {$item_border_color};
    gap: {$styles['gap']}px;
}

#$block_id .cozy-block-list-item:hover {
    background-color: {$item_bg_color_hover};
    color: {$color_hover};
    border-color: {$item_border_color_hover};
}

#$block_id.vertical .list-inline-block {
    margin-bottom: {$container['gap']}px;
}

#$block_id.horizontal .list-inline-block {
    margin-right: {$container['gap']}px;
}

#$block_id svg {
    width: {$icon_styles['size']}px;
    height: {$icon_styles['size']}px;
    transform: rotate({$icon_styles['rotate']}deg);
    opacity: {$icon_styles['opacity']};
}

#$block_id.fill svg {
    fill: {$icon_color['default']};
}

#$block_id.outline svg {
    stroke: {$icon_color['default']};
    fill: none;
}

#$block_id.fill .cozy-block-list-item:hover svg {
    fill: {$icon_color['hover']};
}

#$block_id.outline .cozy-block-list-item:hover svg {
    stroke: {$icon_color['hover']};
    fill: none;
}

#$block_id.stacked .list-icon-wrapper {
    padding-top: {$icon_styles['padding']['top']}px;
    padding-right: {$icon_styles['padding']['right']}px;
    padding-bottom: {$icon_styles['padding']['bottom']}px;
    padding-left: {$icon_styles['padding']['left']}px;
    border-width: {$icon_styles['border']['width']}px;
    border-style: {$icon_styles['border']['style']};
    border-color: {$icon_color['default_border']};
    border-radius: {$icon_styles['radius']}px;
    background-color: {$icon_color['default_bg']};
}

#$block_id.stacked .cozy-block-list-item:hover .list-icon-wrapper {
    background-color: {$icon_box_bg_color_hover};
    border-color: {$icon_color['hover_border']};
}
";

$output = '<div class="cozy-block-wrapper">';

$font_families = array();

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
