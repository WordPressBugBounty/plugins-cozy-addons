<?php

namespace CozyAddons;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the registration and management of custom Gutenberg blocks
 * for the Cozy Addons plugin.
 *
 * This singleton class serves as the entry point for loading and organizing
 * all block-related functionality.
 *
 * @package CozyAddons
 */
class Blocks {

	/**
	 * Singleton instance of the class.
	 *
	 * @var Blocks|null
	 */
	private static $instance = null;

	private static $blocks_manifest = array();

	private static $group_blocks = array(
		'carousel',
		'grid',
		'slide',
		'form-field',
		'form-step',
	);

	/**
	 * Blocks whose frontend script (frontend/{block}.js) is plain JS and needs no jQuery.
	 *
	 * @var string[]
	 */
	private static $jquery_free_scripts = array(
		'advanced-categories',
		'advanced-search',
		'advanced-tab',
		'current-time',
		'featured-post',
		'form',
		'product-category',
		'product-review',
		'progress-bar',
		'related-post',
		'teams',
		'testimonial',
	);

	private static $premium_blocks = array(
		'news-ticker',
		'post-slider',
		'popular-post',
		'related-post',
		'trending-post',
		'product-slider',
		'product-tab',
		'post-views',
		'post-comments',
		'featured-post-tabs',
		'advanced-categories',
		'featured-product-tabs',
		'categorized-post-tabs',
		'magazine-grid',
		'magazine-list',
		'featured-post',
		'wishlist',
		'quick-view',
		'featured-product',
		'toggle-content',
		'countdown-timer',
		'cf7-styler',
		'img-compare',
		'portfolio-gallery-meta',
		'scroll-animation',
	);

	private static $woocommerce_blocks = array(
		'product-carousel',
		'product-category',
		'product-review',
		'product-slider',
		'product-tab',
		'featured-product-tabs',
		'quick-view',
		'featured-product',
		'wishlist',
		'add-to-cart',
	);

	/**
	 * Absolute path to the blocks directory.
	 *
	 * @var string
	 */
	private static $dir = COZY_ADDONS_PLUGIN_DIR . 'blocks/';

	/**
	 * URL to the blocks directory.
	 *
	 * @var string
	 */
	private static $url = COZY_ADDONS_PLUGIN_URL . 'blocks/';

	/**
	 * Returns the singleton instance of the Blocks class.
	 *
	 * @return Blocks The singleton instance.
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * Private to enforce the singleton pattern.
	 * You can use this constructor to load block files or perform setup logic.
	 *
	 * @access private
	 */
	private function __construct() {
		self::$blocks_manifest = \CozyAddons\Helpers\Utils::get_instance()->active_blocks;

		// Initialization logic for custom blocks can go here.
		add_filter( 'block_categories_all', array( $this, 'add_block_categories' ) );

		add_action( 'init', array( $this, 'register_blocks' ) );

		add_action( 'enqueue_block_editor_assets', array( $this, 'localize_editor_globals' ), 5 );
	}

	public function add_block_categories( $categories ) {
		return array_merge(
			array(
				array(
					'slug'  => 'cozy-block',
					'title' => __( 'Cozy Blocks - General', 'cozy-addons' ),
				),

				array(
					'slug'  => 'cozy-block/post-magazine',
					'title' => __( 'Cozy Blocks - Post & Magazine', 'cozy-addons' ),
				),

				array(
					'slug'  => 'cozy-block/woocommerce',
					'title' => __( 'Cozy Blocks - WooCommerce', 'cozy-addons' ),
				),
			),
			$categories
		);
	}

	private function register_utility_blocks() {
		foreach ( self::$group_blocks as $util_block ) {
			if ( is_dir( self::$dir . $util_block ) ) {
				register_block_type( self::$dir . $util_block );
			}
		}
	}

