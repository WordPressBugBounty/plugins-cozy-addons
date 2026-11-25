<?php
/**
 * Loads the Advanced Mega Menu block's server side: shared assets, renderers, patterns and the admin page.
 *
 * Ported from the standalone Cozy Menu Builder plugin. It uses its own names (cozy-block/* blocks,
 * cozy_addons_menu_* functions, .cozy-addons-menu-* classes, the ca_menu_settings option), so both plugins can be active together.
 * The blocks themselves are registered by \CozyAddons\Blocks from blocks/; this file supplies their render callbacks.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once COZY_ADDONS_PLUGIN_DIR . 'core/menu/helpers.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/menu/offcanvas.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/menu/render.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/menu/patterns.php';

if ( is_admin() ) {
	require_once COZY_ADDONS_PLUGIN_DIR . 'core/menu/admin.php';
}

// Before \CozyAddons\Blocks::register_blocks() (init, 10), so the handles exist when block.json references them.
add_action( 'init', 'cozy_addons_menu_register_assets', 9 );
add_filter( 'register_block_type_args', 'cozy_addons_menu_render_callbacks', 10, 2 );
add_filter( 'pre_render_block', 'cozy_addons_menu_pre_render_child', 10, 3 );
add_action( 'enqueue_block_editor_assets', 'cozy_addons_menu_editor_data' );

/**
 * Registers the shared frontend handles. Every menu block's block.json references them, so each file
 * loads once per page and only on pages that render a menu block.
 *
 * @return void
 */
