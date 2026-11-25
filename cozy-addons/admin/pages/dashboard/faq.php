<?php
/**
 * Dashboard: pre-purchase FAQ.
 *
 * Uses <details name="…"> so only one answer is open at a time, without JS.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cozy_dashboard_faqs = array(
	array(
		__( 'Will it work with my theme?', 'cozy-addons' ),
		__( 'Cozy Blocks works with block (Site Editor) themes. It does not support classic themes or the Classic Editor. CozyThemes block themes such as SaasLauncher, Jetnews Magazine and WoxStore are designed for it, and any compatible block theme will work.', 'cozy-addons' ),
	),
	array(
		__( 'The free version already has 30+ blocks. Why would I need Pro?', 'cozy-addons' ),
		__( 'The free blocks cover layout and content: containers, tabs, accordions, pricing tables, sliders, galleries, forms and WooCommerce product grids. Pro adds the blocks that drive results: smart popup triggers and targeting, lead forms with full inbox management, Quick View and Wishlist, magazine layouts, countdown timers, scroll animations and the premium templates and patterns.', 'cozy-addons' ),
	),
	array(
		__( 'What can the Popup Builder do?', 'cozy-addons' ),
		__( 'Build popups, slide-ins, announcement bars and newsletter forms in the Block Editor. Show them on page load, after a delay, on scroll or on exit intent, choose which pages, devices and user roles see them, and control how often they appear.', 'cozy-addons' ),
	),
	array(
		__( 'Can I collect leads and manage them inside WordPress?', 'cozy-addons' ),
		__( 'Yes. The Form block saves every submission to the Lead Forms inbox in your dashboard, where you can search, filter and flag urgent entries. Pro adds booking, lead-magnet and multi-step forms, a status pipeline, notes, auto-replies, CSV export, webhooks and Mailchimp or Brevo sign-ups.', 'cozy-addons' ),
	),
	array(
		__( 'Is this a replacement for Elementor or Divi?', 'cozy-addons' ),
		__( 'It removes the need for one. Cozy Blocks adds design blocks, patterns and templates to the native Block Editor, so you get page-builder layouts without a separate builder or shortcodes. Your pages are saved as standard WordPress block markup.', 'cozy-addons' ),
	),
	array(
		__( 'Will it slow my site down?', 'cozy-addons' ),
		__( 'No. Block scripts and styles load only on pages that use those blocks, and blocks you turn off in the Block Manager load nothing at all. Most blocks do not need jQuery.', 'cozy-addons' ),
	),
	array(
		__( 'Can I use it on client sites?', 'cozy-addons' ),
		__( 'Yes. The free plugin can be used on as many sites as you like. Pro plans cover a set number of sites, and agency plans are made for client work. See the plan details for site limits.', 'cozy-addons' ),
	),
	array(
		__( 'What if Pro is not right for me?', 'cozy-addons' ),
		__( 'Every Pro plan comes with a 30-day money-back guarantee. If it is not the right fit, contact support within 30 days and you get a full refund.', 'cozy-addons' ),
	),
	array(
		__( 'Do you support WooCommerce?', 'cozy-addons' ),
		__( 'Yes. Free includes product carousel, product category, product review and Add to Cart blocks. Pro adds Quick View, Wishlist, Product Slider, Product Tabs, Products Showcase Tabs and Featured Product.', 'cozy-addons' ),
	),
);
?>
<section class="cbd-card cbd-faq">
	<h2 class="cbd-card__title"><?php esc_html_e( 'Questions people ask before they commit', 'cozy-addons' ); ?></h2>

	<div class="cbd-faq__list">
		<?php foreach ( $cozy_dashboard_faqs as $cozy_dashboard_index => $cozy_dashboard_faq ) : ?>
			<details class="cbd-faq__item" name="cbd-faq"<?php echo 0 === $cozy_dashboard_index ? ' open' : ''; ?>>
				<summary>
					<?php echo esc_html( $cozy_dashboard_faq[0] ); ?>
					<?php cozy_addons_dashboard_the_icon( 'chevron', 16 ); ?>
				</summary>
				<p><?php echo esc_html( $cozy_dashboard_faq[1] ); ?></p>
			</details>
		<?php endforeach; ?>
	</div>

	<p class="cbd-faq__more">
		<?php esc_html_e( 'Still unsure?', 'cozy-addons' ); ?>
		<a class="cbd-link" href="<?php echo esc_url( $cozy_dashboard_links['support'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Ask the team before you buy →', 'cozy-addons' ); ?></a>
	</p>
</section>
