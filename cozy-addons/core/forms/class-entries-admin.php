<?php
/**
 * Entries inbox: list table, status pipeline and the single entry screen.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_Post;

/**
 * Admin screens for form entries.
 */
final class Entries_Admin {

	const TYPE = Entry_Post_Type::TYPE;

	/**
	 * Registers admin hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'assets' ) );
		add_filter( 'add_menu_classes', array( __CLASS__, 'menu_bubble' ) );
		add_filter( 'display_post_states', array( __CLASS__, 'urgent_state' ), 10, 2 );

		// Inbox list.
		add_filter( 'manage_' . self::TYPE . '_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_' . self::TYPE . '_posts_custom_column', array( __CLASS__, 'column_content' ), 10, 2 );
		add_filter( 'views_edit-' . self::TYPE, array( __CLASS__, 'views' ) );
		add_action( 'restrict_manage_posts', array( __CLASS__, 'filters' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'filter_query' ) );
		add_filter( 'post_row_actions', array( __CLASS__, 'row_actions' ), 10, 2 );
		add_filter( 'bulk_actions-edit-' . self::TYPE, array( __CLASS__, 'bulk_actions' ) );
		add_filter( 'handle_bulk_actions-edit-' . self::TYPE, array( __CLASS__, 'handle_bulk' ), 10, 3 );
		add_action( 'admin_notices', array( __CLASS__, 'bulk_notice' ) );
		add_action( 'admin_post_cozy_addons_form_set_status', array( __CLASS__, 'set_status' ) );
		add_action( 'admin_post_cozy_addons_form_set_spam', array( __CLASS__, 'set_spam_action' ) );
		add_action( 'admin_post_cozy_addons_form_set_urgent', array( __CLASS__, 'set_urgent_action' ) );

		// Single entry screen.
		add_action( 'add_meta_boxes_' . self::TYPE, array( __CLASS__, 'meta_boxes' ) );
		add_action( 'save_post_' . self::TYPE, array( __CLASS__, 'save_meta' ) );
	}

	/**
	 * Loads the admin styles on the Lead Forms screens.
	 *
	 * @return void
	 */
	public static function assets() {
		$screen = get_current_screen();
		if ( ! $screen ) {
			return;
		}
		// Covers the inbox, entries and the Analytics and Settings pages under the Lead Forms menu.
		if ( self::TYPE === $screen->post_type || false !== strpos( $screen->id, Form_Settings::PAGE ) || false !== strpos( $screen->id, Leads_Analytics::PAGE ) ) {
			wp_enqueue_style( 'cozy-addons--form-entries', COZY_ADDONS_PLUGIN_URL . 'admin/assets/css/form-entries.css', array(), COZY_ADDONS_VERSION );
		}
	}

	/**
	 * Shows a count next to the Lead Forms menu: open urgent entries when there are any, otherwise new
	 * ones. Pro only: without the status pipeline entries can never be handled, so it would only grow.
	 *
	 * @param array $menu Admin menu.
	 * @return array
	 */
	public static function menu_bubble( $menu ) {
		if ( ! cozy_addons_premium_access() ) {
			return $menu;
		}
		$urgent = self::open_urgent_count();
		$count  = $urgent > 0 ? $urgent : ( self::status_counts()['new'] ?? 0 );
		if ( $count < 1 ) {
			return $menu;
		}
		foreach ( $menu as $key => $item ) {
			if ( isset( $item[2] ) && 'edit.php?post_type=' . self::TYPE === $item[2] ) {
				$menu[ $key ][0] .= ' <span class="awaiting-mod' . ( $urgent > 0 ? ' ca-form-bubble--urgent' : '' ) . '">' . esc_html( number_format_i18n( $count ) ) . '</span>';
				break;
			}
		}

		return $menu;
	}

