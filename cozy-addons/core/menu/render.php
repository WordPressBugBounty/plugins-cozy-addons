<?php
/**
 * Server-side rendering for every block. Output is semantic, crawlable HTML:
 * <nav> > <ul> > <li> > <a>, with <button> only for real toggles.
 */
defined( 'ABSPATH' ) || exit;

/* ---------------------------------------------------------------- fragments */

/** Plain-text label: no tags, entities preserved (RichText stores &amp; etc.). Safe to print as HTML text. */
function cozy_addons_menu_label( $html ) {
	return wp_kses( cozy_addons_menu_str( $html ), array() );
}

/**
 * A menu link URL, sanitised: only the protocols WordPress allows (no javascript:, data: and the like).
 * A URL that is not allowed becomes '', so the item renders without a link instead of with an empty href.
 */
function cozy_addons_menu_item_url( $url ) {
	$url = trim( cozy_addons_menu_str( $url ) );
	return '' === $url ? '' : esc_url_raw( $url );
}

/** Link relationship: only known rel keywords are kept. */
function cozy_addons_menu_rel( $rel ) {
	$allowed = array( 'alternate', 'author', 'bookmark', 'external', 'help', 'license', 'me', 'next', 'nofollow', 'noopener', 'noreferrer', 'opener', 'prev', 'privacy-policy', 'search', 'sponsored', 'tag', 'terms-of-service', 'ugc' );
	$tokens  = preg_split( '/\s+/', strtolower( trim( cozy_addons_menu_str( $rel ) ) ) );
	return implode( ' ', array_unique( array_intersect( (array) $tokens, $allowed ) ) );
}

function cozy_addons_menu_chevron() {
	return '<svg class="cozy-addons-menu-caret" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M6 9l6 6 6-6"/></svg>';
}

function cozy_addons_menu_link_html( $url, $new_tab, $rel, $class, $inner, $current = false ) {
	$rel = cozy_addons_menu_rel( $rel );
	if ( $new_tab ) {
		$rel = trim( $rel . ' noopener noreferrer' );
	}
	$attrs = ' class="' . esc_attr( $class ) . '" href="' . esc_url( cozy_addons_menu_str( $url ) ) . '"';
	if ( $new_tab ) {
		$attrs .= ' target="_blank"';
	}
	if ( '' !== $rel ) {
		$attrs .= ' rel="' . esc_attr( $rel ) . '"';
	}
	if ( $current ) {
		$attrs .= ' aria-current="page"';
	}
	return '<a' . $attrs . '>' . $inner . '</a>';
}

/** Icon + label (+ description) + badge. */
function cozy_addons_menu_item_inner( array $a ) {
	$html = '';
	if ( ! empty( $a['icon'] ) ) {
		$svg = cozy_addons_menu_icon( $a['icon'] );
		if ( '' !== $svg ) {
			$html .= '<span class="cozy-addons-menu-ico">' . $svg . '</span>';
		}
	}
	$text        = '<span class="cozy-addons-menu-label">' . cozy_addons_menu_label( isset( $a['label'] ) ? $a['label'] : '' ) . '</span>';
	$description = sanitize_text_field( cozy_addons_menu_str( isset( $a['description'] ) ? $a['description'] : '' ) );
	if ( '' !== $description ) {
		$text .= '<span class="cozy-addons-menu-desc">' . esc_html( $description ) . '</span>';
	}
	$html .= '<span class="cozy-addons-menu-text">' . $text . '</span>';
	$badge = sanitize_text_field( cozy_addons_menu_str( isset( $a['badge'] ) ? $a['badge'] : '' ) );
	if ( '' !== $badge ) {
		$style = cozy_addons_menu_enum( isset( $a['badgeStyle'] ) ? $a['badgeStyle'] : 'accent', array( 'accent', 'dark', 'soft' ), 'accent' );
		$html .= '<span class="cozy-addons-menu-badge cozy-addons-menu-badge--' . esc_attr( $style ) . '">' . esc_html( $badge ) . '</span>';
	}
	return $html;
}

function cozy_addons_menu_item_defaults() {
	return array(
		'label' => '', 'url' => '', 'opensInNewTab' => false, 'rel' => '',
		'icon' => '', 'description' => '', 'badge' => '', 'badgeStyle' => 'accent', 'opensPanel' => '',
	);
}

