<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['blockClientId'] ) ) : '';
$cozy_block_var = 'cozyCounter_' . str_replace( '-', '_', $client_id );

wp_localize_script( 'cozy-block--counter--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--counter--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockCounterInit( "' . esc_html( $client_id ) . '" ) }) ' );
$block_id      = 'cozyBlock_' . str_replace( '-', '_', $client_id );
$fallback_size = isset( $attributes['styles']['fontSize'] ) ? esc_attr( $attributes['styles']['fontSize'] ) : '';
$styles        = array(
	'align'          => isset( $attributes['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['textAlign'] ) ) : '',
	'layout'         => isset( $attributes['blockStyle']['layout'] ) ? esc_attr( sanitize_text_field( $attributes['blockStyle']['layout'] ) ) : '',
	'gap'            => isset( $attributes['blockStyle']['gap'] ) ? esc_attr( $attributes['blockStyle']['gap'] ) : '',
	'font'           => array(
		'size'        => isset( $attributes['styles']['desktop']['font']['size'] ) ? esc_attr( $attributes['styles']['desktop']['font']['size'] ) : $fallback_size,
		'tablet_size' => isset( $attributes['styles']['tablet']['font']['size'] ) ? esc_attr( $attributes['styles']['tablet']['font']['size'] ) : '',
		'mobile_size' => isset( $attributes['styles']['mobile']['font']['size'] ) ? esc_attr( $attributes['styles']['mobile']['font']['size'] ) : '',
		'weight'      => isset( $attributes['styles']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['styles']['font']['weight'] ) ) : '',
		'family'      => isset( $attributes['styles']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['styles']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['styles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['styles']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['styles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['styles']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['styles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['styles']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['styles']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['styles']['letterSpacing'] ) : '',
);

$label_styles = array(
	'label_font'     => array(
		'size'        => isset( $attributes['labelStyles']['desktop']['font']['size'] ) ? esc_attr( $attributes['labelStyles']['desktop']['font']['size'] ) : '',
		'tablet_size' => isset( $attributes['labelStyles']['tablet']['font']['size'] ) ? esc_attr( $attributes['labelStyles']['tablet']['font']['size'] ) : '',
		'mobile_size' => isset( $attributes['labelStyles']['mobile']['font']['size'] ) ? esc_attr( $attributes['labelStyles']['mobile']['font']['size'] ) : '',
		'weight'      => isset( $attributes['labelStyles']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['labelStyles']['font']['weight'] ) ) : '',
		'family'      => isset( $attributes['labelStyles']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['labelStyles']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['labelStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['labelStyles']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['labelStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['labelStyles']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['labelStyles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['labelStyles']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['labelStyles']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['labelStyles']['letterSpacing'] ) : '',
);
$color        = isset( $attributes['styles']['color'] ) ? esc_attr( $attributes['styles']['color'] ) : '';
$label_color  = isset( $attributes['labelStyles']['color'] ) ? esc_attr( $attributes['labelStyles']['color'] ) : '';

$align_item   = '';
if ( 'left' === $styles['align'] ) {
	$align_item = 'start';
} elseif ( 'right' === $styles['align'] ) {
	$align_item = 'end';
} else {
	$align_item = 'center';
}

$block_styles = "
.$block_id.cozy-block-wrapper {
    flex-direction: {$styles['layout']};
    gap: {$styles['gap']};
}
.$block_id {
    font-size: {$styles['font']['size']};
    font-weight: {$styles['font']['weight']};
    font-family: '{$styles['font']['family']}';
	text-transform: {$styles['letter_case']};
	text-decoration: {$styles['decoration']};
	line-height: {$styles['line_height']};
	letter-spacing: {$styles['letter_spacing']};
    color: {$color};
}
.$block_id .cozy-block__counter-label {
    font-size: {$label_styles['label_font']['size']};
    font-weight: {$label_styles['label_font']['weight']};
    font-family: '{$label_styles['label_font']['family']}';
	text-transform: {$label_styles['letter_case']};
	text-decoration: {$label_styles['decoration']};
	line-height: {$label_styles['line_height']};
	letter-spacing: {$label_styles['letter_spacing']};
    color: {$label_color};
}
.$block_id.cozy-block__counter-row{
	justify-content:{$styles['align']};
}
.$block_id.cozy-block__counter-column{
	align-items:{$align_item};
}
@media (max-width: 1024px) {
    .$block_id {
        font-size: {$styles['font']['tablet_size']};
    }
    .$block_id .cozy-block__counter-label {
        font-size: {$label_styles['label_font']['tablet_size']};
    }
}
@media (max-width: 767px) {
    .$block_id {
        font-size: {$styles['font']['mobile_size']};
    }
    .$block_id .cozy-block__counter-label {
        font-size: {$label_styles['label_font']['mobile_size']};
    }
}
";

$font_families = array();

if ( isset( $attributes['styles']['font']['family'] ) && ! empty( $attributes['styles']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['styles']['font']['family'] );
}
if ( isset( $attributes['labelStyles']['font']['family'] ) && ! empty( $attributes['labelStyles']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['labelStyles']['font']['family'] );
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

$classes   = array();
$classes[] = 'cozy-block-wrapper';
if ( 'row' === $attributes['blockStyle']['layout'] ) {
	$classes[] = 'cozy-block__counter-row';
} else {
	$classes[] = 'cozy-block__counter-column';
}
$classes[] = $block_id;

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
	<?php
	if ( isset( $attributes['prefix']['enabled'] ) && filter_var( $attributes['prefix']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		?>
		<div class="cozy-block__counter-label cozy-block__counter-prefix">
			<?php
			$prefix = isset( $attributes['prefix']['value'] ) ? sanitize_text_field( $attributes['prefix']['value'] ) : '';
			echo esc_html( $prefix );
			?>
		</div>
		<?php
	}

	echo $content;

	if ( isset( $attributes['suffix']['enabled'] ) && filter_var( $attributes['suffix']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		?>
		<div class="cozy-block__counter-label cozy-block__counter-suffix">
			<?php
			$suffix = isset( $attributes['suffix']['value'] ) ? sanitize_text_field( $attributes['suffix']['value'] ) : '';
			echo esc_html( $suffix );
			?>
		</div>
		<?php
	}
	?>
</div>
