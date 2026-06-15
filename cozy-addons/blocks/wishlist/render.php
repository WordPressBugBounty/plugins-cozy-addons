<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['clientId'] ) ) ) : '';
$block_id  = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$attributes['isUserLoggedIn']   = is_user_logged_in();
$attributes['userID']           = get_current_user_id();
$attributes['ajaxUrl']          = admin_url( 'admin-ajax.php' );
$attributes['sidebarNonce']     = wp_create_nonce( 'cozy_block_wishlist_render_data_sidebar' );
$attributes['wishlistNonce']    = wp_create_nonce( 'cozy_block_wishlist_update_user_wishlist' );
$attributes['cartNonce']        = wp_create_nonce( 'cozy_block_wishlist_add_to_cart' );
$wishlist_user_meta_early       = get_user_meta( get_current_user_id(), 'cozy_block_wishlist_data', true );
$attributes['userWishlistData'] = is_user_logged_in() && is_array( $wishlist_user_meta_early )
	? array_values( $wishlist_user_meta_early )
	: array();

if ( 'sidebar' === $attributes['variation'] ) {
	wp_localize_script( 'cozy-block--wishlist--frontend-script', $block_id, $attributes );
	wp_add_inline_script( 'cozy-block--wishlist--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockWishlist( "' . esc_html( $client_id ) . '" ) }) ' );
}
$wishlist_icon = array(
	'default' => array(
		'align'  => isset( $attributes['wishlist']['icon']['align'] ) ? $attributes['wishlist']['icon']['align'] : 'right',
		'width'  => isset( $attributes['wishlist']['icon']['box']['width'] ) ? $attributes['wishlist']['icon']['box']['width'] : '40px',
		'height' => isset( $attributes['wishlist']['icon']['box']['height'] ) ? $attributes['wishlist']['icon']['box']['height'] : '40px',
		'border' => isset( $attributes['wishlist']['icon']['box']['border'] ) ? cozy_render_TRBL( 'border', $attributes['wishlist']['icon']['box']['border'] ) : '',
		'color'  => array(
			'text'         => isset( $attributes['wishlist']['icon']['color']['text'] ) ? $attributes['wishlist']['icon']['color']['text'] : '',
			'text_hover'   => isset( $attributes['wishlist']['icon']['color']['textHover'] ) ? $attributes['wishlist']['icon']['color']['textHover'] : '',
			'bg'           => isset( $attributes['wishlist']['icon']['color']['bg'] ) ? $attributes['wishlist']['icon']['color']['bg'] : '',
			'bg_hover'     => isset( $attributes['wishlist']['icon']['color']['bgHover'] ) ? $attributes['wishlist']['icon']['color']['bgHover'] : '',
			'border_hover' => isset( $attributes['wishlist']['icon']['color']['borderHover'] ) ? $attributes['wishlist']['icon']['color']['borderHover'] : '',
		),
	),
	'active'  => array(
		'border' => isset( $attributes['wishlist']['activeIcon']['box']['border'] ) ? cozy_render_TRBL( 'border', $attributes['wishlist']['activeIcon']['box']['border'] ) : '',
		'radius' => isset( $attributes['wishlist']['activeIcon']['box']['radius'] ) ? $attributes['wishlist']['activeIcon']['box']['radius'] : '',
		'color'  => array(
			'text'         => isset( $attributes['wishlist']['activeIcon']['color']['text'] ) ? $attributes['wishlist']['activeIcon']['color']['text'] : '',
			'text_hover'   => isset( $attributes['wishlist']['activeIcon']['color']['textHover'] ) ? $attributes['wishlist']['activeIcon']['color']['textHover'] : '',
			'bg'           => isset( $attributes['wishlist']['activeIcon']['color']['bg'] ) ? $attributes['wishlist']['activeIcon']['color']['bg'] : '',
			'bg_hover'     => isset( $attributes['wishlist']['activeIcon']['color']['bgHover'] ) ? $attributes['wishlist']['activeIcon']['color']['bgHover'] : '',
			'border_hover' => isset( $attributes['wishlist']['activeIcon']['color']['borderHover'] ) ? $attributes['wishlist']['activeIcon']['color']['borderHover'] : '',
		),
	),
);

