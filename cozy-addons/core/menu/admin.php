<?php
/**
 * Mega Menu admin page (Cozy Blocks > Mega Menu): breakpoints and animations, and the overlay and blur
 * defaults (Pro).
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const COZY_ADDONS_MENU_PAGE = 'ca-menu-settings';

add_action( 'admin_menu', 'cozy_addons_menu_admin_menu', 20 );
add_action( 'admin_init', 'cozy_addons_menu_register_setting' );

/**
 * Adds Mega Menu under the Cozy Blocks menu.
 *
 * @return void
 */
function cozy_addons_menu_admin_menu() {
	if ( '0' === get_option( 'cozy-block--mega-menu' ) ) {
		return;
	}
	add_submenu_page(
		'_cozy_companions',
		__( 'Advanced Mega Menu', 'cozy-addons' ),
		__( 'Mega Menu', 'cozy-addons' ),
		'manage_options',
		COZY_ADDONS_MENU_PAGE,
		'cozy_addons_menu_settings_page'
	);
}

/**
 * Registers the option.
 *
 * @return void
 */
function cozy_addons_menu_register_setting() {
	register_setting(
		'ca_menu_settings_group',
		'ca_menu_settings',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'cozy_addons_menu_sanitize_settings',
			'default'           => cozy_addons_menu_defaults(),
		)
	);
}

/**
 * Sanitizes the settings. On free sites the overlay values are kept as they were.
 *
 * @param mixed $input Submitted values.
 * @return array
 */
function cozy_addons_menu_sanitize_settings( $input ) {
	$input  = is_array( $input ) ? $input : array();
	$tablet = isset( $input['tablet'] ) ? (int) $input['tablet'] : 1024;
	$mobile = isset( $input['mobile'] ) ? (int) $input['mobile'] : 767;
	$tablet = max( 600, min( 1600, $tablet ) );
	$mobile = max( 320, min( $tablet - 1, $mobile ) );
	$out    = array(
		'tablet'     => $tablet,
		'mobile'     => $mobile,
		'animations' => empty( $input['animations'] ) ? 0 : 1,
	);

	if ( ! cozy_addons_menu_is_pro() ) {
		foreach ( array( 'overlay', 'overlay_color', 'overlay_opacity', 'overlay_blur', 'overlay_duration' ) as $key ) {
			$out[ $key ] = cozy_addons_menu_option( $key );
		}
		return $out;
	}

	$color = isset( $input['overlay_color'] ) ? trim( (string) $input['overlay_color'] ) : '';
	if ( ! preg_match( '/^#(?:[0-9a-f]{3}|[0-9a-f]{6})$/i', $color ) ) {
		$color = cozy_addons_menu_defaults()['overlay_color'];
	}
	return $out + array(
		'overlay'          => empty( $input['overlay'] ) ? 0 : 1,
		'overlay_color'    => $color,
		'overlay_opacity'  => cozy_addons_menu_clamp_int( isset( $input['overlay_opacity'] ) ? $input['overlay_opacity'] : '', 0, 90, 50 ),
		'overlay_blur'     => cozy_addons_menu_clamp_int( isset( $input['overlay_blur'] ) ? $input['overlay_blur'] : '', 0, 24, 3 ),
		'overlay_duration' => cozy_addons_menu_clamp_int( isset( $input['overlay_duration'] ) ? $input['overlay_duration'] : '', 0, 1000, 250 ),
	);
}

/**
 * Prints the "PRO" label.
 *
 * @return void
 */
function cozy_addons_menu_pro_label() {
	echo '<span style="display:inline-block;margin-left:6px;padding:1px 6px;border-radius:4px;background:#5253f9;color:#fff;font-size:10px;font-weight:600;line-height:1.6;vertical-align:middle">' . esc_html__( 'PRO', 'cozy-addons' ) . '</span>';
}

/**
 * Upgrade notice for free sites.
 *
 * @param string $text What the feature does.
 * @return void
 */
function cozy_addons_menu_upsell( $text ) {
	printf(
		'<div class="notice notice-info inline"><p>%1$s</p><p><a class="button button-primary" href="%2$s" target="_blank" rel="noopener">%3$s</a></p></div>',
		esc_html( $text ),
		esc_url( 'https://cozythemes.com/pricing-and-plans/' ),
		esc_html__( 'Upgrade to Pro', 'cozy-addons' )
	);
}

