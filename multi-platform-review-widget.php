<?php
/**
 * Plugin Name: Multi-Platform Review Widget
 * Description: A WordPress plugin that allows website visitors to leave reviews across multiple platforms.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('MPRW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MPRW_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once MPRW_PLUGIN_DIR . 'admin.php';
require_once MPRW_PLUGIN_DIR . 'widget.php';

// Enqueue scripts and styles
function mprw_enqueue_scripts()
{
    wp_enqueue_style('mprw-style', MPRW_PLUGIN_URL . 'style.css', array(), '1.0');
    wp_enqueue_script('mprw-script', MPRW_PLUGIN_URL . 'widget.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'mprw_enqueue_scripts');

// Activation hook
function mprw_activate()
{

}
register_activation_hook(__FILE__, 'mprw_activate');

// Deactivation hook
function mprw_deactivate()
{
    // Cleanup tasks if needed
}
register_deactivation_hook(__FILE__, 'mprw_deactivate');



