/*
	Description : This js file is used to manage all the javascript related operations
					for the master activity module
	Version : 1.7
*/
$(document).ready(function(){
	var $globalTdSelector;
	//The value of the table row can be dragable and drop to any other td to copy same activity
	initDrag();

	//Initialize bootstrap multiselect
	$('#managed_by').multiselect({
		buttonWidth : '272px',
		nonSelectedText: 'Please Select',
		maxHeight: 200
	});

	//After click on the plus icon it clone the current record and append with the table record
	$(document).on('click' , '.addMoreTable' , function(){
		if($(this).parent().find('i').length == 1)
			$(this).parent().append('<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>');
		var $tempSelector = $(this).parent().parent().clone().insertAfter($(this).parent().parent());
		//$tempSelector.attr('data-reference' , $('#globalCount').val()).find('.enterDetails').html('<span class="droppableItem"></span>');
		$tempSelector.find('.enterDetails , .multipleDetails').attr('class' , 'enterDetails').html('<span class="droppableItem"></span>');
		$tempSelector.find('.hourDropdown').val('');
		$tempSelector.find('.minDropdown').val('');

		$('#globalCount').val((parseInt($('#globalCount').val())+1));
		$tempSelector.attr('data-reference' , $('#globalCount').val());

		//Initialize drag and drop functionality
		initDrag();
	});

	//After click on the minus icon , it will remove the current record
	$(document).on('click' , '.removeMoreTable' , function(){
		if($(this).parent().parent().find('.draggableItem').length > 0)
			swal('Sorry!' , 'Please remove all the activity details first' , 'warning');
		else
		{
			$(this).parent().parent().remove();
			if($('.activityProgramTable').find('tbody tr').length == 1)
				$('.activityProgramTable').find('.removeMoreTable').remove();
		}
	});

	//After click on the table td it will open an modal popup to add the activity details
	$(document).on('click' , '.enterDetails' , function(){
		$globalTdSelector = $(this);
		openAddActivityPopup($(this));
	});

	//After click on any activity it will get the value from database and show in the modal popup
	$(document).on('click' , '.draggableItem' , function(){
		//Reset the form data and error message
		$globalTdSelector = $(this);
		$('#activityDetailsForm')[0].reset();
		$('#activityDetailsForm').find('span.error').remove();
		$('#activityDetailsModal').find('.modalTitle').text('Activity Details ('+formattedDate($(this).parent().parent().data('date'))+')');
		$('#activityDetailsModal').find('#activityDetailsParentId').val($(this).parent().parent().data('parent_id'));
		$('#activityDetailsModal').find('#activityDetailsId').val($(this).data('id'));
		$('#activityDetailsModal').find('#activityDetailsFlag').val('es');

		//Get the activity details from database and show accordingly
		$.ajax({
			url : baseUrl+'master_activity/get_activity_details',
			type : 'POST',
			dataType : 'JSON',
			data : {'id' : $(this).data('id')},
			success : function(response){
				if(response)
				{
					$('#activityDetailsModal').find('#program_name').val(response.program_name);
					$('#activityDetailsModal').find('#location').val(response.location);
					$('#activityDetailsModal').find('#activity').val(response.activity);
					$('#activityDetailsModal').find('#from_time').val(response.from_time);
					$('#activityDetailsModal').find('#to_time').val(response.to_time);

					//Checked the selected multiselect dropdown values
					if(response.managed_by.length > 0)
					{
						var selectedArr = [];
						$.each(response.managed_by , function(index , value){
							selectedArr.push(value.managed_by_name);
						});
						$('#activityDetailsModal').find('#managed_by').val(selectedArr);
						$('#activityDetailsModal').find('#managed_by').multiselect("refresh");
					}

					//Show all the added records(managed by person names) in the add more format
					if(response.managed_by_text.length > 0)
					{
						$('#activityDetailsModal').find('.moreManagedByPerson').remove()
						$.each(response.managed_by_text , function(index , value){
							var htmlStr = '<div class="form-group moreManagedByPerson">\
												<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12"></label>\
												<div class="col-md-6 col-sm-6 col-xs-12">\
													<input name="managed_by_text[]" class="form-control" type="text" value="'+value.managed_by_name+'">\
												</div>\
												<i class="fa fa-lg fa-plus-circle add_section addMorePerson" aria-hidden="true"></i>';
							if(response.managed_by_text.length > 1)
								var htmlStr = htmlStr+'<i class="fa fa-lg fa-minus-circle delete_section removeMorePerson" aria-hidden="true"></i>';
							var htmlStr = htmlStr+'</div>';
							$('#activityDetailsModal').find('.modal-body').append(htmlStr);
						});
					}
					else
						$('#activityDetailsModal').find('.moreManagedByPerson').find('input:text').val('');

					$('#activityDetailsModal').modal();
				}
			}
		});
	});

	//After click on the add icon it will open an modal popup to add the activity details
	$(document).on('click' , '.addMoreActivityDetails' , function(){
		$globalTdSelector = $(this);
		openAddActivityPopup($(this).parent());
	});

	//Check validation for activity details form through jquery validator
	$('#activityDetailsForm').validate({
		errorElement : 'span',
		rules : {
			program_name : {
				required : true
			},
			location : {
				required : true
			},
			activity : {
				required : true
			},
			from_time : {
				required : true
			},
			to_time : {
				required : true
			}
		}
	});

	//After submit the activity details form , check the time validation and save the details in hidden field
	$('#activityDetailsForm').submit(function(e){
		if($(this).valid())
		{
			e.preventDefault();
			//Save activity details in the database through ajax call
			$.ajax({
				url : baseUrl+'master_activity/activity_details_add_edit',
				type : 'POST',
				data : $('#activityDetailsForm').serialize(),
				success : function(response){
					//For the first time insert activity details
					if($globalTdSelector.attr('class').indexOf('enterDetails') != '-1')
					{
						var tdText = '<span class="droppableItem"></span>\
									<div><span class="draggableItem" data-id="'+response+'">'+$('#activityDetailsForm').find('#activity').val()+'</span>\
									<br><i class="fa fa-trash-o deleteActivityDetails"></i></div><hr>\
									<i class="fa fa-plus-square addMoreActivityDetails"></i>';
						$globalTdSelector.attr('class' , 'multipleDetails');
						$globalTdSelector.html(tdText);
					}
					//After edit any activity details
					else if($globalTdSelector.attr('class').indexOf('draggableItem') != '-1')
						$globalTdSelector.text($('#activityDetailsForm').find('#activity').val());
					//After add multiple activity details in same time slot
					else if($globalTdSelector.attr('class').indexOf('addMoreActivityDetails') != '-1')
					{
						var tdText = '<div><span class="draggableItem" data-id="'+response+'">'+$('#activityDetailsForm').find('#activity').val()+'</span>\
									<br><i class="fa fa-trash-o deleteActivityDetails"></i></div><hr>';
						$globalTdSelector.before(tdText);
					}

					//The value of the table row can be dragable and drop to any other td to copy same activity
					initDrag();
				}
			});
			$('#activityDetailsModal').modal('hide');
		}
	});

	//On the submission of master activity form , check atleast one activity details should present
	$('#masterActivityForm').submit(function(){
		if($('#previewContainer').find('.draggableItem').length == 0)
		{
			swal('Sorry!' , 'Please enter atleast one activity details' , 'warning');
			return false;
		}
	});

	//On click of the delete activity icon , delete the hidden fields for the activity details
	$(document).on('click' , ' .deleteActivityDetails' , function(){
		if($('.activityProgramTable').find('.draggableItem').length > 1)
		{
			if(confirm(delete_confirmation.replace('**module**' , 'activity details')))
			{
				var $tempSelector = $(this);
				//Delete from database through ajax
				$.ajax({
					url : baseUrl+'master_activity/delete_activity_details',
					type : 'POST',
					data : {'id' : $tempSelector.parent().find('.draggableItem').data('id')},
					success : function(response){
						$tempSelector.parent().next('hr').remove();
						$tempSelector.parent().remove();
						initDrag();
					}
				});
			}
		}
		else
			swal('Sorry!' , 'Atleast one activity should present' , 'warning');
	});

	//On change of the time slot , it will update hidden field as well as database values for activity details
	$(document).on('change' , '.hourDropdown , .minDropdown' , function(){
		if($(this).parent().parent().find('.draggableItem').length > 0)
		{
			var  $tdSelector = $(this).parent();
			if($(this).parent().attr('class') == 'tdStartTime')
				var fieledName = 'from_time';
			if($(this).parent().attr('class') == 'tdFinishTime')
				var fieledName = 'to_time';
			if(confirm('This time will update to all the related activities . Are you sure ?'))
			{
				var activityIdArr = [];
				$(this).parent().parent().find('.draggableItem').each(function(){
					activityIdArr.push($(this).data('id'));
				});
				//Update the timing in database
				$.ajax({
					url : baseUrl+'master_activity/update_activity_time',
					type : 'POST',
					data : {'fieldName' : fieledName , 'activityIdArr' : activityIdArr , 'time' : $tdSelector.find('.hourDropdown').val()+':'+$tdSelector.find('.minDropdown').val()},
					success : function(response){}
				});
			}
			else
			{
				$(this).parent().parent().find('.draggableItem').each(function(){
					var tempId = $(this).data('id');
					$.ajax({
						url : baseUrl+'master_activity/get_activity_details',
						type : 'POST',
						dataType : 'JSON',
						data : {'id' : tempId},
						success : function(response){
							if(response)
							{
								if(fieledName == 'from_time')
									var tempArr = response.from_time.split(':');
								else if(fieledName == 'to_time')
									var tempArr = response.to_time.split(':');
								$tdSelector.find('.hourDropdown').val(tempArr[0]);
								$tdSelector.find('.minDropdown').val(tempArr[1]);
							}
						}
					});
					return false;
				});
			}
		}
	});

	//After click on the plus icon it clone the current record and append with the person name(for managed by person name)
	$(document).on('click' , '.addMorePerson' , function(){
		if($(this).parent().find('i').length == 1)
			$(this).parent().append('<i class="fa fa-lg fa-minus-circle delete_section removeMorePerson" aria-hidden="true"></i>');
		$(this).parent().clone().insertAfter($(this).parent()).find("input:text").val('');
	});

	//After click on the minus icon , it will remove the current record(for managed by person name)
	$(document).on('click' , '.removeMorePerson' , function(){
		$(this).parent().remove();
		if($('#activityDetailsForm').find('.moreManagedByPerson').length == 1)
			$('#activityDetailsForm').find('.moreManagedByPerson').find('.removeMorePerson').remove();
	});
});

