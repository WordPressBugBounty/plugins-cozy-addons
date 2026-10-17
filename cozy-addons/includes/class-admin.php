<?php
namespace CozyAddons;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles admin-specific functionality for the Cozy Addons plugin.
 *
 * This singleton class loads necessary files and features
 * required for the WordPress admin area.
 *
 * @package CozyAddons
 */
class Admin {
	/**
	 * Singleton instance of the class.
	 *
	 * @var Admin|null
	 */
	private static $instance = null;

	/**
	 * Absolute path to the admin directory.
	 *
	 * @var string
	 */
	private static $dir = COZY_ADDONS_PLUGIN_DIR . 'admin/';

	/**
	 * URL to the admin directory.
	 *
	 * @var string
	 */
	private static $url = COZY_ADDONS_PLUGIN_URL . 'admin/';

	/**
	 * Slug of the plugin's top-level admin menu.
	 *
	 * @var string
	 */
	private static $menu_slug = '_cozy_companions';

	/**
	 * Post types listed under the plugin menu, in display order.
	 *
	 * @var string[]
	 */
	private static $menu_post_types = array(
		'ca_mega_menu',
		'ca_portfolio_gallery',
		'ca_faq',
		'ca_testimonial',
		'ca_popup_builder',
	);

	/**
	 * Returns the singleton instance of the Admin class.
	 *
	 * @return Admin The singleton instance.
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * Initializes admin functionality by loading necessary admin files.
	 *
	 * @access private
	 */
	private function __construct() {
		require self::$dir . 'includes/class-admin-ajax.php';
		\CozyAddons\Admin\Ajax::get_instance();

		$this->load_admin_files();

		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );

		add_action( 'admin_menu', array( $this, 'register_plugin_menu' ), 9 );
		// After Freemius, which adds its own items at priority 999999999.
		add_action( 'admin_menu', array( $this, 'organize_plugin_menu' ), PHP_INT_MAX );

		add_filter( 'parent_file', array( $this, 'set_taxonomy_parent_file' ) );
		add_filter( 'submenu_file', array( $this, 'set_taxonomy_submenu_file' ) );

