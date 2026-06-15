<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'cc_fs' ) ) {
	return;
}

// Prepare Freemius template variables
$VARS = array(
	'id'         => cc_fs()->get_id(),
	'slug'       => cc_fs()->get_slug(),
	'public_key' => cc_fs()->get_public_key(),
	'is_plugin'  => true,
	'is_theme'   => false,
);

$account_url = menu_page_url( '_cozy_companions-account', false );
?>
<div class="license-page">
	<?php
	if ( ! cozy_addons_premium_access() ) {
		?>
	<section class="plan__details">
		<div class="plan__type">
			<h3><?php esc_html_e( 'Current Plan', 'cozy-addons' ); ?></h3>
			<p class="plan__pill"><?php esc_html_e( 'Free', 'cozy-addons' ); ?></p>
		</div>

		<div class="plan__description">
			<p><?php esc_html_e( "You're currently using the free version of Cozy Blocks. Upgrade to Pro to unlock all features.", 'cozy-addons' ); ?></p>
		</div>
	</section>
		
	<section class="license__management">
			<h3><?php esc_html_e( 'Activate License', 'cozy-addons' ); ?></h3>
			<?php
			// Render Freemius opt-in screen inline
			ob_start();
			require COZY_ADDONS_PLUGIN_DIR . 'freemius/templates/connect.php';
			echo ob_get_clean();

			if ( strlen( $account_url ) > 0 ) {
				?>
				<div class="account__management">
					<p><?php esc_html_e( 'License key already entered? Manage your account here.', 'cozy-addons' ); ?></p>
					<a href="<?php echo esc_url( $account_url ); ?>"><?php esc_html_e( 'Manage Account', 'cozy-addons' ); ?></a>
				</div>
				<?php
			}
			?>
	</section>

	<section class="upsell__notice">
		<div class="pro__crown">
			<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.33331 12.6667H14.6666V14H1.33331V12.6667ZM1.33331 3.33334L4.66665 5.66668L7.99998 1.33334L11.3333 5.66668L14.6666 3.33334V11.3333H1.33331V3.33334ZM2.66665 5.89401V10H13.3333V5.89401L11.0533 7.49001L7.99998 3.52001L4.94665 7.49001L2.66665 5.89401Z" />
			</svg>
		</div>
		<div>
			<h3><?php esc_html_e( 'Upgrade to Cozy Blocks Pro', 'cozy-addons' ); ?></h3>
			<p><?php esc_html_e( 'Access 50+ premium blocks, advanced design controls, dynamic content, and WooCommerce-ready elements — everything you need to build stunning websites faster.', 'cozy-addons' ); ?></p>
			<a class="ca__primary-btn btn-md" href="https://cozythemes.com/pricing-and-plans" target="_blank"><?php esc_html_e( 'View Pricing Plans', 'cozy-addons' ); ?></a>
		</div>
	</section>
		<?php
	} else {
		?>
	<section class="plan__details">
		<div class="plan__type">
			<h3><?php esc_html_e( 'Current Plan', 'cozy-addons' ); ?></h3>
			<p class="plan__pill pro"><?php esc_html_e( 'Pro', 'cozy-addons' ); ?></p>
		</div>

		<div class="plan__description">
			<p><?php esc_html_e( 'Woohoo! You’re all set. Enjoy full access to all features.', 'cozy-addons' ); ?></p>
		</div>

		<a class="account__management" href="<?php echo esc_url( $account_url ); ?>"><?php esc_html_e( 'Manage Account', 'cozy-addons' ); ?></a>
	</section>
		<?php
	}
	?>
</div>
