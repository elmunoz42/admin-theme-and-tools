# Fountain City Developer Helper Plugin #

## The purpose of this plugin is to make automatic the availability of certain plugins for the admin user only ##

### Status ###

Currently, the plugin simply makes available the plugins if they exist upon admin login. This means the plugins can be left deactivated which is much better for security reasons. Please note that if you schedule any cron jobs for Backupbuddy backups those won't run if you are not logged in.

In the future we want to incorporate some options for enabling and disabling emails to be used in stage environments. There are sketches of this code in the 'not-yet-active' folder (in dev branch).
