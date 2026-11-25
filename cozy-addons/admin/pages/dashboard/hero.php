<?php
/**
 * Dashboard: welcome hero and feature strip.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cozy_dashboard_user     = wp_get_current_user();
$cozy_dashboard_features = array(
	array(
		'title' => __( 'Templates & Patterns Library', 'cozy-addons' ),
		'text'  => __( 'Launch from a finished design, not a blank page', 'cozy-addons' ),
		'icon'  => 'layout',
		'pro'   => false,
	),
	array(
		'title' => __( 'WooCommerce Blocks', 'cozy-addons' ),
		'text'  => __( 'Product grids, sliders and store layouts', 'cozy-addons' ),
		'icon'  => 'layout',
		'pro'   => true,
	),
	array(
		'title' => __( 'News & Magazine Builder', 'cozy-addons' ),
		'text'  => __( 'Editorial layouts that keep readers reading', 'cozy-addons' ),
		'icon'  => 'layout',
		'pro'   => true,
	),
	array(
		'title' => __( 'Popup Builder', 'cozy-addons' ),
		'text'  => __( 'The right message, at the right moment', 'cozy-addons' ),
		'icon'  => 'layout',
		'pro'   => true,
	),
	array(
		'title' => __( 'Lead Form & Inbox', 'cozy-addons' ),
		'text'  => __( 'Smart forms and one inbox for every lead', 'cozy-addons' ),
		'icon'  => 'layout',
		'pro'   => true,
	),
);
?>
<section class="cbd-card cbd-hero">
	<div class="cbd-hero__intro">
		<p class="cbd-eyebrow">
			<?php
			/* translators: %s: current user's display name. */
			printf( esc_html__( 'Welcome, %s', 'cozy-addons' ), esc_html( $cozy_dashboard_user->display_name ) );
			?>
		</p>
		<h2 class="cbd-hero__title"><?php esc_html_e( 'Build a complete website in the editor you already know.', 'cozy-addons' ); ?></h2>
		<p class="cbd-hero__lead"><?php esc_html_e( 'Pick a finished design, swap in your content, and publish. No page builder, no lock-in. Everything stays native WordPress.', 'cozy-addons' ); ?></p>

		<div class="cbd-hero__actions">
			<a class="cbd-btn cbd-btn--primary" href="<?php echo esc_url( $cozy_dashboard_links['library_templates'] ); ?>">
				<?php cozy_addons_dashboard_the_icon( 'layout' ); ?>
				<?php esc_html_e( 'Import a starter template', 'cozy-addons' ); ?>
			</a>
			<a class="cbd-btn cbd-btn--outline" href="<?php echo esc_url( $cozy_dashboard_links['walkthrough'] ); ?>" target="_blank" rel="noopener">
				<?php cozy_addons_dashboard_the_icon( 'play', 14 ); ?>
				<?php esc_html_e( 'Watch the 2-min walkthrough', 'cozy-addons' ); ?>
			</a>
		</div>

		<a class="cbd-hero__demo" href="<?php echo esc_url( $cozy_dashboard_links['demo_site'] ); ?>" target="_blank" rel="noopener">
			<?php esc_html_e( 'Not ready to touch your site? Try it on a free demo site →', 'cozy-addons' ); ?>
		</a>
	</div>

	<ul class="cbd-hero__features">
		<?php foreach ( $cozy_dashboard_features as $cozy_dashboard_feature ) : ?>
			<li class="cbd-hero__feature">
				<span class="cbd-tile-icon cbd-tile-icon--solid"><?php cozy_addons_dashboard_the_icon( $cozy_dashboard_feature['icon'], 20 ); ?></span>
				<h3>
					<?php echo esc_html( $cozy_dashboard_feature['title'] ); ?>
					<?php
					if ( $cozy_dashboard_feature['pro'] ) {
						cozy_addons_dashboard_badge();
					}
					?>
				</h3>
				<p><?php echo esc_html( $cozy_dashboard_feature['text'] ); ?></p>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
