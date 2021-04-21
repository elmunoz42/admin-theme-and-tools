<?php // Aaadmin-Boss - Settings Page



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


// display the plugin dasbhoard page
function ab_display_dashboard_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;


	?>

	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>


			<?php
			// output security fields
			settings_fields( 'ab_options' );

			// output setting sections

			// NOTE: Not working permissions issue **********************************************************************************
			do_settings_sections( 'ab_section_dashboard' );
			do_settings_sections( 'aaadmin-boss' );

			// submit button
			submit_button();
			?>


	</div>

	<?php

}
