# WordPress Full Site Editing - WP Templates and WP Global Styles purging

WordPress FSE themes save the editor templates modifications and global styles into the database and will use this data first while executing the template hierarchy.

This data is saved in two post types : **wp_template**  and **wp_global_styles**.

While developing FSE themes, you might want to easily clear this data, and this plugin will allow you to do just that.

## Warning !

Make sure to back up your database before deleting the data, as it cannot be recovered after deletion. You have been warned !!!

## Installation

1. Download the code as a zip file.
2. Upload the plugin files to the `/wp-content/plugins/fse-purge` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. Use the Settings > FSE Purge screen to delete the FSE templates and global styles.

## License

You are free to use, modify and publish this code as you wish.