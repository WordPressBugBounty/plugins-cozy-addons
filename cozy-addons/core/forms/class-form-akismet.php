<?php
/**
 * Akismet check for form submissions.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Asks Akismet whether a submission is spam, through the Akismet plugin.
 *
 * The Akismet plugin adds its own API key to the request. This class only checks that a key
 * exists and never reads it into a variable, stores it, prints it or logs it.
 */
final class Form_Akismet {

	/**
	 * Whether the Akismet plugin is active and has an API key.
	 *
	 * @return bool
	 */
	public static function available() {
		return class_exists( '\Akismet' )
			&& is_callable( array( '\Akismet', 'get_api_key' ) )
			&& is_callable( array( '\Akismet', 'http_post' ) )
			&& '' !== (string) \Akismet::get_api_key();
	}

	/**
	 * Whether a form's submissions should be checked. Akismet is "advanced" spam protection, a Pro
	 * feature.
	 *
	 * @param string $mode The form's choice: "on", "off", or "default" to follow the site setting.
	 * @return bool
	 */
	public static function enabled( $mode = 'default' ) {
		if ( 'off' === $mode || ! cozy_addons_premium_access() || ! self::available() ) {
			return false;
		}

		return 'on' === $mode || ! empty( cozy_addons_form_settings()['akismet'] );
	}

	/**
	 * Asks Akismet about a submission. Fails open: when Akismet cannot answer the submission is
	 * accepted, as the honeypot, rate limit and Turnstile still apply.
	 *
	 * @param array  $values Sanitized values.
	 * @param string $page   Page the form was submitted from.
	 * @return bool True when Akismet says it is spam.
	 */
	public static function is_spam( array $values, $page ) {
		$author  = '';
		$email   = '';
		$content = array();
		foreach ( $values as $row ) {
			$value = (string) $row['v'];
			if ( '' === $email && 'email' === $row['t'] ) {
				$email = $value;
			} elseif ( '' === $author && 'text' === $row['t'] && false !== stripos( $row['l'], 'name' ) ) {
				$author = $value;
			} elseif ( in_array( $row['t'], array( 'textarea', 'text', 'select', 'radio' ), true ) && '' !== $value ) {
				$content[] = $value;
			}
		}

		$data = array(
			'blog'                 => home_url(),
			'blog_lang'            => get_locale(),
			'blog_charset'         => get_option( 'blog_charset' ),
			'user_ip'              => cozy_addons_form_client_ip(),
			'user_agent'           => isset( $_SERVER['HTTP_USER_AGENT'] ) ? mb_substr( sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ), 0, 500 ) : '',
			'referrer'             => isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( mb_substr( wp_unslash( $_SERVER['HTTP_REFERER'] ), 0, 500 ) ) : '', // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized by esc_url_raw().
			'permalink'            => $page,
			'comment_type'         => 'contact-form',
			'comment_author'       => $author,
			'comment_author_email' => $email,
			'comment_content'      => implode( "\n", $content ),
			'honeypot_field_name'  => 'cozy_addons_form_hp',
		);

		/**
		 * Filters the data sent to Akismet for a form submission.
		 *
		 * @param array $data   Akismet comment-check parameters.
		 * @param array $values Sanitized values.
		 */
		$data = apply_filters( 'cozy_addons_form_akismet_data', $data, $values );

		$response = \Akismet::http_post( \Akismet::build_query( $data ), 'comment-check' );

		return is_array( $response ) && isset( $response[1] ) && 'true' === trim( (string) $response[1] );
	}
}
