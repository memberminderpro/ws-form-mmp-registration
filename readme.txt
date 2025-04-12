=== WS Form MMP Registration Addon ===
Contributors: memberminderpro, Akaienso
Tags: ws form, membership, registration, rotary, dacdb, email validation, dynamic forms
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 0.0.1
License: Proprietary
License URI: https://memberminderpro.com/license

This addon for WS Form Pro enables dynamic MMP (Member Minder Pro) registration form features, including email duplication checking and Rotary club lookup.

== Description ==

The WS Form MMP Registration Addon extends [WS Form Pro](https://wsform.com) to provide advanced validation and dynamic form features for membership registration workflows managed through Member Minder Pro (MMP).

**Features include:**

* Real-time email duplication validation via MMP API
* Dynamic Rotary club lookup using country and state selection
* Optional AccountID integration with DACdbPlus plugin (if installed)
* Clean, unobtrusive client-side validation experience

== Installation ==

1. Upload the plugin to your `/wp-content/plugins/` directory, or install via Git if applicable:

```bash
git clone https://github.com/memberminderpro/ws-form-mmp-registration.git
```

2. Activate the plugin through the 'Plugins' screen in WordPress
3. Ensure WS Form Pro is installed and active
4. Add required fields to any registration form:
   * A field labeled **Email Address**
   * A hidden field named **AccountID** (or allow the plugin to pull from DACdbPlus)

== Frequently Asked Questions ==

= Does this plugin work without WS Form Pro? =
No. This is an extension built specifically for WS Form Pro and requires it to function.

= Can I use this on multiple forms across my site? =
Yes. The plugin uses dynamic field detection and will bind to any WS Form instance that includes the required fields.

= What if DACdbPlus isn't installed? =
You can provide an AccountID via a hidden WS Form field. If DACdbPlus is installed, it will be auto-detected.

== Screenshots ==

1. Dynamic email validation message displayed under the email field
2. Select dropdown populated with Rotary clubs by country/state

== Changelog ==

= 0.0.1 =
* Initial working release
* Includes email validation via AJAX and dynamic field detection

== Upgrade Notice ==

= 0.0.1 =
Initial release of email validation and dynamic lookup features for WS Form Pro and MMP clients.

