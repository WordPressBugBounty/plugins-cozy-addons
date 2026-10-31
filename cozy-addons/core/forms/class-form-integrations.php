<?php
/**
 * Integrations (Pro): mailing lists and webhooks for new entries.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

use WP_REST_Request;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Queues and delivers entries to Mailchimp, Brevo and webhooks.
 *
 * Jobs run in the same request right after the visitor has their answer: the response is sent
 * first where the server allows it (PHP-FPM, LiteSpeed), so a slow or failing service never holds
 * up the visitor. No cron is involved. Each entry keeps its jobs in "_ca_form_sync", with the outcome shown
 * on the entry. Only short, safe messages are stored: never API keys, secrets or raw responses.
 */
final class Form_Integrations {

	const HOOK = 'cozy_addons_form_sync';
	const META = '_ca_form_sync';

	/**
	 * Entries whose jobs are delivered at the end of this request.
	 *
	 * @var int[]
	 */
	private static $pending = array();

	/**
	 * Registers hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'routes' ) );
		add_action( 'admin_init', array( __CLASS__, 'clear_old_cron' ) );
		add_action( 'admin_post_ca_form_sync_retry', array( __CLASS__, 'retry' ) );
		add_action( 'admin_post_ca_form_webhook_test', array( __CLASS__, 'test_webhook' ) );
	}

	/**
	 * Whether a mailing-list service is the one chosen in Settings and has its key. Pro only.
	 *
	 * @param string $provider "mailchimp" or "brevo".
	 * @return bool
	 */
	public static function connected( $provider ) {
		$settings = cozy_addons_form_settings();

		return cozy_addons_premium_access()
			&& in_array( $provider, array( 'mailchimp', 'brevo' ), true )
			&& cozy_addons_form_mailing_service() === $provider
			&& '' !== (string) $settings[ $provider . '_key' ];
	}

	/**
	 * Builds the jobs for a new entry and starts delivering them.
	 *
	 * @param int   $entry_id Entry ID.
	 * @param array $config   Verified form config.
	 * @param array $values   Saved rows (visible fields only).
	 * @return void
	 */
	public static function queue( $entry_id, array $config, array $values ) {
		if ( ! cozy_addons_premium_access() ) {
			return;
		}
		$answers = array();
		foreach ( $values as $row ) {
			$answers[ $row['n'] ] = (string) $row['v'];
		}

		// Pro: answers that go to fields of the Mailchimp audience, as merge tag => form field.
		$merge = array();
		foreach ( $config['fields'] as $field ) {
			if ( is_array( $field ) && ! empty( $field['mt'] ) && isset( $field['n'] ) ) {
				$merge[ (string) $field['mt'] ] = (string) $field['n'];
			}
		}

		$jobs = array();
		foreach ( $config['fields'] as $field ) {
			if ( ! is_array( $field ) || empty( $field['ml'] ) || 'email' !== ( $field['t'] ?? '' ) || ! is_array( $field['ml'] ) ) {
				continue;
			}
			$list  = $field['ml'];
			$email = isset( $answers[ $field['n'] ] ) ? $answers[ $field['n'] ] : '';
			if ( ! is_email( $email ) || ! self::connected( $list['p'] ?? '' ) ) {
				continue;
			}
			// Only with the visitor's consent, when the form asks for it. A box hidden by conditional
			// logic is not in the entry, so it does not count as ticked. Mailchimp finds the form's
			// consent checkbox by itself (e.g. "Marketing Consent"); a box chosen on fields saved
			// before that still counts.
			$consent = (string) ( $list['c'] ?? '' );
			if ( '' === $consent && 'mailchimp' === $list['p'] ) {
				foreach ( $config['fields'] as $box ) {
					if ( is_array( $box ) && cozy_addons_form_is_consent_box( $box ) ) {
						$consent = (string) $box['n'];
						break;
					}
				}
			}
			if ( '' !== $consent && ( ! isset( $answers[ $consent ] ) || __( 'Yes', 'cozy-addons' ) !== $answers[ $consent ] ) ) {
				continue;
			}
			// Mailchimp adds everyone to the audience set in Settings. Fields saved before that
			// setting existed carry their own audience ID, used while none is set.
			$target = (string) ( $list['l'] ?? '' );
			if ( 'mailchimp' === $list['p'] && '' !== (string) cozy_addons_form_settings()['mailchimp_audience'] ) {
				$target = (string) cozy_addons_form_settings()['mailchimp_audience'];
			}
			$jobs[] = array(
				'type'   => $list['p'],
				'target' => $target,
				'field'  => $field['n'],
				'tags'   => isset( $list['t'] ) && is_array( $list['t'] ) ? array_values( $list['t'] ) : array(),
				'double' => ! empty( $list['d'] ),
			);
			if ( 'mailchimp' === $list['p'] ) {
				// The form's tags, plus any saved on the Email field before tags moved to the form.
				$form_tags                          = isset( $config['tg'] ) && is_array( $config['tg'] ) ? $config['tg'] : array();
				$jobs[ count( $jobs ) - 1 ]['tags'] = array_values( array_unique( array_merge( $form_tags, $jobs[ count( $jobs ) - 1 ]['tags'] ) ) );
				if ( $merge ) {
					$jobs[ count( $jobs ) - 1 ]['merge'] = $merge;
				}
			}
		}

		// Webhooks, unless this form turned them off.
		if ( ! isset( $config['wh'] ) || ! empty( $config['wh'] ) ) {
			foreach ( Integration_Webhooks::active() as $id => $webhook ) {
				$jobs[] = array(
					'type'   => 'webhook',
					'target' => $id,
					'host'   => Integration_Webhooks::host( $webhook['url'] ),
				);
			}
		}

		if ( ! $jobs ) {
			return;
		}
		foreach ( $jobs as $i => $job ) {
			$jobs[ $i ] += array(
				'status'  => 'pending',
				'message' => '',
			);
		}
		// Saved first, so the entry shows "waiting" if delivery never gets to run.
		update_post_meta( $entry_id, self::META, $jobs );

		self::$pending[] = (int) $entry_id;
		if ( ! has_action( 'shutdown', array( __CLASS__, 'deliver_pending' ) ) ) {
			add_action( 'shutdown', array( __CLASS__, 'deliver_pending' ) );
		}
	}

