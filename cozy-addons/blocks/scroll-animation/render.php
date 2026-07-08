<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['clientId'] ) ) ) : '';
$cozy_block_var = 'cozyScrollAnimation_' . str_replace( '-', '_', $client_id );
wp_localize_script( 'cozy-block--scroll-animation--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--scroll-animation--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockScrollAnimationInit( "' . $client_id . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$vertical_scroll = array(
	'gap' => isset( $attributes['verticalScroll']['gap'] ) ? esc_attr( $attributes['verticalScroll']['gap'] ) : '',
);

$header_box = array(
	'width'          => isset( $attributes['headerBox']['width'] ) ? esc_attr( $attributes['headerBox']['width'] ) : '',
	'padding'        => isset( $attributes['headerBox']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['headerBox']['padding'] ) : '',
	'margin'         => isset( $attributes['headerBox']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['headerBox']['margin'] ) : '',
	'border'         => isset( $attributes['headerBox']['border'] ) ? cozy_render_TRBL( 'border', $attributes['headerBox']['border'] ) : '',
	'radius'         => isset( $attributes['headerBox']['radius'] ) ? esc_attr( $attributes['headerBox']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['headerBox']['font']['size'] ) ? esc_attr( $attributes['headerBox']['font']['size'] ) : '',
		'weight' => isset( $attributes['headerBox']['font']['weight'] ) ? esc_attr( $attributes['headerBox']['font']['weight'] ) : '',
		'family' => isset( $attributes['headerBox']['font']['family'] ) ? esc_attr( $attributes['headerBox']['font']['family'] ) : '',
	),
	'letter_case'    => isset( $attributes['headerBox']['letterCase'] ) ? esc_attr( $attributes['headerBox']['letterCase'] ) : '',
	'decoration'     => isset( $attributes['headerBox']['decoration'] ) ? esc_attr( $attributes['headerBox']['decoration'] ) : '',
	'line_height'    => isset( $attributes['headerBox']['lineHeight'] ) ? esc_attr( $attributes['headerBox']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['headerBox']['letterSpacing'] ) ? esc_attr( $attributes['headerBox']['letterSpacing'] ) : '',
	'color'          => array(
		'heading'             => isset( $attributes['headerBox']['color']['heading'] ) ? esc_attr( $attributes['headerBox']['color']['heading'] ) : '',
		'text'                => isset( $attributes['headerBox']['color']['text'] ) ? esc_attr( $attributes['headerBox']['color']['text'] ) : '',
		'bg'                  => isset( $attributes['headerBox']['color']['bg'] ) ? esc_attr( $attributes['headerBox']['color']['bg'] ) : '',
		'button'              => isset( $attributes['headerBox']['color']['button'] ) ? esc_attr( $attributes['headerBox']['color']['button'] ) : '',
		'button_bg'           => isset( $attributes['headerBox']['color']['buttonBg'] ) ? esc_attr( $attributes['headerBox']['color']['buttonBg'] ) : '',
		'button_hover'        => isset( $attributes['headerBox']['color']['buttonHover'] ) ? esc_attr( $attributes['headerBox']['color']['buttonHover'] ) : '',
		'button_bg_hover'     => isset( $attributes['headerBox']['color']['buttonBgHover'] ) ? esc_attr( $attributes['headerBox']['color']['buttonBgHover'] ) : '',
		'button_border_hover' => isset( $attributes['headerBox']['color']['buttonBorderHover'] ) ? esc_attr( $attributes['headerBox']['color']['buttonBorderHover'] ) : '',
	),
);
$heading    = array(
	'margin'         => isset( $attributes['headerBox']['heading']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['headerBox']['heading']['margin'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['headerBox']['heading']['font']['size'] ) ? esc_attr( $attributes['headerBox']['heading']['font']['size'] ) : '',
		'weight' => isset( $attributes['headerBox']['heading']['font']['weight'] ) ? esc_attr( $attributes['headerBox']['heading']['font']['weight'] ) : '',
		'family' => isset( $attributes['headerBox']['heading']['font']['family'] ) ? esc_attr( $attributes['headerBox']['heading']['font']['family'] ) : '',
	),
	'letter_case'    => isset( $attributes['headerBox']['heading']['letterCase'] ) ? esc_attr( $attributes['headerBox']['heading']['letterCase'] ) : '',
	'decoration'     => isset( $attributes['headerBox']['heading']['decoration'] ) ? esc_attr( $attributes['headerBox']['heading']['decoration'] ) : '',
	'line_height'    => isset( $attributes['headerBox']['heading']['lineHeight'] ) ? esc_attr( $attributes['headerBox']['heading']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['headerBox']['heading']['letterSpacing'] ) ? esc_attr( $attributes['headerBox']['heading']['letterSpacing'] ) : '',
);
$button     = array(
	'label'          => isset( $attributes['headerBox']['button']['label'] ) ? $attributes['headerBox']['button']['label'] : '',
	'link'           => isset( $attributes['headerBox']['button']['link'] ) && ! empty( $attributes['headerBox']['button']['link'] ) ? $attributes['headerBox']['button']['link'] : '#',
	'newTab'         => isset( $attributes['headerBox']['button']['newTab'] ) && filter_var( $attributes['headerBox']['button']['newTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '',
	'noFollow'       => isset( $attributes['headerBox']['button']['noFollow'] ) && filter_var( $attributes['headerBox']['button']['noFollow'], FILTER_VALIDATE_BOOLEAN ) ? 'nofollow' : '',
	'padding'        => isset( $attributes['headerBox']['button']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['headerBox']['button']['padding'] ) : '',
	'margin'         => isset( $attributes['headerBox']['button']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['headerBox']['button']['margin'] ) : '',
	'border'         => isset( $attributes['headerBox']['button']['border'] ) ? cozy_render_TRBL( 'border', $attributes['headerBox']['button']['border'] ) : '',
	'radius'         => isset( $attributes['headerBox']['button']['radius'] ) ? esc_attr( $attributes['headerBox']['button']['radius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['headerBox']['button']['font']['size'] ) ? esc_attr( $attributes['headerBox']['button']['font']['size'] ) : '',
		'weight' => isset( $attributes['headerBox']['button']['font']['weight'] ) ? esc_attr( $attributes['headerBox']['button']['font']['weight'] ) : '',
		'family' => isset( $attributes['headerBox']['button']['font']['family'] ) ? esc_attr( $attributes['headerBox']['button']['font']['family'] ) : '',
	),
	'letter_case'    => isset( $attributes['headerBox']['button']['letterCase'] ) ? esc_attr( $attributes['headerBox']['button']['letterCase'] ) : '',
	'decoration'     => isset( $attributes['headerBox']['button']['decoration'] ) ? esc_attr( $attributes['headerBox']['button']['decoration'] ) : '',
	'line_height'    => isset( $attributes['headerBox']['button']['lineHeight'] ) ? esc_attr( $attributes['headerBox']['button']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['headerBox']['button']['letterSpacing'] ) ? esc_attr( $attributes['headerBox']['button']['letterSpacing'] ) : '',
);

$list_scroll = array(
	'width'       => isset( $attributes['listScroll']['width'] ) ? esc_attr( $attributes['listScroll']['width'] ) : '',
	'gap'         => isset( $attributes['listScroll']['gap'] ) ? esc_attr( $attributes['listScroll']['gap'] ) : '',
	'tab_gap'     => isset( $attributes['listScroll']['tabGap'] ) ? esc_attr( $attributes['listScroll']['tabGap'] ) : '',
	'item_gap'    => isset( $attributes['listScroll']['itemGap'] ) ? esc_attr( $attributes['listScroll']['itemGap'] ) : '',
	'tab_justify' => isset( $attributes['listScroll']['tabJustify'] ) ? esc_attr( $attributes['listScroll']['tabJustify'] ) : '',
	'tab_styles'  => array(
		'container_padding' => isset( $attributes['listScroll']['tabStyles']['containerPadding'] ) ? cozy_render_TRBL( 'padding', $attributes['listScroll']['tabStyles']['containerPadding'] ) : '',
		'padding'           => isset( $attributes['listScroll']['tabStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['listScroll']['tabStyles']['padding'] ) : '',
		'border'            => isset( $attributes['listScroll']['tabStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['listScroll']['tabStyles']['border'] ) : '',
		'radius'            => isset( $attributes['listScroll']['tabStyles']['radius'] ) ? esc_attr( $attributes['listScroll']['tabStyles']['radius'] ) : '',
	),
	'title'       => array(
		'margin'         => isset( $attributes['listScroll']['title']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['listScroll']['title']['margin'] ) : '',
		'font'           => array(
			'size'   => isset( $attributes['listScroll']['title']['font']['size'] ) ? esc_attr( $attributes['listScroll']['title']['font']['size'] ) : '',
			'weight' => isset( $attributes['listScroll']['title']['font']['weight'] ) ? esc_attr( $attributes['listScroll']['title']['font']['weight'] ) : '',
			'family' => isset( $attributes['listScroll']['title']['font']['family'] ) ? esc_attr( $attributes['listScroll']['title']['font']['family'] ) : '',
		),
		'letter_case'    => isset( $attributes['listScroll']['title']['letterCase'] ) ? esc_attr( $attributes['listScroll']['title']['letterCase'] ) : '',
		'decoration'     => isset( $attributes['listScroll']['title']['decoration'] ) ? esc_attr( $attributes['listScroll']['title']['decoration'] ) : '',
		'line_height'    => isset( $attributes['listScroll']['title']['lineHeight'] ) ? esc_attr( $attributes['listScroll']['title']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['listScroll']['title']['letterSpacing'] ) ? esc_attr( $attributes['listScroll']['title']['letterSpacing'] ) : '',
	),
	'icon'        => array(
		'margin'     => isset( $attributes['listScroll']['icon']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['listScroll']['icon']['margin'] ) : '',
		'box_width'  => isset( $attributes['listScroll']['icon']['boxWidth'] ) ? esc_attr( $attributes['listScroll']['icon']['boxWidth'] ) : '',
		'box_height' => isset( $attributes['listScroll']['icon']['boxHeight'] ) ? esc_attr( $attributes['listScroll']['icon']['boxHeight'] ) : '',
		'border'     => isset( $attributes['icon']['border'] ) ? cozy_render_TRBL( 'border', $attributes['icon']['border'] ) : '',
		'radius'     => isset( $attributes['listScroll']['icon']['radius'] ) ? esc_attr( $attributes['listScroll']['icon']['radius'] ) : '',
		'size'       => isset( $attributes['listScroll']['icon']['size'] ) ? esc_attr( $attributes['listScroll']['icon']['size'] ) : '',
	),
	'progress'    => array(
		'margin' => isset( $attributes['listScroll']['progressBar']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['listScroll']['progressBar']['margin'] ) : '',
	),
	'color'       => array(
		'title'              => isset( $attributes['listScroll']['color']['title'] ) ? esc_attr( $attributes['listScroll']['color']['title'] ) : '',
		'icon'               => isset( $attributes['listScroll']['color']['icon'] ) ? esc_attr( $attributes['listScroll']['color']['icon'] ) : '',
		'icon_bg'            => isset( $attributes['listScroll']['color']['iconBg'] ) ? esc_attr( $attributes['listScroll']['color']['iconBg'] ) : '',
		'tab_bg'             => isset( $attributes['listScroll']['color']['tabBg'] ) ? esc_attr( $attributes['listScroll']['color']['tabBg'] ) : '',
		'active_text'        => isset( $attributes['listScroll']['color']['activeTabText'] ) ? esc_attr( $attributes['listScroll']['color']['activeTabText'] ) : '',
		'active_body'        => isset( $attributes['listScroll']['color']['activeTabBody'] ) ? esc_attr( $attributes['listScroll']['color']['activeTabBody'] ) : '',
		'active_bg'          => isset( $attributes['listScroll']['color']['activeTabBg'] ) ? esc_attr( $attributes['listScroll']['color']['activeTabBg'] ) : '',
		'active_border'      => isset( $attributes['listScroll']['color']['activeTabBorder'] ) ? esc_attr( $attributes['listScroll']['color']['activeTabBorder'] ) : '',
		'progress_primary'   => isset( $attributes['listScroll']['color']['progressPrimary'] ) ? esc_attr( $attributes['listScroll']['color']['progressPrimary'] ) : '',
		'progress_secondary' => isset( $attributes['listScroll']['color']['progressSecondary'] ) ? esc_attr( $attributes['listScroll']['color']['progressSecondary'] ) : '',
	),
);

$block_styles = "
#$block_id .cozy-block-sa-header-box {
	max-width: {$header_box['width']};
	{$header_box['padding']}
	{$header_box['margin']}
	{$header_box['border']}
	border-radius: {$header_box['radius']};
	align-items: {$attributes['headerBox']['align']};
	font-size: {$header_box['font']['size']};
	font-weight: {$header_box['font']['weight']};
	font-family: {$header_box['font']['family']};
	text-transform: {$header_box['letter_case']};
	text-decoration: {$header_box['decoration']};
	line-height: {$header_box['line_height']};
	letter-spacing: {$header_box['letter_spacing']};
	background-color: {$header_box['color']['bg']};
	color: {$header_box['color']['text']};
}
#$block_id .cozy-block-sa-header-box .header-box__heading {
	{$heading['margin']}
	font-size: {$heading['font']['size']};
	font-weight: {$heading['font']['weight']};
	font-family: {$heading['font']['family']};
	text-transform: {$heading['letter_case']};
	text-decoration: {$heading['decoration']};
	line-height: {$heading['line_height']};
	letter-spacing: {$heading['letter_spacing']};
	color: {$header_box['color']['heading']};
}
#$block_id .cozy-block-sa-header-box .header-box__button a {
	{$button['padding']}
	{$button['margin']}
	{$button['border']}
	border-radius: {$button['radius']};
	font-size: {$button['font']['size']};
	font-weight: {$button['font']['weight']};
	font-family: {$button['font']['family']};
	text-transform: {$button['letter_case']};
	text-decoration: {$button['decoration']};
	line-height: {$button['line_height']};
	letter-spacing: {$button['letter_spacing']};
	color: {$header_box['color']['button']};
	background-color: {$header_box['color']['button_bg']};
}
#$block_id .cozy-block-sa-header-box .header-box__button a:hover {
	color: {$header_box['color']['button_hover']};
	background-color: {$header_box['color']['button_bg_hover']};
	border-color: {$header_box['color']['button_border_hover']};
}

#$block_id.layout-default.scroll-type-vertical {
	gap: {$vertical_scroll['gap']};
}

#$block_id.layout-list.tab-display-inline {
	gap: {$list_scroll['gap']};
}
@media only screen and (max-width: 767px) {
	#$block_id.layout-list.tab-display-inline .list-item__tabs {
		justify-content: {$list_scroll['tab_justify']};
	}
}
#$block_id.layout-list.tab-display-block .list-item__tabs {
	justify-content: {$list_scroll['tab_justify']};
}
#$block_id.layout-list.tab-display-block .list-item__tabs.tab-position-left {
	margin-bottom: {$list_scroll['gap']};
}
#$block_id.layout-list.tab-display-block .list-item__tabs.tab-position-right {
	margin-top: {$list_scroll['gap']};
}
#$block_id.layout-list .list-item__tabs {
	width: {$list_scroll['width']};
	gap: {$list_scroll['tab_gap']};
	{$list_scroll['tab_styles']['container_padding']}
}
#$block_id.layout-list .list-item__tab {
	{$list_scroll['tab_styles']['padding']}
	{$list_scroll['tab_styles']['border']}
	border-radius: {$list_scroll['tab_styles']['radius']};
	background-color: {$list_scroll['color']['tab_bg']};

	&.is-active, &.is-active .tab__icon-wrapper {
		background-color: {$list_scroll['color']['active_bg']};
		border-color: {$list_scroll['color']['active_border']};
	}
	&.is-active .tab__icon-wrapper, &.is-active .tab__title {
		color: {$list_scroll['color']['active_text']};
	}
	&.is-active {
		color: {$list_scroll['color']['active_body']};
	}

	& .tab__progress-bar {
		{$list_scroll['progress']['margin']}
		background-color: {$list_scroll['color']['progress_secondary']};

		& .progress {
			background-color: {$list_scroll['color']['progress_primary']};
		}
	}
}
#$block_id.layout-list .tab__icon-wrapper {
	{$list_scroll['icon']['margin']}
	min-width: {$list_scroll['icon']['box_width']};
	height: {$list_scroll['icon']['box_height']};
	{$list_scroll['icon']['border']}
	border-radius: {$list_scroll['icon']['radius']};
	background-color: {$list_scroll['color']['icon_bg']};
	color: {$list_scroll['color']['icon']};

	& .tab__icon {
		width: {$list_scroll['icon']['size']};
		height: {$list_scroll['icon']['size']};
	}
}
#$block_id.layout-list .tab__title {
	{$list_scroll['title']['margin']}
	font-size: {$list_scroll['title']['font']['size']};
	font-weight: {$list_scroll['title']['font']['weight']};
	font-family: {$list_scroll['title']['font']['family']};
	text-transform: {$list_scroll['title']['letter_case']};
	text-decoration: {$list_scroll['title']['decoration']};
	line-height: {$list_scroll['title']['line_height']};
	letter-spacing: {$list_scroll['title']['letter_spacing']};
	color: {$list_scroll['color']['title']};
}
#$block_id.layout-list.variation-scroll .content__wrapper .cozy-block-scroll-item:not(:last-child) {
	margin-bottom: {$list_scroll['item_gap']};
}
";

