<?php
/**
 * Dashboard: CozyThemes block themes made for Cozy Blocks.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cozy_dashboard_themes = array(
	'homelancer'       => array( __( 'HomeLancer', 'cozy-addons' ), __( 'Home services', 'cozy-addons' ) ),
	'saaslauncher'     => array( __( 'SaasLauncher', 'cozy-addons' ), __( 'SaaS & startup', 'cozy-addons' ) ),
	'jetnews-magazine' => array( __( 'Jetnews Magazine', 'cozy-addons' ), __( 'Blog & magazine', 'cozy-addons' ) ),
	'woxstore'         => array( __( 'WoxStore', 'cozy-addons' ), __( 'WooCommerce', 'cozy-addons' ) ),
);

$cozy_dashboard_active_theme = array( get_stylesheet(), get_template() );
?>
<section class="cbd-card cbd-themes">
	<h2 class="cbd-card__title"><?php esc_html_e( 'Pair it with a theme built for it', 'cozy-addons' ); ?></h2>
	<p class="cbd-card__lead"><?php esc_html_e( 'CozyThemes block themes are designed alongside Cozy Blocks, so layouts and styles match from day one.', 'cozy-addons' ); ?></p>

	<ul class="cbd-themes__list">
		<?php foreach ( $cozy_dashboard_themes as $cozy_dashboard_slug => $cozy_dashboard_theme ) : ?>
			<?php
			$cozy_dashboard_is_active = in_array( $cozy_dashboard_slug, $cozy_dashboard_active_theme, true );
			$cozy_dashboard_installed = wp_get_theme( $cozy_dashboard_slug )->exists();
			$cozy_dashboard_url       = $cozy_dashboard_installed
				? admin_url( 'themes.php?theme=' . $cozy_dashboard_slug )
				: admin_url( 'theme-install.php?search=' . $cozy_dashboard_slug );
			?>
			<li>
				<a class="cbd-theme<?php echo $cozy_dashboard_is_active ? ' is-active' : ''; ?>" href="<?php echo esc_url( $cozy_dashboard_url ); ?>">
					<img
						class="cbd-theme__image"
						src="<?php echo esc_url( 'https://plugins.cozythemes.com/cozy-addons/admin/assets/media/' . $cozy_dashboard_slug . '.webp' ); ?>"
						width="600"
						height="425"
						loading="lazy"
						decoding="async"
						alt="<?php echo esc_attr( sprintf( /* translators: %s: theme name. */ __( '%s theme preview', 'cozy-addons' ), $cozy_dashboard_theme[0] ) ); ?>"
					/>
					<strong>
						<?php echo esc_html( $cozy_dashboard_theme[0] ); ?>
						<?php if ( $cozy_dashboard_is_active ) : ?>
							<span class="cbd-pill cbd-pill--green"><?php esc_html_e( 'Active', 'cozy-addons' ); ?></span>
						<?php endif; ?>
					</strong>
					<span><?php echo esc_html( $cozy_dashboard_theme[1] ); ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
