<?php
/**
 * Ready-made form patterns.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the "Cozy Forms" pattern category and its patterns.
 */
final class Form_Patterns {

	/**
	 * Registers hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register' ), 20 );
	}

	/**
	 * Markup for a list of Form Field blocks.
	 *
	 * @param array[] $fields Field attribute arrays.
	 * @return string
	 */
	private static function fields_markup( array $fields ) {
		$out = '';
		foreach ( $fields as $field ) {
			$out .= '<!-- wp:cozy-block/form-field ' . wp_json_encode( $field ) . ' /-->' . "\n";
		}

		return $out;
	}

	/**
	 * Markup for a Form block holding the given inner markup.
	 *
	 * @param array  $attrs Form block attributes.
	 * @param string $inner Inner block markup.
	 * @return string
	 */
	private static function form_markup( array $attrs, $inner ) {
		return '<!-- wp:cozy-block/form ' . wp_json_encode( $attrs ) . ' -->' . "\n" . $inner . '<!-- /wp:cozy-block/form -->';
	}

	/**
	 * Consent checkbox used by several patterns.
	 *
	 * @return array
	 */
	private static function consent_field() {
		return array(
			'label'     => __( 'I agree to be contacted about my enquiry.', 'cozy-addons' ),
			'fieldType' => 'checkbox',
			'required'  => true,
			'name'      => 'f_consent',
		);
	}

	/**
	 * Contact form markup.
	 *
	 * @return string
	 */
	private static function contact_markup() {
		$fields = array(
			array(
				'label'       => __( 'Full Name', 'cozy-addons' ),
				'fieldType'   => 'text',
				'required'    => true,
				'name'        => 'f_name',
				'placeholder' => __( 'Jane Doe', 'cozy-addons' ),
			),
			array(
				'label'       => __( 'Email Address', 'cozy-addons' ),
				'fieldType'   => 'email',
				'required'    => true,
				'name'        => 'f_email',
				'placeholder' => __( 'jane@example.com', 'cozy-addons' ),
			),
			array(
				'label'       => __( 'Phone Number', 'cozy-addons' ),
				'fieldType'   => 'tel',
				'name'        => 'f_phone',
				'placeholder' => __( '(555) 019-2834', 'cozy-addons' ),
			),
			array(
				'label'       => __( 'Message', 'cozy-addons' ),
				'fieldType'   => 'textarea',
				'required'    => true,
				'name'        => 'f_message',
				'placeholder' => __( 'How can we help you today? Tell us about your enquiry...', 'cozy-addons' ),
			),
			self::consent_field(),
		);

		return self::form_markup(
			array(
				'formType'   => 'contact',
				'formName'   => __( 'Contact form', 'cozy-addons' ),
				'buttonText' => __( 'Send message', 'cozy-addons' ),
			),
			self::fields_markup( $fields )
		);
	}

	/**
	 * Quote request markup.
	 *
	 * @return string
	 */
	private static function quote_markup() {
		$fields = array(
			array(
				'label'       => __( 'Full name', 'cozy-addons' ),
				'fieldType'   => 'text',
				'placeholder' => __( 'Jane Doe', 'cozy-addons' ),
				'required'    => true,
				'name'        => 'f_name',
				'width'       => '50',
			),
			array(
				'label'       => __( 'Phone', 'cozy-addons' ),
				'fieldType'   => 'tel',
				'placeholder' => __( '(555) 019-2834', 'cozy-addons' ),
				'required'    => true,
				'name'        => 'f_phone',
				'width'       => '50',
			),
			array(
				'label'       => __( 'Email', 'cozy-addons' ),
				'fieldType'   => 'email',
				'placeholder' => __( 'jane@example.com', 'cozy-addons' ),
				'required'    => true,
				'name'        => 'f_email',
			),
			array(
				'label'       => __( 'Service needed', 'cozy-addons' ),
				'fieldType'   => 'select',
				'options'     => implode( "\n", array( __( 'Repair', 'cozy-addons' ), __( 'Installation', 'cozy-addons' ), __( 'Maintenance', 'cozy-addons' ), __( 'Other', 'cozy-addons' ) ) ),
				'placeholder' => __( 'Select a service', 'cozy-addons' ),
				'required'    => true,
				'name'        => 'f_service',
				'width'       => '50',
			),
			array(
				'label'     => __( 'Preferred date', 'cozy-addons' ),
				'fieldType' => 'date',
				'name'      => 'f_date',
				'width'     => '50',
			),
			array(
				'label'       => __( 'Tell us about the job', 'cozy-addons' ),
				'fieldType'   => 'textarea',
				'placeholder' => __( 'Describe the work, its size and any deadlines...', 'cozy-addons' ),
				'name'        => 'f_message',
			),
			self::consent_field(),
		);

		return self::form_markup(
			array(
				'formType'   => 'quote',
				'formName'   => __( 'Quote request', 'cozy-addons' ),
				'buttonText' => __( 'Get my free quote', 'cozy-addons' ),
			),
			self::fields_markup( $fields )
		);
	}

