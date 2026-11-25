<?php
/**
 * Server-side render of the Advanced Search block.
 *
 * The search runs through the public cozy-block/v1/search route. Its settings travel in data-*
 * attributes rather than a nonce, so the block keeps working on cached pages.
 *
 * @var array $attributes Block attributes.
 *
 * @package CozyAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CozyAddons\Core\Search\Search_Settings;
use CozyAddons\Core\Search\Search_Engine;

$cozy_search_settings = Search_Settings::get();
$cozy_search_pro      = cozy_addons_premium_access();

// Toggle attributes have no default: when unset the global setting applies. Pro toggles are off on free sites.
$cozy_search_flag = static function ( $attr, $setting, $pro = false ) use ( $attributes, $cozy_search_settings, $cozy_search_pro ) {
	if ( $pro && ! $cozy_search_pro ) {
		return false;
	}
	if ( array_key_exists( $attr, $attributes ) ) {
		return ! empty( $attributes[ $attr ] );
	}

	return $setting ? ! empty( $cozy_search_settings[ $setting ] ) : false;
};

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['clientId'] ) ) ) : wp_unique_id( 'search-' );
$block_id  = 'cozyBlock_' . str_replace( '-', '_', sanitize_key( $client_id ) );

// The same block can appear more than once on a page (e.g. a synced pattern), so element ids get their own suffix.
$uid  = wp_unique_id( 'cozy-search-' );
$mode = isset( $attributes['mode'] ) && in_array( $attributes['mode'], array( 'form', 'icon', 'fullscreen', 'inline' ), true ) ? $attributes['mode'] : 'form';

$label       = ! empty( $attributes['label'] ) ? $attributes['label'] : __( 'Search', 'cozy-addons' );
$placeholder = ! empty( $attributes['placeholder'] ) ? $attributes['placeholder'] : __( 'Search…', 'cozy-addons' );
$btn_icon    = isset( $attributes['buttonStyle'] ) && 'icon' === $attributes['buttonStyle'];
$button_text = ! empty( $attributes['buttonText'] ) ? $attributes['buttonText'] : __( 'Search', 'cozy-addons' );

$types = Search_Engine::resolve_types( ! empty( $attributes['postTypes'] ) ? $attributes['postTypes'] : $cozy_search_settings['post_types'] );
$taxes = Search_Engine::resolve_taxonomies( ! empty( $attributes['taxonomies'] ) ? $attributes['taxonomies'] : $cozy_search_settings['taxonomies'] );
$per   = ! empty( $attributes['perPage'] ) ? min( 20, max( 1, (int) $attributes['perPage'] ) ) : (int) $cozy_search_settings['per_page'];
// A block may raise the global minimum, never lower it (the server enforces the global value).
$min_chars = max( (int) $cozy_search_settings['min_chars'], isset( $attributes['minChars'] ) ? (int) $attributes['minChars'] : 0 );

$type_list = array();
foreach ( $types as $cozy_search_type ) {
	$type_object = get_post_type_object( $cozy_search_type );
	$type_list[] = array(
		'name'  => $cozy_search_type,
		'label' => $type_object ? $type_object->labels->name : $cozy_search_type,
	);
}

$i18n = array(
	'recent'        => __( 'Recent searches', 'cozy-addons' ),
	'popular'       => __( 'Popular searches', 'cozy-addons' ),
	'topics'        => __( 'Topics', 'cozy-addons' ),
	'suggested'     => __( 'Suggested searches', 'cozy-addons' ),
	'clear'         => __( 'Clear', 'cozy-addons' ),
	'remove'        => __( 'Remove', 'cozy-addons' ),
	'all'           => __( 'All', 'cozy-addons' ),
	'filter'        => __( 'Filter by type', 'cozy-addons' ),
	'searching'     => __( 'Searching…', 'cozy-addons' ),
	/* translators: %s: search term */
	'noResults'     => __( 'No results for “%s”', 'cozy-addons' ),
	'noResultsTip'  => __( 'Check the spelling or try a more general word.', 'cozy-addons' ),
	'noneShort'     => __( 'No results', 'cozy-addons' ),
	/* translators: %d: number of results */
	'resultOne'     => __( '%d result', 'cozy-addons' ),
	/* translators: %d: number of results */
	'resultOther'   => __( '%d results', 'cozy-addons' ),
	/* translators: %s: search term */
	'viewAll'       => __( 'View all results for “%s”', 'cozy-addons' ),
	'loadMore'      => __( 'Show more results', 'cozy-addons' ),
	/* translators: %s: corrected search term */
	'didYouMean'    => __( 'Did you mean %s?', 'cozy-addons' ),
	/* translators: %s: corrected search term */
	'showingFor'    => __( 'Showing results for %s', 'cozy-addons' ),
	/* translators: %s: search term as typed */
	'searchFor'     => __( 'Search instead for %s', 'cozy-addons' ),
	'error'         => __( 'Search is unavailable right now.', 'cozy-addons' ),
	'rateLimited'   => __( 'Too many searches. Please wait a moment.', 'cozy-addons' ),
	'retry'         => __( 'Try again', 'cozy-addons' ),
	'close'         => __( 'Close search', 'cozy-addons' ),
	'voice'         => __( 'Search by voice', 'cozy-addons' ),
	'listening'     => __( 'Listening… Speak your search.', 'cozy-addons' ),
	'voiceError'    => __( 'Voice search did not work. Please type your search.', 'cozy-addons' ),
	'heard'         => __( 'Got it… pause when you are done.', 'cozy-addons' ),
	'noSpeech'      => __( 'Didn’t catch that. Please try again.', 'cozy-addons' ),
	'originalPrice' => __( 'Original price:', 'cozy-addons' ),
	'currentPrice'  => __( 'Current price:', 'cozy-addons' ),
	/* translators: 1: average rating, 2: number of reviews */
	'rating'        => __( 'Rated %1$s out of 5, reviews: %2$s', 'cozy-addons' ),
	'outOfStock'    => __( 'Out of stock', 'cozy-addons' ),
	'onSale'        => __( 'Sale', 'cozy-addons' ),
	'results'       => __( 'Search results', 'cozy-addons' ),
);

