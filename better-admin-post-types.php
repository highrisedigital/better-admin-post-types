<?php
/**
 * Plugin Name: Better Admin Post Types
 * Plugin URI: https://highrise.digital
 * Description: Provides a better interface for sites which have lots of post types, consolidating them into a content menu item.
 * Version: 1.0
 * Author: Highrise Digital Ltd
 * Author URI: https://highrise.digital
 * License: GPLv2 or later
 * Text Domain: better-admin-post-types
 *
 * @package better-admin-post-types
 */

/**
 * Copyright (c) 2016 Highrise Digitial Ltd. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

// Exit if directly accessed.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* define variable for path to this plugin file. */
define( 'BAPT_PATH', dirname( __FILE__ ) );
define( 'BAPT_URL', plugins_url( '', __FILE__ ) );

/**
 * Load plugin textdomain.
 */
function bapt_load_textdomain() {
	load_plugin_textdomain( 'better-admin-post-types', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'bapt_load_textdomain' );

// Admin includes.
require_once( dirname( __FILE__ ) . '/inc/admin/admin-menus.php' );
require_once( dirname( __FILE__ ) . '/inc/admin/admin-menu-content.php' );
require_once( dirname( __FILE__ ) . '/inc/admin/admin.php' );
require_once( dirname( __FILE__ ) . '/inc/enqueue.php' );
