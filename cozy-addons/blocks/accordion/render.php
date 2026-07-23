<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['blockClientId'] ) ) : '';
$cozy_block_var = 'cozyAccordion_' . str_replace( '-', '_', $client_id );
wp_localize_script( 'cozy-block--accordion--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--accordion--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockAccordionInit( "' . $client_id . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$container_styles = array(
	'padding'      => array(
		'top'    => isset( $attributes['containerStyles']['padding']['top'] ) && ! empty( $attributes['containerStyles']['padding']['top'] ) ? esc_attr( $attributes['containerStyles']['padding']['top'] ) : '0',
		'right'  => isset( $attributes['containerStyles']['padding']['right'] ) && ! empty( $attributes['containerStyles']['padding']['right'] ) ? esc_attr( $attributes['containerStyles']['padding']['right'] ) : '0',
		'bottom' => isset( $attributes['containerStyles']['padding']['bottom'] ) && ! empty( $attributes['containerStyles']['padding']['bottom'] ) ? esc_attr( $attributes['containerStyles']['padding']['bottom'] ) : '0',
		'left'   => isset( $attributes['containerStyles']['padding']['left'] ) && ! empty( $attributes['containerStyles']['padding']['left'] ) ? esc_attr( $attributes['containerStyles']['padding']['left'] ) : '0',
	),
	'border_style' => isset( $attributes['containerStyles']['border']['type'] ) ? esc_attr( $attributes['containerStyles']['border']['type'] ) : '',
	'border_width' => array(
		'top'    => isset( $attributes['containerStyles']['border']['width']['top'] ) && ! empty( $attributes['containerStyles']['border']['width']['top'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['top'] ) : '0',
		'right'  => isset( $attributes['containerStyles']['border']['width']['right'] ) && ! empty( $attributes['containerStyles']['border']['width']['right'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['right'] ) : '0',
		'bottom' => isset( $attributes['containerStyles']['border']['width']['bottom'] ) && ! empty( $attributes['containerStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['bottom'] ) : '0',
		'left'   => isset( $attributes['containerStyles']['border']['width']['left'] ) && ! empty( $attributes['containerStyles']['border']['width']['left'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['left'] ) : '0',
	),
	'radius'       => array(
		'top'    => isset( $attributes['containerStyles']['borderRadius']['top'] ) && ! empty( $attributes['containerStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['top'] ) : '0',
		'right'  => isset( $attributes['containerStyles']['borderRadius']['right'] ) && ! empty( $attributes['containerStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['right'] ) : '0',
		'bottom' => isset( $attributes['containerStyles']['borderRadius']['bottom'] ) && ! empty( $attributes['containerStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['bottom'] ) : '0',
		'left'   => isset( $attributes['containerStyles']['borderRadius']['left'] ) && ! empty( $attributes['containerStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['left'] ) : '0',
	),
	'gap'          => isset( $attributes['rowGap'] ) && ! empty( $attributes['rowGap'] ) ? esc_attr( $attributes['rowGap'] ) : '',
);
$container_color  = array(
	'bg'     => isset( $attributes['containerStyles']['bgColor'] ) ? esc_attr( $attributes['containerStyles']['bgColor'] ) : '',
	'border' => isset( $attributes['containerStyles']['border']['color'] ) ? esc_attr( $attributes['containerStyles']['border']['color'] ) : '',
);

$item_styles = array(
	'padding'      => array(
		'top'    => isset( $attributes['accordionStyles']['padding']['top'] ) && ! empty( $attributes['accordionStyles']['padding']['top'] ) ? esc_attr( $attributes['accordionStyles']['padding']['top'] ) : '0',
		'right'  => isset( $attributes['accordionStyles']['padding']['right'] ) && ! empty( $attributes['accordionStyles']['padding']['right'] ) ? esc_attr( $attributes['accordionStyles']['padding']['right'] ) : '0',
		'bottom' => isset( $attributes['accordionStyles']['padding']['bottom'] ) && ! empty( $attributes['accordionStyles']['padding']['bottom'] ) ? esc_attr( $attributes['accordionStyles']['padding']['bottom'] ) : '0',
		'left'   => isset( $attributes['accordionStyles']['padding']['left'] ) && ! empty( $attributes['accordionStyles']['padding']['left'] ) ? esc_attr( $attributes['accordionStyles']['padding']['left'] ) : '0',
	),
	'border_style' => isset( $attributes['accordionStyles']['border']['type'] ) ? esc_attr( $attributes['accordionStyles']['border']['type'] ) : '',
	'border_width' => array(
		'top'    => isset( $attributes['accordionStyles']['border']['width']['top'] ) && ! empty( $attributes['accordionStyles']['border']['width']['top'] ) ? esc_attr( $attributes['accordionStyles']['border']['width']['top'] ) : '0',
		'right'  => isset( $attributes['accordionStyles']['border']['width']['right'] ) && ! empty( $attributes['accordionStyles']['border']['width']['right'] ) ? esc_attr( $attributes['accordionStyles']['border']['width']['right'] ) : '0',
		'bottom' => isset( $attributes['accordionStyles']['border']['width']['bottom'] ) && ! empty( $attributes['accordionStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['accordionStyles']['border']['width']['bottom'] ) : '0',
		'left'   => isset( $attributes['accordionStyles']['border']['width']['left'] ) && ! empty( $attributes['accordionStyles']['border']['width']['left'] ) ? esc_attr( $attributes['accordionStyles']['border']['width']['left'] ) : '0',
	),
	'radius'       => array(
		'top'    => isset( $attributes['accordionStyles']['borderRadius']['top'] ) && ! empty( $attributes['accordionStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['accordionStyles']['borderRadius']['top'] ) : '0',
		'right'  => isset( $attributes['accordionStyles']['borderRadius']['right'] ) && ! empty( $attributes['accordionStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['accordionStyles']['borderRadius']['right'] ) : '0',
		'bottom' => isset( $attributes['accordionStyles']['borderRadius']['bottom'] ) && ! empty( $attributes['accordionStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['accordionStyles']['borderRadius']['bottom'] ) : '0',
		'left'   => isset( $attributes['accordionStyles']['borderRadius']['left'] ) && ! empty( $attributes['accordionStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['accordionStyles']['borderRadius']['left'] ) : '0',
	),
);
$item_color  = array(
	'bg'     => isset( $attributes['accordionStyles']['bgColor'] ) ? esc_attr( $attributes['accordionStyles']['bgColor'] ) : '',
	'border' => isset( $attributes['accordionStyles']['border']['color'] ) ? esc_attr( $attributes['accordionStyles']['border']['color'] ) : '',
);

$title_styles = array(
	'margin'         => array(
		'top'    => isset( $attributes['titleTypography']['margin']['top'] ) && ! empty( $attributes['titleTypography']['margin']['top'] ) ? esc_attr( $attributes['titleTypography']['margin']['top'] ) : '',
		'bottom' => isset( $attributes['titleTypography']['margin']['bottom'] ) && ! empty( $attributes['titleTypography']['margin']['bottom'] ) ? esc_attr( $attributes['titleTypography']['margin']['bottom'] ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['titleTypography']['fontSize'] ) && ! empty( $attributes['titleTypography']['fontSize'] ) ? esc_attr( $attributes['titleTypography']['fontSize'] ) : '',
		'weight' => isset( $attributes['titleTypography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['titleTypography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['titleTypography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['titleTypography']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['titleTypography']['lineHeight'] ) && ! empty( $attributes['titleTypography']['lineHeight'] ) ? esc_attr( $attributes['titleTypography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['titleTypography']['letterSpacing'] ) && ! empty( $attributes['titleTypography']['letterSpacing'] ) ? esc_attr( $attributes['titleTypography']['letterSpacing'] ) : '',
);
$title_color  = array(
	'text'   => isset( $attributes['titleTypography']['color'] ) ? esc_attr( $attributes['titleTypography']['color'] ) : '',
	'active' => isset( $attributes['titleTypography']['colorActive'] ) ? esc_attr( $attributes['titleTypography']['colorActive'] ) : '',
);

$content_styles = array(
	'font'           => array(
		'size'   => isset( $attributes['typography']['fontSize'] ) && ! empty( $attributes['typography']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['typography']['fontSize'] ) : '',
		'weight' => isset( $attributes['typography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['typography']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['typography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['typography']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['typography']['lineHeight'] ) && ! empty( $attributes['typography']['lineHeight'] ) ? esc_attr( $attributes['typography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['typography']['letterSpacing'] ) && ! empty( $attributes['typography']['letterSpacing'] ) ? esc_attr( $attributes['typography']['letterSpacing'] ) : '',
);
$content_color  = array(
	'text' => isset( $attributes['typography']['color'] ) ? esc_attr( $attributes['typography']['color'] ) : '',
);

$icon_styles = array(
	'padding'       => array(
		'top'    => isset( $attributes['iconBoxStyles']['padding']['top'] ) && ! empty( $attributes['iconBoxStyles']['padding']['top'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['iconBoxStyles']['padding']['right'] ) && ! empty( $attributes['iconBoxStyles']['padding']['right'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['iconBoxStyles']['padding']['bottom'] ) && ! empty( $attributes['iconBoxStyles']['padding']['bottom'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['iconBoxStyles']['padding']['left'] ) && ! empty( $attributes['iconBoxStyles']['padding']['left'] ) ? esc_attr( $attributes['iconBoxStyles']['padding']['left'] ) : '',
	),
	'border'        => array(
		'width' => isset( $attributes['iconBoxStyles']['borderWidth'] ) && ! empty( $attributes['iconBoxStyles']['borderWidth'] ) ? esc_attr( $attributes['iconBoxStyles']['borderWidth'] ) : '',
		'style' => isset( $attributes['iconBoxStyles']['borderType'] ) ? esc_attr( $attributes['iconBoxStyles']['borderType'] ) : '',
	),
	'radius'        => isset( $attributes['iconBoxStyles']['borderRadius'] ) ? esc_attr( $attributes['iconBoxStyles']['borderRadius'] ) : '',
	'size'          => isset( $attributes['icon']['size'] ) && ! empty( $attributes['icon']['size'] ) ? esc_attr( $attributes['icon']['size'] ) : '',
	'gap'           => isset( $attributes['icon']['gap'] ) && ! empty( $attributes['icon']['gap'] ) ? esc_attr( $attributes['icon']['gap'] ) : '6px',
	'opacity'       => isset( $attributes['icon']['opacity'] ) ? esc_attr( $attributes['icon']['opacity'] ) : '',
	'rotate'        => isset( $attributes['icon']['rotate'] ) ? esc_attr( $attributes['icon']['rotate'] ) : '0',
	'rotate_active' => isset( $attributes['icon']['rotateActive'] ) ? esc_attr( $attributes['icon']['rotateActive'] ) : '',
);
$icon_color  = array(
	'bg'           => isset( $attributes['iconBoxStyles']['bgColor'] ) ? esc_attr( $attributes['iconBoxStyles']['bgColor'] ) : '',
	'border'       => isset( $attributes['iconBoxStyles']['borderColor'] ) ? esc_attr( $attributes['iconBoxStyles']['borderColor'] ) : '',
	'bg_hover'     => isset( $attributes['iconBoxStyles']['bgColorHover'] ) ? esc_attr( $attributes['iconBoxStyles']['bgColorHover'] ) : '',
	'border_hover' => isset( $attributes['iconBoxStyles']['borderColorHover'] ) ? esc_attr( $attributes['iconBoxStyles']['borderColorHover'] ) : '',
	'icon'         => isset( $attributes['icon']['color'] ) ? esc_attr( $attributes['icon']['color'] ) : '',
	'icon_hover'   => isset( $attributes['icon']['colorHover'] ) ? esc_attr( $attributes['icon']['colorHover'] ) : '',
);

$block_styles = "
#$block_id {
    padding-top: {$container_styles['padding']['top']}px;
    padding-right: {$container_styles['padding']['right']}px;
    padding-bottom: {$container_styles['padding']['bottom']}px;
    padding-left: {$container_styles['padding']['left']}px;
    border-style: {$container_styles['border_style']};
    border-top-width: {$container_styles['border_width']['top']}px;
    border-right-width: {$container_styles['border_width']['right']}px;
    border-bottom-width: {$container_styles['border_width']['bottom']}px;
    border-left-width: {$container_styles['border_width']['left']}px;
    border-color: {$container_color['border']};
    border-top-left-radius: {$container_styles['radius']['top']}px;
    border-top-right-radius: {$container_styles['radius']['right']}px;
    border-bottom-right-radius: {$container_styles['radius']['bottom']}px;
    border-bottom-left-radius: {$container_styles['radius']['left']}px;
    background-color: {$container_color['bg']};
}

#$block_id .cozy-accordion-wrapper {
    row-gap: {$container_styles['gap']}px;
}

#$block_id .cozy-block-accordion-item {
    padding-top: {$item_styles['padding']['top']}px;
    padding-right: {$item_styles['padding']['right']}px;
    padding-bottom: {$item_styles['padding']['bottom']}px;
    padding-left: {$item_styles['padding']['left']}px;
    border-style: {$item_styles['border_style']};
    border-top-width: {$item_styles['border_width']['top']}px;
    border-right-width: {$item_styles['border_width']['right']}px;
    border-bottom-width: {$item_styles['border_width']['bottom']}px;
    border-left-width: {$item_styles['border_width']['left']}px;
    border-color: {$item_color['border']};
    border-top-left-radius: {$item_styles['radius']['top']}px;
    border-top-right-radius: {$item_styles['radius']['right']}px;
    border-bottom-right-radius: {$item_styles['radius']['bottom']}px;
    border-bottom-left-radius: {$item_styles['radius']['left']}px;
    background-color: {$item_color['bg']};
}

#$block_id .cozy-block-accordion-item .cozy-accordion-title {
	gap: {$icon_styles['gap']};
}
#$block_id .cozy-block-accordion-item .cozy-accordion-title * {
    margin-top: {$title_styles['margin']['top']};
    margin-bottom: {$title_styles['margin']['bottom']};
    font-size: {$title_styles['font']['size']}px;
    font-weight: {$title_styles['font']['weight']};
    font-family: '{$title_styles['font']['family']}';
    text-transform: {$title_styles['letter_case']};
    text-decoration: {$title_styles['decoration']};
    line-height: {$title_styles['line_height']};
    letter-spacing: {$title_styles['letter_spacing']};
    color: {$title_color['text']};
}
#$block_id .cozy-block-accordion-item .cozy-accordion-title.active * {
    color: {$title_color['active']};
}

#$block_id .cozy-block-accordion-item .cozy-accordion-content {
    font-size: {$content_styles['font']['size']}px;
    font-weight: {$content_styles['font']['weight']};
    font-family: {$content_styles['font']['family']};
    text-transform: {$content_styles['letter_case']};
    text-decoration: {$content_styles['decoration']};
    line-height: {$content_styles['line_height']};
    letter-spacing: {$content_styles['letter_spacing']};
    color: {$content_color['text']};
}

#$block_id .cozy-accordion-title .accordion-icon-wrapper svg {
    width: {$icon_styles['size']}px;
    height: {$icon_styles['size']}px;
    opacity: {$icon_styles['opacity']};
    transform: rotate({$icon_styles['rotate']}deg);
}

#$block_id.icon-view-stacked .cozy-accordion-title .accordion-icon-wrapper {
    padding-top: {$icon_styles['padding']['top']}px;
    padding-right: {$icon_styles['padding']['right']}px;
    padding-bottom: {$icon_styles['padding']['bottom']}px;
    padding-left: {$icon_styles['padding']['left']}px;
    border-width: {$icon_styles['border']['width']}px 
    border-style: {$icon_styles['border']['style']}; 
    border-color: {$icon_color['border']};
    border-radius: {$icon_styles['radius']}px;
    background-color: {$icon_color['bg']};
}

#$block_id.icon-view-stacked .cozy-accordion-title.active .accordion-icon-wrapper {
    background-color: {$icon_color['bg_hover']};
    border-color: {$icon_color['border_hover']};
}

#$block_id.icon-layout-fill .cozy-accordion-title .accordion-icon-wrapper svg {
    fill: {$icon_color['icon']};
}

#$block_id.icon-layout-outline .cozy-accordion-title .accordion-icon-wrapper svg {
    stroke: {$icon_color['icon']};
    fill: none;
}

#$block_id.icon-layout-fill .cozy-accordion-title.active .accordion-icon-wrapper svg {
    fill: {$icon_color['icon_hover']};
    transform: rotate({$icon_styles['rotate_active']}deg);
}

#$block_id.icon-layout-outline .cozy-accordion-title.active .accordion-icon-wrapper svg {
    stroke: {$icon_color['icon_hover']};
    fill: none;
    transform: rotate({$icon_styles['rotate_active']}deg);
}
";

$font_families = array();

if ( isset( $attributes['titleTypography']['fontFamily'] ) && ! empty( $attributes['titleTypography']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['titleTypography']['fontFamily'] );
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

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div class="cozy-block-wrapper">
	<div <?php echo $wrapper_attributes; ?>>
		<?php echo $content; ?>
	</div>
</div>
