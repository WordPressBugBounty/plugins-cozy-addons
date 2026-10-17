<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cozy_form_parsed = ( $block instanceof WP_Block && isset( $block->parsed_block['innerBlocks'] ) ) ? $block->parsed_block['innerBlocks'] : array();
$cozy_form_fields = cozy_addons_form_collect_fields( $cozy_form_parsed );

if ( empty( $cozy_form_fields ) ) {
	if ( current_user_can( 'edit_posts' ) ) {
		echo '<p class="cozy-form__notice">' . esc_html__( 'Form: add at least one field.', 'cozy-addons' ) . '</p>';
	}
	return;
}

// Steps need Pro. Without it a step form still works, with every field on one page.
$cozy_form_steps = cozy_addons_form_has_steps( $cozy_form_parsed ) && cozy_addons_premium_access();

$form_type = isset( $attributes['formType'] ) && isset( cozy_addons_form_types()[ $attributes['formType'] ] ) ? $attributes['formType'] : 'contact';

// Product enquiries (Pro) take the product from the page. Without Pro they work as normal enquiry forms.
$cozy_form_product = null;
$product_display   = '';
if ( 'product' === $form_type && cozy_addons_premium_access() ) {
	$cozy_form_product = \CozyAddons\Core\Forms\Form_WooCommerce::current_product();
	if ( ! $cozy_form_product ) {
		if ( current_user_can( 'edit_posts' ) ) {
			echo '<p class="cozy-form__notice">' . esc_html__( 'Product enquiry form: it only appears on WooCommerce product pages.', 'cozy-addons' ) . '</p>';
		}
		return;
	}
	$product_display = isset( $attributes['productDisplay'] ) && 'modal' === $attributes['productDisplay'] ? 'modal' : 'inline';
}

$client_id = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['blockClientId'] ) ) : wp_unique_id( 'form-' );
$block_id  = 'cozyBlock_' . str_replace( '-', '_', sanitize_key( $client_id ) );

$form_name = cozy_addons_form_plain( isset( $attributes['formName'] ) ? $attributes['formName'] : '' );
if ( '' === $form_name ) {
	$form_name = __( 'Contact form', 'cozy-addons' );
}
$form_id = sanitize_key( isset( $attributes['formId'] ) ? $attributes['formId'] : '' );
if ( '' === $form_id ) {
	$form_id = substr( md5( $form_name ), 0, 8 );
}
$button_text = cozy_addons_form_plain( isset( $attributes['buttonText'] ) ? $attributes['buttonText'] : '' );
if ( '' === $button_text ) {
	$button_text = __( 'Send message', 'cozy-addons' );
}
$success = sanitize_text_field( isset( $attributes['successMessage'] ) ? $attributes['successMessage'] : '' );
if ( '' === $success ) {
	$success = __( "Thanks! We've received your message and will get back to you shortly.", 'cozy-addons' );
}

// Spam protection chosen for this form: a check (reCAPTCHA or Turnstile, which need the site's
// keys and Pro) and Akismet's "on" or "off", which override the site setting. Both travel in the
// signed config so visitors cannot drop them. Forms saved before the choice existed only had
// "turnstile: off".
$spam_choice = isset( $attributes['spamProtection'] ) && is_array( $attributes['spamProtection'] ) ? $attributes['spamProtection'] : array();
if ( isset( $spam_choice['captcha'] ) && in_array( $spam_choice['captcha'], array( 'default', 'none', 'recaptcha', 'turnstile' ), true ) ) {
	$captcha_choice = $spam_choice['captcha'];
} else {
	$captcha_choice = isset( $spam_choice['turnstile'] ) && 'off' === $spam_choice['turnstile'] ? 'none' : 'default';
}
$cozy_form_captcha = cozy_addons_form_resolve_captcha( $captcha_choice );
$akismet_choice = isset( $spam_choice['akismet'] ) && in_array( $spam_choice['akismet'], array( 'on', 'off' ), true ) ? $spam_choice['akismet'] : 'default';

