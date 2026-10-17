<?php
/**
 * Google reCAPTCHA for the Form block.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prints the reCAPTCHA widget (v2) or marks the form for an invisible check (v3), and verifies
 * tokens on the server.
 *
 * Only the site key, which Google designed to be public, reaches the page. The secret key is
 * only ever sent from this server to Google.
 */
final class Form_Recaptcha {

	/**
	 * Action name reCAPTCHA v3 tokens are issued for. Must match frontend/form.js.
	 */
	const ACTION = 'cozy_form';

	const HANDLE = 'cozy-addons--recaptcha';

	/**
	 * The version chosen under Lead Forms → Settings → Spam protection.
	 *
	 * @return string 'v2' or 'v3'.
	 */
	public static function version() {
		return 'v2' === cozy_addons_form_settings()['recaptcha_version'] ? 'v2' : 'v3';
	}

	/**
	 * Markup for the form, and loads Google's script after the form's own script, which drives it.
	 *
	 * @return string HTML. Empty when reCAPTCHA is not set up.
	 */
	public static function widget() {
		if ( ! cozy_addons_form_recaptcha_enabled() ) {
			return '';
		}
		$site_key = (string) cozy_addons_form_settings()['recaptcha_site_key'];
		$v3       = 'v3' === self::version();

		wp_enqueue_script(
			self::HANDLE,
			add_query_arg( 'render', $v3 ? rawurlencode( $site_key ) : 'explicit', 'https://www.google.com/recaptcha/api.js' ),
			array( 'cozy-block--form--frontend-script' ), // The Form block's view script (includes/class-blocks.php), which drives reCAPTCHA.
			null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- External script, versioned by Google.
			array( 'in_footer' => true )
		);
		// Before footer scripts print (priority 20), once every block and plugin has enqueued its own.
		add_action( 'wp_footer', array( __CLASS__, 'skip_duplicate_script' ), 1 );

		if ( $v3 ) {
			// Filled with a fresh token by frontend/form.js just before the form is sent.
			return '<input type="hidden" name="cozy_addons_form_rc" value="" class="cozy-form__recaptcha-v3" data-sitekey="' . esc_attr( $site_key ) . '" data-action="' . esc_attr( self::ACTION ) . '">';
		}

		return '<div class="cozy-form__recaptcha cozy-form__captcha" data-sitekey="' . esc_attr( $site_key ) . '"></div>';
	}

	/**
	 * Google's script under another plugin's handle on this page (Contact Form 7 loads it on every
	 * page), as the query arguments of its URL. Null when there is none.
	 *
	 * @return array|null
	 */
	public static function other_script() {
		return cozy_addons_form_find_loaded_script( self::HANDLE, array( 'www.google.com', 'google.com', 'www.recaptcha.net', 'recaptcha.net' ), '/recaptcha/api.js' );
	}

	/**
	 * Whether another copy of Google's script can drive our forms: any copy can draw the v2
	 * checkbox, but v3 tokens only come for the site key the script was loaded with.
	 *
	 * @param array $other Query arguments of the other copy's URL.
	 * @return bool
	 */
	public static function can_share( array $other ) {
		if ( 'v2' === self::version() ) {
			return true;
		}

		return isset( $other['render'] ) && (string) cozy_addons_form_settings()['recaptcha_site_key'] === $other['render'];
	}

	/**
	 * Drops our copy of Google's script when another plugin already loads one that works for our
	 * forms. Google does not support the script twice on a page: whichever copy loads first owns
	 * window.grecaptcha. With a different v3 key both stay, and Settings warns about it.
	 *
	 * @return void
	 */
	public static function skip_duplicate_script() {
		if ( ! wp_script_is( self::HANDLE, 'enqueued' ) ) {
			return;
		}
		$other = self::other_script();
		if ( null !== $other && self::can_share( $other ) ) {
			wp_dequeue_script( self::HANDLE );
		}
	}

	/**
	 * Site key Contact Form 7's reCAPTCHA integration uses, when it is set up. CF7 loads Google's
	 * script on every page with that key.
	 *
	 * @return string Empty when CF7's reCAPTCHA is not active.
	 */
	public static function cf7_site_key() {
		if ( ! class_exists( 'WPCF7_RECAPTCHA' ) ) {
			return '';
		}
		$service = \WPCF7_RECAPTCHA::get_instance();

		return $service->is_active() ? (string) $service->get_sitekey() : '';
	}

	/**
	 * Verifies a token with Google. Fails closed when Google cannot be reached.
	 *
	 * @param mixed $token Token from the widget (v2) or from grecaptcha.execute() (v3).
	 * @return bool True when Google confirmed it for this site, and for v3 with a good enough score.
	 */
	public static function verify( $token ) {
		$token = is_string( $token ) ? $token : '';
		if ( '' === $token || strlen( $token ) > 4096 ) {
			return false;
		}
		$settings = cozy_addons_form_settings();

		$response = wp_remote_post(
			'https://www.google.com/recaptcha/api/siteverify',
			array(
				'timeout' => 10,
				'body'    => array(
					'secret'   => $settings['recaptcha_secret_key'],
					'response' => $token,
					'remoteip' => cozy_addons_form_client_ip(),
				),
			)
		);
		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			return false;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! is_array( $body ) || empty( $body['success'] ) ) {
			return false;
		}

		// A token solved on another site is refused.
		$host = wp_parse_url( home_url(), PHP_URL_HOST );
		if ( isset( $body['hostname'] ) && is_string( $host ) && strtolower( (string) $body['hostname'] ) !== strtolower( $host ) ) {
			return false;
		}

		if ( 'v3' === self::version() ) {
			$threshold = min( 0.9, max( 0.1, (float) $settings['recaptcha_threshold'] ) );

			return isset( $body['action'], $body['score'] ) && self::ACTION === $body['action'] && (float) $body['score'] >= $threshold;
		}

		return true;
	}
}
