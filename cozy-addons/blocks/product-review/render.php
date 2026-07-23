<?php
use CozyAddons\Helpers\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozyProductReview_' . str_replace( '-', '_', $client_id );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$woo_product_comments = Utils::get_woo_product_reviews();

// Use array_filter to filter reviews.
$woo_product_comments = array_filter(
	$woo_product_comments,
	function ( $review ) use ( $attributes ) {
		return $review->product_rating >= $attributes['ratingFilter'];
	}
);

// Reindex the array to start from 0
$woo_product_comments = array_values( $woo_product_comments );

$attributes = array_merge( $attributes, array( 'woo_product_comments' => $woo_product_comments ) );

wp_localize_script( 'cozy-block--product-review--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--product-review--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockProductReviewInit( "' . esc_html( $client_id ) . '" ) }) ' );

$displayColumn1 = ( $attributes['gridOptions']['displayColumn'] <= 3 ) ? $attributes['gridOptions']['displayColumn'] : 3;
$displayColumn2 = ( $attributes['gridOptions']['displayColumn'] <= 2 ) ? $attributes['gridOptions']['displayColumn'] : 2;

$typography = array(
	'font'           => array(
		'size'   => isset( $attributes['typography']['fontSize'] ) ? esc_attr( $attributes['typography']['fontSize'] ) : '',
		'weight' => isset( $attributes['typography']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['typography']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['typography']['letterCase'] ) ? $attributes['typography']['letterCase'] : '',
	'decoration'     => isset( $attributes['typography']['decoration'] ) ? $attributes['typography']['decoration'] : '',
	'line_height'    => isset( $attributes['typography']['lineHeight'] ) ? $attributes['typography']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['typography']['letterSpacing'] ) ? $attributes['typography']['letterSpacing'] : '',
);

