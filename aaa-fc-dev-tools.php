
<?php

/**
* Plugin Name: AAA FC Development Tools
* Description: Fountain City Developer Tools
* Author: Carlos Munoz Kampff - Fountain City
* Version: 0.2
*/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// PHP ALERT
function js_alert($output){
	echo "<script type='text/javascript'>alert('" . $output . "');</script>";
}
// Creates FC Dev Tools admin bar Tab
function add_links_to_admin_bar($admin_bar) {
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
add_action( 'admin_bar_menu', 'add_links_to_admin_bar',999 );

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
add_action('init','activate_development_plugins');
function activate_development_plugins(){

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
			js_alert($message);
		}
	}
}

// NOTE troubleshooting
// js_alert(get_transient('fc_dev_is_logged_in'));

// Auto deactivate plugins
add_action('init','deactivate_development_plugins');
function deactivate_development_plugins(){
	$current_user = wp_get_current_user();

	// set_transient( 'fc_dev_is_logged_in' , 1 , HOUR_IN_SECONDS ); // NOTE TEMPORARY FOR TESTING
	$fc_dev_is_logged_in = (get_transient('fc_dev_is_logged_in')) ? 1 : 0;
	// js_alert($fc_dev_is_logged_in);

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
			js_alert('plugins_deactivated');
		}
	}
}
