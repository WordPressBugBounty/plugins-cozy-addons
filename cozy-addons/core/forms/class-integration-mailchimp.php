<?php
/**
 * Mailchimp: adds form contacts to an audience with the Lists API.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Talks to the Mailchimp Marketing API. The API key only ever travels from this server to Mailchimp.
 */
final class Integration_Mailchimp {

	/**
	 * API root for a key. Mailchimp keys end in their data centre, e.g. "-us21".
	 *
	 * @param string $key API key.
	 * @return string Empty for a key without a data centre.
	 */
	public static function base( $key ) {
		return preg_match( '/-([a-z]{2,4}[0-9]{1,3})$/', (string) $key, $m ) ? 'https://' . $m[1] . '.api.mailchimp.com/3.0' : '';
	}

	/**
	 * Whether a key looks like a Mailchimp key.
	 *
	 * @param string $key API key.
	 * @return bool
	 */
	public static function valid_key( $key ) {
		return '' !== self::base( $key ) && (bool) preg_match( '/^[a-f0-9]{32}-[a-z]{2,4}[0-9]{1,3}$/', (string) $key );
	}

	/**
	 * One API request, made by this server. The key travels only in the HTTPS Authorization
	 * header to Mailchimp; never in the URL, the body, or anything a visitor or the page can see.
	 *
	 * @param string     $method HTTP method.
	 * @param string     $path   Path under the API root.
	 * @param array|null $body   JSON body.
	 * @param string     $key    API key; the saved one when empty.
	 * @param string     $scheme "Bearer", or "Basic" for the account lookup fallback.
	 * @return array{code:int,data:mixed}|\WP_Error
	 */
	private static function request( $method, $path, $body = null, $key = '', $scheme = 'Bearer' ) {
		$key  = '' !== $key ? $key : (string) cozy_addons_form_settings()['mailchimp_key'];
		$base = self::base( $key );
		if ( '' === $base ) {
			return new \WP_Error( 'cozy_mailchimp_key', __( 'The Mailchimp API key is not valid.', 'cozy-addons' ) );
		}

		$args = array(
			'method'  => $method,
			'timeout' => 8,
			'headers' => array(
				'Authorization' => 'Basic' === $scheme
					? 'Basic ' . base64_encode( 'cozy:' . $key ) // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- HTTP Basic auth.
					: 'Bearer ' . $key,
				'Accept'        => 'application/json',
				'Content-Type'  => 'application/json',
			),
		);
		if ( null !== $body ) {
			$args['body'] = wp_json_encode( $body );
		}
		$response = wp_remote_request( $base . $path, $args );
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
		if ( ! self::valid_key( $key ) ) {
			return new \WP_Error( 'cozy_mailchimp_key', __( 'This does not look like a Mailchimp API key. It ends in your data centre, e.g. "-us21".', 'cozy-addons' ) );
		}
		$result = self::request( 'GET', '/?fields=account_name', null, $key );
		// The account endpoint predates Bearer API keys; ask once more with Basic before giving up.
		if ( ! is_wp_error( $result ) && 401 === $result['code'] ) {
			$result = self::request( 'GET', '/?fields=account_name', null, $key, 'Basic' );
		}
		if ( is_wp_error( $result ) ) {
			return new \WP_Error( 'cozy_mailchimp_down', __( 'Could not reach Mailchimp. Please try again.', 'cozy-addons' ) );
		}
		if ( 200 !== $result['code'] ) {
			return new \WP_Error( 'cozy_mailchimp_key', __( 'Mailchimp did not accept this API key.', 'cozy-addons' ) );
		}

		return sanitize_text_field( isset( $result['data']['account_name'] ) ? (string) $result['data']['account_name'] : '' );
	}

