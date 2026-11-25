<?php
/**
 * Starter patterns (presets). Paths are placeholders: edit them in the editor.
 */
defined( 'ABSPATH' ) || exit;

/*
 * Promo card for mega menu panels, built from core blocks only: a dark Group with a Heading, a Paragraph
 * and a Button. It replaces the old Featured Card block. The same design is used by the patterns below,
 * the Mega Menus post template (ca_cpt_mega_menu_template()) and the editor's Mega Menu starter.
 */

/** Promo card style values, shared by the markup and the block template. */
function cozy_addons_menu_promo_card_style() {
	return array(
		'bg'        => '#12172B',
		'text'      => '#ffffff',
		'radius'    => '18px',
		'padding'   => '24px',
		'title'     => '1.25rem',
		'body'      => '0.95rem',
		'button_bg' => '#FFB547',
		'button_fg' => '#12172B',
	);
}

/**
 * The promo card as a block template (for a post type template).
 *
 * @param string $title  Heading.
 * @param string $text   Paragraph.
 * @param string $label  Button text.
 * @param string $url    Button link.
 * @return array
 */
function cozy_addons_menu_promo_card_template( $title, $text, $label, $url ) {
	$s = cozy_addons_menu_promo_card_style();
	return array(
		'core/group',
		array(
			'style' => array(
				'color'   => array( 'background' => $s['bg'], 'text' => $s['text'] ),
				'border'  => array( 'radius' => $s['radius'] ),
				'spacing' => array( 'padding' => array( 'top' => $s['padding'], 'right' => $s['padding'], 'bottom' => $s['padding'], 'left' => $s['padding'] ) ),
			),
		),
		array(
			array( 'core/heading', array( 'level' => 4, 'content' => $title, 'style' => array( 'typography' => array( 'fontSize' => $s['title'] ) ) ) ),
			array( 'core/paragraph', array( 'content' => $text, 'style' => array( 'typography' => array( 'fontSize' => $s['body'] ) ) ) ),
			array(
				'core/buttons',
				array(),
				array(
					array( 'core/button', array( 'text' => $label, 'url' => $url, 'style' => array( 'color' => array( 'background' => $s['button_bg'], 'text' => $s['button_fg'] ) ) ) ),
				),
			),
		),
	);
}

/**
 * The promo card as saved block markup (for patterns), matching what the block editor saves.
 *
 * @param string $title  Heading.
 * @param string $text   Paragraph.
 * @param string $label  Button text.
 * @param string $url    Button link.
 * @return string
 */
function cozy_addons_menu_promo_card_markup( $title, $text, $label, $url ) {
	$s   = cozy_addons_menu_promo_card_style();
	$pad = $s['padding'];
	$tpl = cozy_addons_menu_promo_card_template( $title, $text, $label, $url );
	$j   = function ( $attrs ) {
		return wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES );
	};
	return '<!-- wp:group ' . $j( $tpl[1] ) . " -->\n"
		. '<div class="wp-block-group has-text-color has-background" style="border-radius:' . $s['radius'] . ';color:' . $s['text'] . ';background-color:' . $s['bg'] . ';padding-top:' . $pad . ';padding-right:' . $pad . ';padding-bottom:' . $pad . ';padding-left:' . $pad . '">'
		. '<!-- wp:heading ' . $j( array( 'level' => 4, 'style' => array( 'typography' => array( 'fontSize' => $s['title'] ) ) ) ) . " -->\n"
		. '<h4 class="wp-block-heading" style="font-size:' . $s['title'] . '">' . esc_html( $title ) . "</h4>\n<!-- /wp:heading -->\n\n"
		. '<!-- wp:paragraph ' . $j( array( 'style' => array( 'typography' => array( 'fontSize' => $s['body'] ) ) ) ) . " -->\n"
		. '<p style="font-size:' . $s['body'] . '">' . esc_html( $text ) . "</p>\n<!-- /wp:paragraph -->\n\n"
		. "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\">"
		. '<!-- wp:button ' . $j( array( 'style' => array( 'color' => array( 'background' => $s['button_bg'], 'text' => $s['button_fg'] ) ) ) ) . " -->\n"
		. '<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="' . esc_url( $url ) . '" style="color:' . $s['button_fg'] . ';background-color:' . $s['button_bg'] . '">' . esc_html( $label ) . "</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:group -->";
}

