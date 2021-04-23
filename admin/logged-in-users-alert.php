<?php // Aaadmin-Boss - Settings Page

// NOTE: THIS PAGE IS CURRENTLY NOT LINKED TO

// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// Get logged in users
function ab_logged_in_users_alert() {


$aUsers = get_users([
'meta_key' => 'session_tokens',
'meta_compare' => 'EXISTS'
]);


$message =  sprintf(
'Users online: %s',
implode(', ', array_map(function($oUser){
$aCurrentSessions = get_user_meta($oUser->ID, 'session_tokens', true);
return get_avatar( $oUser->ID, 96 ) . '<span class="username">' . $oUser->display_name.'</span> (' .
		implode('; ', array_map(function($aSession) {
				return $aSession['ip']; // only return the session ips
		}, $aCurrentSessions)) . ')';
}, $aUsers))
);

   // ab_alert($message);
   ab_alert('test');
}
