<?php // Aaadmin-Boss - Dev Tools Page



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


function ab_display_dev_tools() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;
	?>
		<h1>
			<?php esc_html_e( 'Dev Tools Dashboard', 'my-plugin-textdomain' ); ?>
        </h1>
        <?php

        ab_run_activate_plugin( 'backupbuddy/backupbuddy.php' );
        
        if ( is_plugin_active( 'backupbuddy/backupbuddy.php' ) ) {
        echo 'Backup Buddy is Active';
         } else {
             echo 'Backup Buddy is NOT Active';
         }
		
		 ?>

	<?php
}