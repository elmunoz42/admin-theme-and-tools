
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


// Uploads file to the library view this tutorial: https://www.davidangulo.xyz/how-to-upload-files-in-wordpress-programmatically/
function ab_display_login_logo_page() {

  // check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

  if (isset($_POST['submit'])) {
    $upload_object = wp_upload_bits($_FILES['fileToUpload']['name'], null, file_get_contents($_FILES['fileToUpload']['tmp_name']));
    // var_dump($upload_object["url"]);
    update_option("ab_login_logo", $upload_object["url"]);
  }
  echo '<br>
    <form action="" method="post" enctype="multipart/form-data">
      <h1>Upload the Logo Page Image</h1><br>
      <input type="file" name="fileToUpload" accept=".png,.jpg,.svg" id="fileToUpload" placeholder=' . get_option("ab_login_logo") .'>
      <input type="submit" value="Upload Image" name="submit">
    </form><br>
  ';
  echo 'Current logo: ';
  echo get_option("ab_login_logo") ? get_option("ab_login_logo") : 'no logo set';

}

function ab_file_upload_renderer() {
  ob_start();
  ab_display_login_logo_page();
  return ob_get_clean();
}
add_shortcode('custom_file_uploader', 'ab_file_upload_renderer');