<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$step_title = cozy_addons_form_plain( isset( $attributes['title'] ) ? $attributes['title'] : '' );

echo '<fieldset class="cozy-form__step" data-title="' . esc_attr( $step_title ) . '">';
if ( '' !== $step_title ) {
	echo '<legend class="cozy-form__step-title">' . esc_html( $step_title ) . '</legend>';
}
echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered inner blocks, escaped by their own renderers.
echo '</fieldset>';
