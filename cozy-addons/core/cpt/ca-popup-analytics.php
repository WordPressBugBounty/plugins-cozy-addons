<?php
/**
 * Popup Builder analytics.
 *
 * Counts impressions, clicks and dismissals for popups rendered from the Popup
 * Builder, and shows them on the Popup Builder list screen together with a
 * summary of each popup's settings.
 *
 * Tracking is script based: frontend/modal.js posts an event to the REST route
 * registered here. Only running totals are stored, as hidden post meta. No
 * cookies and no personal data are involved.
 *
 * Analytics is a premium feature, gated on cozy_addons_premium_access(). Free
 * sites collect nothing: render.php does not hand the script its tracking
 * values and the route refuses every request. On the list screen the numbers
 * are replaced by locked placeholders. The Trigger and Targeting columns and
 * the "Live popups" tile describe the popups themselves, so they stay visible.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta key holding the time of the latest impression (Unix timestamp).
 */
define( 'COZY_ADDONS_POPUP_LAST_SHOWN_META', '_ca_popup_last_shown' );

/**
 * Maps each tracked event to the post meta key of its counter.
 *
 * @return array<string,string>
 */
function cozy_addons_popup_counter_keys() {
	return array(
		'impression' => '_ca_popup_impressions',
		'click'      => '_ca_popup_clicks',
		'dismiss'    => '_ca_popup_dismissals',
	);
}

/**
 * Adds one to a popup counter.
 *
 * The increment is a single UPDATE, so simultaneous visitors cannot overwrite
 * each other. Reading the value and writing it back would lose counts under load.
 *
 * @param int    $post_id  Popup post ID.
 * @param string $meta_key Counter meta key.
 * @return void
 */
