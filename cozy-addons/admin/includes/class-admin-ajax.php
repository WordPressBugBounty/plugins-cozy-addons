<?php
namespace CozyAddons\Admin;

class Ajax {
	/**
	 * Singleton instance of this class.
	 *
	 * @var self|null
	 */
	private static $instance = null;

	private static $premium_blocks = array(
		'cf7-styler',
		'countdown-timer',
		'img-compare',
		'modal',
		'scroll-animation',
		'toggle-content',
		'toggle-content',
		'featured-product',
		'featured-product-tabs',
		'product-slider',
		'product-tab',
		'quick-view',
		'wishlist',
		'advanced-categories',
		'categorized-post-tabs',
		'featured-post',
		'featured-post-tabs',
		'magazine-grid',
		'magazine-list',
		'news-ticker',
		'popular-post',
		'post-comments',
		'post-slider',
		'post-views',
		'related-post',
		'trending-post',
	);

	/**
	 * Retrieve the singleton instance of this class.
	 *
	 * Creates the instance on first call and reuses it on all subsequent
	 * calls, ensuring only one instance of this class exists during the
	 * request lifecycle.
	 *
	 * @return self The single instance of this class.
	 */
	public static function get_instance() {
		// Instantiate only if it hasn't been created yet.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * Registers all AJAX action hooks used by this class for handling
	 * admin-side toggles and dismissible notices within the Cozy Addons
	 * plugin. Private to enforce the singleton pattern via get_instance().
	 */
	private function __construct() {
		add_action( 'wp_ajax_cozy_addons_update_block_active_status', array( $this, 'update_block_status' ) );
		add_action( 'wp_ajax_cozy_addons_block_status_change_bulk', array( $this, 'blocks_bulk_update_status' ) );
		add_action( 'wp_ajax_cozy_blocks_dismissble_notice', array( $this, 'dismiss_block_theme_notice' ) );
		add_action( 'wp_ajax_cozy_addons_dismiss_welcome_notice', array( $this, 'dismiss_welcome_notice' ) );
		add_action( 'wp_ajax_cozy_addons_toggle_ca_utility_function_status', array( $this, 'update_utility_function_status' ) );
		add_action( 'wp_ajax_cozy_addons_update_cpt_enabled_option', array( $this, 'update_cpt_active_status' ) );
		add_action( 'wp_ajax_cozy_addons_update_cpt_args', array( $this, 'update_cpt_args' ) );
		add_action( 'wp_ajax_cozy_addons_download_plugin_rollback_version', array( $this, 'download_plugin_rollback_versions' ) );
		add_action( 'wp_ajax_cozy_addons_activate_rollback_version', array( $this, 'activate_rollback_version' ) );
		add_action( 'wp_ajax_cozy_addons_install_activate_plugin', array( $this, 'install_activate_plugin' ) );
	}

	private function is_plugin_installed( $plugin_slug ) {
		$plugin_path = WP_PLUGIN_DIR . '/' . $plugin_slug;
		return file_exists( $plugin_path );
	}

	private function is_plugin_activated( $plugin_slug ) {
		return is_plugin_active( $plugin_slug );
	}

	/**
	 * Retrieves the list of active Cozy Addons blocks.
	 *
	 * This function returns an array of block slugs or identifiers
	 * that are marked as active by the plugin's Utils helper.
	 *
	 * @return array List of active Cozy Addons blocks.
	 */
	private function get_active_blocks() {
		$active_cozy_blocks = \CozyAddons\Helpers\Utils::get_instance()->active_blocks;

		return $active_cozy_blocks;
	}

	/**
	 * Handles AJAX request to update the activation status of a Cozy Addons block.
	 *
	 * This function verifies the user capability, sanitizes incoming POST data,
	 * and updates the WordPress option storing the block's enabled/disabled status.
	 * Only blocks present in the list of allowed active blocks are processed.
	 *
	 * Expected POST parameters:
	 * - 'block_name' (string): The slug/identifier of the block.
	 * - 'checked' (string): The new status value to be saved (usually 'true' or 'false').
	 *
	 * @return void Terminates execution with wp_die().
	 */
	public function update_block_status() {
		check_admin_referer( 'ca_active_status', 'nonce' );

		$allowed_blocks = $this->get_active_blocks();

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$block_name = isset( $_POST['block_name'] ) ? sanitize_text_field( wp_unslash( $_POST['block_name'] ) ) : '';
		if ( ! in_array( $block_name, $allowed_blocks, true ) ) {
			return;
		}

		$option_name = 'cozy-block--' . $block_name;
		$checked     = isset( $_POST['checked'] ) ? sanitize_text_field( wp_unslash( $_POST['checked'] ) ) : '';
		update_option( $option_name, $checked );
		wp_die();
	}

	private function filter_blocks_by_category( $category = '' ) {
		$blocks_manifest = require COZY_ADDONS_PLUGIN_DIR . 'blocks/blocks-manifest.php';

		if ( empty( $category ) ) {
			$filtered_blocks = array_filter(
				$blocks_manifest,
				function ( $item ) {
					return 'cozy-block' === $item['category'];
				}
			);

			return array_keys( $filtered_blocks );
		}

		$filtered_blocks = array_filter(
			$blocks_manifest,
			function ( $item ) use ( $category ) {
				return 'cozy-block/' . $category === $item['category'];
			}
		);

		return array_keys( $filtered_blocks );
	}

	public function blocks_bulk_update_status() {
		check_admin_referer( 'ca_active_status', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$category = isset( $_POST['category'] ) ? sanitize_text_field( wp_unslash( $_POST['category'] ) ) : '';
		$checked  = isset( $_POST['checked'] ) ? sanitize_text_field( wp_unslash( $_POST['checked'] ) ) : '';

		switch ( $category ) {
			case 'woocommerce':
				if ( ! \CozyAddons\Helpers\Utils::is_woocommerce_active() ) {
					return;
				}

				$woocommerce_blocks = $this->filter_blocks_by_category( $category );

				
				break;

			case 'post-magazine':
				$post_blocks = $this->filter_blocks_by_category( $category );
				break;

			case '':
				$general_blocks = $this->filter_blocks_by_category();
				break;

			default:
				break;
		}
	}

	/**
	 * Displays a generic dismissible admin notice in the WordPress dashboard.
	 *
	 * This function is used to show important information, alerts, or announcements
	 * to the user with an option to dismiss the notice. The dismissal is typically
	 * stored using user meta, options, or transients to prevent repeated display.
	 *
	 * Common use cases include plugin updates, feature announcements, or setup prompts.
	 *
	 * @return void
	 */
	public function dismiss_block_theme_notice() {
		update_option( 'cozy_addons_block_theme', 1 );
	}

	/**
	 * Displays a dismissible upsell admin notice for promoting premium features or products.
	 *
	 * This function outputs an admin notice in the WordPress dashboard, encouraging users
	 * to upgrade to a premium version or explore additional features. The notice includes
	 * a dismiss option that respects user preferences using user meta or options.
	 */
	public function dismiss_welcome_notice() {
		update_option( 'cozy_dashboard_dismissed_notice', 1 );
	}

	/**
	 * Callback function to update the enable/disable status of a custom post type feature.
	 *
	 * Typically used with the WordPress Settings API or REST API to handle toggling a setting
	 * related to custom post type (CPT) functionality in the Cozy Addons plugin.
	 *
	 * Validates and saves the new value (e.g., true/false) to the appropriate option or setting.
	 *
	 * @return void
	 */
	public function update_cpt_active_status() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		check_admin_referer( 'ca_active_status', 'nonce' );

		$allowed_options = array(
			'mega-menu-templates',
			'portfolio-gallery-templates',
			'faq-templates',
		);

		$request_option = isset( $_POST['templateName'] ) ? sanitize_text_field( wp_unslash( $_POST['templateName'] ) ) : '';

		if ( ! in_array( $request_option, $allowed_options, true ) ) {
			wp_send_json_error();
		}

		$option_name = 'ca-cpt--' . $request_option;
		$checked     = isset( $_POST['checked'] ) ? sanitize_text_field( wp_unslash( $_POST['checked'] ) ) : '';
		update_option( $option_name, $checked );

		wp_send_json_success();
	}

	public function update_cpt_args() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		check_admin_referer( 'ca_utility_function', 'nonce' );

		$field_data = isset( $_POST['fieldData'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['fieldData'] ) ), true ) : array();