// Pro: a thank-you page, a file to download, and the form's own notification email. The download
// and the email are sealed like the recipients, so they cannot be read in the page source.
$cozy_form_pro      = cozy_addons_premium_access();
$cozy_form_download = '';
$cozy_form_email    = '';
if ( $cozy_form_pro ) {
	$download_url = esc_url_raw( isset( $attributes['downloadUrl'] ) ? (string) $attributes['downloadUrl'] : '', array( 'http', 'https' ) );
	if ( '' !== $download_url ) {
		$cozy_form_download = cozy_addons_form_seal(
			wp_json_encode(
				array(
					'u' => $download_url,
					'l' => cozy_addons_form_plain( isset( $attributes['downloadLabel'] ) ? $attributes['downloadLabel'] : '' ),
				)
			)
		);
	}
	$email_subject = sanitize_text_field( isset( $attributes['emailSubject'] ) ? (string) $attributes['emailSubject'] : '' );
	$email_message = sanitize_textarea_field( isset( $attributes['emailMessage'] ) ? mb_substr( (string) $attributes['emailMessage'], 0, 5000 ) : '' );
	if ( '' !== $email_subject || '' !== trim( $email_message ) ) {
		$cozy_form_email = cozy_addons_form_seal(
			wp_json_encode(
				array(
					's' => mb_substr( $email_subject, 0, 200 ),
					'b' => trim( $email_message ),
				)
			)
		);
	}
}

// Signed config: the browser cannot change which fields exist, who gets the email, etc.
// The recipients are also sealed, so the notification emails cannot be read in the page source.
// The HEX flags keep &, <, > and quotes out of the JSON so it survives an HTML attribute unchanged.
$form_config = array(
	'v'      => 1,
	'id'     => $form_id,
	'name'   => $form_name,
	'fields' => $cozy_form_fields,
	'to'     => cozy_addons_form_seal( implode( ', ', cozy_addons_form_parse_emails( isset( $attributes['notifyEmail'] ) ? $attributes['notifyEmail'] : '' ) ) ),
	'ok'     => $success,
	'go'     => $cozy_form_pro ? esc_url_raw( isset( $attributes['redirectUrl'] ) ? $attributes['redirectUrl'] : '' ) : '',
	'type'   => $form_type,
	'cat'    => isset( $attributes['category'] ) && isset( cozy_addons_form_categories()[ $attributes['category'] ] ) ? $attributes['category'] : '',
	'cp'     => $cozy_form_captcha,
	'ak'     => $akismet_choice,
	'n'      => ! isset( $attributes['notify'] ) || ! empty( $attributes['notify'] ) ? 1 : 0,
);
if ( '' !== $cozy_form_download ) {
	$form_config['dl'] = $cozy_form_download;
}
if ( '' !== $cozy_form_email ) {
	$form_config['em'] = $cozy_form_email;
}
if ( $cozy_form_product ) {
	$form_config['p'] = (int) $cozy_form_product->get_id();
}
$form_json   = wp_json_encode( $form_config, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );
$form_sig    = cozy_addons_form_sign( $form_json );

/*
 * Styles.
 */
$css = 'cozy_addons_form_css_value';

$trbl = static function ( $type, $values ) use ( $css ) {
	if ( ! is_array( $values ) ) {
		return '';
	}
	$values = array_map( $css, array_intersect_key( $values, array_flip( array( 'top', 'right', 'bottom', 'left', 'width', 'style', 'color' ) ) ) );

	return cozy_render_TRBL( $type, $values );
};

$font_size = static function ( $typo, $device ) {
	return isset( $typo[ $device ]['font']['size'] ) ? cozy_addons_sanitize_dimension( $typo[ $device ]['font']['size'] ) : '';
};

