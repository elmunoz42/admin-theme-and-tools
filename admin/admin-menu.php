<?php // Aaadmin-Boss - Admin Menu



// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



// add sub-level administrative menu
function ab_add_sublevel_menu() {

	/*

	add_submenu_page(
		string   $parent_slug,
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug,
		callable $function = ''
	);

	*/

  // NOTE options-general.php is the "Settings" menu tab as parent
	add_submenu_page(
		'aaadmin-boss',
		'Aaadmin Boss Settings',
		'Settings',
		'manage_options',
		'aaadmin-boss',
		'ab_display_settings_page'
	);


// NOTE: NOT WORKING *************************************************
	add_submenu_page(
		'aaadmin-boss',
		'Aaadmin Boss Dashboard',
		'Dashboard',
		'manage_options',
		'ab_dashboard_page',
		'ab_display_dashboard_page'
	);

	add_submenu_page(
		'aaadmin-boss',
		'GDS Dashboard',
		'GDS Dashboard',
		'manage_options',
		'admin.php?page=gds_dashboard',
		'ab_display_gds_dashboard_page'
	);

}
add_action( 'admin_menu', 'ab_add_sublevel_menu' );



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
		'Aaadmin Boss Settings',
		'Aaadmin Boss',
		'manage_options',
		'aaadmin-boss',
		'ab_display_settings_page',
		'dashicons-admin-generic',
		0
	);

}
add_action( 'admin_menu', 'ab_add_toplevel_menu' );
