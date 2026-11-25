<?php
namespace CozyAddons\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Utility helper functions for the Cozy Addons plugin.
 *
 * Provides general-purpose static methods used across the plugin.
 *
 * @since      1.0.0
 * @package    CozyAddons
 * @subpackage CozyAddons/Helpers
 */
class Utils {
	/**
	 * Holds the singleton instance of the class.
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * List of active block slugs registered in the plugin.
	 *
	 * @var array
	 */
	public $active_blocks = array();

	/**
	 * Returns the singleton instance of the class.
	 *
	 * Creates a new instance if one doesn't already exist.
	 * Ensures only one instance of this class is used throughout the plugin.
	 *
	 * @return self
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
	 * Initializes admin functionality by loading necessary admin files.
	 *
	 * @access private
	 */
	private function __construct() {
		$blocks              = require_once COZY_ADDONS_PLUGIN_DIR . 'blocks/blocks-manifest.php';
		$this->active_blocks = array_keys( $blocks );

		// Keep the cached review list in step with reviews and products.
		add_action( 'comment_post', array( __CLASS__, 'flush_review_cache_for_comment' ) );
		add_action( 'edit_comment', array( __CLASS__, 'flush_review_cache_for_comment' ) );
		add_action( 'deleted_comment', array( __CLASS__, 'flush_review_cache' ) );
		add_action( 'wp_set_comment_status', array( __CLASS__, 'flush_review_cache_for_comment' ) );
		add_action( 'save_post', array( __CLASS__, 'flush_review_cache_for_post' ) );
		add_action( 'deleted_post', array( __CLASS__, 'flush_review_cache_for_post' ) );
	}

	/**
	 * Determines whether the currently active theme is a block-based (FSE) theme.
	 *
	 * This function checks if the active WordPress theme supports full site editing (FSE)
	 * by verifying the existence of a `theme.json` file or using WordPress core functions.
	 *
	 * Useful for conditionally enabling features or compatibility layers specific to block themes.
	 *
	 * @return bool True if a block (FSE) theme is active, false otherwise.
	 */
	public static function is_block_theme() {
		$active_theme = wp_get_theme();

		return $active_theme->is_block_theme();
	}

	public static function is_plugin_installed( $plugin_slug ) {
		$plugin_path = WP_PLUGIN_DIR . '/' . $plugin_slug;
		return file_exists( $plugin_path );
	}

	/**
	 * Checks whether the WooCommerce plugin is active.
	 *
	 * This function determines if WooCommerce is currently active on the site,
	 * typically by checking the list of active plugins or if the WooCommerce class exists.
	 *
	 * Useful for conditionally loading WooCommerce-specific features or settings.
	 *
	 * @return bool True if WooCommerce is active, false otherwise.
	 */
	public static function is_woocommerce_active() {
		return is_plugin_active( 'woocommerce/woocommerce.php' );
	}

	/**
	 * Generates a trimmed excerpt from a given string.
	 *
	 * Strips shortcodes and HTML tags, splits the content by words,
	 * and truncates it to the specified word count.
	 * If the content exceeds the length, ellipsis (`...`) is appended.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content The raw content string to generate an excerpt from.
	 * @param int    $length  Optional. Number of words to limit the excerpt to. Default 20.
	 *
	 * @return string The cleaned, shortened excerpt.
	 */
	public static function generate_excerpt( $content, $length = 20 ) {
		if ( empty( $content ) ) {
			return '';
		}

		// Strip HTML tags and shortcodes.
		$content = wp_strip_all_tags( strip_shortcodes( $content ) );
		// $content = do_blocks( $content );

		if ( null === $length ) {
			return $content;
		}

		// Split the content into words.
		$words = explode( ' ', $content );

		// Truncate to the specified length.
		if ( count( $words ) > $length ) {
			$words   = array_slice( $words, 0, $length );
			$content = implode( ' ', $words ) . '...';
		} else {
			$content = implode( ' ', $words );
		}

		return esc_html( $content );
	}

	/**
	 * Transient that caches the enriched product review list.
	 */
	const REVIEWS_CACHE_KEY = 'ca_woo_product_reviews';

	/**
	 * Transient that caches the review count and average rating.
	 */
	const REVIEW_STATS_CACHE_KEY = 'ca_woo_review_stats';

	/**
	 * Per-request copies of the cached values, so repeated calls in one request are free.
	 *
	 * @var array
	 */
	private static $memo = array();

