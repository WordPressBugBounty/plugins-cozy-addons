<?php
/**
 * SMTP plugins for form emails: detection, and installing or activating one from Lead Forms.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Works with the popular SMTP plugins instead of WordPress's default mailer.
 *
 * SMTP plugins take over wp_mail(), which Lead Forms sends through, so once one is active form
 * emails use its mail service and authentication. Lead Forms then leaves the sender to it.
 * Only the sender address and the kind of mailer are read from these plugins, never passwords
 * or API keys.
 */
final class Form_Mailer {

	/**
	 * Plugins Lead Forms can install, activate and hand form emails to.
	 *
	 * @return array<string,array{name:string,file:string,settings:string,description:string}> Keyed by wordpress.org slug.
	 */
	public static function plugins() {
		/**
		 * Filters the SMTP plugins offered under Lead Forms → Settings → General.
		 *
		 * @param array $plugins Keyed by wordpress.org slug: name, file (main plugin file), settings (admin path), description.
		 */
		return apply_filters(
			'cozy_addons_form_smtp_plugins',
			array(
				'wp-mail-smtp' => array(
					'name'        => 'WP Mail SMTP',
					'file'        => 'wp-mail-smtp/wp_mail_smtp.php',
					'settings'    => 'admin.php?page=wp-mail-smtp',
					'description' => __( 'The most used SMTP plugin. Guided setup for Gmail, Microsoft, SendGrid, Brevo, Mailgun, Amazon SES and more.', 'cozy-addons' ),
				),
				'fluent-smtp'  => array(
					'name'        => 'FluentSMTP',
					'file'        => 'fluent-smtp/fluent-smtp.php',
					'settings'    => 'options-general.php?page=fluent-mail',
					'description' => __( 'Free and open source, with all mail services included and an email log.', 'cozy-addons' ),
				),
			)
		);
	}

	/**
	 * Installed and active state of each supported plugin.
	 *
	 * @return array<string,array{installed:bool,active:bool}> Keyed by slug.
	 */
	public static function state() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$installed = get_plugins();
		$state     = array();
		foreach ( self::plugins() as $slug => $plugin ) {
			$state[ $slug ] = array(
				'installed' => isset( $installed[ $plugin['file'] ] ),
				'active'    => self::is_active( $plugin['file'] ),
			);
		}