// Every TypographyControl value except the responsive font size.
$typography = static function ( $typo ) use ( $css ) {
	$typo   = is_array( $typo ) ? $typo : array();
	$family = $css( $typo['font']['family'] ?? '' );

	return 'font-weight:' . $css( $typo['font']['weight'] ?? '' ) . ';'
		. 'font-family:' . ( '' !== $family ? "'{$family}'" : '' ) . ';'
		. 'text-transform:' . $css( $typo['letterCase'] ?? '' ) . ';'
		. 'text-decoration:' . $css( $typo['decoration'] ?? '' ) . ';'
		. 'line-height:' . $css( $typo['lineHeight'] ?? '' ) . ';'
		. 'letter-spacing:' . cozy_addons_sanitize_dimension( $typo['letterSpacing'] ?? '' ) . ';';
};

$layout    = isset( $attributes['layout'] ) && is_array( $attributes['layout'] ) ? $attributes['layout'] : array();
$container = isset( $attributes['containerStyles'] ) && is_array( $attributes['containerStyles'] ) ? $attributes['containerStyles'] : array();
$label     = isset( $attributes['labelStyles'] ) && is_array( $attributes['labelStyles'] ) ? $attributes['labelStyles'] : array();
$input     = isset( $attributes['inputStyles'] ) && is_array( $attributes['inputStyles'] ) ? $attributes['inputStyles'] : array();
$choice    = isset( $attributes['choiceStyles'] ) && is_array( $attributes['choiceStyles'] ) ? $attributes['choiceStyles'] : array();
$button    = isset( $attributes['buttonStyles'] ) && is_array( $attributes['buttonStyles'] ) ? $attributes['buttonStyles'] : array();
$message   = isset( $attributes['messageStyles'] ) && is_array( $attributes['messageStyles'] ) ? $attributes['messageStyles'] : array();
$progress  = isset( $attributes['progressStyles'] ) && is_array( $attributes['progressStyles'] ) ? $attributes['progressStyles'] : array();

$button_align = array(
	'left'   => 'flex-start',
	'center' => 'center',
	'right'  => 'flex-end',
);
$button_align = isset( $button['align'], $button_align[ $button['align'] ] ) ? $button_align[ $button['align'] ] : '';

$device_styles = static function ( $device ) use ( $block_id, $trbl, $font_size, $container, $label, $input, $choice, $button ) {
	return "
	#{$block_id} {
		{$trbl( 'padding', $container[ $device ]['padding'] ?? null )}
	}
	#{$block_id} .cozy-form__label {
		font-size: {$font_size( $label, $device )};
	}
	#{$block_id} .cozy-form__input {
		{$trbl( 'padding', $input[ $device ]['padding'] ?? null )}
		font-size: {$font_size( $input, $device )};
	}
	#{$block_id} .cozy-form__choice, #{$block_id} .cozy-form__check {
		font-size: {$font_size( $choice, $device )};
	}
	#{$block_id} .cozy-form__actions .cozy-form__button {
		{$trbl( 'padding', $button[ $device ]['padding'] ?? null )}
		font-size: {$font_size( $button, $device )};
	}
	";
};