	/**
	 * Clears the cached review data. Hooked to comment and product changes in the constructor.
	 *
	 * @return void
	 */
	public static function flush_review_cache() {
		delete_transient( self::REVIEWS_CACHE_KEY );
		delete_transient( self::REVIEW_STATS_CACHE_KEY );
		unset( self::$memo['reviews'], self::$memo['review_stats'] );
	}

	/**
	 * Clears the review cache when a product changes (its title, rating or image feed the list).
	 *
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public static function flush_review_cache_for_post( $post_id ) {
		if ( 'product' === get_post_type( $post_id ) ) {
			self::flush_review_cache();
		}
	}

	/**
	 * Clears the review cache when a product review comment changes.
	 *
	 * @param int|\WP_Comment $comment Comment ID or object.
	 * @return void
	 */
	public static function flush_review_cache_for_comment( $comment ) {
		$comment = get_comment( $comment );

		if ( $comment && 'product' === get_post_type( $comment->comment_post_ID ) ) {
			self::flush_review_cache();
		}
	}

	/**
	 * Retrieves a list of approved product reviews with additional product and user data.
	 *
	 * The result is cached in a transient (cleared when a review or product changes) and memoized
	 * per request. Post, user and comment meta caches are primed in bulk, so building the list no
	 * longer runs several queries per review.
	 *
	 * @return array List of WP_Comment objects enriched with user avatar, product image,
	 *               product name, product rating, product URL, comment rating, and reviewer name.
	 */
	public static function get_woo_product_reviews() {
		if ( ! self::is_woocommerce_active() ) {
			return array();
		}

		if ( isset( self::$memo['reviews'] ) ) {
			return self::$memo['reviews'];
		}

		$cached = get_transient( self::REVIEWS_CACHE_KEY );
		if ( is_array( $cached ) ) {
			self::$memo['reviews'] = $cached;
			return $cached;
		}

		$comments = get_comments(
			array(
				'status'                    => 'approve',
				'post_status'               => 'publish',
				'post_type'                 => 'product',
				'update_comment_meta_cache' => true,
			)
		);

		if ( ! empty( $comments ) ) {
			$product_ids = array_unique( array_map( 'intval', wp_list_pluck( $comments, 'comment_post_ID' ) ) );
			$user_ids    = array_filter( array_unique( array_map( 'intval', wp_list_pluck( $comments, 'user_id' ) ) ) );

			_prime_post_caches( $product_ids, true, true );
			update_postmeta_cache( $product_ids );

			$thumbnail_ids = array();
			foreach ( $product_ids as $product_id ) {
				$thumbnail_id = (int) get_post_meta( $product_id, '_thumbnail_id', true );
				if ( $thumbnail_id ) {
					$thumbnail_ids[] = $thumbnail_id;
				}
			}
			if ( $thumbnail_ids ) {
				_prime_post_caches( array_unique( $thumbnail_ids ), false, true );
			}

			if ( $user_ids ) {
				cache_users( $user_ids );
			}
		}

		$products = array();

		foreach ( $comments as $comment ) {
			$product_id = (int) $comment->comment_post_ID;

			if ( ! array_key_exists( $product_id, $products ) ) {
				$products[ $product_id ] = wc_get_product( $product_id );
			}

			$product   = $products[ $product_id ];
			$user_data = $comment->user_id ? get_userdata( $comment->user_id ) : false;

			$comment->user_avatar       = get_avatar_url( $comment->user_id );
			$comment->product_image_url = get_the_post_thumbnail_url( $product_id );
			$comment->product_name      = $product ? esc_html( $product->get_title() ) : '';
			$comment->product_rating    = $product ? esc_html( $product->get_average_rating() ) : '';
			$comment->product_url       = $product ? $product->get_permalink() : '';
			$comment->comment_rating    = get_comment_meta( $comment->comment_ID, 'rating', true );
			$comment->reviewer_name     = isset( $user_data->display_name ) ? $user_data->display_name : '';
		}

		set_transient( self::REVIEWS_CACHE_KEY, $comments, 12 * HOUR_IN_SECONDS );
		self::$memo['reviews'] = $comments;

		return $comments;
	}