$shortcut = $cozy_search_flag( 'shortcut', 'shortcut' );

$search_attributes = array(
	'id'                => $block_id,
	'class'             => 'cozy-block-advanced-search cozy-search-root cozy-search-mode-' . $mode,
	'data-mode'         => $mode,
	'data-rest-url'     => esc_url_raw( rest_url( 'cozy-block/v1/search' ) ),
	'data-popular-url'  => esc_url_raw( rest_url( 'cozy-block/v1/search-popular' ) ),
	// Searches are recorded on every site when enabled; Insights and the features built on them are Pro.
	'data-track-url'    => $cozy_search_settings['track_searches'] ? esc_url_raw( rest_url( 'cozy-block/v1/search-track' ) ) : '',
	'data-search-url'   => esc_url_raw( home_url( '/' ) ),
	'data-post-types'   => implode( ',', $types ),
	'data-taxonomies'   => implode( ',', $taxes ),
	'data-types'        => wp_json_encode( $type_list ),
	'data-per-page'     => (string) $per,
	'data-min-chars'    => (string) $min_chars,
	'data-debounce'     => (string) (int) $cozy_search_settings['debounce'],
	'data-recent-limit' => (string) (int) $cozy_search_settings['recent_limit'],
	'data-recent'       => $cozy_search_flag( 'showRecent', 'recent_searches', true ) ? '1' : '0',
	'data-popular'      => $cozy_search_flag( 'showPopular', 'popular_searches', true ) ? '1' : '0',
	'data-topics'       => $cozy_search_flag( 'showSuggestions', 'taxonomy_suggestions' ) ? '1' : '0',
	'data-queries'      => $cozy_search_flag( 'showQueries', 'query_suggestions', true ) ? '1' : '0',
	'data-group'        => $cozy_search_flag( 'groupResults', 'group_results' ) ? '1' : '0',
	'data-fuzzy'        => $cozy_search_flag( 'fuzzy', 'fuzzy_matching', true ) ? '1' : '0',
	'data-images'       => $cozy_search_flag( 'showImages', 'show_images' ) ? '1' : '0',
	'data-excerpts'     => $cozy_search_flag( 'showExcerpts', 'show_excerpts' ) ? '1' : '0',
	'data-highlight'    => $cozy_search_flag( 'highlight', 'highlight' ) ? '1' : '0',
	'data-tabs'         => $cozy_search_flag( 'showTabs', 'show_tabs' ) ? '1' : '0',
	'data-view-all'     => $cozy_search_flag( 'showViewAll', 'show_view_all' ) ? '1' : '0',
	'data-load-more'    => $cozy_search_flag( 'loadMore', 'load_more', true ) ? '1' : '0',
	'data-shortcut'     => $shortcut ? '1' : '0',
	'data-voice'        => $cozy_search_flag( 'voice', '', true ) ? '1' : '0',
	'data-i18n'         => wp_json_encode( $i18n ),
);

