<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['clientId'] ) ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$attributes['ajaxUrl']        = admin_url( 'admin-ajax.php' );
$attributes['isUserLoggedIn'] = is_user_logged_in();
$attributes['cartNonce']      = wp_create_nonce( 'cozy_block_wishlist_add_to_cart' );
$attributes['quickViewNonce'] = wp_create_nonce( 'cozy_block_quick_view_render_data_lightbox' );

$icon = array(
	'box'   => array(
		'width'  => isset( $attributes['icon']['box']['width'] ) ? esc_attr( $attributes['icon']['box']['width'] ) : '40px',
		'height' => isset( $attributes['icon']['box']['height'] ) ? esc_attr( $attributes['icon']['box']['height'] ) : '40px',
		'border' => isset( $attributes['icon']['box']['border'] ) ? cozy_render_TRBL( 'border', $attributes['icon']['box']['border'] ) : '',
		'radius' => isset( $attributes['icon']['box']['radius'] ) ? esc_attr( $attributes['icon']['box']['radius'] ) : '',
	),
	'size'  => isset( $attributes['icon']['size'] ) ? esc_attr( $attributes['icon']['size'] ) : '',
	'color' => array(
		'text'         => isset( $attributes['icon']['color']['text'] ) ? $attributes['icon']['color']['text'] : '',
		'text_hover'   => isset( $attributes['icon']['color']['textHover'] ) ? $attributes['icon']['color']['textHover'] : '',
		'bg'           => isset( $attributes['icon']['color']['bg'] ) ? $attributes['icon']['color']['bg'] : '',
		'bg_hover'     => isset( $attributes['icon']['color']['bgHover'] ) ? $attributes['icon']['color']['bgHover'] : '',
		'border_hover' => isset( $attributes['icon']['color']['borderHover'] ) ? $attributes['icon']['color']['borderHover'] : '',
	),
);

$lightbox = array(
	'padding' => isset( $attributes['lightbox']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['lightbox']['padding'] ) : '',
	'color'   => array(
		'icon'          => isset( $attributes['lightbox']['color']['icon'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['color']['icon'] ) ) : '',
		'icon_hover'    => isset( $attributes['lightbox']['color']['iconHover'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['color']['iconHover'] ) ) : '',
		'icon_bg'       => isset( $attributes['lightbox']['color']['iconBg'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['color']['iconBg'] ) ) : '',
		'icon_bg_hover' => isset( $attributes['lightbox']['color']['iconBgHover'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['color']['iconBgHover'] ) ) : '',
		'bg'            => isset( $attributes['lightbox']['color']['bg'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['color']['bg'] ) ) : '',
		'overlay'       => isset( $attributes['lightbox']['color']['overlay'] ) ? esc_attr( sanitize_text_field( $attributes['lightbox']['color']['overlay'] ) ) : '',
	),
);

$product_title_styles = array(
	'font'        => array(
		'size'   => isset( $attributes['productTitle']['font']['size'] ) ? esc_attr( $attributes['productTitle']['font']['size'] ) : '',
		'weight' => isset( $attributes['productTitle']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['productTitle']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['productTitle']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['productTitle']['font']['family'] ) ) : '',
	),
	'letter_case' => isset( $attributes['productTitle']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['productTitle']['letterCase'] ) ) : '',
	'color'       => array(
		'text'       => isset( $attributes['productTitle']['color']['text'] ) ? $attributes['productTitle']['color']['text'] : '',
		'text_hover' => isset( $attributes['productTitle']['color']['textHover'] ) ? $attributes['productTitle']['color']['textHover'] : '',
	),
);

$product_summary_styles = array(
	'font'  => array(
		'size'   => isset( $attributes['productSummary']['font']['size'] ) ? esc_attr( $attributes['productSummary']['font']['size'] ) : '',
		'weight' => isset( $attributes['productSummary']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['productSummary']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['productSummary']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['productSummary']['font']['family'] ) ) : '',
	),
	'color' => array(
		'text' => isset( $attributes['productSummary']['color']['text'] ) ? $attributes['productSummary']['color']['text'] : '',
	),
);

