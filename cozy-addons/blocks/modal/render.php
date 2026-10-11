<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * The popup opens on page load when it comes from the Popup Builder,
 * and on button click everywhere else.
 */
$attributes['modalEvent'] = cozy_addons_is_rendering_popup_builder() ? 'load' : 'click';

/*
 * Visibility rules. Premium only: free popups are always shown.
 *
 * 1. On the front page the "Show in homepage" toggle alone decides.
 * 2. Deny lists win: a denied page or post type hides the popup.
 * 3. An enabled, non-empty allow list means "only here": the popup shows only
 *    where the page or the post type is on an allow list.
 * 4. Logged-in users are then checked against the role lists.
 *
 * These checks run before any script data is localized, so a hidden popup
 * leaves nothing behind on the page.
 */
if ( cozy_addons_premium_access() ) {
	// Returns a list only when its toggle is on.
	$cozy_visibility_list = static function ( $visibility, $toggle, $list ) {
		if ( ! is_array( $visibility ) || empty( $visibility[ $toggle ] ) || ! filter_var( $visibility[ $toggle ], FILTER_VALIDATE_BOOLEAN ) ) {
			return array();
		}

		return isset( $visibility[ $list ] ) && is_array( $visibility[ $list ] ) ? $visibility[ $list ] : array();
	};

	$page_visibility      = isset( $attributes['pageVisibility'] ) ? $attributes['pageVisibility'] : array();
	$post_type_visibility = isset( $attributes['postTypeVisibility'] ) ? $attributes['postTypeVisibility'] : array();
	$role_visibility      = isset( $attributes['roleVisibility'] ) ? $attributes['roleVisibility'] : array();

	/* Page and post type validation */
	if ( is_front_page() ) {
		if ( isset( $page_visibility['homepage'] ) && ! filter_var( $page_visibility['homepage'], FILTER_VALIDATE_BOOLEAN ) ) {
			return;
		}
	} else {
		// Page slug of the current view, empty when it is not a page.
		$the_page_slug = is_page() ? (string) get_post_field( 'post_name', get_queried_object_id() ) : '';

		// Post type of the current view: single views, post type archives and the blog index.
		$the_post_type = '';
		if ( is_singular() ) {
			$the_post_type = (string) get_post_type( get_queried_object_id() );
		} elseif ( is_post_type_archive() ) {
			$the_post_type = get_query_var( 'post_type' );
			$the_post_type = is_array( $the_post_type ) ? (string) reset( $the_post_type ) : (string) $the_post_type;
		} elseif ( is_home() ) {
			$the_post_type = 'post';
		}

		$page_allowed = $cozy_visibility_list( $page_visibility, 'hasAllowedList', 'allowedList' );
		$page_denied  = $cozy_visibility_list( $page_visibility, 'hasDenyList', 'denyList' );
		$type_allowed = $cozy_visibility_list( $post_type_visibility, 'hasAllowedList', 'allowedList' );
		$type_denied  = $cozy_visibility_list( $post_type_visibility, 'hasDenyList', 'denyList' );

		$is_page_denied = '' !== $the_page_slug && in_array( $the_page_slug, $page_denied, true );
		$is_type_denied = '' !== $the_post_type && in_array( $the_post_type, $type_denied, true );

		if ( $is_page_denied || $is_type_denied ) {
			return;
		}

		if ( ! empty( $page_allowed ) || ! empty( $type_allowed ) ) {
			$is_page_allowed = '' !== $the_page_slug && in_array( $the_page_slug, $page_allowed, true );
			$is_type_allowed = '' !== $the_post_type && in_array( $the_post_type, $type_allowed, true );

			if ( ! $is_page_allowed && ! $is_type_allowed ) {
				return;
			}
		}
	}

	/* User validation */
	if ( is_user_logged_in() ) {
		$role_allowed = $cozy_visibility_list( $role_visibility, 'hasAllowedList', 'allowedList' );
		$role_denied  = $cozy_visibility_list( $role_visibility, 'hasDenyList', 'denyList' );

		$user  = wp_get_current_user();
		$roles = (array) $user->roles;

		if ( ! empty( array_intersect( $roles, $role_denied ) ) ) {
			return;
		}

		if ( ! empty( $role_allowed ) && empty( array_intersect( $roles, $role_allowed ) ) ) {
			return;
		}
	}
}

