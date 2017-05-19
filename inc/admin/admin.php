<?php
/**
 * Admin functions
 *
 * @package better-admin-post-types
 * @since 1.0
 */

/**
 * Removes post types that probably have their own top level menu item
 *
 * @param  array $post_types current array of post types.
 * @return array             the newly modified array of post types.
 */
function bapt_remove_post_types_from_content_section( $post_types ) {

	// if we have post types.
	if ( ! empty( $post_types ) ) {

		// loop through each post type.
		foreach ( $post_types as $post_type ) {

			// get this post types object.
			$post_type_obj = get_post_type_object( $post_type );

			// if we should not show this post type in the menu - it probably has its own menu.
			if ( true !== $post_type_obj->show_in_menu ) {

				// unset or remove this post type from the array.
				unset( $post_types[ $post_type ] );

			} // End if().
		} // End foreach().
	} // End if().
	// return the modified post type array.
	return $post_types;

}

add_filter( 'bapt_content_submenu_post_types', 'bapt_remove_post_types_from_content_section', 10, 1 );
add_filter( 'bapt_content_page_post_types', 'bapt_remove_post_types_from_content_section', 10, 1 );

/**
 * Ddits the registered post type arguments for the built in posts types.
 * Notably this set show in menu to false and adds a description.
 *
 * @param  array  $args       an array of the registered post type args.
 * @param  string $post_type the name of the post type.
 * @return array             the modified array of register post type args.
 */
function bapt_edit_built_in_post_type_args( $args, $post_type ) {

	// create an array of post types to add descriptions to.
	$post_types = apply_filters(
		'bapt_edit_built_in_post_types',
		array(
			'post'	=> 'posts',
			'page'	=> 'pages'
		)
	);

	// if we have have posts to describe.
	if ( ! empty( $post_types ) ) {

		// if this post type is in our list to describe.
		if ( isset( $post_types[ $post_type ] ) ) {

			// if the post type is posts.
			if ( 'post' === $post_type ) {

				// set the description string.
				$post_desc = __( 'Posts are your sites news or blog.', 'hd-basement' );

			}

			// if the post type is pages.
			if ( 'page' === $post_type ) {

				// set the description string.
				$post_desc = __( 'Pages are good for your sites static content.', 'hd-basement' );

			}

			// add the post type description.
			$args['description'] = esc_html( $post_desc );

		} // End if().
	} // End if().

	// return the modified args.
	return $args;

}

add_filter( 'register_post_type_args', 'bapt_edit_built_in_post_type_args', 10, 2 );

/**
 * Outputs the taxonomy buttons for each of the post post_types.
 *
 * @param  string  $post_type  post type to get the buttons for.
 * @param  boolean $show_title true (default) to show the title above the buttons false otherwise.
 */
function bapt_post_type_taxonomy_buttons( $post_type = '', $show_title = true ) {

	// Add an action before the taxonomy buttons are outputted
	do_action( 'bapt_before_post_type_taxonomy_buttons', $post_type, $show_title );

	// get the taxonomies associated with this post type.
	$taxonomies = get_object_taxonomies( $post_type, 'object' );

	// if we have taxonomies.
	if ( ! empty( $taxonomies ) ) {

		?>

		<div class="bapt-post-type-taxonomies">

			<?php

			// if we are showing the title.
			if ( true === $show_title ) {

				// outputt the title.
				?>
				<h4><?php esc_html_e( 'Content Taxonomies', 'better-admin-post-types' ); ?></h4>
				<?php

			}

			// loop through each taxonomy.
			foreach ( $taxonomies as $taxonomy ) {

				// if this taxonomy should not show in the WordPress admin menu.
				if ( false === $taxonomy->show_in_menu ) {
					continue;
				}

				?>
				<a class="page-title-action tax-button" href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=' . $taxonomy->name ) ); ?>"><?php echo esc_html( $taxonomy->label ); ?></a>
				<?php

			} // End foreach().

			?>

		</div><!-- // hd-basement-post-type-taxonomies -->

		<?php

	} // End if().

	// Add an action after the taxonomy buttons are outputted
	do_action( 'bapt_after_post_type_taxonomy_buttons', $post_type, $show_title );

}

/**
 * Outputs the taxonomy buttons on the post type listing page.
 * They are outputted in the admin notices area.
 */
function bapt_post_listing_taxonomy_links() {

	// get the current admin screen.
	$screen = get_current_screen();

	// if we have a post type.
	if ( '' !== $screen->post_type ) {

		// get the post type object.
		$post_type_obj = get_post_type_object( $screen->post_type );

		// if we should not show this post type in the menu - it probably has its own menu.
		if ( true !== $post_type_obj->show_in_menu ) {
			return; // do nothing
		} // End if().
	}

	// if the screen base is a post listing screen.
	if ( 'edit' === $screen->base ) {

		// output the taxonomy buttons.
		bapt_post_type_taxonomy_buttons( $screen->post_type, false );

	}

}

add_action( 'all_admin_notices', 'bapt_post_listing_taxonomy_links' );
