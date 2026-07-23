<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['blockClientId'] ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$separator_icons = array(
	'greater-than'    => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 4.5L4.5 6.117L17.398 12L4.5 17.883L4.5 19.5L19.5 12.585L19.5 11.415Z" /></svg>',
	'less-than'       => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M19.5 4.5L19.5 6.117L6.602 12L19.5 17.883L19.5 19.5L4.5 12.585L4.5 11.415Z"/></svg>',
	'chevron-right'   => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M6 17L11 12L6 7M13 17L18 12L13 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	'chevron-left'    => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M18 17L13 12L18 7M11 17L6 12L11 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	'right-arrow'     => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2929 4.29289C12.6834 3.90237 13.3166 3.90237 13.7071 4.29289L20.7071 11.2929C21.0976 11.6834 21.0976 12.3166 20.7071 12.7071L13.7071 19.7071C13.3166 20.0976 12.6834 20.0976 12.2929 19.7071C11.9024 19.3166 11.9024 18.6834 12.2929 18.2929L17.5858 13H4C3.44772 13 3 12.5523 3 12C3 11.4477 3.44772 11 4 11H17.5858L12.2929 5.70711C11.9024 5.31658 11.9024 4.68342 12.2929 4.29289Z" fill="currentColor"/></svg>',
	'left-arrow'      => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.7071 4.29289C12.0976 4.68342 12.0976 5.31658 11.7071 5.70711L6.41421 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H6.41421L11.7071 18.2929C12.0976 18.6834 12.0976 19.3166 11.7071 19.7071C11.3166 20.0976 10.6834 20.0976 10.2929 19.7071L3.29289 12.7071C3.10536 12.5196 3 12.2652 3 12C3 11.7348 3.10536 11.4804 3.29289 11.2929L10.2929 4.29289C10.6834 3.90237 11.3166 3.90237 11.7071 4.29289Z" fill="currentColor"/></svg>',
	'right-arrowhead' => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M9.75 18.7L17.7 12L9.75 5.3C8.9 4.5 7.5 5.1 7.5 6.3V17.7C7.5 18.9 8.9 19.5 9.75 18.7Z" fill="currentColor"/></svg>',
	'left-arrowhead'  => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M14.25 5.3L6.3 12L14.25 18.7C15.1 19.5 16.5 18.9 16.5 17.7V6.3C16.5 5.1 15.1 4.5 14.25 5.3Z" fill="currentColor"/></svg>',
	'forward-slash'   => '<svg viewBox="-2 0 28 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M16 3L8 21" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	'backslash'       => '<svg viewBox="-2 0 28 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M8 3L16 21" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	'pipe'            => '<svg viewBox="-2 0 28 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 21V3" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	'hyphen'          => '<svg viewBox="-6.5 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M13.875 12.906v2.281h-8.563v-2.281h8.563z"/></svg>',
	'bullet'          => '<svg viewBox="0 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M12.096 16q0 1.632 1.152 2.784t2.752 1.12 2.752-1.12 1.152-2.784-1.152-2.752-2.752-1.152-2.752 1.152-1.152 2.752z"/></svg>',
);

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
	'link_color'     => isset( $attributes['typography']['linkColor'] ) ? esc_attr( $attributes['typography']['linkColor'] ) : '',
	'hover_color'    => isset( $attributes['typography']['hoverColor'] ) ? esc_attr( $attributes['typography']['hoverColor'] ) : '',
	'color'          => isset( $attributes['typography']['color'] ) ? esc_attr( $attributes['typography']['color'] ) : '',
);

$separator_slug = isset( $attributes['separator']['slug'] ) ? esc_attr( $attributes['separator']['slug'] ) : 'greater-than';
$separator_size = isset( $attributes['separator']['size'] ) ? esc_attr( $attributes['separator']['size'] ) : '';

$separator_svg   = isset( $separator_icons[ $separator_slug ] ) ? $separator_icons[ $separator_slug ] : $separator_icons['greater-than'];
$separator_color = isset( $attributes['separator']['color'] ) ? esc_attr( $attributes['separator']['color'] ) : $typography['color'];
$output          = '<div class="cozy-block-wrapper">';

$styles = array(
	'gap' => isset( $attributes['gap'] ) ? esc_attr( $attributes['gap'] ) : '',
);


$block_styles = "
#$block_id {
	font-size: {$typography['font']['size']}px;
	font-weight: {$typography['font']['weight']};
	font-family: {$typography['font']['family']};
	color: {$typography['color']};
	gap: {$styles['gap']};
	text-transform: {$typography['letter_case']};
	line-height: {$typography['line_height']};
	letter-spacing: {$typography['letter_spacing']};
}
#$block_id a {
	color:{$typography['link_color']};
	text-decoration: {$typography['decoration']} !important;
}
#$block_id a:hover{
	color:{$typography['hover_color']};
}
#$block_id svg {
	width: $separator_size;
	height: $separator_size;
	color: $separator_color;
}";

$font_families = array();

if ( isset( $attributes['typography']['fontFamily'] ) && ! empty( $attributes['typography']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['typography']['fontFamily'] );
}
$font_families = array_unique( $font_families );
$font_query    = '';
foreach ( $font_families as $key => $family ) {
	if ( 0 === $key ) {
		$font_query .= 'family=' . str_replace( ' ', '+', esc_attr( $family ) ) . ':wght@100;200;300;400;500;600;700;800;900';
	} else {
		$font_query .= '&family=' . str_replace( ' ', '+', esc_attr( $family ) ) . ':wght@100;200;300;400;500;600;700;800;900';
	}
}
if ( ! empty( $font_query ) ) {
	$google_fonts_url = 'https://fonts.googleapis.com/css2?' . $font_query . '&display=swap';
	echo '<link rel="stylesheet" href="' . $google_fonts_url . '"/>';
}

if ( ! is_home() ) {
	add_action(
		'wp_enqueue_scripts',
		function () use ( $block_styles ) {
			wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
		}
	);

	$output .= '<p class="cozy-block-breadcrumb" id="' . esc_attr( $block_id ) . '">';
	$output .= '<a href="' . home_url( '/' ) . '">' . esc_html( $attributes['homeLabel'] ) . '</a>';

	if ( is_category() ) {
		$category_id  = get_queried_object_id();
		$parent_chain = get_category_parents( $category_id, true, '', false );
		$output      .= $separator_svg . $parent_chain;
	} elseif ( is_single() ) {
		$categories = get_the_category();
		if ( $categories ) {
			$output .= $separator_svg . '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
		}
		$output .= $separator_svg . get_the_title();
	} elseif ( is_page() ) {
		$ancestors = array_reverse( get_post_ancestors( get_the_ID() ) );
		foreach ( $ancestors as $ancestor_id ) {
			$output .= $separator_svg . '<a href="' . esc_url( get_permalink( $ancestor_id ) ) . '">' . esc_html( get_the_title( $ancestor_id ) ) . '</a>';
		}
		$output .= $separator_svg . the_title( '', '', false );
	}

	$output .= '</p>';
}

$output .= '</div>';

echo $output;
