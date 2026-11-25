<?php
/**
 * Cozy Blocks → Search: settings and search insights.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Search;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin page of the Advanced Search block, under the Cozy Blocks menu.
 */
final class Search_Admin {

	const PAGE = 'ca-search-settings';

	/**
	 * Hooks the page and its actions.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ), 20 );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'assets' ) );
		add_action( 'admin_post_ca_search_clear_cache', array( __CLASS__, 'do_clear_cache' ) );
		add_action( 'admin_post_ca_search_clear_data', array( __CLASS__, 'do_clear_data' ) );
		add_action( 'admin_post_ca_search_export', array( __CLASS__, 'do_export' ) );
	}

	/**
	 * URL of the page.
	 *
	 * @param array $args Extra query arguments.
	 * @return string
	 */
	public static function url( $args = array() ) {
		return add_query_arg( array_merge( array( 'page' => self::PAGE ), $args ), admin_url( 'admin.php' ) );
	}

	/**
	 * Adds Search under the Cozy Blocks menu.
	 *
	 * @return void
	 */
	public static function menu() {
		add_submenu_page(
			'_cozy_companions',
			__( 'Advanced Search', 'cozy-addons' ),
			__( 'Search', 'cozy-addons' ),
			'manage_options',
			self::PAGE,
			array( __CLASS__, 'render' )
		);
	}