$sidebar      = array(
	'title'           => array(
		'before_text' => isset( $attributes['sidebar']['sidebarTitle']['beforeText'] ) ? $attributes['sidebar']['sidebarTitle']['beforeText'] : '',
		'after_text'  => isset( $attributes['sidebar']['sidebarTitle']['afterText'] ) ? $attributes['sidebar']['sidebarTitle']['afterText'] : '',
		'alignment'   => isset( $attributes['sidebar']['sidebarTitle']['alignment'] ) ? $attributes['sidebar']['sidebarTitle']['alignment'] : '',
		'color'       => isset( $attributes['sidebar']['sidebarTitle']['color']['text'] ) ? $attributes['sidebar']['sidebarTitle']['color']['text'] : '',
		'font'        => array(
			'size'         => isset( $attributes['sidebar']['sidebarTitle']['font']['size'] ) ? $attributes['sidebar']['sidebarTitle']['font']['size'] : '',
			'family'       => isset( $attributes['sidebar']['sidebarTitle']['font']['family'] ) ? $attributes['sidebar']['sidebarTitle']['font']['family'] : '',
			'weight'       => isset( $attributes['sidebar']['sidebarTitle']['font']['weight'] ) ? $attributes['sidebar']['sidebarTitle']['font']['weight'] : '',
			'lettercase'   => isset( $attributes['sidebar']['sidebarTitle']['letterCase'] ) ? $attributes['sidebar']['sidebarTitle']['letterCase'] : '',
			'decoration'   => isset( $attributes['sidebar']['sidebarTitle']['textDecoration'] ) ? $attributes['sidebar']['sidebarTitle']['textDecoration'] : '',
			'line_height'  => isset( $attributes['sidebar']['sidebarTitle']['lineHeight'] ) ? $attributes['sidebar']['sidebarTitle']['lineHeight'] : '',
			'letter_space' => isset( $attributes['sidebar']['sidebarTitle']['letterSpace'] ) ? $attributes['sidebar']['sidebarTitle']['letterSpace'] : '',
		),
	),
	'color'           => array(
		'cart_text'       => isset( $attributes['sidebar']['color']['cartText'] ) ? $attributes['sidebar']['color']['cartText'] : '',
		'cart_text_hover' => isset( $attributes['sidebar']['color']['cartTextHover'] ) ? $attributes['sidebar']['color']['cartTextHover'] : '',
		'cart_bg'         => isset( $attributes['sidebar']['color']['cartBg'] ) ? $attributes['sidebar']['color']['cartBg'] : '',
		'cart_bg_hover'   => isset( $attributes['sidebar']['color']['cartBgHover'] ) ? $attributes['sidebar']['color']['cartBgHover'] : '',
		'bg'              => isset( $attributes['sidebar']['color']['bg'] ) ? $attributes['sidebar']['color']['bg'] : '',
		'overlay'         => isset( $attributes['sidebar']['color']['overlay'] ) ? $attributes['sidebar']['color']['overlay'] : '',
		'border_bottom'   => isset( $attributes['sidebar']['color']['borderColor'] ) ? $attributes['sidebar']['color']['borderColor'] : '',
	),
	'count'           => array(
		'padding' => isset( $attributes['sidebar']['count']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['sidebar']['count']['padding'] ) : '',
		'border'  => isset( $attributes['sidebar']['count']['border'] ) ? cozy_render_TRBL( 'border', $attributes['sidebar']['count']['border'] ) : '',
		'color'   => array(
			'text' => isset( $attributes['sidebar']['count']['color']['text'] ) ? $attributes['sidebar']['count']['color']['text'] : '',
			'bg'   => isset( $attributes['sidebar']['count']['color']['bg'] ) ? $attributes['sidebar']['count']['color']['bg'] : '',
		),
	),
	'product_title'   => array(
		'color' => array(
			'text'       => isset( $attributes['sidebar']['productTitle']['color']['text'] ) ? $attributes['sidebar']['productTitle']['color']['text'] : '',
			'text_hover' => isset( $attributes['sidebar']['productTitle']['color']['textHover'] ) ? $attributes['sidebar']['productTitle']['color']['textHover'] : '',
		),
	),
	'product_summary' => array(
		'color' => array(
			'text' => isset( $attributes['sidebar']['productSummary']['color']['text'] ) ? $attributes['sidebar']['productSummary']['color']['text'] : '',
		),
	),
	'product_price'   => array(
		'color' => array(
			'text' => isset( $attributes['sidebar']['productPrice']['color']['text'] ) ? $attributes['sidebar']['productPrice']['color']['text'] : '',
		),
	),
	'button'          => array(
		'font'    => array(
			'size'         => isset( $attributes['sidebar']['button']['font']['size'] ) ? $attributes['sidebar']['button']['font']['size'] : '',
			'family'       => isset( $attributes['sidebar']['button']['font']['family'] ) ? $attributes['sidebar']['button']['font']['family'] : '',
			'weight'       => isset( $attributes['sidebar']['button']['font']['weight'] ) ? $attributes['sidebar']['button']['font']['weight'] : '',
			'lettercase'   => isset( $attributes['sidebar']['button']['letterCase'] ) ? $attributes['sidebar']['button']['letterCase'] : '',
			'decoration'   => isset( $attributes['sidebar']['button']['textDecoration'] ) ? $attributes['sidebar']['button']['textDecoration'] : '',
			'line_height'  => isset( $attributes['sidebar']['button']['lineHeight'] ) ? $attributes['sidebar']['button']['lineHeight'] : '',
			'letter_space' => isset( $attributes['sidebar']['button']['letterSpace'] ) ? $attributes['sidebar']['button']['letterSpace'] : '',
		),
		'padding' => isset( $attributes['sidebar']['button']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['sidebar']['button']['padding'] ) : '',
		'cart'    => array(
			'border' => isset( $attributes['sidebar']['button']['cart']['border'] ) ? cozy_render_TRBL( 'border', $attributes['sidebar']['button']['cart']['border'] ) : '',
			'radius' => isset( $attributes['sidebar']['button']['cart']['radius'] ) ? $attributes['sidebar']['button']['cart']['radius'] : '',
			'color'  => array(
				'text'         => isset( $attributes['sidebar']['button']['cart']['color']['text'] ) ? $attributes['sidebar']['button']['cart']['color']['text'] : '',
				'text_hover'   => isset( $attributes['sidebar']['button']['cart']['color']['textHover'] ) ? $attributes['sidebar']['button']['cart']['color']['textHover'] : '',
				'bg'           => isset( $attributes['sidebar']['button']['cart']['color']['bg'] ) ? $attributes['sidebar']['button']['cart']['color']['bg'] : '',
				'bg_hover'     => isset( $attributes['sidebar']['button']['cart']['color']['bgHover'] ) ? $attributes['sidebar']['button']['cart']['color']['bgHover'] : '',
				'border_hover' => isset( $attributes['sidebar']['button']['cart']['color']['borderHover'] ) ? $attributes['sidebar']['button']['cart']['color']['borderHover'] : '',
			),
		),
		'remove'  => array(
			'border' => isset( $attributes['sidebar']['button']['remove']['border'] ) ? cozy_render_TRBL( 'border', $attributes['sidebar']['button']['remove']['border'] ) : '',
			'radius' => isset( $attributes['sidebar']['button']['remove']['radius'] ) ? $attributes['sidebar']['button']['remove']['radius'] : '',
			'color'  => array(
				'text'         => isset( $attributes['sidebar']['button']['remove']['color']['text'] ) ? $attributes['sidebar']['button']['remove']['color']['text'] : '',
				'text_hover'   => isset( $attributes['sidebar']['button']['remove']['color']['textHover'] ) ? $attributes['sidebar']['button']['remove']['color']['textHover'] : '',
				'bg'           => isset( $attributes['sidebar']['button']['remove']['color']['bg'] ) ? $attributes['sidebar']['button']['remove']['color']['bg'] : '',
				'bg_hover'     => isset( $attributes['sidebar']['button']['remove']['color']['bgHover'] ) ? $attributes['sidebar']['button']['remove']['color']['bgHover'] : '',
				'border_hover' => isset( $attributes['sidebar']['button']['remove']['color']['borderHover'] ) ? $attributes['sidebar']['button']['remove']['color']['borderHover'] : '',
			),
		),
	),
);
$sidebar_item = array(
	'padding'      => isset( $attributes['itemStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['itemStyles']['padding'] ) : '',
	'bg'           => isset( $attributes['itemStyles']['color']['bg'] ) ? $attributes['itemStyles']['color']['bg'] : '',
	'bg_hover'     => isset( $attributes['itemStyles']['color']['bgHover'] ) ? $attributes['itemStyles']['color']['bgHover'] : '',
	'border_hover' => isset( $attributes['itemStyles']['color']['borderHover'] ) ? $attributes['itemStyles']['color']['borderHover'] : '',
	'shadow'       => array(
		'horizontal' => isset( $attributes['itemStyles']['shadow']['horizontal'] ) ? $attributes['itemStyles']['shadow']['horizontal'] : '',
		'vertical'   => isset( $attributes['itemStyles']['shadow']['vertical'] ) ? $attributes['itemStyles']['shadow']['vertical'] : '',
		'blur'       => isset( $attributes['itemStyles']['shadow']['blur'] ) ? $attributes['itemStyles']['shadow']['blur'] : '',
		'spread'     => isset( $attributes['itemStyles']['shadow']['spread'] ) ? $attributes['itemStyles']['shadow']['spread'] : '',
		'color'      => isset( $attributes['itemStyles']['shadow']['color'] ) ? $attributes['itemStyles']['shadow']['color'] : '',
		'position'   => isset( $attributes['itemStyles']['shadow']['position'] ) ? $attributes['itemStyles']['shadow']['position'] : '',
	),
	'shadow_hover' => array(
		'horizontal' => isset( $attributes['itemStyles']['shadowHover']['horizontal'] ) ? $attributes['itemStyles']['shadowHover']['horizontal'] : '',
		'vertical'   => isset( $attributes['itemStyles']['shadowHover']['vertical'] ) ? $attributes['itemStyles']['shadowHover']['vertical'] : '',
		'blur'       => isset( $attributes['itemStyles']['shadowHover']['blur'] ) ? $attributes['itemStyles']['shadowHover']['blur'] : '',
		'spread'     => isset( $attributes['itemStyles']['shadowHover']['spread'] ) ? $attributes['itemStyles']['shadowHover']['spread'] : '',
		'color'      => isset( $attributes['itemStyles']['shadowHover']['color'] ) ? $attributes['itemStyles']['shadowHover']['color'] : '',
		'position'   => isset( $attributes['itemStyles']['shadowHover']['position'] ) ? $attributes['itemStyles']['shadowHover']['position'] : '',
	),
);
$sidebar_icon = array(
	'open'  => array(
		'width'  => isset( $attributes['sidebar']['icon']['box']['width'] ) ? $attributes['sidebar']['icon']['box']['width'] : '40px',
		'height' => isset( $attributes['sidebar']['icon']['box']['height'] ) ? $attributes['sidebar']['icon']['box']['height'] : '40px',
		'border' => isset( $attributes['sidebar']['icon']['box']['border'] ) ? cozy_render_TRBL( 'border', $attributes['sidebar']['icon']['box']['border'] ) : '',
		'color'  => array(
			'text'         => isset( $attributes['sidebar']['icon']['color']['text'] ) ? $attributes['sidebar']['icon']['color']['text'] : '',
			'text_hover'   => isset( $attributes['sidebar']['icon']['color']['textHover'] ) ? $attributes['sidebar']['icon']['color']['textHover'] : '',
			'bg'           => isset( $attributes['sidebar']['icon']['color']['bg'] ) ? $attributes['sidebar']['icon']['color']['bg'] : '',
			'bg_hover'     => isset( $attributes['sidebar']['icon']['color']['bgHover'] ) ? $attributes['sidebar']['icon']['color']['bgHover'] : '',
			'border_hover' => isset( $attributes['sidebar']['icon']['color']['borderHover'] ) ? $attributes['sidebar']['icon']['color']['borderHover'] : '',
		),
	),
	'close' => array(
		'width'  => isset( $attributes['sidebar']['closeIcon']['box']['width'] ) ? $attributes['sidebar']['closeIcon']['box']['width'] : '40px',
		'height' => isset( $attributes['sidebar']['closeIcon']['box']['height'] ) ? $attributes['sidebar']['closeIcon']['box']['height'] : '40px',
		'border' => isset( $attributes['sidebar']['closeIcon']['box']['border'] ) ? cozy_render_TRBL( 'border', $attributes['sidebar']['closeIcon']['box']['border'] ) : '',
		'left'   => 'left' === $attributes['sidebar']['closeIcon']['position'] ? $attributes['sidebar']['closeIcon']['left'] : '',
		'right'  => 'right' === $attributes['sidebar']['closeIcon']['position'] ? $attributes['sidebar']['closeIcon']['right'] : '',
		'color'  => array(
			'text'         => isset( $attributes['sidebar']['closeIcon']['color']['text'] ) ? $attributes['sidebar']['closeIcon']['color']['text'] : '',
			'text_hover'   => isset( $attributes['sidebar']['closeIcon']['color']['textHover'] ) ? $attributes['sidebar']['closeIcon']['color']['textHover'] : '',
			'bg'           => isset( $attributes['sidebar']['closeIcon']['color']['bg'] ) ? $attributes['sidebar']['closeIcon']['color']['bg'] : '',
			'bg_hover'     => isset( $attributes['sidebar']['closeIcon']['color']['bgHover'] ) ? $attributes['sidebar']['closeIcon']['color']['bgHover'] : '',
			'border_hover' => isset( $attributes['sidebar']['closeIcon']['color']['borderHover'] ) ? $attributes['sidebar']['closeIcon']['color']['borderHover'] : '',
		),
	),
);

$toast = array(
	'padding'         => isset( $attributes['toastCard']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['toastCard']['padding'] ) : '',
	'border'          => isset( $attributes['toastCard']['border'] ) ? cozy_render_TRBL( 'border', $attributes['toastCard']['border'] ) : '',
	'radius'          => isset( $attributes['toastCard']['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['toastCard']['radius'] ) : '',
	'font'            => array(
		'size'   => isset( $attributes['toastCard']['font']['size'] ) ? $attributes['toastCard']['font']['size'] : '',
		'family' => isset( $attributes['toastCard']['font']['family'] ) ? $attributes['toastCard']['font']['family'] : '',
		'weight' => isset( $attributes['toastCard']['font']['weight'] ) ? $attributes['toastCard']['font']['weight'] : '',
	),
	'letter_case'     => isset( $attributes['toastCard']['letterCase'] ) ? $attributes['toastCard']['letterCase'] : 'none',
	'text_decoration' => isset( $attributes['toastCard']['textDecoration'] ) ? $attributes['toastCard']['textDecoration'] : 'none',
	'line_height'     => isset( $attributes['toastCard']['lineHeight'] ) ? $attributes['toastCard']['lineHeight'] : '',
	'letter_space'    => isset( $attributes['toastCard']['letterSpace'] ) ? $attributes['toastCard']['letterSpace'] : '',
	'color'           => array(
		'text' => isset( $attributes['toastCard']['color']['text'] ) ? $attributes['toastCard']['color']['text'] : '',
		'bg'   => isset( $attributes['toastCard']['color']['bg'] ) ? $attributes['toastCard']['color']['bg'] : '',
	),
);

$block_styles  = "
#$block_id.variation-wishlist .wishlist__icon-wrapper {
	width: {$wishlist_icon['default']['width']};
	height: {$wishlist_icon['default']['height']};
	{$wishlist_icon['default']['border']}
	border-radius: {$attributes['wishlist']['icon']['box']['radius']};
	background-color: {$wishlist_icon['default']['color']['bg']};
}
#$block_id.variation-wishlist .wishlist__icon-wrapper:hover {
	background-color: {$wishlist_icon['default']['color']['bg_hover']};
	border-color: {$wishlist_icon['default']['color']['border_hover']};
}
#$block_id.variation-wishlist .wishlist__icon, .is-loading-spinner{
	width: {$attributes['wishlist']['icon']['size']};
	height: {$attributes['wishlist']['icon']['size']};
	fill: {$wishlist_icon['default']['color']['text']};
	stroke: none;
}
#$block_id .is-loading-spinner svg{
	border-color: {$wishlist_icon['default']['color']['text']};
}
#$block_id.variation-wishlist .wishlist__icon-wrapper:hover .wishlist__icon {
	fill: {$wishlist_icon['default']['color']['text_hover']};
}
#$block_id.variation-wishlist .wishlist__icon-wrapper.is-active {
	{$wishlist_icon['active']['border']}
	border-radius: {$wishlist_icon['active']['radius']};
	background-color: {$wishlist_icon['active']['color']['bg']};
}
#$block_id .wishlist__icon-wrapper.is-active.is-loading-spinner svg{
	border-color: {$wishlist_icon['active']['color']['text']};
}
#$block_id.variation-wishlist .wishlist__icon-wrapper.is-active:hover {
	background-color: {$wishlist_icon['active']['color']['bg_hover']};
	border-color: {$wishlist_icon['active']['color']['border_hover']};
}
#$block_id.variation-wishlist .wishlist__icon-wrapper.is-active .wishlist__icon {
	fill: {$wishlist_icon['active']['color']['text']};
	stroke: none;
}
#$block_id.variation-wishlist .wishlist__icon-wrapper.is-active:hover .wishlist__icon {
	fill: {$wishlist_icon['active']['color']['text_hover']};
}

