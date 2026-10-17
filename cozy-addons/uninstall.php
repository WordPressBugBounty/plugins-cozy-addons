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
delete_option( 'ca-cpt--testimonial-templates' );
delete_option( 'ca-cpt--popup-builder-templates' );

delete_option( 'ca-cpt--config' );

// Popup Builder analytics counters.
delete_post_meta_by_key( '_ca_popup_impressions' );
delete_post_meta_by_key( '_ca_popup_clicks' );
delete_post_meta_by_key( '_ca_popup_dismissals' );
delete_post_meta_by_key( '_ca_popup_last_shown' );

// Form entries: always remove the capabilities and the schedule this plugin added.
$ca_form_admin_role = get_role( 'administrator' );
if ( $ca_form_admin_role ) {
	foreach ( array( 'edit_ca_form_entries', 'edit_others_ca_form_entries', 'publish_ca_form_entries', 'read_private_ca_form_entries', 'delete_ca_form_entries', 'delete_private_ca_form_entries', 'delete_published_ca_form_entries', 'delete_others_ca_form_entries', 'edit_private_ca_form_entries', 'edit_published_ca_form_entries' ) as $ca_form_cap ) {
		$ca_form_admin_role->remove_cap( $ca_form_cap );
	}
}
delete_option( 'ca_form_entry_caps_version' );
wp_clear_scheduled_hook( 'cozy_addons_form_cleanup' );

// Entries and form settings are only removed when "Delete all form entries" was ticked under Form Settings.
$ca_form_settings = get_option( 'ca_form_settings', array() );

// The Turnstile and reCAPTCHA secrets are always removed, even when the other settings are kept.
if ( is_array( $ca_form_settings ) && ( ! empty( $ca_form_settings['turnstile_secret_key'] ) || ! empty( $ca_form_settings['recaptcha_secret_key'] ) ) ) {
	$ca_form_settings['turnstile_secret_key'] = '';
	$ca_form_settings['recaptcha_secret_key'] = '';
	update_option( 'ca_form_settings', $ca_form_settings );
}

if ( is_array( $ca_form_settings ) && ! empty( $ca_form_settings['delete_data'] ) ) {
	$ca_form_entry_ids = get_posts(
		array(
			'post_type'      => 'ca_form_entry',
			'post_status'    => array( 'publish', 'ca_form_spam', 'trash', 'draft', 'private' ),
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);
	foreach ( $ca_form_entry_ids as $ca_form_entry_id ) {
		wp_delete_post( $ca_form_entry_id, true );
	}
	delete_option( 'ca_form_settings' );

	// Files attached to entries. The plugin's delete hooks do not run during uninstall.
	$ca_form_uploads = wp_get_upload_dir();
	$ca_form_dir     = untrailingslashit( $ca_form_uploads['basedir'] ) . '/cozy-addons-forms';
	if ( is_dir( $ca_form_dir ) ) {
		$ca_form_items = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $ca_form_dir, FilesystemIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ( $ca_form_items as $ca_form_item ) {
			if ( $ca_form_item->isDir() && ! $ca_form_item->isLink() ) {
				rmdir( $ca_form_item->getPathname() ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_rmdir -- Plugin's own folder.
			} else {
				wp_delete_file( $ca_form_item->getPathname() );
			}
		}
		rmdir( $ca_form_dir ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_rmdir -- Plugin's own folder.
	}
}

$blocks = require_once WP_PLUGIN_DIR . '/cozy-addons/blocks/blocks-manifest.php';
if ( is_array( $blocks ) ) {
	$active_blocks = array_keys( $blocks );
	foreach ( $active_blocks as $block_name ) {
		delete_option( 'cozy-block--' . $block_name );
	}
}
