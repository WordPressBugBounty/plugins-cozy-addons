<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozySidebarPanel_' . str_replace( '-', '_', $client_id );
wp_localize_script( 'cozy-block--sidebar-panel--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--sidebar-panel--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockSidebarPanelInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$styles = array(
	'zindex' => isset( $attributes['zIndex'] ) ? esc_attr( $attributes['zIndex'] ) : '',
	'width'  => isset( $attributes['width'] ) ? esc_attr( $attributes['width'] ) : '',
);

$container       = array(
	'padding' => array(
		'top'    => isset( $attributes['sidebarPadding']['top'] ) ? esc_attr( $attributes['sidebarPadding']['top'] ) : '',
		'right'  => isset( $attributes['sidebarPadding']['right'] ) ? esc_attr( $attributes['sidebarPadding']['right'] ) : '',
		'bottom' => isset( $attributes['sidebarPadding']['bottom'] ) ? esc_attr( $attributes['sidebarPadding']['bottom'] ) : '',
		'left'   => isset( $attributes['sidebarPadding']['left'] ) ? esc_attr( $attributes['sidebarPadding']['left'] ) : '',
	),
);
$container_color = array(
	'bg'         => isset( $attributes['bgColor'] ) ? $attributes['bgColor'] : '',
	'text'       => isset( $attributes['typography']['color'] ) ? $attributes['typography']['color'] : '',
	'text_hover' => isset( $attributes['typography']['colorHover'] ) ? $attributes['typography']['colorHover'] : '',
);

$icon_styles = array(
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
	'size'    => isset( $attributes['iconSize'] ) ? esc_attr( $attributes['iconSize'] ) : '',
	'rotate'  => isset( $attributes['iconRotate'] ) ? esc_attr( $attributes['iconRotate'] ) : '',
	'opacity' => isset( $attributes['iconOpacity'] ) ? esc_attr( $attributes['iconOpacity'] ) : '',
);
$icon_color  = array(
	'default'        => isset( $attributes['iconColor'] ) ? esc_attr( $attributes['iconColor'] ) : '',
	'border_default' => isset( $attributes['iconBoxStyles']['borderColor'] ) ? esc_attr( $attributes['iconBoxStyles']['borderColor'] ) : '',
	'bg_default'     => isset( $attributes['iconBoxStyles']['bgColor'] ) ? esc_attr( $attributes['iconBoxStyles']['bgColor'] ) : '',
	'hover'          => isset( $attributes['iconColorHover'] ) ? esc_attr( $attributes['iconColorHover'] ) : '',
	'border_hover'   => isset( $attributes['iconBoxStyles']['borderColorHover'] ) ? esc_attr( $attributes['iconBoxStyles']['borderColorHover'] ) : '',
	'bg_hover'       => isset( $attributes['iconBoxStyles']['bgColorHover'] ) ? esc_attr( $attributes['iconBoxStyles']['bgColorHover'] ) : '',
);

$open_icon  = array(
	'gap'   => isset( $attributes['openIcon']['gap'] ) ? esc_attr( $attributes['openIcon']['gap'] ) : '',
	'font'  => array(
		'size'   => isset( $attributes['typography']['fontSize'] ) ? esc_attr( $attributes['typography']['fontSize'] ) : '',
		'weight' => isset( $attributes['typography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['typography']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontFamily'] ) ) : '',
	),
	'color' => array(
		'icon'       => isset( $attributes['openIcon']['color']['icon'] ) ? $attributes['openIcon']['color']['icon'] : '',
		'icon_hover' => isset( $attributes['openIcon']['color']['iconHover'] ) ? $attributes['openIcon']['color']['iconHover'] : '',
		'bg'         => isset( $attributes['openIcon']['color']['bg'] ) ? $attributes['openIcon']['color']['bg'] : '',
		'bg_hover'   => isset( $attributes['openIcon']['color']['bgHover'] ) ? $attributes['openIcon']['color']['bgHover'] : '',
	),
);
$close_icon = array(
	'padding' => array(
		'v_val' => isset( $attributes['closeIcon']['verticalSpacing'] ) ? esc_attr( $attributes['closeIcon']['verticalSpacing'] ) : '',
	),
	'margin'  => array(
		'h_val' => isset( $attributes['closeIcon']['horizontalSpacing'] ) ? esc_attr( $attributes['closeIcon']['horizontalSpacing'] ) : '',
	),
);

$overlay_styles = array(
	'z_index' => isset( $attributes['overlayZIndex'] ) ? $attributes['overlayZIndex'] : '999',
	'color'   => array(
		'bg' => isset( $attributes['overlayBgColor'] ) ? $attributes['overlayBgColor'] : '',
	),
);

