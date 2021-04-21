<?php // Aaadmin-Boss - Dashboard Callbacks



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



// callback: dashboard sections NOTE: NOT WORKING *********************
function ab_display_gds_dashboard_page(){
	// Get dashboard url
	$options = get_option( 'ab_options', ab_options_default() );
	$value = isset( $options['dashboard_url'] ) ? sanitize_text_field( $options['dashboard_url'] ) : '';
  // Display
	echo '<iframe width="1200" height="5000" src="' . $value . '" frameborder="0" style="border:0" allowfullscreen></iframe>';
}
