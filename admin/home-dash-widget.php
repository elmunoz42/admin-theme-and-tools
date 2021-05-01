<?php // Admin Home - Dashboard Widget 



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



// Creates Dashboard Widget
// NOTE: Add additional links as desired
add_action('wp_dashboard_setup', 'ab_dashboard_widgets');
function ab_dashboard_widgets() {
	global $wp_meta_boxes;

	wp_add_dashboard_widget('ab_dev_dashboard', 'Fountain City Support and Resources ', 'ab_dev_dashboard');
}


function ab_logged_in_users_report() {


$aUsers = get_users([
	'meta_key' => 'session_tokens',
	'meta_compare' => 'EXISTS'
	]);


	echo sprintf(
	'Logged in Users: %s',
	implode(', ', array_map(function($oUser){
	$aCurrentSessions = get_user_meta($oUser->ID, 'session_tokens', true);
	return '<span class="username">' . $oUser->display_name.'</span> (' .
			implode('; ', array_map(function($aSession) {
					return $aSession['ip']; // only return the session ips
			}, $aCurrentSessions)) . ')';
	}, $aUsers))
	);
}

// NOTE Lets make these dynamic fields that get populated from settings page.
function ab_dev_dashboard() {
	echo '<p>If you need any support please use our ticketing system, it helps us stay organized :-)</p>';
	echo '<ul><li><a href="https://fountaincity.app/" target="_blank">Create a Support Ticket</a></li>';
	echo '<ul><li><a href="https://fountaincity.host" target="_blank">Manage your Hosting Subscription</a></li>';
	echo '<ul><li><a href="https://analytics.google.com" target="_blank">Google Analytics</a></li>';
	echo '<ul><li><a href="https://search.google.com" target="_blank">Google Search Console</a></li>';
	echo '<ul><li><a href="https://drive.google.com" target="_blank">Google Drive</a></li></ul>';
	ab_logged_in_users_report();

}