		return $state;
	}

	/**
	 * Whether a plugin is active on this site or the network.
	 *
	 * @param string $file Main plugin file.
	 * @return bool
	 */
	private static function is_active( $file ) {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return is_plugin_active( $file ) || ( is_multisite() && is_plugin_active_for_network( $file ) );
	}

	/**
	 * The active SMTP plugin, if any: the one form emails are sent through. With several active,
	 * the one that took over WordPress's mail sending, since only that one sends.
	 *
	 * @return array{slug:string,name:string,settings_url:string,from_email:string,mailer:string,connection:string,configured:bool,setup:array}|array Empty when none is active.
	 */
	public static function active() {
		$plugins = self::plugins();
		$active  = array();
		foreach ( $plugins as $slug => $plugin ) {
			if ( self::is_active( $plugin['file'] ) ) {
				$active[] = $slug;
			}
		}
		if ( ! $active ) {
			return array();
		}

		$slug = $active[0];
		foreach ( self::handler_files() as $file ) {
			$owner = self::owner_of( $file );
			if ( in_array( $owner, $active, true ) ) {
				$slug = $owner;
				break;
			}
		}
		$setup = self::read_setup( $slug );

		return array(
			'slug'         => $slug,
			'name'         => $plugins[ $slug ]['name'],
			'settings_url' => admin_url( $plugins[ $slug ]['settings'] ),
			'from_email'   => $setup['from_email'],
			'mailer'       => self::mailer_label( $setup['mailer'] ),
			'connection'   => $setup['connection'],
			'configured'   => $setup['configured'],
			'setup'        => $setup,
		);
	}

	/**
	 * Names of every active mail plugin. More than one means they can get in each other's way.
	 *
	 * @return string[]
	 */
	public static function active_mail_plugins() {
		$names = array();
		foreach ( self::plugins() as $slug => $plugin ) {
			if ( self::is_active( $plugin['file'] ) ) {
				$names[ $slug ] = $plugin['name'];
			}
		}
		foreach ( self::handler_files() as $file ) {
			if ( '' === self::owner_of( $file ) ) {
				// Keyed by plugin folder, so one plugin is not counted twice.
				$base           = wp_normalize_path( trailingslashit( WP_PLUGIN_DIR ) );
				$path           = wp_normalize_path( $file );
				$key            = 0 === strpos( $path, $base ) ? strtok( substr( $path, strlen( $base ) ), '/' ) : $path;
				$names[ $key ]  = self::plugin_name( $file );
			}
		}

		return array_values( array_unique( $names ) );
	}

	/**
	 * A warning when several mail plugins are active, naming the one that sends.
	 *
	 * @return string Empty when there is at most one.
	 */
	public static function conflict_message() {
		$names = self::active_mail_plugins();
		if ( count( $names ) < 2 ) {
			return '';
		}
		$current = self::current();
		$sender  = ! empty( $current['name'] ) ? $current['name'] : $names[0];

		/* translators: 1: list of plugin names, e.g. "WP Mail SMTP and FluentSMTP", 2: the plugin that sends */
		return sprintf( __( '%1$s are active at the same time. Only %2$s sends form emails, and the others can get in its way. Keep one and deactivate the others.', 'cozy-addons' ), wp_sprintf( '%l', $names ), $sender );
	}

	/**
	 * The plugin form emails are sent through: one of the supported SMTP plugins, or any other
	 * plugin that took over WordPress's mail sending.
	 *
	 * @return array Same keys as active(), plus "generic" for a plugin that is not one of the supported ones. Empty for WordPress's own mailer.
	 */
	public static function current() {
		$active = self::active();

		return $active ? $active : self::takeover();
	}

	/**
	 * Any other plugin that took over WordPress's mail sending, so Lead Forms leaves the sender to it.
	 *
	 * Mail plugins do this in one of three ways: their own pluggable wp_mail(), their own PHPMailer
	 * in place of WordPress's, or a "pre_wp_mail" filter that sends the email itself. Only where the
	 * code lives is looked at; nothing from the plugin is run or read.
	 *
	 * @return array{slug:string,name:string,settings_url:string,from_email:string,mailer:string,configured:bool,generic:bool}|array Empty when WordPress sends the mail itself.
	 */
	public static function takeover() {
		$files = self::handler_files();
		if ( ! $files ) {
			return array();
		}

		return array(
			'slug'         => '',
			'name'         => self::plugin_name( $files[0] ),
			'settings_url' => '',
			'from_email'   => '',
			'mailer'       => '',
			'connection'   => '',
			'configured'   => true,
			'generic'      => true,
		);
	}

	/**
	 * Files of the code that took over WordPress's mail sending, the one that sends first.
	 *
	 * @return string[] Absolute paths. Empty when WordPress sends the mail itself.
	 */
	private static function handler_files() {
		$files = array();

		// 1. Its own wp_mail().
		if ( function_exists( 'wp_mail' ) ) {
			$file = ( new \ReflectionFunction( 'wp_mail' ) )->getFileName();
			if ( is_string( $file ) && ! self::is_core( $file ) ) {
				$files[] = $file;
			}
		}

		// 2. Its own PHPMailer in place of WordPress's.
		global $phpmailer;
		if ( is_object( $phpmailer ) && ! in_array( get_class( $phpmailer ), array( 'PHPMailer\\PHPMailer\\PHPMailer', 'WP_PHPMailer' ), true ) ) {
			$file = ( new \ReflectionClass( $phpmailer ) )->getFileName();
			if ( is_string( $file ) && ! self::is_core( $file ) ) {
				$files[] = $file;
			}
		}

		// 3. A filter that sends the email before WordPress does.
		global $wp_filter;
		if ( isset( $wp_filter['pre_wp_mail'] ) ) {
			foreach ( $wp_filter['pre_wp_mail']->callbacks as $callbacks ) {
				foreach ( $callbacks as $callback ) {
					$file = self::callback_file( $callback['function'] );
					if ( '' !== $file && ! self::is_core( $file ) ) {
						$files[] = $file;
					}
				}
			}
		}

		return array_values( array_unique( $files ) );
	}

	/**
	 * Supported SMTP plugin a file belongs to.
	 *
	 * @param string $file Absolute path.
	 * @return string Its slug, or '' for any other file.
	 */
	private static function owner_of( $file ) {
		$file = wp_normalize_path( $file );
		foreach ( self::plugins() as $slug => $plugin ) {
			if ( 0 === strpos( $file, wp_normalize_path( trailingslashit( WP_PLUGIN_DIR . '/' . dirname( $plugin['file'] ) ) ) ) ) {
				return $slug;
			}
		}

		return '';
	}

	/**
	 * Whether a file belongs to WordPress itself or to Cozy Blocks.
	 *
	 * @param string $file Absolute path.
	 * @return bool
	 */
	private static function is_core( $file ) {
		$file = wp_normalize_path( $file );
		foreach ( array( ABSPATH . WPINC, ABSPATH . 'wp-admin', COZY_ADDONS_PLUGIN_DIR ) as $dir ) {
			if ( 0 === strpos( $file, wp_normalize_path( trailingslashit( $dir ) ) ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * File a filter callback is defined in.
	 *
	 * @param mixed $callback Callback.
	 * @return string Empty when it cannot be told.
	 */
	private static function callback_file( $callback ) {
		try {
			if ( is_string( $callback ) && function_exists( $callback ) ) {
				return (string) ( new \ReflectionFunction( $callback ) )->getFileName();
			}
			if ( $callback instanceof \Closure ) {
				return (string) ( new \ReflectionFunction( $callback ) )->getFileName();
			}
			if ( is_array( $callback ) && 2 === count( $callback ) && method_exists( $callback[0], $callback[1] ) ) {
				return (string) ( new \ReflectionMethod( $callback[0], $callback[1] ) )->getFileName();
			}
		} catch ( \ReflectionException $e ) {
			return '';
		}

		return '';
	}

	/**
	 * Name of the plugin a file belongs to.
	 *
	 * @param string $file Absolute path.
	 * @return string Plugin name, or a general description.
	 */
	private static function plugin_name( $file ) {
		$file = wp_normalize_path( $file );
		if ( 0 === strpos( $file, wp_normalize_path( trailingslashit( WPMU_PLUGIN_DIR ) ) ) ) {
			return __( 'a must-use plugin', 'cozy-addons' );
		}
		$base = wp_normalize_path( trailingslashit( WP_PLUGIN_DIR ) );
		if ( 0 === strpos( $file, $base ) ) {
			$folder = strtok( substr( $file, strlen( $base ) ), '/' );
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			foreach ( get_plugins() as $plugin_file => $data ) {
				if ( 0 === strpos( $plugin_file, $folder . '/' ) || $plugin_file === $folder ) {
					return wp_strip_all_tags( $data['Name'] );
				}
			}
		}

		return __( 'another mail plugin', 'cozy-addons' );
	}

	/**
	 * The setup selected in the plugin's own settings: mailer, sender and whether it can send.
	 * Passwords, API keys and tokens stored alongside are never read out; tokens are only
	 * checked for being present.
	 *
	 * @param string $slug Plugin slug.
	 * @return array{mailer:string,connection:string,from_email:string,from_name:string,force_email:bool,force_name:bool,configured:bool,senders:string[]}
	 */
	private static function read_setup( $slug ) {
		$setup = array(
			'mailer'      => 'mail',
			'connection'  => '',
			'from_email'  => '',
			'from_name'   => '',
			'force_email' => false,
			'force_name'  => false,
			'configured'  => false,
			'senders'     => array(),
		);

		switch ( $slug ) {
			case 'wp-mail-smtp':
				$options = get_option( 'wp_mail_smtp' );
				$options = is_array( $options ) ? $options : array();
				$mail    = isset( $options['mail'] ) && is_array( $options['mail'] ) ? $options['mail'] : array();
				$mailer  = sanitize_key( isset( $mail['mailer'] ) ? (string) $mail['mailer'] : 'mail' );

				$setup['mailer']      = '' !== $mailer ? $mailer : 'mail';
				$setup['from_email']  = isset( $mail['from_email'] ) ? (string) $mail['from_email'] : '';
				$setup['from_name']   = isset( $mail['from_name'] ) ? (string) $mail['from_name'] : '';
				$setup['force_email'] = ! empty( $mail['from_email_force'] );
				$setup['force_name']  = ! empty( $mail['from_name_force'] );
				$setup['configured']  = 'mail' !== $setup['mailer'];

				// Mailbox sign-in mailers only send once the account was connected, and only as it.
				if ( in_array( $setup['mailer'], array( 'gmail', 'outlook', 'zoho' ), true ) ) {
					$auth                 = isset( $options[ $setup['mailer'] ] ) && is_array( $options[ $setup['mailer'] ] ) ? $options[ $setup['mailer'] ] : array();
					$setup['configured']  = ! empty( $auth['refresh_token'] ) || ! empty( $auth['access_token'] );
					$setup['force_email'] = true;
					if ( ! empty( $auth['user_details']['email'] ) ) {
						$setup['from_email'] = (string) $auth['user_details']['email'];
					}
				}
				break;

			case 'fluent-smtp':
				$options     = get_option( 'fluentmail-settings' );
				$options     = is_array( $options ) ? $options : array();
				$connections = isset( $options['connections'] ) && is_array( $options['connections'] ) ? $options['connections'] : array();
				$default     = isset( $options['misc']['default_connection'] ) ? (string) $options['misc']['default_connection'] : '';
				$key         = isset( $connections[ $default ] ) ? $default : (string) key( $connections );
				$settings    = isset( $connections[ $key ]['provider_settings'] ) && is_array( $connections[ $key ]['provider_settings'] ) ? $connections[ $key ]['provider_settings'] : array();

				// FluentSMTP picks the connection by From address, so every connection's sender counts.
				foreach ( $connections as $connection ) {
					if ( ! empty( $connection['provider_settings']['sender_email'] ) ) {
						$setup['senders'][] = strtolower( (string) $connection['provider_settings']['sender_email'] );
					}
				}
				$setup['mailer']      = sanitize_key( isset( $settings['provider'] ) ? (string) $settings['provider'] : 'mail' );
				$setup['connection']  = isset( $connections[ $key ]['title'] ) ? (string) $connections[ $key ]['title'] : '';
				$setup['from_email']  = isset( $settings['sender_email'] ) ? (string) $settings['sender_email'] : '';
				$setup['from_name']   = isset( $settings['sender_name'] ) ? (string) $settings['sender_name'] : '';
				$setup['force_email'] = isset( $settings['force_from_email'] ) && 'no' !== $settings['force_from_email'];
				$setup['force_name']  = isset( $settings['force_from_name'] ) && 'no' !== $settings['force_from_name'];
				$setup['configured']  = (bool) $connections && ! in_array( $setup['mailer'], array( '', 'default', 'mail', 'php' ), true );
				break;
		}

		$setup['from_email'] = is_email( $setup['from_email'] ) ? sanitize_email( $setup['from_email'] ) : '';
		$setup['from_name']  = mb_substr( sanitize_text_field( $setup['from_name'] ), 0, 100 );
		$setup['connection'] = mb_substr( sanitize_text_field( $setup['connection'] ), 0, 100 );
		$setup['senders']    = array_values( array_unique( array_filter( array_map( 'sanitize_email', $setup['senders'] ), 'is_email' ) ) );

		return $setup;
	}

	/**
	 * How Lead Forms sends its emails right now, from the selected setup of the active mail plugin.
	 *
	 * - "plugin": a configured SMTP plugin sends. Lead Forms passes the From address the plugin can
	 *   send as (its own sender, or the Lead Forms sender when the plugin accepts it), so the right
	 *   connection is used and SPF/DKIM line up. The envelope sender is left to the plugin.
	 * - "external": another mail plugin sends; nothing is changed.
	 * - "wordpress": WordPress's mailer, also used while a known SMTP plugin is not set up yet,
	 *   with the sender from Lead Forms → Settings → General.
	 *
	 * @return array{mode:string,from_email:string,from_name:string,return_path:bool}
	 */
	public static function profile() {
		$settings = cozy_addons_form_settings();
		$own      = is_email( $settings['from_email'] ) ? strtolower( (string) $settings['from_email'] ) : '';
		$own_name = (string) $settings['from_name'];
		$current  = self::current();

		if ( ! empty( $current['generic'] ) ) {
			return array(
				'mode'        => 'external',
				'from_email'  => '',
				'from_name'   => '',
				'return_path' => false,
			);
		}

		if ( $current && $current['configured'] ) {
			$setup = $current['setup'];
			if ( 'fluent-smtp' === $current['slug'] ) {
				$can_send_as = in_array( $own, $setup['senders'], true );
			} else {
				$can_send_as = ! $setup['force_email'];
			}

			return array(
				'mode'        => 'plugin',
				'from_email'  => '' !== $own && $can_send_as ? $own : $setup['from_email'],
				'from_name'   => '' !== $own_name && ! $setup['force_name'] ? $own_name : $setup['from_name'],
				'return_path' => false,
			);
		}

		return array(
			'mode'        => 'wordpress',
			'from_email'  => $own,
			'from_name'   => $own_name,
			'return_path' => '' !== $own && ! empty( $settings['return_path'] ),
		);
	}


	/**
	 * Readable name of a mailer key, e.g. "sendgrid" → "SendGrid".
	 *
	 * @param string $mailer Mailer key.
	 * @return string
	 */
	private static function mailer_label( $mailer ) {
		$labels = array(
			'mail'        => __( 'PHP mail', 'cozy-addons' ),
			'default'     => __( 'PHP mail', 'cozy-addons' ),
			'php'         => __( 'PHP mail', 'cozy-addons' ),
			'smtp'        => __( 'SMTP', 'cozy-addons' ),
			'gmail'       => 'Google / Gmail',
			'outlook'     => 'Microsoft 365 / Outlook',
			'sendgrid'    => 'SendGrid',
			'mailgun'     => 'Mailgun',
			'amazonses'   => 'Amazon SES',
			'ses'         => 'Amazon SES',
			'sendinblue'  => 'Brevo',
			'brevo'       => 'Brevo',
			'postmark'    => 'Postmark',
			'sparkpost'   => 'SparkPost',
			'smtpcom'     => 'SMTP.com',
			'sendlayer'   => 'SendLayer',
			'zoho'        => 'Zoho Mail',
			'elasticmail' => 'Elastic Email',
			'smtp2go'     => 'SMTP2GO',
			'resend'      => 'Resend',
			'mailjet'     => 'Mailjet',
			'pepipost'    => 'Netcore',
		);

		return isset( $labels[ $mailer ] ) ? $labels[ $mailer ] : ucwords( str_replace( array( '_', '-' ), ' ', $mailer ) );
	}

	/**
	 * wordpress.org icon of a plugin, cached for a week. Empty when it cannot be fetched.
	 *
	 * @param string $slug Plugin slug.
	 * @return string URL.
	 */
	public static function icon( $slug ) {
		$icons = get_transient( 'ca_form_smtp_icons' );
		if ( ! is_array( $icons ) ) {
			$icons = array();
			if ( ! function_exists( 'plugins_api' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			}
			foreach ( array_keys( self::plugins() ) as $plugin ) {
				$info             = plugins_api(
					'plugin_information',
					array(
						'slug'   => $plugin,
						'fields' => array(
							'icons'       => true,
							'sections'    => false,
							'description' => false,
						),
					)
				);
				$set              = ! is_wp_error( $info ) && isset( $info->icons ) ? (array) $info->icons : array();
				$icons[ $plugin ] = esc_url_raw( $set['svg'] ?? ( $set['2x'] ?? ( $set['1x'] ?? ( $set['default'] ?? '' ) ) ) );
			}
			set_transient( 'ca_form_smtp_icons', $icons, WEEK_IN_SECONDS );
		}

		return isset( $icons[ $slug ] ) ? (string) $icons[ $slug ] : '';
	}

	/**
	 * Whether this user may install plugins here.
	 *
	 * @return bool
	 */
	public static function can_install() {
		return current_user_can( 'install_plugins' ) && ! ( defined( 'DISALLOW_FILE_MODS' ) && DISALLOW_FILE_MODS ) && ( ! is_multisite() || is_super_admin() );
	}

	/**
	 * Link that activates an installed SMTP plugin from Lead Forms.
	 *
	 * @param string $slug Plugin slug.
	 * @return string
	 */
	public static function activate_url( $slug ) {
		return wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'ca_form_activate_smtp',
					'plugin' => $slug,
				),
				admin_url( 'admin-post.php' )
			),
			'ca_form_activate_smtp_' . $slug
		);
	}

	/**
	 * Activates one of the supported SMTP plugins, then returns to Lead Forms → Settings.
	 *
	 * @return void
	 */
	public static function activate() {
		$slug = isset( $_GET['plugin'] ) ? sanitize_key( wp_unslash( $_GET['plugin'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Verified below.
		check_admin_referer( 'ca_form_activate_smtp_' . $slug );
		$plugins = self::plugins();
		if ( ! isset( $plugins[ $slug ] ) || ! current_user_can( 'activate_plugins' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to do that.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		if ( ! function_exists( 'activate_plugin' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$result = activate_plugin( $plugins[ $slug ]['file'] );
		if ( is_wp_error( $result ) ) {
			$notice = array(
				'ok'      => false,
				/* translators: 1: plugin name, 2: error message */
				'message' => sprintf( __( '%1$s could not be activated: %2$s', 'cozy-addons' ), $plugins[ $slug ]['name'], $result->get_error_message() ),
			);
		} else {
			// Two SMTP plugins fight over sending, so switching to one turns the others off.
			$others = array();
			foreach ( $plugins as $other => $plugin ) {
				if ( $other !== $slug && is_plugin_active( $plugin['file'] ) && ! is_plugin_active_for_network( $plugin['file'] ) ) {
					$others[ $plugin['file'] ] = $plugin['name'];
				}
			}
			if ( $others ) {
				deactivate_plugins( array_keys( $others ), false, false );
			}
			$notice = array(
				'ok'      => true,
				'message' => $others
					/* translators: 1: plugin name, 2: names of the plugins that were turned off */
					? sprintf( __( '%1$s is active. %2$s was deactivated so only one plugin sends your email. Set up your mail service in its settings to send authenticated email.', 'cozy-addons' ), $plugins[ $slug ]['name'], wp_sprintf( '%l', array_values( $others ) ) )
					/* translators: %s: plugin name */
					: sprintf( __( '%s is active. Set up your mail service in its settings to send authenticated email.', 'cozy-addons' ), $plugins[ $slug ]['name'] ),
			);
		}
		set_transient( 'ca_form_smtp_notice_' . get_current_user_id(), $notice, MINUTE_IN_SECONDS );
		wp_safe_redirect( cozy_addons_form_admin_url( Form_Settings::PAGE, array( 'tab' => 'general' ) ) );
		exit;
	}
}