/*
 * Styles. Keep in sync with edit/style.js.
 */
$css = 'cozy_addons_form_css_value';

$decl = static function ( $name, $value ) {
	return '' !== $value && null !== $value ? $name . ':' . $value . ';' : '';
};

$trbl = static function ( $type, $values ) use ( $css ) {
	if ( ! is_array( $values ) ) {
		return '';
	}
	$values = array_map( $css, array_intersect_key( $values, array_flip( array( 'top', 'right', 'bottom', 'left', 'width', 'style', 'color' ) ) ) );

	return cozy_render_TRBL( $type, $values );
};

$font_size = static function ( $typo, $device ) use ( $decl ) {
	return $decl( 'font-size', isset( $typo[ $device ]['font']['size'] ) ? cozy_addons_sanitize_dimension( $typo[ $device ]['font']['size'] ) : '' );
};

// Every TypographyControl value except the responsive font size.
$typography = static function ( $typo ) use ( $css, $decl ) {
	$typo   = is_array( $typo ) ? $typo : array();
	$family = $css( $typo['font']['family'] ?? '' );

	return $decl( 'font-weight', $css( $typo['font']['weight'] ?? '' ) )
		. $decl( 'font-family', '' !== $family ? "'{$family}'" : '' )
		. $decl( 'text-transform', $css( $typo['letterCase'] ?? '' ) )
		. $decl( 'text-decoration', $css( $typo['decoration'] ?? '' ) )
		. $decl( 'line-height', $css( $typo['lineHeight'] ?? '' ) )
		. $decl( 'letter-spacing', cozy_addons_sanitize_dimension( $typo['letterSpacing'] ?? '' ) );
};

$style_attr = static function ( $key ) use ( $attributes ) {
	return isset( $attributes[ $key ] ) && is_array( $attributes[ $key ] ) ? $attributes[ $key ] : array();
};

$trigger = $style_attr( 'triggerStyles' );
$button  = $style_attr( 'buttonStyles' );
$icon    = $style_attr( 'iconStyles' );
$panel   = $style_attr( 'panelStyles' );
$input   = $style_attr( 'inputStyles' );
$holder  = $style_attr( 'placeholderStyles' );
$result  = $style_attr( 'resultStyles' );
$chip    = $style_attr( 'chipStyles' );
$tab     = $style_attr( 'tabStyles' );

// Reads a nested style value, sanitized for CSS.
$v = static function ( $group, $path ) use ( $css ) {
	foreach ( explode( '.', $path ) as $part ) {
		if ( ! is_array( $group ) || ! isset( $group[ $part ] ) ) {
			return '';
		}
		$group = $group[ $part ];
	}

	return $css( $group );
};

$accent = $css( $attributes['accentColor'] ?? '' );
$width  = isset( $attributes['modalWidth'] ) ? min( 1100, max( 480, (int) $attributes['modalWidth'] ) ) : 720;

// Aligns the search bar inside its container when it is narrower (max width). Keep in sync with edit/style.js.
$align_margins = static function ( $value ) {
	$map = array(
		'left'   => 'margin-left: 0; margin-right: auto;',
		'center' => 'margin-left: auto; margin-right: auto;',
		'right'  => 'margin-left: auto; margin-right: 0;',
	);

	return is_string( $value ) && isset( $map[ $value ] ) ? $map[ $value ] : '';
};

