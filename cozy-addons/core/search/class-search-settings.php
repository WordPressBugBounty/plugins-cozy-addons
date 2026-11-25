<?php
/**
 * Global settings of the Advanced Search block.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Search;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Reads, sanitizes and gates the search settings stored in one option.
 */
final class Search_Settings {

	const OPTION = 'ca_search_settings';
	const GROUP  = 'ca_search_settings_group';

	/**
	 * Per-request cache of the effective settings.
	 *
	 * @var array|null
	 */
	private static $cache = null;

	/**
	 * Clears the per-request cache when the option changes.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'update_option_' . self::OPTION, array( __CLASS__, 'flush' ) );
		add_action( 'add_option_' . self::OPTION, array( __CLASS__, 'flush' ) );
	}

	/**
	 * Forgets the cached settings.
	 *
	 * @return void
	 */
	public static function flush() {
		self::$cache = null;
	}

	/**
	 * Default settings.
	 *
	 * @return array
	 */
	public static function defaults() {
		return array(
			'post_types'           => array( 'post', 'page' ),
			'taxonomies'           => array( 'category', 'post_tag' ),
			'per_page'             => 8,
			'min_chars'            => 2,
			'debounce'             => 200,
			'cache_seconds'        => 300,
			'rate_limit'           => 60,
			'popular_limit'        => 6,
			'recent_limit'         => 6,
			'retention_days'       => 90,
			'meta_keys'            => '_sku',
			'synonyms'             => '',
			'exclude_ids'          => '',
			'search_content'       => 1,
			'search_terms'         => 1,
			'fuzzy_matching'       => 1,
			'group_results'        => 1,
			'taxonomy_suggestions' => 1,
			'query_suggestions'    => 1,
			'recent_searches'      => 1,
			'popular_searches'     => 1,
			'show_images'          => 1,
			'show_excerpts'        => 1,
			'highlight'            => 1,
			'show_tabs'            => 1,
			'show_view_all'        => 1,
			'load_more'            => 1,
			'shortcut'             => 1,
			'woo_enabled'          => 1,
			'track_searches'       => 1,
			'native_search'        => 0,
		);
	}

	/**
	 * On/off settings.
	 *
	 * @return string[]
	 */
	public static function flags() {
		return array(
			'search_content',
			'search_terms',
			'fuzzy_matching',
			'group_results',
			'taxonomy_suggestions',
			'query_suggestions',
			'recent_searches',
			'popular_searches',
			'show_images',
			'show_excerpts',
			'highlight',
			'show_tabs',
			'show_view_all',
			'load_more',
			'shortcut',
			'woo_enabled',
			'track_searches',
			'native_search',
		);
	}

	/**
	 * Settings that only work with Pro, and the value they take on free sites.
	 *
	 * @return array
	 */
	public static function pro_keys() {
		return array(
			'fuzzy_matching'    => 0,
			'synonyms'          => '',
			'meta_keys'         => '',
			'woo_enabled'       => 0,
			'popular_searches'  => 0,
			'query_suggestions' => 0,
			'native_search'     => 0,
			'load_more'         => 0,
			'recent_searches'   => 0,
		);
	}

	/**
	 * Saved settings merged with the defaults, Pro values included as saved.
	 *
	 * @return array
	 */
	public static function stored() {
		$o               = get_option( self::OPTION, array() );
		$o               = wp_parse_args( is_array( $o ) ? $o : array(), self::defaults() );
		$o['post_types'] = self::to_list( $o['post_types'] );
		$o['taxonomies'] = self::to_list( $o['taxonomies'] );

		return $o;
	}

	/**
	 * Effective settings: Pro features are off on free sites.
	 *
	 * @param string|null $key One setting, or all of them.
	 * @return mixed
	 */
	public static function get( $key = null ) {
		if ( null === self::$cache ) {
			$o = self::stored();
			if ( ! cozy_addons_premium_access() ) {
				$o = array_merge( $o, self::pro_keys() );
			}
			self::$cache = $o;
		}

		if ( null === $key ) {
			return self::$cache;
		}

		return isset( self::$cache[ $key ] ) ? self::$cache[ $key ] : null;
	}

	/**
	 * Accepts an array or a comma separated string; returns unique sanitized slugs.
	 *
	 * @param mixed $value List.
	 * @return string[]
	 */
	public static function to_list( $value ) {
		if ( is_string( $value ) ) {
			$value = explode( ',', $value );
		}
		if ( ! is_array( $value ) ) {
			return array();
		}
		$value = array_filter( array_map( 'sanitize_key', array_map( 'strval', $value ) ) );

		return array_values( array_unique( $value ) );
	}

