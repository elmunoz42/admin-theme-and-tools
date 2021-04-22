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
		'Aaadmin Boss Settings',
		'Aaadmin Boss',
		'manage_options',
		'aaadmin-boss',
		'ab_display_settings_page',
		'dashicons-admin-generic',
		0
	);

	add_menu_page(
		'GDS Dashboard',
		'GDS Dashboard',
		'manage_options',
		'gds-dashboard',
		'ab_display_dashboard',
		'dashicons-schedule',
		1
	);
}
add_action( 'admin_menu', 'ab_add_toplevel_menu' );
