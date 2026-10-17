<?php
/**
 * Lead Forms → Analytics: what needs attention, totals, trend and breakdowns at a glance.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the Analytics page. The status pipeline figures (contacted, completed, lost, win rate,
 * response time) are Pro and shown locked on free sites.
 */
final class Leads_Analytics {

	const PAGE = 'ca-leads-analytics';

	/**
	 * Registers hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
	}

	/**
	 * Adds Analytics under the Lead Forms menu, after Inbox.
	 *
	 * @return void
	 */
	public static function menu() {
		add_submenu_page(
			'edit.php?post_type=' . Entry_Post_Type::TYPE,
			__( 'Lead Analytics', 'cozy-addons' ),
			__( 'Analytics', 'cozy-addons' ),
			'edit_others_ca_form_entries', // phpcs:ignore WordPress.WP.Capabilities.Unknown -- Custom capability registered by this plugin.
			self::PAGE,
			array( __CLASS__, 'render' )
		);
	}

	/**
	 * Short label for a duration in hours, e.g. "35 min", "4.2 h" or "1.5 days".
	 *
	 * @param float|null $hours Hours, or null when unknown.
	 * @return string
	 */
	private static function duration( $hours ) {
		if ( null === $hours ) {
			return '—';
		}
		if ( $hours < 1 ) {
			/* translators: %d: minutes */
			return sprintf( __( '%d min', 'cozy-addons' ), max( 1, (int) round( $hours * 60 ) ) );
		}
		if ( $hours < 48 ) {
			/* translators: %s: hours */
			return sprintf( __( '%s h', 'cozy-addons' ), number_format_i18n( $hours, 1 ) );
		}
		/* translators: %s: days */
		return sprintf( __( '%s days', 'cozy-addons' ), number_format_i18n( $hours / 24, 1 ) );
	}

