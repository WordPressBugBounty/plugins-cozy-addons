<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only render inside an active Form block, so a disabled form never leaves loose inputs behind.
if ( ! ( $block instanceof WP_Block ) || ! array_key_exists( 'cozy-block/formId', $block->context ) ) {
	return;
}

$field    = cozy_addons_form_normalize_field( is_array( $attributes ) ? $attributes : array() );
$field_id = wp_unique_id( 'cozy-form-f-' );
$name     = 'cozy_addons_form_f[' . $field['n'] . ']';
$classes  = 'cozy-form__field cozy-form__field--' . $field['t'] . ( '50' === $field['w'] ? ' is-half' : '' );
$required = $field['r'] ? ' required aria-required="true"' : '';
$star     = $field['r'] ? ' <span class="cozy-form__required" aria-hidden="true">*</span>' : '';
$ph       = '' !== $field['p'] ? ' placeholder="' . esc_attr( $field['p'] ) . '"' : '';
$attrs    = ' id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $name ) . '"' . $required;
$label    = esc_html( $field['l'] );

// Advanced validation (Pro), mirrored in the browser. The server checks the same rules.
$rules     = $field['v'];
$maxlength = isset( $rules['maxl'] ) ? (int) $rules['maxl'] : ( 'textarea' === $field['t'] ? 5000 : 300 );
$checks    = isset( $rules['minl'] ) ? ' minlength="' . esc_attr( $rules['minl'] ) . '"' : '';
if ( isset( $rules['pat'] ) ) {
	$checks .= ' pattern="' . esc_attr( $rules['pat'] ) . '"';
}
if ( isset( $rules['min'] ) ) {
	$checks .= ' min="' . esc_attr( $rules['min'] ) . '"';
}
if ( isset( $rules['max'] ) ) {
	$checks .= ' max="' . esc_attr( $rules['max'] ) . '"';
}
if ( 'number' === $field['t'] ) {
	$checks .= ' step="any"';
}
if ( isset( $rules['msg'] ) ) {
	$checks .= ' data-message="' . esc_attr( $rules['msg'] ) . '"';
}

// Conditional logic (Pro): frontend/form.js shows and hides the field as visitors answer. It
// starts as it would look with nothing filled in, so it does not flash before the script runs.
$wrapper = ' class="' . esc_attr( $classes ) . '" data-name="' . esc_attr( $field['n'] ) . '"';
if ( ! empty( $field['c'] ) ) {
	$wrapper .= ' data-conditions="' . esc_attr( wp_json_encode( $field['c'] ) ) . '"';
	if ( cozy_addons_form_hidden_fields( array( $field ), array() ) ) {
		$wrapper .= ' hidden';
	}
}
$html = '<div' . $wrapper . '>';

