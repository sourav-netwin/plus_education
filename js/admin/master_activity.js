/*
	Description : This js file is used to manage all the javascript related operations
					for the master activity module
	Version : 0.3
*/
$(document).ready(function(){
	//For datepicker
	$('.datepicker').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true
	});

	//For timepicker
	$('.timepicker').datetimepicker({
		pickDate: false
	});

	//After click on the add more icon it will clone the current one and append after that
	$(document).on('click' , '.addMoreTable' , function(){
		if($(this).parent().find('i').length == 1)
			$(this).parent().append('<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>');
		$(this).parent().parent().after($(this).parent().parent().clone());
		$(this).parent().parent().next().find('input:text').val('');
		$(this).parent().parent().next().find('.showErrorMsg').text('');
		$('.timepicker').datetimepicker({
			pickDate: false
		});
	});

	//After click on the remove more icon it will remove current content
	$(document).on('click' , '.removeMoreTable' , function(){
		$(this).parent().parent().remove();
		if($('.addMoreWrapper').length == 1)
			$('.addMoreWrapper').find('.removeMoreTable').remove();
	});

	//Check form validation using jquery validator
	$('#masterActivityForm').validate({
		errorElement : 'span',
		rules : {
			centre_id : {
				required : true
			},
			date : {
				required : true
			}
		},
		messages : {
			centre_id : {
				required : please_select_dynamic.replace('**field**' , 'centre')
			},
			date : {
				required : please_enter_dynamic.replace('**field**' , 'date')
			}
		}
	});

	//On submit of the form it check the duplicate and sub tables validation
	$('#masterActivityForm').submit(function(e){
		if($(this).valid())
		{
			if($('#globalErrorFlag').val() == 2)
				return true;
			e.preventDefault();
			//Check if any record present for the centre and the date through ajax
			$.ajax({
				url : baseUrl+'master_activity/duplicate',
				type : 'POST',
				data : {
							'centre_id' : $('#centre_id').val(),
							'date' : $('#date').val(),
							'flag' : flag,
							'id' : id
				},
				dataType : 'JSON',
				success : function(response){
					if(response.total == 0)
					{
						$('.showDuplicateError').text('');
						var errorFlag = 1;
						//Check the validations for add more program name fields
						$('input[name="program_name[]"]').each(function(){
							if($(this).val() == '')
							{
								$(this).next('.showErrorMsg').text(please_select_dynamic.replace('**field**' , 'program name')).css('display' , 'block');
								errorFlag = 2;
							}
							else
								$(this).next('.showErrorMsg').text('');
						});
						//Check the validations for add more location fields
						$('input[name="location[]"]').each(function(){
							if($(this).val() == '')
							{
								$(this).next('.showErrorMsg').text(please_select_dynamic.replace('**field**' , 'location')).css('display' , 'block');
								errorFlag = 2;
							}
							else
								$(this).next('.showErrorMsg').text('');
						});
						//Check the validations for add more activity fields
						$('input[name="activity[]"]').each(function(){
							if($(this).val() == '')
							{
								$(this).next('.showErrorMsg').text(please_select_dynamic.replace('**field**' , 'activity')).css('display' , 'block');
								errorFlag = 2;
							}
							else
								$(this).next('.showErrorMsg').text('');
						});
						//Check the validations for add more from time fields
						$('input[name="from_time[]"]').each(function(){
							if($(this).val() == '')
							{
								$(this).parent().next('.showErrorMsg').text(please_select_dynamic.replace('**field**' , 'from time')).css('display' , 'block');
								errorFlag = 2;
							}
							else
								$(this).next('.showErrorMsg').text('');
						});
						//Check the validations for add more to time fields
						$('input[name="to_time[]"]').each(function(){
							if($(this).val() == '')
							{
								$(this).parent().next('.showErrorMsg').text(please_select_dynamic.replace('**field**' , 'to time')).css('display' , 'block');
								errorFlag = 2;
							}
							else
								$(this).next('.showErrorMsg').text('');
						});
						if(errorFlag == 1)
						{
							$('#globalErrorFlag').val(2);
							$('#masterActivityForm').submit();
						}
						else
							return false;
					}
					else
					{
						$('.showDuplicateError').text(duplicate_dynamic.replace('**field**' , 'Date')).css('display' , 'block');
						return false;
					}
				}
			});
		}
	});

	//After click on the search preview icon it will show the preview between the selected date
	$(document).on('click' , '.searchPreview' , function(){
		var errorFlag = 1;
		//Check required validation for start date
		if($('#start_date').val() == '')
		{
			$('#start_date').next('.showErrorMessage').text(please_select_dynamic.replace('**field**' , 'start date'));
			errorFlag = 2;
		}
		else
			$('#start_date').next('.showErrorMessage').text('');

		//Check required validation for end date
		if($('#end_date').val() == '')
		{
			$('#end_date').next('.showErrorMessage').text(please_select_dynamic.replace('**field**' , 'end date'));
			errorFlag = 2;
		}
		else
			$('#end_date').next('.showErrorMessage').text('');

		//Check required validation for centre
		if($('#centre_id').val() == '')
		{
			$('#centre_id').next('.showErrorMessage').text(please_select_dynamic.replace('**field**' , 'centre'));
			errorFlag = 2;
		}
		else
			$('#centre_id').next('.showErrorMessage').text('');

		//If required validation is done then  check for the sdate range validation
		if(errorFlag == 1)
		{
			var startDate = $('#start_date').val().split('-');
			var endDate = $('#end_date').val().split('-');
			if(new Date(startDate[2] , startDate[1] , startDate[0]) > new Date(endDate[2] , endDate[1] , endDate[0]))
			{
				$('#start_date').next('.showErrorMessage').text(start_end_date_validation);
				errorFlag = 2;
			}
			else
				$('#start_date').next('.showErrorMessage').text('');
		}

		//If validation done successfully then get the details through ajax call
		if(errorFlag == 1)
		{
			$.ajax({
				url : baseUrl+'master_activity/search_activity',
				type : 'POST',
				data : {'centre_id' : $('#centre_id').val() , 'start_date' : $('#start_date').val() ,  'end_date' : $('#end_date').val()},
				dataType : 'JSON',
				success : function(response){
					$('#previewContainer').empty();
					if(response.htmlStr)
						$('#previewContainer').html(response.htmlStr);
					else
						$('#previewContainer').html('<p class="text-error text-center">No activity available</p>');
				}
			});
		}
	});

	//Check validation for activity report search through jquery validator
	$('#activityReportForm').validate({
		errorElement : 'span',
		rules : {
			centre_id : {
				required : true
			},
			start_date : {
				required : true
			},
			end_date : {
				required : true
			}
		},
		messages : {
			centre_id : {
				required : please_select_dynamic.replace('**field**' , 'centre')
			},
			start_date : {
				required : please_enter_dynamic.replace('**field**' , 'start date')
			},
			end_date : {
				required : please_enter_dynamic.replace('**field**' , 'end date')
			}
		},
		submitHandler : function(form){
			if(new Date($('#start_date').val()) > new Date($('#end_date').val()))
			{
				$('#start_date').parent().find('.showDateError').text(start_end_date_validation).css('display' , 'block');
				return false;
			}
			else
			{
				$('#start_date').parent().find('.showDateError').text('');
				form.submit();
			}
		}
	});

	//With the change of the filter dropdown the table content will also change dynamically
	$(document).on('change' , '.filterDropdown' , function(){
		var whereConditionArr = [];
		$('.filterDropdown').each(function(){
			if($(this).val() != '')
			{
				if($(this).data('field_ref') == 'date')
					whereConditionArr.push("a.date = '"+$(this).val()+"'");
				else
					whereConditionArr.push("b."+$(this).data('field_ref')+" = '"+$(this).val()+"'");
			}
		});
		$.ajax({
			url : baseUrl+'index.php/frontweb/master_activity/filter_search',
			type : 'POST',
			data : {
				'centre_id' : $('#centre_id').val(),
				'start_date' : $('#start_date').val(),
				'end_date' : $('#end_date').val(),
				'whereCondition': whereConditionArr
			},
			dataType : 'JSON',
			success : function(response){
				if(response.details)
				{
					$('.activityreportBody').empty();
					var htmlStr = '';
					$.each(response.details , function(index , value){
						htmlStr+= '<tr>\
										<td>'+value.date+'</td>\
										<td>'+value.program_name+'</td>\
										<td>'+value.location+'</td>\
										<td>'+value.activity+'</td>\
										<td>'+value.from_time+'</td>\
										<td>'+value.to_time+'</td>\
										<td>'+value.managed_by+'</td>\
									</tr>'
					});
					$('.activityreportBody').append(htmlStr);
				}
			}
		});
	});
});