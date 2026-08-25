<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ca_mega_menu_enabled         = get_option( 'ca-cpt--mega-menu-templates' );
$ca_portfolio_gallery_enabled = get_option( 'ca-cpt--portfolio-gallery-templates' );
$ca_faq_enabled               = get_option( 'ca-cpt--faq-templates' );

function cozy_addons_get_cpt_config_option( $cpt = '' ) {
	$config = get_option(
		'ca-cpt--config',
		array(
			'mega-menu'         => array(
				'post_type'      => 'ca_mega_menu',
				'singular_label' => 'Mega Menu Template',
				'plural_label'   => 'Mega Menu Templates',
				'slug'           => 'ca_mega_menu',
				'taxonomy'       => array(),
				'premium'        => true,
			),
			'portfolio-gallery' => array(
				'post_type'      => 'ca_portfolio_gallery',
				'singular_label' => 'Portfolio Gallery Template',
				'plural_label'   => 'Portfolio Gallery Templates',
				'slug'           => 'ca_portfolio_gallery',
				'taxonomy'       => array(
					'category' => array(
						'slug' => 'ca-portfolio-gallery-category',
					),
				),
				'premium'        => true,
			),
			'faq'               => array(
				'post_type'      => 'ca_faq',
				'singular_label' => 'FAQ',
				'plural_label'   => 'FAQ',
				'slug'           => 'ca-faq',
				'taxonomy'       => array(
					'category' => array(
						'singular_label' => 'Category',
						'plural_label'   => 'Categories',
						'slug'           => 'ca-faq-category',
					),
					'tags'     => array(
						'singular_label' => 'Tag',
						'plural_label'   => 'Tags',
						'slug'           => 'ca-faq-tags',
					),
				),
				'premium'        => true,
			),
		)
	);

	$registered_cpt = array(
		'mega-menu',
		'portfolio-gallery',
		'faq',
	);

	if ( ! empty( $cpt ) && in_array( $cpt, $registered_cpt, true ) ) {
		return $config[ $cpt ];
	}

	return $config;
}

function cozy_addons_update_cpt_value( array &$data, string $cpt, string $type, string $value ) {
	// Make sure the top-level CPT entry exists
	if ( ! isset( $data[ $cpt ] ) ) {
		$data[ $cpt ] = array();
	}

	// Split the dot-notation path into individual keys
	$keys = explode( '.', $type );

	// Start a reference pointer at the CPT's array
	$pointer = &$data[ $cpt ];

	// Walk down every key except the last one, creating nested arrays as needed
	foreach ( $keys as $i => $key ) {
		$is_last = ( $i === count( $keys ) - 1 );

		if ( $is_last ) {
			$pointer[ $key ] = $value;
		} else {
			if ( ! isset( $pointer[ $key ] ) || ! is_array( $pointer[ $key ] ) ) {
				$pointer[ $key ] = array();
			}
			$pointer = &$pointer[ $key ];
		}
	}

	unset( $pointer ); // break the reference to avoid accidental reuse
}

if ( cozy_addons_premium_access() ) {
	if ( '1' === $ca_mega_menu_enabled || '' == $ca_mega_menu_enabled ) {
		require_once COZY_ADDONS_PLUGIN_DIR . 'core/cpt/ca-mega-menu.php';
		update_option( 'ca-cpt--mega-menu-templates', '1' );
	}

	if ( '1' === $ca_portfolio_gallery_enabled || '' == $ca_portfolio_gallery_enabled ) {
		require_once COZY_ADDONS_PLUGIN_DIR . 'core/cpt/ca-portfolio-gallery.php';
		update_option( 'ca-cpt--portfolio-gallery-templates', '1' );
	}

	if ( '1' === $ca_faq_enabled || '' == $ca_faq_enabled ) {
		require_once COZY_ADDONS_PLUGIN_DIR . 'core/cpt/ca-faq.php';
		update_option( 'ca-cpt--faq-templates', '1' );
	}
}
