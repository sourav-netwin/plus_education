<!----------Summernote CSS and JS--------->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<!-------------Bootstrap multiselect css and js---------------->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/bootstrap-multiselect.css" />
<script src="<?php echo base_url(); ?>js/admin/bootstrap-multiselect.js"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Junior Centre</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'juniorCentre',
						'method' =>'post'
					);
					echo form_open_multipart(base_url().'admin/junior_centre/edit/'.$post['junior_centre_id'] , $formAttribute);
?>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select Centre<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								echo form_dropdown('centre_id' , getCentreDetails() , $post['centre_id'] , 'class="form-control" id="centre_id"');
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select Program<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								echo form_dropdown('centre_program[]' , getCourseProgramDetails() , $post['centre_program'] , 'class="form-control" id="centre_program" multiple="multiple"');
?>
								<span id="programErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Address<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'centre_address',
									'id' => 'centre_address',
									'class' => 'form-control',
									'rows' =>2,
									'value' => $post['centre_address']
								);
								echo form_textarea($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'centre_description',
									'id' => 'centre_description',
									'class' => 'form-control summernote',
									'value' => $post['centre_description']
								);
								echo form_textarea($inputFieldAttribute);
?>
							<span id="descriptionErrorMessage" style="color:#ff0000"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload Banner Image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag" id="imageChangeFlag" value="1" />
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<input type="hidden" name="oldImg" id="oldImg" value="<?php echo $post['centre_banner']; ?>" />
								<label for="centre_banner">
<?php
									$imgPath = ($post['centre_banner'] != '') ? base_url().JUNIOR_CENTRE_IMAGE_PATH.getThumbnailName($post['centre_banner']) : base_url().'images/no_flag.jpg';
?>
									<img height="50" width="180" class="uploadImageProgramClass" src="<?php echo $imgPath; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'centre_banner',
									'name' => 'centre_banner',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo JUNIOR_CENTRE_WIDTH; ?> X <?php echo JUNIOR_CENTRE_HEIGHT; ?> pixel )
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
									'onclick' => "window.location = '".base_url()."admin/junior_centre/index'"
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
		jQuery.validator.addMethod("checkImageWidth",function(value,element){
			if($('#imgWidthErrorFlag').val() == 2){
					return false;
			}else{
				return true;
			}
		},"<?php echo str_replace(array('**width**' , '**height**') , array(JUNIOR_CENTRE_WIDTH , JUNIOR_CENTRE_HEIGHT) , $this->lang->line('minimum_image_dimension')); ?>");

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

		$('#juniorCentre').validate({
			errorElement : 'span',
			rules : {
				centre_id : {
					required : true
				},
				centre_address : {
					required : true
				},
				centre_banner : {
					checkImageWidth : true,
					checkImageExt : true
				}
			},
			messages : {
				centre_id : {
					required : "<?php echo str_replace('**field**' , 'Centre' , $this->lang->line('please_select_dynamic')); ?>"
				},
				centre_address : {
					required : "<?php echo str_replace('**field**' , 'Address' , $this->lang->line('please_enter_dynamic')); ?>"
				}
			},
			submitHandler : function(){
				$programErrorFlag = $descriptionErrorFlag = 1;
				if($('#centre_program').val() == null)
				{
					$programErrorFlag = 2;
					$('#programErrorMessage').text("<?php echo str_replace('**field**' , 'Program' , $this->lang->line('please_select_dynamic')); ?>");
				}
				else
				{
					$('#programErrorMessage').text('');
					$programErrorFlag = 1;
				}

				var textareaStr = $('#centre_description').summernote('isEmpty') ? '' : $('#centre_description').summernote('code');
				if(strip_html_tags(textareaStr) == '')
				{
					$descriptionErrorFlag = 2;
					$('#descriptionErrorMessage').text("<?php echo str_replace('**field**' , 'Description' , $this->lang->line('please_enter_dynamic')); ?>");
				}
				else
				{
					$('#descriptionErrorMessage').text('');
					$descriptionErrorFlag = 1;
				}

				if($descriptionErrorFlag == 1 && $programErrorFlag == 1)
					return true;
				else
					return false;
			}
		});

		$('#centre_banner').on('change' , function(){
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
						if(!(this.height >= <?php echo JUNIOR_CENTRE_HEIGHT; ?> && this.width >= <?php echo JUNIOR_CENTRE_WIDTH; ?>))
						{
							$('#imgWidthErrorFlag').val('2');
							$('#imgErrorMessage').text("<?php echo str_replace(array('**width**' , '**height**') , array(JUNIOR_CENTRE_WIDTH , JUNIOR_CENTRE_HEIGHT) , $this->lang->line('minimum_image_dimension')); ?>");
							return false;
						}
						else
						{
							$('#imageChangeFlag').val('2');
							$('#imgWidthErrorFlag').val('1');
							$('#imgErrorMessage').text('');
							return true;
						}
					}
				}
			}
		});

		//Initialize summernote
		$('.summernote').summernote({
			height: 200
		});

		//Initialize bootstrap multiselect
		$('#centre_program').multiselect({
			buttonWidth : '498px',
			nonSelectedText: 'Please Select'
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
