<?php
/**
 * Lead Forms → Error log: failed Mailchimp, Brevo, webhook and email deliveries, for administrators.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Keeps the newest delivery errors in one option, outside autoload. Only the short reasons that
 * are already shown on entries are logged, with email addresses masked: never keys or tokens.
 */
final class Form_Log {

	const PAGE   = 'ca-form-log';
	const OPTION = 'ca_form_error_log';
	const SEQ    = 'ca_form_error_log_seq';
	const MAX    = 200;

	/**
	 * Registers the admin hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ), 20 );
		add_action( 'admin_post_ca_form_clear_log', array( __CLASS__, 'clear_action' ) );
	}

	/**
	 * Services that can fail, with their names.
	 *
	 * @return array<string,string>
	 */
	public static function sources() {
		return array(
			'mailchimp' => __( 'Mailchimp', 'cozy-addons' ),
			'brevo'     => __( 'Brevo', 'cozy-addons' ),
			'webhook'   => __( 'Webhook', 'cozy-addons' ),
			'email'     => __( 'Notification email', 'cozy-addons' ),
			'autoreply' => __( 'Auto-reply', 'cozy-addons' ),
		);
	}

	/**
	 * Logs a failed delivery.
	 *
	 * @param string $source   One of sources().
	 * @param string $message  Short reason.
	 * @param int    $entry_id Entry it was for.
	 * @return void
	 */
	public static function add( $source, $message, $entry_id = 0 ) {
		if ( ! isset( self::sources()[ $source ] ) ) {
			return;
		}
		$message = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $message ) ) );
		// The reason can quote the visitor's address; the entry link is enough to find them.
		$message = preg_replace( '/[^\s<>()"\'@]+@[^\s<>()"\'@]+\.[a-z]{2,}/i', '[email]', $message );
		$id      = (int) get_option( self::SEQ, 0 ) + 1;
		update_option( self::SEQ, $id, false );

		$rows   = self::rows();
		$rows[] = array(
			'id'      => $id,
			'time'    => time(),
			'source'  => $source,
			'entry'   => (int) $entry_id,
			'message' => mb_substr( '' !== $message ? $message : __( 'Failed', 'cozy-addons' ), 0, 200 ),
		);
		update_option( self::OPTION, array_slice( $rows, -self::MAX ), false );
	}

	/**
	 * Logged errors, oldest first.
	 *
	 * @param string $source Only this service, or all when empty.
	 * @return array<int,array{id:int,time:int,source:string,entry:int,message:string}>
	 */
	public static function rows( $source = '' ) {
		$rows = get_option( self::OPTION, array() );
		$rows = is_array( $rows ) ? array_values( array_filter( $rows, 'is_array' ) ) : array();
		if ( '' !== $source ) {
			$rows = array_values(
				array_filter(
					$rows,
					static function ( $row ) use ( $source ) {
						return $source === $row['source'];
					}
				)
			);
		}

		return $rows;
	}

	/**
	 * ID of the newest error.
	 *
	 * @param string $source Only this service, or all when empty.
	 * @return int 0 when there is none.
	 */
	public static function latest_id( $source = '' ) {
		$rows = self::rows( $source );

		return $rows ? (int) end( $rows )['id'] : 0;
	}

	/**
	 * Empties the log.
	 *
	 * @return void
	 */
	public static function clear() {
		update_option( self::OPTION, array(), false );
	}

	/**
	 * Adds Error log under the Lead Forms menu, after Settings.
	 *
	 * @return void
	 */
	public static function menu() {
		add_submenu_page(
			'edit.php?post_type=' . Entry_Post_Type::TYPE,
			__( 'Error log', 'cozy-addons' ),
			__( 'Error log', 'cozy-addons' ),
			'manage_options',
			self::PAGE,
			array( __CLASS__, 'render' )
		);
	}

	/**
	 * Clears the log from its page.
	 *
	 * @return void
	 */
	public static function clear_action() {
		check_admin_referer( 'ca_form_clear_log' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to do that.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}
		self::clear();
		wp_safe_redirect( cozy_addons_form_admin_url( self::PAGE, array( 'cleared' => 1 ) ) );
		exit;
	}

	/**
	 * Renders the Error log page.
	 *
	 * @return void
	 */
	public static function render() {
		$sources = self::sources();
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only filter.
		$source = isset( $_GET['source'] ) ? sanitize_key( wp_unslash( $_GET['source'] ) ) : '';
		$source = isset( $sources[ $source ] ) ? $source : '';
		$rows   = array_reverse( self::rows( $source ) );
		$all    = self::rows();
		?>
		<div class="wrap ca-form-log">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'Error log', 'cozy-addons' ); ?></h1>
			<?php if ( $all ) : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ca-form-log__clear">
					<input type="hidden" name="action" value="ca_form_clear_log">
					<?php wp_nonce_field( 'ca_form_clear_log' ); ?>
					<button type="submit" class="button" onclick="return confirm( <?php echo esc_attr( wp_json_encode( __( 'Clear the whole error log?', 'cozy-addons' ) ) ); ?> );"><?php esc_html_e( 'Clear log', 'cozy-addons' ); ?></button>
				</form>
			<?php endif; ?>
			<hr class="wp-header-end">
			<?php // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only flag after the redirect. ?>
			<?php if ( isset( $_GET['cleared'] ) ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'The error log was cleared.', 'cozy-addons' ); ?></p></div>
			<?php endif; ?>
			<p class="description"><?php esc_html_e( 'Deliveries that failed after a form was submitted, newest first. Visitors never see these errors. The newest 200 are kept, without email addresses.', 'cozy-addons' ); ?></p>

			<ul class="subsubsub">
				<li><a href="<?php echo esc_url( cozy_addons_form_admin_url( self::PAGE ) ); ?>"<?php echo '' === $source ? ' class="current" aria-current="page"' : ''; ?>><?php esc_html_e( 'All', 'cozy-addons' ); ?> <span class="count">(<?php echo (int) count( $all ); ?>)</span></a></li>
				<?php foreach ( $sources as $slug => $name ) : ?>
					<li> | <a href="<?php echo esc_url( cozy_addons_form_admin_url( self::PAGE, array( 'source' => $slug ) ) ); ?>"<?php echo $slug === $source ? ' class="current" aria-current="page"' : ''; ?>><?php echo esc_html( $name ); ?> <span class="count">(<?php echo (int) count( self::rows( $slug ) ); ?>)</span></a></li>
				<?php endforeach; ?>
			</ul>
			<br class="clear">

			<div class="ca-leads-panel ca-leads-panel--wide">
				<?php if ( ! $rows ) : ?>
					<p><?php esc_html_e( 'No delivery errors. Failed Mailchimp, Brevo, webhook and email deliveries will be listed here.', 'cozy-addons' ); ?></p>
				<?php else : ?>
					<table class="ca-leads-data ca-form-log__table">
						<thead>
							<tr>
								<th scope="col"><?php esc_html_e( 'When', 'cozy-addons' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Service', 'cozy-addons' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Entry', 'cozy-addons' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Reason', 'cozy-addons' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $rows as $row ) : ?>
								<tr>
									<td title="<?php echo esc_attr( wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $row['time'] ) ); ?>">
										<?php
										/* translators: %s: time since, e.g. "5 mins" */
										echo esc_html( sprintf( __( '%s ago', 'cozy-addons' ), human_time_diff( $row['time'] ) ) );
										?>
									</td>
									<td><?php echo esc_html( $sources[ $row['source'] ] ?? $row['source'] ); ?></td>
									<td>
										<?php if ( $row['entry'] && Entry_Post_Type::TYPE === get_post_type( $row['entry'] ) ) : ?>
											<a href="<?php echo esc_url( (string) get_edit_post_link( $row['entry'] ) ); ?>">#<?php echo (int) $row['entry']; ?> – <?php echo esc_html( get_the_title( $row['entry'] ) ); ?></a>
										<?php elseif ( $row['entry'] ) : ?>
											#<?php echo (int) $row['entry']; ?> <span class="description"><?php esc_html_e( '(deleted)', 'cozy-addons' ); ?></span>
										<?php else : ?>
											–
										<?php endif; ?>
									</td>
									<td><?php echo esc_html( $row['message'] ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
