<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registering custom post type 'ca_faq'.
 *
 * @return void
 */
function ca_cpt_faq() {
	$faq_config = cozy_addons_get_cpt_config_option( 'faq' );

	$args = array(
		'labels'             => array(
			'name'              => _x( 'FAQ', 'FAQ', 'cozy-addons' ),
			'singular_name'     => _x( 'FAQ', 'FAQ', 'cozy-addons' ),
			'menu_name'         => _x( 'FAQ', 'Admin Menu Text', 'cozy-addons' ),
			'name_admin_bar'    => _x( 'FAQ', 'Add New on Toolbar', 'cozy-addons' ),
			'add_new'           => __( 'Add New', 'cozy-addons' ),
			'add_new_item'      => __( 'Add New', 'cozy-addons' ),
			'new_item'          => __( 'New', 'cozy-addons' ),
			'edit_item'         => __( 'Edit', 'cozy-addons' ),
			'view_item'         => __( 'View', 'cozy-addons' ),
			'all_items'         => __( 'All FAQ', 'cozy-addons' ),
			'search_items'      => __( 'Search FAQ', 'cozy-addons' ),
			'parent_item_colon' => __( 'Parent FAQ:', 'cozy-addons' ),
			'not_found'         => __( 'No FAQ found.', 'cozy-addons' ),
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => $faq_config['slug'] ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor' ),
		'show_in_rest'       => true,
		'menu_icon'          => COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/faq.svg',
	);
	register_post_type( 'ca_faq', $args );

	// Register category.
	$labels = array(
		'name'              => __( 'Categories', 'cozy-addons' ),
		'singular_name'     => __( 'Category', 'cozy-addons' ),
		'search_items'      => __( 'Search Categories', 'cozy-addons' ),
		'all_items'         => __( 'All Categories', 'cozy-addons' ),
		'parent_item'       => __( 'Parent Category', 'cozy-addons' ),
		'parent_item_colon' => __( 'Parent Category:', 'cozy-addons' ),
		'edit_item'         => __( 'Edit Category', 'cozy-addons' ),
		'update_item'       => __( 'Update Category', 'cozy-addons' ),
		'add_new_item'      => __( 'Add New Category', 'cozy-addons' ),
		'new_item_name'     => __( 'New Category', 'cozy-addons' ),
		'menu_name'         => __( 'Categories', 'cozy-addons' ),
	);

	register_taxonomy(
		'ca_faq_category',
		array( 'ca_faq' ),
		array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $faq_config['taxonomy']['category']['slug'] ),
			'show_in_rest'      => true,
		)
	);

	// Register tags.
	/*
	$labels = array(
		'name'              => __( 'Tags', 'cozy-addons' ),
		'singular_name'     => __( 'Tag', 'cozy-addons' ),
		'search_items'      => __( 'Search Tags', 'cozy-addons' ),
		'all_items'         => __( 'All Tags', 'cozy-addons' ),
		'parent_item'       => __( 'Parent Tag', 'cozy-addons' ),
		'parent_item_colon' => __( 'Parent Tag:', 'cozy-addons' ),
		'edit_item'         => __( 'Edit Tag', 'cozy-addons' ),
		'update_item'       => __( 'Update Tag', 'cozy-addons' ),
		'add_new_item'      => __( 'Add New Tag', 'cozy-addons' ),
		'new_item_name'     => __( 'New Tag', 'cozy-addons' ),
		'menu_name'         => __( 'Tags', 'cozy-addons' ),
	);

	register_taxonomy(
		'ca_faq_tag',
		array( 'ca_faq' ),
		array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $faq_config['taxonomy']['tags']['slug'] ),
			'show_in_rest'      => true,
		)
	); */
}
add_action( 'init', 'ca_cpt_faq' );
