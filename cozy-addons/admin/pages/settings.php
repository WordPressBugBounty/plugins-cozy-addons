<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$allowed_cpts = array(
	'mega-menu',
	'portfolio-gallery',
	'faq',
);

?>
<aside class="setting-sidebar">
	<ul class="setting-tabs">
		<li id="custom-post-types" class="setting-tab-item is-active">
			<?php esc_html_e( 'Custom Post Types', 'cozy-addons' ); ?></li>
		<li id="utility-functions" class="setting-tab-item"><?php esc_html_e( 'Utility Functions', 'cozy-addons' ); ?>
		</li>
		<li id="design-kit" class="setting-tab-item"><?php esc_html_e( 'Design Kit', 'cozy-addons' ); ?></li>
		<li id="version-control" class="setting-tab-item"><?php esc_html_e( 'Version Control', 'cozy-addons' ); ?></li>
	</ul>
</aside>
<div class="setting-body">
	<div id="custom-post-types" class="setting-tab-content cozy-accordion is-active boxed-layout grid-layout">
		<div class="cpt accordion-item">
			<?php
			$classes   = array();
			$classes[] = 'accordion-header';
			$classes[] = ! cozy_addons_premium_access() ? 'not-allowed' : '';
			?>
			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<i class="chevron">
					<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
							fill="currentColor" />
					</svg>
				</i>
				<div class="flex-layout">
					<div>
						<h3 class="setting-title has-icon">
							<?php esc_html_e( 'Mega Menu Templates', 'cozy-addons' ); ?>
							<i class="icon-wrapper">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path d="M6 19L18 19" stroke="currentColor" stroke-width="1" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M16.5585 16H7.44152C6.58066 16 5.81638 15.4491 5.54415 14.6325L3.70711 9.12132C3.44617 8.3385 4.26195 7.63098 5 8L5.71067 8.35533C6.48064 8.74032 7.41059 8.58941 8.01931 7.98069L10.5858 5.41421C11.3668 4.63317 12.6332 4.63316 13.4142 5.41421L15.9807 7.98069C16.5894 8.58941 17.5194 8.74032 18.2893 8.35533L19 8C19.7381 7.63098 20.5538 8.3385 20.2929 9.12132L18.4558 14.6325C18.1836 15.4491 17.4193 16 16.5585 16Z"
										stroke="currentColor" stroke-width="1" stroke-linejoin="round" />
								</svg>
							</i>
						</h3>
						<p><?php esc_html_e( 'Create templates for the Advanced Mega Menu block that can be used to display this content when creating a mega menu.', 'cozy-addons' ); ?>
						</p>
					</div>
					<div class="toggle-switcher-wrap">
						<?php
						$checked = get_option( 'ca-cpt--mega-menu-templates' );
						?>
						<input type="checkbox"
							class="ca__block-cpt <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>"
							name="mega-menu-templates" id="ca--mega-menu-cpt"
							<?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
						<?php
						$classes   = array();
						$classes[] = 'toggle-switcher';
						$classes[] = ! cozy_addons_premium_access() ? 'has-tooltip is-disabled' : '';
						?>
						<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"></span>
						<?php if ( ! cozy_addons_premium_access() ) { ?>
						<div class="cozy-block-upsell-tooltip">
							<a
								href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?></a>
							<?php esc_html_e( ' to use this feature!', 'cozy-addons' ); ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="accordion-body">
				<?php
				$mega_menu_cpt_config = cozy_addons_get_cpt_config_option( 'mega-menu' );
				?>
				<p>
					<label for="mega-menu-slug"><?php esc_html_e( 'Post type slug', 'cozy-addons' ); ?></label>
					<input id="mega-menu-slug" class="cpt-field" type="text" name="ca-mega-menu-slug" data-cpt="mega-menu" data-type="slug" value="<?php echo esc_attr( $mega_menu_cpt_config['slug'] ); ?>" data-previous-value="<?php echo esc_attr( $mega_menu_cpt_config['slug'] ); ?>" />
				</p>

				<div class="ca-buttons">
					<div class="ca-btn btn-primary save-button">
						<a><?php esc_html_e( 'Save Changes', 'cozy-addons' ); ?></a>
					</div>
					<div class="ca-btn btn-secondary cancel-button">
						<a><?php esc_html_e( 'Cancel', 'cozy-addons' ); ?></a>
					</div>
				</div>

				<div class="ca-spacer sm"></div>
				<hr />
				<div class="ca-spacer sm"></div>

				<div class="flex-layout">
					<div>
						<p>
							<?php echo esc_html__( 'Current permalink structure: ', 'cozy-addons' ) . esc_html( get_option( 'permalink_structure' ) ); ?>
							| <a href="<?php echo esc_url( admin_url( 'options-permalink.php' ) ); ?>"><?php esc_html_e( 'Update structure', 'cozy-addons' ); ?></a>
						</p>
		
						<p>
							<?php esc_html_e( '*Permalinks are flushed automatically after saving.', 'cozy-addons' ); ?>
						</p>
					</div>
					<button class="ca-btn btn-primary-accent">
						<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ca_mega_menu' ) ); ?>"><?php esc_html_e( 'Add Mega Menu', 'cozy-addons' ); ?></a>
					</button>
				</div>
			</div>
		</div>

		<div class="cpt accordion-item">
			<?php
			$classes   = array();
			$classes[] = 'accordion-header';
			$classes[] = ! cozy_addons_premium_access() ? 'not-allowed' : '';
			?>
			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<i class="chevron">
					<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
							fill="currentColor" />
					</svg>
				</i>
				<div class="flex-layout">
					<div>
						<h3 class="setting-title has-icon">
							<?php esc_html_e( 'Portfolio Gallery Templates', 'cozy-addons' ); ?>
							<i class="icon-wrapper">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M6 19L18 19" stroke="currentColor" stroke-width="1" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M16.5585 16H7.44152C6.58066 16 5.81638 15.4491 5.54415 14.6325L3.70711 9.12132C3.44617 8.3385 4.26195 7.63098 5 8L5.71067 8.35533C6.48064 8.74032 7.41059 8.58941 8.01931 7.98069L10.5858 5.41421C11.3668 4.63317 12.6332 4.63316 13.4142 5.41421L15.9807 7.98069C16.5894 8.58941 17.5194 8.74032 18.2893 8.35533L19 8C19.7381 7.63098 20.5538 8.3385 20.2929 9.12132L18.4558 14.6325C18.1836 15.4491 17.4193 16 16.5585 16Z"
										stroke="currentColor" stroke-width="1" stroke-linejoin="round" />
								</svg>
							</i>
						</h3>
						<p><?php esc_html_e( 'Templates created here will appear in the Portfolio Gallery block when its source is set to Portfolio Gallery.', 'cozy-addons' ); ?>
						</p>
					</div>
					<div class="toggle-switcher-wrap">
						<?php
						$checked = get_option( 'ca-cpt--portfolio-gallery-templates' );
						?>
						<input type="checkbox"
							class="ca__block-cpt <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>"
							name="portfolio-gallery-templates" id="ca--portfolio-gallery-cpt"
							<?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
						<?php
						$classes   = array();
						$classes[] = 'toggle-switcher';
						$classes[] = ! cozy_addons_premium_access() ? 'has-tooltip is-disabled' : '';
						?>
						<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"></span>
						<?php if ( ! cozy_addons_premium_access() ) { ?>
						<div class="cozy-block-upsell-tooltip">
							<a
								href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?></a>
							<?php esc_html_e( ' to use this feature!', 'cozy-addons' ); ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="accordion-body">
				<?php
				$portfolio_gallery_cpt_config = cozy_addons_get_cpt_config_option( 'portfolio-gallery' );
				?>
				<p>
					<label for="portfolio-gallery-slug"><?php esc_html_e( 'Post type slug', 'cozy-addons' ); ?></label>
					<input id="portfolio-gallery-slug" class="cpt-field" type="text" name="ca-portfolio-gallery-slug" data-cpt="portfolio-gallery" data-type="slug" value="<?php echo esc_attr( $portfolio_gallery_cpt_config['slug'] ); ?>" data-previous-value="<?php echo esc_attr( $portfolio_gallery_cpt_config['slug'] ); ?>" />
				</p>

				<br />

				<p>
					<label for="portfolio-gallery-cat-slug"><?php esc_html_e( 'Category slug', 'cozy-addons' ); ?></label>
					<input id="portfolio-gallery-cat-slug" class="cpt-field" type="text" name="ca-portfolio-gallery-cat-slug" data-cpt="portfolio-gallery" data-type="taxonomy.category.slug" value="<?php echo esc_attr( $portfolio_gallery_cpt_config['taxonomy']['category']['slug'] ); ?>" data-previous-value="<?php echo esc_attr( $portfolio_gallery_cpt_config['taxonomy']['category']['slug'] ); ?>" />
				</p>

				<div class="ca-buttons">
					<div class="ca-btn btn-primary save-button">
						<a><?php esc_html_e( 'Save Changes', 'cozy-addons' ); ?></a>
					</div>
					<div class="ca-btn btn-secondary cancel-button">
						<a><?php esc_html_e( 'Cancel', 'cozy-addons' ); ?></a>
					</div>
				</div>

				<div class="ca-spacer sm"></div>
				<hr />
				<div class="ca-spacer sm"></div>

				<div class="flex-layout">
					<div>
						<p>
							<?php echo esc_html__( 'Current permalink structure: ', 'cozy-addons' ) . esc_html( get_option( 'permalink_structure' ) ); ?>
							| <a href="<?php echo esc_url( admin_url( 'options-permalink.php' ) ); ?>"><?php esc_html_e( 'Update structure', 'cozy-addons' ); ?></a>
						</p>
		
						<p>
							<?php esc_html_e( '*Permalinks are flushed automatically after saving.', 'cozy-addons' ); ?>
						</p>
					</div>
					<div>
						<button class="ca-btn btn-primary-accent">
							<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ca_portfolio_gallery' ) ); ?>"><?php esc_html_e( 'Add Portfolio Gallery', 'cozy-addons' ); ?></a>
						</button>
						<button class="ca-btn btn-primary cpt-seeder" data-post-type="ca_portfolio_gallery">
							<a><?php esc_html_e( 'Generate Dummy Data', 'cozy-addons' ); ?></a>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="cpt accordion-item">
			<?php
			$classes   = array();
			$classes[] = 'accordion-header';
			$classes[] = ! cozy_addons_premium_access() ? 'not-allowed' : '';
			?>
			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<i class="chevron">
					<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
							fill="currentColor" />
					</svg>
				</i>
				<div class="flex-layout">
					<div>
						<h3 class="setting-title has-icon">
							<?php esc_html_e( 'FAQ Templates', 'cozy-addons' ); ?>
							<i class="icon-wrapper">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M6 19L18 19" stroke="currentColor" stroke-width="1" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M16.5585 16H7.44152C6.58066 16 5.81638 15.4491 5.54415 14.6325L3.70711 9.12132C3.44617 8.3385 4.26195 7.63098 5 8L5.71067 8.35533C6.48064 8.74032 7.41059 8.58941 8.01931 7.98069L10.5858 5.41421C11.3668 4.63317 12.6332 4.63316 13.4142 5.41421L15.9807 7.98069C16.5894 8.58941 17.5194 8.74032 18.2893 8.35533L19 8C19.7381 7.63098 20.5538 8.3385 20.2929 9.12132L18.4558 14.6325C18.1836 15.4491 17.4193 16 16.5585 16Z"
										stroke="currentColor" stroke-width="1" stroke-linejoin="round" />
								</svg>
							</i>
						</h3>
						<p><?php esc_html_e( 'Templates created here will appear in the Accordion block when its source is set to FAQ post type.', 'cozy-addons' ); ?>
						</p>
					</div>
					<div class="toggle-switcher-wrap">
						<?php
						$checked = get_option( 'ca-cpt--faq-templates' );
						?>
						<input type="checkbox"
							class="ca__block-cpt <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>"
							name="faq-templates" id="ca--faq-cpt"
							<?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
						<?php
						$classes   = array();
						$classes[] = 'toggle-switcher';
						$classes[] = ! cozy_addons_premium_access() ? 'has-tooltip is-disabled' : '';
						?>
						<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"></span>
						<?php if ( ! cozy_addons_premium_access() ) { ?>
						<div class="cozy-block-upsell-tooltip">
							<a
								href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?></a>
							<?php esc_html_e( ' to use this feature!', 'cozy-addons' ); ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="accordion-body">
				<?php
				$faq_cpt_config = cozy_addons_get_cpt_config_option( 'faq' );
				?>
				<p>
					<label for="faq-slug"><?php esc_html_e( 'Post type slug', 'cozy-addons' ); ?></label>
					<input id="faq-slug" class="cpt-field" type="text" name="ca-faq-slug" data-cpt="faq" data-type="slug" value="<?php echo esc_attr( $faq_cpt_config['slug'] ); ?>" data-previous-value="<?php echo esc_attr( $faq_cpt_config['slug'] ); ?>" />
				</p>

				<br />

				<p>
					<label for="faq-cat-slug"><?php esc_html_e( 'Category slug', 'cozy-addons' ); ?></label>
					<input id="faq-cat-slug" class="cpt-field" type="text" name="ca-faq-cat-slug" data-cpt="faq" data-type="taxonomy.category.slug" value="<?php echo esc_attr( $faq_cpt_config['taxonomy']['category']['slug'] ); ?>" data-previous-value="<?php echo esc_attr( $faq_cpt_config['taxonomy']['category']['slug'] ); ?>" />
				</p>

				<br />

				<!-- <p>
					<label for="faq-tag-slug"><?php // esc_html_e( 'Tag slug', 'cozy-addons' ); ?></label>
					<input id="faq-tag-slug" class="cpt-field" type="text" name="ca-faq-tag-slug" data-cpt="faq" data-type="taxonomy.tags.slug" value="<?php // echo esc_attr( $faq_cpt_config['taxonomy']['tags']['slug'] ); ?>" data-previous-value="<?php // echo esc_attr( $faq_cpt_config['taxonomy']['tags']['slug'] ); ?>" />
				</p> -->

				<div class="ca-buttons">
					<div class="ca-btn btn-primary save-button">
						<a><?php esc_html_e( 'Save Changes', 'cozy-addons' ); ?></a>
					</div>
					<div class="ca-btn btn-secondary cancel-button">
						<a><?php esc_html_e( 'Cancel', 'cozy-addons' ); ?></a>
					</div>
				</div>

				<div class="ca-spacer sm"></div>
				<hr />
				<div class="ca-spacer sm"></div>

				<div class="flex-layout">
					<div>
						<p>
							<?php echo esc_html__( 'Current permalink structure: ', 'cozy-addons' ) . esc_html( get_option( 'permalink_structure' ) ); ?>
							| <a href="<?php echo esc_url( admin_url( 'options-permalink.php' ) ); ?>"><?php esc_html_e( 'Update structure', 'cozy-addons' ); ?></a>
						</p>
		
						<p>
							<?php esc_html_e( '*Permalinks are flushed automatically after saving.', 'cozy-addons' ); ?>
						</p>
					</div>
					<div>
						<button class="ca-btn btn-primary-accent">
							<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ca_faq' ) ); ?>"><?php esc_html_e( 'Add FAQ', 'cozy-addons' ); ?></a>
						</button>
						<button class="ca-btn btn-primary cpt-seeder" data-post-type="ca_faq">
							<a><?php esc_html_e( 'Generate Dummy Data', 'cozy-addons' ); ?></a>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="cpt accordion-item">
			<?php
			$classes   = array();
			$classes[] = 'accordion-header';
			$classes[] = ! cozy_addons_premium_access() ? 'not-allowed' : '';
			?>
			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<i class="chevron">
					<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M16.5706 1.74303L14.8238 6.47969e-07L8.28527 6.5336L1.74674 7.63524e-08L0 1.74797L6.53854 8.27663C7.00185 8.7398 7.63015 9 8.28527 9C8.9404 9 9.5687 8.7398 10.032 8.27663L16.5706 1.74303Z"
							fill="currentColor" />
					</svg>
				</i>
				<div class="flex-layout">
					<div>
						<h3 class="setting-title has-icon">
							<?php esc_html_e( 'Testimonial Templates', 'cozy-addons' ); ?>
							<i class="icon-wrapper">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M6 19L18 19" stroke="currentColor" stroke-width="1" stroke-linecap="round"
										stroke-linejoin="round" />
									<path
										d="M16.5585 16H7.44152C6.58066 16 5.81638 15.4491 5.54415 14.6325L3.70711 9.12132C3.44617 8.3385 4.26195 7.63098 5 8L5.71067 8.35533C6.48064 8.74032 7.41059 8.58941 8.01931 7.98069L10.5858 5.41421C11.3668 4.63317 12.6332 4.63316 13.4142 5.41421L15.9807 7.98069C16.5894 8.58941 17.5194 8.74032 18.2893 8.35533L19 8C19.7381 7.63098 20.5538 8.3385 20.2929 9.12132L18.4558 14.6325C18.1836 15.4491 17.4193 16 16.5585 16Z"
										stroke="currentColor" stroke-width="1" stroke-linejoin="round" />
								</svg>
							</i>
						</h3>
						<p><?php esc_html_e( 'Templates created here will appear in the Testimonials block when its source is set to Testimonial post type.', 'cozy-addons' ); ?>
						</p>
					</div>
					<div class="toggle-switcher-wrap">
						<?php
						$checked = get_option( 'ca-cpt--testimonial-templates' );
						?>
						<input type="checkbox"
							class="ca__block-cpt <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>"
							name="testimonial-templates" id="ca--testimonial-cpt"
							<?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
						<?php
						$classes   = array();
						$classes[] = 'toggle-switcher';
						$classes[] = ! cozy_addons_premium_access() ? 'has-tooltip is-disabled' : '';
						?>
						<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"></span>
						<?php if ( ! cozy_addons_premium_access() ) { ?>
						<div class="cozy-block-upsell-tooltip">
							<a
								href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( 'Upgrade to Pro', 'cozy-addons' ); ?></a>
							<?php esc_html_e( ' to use this feature!', 'cozy-addons' ); ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="accordion-body">
				<?php
				$testimonial_cpt_config = cozy_addons_get_cpt_config_option( 'testimonial' );
				?>
				<p>
					<label for="faq-slug"><?php esc_html_e( 'Post type slug', 'cozy-addons' ); ?></label>
					<input id="faq-slug" class="cpt-field" type="text" name="ca-testimonial-slug" data-cpt="testimonial" data-type="slug" value="<?php echo esc_attr( $testimonial_cpt_config['slug'] ); ?>" data-previous-value="<?php echo esc_attr( $testimonial_cpt_config['slug'] ); ?>" />
				</p>

				<br />

				<p>
					<label for="testimonial-cat-slug"><?php esc_html_e( 'Category slug', 'cozy-addons' ); ?></label>
					<input id="testimonial-cat-slug" class="cpt-field" type="text" name="ca-testimonial-cat-slug" data-cpt="testimonial" data-type="taxonomy.category.slug" value="<?php echo esc_attr( $testimonial_cpt_config['taxonomy']['category']['slug'] ); ?>" data-previous-value="<?php echo esc_attr( $testimonial_cpt_config['taxonomy']['category']['slug'] ); ?>" />
				</p>

				<br />

				<!-- <p>
					<label for="testimonial-tag-slug"><?php // esc_html_e( 'Tag slug', 'cozy-addons' ); ?></label>
					<input id="testimonial-tag-slug" class="cpt-field" type="text" name="ca-testimonial-tag-slug" data-cpt="testimonial" data-type="taxonomy.tags.slug" value="<?php // echo esc_attr( $testimonial_cpt_config['taxonomy']['tags']['slug'] ); ?>" data-previous-value="<?php // echo esc_attr( $testimonial_cpt_config['taxonomy']['tags']['slug'] ); ?>" />
				</p> -->

				<div class="ca-buttons">
					<div class="ca-btn btn-primary save-button">
						<a><?php esc_html_e( 'Save Changes', 'cozy-addons' ); ?></a>
					</div>
					<div class="ca-btn btn-secondary cancel-button">
						<a><?php esc_html_e( 'Cancel', 'cozy-addons' ); ?></a>
					</div>
				</div>

				<div class="ca-spacer sm"></div>
				<hr />
				<div class="ca-spacer sm"></div>

				<div class="flex-layout">
					<div>
						<p>
							<?php echo esc_html__( 'Current permalink structure: ', 'cozy-addons' ) . esc_html( get_option( 'permalink_structure' ) ); ?>
							| <a href="<?php echo esc_url( admin_url( 'options-permalink.php' ) ); ?>"><?php esc_html_e( 'Update structure', 'cozy-addons' ); ?></a>
						</p>
		
						<p>
							<?php esc_html_e( '*Permalinks are flushed automatically after saving.', 'cozy-addons' ); ?>
						</p>
					</div>
					<div>
						<button class="ca-btn btn-primary-accent">
							<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ca_testimonial' ) ); ?>"><?php esc_html_e( 'Add Testimonial', 'cozy-addons' ); ?></a>
						</button>
						<button class="ca-btn btn-primary cpt-seeder" data-post-type="ca_testimonial">
							<a><?php esc_html_e( 'Generate Dummy Data', 'cozy-addons' ); ?></a>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="utility-functions" class="setting-tab-content boxed-layout grid-layout cols-2">
		<div class="util-function flex-layout">
			<div>
				<h3 class="setting-title"><?php esc_html_e( 'Cozy Animation', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( "'Cozy Animation' attribute in core WordPress blocks (e.g: Group, Columns, ...).", 'cozy-addons' ); ?>
				</p>
			</div>
			<div class="toggle-switcher-wrap">
				<?php
				$checked = get_option( 'ca--utility--animation' );
				?>
				<input type="checkbox" class="ca__utility-function" name="animation"
					id="cozy-addons--utility--animation"
					<?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="toggle-switcher"></span>
			</div>
		</div>

		<div class="util-function flex-layout">
			<div>
				<h3 class="setting-title"><?php esc_html_e( 'Advanced Styling Effects', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( '\'Cozy Advanced Effects\', \'Cozy Responsive Visibility\' and \'Google Fonts\' attribute in core WordPress blocks (e.g: Group, Columns, ...).', 'cozy-addons' ); ?>
				</p>
			</div>
			<div class="toggle-switcher-wrap">
				<?php
				$checked = get_option( 'ca--utility--styles' );
				?>
				<input type="checkbox" class="ca__utility-function" name="styles" id="cozy-addons--utility--styles"
					<?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
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
				<input type="checkbox" class="ca__utility-function" name="post-terms"
					id="cozy-addons--utility--post-terms"
					<?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="toggle-switcher"></span>
			</div>
		</div>
	</div>

	<div id="design-kit" class="setting-tab-content boxed-layout grid-layout cols-2">
		<div class="design-lib flex-layout">
			<div>
				<h3 class="setting-title"><?php esc_html_e( 'Design Kit', 'cozy-addons' ); ?></h3>
				<p><?php esc_html_e( 'Lightweight Patterns & Homepage Templates to make website building easier.', 'cozy-addons' ); ?>
				</p>
			</div>
			<div class="toggle-switcher-wrap">
				<?php
				$checked = get_option( 'ca--utility--pattern-library' );
				?>
				<input type="checkbox" class="ca__utility-function" name="pattern-library"
					id="cozy-addons--utility--pattern-library"
					<?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
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

			<span
				class="rollback-label"><strong><?php esc_html_e( 'Rollback Version ', 'cozy-addons' ); ?></strong></span>
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
			<a id="cozy-addons-rollback-btn" class="button"
				href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Perform Rollback', 'cozy-addons' ); ?></a>
		</div>
	</div>
</div>