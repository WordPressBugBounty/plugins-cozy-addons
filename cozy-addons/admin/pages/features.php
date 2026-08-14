<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$features = array(
	'General Blocks'     => array(
		array(
			'label' => 'Accordion',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Advanced Gallery',
			'free'  => 'Basic',
			'pro'   => 'Advanced with AJAX loader',
		),
		array(
			'label' => 'Advanced Mega Menu',
			'free'  => 'Basic',
			'pro'   => 'Advanced with Mega Menu',
		),
		array(
			'label' => 'Advanced Tabs',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Back to Top',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Breadcrumb',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Cozy Button',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Contact Form 7 Styler',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Cozy Container',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Call To Action',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Date & Time',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Featured Content Box',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Icon List',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Before/After Image',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Popup Builder',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Pricing Table',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Progress Bar',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Scroll Animation',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Sidebar Panel',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Slider',
			'free'  => 'Basic',
			'pro'   => 'Advanced',
		),
		array(
			'label' => 'Social Icons',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Teams',
			'free'  => 'Basic',
			'pro'   => 'Advanced',
		),
		array(
			'label' => 'Testimonials',
			'free'  => 'Basic',
			'pro'   => 'Advanced',
		),
		array(
			'label' => 'Toggle Content',
			'free'  => false,
			'pro'   => true,
		),
	),
	'Post Blocks'        => array(
		array(
			'label' => 'Advertisement',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Advanced Categories',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Categorized Post Tabs',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Featured Post',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Featured Post Tabs',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Magazine Grid (with AJAX loader)',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Magazine List (with AJAX loader)',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'News Ticker',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Popular Post',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Post Grid/Carousel',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Post Comments',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Post Slider',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Post Views',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Related Post',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Trending Post',
			'free'  => false,
			'pro'   => true,
		),
	),
	'WooCommerce Blocks' => array(
		array(
			'label' => 'Add to Cart',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Featured Product',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Featured Product Tabs',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Product Category',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Product Grid/Carousel',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'All Product Reviews',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Product Slider',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Product Showcase Tabs',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Quick View',
			'free'  => false,
			'pro'   => true,
		),
		array(
			'label' => 'Wishlist',
			'free'  => false,
			'pro'   => true,
		),
	),
	'Design Kit'         => array(
		array(
			'label' => 'Patterns',
			'free'  => 'Limited',
			'pro'   => 'Full Access',
		),
		array(
			'label' => 'Homepage Templates',
			'free'  => 'Limited',
			'pro'   => 'Full Access',
		),
	),
	'Utility Functions'  => array(
		array(
			'label' => 'Cozy Animation',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Cozy Hover Styles',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Cozy Responsive Visibility',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => "Core Button block's Hover Styles",
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => "Core Navigation block's Hover Styles",
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Google Fonts in Core WordPress blocks',
			'free'  => true,
			'pro'   => true,
		),
		array(
			'label' => 'Core Post Terms\' styling options',
			'free'  => true,
			'pro'   => true,
		),
	),
);
?>

