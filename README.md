# Fountain City Developer Helper Plugin #

## The purpose of this plugin is to make automatic the availability of certain plugins for the admin user only ##

### Status ###

The purpose of this plugin is to provide development tools like database migration, remote backups, and debugging tools in a streamlined manner. One of the main functionalities is an automatic activation of BackupBuddy, Wp Migrate Db pro, and Query Monitor (if exist).
Upon logout the plugins are deactivated.

Other functionality is being experimented with as well including an admin tab and a dashboard widget. Additionally, there's is some deprecated code to unhook woocommerce emails that we would like to refurbish, that code is currently innactive in the "not-yet-active" folder.

### Goals: ###

- To create an options page where you can set which plugins (if at all) you want to auto update.
- To create an idle functionality where a popup comes up and checks if you are still working otherwise it deactivates the dev plugins. 

### Known Issues: ###

- The admin bar link to activate and deactivate BackupBuddy doesn't work because of the nonce value not being correct. (Compare that link to the deactivate link in the plugins page, you could copy that link exactly which would work for 24 hours until there is a new nonce value. Obviously, that is not the real solution.)
- Sometimes the dev plugins are mysteriously deactivating on page refresh, perhaps there's a logic loophole or an issue with the transient variable not loading correctly.
