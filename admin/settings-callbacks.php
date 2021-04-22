<?php // Aaadmin-Boss - Settings Callbacks



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



// callback: login section
function ab_callback_section_login() {

	echo '<p>These settings enable you to customize the WP Login screen.</p>';

}



// callback: admin section
function ab_callback_section_admin() {

	echo '<p>These settings enable you to customize the WP Admin Area.</p>';

}


// callback: text field for logo
function ab_callback_field_text( $args ) {

	$options = get_option( 'ab_options', ab_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	echo '<input id="ab_options_'. $id .'" name="ab_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="ab_options_'. $id .'">'. $label .'</label>';

}



// radio field options
function ab_options_radio() {

	return array(

		'enable'  => 'Enable custom styles',
		'disable' => 'Disable custom styles'

	);

}



// callback: radio field
function ab_callback_field_radio( $args ) {

	$options = get_option( 'ab_options', ab_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	$radio_options = ab_options_radio();

	foreach ( $radio_options as $value => $label ) {

		$checked = checked( $selected_option === $value, true, false );

		echo '<label><input name="ab_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'> ';
		echo '<span>'. $label .'</span></label><br />';

	}

}



// callback: textarea field
function ab_callback_field_textarea( $args ) {

	$options = get_option( 'ab_options', ab_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$allowed_tags = wp_kses_allowed_html( 'post' );

	$value = isset( $options[$id] ) ? wp_kses( stripslashes_deep( $options[$id] ), $allowed_tags ) : '';

	echo '<textarea id="ab_options_'. $id .'" name="ab_options['. $id .']" rows="5" cols="50">'. $value .'</textarea><br />';
	echo '<label for="ab_options_'. $id .'">'. $label .'</label>';

}



// callback: checkbox field
function ab_callback_field_checkbox( $args ) {

	$options = get_option( 'ab_options', ab_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$checked = isset( $options[$id] ) ? checked( $options[$id], 1, false ) : '';

	echo '<input id="ab_options_'. $id .'" name="ab_options['. $id .']" type="checkbox" value="1"'. $checked .'> ';
	echo '<label for="ab_options_'. $id .'">'. $label .'</label>';

}



// select field options
function ab_options_select() {

	return array(

		'default'   => 'Default',
		'light'     => 'Light',
		'blue'      => 'Blue',
		'coffee'    => 'Coffee',
		'ectoplasm' => 'Ectoplasm',
		'midnight'  => 'Midnight',
		'ocean'     => 'Ocean',
		'sunrise'   => 'Sunrise',

	);

}



// callback: select field
function ab_callback_field_select( $args ) {

	$options = get_option( 'ab_options', ab_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	$select_options = ab_options_select();

	echo '<select id="ab_options_'. $id .'" name="ab_options['. $id .']">';

	foreach ( $select_options as $value => $option ) {

		$selected = selected( $selected_option === $value, true, false );

		echo '<option value="'. $value .'"'. $selected .'>'. $option .'</option>';

	}

	echo '</select> <label for="ab_options_'. $id .'">'. $label .'</label>';

}

// callback: text field for dashboard
function ab_callback_field_text2( $args ) {

	$options = get_option( 'ab_options', ab_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	echo '<input id="ab_options_'. $id .'" name="ab_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="ab_options_'. $id .'">'. $label .'</label>';

}
