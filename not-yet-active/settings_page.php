<?php

// THIS IS NOT YET WORKING


// Register options
function fcdev_register_settings() {
   add_option( 'block_all_emails', 'Yes please!');
   register_setting( 'fcdev_options_group', 'block_all_emails', '_block_all_emails' );
   add_option( 'block_woo_emails', 'Yes please!');
   register_setting( 'fcdev_options_group', 'block_woo_emails', '_block_all_emails' );
   add_option( 'enable_development_plugins', 'Yes please!');
   register_setting( 'fcdev_options_group', 'enable_development_plugins', '_enable_development_plugins' );
}

// Register options page
add_action( 'admin_init', 'fcdev_register_settings' );

function fcdev_register_options_page() {
  add_options_page('Page Title', 'Plugin Menu', 'manage_options', 'fcdev', 'fcdev_options_page');
}
add_action('admin_menu', 'fcdev_register_options_page');

function fcdev_options_page()
{
?>
  <div>
  <?php screen_icon(); ?>
  <h2>FC WP Developer Helper</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'fcdev_options_group' ); ?>
  <h3>Block all emails?</h3>
  <p>Make sure to disable in live</p>
  <table>
  <tr valign="top">
  <th scope="row"><label for="disable_all_emails">Label</label></th>
  <td><input type="text" id="disable_all_emails" name="disable_all_emails" value="<?php echo get_option('disable_all_emails'); ?>" /></td>
  </tr>
  </table>
  <h3>Block woocommerce emails?</h3>
  <p>Make sure to disable in live</p>
  <table>
  <tr valign="top">
  <th scope="row"><label for="disable_woo_emails">Label</label></th>
  <td><input type="text" id="disable_woo_emails" name="disable_woo_emails" value="<?php echo get_option('disable_woo_emails'); ?>" /></td>
  </tr>
  </table>
  <h3>Make backup, database migration, and development tool plugins active when logged in as admin (if they exist in the install)</h3>
  <p>Plugins are if exist All in One Migration, BackupBuddy, WP Migrate DB Pro</p>
  <table>
  <tr valign="top">
  <th scope="row"><label for="enable_development_plugins">Label</label></th>
  <td><input type="text" id="enable_development_plugins" name="enable_development_plugins" value="<?php echo get_option('enable_development_plugins'); ?>" /></td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
} ?>
