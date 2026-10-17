<?php
/**
 * Shared helpers for the Form block, its submission endpoint and the entries inbox.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Field types the Form Field block supports.
 *
 * @return string[]
 */
function cozy_addons_form_field_types() {
	return array( 'text', 'email', 'tel', 'url', 'textarea', 'select', 'radio', 'checkboxes', 'number', 'date', 'time', 'datetime', 'checkbox', 'hidden', 'file', 'image', 'signature' );
}

/**
 * Field types only offered on Pro. Existing fields of these types keep working after a licence
 * ends; the editor just stops offering them.
 *
 * @return string[]
 */
function cozy_addons_form_pro_field_types() {
	return array( 'checkboxes', 'datetime', 'hidden', 'image', 'signature' );
}

/**
 * Field types whose answers come from a list of options.
 *
 * @return string[]
 */
function cozy_addons_form_choice_field_types() {
	return array( 'select', 'radio', 'checkboxes' );
}

/**
 * Form types, matching the Form block's variations.
 *
 * @return array<string,string> Type slug => label.
 */
function cozy_addons_form_types() {
	return array(
		'contact'              => __( 'Contact', 'cozy-addons' ),
		'quote'                => __( 'Quote request', 'cozy-addons' ),
		'appointment-request'  => __( 'Booking', 'cozy-addons' ),
		'service-request'      => __( 'Service request', 'cozy-addons' ),
		'product'              => __( 'Product enquiry', 'cozy-addons' ),
		'consultation-request' => __( 'Consultation', 'cozy-addons' ),
		'support-request'      => __( 'Support request', 'cozy-addons' ),
		'customer-feedback'    => __( 'Feedback', 'cozy-addons' ),
		'newsletter'           => __( 'Newsletter', 'cozy-addons' ),
		'lead-magnet'          => __( 'Lead magnet', 'cozy-addons' ),
		'waitlist'             => __( 'Waitlist', 'cozy-addons' ),
	);
}

/**
 * Whether a form type collects sign-ups rather than enquiries: newsletter, lead magnet and
 * waitlist. Their entries keep one per email, have no status pipeline and are never urgent.
 * Keep in sync with SUBSCRIPTION_TYPES in src/form/variations.js.
 *
 * @param string $type Form type slug.
 * @return bool
 */
function cozy_addons_form_type_is_subscription( $type ) {
	return in_array( $type, array( 'newsletter', 'lead-magnet', 'waitlist' ), true );
}

/**
 * Type of a stored entry. Entries saved before form types existed are contact entries.
 *
 * @param int $entry_id Entry ID.
 * @return string Type slug.
 */
function cozy_addons_form_entry_type( $entry_id ) {
	$type = (string) get_post_meta( $entry_id, '_ca_form_type', true );

	return isset( cozy_addons_form_types()[ $type ] ) ? $type : 'contact';
}

/**
 * URL of a Lead Forms admin screen: the inbox, or one of its pages ("ca-leads-analytics", "ca-form-settings").
 *
 * @param string $page Page slug, or '' for the inbox.
 * @param array  $args Extra query arguments.
 * @return string
 */
function cozy_addons_form_admin_url( $page = '', array $args = array() ) {
	$args = array_merge( array( 'post_type' => 'ca_form_entry' ), '' !== $page ? array( 'page' => $page ) : array(), $args );

	return add_query_arg( $args, admin_url( 'edit.php' ) );
}

/**
 * Form categories. Site settings choose which ones are urgent.
 *
 * @return array<string,string> Category slug => label.
 */
function cozy_addons_form_categories() {
	/**
	 * Filters the categories a form can belong to.
	 *
	 * @param array<string,string> $categories Category slug => label.
	 */
	return apply_filters(
		'cozy_addons_form_categories',
		array(
			'general'      => __( 'General enquiry', 'cozy-addons' ),
			'quote'        => __( 'Quote request', 'cozy-addons' ),
			'service'      => __( 'Service order', 'cozy-addons' ),
			'booking'      => __( 'Booking enquiry', 'cozy-addons' ),
			'support'      => __( 'Support request', 'cozy-addons' ),
			'product'      => __( 'Product enquiry', 'cozy-addons' ),
			'consultation' => __( 'Consultation request', 'cozy-addons' ),
			'feedback'     => __( 'Customer feedback', 'cozy-addons' ),
		)
	);
}