/**
 * Parent row of a submenu. With a URL: real link + separate toggle button.
 * Without a URL: the label itself is the toggle button (never a fake link).
 */
function cozy_addons_menu_trigger_row( array $a, $panel_id, $current ) {
	$inner = cozy_addons_menu_item_inner( $a );
	$name  = trim( wp_strip_all_tags( cozy_addons_menu_label( $a['label'] ) ) );
	$a['url'] = cozy_addons_menu_item_url( $a['url'] );
	if ( '' !== $a['url'] ) {
		$link = cozy_addons_menu_link_html( $a['url'], ! empty( $a['opensInNewTab'] ), $a['rel'], 'cozy-addons-menu-link', $inner, $current );
		/* translators: %s: menu item name. */
		$sr   = sprintf( __( 'Toggle submenu: %s', 'cozy-addons' ), $name );
		$btn  = '<button type="button" class="cozy-addons-menu-chevron" aria-expanded="false" aria-controls="' . esc_attr( $panel_id ) . '" data-cozy-addons-menu-trigger><span class="cozy-addons-menu-sr">' . esc_html( $sr ) . '</span>' . cozy_addons_menu_chevron() . '</button>';
		return '<div class="cozy-addons-menu-row">' . $link . $btn . '</div>';
	}
	return '<div class="cozy-addons-menu-row"><button type="button" class="cozy-addons-menu-link cozy-addons-menu-link--toggle" aria-expanded="false" aria-controls="' . esc_attr( $panel_id ) . '" data-cozy-addons-menu-trigger>' . $inner . cozy_addons_menu_chevron() . '</button></div>';
}

/* -------------------------------------------------------------------- item */

/**
 * A menu link.
 *
 * @param array  $attrs   Attributes.
 * @param string $content Unused (menu items have no inner blocks).
 * @param string $tag     'li' inside a menu list or submenu; 'div' anywhere else (e.g. a Columns block in a mega panel).
 * @return string
 */
function cozy_addons_menu_render_item( $attrs, $content = '', $tag = 'li' ) {
	$tag      = 'div' === $tag ? 'div' : 'li';
	$a        = wp_parse_args( (array) $attrs, cozy_addons_menu_item_defaults() );
	$a['url'] = cozy_addons_menu_item_url( $a['url'] );
	if ( '' === trim( wp_strip_all_tags( cozy_addons_menu_label( $a['label'] ) ) ) ) {
		return '';
	}
	$inner = cozy_addons_menu_item_inner( $a );
	$panel = cozy_addons_menu_is_pro() ? sanitize_html_class( cozy_addons_menu_str( $a['opensPanel'] ) ) : ''; // Opening a panel is Pro.
	if ( '' !== $panel ) { // This item opens an off-canvas panel instead of navigating.
		wp_enqueue_script( 'cozy-block--menu-offcanvas' );
		return '<' . $tag . ' class="cozy-addons-menu-item"><button type="button" class="cozy-addons-menu-link" aria-expanded="false" aria-haspopup="dialog" data-cozy-addons-menu-oc-open="' . esc_attr( $panel ) . '">' . $inner . '</button></' . $tag . '>';
	}
	if ( '' === $a['url'] ) {
		return '<' . $tag . ' class="cozy-addons-menu-item"><span class="cozy-addons-menu-link cozy-addons-menu-link--static">' . $inner . '</span></' . $tag . '>';
	}
	$current = cozy_addons_menu_is_current( $a['url'] );
	$link    = cozy_addons_menu_link_html( $a['url'], ! empty( $a['opensInNewTab'] ), $a['rel'], 'cozy-addons-menu-link', $inner, $current );
	return '<' . $tag . ' class="cozy-addons-menu-item' . ( $current ? ' is-current' : '' ) . '">' . $link . '</' . $tag . '>';
}

/* --------------------------------------------------------------- home link */

/**
 * A link to the site's homepage, with an editable label. Highlighted as current on the front page.
 *
 * @param array  $attrs   Attributes (label).
 * @param string $content Unused.
 * @param string $tag     'li' inside a menu list or submenu; 'div' anywhere else.
 * @return string
 */