#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-wrapper {
    background-color: {$sidebar['color']['overlay']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar {
    width: {$attributes['sidebar']['width']};
    background-color: {$sidebar['color']['bg']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-header{
	border-color:{$sidebar['color']['border_bottom']};
}
#$block_id.variation-sidebar .sidebar-header-title{
	font-size:{$sidebar['title']['font']['size']};
	font-family:{$sidebar['title']['font']['family']};
	font-weight:{$sidebar['title']['font']['weight']};
	text-transform:{$sidebar['title']['font']['lettercase']};
	text-decoration:{$sidebar['title']['font']['decoration']};
	line-height:{$sidebar['title']['font']['line_height']};
	letter-spacing:{$sidebar['title']['font']['letter_space']};
	color:{$sidebar['title']['color']};
}
#$block_id.variation-sidebar .sidebar__icon-wrapper {
	width: {$sidebar_icon['open']['width']};
	height: {$sidebar_icon['open']['height']};
	{$sidebar_icon['open']['border']}
	border-radius: {$attributes['sidebar']['icon']['box']['radius']};
	background-color: {$sidebar_icon['open']['color']['bg']};
}
#$block_id.variation-sidebar .sidebar__icon-wrapper:hover {
	background-color: {$sidebar_icon['open']['color']['bg_hover']};
	border-color: {$sidebar_icon['open']['color']['border_hover']};
}
#$block_id.variation-sidebar .sidebar__icon {
	width: {$attributes['sidebar']['icon']['size']};
	height: {$attributes['sidebar']['icon']['size']};
	fill: {$sidebar_icon['open']['color']['text']};
	stroke: none;
}
#$block_id.variation-sidebar .sidebar__icon-wrapper:hover .sidebar__icon {
	fill: {$sidebar_icon['open']['color']['text_hover']};
}

