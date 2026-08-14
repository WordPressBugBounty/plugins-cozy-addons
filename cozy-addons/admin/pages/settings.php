<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside class="setting-sidebar">
	<ul class="setting-tabs">
		<li id="custom-post-types" class="setting-tab-item is-active"><?php esc_html_e( 'Custom Post Types', 'cozy-addons' ); ?></li>
		<li id="utility-functions" class="setting-tab-item"><?php esc_html_e( 'Utility Functions', 'cozy-addons' ); ?></li>
		<li id="design-kit" class="setting-tab-item"><?php esc_html_e( 'Design Kit', 'cozy-addons' ); ?></li>
		<li id="version-control" class="setting-tab-item"><?php esc_html_e( 'Version Control', 'cozy-addons' ); ?></li>
	</ul>
</aside>
<div class="setting-body">
	<div id="custom-post-types" class="setting-tab-content is-active boxed-layout grid-layout cols-2">
		<div class="cpt flex-layout">
			<div>
				<h3 class="setting-title has-icon">
					<?php esc_html_e( 'Mega Menu Templates', 'cozy-addons' ); ?>
					<i class="icon-wrapper">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6 19L18 19" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M16.5585 16H7.44152C6.58066 16 5.81638 15.4491 5.54415 14.6325L3.70711 9.12132C3.44617 8.3385 4.26195 7.63098 5 8L5.71067 8.35533C6.48064 8.74032 7.41059 8.58941 8.01931 7.98069L10.5858 5.41421C11.3668 4.63317 12.6332 4.63316 13.4142 5.41421L15.9807 7.98069C16.5894 8.58941 17.5194 8.74032 18.2893 8.35533L19 8C19.7381 7.63098 20.5538 8.3385 20.2929 9.12132L18.4558 14.6325C18.1836 15.4491 17.4193 16 16.5585 16Z" stroke="currentColor" stroke-width="1" stroke-linejoin="round"/>
						</svg>
					</i>
				</h3>
				<p><?php esc_html_e( 'Lightweight Patterns & Homepage Templates to make website building easier', 'cozy-addons' ); ?></p>
			</div>
			<div class="toggle-switcher-wrap">
				<input type="checkbox" class="ca__block-cpt <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="mega-menu-templates" id="ca--mega-menu-cpt" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php
				$classes   = array();
				$classes[] = 'toggle-switcher';
				$classes[] = ! cozy_addons_premium_access() ? 'has-tooltip is-disabled' : '';
				?>
				<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"></span>
				<?php if ( ! cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to use this feature!', 'cozy-addons' ); ?>
					</div>
				<?php } ?>
			</div>
		</div>

		<div class="cpt flex-layout">
			<div>
				<h3 class="setting-title has-icon">
					<?php esc_html_e( 'Portfolio Gallery Templates', 'cozy-addons' ); ?>
					<i class="icon-wrapper">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6 19L18 19" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M16.5585 16H7.44152C6.58066 16 5.81638 15.4491 5.54415 14.6325L3.70711 9.12132C3.44617 8.3385 4.26195 7.63098 5 8L5.71067 8.35533C6.48064 8.74032 7.41059 8.58941 8.01931 7.98069L10.5858 5.41421C11.3668 4.63317 12.6332 4.63316 13.4142 5.41421L15.9807 7.98069C16.5894 8.58941 17.5194 8.74032 18.2893 8.35533L19 8C19.7381 7.63098 20.5538 8.3385 20.2929 9.12132L18.4558 14.6325C18.1836 15.4491 17.4193 16 16.5585 16Z" stroke="currentColor" stroke-width="1" stroke-linejoin="round"/>
						</svg>
					</i>
				</h3>
				<p><?php esc_html_e( 'Lightweight Patterns & Homepage Templates to make website building easier', 'cozy-addons' ); ?></p>
			</div>
			<div class="toggle-switcher-wrap">
				<input type="checkbox" class="ca__block-cpt <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="portfolio-gallery-templates" id="ca--portfolio-gallery-cpt" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php
				$classes   = array();
				$classes[] = 'toggle-switcher';
				$classes[] = ! cozy_addons_premium_access() ? 'has-tooltip is-disabled' : '';
				?>
				<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"></span>
				<?php if ( ! cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to use this feature!', 'cozy-addons' ); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div id="utility-functions" class="setting-tab-content boxed-layout grid-layout cols-2">
		<div class="util-function flex-layout">
			<div>
				<h3 class="setting-title"><?php esc_html_e( 'Cozy Animation', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( "'Cozy Animation' attribute in core WordPress blocks (e.g: Group, Columns, ...).", 'cozy-addons' ); ?></p>
			</div>
			<div class="toggle-switcher-wrap">
				<?php
				$checked = get_option( 'ca--utility--animation' );
				?>
				<input type="checkbox" class="ca__utility-function" name="animation" id="cozy-addons--utility--animation" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="toggle-switcher"></span>
			</div>
		</div>

		<div class="util-function flex-layout">
			<div>
				<h3 class="setting-title"><?php esc_html_e( 'Advanced Styling Effects', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( '\'Cozy Advanced Effects\', \'Cozy Responsive Visibility\' and \'Google Fonts\' attribute in core WordPress blocks (e.g: Group, Columns, ...).', 'cozy-addons' ); ?></p>
			</div>
			<div class="toggle-switcher-wrap">
				<?php
				$checked = get_option( 'ca--utility--styles' );
				?>
				<input type="checkbox" class="ca__utility-function" name="styles" id="cozy-addons--utility--styles" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="toggle-switcher"></span>
			</div>
		</div>

		<div class="util-function flex-layout">
			<div>
				<h3 class="setting-title"><?php esc_html_e( 'WP Block Post Terms Styling', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( 'Handy styling features for WP Post Terms block.', 'cozy-addons' ); ?></p>
			</div>
			<div class="toggle-switcher-wrap">
				<?php
				$checked = get_option( 'ca--utility--post-terms' );
				?>
				<input type="checkbox" class="ca__utility-function" name="post-terms" id="cozy-addons--utility--post-terms" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="toggle-switcher"></span>
			</div>
		</div>
	</div>

	<div id="design-kit" class="setting-tab-content boxed-layout grid-layout cols-2">
		<div class="design-lib flex-layout">
			<div>
				<h3 class="setting-title"><?php esc_html_e( 'Design Kit', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( 'Lightweight Patterns & Homepage Templates to make website building easier.', 'cozy-addons' ); ?></p>
			</div>
			<div class="toggle-switcher-wrap">
				<?php
				$checked = get_option( 'ca--utility--pattern-library' );
				?>
				<input type="checkbox" class="ca__utility-function" name="pattern-library" id="cozy-addons--utility--pattern-library" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="toggle-switcher"></span>
			</div>
		</div>
	</div>

	<div id="version-control" class="setting-tab-content boxed-layout">
		<div class="version-rollback">
			<p>
				<?php
				printf(
				/* translators: %s: Plugin version */
					esc_html__( 'Experiencing an issue with Cozy Blocks version %1$s? Rollback to a previous version before the issue appeared.', 'cozy-addons' ),
					esc_html( COZY_ADDONS_VERSION )
				);

				$current_version = COZY_ADDONS_VERSION;

				$nonce         = wp_create_nonce( 'cozy_addons_rollback_action' );
				$rollback_path = "admin-post.php?action=cozy_addons_rollback&version={$current_version}&_wpnonce={$nonce}";
				$url           = get_admin_url( null, $rollback_path );
				?>
			</p>

			<span class="rollback-label"><strong><?php esc_html_e( 'Rollback Version ', 'cozy-addons' ); ?></strong></span>
			<select class="cozy-addons-rollback-version">
			<?php
			$cozy_addons_versions = cozy_addons_get_plugin_versions();

			foreach ( $cozy_addons_versions as $key => $version_info ) {
				if ( version_compare( $version_info['version'], '2.0.0', '<' ) ) {
					break;
				}

				$selected = 0 === $key ? ' selected' : '';
				echo '<option value="' . esc_attr( $version_info['version'] ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $version_info['version'] ) . '</option>';
			}
			?>
			</select>
			<a id="cozy-addons-rollback-btn" class="button" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Perform Rollback', 'cozy-addons' ); ?></a>
		</div>
	</div>
</div>