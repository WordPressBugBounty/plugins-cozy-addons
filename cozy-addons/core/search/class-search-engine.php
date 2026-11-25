<?php
/**
 * Relevance engine of the Advanced Search block.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Search;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Search engine: weighted relevance ranking (title > excerpt > content > SKU / terms),
 * quoted phrases, -exclusions, synonyms, typo tolerance, "did you mean",
 * contextual snippets and WooCommerce product data.
 *
 * It runs through WP_Query, so post status, passwords, multilingual plugins and
 * other query filters keep working.
 */
final class Search_Engine {

	private static $bumped = false;

	public static function init() {
		add_filter( 'posts_search', array( __CLASS__, 'filter_search' ), 10, 2 );
		add_filter( 'posts_fields', array( __CLASS__, 'filter_fields' ), 10, 2 );
		add_filter( 'posts_orderby', array( __CLASS__, 'filter_orderby' ), 10, 2 );

		$invalidate = array(
			'save_post', 'deleted_post', 'set_object_terms', 'created_term', 'edited_term', 'delete_term',
			'update_option_' . Search_Settings::OPTION,
			'woocommerce_update_product', 'woocommerce_product_set_stock_status', 'woocommerce_variation_set_stock_status',
		);
		foreach ( $invalidate as $hook ) {
			add_action( $hook, array( __CLASS__, 'bump' ) );
		}
	}

	/* ------------------------------------------------------------------ cache */

	public static function bump() {
		if ( self::$bumped ) {
			return;
		}
		self::$bumped = true;
		update_option( 'ca_search_cache_version', (string) microtime( true ) );
	}

	public static function cache_key( $term, $args ) {
		return 'ca_search_' . md5( get_option( 'ca_search_cache_version', '1' ) . '|' . wp_json_encode( array( $term, $args ) ) );
	}

	public static function cache_get( $key ) {
		return wp_using_ext_object_cache() ? wp_cache_get( $key, 'ca_search' ) : get_transient( $key );
	}

	public static function cache_set( $key, $value, $ttl = null ) {
		$ttl = null === $ttl ? (int) Search_Settings::get( 'cache_seconds' ) : (int) $ttl;
		if ( $ttl <= 0 ) {
			return;
		}
		if ( wp_using_ext_object_cache() ) {
			wp_cache_set( $key, $value, 'ca_search', $ttl );
		} else {
			set_transient( $key, $value, $ttl );
		}
	}

	/* ---------------------------------------------------------------- helpers */

	public static function woo() {
		return class_exists( 'WooCommerce' ) && function_exists( 'wc_get_product' ) && Search_Settings::get( 'woo_enabled' );
	}

	public static function resolve_types( $list ) {
		$public = get_post_types( array( 'public' => true ), 'names' );
		$types  = array_values( array_intersect( Search_Settings::to_list( $list ), $public ) );
		if ( ! $types ) {
			$types = array_values( array_intersect( Search_Settings::get( 'post_types' ), $public ) );
		}
		return $types ? $types : array( 'post', 'page' );
	}

	public static function resolve_taxonomies( $list ) {
		$public = get_taxonomies( array( 'public' => true ), 'names' );
		return array_values( array_intersect( Search_Settings::to_list( $list ), $public ) );
	}

	public static function clean_term( $term ) {
		$t = sanitize_text_field( (string) $term );
		$t = trim( preg_replace( '/\s+/u', ' ', $t ) );
		return mb_substr( $t, 0, 100 );
	}