if ( 'signature' === $field['t'] ) {
	// Drawn on the canvas by frontend/form.js, which keeps a PNG of it in the text input. The
	// input is visually hidden over the pad, so the browser's "required" message shows there.
	$pad_height = max( 100, min( 400, absint( isset( $attributes['padHeight'] ) ? $attributes['padHeight'] : 160 ) ) );
	if ( '' !== $field['l'] ) {
		$html .= '<span class="cozy-form__label" id="' . esc_attr( $field_id . '-label' ) . '">' . $label . $star . '</span>';
	}
	$html .= '<div class="cozy-form__signature">';
	$html .= '<canvas class="cozy-form__pad" role="img" data-height="' . esc_attr( (string) $pad_height ) . '" aria-label="' . esc_attr__( 'Signature pad. Draw your signature with a mouse, finger or pen.', 'cozy-addons' ) . '"></canvas>';
	$html .= '<input type="text" class="cozy-form__sig-value" id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $name ) . '" tabindex="-1" aria-hidden="true" autocomplete="off"' . $required . ' data-sign="' . esc_attr__( 'Please sign here.', 'cozy-addons' ) . '">';
	$html .= '</div>';
	$html .= '<button type="button" class="cozy-form__sig-clear">' . esc_html__( 'Clear', 'cozy-addons' ) . '</button>';
} elseif ( 'hidden' === $field['t'] ) {
	// Filled from the page by frontend/form.js when it takes a dynamic value, e.g. ?utm_source=.
	$default = sanitize_text_field( cozy_addons_form_plain( isset( $attributes['defaultValue'] ) ? $attributes['defaultValue'] : '' ) );
	$dynamic = isset( $attributes['dynamicValue'] ) && in_array( $attributes['dynamicValue'], array( 'page_url', 'page_title', 'referrer', 'query' ), true ) ? $attributes['dynamicValue'] : '';
	$html   .= '<input type="hidden" id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $default ) . '"';
	if ( '' !== $dynamic ) {
		$html .= ' data-dynamic="' . esc_attr( $dynamic ) . '"';
		if ( 'query' === $dynamic ) {
			$html .= ' data-param="' . esc_attr( sanitize_key( isset( $attributes['queryParam'] ) ? (string) $attributes['queryParam'] : '' ) ) . '"';
		}
	}
	$html .= '>';
} elseif ( 'checkboxes' === $field['t'] ) {
	// Browsers cannot require "at least one" of a group, so frontend/form.js checks data-required.
	$html .= '<fieldset class="cozy-form__choices"' . ( $field['r'] ? ' data-required="true"' : '' ) . '>';
	if ( '' !== $field['l'] ) {
		$html .= '<legend class="cozy-form__label">' . $label . $star . '</legend>';
	}
	foreach ( $field['o'] as $index => $option ) {
		$html .= '<label class="cozy-form__choice" for="' . esc_attr( $field_id . '-' . $index ) . '"><input type="checkbox" id="' . esc_attr( $field_id . '-' . $index ) . '" name="' . esc_attr( $name . '[]' ) . '" value="' . esc_attr( $option ) . '"> <span>' . esc_html( $option ) . '</span></label>';
	}
	$html .= '</fieldset>';
} elseif ( 'radio' === $field['t'] ) {
	$html .= '<fieldset class="cozy-form__choices">';
	if ( '' !== $field['l'] ) {
		$html .= '<legend class="cozy-form__label">' . $label . $star . '</legend>';
	}
	foreach ( $field['o'] as $index => $option ) {
		$html .= '<label class="cozy-form__choice" for="' . esc_attr( $field_id . '-' . $index ) . '"><input type="radio" id="' . esc_attr( $field_id . '-' . $index ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $option ) . '"' . ( 0 === $index ? $required : '' ) . '> <span>' . esc_html( $option ) . '</span></label>';
	}
	$html .= '</fieldset>';
} elseif ( 'checkbox' === $field['t'] ) {
	// With its own text, the label becomes a heading above the box, e.g. "Marketing consent".
	$box_text = cozy_addons_form_plain( isset( $attributes['checkboxText'] ) ? $attributes['checkboxText'] : '' );
	if ( '' !== $box_text ) {
		$html .= '<fieldset class="cozy-form__choices">';
		if ( '' !== $field['l'] ) {
			$html .= '<legend class="cozy-form__label">' . $label . $star . '</legend>';
		}
		$html .= '<label class="cozy-form__check" for="' . esc_attr( $field_id ) . '"><input type="checkbox" value="1"' . $attrs . '> <span>' . esc_html( $box_text ) . '</span></label>';
		$html .= '</fieldset>';
	} else {
		$html .= '<label class="cozy-form__check" for="' . esc_attr( $field_id ) . '"><input type="checkbox" value="1"' . $attrs . '> <span>' . $label . $star . '</span></label>';
	}
} else {
	if ( '' !== $field['l'] ) {
		$html .= '<label class="cozy-form__label" for="' . esc_attr( $field_id ) . '">' . $label . $star . '</label>';
	}
	if ( 'textarea' === $field['t'] ) {
		$html .= '<textarea class="cozy-form__input" rows="4" maxlength="' . esc_attr( $maxlength ) . '"' . $attrs . $ph . $checks . '></textarea>';
	} elseif ( 'select' === $field['t'] ) {
		$html .= '<select class="cozy-form__input"' . $attrs . '>';
		$html .= '<option value="">' . esc_html( '' !== $field['p'] ? $field['p'] : __( 'Select…', 'cozy-addons' ) ) . '</option>';
		foreach ( $field['o'] as $option ) {
			$html .= '<option value="' . esc_attr( $option ) . '">' . esc_html( $option ) . '</option>';
		}
		$html .= '</select>';
	} else {
		if ( 'file' === $field['t'] || 'image' === $field['t'] ) {
			// Only file types the server accepts, and its limits for early messages in the browser.
			$multi = ! empty( $field['mf'] );
			$html .= '<input class="cozy-form__input" type="file" id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $name . ( $multi ? '[]' : '' ) ) . '"' . $required
				. ' accept="' . esc_attr( \CozyAddons\Core\Forms\Form_Uploads::accept( 'image' === $field['t'] ) ) . '"'
				. ' data-max-size="' . esc_attr( (string) ( $field['mx'] * MB_IN_BYTES ) ) . '"'
				. ( $multi ? ' multiple data-max-files="' . esc_attr( (string) $field['mf'] ) . '"' : '' ) . '>';
			if ( 'image' === $field['t'] ) {
				$html .= '<div class="cozy-form__previews" aria-live="polite"></div>';
			}
		} else {
			$autocomplete = '';
			if ( in_array( $field['t'], array( 'email', 'tel', 'url' ), true ) ) {
				$autocomplete = ' autocomplete="' . esc_attr( $field['t'] ) . '"';
			}
			$input_type = 'datetime' === $field['t'] ? 'datetime-local' : $field['t'];
			$html      .= '<input class="cozy-form__input" type="' . esc_attr( $input_type ) . '" maxlength="' . esc_attr( 'url' === $field['t'] ? 500 : $maxlength ) . '"' . $attrs . $ph . $autocomplete . $checks . '>';
		}
	}
}

