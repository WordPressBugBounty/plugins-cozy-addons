<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="sidebar">
	<?php
	if ( ! cozy_addons_premium_access() ) {
		?>
	<div class="boxed-layout upsell-section">
		<h3 class="sidebar-section-title">
			<i class="sidebar-icon">
				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12.3307 1.33331V4.66665M13.9974 2.99998H10.6641" stroke="currentColor" stroke-width="1.2"
						stroke-linecap="round" stroke-linejoin="round" />
					<path d="M3.33594 14.6667H12.6693" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
						stroke-linejoin="round" />
					<path
						d="M11.2504 12.6666H4.7548C4.06938 12.6666 3.72668 12.6666 3.46676 12.4822C3.20683 12.2978 3.0936 11.9744 2.86713 11.3274L1.37009 7.05111C1.29042 6.81551 1.35262 6.55571 1.53077 6.38009C1.75496 6.15907 2.10624 6.12478 2.37005 6.29816L3.1916 6.83811C4.02086 7.38311 4.4355 7.65565 4.8547 7.55658C5.27391 7.45751 5.52273 7.02825 6.02037 6.16972L7.49674 3.62273C7.60047 3.44376 7.79354 3.33331 8.0026 3.33331C8.21167 3.33331 8.40474 3.44376 8.50847 3.62273L9.9848 6.16972C10.4825 7.02825 10.7313 7.45751 11.1505 7.55658C11.5697 7.65565 11.9843 7.38311 12.8136 6.83811L13.6351 6.29816C13.8989 6.12478 14.2503 6.15907 14.4745 6.38009C14.6526 6.55571 14.7148 6.81551 14.6351 7.05111L13.1381 11.3274C12.9116 11.9744 12.7984 12.2978 12.5385 12.4822C12.2785 12.6666 11.9358 12.6666 11.2504 12.6666Z"
						stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</i>
			<?php esc_html_e( 'Build More with Pro', 'cozy-addons' ); ?>
		</h3>

		<ul class="upsell-list">
			<li class="upsell-item">
				<i class="check-icon">
					<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2.08594 5.83331L3.54427 7.29165L7.91927 2.70831" stroke="currentColor"
							stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</i>
				<?php esc_html_e( 'Premium Templates', 'cozy-addons' ); ?>
			</li>
			<li class="upsell-item">
				<i class="check-icon">
					<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2.08594 5.83331L3.54427 7.29165L7.91927 2.70831" stroke="currentColor"
							stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</i>
				<?php esc_html_e( '700+ patterns', 'cozy-addons' ); ?>
			</li>
			<li class="upsell-item">
				<i class="check-icon">
					<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2.08594 5.83331L3.54427 7.29165L7.91927 2.70831" stroke="currentColor"
							stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</i>
				<?php esc_html_e( '50+ Advanced Blocks', 'cozy-addons' ); ?>
			</li>
			<li class="upsell-item">
				<i class="check-icon">
					<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2.08594 5.83331L3.54427 7.29165L7.91927 2.70831" stroke="currentColor"
							stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</i>
				<?php esc_html_e( 'Priority Support', 'cozy-addons' ); ?>
			</li>
		</ul>

		<div class="ca-spacer sm">
		</div>

		<button class="ca-btn is-full-width btn-secondary-alt">
			<a href="https://cozythemes.com/pricing-and-plans/#free-vs-pro"
				target="_blank"><?php esc_html_e( 'Compare Free vs Pro', 'cozy-addons' ); ?></a>
		</button>

		<div class="ca-spacer sm">
		</div>

		<button class="ca-btn is-full-width btn-secondary">
			<a href="https://cozythemes.com/pricing-and-plans"
				target="_blank"><?php esc_html_e( 'Upgrade Now', 'cozy-addons' ); ?></a>
		</button>
	</div>
	<div class="ca-spacer sm"></div>
		<?php
	}
	?>

	<div class="boxed-layout">
		<h3 class="sidebar-section-title"><?php esc_html_e( 'Need Help?', 'cozy-addons' ); ?></h3>
		<ul class="ca-helper-links">
			<li class="helper-link">
				<a href="https://docs.cozythemes.com/cozy-blocks" target="_blank" rel="nofollow noopener">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M3.55816 2.00001C5.19846 1.99771 6.7816 2.59139 8.0026 3.66667V14C6.7816 12.9247 5.19846 12.3311 3.55816 12.3333C2.51682 12.3333 1.99615 12.3333 1.76611 12.1861C1.628 12.0977 1.57158 12.0413 1.48318 11.9031C1.33594 11.6731 1.33594 11.2627 1.33594 10.4419V4.26881C1.33594 3.31695 1.33594 2.84103 1.70176 2.45524C2.06759 2.06945 2.44209 2.04955 3.19108 2.00973C3.3126 2.00327 3.43499 2.00001 3.55816 2.00001Z"
							stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
						<path
							d="M12.4445 2.00001C10.8041 1.99771 9.221 2.59139 8 3.66667V14C9.221 12.9247 10.8041 12.3311 12.4445 12.3333C13.4858 12.3333 14.0065 12.3333 14.2365 12.1861C14.3746 12.0977 14.431 12.0413 14.5194 11.9031C14.6667 11.6731 14.6667 11.2627 14.6667 10.4419V4.26881C14.6667 3.31695 14.6667 2.84103 14.3009 2.45524C13.935 2.06945 13.5605 2.04955 12.8115 2.00973C12.69 2.00327 12.5676 2.00001 12.4445 2.00001Z"
							stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>

					<?php esc_html_e( 'Documentation', 'cozy-addons' ); ?>
				</a>
			</li>
			<li class="helper-link">
				<a href="https://cozythemes.com/support" target="_blank" rel="nofollow noopener">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M7.9948 14.6666C11.6767 14.6666 14.6615 11.6818 14.6615 7.99998C14.6615 4.31808 11.6767 1.33331 7.9948 1.33331C4.31289 1.33331 1.32812 4.31808 1.32812 7.99998C1.32812 11.6818 4.31289 14.6666 7.9948 14.6666Z"
							stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
						<path
							d="M7.9974 11.3334C9.83834 11.3334 11.3307 9.84095 11.3307 8.00002C11.3307 6.15907 9.83834 4.66669 7.9974 4.66669C6.15645 4.66669 4.66406 6.15907 4.66406 8.00002C4.66406 9.84095 6.15645 11.3334 7.9974 11.3334Z"
							stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
						<path
							d="M10.3523 5.64285L12.7093 3.28583M10.3523 10.3569L12.7093 12.7139M5.63827 10.3569L3.28125 12.7139M5.63827 5.64285L3.28125 3.28583"
							stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>

					<?php esc_html_e( 'Support', 'cozy-addons' ); ?>
				</a>
			</li>
			<li class="helper-link">
				<a href="https://plugins.svn.wordpress.org/cozy-addons/trunk/changelog.txt" target="_blank"
					rel="nofollow noopener">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M4.43359 9.0344C5.65932 5.5209 9.00205 3 12.9335 3C17.9041 3 21.9335 7.0294 21.9335 12C21.9335 16.9706 17.9041 21 12.9335 21C9.23284 21 5.83297 18.3244 4.624 15.5"
							stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M12 7.99951V12.9995H15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
							stroke-linejoin="round" />
						<path
							d="M8.42859 15.2554C8.42859 15.2554 4.74496 14.6964 4.18595 15.2554C3.62693 15.8144 4.18596 19.498 4.18596 19.498"
							stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>

					<?php esc_html_e( 'Changelog', 'cozy-addons' ); ?>
				</a>
			</li>
			<?php
			if ( ! cozy_addons_premium_access() ) {
				?>
			<li class="helper-link upsell-link">
				<a href="https://cozythemes.com/pricing-and-plans" target="_blank" rel="nofollow noopener">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12.3307 1.33331V4.66665M13.9974 2.99998H10.6641" stroke="currentColor"
							stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M3.33594 14.6667H12.6693" stroke="currentColor" stroke-width="1.2"
							stroke-linecap="round" stroke-linejoin="round" />
						<path
							d="M11.2504 12.6666H4.7548C4.06938 12.6666 3.72668 12.6666 3.46676 12.4822C3.20683 12.2978 3.0936 11.9744 2.86713 11.3274L1.37009 7.05111C1.29042 6.81551 1.35262 6.55571 1.53077 6.38009C1.75496 6.15907 2.10624 6.12478 2.37005 6.29816L3.1916 6.83811C4.02086 7.38311 4.4355 7.65565 4.8547 7.55658C5.27391 7.45751 5.52273 7.02825 6.02037 6.16972L7.49674 3.62273C7.60047 3.44376 7.79354 3.33331 8.0026 3.33331C8.21167 3.33331 8.40474 3.44376 8.50847 3.62273L9.9848 6.16972C10.4825 7.02825 10.7313 7.45751 11.1505 7.55658C11.5697 7.65565 11.9843 7.38311 12.8136 6.83811L13.6351 6.29816C13.8989 6.12478 14.2503 6.15907 14.4745 6.38009C14.6526 6.55571 14.7148 6.81551 14.6351 7.05111L13.1381 11.3274C12.9116 11.9744 12.7984 12.2978 12.5385 12.4822C12.2785 12.6666 11.9358 12.6666 11.2504 12.6666Z"
							stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>


					<?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?>
				</a>
			</li>
				<?php
			}
			?>
		</ul>
	</div>

	<div class="ca-spacer sm"></div>

	<div class="boxed-layout">
		<h3 class="sidebar-section-title">
			<i class="sidebar-icon">
				<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M9.36719 0.930237C9.42347 0.823563 9.57653 0.823568 9.63281 0.930237L11.7285 4.90192C11.9962 5.40898 12.4838 5.76311 13.0488 5.8609L17.4736 6.62653C17.5925 6.64711 17.6397 6.79297 17.5557 6.87946L14.4258 10.0992C14.026 10.5105 13.8402 11.0841 13.9219 11.6519L14.5605 16.0963C14.5777 16.2156 14.4539 16.3057 14.3457 16.2525L10.3164 14.2711C9.80163 14.0179 9.19837 14.0179 8.68359 14.2711L4.6543 16.2525C4.54606 16.3057 4.42229 16.2156 4.43945 16.0963L5.07812 11.6519C5.15978 11.0841 4.97398 10.5105 4.57422 10.0992L1.44434 6.87946C1.36028 6.79297 1.40754 6.6471 1.52637 6.62653L5.95117 5.8609C6.51618 5.76311 7.00376 5.40898 7.27148 4.90192L9.36719 0.930237Z"
						fill="#FF9A27" stroke="#FF9A27" stroke-width="1.7" />
				</svg>
			</i>
			<?php esc_html_e( 'Enjoying Cozy Blocks?', 'cozy-addons' ); ?>
		</h3>
		<p><?php esc_html_e( 'Your review helps us grow and make Cozy Blocks even better.', 'cozy-addons' ); ?></p>
		<div class="ca-spacer sm"></div>
		<button class="ca-btn is-full-width btn-secondary"><a
				href="https://wordpress.org/support/plugin/cozy-addons/reviews/#new-post"
				target="_blank"><?php esc_html_e( 'Leave a Review', 'cozy-addons' ); ?> →</a></button>
	</div>
</div>