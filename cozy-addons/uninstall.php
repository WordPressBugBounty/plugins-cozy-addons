<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://cozythemes.com/
 * @since      1.0.0
 *
 * @package    CozyAddons
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'ca-cpt--mega-menu-templates' );
delete_option( 'ca-cpt--portfolio-gallery-templates' );
delete_option( 'ca-cpt--faq-templates' );

delete_option( 'ca-cpt--config' );

$blocks        = require_once WP_PLUGIN_DIR . '/cozy-addons/blocks/blocks-manifest.php';
$active_blocks = array_keys( $blocks );
foreach ( $active_blocks as $block_name ) {
	delete_option( 'cozy-block--' . $block_name );
}
