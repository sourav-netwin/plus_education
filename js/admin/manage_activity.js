/*This JS file is to manage custom javascript functionality(for both add/edit/list)
related to the program course module*/

var pageHighlightMenu = "frontweb/manage_activity";
$(document).ready(function(){
	if(pageType == 'list')
	{
		$('[data-toggle="tooltip"]').tooltip();

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
			if(value == '' && $('#oldImg').val() == '')
				return false;
			else
				return true;
		} , required_upload_file);

		jQuery.validator.addMethod("checkFileExt" , function (value , element){
			if($('#fileTypeErrorFlag').val() == 2)
				return false;
			else
				return true;
		} , activity_file_type_error_msg);

		jQuery.validator.addMethod("checkImageWidth",function(value,element){
			if($('#imgWidthErrorFlag').val() == 2){
					return false;
			}else{
				return true;
			}
		},"");

		jQuery.validator.addMethod("checkImageExt" , function (value , element){
			if(value)
			{
				if(splitByLastDot(value) == 'jpg' || splitByLastDot(value) == 'png' || splitByLastDot(value) == 'jpeg')
					return true;
				else
					return false;
			}
			else
				return true;
		} , image_type_error_msg);

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
				'file_name[]' : {
					checkFileExt : true
				},
				front_image : {
					checkRequired : true,
					checkImageWidth : true,
					checkImageExt : true
				},
				show_text : {
					required : true
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
				},
				show_text : {
					required : please_enter_dynamic.replace('**field**' , 'Text')
				}
			}
		});

		/*-----------------Multiple file upload Start------------------*/
		$('#file_name').on('change' , function(){
			var files = (this.files) ? this.files : [];
			if(!files.length || !window.FileReader)
				return;
			$('.listUploadedFileWrapper').empty();
			var allowTypesArr = ['jpg' , 'jpeg' , 'png' , 'doc' , 'docx' , 'xls' , 'xlsx' , 'pdf'];
			var imageTypeArr = [];
			$('#fileTypeErrorFlag').val('1');
			for(var i = 0 ; i < files.length ; i++)
			{
				var splitArr = files[i]['name'].split('.');
				var fileExt = splitArr.pop().toLowerCase();
				if($.inArray(fileExt , allowTypesArr) != '-1')
				{
					$('.listUploadedFileWrapper').append($('.sampleHtmlContainer').html().replace(/dynamicCount/g , (parseInt($('#globalCount').val())+i)).replace(/dynamicFileRefId/g , i));
					$('.listUploadedFile_'+(parseInt($('#globalCount').val())+i)).find('.uploadedFileName').text(files[i]['name']);
					if(/^image/.test(files[i]['type']))
						imageTypeArr.push(i);
					else if(fileExt == 'pdf')
						$('.listUploadedFile_'+(parseInt($('#globalCount').val())+i)).find('.dynamicContentClass').html('<i style="color: red;font-size: 35px;" class="fa fa-lg fa-file-pdf-o"></i>');
					else if(fileExt == 'xls' || fileExt == 'xlsx')
						$('.listUploadedFile_'+(parseInt($('#globalCount').val())+i)).find('.dynamicContentClass').html('<i style="color: green;font-size: 35px;" class="fa fa-lg fa-file-excel-o"></i>');
					else if(fileExt == 'doc' || fileExt == 'docx')
						$('.listUploadedFile_'+(parseInt($('#globalCount').val())+i)).find('.dynamicContentClass').html('<i style="color: #7878ff;font-size: 35px;" class="fa fa-lg fa-file-text-o"></i>');
				}
				else
				{
					$('#fileTypeErrorFlag').val('2');
					swal("Sorry!", 'Only JPG|JPEG|PNG|PDF|DOC|XLS files are allowed', "warning");
					$('.listUploadedFileWrapper').empty();
					return false;
				}
			}
			//Load image
			if(imageTypeArr.length > 0)
			{
				$('.waitClass').css('display' , 'block');
				imageTypeArr.forEach(function(value , key){
					var reader = new FileReader();
					reader.readAsDataURL(files[value]);
					reader.onload = function(){
						var image = new Image();
						image.src = this.result;
						image.onload = function(){
							$('.listUploadedFile_'+(parseInt($('#globalCount').val())+value)).find('.uploadImageActivityClass').attr('src' , this.src);
						};
					};
				});
				$('.waitClass').css('display' , 'none');
			}
		});
		/*-----------------Multiple file upload End------------------*/

		//Delete multiple file
		$(document).on('click' , '.deleteUploadFile' , function(e){
			e.preventDefault();
			if(confirm(delete_confirmation.replace('**module**' , 'file')))
			{
				$('.listUploadedFile_'+$(this).data('ref_id')).remove();
				if($(this).data('flag_type') == 'as')
				{
					var notUploadFileValue = ($('#notUploadFile').val() != '') ? $('#notUploadFile').val()+','+$(this).data('file_ref_id') : $(this).data('file_ref_id');
					$('#notUploadFile').val(notUploadFileValue);
				}
				else if($(this).data('flag_type') == 'es')
				{
					var deleteEditFile = ($('#deleteEditFile').val() != '') ? $('#deleteEditFile').val()+','+$(this).data('activity_file_id') : $(this).data('activity_file_id');
					$('#deleteEditFile').val(deleteEditFile);
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

	//on change of activity front image check validation and also change image
	$('#front_image').on('change' , function(){
		var files = (this.files) ? this.files : [];
		if(!files.length || !window.FileReader)
			return;
		if(/^image/.test(files[0]['type']))
		{
			var reader = new FileReader();
			reader.readAsDataURL(files[0]);
			reader.onload = function(){
				var image = new Image();
				image.src = this.result;
				image.onload = function(){
					$('.uploadImageProgramClass').attr('src' , this.src);
					if(!(this.height >= height1 && this.width >= width1))
					{
						$('#imgWidthErrorFlag').val('2');
						$('#imgErrorMessage').text(minimum_image_dimension.replace('**width**' , width1).replace('**height**' , height1));
						return false;
					}
					else
					{
						$('#imgWidthErrorFlag').val('1');
						$('#imageChangeFlag').val('2');
						$('#imgErrorMessage').text('');
						return true;
					}
				};
			};
		}
	});

	//On change of the selection option show/hide sections for upload image or enter text(in add/edit activity page)
	$(document).on('change' , '.show_type' , function(){
		if($(this).val() == 1)
		{
			$('.showOption_1').show();
			$('.showOption_2').hide();
		}

		else
		{
			$('.showOption_1').hide();
			$('.showOption_2').show();
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