//This function is usd to get formatted date(in dd-MM-YYYY format)
function formattedDate(dateValue)
{
	var monthArr = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	var dateArr = dateValue.split('-');
	return dateArr[0]+'-'+monthArr[(dateArr[1] - 1)]+'-'+dateArr[2];
}

//This function is used to initialize the draggable functionality to drag an activity
function initDrag()
{
	$(".draggableItem").draggable({
		containment : "document",
		cursor : 'move',
		revert : 'invalid',
		helper : 'clone',
		refreshPositions : true,
		revertDuration : 200
	});
	initDrop();
}

//This function is used to initialize the dropable functionality to drop any item to table td
function initDrop()
{
	$(".droppableItem").parent().droppable({
		accept : ".draggableItem",
		greedy: true,
		drop : function(event , ui){
			if(($(this).data('parent_id') != ui.helper.parent().parent().data('parent_id'))
				||
				($(this).parent().data('reference') != ui.helper.parent().parent().parent().data('reference'))
			)
			{
				if($(this).parent().find('td:eq(1)').find('.hourDropdown').val() != '' &&
					$(this).parent().find('td:eq(1)').find('.minDropdown').val() != '' &&
					$(this).parent().find('td:eq(2)').find('.hourDropdown').val() != '' &&
					$(this).parent().find('td:eq(2)').find('.minDropdown').val() != '')
				{
					$tdSelector = $(this);
					//Insert the activity details in the database by copying the existing one
					$.ajax({
						url : baseUrl+'master_activity/copy_activity_details',
						type : 'POST',
						data : {
							'id' : ui.helper.data('id'),
							'from_time' : $(this).parent().find('td:eq(1)').find('.hourDropdown').val()+':'+$(this).parent().find('td:eq(1)').find('.minDropdown').val(),
							'to_time' : $(this).parent().find('td:eq(2)').find('.hourDropdown').val()+':'+$(this).parent().find('td:eq(2)').find('.minDropdown').val(),
							'fixed_day_activity_id' : $(this).data('parent_id')
						},
						dataType : 'JSON',
						success : function(response){
							if(response)
							{
								if($tdSelector.attr('class').indexOf('enterDetails') != '-1')
								{
									var tdText = '<span class="droppableItem"></span>\
												<div><span class="draggableItem" data-id="'+response.id+'">'+response.name+'</span>\
												<br><i class="fa fa-trash-o deleteActivityDetails"></i></div><hr>\
												<i class="fa fa-plus-square addMoreActivityDetails"></i>';
									$tdSelector.attr('class' , 'multipleDetails');
									$tdSelector.html(tdText);
								}
								else
								{
									var tdText = '<div><span class="draggableItem" data-id="'+response.id+'">'+response.name+'</span>\
												<br><i class="fa fa-trash-o deleteActivityDetails"></i></div><hr>';
									$tdSelector.find('.addMoreActivityDetails').before(tdText);
								}
								initDrag();
							}
						}
					});
				}
				else
					swal('Sorry!' , 'Please select start and finish time first' , 'warning');
			}
		}
	});
}