function cozy_addons_menu_render_home( $attrs, $content = '', $tag = 'li' ) {
	$label = isset( $attrs['label'] ) ? trim( cozy_addons_menu_str( $attrs['label'] ) ) : '';
	return cozy_addons_menu_render_item(
		array(
			'label' => '' !== wp_strip_all_tags( $label ) ? $label : __( 'Home', 'cozy-addons' ),
			'url'   => home_url( '/' ),
		),
		'',
		$tag
	);
}

/* ----------------------------------------------------------------- submenu */

function cozy_addons_menu_render_submenu( $attrs, $content = '' ) {
	$a = wp_parse_args( (array) $attrs, array_merge( cozy_addons_menu_item_defaults(), array(
		'openOn' => 'inherit', 'align' => 'start', 'width' => array(),
	) ) );
	$a['url'] = cozy_addons_menu_item_url( $a['url'] );

	if ( '' === trim( (string) $content ) ) {
		// Nothing to open: degrade to a plain item rather than an empty toggle.
		return '' !== $a['url'] ? cozy_addons_menu_render_item( $a ) : '';
	}

	$id          = wp_unique_id( 'cozy-addons-menu-sub-' );
	$bid         = wp_unique_id( 'cozy-addons-menu-b' );
	$current     = '' !== $a['url'] && cozy_addons_menu_is_current( $a['url'] );
	$has_current = $current || false !== strpos( $content, 'aria-current="page"' );

	cozy_addons_menu_css_push( cozy_addons_menu_resp_css( '.' . $bid . '>.cozy-addons-menu-sub', cozy_addons_menu_map_submenu(), $a ) );

	$open_on = cozy_addons_menu_enum( $a['openOn'], array( 'inherit', 'hover', 'click' ), 'inherit' );
	$align   = cozy_addons_menu_enum( $a['align'], array( 'start', 'center', 'end' ), 'start' );

	return '<li class="cozy-addons-menu-item cozy-addons-menu-has-sub cozy-addons-menu-has-dropdown ' . esc_attr( $bid ) . ( $has_current ? ' has-current' : '' ) . '"'
		. ' data-cozy-addons-menu-sub data-open-on="' . esc_attr( $open_on ) . '" data-align="' . esc_attr( $align ) . '">'
		. cozy_addons_menu_trigger_row( $a, $id, $current )
		. '<ul class="cozy-addons-menu-sub" id="' . esc_attr( $id ) . '">' . $content . '</ul>'
		. '</li>';
}

/* -------------------------------------------------------------------- mega */