	/**
	 * Review count and average rating, computed once and cached with the review list.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @return array{total:int|string|null,avg:float|null}
	 */
	private static function get_woo_review_stats() {
		if ( isset( self::$memo['review_stats'] ) ) {
			return self::$memo['review_stats'];
		}

		$cached = get_transient( self::REVIEW_STATS_CACHE_KEY );
		if ( is_array( $cached ) ) {
			self::$memo['review_stats'] = $cached;
			return $cached;
		}

		global $wpdb;

		$total = $wpdb->get_var(
			"
				SELECT COUNT(*)
				FROM {$wpdb->comments}
				WHERE comment_type = 'review'
				AND comment_approved = 1
			"
		);

		$average_rating = $wpdb->get_var(
			"
				SELECT AVG(meta_value) as average_rating
				FROM {$wpdb->commentmeta} AS cm
				WHERE comment_id IN (
					SELECT comment_ID
					FROM {$wpdb->comments}
					WHERE comment_type = 'review' AND comment_approved = 1
				) AND meta_key = 'rating'
			"
		);

		$stats = array(
			'total' => $total,
			'avg'   => $average_rating ? round( $average_rating, 2 ) : null,
		);

		set_transient( self::REVIEW_STATS_CACHE_KEY, $stats, 12 * HOUR_IN_SECONDS );
		self::$memo['review_stats'] = $stats;

		return $stats;
	}

	/**
	 * Retrieves the total number of approved product reviews.
	 *
	 * @return int|string|null Total number of approved product reviews.
	 */
	public static function get_woo_total_product_reviews() {
		$stats = self::get_woo_review_stats();
		return $stats['total'];
	}

	/**
	 * Retrieves the average rating value of all approved product reviews.
	 *
	 * @return float|null Average rating rounded to 2 decimal places, or null if no ratings are found.
	 */
	public static function get_woo_avg_product_reviews() {
		$stats = self::get_woo_review_stats();
		return $stats['avg'];
	}

	/**
	 * Retrieves and returns the output of a custom post type template file.
	 *
	 * Checks if a template file exists in the plugin's `core/templates/` directory.
	 * If it does, the file is included and its output is captured and returned as a string.
	 *
	 * @param string $template The name of the template file (without the `.php` extension).
	 * @return string|null The buffered output of the template file, or null if the file doesn't exist.
	 */
	public static function get_cpt_template( $template ) {
		if ( file_exists( COZY_ADDONS_PLUGIN_DIR . 'core/templates/' . $template . '.php' ) ) {
			ob_start();

			include_once COZY_ADDONS_PLUGIN_DIR . 'core/templates/' . $template . '.php';

			return ob_get_clean();
		}
	}

	/**
	 * Retrieves a list of available Cozy Portfolio gallery templates.
	 *
	 * This static method returns an array of predefined gallery templates
	 * that can be used within the Cozy Portfolio block or plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return array An associative array where keys are template slugs and values are their labels.
	 */
	public static function get_cozy_portfolio_gallery_templates(): array {
		// Memoized per request only: render_block() enqueues block assets as a side effect,
		// so the rendered HTML must not be cached across requests.
		if ( isset( self::$memo['portfolio_templates'] ) ) {
			return self::$memo['portfolio_templates'];
		}

		$args = array(
			'post_type'      => 'ca_portfolio_gallery', // Specify the custom post type.
			'posts_per_page' => -1, // Display all posts.
			'post_status'    => 'publish',
		);

		// Get the posts as an array.
		$posts_array = get_posts( $args );

		// Generate render template.
		foreach ( $posts_array as $template ) {
			// code...

			$parsed_blocks = parse_blocks( $template->post_content );

			$template_render = '';

			foreach ( $parsed_blocks as $block ) {
				$template_render .= render_block( $block );
			}

			$template->render = $template_render;

			$template->featured_image       = get_the_post_thumbnail_url( $template->ID );
			$template->post_custom_category = get_the_terms( $template->ID, 'ca_portfolio_gallery_category' );

			// Retrieve custom post meta.
			$template->post_project_year = get_post_meta( $template->ID, 'ca_portfolio_gallery_project_year', true );
			$template->post_client       = get_post_meta( $template->ID, 'ca_portfolio_gallery_client', true );
			$template->post_skills       = get_post_meta( $template->ID, 'ca_portfolio_gallery_skills', true );
			$template->post_url          = get_post_meta( $template->ID, 'ca_portfolio_gallery_url', true );
		}

		self::$memo['portfolio_templates'] = $posts_array;

		return $posts_array;
	}
}
