<?php
/**
 * Privacy tools (export, erase, policy text) and entry retention.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hooks form entries into the WordPress personal data tools and removes old entries.
 */
final class Entries_Privacy {

	const BATCH = 50;
	const CRON  = 'cozy_addons_form_cleanup';

	/**
	 * Registers hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'wp_privacy_personal_data_exporters', array( __CLASS__, 'register_exporter' ) );
		add_filter( 'wp_privacy_personal_data_erasers', array( __CLASS__, 'register_eraser' ) );
		add_action( 'admin_init', array( __CLASS__, 'policy_text' ) );
		add_action( 'init', array( __CLASS__, 'schedule' ) );
		add_action( self::CRON, array( __CLASS__, 'cleanup' ) );
	}

	/**
	 * Registers the personal data exporter.
	 *
	 * @param array $exporters Existing exporters.
	 * @return array
	 */
	public static function register_exporter( $exporters ) {
		$exporters['cozy-addons-forms'] = array(
			'exporter_friendly_name' => __( 'Cozy Blocks form entries', 'cozy-addons' ),
			'callback'               => array( __CLASS__, 'export' ),
		);

		return $exporters;
	}

	/**
	 * Registers the personal data eraser.
	 *
	 * @param array $erasers Existing erasers.
	 * @return array
	 */
	public static function register_eraser( $erasers ) {
		$erasers['cozy-addons-forms'] = array(
			'eraser_friendly_name' => __( 'Cozy Blocks form entries', 'cozy-addons' ),
			'callback'             => array( __CLASS__, 'erase' ),
		);

		return $erasers;
	}

	/**
	 * Finds entry IDs submitted with an email address.
	 *
	 * @param string $email Email address.
	 * @param int    $page  Page number.
	 * @return int[]
	 */
	private static function find_by_email( $email, $page = 1 ) {
		return get_posts(
			array(
				'post_type'      => Entry_Post_Type::TYPE,
				// Spam and trashed entries hold personal data too.
				'post_status'    => array( 'publish', Entry_Post_Type::SPAM, 'trash' ),
				'posts_per_page' => self::BATCH,
				'paged'          => max( 1, (int) $page ),
				'fields'         => 'ids',
				'no_found_rows'  => true,
				'meta_key'       => '_ca_form_email', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Privacy request, rarely run.
				'meta_value'     => sanitize_email( $email ), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value -- Privacy request, rarely run.
			)
		);
	}

	/**
	 * Exports the entries of a data subject.
	 *
	 * @param string $email_address Email address.
	 * @param int    $page          Page number.
	 * @return array
	 */
	public static function export( $email_address, $page = 1 ) {
		$ids   = self::find_by_email( $email_address, $page );
		$items = array();

		foreach ( $ids as $entry_id ) {
			$data   = array(
				array(
					'name'  => __( 'Received', 'cozy-addons' ),
					'value' => get_the_date( '', $entry_id ),
				),
				array(
					'name'  => __( 'Form', 'cozy-addons' ),
					'value' => (string) get_post_meta( $entry_id, '_ca_form_name', true ),
				),
			);
			$fields = get_post_meta( $entry_id, '_ca_form_fields', true );
			foreach ( (array) $fields as $row ) {
				if ( isset( $row['l'], $row['v'] ) && '' !== (string) $row['v'] ) {
					$data[] = array(
						'name'  => (string) $row['l'],
						'value' => (string) $row['v'],
					);
				}
			}
			$page_url = (string) get_post_meta( $entry_id, '_ca_form_page_url', true );
			if ( '' !== $page_url ) {
				$data[] = array(
					'name'  => __( 'Submitted on', 'cozy-addons' ),
					'value' => $page_url,
				);
			}
			$items[] = array(
				'group_id'    => 'cozy-addons-forms',
				'group_label' => __( 'Form entries', 'cozy-addons' ),
				'item_id'     => 'cozy-addons-form-entry-' . $entry_id,
				'data'        => $data,
			);
		}

		return array(
			'data' => $items,
			'done' => count( $ids ) < self::BATCH,
		);
	}

