<?php
/**
 * Functions which output the page content for the admin menu items
 *
 * @package better-admin-post-types
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

			<h1 class="bapt-content-title"><?php esc_html( get_admin_page_title() ); ?></h1>

			<div class="bapt-content-wrapper metabox-holder">

				<?php

				// Add an action before the content blocks are outputted.
				do_action( 'bapt_before_content_blocks' );

				// Loop through each post type.
				foreach ( $post_types as $post_type ) {

					// Get this post types object.
					$post_type_obj = get_post_type_object( $post_type );
					$post_icon     = bapt_get_content_block_dashicon( $post_type_obj );
					?>

					<div class="postbox bapt-content-block bapt-content-block-<?php esc_attr_e( $post_type ); ?>">

						<?php

						/**
						 * Action fired before the content block title.
						 *
						 * @param obj $post_type_obj the post type object for this content block.
						 */
						do_action( 'bapt_content_block_before_title', $post_type_obj );

						?>

						<h2 class="hndle ui-sortable-handle">
							<?php if ( 'url' === $post_icon ) : ?>
								<img src="<?php echo esc_url( $post_type_obj->menu_icon ); ?>" class="dashicons">
							<?php elseif ( 'svg' === $post_icon ) : ?>
								<img src="<?php echo esc_attr( $post_type_obj->menu_icon ); ?>" class="dashicons svg">
							<?php else : ?>
								<span class="dashicons <?php echo esc_attr( $post_icon ); ?>"></span>
							<?php endif; ?>
							<?php echo esc_html( $post_type_obj->labels->name ); ?>
						</h2>

						<div class="inside">

							<?php

							/**
							 * Action fired after the content block title.
							 *
							 * @param obj $post_type_obj the post type object for this content block.
							 * @hooked - bapt_content_block_description - 20
							 * @hooked - bapt_content_block_post_type_actions - 30
							 */
							do_action( 'bapt_content_block_after_title', $post_type_obj );

							?>

						</div><!-- // inside -->
					
					</div><!-- // postbox -->

					<?php

				} // End foreach().

				// Add an action after the content blocks are outputted.
				do_action( 'bapt_after_content_blocks' );

				?>

			</div><!-- // bapt-content-wrapper -->

		</div><!-- // wrap -->

		<?php

	} // End if().

}