	/** Normalises request arguments (shared by the REST route and the native search page). */
	public static function normalize_args( $raw ) {
		$s        = Search_Settings::get();
		$per_page = isset( $raw['per_page'] ) ? absint( $raw['per_page'] ) : 0;
		$page     = isset( $raw['page'] ) ? absint( $raw['page'] ) : 1;
		$types    = isset( $raw['types'] ) ? $raw['types'] : '';
		$tax      = isset( $raw['taxonomies'] ) && '' !== $raw['taxonomies'] ? $raw['taxonomies'] : $s['taxonomies'];
		return array(
			'types'      => self::resolve_types( $types ),
			'taxonomies' => self::resolve_taxonomies( $tax ),
			'per_page'   => min( 20, max( 1, $per_page ? $per_page : (int) $s['per_page'] ) ),
			'page'       => min( 50, max( 1, $page ) ),
			'fuzzy'      => ! empty( $raw['fuzzy'] ) && ! empty( $s['fuzzy_matching'] ),
		);
	}

	/**
	 * Splits a query into include / exclude parts.
	 * Supports "exact phrases" and -excluded words.
	 */
	public static function parse( $term ) {
		$include = array();
		$exclude = array();
		if ( preg_match_all( '/(-?)"([^"]+)"|(-?)([^\s"]+)/u', $term, $m, PREG_SET_ORDER ) ) {
			foreach ( $m as $x ) {
				if ( isset( $x[2] ) && '' !== $x[2] ) {
					$neg  = ( '-' === $x[1] );
					$text = $x[2];
				} else {
					$neg  = ( isset( $x[3] ) && '-' === $x[3] );
					$text = isset( $x[4] ) ? $x[4] : '';
				}
				$text = trim( $text );
				if ( '' === $text || ! preg_match( '/[\p{L}\p{N}]/u', $text ) ) {
					continue;
				}
				$text = mb_substr( $text, 0, 60 );
				if ( $neg ) {
					$exclude[] = $text;
				} else {
					$include[] = $text;
				}
			}
		}
		return array(
			'include' => array_slice( self::unique_ci( $include ), 0, 6 ),
			'exclude' => array_slice( self::unique_ci( $exclude ), 0, 4 ),
		);
	}

	private static function unique_ci( $list ) {
		$seen = array();
		$out  = array();
		foreach ( $list as $v ) {
			$k = mb_strtolower( $v );
			if ( ! isset( $seen[ $k ] ) ) {
				$seen[ $k ] = true;
				$out[]      = $v;
			}
		}
		return $out;
	}

	private static function alternatives( $token, $synonyms ) {
		$alts = array( $token );
		$k    = mb_strtolower( $token );
		if ( isset( $synonyms[ $k ] ) ) {
			$alts = array_merge( $alts, array_slice( $synonyms[ $k ], 0, 5 ) );
		}
		return $alts;
	}

	/* ------------------------------------------------------------ SQL builder */

	private static function in_placeholders( $list ) {
		return implode( ',', array_fill( 0, count( $list ), '%s' ) );
	}

