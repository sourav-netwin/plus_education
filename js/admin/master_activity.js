/*
	Description : This js file is used to manage all the javascript related operations
					for the master activity module
	Version : 1.5
*/
$(document).ready(function(){
	//For datepicker
	$('.datepicker').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true
	});

	//On change of the centre dropdown , change the student group dropdown value
	$(document).on('change' , '#centre_id' , function(){
		$.ajax({
			url : baseUrl+'master_activity/get_group_dropdown',
			type : 'POST',
			data : {'centre_id' : $(this).val()},
			dataType : 'JSON',
			success : function(response){
				$('#student_group').empty().append(
					$('<option></option').attr('value' , '').text('Please slect group')
				);
				if(response.length > 0)
				{
					$.each(response , function(key , value){
						$('#student_group').append(
							$('<option></option>').attr('value' , value.student_group_id).text(value.group_name)
						);
					});
					//Add validation rules
					$( "#student_group" ).rules( "add", {
						required : true
					});
				}
				else
					$("#student_group").rules("remove");
			}
		});
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
			if(checkDateRange('start_date' , 'end_date') == 2)
				return false;
			else
				form.submit();
		}
	});

	//With the change of the filter dropdown the table content will also change dynamically
	$(document).on('change' , '.filterDropdown' , function(){
		var whereConditionArr = [];
		$('.filterDropdown').each(function(){
			if($(this).val() != '')
			{
				if($(this).data('field_ref') == 'date')
					whereConditionArr.push("b.date = '"+$(this).val()+"'");
				else if($(this).data('field_ref') == 'managed_by')
					whereConditionArr.push("d.managed_by_name = '"+$(this).val()+"'");
				else
					whereConditionArr.push("c."+$(this).data('field_ref')+" = '"+$(this).val()+"'");
			}
		});
		$.ajax({
			url : baseUrl+'master_activity/filter_search',
			type : 'POST',
			data : {
				'centre_id' : $('#centre_id').val(),
				'student_group' : $('#student_group').val(),
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
						var programName = (value.program_name != null) ? value.program_name : '';
						var locationName = (value.location != null) ? value.location : '';
						var activityName = (value.activity != null) ? value.activity : '';
						var fromTime = (value.from_time != null) ? value.from_time : '';
						var toTime = (value.to_time != null) ? value.to_time : '';
						var managedBy = (value.managed_by != null) ? value.managed_by : '';

						htmlStr+= '<tr>\
										<td>'+value.date+'</td>\
										<td>'+programName+'</td>\
										<td>'+locationName+'</td>\
										<td>'+activityName+'</td>\
										<td>'+fromTime+'</td>\
										<td>'+toTime+'</td>\
										<td>'+managedBy+'</td>\
									</tr>'
					});
					$('.activityreportBody').append(htmlStr);
				}
			}
		});
	});
});

//This function is used to check if start date is less than or equal to end date
function checkDateRange(startDateField , endDateField)
{
	if(dateObject($('#'+startDateField).val()) > dateObject($('#'+endDateField).val()))
	{
		$('#'+startDateField).parent().find('.showErrorMessage').text(start_end_date_validation).css('display' , 'block');
		return 2;
	}
	else
	{
		$('#'+startDateField).parent().find('.showErrorMessage').text('');
		return 1;
	}
}

//This function is used to get the date object from a given date
function dateObject(dateValue)
{
	var dateArr = dateValue.split('-');
	return new Date(dateArr[2] , (dateArr[1] - 1) , dateArr[0]);
}