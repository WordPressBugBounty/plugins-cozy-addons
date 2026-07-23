<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $block->context['postId'] ) ) {
	return '';
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['clientId'] ) ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

if ( ! function_exists( 'render_cozy_block_post_views_icon' ) ) {
	function render_cozy_block_post_views_icon( $attributes, $post_views_count ) {
		if ( $attributes['enableOptions']['icon'] && isset( $post_views_count ) && ! empty( $post_views_count ) && '0' != $post_views_count ) {
			$icon_fill      = 'fill' === $attributes['icon']['layout'] ? esc_attr( $attributes['icon']['color'] ) : 'none';
			$icon_stroke    = 'outline' === $attributes['icon']['layout'] ? esc_attr( $attributes['icon']['color'] ) : 'none';
			$stroke_width   = 'outline' === $attributes['icon']['layout'] ? esc_attr( $attributes['icon']['strokeWidth'] ) : '';
			$stroke_opacity = 'outline' === $attributes['icon']['layout'] ? esc_attr( floatval( $attributes['icon']['opacity'] ) / 100 ) : '';

			$icon_size = isset( $attributes['icon']['size'] ) ? esc_attr( $attributes['icon']['size'] ) : '';
			$viewbox   = array();
			$viewbox[] = isset( $attributes['icon']['viewBox']['vx'] ) ? $attributes['icon']['viewBox']['vx'] : '';
			$viewbox[] = isset( $attributes['icon']['viewBox']['vy'] ) ? $attributes['icon']['viewBox']['vy'] : '';
			$viewbox[] = isset( $attributes['icon']['viewBox']['vw'] ) ? $attributes['icon']['viewBox']['vw'] : '';
			$viewbox[] = isset( $attributes['icon']['viewBox']['vh'] ) ? $attributes['icon']['viewBox']['vh'] : '';
			$view_box  = esc_attr( implode( ' ', array_map( 'intval', array_values( $viewbox ) ) ) );
			$icon_path = isset( $attributes['icon']['path'] ) ? esc_attr( $attributes['icon']['path'] ) : '';

			$classes   = array();
			$classes[] = 'cozy-block-post-views__icon-wrapper';
			$classes[] = 'view-' . $attributes['icon']['view'];
			$classes[] = 'layout-' . $attributes['icon']['layout'];

			$sanitized_class = esc_attr( cozy_addons_sanitize_html_class( $classes ) );

			$icon = "
				<div class='{$sanitized_class}'>
					<svg
						width='{$icon_size}'
						height='{$icon_size}'
						class='cozy-block-post-comments__icon'
						xmlns='http://www.w3.org/2000/svg'
						viewBox='{$view_box}'
						aria-hidden='true'
						fill='{$icon_fill}'
						stroke='{$icon_stroke}'
						stroke-width='{$stroke_width}'
						stroke-opacity='{$stroke_opacity}'
					>
						<path d='{$icon_path}'/>
					</svg>
				</div>
			";

			return $icon;
		}

		return '';
	}
}

$cozy_post_id     = $block->context['postId'];
$post_views_count = get_post_meta( $cozy_post_id, 'cozy_post_views_count', true );

$wrapper_attributes = get_block_wrapper_attributes();

$classes   = array();
$classes[] = 'display-' . $attributes['display'];

$block_extra_classes = esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) );

