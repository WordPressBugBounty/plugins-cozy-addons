<?php
namespace CozyAddons\Core\Api;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_REST_Request;
use WP_REST_Response;
use CozyAddons\Core\Forms\Entry_Post_Type;
use CozyAddons\Core\Forms\Form_WooCommerce;
use CozyAddons\Core\Forms\Form_Turnstile;
use CozyAddons\Core\Forms\Form_Recaptcha;
use CozyAddons\Core\Forms\Form_Akismet;
use CozyAddons\Core\Forms\Form_Uploads;

/**
 * Public endpoint that receives Form block submissions, validates them, stores an entry and sends the emails.
 */
class Form {
	/**
	 * Holds the singleton instance of the Form class.
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * Retrieves the singleton instance of the Form class.
	 *
	 * @return self
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor. Registers the REST route.
	 */
	private function __construct() {
		$this->register_routes();
	}

	/**
	 * Registers the submit route.
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			'cozy-block/v1',
			'/form-submit',
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'handle' ),
				'permission_callback' => array( $this, 'public_endpoint' ),
			)
		);
	}

	/**
	 * Permission check for the public form endpoint.
	 *
	 * Visitors must be able to submit without logging in, and forms are often served from a page
	 * cache, so a REST nonce would expire and block real people. Do not add one. Abuse is limited
	 * instead by the signed form config, a honeypot, a minimum fill time and per-visitor rate limiting.
	 *
	 * @return bool Always true.
	 */
	public function public_endpoint() {
		return true;
	}

	/**
	 * Builds an error response.
	 *
	 * @param string $message Message for the visitor.
	 * @param int    $status  HTTP status.
	 * @param array  $errors  Field errors keyed by field name.
	 * @return WP_REST_Response
	 */
	private function fail( $message, $status = 400, array $errors = array() ) {
		return new WP_REST_Response(
			array(
				'ok'      => false,
				'message' => $message,
				'errors'  => $errors,
			),
			$status
		);
	}

	/**
	 * Builds a success response. Also used to quietly drop spam.
	 *
	 * @param array $config Form config.
	 * @return WP_REST_Response
	 */
	private function succeed( array $config ) {
		$download = $this->download( $config );

		return new WP_REST_Response(
			array(
				'ok'       => true,
				'message'  => sanitize_text_field( isset( $config['ok'] ) ? $config['ok'] : '' ),
				'redirect' => ! empty( $config['go'] ) ? esc_url_raw( $config['go'] ) : '',
				'download' => $download ? $download : null,
			),
			200
		);
	}

	/**
	 * File offered after a submission (Pro). Sealed in the config so it is not in the page source.
	 *
	 * @param array $config Form config.
	 * @return array{url:string,label:string}|array Empty when the form has none.
	 */
	private function download( array $config ) {
		$data = json_decode( cozy_addons_form_unseal( isset( $config['dl'] ) ? $config['dl'] : '' ), true );
		$url  = is_array( $data ) && isset( $data['u'] ) ? esc_url_raw( (string) $data['u'], array( 'http', 'https' ) ) : '';
		if ( '' === $url ) {
			return array();
		}
		$label = isset( $data['l'] ) ? sanitize_text_field( (string) $data['l'] ) : '';

		return array(
			'url'   => $url,
			'label' => '' !== $label ? $label : __( 'Download', 'cozy-addons' ),
		);
	}

