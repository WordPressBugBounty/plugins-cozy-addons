<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = isset( $attributes['clientId'] ) ? str_replace( '-', '_', sanitize_key( wp_unslash( $attributes['clientId'] ) ) ) : '';

$block_id = 'cozyBlock_' . $client_id;

$styles = array(
	'justify'        => isset( $attributes['align'] ) ? esc_attr( sanitize_text_field( $attributes['align'] ) ) : '',
	'gap'            => isset( $attributes['gap'] ) ? esc_attr( $attributes['gap'] ) : '',
	'padding'        => isset( $attributes['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['padding'] ) : '',
	'border'         => isset( $attributes['border'] ) ? cozy_render_TRBL( 'border', $attributes['border'] ) : '',
	'radius'         => isset( $attributes['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['font']['size'] ) ? esc_attr( $attributes['font']['size'] ) : '',
		'weight' => isset( $attributes['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['font']['weight'] ) ) : '',
		'family' => isset( $attributes['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['font']['family'] ) ) : '',
	),
	'line_height'    => isset( $attributes['lineHeight'] ) ? esc_attr( $attributes['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['letterSpacing'] ) ? esc_attr( $attributes['letterSpacing'] ) : '',
	'shadow'         => array(
		'horizontal' => isset( $attributes['shadow']['horizontal'] ) ? esc_attr( $attributes['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['shadow']['vertical'] ) ? esc_attr( $attributes['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['shadow']['blur'] ) ? esc_attr( $attributes['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['shadow']['spread'] ) ? esc_attr( $attributes['shadow']['spread'] ) : '',
		'color'      => isset( $attributes['shadow']['color'] ) ? esc_attr( $attributes['shadow']['color'] ) : '',
		'position'   => isset( $attributes['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['shadow']['position'] ) ) : '',
	),
	'color'          => array(
		'text' => isset( $attributes['color']['text'] ) ? esc_attr( $attributes['color']['text'] ) : '',
		'bg'   => isset( $attributes['color']['bg'] ) ? esc_attr( $attributes['color']['bg'] ) : '',
	),
);

$item_styles = array(
	'width'  => isset( $attributes['itemStyles']['width'] ) ? esc_attr( $attributes['itemStyles']['width'] ) : '',
	'height' => isset( $attributes['itemStyles']['height'] ) ? esc_attr( $attributes['itemStyles']['height'] ) : '',
	'margin' => isset( $attributes['itemStyles']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['itemStyles']['margin'] ) : '',
	'border' => isset( $attributes['itemStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['itemStyles']['border'] ) : '',
	'radius' => isset( $attributes['itemStyles']['radius'] ) ? esc_attr( $attributes['itemStyles']['radius'] ) : '',
	'shadow' => array(
		'horizontal' => isset( $attributes['itemStyles']['shadow']['horizontal'] ) ? esc_attr( $attributes['itemStyles']['shadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['itemStyles']['shadow']['vertical'] ) ? esc_attr( $attributes['itemStyles']['shadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['itemStyles']['shadow']['blur'] ) ? esc_attr( $attributes['itemStyles']['shadow']['blur'] ) : '',
		'spread'     => isset( $attributes['itemStyles']['shadow']['spread'] ) ? esc_attr( $attributes['itemStyles']['shadow']['spread'] ) : '',
		'color'      => isset( $attributes['itemStyles']['shadow']['color'] ) ? esc_attr( $attributes['itemStyles']['shadow']['color'] ) : '',
		'position'   => isset( $attributes['itemStyles']['shadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['itemStyles']['shadow']['position'] ) ) : '',
	),
	'color'  => array(
		'text' => isset( $attributes['itemStyles']['color']['text'] ) ? esc_attr( $attributes['itemStyles']['color']['text'] ) : '',
		'bg'   => isset( $attributes['itemStyles']['color']['bg'] ) ? esc_attr( $attributes['itemStyles']['color']['bg'] ) : '',
	),
);

$separator = array(
	'content' => isset( $attributes['separator']['content'] ) ? htmlentities( $attributes['separator']['content'] ) : '',
	'margin'  => isset( $attributes['separator']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['separator']['margin'] ) : '',
	'size'    => isset( $attributes['separator']['size'] ) ? esc_attr( $attributes['separator']['size'] ) : '',
	'color'   => array(
		'text' => isset( $attributes['separator']['color']['text'] ) ? esc_attr( $attributes['separator']['color']['text'] ) : '',
	),
);

$timer_styles = array(
	'padding'        => isset( $attributes['timerStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['timerStyles']['padding'] ) : '',
	'border'         => isset( $attributes['timerStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['timerStyles']['border'] ) : '',
	'radius'         => isset( $attributes['timerStyles']['radius'] ) ? esc_attr( $attributes['timerStyles']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['timerStyles']['font']['size'] ) ? esc_attr( $attributes['timerStyles']['font']['size'] ) : '44px',
		'weight' => isset( $attributes['timerStyles']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['timerStyles']['font']['weight'] ) ) : '600',
		'family' => isset( $attributes['timerStyles']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['timerStyles']['font']['family'] ) ) : '',
	),
	'line_height'    => isset( $attributes['timerStyles']['lineHeight'] ) ? esc_attr( $attributes['timerStyles']['lineHeight'] ) : '1.2em',
	'letter_spacing' => isset( $attributes['timerStyles']['letterSpacing'] ) ? esc_attr( $attributes['timerStyles']['letterSpacing'] ) : '',
	'color'          => array(
		'text' => isset( $attributes['timerStyles']['color']['text'] ) ? esc_attr( $attributes['timerStyles']['color']['text'] ) : '',
		'bg'   => isset( $attributes['timerStyles']['color']['bg'] ) ? esc_attr( $attributes['timerStyles']['color']['bg'] ) : '',
	),
);

$label_styles = array(
	'align'          => isset( $attributes['label']['align'] ) ? esc_attr( sanitize_text_field( $attributes['label']['align'] ) ) : '',
	'gap'            => isset( $attributes['label']['gap'] ) ? $attributes['label']['gap'] : '',
	'font'           => array(
		'size'   => isset( $attributes['label']['font']['size'] ) ? esc_attr( $attributes['label']['font']['size'] ) : '',
		'weight' => isset( $attributes['label']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['label']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['label']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['label']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['label']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['label']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['label']['deocaration'] ) ? esc_attr( sanitize_text_field( $attributes['label']['deocaration'] ) ) : '',
	'line_height'    => isset( $attributes['label']['lineHeight'] ) ? esc_attr( $attributes['label']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['label']['letterSpacing'] ) ? esc_attr( $attributes['label']['letterSpacing'] ) : '',
	'color'          => array(
		'text' => isset( $attributes['label']['color']['text'] ) ? $attributes['label']['color']['text'] : '',
	),
);

$end_text_styles = array(
	'align'          => isset( $attributes['endOptions']['align'] ) ? esc_attr( sanitize_text_field( $attributes['endOptions']['align'] ) ) : '',
	'padding'        => isset( $attributes['endOptions']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['endOptions']['padding'] ) : '',
	'margin'         => isset( $attributes['endOptions']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['endOptions']['margin'] ) : '',
	'border'         => isset( $attributes['endOptions']['border'] ) ? cozy_render_TRBL( 'border', $attributes['endOptions']['border'] ) : '',
	'radius'         => isset( $attributes['endOptions']['radius'] ) ? esc_attr( $attributes['endOptions']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['endOptions']['font']['size'] ) ? esc_attr( $attributes['endOptions']['font']['size'] ) : '',
		'weight' => isset( $attributes['endOptions']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['endOptions']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['endOptions']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['endOptions']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['endOptions']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['endOptions']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['endOptions']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['endOptions']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['endOptions']['lineHeight'] ) ? esc_attr( $attributes['endOptions']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['endOptions']['letterSpacing'] ) ? esc_attr( $attributes['endOptions']['letterSpacing'] ) : '',
	'color'          => array(
		'text' => isset( $attributes['endOptions']['color']['text'] ) ? esc_attr( $attributes['endOptions']['color']['text'] ) : '',
		'bg'   => isset( $attributes['endOptions']['color']['bg'] ) ? esc_attr( $attributes['endOptions']['color']['bg'] ) : '',
	),
);

$ba_label = array(
	'gap'            => isset( $attributes['beforeAfterStyles']['gap'] ) ? esc_attr( $attributes['beforeAfterStyles']['gap'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['beforeAfterStyles']['font']['size'] ) ? esc_attr( $attributes['beforeAfterStyles']['font']['size'] ) : '',
		'weight' => isset( $attributes['beforeAfterStyles']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['beforeAfterStyles']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['beforeAfterStyles']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['beforeAfterStyles']['font']['family'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['beforeAfterStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['beforeAfterStyles']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['beforeAfterStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['beforeAfterStyles']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['beforeAfterStyles']['lineHeight'] ) ? esc_attr( $attributes['beforeAfterStyles']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['beforeAfterStyles']['letterSpacing'] ) ? esc_attr( $attributes['beforeAfterStyles']['letterSpacing'] ) : '',
	'color'          => array(
		'text' => isset( $attributes['beforeAfterStyles']['color']['text'] ) ? esc_attr( $attributes['beforeAfterStyles']['color']['text'] ) : '',
	),
);

$block_styles = "
#$block_id {
	{$styles['padding']}
	{$styles['border']}
	{$styles['radius']}
	font-size: {$styles['font']['size']};
	font-weight: {$styles['font']['weight']};
	font-family: {$styles['font']['family']};
	color: {$styles['color']['text']};
	background-color: {$styles['color']['bg']};
	line-height: {$styles['line_height']};
	letter-spacing: {$styles['letter_spacing']};
}
#$block_id.has-box-shadow {
	box-shadow: {$styles['shadow']['horizontal']} {$styles['shadow']['vertical']} {$styles['shadow']['blur']} {$styles['shadow']['spread']} {$styles['shadow']['color']} {$styles['shadow']['position']};
}

#$block_id .countdown-timer__wrap {
	{$item_styles['margin']}
	justify-content: {$styles['justify']};
	gap: {$styles['gap']};
}

#$block_id .item__wrap {
	width: {$item_styles['width']};
	height: {$item_styles['height']};
	{$item_styles['border']}
	border-radius: {$item_styles['radius']};
	background-color: {$item_styles['color']['bg']};
	color: {$item_styles['color']['text']};
}
#$block_id .item__wrap.has-box-shadow {
	box-shadow: {$item_styles['shadow']['horizontal']} {$item_styles['shadow']['vertical']} {$item_styles['shadow']['blur']} {$item_styles['shadow']['spread']} {$item_styles['shadow']['color']} {$item_styles['shadow']['position']};
}
#$block_id .countdown-timer__item.has-separator:before {
	content: \"{$separator['content']}\";
	{$separator['margin']}
	font-size: {$separator['size']};
	color: {$separator['color']['text']};
}
#$block_id .countdown-timer__item.display-inline {
	gap: {$label_styles['gap']};
}

#$block_id .countdown-timer__item .timer {
	{$timer_styles['padding']}
	{$timer_styles['border']}
	border-radius: {$timer_styles['radius']};
	font-size: {$timer_styles['font']['size']};
	font-weight: {$timer_styles['font']['weight']};
	font-family: {$timer_styles['font']['family']};
	line-height: {$timer_styles['line_height']};
	letter-spacing: {$timer_styles['letter_spacing']};
	background-color: {$timer_styles['color']['bg']};
	color: {$timer_styles['color']['text']};
}

#$block_id .countdown-timer__label {
	text-align: {$label_styles['align']};
	font-size: {$label_styles['font']['size']};
	font-weight: {$label_styles['font']['weight']};
	font-family: {$label_styles['font']['family']};
	text-transform: {$label_styles['letter_case']};
	text-decoration: {$label_styles['decoration']};
	line-height: {$label_styles['line_height']};
	letter-spacing: {$label_styles['letter_spacing']};
	color: {$label_styles['color']['text']};
}
#$block_id .countdown-timer__item.display-block .countdown-timer__label.is-top {
	margin-bottom: {$label_styles['gap']};
}
#$block_id .countdown-timer__item.display-block .countdown-timer__label.is-bottom {
	margin-top: {$label_styles['gap']};
}

#$block_id .countdown-timer__end-text-wrap {
	text-align: {$end_text_styles['align']};
	{$end_text_styles['margin']}
}
#$block_id .countdown-timer__end-text-wrap .end-text {
	{$end_text_styles['padding']}
	{$end_text_styles['border']}
	border-radius: {$end_text_styles['radius']};
	font-size: {$end_text_styles['font']['size']};
	font-weight: {$end_text_styles['font']['weight']};
	font-family: {$end_text_styles['font']['family']};
	text-transform: {$end_text_styles['letter_case']};
	text-decoration: {$end_text_styles['decoration']};
	line-height: {$end_text_styles['line_height']};
	letter-spacing: {$end_text_styles['letter_spacing']};
	background-color: {$end_text_styles['color']['bg']};
	color: {$end_text_styles['color']['text']};
}

#$block_id #offer-wrap:not(.width-inline) .before-label, #$block_id #offer-wrap:not(.width-inline) .after-label {
	text-align: {$styles['justify']};
}
#$block_id #offer-wrap:not(.width-inline) .before-label {
	margin-bottom: {$ba_label['gap']};
}
#$block_id #offer-wrap:not(.width-inline) .after-label {
	margin-top: {$ba_label['gap']};
}
#$block_id #offer-wrap.width-inline {
	justify-content: {$attributes['align']};
	gap: {$ba_label['gap']};
}
#$block_id .before-label, #$block_id .after-label {
	font-size: {$ba_label['font']['size']};
	font-weight: {$ba_label['font']['weight']};
	font-family: {$ba_label['font']['family']};
	text-transform: {$ba_label['letter_case']};
	text-decoration: {$ba_label['decoration']};
	line-height: {$ba_label['line_height']};
	letter-spacing: {$ba_label['letter_spacing']};
	color: {$ba_label['color']['text']};
}
";

$font_families = array();

if ( isset( $attributes['timerStyles']['font']['family'] ) && ! empty( $attributes['timerStyles']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['timerStyles']['font']['family'] );
}

if ( isset( $attributes['label']['font']['family'] ) && ! empty( $attributes['label']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['label']['font']['family'] );
}

if ( isset( $attributes['endOptions']['font']['family'] ) && ! empty( $attributes['endOptions']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['endOptions']['font']['family'] );
}

if ( isset( $attributes['beforeAfterStyles']['font']['family'] ) && ! empty( $attributes['beforeAfterStyles']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['beforeAfterStyles']['font']['family'] );
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

$wrapper_attributes = get_block_wrapper_attributes();

$wp_timezone = wp_timezone();

$now      = new DateTime( 'now', $wp_timezone );
$end_date = new DateTime( 'now', $wp_timezone );

if ( ! empty( $attributes['startDate'] ) ) {
	$start_date   = new DateTime( $attributes['startDate'], $wp_timezone );
	$started_diff = $now->diff( $start_date );

	if ( 0 === $started_diff->invert ) {
		return;
	}
}

if ( ! empty( $attributes['endDate'] ) ) {
	$end_date = new DateTime( $attributes['endDate'], $wp_timezone );
}


// Calculate the difference.
$interval = $end_date->diff( $now );

$expired_diff = $now->diff( $end_date );

// Format the result with at least two digits for each component.
$days    = str_pad( $interval->days, 2, '0', STR_PAD_LEFT );
$hours   = str_pad( $interval->h, 2, '0', STR_PAD_LEFT );
$minutes = str_pad( $interval->i, 2, '0', STR_PAD_LEFT );
$seconds = str_pad( $interval->s, 2, '0', STR_PAD_LEFT );

if ( 1 === $expired_diff->invert ) {
	$days    = '00';
	$hours   = '00';
	$minutes = '00';
	$seconds = '00';
}

$attributes['wpTimezone'] = $wp_timezone;

wp_localize_script( 'cozy-block--countdown-timer--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--countdown-timer--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockCountdownTimer( "' . esc_html( $block_id ) . '" ) }) ' );

$classes   = array();
$classes[] = 'cozy-block-countdown-timer';
$classes[] = $attributes['shadow']['enabled'] ? 'has-box-shadow' : '';
$classes[] = $block_id;
?>

<div class="cozy-block-wrapper">
	<div <?php echo $wrapper_attributes; ?>>
		<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<?php
			$classes   = array();
			$classes[] = $attributes['beforeLabel']['enabled'] || $attributes['afterLabel']['enabled'] ? 'width-' . $attributes['beforeAfterStyles']['width'] : '';
			$classes[] = 'text' === $attributes['endOptions']['type'] && 1 === $expired_diff->invert ? 'display-none' : '';
			?>
			<div id="offer-wrap" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php
				if ( $attributes['beforeLabel']['enabled'] ) {
					?>
					<div class="before-label"><?php echo esc_html( $attributes['beforeLabel']['content'] ); ?></div>
					<?php
				}

				$classes   = array();
				$classes[] = 'countdown-timer__wrap';
				?>
				<ul class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
					<?php
					$wrap_classes   = array();
					$wrap_classes[] = 'item__wrap';
					$wrap_classes[] = $attributes['itemStyles']['shadow']['enabled'] ? 'has-box-shadow' : '';

					$classes   = array();
					$classes[] = 'countdown-timer__item';
					$classes[] = 'display-' . $attributes['label']['display'];

					if ( $attributes['enableOptions']['day'] ) {
						?>
						<li class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $wrap_classes ) ) ) ); ?>">
							<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
								<?php
								if ( $attributes['label']['enabled'] && 'top' === $attributes['label']['position'] ) {
									?>
									<p class="countdown-timer__label is-top"><?php esc_html_e( 'Days', 'cozy-addons' ); ?></p>
									<?php
								}
								?>
								<div class="timer day"><?php echo esc_html( $days ); ?></div>
								<?php
								if ( $attributes['label']['enabled'] && 'bottom' === $attributes['label']['position'] ) {
									?>
									<p class="countdown-timer__label is-bottom"><?php esc_html_e( 'Days', 'cozy-addons' ); ?></p>
									<?php
								}
								?>
							</div>
						</li>
						<?php
					}
					?>

					<?php
					if ( $attributes['enableOptions']['hour'] ) {
						$classes[] = $attributes['enableOptions']['day'] && $attributes['separator']['enabled'] ? 'has-separator' : '';
						?>
						<li class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $wrap_classes ) ) ) ); ?>">
							<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
								<?php
								if ( $attributes['label']['enabled'] && 'top' === $attributes['label']['position'] ) {
									?>
									<p class="countdown-timer__label is-top"><?php esc_html_e( 'Hours', 'cozy-addons' ); ?></p>
									<?php
								}
								?>
								<div class="timer hour"><?php echo esc_html( $hours ); ?></div>
								<?php
								if ( $attributes['label']['enabled'] && 'bottom' === $attributes['label']['position'] ) {
									?>
									<p class="countdown-timer__label is-bottom"><?php esc_html_e( 'Hours', 'cozy-addons' ); ?></p>
									<?php
								}
								?>
							</div>
						</li>
						<?php
					}
					?>

					<?php
					if ( $attributes['enableOptions']['minute'] ) {
						$classes[] = ( $attributes['enableOptions']['day'] || $attributes['enableOptions']['hour'] ) && $attributes['separator']['enabled'] ? 'has-separator' : '';
						?>
						<li class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $wrap_classes ) ) ) ); ?>">
							<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
								<?php
								if ( $attributes['label']['enabled'] && 'top' === $attributes['label']['position'] ) {
									?>
									<p class="countdown-timer__label is-top"><?php esc_html_e( 'Minutes', 'cozy-addons' ); ?></p>
									<?php
								}
								?>
								<div class="timer minute"><?php echo esc_html( $minutes ); ?></div>
								<?php
								if ( $attributes['label']['enabled'] && 'bottom' === $attributes['label']['position'] ) {
									?>
									<p class="countdown-timer__label is-bottom"><?php esc_html_e( 'Minutes', 'cozy-addons' ); ?></p>
									<?php
								}
								?>
							</div>
						</li>
						<?php
					}
					?>

					<?php
					if ( $attributes['enableOptions']['second'] ) {
						$classes[] = ( $attributes['enableOptions']['day'] || $attributes['enableOptions']['hour'] || $attributes['enableOptions']['minute'] ) && $attributes['separator']['enabled'] ? 'has-separator' : '';
						?>
						<li class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $wrap_classes ) ) ) ); ?>">
							<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
								<?php
								if ( $attributes['label']['enabled'] && 'top' === $attributes['label']['position'] ) {
									?>
									<p class="countdown-timer__label is-top"><?php esc_html_e( 'Seconds', 'cozy-addons' ); ?></p>
									<?php
								}
								?>
								<div class="timer second"><?php echo esc_html( $seconds ); ?></div>
								<?php
								if ( $attributes['label']['enabled'] && 'bottom' === $attributes['label']['position'] ) {
									?>
									<p class="countdown-timer__label is-bottom"><?php esc_html_e( 'Seconds', 'cozy-addons' ); ?></p>
									<?php
								}
								?>
							</div>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
				if ( $attributes['afterLabel']['enabled'] ) {
					?>
					<div class="after-label"><?php echo esc_html( $attributes['afterLabel']['content'] ); ?></div>
					<?php
				}
				?>
			</div>
			<?php
			if ( 'text' === $attributes['endOptions']['type'] ) {
				$classes   = array();
				$classes[] = 'countdown-timer__end-text-wrap';
				$classes[] = 1 === $expired_diff->invert ? '' : 'display-none';
				?>
				<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
					<?php
					$classes   = array();
					$classes[] = 'end-text';
					$classes[] = 'display-' . $attributes['endOptions']['width'];
					?>
					<p class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>"><?php echo esc_html( $attributes['endOptions']['label'] ); ?></p>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>