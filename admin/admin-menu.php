<?php // Aaadmin-Boss - Admin Menu



// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



// add top-level administrative menu
function ab_add_toplevel_menu() {

	/*

	add_menu_page(
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug,
		callable $function = '',
		string   $icon_url = '',
		int      $position = null
	)

	*/
  // NOTE $position 0 means very top


	add_menu_page(
		'GDS Dashboard',
		'GDS Dashboard',
		'manage_options',
		'gds-dashboard',
		'ab_display_dashboard',
		'dashicons-schedule',
		0
	);

	add_submenu_page(
		'options-general.php',
		'Aaadmin Boss Settings',
		'Aaadmin Boss',
		'manage_options',
		'aaadmin-boss',
		'ab_display_settings_page'
	);
	add_submenu_page(
		'options-general.php',
		'Aaadmin Boss Login Logo',
		'Login Page Logo',
		'manage_options',
		'ab-login-logo',
		'ab_display_login_logo_page'
	);

}
add_action( 'admin_menu', 'ab_add_toplevel_menu' );

// Add link to settings page from plugins page view. Here's documentation on plugin action links which is used in the filter below... https://developer.wordpress.org/reference/hooks/plugin_action_links_plugin_file/

function ab_settings_and_repo_link( $links ) {
	// Build and escape the URL.
	$url = esc_url("/wp-admin/options-general.php?page=aaadmin-boss");
	$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
	$url2 = esc_url("https://github.com/elmunoz42/admin-theme-and-tools");
	$repository_link = "<a href='$url2'>" . 'Github ' . __('Repository')  . '</a>';
	// Adds the link to the end of the array.
	array_push(
		$links,
		$settings_link,
		$repository_link
	);
	return $links;
}
add_filter( 'plugin_action_links_aaadmin-boss/aaadmin-boss.php', 'ab_settings_and_repo_link' );