<?php
/**
 * Shared helpers: options, sanitizers, responsive CSS builder, icons, URL state.
 */
defined( 'ABSPATH' ) || exit;

/** Below this width (px) the menu collapses into the mobile drawer (the default tablet and mobile behaviour). */
const COZY_ADDONS_MENU_BREAKPOINT = 900;

/* ---------------------------------------------------------------- free / pro */

/**
 * Whether the Pro menu features are available: desktop off-canvas, the mega menu overlay and blur,
 * and mega menu content from the Mega Menus post type.
 *
 * @return bool
 */
function cozy_addons_menu_is_pro() {
	return function_exists( 'cozy_addons_premium_access' ) && cozy_addons_premium_access();
}

/**
 * Turns the Pro settings of a menu off on free sites, so saved Pro values never render there.
 *
 * @param array $attrs Block attributes.
 * @return array
 */
function cozy_addons_menu_strip_pro( array $attrs ) {
	if ( cozy_addons_menu_is_pro() ) {
		return $attrs;
	}
	$attrs['displayMode'] = 'standard';
	$attrs['overlay']     = 'off';
	return $attrs;
}

/* ------------------------------------------------------------------ options */

function cozy_addons_menu_defaults() {
	return array(
		'tablet'           => 1024, // max-width (px) for the tablet override layer.
		'mobile'           => 767,  // max-width (px) for the mobile override layer.
		'animations'       => 1,
		// Mega menu overlay + blur defaults. They mirror the CozyThemesUI reference menu.
		'overlay'          => 1,
		'overlay_color'    => '#0A0E28',
		'overlay_opacity'  => 50,   // percent, 0-90.
		'overlay_blur'     => 3,    // px, 0-24.
		'overlay_duration' => 250,  // ms, 0-1000.
	);
}

/** Typed by the default's type: ints stay ints, strings stay strings. */
function cozy_addons_menu_option( $key ) {
	$defaults = cozy_addons_menu_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : 0;
	$saved    = get_option( 'ca_menu_settings', array() );
	if ( is_array( $saved ) && isset( $saved[ $key ] ) && is_scalar( $saved[ $key ] ) ) {
		return is_int( $default ) ? (int) $saved[ $key ] : (string) $saved[ $key ];
	}
	return $default;
}

/* --------------------------------------------------------------- sanitizers */

/** Plain text, tags stripped, at most $max characters. */
function cozy_addons_menu_clean_text( $value, $max = 60 ) {
	$value = sanitize_text_field( cozy_addons_menu_str( $value ) );
	return function_exists( 'mb_substr' ) ? mb_substr( $value, 0, $max ) : substr( $value, 0, $max );
}

/**
 * Accept http(s), tel:, mailto:, site-relative (/path), #anchor and ?query. Reject everything else
 * (javascript:, data:, vbscript: and bare words that WordPress would turn into http://word).
 * Mirrors sanitizeUrl() in assets/js/lib.js.
 */
function cozy_addons_menu_clean_url( $url ) {
	$url = trim( cozy_addons_menu_str( $url ) );
	if ( '' === $url || ! preg_match( '~^(?:https?:|tel:|mailto:|/(?!/)|#|\?)~i', $url ) ) {
		return '';
	}
	return esc_url_raw( $url, array( 'http', 'https', 'tel', 'mailto' ) );
}

/** A scalar attribute as a string; arrays, objects and null become ''. */
function cozy_addons_menu_str( $value ) {
	return is_scalar( $value ) ? (string) $value : '';
}

/** ID of a Mega Menus post from a block attribute: a positive whole number, else 0. */
function cozy_addons_menu_panel_id( $value ) {
	if ( is_int( $value ) || ( is_string( $value ) && ctype_digit( $value ) ) ) {
		return absint( $value );
	}
	return 0;
}

/**
 * Last line of defence for CSS printed inside a <style> element: every value is already sanitised, and
 * removing "<" means nothing can close the element (CSS never needs it).
 */
function cozy_addons_menu_safe_css( $css ) {
	return str_replace( '<', '', (string) $css );
}