	/**
	 * Delivers this request's entries once WordPress has printed the visitor's answer. Where the
	 * server allows it the connection is closed first, so the visitor does not wait for the services.
	 *
	 * @return void
	 */
	public static function deliver_pending() {
		$entries       = array_unique( self::$pending );
		self::$pending   = array();
		if ( ! $entries ) {
			return;
		}

		if ( function_exists( 'fastcgi_finish_request' ) ) {
			fastcgi_finish_request();
		} elseif ( function_exists( 'litespeed_finish_request' ) ) {
			litespeed_finish_request();
		}
		// Keep going when the visitor closes the page, and give the services time to answer.
		ignore_user_abort( true );
		if ( function_exists( 'set_time_limit' ) && false === strpos( (string) ini_get( 'disable_functions' ), 'set_time_limit' ) ) {
			@set_time_limit( 60 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- Not allowed on every host.
		}

		foreach ( $entries as $entry_id ) {
			self::run( $entry_id );
		}
	}

	/**
	 * Delivers an entry's pending jobs. A temporary failure (network, 429, 5xx) is tried once more
	 * straight away; after that the job is marked failed and can be retried from the entry.
	 *
	 * @param int $entry_id Entry ID.
	 * @return void
	 */
	public static function run( $entry_id ) {
		$entry_id = (int) $entry_id;
		$jobs     = get_post_meta( $entry_id, self::META, true );
		if ( ! is_array( $jobs ) || Entry_Post_Type::TYPE !== get_post_type( $entry_id ) ) {
			return;
		}
		$lock = 'ca_form_sync_lock_' . $entry_id;
		if ( get_transient( $lock ) ) {
			return;
		}
		set_transient( $lock, 1, 2 * MINUTE_IN_SECONDS );

		foreach ( $jobs as $i => $job ) {
			if ( 'pending' !== $job['status'] ) {
				continue;
			}
			$result = self::deliver( $entry_id, $job );
			if ( 'retry' === $result[0] ) {
				sleep( 1 );
				$result = self::deliver( $entry_id, $job );
			}
			list( $status, $message ) = $result;
			// Fields from jobs saved before delivery stopped using cron.
			unset( $jobs[ $i ]['tries'], $jobs[ $i ]['next'] );
			$jobs[ $i ]['status']  = 'ok' === $status ? 'ok' : 'failed';
			$jobs[ $i ]['message'] = $message;
			if ( 'ok' !== $status ) {
				Form_Log::add( $job['type'], $message, $entry_id );
			} elseif ( ! empty( $result[2] ) ) {
				// Added, but some audience fields were refused: the admin should know which.
				Form_Log::add( $job['type'], $result[2], $entry_id );
			}
		}

		update_post_meta( $entry_id, self::META, $jobs );
		delete_transient( $lock );
	}

	/**
	 * Once, after updating from a version that delivered through WP-Cron: removes those scheduled
	 * events and delivers what they were waiting for.
	 *
	 * @return void
	 */
	public static function clear_old_cron() {
		if ( get_option( 'ca_form_sync_cron_cleared' ) ) {
			return;
		}
		update_option( 'ca_form_sync_cron_cleared', 1, false );

		$entries = array();
		foreach ( (array) _get_cron_array() as $events ) {
			if ( isset( $events[ self::HOOK ] ) ) {
				foreach ( $events[ self::HOOK ] as $event ) {
					$entries[] = isset( $event['args'][0] ) ? (int) $event['args'][0] : 0;
				}
			}
		}
		wp_unschedule_hook( self::HOOK );
		foreach ( array_filter( array_unique( $entries ) ) as $entry_id ) {
			self::$pending[] = $entry_id;
		}
		if ( self::$pending && ! has_action( 'shutdown', array( __CLASS__, 'deliver_pending' ) ) ) {
			add_action( 'shutdown', array( __CLASS__, 'deliver_pending' ) );
		}
	}

	/**
	 * Runs one job.
	 *
	 * @param int   $entry_id Entry ID.
	 * @param array $job      Job.
	 * @return array{0:string,1:string,2?:string} Status, message and an optional warning for the error log.
	 */
	private static function deliver( $entry_id, array $job ) {
		if ( ! cozy_addons_premium_access() ) {
			return array( 'fail', __( 'Needs Cozy Blocks Pro', 'cozy-addons' ) );
		}
		if ( 'webhook' === $job['type'] ) {
			$webhook = Integration_Webhooks::get( $job['target'] );
			if ( ! $webhook || empty( $webhook['active'] ) ) {
				return array( 'fail', __( 'This webhook was removed or turned off', 'cozy-addons' ) );
			}

			return Integration_Webhooks::deliver( $webhook, self::payload( $entry_id ) );
		}

		if ( ! self::connected( $job['type'] ) ) {
			return array( 'fail', __( 'The service is no longer connected', 'cozy-addons' ) );
		}
		$contact = self::contact( $entry_id, $job['field'] );
		if ( ! is_email( $contact['email'] ) ) {
			return array( 'fail', __( 'No email address in this entry', 'cozy-addons' ) );
		}

		return 'mailchimp' === $job['type']
			? Integration_Mailchimp::subscribe(
				$job['target'],
				$contact,
				(array) $job['tags'],
				self::mapped( $entry_id, isset( $job['merge'] ) ? (array) $job['merge'] : array() ),
				// Set for all forms in Lead Forms → Settings → Integrations.
				array(
					'double' => ! empty( cozy_addons_form_settings()['mailchimp_double'] ),
					'update' => ! empty( cozy_addons_form_settings()['mailchimp_update'] ),
				)
			)
			: Integration_Brevo::subscribe( $job['target'], $contact, $job['double'] );
	}

	/**
	 * Answers of an entry for the Mailchimp audience fields they are mapped to. Empty answers, and
	 * fields hidden by conditional logic (not in the entry), are left out.
	 *
	 * @param int                  $entry_id Entry ID.
	 * @param array<string,string> $merge    Merge tag => form field name.
	 * @return array<string,string> Merge tag => answer.
	 */
	public static function mapped( $entry_id, array $merge ) {
		$answers = array();
		foreach ( (array) get_post_meta( $entry_id, '_ca_form_fields', true ) as $row ) {
			if ( is_array( $row ) && isset( $row['n'], $row['v'] ) && '' !== (string) $row['v'] ) {
				$answers[ $row['n'] ] = (string) $row['v'];
			}
		}
		$out = array();
		foreach ( $merge as $tag => $name ) {
			if ( isset( $answers[ $name ] ) && preg_match( '/^[A-Z0-9_]{1,50}$/', (string) $tag ) ) {
				$out[ $tag ] = $answers[ $name ];
			}
		}

		return $out;
	}

	/**
	 * The contact for a mailing list: the email of the chosen field, and the name and phone
	 * fields of the form when it has them.
	 *
	 * @param int    $entry_id    Entry ID.
	 * @param string $email_field Field name.
	 * @return array{email:string,first:string,last:string,phone:string}
	 */
	public static function contact( $entry_id, $email_field ) {
		$contact = array(
			'email' => '',
			'first' => '',
			'last'  => '',
			'phone' => '',
		);
		$full    = '';
		foreach ( (array) get_post_meta( $entry_id, '_ca_form_fields', true ) as $row ) {
			if ( ! is_array( $row ) || ! isset( $row['n'], $row['v'] ) || '' === (string) $row['v'] ) {
				continue;
			}
			$value = mb_substr( sanitize_text_field( (string) $row['v'] ), 0, 100 );
			$label = strtolower( $row['n'] . ' ' . ( $row['l'] ?? '' ) );
			$type  = $row['t'] ?? 'text';
			if ( $row['n'] === $email_field ) {
				$contact['email'] = sanitize_email( $value );
			} elseif ( 'tel' === $type && '' === $contact['phone'] ) {
				$contact['phone'] = $value;
			} elseif ( 'text' === $type ) {
				if ( '' === $contact['first'] && preg_match( '/first|given|fore/', $label ) ) {
					$contact['first'] = $value;
				} elseif ( '' === $contact['last'] && preg_match( '/last|surname|family/', $label ) ) {
					$contact['last'] = $value;
				} elseif ( '' === $full && preg_match( '/name/', $label ) && ! preg_match( '/company|business|organi/', $label ) ) {
					$full = $value;
				}
			}
		}
		// A single name field: first word as the first name, the rest as the last name.
		if ( '' === $contact['first'] && '' !== $full ) {
			$parts            = preg_split( '/\s+/', trim( $full ), 2 );
			$contact['first'] = $parts[0];
			if ( '' === $contact['last'] && isset( $parts[1] ) ) {
				$contact['last'] = $parts[1];
			}
		}

		return $contact;
	}

	/**
	 * What webhooks receive for an entry. Files are listed by name only: they stay private.
	 *
	 * @param int $entry_id Entry ID.
	 * @return array
	 */
	public static function payload( $entry_id ) {
		$fields = array();
		foreach ( (array) get_post_meta( $entry_id, '_ca_form_fields', true ) as $row ) {
			if ( is_array( $row ) && isset( $row['n'] ) ) {
				$fields[] = array(
					'name'  => (string) $row['n'],
					'label' => (string) ( $row['l'] ?? '' ),
					'type'  => (string) ( $row['t'] ?? 'text' ),
					'value' => (string) ( $row['v'] ?? '' ),
				);
			}
		}

		return array(
			'event'        => 'entry.created',
			'entry_id'     => (int) $entry_id,
			'form'         => array(
				'id'       => (string) get_post_meta( $entry_id, '_ca_form_id', true ),
				'name'     => (string) get_post_meta( $entry_id, '_ca_form_name', true ),
				'type'     => cozy_addons_form_entry_type( $entry_id ),
				'category' => (string) get_post_meta( $entry_id, '_ca_form_category', true ),
			),
			'submitted_at' => get_post_time( 'c', true, $entry_id ),
			'page_url'     => (string) get_post_meta( $entry_id, '_ca_form_page_url', true ),
			'urgent'       => '1' === get_post_meta( $entry_id, '_ca_form_urgent', true ),
			'fields'       => $fields,
			'site'         => home_url( '/' ),
		);
	}

	/**
	 * Brevo lists for the editor: GET cozy-block/v1/form-lists?provider=brevo. Mailchimp uses the
	 * audience set in Settings.
	 *
	 * @return void
	 */
	public static function routes() {
		register_rest_route(
			'cozy-block/v1',
			'/form-lists',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'lists' ),
				'permission_callback' => static function () {
					return current_user_can( 'edit_posts' );
				},
				'args'                => array(
					'provider' => array(
						'type'     => 'string',
						'enum'     => array( 'brevo' ),
						'required' => true,
					),
					'refresh'  => array( 'type' => 'boolean' ),
				),
			)
		);
		register_rest_route(
			'cozy-block/v1',
			'/form-mailchimp-tags',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'mailchimp_tags' ),
				'permission_callback' => static function () {
					return current_user_can( 'edit_posts' );
				},
				'args'                => array(
					'refresh' => array( 'type' => 'boolean' ),
				),
			)
		);
		register_rest_route(
			'cozy-block/v1',
			'/form-merge-fields',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'merge_fields' ),
				'permission_callback' => static function () {
					return current_user_can( 'edit_posts' );
				},
				'args'                => array(
					'refresh' => array( 'type' => 'boolean' ),
				),
			)
		);
	}

	/**
	 * Pro: tags of the Mailchimp audience, to choose from on a Form block. Never includes the key.
	 *
	 * @param WP_REST_Request $req Request.
	 * @return WP_REST_Response
	 */
	public static function mailchimp_tags( WP_REST_Request $req ) {
		if ( ! self::connected( 'mailchimp' ) || '' === (string) cozy_addons_form_settings()['mailchimp_audience'] ) {
			return new WP_REST_Response( array( 'message' => __( 'Connect Mailchimp and add the Audience ID first.', 'cozy-addons' ) ), 400 );
		}
		$tags = Integration_Mailchimp::tags( (bool) $req->get_param( 'refresh' ) );
		if ( is_wp_error( $tags ) ) {
			return new WP_REST_Response( array( 'message' => $tags->get_error_message() ), 502 );
		}

		return new WP_REST_Response( array( 'tags' => $tags ), 200 );
	}

	/**
	 * Pro: fields of the Mailchimp audience, for mapping form fields to them in the editor. Address
	 * fields need several answers together, so they are not offered. Never includes the key.
	 *
	 * @param WP_REST_Request $req Request.
	 * @return WP_REST_Response
	 */
	public static function merge_fields( WP_REST_Request $req ) {
		if ( ! self::connected( 'mailchimp' ) || '' === (string) cozy_addons_form_settings()['mailchimp_audience'] ) {
			return new WP_REST_Response( array( 'message' => __( 'Connect Mailchimp and add the Audience ID first.', 'cozy-addons' ) ), 400 );
		}
		$fields = Integration_Mailchimp::merge_fields( (bool) $req->get_param( 'refresh' ) );
		if ( is_wp_error( $fields ) ) {
			return new WP_REST_Response( array( 'message' => $fields->get_error_message() ), 502 );
		}
		$fields = array_values(
			array_filter(
				$fields,
				static function ( $field ) {
					return 'address' !== $field['type'];
				}
			)
		);

		return new WP_REST_Response( array( 'fields' => $fields ), 200 );
	}

	/**
	 * Lists of the connected Brevo account, as IDs and names. Cached for 10 minutes.
	 *
	 * @param WP_REST_Request $req Request.
	 * @return WP_REST_Response
	 */
	public static function lists( WP_REST_Request $req ) {
		$provider = (string) $req->get_param( 'provider' );
		if ( ! self::connected( $provider ) ) {
			return new WP_REST_Response( array( 'message' => __( 'This service is not connected.', 'cozy-addons' ) ), 400 );
		}
		// The cache key changes with the API key, so a new account never shows old lists.
		$cache = 'ca_form_lists_' . $provider . '_' . substr( md5( (string) cozy_addons_form_settings()[ $provider . '_key' ] ), 0, 12 );
		$lists = $req->get_param( 'refresh' ) ? false : get_transient( $cache );
		if ( false === $lists ) {
			$lists = Integration_Brevo::lists();
			if ( is_wp_error( $lists ) ) {
				return new WP_REST_Response( array( 'message' => $lists->get_error_message() ), 502 );
			}
			set_transient( $cache, $lists, 10 * MINUTE_IN_SECONDS );
		}

		return new WP_REST_Response( array( 'lists' => $lists ), 200 );
	}

	/**
	 * Retries an entry's failed jobs, from the entry screen.
	 *
	 * @return void
	 */
	public static function retry() {
		$entry_id = isset( $_GET['entry'] ) ? absint( $_GET['entry'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Verified below.
		check_admin_referer( 'ca_form_sync_retry_' . $entry_id );
		if ( ! $entry_id || Entry_Post_Type::TYPE !== get_post_type( $entry_id ) || ! current_user_can( 'edit_post', $entry_id ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to do that.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		$jobs = get_post_meta( $entry_id, self::META, true );
		if ( is_array( $jobs ) ) {
			foreach ( $jobs as $i => $job ) {
				if ( 'failed' === $job['status'] ) {
					$jobs[ $i ] = array_merge(
						$job,
						array(
							'status'  => 'pending',
							'message' => '',
						)
					);
				}
			}
			update_post_meta( $entry_id, self::META, $jobs );
			self::run( $entry_id );
		}
		wp_safe_redirect( get_edit_post_link( $entry_id, 'raw' ) );
		exit;
	}

	/**
	 * Retry link for the entry screen.
	 *
	 * @param int $entry_id Entry ID.
	 * @return string
	 */
	public static function retry_url( $entry_id ) {
		return wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'ca_form_sync_retry',
					'entry'  => (int) $entry_id,
				),
				admin_url( 'admin-post.php' )
			),
			'ca_form_sync_retry_' . (int) $entry_id
		);
	}

	/**
	 * Sends a sample entry to one webhook, from Settings → Integrations.
	 *
	 * @return void
	 */
	public static function test_webhook() {
		$id = isset( $_GET['webhook'] ) ? sanitize_key( wp_unslash( $_GET['webhook'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Verified below.
		check_admin_referer( 'ca_form_webhook_test_' . $id );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to do that.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		$webhook = Integration_Webhooks::get( $id );
		$result  = $webhook && cozy_addons_premium_access()
			? Integration_Webhooks::deliver(
				$webhook,
				array(
					'event'        => 'test',
					'entry_id'     => 0,
					'form'         => array(
						'id'       => 'test',
						'name'     => __( 'Test form', 'cozy-addons' ),
						'type'     => 'contact',
						'category' => '',
					),
					'submitted_at' => gmdate( 'c' ),
					'page_url'     => home_url( '/' ),
					'urgent'       => false,
					'fields'       => array(
						array(
							'name'  => 'name',
							'label' => __( 'Name', 'cozy-addons' ),
							'type'  => 'text',
							'value' => 'Jane Doe',
						),
						array(
							'name'  => 'email',
							'label' => __( 'Email', 'cozy-addons' ),
							'type'  => 'email',
							'value' => 'jane@example.com',
						),
					),
					'site'         => home_url( '/' ),
				),
				'test'
			)
			: array( 'fail', __( 'This webhook was not found.', 'cozy-addons' ) );

		set_transient( 'ca_form_webhook_test_' . get_current_user_id(), array( 'id' => $id, 'ok' => 'ok' === $result[0], 'message' => $result[1] ), MINUTE_IN_SECONDS );
		wp_safe_redirect( cozy_addons_form_admin_url( Form_Settings::PAGE, array( 'tab' => 'integrations' ) ) );
		exit;
	}

	/**
	 * Link that sends a test to a webhook.
	 *
	 * @param string $id Webhook ID.
	 * @return string
	 */
	public static function test_url( $id ) {
		return wp_nonce_url(
			add_query_arg(
				array(
					'action'  => 'ca_form_webhook_test',
					'webhook' => $id,
				),
				admin_url( 'admin-post.php' )
			),
			'ca_form_webhook_test_' . $id
		);
	}

	/**
	 * Human label of a job, for the entry screen.
	 *
	 * @param array $job Job.
	 * @return string
	 */
	public static function label( array $job ) {
		if ( 'webhook' === $job['type'] ) {
			/* translators: %s: webhook host, e.g. hooks.zapier.com */
			return sprintf( __( 'Webhook %s', 'cozy-addons' ), $job['host'] ?? '' );
		}
		$name = 'mailchimp' === $job['type'] ? __( 'Mailchimp', 'cozy-addons' ) : __( 'Brevo', 'cozy-addons' );

		/* translators: 1: service name, 2: list ID */
		return sprintf( __( '%1$s list %2$s', 'cozy-addons' ), $name, $job['target'] );
	}
}
