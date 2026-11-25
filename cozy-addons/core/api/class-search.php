<?php
/**
 * Public endpoints of the Advanced Search block.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Api;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CozyAddons\Core\Search\Search_Settings;
use CozyAddons\Core\Search\Search_Engine;
use CozyAddons\Core\Search\Search_Analytics;

/**
 * Live search, popular searches (Pro) and search tracking.
 *
 * Results are public content, and the block is often served from a page cache, so these routes
 * take no nonce. Expensive (uncached) searches and tracking are rate limited per visitor instead.
 */
class Search {

	const NS = 'cozy-block/v1';

	/**
	 * Holds the singleton instance.
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * Retrieves the singleton instance.
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
	 * Class constructor. Registers the routes.
	 */
	private function __construct() {
		self::register();
	}

	/**
	 * Registers the routes.
	 *
	 * @return void
	 */
	public static function register() {
		register_rest_route( self::NS, '/search', array(
			'methods'             => \WP_REST_Server::READABLE,
			'permission_callback' => '__return_true',
			'callback'            => array( __CLASS__, 'search' ),
			'args'                => array(
				's'          => array( 'required' => true, 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
				'post_types' => array( 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ),
				'taxonomies' => array( 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ),
				'per_page'   => array( 'type' => 'integer', 'default' => 0, 'sanitize_callback' => 'absint' ),
				'page'       => array( 'type' => 'integer', 'default' => 1, 'sanitize_callback' => 'absint' ),
				'fuzzy'      => array( 'type' => 'boolean', 'default' => true ),
			),
		) );

		register_rest_route( self::NS, '/search-popular', array(
			'methods'             => \WP_REST_Server::READABLE,
			'permission_callback' => '__return_true',
			'callback'            => array( __CLASS__, 'popular' ),
		) );

		// Searches are recorded on free and Pro sites alike; only viewing them (Insights) is Pro.
		register_rest_route( self::NS, '/search-track', array(
			'methods'             => \WP_REST_Server::CREATABLE,
			'permission_callback' => '__return_true',
			'callback'            => array( __CLASS__, 'track' ),
			'args'                => array(
				's'          => array( 'required' => true, 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
				'event'      => array( 'type' => 'string', 'default' => 'search', 'enum' => array( 'search', 'click' ) ),
				'post_types' => array( 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ),
				'per_page'   => array( 'type' => 'integer', 'default' => 0, 'sanitize_callback' => 'absint' ),
			),
		) );
	}

	private static function respond( $payload, $max_age = 30 ) {
		$res = rest_ensure_response( $payload );
		$res->header( 'Cache-Control', 'public, max-age=' . (int) $max_age );
		return $res;
	}

	/** Client identifier used only for throttling; hashed and never stored in the analytics table. */
	private static function client_id() {
		$ip = apply_filters( 'cozy_addons_search_client_ip', isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '' );
		return substr( wp_hash( (string) $ip ), 0, 16 );
	}

	/** Fixed-window limiter. Returns false when the client is over the limit. */
	private static function allow( $bucket, $limit ) {
		$limit = (int) apply_filters( 'cozy_addons_search_rate_limit', $limit, $bucket );
		if ( $limit <= 0 ) {
			return true;
		}
		$key = 'ca_search_rl_' . $bucket . '_' . self::client_id();
		$d   = get_transient( $key );
		if ( ! is_array( $d ) || $d['t'] < time() - 60 ) {
			$d = array( 'n' => 0, 't' => time() );
		}
		if ( $d['n'] >= $limit ) {
			return false;
		}
		$d['n']++;
		set_transient( $key, $d, 60 );
		return true;
	}

	private static function args_from( \WP_REST_Request $r ) {
		return Search_Engine::normalize_args( array(
			'types'      => $r->get_param( 'post_types' ),
			'taxonomies' => $r->get_param( 'taxonomies' ),
			'per_page'   => $r->get_param( 'per_page' ),
			// Loading further pages ("Show more results") is Pro.
			'page'       => cozy_addons_premium_access() ? $r->get_param( 'page' ) : 1,
			'fuzzy'      => $r->get_param( 'fuzzy' ),
		) );
	}

	public static function search( \WP_REST_Request $r ) {
		$s    = Search_Settings::get();
		$term = Search_Engine::clean_term( (string) $r->get_param( 's' ) );

		if ( mb_strlen( $term ) < max( 1, (int) $s['min_chars'] ) ) {
			return self::respond( array(
				'term' => $term, 'results' => array(), 'hasMore' => false, 'page' => 1,
				'fuzzy' => false, 'corrected' => null, 'suggestions' => array(), 'queries' => array(),
			) );
		}

		$args = self::args_from( $r );
		$key  = Search_Engine::cache_key( $term, $args );
		$hit  = Search_Engine::cache_get( $key );
		if ( is_array( $hit ) ) {
			return self::respond( self::gate_more( $hit ) );
		}

		// Only uncached (expensive) searches count against the limit.
		if ( ! self::allow( 'search', (int) $s['rate_limit'] ) ) {
			return new \WP_Error( 'ca_search_rate_limited', __( 'Too many searches. Please wait a moment.', 'cozy-addons' ), array( 'status' => 429 ) );
		}

		$payload = Search_Engine::search( $term, $args );
		Search_Engine::cache_set( $key, $payload );
		return self::respond( self::gate_more( $payload ) );
	}

	/**
	 * Loading more results is Pro. Free sites never get "hasMore", so the "Show more results" button
	 * cannot appear whatever the page markup or script says. "truncated" still lets the count read "8+".
	 * Applied after the cache, because cached payloads are shared and the plan can change.
	 *
	 * @param array $payload Search payload.
	 * @return array
	 */
	private static function gate_more( $payload ) {
		if ( ! cozy_addons_premium_access() ) {
			$payload['truncated'] = ! empty( $payload['hasMore'] );
			$payload['hasMore']   = false;
		}
		return $payload;
	}

	public static function popular() {
		$s = Search_Settings::get();
		return self::respond( array(
			'popular' => $s['popular_searches'] ? Search_Analytics::popular( (int) $s['popular_limit'] ) : array(),
		), 300 );
	}

	public static function track( \WP_REST_Request $r ) {
		$s    = Search_Settings::get();
		$ok   = rest_ensure_response( array( 'ok' => true ) );
		$term = Search_Analytics::normalize( (string) $r->get_param( 's' ) );
		if ( empty( $s['track_searches'] ) || '' === $term || ! self::allow( 'track', 30 ) ) {
			return $ok;
		}
		$event = 'click' === $r->get_param( 'event' ) ? 'click' : 'search';

		// One count per visitor, per term and event, for a while: prevents inflating popular searches.
		$lock = 'ca_search_tk_' . md5( $event . '|' . $term . '|' . self::client_id() );
		if ( get_transient( $lock ) ) {
			return $ok;
		}
		set_transient( $lock, 1, 'click' === $event ? 5 * MINUTE_IN_SECONDS : 10 * MINUTE_IN_SECONDS );

		if ( 'click' === $event ) {
			Search_Analytics::click( $term );
			return $ok;
		}

		// Result count is computed server-side (usually a cache hit) rather than trusted from the client.
		if ( mb_strlen( $term ) >= max( 1, (int) $s['min_chars'] ) ) {
			$args = self::args_from( $r );
			$key  = Search_Engine::cache_key( Search_Engine::clean_term( (string) $r->get_param( 's' ) ), $args );
			$hit  = Search_Engine::cache_get( $key );
			if ( ! is_array( $hit ) ) {
				$hit = Search_Engine::search( Search_Engine::clean_term( (string) $r->get_param( 's' ) ), $args );
			}
			Search_Analytics::record( $term, count( $hit['results'] ) );
		}
		return $ok;
	}
}
