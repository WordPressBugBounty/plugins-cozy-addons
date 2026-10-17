<?php
/**
 * Leads analytics engine: reads entry rows and turns them into the numbers on Lead Forms → Analytics.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Collects entry rows for a period and the one before it, and computes the statistics.
 */
final class Leads_Stats {

	const ROW_LIMIT = 10000;

	/**
	 * Report ranges: slug => [ days, label ].
	 *
	 * @return array<string,array{days:int,label:string}>
	 */
	public static function ranges() {
		return array(
			'week'  => array(
				'days'  => 7,
				'label' => __( 'Last 7 days', 'cozy-addons' ),
			),
			'month' => array(
				'days'  => 30,
				'label' => __( 'Last 30 days', 'cozy-addons' ),
			),
			'year'  => array(
				'days'  => 365,
				'label' => __( 'Last 12 months', 'cozy-addons' ),
			),
		);
	}

	/**
	 * Entry rows for the current and previous period in one query. Spam is left out.
	 *
	 * @param int $days Length of one period in days.
	 * @return array[]
	 */
	public static function rows( $days ) {
		global $wpdb;
		$days      = max( 1, (int) $days );
		$from      = gmdate( 'Y-m-d H:i:s', time() - 2 * $days * DAY_IN_SECONDS );
		$cache_key = 'rows_' . $days . '_' . gmdate( 'YmdHi' );
		$rows      = wp_cache_get( $cache_key, 'cozy_addons_forms' );
		if ( false !== $rows ) {
			return $rows;
		}

		$rows = $wpdb->get_results( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Aggregate report, cached below.
			$wpdb->prepare(
				"SELECT p.ID AS id, p.post_date_gmt AS received,
					s.meta_value AS status, t.meta_value AS type, c.meta_value AS category,
					u.meta_value AS urgent, f.meta_value AS form_name, i.meta_value AS form_id,
					ct.meta_value AS contacted_at
				FROM {$wpdb->posts} p
				LEFT JOIN {$wpdb->postmeta} s  ON s.post_id  = p.ID AND s.meta_key  = '_ca_form_status'
				LEFT JOIN {$wpdb->postmeta} t  ON t.post_id  = p.ID AND t.meta_key  = '_ca_form_type'
				LEFT JOIN {$wpdb->postmeta} c  ON c.post_id  = p.ID AND c.meta_key  = '_ca_form_category'
				LEFT JOIN {$wpdb->postmeta} u  ON u.post_id  = p.ID AND u.meta_key  = '_ca_form_urgent'
				LEFT JOIN {$wpdb->postmeta} f  ON f.post_id  = p.ID AND f.meta_key  = '_ca_form_name'
				LEFT JOIN {$wpdb->postmeta} i  ON i.post_id  = p.ID AND i.meta_key  = '_ca_form_id'
				LEFT JOIN {$wpdb->postmeta} ct ON ct.post_id = p.ID AND ct.meta_key = '_ca_form_contacted_at'
				WHERE p.post_type = %s AND p.post_status = 'publish' AND p.post_date_gmt >= %s
				ORDER BY p.post_date_gmt ASC
				LIMIT %d",
				Entry_Post_Type::TYPE,
				$from,
				self::ROW_LIMIT
			),
			ARRAY_A
		);
		$rows = (array) $rows;
		wp_cache_set( $cache_key, $rows, 'cozy_addons_forms', 60 );

		return $rows;
	}

	/**
	 * Median of a list of numbers.
	 *
	 * @param float[] $values Values.
	 * @return float|null Null for an empty list.
	 */
	public static function median( array $values ) {
		if ( empty( $values ) ) {
			return null;
		}
		sort( $values );
		$n   = count( $values );
		$mid = intdiv( $n, 2 );

		return 1 === $n % 2 ? (float) $values[ $mid ] : ( $values[ $mid - 1 ] + $values[ $mid ] ) / 2;
	}

	/**
	 * Percentage change between two numbers.
	 *
	 * @param float $current  Current value.
	 * @param float $previous Previous value.
	 * @return float|null Null when there is no baseline.
	 */
	public static function delta( $current, $previous ) {
		if ( $previous <= 0 ) {
			return null;
		}

		return ( ( (float) $current - (float) $previous ) / (float) $previous ) * 100;
	}

