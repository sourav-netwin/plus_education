/*
	Description : This js file is used to manage all the javascript related operations
					for the master activity module
	Version : 1.8
*/
$(document).ready(function(){
	//For datepicker
	$('.datepicker').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true
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
				whereConditionArr.push($(this).data('field_ref')+" = '"+$(this).val()+"'");
			}
		});
		$.ajax({
			url : baseUrl+'master_activity/filter_search',
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
						var groupName = (value.group_name != null) ? value.group_name : '';
						var groupReferenceName = (value.group_reference != null) ? value.group_reference : '';
						var dateValue = (value.date != null) ? value.date : '';
						var programName = (value.program_name != null) ? value.program_name : '';
						var locationName = (value.location != null) ? value.location : '';
						var activityName = (value.activity != null) ? value.activity : '';
						var fromTime = (value.from_time != null) ? value.from_time : '';
						var toTime = (value.to_time != null) ? value.to_time : '';
						var managedBy = (value.managed_by_name != null) ? value.managed_by_name : '';

						htmlStr+= '<tr>\
										<td>'+groupName+'</td>\
										<td>'+groupReferenceName+'</td>\
										<td>'+formattedDate(dateValue)+'</td>\
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

//This function is usd to get formatted date(in dd-MM-YYYY format)
function formattedDate(dateValue)
{
	var monthArr = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	var dateArr = dateValue.split('-');
	return dateArr[2]+'-'+monthArr[(dateArr[1] - 1)]+'-'+dateArr[0];
}