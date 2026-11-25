<?php
/**
 * Mega Menus: a private post type that holds mega menu content.
 *
 * Each post is the content of a mega menu panel. A new post starts with a Mega Panel block (spacing and
 * background) holding a Columns block: link columns and a promo card made of core blocks. Any block or
 * pattern can be added or removed. A Mega Menu item in the Advanced Mega Menu
 * block picks a post under "Panel content", and the panel shows that post.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'ca_cpt_mega_menu_init' );
add_filter( 'post_row_actions', 'ca_cpt_mega_menu_row_actions', 10, 2 );
add_action( 'admin_post_ca_menu_duplicate', 'ca_cpt_mega_menu_duplicate' );
add_filter( 'rest_pre_dispatch', 'ca_cpt_mega_menu_rest_guard', 10, 3 );

/**
 * Registers the 'ca_mega_menu' post type.
 *
 * @return void
 */
function ca_cpt_mega_menu_init() {
	register_post_type(
		'ca_mega_menu',
		array(
			'labels'          => array(
				'name'               => _x( 'Mega Menus', 'post type general name', 'cozy-addons' ),
				'singular_name'      => _x( 'Mega Menu', 'post type singular name', 'cozy-addons' ),
				'menu_name'          => _x( 'Mega Menus', 'admin menu', 'cozy-addons' ),
				'name_admin_bar'     => _x( 'Mega Menu', 'add new on admin bar', 'cozy-addons' ),
				'add_new'            => __( 'Add mega menu', 'cozy-addons' ),
				'add_new_item'       => __( 'Add new mega menu', 'cozy-addons' ),
				'new_item'           => __( 'New mega menu', 'cozy-addons' ),
				'edit_item'          => __( 'Edit mega menu', 'cozy-addons' ),
				'view_item'          => __( 'View mega menu', 'cozy-addons' ),
				'all_items'          => __( 'All Mega Menus', 'cozy-addons' ),
				'search_items'       => __( 'Search mega menus', 'cozy-addons' ),
				'not_found'          => __( 'No mega menus yet.', 'cozy-addons' ),
				'not_found_in_trash' => __( 'No mega menus in the trash.', 'cozy-addons' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => cozy_addons_get_cpt_menu_parent(),
			'show_in_rest'    => true,
			'rest_base'       => 'ca-menus',
			'menu_icon'       => COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/mega-menu.svg',
			'menu_position'   => 20,
			'supports'        => array( 'title', 'editor', 'revisions' ),
			'capability_type' => 'page',
			'map_meta_cap'    => true,
			'template'        => ca_cpt_mega_menu_template(),
			// No template lock and no block restrictions: every block and pattern can be used.
		)
	);
}

/**
 * Starting content of a new mega menu: a Mega Panel holding a Columns block. Three columns have a heading
 * and Menu Items; the last one is the promo card made of core blocks (cozy_addons_menu_promo_card_template()).
 *
 * @return array Block template.
 */
function ca_cpt_mega_menu_template() {
	$link   = function ( $label, $icon, $description ) {
		return array(
			'cozy-block/menu-item',
			array(
				'label'       => $label,
				'url'         => '#',
				'icon'        => $icon,
				'description' => $description,
			),
		);
	};
	$column = function ( $heading, array $links ) {
		return array(
			'core/column',
			array(),
			array_merge(
				array(
					array(
						'core/paragraph',
						array(
							'className' => 'cozy-addons-menu-heading',
							'content'   => $heading,
						),
					),
				),
				$links
			),
		);
	};
	$card = array(
		'core/column',
		array(),
		array(
			cozy_addons_menu_promo_card_template(
				__( 'Featured offer', 'cozy-addons' ),
				__( 'Promote a product, a guide or a sale here.', 'cozy-addons' ),
				__( 'Learn more', 'cozy-addons' ),
				'#'
			),
		),
	);

	return array(
		array(
			'cozy-block/menu-panel',
			array(),
			array(
				array(
					'core/columns',
					array(),
					array(
						$column(
							__( 'Products', 'cozy-addons' ),
							array(
								$link( __( 'Website builder', 'cozy-addons' ), 'layout', __( 'Design pages visually', 'cozy-addons' ) ),
								$link( __( 'Online store', 'cozy-addons' ), 'bag', __( 'Sell anything online', 'cozy-addons' ) ),
							)
						),
						$column(
							__( 'Marketing', 'cozy-addons' ),
							array(
								$link( __( 'Popups', 'cozy-addons' ), 'popup', __( 'Smart offers', 'cozy-addons' ) ),
								$link( __( 'Forms', 'cozy-addons' ), 'inbox', __( 'Collect every lead', 'cozy-addons' ) ),
							)
						),
						$column(
							__( 'Resources', 'cozy-addons' ),
							array(
								$link( __( 'Guides', 'cozy-addons' ), 'book', '' ),
								$link( __( 'Support', 'cozy-addons' ), 'help', '' ),
							)
						),
						$card,
					),
				),
			),
		),
	);
}

/**
 * Mega menus are private content: only people who can edit them may read them over the REST API.
 * Without this, published posts would be readable by anyone at /wp/v2/ca-menus. On the site they only
 * appear inside the menus that use them.
 *
 * @param mixed           $result  Response to replace the request with, or null.
 * @param WP_REST_Server  $server  Server instance.
 * @param WP_REST_Request $request Request.
 * @return mixed
 */
function ca_cpt_mega_menu_rest_guard( $result, $server, $request ) {
	if ( null !== $result || ! preg_match( '#^/wp/v2/ca-menus(?:/|$)#', (string) $request->get_route() ) ) {
		return $result;
	}
	$type = get_post_type_object( 'ca_mega_menu' );
	if ( ! $type || ! current_user_can( $type->cap->edit_posts ) ) {
		return new WP_Error(
			'rest_forbidden',
			esc_html__( 'Sorry, you are not allowed to view mega menus.', 'cozy-addons' ),
			array( 'status' => rest_authorization_required_code() )
		);
	}
	return $result;
}

/**
 * Adds the Duplicate row action.
 *
 * @param array   $actions Row actions.
 * @param WP_Post $post    Post.
 * @return array
 */
function ca_cpt_mega_menu_row_actions( $actions, $post ) {
	if ( $post instanceof WP_Post && 'ca_mega_menu' === $post->post_type && current_user_can( 'edit_post', $post->ID ) ) {
		$url                          = wp_nonce_url( admin_url( 'admin-post.php?action=ca_menu_duplicate&post=' . (int) $post->ID ), 'ca_menu_duplicate_' . (int) $post->ID );
		$actions['ca_menu_duplicate'] = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Duplicate', 'cozy-addons' ) . '</a>';
	}
	return $actions;
}

/**
 * Duplicates a mega menu as a draft and opens it.
 *
 * @return void
 */
function ca_cpt_mega_menu_duplicate() {
	$id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	check_admin_referer( 'ca_menu_duplicate_' . $id );
	$post = get_post( $id );
	$type = get_post_type_object( 'ca_mega_menu' );
	if ( ! $post || ! $type || 'ca_mega_menu' !== $post->post_type || ! current_user_can( 'edit_post', $id ) || ! current_user_can( $type->cap->create_posts ) ) {
		wp_die( esc_html__( 'You cannot duplicate this mega menu.', 'cozy-addons' ), 403 );
	}
	$new_id = wp_insert_post(
		array(
			'post_type'    => 'ca_mega_menu',
			'post_status'  => 'draft',
			/* translators: %s: original mega menu title. */
			'post_title'   => wp_slash( sanitize_text_field( sprintf( __( '%s (copy)', 'cozy-addons' ), $post->post_title ) ) ),
			// wp_insert_post() runs the content filters, so kses applies for users without unfiltered_html.
			'post_content' => wp_slash( $post->post_content ),
		)
	);
	if ( is_wp_error( $new_id ) || ! $new_id ) {
		wp_die( esc_html__( 'Could not duplicate the mega menu.', 'cozy-addons' ) );
	}
	wp_safe_redirect( admin_url( 'post.php?action=edit&post=' . (int) $new_id ) );
	exit;
}
