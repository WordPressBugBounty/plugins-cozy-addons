<?php
$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( $attributes['clientId'] ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

// wp_localize_script( 'cozy-block-scripts', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--categorized-post-tabs--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockCategorizedPostTabs( "' . $client_id . '" ) }) ' );

$header_box = array(
	'padding' => cozy_render_TRBL( 'padding', $attributes['headerBox']['padding'] ),
	'border'  => isset( $attributes['headerBox']['border'] ) ? cozy_render_TRBL( 'border', $attributes['headerBox']['border'] ) : '',
	'bg'      => isset( $attributes['headerBox']['color']['bg'] ) ? $attributes['headerBox']['color']['bg'] : '',
);

$heading = array(
	'padding'        => cozy_render_TRBL( 'padding', $attributes['headingStyles']['padding'] ),
	'border'         => isset( $attributes['headingStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['headingStyles']['border'] ) : '',
	'radius'         => cozy_render_TRBL( 'border-radius', $attributes['headingStyles']['radius'] ),
	'letter_case'    => isset( $attributes['headingStyles']['letterCase'] ) ? $attributes['headingStyles']['letterCase'] : '',
	'decoration'     => isset( $attributes['headingStyles']['decoration'] ) ? $attributes['headingStyles']['decoration'] : '',
	'line_height'    => isset( $attributes['headingStyles']['lineHeight'] ) ? $attributes['headingStyles']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['headingStyles']['letterSpacing'] ) ? $attributes['headingStyles']['letterSpacing'] : '',
	'bg'             => isset( $attributes['headingStyles']['color']['bg'] ) ? $attributes['headingStyles']['color']['bg'] : '',
	'text'           => isset( $attributes['headingStyles']['color']['text'] ) ? $attributes['headingStyles']['color']['text'] : '',
);

$tab_item = array(
	'padding'        => cozy_render_TRBL( 'padding', $attributes['tabStyles']['padding'] ),
	'border'         => isset( $attributes['tabStyles']['default']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['default']['border'] ) : '',
	'border_active'  => isset( $attributes['tabStyles']['active']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['active']['border'] ) : '',
	'bg'             => isset( $attributes['tabStyles']['color']['bg'] ) ? $attributes['tabStyles']['color']['bg'] : '',
	'bg_hover'       => isset( $attributes['tabStyles']['color']['bgHover'] ) ? $attributes['tabStyles']['color']['bgHover'] : '',
	'bg_active'      => isset( $attributes['tabStyles']['color']['bgActive'] ) ? $attributes['tabStyles']['color']['bgActive'] : '',
	'text'           => isset( $attributes['tabStyles']['color']['text'] ) ? $attributes['tabStyles']['color']['text'] : '',
	'text_hover'     => isset( $attributes['tabStyles']['color']['textHover'] ) ? $attributes['tabStyles']['color']['textHover'] : '',
	'text_active'    => isset( $attributes['tabStyles']['color']['textActive'] ) ? $attributes['tabStyles']['color']['textActive'] : '',
	'shadow'         => array(
		'horizontal' => isset( $attributes['tabStyles']['default']['shadow']['horizontal'] ) ? $attributes['tabStyles']['default']['shadow']['horizontal'] : '',
		'vertical'   => isset( $attributes['tabStyles']['default']['shadow']['vertical'] ) ? $attributes['tabStyles']['default']['shadow']['vertical'] : '',
		'blur'       => isset( $attributes['tabStyles']['default']['shadow']['blur'] ) ? $attributes['tabStyles']['default']['shadow']['blur'] : '',
		'spread'     => isset( $attributes['tabStyles']['default']['shadow']['spread'] ) ? $attributes['tabStyles']['default']['shadow']['spread'] : '',
		'color'      => isset( $attributes['tabStyles']['default']['shadow']['color'] ) ? $attributes['tabStyles']['default']['shadow']['color'] : '',
		'position'   => isset( $attributes['tabStyles']['default']['shadow']['position'] ) ? $attributes['tabStyles']['default']['shadow']['position'] : '',
	),
	'shadow_active'  => array(
		'horizontal' => isset( $attributes['tabStyles']['active']['shadow']['horizontal'] ) ? $attributes['tabStyles']['active']['shadow']['horizontal'] : '',
		'vertical'   => isset( $attributes['tabStyles']['active']['shadow']['vertical'] ) ? $attributes['tabStyles']['active']['shadow']['vertical'] : '',
		'blur'       => isset( $attributes['tabStyles']['active']['shadow']['blur'] ) ? $attributes['tabStyles']['active']['shadow']['blur'] : '',
		'spread'     => isset( $attributes['tabStyles']['active']['shadow']['spread'] ) ? $attributes['tabStyles']['active']['shadow']['spread'] : '',
		'color'      => isset( $attributes['tabStyles']['active']['shadow']['color'] ) ? $attributes['tabStyles']['active']['shadow']['color'] : '',
		'position'   => isset( $attributes['tabStyles']['active']['shadow']['position'] ) ? $attributes['tabStyles']['active']['shadow']['position'] : '',
	),
	'letter_case'    => isset( $attributes['tabStyles']['letterCase'] ) ? $attributes['tabStyles']['letterCase'] : '',
	'decoration'     => isset( $attributes['tabStyles']['decoration'] ) ? $attributes['tabStyles']['decoration'] : '',
	'line_height'    => isset( $attributes['tabStyles']['lineHeight'] ) ? $attributes['tabStyles']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['tabStyles']['letterSpacing'] ) ? $attributes['tabStyles']['letterSpacing'] : '',
);

$featured_image   = array(
	'margin' => array(
		'top'    => isset( $attributes['featuredPostOptions']['image']['margin']['top'] ) ? $attributes['featuredPostOptions']['image']['margin']['top'] : '',
		'bottom' => isset( $attributes['featuredPostOptions']['image']['margin']['bottom'] ) ? $attributes['featuredPostOptions']['image']['margin']['bottom'] : '',
	),
	'height' => isset( $attributes['featuredPostOptions']['image']['height'] ) ? $attributes['featuredPostOptions']['image']['height'] : '',
);
$featured_content = array(
	'outer_vgap'           => isset( $attributes['featuredPostOptions']['content']['outerVGap'] ) ? $attributes['featuredPostOptions']['content']['outerVGap'] : '0px',
	'outer_hgap'           => isset( $attributes['featuredPostOptions']['content']['outerHGap'] ) ? $attributes['featuredPostOptions']['content']['outerHGap'] : '0px',
	'padding'              => cozy_render_TRBL( 'padding', $attributes['featuredPostOptions']['content']['padding'] ),
	'border'               => isset( $attributes['featuredPostOptions']['content']['border'] ) ? cozy_render_TRBL( 'border', $attributes['featuredPostOptions']['content']['border'] ) : '',
	'bg'                   => isset( $attributes['featuredPostOptions']['content']['color']['bg'] ) ? $attributes['featuredPostOptions']['content']['color']['bg'] : '',
	'title_font_family'    => isset( $attributes['featuredPostOptions']['title']['font']['family'] ) ? $attributes['featuredPostOptions']['title']['font']['family'] : '',
	'title_decoration'     => isset( $attributes['featuredPostOptions']['title']['decoration'] ) ? $attributes['featuredPostOptions']['title']['decoration'] : '',
	'title_line_height'    => isset( $attributes['featuredPostOptions']['title']['lineHeight'] ) ? $attributes['featuredPostOptions']['title']['lineHeight'] : '',
	'title_letter_spacing' => isset( $attributes['featuredPostOptions']['title']['letterSpacing'] ) ? $attributes['featuredPostOptions']['title']['letterSpacing'] : '',
	'title_color'          => isset( $attributes['featuredPostOptions']['title']['color']['text'] ) ? $attributes['featuredPostOptions']['title']['color']['text'] : '',
	'title_color_hover'    => isset( $attributes['featuredPostOptions']['title']['color']['textHover'] ) ? $attributes['featuredPostOptions']['title']['color']['textHover'] : '',
);

$post_item    = array(
	'padding'      => cozy_render_TRBL( 'padding', $attributes['postBoxStyles']['padding'] ),
	'border'       => isset( $attributes['postBoxStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['postBoxStyles']['border'] ) : '',
	'bg'           => isset( $attributes['postBoxStyles']['color']['bg'] ) ? $attributes['postBoxStyles']['color']['bg'] : '',
	'bg_hover'     => isset( $attributes['postBoxStyles']['color']['bgHover'] ) ? $attributes['postBoxStyles']['color']['bgHover'] : '',
	'border_hover' => isset( $attributes['postBoxStyles']['color']['borderHover'] ) ? $attributes['postBoxStyles']['color']['borderHover'] : '',
	'shadow'       => array(
		'horizontal' => isset( $attributes['postBoxStyles']['shadow']['horizontal'] ) ? $attributes['postBoxStyles']['shadow']['horizontal'] : '',
		'vertical'   => isset( $attributes['postBoxStyles']['shadow']['vertical'] ) ? $attributes['postBoxStyles']['shadow']['vertical'] : '',
		'blur'       => isset( $attributes['postBoxStyles']['shadow']['blur'] ) ? $attributes['postBoxStyles']['shadow']['blur'] : '',
		'spread'     => isset( $attributes['postBoxStyles']['shadow']['spread'] ) ? $attributes['postBoxStyles']['shadow']['spread'] : '',
		'color'      => isset( $attributes['postBoxStyles']['shadow']['color'] ) ? $attributes['postBoxStyles']['shadow']['color'] : '',
		'position'   => isset( $attributes['postBoxStyles']['shadow']['position'] ) ? $attributes['postBoxStyles']['shadow']['position'] : '',
	),
	'shadow_hover' => array(
		'horizontal' => isset( $attributes['postBoxStyles']['shadowHover']['horizontal'] ) ? $attributes['postBoxStyles']['shadowHover']['horizontal'] : '',
		'vertical'   => isset( $attributes['postBoxStyles']['shadowHover']['vertical'] ) ? $attributes['postBoxStyles']['shadowHover']['vertical'] : '',
		'blur'       => isset( $attributes['postBoxStyles']['shadowHover']['blur'] ) ? $attributes['postBoxStyles']['shadowHover']['blur'] : '',
		'spread'     => isset( $attributes['postBoxStyles']['shadowHover']['spread'] ) ? $attributes['postBoxStyles']['shadowHover']['spread'] : '',
		'color'      => isset( $attributes['postBoxStyles']['shadowHover']['color'] ) ? $attributes['postBoxStyles']['shadowHover']['color'] : '',
		'position'   => isset( $attributes['postBoxStyles']['shadowHover']['position'] ) ? $attributes['postBoxStyles']['shadowHover']['position'] : '',
	),
);
$post_image   = array(
	'margin' => array(
		'top'    => isset( $attributes['postOptions']['image']['margin']['top'] ) ? $attributes['postOptions']['image']['margin']['top'] : '',
		'bottom' => isset( $attributes['postOptions']['image']['margin']['bottom'] ) ? $attributes['postOptions']['image']['margin']['bottom'] : '',
	),
	'width'  => isset( $attributes['postOptions']['image']['width'] ) ? $attributes['postOptions']['image']['width'] : '',
	'height' => isset( $attributes['postOptions']['image']['height'] ) ? $attributes['postOptions']['image']['height'] : '',
);
$post_content = array(
	'padding'              => cozy_render_TRBL( 'padding', $attributes['postOptions']['content']['padding'] ),
	'title_font_family'    => isset( $attributes['postOptions']['title']['font']['family'] ) ? $attributes['postOptions']['title']['font']['family'] : '',
	'title_decoration'     => isset( $attributes['postOptions']['title']['decoration'] ) ? $attributes['postOptions']['title']['decoration'] : '',
	'title_line_height'    => isset( $attributes['postOptions']['title']['lineHeight'] ) ? $attributes['postOptions']['title']['lineHeight'] : '',
	'title_letter_spacing' => isset( $attributes['postOptions']['title']['letterSpacing'] ) ? $attributes['postOptions']['title']['letterSpacing'] : '',
	'title_color'          => isset( $attributes['postOptions']['title']['color']['text'] ) ? $attributes['postOptions']['title']['color']['text'] : '',
	'title_color_hover'    => isset( $attributes['postOptions']['title']['color']['textHover'] ) ? $attributes['postOptions']['title']['color']['textHover'] : '',
);

$featured_cat_item = array(
	'border'         => isset( $attributes['featuredPostCategories']['border'] ) ? cozy_render_TRBL( 'border', $attributes['featuredPostCategories']['border'] ) : '',
	'radius'         => isset( $attributes['featuredPostCategories']['radius'] ) ? $attributes['featuredPostCategories']['radius'] : '',
	'font'           => array(
		'size'   => isset( $attributes['featuredPostCategories']['font']['size'] ) ? $attributes['featuredPostCategories']['font']['size'] : '',
		'family' => isset( $attributes['featuredPostCategories']['font']['family'] ) ? $attributes['featuredPostCategories']['font']['family'] : '',
		'weight' => isset( $attributes['featuredPostCategories']['font']['weight'] ) ? $attributes['featuredPostCategories']['font']['weight'] : '',
	),
	'letter_case'    => isset( $attributes['featuredPostCategories']['letterCase'] ) ? $attributes['featuredPostCategories']['letterCase'] : '',
	'decoration'     => isset( $attributes['featuredPostCategories']['decoration'] ) ? $attributes['featuredPostCategories']['decoration'] : '',
	'line_height'    => isset( $attributes['featuredPostCategories']['lineHeight'] ) ? $attributes['featuredPostCategories']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['featuredPostCategories']['letterSpacing'] ) ? $attributes['featuredPostCategories']['letterSpacing'] : '',
	'color'          => array(
		'text'         => isset( $attributes['featuredPostCategories']['color']['text'] ) ? $attributes['featuredPostCategories']['color']['text'] : '',
		'text_hover'   => isset( $attributes['featuredPostCategories']['color']['textHover'] ) ? $attributes['featuredPostCategories']['color']['textHover'] : '',
		'bg'           => isset( $attributes['featuredPostCategories']['color']['bg'] ) ? $attributes['featuredPostCategories']['color']['bg'] : '',
		'bg_hover'     => isset( $attributes['featuredPostCategories']['color']['bgHover'] ) ? $attributes['featuredPostCategories']['color']['bgHover'] : '',
		'border_hover' => isset( $attributes['featuredPostCategories']['color']['borderHover'] ) ? $attributes['featuredPostCategories']['color']['borderHover'] : '',
	),
);

$cat_item = array(
	'padding'        => cozy_render_TRBL( 'padding', $attributes['postCategories']['padding'] ),
	'border'         => isset( $attributes['postCategories']['border'] ) ? cozy_render_TRBL( 'border', $attributes['postCategories']['border'] ) : '',
	'font_family'    => isset( $attributes['postCategories']['font']['family'] ) ? $attributes['postCategories']['font']['family'] : '',
	'decoration'     => isset( $attributes['postCategories']['decoration'] ) ? $attributes['postCategories']['decoration'] : '',
	'line_height'    => isset( $attributes['postCategories']['lineHeight'] ) ? $attributes['postCategories']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['postCategories']['letterSpacing'] ) ? $attributes['postCategories']['letterSpacing'] : '',
	'text'           => isset( $attributes['postCategories']['color']['text'] ) ? $attributes['postCategories']['color']['text'] : '',
	'text_hover'     => isset( $attributes['postCategories']['color']['textHover'] ) ? $attributes['postCategories']['color']['textHover'] : '',
	'bg'             => isset( $attributes['postCategories']['color']['bg'] ) ? $attributes['postCategories']['color']['bg'] : '',
	'bg_hover'       => isset( $attributes['postCategories']['color']['bgHover'] ) ? $attributes['postCategories']['color']['bgHover'] : '',
	'border_hover'   => isset( $attributes['postCategories']['color']['borderHover'] ) ? $attributes['postCategories']['color']['borderHover'] : '',
);

$post_meta = array(
	'font_family'    => isset( $attributes['postMeta']['font']['family'] ) ? $attributes['postMeta']['font']['family'] : '',
	'decoration'     => isset( $attributes['postMeta']['decoration'] ) ? $attributes['postMeta']['decoration'] : '',
	'line_height'    => isset( $attributes['postMeta']['line_height'] ) ? $attributes['postMeta']['line_height'] : '',
	'letter_spacing' => isset( $attributes['postMeta']['letter_spacing'] ) ? $attributes['postMeta']['letter_spacing'] : '',
	'text'           => isset( $attributes['postMeta']['color']['text'] ) ? $attributes['postMeta']['color']['text'] : '',
	'text_hover'     => isset( $attributes['postMeta']['color']['textHover'] ) ? $attributes['postMeta']['color']['textHover'] : '',
	'featured'       => isset( $attributes['postMeta']['color']['featured'] ) ? $attributes['postMeta']['color']['featured'] : '',
	'featured_hover' => isset( $attributes['postMeta']['color']['featuredHover'] ) ? $attributes['postMeta']['color']['featuredHover'] : '',
);

$featured_read_more = array(
	'border'         => isset( $attributes['featuredReadMore']['border'] ) ? cozy_render_TRBL( 'border', $attributes['featuredReadMore']['border'] ) : '',
	'radius'         => isset( $attributes['featuredReadMore']['radius'] ) ? $attributes['featuredReadMore']['radius'] : '',
	'font'           => array(
		'size'   => isset( $attributes['featuredReadMore']['font']['size'] ) ? $attributes['featuredReadMore']['font']['size'] : '',
		'weight' => isset( $attributes['featuredReadMore']['font']['weight'] ) ? $attributes['featuredReadMore']['font']['weight'] : '',
		'family' => isset( $attributes['featuredReadMore']['font']['family'] ) ? $attributes['featuredReadMore']['font']['family'] : '',
	),
	'letter_case'    => isset( $attributes['featuredReadMore']['letterCase'] ) ? $attributes['featuredReadMore']['letterCase'] : '',
	'decoration'     => isset( $attributes['featuredReadMore']['decoration'] ) ? $attributes['featuredReadMore']['decoration'] : '',
	'line_height'    => isset( $attributes['featuredReadMore']['lineHeight'] ) ? $attributes['featuredReadMore']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['featuredReadMore']['letterSpacing'] ) ? $attributes['featuredReadMore']['letterSpacing'] : '',
	'color'          => array(
		'text'         => isset( $attributes['featuredReadMore']['color']['text'] ) ? $attributes['featuredReadMore']['color']['text'] : '',
		'text_hover'   => isset( $attributes['featuredReadMore']['color']['textHover'] ) ? $attributes['featuredReadMore']['color']['textHover'] : '',
		'bg'           => isset( $attributes['featuredReadMore']['color']['bg'] ) ? $attributes['featuredReadMore']['color']['bg'] : '',
		'bg_hover'     => isset( $attributes['featuredReadMore']['color']['bgHover'] ) ? $attributes['featuredReadMore']['color']['bgHover'] : '',
		'border_hover' => isset( $attributes['featuredReadMore']['color']['borderHover'] ) ? $attributes['featuredReadMore']['color']['borderHover'] : '',
	),
);