$device_styles = static function ( $device ) use ( $block_id, $trbl, $decl, $v, $align_margins, $font_size, $trigger, $button, $input, $holder, $result ) {
	return "
	#{$block_id} .cozy-search-form-trigger,
	#{$block_id} .cozy-search-inline-wrap {
		{$decl( 'max-width', $v( $trigger, "{$device}.width" ) )}
		{$align_margins( $trigger[ $device ]['align'] ?? '' )}
	}
	#{$block_id} .cozy-search-form-trigger,
	#{$block_id} .cozy-search-inline-wrap > .cozy-search-form-search {
		{$decl( 'min-height', $v( $trigger, "{$device}.height" ) )}
		{$trbl( 'padding', $trigger[ $device ]['padding'] ?? null )}
	}
	#{$block_id} .cozy-search-form-trigger,
	#{$block_id} .cozy-search-inline-wrap .cozy-search-input {
		{$font_size( $trigger, $device )}
	}
	#{$block_id} .cozy-search-trigger-button {
		{$trbl( 'padding', $button[ $device ]['padding'] ?? null )}
		{$font_size( $button, $device )}
	}
	#{$block_id} .cozy-search-header .cozy-search-input {
		{$font_size( $input, $device )}
	}
	#{$block_id} .cozy-search-input::placeholder {
		{$font_size( $holder, $device )}
	}
	#{$block_id} .cozy-search-result-title {
		{$font_size( $result, $device )}
	}
	#{$block_id} .cozy-search-result-img {
		{$decl( 'width', $v( $result, "{$device}.imageWidth" ) )}
		{$decl( 'height', $v( $result, "{$device}.imageHeight" ) )}
	}
	";
};

$block_styles = "
#{$block_id} {
	{$decl( '--cozy-search-accent', $accent )}
	--cozy-search-width: {$width}px;
}
#{$block_id} .cozy-search-form-trigger,
#{$block_id} .cozy-search-inline-wrap > .cozy-search-form-search {
	{$typography( $trigger )}
	{$trbl( 'border', $trigger['border'] ?? null )}
	{$decl( 'border-radius', $v( $trigger, 'radius' ) )}
	{$decl( 'color', $v( $trigger, 'color.text' ) )}
	{$decl( 'background-color', $v( $trigger, 'color.bg' ) )}
}
#{$block_id} .cozy-search-inline-wrap .cozy-search-input {
	{$typography( $trigger )}
	{$decl( 'color', $v( $trigger, 'color.text' ) )}
}
#{$block_id} .cozy-search-form-trigger:hover,
#{$block_id} .cozy-search-inline-wrap > .cozy-search-form-search:focus-within {
	{$decl( 'border-color', $v( $trigger, 'color.borderHover' ) )}
}
#{$block_id} .cozy-search-form-trigger > .cozy-search-icon,
#{$block_id} .cozy-search-inline-wrap .cozy-search-search-symbol {
	{$decl( 'color', $v( $trigger, 'color.icon' ) )}
}

#{$block_id} .cozy-search-trigger-button {
	{$typography( $button )}
	{$decl( 'border-radius', $v( $button, 'radius' ) )}
	{$decl( 'color', $v( $button, 'color.text' ) )}
	{$decl( 'background-color', $v( $button, 'color.bg' ) )}
}
#{$block_id} .cozy-search-form-trigger:hover .cozy-search-trigger-button {
	{$decl( 'color', $v( $button, 'color.textHover' ) )}
	{$decl( 'background-color', $v( $button, 'color.bgHover' ) )}
}

#{$block_id} .cozy-search-icon-trigger {
	{$decl( 'width', $v( $icon, 'size' ) )}
	{$decl( 'height', $v( $icon, 'size' ) )}
	{$trbl( 'border', $icon['border'] ?? null )}
	{$decl( 'border-radius', $v( $icon, 'radius' ) )}
	{$decl( 'color', $v( $icon, 'color.icon' ) )}
	{$decl( 'background-color', $v( $icon, 'color.bg' ) )}
}
#{$block_id} .cozy-search-icon-trigger:hover {
	{$decl( 'color', $v( $icon, 'color.iconHover' ) )}
	{$decl( 'background-color', $v( $icon, 'color.bgHover' ) )}
	{$decl( 'border-color', $v( $icon, 'color.borderHover' ) )}
}
#{$block_id} .cozy-search-icon-trigger .cozy-search-icon {
	{$decl( 'width', $v( $icon, 'iconSize' ) )}
	{$decl( 'height', $v( $icon, 'iconSize' ) )}
}

