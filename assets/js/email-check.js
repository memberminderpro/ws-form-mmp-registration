jQuery(function ($) {
    const emailLabel = "Email Address";   // Must match WS Form label
    const accountFieldName = "AccountID"; // Must match WS Form internal field name
    const debounceDelay = 400;
  
    $(document).on('wsf-ready', function (event, formObject, formId) {
      console.log("🛰️ WS Form ready on form", formId);
  
      let emailFieldId = null;
      let accountFieldId = null;
  
      // Scan all fields in the form
      formObject.fields.forEach(function (field) {
        if (field.label === emailLabel) {
          emailFieldId = field.id;
        }
        if (field.name === accountFieldName) {
          accountFieldId = field.id;
        }
      });
  
      // Fallback if fields are missing
      if (!emailFieldId || !accountFieldId) {
        console.warn("⚠️ Required fields not found on form", formId);
        console.warn("Email Field Label:", emailLabel, "| AccountID Field Name:", accountFieldName);
  
        // TODO: Trigger fallback form field injector here (PHP-based or modal prompt)
        return;
      }
  
      const emailField = $(`#wsf-${formId}-field-${emailFieldId}`);
      const accountField = $(`#wsf-${formId}-field-${accountFieldId}`);
  
      if (!emailField.length || !accountField.length) {
        console.warn("❌ Could not locate email/account field DOM elements.");
        return;
      }
  
      console.log("✅ Binding email duplication checker on form", formId);
  
      let debounceTimer = null;
  
      emailField.on('input', function () {
        clearTimeout(debounceTimer);
  
        debounceTimer = setTimeout(function () {
          const email = emailField.val();
          const accountID = accountField.val();
  
          if (!email || !accountID) {
            console.log("⚠️ Missing email or account ID value");
            return;
          }
  
          console.log("📨 Checking email:", email);
          console.log("🆔 AccountID:", accountID);
  
          $.ajax({
            url: '/wp-admin/admin-ajax.php',
            method: 'POST',
            dataType: 'json',
            data: {
              action: 'validate_email_unique',
              email: email,
              account_id: accountID
            },
            success: function (response) {
              if (response.success && response.data.exists) {
                console.log("❌ Duplicate email found");
                wsf_invalid(emailFieldId, "This email is already in the system associated with a membership. Please <a href='/contact'>contact us</a> to change your membership type.");
                emailField.trigger('blur');
              } else {
                console.log("✅ Email is valid and unique");
                wsf_valid(emailFieldId);
  
                setTimeout(function () {
                  emailField.trigger('input change blur');
                  if (typeof wsf_validate === 'function') {
                    console.log("🔁 Triggering WS Form revalidation");
                    wsf_validate();
                  }
                }, 20);
              }
            },
            error: function (xhr, status, error) {
              console.warn("❗ AJAX error checking email:", error);
              wsf_valid(emailFieldId);
            }
          });
        }, debounceDelay);
      });
    });
  });
  