<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu
function mprw_add_admin_menu()
{
    add_menu_page(
        'Multi-Platform Review Widget',
        'Review Widget',
        'manage_options',
        'mprw-settings',
        'mprw_settings_page',
        'dashicons-star-filled',
        100
    );
}
add_action('admin_menu', 'mprw_add_admin_menu');

// Register settings
function mprw_register_settings()
{
    register_setting('mprw_options_group', 'mprw_options', 'mprw_sanitize_options');
}
add_action('admin_init', 'mprw_register_settings');

// Sanitize and validate input
function mprw_sanitize_options($input)
{
    $sanitized_input = array();

    if (!empty($_FILES['mprw_options']['name']['platforms'])) {
        foreach ($_FILES['mprw_options']['name']['platforms'] as $index => $file) {
            if (!empty($file['icon'])) {
                $uploaded_file = wp_handle_upload(array(
                    'name' => $_FILES['mprw_options']['name']['platforms'][$index]['icon'],
                    'type' => $_FILES['mprw_options']['type']['platforms'][$index]['icon'],
                    'tmp_name' => $_FILES['mprw_options']['tmp_name']['platforms'][$index]['icon'],
                    'error' => $_FILES['mprw_options']['error']['platforms'][$index]['icon'],
                    'size' => $_FILES['mprw_options']['size']['platforms'][$index]['icon'],
                ), array('test_form' => false));

                if (isset($uploaded_file['url'])) {
                    $input['platforms'][$index]['icon_url'] = $uploaded_file['url'];
                }
            }
        }
    }

    if (!empty($input['platforms'])) {
        foreach ($input['platforms'] as $index => $platform) {
            $sanitized_input['platforms'][$index]['name'] = sanitize_text_field($platform['name']);
            $sanitized_input['platforms'][$index]['icon_url'] = esc_url_raw($platform['icon_url']);
            $sanitized_input['platforms'][$index]['link'] = esc_url_raw($platform['link']);
        }
    }

    $sanitized_input['widget_color'] = sanitize_hex_color($input['widget_color']);
    $sanitized_input['widget_text_color'] = sanitize_hex_color($input['widget_text_color']);
    $sanitized_input['widget_position'] = sanitize_text_field($input['widget_position']);
    $sanitized_input['cta_text'] = sanitize_text_field($input['cta_text']);
    $sanitized_input['popup_enabled'] = isset($input['popup_enabled']) ? true : false;
    $sanitized_input['popup_delay'] = absint($input['popup_delay']);

    return $sanitized_input;
}

// Settings page HTML
function mprw_settings_page()
{
    $default_options = array(
        'cta_text' => '',
        'platforms' => array(
            'google' => array('link' => ''),
            'facebook' => array('link' => ''),
            'tripadvisor' => array('link' => ''),
            'trustpilot' => array('link' => ''),
        ),
    );

    $options = get_option('mprw_options', $default_options);
    $options = wp_parse_args($options, $default_options);
    ?>
    <div class="wrap">
        <h1>Multi-Platform Review Widget Settings</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php settings_fields('mprw_options_group'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Call-to-Action Text</th>
                    <td><input type="text" name="mprw_options[cta_text]"
                            value="<?php echo esc_attr($options['cta_text']); ?>"></td>
                </tr>
                <tr>
                    <td>
                        <table id="platforms-table">
                            <tr>
                                <th>Platform</th>
                                <th>Link</th>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?php echo MPRW_PLUGIN_URL . 'assets/google.svg'; ?>" width="30px"
                                        height="30px" title="Google">
                                </td>
                                <td>
                                    <input type="text" name="mprw_options[platforms][google][link]"
                                        value="<?php echo esc_attr($options['platforms']['google']['link']); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?php echo MPRW_PLUGIN_URL . 'assets/facebook.svg'; ?>" width="30px"
                                        height="30px" title="Facebook">
                                </td>
                                <td>
                                    <input type="text" name="mprw_options[platforms][facebook][link]"
                                        value="<?php echo esc_attr($options['platforms']['facebook']['link']); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?php echo MPRW_PLUGIN_URL . 'assets/tripadvisor.svg'; ?>" width="30px"
                                        height="30px" title="Tripadvisor">
                                </td>
                                <td>
                                    <input type="text" name="mprw_options[platforms][tripadvisor][link]"
                                        value="<?php echo esc_attr($options['platforms']['tripadvisor']['link']); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?php echo MPRW_PLUGIN_URL . 'assets/trustpilot.svg'; ?>" width="30px"
                                        height="30px" title="Trustpilot">
                                </td>
                                <td>
                                    <input type="text" name="mprw_options[platforms][trustpilot][link]"
                                        value="<?php echo esc_attr($options['platforms']['trustpilot']['link']); ?>">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

