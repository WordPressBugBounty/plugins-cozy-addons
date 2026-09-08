<?php

namespace CozyAddons\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BlockRender {

	/**
	 * Holds the singleton instance of the class.
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * Returns the singleton instance of the class.
	 *
	 * Creates a new instance if one doesn't already exist.
	 * Ensures only one instance of this class is used throughout the plugin.
	 *
	 * @return self
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * Initializes admin functionality by loading necessary admin files.
	 *
	 * @access private
	 */
	private function __construct() {}

	/**
	 * Renders the portfolio gallery block output.
	 *
	 * @param array $attributes Block attributes.
	 * @param array $portfolio_gallery Portfolio gallery data.
	 *
	 * @return string Rendered HTML output.
	 */
	public static function portfolio_gallery_render( $attributes, $portfolio_gallery ) {
		$overlay_content = array(
			'position' => isset( $attributes['overlayContent']['position'] ) ? str_replace( ' ', '-', $attributes['overlayContent']['position'] ) : 'bottom-left',
		);

		$gallery = array(
			'icon' => array(
				'path'    => isset( $attributes['galleryOptions']['icon']['path'] ) ? $attributes['galleryOptions']['icon']['path'] : '',
				'viewBox' => array(
					'vx' => isset( $attributes['galleryOptions']['icon']['viewBox']['vx'] ) ? $attributes['galleryOptions']['icon']['viewBox']['vx'] : '',
					'vy' => isset( $attributes['galleryOptions']['icon']['viewBox']['vy'] ) ? $attributes['galleryOptions']['icon']['viewBox']['vy'] : '',
					'vw' => isset( $attributes['galleryOptions']['icon']['viewBox']['vw'] ) ? $attributes['galleryOptions']['icon']['viewBox']['vw'] : '',
					'vh' => isset( $attributes['galleryOptions']['icon']['viewBox']['vh'] ) ? $attributes['galleryOptions']['icon']['viewBox']['vh'] : '',
				),
			),
		);

		$allowed_tags = array(
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'p',
		);

		ob_start();

		foreach ( $portfolio_gallery as $key => $portfolio ) {
			$portfolio_id = $portfolio->ID;

			$img_url = get_the_post_thumbnail_url( $portfolio_id );

			$post_title = $portfolio->post_title;

			$post_url = get_permalink( $portfolio_id );

			$post_excerpt = $portfolio->post_excerpt;

			$post_content = $portfolio->post_content;

			$classes   = array();
			$classes[] = 'cozy-portfolio';
			$classes[] = 'cozy-block-' . $attributes['layout'];
			$classes[] = 'post-ID__' . $portfolio_id;
			$classes[] = 'layout-type-' . $attributes['layoutType'];
			$classes[] = 'carousel' === $attributes['layout'] ? 'swiper-slide' : '';
			$classes[] = 'gallery' !== $attributes['layoutType'] && isset( $attributes['popup']['enabled'] ) && filter_var( $attributes['popup']['enabled'], FILTER_VALIDATE_BOOLEAN ) ? 'has-modal' : '';

			$portfolio_taxonomy = get_the_terms( $portfolio_id, 'ca_portfolio_gallery_category' );
			$portfolio_tax_ids  = array();
			if ( is_array( $portfolio_taxonomy ) || ! is_wp_error( $portfolio_taxonomy ) ) {
				$portfolio_tax_ids = wp_list_pluck( $portfolio_taxonomy, 'term_id' );
			}

			?>
			<li class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" data-post-id="<?php echo esc_attr( $portfolio_id ); ?>" data-post-taxonomies="<?php echo wp_json_encode( $portfolio_tax_ids ); ?>">
				<?php
				if ( ! empty( $img_url ) ) {
					$classes   = array();
					$classes[] = 'cozy-portfolio__featured-image';
					$classes[] = isset( $attributes['imageHoverEffect'] ) && filter_var( $attributes['imageHoverEffect'], FILTER_VALIDATE_BOOLEAN ) ? 'has-hover-effect' : '';
					?>
					<figure class="<?php echo esc_html( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
						<?php
						if ( 'gallery' !== $attributes['layoutType'] && ( ! isset( $attributes['popup']['enabled'] ) || ! $attributes['popup']['enabled'] ) && isset( $attributes['featuredImage']['link']['enabled'] ) && filter_var( $attributes['featuredImage']['link']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_url ) ) {
							$new_tab   = isset( $attributes['featuredImage']['link']['newTab'] ) && filter_var( $attributes['featuredImage']['link']['newTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
							$no_follow = isset( $attributes['featuredImage']['link']['noFollow'] ) && filter_var( $attributes['featuredImage']['link']['noFollow'], FILTER_VALIDATE_BOOLEAN ) ? 'nofollow' : '';

							?>
							<a href="<?php echo esc_url( $post_url ); ?>" target="<?php echo esc_attr( $new_tab ); ?>" rel="<?php echo esc_attr( $no_follow ); ?>">
							<?php
						}
						?>
							<div class="image__overlay"></div>
							<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $post_title ); ?>" />
							<?php
							if ( 'gallery' !== $attributes['layoutType'] && ( ! isset( $attributes['popup']['enabled'] ) || ! $attributes['popup']['enabled'] ) && isset( $attributes['featuredImage']['link']['enabled'] ) && filter_var( $attributes['featuredImage']['link']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_url ) ) {
								?>
							</a>
								<?php
							}

							if ( 'overlay' === $attributes['layoutType'] || 'gallery' === $attributes['layoutType'] ) {
								$classes   = array();
								$classes[] = 'portfolio__content';
								$classes[] = 'overlay' === $attributes['layoutType'] ? 'position-' . $overlay_content['position'] : '';
								?>
							<div class="<?php echo esc_html( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
								<?php
								if ( 'gallery' !== $attributes['layoutType'] && isset( $attributes['enableOptions']['title'] ) && filter_var( $attributes['enableOptions']['title'], FILTER_VALIDATE_BOOLEAN ) ) {
									$title_tag     = isset( $attributes['postTitle']['tag'] ) && in_array( $attributes['postTitle']['tag'], $allowed_tags, true ) ? $attributes['postTitle']['tag'] : 'p';
									$title_content = '';
									if ( ( 'gallery' !== $attributes['layoutType'] || ! isset( $attributes['popup']['enabled'] ) || ! $attributes['popup']['enabled'] ) && isset( $attributes['postTitle']['link']['enabled'] ) && filter_var( $attributes['postTitle']['link']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_url ) ) {
										$new_tab        = isset( $attributes['postTitle']['link']['newTab'] ) && filter_var( $attributes['postTitle']['link']['newTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
										$rel            = isset( $attributes['postTitle']['link']['noFollow'] ) && filter_var( $attributes['postTitle']['link']['noFollow'], FILTER_VALIDATE_BOOLEAN ) ? 'nofollow' : '';
										$title_content .= '<a href="' . esc_url( $post_url ) . '" target="' . esc_attr( $new_tab ) . '" rel="' . esc_attr( $rel ) . '">';
										$title_content .= esc_html( $post_title );
										$title_content .= '</a>';
									} else {
										$title_content .= esc_html( $post_title );
									}

									printf(
										'<%1$s class="cozy-portfolio__title">%2$s</%1$s>',
										esc_attr( $title_tag ),
										wp_kses(
											$title_content,
											array(
												'a' => array(
													'href' => array(),
													'target' => array(),
													'rel'  => array(),
												),
											)
										)
									);
								}

								if ( 'overlay' === $attributes['layoutType'] ) {
									if ( isset( $attributes['enableOptions']['excerpt'] ) && filter_var( $attributes['enableOptions']['excerpt'], FILTER_VALIDATE_BOOLEAN ) ) {
										?>
										<div class="cozy-portfolio__excerpt">
											<?php
											if ( isset( $attributes['enableOptions']['excerptType'] ) && 'default' === $attributes['enableOptions']['excerptType'] ) {
												echo esc_html( $post_excerpt );
											}
											if ( isset( $attributes['enableOptions']['excerptType'] ) && 'custom' === $attributes['enableOptions']['excerptType'] ) {
												$excerpt_count = isset( $attributes['enableOptions']['excerptCount'] ) ? $attributes['enableOptions']['excerptCount'] : '';
												echo esc_html( cozy_create_excerpt( $post_content, $excerpt_count ) );
											}
											?>
										</div>
										<?php
									}

									if ( filter_var( $attributes['enableOptions']['button'], FILTER_VALIDATE_BOOLEAN ) ) {
										$btn_label = isset( $attributes['overlayContent']['button']['label'] ) ? sanitize_text_field( $attributes['overlayContent']['button']['label'] ) : '';
										?>
										<span class='cozy-portfolio__read-more-btn'>
											<?php
											if ( 'gallery' !== $attributes['layoutType'] && ( ! isset( $attributes['popup']['enabled'] ) || ! filter_var( $attributes['popup']['enabled'] ) ) && isset( $attributes['overlayContent']['button']['link']['enabled'] ) && filter_var( $attributes['overlayContent']['button']['link']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_url ) ) {
												$new_tab   = isset( $attributes['overlayContent']['button']['link']['newTab'] ) && filter_var( $attributes['overlayContent']['button']['link']['newTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
												$no_follow = isset( $attributes['overlayContent']['button']['link']['noFollow'] ) && filter_var( $attributes['overlayContent']['button']['link']['noFollow'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
												?>
												<a href="<?php echo esc_url( $post_url ); ?>" target="<?php echo esc_attr( $new_tab ); ?>" rel="<?php echo esc_attr( $no_follow ); ?>">
												<?php
											}

											echo esc_html( $btn_label );

											if ( 'gallery' !== $attributes['layoutType'] && ( ! isset( $attributes['popup']['enabled'] ) || ! filter_var( $attributes['popup']['enabled'] ) ) && isset( $attributes['overlayContent']['button']['link']['enabled'] ) && filter_var( $attributes['overlayContent']['button']['link']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_url ) ) {
												?>
												</a>
												<?php
											}
											?>
										</span>
										<?php
									}
								}

								if ( 'gallery' === $attributes['layoutType'] && isset( $attributes['enableOptions']['icon'] ) && filter_var( $attributes['enableOptions']['icon'], FILTER_VALIDATE_BOOLEAN ) ) {
									?>
									<i class="gallery__icon">
										<svg
											viewBox="<?php echo esc_attr( implode( ' ', array_map( 'intval', array_values( $gallery['icon']['viewBox'] ) ) ) ); ?>"
											fill="currentColor"
											xmlns="http://www.w3.org/2000/svg"
											aria-hidden="true">
											<path d="<?php echo esc_attr( $gallery['icon']['path'] ); ?>" />
										</svg>
									</i>
									<?php
								}
								?>
							</div>
								<?php
							}
							?>
					</figure>
					<?php
				}

				if ( 'default' === $attributes['layoutType'] ) {
					?>
					<div class="portfolio__content">
						<?php
						if ( isset( $attributes['enableOptions']['title'] ) && filter_var( $attributes['enableOptions']['title'], FILTER_VALIDATE_BOOLEAN ) && 'gallery' !== $attributes['layoutType'] ) {
							$title_tag     = isset( $attributes['postTitle']['tag'] ) && in_array( $attributes['postTitle']['tag'], $allowed_tags, true ) ? $attributes['postTitle']['tag'] : 'p';
							$title_content = '';
							if ( ( ! isset( $attributes['popup']['enabled'] ) || ! $attributes['popup']['enabled'] ) && isset( $attributes['postTitle']['link']['enabled'] ) && filter_var( $attributes['postTitle']['link']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_url ) ) {
								$new_tab        = isset( $attributes['postTitle']['link']['newTab'] ) && filter_var( $attributes['postTitle']['link']['newTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
								$rel            = isset( $attributes['postTitle']['link']['noFollow'] ) && filter_var( $attributes['postTitle']['link']['noFollow'], FILTER_VALIDATE_BOOLEAN ) ? 'nofollow' : '';
								$title_content .= '<a href="' . esc_url( $post_url ) . '" target="' . esc_attr( $new_tab ) . '" rel="' . esc_attr( $rel ) . '">';
								$title_content .= esc_html( $post_title );
								$title_content .= '</a>';
							} else {
								$title_content .= esc_html( $post_title );
							}

							printf(
								'<%1$s class="cozy-portfolio__title">%2$s</%1$s>',
								esc_attr( $title_tag ),
								wp_kses(
									$title_content,
									array(
										'a' => array(
											'href'   => array(),
											'target' => array(),
											'rel'    => array(),
										),
									)
								)
							);
						}
						?>
					</div>
					<?php
				}

				/* Popup modal */
				if ( 'gallery' !== $attributes['layoutType'] && isset( $attributes['popup']['enabled'] ) && filter_var( $attributes['popup']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
					$portfolio_categories = get_the_terms( $portfolio_id, 'ca_portfolio_gallery_category' );
					$modal_excerpt_count  = isset( $attributes['popup']['enableOptions']['excerptCount'] ) ? $attributes['popup']['enableOptions']['excerptCount'] : '';

					$portfolio_cpt_year   = get_post_meta( $portfolio_id, 'ca_portfolio_gallery_project_year', true );
					$portfolio_cpt_client = get_post_meta( $portfolio_id, 'ca_portfolio_gallery_client', true );
					$portfolio_cpt_skills = get_post_meta( $portfolio_id, 'ca_portfolio_gallery_skills', true );
					$portfolio_cpt_url    = get_post_meta( $portfolio_id, 'ca_portfolio_gallery_url', true );

					?>
					<div class="cozy-portfolio__modal display__none">
						<div class="modal__overlay"></div>
						<div class="modal__body">
							<svg class="close__icon" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M4.99999 4.058L8.29999 0.758003L9.24266 1.70067L5.94266 5.00067L9.24266 8.30067L8.29932 9.24334L4.99932 5.94334L1.69999 9.24334L0.757324 8.3L4.05732 5L0.757324 1.7L1.69999 0.75867L4.99999 4.058Z" fill="currentColor" />
							</svg>

							<div class="modal__content">
								<div class="modal__wrap-1">
									<?php
									if ( ! empty( $img_url ) ) {
										?>
										<figure class="modal__featured-image">
											<a href="<?php echo esc_url( $post_url ); ?>" target="_blank" rel="nofollow">
												<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $post_title ); ?>" />
											</a>
										</figure>
										<?php
									}

									if ( isset( $attributes['popup']['enableOptions']['cat'] ) && filter_var( $attributes['popup']['enableOptions']['cat'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $portfolio_categories ) ) {
										?>
										<ul class="modal__portfolio-categories">
											<?php
											foreach ( $portfolio_categories as $category ) {
												?>
												<li class="modal__portfolio-category" data-slug="<?php echo esc_attr( $category->slug ); ?>" data-term-id="<?php echo esc_attr( $category->term_id ); ?>"><?php echo esc_html( $category->name ); ?></li>
												<?php
											}
											?>
										</ul>
										<?php
									}

									$title_tag     = isset( $attributes['postTitle']['tag'] ) && in_array( $attributes['postTitle']['tag'], $allowed_tags, true ) ? $attributes['postTitle']['tag'] : 'p';
									$title_content = '';
									if ( isset( $attributes['postTitle']['link']['enabled'] ) && filter_var( $attributes['postTitle']['link']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_url ) ) {
										$new_tab        = isset( $attributes['postTitle']['link']['newTab'] ) && filter_var( $attributes['postTitle']['link']['newTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
										$rel            = isset( $attributes['postTitle']['link']['noFollow'] ) && filter_var( $attributes['postTitle']['link']['noFollow'], FILTER_VALIDATE_BOOLEAN ) ? 'nofollow' : '';
										$title_content .= '<a href="' . esc_url( $post_url ) . '" target="' . esc_attr( $new_tab ) . '" rel="' . esc_attr( $rel ) . '">';
										$title_content .= esc_html( $post_title );
										$title_content .= '</a>';
									} else {
										$title_content .= esc_html( $post_title );
									}

									printf(
										'<%1$s class="modal__post-title">%2$s</%1$s>',
										esc_attr( $title_tag ),
										wp_kses(
											$title_content,
											array(
												'a' => array(
													'href' => array(),
													'target' => array(),
													'rel'  => array(),
												),
											)
										)
									);

					if ( isset( $attributes['popup']['enableOptions']['excerpt'] ) && filter_var( $attributes['popup']['enableOptions']['excerpt'], FILTER_VALIDATE_BOOLEAN ) ) {
						?>
										<p class="modal__excerpt">
							<?php
							if ( isset( $attributes['popup']['enableOptions']['excerptType'] ) && filter_var( $attributes['popup']['enableOptions']['excerptType'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_excerpt ) ) {
								echo esc_html( $post_excerpt );
							} elseif ( ! empty( $post_content ) ) {
								echo esc_html( cozy_create_excerpt( $post_content, $modal_excerpt_count ) );
							}
							?>
										</p>
						<?php
					}
					?>
								</div>
								<div class="modal__wrap-2">
									<?php
									$title_tag     = isset( $attributes['postTitle']['tag'] ) && in_array( $attributes['postTitle']['tag'], $allowed_tags, true ) ? $attributes['postTitle']['tag'] : 'p';
									$title_content = '';
									if ( isset( $attributes['postTitle']['link']['enabled'] ) && filter_var( $attributes['postTitle']['link']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_url ) ) {
										$new_tab        = isset( $attributes['postTitle']['link']['newTab'] ) && filter_var( $attributes['postTitle']['link']['newTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
										$rel            = isset( $attributes['postTitle']['link']['noFollow'] ) && filter_var( $attributes['postTitle']['link']['noFollow'], FILTER_VALIDATE_BOOLEAN ) ? 'nofollow' : '';
										$title_content .= '<a href="' . esc_url( $post_url ) . '" target="' . esc_attr( $new_tab ) . '" rel="' . esc_attr( $rel ) . '">';
										$title_content .= esc_html( $post_title );
										$title_content .= '</a>';
									} else {
										$title_content .= esc_html( $post_title );
									}

									printf(
										'<%1$s class="modal__post-title">%2$s</%1$s>',
										esc_attr( $title_tag ),
										wp_kses(
											$title_content,
											array(
												'a' => array(
													'href' => array(),
													'target' => array(),
													'rel'  => array(),
												),
											)
										)
									);

									if ( isset( $attributes['popup']['enableOptions']['cpt'] ) && filter_var( $attributes['popup']['enableOptions']['cpt'], FILTER_VALIDATE_BOOLEAN ) ) {
										?>
										<div class="modal__portfolio-cpt-wrap">
											<?php
											if ( isset( $attributes['popup']['enableOptions']['cptYear'] ) && filter_var( $attributes['popup']['enableOptions']['cptYear'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $portfolio_cpt_year ) ) {
												$cpt_label = isset( $attributes['enableOptions']['yearLabel'] ) ? $attributes['enableOptions']['yearLabel'] : 'Project Year';
												?>
												<p class="modal__portfolio-cpt portfolio-cpt__year">
												<p class="cpt__title"><?php echo esc_html( $cpt_label ); ?></p>
												<p class="cpt__subtitle"><?php echo esc_html( $portfolio_cpt_year ); ?></p>
												</p>
												<?php
											}

											if ( isset( $attributes['popup']['enableOptions']['cptClient'] ) && filter_var( $attributes['popup']['enableOptions']['cptClient'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $portfolio_cpt_client ) ) {
												$cpt_label = isset( $attributes['enableOptions']['clientLabel'] ) ? $attributes['enableOptions']['clientLabel'] : 'Client';
												?>
												<p class="modal__portfolio-cpt portfolio-cpt__client">
												<p class="cpt__title"><?php echo esc_html( $cpt_label ); ?></p>
												<p class="cpt__subtitle"><?php echo esc_html( $portfolio_cpt_client ); ?></p>
												</p>
												<?php
											}

											if ( isset( $attributes['popup']['enableOptions']['cptSkills'] ) && filter_var( $attributes['popup']['enableOptions']['cptSkills'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $portfolio_cpt_skills ) ) {
												$cpt_label = isset( $attributes['enableOptions']['skillsLabel'] ) ? $attributes['enableOptions']['skillsLabel'] : 'Skills/Tech';
												?>
												<p class="modal__portfolio-cpt portfolio-cpt__skills">
												<p class="cpt__title"><?php echo esc_html( $cpt_label ); ?></p>
												<p class="cpt__subtitle"><?php echo esc_html( $portfolio_cpt_skills ); ?></p>
												</p>
												<?php
											}

											if ( isset( $attributes['popup']['enableOptions']['cptURL'] ) && filter_var( $attributes['popup']['enableOptions']['cptURL'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $portfolio_cpt_url ) && '#' != $portfolio_cpt_url ) {
												$cpt_label = isset( $attributes['enableOptions']['urlLabel'] ) ? $attributes['enableOptions']['urlLabel'] : 'Website';
												$new_tab   = isset( $attributes['popup']['enableOptions']['urlNewTab'] ) && filter_var( $attributes['popup']['enableOptions']['urlNewTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
												$no_follow = isset( $attributes['popup']['enableOptions']['urlNoFollow'] ) && filter_var( $attributes['popup']['enableOptions']['urlNoFollow'], FILTER_VALIDATE_BOOLEAN ) ? 'nofollow' : '';
												?>
												<p class="modal__portfolio-cpt portfolio-cpt__url">
													<a href="<?php echo esc_url( $portfolio_cpt_url ); ?>" target="<?php echo esc_attr( $new_tab ); ?>" rel="<?php echo esc_attr( $no_follow ); ?>"><?php echo esc_html( $cpt_label ); ?></a>
												</p>
												<?php
											}
											?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					<?php
				}
				?>
			</li>
			<?php
		}

		return ob_get_clean();
	}

	/**
	 * Renders the categorized post tabs block output.
	 *
	 * @param array  $attributes Block attributes.
	 * @param array  $post_data Post data.
	 * @param string $output Rendered HTML output (passed by reference).
	 *
	 * @return void
	 */
	public static function categorized_post_tabs_render( $attributes, $post_data, &$output ) {
		ob_start();
		$classes   = array();
		$classes[] = 'cozy-block-categorized-post-tabs__post-item';
		$classes[] = 'layout-' . $attributes['postOptions']['content']['layout'];
		$classes[] = $attributes['postBoxStyles']['hoverEffect'] ? 'has-hover-effect' : '';
		$classes[] = $attributes['postBoxStyles']['shadow']['enabled'] ? 'has-box-shadow' : '';
		$classes[] = $attributes['postBoxStyles']['shadowHover']['enabled'] ? 'has-hover-box-shadow' : '';
		$classes[] = $attributes['postOptions']['imageOverlay'] ? 'has-image-overlay' : '';
		?>
		<li class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<?php
			if ( $attributes['enableOptions']['postImage'] && ! empty( $post_data['post_image_url'] ) ) {
				$classes      = array();
				$classes[]    = 'post__image';
				$classes[]    = $attributes['postOptions']['image']['hoverEffect'] ? 'has-hover-effect' : '';
				$open_new_tab = isset( $attributes['enableOptions']['imgOpenNewTab'] ) && $attributes['enableOptions']['imgOpenNewTab'] ? '_blank' : '';
				?>
				<figure class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
					<?php
					if ( isset( $attributes['enableOptions']['imgLinkPost'] ) && $attributes['enableOptions']['imgLinkPost'] ) {
						?>
						<a href="<?php echo esc_url( $post_data['post_link'] ); ?>" target="<?php echo esc_attr( $open_new_tab ); ?>">
						<?php
					}
					?>
					<img src="<?php echo esc_url( $post_data['post_image_url'] ); ?>" />
					<?php
					if ( isset( $attributes['enableOptions']['imgLinkPost'] ) && $attributes['enableOptions']['imgLinkPost'] ) {
						?>
						</a>
						<?php
					}
					?>
				</figure>
				<?php
			}
			?>
			<div class="post__content-wrapper">
				<?php
				if ( $attributes['enableOptions']['postCategories'] && ! empty( $post_data['post_categories'] ) ) {
					?>
					<div class="post__categories">
						<?php
						foreach ( $post_data['post_categories'] as $cat_data ) {
							if ( isset( $attributes['enableOptions']['linkCat'] ) && $attributes['enableOptions']['linkCat'] ) {
								$classes      = array();
								$classes[]    = 'post__category-item';
								$open_new_tab = isset( $attributes['enableOptions']['catOpenNewTab'] ) && $attributes['enableOptions']['catOpenNewTab'] ? '_blank' : '';
								?>
								<a class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" href="<?php echo esc_url( $cat_data['link'] ); ?>" target="<?php echo esc_attr( $open_new_tab ); ?>">
								<?php
							} else {
								?>
								<p class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
								<?php
							}
							echo esc_html( $cat_data['name'] );
							if ( isset( $attributes['enableOptions']['linkCat'] ) && $attributes['enableOptions']['linkCat'] ) {
								?>
								</a>
								<?php
							} else {
								?>
								</p>
								<?php
							}
						}
						?>
					</div>
					<?php
				}

				$classes   = array();
				$classes[] = 'post__title';
				$classes[] = isset( $attributes['postOptions']['title']['className'] ) ? $attributes['postOptions']['title']['className'] : '';
				?>
				<h3 class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
					<?php
					$open_new_tab = isset( $attributes['enableOptions']['titleOpenNewTab'] ) && $attributes['enableOptions']['titleOpenNewTab'] ? '_blank' : '';
					if ( isset( $attributes['enableOptions']['titleLinkPost'] ) && $attributes['enableOptions']['titleLinkPost'] ) {
						?>
						<a href="<?php echo esc_url( $post_data['post_link'] ); ?>" target="<?php echo esc_attr( $open_new_tab ); ?>">
						<?php
					}
					echo esc_html( $post_data['post_title'] );
					if ( isset( $attributes['enableOptions']['titleLinkPost'] ) && $attributes['enableOptions']['titleLinkPost'] ) {
						?>
						</a>
						<?php
					}
					?>
				</h3>
				<?php
				if ( $attributes['enableOptions']['postAuthor'] || $attributes['enableOptions']['postComments'] || $attributes['enableOptions']['postDate'] ) {
					$has_meta_link = isset( $attributes['enableOptions']['linkPostMeta'] ) && $attributes['enableOptions']['linkPostMeta'] ? true : false;
					$open_new_tab  = isset( $attributes['enableOptions']['linkPostMeta'], $attributes['enableOptions']['postMetaOpenNewTab'] ) && $attributes['enableOptions']['linkPostMeta'] && $attributes['enableOptions']['postMetaOpenNewTab'] ? '_blank' : '';
					$show_icon     = isset( $attributes['postMeta']['enableIcon'] ) && $attributes['postMeta']['enableIcon'] ? true : false;
					?>
					<div class="post__meta">
					<?php
					if ( $attributes['enableOptions']['postAuthor'] ) {
						$classes   = array();
						$classes[] = 'post__author';
						$classes[] = 'display-flex';
						if ( $has_meta_link ) {
							?>
							<a class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" href="<?php echo esc_url( $post_data['post_author_url'] ); ?>" target="<?php echo esc_attr( $open_new_tab ); ?>">
							<?php
						} else {
							?>
							<p class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
							<?php
						}

						if ( $show_icon ) {
							?>
							<svg width="<?php echo esc_attr( $attributes['postMeta']['font']['size'] ); ?>" height="<?php echo esc_attr( $attributes['postMeta']['font']['size'] ); ?>" xmlns="http://www.w3.org/2000/svg"	aria-hidden="true" viewBox="0 0 12 15">
								<path d="M11.2972 14.6667H0.630493V13.3333C0.630493 12.4493 0.981683 11.6014 1.6068 10.9763C2.23193 10.3512 3.07977 10 3.96383 10H7.96383C8.84788 10 9.69573 10.3512 10.3208 10.9763C10.946 11.6014 11.2972 12.4493 11.2972 13.3333V14.6667ZM5.96383 8.66667C5.43854 8.66667 4.9184 8.5632 4.43309 8.36218C3.94779 8.16117 3.50683 7.86653 3.1354 7.49509C2.76396 7.12366 2.46933 6.6827 2.26831 6.1974C2.06729 5.7121 1.96383 5.19195 1.96383 4.66667C1.96383 4.14138 2.06729 3.62124 2.26831 3.13593C2.46933 2.65063 2.76396 2.20967 3.1354 1.83824C3.50683 1.4668 3.94779 1.17217 4.43309 0.971148C4.9184 0.770129 5.43854 0.666666 5.96383 0.666666C7.02469 0.666666 8.04211 1.08809 8.79225 1.83824C9.5424 2.58838 9.96383 3.6058 9.96383 4.66667C9.96383 5.72753 9.5424 6.74495 8.79225 7.49509C8.04211 8.24524 7.02469 8.66667 5.96383 8.66667Z"  />
							</svg>
							<?php
						}

						?>
						<span><?php echo esc_html( $post_data['post_author_name'] ); ?></span>
						<?php

						if ( $has_meta_link ) {
							?>
							</a>
							<?php
						} else {
							?>
							</p>
							<?php
						}
					}

					if ( $attributes['enableOptions']['postComments'] && intval( $post_data['comment_count'] ) > 0 ) {
						$classes   = array();
						$classes[] = 'post__comments';
						$classes[] = 'display-flex';
						if ( $has_meta_link ) {
							?>
							<a class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" href="<?php echo esc_url( $post_data['comment_link'] ); ?>" target="<?php echo esc_attr( $open_new_tab ); ?>">
							<?php
						} else {
							?>
							<p class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
							<?php
						}

						if ( $show_icon ) {
							?>
							<svg width="<?php echo esc_attr( $attributes['postMeta']['font']['size'] ); ?>" height="<?php echo esc_attr( $attributes['postMeta']['font']['size'] ); ?>" xmlns="http://www.w3.org/2000/svg"	aria-hidden="true" viewBox="0 0 25 20">
								<path d="M18.0556 6.94444C18.0556 3.10764 14.0148 0 9.02778 0C4.0408 0 0 3.10764 0 6.94444C0 8.43316 0.611979 9.80469 1.64931 10.9375C1.06771 12.2483 0.108507 13.2899 0.0954861 13.3029C0 13.4028 -0.0260417 13.5503 0.0303819 13.6806C0.0868056 13.8108 0.208333 13.8889 0.347222 13.8889C1.93576 13.8889 3.25087 13.355 4.19705 12.8038C5.59462 13.4852 7.24826 13.8889 9.02778 13.8889C14.0148 13.8889 18.0556 10.7812 18.0556 6.94444ZM23.3507 16.4931C24.388 15.3646 25 13.9887 25 12.5C25 9.59635 22.678 7.10937 19.388 6.07205C19.4271 6.35851 19.4444 6.6493 19.4444 6.94444C19.4444 11.5408 14.77 15.2778 9.02778 15.2778C8.55903 15.2778 8.1033 15.2431 7.65191 15.1953C9.0191 17.691 12.2309 19.4444 15.9722 19.4444C17.7517 19.4444 19.4054 19.0451 20.8029 18.3594C21.7491 18.9106 23.0642 19.4444 24.6528 19.4444C24.7917 19.4444 24.9175 19.362 24.9696 19.2361C25.026 19.1102 25 18.9627 24.9045 18.8585C24.8915 18.8455 23.9323 17.8082 23.3507 16.4931Z" />
							</svg>
							<?php
						}

						?>
						<span><?php echo esc_html( $post_data['comment_count'] ); ?></span>
						<?php

						if ( $has_meta_link ) {
							?>
							</a>
							<?php
						} else {
							?>
							</p>
							<?php
						}
					}

					if ( $attributes['enableOptions']['postDate'] ) {
						$classes   = array();
						$classes[] = 'post__date';
						$classes[] = 'display-flex';
						if ( $has_meta_link ) {
							?>
							<a class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" href="<?php echo esc_url( $post_data['post_link'] ); ?>" target="<?php echo esc_attr( $open_new_tab ); ?>">
							<?php
						} else {
							?>
							<p class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
							<?php
						}

						if ( $show_icon ) {
							?>
							<svg width="<?php echo esc_attr( $attributes['postMeta']['font']['size'] ); ?>" height="<?php echo esc_attr( $attributes['postMeta']['font']['size'] ); ?>" xmlns="http://www.w3.org/2000/svg"	aria-hidden="true" viewBox="0 0 16 18">
								<path d="M7.66699 10.6666C7.43088 10.6666 7.23296 10.5868 7.07324 10.427C6.91352 10.2673 6.83366 10.0694 6.83366 9.83329C6.83366 9.59718 6.91352 9.39927 7.07324 9.23954C7.23296 9.07982 7.43088 8.99996 7.66699 8.99996C7.9031 8.99996 8.10102 9.07982 8.26074 9.23954C8.42046 9.39927 8.50033 9.59718 8.50033 9.83329C8.50033 10.0694 8.42046 10.2673 8.26074 10.427C8.10102 10.5868 7.9031 10.6666 7.66699 10.6666ZM4.33366 10.6666C4.09755 10.6666 3.89963 10.5868 3.73991 10.427C3.58019 10.2673 3.50033 10.0694 3.50033 9.83329C3.50033 9.59718 3.58019 9.39927 3.73991 9.23954C3.89963 9.07982 4.09755 8.99996 4.33366 8.99996C4.56977 8.99996 4.76769 9.07982 4.92741 9.23954C5.08713 9.39927 5.16699 9.59718 5.16699 9.83329C5.16699 10.0694 5.08713 10.2673 4.92741 10.427C4.76769 10.5868 4.56977 10.6666 4.33366 10.6666ZM11.0003 10.6666C10.7642 10.6666 10.5663 10.5868 10.4066 10.427C10.2469 10.2673 10.167 10.0694 10.167 9.83329C10.167 9.59718 10.2469 9.39927 10.4066 9.23954C10.5663 9.07982 10.7642 8.99996 11.0003 8.99996C11.2364 8.99996 11.4344 9.07982 11.5941 9.23954C11.7538 9.39927 11.8337 9.59718 11.8337 9.83329C11.8337 10.0694 11.7538 10.2673 11.5941 10.427C11.4344 10.5868 11.2364 10.6666 11.0003 10.6666ZM7.66699 14C7.43088 14 7.23296 13.9201 7.07324 13.7604C6.91352 13.6007 6.83366 13.4027 6.83366 13.1666C6.83366 12.9305 6.91352 12.7326 7.07324 12.5729C7.23296 12.4132 7.43088 12.3333 7.66699 12.3333C7.9031 12.3333 8.10102 12.4132 8.26074 12.5729C8.42046 12.7326 8.50033 12.9305 8.50033 13.1666C8.50033 13.4027 8.42046 13.6007 8.26074 13.7604C8.10102 13.9201 7.9031 14 7.66699 14ZM4.33366 14C4.09755 14 3.89963 13.9201 3.73991 13.7604C3.58019 13.6007 3.50033 13.4027 3.50033 13.1666C3.50033 12.9305 3.58019 12.7326 3.73991 12.5729C3.89963 12.4132 4.09755 12.3333 4.33366 12.3333C4.56977 12.3333 4.76769 12.4132 4.92741 12.5729C5.08713 12.7326 5.16699 12.9305 5.16699 13.1666C5.16699 13.4027 5.08713 13.6007 4.92741 13.7604C4.76769 13.9201 4.56977 14 4.33366 14ZM11.0003 14C10.7642 14 10.5663 13.9201 10.4066 13.7604C10.2469 13.6007 10.167 13.4027 10.167 13.1666C10.167 12.9305 10.2469 12.7326 10.4066 12.5729C10.5663 12.4132 10.7642 12.3333 11.0003 12.3333C11.2364 12.3333 11.4344 12.4132 11.5941 12.5729C11.7538 12.7326 11.8337 12.9305 11.8337 13.1666C11.8337 13.4027 11.7538 13.6007 11.5941 13.7604C11.4344 13.9201 11.2364 14 11.0003 14ZM1.83366 17.3333C1.37533 17.3333 0.982964 17.1701 0.656576 16.8437C0.330187 16.5173 0.166992 16.125 0.166992 15.6666V3.99996C0.166992 3.54163 0.330187 3.14926 0.656576 2.82288C0.982964 2.49649 1.37533 2.33329 1.83366 2.33329H2.66699V0.666626H4.33366V2.33329H11.0003V0.666626H12.667V2.33329H13.5003C13.9587 2.33329 14.351 2.49649 14.6774 2.82288C15.0038 3.14926 15.167 3.54163 15.167 3.99996V15.6666C15.167 16.125 15.0038 16.5173 14.6774 16.8437C14.351 17.1701 13.9587 17.3333 13.5003 17.3333H1.83366ZM1.83366 15.6666H13.5003V7.33329H1.83366V15.6666Z" />
							</svg>
							<?php
						}

						?>
						<span><?php echo esc_html( $post_data['post_date_formatted'] ); ?></span>
						<?php

						if ( $has_meta_link ) {
							?>
							</a>
							<?php
						} else {
							?>
							</p>
							<?php
						}
					}
					?>
					</div>
					<?php
				}

				if ( $attributes['enableOptions']['postContent'] ) {
					?>
					<div class="post__content">
						<div>
							<?php
							if ( isset( $post_data['post_excerpt'] ) && ! empty( $post_data['post_excerpt'] ) ) {
								echo cozy_create_excerpt( $post_data['post_excerpt'], $attributes['enableOptions']['postExcerpt'] );
							} else {
								echo cozy_create_excerpt( $post_data['post_content'], $attributes['enableOptions']['postExcerpt'] );
							}
							?>
						</div>
						<?php
						if ( $attributes['enableOptions']['readMore'] ) {
							$open_new_tab = isset( $attributes['enableOptions']['readMoreNewTab'] ) && $attributes['enableOptions']['readMoreNewTab'] ? '_blank' : '';
							?>
							<span class="post__read-more">
								<a class="post__read-more-link" href="<?php echo esc_url( $post_data['post_link'] ); ?>" target="<?php echo esc_attr( $open_new_tab ); ?>">
									<?php esc_html_e( 'Read More', 'cozy-addons' ); ?>
								</a>
							</span>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
		</li>
		<?php

		echo ob_get_clean();
	}

	/**
	 * Renders the advanced gallery block output.
	 *
	 * @param array  $attributes Block attributes.
	 * @param array  $item_data Gallery item data.
	 * @param string $output Rendered HTML output (passed by reference).
	 *
	 * @return void
	 */
	public static function advanced_gallery_render( $attributes, $item_data, &$output ) {
		$classes   = array();
		$classes[] = 'cozy-block-advanced-gallery__item';
		$classes[] = 'carousel' === $attributes['display'] ? 'swiper-slide' : '';
		$classes[] = filter_var( $attributes['enableOptions']['hoverTitle'], FILTER_VALIDATE_BOOLEAN ) ? 'has-hover-caption' : '';
		$output   .= '<li class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';

		$classes   = array();
		$classes[] = 'cozy-block-advanced-gallery__image-wrapper';
		$classes[] = filter_var( $attributes['image']['hoverEffect'], FILTER_VALIDATE_BOOLEAN ) ? 'has-hover-effect' : '';
		$output   .= '<figure class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
		$output   .= '<span class="cozy-block-advanced-gallery__image-background"></span>';
		$output   .= '<img class="cozy-block-advanced-gallery__image" src="' . esc_url( $item_data['url'] ) . '" alt="' . esc_attr( $item_data['alt'] ) . '" />';

		if ( filter_var( $attributes['enableOptions']['hoverIcon'], FILTER_VALIDATE_BOOLEAN ) ) {
			$view_box   = array();
			$view_box[] = $attributes['icon']['viewBox']['vx'];
			$view_box[] = $attributes['icon']['viewBox']['vy'];
			$view_box[] = $attributes['icon']['viewBox']['vw'];
			$view_box[] = $attributes['icon']['viewBox']['vh'];
			$output    .= '<div class="cozy-block-advanced-gallery__icon-wrapper">';
			$output    .= '<svg class="cozy-block-advanced-gallery__icon" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="' . esc_attr( implode( ' ', array_map( 'intval', array_values( $view_box ) ) ) ) . '">';
			$output    .= '<path d="' . esc_attr( $attributes['icon']['path'] ) . '" />';
			$output    .= '</svg>';
			$output    .= '</div>';
		}

		if ( filter_var( $attributes['enableOptions']['hoverTitle'], FILTER_VALIDATE_BOOLEAN ) ) {
			$output .= '<div class="cozy-block-advanced-gallery__image-caption">';
			$output .= esc_html( $item_data['caption'] );
			$output .= '</div>';
		}
		$output .= '</figure>';

		$output .= '</li>';
	}

	/**
	 * Renders the popular post block output.
	 *
	 * @param array  $attributes Block attributes.
	 * @param array  $post_data Post data.
	 * @param string $output Rendered HTML output (passed by reference).
	 *
	 * @return void
	 */
	public static function popular_posts_render( $attributes, $post_data, &$output ) {
		$item_classes   = array();
		$item_classes[] = 'cozy-block-popular-posts__item';
		$output        .= '<li class="' . implode( ' ', $item_classes ) . '" data-post-id="' . esc_attr( $post_data['ID'] ) . '">';

		if ( 'list' === $attributes['display'] ) {
			$output .= '<div class="item__flex" style="display:flex;gap:' . esc_attr( $attributes['imageStyles']['gap'] ) . '">';
		}

			// Post Image.
		if ( filter_var( $attributes['enableOptions']['image'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_data['post_image_url'] ) ) {
			$figure_classes   = array();
			$figure_classes[] = 'cozy-block-popular-posts__image';
			$figure_classes[] = $attributes['imageStyles']['hoverEffect'] ? 'has-hover-effect' : '';
			$output          .= '<figure class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $figure_classes ) ) ) ) . '">';
			$has_post_link    = isset( $attributes['enableOptions']['imgLinkPost'] ) && filter_var( $attributes['enableOptions']['imgLinkPost'], FILTER_VALIDATE_BOOLEAN ) ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
			$open_new_tab     = isset( $attributes['enableOptions']['imgLinkPost'], $attributes['enableOptions']['imgLinkNewTab'] ) && filter_var( $attributes['enableOptions']['imgLinkPost'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['enableOptions']['imgLinkNewTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
			$output          .= '<a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener">';
			$output          .= '<img alt="' . esc_html( $post_data['post_title'] ) . '" src="' . esc_url( $post_data['post_image_url'] ) . '" />';
			$output          .= '</a>';
			$output          .= '</figure>';
		}

			$output .= '<div>';
			// Post Category.
		if ( filter_var( $attributes['enableOptions']['category'], FILTER_VALIDATE_BOOLEAN ) ) {
			$category_classes   = array();
			$category_classes[] = 'cozy-block-popular-posts__post-categories';
			$category_classes[] = $attributes['categoryStyles']['hoverEffect'] ? 'has-hover-effect' : '';
			$output            .= '<div class="' . esc_attr( implode( ' ', $category_classes ) ) . '">';
			$open_new_tab       = isset( $attributes['enableOptions']['linkCat'], $attributes['enableOptions']['catNewTab'] ) && filter_var( $attributes['enableOptions']['linkCat'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['enableOptions']['catNewTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
			foreach ( $post_data['post_categories'] as $cat_data ) {
				$has_cat_link = isset( $attributes['enableOptions']['linkCat'] ) && filter_var( $attributes['enableOptions']['linkCat'], FILTER_VALIDATE_BOOLEAN ) ? 'href="' . esc_url( $cat_data['link'] ) . '"' : '';
				$output      .= '<a ' . $has_cat_link . ' target="' . esc_attr( $open_new_tab ) . '" rel="noopener">';
				$output      .= esc_html( $cat_data['name'] );
				$output      .= '</a>';
			}
			$output .= '</div>';
		}

		// Post Title.
		$has_post_link = isset( $attributes['enableOptions']['titleLinkPost'] ) && filter_var( $attributes['enableOptions']['titleLinkPost'], FILTER_VALIDATE_BOOLEAN ) ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
		$open_new_tab  = isset( $attributes['enableOptions']['titleLinkPost'], $attributes['enableOptions']['titleLinkNewTab'] ) && filter_var( $attributes['enableOptions']['titleLinkPost'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['enableOptions']['titleLinkNewTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
		$classes       = array();
		$classes[]     = 'cozy-block-popular-posts__post-title';
		$classes[]     = isset( $attributes['titleStyles']['className'] ) ? $attributes['titleStyles']['className'] : '';
		$allowed_tags  = array(
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'div',
			'p',
		);
		$title_tag     = isset( $attributes['titleStyles']['tag'] ) && in_array( $attributes['titleStyles']['tag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['titleStyles']['tag'] ) : 'h3';
		$output       .= sprintf( '<%1$s class="%2$s"><a %3$s target="%4$s" rel="noopener">%5$s</a></%1$s>', esc_attr( $title_tag ), esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ), $has_post_link, $open_new_tab, esc_html( $post_data['post_title'] ) );

		if ( ( isset( $attributes['enableOptions']['author'] ) && filter_var( $attributes['enableOptions']['author'], FILTER_VALIDATE_BOOLEAN ) ) || ( isset( $attributes['enableOptions']['comments'] ) && filter_var( $attributes['enableOptions']['comments'], FILTER_VALIDATE_BOOLEAN ) ) || filter_var( $attributes['enableOptions']['date'], FILTER_VALIDATE_BOOLEAN ) ) {
			$output .= '<div class="post__meta">';

			$has_meta_link = isset( $attributes['enableOptions']['linkPostMeta'] ) && $attributes['enableOptions']['linkPostMeta'] ? true : false;
			$open_new_tab  = isset( $attributes['enableOptions']['linkPostMeta'], $attributes['enableOptions']['postMetaNewTab'] ) && $attributes['enableOptions']['linkPostMeta'] && $attributes['enableOptions']['postMetaNewTab'] ? '_blank' : '';
			$show_icon     = isset( $attributes['enableOptions']['enableMetaIcon'] ) && $attributes['enableOptions']['enableMetaIcon'] ? true : false;

			if ( isset( $attributes['enableOptions']['author'] ) && filter_var( $attributes['enableOptions']['author'], FILTER_VALIDATE_BOOLEAN ) ) {
				$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_author_url'] ) . '"' : '';
				$output   .= '<a class="post__author display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
				if ( $show_icon ) {
					$output .= '<svg
									width="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
									height="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
									xmlns="http://www.w3.org/2000/svg"
									aria-hidden="true"
									viewBox="0 0 12 15"
								>
													<path d="M11.2972 14.6667H0.630493V13.3333C0.630493 12.4493 0.981683 11.6014 1.6068 10.9763C2.23193 10.3512 3.07977 10 3.96383 10H7.96383C8.84788 10 9.69573 10.3512 10.3208 10.9763C10.946 11.6014 11.2972 12.4493 11.2972 13.3333V14.6667ZM5.96383 8.66667C5.43854 8.66667 4.9184 8.5632 4.43309 8.36218C3.94779 8.16117 3.50683 7.86653 3.1354 7.49509C2.76396 7.12366 2.46933 6.6827 2.26831 6.1974C2.06729 5.7121 1.96383 5.19195 1.96383 4.66667C1.96383 4.14138 2.06729 3.62124 2.26831 3.13593C2.46933 2.65063 2.76396 2.20967 3.1354 1.83824C3.50683 1.4668 3.94779 1.17217 4.43309 0.971148C4.9184 0.770129 5.43854 0.666666 5.96383 0.666666C7.02469 0.666666 8.04211 1.08809 8.79225 1.83824C9.5424 2.58838 9.96383 3.6058 9.96383 4.66667C9.96383 5.72753 9.5424 6.74495 8.79225 7.49509C8.04211 8.24524 7.02469 8.66667 5.96383 8.66667Z" />
												</svg>';
				}

				$output .= '<p>' . esc_html( $post_data['post_author_name'] ) . '</p>';
				$output .= '</a>';
			}

			if ( isset( $attributes['enableOptions']['comments'] ) && filter_var( $attributes['enableOptions']['comments'], FILTER_VALIDATE_BOOLEAN ) && intval( $post_data['comment_count'] ) > 0 ) {
				$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['comment_link'] ) . '"' : '';
				$output   .= '<a class="post__comments display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
				if ( $show_icon ) {
					$output .= '<svg
												width="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
												height="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
												xmlns="http://www.w3.org/2000/svg"
												aria-hidden="true"
												viewBox="0 0 25 20"
											>
												<path d="M18.0556 6.94444C18.0556 3.10764 14.0148 0 9.02778 0C4.0408 0 0 3.10764 0 6.94444C0 8.43316 0.611979 9.80469 1.64931 10.9375C1.06771 12.2483 0.108507 13.2899 0.0954861 13.3029C0 13.4028 -0.0260417 13.5503 0.0303819 13.6806C0.0868056 13.8108 0.208333 13.8889 0.347222 13.8889C1.93576 13.8889 3.25087 13.355 4.19705 12.8038C5.59462 13.4852 7.24826 13.8889 9.02778 13.8889C14.0148 13.8889 18.0556 10.7812 18.0556 6.94444ZM23.3507 16.4931C24.388 15.3646 25 13.9887 25 12.5C25 9.59635 22.678 7.10937 19.388 6.07205C19.4271 6.35851 19.4444 6.6493 19.4444 6.94444C19.4444 11.5408 14.77 15.2778 9.02778 15.2778C8.55903 15.2778 8.1033 15.2431 7.65191 15.1953C9.0191 17.691 12.2309 19.4444 15.9722 19.4444C17.7517 19.4444 19.4054 19.0451 20.8029 18.3594C21.7491 18.9106 23.0642 19.4444 24.6528 19.4444C24.7917 19.4444 24.9175 19.362 24.9696 19.2361C25.026 19.1102 25 18.9627 24.9045 18.8585C24.8915 18.8455 23.9323 17.8082 23.3507 16.4931Z" />
											</svg>';
				}

				$output .= '<p>' . esc_html( $post_data['comment_count'] ) . '</p>';
				$output .= '</a>';
			}

			// Post Date.
			if ( filter_var( $attributes['enableOptions']['date'], FILTER_VALIDATE_BOOLEAN ) ) {
				$meta_link   = $has_meta_link ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
					$output .= '<a class="post__date display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
				if ( $show_icon ) {
					$output .= '<svg
													width="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
													height="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
													xmlns="http://www.w3.org/2000/svg"
													viewBox="0 0 16 18"
													aria-hidden="true"
												>
													<path d="M7.66699 10.6666C7.43088 10.6666 7.23296 10.5868 7.07324 10.427C6.91352 10.2673 6.83366 10.0694 6.83366 9.83329C6.83366 9.59718 6.91352 9.39927 7.07324 9.23954C7.23296 9.07982 7.43088 8.99996 7.66699 8.99996C7.9031 8.99996 8.10102 9.07982 8.26074 9.23954C8.42046 9.39927 8.50033 9.59718 8.50033 9.83329C8.50033 10.0694 8.42046 10.2673 8.26074 10.427C8.10102 10.5868 7.9031 10.6666 7.66699 10.6666ZM4.33366 10.6666C4.09755 10.6666 3.89963 10.5868 3.73991 10.427C3.58019 10.2673 3.50033 10.0694 3.50033 9.83329C3.50033 9.59718 3.58019 9.39927 3.73991 9.23954C3.89963 9.07982 4.09755 8.99996 4.33366 8.99996C4.56977 8.99996 4.76769 9.07982 4.92741 9.23954C5.08713 9.39927 5.16699 9.59718 5.16699 9.83329C5.16699 10.0694 5.08713 10.2673 4.92741 10.427C4.76769 10.5868 4.56977 10.6666 4.33366 10.6666ZM11.0003 10.6666C10.7642 10.6666 10.5663 10.5868 10.4066 10.427C10.2469 10.2673 10.167 10.0694 10.167 9.83329C10.167 9.59718 10.2469 9.39927 10.4066 9.23954C10.5663 9.07982 10.7642 8.99996 11.0003 8.99996C11.2364 8.99996 11.4344 9.07982 11.5941 9.23954C11.7538 9.39927 11.8337 9.59718 11.8337 9.83329C11.8337 10.0694 11.7538 10.2673 11.5941 10.427C11.4344 10.5868 11.2364 10.6666 11.0003 10.6666ZM7.66699 14C7.43088 14 7.23296 13.9201 7.07324 13.7604C6.91352 13.6007 6.83366 13.4027 6.83366 13.1666C6.83366 12.9305 6.91352 12.7326 7.07324 12.5729C7.23296 12.4132 7.43088 12.3333 7.66699 12.3333C7.9031 12.3333 8.10102 12.4132 8.26074 12.5729C8.42046 12.7326 8.50033 12.9305 8.50033 13.1666C8.50033 13.4027 8.42046 13.6007 8.26074 13.7604C8.10102 13.9201 7.9031 14 7.66699 14ZM4.33366 14C4.09755 14 3.89963 13.9201 3.73991 13.7604C3.58019 13.6007 3.50033 13.4027 3.50033 13.1666C3.50033 12.9305 3.58019 12.7326 3.73991 12.5729C3.89963 12.4132 4.09755 12.3333 4.33366 12.3333C4.56977 12.3333 4.76769 12.4132 4.92741 12.5729C5.08713 12.7326 5.16699 12.9305 5.16699 13.1666C5.16699 13.4027 5.08713 13.6007 4.92741 13.7604C4.76769 13.9201 4.56977 14 4.33366 14ZM11.0003 14C10.7642 14 10.5663 13.9201 10.4066 13.7604C10.2469 13.6007 10.167 13.4027 10.167 13.1666C10.167 12.9305 10.2469 12.7326 10.4066 12.5729C10.5663 12.4132 10.7642 12.3333 11.0003 12.3333C11.2364 12.3333 11.4344 12.4132 11.5941 12.5729C11.7538 12.7326 11.8337 12.9305 11.8337 13.1666C11.8337 13.4027 11.7538 13.6007 11.5941 13.7604C11.4344 13.9201 11.2364 14 11.0003 14ZM1.83366 17.3333C1.37533 17.3333 0.982964 17.1701 0.656576 16.8437C0.330187 16.5173 0.166992 16.125 0.166992 15.6666V3.99996C0.166992 3.54163 0.330187 3.14926 0.656576 2.82288C0.982964 2.49649 1.37533 2.33329 1.83366 2.33329H2.66699V0.666626H4.33366V2.33329H11.0003V0.666626H12.667V2.33329H13.5003C13.9587 2.33329 14.351 2.49649 14.6774 2.82288C15.0038 3.14926 15.167 3.54163 15.167 3.99996V15.6666C15.167 16.125 15.0038 16.5173 14.6774 16.8437C14.351 17.1701 13.9587 17.3333 13.5003 17.3333H1.83366ZM1.83366 15.6666H13.5003V7.33329H1.83366V15.6666Z" />
												</svg>';
				}

					$output .= '<p>' . esc_html( $post_data['post_date_formatted'] ) . '</p>';
					$output .= '</a>';
			}

			$output .= '</div>';

		}

			// Post Excerpt
		if ( filter_var( $attributes['enableOptions']['content'], FILTER_VALIDATE_BOOLEAN ) ) {
			$output .= '<p class="cozy-block-popular-posts__content">';
			if ( isset( $post_data['post_excerpt'] ) && ! empty( $post_data['post_excerpt'] ) ) {
				$output .= cozy_create_excerpt( $post_data['post_excerpt'], $attributes['enableOptions']['excerpt'] );
			} else {
				$output .= cozy_create_excerpt( $post_data['post_content'], $attributes['enableOptions']['excerpt'] );
			}
			$output .= '</p>';
		}
			$output .= '</div>';

		if ( 'list' === $attributes['display'] ) {
			$output .= '</div>';
		}

		$output .= '</li>';
	}

	/**
	 * Renders the trending post block output.
	 *
	 * @param array  $attributes Block attributes.
	 * @param array  $post_data Post data.
	 * @param string $output Rendered HTML output (passed by reference).
	 *
	 * @return void
	 */
	public static function trending_posts_render( $attributes, $post_data, &$output ) {
		$item_classes   = array();
		$item_classes[] = 'cozy-block-trending-posts__item';
		$output        .= '<li class="' . implode( ' ', $item_classes ) . '" data-post-id="' . esc_attr( $post_data['ID'] ) . '">';

		if ( 'list' === $attributes['display'] ) {
			$output .= '<div class="item__flex" style="display:flex;gap:' . $attributes['imageStyles']['gap'] . '">';
		}

			// Post Image.
		if ( filter_var( $attributes['enableOptions']['image'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $post_data['post_image_url'] ) ) {
			$figure_classes   = array();
			$figure_classes[] = 'cozy-block-trending-posts__image';
			$figure_classes[] = $attributes['imageStyles']['hoverEffect'] ? 'has-hover-effect' : '';
			$output          .= '<figure class="' . implode( ' ', $figure_classes ) . '">';
			$has_post_link    = isset( $attributes['enableOptions']['imgLinkPost'] ) && filter_var( $attributes['enableOptions']['imgLinkPost'], FILTER_VALIDATE_BOOLEAN ) ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
			$open_new_tab     = isset( $attributes['enableOptions']['imgLinkPost'], $attributes['enableOptions']['imgLinkNewTab'] ) && filter_var( $attributes['enableOptions']['imgLinkPost'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['enableOptions']['imgLinkNewTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
			$output          .= '<a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener">';
			$output          .= '<img alt="' . esc_attr( $post_data['post_title'] ) . '" src="' . esc_url( $post_data['post_image_url'] ) . '" />';
			$output          .= '</a>';
			$output          .= '</figure>';
		}

			$output .= '<div>';
			// Post Category.
		if ( filter_var( $attributes['enableOptions']['category'], FILTER_VALIDATE_BOOLEAN ) ) {
			$category_classes   = array();
			$category_classes[] = 'cozy-block-trending-posts__post-categories';
			$category_classes[] = $attributes['categoryStyles']['hoverEffect'] ? 'has-hover-effect' : '';
			$output            .= '<div class="' . implode( ' ', $category_classes ) . '">';
			$open_new_tab       = isset( $attributes['enableOptions']['linkCat'], $attributes['enableOptions']['catNewTab'] ) && filter_var( $attributes['enableOptions']['linkCat'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['enableOptions']['catNewTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
			foreach ( $post_data['post_categories'] as $cat_data ) {
				$has_cat_link = isset( $attributes['enableOptions']['linkCat'] ) && filter_var( $attributes['enableOptions']['linkCat'], FILTER_VALIDATE_BOOLEAN ) ? 'href="' . esc_url( $cat_data['link'] ) . '"' : '';
				$output      .= '<a ' . $has_cat_link . ' target="' . $open_new_tab . '" rel="noopener">';
				$output      .= esc_html( $cat_data['name'] );
				$output      .= '</a>';
			}
			$output .= '</div>';
		}

			// Post Title.
			$has_post_link = isset( $attributes['enableOptions']['titleLinkPost'] ) && filter_var( $attributes['enableOptions']['titleLinkPost'], FILTER_VALIDATE_BOOLEAN ) ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
			$open_new_tab  = isset( $attributes['enableOptions']['titleLinkPost'], $attributes['enableOptions']['titleLinkNewTab'] ) && filter_var( $attributes['enableOptions']['titleLinkPost'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['enableOptions']['titleLinkNewTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
			$classes       = array();
			$classes[]     = 'cozy-block-trending-posts__post-title';
			$classes[]     = isset( $attributes['titleStyles']['className'] ) ? $attributes['titleStyles']['className'] : '';
			$allowed_tags  = array(
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'div',
				'p',
			);
			$title_tag     = isset( $attributes['titleStyles']['tag'] ) && in_array( $attributes['titleStyles']['tag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['titleStyles']['tag'] ) : 'h3';
			$output       .= sprintf( '<%1$s class="%2$s"><a %3$s target="%4$s" rel="noopener">%5$s</a></%1$s>', esc_attr( $title_tag ), esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ), $has_post_link, $open_new_tab, esc_html( $post_data['post_title'] ) );

			if ( ( isset( $attributes['enableOptions']['author'] ) && filter_var( $attributes['enableOptions']['author'], FILTER_VALIDATE_BOOLEAN ) ) || ( isset( $attributes['enableOptions']['comments'] ) && filter_var( $attributes['enableOptions']['comments'], FILTER_VALIDATE_BOOLEAN ) ) || filter_var( $attributes['enableOptions']['date'], FILTER_VALIDATE_BOOLEAN ) ) {
				$output .= '<div class="post__meta">';

				$has_meta_link = isset( $attributes['enableOptions']['linkPostMeta'] ) && $attributes['enableOptions']['linkPostMeta'] ? true : false;
				$open_new_tab  = isset( $attributes['enableOptions']['linkPostMeta'], $attributes['enableOptions']['postMetaNewTab'] ) && $attributes['enableOptions']['linkPostMeta'] && $attributes['enableOptions']['postMetaNewTab'] ? '_blank' : '';
				$show_icon     = isset( $attributes['enableOptions']['enableMetaIcon'] ) && $attributes['enableOptions']['enableMetaIcon'] ? true : false;

				if ( isset( $attributes['enableOptions']['author'] ) && filter_var( $attributes['enableOptions']['author'], FILTER_VALIDATE_BOOLEAN ) ) {
					$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_author_url'] ) . '"' : '';
					$output   .= '<a class="post__author display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
					if ( $show_icon ) {
						$output .= '<svg
													width="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
													height="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
													xmlns="http://www.w3.org/2000/svg"
													aria-hidden="true"
													viewBox="0 0 12 15"
												>
													<path d="M11.2972 14.6667H0.630493V13.3333C0.630493 12.4493 0.981683 11.6014 1.6068 10.9763C2.23193 10.3512 3.07977 10 3.96383 10H7.96383C8.84788 10 9.69573 10.3512 10.3208 10.9763C10.946 11.6014 11.2972 12.4493 11.2972 13.3333V14.6667ZM5.96383 8.66667C5.43854 8.66667 4.9184 8.5632 4.43309 8.36218C3.94779 8.16117 3.50683 7.86653 3.1354 7.49509C2.76396 7.12366 2.46933 6.6827 2.26831 6.1974C2.06729 5.7121 1.96383 5.19195 1.96383 4.66667C1.96383 4.14138 2.06729 3.62124 2.26831 3.13593C2.46933 2.65063 2.76396 2.20967 3.1354 1.83824C3.50683 1.4668 3.94779 1.17217 4.43309 0.971148C4.9184 0.770129 5.43854 0.666666 5.96383 0.666666C7.02469 0.666666 8.04211 1.08809 8.79225 1.83824C9.5424 2.58838 9.96383 3.6058 9.96383 4.66667C9.96383 5.72753 9.5424 6.74495 8.79225 7.49509C8.04211 8.24524 7.02469 8.66667 5.96383 8.66667Z" />
												</svg>';
					}

					$output .= '<p>' . esc_html( $post_data['post_author_name'] ) . '</p>';
					$output .= '</a>';
				}

				if ( isset( $attributes['enableOptions']['comments'] ) && filter_var( $attributes['enableOptions']['comments'], FILTER_VALIDATE_BOOLEAN ) && intval( $post_data['comment_count'] ) > 0 ) {
					$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['comment_link'] ) . '"' : '';
					$output   .= '<a class="post__comments display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
					if ( $show_icon ) {
						$output .= '<svg
												width="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
												height="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
												xmlns="http://www.w3.org/2000/svg"
												aria-hidden="true"
												viewBox="0 0 25 20"
											>
												<path d="M18.0556 6.94444C18.0556 3.10764 14.0148 0 9.02778 0C4.0408 0 0 3.10764 0 6.94444C0 8.43316 0.611979 9.80469 1.64931 10.9375C1.06771 12.2483 0.108507 13.2899 0.0954861 13.3029C0 13.4028 -0.0260417 13.5503 0.0303819 13.6806C0.0868056 13.8108 0.208333 13.8889 0.347222 13.8889C1.93576 13.8889 3.25087 13.355 4.19705 12.8038C5.59462 13.4852 7.24826 13.8889 9.02778 13.8889C14.0148 13.8889 18.0556 10.7812 18.0556 6.94444ZM23.3507 16.4931C24.388 15.3646 25 13.9887 25 12.5C25 9.59635 22.678 7.10937 19.388 6.07205C19.4271 6.35851 19.4444 6.6493 19.4444 6.94444C19.4444 11.5408 14.77 15.2778 9.02778 15.2778C8.55903 15.2778 8.1033 15.2431 7.65191 15.1953C9.0191 17.691 12.2309 19.4444 15.9722 19.4444C17.7517 19.4444 19.4054 19.0451 20.8029 18.3594C21.7491 18.9106 23.0642 19.4444 24.6528 19.4444C24.7917 19.4444 24.9175 19.362 24.9696 19.2361C25.026 19.1102 25 18.9627 24.9045 18.8585C24.8915 18.8455 23.9323 17.8082 23.3507 16.4931Z" />
											</svg>';
					}

					$output .= '<p>' . esc_html( $post_data['comment_count'] ) . '</p>';
					$output .= '</a>';
				}

				// Post Date.
				if ( filter_var( $attributes['enableOptions']['date'], FILTER_VALIDATE_BOOLEAN ) ) {
					$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
					$output   .= '<a class="post__date display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
					if ( $show_icon ) {
						$output .= '<svg
													width="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
													height="' . esc_attr( $attributes['dateStyles']['fontSize'] ) . '"
													xmlns="http://www.w3.org/2000/svg"
													viewBox="0 0 16 18"
													aria-hidden="true"
												>
													<path d="M7.66699 10.6666C7.43088 10.6666 7.23296 10.5868 7.07324 10.427C6.91352 10.2673 6.83366 10.0694 6.83366 9.83329C6.83366 9.59718 6.91352 9.39927 7.07324 9.23954C7.23296 9.07982 7.43088 8.99996 7.66699 8.99996C7.9031 8.99996 8.10102 9.07982 8.26074 9.23954C8.42046 9.39927 8.50033 9.59718 8.50033 9.83329C8.50033 10.0694 8.42046 10.2673 8.26074 10.427C8.10102 10.5868 7.9031 10.6666 7.66699 10.6666ZM4.33366 10.6666C4.09755 10.6666 3.89963 10.5868 3.73991 10.427C3.58019 10.2673 3.50033 10.0694 3.50033 9.83329C3.50033 9.59718 3.58019 9.39927 3.73991 9.23954C3.89963 9.07982 4.09755 8.99996 4.33366 8.99996C4.56977 8.99996 4.76769 9.07982 4.92741 9.23954C5.08713 9.39927 5.16699 9.59718 5.16699 9.83329C5.16699 10.0694 5.08713 10.2673 4.92741 10.427C4.76769 10.5868 4.56977 10.6666 4.33366 10.6666ZM11.0003 10.6666C10.7642 10.6666 10.5663 10.5868 10.4066 10.427C10.2469 10.2673 10.167 10.0694 10.167 9.83329C10.167 9.59718 10.2469 9.39927 10.4066 9.23954C10.5663 9.07982 10.7642 8.99996 11.0003 8.99996C11.2364 8.99996 11.4344 9.07982 11.5941 9.23954C11.7538 9.39927 11.8337 9.59718 11.8337 9.83329C11.8337 10.0694 11.7538 10.2673 11.5941 10.427C11.4344 10.5868 11.2364 10.6666 11.0003 10.6666ZM7.66699 14C7.43088 14 7.23296 13.9201 7.07324 13.7604C6.91352 13.6007 6.83366 13.4027 6.83366 13.1666C6.83366 12.9305 6.91352 12.7326 7.07324 12.5729C7.23296 12.4132 7.43088 12.3333 7.66699 12.3333C7.9031 12.3333 8.10102 12.4132 8.26074 12.5729C8.42046 12.7326 8.50033 12.9305 8.50033 13.1666C8.50033 13.4027 8.42046 13.6007 8.26074 13.7604C8.10102 13.9201 7.9031 14 7.66699 14ZM4.33366 14C4.09755 14 3.89963 13.9201 3.73991 13.7604C3.58019 13.6007 3.50033 13.4027 3.50033 13.1666C3.50033 12.9305 3.58019 12.7326 3.73991 12.5729C3.89963 12.4132 4.09755 12.3333 4.33366 12.3333C4.56977 12.3333 4.76769 12.4132 4.92741 12.5729C5.08713 12.7326 5.16699 12.9305 5.16699 13.1666C5.16699 13.4027 5.08713 13.6007 4.92741 13.7604C4.76769 13.9201 4.56977 14 4.33366 14ZM11.0003 14C10.7642 14 10.5663 13.9201 10.4066 13.7604C10.2469 13.6007 10.167 13.4027 10.167 13.1666C10.167 12.9305 10.2469 12.7326 10.4066 12.5729C10.5663 12.4132 10.7642 12.3333 11.0003 12.3333C11.2364 12.3333 11.4344 12.4132 11.5941 12.5729C11.7538 12.7326 11.8337 12.9305 11.8337 13.1666C11.8337 13.4027 11.7538 13.6007 11.5941 13.7604C11.4344 13.9201 11.2364 14 11.0003 14ZM1.83366 17.3333C1.37533 17.3333 0.982964 17.1701 0.656576 16.8437C0.330187 16.5173 0.166992 16.125 0.166992 15.6666V3.99996C0.166992 3.54163 0.330187 3.14926 0.656576 2.82288C0.982964 2.49649 1.37533 2.33329 1.83366 2.33329H2.66699V0.666626H4.33366V2.33329H11.0003V0.666626H12.667V2.33329H13.5003C13.9587 2.33329 14.351 2.49649 14.6774 2.82288C15.0038 3.14926 15.167 3.54163 15.167 3.99996V15.6666C15.167 16.125 15.0038 16.5173 14.6774 16.8437C14.351 17.1701 13.9587 17.3333 13.5003 17.3333H1.83366ZM1.83366 15.6666H13.5003V7.33329H1.83366V15.6666Z" />
												</svg>';
					}

					$output .= '<p>' . esc_html( $post_data['post_date_formatted'] ) . '</p>';
					$output .= '</a>';
				}

				$output .= '</div>';

			}

			// Post Excerpt.
			if ( filter_var( $attributes['enableOptions']['content'], FILTER_VALIDATE_BOOLEAN ) ) {
				$output .= '<p class="cozy-block-trending-posts__content">';
				if ( isset( $post_data['post_excerpt'] ) && ! empty( $post_data['post_excerpt'] ) ) {
					$output .= cozy_create_excerpt( $post_data['post_excerpt'], $attributes['enableOptions']['excerpt'] );
				} else {
					$output .= cozy_create_excerpt( $post_data['post_content'], $attributes['enableOptions']['excerpt'] );
				}
				$output .= '</p>';
			}

			$output .= '</div>';

			if ( 'list' === $attributes['display'] ) {
				$output .= '</div>';
			}

			$output .= '</li>';
	}

	public static function list_scroll_tab_render( $attributes ) {
		if ( ! isset( $attributes['childAttrs'] ) || empty( $attributes['childAttrs'] ) ) {
			return '';
		}

		ob_start();

		$classes   = array();
		$classes[] = 'list-item__tabs';
		$classes[] = 'tab-position-' . $attributes['listScroll']['tabPosition'];
		?>
		<ul class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<?php
			$allowed_tags = array(
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'p',
			);
			$title_tag    = in_array( $attributes['listScroll']['title']['tag'], $allowed_tags, true ) ? $attributes['listScroll']['title']['tag'] : 'p';
			foreach ( $attributes['childAttrs'] as $key => $tab ) {
				$classes   = array();
				$classes[] = 'list-item__tab';
				$classes[] = 0 === $key ? 'is-active' : '';
				?>
				<li id="cozyBlock_<?php echo esc_attr( str_replace( '-', '_', $tab['clientId'] ) ); ?>" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
					<div class="tab-container">
						<?php
						// Render icon.
						if ( isset( $attributes['listScroll']['icon']['enabled'] ) && filter_var( $attributes['listScroll']['icon']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $tab['icon']['path'] ) ) {
							printf( '<i class="tab__icon-wrapper"><svg class="tab__icon" width="16" height="16" viewBox="%1$s %2$s %3$s %4$s" fill="currentColor"><path d="%5$s"></path></svg></i>', esc_attr( $tab['icon']['viewBox']['vx'] ), esc_attr( $tab['icon']['viewBox']['vy'] ), esc_attr( $tab['icon']['viewBox']['vw'] ), esc_attr( $tab['icon']['viewBox']['vh'] ), esc_attr( $tab['icon']['path'] ) );
						}

						if ( isset( $attributes['listScroll']['title']['enabled'] ) || isset( $attributes['listScroll']['description']['enabled'] ) || filter_var( $attributes['listScroll']['title']['enabled'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['listScroll']['description']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
							?>
							<div class="tab-content__wrapper">
							<?php
							// Render title.
							if ( isset( $attributes['listScroll']['title']['enabled'] ) && filter_var( $attributes['listScroll']['title']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $tab['title'] ) ) {
								$classes   = array();
								$classes[] = 'tab__title';
								$classes[] = isset( $attributes['listScroll']['icon']['enabled'], $attributes['listScroll']['title']['indexNumber'] ) && ! filter_var( $attributes['listScroll']['icon']['enabled'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['listScroll']['title']['indexNumber'], FILTER_VALIDATE_BOOLEAN ) ? 'has-index-number' : '';
								printf( '<%1$s class="%2$s">%3$s</%1$s>', esc_attr( $title_tag ), esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ), esc_html( $tab['title'] ) );
							}

							// Render description.
							if ( isset( $attributes['listScroll']['description']['enabled'] ) && filter_var( $attributes['listScroll']['description']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $tab['description'] ) ) {
								$is_collapsible = isset( $attributes['listScroll']['collapse'] ) && filter_var( $attributes['listScroll']['collapse'], FILTER_VALIDATE_BOOLEAN ) ? true : false;
								$classes        = array();
								$classes[]      = 'tab__description';
								$classes[]      = $is_collapsible ? 'is-collapsible' : '';
								$classes[]      = $is_collapsible && 0 === $key ? 'is-open' : '';
								printf( '<div class="%1$s"><div class="tab__description-inner">%2$s</div></div>', esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ), esc_html( $tab['description'] ) );
							}

							?>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					// if ( 'click' === $attributes['listScroll']['variation'] && isset( $attributes['listScroll']['autoplay']['enabled'], $attributes['listScroll']['autoplay']['progressBar'] ) && filter_var( $attributes['listScroll']['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['listScroll']['autoplay']['progressBar'], FILTER_VALIDATE_BOOLEAN ) ) {
					if ( isset( $attributes['listScroll']['autoplay']['enabled'], $attributes['listScroll']['autoplay']['progressBar'] ) && filter_var( $attributes['listScroll']['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $attributes['listScroll']['autoplay']['progressBar'], FILTER_VALIDATE_BOOLEAN ) ) {
						printf( '<div class="tab__progress-bar"><div class="progress"></div></div>' );
					}
					?>
				</li>
				<?php
			}
			?>
		</ul>
		<?php

		return ob_get_clean();
	}

	public static function generate_cpt_testimonial_layout( $testimonials, $attributes ) {
		$review_source_icons = array(
			'capterra'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 8.82411L10.1371 8.8261L16.3012 8.82713V2.83118L0 8.82411Z" fill="#FF9D28"/>
					<path d="M16.3012 2.83128V24L24 0L16.3012 2.83128Z" fill="#68C5ED"/>
					<path d="M16.3012 8.8272L10.1371 8.82617L16.3012 24V8.8272Z" fill="#044D80"/>
					<path d="M0 8.82422L11.7178 12.7196L10.1371 8.82621L0 8.82422Z" fill="#E54747"/>
					</svg>
						',
			'clutch'     => '<svg width="80" height="18" viewBox="0 0 80 18" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g clip-path="url(#clip0_2023_411)">
					<path d="M58.9993 13.8678C60.4477 13.8678 61.6219 12.9358 61.6219 11.7861C61.6219 10.6364 60.4477 9.70435 58.9993 9.70435C57.5508 9.70435 56.3766 10.6364 56.3766 11.7861C56.3766 12.9358 57.5508 13.8678 58.9993 13.8678Z" fill="#E62415"/>
					<path d="M20.8233 0H24.2938V17.7652H20.8233V0ZM36.9337 12.287C36.9337 15.0417 34.0942 15.2609 33.2265 15.2609C31.0574 15.2609 30.7419 13.6487 30.7419 12.6783V5.80696H27.2517V12.6626C27.2319 14.3687 27.8432 15.7774 29.0264 16.7165C30.1009 17.4768 31.4698 17.9237 32.9073 17.9835C34.3448 18.0432 35.765 17.7123 36.9337 17.0452V17.7652H40.424V5.80696H36.9337V12.287ZM47.9566 1.78435H44.4664V5.80696H42.0409V8.42087H44.4664V17.7652H47.9566V8.42087H50.8159V5.80696H47.9566V1.78435ZM62.1149 14.3687C61.3261 14.9322 60.281 15.2452 59.1373 15.2452C58.5563 15.2583 57.978 15.1768 57.4382 15.0058C56.8983 14.8348 56.4082 14.5779 55.9981 14.251C55.5881 13.924 55.2666 13.5338 55.0536 13.1046C54.8406 12.6753 54.7406 12.2159 54.7597 11.7548C54.7597 9.73565 56.5541 8.32696 59.1373 8.32696C60.2613 8.32696 61.3261 8.62435 62.1346 9.18783L62.6867 9.56348L65.1319 7.62261L64.5206 7.18435C63.0398 6.13601 61.1214 5.56149 59.1373 5.57217C54.6019 5.57217 51.3089 8.17043 51.3089 11.7391C51.2848 12.5618 51.4705 13.3799 51.8549 14.1442C52.2392 14.9085 52.8143 15.6032 53.5456 16.1866C54.2768 16.7699 55.1492 17.2299 56.1101 17.5389C57.071 17.8478 58.1007 17.9993 59.1373 17.9843C61.2078 17.9843 63.1403 17.4052 64.56 16.3565L65.1516 15.9183L62.667 13.9774L62.1149 14.3687ZM78.2253 6.85565C77.1508 6.09536 75.7819 5.64847 74.3444 5.58872C72.9069 5.52897 71.4867 5.85991 70.318 6.52696V0H66.8277V17.7652H70.318V11.3009C70.318 8.54609 73.1575 8.32696 74.0251 8.32696C76.1942 8.32696 76.5097 9.93913 76.5097 10.9096V17.7809H80V10.9096C80.1053 9.42534 79.4674 7.96823 78.2253 6.85565ZM15.6766 13.5078C14.9976 14.0615 14.1848 14.5008 13.2869 14.7993C12.3891 15.0978 11.4245 15.2495 10.4511 15.2452C6.40868 15.2452 3.47054 12.7252 3.47054 9.26609C3.47054 5.7913 6.40868 3.2713 10.4511 3.2713C12.4033 3.2713 14.2568 3.88174 15.6569 4.99304L16.209 5.4313L18.6345 3.50609L18.102 3.06783C17.1015 2.26007 15.9073 1.61956 14.5899 1.18406C13.2724 0.748566 11.8584 0.526912 10.4314 0.532174C4.49593 0.532174 0 4.2887 0 9.28174C0 14.2435 4.49593 18 10.4314 18C13.3695 18 16.0907 17.0922 18.102 15.4487L18.6345 15.0104L16.2287 13.0539L15.6766 13.5078Z" fill="#17313B"/>
					</g>
					<defs>
					<clipPath id="clip0_2023_411">
					<rect width="80" height="18" fill="white"/>
					</clipPath>
					</defs>
				</svg>
					',
			'linkedin'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_2023_409)">
						<path d="M21.829 0H2.17099C0.972 0 0 0.972 0 2.17099V21.8289C0 23.028 0.972 24 2.17099 24H21.8289C23.028 24 24 23.028 24 21.8289V2.17099C24 0.972 23.028 0 21.829 0ZM7.42662 20.7232C7.42662 21.0721 7.14377 21.355 6.79483 21.355H4.10544C3.7565 21.355 3.47365 21.0721 3.47365 20.7232V9.4494C3.47365 9.10046 3.7565 8.81761 4.10544 8.81761H6.79483C7.14377 8.81761 7.42662 9.10046 7.42662 9.4494V20.7232ZM5.45014 7.75489C4.0391 7.75489 2.8952 6.61099 2.8952 5.19996C2.8952 3.78892 4.0391 2.64503 5.45014 2.64503C6.86117 2.64503 8.00507 3.78892 8.00507 5.19996C8.00507 6.61099 6.86124 7.75489 5.45014 7.75489ZM21.4813 20.7741C21.4813 21.0949 21.2212 21.355 20.9004 21.355H18.0145C17.6937 21.355 17.4335 21.0949 17.4335 20.7741V15.486C17.4335 14.6972 17.6649 12.0292 15.372 12.0292C13.5934 12.0292 13.2327 13.8553 13.1602 14.6749V20.7741C13.1602 21.0949 12.9002 21.355 12.5793 21.355H9.78817C9.46737 21.355 9.20727 21.0949 9.20727 20.7741V9.39851C9.20727 9.07772 9.46737 8.81761 9.78817 8.81761H12.5793C12.9001 8.81761 13.1602 9.07772 13.1602 9.39851V10.3821C13.8197 9.39236 14.7998 8.62844 16.8866 8.62844C21.5077 8.62844 21.4813 12.9457 21.4813 15.3178V20.7741Z" fill="#0077B7"/>
						</g>
						<defs>
						<clipPath id="clip0_2023_409">
						<rect width="24" height="24" fill="white"/>
						</clipPath>
						</defs>
					</svg>
					',
			'g2'         => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_2023_407)">
						<path d="M12 0C8.8174 0 5.76515 1.26428 3.51472 3.51472C1.26428 5.76515 0 8.8174 0 12C0 15.1826 1.26428 18.2348 3.51472 20.4853C5.76515 22.7357 8.8174 24 12 24C15.1826 24 18.2348 22.7357 20.4853 20.4853C22.7357 18.2348 24 15.1826 24 12C24 8.8174 22.7357 5.76515 20.4853 3.51472C18.2348 1.26428 15.1826 0 12 0ZM12.122 5.143C12.572 5.143 13.022 5.187 13.464 5.275L12.122 8.081C9.962 8.08 8.203 9.84 8.203 12C8.203 14.16 9.963 15.92 12.123 15.92C13.06 15.92 13.967 15.582 14.676 14.969L16.159 17.541C15.1365 18.2859 13.9277 18.7334 12.6666 18.8339C11.4055 18.9344 10.1412 18.684 9.01357 18.1104C7.88595 17.5368 6.93904 16.6624 6.27762 15.584C5.6162 14.5055 5.26608 13.2651 5.266 12C5.266 10.1817 5.98833 8.43783 7.27408 7.15208C8.55983 5.86633 10.3037 5.143 12.122 5.143ZM15.62 5.633C15.6287 5.63291 15.6373 5.63291 15.646 5.633C16.073 5.633 16.438 5.746 16.747 5.973C17.057 6.202 17.213 6.519 17.213 6.919C17.213 7.558 16.853 7.949 16.178 8.295L15.801 8.486C15.398 8.69 15.199 8.871 15.144 9.192H17.194V10.042H14.093V9.898C14.093 9.372 14.196 8.938 14.407 8.592C14.618 8.247 14.983 7.942 15.509 7.675L15.751 7.558C16.178 7.342 16.289 7.157 16.289 6.933C16.289 6.667 16.061 6.475 15.689 6.475C15.249 6.475 14.916 6.703 14.685 7.169L14.093 6.574C14.223 6.295 14.431 6.072 14.712 5.899C14.9834 5.7262 15.2983 5.63396 15.62 5.633ZM13.526 11.021H16.92L18.617 13.958L16.92 16.898L15.223 13.958H11.83L13.526 11.021Z" fill="#FF492C"/>
						</g>
						<defs>
						<clipPath id="clip0_2023_407">
						<rect width="24" height="24" fill="white"/>
						</clipPath>
						</defs>
					</svg>
					',
			'trustpilot' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_2023_405)">
						<path d="M17.227 16.67L19.417 23.412L12.004 18.024L17.227 16.67ZM24 9.30999H14.835L12.005 0.588989L9.165 9.31199L0 9.29999L7.422 14.697L4.582 23.411L12.004 18.024L16.587 14.697L24 9.30999Z" fill="#00B67A"/>
						</g>
						<defs>
						<clipPath id="clip0_2023_405">
						<rect width="24" height="24" fill="white"/>
						</clipPath>
						</defs>
					</svg>
					',
			'yelp'       => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_2023_401)">
						<path d="M7.6885 15.1415L4.017 15.9898C3.6401 16.0769 3.262 16.1728 2.8718 16.1448C2.6107 16.126 2.3596 16.1034 2.1112 15.9318C1.97698 15.8364 1.86423 15.714 1.7802 15.5724C1.4316 15.0205 1.4146 14.2063 1.4105 13.572C1.405 12.8703 1.51701 12.1726 1.7419 11.5078C1.77163 11.4229 1.80749 11.3402 1.8492 11.2604C1.88715 11.1861 1.92904 11.1138 1.9747 11.0439C2.02339 10.9754 2.07556 10.9095 2.131 10.8464C2.24264 10.7251 2.37859 10.6286 2.53 10.5633C2.67516 10.5023 2.83187 10.4738 2.9892 10.4796C3.2247 10.4812 3.5031 10.5316 3.8992 10.653C3.9547 10.6721 4.0229 10.6912 4.0848 10.7102C4.4125 10.8115 4.7896 10.9506 5.2347 11.1089C5.921 11.3493 6.601 11.5959 7.281 11.8486L8.4927 12.2909C8.7144 12.3716 8.929 12.4709 9.1339 12.5879C9.3079 12.6863 9.4612 12.8177 9.5851 12.9749C9.67659 13.1046 9.74182 13.251 9.7771 13.4058C9.84794 13.7137 9.79666 14.037 9.63404 14.3078C9.47142 14.5786 9.21013 14.7759 8.9051 14.858C8.8583 14.8731 8.8199 14.8819 8.7966 14.8873L7.6916 15.1426L7.6885 15.1415ZM18.8208 7.56501C18.7571 7.50166 18.6888 7.44304 18.6166 7.38961C18.5498 7.33958 18.4805 7.29305 18.4089 7.25021C18.3353 7.20987 18.2595 7.17348 18.182 7.14121C18.0287 7.08107 17.8645 7.05395 17.7 7.06161C17.5427 7.07059 17.3892 7.11368 17.2502 7.18791C17.0395 7.29271 16.8114 7.46111 16.5082 7.74301C16.4662 7.78471 16.4135 7.83161 16.3662 7.87601C16.116 8.11111 15.8376 8.40121 15.5063 8.73901C14.9958 9.25516 14.4903 9.77615 13.9897 10.3019L13.0935 11.2312C12.9294 11.4011 12.7801 11.5845 12.6469 11.7795C12.5334 11.9444 12.4531 12.1298 12.4105 12.3254C12.3859 12.4754 12.3895 12.6286 12.4212 12.7772L12.4258 12.7972C12.4965 13.1049 12.6839 13.3731 12.9485 13.5453C13.2131 13.7175 13.5343 13.7802 13.8442 13.7202C13.8814 13.7149 13.9182 13.7078 13.9547 13.6989L18.7328 12.5949C19.1094 12.5079 19.4915 12.4282 19.8298 12.2318C20.0567 12.1002 20.2726 11.9698 20.4207 11.7066C20.4997 11.562 20.5476 11.4025 20.5612 11.2383C20.6345 10.5871 20.2944 9.84751 20.0209 9.27531C19.7192 8.64219 19.3135 8.06409 18.8208 7.56501ZM8.9703 0.0754101C8.69126 0.114032 8.41426 0.166227 8.1403 0.23181C7.8649 0.29781 7.5923 0.37011 7.3257 0.45541C6.4577 0.73981 5.2373 1.26171 5.0307 2.26191C4.9142 2.82741 5.1902 3.40581 5.4044 3.92191C5.6639 4.54731 6.0184 5.11081 6.3417 5.69961C7.196 7.25411 8.0662 8.79891 8.9339 10.3453C9.1929 10.807 9.4755 11.3917 9.9769 11.6309C10.01 11.6454 10.0438 11.6582 10.0782 11.6692C10.303 11.7543 10.5481 11.7708 10.7823 11.7163C10.7963 11.7131 10.8102 11.7099 10.8241 11.7066C11.0405 11.6478 11.2363 11.5302 11.3899 11.3669C11.4176 11.3409 11.444 11.3135 11.4689 11.2847C11.8152 10.8497 11.8143 10.2014 11.8453 9.67131C11.9495 7.90031 12.0592 6.12901 12.1462 4.35711C12.1794 3.68591 12.2517 3.02381 12.2117 2.34751C12.1789 1.78961 12.1749 1.14911 11.8226 0.69121C11.2008 -0.11609 9.875 -0.0497899 8.9703 0.0754101ZM11.0543 16.0259C10.9192 15.8358 10.7273 15.6933 10.5063 15.6189C10.2852 15.5444 10.0463 15.5418 9.8237 15.6114C9.77137 15.6288 9.72037 15.6499 9.6711 15.6747C9.59496 15.7135 9.52233 15.7588 9.454 15.8101C9.2548 15.9576 9.0872 16.1493 8.9344 16.3416C8.8958 16.3906 8.8604 16.4559 8.8144 16.4978L8.0458 17.5551C7.6096 18.1473 7.17915 18.7436 6.7545 19.3441C6.4765 19.7336 6.2361 20.0625 6.0462 20.3535C6.0102 20.4082 5.9728 20.4695 5.9387 20.5182C5.711 20.8704 5.5821 21.1274 5.5159 21.3563C5.46624 21.5084 5.45054 21.6696 5.4699 21.8284C5.491 21.9939 5.5467 22.153 5.6334 22.2954C5.6794 22.3669 5.7291 22.436 5.7821 22.5024C5.83722 22.5664 5.89578 22.6273 5.9575 22.6849C6.02339 22.7478 6.09385 22.8057 6.1683 22.8581C6.6987 23.2271 7.2795 23.4923 7.8903 23.6972C8.39869 23.866 8.92711 23.967 9.4619 23.9976C9.5529 24.0022 9.644 24.0001 9.7347 23.9916C9.8188 23.9843 9.90245 23.9726 9.9853 23.9565C10.0681 23.9372 10.1498 23.9135 10.23 23.8855C10.3862 23.8271 10.5285 23.7365 10.6475 23.6197C10.7602 23.5067 10.8469 23.3707 10.9016 23.2208C10.9905 22.9994 11.0489 22.7182 11.0873 22.3008C11.0907 22.2415 11.0991 22.1703 11.105 22.105C11.1354 21.7587 11.1493 21.3519 11.1716 20.8735C11.2091 20.1378 11.2386 19.4054 11.2619 18.6709C11.2619 18.6709 11.3114 17.3656 11.3113 17.3649C11.3226 17.0641 11.3133 16.7307 11.2299 16.4313C11.1933 16.2877 11.134 16.1509 11.0543 16.0259ZM19.7297 18.0698C19.5692 17.8938 19.3419 17.7184 18.9835 17.5016C18.9317 17.4728 18.8711 17.4342 18.8151 17.4007C18.5166 17.2212 18.1571 17.0323 17.7371 16.8042C17.0927 16.451 16.4451 16.1036 15.7944 15.7622L14.6429 15.1515C14.5832 15.134 14.5226 15.0908 14.4663 15.0637C14.2451 14.9579 14.0105 14.8592 13.7671 14.8139C13.6832 14.7978 13.598 14.7889 13.5126 14.7874C13.4575 14.7868 13.4024 14.7901 13.3478 14.7974C13.1175 14.8332 12.9043 14.9407 12.7386 15.1047C12.573 15.2687 12.4632 15.4808 12.4251 15.7107C12.4076 15.857 12.4129 16.0051 12.441 16.1497C12.4973 16.4562 12.6342 16.7593 12.7756 17.0247L13.3906 18.1773C13.7328 18.8273 14.079 19.4736 14.4341 20.1179C14.6631 20.5381 14.8537 20.8978 15.0323 21.1959C15.0661 21.2519 15.1044 21.3122 15.1334 21.3641C15.3507 21.7225 15.5254 21.9481 15.7024 22.1099C15.817 22.2206 15.9544 22.3049 16.105 22.3569C16.2633 22.4094 16.431 22.4279 16.5969 22.4115C16.6813 22.4015 16.7651 22.387 16.8479 22.368C16.9296 22.346 17.0101 22.32 17.0889 22.2896C17.1741 22.2576 17.2568 22.2194 17.3364 22.1753C17.804 21.9131 18.2349 21.5904 18.6182 21.2156C19.0778 20.7634 19.4841 20.2702 19.8002 19.7056C19.8442 19.6256 19.8821 19.5426 19.914 19.4573C19.9438 19.3783 19.9696 19.2978 19.9913 19.2162C20.0099 19.1332 20.0243 19.0493 20.0342 18.9649C20.05 18.7991 20.0307 18.6318 19.9777 18.4739C19.9256 18.3227 19.8409 18.1847 19.7297 18.0698ZM22.5897 21.8118C22.5902 21.9603 22.552 22.1063 22.4787 22.2354C22.4047 22.3674 22.3007 22.4731 22.1672 22.5526C22.0347 22.6317 21.883 22.6728 21.7287 22.6716C21.5749 22.6727 21.4238 22.632 21.2914 22.5537C21.161 22.4776 21.0531 22.3681 20.9789 22.2366C20.9055 22.1071 20.8673 21.9607 20.8679 21.8118C20.8679 21.6592 20.9059 21.516 20.9822 21.3824C21.0568 21.2507 21.1657 21.1415 21.2972 21.0665C21.4281 20.9901 21.5771 20.9502 21.7287 20.9509C21.8794 20.9504 22.0276 20.9898 22.1581 21.0653C22.2899 21.1398 22.3991 21.2486 22.4741 21.3801C22.5505 21.5111 22.5904 21.6602 22.5897 21.8118ZM22.4695 21.8118C22.4695 21.679 22.4363 21.5558 22.3699 21.442C22.3035 21.3282 22.2135 21.2382 22.0997 21.1718C21.9876 21.1049 21.8593 21.0701 21.7287 21.0711C21.5987 21.0703 21.4709 21.1048 21.3589 21.1707C21.2466 21.2357 21.1531 21.3288 21.0876 21.4409C21.0213 21.5532 20.9869 21.6814 20.988 21.8118C20.988 21.9438 21.0212 22.0675 21.0876 22.1828C21.1524 22.2957 21.2461 22.3893 21.3589 22.4541C21.4713 22.519 21.5989 22.553 21.7287 22.5526C21.8587 22.5534 21.9865 22.519 22.0985 22.453C22.2105 22.3884 22.3036 22.2956 22.3687 22.1839C22.4356 22.0714 22.4704 21.9427 22.4695 21.8118ZM21.8925 21.8702L22.1649 22.3224H21.9727L21.7357 21.9172H21.5811V22.3224H21.4116V21.3024H21.7104C21.8372 21.3024 21.9299 21.3271 21.9887 21.3768C22.0482 21.4264 22.0779 21.502 22.0779 21.6035C22.0788 21.6615 22.0616 21.7183 22.0287 21.766C21.9967 21.8126 21.9512 21.8473 21.8925 21.8702ZM21.8513 21.7294C21.8692 21.7147 21.8835 21.6962 21.8932 21.6751C21.9029 21.6541 21.9078 21.6312 21.9073 21.608C21.9073 21.5507 21.8909 21.5099 21.8582 21.4855C21.8253 21.4604 21.7735 21.4478 21.7025 21.4478H21.5811V21.7763H21.7048C21.7658 21.7763 21.8146 21.7607 21.8513 21.7294Z" fill="#FF1A1A"/>
						</g>
						<defs>
						<clipPath id="clip0_2023_401">
						<rect width="24" height="24" fill="white"/>
						</clipPath>
						</defs>
						</svg>
						',
			'google'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_2024_401)">
						<path d="M17.4582 12C17.4591 13.3678 16.9773 14.6921 16.0976 15.7395C15.2178 16.787 13.9967 17.4903 12.6493 17.7257C11.3018 17.9611 9.91455 17.7134 8.73183 17.0262C7.54912 16.3391 6.64684 15.2566 6.18397 13.9694L2.85938 16.6291C3.89314 18.5942 5.55553 20.1563 7.5811 21.0659C9.60667 21.9755 11.8786 22.1802 14.0342 21.6473C16.1897 21.1144 18.1045 19.8746 19.4729 18.1259C20.8412 16.3772 21.5842 14.2204 21.5832 12" fill="#00AC47"/>
						<path d="M17.4608 12C17.46 12.9248 17.2383 13.8359 16.8141 14.6577C16.3899 15.4794 15.7755 16.1878 15.0221 16.724L18.3089 19.3534C19.3395 18.4255 20.1638 17.2915 20.7283 16.0247C21.2927 14.758 21.5849 13.3868 21.5858 12" fill="#4285F4"/>
						<path d="M5.83456 11.9995C5.836 11.3276 5.95471 10.6611 6.18534 10.0301L2.86074 7.37042C2.1048 8.79631 1.70956 10.3856 1.70956 11.9995C1.70956 13.6134 2.1048 15.2027 2.86074 16.6286L6.18534 13.9689C5.95471 13.3379 5.836 12.6714 5.83456 11.9995Z" fill="#FFBA00"/>
						<path d="M11.6457 6.18751C12.8756 6.18785 14.0733 6.58088 15.0642 7.30936L18.1092 4.46738C16.9789 3.4928 15.643 2.78608 14.2013 2.39995C12.7597 2.01382 11.2494 1.95826 9.78329 2.23741C8.31715 2.51656 6.93298 3.12322 5.73408 4.01211C4.53518 4.901 3.5525 6.04916 2.85938 7.37093L6.18397 10.0306C6.58944 8.90661 7.33119 7.93477 8.30839 7.24717C9.28559 6.55957 10.4508 6.18959 11.6457 6.18751Z" fill="#EA4435"/>
						<path d="M21.5846 11.25V12L19.8971 14.625H12.0221V10.5H20.8346C21.0335 10.5 21.2242 10.579 21.3649 10.7197C21.5055 10.8603 21.5846 11.0511 21.5846 11.25Z" fill="#4285F4"/>
						</g>
						<defs>
						<clipPath id="clip0_2024_401">
						<rect width="24" height="24" fill="white"/>
						</clipPath>
						</defs>
					</svg>
					',
			'facebook'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_2023_403)">
						<path d="M9.101 23.691V15.711H6.627V12.044H9.101V10.464C9.101 6.37901 10.949 4.48601 14.959 4.48601C15.36 4.48601 15.914 4.52801 16.427 4.58901C16.8112 4.62855 17.1924 4.69369 17.568 4.78401V8.10901C17.3509 8.08875 17.133 8.07675 16.915 8.07301C16.6707 8.06667 16.4264 8.06367 16.182 8.06401C15.475 8.06401 14.923 8.16001 14.507 8.37301C14.2273 8.51332 13.9922 8.72869 13.828 8.99501C13.57 9.41501 13.454 9.99001 13.454 10.747V12.044H17.373L16.987 14.147L16.7 15.711H13.454V23.956C19.396 23.238 24 18.179 24 12.044C24 5.41701 18.627 0.0440063 12 0.0440063C5.373 0.0440063 0 5.41701 0 12.044C0 17.672 3.874 22.394 9.101 23.691Z" fill="#0866FF"/>
						</g>
						<defs>
						<clipPath id="clip0_2023_403">
						<rect width="24" height="24" fill="white"/>
						</clipPath>
						</defs>
					</svg>
					',
		);

		$allowed_tags = array(
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'p',
			'div',
			'span',
		);

		$rating = array(
			'margin' => isset( $attributes['rating']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['rating']['margin'] ) : '',
			'size'   => isset( $attributes['rating']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['rating']['size'] ) : '',
			'color'  => array(
				'primary'   => isset( $attributes['rating']['color']['primary'] ) ? esc_attr( sanitize_text_field( $attributes['rating']['color']['primary'] ) ) : '',
				'secondary' => isset( $attributes['rating']['color']['secondary'] ) ? esc_attr( sanitize_text_field( $attributes['rating']['color']['secondary'] ) ) : '',
			),
		);

		$display_modes  = array(
			'testimonials-block-1',
			'testimonials-block-2',
			'testimonials-block-3',
			'testimonials-block-4',
			'testimonials-block-5',
			'testimonials-block-6',
		);
		$review_sources = array(
			// 'default',
			'google',
			'facebook',
			'yelp',
			'trustpilot',
			'clutch',
			'linkedin',
			'g2',
			'capterra',
		);

		$display = isset( $attributes['display'] ) && in_array( sanitize_text_field( $attributes['display'] ), $display_modes, true ) ? sanitize_text_field( $attributes['display'] ) : 'display-1';

		ob_start();
		foreach ( $testimonials as $index => $testimonial ) {
			$testimonial_rating        = get_post_meta( $testimonial->ID, 'ca_testimonial_rating', true );
			$testimonial_name          = get_post_meta( $testimonial->ID, 'ca_testimonial_name', true );
			$testimonial_role          = get_post_meta( $testimonial->ID, 'ca_testimonial_role', true );
			$testimonial_review_source = get_post_meta( $testimonial->ID, 'ca_testimonial_review_source', true );

			$title_tag = isset( $attributes['postTitle']['tag'] ) && in_array( $attributes['postTitle']['tag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['postTitle']['tag'] ) : 'h3';

			if ( 'testimonials-block-1' === $display ) {
				$classes   = array();
				$classes[] = 'cozy-block-' . $attributes['layout'];
				$classes[] = 'carousel' === $attributes['layout'] ? 'swiper-slide' : '';
				?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php
				if ( isset( $attributes['content']['thumbnail'], $attributes['content']['authorName'], $attributes['content']['authorRole'], $attributes['content']['reviewSource'] ) && ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['reviewSource'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					?>
					<div class="author-box">
					<?php
					if ( isset( $attributes['content']['thumbnail'], $attributes['content']['authorName'], $attributes['content']['authorRole'] ) && ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) ) ) {
						?>
						<div class="author-details">
						<?php
						if ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) && ! empty( get_the_post_thumbnail_url( $testimonial->ID ) ) ) {
							?>
							<figure class="author-thumbnail">
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( $testimonial->ID ) ); ?>" alt="<?php echo esc_attr( $testimonial_name ); ?>" />
							</figure>
							<?php
						}
						?>
							<div>
							<?php
							$title_tag = isset( $attributes['authorName']['tag'] ) && in_array( $attributes['authorName']['tag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['authorName']['tag'] ) : 'h4';

							if ( filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_name ) ) {
								printf( '<%1$s class="author-name">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial_name ) );
							}

							if ( filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_role ) ) {
								?>
								<p class="author-role"><?php echo esc_html( $testimonial_role ); ?></p>
								<?php
							}
							?>
							</div>
						</div>
							<?php
					}
					if ( filter_var( $attributes['content']['reviewSource'] ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
						?>
						<i class="review-icon" title="<?php echo esc_attr( ucfirst( $testimonial_review_source ) ); ?>">
							<?php echo $review_source_icons[ $testimonial_review_source ]; ?>
						</i>
						<?php
					}
					?>
					</div>
					<?php
				}

				$star          = array(
					'--rating'           => floatval( $testimonial_rating ) * 20 . '%',
					'--star-size'        => $rating['size'],
					'--star-color'       => $rating['color']['secondary'],
					'--start-fill-color' => $rating['color']['primary'],
				);
				$inline_styles = '';
				foreach ( $star as $key => $style ) {
					$inline_styles .= $key . ':' . $style . ';';
				}

				if ( isset( $attributes['content']['rating'] ) && filter_var( $attributes['content']['rating'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_rating ) ) {
					?>
					<div class="star-rating" style="<?php echo esc_attr( trim( $inline_styles, ';' ) ); ?>"></div>
					<?php
				}

				if ( isset( $attributes['content']['postContent'] ) && filter_var( $attributes['content']['postContent'], FILTER_VALIDATE_BOOLEAN ) ) {
					$excerpt = isset( $attributes['content']['excerpt'] ) ? sanitize_text_field( $attributes['content']['excerpt'] ) : '20';
					?>
					<p class="post-content"><?php echo esc_html( cozy_create_excerpt( $testimonial->post_content, $excerpt ) ); ?></p>
					<?php
				}
				?>
			</div>
				<?php
			} elseif ( 'testimonials-block-2' === $display ) {
				$classes   = array();
				$classes[] = 'cozy-block-' . $attributes['layout'];
				$classes[] = 'carousel' === $attributes['layout'] ? 'swiper-slide' : '';
				?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php
				if ( isset( $attributes['content']['postTitle'] ) && filter_var( $attributes['content']['postTitle'], FILTER_VALIDATE_BOOLEAN ) ) {
					printf( '<%1$s class="post-title">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial->post_title ) );
				}

				$star          = array(
					'--rating'           => floatval( $testimonial_rating ) * 20 . '%',
					'--star-size'        => $rating['size'],
					'--star-color'       => $rating['color']['secondary'],
					'--start-fill-color' => $rating['color']['primary'],
				);
				$inline_styles = '';
				foreach ( $star as $key => $style ) {
					$inline_styles .= $key . ':' . $style . ';';
				}

				if ( isset( $attributes['content']['rating'] ) && filter_var( $attributes['content']['rating'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_rating ) ) {
					?>
					<div class="star-rating" style="<?php echo esc_attr( trim( $inline_styles, ';' ) ); ?>"></div>
					<?php
				}

				if ( isset( $attributes['content']['postContent'] ) && filter_var( $attributes['content']['postContent'], FILTER_VALIDATE_BOOLEAN ) ) {
					$excerpt = isset( $attributes['content']['excerpt'] ) ? sanitize_text_field( $attributes['content']['excerpt'] ) : '20';
					?>
					<p class="post-content"><?php echo esc_html( cozy_create_excerpt( $testimonial->post_content, $excerpt ) ); ?></p>
					<?php
				}

				if ( isset( $attributes['content']['thumbnail'], $attributes['content']['authorName'], $attributes['content']['authorRole'], $attributes['content']['reviewSource'] ) && ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['reviewSource'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					?>
					<div class="author-box">
					<?php
					if ( isset( $attributes['content']['thumbnail'], $attributes['content']['authorName'], $attributes['content']['authorRole'] ) && ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) ) ) {
						?>
						<div class="author-details">
						<?php
						if ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) && ! empty( get_the_post_thumbnail_url( $testimonial->ID ) ) ) {
							?>
							<figure class="author-thumbnail">
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( $testimonial->ID ) ); ?>" alt="<?php echo esc_attr( $testimonial_name ); ?>" />
							</figure>
							<?php
						}
						?>
							<div>
							<?php
							$title_tag = isset( $attributes['authorName']['tag'] ) && in_array( $attributes['authorName']['tag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['authorName']['tag'] ) : 'h4';

							if ( filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_name ) ) {
								printf( '<%1$s class="author-name">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial_name ) );
							}

							if ( filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_role ) ) {
								?>
								<p class="author-role"><?php echo esc_html( $testimonial_role ); ?></p>
								<?php
							}
							?>
							</div>
						</div>
							<?php
					}
					if ( filter_var( $attributes['content']['reviewSource'] ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
						?>
						<i class="review-icon" title="<?php echo esc_attr( ucfirst( $testimonial_review_source ) ); ?>">
							<?php echo $review_source_icons[ $testimonial_review_source ]; ?>
						</i>
						<?php
					}
					?>
					</div>
					<?php
				}
				?>
			</div>
				<?php
			} elseif ( 'testimonials-block-3' === $display ) {
				$classes   = array();
				$classes[] = 'cozy-block-' . $attributes['layout'];
				$classes[] = 'carousel' === $attributes['layout'] ? 'swiper-slide' : '';
				?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<div class="flex-box">
					<?php
					if ( isset( $attributes['content']['thumbnail'] ) && ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) ) && ! empty( get_the_post_thumbnail_url( $testimonial->ID ) ) ) {
						?>
					<figure class="author-thumbnail">
						<img src="<?php echo esc_url( get_the_post_thumbnail_url( $testimonial->ID ) ); ?>" alt="<?php echo esc_attr( $testimonial_name ); ?>" />
					</figure>
						<?php
					}
					?>
					<div>
						<?php
						$star          = array(
							'--rating'           => floatval( $testimonial_rating ) * 20 . '%',
							'--star-size'        => $rating['size'],
							'--star-color'       => $rating['color']['secondary'],
							'--start-fill-color' => $rating['color']['primary'],
						);
						$inline_styles = '';
						foreach ( $star as $key => $style ) {
							$inline_styles .= $key . ':' . $style . ';';
						}

						if ( isset( $attributes['content']['thumbnail'] ) && filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_rating ) ) {
							?>
						<div class="star-rating" style="<?php echo esc_attr( trim( $inline_styles, ';' ) ); ?>"></div>
							<?php
						}

						if ( isset( $attributes['content']['postTitle'] ) && filter_var( $attributes['content']['postTitle'], FILTER_VALIDATE_BOOLEAN ) ) {
							printf( '<%1$s class="post-title">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial->post_title ) );
						}

						if ( isset( $attributes['content']['postContent'] ) && filter_var( $attributes['content']['postContent'], FILTER_VALIDATE_BOOLEAN ) ) {
							$excerpt = isset( $attributes['content']['excerpt'] ) ? sanitize_text_field( $attributes['content']['excerpt'] ) : '20';
							?>
						<p class="post-content"><?php echo esc_html( cozy_create_excerpt( $testimonial->post_content, $excerpt ) ); ?></p>
							<?php
						}

						if ( isset( $attributes['content']['authorName'], $attributes['content']['authorRole'] ) && ( filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) ) ) {
							?>
						<div class="author-box">
							<div class="author-details">
								<?php
								$title_tag = isset( $attributes['authorName']['tag'] ) && in_array( $attributes['authorName']['tag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['authorName']['tag'] ) : 'h4';

								if ( filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_name ) ) {
									printf( '<%1$s class="author-name">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial_name ) );
								}

								if ( filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_name ) && filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_role ) ) {
									?>
								<p class="separator">|</p>
									<?php
								}

								if ( filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_role ) ) {
									?>
									<p class="author-role"><?php echo esc_html( $testimonial_role ); ?></p>
									<?php
								}
								?>
							</div>
						</div>
							<?php
						}

						if ( isset( $attributes['content']['reviewSource'] ) && ! empty( $testimonial_review_source ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
							?>
						<div class="author-box">
							<?php
							if ( filter_var( $attributes['content']['reviewSource'] ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
								?>
							<i class="review-icon" title="<?php echo esc_attr( ucfirst( $testimonial_review_source ) ); ?>">
									<?php echo $review_source_icons[ $testimonial_review_source ]; ?>
							</i>
							<p>
									<?php
									esc_html_e( 'Verified ', 'cozy-addons' );
									echo esc_html( ucfirst( $testimonial_review_source ) );
									esc_html_e( ' Review', 'cozy-addons' );
									?>
							</p>
								<?php
							}
							?>
						</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
				<?php
			} elseif ( 'testimonials-block-4' === $display ) {
				$classes   = array();
				$classes[] = 'cozy-block-' . $attributes['layout'];
				$classes[] = 'carousel' === $attributes['layout'] ? 'swiper-slide' : '';
				?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<div class="flex-box">
					<div>
						<?php
						if ( isset( $attributes['content']['reviewSource'] ) && ! empty( $testimonial_review_source ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
							?>
						<div class="author-box">
							<?php
							if ( filter_var( $attributes['content']['reviewSource'] ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
								?>
							<i class="review-icon" title="<?php echo esc_attr( ucfirst( $testimonial_review_source ) ); ?>">
									<?php echo $review_source_icons[ $testimonial_review_source ]; ?>
							</i>
							<p>
									<?php
									esc_html_e( 'Verified ', 'cozy-addons' );
									echo esc_html( ucfirst( $testimonial_review_source ) );
									esc_html_e( ' Review', 'cozy-addons' );
									?>
							</p>
								<?php
							}
							?>
						</div>
							<?php
						}

						if ( isset( $attributes['content']['postContent'] ) && filter_var( $attributes['content']['postContent'], FILTER_VALIDATE_BOOLEAN ) ) {
							$excerpt = isset( $attributes['content']['excerpt'] ) ? sanitize_text_field( $attributes['content']['excerpt'] ) : '20';
							?>
						<p class="post-content"><?php echo esc_html( cozy_create_excerpt( $testimonial->post_content, $excerpt ) ); ?></p>
							<?php
						}

						if ( isset( $attributes['content']['authorName'], $attributes['content']['authorRole'] ) && ( filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) ) ) {
							?>
						<div class="author-box">
							<div class="author-details">
								<?php
								$title_tag = isset( $attributes['authorName']['tag'] ) && in_array( $attributes['authorName']['tag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['authorName']['tag'] ) : 'h4';

								if ( filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_name ) ) {
									printf( '<%1$s class="author-name">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial_name ) );
								}

								if ( filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_role ) ) {
									?>
									<p class="author-role"><?php echo esc_html( $testimonial_role ); ?></p>
									<?php
								}
								?>
							</div>
						</div>
							<?php
						}
						?>
					</div>
					<?php
					if ( isset( $attributes['content']['thumbnail'] ) && ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) ) && ! empty( get_the_post_thumbnail_url( $testimonial->ID ) ) ) {
						?>
					<figure class="author-thumbnail">
						<img src="<?php echo esc_url( get_the_post_thumbnail_url( $testimonial->ID ) ); ?>" alt="<?php echo esc_attr( $testimonial_name ); ?>" />
					</figure>
						<?php
					}
					?>
				</div>
			</div>
				<?php
			} elseif ( 'testimonials-block-5' === $display ) {
				$classes   = array();
				$classes[] = 'cozy-block-' . $attributes['layout'];
				$classes[] = 'carousel' === $attributes['layout'] ? 'swiper-slide' : '';
				?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php
				if ( isset( $attributes['content']['thumbnail'], $attributes['content']['authorName'], $attributes['content']['authorRole'] ) && ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					?>
						<div class="author-details">
						<?php
						if ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) && ! empty( get_the_post_thumbnail_url( $testimonial->ID ) ) ) {
							?>
							<figure class="author-thumbnail">
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( $testimonial->ID ) ); ?>" alt="<?php echo esc_attr( $testimonial_name ); ?>" />
							</figure>
							<?php
						}
						?>
							<div>
							<?php
							$title_tag = isset( $attributes['authorName']['tag'] ) && in_array( $attributes['authorName']['tag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['authorName']['tag'] ) : 'h4';

							if ( filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_name ) ) {
								printf( '<%1$s class="author-name">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial_name ) );
							}

							if ( filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_role ) ) {
								?>
								<p class="author-role"><?php echo esc_html( $testimonial_role ); ?></p>
								<?php
							}
							?>
							</div>
						</div>
							<?php
				}

				if ( isset( $attributes['content']['postTitle'] ) && filter_var( $attributes['content']['postTitle'], FILTER_VALIDATE_BOOLEAN ) ) {
					printf( '<%1$s class="post-title">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial->post_title ) );
				}

				if ( isset( $attributes['content']['postContent'] ) && filter_var( $attributes['content']['postContent'], FILTER_VALIDATE_BOOLEAN ) ) {
					$excerpt = isset( $attributes['content']['excerpt'] ) ? sanitize_text_field( $attributes['content']['excerpt'] ) : '20';
					?>
					<p class="post-content"><?php echo esc_html( cozy_create_excerpt( $testimonial->post_content, $excerpt ) ); ?></p>
					<?php
				}

				$star          = array(
					'--rating'           => floatval( $testimonial_rating ) * 20 . '%',
					'--star-size'        => $rating['size'],
					'--star-color'       => $rating['color']['secondary'],
					'--start-fill-color' => $rating['color']['primary'],
				);
				$inline_styles = '';
				foreach ( $star as $key => $style ) {
					$inline_styles .= $key . ':' . $style . ';';
				}

				if ( isset( $attributes['content']['rating'] ) && filter_var( $attributes['content']['rating'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_rating ) ) {
					?>
					<div class="star-rating" style="<?php echo esc_attr( trim( $inline_styles, ';' ) ); ?>"></div>
					<?php
				}

				if ( isset( $attributes['content']['reviewSource'] ) && ! empty( $testimonial_review_source ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
					?>
					<div class="author-box">
					<?php
					if ( filter_var( $attributes['content']['reviewSource'] ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
						?>
						<i class="review-icon" title="<?php echo esc_attr( ucfirst( $testimonial_review_source ) ); ?>">
							<?php echo $review_source_icons[ $testimonial_review_source ]; ?>
						</i>
						<p>
						<?php
						esc_html_e( 'Verified ', 'cozy-addons' );
						echo esc_html( ucfirst( $testimonial_review_source ) );
						esc_html_e( ' Review', 'cozy-addons' );
						?>
						</p>
						<?php
					}
					?>
					</div>
					<?php
				}
				?>
			</div>
				<?php
			} elseif ( 'testimonials-block-6' === $display ) {
				$classes   = array();
				$classes[] = 'cozy-block-' . $attributes['layout'];
				$classes[] = 'carousel' === $attributes['layout'] ? 'swiper-slide' : '';
				?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php

				if ( isset( $attributes['content']['reviewSource'] ) && ! empty( $testimonial_review_source ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
					?>
					<div class="author-box">
					<?php
					if ( filter_var( $attributes['content']['reviewSource'] ) && in_array( sanitize_text_field( $testimonial_review_source ), $review_sources, true ) ) {
						?>
						<i class="review-icon" title="<?php echo esc_attr( ucfirst( $testimonial_review_source ) ); ?>">
							<?php echo $review_source_icons[ $testimonial_review_source ]; ?>
						</i>
						<p>
						<?php
						esc_html_e( 'Verified ', 'cozy-addons' );
						echo esc_html( ucfirst( $testimonial_review_source ) );
						esc_html_e( ' Review', 'cozy-addons' );
						?>
						</p>
						<?php
					}
					?>
					</div>
					<?php
				}

				$star          = array(
					'--rating'           => floatval( $testimonial_rating ) * 20 . '%',
					'--star-size'        => $rating['size'],
					'--star-color'       => $rating['color']['secondary'],
					'--start-fill-color' => $rating['color']['primary'],
				);
				$inline_styles = '';
				foreach ( $star as $key => $style ) {
					$inline_styles .= $key . ':' . $style . ';';
				}

				if ( isset( $attributes['content']['rating'] ) && filter_var( $attributes['content']['rating'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_rating ) ) {
					?>
					<div class="star-rating" style="<?php echo esc_attr( trim( $inline_styles, ';' ) ); ?>"></div>
					<?php
				}

				if ( isset( $attributes['content']['postTitle'] ) && filter_var( $attributes['content']['postTitle'], FILTER_VALIDATE_BOOLEAN ) ) {
					printf( '<%1$s class="post-title">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial->post_title ) );
				}

				if ( isset( $attributes['content']['postContent'] ) && filter_var( $attributes['content']['postContent'], FILTER_VALIDATE_BOOLEAN ) ) {
					$excerpt = isset( $attributes['content']['excerpt'] ) ? sanitize_text_field( $attributes['content']['excerpt'] ) : '20';
					?>
					<p class="post-content"><?php echo esc_html( cozy_create_excerpt( $testimonial->post_content, $excerpt ) ); ?></p>
					<?php
				}

				if ( isset( $attributes['content']['thumbnail'], $attributes['content']['authorName'], $attributes['content']['authorRole'] ) && ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					?>
						<div class="author-details">
						<?php
						if ( filter_var( $attributes['content']['thumbnail'], FILTER_VALIDATE_BOOLEAN ) && ! empty( get_the_post_thumbnail_url( $testimonial->ID ) ) ) {
							?>
							<figure class="author-thumbnail">
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( $testimonial->ID ) ); ?>" alt="<?php echo esc_attr( $testimonial_name ); ?>" />
							</figure>
							<?php
						}
						?>
							<div>
							<?php
							$title_tag = isset( $attributes['authorName']['tag'] ) && in_array( $attributes['authorName']['tag'], $allowed_tags, true ) ? sanitize_text_field( $attributes['authorName']['tag'] ) : 'h4';

							if ( filter_var( $attributes['content']['authorName'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_name ) ) {
								printf( '<%1$s class="author-name">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $testimonial_name ) );
							}

							if ( filter_var( $attributes['content']['authorRole'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $testimonial_role ) ) {
								?>
								<p class="author-role"><?php echo esc_html( $testimonial_role ); ?></p>
								<?php
							}
							?>
							</div>
						</div>
							<?php
				}
				?>
			</div>
				<?php
			}
		}

		return ob_get_clean();
	}
}
