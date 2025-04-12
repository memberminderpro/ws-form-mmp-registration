<?php
/*
Plugin Name: WS Form MMP Registration
Description: Adds validation and club lookup features for MMP membership registration forms built with WS Form.
Version: 0.0.1
Author: Member Minder Pro, LLC
*/

defined('ABSPATH') || exit;

// Autoload Composer classes
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Core includes
require_once __DIR__ . '/includes/ajax/email-check.php';
require_once __DIR__ . '/includes/ajax/club-lookup.php';

add_action('plugins_loaded', function () {
    if (class_exists('WS_Form_Common')) {
        new \Mmpro\WSFormRegistration\Integration\RegistrationAction();
    }
});

function mmp_register_form_scripts() {
    wp_enqueue_script(
        'mmp-email-check',
        plugin_dir_url(__FILE__) . 'assets/js/email-check.js',
        ['jquery'],
        '1.0.0',
        true
    );
    wp_enqueue_script(
        'mmp-club-lookup',
        plugin_dir_url(__FILE__) . 'assets/js/club-lookup.js',
        ['jquery'],
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'mmp_register_form_scripts');