	/**
	 * Quick call-back markup.
	 *
	 * @return string
	 */
	private static function callback_markup() {
		$fields = array(
			array(
				'label'       => __( 'Name', 'cozy-addons' ),
				'fieldType'   => 'text',
				'placeholder' => __( 'Jane Doe', 'cozy-addons' ),
				'required'    => true,
				'name'        => 'f_name',
				'width'       => '50',
			),
			array(
				'label'       => __( 'Phone', 'cozy-addons' ),
				'fieldType'   => 'tel',
				'placeholder' => __( '(555) 019-2834', 'cozy-addons' ),
				'required'    => true,
				'name'        => 'f_phone',
				'width'       => '50',
			),
			array(
				'label'       => __( 'How can we help?', 'cozy-addons' ),
				'fieldType'   => 'textarea',
				'placeholder' => __( 'Tell us briefly what you need...', 'cozy-addons' ),
				'name'        => 'f_message',
			),
		);

		return self::form_markup(
			array(
				'formType'   => 'contact',
				'formName'   => __( 'Call-back request', 'cozy-addons' ),
				'buttonText' => __( 'Call me back', 'cozy-addons' ),
			),
			self::fields_markup( $fields )
		);
	}

	/**
	 * Newsletter form markup: an inline email field and a Subscribe button.
	 *
	 * Also used by the Popup Builder layouts in core/library/patterns/modal-block-*.php.
	 *
	 * @return string Empty while the Form block is disabled.
	 */
	public static function newsletter_form_markup() {
		if ( '0' === get_option( 'cozy-block--form' ) ) {
			return '';
		}

		return self::form_markup(
			array(
				'formType'       => 'newsletter',
				'formName'       => __( 'Newsletter', 'cozy-addons' ),
				'buttonText'     => __( 'Subscribe', 'cozy-addons' ),
				'successMessage' => __( 'Thanks for subscribing!', 'cozy-addons' ),
				'notify'         => false,
				'layoutStyle'    => 'inline',
				'hideLabels'     => true,
			),
			self::fields_markup(
				array(
					array(
						'label'       => __( 'Email', 'cozy-addons' ),
						'fieldType'   => 'email',
						'placeholder' => __( 'Your email address', 'cozy-addons' ),
						'required'    => true,
						'name'        => 'f_email',
					),
				)
			)
		);
	}