<div class="main">
	<div class="boxed-layout">
		<div class="flex-layout">
			<div>
				<h2 class="section-title"><?php esc_html_e( 'Cozy Blocks Free vs Pro', 'cozy-addons' ); ?></h2>
				<p><?php esc_html_e( 'Follow the guided workflow — we\'ll always highlight your next best action.', 'cozy-addons' ); ?></p>
			</div>
			<?php
			if ( ! cozy_addons_premium_access() ) {
				?>
				<button class="ca-btn btn-primary has-icon">
					<a href="https://cozythemes.com/pricing-and-plans" target="_blank">
						<i>
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12.3307 1.33331V4.66665M13.9974 2.99998H10.6641" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M3.33594 14.6667H12.6693" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M11.2504 12.6666H4.7548C4.06938 12.6666 3.72668 12.6666 3.46676 12.4822C3.20683 12.2978 3.0936 11.9744 2.86713 11.3274L1.37009 7.05111C1.29042 6.81551 1.35262 6.55571 1.53077 6.38009C1.75496 6.15907 2.10624 6.12478 2.37005 6.29816L3.1916 6.83811C4.02086 7.38311 4.4355 7.65565 4.8547 7.55658C5.27391 7.45751 5.52273 7.02825 6.02037 6.16972L7.49674 3.62273C7.60047 3.44376 7.79354 3.33331 8.0026 3.33331C8.21167 3.33331 8.40474 3.44376 8.50847 3.62273L9.9848 6.16972C10.4825 7.02825 10.7313 7.45751 11.1505 7.55658C11.5697 7.65565 11.9843 7.38311 12.8136 6.83811L13.6351 6.29816C13.8989 6.12478 14.2503 6.15907 14.4745 6.38009C14.6526 6.55571 14.7148 6.81551 14.6351 7.05111L13.1381 11.3274C12.9116 11.9744 12.7984 12.2978 12.5385 12.4822C12.2785 12.6666 11.9358 12.6666 11.2504 12.6666Z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</i>
						<?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?>
					</a>
				</button>
				<?php
			}
			?>
		</div>

		<br/>

		<div class="table-wrap" role="region">
			<table class="feature-table" aria-describedby="legend">
				<tbody>
					<!-- General section -->
					<?php
					foreach ( $features as $key => $section ) {
						?>
						<tr class="section">
							<th scope="col"><?php echo esc_html( $key ); ?></th>
							<th scope="col" class="col-free">Free</th>
							<th scope="col" class="col-pro">Pro</th>
						</tr>

						<?php
						$total_section = count( $section );
						foreach ( $section as $index => $feature ) {
							$classes   = array();
							$classes[] = 'section__item';
							$classes[] = $index === $total_section - 1 ? 'last-item' : '';
							?>
							<tr class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
								<td><?php echo esc_html( $feature['label'] ); ?></td>
								<td class="<?php echo is_bool( $feature['free'] ) ? ( $feature['free'] ? 'chip__yes' : 'chip__no' ) : ''; ?>">
									<span>
									<?php
									if ( is_bool( $feature['free'] ) ) {
										if ( $feature['free'] ) {
											?>
											<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M4.75 10.0208L0 5.27083L1.1875 4.08333L4.75 7.64583L12.3958 0L13.5833 1.1875L4.75 10.0208Z" fill="#0E9254"/>
											</svg>	
											<?php
										} else {
											?>
												<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M1.16667 11.6667L0 10.5L4.66667 5.83333L0 1.16667L1.16667 0L5.83333 4.66667L10.5 0L11.6667 1.16667L7 5.83333L11.6667 10.5L10.5 11.6667L5.83333 7L1.16667 11.6667Z" fill="#D60035"/>
												</svg>
											<?php
										}
									} else {
										echo esc_html( $feature['free'] );
									}
									?>
									</span>
								</td>
								<td class="<?php echo is_bool( $feature['pro'] ) ? ( $feature['pro'] ? 'chip__yes' : 'chip__no' ) : ''; ?>">
									<span>
									<?php
									if ( is_bool( $feature['pro'] ) ) {
										if ( $feature['pro'] ) {
											?>
											<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M4.75 10.0208L0 5.27083L1.1875 4.08333L4.75 7.64583L12.3958 0L13.5833 1.1875L4.75 10.0208Z" fill="#0E9254"/>
											</svg>	
											<?php
										} else {
											?>
												<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M1.16667 11.6667L0 10.5L4.66667 5.83333L0 1.16667L1.16667 0L5.83333 4.66667L10.5 0L11.6667 1.16667L7 5.83333L11.6667 10.5L10.5 11.6667L5.83333 7L1.16667 11.6667Z" fill="#D60035"/>
												</svg>
											<?php
										}
									} else {
										echo esc_html( $feature['pro'] );
									}
									?>
									</span>
								</td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>

		<?php
		if ( ! cozy_addons_premium_access() ) {
			?>
				<hr />
				<br />
				<div style="text-align:right">
					<button class="ca-btn btn-primary has-icon">
						<a href="https://cozythemes.com/pricing-and-plans" target="_blank">
							<i>
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.3307 1.33331V4.66665M13.9974 2.99998H10.6641" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M3.33594 14.6667H12.6693" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M11.2504 12.6666H4.7548C4.06938 12.6666 3.72668 12.6666 3.46676 12.4822C3.20683 12.2978 3.0936 11.9744 2.86713 11.3274L1.37009 7.05111C1.29042 6.81551 1.35262 6.55571 1.53077 6.38009C1.75496 6.15907 2.10624 6.12478 2.37005 6.29816L3.1916 6.83811C4.02086 7.38311 4.4355 7.65565 4.8547 7.55658C5.27391 7.45751 5.52273 7.02825 6.02037 6.16972L7.49674 3.62273C7.60047 3.44376 7.79354 3.33331 8.0026 3.33331C8.21167 3.33331 8.40474 3.44376 8.50847 3.62273L9.9848 6.16972C10.4825 7.02825 10.7313 7.45751 11.1505 7.55658C11.5697 7.65565 11.9843 7.38311 12.8136 6.83811L13.6351 6.29816C13.8989 6.12478 14.2503 6.15907 14.4745 6.38009C14.6526 6.55571 14.7148 6.81551 14.6351 7.05111L13.1381 11.3274C12.9116 11.9744 12.7984 12.2978 12.5385 12.4822C12.2785 12.6666 11.9358 12.6666 11.2504 12.6666Z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</i>
						<?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?>
						</a>
					</button>
				</div>
				<?php
		}
		?>
	</div>
	<?php
	if ( ! cozy_addons_premium_access() ) {
		?>
	<div class="ca-spacer"></div>

	<div class="cta">
		<figure class="cta-featured-image">
			<a href="https://cozythemes.com/pricing-and-plans" target="_blank">
				<img height="450" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/cta-2.png" alt="Cozy Blocks Features list" />
			</a>
		</figure>
	</div>
		<?php
	}
	?>
</div>
<?php require COZY_ADDONS_PLUGIN_DIR . 'admin/sections/sidebar.php'; ?>