$read_more = array(
	'padding'        => cozy_render_TRBL( 'padding', $attributes['readMore']['padding'] ),
	'border'         => isset( $attributes['readMore']['border'] ) ? cozy_render_TRBL( 'border', $attributes['readMore']['border'] ) : '',
	'font_family'    => isset( $attributes['readMore']['font']['family'] ) ? $attributes['readMore']['font']['family'] : '',
	'decoration'     => isset( $attributes['readMore']['decoration'] ) ? $attributes['readMore']['decoration'] : '',
	'line_height'    => isset( $attributes['readMore']['lineHeight'] ) ? $attributes['readMore']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['readMore']['letterSpacing'] ) ? $attributes['readMore']['letterSpacing'] : '',
	'text'           => isset( $attributes['readMore']['color']['text'] ) ? $attributes['readMore']['color']['text'] : '',
	'text_hover'     => isset( $attributes['readMore']['color']['textHover'] ) ? $attributes['readMore']['color']['textHover'] : '',
	'bg'             => isset( $attributes['readMore']['color']['bg'] ) ? $attributes['readMore']['color']['bg'] : '',
	'bg_hover'       => isset( $attributes['readMore']['color']['bgHover'] ) ? $attributes['readMore']['color']['bgHover'] : '',
	'border_hover'   => isset( $attributes['readMore']['color']['borderHover'] ) ? $attributes['readMore']['color']['borderHover'] : '',
);