function cozy_addons_menu_render_mega( $attrs, $content = '' ) {
	$panel_id = cozy_addons_menu_panel_id( isset( $attrs['savedPanel'] ) ? $attrs['savedPanel'] : 0 );
	if ( $panel_id ) {
		$saved = cozy_addons_menu_saved_panel( $panel_id );
		if ( $saved ) {
			// The row (label, link, icon, badge, open on, align) and the panel size stay the item's own;
			// the content, spacing and style come from the post.
			$attrs   = array_merge( (array) $attrs, $saved['attrs'] );
			$content = $saved['content'];
		}
	}
	$a = wp_parse_args( (array) $attrs, array_merge( cozy_addons_menu_item_defaults(), array(
		'openOn' => 'inherit', 'align' => 'start', 'widthMode' => 'content', 'contentWidth' => '1200px',
		'padding' => array(), 'customWidth' => array(),
		'panelBg' => '', 'radius' => '', 'shadow' => true,
	) ) );
	$a['url']     = cozy_addons_menu_item_url( $a['url'] );
	$a['padding'] = cozy_addons_menu_devices( $a['padding'], array( 'padding' ) ); // PaddingControl format; older d/t/m values still work.

	if ( '' === trim( (string) $content ) ) {
		return '' !== $a['url'] ? cozy_addons_menu_render_item( $a ) : '';
	}

	$id          = wp_unique_id( 'cozy-addons-menu-mega-' );
	$bid         = wp_unique_id( 'cozy-addons-menu-b' );
	$current     = '' !== $a['url'] && cozy_addons_menu_is_current( $a['url'] );
	$has_current = $current || false !== strpos( $content, 'aria-current="page"' );
	$mode        = cozy_addons_menu_enum( $a['widthMode'], array( 'content', 'full', 'custom' ), 'content' );
	$open_on     = cozy_addons_menu_enum( $a['openOn'], array( 'inherit', 'hover', 'click' ), 'inherit' );
	$align       = cozy_addons_menu_enum( $a['align'], array( 'start', 'center', 'end' ), 'start' );

	$map = cozy_addons_menu_map_mega();
	if ( 'custom' !== $mode ) {
		unset( $map['customWidth'] );
	}
	cozy_addons_menu_css_push( cozy_addons_menu_resp_css( '.' . $bid . '>.cozy-addons-menu-mega', $map, $a ) );

	$content_width = cozy_addons_menu_sanitize_length( cozy_addons_menu_str( $a['contentWidth'] ) );
	if ( '' === $content_width ) {
		$content_width = '1200px';
	}
	$style = '';
	if ( 'content' === $mode ) {
		$style .= '--cozy-addons-menu-mw:min(' . $content_width . ',calc(100vw - 24px));';
	} elseif ( 'full' === $mode ) {
		$style .= '--cozy-addons-menu-inner:' . $content_width . ';';
	}
	$bg = cozy_addons_menu_sanitize_color( $a['panelBg'] );
	if ( '' !== $bg ) {
		$style .= '--cozy-addons-menu-mega-bg:' . $bg . ';';
	}
	$radius = cozy_addons_menu_sanitize_length( $a['radius'] );
	if ( '' !== $radius ) {
		$style .= '--cozy-addons-menu-mega-r:' . $radius . ';';
	}

	return '<li class="cozy-addons-menu-item cozy-addons-menu-has-sub cozy-addons-menu-has-mega ' . esc_attr( $bid ) . ( $has_current ? ' has-current' : '' ) . '"'
		. ' data-cozy-addons-menu-sub data-open-on="' . esc_attr( $open_on ) . '" data-width-mode="' . esc_attr( $mode ) . '" data-align="' . esc_attr( $align ) . '">'
		. cozy_addons_menu_trigger_row( $a, $id, $current )
		. '<div class="cozy-addons-menu-mega' . ( empty( $a['shadow'] ) ? ' cozy-addons-menu-mega--flat' : '' ) . '" id="' . esc_attr( $id ) . '"' . ( '' !== $style ? ' style="' . esc_attr( $style ) . '"' : '' ) . '>'
		. '<div class="cozy-addons-menu-mega__content">' . $content . '</div></div>'
		. '</li>';
}

/* --------------------------------------------------------------- root menu */

function cozy_addons_menu_root_defaults() {
	return array(
		'ariaLabel' => 'Primary', 'direction' => array(), 'justify' => array(), 'gap' => array(),
		'typography' => array(), 'itemPadding' => array(), 'panelOffset' => array(), 'openOn' => 'hover',
		'linkColor' => '', 'hoverColor' => '', 'activeColor' => '', 'accentColor' => '',
		'panelBg' => '', 'panelText' => '', 'animate' => true,
		'overlay' => 'default', 'overlayColor' => '', 'overlayOpacity' => '', 'overlayBlur' => '', 'overlayDuration' => '',
		'displayMode' => 'standard',
	);
}

