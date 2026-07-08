<?php
if ( ! function_exists( 'cozy_block_update_post_terms_markup' ) ) {

	/**
	 * Update core/post-terms block frontend markup.
	 */
	function cozy_block_update_post_terms_markup( $block_content, $block ) {
		$post_terms_status = get_option( 'ca--utility--post-terms' );
		$item_styles       = $block['attrs']['cozyItemStyles'] ?? false;

		if ( ( '1' === $post_terms_status || '' == $post_terms_status ) && $item_styles ) {
			$processor = new \WP_HTML_Tag_Processor( $block_content );

			$padding         = isset( $item_styles['padding'] ) ? cozy_render_TRBL( 'padding', $item_styles['padding'] ) : '';
			$border          = isset( $item_styles['border'] ) ? cozy_render_TRBL( 'border', $item_styles['border'] ) : '';
			$gap             = isset( $item_styles['gap'] ) ? $item_styles['gap'] : '';
			$radius          = isset( $item_styles['radius'] ) ? $item_styles['radius'] : '';
			$alternate_color = $item_styles['alternateColor'] ?? false;
			$colors          = array(
				'primary'   => array(
					'text'       => isset( $item_styles['primaryColor']['text'] ) ? $item_styles['primaryColor']['text'] : '',
					'text_hover' => isset( $item_styles['primaryColor']['textHover'] ) ? $item_styles['primaryColor']['textHover'] : '',
					'bg'         => isset( $item_styles['primaryColor']['bg'] ) ? $item_styles['primaryColor']['bg'] : '',
					'bg_hover'   => isset( $item_styles['primaryColor']['bgHover'] ) ? $item_styles['primaryColor']['bgHover'] : '',
				),
				'secondary' => array(
					'text'       => isset( $item_styles['secondaryColor']['text'] ) ? $item_styles['secondaryColor']['text'] : '',
					'text_hover' => isset( $item_styles['secondaryColor']['textHover'] ) ? $item_styles['secondaryColor']['textHover'] : '',
					'bg'         => isset( $item_styles['secondaryColor']['bg'] ) ? $item_styles['secondaryColor']['bg'] : '',
					'bg_hover'   => isset( $item_styles['secondaryColor']['bgHover'] ) ? $item_styles['secondaryColor']['bgHover'] : '',
				),
			);

			$class_name = '.wp-block-post-terms';
			$text_align = isset( $block['attrs']['style']['typography']['textAlign'] ) ? $block['attrs']['style']['typography']['textAlign'] : 'left';

			if ( isset( $block['attrs']['className'] ) ) {
				$class_name .= '.' . str_replace( ' ', '.', $block['attrs']['className'] );
			}

			$wrapper_styles = "
			$class_name {
				display:flex;
				gap:{$gap};
				justify-content: {$text_align};
			}
			";

			$index = 0;
			while ( $processor->next_tag( 'a' ) ) {
				$is_even = ( 0 === $index % 2 );

				if ( $alternate_color && ! $is_even ) {
					$color    = $colors['secondary']['text'];
					$bg_color = $colors['secondary']['bg'];
				} else {
					$color    = $colors['primary']['text'];
					$bg_color = $colors['primary']['bg'];
				}

				$styles = cozy_addons_clean_empty_css(
					"color:{$color}; background-color:{$bg_color}; {$padding} {$border} border-radius:{$radius};"
				);

				$processor->set_attribute( 'style', $styles );
				++$index;
			}

			return "<style>$wrapper_styles</style>" . $processor->get_updated_html();
		}

		return $block_content;
	}
}
add_filter( 'render_block_core/post-terms', 'cozy_block_update_post_terms_markup', 10, 2 );
