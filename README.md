# Aaadmin Boss - Admin Theme and Tools Plugin #

## The purpose of this plugin is to brand the backend and login (a bit), streamline the workflow of wp development and to provide wholistic KPI insights for client and dev (by leveraging Google Data Studio integration) ##

### Status ###

The purpose of this plugin is to provide development tools like database migration, remote backups, and debugging tools in a streamlined manner. One of the main functionalities is an automatic activation of BackupBuddy, Wp Migrate Db pro, and Query Monitor (if exist).
Upon logout the plugins are deactivated.

Other functionality is being experimented with as well including an admin tab and a dashboard widget. Additionally, there's is some deprecated code to unhook woocommerce emails that we would like to refurbish, that code is currently innactive in the "not-yet-active" folder.

### Goals: ###

| Status       | Description   |Note    |
| ------------- |:-------------|:-------|
|In Progress|A settings page per plugin dev tutorial adding field for GDS dashboard link for embed|Needs upload login logo functionality|
|QA|Page for Google Data Studio dashboard|Need to look into what we want it to do when someone doesn't yet have a dashboard.|
|In Progress|Style login page with logo option, unfortunately tutorial shows how to customize the logo url but not the logo itself. See from awakenings project|Need to make to figure out a solution for uploading the logo and displaying it programmatically.|
|In Progress|Add menu links to media library, Backupbuddy, Litespeed, WP Migrate DB, Query Monitor, GDS dashboard, and plugins page.|Need to Make the links conditional on the active status of those plugins and the whole shortcut menu should only appear for admins.|
|In Progress|Function for displaying queries as tables||
|In Progress|Activate dev plugins with confirmation popup and deactivate automatically.|Currently you can activate backup buddy and it will update you that changes where made in the dev tools page (available in settins page and shortcut). Function now also deactivates the plugin.|
|In Progress|Tell devs if another admin is onsite|Currently you can see who is logged in in the regular dashboard widget, but a popup would be a good improvement.|
|In Progress|Expand debugging functions||
|New|Idle functionality where a popup comes up and checks if you are still working otherwise it deactivates the dev plugins||
|New|Add an integration with the redmine ticketing system api to create a ticket right from the wp dashboard perhaps following this forum discussion: https://www.redmine.org/boards/2/topics/16260 ||

### Known Issues: ###

- The admin bar link to activate and deactivate BackupBuddy doesn't work because of the nonce value not being correct. (Compare that link to the deactivate link in the plugins page, you could copy that link exactly which would work for 24 hours until there is a new nonce value. Obviously, that is not the real solution.) In the meantime I've made it so that the link just takes you to the plugins page search for backup buddy so deactivation is one click away. One possible solution is to create an admin page that has the new script to activate plugins saves a transient token and then when you return deactivates the "dev tools" plugins... so "activate dev tools", "deactivate dev tools". And in the settings page you could add the dev tools plugins that you want to be part of this. 
- Sometimes the dev plugins are mysteriously deactivating on page refresh, perhaps there's a logic loophole or an issue with the transient variable not loading correctly.