add_action( 'init', function () {
	if ( ! function_exists( 'register_block_pattern' ) || '0' === get_option( 'cozy-block--mega-menu' ) ) {
		return;
	}
	register_block_pattern_category( 'cozy-block-menu', array( 'label' => __( 'Cozy Blocks Menus', 'cozy-addons' ) ) );

	register_block_pattern( 'cozy-block/menu-simple', array(
		'title'      => __( 'Simple horizontal navigation', 'cozy-addons' ),
		'categories' => array( 'cozy-block-menu' ),
		'content'    => '<!-- wp:cozy-block/mega-menu {"ariaLabel":"Primary"} -->
<!-- wp:cozy-block/menu-home /-->
<!-- wp:cozy-block/menu-item {"label":"About","url":"/about/"} /-->
<!-- wp:cozy-block/menu-item {"label":"Services","url":"/services/"} /-->
<!-- wp:cozy-block/menu-item {"label":"Contact","url":"/contact/"} /-->
<!-- /wp:cozy-block/mega-menu -->',
	) );

	register_block_pattern( 'cozy-block/menu-submenu', array(
		'title'      => __( 'Navigation with submenu', 'cozy-addons' ),
		'categories' => array( 'cozy-block-menu' ),
		'content'    => '<!-- wp:cozy-block/mega-menu {"ariaLabel":"Primary","openOn":"hover"} -->
<!-- wp:cozy-block/menu-home /-->
<!-- wp:cozy-block/menu-submenu {"label":"Services","url":"/services/"} -->
<!-- wp:cozy-block/menu-item {"label":"Web design","url":"/services/web-design/","icon":"layout","description":"Sites that convert"} /-->
<!-- wp:cozy-block/menu-item {"label":"Local SEO","url":"/services/local-seo/","icon":"target","description":"Rank where you work"} /-->
<!-- wp:cozy-block/menu-item {"label":"Support plans","url":"/services/support/","icon":"help"} /-->
<!-- /wp:cozy-block/menu-submenu -->
<!-- wp:cozy-block/menu-item {"label":"Pricing","url":"/pricing/"} /-->
<!-- wp:cozy-block/menu-item {"label":"Contact","url":"/contact/"} /-->
<!-- /wp:cozy-block/mega-menu -->',
	) );

	register_block_pattern( 'cozy-block/menu-mega', array(
		'title'      => __( 'Mega menu with promo card', 'cozy-addons' ),
		'categories' => array( 'cozy-block-menu' ),
		'content'    => '<!-- wp:cozy-block/mega-menu {"ariaLabel":"Primary","openOn":"hover"} -->
<!-- wp:cozy-block/menu-home /-->
<!-- wp:cozy-block/menu-mega {"label":"Products","widthMode":"content"} -->
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"cozy-addons-menu-heading"} -->
<p class="cozy-addons-menu-heading">Build</p>
<!-- /wp:paragraph -->
<!-- wp:cozy-block/menu-item {"label":"Website builder","url":"/products/website-builder/","icon":"layout","description":"Design pages visually"} /-->
<!-- wp:cozy-block/menu-item {"label":"Store builder","url":"/products/store-builder/","icon":"bag","description":"Sell online"} /-->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"cozy-addons-menu-heading"} -->
<p class="cozy-addons-menu-heading">Grow</p>
<!-- /wp:paragraph -->
<!-- wp:cozy-block/menu-item {"label":"Popups","url":"/products/popups/","icon":"popup","description":"Smart offers"} /-->
<!-- wp:cozy-block/menu-item {"label":"Forms and inbox","url":"/products/forms/","icon":"inbox","description":"Track every lead"} /-->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"cozy-addons-menu-heading"} -->
<p class="cozy-addons-menu-heading">Learn</p>
<!-- /wp:paragraph -->
<!-- wp:cozy-block/menu-item {"label":"Guides","url":"/guides/","icon":"book"} /-->
<!-- wp:cozy-block/menu-item {"label":"Support","url":"/support/","icon":"help"} /-->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">' . cozy_addons_menu_promo_card_markup( __( 'New: starter sites', 'cozy-addons' ), __( 'Import a complete design in one click.', 'cozy-addons' ), __( 'Browse starters', 'cozy-addons' ), '/starter-sites/' ) . '</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- /wp:cozy-block/menu-mega -->
<!-- wp:cozy-block/menu-item {"label":"Pricing","url":"/pricing/"} /-->
<!-- /wp:cozy-block/mega-menu -->',
	) );

	register_block_pattern( 'cozy-block/menu-promo-card', array(
		'title'       => __( 'Mega menu promo card', 'cozy-addons' ),
		'description' => __( 'A card with a heading, text and a button, made of core blocks. Place it in a mega menu panel.', 'cozy-addons' ),
		'categories'  => array( 'cozy-block-menu' ),
		'content'     => cozy_addons_menu_promo_card_markup( __( 'Featured offer', 'cozy-addons' ), __( 'Promote a product, a guide or a sale here.', 'cozy-addons' ), __( 'Learn more', 'cozy-addons' ), '#' ),
	) );

	if ( ! cozy_addons_menu_is_pro() ) {
		return; // Desktop off-canvas is Pro.
	}

	// Desktop off-canvas starters. Give each menu an HTML anchor (Advanced) to open it from a trigger menu or menu items.
	$oc_items = '<!-- wp:cozy-block/menu-home /-->
