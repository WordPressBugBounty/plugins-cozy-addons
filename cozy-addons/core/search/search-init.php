<?php
/**
 * Loads the Advanced Search block's server side: settings, relevance engine, analytics and admin page.
 *
 * The public endpoints live with the other REST routes in core/api/class-search.php.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CozyAddons\Core\Search\Search_Settings;
use CozyAddons\Core\Search\Search_Engine;
use CozyAddons\Core\Search\Search_Analytics;
use CozyAddons\Core\Search\Search_Admin;

require_once COZY_ADDONS_PLUGIN_DIR . 'core/search/class-search-settings.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/search/class-search-engine.php';
require_once COZY_ADDONS_PLUGIN_DIR . 'core/search/class-search-analytics.php';

Search_Settings::init();
Search_Engine::init();
Search_Analytics::init();

add_action( 'enqueue_block_editor_assets', 'cozy_addons_search_editor_data' );
add_action( 'pre_get_posts', 'cozy_addons_search_native_results' );

if ( is_admin() ) {
	require_once COZY_ADDONS_PLUGIN_DIR . 'core/search/class-search-admin.php';
	Search_Admin::init();
}

/**
 * Gives the Advanced Search block's sidebar the global defaults, so its toggles show the values that apply.
 *
 * @return void
 */
function cozy_addons_search_editor_data() {
	$handle = generate_block_asset_handle( 'cozy-block/advanced-search', 'editorScript' );
	// Not registered when the block is turned off in the dashboard.
	if ( ! current_user_can( 'edit_posts' ) || ! wp_script_is( $handle, 'registered' ) ) {
		return;
	}

	$s    = Search_Settings::get();
	$data = array(
		'settingsUrl' => current_user_can( 'manage_options' ) ? admin_url( 'admin.php?page=ca-search-settings' ) : '',
		'woo'         => Search_Engine::woo(),
		'defaults'    => array(
			'showRecent'      => (bool) $s['recent_searches'],
			'showPopular'     => (bool) $s['popular_searches'],
			'showSuggestions' => (bool) $s['taxonomy_suggestions'],
			'showQueries'     => (bool) $s['query_suggestions'],
			'groupResults'    => (bool) $s['group_results'],
			'fuzzy'           => (bool) $s['fuzzy_matching'],
			'showImages'      => (bool) $s['show_images'],
			'showExcerpts'    => (bool) $s['show_excerpts'],
			'highlight'       => (bool) $s['highlight'],
			'showTabs'        => (bool) $s['show_tabs'],
			'showViewAll'     => (bool) $s['show_view_all'],
			'loadMore'        => (bool) $s['load_more'],
			'shortcut'        => (bool) $s['shortcut'],
			'voice'           => false,
			'postTypes'       => implode( ',', $s['post_types'] ),
			'taxonomies'      => implode( ',', $s['taxonomies'] ),
			'perPage'         => (int) $s['per_page'],
		),
	);

	wp_add_inline_script( $handle, 'window.cozySearchData = ' . wp_json_encode( $data ) . ';', 'before' );
}

/**
 * Pro: ranks the theme's native search results page (?s=term) with the block's relevance and typo-tolerant engine.
 *
 * @param WP_Query $q Query.
 * @return void
 */
function cozy_addons_search_native_results( $q ) {
	if ( is_admin() || ! $q->is_main_query() || ! $q->is_search() || ! Search_Settings::get( 'native_search' ) ) {
		return;
	}
	$term = Search_Engine::clean_term( (string) $q->get( 's' ) );
	if ( '' === $term ) {
		return;
	}
	$requested = $q->get( 'post_type' );
	if ( is_array( $requested ) ) {
		$requested = implode( ',', $requested );
	}
	$requested = ( is_string( $requested ) && 'any' !== $requested ) ? $requested : '';
	$types     = Search_Engine::resolve_types( $requested );
	$ids       = Search_Engine::ids( $term, $types );

	$q->set( 'post_type', $types );
	$q->set( 'post__in', $ids ? $ids : array( 0 ) );
	$q->set( 'orderby', 'post__in' );
	$q->set( 'ca_search_native', 1 );
}