	/**
	 * Builds the WHERE and the relevance expression.
	 * Every include token must match somewhere (AND); each token may match title,
	 * excerpt, content, configured meta (SKU) or a taxonomy term name (OR).
	 */
	private static function build_sql( $parsed, $opts ) {
		global $wpdb;
		$p        = $wpdb->posts;
		$synonyms = Search_Settings::synonym_map();
		$meta     = $opts['meta'];
		$tax      = $opts['taxonomies'];
		$where    = array();
		$score    = array();

		foreach ( $parsed['include'] as $tok ) {
			$conds = array();
			foreach ( self::alternatives( $tok, $synonyms ) as $alt ) {
				$like = '%' . $wpdb->esc_like( $alt ) . '%';
				$c    = array(
					$wpdb->prepare( "{$p}.post_title LIKE %s", $like ),
					$wpdb->prepare( "{$p}.post_excerpt LIKE %s", $like ),
				);
				if ( $opts['content'] ) {
					$c[] = $wpdb->prepare( "{$p}.post_content LIKE %s", $like );
				}
				if ( $meta ) {
					$c[] = $wpdb->prepare(
						"EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm WHERE pm.post_id = {$p}.ID AND pm.meta_key IN (" . self::in_placeholders( $meta ) . ') AND pm.meta_value LIKE %s)',
						array_merge( $meta, array( $like ) )
					);
				}
				if ( $opts['terms'] && $tax ) {
					$c[] = $wpdb->prepare(
						"EXISTS (SELECT 1 FROM {$wpdb->term_relationships} tr INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id WHERE tr.object_id = {$p}.ID AND tt.taxonomy IN (" . self::in_placeholders( $tax ) . ') AND t.name LIKE %s)',
						array_merge( $tax, array( $like ) )
					);
				}
				$conds[] = '(' . implode( ' OR ', $c ) . ')';
			}
			$where[] = '(' . implode( ' OR ', $conds ) . ')';

			$like    = '%' . $wpdb->esc_like( $tok ) . '%';
			$score[] = $wpdb->prepare( "(CASE WHEN {$p}.post_title LIKE %s THEN 14 ELSE 0 END)", $like );
			$score[] = $wpdb->prepare( "(CASE WHEN {$p}.post_excerpt LIKE %s THEN 5 ELSE 0 END)", $like );
			if ( $opts['content'] ) {
				$score[] = $wpdb->prepare( "(CASE WHEN {$p}.post_content LIKE %s THEN 2 ELSE 0 END)", $like );
			}
		}

		foreach ( $parsed['exclude'] as $tok ) {
			$like    = '%' . $wpdb->esc_like( $tok ) . '%';
			$where[] = $wpdb->prepare(
				"({$p}.post_title NOT LIKE %s AND {$p}.post_excerpt NOT LIKE %s AND {$p}.post_content NOT LIKE %s)",
				$like,
				$like,
				$like
			);
		}

		// Whole-phrase bonuses.
		$phrase  = implode( ' ', $parsed['include'] );
		$score[] = $wpdb->prepare( "(CASE WHEN {$p}.post_title = %s THEN 120 ELSE 0 END)", $phrase );
		$score[] = $wpdb->prepare( "(CASE WHEN {$p}.post_title LIKE %s THEN 70 ELSE 0 END)", $wpdb->esc_like( $phrase ) . '%' );
		$score[] = $wpdb->prepare( "(CASE WHEN {$p}.post_title LIKE %s THEN 45 ELSE 0 END)", '%' . $wpdb->esc_like( $phrase ) . '%' );
		if ( $meta ) {
			$score[] = $wpdb->prepare(
				"(CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm2 WHERE pm2.post_id = {$p}.ID AND pm2.meta_key IN (" . self::in_placeholders( $meta ) . ') AND pm2.meta_value = %s) THEN 100 ELSE 0 END)',
				array_merge( $meta, array( $phrase ) )
			);
		}

		return array(
			'where' => ' AND (' . implode( ' AND ', $where ) . ') ',
			'score' => '(' . implode( ' + ', $score ) . ')',
		);
	}

	public static function filter_search( $search, $q ) {
		$sql = $q->get( 'ca_search_sql' );
		if ( is_array( $sql ) ) {
			return $sql['where'];
		}
		if ( $q->get( 'ca_search_native' ) ) {
			return '';
		}
		return $search;
	}

	public static function filter_fields( $fields, $q ) {
		$sql = $q->get( 'ca_search_sql' );
		if ( is_array( $sql ) ) {
			return $fields . ', ' . $sql['score'] . ' AS ca_search_score';
		}
		return $fields;
	}

	public static function filter_orderby( $orderby, $q ) {
		global $wpdb;
		if ( is_array( $q->get( 'ca_search_sql' ) ) ) {
			return "ca_search_score DESC, {$wpdb->posts}.post_date DESC";
		}
		return $orderby;
	}

