<?php // MyPlugin - Core Functionality



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



// custom login logo url
function ab_custom_login_url( $url ) {

	$options = get_option( 'ab_options', ab_options_default() );

	if ( isset( $options['custom_url'] ) && ! empty( $options['custom_url'] ) ) {

		$url = esc_url( $options['custom_url'] );

	}

	return $url;

}
add_filter( 'login_headerurl', 'ab_custom_login_url' );



// custom login logo title
function ab_custom_login_title( $title ) {

	$options = get_option( 'ab_options', ab_options_default() );

	if ( isset( $options['custom_title'] ) && ! empty( $options['custom_title'] ) ) {

		$title = esc_attr( $options['custom_title'] );

	}

	return $title;

}
add_filter( 'login_headertext', 'ab_custom_login_title' );



// custom login styles
function ab_custom_login_styles() {

	$styles = false;

	$options = get_option( 'ab_options', ab_options_default() );

	if ( isset( $options['custom_style'] ) && ! empty( $options['custom_style'] ) ) {

		$styles = sanitize_text_field( $options['custom_style'] );

	}

	if ( 'enable' === $styles ) {

		/*

		wp_enqueue_style(
			string           $handle,
			string           $src = '',
			array            $deps = array(),
			string|bool|null $ver = false,
			string           $media = 'all'
		)

		wp_enqueue_script(
			string           $handle,
			string           $src = '',
			array            $deps = array(),
			string|bool|null $ver = false,
			bool             $in_footer = false
		)

		*/

		// NOTE - What is the handle? Should it be aaadmin-boss?
		wp_enqueue_style( 'myplugin', plugin_dir_url( dirname( __FILE__ ) ) . 'public/css/ab-login.css', array(), null, 'screen' );

		wp_enqueue_script( 'myplugin', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/ab-login.js', array(), null, true );

	}

}
add_action( 'login_enqueue_scripts', 'ab_custom_login_styles' );



// custom login message
function ab_custom_login_message( $message ) {

	$options = get_option( 'ab_options', ab_options_default() );

	if ( isset( $options['custom_message'] ) && ! empty( $options['custom_message'] ) ) {

		$message = wp_kses_post( $options['custom_message'] ) . $message;

	}

	return $message;

}
add_filter( 'login_message', 'ab_custom_login_message' );



// custom admin footer
function ab_custom_admin_footer( $message ) {

	$options = get_option( 'ab_options', ab_options_default() );

	if ( isset( $options['custom_footer'] ) && ! empty( $options['custom_footer'] ) ) {

		$message = sanitize_text_field( $options['custom_footer'] );

	}

	return $message;

}
add_filter( 'admin_footer_text', 'ab_custom_admin_footer' );



// custom toolbar items
function ab_custom_admin_toolbar() {

	$toolbar = false;

	$options = get_option( 'ab_options', ab_options_default() );

	if ( isset( $options['custom_toolbar'] ) && ! empty( $options['custom_toolbar'] ) ) {

		$toolbar = (bool) $options['custom_toolbar'];

	}

	if ( $toolbar ) {

		global $wp_admin_bar;

		$wp_admin_bar->remove_menu( 'comments' );
		$wp_admin_bar->remove_menu( 'new-content' );

	}

}
add_action( 'wp_before_admin_bar_render', 'ab_custom_admin_toolbar', 999 );



// custom admin color scheme
function ab_custom_admin_scheme( $user_id ) {

	$scheme = 'default';

	$options = get_option( 'ab_options', ab_options_default() );

	if ( isset( $options['custom_scheme'] ) && ! empty( $options['custom_scheme'] ) ) {

		$scheme = sanitize_text_field( $options['custom_scheme'] );

	}

	$args = array( 'ID' => $user_id, 'admin_color' => $scheme );

	wp_update_user( $args );

}
add_action( 'user_register', 'ab_custom_admin_scheme' );

// custom login logo url
// function ab_get_dashboard_url( ) {
function ab_get_dashboard_url( $url ) {

	$options = get_option( 'ab_options', ab_options_default() );

	if ( isset( $options['dashboard_url'] ) && ! empty( $options['dashboard_url'] ) ) {

		$url = esc_url( $options['dashboard_url'] );

	}

	return $url;

}

// NOTE found online funciton to display query data need to test https://stackoverflow.com/questions/15251095/display-data-from-sql-database-into-php-html-table
function ab_display_data($data) {
    $output = "<table>";
    foreach($data as $key => $var) {
        //$output .= '<tr>';
        if($key===0) {
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= "<td>" . $col . '</td>';
            }
            $output .= '</tr>';
            foreach($var as $col => $val) {
                $output .= '<td>' . $val . '</td>';
            }
            $output .= '</tr>';
        }
        else {
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= '<td>' . $val . '</td>';
            }
            $output .= '</tr>';
        }
    }
    $output .= '</table>';
    echo $output;
}


// NOTE: FOUND THIS ONLINE, WAY TO ACTIVATE PLUGIN Could create a special admin page where when you go there it activates dev tools.
function ab_run_activate_plugin( $plugin ) {
    $current = get_option( 'active_plugins' );
    $plugin = plugin_basename( trim( $plugin ) );

    if ( !in_array( $plugin, $current ) ) {
        $current[] = $plugin;
        sort( $current );
        do_action( 'activate_plugin', trim( $plugin ) );
        update_option( 'active_plugins', $current );
        do_action( 'activate_' . trim( $plugin ) );
        do_action( 'activated_plugin', trim( $plugin) );
    }

    return null;
}
// ab_run_activate_plugin( 'akismet/akismet.php' ); EXAMPLE