$col1 = isset( $attributes['postOptions']['column'] ) && $attributes['postOptions']['column'] <= 3 ? $attributes['postOptions']['column'] : 3;
$col2 = isset( $attributes['postOptions']['column'] ) && $attributes['postOptions']['column'] <= 2 ? $attributes['postOptions']['column'] : 2;

$block_styles = "
#$block_id .cozy-block-categorized-post-tabs__header {
    {$header_box['padding']}
    margin-top: {$attributes['headerBox']['margin']['top']};
    margin-bottom: {$attributes['headerBox']['margin']['bottom']};
    {$header_box['border']}
    border-radius: {$attributes['headerBox']['radius']};
    background-color: {$header_box['bg']};
    gap: {$attributes['headingGap']};
    justify-content: {$attributes['tabOptions']['justifyTab']};
}

#$block_id .cozy-block-categorized-post-tabs__heading {
    {$heading['padding']}
    {$heading['border']}
    {$heading['radius']}
    font-size: clamp(20px, calc(3vw + 4px), {$attributes['headingStyles']['font']['size']});
    font-weight: {$attributes['headingStyles']['font']['weight']};
    font-family: {$attributes['headingStyles']['font']['family']};
	text-transform: {$heading['letter_case']};
	text-decoration: {$heading['decoration']};
	line-height: {$heading['line_height']};
	letter-spacing: {$heading['letter_spacing']};
    background-color: {$heading['bg']};
    color: {$heading['text']};
}

#$block_id .cozy-block-categorized-post-tabs__tabs {
    gap: {$attributes['tabOptions']['gap']};
}

#$block_id .cozy-block-categorized-post-tabs__tab {
    {$tab_item['padding']}
    {$tab_item['border']}
    border-radius: {$attributes['tabStyles']['radius']};
    font-size: clamp(18px, calc(3vw + 4px), {$attributes['tabStyles']['font']['size']});
    font-weight: {$attributes['tabStyles']['font']['weight']};
    font-family: {$attributes['tabStyles']['font']['family']};
	text-transform: {$tab_item['letter_case']};
	text-decoration: {$tab_item['decoration']};
	line-height: {$tab_item['line_height']};
	letter-spacing: {$tab_item['letter_spacing']};
    background-color: {$tab_item['bg']};
    color: {$tab_item['text']};
}
#$block_id .item-has-default-shadow .cozy-block-categorized-post-tabs__tab {
    box-shadow: {$tab_item['shadow']['horizontal']}px {$tab_item['shadow']['vertical']}px {$tab_item['shadow']['blur']}px {$tab_item['shadow']['spread']}px {$tab_item['shadow']['color']} {$tab_item['shadow']['position']};
}
#$block_id .cozy-block-categorized-post-tabs__tab:hover {
    background-color: {$tab_item['bg_hover']};
    color: {$tab_item['text_hover']};
}
#$block_id .cozy-block-categorized-post-tabs__tab.active-tab {
    margin-bottom: {$attributes['tabStyles']['active']['marginBottom']}px;
    {$tab_item['border_active']}
    background-color: {$tab_item['bg_active']};
    color: {$tab_item['text_active']};
}
#$block_id .item-has-active-shadow .cozy-block-categorized-post-tabs__tab.active-tab {
    box-shadow: {$tab_item['shadow_active']['horizontal']}px {$tab_item['shadow_active']['vertical']}px {$tab_item['shadow_active']['blur']}px {$tab_item['shadow_active']['spread']}px {$tab_item['shadow_active']['color']} {$tab_item['shadow_active']['position']};
}

