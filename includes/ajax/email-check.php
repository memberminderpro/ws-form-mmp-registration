<?php
// Bail if accessed directly
defined('ABSPATH') || exit;

add_action('wp_ajax_validate_email_unique', 'mmp_validate_email_unique');
add_action('wp_ajax_nopriv_validate_email_unique', 'mmp_validate_email_unique');

function mmp_validate_email_unique() {
    $email      = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $account_id = isset($_POST['account_id']) ? sanitize_text_field($_POST['account_id']) : '';

    if (!$email || !$account_id) {
        wp_send_json_error(['message' => 'Missing required parameters.']);
    }

    $url = add_query_arg([
        'AccountID' => $account_id,
        'email'     => $email,
        'IsActive'  => 'Y',
    ], 'https://www.emembersdb.com/Lookup/EMailCheck.cfm');

    $response = wp_remote_get($url, [
        'timeout' => 10,
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]);

    if (is_wp_error($response)) {
        wp_send_json_error(['message' => 'Unable to complete request.']);
    }

    $body   = trim(wp_remote_retrieve_body($response));
    $exists = ($body === '1');

    wp_send_json_success(['exists' => $exists]);
}