$font_families = array();

if ( isset( $attributes['headerBox']['font']['family'] ) && ! empty( $attributes['headerBox']['font']['family'] ) ) {
	$font_families[] = $attributes['headerBox']['font']['family'];
}
if ( isset( $attributes['headerBox']['heading']['font']['family'] ) && ! empty( $attributes['headerBox']['heading']['font']['family'] ) ) {
	$font_families[] = $attributes['headerBox']['heading']['font']['family'];
}
if ( isset( $attributes['headerBox']['button']['font']['family'] ) && ! empty( $attributes['headerBox']['button']['font']['family'] ) ) {
	$font_families[] = $attributes['headerBox']['button']['font']['family'];
}
if ( isset( $attributes['listScroll']['title']['font']['family'] ) && ! empty( $attributes['listScroll']['title']['font']['family'] ) ) {
	$font_families[] = $attributes['listScroll']['title']['font']['family'];
}
// Remove duplicate font families.
$font_families = array_unique( $font_families );
$font_query    = '';
// Add other fonts.
foreach ( $font_families as $key => $family ) {
	if ( 0 === $key ) {
		$font_query .= 'family=' . str_replace( ' ', '+', $family ) . ':wght@100;200;300;400;500;600;700;800;900';
	} else {
		$font_query .= '&family=' . str_replace( ' ', '+', $family ) . ':wght@100;200;300;400;500;600;700;800;900';
	}
}
if ( ! empty( $font_query ) ) {
	// Generate the inline style for the Google Fonts link.
	$google_fonts_url = 'https://fonts.googleapis.com/css2?' . $font_query . '&display=swap';

	echo '<link rel="stylesheet" href="' . $google_fonts_url . '"/>';
}

