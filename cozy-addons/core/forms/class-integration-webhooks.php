<?php
/**
 * Webhooks: sends each new entry to the site owner's endpoints, e.g. Zapier, Make or n8n.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Posts signed JSON to webhook endpoints.
 *
 * Requests go through wp_safe_remote_post(), which refuses local and private network addresses,
 * so a webhook cannot be used to reach the server's own network.
 */
final class Integration_Webhooks {

	const MAX = 5;

	/**
	 * Saved webhooks that are switched on and complete. Pro only.
	 *
	 * @return array<string,array{id:string,url:string,secret:string,active:int}> Keyed by ID.
	 */
	public static function active() {
		if ( ! cozy_addons_premium_access() ) {
			return array();
		}
		$out = array();
		foreach ( (array) cozy_addons_form_settings()['webhooks'] as $row ) {
			if ( is_array( $row ) && ! empty( $row['active'] ) && ! empty( $row['id'] ) && ! empty( $row['url'] ) && ! empty( $row['secret'] ) ) {
				$out[ $row['id'] ] = $row;
			}
		}

		return $out;
	}

	/**
	 * A saved webhook, active or not.
	 *
	 * @param string $id Webhook ID.
	 * @return array|null
	 */
	public static function get( $id ) {
		foreach ( (array) cozy_addons_form_settings()['webhooks'] as $row ) {
			if ( is_array( $row ) && isset( $row['id'] ) && $row['id'] === $id ) {
				return $row;
			}
		}

		return null;
	}

	/**
	 * Host of a webhook URL, to show which endpoint a delivery went to without its path or tokens.
	 *
	 * @param string $url Endpoint URL.
	 * @return string
	 */
	public static function host( $url ) {
		$host = wp_parse_url( (string) $url, PHP_URL_HOST );

		return is_string( $host ) ? $host : '';
	}

	/**
	 * Posts a payload. The body is signed with the webhook's secret so the receiver can check it
	 * came from this site: X-Cozy-Signature is "sha256=" and the HMAC-SHA256 of the raw body.
	 *
	 * @param array  $webhook Saved webhook.
	 * @param array  $payload Data to send.
	 * @param string $event   Event name.
	 * @return array{0:string,1:string} Status ("ok", "retry" or "fail") and a short message.
	 */
	public static function deliver( array $webhook, array $payload, $event = 'entry.created' ) {
		// The same check wp_safe_remote_post() makes; such an address will not work on a retry either.
		if ( ! wp_http_validate_url( $webhook['url'] ) ) {
			return array( 'fail', __( 'This address is not allowed', 'cozy-addons' ) );
		}
		$body     = wp_json_encode( $payload );
		$response = wp_safe_remote_post(
			$webhook['url'],
			array(
				'timeout'     => 8,
				'redirection' => 2,
				'headers'     => array(
					'Content-Type'     => 'application/json',
					'User-Agent'       => 'CozyBlocks/' . ( defined( 'COZY_ADDONS_VERSION' ) ? COZY_ADDONS_VERSION : '1' ) . '; ' . home_url( '/' ),
					'X-Cozy-Event'     => $event,
					'X-Cozy-Signature' => 'sha256=' . hash_hmac( 'sha256', (string) $body, (string) $webhook['secret'] ),
				),
				'body'        => $body,
			)
		);

		if ( is_wp_error( $response ) ) {
			return array( 'retry', __( 'Could not reach the endpoint', 'cozy-addons' ) );
		}
		$code = (int) wp_remote_retrieve_response_code( $response );
		if ( $code >= 200 && $code < 300 ) {
			/* translators: %d: HTTP status code */
			return array( 'ok', sprintf( __( 'Sent (HTTP %d)', 'cozy-addons' ), $code ) );
		}

		/* translators: %d: HTTP status code */
		$message = sprintf( __( 'The endpoint answered HTTP %d', 'cozy-addons' ), $code );

		return array( 429 === $code || $code >= 500 ? 'retry' : 'fail', $message );
	}
}