	public function register_blocks() {
		if ( empty( self::$blocks_manifest ) || ! is_array( self::$blocks_manifest ) ) {
			return;
		}

		// Let register_block_type() read block metadata from the build manifest (one opcache-able PHP
		// array) instead of parsing every block.json on every request. WP 6.7+.
		if ( function_exists( 'wp_register_block_metadata_collection' ) && file_exists( self::$dir . 'blocks-manifest.php' ) ) {
			wp_register_block_metadata_collection( self::$dir, self::$dir . 'blocks-manifest.php' );
		}

		$this->register_utility_blocks();

		// Editor-only globals. Registered here so block editor scripts can depend on the handle; the data
		// itself is built and attached only when the block editor loads (see localize_editor_globals()).
		wp_register_script( 'cozy-addons--global-block-vars', self::$url . 'index.js', array(), COZY_ADDONS_VERSION, false );

		wp_register_style( 'cozy-block--global-block-styles', COZY_ADDONS_PLUGIN_URL . 'assets/css/block-styles.css', array(), COZY_ADDONS_VERSION );

		foreach ( self::$blocks_manifest as $block_name ) {
			// Block enabled status from dashboard.
			$is_block_active = get_option( 'cozy-block--' . $block_name );

			if ( in_array( $block_name, self::$group_blocks, true ) || ( ! \CozyAddons\Helpers\Utils::is_woocommerce_active() && in_array( $block_name, self::$woocommerce_blocks, true ) ) || ( '0' === $is_block_active ) ) {
				continue;
			}

			if ( '' === $is_block_active && ! in_array( $block_name, self::$premium_blocks, true ) ) {
				update_option( 'cozy-block--' . $block_name, 1 );
			}

			// Frontend script registration/enqueue.
			$frontend_script_path = COZY_ADDONS_PLUGIN_DIR . 'frontend/' . $block_name . '.js';
			$frontend_script_url  = COZY_ADDONS_PLUGIN_URL . 'frontend/' . $block_name . '.js';
			$script_handle        = 'cozy-block--' . $block_name . '--frontend-script';

			if ( file_exists( $frontend_script_path ) ) {
				// Only pull in jQuery (+ migrate, ~100 KB) for scripts that actually use it.
				$deps = in_array( $block_name, self::$jquery_free_scripts, true ) ? array() : array( 'jquery' );
				wp_register_script( $script_handle, $frontend_script_url, $deps, COZY_ADDONS_VERSION, true );
			}

			if ( 'portfolio-gallery-meta' === $block_name ) {
				$is_portfolio_active = get_option( 'cozy-block--portfolio-gallery' );
				if ( '0' === $is_portfolio_active ) {
					continue;
				}
			}

			// Block registration.
			$block_type = register_block_type(
				self::$dir . $block_name,
			);

			self::add_global_vars_dependency( $block_type );
		}
	}

	/**
	 * Makes a block's editor scripts depend on the editor globals handle, so `cozyBlockAssets`
	 * is defined before any block bundle evaluates.
	 *
	 * @param \WP_Block_Type|false $block_type Registered block type.
	 * @return void
	 */
	private static function add_global_vars_dependency( $block_type ) {
		if ( ! $block_type instanceof \WP_Block_Type || empty( $block_type->editor_script_handles ) ) {
			return;
		}

		$scripts = wp_scripts();

		foreach ( $block_type->editor_script_handles as $handle ) {
			if ( isset( $scripts->registered[ $handle ] ) && ! in_array( 'cozy-addons--global-block-vars', $scripts->registered[ $handle ]->deps, true ) ) {
				$scripts->registered[ $handle ]->deps[] = 'cozy-addons--global-block-vars';
			}
		}
	}

	/**
	 * Builds the editor globals (`cozyBlockAssets`) and enqueues them, in the block editor only.
	 *
	 * Previously this was localized on `init`, which printed ~500 KB of icon/font data on every
	 * frontend and admin page and ran the review/portfolio queries on every request.
	 *
	 * @return void
	 */
	public function localize_editor_globals() {
		if ( ! wp_script_is( 'cozy-addons--global-block-vars', 'registered' ) ) {
			return;
		}

		wp_localize_script(
			'cozy-addons--global-block-vars',
			'cozyBlockAssets',
			array(
				'isPremium'            => cozy_addons_premium_access(),
				'imageDir'             => COZY_ADDONS_PLUGIN_URL . 'assets/img',
				'googleFonts'          => cozy_addons_google_fonts(),
				'icons'                => \CozyAddons\Icons::get_cozy_icon_collection(),
				'socialIcons'          => \CozyAddons\Icons::get_cozy_social_icon_collection(),
				'shapeDividerIcons'    => \CozyAddons\Icons::get_cozy_shape_divider_collection(),
				'breadcrumbSeparators' => \CozyAddons\Icons::get_cozy_breadcrumbs_separator(),
				'portfolioCPT'         => \CozyAddons\Helpers\Utils::get_cozy_portfolio_gallery_templates(),
				'portfolioTerms'       => get_terms( array( 'ca_portfolio_gallery_category' ) ),
				'productReviews'       => \CozyAddons\Helpers\Utils::get_woo_product_reviews(),
				'totalReviews'         => \CozyAddons\Helpers\Utils::get_woo_total_product_reviews(),
				'avgReviews'           => \CozyAddons\Helpers\Utils::get_woo_avg_product_reviews(),
				'adminURL'             => trailingslashit( admin_url() ),
			)
		);

		wp_enqueue_script( 'cozy-addons--global-block-vars' );
	}

	/**
	 * Include asset path if exists to fetch dependencies and version.
	 *
	 * @param string $path location to the index.asset.php.
	 * @return array
	 */
	public static function asset_file_values( string $path ): array {
		$asset_path = $path;

		return file_exists( $asset_path )
			? include $asset_path
			: array(
				'dependencies' => array(),
				'version'      => $version ?? COZY_ADDONS_VERSION,
			);
	}
}
