<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$testimonial_args = array(
	'testimonial' => array(
		'post_type'      => 'ca_testimonial',
		'singular_label' => 'Testimonial',
		'plural_label'   => 'Testimonials',
		'slug'           => 'ca-testimonial',
		'taxonomy'       => array(
			'category' => array(
				'singular_label' => 'Category',
				'plural_label'   => 'Categories',
				'slug'           => 'ca-testimonial-category',
			),
			'tags'     => array(
				'singular_label' => 'Tag',
				'plural_label'   => 'Tags',
				'slug'           => 'ca-testimonial-tags',
			),
		),
		'premium'        => true,
	),
);

$cpt_config = cozy_addons_get_cpt_config_option();

if ( ! isset( $cpt_config['testimonial'] ) ) {
	$cpt_config = array_merge( $cpt_config, $testimonial_args );

	update_option( 'ca-cpt--config', $cpt_config );
}

/**
 * Registering custom post type 'ca_testimonial'.
 *
 * @return void
 */
function ca_cpt_testimonial() {
	$testimonial_config = cozy_addons_get_cpt_config_option( 'testimonial' );

	$args = array(
		'labels'               => array(
			'name'              => _x( 'Testimonial', 'Testimonial', 'cozy-addons' ),
			'singular_name'     => _x( 'Testimonial', 'Testimonial', 'cozy-addons' ),
			'menu_name'         => _x( 'Testimonials', 'Admin Menu Text', 'cozy-addons' ),
			'name_admin_bar'    => _x( 'Testimonials', 'Add New on Toolbar', 'cozy-addons' ),
			'add_new'           => __( 'Add New', 'cozy-addons' ),
			'add_new_item'      => __( 'Add New', 'cozy-addons' ),
			'new_item'          => __( 'New', 'cozy-addons' ),
			'edit_item'         => __( 'Edit', 'cozy-addons' ),
			'view_item'         => __( 'View', 'cozy-addons' ),
			'all_items'         => __( 'All Testimonials', 'cozy-addons' ),
			'search_items'      => __( 'Search Testimonial', 'cozy-addons' ),
			'parent_item_colon' => __( 'Parent Testimonial:', 'cozy-addons' ),
			'not_found'         => __( 'No Testimonial found.', 'cozy-addons' ),
		),
		'public'               => true,
		'publicly_queryable'   => true,
		'show_ui'              => true,
		'show_in_menu'         => true,
		'query_var'            => true,
		'rewrite'              => array( 'slug' => $testimonial_config['slug'] ),
		'capability_type'      => 'post',
		'has_archive'          => true,
		'hierarchical'         => true,
		'menu_position'        => 20,
		'supports'             => array( 'thumbnail', 'title', 'editor' ),
		'show_in_rest'         => true,
		'menu_icon'            => COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/testimonial.svg',
		'register_meta_box_cb' => 'ca_cpt_testimonial_meta_box_callback',
	);
	register_post_type( 'ca_testimonial', $args );

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
		'ca_testimonial_category',
		array( 'ca_testimonial' ),
		array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $testimonial_config['taxonomy']['category']['slug'] ),
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
		'ca_testimonial_tag',
		array( 'ca_testimonial' ),
		array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $testimonial_config['taxonomy']['tags']['slug'] ),
			'show_in_rest'      => true,
		)
	); */

	/* Register meta fields */
	register_meta(
		'post',
		'ca_testimonial_rating',
		array(
			'type'         => 'string',
			'description'  => __( 'Review Rating', 'cozy-addons' ),
			'single'       => true,
			'show_in_rest' => true,
		)
	);

	register_meta(
		'post',
		'ca_testimonial_name',
		array(
			'type'         => 'string',
			'description'  => __( 'Author Name', 'cozy-addons' ),
			'single'       => true,
			'show_in_rest' => true,
		)
	);

	register_meta(
		'post',
		'ca_testimonial_role',
		array(
			'type'         => 'string',
			'description'  => __( 'Author Role/Company', 'cozy-addons' ),
			'single'       => true,
			'show_in_rest' => true,
		)
	);

	register_meta(
		'post',
		'ca_testimonial_review_source',
		array(
			'type'         => 'string',
			'description'  => __( 'Review Source', 'cozy-addons' ),
			'single'       => true,
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'ca_cpt_testimonial' );

function ca_cpt_testimonial_meta_box_callback() {
	add_meta_box(
		'ca_testimonial_custom_fields',
		__( 'Meta Fields', 'cozy-addons' ),
		'ca_testimonial_fields_callback',
		'ca_testimonial',
		'side',
		'high'
	);
}

function ca_testimonial_fields_callback( $post ) {
	$testimonial_rating = get_post_meta( $post->ID, 'ca_testimonial_rating', true );
	$testimonial_name   = get_post_meta( $post->ID, 'ca_testimonial_name', true );
	$testimonial_role   = get_post_meta( $post->ID, 'ca_testimonial_role', true );
	$testimonial_source = get_post_meta( $post->ID, 'ca_testimonial_review_source', true );

	?>
	<label for="ca-testimonial-rating"><?php esc_html_e( 'Testimonial Rating', 'cozy-addons' ); ?></label>
	<br />
	<input style="max-width:50%;width:100%" id="ca-testimonial-rating" name="ca_testimonial_rating" type="number" min="1" max="5" step="1" value="<?php echo esc_attr( sanitize_text_field( $testimonial_rating ) ); ?>" />
	<br />
	<br />

	<label for="ca-testimonial-name"><?php esc_html_e( 'Author Name', 'cozy-addons' ); ?></label>
	<br />
	<input style="max-width:100%;width:100%" id="ca-testimonial-name" name="ca_testimonial_name" type="text" value="<?php echo esc_attr( sanitize_text_field( $testimonial_name ) ); ?>" />
	<br />
	<br />

	<label for="ca-testimonial-role"><?php esc_html_e( 'Author Role/Company', 'cozy-addons' ); ?></label>
	<input style="max-width:100%;width:100%" id="ca-testimonial-role" name="ca_testimonial_role" type="text" value="<?php echo esc_attr( sanitize_text_field( $testimonial_role ) ); ?>" />

	<br />
	<br />

	<label for="ca-testimonial-reivew-source"><?php esc_html_e( 'Review Source', 'cozy-addons' ); ?></label>
	<select style="max-width:100%;width:100%;box-sizing:border-box" id="ca-testimonial-reivew-source" name="ca_testimonial_review_source">
		<option value="default" <?php echo 'default' === $testimonial_source ? 'selected' : ''; ?>><?php esc_html_e( 'Default', 'cozy-addons' ); ?></option>
		<option value="facebook" <?php echo 'facebook' === $testimonial_source ? 'selected' : ''; ?>><?php esc_html_e( 'Facebook', 'cozy-addons' ); ?></option>
		<option value="google" <?php echo 'google' === $testimonial_source ? 'selected' : ''; ?>><?php esc_html_e( 'Google', 'cozy-addons' ); ?></option>
		<option value="yelp" <?php echo 'yelp' === $testimonial_source ? 'selected' : ''; ?>><?php esc_html_e( 'Yelp', 'cozy-addons' ); ?></option>
		<option value="trustpilot" <?php echo 'trustpilot' === $testimonial_source ? 'selected' : ''; ?>><?php esc_html_e( 'Trustpilot', 'cozy-addons' ); ?></option>
		<option value="clutch" <?php echo 'clutch' === $testimonial_source ? 'selected' : ''; ?>><?php esc_html_e( 'Clutch', 'cozy-addons' ); ?></option>
		<option value="linkedin" <?php echo 'linkedin' === $testimonial_source ? 'selected' : ''; ?>><?php esc_html_e( 'Linkedin', 'cozy-addons' ); ?></option>
		<option value="g2" <?php echo 'g2' === $testimonial_source ? 'selected' : ''; ?>><?php esc_html_e( 'G2', 'cozy-addons' ); ?></option>
		<option value="capterra" <?php echo 'capterra' === $testimonial_source ? 'selected' : ''; ?>><?php esc_html_e( 'Capterra', 'cozy-addons' ); ?></option>
	</select>

	<?php wp_nonce_field( -1, 'ca_testimonial_nonce' ); ?>

	<?php
}

function ca_testimonial_save_custom_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'manage_options', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['ca_testimonial_nonce'] ) && ! empty( $_POST['ca_testimonial_nonce'] ) && ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['ca_testimonial_nonce'] ) ) ) ) {
		return;
	}

	if ( isset( $_POST['ca_testimonial_rating'] ) && ! empty( isset( $_POST['ca_testimonial_rating'] ) ) ) {
		$testimonial_field = sanitize_text_field( wp_unslash( $_POST['ca_testimonial_rating'] ) );
		update_post_meta( $post_id, 'ca_testimonial_rating', $testimonial_field );
	}

	if ( isset( $_POST['ca_testimonial_name'] ) && ! empty( isset( $_POST['ca_testimonial_name'] ) ) ) {
		$testimonial_field = sanitize_text_field( wp_unslash( $_POST['ca_testimonial_name'] ) );
		update_post_meta( $post_id, 'ca_testimonial_name', $testimonial_field );
	}

	if ( isset( $_POST['ca_testimonial_role'] ) && ! empty( isset( $_POST['ca_testimonial_role'] ) ) ) {
		$testimonial_field = sanitize_text_field( wp_unslash( $_POST['ca_testimonial_role'] ) );
		update_post_meta( $post_id, 'ca_testimonial_role', $testimonial_field );
	}

	if ( isset( $_POST['ca_testimonial_review_source'] ) && ! empty( isset( $_POST['ca_testimonial_review_source'] ) ) ) {
		$testimonial_field = sanitize_text_field( wp_unslash( $_POST['ca_testimonial_review_source'] ) );
		update_post_meta( $post_id, 'ca_testimonial_review_source', $testimonial_field );
	}
}
add_action( 'save_post', 'ca_testimonial_save_custom_meta' );

