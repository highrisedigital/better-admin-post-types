<?php
/**
 * Declares general functions used throughout the plugin files
 *
 * @package better-admin-post-types
 */

/**
 * Gets the dashicon to use for a content block. If the post type was not
 * declared with a dashicon then the default post icon is returend.
 *
 * @param  obj $post_type_obj the post type object to retrieve the icon from.
 * @return string             the class name of the icon to return - defaults to 'dashicons-admin-post'.
 */
function bapt_get_content_block_dashicon( $post_type_obj ) {

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

	// return the menu icon string.
	return $menu_icon;

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