.logged-in #$block_id.variation-sidebar .sidebar-close-button {
    margin-top: calc(34px + {$attributes['sidebar']['closeIcon']['top']});
}
#$block_id.variation-sidebar .sidebar-close-button {
    margin-top: {$attributes['sidebar']['closeIcon']['top']};
    margin-left: {$sidebar_icon['close']['left']};
    margin-right: {$sidebar_icon['close']['right']};
	width: {$sidebar_icon['close']['width']};
	height: {$sidebar_icon['close']['height']};
	{$sidebar_icon['close']['border']}
	border-radius: {$attributes['sidebar']['closeIcon']['box']['radius']};
	background-color: {$sidebar_icon['close']['color']['bg']};
}
#$block_id.variation-sidebar .sidebar-close-button:hover {
	background-color: {$sidebar_icon['close']['color']['bg_hover']};
	border-color: {$sidebar_icon['close']['color']['border_hover']};
}
#$block_id.variation-sidebar .sidebar-close-button svg {
	width: {$attributes['sidebar']['closeIcon']['size']};
	height: {$attributes['sidebar']['closeIcon']['size']};
	fill: {$sidebar_icon['close']['color']['text']};
	stroke: none;
}
#$block_id.variation-sidebar .sidebar-close-button:hover svg {
	fill: {$sidebar_icon['close']['color']['text_hover']};
}

