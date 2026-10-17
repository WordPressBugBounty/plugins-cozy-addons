<?php
/**
 * Form entry custom post type.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Entries are stored as a private post type that only administrators can see.
 * Access uses dedicated capabilities (edit_ca_form_entries, etc.) granted to the Administrator role.
 */
final class Entry_Post_Type {

	const TYPE = 'ca_form_entry';

	// Entries Akismet flagged. Kept out of the inbox and its counts, deleted after 30 days.
	const SPAM = 'ca_form_spam';

	/**
	 * Registers hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register' ) );
		add_action( 'init', array( __CLASS__, 'grant_caps' ), 20 );
	}

	/**
	 * Registers the entry post type.
	 *
	 * @return void
	 */
	public static function register() {
		register_post_type(
			self::TYPE,
			array(
				'labels'              => array(
					'name'               => __( 'Form Entries', 'cozy-addons' ),
					'singular_name'      => __( 'Form Entry', 'cozy-addons' ),
					// Distinct from the "Leads" menu of the standalone Cozy Leads plugin.
					'menu_name'          => __( 'Lead Forms', 'cozy-addons' ),
					'all_items'          => __( 'Inbox', 'cozy-addons' ),
					'edit_item'          => __( 'Form Entry', 'cozy-addons' ),
					'search_items'       => __( 'Search entries', 'cozy-addons' ),
					'not_found'          => __( 'No entries yet. They appear here when someone submits a Cozy Form block.', 'cozy-addons' ),
					'not_found_in_trash' => __( 'No entries in the trash.', 'cozy-addons' ),
				),
				'public'              => false,
				'show_ui'             => true,
				// Its own top-level menu: Lead Forms → Inbox, Analytics, Settings.
				'show_in_menu'        => true,
				'menu_position'       => 26,
				'show_in_rest'        => false,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'rewrite'             => false,
				'query_var'           => false,
				'menu_icon'           => self::menu_icon(),
				'supports'            => array( 'title' ),
				'capability_type'     => array( 'ca_form_entry', 'ca_form_entries' ),
				'map_meta_cap'        => true,
				// Entries are created by form submissions only, never by hand.
				'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
			)
		);

		// List tables only show a status view for post types that have posts in it, so this stays on Form Entries.
		register_post_status(
			self::SPAM,
			array(
				'label'                     => _x( 'Spam', 'form entry status', 'cozy-addons' ),
				'public'                    => false,
				'internal'                  => false,
				'protected'                 => true,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => false,
				'show_in_admin_status_list' => true,
				/* translators: %s: number of spam entries */
				'label_count'               => _n_noop( 'Spam <span class="count">(%s)</span>', 'Spam <span class="count">(%s)</span>', 'cozy-addons' ),
			)
		);
	}

	/**
	 * Menu icon: a form with two fields and a button. A single-colour SVG, so WordPress tints it to
	 * match the admin colour scheme like a dashicon.
	 *
	 * @return string Data URI.
	 */
	private static function menu_icon() {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="black" fill-rule="evenodd" d="M2 2h16v4H2zm1.5 1.5v1h13v-1zM2 7.5h16v6H2zM3.5 9v3h13V9zM2 15h9v3H2z"/></svg>';

		return 'data:image/svg+xml;base64,' . base64_encode( $svg ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Data URI for the menu icon, as WordPress expects.
	}

	/**
	 * Gives Administrators the entry capabilities. Runs once per plugin version.
	 *
	 * @return void
	 */
	public static function grant_caps() {
		if ( get_option( 'ca_form_entry_caps_version' ) === COZY_ADDONS_VERSION ) {
			return;
		}

		$role = get_role( 'administrator' );
		$type = get_post_type_object( self::TYPE );
		if ( ! $role || ! $type ) {
			return;
		}

		$skip = array( 'edit_post', 'read_post', 'delete_post', 'create_posts' );
		foreach ( (array) $type->cap as $key => $cap ) {
			if ( ! in_array( $key, $skip, true ) ) {
				$role->add_cap( $cap );
			}
		}

		update_option( 'ca_form_entry_caps_version', COZY_ADDONS_VERSION );
	}
}
