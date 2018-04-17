/*
Description : This javascript file is used to manage all the js operations for activity program module
Version : 0.3
*/

$(document).ready(function(){
	//On change of the centre dropdown , it will get the student group dropdown values through ajax call
	$(document).on('change' , '#centre_id' , function(){
		$.ajax({
			url : baseUrl+'activity_program/get_dropdown/2',
			type : 'POST',
			data : {'centre_id' : $(this).val()},
			dataType : 'JSON',
			success : function(response){
				$('#student_group').empty().append(
					$('<option></option>').attr('value' , '').text('Please select group')
				);
				if(response.length > 0)
				{
					$.each(response , function(index , value){
						$('#student_group').append(
							$('<option></option>').attr('value' , value.id).text(value.name)
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

	//On change of the type dropdown it will prepare the dropdown to select(can be master activity names or group reference number)
	$(document).on('change' , '#reportType' , function(){
		if($('#centre_id').val() == '' || ($('#student_group').find('option').length > 1 && $('#student_group').val() == ''))
		{
			alert('Please select centre and student\'s group first');
			$(this).val('');
		}
		else
		{
			if($(this).val() == 2)
			{
				var ajaxUrl = baseUrl+'activity_program/get_dropdown/1';
				var ajaxData = {'centre_id' : $('#centre_id').val()};
				$('#selectType').parent().parent().find('.control-label').attr('class' , 'control-label custom-control-label col-lg-6');
				$('#selectType').parent().attr('class' , 'col-lg-6');
				$('#selectType').parent().parent().find('.control-label').html('Group reference no.<span class="required">*</span>');
			}
			else if($(this).val() == 1)
			{
				var ajaxUrl = baseUrl+'activity_program/get_dropdown/3';
				var ajaxData = {'centre_id' : $('#centre_id').val() , 'student_group' : $('#student_group').val()};
				$('#selectType').parent().parent().find('.control-label').attr('class' , 'control-label custom-control-label col-lg-3');
				$('#selectType').parent().attr('class' , 'col-lg-9');
				$('#selectType').parent().parent().find('.control-label').html('Activity<span class="required">*</span>');
			}
			$.ajax({
				url : ajaxUrl,
				type : 'POST',
				data : ajaxData,
				dataType : 'JSON',
				success : function(response){
					$('#selectType').empty().append(
						$('<option></option>').attr('value' , '').text('Please select')
					);
					if(response.length > 0)
					{
						$.each(response , function(index , value){
							$('#selectType').append(
								$('<option></option>').attr('value' , value.id).text(value.name)
							);
						});
					}
				}
			});
		}
	});

	//Initialize validator for search form
	$('#searchForm').validate({
		errorElement : 'span',
		rules : {
			centre_id : {
				required : true
			},
			reportType : {
				required : true
			},
			selectType : {
				required : true
			}
		}
	});
});