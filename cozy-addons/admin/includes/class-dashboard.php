<?php
/**
 * Dashboard tab data.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Data for the Dashboard tab: links, personas and the setup checklist.
 *
 * Holds no hooks. The Dashboard partials in admin/pages/dashboard/ read from it,
 * and the `cozy_addons_dashboard_state` AJAX handler writes through it.
 *
 * @package CozyAddons
 */
class Dashboard {
	/**
	 * Option that stores the chosen persona and the manually ticked checklist items.
	 *
	 * @var string
	 */
	const STATE_OPTION = 'ca_dashboard_state';

	/**
	 * Transient that caches whether any post contains a Cozy block.
	 *
	 * @var string
	 */
	const BLOCK_USAGE_TRANSIENT = 'ca_dashboard_block_usage';

	/**
	 * Every URL the Dashboard tab links to, in one place.
	 *
	 * @return array<string,string>
	 */
	public static function links() {
		$library_enabled = self::is_pattern_library_enabled();
		$blocks_tab      = \CozyAddons\Helpers\Utils::is_block_theme() ? 'blocks' : 'settings';

		return array(
			'docs'              => 'https://docs.cozythemes.com/cozy-blocks',
			'support_forum'     => 'https://wordpress.org/support/plugin/cozy-addons/',
			'support'           => 'https://cozythemes.com/support',
			'live_demo'         => 'https://cozythemes.com/cozy-addons',
			'demo_site'         => 'https://app.zipwp.com/wp?plugins=cozy-addons',
			'walkthrough'       => 'https://www.youtube.com/watch?v=fNwIqedPyEU',
			'pricing'           => 'https://cozythemes.com/pricing-and-plans',
			'popup_demo'        => 'https://cozyblock.cozythemes.com/popup-builder-gutenberg-block/',
			'library_templates' => $library_enabled ? admin_url( 'post-new.php?post_type=page&ca_library=templates' ) : 'https://cozythemes.com/website-templates?tab=template',
			'library_patterns'  => $library_enabled ? admin_url( 'post-new.php?post_type=page&ca_library=patterns' ) : 'https://cozythemes.com/website-templates',
			'new_page'          => admin_url( 'post-new.php?post_type=page' ),
			'pages'             => admin_url( 'edit.php?post_type=page' ),
			'block_themes'      => admin_url( 'theme-install.php?browse=block-themes' ),
			'blocks_tab'        => admin_url( 'admin.php?page=_cozy_companions&tab=' . $blocks_tab ),
			'free_pro_tab'      => admin_url( 'admin.php?page=_cozy_companions&tab=free-pro-comparison' ),
		);
	}

	/**
	 * Whether the editor Design Library (pattern library utility) is turned on.
	 *
	 * @return bool
	 */
	public static function is_pattern_library_enabled() {
		$value = get_option( 'ca--utility--pattern-library' );

		return '1' === $value || '' == $value; // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual -- Unset option means enabled.
	}

	/**
	 * Personas offered under "What are you building?", with the tip each one shows.
	 *
	 * @return array<string,array{title:string,subtitle:string,tip:string}>
	 */
	public static function personas() {
		return array(
			'clients'  => array(
				'title'    => __( 'Client’s sites', 'cozy-addons' ),
				'subtitle' => __( 'Freelancer or agency', 'cozy-addons' ),
				'tip'      => __( 'Import a homepage template for your client’s niche, then customise it in the Site Editor. Pro adds the polish clients notice: scroll animations and before/after reveals.', 'cozy-addons' ),
			),
			'store'    => array(
				'title'    => __( 'Online store', 'cozy-addons' ),
				'subtitle' => __( 'WooCommerce', 'cozy-addons' ),
				'tip'      => __( 'Start from a shop template and drop product grids and categories onto your homepage. Pro adds Quick View, Wishlist and product sliders that shorten the path to checkout.', 'cozy-addons' ),
			),
			'magazine' => array(
				'title'    => __( 'Blog or magazine', 'cozy-addons' ),
				'subtitle' => __( 'Publishing', 'cozy-addons' ),
				'tip'      => __( 'Pick a blog template, then add post grids and carousels to surface your latest stories. Pro adds magazine layouts, a news ticker and trending and related posts.', 'cozy-addons' ),
			),
			'business' => array(
				'title'    => __( 'My business', 'cozy-addons' ),
				'subtitle' => __( 'Getting started', 'cozy-addons' ),
				'tip'      => __( 'Import a template for your industry and add a contact form so enquiries land in your inbox. Pro adds booking and lead-capture forms and popups that turn visitors into leads.', 'cozy-addons' ),
			),
		);
	}

	/**
	 * Saved Dashboard state.
	 *
	 * @return array{persona:string,done:string[]}
	 */
	public static function get_state() {
		$state = get_option( self::STATE_OPTION, array() );
		$state = is_array( $state ) ? $state : array();

		$persona = isset( $state['persona'] ) && is_string( $state['persona'] ) ? $state['persona'] : '';
		$done    = isset( $state['done'] ) && is_array( $state['done'] ) ? array_values( array_filter( $state['done'], 'is_string' ) ) : array();

		if ( ! array_key_exists( $persona, self::personas() ) ) {
			$persona = 'clients';
		}

		return array(
			'persona' => $persona,
			'done'    => $done,
		);
	}

