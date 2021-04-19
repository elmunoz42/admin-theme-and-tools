<?php // Aaadmin-Boss - Settings Page



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// NOTE: NOT WORKING *************************************

// display the plugin dasbhoard page
function ab_display_dashboard_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;


	?>

	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">

			<?php
			// output security fields
			settings_fields( 'ab_options' );

			// output setting sections
			do_settings_sections( 'dashboard-page' );

			// submit button
			// submit_button();

			?>

		</form>
	</div>

	<?php

}
