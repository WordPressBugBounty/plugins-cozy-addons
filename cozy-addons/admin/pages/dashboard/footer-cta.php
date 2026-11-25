<?php
/**
 * Dashboard: closing call-to-action row.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="cbd-footer-cta">
	<a class="cbd-btn cbd-btn--primary" href="<?php echo esc_url( $cozy_dashboard_links['library_templates'] ); ?>">
		<?php cozy_addons_dashboard_the_icon( 'layout' ); ?>
		<?php esc_html_e( 'Import a starter template', 'cozy-addons' ); ?>
	</a>
	<a class="cbd-btn cbd-btn--outline" href="<?php echo esc_url( $cozy_dashboard_links['docs'] ); ?>" target="_blank" rel="noopener">
		<?php cozy_addons_dashboard_the_icon( 'doc' ); ?>
		<?php esc_html_e( 'Documentation', 'cozy-addons' ); ?>
	</a>
	<?php if ( ! $cozy_dashboard_premium ) : ?>
		<a class="cbd-btn cbd-btn--amber" href="<?php echo esc_url( $cozy_dashboard_links['pricing'] ); ?>" target="_blank" rel="noopener">
			<?php cozy_addons_dashboard_the_icon( 'star' ); ?>
			<?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?>
		</a>
	<?php endif; ?>
</div>