#{$block_id} .cozy-search-modal,
#{$block_id} .cozy-search-panel {
	{$decl( '--cozy-search-bg', $v( $panel, 'color.bg' ) )}
	{$decl( '--cozy-search-fg', $v( $panel, 'color.text' ) )}
	{$decl( '--cozy-search-muted', $v( $panel, 'color.muted' ) )}
	{$decl( '--cozy-search-line', $v( $panel, 'color.line' ) )}
	{$decl( '--cozy-search-hover', $v( $panel, 'color.hover' ) )}
}
#{$block_id}:not(.cozy-search-mode-fullscreen) .cozy-search-backdrop {
	{$decl( 'background', $v( $panel, 'color.overlay' ) )}
}
#{$block_id} .cozy-search-dropdown {
	{$trbl( 'border', $panel['border'] ?? null )}
	{$decl( 'border-radius', $v( $panel, 'radius' ) )}
}
@media (min-width: 641px) {
	#{$block_id}:not(.cozy-search-mode-fullscreen) .cozy-search-dialog {
		{$trbl( 'border', $panel['border'] ?? null )}
		{$decl( 'border-radius', $v( $panel, 'radius' ) )}
	}
}

#{$block_id} .cozy-search-header .cozy-search-input {
	{$typography( $input )}
	{$decl( 'color', $v( $input, 'color.text' ) )}
}
#{$block_id} .cozy-search-input::placeholder {
	{$typography( $holder )}
	{$decl( 'color', $v( $input, 'color.placeholder' ) )}
}

#{$block_id} .cozy-search-result {
	{$decl( 'border-radius', $v( $result, 'radius' ) )}
}
#{$block_id} .cozy-search-result:hover,
#{$block_id} .cozy-search-result.is-active {
	{$decl( 'background', $v( $result, 'color.bgHover' ) )}
}
#{$block_id} .cozy-search-result-title {
	{$typography( $result )}
	{$decl( 'color', $v( $result, 'color.title' ) )}
}
#{$block_id} .cozy-search-result-meta {
	{$decl( 'color', $v( $result, 'color.meta' ) )}
}
#{$block_id} .cozy-search-result-excerpt {
	{$decl( 'color', $v( $result, 'color.excerpt' ) )}
}
/* Older blocks saved one size for both; the per-device rules below override it. */
#{$block_id} .cozy-search-result-img {
	{$decl( 'width', '' !== $v( $result, 'imageWidth' ) ? $v( $result, 'imageWidth' ) : $v( $result, 'imageSize' ) )}
	{$decl( 'height', '' !== $v( $result, 'imageHeight' ) ? $v( $result, 'imageHeight' ) : $v( $result, 'imageSize' ) )}
	{$decl( 'border-radius', $v( $result, 'imageRadius' ) )}
}
#{$block_id} .cozy-search-mark {
	{$decl( 'background', $v( $result, 'color.highlightBg' ) )}
	{$decl( 'color', $v( $result, 'color.highlightText' ) )}
}

#{$block_id} .cozy-search-chip,
#{$block_id} .cozy-search-chip-wrap {
	{$decl( 'border-radius', $v( $chip, 'radius' ) )}
	{$decl( 'border-color', $v( $chip, 'color.border' ) )}
}
#{$block_id} .cozy-search-chip {
	{$decl( 'color', $v( $chip, 'color.text' ) )}
	{$decl( 'background', $v( $chip, 'color.bg' ) )}
}
#{$block_id} .cozy-search-chip:hover {
	{$decl( 'color', $v( $chip, 'color.textHover' ) )}
	{$decl( 'background', $v( $chip, 'color.bgHover' ) )}
}