	/**
	 * Handles a form submission.
	 *
	 * @param WP_REST_Request $req Request.
	 * @return WP_REST_Response
	 */
	public function handle( WP_REST_Request $req ) {
		// 1. Verify the signed form config.
		$config = cozy_addons_form_verify( $req->get_param( 'cozy_addons_form_config' ), $req->get_param( 'cozy_addons_form_sig' ) );
		if ( null === $config ) {
			return $this->fail( __( 'This form has expired. Please refresh the page and try again.', 'cozy-addons' ) );
		}
		if ( empty( $config['fields'] ) || ! is_array( $config['fields'] ) || count( $config['fields'] ) > 40 ) {
			return $this->fail( __( 'This form is not configured correctly.', 'cozy-addons' ) );
		}

		// 2. Honeypot: pretend success so bots move on.
		if ( '' !== (string) $req->get_param( 'cozy_addons_form_hp' ) ) {
			return $this->succeed( $config );
		}

		// 3. Minimum fill time, measured in the browser so clock skew cannot cause false positives.
		if ( (int) $req->get_param( 'cozy_addons_form_el' ) < 1500 ) {
			return $this->fail( __( 'Please review your details and submit again.', 'cozy-addons' ), 429 );
		}

		// 4. Per-visitor rate limit. The IP is only hashed into a short-lived counter.
		$rate_key = 'ca_form_rl_' . md5( cozy_addons_form_client_ip() . wp_salt( 'nonce' ) );
		$count    = (int) get_transient( $rate_key );
		/**
		 * Filters how many form submissions one visitor may send per 10 minutes.
		 *
		 * @param int $limit Submissions allowed.
		 */
		$limit = (int) apply_filters( 'cozy_addons_form_rate_limit', 8 );
		if ( $count >= $limit ) {
			return $this->fail( __( 'Too many submissions. Please try again in a few minutes.', 'cozy-addons' ), 429 );
		}
		set_transient( $rate_key, $count + 1, 10 * MINUTE_IN_SECONDS );

		// The form's spam check (Pro): reCAPTCHA or Turnstile, while the service is still set up.
		// Older configs have "ts" instead, or nothing at all from before the per-form choice, and
		// keep Turnstile. Google's and Cloudflare's error codes are never passed on.
		if ( isset( $config['cp'] ) ) {
			$captcha = is_string( $config['cp'] ) ? $config['cp'] : '';
		} else {
			$captcha = ! isset( $config['ts'] ) || ! empty( $config['ts'] ) ? 'turnstile' : '';
		}
		$human = true;
		if ( 'turnstile' === $captcha && cozy_addons_form_turnstile_enabled() ) {
			$human = Form_Turnstile::verify( $req->get_param( 'cf-turnstile-response' ) );
		} elseif ( 'recaptcha' === $captcha && cozy_addons_form_recaptcha_enabled() ) {
			$human = Form_Recaptcha::verify( 'v3' === Form_Recaptcha::version() ? $req->get_param( 'cozy_addons_form_rc' ) : $req->get_param( 'g-recaptcha-response' ) );
		}
		if ( ! $human ) {
			return $this->fail( __( 'Could not verify that you are human. Please try again.', 'cozy-addons' ), 403 );
		}

		// 5. Validate and sanitize every configured field.
		$posted = $req->get_param( 'cozy_addons_form_f' );
		$posted = is_array( $posted ) ? $posted : array();
		$values        = array();
		$errors        = array();
		$urgent_answer = '';
		$uploads       = array();
		$files         = $req->get_file_params();

		// Conditional logic (Pro): fields hidden for these answers are skipped, like in the browser.
		// Uploads and signatures have no answer to compare.
		$rule_values = $this->rule_values( $posted );
		foreach ( $config['fields'] as $field ) {
			if ( is_array( $field ) && isset( $field['n'], $field['t'] ) && in_array( $field['t'], array( 'file', 'image', 'signature' ), true ) ) {
				unset( $rule_values[ $field['n'] ] );
			}
		}
		$hidden = cozy_addons_form_hidden_fields( $config['fields'], $rule_values );

		foreach ( $config['fields'] as $index => $field ) {
			if ( ! is_array( $field ) || empty( $field['n'] ) || isset( $hidden[ $field['n'] ] ) ) {
				continue;
			}
			// Answers the form marked urgent, e.g. "Emergency – today". Signed with the config.
			$urgent_options = isset( $field['u'] ) && is_array( $field['u'] ) ? array_map( 'sanitize_text_field', $field['u'] ) : array();
			$field          = array(
				'n' => sanitize_key( $field['n'] ),
				'l' => sanitize_text_field( isset( $field['l'] ) ? $field['l'] : '' ),
				't' => sanitize_key( isset( $field['t'] ) ? $field['t'] : 'text' ),
				'r' => ! empty( $field['r'] ),
				'o' => isset( $field['o'] ) && is_array( $field['o'] ) ? array_map( 'sanitize_text_field', $field['o'] ) : array(),
				'v' => isset( $field['v'] ) && is_array( $field['v'] ) ? $field['v'] : array(),
			);
			$raw   = isset( $posted[ $field['n'] ] ) ? $posted[ $field['n'] ] : '';

			if ( 'file' === $field['t'] || 'image' === $field['t'] ) {
				// Checked now and only stored once the whole submission is accepted.
				$signed                  = $config['fields'][ $index ];
				$images_only             = 'image' === $field['t'];
				list( $picked, $error )  = Form_Uploads::from_request( is_array( $files ) ? $files : array(), $field['n'], isset( $signed['mf'] ) ? (int) $signed['mf'] : 1 );
				$value                   = '';
				if ( '' === $error && empty( $picked ) && $field['r'] ) {
					$error = $images_only ? __( 'Please choose an image.', 'cozy-addons' ) : __( 'Please choose a file.', 'cozy-addons' );
				}
				$checked = array();
				foreach ( '' === $error ? $picked : array() as $file ) {
					list( $upload, $error ) = Form_Uploads::validate( $file, array( 'mx' => isset( $signed['mx'] ) ? $signed['mx'] : 0 ), $images_only );
					if ( '' !== $error ) {
						break;
					}
					$checked[] = $upload;
				}
				if ( '' === $error && $checked ) {
					$uploads[ $field['n'] ] = array( 'list' => $checked );
					$value                  = implode( ', ', wp_list_pluck( $checked, 'name' ) );
				}
			} elseif ( 'signature' === $field['t'] ) {
				list( $png, $error ) = Form_Uploads::validate_signature( $raw );
				$value               = '';
				if ( '' === $error && null === $png && $field['r'] ) {
					$error = __( 'Please sign here.', 'cozy-addons' );
				}
				if ( '' === $error && null !== $png ) {
					$uploads[ $field['n'] ] = array( 'signature' => $png );
					$value                  = __( 'Signed', 'cozy-addons' );
				}
			} else {
				list( $value, $error ) = $this->clean( $field, $raw );
			}
			if ( '' !== $error ) {
				$errors[ $field['n'] ] = $error;
				continue;
			}
			$values[] = array(
				'n' => $field['n'],
				'l' => '' !== $field['l'] ? $field['l'] : ucfirst( $field['n'] ),
				't' => $field['t'],
				'v' => $value,
			);
			// A checkbox group is urgent when any ticked answer is.
			$answers = 'checkboxes' === $field['t'] && is_array( $raw ) ? array_map( 'sanitize_text_field', array_filter( $raw, 'is_scalar' ) ) : array( (string) $value );
			foreach ( $answers as $answer ) {
				if ( '' === $urgent_answer && '' !== $answer && in_array( $answer, $urgent_options, true ) ) {
					$urgent_answer = $answer;
				}
			}
		}

		if ( $errors ) {
			return $this->fail( __( 'Please check the highlighted fields.', 'cozy-addons' ), 422, $errors );
		}

		$type = isset( $config['type'] ) && is_string( $config['type'] ) && isset( cozy_addons_form_types()[ $config['type'] ] ) ? $config['type'] : 'contact';

		// Category and urgency. An urgent answer is the more specific reason; sign-up forms (newsletter, lead magnet, waitlist) are never urgent.
		$category = isset( $config['cat'] ) && is_string( $config['cat'] ) && isset( cozy_addons_form_categories()[ $config['cat'] ] ) ? $config['cat'] : '';
		$urgency  = array(
			'category' => $category,
			'reason'   => '',
		);
		if ( ! cozy_addons_form_type_is_subscription( $type ) ) {
			if ( '' !== $urgent_answer ) {
				$urgency['reason'] = $urgent_answer;
			} elseif ( '' !== $category && cozy_addons_form_category_is_urgent( $category ) ) {
				$urgency['reason'] = cozy_addons_form_categories()[ $category ];
			}
		}

		// 6. Product enquiry (Pro): product details come from the database, never from the visitor.
		$product = array();
		if ( ! empty( $config['p'] ) && cozy_addons_premium_access() ) {
			$product = Form_WooCommerce::resolve( (int) $config['p'], absint( $req->get_param( 'cozy_addons_form_variation_id' ) ) );
			if ( null === $product ) {
				return $this->fail( __( 'This product is no longer available.', 'cozy-addons' ) );
			}
			$values = array_merge( $values, $this->product_rows( $product, $req->get_param( 'cozy_addons_form_product_options' ) ) );
		}

		// 7. Very light spam check, extendable.
		$is_spam = false;
		foreach ( $values as $row ) {
			if ( 'textarea' === $row['t'] && preg_match_all( '#https?://#i', (string) $row['v'] ) > 3 ) {
				$is_spam = true;
			}
		}
		/**
		 * Filters whether a form submission should be silently dropped as spam.
		 *
		 * @param bool  $is_spam Current verdict.
		 * @param array $values  Sanitized values.
		 * @param array $config  Form config.
		 */
		if ( apply_filters( 'cozy_addons_form_is_spam', $is_spam, $values, $config ) ) {
			return $this->succeed( $config );
		}

		// Optional Akismet check. Spam is kept under Lead Forms → Inbox → Spam, without any email.
		$is_spam = Form_Akismet::enabled( isset( $config['ak'] ) && is_string( $config['ak'] ) ? $config['ak'] : 'default' ) && Form_Akismet::is_spam( $values, $this->page_url( $req ) );

		// 8. Sign-up forms: a repeat sign-up gets the same answer, so nobody can test which emails are subscribed.
		if ( ! $is_spam && cozy_addons_form_type_is_subscription( $type ) && $this->is_subscribed( $values, $config ) ) {
			return $this->succeed( $config );
		}

		// 9. Store uploaded files privately, then save the entry and notify. The visitor sees the same answer either way.
		$stored = array();
		foreach ( $uploads as $name => $upload ) {
			$stored[ $name ] = array();
			$batch           = isset( $upload['signature'] ) ? array( null ) : $upload['list'];
			foreach ( $batch as $one ) {
				$file = null === $one
					? Form_Uploads::store_data( $upload['signature'], 'png', 'image/png', 'signature-' . $name . '.png' )
					: Form_Uploads::store( $one );
				if ( null === $file ) {
					Form_Uploads::delete_files( $stored );
					return $this->fail( __( 'We could not save your file. Please try again.', 'cozy-addons' ), 500 );
				}
				$stored[ $name ][] = $file;
			}
		}

		$entry_id = $this->save_entry( $req, $config, $values, $type, $product, $is_spam, $urgency, $stored );
		if ( is_wp_error( $entry_id ) ) {
			Form_Uploads::delete_files( $stored );
			return $this->fail( __( 'We could not save your message. Please try again.', 'cozy-addons' ), 500 );
		}

		return $this->succeed( $config );
	}