$product_price_styles = array(
	'font'  => array(
		'size'   => isset( $attributes['productPrice']['font']['size'] ) ? esc_attr( $attributes['productPrice']['font']['size'] ) : '',
		'weight' => isset( $attributes['productPrice']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['productPrice']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['productPrice']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['productPrice']['font']['family'] ) ) : '',
	),
	'color' => array(
		'text' => isset( $attributes['productPrice']['color']['text'] ) ? $attributes['productPrice']['color']['text'] : '',
	),
);

$cart_button = array(
	'padding'     => isset( $attributes['cartButton']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['cartButton']['padding'] ) : '',
	'margin'      => isset( $attributes['cartButton']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['cartButton']['margin'] ) : '',
	'border'      => isset( $attributes['cartButton']['border'] ) ? cozy_render_TRBL( 'border', $attributes['cartButton']['border'] ) : '',
	'radius'      => isset( $attributes['cartButton']['radius'] ) ? esc_attr( $attributes['cartButton']['radius'] ) : '',
	'font'        => array(
		'size'   => isset( $attributes['cartButton']['font']['size'] ) ? esc_attr( $attributes['cartButton']['font']['size'] ) : '',
		'weight' => isset( $attributes['cartButton']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['cartButton']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['cartButton']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['cartButton']['font']['family'] ) ) : '',
	),
	'letter_case' => isset( $attributes['cartButton']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['cartButton']['letterCase'] ) ) : '',
	'color'       => array(
		'text'         => isset( $attributes['cartButton']['color']['text'] ) ? esc_attr( $attributes['cartButton']['color']['text'] ) : '',
		'text_hover'   => isset( $attributes['cartButton']['color']['textHover'] ) ? esc_attr( $attributes['cartButton']['color']['textHover'] ) : '',
		'bg'           => isset( $attributes['cartButton']['color']['bg'] ) ? esc_attr( $attributes['cartButton']['color']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['cartButton']['color']['bgHover'] ) ? esc_attr( $attributes['cartButton']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['cartButton']['color']['borderHover'] ) ? esc_attr( $attributes['cartButton']['color']['borderHover'] ) : '',
	),
);

$view_button = array(
	'border'      => isset( $attributes['viewButton']['border'] ) ? cozy_render_TRBL( 'border', $attributes['viewButton']['border'] ) : '',
	'radius'      => isset( $attributes['viewButton']['radius'] ) ? esc_attr( $attributes['viewButton']['radius'] ) : '',
	'font'        => array(
		'size'   => isset( $attributes['viewButton']['font']['size'] ) ? esc_attr( $attributes['viewButton']['font']['size'] ) : '',
		'weight' => isset( $attributes['viewButton']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['viewButton']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['viewButton']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['viewButton']['font']['family'] ) ) : '',
	),
	'letter_case' => isset( $attributes['viewButton']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['viewButton']['letterCase'] ) ) : '',
	'color'       => array(
		'text'         => isset( $attributes['viewButton']['color']['text'] ) ? esc_attr( $attributes['viewButton']['color']['text'] ) : '',
		'text_hover'   => isset( $attributes['viewButton']['color']['textHover'] ) ? esc_attr( $attributes['viewButton']['color']['textHover'] ) : '',
		'bg'           => isset( $attributes['viewButton']['color']['bg'] ) ? esc_attr( $attributes['viewButton']['color']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['viewButton']['color']['bgHover'] ) ? esc_attr( $attributes['viewButton']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['viewButton']['color']['borderHover'] ) ? esc_attr( $attributes['viewButton']['color']['borderHover'] ) : '',
	),
);