add_filter(
	'manage_ca_testimonial_posts_columns',
	function ( $columns ) {
		$columns['ca_testimonial_rating']        = __( 'Testimonial Rating', 'cozy-addons' );
		$columns['ca_testimonial_name']          = __( 'Author Name', 'cozy-addons' );
		$columns['ca_testimonial_role']          = __( 'Author Role/Company', 'cozy-addons' );
		$columns['ca_testimonial_review_source'] = __( 'Review Source', 'cozy-addons' );

		return $columns;
	}
);

add_action(
	'manage_ca_testimonial_posts_custom_column',
	function ( $column_name, $post_id ) {
		switch ( $column_name ) {
			case 'ca_testimonial_rating':
				$testimonial_rating = get_post_meta( $post_id, 'ca_testimonial_rating', true );
				echo '' !== $testimonial_rating ? wp_kses_post( $testimonial_rating ) : 'N/A';
				break;

			case 'ca_testimonial_name':
				$testimonial_name = get_post_meta( $post_id, 'ca_testimonial_name', true );
				echo '' !== $testimonial_name ? wp_kses_post( $testimonial_name ) : 'N/A';
				break;

			case 'ca_testimonial_role':
				$testimonial_role = get_post_meta( $post_id, 'ca_testimonial_role', true );
				echo '' !== $testimonial_role ? wp_kses_post( $testimonial_role ) : 'N/A';
				break;

			case 'ca_testimonial_review_source':
				$testimonial_role = get_post_meta( $post_id, 'ca_testimonial_review_source', true );
				echo '' !== $testimonial_role ? wp_kses_post( ucfirst( $testimonial_role ) ) : 'N/A';
				break;

			default:
				break;
		}
	},
	10,
	2
);
