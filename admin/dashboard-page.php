<?php // Aaadmin-Boss - Settings Page



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


function ab_display_dashboard() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;
	?>
		<h1>
			<?php esc_html_e( 'Google Data Studio Dashboard', 'my-plugin-textdomain' ); ?>
		</h1><?php

		$options = get_option( 'ab_options', ab_options_default() );
		$value = isset( $options['dashboard_url'] ) ? sanitize_text_field( $options['dashboard_url'] ) : '';
		echo '<h3><a href="' . $value . '" target="_blank">-> Go to GDS</a></h3> ';
		echo '<iframe width="1200" height="5000" src="' . $value . '" frameborder="0" style="border:0" allowfullscreen></iframe>';
		 ?>

	<?php
}
