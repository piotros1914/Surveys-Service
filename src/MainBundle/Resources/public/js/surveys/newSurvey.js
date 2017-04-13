jQuery(document).ready(function() {

	var fieldPreName = '#new_survey_survey_activity_';
	var answerLimitID = fieldPreName + 'answerLimit';
	var endDateID = fieldPreName + 'endDate';
	var is_alwaysActiveID = fieldPreName + 'is_alwaysActive';
	$('.activity').parent().parent().hide();

	$(document).on('change', '.activity_select', function() {
		$('.activity').parent().parent().hide();
		clearActivity();
		changeType(this);

	});

	function clearActivity() {
		$('.activity').val(null);
	}

	function changeType(activity_select) {
		var activity_select_val = $(activity_select).val();
		$(fieldPreName + activity_select_val).parent().parent().show();

		if (activity_select_val == 'is_alwaysActive')
			$(is_alwaysActiveID).val(1);

	}

	$("#new_survey_survey_activity_endDate").datepicker({
		weekStart : 1,
		format : 'yyyy-mm-dd'
	});

	$('.form-group:first > .col-sm-4').remove();
	$('.form-group:first > .col-sm-8').attr("class", "col-sm-12");

}

);