//This function is used to open modal popup to add new activity details
function openAddActivityPopup($tempSelector)
{
	//Reset the form data and error message
	$('#activityDetailsForm')[0].reset();
	$('#activityDetailsForm').find('span.error').remove();
	$('#activityDetailsModal').find('.modalTitle').text('Activity Details ('+formattedDate($tempSelector.data('date'))+')');
	$('#activityDetailsModal').find('#activityDetailsParentId').val($tempSelector.data('parent_id'));
	$('#activityDetailsModal').find('#activityDetailsFlag').val('as');

	//Remove add more fields and keep only one section
	$('#activityDetailsModal').find('#activityDetailsForm').find('.moreManagedByPerson').remove();
	var htmlStr = '<div class="form-group moreManagedByPerson">\
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12"></label>\
						<div class="col-md-6 col-sm-6 col-xs-12">\
							<input name="managed_by_text[]" class="form-control" type="text">\
						</div>\
						<i class="fa fa-lg fa-plus-circle add_section addMorePerson" aria-hidden="true"></i>\
					</div>';
	$('#activityDetailsModal').find('#activityDetailsForm').find('.modal-body').append(htmlStr);

	//Deselect all the options from multiselect dropdown
	$('#managed_by').multiselect("deselectAll", false).multiselect("refresh");

	//Set the from and to time field as per the time slot
	if($tempSelector.parent().find('td:eq(1)').find('.hourDropdown').val() != '' && $tempSelector.parent().find('td:eq(1)').find('.minDropdown').val() != '')
		$('#activityDetailsModal').find('#from_time').val($tempSelector.parent().find('td:eq(1)').find('.hourDropdown').val()+':'+$tempSelector.parent().find('td:eq(1)').find('.minDropdown').val());
	if($tempSelector.parent().find('td:eq(2)').find('.hourDropdown').val() != '' && $tempSelector.parent().find('td:eq(2)').find('.minDropdown').val() != '')
		$('#activityDetailsModal').find('#to_time').val($tempSelector.parent().find('td:eq(2)').find('.hourDropdown').val()+':'+$tempSelector.parent().find('td:eq(2)').find('.minDropdown').val());

	$('#activityDetailsModal').modal();
}

