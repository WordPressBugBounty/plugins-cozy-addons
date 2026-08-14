<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="plugins-marketplace">
	<h2 class="section-title"><?php esc_html_e( 'Plugins', 'cozy-addons' ); ?></h2>

	<div class="grid-layout cols-3">
		<div class="boxed-layout banner-box">
			<figure class="product-image">
				<img width="44" height="44"
					src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/vidplex.png"
					alt="Vidplex logo" />
			</figure>
			<h3 class="product-title"><?php esc_html_e( 'Vidplex', 'cozy-addons' ); ?></h3>
			<p><?php esc_html_e( 'Vidplex is a Gutenberg block plugin that connects to YouTube channels or URLs to auto-sync and display videos in responsive galleries, sliders, carousels, and featured/sticky layouts.', 'cozy-addons' ); ?>
			</p>
			<div class="ca-spacer sm"></div>
			<hr />
			<div class="ca-spacer sm"></div>
			<div class="ca-buttons">
				<button class="ca-btn btn-secondary">
					<a href="https://wordpress.org/plugins/vidplex" target="_blank"
						rel="noopener"><?php esc_html_e( 'Explore More', 'cozy-addons' ); ?></a>
				</button>
				<button class="ca-btn btn-primary has-icon">
					<?php
					if ( ! \CozyAddons\Helpers\Utils::is_plugin_installed( 'vidplex/vidplex.php' ) || ! is_plugin_active( 'vidplex/vidplex.php' ) ) {
						?>
					<a class="activate-plugin" data-plugins="vidplex" href="#">
						<?php
						if ( ! \CozyAddons\Helpers\Utils::is_plugin_installed( 'vidplex/vidplex.php' ) ) {
							?>
						<i class="icon-wrap">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M2 11.3333C2 11.9533 2 12.2633 2.06815 12.5176C2.25309 13.2078 2.79218 13.7469 3.48237 13.9318C3.7367 14 4.04669 14 4.66667 14H11.3333C11.9533 14 12.2633 14 12.5177 13.9318C13.2078 13.7469 13.7469 13.2078 13.9319 12.5176C14 12.2633 14 11.9533 14 11.3333"
									stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
								<path
									d="M11 7.66682C11 7.66682 8.79056 10.6668 7.99996 10.6668C7.20943 10.6668 5 7.66682 5 7.66682M7.99996 10.0001V2.00012"
									stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</i>
							<?php
							esc_html_e( 'Install', 'cozy-addons' );
						} elseif ( ! is_plugin_active( 'vidplex/vidplex.php' ) ) {
							esc_html_e( 'Activate', 'cozy-addons' );
						}
						?>
					</a>
						<?php
					} else {
						?>
					<a class="is-disabled" href="#"><?php esc_html_e( 'Activated', 'cozy-addons' ); ?></a>
						<?php
					}
					?>
				</button>
			</div>
		</div>

		<div class="boxed-layout banner-box">
			<figure class="product-image">
				<img width="44" height="44"
					src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/rootblox.png"
					alt="Vidplex logo" />
			</figure>
			<h3 class="product-title"><?php esc_html_e( 'Rootblox', 'cozy-addons' ); ?></h3>
			<p><?php esc_html_e( 'Vidplex is a Gutenberg block plugin that connects to YouTube channels or URLs to auto-sync and display videos in responsive galleries, sliders, carousels, and featured/sticky layouts.', 'cozy-addons' ); ?>
			</p>
			<div class="ca-spacer sm"></div>
			<hr />
			<div class="ca-spacer sm"></div>
			<div class="ca-buttons">
				<button class="ca-btn btn-secondary">
					<a href="https://wordpress.org/plugins/rootblox" target="_blank"
						rel="noopener"><?php esc_html_e( 'Explore More', 'cozy-addons' ); ?></a>
				</button>
				<button class="ca-btn btn-primary has-icon">
					<?php
					if ( ! \CozyAddons\Helpers\Utils::is_plugin_installed( 'rootblox/rootblox.php' ) || ! is_plugin_active( 'rootblox/rootblox.php' ) ) {
						?>
					<a class="activate-plugin" data-plugins="rootblox" href="#">
						<?php
						if ( ! \CozyAddons\Helpers\Utils::is_plugin_installed( 'rootblox/rootblox.php' ) ) {
							?>
						<i class="icon-wrap">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M2 11.3333C2 11.9533 2 12.2633 2.06815 12.5176C2.25309 13.2078 2.79218 13.7469 3.48237 13.9318C3.7367 14 4.04669 14 4.66667 14H11.3333C11.9533 14 12.2633 14 12.5177 13.9318C13.2078 13.7469 13.7469 13.2078 13.9319 12.5176C14 12.2633 14 11.9533 14 11.3333"
									stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
								<path
									d="M11 7.66682C11 7.66682 8.79056 10.6668 7.99996 10.6668C7.20943 10.6668 5 7.66682 5 7.66682M7.99996 10.0001V2.00012"
									stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</i>
							<?php
							esc_html_e( 'Install', 'cozy-addons' );
						} elseif ( ! is_plugin_active( 'rootblox/rootblox.php' ) ) {
							esc_html_e( 'Activate', 'cozy-addons' );
						}
						?>
					</a>
						<?php
					} else {
						?>
					<a class="is-disabled" href="#"><?php esc_html_e( 'Activated', 'cozy-addons' ); ?></a>
						<?php
					}
					?>
				</button>
			</div>
		</div>

		<div class="boxed-layout banner-box">
			<figure class="product-image">
				<img width="44" height="44"
					src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/quiqowl.png"
					alt="Vidplex logo" />
			</figure>
			<h3 class="product-title"><?php esc_html_e( 'Quiqowl', 'cozy-addons' ); ?></h3>
			<p><?php esc_html_e( 'Vidplex is a Gutenberg block plugin that connects to YouTube channels or URLs to auto-sync and display videos in responsive galleries, sliders, carousels, and featured/sticky layouts.', 'cozy-addons' ); ?>
			</p>
			<div class="ca-spacer sm"></div>
			<hr />
			<div class="ca-spacer sm"></div>
			<div class="ca-buttons">
				<button class="ca-btn btn-secondary">
					<a href="https://wordpress.org/plugins/quiqowl" target="_blank"
						rel="noopener"><?php esc_html_e( 'Explore More', 'cozy-addons' ); ?></a>
				</button>
				<button class="ca-btn btn-primary has-icon">
					<?php
					if ( ! \CozyAddons\Helpers\Utils::is_plugin_installed( 'quiqowl/quiqowl.php' ) || ! is_plugin_active( 'quiqowl/quiqowl.php' ) ) {
						?>
					<a class="activate-plugin" data-plugins="quiqowl" href="#">
						<?php
						if ( ! \CozyAddons\Helpers\Utils::is_plugin_installed( 'quiqowl/quiqowl.php' ) ) {
							?>
						<i class="icon-wrap">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M2 11.3333C2 11.9533 2 12.2633 2.06815 12.5176C2.25309 13.2078 2.79218 13.7469 3.48237 13.9318C3.7367 14 4.04669 14 4.66667 14H11.3333C11.9533 14 12.2633 14 12.5177 13.9318C13.2078 13.7469 13.7469 13.2078 13.9319 12.5176C14 12.2633 14 11.9533 14 11.3333"
									stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
								<path
									d="M11 7.66682C11 7.66682 8.79056 10.6668 7.99996 10.6668C7.20943 10.6668 5 7.66682 5 7.66682M7.99996 10.0001V2.00012"
									stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</i>
							<?php
							esc_html_e( 'Install', 'cozy-addons' );
						} elseif ( ! is_plugin_active( 'quiqowl/quiqowl.php' ) ) {
							esc_html_e( 'Activate', 'cozy-addons' );
						}
						?>
					</a>
						<?php
					} else {
						?>
					<a class="is-disabled" href="#"><?php esc_html_e( 'Activated', 'cozy-addons' ); ?></a>
						<?php
					}
					?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="ca-spacer"></div>