/**
 * Whether entries of a category are urgent, per Settings → General.
 *
 * @param string $category Category slug.
 * @return bool
 */
function cozy_addons_form_category_is_urgent( $category ) {
	return in_array( $category, (array) cozy_addons_form_settings()['urgent_categories'], true );
}

/**
 * Whether an entry is still New after the overdue time from Settings → General. Needs the
 * Pro status pipeline: without it entries never leave New.
 *
 * @param int $entry_id Entry ID.
 * @return bool
 */
function cozy_addons_form_entry_is_overdue( $entry_id ) {
	if ( ! cozy_addons_premium_access() || cozy_addons_form_type_is_subscription( cozy_addons_form_entry_type( $entry_id ) ) ) {
		return false;
	}
	$status = (string) get_post_meta( $entry_id, '_ca_form_status', true );
	if ( '' !== $status && 'new' !== $status ) {
		return false;
	}
	$hours = (int) cozy_addons_form_settings()['overdue_hours'];

	return ( time() - (int) get_post_time( 'U', true, $entry_id ) ) >= $hours * HOUR_IN_SECONDS;
}

/**
 * Entry pipeline statuses.
 *
 * @return array<string,string> Status slug => label.
 */
function cozy_addons_form_entry_statuses() {
	/**
	 * Filters the statuses an entry can move through. "new" must stay the first one.
	 *
	 * @param array<string,string> $statuses Status slug => label.
	 */
	return apply_filters(
		'cozy_addons_form_entry_statuses',
		array(
			'new'       => __( 'New', 'cozy-addons' ),
			'contacted' => __( 'Contacted', 'cozy-addons' ),
			'quoted'    => __( 'Quoted', 'cozy-addons' ),
			'won'       => __( 'Won', 'cozy-addons' ),
			'lost'      => __( 'Lost', 'cozy-addons' ),
		)
	);
}

/**
 * Form settings merged with defaults.
 *
 * @return array<string,mixed>
 */
function cozy_addons_form_settings() {
	$defaults = array(
		'notify_emails'        => '',
		'autoreply_enabled'    => 0,
		'autoreply_subject'    => __( 'We received your message', 'cozy-addons' ),
		'autoreply_message'    => __( "Hi {name},\n\nThanks for getting in touch. We've received your message and will reply shortly.\n\n{site}", 'cozy-addons' ),
		'ip_source'            => 'remote_addr',
		'retention_days'       => 0,
		'delete_data'          => 0,
		'turnstile_site_key'   => '',
		'turnstile_secret_key' => '',
		'captcha_default'      => '',
		'recaptcha_version'    => 'v3',
		'recaptcha_site_key'   => '',
		'recaptcha_secret_key' => '',
		'recaptcha_threshold'  => 0.5,
		'akismet'              => 0,
		'urgent_categories'    => array( 'service', 'booking' ),
		'overdue_hours'        => 24,
	);
	$saved    = get_option( 'ca_form_settings', array() );

	return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
}

/**
 * Whether Cloudflare Turnstile is in use: the site has Pro and both keys are saved.
 *
 * @return bool
 */
function cozy_addons_form_turnstile_enabled() {
	$settings = cozy_addons_form_settings();

	// Turnstile is "advanced" spam protection, a Pro feature; free sites keep the honeypot,
	// fill time and rate limit.
	return cozy_addons_premium_access() && '' !== $settings['turnstile_site_key'] && '' !== $settings['turnstile_secret_key'];
}

/**
 * Whether Google reCAPTCHA is in use: the site has Pro and both keys are saved.
 *
 * @return bool
 */
function cozy_addons_form_recaptcha_enabled() {
	$settings = cozy_addons_form_settings();

	return cozy_addons_premium_access() && '' !== $settings['recaptcha_site_key'] && '' !== $settings['recaptcha_secret_key'];
}

/**
 * The site's default spam check. "Auto" (nothing chosen yet) keeps sites as they were before
 * the choice existed: Turnstile when its keys are saved, otherwise the honeypot alone.
 *
 * @return string 'recaptcha', 'turnstile' or ''.
 */
function cozy_addons_form_default_captcha() {
	$choice = (string) cozy_addons_form_settings()['captcha_default'];
	if ( '' === $choice ) {
		return cozy_addons_form_turnstile_enabled() ? 'turnstile' : '';
	}

	return cozy_addons_form_resolve_captcha( $choice );
}

