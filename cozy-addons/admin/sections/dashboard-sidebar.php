<?php
/**
 * Dashboard tab sidebar: help links, what's new and the Pro promo.
 *
 * Expects $cozy_dashboard_links and $cozy_dashboard_premium from admin/pages/index.php.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cozy_dashboard_help = array(
	array( 'book', __( 'Block documentation', 'cozy-addons' ), $cozy_dashboard_links['docs'] ),
	array( 'lifebuoy', __( 'Support', 'cozy-addons' ), $cozy_dashboard_links['support'] ),
	array( 'eye', __( 'Live demo', 'cozy-addons' ), $cozy_dashboard_links['live_demo'] ),
);

$cozy_dashboard_news = array(
	array( __( 'Lead Form & Inbox', 'cozy-addons' ), __( 'Contact, quote, booking and newsletter forms with an inbox in your dashboard. Smart lead forms with Pro.', 'cozy-addons' ) ),
	array( __( 'Mega Menu', 'cozy-addons' ), __( 'Dropdown, mega panel and off-canvas menus built from blocks, with icons and badges.', 'cozy-addons' ) ),
	array( __( 'Advanced Search', 'cozy-addons' ), __( 'Live search with instant results. Pro adds typo tolerance, synonyms and search insights.', 'cozy-addons' ) ),
);
?>
<aside class="sidebar cbd-sidebar">
	<div class="cbd-card cbd-side">
		<h3 class="cbd-side__title"><?php esc_html_e( 'Need a hand?', 'cozy-addons' ); ?></h3>
		<ul class="cbd-side__links">
			<?php foreach ( $cozy_dashboard_help as $cozy_dashboard_link ) : ?>
				<li>
					<a href="<?php echo esc_url( $cozy_dashboard_link[2] ); ?>" target="_blank" rel="noopener">
						<?php cozy_addons_dashboard_the_icon( $cozy_dashboard_link[0] ); ?>
						<?php echo esc_html( $cozy_dashboard_link[1] ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<div class="cbd-card cbd-side">
		<h3 class="cbd-side__title"><?php esc_html_e( 'What’s new', 'cozy-addons' ); ?></h3>
		<ul class="cbd-side__news">
			<?php foreach ( $cozy_dashboard_news as $cozy_dashboard_item ) : ?>
				<li>
					<strong><?php echo esc_html( $cozy_dashboard_item[0] ); ?> <?php cozy_addons_dashboard_badge( 'free-pro' ); ?></strong>
					<p><?php echo esc_html( $cozy_dashboard_item[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</aside>
