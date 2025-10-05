# WordPress Full Site Editing - wp_template purging

WordPress FSE themes save the editor templates modifications into the database and will use this data first while executing the template hierarchy.

This data is saved in a **wp_template** post type.

While developing FSE themes, you might want to easily clear this data, and this plugin will allow you to do just that.

## Warning !

 Make sure to back up your database before deleting the wp_template post types, as it cannot be recovered after deletion.

 You have been warned !