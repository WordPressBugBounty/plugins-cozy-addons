<?php
/**
 * Loads the Form block's server side: entries post type, inbox, settings, export, privacy and patterns.
 *
 * The submission endpoint lives with the other REST routes in core/api/class-form.php.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/functions.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-entry-post-type.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-entries-privacy.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-form-patterns.php';
// Product enquiries. Checks for WooCommerce itself, as WooCommerce may load after this plugin.
require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-form-woocommerce.php';
// Spam protection. Akismet checks for the Akismet plugin itself, for the same reason.
require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-form-turnstile.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-form-recaptcha.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-form-akismet.php';
// Files attached to entries, kept out of the public uploads.
require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-form-uploads.php';

\CozyAddons\Core\Forms\Entry_Post_Type::init();
\CozyAddons\Core\Forms\Entries_Privacy::init();
\CozyAddons\Core\Forms\Form_Patterns::init();
\CozyAddons\Core\Forms\Form_Uploads::init();

// Tells the Form block's sidebar which spam protection is set up, as booleans only.
add_action( 'enqueue_block_editor_assets', 'cozy_addons_form_editor_spam_status' );

if ( is_admin() ) {
	require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-form-settings.php';
	require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-entries-admin.php';
	require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-entries-export.php';
	require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-leads-stats.php';
	require_once COZY_ADDONS_PLUGIN_DIR . 'core/forms/class-leads-analytics.php';

	// Lead Forms menu order: Inbox (the post type), Analytics, Settings.
	\CozyAddons\Core\Forms\Leads_Analytics::init();
	\CozyAddons\Core\Forms\Form_Settings::init();
	\CozyAddons\Core\Forms\Entries_Admin::init();
	\CozyAddons\Core\Forms\Entries_Export::init();
}