#$block_id .cozy-block-categorized-post-tabs__body.has-featured-post {
	column-gap: {$attributes['featuredPostOptions']['columnGap']};
}
@media only screen and (max-width: 767px) {
	#$block_id .cozy-block-categorized-post-tabs__body.has-featured-post {
		row-gap: {$attributes['featuredPostOptions']['rowGap']};
	}
}

#$block_id .featured-post__image {
	margin-top: {$featured_image['margin']['top']};
	margin-bottom: {$featured_image['margin']['bottom']};
	max-height: {$featured_image['height']};
}
#$block_id .featured-post__image img {
	height: {$featured_image['height']};
	border-radius: {$attributes['featuredPostOptions']['image']['radius']};
}
@media only screen and (max-width: 1024px) {
	#$block_id .featured-post__image img {
		max-height: {$featured_image['height']};
	}
}
#$block_id .featured-post__content-overlay-wrapper {
	padding: {$featured_content['outer_vgap']} {$featured_content['outer_hgap']};
	margin-top: {$attributes['featuredPostOptions']['content']['margin']['top']}px;
	margin-bottom: {$attributes['featuredPostOptions']['content']['margin']['bottom']};
}
#$block_id .featured-post__content-wrapper {
	{$featured_content['padding']}
	{$featured_content['border']}
	border-radius: {$attributes['featuredPostOptions']['content']['radius']};
	background-color: {$featured_content['bg']};
	position: {$attributes['featuredPostOptions']['content']['position']};
	text-align: {$attributes['featuredPostOptions']['textAlign']};
}
#$block_id .featured-post__meta.post__meta, #$block_id .featured-post__categories.post__categories {
	justify-content: {$attributes['featuredPostOptions']['textAlign']};
}

#$block_id .featured-post__category-item.post__category-item {
	{$featured_cat_item['border']}
	border-radius: {$featured_cat_item['radius']};
	font-size: {$featured_cat_item['font']['size']};
	font-weight: {$featured_cat_item['font']['weight']};
	font-family: {$featured_cat_item['font']['family']};
	text-transform: {$featured_cat_item['letter_case']};
	text-decoration: {$featured_cat_item['decoration']};
	line-height: {$featured_cat_item['line_height']};
	letter-spacing: {$featured_cat_item['letter_spacing']};
	color: {$featured_cat_item['color']['text']};
	background-color: {$featured_cat_item['color']['bg']};
}
#$block_id .featured-post__category-item.post__category-item:hover {
	color: {$featured_cat_item['color']['text_hover']};
	background-color: {$featured_cat_item['color']['bg_hover']};
	border-color: {$featured_cat_item['color']['border_hover']};
}

#$block_id .featured-post__title {
	margin-top: {$attributes['featuredPostOptions']['title']['margin']['top']};
	margin-bottom: {$attributes['featuredPostOptions']['title']['margin']['bottom']};
	font-size: clamp(16px, calc(3vw + 4px), {$attributes['featuredPostOptions']['title']['font']['size']});
	font-weight: {$attributes['featuredPostOptions']['title']['font']['weight']};
	font-family: {$featured_content['title_font_family']};
	text-transform: {$attributes['featuredPostOptions']['title']['letterCase']};
	line-height: {$featured_content['title_line_height']};
	letter-spacing: {$featured_content['title_letter_spacing']};
}
#$block_id .featured-post__title a {
	text-decoration: {$featured_content['title_decoration']};
	color: {$featured_content['title_color']};
}
#$block_id .featured-post__title:hover a {
	color: {$featured_content['title_color_hover']};
}

#$block_id .featured-post__meta.post__meta .display-flex {
	color: {$post_meta['featured']};
}
#$block_id .featured-post__meta.post__meta svg {
	fill: {$post_meta['featured']};
}
#$block_id .featured-post__meta.post__meta .display-flex:hover p {
	color: {$post_meta['featured_hover']};
}
#$block_id .featured-post__meta.post__meta .display-flex:hover svg {
	fill: {$post_meta['featured_hover']};
}

#$block_id .featured-post__content .post__read-more-link {
	{$featured_read_more['border']}
	border-radius: {$featured_read_more['radius']};
	font-size: {$featured_read_more['font']['size']};
	font-weight: {$featured_read_more['font']['weight']};
	font-family: {$featured_read_more['font']['family']};
	text-transform: {$featured_read_more['letter_case']};
	text-decoration: {$featured_read_more['decoration']};
	line-height: {$featured_read_more['line_height']};
	letter-spacing: {$featured_read_more['letter_spacing']};
	color: {$featured_read_more['color']['text']};
	background-color: {$featured_read_more['color']['bg']};
}
#$block_id .featured-post__content .post__read-more-link:hover {
	color: {$featured_read_more['color']['text_hover']};
	background-color: {$featured_read_more['color']['bg_hover']};
	border-color: {$featured_read_more['color']['border_hover']};
}

#$block_id .cozy-block-categorized-post-tabs__posts {
	grid-template-columns: repeat({$attributes['postOptions']['column']}, 1fr);
	gap: {$attributes['postOptions']['gap']};
	text-align: {$attributes['postOptions']['textAlign']};
}
@media screen and (max-width: 1024px) {
	#$block_id .cozy-block-categorized-post-tabs__posts {
		grid-template-columns: repeat({$col1}, 1fr);
	}
}
@media screen and (max-width: 767px) {
	#$block_id .cozy-block-categorized-post-tabs__posts {
		grid-template-columns: repeat({$col2}, 1fr);
	}
}
@media screen and (max-width: 420px) {
	#$block_id .cozy-block-categorized-post-tabs__posts {
		grid-template-columns: repeat(1, 1fr);
	}
}

#$block_id .cozy-block-categorized-post-tabs__post-item {
	{$post_item['padding']}
	margin-top: {$attributes['postBoxStyles']['margin']['top']};
	margin-bottom: {$attributes['postBoxStyles']['margin']['bottom']};
	{$post_item['border']}
	border-radius: {$attributes['postBoxStyles']['radius']};
	background-color: {$post_item['bg']};
}
#$block_id .cozy-block-categorized-post-tabs__post-item.has-box-shadow {
	box-shadow: {$post_item['shadow']['horizontal']}px {$post_item['shadow']['vertical']}px {$post_item['shadow']['blur']}px {$post_item['shadow']['spread']}px {$post_item['shadow']['color']} {$post_item['shadow']['position']}; 
}
#$block_id .cozy-block-categorized-post-tabs__post-item:hover {
	background-color: {$post_item['bg_hover']};
	border-color: {$post_item['border_hover']};
}
#$block_id .cozy-block-categorized-post-tabs__post-item.has-hover-box-shadow:hover {
	box-shadow: {$post_item['shadow_hover']['horizontal']}px {$post_item['shadow_hover']['vertical']}px {$post_item['shadow_hover']['blur']}px {$post_item['shadow_hover']['spread']}px {$post_item['shadow_hover']['color']} {$post_item['shadow_hover']['position']}; 
}
#$block_id .cozy-block-categorized-post-tabs__post-item.layout-invert {
	gap: {$attributes['postOptions']['content']['gap']};
}

#$block_id .post__image {
	margin-top: {$post_image['margin']['top']};
	margin-bottom: {$post_image['margin']['bottom']};
	max-height: {$post_image['height']};
}
#$block_id .cozy-block-categorized-post-tabs__post-item:not(.layout-invert) .post__image {
	max-width: {$post_image['width']};
}
#$block_id .layout-invert .post__image {
	min-width: {$post_image['width']};
}
#$block_id .post__image img {
	height: {$post_image['height']};
	border-radius: {$attributes['postOptions']['image']['radius']};
}
@media only screen and (max-width: 1024px) {
	#$block_id .post__image img {
		max-height: {$post_image['height']};
	}
}