$toast_card = array(
	'font'          => array(
		'size'   => isset( $attributes['toastCard']['font']['size'] ) ? esc_attr( $attributes['toastCard']['font']['size'] ) : '',
		'weight' => isset( $attributes['toastCard']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['toastCard']['font']['weight'] ) ) : '',
		'family' => isset( $attributes['toastCard']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['toastCard']['font']['family'] ) ) : '',
	),
	'color'         => array(
		'text' => isset( $attributes['toastCard']['color']['text'] ) ? esc_attr( $attributes['toastCard']['color']['text'] ) : '',
		'bg'   => isset( $attributes['toastCard']['color']['bg'] ) ? esc_attr( $attributes['toastCard']['color']['bg'] ) : '',
	),
	'padding'       => isset( $attributes['toastCard']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['toastCard']['padding'] ) : '',
	'border'        => isset( $attributes['toastCard']['border'] ) ? cozy_render_TRBL( 'border', $attributes['toastCard']['border'] ) : '',
	'border_radius' => isset( $attributes['toastCard']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['toastCard']['radius'] ) : '',
);

$product_categories_styles = array(
	'padding' => isset( $attributes['productCategories']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['productCategories']['padding'] ) : '',
	'font'    => array(
		'size'        => isset( $attributes['productCategories']['font']['size'] ) ? esc_attr( $attributes['productCategories']['font']['size'] ) : '',
		'family'      => isset( $attributes['productCategories']['font']['family'] ) ? esc_attr( sanitize_text_field( $attributes['productCategories']['font']['family'] ) ) : '',
		'weight'      => isset( $attributes['productCategories']['font']['weight'] ) ? esc_attr( sanitize_text_field( $attributes['productCategories']['font']['weight'] ) ) : '',
		'letter_case' => isset( $attributes['productCategories']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['productCategories']['letterCase'] ) ) : '',
	),
	'color'   => array(
		'text'       => isset( $attributes['productCategories']['color']['text'] ) ? esc_attr( $attributes['productCategories']['color']['text'] ) : '',
		'text_hover' => isset( $attributes['productCategories']['color']['textHover'] ) ? esc_attr( $attributes['productCategories']['color']['textHover'] ) : '',
		'bg'         => isset( $attributes['productCategories']['color']['background'] ) ? esc_attr( $attributes['productCategories']['color']['background'] ) : '',
		'bg_hover'   => isset( $attributes['productCategories']['color']['backgroundHover'] ) ? esc_attr( $attributes['productCategories']['color']['backgroundHover'] ) : '',
	),
);

$review_styles = array(
	'padding' => isset( $attributes['review']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['review']['padding'] ) : '',
	'color'   => array(
		'author'  => isset( $attributes['review']['color']['author'] ) ? esc_attr( sanitize_text_field( $attributes['review']['color']['author'] ) ) : '',
		'date'    => isset( $attributes['review']['color']['date'] ) ? esc_attr( sanitize_text_field( $attributes['review']['color']['date'] ) ) : '',
		'content' => isset( $attributes['review']['color']['content'] ) ? esc_attr( sanitize_text_field( $attributes['review']['color']['content'] ) ) : '',
	),
);

$nav = array(
	'size'       => isset( $attributes['navigation']['size'] ) ? esc_attr( $attributes['navigation']['size'] ) : '',
	'box_width'  => isset( $attributes['navigation']['boxWidth'] ) ? esc_attr( $attributes['navigation']['boxWidth'] ) : '',
	'box_height' => isset( $attributes['navigation']['boxHeight'] ) ? esc_attr( $attributes['navigation']['boxHeight'] ) : '',
	'radius'     => isset( $attributes['navigation']['radius'] ) ? esc_attr( $attributes['navigation']['radius'] ) : '',
	'border'     => isset( $attributes['navigation']['border'] ) ? cozy_render_TRBL( 'border', $attributes['navigation']['border'] ) : '',
	'color'      => array(
		'icon'         => isset( $attributes['navigation']['color']['icon'] ) ? esc_attr( $attributes['navigation']['color']['icon'] ) : '',
		'icon_hover'   => isset( $attributes['navigation']['color']['iconHover'] ) ? esc_attr( $attributes['navigation']['color']['iconHover'] ) : '',
		'bg'           => isset( $attributes['navigation']['color']['bg'] ) ? esc_attr( $attributes['navigation']['color']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['navigation']['color']['bgHover'] ) ? esc_attr( $attributes['navigation']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['navigation']['color']['borderHover'] ) ? esc_attr( $attributes['navigation']['color']['borderHover'] ) : '',
	),
);