	/**
	 * Whether an audience ID is right: it looks like one and the key can read that audience.
	 * Also gives the address of the audience's unsubscribe form, for forms that link to it.
	 *
	 * @param string $audience Audience ID, from Audience → All contacts → ⋯ → Audience settings.
	 * @param string $key      API key; the saved one when empty.
	 * @return array{name:string,unsubscribe:string}|\WP_Error
	 */
	public static function audience( $audience, $key = '' ) {
		if ( ! self::valid_audience( $audience ) ) {
			return new \WP_Error( 'cozy_mailchimp_audience', __( 'This does not look like a Mailchimp Audience ID, e.g. "a1b2c3d4e5".', 'cozy-addons' ) );
		}
		$result = self::request( 'GET', '/lists/' . rawurlencode( $audience ) . '?fields=id,name,subscribe_url_long', null, $key );
		if ( is_wp_error( $result ) ) {
			return new \WP_Error( 'cozy_mailchimp_down', __( 'Could not reach Mailchimp to check the Audience ID. Please try again.', 'cozy-addons' ) );
		}
		if ( 401 === $result['code'] || 403 === $result['code'] ) {
			return new \WP_Error( 'cozy_mailchimp_key', __( 'Mailchimp did not accept the API key for this audience.', 'cozy-addons' ) );
		}
		if ( 404 === $result['code'] ) {
			return new \WP_Error( 'cozy_mailchimp_audience', __( 'Mailchimp could not find this audience. Check the Audience ID.', 'cozy-addons' ) );
		}
		if ( 200 !== $result['code'] ) {
			return new \WP_Error( 'cozy_mailchimp_audience', self::outcome( $result )[1] );
		}

		return array(
			'name'        => sanitize_text_field( (string) ( $result['data']['name'] ?? '' ) ),
			'unsubscribe' => self::unsubscribe_from( (string) ( $result['data']['subscribe_url_long'] ?? '' ) ),
		);
	}

	/**
	 * The audience's unsubscribe form, from its signup form address
	 * ("https://….list-manage.com/subscribe?u=…&id=…" → "…/unsubscribe?u=…&id=…").
	 *
	 * @param string $subscribe Signup form URL.
	 * @return string Empty when it is not a Mailchimp form address.
	 */
	public static function unsubscribe_from( $subscribe ) {
		$host = (string) wp_parse_url( $subscribe, PHP_URL_HOST );
		if ( 'https' !== wp_parse_url( $subscribe, PHP_URL_SCHEME ) || ! preg_match( '/(^|\.)list-manage\.com$/', $host ) || false === strpos( $subscribe, '/subscribe?' ) ) {
			return '';
		}

		return esc_url_raw( str_replace( '/subscribe?', '/unsubscribe?', $subscribe ) );
	}

	/**
	 * Fills in the unsubscribe form address for an audience saved before it was kept. Admin
	 * screens only, at most once an hour, so pages never wait for Mailchimp.
	 *
	 * @return void
	 */
	public static function ensure_unsubscribe_url() {
		$settings = cozy_addons_form_settings();
		if ( '' !== (string) $settings['mailchimp_unsub'] || '' === (string) $settings['mailchimp_audience'] || ! Form_Integrations::connected( 'mailchimp' ) || get_transient( 'ca_form_mc_unsub_checked' ) ) {
			return;
		}
		set_transient( 'ca_form_mc_unsub_checked', 1, HOUR_IN_SECONDS );
		$info = self::audience( (string) $settings['mailchimp_audience'] );
		if ( ! is_wp_error( $info ) && '' !== $info['unsubscribe'] ) {
			$stored                    = get_option( 'ca_form_settings', array() );
			$stored                    = is_array( $stored ) ? $stored : array();
			$stored['mailchimp_unsub'] = $info['unsubscribe'];
			update_option( 'ca_form_settings', $stored );
		}
	}

	/**
	 * Whether a value looks like an audience ID.
	 *
	 * @param string $audience Audience ID.
	 * @return bool
	 */
	public static function valid_audience( $audience ) {
		return (bool) preg_match( '/^[A-Za-z0-9_\-]{1,64}$/', (string) $audience );
	}

