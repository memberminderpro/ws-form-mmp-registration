jQuery(function($) {
    $(document).on('wsf-ready', function(event, formObject, formId) {
      // your script logic goes here
      console.log('🔁 WS Form ready on form ID:', formId);
    });
  });
  