$bullets = array(
	'bottom' => isset( $attributes['pagination']['bottom'] ) ? esc_attr( $attributes['pagination']['bottom'] ) : '',
	'align'  => isset( $attributes['pagination']['align'] ) ? esc_attr( sanitize_text_field( $attributes['pagination']['align'] ) ) : '',
	'width'  => isset( $attributes['pagination']['width'] ) ? esc_attr( $attributes['pagination']['width'] ) : '',
	'height' => isset( $attributes['pagination']['height'] ) ? esc_attr( $attributes['pagination']['height'] ) : '',
	'radius' => isset( $attributes['pagination']['radius'] ) ? esc_attr( $attributes['pagination']['radius'] ) : '',
	'active' => array(
		'width'   => isset( $attributes['pagination']['active']['width'] ) ? esc_attr( $attributes['pagination']['active']['width'] ) : '',
		'height'  => isset( $attributes['pagination']['active']['height'] ) ? esc_attr( $attributes['pagination']['active']['height'] ) : '',
		'radius'  => isset( $attributes['pagination']['active']['radius'] ) ? esc_attr( $attributes['pagination']['active']['radius'] ) : '',
		'outline' => isset( $attributes['pagination']['active']['border'] ) ? cozy_render_TRBL( 'outline', $attributes['pagination']['active']['border'] ) : '',
		'offset'  => isset( $attributes['pagination']['active']['offset'] ) ? esc_attr( $attributes['pagination']['active']['offset'] ) : '',
	),
	'color'  => array(
		'default'       => isset( $attributes['pagination']['color']['default'] ) ? $attributes['pagination']['color']['default'] : '',
		'default_hover' => isset( $attributes['pagination']['color']['defaultHover'] ) ? $attributes['pagination']['color']['defaultHover'] : '',
		'active'        => isset( $attributes['pagination']['color']['active'] ) ? $attributes['pagination']['color']['active'] : '',
		'active_hover'  => isset( $attributes['pagination']['color']['activeHover'] ) ? $attributes['pagination']['color']['activeHover'] : '',
	),
	'left'   => isset( $attributes['pagination']['align'], $attributes['pagination']['left'] ) && 'left' === $attributes['pagination']['align'] ? esc_attr( $attributes['pagination']['left'] ) : '',
	'right'  => isset( $attributes['pagination']['align'], $attributes['pagination']['right'] ) && 'right' === $attributes['pagination']['align'] ? esc_attr( $attributes['pagination']['right'] ) : '',
);

