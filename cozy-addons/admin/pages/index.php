<?php
/**
 * Dashboard tab.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once COZY_ADDONS_PLUGIN_DIR . 'admin/pages/dashboard/icons.php';

$cozy_dashboard_links   = \CozyAddons\Admin\Dashboard::links();
$cozy_dashboard_state   = \CozyAddons\Admin\Dashboard::get_state();
$cozy_dashboard_premium = cozy_addons_premium_access();
?>
<div class="main cbd" data-persona="<?php echo esc_attr( $cozy_dashboard_state['persona'] ); ?>">
	<?php
	require COZY_ADDONS_PLUGIN_DIR . 'admin/pages/dashboard/hero.php';
	require COZY_ADDONS_PLUGIN_DIR . 'admin/pages/dashboard/onboarding.php';
	require COZY_ADDONS_PLUGIN_DIR . 'admin/pages/dashboard/start-cards.php';

	if ( ! $cozy_dashboard_premium ) {
		require COZY_ADDONS_PLUGIN_DIR . 'admin/pages/dashboard/pro-showcase.php';
	}

	require COZY_ADDONS_PLUGIN_DIR . 'admin/pages/dashboard/themes.php';
	require COZY_ADDONS_PLUGIN_DIR . 'admin/pages/dashboard/faq.php';
	require COZY_ADDONS_PLUGIN_DIR . 'admin/pages/dashboard/footer-cta.php';
	?>
</div>

<?php require COZY_ADDONS_PLUGIN_DIR . 'admin/sections/dashboard-sidebar.php'; ?>