	/**
	 * Fields of the saved audience ("audience fields and merge tags" in Mailchimp), for mapping
	 * form fields to them. Cached for an hour; the key never leaves this server.
	 *
	 * @param bool $refresh Skip the cache.
	 * @return array<int,array{tag:string,name:string,type:string,required:bool,choices:string[]}>|\WP_Error
	 */
	public static function merge_fields( $refresh = false ) {
		$settings = cozy_addons_form_settings();
		$audience = (string) $settings['mailchimp_audience'];
		if ( ! self::valid_audience( $audience ) ) {
			return new \WP_Error( 'cozy_mailchimp_audience', __( 'Add the Mailchimp Audience ID under Lead Forms → Settings → Integrations.', 'cozy-addons' ) );
		}
		// The cache key changes with the key and audience, so another account never shows old fields.
		$cache  = 'ca_form_mc_fields_' . substr( md5( (string) $settings['mailchimp_key'] . '|' . $audience ), 0, 12 );
		$fields = $refresh ? false : get_transient( $cache );
		if ( is_array( $fields ) ) {
			return $fields;
		}

		$result = self::request( 'GET', '/lists/' . rawurlencode( $audience ) . '/merge-fields?count=1000&fields=merge_fields.tag,merge_fields.name,merge_fields.type,merge_fields.required,merge_fields.options.choices,merge_fields.options.date_format' );
		if ( is_wp_error( $result ) || 200 !== $result['code'] ) {
			return new \WP_Error( 'cozy_mailchimp_fields', __( 'Could not load the fields of your Mailchimp audience.', 'cozy-addons' ) );
		}
		$fields = array();
		foreach ( isset( $result['data']['merge_fields'] ) && is_array( $result['data']['merge_fields'] ) ? $result['data']['merge_fields'] : array() as $field ) {
			$tag = strtoupper( (string) ( $field['tag'] ?? '' ) );
			if ( ! preg_match( '/^[A-Z0-9_]{1,50}$/', $tag ) ) {
				continue;
			}
			$choices = array();
			foreach ( isset( $field['options']['choices'] ) && is_array( $field['options']['choices'] ) ? $field['options']['choices'] : array() as $choice ) {
				$choices[] = sanitize_text_field( (string) $choice );
			}
			$fields[] = array(
				'tag'      => $tag,
				'name'     => sanitize_text_field( (string) ( $field['name'] ?? $tag ) ),
				'type'     => sanitize_key( (string) ( $field['type'] ?? 'text' ) ),
				'required' => ! empty( $field['required'] ),
				'choices'  => $choices,
			);
		}
		set_transient( $cache, $fields, HOUR_IN_SECONDS );

		return $fields;
	}

	/**
	 * Tags that already exist in the saved audience, for choosing them on a form. Cached for 10
	 * minutes; the key never leaves this server.
	 *
	 * @param bool $refresh Skip the cache.
	 * @return string[]|\WP_Error Tag names, sorted.
	 */
	public static function tags( $refresh = false ) {
		$settings = cozy_addons_form_settings();
		$audience = (string) $settings['mailchimp_audience'];
		if ( ! self::valid_audience( $audience ) ) {
			return new \WP_Error( 'cozy_mailchimp_audience', __( 'Add the Mailchimp Audience ID under Lead Forms → Settings → Integrations.', 'cozy-addons' ) );
		}
		$cache = 'ca_form_mc_tags_' . substr( md5( (string) $settings['mailchimp_key'] . '|' . $audience ), 0, 12 );
		$tags  = $refresh ? false : get_transient( $cache );
		if ( is_array( $tags ) ) {
			return $tags;
		}

		// Without a name, Mailchimp returns every tag of the audience.
		$result = self::request( 'GET', '/lists/' . rawurlencode( $audience ) . '/tag-search' );
		if ( is_wp_error( $result ) || 200 !== $result['code'] ) {
			return new \WP_Error( 'cozy_mailchimp_tags', __( 'Could not load the tags of your Mailchimp audience.', 'cozy-addons' ) );
		}
		$tags = array();
		foreach ( isset( $result['data']['tags'] ) && is_array( $result['data']['tags'] ) ? $result['data']['tags'] : array() as $tag ) {
			$name = mb_substr( trim( sanitize_text_field( (string) ( $tag['name'] ?? '' ) ) ), 0, 100 );
			if ( '' !== $name ) {
				$tags[] = $name;
			}
		}
		$tags = array_values( array_unique( $tags ) );
		natcasesort( $tags );
		$tags = array_values( $tags );
		set_transient( $cache, $tags, 10 * MINUTE_IN_SECONDS );

		return $tags;
	}

