## ✅ Phase 1: **DACdbPlus Settings Integration**

### 🧱 Store settings in `mmp_plus_options`

- Use `get_option('mmp_plus_options')`  
- Store custom settings in a `ws_form_custom` key:
  ```php
  [
    'ws_form_custom' => [
      'enabled' => true,
      'forms' => [
        'ragfp-registration' => [
          'email_validation' => true,
          'club_lookup' => true,
          'default_club_id' => '99999',
          'account_id' => '123456',
        ],
        // other form slugs can follow this pattern
      ]
    ]
  ]
  ```

- On plugin activation, check if `ws_form_custom` exists in `mmp_plus_options`; if not, inject default RAGFP config.

---

## ✅ Phase 2: **Lite/Pro Detection Logic**

Add this early in your plugin:

```php
define('WSF_IS_PRO', class_exists('WS_Form_Common') && class_exists('WS_Form_Addon'));
```

Use this flag to conditionally load the Pro-only tab.

---

## ✅ Phase 3: **WS Form Pro Tab for Docs + Link**

If Pro is detected, register a read-only settings tab:

```php
if (defined('WSF_IS_PRO') && WSF_IS_PRO) {
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
}
```

---

## ✅ Phase 4: **Frontend Logic Reads from DACdbPlus**

Instead of plugin-specific options, always read from:

```php
$options = get_option('mmp_plus_options');
$custom = $options['ws_form_custom']['forms']['ragfp-registration'] ?? null;
```

Inject these into `wp_localize_script()` for frontend JS use.

---

## ✅ Phase 5: **On Activation – Inject Defaults if Missing**

In your activation hook:

```php
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
```

---

## ✅ Optional: Admin Notice in WS Form Lite Mode

If WS Form Lite is detected:

```php
if (!WSF_IS_PRO) {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-info"><p><strong>MMP Registration</strong> is running in WS Form Lite mode. All configuration must be done via DACdbPlus settings.</p></div>';
    });
}
```

---

Would you like me to assemble this into a new `SettingsManager` class or plain procedural file and commit it into a specific branch of the GitHub repo?