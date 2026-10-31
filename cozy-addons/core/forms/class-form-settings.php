<?php
/**
 * Lead Forms → Settings: General, Spam protection, Integrations and Data & privacy tabs.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers and renders the form settings.
 */
final class Form_Settings {

	const PAGE   = 'ca-form-settings';
	const OPTION = 'ca_form_settings';
	const GROUP  = 'ca_form_settings_group';

	/**
	 * Registers hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
		add_action( 'admin_post_ca_form_test_email', array( __CLASS__, 'test_email' ) );
		add_action( 'admin_post_ca_form_activate_smtp', array( Form_Mailer::class, 'activate' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_installer' ) );
	}

	/**
	 * Adds Settings under the Lead Forms menu.
	 *
	 * @return void
	 */
	public static function menu() {
		add_submenu_page(
			'edit.php?post_type=' . Entry_Post_Type::TYPE,
			__( 'Lead Settings', 'cozy-addons' ),
			__( 'Settings', 'cozy-addons' ),
			'manage_options',
			self::PAGE,
			array( __CLASS__, 'render' )
		);
	}

	/**
	 * Registers the setting.
	 *
	 * @return void
	 */
	public static function register() {
		register_setting(
			self::GROUP,
			self::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( __CLASS__, 'sanitize' ),
				'default'           => array(),
				// Holds the Turnstile secret key, so it must never be readable through /wp/v2/settings.
				'show_in_rest'      => false,
			)
		);
	}

	/**
	 * The settings tabs and the keys each one saves.
	 *
	 * @return array<string,array{label:string,keys:string[]}>
	 */
	public static function tabs() {
		return array(
			'general'      => array(
				'label' => __( 'General', 'cozy-addons' ),
				'keys'  => array( 'from_name', 'from_email', 'return_path', 'notify_emails', 'autoreply_enabled', 'autoreply_subject', 'autoreply_message', 'urgent_categories', 'overdue_hours' ),
			),
			'spam'         => array(
				'label' => __( 'Spam protection', 'cozy-addons' ),
				'keys'  => array( 'captcha_default', 'recaptcha_version', 'recaptcha_site_key', 'recaptcha_secret_key', 'recaptcha_threshold', 'turnstile_site_key', 'turnstile_secret_key', 'akismet', 'ip_source' ),
			),
			'integrations' => array(
				'label' => __( 'Integrations', 'cozy-addons' ),
				'keys'  => array( 'mailing_service', 'mailchimp_key', 'mailchimp_audience', 'mailchimp_double', 'mailchimp_update', 'mailchimp_unsub_link', 'brevo_key', 'brevo_doi_template', 'brevo_doi_redirect', 'webhooks' ),
			),
			'privacy'      => array(
				'label' => __( 'Data & privacy', 'cozy-addons' ),
				'keys'  => array( 'retention_days', 'delete_data' ),
			),
		);
	}

	/**
	 * Sanitizes the settings array.
	 *
	 * Each tab posts its own keys and a hidden "_tab"; the other tabs' values are kept as stored, so
	 * saving one tab never resets another. Without "_tab" (e.g. WordPress re-running this on the
	 * first save) every key is cleaned.
	 *
	 * Free sites cannot edit the Pro fields, so their stored values are kept as they are.
	 * The Turnstile secret is never printed back into the form, so a blank field keeps the saved one.
	 *
	 * @param mixed $input Raw settings.
	 * @return array
	 */
	public static function sanitize( $input ) {
		$input    = is_array( $input ) ? $input : array();
		$existing = cozy_addons_form_settings();
		$tabs     = self::tabs();
		$tab      = isset( $input['_tab'] ) && is_string( $input['_tab'] ) && isset( $tabs[ $input['_tab'] ] ) ? $input['_tab'] : '';
		$keys     = '' !== $tab ? $tabs[ $tab ]['keys'] : array_keys( $existing );
		$is_pro   = cozy_addons_premium_access();
		$clean    = $existing;

		foreach ( $keys as $key ) {
			switch ( $key ) {
				case 'from_name':
					$name          = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : '';
					$clean[ $key ] = mb_substr( trim( str_replace( array( '<', '>', '"', "\r", "\n" ), '', $name ) ), 0, 100 );
					break;

				case 'from_email':
					$typed   = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? trim( $input[ $key ] ) : '';
					$address = sanitize_email( $typed );
					if ( '' !== $typed && ! is_email( $address ) ) {
						self::error( 'ca_form_from_email', __( 'The sender email is not a valid address, so the WordPress default is used.', 'cozy-addons' ) );
						$address = '';
					}
					$clean[ $key ] = $address;
					break;

				case 'return_path':
					$clean[ $key ] = empty( $input[ $key ] ) ? 0 : 1;
					break;

				case 'notify_emails':
					$clean[ $key ] = implode( ', ', cozy_addons_form_parse_emails( isset( $input[ $key ] ) ? $input[ $key ] : '' ) );
					break;

				case 'autoreply_enabled':
				case 'akismet':
				case 'mailchimp_double':
				case 'mailchimp_update':
				case 'mailchimp_unsub_link':
				case 'delete_data':
					// Pro settings keep their saved values on free sites.
					if ( 'delete_data' === $key || $is_pro ) {
						$clean[ $key ] = empty( $input[ $key ] ) ? 0 : 1;
					}
					break;

				case 'autoreply_subject':
				case 'turnstile_site_key':
				case 'recaptcha_site_key':
					if ( $is_pro ) {
						$clean[ $key ] = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? trim( sanitize_text_field( $input[ $key ] ) ) : '';
					}
					break;

				case 'autoreply_message':
					if ( $is_pro ) {
						$clean[ $key ] = sanitize_textarea_field( isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? $input[ $key ] : '' );
					}
					break;

				case 'urgent_categories':
					$chosen        = isset( $input[ $key ] ) && is_array( $input[ $key ] ) ? array_map( 'sanitize_key', $input[ $key ] ) : array();
					$clean[ $key ] = array_values( array_intersect( $chosen, array_keys( cozy_addons_form_categories() ) ) );
					break;

				case 'overdue_hours':
					if ( $is_pro ) {
						$clean[ $key ] = isset( $input[ $key ] ) ? min( 720, max( 1, absint( $input[ $key ] ) ) ) : 24;
					}
					break;

				case 'turnstile_secret_key':
				case 'recaptcha_secret_key':
					if ( ! $is_pro ) {
						break;
					}
					$secret = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? trim( sanitize_text_field( $input[ $key ] ) ) : '';
					if ( '' === $secret ) {
						$secret = $existing[ $key ];
					}
					if ( ! empty( $input[ 'turnstile_secret_key' === $key ? 'turnstile_clear' : 'recaptcha_clear' ] ) ) {
						$secret = '';
					}
					$clean[ $key ] = $secret;
					break;

				case 'captcha_default':
					if ( $is_pro ) {
						$choice        = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? $input[ $key ] : '';
						$clean[ $key ] = in_array( $choice, array( 'none', 'recaptcha', 'turnstile' ), true ) ? $choice : '';
					}
					break;

				case 'recaptcha_version':
					if ( $is_pro ) {
						$clean[ $key ] = isset( $input[ $key ] ) && 'v2' === $input[ $key ] ? 'v2' : 'v3';
					}
					break;

				case 'recaptcha_threshold':
					if ( $is_pro ) {
						$clean[ $key ] = isset( $input[ $key ] ) && is_numeric( $input[ $key ] ) ? round( min( 0.9, max( 0.1, (float) $input[ $key ] ) ), 1 ) : 0.5;
					}
					break;

				case 'mailing_service':
					if ( $is_pro ) {
						$choice        = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? $input[ $key ] : '';
						$allowed       = cozy_addons_form_brevo_available() ? array( 'none', 'mailchimp', 'brevo' ) : array( 'none', 'mailchimp' );
						$clean[ $key ] = in_array( $choice, $allowed, true ) ? $choice : '';
					}
					break;

				case 'mailchimp_key':
				case 'brevo_key':
					if ( ! $is_pro ) {
						break;
					}
					$provider = 'mailchimp_key' === $key ? 'mailchimp' : 'brevo';
					if ( ! empty( $input[ $provider . '_clear' ] ) ) {
						$clean[ $key ]                   = '';
						$clean[ $provider . '_account' ] = '';
						break;
					}
					// Never printed back: a blank field keeps the saved key. A new key is checked first.
					$api_key = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? trim( sanitize_text_field( $input[ $key ] ) ) : '';
					if ( '' === $api_key || $api_key === $existing[ $key ] ) {
						break;
					}
					$account = 'mailchimp' === $provider ? Integration_Mailchimp::account( $api_key ) : Integration_Brevo::account( $api_key );
					if ( is_wp_error( $account ) ) {
						self::error( 'ca_form_' . $provider, $account->get_error_message() );
						break;
					}
					$clean[ $key ]                   = $api_key;
					$clean[ $provider . '_account' ] = '' !== $account ? $account : __( 'Connected', 'cozy-addons' );
					break;

				case 'mailchimp_audience':
					if ( ! $is_pro ) {
						break;
					}
					if ( ! empty( $input['mailchimp_clear'] ) ) {
						$clean[ $key ]            = '';
						$clean['mailchimp_unsub'] = '';
						break;
					}
					$audience = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? trim( sanitize_text_field( $input[ $key ] ) ) : '';
					$mc_key   = (string) $clean['mailchimp_key'];
					if ( '' === $audience || ( $audience === $existing[ $key ] && $mc_key === $existing['mailchimp_key'] ) ) {
						$clean[ $key ] = $audience;
						if ( '' === $audience ) {
							$clean['mailchimp_unsub'] = '';
						}
						break;
					}
					// Checked with Mailchimp once there is a key, so a typo shows up here and not on entries.
					$checked = '' !== $mc_key ? Integration_Mailchimp::audience( $audience, $mc_key ) : ( Integration_Mailchimp::valid_audience( $audience ) ? true : new \WP_Error( 'cozy_mailchimp_audience', __( 'This does not look like a Mailchimp Audience ID, e.g. "a1b2c3d4e5".', 'cozy-addons' ) ) );
					if ( is_wp_error( $checked ) ) {
						self::error( 'ca_form_mailchimp_audience', $checked->get_error_message() );
						break;
					}
					$clean[ $key ]            = $audience;
					$clean['mailchimp_unsub'] = is_array( $checked ) ? $checked['unsubscribe'] : '';
					break;

				case 'mailchimp_unsub':
					// Set alongside the audience; kept when WordPress cleans the whole array again.
					if ( '' === $tab && isset( $input[ $key ] ) && is_string( $input[ $key ] ) ) {
						$clean[ $key ] = '' === $input[ $key ] ? '' : Integration_Mailchimp::unsubscribe_from( str_replace( '/unsubscribe?', '/subscribe?', $input[ $key ] ) );
					}
					break;

				case 'mailchimp_account':
				case 'brevo_account':
					// Only set alongside the key, except when WordPress cleans the whole array again.
					if ( '' === $tab && isset( $input[ $key ] ) && is_string( $input[ $key ] ) ) {
						$clean[ $key ] = sanitize_text_field( $input[ $key ] );
					}
					break;

				case 'brevo_doi_template':
					if ( $is_pro ) {
						$clean[ $key ] = isset( $input[ $key ] ) ? absint( $input[ $key ] ) : 0;
					}
					break;

				case 'brevo_doi_redirect':
					if ( $is_pro ) {
						$clean[ $key ] = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? esc_url_raw( trim( $input[ $key ] ), array( 'http', 'https' ) ) : '';
					}
					break;

				case 'webhooks':
					if ( $is_pro ) {
						$clean[ $key ] = self::sanitize_webhooks( isset( $input[ $key ] ) && is_array( $input[ $key ] ) ? $input[ $key ] : array(), (array) $existing[ $key ], '' === $tab );
					}
					break;

				case 'ip_source':
					$ip_source     = isset( $input[ $key ] ) ? sanitize_key( $input[ $key ] ) : 'remote_addr';
					$clean[ $key ] = in_array( $ip_source, array( 'remote_addr', 'cloudflare', 'forwarded' ), true ) ? $ip_source : 'remote_addr';
					break;

				case 'retention_days':
					$clean[ $key ] = isset( $input[ $key ] ) ? min( 3650, absint( $input[ $key ] ) ) : 0;
					break;
			}
		}

		return $clean;
	}

	/**
	 * WordPress's plugin installer for the "Install & activate" buttons on Settings → General.
	 *
	 * @param string $hook Admin page hook.
	 * @return void
	 */
	public static function enqueue_installer( $hook ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only picks the screen.
		if ( false === strpos( (string) $hook, self::PAGE ) || ( isset( $_GET['tab'] ) && 'general' !== $_GET['tab'] ) || ! Form_Mailer::can_install() ) {
			return;
		}
		wp_enqueue_script( 'updates' );
		// Asks for FTP/SSH details when the server cannot write plugin files directly.
		add_action( 'admin_footer', 'wp_print_request_filesystem_credentials_modal' );
		wp_add_inline_script(
			'updates',
			"document.addEventListener( 'click', function ( event ) {
				var button = event.target.closest( '.ca-form-install-smtp' );
				if ( ! button || button.disabled ) {
					return;
				}
				button.disabled = true;
				button.classList.add( 'updating-message' );
				button.textContent = " . wp_json_encode( __( 'Installing…', 'cozy-addons' ) ) . ";
				wp.updates.installPlugin( {
					slug: button.getAttribute( 'data-slug' ),
					success: function () {
						button.textContent = " . wp_json_encode( __( 'Activating…', 'cozy-addons' ) ) . ";
						window.location.href = button.getAttribute( 'data-activate' );
					},
					error: function ( response ) {
						button.disabled = false;
						button.classList.remove( 'updating-message' );
						button.textContent = " . wp_json_encode( __( 'Install & activate', 'cozy-addons' ) ) . ";
						window.alert( ( response && response.errorMessage ) || " . wp_json_encode( __( 'The plugin could not be installed.', 'cozy-addons' ) ) . " );
					}
				} );
			} );"
		);
	}

	/**
	 * Sends a test email with the saved sender to the current user, from Settings → General.
	 *
	 * @return void
	 */
	public static function test_email() {
		check_admin_referer( 'ca_form_test_email' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to do that.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}

		$site = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
		$sent = cozy_addons_form_mail(
			wp_get_current_user()->user_email,
			/* translators: %s: site name */
			sprintf( __( '[%s] Test email from Lead Forms', 'cozy-addons' ), $site ),
			__( 'This is a test of the sender set under Lead Forms → Settings → General. If it arrived in your inbox, form notifications will be sent the same way.', 'cozy-addons' )
		);
		set_transient(
			'ca_form_test_email_' . get_current_user_id(),
			array(
				'ok'      => $sent,
				'message' => $sent
					? __( 'Test email sent. Check the inbox, and the spam folder.', 'cozy-addons' )
					/* translators: %s: error from the mailer */
					: sprintf( __( 'The test email could not be sent: %s', 'cozy-addons' ), cozy_addons_form_mail_error() ),
			),
			MINUTE_IN_SECONDS
		);
		wp_safe_redirect( cozy_addons_form_admin_url( self::PAGE, array( 'tab' => 'general' ) ) );
		exit;
	}

	/**
	 * Shows a message on the settings screen. Settings can also be saved outside the admin
	 * (e.g. WP-CLI), where there is no screen to show it on.
	 *
	 * @param string $code    Message ID.
	 * @param string $message Message.
	 * @return void
	 */
	private static function error( $code, $message ) {
		if ( function_exists( 'add_settings_error' ) ) {
			add_settings_error( self::OPTION, $code, $message );
		}
	}

	/**
	 * Cleans the webhook rows. Each keeps its ID and signing secret; new rows, and rows asked to,
	 * get a new secret, which is shown once after saving. Addresses on the server's own network
	 * are refused.
	 *
	 * @param array $rows     Posted rows.
	 * @param array $existing Saved rows.
	 * @param bool  $internal WordPress cleaning the already-clean array again (first save).
	 * @return array
	 */
	private static function sanitize_webhooks( array $rows, array $existing, $internal ) {
		$saved = array();
		foreach ( $existing as $row ) {
			if ( is_array( $row ) && ! empty( $row['id'] ) ) {
				$saved[ $row['id'] ] = $row;
			}
		}

		$out     = array();
		$secrets = array();
		foreach ( array_slice( array_values( $rows ), 0, Integration_Webhooks::MAX ) as $row ) {
			if ( ! is_array( $row ) || ! empty( $row['remove'] ) ) {
				continue;
			}
			$url = isset( $row['url'] ) && is_string( $row['url'] ) ? esc_url_raw( trim( $row['url'] ), array( 'http', 'https' ) ) : '';
			if ( '' === $url ) {
				continue;
			}
			if ( ! wp_http_validate_url( $url ) ) {
				/* translators: %s: webhook address */
				self::error( 'ca_form_webhook', sprintf( __( 'The webhook address %s is not allowed. Use a public http(s) address.', 'cozy-addons' ), $url ) );
				continue;
			}

			$id = isset( $row['id'] ) && is_string( $row['id'] ) ? sanitize_key( $row['id'] ) : '';
			if ( isset( $saved[ $id ] ) ) {
				$secret = $saved[ $id ]['secret'];
			} elseif ( $internal && '' !== $id && isset( $row['secret'] ) && is_string( $row['secret'] ) && preg_match( '/^whsec_[a-f0-9]{48}$/', $row['secret'] ) ) {
				$secret = $row['secret'];
			} else {
				$id     = strtolower( wp_generate_password( 12, false, false ) );
				$secret = '';
			}
			if ( '' === $secret || ! empty( $row['regenerate'] ) ) {
				$secret         = 'whsec_' . bin2hex( random_bytes( 24 ) );
				$secrets[ $id ] = $secret;
			}

			$out[] = array(
				'id'     => $id,
				'url'    => $url,
				'secret' => $secret,
				'active' => empty( $row['active'] ) ? 0 : 1,
			);
		}

		// New secrets are shown once, to the person who saved them.
		if ( $secrets ) {
			$key   = 'ca_form_new_webhook_secrets_' . get_current_user_id();
			$shown = get_transient( $key );
			set_transient( $key, array_merge( is_array( $shown ) ? $shown : array(), $secrets ), 10 * MINUTE_IN_SECONDS );
		}

		return $out;
	}

	/**
	 * Renders the settings page with its tabs.
	 *
	 * @return void
	 */
	public static function render() {
		$tabs = self::tabs();
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only tab switch.
		$tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'general';
		$tab = isset( $tabs[ $tab ] ) ? $tab : 'general';
		?>
		<div class="wrap ca-form-settings">
			<h1><?php esc_html_e( 'Lead Settings', 'cozy-addons' ); ?></h1>
			<p><?php esc_html_e( 'These settings apply to every Cozy Blocks Form block. Entries are listed under Lead Forms → Inbox.', 'cozy-addons' ); ?></p>

			<nav class="nav-tab-wrapper">
				<?php foreach ( $tabs as $slug => $info ) : ?>
					<a href="<?php echo esc_url( cozy_addons_form_admin_url( self::PAGE, array( 'tab' => $slug ) ) ); ?>" class="nav-tab<?php echo $slug === $tab ? ' nav-tab-active' : ''; ?>"<?php echo $slug === $tab ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $info['label'] ); ?></a>
				<?php endforeach; ?>
			</nav>

			<?php settings_errors(); ?>
			<form method="post" action="options.php">
				<?php settings_fields( self::GROUP ); ?>
				<input type="hidden" name="ca_form_settings[_tab]" value="<?php echo esc_attr( $tab ); ?>">
				<table class="form-table" role="presentation">
					<?php
					if ( 'general' === $tab ) {
						self::render_general();
					} elseif ( 'spam' === $tab ) {
						self::render_spam();
					} elseif ( 'integrations' === $tab ) {
						self::render_integrations();
					} else {
						self::render_privacy();
					}
					?>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * General tab: notifications, auto-reply and urgency.
	 *
	 * @return void
	 */
	private static function render_general() {
		$s      = cozy_addons_form_settings();
		$is_pro = cozy_addons_premium_access();
		$locked = $is_pro ? '' : ' disabled';
		?>
		<?php
		$site_host = (string) wp_parse_url( home_url(), PHP_URL_HOST );
		$site_host = preg_replace( '/^www\./', '', $site_host );
		$from_host = '' !== $s['from_email'] ? strtolower( substr( strrchr( $s['from_email'], '@' ), 1 ) ) : '';
		// Same domain, or one is a subdomain of the other (e.g. mail.example.com). WordPress polyfills str_ends_with().
		$other     = '' !== $from_host && $from_host !== $site_host && ! str_ends_with( $site_host, '.' . $from_host ) && ! str_ends_with( $from_host, '.' . $site_host );
		$smtp      = Form_Mailer::current();
		$notice    = get_transient( 'ca_form_smtp_notice_' . get_current_user_id() );
		if ( $notice ) {
			delete_transient( 'ca_form_smtp_notice_' . get_current_user_id() );
		}
		$test      = get_transient( 'ca_form_test_email_' . get_current_user_id() );
		if ( $test ) {
			delete_transient( 'ca_form_test_email_' . get_current_user_id() );
		}
		?>
		<tr>
			<th scope="row"><?php esc_html_e( 'Email sender', 'cozy-addons' ); ?></th>
			<td>
				<?php if ( $test ) : ?>
					<div class="notice inline <?php echo $test['ok'] ? 'notice-success' : 'notice-error'; ?>"><p><?php echo esc_html( $test['message'] ); ?></p></div>
				<?php endif; ?>
				<?php if ( $notice ) : ?>
					<div class="notice inline <?php echo $notice['ok'] ? 'notice-success' : 'notice-error'; ?>"><p><?php echo esc_html( $notice['message'] ); ?></p></div>
				<?php endif; ?>
				<?php $conflict = Form_Mailer::conflict_message(); ?>
				<?php if ( '' !== $conflict ) : ?>
					<div class="notice inline notice-warning"><p><?php echo esc_html( $conflict ); ?> <a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>"><?php esc_html_e( 'Go to Plugins', 'cozy-addons' ); ?></a></p></div>
				<?php endif; ?>
				<?php if ( $smtp && $smtp['configured'] ) : ?>
					<?php
					// The SMTP plugin's selected setup sends. The Lead Forms sender is kept for when it
					// is turned off, and used as From when the plugin can send as it.
					$profile = Form_Mailer::profile();
					?>
					<input type="hidden" name="ca_form_settings[from_name]" value="<?php echo esc_attr( $s['from_name'] ); ?>">
					<input type="hidden" name="ca_form_settings[from_email]" value="<?php echo esc_attr( $s['from_email'] ); ?>">
					<input type="hidden" name="ca_form_settings[return_path]" value="<?php echo esc_attr( (string) $s['return_path'] ); ?>">
					<div class="ca-form-mailer is-active">
						<span class="dashicons dashicons-yes-alt" aria-hidden="true"></span>
						<div>
							<p>
								<?php
								echo wp_kses(
									'' !== $profile['from_email']
										/* translators: 1: SMTP plugin name, 2: mail service and connection, 3: sender email */
										? sprintf( __( 'Form emails are sent through <strong>%1$s</strong> (%2$s) from <strong>%3$s</strong>.', 'cozy-addons' ), esc_html( $smtp['name'] ), esc_html( '' !== $smtp['connection'] ? $smtp['mailer'] . ' – ' . $smtp['connection'] : $smtp['mailer'] ), esc_html( $profile['from_email'] ) )
										: ( '' !== $smtp['mailer']
											/* translators: 1: SMTP plugin name, 2: mail service */
											? sprintf( __( 'Form emails are sent through <strong>%1$s</strong> (%2$s).', 'cozy-addons' ), esc_html( $smtp['name'] ), esc_html( $smtp['mailer'] ) )
											/* translators: %s: plugin name */
											: sprintf( __( 'Form emails are sent through <strong>%s</strong>.', 'cozy-addons' ), esc_html( $smtp['name'] ) ) ),
									array( 'strong' => array() )
								);
								?>
							</p>
							<p class="description"><?php echo esc_html( sprintf( /* translators: %s: SMTP plugin name */ __( 'The sender and the mail service are set in %s.', 'cozy-addons' ), $smtp['name'] ) ); ?></p>
							<?php if ( '' !== $smtp['settings_url'] ) : ?>
								<p><a class="button" href="<?php echo esc_url( $smtp['settings_url'] ); ?>"><?php echo esc_html( sprintf( /* translators: %s: SMTP plugin name */ __( 'Open %s settings', 'cozy-addons' ), $smtp['name'] ) ); ?></a></p>
							<?php endif; ?>
						</div>
					</div>
				<?php elseif ( $smtp ) : ?>
					<div class="notice notice-warning inline">
						<p>
							<?php echo esc_html( sprintf( /* translators: %s: SMTP plugin name */ __( '%s is active but no mail service is set up yet: it still uses PHP mail, which many servers cannot send. Choose a mailer (e.g. Google / Gmail) in its settings. Until then, form emails use the sender below.', 'cozy-addons' ), $smtp['name'] ) ); ?>
						</p>
						<p><a class="button" href="<?php echo esc_url( $smtp['settings_url'] ); ?>"><?php echo esc_html( sprintf( /* translators: %s: SMTP plugin name */ __( 'Open %s settings', 'cozy-addons' ), $smtp['name'] ) ); ?></a></p>
					</div>
				<?php endif; ?>
				<?php if ( ! $smtp || ! $smtp['configured'] ) : ?>
					<?php
					$state   = Form_Mailer::state();
					$install = Form_Mailer::can_install();
					?>
					<?php if ( ! $smtp ) : ?>
					<div class="ca-form-mailers">
						<p><strong><?php esc_html_e( 'Send with a mail service', 'cozy-addons' ); ?></strong></p>
						<p class="description"><?php esc_html_e( 'An SMTP plugin sends your emails through a mail service (Gmail, Microsoft, SendGrid, Brevo, Amazon SES…) with SPF/DKIM authentication, so they stay out of spam. Once one is active, form emails use it.', 'cozy-addons' ); ?></p>
						<div class="ca-form-mailers__list">
							<?php foreach ( Form_Mailer::plugins() as $slug => $plugin ) : ?>
								<?php $icon = Form_Mailer::icon( $slug ); ?>
								<div class="ca-form-mailer">
									<?php if ( '' !== $icon ) : ?>
										<img src="<?php echo esc_url( $icon ); ?>" alt="" width="40" height="40">
									<?php else : ?>
										<span class="dashicons dashicons-email-alt" aria-hidden="true"></span>
									<?php endif; ?>
									<div>
										<p><strong><?php echo esc_html( $plugin['name'] ); ?></strong></p>
										<p class="description"><?php echo esc_html( $plugin['description'] ); ?></p>
										<?php if ( $state[ $slug ]['installed'] && current_user_can( 'activate_plugins' ) ) : ?>
											<a class="button" href="<?php echo esc_url( Form_Mailer::activate_url( $slug ) ); ?>"><?php esc_html_e( 'Activate', 'cozy-addons' ); ?></a>
										<?php elseif ( ! $state[ $slug ]['installed'] && $install ) : ?>
											<button type="button" class="button ca-form-install-smtp" data-slug="<?php echo esc_attr( $slug ); ?>" data-activate="<?php echo esc_url( Form_Mailer::activate_url( $slug ) ); ?>"><?php esc_html_e( 'Install & activate', 'cozy-addons' ); ?></button>
										<?php elseif ( ! $state[ $slug ]['installed'] ) : ?>
											<a href="<?php echo esc_url( 'https://wordpress.org/plugins/' . $slug . '/' ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View on WordPress.org', 'cozy-addons' ); ?></a>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<p><strong><?php esc_html_e( 'Or keep the default mailer', 'cozy-addons' ); ?></strong></p>
					<?php endif; ?>
				<p>
					<label for="ca_form_from_name"><?php esc_html_e( 'From name', 'cozy-addons' ); ?></label><br>
					<input type="text" id="ca_form_from_name" class="regular-text" name="ca_form_settings[from_name]" value="<?php echo esc_attr( $s['from_name'] ); ?>" placeholder="<?php echo esc_attr( wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) ); ?>">
				</p>
				<p>
					<label for="ca_form_from_email"><?php esc_html_e( 'From email', 'cozy-addons' ); ?></label><br>
					<input type="email" id="ca_form_from_email" class="regular-text" name="ca_form_settings[from_email]" value="<?php echo esc_attr( $s['from_email'] ); ?>" placeholder="<?php echo esc_attr( 'noreply@' . $site_host ); ?>">
				</p>
				<p><label><input type="checkbox" name="ca_form_settings[return_path]" value="1" <?php checked( $s['return_path'], 1 ); ?>> <?php esc_html_e( 'Also use it as the envelope sender (Return-Path)', 'cozy-addons' ); ?></label></p>
				<?php if ( $other ) : ?>
					<div class="notice notice-warning inline"><p><?php echo esc_html( sprintf( /* translators: 1: sender domain, 2: site domain */ __( 'This address is on %1$s, not %2$s. Mail from another domain is often marked as spam unless that domain allows this server to send for it (SPF/DKIM).', 'cozy-addons' ), $from_host, $site_host ) ); ?></p></div>
				<?php endif; ?>
				<p class="description"><?php esc_html_e( 'Used for form notifications and auto-replies, so they are less likely to land in spam. Use an address on your own domain that your email host allows, e.g. hello@yourdomain.com. Leave empty to keep the WordPress default. Notifications still reply to the visitor.', 'cozy-addons' ); ?></p>
				<?php endif; ?>
				<p><a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=ca_form_test_email' ), 'ca_form_test_email' ) ); ?>"><?php esc_html_e( 'Send test email', 'cozy-addons' ); ?></a> <span class="description"><?php echo esc_html( $smtp && $smtp['configured'] ? sprintf( /* translators: 1: email address, 2: SMTP plugin name */ __( 'Sends to %1$s through %2$s.', 'cozy-addons' ), wp_get_current_user()->user_email, $smtp['name'] ) : sprintf( /* translators: %s: email address */ __( 'Sends to %s with the saved sender.', 'cozy-addons' ), wp_get_current_user()->user_email ) ); ?></span></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ca_form_notify"><?php esc_html_e( 'Notification emails', 'cozy-addons' ); ?></label></th>
			<td>
				<input type="text" id="ca_form_notify" class="regular-text" name="ca_form_settings[notify_emails]" value="<?php echo esc_attr( $s['notify_emails'] ); ?>" placeholder="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>">
				<p class="description"><?php esc_html_e( 'Comma-separated. Leave empty to use the site admin email. A form can override this in its block settings.', 'cozy-addons' ); ?></p>
			</td>
		</tr>
		<tr class="<?php echo $is_pro ? '' : 'ca-form-is-locked'; ?>">
			<th scope="row">
				<?php esc_html_e( 'Auto-reply to the visitor', 'cozy-addons' ); ?>
				<?php
				if ( ! $is_pro ) {
					cozy_addons_form_print_pro_label();
				}
				?>
			</th>
			<td>
				<label><input type="checkbox" name="ca_form_settings[autoreply_enabled]" value="1" <?php checked( $s['autoreply_enabled'], 1 ); ?><?php echo esc_attr( $locked ); ?>> <?php esc_html_e( 'Send a confirmation email to the person who submitted the form', 'cozy-addons' ); ?></label>
				<p>
					<label for="ca_form_ar_subject"><?php esc_html_e( 'Subject', 'cozy-addons' ); ?></label><br>
					<input type="text" id="ca_form_ar_subject" class="regular-text" name="ca_form_settings[autoreply_subject]" value="<?php echo esc_attr( $s['autoreply_subject'] ); ?>"<?php echo esc_attr( $locked ); ?>>
				</p>
				<p>
					<label for="ca_form_ar_message"><?php esc_html_e( 'Message', 'cozy-addons' ); ?></label><br>
					<textarea id="ca_form_ar_message" class="large-text" rows="6" name="ca_form_settings[autoreply_message]"<?php echo esc_attr( $locked ); ?>><?php echo esc_textarea( $s['autoreply_message'] ); ?></textarea>
				</p>
				<p class="description"><?php esc_html_e( 'Available tags: {name}, {site}, {download_url} (the form\'s file to download). Sent at most once per hour to the same address.', 'cozy-addons' ); ?></p>
				<?php if ( ! $is_pro ) : ?>
					<p><a href="https://cozythemes.com/pricing-and-plans/" target="_blank" rel="noopener"><?php esc_html_e( 'Upgrade to Pro to send auto-replies', 'cozy-addons' ); ?></a></p>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Urgent categories', 'cozy-addons' ); ?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><?php esc_html_e( 'Urgent categories', 'cozy-addons' ); ?></legend>
					<?php foreach ( cozy_addons_form_categories() as $slug => $label ) : ?>
						<label><input type="checkbox" name="ca_form_settings[urgent_categories][]" value="<?php echo esc_attr( $slug ); ?>" <?php checked( in_array( $slug, (array) $s['urgent_categories'], true ) ); ?>> <?php echo esc_html( $label ); ?></label><br>
					<?php endforeach; ?>
				</fieldset>
				<p class="description"><?php esc_html_e( 'Entries from forms in these categories arrive marked urgent. Choose a form\'s category in its block sidebar. A dropdown or choice field can also mark single answers as urgent.', 'cozy-addons' ); ?></p>
			</td>
		</tr>
		<tr class="<?php echo $is_pro ? '' : 'ca-form-is-locked'; ?>">
			<th scope="row">
				<label for="ca_form_overdue"><?php esc_html_e( 'Flag new entries as waiting after', 'cozy-addons' ); ?></label>
				<?php
				if ( ! $is_pro ) {
					cozy_addons_form_print_pro_label();
				}
				?>
			</th>
			<td>
				<input type="number" id="ca_form_overdue" min="1" max="720" class="small-text" name="ca_form_settings[overdue_hours]" value="<?php echo esc_attr( (string) $s['overdue_hours'] ); ?>"<?php echo esc_attr( $locked ); ?>> <?php esc_html_e( 'hours', 'cozy-addons' ); ?>
				<p class="description"><?php esc_html_e( 'Entries still New after this time are shown as waiting in the inbox and in Analytics.', 'cozy-addons' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Spam protection tab: the default check, reCAPTCHA, Turnstile, Akismet and the visitor IP source.
	 *
	 * @return void
	 */
	private static function render_spam() {
		$s      = cozy_addons_form_settings();
		$is_pro = cozy_addons_premium_access();
		$locked = $is_pro ? '' : ' disabled';
		?>
		<tr>
			<th scope="row"><?php esc_html_e( 'Always on', 'cozy-addons' ); ?></th>
			<td><p class="description"><?php esc_html_e( 'Every form already has a hidden honeypot field, a minimum fill time and a per-visitor rate limit. Add a check below for stronger protection. Everything on this tab applies to every form.', 'cozy-addons' ); ?></p></td>
		</tr>
		<tr class="<?php echo $is_pro ? '' : 'ca-form-is-locked'; ?>">
			<th scope="row">
				<?php esc_html_e( 'Spam check', 'cozy-addons' ); ?>
				<?php
				if ( ! $is_pro ) {
					cozy_addons_form_print_pro_label();
				}
				?>
			</th>
			<td>
				<?php
				// Nothing chosen yet keeps Turnstile on sites that already had its keys.
				$default_choice = '' !== $s['captcha_default'] ? $s['captcha_default'] : ( '' !== $s['turnstile_site_key'] && '' !== $s['turnstile_secret_key'] ? 'turnstile' : 'none' );
				$choices        = array(
					'none'      => array( __( 'Honeypot only', 'cozy-addons' ), true ),
					'recaptcha' => array( __( 'Google reCAPTCHA', 'cozy-addons' ), '' !== $s['recaptcha_site_key'] && '' !== $s['recaptcha_secret_key'] ),
					'turnstile' => array( __( 'Cloudflare Turnstile', 'cozy-addons' ), '' !== $s['turnstile_site_key'] && '' !== $s['turnstile_secret_key'] ),
				);
				?>
				<fieldset>
					<legend class="screen-reader-text"><?php esc_html_e( 'Spam check', 'cozy-addons' ); ?></legend>
					<?php foreach ( $choices as $value => $choice ) : ?>
						<label><input type="radio" name="ca_form_settings[captcha_default]" value="<?php echo esc_attr( $value ); ?>" <?php checked( $default_choice, $value ); ?><?php echo esc_attr( $locked ); ?>> <?php echo esc_html( $choice[0] ); ?><?php echo $choice[1] ? '' : ' <span class="description">' . esc_html__( '(add its keys)', 'cozy-addons' ) . '</span>'; ?></label><br>
					<?php endforeach; ?>
				</fieldset>
				<p class="description"><?php esc_html_e( 'Used by every form. A check without keys falls back to the honeypot.', 'cozy-addons' ); ?></p>
			</td>
		</tr>
		<tr class="<?php echo $is_pro ? '' : 'ca-form-is-locked'; ?>" data-ca-check="recaptcha"<?php echo 'recaptcha' === $default_choice ? '' : ' hidden'; ?>>
			<th scope="row">
				<?php esc_html_e( 'Google reCAPTCHA', 'cozy-addons' ); ?>
				<?php
				if ( ! $is_pro ) {
					cozy_addons_form_print_pro_label();
				}
				?>
			</th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><?php esc_html_e( 'reCAPTCHA version', 'cozy-addons' ); ?></legend>
					<label><input type="radio" name="ca_form_settings[recaptcha_version]" value="v3" <?php checked( 'v2' !== $s['recaptcha_version'] ); ?><?php echo esc_attr( $locked ); ?>> <?php esc_html_e( 'v3, invisible: Google scores each submission in the background', 'cozy-addons' ); ?></label><br>
					<label><input type="radio" name="ca_form_settings[recaptcha_version]" value="v2" <?php checked( 'v2', $s['recaptcha_version'] ); ?><?php echo esc_attr( $locked ); ?>> <?php esc_html_e( 'v2, checkbox: "I\'m not a robot"', 'cozy-addons' ); ?></label>
				</fieldset>
				<p>
					<label for="ca_form_rc_site"><?php esc_html_e( 'Site key', 'cozy-addons' ); ?></label><br>
					<input type="text" id="ca_form_rc_site" class="regular-text" name="ca_form_settings[recaptcha_site_key]" value="<?php echo esc_attr( $s['recaptcha_site_key'] ); ?>" autocomplete="off"<?php echo esc_attr( $locked ); ?>>
				</p>
				<p>
					<label for="ca_form_rc_secret"><?php esc_html_e( 'Secret key', 'cozy-addons' ); ?></label><br>
					<?php // The secret is never printed back. A blank field keeps the saved one. ?>
					<input type="password" id="ca_form_rc_secret" class="regular-text" name="ca_form_settings[recaptcha_secret_key]" value="" autocomplete="new-password" placeholder="<?php echo '' !== $s['recaptcha_secret_key'] ? esc_attr__( 'Saved, leave blank to keep', 'cozy-addons' ) : ''; ?>"<?php echo esc_attr( $locked ); ?>>
				</p>
				<?php if ( $is_pro && '' !== $s['recaptcha_secret_key'] ) : ?>
					<p><label><input type="checkbox" name="ca_form_settings[recaptcha_clear]" value="1"> <?php esc_html_e( 'Remove the saved secret key', 'cozy-addons' ); ?></label></p>
				<?php endif; ?>
				<p>
					<label for="ca_form_rc_threshold"><?php esc_html_e( 'Minimum score (v3)', 'cozy-addons' ); ?></label><br>
					<input type="number" id="ca_form_rc_threshold" class="small-text" min="0.1" max="0.9" step="0.1" name="ca_form_settings[recaptcha_threshold]" value="<?php echo esc_attr( (string) $s['recaptcha_threshold'] ); ?>"<?php echo esc_attr( $locked ); ?>>
				</p>
				<p class="description">
					<?php esc_html_e( 'Keys are made for one version, so create them for the version chosen above. Submissions scoring below the minimum are refused; 0.5 suits most sites.', 'cozy-addons' ); ?>
					<a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="noopener"><?php esc_html_e( 'Get your keys', 'cozy-addons' ); ?></a>
				</p>
				<?php
				// CF7 loads Google's script on every page with its key, and one page can only run v3 for that key.
				$cf7_key = Form_Recaptcha::cf7_site_key();
				if ( '' !== $cf7_key && 'v2' !== $s['recaptcha_version'] && $cf7_key !== $s['recaptcha_site_key'] ) :
					?>
					<div class="notice notice-warning inline"><p><?php esc_html_e( 'Contact Form 7 also uses reCAPTCHA on this site, with a different site key, and loads Google\'s script on every page. A page can only run reCAPTCHA v3 for one key, so forms here may be refused as spam. Use the same site and secret keys as Contact Form 7, or choose v2 or Cloudflare Turnstile.', 'cozy-addons' ); ?></p></div>
				<?php endif; ?>
			</td>
		</tr>
		<tr class="<?php echo $is_pro ? '' : 'ca-form-is-locked'; ?>" data-ca-check="turnstile"<?php echo 'turnstile' === $default_choice ? '' : ' hidden'; ?>>
			<th scope="row">
				<?php esc_html_e( 'Cloudflare Turnstile', 'cozy-addons' ); ?>
				<?php
				if ( ! $is_pro ) {
					cozy_addons_form_print_pro_label();
				}
				?>
			</th>
			<td>
				<p>
					<label for="ca_form_ts_site"><?php esc_html_e( 'Site key', 'cozy-addons' ); ?></label><br>
					<input type="text" id="ca_form_ts_site" class="regular-text" name="ca_form_settings[turnstile_site_key]" value="<?php echo esc_attr( $s['turnstile_site_key'] ); ?>" autocomplete="off"<?php echo esc_attr( $locked ); ?>>
				</p>
				<p>
					<label for="ca_form_ts_secret"><?php esc_html_e( 'Secret key', 'cozy-addons' ); ?></label><br>
					<?php // The secret is never printed back. A blank field keeps the saved one. ?>
					<input type="password" id="ca_form_ts_secret" class="regular-text" name="ca_form_settings[turnstile_secret_key]" value="" autocomplete="new-password" placeholder="<?php echo '' !== $s['turnstile_secret_key'] ? esc_attr__( 'Saved, leave blank to keep', 'cozy-addons' ) : ''; ?>"<?php echo esc_attr( $locked ); ?>>
				</p>
				<?php if ( $is_pro && '' !== $s['turnstile_secret_key'] ) : ?>
					<p><label><input type="checkbox" name="ca_form_settings[turnstile_clear]" value="1"> <?php esc_html_e( 'Remove the saved secret key', 'cozy-addons' ); ?></label></p>
				<?php endif; ?>
				<p class="description">
					<?php esc_html_e( 'Forms using Turnstile show its check, and each submission is verified with Cloudflare.', 'cozy-addons' ); ?>
					<a href="https://developers.cloudflare.com/turnstile/get-started/" target="_blank" rel="noopener"><?php esc_html_e( 'Get your keys', 'cozy-addons' ); ?></a>
				</p>
			</td>
		</tr>
		<tr class="<?php echo $is_pro ? '' : 'ca-form-is-locked'; ?>">
			<th scope="row">
				<?php esc_html_e( 'Akismet', 'cozy-addons' ); ?>
				<?php
				if ( ! $is_pro ) {
					cozy_addons_form_print_pro_label();
				}
				?>
			</th>
			<td>
				<?php if ( Form_Akismet::available() ) : ?>
					<label><input type="checkbox" name="ca_form_settings[akismet]" value="1" <?php checked( $s['akismet'], 1 ); ?><?php echo esc_attr( $locked ); ?>> <?php esc_html_e( 'Check submissions with Akismet', 'cozy-addons' ); ?></label>
					<p class="description"><?php esc_html_e( 'Submissions Akismet flags are kept under Lead Forms → Inbox → Spam for 30 days, without sending you an email. The visitor\'s details, IP address and message are sent to Akismet.', 'cozy-addons' ); ?></p>
				<?php else : ?>
					<input type="hidden" name="ca_form_settings[akismet]" value="<?php echo esc_attr( (string) $s['akismet'] ); ?>">
					<p class="description"><?php esc_html_e( 'Install and activate the Akismet plugin with an API key to check submissions with Akismet.', 'cozy-addons' ); ?></p>
				<?php endif; ?>
				<?php if ( ! $is_pro ) : ?>
					<p><a href="https://cozythemes.com/pricing-and-plans/" target="_blank" rel="noopener"><?php esc_html_e( 'Upgrade to Pro for Google reCAPTCHA, Cloudflare Turnstile and Akismet', 'cozy-addons' ); ?></a></p>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ca_form_ip_source"><?php esc_html_e( 'Visitor IP for spam limits', 'cozy-addons' ); ?></label></th>
			<td>
				<select id="ca_form_ip_source" name="ca_form_settings[ip_source]">
					<option value="remote_addr" <?php selected( $s['ip_source'], 'remote_addr' ); ?>><?php esc_html_e( 'Standard (server-reported address)', 'cozy-addons' ); ?></option>
					<option value="cloudflare" <?php selected( $s['ip_source'], 'cloudflare' ); ?>><?php esc_html_e( 'Cloudflare (CF-Connecting-IP header)', 'cozy-addons' ); ?></option>
					<option value="forwarded" <?php selected( $s['ip_source'], 'forwarded' ); ?>><?php esc_html_e( 'Other proxy (X-Forwarded-For header)', 'cozy-addons' ); ?></option>
				</select>
				<p class="description"><?php esc_html_e( 'Only change this if your site is behind that proxy, otherwise visitors could fake their address. IPs are used for rate limiting only and are never saved with entries.', 'cozy-addons' ); ?></p>
			</td>
		</tr>
		<script>
			// Shows the key settings of the chosen check only.
			document.querySelectorAll( 'input[name="ca_form_settings[captcha_default]"]' ).forEach( function ( radio ) {
				radio.addEventListener( 'change', function () {
					document.querySelectorAll( '[data-ca-check]' ).forEach( function ( row ) {
						row.hidden = row.getAttribute( 'data-ca-check' ) !== radio.value;
					} );
				} );
			} );
		</script>
		<?php
	}

	/**
	 * Data & privacy tab: retention and uninstall.
	 *
	 * @return void
	 */
	private static function render_privacy() {
		$s = cozy_addons_form_settings();
		?>
		<tr>
			<th scope="row"><label for="ca_form_retention"><?php esc_html_e( 'Delete old entries after', 'cozy-addons' ); ?></label></th>
			<td>
				<input type="number" id="ca_form_retention" min="0" max="3650" class="small-text" name="ca_form_settings[retention_days]" value="<?php echo esc_attr( (string) $s['retention_days'] ); ?>"> <?php esc_html_e( 'days (0 = keep forever)', 'cozy-addons' ); ?>
				<p class="description"><?php esc_html_e( 'Spam is always deleted after 30 days, or sooner if this is shorter.', 'cozy-addons' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Uninstall', 'cozy-addons' ); ?></th>
			<td>
				<label><input type="checkbox" name="ca_form_settings[delete_data]" value="1" <?php checked( $s['delete_data'], 1 ); ?>> <?php esc_html_e( 'Delete all form entries and these settings when Cozy Blocks is deleted', 'cozy-addons' ); ?></label>
			</td>
		</tr>
		<?php
	}

	/**
	 * Integrations tab (Pro): Mailchimp, Brevo and webhooks.
	 *
	 * @return void
	 */
	private static function render_integrations() {
		// An audience saved before its unsubscribe form was kept gets it now.
		Integration_Mailchimp::ensure_unsubscribe_url();
		$s       = cozy_addons_form_settings();
		$is_pro  = cozy_addons_premium_access();
		$locked  = $is_pro ? '' : ' disabled';
		$row     = $is_pro ? '' : 'ca-form-is-locked';
		$secrets = get_transient( 'ca_form_new_webhook_secrets_' . get_current_user_id() );
		$secrets = is_array( $secrets ) ? $secrets : array();
		$test    = get_transient( 'ca_form_webhook_test_' . get_current_user_id() );
		if ( $secrets ) {
			delete_transient( 'ca_form_new_webhook_secrets_' . get_current_user_id() );
		}
		if ( $test ) {
			delete_transient( 'ca_form_webhook_test_' . get_current_user_id() );
		}
		$pro_label = static function () use ( $is_pro ) {
			if ( ! $is_pro ) {
				cozy_addons_form_print_pro_label();
			}
		};
		?>
		<tr>
			<th scope="row"><?php esc_html_e( 'How it works', 'cozy-addons' ); ?></th>
			<td><p class="description"><?php esc_html_e( 'Connect a mailing list service here, then choose a list on any Email field in the Form block sidebar under "Mailing list". Webhooks receive every new entry from forms that have them on. Contacts and entries are sent right after each submission, after the visitor has their answer; the result shows on the entry, where a failed delivery can be retried.', 'cozy-addons' ); ?></p></td>
		</tr>
		<?php
		// One mailing list service at a time. The other one's saved key is kept for switching back.
		$service  = cozy_addons_form_mailing_service();
		$services = array(
			'none'      => array( __( 'None', 'cozy-addons' ), '' ),
			'mailchimp' => array( __( 'Mailchimp', 'cozy-addons' ), cozy_addons_form_service_logo( 'mailchimp' ) ),
			'brevo'     => array( __( 'Brevo', 'cozy-addons' ), cozy_addons_form_service_logo( 'brevo' ) ),
		);
		?>
		<?php // Not faded like the other locked rows: on free sites the cards show what Pro adds. ?>
		<tr>
			<th scope="row"><?php esc_html_e( 'Mailing list service', 'cozy-addons' ); ?><?php $pro_label(); ?></th>
			<td>
				<fieldset class="ca-form-services<?php echo $is_pro ? '' : ' is-locked'; ?>">
					<legend class="screen-reader-text"><?php esc_html_e( 'Mailing list service', 'cozy-addons' ); ?></legend>
					<?php foreach ( $services as $value => $info ) : ?>
						<?php $soon = 'brevo' === $value && ! cozy_addons_form_brevo_available(); ?>
						<label class="ca-form-service<?php echo $soon ? ' is-soon' : ''; ?>">
							<input type="radio" name="ca_form_settings[mailing_service]" value="<?php echo esc_attr( $value ); ?>" <?php checked( $is_pro && '' !== $service ? $service : 'none', $value ); ?><?php echo esc_attr( $soon ? ' disabled' : $locked ); ?>>
							<span class="ca-form-service__card">
								<?php if ( '' !== $info[1] ) : ?>
									<img src="<?php echo esc_url( $info[1] ); ?>" alt="" width="32" height="32">
								<?php else : ?>
									<span class="ca-form-service__none dashicons dashicons-dismiss" aria-hidden="true"></span>
								<?php endif; ?>
								<span class="ca-form-service__name"><?php echo esc_html( $info[0] ); ?></span>
								<?php if ( $soon ) : ?>
									<span class="ca-form-service__soon"><?php esc_html_e( 'Coming soon', 'cozy-addons' ); ?></span>
								<?php elseif ( ! $is_pro && 'none' !== $value ) : ?>
									<span class="ca-form-service__pro"><?php esc_html_e( 'PRO', 'cozy-addons' ); ?></span>
								<?php elseif ( 'none' !== $value && '' !== $s[ $value . '_key' ] ) : ?>
									<span class="ca-form-service__state"><?php esc_html_e( 'Key saved', 'cozy-addons' ); ?></span>
								<?php endif; ?>
							</span>
						</label>
					<?php endforeach; ?>
				</fieldset>
				<?php if ( $is_pro ) : ?>
					<p class="description"><?php esc_html_e( 'Email fields with "Mailing list" turned on add people to this service. Choose the list on each Email field in the Form block sidebar.', 'cozy-addons' ); ?></p>
				<?php else : ?>
					<p class="description"><?php esc_html_e( 'Add the people who fill in your forms to a Mailchimp audience or Brevo list, with their consent.', 'cozy-addons' ); ?></p>
				<?php endif; ?>
			</td>
		</tr>
		<tr class="<?php echo esc_attr( $row ); ?>" data-ca-service="mailchimp"<?php echo 'mailchimp' === $service ? '' : ' hidden'; ?>>
			<th scope="row"><label for="ca_form_mc_key" class="ca-form-service-title"><img src="<?php echo esc_url( cozy_addons_form_service_logo( 'mailchimp' ) ); ?>" alt="" width="20" height="20"> <?php esc_html_e( 'Mailchimp', 'cozy-addons' ); ?></label></th>
			<td>
				<?php if ( '' !== $s['mailchimp_key'] ) : ?>
					<p><span class="ca-form-connected"><?php echo esc_html( sprintf( /* translators: %s: account name */ __( 'Connected to %s', 'cozy-addons' ), $s['mailchimp_account'] ) ); ?></span></p>
				<?php endif; ?>
				<?php // The key is never printed back. A blank field keeps the saved one. ?>
				<input type="password" id="ca_form_mc_key" class="regular-text" name="ca_form_settings[mailchimp_key]" value="" autocomplete="new-password" placeholder="<?php echo '' !== $s['mailchimp_key'] ? esc_attr__( 'Saved, leave blank to keep', 'cozy-addons' ) : esc_attr__( 'API key', 'cozy-addons' ); ?>"<?php echo esc_attr( $locked ); ?>>
				<?php if ( $is_pro && '' !== $s['mailchimp_key'] ) : ?>
					<p><label><input type="checkbox" name="ca_form_settings[mailchimp_clear]" value="1"> <?php esc_html_e( 'Disconnect and remove the saved key', 'cozy-addons' ); ?></label></p>
				<?php endif; ?>
				<p class="description">
					<?php esc_html_e( 'Create a key in Mailchimp under Profile → Extras → API keys.', 'cozy-addons' ); ?>
					<a href="https://mailchimp.com/help/about-api-keys/" target="_blank" rel="noopener"><?php esc_html_e( 'How to get a key', 'cozy-addons' ); ?></a>
				</p>
				<p>
					<label for="ca_form_mc_audience"><?php esc_html_e( 'Audience ID', 'cozy-addons' ); ?></label><br>
					<input type="text" id="ca_form_mc_audience" class="regular-text code" name="ca_form_settings[mailchimp_audience]" value="<?php echo esc_attr( $s['mailchimp_audience'] ); ?>" placeholder="a1b2c3d4e5" autocomplete="off" spellcheck="false"<?php echo esc_attr( $locked ); ?>>
				</p>
				<?php if ( $is_pro && '' !== $s['mailchimp_key'] && '' === $s['mailchimp_audience'] ) : ?>
					<div class="notice notice-warning inline"><p><?php esc_html_e( 'Add the Audience ID, or contacts cannot be added to Mailchimp.', 'cozy-addons' ); ?></p></div>
				<?php endif; ?>
				<p class="description">
					<?php esc_html_e( 'Form sign-ups are added to this audience. To find it in Mailchimp, open Audience → All contacts, click the ⋯ menu next to "Add contacts" and choose Audience settings: the Audience ID is listed there.', 'cozy-addons' ); ?>
					<a href="https://mailchimp.com/help/find-audience-id/" target="_blank" rel="noopener"><?php esc_html_e( 'Find your Audience ID', 'cozy-addons' ); ?></a>
				</p>
				<?php
				// Mailchimp's own list settings, for every form that adds people to the audience.
				$mc_options = array(
					'mailchimp_double'     => array(
						__( 'Use double opt-in', 'cozy-addons' ),
						__( 'Before new subscribers are added, they\'ll need to confirm their email address.', 'cozy-addons' ),
						__( 'Recommended', 'cozy-addons' ),
					),
					'mailchimp_update'     => array(
						__( 'Update existing subscribers', 'cozy-addons' ),
						__( 'If an existing subscriber fills out a form, their information is updated with what\'s provided.', 'cozy-addons' ),
						'',
					),
					'mailchimp_unsub_link' => array(
						__( 'Include unsubscribe link', 'cozy-addons' ),
						'' !== (string) $s['mailchimp_unsub']
							? __( 'Adds a link to your audience\'s unsubscribe form below forms that add people to Mailchimp.', 'cozy-addons' )
							: __( 'Adds a link to your audience\'s unsubscribe form below forms that add people to Mailchimp. Available once the Audience ID is saved.', 'cozy-addons' ),
						'',
					),
				);
				?>
				<div class="ca-form-mc-list" role="group" aria-labelledby="ca_form_mc_list_title">
					<div class="ca-form-mc-list__head">
						<span class="dashicons dashicons-admin-settings" aria-hidden="true"></span>
						<div>
							<h3 id="ca_form_mc_list_title"><?php esc_html_e( 'List settings', 'cozy-addons' ); ?></h3>
							<p><?php esc_html_e( 'Applies to every form that adds people to Mailchimp.', 'cozy-addons' ); ?></p>
						</div>
					</div>
					<?php foreach ( $mc_options as $mc_setting => $mc_option ) : ?>
						<label class="ca-form-mc-option">
							<input type="checkbox" name="ca_form_settings[<?php echo esc_attr( $mc_setting ); ?>]" value="1" <?php checked( $s[ $mc_setting ], 1 ); ?><?php echo esc_attr( $locked ); ?>>
							<span class="ca-form-mc-option__text">
								<span class="ca-form-mc-option__title">
									<?php echo esc_html( $mc_option[0] ); ?>
									<?php if ( '' !== $mc_option[2] ) : ?>
										<span class="ca-form-mc-option__badge"><?php echo esc_html( $mc_option[2] ); ?></span>
									<?php endif; ?>
								</span>
								<span class="ca-form-mc-option__help"><?php echo esc_html( $mc_option[1] ); ?></span>
							</span>
						</label>
					<?php endforeach; ?>
					<div class="ca-form-mc-list__foot">
						<p><span class="dashicons dashicons-shield" aria-hidden="true"></span> <span><strong><?php esc_html_e( 'Consent:', 'cozy-addons' ); ?></strong> <?php esc_html_e( 'when a form has a consent checkbox (for example "Marketing Consent" or "Send me news and offers"), people are only added when they tick it.', 'cozy-addons' ); ?></span></p>
						<p><span class="dashicons dashicons-info-outline" aria-hidden="true"></span> <span><strong><?php esc_html_e( 'Note:', 'cozy-addons' ); ?></strong> <?php esc_html_e( 'If you haven\'t already, add your website URL in Mailchimp under Audience → Settings → Audience name and defaults, so people can return to your site after subscribing.', 'cozy-addons' ); ?></span></p>
					</div>
				</div>
			</td>
		</tr>
		<?php if ( cozy_addons_form_brevo_available() ) : ?>
		<tr class="<?php echo esc_attr( $row ); ?>" data-ca-service="brevo"<?php echo 'brevo' === $service ? '' : ' hidden'; ?>>
			<th scope="row"><label for="ca_form_br_key" class="ca-form-service-title"><img src="<?php echo esc_url( cozy_addons_form_service_logo( 'brevo' ) ); ?>" alt="" width="20" height="20"> <?php esc_html_e( 'Brevo', 'cozy-addons' ); ?></label></th>
			<td>
				<?php if ( '' !== $s['brevo_key'] ) : ?>
					<p><span class="ca-form-connected"><?php echo esc_html( sprintf( /* translators: %s: account name */ __( 'Connected to %s', 'cozy-addons' ), $s['brevo_account'] ) ); ?></span></p>
				<?php endif; ?>
				<input type="password" id="ca_form_br_key" class="regular-text" name="ca_form_settings[brevo_key]" value="" autocomplete="new-password" placeholder="<?php echo '' !== $s['brevo_key'] ? esc_attr__( 'Saved, leave blank to keep', 'cozy-addons' ) : esc_attr__( 'API key', 'cozy-addons' ); ?>"<?php echo esc_attr( $locked ); ?>>
				<?php if ( $is_pro && '' !== $s['brevo_key'] ) : ?>
					<p><label><input type="checkbox" name="ca_form_settings[brevo_clear]" value="1"> <?php esc_html_e( 'Disconnect and remove the saved key', 'cozy-addons' ); ?></label></p>
				<?php endif; ?>
				<p>
					<label for="ca_form_br_doi"><?php esc_html_e( 'Double opt-in template ID', 'cozy-addons' ); ?></label><br>
					<input type="number" min="0" id="ca_form_br_doi" class="small-text" name="ca_form_settings[brevo_doi_template]" value="<?php echo esc_attr( (string) $s['brevo_doi_template'] ); ?>"<?php echo esc_attr( $locked ); ?>>
				</p>
				<p>
					<label for="ca_form_br_redirect"><?php esc_html_e( 'Page after confirming', 'cozy-addons' ); ?></label><br>
					<input type="url" id="ca_form_br_redirect" class="regular-text" name="ca_form_settings[brevo_doi_redirect]" value="<?php echo esc_attr( $s['brevo_doi_redirect'] ); ?>" placeholder="<?php echo esc_attr( home_url( '/' ) ); ?>"<?php echo esc_attr( $locked ); ?>>
				</p>
				<p class="description">
					<?php esc_html_e( 'Create a key in Brevo under SMTP & API → API keys. Double opt-in needs a Brevo email template with the confirmation link (tag "optin").', 'cozy-addons' ); ?>
					<a href="https://help.brevo.com/hc/en-us/articles/209467485" target="_blank" rel="noopener"><?php esc_html_e( 'How to get a key', 'cozy-addons' ); ?></a>
				</p>
			</td>
		</tr>
		<?php endif; ?>
		<tr class="<?php echo esc_attr( $row ); ?>">
			<th scope="row"><?php esc_html_e( 'Webhooks', 'cozy-addons' ); ?><?php $pro_label(); ?></th>
			<td>
				<?php if ( $test ) : ?>
					<div class="notice inline <?php echo $test['ok'] ? 'notice-success' : 'notice-error'; ?>"><p><?php echo esc_html( sprintf( /* translators: %s: result, e.g. "Sent (HTTP 200)" */ __( 'Test: %s', 'cozy-addons' ), $test['message'] ) ); ?></p></div>
				<?php endif; ?>
				<?php
				$hooks   = array_values( (array) $s['webhooks'] );
				$hooks[] = array();
				foreach ( array_slice( $hooks, 0, Integration_Webhooks::MAX ) as $i => $hook ) :
					$id   = isset( $hook['id'] ) ? (string) $hook['id'] : '';
					$base = 'ca_form_settings[webhooks][' . $i . ']';
					?>
					<fieldset class="ca-form-webhook">
						<legend class="screen-reader-text"><?php echo esc_html( sprintf( /* translators: %d: webhook number */ __( 'Webhook %d', 'cozy-addons' ), $i + 1 ) ); ?></legend>
						<input type="hidden" name="<?php echo esc_attr( $base . '[id]' ); ?>" value="<?php echo esc_attr( $id ); ?>">
						<input type="url" class="regular-text" name="<?php echo esc_attr( $base . '[url]' ); ?>" value="<?php echo esc_attr( isset( $hook['url'] ) ? $hook['url'] : '' ); ?>" placeholder="https://hooks.zapier.com/…" aria-label="<?php esc_attr_e( 'Webhook address', 'cozy-addons' ); ?>"<?php echo esc_attr( $locked ); ?>>
						<label><input type="checkbox" name="<?php echo esc_attr( $base . '[active]' ); ?>" value="1" <?php checked( '' === $id || ! empty( $hook['active'] ) ); ?><?php echo esc_attr( $locked ); ?>> <?php esc_html_e( 'Active', 'cozy-addons' ); ?></label>
						<?php if ( '' !== $id ) : ?>
							<label><input type="checkbox" name="<?php echo esc_attr( $base . '[remove]' ); ?>" value="1"<?php echo esc_attr( $locked ); ?>> <?php esc_html_e( 'Remove', 'cozy-addons' ); ?></label>
							<?php if ( $is_pro ) : ?>
								<a class="button button-small" href="<?php echo esc_url( Form_Integrations::test_url( $id ) ); ?>"><?php esc_html_e( 'Send test', 'cozy-addons' ); ?></a>
							<?php endif; ?>
							<p class="description">
								<?php esc_html_e( 'Signing secret:', 'cozy-addons' ); ?>
								<?php if ( isset( $secrets[ $id ] ) ) : ?>
									<code class="ca-form-secret"><?php echo esc_html( $secrets[ $id ] ); ?></code>
									<strong><?php esc_html_e( 'Copy it now; it will not be shown again.', 'cozy-addons' ); ?></strong>
								<?php else : ?>
									<code>whsec_••••<?php echo esc_html( substr( (string) $hook['secret'], -4 ) ); ?></code>
									<label><input type="checkbox" name="<?php echo esc_attr( $base . '[regenerate]' ); ?>" value="1"<?php echo esc_attr( $locked ); ?>> <?php esc_html_e( 'Make a new secret', 'cozy-addons' ); ?></label>
								<?php endif; ?>
							</p>
						<?php endif; ?>
					</fieldset>
				<?php endforeach; ?>
				<p class="description"><?php esc_html_e( 'Each new entry is posted as JSON to these addresses, e.g. to Zapier, Make or n8n. Requests carry an X-Cozy-Signature header: "sha256=" followed by the HMAC-SHA256 of the body with the signing secret. Uploaded files are listed by name only.', 'cozy-addons' ); ?></p>
			</td>
		</tr>
		<?php if ( ! $is_pro ) : ?>
			<tr>
				<th scope="row"></th>
				<td><a href="https://cozythemes.com/pricing-and-plans/" target="_blank" rel="noopener"><?php esc_html_e( 'Upgrade to Pro for Mailchimp, Brevo and webhooks', 'cozy-addons' ); ?></a></td>
			</tr>
		<?php endif; ?>
		<script>
			// Shows the settings of the chosen mailing list service only.
			document.querySelectorAll( 'input[name="ca_form_settings[mailing_service]"]' ).forEach( function ( radio ) {
				radio.addEventListener( 'change', function () {
					document.querySelectorAll( '[data-ca-service]' ).forEach( function ( row ) {
						row.hidden = row.getAttribute( 'data-ca-service' ) !== radio.value;
					} );
				} );
			} );
		</script>
		<?php
	}
}
