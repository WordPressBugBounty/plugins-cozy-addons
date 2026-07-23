<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $block->context['postId'] ) ) {
	return '';
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['clientId'] ) ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

if ( ! function_exists( 'render_cozy_block_post_comments_icon' ) ) {
	function render_cozy_block_post_comments_icon( $attributes, $post_comments_count ) {
		if ( $attributes['enableOptions']['icon'] && isset( $post_comments_count ) && ! empty( $post_comments_count ) && '0' != $post_comments_count ) {
			$icon_fill      = 'fill' === $attributes['icon']['layout'] ? esc_attr( $attributes['icon']['color'] ) : 'none';
			$icon_stroke    = 'outline' === $attributes['icon']['layout'] ? esc_attr( $attributes['icon']['color'] ) : 'none';
			$stroke_width   = 'outline' === $attributes['icon']['layout'] ? cozy_addons_sanitize_dimension( $attributes['icon']['strokeWidth'] ) : '';
			$stroke_opacity = 'outline' === $attributes['icon']['layout'] ? cozy_addons_sanitize_dimension( $attributes['icon']['opacity'] ) / 100 : '';
			$icon_size      = isset( $attributes['icon']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['size'] ) : '';
			$viewbox        = array();
			$viewbox[]      = isset( $attributes['icon']['viewBox']['vx'] ) ? $attributes['icon']['viewBox']['vx'] : '';
			$viewbox[]      = isset( $attributes['icon']['viewBox']['vy'] ) ? $attributes['icon']['viewBox']['vy'] : '';
			$viewbox[]      = isset( $attributes['icon']['viewBox']['vw'] ) ? $attributes['icon']['viewBox']['vw'] : '';
			$viewbox[]      = isset( $attributes['icon']['viewBox']['vh'] ) ? $attributes['icon']['viewBox']['vh'] : '';
			$view_box       = esc_attr( implode( ' ', array_map( 'intval', array_values( $viewbox ) ) ) );
			$icon_path      = isset( $attributes['icon']['path'] ) ? esc_attr( $attributes['icon']['path'] ) : '';

			$classes   = array();
			$classes[] = 'cozy-block-post-comments__icon-wrapper';
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

$cozy_post_id        = $block->context['postId'];
$post_comments_count = get_comments_number( $cozy_post_id );
$post_comments_link  = get_comments_link( $cozy_post_id );

$wrapper_attributes = get_block_wrapper_attributes();

$classes   = array();
$classes[] = 'display-' . $attributes['display'];

$block_extra_classes = esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) );

$styles = array(
	'align'   => isset( $attributes['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['textAlign'] ) ) : '',
	'justify' => isset( $attributes['contentJustify'] ) ? esc_attr( sanitize_text_field( $attributes['contentJustify'] ) ) : '',
	'gap'     => isset( $attributes['contentGap'] ) ? cozy_addons_sanitize_dimension( $attributes['contentGap'] ) : '',
);

$icon_box_padding = isset( $attributes['iconBox']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['iconBox']['padding'] ) : '';
$icon_box_border  = isset( $attributes['iconBox']['border'] ) ? cozy_render_TRBL( 'border', $attributes['iconBox']['border'] ) : '';
$icon_styles      = array(
	'gap'        => isset( $attributes['icon']['gap'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['gap'] ) : '',
	'radius'     => isset( $attributes['iconBox']['borderRadius'] ) ? cozy_addons_sanitize_dimension( $attributes['iconBox']['borderRadius'] ) : '',
	'rotate'     => isset( $attributes['icon']['rotate'] ) ? cozy_addons_sanitize_dimension( $attributes['icon']['rotate'] ) : '',
	'bg_hover'   => isset( $attributes['iconBox']['bgColorHover'] ) ? esc_attr( $attributes['iconBox']['bgColorHover'] ) : '',
	'icon_hover' => isset( $attributes['icon']['colorHover'] ) ? esc_attr( $attributes['icon']['colorHover'] ) : '',
	'bg'         => isset( $attributes['iconBox']['bgColor'] ) ? esc_attr( $attributes['iconBox']['bgColor'] ) : '',
	'text'       => isset( $attributes['label']['color'] ) ? esc_attr( $attributes['label']['color'] ) : '',
);

$label = array(
	'font'           => array(
		'size'   => isset( $attributes['label']['fontSize'] ) ? cozy_addons_sanitize_dimension( $attributes['label']['fontSize'] ) : '',
		'weight' => isset( $attributes['label']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['label']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['label']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['label']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['label']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['label']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['label']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['label']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['label']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['label']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['label']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['label']['letterSpacing'] ) : '',
);


$block_styles = "
#$block_id.display-block {
    text-align: {$styles['align']};
}
#$block_id.display-block .cozy-block-post-comments__wrapper {
    justify-content: {$styles['align']};
    margin: {$styles['gap']} 0;
}
#$block_id.display-inline {
    justify-content: {$styles['justify']};
    gap: {$styles['gap']};
}

#$block_id .cozy-block-post-comments__wrapper {
	gap: {$icon_styles['gap']}
}
#$block_id .cozy-block-post-comments__wrapper:hover .cozy-block-post-comments__icon-wrapper {
    background-color: {$icon_styles['bg_hover']};
}
#$block_id .cozy-block-post-comments__wrapper:hover .cozy-block-post-comments__icon-wrapper.layout-fill > .cozy-block-post-comments__icon {
    fill: {$icon_styles['icon_hover']};
}
#$block_id .cozy-block-post-comments__wrapper:hover .cozy-block-post-comments__icon-wrapper.layout-outline > .cozy-block-post-comments__icon {
    stroke: {$icon_styles['icon_hover']};
}

