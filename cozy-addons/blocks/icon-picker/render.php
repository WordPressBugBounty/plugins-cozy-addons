<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id          = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';
$block_id           = 'cozyBlock_' . str_replace( '-', '_', $client_id );
$box_bg_color       = isset( $attributes['boxStyles']['bgColor'] ) ? esc_attr( $attributes['boxStyles']['bgColor'] ) : '';
$box_bg_color_hover = isset( $attributes['boxStyles']['bgColorHover'] ) ? esc_attr( $attributes['boxStyles']['bgColorHover'] ) : '';

$wrapper_styles = array(
	'align' => isset( $attributes['align'] ) ? esc_attr( sanitize_text_field( $attributes['align'] ) ) : 'center',
);

$margin = array(
	'top'    => isset( $attributes['margin']['top'] ) ? esc_attr( $attributes['margin']['top'] ) : '',
	'right'  => isset( $attributes['margin']['right'] ) ? esc_attr( $attributes['margin']['right'] ) : '',
	'bottom' => isset( $attributes['margin']['bottom'] ) ? esc_attr( $attributes['margin']['bottom'] ) : '',
	'left'   => isset( $attributes['margin']['left'] ) ? esc_attr( $attributes['margin']['left'] ) : '',
);

$icon_styles = array(
	'padding' => array(
		'top'    => isset( $attributes['boxStyles']['padding']['top'] ) ? esc_attr( $attributes['boxStyles']['padding']['top'] ) : '',
		'right'  => isset( $attributes['boxStyles']['padding']['right'] ) ? esc_attr( $attributes['boxStyles']['padding']['right'] ) : '',
		'bottom' => isset( $attributes['boxStyles']['padding']['bottom'] ) ? esc_attr( $attributes['boxStyles']['padding']['bottom'] ) : '',
		'left'   => isset( $attributes['boxStyles']['padding']['left'] ) ? esc_attr( $attributes['boxStyles']['padding']['left'] ) : '',
	),
	'border'  => array(
		'width' => isset( $attributes['boxStyles']['borderWidth'] ) ? esc_attr( $attributes['boxStyles']['borderWidth'] ) : '',
		'style' => isset( $attributes['boxStyles']['borderType'] ) ? esc_attr( sanitize_text_field( $attributes['boxStyles']['borderType'] ) ) : '',
	),
	'radius'  => isset( $attributes['boxStyles']['borderRadius'] ) ? esc_attr( $attributes['boxStyles']['borderRadius'] ) : '',
	'size'    => isset( $attributes['iconSize'] ) ? esc_attr( $attributes['iconSize'] ) : '',
	'rotate'  => isset( $attributes['iconRotate'] ) ? esc_attr( $attributes['iconRotate'] ) : '',
);
$icon_color  = array(
	'border'       => isset( $attributes['boxStyles']['borderColor'] ) ? esc_attr( $attributes['boxStyles']['borderColor'] ) : '',
	'border_hover' => isset( $attributes['boxStyles']['borderColorHover'] ) ? esc_attr( $attributes['boxStyles']['borderColorHover'] ) : '',
	'hover'        => isset( $attributes['iconColorHover'] ) ? esc_attr( $attributes['iconColorHover'] ) : '',
);

$stroke_hover_color = 'outline' === $attributes['layout'] ? esc_attr( $icon_color['hover'] ) : '';

$block_styles = "
.cozy-block-icon-wrapper {
	justify-content: {$wrapper_styles['align']};
}
	
#$block_id {
    margin-top: {$margin['top']}px;
    margin-right: {$margin['right']}px;
    margin-bottom: {$margin['bottom']}px;
    margin-left: {$margin['left']}px;
}

#$block_id.stacked {
    padding-top: {$icon_styles['padding']['top']}px;
    padding-right: {$icon_styles['padding']['right']}px;
    padding-bottom: {$icon_styles['padding']['bottom']}px;
    padding-left: {$icon_styles['padding']['left']}px;
    border-width: {$icon_styles['border']['width']}px;
    border-style: {$icon_styles['border']['style']};
	border-color:{$icon_color['border']};
    border-radius: {$icon_styles['radius']}px;
    background-color: {$box_bg_color};
    width: {$icon_styles['size']}px;
    height: {$icon_styles['size']}px;
}

#$block_id svg {
    transform: rotate({$icon_styles['rotate']}deg);
}

#$block_id.stacked:hover {
    background-color: {$box_bg_color_hover};
    border-color: {$icon_color['border_hover']};
}

#$block_id:hover svg {
    fill: {$icon_color['hover']};
}
#$block_id:hover svg {
    stroke: {$stroke_hover_color};
}
";

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--global-block-styles', cozy_addons_clean_empty_css( $block_styles ) );
	}
);

$wrapper_attributes = get_block_wrapper_attributes();

?>

<div class="cozy-block-wrapper cozy-block-icon-wrapper">
	<div <?php echo $wrapper_attributes; ?>>
		<?php
		if ( isset( $attributes['link']['enabled'], $attributes['link']['url'] ) && $attributes['link']['enabled'] && ! empty( $attributes['link']['url'] ) ) {
			$new_tab  = isset( $attributes['link']['newTab'] ) && $attributes['link']['newTab'] ? '_blank' : '';
			$nofollow = isset( $attributes['link']['noFollow'] ) && $attributes['link']['noFollow'] ? 'nofollow' : '';
			?>
			<a href="<?php echo esc_url( $attributes['link']['url'] ); ?>" target="<?php echo esc_attr( $new_tab ); ?>" rel="<?php echo esc_attr( $nofollow ); ?>">
			<?php
		}

		echo $content;

		if ( isset( $attributes['link']['enabled'], $attributes['link']['url'] ) && $attributes['link']['enabled'] && ! empty( $attributes['link']['url'] ) ) {
			?>
			</a>
			<?php
		}
		?>
	</div>
</div>