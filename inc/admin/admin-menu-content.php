<?php
/**
 * Functions which output the page content for the admin menu items
 *
 * @package better-admin-post-types
 * @since 1.0
 */

/**
 * Outputs the contents of the admin page for the content menu item
 */
function bapt_content_page() {

	// Get all the post types where we should show ui for.
	$post_types = get_post_types(
		array(
			'show_ui' => true,
		)
	);

	// If attachments is in the post types array.
	if ( isset( $post_types['attachment'] ) ) {

		// Remove attachments.
		unset( $post_types['attachment'] );

	}

	// Allow post types to be filterable.
	$post_types = apply_filters( 'bapt_content_page_post_types', $post_types );

	// Check we have post types to action.
	if ( ! empty( $post_types ) ) {

		?>
		<div class="wrap">

			<h1 class="bapt-content-title"><?php esc_html_e( 'Content', 'better-admin-post-types' ); ?></h1>

			<div class="bapt-content-wrapper metabox-holder">

				<?php

				// Add an action before the content blocks are outputted
				do_action( 'bapt_before_content_blocks' );

				// Loop through each post type.
				foreach ( $post_types as $post_type ) {

					// Get this post types object.
					$post_type_obj = get_post_type_object( $post_type );

					?>

					<div class="postbox bapt-content-block">

						<?php

						// Set a default menu icon.
						$menu_icon = 'dashicons-admin-post';

						// If no menu icon is declared.
						if ( null === $post_type_obj->menu_icon ) {

							// If this post type is a page.
							if ( 'page' === $post_type_obj->name ) {

								// Set the menu icon to be the page icon.
								$menu_icon = 'dashicons-admin-page';

							} // End if().
						} else { // We have a menu icon declared.

							// Set the menu icon to that declared in register post type.
							$menu_icon = $post_type_obj->menu_icon;

						}

						?>

						<h2 class="hndle ui-sortable-handle"><span class="dashicons <?php echo esc_attr( $menu_icon ); ?>"></span> <?php echo esc_html( $post_type_obj->labels->name ); ?></h2>

						<div class="inside">

							<?php

								// Output the post type description.
								echo wp_kses_post( wpautop( $post_type_obj->description ) );

							?>

							<div class="bapt-content-actions">

								<h4><?php esc_html_e( 'Actions', 'better-admin-post-types' ); ?></h4>

								<div class="bapt-content-actions__links">
									<a class="page-title-action post-type-button view-all" href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ); ?>"><?php esc_html_e( 'View All', 'better-admin-post-types' ); ?></a>
									<a class="page-title-action post-type-button add-new" href="<?php echo esc_url( admin_url( '/post-new.php?post_type=' . $post_type ) ); ?>"><?php esc_html_e( 'Add New', 'better-admin-post-types' ); ?></a>
								</div>

								<?php

									// Output the taxonomy links for this post type.
									bapt_post_type_taxonomy_buttons( $post_type, true );

								?>

							</div><!-- // bapt-content-actions -->

						</div><!-- // inside -->
					
					</div><!-- // postbox -->

					<?php

				} // End foreach().

				// Add an action after the content blocks are outputted
				do_action( 'bapt_after_content_blocks' );

				?>

			</div><!-- // bapt-content-wrapper -->

		</div><!-- // wrap -->

		<?php

	} // End if().

}