<div class="themes-marketplace">
	<h2 class="section-title"><?php esc_html_e( 'Themes', 'cozy-addons' ); ?></h2>

	<div class="grid-layout cols-3">
		<div class="boxed-layout">
			<figure class="product-image theme-image">
				<img height="240" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/saaslauncher.webp" alt="SaasLauncher display image" />
			</figure>
			<div class="inner-wrap">
				<h3 class="product-title"><?php esc_html_e( 'SaasLauncher', 'cozy-addons' ); ?></h3>
				<ul class="product-tags">
					<li class="tag-item"><?php esc_html_e( 'Agency', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'SaaS', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Startup', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Business', 'cozy-addons' ); ?></li>
				</ul>
				<p><?php esc_html_e( 'SaasLauncher is a fast, FSE-ready WordPress theme from CozyThemes for SaaS, agency, and business websites, offering 50+ pre-built starter templates, Gutenberg blocks, and one-click demo import to launch professional sites quickly.', 'cozy-addons' ); ?></p>
				<div class="ca-spacer sm"></div>
				<hr>
				<div class="ca-spacer sm"></div>
				<div class="ca-buttons">
					<button class="ca-btn btn-secondary">
						<a href="https://cozythemes.com/saaslauncher-wordpress-theme/" target="_blank" rel="noopener"><?php esc_html_e( 'Explore More', 'cozy-addons' ); ?></a>
					</button>
					<button class="ca-btn btn-primary has-icon">
						<a href="<?php echo esc_url( admin_url( 'theme-install.php?search=saaslauncher' ) ); ?>" target="_blank" rel="noopener">
							<i class="icon-wrap">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M2 11.3333C2 11.9533 2 12.2633 2.06815 12.5176C2.25309 13.2078 2.79218 13.7469 3.48237 13.9318C3.7367 14 4.04669 14 4.66667 14H11.3333C11.9533 14 12.2633 14 12.5177 13.9318C13.2078 13.7469 13.7469 13.2078 13.9319 12.5176C14 12.2633 14 11.9533 14 11.3333"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M11 7.66682C11 7.66682 8.79056 10.6668 7.99996 10.6668C7.20943 10.6668 5 7.66682 5 7.66682M7.99996 10.0001V2.00012"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
								</svg>
							</i>
							<?php esc_html_e( 'Install', 'cozy-addons' ); ?>
						</a>
					</button>
				</div>
			</div>
		</div>

		<div class="boxed-layout">
			<figure class="product-image theme-image">
				<img height="240" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/homelancer.webp" alt="SaasLauncher display image" />
			</figure>
			<div class="inner-wrap">
				<h3 class="product-title"><?php esc_html_e( 'Homelancer', 'cozy-addons' ); ?></h3>
				<ul class="product-tags">
					<li class="tag-item"><?php esc_html_e( 'Home Services', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Local Business', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Plumbing', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'HVAC', 'cozy-addons' ); ?></li>
				</ul>
				<p><?php esc_html_e( 'HomeLancer is a fast, SEO-friendly FSE WordPress theme built for home service businesses like plumbing, HVAC, and cleaning, offering 50+ block patterns and pre-built templates for easy mobile-ready site building.', 'cozy-addons' ); ?></p>
				<div class="ca-spacer sm"></div>
				<hr>
				<div class="ca-spacer sm"></div>
				<div class="ca-buttons">
					<button class="ca-btn btn-secondary">
						<a href="https://cozythemes.com/homelancer/" target="_blank" rel="noopener"><?php esc_html_e( 'Explore More', 'cozy-addons' ); ?></a>
					</button>
					<button class="ca-btn btn-primary has-icon">
						<a href="<?php echo esc_url( admin_url( 'theme-install.php?search=homelancer' ) ); ?>" target="_blank" rel="noopener">
							<i class="icon-wrap">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M2 11.3333C2 11.9533 2 12.2633 2.06815 12.5176C2.25309 13.2078 2.79218 13.7469 3.48237 13.9318C3.7367 14 4.04669 14 4.66667 14H11.3333C11.9533 14 12.2633 14 12.5177 13.9318C13.2078 13.7469 13.7469 13.2078 13.9319 12.5176C14 12.2633 14 11.9533 14 11.3333"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M11 7.66682C11 7.66682 8.79056 10.6668 7.99996 10.6668C7.20943 10.6668 5 7.66682 5 7.66682M7.99996 10.0001V2.00012"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
								</svg>
							</i>
							<?php esc_html_e( 'Install', 'cozy-addons' ); ?>
						</a>
					</button>
				</div>
			</div>
		</div>
	
		<div class="boxed-layout">
			<figure class="product-image theme-image">
				<img height="240" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/jetnews-magazine.webp" alt="SaasLauncher display image" />
			</figure>
			<div class="inner-wrap">
				<h3 class="product-title"><?php esc_html_e( 'Jetnews Magazine', 'cozy-addons' ); ?></h3>
				<ul class="product-tags">
					<li class="tag-item"><?php esc_html_e( 'Blog', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'News', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Magazine', 'cozy-addons' ); ?></li>
				</ul>
				<p><?php esc_html_e( 'JetNews Magazine is a Full Site Editing WordPress theme built for publishers, bloggers, and news sites, offering 20+ niche-ready starter templates, 50+ pre-built sections, and dedicated post/magazine blocks for creating content-focused editorial websites.', 'cozy-addons' ); ?></p>
				<div class="ca-spacer sm"></div>
				<hr>
				<div class="ca-spacer sm"></div>
				<div class="ca-buttons">
					<button class="ca-btn btn-secondary">
						<a href="https://cozythemes.com/jetnews-magazine-wordpress-theme/" target="_blank" rel="noopener"><?php esc_html_e( 'Explore More', 'cozy-addons' ); ?></a>
					</button>
					<button class="ca-btn btn-primary has-icon">
						<a href="<?php echo esc_url( admin_url( 'theme-install.php?search=jetnews-magazine' ) ); ?>" target="_blank" rel="noopener">
							<i class="icon-wrap">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M2 11.3333C2 11.9533 2 12.2633 2.06815 12.5176C2.25309 13.2078 2.79218 13.7469 3.48237 13.9318C3.7367 14 4.04669 14 4.66667 14H11.3333C11.9533 14 12.2633 14 12.5177 13.9318C13.2078 13.7469 13.7469 13.2078 13.9319 12.5176C14 12.2633 14 11.9533 14 11.3333"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M11 7.66682C11 7.66682 8.79056 10.6668 7.99996 10.6668C7.20943 10.6668 5 7.66682 5 7.66682M7.99996 10.0001V2.00012"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
								</svg>
							</i>
							<?php esc_html_e( 'Install', 'cozy-addons' ); ?>
						</a>
					</button>
				</div>
			</div>
		</div>

		<div class="boxed-layout">
			<figure class="product-image theme-image">
				<img height="240" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/fotawp.webp" alt="SaasLauncher display image" />
			</figure>
			<div class="inner-wrap">
				<h3 class="product-title"><?php esc_html_e( 'FotaWP', 'cozy-addons' ); ?></h3>
				<ul class="product-tags">
					<li class="tag-item"><?php esc_html_e( 'Agency', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Portfolio', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Business', 'cozy-addons' ); ?></li>
				</ul>
				<p><?php esc_html_e( 'FotaWP is a fast, fully customizable multipurpose Full Site Editing WordPress theme with 30+ ready-to-import starter demos and 50+ advanced blocks, letting you build any type of website — from business and eCommerce to blogs and portfolios — without coding.', 'cozy-addons' ); ?></p>
				<div class="ca-spacer sm"></div>
				<hr>
				<div class="ca-spacer sm"></div>
				<div class="ca-buttons">
					<button class="ca-btn btn-secondary">
						<a href="https://cozythemes.com/fotawp/" target="_blank" rel="noopener"><?php esc_html_e( 'Explore More', 'cozy-addons' ); ?></a>
					</button>
					<button class="ca-btn btn-primary has-icon">
						<a href="<?php echo esc_url( admin_url( 'theme-install.php?search=fotawp' ) ); ?>" target="_blank" rel="noopener">
							<i class="icon-wrap">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M2 11.3333C2 11.9533 2 12.2633 2.06815 12.5176C2.25309 13.2078 2.79218 13.7469 3.48237 13.9318C3.7367 14 4.04669 14 4.66667 14H11.3333C11.9533 14 12.2633 14 12.5177 13.9318C13.2078 13.7469 13.7469 13.2078 13.9319 12.5176C14 12.2633 14 11.9533 14 11.3333"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M11 7.66682C11 7.66682 8.79056 10.6668 7.99996 10.6668C7.20943 10.6668 5 7.66682 5 7.66682M7.99996 10.0001V2.00012"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
								</svg>
							</i>
							<?php esc_html_e( 'Install', 'cozy-addons' ); ?>
						</a>
					</button>
				</div>
			</div>
		</div>

		<div class="boxed-layout">
			<figure class="product-image theme-image">
				<img height="240" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/woxstore.webp" alt="SaasLauncher display image" />
			</figure>
			<div class="inner-wrap">
				<h3 class="product-title"><?php esc_html_e( 'WoxStore', 'cozy-addons' ); ?></h3>
				<ul class="product-tags">
					<li class="tag-item"><?php esc_html_e( 'E-Commerce', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Online Store', 'cozy-addons' ); ?></li>
				</ul>
				<p><?php esc_html_e( 'WoxStore is a Full Site Editing WooCommerce theme built for fashion, beauty, and cosmetics brands, offering 10+ pre-built store demos, dedicated eCommerce blocks, and full design customization to launch a conversion-focused online store fast.', 'cozy-addons' ); ?></p>
				<div class="ca-spacer sm"></div>
				<hr>
				<div class="ca-spacer sm"></div>
				<div class="ca-buttons">
					<button class="ca-btn btn-secondary">
						<a href="https://cozythemes.com/woxstore-woocommerce-theme/" target="_blank" rel="noopener"><?php esc_html_e( 'Explore More', 'cozy-addons' ); ?></a>
					</button>
					<button class="ca-btn btn-primary has-icon">
						<a href="<?php echo esc_url( admin_url( 'theme-install.php?search=woxstore' ) ); ?>" target="_blank" rel="noopener">
							<i class="icon-wrap">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M2 11.3333C2 11.9533 2 12.2633 2.06815 12.5176C2.25309 13.2078 2.79218 13.7469 3.48237 13.9318C3.7367 14 4.04669 14 4.66667 14H11.3333C11.9533 14 12.2633 14 12.5177 13.9318C13.2078 13.7469 13.7469 13.2078 13.9319 12.5176C14 12.2633 14 11.9533 14 11.3333"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M11 7.66682C11 7.66682 8.79056 10.6668 7.99996 10.6668C7.20943 10.6668 5 7.66682 5 7.66682M7.99996 10.0001V2.00012"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
								</svg>
							</i>
							<?php esc_html_e( 'Install', 'cozy-addons' ); ?>
						</a>
					</button>
				</div>
			</div>
		</div>

		<div class="boxed-layout">
			<figure class="product-image theme-image">
				<img height="240" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/orakus.webp" alt="SaasLauncher display image" />
			</figure>
			<div class="inner-wrap">
				<h3 class="product-title"><?php esc_html_e( 'Orakus', 'cozy-addons' ); ?></h3>
				<ul class="product-tags">
					<li class="tag-item"><?php esc_html_e( 'Local Services', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Decoration', 'cozy-addons' ); ?></li>
					<li class="tag-item"><?php esc_html_e( 'Furniture', 'cozy-addons' ); ?></li>
				</ul>
				<p><?php esc_html_e( 'Orakus is a Full Site Editing WordPress theme built for interior designers, decorators, and home decor businesses, offering 4 starter demos, 100+ pre-built sections, and WooCommerce/portfolio support to launch a stylish design website with no coding.', 'cozy-addons' ); ?></p>
				<div class="ca-spacer sm"></div>
				<hr>
				<div class="ca-spacer sm"></div>
				<div class="ca-buttons">
					<button class="ca-btn btn-secondary">
						<a href="https://cozythemes.com/orakus/" target="_blank" rel="noopener"><?php esc_html_e( 'Explore More', 'cozy-addons' ); ?></a>
					</button>
					<button class="ca-btn btn-primary has-icon">
						<a href="<?php echo esc_url( admin_url( 'theme-install.php?search=orakus' ) ); ?>" target="_blank" rel="noopener">
							<i class="icon-wrap">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M2 11.3333C2 11.9533 2 12.2633 2.06815 12.5176C2.25309 13.2078 2.79218 13.7469 3.48237 13.9318C3.7367 14 4.04669 14 4.66667 14H11.3333C11.9533 14 12.2633 14 12.5177 13.9318C13.2078 13.7469 13.7469 13.2078 13.9319 12.5176C14 12.2633 14 11.9533 14 11.3333"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M11 7.66682C11 7.66682 8.79056 10.6668 7.99996 10.6668C7.20943 10.6668 5 7.66682 5 7.66682M7.99996 10.0001V2.00012"
										stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
								</svg>
							</i>
							<?php esc_html_e( 'Install', 'cozy-addons' ); ?>
						</a>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
if ( ! cozy_addons_premium_access() ) {
	?>
<div class="ca-spacer"></div>

<div class="cta">
	<figure class="cta-featured-image">
		<a href="https://cozythemes.com/pricing-and-plans" target="_blank">
			<img height="450" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/cta-2.png"
				alt="Cozy Blocks Features list" />
		</a>
	</figure>
</div>
	<?php
}
?>