$wrapper_attr = get_block_wrapper_attributes();

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$classes   = array();
$classes[] = 'cozy-block-wrapper';
$classes[] = 'block-wrapper-' . $client_id;
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
	<div <?php echo $wrapper_attr; ?>>
		<?php
		$classes   = array();
		$classes[] = 'cozy-block-scroll-animation';
		$classes[] = 'layout-' . $attributes['layout'];
		$classes[] = 'default' === $attributes['layout'] ? 'scroll-type-' . $attributes['scrollDirection'] : '';
		$classes[] = 'default' === $attributes['layout'] && 'vertical' === $attributes['scrollDirection'] && isset( $attributes['verticalScroll']['desktopOnly'] ) && filter_var( $attributes['verticalScroll']['desktopOnly'], FILTER_VALIDATE_BOOLEAN ) ? 'is-desktop-only' : '';
		$classes[] = 'default' === $attributes['layout'] && 'horizontal' === $attributes['scrollDirection'] ? 'swiper-container' : '';
		$classes[] = 'list' === $attributes['layout'] ? 'variation-' . $attributes['listScroll']['variation'] : '';
		$classes[] = 'list' === $attributes['layout'] && 'click' === $attributes['listScroll']['variation'] ? 'tab-display-' . $attributes['listScroll']['tabLayout'] : 'tab-display-inline';
		?>
		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" id="<?php echo esc_attr( $block_id ); ?>"> 
			<?php
			if ( isset( $attributes['headerBox']['enabled'], $attributes['headerBox']['elements']['heading'], $attributes['headerBox']['elements']['text'], $attributes['headerBox']['elements']['button'] ) && filter_var( $attributes['headerBox']['enabled'], FILTER_VALIDATE_BOOLEAN ) && ( filter_var( $attributes['headerBox']['elements']['heading'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['headerBox']['elements']['text'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['headerBox']['elements']['button'], FILTER_VALIDATE_BOOLEAN ) ) ) {
				?>
				<div class="cozy-block-sa-header-box">
					<div>
					<?php
					$allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
					$title_tag    = isset( $attributes['headerBox']['heading']['tag'] ) && in_array( $attributes['headerBox']['heading']['tag'], $allowed_tags, true ) ? $attributes['headerBox']['heading']['tag'] : 'h2';
					if ( filter_var( $attributes['headerBox']['elements']['heading'], FILTER_VALIDATE_BOOLEAN ) && isset( $attributes['headerBox']['heading']['content'] ) ) {
						printf( '<%1$s class="header-box__heading">%2$s</%1$s>', esc_attr( $title_tag ), esc_html( $attributes['headerBox']['heading']['content'] ) );
					}

					if ( filter_var( $attributes['headerBox']['elements']['text'], FILTER_VALIDATE_BOOLEAN ) && isset( $attributes['headerBox']['textContent'] ) ) {
						printf( '<p class="header-box__text">%1$s</p>', esc_html( $attributes['headerBox']['textContent'] ) );
					}
					?>
					</div>
					<?php
					if ( filter_var( $attributes['headerBox']['elements']['button'], FILTER_VALIDATE_BOOLEAN ) ) {
						?>
					<button class="header-box__button">
						<a href="<?php echo esc_url( $button['link'] ); ?>" target="<?php echo esc_attr( $button['newTab'] ); ?>" rel="<?php echo esc_attr( $button['noFollow'] ); ?>"><?php echo esc_html( $button['label'] ); ?></a>
					</button>
						<?php
					}
					?>
				</div>
				<?php
			}

			if ( 'default' === $attributes['layout'] && 'horizontal' === $attributes['scrollDirection'] ) {
				?>
			<div class="swiper-wrapper">
				<?php
			}

			if ( 'list' === $attributes['layout'] && 'left' === $attributes['listScroll']['tabPosition'] ) {
				echo \CozyAddons\Helpers\BlockRender::list_scroll_tab_render( $attributes );
			}

			if ( 'list' === $attributes['layout'] ) {
				echo '<div class="content__wrapper">';
			}
			echo $content;
			if ( 'list' === $attributes['layout'] ) {
				echo '</div>';
			}

			if ( 'list' === $attributes['layout'] && 'right' === $attributes['listScroll']['tabPosition'] ) {
				echo \CozyAddons\Helpers\BlockRender::list_scroll_tab_render( $attributes );
			}

			if ( 'default' === $attributes['layout'] && 'horizontal' === $attributes['scrollDirection'] ) {
				?>
			</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
