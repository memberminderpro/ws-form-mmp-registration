# WS Form MMP Registration Addon

This WordPress plugin extends [WS Form Pro](https://wsform.com) to support MMP (Member Minder Pro) membership registration workflows, including:

- Email duplication checking (live API validation)
- Dynamic Rotary club lookup (geographic filters)
- Optional integration with [DACdbPlus](https://wordpress.dacdb.com/plugins/dacdbplus/changelog) for shared AccountID detection

---

## Features

- **Email Validation**
  - Checks if an entered email is already in the MMP database
  - Disables submission and displays a customizable message if duplicate is found
  - Field detection is dynamic via WS Form’s `formObject` structure

- **Club Lookup**
  - Dynamically loads available clubs based on selected country and state
  - Integrates with Rotary and OSDIA APIs
  - Clean, real-time select or datagrid population

- **AccountID Integration**
  - Can pull AccountID automatically from DACdbPlus if installed
  - Falls back to hidden field input per form if DACdbPlus is not present

---

## Installation

1. Clone or download this repo into your WordPress `/wp-content/plugins/` directory:

   ```bash
   git clone https://github.com/memberminderpro/ws-form-mmp-registration.git
   ```

2. Activate the plugin via the WordPress admin

3. Ensure WS Form Pro is installed and active

4. Add the required fields to your form:
   - `Email Address` (type: Email)
   - `AccountID` (type: Hidden, or auto-injected from DACdbPlus)

---

## Form Setup Notes

This addon dynamically binds to WS Form fields using:
- Label: `"Email Address"`  
- Field name: `"AccountID"`

You **do not need to set fixed field IDs**. The plugin will automatically detect them.

If either field is missing, fallback logic will trigger (planned feature).

---

## Folder Structure

```
ws-form-mmp-registration/
├── assets/
│   └── js/
│       ├── email-check.js
│       └── club-lookup.js
├── includes/
│   ├── ajax/
│   ├── helpers/
│   ├── integration/
│   └── settings-page.php
├── templates/
├── ws-form-mmp-registration.php
├── uninstall.php
└── README.md
```

---

## Development

```bash
git clone git@github.com:memberminderpro/ws-form-mmp-registration.git
cd ws-form-mmp-registration
```

Pushes to `develop` will trigger deployment to the dev server.

---

## Roadmap

- [x] Dynamic field detection by label
- [x] Email validation via AJAX
- [ ] JSON fallback injection for missing fields
- [ ] Admin UI: status + DACdbPlus integration help
- [ ] Plugin settings page
- [ ] Deployment workflow with tag-based promotion

---

## License

© [Member Minder Pro, LLC](https://mmpro.llc). All rights reserved.