$typography = array(
	'letter_case'    => isset( $attributes['typography']['letterCase'] ) ? $attributes['typography']['letterCase'] : '',
	'decoration'     => isset( $attributes['typography']['decoration'] ) ? $attributes['typography']['decoration'] : '',
	'line_height'    => isset( $attributes['typography']['lineHeight'] ) ? $attributes['typography']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['typography']['letterSpacing'] ) ? $attributes['typography']['letterSpacing'] : '',
);

$block_styles = "
#$block_id .cozy-sidebar-panel-wrapper{
    padding-top: {$container['padding']['top']}px;
    padding-right: {$container['padding']['right']}px;
    padding-bottom: {$container['padding']['bottom']}px;
    padding-left: {$container['padding']['left']}px;
    background-color: {$container_color['bg']};
    z-index: {$styles['zindex']};
}
#$block_id.layout-custom .cozy-sidebar-panel-wrapper {
    width: {$styles['width']}px;
}
#$block_id .sidebar-icon-wrapper:not(.close-icon-wrapper) svg {
    width: {$icon_styles['size']}px;
    height: {$icon_styles['size']}px;
    rotate: {$icon_styles['rotate']}deg;
    opacity: {$icon_styles['opacity']};
}
#$block_id.icon-layout-fill .sidebar-icon-wrapper svg {
    fill: {$icon_color['default']};
}
#$block_id.icon-layout-outline .sidebar-icon-wrapper svg {
    stroke: {$icon_color['default']};
    fill: none;
}
#$block_id.icon-layout-fill .sidebar-icon-wrapper:hover svg, #$block_id.icon-layout-fill .open-icon-wrapper:hover .sidebar-icon-wrapper svg {
    fill: {$icon_color['hover']};
}
#$block_id.icon-layout-outline .sidebar-icon-wrapper:hover svg, #$block_id.icon-layout-outline .open-icon-wrapper:hover .sidebar-icon-wrapper svg {
    stroke: {$icon_color['hover']};
    fill: none;
}
#$block_id.icon-view-stacked .sidebar-icon-wrapper {
    padding-top: {$icon_styles['padding']['top']}px;
    padding-right: {$icon_styles['padding']['right']}px;
    padding-bottom: {$icon_styles['padding']['bottom']}px;
    padding-left: {$icon_styles['padding']['left']}px;
    border-width: {$icon_styles['border']['width']}px;
    border-style: {$icon_styles['border']['style']}; 
    border-color: {$icon_color['border_default']};
    border-radius: {$icon_styles['radius']}px;
    background-color: {$icon_color['bg_default']};
}
#$block_id.icon-view-stacked .sidebar-icon-wrapper:hover, #$block_id.icon-view-stacked .open-icon-wrapper:hover .sidebar-icon-wrapper {
    border-color: {$icon_color['border_hover']};
    background-color: {$icon_color['bg_hover']};
}
#$block_id .relative {
    padding: {$close_icon['padding']['v_val']}px 0;
    margin: 0 {$close_icon['margin']['h_val']}px;
}
#$block_id .open-icon-wrapper {
    gap: {$open_icon['gap']}px;
    font-size: {$open_icon['font']['size']}px;
    font-weight: {$open_icon['font']['weight']};
    font-family: {$open_icon['font']['family']};
    text-transform: {$typography['letter_case']};
    text-decoration: {$typography['decoration']};
    line-height: {$typography['line_height']};
    letter-spacing: {$typography['letter_spacing']};
    color: {$container_color['text']};
}
#$block_id .open-icon-wrapper:hover {
    color: {$container_color['text_hover']};
}
#$block_id.icon-layout-fill .open-icon-wrapper .sidebar-icon-wrapper svg {
    fill: {$open_icon['color']['icon']};
}
#$block_id.icon-layout-outline .open-icon-wrapper .sidebar-icon-wrapper svg {
    stroke: {$open_icon['color']['icon']};
    fill: none;
}
#$block_id.icon-layout-fill .open-icon-wrapper:hover .sidebar-icon-wrapper svg {
    fill: {$open_icon['color']['icon_hover']};
}
#$block_id.icon-layout-outline .open-icon-wrapper:hover .sidebar-icon-wrapper svg {
    stroke: {$open_icon['color']['icon_hover']};
    fill: none;
}
#$block_id.icon-view-stacked .open-icon-wrapper .sidebar-icon-wrapper {
    background-color: {$open_icon['color']['bg']};
}
#$block_id.icon-view-stacked .open-icon-wrapper:hover .sidebar-icon-wrapper {
    background-color: {$open_icon['color']['bg_hover']};
}

#$block_id.has-overlay:before {
    z-index: {$overlay_styles['z_index']};
    background-color: {$overlay_styles['color']['bg']};
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
