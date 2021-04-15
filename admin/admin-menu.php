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
		'options-general.php',
		'Aaadmin Boss Settings',
		'Aaadmin Boss',
		'manage_options',
		'aaadmin-boss',
		'ab_display_settings_page'
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