$block_styles = "
#$block_id .cozy-block-quick-view__icon-wrapper {
	width: {$icon['box']['width']};
	height: {$icon['box']['height']};
    {$icon['box']['border']}
    border-radius: {$icon['box']['radius']};
    background-color: {$icon['color']['bg']};
}
#$block_id .cozy-block-quick-view__icon-wrapper svg {
    width: {$icon['size']};
    height: {$icon['size']};
    fill: {$icon['color']['text']};
    stroke: none;
}
#$block_id .cozy-block-quick-view__icon-wrapper:hover svg {
    fill: {$icon['color']['text_hover']};
}
#$block_id .cozy-block-quick-view__icon-wrapper:hover {
    background-color: {$icon['color']['bg_hover']};
    border-color: {$icon['color']['border_hover']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} {
    background-color: {$lightbox['color']['overlay']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .cozy-block-quick-view__lightbox-toolbar-button.lightbox__close-button {
    background-color: {$lightbox['color']['icon_bg']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .cozy-block-quick-view__lightbox-toolbar-button.lightbox__close-button:hover {
    background-color: {$lightbox['color']['icon_bg_hover']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .cozy-block-quick-view__lightbox-toolbar-button.lightbox__close-button svg {
    fill: {$lightbox['color']['icon']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .cozy-block-quick-view__lightbox-toolbar-button.lightbox__close-button:hover svg {
    fill: {$lightbox['color']['icon_hover']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__product-detail {
    {$lightbox['padding']}
    background-color: {$lightbox['color']['bg']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .post__title a {
	font-size: {$product_title_styles['font']['size']};
	font-weight: {$product_title_styles['font']['weight']};
	font-family: {$product_title_styles['font']['family']};
	text-transform: {$product_title_styles['letter_case']};
	color: {$product_title_styles['color']['text']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .post__title a:hover {
	color: {$product_title_styles['color']['text_hover']};
}

body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .post__content {
	font-size: {$product_summary_styles['font']['size']};
	font-weight: {$product_summary_styles['font']['weight']};
	font-family: {$product_summary_styles['font']['family']};
	color: {$product_summary_styles['color']['text']};
}

body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .post__price * {
	font-size: {$product_price_styles['font']['size']};
	font-weight: {$product_price_styles['font']['weight']};
	font-family: {$product_price_styles['font']['family']};
	color: {$product_price_styles['color']['text']};
}

body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__cart-wrapper {
	{$cart_button['margin']}
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__cart-button {
	{$cart_button['padding']}
	{$cart_button['border']}
	border-radius: {};
	font-size: {$cart_button['font']['size']};
	font-weight: {$cart_button['font']['weight']};
	font-family: {$cart_button['font']['family']};
	text-transform: {$cart_button['letter_case']};
	color: {$cart_button['color']['text']};
	background-color: {$cart_button['color']['bg']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__cart-button:hover {
	color: {$cart_button['color']['text_hover']};
	background-color: {$cart_button['color']['bg_hover']};
	border-color: {$cart_button['color']['border_hover']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__cart-view {
	{$cart_button['padding']}
	{$view_button['border']}
	border-radius: {$view_button['radius']};
	background-color: {$view_button['color']['bg']};
	font-size: {$view_button['font']['size']};
	font-weight: {$view_button['font']['weight']};
	font-family: {$view_button['font']['family']};
	text-transform: {$view_button['letter_case']};
	color: {$view_button['color']['text']};
}
#$block_id.cozy-block-quick-view__cart-tooltip {
	{$toast_card['padding']}
	{$toast_card['border']}
	{$toast_card['border_radius']}
	font-size:{$toast_card['font']['size']};
	font-weight:{$toast_card['font']['weight']};
	font-family:{$toast_card['font']['family']};
	color:{$toast_card['color']['text']};
	background-color:{$toast_card['color']['bg']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__cart-view:hover {
	color: {$view_button['color']['text_hover']};
	background-color: {$view_button['color']['bg_hover']};
	border-color: {$view_button['color']['border_hover']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__rating {
	{$review_styles['padding']}
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__rating .review-author {
	color: {$review_styles['color']['author']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__rating .review-date {
	color: {$review_styles['color']['date']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__rating .review-content {
	color: {$review_styles['color']['content']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__product-taxonomies-wrapper .quick-view__product-category {
    {$product_categories_styles['padding']}
    font-size: {$product_categories_styles['font']['size']};
    font-family: {$product_categories_styles['font']['family']};
    font-weight: {$product_categories_styles['font']['weight']};
    text-transform: {$product_categories_styles['font']['letter_case']};
    color: {$product_categories_styles['color']['text']};
    background-color: {$product_categories_styles['color']['bg']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .quick-view__product-taxonomies-wrapper .quick-view__product-category:hover {
    color: {$product_categories_styles['color']['text_hover']};
    background-color: {$product_categories_styles['color']['bg_hover']};
}
#$block_id .swiper-button-prev::after,
#$block_id .swiper-button-next::after {
    font-size: {$nav['size']};
}
#$block_id .swiper-button-prev,
#$block_id .swiper-button-next {
    width: {$nav['box_width']};
    height: {$nav['box_height']};
    {$nav['border']}
    border-radius: {$nav['radius']};
    color: {$nav['color']['icon']};
    background-color: {$nav['color']['bg']};
}
#$block_id .swiper-button-prev:hover,
#$block_id .swiper-button-next:hover {
    color: {$nav['color']['icon_hover']};
    background-color: {$nav['color']['bg_hover']};
    border-color: {$nav['color']['border_hover']};
}

body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .swiper-pagination {
    bottom: {$bullets['bottom']}px;
    text-align: {$bullets['align']};
    padding-left: {$bullets['left']};
    padding-right: {$bullets['right']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .swiper-pagination-bullet {
    width: {$bullets['width']};
    height: {$bullets['height']};
    border-radius: {$bullets['radius']};
    background-color: {$bullets['color']['default']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .swiper-pagination-horizontal .swiper-pagination-bullet {
    margin: 0 var(--swiper-pagination-bullet-horizontal-gap, {$attributes['pagination']['gap']});
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .swiper-pagination-bullet:hover {
    background-color: {$bullets['color']['default_hover']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .swiper-pagination-bullet-active {
    width: {$bullets['active']['width']};
    height: {$bullets['active']['height']};
    border-radius: {$bullets['active']['radius']};
    {$bullets['active']['outline']}
    outline-offset: {$bullets['active']['offset']};
    background-color: {$bullets['color']['active']};
}
body .cozy-block-quick-view__lightbox-wrapper.cozy-source-{$block_id} .swiper-pagination-bullet-active:hover {
    background-color: {$bullets['color']['active_hover']};
}
";

$product_id = $block->context['postId'];

$classes   = array();
$classes[] = 'cozy-block-quick-view';
$classes[] = 'post-' . $product_id;
$output    = '<div class="' . esc_attr( trim( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) ) . '" id="' . esc_attr( $block_id ) . '">';

if ( ! empty( $attributes['postType'] ) && 'product' === $attributes['postType'] ) {
	/* Icon Wrapper */
	$output    .= '<div class="cozy-block-quick-view__icon-wrapper" title="' . esc_attr( 'Quick View' ) . '" data-product-id="' . $product_id . '" onClick="handleQuickViewIconClick(' . $product_id . ', ' . htmlspecialchars( wp_json_encode( $attributes ), ENT_QUOTES, 'UTF-8' ) . ')">';
	$view_box   = array();
	$view_box[] = $attributes['icon']['viewBox']['vx'];
	$view_box[] = $attributes['icon']['viewBox']['vy'];
	$view_box[] = $attributes['icon']['viewBox']['vw'];
	$view_box[] = $attributes['icon']['viewBox']['vh'];
	$output    .= '<svg class="cozy-block-quick-view__icon" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="' . esc_attr( implode( ' ', array_map( 'intval', array_values( $view_box ) ) ) ) . '">';
	$output    .= '<path d="' . esc_attr( $attributes['icon']['path'] ) . '" />';
	$output    .= '</svg>';
	$output    .= '</div>';
	/* End Icon Wrapper */
}

$output .= '</div>';

$wrapper_attributes = get_block_wrapper_attributes();

$font_families = array();

if ( isset( $attributes['productTitle']['font']['family'] ) && ! empty( $attributes['productTitle']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['productTitle']['font']['family'] );
}
if ( isset( $attributes['productCategories']['font']['family'] ) && ! empty( $attributes['productCategories']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['productCategories']['font']['family'] );
}
if ( isset( $attributes['productSummary']['font']['family'] ) && ! empty( $attributes['productSummary']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['productSummary']['font']['family'] );
}
if ( isset( $attributes['productPrice']['font']['family'] ) && ! empty( $attributes['productPrice']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['productPrice']['font']['family'] );
}
if ( isset( $attributes['cartButton']['font']['family'] ) && ! empty( $attributes['cartButton']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['cartButton']['font']['family'] );
}
if ( isset( $attributes['toastCard']['font']['family'] ) && ! empty( $attributes['toastCard']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['toastCard']['font']['family'] );
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

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$render = sprintf( '<div class="cozy-block-wrapper cozy-block-quick-view-wrapper justify-content-' . $attributes['icon']['align'] . '"><div %1$s>%2$s</div></div>', $wrapper_attributes, $output );
echo $render;


?>
<script src="<?php echo esc_url( trailingslashit( COZY_ADDONS_PLUGIN_URL ) ) . 'vendor/jquery/jquery.js'; ?>"></script>
<script type="text/javascript">
function handleQuickViewIconClick(productId, attributes) {
	if ($('body').find('.cozy-block-quick-view__lightbox-wrapper').length === 0) {
		$('body').append('<div class="cozy-block-quick-view__lightbox-wrapper visibility-hidden"><div class="cozy-block-quick-view__lightbox"><div class="cozy-block-quick-view__lightbox-body-wrapper"><div class="cozy-block-quick-view__lightbox-body"><div class="spinner"></div></div></div></div></div>');
	}

	const sourceBlockId = 'cozyBlock_' + attributes.clientId.replace(/-/g, '_');

	let lightboxWrapper = $('body .cozy-block-quick-view__lightbox-wrapper');
	let body = $('body');

	// Remove any previous source class, add current block's
	lightboxWrapper.removeClass(function(index, className) {
		return (className.match(/\bcozy-source-\S+/g) || []).join(' ');
	});
	lightboxWrapper.addClass('cozy-source-' + sourceBlockId);

	lightboxWrapper.removeClass('visibility-hidden');
	body.addClass('overflow-hidden');

	let spinner = $('body .cozy-block-quick-view__lightbox-wrapper .spinner');
	spinner.removeClass('visibility-hidden');

	$.ajax({
		url: "<?php echo $attributes['ajaxUrl']; ?>",
		method: "POST",
		data: {
			action: "cozy_block_quick_view_lightbox_render",
			quickViewNonce: "<?php echo $attributes['quickViewNonce']; ?>",
			productId: productId,
			viewButtonLabel: JSON.stringify(attributes.viewButton.label),
		},
		success: function(response) {
			spinner.addClass('visibility-hidden');
			$('body .cozy-block-quick-view__lightbox-body').append(response.data.render);

			// Close lightbox - close button
			$("body .cozy-block-quick-view__lightbox-body .lightbox__close-button").on("click", function () {
				lightboxWrapper.addClass("visibility-hidden");
				lightboxWrapper.removeClass('cozy-source-' + sourceBlockId);
				body.removeClass("overflow-hidden");
				$("body .cozy-block-quick-view__lightbox-body").html("");
				$("body .cozy-block-quick-view__lightbox-body").html("<div class='spinner visibility-hidden'></div>");
			});

			// Close lightbox - backdrop click
			$("body .cozy-block-quick-view__lightbox-body-wrapper").on("click", function (event) {
				if (event.target === this) {
					lightboxWrapper.addClass("visibility-hidden");
					lightboxWrapper.removeClass('cozy-source-' + sourceBlockId);
					body.removeClass("overflow-hidden");
					$("body .cozy-block-quick-view__lightbox-body").html("");
					$("body .cozy-block-quick-view__lightbox-body").html("<div class='spinner visibility-hidden'></div>");
				}
			});

			// Close lightbox - escape key
			$(document).on("keydown", function (event) {
				if (event.key === "Escape" && !lightboxWrapper.hasClass("visibility-hidden")) {
					lightboxWrapper.addClass("visibility-hidden");
					lightboxWrapper.removeClass('cozy-source-' + sourceBlockId);
					body.removeClass("overflow-hidden");
					$("body .cozy-block-quick-view__lightbox-body").html("");
					$("body .cozy-block-quick-view__lightbox-body").html("<div class='spinner visibility-hidden'></div>");
				}
			});

			// Increase quantity
			$("body .cozy-block-quick-view__lightbox-wrapper .quantity__increase").on("click", function () {
				let quantity = Math.abs(
					parseInt($("body .cozy-block-quick-view__lightbox-wrapper .quick-view__quantity-input").val())
				);
				$("body .cozy-block-quick-view__lightbox-wrapper .quick-view__quantity-input").val(quantity + 1);

				const newQuantity = quantity + 1;
				if (newQuantity > 1) {
					$("body .cozy-block-quick-view__lightbox-wrapper .quantity__decrease").removeClass("opacity-50");
				}
			});

			// Decrease quantity
			$("body .cozy-block-quick-view__lightbox-wrapper .quantity__decrease").click(function () {
				let quantity = Math.abs(
					parseInt($("body .cozy-block-quick-view__lightbox-wrapper .quick-view__quantity-input").val())
				);
				const newQuantity = quantity - 1;

				if (newQuantity > 0) {
					$("body .cozy-block-quick-view__lightbox-wrapper .quick-view__quantity-input").val(quantity - 1);
				} else {
					$("body .cozy-block-quick-view__lightbox-wrapper .quick-view__quantity-input").val(1);
				}

				if (newQuantity <= 1) {
					$(this).addClass("opacity-50");
				} else {
					$(this).removeClass("opacity-50");
				}
			});

			// Add to cart
			$("body .cozy-block-quick-view__lightbox-wrapper .quick-view__cart-button.product_type_simple").on("click", function () {
				const cartSpinner = $(this).find('.loader-icon');
				const cartLabel = $(this).find('.cart-button__label');

				cartSpinner.removeClass('display-none');
				cartLabel.addClass('display-none');

				$.ajax({
					url: "<?php echo $attributes['ajaxUrl']; ?>",
					method: "POST",
					data: {
						action: "cozy_block_wishlist_add_to_cart",
						cartNonce: "<?php echo $attributes['cartNonce']; ?>",
						productId: productId,
						productQuantity: parseInt(
							$("body .cozy-block-quick-view__lightbox-wrapper .quick-view__quantity-input").val()
						),
					},
					success: function (response) {
						if (response.data.fragments) {
							$(document.body).trigger("added_to_cart", [
								response.data.fragments,
								response.data.cart_hash,
							]);
						}

						const toastBlockId = 'cozyBlock_' + attributes.clientId.replace(/-/g, '_');

						if (!$("body").find(".cozy-block-quick-view__cart-tooltip").length) {
							$("body").append('<div class="cozy-block-quick-view__cart-tooltip"></div>');
						}
						const cartTooltip = $("body .cozy-block-quick-view__cart-tooltip");
						cartTooltip.attr('id', toastBlockId);

						if (response.success) {
							cartTooltip.text(`${response.data.product_name} has been added to cart!`);
						} else {
							cartTooltip.text('Sorry! Cannot purchase the product.');
						}

						cartTooltip.removeClass("visibility-hidden");
						setTimeout(() => {
							cartTooltip.addClass("visibility-hidden");
						}, 2000);

						cartSpinner.addClass('display-none');
						cartLabel.removeClass('display-none');
					},
					error: function (error) {
						console.error("Unable to add to cart...");
						cartSpinner.addClass('display-none');
						cartLabel.removeClass('display-none');
					},
				});
			});

			const swiperContainer = document.querySelector('.cozy-block-quick-view__lightbox-wrapper .quick-view__rating.swiper__container');
			const bullets = document.querySelector('.cozy-block-quick-view__lightbox-wrapper .swiper-pagination');

			const sliderAttr = {
				init: true,
				slidesPerView: 1,
				loop: true,
				autoplay: {
					delay: 1500,
					pauseOnMouseEnter: true,
				},
				speed: 2000,
				pagination: {
					el: bullets,
					clickable: true,
				}
			};

			const ratingSlider = new Swiper(swiperContainer, sliderAttr);
		},
		error: function() {
			console.log("Unable to display quick view...");
		}
	});
}
</script>