<!-- wp:cozy-block/menu-submenu {"label":"Services","url":"/services/"} -->
<!-- wp:cozy-block/menu-item {"label":"Web design","url":"/services/web-design/"} /-->
<!-- wp:cozy-block/menu-item {"label":"Local SEO","url":"/services/local-seo/"} /-->
<!-- /wp:cozy-block/menu-submenu -->
<!-- wp:cozy-block/menu-item {"label":"Pricing","url":"/pricing/"} /-->
<!-- wp:cozy-block/menu-item {"label":"Contact","url":"/contact/"} /-->';
	// Closing text and a button below the links (panel intro and panel buttons).
	$oc_extras = ',"ocIntro":"Questions? We reply within one working day.","ocCtas":[{"id":"contact","type":"quote","enabled":true,"style":"primary","label":"Get in touch","url":"/contact/"}]';

	register_block_pattern( 'cozy-block/menu-offcanvas-drawer', array(
		'title'      => __( 'Off-canvas side drawer', 'cozy-addons' ),
		'categories' => array( 'cozy-block-menu' ),
		'content'    => '<!-- wp:cozy-block/mega-menu {"ariaLabel":"Primary","displayMode":"offcanvas","ocLayout":"drawer","ocSide":"right","ocOffsetTop":"auto","ocHeading":"Explore","ocLogo":"site"' . $oc_extras . '} -->' . "\n" . $oc_items . "\n" . '<!-- /wp:cozy-block/mega-menu -->',
	) );
	register_block_pattern( 'cozy-block/menu-offcanvas-fullscreen', array(
		'title'      => __( 'Fullscreen overlay menu', 'cozy-addons' ),
		'categories' => array( 'cozy-block-menu' ),
		'content'    => '<!-- wp:cozy-block/mega-menu {"ariaLabel":"Primary","displayMode":"offcanvas","ocLayout":"fullscreen","ocContent":"editorial","ocAnimation":"reveal-up","ocBg":"#12172B","ocText":"#ffffff","ocLogo":"site"' . $oc_extras . '} -->' . "\n" . $oc_items . "\n" . '<!-- /wp:cozy-block/mega-menu -->',
	) );
	register_block_pattern( 'cozy-block/menu-offcanvas-push', array(
		'title'      => __( 'Push sidebar menu', 'cozy-addons' ),
		'categories' => array( 'cozy-block-menu' ),
		'content'    => '<!-- wp:cozy-block/mega-menu {"ariaLabel":"Primary","displayMode":"offcanvas","ocLayout":"push","ocSide":"left","ocWidth":"narrow","ocHeading":"Menu"' . $oc_extras . '} -->' . "\n" . $oc_items . "\n" . '<!-- /wp:cozy-block/mega-menu -->',
	) );
} );
