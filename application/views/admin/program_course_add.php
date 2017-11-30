<!----------Summernote CSS and JS--------->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Course Program</h2>
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
					echo form_open_multipart(base_url().'admin/program_course/add' , $formAttribute);
?>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Program Name<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_course_name',
									'id' => 'program_course_name',
									'class' => 'form-control',
									'placeholder' => 'Program Name'
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_course_description',
									'id' => 'program_course_description',
									'class' => 'form-control summernote'
								);
								echo form_textarea($inputFieldAttribute);
?>
							<span id="descriptionErrorMessage" style="color:#ff0000"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload Logo <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<label for="program_course_logo">
									<img class="uploadImageProgramClass" height="87" width="90" src="<?php echo base_url().'images/no_flag.jpg'; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'program_course_logo',
									'name' => 'program_course_logo',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo PROGRAM_COURSE_WIDTH; ?> X <?php echo PROGRAM_COURSE_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessage" style="color:#ff0000"><?php echo ($imageError != '') ? $imageError : ''; ?></span>
							</div>
						</div>
						<div class="ln_solid"></div>
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
									'onclick' => "window.location = '".base_url()."admin/program_course/index'"
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
			if(/[()+<>\"\'%&;]/.test(value)){
					return false;
			}else{
				return true;
			}
		},"<?php echo $this->lang->line('valid_data_error_msg'); ?>");

		jQuery.validator.addMethod("checkImageWidth",function(value,element){
			if($('#imgWidthErrorFlag').val() == 2){
					return false;
			}else{
				return true;
			}
		},"<?php echo str_replace(array('**width**' , '**height**') , array(PROGRAM_COURSE_WIDTH , PROGRAM_COURSE_HEIGHT) , $this->lang->line('minimum_image_dimension')); ?>");

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
		} , "<?php echo $this->lang->line('image_type_error_msg'); ?>");

		$('#programDetails').validate({
			errorElement : 'span',
			rules : {
				program_course_name : {
					required : true,
					validData : true
				},
				program_course_logo : {
					required : true ,
					checkImageWidth : true,
					checkImageExt : true
				}
			},
			messages : {
				program_course_name : {
					required : "<?php echo str_replace('**field**' , 'Program Name' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				program_course_logo : {
					required : "<?php echo $this->lang->line('required_upload_image'); ?>"
				}
			},
			submitHandler : function(){
				var textareaStr = $('#program_course_description').summernote('isEmpty') ? '' : $('#program_course_description').summernote('code');
				if(strip_html_tags(textareaStr) == '')
				{
					$('#descriptionErrorMessage').text("<?php echo str_replace('**field**' , 'Description' , $this->lang->line('please_enter_dynamic')); ?>");
					return false;
				}
				else
				{
					$('#descriptionErrorMessage').text('');
					return true;
				}
			}
		});

		$('#program_course_logo').on('change' , function(){
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
						if(!(this.height >= <?php echo PROGRAM_COURSE_HEIGHT; ?> && this.width >= <?php echo PROGRAM_COURSE_WIDTH; ?>))
						{
							$('#imgWidthErrorFlag').val('2');
							$('#imgErrorMessage').text("<?php echo str_replace(array('**width**' , '**height**') , array(PROGRAM_COURSE_WIDTH , PROGRAM_COURSE_HEIGHT) , $this->lang->line('minimum_image_dimension')); ?>");
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

		//initialize summernote
		$('.summernote').summernote({
			height: 200
		});
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

	//This function is used to remove html taags from the inputted string
	function strip_html_tags(str)
	{
		if(str == '')
			return '';
		else
			str = str.toString();
		return str.replace(/<[^>]*>/g , '');
	}
</script>