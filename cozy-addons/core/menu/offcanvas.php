<?php
/**
 * Desktop off-canvas display mode: Side Drawer, Fullscreen Overlay, Push Sidebar.
 *
 * Extends the existing menu block (displayMode = 'offcanvas'). The same list, submenu and mega content
 * is shown as an accordion inside the panel, with an optional heading, logo, intro and buttons. The existing
 * mobile menu is untouched: below the menu's breakpoint it keeps working exactly as before.
 * Pro feature: on free sites the menu renders in standard mode (see cozy_addons_menu_strip_pro()).
 */
defined( 'ABSPATH' ) || exit;

/* ---------------------------------------------------------------- sanitizers */

/**
 * Selector allow-list: ids, classes, tags, attribute selectors (no quotes), combinators.
 * No parentheses, quotes, braces, semicolons or backslashes. Mirrors sanitizeSelector() in lib.js.
 */
function cozy_addons_menu_sanitize_selector( $value ) {
	$value = trim( cozy_addons_menu_str( $value ) );
	if ( '' === $value || strlen( $value ) > 150 || ! preg_match( '/^[A-Za-z0-9_\-#.\[\]=\s>,*~+^$|:]+$/', $value ) ) {
		return '';
	}
	return preg_replace( '/\s+/', ' ', $value );
}

function cozy_addons_menu_sanitize_classes( $value ) {
	$out = array();
	foreach ( preg_split( '/\s+/', trim( cozy_addons_menu_str( $value ) ) ) as $token ) {
		if ( '' !== $token && preg_match( '/^[A-Za-z_][A-Za-z0-9_-]{0,40}$/', $token ) ) {
			$out[] = $token;
		}
	}
	return implode( ' ', array_slice( $out, 0, 5 ) );
}

/** Safe CSS url() for a background image: http(s) or site-relative only, no characters that could close the url(). */
function cozy_addons_menu_css_url( $url ) {
	$url = cozy_addons_menu_clean_url( $url );
	if ( '' === $url || preg_match( '/^(?:tel:|mailto:)|["\'()\\\\\s<>]/i', $url ) ) {
		return '';
	}
	return 'url("' . $url . '")';
}

/* ------------------------------------------------------- panel logo and buttons */

/**
 * Logo at the top of the off-canvas panel: none, the site logo (or site name), or a custom image.
 *
 * @param array $a array( 'logo' => mode, 'logo_url' => image URL, 'logo_alt' => alt text ).
 * @return string
 */
function cozy_addons_menu_render_logo( array $a ) {
	$mode = cozy_addons_menu_enum( isset( $a['logo'] ) ? $a['logo'] : 'none', array( 'none', 'site', 'custom' ), 'none' );
	if ( 'site' === $mode ) {
		$logo = function_exists( 'get_custom_logo' ) ? get_custom_logo() : '';
		if ( '' === $logo ) {
			$logo = '<a class="cozy-addons-menu-logo__text" href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
		}
		return '<div class="cozy-addons-menu-logo">' . $logo . '</div>';
	}
	if ( 'custom' === $mode ) {
		$src = cozy_addons_menu_clean_url( isset( $a['logo_url'] ) ? $a['logo_url'] : '' );
		if ( '' === $src ) {
			return '';
		}
		return '<div class="cozy-addons-menu-logo"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( cozy_addons_menu_clean_text( isset( $a['logo_alt'] ) ? $a['logo_alt'] : '', 120 ) ) . '" decoding="async"></a></div>';
	}
	return '';
}

function cozy_addons_menu_cta_types() {
	return array(
		'call'     => array( 'label' => __( 'Call now', 'cozy-addons' ), 'icon' => 'phone', 'default' => __( 'Call Now', 'cozy-addons' ) ),
		'quote'    => array( 'label' => __( 'Get a free quote', 'cozy-addons' ), 'icon' => 'file', 'default' => __( 'Get a Free Quote', 'cozy-addons' ) ),
		'whatsapp' => array( 'label' => __( 'WhatsApp', 'cozy-addons' ), 'icon' => 'whatsapp', 'default' => __( 'WhatsApp', 'cozy-addons' ) ),
		'booking'  => array( 'label' => __( 'Book an appointment', 'cozy-addons' ), 'icon' => 'calendar', 'default' => __( 'Book an Appointment', 'cozy-addons' ) ),
		'email'    => array( 'label' => __( 'Email us', 'cozy-addons' ), 'icon' => 'mail', 'default' => __( 'Email Us', 'cozy-addons' ) ),
		'custom'   => array( 'label' => __( 'Custom', 'cozy-addons' ), 'icon' => 'arrow', 'default' => __( 'Learn more', 'cozy-addons' ) ),
	);
}

