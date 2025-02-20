<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add widget to footer
function mprw_add_widget()
{
    $options = get_option('mprw_options');
    ?>
    <div id="mprw-widget" class="mprw-widget bottom-right">
        <div class="mprw-widget-button">
            <?php echo esc_html($options['cta_text']); ?>
        </div>

    </div>
    <?php

}
add_action('wp_footer', 'mprw_add_widget');

