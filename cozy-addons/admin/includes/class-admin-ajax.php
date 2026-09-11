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
		add_action( 'wp_ajax_cozy_addons_seed_cpt', array( $this, 'generate_cpt_dummy_data' ) );
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
				function ( $item, $block_name ) {
					if ( 'cozy-block' === $item['category'] ) {
						if ( ! cozy_addons_premium_access() && in_array( $block_name, self::$premium_blocks, true ) ) {
							return false;
						}
						return true;
					}
					return false;
				},
				ARRAY_FILTER_USE_BOTH
			);

			return array_keys( $filtered_blocks );
		}

		$filtered_blocks = array_filter(
			$blocks_manifest,
			function ( $item, $block_name ) use ( $category ) {
				if ( 'cozy-block/' . $category === $item['category'] ) {
					if ( ! cozy_addons_premium_access() && in_array( $block_name, self::$premium_blocks, true ) ) {
						return false;
					}
					return true;
				}
				return false;
			},
			ARRAY_FILTER_USE_BOTH
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

		$blocks = array();

		switch ( $category ) {
			case 'woocommerce':
				if ( ! \CozyAddons\Helpers\Utils::is_woocommerce_active() ) {
					return;
				}

				$blocks = $this->filter_blocks_by_category( $category );

				break;

			case 'post-magazine':
				$blocks = $this->filter_blocks_by_category( $category );
				break;

			case '':
				$blocks = $this->filter_blocks_by_category();
				break;

			default:
				break;
		}

		if ( ! empty( $blocks ) ) {
			foreach ( $blocks as $block_name ) {
				update_option( 'cozy-block--' . $block_name, $checked );
			}
		}

		wp_send_json_success(
			array(
				'blocks' => $blocks,
			)
		);
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

	private function get_cpt_dummy_data( $post_type = '' ) {
		if ( empty( $post_type ) ) {
			return array();
		}

		switch ( $post_type ) {
			case 'ca_faq':
				$faq_data = array(
					array(
						'post_title'   => 'How do I reset my password?',
						'post_content' => '<!-- wp:paragraph -->
							<p>Go to the login page and click "Forgot Password." Enter your registered email address, and we\'ll send you a link to create a new password. The link expires after 24 hours.</p>
							<!-- /wp:paragraph -->',
					),
					array(
						'post_title'   => 'What payment methods do you accept?',
						'post_content' => '<!-- wp:paragraph -->
							<p>We accept all major credit and debit cards (Visa, Mastercard, American Express), PayPal, and bank transfers. Payment information is processed securely and never stored on our servers.</p>
							<!-- /wp:paragraph -->',
					),
					array(
						'post_title'   => 'How long does shipping take?',
						'post_content' => '<!-- wp:paragraph -->
							<p>Standard shipping typically takes 3–5 business days within the country. Express shipping options are available at checkout for 1–2 day delivery, depending on your location.</p>
							<!-- /wp:paragraph -->',
					),
					array(
						'post_title'   => 'Can I cancel or change my order after placing it?',
						'post_content' => '<!-- wp:paragraph -->
							<p>Orders can be modified or canceled within 1 hour of placement. After that window, the order enters processing and can no longer be changed, though you can still request a return once it arrives.</p>
							<!-- /wp:paragraph -->',
					),
					array(
						'post_title'   => 'Do you offer a free trial for premium plans?',
						'post_content' => '<!-- wp:paragraph -->
							<p>Yes, all premium plans come with a 14-day free trial. No credit card is required to start, and you can cancel anytime before the trial ends without being charged.</p>
							<!-- /wp:paragraph -->',
					),
				);

				return $faq_data;

			case 'ca_testimonial':
				$testimonials_data = array(
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/media/testimonial-1.png',
						'post_title'    => 'Absolutely love this plugin!',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>This tool completely transformed how we manage our workflow. The interface is intuitive and support has been fantastic every step of the way.</p>
                            <!-- /wp:paragraph -->',
						'meta_input'    => array(
							'ca_testimonial_rating'        => '5',
							'ca_testimonial_name'          => 'James Whitfield',
							'ca_testimonial_role'          => 'Marketing Manager',
							'ca_testimonial_review_source' => 'google',
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/media/testimonial-2.png',
						'post_title'    => 'Great value for the price',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>We compared several options before settling on this one, and it was clearly the best choice. Setup was quick and the results speak for themselves.</p>
                            <!-- /wp:paragraph -->',
						'meta_input'    => array(
							'ca_testimonial_rating'        => '4',
							'ca_testimonial_name'          => 'Sarah Johnson',
							'ca_testimonial_role'          => 'Small Business Owner',
							'ca_testimonial_review_source' => 'google',
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/media/testimonial-3.png',
						'post_title'    => 'Exceeded our expectations',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Our team was skeptical at first, but within a week everyone was on board. The customization options let us tailor everything to our exact needs.</p>
                            <!-- /wp:paragraph -->',
						'meta_input'    => array(
							'ca_testimonial_rating'        => '5',
							'ca_testimonial_name'          => 'Emily Rodriguez',
							'ca_testimonial_role'          => 'Operations Director',
							'ca_testimonial_review_source' => 'google',

						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/media/team-1.png',
						'post_title'    => 'Solid tool, minor learning curve',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>It took a little while to get used to all the features, but once we did, it became an essential part of our daily operations. Would recommend to any growing team.</p>
                            <!-- /wp:paragraph -->',
						'meta_input'    => array(
							'ca_testimonial_rating'        => '4',
							'ca_testimonial_name'          => 'David Kim',
							'ca_testimonial_role'          => 'Product Manager',
							'ca_testimonial_review_source' => 'google',

						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/media/team-3.png',
						'post_title'    => 'Customer support is top notch',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Whenever we ran into an issue, the support team responded quickly and actually solved the problem instead of just pointing us to a FAQ page. Rare these days.</p>
                            <!-- /wp:paragraph -->',
						'meta_input'    => array(
							'ca_testimonial_rating'        => '5',
							'ca_testimonial_name'          => 'Priya Patel',
							'ca_testimonial_role'          => 'Customer',
							'ca_testimonial_review_source' => 'google',

						),
					),
				);

				return $testimonials_data;

			case 'ca_portfolio_gallery':
				$portfolio_data = array(
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/portfolio-gallery/gallery-1.png',
						'post_title'    => 'Nimbus Cloud Dashboard Redesign',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>A complete overhaul of a SaaS analytics dashboard, focused on simplifying complex data visualizations and reducing time-to-insight for enterprise users.</p>
                            <!-- /wp:paragraph -->',
						'categories'    => array( 'Web Design', 'SaaS' ),
						'meta_input'    => array(
							'ca_portfolio_gallery_project_year' => '2024',
							'ca_portfolio_gallery_client' => 'Nimbus Technologies',
							'ca_portfolio_gallery_skills' => 'Figma, React, D3.js, Tailwind CSS',
							'ca_portfolio_gallery_url'    => 'https://example.com/nimbus-dashboard',
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/portfolio-gallery/gallery-2.png',
						'post_title'    => 'Harborline E-Commerce Platform',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Built a headless e-commerce storefront handling over 10,000 SKUs, with custom filtering, a streamlined checkout flow, and full mobile responsiveness.</p>
                            <!-- /wp:paragraph -->',
						'categories'    => array( 'E-Commerce', 'Development' ),
						'meta_input'    => array(
							'ca_portfolio_gallery_project_year' => '2023',
							'ca_portfolio_gallery_client' => 'Harborline Goods',
							'ca_portfolio_gallery_skills' => 'WordPress, WooCommerce, PHP, JavaScript',
							'ca_portfolio_gallery_url'    => 'https://example.com/harborline-shop',
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/portfolio-gallery/gallery-3.png',
						'post_title'    => 'Verdant Wellness Brand Identity',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Developed a full brand identity system for a wellness startup, including logo design, color palette, typography guidelines, and a launch landing page.</p>
                            <!-- /wp:paragraph -->',
						'categories'    => array( 'Branding', 'Design' ),
						'meta_input'    => array(
							'ca_portfolio_gallery_project_year' => '2024',
							'ca_portfolio_gallery_client' => 'Verdant Wellness Co.',
							'ca_portfolio_gallery_skills' => 'Illustrator, Photoshop, Webflow',
							'ca_portfolio_gallery_url'    => 'https://example.com/verdant-brand',
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/portfolio-gallery/gallery-4.png',
						'post_title'    => 'Pulsegrid Fintech Mobile App',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Designed and developed a personal finance tracking app with real-time budget alerts, spending insights, and biometric login support.</p>
                            <!-- /wp:paragraph -->',
						'categories'    => array( 'Mobile App', 'Fintech' ),
						'meta_input'    => array(
							'ca_portfolio_gallery_project_year' => '2022',
							'ca_portfolio_gallery_client' => 'Pulsegrid Inc.',
							'ca_portfolio_gallery_skills' => 'React Native, Node.js, Firebase',
							'ca_portfolio_gallery_url'    => 'https://example.com/pulsegrid-app',
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/portfolio-gallery/gallery-5.png',
						'post_title'    => 'Oakstead Realty Marketing Site',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Created a marketing website for a boutique real estate agency, featuring interactive property maps, virtual tour embeds, and lead-capture forms.</p>
                            <!-- /wp:paragraph -->',
						'categories'    => array( 'Web Design', 'Real Estate' ),
						'meta_input'    => array(
							'ca_portfolio_gallery_project_year' => '2023',
							'ca_portfolio_gallery_client' => 'Oakstead Realty Group',
							'ca_portfolio_gallery_skills' => 'WordPress, ACF, GSAP, Mapbox',
							'ca_portfolio_gallery_url'    => 'https://example.com/oakstead-realty',
						),
					),
				);

				return $portfolio_data;

			case 'post':
				$blog_data = array(
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/post/blog-1.png',
						'post_title'    => 'The Role of AI in Shaping the Next Generation of SaaS',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Artificial intelligence is no longer a bolt-on feature for software platforms — it is becoming the foundation many products are built around. From predictive analytics to automated workflows, AI is reshaping how SaaS companies design their core offerings.</p>
                            <!-- /wp:paragraph -->

                            <!-- wp:paragraph -->
                            <p>Forward-thinking teams are embedding machine learning directly into their product roadmaps rather than treating it as an afterthought, giving users smarter defaults and more personalized experiences out of the box.</p>
                            <!-- /wp:paragraph -->',
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/post/blog-2.png',
						'post_title'    => 'How Automation Is Cutting SaaS Onboarding Time in Half',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Long, manual onboarding flows are one of the biggest reasons new users abandon a product before they see its value. Automated setup wizards and smart defaults are changing that equation entirely.</p>
                            <!-- /wp:paragraph -->

                            <!-- wp:paragraph -->
                            <p>By automatically importing data, pre-configuring common settings, and guiding users toward their first meaningful action, companies are seeing dramatically faster time-to-value and higher activation rates.</p>
                            <!-- /wp:paragraph -->',
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/post/blog-3.png',
						'post_title'    => 'The Future of SaaS: Trends to Watch in 2025',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Usage-based pricing, vertical-specific platforms, and AI-native features are three of the biggest shifts reshaping the SaaS landscape heading into 2025.</p>
                            <!-- /wp:paragraph -->

                            <!-- wp:paragraph -->
                            <p>Companies that adapt their product and pricing strategy early are positioning themselves to capture the next wave of buyers, who increasingly expect flexibility and intelligence baked into every tool they adopt.</p>
                            <!-- /wp:paragraph -->',
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/post/blog-4.png',
						'post_title'    => 'Why Customer Retention Is the New Growth Metric',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Acquiring new customers has always dominated the growth conversation, but retention is quietly becoming the metric that separates sustainable SaaS businesses from the rest.</p>
                            <!-- /wp:paragraph -->

                            <!-- wp:paragraph -->
                            <p>Reducing churn by even a few percentage points compounds significantly over time, and many teams are now investing as much in customer success as they do in sales and marketing.</p>
                            <!-- /wp:paragraph -->',
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/post/blog-5.png',
						'post_title'    => 'Building a Product-Led Growth Strategy from Scratch',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Product-led growth flips the traditional sales funnel by letting the product itself do the convincing, often through free trials, freemium tiers, or self-serve onboarding.</p>
                            <!-- /wp:paragraph -->

                            <!-- wp:paragraph -->
                            <p>Getting this right requires a deep understanding of your "aha moment" — the specific point where users recognize the product\'s value — and designing every early interaction to get them there faster.</p>
                            <!-- /wp:paragraph -->',
					),
				);

				return $blog_data;

			case 'product':
				$product_data = array(
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/product/product-1.png',
						'post_title'    => 'Aria Wireless Headphones',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Over-ear wireless headphones with active noise cancellation, 30-hour battery life, and plush memory-foam ear cushions for all-day comfort.</p>
                            <!-- /wp:paragraph -->',
						'post_excerpt'  => 'Wireless over-ear headphones with ANC and 30-hour battery life.',
						'meta_input'    => array(
							'_sku'           => 'ARIA-HP-001',
							'_regular_price' => '129.99',
							'_sale_price'    => '99.99',
							'_stock_qty'     => 45,
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/product/product-2.png',
						'post_title'    => 'Kindle Ridge Ceramic Mug',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>Hand-glazed ceramic mug with a matte finish, holds 12oz, and is safe for both microwave and dishwasher use. Available in a warm terracotta glaze.</p>
                            <!-- /wp:paragraph -->',
						'post_excerpt'  => 'Hand-glazed 12oz ceramic mug, microwave and dishwasher safe.',
						'meta_input'    => array(
							'_sku'           => 'KR-MUG-014',
							'_regular_price' => '18.00',
							'_sale_price'    => '',
							'_stock_qty'     => 120,
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/product/product-3.png',
						'post_title'    => 'Trailmark Canvas Backpack',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>A rugged 22L canvas backpack with a padded laptop sleeve, water-resistant coating, and reinforced stitching built to handle daily commutes or weekend trips.</p>
                            <!-- /wp:paragraph -->',
						'post_excerpt'  => 'Rugged 22L canvas backpack with padded laptop sleeve.',
						'meta_input'    => array(
							'_sku'           => 'TM-BAG-022',
							'_regular_price' => '74.50',
							'_sale_price'    => '59.00',
							'_stock_qty'     => 30,
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/product/product-4.png',
						'post_title'    => 'Solace Weighted Blanket',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>A 15lb weighted blanket filled with glass beads and wrapped in a breathable cotton cover, designed to reduce restlessness and improve sleep quality.</p>
                            <!-- /wp:paragraph -->',
						'post_excerpt'  => '15lb weighted blanket with breathable cotton cover.',
						'meta_input'    => array(
							'_sku'           => 'SOL-BLK-015',
							'_regular_price' => '89.99',
							'_sale_price'    => '',
							'_stock_qty'     => 0,
						),
					),
					array(
						'thumbnail_url' => 'https://plugins.cozythemes.com/cozy-addons/assets/cpt/product/product-5.png',
						'post_title'    => 'Fernwood Cutting Board Set',
						'post_content'  => '<!-- wp:paragraph -->
                            <p>A set of three acacia wood cutting boards in graduated sizes, finished with food-safe mineral oil and featuring a juice groove to catch spills.</p>
                            <!-- /wp:paragraph -->',
						'post_excerpt'  => 'Set of 3 acacia wood cutting boards with juice groove.',
						'meta_input'    => array(
							'_sku'           => 'FW-CBS-003',
							'_regular_price' => '42.00',
							'_sale_price'    => '34.99',
							'_stock_qty'     => 65,
						),
					),
				);

				return $product_data;

			default:
				return array();
		}
	}

	private function cpt_create_thumbnail( $post_id, $post_type, $thumbnail_url ) {
		$image_url = $thumbnail_url;
		$tmp       = download_url( $image_url );
		if ( is_wp_error( $tmp ) ) {
			return;
		}

		$file_array = array(
			'name'     => $post_type . $post_id . '.png',
			'tmp_name' => $tmp,
		);

		$attachment_id = media_handle_sideload( $file_array, $post_id );
		if ( ! is_wp_error( $attachment_id ) ) {
			set_post_thumbnail( $post_id, $attachment_id );
		} else {
			wp_delete_file( $tmp );
		}
	}


	public function generate_cpt_dummy_data() {
		check_admin_referer( 'ca_utility_function', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$allowed_post_types = array(
			'ca_faq',
			'ca_testimonial',
			'ca_portfolio_gallery',
			'post',
			'product',
		);

		$post_type = isset( $_POST['postType'] ) && in_array( sanitize_text_field( wp_unslash( $_POST['postType'] ) ), $allowed_post_types, true ) ? sanitize_text_field( wp_unslash( $_POST['postType'] ) ) : '';

		if ( empty( $post_type ) ) {
			wp_send_json_error();
		}

		$cpt_data = $this->get_cpt_dummy_data( $post_type );

		if ( empty( $cpt_data ) ) {
			wp_send_json_error();
		}

		foreach ( $cpt_data as $cpt ) {
			$post_id = wp_insert_post(
				array_merge(
					$cpt,
					array(
						'post_status' => 'publish',
						'post_type'   => $post_type,
					)
				)
			);

			if ( isset( $cpt['thumbnail_url'] ) && ! empty( $cpt['thumbnail_url'] ) ) {
				$this->cpt_create_thumbnail( $post_id, $post_type, $cpt['thumbnail_url'] );
			}
		}

		wp_send_json_success();
	}
}