#{$block_id} .cozy-search-tab {
	{$decl( 'border-radius', $v( $tab, 'radius' ) )}
	{$decl( 'color', $v( $tab, 'color.text' ) )}
	{$decl( 'background', $v( $tab, 'color.bg' ) )}
	{$trbl( 'border', $tab['border'] ?? null )}
}
#{$block_id} .cozy-search-tab[aria-pressed=\"true\"] {
	{$decl( 'color', $v( $tab, 'color.activeText' ) )}
	{$decl( 'background', $v( $tab, 'color.activeBg' ) )}
	{$decl( 'border-color', $v( $tab, 'color.activeBg' ) )}
	{$trbl( 'border', $tab['activeBorder'] ?? null )}
}

{$device_styles( 'desktop' )}
@media only screen and (width <= 1024px) {
	{$device_styles( 'tablet' )}
}
@media only screen and (width <= 767px) {
	{$device_styles( 'mobile' )}
}
";
$block_styles = cozy_addons_clean_empty_css( $block_styles );
// Drops the rules left empty, so pages only carry the styles that were set.
$block_styles = preg_replace( '/[^{}]+\{\s*\}/', '', $block_styles );
$block_styles = preg_replace( '/@media[^{]+\{\s*\}/', '', $block_styles );
$block_styles = trim( preg_replace( '/\s+/', ' ', $block_styles ) );

