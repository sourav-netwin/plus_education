/*
	Then js file is used to manage the extra activity management
	Version : 0.1
*/
var pageHighlightMenu = "frontweb/extra_activity";
$(document).ready(function(){
	//Check required validation for the search fields
	$('#searchForm').validate({
		errorElement : 'span',
		rules : {
			centre_id : {
				required : true
			},
			date : {
				required : true
			}
		}
	});

	//After click on the add more icon it will add one new section by cloning the previous section
	$(document).on('click' , '.addMoreTable' , function(){
		if($(this).parent().find('i').length == 1)
			$(this).parent().append('<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>');
		$(this).parent().parent().after($(this).parent().parent().clone());
		$(this).parent().parent().next().find('input:text').val('');
		$(this).parent().parent().next().find('.showErrorMessage').text('');
		$('.timepicker').datetimepicker({
			pickDate: false
		});
	});

	//After click on the remove more icon it will remove the current content
	$(document).on('click' , '.removeMoreTable' , function(){
		$(this).parent().parent().remove();
		if($('.addMoreWrapper').length == 1)
			$('.addMoreWrapper').find('.removeMoreTable').remove();
	});

	//Check required validation for the activity details group wise form
	$('#extraActivityForm').validate({
		errorElement : 'span',
		rules : {
			group_name : {
				required : true
			}
		}
	});

	//Check validation for the update extra activity
	$('#extraActivityForm').submit(function(){
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
		if(errorFlag == 2)
			return false;
	});

	//On change of the centre , change the dropdown value of student group
	$(document).on('change' , '#group_name' , function(){
		$('#extraActivityForm').find('.activityDetailsContainer').empty();
		if($(this).val() != '')
		{
			$.ajax({
				url : 'get_activity_details',
				data : {
							'centre_id' : $('#extraActivityForm').find('input[name="centre_id"]').val(),
							'date' : $('#extraActivityForm').find('input[name="date"]').val(),
							'group_name' : $(this).val()
				},
				type : 'POST',
				dataType : 'JSON',
				success : function(response){
					if(response.htmlStr)
						$('#extraActivityForm').find('.activityDetailsContainer').append(response.htmlStr);
					$('.timepicker').datetimepicker({
						pickDate: false
					});
				}
			});
		}
	});

	/*On click of the pick button from the master activity details table , it will add one record in the
	extra activity details section in editable format*/
	$(document).on('click' , '.pickRecord' , function(){
		if($('#extraActivityForm').find('#group_name').val() != '')
		{
			$.ajax({
				url : 'get_master_activity',
				data : {'id' : $(this).data('ref_id')},
				type : 'POST',
				dataType : 'JSON',
				success : function(response){
					if(response.htmlStr)
					{
						if($('.activityDetailsContainer').find('.addMoreWrapper').length == 1)
							$('.addMoreWrapper').find('.addMoreTable').parent().append('<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>');
						$('#extraActivityForm').find('.activityDetailsContainer').append(response.htmlStr);
						$('.timepicker').datetimepicker({
							pickDate: false
						});
					}
					$("html, body").animate({ scrollTop: $(document).height() }, 1000);
				}
			});
		}
		else
			swal('Sorry!' , 'Please select the group first' , 'warning');
	});
});