/** One CSS length token. Unitless non-zero numbers become px. */
function cozy_addons_menu_length_token( $token ) {
	$token = trim( (string) $token );
	if ( 'auto' === $token || '0' === $token ) {
		return $token;
	}
	if ( preg_match( '/^-?\d*\.?\d+$/', $token ) ) {
		return $token . 'px';
	}
	if ( preg_match( '/^-?\d*\.?\d+(?:px|rem|em|%|vw|vh|ch)$/', $token ) ) {
		return $token;
	}
	return '';
}

/** One or more length tokens ("12px", "10px 14px"). Returns '' when anything is invalid. */
function cozy_addons_menu_sanitize_length( $value, $max_tokens = 1 ) {
	if ( ! is_string( $value ) && ! is_numeric( $value ) ) {
		return '';
	}
	$parts = preg_split( '/\s+/', trim( (string) $value ) );
	if ( ! $parts || '' === $parts[0] || count( $parts ) > $max_tokens ) {
		return '';
	}
	$out = array();
	foreach ( $parts as $part ) {
		$token = cozy_addons_menu_length_token( $part );
		if ( '' === $token ) {
			return '';
		}
		$out[] = $token;
	}
	return implode( ' ', $out );
}

function cozy_addons_menu_sanitize_color( $value ) {
	if ( ! is_string( $value ) || strlen( $value ) > 100 ) {
		return '';
	}
	$value = trim( $value );
	if ( preg_match( '/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value ) ) {
		return $value;
	}
	if ( preg_match( '/^(?:rgb|hsl)a?\(\s*[0-9.%\s,\/-]+\)$/i', $value ) ) {
		return $value;
	}
	if ( in_array( strtolower( $value ), array( 'transparent', 'currentcolor', 'inherit' ), true ) ) {
		return $value;
	}
	if ( preg_match( '/^var\(--wp--preset--color--[a-z0-9-]+\)$/', $value ) ) {
		return $value;
	}
	return '';
}

function cozy_addons_menu_enum( $value, array $allowed, $default ) {
	return in_array( $value, $allowed, true ) ? $value : $default;
}

/**
 * A BoxControl value (top, right, bottom, left) as a CSS shorthand ("10px 14px 10px 14px"). A missing
 * side is 0. Returns '' when no side is set. Mirrors boxValue() in src/mega-menu/lib.js.
 *
 * @param array $box Sides.
 * @return string
 */
function cozy_addons_menu_box_shorthand( array $box ) {
	$sides = array();
	$any   = false;
	foreach ( array( 'top', 'right', 'bottom', 'left' ) as $side ) {
		$v       = isset( $box[ $side ] ) ? trim( cozy_addons_menu_str( $box[ $side ] ) ) : '';
		$any     = $any || '' !== $v;
		$sides[] = '' !== $v ? $v : '0';
	}
	return $any ? implode( ' ', $sides ) : '';
}

/** Normalise a responsive attribute to array( d, t, m ) of strings. Box values become CSS shorthands. */
function cozy_addons_menu_resp( $value ) {
	$out = array(
		'd' => '',
		't' => '',
		'm' => '',
	);
	if ( is_array( $value ) ) {
		foreach ( $out as $key => $unused ) {
			if ( isset( $value[ $key ] ) && ( is_string( $value[ $key ] ) || is_numeric( $value[ $key ] ) ) ) {
				$out[ $key ] = (string) $value[ $key ];
			} elseif ( isset( $value[ $key ] ) && is_array( $value[ $key ] ) ) {
				$out[ $key ] = cozy_addons_menu_box_shorthand( $value[ $key ] );
			}
		}
	}
	return $out;
}

function cozy_addons_menu_clean_value( $raw, array $def ) {
	switch ( $def['type'] ) {
		case 'length':
			return cozy_addons_menu_sanitize_length( $raw, isset( $def['tokens'] ) ? (int) $def['tokens'] : 1 );
		case 'enum':
			return in_array( $raw, $def['allowed'], true ) ? $raw : '';
		case 'int':
			if ( ! is_numeric( $raw ) ) {
				return '';
			}
			$n = (int) $raw;
			return ( $n >= $def['min'] && $n <= $def['max'] ) ? (string) $n : '';
	}
	return '';
}

/* --------------------------------------- shared Cozy controls (Padding, Typography) */

/**
 * Per-device values from the Cozy blocks' control format ( desktop|tablet|mobile => ... ) as the menu's
 * d/t/m format, so they go through the same responsive CSS builder.
 *
 * @param mixed $value   Attribute value.
 * @param array $path    Keys inside each device, e.g. array( 'padding' ) or array( 'font', 'size' ).
 * @param bool  $legacy  Also accept the older d/t/m format as is.
 * @return array
 */
function cozy_addons_menu_devices( $value, array $path, $legacy = true ) {
	$out = array();
	if ( ! is_array( $value ) ) {
		return $out;
	}
	if ( $legacy && array_intersect_key( $value, array_flip( array( 'd', 't', 'm' ) ) ) ) {
		return $value; // Saved before the shared controls were used.
	}
	foreach ( array( 'desktop' => 'd', 'tablet' => 't', 'mobile' => 'm' ) as $device => $key ) {
		$v = isset( $value[ $device ] ) ? $value[ $device ] : null;
		foreach ( $path as $step ) {
			$v = is_array( $v ) && isset( $v[ $step ] ) ? $v[ $step ] : null;
		}
		if ( null !== $v && '' !== $v && array() !== $v ) {
			$out[ $key ] = $v;
		}
	}
	return $out;
}

/**
 * Typography of the menu links (TypographyControl format), sanitised: font family, weight, letter case,
 * decoration, line height and letter spacing. Font sizes are per device and go through the map.
 *
 * @param mixed $t Typography attribute.
 * @return array( 'vars' => CSS custom properties, 'family' => Google font family or '' ).
 */
function cozy_addons_menu_typography( $t ) {
	$t      = is_array( $t ) ? $t : array();
	$font   = isset( $t['font'] ) && is_array( $t['font'] ) ? $t['font'] : array();
	$family = trim( preg_replace( '/[^A-Za-z0-9 -]/', '', cozy_addons_menu_str( isset( $font['family'] ) ? $font['family'] : '' ) ) );
	$family = substr( preg_replace( '/\s+/', ' ', $family ), 0, 60 );
	$weight = cozy_addons_menu_str( isset( $font['weight'] ) ? $font['weight'] : '' );
	$weight = in_array( $weight, array( '100', '200', '300', '400', '500', '600', '700', '800', '900' ), true ) ? $weight : '';
	$case   = cozy_addons_menu_enum( cozy_addons_menu_str( isset( $t['letterCase'] ) ? $t['letterCase'] : '' ), array( 'uppercase', 'lowercase', 'capitalize' ), '' );
	$deco   = cozy_addons_menu_enum( cozy_addons_menu_str( isset( $t['decoration'] ) ? $t['decoration'] : '' ), array( 'underline', 'line-through' ), '' );
	$lh     = trim( cozy_addons_menu_str( isset( $t['lineHeight'] ) ? $t['lineHeight'] : '' ) );
	$lh     = preg_match( '/^\d*\.?\d+(?:px|em|rem|%)?$/', $lh ) ? $lh : '';
	$ls     = cozy_addons_menu_sanitize_length( cozy_addons_menu_str( isset( $t['letterSpacing'] ) ? $t['letterSpacing'] : '' ) );
	$ls     = preg_match( '/%|vw|vh|ch/', $ls ) ? '' : $ls;
	$vars   = '';
	foreach ( array(
		'--cozy-addons-menu-ff' => '' !== $family ? '"' . $family . '"' : '',
		'--cozy-addons-menu-fw' => $weight,
		'--cozy-addons-menu-tt' => $case,
		'--cozy-addons-menu-td' => $deco,
		'--cozy-addons-menu-lh' => $lh,
		'--cozy-addons-menu-ls' => $ls,
	) as $var => $value ) {
		if ( '' !== $value ) {
			$vars .= $var . ':' . $value . ';';
		}
	}
	return array( 'vars' => $vars, 'family' => $family );
}

/* ------------------------------------------------------- responsive CSS map */

/*
 * Each map entry: attribute => array( var, type, [allowed|min|max|tokens|wrap|also] ).
 * Keep in sync with assets/js/lib.js (same maps, same cleaning rules).
 */
function cozy_addons_menu_map_root() {
	return array(
		'direction'   => array(
			'var'     => '--cozy-addons-menu-dir',
			'type'    => 'enum',
			'allowed' => array( 'row', 'column' ),
			'also'    => array(
				'--cozy-addons-menu-ai' => array(
					'row'    => 'center',
					'column' => 'stretch',
				),
			),
		),
		'justify'     => array(
			'var'     => '--cozy-addons-menu-justify',
			'type'    => 'enum',
			'allowed' => array( 'flex-start', 'center', 'flex-end', 'space-between' ),
		),
		'gap'         => array(
			'var'  => '--cozy-addons-menu-gap',
			'type' => 'length',
		),
		'fontSize'    => array(
			'var'  => '--cozy-addons-menu-fs',
			'type' => 'length',
		),
		'itemPadding' => array(
			'var'    => '--cozy-addons-menu-pad',
			'type'   => 'length',
			'tokens' => 4,
		),
		'panelOffset' => array(
			'var'  => '--cozy-addons-menu-panel-offset',
			'type' => 'length',
		),
	);
}

function cozy_addons_menu_map_submenu() {
	return array(
		'width' => array(
			'var'  => '--cozy-addons-menu-sub-w',
			'type' => 'length',
		),
	);
}

function cozy_addons_menu_map_mega() {
	return array(
		'padding'     => array(
			'var'    => '--cozy-addons-menu-mega-pad',
			'type'   => 'length',
			'tokens' => 4,
		),
		'customWidth' => array(
			'var'  => '--cozy-addons-menu-mw',
			'type' => 'length',
			'wrap' => 'min(%s,calc(100vw - 24px))',
		),
	);
}

/**
 * Build desktop-first CSS custom properties for one selector.
 * Desktop = base, tablet/mobile = max-width media queries that cascade down.
 */
function cozy_addons_menu_resp_css( $selector, array $map, array $attrs ) {
	$buckets = array(
		'd' => '',
		't' => '',
		'm' => '',
	);
	foreach ( $map as $attr => $def ) {
		$values = cozy_addons_menu_resp( isset( $attrs[ $attr ] ) ? $attrs[ $attr ] : array() );
		foreach ( $values as $device => $raw ) {
			if ( '' === $raw ) {
				continue;
			}
			$clean = cozy_addons_menu_clean_value( $raw, $def );
			if ( '' === $clean ) {
				continue;
			}
			if ( ! empty( $def['also'] ) ) {
				foreach ( $def['also'] as $extra_var => $lookup ) {
					if ( isset( $lookup[ $clean ] ) ) {
						$buckets[ $device ] .= $extra_var . ':' . $lookup[ $clean ] . ';';
					}
				}
			}
			if ( ! empty( $def['wrap'] ) ) {
				$clean = sprintf( $def['wrap'], $clean );
			}
			$buckets[ $device ] .= $def['var'] . ':' . $clean . ';';
		}
	}
	$css = '';
	if ( '' !== $buckets['d'] ) {
		$css .= $selector . '{' . $buckets['d'] . '}';
	}
	if ( '' !== $buckets['t'] ) {
		$css .= '@media (max-width:' . cozy_addons_menu_option( 'tablet' ) . 'px){' . $selector . '{' . $buckets['t'] . '}}';
	}
	if ( '' !== $buckets['m'] ) {
		$css .= '@media (max-width:' . cozy_addons_menu_option( 'mobile' ) . 'px){' . $selector . '{' . $buckets['m'] . '}}';
	}
	return $css;
}

/* ------------------------------------------------ per-request CSS collection */

/** Children push CSS here; the root menu flushes it into one <style> tag. */
function cozy_addons_menu_css_push( $css ) {
	if ( '' !== $css ) {
		$GLOBALS['cozy_addons_menu_css_buffer'][] = $css;
	}
}

function cozy_addons_menu_css_flush() {
	$css                                    = isset( $GLOBALS['cozy_addons_menu_css_buffer'] ) ? implode( '', $GLOBALS['cozy_addons_menu_css_buffer'] ) : '';
	$GLOBALS['cozy_addons_menu_css_buffer'] = array();
	return $css;
}

/** Safety net: CSS from blocks rendered outside a root menu still gets printed. */
add_action(
	'wp_footer',
	function () {
		$css = cozy_addons_menu_css_flush();
		if ( '' !== $css ) {
			echo '<style id="cozy-addons-menu-late-css">' . cozy_addons_menu_safe_css( $css ) . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput -- values are sanitised by cozy_addons_menu_resp_css(); cozy_addons_menu_safe_css() keeps the element closed.
		}
	},
	1
);

/** Mobile-layout rules are shared per breakpoint and printed once per request. */
function cozy_addons_menu_mobile_css( $bp ) {
	static $done = array();
	$bp          = (int) $bp;
	if ( isset( $done[ $bp ] ) ) {
		return '';
	}
	$done[ $bp ] = true;
	$template    = file_get_contents( COZY_ADDONS_PLUGIN_DIR . 'assets/css/menu/mobile.tpl.css' );
	return str_replace( '__BP__', (string) $bp, (string) $template );
}

/* -------------------------------------------------------------------- icons */

function cozy_addons_menu_icons() {
	return array(
		'layout'   => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 9h18M9 21V9"/>',
		'bag'      => '<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 01-8 0"/>',
		'news'     => '<path d="M4 4h13a1 1 0 011 1v14a2 2 0 002 2H6a2 2 0 01-2-2z"/><path d="M18 9h3v10a2 2 0 01-2 2"/><path d="M8 8h6M8 12h6M8 16h4"/>',
		'blocks'   => '<rect x="3" y="3" width="8" height="8" rx="2"/><rect x="13" y="3" width="8" height="8" rx="2"/><rect x="3" y="13" width="8" height="8" rx="2"/><path d="M17 13v8M13 17h8"/>',
		'popup'    => '<rect x="3" y="4" width="18" height="16" rx="3"/><path d="M3 9h18M9 14h6"/>',
		'inbox'    => '<path d="M22 12h-6l-2 3h-4l-2-3H2"/><path d="M5.5 5.1L2 12v6a2 2 0 002 2h16a2 2 0 002-2v-6l-3.5-6.9A2 2 0 0016.8 4H7.2a2 2 0 00-1.7 1.1z"/>',
		'mail'     => '<rect x="2" y="4" width="20" height="16" rx="3"/><path d="M22 7l-10 6L2 7"/>',
		'zap'      => '<path d="M13 2L4 14h7l-1 8 9-12h-7z"/>',
		'home'     => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/><path d="M10 20v-6h4v6"/>',
		'cart'     => '<circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.7 12.4a1 1 0 001 .6h9.6a1 1 0 001-.8L21 7H6"/>',
		'book'     => '<path d="M2 4h6a4 4 0 014 4v13a3 3 0 00-3-3H2z"/><path d="M22 4h-6a4 4 0 00-4 4v13a3 3 0 013-3h7z"/>',
		'target'   => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.5"/>',
		'brief'    => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M3 13h18"/>',
		'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0116 0"/>',
		'info'     => '<circle cx="12" cy="12" r="9"/><path d="M12 11v6M12 7.5v.01"/>',
		'help'     => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 015 .5c0 1.5-2.5 2-2.5 3.5M12 17v.01"/>',
		'chat'     => '<path d="M21 12a8 8 0 01-11.6 7.1L3 21l1.9-5.6A8 8 0 1121 12z"/>',
		'star'     => '<path d="M12 3l2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9z"/>',
		'phone'    => '<path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3.1 19.5 19.5 0 01-6-6A19.8 19.8 0 012.1 4.2 2 2 0 014.1 2h3a2 2 0 012 1.7c.1 1 .4 1.9.7 2.8a2 2 0 01-.5 2.1L8.1 9.9a16 16 0 006 6l1.3-1.3a2 2 0 012.1-.4c.9.3 1.8.6 2.8.7a2 2 0 011.7 2z"/>',
		'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
		'search'   => '<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>',
		'whatsapp' => '<path d="M21 12a8 8 0 01-11.6 7.1L3 21l1.9-5.6A8 8 0 1121 12z"/><path d="M9 8.5c0 3.2 3.3 6.5 6.5 6.5l1-1.7-2-1-1 .8a4.7 4.7 0 01-1.9-1.9l.8-1-1-2z"/>',
		'file'     => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h6"/>',
		'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
	);
}

/**
 * The Cozy icon library (the Icon Picker block's icons), keyed by name. It is the main source of menu
 * icons; the menu's own icons above only fill in names the library does not have.
 *
 * @return array<string,string> Name => SVG markup.
 */
function cozy_addons_menu_library_icons() {
	static $icons = null;
	if ( null === $icons ) {
		$icons = class_exists( '\CozyAddons\Icons' ) ? (array) \CozyAddons\Icons::get_cozy_icon_collection() : array();
	}
	return $icons;
}

/** Whether a name is a known icon: one from the Cozy icon library or one of the menu's own icons. */
function cozy_addons_menu_icon_exists( $key ) {
	if ( ! is_string( $key ) || '' === $key ) {
		return false;
	}
	return isset( cozy_addons_menu_icons()[ $key ] ) || isset( cozy_addons_menu_library_icons()[ $key ] );
}

/**
 * A library icon as menu-ready SVG: 20px, coloured with currentColor like the text around it, and only
 * the drawing elements kept (path, g, circle, rect, ellipse, line, polyline, polygon with presentation
 * attributes). Mirrors libraryIconSvg() in src/mega-menu/edit/utils/icons.js.
 *
 * @param string $markup Library SVG markup.
 * @return string
 */
function cozy_addons_menu_library_svg( $markup ) {
	if ( ! preg_match( '~<svg\b([^>]*)>(.*)</svg>~is', (string) $markup, $m ) ) {
		return '';
	}
	$viewbox = preg_match( '~viewBox="([0-9.\s-]+)"~i', $m[1], $vb ) ? trim( preg_replace( '/\s+/', ' ', $vb[1] ) ) : '0 0 24 24';
	$attrs   = array_fill_keys( array( 'fill', 'fill-rule', 'clip-rule', 'fill-opacity', 'stroke', 'stroke-width', 'stroke-linecap', 'stroke-linejoin', 'opacity', 'transform' ), true );
	$shape   = function ( array $extra ) use ( $attrs ) {
		return $attrs + array_fill_keys( $extra, true );
	};
	$inner = wp_kses(
		$m[2],
		array(
			'path'     => $shape( array( 'd' ) ),
			'g'        => $attrs,
			'circle'   => $shape( array( 'cx', 'cy', 'r' ) ),
			'ellipse'  => $shape( array( 'cx', 'cy', 'rx', 'ry' ) ),
			'rect'     => $shape( array( 'x', 'y', 'width', 'height', 'rx', 'ry' ) ),
			'line'     => $shape( array( 'x1', 'y1', 'x2', 'y2' ) ),
			'polyline' => $shape( array( 'points' ) ),
			'polygon'  => $shape( array( 'points' ) ),
		)
	);
	// Every colour follows the text colour; "none" stays none.
	$inner = preg_replace( '~\b(fill|stroke)="(?!none")[^"]*"~i', '$1="currentColor"', $inner );
	return '<svg viewBox="' . esc_attr( $viewbox ) . '" width="20" height="20" fill="currentColor" aria-hidden="true" focusable="false">' . trim( preg_replace( '/\s+/', ' ', $inner ) ) . '</svg>';
}

/**
 * Icon SVG by name. The Cozy icon library comes first; the menu's own outline icons are used only for
 * names the library does not have. Only known names render.
 */
function cozy_addons_menu_icon( $key ) {
	static $library = array();
	if ( ! is_string( $key ) || '' === $key ) {
		return '';
	}
	$all = cozy_addons_menu_library_icons();
	if ( isset( $all[ $key ] ) ) {
		if ( ! array_key_exists( $key, $library ) ) {
			$library[ $key ] = cozy_addons_menu_library_svg( $all[ $key ] );
		}
		if ( '' !== $library[ $key ] ) {
			return $library[ $key ];
		}
	}
	$icons = cozy_addons_menu_icons();
	if ( isset( $icons[ $key ] ) ) {
		return '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icons[ $key ] . '</svg>';
	}
	return '';
}

/* ------------------------------------------------------------ URL and state */

/** host + path (no trailing slash, no query) for comparing a menu URL with the current request. */
function cozy_addons_menu_url_signature( $url ) {
	$url = trim( cozy_addons_menu_str( $url ) );
	if ( '' === $url || '#' === $url[0] ) {
		return '';
	}
	if ( '/' === $url[0] && 0 !== strpos( $url, '//' ) ) {
		$url = home_url( $url );
	}
	$parts = wp_parse_url( $url );
	if ( empty( $parts['host'] ) ) {
		return '';
	}
	$path = isset( $parts['path'] ) ? untrailingslashit( $parts['path'] ) : '';
	return strtolower( $parts['host'] ) . $path;
}

function cozy_addons_menu_is_current( $url ) {
	static $current = null;
	if ( null === $current ) {
		global $wp;
		$request = ( isset( $wp ) && isset( $wp->request ) ) ? $wp->request : '';
		$current = cozy_addons_menu_url_signature( home_url( '/' . $request ) );
	}
	$signature = cozy_addons_menu_url_signature( $url );
	return '' !== $signature && $signature === $current;
}


/* ------------------------------------------------------------ overlay helpers */

/** "#0A0E28" + 50 => "rgba(10,14,40,0.5)". Anything that is not a hex colour falls back to the default. */
function cozy_addons_menu_hex_to_rgba( $hex, $opacity ) {
	$hex = ltrim( trim( (string) $hex ), '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( ! preg_match( '/^[0-9a-f]{6}$/i', $hex ) ) {
		$hex = '0A0E28';
	}
	$alpha = max( 0, min( 90, (int) $opacity ) ) / 100;
	$alpha = rtrim( rtrim( number_format( $alpha, 2, '.', '' ), '0' ), '.' );
	return sprintf( 'rgba(%d,%d,%d,%s)', hexdec( substr( $hex, 0, 2 ) ), hexdec( substr( $hex, 2, 2 ) ), hexdec( substr( $hex, 4, 2 ) ), '' === $alpha ? '0' : $alpha );
}

function cozy_addons_menu_clamp_int( $value, $min, $max, $fallback ) {
	if ( '' === $value || null === $value || ! is_numeric( $value ) ) {
		return $fallback;
	}
	return max( $min, min( $max, (int) $value ) );
}

/**
 * Overlay config for one menu. A menu value overrides the global default; empty means inherit.
 * Returns array( on => bool, css => custom properties read by view.js ).
 */
function cozy_addons_menu_overlay_config( array $a ) {
	$mode = cozy_addons_menu_enum( isset( $a['overlay'] ) ? $a['overlay'] : 'default', array( 'default', 'on', 'off' ), 'default' );
	$on   = 'on' === $mode || ( 'default' === $mode && cozy_addons_menu_option( 'overlay' ) );
	if ( ! $on ) {
		return array(
			'on'  => false,
			'css' => '',
		);
	}
	$color    = ( isset( $a['overlayColor'] ) && '' !== trim( (string) $a['overlayColor'] ) ) ? $a['overlayColor'] : cozy_addons_menu_option( 'overlay_color' );
	$opacity  = cozy_addons_menu_clamp_int( isset( $a['overlayOpacity'] ) ? $a['overlayOpacity'] : '', 0, 90, cozy_addons_menu_option( 'overlay_opacity' ) );
	$blur     = cozy_addons_menu_clamp_int( isset( $a['overlayBlur'] ) ? $a['overlayBlur'] : '', 0, 24, cozy_addons_menu_option( 'overlay_blur' ) );
	$duration = cozy_addons_menu_clamp_int( isset( $a['overlayDuration'] ) ? $a['overlayDuration'] : '', 0, 1000, cozy_addons_menu_option( 'overlay_duration' ) );
	return array(
		'on'  => true,
		'css' => '--cozy-addons-menu-ov-color:' . cozy_addons_menu_hex_to_rgba( $color, $opacity ) . ';--cozy-addons-menu-ov-blur:' . $blur . 'px;--cozy-addons-menu-ov-dur:' . $duration . 'ms;',
	);
}
