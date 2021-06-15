
<?php



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

$abOption = get_option("ab_login_logo");

// Determine if field is not in Database
if($abOption === FALSE) {
    add_option("ab_login_logo");
}

// Load Required WordPress Uploader Script
// NOTE: Currently having issue with ab-upload so the script is added in this template in the meantime. Need to fix and refactor.
function ab_options_enqueue_scripts() {
    wp_register_script( 'ab-upload', plugins_url('/public/js/ab-upload.js', __FILE__), array('jquery','media-upload','thickbox') );

    wp_enqueue_script('jquery');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');

    wp_enqueue_script('media-upload');
    wp_enqueue_script('ab-upload');
}

add_action('admin_enqueue_scripts', 'ab_options_enqueue_scripts');

function ab_display_login_logo_page() {
   

    // Option B 

?> 
<!-- https://artisansweb.net/upload-files-programmatically-wordpress/ -->
<h2>Upload a File</h2>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" required />
    <input type="submit" name="upload_file" value="Upload" />
</form>

<?php
    // End Option B


    // check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

   $abOption = get_option("ab_login_logo"); 
   ?>


   <!-- Option A -->
    <form id="form-options" action="" type="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td valign='top'><label>Logo Image : </label></td>
            <td valign='top'>
                <input type='text' id='logo_url' readonly='readonly' name='logo' size='40' value='<?php echo esc_url( $abOption ) ?>'/>
                <input id='upload_button' type='button' class='button' value='Upload Logo' />
                <br />
                <em>size should be 188x69</em>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <input name="submit" id="submit_option" type="submit" class="button button-primary" value="<?php esc_attr_e('Save Settings', 'ab'); ?>" />
            </td>
        <tr>
    </table>
    </form>

    <script>
    jQuery(document).ready(function ($) {
    alert("Hello");
    $('#upload_button').click(function () {
        tb_show('Upload a logo', 'media-upload.php?type=image&TB_iframe=true&post_id=0', false);
        alert($_POST['logo']);
        return false;
    });

    // Display the Image link in TEXT Field
    window.send_to_editor = function (html) {
        var image_url = $('img', html).attr('src');
        $('#logo_url').val(image_url);
        tb_remove();
    }
});
    </script>

    <?php
    // Save to database NOT WORKING
    if( isset($_POST['submit']) ) update_option("ab_login_logo", $_POST['logo']);
}

?>



<?php
function fn_upload_file() {
    if ( isset($_POST['upload_file']) ) {
        $upload = wp_upload_bits($_FILES['file']['name'], null, $_FILES['file']['tmp_name']);
        // save into database $upload['url]
    }
}
add_action('init', 'fn_upload_file');

 