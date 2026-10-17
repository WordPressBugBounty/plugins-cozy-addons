<?php
/**
 * Files attached to form entries: checking, private storage, download and clean-up.
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Keeps uploaded files out of the public uploads.
 *
 * Files are saved under uploads/cozy-addons-forms with random names, in folders that deny web
 * access. They are only ever served to users who can edit the entry, through download(), and
 * are deleted together with their entry.
 */
final class Form_Uploads {

	/**
	 * Folder under the uploads directory.
	 */
	const DIR = 'cozy-addons-forms';

	/**
	 * Registers the hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'before_delete_post', array( __CLASS__, 'delete_for_entry' ) );
		add_action( 'admin_post_ca_form_file', array( __CLASS__, 'download' ) );
	}

	/**
	 * File types visitors may upload: images and common documents. Never scripts, markup,
	 * SVG or archives.
	 *
	 * @return array<string,string> Extension pattern => mime type, as for wp_check_filetype().
	 */
	public static function allowed_types() {
		/**
		 * Filters the file types form visitors may upload.
		 *
		 * @param array<string,string> $types Extension pattern => mime type.
		 */
		return apply_filters(
			'cozy_addons_form_upload_types',
			array(
				'jpg|jpeg' => 'image/jpeg',
				'png'      => 'image/png',
				'gif'      => 'image/gif',
				'webp'     => 'image/webp',
				'pdf'      => 'application/pdf',
				'txt'      => 'text/plain',
				'doc'      => 'application/msword',
				'docx'     => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'xls'      => 'application/vnd.ms-excel',
				'xlsx'     => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'odt'      => 'application/vnd.oasis.opendocument.text',
			)
		);
	}

	/**
	 * Allowed extensions for the input's accept attribute, e.g. ".jpg,.jpeg,.png".
	 *
	 * @param bool $images_only Only image types, for image upload fields.
	 * @return string
	 */
	public static function accept( $images_only = false ) {
		$extensions = array();
		foreach ( array_keys( $images_only ? self::image_types() : self::allowed_types() ) as $pattern ) {
			foreach ( explode( '|', $pattern ) as $extension ) {
				$extensions[] = '.' . $extension;
			}
		}

		return implode( ',', $extensions );
	}

	/**
	 * Largest upload the server accepts, in whole megabytes, at most 20.
	 *
	 * @return int
	 */
	public static function server_limit_mb() {
		return max( 1, min( 20, (int) floor( wp_max_upload_size() / MB_IN_BYTES ) ) );
	}

	/**
	 * Picks one field's uploads out of the request's files.
	 *
	 * @param array  $files Files from the request, as in $_FILES.
	 * @param string $name  Field name.
	 * @param int    $max   Files the field takes: 1, or more for a multiple-file field (Pro).
	 * @return array{0:array,1:string} Uploads (name, tmp_name, error, size), empty when none was sent, and an error message.
	 */
	public static function from_request( array $files, $name, $max = 1 ) {
		$group = isset( $files['cozy_addons_form_f'] ) && is_array( $files['cozy_addons_form_f'] ) ? $files['cozy_addons_form_f'] : array();
		$keys  = array( 'name', 'tmp_name', 'error', 'size' );
		$max   = max( 1, (int) $max );
		foreach ( $keys as $key ) {
			if ( ! isset( $group[ $key ][ $name ] ) ) {
				return array( array(), '' );
			}
		}

		// A single-file field takes exactly one file; a multiple-file field a flat list.
		$is_list = is_array( $group['name'][ $name ] );
		if ( $is_list && 1 === $max ) {
			return array( array(), __( 'Please choose one file.', 'cozy-addons' ) );
		}
		$count = $is_list ? count( $group['name'][ $name ] ) : 1;
		if ( $count > 50 ) {
			return array( array(), __( 'Please enter a valid value.', 'cozy-addons' ) );
		}

		$uploads = array();
		foreach ( $is_list ? array_keys( $group['name'][ $name ] ) : array( null ) as $slot ) {
			$file = array();
			foreach ( $keys as $key ) {
				$value = null === $slot ? $group[ $key ][ $name ] : ( isset( $group[ $key ][ $name ][ $slot ] ) ? $group[ $key ][ $name ][ $slot ] : null );
				if ( ! is_scalar( $value ) ) {
					return array( array(), __( 'Please enter a valid value.', 'cozy-addons' ) );
				}
				$file[ $key ] = $value;
			}
			if ( UPLOAD_ERR_NO_FILE !== (int) $file['error'] ) {
				$uploads[] = $file;
			}
		}
		if ( count( $uploads ) > $max ) {
			return array(
				array(),
				sprintf(
					/* translators: %d: number of files */
					_n( 'You can upload up to %d file.', 'You can upload up to %d files.', $max, 'cozy-addons' ),
					$max
				),
			);
		}

		return array( $uploads, '' );
	}

