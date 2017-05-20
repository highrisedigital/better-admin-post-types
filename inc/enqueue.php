<?php
/**
 * Enqueues any javascript and stylsheets for the plugin
 *
 * @package better-admin-post-types
 * @since  0.1
 */

/**
 * Enqueues the scripts and styles for the WordPress admin area
 */
function bapt_enqueue_admin_scripts_styles() {

	// enqueue the admin stylesheet for the plugin.
	wp_enqueue_style( 'bapt_admin_styles', BAPT_URL . '/assets/css/bapt-styles.css' );

}

add_action( 'admin_enqueue_scripts', 'bapt_enqueue_admin_scripts_styles' );
