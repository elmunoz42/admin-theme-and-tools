
<?php

/**
* Plugin Name: AAAdmin Boss
* Description: Admin Theme, Functionality & Dev Tools
* Author: Carlos Munoz Kampff - CMK Web & Digital Arts
* Version: 0.2
* License:     GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.txt
*/

// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version
// 2 of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// with this program. If not, visit: https://www.gnu.org/licenses/


// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// Add custom color scheme
function additional_admin_color_schemes() {
  //Get the theme directory
  // $theme_dir = get_template_directory_uri();
	//
  // //Ocean
	$plugin_dir = plugin_dir_url( dirname( __FILE__ ) ) ;
  wp_admin_css_color( 'fountain', __( 'Fountain' ),
    $plugin_dir . 'aaadmin-boss/public/css/colors.css',
    array( '#2a3db6', '#00ffd5', '#00e6c0', '#313541' )
  );
  // var_dump($plugin_dir . 'aaadmin-boss/public/css/colors.css');die;
}
add_action('admin_init', 'additional_admin_color_schemes');


// include plugin dependencies: admin only
if ( is_admin() ) {

	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/dashboard-page.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/login-logo-page.php';

}


// include plugin dependencies: admin and public
require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php';



// default plugin options
function ab_options_default() {

	return array(
		'custom_url'     => 'https://fountaincity.tech/',
		'custom_title'   => 'Customized Wordpress Application',
		'custom_style'   => 'disable',
		'custom_message' => '<p class="custom-message">My custom message</p>',
		'custom_footer'  => 'Customized Wordpress Application by Fountain City, Inc (an open source project)',
		'custom_toolbar' => false,
		'custom_scheme'  => 'default',
		'dashboard_url'  => 'https://datastudio.google.com/u/0/reporting/1ea2f974-80d3-443f-b205-5316716a13d3/page/p_sporg6bdwc/preview'
	);

}



// NOTE need to test ***********************
function ab_dev_admin_theme_style() {
    wp_enqueue_style('ab-admin-theme', plugins_url('/public/css/wp-admin-dev.css', __FILE__));
}
function ab_client_admin_theme_style() {
    wp_enqueue_style('ab-admin-theme', plugins_url('/public/css/wp-admin-client.css', __FILE__));
}
add_action( 'wp_loaded', 'ab_load_the_right_style_when_wp_loaded' );

function ab_load_the_right_style_when_wp_loaded(){
  $current_user = wp_get_current_user();

  if (  $current_user->exists() ) {

    if (in_array( 'administrator', (array) $current_user->roles)) {
      add_action('admin_enqueue_scripts', 'ab_dev_admin_theme_style');
      add_action('login_enqueue_scripts', 'ab_dev_admin_theme_style');
    } elseif (in_array( 'client', (array) $current_user->roles)){
      add_action('admin_enqueue_scripts', 'ab_client_admin_theme_style');
      add_action('login_enqueue_scripts', 'ab_client_admin_theme_style');
    }
  }
}

// Login logo css

function ab_custom_login_logo()
{   
	if (get_option("ab_login_logo") && get_option("ab_options")['custom_style'] == 'enable') {
	$logo_url = get_option("ab_login_logo");
	echo '<style  type="text/css"> 
			.login h1 a {
			background-image: url(' . $logo_url . ');
			width: 300px;
			background-size: contain;
			background-repeat: no-repeat;
			} 
		</style>';
	} elseif ( !get_option("ab_login_logo") && get_option("ab_options")['custom_style'] == 'enable'){
		echo '<style  type="text/css"> 
			.login h1 a {
				background-image: url("/wp-content/plugins/aaadmin-boss/public/assets/login-screen-logo.png");
				width: 300px;
				background-size: contain;
				background-repeat: no-repeat;
			}
		</style>';
	}
}
add_action('login_head',  'ab_custom_login_logo');

// **********************************

// Debugging Functions and Alerts
function ab_alert($output){
	echo "<script type='text/javascript'>alert('" . $output . "');</script>";
}

// Creates FC Dev Tools admin bar Tab
add_action( 'admin_bar_menu', 'ab_add_links_to_admin_bar',999 );
function ab_add_links_to_admin_bar($admin_bar) {
	// add a parent item
	$args = array(
		'id'    => 'ab_dev_tools',
		'title' => 'AB Shortcuts',
		'href'   => '#', 
	);
	$admin_bar->add_node( $args );
	$args = array(
		'parent' => 'ab_dev_tools',
		'id'     => 'media-libray',
		'title'  => 'Media Library',
		'href'   => esc_url( admin_url( 'upload.php' ) ),
		'meta'   => false
	);
	$admin_bar->add_node( $args );

	$args = array(
		'parent' => 'ab_dev_tools',
		'id'     => 'all-pages',
		'title'  => 'All Pages by Date',
		'href'   => esc_url( admin_url( 'edit.php?post_type=page&orderby=date&order=desc' ) ),
		'meta'   => false
	);
	$admin_bar->add_node( $args );

	$args = array(
		'parent' => 'ab_dev_tools',
		'id'     => 'all-posts',
		'title'  => 'All Posts by Date',
		'href'   => esc_url( admin_url( 'edit.php?post_type=post&orderby=date&order=desc' ) ),
		'meta'   => false
	);
	$admin_bar->add_node( $args );

	$args = array(
		'parent' => 'ab_dev_tools',
		'id'     => 'plugins',
		'title'  => 'All Plugins',
		'href'   => esc_url( admin_url( 'plugins.php' ) ),
		'meta'   => false
	);
	$admin_bar->add_node( $args );
	if (is_plugin_active('backupbuddy/backupbuddy.php')) {
		$args = array(
			'parent' => 'ab_dev_tools',
			'id'     => 'backup',
			'title'  => 'BackupBuddy',
			'href'   => esc_url( admin_url( 'admin.php?page=pb_backupbuddy_backup' ) ),
			'meta'   => false
		);
		$admin_bar->add_node( $args );
	}
	if (is_plugin_active('wp-migrate-db-pro/wp-migrate-db-pro.php')) {
		$args = array(
			'parent' => 'ab_dev_tools',
			'id'     => 'sync_db',
			'title'  => 'Sync Database',
			'href'   => esc_url( admin_url( 'tools.php?page=wp-migrate-db-pro' ) ),
			'meta'   => false
		);
		$admin_bar->add_node( $args );
	}
	if (is_plugin_active('litespeed-cache/litespeed-cache.php')) {
		global $wp;
		$no_cache_url =  ab_before_cache_link( add_query_arg( $wp->query_vars, home_url( $wp->request ) ) );
		$args = array(
			'parent' => 'ab_dev_tools',
			'id'     => 'no_cache',
			'title'  => 'Reload Page wo/ Cache',
			'href'   => esc_url( $no_cache_url ),
			'meta'   => false
		);
		$admin_bar->add_node( $args );
	}
}

// ADD CLASS TO BODY OF ALL PAGES FOR CUSTOM STYLES IF ADD 'fc_body_class' AS A CUSTOM FIELD TO THE PAGE or POST
add_filter( 'body_class', 'ab_body_class' );
/**
 * Add custom field body class(es) to the body classes.
 *
 * It accepts values from a per-page custom field, and only outputs when viewing a singular static Page.
 *
 * @param array $classes Existing body classes.
 * @return array Amended body classes.
 */
function ab_body_class( array $classes ) {
	$new_class = is_page() ? get_post_meta( get_the_ID(), 'fc_body_class', true ) : null;

	if ( $new_class ) {
		$classes[] = $new_class;
	}

	return $classes;
}
