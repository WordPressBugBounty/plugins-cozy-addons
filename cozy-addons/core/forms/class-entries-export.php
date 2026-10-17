<?php
/**
 * CSV export of form entries (Pro).
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Streams entries as a CSV download.
 */
final class Entries_Export {

	const BATCH     = 500;
	const MAX_PAGES = 20;

	/**
	 * Registers hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_post_cozy_addons_form_export', array( __CLASS__, 'handle' ) );
	}

	/**
	 * URL of the export action, carrying the current filters.
	 *
	 * @param array $args Extra query arguments (status, form, type).
	 * @return string URL with nonce.
	 */
	public static function url( array $args = array() ) {
		$args['action'] = 'cozy_addons_form_export';

		return wp_nonce_url( add_query_arg( $args, admin_url( 'admin-post.php' ) ), 'cozy_addons_form_export' );
	}

	/**
	 * Neutralises spreadsheet formulas in a cell (CSV injection).
	 *
	 * @param mixed $value Cell value.
	 * @return string
	 */
	public static function cell( $value ) {
		$value = (string) $value;
		if ( '' === $value ) {
			return '';
		}
		// Plain phone numbers such as "+1 555 123 4567" are safe and should stay readable.
		if ( preg_match( '/^\+[0-9][0-9\s().\-]*$/', $value ) ) {
			return $value;
		}
		if ( preg_match( '/^[=+\-@\t\r]/', $value ) ) {
			return "'" . $value;
		}

		return $value;
	}

	/**
	 * Sends the CSV file.
	 *
	 * @return void
	 */
	public static function handle() {
		if ( ! current_user_can( 'edit_others_ca_form_entries' ) ) { // phpcs:ignore WordPress.WP.Capabilities.Unknown -- Custom capability registered by this plugin.
			wp_die( esc_html__( 'You are not allowed to export entries.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		check_admin_referer( 'cozy_addons_form_export' );
		if ( ! cozy_addons_premium_access() ) {
			wp_die( esc_html__( 'Exporting entries is available in Cozy Blocks Pro.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}

		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Verified above by check_admin_referer().
		$status   = isset( $_GET['ca_form_status'] ) ? sanitize_key( wp_unslash( $_GET['ca_form_status'] ) ) : '';
		$form     = isset( $_GET['ca_form_name'] ) ? sanitize_text_field( wp_unslash( $_GET['ca_form_name'] ) ) : '';
		$type     = isset( $_GET['ca_form_type'] ) ? sanitize_key( wp_unslash( $_GET['ca_form_type'] ) ) : '';
		$category = isset( $_GET['ca_form_category'] ) ? sanitize_key( wp_unslash( $_GET['ca_form_category'] ) ) : '';
		$urgent   = ! empty( $_GET['ca_form_urgent'] );
		// phpcs:enable

		$args = array(
			'post_type'      => Entry_Post_Type::TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => self::BATCH,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		);
		$mq   = Entries_Admin::build_meta_query( $status, $form, $type, $category, $urgent );
		if ( $mq ) {
			$args['meta_query'] = $mq; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- Admin-only export.
		}

		nocache_headers();
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="form-entries-' . gmdate( 'Y-m-d' ) . '.csv"' );

		$out = fopen( 'php://output', 'w' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen -- Streaming a download, not touching the filesystem.
		fwrite( $out, "\xEF\xBB\xBF" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite -- UTF-8 BOM so Excel reads accents correctly.
		fputcsv( $out, array( 'ID', 'Received', 'Name', 'Email', 'Phone', 'Status', 'Urgent', 'Type', 'Category', 'Form', 'Product', 'Product SKU', 'Submitted on', 'Details' ), ',', '"', '' );

		for ( $page = 1; $page <= self::MAX_PAGES; $page++ ) {
			$args['paged'] = $page;
			$ids           = get_posts( $args );
			foreach ( $ids as $entry_id ) {
				fputcsv( $out, self::row( (int) $entry_id ), ',', '"', '' );
			}
			if ( count( $ids ) < self::BATCH ) {
				break;
			}
		}
		fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose -- Streaming a download.
		exit;
	}

	/**
	 * Builds one CSV row.
	 *
	 * @param int $entry_id Entry ID.
	 * @return string[]
	 */
	private static function row( $entry_id ) {
		$meta    = static function ( $key ) use ( $entry_id ) {
			return (string) get_post_meta( $entry_id, '_ca_form_' . $key, true );
		};
		$fields  = get_post_meta( $entry_id, '_ca_form_fields', true );
		$details = array();
		foreach ( (array) $fields as $field ) {
			if ( isset( $field['l'], $field['v'] ) && '' !== (string) $field['v'] ) {
				$details[] = $field['l'] . ': ' . str_replace( array( "\r", "\n" ), ' ', (string) $field['v'] );
			}
		}

		$cells = array(
			(string) $entry_id,
			get_the_date( 'Y-m-d H:i', $entry_id ),
			get_the_title( $entry_id ),
			$meta( 'email' ),
			$meta( 'phone' ),
			$meta( 'status' ),
			'1' === $meta( 'urgent' ) ? 'Yes' : '',
			cozy_addons_form_entry_type( $entry_id ),
			$meta( 'category' ),
			$meta( 'name' ),
			$meta( 'product_name' ),
			$meta( 'product_sku' ),
			$meta( 'page_url' ),
			implode( ' | ', $details ),
		);

		return array_map( array( __CLASS__, 'cell' ), $cells );
	}
}
