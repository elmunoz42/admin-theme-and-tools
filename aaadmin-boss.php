
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
	require_once plugin_dir_path( __FILE__ ) . 'admin/home-dash-widget.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/dev-tools-page.php';
	// require_once plugin_dir_path( __FILE__ ) . 'admin/logged-in-users-alert.php'; NOTE moving this to dashboard widget

}


// include plugin dependencies: admin and public
require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php';



// default plugin options
function ab_options_default() {

	return array(
		'custom_url'     => 'https://fountaincity.tech/wp-content/uploads/2018/10/fauntain-city-logo.png',
		'custom_title'   => 'Customized Wordpress Application',
		'custom_style'   => 'disable',
		'custom_message' => '<p class="custom-message">My custom message</p>',
		'custom_footer'  => 'Customized Wordpress Application by Fountain City, Inc (an open source project)',
		'custom_toolbar' => false,
		'custom_scheme'  => 'fountain',
		'dashboard_url'  => 'https://datastudio.google.com/'
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
		'title'  => 'All Pages',
		'href'   => esc_url( admin_url( 'edit.php?post_type=page' ) ),
		'meta'   => false
	);
	$admin_bar->add_node( $args );

	$args = array(
		'parent' => 'ab_dev_tools',
		'id'     => 'all-posts',
		'title'  => 'All Posts',
		'href'   => esc_url( admin_url( 'edit.php?post_type=post' ) ),
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
	

	// NOTE: THIS SECTION I WAS TRYING TO DEACTIVATE / ACTIVATE PLUGIN BY LINK AND IT DID NOT WORK BECAUSE IT WOULD SAY LINK EXPIRED
		// $url = (wp_nonce_url(admin_url('plugins.php?action=deactivate&plugin=backupbuddy%2Fbackupbuddy.php&plugin_status=all&paged=1&s'), 'action') );
		// $url = (wp_nonce_url(admin_url('plugins.php?action=deactivate&plugin=backupbuddy%2Fbackupbuddy.php&plugin_status=all&paged=1&s&' ), 'activate_bu_buddy', 'my_nonce1');
        // $url = wp_nonce_url(admin_url('plugins.php?action=activate&plugin=backupbuddy%2Fbackupbuddy.php&plugin_status=all&paged=1&s&' ), 'activate_bu_buddy', 'my_nonce2');

	// Check if BackupBuddy is active and provide the appropriate links
	if (is_plugin_active('backupbuddy/backupbuddy.php')) {
        
		$url = admin_url('options-general.php?page=dev-tools');
	    $args = array(
	        'parent' => 'ab_dev_tools',
	        'id'     => 'deactivate_bu_buddy',
	        'title'  => 'Deactivate BU Buddy',
	        'href'   => esc_url( $url ),
	        'meta'   => false
	    );
			$admin_bar->add_node( $args );
	} else {
		
		$url = admin_url('options-general.php?page=dev-tools');
		$args = array(
				'parent' => 'ab_dev_tools',
				'id'     => 'activate_bu_buddy',
				'title'  => 'Activate BU Buddy ',
				'href'   => esc_url( $url  ) ,
				'meta'   => false
		);
		$admin_bar->add_node( $args );
	}
	
	
	


	// Check if WP Migrate DB Pro is active and provide the appropriate links
	// if (is_plugin_active('wp-migrate-db-pro/wp-migrate-db-pro.php')) {
	//
	//     $args = array(
	//         'parent' => 'ab_dev_tools',
	//         'id'     => 'deactivate_wp-migrate-db-pro',
	//         'title'  => 'Deactivate WP Migrate DB Pro',
	//         'href'   => esc_url( admin_url( 'plugins.php?action=deactivate&plugin=wp-migrate-db-pro%2Fwp-migrate-db-pro.php&plugin_status=all&paged=1&s&_wpnonce=' . esc_attr( $nonce ) ) ),
	//         'meta'   => false
	//     );
	// 		$admin_bar->add_node( $args );
	// } else {
	// 	$args = array(
	// 			'parent' => 'ab_dev_tools',
	// 			'id'     => 'activate_wp-migrate-db-pro',
	// 			'title'  => 'Activate WP Migrate DB Pro',
	// 			'href'   => esc_url( admin_url( 'plugins.php?action=activate&plugin=wp-migrate-db-pro%2Fwp-migrate-db-pro.php&plugin_status=all&paged=1&s&_wpnonce=' . esc_attr( $nonce )  ) ),
	// 			'meta'   => false
	// 	);
	// 	$admin_bar->add_node( $args );
	// }

}





// // Creates Dashboard Widget
// // NOTE: Add additional links as desired
// add_action('wp_dashboard_setup', 'ab_dashboard_widgets');
// function ab_dashboard_widgets() {
// 	global $wp_meta_boxes;

// 	wp_add_dashboard_widget('ab_dev_dashboard', 'Fountain City Support and Resources ', 'ab_dev_dashboard');
// }


// function ab_logged_in_users_report() {


// $aUsers = get_users([
// 	'meta_key' => 'session_tokens',
// 	'meta_compare' => 'EXISTS'
// 	]);


// 	echo sprintf(
// 	'Users online: %s',
// 	implode(', ', array_map(function($oUser){
// 	$aCurrentSessions = get_user_meta($oUser->ID, 'session_tokens', true);
// 	return '<span class="username">' . $oUser->display_name.'</span> (' .
// 			implode('; ', array_map(function($aSession) {
// 					return $aSession['ip']; // only return the session ips
// 			}, $aCurrentSessions)) . ')';
// 	}, $aUsers))
// 	);
// }

// // NOTE Lets make these dynamic fields that get populated from settings page.
// function ab_dev_dashboard() {
// 	echo '<p>If you need any support please use our ticketing system, it helps us stay organized :-)</p>';
// 	echo '<ul><li><a href="https://fountaincity.app/" target="_blank">Create a Support Ticket</a></li>';
// 	echo '<ul><li><a href="https://fountaincity.host" target="_blank">Manage your Hosting Subscription</a></li>';
// 	echo '<ul><li><a href="https://analytics.google.com" target="_blank">Google Analytics</a></li>';
// 	echo '<ul><li><a href="https://drive.google.com" target="_blank">Google Drive</a></li></ul>';
// 	ab_logged_in_users_report();

// }


// Auto activate plugins
add_action('init','ab_activate_development_plugins');
function ab_activate_development_plugins(){

	$current_user = wp_get_current_user();

	// set_transient( 'ab_dev_is_logged_in' , 0 , HOUR_IN_SECONDS ); // NOTE TEMPORARY FOR TESTING
	$ab_dev_is_logged_in = (get_transient('ab_dev_is_logged_in')) ? 1 : 0;

	$backup_buddy = ABSPATH."wp-content/plugins/backupbuddy/backupbuddy.php";
	$wp_migrate_db_pro = ABSPATH."wp-content/plugins/wp-migrate-db-pro/wp-migrate-db-pro.php";
	$query_monitor = ABSPATH."wp-content/plugins/query-monitor/query-monitor.php";
	// If the current user is an administrator, and the ab_dev_is_logged_in transient hasn't yet been set to true
	if (current_user_can('administrator') && $ab_dev_is_logged_in == 0){
		// If one of our devs is the current user
		if ($current_user->user_login == 'sebastian' || $current_user->user_login == 'will' || $current_user->user_login == 'carlos' || $current_user->user_login == 'carlos.mk' || $current_user->user_login == 'gray') {

			set_transient( 'ab_dev_is_logged_in' , 1 , HOUR_IN_SECONDS );
			$ab_dev_is_logged_in == 1;  // Not sure why I had to do this. Plugins were deactivating on refresh when I didn't ??
			$message = 'The below development plugin(s) have been activated by fc dev tools:\n';
			if (!file_exists($backup_buddy)&&!file_exists ($wp_migrate_db_pro)&&!file_exists ($query_monitor)) {
				$message = 'BackupBuddy, Wp Migrate DB Pro and Query Monitor are not installed.';
			}
			if (file_exists ($backup_buddy)) {
				activate_plugin( $backup_buddy );

				$message .= 'BackupBuddy\n';
			}
			if (file_exists ($wp_migrate_db_pro)) {
				activate_plugin( $wp_migrate_db_pro );
				$message .= 'WP Migrate DB Pro\n';
			}
			if (file_exists ($query_monitor)) {
				activate_plugin( $query_monitor );
				$message .= 'Query Monitor\n';
			}
			ab_alert($message);
		}
	}
}

// NOTE troubleshooting
// ab_alert(get_transient('ab_dev_is_logged_in'));

// Auto deactivate plugins
add_action('init','ab_deactivate_development_plugins');
function ab_deactivate_development_plugins(){
	$current_user = wp_get_current_user();

	// set_transient( 'ab_dev_is_logged_in' , 1 , HOUR_IN_SECONDS ); // NOTE TEMPORARY FOR TESTING
	$ab_dev_is_logged_in = (get_transient('ab_dev_is_logged_in')) ? 1 : 0;
	// ab_alert($ab_dev_is_logged_in);

	// If the ab_dev_is_logged_in transient is still 1 ...
	if($ab_dev_is_logged_in == 1){
		// ... and neither Sebastian, Will, Carlos or Gray are logged in, deactivate the plugins. This should only be true for an instant.
		if ($current_user->user_login != 'sebastian' && $current_user->user_login != 'will' && $current_user->user_login != 'carlos' && $current_user->user_login != 'carlos.mk' && $current_user->user_login != 'gray'){
			$backup_buddy = ABSPATH."wp-content/plugins/backupbuddy/backupbuddy.php";
			$wp_migrate_db_pro = ABSPATH."wp-content/plugins/wp-migrate-db-pro/wp-migrate-db-pro.php";
			$query_monitor = ABSPATH."wp-content/plugins/query-monitor/query-monitor.php";

			set_transient( 'ab_dev_is_logged_in' , 0 , HOUR_IN_SECONDS );
			if (file_exists ($backup_buddy)) {
				deactivate_plugins( $backup_buddy );
			}
			if (file_exists ($wp_migrate_db_pro)) {
				deactivate_plugins( $wp_migrate_db_pro );
			}
			if (file_exists ($query_monitor)) {
				deactivate_plugins( $query_monitor );
			}
			ab_alert('plugins_deactivated');
		}
	}
}
