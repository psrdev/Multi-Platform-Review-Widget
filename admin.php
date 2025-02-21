<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class MPRW_Admin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_admin_menu()
    {
        add_menu_page(
            'Multi-Platform Review Widget',
            'Review Widget',
            'manage_options',
            'mprw-settings',
            [$this, 'settings_page'],
            'dashicons-star-filled',
            100
        );
    }

    public function register_settings()
    {
        register_setting('mprw_options_group', 'mprw_options', [$this, 'sanitize_options']);
    }

    public function sanitize_options($input)
    {
        $sanitized_input = array();

        if (!empty($input['platforms'])) {
            foreach ($input['platforms'] as $index => $platform) {

                $sanitized_input['platforms'][$index]['link'] = esc_url_raw($platform['link']);
            }
        }


        $sanitized_input['cta_text'] = sanitize_text_field($input['cta_text']);


        return $sanitized_input;
    }

    public function settings_page()
    {
        $default_options = array(
            'cta_text' => 'Review Us On',
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
}

// Initialize the admin class
new MPRW_Admin();

