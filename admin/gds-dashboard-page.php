<?php // Aaadmin-Boss - Settings Page



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


// display the plugin dasbhoard page
function ab_display_gds_dashboard_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;


	?>

	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>


			<?php
			// output security fields
			settings_fields( 'ab_options' );

			// output setting sections
			$options = get_option( 'ab_options', ab_options_default() );
			$value = isset( $options['dashboard_url'] ) ? sanitize_text_field( $options['dashboard_url'] ) : '';
		  // Display
			echo '<iframe width="1200" height="5000" src="' . $value . '" frameborder="0" style="border:0" allowfullscreen></iframe>';
			// NOTE: Not working permissions issue **********************************************************************************
			// do_settings_sections( 'ab_dashboard_page' );
			// do_settings_sections( 'aaadmin-boss' );

			// submit button
			?>


	</div>

	<?php

}
