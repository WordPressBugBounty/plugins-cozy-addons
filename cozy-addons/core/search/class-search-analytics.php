<?php
/**
 * Search analytics of the Advanced Search block (Pro).
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Search;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Privacy-friendly search analytics: stores only the normalised query text and
 * aggregate counters (no IP address, no user id).
 */
final class Search_Analytics {

	const CRON = 'cozy_addons_search_prune';

	const DB_VERSION = '1';

	/**
	 * Creates or updates the table when its version changes (activation hooks do not run on updates),
	 * and schedules the daily clean-up.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'maybe_install' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'maybe_install' ) );
		add_action( self::CRON, array( __CLASS__, 'prune' ) );
	}

	/**
	 * Installs the table once per table version and makes sure the clean-up is scheduled.
	 *
	 * @return void
	 */
	public static function maybe_install() {
		if ( get_option( 'ca_search_db_version' ) !== self::DB_VERSION ) {
			self::install();
		}
		if ( ! wp_next_scheduled( self::CRON ) ) {
			wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', self::CRON );
		}
	}

	public static function table() {
		global $wpdb;
		return $wpdb->prefix . 'ca_search_queries';
	}

	public static function install() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$table   = self::table();
		$charset = $wpdb->get_charset_collate();
		dbDelta( "CREATE TABLE {$table} (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  term_hash char(32) NOT NULL,
  term varchar(191) NOT NULL,
  hits int(10) unsigned NOT NULL DEFAULT 1,
  results int(10) unsigned NOT NULL DEFAULT 0,
  zero_hits int(10) unsigned NOT NULL DEFAULT 0,
  clicks int(10) unsigned NOT NULL DEFAULT 0,
  first_seen datetime NOT NULL,
  last_seen datetime NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY term_hash (term_hash),
  KEY last_seen (last_seen),
  KEY hits (hits)
) {$charset};" );

		update_option( 'ca_search_db_version', self::DB_VERSION );
	}

	/** Returns a normalised term, or '' when it should not be stored. */
	public static function normalize( $term ) {
		$term = mb_strtolower( sanitize_text_field( (string) $term ) );
		$term = trim( preg_replace( '/\s+/u', ' ', $term ) );
		if ( mb_strlen( $term ) < 2 || mb_strlen( $term ) > 100 ) {
			return '';
		}
		// Never store URLs, e-mail addresses or long numbers (privacy / spam).
		if ( preg_match( '#https?:|www\.|@|\d{9,}#i', $term ) ) {
			return '';
		}
		return $term;
	}

	public static function record( $term, $results ) {
		global $wpdb;
		$term = self::normalize( $term );
		if ( '' === $term ) {
			return;
		}
		$results = max( 0, (int) $results );
		$zero    = $results < 1 ? 1 : 0;
		$now     = gmdate( 'Y-m-d H:i:s' );
		$wpdb->query( $wpdb->prepare(
			'INSERT INTO ' . self::table() . ' (term_hash, term, hits, results, zero_hits, clicks, first_seen, last_seen) VALUES (%s, %s, 1, %d, %d, 0, %s, %s)
			 ON DUPLICATE KEY UPDATE hits = hits + 1, results = %d, zero_hits = zero_hits + %d, last_seen = %s',
			md5( $term ),
			$term,
			$results,
			$zero,
			$now,
			$now,
			$results,
			$zero,
			$now
		) );
		delete_transient( 'ca_search_popular' );
	}

	public static function click( $term ) {
		global $wpdb;
		$term = self::normalize( $term );
		if ( '' === $term ) {
			return;
		}
		$wpdb->query( $wpdb->prepare( 'UPDATE ' . self::table() . ' SET clicks = clicks + 1 WHERE term_hash = %s', md5( $term ) ) );
	}

	public static function popular( $limit = 6 ) {
		global $wpdb;
		$limit = max( 0, (int) $limit );
		if ( ! $limit ) {
			return array();
		}
		$cached = get_transient( 'ca_search_popular' );
		if ( is_array( $cached ) ) {
			return array_slice( $cached, 0, $limit );
		}
		$min   = (int) apply_filters( 'cozy_addons_search_popular_min_hits', 2 );
		$since = gmdate( 'Y-m-d H:i:s', time() - 90 * DAY_IN_SECONDS );
		$rows  = $wpdb->get_col( $wpdb->prepare(
			'SELECT term FROM ' . self::table() . ' WHERE results > 0 AND hits >= %d AND last_seen >= %s ORDER BY hits DESC, last_seen DESC LIMIT 20',
			$min,
			$since
		) );
		$rows = is_array( $rows ) ? $rows : array();
		set_transient( 'ca_search_popular', $rows, 10 * MINUTE_IN_SECONDS );
		return array_slice( $rows, 0, $limit );
	}

	/** Query auto-completion from what other visitors successfully searched for. */
	public static function suggest( $prefix, $limit = 5 ) {
		global $wpdb;
		$p = mb_strtolower( trim( (string) $prefix ) );
		if ( mb_strlen( $p ) < 2 ) {
			return array();
		}
		$rows = $wpdb->get_col( $wpdb->prepare(
			'SELECT term FROM ' . self::table() . ' WHERE term LIKE %s AND term <> %s AND results > 0 AND hits >= %d ORDER BY hits DESC LIMIT %d',
			$wpdb->esc_like( $p ) . '%',
			$p,
			(int) apply_filters( 'cozy_addons_search_popular_min_hits', 2 ),
			(int) $limit
		) );
		return is_array( $rows ) ? $rows : array();
	}

	public static function top( $days = 30, $limit = 25, $zero_only = false ) {
		global $wpdb;
		$since = gmdate( 'Y-m-d H:i:s', time() - max( 1, (int) $days ) * DAY_IN_SECONDS );
		$where = $zero_only ? 'AND results = 0' : '';
		$rows  = $wpdb->get_results( $wpdb->prepare(
			'SELECT term, hits, results, zero_hits, clicks, last_seen FROM ' . self::table() . " WHERE last_seen >= %s {$where} ORDER BY hits DESC LIMIT %d",
			$since,
			(int) $limit
		), ARRAY_A );
		return is_array( $rows ) ? $rows : array();
	}

	public static function totals( $days = 30 ) {
		global $wpdb;
		$since = gmdate( 'Y-m-d H:i:s', time() - max( 1, (int) $days ) * DAY_IN_SECONDS );
		$row   = $wpdb->get_row( $wpdb->prepare(
			'SELECT COUNT(*) AS terms, COALESCE(SUM(hits),0) AS hits, COALESCE(SUM(zero_hits),0) AS zero_hits, COALESCE(SUM(clicks),0) AS clicks FROM ' . self::table() . ' WHERE last_seen >= %s',
			$since
		), ARRAY_A );
		return is_array( $row ) ? $row : array( 'terms' => 0, 'hits' => 0, 'zero_hits' => 0, 'clicks' => 0 );
	}

	public static function prune() {
		global $wpdb;
		$days  = max( 7, (int) Search_Settings::get( 'retention_days' ) );
		$since = gmdate( 'Y-m-d H:i:s', time() - $days * DAY_IN_SECONDS );
		$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . self::table() . ' WHERE last_seen < %s', $since ) );
	}

	public static function clear() {
		global $wpdb;
		$wpdb->query( 'TRUNCATE TABLE ' . self::table() );
		delete_transient( 'ca_search_popular' );
	}
}