// Google Fonts.
$font_families = array();
foreach ( array( $trigger, $button, $input, $holder, $result ) as $typo ) {
	$family = $css( $typo['font']['family'] ?? '' );
	if ( '' !== $family ) {
		$font_families[] = $family;
	}
}
$font_families = array_unique( $font_families );
if ( ! empty( $font_families ) ) {
	$font_query = array();
	foreach ( $font_families as $family ) {
		$font_query[] = 'family=' . str_replace( ' ', '+', $family ) . ':wght@100;200;300;400;500;600;700;800;900';
	}
	echo cozy_addons_google_fonts_link( 'https://fonts.googleapis.com/css2?' . implode( '&', $font_query ) . '&display=swap' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in the helper.
}

if ( did_action( 'wp_enqueue_scripts' ) ) {
	// Classic themes render the content after the head, when inline styles can no longer be added to it.
	echo '<style>' . $block_styles . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Every value is sanitized above.
} else {
	add_action(
		'wp_enqueue_scripts',
		function () use ( $block_styles ) {
			wp_add_inline_style( 'cozy-block--global-block-styles', $block_styles );
		}
	);
}

$icon_search = '<svg class="cozy-search-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>';
$icon_close  = '<svg class="cozy-search-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M6 6l12 12M18 6 6 18"/></svg>';

$list_id = $uid . '-list';

// The search form is a real GET form, so it works without JavaScript and "Enter" opens the full results page.
$render_form = static function () use ( $uid, $list_id, $placeholder, $label, $types, $icon_search, $icon_close, $mode ) {
	?>
	<form class="cozy-search-form-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<span class="cozy-search-search-symbol"><?php echo $icon_search; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static markup. ?></span>
		<label class="screen-reader-text" for="<?php echo esc_attr( $uid ); ?>-input"><?php echo esc_html( $label ); ?></label>
		<input id="<?php echo esc_attr( $uid ); ?>-input" class="cozy-search-input" type="search" name="s" value="" placeholder="<?php echo esc_attr( $placeholder ); ?>"
			role="combobox" aria-autocomplete="list" aria-expanded="false" aria-haspopup="listbox" aria-controls="<?php echo esc_attr( $list_id ); ?>"
			autocomplete="off" autocapitalize="off" spellcheck="false" enterkeyhint="search" inputmode="search">
		<?php foreach ( $types as $cozy_search_type ) : ?>
			<input type="hidden" name="post_type[]" value="<?php echo esc_attr( $cozy_search_type ); ?>">
		<?php endforeach; ?>
		<span class="cozy-search-spinner" aria-hidden="true"></span>
		<span class="cozy-search-voice-slot"></span>
		<?php if ( 'inline' !== $mode ) : ?>
			<button type="button" class="cozy-search-icon-btn cozy-search-close" aria-label="<?php esc_attr_e( 'Close search', 'cozy-addons' ); ?>"><?php echo $icon_close; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static markup. ?></button>
		<?php endif; ?>
	</form>
	<?php
};

$render_panel_body = static function () use ( $list_id ) {
	?>
	<div class="cozy-search-tabs" role="group" hidden></div>
	<div class="cozy-search-status" role="status" aria-live="polite"></div>
	<div class="cozy-search-body">
		<div class="cozy-search-notice"></div>
		<div class="cozy-search-suggestions"></div>
		<div class="cozy-search-results" id="<?php echo esc_attr( $list_id ); ?>" role="listbox" aria-label="<?php esc_attr_e( 'Search results', 'cozy-addons' ); ?>"></div>
		<div class="cozy-search-more"></div>
	</div>
	<div class="cozy-search-footer">
		<span class="cozy-search-hints" aria-hidden="true">
			<span><kbd class="cozy-search-kbd">↑</kbd><kbd class="cozy-search-kbd">↓</kbd> <?php esc_html_e( 'navigate', 'cozy-addons' ); ?></span>
			<span><kbd class="cozy-search-kbd">↵</kbd> <?php esc_html_e( 'open', 'cozy-addons' ); ?></span>
			<span><kbd class="cozy-search-kbd">esc</kbd> <?php esc_html_e( 'close', 'cozy-addons' ); ?></span>
		</span>
		<a class="cozy-search-viewall" href="#" hidden></a>
	</div>
	<?php
};

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'cozy-block-wrapper' ) );
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by core. ?>>
	<div
	<?php
	foreach ( $search_attributes as $attr_name => $attr_value ) {
		echo ' ' . esc_attr( $attr_name ) . '="' . esc_attr( $attr_value ) . '"';
	}
	?>
	>
		<?php if ( 'inline' === $mode ) : ?>
			<div class="cozy-search-inline-wrap">
				<?php $render_form(); ?>
				<div class="cozy-search-panel cozy-search-dropdown" hidden>
					<?php $render_panel_body(); ?>
				</div>
			</div>
		<?php else : ?>
			<?php if ( 'icon' === $mode || 'fullscreen' === $mode ) : ?>
				<button type="button" class="cozy-search-trigger cozy-search-icon-trigger" aria-haspopup="dialog" aria-expanded="false" aria-controls="<?php echo esc_attr( $uid ); ?>-modal" aria-label="<?php echo esc_attr( $label ); ?>">
					<?php echo $icon_search; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static markup. ?>
				</button>
			<?php else : ?>
				<button type="button" class="cozy-search-trigger cozy-search-form-trigger<?php echo $btn_icon ? ' cozy-search-btn-icon' : ''; ?>" aria-haspopup="dialog" aria-expanded="false" aria-controls="<?php echo esc_attr( $uid ); ?>-modal">
					<?php echo $icon_search; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static markup. ?>
					<span class="cozy-search-trigger-text"><?php echo esc_html( $placeholder ); ?></span>
					<?php if ( $shortcut ) : ?>
						<span class="cozy-search-kbd-group" aria-hidden="true"><kbd class="cozy-search-kbd cozy-search-kbd-mod">Ctrl</kbd><kbd class="cozy-search-kbd">K</kbd></span>
					<?php endif; ?>
					<?php if ( $btn_icon ) : ?>
						<span class="cozy-search-trigger-button cozy-search-trigger-button--icon"><?php echo $icon_search; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static markup. ?><span class="screen-reader-text"><?php echo esc_html( $button_text ); ?></span></span>
					<?php else : ?>
						<span class="cozy-search-trigger-button"><?php echo esc_html( $button_text ); ?></span>
					<?php endif; ?>
				</button>
			<?php endif; ?>
			<noscript>
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="<?php echo esc_attr( $uid ); ?>-ns"><?php echo esc_html( $label ); ?></label>
					<input id="<?php echo esc_attr( $uid ); ?>-ns" type="search" name="s" placeholder="<?php echo esc_attr( $placeholder ); ?>">
					<button type="submit"><?php echo esc_html( $button_text ); ?></button>
				</form>
			</noscript>
			<div class="cozy-search-modal" id="<?php echo esc_attr( $uid ); ?>-modal" hidden>
				<div class="cozy-search-backdrop"></div>
				<div class="cozy-search-panel cozy-search-dialog" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr( $label ); ?>">
					<div class="cozy-search-header"><?php $render_form(); ?></div>
					<?php $render_panel_body(); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
