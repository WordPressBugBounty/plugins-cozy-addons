<?php
/**
 * Cloudflare Turnstile for the Form block.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prints the Turnstile widget and verifies its token on the server.
 *
 * Only the site key, which Cloudflare designed to be public, reaches the page. The secret key is
 * only ever sent from this server to Cloudflare.
 */
final class Form_Turnstile {

	const ACTION = 'cozy-form';

	const HANDLE = 'cozy-addons--turnstile';

	/**
	 * Markup of the widget, and loads Cloudflare's script. Empty when Turnstile is not set up.
	 *
	 * @param bool $inline Whether the form uses the inline layout; the widget then only shows when a visitor must interact.
	 * @return string HTML.
	 */
	public static function widget( $inline = false ) {
		if ( ! cozy_addons_form_turnstile_enabled() ) {
			return '';
		}

		wp_enqueue_script(
			self::HANDLE,
			'https://challenges.cloudflare.com/turnstile/v0/api.js',
			array(),
			null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- External script, versioned by Cloudflare.
			array(
				'in_footer' => true,
				'strategy'  => 'async',
			)
		);
		// Before footer scripts print (priority 20), once every block and plugin has enqueued its own.
		add_action( 'wp_footer', array( __CLASS__, 'skip_duplicate_script' ), 1 );

		return '<div class="cf-turnstile cozy-form__turnstile" data-sitekey="' . esc_attr( cozy_addons_form_settings()['turnstile_site_key'] ) . '" data-action="' . esc_attr( self::ACTION ) . '"' . ( $inline ? ' data-appearance="interaction-only"' : '' ) . '></div>';
	}

	/**
	 * Drops our copy of Cloudflare's script when another plugin (Contact Form 7, Cozy Leads) already
	 * loads it: a second copy can draw a second widget. Their copy draws ours too, as it finds every
	 * .cf-turnstile box on the page, unless it was loaded for explicit rendering only.
	 *
	 * @return void
	 */
	public static function skip_duplicate_script() {
		if ( ! wp_script_is( self::HANDLE, 'enqueued' ) ) {
			return;
		}
		$other = cozy_addons_form_find_loaded_script( self::HANDLE, array( 'challenges.cloudflare.com' ), '/turnstile/v0/api.js' );
		if ( null !== $other && ( ! isset( $other['render'] ) || 'explicit' !== $other['render'] ) ) {
			wp_dequeue_script( self::HANDLE );
		}
	}

	/**
	 * Verifies a Turnstile token with Cloudflare. Fails closed when Cloudflare cannot be reached.
	 *
	 * @param mixed $token Token posted by the widget.
	 * @return bool True when Cloudflare confirmed it for this form action.
	 */
	public static function verify( $token ) {
		$token = is_string( $token ) ? $token : '';
		if ( '' === $token || strlen( $token ) > 2048 ) {
			return false;
		}

		$response = wp_remote_post(
			'https://challenges.cloudflare.com/turnstile/v0/siteverify',
			array(
				'timeout' => 10,
				'body'    => array(
					'secret'   => cozy_addons_form_settings()['turnstile_secret_key'],
					'response' => $token,
					'remoteip' => cozy_addons_form_client_ip(),
				),
			)
		);
		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			return false;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		// A token issued for another site's widget or action is refused too.
		return is_array( $body ) && ! empty( $body['success'] ) && ( ! isset( $body['action'] ) || self::ACTION === $body['action'] );
	}
}