	/**
	 * Checks a drawn signature (Pro), sent by the browser as a PNG data URL.
	 *
	 * @param mixed $raw Submitted value.
	 * @return array{0:?string,1:string} PNG bytes (null when nothing was drawn) and an error message.
	 */
	public static function validate_signature( $raw ) {
		$raw = is_string( $raw ) ? trim( $raw ) : '';
		if ( '' === $raw ) {
			return array( null, '' );
		}
		$invalid = __( 'The signature could not be read. Please sign again.', 'cozy-addons' );
		$prefix  = 'data:image/png;base64,';
		if ( strlen( $raw ) > 400 * KB_IN_BYTES || 0 !== strpos( $raw, $prefix ) ) {
			return array( null, $invalid );
		}
		$png = base64_decode( substr( $raw, strlen( $prefix ) ), true ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- Decoding the drawn image.
		if ( false === $png || 0 !== strpos( $png, "\x89PNG\r\n\x1a\n" ) ) {
			return array( null, $invalid );
		}
		$size = @getimagesizefromstring( $png ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- Broken images are handled.
		if ( ! $size || IMAGETYPE_PNG !== $size[2] || $size[0] < 1 || $size[1] < 1 || $size[0] > 3000 || $size[1] > 1500 ) {
			return array( null, $invalid );
		}

		return array( $png, '' );
	}

	/**
	 * Image types, for image upload fields (Pro).
	 *
	 * @return array<string,string> Extension pattern => mime type.
	 */
	public static function image_types() {
		return array_intersect_key(
			self::allowed_types(),
			array_flip( array( 'jpg|jpeg', 'png', 'gif', 'webp' ) )
		);
	}

	/**
	 * Checks an upload against the field's size limit and the allowed types.
	 *
	 * @param array $file        Upload from from_request().
	 * @param array $field       Field definition; "mx" is its size limit in MB.
	 * @param bool  $images_only Whether only images are accepted (image upload fields).
	 * @return array{0:?array,1:string} The checked upload with its real extension and mime type, and an error message.
	 */
	public static function validate( array $file, array $field, $images_only = false ) {
		$limit_mb = isset( $field['mx'] ) ? max( 1, min( self::server_limit_mb(), (int) $field['mx'] ) ) : self::server_limit_mb();
		$too_big  = sprintf(
			/* translators: %d: size limit in megabytes */
			__( 'The file is too large. The limit is %d MB.', 'cozy-addons' ),
			$limit_mb
		);

		$error = (int) $file['error'];
		if ( UPLOAD_ERR_INI_SIZE === $error || UPLOAD_ERR_FORM_SIZE === $error ) {
			return array( null, $too_big );
		}
		if ( UPLOAD_ERR_OK !== $error || ! is_uploaded_file( (string) $file['tmp_name'] ) ) {
			return array( null, __( 'The file could not be uploaded. Please try again.', 'cozy-addons' ) );
		}
		$size = (int) filesize( (string) $file['tmp_name'] );
		if ( $size <= 0 ) {
			return array( null, __( 'The file is empty.', 'cozy-addons' ) );
		}
		if ( $size > $limit_mb * MB_IN_BYTES ) {
			return array( null, $too_big );
		}

		// The extension must be allowed and match the file's real content.
		$types = $images_only ? self::image_types() : self::allowed_types();
		$check = wp_check_filetype_and_ext( (string) $file['tmp_name'], (string) $file['name'], $types );
		if ( empty( $check['ext'] ) || empty( $check['type'] ) ) {
			return array( null, $images_only ? __( 'Please choose an image (JPG, PNG, GIF or WebP).', 'cozy-addons' ) : __( 'This type of file is not allowed.', 'cozy-addons' ) );
		}
		// Images must really be images, and of a sane size.
		if ( 0 === strpos( $check['type'], 'image/' ) ) {
			$image = wp_getimagesize( (string) $file['tmp_name'] );
			if ( ! $image || $image[0] < 1 || $image[1] < 1 || $image[0] > 10000 || $image[1] > 10000 ) {
				return array( null, __( 'This image could not be read, or it is too large.', 'cozy-addons' ) );
			}
		}

		$name = sanitize_file_name( wp_basename( (string) $file['name'] ) );
		if ( '' === $name || '.' . $check['ext'] === $name ) {
			$name = 'file.' . $check['ext'];
		}

		return array(
			array(
				'tmp'  => (string) $file['tmp_name'],
				'name' => mb_substr( $name, -150 ),
				'ext'  => $check['ext'],
				'type' => $check['type'],
				'size' => $size,
			),
			'',
		);
	}

	/**
	 * Absolute path of the storage folder, without a trailing slash.
	 *
	 * @return string
	 */
	public static function base_dir() {
		$uploads = wp_get_upload_dir();

		return untrailingslashit( $uploads['basedir'] ) . '/' . self::DIR;
	}

	/**
	 * Creates a storage folder with files that keep web servers from listing or serving it.
	 *
	 * @param string $dir Absolute path.
	 * @return bool
	 */
	private static function protect( $dir ) {
		if ( ! wp_mkdir_p( $dir ) ) {
			return false;
		}
		// phpcs:disable WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents -- Small static files in our own folder.
		if ( ! file_exists( $dir . '/index.php' ) ) {
			file_put_contents( $dir . '/index.php', "<?php\n// Silence is golden.\n" );
		}
		if ( self::base_dir() === $dir && ! file_exists( $dir . '/.htaccess' ) ) {
			file_put_contents( $dir . '/.htaccess', "<IfModule mod_authz_core.c>\n\tRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n\tDeny from all\n</IfModule>\n" );
		}
		// phpcs:enable

		return true;
	}

	/**
	 * Moves a checked upload into private storage under a random name.
	 *
	 * @param array $upload Checked upload from validate().
	 * @return array|null Stored file: file (path inside the storage folder), name, size and type. Null on failure.
	 */
	public static function store( array $upload ) {
		$relative = self::new_path( $upload['ext'] );
		if ( '' === $relative || ! @move_uploaded_file( $upload['tmp'], self::base_dir() . '/' . $relative ) ) { // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- Failure is handled.
			return null;
		}
		chmod( self::base_dir() . '/' . $relative, 0640 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_chmod -- Our own file.

		return array(
			'file' => $relative,
			'name' => $upload['name'],
			'size' => (int) $upload['size'],
			'type' => $upload['type'],
		);
	}

	/**
	 * Saves generated file content, e.g. a drawn signature, into private storage.
	 *
	 * @param string $bytes File content.
	 * @param string $ext   Extension.
	 * @param string $type  Mime type.
	 * @param string $name  File name shown in the inbox.
	 * @return array|null Stored file like store(), or null on failure.
	 */
	public static function store_data( $bytes, $ext, $type, $name ) {
		$relative = self::new_path( $ext );
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents -- Our own private folder.
		if ( '' === $relative || false === file_put_contents( self::base_dir() . '/' . $relative, $bytes ) ) {
			return null;
		}
		chmod( self::base_dir() . '/' . $relative, 0640 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_chmod -- Our own file.

		return array(
			'file' => $relative,
			'name' => $name,
			'size' => strlen( $bytes ),
			'type' => $type,
		);
	}

	/**
	 * A new random path inside protected monthly folders.
	 *
	 * @param string $ext Extension.
	 * @return string Path inside the storage folder, or '' when the folders cannot be created.
	 */
	private static function new_path( $ext ) {
		$base = self::base_dir();
		$sub  = gmdate( 'Y/m' );
		if ( ! self::protect( $base ) || ! self::protect( $base . '/' . gmdate( 'Y' ) ) || ! self::protect( $base . '/' . $sub ) ) {
			return '';
		}

		return $sub . '/' . bin2hex( random_bytes( 16 ) ) . '.' . sanitize_key( $ext );
	}

	/**
	 * A field's stored files as a list. Entries saved before multiple files existed hold one file.
	 *
	 * @param mixed  $files Stored files keyed by field name, from the _ca_form_files meta.
	 * @param string $name  Field name.
	 * @return array[]
	 */
	public static function field_files( $files, $name ) {
		$stored = is_array( $files ) && isset( $files[ $name ] ) && is_array( $files[ $name ] ) ? $files[ $name ] : array();

		return isset( $stored['file'] ) ? array( $stored ) : array_values( array_filter( $stored, 'is_array' ) );
	}

	/**
	 * Absolute path of a stored file, only when it really is inside the storage folder.
	 *
	 * @param array $stored Stored file from store().
	 * @return string Path, or '' when it is missing or outside the folder.
	 */
	public static function path( $stored ) {
		if ( ! is_array( $stored ) || empty( $stored['file'] ) || ! is_string( $stored['file'] ) ) {
			return '';
		}
		$base = realpath( self::base_dir() );
		$path = realpath( self::base_dir() . '/' . $stored['file'] );
		if ( false === $base || false === $path || 0 !== strpos( $path, $base . DIRECTORY_SEPARATOR ) || ! is_file( $path ) ) {
			return '';
		}

		return $path;
	}

	/**
	 * Deletes stored files.
	 *
	 * @param array $files Stored files keyed by field name.
	 * @return void
	 */
	public static function delete_files( array $files ) {
		foreach ( array_keys( $files ) as $name ) {
			foreach ( self::field_files( $files, $name ) as $stored ) {
				$path = self::path( $stored );
				if ( '' !== $path ) {
					wp_delete_file( $path );
				}
			}
		}
	}

	/**
	 * Deletes an entry's files when the entry is deleted, whichever way: by hand, retention,
	 * spam clean-up or a privacy erasure request.
	 *
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public static function delete_for_entry( $post_id ) {
		if ( Entry_Post_Type::TYPE !== get_post_type( $post_id ) ) {
			return;
		}
		$files = get_post_meta( $post_id, '_ca_form_files', true );
		if ( is_array( $files ) ) {
			self::delete_files( $files );
		}
	}

	/**
	 * Link that downloads an entry's file, for users who can edit the entry.
	 *
	 * @param int    $entry_id Entry ID.
	 * @param string $field    Field name.
	 * @param int    $index    Position of the file in the field's list.
	 * @param bool   $inline   Show an image in the page instead of downloading it.
	 * @return string
	 */
	public static function download_url( $entry_id, $field, $index = 0, $inline = false ) {
		$args = array(
			'action' => 'ca_form_file',
			'entry'  => (int) $entry_id,
			'field'  => sanitize_key( $field ),
			'i'      => (int) $index,
		);
		if ( $inline ) {
			$args['inline'] = 1;
		}

		return wp_nonce_url(
			add_query_arg( $args, admin_url( 'admin-post.php' ) ),
			'ca_form_file_' . (int) $entry_id . '_' . sanitize_key( $field )
		);
	}

	/**
	 * Sends an entry's file as a download. The path comes from the entry, never from the request.
	 *
	 * @return void
	 */
	public static function download() {
		$entry_id = isset( $_GET['entry'] ) ? absint( $_GET['entry'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Verified below.
		$field    = isset( $_GET['field'] ) ? sanitize_key( wp_unslash( $_GET['field'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Verified below.

		check_admin_referer( 'ca_form_file_' . $entry_id . '_' . $field );
		if ( ! $entry_id || Entry_Post_Type::TYPE !== get_post_type( $entry_id ) || ! current_user_can( 'edit_post', $entry_id ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to download this file.', 'cozy-addons' ), '', array( 'response' => 403 ) );
		}

		$index = isset( $_GET['i'] ) ? absint( $_GET['i'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Verified above.
		$list  = self::field_files( get_post_meta( $entry_id, '_ca_form_files', true ), $field );
		$file  = isset( $list[ $index ] ) ? $list[ $index ] : null;
		$path  = self::path( $file );
		if ( '' === $path ) {
			wp_die( esc_html__( 'This file is no longer available.', 'cozy-addons' ), '', array( 'response' => 404 ) );
		}

		// Images and signatures can be shown in the inbox. Everything else is only downloaded.
		$type   = isset( $file['type'] ) ? (string) $file['type'] : '';
		$inline = ! empty( $_GET['inline'] ) && in_array( $type, array_values( self::image_types() ), true ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Verified above.
		$name   = str_replace( array( '"', "\r", "\n" ), '', sanitize_file_name( (string) $file['name'] ) );
		nocache_headers();
		header( 'Content-Type: ' . ( $inline ? $type : 'application/octet-stream' ) );
		header( 'Content-Disposition: ' . ( $inline ? 'inline' : 'attachment' ) . '; filename="' . $name . '"' );
		header( 'Content-Length: ' . filesize( $path ) );
		header( 'X-Content-Type-Options: nosniff' );
		header( "Content-Security-Policy: default-src 'none'; sandbox" );
		readfile( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_readfile -- Streaming a private file.
		exit;
	}
}
