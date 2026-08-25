<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user_details = wp_get_current_user();
?>
<div class="main">
	<div class="banner-box boxed-layout flex-layout">
		<div>
			<p>
				<?php
				esc_html_e( 'Welcome to Cozy Blocks, ', 'cozy-addons' );
				?>
				<strong
					style="color:var(--cozy-addons--heading)"><?php echo esc_html( ucfirst( $user_details->user_login ) ); ?>!</strong>
				👋
			</p>

			<h2 class="section-title">
				<?php esc_html_e( 'Build Stunning WordPress Websites. Faster with Cozy Blocks.', 'cozy-addons' ); ?>
			</h2>
			<p><?php esc_html_e( 'Powerful blocks, ready-made patterns, and professionally designed templates to help you create beautiful websites faster with Gutenberg.', 'cozy-addons' ); ?>
			</p>

			<ul class="features-list">
				<li class="feature-list-item">
					<i class="check-icon">
						<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M2.08594 5.83331L3.54427 7.29165L7.91927 2.70831" stroke="currentColor"
								stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</i>
					<?php esc_html_e( '50+ Advanced Blocks', 'cozy-addons' ); ?>
				</li>
				<li class="feature-list-item">
					<i class="check-icon">
						<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M2.08594 5.83331L3.54427 7.29165L7.91927 2.70831" stroke="currentColor"
								stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</i>
					<?php esc_html_e( '700+ Patterns', 'cozy-addons' ); ?>
				</li>
				<li class="feature-list-item">
					<i class="check-icon">
						<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M2.08594 5.83331L3.54427 7.29165L7.91927 2.70831" stroke="currentColor"
								stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</i>
					<?php esc_html_e( '50+ Starter Templates', 'cozy-addons' ); ?>
				</li>
			</ul>

			<div class="ca-spacer sm"></div>

			<div class="ca-buttons">
				<?php
				if ( ! cozy_addons_premium_access() ) {
					?>
				<button class="ca-btn has-icon btn-primary">
					<a href="https://cozythemes.com/pricing-and-plans" target="_blank">
						<i>
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M12.3307 1.33331V4.66665M13.9974 2.99998H10.6641" stroke="currentColor"
									stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M3.33594 14.6667H12.6693" stroke="currentColor" stroke-width="1.2"
									stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M11.2504 12.6666H4.7548C4.06938 12.6666 3.72668 12.6666 3.46676 12.4822C3.20683 12.2978 3.0936 11.9744 2.86713 11.3274L1.37009 7.05111C1.29042 6.81551 1.35262 6.55571 1.53077 6.38009C1.75496 6.15907 2.10624 6.12478 2.37005 6.29816L3.1916 6.83811C4.02086 7.38311 4.4355 7.65565 4.8547 7.55658C5.27391 7.45751 5.52273 7.02825 6.02037 6.16972L7.49674 3.62273C7.60047 3.44376 7.79354 3.33331 8.0026 3.33331C8.21167 3.33331 8.40474 3.44376 8.50847 3.62273L9.9848 6.16972C10.4825 7.02825 10.7313 7.45751 11.1505 7.55658C11.5697 7.65565 11.9843 7.38311 12.8136 6.83811L13.6351 6.29816C13.8989 6.12478 14.2503 6.15907 14.4745 6.38009C14.6526 6.55571 14.7148 6.81551 14.6351 7.05111L13.1381 11.3274C12.9116 11.9744 12.7984 12.2978 12.5385 12.4822C12.2785 12.6666 11.9358 12.6666 11.2504 12.6666Z"
									stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?>
					</a>
				</button>
					<?php
				}
				?>
				<button class="ca-btn has-icon btn-primary-accent">
					<a href="https://docs.cozythemes.com/cozy-blocks" target="_blank">
						<i>
							<svg width="18" height="18" viewBox="0 0 18 18" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M6 5.25H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
								<path d="M6 8.25H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
								<path
									d="M9.75 16.125V15.75C9.75 13.6287 9.75 12.5681 10.409 11.909C11.0681 11.25 12.1287 11.25 14.25 11.25H14.625M15 10.0073V7.5C15 4.67157 15 3.25736 14.1213 2.37868C13.2427 1.5 11.8284 1.5 9 1.5C6.17158 1.5 4.75736 1.5 3.87868 2.37868C3 3.25736 3 4.67157 3 7.5V10.9081C3 13.3419 3 14.5588 3.66455 15.383C3.79881 15.5495 3.95048 15.7012 4.117 15.8354C4.94123 16.5 6.15811 16.5 8.59185 16.5C9.12105 16.5 9.38558 16.5 9.6279 16.4145C9.6783 16.3967 9.72765 16.3763 9.77588 16.3532C10.0077 16.2423 10.1947 16.0553 10.5689 15.6811L14.1213 12.1287C14.5549 11.6951 14.7716 11.4784 14.8858 11.2027C15 10.9271 15 10.6204 15 10.0073Z"
									stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'Documentation', 'cozy-addons' ); ?>
					</a>
				</button>
			</div>
		</div>
		<figure class="banner-image">
			<img height="270" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/dashboard_banner.png"
				alt="Banner image displaying patterns" />
		</figure>
	</div>

	<div class="ca-spacer"></div>

	<div class="getting-started">
		<h2 class="section-title"><?php esc_html_e( 'Start Building', 'cozy-addons' ); ?></h2>
		<p><?php esc_html_e( 'Choose the fastest way to bring your next website to life.', 'cozy-addons' ); ?></p>
		<div class="grid-layout cols-3">
			<div class="boxed-layout">
				<figure>
					<img height="40"
						src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/getting-started-1.png"
						alt="Templates stack icon" />
				</figure>
				<h3><?php esc_html_e( 'Start with a Template', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( 'Launch faster with professionally designed websites ready to customize.', 'cozy-addons' ); ?>
				</p>
				<button class="ca-btn btn-secondary">
					<a href="https://cozythemes.com/website-templates?tab=template" target="_blank">
						<?php esc_html_e( 'Browse Templates →', 'cozy-addons' ); ?>
					</a>
				</button>
			</div>

			<div class="boxed-layout">
				<figure>
					<img height="40"
						src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/getting-started-2.png"
						alt="Templates stack icon" />
				</figure>
				<h3><?php esc_html_e( 'Build with Patterns', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( 'Create beautiful pages quickly with ready-made sections and layouts.', 'cozy-addons' ); ?>
				</p>
				<button class="ca-btn btn-secondary">
					<a href="https://cozythemes.com/website-templates" target="_blank">
						<?php esc_html_e( 'Explore Patterns →', 'cozy-addons' ); ?>
					</a>
				</button>
			</div>

			<div class="boxed-layout">
				<figure>
					<img height="40"
						src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/getting-started-3.png"
						alt="Templates stack icon" />
				</figure>
				<h3><?php esc_html_e( 'Build with Blocks', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( 'Create custom layouts with powerful Gutenberg blocks built for flexibility.', 'cozy-addons' ); ?>
				</p>
				<button class="ca-btn btn-secondary">
					<a href="<?php echo esc_url( admin_url( 'admin.php/?page=_cozy_companions&tab=blocks' ) ); ?>">
						<?php esc_html_e( 'Explore Blocks →', 'cozy-addons' ); ?>
					</a>
				</button>
			</div>
		</div>
	</div>

	<div class="ca-spacer"></div>

	<div class="boxed-layout">
		<p class="section-pill"><?php esc_html_e( 'Getting Started', 'cozy-addons' ); ?></p>
		<h2 class="section-title"><?php esc_html_e( 'Stuck? Watch Our Walkthrough Video', 'cozy-addons' ); ?></h2>
		<iframe width="100%" height="450" src="https://www.youtube.com/embed/fNwIqedPyEU?si=y4BK8YcPqhHiFyvv" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
	</div>

	<div class="ca-spacer"></div>

	<div class="block-list boxed-layout">
		<p class="section-pill"><?php esc_html_e( '50+ Advanced Blocks', 'cozy-addons' ); ?></p>
		<h2 class="section-title"><?php esc_html_e( 'Unlock More. Build Without Limits.', 'cozy-addons' ); ?></h2>
		<p><?php esc_html_e( 'Go beyond the essentials with powerful Pro blocks for dynamic content, marketing, and WooCommerce—everything you need to create more advanced websites with Gutenberg.', 'cozy-addons' ); ?>
		</p>

		<div class="ca-spacer sm"></div>

		<ul class="icon-collection grid-layout cols-6">
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M38.3096 2.88281C44.7939 3.04701 50 8.35499 50 14.8789V36.8789C50 43.5063 44.6274 48.8789 38 48.8789H12C5.37258 48.8789 0 43.5063 0 36.8789V14.8789C0 8.35499 5.20608 3.04701 11.6904 2.88281L12 2.87891H38L38.3096 2.88281ZM12 4.87891C6.47715 4.87891 2 9.35606 2 14.8789V36.8789C2 42.4018 6.47715 46.8789 12 46.8789H38C43.5228 46.8789 48 42.4018 48 36.8789V14.8789C48 9.52866 43.7983 5.15945 38.5146 4.8916L38 4.87891H12Z"
							fill="#0c50ff" />
						<rect width="11" height="11" rx="5.5" transform="matrix(-1 0 0 1 50.9375 1.12109)"
							fill="#C2D3FF" />
						<path d="M47.1797 8.36572L44.9068 6.09288L42.937 4.12308" stroke="#0c50ff"
							stroke-linecap="round" />
						<path d="M43.1797 8.3667L45.4525 6.09386L47.4223 4.12406" stroke="#0c50ff"
							stroke-linecap="round" />
						<rect x="14" y="26.8789" width="14" height="2" rx="1" fill="#94AAE0" />
						<rect x="29" y="26.8789" width="9" height="2" rx="1" fill="#0c50ff" />
						<rect x="11" y="22.8789" width="9" height="2" rx="1" fill="#94AAE0" />
						<rect x="21" y="22.8789" width="9" height="2" rx="1" fill="#94AAE0" />
						<rect x="31" y="22.8789" width="9" height="2" rx="1" fill="#94AAE0" />
						<rect x="21" y="31.8789" width="9" height="3" rx="1.5" fill="#0c50ff" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Popup Builder', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 64 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M44.8223 1.50391C51.3065 1.66825 56.5127 6.97618 56.5127 13.5V29.5L56.5088 29.8096C56.3446 36.2938 51.0365 41.4999 44.5127 41.5H18.5127C11.9888 41.5 6.6808 36.2939 6.5166 29.8096L6.5127 29.5V13.5C6.5127 6.97608 11.7188 1.66811 18.2031 1.50391L18.5127 1.5H44.5127L44.8223 1.50391ZM18.5127 3.5C12.9898 3.5 8.5127 7.97715 8.5127 13.5V29.5C8.5127 35.0228 12.9898 39.5 18.5127 39.5H44.5127C50.0354 39.4999 54.5127 35.0228 54.5127 29.5V13.5C54.5127 8.14985 50.3109 3.78068 45.0273 3.5127L44.5127 3.5H18.5127ZM4.34082 16.7568C4.7513 16.3874 5.38346 16.4206 5.75293 16.8311C6.12237 17.2415 6.08917 17.8737 5.67871 18.2432L2.33008 21.2568C1.88916 21.654 1.88916 22.346 2.33008 22.7432L5.67871 25.7568C6.08917 26.1263 6.12237 26.7585 5.75293 27.1689C5.38346 27.5794 4.7513 27.6126 4.34082 27.2432L0.992188 24.2295C-0.331347 23.0378 -0.331344 20.9622 0.992188 19.7705L4.34082 16.7568ZM57.2695 16.8311C57.639 16.4207 58.2712 16.3874 58.6816 16.7568L62.0303 19.7705C63.3537 20.9621 63.3537 23.0378 62.0303 24.2295L58.6816 27.2432C58.2712 27.6126 57.639 27.5793 57.2695 27.1689C56.9001 26.7585 56.9333 26.1263 57.3438 25.7568L60.6924 22.7432C61.1332 22.346 61.1332 21.654 60.6924 21.2568L57.3438 18.2432C56.9333 17.8737 56.9001 17.2415 57.2695 16.8311Z"
							fill="#0c50ff" />
						<rect x="23.9883" y="45.5" width="3" height="3" rx="1.5" fill="#CAD5F2" />
						<rect x="29.9883" y="45.5" width="3" height="3" rx="1.5" fill="#0c50ff" />
						<rect x="35.9883" y="45.5" width="3" height="3" rx="1.5" fill="#CAD5F2" />
						<rect x="16.4937" y="16.4937" width="13.8969" height="13.8969" stroke="#0c50ff"
							stroke-width="1.21403" />
						<path d="M28.1104 14.002H14.001V28.1104H13V13H28.1104V14.002Z" fill="#0c50ff" />
						<path
							d="M22.4082 24.2939C22.8731 24.2939 23.2498 24.6709 23.25 25.1357C23.25 25.6007 22.8732 25.9775 22.4082 25.9775C21.9434 25.9773 21.5664 25.6006 21.5664 25.1357C21.5666 24.6711 21.9435 24.2942 22.4082 24.2939ZM25.4404 24.2939C25.9051 24.2942 26.282 24.671 26.2822 25.1357C26.2822 25.6006 25.9052 25.9773 25.4404 25.9775C24.9755 25.9775 24.5986 25.6007 24.5986 25.1357C24.5988 24.671 24.9756 24.294 25.4404 24.2939ZM25.4404 24.7988C25.2546 24.7989 25.1037 24.95 25.1035 25.1357C25.1035 25.3217 25.2545 25.4726 25.4404 25.4727C25.6262 25.4724 25.7773 25.3216 25.7773 25.1357C25.7772 24.95 25.6261 24.799 25.4404 24.7988ZM22.4082 24.7988C22.2225 24.7991 22.0715 24.95 22.0713 25.1357C22.0713 25.3216 22.2224 25.4724 22.4082 25.4727C22.5942 25.4727 22.7451 25.3217 22.7451 25.1357C22.7449 24.9499 22.5941 24.7988 22.4082 24.7988ZM21.4766 20.0293L21.6611 20.8428H26.6572C26.8871 20.8429 27.0566 21.0592 27.001 21.2822L26.3779 23.7744C26.3386 23.9317 26.1963 24.0419 26.0342 24.042H22.1523C21.9874 24.0418 21.8442 23.9275 21.8076 23.7666L21.2139 21.1514L21.0283 20.3379H20.2197C20.0802 20.3379 19.9668 20.2245 19.9668 20.085C19.9669 19.9455 20.0803 19.832 20.2197 19.832H21.4316L21.4766 20.0293ZM22.2734 23.5371H25.916L26.4639 21.3477H21.7764L22.2734 23.5371Z"
							fill="#0c50ff" />
						<line x1="34.6406" y1="21.393" x2="40.7108" y2="21.393" stroke="#0c50ff"
							stroke-width="1.21403" />
						<line x1="41.9258" y1="21.393" x2="47.9959" y2="21.393" stroke="#0c50ff"
							stroke-width="1.21403" />
						<line x1="34.6406" y1="17.7524" x2="50.423" y2="17.7524" stroke="#0c50ff"
							stroke-width="1.21403" />
						<line x1="34.6406" y1="25.0336" x2="44.3528" y2="25.0336" stroke="#0c50ff"
							stroke-width="1.21403" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Product Slider', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 52 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="17.3817" cy="20.3817" r="16.3817" stroke="#0c50ff" stroke-width="2" />
						<path d="M30.1895 30.9023L48.4806 46.094" stroke="#0c50ff" stroke-width="2"
							stroke-linecap="round" />
						<path d="M39.0215 38.3555L49.1182 47.0002" stroke="#0c50ff" stroke-width="3.86261"
							stroke-linecap="round" />
						<path
							d="M15.1699 23.6426C16.1655 23.6426 16.9724 24.4498 16.9727 25.4453C16.9727 26.441 16.1656 27.248 15.1699 27.248C14.1744 27.2479 13.3672 26.4409 13.3672 25.4453C13.3674 24.4499 14.1745 23.6428 15.1699 23.6426ZM21.6611 23.6426C22.6566 23.6427 23.4637 24.4499 23.4639 25.4453C23.4639 26.4409 22.6567 27.2479 21.6611 27.248C20.6655 27.248 19.8584 26.441 19.8584 25.4453C19.8586 24.4498 20.6656 23.6427 21.6611 23.6426ZM21.6611 24.7246C21.263 24.7247 20.9406 25.0473 20.9404 25.4453C20.9404 25.8435 21.2629 26.1669 21.6611 26.167C22.0593 26.1669 22.3828 25.8435 22.3828 25.4453C22.3826 25.0473 22.0592 24.7247 21.6611 24.7246ZM15.1699 24.7246C14.7719 24.7248 14.4494 25.0473 14.4492 25.4453C14.4492 25.8435 14.7718 26.1668 15.1699 26.167C15.5682 26.167 15.8916 25.8436 15.8916 25.4453C15.8914 25.0472 15.5681 24.7246 15.1699 24.7246ZM13.1729 14.5068L13.5693 16.25H24.2676C24.7602 16.25 25.1223 16.7126 25.0029 17.1904L23.668 22.5273C23.5834 22.864 23.2808 23.1006 22.9336 23.1006H14.6211C14.268 23.1002 13.9612 22.8551 13.8828 22.5107L12.6104 16.9102L12.2139 15.168H10.4824C10.184 15.1678 9.94158 14.9254 9.94141 14.627C9.94141 14.3284 10.1839 14.0861 10.4824 14.0859H13.0771L13.1729 14.5068ZM14.8799 22.0186H22.6807L23.8525 17.3311H13.8154L14.8799 22.0186Z"
							fill="#0c50ff" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Quick View', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 47 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M22.9375 9.91211C30.6459 -0.365283 47 5.0866 47 17.9336V18.4902L46.9951 18.8584C46.9366 21.0106 46.3669 23.0949 45.3604 24.9512C44.8072 24.2643 44.1852 23.6356 43.502 23.0781C44.1518 21.6539 44.4999 20.0919 44.5 18.4902V17.9336C44.5 7.48913 31.2044 3.05674 24.9375 11.4121L22.8887 14.1426L20.9033 11.3662C15.163 3.33702 2.50031 7.3976 2.5 17.2676V18.8594C2.5001 21.8696 3.7734 24.7393 6.00488 26.7598L22.9756 42.126L25.2588 40.1543C25.7441 40.8362 26.2951 41.4672 26.9033 42.0391L22.9375 45.4629L4.32715 28.6133C1.65818 26.1968 0.0997122 22.7961 0.00488281 19.207L0 18.8594V17.2676C0.000309461 4.96605 15.783 -0.0951033 22.9375 9.91211Z"
							fill="#0c50ff" />
						<circle cx="36.5" cy="33.5" r="7.5" stroke="#0c50ff" stroke-width="2" />
						<path d="M40 34H36.7857H34" stroke="#0c50ff" stroke-linecap="round" />
						<path d="M36.75 31V34.2143V37" stroke="#0c50ff" stroke-linecap="round" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Wishlist', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="18.9902" y="44.5" width="3" height="3" rx="1.5" fill="#CAD5F2" />
						<rect x="24.9902" y="44.5" width="3" height="3" rx="1.5" fill="#0c50ff" />
						<rect x="30.9902" y="44.5" width="3" height="3" rx="1.5" fill="#CAD5F2" />
						<path
							d="M35.5039 2.5C42.1313 2.5 47.5039 7.87258 47.5039 14.5V28.5C47.5039 35.0239 42.2978 40.3319 35.8135 40.4961L35.5039 40.5H15.5039L15.1943 40.4961C8.71 40.3319 3.50391 35.0239 3.50391 28.5V14.5C3.50391 7.87259 8.8765 2.50001 15.5039 2.5H35.5039ZM15.5039 4.5C10.1537 4.50001 5.78445 8.70168 5.5166 13.9854L5.50391 14.5V28.5C5.50391 34.0228 9.98107 38.5 15.5039 38.5H35.5039C41.0268 38.5 45.5039 34.0228 45.5039 28.5V14.5C45.5039 8.97715 41.0268 4.5 35.5039 4.5H15.5039ZM1.00684 17.5C1.55901 17.5007 2.0064 17.9488 2.00586 18.501L2 23.001L2.00586 27.499C2.0064 28.0512 1.55901 28.4993 1.00684 28.5C0.454701 28.5005 0.00657835 28.0532 0.00585938 27.501L0 23.001V22.999L0.00585938 18.499C0.00657835 17.9468 0.454701 17.4995 1.00684 17.5ZM50.0049 17.5C50.5568 17.501 51.0044 17.949 51.0039 18.501L50.998 23.001L51.0039 27.499C51.0044 28.051 50.5568 28.499 50.0049 28.5C49.4527 28.5005 49.0046 28.0532 49.0039 27.501L48.998 23.001V22.999L49.0039 18.499C49.0046 17.9468 49.4527 17.4995 50.0049 17.5Z"
							fill="#0c50ff" />
						<rect x="13.0566" y="16.0547" width="11.447" height="11.447" stroke="#0c50ff" />
						<path d="M23.4482 14.9707H11.9746V26.4463H11.002V14H23.4482V14.9707Z" fill="#0c50ff" />
						<path d="M20.709 21.1289L21.8914 24.7385H15.668L17.4417 22.1558L18.7486 23.5872L20.709 21.1289Z"
							fill="#0c50ff" />
						<circle cx="16.1951" cy="21.5018" r="0.497878" fill="#0c50ff" />
						<line x1="28.0039" y1="20.5" x2="33.0039" y2="20.5" stroke="#0c50ff" />
						<line x1="34.0039" y1="20.5" x2="39.0039" y2="20.5" stroke="#0c50ff" />
						<line x1="28.0039" y1="17.5" x2="41.0039" y2="17.5" stroke="#0c50ff" />
						<line x1="28.0039" y1="23.5" x2="36.0039" y2="23.5" stroke="#0c50ff" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Post Slider', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="1" y="1" width="48" height="48" rx="11" stroke="#0C50FF" stroke-width="2" />
						<rect x="10.5" y="8.5" width="13" height="11" stroke="#0c50ff" />
						<path d="M18.041 12.125L19.2235 15.7346H13L14.7737 13.1519L16.0806 14.5833L18.041 12.125Z"
							fill="#0c50ff" />
						<circle cx="13.5272" cy="12.4979" r="0.497878" fill="#0c50ff" />
						<line x1="10.5" y1="23.5" x2="15.5" y2="23.5" stroke="#A0C1FF" />
						<line x1="16.5" y1="23.5" x2="21.5" y2="23.5" stroke="#A0C1FF" />
						<line x1="10.5" y1="21.5" x2="23.5" y2="21.5" stroke="#A0C1FF" />
						<rect x="26.5" y="8.5" width="13" height="11" stroke="#0c50ff" />
						<path d="M34.041 12.125L35.2235 15.7346H29L30.7737 13.1519L32.0806 14.5833L34.041 12.125Z"
							fill="#0c50ff" />
						<circle cx="29.5272" cy="12.4979" r="0.497878" fill="#0c50ff" />
						<line x1="26.5" y1="23.5" x2="31.5" y2="23.5" stroke="#A0C1FF" />
						<line x1="32.5" y1="23.5" x2="37.5" y2="23.5" stroke="#A0C1FF" />
						<line x1="26.5" y1="21.5" x2="39.5" y2="21.5" stroke="#A0C1FF" />
						<rect x="10.5" y="27.5" width="13" height="11" stroke="#0c50ff" />
						<path d="M18.041 31.125L19.2235 34.7346H13L14.7737 32.1519L16.0806 33.5833L18.041 31.125Z"
							fill="#0c50ff" />
						<circle cx="13.5272" cy="31.4979" r="0.497878" fill="#0c50ff" />
						<line x1="10.5" y1="42.5" x2="15.5" y2="42.5" stroke="#A0C1FF" />
						<line x1="16.5" y1="42.5" x2="21.5" y2="42.5" stroke="#A0C1FF" />
						<line x1="10.5" y1="40.5" x2="23.5" y2="40.5" stroke="#A0C1FF" />
						<rect x="26.5" y="27.5" width="13" height="11" stroke="#0c50ff" />
						<path d="M34.041 31.125L35.2235 34.7346H29L30.7737 32.1519L32.0806 33.5833L34.041 31.125Z"
							fill="#0c50ff" />
						<circle cx="29.5272" cy="31.4979" r="0.497878" fill="#0c50ff" />
						<line x1="26.5" y1="42.5" x2="31.5" y2="42.5" stroke="#A0C1FF" />
						<line x1="32.5" y1="42.5" x2="37.5" y2="42.5" stroke="#A0C1FF" />
						<line x1="26.5" y1="40.5" x2="39.5" y2="40.5" stroke="#A0C1FF" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Featured Post', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z"
							fill="#0c50ff" />
						<rect x="6.40436" y="13.4044" width="13.209" height="12.1307" stroke="#0c50ff"
							stroke-width="0.808713" />
						<path
							d="M15.0159 17.8516L16.2451 21.6256H9.77539L11.6193 18.9252L12.9779 20.4218L15.0159 17.8516Z"
							fill="#0c50ff" />
						<circle cx="10.3145" cy="18.3907" r="0.539142" fill="#0c50ff" />
						<path d="M7.07812 27.9805H11.3913" stroke="#0c50ff" stroke-width="0.808713" />
						<path d="M12.4688 27.9805H17.321" stroke="#0c50ff" stroke-width="0.808713" />
						<path d="M7.07812 30.1406H18.9393" stroke="#0c50ff" stroke-width="0.808713" />
						<path d="M7.07812 32.3008H14.087" stroke="#0c50ff" stroke-width="0.808713" />
						<rect x="22.3346" y="13.3171" width="8.24374" height="6.97547" stroke="#0c50ff"
							stroke-width="0.634134" />
						<path
							d="M27.1166 15.6211L27.8664 17.9101H23.9199L25.0447 16.2723L25.8734 17.18L27.1166 15.6211Z"
							fill="#0c50ff" />
						<circle cx="24.2532" cy="15.8548" r="0.315721" fill="#0c50ff" />
						<line x1="22.334" y1="23.5618" x2="25.5047" y2="23.5618" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<line x1="26.1367" y1="23.5618" x2="29.3074" y2="23.5618" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<line x1="22.334" y1="22.2923" x2="30.5777" y2="22.2923" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<rect x="32.4811" y="13.3171" width="8.24374" height="6.97547" stroke="#0c50ff"
							stroke-width="0.634134" />
						<path
							d="M37.2631 15.6211L38.0129 17.9101H34.0664L35.1912 16.2723L36.0199 17.18L37.2631 15.6211Z"
							fill="#0c50ff" />
						<circle cx="34.3997" cy="15.8548" r="0.315721" fill="#0c50ff" />
						<line x1="32.4805" y1="23.5618" x2="35.6511" y2="23.5618" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<line x1="36.2832" y1="23.5618" x2="39.4539" y2="23.5618" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<line x1="32.4805" y1="22.2923" x2="40.7242" y2="22.2923" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<rect x="22.3346" y="26.5319" width="8.24374" height="6.97547" stroke="#0c50ff"
							stroke-width="0.634134" />
						<path
							d="M27.1166 28.8359L27.8664 31.1249H23.9199L25.0447 29.4871L25.8734 30.3948L27.1166 28.8359Z"
							fill="#0c50ff" />
						<circle cx="24.2532" cy="29.0696" r="0.315721" fill="#0c50ff" />
						<line x1="22.334" y1="36.7767" x2="25.5047" y2="36.7767" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<line x1="26.1367" y1="36.7767" x2="29.3074" y2="36.7767" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<line x1="22.334" y1="35.5072" x2="30.5777" y2="35.5072" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<rect x="32.4811" y="26.5319" width="8.24374" height="6.97547" stroke="#0c50ff"
							stroke-width="0.634134" />
						<path
							d="M37.2631 28.8359L38.0129 31.1249H34.0664L35.1912 29.4871L36.0199 30.3948L37.2631 28.8359Z"
							fill="#0c50ff" />
						<circle cx="34.3997" cy="29.0696" r="0.315721" fill="#0c50ff" />
						<line x1="32.4805" y1="36.7767" x2="35.6511" y2="36.7767" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<line x1="36.2832" y1="36.7767" x2="39.4539" y2="36.7767" stroke="#A0C1FF"
							stroke-width="0.634134" />
						<line x1="32.4805" y1="35.5072" x2="40.7242" y2="35.5072" stroke="#A0C1FF"
							stroke-width="0.634134" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Magazine Grid', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M28.8887 2.62109C30.6326 2.30402 32.367 3.22115 33.0869 4.84082L34.1016 7.12305C34.1061 7.13319 34.1091 7.14409 34.1133 7.1543H44.041C47.3547 7.1543 50.041 9.8406 50.041 13.1543V41.4424C50.0408 44.7559 47.3546 47.4424 44.041 47.4424H6C2.68653 47.4423 0.000257081 44.7558 0 41.4424V9.16602C0 5.85236 2.68637 3.16611 6 3.16602H10.5791C12.325 3.1661 13.9219 4.15149 14.7051 5.71191C15.149 6.59597 16.0537 7.15421 17.043 7.1543H17.1631C16.7434 5.06966 18.1108 3.00871 20.2422 2.62109C21.9861 2.30408 23.7205 3.22115 24.4404 4.84082L25.4551 7.12305C25.4596 7.13321 25.4626 7.14407 25.4668 7.1543H25.8096C25.3899 5.06968 26.7573 3.00872 28.8887 2.62109ZM6 5.16602C3.79094 5.16611 2 6.95693 2 9.16602V41.4424C2.00026 43.6512 3.7911 45.4423 6 45.4424H44.041C46.25 45.4424 48.0408 43.6513 48.041 41.4424V13.1543C48.041 10.9452 46.2501 9.1543 44.041 9.1543H17.043C15.2971 9.15421 13.7002 8.16876 12.917 6.6084C12.4731 5.72425 11.5684 5.16611 10.5791 5.16602H6ZM31.2598 5.65332C30.9145 4.87678 30.0822 4.43684 29.2461 4.58887C28.175 4.78392 27.5057 5.86035 27.8047 6.90723L27.875 7.1543H31.9268L31.2598 5.65332ZM22.6133 5.65332C22.2681 4.87678 21.4357 4.43691 20.5996 4.58887C19.5285 4.7839 18.8592 5.86032 19.1582 6.90723L19.2285 7.1543H23.2803L22.6133 5.65332Z"
							fill="#0c50ff" />
						<rect x="10.0195" y="14.5" width="14" height="11" stroke="#0c50ff" />
						<path d="M18.5605 18.125L19.743 21.7346H13.5195L15.2932 19.1519L16.6002 20.5833L18.5605 18.125Z"
							fill="#0c50ff" />
						<circle cx="14.0467" cy="18.4979" r="0.497878" fill="#0c50ff" />
						<line x1="27.5195" y1="19.5" x2="32.5195" y2="19.5" stroke="#9FC0FF" />
						<line x1="33.5195" y1="19.5" x2="38.5195" y2="19.5" stroke="#9FC0FF" />
						<line x1="27.5195" y1="16.5" x2="40.5195" y2="16.5" stroke="#9FC0FF" />
						<line x1="27.5195" y1="22.5" x2="35.5195" y2="22.5" stroke="#9FC0FF" />
						<rect x="10.0195" y="28.5" width="14" height="11" stroke="#0c50ff" />
						<path d="M18.5605 32.125L19.743 35.7346H13.5195L15.2932 33.1519L16.6002 34.5833L18.5605 32.125Z"
							fill="#0c50ff" />
						<circle cx="14.0467" cy="32.4979" r="0.497878" fill="#0c50ff" />
						<line x1="27.5195" y1="33.5" x2="32.5195" y2="33.5" stroke="#9FC0FF" />
						<line x1="33.5195" y1="33.5" x2="38.5195" y2="33.5" stroke="#9FC0FF" />
						<line x1="27.5195" y1="30.5" x2="40.5195" y2="30.5" stroke="#9FC0FF" />
						<line x1="27.5195" y1="36.5" x2="35.5195" y2="36.5" stroke="#9FC0FF" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Featured Post Tabs', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M28.8887 2.62109C30.6326 2.30402 32.367 3.22115 33.0869 4.84082L34.1016 7.12305C34.1061 7.13319 34.1091 7.14409 34.1133 7.1543H44.041C47.3547 7.1543 50.041 9.8406 50.041 13.1543V41.4424C50.0408 44.7559 47.3546 47.4424 44.041 47.4424H6C2.68653 47.4423 0.000257081 44.7558 0 41.4424V9.16602C0 5.85236 2.68637 3.16611 6 3.16602H10.5791C12.325 3.1661 13.9219 4.15149 14.7051 5.71191C15.149 6.59597 16.0537 7.15421 17.043 7.1543H17.1631C16.7434 5.06966 18.1108 3.00871 20.2422 2.62109C21.9861 2.30408 23.7205 3.22115 24.4404 4.84082L25.4551 7.12305C25.4596 7.13321 25.4626 7.14407 25.4668 7.1543H25.8096C25.3899 5.06968 26.7573 3.00872 28.8887 2.62109ZM6 5.16602C3.79094 5.16611 2 6.95693 2 9.16602V41.4424C2.00026 43.6512 3.7911 45.4423 6 45.4424H44.041C46.25 45.4424 48.0408 43.6513 48.041 41.4424V13.1543C48.041 10.9452 46.2501 9.1543 44.041 9.1543H17.043C15.2971 9.15421 13.7002 8.16876 12.917 6.6084C12.4731 5.72425 11.5684 5.16611 10.5791 5.16602H6ZM31.2598 5.65332C30.9145 4.87678 30.0822 4.43684 29.2461 4.58887C28.175 4.78392 27.5057 5.86035 27.8047 6.90723L27.875 7.1543H31.9268L31.2598 5.65332ZM22.6133 5.65332C22.2681 4.87678 21.4357 4.43691 20.5996 4.58887C19.5285 4.7839 18.8592 5.86032 19.1582 6.90723L19.2285 7.1543H23.2803L22.6133 5.65332Z"
							fill="#0c50ff" />
						<rect x="12.0547" y="19.6133" width="11.447" height="11.447" stroke="#0c50ff" />
						<path d="M22.4463 18.5293H10.9727V30.0049H10V17.5586H22.4463V18.5293Z" fill="#0c50ff" />
						<path
							d="M16.1074 27.0244C16.5723 27.0244 16.949 27.4014 16.9492 27.8662C16.9492 28.3312 16.5724 28.708 16.1074 28.708C15.6426 28.7078 15.2656 28.3311 15.2656 27.8662C15.2658 27.4015 15.6427 27.0246 16.1074 27.0244ZM19.1396 27.0244C19.6043 27.0246 19.9813 27.4015 19.9814 27.8662C19.9814 28.3311 19.6045 28.7078 19.1396 28.708C18.6747 28.7079 18.2979 28.3312 18.2979 27.8662C18.298 27.4014 18.6748 27.0245 19.1396 27.0244ZM19.1396 27.5293C18.9538 27.5294 18.8029 27.6804 18.8027 27.8662C18.8027 28.0522 18.9537 28.203 19.1396 28.2031C19.3255 28.2029 19.4766 28.0521 19.4766 27.8662C19.4764 27.6805 19.3253 27.5295 19.1396 27.5293ZM16.1074 27.5293C15.9217 27.5295 15.7707 27.6805 15.7705 27.8662C15.7705 28.0521 15.9216 28.2029 16.1074 28.2031C16.2934 28.2031 16.4443 28.0522 16.4443 27.8662C16.4441 27.6804 16.2933 27.5293 16.1074 27.5293ZM15.1758 22.7598L15.3604 23.5732H20.3564C20.5863 23.5734 20.7558 23.7897 20.7002 24.0127L20.0771 26.5049C20.0378 26.6622 19.8955 26.7724 19.7334 26.7725H15.8516C15.6866 26.7723 15.5434 26.658 15.5068 26.4971L14.9131 23.8818L14.7275 23.0684H13.9189C13.7794 23.0684 13.666 22.9549 13.666 22.8154C13.6661 22.676 13.7795 22.5625 13.9189 22.5625H15.1309L15.1758 22.7598ZM15.9727 26.2676H19.6152L20.1631 24.0781H15.4756L15.9727 26.2676Z"
							fill="#0c50ff" />
						<line x1="10.502" y1="36.0586" x2="15.502" y2="36.0586" stroke="#A0C1FF" />
						<line x1="16.502" y1="36.0586" x2="21.502" y2="36.0586" stroke="#A0C1FF" />
						<line x1="10.502" y1="34.0586" x2="23.502" y2="34.0586" stroke="#A0C1FF" />
						<line x1="10.502" y1="38.0586" x2="18.502" y2="38.0586" stroke="#A0C1FF" />
						<rect x="29.0566" y="19.6133" width="11.447" height="11.447" stroke="#0c50ff" />
						<path d="M39.4482 18.5293H27.9746V30.0049H27.002V17.5586H39.4482V18.5293Z" fill="#0c50ff" />
						<path
							d="M33.1094 27.0244C33.5743 27.0244 33.951 27.4014 33.9512 27.8662C33.9512 28.3312 33.5744 28.708 33.1094 28.708C32.6446 28.7078 32.2676 28.3311 32.2676 27.8662C32.2678 27.4015 32.6447 27.0246 33.1094 27.0244ZM36.1416 27.0244C36.6063 27.0246 36.9832 27.4015 36.9834 27.8662C36.9834 28.3311 36.6064 28.7078 36.1416 28.708C35.6767 28.7079 35.2998 28.3312 35.2998 27.8662C35.3 27.4014 35.6768 27.0245 36.1416 27.0244ZM36.1416 27.5293C35.9558 27.5294 35.8049 27.6804 35.8047 27.8662C35.8047 28.0522 35.9557 28.203 36.1416 28.2031C36.3274 28.2029 36.4785 28.0521 36.4785 27.8662C36.4783 27.6805 36.3273 27.5295 36.1416 27.5293ZM33.1094 27.5293C32.9237 27.5295 32.7727 27.6805 32.7725 27.8662C32.7725 28.0521 32.9236 28.2029 33.1094 28.2031C33.2954 28.2031 33.4463 28.0522 33.4463 27.8662C33.4461 27.6804 33.2953 27.5293 33.1094 27.5293ZM32.1777 22.7598L32.3623 23.5732H37.3584C37.5883 23.5734 37.7578 23.7897 37.7021 24.0127L37.0791 26.5049C37.0397 26.6622 36.8975 26.7724 36.7354 26.7725H32.8535C32.6885 26.7723 32.5454 26.658 32.5088 26.4971L31.915 23.8818L31.7295 23.0684H30.9209C30.7814 23.0684 30.668 22.9549 30.668 22.8154C30.6681 22.676 30.7815 22.5625 30.9209 22.5625H32.1328L32.1777 22.7598ZM32.9746 26.2676H36.6172L37.165 24.0781H32.4775L32.9746 26.2676Z"
							fill="#0c50ff" />
						<line x1="27.5039" y1="36.0586" x2="32.5039" y2="36.0586" stroke="#A0C1FF" />
						<line x1="33.5039" y1="36.0586" x2="38.5039" y2="36.0586" stroke="#A0C1FF" />
						<line x1="27.5039" y1="34.0586" x2="40.5039" y2="34.0586" stroke="#A0C1FF" />
						<line x1="27.5039" y1="38.0586" x2="35.5039" y2="38.0586" stroke="#A0C1FF" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Products Showcase Tabs', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M28.8887 2.62109C30.6326 2.30402 32.367 3.22115 33.0869 4.84082L34.1016 7.12305C34.1061 7.13319 34.1091 7.14409 34.1133 7.1543H44.041C47.3547 7.1543 50.041 9.8406 50.041 13.1543V41.4424C50.0408 44.7559 47.3546 47.4424 44.041 47.4424H6C2.68653 47.4423 0.000257081 44.7558 0 41.4424V9.16602C0 5.85236 2.68637 3.16611 6 3.16602H10.5791C12.325 3.1661 13.9219 4.15149 14.7051 5.71191C15.149 6.59597 16.0537 7.15421 17.043 7.1543H17.1631C16.7434 5.06966 18.1108 3.00871 20.2422 2.62109C21.9861 2.30408 23.7205 3.22115 24.4404 4.84082L25.4551 7.12305C25.4596 7.13321 25.4626 7.14407 25.4668 7.1543H25.8096C25.3899 5.06968 26.7573 3.00872 28.8887 2.62109ZM6 5.16602C3.79094 5.16611 2 6.95693 2 9.16602V41.4424C2.00026 43.6512 3.7911 45.4423 6 45.4424H44.041C46.25 45.4424 48.0408 43.6513 48.041 41.4424V13.1543C48.041 10.9452 46.2501 9.1543 44.041 9.1543H17.043C15.2971 9.15421 13.7002 8.16876 12.917 6.6084C12.4731 5.72425 11.5684 5.16611 10.5791 5.16602H6ZM15 36.5586H7V35.5586H15V36.5586ZM12 34.5586H7V33.5586H12V34.5586ZM18 34.5586H13V33.5586H18V34.5586ZM20 32.5586H7V31.5586H20V32.5586ZM23 29.5586H7V15.5586H23V29.5586ZM8 28.5586H22V16.5586H8V28.5586ZM18.2236 24.291H12L13.7734 21.709L15.0811 23.1396L17.041 20.6816L18.2236 24.291ZM12.5273 20.5586C12.8023 20.5586 13.0254 20.7817 13.0254 21.0566C13.0254 21.3316 12.8023 21.5547 12.5273 21.5547C12.2525 21.5545 12.0293 21.3315 12.0293 21.0566C12.0293 20.7818 12.2525 20.5588 12.5273 20.5586ZM31.2598 5.65332C30.9145 4.87678 30.0822 4.43684 29.2461 4.58887C28.175 4.78392 27.5057 5.86035 27.8047 6.90723L27.875 7.1543H31.9268L31.2598 5.65332ZM22.6133 5.65332C22.2681 4.87678 21.4357 4.43691 20.5996 4.58887C19.5285 4.7839 18.8592 5.86032 19.1582 6.90723L19.2285 7.1543H23.2803L22.6133 5.65332Z"
							fill="#0c50ff" />
						<rect x="25.25" y="15.8086" width="8.5" height="7.5" rx="1.75" stroke="#0c50ff"
							stroke-width="0.5" />
						<path d="M31.059 18.6328L31.7765 20.8232H28L29.0763 19.2559L29.8694 20.1245L31.059 18.6328Z"
							fill="#0c50ff" />
						<circle cx="28.3217" cy="18.8607" r="0.302122" fill="#0c50ff" />
						<line x1="36" y1="19.3086" x2="39.3333" y2="19.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<line x1="40" y1="19.3086" x2="43.3333" y2="19.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<line x1="36" y1="17.3086" x2="44.6667" y2="17.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<line x1="36" y1="21.3086" x2="41.3333" y2="21.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<rect x="25.25" y="24.8086" width="8.5" height="7.5" rx="1.75" stroke="#0c50ff"
							stroke-width="0.5" />
						<path d="M31.059 27.6328L31.7765 29.8232H28L29.0763 28.2559L29.8694 29.1245L31.059 27.6328Z"
							fill="#0c50ff" />
						<circle cx="28.3217" cy="27.8607" r="0.302122" fill="#0c50ff" />
						<line x1="36" y1="28.3086" x2="39.3333" y2="28.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<line x1="40" y1="28.3086" x2="43.3333" y2="28.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<line x1="36" y1="26.3086" x2="44.6667" y2="26.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<line x1="36" y1="30.3086" x2="41.3333" y2="30.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<rect x="25.25" y="33.8086" width="8.5" height="7.5" rx="1.75" stroke="#0c50ff"
							stroke-width="0.5" />
						<path d="M31.059 36.6328L31.7765 38.8232H28L29.0763 37.2559L29.8694 38.1245L31.059 36.6328Z"
							fill="#0c50ff" />
						<circle cx="28.3217" cy="36.8607" r="0.302122" fill="#0c50ff" />
						<line x1="36" y1="37.3086" x2="39.3333" y2="37.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<line x1="40" y1="37.3086" x2="43.3333" y2="37.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<line x1="36" y1="35.3086" x2="44.6667" y2="35.3086" stroke="#9FC0FF" stroke-width="0.5" />
						<line x1="36" y1="39.3086" x2="41.3333" y2="39.3086" stroke="#9FC0FF" stroke-width="0.5" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Categorized Post Tabs', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z"
							fill="#0c50ff" />
						<circle cx="13" cy="25" r="3" fill="#0c50ff" />
						<circle cx="24" cy="25" r="3" fill="#0c50ff" />
						<circle cx="35" cy="25" r="3" fill="#0c50ff" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'News Ticker', 'cozy-addons' ); ?></p>
			</li>
			<li class="grid-layout-item">
				<i class="icon-wrapper">
					<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z"
							fill="#0c50ff" />
						<rect x="8.5" y="12.5" width="14" height="11" rx="2.5" stroke="#0c50ff" />
						<path
							d="M18.0498 16C18.2983 16 18.5 16.2017 18.5 16.4502V18.25C18.5 18.3881 18.3881 18.5 18.25 18.5C18.1119 18.5 18 18.3881 18 18.25V16.8535L16.2168 18.6367C15.964 18.8895 15.568 18.9287 15.2705 18.7305L14.4521 18.1855C14.353 18.1195 14.221 18.1326 14.1367 18.2168L13.4268 18.9268C13.3291 19.0244 13.1709 19.0244 13.0732 18.9268C12.9756 18.8291 12.9756 18.6709 13.0732 18.5732L13.7832 17.8633C14.036 17.6105 14.432 17.5713 14.7295 17.7695L15.5479 18.3145C15.647 18.3805 15.779 18.3674 15.8633 18.2832L17.6465 16.5H16.25C16.1119 16.5 16 16.3881 16 16.25C16 16.1119 16.1119 16 16.25 16H18.0498Z"
							fill="#0c50ff" />
						<line x1="26" y1="17.5" x2="31" y2="17.5" stroke="#9FC0FF" />
						<line x1="32" y1="17.5" x2="37" y2="17.5" stroke="#9FC0FF" />
						<line x1="26" y1="14.5" x2="39" y2="14.5" stroke="#9FC0FF" />
						<line x1="26" y1="20.5" x2="34" y2="20.5" stroke="#9FC0FF" />
						<rect x="8.5" y="26.5" width="14" height="11" rx="2.5" stroke="#0c50ff" />
						<path
							d="M18.0498 30C18.2983 30 18.5 30.2017 18.5 30.4502V32.25C18.5 32.3881 18.3881 32.5 18.25 32.5C18.1119 32.5 18 32.3881 18 32.25V30.8535L16.2168 32.6367C15.964 32.8895 15.568 32.9287 15.2705 32.7305L14.4521 32.1855C14.353 32.1195 14.221 32.1326 14.1367 32.2168L13.4268 32.9268C13.3291 33.0244 13.1709 33.0244 13.0732 32.9268C12.9756 32.8291 12.9756 32.6709 13.0732 32.5732L13.7832 31.8633C14.036 31.6105 14.432 31.5713 14.7295 31.7695L15.5479 32.3145C15.647 32.3805 15.779 32.3674 15.8633 32.2832L17.6465 30.5H16.25C16.1119 30.5 16 30.3881 16 30.25C16 30.1119 16.1119 30 16.25 30H18.0498Z"
							fill="#0c50ff" />
						<line x1="26" y1="31.5" x2="31" y2="31.5" stroke="#9FC0FF" />
						<line x1="32" y1="31.5" x2="37" y2="31.5" stroke="#9FC0FF" />
						<line x1="26" y1="28.5" x2="39" y2="28.5" stroke="#9FC0FF" />
						<line x1="26" y1="34.5" x2="34" y2="34.5" stroke="#9FC0FF" />
					</svg>
				</i>
				<p class="block-label"><?php esc_html_e( 'Trending Post', 'cozy-addons' ); ?></p>
			</li>
		</ul>

		<div class="ca-spacer sm"></div>

		<div class="ca-buttons">
			<?php
			if ( ! cozy_addons_premium_access() ) {
				?>
			<button class="ca-btn has-icon btn-primary">
				<a href="https://cozythemes.com/pricing-and-plans" target="_blank">
					<i>
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.3307 1.33331V4.66665M13.9974 2.99998H10.6641" stroke="currentColor"
								stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M3.33594 14.6667H12.6693" stroke="currentColor" stroke-width="1.2"
								stroke-linecap="round" stroke-linejoin="round" />
							<path
								d="M11.2504 12.6666H4.7548C4.06938 12.6666 3.72668 12.6666 3.46676 12.4822C3.20683 12.2978 3.0936 11.9744 2.86713 11.3274L1.37009 7.05111C1.29042 6.81551 1.35262 6.55571 1.53077 6.38009C1.75496 6.15907 2.10624 6.12478 2.37005 6.29816L3.1916 6.83811C4.02086 7.38311 4.4355 7.65565 4.8547 7.55658C5.27391 7.45751 5.52273 7.02825 6.02037 6.16972L7.49674 3.62273C7.60047 3.44376 7.79354 3.33331 8.0026 3.33331C8.21167 3.33331 8.40474 3.44376 8.50847 3.62273L9.9848 6.16972C10.4825 7.02825 10.7313 7.45751 11.1505 7.55658C11.5697 7.65565 11.9843 7.38311 12.8136 6.83811L13.6351 6.29816C13.8989 6.12478 14.2503 6.15907 14.4745 6.38009C14.6526 6.55571 14.7148 6.81551 14.6351 7.05111L13.1381 11.3274C12.9116 11.9744 12.7984 12.2978 12.5385 12.4822C12.2785 12.6666 11.9358 12.6666 11.2504 12.6666Z"
								stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
								stroke-linejoin="round" />
						</svg>
					</i>
					<?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?>
				</a>
			</button>
				<?php
			}
			?>
			<button class="ca-btn has-icon btn-primary-accent">
				<a href="<?php echo esc_url( admin_url( 'admin.php/?page=_cozy_companions&tab=blocks' ) ); ?>">
					<?php esc_html_e( 'Explore Blocks →', 'cozy-addons' ); ?>
				</a>
			</button>
		</div>
	</div>

	<div class="ca-spacer"></div>

	<div class="feature-highlights">
		<p class="section-pill pill-secondary"><?php esc_html_e( 'Feature Highlights', 'cozy-addons' ); ?></p>
		<h2 class="section-title"><?php esc_html_e( 'Powerful Features Built For Modern Websites', 'cozy-addons' ); ?>
		</h2>
		<p><?php esc_html_e( 'Packed with powerful features to build beautiful, engaging, high-performing websites that drive more conversions and business growth.', 'cozy-addons' ); ?>
		</p>

		<ul class="grid-layout cols-3">
			<li class="boxed-layout">
				<h3 class="feature-title has-icon">
					<i class="title-icon">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M2 8C2 5.17157 2 3.75736 2.87868 2.87868C3.75736 2 5.17157 2 8 2C10.8284 2 12.2427 2 13.1213 2.87868C14 3.75736 14 5.17157 14 8C14 10.8284 14 12.2427 13.1213 13.1213C12.2427 14 10.8284 14 8 14C5.17157 14 3.75736 14 2.87868 13.1213C2 12.2427 2 10.8284 2 8Z"
								stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M2.33594 5.33334H13.6693" stroke="#4C3EFA" stroke-linecap="round"
								stroke-linejoin="round" />
							<path d="M8.66406 8H11.3307" stroke="#4C3EFA" stroke-linecap="round"
								stroke-linejoin="round" />
							<path d="M8.66406 10.6667H9.9974" stroke="#4C3EFA" stroke-linecap="round"
								stroke-linejoin="round" />
							<path d="M6 5.33334V14" stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</i>
					<?php esc_html_e( 'Website Building', 'cozy-addons' ); ?>
				</h3>

				<ul class="icon-list">
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M11.8333 1.66644C12.9292 1.66644 13.4771 1.66644 13.8458 1.9691C13.9134 2.0245 13.9753 2.08641 14.0307 2.15392C14.3333 2.5227 14.3333 3.07062 14.3333 4.16644C14.3333 5.26228 14.3333 5.81019 14.0307 6.17897C13.9753 6.24648 13.9134 6.30839 13.8458 6.3638C13.4771 6.66644 12.9292 6.66644 11.8333 6.66644H4.5C3.40417 6.66644 2.85626 6.66644 2.48747 6.36379C2.41996 6.30839 2.35806 6.24648 2.30265 6.17897C2 5.81019 2 5.26227 2 4.16644C2 3.07062 2 2.5227 2.30265 2.15392C2.35806 2.08641 2.41996 2.0245 2.48747 1.9691C2.85626 1.66644 3.40417 1.66644 4.5 1.66644H11.8333Z"
									stroke="#4C3EFA" stroke-linejoin="round" />
								<path
									d="M11.8335 9.33331C12.9295 9.33325 13.4774 9.33325 13.8462 9.63592C13.9137 9.69132 13.9756 9.75318 14.031 9.82065C14.3337 10.1894 14.3337 10.7374 14.3337 11.8334C14.3337 12.9292 14.3337 13.4771 14.031 13.8459C13.9756 13.9134 13.9137 13.9753 13.8463 14.0307C13.4775 14.3334 12.9295 14.3334 11.8337 14.3334L10.5001 14.3334C9.4042 14.3334 8.85627 14.3335 8.48747 14.0308C8.42 13.9754 8.35807 13.9135 8.30267 13.846C8 13.4772 8 12.9293 8 11.8334C8 10.7375 8 10.1896 8.30267 9.82078C8.35807 9.75332 8.41993 9.69145 8.4874 9.63605C8.8562 9.33338 9.40413 9.33338 10.5 9.33331H11.8335Z"
									stroke="#4C3EFA" stroke-linejoin="round" />
								<path
									d="M3.49722 9.33325C3.96226 9.33325 4.19478 9.33325 4.38399 9.39059C4.81022 9.51985 5.14378 9.85339 5.27303 10.2797C5.3304 10.4689 5.3304 10.7014 5.3304 11.1664V12.5003C5.3304 12.9654 5.3304 13.1979 5.27303 13.3871C5.14378 13.8133 4.81023 14.1469 4.384 14.2761C4.1948 14.3335 3.96228 14.3335 3.49725 14.3335C3.03221 14.3335 2.79969 14.3335 2.61048 14.2761C2.18424 14.1469 1.85069 13.8133 1.72144 13.3871C1.66406 13.1979 1.66406 12.9654 1.66406 12.5003V11.1664C1.66406 10.7014 1.66406 10.4689 1.72144 10.2797C1.85069 9.85345 2.18424 9.51985 2.61046 9.39065C2.79967 9.33325 3.03219 9.33325 3.49722 9.33325Z"
									stroke="#4C3EFA" stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'Full Site Editing', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M4.99652 9.16869C7.05553 6.77629 11.7192 2.10321 13.6925 2.00299C14.9133 1.88606 12.4812 6.217 6.719 10.956M7.63873 6.69662L9.1438 8.21662M2 13.9031C2.47299 12.2315 2.17458 13.053 2.33605 11.128C2.42204 10.843 2.59505 9.95849 3.67572 9.51769C4.90412 9.01662 5.80465 9.77409 6.03741 10.13C6.72313 10.8735 6.8026 11.7968 6.03741 12.8516C5.2722 13.9064 3.00235 14.1685 2 13.9031Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'Global Styles', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M2.59156 13.4059C1.66406 12.4784 1.66406 10.9856 1.66406 8.00002C1.66406 5.01446 1.66406 3.52168 2.59156 2.59418C3.51905 1.66669 5.01184 1.66669 7.9974 1.66669C10.9829 1.66669 12.4757 1.66669 13.4033 2.59418C14.3307 3.52167 14.3307 5.01446 14.3307 8.00002C14.3307 10.9856 14.3307 12.4784 13.4033 13.4059C12.4757 14.3334 10.9829 14.3334 7.9974 14.3334C5.01184 14.3334 3.51906 14.3334 2.59156 13.4059Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M1.66406 6H14.3307" stroke="#4C3EFA" />
							</svg>
						</i>
						<?php esc_html_e( 'Header Builder', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M13.4033 2.59418C14.3307 3.52168 14.3307 5.01446 14.3307 8.00002C14.3307 10.9856 14.3307 12.4784 13.4033 13.4059C12.4757 14.3334 10.9829 14.3334 7.9974 14.3334C5.01184 14.3334 3.51905 14.3334 2.59156 13.4059C1.66406 12.4784 1.66406 10.9856 1.66406 8.00002C1.66406 5.01446 1.66406 3.52167 2.59156 2.59418C3.51906 1.66669 5.01184 1.66669 7.9974 1.66669C10.9829 1.66669 12.4757 1.66669 13.4033 2.59418Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M14.3307 10H1.66406" stroke="#4C3EFA" />
							</svg>
						</i>
						<?php esc_html_e( 'Footer Builder', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M13.4033 13.4059C12.4757 14.3334 10.9829 14.3334 7.9974 14.3334C5.01184 14.3334 3.51905 14.3334 2.59156 13.4059C1.66406 12.4784 1.66406 10.9856 1.66406 8.00002C1.66406 5.01446 1.66406 3.52167 2.59156 2.59418C3.51906 1.66669 5.01184 1.66669 7.9974 1.66669C10.9829 1.66669 12.4757 1.66669 13.4033 2.59418C14.3307 3.52168 14.3307 5.01446 14.3307 8.00002C14.3307 10.9856 14.3307 12.4784 13.4033 13.4059Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M14.3307 5.66669H1.66406" stroke="#4C3EFA" />
								<path d="M14.3307 10.3333H1.66406" stroke="#4C3EFA" />
							</svg>
						</i>
						<?php esc_html_e( 'Advanced Layouts', 'cozy-addons' ); ?>
					</li>
				</ul>
			</li>
			<li class="boxed-layout">
				<h3 class="feature-title has-icon">
					<i class="title-icon">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M3.29884 5.36046H7.2214M1.33594 12L5.00102 8.3908C5.14203 8.25193 5.36232 8.23627 5.52131 8.35387L8.35187 10.4475C8.5186 10.5709 8.7512 10.5469 8.88967 10.3922L14.1925 4.46841M12.0749 4H13.9563C14.3216 4 14.6199 4.29385 14.6273 4.66119L14.6693 6.70993"
								stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</i>
					<?php esc_html_e( 'Business Growth', 'cozy-addons' ); ?>
				</h3>

				<ul class="icon-list">
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M1.32812 7.00002C1.32812 6.48616 1.33711 5.98455 1.35419 5.50022C1.41001 3.91791 1.43792 3.12675 2.0815 2.47832C2.72509 1.82989 3.53859 1.79509 5.16559 1.72548C6.05824 1.68729 7.00873 1.66669 7.9948 1.66669C8.98087 1.66669 9.93133 1.68729 10.824 1.72548C12.451 1.79509 13.2645 1.82989 13.9081 2.47832C14.5517 3.12675 14.5796 3.91791 14.6354 5.50022C14.6525 5.98455 14.6615 6.48616 14.6615 7.00002C14.6615 7.51389 14.6525 8.01549 14.6354 8.49982C14.5796 10.0822 14.5517 10.8733 13.9081 11.5218C13.2645 12.1702 12.451 12.205 10.8239 12.2746C10.3347 12.2955 9.828 12.3112 9.30767 12.321C8.81353 12.3304 8.56653 12.3351 8.34947 12.4178C8.1324 12.5004 7.94973 12.657 7.58447 12.9702L6.13149 14.2162C6.04328 14.2918 5.93093 14.3334 5.81473 14.3334C5.54599 14.3334 5.32813 14.1155 5.32813 13.8468V12.2813C5.27374 12.2791 5.21956 12.2769 5.16559 12.2746C3.53859 12.205 2.72509 12.1702 2.0815 11.5217C1.43792 10.8733 1.41001 10.0822 1.35419 8.49982C1.33711 8.01549 1.32812 7.51389 1.32812 7.00002Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M6.9948 6.99998V5.66665C6.9948 5.03811 6.9948 4.72384 6.79953 4.52857C6.60427 4.33331 6.29 4.33331 5.66146 4.33331C5.03292 4.33331 4.71865 4.33331 4.52339 4.52857C4.32813 4.72384 4.32812 5.03811 4.32812 5.66665C4.32812 6.29519 4.32813 6.60945 4.52339 6.80471C4.71865 6.99998 5.03292 6.99998 5.66146 6.99998H6.9948ZM6.9948 6.99998V7.59891C6.9948 8.28385 6.9948 8.62631 6.872 8.89225C6.73913 9.17998 6.50813 9.41098 6.22042 9.54385C5.95443 9.66665 5.61198 9.66665 4.92708 9.66665"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M11.6667 6.99998V5.66665C11.6667 5.03811 11.6667 4.72384 11.4714 4.52857C11.2761 4.33331 10.9619 4.33331 10.3333 4.33331C9.7048 4.33331 9.39053 4.33331 9.19527 4.52857C9 4.72384 9 5.03811 9 5.66665C9 6.29519 9 6.60945 9.19527 6.80471C9.39053 6.99998 9.7048 6.99998 10.3333 6.99998H11.6667ZM11.6667 6.99998V7.59891C11.6667 8.28385 11.6667 8.62631 11.5439 8.89225C11.411 9.17998 11.18 9.41098 10.8923 9.54385C10.6263 9.66665 10.2839 9.66665 9.59893 9.66665"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'Testimonials', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M4 11.983C4.0858 12.8553 4.27971 13.4424 4.71794 13.8806C5.50397 14.6667 6.76907 14.6667 9.29927 14.6667C11.8295 14.6667 13.0946 14.6667 13.8806 13.8806C14.6667 13.0946 14.6667 11.8295 14.6667 9.29927C14.6667 6.76907 14.6667 5.50397 13.8806 4.71794C13.4424 4.27971 12.8553 4.0858 11.983 4"
									stroke="#4C3EFA" />
								<path
									d="M1.33594 6.66665C1.33594 4.15249 1.33594 2.89541 2.11698 2.11436C2.89804 1.33331 4.15511 1.33331 6.66927 1.33331C9.1834 1.33331 10.4405 1.33331 11.2215 2.11436C12.0026 2.89541 12.0026 4.15249 12.0026 6.66665C12.0026 9.18078 12.0026 10.4379 11.2215 11.2189C10.4405 12 9.1834 12 6.66927 12C4.15511 12 2.89804 12 2.11698 11.2189C1.33594 10.4379 1.33594 9.18078 1.33594 6.66665Z"
									stroke="#4C3EFA" />
								<path d="M3.33594 12C5.61634 8.83246 8.17907 4.63166 12.0026 7.78226"
									stroke="#4C3EFA" />
							</svg>
						</i>
						<?php esc_html_e( 'Portfolio', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="15" height="13" viewBox="0 0 15 13" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M11.1667 12.4997C11.1667 10.9882 11.1667 10.2325 10.8953 9.63947C10.61 9.01607 10.1192 8.50927 9.50476 8.20354C8.92029 7.91274 8.16669 7.83301 6.65089 7.83641L5.01518 7.83301C3.5 7.83301 2.76331 7.90427 2.18616 8.18501C1.5524 8.49321 1.05125 9.00974 0.762747 9.65194C0.500007 10.2368 0.500007 10.9911 0.5 12.4997"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M8.50524 3.16667C8.50524 4.63943 7.3113 5.83334 5.83857 5.83334C4.36578 5.83334 3.17188 4.63943 3.17188 3.16667C3.17188 1.69391 4.36578 0.5 5.83857 0.5C7.3113 0.5 8.50524 1.69391 8.50524 3.16667Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M13.8373 12.4993C13.8373 10.9955 13.8373 10.2437 13.5659 9.65375C13.2805 9.03362 12.7863 8.47015 12.1719 8.16602"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M9.83594 0.583008C10.9861 0.879041 11.8359 1.92311 11.8359 3.16567C11.8359 4.40823 10.9861 5.4523 9.83594 5.7483"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'Team Sections', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<rect x="2" y="2" width="12" height="12" rx="6" stroke="#4C3EFA" />
								<path
									d="M7.63281 13.9873C4.49015 13.7975 2 11.1904 2 8C2 4.8096 4.49012 2.20146 7.63281 2.01172V13.9873Z"
									fill="#ECEBFF" stroke="#4C3EFA" />
								<rect x="6.23438" y="6.76367" width="3.26818" height="3.26818" rx="1.63409"
									fill="#4C3EFA" />
								<line x1="7.35994" y1="7.78497" x2="7.35994" y2="9.01054" stroke="white"
									stroke-width="0.204261" />
								<line x1="7.76619" y1="7.78497" x2="7.76619" y2="9.01054" stroke="white"
									stroke-width="0.204261" />
								<line x1="8.18026" y1="7.78497" x2="8.18026" y2="9.01054" stroke="white"
									stroke-width="0.204261" />
							</svg>
						</i>
						<?php esc_html_e( 'Before/After Image', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M5.4834 4.00031C5.75952 4.00031 5.98337 4.22419 5.9834 4.50031C5.9834 4.77645 5.75954 5.00031 5.4834 5.00031H3.62891C2.725 5.00033 1.99225 5.73313 1.99219 6.63702V12.3636C1.9922 12.7961 2.1615 13.1881 2.43555 13.4808L6.19043 9.72589H4.27148V8.9007H6.97852C7.32137 8.9007 7.59961 9.17919 7.59961 9.52179V12.2288H6.77441V10.3089L3.15332 13.929C3.30392 13.9747 3.46338 14.0003 3.62891 14.0003H9.35547C10.2594 14.0003 10.9922 13.2675 10.9922 12.3636V10.7288C10.9922 10.4527 11.2161 10.2288 11.4922 10.2288C11.7683 10.2288 11.9922 10.4527 11.9922 10.7288V12.3636L11.9785 12.6331C11.8525 13.8741 10.866 14.8606 9.625 14.9866L9.35547 15.0003H3.62891C2.2637 15.0003 1.14088 13.9627 1.00586 12.6331L0.992188 12.3636V6.63702C0.992247 5.18084 2.17272 4.00033 3.62891 4.00031H5.4834ZM12.3984 2.12628C13.2269 2.12628 13.8984 2.79785 13.8984 3.62628V6.62628C13.8984 7.45471 13.2269 8.12628 12.3984 8.12628H9.39844C8.57001 8.12628 7.89844 7.45471 7.89844 6.62628V3.62628C7.89844 2.79785 8.57001 2.12628 9.39844 2.12628H12.3984ZM9.39844 3.12628C9.1223 3.12628 8.89844 3.35014 8.89844 3.62628V6.62628C8.89844 6.90242 9.1223 7.12628 9.39844 7.12628H12.3984C12.6746 7.12628 12.8984 6.90242 12.8984 6.62628V3.62628C12.8984 3.35014 12.6746 3.12628 12.3984 3.12628H9.39844Z"
									fill="#4C3EFA" />
							</svg>
						</i>
						<?php esc_html_e( 'Popup Builder', 'cozy-addons' ); ?>
					</li>
				</ul>
			</li>
			<li class="boxed-layout">
				<h3 class="feature-title has-icon">
					<i class="title-icon">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M5.32812 10.6667L5.81077 8.73607C5.92682 8.27187 6.16684 7.848 6.50517 7.5096L10.9447 3.07006L11.6047 2.41007C12.1515 1.86331 13.038 1.86331 13.5847 2.41007C14.1315 2.95683 14.1315 3.84329 13.5847 4.39005L12.9247 5.05004L8.48513 9.4896C8.1468 9.82793 7.72286 10.068 7.25866 10.184L5.32812 10.6667Z"
								stroke="#4C3EFA" stroke-linejoin="round" />
							<path
								d="M12.6588 9.00001C12.6588 11.1917 12.6588 12.2875 12.0535 13.0251C11.9427 13.1601 11.8189 13.2839 11.6839 13.3947C10.9463 14 9.85046 14 7.65879 14H7.32553C4.81136 14 3.55429 14 2.77325 13.2189C1.99221 12.4379 1.99219 11.1808 1.99219 8.66668V8.33334C1.99219 6.14169 1.99219 5.04587 2.59748 4.3083C2.7083 4.17328 2.83211 4.04946 2.96715 3.93864C3.70471 3.33334 4.80053 3.33334 6.99219 3.33334"
								stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</i>
					<?php esc_html_e( 'Content Creation', 'cozy-addons' ); ?>
				</h3>

				<ul class="icon-list">
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M3.55816 2.00001C5.19846 1.99771 6.7816 2.59139 8.0026 3.66667V14C6.7816 12.9247 5.19846 12.3311 3.55816 12.3333C2.51682 12.3333 1.99615 12.3333 1.76611 12.1861C1.628 12.0977 1.57158 12.0413 1.48318 11.9031C1.33594 11.6731 1.33594 11.2627 1.33594 10.4419V4.26881C1.33594 3.31695 1.33594 2.84103 1.70176 2.45524C2.06759 2.06945 2.44209 2.04955 3.19108 2.00973C3.3126 2.00327 3.43499 2.00001 3.55816 2.00001Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M12.4445 2.00001C10.8041 1.99771 9.221 2.59139 8 3.66667V14C9.221 12.9247 10.8041 12.3311 12.4445 12.3333C13.4858 12.3333 14.0065 12.3333 14.2365 12.1861C14.3746 12.0977 14.431 12.0413 14.5194 11.9031C14.6667 11.6731 14.6667 11.2627 14.6667 10.4419V4.26881C14.6667 3.31695 14.6667 2.84103 14.3009 2.45524C13.935 2.06945 13.5605 2.04955 12.8115 2.00973C12.69 2.00327 12.5676 2.00001 12.4445 2.00001Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'Blog Layouts', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M12.0026 10V6C12.0026 4.11438 12.0026 3.17157 11.4168 2.58579C10.831 2 9.8882 2 8.0026 2H5.33594C3.45032 2 2.50751 2 1.92172 2.58579C1.33594 3.17157 1.33594 4.11438 1.33594 6V10C1.33594 11.8856 1.33594 12.8284 1.92172 13.4142C2.50751 14 3.45032 14 5.33594 14H13.3359"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M4 5.33331H9.33333" stroke="#4C3EFA" stroke-linecap="round"
									stroke-linejoin="round" />
								<path d="M4 8H9.33333" stroke="#4C3EFA" stroke-linecap="round"
									stroke-linejoin="round" />
								<path d="M4 10.6667H6.66667" stroke="#4C3EFA" stroke-linecap="round"
									stroke-linejoin="round" />
								<path
									d="M12 5.33331H12.6667C13.6095 5.33331 14.0809 5.33331 14.3738 5.62621C14.6667 5.9191 14.6667 6.39051 14.6667 7.33331V12.6666C14.6667 13.403 14.0697 14 13.3333 14C12.5969 14 12 13.403 12 12.6666V5.33331Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'Magazine Features', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M10.2459 6.48499C10.6025 6.66665 11.0692 6.66665 12.0026 6.66665C12.936 6.66665 13.4027 6.66665 13.7593 6.48499C14.0729 6.3252 14.3278 6.07023 14.4876 5.75663C14.6693 5.40011 14.6693 4.9334 14.6693 3.99998C14.6693 3.06656 14.6693 2.59985 14.4876 2.24333C14.3278 1.92973 14.0729 1.67476 13.7593 1.51497C13.4027 1.33331 12.936 1.33331 12.0026 1.33331C11.0692 1.33331 10.6025 1.33331 10.2459 1.51497C9.93234 1.67476 9.6774 1.92973 9.5176 2.24333C9.33594 2.59985 9.33594 3.06656 9.33594 3.99998C9.33594 4.9334 9.33594 5.40011 9.5176 5.75663C9.6774 6.07023 9.93234 6.3252 10.2459 6.48499Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M6.66927 9.33333V6.66667C6.66927 5.73325 6.66927 5.26653 6.48762 4.91001C6.32782 4.59641 6.07286 4.34145 5.75926 4.18165C5.40274 4 4.93602 4 4.0026 4C3.06918 4 2.60247 4 2.24595 4.18165C1.93235 4.34145 1.67738 4.59641 1.51759 4.91001C1.33594 5.26653 1.33594 5.73325 1.33594 6.66667V9.33333H6.66927Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M6.66927 9.33331H1.33594V11.3333C1.33594 12.9046 1.33594 13.6903 1.82409 14.1785C2.31225 14.6666 3.09792 14.6666 4.66927 14.6666H6.66927V9.33331Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M9.33073 9.33331H6.66406V14.6666H9.33073C10.2641 14.6666 10.7309 14.6666 11.0874 14.485C11.401 14.3252 11.6559 14.0702 11.8157 13.7566C11.9974 13.4001 11.9974 12.9334 11.9974 12C11.9974 11.0666 11.9974 10.5998 11.8157 10.2433C11.6559 9.92971 11.401 9.67478 11.0874 9.51498C10.7309 9.33331 10.2641 9.33331 9.33073 9.33331Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'Advanced Post Blocks', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M8.0026 8.00002C8.0026 8.00002 6.17688 11.3334 4.33594 11.3334C2.49499 11.3334 1.33594 9.84095 1.33594 8.00002C1.33594 6.15907 2.49499 4.66669 4.33594 4.66669C6.17688 4.66669 8.0026 8.00002 8.0026 8.00002ZM8.0026 8.00002C8.0026 8.00002 9.82834 11.3334 11.6693 11.3334C13.5102 11.3334 14.6693 9.84095 14.6693 8.00002C14.6693 6.15907 13.5102 4.66669 11.6693 4.66669C9.82834 4.66669 8.0026 8.00002 8.0026 8.00002Z"
									stroke="#4C3EFA" />
							</svg>
						</i>
						<?php esc_html_e( 'Dynamic Content', 'cozy-addons' ); ?>
					</li>
					<li class="list-item">
						<i class="icon-wrapper">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M2.21568 8.6742C2.44927 6.67267 2.79057 5.17189 3.10709 4.10567C3.36663 3.23141 3.49639 2.79427 4.02855 2.39713C4.56071 2 5.10465 2 6.19251 2H9.80753C10.8954 2 11.4393 2 11.9715 2.39713C12.5036 2.79427 12.6334 3.23141 12.8929 4.10567C13.2095 5.17189 13.5507 6.67267 13.7843 8.6742C14.0597 11.0331 14.1973 12.2126 13.4018 13.1063C12.6063 14 11.3172 14 8.73894 14H7.26107C4.68281 14 3.39368 14 2.59821 13.1063C1.80274 12.2126 1.94039 11.0331 2.21568 8.6742Z"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
								<path
									d="M6 4.66669C6 5.77125 6.8954 6.66669 8 6.66669C9.1046 6.66669 10 5.77125 10 4.66669"
									stroke="#4C3EFA" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</i>
						<?php esc_html_e( 'WooCommerce Blocks', 'cozy-addons' ); ?>
					</li>
				</ul>
			</li>
		</ul>
	</div>

	<div class="ca-spacer"></div>

	<div class="starter-templates banner-box boxed-layout flex-layout">
		<div>
			<p class="section-pill"><?php esc_html_e( 'Starter Templates', 'cozy-addons' ); ?></p>
			<h2 class="section-title">
				<?php esc_html_e( 'Skip the Blank Canvas. Start Building with a Professionally Designed Website.', 'cozy-addons' ); ?>
			</h2>
			<p><?php esc_html_e( 'Choose from 50+ professionally designed starter templates for diverse business niches. Customize your favorite and launch your website faster.', 'cozy-addons' ); ?>
			</p>
			<div class="ca-spacer sm"></div>
			<button class="ca-btn btn-primary">
				<a href="https://cozythemes.com/website-templates?tab=template"
					target="_blank"><?php esc_html_e( 'Explore All Templates →', 'cozy-addons' ); ?></a>
			</button>
		</div>
		<figure class="banner-image">
			<img height="320" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/starter-templates.png"
				alt="Banner image displaying patterns" />
		</figure>
	</div>

	<div class="ca-spacer"></div>

	<div class="faqs boxed-layout">
		<h2 class="section-title"><?php esc_html_e( 'Frequently Asked Questions', 'cozy-addons' ); ?></h2>
		<p><?php esc_html_e( 'Find quick answers about Cozy Blocks, its features, compatibility, Free vs Pro, and getting started.', 'cozy-addons' ); ?>
		</p>
		<div class="cozy-accordion">
			<div class="accordion-item active">
				<div class="accordion-header">
					<h3><?php esc_html_e( 'Is Cozy Blocks necessary?', 'cozy-addons' ); ?></h3>
					<i class="chevron">
						<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
								fill="currentColor" />
						</svg>
					</i>
				</div>
				<div class="accordion-body">
					<p><?php esc_html_e( 'Cozy Blocks is a powerful WordPress plugin that offers 50+ advanced Gutenberg blocks built specifically for the Full Site Editing (FSE) experience. It allows you to design complete websites visually — including post grids, WooCommerce layouts, galleries, portfolios, and more — all without using third-party page builders or custom code.', 'cozy-addons' ); ?>
					</p>
				</div>
			</div>

			<div class="accordion-item">
				<div class="accordion-header">
					<h3><?php esc_html_e( 'Is Cozy Blocks compatible with all WordPress themes?', 'cozy-addons' ); ?>
					</h3>
					<i class="chevron">
						<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
								fill="currentColor" />
						</svg>
					</i>
				</div>
				<div class="accordion-body">
					<p><?php esc_html_e( 'Cozy Blocks is only compatible with block-based (FSE) WordPress themes. It does not support classic themes or the Classic Editor. To get the full benefits of Cozy Blocks, you must use it with a modern block theme like SaasLauncher, HomeLancer, Jetnews Magazine, WoxStore, or any compatible Full Site Editing theme available on WordPress.org.', 'cozy-addons' ); ?>
					</p>
				</div>
			</div>

			<div class="accordion-item">
				<div class="accordion-header">
					<h3><?php esc_html_e( 'Is Cozy Blocks a replacement for Elementor or Divi?', 'cozy-addons' ); ?>
					</h3>
					<i class="chevron">
						<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
								fill="currentColor" />
						</svg>
					</i>
				</div>
				<div class="accordion-body">
					<p><?php esc_html_e( 'Yes — for block-theme users. Cozy Blocks gives you the same design capabilities (hero sections, pricing tables, sliders, mega menus, popups, WooCommerce layouts) inside the native WordPress Block Editor, without installing a separate page builder. If your site uses a modern FSE block theme, Cozy Blocks replaces everything Elementor and Divi do, while being significantly faster and lighter.', 'cozy-addons' ); ?>
					</p>
				</div>
			</div>

			<div class="accordion-item">
				<div class="accordion-header">
					<h3><?php esc_html_e( 'Building client websites as a freelancer or agency?', 'cozy-addons' ); ?>
					</h3>
					<i class="chevron">
						<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
								fill="currentColor" />
						</svg>
					</i>
				</div>
				<div class="accordion-body">
					<p><?php esc_html_e( 'Import a complete homepage template for your client’s niche in one click, then customize it fully inside the Site Editor. No third-party dependencies.', 'cozy-addons' ); ?>
					</p>
				</div>
			</div>

			<div class="accordion-item">
				<div class="accordion-header">
					<h3><?php esc_html_e( 'Running a WooCommerce store?', 'cozy-addons' ); ?></h3>
					<i class="chevron">
						<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
								fill="currentColor" />
						</svg>
					</i>
				</div>
				<div class="accordion-body">
					<p><?php esc_html_e( 'Product grids, category blocks, quick view, wishlist, product sliders, and add-to-cart blocks work natively without extra plugins.', 'cozy-addons' ); ?>
					</p>
				</div>
			</div>

			<div class="accordion-item">
				<div class="accordion-header">
					<h3><?php esc_html_e( 'Publishing a blog, news site, or magazine?', 'cozy-addons' ); ?></h3>
					<i class="chevron">
						<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
								fill="currentColor" />
						</svg>
					</i>
				</div>
				<div class="accordion-body">
					<p><?php esc_html_e( 'Post grids, news tickers, trending posts, magazine-style layouts, and categorized post tabs are all included — no theme dependency.', 'cozy-addons' ); ?>
					</p>
				</div>
			</div>

			<div class="accordion-item">
				<div class="accordion-header">
					<h3><?php esc_html_e( 'New to WordPress?', 'cozy-addons' ); ?></h3>
					<i class="chevron">
						<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
								fill="currentColor" />
						</svg>
					</i>
				</div>
				<div class="accordion-body">
					<p><?php esc_html_e( 'The 700+ ready-made patterns and 50+ homepage templates mean you can start with a professionally designed page, not a blank screen.', 'cozy-addons' ); ?>
					</p>
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
				<img height="450" src="https://plugins.cozythemes.com/cozy-addons/admin/assets/media/cta.png"
					alt="Cozy Blocks Features list" />
			</a>
		</figure>
	</div>

	<div class="ca-spacer"></div>

	<div class="money-back boxed-layout flex-layout banner-box">
		<svg width="199" height="166" viewBox="0 0 199 166" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path
				d="M40.0541 55.6153L41.532 52.9779L50.082 55.781L43.2694 49.8722L44.6968 47.3213L57.046 53.9363L56.0295 55.745L47.6237 51.2989L55.0419 57.5104L54.184 59.0453L44.9347 55.99L53.1747 60.8395L52.151 62.6626L40.0469 55.6153H40.0541Z"
				fill="#5858FA" />
			<path
				d="M58.0153 51.197C57.0133 51.161 55.9463 50.6494 54.8073 49.655L50.8783 46.2178C49.7392 45.2233 49.0976 44.2361 48.939 43.2633C48.7804 42.2833 49.1985 41.2385 50.1718 40.1216C51.145 39.0119 52.1255 38.4714 53.1275 38.4931C54.1224 38.5147 55.1893 39.0191 56.314 40.0063L60.2574 43.4507C61.382 44.4379 62.0308 45.4251 62.1966 46.4195C62.3624 47.4139 61.9587 48.466 60.9855 49.5757C60.005 50.6926 59.0174 51.233 58.0153 51.2042V51.197ZM59.7239 47.1689C59.5869 46.8303 59.2985 46.47 58.866 46.088L53.8845 41.7285C53.4519 41.3466 53.0626 41.116 52.7094 41.0367C52.3634 40.9575 52.0245 41.0944 51.7073 41.4619C51.3901 41.8222 51.2964 42.1753 51.419 42.5067C51.5487 42.8382 51.8299 43.1985 52.2624 43.5804L57.2439 47.94C57.6837 48.3291 58.0802 48.5669 58.4335 48.6533C58.7795 48.747 59.1183 48.6029 59.4499 48.2282C59.7671 47.8607 59.8609 47.5076 59.7239 47.1689Z"
				fill="#5858FA" />
			<path
				d="M56.3203 34.0543L57.8847 32.8293L64.8199 36.6412L60.3358 30.9125L62.203 29.4497L70.8395 40.4675L69.3256 41.6493L62.102 37.4698L66.8745 43.566L64.9569 45.0648L56.3203 34.0471V34.0543Z"
				fill="#5858FA" />
			<path
				d="M65.9609 27.0782L71.3245 24.167L72.2689 25.8964L69.3997 27.4529L71.1731 30.7171L73.3936 29.5138L74.3452 31.2576L72.1247 32.461L74.2226 36.3161L77.1207 34.738L78.0435 36.4386L72.651 39.3714L65.9609 27.071V27.0782Z"
				fill="#5858FA" />
			<path
				d="M79.2891 30.0052L73.875 22.965L76.3982 22.0643L79.4693 26.2005L79.116 21.0987L81.5744 20.2196L81.8771 29.0828L83.7443 34.3071L81.1562 35.2294L79.2891 30.0052Z"
				fill="#5858FA" />
			<path
				d="M90.8438 18.2449L94.3907 17.9639C95.746 17.8558 96.8201 18.036 97.6059 18.4972C98.3917 18.9583 98.8459 19.8735 98.954 21.2426C99.0189 22.0713 98.8964 22.7342 98.5864 23.2386C98.2764 23.743 97.7934 24.0817 97.1518 24.2474C97.9736 24.2979 98.6152 24.5933 99.0694 25.1338C99.5236 25.6742 99.7903 26.4452 99.8696 27.4469C100.086 30.1779 98.8387 31.6551 96.1281 31.8713L91.954 32.2027L90.8438 18.2522V18.2449ZM95.4288 29.9113C96.1208 29.8536 96.5894 29.6446 96.8418 29.2771C97.0941 28.9096 97.195 28.3548 97.1373 27.6054C97.0725 26.7983 96.8778 26.2363 96.5606 25.912C96.2362 25.5877 95.7316 25.4508 95.0251 25.5085L94.2681 25.5661L94.6213 29.9761L95.4288 29.9113ZM94.8376 23.5989C95.5297 23.5413 95.9839 23.3539 96.2146 23.0224C96.4453 22.691 96.5318 22.1866 96.4741 21.5092C96.4236 20.8895 96.229 20.4572 95.8829 20.2122C95.5369 19.9672 95.0323 19.8735 94.3546 19.9239L93.8211 19.9672L94.1167 23.6566L94.8376 23.5989Z"
				fill="#5858FA" />
			<path
				d="M105.322 17.9269L108.465 18.2584L109.669 32.4611L107.052 32.1801L106.865 29.0672L104.666 28.8366L103.808 31.8414L101.141 31.5604L105.322 17.9269ZM106.778 27.2945L106.533 21.6019L105.113 27.1144L106.778 27.2945Z"
				fill="#5858FA" />
			<path
				d="M111.833 31.9859C111.458 31.0419 111.487 29.8458 111.905 28.3974L113.304 23.5839C113.736 22.0995 114.356 21.069 115.171 20.4853C115.985 19.9017 117.11 19.8152 118.545 20.2331C119.914 20.6295 120.794 21.2492 121.169 22.085C121.544 22.9209 121.551 23.9658 121.183 25.2124L120.851 26.3437L118.199 25.5727L118.559 24.3261C118.674 23.9297 118.746 23.5983 118.782 23.3461C118.811 23.0939 118.775 22.8633 118.66 22.6543C118.545 22.4453 118.321 22.294 117.989 22.2003C117.492 22.0562 117.124 22.1211 116.886 22.4021C116.649 22.6831 116.439 23.1299 116.259 23.7496L114.479 29.853C114.298 30.4871 114.241 30.9771 114.32 31.3374C114.392 31.6977 114.659 31.9427 115.113 32.0724C115.574 32.2093 115.92 32.1372 116.144 31.8634C116.367 31.5896 116.569 31.1356 116.749 30.5231L117.132 29.2117L119.785 29.9827L119.46 31.0924C119.085 32.375 118.516 33.283 117.744 33.8234C116.973 34.3639 115.899 34.4287 114.515 34.0252C113.087 33.6072 112.186 32.9299 111.811 31.9859H111.833Z"
				fill="#5858FA" />
			<path
				d="M126.232 23.0925L128.762 24.368L126.109 29.6499L131.033 25.5065L133.506 26.7459L128.33 31.1847L127.4 39.3418L124.819 38.0447L125.698 31.4874L124.941 31.9558L122.476 36.863L119.945 35.5875L126.232 23.0781V23.0925Z"
				fill="#5858FA" />
			<path
				d="M75.0363 125.985L77.7542 127.318L75.4184 136.008L80.9478 128.882L83.572 130.165L77.646 142.847L75.7861 141.932L79.7655 133.299L73.9694 141.045L72.3834 140.267L74.9282 130.871L70.5378 139.359L68.6562 138.437L75.0363 125.971V125.985Z"
				fill="#5858FA" />
			<path
				d="M82.6431 143.44C82.2178 142.533 82.1817 141.344 82.5494 139.881L83.811 134.815C84.1786 133.352 84.7554 132.329 85.5556 131.738C86.3558 131.154 87.4732 131.039 88.915 131.399C90.3497 131.753 91.2797 132.379 91.7122 133.28C92.1447 134.181 92.188 135.355 91.8203 136.804L90.5515 141.884C90.1911 143.34 89.6071 144.363 88.7925 144.968C87.9851 145.566 86.8604 145.689 85.433 145.336C83.9912 144.975 83.054 144.341 82.6287 143.433L82.6431 143.44ZM87.0046 143.116C87.2497 142.835 87.4372 142.417 87.5742 141.862L89.1746 135.442C89.3116 134.88 89.3404 134.426 89.2539 134.08C89.1674 133.734 88.8934 133.504 88.4176 133.381C87.949 133.266 87.5958 133.338 87.3579 133.604C87.12 133.871 86.9325 134.282 86.7884 134.844L85.1879 141.264C85.0437 141.834 85.0149 142.295 85.0942 142.648C85.1735 143.001 85.4547 143.239 85.9305 143.354C86.3991 143.469 86.7523 143.39 86.9974 143.109L87.0046 143.116Z"
				fill="#5858FA" />
			<path
				d="M94.141 132.717L96.1235 132.825L98.8485 140.255L99.2378 132.991L101.602 133.114L100.86 147.093L98.9423 146.992L96.246 139.094L95.8351 146.826L93.3984 146.697L94.141 132.717Z"
				fill="#5858FA" />
			<path
				d="M103.188 132.977L109.25 132.263L109.481 134.223L106.237 134.605L106.67 138.295L109.178 137.999L109.409 139.974L106.9 140.269L107.412 144.629L110.692 144.247L110.916 146.171L104.817 146.884L103.188 132.984V132.977Z"
				fill="#5858FA" />
			<path
				d="M114.338 139.685L109.414 132.292L111.995 131.564L114.778 135.895V130.779L117.286 130.073L116.984 138.936L118.49 144.275L115.845 145.018L114.338 139.678V139.685Z"
				fill="#5858FA" />
			<path
				d="M121.828 128.097L124.878 126.26C126.045 125.561 127.084 125.236 127.992 125.301C128.908 125.366 129.715 125.986 130.421 127.153C130.847 127.867 131.034 128.515 130.984 129.106C130.926 129.697 130.652 130.208 130.147 130.648C130.904 130.324 131.611 130.302 132.26 130.583C132.909 130.864 133.493 131.433 134.004 132.298C135.417 134.647 134.963 136.521 132.635 137.926L129.052 140.08L121.828 128.09V128.097ZM127.797 131.102C128.388 130.749 128.713 130.367 128.771 129.971C128.828 129.574 128.677 129.084 128.331 128.501C128.006 127.967 127.639 127.672 127.228 127.6C126.81 127.535 126.312 127.679 125.728 128.025L125.267 128.299L127.177 131.469L127.797 131.095V131.102ZM131.15 136.492C131.741 136.132 132.072 135.735 132.13 135.296C132.195 134.856 132.029 134.316 131.647 133.674C131.229 132.983 130.804 132.565 130.371 132.413C129.938 132.262 129.419 132.37 128.821 132.73L128.172 133.12L130.457 136.91L131.157 136.492H131.15Z"
				fill="#5858FA" />
			<path
				d="M131.195 121.816L133.553 119.704L144.907 128.33L142.953 130.081L140.51 128.135L138.859 129.612L140.517 132.264L138.52 134.051L131.195 121.816ZM139.125 127.011L134.735 123.379L137.878 128.128L139.125 127.011Z"
				fill="#5858FA" />
			<path
				d="M146.684 124.769C145.667 124.769 144.564 124.308 143.375 123.386L139.41 120.316C138.191 119.372 137.456 118.414 137.211 117.441C136.966 116.468 137.297 115.394 138.22 114.213C139.092 113.081 139.994 112.498 140.909 112.454C141.825 112.411 142.798 112.793 143.829 113.586L144.759 114.306L143.065 116.49L142.041 115.697C141.709 115.445 141.435 115.258 141.212 115.128C140.988 115.005 140.758 114.955 140.52 114.991C140.289 115.02 140.066 115.171 139.849 115.445C139.532 115.856 139.46 116.223 139.633 116.547C139.806 116.872 140.145 117.232 140.657 117.621L145.689 121.512C146.208 121.916 146.648 122.146 147.008 122.204C147.368 122.262 147.693 122.11 147.981 121.736C148.277 121.354 148.342 121.008 148.161 120.698C147.988 120.388 147.642 120.035 147.131 119.639L146.049 118.803L147.743 116.619L148.659 117.326C149.719 118.147 150.353 119.012 150.569 119.92C150.786 120.835 150.454 121.858 149.574 122.997C148.666 124.171 147.7 124.762 146.684 124.762V124.769Z"
				fill="#5858FA" />
			<path
				d="M141.335 110.242L142.633 107.72L147.896 110.422L143.794 105.464L145.055 103.007L149.453 108.217L157.606 109.219L156.287 111.784L149.734 110.847L150.195 111.611L155.083 114.119L153.786 116.641L141.328 110.249L141.335 110.242Z"
				fill="#5858FA" />
			<path
				d="M62.3663 84.6543L65.9348 98.4536L68.1696 97.7258L62.9358 84.467L62.3663 84.6543ZM80.728 78.6014L80.3891 78.7095L82.0977 83.9698L83.6549 83.4654C84.4839 83.1987 84.6137 82.1971 84.0514 80.4749C83.6765 79.3292 83.28 78.6518 82.8474 78.4357C82.4221 78.2195 81.7084 78.2771 80.7135 78.6014H80.728ZM99.7024 72.5124L103.271 86.3117L105.506 85.5839L100.272 72.3251L99.7024 72.5124ZM176.761 32.6063L167.331 35.6688C147.124 6.42013 109.341 -7.49442 73.8288 4.0566C38.3166 15.6004 15.9538 49.0717 16.8333 84.6111L7.40379 87.6736L0 102.222L7.42541 125.036L21.9735 132.436L31.403 129.374C51.6102 158.63 89.3933 172.544 124.906 160.993C160.418 149.45 182.781 115.978 181.901 80.4317L191.331 77.3692L198.734 62.8277L191.309 40.0139L176.761 32.6135V32.6063ZM74.5786 6.35527C108.808 -4.77781 145.221 8.45939 164.931 36.4542L161.449 37.5855C142.46 11.4138 108.036 -0.865014 75.6527 9.66998C43.2693 20.1978 22.6655 50.3616 22.716 82.7015L19.234 83.8329C18.6933 49.6049 40.3424 17.4884 74.5714 6.35527H74.5786ZM161.131 58.8213L162.854 64.1176L156.972 66.0271L159.062 72.4548L165.601 70.329L167.396 75.8343L154.521 80.021L145.343 51.8172L157.815 47.7602L159.596 53.2295L153.468 55.2255L155.263 60.7308L161.146 58.8213H161.131ZM125.367 49.3239C114.683 40.9867 100.178 37.9314 86.3222 42.4351C72.4663 46.9388 62.5321 57.9421 58.805 70.9704L25.1383 81.9161C25.4194 50.8948 45.3094 22.0857 76.4097 11.9687C107.51 1.85881 140.549 13.4603 159.041 38.3782L125.374 49.3239H125.367ZM130.103 62.7845L128.337 57.3513L141.977 52.9196L143.743 58.3529L140.038 59.5563L147.449 82.3268L141.213 84.3517L133.802 61.5811L130.096 62.7845H130.103ZM95.622 57.9638L91.484 57.1999L88.5931 60.248L88.0452 56.083L84.246 54.2743L88.038 52.4657L88.5859 48.3007L91.484 51.3488L95.622 50.5849L93.6179 54.2816L95.622 57.9782V57.9638ZM103.365 105.645L107.503 106.409L110.394 103.361L110.941 107.526L114.741 109.334L110.949 111.143L110.401 115.308L107.503 112.26L103.365 113.024L105.369 109.327L103.365 105.631V105.645ZM109.478 94.6705L107.654 90.5631L104.504 91.5864L105.499 95.9603L99.4429 97.9275L93.4521 68.6861L103.213 65.5155L115.512 92.7033L109.492 94.6633L109.478 94.6705ZM106.119 53.9645L103.184 53.4241L101.13 55.5858L100.741 52.6314L98.0443 51.3488L100.733 50.0661L101.123 47.1117L103.177 49.2735L106.111 48.733L104.691 51.356L106.119 53.9789V53.9645ZM116.247 102.042L119.182 102.583L121.236 100.421L121.625 103.375L124.322 104.658L121.633 105.94L121.243 108.895L119.189 106.733L116.255 107.274L117.675 104.651L116.247 102.028V102.042ZM118.864 91.6152L109.687 63.4114L116.096 61.3289L123.356 73.8887L118.965 60.3993L124.985 58.4393L134.162 86.6431L128.07 88.6248L120.357 75.5245L124.949 89.6336L118.857 91.6152H118.864ZM92.8681 109.644L95.8023 110.185L97.8569 108.023L98.2462 110.977L100.942 112.26L98.2534 113.543L97.8641 116.497L95.8095 114.335L92.8754 114.876L94.2956 112.253L92.8681 109.63V109.644ZM90.7703 81.1451C90.828 81.6927 90.8063 82.1755 90.7198 82.579C90.6333 82.9898 90.4387 83.4221 90.1359 83.8833C89.8331 84.3445 89.4222 84.7624 88.9031 85.1227C89.5159 85.0434 90.0566 85.0867 90.5324 85.2524C91.001 85.4181 91.3903 85.6848 91.6931 86.0595C91.9958 86.427 92.2337 86.7873 92.414 87.1259C92.587 87.4646 92.7528 87.8609 92.897 88.3077C94.4181 92.9699 95.5427 96.5224 96.2853 98.9508L90.1936 100.932L86.6178 89.9362C86.4736 89.4967 86.315 89.1652 86.142 88.9346C85.969 88.704 85.7455 88.5743 85.4644 88.5383C85.1832 88.5023 84.9309 88.5167 84.7002 88.5599C84.4695 88.6104 84.1235 88.7112 83.6621 88.8553L87.8434 101.689L81.5354 103.743L72.3581 75.5389L81.9247 72.426C82.9051 72.1089 83.7846 71.9648 84.5704 72.008C85.3562 72.044 86.0195 72.217 86.5601 72.5196C87.1008 72.8223 87.6055 73.2907 88.0669 73.932C88.5282 74.5733 88.9103 75.2362 89.2131 75.928C89.5159 76.6198 89.8331 77.4701 90.1647 78.4861C90.3377 79.0193 90.4675 79.4517 90.5612 79.7976C90.6549 80.1362 90.727 80.583 90.7847 81.1379L90.7703 81.1451ZM82.7393 61.5667L79.8052 61.0263L77.7506 63.188L77.3613 60.2336L74.6651 58.951L77.3541 57.6683L77.7434 54.7139L79.798 56.8757L82.7321 56.3352L81.3119 58.9582L82.7393 61.5811V61.5667ZM78.1615 104.852L72.1419 106.812L70.318 102.705L67.1676 103.728L68.1624 108.102L62.1067 110.069L56.1159 80.828L65.8771 77.6574L78.1759 104.845L78.1615 104.852ZM34.5174 87.8537L40.573 85.8865L47.1838 106.193C47.2847 106.503 47.3641 106.74 47.4289 106.913C47.4938 107.086 47.602 107.324 47.7533 107.612C47.9047 107.9 48.0633 108.117 48.2219 108.261C48.3805 108.405 48.5824 108.513 48.8275 108.585C49.0726 108.657 49.3394 108.643 49.6349 108.549C49.88 108.47 50.0819 108.354 50.2405 108.218C50.3991 108.073 50.5 107.9 50.5505 107.699C50.601 107.49 50.6298 107.302 50.6442 107.122C50.6586 106.942 50.6298 106.712 50.5721 106.445C50.5072 106.171 50.4568 105.962 50.4207 105.818C50.3775 105.674 50.3198 105.472 50.2333 105.213L43.6225 84.9065L49.6782 82.9393L56.4259 103.671C57.255 106.222 57.2766 108.354 56.4836 110.077C55.6906 111.799 54.0037 113.067 51.4084 113.903C48.777 114.768 46.6359 114.746 44.985 113.817C43.3341 112.894 42.0942 111.158 41.2651 108.607L34.5174 87.8754V87.8537ZM73.3674 115.733C84.0514 124.07 98.5562 127.126 112.412 122.622C126.268 118.118 136.202 107.115 139.929 94.0868L173.596 83.1411C173.315 114.162 153.425 142.971 122.332 153.089C91.2317 163.198 58.1922 151.597 39.7007 126.679L73.3674 115.733ZM21.44 113.997L17.4605 101.783C17.028 100.45 16.8261 99.2318 16.855 98.1221C16.8838 97.0124 17.0712 96.1117 17.4101 95.4055C17.7489 94.6993 18.2391 94.0724 18.8807 93.5104C19.5224 92.9483 20.1279 92.5231 20.7119 92.2421C21.2886 91.9539 21.9374 91.6945 22.6439 91.4639C23.5162 91.1828 24.3308 90.9811 25.0806 90.8802C25.8303 90.7721 26.5008 90.7649 27.0992 90.8586C27.6975 90.9523 28.2454 91.0964 28.7356 91.2909C29.2331 91.4855 29.68 91.7881 30.091 92.1773C30.5019 92.5736 30.8623 92.9771 31.1723 93.3951C31.4823 93.813 31.7851 94.3318 32.0807 94.9587C32.3762 95.5856 32.6286 96.1765 32.8448 96.7386C33.0611 97.2934 33.2918 97.9564 33.5369 98.7274L27.5822 100.666L26.854 98.432C26.7099 97.9852 26.5368 97.6249 26.3494 97.3655C26.162 97.0989 25.9601 96.9331 25.7438 96.8683C25.5348 96.8034 25.3473 96.7674 25.1959 96.7746C25.0373 96.7746 24.8715 96.8106 24.6985 96.8683C24.3453 96.9836 24.0713 97.1205 23.8839 97.2862C23.6964 97.452 23.5667 97.6249 23.4874 97.805C23.4081 97.9852 23.4009 98.2734 23.4657 98.6625C23.5306 99.0517 23.6099 99.4192 23.7037 99.7506C23.7974 100.082 23.9632 100.608 24.1939 101.314L27.7408 112.217C27.8777 112.628 28.0003 112.973 28.1229 113.247C28.2454 113.521 28.4112 113.809 28.6275 114.105C28.8438 114.4 29.0961 114.595 29.3917 114.688C29.6872 114.782 30.0261 114.768 30.4082 114.645C31.0353 114.443 31.3742 114.062 31.4174 113.507C31.4679 112.952 31.3093 112.123 30.9488 111.028L29.8891 107.771L28.2238 108.311L26.6378 103.44L34.1857 100.983L39.5349 117.412L37.1054 118.205L35.2671 116.158C34.7481 118.327 33.3279 119.783 31.0137 120.54C26.5152 122.002 23.3216 119.826 21.4256 114.004L21.44 113.997ZM124.156 158.695C89.9268 169.828 53.5134 156.591 33.8037 128.596L37.2857 127.464C56.2818 153.643 90.6982 165.915 123.082 155.387C155.465 144.859 176.069 114.688 176.018 82.3557L179.5 81.2243C180.041 115.452 158.392 147.569 124.163 158.702L124.156 158.695ZM184.114 70.3939L171.239 74.5805L162.061 46.3767L174.533 42.3198L176.314 47.7891L170.186 49.7851L171.981 55.2904L177.864 53.3808L179.587 58.6771L173.704 60.5867L175.795 67.0143L182.334 64.8886L184.129 70.3939H184.114Z"
				fill="#5858FA" />
		</svg>
		<div>
			<h2 class="section-title"><?php esc_html_e( 'Upgrade Risk Free, 100% Money Back Guarantee!', 'cozy-addons' ); ?></h2>
			<p><strong
					style="color:var(--cozy-addons--heading)"><?php esc_html_e( 'Shop with confidence.', 'cozy-addons' ); ?></strong>
				<?php esc_html_e( 'If our product doesn’t meet your needs and our support team can’t resolve the issue, get a ', 'cozy-addons' ); ?><strong
					style="color:var(--cozy-addons--heading)"><?php esc_html_e( 'full refund within 30 days—no questions asked.', 'cozy-addons' ); ?></strong>
			</p>
		</div>
	</div>
		<?php
	}
	?>
</div>
<?php require COZY_ADDONS_PLUGIN_DIR . 'admin/sections/sidebar.php'; ?>