	/**
	 * Registers the setting.
	 *
	 * @return void
	 */
	public static function register() {
		register_setting(
			Search_Settings::GROUP,
			Search_Settings::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( Search_Settings::class, 'sanitize' ),
				'default'           => Search_Settings::defaults(),
				'show_in_rest'      => false,
			)
		);
	}

	/**
	 * Styles of the page.
	 *
	 * @param string $hook Current admin page.
	 * @return void
	 */
	public static function assets( $hook ) {
		if ( false === strpos( (string) $hook, self::PAGE ) ) {
			return;
		}
		wp_enqueue_style( 'cozy-addons--search-admin', COZY_ADDONS_PLUGIN_URL . 'admin/assets/css/search-admin.css', array(), COZY_ADDONS_VERSION );
	}

	/**
	 * Checks the capability and nonce of an admin-post action.
	 *
	 * @param string $action Action name.
	 * @param bool   $pro    Whether the action needs Pro.
	 * @return void
	 */
	private static function guard( $action, $pro = false ) {
		if ( ! current_user_can( 'manage_options' ) || ( $pro && ! cozy_addons_premium_access() ) ) {
			wp_die( esc_html__( 'You do not have permission to do this.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		check_admin_referer( $action );
	}

	/**
	 * Returns to the page with a notice.
	 *
	 * @param string $tab  Tab.
	 * @param string $done Notice.
	 * @return void
	 */
	private static function back( $tab, $done ) {
		wp_safe_redirect(
			self::url(
				array(
					'tab'  => $tab,
					'done' => $done,
				)
			)
		);
		exit;
	}

	/**
	 * Clears cached results.
	 *
	 * @return void
	 */
	public static function do_clear_cache() {
		self::guard( 'ca_search_clear_cache' );
		Search_Engine::bump();
		delete_transient( 'ca_search_popular' );
		self::back( 'settings', 'cache' );
	}

	/**
	 * Deletes all recorded searches (Pro).
	 *
	 * @return void
	 */
	public static function do_clear_data() {
		self::guard( 'ca_search_clear_data', true );
		Search_Analytics::clear();
		self::back( 'insights', 'data' );
	}

	/**
	 * Downloads the recorded searches as CSV (Pro).
	 *
	 * @return void
	 */
	public static function do_export() {
		self::guard( 'ca_search_export', true );
		nocache_headers();
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="search-insights-' . gmdate( 'Y-m-d' ) . '.csv"' );
		$out = fopen( 'php://output', 'w' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		fputcsv( $out, array( 'term', 'searches', 'last_result_count', 'zero_result_searches', 'clicks', 'last_seen_utc' ) );
		foreach ( Search_Analytics::top( 3650, 5000 ) as $row ) {
			$term = $row['term'];
			if ( preg_match( '/^[=+\-@\t\r]/', $term ) ) {
				$term = "'" . $term; // Neutralises spreadsheet formula injection.
			}
			fputcsv( $out, array( $term, $row['hits'], $row['results'], $row['zero_hits'], $row['clicks'], $row['last_seen'] ) );
		}
		fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		exit;
	}

	/* ----------------------------------------------------------------- views */

	/**
	 * Renders the page.
	 *
	 * @return void
	 */
	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only tab switch.
		$tab  = ( isset( $_GET['tab'] ) && 'insights' === $_GET['tab'] ) ? 'insights' : 'settings';
		$tabs = array(
			'settings' => __( 'Settings', 'cozy-addons' ),
			'insights' => __( 'Insights & tools', 'cozy-addons' ),
		);
		?>
		<div class="wrap ca-search-admin">
			<h1><?php esc_html_e( 'Advanced Search', 'cozy-addons' ); ?></h1>
			<p><?php esc_html_e( 'These settings apply to every Advanced Search block. Each block can override the display options in its sidebar.', 'cozy-addons' ); ?></p>
			<?php
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Notice after a redirect.
			$done = isset( $_GET['done'] ) ? sanitize_key( wp_unslash( $_GET['done'] ) ) : '';
			if ( '' !== $done ) {
				$msg = 'data' === $done ? __( 'Search analytics cleared.', 'cozy-addons' ) : __( 'Search cache cleared.', 'cozy-addons' );
				echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $msg ) . '</p></div>';
			}
			?>
			<nav class="nav-tab-wrapper">
				<?php foreach ( $tabs as $slug => $label ) : ?>
					<a class="nav-tab<?php echo $slug === $tab ? ' nav-tab-active' : ''; ?>" href="<?php echo esc_url( self::url( 'settings' === $slug ? array() : array( 'tab' => $slug ) ) ); ?>"<?php echo $slug === $tab ? ' aria-current="page"' : ''; ?>>
						<?php echo esc_html( $label ); ?>
						<?php
						if ( 'insights' === $slug && ! cozy_addons_premium_access() ) {
							self::pro_label();
						}
						?>
					</a>
				<?php endforeach; ?>
			</nav>
			<?php 'insights' === $tab ? self::insights() : self::settings(); ?>
		</div>
		<?php
	}

	/**
	 * Prints the "PRO" label.
	 *
	 * @return void
	 */
	private static function pro_label() {
		echo '<span class="ca-search-pro-label">' . esc_html__( 'PRO', 'cozy-addons' ) . '</span>';
	}

	/**
	 * Upgrade link for free sites.
	 *
	 * @param string $text What the feature does.
	 * @return void
	 */
	private static function upsell( $text ) {
		printf(
			'<div class="ca-search-upsell"><p>%1$s</p><a class="button button-primary" href="%2$s" target="_blank" rel="noopener">%3$s</a></div>',
			esc_html( $text ),
			esc_url( 'https://cozythemes.com/pricing-and-plans/' ),
			esc_html__( 'Upgrade to Pro', 'cozy-addons' )
		);
	}

	/**
	 * One checkbox setting.
	 *
	 * @param array  $s      Settings.
	 * @param string $key    Setting.
	 * @param string $label  Label.
	 * @param string $help   Help text.
	 * @param bool   $locked Disabled on free sites.
	 * @return void
	 */
	private static function checkbox( $s, $key, $label, $help = '', $locked = false ) {
		printf(
			'<label class="ca-search-check%6$s"><input type="checkbox" name="%1$s[%2$s]" value="1" %3$s%7$s> %4$s%8$s</label>%5$s',
			esc_attr( Search_Settings::OPTION ),
			esc_attr( $key ),
			checked( ! empty( $s[ $key ] ), true, false ),
			esc_html( $label ),
			$help ? '<p class="description ca-search-check-help">' . esc_html( $help ) . '</p>' : '',
			$locked ? ' is-locked' : '',
			$locked ? ' disabled' : '',
			$locked ? ' <span class="ca-search-pro-label">' . esc_html__( 'PRO', 'cozy-addons' ) . '</span>' : ''
		);
	}

	/**
	 * One number setting.
	 *
	 * @param array  $s    Settings.
	 * @param string $key  Setting.
	 * @param int    $min  Minimum.
	 * @param int    $max  Maximum.
	 * @param string $help Help text.
	 * @return void
	 */
	private static function number( $s, $key, $min, $max, $help = '' ) {
		printf(
			'<input type="number" class="small-text" name="%1$s[%2$s]" value="%3$d" min="%4$d" max="%5$d">%6$s',
			esc_attr( Search_Settings::OPTION ),
			esc_attr( $key ),
			(int) $s[ $key ],
			(int) $min,
			(int) $max,
			$help ? '<p class="description">' . esc_html( $help ) . '</p>' : ''
		);
	}

	/**
	 * Settings tab.
	 *
	 * @return void
	 */
	private static function settings() {
		$s      = Search_Settings::stored();
		$name   = Search_Settings::OPTION;
		$is_pro = cozy_addons_premium_access();
		$lock   = ! $is_pro;
		$pts    = get_post_types( array( 'public' => true ), 'objects' );
		$taxs   = get_taxonomies( array( 'public' => true ), 'objects' );
		?>
		<form method="post" action="options.php">
			<?php settings_fields( Search_Settings::GROUP ); ?>

			<h2><?php esc_html_e( 'Content to search', 'cozy-addons' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Post types', 'cozy-addons' ); ?></th>
					<td>
						<?php foreach ( $pts as $pt ) : ?>
							<label class="ca-search-inline"><input type="checkbox" name="<?php echo esc_attr( $name ); ?>[post_types][]" value="<?php echo esc_attr( $pt->name ); ?>" <?php checked( in_array( $pt->name, $s['post_types'], true ) ); ?>> <?php echo esc_html( $pt->labels->name ); ?></label>
						<?php endforeach; ?>
						<p class="description"><?php esc_html_e( 'Defaults for every search block. Each block can override this.', 'cozy-addons' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Taxonomies', 'cozy-addons' ); ?></th>
					<td>
						<?php foreach ( $taxs as $tx ) : ?>
							<label class="ca-search-inline"><input type="checkbox" name="<?php echo esc_attr( $name ); ?>[taxonomies][]" value="<?php echo esc_attr( $tx->name ); ?>" <?php checked( in_array( $tx->name, $s['taxonomies'], true ) ); ?>> <?php echo esc_html( $tx->labels->name ); ?></label>
						<?php endforeach; ?>
						<p class="description"><?php esc_html_e( 'Used for "topic" suggestions and, when enabled below, for matching term names.', 'cozy-addons' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ca-search-exclude"><?php esc_html_e( 'Exclude post IDs', 'cozy-addons' ); ?></label></th>
					<td><input id="ca-search-exclude" type="text" class="regular-text" name="<?php echo esc_attr( $name ); ?>[exclude_ids]" value="<?php echo esc_attr( $s['exclude_ids'] ); ?>" placeholder="12, 45, 78"></td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Relevance', 'cozy-addons' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Matching', 'cozy-addons' ); ?></th>
					<td>
						<?php
						self::checkbox( $s, 'search_content', __( 'Search post content', 'cozy-addons' ), __( 'Titles and excerpts are always searched. Turn off content on very large sites for faster queries.', 'cozy-addons' ) );
						self::checkbox( $s, 'search_terms', __( 'Match category / tag names', 'cozy-addons' ) );
						self::checkbox( $s, 'fuzzy_matching', __( 'Typo tolerance and "Did you mean"', 'cozy-addons' ), __( 'Used when a search finds nothing: tolerates typos, transposed letters and partial words in titles.', 'cozy-addons' ), $lock );
						self::checkbox( $s, 'native_search', __( 'Also improve the theme\'s search results page (?s=)', 'cozy-addons' ), __( 'Applies the same ranking to the full results page.', 'cozy-addons' ), $lock );
						self::checkbox( $s, 'woo_enabled', __( 'WooCommerce: show price, stock, SKU and rating', 'cozy-addons' ), class_exists( 'WooCommerce' ) ? '' : __( 'WooCommerce is not active.', 'cozy-addons' ), $lock );
						?>
					</td>
				</tr>
				<tr class="<?php echo $lock ? 'ca-search-is-locked' : ''; ?>">
					<th scope="row">
						<label for="ca-search-meta"><?php esc_html_e( 'Custom fields to search', 'cozy-addons' ); ?></label>
						<?php
						if ( $lock ) {
							self::pro_label();
						}
						?>
					</th>
					<td>
						<input id="ca-search-meta" type="text" class="regular-text" name="<?php echo esc_attr( $name ); ?>[meta_keys]" value="<?php echo esc_attr( $s['meta_keys'] ); ?>" placeholder="_sku, isbn"<?php disabled( $lock ); ?>>
						<p class="description"><?php esc_html_e( 'Comma-separated meta keys. An exact match ranks first (great for SKUs).', 'cozy-addons' ); ?></p>
					</td>
				</tr>
				<tr class="<?php echo $lock ? 'ca-search-is-locked' : ''; ?>">
					<th scope="row">
						<label for="ca-search-syn"><?php esc_html_e( 'Synonyms', 'cozy-addons' ); ?></label>
						<?php
						if ( $lock ) {
							self::pro_label();
						}
						?>
					</th>
					<td>
						<textarea id="ca-search-syn" rows="5" class="large-text code" name="<?php echo esc_attr( $name ); ?>[synonyms]" placeholder="tee, t-shirt, tshirt&#10;sofa, couch"<?php disabled( $lock ); ?>><?php echo esc_textarea( $s['synonyms'] ); ?></textarea>
						<p class="description"><?php esc_html_e( 'One group per line, words separated by commas. Visitors typing any word also find the others.', 'cozy-addons' ); ?></p>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Defaults for the search block', 'cozy-addons' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Results', 'cozy-addons' ); ?></th>
					<td>
						<?php
						self::checkbox( $s, 'group_results', __( 'Group results by content type', 'cozy-addons' ) );
						self::checkbox( $s, 'show_tabs', __( 'Show type filter tabs', 'cozy-addons' ) );
						self::checkbox( $s, 'show_images', __( 'Show thumbnails', 'cozy-addons' ) );
						self::checkbox( $s, 'show_excerpts', __( 'Show excerpts (centred on the match)', 'cozy-addons' ) );
						self::checkbox( $s, 'highlight', __( 'Highlight matching words', 'cozy-addons' ) );
						self::checkbox( $s, 'show_view_all', __( 'Show "View all results" link', 'cozy-addons' ) );
						self::checkbox( $s, 'load_more', __( 'Load more results in the search window ("Show more results" button)', 'cozy-addons' ), '', $lock );
						self::checkbox( $s, 'taxonomy_suggestions', __( 'Suggest matching categories / tags', 'cozy-addons' ) );
						self::checkbox( $s, 'shortcut', __( 'Open with Ctrl/⌘ + K', 'cozy-addons' ) );
						self::checkbox( $s, 'recent_searches', __( 'Remember each visitor\'s recent searches (in their browser)', 'cozy-addons' ), '', $lock );
						self::checkbox( $s, 'query_suggestions', __( 'Suggest searches other visitors made', 'cozy-addons' ), '', $lock );
						self::checkbox( $s, 'popular_searches', __( 'Show popular searches', 'cozy-addons' ), '', $lock );
						?>
					</td>
				</tr>
				<tr><th scope="row"><?php esc_html_e( 'Results per search', 'cozy-addons' ); ?></th><td><?php self::number( $s, 'per_page', 1, 20 ); ?></td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Minimum characters', 'cozy-addons' ); ?></th><td><?php self::number( $s, 'min_chars', 1, 5 ); ?></td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Typing delay (ms)', 'cozy-addons' ); ?></th><td><?php self::number( $s, 'debounce', 0, 2000 ); ?></td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Recent searches shown', 'cozy-addons' ); ?></th><td><?php self::number( $s, 'recent_limit', 0, 20 ); ?></td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Popular searches shown', 'cozy-addons' ); ?></th><td><?php self::number( $s, 'popular_limit', 0, 20 ); ?></td></tr>
			</table>

			<h2><?php esc_html_e( 'Performance & privacy', 'cozy-addons' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr><th scope="row"><?php esc_html_e( 'Cache results (seconds)', 'cozy-addons' ); ?></th><td><?php self::number( $s, 'cache_seconds', 0, 86400, __( '0 disables caching. The cache is cleared automatically when content changes.', 'cozy-addons' ) ); ?></td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Rate limit (uncached searches / minute / visitor)', 'cozy-addons' ); ?></th><td><?php self::number( $s, 'rate_limit', 0, 1000, __( '0 disables the limit.', 'cozy-addons' ) ); ?></td></tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Analytics', 'cozy-addons' ); ?></th>
					<td>
						<?php
						self::checkbox(
							$s,
							'track_searches',
							__( 'Record search terms to power Insights, popular searches and suggestions', 'cozy-addons' ),
							__( 'Only the search text and counters are stored. No IP addresses or user IDs. Emails, URLs and long numbers are never stored.', 'cozy-addons' )
								. ( $lock ? ' ' . __( 'Searches are recorded on the free version too, so your Insights are ready when you upgrade to Pro.', 'cozy-addons' ) : '' )
						);
						?>
						<p><?php self::number( $s, 'retention_days', 7, 730, __( 'Days to keep terms that nobody searched for again.', 'cozy-addons' ) ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>

		<h2><?php esc_html_e( 'Cache', 'cozy-addons' ); ?></h2>
		<p><?php self::tool_button( 'ca_search_clear_cache', __( 'Clear search cache', 'cozy-addons' ), false ); ?></p>
		<?php
	}

	/**
	 * Table of search terms.
	 *
	 * @param array  $rows  Rows.
	 * @param string $empty Text when there are none.
	 * @return void
	 */
	private static function table( $rows, $empty ) {
		if ( ! $rows ) {
			echo '<p>' . esc_html( $empty ) . '</p>';
			return;
		}
		echo '<table class="widefat striped ca-search-table"><thead><tr>';
		foreach ( array( __( 'Search term', 'cozy-addons' ), __( 'Searches', 'cozy-addons' ), __( 'Results', 'cozy-addons' ), __( 'Clicks', 'cozy-addons' ), __( 'Last searched', 'cozy-addons' ) ) as $h ) {
			echo '<th>' . esc_html( $h ) . '</th>';
		}
		echo '</tr></thead><tbody>';
		foreach ( $rows as $r ) {
			printf(
				'<tr><td>%s</td><td>%d</td><td>%d</td><td>%d</td><td>%s</td></tr>',
				esc_html( $r['term'] ),
				(int) $r['hits'],
				(int) $r['results'],
				(int) $r['clicks'],
				esc_html( get_date_from_gmt( $r['last_seen'], get_option( 'date_format' ) ) )
			);
		}
		echo '</tbody></table>';
	}

	/**
	 * Insights tab (Pro).
	 *
	 * @return void
	 */
	private static function insights() {
		if ( ! cozy_addons_premium_access() ) {
			self::upsell(
				__( 'See what visitors search for, which searches find nothing (content gaps) and how often results get clicked. Includes popular and suggested searches in the block, and CSV export.', 'cozy-addons' )
				. ( Search_Settings::get( 'track_searches' ) ? ' ' . __( 'Searches are already being recorded, so your Insights are ready as soon as you upgrade.', 'cozy-addons' ) : '' )
			);
			return;
		}
		if ( ! Search_Settings::get( 'track_searches' ) ) {
			echo '<div class="notice notice-info inline"><p>' . esc_html__( 'Recording search terms is turned off under Settings → Analytics, so no new searches are added.', 'cozy-addons' ) . '</p></div>';
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only filter.
		$days = isset( $_GET['days'] ) ? absint( $_GET['days'] ) : 30;
		$days = in_array( $days, array( 7, 30, 90 ), true ) ? $days : 30;
		$t    = Search_Analytics::totals( $days );
		$ctr  = $t['hits'] > 0 ? round( 100 * $t['clicks'] / $t['hits'] ) : 0;
		$zero = $t['hits'] > 0 ? round( 100 * $t['zero_hits'] / $t['hits'] ) : 0;
		?>
		<p class="ca-search-range">
			<?php foreach ( array( 7, 30, 90 ) as $d ) : ?>
				<a class="button <?php echo $d === $days ? 'button-primary' : ''; ?>" href="<?php echo esc_url( self::url( array( 'tab' => 'insights', 'days' => $d ) ) ); ?>">
					<?php /* translators: %d: number of days */ echo esc_html( sprintf( _n( 'Last %d day', 'Last %d days', $d, 'cozy-addons' ), $d ) ); ?>
				</a>
			<?php endforeach; ?>
		</p>

		<div class="ca-search-stats">
			<div class="ca-search-stat"><span class="ca-search-stat__value"><?php echo esc_html( number_format_i18n( (int) $t['hits'] ) ); ?></span><span class="ca-search-stat__label"><?php esc_html_e( 'Searches', 'cozy-addons' ); ?></span></div>
			<div class="ca-search-stat"><span class="ca-search-stat__value"><?php echo esc_html( number_format_i18n( (int) $t['terms'] ) ); ?></span><span class="ca-search-stat__label"><?php esc_html_e( 'Distinct terms', 'cozy-addons' ); ?></span></div>
			<div class="ca-search-stat"><span class="ca-search-stat__value"><?php echo esc_html( $ctr . '%' ); ?></span><span class="ca-search-stat__label"><?php esc_html_e( 'Led to a click', 'cozy-addons' ); ?></span></div>
			<div class="ca-search-stat"><span class="ca-search-stat__value"><?php echo esc_html( $zero . '%' ); ?></span><span class="ca-search-stat__label"><?php esc_html_e( 'Found nothing', 'cozy-addons' ); ?></span></div>
		</div>

		<h2><?php esc_html_e( 'Top searches', 'cozy-addons' ); ?></h2>
		<?php self::table( Search_Analytics::top( $days, 25 ), __( 'No searches recorded yet.', 'cozy-addons' ) ); ?>

		<h2><?php esc_html_e( 'Searches with no results (content gaps)', 'cozy-addons' ); ?></h2>
		<p class="description"><?php esc_html_e( 'Add content, synonyms or redirects for these and your search gets better immediately.', 'cozy-addons' ); ?></p>
		<?php self::table( Search_Analytics::top( $days, 25, true ), __( 'Nothing here. Every recorded search found something.', 'cozy-addons' ) ); ?>

		<h2><?php esc_html_e( 'Tools', 'cozy-addons' ); ?></h2>
		<p>
			<?php
			self::tool_button( 'ca_search_export', __( 'Export CSV', 'cozy-addons' ), false );
			self::tool_button( 'ca_search_clear_cache', __( 'Clear search cache', 'cozy-addons' ), false );
			self::tool_button( 'ca_search_clear_data', __( 'Delete all analytics', 'cozy-addons' ), true );
			?>
		</p>
		<?php
	}

	/**
	 * Button of an admin-post action.
	 *
	 * @param string $action  Action.
	 * @param string $label   Label.
	 * @param bool   $confirm Ask before running.
	 * @return void
	 */
	private static function tool_button( $action, $label, $confirm ) {
		$url = wp_nonce_url( admin_url( 'admin-post.php?action=' . $action ), $action );
		printf(
			'<a class="button" href="%s" %s>%s</a> ',
			esc_url( $url ),
			$confirm ? 'onclick="return confirm(\'' . esc_js( __( 'Are you sure? This cannot be undone.', 'cozy-addons' ) ) . '\')"' : '',
			esc_html( $label )
		);
	}
}