#$block_id.variation-sidebar .cozy-block-wishlist__count {
	margin-top: {$attributes['sidebar']['count']['margin']['top']}px;
	margin-right: {$attributes['sidebar']['count']['margin']['right']}px;
	{$sidebar['count']['padding']}
	{$sidebar['count']['border']}
	border-radius: {$attributes['sidebar']['count']['radius']};
	color: {$sidebar['count']['color']['text']};
	background-color: {$sidebar['count']['color']['bg']};
	font-size: {$attributes['sidebar']['count']['font']['size']};
	font-weight: {$attributes['sidebar']['count']['font']['weight']};
	font-family: {$attributes['sidebar']['count']['font']['family']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__product-data {
	{$sidebar_item['padding']}
	margin-top: {$attributes['itemStyles']['margin']['top']};
	margin-bottom: {$attributes['itemStyles']['margin']['bottom']};
	border-radius: {$attributes['itemStyles']['radius']};
	background-color: {$sidebar_item['bg']};
	border-color:{$sidebar['color']['border_bottom']};
}
#$block_id.variation-sidebar.item-has-box-shadow .cozy-block-wishlist__product-data {
	box-shadow: {$sidebar_item['shadow']['horizontal']}px {$sidebar_item['shadow']['vertical']}px {$sidebar_item['shadow']['blur']}px {$sidebar_item['shadow']['spread']}px {$sidebar_item['shadow']['color']} {$sidebar_item['shadow']['position']}; 
}
#$block_id.variation-sidebar .cozy-block-wishlist__product-data:hover {
	background-color: {$sidebar_item['bg_hover']};
	border-color: {$sidebar_item['border_hover']};
}
#$block_id.variation-sidebar.item-has-hover-box-shadow .cozy-block-wishlist__product-data:hover {
	box-shadow: {$sidebar_item['shadow_hover']['horizontal']}px {$sidebar_item['shadow_hover']['vertical']}px {$sidebar_item['shadow_hover']['blur']}px {$sidebar_item['shadow_hover']['spread']}px {$sidebar_item['shadow_hover']['color']} {$sidebar_item['shadow_hover']['position']}; 
}
#$block_id.variation-sidebar .cozy-block-wishlist__product-title a {
	font-size: {$attributes['sidebar']['productTitle']['font']['size']};
	font-weight: {$attributes['sidebar']['productTitle']['font']['weight']};
	font-family: {$attributes['sidebar']['productTitle']['font']['family']};
	text-transform: {$attributes['sidebar']['productTitle']['letterCase']};
	text-decoration: {$attributes['sidebar']['productTitle']['textDecoration']};
	line-height: {$attributes['sidebar']['productTitle']['lineHeight']};
	letter-spacing: {$attributes['sidebar']['productTitle']['letterSpace']};
	color: {$sidebar['product_title']['color']['text']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__product-title a:hover {
	color: {$sidebar['product_title']['color']['text_hover']};
}

#$block_id.variation-sidebar .cozy-block-wishlist__product-summary {
	font-size: {$attributes['sidebar']['productSummary']['font']['size']};
	font-weight: {$attributes['sidebar']['productSummary']['font']['weight']};
	font-family: {$attributes['sidebar']['productSummary']['font']['family']};
	text-transform: {$attributes['sidebar']['productSummary']['letterCase']};
	text-decoration: {$attributes['sidebar']['productSummary']['textDecoration']};
	line-height: {$attributes['sidebar']['productSummary']['lineHeight']};
	letter-spacing: {$attributes['sidebar']['productSummary']['letterSpace']};
	color: {$sidebar['product_summary']['color']['text']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__product-price {
	font-size: {$attributes['sidebar']['productPrice']['font']['size']};
	font-weight: {$attributes['sidebar']['productPrice']['font']['weight']};
	font-family: {$attributes['sidebar']['productPrice']['font']['family']};
	text-transform: {$attributes['sidebar']['productPrice']['letterCase']};
	text-decoration: {$attributes['sidebar']['productPrice']['textDecoration']};
	line-height: {$attributes['sidebar']['productPrice']['lineHeight']};
	letter-spacing: {$attributes['sidebar']['productPrice']['letterSpace']};
	color: {$sidebar['product_price']['color']['text']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-button {
	font-size: {$attributes['sidebar']['button']['font']['size']};
	font-weight: {$attributes['sidebar']['button']['font']['weight']};
	font-family: {$attributes['sidebar']['button']['font']['family']};
	text-transform: {$attributes['sidebar']['button']['letterCase']};
	text-decoration: {$attributes['sidebar']['button']['textDecoration']};
	line-height: {$attributes['sidebar']['button']['lineHeight']};
	letter-spacing: {$attributes['sidebar']['button']['letterSpace']};
}
#$block_id.variation-sidebar .cozy-block-add-btn-has-link .cozy-block-wishlist__sidebar-button,
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-button.add__cart,
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-button.out-of-stock{
	{$sidebar['button']['cart']['border']}
	border-radius: {$attributes['sidebar']['button']['cart']['radius']};
	color: {$sidebar['button']['cart']['color']['text']};
	background-color: {$sidebar['button']['cart']['color']['bg']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-button.add__cart:hover,
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-button.out-of-stock:hover,
#$block_id.variation-sidebar a:hover .cozy-block-wishlist__sidebar-button{
	color: {$sidebar['button']['cart']['color']['text_hover']};
	background-color: {$sidebar['button']['cart']['color']['bg_hover']};
	border-color: {$sidebar['button']['cart']['color']['border_hover']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-button.remove__wishlist {
	{$sidebar['button']['remove']['border']}
	border-radius: {$attributes['sidebar']['button']['remove']['radius']};
	background-color: {$sidebar['button']['remove']['color']['bg']};
	font-size: {$attributes['sidebar']['button']['font']['size']};
	}
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-button.remove__wishlist svg{		
	color: {$sidebar['button']['remove']['color']['text']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-button.remove__wishlist:hover {
	background-color: {$sidebar['button']['remove']['color']['bg_hover']};
	border-color: {$sidebar['button']['remove']['color']['border_hover']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__sidebar-button.remove__wishlist:hover svg {
	color: {$sidebar['button']['remove']['color']['text_hover']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__cart-btn-wrapper{
	border-color:{$sidebar['color']['border_bottom']};
	background-color: color-mix(in srgb, {$sidebar['color']['cart_bg']} 20%, transparent);
}
#$block_id.variation-sidebar .cozy-block-wishlist__cart-button {
	color: {$sidebar['color']['cart_text']};
	background-color: {$sidebar['color']['cart_bg']};
}
#$block_id.variation-sidebar .cozy-block-wishlist__cart-button:hover {
	color: {$sidebar['color']['cart_text_hover']};
	background-color: {$sidebar['color']['cart_bg_hover']};
}

#{$block_id}.cozy-block-wishlist__toast {
    {$toast['padding']}
    {$toast['border']}
    {$toast['radius']}
    font-size: {$toast['font']['size']};
    font-weight: {$toast['font']['weight']};
    font-family: {$toast['font']['family']};
    text-transform: {$toast['letter_case']};
    text-decoration: {$toast['text_decoration']};
    line-height: {$toast['line_height']};
    letter-spacing: {$toast['letter_space']};
    color: {$toast['color']['text']};
    background-color: {$toast['color']['bg']};
}
";
$classes       = array();
$classes[]     = 'cozy-block-wishlist';
$classes[]     = 'variation-' . $attributes['variation'];
$classes[]     = 'sidebar' === $attributes['variation'] && $attributes['itemStyles']['shadow']['enabled'] ? 'item-has-box-shadow' : '';
$classes[]     = 'sidebar' === $attributes['variation'] && $attributes['itemStyles']['shadowHover']['enabled'] ? 'item-has-hover-box-shadow' : '';
$wishlist_data = wp_json_encode(
	array(
		'beforeLabel' => $sidebar['title']['before_text'],
		'afterLabel'  => $sidebar['title']['after_text'],
		'alignment'   => $sidebar['title']['alignment'],
	)
);
$output        = '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '" id="' . esc_attr( $block_id ) . '" wishlist-user-data=\'' . esc_attr( $wishlist_data ) . '\'>';

/* Wishlist Variation */
$wishlist_user_meta = get_user_meta( $attributes['userID'], 'cozy_block_wishlist_data', true );
if ( ! empty( $attributes['postType'] ) && 'product' === $attributes['postType'] && 'wishlist' === $attributes['variation'] ) {
	$cozy_product_id   = $block->context['postId'];
	$cozy_product      = wc_get_product( $cozy_product_id );
	$cozy_product_name = $cozy_product ? esc_js( $cozy_product->get_name() ) : '';

	$classes   = array();
	$classes[] = 'cozy-block-wishlist__icon-wrapper';
	$classes[] = 'wishlist__icon-wrapper';
	$classes[] = 'post-' . $cozy_product_id;
	$classes[] = is_array( $wishlist_user_meta ) && is_user_logged_in() && in_array( intval( $cozy_product_id ), $wishlist_user_meta ) ? 'is-active' : '';
	$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '" data-product-id="' . $cozy_product_id . '" data-product-name="' . esc_attr( $cozy_product_name ) . '" onClick="handleWishlistClick(' . $cozy_product_id . ', \'' . esc_js( $cozy_product_name ) . '\', \'' . esc_js( $block_id ) . '\')" title="' . esc_attr( 'Wishlist' ) . '">';

	$view_box   = array();
	$view_box[] = $attributes['wishlist']['icon']['viewBox']['vx'];
	$view_box[] = $attributes['wishlist']['icon']['viewBox']['vy'];
	$view_box[] = $attributes['wishlist']['icon']['viewBox']['vw'];
	$view_box[] = $attributes['wishlist']['icon']['viewBox']['vh'];
	$output    .= '<svg class="cozy-block-wishlist__icon wishlist__icon" viewBox="' . implode( ' ', $view_box ) . '" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">';
	$output    .= '<path d="' . $attributes['wishlist']['icon']['path'] . '" />';
	$output    .= '</svg>';

	$output .= '</div>';
}
/* End Wishlist Variation */

/* Sidebar Variation */
if ( 'sidebar' === $attributes['variation'] ) {
	$output    .= '<div class="cozy-block-wishlist__icon-wrapper sidebar__icon-wrapper" title="' . esc_attr__( 'Wishlist', 'cozy-addons' ) . '">';
	$view_box   = array();
	$view_box[] = $attributes['sidebar']['icon']['viewBox']['vx'];
	$view_box[] = $attributes['sidebar']['icon']['viewBox']['vy'];
	$view_box[] = $attributes['sidebar']['icon']['viewBox']['vw'];
	$view_box[] = $attributes['sidebar']['icon']['viewBox']['vh'];
	$output    .= '<svg class="cozy-block-wishlist__icon sidebar__icon" viewBox="' . implode( ' ', $view_box ) . '" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">';
	$output    .= '<path d="' . $attributes['sidebar']['icon']['path'] . '" />';
	$output    .= '</svg>';

	/* Wishlist Count */
	if ( isset( $attributes['sidebar']['count']['enabled'] ) && $attributes['sidebar']['count']['enabled'] ) {
		if ( is_user_logged_in() && is_array( $wishlist_user_meta ) && count( $wishlist_user_meta ) > 0 ) {
			$output .= '<span class="cozy-block-wishlist__count">';
			$output .= count( $wishlist_user_meta );
			$output .= '</span>';
		}
	}
	/* End Wishlist Count */

	$output .= '</div>';

	$classes   = array();
	$classes[] = 'cozy-block-wishlist__sidebar-wrapper';
	$classes[] = 'visibility-hidden';
	$classes[] = 'position-' . $attributes['sidebar']['position'];
	$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
	/* Sidebar */
	$output .= '<div class="cozy-block-wishlist__sidebar">';

	/* Close Button */
	$classes   = array();
	$classes[] = 'cozy-block-wishlist__toolbar-button';
	$classes[] = 'sidebar-close-button';
	$classes[] = 'position-' . $attributes['sidebar']['closeIcon']['position'];
	$output   .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
	$output   .= '<svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/" aria-hidden="true">';
	$output   .= '<path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z" />';
	$output   .= '</svg>';
	$output   .= '</div>';
	/* End Close Button */

	/* Sidebar Data */
	$output       .= '<div class="cozy-block-wishlist__sidebar-body">';
		$classes   = array();
		$classes[] = 'cozy-block-wishlist__sidebar-header';
		$output   .= '<div class="' . esc_attr( implode( '', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">';
	if ( $attributes['sidebar']['sidebarTitle']['toggle'] ) {
		// 1. Normalize $wishlist_user_meta to an array
		$wishlist_data = is_array( $wishlist_user_meta )
		? $wishlist_user_meta
		: json_decode( (string) $wishlist_user_meta, true ) ?? array();

		$wishlist_count = count( $wishlist_data );

		// 2. Build the output
		$alignment   = esc_attr( $sidebar['title']['alignment'] );
		$before_text = esc_attr( $sidebar['title']['before_text'] );
		$after_text  = esc_attr( $sidebar['title']['after_text'] );

		$output .= "<p class='sidebar-header-title title-align-{$alignment}'>{$before_text} " . esc_attr( $wishlist_count ) . " {$after_text}</p></div>";
	}
	if ( is_user_logged_in() ) {
		$output .= '<ul class="cozy-block-wishlist__product-data-wrapper">';
		if ( is_array( $wishlist_user_meta ) && ! empty( $wishlist_user_meta ) ) {
			krsort( $wishlist_user_meta );
			foreach ( $wishlist_user_meta as $product_id ) {
				$product = wc_get_product( $product_id );

				if ( $product ) {
					$product_name        = $product->get_name();
					$product_link        = get_permalink( $product_id );
					$product_type        = $product->get_type();
					$product_url         = 'external' !== $product_type ? get_permalink( $product_id ) : $product->get_product_url();
					$product_price       = wc_price( $product->get_price() );
					$product_description = $product->get_short_description();
					$product_image       = wp_get_attachment_url( $product->get_image_id() );
					$is_in_stock         = 'instock' === $product->get_stock_status();
					$add_to_cart_text    = $product->add_to_cart_text();
					$add_to_cart_url     = $product->add_to_cart_url();

					$open_in_new_tab = ! $is_in_stock
						? ! empty( $attributes['openLinkinNewTab']['outofStock'] )
						: ! empty( $attributes['openLinkinNewTab'][ $product_type ] );
					$target          = $open_in_new_tab ? ' target="_blank" rel="noopener"' : '';

					$trash_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="25" viewBox="0 0 22 25" fill="currentColor">
            <path d="M1.5625 22.6563C1.5625 23.2779 1.80943 23.874 2.24897 24.3135C2.68851 24.7531 3.28465 25 3.90625 25H17.9688C18.5904 25 19.1865 24.7531 19.626 24.3135C20.0656 23.874 20.3125 23.2779 20.3125 22.6563V6.25001H1.5625V22.6563ZM14.8438 10.1563C14.8438 9.94906 14.9261 9.75034 15.0726 9.60383C15.2191 9.45732 15.4178 9.37501 15.625 9.37501C15.8322 9.37501 16.0309 9.45732 16.1774 9.60383C16.3239 9.75034 16.4062 9.94906 16.4062 10.1563V21.0938C16.4062 21.301 16.3239 21.4997 16.1774 21.6462C16.0309 21.7927 15.8322 21.875 15.625 21.875C15.4178 21.875 15.2191 21.7927 15.0726 21.6462C14.9261 21.4997 14.8438 21.301 14.8438 21.0938V10.1563ZM10.1562 10.1563C10.1562 9.94906 10.2386 9.75034 10.3851 9.60383C10.5316 9.45732 10.7303 9.37501 10.9375 9.37501C11.1447 9.37501 11.3434 9.45732 11.4899 9.60383C11.6364 9.75034 11.7188 9.94906 11.7188 10.1563V21.0938C11.7188 21.301 11.6364 21.4997 11.4899 21.6462C11.3434 21.7927 11.1447 21.875 10.9375 21.875C10.7303 21.875 10.5316 21.7927 10.3851 21.6462C10.2386 21.4997 10.1562 21.301 10.1562 21.0938V10.1563ZM5.46875 10.1563C5.46875 9.94906 5.55106 9.75034 5.69757 9.60383C5.84409 9.45732 6.0428 9.37501 6.25 9.37501C6.4572 9.37501 6.65591 9.45732 6.80243 9.60383C6.94894 9.75034 7.03125 9.94906 7.03125 10.1563V21.0938C7.03125 21.301 6.94894 21.4997 6.80243 21.6462C6.65591 21.7927 6.4572 21.875 6.25 21.875C6.0428 21.875 5.84409 21.7927 5.69757 21.6462C5.55106 21.4997 5.46875 21.301 5.46875 21.0938V10.1563ZM21.0938 1.56251H15.2344L14.7754 0.649423C14.6782 0.454215 14.5284 0.29001 14.3429 0.175281C14.1575 0.0605526 13.9437 -0.00014785 13.7256 8.5609e-06H8.14453C7.92694 -0.000827891 7.71352 0.0596463 7.52871 0.174503C7.34391 0.289359 7.19519 0.453951 7.09961 0.649423L6.64062 1.56251H0.78125C0.57405 1.56251 0.375336 1.64482 0.228823 1.79133C0.08231 1.93784 0 2.13656 0 2.34376L0 3.90626C0 4.11346 0.08231 4.31217 0.228823 4.45869C0.375336 4.6052 0.57405 4.68751 0.78125 4.68751H21.0938C21.301 4.68751 21.4997 4.6052 21.6462 4.45869C21.7927 4.31217 21.875 4.11346 21.875 3.90626V2.34376C21.875 2.13656 21.7927 1.93784 21.6462 1.79133C21.4997 1.64482 21.301 1.56251 21.0938 1.56251Z"/>
        </svg>';

					$is_linked = 'external' === $product_type || 'variable' === $product_type || 'grouped' === $product_type || ! $is_in_stock;

					$classes   = array();
					$classes[] = 'cozy-block-wishlist__sidebar-button';
					$classes[] = $is_linked ? ( $is_in_stock ? '' : 'out-of-stock' ) : 'add__cart';
					$classes[] = esc_attr( $product_type ) . '_product';
					$classes   = array_filter( $classes );

					$output .= '<li class="cozy-block-wishlist__product-data post-' . $product_id . '">';

						/* Image */
					if ( ! empty( $product_image ) ) {
						$output .= '<figure class="cozy-block-wishlist__product-image">';
						$output .= '<a href="' . esc_url( $product_link ) . '"' . $target . '>';
						$output .= '<img src="' . esc_url( $product_image ) . '" />';
						$output .= '</a>';
						$output .= '</figure>';
					}
					/* End Image */

					/* Content */
					$output .= '<div class="cozy-block-wishlist__product-content">';

					/* Title + Price */
					$output .= '<div class="cozy-block-wishlist__product-title-price">';
					$output .= '<p class="cozy-block-wishlist__product-title"><a href="' . esc_url( $product_link ) . '"' . $target . '>' . $product_name . '</a></p>';
					$output .= '<p class="cozy-block-wishlist__product-price">' . $product_price . '</p>';
					$output .= '</div>';
					/* End Title + Price */

					/* Summary */
					$output .= '<p class="cozy-block-wishlist__product-summary">' . cozy_create_excerpt( $product_description, 15 ) . '</p>';
					/* End Summary */

					/* Buttons */
					$output .= '<div class="cozy-block-wishlist__btn-wrapper">';

					if ( $is_linked ) {
						$output .= '<a class="cozy-block-add-btn-has-link" href="' . esc_url( $product_url ) . '"' . $target . '>';
						$output .= '<div class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ) . '">' . $add_to_cart_text . '</div>';
						$output .= '</a>';
					} else {
						$output .= '<div class="' . implode( ' ', $classes ) . ' " data-product-id="' . $product_id . '"><span class="wishlist__add-to-cart_text">' . $add_to_cart_text . '</span></div>';
					}

					$output .= '<div class="cozy-block-wishlist__sidebar-button remove__wishlist" data-product-id="' . $product_id . '" data-product-name="' . esc_attr( $product_name ) . '">' . $trash_icon . '</div>';

					$output .= '</div>';
					/* End Buttons */

					$output .= '</div>';
					/* End Content */

					$output .= '</li>';
				}
			}
		}
		$output .= '</ul>';
	}
	$output .= '</div>';
	/* End Sidebar Data */

	/* Go to Cart Button */
	$cart_page_url = wc_get_cart_url();
	$output       .= '<div class="cozy-block-wishlist__cart-btn-wrapper"><a class="cozy-block-wishlist__cart-button" href="' . esc_url( $cart_page_url ) . '" rel="noopener" target="_blank">';
	$output       .= esc_html__( 'View my cart', 'cozy-addons' );
	$output       .= '</a></div>';
	/* End Cart Button */

	$output .= '</div>';
	/* End Sidebar */
	$output .= '</div>';
}
/* End Sidebar Variation */
$output .= '</div>';

$wrapper_attributes = get_block_wrapper_attributes();
if ( 'sidebar' === $attributes['variation'] ) {
	$font_families = array();

	if ( isset( $attributes['sidebar']['count']['font']['family'] ) && ! empty( $attributes['sidebar']['count']['font']['family'] ) ) {
		$font_families[] = $attributes['sidebar']['count']['font']['family'];
	}
	if ( isset( $attributes['sidebar']['productTitle']['font']['family'] ) && ! empty( $attributes['sidebar']['productTitle']['font']['family'] ) ) {
		$font_families[] = $attributes['sidebar']['productTitle']['font']['family'];
	}
	if ( isset( $attributes['sidebar']['productSummary']['font']['family'] ) && ! empty( $attributes['sidebar']['productSummary']['font']['family'] ) ) {
		$font_families[] = $attributes['sidebar']['productSummary']['font']['family'];
	}
	if ( isset( $attributes['sidebar']['productPrice']['font']['family'] ) && ! empty( $attributes['sidebar']['productPrice']['font']['family'] ) ) {
		$font_families[] = $attributes['sidebar']['productPrice']['font']['family'];
	}
	if ( isset( $attributes['sidebar']['button']['font']['family'] ) && ! empty( $attributes['sidebar']['button']['font']['family'] ) ) {
		$font_families[] = $attributes['sidebar']['button']['font']['family'];
	}
	if ( isset( $attributes['toastCard']['font']['family'] ) && ! empty( $attributes['toastCard']['font']['family'] ) ) {
		$font_families[] = $attributes['toastCard']['font']['family'];
	}
	if ( isset( $attributes['sidebar']['sidebarTitle']['font']['family'] ) && ! empty( $attributes['toastCard']['font']['family'] ) ) {
		$font_families[] = $attributes['sidebar']['sidebarTitle']['font']['family'];
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
}

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);


$render = sprintf( '<div class="cozy-block-wrapper cozy-block-wishlist-wrapper justify-' . $wishlist_icon['default']['align'] . '"><div %1$s>%2$s</div></div>', $wrapper_attributes, $output );
echo $render;

if ( ! function_exists( 'add_to_wishlist_cookie' ) ) {
	function add_to_wishlist_cookie( $product_id ) {
		$wishlist = isset( $_COOKIE['wishlist'] ) ? json_decode( sanitize_key( wp_unslash( $_COOKIE['wishlist'] ) ), true ) : array();
		if ( ! in_array( $product_id, $wishlist ) ) {
			$wishlist[] = $product_id;
			setcookie( 'wishlist', wp_json_encode( $wishlist ), time() + ( 86400 * 30 ), '/' ); // 30 days expiration
			return true;
		}
		return false; // Item already in wishlist.
	}
}

if ( ! is_user_logged_in() ) {
	?>
<script src="<?php echo esc_url( trailingslashit( COZY_ADDONS_PLUGIN_URL ) ) . 'vendor/jquery/jquery.js'; ?>"></script>
<script type="text/javascript">
	var showWishlistCount = <?php echo ( isset( $attributes['sidebar']['count']['enabled'] ) && $attributes['sidebar']['count']['enabled'] ) ? 'true' : 'false'; ?>;

	function getLocalWishlist() {
		return JSON.parse(localStorage.getItem("cozy_block_wishlist_data")) || [];
	}

	function updateLocalWishlist(productId) {
		let wishlist = getLocalWishlist();

		if (wishlist.includes(productId)) {
			wishlist = wishlist.filter((id) => parseInt(id) !== parseInt(productId));
		} else {
			wishlist.push(productId);
		}

		localStorage.setItem("cozy_block_wishlist_data", JSON.stringify(wishlist));
	}

	function updateWishlistCount(wishlistData) {
		if (showWishlistCount === true) {
			if (wishlistData.length > 0) {
				if ($('.cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count').length) {
					$('.cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count').html(wishlistData.length);
				} else {
					$('.cozy-block-wishlist.variation-sidebar .sidebar__icon-wrapper').append(
						`<span class="cozy-block-wishlist__count">${wishlistData.length}</span>`
					);
				}
			} else {
				$('.cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count').remove();
			}
		}
	}

	$(document).ready(function() {
		const wishlistData = getLocalWishlist();

		updateWishlistCount(wishlistData);

		wishlistData.forEach((productID) => {
			const wishlistIconWrapper = document.querySelector(
				'.cozy-block-wishlist.variation-wishlist .post-' + productID
			);
			if (wishlistIconWrapper) {
				wishlistIconWrapper.classList.add('is-active');
			}
		});
	});

function handleWishlistClick(productId, productName, blockId) {
	const $icon = $('.cozy-block-wrapper .wishlist__icon-wrapper[data-product-id="' + productId + '"]');

	$icon.addClass("is-loading-spinner");

	updateLocalWishlist(productId);

	const wishlistData = getLocalWishlist();

	if (wishlistData.includes(productId)) {
		$icon.addClass("is-active");
	} else {
		$icon.removeClass("is-active");
	}

	$icon.removeClass("is-loading-spinner");

	updateWishlistCount(wishlistData);

	const isNowActive = wishlistData.includes(productId);
	const actionLabel = isNowActive ? 'added to' : 'removed from';
	let $toast = $('body > #' + blockId + '.cozy-block-wishlist__toast');
	if (!$toast.length) {
		$('body').append('<div id="' + blockId + '" class="cozy-block-wishlist__toast visibility-hidden"></div>');
		$toast = $('body > #' + blockId + '.cozy-block-wishlist__toast');
	}
	$toast.html(`${productName} has been ${actionLabel} Wishlist`).removeClass('visibility-hidden');
	setTimeout(() => {
		$toast.addClass('visibility-hidden');
		$toast.remove();
	}, 2000);
}
</script>
	<?php
}

if ( 'wishlist' === $attributes['variation'] && is_user_logged_in() ) {
	?>
<script src="<?php echo esc_url( trailingslashit( COZY_ADDONS_PLUGIN_URL ) ) . 'vendor/jquery/jquery.js'; ?>"></script>
<script type="text/javascript">
	var showWishlistCount = <?php echo ( isset( $attributes['sidebar']['count']['enabled'] ) && $attributes['sidebar']['count']['enabled'] ) ? 'true' : 'false'; ?>;

	function updateSidebarRender(wishlistData) {
		$.ajax({
			url: "<?php echo esc_url( $attributes['ajaxUrl'] ); ?>",
			method: "POST",
			data: {
				action: "cozy_block_wishlist_render_data_sidebar",
				sidebarNonce: "<?php echo sanitize_key( $attributes['sidebarNonce'] ); ?>",
				wishlistData: JSON.stringify(wishlistData),
				beforeLabel: "<?php echo esc_attr( $sidebar['title']['before_text'] ); ?>",
				afterLabel: "<?php echo esc_attr( $sidebar['title']['after_text'] ); ?>",
				alignment: "<?php echo esc_attr( $sidebar['title']['alignment'] ); ?>",
			},
			success: function(response) {
				if (response.data) {
					$('.cozy-block-wishlist__sidebar-body').html(response.data.render);
				}
			},
			error: function(error) {
				console.log("Unable to load data...");
			},
		});
	}

function handleWishlistClick(productId, productName, blockId) {
		let $toast = null;
		$.ajax({
			url: "<?php echo esc_url( $attributes['ajaxUrl'] ); ?>",
			method: "POST",
			data: {
				action: "cozy_block_wishlist_update_user_wishlist",
				wishlistNonce: "<?php echo sanitize_key( $attributes['wishlistNonce'] ); ?>",
				productId: productId,
				userId: "<?php echo sanitize_key( $attributes['userID'] ); ?>",
			},
			beforeSend: function() {
				$('.cozy-block-wrapper .wishlist__icon-wrapper[data-product-id="' + productId + '"]').addClass("is-loading-spinner");
			},
			success: function(response) {
				if (response.data.user_wishlist.includes(parseInt(productId))) {
					$('.cozy-block-wrapper .wishlist__icon-wrapper[data-product-id="' + productId + '"]').addClass("is-active");
				} else {
					$('.cozy-block-wrapper .wishlist__icon-wrapper[data-product-id="' + productId + '"]').removeClass("is-active");
				}

				if (showWishlistCount === true) {
					if (response.data.user_wishlist.length > 0) {
						if ($('.cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count').length) {
							$('.cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count').html(response.data.user_wishlist.length);
						} else {
							$('.cozy-block-wishlist.variation-sidebar .sidebar__icon-wrapper').append(
								`<span class="cozy-block-wishlist__count">${response.data.user_wishlist.length}</span>`
							);
						}
					} else {
						$('.cozy-block-wishlist.variation-sidebar .cozy-block-wishlist__count').remove();
					}
				}

				updateSidebarRender(response.data.user_wishlist);

				const isNowActive = response.data.user_wishlist.includes(parseInt(productId));
				const actionLabel = isNowActive ? 'added to' : 'removed from';
				$('body > #' + blockId + '.cozy-block-wishlist__toast').remove();
				$('body').append('<div id="' + blockId + '" class="cozy-block-wishlist__toast visibility-hidden"></div>');
				$toast = $('body > #' + blockId + '.cozy-block-wishlist__toast');
				$toast.html(`${productName} has been ${actionLabel} Wishlist`).removeClass('visibility-hidden');
			},
			error: function(error) {
				console.log('Unable to update wishlist...');
			},
			complete: function() {
				$('.cozy-block-wrapper .wishlist__icon-wrapper[data-product-id="' + productId + '"]').removeClass("is-loading-spinner");
				setTimeout(() => {
					if ($toast) {
						$toast.addClass('visibility-hidden');
						$toast.remove();
					}
				}, 2000);
			}
		});
	}
</script>
	<?php
}
?>