	private static function base_args( $types ) {
		$args = array(
			'post_type'              => $types,
			'post_status'            => 'publish',
			'has_password'           => false,
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'suppress_filters'       => false,
			'update_post_term_cache' => false,
		);
		$exclude = Search_Settings::exclude_ids();
		if ( $exclude ) {
			$args['post__not_in'] = $exclude;
		}
		if ( in_array( 'product', $types, true ) && self::woo() ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => array( 'exclude-from-search' ),
					'operator' => 'NOT IN',
				),
			);
		}
		return $args;
	}

	private static function opts( $taxonomies ) {
		return array(
			'content'    => (bool) Search_Settings::get( 'search_content' ),
			'terms'      => (bool) Search_Settings::get( 'search_terms' ),
			'meta'       => Search_Settings::meta_keys(),
			'taxonomies' => $taxonomies,
		);
	}

	/** Runs the ranked query. Returns WP_Post objects (or IDs) plus a "has more" flag. */
	private static function query( $parsed, $types, $per_page, $page, $opts, $ids_only = false ) {
		if ( empty( $parsed['include'] ) ) {
			return array( 'posts' => array(), 'more' => false );
		}
		$args                   = self::base_args( $types );
		$args['ca_search_sql']      = self::build_sql( $parsed, $opts );
		$args['orderby']        = 'none';
		$args['posts_per_page'] = $per_page + 1;
		$args['offset']         = ( $page - 1 ) * $per_page;
		if ( $ids_only ) {
			$args['fields'] = 'ids';
		}
		$q     = new \WP_Query( $args );
		$posts = $q->posts;
		$more  = count( $posts ) > $per_page;
		return array( 'posts' => array_slice( $posts, 0, $per_page ), 'more' => $more );
	}

	private static function fetch_ids( $ids, $types ) {
		if ( ! $ids ) {
			return array();
		}
		$args                   = self::base_args( $types );
		$args['post__in']       = $ids;
		$args['orderby']        = 'post__in';
		$args['posts_per_page'] = count( $ids );
		$q                      = new \WP_Query( $args );
		return $q->posts;
	}

	/* ------------------------------------------------------------ fuzzy match */

	/** Cached index of title words (for typo tolerance). Rebuilt when content changes. */
	private static function index( $types ) {
		global $wpdb;
		$key = 'ca_search_idx_' . md5( get_option( 'ca_search_cache_version', '1' ) . implode( ',', $types ) );
		$hit = self::cache_get( $key );
		if ( is_array( $hit ) ) {
			return $hit;
		}
		$limit = (int) apply_filters( 'cozy_addons_search_fuzzy_index_limit', 4000 );
		$rows  = $wpdb->get_results( $wpdb->prepare(
			"SELECT ID, post_title FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_password = '' AND post_type IN (" . self::in_placeholders( $types ) . ') ORDER BY post_date DESC LIMIT %d',
			array_merge( $types, array( $limit ) )
		) );
		$titles = array();
		$vocab  = array();
		foreach ( (array) $rows as $r ) {
			$t     = mb_strtolower( html_entity_decode( wp_strip_all_tags( $r->post_title ), ENT_QUOTES, 'UTF-8' ) );
			$words = preg_split( '/[^\p{L}\p{N}]+/u', $t, -1, PREG_SPLIT_NO_EMPTY );
			$words = array_values( array_filter( $words, function ( $w ) {
				return mb_strlen( $w ) >= 2 && mb_strlen( $w ) <= 40;
			} ) );
			if ( ! $words ) {
				continue;
			}
			$titles[ (int) $r->ID ] = $words;
			foreach ( $words as $w ) {
				$vocab[ $w ] = isset( $vocab[ $w ] ) ? $vocab[ $w ] + 1 : 1;
			}
		}
		$idx = array( 'titles' => $titles, 'vocab' => $vocab );
		self::cache_set( $key, $idx, 12 * HOUR_IN_SECONDS );
		return $idx;
	}

	/** Optimal-string-alignment distance (insert/delete/substitute/transpose) with early exit. */
	private static function dist( $a, $b, $max ) {
		$x = preg_split( '//u', $a, -1, PREG_SPLIT_NO_EMPTY );
		$y = preg_split( '//u', $b, -1, PREG_SPLIT_NO_EMPTY );
		$m = count( $x );
		$n = count( $y );
		if ( abs( $m - $n ) > $max ) {
			return $max + 1;
		}
		$prev2 = array();
		$prev  = range( 0, $n );
		for ( $i = 1; $i <= $m; $i++ ) {
			$cur = array( $i );
			$min = $i;
			for ( $j = 1; $j <= $n; $j++ ) {
				$cost = ( $x[ $i - 1 ] === $y[ $j - 1 ] ) ? 0 : 1;
				$v    = min( $prev[ $j ] + 1, $cur[ $j - 1 ] + 1, $prev[ $j - 1 ] + $cost );
				if ( $i > 1 && $j > 1 && $x[ $i - 1 ] === $y[ $j - 2 ] && $x[ $i - 2 ] === $y[ $j - 1 ] ) {
					$v = min( $v, $prev2[ $j - 2 ] + 1 );
				}
				$cur[ $j ] = $v;
				$min       = min( $min, $v );
			}
			if ( $min > $max ) {
				return $max + 1;
			}
			$prev2 = $prev;
			$prev  = $cur;
		}
		return $prev[ $n ];
	}

	/**
	 * Finds posts whose titles contain every query word allowing typos / prefixes.
	 * Also proposes a corrected query ("did you mean").
	 */
	public static function fuzzy( $include, $types, $limit ) {
		$words = array();
		foreach ( $include as $t ) {
			foreach ( preg_split( '/[^\p{L}\p{N}]+/u', mb_strtolower( $t ), -1, PREG_SPLIT_NO_EMPTY ) as $w ) {
				$words[] = $w;
			}
		}
		$words = array_slice( array_values( array_unique( $words ) ), 0, 6 );
		$empty = array( 'ids' => array(), 'corrected' => null );
		if ( ! $words ) {
			return $empty;
		}
		$idx = self::index( $types );
		if ( empty( $idx['titles'] ) ) {
			return $empty;
		}
		$vocab     = $idx['vocab'];
		$map       = array();
		$corrected = array();
		$changed   = false;

		foreach ( $words as $tok ) {
			$map[ $tok ] = array();
			$lt          = mb_strlen( $tok );
			$max         = ( $lt <= 3 ) ? 0 : ( ( $lt <= 6 ) ? 1 : 2 );
			$best        = null;
			$best_sim    = 0;
			$best_freq   = 0;
			foreach ( $vocab as $w => $freq ) {
				$w = (string) $w;
				if ( $w === $tok ) {
					$map[ $tok ][ $w ] = 1.0;
					continue;
				}
				if ( $lt >= 3 && 0 === mb_strpos( $w, $tok ) ) {
					$map[ $tok ][ $w ] = 0.9;
					continue;
				}
				if ( ! $max ) {
					continue;
				}
				$lw = mb_strlen( $w );
				if ( abs( $lw - $lt ) > $max ) {
					continue;
				}
				$d = self::dist( $tok, $w, $max );
				if ( $d > $max ) {
					continue;
				}
				$sim               = max( 0.4, 1 - $d / max( $lt, $lw ) );
				$map[ $tok ][ $w ] = $sim;
				if ( $sim > $best_sim || ( $sim === $best_sim && $freq > $best_freq ) ) {
					$best      = $w;
					$best_sim  = $sim;
					$best_freq = $freq;
				}
			}
			if ( isset( $vocab[ $tok ] ) ) {
				$corrected[] = $tok;
			} elseif ( null !== $best ) {
				$corrected[] = $best;
				$changed     = true;
			} else {
				$corrected[] = $tok;
			}
		}

		$scored = array();
		foreach ( $idx['titles'] as $id => $title_words ) {
			$total = 0;
			foreach ( $words as $tok ) {
				$b = 0;
				foreach ( $title_words as $w ) {
					if ( isset( $map[ $tok ][ $w ] ) && $map[ $tok ][ $w ] > $b ) {
						$b = $map[ $tok ][ $w ];
					}
				}
				if ( $b <= 0 ) {
					continue 2;
				}
				$total += $b;
			}
			$scored[ $id ] = $total;
		}
		arsort( $scored );

		return array(
			'ids'       => array_slice( array_keys( $scored ), 0, $limit ),
			'corrected' => $changed ? implode( ' ', $corrected ) : null,
		);
	}

	/* ---------------------------------------------------------------- results */

	private static function text( $s ) {
		return html_entity_decode( wp_strip_all_tags( (string) $s ), ENT_QUOTES, 'UTF-8' );
	}

	/** Snippet centred on the first match in the content, falling back to the excerpt. */
	private static function snippet( $post, $tokens ) {
		$plain  = self::text( strip_shortcodes( $post->post_content ) );
		$plain  = trim( preg_replace( '/\s+/u', ' ', $plain ) );
		$manual = trim( preg_replace( '/\s+/u', ' ', self::text( $post->post_excerpt ) ) );

		foreach ( $tokens as $t ) {
			if ( '' !== $manual && false !== mb_stripos( $manual, $t ) ) {
				return wp_trim_words( $manual, 30 );
			}
		}
		foreach ( $tokens as $t ) {
			$pos = mb_stripos( $plain, $t );
			if ( false !== $pos ) {
				$start = max( 0, $pos - 70 );
				$text  = mb_substr( $plain, $start, 180 );
				if ( $start > 0 ) {
					$text = '… ' . preg_replace( '/^\S*\s/u', '', $text );
				}
				if ( $start + 180 < mb_strlen( $plain ) ) {
					$text .= ' …';
				}
				return $text;
			}
		}
		return '' !== $manual ? wp_trim_words( $manual, 30 ) : wp_trim_words( $plain, 28 );
	}

	private static function price_text( $amount ) {
		return html_entity_decode( wp_strip_all_tags( wc_price( $amount ) ), ENT_QUOTES, 'UTF-8' );
	}

	private static function format( $p, $tokens, $woo ) {
		$obj   = get_post_type_object( $p->post_type );
		$title = self::text( get_the_title( $p ) );
		$item  = array(
			'id'          => (int) $p->ID,
			'title'       => '' !== $title ? $title : __( '(no title)', 'cozy-addons' ),
			'url'         => get_permalink( $p ),
			'excerpt'     => self::snippet( $p, $tokens ),
			'type'        => $p->post_type,
			'typeLabel'   => $obj ? $obj->labels->singular_name : $p->post_type,
			'typePlural'  => $obj ? $obj->labels->name : $p->post_type,
			'image'       => (string) get_the_post_thumbnail_url( $p->ID, 'thumbnail' ),
			'date'        => ( ! is_post_type_hierarchical( $p->post_type ) && 'product' !== $p->post_type ) ? get_the_date( '', $p ) : '',
		);
		if ( $woo && 'product' === $p->post_type ) {
			$pr = wc_get_product( $p->ID );
			if ( $pr ) {
				if ( $pr->is_type( 'variable' ) ) {
					$min   = $pr->get_variation_price( 'min' );
					$max   = $pr->get_variation_price( 'max' );
					$price = ( $min === $max ) ? self::price_text( $min ) : self::price_text( $min ) . ' – ' . self::price_text( $max );
				} else {
					$price = '' === $pr->get_price() ? '' : self::price_text( $pr->get_price() );
				}
				$item['price']        = $price;
				$item['onSale']       = (bool) $pr->is_on_sale();
				$item['regularPrice'] = ( $pr->is_on_sale() && ! $pr->is_type( 'variable' ) && '' !== $pr->get_regular_price() ) ? self::price_text( $pr->get_regular_price() ) : '';
				$item['inStock']      = (bool) $pr->is_in_stock();
				$item['sku']          = (string) $pr->get_sku();
				$item['rating']       = (float) $pr->get_average_rating();
				$item['ratingCount']  = (int) $pr->get_rating_count();
			}
		}
		return apply_filters( 'cozy_addons_search_result_item', $item, $p );
	}

	public static function tax_suggestions( $term, $taxonomies, $limit = 5 ) {
		$out = array();
		foreach ( $taxonomies as $tax ) {
			$terms = get_terms( array(
				'taxonomy'   => $tax,
				'name__like' => $term,
				'number'     => $limit,
				'hide_empty' => true,
				'orderby'    => 'count',
				'order'      => 'DESC',
			) );
			if ( is_wp_error( $terms ) ) {
				continue;
			}
			$obj = get_taxonomy( $tax );
			foreach ( $terms as $t ) {
				$link = get_term_link( $t );
				if ( is_wp_error( $link ) ) {
					continue;
				}
				$out[] = array(
					'id'            => (int) $t->term_id,
					'name'          => self::text( $t->name ),
					'count'         => (int) $t->count,
					'url'           => $link,
					'taxonomy'      => $tax,
					'taxonomyLabel' => $obj ? $obj->labels->singular_name : $tax,
				);
			}
		}
		usort( $out, function ( $a, $b ) {
			return $b['count'] - $a['count'];
		} );
		return array_slice( $out, 0, $limit );
	}

	/** Full payload for the REST endpoint. */
	public static function search( $term, $args ) {
		$parsed = self::parse( $term );
		$opts   = self::opts( $args['taxonomies'] );
		$res    = self::query( $parsed, $args['types'], $args['per_page'], $args['page'], $opts );
		$posts  = $res['posts'];
		$more   = $res['more'];
		$fuzzy  = false;
		$fixed  = null;

		if ( ! $posts && 1 === $args['page'] && $args['fuzzy'] && $parsed['include'] ) {
			$f     = self::fuzzy( $parsed['include'], $args['types'], $args['per_page'] );
			$fixed = $f['corrected'];
			if ( $f['ids'] ) {
				$posts = self::fetch_ids( $f['ids'], $args['types'] );
				$more  = false;
				$fuzzy = true;
			}
		}

		$tokens = $parsed['include'];
		if ( $fixed ) {
			$tokens = array_merge( $tokens, explode( ' ', $fixed ) );
		}
		$woo     = self::woo();
		$results = array();
		foreach ( $posts as $p ) {
			$results[] = self::format( $p, $tokens, $woo );
		}

		$s = Search_Settings::get();
		return array(
			'term'        => $term,
			'results'     => $results,
			'hasMore'     => $more,
			'page'        => $args['page'],
			'fuzzy'       => $fuzzy,
			'corrected'   => $fixed,
			'suggestions' => ( 1 === $args['page'] && $s['taxonomy_suggestions'] && $args['taxonomies'] ) ? self::tax_suggestions( $term, $args['taxonomies'] ) : array(),
			'queries'     => ( 1 === $args['page'] && $s['query_suggestions'] ) ? Search_Analytics::suggest( $term ) : array(),
		);
	}

	/** Ranked IDs for the native search results page. */
	public static function ids( $term, $types ) {
		$args = self::normalize_args( array( 'types' => $types, 'fuzzy' => 1 ) );
		$key  = self::cache_key( $term, array( 'ids', $args['types'], $args['fuzzy'] ) );
		$hit  = self::cache_get( $key );
		if ( is_array( $hit ) ) {
			return $hit;
		}
		$parsed = self::parse( $term );
		$res    = self::query( $parsed, $args['types'], 500, 1, self::opts( Search_Settings::get( 'taxonomies' ) ), true );
		$ids    = array_map( 'intval', $res['posts'] );
		if ( ! $ids && $args['fuzzy'] && $parsed['include'] ) {
			$f   = self::fuzzy( $parsed['include'], $args['types'], 500 );
			$ids = array_map( 'intval', $f['ids'] );
		}
		self::cache_set( $key, $ids );
		return $ids;
	}
}