$client_id      = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$cozy_block_var = 'cozyModal_' . str_replace( '-', '_', $client_id );

$attributes['isPremium'] = cozy_addons_premium_access();

/*
 * Analytics, a premium feature. Only popups rendered from the Popup Builder are
 * tracked, since those are the ones listed on the Popup Builder screen. Visits
 * by users who can edit posts are left out so testing does not inflate the
 * numbers. Without these values the frontend script sends nothing, so free
 * sites make no tracking requests at all.
 */
$cozy_popup_id = cozy_addons_rendering_popup_id();
if ( $cozy_popup_id && $attributes['isPremium'] ) {
	$attributes['popupId']     = $cozy_popup_id;
	$attributes['trackUrl']    = esc_url_raw( rest_url( 'cozy-block/v1/popup-event' ) );
	$attributes['trackEvents'] = ! current_user_can( 'edit_posts' );
}

wp_localize_script( 'cozy-block--modal--frontend-script', $cozy_block_var, $attributes );
wp_add_inline_script( 'cozy-block--modal--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockModalInit( "' . esc_html( $client_id ) . '" ) }) ' );

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$modal = array(
	'desktop'      => array(
		'padding' => isset( $attributes['styles']['desktop']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['styles']['desktop']['padding'] ) : '',
		'margin'  => isset( $attributes['styles']['desktop']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['styles']['desktop']['margin'] ) : '',
		'width'   => isset( $attributes['styles']['desktop']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['styles']['desktop']['width'] ) : '',
		'height'  => isset( $attributes['styles']['desktop']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['styles']['desktop']['height'] ) : '',
	),
	'tablet'       => array(
		'padding' => isset( $attributes['styles']['tablet']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['styles']['tablet']['padding'] ) : '',
		'margin'  => isset( $attributes['styles']['tablet']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['styles']['tablet']['margin'] ) : '',
		'width'   => isset( $attributes['styles']['tablet']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['styles']['tablet']['width'] ) : '',
		'height'  => isset( $attributes['styles']['tablet']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['styles']['tablet']['height'] ) : '',
	),
	'mobile'       => array(
		'padding' => isset( $attributes['styles']['mobile']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['styles']['mobile']['padding'] ) : '',
		'margin'  => isset( $attributes['styles']['mobile']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['styles']['mobile']['margin'] ) : '',
		'width'   => isset( $attributes['styles']['mobile']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['styles']['mobile']['width'] ) : '',
		'height'  => isset( $attributes['styles']['mobile']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['styles']['mobile']['height'] ) : '',
	),
	'border'       => isset( $attributes['styles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['styles']['border'] ) : '',
	'radius'       => isset( $attributes['styles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['styles']['radius'] ) : '',
	'overlay_blur' => isset( $attributes['overlayBlur'] ) ? cozy_addons_sanitize_dimension( $attributes['overlayBlur'] ) : '',
	'color'        => array(
		'bg'      => isset( $attributes['backgroundColor'] ) ? esc_attr( sanitize_text_field( $attributes['backgroundColor'] ) ) : '',
		'overlay' => isset( $attributes['backgroundOverlayColor'] ) ? esc_attr( sanitize_text_field( $attributes['backgroundOverlayColor'] ) ) : '',
	),
);

$button_styles = array(
	'justify'        => isset( $attributes['clickButtonStyles']['justify'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['justify'] ) ) : 'center',
	'content'        => isset( $attributes['clickButtonStyles']['content'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['content'] ) ) : 'default',
	'margin'         => isset( $attributes['clickButtonStyles']['margin'] ) ? cozy_render_TRBL( 'margin', $attributes['clickButtonStyles']['margin'] ) : '',
	'desktop'        => array(
		'padding' => isset( $attributes['clickButtonStyles']['desktop']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['clickButtonStyles']['desktop']['padding'] ) : '',
		'width'   => isset( $attributes['clickButtonStyles']['desktop']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['desktop']['width'] ) : '',
		'height'  => isset( $attributes['clickButtonStyles']['desktop']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['desktop']['height'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['clickButtonStyles']['desktop']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'         => array(
		'padding' => isset( $attributes['clickButtonStyles']['tablet']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['clickButtonStyles']['tablet']['padding'] ) : '',
		'width'   => isset( $attributes['clickButtonStyles']['tablet']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['tablet']['width'] ) : '',
		'height'  => isset( $attributes['clickButtonStyles']['tablet']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['tablet']['height'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['clickButtonStyles']['tablet']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'         => array(
		'padding' => isset( $attributes['clickButtonStyles']['mobile']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['clickButtonStyles']['mobile']['padding'] ) : '',
		'width'   => isset( $attributes['clickButtonStyles']['mobile']['width'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['mobile']['width'] ) : '',
		'height'  => isset( $attributes['clickButtonStyles']['mobile']['height'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['mobile']['height'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['clickButtonStyles']['mobile']['font']['size'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['mobile']['font']['size'] ) : '',
		),
	),
	'border'         => isset( $attributes['clickButtonStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['clickButtonStyles']['border'] ) : '',
	'radius'         => isset( $attributes['clickButtonStyles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['radius'] ) : '',
	'font'           => array(
		'weight' => isset( $attributes['clickButtonStyles']['fontWeight'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['fontWeight'] ) ) : '',
		'family' => isset( $attributes['clickButtonStyles']['fontFamily'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['fontFamily'] ) ) : '',
	),
	'letter_case'    => isset( $attributes['clickButtonStyles']['letterCase'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['letterCase'] ) ) : '',
	'decoration'     => isset( $attributes['clickButtonStyles']['decoration'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['decoration'] ) ) : '',
	'line_height'    => isset( $attributes['clickButtonStyles']['lineHeight'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['lineHeight'] ) : '',
	'letter_spacing' => isset( $attributes['clickButtonStyles']['letterSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['clickButtonStyles']['letterSpacing'] ) : '',
	'color'          => array(
		'text'         => isset( $attributes['clickButtonStyles']['color'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['color'] ) ) : '',
		'text_hover'   => isset( $attributes['clickButtonStyles']['colorHover'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['colorHover'] ) ) : '',
		'bg'           => isset( $attributes['clickButtonStyles']['bgColor'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['bgColor'] ) ) : '',
		'bg_hover'     => isset( $attributes['clickButtonStyles']['bgColorHover'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['bgColorHover'] ) ) : '',
		'border_hover' => isset( $attributes['clickButtonStyles']['borderColorHover'] ) ? esc_attr( sanitize_text_field( $attributes['clickButtonStyles']['borderColorHover'] ) ) : '',
	),
);

$icon_styles = array(
	'position'   => isset( $attributes['iconStyles']['alignment'] ) ? esc_attr( sanitize_text_field( $attributes['iconStyles']['alignment'] ) ) : 'right',
	'top'        => isset( $attributes['iconStyles']['vSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['iconStyles']['vSpacing'] ) : '',
	'left'       => isset( $attributes['iconStyles']['hSpacing'] ) ? cozy_addons_sanitize_dimension( $attributes['iconStyles']['hSpacing'] ) : '',
	'box_width'  => isset( $attributes['iconStyles']['boxWidth'] ) ? esc_attr( $attributes['iconStyles']['boxWidth'] ) : '',
	'box_height' => isset( $attributes['iconStyles']['boxHeight'] ) ? esc_attr( $attributes['iconStyles']['boxHeight'] ) : '',
	'size'       => isset( $attributes['iconStyles']['size'] ) ? esc_attr( $attributes['iconStyles']['size'] ) : '',
	'border'     => isset( $attributes['iconStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['iconStyles']['border'] ) : '',
	'radius'     => isset( $attributes['iconStyles']['radius'] ) ? cozy_addons_sanitize_dimension( $attributes['iconStyles']['radius'] ) : '',
	'z_index'    => isset( $attributes['iconStyles']['zIndex'] ) ? cozy_addons_sanitize_dimension( $attributes['iconStyles']['zIndex'] ) : '100',
	'color'      => array(
		'icon'         => isset( $attributes['iconStyles']['iconColor'] ) ? esc_attr( $attributes['iconStyles']['iconColor'] ) : '',
		'icon_hover'   => isset( $attributes['iconStyles']['iconColorHover'] ) ? esc_attr( $attributes['iconStyles']['iconColorHover'] ) : '',
		'bg'           => isset( $attributes['iconStyles']['bg'] ) ? esc_attr( $attributes['iconStyles']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['iconStyles']['bgHover'] ) ? esc_attr( $attributes['iconStyles']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['iconStyles']['borderHover'] ) ? esc_attr( $attributes['iconStyles']['borderHover'] ) : '',
	),
);

$block_styles = "
#$block_id {
	{$modal['desktop']['padding']}
	{$modal['desktop']['margin']}
	{$modal['border']}
	border-radius: {$modal['radius']};
	background-color: {$modal['color']['bg']};
}
.block-$block_id .cozy-block-modal.type-default {
	width: {$modal['desktop']['width']};
	height: {$modal['desktop']['height']};
}

.block-$block_id .cozy-block-modal__overlay {
	background-color: {$modal['color']['overlay']};
	backdrop-filter: blur({$modal['overlay_blur']});
}

.block-$block_id .close-icon-wrapper {
	width: {$icon_styles['box_width']};
	height: {$icon_styles['box_height']};
	{$icon_styles['border']}
	border-radius: {$icon_styles['radius']};
	background-color: {$icon_styles['color']['bg']};
	color: {$icon_styles['color']['icon']};
	z-index: {$icon_styles['z_index']};
	margin-top: {$icon_styles['top']};

	&.position-left {
		margin-left: {$icon_styles['left']};
	}
	&.position-right {
		margin-right: {$icon_styles['left']};
	}

	& svg {
		width: {$icon_styles['size']};
		height: {$icon_styles['size']};
	}

	&:hover {
		background-color: {$icon_styles['color']['bg_hover']};
		color: {$icon_styles['color']['icon_hover']};
		border-color: {$icon_styles['color']['border_hover']};
	}
}

.cozy-block-modal-wrapper.block-$block_id .cozy-modal-button {
	{$button_styles['margin']}
}
.block-$block_id .cozy-modal-button.content-default {
	{$button_styles['desktop']['padding']}
	{$button_styles['border']}
	border-radius: {$button_styles['radius']};
	font-size: {$button_styles['desktop']['font']['size']};
	font-weight: {$button_styles['font']['weight']};
	font-family: {$button_styles['font']['family']};
	text-transform: {$button_styles['letter_case']};
	text-decoration: {$button_styles['decoration']};
	line-height: {$button_styles['line_height']};
	letter-spacing: {$button_styles['letter_spacing']};
	background-color: {$button_styles['color']['bg']};
	color: {$button_styles['color']['text']};

	&:hover {
		background-color: {$button_styles['color']['bg_hover']};
		color: {$button_styles['color']['text_hover']};
		border-color: {$button_styles['color']['border_hover']};
	}
}
.block-$block_id .cozy-modal-button.content-image .button-image {
	max-width: {$button_styles['desktop']['width']};
	max-height: {$button_styles['desktop']['height']};
	{$button_styles['border']}
	border-radius: {$button_styles['radius']};

	& img {
		border-radius: {$button_styles['radius']};
	}
}

@media (width <= 1024px) {
	#$block_id {
		{$modal['tablet']['padding']}
		{$modal['tablet']['margin']}
	}
	.block-$block_id .cozy-block-modal.type-default {
		width: {$modal['tablet']['width']};
		height: {$modal['tablet']['height']};
	}

	.block-$block_id .cozy-modal-button.content-image .button-image {
		max-width: {$button_styles['tablet']['width']};
		max-height: {$button_styles['tablet']['height']};
	}
}

@media (width <= 767px) {
	#$block_id {
		{$modal['mobile']['padding']}
		{$modal['mobile']['margin']}
	}
	.block-$block_id .cozy-block-modal.type-default {
		width: {$modal['mobile']['width']};
		height: {$modal['mobile']['height']};
	}

	.block-$block_id .cozy-modal-button.content-image .button-image {
		max-width: {$button_styles['mobile']['width']};
		max-height: {$button_styles['mobile']['height']};
	}
}
";

$font_families = array();

if ( isset( $attributes['clickButtonStyles']['font']['family'] ) && ! empty( $attributes['clickButtonStyles']['font']['family'] ) ) {
	$font_families[] = sanitize_text_field( $attributes['clickButtonStyles']['font']['family'] );
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

// Render styles here for 'wp_body_open' hook.
echo '<style>' . cozy_addons_clean_empty_css( $block_styles ) . '</style>';

$classes   = array();
$classes[] = 'cozy-block-wrapper';
$classes[] = 'cozy-block-modal-wrapper';
$classes[] = 'block-' . $block_id;
$classes[] = isset( $attributes['modalType'], $attributes['modalEvent'], $attributes['clickButtonStyles']['variation'] ) && 'default' === $attributes['modalType'] && 'click' === $attributes['modalEvent'] ? 'variation-' . $attributes['clickButtonStyles']['variation'] : '';
$classes[] = isset( $attributes['modalType'], $attributes['modalEvent'], $attributes['clickButtonStyles']['variation'], $attributes['clickButtonStyles']['placement'] ) && 'default' === $attributes['modalType'] && 'click' === $attributes['modalEvent'] && 'float' === $attributes['clickButtonStyles']['variation'] ? 'placement-' . str_replace( ' ', '-', $attributes['clickButtonStyles']['placement'] ) : '';
$classes[] = isset( $attributes['responsiveVisibility']['desktop'] ) && ! filter_var( $attributes['responsiveVisibility']['desktop'], FILTER_VALIDATE_BOOLEAN ) ? 'is-hidden__desktop' : '';
$classes[] = isset( $attributes['responsiveVisibility']['tablet'] ) && ! filter_var( $attributes['responsiveVisibility']['tablet'], FILTER_VALIDATE_BOOLEAN ) ? 'is-hidden__tablet' : '';
$classes[] = isset( $attributes['responsiveVisibility']['mobile'] ) && ! filter_var( $attributes['responsiveVisibility']['mobile'], FILTER_VALIDATE_BOOLEAN ) ? 'is-hidden__mobile' : '';
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
	<?php
	$classes   = array();
	$classes[] = 'cozy-block-modal';
	$classes[] = isset( $attributes['modalType'] ) ? 'type-' . $attributes['modalType'] : '';
	$classes[] = isset( $attributes['modalType'], $attributes['modalEvent'] ) && 'default' === $attributes['modalType'] ? 'event-' . $attributes['modalEvent'] : '';
	$classes[] = isset( $attributes['modalType'] ) && 'default' === $attributes['modalType'] ? 'display-none' : '';
	$classes[] = isset( $attributes['modalType'], $attributes['placement'] ) && 'default' === $attributes['modalType'] ? 'position-' . str_replace( ' ', '-', $attributes['placement'] ) : '';
	?>
	<div id="<?php echo esc_attr( $block_id ); ?>"
		class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
		<?php
		if ( isset( $attributes['iconStyles']['enabled'] ) && filter_var( $attributes['iconStyles']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
			$classes   = array();
			$classes[] = 'close-icon-wrapper';
			$classes[] = isset( $attributes['iconStyles']['alignment'] ) ? 'position-' . $attributes['iconStyles']['alignment'] : '';

			?>
		<div
			class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<svg width="16" height="16" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				<path
					d="M10.9449 9.66003C11.3049 10.02 11.3049 10.58 10.9449 10.94C10.7649 11.12 10.5449 11.2 10.3049 11.2C10.0649 11.2 9.84493 11.12 9.66493 10.94L6.00492 7.28004L2.34491 10.94C2.16491 11.12 1.94492 11.2 1.70492 11.2C1.46492 11.2 1.24493 11.12 1.06493 10.94C0.704932 10.58 0.704932 10.02 1.06493 9.66003L4.72492 6.00004L1.06493 2.34004C0.704932 1.98004 0.704932 1.42004 1.06493 1.06004C1.42493 0.700037 1.98491 0.700037 2.34491 1.06004L6.00492 4.72003L9.66493 1.06004C10.0249 0.700037 10.5849 0.700037 10.9449 1.06004C11.3049 1.42004 11.3049 1.98004 10.9449 2.34004L7.2849 6.00004L10.9449 9.66003Z" />
			</svg>
		</div>
			<?php
		}
		?>

		<?php
		$popup_id = isset( $attributes['selectedCPT'] ) ? sanitize_text_field( $attributes['selectedCPT'] ) : '';
		if ( cozy_addons_premium_access() && isset( $attributes['source'] ) && 'popup-builder' === $attributes['source'] && ! empty( $popup_id ) ) {
			$post_status = get_post_status( $popup_id );
			if ( 'publish' === $post_status ) {
				$popup_content = get_post_field( 'post_content', $popup_id );
				$blocks        = parse_blocks( $popup_content );
				foreach ( $blocks as $block ) {
					echo render_block( $block );
				}
			}
		} else {
			echo $content;
		}
		?>
	</div>
	<?php
	if ( isset( $attributes['modalType'] ) && 'default' === $attributes['modalType'] ) {
		if ( ! isset( $attributes['addOverlay'] ) || ( isset( $attributes['addOverlay'] ) && filter_var( $attributes['addOverlay'], FILTER_VALIDATE_BOOLEAN ) ) ) {
			?>
		<div class="cozy-block-modal__overlay display-none"></div>
			<?php
		}

		if ( isset( $attributes['modalEvent'] ) && 'click' === $attributes['modalEvent'] ) {
			$classes   = array();
			$classes[] = 'cozy-modal-button';
			$classes[] = ! isset( $attributes['clickButtonStyles']['variation'] ) || ( isset( $attributes['clickButtonStyles']['variation'] ) && 'default' === $attributes['clickButtonStyles']['variation'] ) ? 'align-' . $button_styles['justify'] : '';
			$classes[] = 'content-' . $button_styles['content'];
			?>
	<button
		class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<?php
			if ( ! isset( $attributes['clickButtonStyles']['content'] ) || ( isset( $attributes['clickButtonStyles']['content'] ) && 'default' === $attributes['clickButtonStyles']['content'] ) ) {
				$label = isset( $attributes['clickButtonStyles']['label'] ) ? sanitize_text_field( $attributes['clickButtonStyles']['label'] ) : '';
				echo esc_html( $label );
			} elseif ( isset( $attributes['clickButtonStyles']['content'], $attributes['clickButtonStyles']['imgURL'] ) && 'image' === $attributes['clickButtonStyles']['content'] ) {
				$classes   = array();
				$classes[] = 'button-image';
				$classes[] = isset( $attributes['clickButtonStyles']['imgHasPulse'] ) && filter_var( $attributes['clickButtonStyles']['imgHasPulse'], FILTER_VALIDATE_BOOLEAN ) ? 'has-pulse-animation' : '';
				?>
		<figure
			class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php
					$img_alt = isset( $attributes['clickButtonStyles']['imgAlt'] ) ? sanitize_text_field( $attributes['clickButtonStyles']['imgAlt'] ) : '';
				?>
			<img src="<?php echo esc_url( $attributes['clickButtonStyles']['imgURL'] ); ?>"
				alt="<?php echo esc_attr( $img_alt ); ?>" />
		</figure>
				<?php
			}
			?>
	</button>
			<?php
		}
	}
	?>
</div>