function cozy_addons_popup_increment_counter( $post_id, $meta_key ) {
	global $wpdb;

	$increment = $wpdb->prepare(
		"UPDATE {$wpdb->postmeta} SET meta_value = meta_value + 1 WHERE post_id = %d AND meta_key = %s",
		$post_id,
		$meta_key
	);

	// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery
	if ( ! $wpdb->query( $increment ) ) {
		// No row yet. Create it under a lock so two first-time events cannot
		// both insert one, which would leave duplicate counter rows.
		$lock = 'ca_popup_' . md5( $post_id . '|' . $meta_key );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->get_var( $wpdb->prepare( 'SELECT GET_LOCK( %s, 3 )', $lock ) );

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery
		if ( ! $wpdb->query( $increment ) ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->insert(
				$wpdb->postmeta,
				array(
					'post_id'    => $post_id,
					'meta_key'   => $meta_key, // phpcs:ignore WordPress.DB.SlowDBQuery
					'meta_value' => '1', // phpcs:ignore WordPress.DB.SlowDBQuery
				),
				array( '%d', '%s', '%s' )
			);
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->get_var( $wpdb->prepare( 'SELECT RELEASE_LOCK( %s )', $lock ) );
	}

	wp_cache_delete( $post_id, 'post_meta' );
}

/**
 * Registers the public route the popup script reports events to.
 *
 * @return void
 */
function cozy_addons_popup_register_event_route() {
	register_rest_route(
		'cozy-block/v1',
		'/popup-event',
		array(
			'methods'             => \WP_REST_Server::CREATABLE,
			'callback'            => 'cozy_addons_popup_record_event',
			// Visitors are logged out, so the route cannot ask for a login. It
			// only ever adds one to a counter of a published popup, and only on
			// premium sites: free sites refuse every request, which also covers
			// cached pages still served after a downgrade.
			'permission_callback' => 'cozy_addons_premium_access',
			'args'                => array(
				'id'    => array(
					'required'          => true,
					'type'              => 'integer',
					'minimum'           => 1,
					'sanitize_callback' => 'absint',
				),
				'event' => array(
					'required' => true,
					'type'     => 'string',
					'enum'     => array_keys( cozy_addons_popup_counter_keys() ),
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'cozy_addons_popup_register_event_route' );

/**
 * Records one popup event.
 *
 * @param \WP_REST_Request $request Request with `id` and `event`.
 * @return \WP_REST_Response|\WP_Error
 */
function cozy_addons_popup_record_event( \WP_REST_Request $request ) {
	$post_id = absint( $request->get_param( 'id' ) );
	$event   = (string) $request->get_param( 'event' );
	$keys    = cozy_addons_popup_counter_keys();
	$popup   = get_post( $post_id );

	if ( ! isset( $keys[ $event ] ) || ! $popup || 'ca_popup_builder' !== $popup->post_type || 'publish' !== $popup->post_status ) {
		return new \WP_Error( 'cozy_addons_popup_not_found', __( 'Popup not found.', 'cozy-addons' ), array( 'status' => 404 ) );
	}

	cozy_addons_popup_increment_counter( $post_id, $keys[ $event ] );

	if ( 'impression' === $event ) {
		update_post_meta( $post_id, COZY_ADDONS_POPUP_LAST_SHOWN_META, time() );
	}

	return new \WP_REST_Response( null, 204 );
}

/**
 * Reads a popup's counters.
 *
 * @param int $post_id Popup post ID.
 * @return array{impression:int,click:int,dismiss:int,last_shown:int}
 */
function cozy_addons_popup_get_stats( $post_id ) {
	$stats = array();

	foreach ( cozy_addons_popup_counter_keys() as $event => $meta_key ) {
		$stats[ $event ] = absint( get_post_meta( $post_id, $meta_key, true ) );
	}

	$stats['last_shown'] = absint( get_post_meta( $post_id, COZY_ADDONS_POPUP_LAST_SHOWN_META, true ) );

	return $stats;
}

/**
 * Formats a share of a total as a percentage, or a dash when there is no total.
 *
 * @param int $part  Numerator.
 * @param int $total Denominator.
 * @return string
 */
function cozy_addons_popup_format_rate( $part, $total ) {
	if ( $total <= 0 ) {
		return '—';
	}

	return number_format_i18n( ( $part / $total ) * 100, 1 ) . '%';
}

/**
 * Shortens large counts for the summary tiles: 1,284 / 12.9K / 4.2M.
 *
 * @param int $number Count.
 * @return string
 */
function cozy_addons_popup_format_compact( $number ) {
	if ( $number >= 1000000 ) {
		return number_format_i18n( $number / 1000000, 1 ) . 'M';
	}

	if ( $number >= 10000 ) {
		return number_format_i18n( $number / 1000, 1 ) . 'K';
	}

	return number_format_i18n( $number );
}

/**
 * Finds the first Popup Modal block in a list of parsed blocks.
 *
 * @param array $blocks Parsed blocks.
 * @return array|null
 */
function cozy_addons_popup_find_modal_block( $blocks ) {
	foreach ( $blocks as $block ) {
		if ( isset( $block['blockName'] ) && 'cozy-block/modal' === $block['blockName'] ) {
			return $block;
		}

		if ( ! empty( $block['innerBlocks'] ) ) {
			$found = cozy_addons_popup_find_modal_block( $block['innerBlocks'] );
			if ( $found ) {
				return $found;
			}
		}
	}

	return null;
}

/**
 * Returns a popup's saved settings merged over the block's defaults.
 *
 * @param \WP_Post $post Popup post.
 * @return array|null Attributes, or null when the post holds no Popup Modal block.
 */
function cozy_addons_popup_get_settings( $post ) {
	$modal = cozy_addons_popup_find_modal_block( parse_blocks( $post->post_content ) );

	if ( ! $modal ) {
		return null;
	}

	$defaults   = array();
	$block_type = \WP_Block_Type_Registry::get_instance()->get_registered( 'cozy-block/modal' );

	if ( $block_type && is_array( $block_type->attributes ) ) {
		foreach ( $block_type->attributes as $name => $schema ) {
			if ( is_array( $schema ) && array_key_exists( 'default', $schema ) ) {
				$defaults[ $name ] = $schema['default'];
			}
		}
	}

	return array_merge( $defaults, is_array( $modal['attrs'] ) ? $modal['attrs'] : array() );
}

/**
 * Describes when the popup opens. First line is the trigger, the rest are conditions.
 *
 * @param array $settings Popup settings.
 * @return string[]
 */
function cozy_addons_popup_describe_trigger( $settings ) {
	$is_premium = cozy_addons_premium_access();

	if ( $is_premium && isset( $settings['trigger'] ) && 'exit' === $settings['trigger'] ) {
		return array( __( 'Exit intent', 'cozy-addons' ) );
	}

	$lines = array( __( 'On load', 'cozy-addons' ) );

	// Delay and scroll depth only apply with premium, matching frontend/modal.js.
	if ( $is_premium ) {
		$delay  = isset( $settings['loadCondition']['delay'] ) ? (float) $settings['loadCondition']['delay'] : 0;
		$scroll = isset( $settings['loadCondition']['scroll'] ) ? (int) $settings['loadCondition']['scroll'] : 0;

		if ( $delay > 0 ) {
			/* translators: %s: number of seconds. */
			$lines[] = sprintf( __( 'After %ss', 'cozy-addons' ), number_format_i18n( $delay, floor( $delay ) === $delay ? 0 : 1 ) );
		}

		if ( $scroll > 0 ) {
			/* translators: %d: scroll depth percentage. */
			$lines[] = sprintf( __( 'At %d%% scroll', 'cozy-addons' ), $scroll );
		}
	}

	return $lines;
}

/**
 * Describes how often the popup is shown to one visitor.
 *
 * @param array $settings Popup settings.
 * @return string[]
 */
function cozy_addons_popup_describe_frequency( $settings ) {
	// Frequency rules are premium only; free popups show on every load.
	if ( ! cozy_addons_premium_access() || ! empty( $settings['loadOnRefresh'] ) ) {
		return array( __( 'Every page load', 'cozy-addons' ) );
	}

	if ( ! isset( $settings['frequencyControl'] ) || 'once_per_visitor' !== $settings['frequencyControl'] ) {
		return array( __( 'Once per session', 'cozy-addons' ) );
	}

	// Same options as the Cooldown Interval select in the editor (values are days).
	$cooldowns = array(
		'0.010' => __( '15 minutes', 'cozy-addons' ),
		'0.021' => __( '30 minutes', 'cozy-addons' ),
		'0.042' => __( '1 hour', 'cozy-addons' ),
		'0.25'  => __( '6 hours', 'cozy-addons' ),
		'0.5'   => __( '12 hours', 'cozy-addons' ),
		'1'     => __( '1 day', 'cozy-addons' ),
		'7'     => __( '1 week', 'cozy-addons' ),
		'30'    => __( '1 month', 'cozy-addons' ),
	);

	$interval = isset( $settings['cooldownInterval'] ) ? (string) $settings['cooldownInterval'] : '1';

	if ( isset( $cooldowns[ $interval ] ) ) {
		$cooldown = $cooldowns[ $interval ];
	} else {
		/* translators: %s: number of days. */
		$cooldown = sprintf( __( '%s days', 'cozy-addons' ), $interval );
	}

	return array(
		__( 'Once per visitor', 'cozy-addons' ),
		/* translators: %s: cooldown length, e.g. "6 hours". */
		sprintf( __( 'Again after %s', 'cozy-addons' ), $cooldown ),
	);
}

/**
 * Summarises one allow/deny rule set, e.g. "Pages: 2 allowed, 1 denied".
 *
 * @param string $label      Rule set label.
 * @param array  $visibility Visibility attribute with the four list keys.
 * @return string Empty when no list is active.
 */
function cozy_addons_popup_describe_rules( $label, $visibility ) {
	if ( ! is_array( $visibility ) ) {
		return '';
	}

	$parts   = array();
	$allowed = ! empty( $visibility['hasAllowedList'] ) && ! empty( $visibility['allowedList'] ) && is_array( $visibility['allowedList'] ) ? count( $visibility['allowedList'] ) : 0;
	$denied  = ! empty( $visibility['hasDenyList'] ) && ! empty( $visibility['denyList'] ) && is_array( $visibility['denyList'] ) ? count( $visibility['denyList'] ) : 0;

	if ( $allowed ) {
		/* translators: %s: number of allowed items. */
		$parts[] = sprintf( __( '%s allowed', 'cozy-addons' ), number_format_i18n( $allowed ) );
	}

	if ( $denied ) {
		/* translators: %s: number of denied items. */
		$parts[] = sprintf( __( '%s denied', 'cozy-addons' ), number_format_i18n( $denied ) );
	}

	return $parts ? $label . ': ' . implode( ', ', $parts ) : '';
}

/**
 * Describes where and to whom the popup is shown.
 *
 * @param array $settings Popup settings.
 * @return string[]
 */
function cozy_addons_popup_describe_targeting( $settings ) {
	$lines = array();

	// Placement, e.g. "bottom right" -> "Bottom right", "center center" -> "Center".
	$placement = isset( $settings['placement'] ) ? trim( (string) $settings['placement'] ) : 'center center';
	$lines[]   = 'center center' === $placement ? __( 'Center', 'cozy-addons' ) : ucfirst( $placement );

	// Devices.
	$device_labels = array(
		'desktop' => __( 'Desktop', 'cozy-addons' ),
		'tablet'  => __( 'Tablet', 'cozy-addons' ),
		'mobile'  => __( 'Mobile', 'cozy-addons' ),
	);
	$devices       = array();

	foreach ( $device_labels as $device => $device_label ) {
		if ( ! isset( $settings['responsiveVisibility'][ $device ] ) || filter_var( $settings['responsiveVisibility'][ $device ], FILTER_VALIDATE_BOOLEAN ) ) {
			$devices[] = $device_label;
		}
	}

	if ( count( $devices ) === count( $device_labels ) ) {
		$lines[] = __( 'All devices', 'cozy-addons' );
	} elseif ( $devices ) {
		$lines[] = implode( ', ', $devices );
	} else {
		$lines[] = __( 'No devices', 'cozy-addons' );
	}

	// Page, post type and role rules only apply with premium, matching render.php.
	if ( cozy_addons_premium_access() ) {
		$rules = array();

		if ( isset( $settings['pageVisibility']['homepage'] ) && ! filter_var( $settings['pageVisibility']['homepage'], FILTER_VALIDATE_BOOLEAN ) ) {
			$rules[] = __( 'Not on homepage', 'cozy-addons' );
		}

		$rules[] = cozy_addons_popup_describe_rules( __( 'Pages', 'cozy-addons' ), isset( $settings['pageVisibility'] ) ? $settings['pageVisibility'] : array() );
		$rules[] = cozy_addons_popup_describe_rules( __( 'Post types', 'cozy-addons' ), isset( $settings['postTypeVisibility'] ) ? $settings['postTypeVisibility'] : array() );
		$rules[] = cozy_addons_popup_describe_rules( __( 'Roles', 'cozy-addons' ), isset( $settings['roleVisibility'] ) ? $settings['roleVisibility'] : array() );
		$rules   = array_filter( $rules );

		$lines = array_merge( $lines, $rules ? $rules : array( __( 'All pages', 'cozy-addons' ) ) );
	}

	return $lines;
}

/**
 * Prints a settings cell: the first line as the value, the rest as details.
 *
 * @param string[] $lines Lines to print.
 * @return void
 */
function cozy_addons_popup_print_lines( $lines ) {
	$lines = array_values( array_filter( $lines ) );

	foreach ( $lines as $index => $line ) {
		printf(
			'<span class="%s">%s</span>',
			0 === $index ? 'ca-popup-cell__main' : 'ca-popup-cell__detail',
			esc_html( $line )
		);
	}
}

/**
 * Columns that show analytics data. These are premium only.
 *
 * @return string[]
 */
function cozy_addons_popup_analytics_columns() {
	return array(
		'ca_popup_impressions',
		'ca_popup_clicks',
		'ca_popup_conversion',
		'ca_popup_dismissals',
		'ca_popup_last_shown',
	);
}

/**
 * Prints the placeholder shown in place of a number on free sites.
 *
 * @return void
 */
function cozy_addons_popup_print_locked_value() {
	echo '<span class="ca-popup-locked" aria-hidden="true">—</span><span class="screen-reader-text">' . esc_html__( 'Available in Pro', 'cozy-addons' ) . '</span>';
}

/**
 * Adds the settings and analytics columns to the Popup Builder list.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function cozy_addons_popup_list_columns( $columns ) {
	$new_columns = array(
		// Frequency is shown under the trigger: both describe when the popup
		// appears, and a separate column leaves too little room for the title.
		'ca_popup_trigger'     => __( 'Trigger', 'cozy-addons' ),
		'ca_popup_targeting'   => __( 'Targeting', 'cozy-addons' ),
		'ca_popup_impressions' => __( 'Impressions', 'cozy-addons' ),
		'ca_popup_clicks'      => __( 'Clicks', 'cozy-addons' ),
		'ca_popup_conversion'  => __( 'Conversion rate', 'cozy-addons' ),
		'ca_popup_dismissals'  => __( 'Dismissals', 'cozy-addons' ),
		'ca_popup_last_shown'  => __( 'Last shown', 'cozy-addons' ),
	);

	// Free sites: mark the analytics columns as premium.
	if ( ! cozy_addons_premium_access() ) {
		foreach ( cozy_addons_popup_analytics_columns() as $column ) {
			$new_columns[ $column ] = esc_html( $new_columns[ $column ] ) . ' <span class="ca-popup-pro-label">' . esc_html__( 'PRO', 'cozy-addons' ) . '</span>';
		}
	}

	// Keep Date as the last column.
	$date = array();
	if ( isset( $columns['date'] ) ) {
		$date = array( 'date' => $columns['date'] );
		unset( $columns['date'] );
	}

	return array_merge( $columns, $new_columns, $date );
}
add_filter( 'manage_ca_popup_builder_posts_columns', 'cozy_addons_popup_list_columns' );

/**
 * Prints one cell of the settings and analytics columns.
 *
 * @param string $column_name Column key.
 * @param int    $post_id     Popup post ID.
 * @return void
 */
function cozy_addons_popup_list_column_content( $column_name, $post_id ) {
	static $cache = array();

	if ( 0 !== strpos( $column_name, 'ca_popup_' ) ) {
		return;
	}

	$is_premium = cozy_addons_premium_access();

	// Free sites: no analytics data is shown, and none is read.
	if ( ! $is_premium && in_array( $column_name, cozy_addons_popup_analytics_columns(), true ) ) {
		cozy_addons_popup_print_locked_value();
		return;
	}

	if ( ! isset( $cache[ $post_id ] ) ) {
		$post               = get_post( $post_id );
		$cache[ $post_id ] = array(
			'settings' => $post ? cozy_addons_popup_get_settings( $post ) : null,
			'stats'    => $is_premium ? cozy_addons_popup_get_stats( $post_id ) : array(),
		);
	}

	$settings = $cache[ $post_id ]['settings'];
	$stats    = $cache[ $post_id ]['stats'];

	switch ( $column_name ) {
		case 'ca_popup_trigger':
		case 'ca_popup_targeting':
			if ( ! $settings ) {
				echo '<span aria-hidden="true">—</span><span class="screen-reader-text">' . esc_html__( 'No Popup Modal block in this popup', 'cozy-addons' ) . '</span>';
				break;
			}

			if ( 'ca_popup_trigger' === $column_name ) {
				cozy_addons_popup_print_lines( array_merge( cozy_addons_popup_describe_trigger( $settings ), cozy_addons_popup_describe_frequency( $settings ) ) );
			} else {
				cozy_addons_popup_print_lines( cozy_addons_popup_describe_targeting( $settings ) );
			}
			break;

		case 'ca_popup_impressions':
			echo esc_html( number_format_i18n( $stats['impression'] ) );
			break;

		case 'ca_popup_clicks':
			echo esc_html( number_format_i18n( $stats['click'] ) );
			break;

		case 'ca_popup_conversion':
			echo esc_html( cozy_addons_popup_format_rate( $stats['click'], $stats['impression'] ) );
			break;

		case 'ca_popup_dismissals':
			printf( '<span class="ca-popup-cell__main">%s</span>', esc_html( number_format_i18n( $stats['dismiss'] ) ) );

			if ( $stats['impression'] > 0 ) {
				printf(
					'<span class="ca-popup-cell__detail">%s</span>',
					/* translators: %s: percentage of impressions. */
					esc_html( sprintf( __( '%s of impressions', 'cozy-addons' ), cozy_addons_popup_format_rate( $stats['dismiss'], $stats['impression'] ) ) )
				);
			}
			break;

		case 'ca_popup_last_shown':
			if ( ! $stats['last_shown'] ) {
				esc_html_e( 'Never', 'cozy-addons' );
				break;
			}

			printf(
				'<time datetime="%1$s" title="%2$s">%3$s</time>',
				esc_attr( gmdate( 'c', $stats['last_shown'] ) ),
				esc_attr( wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $stats['last_shown'] ) ),
				/* translators: %s: human-readable time difference, e.g. "3 hours". */
				esc_html( sprintf( __( '%s ago', 'cozy-addons' ), human_time_diff( $stats['last_shown'], time() ) ) )
			);
			break;

		default:
			break;
	}
}
add_action( 'manage_ca_popup_builder_posts_custom_column', 'cozy_addons_popup_list_column_content', 10, 2 );

/**
 * Columns that can be sorted, mapped to their counter meta key.
 *
 * @return array<string,string>
 */
function cozy_addons_popup_sortable_keys() {
	$keys = cozy_addons_popup_counter_keys();

	return array(
		'ca_popup_impressions' => $keys['impression'],
		'ca_popup_clicks'      => $keys['click'],
		'ca_popup_dismissals'  => $keys['dismiss'],
	);
}

/**
 * Makes the counter columns sortable, highest first.
 *
 * @param array $columns Sortable columns.
 * @return array
 */
function cozy_addons_popup_sortable_columns( $columns ) {
	// Sorting by hidden numbers would still reveal their order.
	if ( ! cozy_addons_premium_access() ) {
		return $columns;
	}

	foreach ( array_keys( cozy_addons_popup_sortable_keys() ) as $column ) {
		$columns[ $column ] = array( $column, true );
	}

	return $columns;
}
add_filter( 'manage_edit-ca_popup_builder_sortable_columns', 'cozy_addons_popup_sortable_columns' );

/**
 * Orders the list by a counter.
 *
 * Uses its own LEFT JOIN so popups that have no counter row yet still appear,
 * counted as zero. Ordering through meta_key would drop them from the list.
 *
 * @param array     $clauses Query clauses.
 * @param \WP_Query $query   Query.
 * @return array
 */
function cozy_addons_popup_sort_clauses( $clauses, $query ) {
	global $wpdb;

	if ( ! is_admin() || ! $query->is_main_query() || 'ca_popup_builder' !== $query->get( 'post_type' ) || ! cozy_addons_premium_access() ) {
		return $clauses;
	}

	$sortable = cozy_addons_popup_sortable_keys();
	$orderby  = $query->get( 'orderby' );

	if ( ! is_string( $orderby ) || ! isset( $sortable[ $orderby ] ) ) {
		return $clauses;
	}

	$order = 'ASC' === strtoupper( (string) $query->get( 'order' ) ) ? 'ASC' : 'DESC';

	$clauses['join']   .= $wpdb->prepare(
		" LEFT JOIN {$wpdb->postmeta} AS ca_popup_stat ON ( ca_popup_stat.post_id = {$wpdb->posts}.ID AND ca_popup_stat.meta_key = %s )",
		$sortable[ $orderby ]
	);
	$clauses['orderby'] = "CAST( COALESCE( ca_popup_stat.meta_value, 0 ) AS UNSIGNED ) {$order}, {$wpdb->posts}.post_date DESC";

	return $clauses;
}
add_filter( 'posts_clauses', 'cozy_addons_popup_sort_clauses', 10, 2 );

/**
 * Sums the counters of every popup that is not in the trash.
 *
 * @return array{impression:int,click:int,dismiss:int}
 */
function cozy_addons_popup_get_totals() {
	global $wpdb;

	$keys   = cozy_addons_popup_counter_keys();
	$totals = array_fill_keys( array_keys( $keys ), 0 );

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT pm.meta_key, SUM( CAST( pm.meta_value AS UNSIGNED ) ) AS total
			FROM {$wpdb->postmeta} pm
			INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE p.post_type = 'ca_popup_builder'
			AND p.post_status NOT IN ( 'trash', 'auto-draft' )
			AND pm.meta_key IN ( %s, %s, %s )
			GROUP BY pm.meta_key",
			$keys['impression'],
			$keys['click'],
			$keys['dismiss']
		)
	);

	$events = array_flip( $keys );

	foreach ( (array) $rows as $row ) {
		if ( isset( $events[ $row->meta_key ] ) ) {
			$totals[ $events[ $row->meta_key ] ] = absint( $row->total );
		}
	}

	return $totals;
}

/**
 * Prints the summary tiles above the Popup Builder list.
 *
 * @param array $views Status links of the list table.
 * @return array Unchanged status links.
 */
function cozy_addons_popup_render_totals_bar( $views ) {
	$is_premium = cozy_addons_premium_access();
	$counts     = wp_count_posts( 'ca_popup_builder' );
	$live       = isset( $counts->publish ) ? absint( $counts->publish ) : 0;

	// Free sites: the analytics totals are neither queried nor shown.
	$totals = $is_premium ? cozy_addons_popup_get_totals() : array_fill_keys( array_keys( cozy_addons_popup_counter_keys() ), 0 );

	$tiles = array(
		array(
			'label'  => __( 'Live popups', 'cozy-addons' ),
			'value'  => cozy_addons_popup_format_compact( $live ),
			'exact'  => number_format_i18n( $live ),
			'detail' => __( 'Published and shown on the site', 'cozy-addons' ),
			// A count of popups, not analytics data, so it is never locked.
			'locked' => false,
		),
		array(
			'label'  => __( 'Impressions', 'cozy-addons' ),
			'value'  => cozy_addons_popup_format_compact( $totals['impression'] ),
			'exact'  => number_format_i18n( $totals['impression'] ),
			'detail' => __( 'Times a popup was shown', 'cozy-addons' ),
			'locked' => ! $is_premium,
		),
		array(
			'label'  => __( 'Clicks', 'cozy-addons' ),
			'value'  => cozy_addons_popup_format_compact( $totals['click'] ),
			'exact'  => number_format_i18n( $totals['click'] ),
			'detail' => __( 'Views with a link or button click', 'cozy-addons' ),
			'locked' => ! $is_premium,
		),
		array(
			'label'  => __( 'Conversion rate', 'cozy-addons' ),
			'value'  => cozy_addons_popup_format_rate( $totals['click'], $totals['impression'] ),
			'exact'  => '',
			'detail' => __( 'Clicks divided by impressions', 'cozy-addons' ),
			'locked' => ! $is_premium,
		),
		array(
			'label'  => __( 'Dismissals', 'cozy-addons' ),
			'value'  => cozy_addons_popup_format_compact( $totals['dismiss'] ),
			'exact'  => number_format_i18n( $totals['dismiss'] ),
			'detail' => $totals['impression'] > 0
				/* translators: %s: percentage of impressions. */
				? sprintf( __( '%s of impressions, closed without a click', 'cozy-addons' ), cozy_addons_popup_format_rate( $totals['dismiss'], $totals['impression'] ) )
				: __( 'Closed without a click', 'cozy-addons' ),
			'locked' => ! $is_premium,
		),
	);
	?>
	<div class="ca-popup-stats" role="group" aria-label="<?php esc_attr_e( 'Popup analytics summary', 'cozy-addons' ); ?>">
		<?php foreach ( $tiles as $tile ) { ?>
		<div class="ca-popup-stat<?php echo $tile['locked'] ? ' is-locked' : ''; ?>">
			<span class="ca-popup-stat__label">
				<?php echo esc_html( $tile['label'] ); ?>
				<?php if ( $tile['locked'] ) { ?>
				<span class="ca-popup-pro-label"><?php esc_html_e( 'PRO', 'cozy-addons' ); ?></span>
				<?php } ?>
			</span>
			<?php if ( $tile['locked'] ) { ?>
			<span class="ca-popup-stat__value"><?php cozy_addons_popup_print_locked_value(); ?></span>
			<?php } else { ?>
			<span class="ca-popup-stat__value"<?php echo '' !== $tile['exact'] && $tile['exact'] !== $tile['value'] ? ' title="' . esc_attr( $tile['exact'] ) . '"' : ''; ?>><?php echo esc_html( $tile['value'] ); ?></span>
			<?php } ?>
			<span class="ca-popup-stat__detail"><?php echo esc_html( $tile['detail'] ); ?></span>
		</div>
		<?php } ?>
	</div>
	<?php if ( $is_premium ) { ?>
		<?php
		// render.php turns tracking off for users who can edit posts. Anyone who can
		// open this screen is one of them, so say it here: otherwise testing a popup
		// while logged in looks like tracking is broken.
		?>
	<p class="ca-popup-stats__note">
		<?php esc_html_e( 'Your own visits are not counted while you are logged in. To test a popup, open your site in a private window.', 'cozy-addons' ); ?>
	</p>
	<?php } else { ?>
	<p class="ca-popup-stats__note">
		<?php
		echo wp_kses(
			sprintf(
				/* translators: %s: "Upgrade to Pro" link. */
				__( 'Popup analytics is a Pro feature. %s to see impressions, clicks and dismissals for your popups.', 'cozy-addons' ),
				'<a href="https://cozythemes.com/pricing-and-plans/" target="_blank" rel="noopener">' . esc_html__( 'Upgrade to Pro', 'cozy-addons' ) . '</a>'
			),
			array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
					'rel'    => array(),
				),
			)
		);
		?>
	</p>
	<?php } ?>
	<?php

	return $views;
}
add_filter( 'views_edit-ca_popup_builder', 'cozy_addons_popup_render_totals_bar' );

/**
 * Loads the list screen styles.
 *
 * @return void
 */
function cozy_addons_popup_analytics_assets() {
	$screen = get_current_screen();

	if ( ! $screen || 'edit-ca_popup_builder' !== $screen->id ) {
		return;
	}

	wp_enqueue_style( 'cozy-addons--popup-analytics', COZY_ADDONS_PLUGIN_URL . 'admin/assets/css/popup-analytics.css', array(), COZY_ADDONS_VERSION );
}
add_action( 'admin_enqueue_scripts', 'cozy_addons_popup_analytics_assets' );