function cozy_addons_menu_render_root( $attrs, $content = '' ) {
	if ( isset( $attrs['displayMode'] ) && 'trigger' === $attrs['displayMode'] ) {
		return cozy_addons_menu_render_trigger_mode( (array) $attrs ); // Only a button; empty on free sites.
	}
	$attrs = cozy_addons_menu_strip_pro( (array) $attrs ); // Off-canvas and the overlay are Pro.
	$a = wp_parse_args( (array) $attrs, cozy_addons_menu_root_defaults() );
	if ( '' === trim( (string) $content ) ) {
		return '';
	}
	$oc = cozy_addons_menu_oc_config( (array) $attrs + $a );

	// Tablet and mobile use the default behaviour: below the breakpoint the links collapse behind the
	// toggle into a drawer on the right.
	$bp = COZY_ADDONS_MENU_BREAKPOINT;
	if ( $oc && $oc['show']['mobile'] ) {
		$bp = 320; // The panel replaces the mobile menu at every width.
	}
	$open_on = cozy_addons_menu_enum( $a['openOn'], array( 'hover', 'click' ), 'hover' );
	$iid     = wp_unique_id( 'cozy-addons-menu-i' );
	$drawer  = wp_unique_id( 'cozy-addons-menu-drawer-' );

	// Typography and item padding use the Cozy blocks' shared control format; map them to d/t/m.
	$typo              = cozy_addons_menu_typography( $a['typography'] );
	$a['fontSize']     = cozy_addons_menu_devices( $a['typography'], array( 'font', 'size' ), false );
	if ( ! $a['fontSize'] && isset( $attrs['fontSize'] ) && is_array( $attrs['fontSize'] ) ) {
		$a['fontSize'] = $attrs['fontSize']; // Saved before the Typography control was used.
	}
	$a['itemPadding'] = cozy_addons_menu_devices( $a['itemPadding'], array( 'padding' ) );

	// Instance CSS: responsive variables + colours + overlay settings + whatever the children queued.
	$css    = cozy_addons_menu_resp_css( '.' . $iid, cozy_addons_menu_map_root(), $a );
	$vars   = $typo['vars'];
	$colors = array(
		'linkColor' => '--cozy-addons-menu-text', 'hoverColor' => '--cozy-addons-menu-hover', 'activeColor' => '--cozy-addons-menu-active',
		'accentColor' => '--cozy-addons-menu-accent', 'panelBg' => '--cozy-addons-menu-panel-bg', 'panelText' => '--cozy-addons-menu-panel-text',
	);
	foreach ( $colors as $attr => $var ) {
		$color = cozy_addons_menu_sanitize_color( isset( $a[ $attr ] ) ? $a[ $attr ] : '' );
		if ( '' !== $color ) {
			$vars .= $var . ':' . $color . ';';
		}
	}
	$overlay = $oc ? array( 'on' => false, 'css' => '' ) : cozy_addons_menu_overlay_config( $a ); // Off-canvas menus have no mega panels.
	$vars   .= $overlay['css'];
	if ( $oc ) {
		$vars .= cozy_addons_menu_oc_vars( $oc );
	}
	if ( '' !== $vars ) {
		$css .= '.' . $iid . '{' . $vars . '}';
	}
	if ( $oc ) {
		$css .= cozy_addons_menu_oc_visibility_css( $iid, $oc, $bp );
	}
	$css = cozy_addons_menu_mobile_css( $bp ) . ( $oc ? cozy_addons_menu_oc_css( $bp ) : '' ) . $css . cozy_addons_menu_css_flush();

	// Mobile bar: only the menu toggle (an icon with a screen-reader label).
	$bar = '<div class="cozy-addons-menu-bar" data-cozy-addons-menu-bar><div class="cozy-addons-menu-actions">'
		. '<button type="button" class="cozy-addons-menu-toggle" aria-expanded="false" aria-controls="' . esc_attr( $drawer ) . '" data-cozy-addons-menu-toggle>'
		. '<span class="cozy-addons-menu-toggle__bars" aria-hidden="true"><i></i><i></i><i></i></span>'
		. '<span class="cozy-addons-menu-sr">' . esc_html__( 'Menu', 'cozy-addons' ) . '</span></button></div></div>';

	$classes = array( 'cozy-addons-menu', 'cozy-addons-menu--bp-' . $bp, 'cozy-addons-menu--mode-drawer', 'cozy-addons-menu--side-right', $iid );
	if ( ! empty( $a['animate'] ) && cozy_addons_menu_option( 'animations' ) ) {
		$classes[] = 'cozy-addons-menu--anim';
	}
	$data = array(
		'class'           => '',
		'aria-label'      => cozy_addons_menu_clean_text( '' !== trim( cozy_addons_menu_str( $a['ariaLabel'] ) ) ? $a['ariaLabel'] : __( 'Menu', 'cozy-addons' ), 80 ),
		'data-cozy-addons-menu'        => '',
		'data-open-on'    => $open_on,
		'data-breakpoint' => (string) $bp,
		'data-mode'       => 'drawer',
		'data-overlay'    => $overlay['on'] ? '1' : '0',
	);
	if ( $oc ) {
		$classes = array_merge( $classes, array(
			'cozy-addons-menu--oc', 'cozy-addons-menu--oc-' . $oc['layout'], 'cozy-addons-menu--oc-' . $oc['side'], 'cozy-addons-menu--oc-anim-' . $oc['anim'], 'cozy-addons-menu--oc-content-' . $oc['content'],
		) );
		if ( 'content' === $oc['height'] ) { $classes[] = 'cozy-addons-menu--oc-h-content'; }
		if ( $oc['backdrop'] ) { $classes[] = 'cozy-addons-menu--oc-bd'; }
		if ( $oc['close_btn'] ) { $classes[] = 'cozy-addons-menu--oc-closebtn'; $classes[] = 'cozy-addons-menu--oc-close-' . $oc['close_pos']; }
		if ( $oc['inset'] ) { $classes[] = 'cozy-addons-menu--oc-inset'; }
		$push_parts = ( $oc['push']['header'] ? 'h' : '' ) . ( $oc['push']['main'] ? 'm' : '' ) . ( $oc['push']['footer'] ? 'f' : '' );
		$tablet     = max( (int) cozy_addons_menu_option( 'tablet' ), $bp );
		$data      += array(
			'data-display'          => 'offcanvas',
			'data-oc-layout'        => $oc['layout'],
			'data-oc-side'          => $oc['side'],
			'data-oc-modal'         => $oc['modal'] ? '1' : '0',
			'data-oc-lock'          => $oc['lock'] ? '1' : '0',
			'data-oc-bdclose'       => ( $oc['backdrop'] && $oc['bd_close'] ) ? '1' : '0',
			'data-oc-offset'        => 'auto' === $oc['offset'] ? 'auto' : '',
			'data-oc-push-mode'     => $oc['push']['mode'],
			'data-oc-push-selector' => $oc['push']['selector'],
			'data-oc-push-parts'    => $push_parts,
			'data-oc-show'          => ( $oc['show']['desktop'] ? 'd' : '' ) . ( $oc['show']['tablet'] ? 't' : '' ) . ( $oc['show']['mobile'] ? 'm' : '' ),
			'data-oc-tablet'        => (string) $tablet,
			'data-oc-label'         => $oc['label'],
			'data-oc-selector'      => 'external' === $oc['trigger']['mode'] ? $oc['trigger']['selector'] : '',
		);
		wp_enqueue_script( 'cozy-block--menu-offcanvas' );
	}
	$data['class'] = implode( ' ', $classes );
	$wrapper = get_block_wrapper_attributes( $data );

	$noscript = '.' . $iid . ' .cozy-addons-menu-toggle,.' . $iid . ' .cozy-addons-menu-close,.' . $iid . ' .cozy-addons-menu-backdrop{display:none!important}'
		. '.' . $iid . ' .cozy-addons-menu-drawer{position:static!important;display:block!important;visibility:visible!important;opacity:1!important;transform:none!important;clip-path:none!important;width:auto!important;max-width:none!important;height:auto!important;max-height:none!important;padding:0!important;background:none!important;box-shadow:none!important}'
		. '.' . $iid . ' .cozy-addons-menu-sub,.' . $iid . ' .cozy-addons-menu-mega{position:static!important;display:block!important;visibility:visible!important;opacity:1!important;transform:none!important;width:auto!important;box-shadow:none!important}'
		. '.' . $iid . ' .cozy-addons-menu-bar,.' . $iid . ' .cozy-addons-menu-oc-trigger,.' . $iid . ' .cozy-addons-menu-oc-only{display:none!important}';

	$close_svg = '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M6 6l12 12M18 6L6 18"/></svg>';

	// Every value is sanitised in cozy_addons_menu_resp_css(), the colour/length cleaners, cozy_addons_menu_overlay_config()
	// and cozy_addons_menu_oc_config(); cozy_addons_menu_safe_css() keeps the element closed whatever happens.
	// The chosen Google font, loaded the same way as in the other Cozy blocks (merged into one <head> stylesheet).
	$fonts = '';
	if ( '' !== $typo['family'] && function_exists( 'cozy_addons_google_fonts_link' ) ) {
		$fonts = cozy_addons_google_fonts_link( 'https://fonts.googleapis.com/css2?family=' . str_replace( ' ', '+', $typo['family'] ) . ':wght@100;200;300;400;500;600;700;800;900&display=swap' );
	}
	$html  = $fonts . '<style>' . cozy_addons_menu_safe_css( $css ) . '</style>';
	$html .= '<nav ' . $wrapper . '>';
	if ( $oc ) {
		$html .= cozy_addons_menu_oc_trigger_html( $oc, $drawer );
	}
	$html .= $bar;
	$html .= '<div class="cozy-addons-menu-backdrop" data-cozy-addons-menu-backdrop aria-hidden="true"></div>';
	$html .= '<div class="cozy-addons-menu-drawer" id="' . esc_attr( $drawer ) . '" data-cozy-addons-menu-drawer>';
	$html .= '<button type="button" class="cozy-addons-menu-close" data-cozy-addons-menu-close aria-label="' . esc_attr__( 'Close menu', 'cozy-addons' ) . '">' . $close_svg . '</button>';
	if ( $oc ) {
		$html .= '<div class="cozy-addons-menu-oc-body">' . cozy_addons_menu_oc_head_html( $oc )
			. '<nav class="cozy-addons-menu-oc-nav" aria-label="' . esc_attr( $oc['label'] ) . '"><ul class="cozy-addons-menu-list">' . $content . '</ul></nav>'
			. cozy_addons_menu_oc_ctas_html( $oc ) . '</div>';
	} else {
		$html .= '<ul class="cozy-addons-menu-list">' . $content . '</ul>';
	}
	$html .= '</div>';
	$html .= '<noscript><style>' . cozy_addons_menu_safe_css( $noscript ) . '</style></noscript>';
	$html .= '</nav>';
	return $html;
}

