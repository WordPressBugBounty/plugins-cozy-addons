<?php

use CozyBlock\Icons\CozyIcons;

$client_id = ! empty( $attributes['blockClientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', wp_strip_all_tags( sanitize_key( $attributes['blockClientId'] ) ) ) : '';

$block_id = 'cozyBlock_' . str_replace( '-', '_', $client_id );

$container_color = array(
	'text'       => isset( $attributes['typography']['color'] ) ? $attributes['typography']['color'] : '',
	'text_hover' => isset( $attributes['typography']['colorHover'] ) ? $attributes['typography']['colorHover'] : '',
);

$icon_color = array(
	'bg_hover' => isset( $attributes['boxStyles']['bgColorHover'] ) ? $attributes['boxStyles']['bgColorHover'] : '',
	'default'  => isset( $attributes['iconColor'] ) ? $attributes['iconColor'] : '',
	'hover'    => isset( $attributes['iconColorHover'] ) ? $attributes['iconColorHover'] : '',
);

$block_styles = "
    #{$block_id}.horizontal ul li .inline-block{
        margin-right: {$attributes['iconGap']}px;
    }
    #{$block_id}.vertical.left ul {
        left: {$attributes['iconDisplay']['left']}px;
    }
    #{$block_id}.vertical.right ul {
        right: {$attributes['iconDisplay']['right']}px;
    }
    #{$block_id} ul li .inline-block {
        padding: {$attributes['boxStyles']['padding']['top']}px {$attributes['boxStyles']['padding']['right']}px {$attributes['boxStyles']['padding']['bottom']}px {$attributes['boxStyles']['padding']['left']}px;
        border: {$attributes['boxStyles']['borderWidth']}px {$attributes['boxStyles']['borderType']} {$attributes['boxStyles']['borderColor']};
        border-radius: {$attributes['boxStyles']['borderRadius']}px;
        background-color: {$attributes['boxStyles']['bgColor']};
        font: {$attributes['typography']['fontWeight']} {$attributes['typography']['fontSize']}px {$attributes['typography']['fontFamily']};
        color: {$container_color['text']};
    }
	#{$block_id} ul li .inline-block p:before {
		background-color: {$container_color['text']};
	}
    #{$block_id} ul li .inline-block:hover {
        background-color: {$icon_color['bg_hover']};
        color: {$container_color['text_hover']};
    }
	#{$block_id} ul li .inline-block:hover p:before {
		background-color: {$container_color['text_hover']};
	}
    #{$block_id} ul li svg path {
        fill: {$icon_color['default']} !important;
    }
    #{$block_id} ul li:hover svg path {
        fill: {$icon_color['hover']} !important;
    }
";

$social_icons = CozyIcons::get_cozy_social_icon_collection();
$permalink    = get_permalink();

$classes   = array();
$classes[] = 'cozy-block-social-share';
$classes[] = $attributes['iconDisplay']['orientation'];
$classes[] = $attributes['iconDisplay']['alignment'];
?>

<div class="cozy-block-wrapper">

	<?php
	add_action(
		'wp_enqueue_scripts',
		function () use ( $block_styles ) {
			wp_add_inline_style( 'cozy-block--social-share--style', esc_html( $block_styles ) );
		}
	);
	?>

	<div class="<?php echo esc_html( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" id="<?php echo esc_html( $block_id ); ?>">
		<ul>
			<?php
			foreach ( $attributes['selectedSocialList'] as $social ) {
				$value = $social['value'];

				$icon_styles = "
                    .{$block_id}.{$value} {
                        background-color: {$social['bgColor']} !important;
                    }
                    .{$block_id}.{$value}:hover {
                        background-color: {$social['bgColorHover']} !important;
                    }
                    #{$block_id} .{$block_id}.{$value} svg path{
                        fill: {$social['iconColor']} !important;
                    }
                    #{$block_id} .{$block_id}.{$value} svg:hover path{
                        fill: {$social['iconColorHover']} !important;
                    }
                    .{$block_id}.{$value} svg {
                        width: {$attributes['iconSize']}px !important;
                        height: {$attributes['iconSize']}px !important;
                    }
                ";

				$share_url  = $social['shareUrl'];
				$page_title = the_title( '', '', '', false );

				if ( 'whatsapp' === $social['value'] ) {
					$share_url .= $page_title . ' ' . $permalink;
				} elseif ( 'twitter' === $social['value'] ) {
					$share_url .= $page_title . '?url=' . $permalink;
				} elseif ( 'telegram' === $social['value'] ) {
					$share_url .= $page_title . '?url=' . $permalink;
				} elseif ( 'reddit' === $social['value'] ) {
					$share_url .= $page_title . '?url=' . $permalink;
				} elseif ( 'linkedin' === $social['value'] ) {
					$share_url .= $page_title . '?url=' . $permalink . '&mini=true';
				} elseif ( 'email' === $social['value'] ) {
					$share_url .= $page_title . '?body=' . $permalink;
				} else {
					$share_url .= $permalink;
				}

				if ( isset( $social['enabled'] ) && filter_var( $social['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
					?>
					<style>
						<?php echo esc_html( $icon_styles ); ?>
					</style>
					<a href="<?php echo esc_url( $share_url ); ?>" target="_blank">
						<li class="<?php echo esc_attr( sanitize_html_class( $value ) ) . ' ' . esc_attr( sanitize_html_class( $block_id ) ); ?>">
							<div class="inline-block">
								<div class="flex">
									<i>
										<?php
										echo $social_icons[ $value ]['logo'];
										?>
									</i>
									<?php
									if ( true === $attributes['enableLabel'] && 'horizontal' === $attributes['iconDisplay']['orientation'] ) {
										echo '<p>' . esc_html( $social['label'] ) . '</p>';
									}
									?>
								</div>
							</div>
						</li>
					</a>
					<?php
				}
			}
			?>
		</ul>
	</div>
</div>