	/**
	 * Counts urgent entries that are still open: New, Contacted or Quoted.
	 *
	 * @return int
	 */
	public static function open_urgent_count() {
		static $count = null;
		if ( null !== $count ) {
			return $count;
		}
		global $wpdb;
		$count = (int) $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Small count, cached per request by the static variable.
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$wpdb->posts} p
				 INNER JOIN {$wpdb->postmeta} u ON u.post_id = p.ID AND u.meta_key = '_ca_form_urgent' AND u.meta_value = '1'
				 LEFT JOIN {$wpdb->postmeta} s ON s.post_id = p.ID AND s.meta_key = '_ca_form_status'
				 WHERE p.post_type = %s AND p.post_status = 'publish' AND ( s.meta_value IS NULL OR s.meta_value IN ( 'new', 'contacted', 'quoted' ) )",
				self::TYPE
			)
		);

		return $count;
	}

	/**
	 * Counts urgent entries in the inbox.
	 *
	 * @return int
	 */
	private static function urgent_count() {
		global $wpdb;

		return (int) $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Small count for the list view links.
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$wpdb->posts} p
				 INNER JOIN {$wpdb->postmeta} u ON u.post_id = p.ID AND u.meta_key = '_ca_form_urgent' AND u.meta_value = '1'
				 WHERE p.post_type = %s AND p.post_status = 'publish'",
				self::TYPE
			)
		);
	}

	/**
	 * Adds an "Urgent" pill after the entry title in the inbox, with the reason as its tooltip.
	 *
	 * @param array   $states Post states.
	 * @param WP_Post $post   Post.
	 * @return array
	 */
	public static function urgent_state( $states, $post ) {
		if ( ! $post instanceof WP_Post || self::TYPE !== $post->post_type || '1' !== get_post_meta( $post->ID, '_ca_form_urgent', true ) ) {
			return $states;
		}
		$reason                   = (string) get_post_meta( $post->ID, '_ca_form_urgent_reason', true );
		$states['ca_form_urgent'] = '<span class="ca-form-urgent-pill" title="' . esc_attr( $reason ) . '">' . esc_html__( 'Urgent', 'cozy-addons' ) . '</span>';

		return $states;
	}

	/**
	 * Flags or unflags an entry as urgent by hand.
	 *
	 * @param int  $entry_id Entry ID.
	 * @param bool $urgent   True to flag.
	 * @return bool True when it changed.
	 */
	public static function set_urgent( $entry_id, $urgent ) {
		$entry_id = (int) $entry_id;
		if ( self::TYPE !== get_post_type( $entry_id ) || cozy_addons_form_type_is_subscription( cozy_addons_form_entry_type( $entry_id ) ) ) {
			return false;
		}
		$was = '1' === get_post_meta( $entry_id, '_ca_form_urgent', true );
		if ( $was === (bool) $urgent ) {
			return false;
		}
		$user = wp_get_current_user();
		if ( $urgent ) {
			update_post_meta( $entry_id, '_ca_form_urgent', '1' );
			/* translators: %s: user name */
			update_post_meta( $entry_id, '_ca_form_urgent_reason', sprintf( __( 'Marked by %s', 'cozy-addons' ), $user->display_name ) );
			self::add_activity( $entry_id, 'status', __( 'Marked as urgent', 'cozy-addons' ) );
		} else {
			delete_post_meta( $entry_id, '_ca_form_urgent' );
			delete_post_meta( $entry_id, '_ca_form_urgent_reason' );
			self::add_activity( $entry_id, 'status', __( 'Marked as not urgent', 'cozy-addons' ) );
		}

		return true;
	}

	/**
	 * Handles the Mark urgent / Not urgent row links.
	 *
	 * @return void
	 */
	public static function set_urgent_action() {
		$id = isset( $_GET['entry'] ) ? absint( $_GET['entry'] ) : 0;
		check_admin_referer( 'cozy_addons_form_urgent_' . $id );

		if ( ! $id || self::TYPE !== get_post_type( $id ) || ! current_user_can( 'edit_post', $id ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		self::set_urgent( $id, ! empty( $_GET['urgent'] ) );
		wp_safe_redirect( wp_get_referer() ? wp_get_referer() : cozy_addons_form_admin_url() );
		exit;
	}

	/**
	 * Changes an entry's status and records it in the activity log.
	 *
	 * The status pipeline is a Pro feature. Free sites still store every entry as "New",
	 * so the pipeline is ready to use after upgrading.
	 *
	 * @param int    $entry_id   Entry ID.
	 * @param string $new_status New status slug.
	 * @return bool True when the status changed.
	 */
	public static function change_status( $entry_id, $new_status ) {
		$entry_id = (int) $entry_id;
		$statuses = cozy_addons_form_entry_statuses();
		// Sign-ups (newsletter, lead magnet, waitlist) have no status pipeline.
		if ( ! cozy_addons_premium_access() || ! isset( $statuses[ $new_status ] ) || self::TYPE !== get_post_type( $entry_id ) || cozy_addons_form_type_is_subscription( cozy_addons_form_entry_type( $entry_id ) ) ) {
			return false;
		}
		$old = (string) get_post_meta( $entry_id, '_ca_form_status', true );
		$old = isset( $statuses[ $old ] ) ? $old : 'new';
		if ( $old === $new_status ) {
			return false;
		}

		$now = gmdate( 'Y-m-d H:i:s' );
		update_post_meta( $entry_id, '_ca_form_status', $new_status );

		// The first move out of "New" counts as the first response; Won or Lost closes the entry.
		if ( 'new' !== $new_status && ! get_post_meta( $entry_id, '_ca_form_contacted_at', true ) ) {
			update_post_meta( $entry_id, '_ca_form_contacted_at', $now );
		}
		if ( in_array( $new_status, array( 'won', 'lost' ), true ) ) {
			update_post_meta( $entry_id, '_ca_form_closed_at', $now );
		} else {
			delete_post_meta( $entry_id, '_ca_form_closed_at' );
		}

		self::add_activity( $entry_id, 'status', $statuses[ $old ] . ' → ' . $statuses[ $new_status ] );

		return true;
	}

	/**
	 * Appends an item to an entry's activity log.
	 *
	 * Status changes are always recorded, so the timeline is complete when a site upgrades to Pro.
	 *
	 * @param int    $entry_id Entry ID.
	 * @param string $kind     "status" or "note".
	 * @param string $text     Item text.
	 * @return void
	 */
	public static function add_activity( $entry_id, $kind, $text ) {
		$log   = get_post_meta( $entry_id, '_ca_form_activity', true );
		$log   = is_array( $log ) ? $log : array();
		$log[] = array(
			't' => gmdate( 'Y-m-d H:i:s' ),
			'u' => get_current_user_id(),
			'k' => 'note' === $kind ? 'note' : 'status',
			'x' => $text,
		);
		update_post_meta( $entry_id, '_ca_form_activity', wp_slash( array_slice( $log, -200 ) ) );
	}

	/**
	 * Meta query used by the inbox filters and the CSV export.
	 *
	 * @param string $status Status slug or empty.
	 * @param string $form   Form name or empty.
	 * @param string $type     Form type or empty.
	 * @param string $category Form category or empty.
	 * @param bool   $urgent   Only urgent entries.
	 * @return array Meta query, possibly empty.
	 */
	public static function build_meta_query( $status, $form, $type = '', $category = '', $urgent = false ) {
		$mq = array();
		if ( isset( cozy_addons_form_entry_statuses()[ $status ] ) ) {
			$mq[] = array(
				'key'   => '_ca_form_status',
				'value' => $status,
			);
		}
		if ( '' !== $form ) {
			$mq[] = array(
				'key'   => '_ca_form_name',
				'value' => $form,
			);
		}
		if ( 'contact' === $type ) {
			// Entries saved before form types existed have no type and count as contact entries.
			$mq[] = array(
				'relation' => 'OR',
				array(
					'key'   => '_ca_form_type',
					'value' => 'contact',
				),
				array(
					'key'     => '_ca_form_type',
					'compare' => 'NOT EXISTS',
				),
			);
		} elseif ( isset( cozy_addons_form_types()[ $type ] ) ) {
			$mq[] = array(
				'key'   => '_ca_form_type',
				'value' => $type,
			);
		}
		if ( isset( cozy_addons_form_categories()[ $category ] ) ) {
			$mq[] = array(
				'key'   => '_ca_form_category',
				'value' => $category,
			);
		}
		if ( $urgent ) {
			$mq[] = array(
				'key'   => '_ca_form_urgent',
				'value' => '1',
			);
		}
		if ( $mq ) {
			$mq['relation'] = 'AND';
		}

		return $mq;
	}

	/**
	 * Counts entries per status.
	 *
	 * @return array<string,int>
	 */
	public static function status_counts() {
		static $cache = null;
		if ( null !== $cache ) {
			return $cache;
		}
		global $wpdb;
		$cache = array_fill_keys( array_keys( cozy_addons_form_entry_statuses() ), 0 );
		$rows  = $wpdb->get_results( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching -- Aggregate count, cached per request by the static variable.
			$wpdb->prepare(
				"SELECT pm.meta_value AS s, COUNT(*) AS c FROM {$wpdb->postmeta} pm
				 INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				 WHERE pm.meta_key = %s AND p.post_type = %s AND p.post_status = 'publish'
				 GROUP BY pm.meta_value",
				'_ca_form_status',
				self::TYPE
			)
		);
		foreach ( (array) $rows as $row ) {
			if ( isset( $cache[ $row->s ] ) ) {
				$cache[ $row->s ] = (int) $row->c;
			}
		}

		return $cache;
	}

	/**
	 * Builds a coloured status badge.
	 *
	 * @param string $status Status slug.
	 * @return string HTML.
	 */
	private static function badge( $status ) {
		$statuses = cozy_addons_form_entry_statuses();
		$slug     = isset( $statuses[ $status ] ) ? $status : 'new';

		return '<span class="ca-form-badge ca-form-badge--' . esc_attr( $slug ) . '">' . esc_html( $statuses[ $slug ] ) . '</span>';
	}

	/**
	 * Defines the inbox list columns.
	 *
	 * @param array $cols Default columns.
	 * @return array
	 */
	public static function columns( array $cols ) {
		return array(
			'cb'              => $cols['cb'] ?? '<input type="checkbox" />',
			'title'           => __( 'Entry', 'cozy-addons' ),
			'ca_form_contact' => __( 'Contact', 'cozy-addons' ),
			'ca_form_details' => __( 'Details', 'cozy-addons' ),
			'ca_form_status'  => cozy_addons_premium_access() ? __( 'Status', 'cozy-addons' ) : esc_html__( 'Status', 'cozy-addons' ) . ' <span class="ca-form-pro-label">' . esc_html__( 'PRO', 'cozy-addons' ) . '</span>',
			'date'            => __( 'Received', 'cozy-addons' ),
		);
	}

	/**
	 * Prints a custom column cell.
	 *
	 * @param string $column  Column key.
	 * @param int    $post_id Entry ID.
	 * @return void
	 */
	public static function column_content( $column, $post_id ) {
		switch ( $column ) {
			case 'ca_form_contact':
				$email = (string) get_post_meta( $post_id, '_ca_form_email', true );
				$phone = (string) get_post_meta( $post_id, '_ca_form_phone', true );
				if ( $email ) {
					echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a><br>';
				}
				if ( $phone ) {
					echo '<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>';
				}
				if ( ! $email && ! $phone ) {
					echo '&mdash;';
				}
				break;

			case 'ca_form_details':
				$summary = (string) get_post_meta( $post_id, '_ca_form_summary', true );
				$product = (string) get_post_meta( $post_id, '_ca_form_product_name', true );
				$type    = cozy_addons_form_entry_type( $post_id );
				echo '<strong>' . esc_html( (string) get_post_meta( $post_id, '_ca_form_name', true ) ) . '</strong>';
				echo ' <span class="ca-form-type ca-form-type--' . esc_attr( $type ) . '">' . esc_html( cozy_addons_form_types()[ $type ] ) . '</span>';
				if ( '' !== $product ) {
					echo '<br><span class="ca-form-product-tag">' . esc_html( $product ) . '</span>';
				}
				if ( $summary ) {
					echo '<br><span class="description">' . esc_html( $summary ) . '</span>';
				}
				break;

			case 'ca_form_status':
				if ( cozy_addons_form_type_is_subscription( cozy_addons_form_entry_type( $post_id ) ) ) {
					echo '<span class="ca-form-badge ca-form-badge--subscriber">' . esc_html__( 'Subscriber', 'cozy-addons' ) . '</span>';
					break;
				}
				if ( ! cozy_addons_premium_access() ) {
					echo '<span class="ca-form-locked" aria-hidden="true">&mdash;</span><span class="screen-reader-text">' . esc_html__( 'Available in Pro', 'cozy-addons' ) . '</span>';
					break;
				}
				echo self::badge( (string) get_post_meta( $post_id, '_ca_form_status', true ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in badge().
				if ( cozy_addons_form_entry_is_overdue( $post_id ) ) {
					echo '<br><span class="ca-form-late">' . esc_html(
						sprintf(
							/* translators: %s: how long the entry has been waiting, e.g. "2 days" */
							__( 'Waiting %s', 'cozy-addons' ),
							human_time_diff( (int) get_post_time( 'U', true, $post_id ) )
						)
					) . '</span>';
				}
				break;
		}
	}

	/**
	 * Adds the Urgent view and, on Pro, per-status views above the list.
	 *
	 * @param array $views Default views.
	 * @return array
	 */
	public static function views( array $views ) {
		$is_pro  = cozy_addons_premium_access();
		$counts  = $is_pro ? self::status_counts() : array();
		$current = isset( $_GET['ca_form_status'] ) ? sanitize_key( wp_unslash( $_GET['ca_form_status'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$urgent  = ! empty( $_GET['ca_form_urgent'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$out     = array();

		foreach ( $views as $key => $html ) {
			if ( 'all' === $key && ( '' !== $current || $urgent ) ) {
				$html = preg_replace( '/ class="current"| aria-current="page"/', '', $html );
			}
			$out[ $key ] = $html;
			if ( 'all' === $key ) {
				$out['ca_form_urgent'] = sprintf(
					'<a href="%s"%s>%s <span class="count">(%d)</span></a>',
					esc_url( cozy_addons_form_admin_url( '', array( 'ca_form_urgent' => 1 ) ) ),
					$urgent ? ' class="current" aria-current="page"' : '',
					esc_html__( 'Urgent', 'cozy-addons' ),
					self::urgent_count()
				);
				if ( ! $is_pro ) {
					continue;
				}
				foreach ( cozy_addons_form_entry_statuses() as $slug => $label ) {
					$url                       = add_query_arg(
						array(
							'post_type'      => self::TYPE,
							'ca_form_status' => $slug,
						),
						admin_url( 'edit.php' )
					);
					$out[ 'ca_form_' . $slug ] = sprintf(
						'<a href="%s"%s>%s <span class="count">(%d)</span></a>',
						esc_url( $url ),
						$current === $slug ? ' class="current" aria-current="page"' : '',
						esc_html( $label ),
						$counts[ $slug ] ?? 0
					);
				}
			}
		}

		return $out;
	}

	/**
	 * Prints the form filter dropdown and the CSV export button.
	 *
	 * @param string $post_type Current post type.
	 * @return void
	 */
	public static function filters( $post_type ) {
		if ( self::TYPE !== $post_type ) {
			return;
		}
		global $wpdb;
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Read-only filter values.
		$form     = isset( $_GET['ca_form_name'] ) ? sanitize_text_field( wp_unslash( $_GET['ca_form_name'] ) ) : '';
		$status   = isset( $_GET['ca_form_status'] ) ? sanitize_key( wp_unslash( $_GET['ca_form_status'] ) ) : '';
		$type     = isset( $_GET['ca_form_type'] ) ? sanitize_key( wp_unslash( $_GET['ca_form_type'] ) ) : '';
		$category = isset( $_GET['ca_form_category'] ) ? sanitize_key( wp_unslash( $_GET['ca_form_category'] ) ) : '';
		$urgent   = ! empty( $_GET['ca_form_urgent'] );
		// phpcs:enable
		$forms = wp_cache_get( 'form_names', 'cozy_addons_forms' );
		if ( false === $forms ) {
			$forms = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value <> '' ORDER BY meta_value ASC LIMIT 50", '_ca_form_name' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery -- Small distinct list, cached below.
			wp_cache_set( 'form_names', $forms, 'cozy_addons_forms', 60 );
		}

		echo '<select name="ca_form_name"><option value="">' . esc_html__( 'All forms', 'cozy-addons' ) . '</option>';
		foreach ( $forms as $name ) {
			printf( '<option value="%1$s"%2$s>%1$s</option>', esc_attr( $name ), selected( $form, $name, false ) );
		}
		echo '</select>';

		echo '<select name="ca_form_type"><option value="">' . esc_html__( 'All types', 'cozy-addons' ) . '</option>';
		foreach ( cozy_addons_form_types() as $slug => $label ) {
			printf( '<option value="%s"%s>%s</option>', esc_attr( $slug ), selected( $type, $slug, false ), esc_html( $label ) );
		}
		echo '</select>';

		echo '<select name="ca_form_category"><option value="">' . esc_html__( 'All categories', 'cozy-addons' ) . '</option>';
		foreach ( cozy_addons_form_categories() as $slug => $label ) {
			printf( '<option value="%s"%s>%s</option>', esc_attr( $slug ), selected( $category, $slug, false ), esc_html( $label ) );
		}
		echo '</select>';
		if ( $urgent ) {
			echo '<input type="hidden" name="ca_form_urgent" value="1">';
		}

		if ( cozy_addons_premium_access() ) {
			echo '<a class="button" href="' . esc_url(
				Entries_Export::url(
					array(
						'ca_form_status'   => $status,
						'ca_form_name'     => $form,
						'ca_form_type'     => $type,
						'ca_form_category' => $category,
						'ca_form_urgent'   => $urgent ? 1 : '',
					)
				)
			) . '">' . esc_html__( 'Export CSV', 'cozy-addons' ) . '</a>';
		} else {
			echo '<a class="button ca-form-locked-button" href="https://cozythemes.com/pricing-and-plans/" target="_blank" rel="noopener">' . esc_html__( 'Export CSV', 'cozy-addons' );
			cozy_addons_form_print_pro_label();
			echo '</a>';
		}
	}

	/**
	 * Applies the status and form filters to the inbox query.
	 *
	 * @param \WP_Query $query Current query.
	 * @return void
	 */
	public static function filter_query( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() || self::TYPE !== $query->get( 'post_type' ) ) {
			return;
		}
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Read-only list filtering.
		$status   = isset( $_GET['ca_form_status'] ) && cozy_addons_premium_access() ? sanitize_key( wp_unslash( $_GET['ca_form_status'] ) ) : '';
		$form     = isset( $_GET['ca_form_name'] ) ? sanitize_text_field( wp_unslash( $_GET['ca_form_name'] ) ) : '';
		$type     = isset( $_GET['ca_form_type'] ) ? sanitize_key( wp_unslash( $_GET['ca_form_type'] ) ) : '';
		$category = isset( $_GET['ca_form_category'] ) ? sanitize_key( wp_unslash( $_GET['ca_form_category'] ) ) : '';
		$urgent   = ! empty( $_GET['ca_form_urgent'] );
		// phpcs:enable
		$mq = self::build_meta_query( $status, $form, $type, $category, $urgent );
		if ( $mq ) {
			$query->set( 'meta_query', $mq ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- Admin-only list filter.
		}
	}

	/**
	 * Adds quick status links to each row.
	 *
	 * @param array   $actions Default actions.
	 * @param WP_Post $post    Entry post.
	 * @return array
	 */
	public static function row_actions( array $actions, WP_Post $post ) {
		if ( self::TYPE !== $post->post_type ) {
			return $actions;
		}
		unset( $actions['inline hide-if-no-js'], $actions['view'] );

		$is_spam = Entry_Post_Type::SPAM === $post->post_status;
		$url     = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'cozy_addons_form_set_spam',
					'entry'  => $post->ID,
					'spam'   => $is_spam ? 0 : 1,
				),
				admin_url( 'admin-post.php' )
			),
			'cozy_addons_form_spam_' . $post->ID
		);
		$actions['ca_form_spam'] = '<a href="' . esc_url( $url ) . '">' . ( $is_spam ? esc_html__( 'Not spam', 'cozy-addons' ) : esc_html__( 'Spam', 'cozy-addons' ) ) . '</a>';

		if ( $is_spam || cozy_addons_form_type_is_subscription( cozy_addons_form_entry_type( $post->ID ) ) ) {
			return $actions;
		}

		$is_urgent                 = '1' === get_post_meta( $post->ID, '_ca_form_urgent', true );
		$urgent_url                = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'cozy_addons_form_set_urgent',
					'entry'  => $post->ID,
					'urgent' => $is_urgent ? 0 : 1,
				),
				admin_url( 'admin-post.php' )
			),
			'cozy_addons_form_urgent_' . $post->ID
		);
		$actions['ca_form_urgent'] = '<a href="' . esc_url( $urgent_url ) . '">' . ( $is_urgent ? esc_html__( 'Not urgent', 'cozy-addons' ) : esc_html__( 'Mark urgent', 'cozy-addons' ) ) . '</a>';

		// Status links are Pro; Spam and Urgent above are free.
		if ( ! cozy_addons_premium_access() ) {
			return $actions;
		}

		$current = (string) get_post_meta( $post->ID, '_ca_form_status', true );
		foreach ( cozy_addons_form_entry_statuses() as $slug => $label ) {
			if ( $slug === $current || 'new' === $slug ) {
				continue;
			}
			$url = wp_nonce_url(
				add_query_arg(
					array(
						'action' => 'cozy_addons_form_set_status',
						'entry'  => $post->ID,
						'status' => $slug,
					),
					admin_url( 'admin-post.php' )
				),
				'cozy_addons_form_status_' . $post->ID
			);
			/* translators: %s: status label */
			$actions[ 'ca_form_' . $slug ] = '<a href="' . esc_url( $url ) . '">' . esc_html( sprintf( __( 'Mark %s', 'cozy-addons' ), strtolower( $label ) ) ) . '</a>';
		}

		return $actions;
	}

	/**
	 * Handles the one-click status links.
	 *
	 * @return void
	 */
	public static function set_status() {
		$id     = isset( $_GET['entry'] ) ? absint( $_GET['entry'] ) : 0;
		$status = isset( $_GET['status'] ) ? sanitize_key( wp_unslash( $_GET['status'] ) ) : '';
		check_admin_referer( 'cozy_addons_form_status_' . $id );

		if ( ! cozy_addons_premium_access() ) {
			wp_die( esc_html__( 'Entry statuses are available in Cozy Blocks Pro.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		if ( ! $id || ! isset( cozy_addons_form_entry_statuses()[ $status ] ) || self::TYPE !== get_post_type( $id ) || ! current_user_can( 'edit_post', $id ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		self::change_status( $id, $status );
		wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url( 'edit.php?post_type=' . self::TYPE ) );
		exit;
	}

	/**
	 * Moves an entry to or out of Spam.
	 *
	 * "Not spam" restores it to the inbox; the email it skipped is not sent afterwards.
	 *
	 * @param int  $entry_id Entry ID.
	 * @param bool $spam     True to mark as spam.
	 * @return bool True when the entry moved.
	 */
	public static function set_spam( $entry_id, $spam ) {
		$entry_id = (int) $entry_id;
		$target   = $spam ? Entry_Post_Type::SPAM : 'publish';
		if ( self::TYPE !== get_post_type( $entry_id ) || get_post_status( $entry_id ) === $target ) {
			return false;
		}
		$updated = wp_update_post(
			array(
				'ID'          => $entry_id,
				'post_status' => $target,
			),
			true
		);
		if ( is_wp_error( $updated ) ) {
			return false;
		}
		if ( ! cozy_addons_form_type_is_subscription( cozy_addons_form_entry_type( $entry_id ) ) ) {
			self::add_activity( $entry_id, 'status', $spam ? __( 'Marked as spam', 'cozy-addons' ) : __( 'Marked as not spam', 'cozy-addons' ) );
		}

		return true;
	}

	/**
	 * Handles the Spam / Not spam row links.
	 *
	 * @return void
	 */
	public static function set_spam_action() {
		$id = isset( $_GET['entry'] ) ? absint( $_GET['entry'] ) : 0;
		check_admin_referer( 'cozy_addons_form_spam_' . $id );

		if ( ! $id || self::TYPE !== get_post_type( $id ) || ! current_user_can( 'edit_post', $id ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		self::set_spam( $id, ! empty( $_GET['spam'] ) );
		wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url( 'edit.php?post_type=' . self::TYPE ) );
		exit;
	}

	/**
	 * Adds bulk status actions.
	 *
	 * @param array $actions Default actions.
	 * @return array
	 */
	public static function bulk_actions( array $actions ) {
		unset( $actions['edit'] );
		if ( cozy_addons_premium_access() ) {
			foreach ( cozy_addons_form_entry_statuses() as $slug => $label ) {
				/* translators: %s: status label */
				$actions[ 'ca_form_mark_' . $slug ] = sprintf( __( 'Mark as %s', 'cozy-addons' ), $label );
			}
		}
		$actions['ca_form_urgent']     = __( 'Mark urgent', 'cozy-addons' );
		$actions['ca_form_not_urgent'] = __( 'Not urgent', 'cozy-addons' );
		$actions['ca_form_spam']       = __( 'Mark as spam', 'cozy-addons' );
		$actions['ca_form_not_spam']   = __( 'Not spam', 'cozy-addons' );

		return $actions;
	}

	/**
	 * Applies a bulk status change.
	 *
	 * @param string $redirect Redirect URL.
	 * @param string $action   Bulk action.
	 * @param array  $ids      Selected entry IDs.
	 * @return string
	 */
	public static function handle_bulk( $redirect, $action, array $ids ) {
		if ( 'ca_form_urgent' === $action || 'ca_form_not_urgent' === $action ) {
			$n = 0;
			foreach ( $ids as $id ) {
				$id = absint( $id );
				if ( current_user_can( 'edit_post', $id ) && self::set_urgent( $id, 'ca_form_urgent' === $action ) ) {
					++$n;
				}
			}
			return add_query_arg( 'ca_form_bulk', $n, $redirect );
		}
		if ( 'ca_form_spam' === $action || 'ca_form_not_spam' === $action ) {
			$n = 0;
			foreach ( $ids as $id ) {
				$id = absint( $id );
				if ( current_user_can( 'edit_post', $id ) && self::set_spam( $id, 'ca_form_spam' === $action ) ) {
					++$n;
				}
			}
			return add_query_arg( 'ca_form_bulk', $n, $redirect );
		}
		if ( 0 !== strpos( $action, 'ca_form_mark_' ) ) {
			return $redirect;
		}
		$status = substr( $action, strlen( 'ca_form_mark_' ) );
		if ( ! isset( cozy_addons_form_entry_statuses()[ $status ] ) ) {
			return $redirect;
		}
		$n = 0;
		foreach ( $ids as $id ) {
			$id = absint( $id );
			// change_status() refuses on free sites, and for sign-ups.
			if ( self::TYPE === get_post_type( $id ) && current_user_can( 'edit_post', $id ) && self::change_status( $id, $status ) ) {
				++$n;
			}
		}

		return add_query_arg( 'ca_form_bulk', $n, $redirect );
	}

	/**
	 * Shows a notice after a bulk update.
	 *
	 * @return void
	 */
	public static function bulk_notice() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Read-only notice after a redirect.
		if ( empty( $_GET['ca_form_bulk'] ) || empty( $_GET['post_type'] ) || self::TYPE !== sanitize_key( wp_unslash( $_GET['post_type'] ) ) ) {
			return;
		}
		$count = absint( $_GET['ca_form_bulk'] );
		// phpcs:enable
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html(
			sprintf(
				/* translators: %d: number of entries */
				_n( '%d entry updated.', '%d entries updated.', $count, 'cozy-addons' ),
				$count
			)
		) . '</p></div>';
	}

	/**
	 * Registers the entry screen meta boxes. Sign-ups only have their details.
	 *
	 * @param WP_Post $post Entry post.
	 * @return void
	 */
	public static function meta_boxes( $post ) {
		add_meta_box( 'ca_form_details', __( 'Entry details', 'cozy-addons' ), array( __CLASS__, 'box_details' ), self::TYPE, 'normal', 'high' );
		if ( $post instanceof WP_Post && cozy_addons_form_type_is_subscription( cozy_addons_form_entry_type( $post->ID ) ) ) {
			return;
		}
		add_meta_box( 'ca_form_activity', __( 'Activity & notes', 'cozy-addons' ), array( __CLASS__, 'box_activity' ), self::TYPE, 'normal', 'default' );
		add_meta_box( 'ca_form_status', __( 'Status', 'cozy-addons' ), array( __CLASS__, 'box_status' ), self::TYPE, 'side', 'high' );
	}

	/**
	 * Prints the submitted details.
	 *
	 * @param WP_Post $post Entry post.
	 * @return void
	 */
	public static function box_details( WP_Post $post ) {
		$fields = get_post_meta( $post->ID, '_ca_form_fields', true );
		$fields = is_array( $fields ) ? $fields : array();
		$files  = get_post_meta( $post->ID, '_ca_form_files', true );
		$files  = is_array( $files ) ? $files : array();
		$page   = (string) get_post_meta( $post->ID, '_ca_form_page_url', true );
		$ptitle = (string) get_post_meta( $post->ID, '_ca_form_page_title', true );

		echo '<table class="ca-form-table"><tbody>';
		printf( '<tr><th>%s</th><td>%s</td></tr>', esc_html__( 'Form', 'cozy-addons' ), esc_html( (string) get_post_meta( $post->ID, '_ca_form_name', true ) ) );
		printf( '<tr><th>%s</th><td>%s</td></tr>', esc_html__( 'Type', 'cozy-addons' ), esc_html( cozy_addons_form_types()[ cozy_addons_form_entry_type( $post->ID ) ] ) );
		printf( '<tr><th>%s</th><td>%s</td></tr>', esc_html__( 'Received', 'cozy-addons' ), esc_html( get_the_date( '', $post ) . ' ' . get_the_time( '', $post ) ) );
		if ( $page ) {
			printf( '<tr><th>%s</th><td><a href="%s" target="_blank" rel="noopener">%s</a></td></tr>', esc_html__( 'Submitted on', 'cozy-addons' ), esc_url( $page ), esc_html( '' !== $ptitle ? $ptitle : $page ) );
		}

		foreach ( $fields as $row ) {
			$value = isset( $row['v'] ) ? (string) $row['v'] : '';
			if ( '' === $value ) {
				continue;
			}
			$type = $row['t'] ?? 'text';
			if ( 'email' === $type ) {
				$out = '<a href="mailto:' . esc_attr( $value ) . '">' . esc_html( $value ) . '</a>';
			} elseif ( 'tel' === $type ) {
				$out = '<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $value ) ) . '">' . esc_html( $value ) . '</a>';
			} elseif ( 'url' === $type ) {
				$out = '<a href="' . esc_url( $value ) . '" target="_blank" rel="noopener">' . esc_html( $value ) . '</a>';
			} elseif ( in_array( $type, array( 'file', 'image', 'signature' ), true ) ) {
				// Private files are only served through the download handler. Images and
				// signatures also show as thumbnails.
				$name  = (string) ( $row['n'] ?? '' );
				$items = array();
				foreach ( Form_Uploads::field_files( $files, $name ) as $index => $stored ) {
					if ( '' === Form_Uploads::path( $stored ) ) {
						$items[] = esc_html( (string) $stored['name'] ) . ' (' . esc_html__( 'file no longer available', 'cozy-addons' ) . ')';
						continue;
					}
					$link  = esc_url( Form_Uploads::download_url( $post->ID, $name, $index ) );
					$thumb = '';
					if ( 0 === strpos( (string) $stored['type'], 'image/' ) ) {
						$thumb = '<a href="' . $link . '"><img class="ca-form-file-thumb" src="' . esc_url( Form_Uploads::download_url( $post->ID, $name, $index, true ) ) . '" alt="' . esc_attr( (string) $stored['name'] ) . '"></a><br>';
					}
					$items[] = $thumb . '<a href="' . $link . '">' . esc_html( (string) $stored['name'] ) . '</a> (' . esc_html( size_format( (int) $stored['size'] ) ) . ')';
				}
				$out = $items ? implode( '<br>', $items ) : esc_html( $value ) . ' (' . esc_html__( 'file no longer available', 'cozy-addons' ) . ')';
			} else {
				$out = nl2br( esc_html( $value ) );
			}
			printf( '<tr><th>%s</th><td>%s</td></tr>', esc_html( (string) ( $row['l'] ?? '' ) ), $out ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
		}

		$product_id = (int) get_post_meta( $post->ID, '_ca_form_product_id', true );
		if ( $product_id && get_edit_post_link( $product_id ) ) {
			printf(
				'<tr><th>%s</th><td><a href="%s">%s</a></td></tr>',
				esc_html__( 'Edit product', 'cozy-addons' ),
				esc_url( get_edit_post_link( $product_id ) ),
				esc_html( (string) get_post_meta( $post->ID, '_ca_form_product_name', true ) )
			);
		}

		$notified = get_post_meta( $post->ID, '_ca_form_notified', true );
		if ( '' !== $notified ) {
			printf(
				'<tr><th>%s</th><td>%s</td></tr>',
				esc_html__( 'Email notification', 'cozy-addons' ),
				'1' === $notified ? esc_html__( 'Sent', 'cozy-addons' ) : '<span class="ca-form-warn">' . esc_html__( 'Failed to send. Check your site email setup (an SMTP plugin is recommended).', 'cozy-addons' ) . '</span>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped inline.
			);
		}
		echo '</tbody></table>';
	}

	/**
	 * Prints the status select (Pro) and the quick-contact buttons.
	 *
	 * @param WP_Post $post Entry post.
	 * @return void
	 */
	public static function box_status( $post ) {
		wp_nonce_field( 'ca_form_save_entry_' . $post->ID, 'ca_form_meta_nonce' );
		$current = (string) get_post_meta( $post->ID, '_ca_form_status', true );
		$email   = (string) get_post_meta( $post->ID, '_ca_form_email', true );
		$phone   = (string) get_post_meta( $post->ID, '_ca_form_phone', true );

		// Urgency is free: the flag, why it was set, and a checkbox to change it.
		$urgent = '1' === get_post_meta( $post->ID, '_ca_form_urgent', true );
		$reason = (string) get_post_meta( $post->ID, '_ca_form_urgent_reason', true );
		echo '<p><input type="hidden" name="ca_form_urgent_sent" value="1"><label><input type="checkbox" name="ca_form_urgent" value="1"' . checked( $urgent, true, false ) . '> <strong>' . esc_html__( 'Urgent', 'cozy-addons' ) . '</strong></label>';
		if ( $urgent && '' !== $reason ) {
			echo '<br><span class="description">' . esc_html( $reason ) . '</span>';
		}
		echo '</p>';

		if ( cozy_addons_premium_access() ) {
			echo '<p><label for="ca_form_status_select" class="screen-reader-text">' . esc_html__( 'Status', 'cozy-addons' ) . '</label>';
			echo '<select name="ca_form_status" id="ca_form_status_select" style="width:100%">';
			foreach ( cozy_addons_form_entry_statuses() as $slug => $label ) {
				printf( '<option value="%s"%s>%s</option>', esc_attr( $slug ), selected( $current, $slug, false ), esc_html( $label ) );
			}
			echo '</select></p>';
		} else {
			echo '<div class="ca-form-locked-panel"><p><strong>' . esc_html__( 'Track each entry from New to Won', 'cozy-addons' ) . '</strong> ';
			cozy_addons_form_print_pro_label();
			echo '</p><p>' . esc_html__( 'Mark entries as Contacted, Quoted, Won or Lost, filter the inbox by status and see how many new entries are waiting.', 'cozy-addons' ) . '</p>';
			echo '<p><a class="button" href="https://cozythemes.com/pricing-and-plans/" target="_blank" rel="noopener">' . esc_html__( 'Upgrade to Pro', 'cozy-addons' ) . '</a></p></div>';
		}

		if ( $email || $phone ) {
			echo '<p class="ca-form-quick">';
			if ( $phone ) {
				echo '<a class="button" href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html__( 'Call', 'cozy-addons' ) . '</a> ';
			}
			if ( $email ) {
				echo '<a class="button" href="mailto:' . esc_attr( $email ) . '">' . esc_html__( 'Email', 'cozy-addons' ) . '</a>';
			}
			echo '</p>';
		}
	}

	/**
	 * Prints the activity timeline and, on Pro, the add-note field.
	 *
	 * @param WP_Post $post Entry post.
	 * @return void
	 */
	public static function box_activity( $post ) {
		if ( ! cozy_addons_premium_access() ) {
			echo '<div class="ca-form-locked-panel"><p><strong>' . esc_html__( 'Keep notes and see the full history of each entry', 'cozy-addons' ) . '</strong> ';
			cozy_addons_form_print_pro_label();
			echo '</p><p>' . esc_html__( 'Record call outcomes and next steps, and see every status change with who made it and when.', 'cozy-addons' ) . '</p>';
			echo '<p><a class="button button-primary" href="https://cozythemes.com/pricing-and-plans/" target="_blank" rel="noopener">' . esc_html__( 'Upgrade to Pro', 'cozy-addons' ) . '</a></p></div>';
			return;
		}

		$log = get_post_meta( $post->ID, '_ca_form_activity', true );
		$log = is_array( $log ) ? array_reverse( $log ) : array();

		echo '<p><label for="ca_form_new_note" class="screen-reader-text">' . esc_html__( 'Add a note', 'cozy-addons' ) . '</label>';
		echo '<textarea name="ca_form_new_note" id="ca_form_new_note" rows="3" style="width:100%" placeholder="' . esc_attr__( 'Add a note (call outcome, reply sent, next step)…', 'cozy-addons' ) . '"></textarea>';
		echo '<span class="description">' . esc_html__( 'Saved when you click Update.', 'cozy-addons' ) . '</span></p>';

		echo '<ul class="ca-form-timeline">';
		foreach ( $log as $item ) {
			$time = isset( $item['t'] ) ? strtotime( $item['t'] . ' UTC' ) : 0;
			$user = ! empty( $item['u'] ) ? get_userdata( (int) $item['u'] ) : false;
			$kind = isset( $item['k'] ) && 'note' === $item['k'] ? 'note' : 'status';
			echo '<li class="ca-form-timeline__item ca-form-timeline__item--' . esc_attr( $kind ) . '">';
			echo '<span class="ca-form-timeline__meta" title="' . esc_attr( $time ? wp_date( 'Y-m-d H:i', $time ) : '' ) . '">';
			/* translators: %s: time since, e.g. "2 hours" */
			echo esc_html( $time ? sprintf( __( '%s ago', 'cozy-addons' ), human_time_diff( $time ) ) : '' );
			if ( $user ) {
				echo ' &middot; ' . esc_html( $user->display_name );
			}
			echo '</span>';
			echo '<span class="ca-form-timeline__text">' . nl2br( esc_html( isset( $item['x'] ) ? (string) $item['x'] : '' ) ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped before nl2br().
			echo '</li>';
		}
		echo '<li class="ca-form-timeline__item"><span class="ca-form-timeline__meta">' . esc_html( get_the_date( '', $post ) . ' ' . get_the_time( '', $post ) ) . '</span><span class="ca-form-timeline__text">' . esc_html__( 'Entry received', 'cozy-addons' ) . '</span></li>';
		echo '</ul>';
	}

	/**
	 * Saves the status and a new note, both Pro. change_status() checks Pro itself.
	 *
	 * @param int $post_id Entry ID.
	 * @return void
	 */
	public static function save_meta( $post_id ) {
		if ( ! isset( $_POST['ca_form_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ca_form_meta_nonce'] ) ), 'ca_form_save_entry_' . $post_id ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( isset( $_POST['ca_form_urgent_sent'] ) ) {
			self::set_urgent( $post_id, ! empty( $_POST['ca_form_urgent'] ) );
		}
		if ( isset( $_POST['ca_form_status'] ) ) {
			self::change_status( $post_id, sanitize_key( wp_unslash( $_POST['ca_form_status'] ) ) );
		}
		if ( isset( $_POST['ca_form_new_note'] ) && cozy_addons_premium_access() ) {
			$note = trim( sanitize_textarea_field( wp_unslash( $_POST['ca_form_new_note'] ) ) );
			if ( '' !== $note ) {
				self::add_activity( $post_id, 'note', mb_substr( $note, 0, 2000 ) );
			}
		}
	}
}