	/**
	 * An answer in the format Mailchimp expects for a field type.
	 *
	 * @param string $value Answer as saved on the entry.
	 * @param string $type  Mailchimp field type, '' when unknown.
	 * @return string|float|null Null when it cannot be sent.
	 */
	private static function merge_value( $value, $type ) {
		$value = trim( (string) $value );
		switch ( $type ) {
			case 'address':
				// Needs street, city, state and zip together; one answer cannot fill it.
				return null;
			case 'number':
				return is_numeric( $value ) ? $value + 0 : null;
			case 'date':
				// Date and date-and-time fields are saved as "YYYY-MM-DD" or "YYYY-MM-DD HH:MM".
				return preg_match( '/^(\d{4}-\d{2}-\d{2})/', $value, $m ) ? $m[1] : $value;
			case 'birthday':
				return preg_match( '/^\d{4}-(\d{2})-(\d{2})/', $value, $m ) ? $m[1] . '/' . $m[2] : $value;
			default:
				return mb_strcut( $value, 0, 255 );
		}
	}

	/**
	 * Adds a contact to an audience with the Lists API. The form only gets here once the visitor
	 * signed up (and ticked the consent box, when the form asks for one).
	 *
	 * - Double opt-in: new contacts are "pending" and confirm by email first; otherwise "subscribed".
	 * - Update existing subscribers: an address already in the audience gets the new details
	 *   (PUT, an upsert). Otherwise it is left as it is. Either way an existing contact keeps its
	 *   status, so people who unsubscribed are never subscribed again.
	 *
	 * FNAME, LNAME and PHONE are filled from the form's name and phone fields; answers mapped to
	 * audience fields (Pro) are added on top and win. Fields Mailchimp refuses are left out, and
	 * the contact is still added.
	 *
	 * @param string $audience Audience ID.
	 * @param array  $contact  email, first, last, phone.
	 * @param array  $tags     Tags to add.
	 * @param array  $mapped   Answers mapped to audience fields, keyed by merge tag.
	 * @param array  $options  "double" (double opt-in) and "update" (update existing subscribers).
	 * @return array{0:string,1:string,2?:string} Status ("ok", "retry" or "fail"), a short message and,
	 *                                            when fields were left out, a warning for the error log.
	 */
	public static function subscribe( $audience, array $contact, array $tags, array $mapped = array(), array $options = array() ) {
		if ( ! self::valid_audience( $audience ) ) {
			return array( 'fail', __( 'Add the Mailchimp Audience ID under Lead Forms → Settings → Integrations', 'cozy-addons' ) );
		}
		$status = empty( $options['double'] ) ? 'subscribed' : 'pending';
		$update = ! empty( $options['update'] );
		$method = $update ? 'PUT' : 'POST';
		$path   = '/lists/' . rawurlencode( $audience ) . '/members' . ( $update ? '/' . md5( strtolower( $contact['email'] ) ) : '' ) . '?skip_merge_validation=true';
		// PUT keeps the status of an existing contact and only uses this one for new addresses.
		$payload = array( 'email_address' => $contact['email'] );
		$payload[ $update ? 'status_if_new' : 'status' ] = $status;
		$merge   = array_filter(
			array(
				'FNAME' => $contact['first'],
				'LNAME' => $contact['last'],
				'PHONE' => $contact['phone'],
			),
			'strlen'
		);
		if ( $mapped ) {
			$types = array();
			$known = self::merge_fields();
			foreach ( is_wp_error( $known ) ? array() : $known as $field ) {
				$types[ $field['tag'] ] = $field['type'];
			}
			foreach ( $mapped as $tag => $value ) {
				$value = self::merge_value( $value, $types[ $tag ] ?? '' );
				if ( null !== $value && '' !== $value ) {
					$merge[ $tag ] = $value;
				}
			}
		}
		$full = $payload;
		if ( $merge ) {
			$full['merge_fields'] = $merge;
		}
		if ( $tags ) {
			$full['tags'] = array_values( $tags );
		}

		$result  = self::request( $method, $path, $full );
		$dropped = array();
		// Without "update existing subscribers", an address already in the audience is left as it is.
		if ( ! $update && ! is_wp_error( $result ) && 400 === $result['code'] && 'Member Exists' === ( $result['data']['title'] ?? '' ) ) {
			return array( 'ok', __( 'Already in the audience, not updated', 'cozy-addons' ) );
		}
		if ( ! is_wp_error( $result ) && 400 === $result['code'] && $merge ) {
			// Leave out only the fields Mailchimp named, e.g. "merge_fields.BIRTHDAY".
			foreach ( isset( $result['data']['errors'] ) && is_array( $result['data']['errors'] ) ? $result['data']['errors'] : array() as $error ) {
				$field = strtoupper( preg_replace( '/^merge_fields\./i', '', (string) ( $error['field'] ?? '' ) ) );
				if ( isset( $merge[ $field ] ) ) {
					$dropped[ $field ] = mb_substr( sanitize_text_field( (string) ( $error['message'] ?? '' ) ), 0, 80 );
				}
			}
			if ( $dropped ) {
				$retry                 = $full;
				$retry['merge_fields'] = array_diff_key( $merge, $dropped );
				if ( ! $retry['merge_fields'] ) {
					unset( $retry['merge_fields'] );
				}
				$result = self::request( $method, $path, $retry );
			}
			// Still refused, or no field named: just the address and status.
			if ( ! is_wp_error( $result ) && 400 === $result['code'] ) {
				$result  = self::request( $method, $path, $payload );
				$dropped = $dropped + array_fill_keys( array_keys( $merge ), '' );
			}
		} elseif ( ! is_wp_error( $result ) && 400 === $result['code'] && $full !== $payload ) {
			// Tags it refuses: send just the address and status.
			$result = self::request( $method, $path, $payload );
		}
		$outcome = self::outcome( $result );
		if ( 'ok' !== $outcome[0] ) {
			return $outcome;
		}
		$state = isset( $result['data']['status'] ) ? (string) $result['data']['status'] : '';
		if ( in_array( $state, array( 'unsubscribed', 'cleaned' ), true ) ) {
			// Their choice stands: an existing contact who left is not subscribed again.
			$message = __( 'Not added: this address unsubscribed earlier', 'cozy-addons' );
		} else {
			$message = 'pending' === $state ? __( 'Added, waiting for confirmation', 'cozy-addons' ) : __( 'Added', 'cozy-addons' );
		}
		if ( ! $dropped ) {
			return array( 'ok', $message );
		}

		$reasons = array();
		foreach ( $dropped as $tag => $reason ) {
			$reasons[] = '' !== $reason ? $tag . ' (' . $reason . ')' : $tag;
		}

		return array(
			'ok',
			/* translators: 1: "Added", 2: merge tags, e.g. "BIRTHDAY, SIZE" */
			sprintf( __( '%1$s (not sent: %2$s)', 'cozy-addons' ), $message, implode( ', ', array_keys( $dropped ) ) ),
			/* translators: %s: merge tags with Mailchimp's reasons */
			sprintf( __( 'Added, but Mailchimp refused these fields: %s', 'cozy-addons' ), implode( '; ', $reasons ) ),
		);
	}

