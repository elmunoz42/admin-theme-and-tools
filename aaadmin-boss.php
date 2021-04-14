
<?php

/**
* Plugin Name: AAAdmin Boss
* Description: Admin Theme, Functionality & Dev Tools
* Author: Carlos Munoz Kampff - Fountain City
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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function ab_dev_admin_theme_style() {
    wp_enqueue_style('ab-admin-theme', plugins_url('/admin/css/wp-admin-dev.css', __FILE__));
}
function ab_client_admin_theme_style() {
    wp_enqueue_style('ab-admin-theme', plugins_url('/admin/css/wp-admin-client.css', __FILE__));
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
      // add_action('admin_head', 'cmk_backend_menu_therapist');
    }
  }
}


// Debugging Functions and Alerts
function fc_alert($output){
	echo "<script type='text/javascript'>alert('" . $output . "');</script>";
}

function fc_debugout($value, $autodump = false)
{
    if ($autodump || (empty($value) && $value !== 0 && $value !== "0") || $value === true) {
        var_dump($value);
    } else {
        print_r($value);
    }
    die();
}
if (!function_exists('write_log')) {

    function fc_write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}



// Creates FC Dev Tools admin bar Tab
add_action( 'admin_bar_menu', 'fc_add_links_to_admin_bar',999 );
function fc_add_links_to_admin_bar($admin_bar) {
	// add a parent item
	$args = array(
		'id'    => 'fc_dev_tools',
		'title' => 'FC Dev Tools',
		'href'   => 'http://example.com/', // Showing how to add an external link
	);
	$admin_bar->add_node( $args );
	$args = array(
		'parent' => 'fc_dev_tools',
		'id'     => 'media-libray',
		'title'  => 'Media Library',
		'href'   => esc_url( admin_url( 'upload.php' ) ),
		'meta'   => false
	);
	$admin_bar->add_node( $args );

	$args = array(
		'parent' => 'fc_dev_tools',
		'id'     => 'plugins',
		'title'  => 'Plugins',
		'href'   => esc_url( admin_url( 'plugins.php' ) ),
		'meta'   => false
	);
	$admin_bar->add_node( $args );

	$args = array(
		'parent' => 'fc_dev_tools',
		'id'     => 'sync_db',
		'title'  => 'Sync Database',
		'href'   => esc_url( admin_url( 'tools.php?page=wp-migrate-db-pro' ) ),
		'meta'   => false
	);
	$admin_bar->add_node( $args );



	// NOTE THIS SECTION IS NOT WORKING DUE TO NONCE ISSUE would like to resolve

	// Check if BackupBuddy is active and provide the appropriate links
	if (is_plugin_active('backupbuddy/backupbuddy.php')) {
			$url = wp_nonce_url(admin_url('plugins.php?action=deactivate&plugin=backupbuddy%2Fbackupbuddy.php&plugin_status=all&paged=1&s&' ), 'activate_bu_buddy', 'my_nonce1');
	    $args = array(
	        'parent' => 'fc_dev_tools',
	        'id'     => 'deactivate_bu_buddy',
	        'title'  => 'Deactivate BU Buddy',
	        'href'   => esc_url( (wp_nonce_url(admin_url('plugins.php?action=deactivate&plugin=backupbuddy%2Fbackupbuddy.php&plugin_status=all&paged=1&s'), 'action') ) ),
	        'meta'   => false
	    );
			$admin_bar->add_node( $args );
	} else {
		$url = wp_nonce_url(admin_url('plugins.php?action=activate&plugin=backupbuddy%2Fbackupbuddy.php&plugin_status=all&paged=1&s&' ), 'deactivate_bu_buddy', 'my_nonce2');
		$args = array(
				'parent' => 'fc_dev_tools',
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
	//         'parent' => 'fc_dev_tools',
	//         'id'     => 'deactivate_wp-migrate-db-pro',
	//         'title'  => 'Deactivate WP Migrate DB Pro',
	//         'href'   => esc_url( admin_url( 'plugins.php?action=deactivate&plugin=wp-migrate-db-pro%2Fwp-migrate-db-pro.php&plugin_status=all&paged=1&s&_wpnonce=' . esc_attr( $nonce ) ) ),
	//         'meta'   => false
	//     );
	// 		$admin_bar->add_node( $args );
	// } else {
	// 	$args = array(
	// 			'parent' => 'fc_dev_tools',
	// 			'id'     => 'activate_wp-migrate-db-pro',
	// 			'title'  => 'Activate WP Migrate DB Pro',
	// 			'href'   => esc_url( admin_url( 'plugins.php?action=activate&plugin=wp-migrate-db-pro%2Fwp-migrate-db-pro.php&plugin_status=all&paged=1&s&_wpnonce=' . esc_attr( $nonce )  ) ),
	// 			'meta'   => false
	// 	);
	// 	$admin_bar->add_node( $args );
	// }

}


// Creates Dashboard Widget
// NOTE: Add additional links as desired
add_action('wp_dashboard_setup', 'fc_dashboard_widgets');
function fc_dashboard_widgets() {
	global $wp_meta_boxes;

	wp_add_dashboard_widget('fc_dev_dashboard', 'Fountain City Support and Resources ', 'fc_dev_dashboard');
}

function fc_dev_dashboard() {
	echo '<p>If you need any support please use our ticketing system, it helps us stay organized :-)</p>';
	echo '<ul><li><a href="https://tickets.fountain-city.com/" target="_blank">Create a Support Ticket</a></li>';
	echo '<ul><li><a href="https://fountaincity.host" target="_blank">Manage your Hosting Subscription</a></li>';
	echo '<ul><li><a href="https://analytics.google.com" target="_blank">Google Analytics</a></li>';
	echo '<ul><li><a href="https://drive.google.com" target="_blank">Google Drive</a></li></ul>';
}


// Auto activate plugins
add_action('init','fc_activate_development_plugins');
function fc_activate_development_plugins(){

	$current_user = wp_get_current_user();

	// set_transient( 'fc_dev_is_logged_in' , 0 , HOUR_IN_SECONDS ); // NOTE TEMPORARY FOR TESTING
	$fc_dev_is_logged_in = (get_transient('fc_dev_is_logged_in')) ? 1 : 0;

	$backup_buddy = ABSPATH."wp-content/plugins/backupbuddy/backupbuddy.php";
	$wp_migrate_db_pro = ABSPATH."wp-content/plugins/wp-migrate-db-pro/wp-migrate-db-pro.php";
	$query_monitor = ABSPATH."wp-content/plugins/query-monitor/query-monitor.php";
	// If the current user is an administrator, and the fc_dev_is_logged_in transient hasn't yet been set to true
	if (current_user_can('administrator') && $fc_dev_is_logged_in == 0){
		// If one of our devs is the current user
		if ($current_user->user_login == 'sebastian' || $current_user->user_login == 'will' || $current_user->user_login == 'carlos' || $current_user->user_login == 'carlos.mk' || $current_user->user_login == 'gray') {

			set_transient( 'fc_dev_is_logged_in' , 1 , HOUR_IN_SECONDS );
			$fc_dev_is_logged_in == 1;  // Not sure why I had to do this. Plugins were deactivating on refresh when I didn't ??
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
			fc_alert($message);
		}
	}
}

// NOTE troubleshooting
// fc_alert(get_transient('fc_dev_is_logged_in'));

// Auto deactivate plugins
add_action('init','fc_deactivate_development_plugins');
function fc_deactivate_development_plugins(){
	$current_user = wp_get_current_user();

	// set_transient( 'fc_dev_is_logged_in' , 1 , HOUR_IN_SECONDS ); // NOTE TEMPORARY FOR TESTING
	$fc_dev_is_logged_in = (get_transient('fc_dev_is_logged_in')) ? 1 : 0;
	// fc_alert($fc_dev_is_logged_in);

	// If the fc_dev_is_logged_in transient is still 1 ...
	if($fc_dev_is_logged_in == 1){
		// ... and neither Sebastian, Will, Carlos or Gray are logged in, deactivate the plugins. This should only be true for an instant.
		if ($current_user->user_login != 'sebastian' && $current_user->user_login != 'will' && $current_user->user_login != 'carlos' && $current_user->user_login != 'carlos.mk' && $current_user->user_login != 'gray'){
			$backup_buddy = ABSPATH."wp-content/plugins/backupbuddy/backupbuddy.php";
			$wp_migrate_db_pro = ABSPATH."wp-content/plugins/wp-migrate-db-pro/wp-migrate-db-pro.php";
			$query_monitor = ABSPATH."wp-content/plugins/query-monitor/query-monitor.php";

			set_transient( 'fc_dev_is_logged_in' , 0 , HOUR_IN_SECONDS );
			if (file_exists ($backup_buddy)) {
				deactivate_plugins( $backup_buddy );
			}
			if (file_exists ($wp_migrate_db_pro)) {
				deactivate_plugins( $wp_migrate_db_pro );
			}
			if (file_exists ($query_monitor)) {
				deactivate_plugins( $query_monitor );
			}
			fc_alert('plugins_deactivated');
		}
	}
}
