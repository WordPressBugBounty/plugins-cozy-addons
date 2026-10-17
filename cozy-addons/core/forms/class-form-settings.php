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
				'keys'  => array( 'notify_emails', 'autoreply_enabled', 'autoreply_subject', 'autoreply_message', 'urgent_categories', 'overdue_hours' ),
			),
			'spam'         => array(
				'label' => __( 'Spam protection', 'cozy-addons' ),
				'keys'  => array( 'captcha_default', 'recaptcha_version', 'recaptcha_site_key', 'recaptcha_secret_key', 'recaptcha_threshold', 'turnstile_site_key', 'turnstile_secret_key', 'akismet', 'ip_source' ),
			),
			'integrations' => array(
				'label' => __( 'Integrations', 'cozy-addons' ),
				'keys'  => array(),
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
				case 'notify_emails':
					$clean[ $key ] = implode( ', ', cozy_addons_form_parse_emails( isset( $input[ $key ] ) ? $input[ $key ] : '' ) );
					break;

				case 'autoreply_enabled':
				case 'akismet':
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

			<?php
			if ( 'integrations' === $tab ) {
				self::render_integrations();
				echo '</div>';
				return;
			}
			?>
			<form method="post" action="options.php">
				<?php settings_fields( self::GROUP ); ?>
				<input type="hidden" name="ca_form_settings[_tab]" value="<?php echo esc_attr( $tab ); ?>">
				<table class="form-table" role="presentation">
					<?php
					if ( 'general' === $tab ) {
						self::render_general();
					} elseif ( 'spam' === $tab ) {
						self::render_spam();
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
			<td><p class="description"><?php esc_html_e( 'Every form already has a hidden honeypot field, a minimum fill time and a per-visitor rate limit. Add a check below for stronger protection. Each Form block can choose its own check, and turn Akismet on or off, in its sidebar under Spam protection.', 'cozy-addons' ); ?></p></td>
		</tr>
		<tr class="<?php echo $is_pro ? '' : 'ca-form-is-locked'; ?>">
			<th scope="row">
				<?php esc_html_e( 'Default check', 'cozy-addons' ); ?>
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
					<legend class="screen-reader-text"><?php esc_html_e( 'Default check', 'cozy-addons' ); ?></legend>
					<?php foreach ( $choices as $value => $choice ) : ?>
						<label><input type="radio" name="ca_form_settings[captcha_default]" value="<?php echo esc_attr( $value ); ?>" <?php checked( $default_choice, $value ); ?><?php echo esc_attr( $locked ); ?>> <?php echo esc_html( $choice[0] ); ?><?php echo $choice[1] ? '' : ' <span class="description">' . esc_html__( '(add keys below)', 'cozy-addons' ) . '</span>'; ?></label><br>
					<?php endforeach; ?>
				</fieldset>
				<p class="description"><?php esc_html_e( 'Used by forms set to "Site default". A check without keys falls back to the honeypot.', 'cozy-addons' ); ?></p>
			</td>
		</tr>
		<tr class="<?php echo $is_pro ? '' : 'ca-form-is-locked'; ?>">
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
		<tr class="<?php echo $is_pro ? '' : 'ca-form-is-locked'; ?>">
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
	 * Integrations tab: services planned for later. Nothing to save yet.
	 *
	 * @return void
	 */
	private static function render_integrations() {
		$cards = array(
			array(
				'title' => __( 'Mailchimp', 'cozy-addons' ),
				'text'  => __( 'Add newsletter sign-ups to a Mailchimp audience automatically.', 'cozy-addons' ),
			),
			array(
				'title' => __( 'Webhooks', 'cozy-addons' ),
				'text'  => __( 'Send each new entry to Zapier, Make, n8n or your own app.', 'cozy-addons' ),
			),
		);
		echo '<p>' . esc_html__( 'Connect your forms to other services. Spam protection services are set up on the Spam protection tab.', 'cozy-addons' ) . '</p>';
		echo '<div class="ca-leads-integrations">';
		foreach ( $cards as $card ) {
			echo '<div class="ca-leads-integration"><h2>' . esc_html( $card['title'] ) . ' <span class="ca-leads-soon">' . esc_html__( 'Coming soon', 'cozy-addons' ) . '</span></h2><p>' . esc_html( $card['text'] ) . '</p></div>';
		}
		echo '</div>';
	}
}