#$block_id .post__content-wrapper {
	{$post_content['padding']}
}

#$block_id .post__categories {
	gap: {$attributes['postCategories']['gap']};
	margin-top: {$attributes['postCategories']['margin']['top']};
	margin-bottom: {$attributes['postCategories']['margin']['bottom']};
	justify-content: {$attributes['postOptions']['textAlign']};
}
#$block_id .post__category-item {
	{$cat_item['padding']}
	{$cat_item['border']}
	border-radius: {$attributes['postCategories']['radius']};
	font-size: {$attributes['postCategories']['font']['size']};
	font-weight: {$attributes['postCategories']['font']['weight']};
	font-family: {$cat_item['font_family']};
	text-transform: {$attributes['postCategories']['letterCase']};
	text-decoration: {$cat_item['decoration']};
	line-height: {$cat_item['line_height']};
	letter-spacing: {$cat_item['letter_spacing']};
	color: {$cat_item['text']};
	background-color: {$cat_item['bg']};
}
#$block_id .post__category-item:hover {
	color: {$cat_item['text_hover']};
	background-color: {$cat_item['bg_hover']};
	border-color: {$cat_item['border_hover']};
}

#$block_id .post__title {
	margin-top: {$attributes['postOptions']['title']['margin']['top']};
	margin-bottom: {$attributes['postOptions']['title']['margin']['bottom']};
	font-size: clamp(16px, calc(3vw + 4px), {$attributes['postOptions']['title']['font']['size']});
	font-weight: {$attributes['postOptions']['title']['font']['weight']};
	font-family: {$post_content['title_font_family']};
	text-transform: {$attributes['postOptions']['title']['letterCase']};
	line-height: {$post_content['title_line_height']};
	letter-spacing: {$post_content['title_letter_spacing']};
}
#$block_id .post__title a {
	text-decoration: {$post_content['title_decoration']};
	color: {$post_content['title_color']};
}
#$block_id .post__title:hover a {
	color: {$post_content['title_color_hover']};
}

#$block_id .post__meta {
	margin-top: {$attributes['postMeta']['margin']['top']};
	margin-bottom: {$attributes['postMeta']['margin']['bottom']};
	justify-content: {$attributes['postOptions']['textAlign']};
	font-size: {$attributes['postMeta']['font']['size']};
	font-weight: {$attributes['postMeta']['font']['weight']};
	font-family: {$post_meta['font_family']};
	text-transform: {$attributes['postMeta']['letterCase']};
	line-height: {$post_meta['line_height']};
	letter-spacing: {$post_meta['letter_spacing']};

}
#$block_id .post__meta a {
	text-decoration: {$post_meta['decoration']};
}
#$block_id .post__meta .display-flex {
	color: {$post_meta['text']};
}
#$block_id .post__meta svg {
	fill: {$post_meta['text']};
}
#$block_id .post__meta .display-flex:hover p {
	color: {$post_meta['text_hover']};
}
#$block_id .post__meta .display-flex:hover svg {
	fill: {$post_meta['text_hover']};
}

#$block_id .post__read-more {
	margin-top: {$attributes['readMore']['margin']['top']};
	margin-bottom: {$attributes['readMore']['margin']['bottom']};
	text-align: {$attributes['readMore']['textAlign']};
}
#$block_id .post__read-more-link {
	{$read_more['padding']}
	{$read_more['border']}
	border-radius: {$attributes['readMore']['radius']};
	font-size: {$attributes['readMore']['font']['size']};
	font-weight: {$attributes['readMore']['font']['weight']};
	font-family: {$read_more['font_family']};
	text-transform: {$attributes['readMore']['letterCase']};
	text-decoration: {$read_more['decoration']};
	line-height: {$read_more['line_height']};
	letter-spacing: {$read_more['letter_spacing']};
	color: {$read_more['text']};
	background-color: {$read_more['bg']};
}
#$block_id .post__read-more-link:hover {
	color: {$read_more['text_hover']};
	background-color: {$read_more['bg_hover']};
	border-color: {$read_more['border_hover']};
}
";

$classes   = array();
$classes[] = 'cozy-block-categorized-post-tabs';

$output = '<div class="' . implode( ' ', $classes ) . '" id="' . $block_id . '">';

$output .= '<article class="cozy-block-categorized-post-tabs__header">';

if ( $attributes['enableOptions']['heading'] ) {
	$output .= sprintf( '<%1$s class="cozy-block-categorized-post-tabs__heading">%2$s</%1$s>', $attributes['headingTag'], $attributes['headingLabel'] );
}

$classes   = array();
$classes[] = 'cozy-block-categorized-post-tabs__tabs';
$classes[] = isset( $attributes['tabStyles']['default']['shadow']['enabled'] ) ? 'item-has-default-shadow' : '';
$classes[] = isset( $attributes['tabStyles']['active']['shadow']['enabled'] ) ? 'item-has-active-shadow' : '';
$output   .= '<ul class="' . implode( ' ', $classes ) . '">';
if ( $attributes['tabOptions']['showDefaultTab'] ) {
	$output .= '<li class="cozy-block-categorized-post-tabs__tab active-tab" data-index="0">' . esc_html__( 'All', 'cozy-addons' ) . '</li>';
}
if ( ! empty( $attributes['selectedCategories'] ) ) {
	foreach ( $attributes['selectedCategories'] as $index => $identifier ) {
		$classes    = array();
		$classes[]  = 'cozy-block-categorized-post-tabs__tab';
		$classes[]  = ! $attributes['tabOptions']['showDefaultTab'] && 0 === $index ? 'active-tab' : '';
		$cat_data   = get_term( $identifier );
		$data_index = $attributes['tabOptions']['showDefaultTab'] ? $index + 1 : $index;
		$output    .= '<li class="' . implode( ' ', $classes ) . '" data-index="' . $data_index . '">';
		$output    .= esc_html( $cat_data->name );
		$output    .= '</li>';
	}
}
$output .= '</ul>';

$output .= '</article>';


/* Fetch Posts */
if ( ! function_exists( 'get_cozy_block_categorized_posts' ) ) {
	function get_cozy_block_categorized_posts( $args = array() ) {
		if ( ! empty( $args ) ) {
			$latest_posts         = new \WP_Query( $args );
			$additional_post_data = array();
			foreach ( $latest_posts->posts as $post ) {
				$post_image_url              = get_the_post_thumbnail_url( $post->ID );
				$post_link                   = get_permalink( $post->ID );
				$post_id                     = $post->ID;
				$post_data                   = (array) $post; // Convert WP_Post object to an array.
				$post_data['post_image_url'] = $post_image_url;

				// Get categories and their links.
				$categories      = get_the_category( $post->ID );
				$post_categories = array();
				foreach ( $categories as $category ) {
					$post_categories[] = array(
						'name'        => $category->name,
						'link'        => get_category_link( $category->term_id ),
						'count'       => $category->count,
						'description' => $category->description,
						'slug'        => $category->slug,
						'taxonomy'    => $category->taxonomy,
						'parent'      => $category->parent,
					);
				}
				$post_data['post_categories'] = $post_categories;

				$post_data['post_excerpt'] = get_the_excerpt( $post_id );

				$post_data['post_author_name']    = get_the_author_meta( 'display_name', $post->post_author ) ?? '';
				$post_data['post_author_url']     = get_author_posts_url( $post_data['post_author'] ) ?? '';
				$post_data['post_link']           = $post_link;
				$post_data['post_date_formatted'] = get_the_date( '', $post_id );
				$post_data['comment_link']        = get_comments_link( $post_id );
				$additional_post_data[]           = $post_data;
			}
			wp_reset_postdata();

			return $additional_post_data;
		}

		return array();
	}
}
/* Fetch Featured Post */
if ( ! function_exists( 'get_cozy_block_categorized_featured_post' ) ) {
	function get_cozy_block_categorized_featured_post( $post_id ) {
		$post_data            = get_post( $post_id );
		$additional_post_data = array();

		$post_image_url = get_the_post_thumbnail_url( $post_id );
		$post_link      = get_permalink( $post_id );

		$post_data                   = (array) $post_data; // Convert WP_Post object to an array.
		$post_data['post_image_url'] = $post_image_url;

		// Get categories and their links.
		$categories      = get_the_category( $post_id );
		$post_categories = array();
		foreach ( $categories as $category ) {
			$post_categories[] = array(
				'name'        => $category->name,
				'link'        => get_category_link( $category->term_id ),
				'count'       => $category->count,
				'description' => $category->description,
				'slug'        => $category->slug,
				'taxonomy'    => $category->taxonomy,
				'parent'      => $category->parent,
			);
		}
		$post_data['post_categories'] = $post_categories;

		$post_data['post_excerpt'] = get_the_excerpt( $post_id );

		$post_data['post_author_name']    = get_the_author_meta( 'display_name', $post_data['post_author'] ) ?? '';
		$post_data['post_author_url']     = get_author_posts_url( $post_data['post_author'] ) ?? '';
		$post_data['post_link']           = $post_link;
		$post_data['post_date_formatted'] = get_the_date( '', $post_id );
		$post_data['comment_link']        = get_comments_link( $post_id );
		$additional_post_data[]           = $post_data;
		// print_r( $additional_post_data );
		return $additional_post_data;
	}
}

