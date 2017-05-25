<?php
/**
 * Declares general functions used throughout the plugin files
 *
 * @package better-admin-post-types
 */

/**
 * Gets the menu icon to use for a content block.
 *
 * Checks to see if the post type was registered with an inline SVG
 * icon or a URL to an icon image first and returns a hint instead
 * of the dashicon name. If the post type was not declared with a
 * dashicon then the default post icon is returned.
 *
 * @see register_post_type() for $post_type_obj properties.
 *
 * @param  WP_Post_Type $post_type_obj the post type object to retrieve the icon from.
 * @return string             the class name of the icon to return - defaults to 'dashicons-admin-post'.
 */
function bapt_get_content_block_dashicon( $post_type_obj ) {
	if ( null !== $post_type_obj->menu_icon ) {

		// Checks for an inline SVG passed as the menu icon.
		if ( 0 === strpos( $post_type_obj->menu_icon, 'data:image/svg+xml;' ) ) {
			return 'svg';
		}

		// Checks for a URL to an icon file.
		if ( 0 === strpos( $post_type_obj->menu_icon, 'http' ) ) {
			return 'url';
		}

		// 'none' or dashicon.
		return $post_type_obj->menu_icon;
	}

	if ( 'page' === $post_type_obj->name ) {
		return 'dashicons-admin-page';
	}

	return 'dashicons-admin-post';
}

/**
 * Adds the post type description to the content block after the title.
 *
 * @param  object $post_type_obj the post type object for this content block.
 */
function bapt_content_block_description( $post_type_obj ) {

	// echo the post type description.
	echo wp_kses_post( wpautop( $post_type_obj->description ) );

}

add_action( 'bapt_content_block_after_title', 'bapt_content_block_description', 20, 1 );

/**
 * Outputs the content blocks post type actions. Buttons for view all and add new
 *
 * @param  obj $post_type_obj the post type object to set the actions for.
 */
function bapt_content_block_post_type_actions( $post_type_obj ) {

	?>

	<div class="bapt-content-actions">

		<h4><?php esc_html_e( 'Actions', 'better-admin-post-types' ); ?></h4>

		<div class="bapt-content-actions__links">
			<a class="page-title-action post-type-button view-all" href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $post_type_obj->name ) ); ?>"><?php esc_html_e( 'View All', 'better-admin-post-types' ); ?></a>
			<a class="page-title-action post-type-button add-new" href="<?php echo esc_url( admin_url( '/post-new.php?post_type=' . $post_type_obj->name ) ); ?>"><?php esc_html_e( 'Add New', 'better-admin-post-types' ); ?></a>
		</div>

		<?php

			// Output the taxonomy links for this post type.
			bapt_post_type_taxonomy_buttons( $post_type_obj->name, true );

		?>

	</div><!-- // bapt-content-actions -->

	<?php

}

add_action( 'bapt_content_block_after_title', 'bapt_content_block_post_type_actions', 30, 1 );
