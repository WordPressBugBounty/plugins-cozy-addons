<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';

$bg_color       = isset( $attributes['boxStyles']['bgColor'] ) ? $attributes['boxStyles']['bgColor'] : '';
$bg_color_hover = isset( $attributes['boxStyles']['bgColorHover'] ) ? $attributes['boxStyles']['bgColorHover'] : '';

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$styles = array(
	'gap'     => isset( $attributes['gap'] ) ? esc_attr( $attributes['gap'] ) : '',
	'padding' => array(
		'top'    => isset( $attributes['boxStyles']['padding']['top'] ) ? esc_attr( $attributes['boxStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['boxStyles']['padding']['right'] ) ? esc_attr( $attributes['boxStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['boxStyles']['padding']['bottom'] ) ? esc_attr( $attributes['boxStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['boxStyles']['padding']['left'] ) ? esc_attr( $attributes['boxStyles']['padding']['left'] ) : '',
	),
	'border'  => array(
		'width' => isset( $attributes['boxStyles']['borderWidth'] ) ? esc_attr( $attributes['boxStyles']['borderWidth'] ) : '',
		'style' => isset( $attributes['boxStyles']['borderType'] ) ? esc_attr( sanitize_text_field( $attributes['boxStyles']['borderType'] ) ) : '',
	),
	'radius'  => isset( $attributes['boxStyles']['borderRadius'] ) ? esc_attr( $attributes['boxStyles']['borderRadius'] ) : '',
);

$icon_styles = array(
	'size'    => isset( $attributes['iconSize'] ) ? esc_attr( $attributes['iconSize'] ) : '',
	'opacity' => isset( $attributes['iconOpacity'] ) ? esc_attr( $attributes['iconOpacity'] ) : '',
);

$icon_color = array(
	'border'       => isset( $attributes['boxStyles']['borderColor'] ) ? $attributes['boxStyles']['borderColor'] : '',
	'default'      => isset( $attributes['iconColor'] ) ? $attributes['iconColor'] : '',
	'hover'        => isset( $attributes['iconColorHover'] ) ? $attributes['iconColorHover'] : '',
	'border_hover' => isset( $attributes['boxStyles']['borderColorHover'] ) ? esc_attr( $attributes['boxStyles']['borderColorHover'] ) : '',
);

$block_styles = "
#$block_id .cozy-block-social-icon-picker {
    margin-right: {$styles['gap']}px;
}
#$block_id.stacked .cozy-block-social-icon-picker {
    padding-top: {$styles['padding']['top']}px;
    padding-right: {$styles['padding']['right']}px;
    padding-bottom: {$styles['padding']['bottom']}px;
    padding-left: {$styles['padding']['left']}px;
    border: {$styles['border']['width']}px;
    border-style: {$styles['border']['style']};
    border-color: {$icon_color['border']};
    border-radius: {$styles['radius']}px;
}
#$block_id.stacked.icon-color-custom .cozy-block-social-icon-picker {
    background: {$bg_color};
}
#$block_id.stacked a:hover .cozy-block-social-icon-picker {
    border-color: {$icon_color['border_hover']};
}
#$block_id.stacked.icon-color-custom a:hover .cozy-block-social-icon-picker {
    background: {$bg_color_hover};
}
#$block_id svg {
    width: {$icon_styles['size']}px !important;
    height: {$icon_styles['size']}px !important;
    opacity: {$icon_styles['opacity']};
}
#$block_id.fill.icon-color-custom svg {
    fill: {$icon_color['default']};
}
#$block_id.fill.icon-color-custom a:hover .cozy-block-social-icon-picker svg {
    fill: {$icon_color['hover']};
}
#$block_id.outline.icon-color-custom svg {
    stroke: {$icon_color['default']};
    fill: none;
}
#$block_id.outline.icon-color-custom a:hover .cozy-block-social-icon-picker svg {
    stroke: {$icon_color['hover']};
    fill: none;
}
";

$output = '<div class="cozy-block-wrapper">';

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$output .= $content;
$output .= '</div>';

echo $output;
