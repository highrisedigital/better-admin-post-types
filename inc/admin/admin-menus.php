<?php
/**
 * Creates the admin menus
 *
 * @package better-admin-post-types
 * @since 0.1
 */

/**
 * Adds the admin menus for the plugin
 */
function bapt_admin_menus() {

	// Add the menu for content.
	add_menu_page(
		__( 'Content', 'better-admin-post-types' ),
		__( 'Content', 'better-admin-post-types' ),
		'edit_posts',
		'bapt_content',
		'bapt_content_page',
		'dashicons-admin-page',
		4 // Make sure the content menu item comes first.
	);

	// Get the post types to add as content sub menu items.
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
	$post_types = apply_filters( 'bapt_content_submenu_post_types', $post_types );

	// Check we have post types to action.
	if ( ! empty( $post_types ) ) {

		// Loop through each post type.
		foreach ( $post_types as $post_type ) {

			// Get this post types object.
			$post_type_obj = get_post_type_object( $post_type );

			// add the sub page menu item.
			add_submenu_page(
				'bapt_content',
				$post_type_obj->labels->name,
				$post_type_obj->labels->menu_name,
				'edit_posts',
				'edit.php?post_type=' . $post_type
			);

		} // End foreach().
	} // End if().

	// create an array for menu items to remove.
	$menu_items = array(
		'edit.php',
		'edit.php?post_type=page',
	);

	// get all the post types where we should show ui for.
	$post_types = get_post_types(
		array(
			'show_ui' => true,
		)
	);

	// if attachments is in the post types array.
	if ( isset( $post_types['attachment'] ) ) {

		// remove attachments.
		unset( $post_types['attachment'] );

	}

	// check we have post types to action.
	if ( ! empty( $post_types ) ) {

		// loop through each post type.
		foreach ( $post_types as $post_type ) {

			// get this post types object.
			$post_type_obj = get_post_type_object( $post_type );

			// if this post type is post.
			if ( 'post' === $post_type ) {

				// add this post type to the menu items array.
				$menu_items[ $post_type_obj->name ] = 'edit.php';

			} else { // any post type except post.

				// add this post type to the menu items array.
				$menu_items[ $post_type_obj->name ] = 'edit.php?post_type=' . $post_type;

			}
		}
	} // End if().

	// allow the array to be filtered.
	$menu_items = apply_filters( 'bapt_removed_admin_menus', $menu_items );

	// loop through each of the items from our array.
	foreach ( $menu_items as $menu_item ) {

		// reomve the menu item.
		remove_menu_page( $menu_item );

	}

}

add_action( 'admin_menu', 'bapt_admin_menus' );

/**
 * Corrects the taxonomy parent file so the content menu stays open when view taxonomy listing.
 *
 * @param  string $parent_file the name of the current parent file.
 * @return string              the name of the modified parent file.
 */
function bapt_tax_menu_correction( $parent_file ) {

	// get all the taxonomies which would normally show in the menu.
	$taxonomies = get_taxonomies(
		array(
			'show_in_menu' => true,
		)
	);

	// filter the list of taxonomies.
	$taxonomies = apply_filters( 'bapt_tax_menu_correction_taxonomies', $taxonomies );

	// if we have registered taxonomies.
	if ( ! empty( $taxonomies ) ) {

		foreach ( $taxonomies as $taxonomy ) {

			/* set the parent file slug to the sen main page */
			$parent_file = 'bapt_content';

		}
	}

	// return the new parent file.
	return $parent_file;

}

add_action( 'parent_file', 'bapt_tax_menu_correction' );
