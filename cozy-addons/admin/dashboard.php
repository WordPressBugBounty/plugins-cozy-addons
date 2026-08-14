<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="cozy-blocks__dashboard">
	<div class="toast-message"></div>

	<?php
	if ( ! cozy_addons_premium_access() ) {
		?>
		<section class="dashboard__notifier-bar">
			<p>🚀
				<?php esc_html_e( 'Build More with Cozy Blocks Pro — Unlock Premium Blocks, Advanced Tools & More.', 'cozy-addons' ); ?>
			</p>
		</section>
		<?php
	}
	?>

	<section class="dashboard__header">
		<div class="brand-nav__wrapper">
			<div class="ca__brand-identity">
				<figure class="ca__logo">
					<img
						src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/cozy-addons-icon.png' ); ?>" />
				</figure>
				<div>
					<h1 class="plugin-name"><?php esc_html_e( 'Cozy Blocks', 'cozy-addons' ); ?></h1>
					<p class="plugin-version">
						<?php echo esc_html__( 'Version ', 'cozy-addons' ) . esc_html( COZY_ADDONS_VERSION ); ?></p>
				</div>
			</div>
			<ul class="ct-tabs" id="ct-dashboard-tabs">
				<li class="ct-tab" data-slug="dashboard"><?php esc_html_e( 'Dashboard', 'cozy-addons' ); ?></li>

				<?php if ( \CozyAddons\Helpers\Utils::is_block_theme() ) { ?>
				<div class="ct-tab" data-slug="blocks"><?php esc_html_e( 'Blocks', 'cozy-addons' ); ?></div>
				<?php } ?>

				<li class="ct-tab" data-slug="settings"><?php esc_html_e( 'Settings', 'cozy-addons' ); ?></li>

				<li class="ct-tab" data-slug="free-pro-comparison"><?php esc_html_e( 'Free VS Pro', 'cozy-addons' ); ?>
				</li>

				<li class="ct-tab" data-slug="license"><?php esc_html_e( 'License', 'cozy-addons' ); ?></li>

				<li class="ct-tab" data-slug="products"><?php esc_html_e( 'Our Products', 'cozy-addons' ); ?></li>
			</ul>
		</div>
		<?php
		if ( ! cozy_addons_premium_access() ) {
			?>
		<div>
			<button class="ca-btn btn-primary has-icon">
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
		</div>
			<?php
		}
		?>
	</section>

	<section class="dashboard__body">
		<div class="tab-content" id="dashboard">
			<?php
			require_once COZY_ADDONS_PLUGIN_DIR . 'admin/pages/index.php';
			?>
		</div>

		<?php
		if ( \CozyAddons\Helpers\Utils::is_block_theme() ) :
			?>

		<div class="tab-content" id="blocks">
			<?php require_once COZY_ADDONS_PLUGIN_DIR . 'admin/pages/blocks.php'; ?>
		</div>

		<?php endif; ?>

		<div class="tab-content" id="settings">
			<?php require_once COZY_ADDONS_PLUGIN_DIR . 'admin/pages/settings.php'; ?>
		</div>

		<div class="tab-content" id="free-pro-comparison">
			<?php require_once COZY_ADDONS_PLUGIN_DIR . 'admin/pages/features.php'; ?>
		</div>

		<div class="tab-content" id="license">
			<?php require_once COZY_ADDONS_PLUGIN_DIR . 'admin/pages/license.php'; ?>
		</div>

		<div class="tab-content" id="products">
			<?php require_once COZY_ADDONS_PLUGIN_DIR . 'admin/pages/our-products.php'; ?>
		</div>
	</section>
</div>