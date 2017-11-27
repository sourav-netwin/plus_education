<link href="<?php echo base_url(); ?>css/admin/lobibox.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/admin/lobibox.js"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3">
			<div class="x_panel">
				<div class="x_title">
					<h2>Multi Language Wise</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left input_mask show-custom-error-tag',
						'id' => 'multiLanProgram',
						'method' =>'post'
					);
					echo form_open('' , $formAttribute);
?>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Language<span class="required">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
<?php
								echo form_dropdown('language_id' , getLanguageDetails() , '' , 'class="form-control" id="language_id"');
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Program Title<span class="required">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_title',
									'id' => 'program_title',
									'class' => 'form-control',
									'placeholder' => 'Program Title'
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Short Description<span class="required">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_short_description',
									'id' => 'program_short_description',
									'class' => 'form-control',
									'placeholder' => 'Short Description'
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_description',
									'id' => 'program_description',
									'class' => 'form-control'
								);
								echo form_textarea($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
<?php
								$inputFieldAttribute = array(
									'class' => 'btn btn-primary',
									'content' => 'Save',
									'id' => 'multiLanguageSaveBtn'
								);
								echo form_button($inputFieldAttribute);
?>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Program</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'programDetails',
						'method' =>'post'
					);
					echo form_open_multipart(base_url().'admin/program/add' , $formAttribute);
?>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<label for="program_image">
									<img class="uploadImageClass" src="<?php echo base_url().'images/no_flag.jpg'; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'program_image',
									'name' => 'program_image',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; image size should be less than 500 X 500 pixel )
								</small>
								<span id="imgErrorMessage" style="color:#ff0000"><?php echo ($imageError != '') ? $imageError : ''; ?></span>
							</div>
						</div>
						<span id="multiLanProgramFormError" class="error col-lg-offset-3"></span>
						<div class="ln_solid"></div>
						<div id = "saveTempMultiLanguageData"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<?php
								$inputFieldAttribute = array(
									'class' => 'btn btn-success',
									'value' => 'Submit'
								);
								echo form_submit($inputFieldAttribute);

								$inputFieldAttribute = array(
									'class' => 'btn btn-primary',
									'content' => 'Cancel',
									'onclick' => "window.location = '".base_url()."admin/program/index'"
								);
								echo form_button($inputFieldAttribute);
?>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type = "text/javascript">
	$(window).ready(function(){
		var selectedLanguage = [];
		jQuery.validator.addMethod("validData",function(value,element){
			if(/[()+<,>\"\'%&;]/.test(value)){
					return false;
			}else{
				return true;
			}
		},"Please enter valid data.");

		$('#multiLanProgram').validate({
			errorElement : 'span',
			rules : {
				language_id : {
					required : true ,
				},
				program_title : {
					required : true,
					validData : true
				},
				program_short_description : {
					required : true,
					validData : true
				},
				program_description : {
					required : true
				}
			},
			messages : {
				language_id : {
					required : 'Please enter name'
				},
				program_title : {
					required : 'Please enter email'
				},
				program_short_description : {
					required : 'Please enter user id'
				},
				program_description : {
					required : 'Please enter an image'
				}
			}
		});

		$('#multiLanguageSaveBtn').on('click' , function(){
			if($('#multiLanProgram').valid())
			{
				if($.inArray($('#language_id').val() , selectedLanguage) == -1)
				{
					selectedLanguage.push($('#language_id').val());
					var tempStr = '';
					tempStr += '<input type="hidden" name="program_title['+$('#language_id').val()+']" id="program_title_'+$('#language_id').val()+'" value="'+$('#program_title').val()+'" >';
					tempStr += '<input type="hidden" name="program_short_description['+$('#language_id').val()+']" id="program_short_description_'+$('#language_id').val()+'" value="'+$('#program_short_description').val()+'" >';
					tempStr += '<input type="hidden" name="program_description['+$('#language_id').val()+']" id="program_description_'+$('#language_id').val()+'" value="'+$('#program_description').val()+'" >';
					$('#saveTempMultiLanguageData').append(tempStr);
				}
				else
				{
					$('#program_title_'+$('#language_id').val()).val($('#program_title').val());
					$('#program_short_description_'+$('#language_id').val()).val($('#program_short_description').val());
					$('#program_description_'+$('#language_id').val()).val($('#program_description').val());
				}
				Lobibox.notify('success' , {
					delay : 1800,
					icon : false,
					msg : 'Program is saved successfully.'
				});
			}
		});

		$('#program_image').on('change' , function(){
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
						$('.uploadImageClass').attr('src' , this.src);
						if(!(this.height == 500 && this.width == 1920))
						{
							$('#imgWidthErrorFlag').val('2');
							$('#imgErrorMessage').text('Image size should be exact 1920 X 500 pixel');
							return false;
						}
						else
						{
							$('#imgWidthErrorFlag').val('1');
							$('#imgErrorMessage').text('');
							return true;
						}
					}
				}
			}
		});

		jQuery.validator.addMethod("checkImageWidth",function(value,element){
			if($('#imgWidthErrorFlag').val() == 2){
					return false;
			}else{
				return true;
			}
		},"Image size should be exact 1920 X 500 pixel");

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
		} , "Please upload JPG|PNG|JPEG image.");

		$('#programDetails').validate({
			errorElement : 'span',
			rules : {
				program_image : {
					required : true ,
					checkImageWidth : true,
					checkImageExt : true
				}
			},
			messages : {
				program_image : {
					required : 'Please upload image'
				}
			},
			submitHandler : function(){
				if($.inArray('1' , selectedLanguage) == -1)
				{
					$('#multiLanProgramFormError').text('Please add data for English');
					$('#multiLanProgramFormError').css('display' , 'block');
					return false;
				}
				else
				{
					$('#saveTempMultiLanguageData').append('<input type="hidden" name="selected_language" value="'+selectedLanguage.toString()+'">');
					$('#multiLanProgramFormError').text('');
					return true;
				}
			}
		});

		//This function is used to return string name after dot
		function splitByLastDot(str)
		{
			if(str != '')
			{
				var arr = str.split('.');
				return arr[1];
			}
		}
	});
</script>