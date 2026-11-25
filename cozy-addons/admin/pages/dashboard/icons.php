<?php
/**
 * Inline SVG icons for the Dashboard tab.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'cozy_addons_dashboard_icon' ) ) {
	/**
	 * Returns an inline SVG icon.
	 *
	 * Icons use currentColor, so they take the text color of their parent.
	 * The markup is static and safe to echo.
	 *
	 * @param string $name Icon name.
	 * @param int    $size Width and height in pixels.
	 * @return string SVG markup, or an empty string for an unknown name.
	 */
	function cozy_addons_dashboard_icon( $name, $size = 16 ) {
		static $paths = array(
			'layout'   => '<rect x="3" y="3" width="18" height="18" rx="3" fill="currentColor"/><path d="M3 10h18M11 10v11" stroke="#fff" stroke-width="2"/>',
			'play'     => '<path d="M7 4.5v15a1 1 0 0 0 1.5.86l12.5-7.5a1 1 0 0 0 0-1.72L8.5 3.64A1 1 0 0 0 7 4.5Z" fill="currentColor"/>',
			'users'    => '<circle cx="9" cy="8" r="3.25" stroke="currentColor" stroke-width="1.6"/><path d="M3 19c.6-3 3-4.75 6-4.75S14.4 16 15 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M15.5 4.9a3.25 3.25 0 0 1 0 6.2M17.5 14.6c1.8.6 3.1 2.1 3.5 4.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
			'bulb'     => '<path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-3.6 10.8c.6.5 1.1 1.3 1.1 2.2h5c0-.9.5-1.7 1.1-2.2A6 6 0 0 0 12 3Z" fill="currentColor" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>',
			'check'    => '<path d="m5 12.5 4.5 4.5L19 7.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>',
			'layers'   => '<path d="m12 3 9 4.75-9 4.75-9-4.75L12 3Z" fill="currentColor"/><path d="m3 12.25 9 4.75 9-4.75M3 16.5l9 4.5 9-4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>',
			'blocks'   => '<rect x="3" y="12" width="9" height="9" rx="2" fill="currentColor"/><rect x="3" y="3" width="7" height="7" rx="2" fill="currentColor"/><circle cx="17" cy="7" r="4" fill="currentColor"/>',
			'star'     => '<path d="m12 2.8 2.83 5.73 6.32.92-4.58 4.46 1.08 6.3L12 17.24l-5.65 2.97 1.08-6.3-4.58-4.46 6.32-.92L12 2.8Z" fill="currentColor"/>',
			'popup'    => '<rect x="3" y="4" width="18" height="16" rx="3" stroke="currentColor" stroke-width="1.8"/><path d="M3 9h18" stroke="currentColor" stroke-width="1.8"/><rect x="8" y="12" width="8" height="5" rx="1.2" fill="currentColor"/>',
			'mail'     => '<rect x="2.5" y="4.5" width="19" height="15" rx="2.5" fill="currentColor"/><path d="m3.5 6.5 8.5 6.25 8.5-6.25" stroke="#1d1f3f" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>',
			'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2.5" stroke="currentColor" stroke-width="1.8"/><path d="M3 10h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>',
			'download' => '<path d="M12 3v12m0 0-4.5-4.5M12 15l4.5-4.5M4 17v2.5A1.5 1.5 0 0 0 5.5 21h13a1.5 1.5 0 0 0 1.5-1.5V17" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>',
			'shield'   => '<path d="M12 2.5 20 5.5v6.2c0 4.9-3.4 8.6-8 9.8-4.6-1.2-8-4.9-8-9.8V5.5l8-3Z" fill="currentColor"/><path d="m8.5 12 2.5 2.5 4.5-5" stroke="#1d1f3f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
			'doc'      => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M14 3v5h5M9 13h6M9 17h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>',
			'book'     => '<path d="M5.3 3c2.5 0 4.8.9 6.7 2.5V21c-1.9-1.6-4.2-2.5-6.7-2.5-1.5 0-2.3 0-2.6-.2-.2-.1-.3-.2-.4-.4-.3-.3-.3-.9-.3-2.2V6.4c0-1.4 0-2.2.6-2.7.5-.6 1.1-.6 2.2-.7H5.3ZM18.7 3c-2.5 0-4.8.9-6.7 2.5V21c1.9-1.6 4.2-2.5 6.7-2.5 1.5 0 2.3 0 2.6-.2.2-.1.3-.2.4-.4.3-.3.3-.9.3-2.2V6.4c0-1.4 0-2.2-.6-2.7-.5-.6-1.1-.6-2.2-.7h-.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
			'lifebuoy' => '<circle cx="12" cy="12" r="9.5" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="4.5" stroke="currentColor" stroke-width="1.6"/><path d="m15.2 8.8 3.5-3.5M15.2 15.2l3.5 3.5M8.8 15.2l-3.5 3.5M8.8 8.8 5.3 5.3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
			'eye'      => '<path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>',
			'crown'    => '<path d="M3.5 18.5h17M5 15.5 3 7.5l5 3.5 4-6 4 6 5-3.5-2 8H5Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>',
			'chevron'  => '<path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>',
			'dash'     => '<path d="M6 12h12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
			'arrow'    => '<path d="M5 12h14m0 0-5-5m5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
			'compare'  => '<path d="m9 8-4 4 4 4M15 8l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
			'heart'    => '<path d="M12 20s-7.5-4.6-7.5-10A4.3 4.3 0 0 1 12 7.4 4.3 4.3 0 0 1 19.5 10c0 5.4-7.5 10-7.5 10Z" fill="currentColor"/>',
		);

		if ( ! isset( $paths[ $name ] ) ) {
			return '';
		}

		$size = (int) $size;

		return '<svg class="cbd-icon" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
	}
}

if ( ! function_exists( 'cozy_addons_dashboard_the_icon' ) ) {
	/**
	 * Echoes an inline SVG icon from cozy_addons_dashboard_icon().
	 *
	 * @param string $name Icon name.
	 * @param int    $size Width and height in pixels.
	 * @return void
	 */
	function cozy_addons_dashboard_the_icon( $name, $size = 16 ) {
		echo cozy_addons_dashboard_icon( $name, $size ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG built from a fixed map.
	}
}

if ( ! function_exists( 'cozy_addons_dashboard_badge' ) ) {
	/**
	 * Echoes a tier badge.
	 *
	 * @param string $tier 'pro' or 'free-pro'.
	 * @return void
	 */
	function cozy_addons_dashboard_badge( $tier = 'pro' ) {
		$label = 'free-pro' === $tier ? __( 'Free + Pro', 'cozy-addons' ) : __( 'Pro', 'cozy-addons' );

		printf( '<span class="cbd-badge">%s</span>', esc_html( $label ) );
	}
}