/* Posts Render */
if ( ! function_exists( 'render_cozy_block_categorized_post_tabs_data' ) ) {
	function render_cozy_block_categorized_post_tabs_data( $attributes, $post_data, &$output ) {
		$classes   = array();
		$classes[] = 'cozy-block-categorized-post-tabs__post-item';
		$classes[] = 'layout-' . $attributes['postOptions']['content']['layout'];
		$classes[] = $attributes['postBoxStyles']['hoverEffect'] ? 'has-hover-effect' : '';
		$classes[] = $attributes['postBoxStyles']['shadow']['enabled'] ? 'has-box-shadow' : '';
		$classes[] = $attributes['postBoxStyles']['shadowHover']['enabled'] ? 'has-hover-box-shadow' : '';
		$classes[] = $attributes['postOptions']['imageOverlay'] ? 'has-image-overlay' : '';
		$output   .= '<li class="' . implode( ' ', $classes ) . '">';

		if ( $attributes['enableOptions']['postImage'] && ! empty( $post_data['post_image_url'] ) ) {
			$classes       = array();
			$classes[]     = 'post__image';
			$classes[]     = $attributes['postOptions']['image']['hoverEffect'] ? 'has-hover-effect' : '';
			$has_post_link = isset( $attributes['enableOptions']['imgLinkPost'] ) && $attributes['enableOptions']['imgLinkPost'] ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
			$open_new_tab  = isset( $attributes['enableOptions']['imgLinkPost'], $attributes['enableOptions']['imgOpenNewTab'] ) && $attributes['enableOptions']['imgLinkPost'] && $attributes['enableOptions']['imgOpenNewTab'] ? '_blank' : '';
			$output       .= '<figure class="' . implode( ' ', $classes ) . '"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener"><img src="' . $post_data['post_image_url'] . '" /></a></figure>';
		}

		$output .= '<div class="post__content-wrapper">';

		if ( $attributes['enableOptions']['postCategories'] && ! empty( $post_data['post_categories'] ) ) {
			$output .= '<div class="post__categories">';
			foreach ( $post_data['post_categories'] as $cat_data ) {
				$has_cat_link = isset( $attributes['enableOptions']['linkCat'] ) && $attributes['enableOptions']['linkCat'] ? 'href="' . esc_url( $cat_data['link'] ) . '"' : '';
				$open_new_tab = isset( $attributes['enableOptions']['linkCat'], $attributes['enableOptions']['catOpenNewTab'] ) && $attributes['enableOptions']['linkCat'] && $attributes['enableOptions']['catOpenNewTab'] ? '_blank' : '';
				$output      .= '<a class="post__category-item" ' . $has_cat_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $cat_data['name'] ) . '</a>';
			}
			$output .= '</div>';
		}

		$has_post_link      = isset( $attributes['enableOptions']['titleLinkPost'] ) && $attributes['enableOptions']['titleLinkPost'] ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
		$open_new_tab       = isset( $attributes['enableOptions']['titleLinkPost'], $attributes['enableOptions']['titleOpenNewTab'] ) && $attributes['enableOptions']['titleLinkPost'] && $attributes['enableOptions']['titleOpenNewTab'] ? '_blank' : '';
		$classes            = array();
		$classes[]          = 'post__title';
		$additional_classes = isset( $attributes['postOptions']['title']['className'] ) ? $attributes['postOptions']['title']['className'] : '';
		if ( ! empty( $additional_classes ) ) {
			$classes = array_merge( $classes, explode( ' ', $additional_classes ) );
		}
		$output .= '<h2 class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $post_data['post_title'] ) . '</a></h2>';

		if ( $attributes['enableOptions']['postAuthor'] || $attributes['enableOptions']['postComments'] || $attributes['enableOptions']['postDate'] ) {
			$output .= '<div class="post__meta">';

			$has_meta_link = isset( $attributes['enableOptions']['linkPostMeta'] ) && $attributes['enableOptions']['linkPostMeta'] ? true : false;
			$open_new_tab  = isset( $attributes['enableOptions']['linkPostMeta'], $attributes['enableOptions']['postMetaOpenNewTab'] ) && $attributes['enableOptions']['linkPostMeta'] && $attributes['enableOptions']['postMetaOpenNewTab'] ? '_blank' : '';
			$show_icon     = isset( $attributes['postMeta']['enableIcon'] ) && $attributes['postMeta']['enableIcon'] ? true : false;
			if ( $attributes['enableOptions']['postAuthor'] ) {
				$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_author_url'] ) . '"' : '';
				$output   .= '<a class="post__author display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
				if ( $show_icon ) {
					$output .= '<svg
											width="' . $attributes['postMeta']['font']['size'] . '"
											height="' . $attributes['postMeta']['font']['size'] . '"
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

			if ( $attributes['enableOptions']['postComments'] && intval( $post_data['comment_count'] ) > 0 ) {
				$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['comment_link'] ) . '"' : '';
				$output   .= '<a class="post__comments display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
				if ( $show_icon ) {
					$output .= '<svg
											width="' . $attributes['postMeta']['font']['size'] . '"
											height="' . $attributes['postMeta']['font']['size'] . '"
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

			if ( $attributes['enableOptions']['postDate'] ) {
				$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
				$output   .= '<a class="post__date display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
				if ( $show_icon ) {
					$output .= '<svg
											width="' . $attributes['postMeta']['font']['size'] . '"
											height="' . $attributes['postMeta']['font']['size'] . '"
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

		if ( $attributes['enableOptions']['postContent'] ) {
			$output .= '<div class="post__content">';

			$output .= '<div>';
			if ( isset( $post_data['post_excerpt'] ) && ! empty( $post_data['post_excerpt'] ) ) {
				$output .= $post_data['post_excerpt'];
			} else {
				$output .= cozy_create_excerpt( $post_data['post_content'], $attributes['enableOptions']['postExcerpt'] );
			}
			$output .= '</div>';

			if ( $attributes['enableOptions']['readMore'] ) {
				$open_new_tab = isset( $attributes['enableOptions']['readMoreNewTab'] ) && $attributes['enableOptions']['readMoreNewTab'] ? '_blank' : '';
				$output      .= '<span class="post__read-more"><a class="post__read-more-link" href="' . esc_url( $post_data['post_link'] ) . '" target="' . $open_new_tab . '" rel="noopener">' . esc_html__( 'Read More', 'cozy-addons' ) . '</a></span>';
			}
			$output .= '</div>';
		}

		$output .= '</div>';

		$output .= '</li>';
	}
}
/* Featured Post Render */
if ( ! function_exists( 'render_cozy_block_categorized_post_tabs_featured_data' ) ) {
	function render_cozy_block_categorized_post_tabs_featured_data( $attributes, $post_data, &$output ) {
		if ( ! empty( $post_data ) ) {
			$output   .= '<div class="cozy-block-categorized-post-tabs__featured-post-wrapper">';
			$classes   = array();
			$classes[] = 'cozy-block-categorized-post-tabs__featured-post';
			$classes[] = $attributes['featuredPostOptions']['imageOverlay'] ? 'has-image-overlay' : '';
			$classes[] = $attributes['featuredPostOptions']['sticky'] ? 'is-sticky' : '';
			$output   .= '<div class="' . implode( ' ', $classes ) . '">';
			if ( $attributes['enableOptions']['postImage'] ) {
				$classes       = array();
				$classes[]     = 'featured-post__image';
				$classes[]     = $attributes['postOptions']['image']['hoverEffect'] ? 'has-hover-effect' : '';
				$has_post_link = isset( $attributes['enableOptions']['imgLinkPost'] ) && $attributes['enableOptions']['imgLinkPost'] ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
				$open_new_tab  = isset( $attributes['enableOptions']['imgLinkPost'], $attributes['enableOptions']['imgOpenNewTab'] ) && $attributes['enableOptions']['imgLinkPost'] && $attributes['enableOptions']['imgOpenNewTab'] ? '_blank' : '';

				$output .= '<figure class="' . implode( ' ', $classes ) . '"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener"><img src="' . $post_data['post_image_url'] . '" /></a></figure>';
			}

			$output .= '<div class="featured-post__content-overlay-wrapper">';
			$output .= '<div class="featured-post__content-wrapper">';
			if ( isset( $attributes['enableOptions']['featuredPostCategories'] ) && $attributes['enableOptions']['featuredPostCategories'] && ! empty( $post_data['post_categories'] ) ) {
				$output .= '<div class="featured-post__categories post__categories">';
				foreach ( $post_data['post_categories'] as $cat_data ) {
					$has_cat_link = isset( $attributes['enableOptions']['linkCat'] ) && $attributes['enableOptions']['linkCat'] ? 'href="' . esc_url( $cat_data['link'] ) . '"' : '';
					$open_new_tab = isset( $attributes['enableOptions']['linkCat'], $attributes['enableOptions']['catOpenNewTab'] ) && $attributes['enableOptions']['linkCat'] && $attributes['enableOptions']['catOpenNewTab'] ? '_blank' : '';
					$output      .= '<a class="featured-post__category-item post__category-item" ' . $has_cat_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $cat_data['name'] ) . '</a>';
				}
				$output .= '</div>';
			}

			$has_post_link      = isset( $attributes['enableOptions']['titleLinkPost'] ) && $attributes['enableOptions']['titleLinkPost'] ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
			$open_new_tab       = isset( $attributes['enableOptions']['titleLinkPost'], $attributes['enableOptions']['titleOpenNewTab'] ) && $attributes['enableOptions']['titleLinkPost'] && $attributes['enableOptions']['titleOpenNewTab'] ? '_blank' : '';
			$classes            = array();
			$classes[]          = 'featured-post__title';
			$additional_classes = isset( $attributes['featuredPostOptions']['title']['className'] ) ? $attributes['featuredPostOptions']['title']['className'] : '';
			if ( ! empty( $additional_classes ) ) {
				$classes = array_merge( $classes, explode( ' ', $additional_classes ) );
			}
			$output .= '<h2 class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '"><a ' . $has_post_link . ' target="' . $open_new_tab . '" rel="noopener">' . esc_html( $post_data['post_title'] ) . '</a></h2>';

			if ( ( isset( $attributes['enableOptions']['featuredPostAuthor'] ) && $attributes['enableOptions']['featuredPostAuthor'] ) || ( isset( $attributes['enableOptions']['featuredPostComments'] ) && $attributes['enableOptions']['featuredPostComments'] ) || ( isset( $attributes['enableOptions']['featuredPostDate'] ) && $attributes['enableOptions']['featuredPostDate'] ) ) {
				$output       .= '<div class="featured-post__meta post__meta">';
				$has_meta_link = isset( $attributes['enableOptions']['linkPostMeta'] ) && $attributes['enableOptions']['linkPostMeta'] ? true : false;
				$open_new_tab  = isset( $attributes['enableOptions']['linkPostMeta'], $attributes['enableOptions']['postMetaOpenNewTab'] ) && $attributes['enableOptions']['linkPostMeta'] && $attributes['enableOptions']['postMetaOpenNewTab'] ? '_blank' : '';
				$show_icon     = isset( $attributes['postMeta']['enableIcon'] ) && $attributes['postMeta']['enableIcon'] ? true : false;

				if ( isset( $attributes['enableOptions']['featuredPostAuthor'] ) && $attributes['enableOptions']['featuredPostAuthor'] ) {
					$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_author_url'] ) . '"' : '';
					$output   .= '<a class="featured-post__author display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
					if ( $show_icon ) {
						$output .= '<svg
											width="' . $attributes['postMeta']['font']['size'] . '"
											height="' . $attributes['postMeta']['font']['size'] . '"
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

				if ( isset( $attributes['enableOptions']['featuredPostComments'] ) && $attributes['enableOptions']['featuredPostComments'] && intval( $post_data['comment_count'] ) > 0 ) {
					$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['comment_link'] ) . '"' : '';
					$output   .= '<a class="featured-post__comments display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
					if ( $show_icon ) {
						$output .= '<svg
											width="' . $attributes['postMeta']['font']['size'] . '"
											height="' . $attributes['postMeta']['font']['size'] . '"
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

				if ( isset( $attributes['enableOptions']['featuredPostDate'] ) && $attributes['enableOptions']['featuredPostDate'] ) {
					$meta_link = $has_meta_link ? 'href="' . esc_url( $post_data['post_link'] ) . '"' : '';
					$output   .= '<a class="featured-post__date display-flex" ' . $meta_link . ' target="' . $open_new_tab . '" rel="noopener">';
					if ( $show_icon ) {
						$output .= '<svg
											width="' . $attributes['postMeta']['font']['size'] . '"
											height="' . $attributes['postMeta']['font']['size'] . '"
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

			if ( isset( $attributes['enableOptions']['featuredPostContent'] ) && $attributes['enableOptions']['featuredPostContent'] ) {
				$output          .= '<div class="featured-post__content">';
				$featured_excerpt = isset( $attributes['enableOptions']['featuredPostExcerpt'] ) ? $attributes['enableOptions']['featuredPostExcerpt'] : 20;

				$output .= '<div>';
				if ( isset( $post_data['post_excerpt'] ) && ! empty( $post_data['post_excerpt'] ) ) {
					$output .= $post_data['post_excerpt'];
				} else {
					$output .= cozy_create_excerpt( $post_data['post_content'], $featured_excerpt );
				}
				$output .= '</div>';

				if ( isset( $attributes['enableOptions']['featuredReadMore'] ) && $attributes['enableOptions']['featuredReadMore'] ) {
					$open_new_tab = isset( $attributes['enableOptions']['readMoreNewTab'] ) && $attributes['enableOptions']['readMoreNewTab'] ? '_blank' : '';
					$output      .= '<span class="post__read-more post__read-more"><a class="post__read-more-link" href="' . esc_url( $post_data['post_link'] ) . '" target="' . $open_new_tab . '" rel="noopener">' . esc_html__( 'Read More', 'cozy-addons' ) . '</a></span>';
				}
				$output .= '</div>';
			}

			$output .= '</div>';
			$output .= '</div>';

			$output .= '</div>';
			$output .= '</div>';
		}
	}
}

// Tab content body for 'All' tab.
if ( $attributes['tabOptions']['showDefaultTab'] ) {
	$args = array(
		'post_type'      => 'post',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => $attributes['perPage'], // Number of popular posts to retrieve.
	);
	if ( $attributes['featuredPostOptions']['enabled'] ) {
		$featured_post_id = isset( $attributes['featuredPostOptions']['postID'] ) ? $attributes['featuredPostOptions']['postID'] : '';

		$args['post__not_in'] = array( $featured_post_id );
	}
	$additional_post_data = get_cozy_block_categorized_posts( $args );

	$featured_post_data = array();

	if ( $attributes['featuredPostOptions']['enabled'] ) {
		if ( 'default' === $attributes['featuredPostOptions']['source'] && ! empty( $additional_post_data ) ) {
			$featured_post_data = $additional_post_data[0];
			array_shift( $additional_post_data );
		} else {
			$featured_post_data = get_cozy_block_categorized_featured_post( $featured_post_id );
			if ( is_array( $featured_post_data ) ) {
				$featured_post_data = array_shift( $featured_post_data );
			}
		}
	}

	$classes   = array();
	$classes[] = 'cozy-block-categorized-post-tabs__body';
	$classes[] = $attributes['featuredPostOptions']['enabled'] ? 'has-featured-post' : '';
	$classes[] = 'active-content';
	$output   .= '<div class="' . implode( ' ', $classes ) . '">';

	if ( $attributes['featuredPostOptions']['enabled'] && 'left' === $attributes['featuredPostOptions']['position'] ) {
		render_cozy_block_categorized_post_tabs_featured_data( $attributes, $featured_post_data, $output );
	}

	if ( ! empty( $additional_post_data ) ) {
		$output .= '<ul class="cozy-block-categorized-post-tabs__posts">';
		foreach ( $additional_post_data as $key => $post_data ) {
			render_cozy_block_categorized_post_tabs_data( $attributes, $post_data, $output );
		}
		$output .= '</ul>';
	}

	if ( $attributes['featuredPostOptions']['enabled'] && 'right' === $attributes['featuredPostOptions']['position'] ) {
		render_cozy_block_categorized_post_tabs_featured_data( $attributes, $featured_post_data, $output );
	}
	$output .= '</div>';
}
// Tab content body for tabs
if ( ! empty( $attributes['selectedCategories'] ) ) {
	foreach ( $attributes['selectedCategories'] as $index => $identifier ) {
		// Filter the array to find the objects with the specified catID.
		$filtered_array = array_filter(
			$attributes['featuredPostOptions']['categoryFeatured'],
			function ( $item ) use ( $identifier ) {
				return intval( $item['catID'] ) === intval( $identifier );
			}
		);
		$cat_featured   = array();

		if ( is_array( $filtered_array ) ) {
			$cat_featured = array_shift( $filtered_array );
		}

		$args = array(
			'post_type'      => 'post',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => $attributes['perPage'], // Number of popular posts to retrieve.
			'category__in'   => array( $identifier ),
		);
		if ( $attributes['featuredPostOptions']['enabled'] ) {
			$featured_post_id     = isset( $cat_featured['postID'] ) ? $cat_featured['postID'] : '';
			$args['post__not_in'] = array( $featured_post_id );
		}

		$additional_post_data = get_cozy_block_categorized_posts( $args );

		$featured_post_data = array();

		if ( $attributes['featuredPostOptions']['enabled'] ) {
			if ( 'default' === $cat_featured['source'] && ! empty( $additional_post_data ) ) {
				$featured_post_data = $additional_post_data[0];
				array_shift( $additional_post_data );
			} else {
				$featured_post_data = get_cozy_block_categorized_featured_post( $featured_post_id );
				if ( is_array( $featured_post_data ) ) {
					$featured_post_data = array_shift( $featured_post_data );
				}
			}
		}

		$classes   = array();
		$classes[] = 'cozy-block-categorized-post-tabs__body';
		$classes[] = $attributes['featuredPostOptions']['enabled'] ? 'has-featured-post' : '';
		$classes[] = ! $attributes['tabOptions']['showDefaultTab'] && 0 === $index ? 'active-content' : '';
		$cat_data  = get_term( $identifier );
		$output   .= '<div class="' . implode( ' ', $classes ) . '">';
		if ( $attributes['featuredPostOptions']['enabled'] && 'left' === $attributes['featuredPostOptions']['position'] ) {
			render_cozy_block_categorized_post_tabs_featured_data( $attributes, $featured_post_data, $output );
		}

		if ( ! empty( $additional_post_data ) ) {
			$output .= '<ul class="cozy-block-categorized-post-tabs__posts">';
			foreach ( $additional_post_data as $key => $post_data ) {
				render_cozy_block_categorized_post_tabs_data( $attributes, $post_data, $output );
			}
			$output .= '</ul>';
		}

		if ( $attributes['featuredPostOptions']['enabled'] && 'right' === $attributes['featuredPostOptions']['position'] ) {
			render_cozy_block_categorized_post_tabs_featured_data( $attributes, $featured_post_data, $output );
		}
		$output .= '</div>';
	}
}

$output .= '</div>';

$wrapper_attributes = get_block_wrapper_attributes();

$font_families = array();

if ( isset( $attributes['headingStyles']['font']['family'] ) && ! empty( $attributes['headingStyles']['font']['family'] ) ) {
	$font_families[] = $attributes['headingStyles']['font']['family'];
}
if ( isset( $attributes['tabStyles']['font']['family'] ) && ! empty( $attributes['tabStyles']['font']['family'] ) ) {
	$font_families[] = $attributes['tabStyles']['font']['family'];
}
if ( isset( $attributes['featuredPostCategories']['font']['family'] ) && ! empty( $attributes['featuredPostCategories']['font']['family'] ) ) {
	$font_families[] = $attributes['featuredPostCategories']['font']['family'];
}
if ( isset( $attributes['postCategories']['font']['family'] ) && ! empty( $attributes['postCategories']['font']['family'] ) ) {
	$font_families[] = $attributes['postCategories']['font']['family'];
}
if ( isset( $attributes['featuredPostOptions']['title']['font']['family'] ) && ! empty( $attributes['featuredPostOptions']['title']['font']['family'] ) ) {
	$font_families[] = $attributes['featuredPostOptions']['title']['font']['family'];
}
if ( isset( $attributes['postOptions']['title']['font']['family'] ) && ! empty( $attributes['postOptions']['title']['font']['family'] ) ) {
	$font_families[] = $attributes['postOptions']['title']['font']['family'];
}
if ( isset( $attributes['postMeta']['font']['family'] ) && ! empty( $attributes['postMeta']['font']['family'] ) ) {
	$font_families[] = $attributes['postMeta']['font']['family'];
}
if ( isset( $attributes['featuredReadMore']['font']['family'] ) && ! empty( $attributes['featuredReadMore']['font']['family'] ) ) {
	$font_families[] = $attributes['featuredReadMore']['font']['family'];
}
if ( isset( $attributes['readMore']['font']['family'] ) && ! empty( $attributes['readMore']['font']['family'] ) ) {
	$font_families[] = $attributes['readMore']['font']['family'];
}

// Remove duplicate font families.
$font_families = array_unique( $font_families );

$font_query = '';

// Add other fonts.
foreach ( $font_families as $key => $family ) {
	if ( 0 === $key ) {
		$font_query .= 'family=' . $family . ':wght@100;200;300;400;500;600;700;800;900';
	} else {
		$font_query .= '&family=' . $family . ':wght@100;200;300;400;500;600;700;800;900';
	}
}

if ( ! empty( $font_query ) ) {
	// Generate the inline style for the Google Fonts link.
	$google_fonts_url = 'https://fonts.googleapis.com/css2?' . rawurlencode( $font_query );

	// Add the Google Fonts URL as an inline style.
	wp_add_inline_style( 'cozy-block--categorized-post-tabs--style', '@import url("' . rawurldecode( esc_url( $google_fonts_url ) ) . '");' );
}

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--categorized-post-tabs--style', esc_html( $block_styles ) );
	}
);

$render = sprintf( '<div class="cozy-block-wrapper"><div %1$s>%2$s</div></div>', $wrapper_attributes, $output );
echo $render;