$block_styles = "
#{$block_id} {
	{$trbl( 'border', $container['border'] ?? null )}
	border-radius: {$css( $container['radius'] ?? '' )};
	background-color: {$css( $container['bgColor'] ?? '' )};
}
#{$block_id} .cozy-form__fields, #{$block_id} .cozy-form__step {
	column-gap: {$css( $layout['columnGap'] ?? '' )};
	row-gap: {$css( $layout['rowGap'] ?? '' )};
}
#{$block_id} .cozy-form__field {
	gap: {$css( $label['gap'] ?? '' )};
}
#{$block_id} .cozy-form__label, #{$block_id} .cozy-form__step-title {
	{$typography( $label )}
	color: {$css( $label['color']['text'] ?? '' )};
}
#{$block_id} .cozy-form__required {
	color: {$css( $label['color']['required'] ?? '' )};
}
#{$block_id} .cozy-form__input {
	{$typography( $input )}
	{$trbl( 'border', $input['border'] ?? null )}
	border-radius: {$css( $input['radius'] ?? '' )};
	color: {$css( $input['color']['text'] ?? '' )};
	background-color: {$css( $input['color']['bg'] ?? '' )};
}
#{$block_id} .cozy-form__input::placeholder {
	color: {$css( $input['color']['placeholder'] ?? '' )};
}
#{$block_id} .cozy-form__input:focus, #{$block_id} .cozy-form__input:focus-visible {
	{$trbl( 'border', $input['borderFocus'] ?? null )}
	color: {$css( $input['color']['textFocus'] ?? '' )};
	background-color: {$css( $input['color']['bgFocus'] ?? '' )};
}
#{$block_id} textarea.cozy-form__input {
	min-height: {$css( $input['textareaHeight'] ?? '' )};
}
#{$block_id} .cozy-form__choice, #{$block_id} .cozy-form__check {
	{$typography( $choice )}
	color: {$css( $choice['color']['text'] ?? '' )};
}
#{$block_id} .cozy-form__choices {
	gap: {$css( $choice['gap'] ?? '' )};
}
#{$block_id} .cozy-form__choice {
	{$trbl( 'border', $choice['border'] ?? null )}
	border-radius: {$css( $choice['radius'] ?? '' )};
	background-color: {$css( $choice['color']['bg'] ?? '' )};
}
#{$block_id} .cozy-form__choice:has(input:checked) {
	border-color: {$css( $choice['color']['borderActive'] ?? '' )};
	background-color: {$css( $choice['color']['bgActive'] ?? '' )};
}
#{$block_id} .cozy-form__choice input, #{$block_id} .cozy-form__check input {
	width: {$css( $choice['size'] ?? '' )};
	height: {$css( $choice['size'] ?? '' )};
	accent-color: {$css( $choice['color']['accent'] ?? '' )};
}
#{$block_id} .cozy-form__actions {
	justify-content: {$button_align};
}
#{$block_id}:not(.is-layout-inline) .cozy-form__actions {
	margin-top: {$css( $button['margin']['top'] ?? '' )};
}
#{$block_id} .cozy-form__actions .cozy-form__button {
	" . ( ! empty( $button['fullWidth'] ) ? 'flex: 1 1 0;' : '' ) . "
	{$typography( $button )}
	{$trbl( 'border', $button['border'] ?? null )}
	border-radius: {$css( $button['radius'] ?? '' )};
	color: {$css( $button['color']['text'] ?? '' )};
	background-color: {$css( $button['color']['bg'] ?? '' )};
}
#{$block_id} .cozy-form__actions .cozy-form__button:hover {
	color: {$css( $button['color']['textHover'] ?? '' )};
	background-color: {$css( $button['color']['bgHover'] ?? '' )};
	border-color: {$css( $button['color']['borderHover'] ?? '' )};
}
#{$block_id} .cozy-form__message {
	border-radius: {$css( $message['radius'] ?? '' )};
}
#{$block_id} .cozy-form__message.is-success {
	color: {$css( $message['color']['successText'] ?? '' )};
	background-color: {$css( $message['color']['successBg'] ?? '' )};
}
#{$block_id} .cozy-form__message.is-error {
	color: {$css( $message['color']['errorText'] ?? '' )};
	background-color: {$css( $message['color']['errorBg'] ?? '' )};
}
#{$block_id} .cozy-form__progress-text {
	color: {$css( $progress['color']['text'] ?? '' )};
}
#{$block_id} .cozy-form__progress-bar {
	height: {$css( $progress['height'] ?? '' )};
	background-color: {$css( $progress['color']['track'] ?? '' )};
}
#{$block_id} .cozy-form__progress-fill {
	background-color: {$css( $progress['color']['bar'] ?? '' )};
}
#{$block_id} .cozy-form__step-nav {
	color: {$css( $progress['color']['text'] ?? '' )};
	--cozy-form-step-active: {$css( $progress['color']['bar'] ?? '' )};
	--cozy-form-step-inactive: {$css( $progress['color']['track'] ?? '' )};
}
{$device_styles( 'desktop' )}
@media only screen and (width <= 1024px) {
	{$device_styles( 'tablet' )}
}
@media only screen and (width <= 767px) {
	{$device_styles( 'mobile' )}
}
";
$block_styles = cozy_addons_clean_empty_css( $block_styles );