$styles = array(
	'align'   => isset( $attributes['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['textAlign'] ) ) : '',
	'gap'     => isset( $attributes['contentGap'] ) ? esc_attr( $attributes['contentGap'] ) : '',
	'justify' => isset( $attributes['contentJustify'] ) ? esc_attr( sanitize_text_field( $attributes['contentJustify'] ) ) : '',
);

$icon_box_padding = isset( $attributes['iconBox']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['iconBox']['padding'] ) : '';
$icon_box_border  = isset( $attributes['iconBox']['border'] ) ? cozy_render_TRBL( 'border', $attributes['iconBox']['border'] ) : '';
$icon_styles      = array(
	'gap'    => isset( $attributes['icon']['gap'] ) ? esc_attr( $attributes['icon']['gap'] ) : '',
	'radius' => isset( $attributes['iconBox']['borderRadius'] ) ? esc_attr( $attributes['iconBox']['borderRadius'] ) : '',
	'rotate' => isset( $attributes['icon']['rotate'] ) ? esc_attr( $attributes['icon']['rotate'] ) : '',
	'bg'     => isset( $attributes['iconBox']['bgColor'] ) ? esc_attr( $attributes['iconBox']['bgColor'] ) : '',
);

$label_color  = isset( $attributes['label']['color'] ) ? $attributes['label']['color'] : '';
$label_styles = array(
	'font_size'      => isset( $attributes['label']['fontSize'] ) ? esc_attr( $attributes['label']['fontSize'] ) : '',
	'font_weight'    => isset( $attributes['label']['fontWeight'] ) ? esc_attr( $attributes['label']['fontWeight'] ) : '',
	'font_family'    => isset( $attributes['label']['fontFamily'] ) ? esc_attr( $attributes['label']['fontFamily'] ) : '',
	'letter_case'    => isset( $attributes['label']['letterCase'] ) ? esc_attr( $attributes['label']['letterCase'] ) : '',
	'decoration'     => isset( $attributes['label']['decoration'] ) ? esc_attr( $attributes['label']['decoration'] ) : '',
	'line_height'    => isset( $attributes['label']['lineHeight'] ) ? esc_attr( $attributes['label']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['label']['letterSpacing'] ) ? esc_attr( $attributes['label']['letterSpacing'] ) : '',
);

$block_styles = "
#$block_id.display-block {
    text-align: {$styles['align']};
}
#$block_id.display-block .cozy-block-post-views__wrapper {
    justify-content: {$styles['align']};
    margin: {$styles['gap']} 0;
}
#$block_id.display-inline {
    justify-content: {$styles['justify']};
    gap: {$styles['gap']};
}

#$block_id .cozy-block-post-views__wrapper {
	gap: {$icon_styles['gap']}
}

#$block_id .cozy-block-post-views__icon-wrapper.view-stacked {
	{$icon_box_padding}
	{$icon_box_border}
	border-radius: {$icon_styles['radius']};
	background-color: {$icon_styles['bg']};
}
#$block_id .cozy-block-post-views__icon {
	transform: rotate({$icon_styles['rotate']}deg);
}

#$block_id .cozy-block-post-views__label {
	font-size: {$label_styles['font_size']};
	font-weight: {$label_styles['font_weight']};
	font-family: {$label_styles['font_family']};
	text-transform: {$label_styles['letter_case']};
	text-decoration: {$label_styles['decoration']};
	line-height: {$label_styles['line_height']};
	letter-spacing: {$label_styles['letter_spacing']};
	color: {$label_color};
}
";

$output = '<div ' . $wrapper_attributes . '>';

$font_families = array();

if ( isset( $attributes['label']['fontFamily'] ) && ! empty( $attributes['label']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['label']['fontFamily'] );
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

$output .= '<div class="cozy-block-post-views ' . $block_extra_classes . '" id="' . esc_attr( $block_id ) . '">';

if ( $attributes['enableOptions']['labelBefore'] ) {
	$output .= '<p class="cozy-block-post-views__label cozy-block-post-views__label-before">' . esc_html( $attributes['labelBefore'] ) . '</p>';
}

$output .= '<div class="cozy-block-post-views__wrapper">';
if ( 'before' === $attributes['icon']['position'] ) {
	$output .= render_cozy_block_post_views_icon( $attributes, $post_views_count );
}

if ( $attributes['enableOptions']['views'] ) {
	$output .= isset( $post_views_count ) && '0' !== $post_views_count ? '<p class="cozy-block-post-views__view-count">' . esc_html( $post_views_count ) . '</p>' : '';
}

if ( 'after' === $attributes['icon']['position'] ) {
	$output .= render_cozy_block_post_views_icon( $attributes, $post_views_count );
}
$output .= '</div>';

if ( $attributes['enableOptions']['labelAfter'] ) {
	$output .= '<p class="cozy-block-post-views__label cozy-block-post-views__label-after">' . esc_html( $attributes['labelAfter'] ) . '</p>';
}

$output .= '</div></div>';

$post_type = $block->context['postType'];

if ( isset( $post_views_count ) && 'post' === $post_type && ! empty( $post_views_count ) && '0' != $post_views_count ) {
	echo $output;
}