		if ( empty( $field_data ) ) {
			wp_send_json_error();
		}

		$field_options = cozy_addons_get_cpt_config_option();

		foreach ( $field_data as $key => $value ) {
			$cpt  = $value['cpt'];
			$type = $value['type'];
			$val  = $value['value'];

			cozy_addons_update_cpt_value( $field_options, $cpt, $type, $val );
		}

		update_option( 'ca-cpt--config', $field_options );
		update_option( 'cozy_addons_flush_rewrite_flag', true );

		wp_send_json_success();
	}

	/**
	 * Update the enabled/disabled status of a utility function via AJAX.
	 *
	 * Handles the AJAX request triggered when an admin toggles a utility
	 * feature (e.g. animation, styles, pattern library, post terms) on or
	 * off from the plugin settings screen. Validates the nonce and user
	 * capability, restricts the target option to a whitelist of known
	 * utility functions, then persists the new state via update_option().
	 *
	 * Expects the following POST parameters:
	 *
	 * @return void Sends a JSON response and terminates execution:
	 *              - wp_send_json_success() on successful update.
	 *              - wp_send_json_error() if the function name is not in the allowed list.
	 *              - wp_die() if the current user lacks the 'manage_options' capability.
	 */
	public function update_utility_function_status() {
		check_admin_referer( 'ca_utility_function', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Access Denied' );
			return;
		}

		$allowed_options = array(
			'animation',
			'styles',
			'pattern-library',
			'post-terms',
		);

		$request_option = isset( $_POST['functionName'] ) ? sanitize_text_field( wp_unslash( $_POST['functionName'] ) ) : '';

		if ( ! in_array( $request_option, $allowed_options, true ) ) {
			wp_send_json_error();
		}

		$option_name = 'ca--utility--' . $request_option;
		$checked     = isset( $_POST['checked'] ) ? sanitize_text_field( wp_unslash( $_POST['checked'] ) ) : '';
		update_option( $option_name, $checked );
		wp_send_json_success();
	}

	public function download_plugin_rollback_versions() {
		check_admin_referer( 'cozy_addons_rollback_version_download', 'nonce' );

		$previous_version_url = isset( $_POST['downloadURL'] ) ? sanitize_url( wp_unslash( $_POST['downloadURL'] ) ) : '';

		// Your previous version logic here.
		if ( empty( esc_url( $previous_version_url ) ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid download URL.', 'cozy-addons' ) ) );
		}

		$temp_file = download_url( esc_url( $previous_version_url ) );

		if ( is_wp_error( $temp_file ) ) {
			wp_delete_file( $temp_file );
			wp_send_json_error( array( 'message' => esc_html__( 'Oops! Download failed.', 'cozy-addons' ) ) );
		}

		wp_send_json_success(
			array(
				'tempFile' => $temp_file,
			)
		);
	}

	public function activate_rollback_version() {
		check_admin_referer( 'cozy_addons_rollback_version_activate', 'nonce' );

		$temp_file = isset( $_POST['tempURL'] ) ? sanitize_text_field( wp_unslash( $_POST['tempURL'] ) ) : '';

		if ( empty( $temp_file ) || ! file_exists( $temp_file ) || mime_content_type( $temp_file ) !== 'application/zip' ) {
			wp_delete_file( $temp_file );
			wp_send_json_error();
		}

		if ( is_plugin_active( 'cozy-addons/cozy-addons.php' ) ) {
			deactivate_plugins( 'cozy-addons/cozy-addons.php' );

			if ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . 'cozy-addons' ) ) {
				// if ( is_wp_error( uninstall_plugin( 'cozy-addons/cozy-addons.php' ) ) ) {
				// wp_send_json_error();
				// }

				if ( is_wp_error( delete_plugins( array( 'cozy-addons/cozy-addons.php' ) ) ) ) {
					wp_send_json_error();
				}
			}
		}

		$result = unzip_file( $temp_file, WP_PLUGIN_DIR );

		wp_delete_file( $temp_file );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error();
		}

		if ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . 'cozy-addons' ) ) {
			activate_plugin( 'cozy-addons/cozy-addons.php' );
		}

		wp_send_json_success();
	}

	public function install_activate_plugin() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'Not allowed' );
		}

		check_admin_referer( 'ca_theme_plugin_install_activate', 'nonce' );

		$requested_plugins = isset( $_POST['plugins'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['plugins'] ) ) ) : array();

		$allowed_plugins = array(
			'woocommerce',
			'vidplex',
			'rootblox',
			'quiqowl',
		);

		$matches = array();
		if ( ! empty( $requested_plugins ) ) {
			$matches = array_intersect( $requested_plugins, $allowed_plugins );
			if ( empty( $matches ) ) {
				$matches = $allowed_plugins;
			}
		} else {
			$matches = $allowed_plugins;
		}

		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/misc.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

		foreach ( $matches as $plugin_slug ) {
			$plugin_file = $plugin_slug . '.php';

			if ( $this->is_plugin_activated( $plugin_slug . '/' . $plugin_file ) ) {
				continue;
			}

			if ( $this->is_plugin_installed( $plugin_slug . '/' . $plugin_file ) ) {
				activate_plugin( $plugin_slug . '/' . $plugin_file );
				continue;
			}

			$api = plugins_api(
				'plugin_information',
				array(
					'slug'   => $plugin_slug,
					'fields' => array( 'sections' => false ),
				)
			);

			if ( is_wp_error( $api ) ) {
				continue;
			}

			$upgrader = new \Plugin_Upgrader();
			$install  = $upgrader->install( $api->download_link );

			if ( $install ) {
				// Activate the plugin.
				$activate = activate_plugin( $plugin_slug . '/' . $plugin_file );

				// Check if activation is successful.
				if ( is_wp_error( $activate ) ) {
					continue;
				}
			}
		}

		wp_send_json_success();
	}
}