	/**
	 * Whether a custom field key is safe to search.
	 *
	 * @param string $k Meta key.
	 * @return bool
	 */
	private static function valid_meta_key( $k ) {
		return (bool) preg_match( '/^[A-Za-z0-9_\-]{1,100}$/', $k );
	}

	/**
	 * Custom fields searched (Pro).
	 *
	 * @return string[]
	 */
	public static function meta_keys() {
		$keys = array_map( 'trim', explode( ',', (string) self::get( 'meta_keys' ) ) );
		$keys = array_filter( $keys, array( __CLASS__, 'valid_meta_key' ) );

		return array_values( array_unique( $keys ) );
	}

	/**
	 * Post IDs never shown in results.
	 *
	 * @return int[]
	 */
	public static function exclude_ids() {
		$ids = array_filter( array_map( 'absint', explode( ',', (string) self::get( 'exclude_ids' ) ) ) );

		return array_values( array_unique( $ids ) );
	}

	/**
	 * Synonym groups (Pro): "tee, t-shirt, tshirt" per line  =>  word => equivalent words.
	 *
	 * @return array<string,string[]>
	 */
	public static function synonym_map() {
		$map = array();
		foreach ( preg_split( '/\R/', (string) self::get( 'synonyms' ) ) as $line ) {
			$words = array();
			foreach ( explode( ',', $line ) as $w ) {
				$w = mb_strtolower( trim( $w ) );
				if ( '' !== $w ) {
					$words[] = $w;
				}
			}
			$words = array_values( array_unique( $words ) );
			if ( count( $words ) < 2 ) {
				continue;
			}
			foreach ( $words as $w ) {
				$others    = array_values( array_diff( $words, array( $w ) ) );
				$map[ $w ] = isset( $map[ $w ] ) ? array_values( array_unique( array_merge( $map[ $w ], $others ) ) ) : $others;
			}
		}

		return $map;
	}

	/**
	 * Sanitizes the settings form. Free sites cannot edit the Pro settings, so their saved values are kept.
	 *
	 * @param mixed $in Raw input.
	 * @return array
	 */
	public static function sanitize( $in ) {
		$d   = self::defaults();
		$in  = is_array( $in ) ? $in : array();
		$out = array();

		$public            = array_keys( get_post_types( array( 'public' => true ) ) );
		$types             = array_values( array_intersect( self::to_list( isset( $in['post_types'] ) ? $in['post_types'] : array() ), $public ) );
		$out['post_types'] = $types ? $types : $d['post_types'];

		$public_tax        = array_keys( get_taxonomies( array( 'public' => true ) ) );
		$out['taxonomies'] = array_values( array_intersect( self::to_list( isset( $in['taxonomies'] ) ? $in['taxonomies'] : array() ), $public_tax ) );

		$ranges = array(
			'per_page'       => array( 1, 20 ),
			'min_chars'      => array( 1, 5 ),
			'debounce'       => array( 0, 2000 ),
			'popular_limit'  => array( 0, 20 ),
			'recent_limit'   => array( 0, 20 ),
			'cache_seconds'  => array( 0, 86400 ),
			'rate_limit'     => array( 0, 1000 ),
			'retention_days' => array( 7, 730 ),
		);
		foreach ( $ranges as $k => $r ) {
			$v         = isset( $in[ $k ] ) ? absint( $in[ $k ] ) : $d[ $k ];
			$out[ $k ] = min( $r[1], max( $r[0], $v ) );
		}
		foreach ( self::flags() as $k ) {
			$out[ $k ] = empty( $in[ $k ] ) ? 0 : 1;
		}

		$meta             = isset( $in['meta_keys'] ) ? explode( ',', sanitize_text_field( $in['meta_keys'] ) ) : array();
		$meta             = array_filter( array_map( 'trim', $meta ), array( __CLASS__, 'valid_meta_key' ) );
		$out['meta_keys'] = implode( ',', array_unique( $meta ) );

		$syn             = isset( $in['synonyms'] ) ? sanitize_textarea_field( $in['synonyms'] ) : '';
		$out['synonyms'] = implode( "\n", array_slice( preg_split( '/\R/', $syn ), 0, 100 ) );

		$ids                = isset( $in['exclude_ids'] ) ? explode( ',', (string) $in['exclude_ids'] ) : array();
		$out['exclude_ids'] = implode( ',', array_unique( array_filter( array_map( 'absint', $ids ) ) ) );

		// Pro settings keep their saved values on free sites.
		if ( ! cozy_addons_premium_access() ) {
			$stored = self::stored();
			foreach ( array_keys( self::pro_keys() ) as $k ) {
				$out[ $k ] = $stored[ $k ];
			}
		}

		return $out;
	}
}
