# Fountain City Developer Tools Plugin #

## The purpose of this plugin is to streamline the workflow of wp development and to provide wholistic KPI insights for client and dev (by leveraging Google Data Studio integration)##

### Status ###

The purpose of this plugin is to provide development tools like database migration, remote backups, and debugging tools in a streamlined manner. One of the main functionalities is an automatic activation of BackupBuddy, Wp Migrate Db pro, and Query Monitor (if exist).
Upon logout the plugins are deactivated.

Other functionality is being experimented with as well including an admin tab and a dashboard widget. Additionally, there's is some deprecated code to unhook woocommerce emails that we would like to refurbish, that code is currently innactive in the "not-yet-active" folder.

### Goals: ###

- A settings page per plugin dev tutorial adding field for GDS dashboard link for embed.
- Style login page with logo option.
- Add menu links to media library, Backupbuddy, Litespeed, WP Migrate DB, Query Monitor, GDS dashboard, and plugins page.
- Page for Google Data Studio dashboard
- Function for displaying queries as tables
- Activate dev plugins with confirmation popup and deactivate automatically.
- Tell devs if another admin is onsite.
- Expand debugging functions.
- Idle functionality where a popup comes up and checks if you are still working otherwise it deactivates the dev plugins.

### Known Issues: ###

- The admin bar link to activate and deactivate BackupBuddy doesn't work because of the nonce value not being correct. (Compare that link to the deactivate link in the plugins page, you could copy that link exactly which would work for 24 hours until there is a new nonce value. Obviously, that is not the real solution.)
- Sometimes the dev plugins are mysteriously deactivating on page refresh, perhaps there's a logic loophole or an issue with the transient variable not loading correctly.
