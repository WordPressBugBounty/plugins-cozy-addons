<?php
/**
 * Dashboard: dark "Cozy Blocks Pro" showcase. Rendered on free sites only.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cozy_dashboard_extras = array(
	'store'    => array(
		'title' => __( 'Sell more from every product page', 'cozy-addons' ),
		'text'  => __( 'Give shoppers fewer clicks between interest and checkout.', 'cozy-addons' ),
		'chips' => array( __( 'Quick View', 'cozy-addons' ), __( 'Wishlist', 'cozy-addons' ), __( 'Product Slider', 'cozy-addons' ), __( 'Products Showcase Tabs', 'cozy-addons' ), __( 'Featured Product', 'cozy-addons' ) ),
	),
	'business' => array(
		'title' => __( 'Turn visitors into leads', 'cozy-addons' ),
		'text'  => __( 'Time-boxed offers and forms that match your brand. Pairs with Popup Builder above.', 'cozy-addons' ),
		'chips' => array( __( 'Countdown Timer', 'cozy-addons' ), __( 'Contact Form 7 Styler', 'cozy-addons' ), __( 'Toggle Content', 'cozy-addons' ), __( 'Pricing Table', 'cozy-addons' ) ),
	),
	'magazine' => array(
		'title' => __( 'Publish like a magazine', 'cozy-addons' ),
		'text'  => __( 'Editorial layouts that surface your best content automatically.', 'cozy-addons' ),
		'chips' => array( __( 'Magazine Grid', 'cozy-addons' ), __( 'Magazine List', 'cozy-addons' ), __( 'News Ticker', 'cozy-addons' ), __( 'Trending Post', 'cozy-addons' ), __( 'Featured Post Tabs', 'cozy-addons' ) ),
	),
	'clients'  => array(
		'title' => __( 'Make pages feel premium', 'cozy-addons' ),
		'text'  => __( 'The finishing touches that make a build look custom-made.', 'cozy-addons' ),
		'chips' => array( __( 'Scroll Animation', 'cozy-addons' ), __( 'Before/After Image', 'cozy-addons' ), __( 'Advanced Categories', 'cozy-addons' ), __( 'Related Post', 'cozy-addons' ) ),
	),
);

$cozy_dashboard_replaced_plugins = array(
	__( 'Popup plugin', 'cozy-addons' ),
	__( 'Newsletter popup plugin', 'cozy-addons' ),
	__( 'Lead form plugin', 'cozy-addons' ),
	__( 'Photo gallery plugin', 'cozy-addons' ),
	__( 'Portfolio builder plugin', 'cozy-addons' ),
	__( 'Testimonials plugin', 'cozy-addons' ),
	__( 'Team builder plugin', 'cozy-addons' ),
	__( 'Countdown timer plugin', 'cozy-addons' ),
	__( 'WooCommerce wishlist plugin', 'cozy-addons' ),
	__( 'Product quick view plugin', 'cozy-addons' ),
	__( 'News ticker plugin', 'cozy-addons' ),
	__( 'Before/after slider plugin', 'cozy-addons' ),
);

// Each row: label, included in free.
$cozy_dashboard_compare = array(
	array( __( 'Layout and content essentials: container, tabs, accordion, pricing, CTA, slider, gallery', 'cozy-addons' ), true ),
	array( __( 'WooCommerce product grids, categories and Add to Cart', 'cozy-addons' ), true ),
	array( __( 'Quick View, Wishlist, Product Slider and Showcase Tabs', 'cozy-addons' ), false ),
	array( __( 'Popup Builder: popups, slide-ins, announcement bars, newsletter and lead forms', 'cozy-addons' ), false ),
	array( __( 'Smart triggers: exit intent, time, scroll, click, plus page, device and role targeting', 'cozy-addons' ), false ),
	array( __( 'Basic form builder and basic inbox', 'cozy-addons' ), true ),
	array( __( 'Lead Form & Inbox: smart booking, enquiry, newsletter and lead-magnet forms with full inbox management', 'cozy-addons' ), false ),
	array( __( 'Countdown Timer', 'cozy-addons' ), false ),
	array( __( 'Magazine layouts, News Ticker, Trending and Related Posts', 'cozy-addons' ), false ),
	array( __( 'Scroll Animation and Before/After Image', 'cozy-addons' ), false ),
	array( __( 'Contact Form 7 Styler', 'cozy-addons' ), false ),
	array( __( 'Dedicated Pro support', 'cozy-addons' ), false ),
);

$cozy_dashboard_reviews = array(
	array( __( '“Speed seems fast, and ideas are limitless.”', 'cozy-addons' ), __( 'wacpro · Upgraded to Pro', 'cozy-addons' ) ),
	array( __( '“What I like is their support is very fast.”', 'cozy-addons' ), __( 'yandeputra · WordPress.org review', 'cozy-addons' ) ),
	array( __( '“Their support person is always willing and happy to help out.”', 'cozy-addons' ), __( 'akuben · WordPress.org review', 'cozy-addons' ) ),
);
?>
<section class="cbd-pro">
	<p class="cbd-pill cbd-pill--amber"><?php cozy_addons_dashboard_the_icon( 'star', 10 ); ?><?php esc_html_e( 'Cozy Blocks Pro', 'cozy-addons' ); ?></p>
	<h2 class="cbd-pro__title"><?php esc_html_e( 'When your site needs to do more than look good', 'cozy-addons' ); ?></h2>
	<p class="cbd-pro__lead"><?php esc_html_e( 'Pro is built around outcomes: more sales, more leads, more readers. Here is what it adds, ordered for what you are building.', 'cozy-addons' ); ?></p>

	<div class="cbd-pro__features">
		<!-- Popup Builder -->
		<article class="cbd-feature cbd-feature--popup" data-for="clients business">
			<div class="cbd-feature__copy">
				<p class="cbd-feature__kicker"><?php cozy_addons_dashboard_the_icon( 'popup', 14 ); ?><?php esc_html_e( 'Pro · Popup Builder', 'cozy-addons' ); ?></p>
				<h3><?php esc_html_e( 'The right message, to the right visitor, at the right moment.', 'cozy-addons' ); ?></h3>
				<ul class="cbd-ticks">
					<li><?php cozy_addons_dashboard_the_icon( 'check', 14 ); ?><?php esc_html_e( 'Popups, slide-ins, announcement bars and newsletter forms, built in the Block Editor', 'cozy-addons' ); ?></li>
					<li><?php cozy_addons_dashboard_the_icon( 'check', 14 ); ?><?php esc_html_e( 'Trigger on exit intent, time, scroll or click', 'cozy-addons' ); ?></li>
					<li><?php cozy_addons_dashboard_the_icon( 'check', 14 ); ?><?php esc_html_e( 'Target by page, device and user role, and set how often it shows', 'cozy-addons' ); ?></li>
				</ul>
				<p class="cbd-feature__foot">
					<?php esc_html_e( 'No extra popup plugin needed.', 'cozy-addons' ); ?>
					<a class="cbd-link cbd-link--amber" href="<?php echo esc_url( $cozy_dashboard_links['popup_demo'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'See it in action →', 'cozy-addons' ); ?></a>
				</p>
			</div>
			<div class="cbd-feature__visual">
				<div class="cbd-popup-demo" data-variant="popup" aria-hidden="true">
					<span class="cbd-popup-demo__line"></span>
					<span class="cbd-popup-demo__line cbd-popup-demo__line--wide"></span>
					<span class="cbd-popup-demo__block"></span>
					<div class="cbd-popup-demo__box">
						<span class="cbd-popup-demo__tag"><?php esc_html_e( '10% OFF', 'cozy-addons' ); ?></span>
						<span class="cbd-sk cbd-sk--dark"></span>
						<span class="cbd-sk cbd-sk--short"></span>
						<span class="cbd-popup-demo__input"></span>
						<span class="cbd-popup-demo__btn"></span>
					</div>
				</div>
				<div class="cbd-chips cbd-chips--toggle" role="group" aria-label="<?php esc_attr_e( 'Popup types', 'cozy-addons' ); ?>">
					<button type="button" class="cbd-chip is-active" data-variant="popup" aria-pressed="true"><?php esc_html_e( 'Popups', 'cozy-addons' ); ?></button>
					<button type="button" class="cbd-chip" data-variant="slidein" aria-pressed="false"><?php esc_html_e( 'Slide-ins', 'cozy-addons' ); ?></button>
					<button type="button" class="cbd-chip" data-variant="bar" aria-pressed="false"><?php esc_html_e( 'Announcement', 'cozy-addons' ); ?></button>
					<button type="button" class="cbd-chip" data-variant="newsletter" aria-pressed="false"><?php esc_html_e( 'Newsletter & lead capture', 'cozy-addons' ); ?></button>
				</div>
			</div>
		</article>

		<!-- Lead Form & Inbox -->
		<article class="cbd-feature cbd-feature--leads" data-for="business">
			<div class="cbd-feature__visual">
				<div class="cbd-leads-demo" aria-hidden="true">
					<div class="cbd-leads-demo__form">
						<span class="cbd-sk cbd-sk--dark"></span>
						<span class="cbd-sk cbd-sk--short"></span>
						<span class="cbd-leads-demo__input"></span>
						<span class="cbd-leads-demo__input"></span>
						<span class="cbd-leads-demo__btn"><?php esc_html_e( 'Get the free guide', 'cozy-addons' ); ?></span>
					</div>
					<span class="cbd-leads-demo__arrow"><?php cozy_addons_dashboard_the_icon( 'arrow', 14 ); ?></span>
					<div class="cbd-leads-demo__inbox">
						<p><strong><?php esc_html_e( 'Inbox', 'cozy-addons' ); ?></strong><span><?php esc_html_e( '3 new', 'cozy-addons' ); ?></span></p>
						<span class="cbd-leads-demo__row"><i class="is-violet"></i><b></b><em class="is-violet"><?php esc_html_e( 'Booking', 'cozy-addons' ); ?></em></span>
						<span class="cbd-leads-demo__row"><i class="is-orange"></i><b></b><em class="is-green"><?php esc_html_e( 'Newsletter', 'cozy-addons' ); ?></em></span>
						<span class="cbd-leads-demo__row"><i class="is-blue"></i><b></b><em class="is-amber"><?php esc_html_e( 'Lead magnet', 'cozy-addons' ); ?></em></span>
					</div>
				</div>
			</div>
			<div class="cbd-feature__copy">
				<p class="cbd-feature__kicker"><?php cozy_addons_dashboard_the_icon( 'mail', 14 ); ?><?php esc_html_e( 'Free + Pro · Lead Form & Inbox', 'cozy-addons' ); ?></p>
				<h3><?php esc_html_e( 'Start capturing leads free. Go further with Pro.', 'cozy-addons' ); ?></h3>
				<p class="cbd-feature__text"><?php esc_html_e( 'Every site gets a basic form builder and inbox. Pro unlocks smart forms for booking, enquiries, lead capture, lead magnets and newsletters, with full inbox management.', 'cozy-addons' ); ?></p>
				<p class="cbd-included"><?php cozy_addons_dashboard_the_icon( 'check', 12 ); ?><?php esc_html_e( 'Included free: basic form builder and basic inbox', 'cozy-addons' ); ?></p>
				<p class="cbd-feature__label"><?php esc_html_e( 'With Pro', 'cozy-addons' ); ?></p>
				<ul class="cbd-pro-rows">
					<li>
						<span class="cbd-pro-rows__icon"><?php cozy_addons_dashboard_the_icon( 'calendar', 18 ); ?></span>
						<span><strong><?php esc_html_e( 'Lead capture', 'cozy-addons' ); ?></strong><?php esc_html_e( 'Booking and enquiry forms that collect the details you need', 'cozy-addons' ); ?></span>
					</li>
					<li>
						<span class="cbd-pro-rows__icon"><?php cozy_addons_dashboard_the_icon( 'mail', 18 ); ?></span>
						<span><strong><?php esc_html_e( 'Newsletter', 'cozy-addons' ); ?></strong><?php esc_html_e( 'Signup forms anywhere on your site to grow your list', 'cozy-addons' ); ?></span>
					</li>
					<li>
						<span class="cbd-pro-rows__icon"><?php cozy_addons_dashboard_the_icon( 'download', 18 ); ?></span>
						<span><strong><?php esc_html_e( 'Lead magnet', 'cozy-addons' ); ?></strong><?php esc_html_e( 'Trade a guide, checklist or offer for an email address', 'cozy-addons' ); ?></span>
					</li>
				</ul>
				<div class="cbd-feature__actions">
					<a class="cbd-btn cbd-btn--ghost" href="<?php echo esc_url( $cozy_dashboard_links['new_page'] ); ?>"><?php esc_html_e( 'Try the free form builder', 'cozy-addons' ); ?></a>
					<a class="cbd-link cbd-link--amber" href="<?php echo esc_url( $cozy_dashboard_links['free_pro_tab'] ); ?>"><?php esc_html_e( 'See what Pro adds →', 'cozy-addons' ); ?></a>
				</div>
			</div>
		</article>
	</div>

	<h3 class="cbd-pro__subtitle"><?php esc_html_e( 'Plus everything else in Pro', 'cozy-addons' ); ?></h3>
	<div class="cbd-extras">
		<?php foreach ( $cozy_dashboard_extras as $cozy_dashboard_key => $cozy_dashboard_extra ) : ?>
			<article class="cbd-extra" data-for="<?php echo esc_attr( $cozy_dashboard_key ); ?>">
				<div class="cbd-extra__visual cbd-extra__visual--<?php echo esc_attr( $cozy_dashboard_key ); ?>" aria-hidden="true">
					<?php if ( 'store' === $cozy_dashboard_key ) : ?>
						<div class="cbd-vis-product">
							<span class="cbd-vis-product__img"><i><?php cozy_addons_dashboard_the_icon( 'heart', 10 ); ?></i><b><?php esc_html_e( 'Quick View', 'cozy-addons' ); ?></b></span>
							<span class="cbd-sk"></span>
							<span class="cbd-sk cbd-sk--accent"></span>
						</div>
						<div class="cbd-vis-product cbd-vis-product--ghost">
							<span class="cbd-vis-product__img"></span>
							<span class="cbd-sk"></span>
							<span class="cbd-sk cbd-sk--accent"></span>
						</div>
					<?php elseif ( 'business' === $cozy_dashboard_key ) : ?>
						<div class="cbd-vis-offer">
							<span class="cbd-sk cbd-sk--dark"></span>
							<span class="cbd-sk"></span>
							<span class="cbd-vis-offer__timer"><b>02</b><b>14</b><b>36</b></span>
							<span class="cbd-vis-offer__input"></span>
							<span class="cbd-vis-offer__btn"></span>
						</div>
					<?php elseif ( 'magazine' === $cozy_dashboard_key ) : ?>
						<div class="cbd-vis-mag">
							<span class="cbd-vis-mag__ticker"><b><?php esc_html_e( 'Latest', 'cozy-addons' ); ?></b><i></i></span>
							<span class="cbd-vis-mag__grid"><span class="is-main"></span><span class="is-a"></span><span class="is-b"></span><span class="is-c"></span></span>
						</div>
					<?php else : ?>
						<div class="cbd-vis-premium">
							<span class="cbd-vis-premium__compare"><i><?php cozy_addons_dashboard_the_icon( 'compare', 12 ); ?></i></span>
							<span class="cbd-vis-premium__bars"><b></b><b class="is-amber"></b><b></b></span>
						</div>
					<?php endif; ?>
				</div>
				<h4><?php echo esc_html( $cozy_dashboard_extra['title'] ); ?></h4>
				<p><?php echo esc_html( $cozy_dashboard_extra['text'] ); ?></p>
				<ul class="cbd-chips">
					<?php foreach ( $cozy_dashboard_extra['chips'] as $cozy_dashboard_chip ) : ?>
						<li class="cbd-chip"><?php echo esc_html( $cozy_dashboard_chip ); ?></li>
					<?php endforeach; ?>
				</ul>
			</article>
		<?php endforeach; ?>
	</div>

	<div class="cbd-toolkit">
		<div>
			<h3><?php esc_html_e( 'One toolkit instead of a stack of single-purpose plugins', 'cozy-addons' ); ?></h3>
			<p><?php esc_html_e( 'Cozy Blocks and Pro can stand in for add-ons you would otherwise install, update and style one by one. Fewer plugins means a lighter, more consistent site.', 'cozy-addons' ); ?></p>
		</div>
		<ul class="cbd-chips cbd-chips--struck">
			<?php foreach ( $cozy_dashboard_replaced_plugins as $cozy_dashboard_plugin ) : ?>
				<li class="cbd-chip"><del><?php echo esc_html( $cozy_dashboard_plugin ); ?></del></li>
			<?php endforeach; ?>
		</ul>
	</div>

	<div class="cbd-compare" role="table" aria-label="<?php esc_attr_e( 'What you get in Free and Pro', 'cozy-addons' ); ?>">
		<div class="cbd-compare__row cbd-compare__row--head" role="row">
			<span role="columnheader"><?php esc_html_e( 'What you get', 'cozy-addons' ); ?></span>
			<span role="columnheader"><?php esc_html_e( 'Free', 'cozy-addons' ); ?></span>
			<span role="columnheader" class="is-pro"><?php esc_html_e( 'Pro', 'cozy-addons' ); ?></span>
		</div>
		<?php foreach ( $cozy_dashboard_compare as $cozy_dashboard_row ) : ?>
			<div class="cbd-compare__row" role="row">
				<span role="cell"><?php echo esc_html( $cozy_dashboard_row[0] ); ?></span>
				<span role="cell" class="<?php echo $cozy_dashboard_row[1] ? 'is-yes' : 'is-no'; ?>">
					<?php cozy_addons_dashboard_the_icon( $cozy_dashboard_row[1] ? 'check' : 'dash', 16 ); ?>
					<span class="screen-reader-text"><?php echo $cozy_dashboard_row[1] ? esc_html__( 'Included', 'cozy-addons' ) : esc_html__( 'Not included', 'cozy-addons' ); ?></span>
				</span>
				<span role="cell" class="is-pro is-yes">
					<?php cozy_addons_dashboard_the_icon( 'check', 16 ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Included', 'cozy-addons' ); ?></span>
				</span>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="cbd-proof">
		<div class="cbd-proof__rating">
			<strong>4.6</strong>
			<span>
				<span class="cbd-stars" aria-hidden="true">
					<?php
					for ( $cozy_dashboard_i = 0; $cozy_dashboard_i < 5; $cozy_dashboard_i++ ) {
						cozy_addons_dashboard_the_icon( 'star', 12 );
					}
					?>
				</span>
				<span class="screen-reader-text"><?php esc_html_e( 'Rated 4.6 out of 5', 'cozy-addons' ); ?></span>
				<?php esc_html_e( 'on WordPress.org', 'cozy-addons' ); ?>
			</span>
		</div>
		<?php foreach ( $cozy_dashboard_reviews as $cozy_dashboard_review ) : ?>
			<figure class="cbd-proof__quote">
				<blockquote><?php echo esc_html( $cozy_dashboard_review[0] ); ?></blockquote>
				<figcaption><?php echo esc_html( $cozy_dashboard_review[1] ); ?></figcaption>
			</figure>
		<?php endforeach; ?>
	</div>

	<div class="cbd-guarantee">
		<span class="cbd-guarantee__icon"><?php cozy_addons_dashboard_the_icon( 'shield', 44 ); ?></span>
		<div>
			<h3><?php esc_html_e( 'Try Pro with a 30-day money-back guarantee.', 'cozy-addons' ); ?></h3>
			<p><?php esc_html_e( 'If it is not the right fit, you are covered. See plan details for site limits and agency licensing.', 'cozy-addons' ); ?></p>
		</div>
		<a class="cbd-btn cbd-btn--amber" href="<?php echo esc_url( $cozy_dashboard_links['pricing'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'See plans & pricing', 'cozy-addons' ); ?></a>
	</div>
</section>