	/**
	 * Saves the chosen persona.
	 *
	 * @param string $persona Persona key.
	 * @return bool False when the persona is unknown.
	 */
	public static function set_persona( $persona ) {
		if ( ! array_key_exists( $persona, self::personas() ) ) {
			return false;
		}

		$state            = self::get_state();
		$state['persona'] = $persona;
		update_option( self::STATE_OPTION, $state, false );

		return true;
	}

	/**
	 * Ticks or unticks a checklist item by hand.
	 *
	 * @param string $item Checklist item key.
	 * @param bool   $done New state.
	 * @return bool False when the item is unknown or cannot be ticked by hand.
	 */
	public static function set_item_done( $item, $done ) {
		$definitions = self::checklist_definitions();

		if ( ! isset( $definitions[ $item ] ) || empty( $definitions[ $item ]['manual'] ) ) {
			return false;
		}

		$state = self::get_state();
		$list  = array_diff( $state['done'], array( $item ) );

		if ( $done ) {
			$list[] = $item;
		}

		$state['done'] = array_values( $list );
		update_option( self::STATE_OPTION, $state, false );

		return true;
	}

	/**
	 * Static parts of the setup checklist.
	 *
	 * `manual` items can be ticked by the user; the rest are detected only.
	 *
	 * @return array<string,array>
	 */
	private static function checklist_definitions() {
		$links = self::links();

		return array(
			'block-theme' => array(
				'title'       => __( 'Use a block theme', 'cozy-addons' ),
				'description' => __( 'Cozy Blocks is built for the Site Editor. This is detected automatically.', 'cozy-addons' ),
				'action'      => __( 'Browse themes', 'cozy-addons' ),
				'url'         => $links['block_themes'],
				'manual'      => false,
			),
			'template'    => array(
				'title'       => __( 'Import a starter template', 'cozy-addons' ),
				'description' => __( 'Start from a finished design for your niche instead of a blank page.', 'cozy-addons' ),
				'action'      => __( 'Choose a template', 'cozy-addons' ),
				'url'         => $links['library_templates'],
				'manual'      => true,
			),
			'pattern'     => array(
				'title'       => __( 'Insert a pattern', 'cozy-addons' ),
				'description' => __( 'Add a hero, pricing table or testimonials section in one click.', 'cozy-addons' ),
				'action'      => __( 'Open patterns', 'cozy-addons' ),
				'url'         => $links['library_patterns'],
				'manual'      => true,
			),
			'cozy-block'  => array(
				'title'       => __( 'Try a Cozy block', 'cozy-addons' ),
				'description' => __( 'Open any page and search for "Cozy" in the inserter.', 'cozy-addons' ),
				'action'      => __( 'Edit a page', 'cozy-addons' ),
				'url'         => $links['pages'],
				'manual'      => true,
			),
			'keep-fast'   => array(
				'title'       => __( 'Keep it fast', 'cozy-addons' ),
				'description' => __( 'Disable blocks you do not use. Disabled blocks load zero scripts or styles.', 'cozy-addons' ),
				'action'      => __( 'Open Block Manager', 'cozy-addons' ),
				'url'         => $links['blocks_tab'],
				'manual'      => true,
			),
		);
	}

	/**
	 * Setup checklist with each item's done flag.
	 *
	 * @return array<string,array> Keyed by item; each has title, description, action, url, manual, done, auto.
	 */
	public static function get_checklist() {
		$state = self::get_state();
		$auto  = array(
			'block-theme' => \CozyAddons\Helpers\Utils::is_block_theme(),
			'cozy-block'  => self::has_used_cozy_block(),
			'keep-fast'   => self::has_disabled_blocks(),
		);

		$items = array();

		foreach ( self::checklist_definitions() as $key => $item ) {
			$is_auto      = ! empty( $auto[ $key ] );
			$item['auto'] = $is_auto;
			$item['done'] = $is_auto || ( $item['manual'] && in_array( $key, $state['done'], true ) );

			$items[ $key ] = $item;
		}

		return $items;
	}

	/**
	 * Whether any saved content uses a Cozy block.
	 *
	 * The answer is cached for an hour; once it is true it is kept for good.
	 *
	 * @return bool
	 */
	private static function has_used_cozy_block() {
		$state = self::get_state();

		if ( in_array( 'cozy-block:auto', $state['done'], true ) ) {
			return true;
		}

		$cached = get_transient( self::BLOCK_USAGE_TRANSIENT );

		if ( false !== $cached ) {
			return '1' === $cached;
		}

		global $wpdb;

		$found = (bool) $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts} WHERE post_type <> 'revision' AND post_status <> 'auto-draft' AND post_content LIKE %s LIMIT 1",
				'%' . $wpdb->esc_like( '<!-- wp:cozy-block/' ) . '%'
			)
		);

		if ( $found ) {
			$state['done'][] = 'cozy-block:auto';
			update_option( self::STATE_OPTION, $state, false );
		}

		set_transient( self::BLOCK_USAGE_TRANSIENT, $found ? '1' : '0', HOUR_IN_SECONDS );

		return $found;
	}

	/**
	 * Whether at least one Cozy block has been turned off in the Block Manager.
	 *
	 * @return bool
	 */
	private static function has_disabled_blocks() {
		global $wpdb;

		return (bool) $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->prepare(
				"SELECT option_id FROM {$wpdb->options} WHERE option_name LIKE %s AND option_value = '0' LIMIT 1",
				$wpdb->esc_like( 'cozy-block--' ) . '%'
			)
		);
	}
}