/**
 * The spam check a form actually uses. A service that is not set up, or a site without Pro,
 * leaves the honeypot, fill time and rate limit on their own.
 *
 * @param string $choice 'default', 'none', 'recaptcha' or 'turnstile'.
 * @return string 'recaptcha', 'turnstile' or ''.
 */
function cozy_addons_form_resolve_captcha( $choice ) {
	if ( 'default' === $choice ) {
		return cozy_addons_form_default_captcha();
	}
	if ( 'recaptcha' === $choice && cozy_addons_form_recaptcha_enabled() ) {
		return 'recaptcha';
	}
	if ( 'turnstile' === $choice && cozy_addons_form_turnstile_enabled() ) {
		return 'turnstile';
	}

	return '';
}

/**
 * Finds a script another plugin or the theme loads on this page from the same address as one of
 * ours, e.g. Contact Form 7's copy of Google's reCAPTCHA script. WordPress only merges scripts
 * by handle, so two plugins loading the same URL under different handles get it twice.
 *
 * @param string   $own   Our handle, which is skipped.
 * @param string[] $hosts Hosts the script is served from.
 * @param string   $path  Path of the script.
 * @return array|null Query arguments of the other copy's URL, or null when there is none.
 */
function cozy_addons_form_find_loaded_script( $own, array $hosts, $path ) {
	$scripts = wp_scripts();
	foreach ( $scripts->registered as $handle => $script ) {
		if ( $own === $handle || ! is_string( $script->src ) || '' === $script->src ) {
			continue;
		}
		$url = wp_parse_url( $script->src );
		if ( empty( $url['host'] ) || empty( $url['path'] ) || $path !== $url['path'] || ! in_array( strtolower( $url['host'] ), $hosts, true ) ) {
			continue;
		}
		// "enqueued" also covers a script that is only a dependency of an enqueued one.
		if ( wp_script_is( $handle, 'enqueued' ) || wp_script_is( $handle, 'done' ) ) {
			$args = array();
			wp_parse_str( isset( $url['query'] ) ? $url['query'] : '', $args );

			return $args;
		}
	}

	return null;
}

/**
 * Gives the Form block's sidebar the site's spam protection status (whether Turnstile or
 * reCAPTCHA keys are saved, the default check and whether Akismet is available and on: never
 * keys), the form categories and links to the Lead Forms screens.
 *
 * @return void
 */
function cozy_addons_form_editor_spam_status() {
	$handle = generate_block_asset_handle( 'cozy-block/form', 'editorScript' );
	// Not registered when the Form block is turned off in the dashboard.
	if ( ! current_user_can( 'edit_posts' ) || ! wp_script_is( $handle, 'registered' ) ) {
		return;
	}

	$status = array(
		'turnstile'        => cozy_addons_form_turnstile_enabled(),
		'recaptcha'        => cozy_addons_form_recaptcha_enabled(),
		'recaptchaVersion' => 'v2' === cozy_addons_form_settings()['recaptcha_version'] ? 'v2' : 'v3',
		'captchaDefault'   => cozy_addons_form_default_captcha(),
		'akismetAvailable' => \CozyAddons\Core\Forms\Form_Akismet::available(),
		'akismetSite'      => ! empty( cozy_addons_form_settings()['akismet'] ),
		'settingsUrl'      => current_user_can( 'manage_options' ) ? cozy_addons_form_admin_url( 'ca-form-settings', array( 'tab' => 'spam' ) ) : '',
	);

	// Categories for the form sidebar, and links to the Lead Forms screens.
	$data = array(
		'categories'       => cozy_addons_form_categories(),
		'urgentCategories' => array_values( (array) cozy_addons_form_settings()['urgent_categories'] ),
		'inboxUrl'         => cozy_addons_form_admin_url(),
	);

	wp_add_inline_script(
		$handle,
		'window.cozyFormSpam = ' . wp_json_encode( $status ) . ';' . "\n" . 'window.cozyFormData = ' . wp_json_encode( $data ) . ';',
		'before'
	);
}

/**
 * Key for sealing values that travel through the page but must stay unreadable there.
 *
 * @return string 32-byte key.
 */
function cozy_addons_form_seal_key() {
	return hash( 'sha256', 'cozy-addons-form-to|' . wp_salt( 'auth' ), true );
}