/**
 * Renders the page.
 *
 * @return void
 */
function cozy_addons_menu_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Advanced Mega Menu', 'cozy-addons' ); ?></h1>
		<?php cozy_addons_menu_settings_tab(); ?>
	</div>
	<?php
}

/**
 * Settings tab.
 *
 * @return void
 */
function cozy_addons_menu_settings_tab() {
	$opts = array();
	foreach ( array_keys( cozy_addons_menu_defaults() ) as $key ) {
		$opts[ $key ] = cozy_addons_menu_option( $key );
	}
	$pro = cozy_addons_menu_is_pro();
	?>
	<form method="post" action="options.php">
		<?php settings_fields( 'ca_menu_settings_group' ); ?>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="ca-menu-tablet"><?php esc_html_e( 'Tablet breakpoint (px)', 'cozy-addons' ); ?></label></th>
				<td><input id="ca-menu-tablet" name="ca_menu_settings[tablet]" type="number" min="600" max="1600" value="<?php echo (int) $opts['tablet']; ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="ca-menu-mobile"><?php esc_html_e( 'Mobile breakpoint (px)', 'cozy-addons' ); ?></label></th>
				<td><input id="ca-menu-mobile" name="ca_menu_settings[mobile]" type="number" min="320" max="1599" value="<?php echo (int) $opts['mobile']; ?>">
				<p class="description"><?php esc_html_e( 'Used by the per-device controls (tablet and mobile overrides). Below 900px every menu collapses behind a menu button into a drawer.', 'cozy-addons' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Animations', 'cozy-addons' ); ?></th>
				<td><label><input name="ca_menu_settings[animations]" type="checkbox" value="1" <?php checked( $opts['animations'], 1 ); ?>> <?php esc_html_e( 'Open and close animations', 'cozy-addons' ); ?></label></td>
			</tr>
		</table>

		<h2>
			<?php esc_html_e( 'Page overlay (defaults)', 'cozy-addons' ); ?>
			<?php if ( ! $pro ) : ?>
				<?php cozy_addons_menu_pro_label(); ?>
			<?php endif; ?>
		</h2>
		<p class="description"><?php esc_html_e( 'Dims and blurs the page behind an open mega menu. Each menu can override these in its block settings. Off-canvas backdrops use the same defaults.', 'cozy-addons' ); ?></p>
		<?php
		if ( ! $pro ) {
			cozy_addons_menu_upsell( __( 'The overlay and blur behind mega menus is a Pro feature.', 'cozy-addons' ) );
		}
		?>
		<fieldset <?php disabled( ! $pro ); ?>>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Overlay', 'cozy-addons' ); ?></th>
					<td><label><input name="ca_menu_settings[overlay]" type="checkbox" value="1" <?php checked( $opts['overlay'], 1 ); ?>> <?php esc_html_e( 'Dim the page behind mega menus', 'cozy-addons' ); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><label for="ca-menu-ov-color"><?php esc_html_e( 'Overlay color', 'cozy-addons' ); ?></label></th>
					<td><input id="ca-menu-ov-color" name="ca_menu_settings[overlay_color]" type="color" value="<?php echo esc_attr( $opts['overlay_color'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="ca-menu-ov-opacity"><?php esc_html_e( 'Opacity (%)', 'cozy-addons' ); ?></label></th>
					<td><input id="ca-menu-ov-opacity" name="ca_menu_settings[overlay_opacity]" type="number" min="0" max="90" value="<?php echo (int) $opts['overlay_opacity']; ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="ca-menu-ov-blur"><?php esc_html_e( 'Blur (px)', 'cozy-addons' ); ?></label></th>
					<td><input id="ca-menu-ov-blur" name="ca_menu_settings[overlay_blur]" type="number" min="0" max="24" value="<?php echo (int) $opts['overlay_blur']; ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="ca-menu-ov-dur"><?php esc_html_e( 'Transition (ms)', 'cozy-addons' ); ?></label></th>
					<td><input id="ca-menu-ov-dur" name="ca_menu_settings[overlay_duration]" type="number" min="0" max="1000" step="50" value="<?php echo (int) $opts['overlay_duration']; ?>"></td>
				</tr>
			</table>
		</fieldset>
		<?php submit_button(); ?>
	</form>
	<?php
}