$container_styles = array(
	'padding'      => array(
		'top'    => isset( $attributes['containerStyles']['padding']['top'] ) ? esc_attr( $attributes['containerStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['containerStyles']['padding']['right'] ) ? esc_attr( $attributes['containerStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['containerStyles']['padding']['bottom'] ) ? esc_attr( $attributes['containerStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['containerStyles']['padding']['left'] ) ? esc_attr( $attributes['containerStyles']['padding']['left'] ) : '',
	),
	'border'       => array(
		'style'        => isset( $attributes['containerStyles']['border']['type'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['border']['type'] ) ) : '',
		'width_top'    => isset( $attributes['containerStyles']['border']['width']['top'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['top'] ) : '',
		'width_right'  => isset( $attributes['containerStyles']['border']['width']['right'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['right'] ) : '',
		'width_bottom' => isset( $attributes['containerStyles']['border']['width']['bottom'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['bottom'] ) : '',
		'width_left'   => isset( $attributes['containerStyles']['border']['width']['left'] ) ? esc_attr( $attributes['containerStyles']['border']['width']['left'] ) : '',
		'color'        => isset( $attributes['containerStyles']['border']['color'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['border']['color'] ) ) : '',
	),
	'radius'       => array(
		'top'    => isset( $attributes['containerStyles']['borderRadius']['top'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['top'] ) : '',
		'right'  => isset( $attributes['containerStyles']['borderRadius']['right'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['right'] ) : '',
		'bottom' => isset( $attributes['containerStyles']['borderRadius']['bottom'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['bottom'] ) : '',
		'left'   => isset( $attributes['containerStyles']['borderRadius']['left'] ) ? esc_attr( $attributes['containerStyles']['borderRadius']['left'] ) : '',
	),
	'shadow'       => array(
		'horizontal' => isset( $attributes['containerStyles']['boxShadow']['horizontal'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['horizontal'] ) : '',
		'vertical'   => isset( $attributes['containerStyles']['boxShadow']['vertical'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['vertical'] ) : '',
		'blur'       => isset( $attributes['containerStyles']['boxShadow']['blur'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['blur'] ) : '',
		'spread'     => isset( $attributes['containerStyles']['boxShadow']['spread'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['spread'] ) : '',
		'color'      => isset( $attributes['containerStyles']['boxShadow']['color'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['boxShadow']['color'] ) ) : '',
		'position'   => isset( $attributes['containerStyles']['boxShadow']['position'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['boxShadow']['position'] ) ) : '',
	),
	'shadow_hover' => array(
		'blur'   => isset( $attributes['containerStyles']['boxShadow']['blurHover'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['blurHover'] ) : '',
		'spread' => isset( $attributes['containerStyles']['boxShadow']['spreadHover'] ) ? esc_attr( $attributes['containerStyles']['boxShadow']['spreadHover'] ) : '',
		'color'  => isset( $attributes['containerStyles']['boxShadow']['colorHover'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['boxShadow']['colorHover'] ) ) : '',
	),
	'text'         => isset( $attributes['typography']['color'] ) ? esc_attr( sanitize_text_field( $attributes['typography']['color'] ) ) : '',
	'bg'           => isset( $attributes['containerStyles']['bgColor'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['bgColor'] ) ) : '',
	'border_hover' => isset( $attributes['containerStyles']['border']['colorHover'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['border']['colorHover'] ) ) : '',
	'bg_hover'     => isset( $attributes['containerStyles']['bgColorHover'] ) ? esc_attr( sanitize_text_field( $attributes['containerStyles']['bgColorHover'] ) ) : '',
);

$heading_styles = array(
	'margin'         => array(
		'bottom' => isset( $attributes['headingOptions']['verticalGap'] ) ? esc_attr( $attributes['headingOptions']['verticalGap'] ) : '',
	),
	'justify'        => isset( $attributes['headingOptions']['blockAlign'] ) ? esc_attr( sanitize_text_field( $attributes['headingOptions']['blockAlign'] ) ) : '',
	'gap'            => isset( $attributes['headingOptions']['gap'] ) ? esc_attr( $attributes['headingOptions']['gap'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['headingOptions']['fontSize'] ) ? esc_attr( $attributes['headingOptions']['fontSize'] ) : '',
		'weight' => isset( $attributes['headingOptions']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['headingOptions']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['headingOptions']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['headingOptions']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['headingOptions']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['headingOptions']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['headingOptions']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['headingOptions']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['headingOptions']['lineHeight'] ) ? esc_attr( $attributes['headingOptions']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['headingOptions']['letterSpacing'] ) ? esc_attr( $attributes['headingOptions']['letterSpacing'] ) : '',
);
$heading_color  = array(
	'text'      => isset( $attributes['headingOptions']['color'] ) ? esc_attr( $attributes['headingOptions']['color'] ) : '',
	'rating_bg' => isset( $attributes['headingOptions']['iconBgColor'] ) ? esc_attr( $attributes['headingOptions']['iconBgColor'] ) : '',
);

$grid = array(
	'column' => isset( $attributes['gridOptions']['displayColumn'] ) ? esc_attr( $attributes['gridOptions']['displayColumn'] ) : '',
	'gap'    => isset( $attributes['gridOptions']['columnGap'] ) ? esc_attr( $attributes['gridOptions']['columnGap'] ) : '',
	'align'  => isset( $attributes['gridOptions']['blockAlign'] ) ? esc_attr( sanitize_text_field( $attributes['gridOptions']['blockAlign'] ) ) : '',
);

$list = array(
	'gap'   => isset( $attributes['listOptions']['rowGap'] ) ? esc_attr( $attributes['listOptions']['rowGap'] ) : '',
	'align' => isset( $attributes['listOptions']['textAlign'] ) ? esc_attr( sanitize_text_field( $attributes['listOptions']['textAlign'] ) ) : '',
);

$img_styles = array(
	'width'  => isset( $attributes['reviewImage']['width'] ) ? esc_attr( $attributes['reviewImage']['width'] ) : '',
	'height' => isset( $attributes['reviewImage']['height'] ) ? esc_attr( $attributes['reviewImage']['height'] ) : '',
	'radius' => isset( $attributes['reviewImage']['borderRadius'] ) ? esc_attr( $attributes['reviewImage']['borderRadius'] ) : '',
);

$title_styles = array(
	'wrapper_margin' => array(
		'top'    => isset( $attributes['reviewContent']['margin']['top'] ) ? esc_attr( $attributes['reviewContent']['margin']['top'] ) : '',
		'right'  => isset( $attributes['reviewContent']['margin']['right'] ) ? esc_attr( $attributes['reviewContent']['margin']['right'] ) : '',
		'bottom' => isset( $attributes['reviewContent']['margin']['bottom'] ) ? esc_attr( $attributes['reviewContent']['margin']['bottom'] ) : '',
		'left'   => isset( $attributes['reviewContent']['margin']['left'] ) ? esc_attr( $attributes['reviewContent']['margin']['left'] ) : '',
	),
	'margin'         => array(
		'left' => isset( $attributes['reviewTitle']['marginLeft'] ) ? esc_attr( $attributes['reviewTitle']['marginLeft'] ) : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['reviewTitle']['titleTypography']['fontSize'] ) ? esc_attr( $attributes['reviewTitle']['titleTypography']['fontSize'] ) : '',
		'weight' => isset( $attributes['reviewTitle']['titleTypography']['fontWeight'] ) ? esc_attr( $attributes['reviewTitle']['titleTypography']['fontWeight'] ) : '',
		'family' => isset( $attributes['reviewTitle']['titleTypography']['fontFamily'] ) ? esc_attr( $attributes['reviewTitle']['titleTypography']['fontFamily'] ) : '',
	),
	'rating_size'    => isset( $attributes['reviewTitle']['ratingSize'] ) ? esc_attr( $attributes['reviewTitle']['ratingSize'] ) : '',
	'letter_case'    => isset( $attributes['reviewTitle']['titleTypography']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['reviewTitle']['titleTypography']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['reviewTitle']['titleTypography']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['reviewTitle']['titleTypography']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['reviewTitle']['titleTypography']['lineHeight'] ) ? esc_attr( $attributes['reviewTitle']['titleTypography']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['reviewTitle']['titleTypography']['letterSpacing'] ) ? esc_attr( $attributes['reviewTitle']['titleTypography']['letterSpacing'] ) : '',
);
$title_color  = array(
	'text'       => isset( $attributes['reviewTitle']['textColor'] ) ? esc_attr( $attributes['reviewTitle']['textColor'] ) : '',
	'text_hover' => isset( $attributes['reviewTitle']['titleColorHover'] ) ? esc_attr( $attributes['reviewTitle']['titleColorHover'] ) : '',
);

$loader_styles = array(
	'margin'         => array(
		'top' => isset( $attributes['ajaxButton']['marginTop'] ) ? esc_attr( $attributes['ajaxButton']['marginTop'] ) : '',
	),
	'padding'        => array(
		'top'    => isset( $attributes['ajaxButton']['padding']['top'] ) ? esc_attr( $attributes['ajaxButton']['padding']['top'] ) : '',
		'right'  => isset( $attributes['ajaxButton']['padding']['right'] ) ? esc_attr( $attributes['ajaxButton']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['ajaxButton']['padding']['bottom'] ) ? esc_attr( $attributes['ajaxButton']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['ajaxButton']['padding']['left'] ) ? esc_attr( $attributes['ajaxButton']['padding']['left'] ) : '',
	),
	'border'         => array(
		'style' => isset( $attributes['ajaxButton']['border']['type'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxButton']['border']['type'] ) ) : '',
		'width' => isset( $attributes['ajaxButton']['border']['width'] ) ? esc_attr( $attributes['ajaxButton']['border']['width'] ) : '',
	),
	'radius'         => isset( $attributes['ajaxButton']['borderRadius'] ) ? esc_attr( $attributes['ajaxButton']['borderRadius'] ) : '',
	'font'           => array(
		'size'   => isset( $attributes['ajaxButton']['fontSize'] ) ? esc_attr( $attributes['ajaxButton']['fontSize'] ) : '',
		'weight' => isset( $attributes['ajaxButton']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxButton']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['ajaxButton']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxButton']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['ajaxButton']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxButton']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['ajaxButton']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['ajaxButton']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['ajaxButton']['lineHeight'] ) ? esc_attr( $attributes['ajaxButton']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['ajaxButton']['letterSpacing'] ) ? esc_attr( $attributes['ajaxButton']['letterSpacing'] ) : '',
);
$loader_color  = array(
	'border'       => isset( $attributes['ajaxButton']['border']['color'] ) ? esc_attr( $attributes['ajaxButton']['border']['color'] ) : '',
	'text'         => isset( $attributes['ajaxButton']['color'] ) ? esc_attr( $attributes['ajaxButton']['color'] ) : '',
	'bg'           => isset( $attributes['ajaxButton']['bgColor'] ) ? esc_attr( $attributes['ajaxButton']['bgColor'] ) : '',
	'border_hover' => isset( $attributes['ajaxButton']['border']['colorHover'] ) ? esc_attr( $attributes['ajaxButton']['border']['colorHover'] ) : '',
	'text_hover'   => isset( $attributes['ajaxButton']['colorHover'] ) ? esc_attr( $attributes['ajaxButton']['colorHover'] ) : '',
	'bg_hover'     => isset( $attributes['ajaxButton']['bgColorHover'] ) ? esc_attr( $attributes['ajaxButton']['bgColorHover'] ) : '',
);

$nav       = array(
	'size'       => isset( $attributes['navigation']['iconSize'] ) ? esc_attr( $attributes['navigation']['iconSize'] ) : '',
	'box_width'  => isset( $attributes['navigation']['iconBoxWidth'] ) ? esc_attr( $attributes['navigation']['iconBoxWidth'] ) : '',
	'box_height' => isset( $attributes['navigation']['iconBoxHeight'] ) ? esc_attr( $attributes['navigation']['iconBoxHeight'] ) : '',
	'border'     => isset( $attributes['navigation']['border'] ) ? cozy_render_TRBL( 'border', $attributes['navigation']['border'] ) : '',
	'radius'     => isset( $attributes['navigation']['borderRadius'] ) ? esc_attr( $attributes['navigation']['borderRadius'] ) : '',
	'top'        => isset( $attributes['navigation']['verticalPosition'] ) ? esc_attr( $attributes['navigation']['verticalPosition'] ) : '',
);
$nav_color = array(
	'icon'         => isset( $attributes['navigation']['color'] ) ? esc_attr( $attributes['navigation']['color'] ) : '',
	'bg'           => isset( $attributes['navigation']['backgroundColor'] ) ? esc_attr( $attributes['navigation']['backgroundColor'] ) : '',
	'icon_hover'   => isset( $attributes['navigation']['colorHover'] ) ? esc_attr( $attributes['navigation']['colorHover'] ) : '',
	'bg_hover'     => isset( $attributes['navigation']['backgroundColorHover'] ) ? esc_attr( $attributes['navigation']['backgroundColorHover'] ) : '',
	'border_hover' => isset( $attributes['navigation']['borderHover'] ) ? esc_attr( $attributes['navigation']['borderHover'] ) : '',
);

$bullet       = array(
	'bottom' => isset( $attributes['pagination']['verticalPosition'] ) ? esc_attr( $attributes['pagination']['verticalPosition'] ) : '',
	'align'  => isset( $attributes['pagination']['align'] ) ? $attributes['pagination']['align'] : 'center',
	'left'   => isset( $attributes['pagination']['align'], $attributes['pagination']['left'] ) && 'left' === $attributes['pagination']['align'] ? 'padding-left: ' . $attributes['pagination']['left'] . ';' : '',
	'right'  => isset( $attributes['pagination']['align'], $attributes['pagination']['right'] ) && 'right' === $attributes['pagination']['align'] ? 'padding-right: ' . $attributes['pagination']['right'] . ';' : '',
	'width'  => isset( $attributes['pagination']['width'] ) ? esc_attr( $attributes['pagination']['width'] ) : '',
	'height' => isset( $attributes['pagination']['height'] ) ? esc_attr( $attributes['pagination']['height'] ) : '',
	'radius' => isset( $attributes['pagination']['borderRadius'] ) ? esc_attr( $attributes['pagination']['borderRadius'] ) : '',
	'active' => array(
		'width'  => isset( $attributes['pagination']['activeWidth'] ) ? esc_attr( $attributes['pagination']['activeWidth'] ) : '',
		'height' => isset( $attributes['pagination']['activeHeight'] ) ? esc_attr( $attributes['pagination']['activeHeight'] ) : '',
		'border' => isset( $attributes['pagination']['activeBorder'] ) ? cozy_render_TRBL( 'outline', $attributes['pagination']['activeBorder'] ) : '',
		'radius' => isset( $attributes['pagination']['activeBorderRadius'] ) ? esc_attr( $attributes['pagination']['activeBorderRadius'] ) : '',
		'offset' => isset( $attributes['pagination']['activeOffset'] ) ? $attributes['pagination']['activeOffset'] : '',
	),
	'gap'    => isset( $attributes['pagination']['gap'] ) ? $attributes['pagination']['gap'] : '',
);
$bullet_color = array(
	'default_bg'       => isset( $attributes['pagination']['color'] ) ? $attributes['pagination']['color'] : '',
	'active_bg'        => isset( $attributes['pagination']['activeColor'] ) ? $attributes['pagination']['activeColor'] : '',
	'default_bg_hover' => isset( $attributes['pagination']['colorHover'] ) ? $attributes['pagination']['colorHover'] : '',
	'active_bg_hover'  => isset( $attributes['pagination']['activeColorHover'] ) ? $attributes['pagination']['activeColorHover'] : '',
);

$block_styles = "
#$block_id {
    font-size: {$typography['font']['size']}px;
    font-weight: {$typography['font']['weight']};
    font-family: {$typography['font']['family']};
    text-transform: {$typography['letter_case']};
    text-decoration: {$typography['decoration']};
    line-height: {$typography['line_height']};
    letter-spacing: {$typography['letter_spacing']};
    color: {$container_styles['text']};
}
#$block_id .woo-product-review {
    padding-top: {$container_styles['padding']['top']}px;
    padding-right: {$container_styles['padding']['right']}px;
    padding-bottom: {$container_styles['padding']['bottom']}px;
    padding-left: {$container_styles['padding']['left']}px;
    border-style: {$container_styles['border']['style']};
    border-top-width: {$container_styles['border']['width_top']}px;
    border-right-width: {$container_styles['border']['width_right']}px;
    border-bottom-width: {$container_styles['border']['width_bottom']}px;
    border-left-width: {$container_styles['border']['width_left']}px;
    border-color: {$container_styles['border']['color']};
    background-color: {$container_styles['bg']};
    border-top-left-radius: {$container_styles['radius']['top']}px;
    border-top-right-radius: {$container_styles['radius']['right']}px;
    border-bottom-right-radius: {$container_styles['radius']['bottom']}px;
    border-bottom-left-radius: {$container_styles['radius']['left']}px;
}
#$block_id.has-box-shadow .woo-product-review {
    box-shadow: {$container_styles['shadow']['horizontal']}px {$container_styles['shadow']['vertical']}px {$container_styles['shadow']['blur']}px {$container_styles['shadow']['spread']}px {$container_styles['shadow']['color']} {$container_styles['shadow']['position']};
}
#$block_id .woo-product-review:hover {
    border-color: {$container_styles['border_hover']};
    background-color: {$container_styles['bg_hover']};
}
#$block_id.has-box-shadow .woo-product-review:hover {
    box-shadow: {$container_styles['shadow']['horizontal']}px {$container_styles['shadow']['vertical']}px {$container_styles['shadow_hover']['blur']}px {$container_styles['shadow_hover']['spread']}px {$container_styles['shadow_hover']['color']} {$container_styles['shadow']['position']};
}
#$block_id .review-heading-wrapper {
    margin-bottom: {$heading_styles['margin']['bottom']}px;
    justify-content: {$heading_styles['justify']};
    gap: {$heading_styles['gap']}px;
}
#$block_id .review-heading-wrapper .review-heading{
    font-size: {$heading_styles['font']['size']}px;
    font-weight: {$heading_styles['font']['weight']};
    font-family: {$heading_styles['font']['family']};
    text-transform: {$heading_styles['letter_case']};
    text-decoration: {$heading_styles['decoration']};
    line-height: {$heading_styles['line_height']};
    letter-spacing: {$heading_styles['letter_spacing']};
    color: {$heading_color['text']};
}
#$block_id .review-heading-wrapper .total-avg-rating-wrapper {
    background-color: {$heading_color['rating_bg']};
}
#$block_id.layout-grid .woo-product-review-wrapper {
    grid-template-columns: repeat({$grid['column']}, 1fr);
    gap: {$grid['gap']}px;
    text-align: {$grid['align']};
}
@media screen and (max-width: 1024px) {
    .cozy-block-product-review.layout-grid .woo-product-review-wrapper {
        grid-template-columns: repeat(
        {$displayColumn1},
        1fr
        ) !important;
    }
}
@media screen and (max-width: 767px) {
    .cozy-block-product-review.layout-grid .woo-product-review-wrapper {
        grid-template-columns: repeat(
        {$displayColumn2},
        1fr
        ) !important;
    }
}
@media screen and (max-width: 400px) {
    .cozy-block-product-review.layout-grid .woo-product-review-wrapper {
        grid-template-columns: repeat(
        1,
        1fr
        ) !important;
    }
}
#$block_id.layout-list .woo-product-review {
    margin: 0 0 {$list['gap']}px 0;
    text-align: {$list['align']};
}
#$block_id .woo-product-review figure {
    width: {$img_styles['width']}px;
    height: {$img_styles['height']}px;
    border-radius: {$img_styles['radius']}px;
}
#$block_id .woo-product-review figure img {
    border-radius: {$img_styles['radius']}px;
}
#$block_id .woo-product-review .display-grid .display-flex.align-start.flex-column {
    margin-left: {$title_styles['margin']['left']}px;
    color: {$title_color['text']};
}
#$block_id .woo-product-review .display-grid .display-flex.align-start.flex-column .review-date:before {
    border-right-color: {$title_color['text']};
}
#$block_id .product-name {
    font-size: {$title_styles['font']['size']}px;
    font-weight: {$title_styles['font']['weight']};
    font-family: {$title_styles['font']['family']};
    text-transform: {$title_styles['letter_case']};
    text-decoration: {$title_styles['decoration']};
    line-height: {$title_styles['line_height']};
    letter-spacing: {$title_styles['letter_spacing']};
    color: {$title_color['text']};
}
#$block_id .product-name:hover {
    color: {$title_color['text_hover']};
}
#$block_id .product-rating-wrapper {
    font-size: {$title_styles['rating_size']}px;
}
#$block_id .review-content-wrapper {
    margin-top: {$title_styles['wrapper_margin']['top']}px;
    margin-right: {$title_styles['wrapper_margin']['right']}px;
    margin-bottom: {$title_styles['wrapper_margin']['bottom']}px;
    margin-left: {$title_styles['wrapper_margin']['left']}px;
}
#$block_id .cozy-dynamic-loader {
    margin-top: {$loader_styles['margin']['top']}px;
    padding-top: {$loader_styles['padding']['top']}px;
    padding-right: {$loader_styles['padding']['right']}px;
    padding-bottom: {$loader_styles['padding']['bottom']}px;
    padding-left: {$loader_styles['padding']['left']}px;
    border-style: {$loader_styles['border']['style']};
    border-width: {$loader_styles['border']['width']}px;
    border-color: {$loader_color['border']};
    border-radius: {$loader_styles['radius']}px;
    background-color: {$loader_color['bg']};
    color: {$loader_color['text']};
    font-size: {$loader_styles['font']['size']}px;
    font-weight: {$loader_styles['font']['weight']};
    font-family: {$loader_styles['font']['family']};
    text-transform: {$loader_styles['letter_case']};
    text-decoration: {$loader_styles['decoration']};
    line-height: {$loader_styles['line_height']};
    letter-spacing: {$loader_styles['letter_spacing']};
}
#$block_id .cozy-dynamic-loader:hover {
    border-color: {$loader_color['border_hover']};
    color: {$loader_color['text_hover']};
    background-color: {$loader_color['bg_hover']};
}
#$block_id .swiper-button-prev::after,
#$block_id .swiper-button-next::after {
    font-size: {$nav['size']}px;
}
#$block_id .swiper-button-prev,
#$block_id .swiper-button-next {
    width: {$nav['box_width']}px;
    height: {$nav['box_height']}px;
    {$nav['border']}
    border-radius: {$nav['radius']}px;
    color: {$nav_color['icon']};
    background-color: {$nav_color['bg']};
    top: var(--swiper-navigation-top-offset, {$nav['top']}%);
}
#$block_id .swiper-button-prev:hover,
#$block_id .swiper-button-next:hover {
    color: {$nav_color['icon_hover']};
    background-color: {$nav_color['bg_hover']};
    border-color: {$nav_color['border_hover']};
}