/**
 * Encrypts a value for the signed form config, e.g. the notification emails, so it cannot be
 * read in the page source. The signature already stops it being changed.
 *
 * @param string $text Plain text.
 * @return string Base64 of the nonce and the ciphertext, or '' for empty input.
 */
function cozy_addons_form_seal( $text ) {
	$text = (string) $text;
	if ( '' === $text ) {
		return '';
	}
	$nonce = random_bytes( SODIUM_CRYPTO_SECRETBOX_NONCEBYTES );

	return base64_encode( $nonce . sodium_crypto_secretbox( $text, $nonce, cozy_addons_form_seal_key() ) ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Transport encoding of ciphertext.
}

/**
 * Decrypts a value sealed by cozy_addons_form_seal().
 *
 * @param mixed $sealed Sealed value.
 * @return string Plain text, or '' when it is missing or cannot be opened.
 */
function cozy_addons_form_unseal( $sealed ) {
	$raw = is_string( $sealed ) && '' !== $sealed ? base64_decode( $sealed, true ) : false; // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- Transport encoding of ciphertext.
	if ( false === $raw || strlen( $raw ) <= SODIUM_CRYPTO_SECRETBOX_NONCEBYTES ) {
		return '';
	}
	try {
		$plain = sodium_crypto_secretbox_open( substr( $raw, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES ), substr( $raw, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES ), cozy_addons_form_seal_key() );
	} catch ( \Exception $e ) {
		return '';
	}

	return is_string( $plain ) ? $plain : '';
}

/**
 * Turns editor-stored rich text into plain text.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function cozy_addons_form_plain( $value ) {
	$value = wp_strip_all_tags( (string) $value );
	$value = html_entity_decode( $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' );

	return trim( str_replace( "\xC2\xA0", ' ', $value ) );
}

/**
 * Keeps a style value from breaking out of its CSS declaration.
 *
 * @param mixed $value Raw value, e.g. a color or a font family.
 * @return string
 */
function cozy_addons_form_css_value( $value ) {
	if ( ! is_scalar( $value ) ) {
		return '';
	}

	return esc_attr( trim( str_replace( array( ';', '{', '}', '<', '>', '"', "'", '\\' ), '', sanitize_text_field( (string) $value ) ) ) );
}

/**
 * Normalises a Form Field block's attributes. Shared by the renderer and the signed form config.
 *
 * @param array $attrs Block attributes.
 * @return array Short keys: n (name), l (label), t (type), r (required), o (options), p (placeholder), w (width),
 *               u (urgent answers), v (validation), c (conditions), and for uploads mx (size limit in MB),
 *               mf (files allowed, multiple-file fields only) and img (images only).
 */
function cozy_addons_form_normalize_field( array $attrs ) {
	$attrs = wp_parse_args(
		$attrs,
		array(
			'label'         => '',
			'fieldType'     => 'text',
			'placeholder'   => '',
			'required'      => false,
			'options'       => '',
			'name'          => '',
			'width'         => '100',
			'urgentOptions' => array(),
			'validation'    => array(),
			'conditions'    => array(),
			'maxSize'       => '5',
			'multiple'      => false,
			'maxFiles'      => '5',
		)
	);

	$label = cozy_addons_form_plain( $attrs['label'] );
	$type  = in_array( $attrs['fieldType'], cozy_addons_form_field_types(), true ) ? $attrs['fieldType'] : 'text';
	$name  = sanitize_key( (string) $attrs['name'] );
	if ( '' === $name ) {
		$name = sanitize_key( sanitize_title( $label ) );
	}
	if ( '' === $name ) {
		$name = 'field';
	}

	$options = array();
	if ( in_array( $type, cozy_addons_form_choice_field_types(), true ) ) {
		foreach ( preg_split( '/\R/', (string) $attrs['options'] ) as $line ) {
			$line = sanitize_text_field( cozy_addons_form_plain( $line ) );
			if ( '' !== $line ) {
				$options[] = $line;
			}
		}
		$options = array_slice( array_values( array_unique( $options ) ), 0, 50 );
	}

	// Answers that make an entry urgent, e.g. "Emergency – today". Only real options count.
	$urgent = array();
	foreach ( is_array( $attrs['urgentOptions'] ) ? $attrs['urgentOptions'] : array() as $answer ) {
		$answer = sanitize_text_field( cozy_addons_form_plain( $answer ) );
		if ( in_array( $answer, $options, true ) ) {
			$urgent[] = $answer;
		}
	}

	$field = array(
		'n' => $name,
		'l' => $label,
		't' => $type,
		'r' => 'hidden' !== $type && (bool) $attrs['required'],
		'o' => $options,
		'p' => cozy_addons_form_plain( $attrs['placeholder'] ),
		'w' => '50' === (string) $attrs['width'] ? '50' : '100',
		'u' => array_values( array_unique( $urgent ) ),
		'v' => cozy_addons_form_normalize_validation( $attrs['validation'], $type ),
		'c' => cozy_addons_form_normalize_conditions( $attrs['conditions'] ),
	);

	// Upload limits, signed so visitors cannot raise them: size per file in MB and, for a
	// multiple-file field (Pro), how many files.
	if ( in_array( $type, array( 'file', 'image' ), true ) ) {
		$field['mx'] = max( 1, min( \CozyAddons\Core\Forms\Form_Uploads::server_limit_mb(), absint( $attrs['maxSize'] ) ) );
		if ( ! empty( $attrs['multiple'] ) ) {
			$field['mf'] = max( 2, min( 10, absint( $attrs['maxFiles'] ) ) );
		}
		if ( 'image' === $type ) {
			$field['img'] = 1;
		}
	}

	return $field;
}

/**
 * Cleans a field's advanced validation rules (Pro): length limits for text, a pattern for short
 * text, and a range for numbers, with an optional custom error message. A pattern that is not a
 * valid regular expression is dropped, so it can never break the form.
 *
 * @param mixed  $rules Raw rules from the block.
 * @param string $type  Field type.
 * @return array Only the rules that apply, with short keys.
 */
function cozy_addons_form_normalize_validation( $rules, $type ) {
	$rules = is_array( $rules ) ? $rules : array();
	$out   = array();

	if ( in_array( $type, array( 'text', 'textarea' ), true ) ) {
		foreach ( array(
			'minLength' => 'minl',
			'maxLength' => 'maxl',
		) as $key => $short ) {
			if ( isset( $rules[ $key ] ) && '' !== (string) $rules[ $key ] && absint( $rules[ $key ] ) > 0 ) {
				$out[ $short ] = absint( $rules[ $key ] );
			}
		}
	}
	if ( 'text' === $type && isset( $rules['pattern'] ) && is_string( $rules['pattern'] ) && '' !== $rules['pattern'] ) {
		$pattern = mb_substr( $rules['pattern'], 0, 300 );
		// Same anchoring as the HTML pattern attribute. Invalid expressions are left out.
		if ( false !== @preg_match( cozy_addons_form_pattern_regex( $pattern ), '' ) ) { // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- Testing whether a site owner's regex compiles.
			$out['pat'] = $pattern;
		}
	}
	if ( 'number' === $type ) {
		foreach ( array( 'min', 'max' ) as $key ) {
			if ( isset( $rules[ $key ] ) && '' !== (string) $rules[ $key ] && is_numeric( $rules[ $key ] ) ) {
				$out[ $key ] = (float) $rules[ $key ];
			}
		}
	}
	if ( $out && isset( $rules['message'] ) && is_string( $rules['message'] ) ) {
		$message = sanitize_text_field( cozy_addons_form_plain( $rules['message'] ) );
		if ( '' !== $message ) {
			$out['msg'] = mb_substr( $message, 0, 200 );
		}
	}

	return $out;
}

/**
 * PCRE version of a field pattern, anchored like the HTML pattern attribute.
 *
 * @param string $pattern Pattern from the block.
 * @return string Regular expression.
 */
function cozy_addons_form_pattern_regex( $pattern ) {
	return '@^(?:' . str_replace( '@', '\\@', $pattern ) . ')$@u';
}

/**
 * Cleans a field's conditional logic (Pro): show or hide the field when all or any rules match.
 *
 * @param mixed $conditions Raw conditions from the block.
 * @return array Empty when off, otherwise action (a), match (m) and rules (r: [field, operator, value]).
 */
function cozy_addons_form_normalize_conditions( $conditions ) {
	if ( ! is_array( $conditions ) || empty( $conditions['enabled'] ) || empty( $conditions['rules'] ) || ! is_array( $conditions['rules'] ) ) {
		return array();
	}

	$rules = array();
	foreach ( array_slice( $conditions['rules'], 0, 10 ) as $rule ) {
		$field = is_array( $rule ) && isset( $rule['field'] ) ? sanitize_key( (string) $rule['field'] ) : '';
		$op    = is_array( $rule ) && isset( $rule['op'] ) ? (string) $rule['op'] : '';
		if ( '' === $field || ! in_array( $op, array( 'is', 'is_not', 'contains', 'empty', 'not_empty' ), true ) ) {
			continue;
		}
		$rules[] = array( $field, $op, sanitize_text_field( cozy_addons_form_plain( isset( $rule['value'] ) ? $rule['value'] : '' ) ) );
	}
	if ( empty( $rules ) ) {
		return array();
	}

	return array(
		'a' => isset( $conditions['action'] ) && 'hide' === $conditions['action'] ? 'hide' : 'show',
		'm' => isset( $conditions['match'] ) && 'any' === $conditions['match'] ? 'any' : 'all',
		'r' => $rules,
	);
}

/**
 * Whether one conditional-logic rule matches a field's submitted value.
 *
 * @param string       $op       Operator.
 * @param string|array $value    Submitted value; an array for checkbox groups.
 * @param string       $expected Value from the rule.
 * @return bool
 */
function cozy_addons_form_rule_matches( $op, $value, $expected ) {
	$values = is_array( $value ) ? array_map( 'strval', $value ) : ( '' === (string) $value ? array() : array( (string) $value ) );

	switch ( $op ) {
		case 'empty':
			return empty( $values );
		case 'not_empty':
			return ! empty( $values );
		case 'is':
			return in_array( $expected, $values, true );
		case 'is_not':
			return ! in_array( $expected, $values, true );
		case 'contains':
			return '' !== $expected && false !== mb_stripos( implode( ', ', $values ), $expected );
	}

	return false;
}

/**
 * Names of the fields that conditional logic hides for the submitted values. Fields hidden by
 * their own rules count as empty for the rules of others, re-checked until nothing changes.
 * The browser runs the same logic in frontend/form.js.
 *
 * @param array $fields Normalised fields from the signed config.
 * @param array $posted Submitted values keyed by field name.
 * @return array<string,bool> Hidden field names as keys.
 */
function cozy_addons_form_hidden_fields( array $fields, array $posted ) {
	$hidden = array();
	for ( $pass = 0; $pass < 5; $pass++ ) {
		$changed = false;
		foreach ( $fields as $field ) {
			if ( ! is_array( $field ) || empty( $field['n'] ) || empty( $field['c']['r'] ) || ! is_array( $field['c']['r'] ) ) {
				continue;
			}
			$results = array();
			foreach ( $field['c']['r'] as $rule ) {
				if ( ! is_array( $rule ) || count( $rule ) < 3 ) {
					continue;
				}
				$target    = (string) $rule[0];
				$value     = isset( $hidden[ $target ] ) ? '' : ( isset( $posted[ $target ] ) ? $posted[ $target ] : '' );
				$results[] = cozy_addons_form_rule_matches( (string) $rule[1], $value, (string) $rule[2] );
			}
			if ( empty( $results ) ) {
				continue;
			}
			$matched   = 'any' === ( $field['c']['m'] ?? 'all' ) ? in_array( true, $results, true ) : ! in_array( false, $results, true );
			$is_hidden = 'hide' === ( $field['c']['a'] ?? 'show' ) ? $matched : ! $matched;
			if ( $is_hidden !== isset( $hidden[ $field['n'] ] ) ) {
				if ( $is_hidden ) {
					$hidden[ $field['n'] ] = true;
				} else {
					unset( $hidden[ $field['n'] ] );
				}
				$changed = true;
			}
		}
		if ( ! $changed ) {
			break;
		}
	}

	return $hidden;
}

/**
 * Walks parsed inner blocks and collects every Form Field block, also inside steps, columns and groups.
 *
 * @param array $blocks Parsed blocks.
 * @return array Normalised fields.
 */
function cozy_addons_form_collect_fields( array $blocks ) {
	$out = array();
	foreach ( $blocks as $block ) {
		if ( isset( $block['blockName'] ) && 'cozy-block/form-field' === $block['blockName'] ) {
			$out[] = cozy_addons_form_normalize_field( isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array() );
		} elseif ( ! empty( $block['innerBlocks'] ) ) {
			$out = array_merge( $out, cozy_addons_form_collect_fields( $block['innerBlocks'] ) );
		}
	}

	return $out;
}

/**
 * Whether the inner blocks contain a Form Step block.
 *
 * @param array $blocks Parsed blocks.
 * @return bool
 */
function cozy_addons_form_has_steps( array $blocks ) {
	foreach ( $blocks as $block ) {
		if ( isset( $block['blockName'] ) && 'cozy-block/form-step' === $block['blockName'] ) {
			return true;
		}
		if ( ! empty( $block['innerBlocks'] ) && cozy_addons_form_has_steps( $block['innerBlocks'] ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Titles of the Form Step blocks, in order. Untitled steps get an empty string.
 *
 * @param array $blocks Parsed blocks.
 * @return string[]
 */
function cozy_addons_form_step_titles( array $blocks ) {
	$titles = array();
	foreach ( $blocks as $block ) {
		if ( isset( $block['blockName'] ) && 'cozy-block/form-step' === $block['blockName'] ) {
			$titles[] = cozy_addons_form_plain( isset( $block['attrs']['title'] ) ? $block['attrs']['title'] : '' );
		} elseif ( ! empty( $block['innerBlocks'] ) ) {
			$titles = array_merge( $titles, cozy_addons_form_step_titles( $block['innerBlocks'] ) );
		}
	}

	return $titles;
}

/**
 * Signs a form config so the browser cannot change its fields or recipients.
 *
 * The context prefix keeps these signatures apart from other plugins that sign with the same salt.
 *
 * @param string $json Encoded form config.
 * @return string
 */
function cozy_addons_form_sign( $json ) {
	return hash_hmac( 'sha256', 'cozy-addons-form|' . $json, wp_salt( 'auth' ) );
}

/**
 * Verifies a signed form config and decodes it.
 *
 * @param mixed $json Encoded form config from the request.
 * @param mixed $sig  Signature from the request.
 * @return array|null The config, or null when it is missing, too large or tampered with.
 */
function cozy_addons_form_verify( $json, $sig ) {
	$json = is_string( $json ) ? $json : '';
	$sig  = is_string( $sig ) ? $sig : '';

	if ( '' === $json || strlen( $json ) > 40000 || '' === $sig || ! hash_equals( cozy_addons_form_sign( $json ), $sig ) ) {
		return null;
	}

	$config = json_decode( $json, true );

	return is_array( $config ) ? $config : null;
}

/**
 * Best-effort client IP, used only for rate limiting and never stored.
 *
 * Forwarded headers are trusted only when the site owner opted in under Lead Forms → Settings.
 *
 * @return string
 */
function cozy_addons_form_client_ip() {
	$settings   = cozy_addons_form_settings();
	$candidates = array();

	if ( 'cloudflare' === $settings['ip_source'] && isset( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
		$candidates[] = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ) );
	} elseif ( 'forwarded' === $settings['ip_source'] && isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$parts        = explode( ',', sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) );
		$candidates[] = trim( $parts[0] );
	}
	if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
		$candidates[] = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
	}

	$ip = '';
	foreach ( $candidates as $candidate ) {
		if ( false !== filter_var( $candidate, FILTER_VALIDATE_IP ) ) {
			$ip = $candidate;
			break;
		}
	}

	/**
	 * Filters the IP address used for rate limiting form submissions.
	 *
	 * @param string $ip Detected IP address.
	 */
	return (string) apply_filters( 'cozy_addons_form_client_ip', $ip );
}

/**
 * Cleans a comma-separated list of email addresses.
 *
 * @param mixed $emails_raw Raw list.
 * @return string[] Valid addresses.
 */
function cozy_addons_form_parse_emails( $emails_raw ) {
	$emails = array();
	foreach ( explode( ',', is_scalar( $emails_raw ) ? (string) $emails_raw : '' ) as $candidate ) {
		$candidate = sanitize_email( trim( $candidate ) );
		if ( is_email( $candidate ) ) {
			$emails[] = $candidate;
		}
	}

	return array_values( array_unique( $emails ) );
}

/**
 * Prints the "PRO" pill used for locked features in the admin.
 *
 * @return void
 */
function cozy_addons_form_print_pro_label() {
	echo '<span class="ca-form-pro-label">' . esc_html__( 'PRO', 'cozy-addons' ) . '</span>';
}