// Google Fonts.
$font_families = array();
foreach ( array( $label, $input, $choice, $button ) as $typo ) {
	$family = $css( $typo['font']['family'] ?? '' );
	if ( '' !== $family ) {
		$font_families[] = $family;
	}
}
$font_families = array_unique( $font_families );
if ( ! empty( $font_families ) ) {
	$font_query = array();
	foreach ( $font_families as $family ) {
		$font_query[] = 'family=' . str_replace( ' ', '+', $family ) . ':wght@100;200;300;400;500;600;700;800;900';
	}
	echo '<link rel="stylesheet" href="' . esc_url( 'https://fonts.googleapis.com/css2?' . implode( '&', $font_query ) . '&display=swap' ) . '"/>';
}

if ( did_action( 'wp_enqueue_scripts' ) ) {
	// Classic themes render the content after the head, when inline styles can no longer be added to it.
	echo '<style>' . $block_styles . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Every value is sanitized above.
} else {
	add_action(
		'wp_enqueue_scripts',
		function () use ( $block_styles ) {
			wp_add_inline_style( 'cozy-block--global-block-styles', $block_styles );
		}
	);
}

/* translators: 1: current step number, 2: total number of steps */
$step_label = __( 'Step %1$s of %2$s', 'cozy-addons' );

$next_text = cozy_addons_form_plain( isset( $attributes['nextText'] ) ? $attributes['nextText'] : '' );
if ( '' === $next_text ) {
	$next_text = __( 'Next', 'cozy-addons' );
}
$back_text = cozy_addons_form_plain( isset( $attributes['backText'] ) ? $attributes['backText'] : '' );
if ( '' === $back_text ) {
	$back_text = __( 'Back', 'cozy-addons' );
}
$progress_style = isset( $attributes['progressStyle'] ) && 'numbers' === $attributes['progressStyle'] ? 'numbers' : 'bar';

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'cozy-block-wrapper' ) );

$form_classes = array( 'cozy-block-form', 'is-type-' . $form_type );
if ( isset( $attributes['layoutStyle'] ) && 'inline' === $attributes['layoutStyle'] ) {
	$form_classes[] = 'is-layout-inline';
}
if ( ! empty( $attributes['hideLabels'] ) ) {
	$form_classes[] = 'has-hidden-labels';
}

