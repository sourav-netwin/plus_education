/*This JS file is to manage custom javascript functionality(for both add/edit/list)
related to the program course module*/

var pageHighlightMenu = "frontweb/manage_activity";
$(document).ready(function(){
	if(pageType == 'list')
	{
		//Initialize datatable
		var table = $("#datatable").DataTable({
			processing : true,
			stateSave : true
		});

		function confirmAction(message, callback, closeOnConfirm, closeOnCancel)
		{
			if(!message){
				message = 'Are you sure';
			}
			if(!closeOnConfirm){
				closeOnConfirm = false;
			}
			else{
				closeOnConfirm = true;
			}
			if(!closeOnCancel){
				closeOnCancel = false;
			}
			else{
				closeOnCancel = true;
			}
			swal({
				title: '',
				text: message,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#00a65a",
				confirmButtonText: "Yes",
				closeOnConfirm: closeOnConfirm,
				closeOnCancel: closeOnCancel
			}, function(status){
				if(status){
					callback(true);
				}
				else{
					callback(false);
				}
			});

		}
	}

	//On click of the status icon , change status of the activity
	$(document).on('click' , '.global-list-status-icon' , function(e){
		var message = ($(this).find('.fa').data('status_type') == 1) ? inactive_confirmation.replace('**module**' , 'Program') : active_confirmation.replace('**module**' , 'Program');
		var id = $(this).find('.fa').data('activity_id');
		var status = $(this).find('.fa').data('status_type');
		confirmAction(message , function(c){
			if(c){
				$.ajax({
					url : 'manage_activity/update_status',
					type : 'POST',
					data : {'activity_id' : id , 'status' : status , csrf_test_name: $.cookie('csrf_cookie_name')},
					success : function(){
						location.reload(true);
					}
				});
			}
		} , true , true);
	});

	//Jquery validator to check form validation
	if(pageType == 'add_edit')
	{
		//Add customize rules
		jQuery.validator.addMethod("validData",function(value,element){
			if(/[()+<>\"\'%&;]/.test(value)){
					return false;
			}else{
				return true;
			}
		} , valid_data_error_msg);

		jQuery.validator.addMethod('checkRequired' , function(value , element){
			if(value == '' && $('#editUploadFlag').val() == '1')
				return false;
			else
				return true;
		} , required_upload_file);

		jQuery.validator.addMethod("checkPdfExt" , function (value , element){
			if(value)
			{
				if(splitByLastDot(value) == 'pdf')
					return true;
				else
					return false;
			}
			else
				return true;
		} , pdf_type_error_msg);

		$('#activityDetails').validate({
			errorElement : 'span',
			rules : {
				name : {
					required : true,
					validData : true
				},
				centre_id : {
					required : true
				},
				description : {
					required : true
				},
				file_name : {
					checkRequired : true,
					checkPdfExt : true
				}
			},
			messages : {
				name : {
					required : please_enter_dynamic.replace('**field**' , 'Activity Name')
				},
				centre_id : {
					required : please_select_dynamic.replace('**field**' , 'Centre')
				},
				description : {
					required : please_enter_dynamic.replace('**field**' , 'Description')
				}
			}
		});
	}

	//Form edit page admin will click on the remove remove icon
	$(document).on('click' , '.removePdfFile' , function(){
		if(confirm(delete_confirmation.replace('**module**' , 'Pdf file')))
		{
			$('.showPdfWrapper').css('display' , 'none');
			$('.showFileUploadWrapper').css('display' , 'block');
			$('#editUploadFlag').val('1');
		}
	});
});

//Function is used to confirm before delete any activity
function confirm_delete()
{
	if(confirm(delete_confirmation.replace('**module**' , 'Activity')))
		return true;
	else
		return false;
}

//This function is used to return string name after dot
function splitByLastDot(str)
{
	if(str != '')
	{
		var arr = str.split('.');
		return arr[1];
	}
}
