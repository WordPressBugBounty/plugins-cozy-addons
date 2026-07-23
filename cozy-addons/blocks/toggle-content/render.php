<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = isset( $attributes['clientId'] ) ? str_replace( '-', '_', sanitize_key( wp_unslash( $attributes['clientId'] ) ) ) : '';

$block_id = 'cozyBlock_' . $client_id;

wp_localize_script( 'cozy-block--toggle-content--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--toggle-content--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockToggleContent( "' . esc_html( $block_id ) . '" ) }) ' );

$styles = array(
	'padding' => isset( $attributes['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['padding'] ) : '',
	'margin'  => isset( $attributes['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['margin'] ) : '',
	'border'  => isset( $attributes['border'] ) ? cozy_render_TRBL( 'border', $attributes['border'] ) : '',
	'radius'  => isset( $attributes['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['radius'] ) : '',
	'shadow'  => array(
		'horizontal' => isset( $attributes['shadow']['horizontal'] ) ? esc_attr( $attributes['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['shadow']['vertical'] ) ? esc_attr( $attributes['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['shadow']['blur'] ) ? esc_attr( $attributes['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['shadow']['spread'] ) ? esc_attr( $attributes['shadow']['spread'] ) : '',
		'color'      => isset( $attributes['shadow']['color'] ) ? esc_attr( sanitize_text_field( $attributes['shadow']['color'] ) ) : '',
		'position'   => isset( $attributes['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['shadow']['position'] ) ) : '',
	),
	'color'   => array(
		'text' => isset( $attributes['color']['text'] ) ? esc_attr( $attributes['color']['text'] ) : '',
		'bg'   => isset( $attributes['color']['bg'] ) ? esc_attr( $attributes['color']['bg'] ) : '',
	),
	'font'    => array(
		'size'   => isset( $attributes['font']['size'] ) ? esc_attr( $attributes['font']['size'] ) : '',
		'weight' => isset( $attributes['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['font']['weight'] ) ) : '',
		'family' => isset( $attributes['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['font']['family'] ) ) : '',
	),
);

$wrapper_styles = array(
	'width'       => isset( $attributes['wrapperStyles']['width'] ) ? esc_attr( $attributes['wrapperStyles']['width'] ) : '',
	'content_gap' => isset( $attributes['wrapperStyles']['contentGap'] ) ? esc_attr( $attributes['wrapperStyles']['contentGap'] ) : '',
	'justify'     => isset( $attributes['wrapperStyles']['contentAlign'] ) ? esc_attr( sanitize_text_field( $attributes['wrapperStyles']['contentAlign'] ) ) : '',
	'padding'     => isset( $attributes['wrapperStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['wrapperStyles']['padding'] ) : '',
	'margin'      => isset( $attributes['wrapperStyles']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['wrapperStyles']['margin'] ) : '',
	'border'      => isset( $attributes['wrapperStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['wrapperStyles']['border'] ) : '',
	'radius'      => isset( $attributes['wrapperStyles']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['wrapperStyles']['radius'] ) : '',
	'color'       => array(
		'bg' => isset( $attributes['wrapperStyles']['color']['bg'] ) ? esc_attr( $attributes['wrapperStyles']['color']['bg'] ) : '',
	),
);

$tab_styles = array(
	'default'        => array(
		'padding' => isset( $attributes['tabStyles']['default']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['tabStyles']['default']['padding'] ) : '',
		'border'  => isset( $attributes['tabStyles']['default']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['default']['border'] ) : '',
		'radius'  => isset( $attributes['tabStyles']['default']['radius'] ) ? esc_attr( $attributes['tabStyles']['default']['radius'] ) : '',
	),
	'active'         => array(
		'margin' => isset( $attributes['tabStyles']['active']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['tabStyles']['active']['margin'] ) : '',
		'border' => isset( $attributes['tabStyles']['active']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['active']['border'] ) : '',
		'radius' => isset( $attributes['tabStyles']['active']['radius'] ) ? esc_attr( $attributes['tabStyles']['active']['radius'] ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['tabStyles']['font']['size'] ) ? esc_attr( $attributes['tabStyles']['font']['size'] ) : '',
		'weight' => isset( $attributes['tabStyles']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['tabStyles']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['tabStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['tabStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['tabStyles']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['tabStyles']['lineHeight'] ) ? esc_attr( $attributes['tabStyles']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['tabStyles']['letterSpacing'] ) ? esc_attr( $attributes['tabStyles']['letterSpacing'] ) : '',
	'color'          => array(
		'text'         => isset( $attributes['tabStyles']['color']['text'] ) ? esc_attr( $attributes['tabStyles']['color']['text'] ) : '',
		'text_active'  => isset( $attributes['tabStyles']['color']['textActive'] ) ? esc_attr( $attributes['tabStyles']['color']['textActive'] ) : '',
		'text_hover'   => isset( $attributes['tabStyles']['color']['textHover'] ) ? esc_attr( $attributes['tabStyles']['color']['textHover'] ) : '',
		'bg'           => isset( $attributes['tabStyles']['color']['bg'] ) ? esc_attr( $attributes['tabStyles']['color']['bg'] ) : '',
		'bg_active'    => isset( $attributes['tabStyles']['color']['bgActive'] ) ? esc_attr( $attributes['tabStyles']['color']['bgActive'] ) : '',
		'bg_hover'     => isset( $attributes['tabStyles']['color']['bgHover'] ) ? esc_attr( $attributes['tabStyles']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['tabStyles']['color']['borderHover'] ) ? esc_attr( $attributes['tabStyles']['color']['borderHover'] ) : '',
	),
);

$toggle_styles = array(
	'font'           => array(
		'size'   => isset( $attributes['toggleStyles']['font']['size'] ) ? esc_attr( $attributes['toggleStyles']['font']['size'] ) : '',
		'weight' => isset( $attributes['toggleStyles']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['toggleStyles']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['toggleStyles']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['toggleStyles']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['toggleStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['toggleStyles']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['toggleStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['toggleStyles']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['toggleStyles']['lineHeight'] ) ? esc_attr( $attributes['toggleStyles']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['toggleStyles']['letterSpacing'] ) ? esc_attr( $attributes['toggleStyles']['letterSpacing'] ) : '',
	'color'          => array(
		'text'          => isset( $attributes['toggleStyles']['color']['text'] ) ? esc_attr( $attributes['toggleStyles']['color']['text'] ) : '',
		'button'        => isset( $attributes['toggleStyles']['color']['button'] ) ? esc_attr( $attributes['toggleStyles']['color']['button'] ) : '',
		'button_active' => isset( $attributes['toggleStyles']['color']['buttonActive'] ) ? esc_attr( $attributes['toggleStyles']['color']['buttonActive'] ) : '',
		'bg'            => isset( $attributes['toggleStyles']['color']['bg'] ) ? esc_attr( $attributes['toggleStyles']['color']['bg'] ) : '',
		'bg_active'     => isset( $attributes['toggleStyles']['color']['bgActive'] ) ? esc_attr( $attributes['toggleStyles']['color']['bgActive'] ) : '',
	),
);

$block_styles = "
#$block_id {
    {$styles['padding']}
    {$styles['margin']}
    {$styles['border']}
    {$styles['radius']}
    background-color: {$styles['color']['bg']};
    color: {$styles['color']['text']};
    font-size: {$styles['font']['size']};
    font-weight: {$styles['font']['weight']};
    font-family: {$styles['font']['family']};
}
#$block_id.has-box-shadow {
    box-shadow: {$styles['shadow']['horizontal']} {$styles['shadow']['vertical']} {$styles['shadow']['blur']} {$styles['shadow']['spread']} {$styles['shadow']['color']} {$styles['shadow']['position']};
}

#$block_id .toggle-content__header {
    {$wrapper_styles['margin']}
}

#$block_id .toggle-content__tabs, #$block_id .toggle-content__slider {
    width: {$wrapper_styles['width']};
    {$wrapper_styles['padding']}
    {$wrapper_styles['border']}
    {$wrapper_styles['radius']}
    justify-content: {$wrapper_styles['justify']};
    gap: {$wrapper_styles['content_gap']};
    background-color: {$wrapper_styles['color']['bg']};
}

#$block_id .toggle-content__tabs .tab-item {
    {$tab_styles['default']['padding']}
    {$tab_styles['default']['border']}
    border-radius: {$tab_styles['default']['radius']};
    color: {$tab_styles['color']['text']};
    background-color: {$tab_styles['color']['bg']};
    font-size: {$tab_styles['font']['size']};
    font-weight: {$tab_styles['font']['weight']};
    font-family: {$tab_styles['font']['family']};
    text-transform: {$tab_styles['letter_case']};
    text-decoration: {$tab_styles['decoration']};
    line-height: {$tab_styles['line_height']};
    letter-spacing: {$tab_styles['letter_spacing']};
}
#$block_id .toggle-content__tabs .tab-item.active-tab {
    {$tab_styles['active']['margin']}
    {$tab_styles['active']['border']}
    border-radius: {$tab_styles['active']['radius']};
    color: {$tab_styles['color']['text_active']};
    background-color: {$tab_styles['color']['bg_active']};
}
#$block_id .toggle-content__tabs .tab-item:hover {
    color: {$tab_styles['color']['text_hover']};
    background-color: {$tab_styles['color']['bg_hover']};
    border-color: {$tab_styles['color']['border_hover']};
}

#$block_id .toggle-content__slider {
	font-size: {$toggle_styles['font']['size']};
    font-weight: {$toggle_styles['font']['weight']};
    font-family: {$toggle_styles['font']['family']};
    text-transform: {$toggle_styles['letter_case']};
    text-decoration: {$toggle_styles['decoration']};
    line-height: {$toggle_styles['line_height']};
    letter-spacing: {$toggle_styles['letter_spacing']};
	color: {$toggle_styles['color']['text']};
}
#$block_id .toggle-content__slider .slider {
    background-color: {$toggle_styles['color']['bg']};
}
#$block_id .toggle-content__slider .slider:before {
    background-color: {$toggle_styles['color']['button']};
}
#$block_id .toggle-content__slider #toggle-switch:checked + .slider {
    background-color: {$toggle_styles['color']['bg_active']};
}
#$block_id .toggle-content__slider #toggle-switch:checked + .slider:before {
    background-color: {$toggle_styles['color']['button_active']};
}
";

$wrapper_attributes = get_block_wrapper_attributes();

// Extract the existing class attribute
preg_match( '/<div[^>]*\bclass=["\']([^"\']*\bcozy-block-toggle-content-item\b[^"\']*)["\']/', $content, $matches );
$existing_class = isset( $matches[1] ) ? $matches[1] : '';

$updated_class = trim( $existing_class ) . ' show-content';
$content       = preg_replace(
	'/(<div[^>]*\bid=["\'][^"\']*["\'][^>]*\bclass=["\'])cozy-block-toggle-content-item([^"\']*)(["\'])/',
	'${1}' . esc_attr( $updated_class ) . '${3}',
	$content,
	1
);


$font_families = array();

if ( isset( $attributes['tabStyles']['font']['family'] ) && ! empty( $attributes['tabStyles']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['tabStyles']['font']['family'] );
}

if ( isset( $attributes['toggleStyles']['font']['family'] ) && ! empty( $attributes['toggleStyles']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['toggleStyles']['font']['family'] );
}

if ( isset( $attributes['font']['family'] ) && ! empty( $attributes['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['font']['family'] );
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
$classes[] = 'cozy-block-toggle-content';
$classes[] = $attributes['shadow']['enabled'] ? 'has-box-shadow' : '';

?>

<div class="cozy-block-wrapper">
	<div <?php echo $wrapper_attributes; ?>>
		<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<?php
			$classes   = array();
			$classes[] = 'toggle-content__header';
			$classes[] = 'content-width-' . $attributes['wrapperStyles']['width'];
			$classes[] = 'content-align-' . $attributes['wrapperStyles']['contentAlign'];
			?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php
				if ( 'tab' === $attributes['type'] && ! empty( $attributes['tabs'] ) ) {
					?>
					<ul class="toggle-content__tabs">
						<?php
						foreach ( $attributes['tabs'] as $key => $tab_item ) {
							$highlight = array(
								'show_on_active' => isset( $tab_item['highlight']['showOnActive'] ) && filter_var( $tab_item['highlight']['showOnActive'], FILTER_VALIDATE_BOOLEAN ) ? true : false,
								'content'        => isset( $tab_item['highlight']['content'] ) ? sanitize_text_field( $tab_item['highlight']['content'] ) : '',
								'align'          => isset( $tab_item['highlight']['align'] ) ? sanitize_text_field( $tab_item['highlight']['align'] ) : 'right',
								'padding'        => isset( $tab_item['highlight']['padding'] ) ? cozy_render_TRBL( 'padding', $tab_item['highlight']['padding'] ) : '',
								'border'         => isset( $tab_item['highlight']['border'] ) ? cozy_render_TRBL( 'border', $tab_item['highlight']['border'] ) : '',
								'radius'         => isset( $tab_item['highlight']['radius'] ) ? cozy_render_TRBL( 'border-radius', $tab_item['highlight']['radius'] ) : '',
								'font'           => array(
									'size'   => isset( $tab_item['highlight']['font']['size'] ) ? esc_attr( $tab_item['highlight']['font']['size'] ) : '',
									'weight' => isset( $tab_item['highlight']['font']['weight'] ) ? esc_attr( sanitize_text_field( $tab_item['highlight']['font']['weight'] ) ) : '',
									'family' => isset( $tab_item['highlight']['font']['family'] ) ? esc_attr( sanitize_text_field( $tab_item['highlight']['font']['family'] ) ) : '',
								),
								'letter_case'    => isset( $tab_item['highlight']['letterCase'] ) ? esc_attr( sanitize_text_field( $tab_item['highlight']['letterCase'] ) ) : '',
								'decoration'     => isset( $tab_item['highlight']['decoration'] ) ? esc_attr( sanitize_text_field( $tab_item['highlight']['decoration'] ) ) : '',
								'line_height'    => isset( $tab_item['highlight']['lineHeight'] ) ? esc_attr( $tab_item['highlight']['lineHeight'] ) : '',
								'letter_spacing' => isset( $tab_item['highlight']['letterSpacing'] ) ? esc_attr( $tab_item['highlight']['letterSpacing'] ) : '',
								'color'          => array(
									'text' => isset( $tab_item['highlight']['color']['text'] ) ? esc_attr( $tab_item['highlight']['color']['text'] ) : '',
									'bg'   => isset( $tab_item['highlight']['color']['bg'] ) ? esc_attr( $tab_item['highlight']['color']['bg'] ) : '',
								),
								'v_offset'       => isset( $tab_item['highlight']['vOffset'] ) ? esc_attr( $tab_item['highlight']['vOffset'] ) : '',
								'h_offset'       => isset( $tab_item['highlight']['hOffset'] ) ? esc_attr( $tab_item['highlight']['hOffset'] ) : '',
								'rotate'         => isset( $tab_item['highlight']['rotate'] ) ? esc_attr( $tab_item['highlight']['rotate'] ) : '',
							);

							$classes   = array();
							$classes[] = 'tab-item';
							$classes[] = 0 === $key ? 'active-tab' : '';
							$classes[] = isset( $tab_item['highlight']['enabled'] ) && filter_var( $tab_item['highlight']['enabled'], FILTER_VALIDATE_BOOLEAN ) ? 'has-highlight-text' : '';
							$classes[] = isset( $tab_item['highlight']['enabled'], $tab_item['highlight']['showOnActive'] ) && filter_var( $tab_item['highlight']['enabled'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $tab_item['highlight']['showOnActive'], FILTER_VALIDATE_BOOLEAN ) ? 'show-on-active' : '';

							if ( isset( $tab_item['highlight']['enabled'] ) && filter_var( $tab_item['highlight']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
								$tab_styles = "
								#{$tab_item['blockID']}.tab-item.has-highlight-text:after {
									content: '{$highlight['content']}';
									{$highlight['padding']}
									{$highlight['border']}
									{$highlight['radius']}
									font-size: {$highlight['font']['size']};
									font-weight: {$highlight['font']['weight']};
									font-family: {$highlight['font']['family']};
									text-transform: {$highlight['letter_case']};
									text-decoration: {$highlight['decoration']};
									line-height: {$highlight['line_height']};
									letter-spacing: {$highlight['letter_spacing']};
									background-color: {$highlight['color']['bg']};
									color: {$highlight['color']['text']};
									top: {$highlight['v_offset']};
									{$highlight['align']}: {$highlight['h_offset']};
									transform: rotate({$highlight['rotate']}deg);
								}
								";
								?>
								<style>
									<?php
									if ( ! empty( $highlight['font']['family'] ) ) {
										$font_query = 'https://fonts.googleapis.com/css2?family=' . esc_attr( sanitize_text_field( $highlight['font']['family'] ) ) . ':wght@100;200;300;400;500;600;700;800;900';
										echo '@import url("' . $font_query . '");';
									}
									echo $tab_styles;
									?>
								</style>
								<?php
							}
							?>
							<li id="<?php echo esc_attr( $tab_item['blockID'] ); ?>" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" data-index="<?php echo esc_attr( $key ); ?>" data-client-id="<?php echo esc_attr( $tab_item['clientId'] ); ?>"><?php echo esc_html( $tab_item['tabLabel'] ); ?></li>
							<?php
						}
						?>
					</ul>
					<?php
				}

				if ( 'toggle' === $attributes['type'] && count( $attributes['tabs'] ) >= 2 ) {
					$classes   = array();
					$classes[] = 'tab-item';
					$classes[] = 'first-element';
					$classes[] = 'active-tab';
					$classes[] = isset( $attributes['tabs'][0]['highlight']['enabled'] ) && filter_var( $attributes['tabs'][0]['highlight']['enabled'], FILTER_VALIDATE_BOOLEAN ) ? 'has-highlight-text' : '';
					$classes[] = isset( $attributes['tabs'][0]['highlight']['enabled'], $attributes['tabs'][0]['highlight']['showOnActive'] ) && filter_var( $attributes['tabs'][0]['highlight']['enabled'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['tabs'][0]['highlight']['showOnActive'], FILTER_VALIDATE_BOOLEAN ) ? 'show-on-active' : '';

					$highlight = array(
						'content'        => isset( $attributes['tabs'][0]['highlight']['content'] ) ? sanitize_text_field( $attributes['tabs'][0]['highlight']['content'] ) : '',
						'align'          => isset( $attributes['tabs'][0]['highlight']['align'] ) ? sanitize_text_field( $attributes['tabs'][0]['highlight']['align'] ) : '',
						'padding'        => isset( $attributes['tabs'][0]['highlight']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['tabs'][0]['highlight']['padding'] ) : '',
						'border'         => isset( $attributes['tabs'][0]['highlight']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabs'][0]['highlight']['border'] ) : '',
						'radius'         => isset( $attributes['tabs'][0]['highlight']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['tabs'][0]['highlight']['radius'] ) : '',
						'font'           => array(
							'size'   => isset( $attributes['tabs'][0]['highlight']['font']['size'] ) ? esc_attr( $attributes['tabs'][0]['highlight']['font']['size'] ) : '',
							'family' => isset( $attributes['tabs'][0]['highlight']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['tabs'][0]['highlight']['font']['family'] ) ) : '',
							'weight' => isset( $attributes['tabs'][0]['highlight']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['tabs'][0]['highlight']['font']['weight'] ) ) : '',
						),
						'letter_case'    => isset( $attributes['tabs'][0]['highlight']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['tabs'][0]['highlight']['letterCase'] ) ) : '',
						'decoration'     => isset( $attributes['tabs'][0]['highlight']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['tabs'][0]['highlight']['decoration'] ) ) : '',
						'line_height'    => isset( $attributes['tabs'][0]['highlight']['lineHeight'] ) ? esc_attr( $attributes['tabs'][0]['highlight']['lineHeight'] ) : '',
						'letter_spacing' => isset( $attributes['tabs'][0]['highlight']['letterSpacing'] ) ? esc_attr( $attributes['tabs'][0]['highlight']['letterSpacing'] ) : '',
						'color'          => array(
							'text' => isset( $attributes['tabs'][0]['highlight']['color']['text'] ) ? esc_attr( $attributes['tabs'][0]['highlight']['color']['text'] ) : '',
							'bg'   => isset( $attributes['tabs'][0]['highlight']['color']['bg'] ) ? esc_attr( $attributes['tabs'][0]['highlight']['color']['bg'] ) : '',
						),
						'v_offset'       => isset( $attributes['tabs'][0]['highlight']['vOffset'] ) ? esc_attr( $attributes['tabs'][0]['highlight']['vOffset'] ) : '',
						'h_offset'       => isset( $attributes['tabs'][0]['highlight']['hOffset'] ) ? esc_attr( $attributes['tabs'][0]['highlight']['hOffset'] ) : '',
						'rotate'         => isset( $attributes['tabs'][0]['highlight']['rotate'] ) ? esc_attr( $attributes['tabs'][0]['highlight']['rotate'] ) : '',
					);

					$element_style = "
						#$block_id .tab-item.first-element.has-highlight-text:after {
							content: '{$highlight['content']}';
							{$highlight['padding']}
							{$highlight['border']}
							{$highlight['radius']}
							font-size: {$highlight['font']['size']};
							font-weight: {$highlight['font']['weight']};
							font-family: {$highlight['font']['family']};
							text-transform: {$highlight['letter_case']};
							text-decoration: {$highlight['decoration']};
							line-height: {$highlight['line_height']};
							letter-spacing: {$highlight['letter_spacing']};
							background-color: {$highlight['color']['bg']};
							color: {$highlight['color']['text']};
							top: {$highlight['v_offset']};
							{$highlight['align']}: {$highlight['h_offset']};
							transform: rotate({$highlight['rotate']}deg);
						}
					";
					?>
					<div class="toggle-content__slider">
						<style>
							<?php
							if ( ! empty( $highlight['font']['family'] ) ) {
								$font_query = 'https://fonts.googleapis.com/css2?family=' . esc_attr( sanitize_text_field( $highlight['font']['family'] ) ) . ':wght@100;200;300;400;500;600;700;800;900';
								echo '@import url("' . $font_query . '");';
							}
							echo $element_style;
							?>
						</style>
						<p class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" data-index="0"><?php echo esc_html( $attributes['tabs'][0]['tabLabel'] ); ?></p>
						<label class="switch">
							<input id="toggle-switch" type="checkbox" />
							<span class="slider"></span>
						</label>
						<?php
						$classes   = array();
						$classes[] = 'tab-item';
						$classes[] = 'second-element';
						$classes[] = isset( $attributes['tabs'][1]['highlight']['enabled'] ) && filter_var( $attributes['tabs'][1]['highlight']['enabled'], FILTER_VALIDATE_BOOLEAN ) ? 'has-highlight-text' : '';
						$classes[] = isset( $attributes['tabs'][1]['highlight']['enabled'], $attributes['tabs'][1]['highlight']['showOnActive'] ) && filter_var( $attributes['tabs'][1]['highlight']['enabled'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['tabs'][1]['highlight']['showOnActive'], FILTER_VALIDATE_BOOLEAN ) ? 'show-on-active' : '';

						$highlight = array(
							'content'        => isset( $attributes['tabs'][1]['highlight']['content'] ) ? sanitize_text_field( $attributes['tabs'][1]['highlight']['content'] ) : '',
							'align'          => isset( $attributes['tabs'][1]['highlight']['align'] ) ? sanitize_text_field( $attributes['tabs'][1]['highlight']['align'] ) : '',
							'padding'        => isset( $attributes['tabs'][1]['highlight']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['tabs'][1]['highlight']['padding'] ) : '',
							'border'         => isset( $attributes['tabs'][1]['highlight']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabs'][1]['highlight']['border'] ) : '',
							'radius'         => isset( $attributes['tabs'][1]['highlight']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['tabs'][1]['highlight']['radius'] ) : '',
							'font'           => array(
								'size'   => isset( $attributes['tabs'][1]['highlight']['font']['size'] ) ? esc_attr( $attributes['tabs'][1]['highlight']['font']['size'] ) : '',
								'family' => isset( $attributes['tabs'][1]['highlight']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['tabs'][1]['highlight']['font']['family'] ) ) : '',
								'weight' => isset( $attributes['tabs'][1]['highlight']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['tabs'][1]['highlight']['font']['weight'] ) ) : '',
							),
							'letter_case'    => isset( $attributes['tabs'][1]['highlight']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['tabs'][1]['highlight']['letterCase'] ) ) : '',
							'decoration'     => isset( $attributes['tabs'][1]['highlight']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['tabs'][1]['highlight']['decoration'] ) ) : '',
							'line_height'    => isset( $attributes['tabs'][1]['highlight']['lineHeight'] ) ? esc_attr( $attributes['tabs'][1]['highlight']['lineHeight'] ) : '',
							'letter_spacing' => isset( $attributes['tabs'][1]['highlight']['letterSpacing'] ) ? esc_attr( $attributes['tabs'][1]['highlight']['letterSpacing'] ) : '',
							'color'          => array(
								'text' => isset( $attributes['tabs'][1]['highlight']['color']['text'] ) ? esc_attr( $attributes['tabs'][1]['highlight']['color']['text'] ) : '',
								'bg'   => isset( $attributes['tabs'][1]['highlight']['color']['bg'] ) ? esc_attr( $attributes['tabs'][1]['highlight']['color']['bg'] ) : '',
							),
							'v_offset'       => isset( $attributes['tabs'][1]['highlight']['vOffset'] ) ? esc_attr( $attributes['tabs'][1]['highlight']['vOffset'] ) : '',
							'h_offset'       => isset( $attributes['tabs'][1]['highlight']['hOffset'] ) ? esc_attr( $attributes['tabs'][1]['highlight']['hOffset'] ) : '',
							'rotate'         => isset( $attributes['tabs'][1]['highlight']['rotate'] ) ? esc_attr( $attributes['tabs'][1]['highlight']['rotate'] ) : '',
						);

						$element_style = "
						#$block_id .tab-item.second-element.has-highlight-text:after {
							content: '{$highlight['content']}';
							{$highlight['padding']}
							{$highlight['border']}
							{$highlight['radius']}
							font-size: {$highlight['font']['size']};
							font-weight: {$highlight['font']['weight']};
							font-family: {$highlight['font']['family']};
							text-transform: {$highlight['letter_case']};
							text-decoration: {$highlight['decoration']};
							line-height: {$highlight['line_height']};
							letter-spacing: {$highlight['letter_spacing']};
							background-color: {$highlight['color']['bg']};
							color: {$highlight['color']['text']};
							top: {$highlight['v_offset']};
							{$highlight['align']}: {$highlight['h_offset']};
							transform: rotate({$highlight['rotate']}deg);
						}
					";
						?>
						<style>
							<?php
							if ( ! empty( $highlight['font']['family'] ) ) {
								$font_query = 'https://fonts.googleapis.com/css2?family=' . esc_attr( sanitize_text_field( $highlight['font']['family'] ) ) . ':wght@100;200;300;400;500;600;700;800;900';
								echo '@import url("' . $font_query . '");';
							}
							echo $element_style;
							?>
						</style>
						<p class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" data-index="1"><?php echo esc_html( $attributes['tabs'][1]['tabLabel'] ); ?></p>
					</div>
					<?php
				}
				?>
			</div>

			<?php echo $content; ?>
		</div>
	</div>
</div>