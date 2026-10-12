<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle migration form submission (triggered by button in settings page)
 */
add_action( 'init', function () {
	// Check if our migration form was submitted
	if ( isset( $_POST['clrestaurant_migrate_action'] ) && $_POST['clrestaurant_migrate_action'] == '1' ) {

		// Capability check
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Nonce check
		if ( empty( $_POST['clrestaurant_migrate_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['clrestaurant_migrate_nonce'] ) ), 'clrestaurant_migrate_old_data' ) ) {
			wp_die( esc_html__( 'Security check failed.', 'clrestaurant' ) );
		}

		// Prevent re-run if already migrated
		if ( get_option( 'rtcl_clrestaurant_data_migrated' ) ) {
			return;
		}

		// Run your migration function
		if ( function_exists( 'migrate_clrestaurant_form_data' ) ) {
			migrate_clrestaurant_form_data();
		}

		// Mark as migrated
		update_option( 'rtcl_clrestaurant_data_migrated', 1 );

		// Redirect back to avoid resubmission on page reload
		wp_safe_redirect( wp_get_referer() ?: admin_url() );
		exit;
	}
} );

/**
 * @param $post_id
 *
 * @return void
 */
function clrestaurant_migrate_food_menu( $post_id = 0 ) {
	global $wpdb;

	$old_data = get_post_meta( $post_id, 'listing_food_list', true );
	if ( ! empty( $old_data ) && is_array( $old_data ) ) {
		$new_data = [];

		foreach ( $old_data as $group ) {
			// Group Title Row
			$new_data[] = [
				'enable_group_title' => 'yes',
				'menu_name'          => $group['gtitle'] ?? '',
			];

			// Menu Items
			if ( ! empty( $group['food_list'] ) && is_array( $group['food_list'] ) ) {
				foreach ( $group['food_list'] as $item ) {
					$menu_item     = [
						'enable_group_title' => 'no',
						'menu_name'          => $item['title'] ?? '',
						'menu_desc'          => $item['description'] ?? '',
						'menu_price'         => $item['foodprice'] ?? '',
					];
					$attachment_id = (int) $item['attachment_id'];
					if ( ! empty( $attachment_id ) && is_numeric( $attachment_id ) ) {
						$newAttachementId = duplicate_media_by_id( $attachment_id, $post_id );
						// Update the attachment
						if ( ! empty( $newAttachementId ) ) {
							update_post_meta( $newAttachementId, '_rtcl_attachment_type', 'file' );
							$menu_item['menu_img'] = [ $newAttachementId ];
						}
					}

					$new_data[] = $menu_item;
				}
			}
		}
		// Save new meta
		update_post_meta( $post_id, 'rtcl_clrestaurant_food_list', $new_data );
	}
}

/**
 * @param $media_id
 * @param $post_id
 *
 * @return int|WP_Error
 */
function duplicate_media_by_id( $media_id, $post_id = 0 ) {
	$post = get_post( $media_id );

	if ( ! $post || 'attachment' !== $post->post_type ) {
		return new WP_Error( 'invalid_media', __( 'Invalid media ID.' ) );
	}

	$file = get_attached_file( $media_id );

	if ( ! file_exists( $file ) ) {
		return new WP_Error( 'missing_file', __( 'Original file does not exist.' ) );
	}

	$file_info = pathinfo( $file );
	$new_filename = wp_unique_filename( $file_info['dirname'], $file_info['basename'] );
	$new_file     = trailingslashit( $file_info['dirname'] ) . $new_filename;

	if ( ! copy( $file, $new_file ) ) {
		return new WP_Error( 'copy_failed', __( 'File could not be copied.' ) );
	}

	// Get upload directory info
	$wp_upload_dir = wp_upload_dir();
	$upload_baseurl = $wp_upload_dir['baseurl'];

	// Find relative path under uploads directory
	$relative_path = str_replace( trailingslashit( $wp_upload_dir['basedir'] ), '', $new_file );
	$file_url      = trailingslashit( $upload_baseurl ) . $relative_path;

	$attachment = array(
		'post_mime_type' => $post->post_mime_type,
		'post_title'     => $post->post_title . ' (Copy)',
		'post_content'   => $post->post_content,
		'post_excerpt'   => $post->post_excerpt,
		'post_status'    => 'inherit',
		'post_parent'    => $post_id,
		'guid'           => $file_url, // Important: real file URL, not a permalink.
	);

	$new_attachment_id = wp_insert_attachment( $attachment, $new_file );

	if ( is_wp_error( $new_attachment_id ) ) {
		return $new_attachment_id;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	$attach_data = wp_generate_attachment_metadata( $new_attachment_id, $new_file );
	wp_update_attachment_metadata( $new_attachment_id, $attach_data );

	return $new_attachment_id;
}

function migrate_clrestaurant_form_data() {
	try {
		$post_ids = get_posts( [
			'post_type'      => 'rtcl_listing',
			'post_status'    => 'any',
			'posts_per_page' => - 1,
			'fields'         => 'ids',
		] );
		foreach ( $post_ids as $post_id ) {
			clrestaurant_migrate_food_menu( $post_id );
		}
		update_option( 'rtcl_clrestaurant_data_migrated', 1 );
	} catch ( Throwable $e ) {
		error_log( 'Listing data migration failed: ' . $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	}
}

/**
 * Inject migration Status + Trigger button into RTCL general settings options.
 *
 * Place this in the same plugin file (below your migration functions).
 */
function clrestaurant_add_migration_settings_field( $options ) {
	// Add section header (if not already present in your options)
	$options['old_data_migration_section'] = [
		'title' => esc_html__( 'Old Data Migration', 'clrestaurant' ),
		'type'  => 'section',
	];

	// Status HTML
	$migrated    = get_option( 'rtcl_clrestaurant_data_migrated' );
	$last_errors = get_option( 'rtcl_clrestaurant_data_migration_last_errors', [] );

	$status_html = '<div id="clrestaurant-migration-status">';
	if ( $migrated ) {
		$when        = is_array( $migrated ) && ! empty( $migrated['at'] ) ? esc_html( $migrated['at'] ) : '';
		$status_html .= '<p><strong style="color:green;">' . esc_html__( 'Migration status: DONE', 'clrestaurant' ) . '</strong>';
		if ( $when ) {
			$status_html .= '<br><small>' . $when . '</small>';
		}
		$status_html .= '</p>';
	} else {
		$status_html .= '<p><strong>' . esc_html__( 'Migration status: Not yet run', 'clrestaurant' ) . '</strong></p>';
	}

	if ( ! empty( $last_errors['errors'] ) ) {
		$status_html .= '<p style="color:#d63638;">' . esc_html__( 'Last run had errors. Check logs.', 'clrestaurant' ) . '</p>';
	}
	$status_html .= '</div>';

	$options['clrestaurant_migration_status'] = [
		'title' => esc_html__( 'Status', 'clrestaurant' ),
		'type'  => 'html',
		'html'  => $status_html,
	];

	// Button/form HTML (simple POST; handled by admin_init handler below)
	$button_html = '';
	ob_start();
	?>
    <div id="clrestaurant-migration-wrap" style="margin-top:8px;">
        <form method="post" class="clrestaurant-migration-form" style="margin:0;">
			<?php wp_nonce_field( 'clrestaurant_migrate_old_data', 'clrestaurant_migrate_nonce' ); ?>
            <input type="hidden" name="clrestaurant_migrate_action" value="1"/>
            <p>
                <button type="submit" class="button button-primary" name="clrestaurant_migrate" value="1"
					<?php disabled( (bool) $migrated ); ?>>
					<?php echo esc_html( $migrated ? __( 'Already Migrated', 'clrestaurant' ) : __( 'Run Migration', 'clrestaurant' ) ); ?>

                </button>
                <span style="margin-left:10px; color:#666;"><?php esc_html_e( 'This runs the one-time old-data migration.', 'clrestaurant' ); ?></span>
            </p>
        </form>
    </div>
	<?php
	$button_html = ob_get_clean();

	$options['clrestaurant_migration_button'] = [
		'title' => esc_html__( 'Trigger', 'clrestaurant' ),
		'type'  => 'html',
		'html'  => $button_html,
	];

	return $options;
}

add_filter( 'rtcl_general_settings_options', 'clrestaurant_add_migration_settings_field', 20 );


/**
 * Handle migration form submission (admin POST).
 * - Checks capability and nonce.
 * - Prevents re-run if option already set.
 * - Calls migrate_clrestaurant_form_data() (should already exist above).
 */
function clrestaurant_handle_migration_form_submission() {
	// Only process admin POST requests
	if ( ! is_admin() || 'POST' !== strtoupper( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ?? '' ) ) ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
		return;
	}

	// Was our form submitted?
	if ( empty( $_POST['clrestaurant_migrate_action'] ) ) {
		return;
	}

	// Capability check
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Nonce check
	if ( empty( $_POST['clrestaurant_migrate_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['clrestaurant_migrate_nonce'] ) ), 'clrestaurant_migrate_old_data' ) ) {
		// Invalid nonce — redirect back quietly
		if ( ! headers_sent() ) {
			wp_safe_redirect( wp_get_referer() ?: admin_url() );
			exit;
		}

		return;
	}

	// Prevent accidental re-run
	if ( get_option( 'rtcl_clrestaurant_data_migrated' ) ) {
		if ( ! headers_sent() ) {
			wp_safe_redirect( wp_get_referer() ?: admin_url() );
			exit;
		}

		return;
	}

	try {
		if ( function_exists( 'migrate_clrestaurant_form_data' ) ) {
			migrate_clrestaurant_form_data();
		} else {
			error_log( '[clrestaurant_migration] migrate_clrestaurant_form_data() not found.' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		}
	} catch ( Throwable $e ) {
		error_log( '[clrestaurant_migration] Exception during migration: ' . $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		// Optionally save last error for status display:
		update_option( 'rtcl_clrestaurant_data_migration_last_errors', [
			'at'     => current_time( 'mysql' ),
			'errors' => [ $e->getMessage() ],
		], false );
	}

	// PRG: redirect back to avoid resubmission on refresh
	if ( ! headers_sent() ) {
		wp_safe_redirect( wp_get_referer() ?: admin_url() );
		exit;
	}
}

add_action( 'init', 'clrestaurant_handle_migration_form_submission' );