#$block_id .cozy-block-post-comments__icon-wrapper.view-stacked {
	{$icon_box_padding}
	{$icon_box_border}
	border-radius: {$icon_styles['radius']};
	background-color: {$icon_styles['bg']};
}
#$block_id .cozy-block-post-comments__icon {
	transform: rotate({$icon_styles['rotate']}deg);
}

#$block_id .cozy-block-post-comments__label {
	font-size: {$label['font']['size']};
	font-weight: {$label['font']['weight']};
	font-family: {$label['font']['family']};
	text-transform: {$label['letter_case']};
	text-decoration: {$label['decoration']};
	line-height: {$label['line_height']};
	letter-spacing: {$label['letter_spacing']};
	color: {$icon_styles['text']};
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

$output .= '<div class="cozy-block-post-comments ' . $block_extra_classes . '" id="' . esc_attr( $block_id ) . '">';

if ( $attributes['enableOptions']['labelBefore'] ) {
	$output .= '<p class="cozy-block-post-comments__label cozy-block-post-comments__label-before">' . esc_html( $attributes['labelBefore'] ) . '</p>';
}

$output .= '<div>';

$open_new_tab = isset( $attributes['linkNewTab'] ) && $attributes['linkNewTab'] ? 'target="_blank"' : '';

$output .= '<a class="cozy-block-post-comments__wrapper" href="' . esc_url( $post_comments_link ) . '" ' . $open_new_tab . ' rel="noopener">';
if ( 'before' === $attributes['icon']['position'] ) {
	$output .= render_cozy_block_post_comments_icon( $attributes, $post_comments_count );
}

if ( $attributes['enableOptions']['comments'] ) {
	$output .= isset( $post_comments_count ) && '0' !== $post_comments_count ? '<p class="cozy-block-post-comments__comment-count">' . esc_html( $post_comments_count ) . '</p>' : '';
}

if ( 'after' === $attributes['icon']['position'] ) {
	$output .= render_cozy_block_post_comments_icon( $attributes, $post_comments_count );
}
$output .= '</a>';

$output .= '</div>';

if ( $attributes['enableOptions']['labelAfter'] ) {
	$output .= '<p class="cozy-block-post-comments__label cozy-block-post-comments__label-after">' . esc_html( $attributes['labelAfter'] ) . '</p>';
}

$output .= '</div></div>';

$post_type = $block->context['postType'];

if ( isset( $post_comments_count ) && 'post' === $post_type && ! empty( $post_comments_count ) && '0' != $post_comments_count ) {
	echo $output;
}
