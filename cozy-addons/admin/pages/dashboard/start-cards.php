<?php
/**
 * Dashboard: three ways to start building.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cozy_dashboard_start_cards = array(
	array(
		'icon'  => 'layout',
		'title' => __( 'Start with a template', 'cozy-addons' ),
		'text'  => __( 'A complete, niche-ready site you customise instead of starting blank.', 'cozy-addons' ),
		'link'  => __( 'Browse starter templates →', 'cozy-addons' ),
		'url'   => $cozy_dashboard_links['library_templates'],
	),
	array(
		'icon'  => 'layers',
		'title' => __( 'Build with patterns', 'cozy-addons' ),
		'text'  => __( 'Mix hero, pricing, team and FAQ sections. Pages come together in minutes.', 'cozy-addons' ),
		'link'  => __( 'Explore the patterns library →', 'cozy-addons' ),
		'url'   => $cozy_dashboard_links['library_patterns'],
	),
	array(
		'icon'  => 'blocks',
		'title' => __( 'Craft with blocks', 'cozy-addons' ),
		'text'  => __( 'Fine-tune typography, spacing, animation and hover effects without CSS.', 'cozy-addons' ),
		'link'  => __( 'See every block →', 'cozy-addons' ),
		'url'   => $cozy_dashboard_links['blocks_tab'],
	),
);
?>
<section class="cbd-start">
	<?php foreach ( $cozy_dashboard_start_cards as $cozy_dashboard_card ) : ?>
		<div class="cbd-card cbd-start__card">
			<span class="cbd-tile-icon cbd-tile-icon--lg"><?php cozy_addons_dashboard_the_icon( $cozy_dashboard_card['icon'], 20 ); ?></span>
			<h3><?php echo esc_html( $cozy_dashboard_card['title'] ); ?></h3>
			<p><?php echo esc_html( $cozy_dashboard_card['text'] ); ?></p>
			<a class="cbd-link" href="<?php echo esc_url( $cozy_dashboard_card['url'] ); ?>"><?php echo esc_html( $cozy_dashboard_card['link'] ); ?></a>
		</div>
	<?php endforeach; ?>
</section>
