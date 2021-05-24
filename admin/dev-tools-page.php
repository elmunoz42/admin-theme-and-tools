<?php // Aaadmin-Boss - Dev Tools Page



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


function ab_display_dev_tools() {
    // Check if needed functions exists - if not, require them
    if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
	// check if user is allowed access
    if ( ! current_user_can( 'manage_options' ) ) return;
    
	?>
		<h1>
			<?php esc_html_e( 'Dev Tools Dashboard', 'my-plugin-textdomain' ); ?>
        </h1>
        <?php
        // check that backupbuddy is installed 
	    if ( ! file_exists( ABSPATH . 'wp-content/plugins/backupbuddy/backupbuddy.php' ) ) return;


       
        ab_run_activate_deactivate_plugin( 'backupbuddy/backupbuddy.php' );
        if ( is_plugin_active( 'backupbuddy/backupbuddy.php' ) ) {
        echo 'Backup Buddy is Active<br>';
         } else {
             echo 'Backup Buddy is NOT Active<br>';
         }

         if ( ! file_exists( ABSPATH . 'wp-content/plugins/query-monitor/query-monitor.php' ) ) return;
        ab_run_activate_deactivate_plugin( 'query-monitor/query-monitor.php' );
        if ( is_plugin_active( 'query-monitor/query-monitor.php' ) ) {
        echo 'Query Monitor is Active<br>';
         } else {
             echo 'Query Monitor is NOT Active<br>';
         }

        if ( ! file_exists( ABSPATH . 'wp-content/plugins/rebusted/rebusted.php' ) ) return;
        ab_run_activate_deactivate_plugin( 'rebusted/rebusted.php' );
        if ( is_plugin_active( 'rebusted/rebusted.php' ) ) {
        echo 'Rebusted is Active<br>';
         } else {
             echo 'Rebusted is NOT Active<br>';
         }
		
		 ?>

	<?php
}