/* ------------------------------------------- mega menu content (Mega Menus) */

/**
 * The top-level blocks of a Mega Menus post, when a mega item may use it as its panel content.
 * Pro only; the post must be published (or editable by the current user, for previews).
 * A whole Advanced Mega Menu block inside it is left out: a navigation bar cannot sit inside a panel.
 *
 * @param int $id Post ID.
 * @return array|null Parsed blocks (whitespace-only chunks left out).
 */
function cozy_addons_menu_saved_panel_blocks( $id ) {
	static $cache = array();
	$id = absint( $id );
	if ( ! $id || ! cozy_addons_menu_is_pro() ) {
		return null;
	}
	if ( array_key_exists( $id, $cache ) ) {
		return $cache[ $id ];
	}
	$blocks = null;
	$post   = get_post( $id );
	if ( $post && 'ca_mega_menu' === $post->post_type
		&& ( 'publish' === $post->post_status || current_user_can( 'edit_post', $id ) )
		&& ( '' === $post->post_password || current_user_can( 'edit_post', $id ) ) ) {
		$blocks = array_values(
			array_filter(
				parse_blocks( $post->post_content ),
				function ( $b ) {
					if ( 'cozy-block/mega-menu' === $b['blockName'] ) {
						return false;
					}
					return ! empty( $b['blockName'] ) || '' !== trim( (string) $b['innerHTML'] );
				}
			)
		);
		$blocks = $blocks ? $blocks : null;
	}
	$cache[ $id ] = $blocks;
	return $blocks;
}

