<?php // Aaadmin-boss - Register Settings



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



// register plugin settings
function ab_register_settings() {

	/*

	register_setting(
		string   $option_group,
		string   $option_name,
		callable $sanitize_callback = ''
	);

	*/

	register_setting(
		'ab_options',
		'ab_options',
		'ab_callback_validate_options'
	);

	/*

	add_settings_section(
		string   $id,
		string   $title,
		callable $callback,
		string   $page
	);

	*/

	add_settings_section(
		'ab_section_login',
		'Customize Login Page',
		'ab_callback_section_login',
		'aaadmin-boss'
	);

	add_settings_section(
		'ab_section_admin',
		'Customize Admin Area',
		'ab_callback_section_admin',
		'aaadmin-boss'
	);

	/*

	add_settings_field(
    	string   $id,
		string   $title,
		callable $callback,
		string   $page,
		string   $section = 'default',
		array    $args = []
	);

	*/

	add_settings_field(
		'custom_url',
		'Custom URL',
		'ab_callback_field_text',
		'aaadmin-boss',
		'ab_section_login',
		[ 'id' => 'custom_url', 'label' => 'Custom URL for the login logo link' ]
	);

	add_settings_field(
		'custom_title',
		'Custom Title',
		'ab_callback_field_text',
		'aaadmin-boss',
		'ab_section_login',
		[ 'id' => 'custom_title', 'label' => 'Custom title below the logo' ]
	);

	add_settings_field(
		'custom_style',
		'Custom Login Page Style',
		'ab_callback_field_radio',
		'aaadmin-boss',
		'ab_section_login',
		[ 'id' => 'custom_style', 'label' => 'Custom CSS for the Login screen' ]
	);

	add_settings_field(
		'custom_message',
		'Custom Message',
		'ab_callback_field_textarea',
		'aaadmin-boss',
		'ab_section_login',
		[ 'id' => 'custom_message', 'label' => 'Custom text and/or markup' ]
	);

	add_settings_field(
		'custom_footer',
		'Custom Footer',
		'ab_callback_field_text',
		'aaadmin-boss',
		'ab_section_admin',
		[ 'id' => 'custom_footer', 'label' => 'Custom footer text' ]
	);

	add_settings_field(
		'custom_toolbar',
		'Custom Toolbar',
		'ab_callback_field_checkbox',
		'aaadmin-boss',
		'ab_section_admin',
		[ 'id' => 'custom_toolbar', 'label' => 'Remove new post and comment links from the Toolbar' ]
	);

	add_settings_field(
		'custom_scheme',
		'Custom Scheme',
		'ab_callback_field_select',
		'aaadmin-boss',
		'ab_section_admin',
		[ 'id' => 'custom_scheme', 'label' => 'Default color scheme for new users' ]
	);

	add_settings_field(
		'dashboard_url',
		'Google Data Studio Dashboard URL',
		'ab_callback_field_text2',
		'aaadmin-boss',
		'ab_section_admin',
		[ 'id' => 'dashboard_url', 'label' => 'Embed URL for the Google Data Studio Dashboard' ]
	);

}
add_action( 'admin_init', 'ab_register_settings' );
