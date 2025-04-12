<?php
defined('ABSPATH') || exit;

// Register the admin menu item
add_action('admin_menu', function () {
    add_options_page(
        'MMP Registration Settings',
        'MMP Registration',
        'manage_options',
        'mmp-registration-settings',
        'mmp_render_settings_page'
    );
});

function mmp_render_settings_page() {
    echo '<div class="wrap">';
    echo '<h1>WS Form MMP Registration Settings</h1>';

    if (class_exists('Mmpro\\DACdbPlus\\Core')) {
        // DACdbPlus plugin is present — try to get AccountID
        if (method_exists('Mmpro\\DACdbPlus\\Core', 'get_instance')) {
            $instance = Mmpro\DACdbPlus\Core::get_instance();
            $account_id = method_exists($instance, 'get_account_id') ? $instance->get_account_id() : 'Unavailable';

            echo '<p><strong>✅ DACdbPlus detected.</strong></p>';
            echo '<p><strong>AccountID:</strong> ' . esc_html($account_id) . '</p>';
        } else {
            echo '<p><strong>⚠️ DACdbPlus detected, but instance method not available.</strong></p>';
        }
    } else {
        echo '<p><strong>❌ DACdbPlus is not active.</strong></p>';
        echo '<p>Please install or activate the DACdbPlus plugin, or use a hidden AccountID field in your WS Form.</p>';
    }

    echo '</div>';
}
