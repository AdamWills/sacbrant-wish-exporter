(function( $ ) {
	'use strict';
	$(document).ready(function() {
		$('.js__wish-datepicker-start').datepicker({
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			onSelect: function(date) {
				$(this).parent('div').removeClass('form-field-invalid');
				var toDate = $('.js__wish-datepicker-end'),
						minDate = $(this).datepicker('getDate');
				toDate.datepicker('setDate', minDate);
				toDate.datepicker('option', 'minDate', minDate);
			}
		});

		$('.js__wish-datepicker-end').datepicker({
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			onSelect: function(date) {
				$(this).parent('div').removeClass('form-field-invalid');
			}
		});

		$('.js__validate-wish-form').on('click', function() {
			var $fromDate = $('#wish-report-from'),
					$toDate = $('#wish-report-to'),
					$errorDisplay = $('#wish-report-errors'),
					$errorList = $errorDisplay.find('ul'),
					errors = [];

			if ('' === $fromDate.val()) {
				$fromDate.parent('div').addClass('form-field-invalid');
				errors.push('Please select a `from` date.');
			}

			if ('' === $toDate.val()) {
				$toDate.parent('div').addClass('form-field-invalid');
				errors.push('Please select a `to` date.');
			}

			if (errors.length) {
				$errorList.empty();
				for (var i = 0; i < errors.length; i++) {
					$errorList.append('<li>' + errors[i] + '</li>');
				}
				$errorDisplay.removeClass('hidden');
				return false;
			}
		});

	});
})( jQuery );