function cozy_addons_menu_sanitize_ctas( $raw ) {
	$out = array();
	if ( ! is_array( $raw ) ) {
		return $out;
	}
	$types = cozy_addons_menu_cta_types();
	foreach ( $raw as $item ) {
		if ( ! is_array( $item ) || ( isset( $item['enabled'] ) && ! $item['enabled'] ) ) {
			continue;
		}
		$type = ( isset( $item['type'] ) && is_string( $item['type'] ) && isset( $types[ $item['type'] ] ) ) ? $item['type'] : '';
		if ( '' === $type ) {
			continue;
		}
		$out[] = array(
			'type'    => $type,
			'label'   => cozy_addons_menu_clean_text( isset( $item['label'] ) ? $item['label'] : '' ),
			'url'     => cozy_addons_menu_clean_url( isset( $item['url'] ) ? $item['url'] : '' ),
			'phone'   => cozy_addons_menu_clean_text( isset( $item['phone'] ) ? $item['phone'] : '', 30 ),
			'email'   => sanitize_email( cozy_addons_menu_str( isset( $item['email'] ) ? $item['email'] : '' ) ),
			'subject' => cozy_addons_menu_clean_text( isset( $item['subject'] ) ? $item['subject'] : '', 80 ),
			'message' => cozy_addons_menu_clean_text( isset( $item['message'] ) ? $item['message'] : '', 200 ),
			'icon'    => ( isset( $item['icon'] ) && cozy_addons_menu_icon_exists( $item['icon'] ) ) ? $item['icon'] : '',
			'style'   => cozy_addons_menu_enum( isset( $item['style'] ) ? $item['style'] : 'secondary', array( 'primary', 'secondary', 'outline', 'link' ), 'secondary' ),
		);
		if ( count( $out ) >= 6 ) {
			break;
		}
	}
	return $out;
}

/**
 * Build the href for a CTA. Phone numbers and message text are re-encoded, never trusted.
 * Mirrors ctaHref() in src/mega-menu/lib.js. Returns '' when the item is not usable.
 */
function cozy_addons_menu_cta_href( array $item ) {
	switch ( $item['type'] ) {
		case 'call':
			$raw    = preg_replace( '/[^0-9+]/', '', (string) $item['phone'] );
			$digits = preg_replace( '/\D/', '', $raw );
			if ( strlen( $digits ) < 5 || strlen( $digits ) > 15 ) {
				return '';
			}
			return 'tel:' . ( 0 === strpos( $raw, '+' ) ? '+' : '' ) . $digits;

		case 'whatsapp':
			$digits = preg_replace( '/\D/', '', (string) $item['phone'] );
			if ( strlen( $digits ) < 5 || strlen( $digits ) > 15 ) {
				return '';
			}
			$url = 'https://wa.me/' . $digits;
			if ( '' !== trim( $item['message'] ) ) {
				$url .= '?text=' . rawurlencode( trim( $item['message'] ) );
			}
			return $url;

		case 'email':
			$email = sanitize_email( $item['email'] );
			if ( '' === $email ) {
				return '';
			}
			$url = 'mailto:' . $email;
			if ( '' !== trim( $item['subject'] ) ) {
				$url .= '?subject=' . rawurlencode( trim( $item['subject'] ) );
			}
			return $url;
	}
	return cozy_addons_menu_clean_url( $item['url'] ); // quote, booking, custom.
}


/**
 * The off-canvas panel's buttons. Returns '' (no markup at all) when nothing usable is enabled.
 *
 * @param array  $items         Raw button settings (ocCtas).
 * @param string $layout        stack | grid | inline.
 * @param string $wrapper_class Wrapper classes.
 * @return string
 */