function cozy_addons_menu_register_assets() {
	$v = COZY_ADDONS_VERSION;

	wp_register_style( 'cozy-block--menu-frontend', COZY_ADDONS_PLUGIN_URL . 'assets/css/menu/frontend.css', array(), $v );
	wp_register_script(
		'cozy-block--menu-view',
		COZY_ADDONS_PLUGIN_URL . 'frontend/menu/view.js',
		array(),
		$v,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
	// Desktop off-canvas behaviour: enqueued only when a page renders an off-canvas menu, trigger or "opens panel" item.
	wp_register_script(
		'cozy-block--menu-offcanvas',
		COZY_ADDONS_PLUGIN_URL . 'frontend/menu/offcanvas.js',
		array( 'cozy-block--menu-view' ),
		$v,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}

/**
 * Child blocks and their render callbacks.
 *
 * Only the root block is registered on the server. The children are registered in the editor only
 * (one folder per block under src/mega-menu/, metadata in core/menu/blocks/*.json) and rendered by
 * cozy_addons_menu_pre_render_child(), so they add nothing to the server block registry.
 *
 * @return array<string,string>
 */
function cozy_addons_menu_child_blocks() {
	return array(
		'cozy-block/menu-item'          => 'cozy_addons_menu_render_item',
		'cozy-block/menu-home'          => 'cozy_addons_menu_render_home',
		'cozy-block/menu-submenu'       => 'cozy_addons_menu_render_submenu',
		'cozy-block/menu-mega'          => 'cozy_addons_menu_render_mega',
		'cozy-block/menu-panel'         => '__return_empty_string', // Saved mega panel: rendered through a mega item only.
	);
}

/**
 * Attaches the root renderer. Every menu block is dynamic: saved content is only inner-block markup.
 *
 * @param array  $args Block type arguments.
 * @param string $name Block name.
 * @return array
 */
function cozy_addons_menu_render_callbacks( $args, $name ) {
	if ( 'cozy-block/mega-menu' === $name ) {
		$args['render_callback'] = 'cozy_addons_menu_render_root';
	}
	return $args;
}

/**
 * Attribute schema of a child block, read from its metadata file (core/menu/blocks/*.json).
 *
 * @param string $name Block name.
 * @return array Attribute name => schema.
 */
function cozy_addons_menu_child_schema( $name ) {
	static $cache = array();
	$name = (string) $name;
	if ( isset( $cache[ $name ] ) ) {
		return $cache[ $name ];
	}
	$schema = array();
	$slug   = substr( $name, strlen( 'cozy-block/' ) );
	$file   = COZY_ADDONS_PLUGIN_DIR . 'core/menu/blocks/' . $slug . '.json';
	// Only known child blocks map to a file, so a block name can never point at another path.
	if ( isset( cozy_addons_menu_child_blocks()[ $name ] ) && preg_match( '/^[a-z-]+$/', $slug ) && is_readable( $file ) ) {
		$meta = wp_json_file_decode( $file, array( 'associative' => true ) );
		if ( is_array( $meta ) && ! empty( $meta['attributes'] ) && is_array( $meta['attributes'] ) ) {
			$schema = $meta['attributes'];
		}
	}
	$cache[ $name ] = $schema;
	return $schema;
}

/**
 * Attribute defaults of a child block, from its metadata file.
 *
 * @param string $name Block name.
 * @return array
 */
function cozy_addons_menu_child_defaults( $name ) {
	$defaults = array();
	foreach ( cozy_addons_menu_child_schema( $name ) as $key => $schema ) {
		if ( is_array( $schema ) && array_key_exists( 'default', $schema ) ) {
			$defaults[ $key ] = $schema['default'];
		}
	}
	return $defaults;
}

/**
 * Validates a child block's attributes against its schema, the way WordPress does for registered blocks
 * (WP_Block_Type::prepare_attributes_for_render()): undeclared attributes are dropped, a value of the wrong
 * type (an array where a string is expected, and so on) is replaced by the default, and defaults are filled
 * in. The renderers then sanitise and escape each value for where it is printed.
 *
 * @param string $name  Block name.
 * @param mixed  $attrs Raw attributes from the block markup.
 * @return array
 */
function cozy_addons_menu_child_attrs( $name, $attrs ) {
	static $types = array();
	$name   = (string) $name;
	$schema = cozy_addons_menu_child_schema( $name );
	if ( ! isset( $types[ $name ] ) ) {
		// Never registered: the type object only runs the core attribute validation.
		$types[ $name ] = new WP_Block_Type( $name, array( 'attributes' => $schema ) );
	}
	$attrs = is_array( $attrs ) ? array_intersect_key( $attrs, $schema ) : array();
	return $types[ $name ]->prepare_attributes_for_render( $attrs );
}

/**
 * Renders the child blocks, which are not registered on the server.
 *
 * pre_render_block runs for top-level and nested blocks (WP 5.9+), so this covers children inside the
 * menu and any depth of nesting (submenus in submenus, columns in mega panels).
 *
 * @param string|null   $pre    Pre-rendered content, null to continue.
 * @param array         $parsed Parsed block.
 * @param WP_Block|null $parent Parent block, when nested.
 * @return string|null
 */
function cozy_addons_menu_pre_render_child( $pre, $parsed, $parent = null ) {
	$name     = isset( $parsed['blockName'] ) ? $parsed['blockName'] : '';
	$children = cozy_addons_menu_child_blocks();
	if ( null !== $pre || ! isset( $children[ $name ] ) ) {
		return $pre;
	}
	$registry = WP_Block_Type_Registry::get_instance();
	if ( $registry->is_registered( $name ) ) {
		return null; // Registered by someone else: let WordPress render it.
	}
	if ( ! $registry->is_registered( 'cozy-block/mega-menu' ) ) {
		return ''; // The Mega Menu block is turned off in the dashboard.
	}
	if ( $parent instanceof WP_Block && 'cozy-block/mega-menu' === $parent->name && isset( $parent->attributes['displayMode'] ) && 'trigger' === $parent->attributes['displayMode'] ) {
		return ''; // A trigger-mode menu shows only its button: its saved links are kept but not rendered.
	}
	if ( $parent instanceof WP_Block && 'cozy-block/menu-mega' === $parent->name && isset( $parent->attributes['savedPanel'] ) && cozy_addons_menu_saved_panel_blocks( cozy_addons_menu_panel_id( $parent->attributes['savedPanel'] ) ) ) {
		return ''; // The item uses a saved panel: its own links are kept but not rendered.
	}

	$attrs = cozy_addons_menu_child_attrs( $name, isset( $parsed['attrs'] ) ? $parsed['attrs'] : array() );
	if ( in_array( $name, array( 'cozy-block/menu-item', 'cozy-block/menu-home' ), true )
		&& ! ( $parent instanceof WP_Block && in_array( $parent->name, array( 'cozy-block/mega-menu', 'cozy-block/menu-submenu' ), true ) ) ) {
		// Outside a menu list (e.g. in a Columns block inside a mega panel) the link is not a list item.
		return (string) call_user_func( $children[ $name ], $attrs, '', 'div' );
	}
	$content = '';
	if ( ! empty( $parsed['innerBlocks'] ) ) {
		// An unregistered block renders its inner blocks (running this filter for nested children) and keeps the context.
		$inner   = new WP_Block( $parsed, $parent instanceof WP_Block ? $parent->context : array() );
		$content = $inner->render();
	}
	return (string) call_user_func( $children[ $name ], $attrs, $content );
}

/**
 * Gives the editor the breakpoints, icons and defaults, so the preview uses the same rules as the frontend.
 *
 * @return void
 */
function cozy_addons_menu_editor_data() {
	$handle = generate_block_asset_handle( 'cozy-block/mega-menu', 'editorScript' );
	// Not registered when the block is turned off in the dashboard.
	if ( ! wp_script_is( $handle, 'registered' ) ) {
		return;
	}
	wp_add_inline_script(
		$handle,
		'window.cozyAddonsMenuEditor=' . wp_json_encode(
			array(
				'tablet'      => cozy_addons_menu_option( 'tablet' ),
				'mobile'      => cozy_addons_menu_option( 'mobile' ),
				'icons'       => cozy_addons_menu_icons(),
				'isPro'       => cozy_addons_menu_is_pro(),
				'overlay'     => array(
					'on'       => cozy_addons_menu_is_pro() && (bool) cozy_addons_menu_option( 'overlay' ),
					'color'    => cozy_addons_menu_option( 'overlay_color' ),
					'opacity'  => cozy_addons_menu_option( 'overlay_opacity' ),
					'blur'     => cozy_addons_menu_option( 'overlay_blur' ),
					'duration' => cozy_addons_menu_option( 'overlay_duration' ),
				),
				// The off-canvas panel rules, so the editor can show an open-panel mockup with the site's CSS (Pro only).
				'ocTpl'       => cozy_addons_menu_is_pro() ? (string) file_get_contents( COZY_ADDONS_PLUGIN_DIR . 'assets/css/menu/offcanvas.tpl.css' ) : '',
			),
			JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES
		) . ';',
		'before'
	);
}