	/**
	 * Computes every number on the Analytics page.
	 *
	 * Lead figures leave sign-ups (newsletter, lead magnet, waitlist) out; those are counted as subscribers. The yearly
	 * range is charted per month, shorter ranges per day.
	 *
	 * @param array[] $rows Rows from rows().
	 * @param int     $days Period length in days.
	 * @param int     $now  Current timestamp, injectable for tests.
	 * @return array
	 */
	public static function compute( array $rows, $days, $now = 0 ) {
		$days    = max( 1, (int) $days );
		$now     = $now ? (int) $now : time();
		$cut     = $now - $days * DAY_IN_SECONDS;
		$monthly = $days > 90;

		$blank   = static function () {
			return array(
				'leads'       => 0,
				'urgent'      => 0,
				'subscribers' => 0,
				'contacted'   => 0,
				'won'         => 0,
				'lost'        => 0,
				'responses'   => array(),
			);
		};
		$buckets = array(
			'cur'  => $blank(),
			'prev' => $blank(),
		);

		// Chart buckets: one per day, or one per month for the yearly range.
		$trend        = array();
		$trend_urgent = array();
		if ( $monthly ) {
			// From the first of the month, so "-1 month" never skips or repeats a month.
			$first = ( new \DateTimeImmutable( '@' . $now ) )->setTimezone( wp_timezone() )->modify( 'first day of this month' );
			for ( $i = 11; $i >= 0; $i-- ) {
				$key                  = $first->modify( "-{$i} months" )->format( 'Y-m' );
				$trend[ $key ]        = 0;
				$trend_urgent[ $key ] = 0;
			}
		} else {
			for ( $i = $days - 1; $i >= 0; $i-- ) {
				$key                  = wp_date( 'Y-m-d', $now - $i * DAY_IN_SECONDS );
				$trend[ $key ]        = 0;
				$trend_urgent[ $key ] = 0;
			}
		}

		$statuses   = array_fill_keys( array_keys( cozy_addons_form_entry_statuses() ), 0 );
		$categories = array();
		$forms      = array();
		$types      = array();
		$recent     = array();
		$today      = 0;

		foreach ( $rows as $row ) {
			$received = strtotime( (string) $row['received'] . ' UTC' );
			if ( ! $received ) {
				continue;
			}
			$type   = isset( $row['type'] ) && isset( cozy_addons_form_types()[ $row['type'] ] ) ? $row['type'] : 'contact';
			$period = $received >= $cut ? 'cur' : 'prev';

			if ( cozy_addons_form_type_is_subscription( $type ) ) {
				++$buckets[ $period ]['subscribers'];
				if ( 'cur' === $period ) {
					$types[ $type ] = isset( $types[ $type ] ) ? $types[ $type ] + 1 : 1;
				}
				continue;
			}

			$status    = isset( $row['status'] ) && isset( $statuses[ $row['status'] ] ) ? $row['status'] : 'new';
			$is_urgent = '1' === (string) $row['urgent'];

			++$buckets[ $period ]['leads'];
			if ( $is_urgent ) {
				++$buckets[ $period ]['urgent'];
			}
			if ( 'won' === $status ) {
				++$buckets[ $period ]['won'];
			}
			if ( 'lost' === $status ) {
				++$buckets[ $period ]['lost'];
			}
			if ( ! empty( $row['contacted_at'] ) ) {
				++$buckets[ $period ]['contacted'];
				$contacted = strtotime( $row['contacted_at'] . ' UTC' );
				if ( $contacted && $contacted >= $received ) {
					$buckets[ $period ]['responses'][] = ( $contacted - $received ) / HOUR_IN_SECONDS;
				}
			}

			if ( 'prev' === $period ) {
				continue;
			}

			$key = wp_date( $monthly ? 'Y-m' : 'Y-m-d', $received );
			if ( isset( $trend[ $key ] ) ) {
				++$trend[ $key ];
				if ( $is_urgent ) {
					++$trend_urgent[ $key ];
				}
			}
			if ( $received >= $now - DAY_IN_SECONDS ) {
				++$today;
			}
			++$statuses[ $status ];
			$types[ $type ] = isset( $types[ $type ] ) ? $types[ $type ] + 1 : 1;

			$category = isset( $row['category'] ) && isset( cozy_addons_form_categories()[ $row['category'] ] ) ? $row['category'] : '';
			if ( ! isset( $categories[ $category ] ) ) {
				$categories[ $category ] = array(
					'leads'  => 0,
					'urgent' => 0,
					'won'    => 0,
				);
			}
			++$categories[ $category ]['leads'];
			$categories[ $category ]['urgent'] += $is_urgent ? 1 : 0;
			$categories[ $category ]['won']    += 'won' === $status ? 1 : 0;

			$form_key = '' !== (string) $row['form_id'] ? (string) $row['form_id'] : 'unknown';
			if ( ! isset( $forms[ $form_key ] ) ) {
				$forms[ $form_key ] = array(
					'name'   => '' !== (string) $row['form_name'] ? (string) $row['form_name'] : $form_key,
					'leads'  => 0,
					'urgent' => 0,
					'won'    => 0,
				);
			}
			++$forms[ $form_key ]['leads'];
			$forms[ $form_key ]['urgent'] += $is_urgent ? 1 : 0;
			$forms[ $form_key ]['won']    += 'won' === $status ? 1 : 0;

			if ( $is_urgent ) {
				$recent[] = (int) $row['id'];
			}
		}

		$by_leads = static function ( array $bucket ) {
			uasort(
				$bucket,
				static function ( $a, $b ) {
					return $b['leads'] <=> $a['leads'];
				}
			);
			return array_slice( $bucket, 0, 8, true );
		};
		arsort( $types );

		$rate = static function ( array $bucket ) {
			$closed = $bucket['won'] + $bucket['lost'];
			return $closed > 0 ? ( (float) $bucket['won'] / $closed ) * 100 : null;
		};

		$summary = static function ( array $bucket ) use ( $rate ) {
			return array(
				'leads'        => $bucket['leads'],
				'urgent'       => $bucket['urgent'],
				'subscribers'  => $bucket['subscribers'],
				'contacted'    => $bucket['contacted'],
				'won'          => $bucket['won'],
				'lost'         => $bucket['lost'],
				'win_rate'     => $rate( $bucket ),
				'median_hours' => self::median( $bucket['responses'] ),
			);
		};

		return array(
			'days'          => $days,
			'monthly'       => $monthly,
			'cur'           => $summary( $buckets['cur'] ),
			'prev'          => $summary( $buckets['prev'] ),
			'today'         => $today,
			'trend'         => array_values( $trend ),
			'trend_urgent'  => array_values( $trend_urgent ),
			'trend_x'       => array_keys( $trend ),
			'statuses'      => $statuses,
			'categories'    => $by_leads( $categories ),
			'forms'         => $by_leads( $forms ),
			'types'         => $types,
			// Newest urgent entries first, for "Needs attention".
			'recent_urgent' => array_slice( array_reverse( $recent ), 0, 5 ),
		);
	}

	/**
	 * Counts entries still New after the overdue time. Pro, as it needs the status pipeline.
	 *
	 * @return int
	 */
	public static function overdue_count() {
		global $wpdb;
		$before = gmdate( 'Y-m-d H:i:s', time() - (int) cozy_addons_form_settings()['overdue_hours'] * HOUR_IN_SECONDS );

		return (int) $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Small count for the Analytics page.
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$wpdb->posts} p
				 INNER JOIN {$wpdb->postmeta} s ON s.post_id = p.ID AND s.meta_key = '_ca_form_status' AND s.meta_value = 'new'
				 LEFT JOIN {$wpdb->postmeta} t ON t.post_id = p.ID AND t.meta_key = '_ca_form_type'
				 WHERE p.post_type = %s AND p.post_status = 'publish' AND p.post_date_gmt < %s AND ( t.meta_value IS NULL OR t.meta_value NOT IN ( %s, %s, %s ) )",
				Entry_Post_Type::TYPE,
				$before,
				// Sign-up types, see cozy_addons_form_type_is_subscription().
				'newsletter',
				'lead-magnet',
				'waitlist'
			)
		);
	}
}
