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
            <div class="mprw-widget-cta"><?php echo esc_html($options['cta_text'] ?? ''); ?></div>
            <ul class="mprw-widget-platforms">
                <li><a href="<?php echo esc_url($options['platforms']['google']['link'] ?? '#'); ?>"><img
                            src="<?php echo MPRW_PLUGIN_URL . "assets/google.svg" ?>" alt="Google" width="30px"
                            height="30px"></a></li>
                <li><a href="<?php echo esc_url($options['platforms']['facebook']['link'] ?? '#'); ?>"><img
                            src="<?php echo MPRW_PLUGIN_URL . "assets/facebook.svg" ?>" alt="Facebook" width="30px"
                            height="30px"></a></li>
                <li><a href="<?php echo esc_url($options['platforms']['tripadvisor']['link'] ?? '#'); ?>"><img
                            src="<?php echo MPRW_PLUGIN_URL . "assets/tripadvisor.svg" ?>" alt="Tripadvisor" width="30px"
                            height="30px"></a></li>
                <li><a href="<?php echo esc_url($options['platforms']['trustpilot']['link'] ?? '#'); ?>"><img
                            src="<?php echo MPRW_PLUGIN_URL . "assets/trustpilot.svg" ?>" alt="Trustpilot" width="30px"
                            height="30px"></a></li>
            </ul>
        </div>
    </div>
    <?php

}
add_action('wp_footer', 'mprw_add_widget');