	/**
	 * Newsletter sign-up section: heading, short text and an inline email form.
	 *
	 * @return string
	 */
	private static function newsletter_markup() {
		$form = self::newsletter_form_markup();

		return '<!-- wp:group {"layout":{"type":"constrained","contentSize":"640px"}} -->' . "\n"
			. '<div class="wp-block-group">'
			. '<!-- wp:heading {"textAlign":"center"} --><h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Get our latest news', 'cozy-addons' ) . '</h2><!-- /wp:heading -->'
			. '<!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">' . esc_html__( 'Tips, offers and updates in your inbox. Unsubscribe at any time.', 'cozy-addons' ) . '</p><!-- /wp:paragraph -->'
			. $form
			. '</div>' . "\n"
			. '<!-- /wp:group -->';
	}

	/**
	 * Multi-step quote request markup (Pro).
	 *
	 * @return string
	 */
	private static function steps_markup() {
		$one   = array(
			array(
				'label'       => __( 'Service needed', 'cozy-addons' ),
				'fieldType'   => 'select',
				'options'     => implode( "\n", array( __( 'Repair', 'cozy-addons' ), __( 'Installation', 'cozy-addons' ), __( 'Maintenance', 'cozy-addons' ), __( 'Other', 'cozy-addons' ) ) ),
				'placeholder' => __( 'Select a service', 'cozy-addons' ),
				'required'    => true,
				'name'        => 'f_service',
			),
			array(
				'label'     => __( 'How soon do you need this?', 'cozy-addons' ),
				'fieldType' => 'radio',
				'options'   => implode( "\n", array( __( 'Today', 'cozy-addons' ), __( 'Within a few days', 'cozy-addons' ), __( 'This week or next', 'cozy-addons' ), __( 'Just getting quotes', 'cozy-addons' ) ) ),
				'required'  => true,
				'name'      => 'f_urgency',
			),
		);
		$two   = array(
			array(
				'label'       => __( 'Tell us about the job', 'cozy-addons' ),
				'fieldType'   => 'textarea',
				'placeholder' => __( 'Describe the work, its size and any deadlines...', 'cozy-addons' ),
				'name'        => 'f_message',
			),
			array(
				'label'     => __( 'Preferred date', 'cozy-addons' ),
				'fieldType' => 'date',
				'name'      => 'f_date',
				'width'     => '50',
			),
		);
		$three = array(
			array(
				'label'       => __( 'Full name', 'cozy-addons' ),
				'fieldType'   => 'text',
				'placeholder' => __( 'Jane Doe', 'cozy-addons' ),
				'required'    => true,
				'name'        => 'f_name',
				'width'       => '50',
			),
			array(
				'label'       => __( 'Phone', 'cozy-addons' ),
				'fieldType'   => 'tel',
				'placeholder' => __( '(555) 019-2834', 'cozy-addons' ),
				'required'    => true,
				'name'        => 'f_phone',
				'width'       => '50',
			),
			array(
				'label'       => __( 'Email', 'cozy-addons' ),
				'fieldType'   => 'email',
				'placeholder' => __( 'jane@example.com', 'cozy-addons' ),
				'name'        => 'f_email',
			),
			self::consent_field(),
		);

		$step = static function ( $title, array $fields ) {
			return '<!-- wp:cozy-block/form-step ' . wp_json_encode( array( 'title' => $title ) ) . ' -->' . "\n" . self::fields_markup( $fields ) . '<!-- /wp:cozy-block/form-step -->' . "\n";
		};

		return self::form_markup(
			array(
				'formType'      => 'quote',
				'formName'      => __( 'Quote request (multi-step)', 'cozy-addons' ),
				'buttonText'    => __( 'Send my request', 'cozy-addons' ),
				'progressStyle' => 'numbers',
			),
			$step( __( 'The service', 'cozy-addons' ), $one ) . $step( __( 'The job', 'cozy-addons' ), $two ) . $step( __( 'Your details', 'cozy-addons' ), $three )
		);
	}

	/**
	 * Registers the pattern category and patterns while the Form block is enabled.
	 *
	 * @return void
	 */
	public static function register() {
		if ( ! function_exists( 'register_block_pattern' ) || '0' === get_option( 'cozy-block--form' ) ) {
			return;
		}

		register_block_pattern_category( 'cozy-forms', array( 'label' => __( 'Cozy Forms', 'cozy-addons' ) ) );

		$patterns = array(
			'cozy-addons/form-contact'    => array(
				'title'    => __( 'Contact form', 'cozy-addons' ),
				'keywords' => array( 'contact', 'form', 'message', 'email' ),
				'content'  => self::contact_markup(),
			),
			'cozy-addons/form-quote'      => array(
				'title'    => __( 'Quote request form', 'cozy-addons' ),
				'keywords' => array( 'quote', 'lead', 'enquiry', 'form' ),
				'content'  => self::quote_markup(),
			),
			'cozy-addons/form-callback'   => array(
				'title'    => __( 'Call-back request form', 'cozy-addons' ),
				'keywords' => array( 'callback', 'phone', 'enquiry', 'form' ),
				'content'  => self::callback_markup(),
			),
			'cozy-addons/form-newsletter' => array(
				'title'    => __( 'Newsletter sign-up', 'cozy-addons' ),
				'keywords' => array( 'newsletter', 'subscribe', 'email', 'signup' ),
				'content'  => self::newsletter_markup(),
			),
		);

		if ( cozy_addons_premium_access() ) {
			$patterns['cozy-addons/form-quote-steps'] = array(
				'title'    => __( 'Quote request form (multi-step)', 'cozy-addons' ),
				'keywords' => array( 'quote', 'multi-step', 'wizard', 'form' ),
				'content'  => self::steps_markup(),
			);
		}

		foreach ( $patterns as $name => $pattern ) {
			$pattern['categories'] = array( 'cozy-forms' );
			register_block_pattern( $name, $pattern );
		}
	}
}