	/**
	 * Erases the entries of a data subject.
	 *
	 * @param string $email_address Email address.
	 * @param int    $page          Page number, unused because deleted items shift the result set.
	 * @return array
	 */
	public static function erase( $email_address, $page = 1 ) {
		unset( $page );
		$ids     = self::find_by_email( $email_address, 1 );
		$removed = 0;
		foreach ( $ids as $entry_id ) {
			if ( wp_delete_post( $entry_id, true ) ) {
				++$removed;
			}
		}

		return array(
			'items_removed'  => $removed,
			'items_retained' => 0,
			'messages'       => array(),
			'done'           => count( $ids ) < self::BATCH,
		);
	}

	/**
	 * Suggests text for the site's privacy policy.
	 *
	 * @return void
	 */
	public static function policy_text() {
		if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
			return;
		}
		$content = '<p class="privacy-policy-tutorial">' . esc_html__( 'Suggested text for sites using Cozy Blocks forms.', 'cozy-addons' ) . '</p>'
			. '<p>' . esc_html__( 'When you submit a form on this site we store the details you enter (for example your name, phone number, email address and message) and the page you submitted it from. We use this to reply to you. Your IP address is used briefly to limit spam and is not stored with your message.', 'cozy-addons' ) . '</p>'
			. '<p>' . esc_html__( 'Files, images and signatures you add to a form are stored privately on this site with your message, are only available to our staff, and are deleted together with your message.', 'cozy-addons' ) . '</p>';
		if ( cozy_addons_form_turnstile_enabled() ) {
			$content .= '<p>' . esc_html__( 'Our forms use Cloudflare Turnstile to check that submissions come from a person. Turnstile runs in your browser and Cloudflare receives information about your visit, such as your IP address. See the Cloudflare privacy policy: https://www.cloudflare.com/privacypolicy/', 'cozy-addons' ) . '</p>';
		}
		if ( cozy_addons_form_recaptcha_enabled() ) {
			$content .= '<p>' . esc_html__( 'Our forms may use Google reCAPTCHA to check that submissions come from a person. reCAPTCHA runs in your browser and Google receives information about your visit and your device, such as your IP address. See the Google privacy policy: https://policies.google.com/privacy', 'cozy-addons' ) . '</p>';
		}
		if ( ! empty( cozy_addons_form_settings()['akismet'] ) ) {
			$content .= '<p>' . esc_html__( 'Form submissions may be checked through the Automattic Akismet spam detection service. The details you enter, your IP address and your browser user agent are sent to Akismet. See the Automattic privacy policy: https://automattic.com/privacy/', 'cozy-addons' ) . '</p>';
		}
		wp_add_privacy_policy_content( 'Cozy Blocks', wp_kses_post( $content ) );
	}

	/**
	 * Makes sure the daily cleanup is scheduled.
	 *
	 * @return void
	 */
	public static function schedule() {
		if ( ! wp_next_scheduled( self::CRON ) ) {
			wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', self::CRON );
		}
	}

	/**
	 * Deletes spam after 30 days, and other entries older than the retention period when one is set.
	 *
	 * @return void
	 */
	public static function cleanup() {
		$days = (int) cozy_addons_form_settings()['retention_days'];

		// Spam is kept for 30 days at most, or less when the retention period is shorter.
		self::delete_older_than( Entry_Post_Type::SPAM, $days > 0 ? min( 30, $days ) : 30 );
		if ( $days > 0 ) {
			self::delete_older_than( 'any', $days );
		}
	}

	/**
	 * Deletes up to 100 entries of a status older than a number of days.
	 *
	 * @param string $status Post status, or "any".
	 * @param int    $days   Age in days.
	 * @return void
	 */
	private static function delete_older_than( $status, $days ) {
		$ids = get_posts(
			array(
				'post_type'      => Entry_Post_Type::TYPE,
				'post_status'    => $status,
				'posts_per_page' => 100,
				'fields'         => 'ids',
				'no_found_rows'  => true,
				'date_query'     => array(
					array(
						'column' => 'post_date_gmt',
						'before' => gmdate( 'Y-m-d H:i:s', time() - $days * DAY_IN_SECONDS ),
					),
				),
			)
		);
		foreach ( $ids as $entry_id ) {
			wp_delete_post( $entry_id, true );
		}
	}
}
