<?php
/**
 * Plugin Name: WS Form MMP Registration
 * Description: Adds WS Form features integrated with DACdbPlus settings. Requires WS Form (Lite or Pro) and DACdbPlus.
 * Author: Member Minder Pro
 * Version: 1.0.0
 */

// Define if WS Form Pro is available
define('WSF_IS_PRO', class_exists('WS_Form_Common') && class_exists('WS_Form_Addon'));

// Hook into plugins_loaded
add_action('plugins_loaded', function () {
    if (!function_exists('get_option')) return;

    // Load settings from DACdbPlus options
    $options = get_option('mmp_plus_options', []);
    $form_settings = $options['ws_form_custom']['forms']['ragfp-registration'] ?? null;

    // Inject default settings on activation if not present
    register_activation_hook(__FILE__, function () {
        $options = get_option('mmp_plus_options', []);
        if (empty($options['ws_form_custom'])) {
            $options['ws_form_custom'] = [
                'enabled' => true,
                'forms' => [
                    'ragfp-registration' => [
                        'email_validation' => true,
                        'club_lookup' => true,
                        'default_club_id' => '99999',
                        'account_id' => '123456',
                    ]
                ]
            ];
            update_option('mmp_plus_options', $options);
        }
    });

    // Register WS Form Pro tab if Pro is available
    if (WSF_IS_PRO) {
        add_filter('wsf_settings_tabs', function ($tabs) {
            $tabs['mmp_registration'] = [
                'label' => __('MMP Registration', 'ws-form-mmp-registration'),
                'icon'  => 'fas fa-id-badge',
            ];
            return $tabs;
        });

        add_filter('wsf_settings_form_fields', function ($fields) {
            $fields['mmp_registration'] = [
                [
                    'id'    => 'mmp_info',
                    'label' => __('Settings Location', 'ws-form-mmp-registration'),
                    'type'  => 'html',
                    'html'  => '<p>Settings for WS Form MMP Registration are now managed in the <a href="' . admin_url('options-general.php?page=mmp-settings') . '">DACdbPlus Settings</a>.</p>',
                ]
            ];
            return $fields;
        });
    } else {
        // Lite mode admin notice
        add_action('admin_notices', function () {
            echo '<div class="notice notice-info"><p><strong>WS Form MMP Registration</strong> is running in WS Form Lite mode. All configuration must be done via DACdbPlus settings.</p></div>';
        });
    }
});