/**
 * Renders a Mega Menus post for a mega item: its panel settings and its content.
 *
 * Spacing and style come from the post's Mega Panel block; the panel size stays the mega item's. Content is
 * everything in the post, in order: the Mega Panel block contributes its inner blocks, and any other block or
 * pattern placed in the post renders as is.
 *
 * @param int $id Post ID.
 * @return array|null array( 'attrs' => panel settings, 'content' => html ), or null when unavailable.
 */
function cozy_addons_menu_saved_panel( $id ) {
	static $stack = array();
	$blocks = cozy_addons_menu_saved_panel_blocks( $id );
	if ( ! $blocks || in_array( (int) $id, $stack, true ) ) {
		return null;
	}
	$stack[]  = (int) $id;
	$settings = array();
	$content  = '';
	foreach ( $blocks as $block ) {
		if ( 'cozy-block/menu-panel' === $block['blockName'] ) {
			if ( ! $settings ) {
				$settings = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();
			}
			// Not registered on the server: WP_Block renders its inner blocks through cozy_addons_menu_pre_render_child().
			$content .= ( new WP_Block( $block ) )->render();
		} else {
			$content .= render_block( $block );
		}
	}
	array_pop( $stack );
	$attrs = cozy_addons_menu_child_attrs( 'cozy-block/menu-panel', $settings );
	return array(
		'attrs'   => array_intersect_key( $attrs, array_flip( array( 'padding', 'panelBg', 'radius', 'shadow' ) ) ),
		'content' => $content,
	);
}

