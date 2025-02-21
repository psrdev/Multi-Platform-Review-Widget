<?php
/**
 * Plugin Name: Multi-Platform Review Widget
 * Description: A WordPress plugin that allows website visitors to leave reviews across multiple platforms.
 * Version: 1.0
 * Author: Pravin Singh Rana
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class MultiPlatformReviewWidget
{
    public function __construct()
    {
        // Define plugin constants
        define('MPRW_PLUGIN_DIR', plugin_dir_path(__FILE__));
        define('MPRW_PLUGIN_URL', plugin_dir_url(__FILE__));

        // Include necessary files
        require_once MPRW_PLUGIN_DIR . 'admin.php';
        require_once MPRW_PLUGIN_DIR . 'widget.php';

        // Hooks
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('mprw-style', MPRW_PLUGIN_URL . 'style.css', array(), '1.0');
        wp_enqueue_script('mprw-script', MPRW_PLUGIN_URL . 'widget.js', array('jquery'), '1.0', true);
    }

    public function activate()
    {
        // Activation tasks
    }

    public function deactivate()
    {
        // Deactivation tasks
    }
}

// Initialize the plugin
new MultiPlatformReviewWidget();



