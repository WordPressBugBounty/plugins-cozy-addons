<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$popup_builder_args = array(
	'popup-builder' => array(
		'post_type'      => 'ca_popup_builder',
		'singular_label' => 'Popup Builder',
		'plural_label'   => 'Popup Builder',
		'slug'           => 'ca-popup-builder',
		'taxonomy'       => array(
			'category' => array(
				'singular_label' => 'Category',
				'plural_label'   => 'Categories',
				'slug'           => 'ca-popup-builder-category',
			),
			'tags'     => array(
				'singular_label' => 'Tag',
				'plural_label'   => 'Tags',
				'slug'           => 'ca-popup-builder-tags',
			),
		),
		'premium'        => true,
	),
);

$cpt_config = cozy_addons_get_cpt_config_option();

if ( ! isset( $cpt_config['popup-builder'] ) ) {
	$cpt_config = array_merge( $cpt_config, $popup_builder_args );

	update_option( 'ca-cpt--config', $cpt_config );
}

/**
 * Registering custom post type 'ca_testimonial'.
 *
 * @return void
 */
function ca_cpt_popup_builder() {
	$popup_builder_config = cozy_addons_get_cpt_config_option( 'popup-builder' );

	$args = array(
		'labels'             => array(
			'name'              => _x( 'Popup Builder', 'Popup Builder', 'cozy-addons' ),
			'singular_name'     => _x( 'Popup Builder', 'Popup Builder', 'cozy-addons' ),
			'menu_name'         => _x( 'Popup Builder', 'Admin Menu Text', 'cozy-addons' ),
			'name_admin_bar'    => _x( 'Popup Builder', 'Add New on Toolbar', 'cozy-addons' ),
			'add_new'           => __( 'Add New', 'cozy-addons' ),
			'add_new_item'      => __( 'Add New', 'cozy-addons' ),
			'new_item'          => __( 'New', 'cozy-addons' ),
			'edit_item'         => __( 'Edit', 'cozy-addons' ),
			'view_item'         => __( 'View', 'cozy-addons' ),
			'all_items'         => __( 'All Popup Builder', 'cozy-addons' ),
			'search_items'      => __( 'Search Popups', 'cozy-addons' ),
			'parent_item_colon' => __( 'Parent Popups:', 'cozy-addons' ),
			'not_found'         => __( 'No Popups found.', 'cozy-addons' ),
		),
		'public'             => true,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => $popup_builder_config['slug'] ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor' ),
		'show_in_rest'       => true,
		'menu_icon'          => COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/popup-builder.svg',
		'show_in_nav_menus'  => false,
	);
	register_post_type( 'ca_popup_builder', $args );
}

add_action( 'init', 'ca_cpt_popup_builder' );

// Impression, click and dismissal tracking, and the list screen columns.
require_once COZY_ADDONS_PLUGIN_DIR . 'core/cpt/ca-popup-analytics.php';

$ca_popups = get_posts(
	array(
		'post_type'      => 'ca_popup_builder',
		'post_status'    => 'publish',
		'posts_per_page' => 100,
	)
);

if ( ! empty( $ca_popups ) ) {
	add_action(
		'wp_body_open',
		function () use ( $ca_popups ) {
			foreach ( $ca_popups as $popup ) {
				// Blocks, shortcodes and embeds, the way post content is rendered.
				echo cozy_addons_render_popup_content( $popup );
			}
		}
	);
}
