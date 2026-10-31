<?php
/**
 * Brevo: adds form contacts to a list.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Talks to the Brevo API. The API key only ever travels from this server to Brevo.
 */
final class Integration_Brevo {

	const BASE = 'https://api.brevo.com/v3';

	/**
	 * One API request.
	 *
	 * @param string     $method HTTP method.
	 * @param string     $path   Path under the API root.
	 * @param array|null $body   JSON body.
	 * @param string     $key    API key; the saved one when empty.
	 * @return array{code:int,data:mixed}|\WP_Error
	 */
	private static function request( $method, $path, $body = null, $key = '' ) {
		$key  = '' !== $key ? $key : (string) cozy_addons_form_settings()['brevo_key'];
		$args = array(
			'method'  => $method,
			'timeout' => 8,
			'headers' => array(
				'api-key'      => $key,
				'Accept'       => 'application/json',
				'Content-Type' => 'application/json',
			),
		);
		if ( null !== $body ) {
			$args['body'] = wp_json_encode( $body );
		}
		$response = wp_remote_request( self::BASE . $path, $args );
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return array(
			'code' => (int) wp_remote_retrieve_response_code( $response ),
			'data' => json_decode( wp_remote_retrieve_body( $response ), true ),
		);
	}

	/**
	 * Account name, to confirm a key works.
	 *
	 * @param string $key API key.
	 * @return string|\WP_Error
	 */
	public static function account( $key ) {
		if ( ! preg_match( '/^[A-Za-z0-9_\-]{20,200}$/', (string) $key ) ) {
			return new \WP_Error( 'cozy_brevo_key', __( 'This does not look like a Brevo API key.', 'cozy-addons' ) );
		}
		$result = self::request( 'GET', '/account', null, $key );
		if ( is_wp_error( $result ) ) {
			return new \WP_Error( 'cozy_brevo_down', __( 'Could not reach Brevo. Please try again.', 'cozy-addons' ) );
		}
		if ( 200 !== $result['code'] ) {
			return new \WP_Error( 'cozy_brevo_key', __( 'Brevo did not accept this API key.', 'cozy-addons' ) );
		}
		$data = is_array( $result['data'] ) ? $result['data'] : array();

		return sanitize_text_field( (string) ( ! empty( $data['companyName'] ) ? $data['companyName'] : ( $data['email'] ?? '' ) ) );
	}

	/**
	 * Lists of the connected account, up to 500.
	 *
	 * @return array<int,array{id:string,name:string}>|\WP_Error
	 */
	public static function lists() {
		$lists = array();
		for ( $offset = 0; $offset < 500; $offset += 50 ) {
			$result = self::request( 'GET', '/contacts/lists?limit=50&offset=' . $offset );
			if ( is_wp_error( $result ) || 200 !== $result['code'] ) {
				return new \WP_Error( 'cozy_brevo_lists', __( 'Could not load your Brevo lists.', 'cozy-addons' ) );
			}
			$page = isset( $result['data']['lists'] ) && is_array( $result['data']['lists'] ) ? $result['data']['lists'] : array();
			foreach ( $page as $list ) {
				$lists[] = array(
					'id'   => (string) absint( $list['id'] ),
					'name' => sanitize_text_field( (string) $list['name'] ),
				);
			}
			if ( count( $page ) < 50 ) {
				break;
			}
		}

		return $lists;
	}

	/**
	 * Adds or updates a contact, or with double opt-in sends Brevo's confirmation email first.
	 *
	 * @param string $list    List ID.
	 * @param array  $contact email, first, last, phone.
	 * @param bool   $double  Double opt-in.
	 * @return array{0:string,1:string} Status ("ok", "retry" or "fail") and a short message.
	 */
	public static function subscribe( $list, array $contact, $double ) {
		$settings   = cozy_addons_form_settings();
		$attributes = array_filter(
			array(
				'FIRSTNAME' => $contact['first'],
				'LASTNAME'  => $contact['last'],
			),
			'strlen'
		);

		if ( $double ) {
			if ( empty( $settings['brevo_doi_template'] ) ) {
				return array( 'fail', __( 'Double opt-in needs a Brevo template ID under Lead Forms → Settings → Integrations.', 'cozy-addons' ) );
			}
			$body = array(
				'email'          => $contact['email'],
				'includeListIds' => array( (int) $list ),
				'templateId'     => (int) $settings['brevo_doi_template'],
				'redirectionUrl' => '' !== $settings['brevo_doi_redirect'] ? $settings['brevo_doi_redirect'] : home_url( '/' ),
			);
			if ( $attributes ) {
				$body['attributes'] = $attributes;
			}
			$status = self::outcome( self::request( 'POST', '/contacts/doubleOptinConfirmation', $body ) );

			return 'ok' === $status[0] ? array( 'ok', __( 'Confirmation email sent', 'cozy-addons' ) ) : $status;
		}

		$body = array(
			'email'         => $contact['email'],
			'listIds'       => array( (int) $list ),
			'updateEnabled' => true,
		);
		if ( $attributes ) {
			$body['attributes'] = $attributes;
		}
		$status = self::outcome( self::request( 'POST', '/contacts', $body ) );

		return 'ok' === $status[0] ? array( 'ok', __( 'Added', 'cozy-addons' ) ) : $status;
	}

	/**
	 * Turns a response into a job status. Only Brevo's short error code is kept.
	 *
	 * @param array|\WP_Error $result Response.
	 * @return array{0:string,1:string}
	 */
	private static function outcome( $result ) {
		if ( is_wp_error( $result ) ) {
			return array( 'retry', __( 'Could not reach Brevo', 'cozy-addons' ) );
		}
		if ( $result['code'] >= 200 && $result['code'] < 300 ) {
			return array( 'ok', '' );
		}
		if ( 429 === $result['code'] || $result['code'] >= 500 ) {
			/* translators: %d: HTTP status code */
			return array( 'retry', sprintf( __( 'Brevo is unavailable (HTTP %d)', 'cozy-addons' ), $result['code'] ) );
		}
		$code = isset( $result['data']['code'] ) ? sanitize_key( (string) $result['data']['code'] ) : '';

		/* translators: 1: HTTP status code, 2: Brevo's error code, e.g. "invalid_parameter" */
		return array( 'fail', trim( sprintf( __( 'Brevo refused the contact (HTTP %1$d) %2$s', 'cozy-addons' ), $result['code'], $code ) ) );
	}
}