	/**
	 * Renders the page.
	 *
	 * @return void
	 */
	public static function render() {
		if ( ! current_user_can( 'edit_others_ca_form_entries' ) ) { // phpcs:ignore WordPress.WP.Capabilities.Unknown -- Custom capability registered by this plugin.
			wp_die( esc_html__( 'You are not allowed to view this page.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}

		$ranges = Leads_Stats::ranges();
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only range switch.
		$range  = isset( $_GET['range'] ) ? sanitize_key( wp_unslash( $_GET['range'] ) ) : 'month';
		$range  = isset( $ranges[ $range ] ) ? $range : 'month';
		$days   = $ranges[ $range ]['days'];
		$data   = Leads_Stats::compute( Leads_Stats::rows( $days ), $days );
		$is_pro = cozy_addons_premium_access();

		echo '<div class="wrap ca-leads-dash">';
		echo '<h1 class="wp-heading-inline">' . esc_html__( 'Lead Analytics', 'cozy-addons' ) . '</h1>';
		echo '<div class="ca-leads-dash__tools"><span class="ca-leads-range">';
		foreach ( $ranges as $slug => $info ) {
			printf(
				'<a href="%s" class="%s"%s>%s</a>',
				esc_url( cozy_addons_form_admin_url( self::PAGE, array( 'range' => $slug ) ) ),
				esc_attr( $slug === $range ? 'is-active' : '' ),
				$slug === $range ? ' aria-current="page"' : '',
				esc_html( $info['label'] )
			);
		}
		echo '</span> ';
		if ( $is_pro ) {
			echo '<a class="button" href="' . esc_url( Entries_Export::url() ) . '">' . esc_html__( 'Export CSV', 'cozy-addons' ) . '</a>';
		}
		echo '</div><hr class="wp-header-end">';

		$cur  = $data['cur'];
		$prev = $data['prev'];
		if ( 0 === $cur['leads'] + $prev['leads'] + $cur['subscribers'] + $prev['subscribers'] ) {
			self::empty_state();
			echo '</div>';
			return;
		}

		self::attention( $data, $is_pro );

		echo '<h2 class="ca-leads-section">' . esc_html__( 'At a glance', 'cozy-addons' ) . '</h2><div class="ca-leads-kpis">';
		$previous = static function ( $count ) {
			/* translators: %s: count in the previous period */
			return sprintf( __( 'previous period: %s', 'cozy-addons' ), number_format_i18n( $count ) );
		};
		self::kpi( __( 'New entries', 'cozy-addons' ), number_format_i18n( $cur['leads'] ), self::badge( Leads_Stats::delta( $cur['leads'], $prev['leads'] ) ), $previous( $prev['leads'] ) );
		self::kpi( __( 'Urgent', 'cozy-addons' ), number_format_i18n( $cur['urgent'] ), self::badge( Leads_Stats::delta( $cur['urgent'], $prev['urgent'] ), true ), $previous( $prev['urgent'] ), 'is-urgent' );
		self::kpi( __( 'Last 24 hours', 'cozy-addons' ), number_format_i18n( $data['today'] ), '', __( 'entries received today', 'cozy-addons' ) );
		self::kpi( __( 'Subscribers', 'cozy-addons' ), number_format_i18n( $cur['subscribers'] ), self::badge( Leads_Stats::delta( $cur['subscribers'], $prev['subscribers'] ) ), __( 'newsletter, waitlist and lead magnet sign-ups', 'cozy-addons' ) );
		echo '</div>';

		self::pipeline( $data, $is_pro );

		echo '<div class="ca-leads-panel ca-leads-panel--wide"><h2>' . esc_html( $data['monthly'] ? __( 'Entries per month', 'cozy-addons' ) : __( 'Entries per day', 'cozy-addons' ) ) . '</h2>';
		self::trend( $data );
		echo '</div>';

		echo '<div class="ca-leads-grid">';
		self::categories( $data );
		self::forms( $data, $is_pro );
		self::types( $data );
		echo '</div>';

		echo '<div class="ca-leads-grid">';
		self::funnel( $data, $is_pro );
		self::status_split( $data, $is_pro );
		echo '</div>';

		echo '<p class="description">' . esc_html__( 'Figures cover entries received in the selected period, compared with the period before it. Spam is left out, and newsletter, waitlist and lead magnet sign-ups are counted as subscribers. Completed means marked Won; win rate = won ÷ (won + lost).', 'cozy-addons' ) . '</p>';
		echo '</div>';
	}

	/**
	 * Shown before any entry exists.
	 *
	 * @return void
	 */
	private static function empty_state() {
		echo '<div class="ca-leads-panel ca-leads-empty"><h2>' . esc_html__( 'No entries yet', 'cozy-addons' ) . '</h2>';
		echo '<p>' . esc_html__( 'Add a Form block to a page and your first entries show up here: what is new, what is urgent, and how your forms are doing.', 'cozy-addons' ) . '</p>';
		echo '<p><a class="button button-primary" href="' . esc_url( admin_url( 'post-new.php?post_type=page' ) ) . '">' . esc_html__( 'Create a page with a form', 'cozy-addons' ) . '</a></p></div>';
	}

	/**
	 * "Needs attention": the newest urgent entries, and on Pro what is still open or waiting.
	 *
	 * @param array $data   Statistics.
	 * @param bool  $is_pro Pro access.
	 * @return void
	 */
	private static function attention( array $data, $is_pro ) {
		$open    = $is_pro ? Entries_Admin::open_urgent_count() : 0;
		$overdue = $is_pro ? Leads_Stats::overdue_count() : 0;
		if ( empty( $data['recent_urgent'] ) && 0 === $open && 0 === $overdue ) {
			return;
		}

		echo '<div class="ca-leads-attention"><h2>' . esc_html__( 'Needs attention', 'cozy-addons' ) . '</h2>';
		if ( $is_pro && ( $open || $overdue ) ) {
			echo '<p class="ca-leads-attention__counts">';
			if ( $open ) {
				echo '<a href="' . esc_url( cozy_addons_form_admin_url( '', array( 'ca_form_urgent' => 1 ) ) ) . '"><strong>' . esc_html(
					sprintf(
						/* translators: %d: number of entries */
						_n( '%d urgent entry is still open', '%d urgent entries are still open', $open, 'cozy-addons' ),
						$open
					)
				) . '</strong></a>';
			}
			if ( $overdue ) {
				echo ( $open ? ' &middot; ' : '' ) . '<a href="' . esc_url( cozy_addons_form_admin_url( '', array( 'ca_form_status' => 'new' ) ) ) . '">' . esc_html(
					sprintf(
						/* translators: 1: number of entries, 2: hours */
						_n( '%1$d new entry has waited more than %2$d hours', '%1$d new entries have waited more than %2$d hours', $overdue, 'cozy-addons' ),
						$overdue,
						(int) cozy_addons_form_settings()['overdue_hours']
					)
				) . '</a>';
			}
			echo '</p>';
		}

		if ( ! empty( $data['recent_urgent'] ) ) {
			echo '<ul class="ca-leads-attention__list">';
			foreach ( $data['recent_urgent'] as $entry_id ) {
				$phone  = (string) get_post_meta( $entry_id, '_ca_form_phone', true );
				$reason = (string) get_post_meta( $entry_id, '_ca_form_urgent_reason', true );
				echo '<li><span class="ca-form-urgent-pill">' . esc_html__( 'Urgent', 'cozy-addons' ) . '</span> <a href="' . esc_url( (string) get_edit_post_link( $entry_id ) ) . '">' . esc_html( get_the_title( $entry_id ) ) . '</a>';
				if ( '' !== $reason ) {
					echo ' <span class="description">' . esc_html( $reason ) . '</span>';
				}
				/* translators: %s: time since, e.g. "2 hours" */
				echo ' <span class="description">&middot; ' . esc_html( sprintf( __( '%s ago', 'cozy-addons' ), human_time_diff( (int) get_post_time( 'U', true, $entry_id ) ) ) ) . '</span>';
				if ( $phone ) {
					echo ' &middot; <a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>';
				}
				echo '</li>';
			}
			echo '</ul><a href="' . esc_url( cozy_addons_form_admin_url( '', array( 'ca_form_urgent' => 1 ) ) ) . '">' . esc_html__( 'Open all urgent entries', 'cozy-addons' ) . '</a>';
		}
		echo '</div>';
	}

	/**
	 * The status pipeline cards: Pro, shown locked on free sites.
	 *
	 * @param array $data   Statistics.
	 * @param bool  $is_pro Pro access.
	 * @return void
	 */
	private static function pipeline( array $data, $is_pro ) {
		$cur  = $data['cur'];
		$prev = $data['prev'];

		echo '<h2 class="ca-leads-section">' . esc_html__( 'Follow-up', 'cozy-addons' );
		if ( ! $is_pro ) {
			cozy_addons_form_print_pro_label();
		}
		echo '</h2><div class="ca-leads-kpis' . ( $is_pro ? '' : ' is-locked' ) . '">';

		if ( ! $is_pro ) {
			foreach ( array( __( 'Waiting for reply', 'cozy-addons' ), __( 'Contacted', 'cozy-addons' ), __( 'Completed', 'cozy-addons' ), __( 'Lost', 'cozy-addons' ), __( 'Win rate', 'cozy-addons' ), __( 'First response', 'cozy-addons' ) ) as $label ) {
				self::kpi( $label, '—', '', __( 'Available in Pro', 'cozy-addons' ) );
			}
			echo '</div><p class="ca-leads-upsell">' . esc_html__( 'Track each entry from New to Contacted, Completed or Lost, and see your win rate and how fast you reply.', 'cozy-addons' ) . ' <a class="button" href="https://cozythemes.com/pricing-and-plans/" target="_blank" rel="noopener">' . esc_html__( 'Upgrade to Pro', 'cozy-addons' ) . '</a></p>';
			return;
		}

		$waiting   = Entries_Admin::status_counts()['new'] ?? 0;
		$win_delta = ( null !== $cur['win_rate'] && null !== $prev['win_rate'] ) ? $cur['win_rate'] - $prev['win_rate'] : null;
		$res_delta = ( null !== $cur['median_hours'] && null !== $prev['median_hours'] ) ? Leads_Stats::delta( $cur['median_hours'], $prev['median_hours'] ) : null;

		self::kpi( __( 'Waiting for reply', 'cozy-addons' ), number_format_i18n( $waiting ), '', __( 'all entries still New', 'cozy-addons' ) );
		self::kpi( __( 'Contacted', 'cozy-addons' ), number_format_i18n( $cur['contacted'] ), self::badge( Leads_Stats::delta( $cur['contacted'], $prev['contacted'] ) ), __( 'replied to at least once', 'cozy-addons' ) );
		self::kpi( __( 'Completed', 'cozy-addons' ), number_format_i18n( $cur['won'] ), self::badge( Leads_Stats::delta( $cur['won'], $prev['won'] ) ), __( 'marked Won', 'cozy-addons' ) );
		self::kpi( __( 'Lost', 'cozy-addons' ), number_format_i18n( $cur['lost'] ), self::badge( Leads_Stats::delta( $cur['lost'], $prev['lost'] ), true ), __( 'marked Lost', 'cozy-addons' ) );
		self::kpi( __( 'Win rate', 'cozy-addons' ), null === $cur['win_rate'] ? '—' : number_format_i18n( $cur['win_rate'], 1 ) . '%', self::badge( $win_delta, false, ' pt' ), __( 'won ÷ (won + lost)', 'cozy-addons' ) );
		self::kpi( __( 'First response', 'cozy-addons' ), self::duration( $cur['median_hours'] ), self::badge( $res_delta, true ), __( 'median time to first status change', 'cozy-addons' ) );
		echo '</div>';
	}

	/**
	 * Change badge against the previous period.
	 *
	 * @param float|null $change          Percent or point change; null when not comparable.
	 * @param bool       $lower_is_better True when a decrease is good.
	 * @param string     $suffix          Unit suffix.
	 * @return string HTML.
	 */
	private static function badge( $change, $lower_is_better = false, $suffix = '%' ) {
		if ( null === $change ) {
			return '<span class="ca-leads-delta">' . esc_html__( 'no baseline', 'cozy-addons' ) . '</span>';
		}
		if ( abs( $change ) < 0.05 ) {
			return '<span class="ca-leads-delta">' . esc_html__( 'no change', 'cozy-addons' ) . '</span>';
		}
		$up   = $change > 0;
		$good = $lower_is_better ? ! $up : $up;

		return '<span class="ca-leads-delta ca-leads-delta--' . ( $good ? 'good' : 'bad' ) . '">' . ( $up ? '▲ ' : '▼ ' ) . esc_html( number_format_i18n( abs( $change ), 1 ) . $suffix ) . '</span>';
	}

	/**
	 * Prints one KPI card.
	 *
	 * @param string $label Label.
	 * @param string $value Display value.
	 * @param string $delta Badge HTML from badge(), or ''.
	 * @param string $hint  Small print.
	 * @param string $class Extra class.
	 * @return void
	 */
	private static function kpi( $label, $value, $delta, $hint, $class = '' ) {
		echo '<div class="ca-leads-kpi ' . esc_attr( $class ) . '"><span class="ca-leads-kpi__label">' . esc_html( $label ) . '</span><span class="ca-leads-kpi__value">' . esc_html( $value ) . '</span>';
		echo wp_kses( $delta, array( 'span' => array( 'class' => true ) ) );
		echo '<span class="ca-leads-kpi__hint">' . esc_html( $hint ) . '</span></div>';
	}

	/**
	 * Line chart of entries, with urgent entries as a second line. Ported from Cozy Leads.
	 *
	 * @param array $data Statistics.
	 * @return void
	 */
	private static function trend( array $data ) {
		$all     = $data['trend'];
		$urgent  = $data['trend_urgent'];
		$n       = count( $all );
		$w       = 900;
		$h       = 240;
		$left    = 38;
		$right   = 12;
		$top     = 12;
		$base    = 28;
		$max     = max( 1, max( $all ) );
		$max     = (int) ceil( $max / 4 ) * 4;
		$inner_w = $w - $left - $right;
		$inner_h = $h - $top - $base;
		$x       = static function ( $i ) use ( $n, $left, $inner_w ) {
			return $left + ( $n > 1 ? ( $i / ( $n - 1 ) ) * $inner_w : $inner_w / 2 );
		};
		$y       = static function ( $v ) use ( $top, $inner_h, $max ) {
			return $top + $inner_h - ( $v / $max ) * $inner_h;
		};
		$fmt     = static function ( $number ) {
			return number_format( (float) $number, 1, '.', '' );
		};

		$line_all    = array();
		$line_urgent = array();
		foreach ( $all as $i => $v ) {
			$line_all[]    = $fmt( $x( $i ) ) . ',' . $fmt( $y( $v ) );
			$line_urgent[] = $fmt( $x( $i ) ) . ',' . $fmt( $y( $urgent[ $i ] ) );
		}
		$area = $fmt( $x( 0 ) ) . ',' . $fmt( $top + $inner_h ) . ' ' . implode( ' ', $line_all ) . ' ' . $fmt( $x( $n - 1 ) ) . ',' . $fmt( $top + $inner_h );

		$svg = '<svg class="ca-leads-chart" viewBox="0 0 ' . (int) $w . ' ' . (int) $h . '" role="img" aria-label="' . esc_attr__( 'Entries and urgent entries over time', 'cozy-addons' ) . '" preserveAspectRatio="none">';
		for ( $g = 0; $g <= 4; $g++ ) {
			$gy   = $top + $inner_h - ( $g / 4 ) * $inner_h;
			$svg .= '<line x1="' . (int) $left . '" x2="' . (int) ( $w - $right ) . '" y1="' . $fmt( $gy ) . '" y2="' . $fmt( $gy ) . '" class="ca-leads-chart__grid"/>';
			$svg .= '<text x="' . (int) ( $left - 6 ) . '" y="' . $fmt( $gy + 4 ) . '" text-anchor="end" class="ca-leads-chart__label">' . esc_html( (string) round( ( $g / 4 ) * $max ) ) . '</text>';
		}
		$ticks = min( $data['monthly'] ? 12 : 6, $n );
		for ( $t = 0; $t < $ticks; $t++ ) {
			$i     = (int) round( $t * ( $n - 1 ) / max( 1, $ticks - 1 ) );
			$label = $data['monthly'] ? wp_date( 'M', strtotime( $data['trend_x'][ $i ] . '-15 12:00:00' ) ) : wp_date( 'M j', strtotime( $data['trend_x'][ $i ] . ' 12:00:00' ) );
			$svg  .= '<text x="' . $fmt( $x( $i ) ) . '" y="' . (int) ( $h - 8 ) . '" text-anchor="middle" class="ca-leads-chart__label">' . esc_html( $label ) . '</text>';
		}
		$svg .= '<polygon points="' . esc_attr( $area ) . '" class="ca-leads-chart__area"/>';
		$svg .= '<polyline points="' . esc_attr( implode( ' ', $line_all ) ) . '" class="ca-leads-chart__line"/>';
		$svg .= '<polyline points="' . esc_attr( implode( ' ', $line_urgent ) ) . '" class="ca-leads-chart__urgent"/>';
		$svg .= '</svg>';

		echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Built from integers, formatted floats and escaped strings above.
		echo '<p class="ca-leads-legend"><span class="ca-leads-legend__all"></span>' . esc_html__( 'All entries', 'cozy-addons' ) . ' <span class="ca-leads-legend__urgent"></span>' . esc_html__( 'Urgent', 'cozy-addons' ) . '</p>';
	}

	/**
	 * Prints one horizontal bar.
	 *
	 * @param string $label     Row label.
	 * @param int    $count     Row count.
	 * @param int    $max       Largest count, for scaling.
	 * @param string $css_class Colour class suffix.
	 * @param string $url       Optional link.
	 * @param string $note      Optional note on the right.
	 * @return void
	 */
	private static function bar( $label, $count, $max, $css_class, $url = '', $note = '' ) {
		$pct  = $max > 0 ? max( $count > 0 ? 2 : 0, round( ( $count / $max ) * 100 ) ) : 0;
		$name = $url ? '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>' : esc_html( $label );
		printf(
			'<div class="ca-leads-bar"><div class="ca-leads-bar__label">%s</div><div class="ca-leads-bar__track"><span class="ca-leads-bar__fill ca-leads-fill--%s" style="width:%d%%"></span></div><div class="ca-leads-bar__count">%d</div><div class="ca-leads-bar__note">%s</div></div>',
			wp_kses_post( $name ),
			esc_attr( sanitize_html_class( $css_class ) ),
			(int) $pct,
			(int) $count,
			esc_html( $note )
		);
	}

	/**
	 * Entries by form category, with how many were urgent.
	 *
	 * @param array $data Statistics.
	 * @return void
	 */
	private static function categories( array $data ) {
		echo '<div class="ca-leads-panel"><h2>' . esc_html__( 'By category', 'cozy-addons' ) . '</h2>';
		if ( empty( $data['categories'] ) ) {
			echo '<p class="description">' . esc_html__( 'No entries in this period.', 'cozy-addons' ) . '</p></div>';
			return;
		}
		$labels = cozy_addons_form_categories();
		$max    = max( array_column( $data['categories'], 'leads' ) );
		foreach ( $data['categories'] as $slug => $row ) {
			$url = '' !== $slug ? cozy_addons_form_admin_url( '', array( 'ca_form_category' => $slug ) ) : '';
			/* translators: %d: number of urgent entries */
			$note = $row['urgent'] ? sprintf( __( '%d urgent', 'cozy-addons' ), $row['urgent'] ) : '';
			self::bar( '' !== $slug ? $labels[ $slug ] : __( 'No category', 'cozy-addons' ), $row['leads'], $max, cozy_addons_form_category_is_urgent( $slug ) ? 'urgent' : 'default', $url, $note );
		}
		echo '</div>';
	}

	/**
	 * Entries per form.
	 *
	 * @param array $data   Statistics.
	 * @param bool  $is_pro Pro access, for the Completed column.
	 * @return void
	 */
	private static function forms( array $data, $is_pro ) {
		echo '<div class="ca-leads-panel"><h2>' . esc_html__( 'By form', 'cozy-addons' ) . '</h2>';
		if ( empty( $data['forms'] ) ) {
			echo '<p class="description">' . esc_html__( 'No entries in this period.', 'cozy-addons' ) . '</p></div>';
			return;
		}
		echo '<table class="ca-leads-data"><thead><tr><th>' . esc_html__( 'Form', 'cozy-addons' ) . '</th><th>' . esc_html__( 'Entries', 'cozy-addons' ) . '</th><th>' . esc_html__( 'Urgent', 'cozy-addons' ) . '</th>' . ( $is_pro ? '<th>' . esc_html__( 'Completed', 'cozy-addons' ) . '</th>' : '' ) . '</tr></thead><tbody>';
		foreach ( $data['forms'] as $row ) {
			echo '<tr><td><a href="' . esc_url( cozy_addons_form_admin_url( '', array( 'ca_form_name' => $row['name'] ) ) ) . '">' . esc_html( $row['name'] ) . '</a></td><td>' . esc_html( number_format_i18n( $row['leads'] ) ) . '</td><td>' . esc_html( number_format_i18n( $row['urgent'] ) ) . '</td>' . ( $is_pro ? '<td>' . esc_html( number_format_i18n( $row['won'] ) ) . '</td>' : '' ) . '</tr>';
		}
		echo '</tbody></table></div>';
	}

	/**
	 * Entries per form type, sign-ups included.
	 *
	 * @param array $data Statistics.
	 * @return void
	 */
	private static function types( array $data ) {
		echo '<div class="ca-leads-panel"><h2>' . esc_html__( 'By form type', 'cozy-addons' ) . '</h2>';
		if ( empty( $data['types'] ) ) {
			echo '<p class="description">' . esc_html__( 'No entries in this period.', 'cozy-addons' ) . '</p></div>';
			return;
		}
		$labels = cozy_addons_form_types();
		$max    = max( $data['types'] );
		foreach ( $data['types'] as $slug => $count ) {
			self::bar( $labels[ $slug ], $count, $max, 'type-' . $slug, cozy_addons_form_admin_url( '', array( 'ca_form_type' => $slug ) ) );
		}
		echo '</div>';
	}

	/**
	 * Received → Contacted → Completed for entries of the period. Pro.
	 *
	 * @param array $data   Statistics.
	 * @param bool  $is_pro Pro access.
	 * @return void
	 */
	private static function funnel( array $data, $is_pro ) {
		echo '<div class="ca-leads-panel' . ( $is_pro ? '' : ' is-locked' ) . '"><h2>' . esc_html__( 'Follow-up funnel', 'cozy-addons' );
		if ( ! $is_pro ) {
			cozy_addons_form_print_pro_label();
		}
		echo '</h2>';
		if ( ! $is_pro ) {
			echo '<p class="description">' . esc_html__( 'See how many entries you contacted and completed.', 'cozy-addons' ) . '</p></div>';
			return;
		}
		$cur    = $data['cur'];
		$stages = array(
			'received'  => array( __( 'Received', 'cozy-addons' ), $cur['leads'] ),
			'contacted' => array( __( 'Contacted', 'cozy-addons' ), $cur['contacted'] ),
			'won'       => array( __( 'Completed', 'cozy-addons' ), $cur['won'] ),
			'lost'      => array( __( 'Lost', 'cozy-addons' ), $cur['lost'] ),
		);
		$top    = max( 1, $cur['leads'] );
		foreach ( $stages as $key => $stage ) {
			self::bar( $stage[0] . ' · ' . number_format_i18n( ( $stage[1] / $top ) * 100, 0 ) . '%', $stage[1], $top, $key );
		}
		echo '</div>';
	}

	/**
	 * Where the period's entries stand now. Pro.
	 *
	 * @param array $data   Statistics.
	 * @param bool  $is_pro Pro access.
	 * @return void
	 */
	private static function status_split( array $data, $is_pro ) {
		echo '<div class="ca-leads-panel' . ( $is_pro ? '' : ' is-locked' ) . '"><h2>' . esc_html__( 'Where entries stand now', 'cozy-addons' );
		if ( ! $is_pro ) {
			cozy_addons_form_print_pro_label();
		}
		echo '</h2>';
		if ( ! $is_pro ) {
			echo '<p class="description">' . esc_html__( 'Split this period\'s entries by status: New, Contacted, Quoted, Won and Lost.', 'cozy-addons' ) . '</p></div>';
			return;
		}
		$max = max( 1, max( $data['statuses'] ) );
		foreach ( cozy_addons_form_entry_statuses() as $slug => $label ) {
			self::bar( $label, $data['statuses'][ $slug ] ?? 0, $max, $slug, cozy_addons_form_admin_url( '', array( 'ca_form_status' => $slug ) ) );
		}
		echo '</div>';
	}
}