$trigger_text = cozy_addons_form_plain( isset( $attributes['triggerText'] ) ? $attributes['triggerText'] : '' );
if ( '' === $trigger_text ) {
	$trigger_text = __( 'Ask about this product', 'cozy-addons' );
}
$dialog_id = wp_unique_id( 'cozy-form-dialog-' );
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by core. ?>>
	<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $form_classes ) ); ?>">
		<?php if ( 'modal' === $product_display ) : ?>
			<button type="button" class="wp-element-button cozy-form__button cozy-form__open" aria-haspopup="dialog"><?php echo esc_html( $trigger_text ); ?></button>
			<dialog class="cozy-form__dialog" aria-labelledby="<?php echo esc_attr( $dialog_id ); ?>-title">
				<button type="button" class="cozy-form__close" aria-label="<?php esc_attr_e( 'Close', 'cozy-addons' ); ?>">&times;</button>
				<h2 class="cozy-form__dialog-title" id="<?php echo esc_attr( $dialog_id ); ?>-title"><?php echo esc_html( $form_name ); ?></h2>
		<?php endif; ?>
		<?php
		if ( $cozy_form_product ) {
			echo \CozyAddons\Core\Forms\Form_WooCommerce::card( $cozy_form_product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in card().
		}
		?>
		<form class="cozy-form__form" method="post" action="" data-endpoint="<?php echo esc_url( rest_url( 'cozy-block/v1/form-submit' ) ); ?>" data-error="<?php echo esc_attr__( 'Something went wrong. Please try again.', 'cozy-addons' ); ?>" data-choose="<?php echo esc_attr__( 'Please choose at least one option.', 'cozy-addons' ); ?>" data-too-large="<?php echo esc_attr__( 'This file is too large.', 'cozy-addons' ); ?>" data-too-many="<?php /* translators: %d: number of files */ echo esc_attr__( 'You can upload up to %d files.', 'cozy-addons' ); ?>"<?php echo $cozy_form_steps ? ' data-steps="1" data-step-label="' . esc_attr( $step_label ) . '"' : ''; ?>>
			<?php if ( $cozy_form_steps && 'numbers' === $progress_style ) : ?>
				<ol class="cozy-form__step-nav" hidden>
					<?php
					foreach ( cozy_addons_form_step_titles( $cozy_form_parsed ) as $step_index => $step_title ) {
						if ( '' === $step_title ) {
							/* translators: %d: step number */
							$step_title = sprintf( __( 'Step %d', 'cozy-addons' ), $step_index + 1 );
						}
						echo '<li class="cozy-form__step-nav-item"><span class="cozy-form__step-num">' . esc_html( (string) ( $step_index + 1 ) ) . '</span><span class="cozy-form__step-name">' . esc_html( $step_title ) . '</span></li>';
					}
					?>
				</ol>
				<span class="cozy-form__sr-only cozy-form__progress-text" aria-live="polite"></span>
			<?php elseif ( $cozy_form_steps ) : ?>
				<div class="cozy-form__progress" hidden>
					<span class="cozy-form__progress-text" aria-live="polite"></span>
					<span class="cozy-form__progress-bar" aria-hidden="true"><span class="cozy-form__progress-fill"></span></span>
				</div>
			<?php endif; ?>
			<div class="cozy-form__fields"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered inner blocks, escaped by their own renderers. ?></div>
			<input type="hidden" name="cozy_addons_form_config" value="<?php echo esc_attr( $form_json ); ?>">
			<input type="hidden" name="cozy_addons_form_sig" value="<?php echo esc_attr( $form_sig ); ?>">
			<?php if ( $cozy_form_product ) : ?>
				<input type="hidden" name="cozy_addons_form_variation_id" value="">
				<input type="hidden" name="cozy_addons_form_product_options" value="">
			<?php endif; ?>
			<div class="cozy-form__hp" aria-hidden="true">
				<label><?php esc_html_e( 'Leave this field empty', 'cozy-addons' ); ?>
					<input type="text" name="cozy_addons_form_hp" tabindex="-1" autocomplete="off">
				</label>
			</div>
			<?php
			if ( 'turnstile' === $cozy_form_captcha ) {
				echo \CozyAddons\Core\Forms\Form_Turnstile::widget( isset( $attributes['layoutStyle'] ) && 'inline' === $attributes['layoutStyle'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in widget().
			} elseif ( 'recaptcha' === $cozy_form_captcha ) {
				echo \CozyAddons\Core\Forms\Form_Recaptcha::widget(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in widget().
			}
			?>
			<div class="cozy-form__actions">
				<?php if ( $cozy_form_steps ) : ?>
					<button type="button" class="wp-element-button cozy-form__button cozy-form__back" hidden><?php echo esc_html( $back_text ); ?></button>
					<button type="button" class="wp-element-button cozy-form__button cozy-form__next" hidden><?php echo esc_html( $next_text ); ?></button>
				<?php endif; ?>
				<button type="submit" class="wp-element-button cozy-form__button cozy-form__submit"><?php echo esc_html( $button_text ); ?></button>
			</div>
			<div class="cozy-form__message" role="status" aria-live="polite" tabindex="-1" hidden></div>
		</form>
		<noscript><p><?php esc_html_e( 'Please enable JavaScript to send this form.', 'cozy-addons' ); ?></p></noscript>
		<?php if ( 'modal' === $product_display ) : ?>
			</dialog>
		<?php endif; ?>
	</div>
</div>