	/**
	 * Turns a response into a job status, for the entry screen only. Keeps Mailchimp's short
	 * reason, never anything from the request.
	 *
	 * @param array|\WP_Error $result Response.
	 * @return array{0:string,1:string}
	 */
	private static function outcome( $result ) {
		if ( is_wp_error( $result ) ) {
			return array( 'retry', __( 'Could not reach Mailchimp', 'cozy-addons' ) );
		}
		if ( $result['code'] >= 200 && $result['code'] < 300 ) {
			return array( 'ok', '' );
		}
		if ( 429 === $result['code'] || $result['code'] >= 500 ) {
			/* translators: %d: HTTP status code */
			return array( 'retry', sprintf( __( 'Mailchimp is unavailable (HTTP %d)', 'cozy-addons' ), $result['code'] ) );
		}
		$data   = is_array( $result['data'] ) ? $result['data'] : array();
		$reason = isset( $data['title'] ) ? (string) $data['title'] : '';
		if ( ! empty( $data['errors'][0]['message'] ) ) {
			$reason .= ': ' . $data['errors'][0]['message'];
		} elseif ( ! empty( $data['detail'] ) ) {
			$reason .= ( '' !== $reason ? ': ' : '' ) . $data['detail'];
		}
		$reason = mb_substr( trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $reason ) ) ), 0, 160 );

		/* translators: 1: HTTP status code, 2: Mailchimp's reason, e.g. "Invalid Resource: …" */
		return array( 'fail', trim( sprintf( __( 'Mailchimp refused the contact (HTTP %1$d) %2$s', 'cozy-addons' ), $result['code'], $reason ) ) );
	}
}