		add_action( 'current_screen', array( $this, 'add_taxonomy_links' ) );
	}

	/**
	 * Loads admin-specific files.
	 *
	 * Includes files only when in the WordPress admin dashboard.
	 *
	 * @return void
	 */
	private function load_admin_files() {
		require_once self::$dir . 'admin-notice.php';
	}

	/**
	 * Enqueues admin-specific styles and scripts for the Cozy Addons plugin.
	 *
	 * This function checks if the current screen is the plugin's admin page and,
	 * if so, enqueues the necessary styles and scripts, along with localized data
	 * for AJAX usage.
	 */
	public function load_admin_assets() {
		$current_screen = get_current_screen();

		wp_enqueue_style( 'cozy-addons--admin-notice--style', self::$url . 'assets/css/admin-notice-styles.css', array(), COZY_ADDONS_VERSION, 'all' );
		wp_enqueue_script( 'cozy-addons--cpt-seeder-script', self::$url . 'assets/js/cpt-seeder.js', array( 'jquery' ), COZY_ADDONS_VERSION, false );
		wp_localize_script(
			'cozy-addons--cpt-seeder-script',
			'ajax_object',
			array(
				'ajax_url'             => esc_url( admin_url( 'admin-ajax.php' ) ),
				'utilityFunctionNonce' => wp_create_nonce( 'ca_utility_function' ),
			)
		);

		$allowed_pages = array(
			'dashboard',
			'plugins',
			'toplevel_page__cozy_companions',
		);

		if ( ! in_array( $current_screen->id, $allowed_pages, true ) ) {
			return;
		}

		wp_enqueue_style( 'cozy-addons--admin-style', self::$url . 'assets/css/admin-styles.css', array(), COZY_ADDONS_VERSION, 'all' );
		wp_enqueue_script( 'cozy-addons--admin-script', self::$url . 'assets/js/admin-scripts.js', array( 'jquery' ), COZY_ADDONS_VERSION, false );
		wp_localize_script(
			'cozy-addons--admin-script',
			'ajax_object',
			array(
				'ajax_url'             => esc_url( admin_url( 'admin-ajax.php' ) ),
				'isPremium'            => cozy_addons_premium_access(),
				'activeStatusNonce'    => wp_create_nonce( 'ca_active_status' ),
				'utilityFunctionNonce' => wp_create_nonce( 'ca_utility_function' ),
				'themePluginNonce'     => wp_create_nonce( 'ca_theme_plugin_install_activate' ),
			)
		);
	}

	/**
	 * Registers the admin menu and submenu for the Cozy Addons plugin.
	 *
	 * Adds a top-level menu and a corresponding submenu page in the WordPress admin dashboard
	 * under the "Cozy Blocks" label. The menu is only registered if it does not already exist.
	 */
	public function register_plugin_menu() {
		if ( ! menu_page_url( '_cozy_companions' ) ) {
			add_menu_page( 'Cozy Blocks', 'Cozy Blocks', 'manage_options', '_cozy_companions', array( $this, 'cozy_companion_info' ), self::$url . 'assets/img/ct_logo.png', '2' );
			add_submenu_page(
				'_cozy_companions',
				'Dashboard',
				__( 'Dashboard', 'cozy-addons' ),
				'manage_options',
				'_cozy_companions'
			);
			add_submenu_page(
				'_cozy_companions',
				'Blocks',
				__( 'Blocks', 'cozy-addons' ),
				'manage_options',
				'_cozy_companions&tab=blocks',
				array( $this, 'cozy_companion_info' )
			);
			add_submenu_page(
				'_cozy_companions',
				'Settings',
				__( 'Settings', 'cozy-addons' ),
				'manage_options',
				'_cozy_companions&tab=settings',
				array( $this, 'cozy_companion_info' )
			);
			add_submenu_page(
				'_cozy_companions',
				'Free VS Pro',
				__( 'Free VS Pro', 'cozy-addons' ),
				'manage_options',
				'_cozy_companions&tab=free-pro-comparison',
				array( $this, 'cozy_companion_info' )
			);
			if ( ! cozy_addons_premium_access() ) {
				add_submenu_page(
					'_cozy_companions',
					'License',
					__( 'Activate License', 'cozy-addons' ),
					'manage_options',
					'_cozy_companions&tab=license',
					array( $this, 'cozy_companion_info' )
				);
			}
		}
	}

	/**
	 * Sorts the plugin submenu into groups and marks where each group starts.
	 *
	 * Order: Dashboard | Blocks and the post types | Settings, Free VS Pro, License |
	 * everything else (the Freemius pages). Only the order, the post type labels and
	 * the CSS classes change; the slugs are left as registered.
	 */
	public function organize_plugin_menu() {
		global $submenu;

		$items = isset( $submenu[ self::$menu_slug ] ) ? array_values( $submenu[ self::$menu_slug ] ) : array();

		$post_type_slugs = array();

		foreach ( self::$menu_post_types as $post_type ) {
			$post_type_object = $this->get_menu_post_type_object( $post_type );

			if ( ! $post_type_object ) {
				continue;
			}

			$slug              = 'edit.php?post_type=' . $post_type;
			$post_type_slugs[] = $slug;
			$index             = array_search( $slug, array_column( $items, 2 ), true );

			if ( false !== $index ) {
				// Core labels the item with 'all_items'.
				$items[ $index ][0] = $post_type_object->labels->menu_name;
			} elseif ( current_user_can( $post_type_object->cap->edit_posts ) ) {
				// Freemius empties the submenu while its opt-in screen is pending.
				$items[] = array(
					$post_type_object->labels->menu_name,
					$post_type_object->cap->edit_posts,
					$slug,
					$post_type_object->labels->name,
				);
			}
		}

		if ( empty( $items ) ) {
			return;
		}

		// Keeps the top-level link on the plugin page instead of the first post type.
		if ( ! in_array( self::$menu_slug, array_column( $items, 2 ), true ) && current_user_can( 'manage_options' ) ) {
			$items[] = array( __( 'Dashboard', 'cozy-addons' ), 'manage_options', self::$menu_slug, 'Dashboard' );
		}

		$groups = array(
			array( self::$menu_slug ),
			array_merge( array( self::$menu_slug . '&tab=blocks' ), $post_type_slugs ),
			array(
				self::$menu_slug . '&tab=settings',
				self::$menu_slug . '&tab=free-pro-comparison',
				self::$menu_slug . '&tab=license',
			),
		);

		$sorted = array();

		foreach ( $groups as $slugs ) {
			$group = array();

			foreach ( $slugs as $slug ) {
				foreach ( $items as $index => $item ) {
					if ( $slug === $item[2] ) {
						$group[] = $item;
						unset( $items[ $index ] );
					}
				}
			}

			$sorted[] = $group;
		}

		// Whatever is left keeps its order in a last group.
		$sorted[] = array_values( $items );

		$organized = array();

		foreach ( $sorted as $group ) {
			if ( empty( $group ) ) {
				continue;
			}

			if ( ! empty( $organized ) ) {
				$group[0][4] = trim( ( isset( $group[0][4] ) ? $group[0][4] : '' ) . ' ca-menu-group-start' );
			}

			$organized = array_merge( $organized, $group );
		}

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$submenu[ self::$menu_slug ] = $organized;
	}

	/**
	 * Returns a post type's object when it is listed under the plugin menu.
	 *
	 * Users who cannot open the plugin menu keep the post types as top-level menus.
	 *
	 * @param string $post_type Post type name.
	 * @return \WP_Post_Type|null
	 */
	private function get_menu_post_type_object( $post_type ) {
		if ( ! in_array( $post_type, self::$menu_post_types, true ) ) {
			return null;
		}

		$post_type_object = get_post_type_object( $post_type );

		return $post_type_object && self::$menu_slug === $post_type_object->show_in_menu ? $post_type_object : null;
	}

	/**
	 * Returns the post type of the current taxonomy screen when that post type is
	 * listed under the plugin menu.
	 *
	 * @return string Post type name, or an empty string on any other screen.
	 */
	private function get_taxonomy_screen_post_type() {
		$screen = get_current_screen();

		if ( ! $screen || ! in_array( $screen->base, array( 'edit-tags', 'term' ), true ) ) {
			return '';
		}

		return $this->get_menu_post_type_object( $screen->post_type ) ? $screen->post_type : '';
	}

	/**
	 * Keeps the plugin menu open on the taxonomy screens of its post types.
	 *
	 * @param string $parent_file The parent file.
	 * @return string
	 */
	public function set_taxonomy_parent_file( $parent_file ) {
		return $this->get_taxonomy_screen_post_type() ? self::$menu_slug : $parent_file;
	}

	/**
	 * Highlights the post type's menu item on its taxonomy screens.
	 *
	 * @param string $submenu_file The submenu file.
	 * @return string
	 */
	public function set_taxonomy_submenu_file( $submenu_file ) {
		$post_type = $this->get_taxonomy_screen_post_type();

		return $post_type ? 'edit.php?post_type=' . $post_type : $submenu_file;
	}

	/**
	 * Hooks the links between a post type's list and its taxonomy screens.
	 *
	 * @param \WP_Screen $screen Current screen.
	 */
	public function add_taxonomy_links( $screen ) {
		if ( ! in_array( $screen->base, array( 'edit', 'edit-tags' ), true ) || ! $this->get_menu_post_type_object( $screen->post_type ) ) {
			return;
		}

		add_filter( 'views_' . $screen->id, array( $this, 'filter_taxonomy_links' ) );
	}

	/**
	 * Links a post type's list and its taxonomy screens to each other, as the
	 * taxonomy screens have no menu item.
	 *
	 * @param array $views Links above the list table.
	 * @return array
	 */
	public function filter_taxonomy_links( $views ) {
		$screen           = get_current_screen();
		$post_type_object = get_post_type_object( $screen->post_type );
		$links            = array();

		// Back to the post type's list from its taxonomy screens.
		if ( 'edit-tags' === $screen->base ) {
			$links['post-type'] = sprintf(
				'<a href="%s">%s</a>',
				esc_url( admin_url( 'edit.php?post_type=' . $post_type_object->name ) ),
				esc_html( $post_type_object->labels->all_items )
			);
		}

		foreach ( get_object_taxonomies( $post_type_object->name, 'objects' ) as $taxonomy ) {
			if ( ! $taxonomy->show_ui || ! current_user_can( $taxonomy->cap->manage_terms ) ) {
				continue;
			}

			$links[ 'taxonomy-' . $taxonomy->name ] = sprintf(
				'<a href="%s"%s>%s</a>',
				esc_url( admin_url( 'edit-tags.php?taxonomy=' . $taxonomy->name . '&post_type=' . $post_type_object->name ) ),
				$screen->taxonomy === $taxonomy->name ? ' class="current" aria-current="page"' : '',
				esc_html( $taxonomy->labels->name )
			);
		}

		return array_merge( $views, $links );
	}

	/**
	 * Includes the plugin's dashboard page template.
	 *
	 * This function loads the main admin interface for the Cozy Addons plugin
	 * by including the dashboard PHP file.
	 */
	public function cozy_companion_info() {
			include_once self::$dir . 'dashboard.php';
	}
}