function cozy_addons_menu_render_ctas( $items, $layout, $wrapper_class ) {
	$items = cozy_addons_menu_sanitize_ctas( $items );
	if ( ! $items ) {
		return '';
	}
	$types  = cozy_addons_menu_cta_types();
	$layout = cozy_addons_menu_enum( $layout, array( 'stack', 'grid', 'inline' ), 'stack' );
	$links  = '';
	foreach ( $items as $item ) {
		$href = cozy_addons_menu_cta_href( $item );
		if ( '' === $href ) {
			continue;
		}
		$label = '' !== $item['label'] ? $item['label'] : $types[ $item['type'] ]['default'];
		$icon  = '' !== $item['icon'] ? $item['icon'] : $types[ $item['type'] ]['icon'];
		$ext   = 0 === strpos( $href, 'https://wa.me/' ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		$links .= '<a class="cozy-addons-menu-cta cozy-addons-menu-cta--style-' . esc_attr( $item['style'] ) . '" href="' . esc_url( $href, array( 'http', 'https', 'tel', 'mailto' ) ) . '"' . $ext . '>'
			. cozy_addons_menu_icon( $icon ) . '<span>' . esc_html( $label ) . '</span></a>';
	}
	if ( '' === $links ) {
		return '';
	}
	return '<div class="' . esc_attr( $wrapper_class ) . ' cozy-addons-menu-ctas--' . esc_attr( $layout ) . '" role="group" aria-label="' . esc_attr__( 'Quick actions', 'cozy-addons' ) . '">'
		. '<div class="cozy-addons-menu-ctas__list">' . $links . '</div></div>';
}

/* -------------------------------------------------------------------- config */

function cozy_addons_menu_oc_widths() {
	return array( 'narrow' => '320px', 'medium' => '420px', 'wide' => '560px', 'xwide' => '760px' );
}

/**
 * Normalised, sanitised off-canvas settings, or null when the menu is in standard mode.
 */
function cozy_addons_menu_oc_config( array $a ) {
	if ( 'offcanvas' !== cozy_addons_menu_enum( isset( $a['displayMode'] ) ? $a['displayMode'] : 'standard', array( 'standard', 'offcanvas' ), 'standard' ) ) {
		return null;
	}
	$g = function ( $key, $default = '' ) use ( $a ) {
		return isset( $a[ $key ] ) ? $a[ $key ] : $default;
	};

	$layout = cozy_addons_menu_enum( $g( 'ocLayout', 'drawer' ), array( 'drawer', 'fullscreen', 'push' ), 'drawer' );
	$widths = cozy_addons_menu_oc_widths();
	$w_mode = cozy_addons_menu_enum( $g( 'ocWidth', 'medium' ), array( 'narrow', 'medium', 'wide', 'xwide', 'custom' ), 'medium' );
	$width  = 'custom' === $w_mode ? cozy_addons_menu_sanitize_length( $g( 'ocWidthCustom' ) ) : $widths[ $w_mode ];
	if ( '' === $width ) {
		$width = $widths['medium'];
	}

	$offset = trim( cozy_addons_menu_str( $g( 'ocOffsetTop' ) ) );
	$offset = 'auto' === $offset ? 'auto' : cozy_addons_menu_sanitize_length( $offset );

	$content = cozy_addons_menu_enum( $g( 'ocContent', '' ), array( '', 'center', 'left', 'columns', 'editorial', 'grid' ), '' );
	if ( '' === $content ) {
		$content = 'fullscreen' === $layout ? 'center' : 'left';
	}
	$anims = 'fullscreen' === $layout
		? array( 'fade', 'scale', 'reveal-up', 'reveal-down', 'reveal-left', 'reveal-right' )
		: array( 'slide', 'fade' );
	$anim = cozy_addons_menu_enum( $g( 'ocAnimation', '' ), $anims, $anims[0] );

	$modal = cozy_addons_menu_enum( $g( 'ocModal', 'auto' ), array( 'auto', 'on', 'off' ), 'auto' );
	$modal = 'auto' === $modal ? ( 'push' !== $layout ) : ( 'on' === $modal );
	$lock  = cozy_addons_menu_enum( $g( 'ocLock', 'auto' ), array( 'auto', 'on', 'off' ), 'auto' );
	$lock  = 'auto' === $lock ? $modal : ( 'on' === $lock );

	// Backdrop: automatic = on for the side drawer, off for push (you are pushing that content, not dimming it); never for fullscreen.
	$bd_mode  = cozy_addons_menu_enum( $g( 'ocBackdrop', 'auto' ), array( 'auto', 'on', 'off' ), 'auto' );
	$backdrop = 'fullscreen' !== $layout && ( 'on' === $bd_mode || ( 'auto' === $bd_mode && 'drawer' === $layout ) );
	$bd_color = cozy_addons_menu_sanitize_color( (string) $g( 'ocBackdropColor' ) );
	$bd_color = ( '' !== $bd_color && 0 === strpos( $bd_color, '#' ) ) ? $bd_color : cozy_addons_menu_option( 'overlay_color' );
	$bd_opac  = cozy_addons_menu_clamp_int( $g( 'ocBackdropOpacity' ), 0, 90, cozy_addons_menu_option( 'overlay_opacity' ) );
	$bd_blur  = cozy_addons_menu_clamp_int( $g( 'ocBackdropBlur' ), 0, 24, cozy_addons_menu_option( 'overlay_blur' ) );

	$bg  = cozy_addons_menu_sanitize_color( (string) $g( 'ocBg' ) );
	$bg2 = cozy_addons_menu_sanitize_color( (string) $g( 'ocBg2' ) );
	$bgi = cozy_addons_menu_css_url( (string) $g( 'ocBgImage' ) );
	$weights = array( '', '300', '400', '500', '600', '700', '800' );

	$trigger = cozy_addons_menu_enum( $g( 'ocTrigger', 'hamburger' ), array( 'hamburger', 'button', 'external' ), 'hamburger' );
	$t_icon  = cozy_addons_menu_str( $g( 'ocTriggerIcon', 'bars' ) );
	$t_icon  = ( 'bars' === $t_icon || '' === $t_icon || cozy_addons_menu_icon_exists( $t_icon ) ) ? $t_icon : 'bars';

	return array(
		'layout'      => $layout,
		'side'        => cozy_addons_menu_enum( $g( 'ocSide', 'right' ), array( 'left', 'right' ), 'right' ),
		'width'       => $width,
		'max_width'   => cozy_addons_menu_sanitize_length( $g( 'ocMaxWidth' ) ),
		'height'      => cozy_addons_menu_enum( $g( 'ocHeight', 'full' ), array( 'full', 'content' ), 'full' ),
		'offset'      => $offset,
		'content'     => $content,
		'columns'     => cozy_addons_menu_clamp_int( $g( 'ocColumns', 2 ), 1, 4, 2 ),
		'inset'       => 'fullscreen' === $layout && ! empty( $a['ocInset'] ),
		'anim'        => $anim,
		'duration'    => cozy_addons_menu_clamp_int( $g( 'ocDuration', 350 ), 0, 1500, 350 ),
		'backdrop'    => $backdrop,
		'bd_color'    => $bd_color,
		'bd_opacity'  => $bd_opac,
		'bd_blur'     => $bd_blur,
		'close_btn'   => ! array_key_exists( 'ocCloseButton', $a ) || ! empty( $a['ocCloseButton'] ),
		'close_pos'   => cozy_addons_menu_enum( $g( 'ocClosePos', 'right' ), array( 'right', 'left' ), 'right' ),
		'bd_close'    => ! array_key_exists( 'ocBackdropClose', $a ) || ! empty( $a['ocBackdropClose'] ),
		'modal'       => $modal,
		'lock'        => $lock,
		'bg'          => $bg,
		'bg2'         => $bg2,
		'bg_angle'    => cozy_addons_menu_clamp_int( $g( 'ocBgAngle', 135 ), 0, 360, 135 ),
		'bg_image'    => $bgi,
		'text'        => cozy_addons_menu_sanitize_color( (string) $g( 'ocText' ) ),
		'font_size'   => cozy_addons_menu_sanitize_length( $g( 'ocFontSize' ) ),
		'font_weight' => in_array( cozy_addons_menu_str( $g( 'ocFontWeight' ) ), $weights, true ) ? cozy_addons_menu_str( $g( 'ocFontWeight' ) ) : '',
		'padding'     => cozy_addons_menu_sanitize_length( $g( 'ocPadding' ), 4 ),
		'radius'      => cozy_addons_menu_sanitize_length( $g( 'ocRadius' ) ),
		'shadow'      => cozy_addons_menu_enum( $g( 'ocShadow', 'soft' ), array( 'none', 'soft', 'strong' ), 'soft' ),
		'border_w'    => cozy_addons_menu_sanitize_length( $g( 'ocBorderWidth' ) ),
		'border_c'    => cozy_addons_menu_sanitize_color( (string) $g( 'ocBorderColor' ) ),
		'logo'        => cozy_addons_menu_enum( $g( 'ocLogo', 'none' ), array( 'none', 'site', 'custom' ), 'none' ),
		'logo_url'    => cozy_addons_menu_clean_url( $g( 'ocLogoUrl' ) ),
		'logo_alt'    => cozy_addons_menu_clean_text( $g( 'ocLogoAlt' ), 80 ),
		'heading'     => cozy_addons_menu_clean_text( $g( 'ocHeading' ), 80 ),
		'intro'       => cozy_addons_menu_clean_text( $g( 'ocIntro' ), 240 ),
		'cta_layout'  => cozy_addons_menu_enum( $g( 'ocCtaLayout', 'stack' ), array( 'stack', 'grid', 'inline' ), 'stack' ),
		'ctas'        => is_array( $g( 'ocCtas', array() ) ) ? $g( 'ocCtas', array() ) : array(), // Each item is sanitised by cozy_addons_menu_sanitize_ctas().
		'label'       => cozy_addons_menu_clean_text( '' !== trim( cozy_addons_menu_str( $g( 'ocPanelLabel' ) ) ) ? $g( 'ocPanelLabel' ) : __( 'Menu', 'cozy-addons' ), 60 ),
		'trigger'     => array(
			'mode'     => $trigger,
			'label'    => cozy_addons_menu_clean_text( $g( 'ocTriggerLabel', 'Menu' ), 40 ),
			'icon'     => $t_icon,
			'icon_pos' => cozy_addons_menu_enum( $g( 'ocTriggerIconPos', 'left' ), array( 'left', 'right' ), 'left' ),
			'icon_only' => ! empty( $a['ocTriggerIconOnly'] ),
			'aria'     => cozy_addons_menu_clean_text( $g( 'ocTriggerAria' ), 60 ),
			'align'    => cozy_addons_menu_enum( $g( 'ocTriggerAlign', 'start' ), array( 'start', 'center', 'end' ), 'start' ),
			'bg'       => cozy_addons_menu_sanitize_color( (string) $g( 'ocTriggerBg' ) ),
			'color'    => cozy_addons_menu_sanitize_color( (string) $g( 'ocTriggerColor' ) ),
			'hover_bg' => cozy_addons_menu_sanitize_color( (string) $g( 'ocTriggerHoverBg' ) ),
			'padding'  => cozy_addons_menu_sanitize_length( $g( 'ocTriggerPadding' ), 4 ),
			'radius'   => cozy_addons_menu_sanitize_length( $g( 'ocTriggerRadius' ) ),
			'border_w' => cozy_addons_menu_sanitize_length( $g( 'ocTriggerBorderWidth' ) ),
			'border_c' => cozy_addons_menu_sanitize_color( (string) $g( 'ocTriggerBorderColor' ) ),
			'class'    => cozy_addons_menu_sanitize_classes( $g( 'ocTriggerClass' ) ),
			'selector' => cozy_addons_menu_sanitize_selector( $g( 'ocTriggerSelector' ) ),
		),
		'push'        => array(
			'mode'     => cozy_addons_menu_enum( $g( 'ocPushTarget', 'auto' ), array( 'auto', 'custom' ), 'auto' ),
			'selector' => cozy_addons_menu_sanitize_selector( $g( 'ocPushSelector' ) ),
			'header'   => ! array_key_exists( 'ocPushHeader', $a ) || ! empty( $a['ocPushHeader'] ),
			'main'     => ! array_key_exists( 'ocPushMain', $a ) || ! empty( $a['ocPushMain'] ),
			'footer'   => ! array_key_exists( 'ocPushFooter', $a ) || ! empty( $a['ocPushFooter'] ),
		),
		'show'        => array(
			'desktop' => ! array_key_exists( 'ocShowDesktop', $a ) || ! empty( $a['ocShowDesktop'] ),
			'tablet'  => ! array_key_exists( 'ocShowTablet', $a ) || ! empty( $a['ocShowTablet'] ),
			'mobile'  => ! empty( $a['ocShowMobile'] ),
		),
	);
}

/* ---------------------------------------------------------------- CSS output */

/** Custom properties for one menu instance (applied to the nav and to its portal copy through the shared class). */
function cozy_addons_menu_oc_vars( array $oc ) {
	$v  = '--oc-w:' . $oc['width'] . ';--oc-dur:' . $oc['duration'] . 'ms;--oc-cols:' . $oc['columns'] . ';';
	$v .= '--oc-mega-cols:' . ( 'fullscreen' === $oc['layout'] ? 3 : 1 ) . ';';
	$v .= '--oc-bd-color:' . cozy_addons_menu_hex_to_rgba( $oc['bd_color'], $oc['bd_opacity'] ) . ';--oc-bd-blur:' . $oc['bd_blur'] . 'px;';
	if ( '' !== $oc['max_width'] ) {
		$v .= '--oc-maxw:' . $oc['max_width'] . ';';
	}
	if ( '' !== $oc['offset'] && 'auto' !== $oc['offset'] ) {
		$v .= '--oc-top-user:' . $oc['offset'] . ';';
	}
	if ( '' !== $oc['bg'] ) {
		$v .= '--oc-bg:' . $oc['bg'] . ';';
	}
	$layers = array();
	if ( '' !== $oc['bg_image'] ) {
		$layers[] = $oc['bg_image'];
	}
	if ( '' !== $oc['bg2'] ) {
		$layers[] = 'linear-gradient(' . (int) $oc['bg_angle'] . 'deg,' . ( '' !== $oc['bg'] ? $oc['bg'] : '#fff' ) . ',' . $oc['bg2'] . ')';
	}
	if ( $layers ) {
		$v .= '--oc-bgimg:' . implode( ',', $layers ) . ';';
	}
	if ( '' !== $oc['text'] ) {
		$v .= '--oc-text:' . $oc['text'] . ';';
	}
	if ( '' !== $oc['font_size'] ) {
		$v .= '--oc-fs:' . $oc['font_size'] . ';';
	}
	if ( '' !== $oc['font_weight'] ) {
		$v .= '--oc-fw:' . $oc['font_weight'] . ';';
	}
	if ( '' !== $oc['padding'] ) {
		$v .= '--oc-pad:' . $oc['padding'] . ';';
	}
	if ( '' !== $oc['radius'] ) {
		$v .= '--oc-r:' . $oc['radius'] . ';';
	}
	$shadows = array( 'none' => 'none', 'soft' => '0 30px 80px -20px rgba(10,14,40,.35)', 'strong' => '0 40px 120px -10px rgba(10,14,40,.6)' );
	$v .= '--oc-shadow:' . $shadows[ $oc['shadow'] ] . ';';
	if ( '' !== $oc['border_w'] ) {
		$v .= '--oc-bw:' . $oc['border_w'] . ';';
	}
	if ( '' !== $oc['border_c'] ) {
		$v .= '--oc-bc:' . $oc['border_c'] . ';';
	}
	return $v;
}

/**
 * Which device ranges show the desktop off-canvas trigger.
 * mobile (<= breakpoint) is where the existing mobile menu lives; desktop is above the tablet width.
 */
function cozy_addons_menu_oc_visibility_css( $iid, array $oc, $bp ) {
	$tablet = max( (int) cozy_addons_menu_option( 'tablet' ), $bp );
	$rules  = '';
	if ( $oc['show']['desktop'] ) {
		$rules .= '@media (min-width:' . ( $tablet + 1 ) . 'px){.' . $iid . ' .cozy-addons-menu-oc-trigger{display:inline-flex}}';
	}
	if ( $oc['show']['tablet'] && $tablet > $bp ) {
		$rules .= '@media (min-width:' . ( $bp + 1 ) . 'px) and (max-width:' . $tablet . 'px){.' . $iid . ' .cozy-addons-menu-oc-trigger{display:inline-flex}}';
	}
	return $rules;
}

/** The desktop off-canvas rules, stamped once per breakpoint (like the mobile template). */
function cozy_addons_menu_oc_css( $bp ) {
	static $done = array();
	$bp = (int) $bp;
	if ( isset( $done[ $bp ] ) ) {
		return '';
	}
	$done[ $bp ] = true;
	$template = file_get_contents( COZY_ADDONS_PLUGIN_DIR . 'assets/css/menu/offcanvas.tpl.css' );
	return str_replace( array( '__BPMIN__', '__BP__' ), array( (string) ( $bp + 1 ), (string) $bp ), (string) $template );
}

/* ------------------------------------------------------------------- trigger */

/** Inline custom properties for a trigger button (shared by the internal trigger and the trigger display mode). */
function cozy_addons_menu_oc_trigger_style( array $t ) {
	$map = array( 'bg' => '--oc-t-bg', 'color' => '--oc-t-color', 'hover_bg' => '--oc-t-hover', 'padding' => '--oc-t-pad', 'radius' => '--oc-t-r', 'border_w' => '--oc-t-bw', 'border_c' => '--oc-t-bc' );
	$css = '';
	foreach ( $map as $key => $var ) {
		if ( isset( $t[ $key ] ) && '' !== $t[ $key ] ) {
			$css .= $var . ':' . $t[ $key ] . ';';
		}
	}
	return $css;
}

function cozy_addons_menu_oc_trigger_inner( array $t ) {
	$icon = '';
	if ( 'bars' === $t['icon'] ) {
		$icon = '<span class="cozy-addons-menu-oc-ico cozy-addons-menu-oc-bars" aria-hidden="true"><i></i><i></i><i></i></span>';
	} elseif ( '' !== $t['icon'] ) {
		$icon = '<span class="cozy-addons-menu-oc-ico">' . cozy_addons_menu_icon( $t['icon'] ) . '</span>';
	}
	$name = '' !== $t['aria'] ? $t['aria'] : ( '' !== $t['label'] ? $t['label'] : __( 'Open menu', 'cozy-addons' ) );
	if ( $t['icon_only'] && '' !== $icon ) {
		return $icon . '<span class="cozy-addons-menu-sr">' . esc_html( $name ) . '</span>';
	}
	$text = '<span class="cozy-addons-menu-oc-label">' . esc_html( '' !== $t['label'] ? $t['label'] : $name ) . '</span>';
	return 'right' === $t['icon_pos'] ? $text . $icon : $icon . $text;
}

/** The built-in trigger button rendered inside the menu. */
function cozy_addons_menu_oc_trigger_html( array $oc, $panel_id ) {
	$t = $oc['trigger'];
	if ( 'external' === $t['mode'] ) {
		return '';
	}
	$style   = cozy_addons_menu_oc_trigger_style( $t );
	$classes = 'cozy-addons-menu-oc-trigger cozy-addons-menu-oc-trigger--align-' . $t['align'] . ( 'hamburger' === $t['mode'] ? ' cozy-addons-menu-oc-trigger--hamburger' : '' ) . ( $t['icon_only'] ? ' cozy-addons-menu-oc-trigger--icon-only' : '' ) . ( '' !== $t['class'] ? ' ' . $t['class'] : '' );
	return '<button type="button" class="' . esc_attr( $classes ) . '"' . ( '' !== $style ? ' style="' . esc_attr( $style ) . '"' : '' )
		. ' aria-expanded="false" aria-controls="' . esc_attr( $panel_id ) . '"' . ( $oc['modal'] ? ' aria-haspopup="dialog"' : '' ) . ' data-cozy-addons-menu-oc-trigger>'
		. cozy_addons_menu_oc_trigger_inner( $t ) . '</button>';
}

/** Heading, logo and intro shown at the top of the desktop panel. */
function cozy_addons_menu_oc_head_html( array $oc ) {
	$logo = cozy_addons_menu_render_logo( array( 'logo' => $oc['logo'], 'logo_url' => $oc['logo_url'], 'logo_alt' => $oc['logo_alt'] ) );
	if ( '' === $logo && '' === $oc['heading'] && '' === $oc['intro'] ) {
		return '';
	}
	return '<div class="cozy-addons-menu-oc-head cozy-addons-menu-oc-only">' . $logo
		. ( '' !== $oc['heading'] ? '<p class="cozy-addons-menu-oc-heading">' . esc_html( $oc['heading'] ) . '</p>' : '' )
		. ( '' !== $oc['intro'] ? '<p class="cozy-addons-menu-oc-intro">' . esc_html( $oc['intro'] ) . '</p>' : '' ) . '</div>';
}

/** The panel's buttons, with a desktop-only wrapper. */
function cozy_addons_menu_oc_ctas_html( array $oc ) {
	return cozy_addons_menu_render_ctas( $oc['ctas'], $oc['cta_layout'], 'cozy-addons-menu-oc-ctas cozy-addons-menu-oc-only' );
}

/* --------------------------------------------------- off-canvas trigger display mode */

/**
 * A menu in "Off-canvas trigger" display mode renders only a button that opens another menu's
 * off-canvas panel, addressed by that menu's HTML anchor. It uses the root's ocTrigger* settings.
 *
 * @param array $attrs Root block attributes (defaults already filled in by the registry).
 * @return string
 */
function cozy_addons_menu_render_trigger_mode( array $attrs ) {
	if ( ! cozy_addons_menu_is_pro() ) {
		return ''; // Desktop off-canvas is Pro.
	}
	$g = function ( $key, $default = '' ) use ( $attrs ) {
		return isset( $attrs[ $key ] ) ? $attrs[ $key ] : $default;
	};
	$a = array(
		'panelId'     => $g( 'ocTargetPanel' ),
		'label'       => $g( 'ocTriggerLabel', 'Menu' ),
		'icon'        => $g( 'ocTriggerIcon', 'bars' ),
		'iconPos'     => $g( 'ocTriggerIconPos', 'left' ),
		'iconOnly'    => $g( 'ocTriggerIconOnly', false ),
		'ariaLabel'   => $g( 'ocTriggerAria' ),
		'align'       => $g( 'ocTriggerAlign', 'start' ),
		'bg'          => $g( 'ocTriggerBg' ),
		'color'       => $g( 'ocTriggerColor' ),
		'hoverBg'     => $g( 'ocTriggerHoverBg' ),
		'padding'     => $g( 'ocTriggerPadding' ),
		'radius'      => $g( 'ocTriggerRadius' ),
		'borderWidth' => $g( 'ocTriggerBorderWidth' ),
		'borderColor' => $g( 'ocTriggerBorderColor' ),
		'extraClass'  => $g( 'ocTriggerClass' ),
	);
	$panel = sanitize_html_class( cozy_addons_menu_str( $a['panelId'] ) );
	if ( '' === $panel ) {
		return ''; // Nothing to open.
	}
	$a['icon'] = cozy_addons_menu_str( $a['icon'] );
	$icon      = ( 'bars' === $a['icon'] || cozy_addons_menu_icon_exists( $a['icon'] ) ) ? $a['icon'] : ( '' === $a['icon'] ? '' : 'bars' );
	$t = array(
		'icon' => $icon, 'icon_pos' => cozy_addons_menu_enum( $a['iconPos'], array( 'left', 'right' ), 'left' ), 'icon_only' => ! empty( $a['iconOnly'] ),
		'label' => cozy_addons_menu_clean_text( $a['label'], 40 ), 'aria' => cozy_addons_menu_clean_text( $a['ariaLabel'], 60 ),
		'bg' => cozy_addons_menu_sanitize_color( (string) $a['bg'] ), 'color' => cozy_addons_menu_sanitize_color( (string) $a['color'] ), 'hover_bg' => cozy_addons_menu_sanitize_color( (string) $a['hoverBg'] ),
		'padding' => cozy_addons_menu_sanitize_length( $a['padding'], 4 ), 'radius' => cozy_addons_menu_sanitize_length( $a['radius'] ),
		'border_w' => cozy_addons_menu_sanitize_length( $a['borderWidth'] ), 'border_c' => cozy_addons_menu_sanitize_color( (string) $a['borderColor'] ),
	);
	$align   = cozy_addons_menu_enum( $a['align'], array( 'start', 'center', 'end' ), 'start' );
	$extra   = cozy_addons_menu_sanitize_classes( $a['extraClass'] );
	$style   = cozy_addons_menu_oc_trigger_style( $t );
	$classes = 'cozy-addons-menu-oc-trigger cozy-addons-menu-oc-trigger--ext' . ( $t['icon_only'] ? ' cozy-addons-menu-oc-trigger--icon-only' : '' ) . ( '' !== $extra ? ' ' . $extra : '' );
	wp_enqueue_script( 'cozy-block--menu-offcanvas' ); // Pulls in view.js; the block's own style handle loads the CSS.
	$wrapper = get_block_wrapper_attributes( array( 'class' => 'cozy-addons-menu-oc-trigger-wrap cozy-addons-menu-oc-trigger-wrap--' . $align ) );
	return '<div ' . $wrapper . '><button type="button" class="' . esc_attr( $classes ) . '"' . ( '' !== $style ? ' style="' . esc_attr( $style ) . '"' : '' )
		. ' aria-expanded="false" aria-haspopup="dialog" data-cozy-addons-menu-oc-open="' . esc_attr( $panel ) . '">' . cozy_addons_menu_oc_trigger_inner( $t ) . '</button></div>';
}
