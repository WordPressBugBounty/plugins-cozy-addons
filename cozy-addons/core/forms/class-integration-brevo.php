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
 * Talks to the Brevo API v3. The API key only ever travels from this server to Brevo, in the
 * "api-key" header; never in a URL, a body, or anything a visitor or the page can see.
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
	 * @param string $key API key; the saved one when empty.
	 * @return array<int,array{id:string,name:string}>|\WP_Error
	 */
	public static function lists( $key = '' ) {
		$lists = array();
		for ( $offset = 0; $offset < 500; $offset += 50 ) {
			$result = self::request( 'GET', '/contacts/lists?limit=50&offset=' . $offset, null, $key );
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
	 * Lists of the saved account, cached for 10 minutes so screens do not wait for Brevo.
	 *
	 * @param bool $refresh Skip the cache.
	 * @return array<int,array{id:string,name:string}>|\WP_Error
	 */
	public static function cached_lists( $refresh = false ) {
		// The cache key changes with the API key, so a new account never shows old lists.
		$cache = 'ca_form_lists_brevo_' . substr( md5( (string) cozy_addons_form_settings()['brevo_key'] ), 0, 12 );
		$lists = $refresh ? false : get_transient( $cache );
		if ( is_array( $lists ) ) {
			return $lists;
		}
		$lists = self::lists();
		if ( ! is_wp_error( $lists ) ) {
			set_transient( $cache, $lists, 10 * MINUTE_IN_SECONDS );
		}

		return $lists;
	}

	/**
	 * Whether a list exists in the account the key belongs to.
	 *
	 * @param int    $id  List ID, from Contacts → Lists in Brevo.
	 * @param string $key API key; the saved one when empty.
	 * @return string|\WP_Error The list's name.
	 */
	public static function list_name( $id, $key = '' ) {
		$id = absint( $id );
		if ( ! $id ) {
			return new \WP_Error( 'cozy_brevo_list', __( 'Choose a Brevo list.', 'cozy-addons' ) );
		}
		$result = self::request( 'GET', '/contacts/lists/' . $id, null, $key );
		if ( is_wp_error( $result ) ) {
			return new \WP_Error( 'cozy_brevo_down', __( 'Could not reach Brevo to check the list. Please try again.', 'cozy-addons' ) );
		}
		if ( 401 === $result['code'] || 403 === $result['code'] ) {
			return new \WP_Error( 'cozy_brevo_key', __( 'Brevo did not accept the API key for this list.', 'cozy-addons' ) );
		}
		if ( 404 === $result['code'] ) {
			return new \WP_Error( 'cozy_brevo_list', __( 'Brevo could not find this list. Check the list ID.', 'cozy-addons' ) );
		}
		if ( 200 !== $result['code'] ) {
			return new \WP_Error( 'cozy_brevo_list', self::outcome( $result )[1] );
		}

		return sanitize_text_field( (string) ( $result['data']['name'] ?? '' ) );
	}

	/**
	 * Contact attributes of the account that a form can fill, for mapping form fields to them.
	 * Calculated, global and transactional attributes are left out. Cached for an hour; the key
	 * never leaves this server.
	 *
	 * @param bool $refresh Skip the cache.
	 * @return array<int,array{name:string,type:string,choices:array<int,array{label:string,value:int}>}>|\WP_Error
	 */
	public static function attributes( $refresh = false ) {
		$key   = (string) cozy_addons_form_settings()['brevo_key'];
		$cache = 'ca_form_br_attrs_' . substr( md5( $key ), 0, 12 );
		$attrs = $refresh ? false : get_transient( $cache );
		if ( is_array( $attrs ) ) {
			return $attrs;
		}

		$result = self::request( 'GET', '/contacts/attributes' );
		if ( is_wp_error( $result ) || 200 !== $result['code'] ) {
			return new \WP_Error( 'cozy_brevo_attributes', __( 'Could not load the contact attributes of your Brevo account.', 'cozy-addons' ) );
		}
		$attrs = array();
		foreach ( isset( $result['data']['attributes'] ) && is_array( $result['data']['attributes'] ) ? $result['data']['attributes'] : array() as $attr ) {
			$name = strtoupper( (string) ( $attr['name'] ?? '' ) );
			if ( ! in_array( $attr['category'] ?? '', array( 'normal', 'category' ), true ) || ! preg_match( '/^[A-Z0-9_]{1,50}$/', $name ) ) {
				continue;
			}
			$choices = array();
			foreach ( isset( $attr['enumeration'] ) && is_array( $attr['enumeration'] ) ? $attr['enumeration'] : array() as $item ) {
				$choices[] = array(
					'label' => sanitize_text_field( (string) ( $item['label'] ?? '' ) ),
					'value' => (int) ( $item['value'] ?? 0 ),
				);
			}
			$attrs[] = array(
				'name'    => $name,
				'type'    => 'category' === $attr['category'] ? 'category' : sanitize_key( (string) ( $attr['type'] ?? 'text' ) ),
				'choices' => $choices,
			);
		}
		set_transient( $cache, $attrs, HOUR_IN_SECONDS );

		return $attrs;
	}

	/**
	 * An answer in the format Brevo expects for an attribute.
	 *
	 * @param string $value Answer as saved on the entry.
	 * @param array  $attr  Attribute from attributes(), or empty when unknown.
	 * @return mixed Null when it cannot be sent.
	 */
	private static function attribute_value( $value, array $attr ) {
		$value = trim( (string) $value );
		switch ( $attr['type'] ?? '' ) {
			case 'float':
				return is_numeric( $value ) ? $value + 0 : null;
			case 'date':
				// Date and date-and-time fields are saved as "YYYY-MM-DD" or "YYYY-MM-DD HH:MM".
				return preg_match( '/^(\d{4}-\d{2}-\d{2})/', $value, $m ) ? $m[1] : null;
			case 'boolean':
				return in_array( strtolower( $value ), array( '1', 'yes', 'true', strtolower( __( 'Yes', 'cozy-addons' ) ) ), true );
			case 'category':
				// Brevo stores the number of the option whose label matches the answer.
				foreach ( $attr['choices'] as $choice ) {
					if ( 0 === strcasecmp( $choice['label'], $value ) ) {
						return $choice['value'];
					}
				}
				return null;
			default:
				return mb_substr( $value, 0, 255 );
		}
	}

	/**
	 * Adds a contact to a list. The form only gets here once the visitor signed up (and ticked
	 * the consent box, when the form has one).
	 *
	 * The form chooses, on its Form block:
	 * - Double opt-in: Brevo emails the confirmation link first and adds the contact once they
	 *   confirm. Needs a Brevo template with the {{ doubleoptin }} link.
	 * - Confirmation email (never with double opt-in): once the contact is added, Brevo sends the
	 *   chosen template to them.
	 * A contact already in Brevo gets the new details and lists, as with Brevo's own forms.
	 * Blocklisted contacts are never unblocked.
	 *
	 * FIRSTNAME, LASTNAME and SMS are filled from the form's name and phone fields; answers mapped
	 * to attributes (Pro) are added on top and win. Attributes Brevo refuses are left out, and the
	 * contact is still added.
	 *
	 * @param string $list_id List ID, the first of the form's lists.
	 * @param array  $contact email, first, last, phone.
	 * @param array  $mapped  Answers mapped to attributes, keyed by attribute name.
	 * @param array  $options "double", "double_template", "double_redirect", "confirm_template",
	 *                        and "lists" (the form's other list IDs).
	 * @return array{0:string,1:string,2?:string} Status ("ok", "retry" or "fail"), a short message and,
	 *                                            when attributes were left out, a warning for the error log.
	 */
	public static function subscribe( $list_id, array $contact, array $mapped = array(), array $options = array() ) {
		$lists = array_values( array_unique( array_filter( array_map( 'absint', array_merge( array( $list_id ), (array) ( $options['lists'] ?? array() ) ) ) ) ) );
		if ( ! $lists || ! absint( $list_id ) ) {
			return array( 'fail', __( 'Choose a Brevo list in the Form block\'s Integrations panel', 'cozy-addons' ) );
		}
		$double = ! empty( $options['double'] );
		if ( $double && empty( $options['double_template'] ) ) {
			return array( 'fail', __( 'Choose a double opt-in template in the Form block\'s Integrations panel', 'cozy-addons' ) );
		}
		// The two are never combined; double opt-in already sends its own email.
		$confirm = $double ? 0 : absint( $options['confirm_template'] ?? 0 );

		$attributes = array_filter(
			array(
				'FIRSTNAME' => $contact['first'],
				'LASTNAME'  => $contact['last'],
			),
			'strlen'
		);
		$auto       = array_keys( $attributes );
		if ( $mapped ) {
			$known = array();
			$attrs = self::attributes();
			foreach ( is_wp_error( $attrs ) ? array() : $attrs as $attr ) {
				$known[ $attr['name'] ] = $attr;
			}
			foreach ( $mapped as $name => $value ) {
				$value = self::attribute_value( $value, $known[ $name ] ?? array() );
				if ( null !== $value && '' !== $value ) {
					$attributes[ $name ] = $value;
				}
			}
		}

		if ( $double ) {
			$path = '/contacts/doubleOptinConfirmation';
			$base = array(
				'email'          => $contact['email'],
				'includeListIds' => $lists,
				'templateId'     => absint( $options['double_template'] ),
				'redirectionUrl' => ! empty( $options['double_redirect'] ) ? (string) $options['double_redirect'] : home_url( '/' ),
			);
		} else {
			$path = '/contacts';
			$base = array(
				'email'         => $contact['email'],
				'listIds'       => $lists,
				'updateEnabled' => true,
			);
		}
		$full = $base;
		if ( $attributes ) {
			$full['attributes'] = $attributes;
		}

		$result  = self::request( 'POST', $path, $full );
		$dropped = array();
		// An attribute Brevo refuses (not in the account, or a wrong value): send the contact
		// with just the names, or without attributes if those are refused too.
		if ( ! is_wp_error( $result ) && 400 === $result['code'] && $attributes ) {
			$reason = mb_substr( sanitize_text_field( (string) ( $result['data']['message'] ?? '' ) ), 0, 120 );
			$keep   = array_intersect_key( $attributes, array_flip( $auto ) );
			$retry  = $base;
			if ( $keep && $keep !== $attributes ) {
				$retry['attributes'] = $keep;
				$result              = self::request( 'POST', $path, $retry );
				$dropped             = array_diff_key( $attributes, $keep );
				unset( $retry['attributes'] );
			}
			if ( ! is_wp_error( $result ) && 400 === $result['code'] ) {
				$result  = self::request( 'POST', $path, $retry );
				$dropped = $attributes;
			}
			$dropped = array_fill_keys( array_keys( $dropped ), $reason );
		}
		$outcome = self::outcome( $result );
		if ( 'ok' !== $outcome[0] ) {
			return $outcome;
		}
		$message  = $double ? __( 'Double opt-in email sent', 'cozy-addons' ) : __( 'Added', 'cozy-addons' );
		$warnings = array();
		if ( $dropped ) {
			/* translators: 1: "Added", 2: attribute names, e.g. "COMPANY, SIZE" */
			$message    = sprintf( __( '%1$s (not sent: %2$s)', 'cozy-addons' ), $message, implode( ', ', array_keys( $dropped ) ) );
			/* translators: 1: attribute names, 2: Brevo's reason */
			$warnings[] = trim( sprintf( __( 'Added, but Brevo refused these attributes: %1$s. %2$s', 'cozy-addons' ), implode( ', ', array_keys( $dropped ) ), (string) reset( $dropped ) ) );
		}

		// The form's confirmation email. A contact that was added stays added if it fails.
		if ( $confirm ) {
			$sent = self::send_template( $confirm, $contact );
			if ( true === $sent ) {
				/* translators: %s: "Added" */
				$message = sprintf( __( '%s, confirmation email sent', 'cozy-addons' ), $message );
			} else {
				/* translators: %s: "Added" */
				$message = sprintf( __( '%s (confirmation email not sent)', 'cozy-addons' ), $message );
				/* translators: %s: Brevo's reason */
				$warnings[] = sprintf( __( 'Added, but the confirmation email was not sent: %s', 'cozy-addons' ), $sent );
			}
		}

		return $warnings ? array( 'ok', $message, implode( ' ', $warnings ) ) : array( 'ok', $message );
	}

	/**
	 * Sends a Brevo email template to a new contact, e.g. the form's confirmation email.
	 *
	 * @param int   $template Template ID.
	 * @param array $contact  email, first, last.
	 * @return true|string True when Brevo accepted it, otherwise its short reason.
	 */
	private static function send_template( $template, array $contact ) {
		$name = trim( $contact['first'] . ' ' . $contact['last'] );
		$to   = array( 'email' => $contact['email'] );
		if ( '' !== $name ) {
			$to['name'] = mb_substr( $name, 0, 100 );
		}
		$result = self::request(
			'POST',
			'/smtp/email',
			array(
				'templateId' => (int) $template,
				'to'         => array( $to ),
			)
		);
		$outcome = self::outcome( $result );

		return 'ok' === $outcome[0] ? true : preg_replace( '/^Brevo refused the contact/', 'Brevo refused the email', $outcome[1] );
	}

	/**
	 * Active email templates of the account, for the confirmation and double opt-in emails.
	 * Cached for 10 minutes; the key never leaves this server.
	 *
	 * @param bool $refresh Skip the cache.
	 * @return array<int,array{id:int,name:string,tag:string}>|\WP_Error
	 */
	public static function templates( $refresh = false ) {
		$cache     = 'ca_form_br_tpls_' . substr( md5( (string) cozy_addons_form_settings()['brevo_key'] ), 0, 12 );
		$templates = $refresh ? false : get_transient( $cache );
		if ( is_array( $templates ) ) {
			return $templates;
		}
		$templates = array();
		for ( $offset = 0; $offset < 1000; $offset += 100 ) {
			$result = self::request( 'GET', '/smtp/templates?templateStatus=true&limit=100&offset=' . $offset );
			if ( is_wp_error( $result ) || 200 !== $result['code'] ) {
				return new \WP_Error( 'cozy_brevo_templates', __( 'Could not load your Brevo email templates.', 'cozy-addons' ) );
			}
			$page = isset( $result['data']['templates'] ) && is_array( $result['data']['templates'] ) ? $result['data']['templates'] : array();
			foreach ( $page as $template ) {
				$templates[] = array(
					'id'   => absint( $template['id'] ?? 0 ),
					'name' => sanitize_text_field( (string) ( $template['name'] ?? '' ) ),
					'tag'  => sanitize_text_field( (string) ( $template['tag'] ?? '' ) ),
				);
			}
			if ( count( $page ) < 100 ) {
				break;
			}
		}
		set_transient( $cache, $templates, 10 * MINUTE_IN_SECONDS );

		return $templates;
	}

	/**
	 * Turns a response into a job status, for the entry screen only. Keeps Brevo's short reason,
	 * never anything from the request.
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
		$data   = is_array( $result['data'] ) ? $result['data'] : array();
		$reason = trim( sanitize_key( (string) ( $data['code'] ?? '' ) ) . ': ' . sanitize_text_field( (string) ( $data['message'] ?? '' ) ), ': ' );
		$reason = mb_substr( trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $reason ) ) ), 0, 160 );

		/* translators: 1: HTTP status code, 2: Brevo's reason, e.g. "invalid_parameter: …" */
		return array( 'fail', trim( sprintf( __( 'Brevo refused the contact (HTTP %1$d) %2$s', 'cozy-addons' ), $result['code'], $reason ) ) );
	}
}