$html .= '</div>';

$common = array(
	'id'             => true,
	'name'           => true,
	'class'          => true,
	'required'       => true,
	'aria-required'  => true,
	'placeholder'    => true,
	'autocomplete'   => true,
	'maxlength'      => true,
	'minlength'      => true,
	'pattern'        => true,
	'min'            => true,
	'max'            => true,
	'step'           => true,
	'data-message'   => true,
	'accept'         => true,
	'data-max-size'  => true,
	'multiple'       => true,
	'data-max-files' => true,
	'tabindex'       => true,
	'aria-hidden'    => true,
	'data-sign'      => true,
);

echo wp_kses(
	$html,
	array(
		'div'      => array(
			'class'           => true,
			'aria-live'       => true,
			'data-name'       => true,
			'data-conditions' => true,
			'hidden'          => true,
		),
		'fieldset' => array(
			'class'         => true,
			'data-required' => true,
		),
		'legend'   => array( 'class' => true ),
		'span'     => array(
			'class'       => true,
			'id'          => true,
			'aria-hidden' => true,
		),
		'canvas'   => array(
			'class'       => true,
			'role'        => true,
			'aria-label'  => true,
			'data-height' => true,
		),
		'button'   => array(
			'type'  => true,
			'class' => true,
		),
		'label'    => array(
			'class' => true,
			'for'   => true,
		),
		'input'    => $common + array(
			'type'         => true,
			'value'        => true,
			'data-dynamic' => true,
			'data-param'   => true,
		),
		'textarea' => $common + array( 'rows' => true ),
		'select'   => $common,
		'option'   => array( 'value' => true ),
	)
);
