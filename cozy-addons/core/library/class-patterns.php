<?php
namespace Core;

use WP_Block_Pattern_Categories_Registry;
use WP_Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Patterns {
	private static $instance;

	private static $dir = COZY_ADDONS_PLUGIN_DIR . 'core/library/';
	private static $url = COZY_ADDONS_PLUGIN_URL . 'core/library/';

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->init();

		$this->register_theme_patterns();
	}

	/**
	 * Registers editor and frontend hooks for the block pattern library feature.
	 *
	 * Two things happen here, both gated behind the 'ca--utility--pattern-library'
	 * option: the feature is considered "on" if the option is explicitly '1', or
	 * if it hasn't been set/is empty (i.e. it defaults to enabled). Any other
	 * value disables it.
	 *
	 * - On 'enqueue_block_editor_assets': enqueues the pattern library JS for
	 *   the block editor and localizes it with premium status, plugin URL,
	 *   the patterns/templates/pages JSON data, and the active theme's
	 *   text domain.
	 * - On 'wp_enqueue_scripts': enqueues the frontend stylesheet for
	 *   pattern-related styles.
	 *
	 * @since 1.0.0 (adjust to your actual version)
	 *
	 * @return void
	 */
	private function init() {
		add_action(
			'enqueue_block_editor_assets',
			function () {
				$value = get_option( 'ca--utility--pattern-library' );

				if ( '1' !== $value && '' != $value ) {
					return;
				}

				wp_enqueue_script(
					'cozy-addons--pattern',
					COZY_ADDONS_PLUGIN_URL . 'assets/js/cozy-patterns.js',
					array( 'react-jsx-runtime', 'wp-editor', 'wp-plugins', 'wp-primitives' ),
					COZY_ADDONS_VERSION,
					false
				);
				wp_localize_script(
					'cozy-addons--pattern',
					'scriptObj',
					array(
						'isPremium'   => cozy_addons_premium_access(),
						'pluginUrl'   => COZY_ADDONS_PLUGIN_URL,
						'patterns'    => wp_json_file_decode( self::$dir . 'patterns/patterns.json' ),
						'templates'   => wp_json_file_decode( self::$dir . 'templates/templates.json' ),
						'pages'       => wp_json_file_decode( self::$dir . 'pages/pages.json' ),
						'activeTheme' => wp_get_theme()->get( 'TextDomain' ),
					)
				);
			}
		);

		add_action(
			'wp_enqueue_scripts',
			function () {
				$value = get_option( 'ca--utility--pattern-library' );

				if ( '1' !== $value && '' != $value ) {
					return;
				}

				wp_enqueue_style(
					'cozy-addons--pattern--frontend',
					COZY_ADDONS_PLUGIN_URL . 'assets/css/pattern-styles.css',
					array(),
					COZY_ADDONS_VERSION
				);
			}
		);
	}

	/**
	 * Gets the list of themes that support premium block patterns.
	 *
	 * Reads from a JSON file on disk, validates and sanitizes the result,
	 * and caches it for the duration of the request to avoid repeated
	 * file reads.
	 *
	 * @return array List of sanitized theme slugs.
	 */
	private function get_supported_pattern_themes() {
		$cache_key = 'ca_pattern_themes';
		$cached    = get_transient( $cache_key );

		if ( false !== $cached ) {
			return $cached;
		}

		$themes = array();

		$response = wp_remote_get(
			'https://plugins.cozythemes.com/cozy-addons/theme-patterns.json',
			array( 'timeout' => 5 )
		);

		if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );

			if ( is_array( $data ) ) {
				$themes = array_values(
					array_filter(
						array_map( 'sanitize_key', $data )
					)
				);
			}
		}

		// Cache for 12 hours, even on failure (empty array), so a down
		// server doesn't cause a remote request on every single page load.
		set_transient( $cache_key, $themes, 12 * HOUR_IN_SECONDS );

		return $themes;
	}

	/**
	 * Registers a premium block pattern category for the active theme.
	 *
	 * Only runs for premium users, and only when the currently active
	 * theme's stylesheet slug is in the supported list. Registers a
	 * "{Theme Name} PRO" block pattern category (slug: ct-{theme}-pro)
	 * on 'init', so pattern files can be assigned to it.
	 *
	 * @since 1.0.0 (adjust to your actual version)
	 *
	 * @return void
	 */
	private function register_theme_patterns() {
		if ( ! cozy_addons_premium_access() ) {
			return;
		}

		$themes = $this->get_supported_pattern_themes();

		$active_theme = get_stylesheet();

		if ( ! in_array( $active_theme, $themes, true ) ) {
			return;
		}

		add_action(
			'init',
			function () use ( $active_theme ) {
				$cat_slug = 'ct-' . $active_theme . '-pro';

				$theme      = wp_get_theme();
				$theme_name = $theme->get( 'Name' );

				if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $cat_slug ) ) {
					register_block_pattern_category(
						$cat_slug,
						array(
							'label' => $theme_name . __( ' PRO', 'cozy-addons' ),
						)
					);
				}
			}
		);
	}
}