#$block_id .swiper-pagination {
    bottom: {$bullet['bottom']}px;
    text-align: {$bullet['align']};
    {$bullet['left']}
    {$bullet['right']}
}
#$block_id .swiper-pagination .swiper-pagination-bullet {
    margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$bullet['gap']}px);
}
#$block_id .swiper-pagination .swiper-pagination-bullet {
    width: {$bullet['width']}px;
    height: {$bullet['height']}px;
    border-radius: {$bullet['radius']}px;
    background-color: {$bullet_color['default_bg']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active {
    width: {$bullet['width']}px;
    height: {$bullet['active']['height']}px;
    {$bullet['active']['border']}
    outline-offset: {$bullet['active']['offset']}px;
    border-radius: {$bullet['active']['radius']}px;
    background-color: {$bullet_color['active_bg']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet:hover {
    background-color: {$bullet_color['default_bg_hover']};
}
#$block_id .swiper-pagination .swiper-pagination-bullet-active:hover {
    background-color: {$bullet_color['active_bg_hover']};
}
";

$months = array(
	'January',
	'February',
	'March',
	'April',
	'May',
	'June',
	'July',
	'August',
	'September',
	'October',
	'November',
	'December',
);

$avgReviews   = Utils::get_woo_avg_product_reviews();
$totalReviews = Utils::get_woo_total_product_reviews();

$reviewsToDisplay = array();

if ( intval( $attributes['perPage'] ) === -1 ) {
	// Display all reviews
	$reviewsToDisplay = Utils::get_woo_product_reviews();
}

if ( intval( $attributes['perPage'] ) !== -1 ) {
	// Display reviews based on the specified perPage value
	$reviewsToDisplay = array_filter(
		Utils::get_woo_product_reviews(),
		function ( $review ) use ( $attributes ) {
			return $review->product_rating >= $attributes['ratingFilter'];
		}
	);

	$reviewsToDisplay = array_slice( $reviewsToDisplay, 0, intval( $attributes['perPage'] ) );
}

$reviewsToDisplay = array_filter(
	$reviewsToDisplay,
	function ( $review ) use ( $attributes ) {
		return $review->product_rating >= $attributes['ratingFilter'];
	}
);
$percent          = $avgReviews / 5 * 100;

echo '<div class="cozy-block-wrapper">';

$font_families = array();

if ( isset( $attributes['ajaxButton']['fontFamily'] ) && ! empty( $attributes['ajaxButton']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['ajaxButton']['fontFamily'] );
}

if ( isset( $attributes['headingOptions']['fontFamily'] ) && ! empty( $attributes['headingOptions']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['headingOptions']['fontFamily'] );
}

if ( isset( $attributes['reviewTitle']['titleTypography']['fontFamily'] ) && ! empty( $attributes['reviewTitle']['titleTypography']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['reviewTitle']['titleTypography']['fontFamily'] );
}

if ( isset( $attributes['typography']['fontFamily'] ) && ! empty( $attributes['typography']['fontFamily'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['typography']['fontFamily'] );
}
// Remove duplicate font families.
$font_families = array_unique( $font_families );
$font_query    = '';
// Add other fonts.
foreach ( $font_families as $key => $family ) {
	if ( 0 === $key ) {
		$font_query .= 'family=' . str_replace( ' ', '+', esc_attr( $family ) ) . ':wght@100;200;300;400;500;600;700;800;900';
	} else {
		$font_query .= '&family=' . str_replace( ' ', '+', esc_attr( $family ) ) . ':wght@100;200;300;400;500;600;700;800;900';
	}
}
if ( ! empty( $font_query ) ) {
	// Generate the inline style for the Google Fonts link.
	$google_fonts_url = 'https://fonts.googleapis.com/css2?' . $font_query . '&display=swap';

	echo '<link rel="stylesheet" href="' . $google_fonts_url . '"/>';
}

echo '<div class="cozy-block-product-review layout-' . esc_attr( sanitize_html_class( $attributes['layout'] ) ) . ' ' . ( $attributes['hoverShow'] ? 'hover-show' : '' ) . ' ' . ( $attributes['containerStyles']['boxShadow']['enabled'] ? 'has-box-shadow' : '' ) . ' ' . ( $attributes['reviewImage']['hoverEffect'] ? 'has-image-hover-effect' : '' ) . '" id="' . esc_attr( $block_id ) . '">';

if ( $attributes['headingOptions']['enabled'] ) {
	echo '<div class="review-heading-wrapper">';
	echo '<h2 class="review-heading">' . esc_html( $attributes['headingOptions']['label'] ) . '</h2>';

	echo '<div class="total-reviews-count">';
	echo '<div class="display-inline-flex total-avg-rating-wrapper" style="margin-right: 10px; padding: 0 10px; border-radius: 10px;">';
	echo '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: text-top; margin-right: 5px;">';
	// ... SVG path
	echo '<path stroke="' . esc_attr( $attributes['headingOptions']['iconColor'] ) . '" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M6.65335 1.83265C6.68155 1.76387 6.72957 1.70503 6.7913 1.66362C6.85303 1.62221 6.92568 1.6001 7.00002 1.6001C7.07435 1.6001 7.14701 1.62221 7.20874 1.66362C7.27047 1.70503 7.31849 1.76387 7.34669 1.83265L8.76335 5.23998C8.78987 5.30374 8.83346 5.35894 8.88933 5.39952C8.9452 5.4401 9.01119 5.46448 9.08002 5.46998L12.7587 5.76465C13.0914 5.79131 13.226 6.20665 12.9727 6.42331L10.17 8.82465C10.1177 8.86944 10.0786 8.92778 10.0572 8.99328C10.0358 9.05878 10.0329 9.12891 10.0487 9.19598L10.9054 12.786C10.9226 12.858 10.9181 12.9335 10.8924 13.003C10.8667 13.0724 10.821 13.1327 10.7611 13.1763C10.7012 13.2198 10.6297 13.2445 10.5557 13.2475C10.4817 13.2504 10.4085 13.2313 10.3454 13.1926L7.19535 11.2693C7.13651 11.2335 7.06893 11.2145 7.00002 11.2145C6.93111 11.2145 6.86353 11.2335 6.80469 11.2693L3.65469 13.1933C3.59152 13.232 3.51832 13.2511 3.44432 13.2481C3.37033 13.2452 3.29885 13.2204 3.23893 13.1769C3.17901 13.1334 3.13333 13.0731 3.10765 13.0036C3.08198 12.9342 3.07747 12.8587 3.09469 12.7866L3.95135 9.19598C3.96724 9.12891 3.96432 9.05876 3.94291 8.99325C3.92151 8.92773 3.88244 8.86939 3.83002 8.82465L1.02735 6.42331C0.971228 6.37505 0.930626 6.31128 0.910652 6.24C0.890678 6.16873 0.892224 6.09314 0.915096 6.02274C0.937968 5.95235 0.981145 5.89028 1.0392 5.84436C1.09725 5.79844 1.16758 5.7707 1.24135 5.76465L4.92002 5.46998C4.98885 5.46448 5.05483 5.4401 5.1107 5.39952C5.16657 5.35894 5.21017 5.30374 5.23669 5.23998L6.65335 1.83265Z" />';
	echo '</svg>';
	echo '<span>' . esc_html( $avgReviews ) . '</span>';
	echo '</div>';
	echo '<p class="display-inline-block" style="margin: 0">' . esc_html( $totalReviews ) . ' ' . esc_html__( 'Reviews', 'cozy-addons' ) . '</p>';
	echo '</div>';

	echo '</div>';
}

echo '<div class="cozy-product-review__swiper-container">';
echo '<ul class="woo-product-review-wrapper ' . ( 'carousel' === $attributes['layout'] ? 'swiper-wrapper' : '' ) . '">';

if ( ! empty( $reviewsToDisplay ) ) {
	foreach ( $reviewsToDisplay as $review ) {
		$comment_id     = $review->comment_ID;
		$comment_rating = get_comment_meta( $comment_id, 'rating', true );

		$dateString = $review->comment_date;
		$dateObject = new DateTime( $dateString );

		$day   = $dateObject->format( 'd' );
		$month = $months[ $dateObject->format( 'n' ) - 1 ];
		$year  = $dateObject->format( 'Y' );

		$formattedDate = '';

		if ( $attributes['reviewTitle']['dateAbbr'] ) {
			$month = substr( $month, 0, 3 );
		}

		if ( $attributes['reviewTitle']['dateFormat'] === 'd-m-y' ) {
			$formattedDate = $day . ' ' . $month . ', ' . $year;
		}

		if ( $attributes['reviewTitle']['dateFormat'] === 'm-d-y' ) {
			$formattedDate = $month . ' ' . $day . ', ' . $year;
		}

		$percent = $comment_rating / 5 * 100;

		$rating_color = isset( $attributes['reviewTitle']['ratingColor'] ) ? esc_attr( $attributes['reviewTitle']['ratingColor'] ) : '';
		$varPercent   = "
            #$block_id .product-rating-wrapper[data-rating='{$comment_rating}']:before {
                --percent: calc($percent%);
                background: linear-gradient(90deg, {$rating_color} $percent%, rgba(0,0,0,0.2) $percent%);
            }
        ";

		echo '<style>' . $varPercent . '</style>';
		echo '<li class="woo-product-review ' . ( 'carousel' === $attributes['layout'] ? 'swiper-slide' : '' ) . '" data-comment-id="' . esc_attr( $review->comment_ID ) . '">';

		if ( $attributes['enableOptions']['reviewContent'] && 'top' === $attributes['reviewContent']['position'] ) {
			echo '<div class="review-content-wrapper">';
			echo '<div class="review-content">' . esc_html( cozy_create_excerpt( $review->comment_content, intval( $attributes['reviewContent']['excerpt'] ) ) ) . '</div>';
			echo '</div>';
		}

		echo '<div class="display-grid">';

		if ( $attributes['enableOptions']['image'] ) {
			echo '<figure class="review-image">';
			if ( $attributes['imageType'] === 'user' ) {
				echo '<img src="' . esc_url( $review->user_avatar ) . '" />';
			} elseif ( $attributes['imageType'] === 'product' ) {
				echo '<img src="' . esc_url( $review->product_image_url ) . '" />';
			}
			echo '</figure>';
		}

		echo '<div class="display-flex flex-column align-start justify-center">';

		echo '<div class="display-flex" style="flex-wrap:wrap;row-gap:4px;">';

		if ( $attributes['enableOptions']['productName'] ) {
			$has_post_link = isset( $attributes['enableOptions']['titleLinkPost'] ) && $attributes['enableOptions']['titleLinkPost'] ? 'href="' . esc_url( $review->product_url ) . '"' : '';
			$open_new_tab  = isset( $attributes['enableOptions']['titleLinkPost'], $attributes['enableOptions']['titleLinkNewTab'] ) && $attributes['enableOptions']['titleLinkPost'] && $attributes['enableOptions']['titleLinkNewTab'] ? '_blank' : '';
			echo '<a class="product-name" ' . $has_post_link . ' target="' . esc_attr( $open_new_tab ) . '" rel="noopener">';
			echo esc_html( $review->product_name );
			echo '</a>';
		}

		if ( $attributes['enableOptions']['productRating'] ) {
			echo '<div class="product-rating-wrapper" data-rating="' . esc_attr( $comment_rating ) . '"></div>';
		}

		echo '</div>';

		echo '<div class="display-flex" style="margin-top:6px;margin-bottom:4px;">';

		if ( $attributes['enableOptions']['reviewerName'] ) {
			echo '<div class="reviewer-name">' . esc_html( $review->reviewer_name ) . '</div>';
		}

		if ( $attributes['enableOptions']['reviewDate'] ) {
			echo '<time class="review-date">' . esc_html( $formattedDate ) . '</time>';
		}

		echo '</div>';

		echo '</div>';

		echo '</div>';

		if ( $attributes['enableOptions']['reviewContent'] && 'bottom' === $attributes['reviewContent']['position'] ) {
			echo '<div class="review-content-wrapper">';
			echo '<div class="review-content">' . esc_html( cozy_create_excerpt( $review->comment_content, intval( $attributes['reviewContent']['excerpt'] ) ) ) . '</div>';
			echo '</div>';
		}

		echo '</li>';
	}
}

echo '</ul>';

if ( $attributes['layout'] === 'carousel' && $attributes['navigation']['enabled'] ) {
	echo '<div class="swiper-button-prev cozy-block-button-prev"></div>';
	echo '<div class="swiper-button-next cozy-block-button-next"></div>';
}

if ( $attributes['layout'] === 'carousel' && $attributes['pagination']['enabled'] ) {
	echo '<div class="swiper-pagination cozy-pagination"></div>';
}

echo '</div>';

if ( $attributes['perPage'] !== '-1' && $attributes['layout'] !== 'carousel' && $attributes['ajaxButton']['enabled'] ) {
	echo '<div class="display-flex justify-center">';
	echo '<button class="cozy-dynamic-loader">' . esc_html( $attributes['ajaxButton']['label'] ) . '</button>';
	echo '</div>';
}

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

echo '</div>';

echo '</div>';
