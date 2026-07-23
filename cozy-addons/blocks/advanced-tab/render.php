<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['blockClientId'] ) ) : '';
$cozy_block_var = 'cozyAdvancedTab_' . str_replace( '-', '_', $client_id );
wp_localize_script( 'cozy-block--advanced-tab--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--advanced-tab--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockAdvancedTabInit( "' . $client_id . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$container_color = array(
	'border' => isset( $attributes['containerStyles']['border']['color'] ) ? esc_attr( $attributes['containerStyles']['border']['color'] ) : '',
	'bg'     => isset( $attributes['containerStyles']['bgColor'] ) ? esc_attr( $attributes['containerStyles']['bgColor'] ) : '',
);
$container       = array(
	'align'   => isset( $attributes['tabAlign'] ) ? esc_attr( sanitize_text_field( $attributes['tabAlign'] ) ) : '',
	'padding' => array(
		'top'    => isset( $attributes['containerStyles']['padding']['top'] ) && ! empty( $attributes['containerStyles']['padding']['top'] ) ? esc_attr( $attributes['containerStyles']['padding']['top'] ) : '0',
		'right'  => isset( $attributes['containerStyles']['padding']['right'] ) && ! empty( $attributes['containerStyles']['padding']['right'] ) ? esc_attr( $attributes['containerStyles']['padding']['top'] ) : '0',
		'bottom' => isset( $attributes['containerStyles']['padding']['bottom'] ) && ! empty( $attributes['containerStyles']['padding']['bottom'] ) ? esc_attr( $attributes['containerStyles']['padding']['top'] ) : '0',
		'left'   => isset( $attributes['containerStyles']['padding']['left'] ) && ! empty( $attributes['containerStyles']['padding']['left'] ) ? esc_attr( $attributes['containerStyles']['padding']['top'] ) : '0',
	),
	'border'  => array(
		'style'        => isset( $attributes['containerStyles']['border']['type'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['border']['type'] ) ) : '',
		'width_top'    => isset( $attributes['containerStyles']['border']['width']['top'] ) && ! empty( $attributes['containerStyles']['border']['width']['top'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['top'] ) : '0',
		'width_right'  => isset( $attributes['containerStyles']['border']['width']['right'] ) && ! empty( $attributes['containerStyles']['border']['width']['right'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['right'] ) : '0',
		'width_bottom' => isset( $attributes['containerStyles']['border']['width']['bottom'] ) && ! empty( $attributes['containerStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['bottom'] ) : '0',
		'width_left'   => isset( $attributes['containerStyles']['border']['width']['left'] ) && ! empty( $attributes['containerStyles']['border']['width']['left'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['left'] ) : '0',
	),
	'radius'  => array(
		'top'    => isset( $attributes['containerStyles']['borderRadius']['top'] ) && ! empty( $attributes['containerStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['top'] ) : '0',
		'right'  => isset( $attributes['containerStyles']['borderRadius']['right'] ) && ! empty( $attributes['containerStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['right'] ) : '0',
		'bottom' => isset( $attributes['containerStyles']['borderRadius']['bottom'] ) && ! empty( $attributes['containerStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['bottom'] ) : '0',
		'left'   => isset( $attributes['containerStyles']['borderRadius']['left'] ) && ! empty( $attributes['containerStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['left'] ) : '0',
	),
);

$title_color  = array(
	'text' => isset( $attributes['titleTypography']['color'] ) ? esc_attr( $attributes['titleTypography']['color'] ) : '',
);
$title_styles = array(
	'gap'            => isset( $attributes['titleStyles']['gap'] ) ? esc_attr( $attributes['titleStyles']['gap'] ) : '',
	'flex_wrap'      => isset( $attributes['titleStyles']['flexWrap'] ) && $attributes['titleStyles']['flexWrap'] ? 'wrap' : 'nowrap',
	'font'           => array(
		'size'   => isset( $attributes['titleTypography']['fontSize'] ) ? esc_attr( $attributes['titleTypography']['fontSize'] ) : '',
		'weight' => isset( $attributes['titleTypography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['titleTypography']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['titleTypography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['titleTypography']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['titleTypography']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['titleTypography']['lineHeight'] ) ? esc_attr( $attributes['titleTypography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['titleTypography']['letterSpacing'] ) ? esc_attr( $attributes['titleTypography']['letterSpacing'] ) : '',
);

$tab_title_color = array(
	'border' => isset( $attributes['separatorStyles']['border']['color'] ) ? esc_attr( $attributes['separatorStyles']['border']['color'] ) : '',
	'text'   => isset( $attributes['typography']['color'] ) ? esc_attr( $attributes['typography']['color'] ) : '',
);

$tab_width  = isset( $attributes['tabStyles']['width'] ) ? $attributes['tabStyles']['width'] : '';
$tab_after  = isset( $attributes['enableTabAfter'] ) && $attributes['enableTabAfter'] ? esc_attr( $attributes['separatorStyles']['border']['width']['bottom'] ) . 'px' : '';
$tab_color  = array(
	'border'        => isset( $attributes['tabStyles']['border']['color'] ) ? $attributes['tabStyles']['border']['color'] : '',
	'bg'            => isset( $attributes['tabStyles']['bgColor'] ) ? $attributes['tabStyles']['bgColor'] : '',
	'active_bg'     => isset( $attributes['tabStyles']['bgColorActive'] ) ? $attributes['tabStyles']['bgColorActive'] : '',
	'active_text'   => isset( $attributes['typography']['colorActive'] ) ? $attributes['typography']['colorActive'] : '',
	'active_border' => isset( $attributes['tabStyles']['border']['colorActive'] ) ? $attributes['tabStyles']['border']['colorActive'] : '',
);
$tab_styles = array(
	'gap'            => isset( $attributes['columnGap'] ) ? esc_attr( $attributes['columnGap'] ) : '',
	'row_gap'        => isset( $attributes['rowGap'] ) ? esc_attr( $attributes['rowGap'] ) : '',
	'icon_gap'       => isset( $attributes['iconSpacing'] ) ? esc_attr( $attributes['iconSpacing'] ) : '',
	'align'          => isset( $attributes['tabAlign'] ) ? esc_attr( sanitize_text_field( $attributes['tabAlign'] ) ) : '',
	'sep_padding'    => array(
		'top'    => isset( $attributes['separatorStyles']['padding']['top'] ) && ! empty( $attributes['separatorStyles']['padding']['top'] ) ? esc_attr( $attributes['separatorStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['separatorStyles']['padding']['right'] ) && ! empty( $attributes['separatorStyles']['padding']['right'] ) ? esc_attr( $attributes['separatorStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['separatorStyles']['padding']['bottom'] ) && ! empty( $attributes['separatorStyles']['padding']['bottom'] ) ? esc_attr( $attributes['separatorStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['separatorStyles']['padding']['left'] ) && ! empty( $attributes['separatorStyles']['padding']['left'] ) ? esc_attr( $attributes['separatorStyles']['padding']['left'] ) : '',
	),
	'sep_border'     => array(
		'style'        => isset( $attributes['separatorStyles']['border']['type'] ) ? esc_attr( sanitize_text_field( $attributes['separatorStyles']['border']['type'] ) ) : '',
		'width_top'    => isset( $attributes['separatorStyles']['border']['width']['top'] ) && ! empty( $attributes['separatorStyles']['border']['width']['top'] ) ? esc_attr( $attributes['separatorStyles']['border']['width']['top'] ) : '0',
		'width_right'  => isset( $attributes['separatorStyles']['border']['width']['right'] ) && ! empty( $attributes['separatorStyles']['border']['width']['right'] ) ? esc_attr( $attributes['separatorStyles']['border']['width']['right'] ) : '0',
		'width_bottom' => isset( $attributes['separatorStyles']['border']['width']['bottom'] ) && ! empty( $attributes['separatorStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['separatorStyles']['border']['width']['bottom'] ) : '0',
		'width_left'   => isset( $attributes['separatorStyles']['border']['width']['left'] ) && ! empty( $attributes['separatorStyles']['border']['width']['left'] ) ? esc_attr( $attributes['separatorStyles']['border']['width']['left'] ) : '0',
	),
	'padding'        => array(
		'top'    => isset( $attributes['tabStyles']['padding']['top'] ) ? esc_attr( $attributes['tabStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['tabStyles']['padding']['right'] ) ? esc_attr( $attributes['tabStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['tabStyles']['padding']['bottom'] ) ? esc_attr( $attributes['tabStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['tabStyles']['padding']['left'] ) ? esc_attr( $attributes['tabStyles']['padding']['left'] ) : '',
	),
	'border'         => array(
		'style'        => isset( $attributes['tabStyles']['border']['type'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['border']['type'] ) ) : '',
		'width_top'    => isset( $attributes['tabStyles']['border']['width']['top'] ) && ! empty( $attributes['tabStyles']['border']['width']['top'] ) ? esc_attr( $attributes['tabStyles']['border']['width']['top'] ) : '',
		'width_right'  => isset( $attributes['tabStyles']['border']['width']['right'] ) && ! empty( $attributes['tabStyles']['border']['width']['right'] ) ? esc_attr( $attributes['tabStyles']['border']['width']['right'] ) : '',
		'width_bottom' => isset( $attributes['tabStyles']['border']['width']['bottom'] ) && ! empty( $attributes['tabStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['tabStyles']['border']['width']['bottom'] ) : '',
		'width_left'   => isset( $attributes['tabStyles']['border']['width']['left'] ) && ! empty( $attributes['tabStyles']['border']['width']['left'] ) ? esc_attr( $attributes['tabStyles']['border']['width']['left'] ) : '',
	),
	'radius'         => array(
		'top'    => isset( $attributes['tabStyles']['borderRadius']['top'] ) && ! empty( $attributes['tabStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['tabStyles']['borderRadius']['top'] ) : '',
		'right'  => isset( $attributes['tabStyles']['borderRadius']['right'] ) && ! empty( $attributes['tabStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['tabStyles']['borderRadius']['right'] ) : '',
		'bottom' => isset( $attributes['tabStyles']['borderRadius']['bottom'] ) && ! empty( $attributes['tabStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['tabStyles']['borderRadius']['bottom'] ) : '',
		'left'   => isset( $attributes['tabStyles']['borderRadius']['left'] ) && ! empty( $attributes['tabStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['tabStyles']['borderRadius']['left'] ) : '',
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

$icon_styles = array(
	'size' => isset( $attributes['iconSize'] ) ? esc_attr( $attributes['iconSize'] ) : '',
);
$icon_color  = array(
	'icon'        => isset( $attributes['typography']['color'] ) ? $attributes['typography']['color'] : '',
	'active_icon' => isset( $attributes['typography']['colorActive'] ) ? $attributes['typography']['colorActive'] : '',
);

$content_styles = array(
	'padding' => array(
		'top'    => isset( $attributes['contentStyles']['padding']['top'] ) ? esc_attr( $attributes['contentStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['contentStyles']['padding']['right'] ) ? esc_attr( $attributes['contentStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['contentStyles']['padding']['bottom'] ) ? esc_attr( $attributes['contentStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['contentStyles']['padding']['left'] ) ? esc_attr( $attributes['contentStyles']['padding']['left'] ) : '',
	),
	'margin'  => isset( $attributes['contentStyles']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['contentStyles']['margin'] ) : '',
	'border'  => array(
		'style'        => isset( $attributes['contentStyles']['border']['type'] ) ? esc_attr( sanitize_text_field( $attributes['contentStyles']['border']['type'] ) ) : '',
		'width_top'    => isset( $attributes['contentStyles']['border']['width']['top'] ) ? esc_attr( $attributes['contentStyles']['border']['width']['top'] ) : '',
		'width_right'  => isset( $attributes['contentStyles']['border']['width']['right'] ) ? esc_attr( $attributes['contentStyles']['border']['width']['right'] ) : '',
		'width_bottom' => isset( $attributes['contentStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['contentStyles']['border']['width']['bottom'] ) : '',
		'width_left'   => isset( $attributes['contentStyles']['border']['width']['left'] ) ? esc_attr( $attributes['contentStyles']['border']['width']['left'] ) : '',
	),
	'radius'  => array(
		'top'    => isset( $attributes['contentStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['contentStyles']['borderRadius']['top'] ) : '',
		'right'  => isset( $attributes['contentStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['contentStyles']['borderRadius']['right'] ) : '',
		'bottom' => isset( $attributes['contentStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['contentStyles']['borderRadius']['bottom'] ) : '',
		'left'   => isset( $attributes['contentStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['contentStyles']['borderRadius']['left'] ) : '',
	),
);
$content_color  = array(
	'border' => isset( $attributes['contentStyles']['border']['color'] ) ? esc_attr( $attributes['contentStyles']['border']['color'] ) : '',
	'bg'     => isset( $attributes['contentStyles']['bgColor'] ) ? esc_attr( $attributes['contentStyles']['bgColor'] ) : '',
);

$block_styles = "
#$block_id {
    padding-top: {$container['padding']['top']}px;
    padding-right: {$container['padding']['right']}px;
    padding-bottom: {$container['padding']['bottom']}px;
    padding-left: {$container['padding']['left']}px;
    border-style: {$container['border']['style']};
    border-top-width: {$container['border']['width_top']}px;
    border-right-width: {$container['border']['width_right']}px;
    border-bottom-width: {$container['border']['width_bottom']}px;
    border-left-width: {$container['border']['width_left']}px;
    border-color: {$container_color['border']};
    border-top-left-radius: {$container['radius']['top']}px;
    border-top-right-radius: {$container['radius']['right']}px;
    border-bottom-right-radius: {$container['radius']['bottom']}px;
    border-bottom-left-radius: {$container['radius']['left']}px;
    background-color: {$container_color['bg']};
}

#$block_id .advanced-tab-title {
    font-size: {$title_styles['font']['size']}px;
    font-weight: {$title_styles['font']['weight']};
    font-family: {$title_styles['font']['family']};
    color: {$title_color['text']};
    text-tranform: {$title_styles['letter_case']};
    text-decoration: {$title_styles['decoration']};
    line-height: {$title_styles['line_height']};
    letter-spacing: {$title_styles['letter_spacing']};
}

#$block_id .cozy-tab-title {
    padding-top: {$tab_styles['sep_padding']['top']}px;
    padding-right: {$tab_styles['sep_padding']['right']}px;
    padding-bottom: {$tab_styles['sep_padding']['bottom']}px;
    padding-left: {$tab_styles['sep_padding']['left']}px;
    border-style: {$tab_styles['sep_border']['style']};
    border-top-width: {$tab_styles['sep_border']['width_top']}px;
    border-right-width: {$tab_styles['sep_border']['width_right']}px;
    border-bottom-width: {$tab_styles['sep_border']['width_bottom']}px;
    border-left-width: {$tab_styles['sep_border']['width_left']}px;
    border-color: {$tab_title_color['border']};
    font-size: {$tab_styles['font']['size']}px;
    font-weight: {$tab_styles['font']['weight']};
    font-family: {$tab_styles['font']['family']};
    text-tranform: {$tab_styles['letter_case']};
    text-decoration: {$tab_styles['decoration']};
    line-height: {$tab_styles['line_height']};
    letter-spacing: {$tab_styles['letter_spacing']};
    color: {$tab_title_color['text']};
}

#$block_id .layout-wrapper {
    gap: {$title_styles['gap']};
    flex-wrap: {$title_styles['flex_wrap']};
}
#$block_id.layout-horizontal .layout-wrapper {
    justify-content: {$container['align']};
}
#$block_id.layout-horizontal .cozy-tab-title {
    gap: {$tab_styles['gap']}px;
    justify-content: {$tab_styles['align']};
}

#$block_id .cozy-tab-title .cozy-tab-button {
    padding-top: {$tab_styles['padding']['top']}px;
    padding-right: {$tab_styles['padding']['right']}px;
    padding-bottom: {$tab_styles['padding']['bottom']}px;
    padding-left: {$tab_styles['padding']['left']}px;
    border-style: {$tab_styles['border']['style']};
    border-top-width: {$tab_styles['border']['width_top']}px;
    border-right-width: {$tab_styles['border']['width_right']}px;
    border-bottom-width: {$tab_styles['border']['width_bottom']}px;
    border-left-width: {$tab_styles['border']['width_left']}px;
    border-color: {$tab_color['border']};
    border-top-left-radius: {$tab_styles['radius']['top']}px;
    border-top-right-radius: {$tab_styles['radius']['right']}px;
    border-bottom-right-radius: {$tab_styles['radius']['bottom']}px;
    border-bottom-left-radius: {$tab_styles['radius']['left']}px;
    background-color: {$tab_color['bg']};
}

#$block_id.layout-vertical .cozy-tab-title .cozy-tab-button {
    width: {$tab_width}px;
}
#$block_id.layout-vertical {
    gap: {$tab_styles['gap']}px;
}
#$block_id.layout-vertical .cozy-tab-title {
    gap: {$tab_styles['row_gap']}px;
}
@media only screen and (max-width: 767px) {
    #$block_id.layout-vertical .layout-wrapper {
        margin-bottom: {$tab_styles['gap']}px;
    }
    #$block_id.layout-vertical .cozy-tab-title .cozy-tab-button {
        max-width: {$tab_width}px;
        width: 100%;
    }
}

#$block_id .cozy-tab-title .cozy-tab-button .display-flex {
    gap: {$tab_styles['icon_gap']}px;
}

#$block_id .cozy-tab-title .cozy-tab-button.active {
    border-color: {$tab_color['active_border']};
    background-color: {$tab_color['active_bg']};
    color: {$tab_color['active_text']};
}

#$block_id .cozy-tab-title .cozy-tab-button.active:after {
    height: {$tab_after};
    bottom: -{$tab_styles['sep_border']['width_bottom']}px;
    background-color: {$tab_color['active_bg']};
}

#$block_id .cozy-tab-title .cozy-tab-button .cozy-tab-icon {
    width: {$icon_styles['size']}px;
    height: {$icon_styles['size']}px;
}

#$block_id.icon-layout-fill .cozy-tab-title .cozy-tab-button .cozy-tab-icon {
    fill: {$icon_color['icon']};
}

#$block_id.icon-layout-outline .cozy-tab-title .cozy-tab-button .cozy-tab-icon {
    stroke: {$icon_color['icon']};
    fill: none;
}

#$block_id.icon-layout-fill .cozy-tab-title .cozy-tab-button.active .cozy-tab-icon {
    fill: {$icon_color['active_icon']};
}

#$block_id.icon-layout-outline .cozy-tab-title .cozy-tab-button.active .cozy-tab-icon {
    stroke: {$icon_color['active_icon']};
    fill: none;
}

#$block_id .cozy-advanced-tab-wrapper {
    padding-top: {$content_styles['padding']['top']}px;
    padding-right: {$content_styles['padding']['right']}px;
    padding-bottom: {$content_styles['padding']['bottom']}px;
    padding-left: {$content_styles['padding']['left']}px;
    {$content_styles['margin']}
    border-style: {$content_styles['border']['style']};
    border-top-width: {$content_styles['border']['width_top']}px;
    border-right-width: {$content_styles['border']['width_right']}px;
    border-bottom-width: {$content_styles['border']['width_bottom']}px;
    border-left-width: {$content_styles['border']['width_left']}px;
    border-color: {$content_color['border']};
    border-top-left-radius: {$content_styles['radius']['top']}px;
    border-top-right-radius: {$content_styles['radius']['right']}px;
    border-bottom-right-radius: {$content_styles['radius']['bottom']}px;
    border-bottom-left-radius: {$content_styles['radius']['left']}px;
    background-color: {$content_color['bg']};
}
";

$output = '<div class="cozy-block-wrapper">';

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

$output .= $content;
$output .= '</div>';

echo $output;
