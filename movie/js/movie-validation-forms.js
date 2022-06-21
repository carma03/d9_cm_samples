/**
 * @file movie-validation-forms.js
 *
 */

 (function ($, Drupal) {
  'use strict';

  Drupal.behaviors.movie_validation_forms = {
    attach: function(context, settings) {

      // Highlight the release_date field in red if the inputted date
      // is in the future.
      const $movieForm = $('form.movie-form', context);
      if ($movieForm.length > 0) {
        const $releaseDateField = $movieForm.find('input[name="release_date[0][value][date]"]');
        if ($releaseDateField.length > 0) {
          $releaseDateField.on('change', function(evt) {
            let value = $(this).val();
            if (value.length > 0) {
              value = new Date(value);
              if (value > new Date()) {
                $(this).addClass('error');
              } else {
                $(this).removeClass('error');
              }
            }
          });
        }

      }
    }
  }
})(jQuery, Drupal);