	/**
	 * Sanitizes and validates one value.
	 *
	 * @param array $field Field definition.
	 * @param mixed $raw   Submitted value.
	 * @return array{0:?string,1:string} Clean value and error message.
	 */
	private function clean( array $field, $raw ) {
		$required = __( 'This field is required.', 'cozy-addons' );
		$invalid  = __( 'Please enter a valid value.', 'cozy-addons' );

		if ( 'checkbox' === $field['t'] ) {
			$checked = ! is_array( $raw ) && ! empty( $raw );
			if ( $field['r'] && ! $checked ) {
				return array( null, __( 'Please tick this box to continue.', 'cozy-addons' ) );
			}
			return array( $checked ? __( 'Yes', 'cozy-addons' ) : __( 'No', 'cozy-addons' ), '' );
		}

		if ( 'checkboxes' === $field['t'] ) {
			return $this->clean_choices( $field, $raw );
		}

		if ( is_array( $raw ) ) {
			return array( null, $invalid );
		}
		$value = trim( (string) $raw );
		if ( '' === $value ) {
			return $field['r'] ? array( null, $required ) : array( '', '' );
		}

		switch ( $field['t'] ) {
			case 'email':
				$value = sanitize_email( $value );
				if ( ! is_email( $value ) ) {
					return array( null, __( 'Please enter a valid email address.', 'cozy-addons' ) );
				}
				break;
			case 'tel':
				$value = sanitize_text_field( $value );
				if ( ! preg_match( '/^[0-9+().\-\s]{6,25}$/', $value ) ) {
					return array( null, __( 'Please enter a valid phone number.', 'cozy-addons' ) );
				}
				break;
			case 'url':
				// Visitors often leave out the scheme; browsers ask for it, scripts may not.
				if ( ! preg_match( '#^[a-z][a-z0-9+.\-]*://#i', $value ) ) {
					$value = 'https://' . $value;
				}
				$value = esc_url_raw( mb_substr( $value, 0, 500 ), array( 'http', 'https' ) );
				if ( '' === $value || false === filter_var( $value, FILTER_VALIDATE_URL ) ) {
					return array( null, __( 'Please enter a valid web address.', 'cozy-addons' ) );
				}
				break;
			case 'number':
				if ( ! is_numeric( $value ) ) {
					return array( null, __( 'Please enter a number.', 'cozy-addons' ) );
				}
				$value = sanitize_text_field( $value );
				break;
			case 'date':
				if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $value ) ) {
					return array( null, $invalid );
				}
				break;
			case 'time':
				// "14:30", optionally with seconds, stored as "14:30".
				if ( ! preg_match( '/^([01]\d|2[0-3]):([0-5]\d)(?::[0-5]\d(?:\.\d{1,3})?)?$/', $value, $parts ) ) {
					return array( null, $invalid );
				}
				$value = $parts[1] . ':' . $parts[2];
				break;
			case 'datetime':
				// "2026-10-17T14:30", optionally with seconds, stored as "2026-10-17 14:30".
				if ( ! preg_match( '/^(\d{4}-\d{2}-\d{2})T(\d{2}:\d{2})(?::\d{2}(?:\.\d{1,3})?)?$/', $value, $parts ) ) {
					return array( null, $invalid );
				}
				$value = $parts[1] . ' ' . $parts[2];
				break;
			case 'select':
			case 'radio':
				$value = sanitize_text_field( $value );
				if ( ! in_array( $value, $field['o'], true ) ) {
					return array( null, $invalid );
				}
				break;
			case 'textarea':
				$value = sanitize_textarea_field( mb_substr( $value, 0, 5000 ) );
				break;
			default:
				$value = sanitize_text_field( mb_substr( $value, 0, 300 ) );
		}

		$error = $this->check_rules( $field, $value );

		return '' === $error ? array( $value, '' ) : array( null, $error );
	}

	/**
	 * Sanitizes a checkbox group: every ticked answer must be one of its options.
	 *
	 * @param array $field Field definition.
	 * @param mixed $raw   Submitted value, a list of answers.
	 * @return array{0:?string,1:string} Answers joined with commas, and an error message.
	 */
	private function clean_choices( array $field, $raw ) {
		if ( '' === $raw || null === $raw ) {
			$raw = array();
		}
		if ( ! is_array( $raw ) || count( $raw ) > 50 ) {
			return array( null, __( 'Please enter a valid value.', 'cozy-addons' ) );
		}

		$ticked = array();
		foreach ( $raw as $answer ) {
			$answer = is_scalar( $answer ) ? sanitize_text_field( (string) $answer ) : '';
			if ( '' === $answer ) {
				continue;
			}
			if ( ! in_array( $answer, $field['o'], true ) ) {
				return array( null, __( 'Please enter a valid value.', 'cozy-addons' ) );
			}
			$ticked[] = $answer;
		}
		if ( empty( $ticked ) ) {
			return $field['r'] ? array( null, __( 'Please choose at least one option.', 'cozy-addons' ) ) : array( '', '' );
		}

		// In the form's order, each answer once.
		return array( implode( ', ', array_values( array_intersect( $field['o'], $ticked ) ) ), '' );
	}

	/**
	 * Advanced validation (Pro): length, pattern and number range, from the signed config.
	 *
	 * @param array  $field Field definition, with its rules under "v".
	 * @param string $value Clean, non-empty value.
	 * @return string Error message, or '' when the value passes.
	 */
	private function check_rules( array $field, $value ) {
		$rules = $field['v'];
		if ( empty( $rules ) ) {
			return '';
		}
		$message = isset( $rules['msg'] ) && is_string( $rules['msg'] ) && '' !== $rules['msg'] ? sanitize_text_field( $rules['msg'] ) : __( 'Please enter a valid value.', 'cozy-addons' );
		$length  = mb_strlen( $value );

		if ( isset( $rules['minl'] ) && $length < (int) $rules['minl'] ) {
			return $message;
		}
		if ( isset( $rules['maxl'] ) && $length > (int) $rules['maxl'] ) {
			return $message;
		}
		if ( isset( $rules['pat'] ) && is_string( $rules['pat'] ) && '' !== $rules['pat'] ) {
			// An expression that does not compile is skipped rather than blocking every visitor.
			$match = @preg_match( cozy_addons_form_pattern_regex( $rules['pat'] ), $value ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- Site owner's regex.
			if ( 0 === $match ) {
				return $message;
			}
		}
		if ( isset( $rules['min'] ) && is_numeric( $value ) && (float) $value < (float) $rules['min'] ) {
			return $message;
		}
		if ( isset( $rules['max'] ) && is_numeric( $value ) && (float) $value > (float) $rules['max'] ) {
			return $message;
		}

		return '';
	}

	/**
	 * Submitted values as conditional-logic rules see them: text, or a list for checkbox groups.
	 *
	 * @param array $posted Submitted values keyed by field name.
	 * @return array
	 */
	private function rule_values( array $posted ) {
		$out = array();
		foreach ( $posted as $name => $value ) {
			if ( is_array( $value ) ) {
				$out[ sanitize_key( $name ) ] = array_values( array_map( 'sanitize_text_field', array_filter( $value, 'is_scalar' ) ) );
			} elseif ( is_scalar( $value ) ) {
				$out[ sanitize_key( $name ) ] = trim( sanitize_text_field( (string) $value ) );
			}
		}

		return $out;
	}

	/**
	 * Page the form was submitted from, without its query string so tracking tags do not split pages.
	 *
	 * @param WP_REST_Request $req Request.
	 * @return string
	 */
	private function page_url( WP_REST_Request $req ) {
		$page = esc_url_raw( (string) $req->get_param( 'cozy_addons_form_page' ) );

		return '' !== $page ? (string) strtok( $page, '?#' ) : '';
	}

	/**
	 * Rows describing the product of an enquiry, added after the visitor's fields.
	 *
	 * @param array $product Trusted product details from Form_WooCommerce::resolve().
	 * @param mixed $options Options the visitor chose on the product page, e.g. "Size: L".
	 * @return array
	 */
	private function product_rows( array $product, $options ) {
		$options = is_scalar( $options ) ? trim( sanitize_text_field( mb_substr( (string) $options, 0, 300 ) ) ) : '';
		$rows    = array(
			array(
				'n' => 'product',
				'l' => __( 'Product', 'cozy-addons' ),
				't' => 'product',
				'v' => $product['name'],
			),
		);
		if ( '' !== $options ) {
			$rows[] = array(
				'n' => 'product_options',
				'l' => __( 'Selected options', 'cozy-addons' ),
				't' => 'product',
				'v' => $options,
			);
		}
		if ( '' !== $product['sku'] ) {
			$rows[] = array(
				'n' => 'product_sku',
				'l' => __( 'SKU', 'cozy-addons' ),
				't' => 'product',
				'v' => $product['sku'],
			);
		}
		if ( '' !== $product['price'] ) {
			$rows[] = array(
				'n' => 'product_price',
				'l' => __( 'Price shown', 'cozy-addons' ),
				't' => 'product',
				'v' => $product['price'],
			);
		}
		$rows[] = array(
			'n' => 'product_url',
			'l' => __( 'Product page', 'cozy-addons' ),
			't' => 'url',
			'v' => $product['url'],
		);

		return $rows;
	}

	/**
	 * Whether the email of a newsletter sign-up is already stored for this form.
	 *
	 * @param array $values Sanitized values.
	 * @param array $config Form config.
	 * @return bool
	 */
	private function is_subscribed( array $values, array $config ) {
		$email = '';
		foreach ( $values as $row ) {
			if ( 'email' === $row['t'] && '' !== (string) $row['v'] ) {
				$email = (string) $row['v'];
				break;
			}
		}
		if ( '' === $email ) {
			return false;
		}

		$found = get_posts(
			array(
				'post_type'      => Entry_Post_Type::TYPE,
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'no_found_rows'  => true,
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- One small lookup per sign-up.
					array(
						'key'   => '_ca_form_email',
						'value' => $email,
					),
					array(
						'key'   => '_ca_form_id',
						'value' => sanitize_key( isset( $config['id'] ) ? $config['id'] : '' ),
					),
				),
			)
		);

		return ! empty( $found );
	}

	/**
	 * Creates the entry post and sends the emails.
	 *
	 * @param WP_REST_Request $req     Request.
	 * @param array           $config  Form config.
	 * @param array           $values  Sanitized values.
	 * @param string          $type    Form type.
	 * @param array           $product Trusted product details, empty when not a product enquiry.
	 * @param bool            $is_spam Whether Akismet flagged it: saved as spam, without emails or the created action.
	 * @param array           $urgency Category slug and urgency reason ('' when not urgent).
	 * @param array           $files   Stored files keyed by field name, from Form_Uploads::store().
	 * @return int|\WP_Error Entry ID or error.
	 */
	private function save_entry( WP_REST_Request $req, array $config, array $values, $type, array $product, $is_spam = false, array $urgency = array(), array $files = array() ) {
		$title   = '';
		$email   = '';
		$phone   = '';
		$summary = '';
		$lines   = array();

		foreach ( $values as $row ) {
			if ( '' !== (string) $row['v'] ) {
				$lines[] = $row['l'] . ': ' . $row['v'];
			}
			if ( '' === $email && 'email' === $row['t'] ) {
				$email = (string) $row['v'];
			}
			if ( '' === $phone && 'tel' === $row['t'] ) {
				$phone = (string) $row['v'];
			}
			if ( '' === $title && 'text' === $row['t'] && false !== stripos( $row['l'], 'name' ) ) {
				$title = (string) $row['v'];
			}
			if ( '' === $summary && in_array( $row['t'], array( 'textarea', 'select' ), true ) ) {
				$summary = wp_trim_words( (string) $row['v'], 30, '…' );
			}
		}
		if ( '' === $title ) {
			foreach ( $values as $row ) {
				if ( 'text' === $row['t'] && '' !== (string) $row['v'] ) {
					$title = (string) $row['v'];
					break;
				}
			}
		}
		if ( '' === $title ) {
			$title = '' !== $email ? $email : ( '' !== $phone ? $phone : __( 'New entry', 'cozy-addons' ) );
		}
		$title = mb_substr( $title, 0, 120 );

		$page       = $this->page_url( $req );
		$page_title = sanitize_text_field( mb_substr( (string) $req->get_param( 'cozy_addons_form_title' ), 0, 200 ) );
		$form_name  = sanitize_text_field( isset( $config['name'] ) ? $config['name'] : __( 'Contact form', 'cozy-addons' ) );

		$postarr = array(
			'post_type'    => Entry_Post_Type::TYPE,
			'post_status'  => $is_spam ? Entry_Post_Type::SPAM : 'publish',
			'post_title'   => $title,
			'post_content' => implode( "\n", $lines ),
			'meta_input'   => array(
				'_ca_form_type'       => $type,
				'_ca_form_category'   => isset( $urgency['category'] ) ? $urgency['category'] : '',
				'_ca_form_fields'     => $values,
				'_ca_form_name'       => $form_name,
				'_ca_form_id'         => sanitize_key( isset( $config['id'] ) ? $config['id'] : '' ),
				'_ca_form_email'      => $email,
				'_ca_form_phone'      => $phone,
				'_ca_form_summary'    => $summary,
				'_ca_form_page_url'   => $page,
				'_ca_form_page_title' => $page_title,
			),
		);

		if ( ! empty( $urgency['reason'] ) ) {
			$postarr['meta_input']['_ca_form_urgent']        = '1';
			$postarr['meta_input']['_ca_form_urgent_reason'] = $urgency['reason'];
		}
		// Sign-ups have no status pipeline, so they stay out of the "new" counts.
		if ( ! cozy_addons_form_type_is_subscription( $type ) ) {
			$postarr['meta_input']['_ca_form_status'] = 'new';
		}
		if ( ! empty( $product ) ) {
			$postarr['meta_input']['_ca_form_product_id']   = (int) $product['id'];
			$postarr['meta_input']['_ca_form_product_name'] = $product['name'];
			$postarr['meta_input']['_ca_form_product_sku']  = $product['sku'];
			$postarr['meta_input']['_ca_form_product_url']  = $product['url'];
		}

		// Files stay in private storage; the entry only keeps where they are.
		if ( ! empty( $files ) ) {
			$postarr['meta_input']['_ca_form_files'] = $files;
		}

		// wp_insert_post() and update_post_meta() expect slashed data.
		$entry_id = wp_insert_post( wp_slash( $postarr ), true );
		if ( is_wp_error( $entry_id ) ) {
			return $entry_id;
		}

		if ( $is_spam ) {
			return (int) $entry_id;
		}

		$this->notify( (int) $entry_id, $config, $title, $email, $values, $page, $product );

		/**
		 * Fires after a form entry has been saved.
		 *
		 * @param int   $entry_id Entry post ID.
		 * @param array $values   Sanitized values.
		 * @param array $config   Form config.
		 */
		do_action( 'cozy_addons_form_entry_created', (int) $entry_id, $values, $config );

		return (int) $entry_id;
	}

	/**
	 * Sends the admin notification, unless the form turned it off, and on Pro the optional
	 * auto-reply to the visitor.
	 *
	 * @param int    $entry_id Entry ID.
	 * @param array  $config   Form config.
	 * @param string $title    Entry title.
	 * @param string $email    Visitor email.
	 * @param array  $values   Sanitized values.
	 * @param string $page     Page the form was submitted from.
	 * @param array  $product  Trusted product details, empty when not a product enquiry.
	 * @return void
	 */
	private function notify( $entry_id, array $config, $title, $email, array $values, $page, array $product ) {
		$settings = cozy_addons_form_settings();
		$site     = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );

		if ( ! isset( $config['n'] ) || ! empty( $config['n'] ) ) {
			$this->notify_owner( $entry_id, $config, $title, $email, $values, $page, $product, $site );
		}

		// Pro: confirmation to the visitor, at most one per address per hour to prevent abuse.
		if ( cozy_addons_premium_access() && ! empty( $settings['autoreply_enabled'] ) && is_email( $email ) ) {
			$throttle = 'ca_form_ar_' . md5( strtolower( $email ) );
			if ( false === get_transient( $throttle ) ) {
				set_transient( $throttle, 1, HOUR_IN_SECONDS );
				$download = $this->download( $config );
				$message  = str_replace(
					array( '{name}', '{site}', '{download_url}' ),
					array( $title, $site, $download ? $download['url'] : '' ),
					(string) $settings['autoreply_message']
				);
				wp_mail( $email, wp_strip_all_tags( (string) $settings['autoreply_subject'] ), $message, array( 'Content-Type: text/plain; charset=UTF-8' ) );
			}
		}
	}

	/**
	 * Emails the entry to the form's recipients.
	 *
	 * @param int    $entry_id Entry ID.
	 * @param array  $config   Form config.
	 * @param string $title    Entry title.
	 * @param string $email    Visitor email.
	 * @param array  $values   Sanitized values.
	 * @param string $page     Page the form was submitted from.
	 * @param array  $product  Trusted product details, may be empty.
	 * @param string $site     Site name.
	 * @return void
	 */
	private function notify_owner( $entry_id, array $config, $title, $email, array $values, $page, array $product, $site ) {
		$settings = cozy_addons_form_settings();

		// The form's own recipients win over the global list; the site admin is the last resort.
		// The form's recipients are sealed in the config so they cannot be read in the page source.
		$recipients = cozy_addons_form_parse_emails( cozy_addons_form_unseal( isset( $config['to'] ) ? $config['to'] : '' ) );
		if ( empty( $recipients ) ) {
			$recipients = cozy_addons_form_parse_emails( $settings['notify_emails'] );
		}
		if ( empty( $recipients ) ) {
			$recipients = array( get_option( 'admin_email' ) );
		}

		if ( ! empty( $product ) ) {
			$subject = sprintf(
				/* translators: 1: site name, 2: visitor name, 3: product name */
				__( '[%1$s] Product enquiry from %2$s: %3$s', 'cozy-addons' ),
				$site,
				$title,
				$product['name']
			);
		} else {
			$subject = sprintf(
				/* translators: 1: site name, 2: entry title */
				__( '[%1$s] New form entry: %2$s', 'cozy-addons' ),
				$site,
				$title
			);
		}

		$form_name  = isset( $config['name'] ) ? sanitize_text_field( (string) $config['name'] ) : '';
		$entry_url  = admin_url( 'post.php?post=' . $entry_id . '&action=edit' );
		$all_fields = '';
		foreach ( $values as $row ) {
			if ( '' !== (string) $row['v'] ) {
				$all_fields .= $row['l'] . ': ' . $row['v'] . "\n";
			}
		}

		$body = sprintf(
			/* translators: %s: form name */
			__( 'New submission from "%s"', 'cozy-addons' ),
			$form_name
		) . "\n\n" . $all_fields;
		if ( $page ) {
			$body .= "\n" . __( 'Submitted on', 'cozy-addons' ) . ': ' . $page . "\n";
		}
		$body .= "\n" . __( 'View entry', 'cozy-addons' ) . ': ' . $entry_url . "\n";

		// Pro: the form's own subject and message. Sealed in the config, so not readable in the page.
		$template = cozy_addons_premium_access() ? json_decode( cozy_addons_form_unseal( isset( $config['em'] ) ? $config['em'] : '' ), true ) : null;
		if ( is_array( $template ) ) {
			$tags = array(
				'{form_name}'  => $form_name,
				'{site}'       => $site,
				'{page_url}'   => $page,
				'{date}'       => wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ),
				'{entry_url}'  => $entry_url,
				'{all_fields}' => rtrim( $all_fields ),
			);
			foreach ( $values as $row ) {
				$tags[ '{field:' . $row['n'] . '}' ] = (string) $row['v'];
			}
			$fill = function ( $text ) use ( $tags ) {
				// Tags of fields left empty or hidden become blank.
				return preg_replace( '/\{field:[a-z0-9_\-]+\}/', '', strtr( (string) $text, $tags ) );
			};
			if ( ! empty( $template['s'] ) && is_string( $template['s'] ) ) {
				$custom = trim( preg_replace( '/[\r\n]+/', ' ', wp_strip_all_tags( $fill( $template['s'] ) ) ) );
				if ( '' !== $custom ) {
					$subject = $custom;
				}
			}
			if ( ! empty( $template['b'] ) && is_string( $template['b'] ) ) {
				$body = $fill( $template['b'] ) . "\n";
			}
		}

		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
		if ( is_email( $email ) ) {
			$headers[] = 'Reply-To: ' . $email;
		}

		// Urgent entries stand out in the inbox and in the email.
		if ( '1' === get_post_meta( $entry_id, '_ca_form_urgent', true ) ) {
			/* translators: %s: email subject */
			$subject = sprintf( __( '[Urgent] %s', 'cozy-addons' ), $subject );
			$body    = __( 'Urgent', 'cozy-addons' ) . ': ' . get_post_meta( $entry_id, '_ca_form_urgent_reason', true ) . "\n\n" . $body;
		}

		$sent = wp_mail( $recipients, $subject, $body, $headers );
		update_post_meta( $entry_id, '_ca_form_notified', $sent ? '1' : '0' );
	}
}
