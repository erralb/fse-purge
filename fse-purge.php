<?php

/**
 * Plugin Name: FSE Purge
 * Description: Delete the FSE wp_template post type posts, useful for resetting the FSE templates while developing themes.
 * Version: 1.0.0
 * Author: Agence NN
 * Author URI: https://negative.network
 * Text Domain: fse-purge
 * License: GPL2
 */

//The default functions of a WordPress plugin
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Initialize the plugin
add_action('plugins_loaded', function () {
    new FSEPurge();
});

class FSEPurge
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu()
    {
        add_management_page(
            'FSE Purge',
            'FSE Purge',
            'manage_options',
            'fse-purge',
            array($this, 'render_admin_page')
        );
    }

    public function render_admin_page()
    {
        if (! current_user_can('manage_options')) {
            wp_die('Unauthorized user');
        }

        if (isset($_POST['fse_purge_action']) && $_POST['fse_purge_action'] === 'delete_templates') {
            if ($this->delete_templates()) {
                echo '<div class="notice notice-success is-dismissible"><p>All FSE templates have been deleted.</p></div>';
            } else {
                echo '<div class="notice notice-error is-dismissible"><p>Error deleting templates.</p></div>';
            }
        }

        // Fetch all wp_template posts to display count and list
        $templates = get_posts(array(
            'post_type' => 'wp_template',
            'numberposts' => -1,
            'post_status' => 'any',
        ));

?>
        <div class="wrap">
            <h1>FSE Purge</h1>
            <h2>FSE Templates</h2>
            <?php if (count($templates) > 0): ?>
                <ul>
                    <?php foreach ($templates as $template): ?>
                        <li><?php echo esc_html($template->post_title); ?> (ID: <?php echo $template->ID; ?>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No FSE templates found.</p>
            <?php endif; ?>
            <h2>Delete All FSE Templates</h2>
            <form method="post">
                <input type="hidden" name="fse_purge_action" value="delete_templates">
                <div style="background: #ffebe8; border: 1px solid #dd3c10; padding: 10px; margin-bottom: 20px;">
                    <p><b>Warning</b>: This action cannot be undone !!!</p>
                    <p>Make sure to backup the database before proceeding.</p>
                    <p>Clicking this button will delete <b>all</b> FSE templates (wp_template posts) permanently, for all users and themes</p>
                </div>
                <p><input type="submit" class="button button-primary" value="Delete FSE Templates"></p>
            </form>
        </div>
<?php
    }

    private function delete_templates()
    {
        $templates = get_posts(array(
            'post_type' => 'wp_template',
            'numberposts' => -1,
            'post_status' => 'any',
        ));

        foreach ($templates as $template) {
            wp_delete_post($template->ID, true);
        }

        return true;
    }
}

// Admin notice after deletion
add_action('admin_notices', function () {
    if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
        echo '<div class="notice notice-success is-dismissible"><p>All FSE templates have been deleted.</p></div>';
    }
});
