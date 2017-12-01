<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>My Profile</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'myProfileForm',
						'method' => 'post'
					);
					echo form_open_multipart(base_url().'admin/dashboard/my_profile' , $formAttribute);
?>
						<div class="form-group">
							<div class="col-lg-6 col-lg-offset-3" style = "color: red;">
<?php
								echo validation_errors();
								if($imageError != '')
									echo br(1).$imageError;
?>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'class' => 'form-control has-feedback-left',
									'id' => 'userName',
									'name' => 'userName',
									'value' => (isset($post['userName']) && $post['userName'] != '') ? $post['userName'] : ''
								);
								echo form_input($inputFieldAttribute);
?>
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'class' => 'form-control has-feedback-left',
									'id' => 'userEmail',
									'name' => 'userEmail',
									'value' => (isset($post['userEmail']) && $post['userEmail'] != '') ? $post['userEmail'] : ''
								);
								echo form_input($inputFieldAttribute);
?>
								<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">User Id <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'class' => 'form-control has-feedback-left',
									'id' => 'userId',
									'name' => 'userId',
									'value' => (isset($post['userId']) && $post['userId'] != '') ? $post['userId'] : ''
								);
								echo form_input($inputFieldAttribute);
?>
								<span class="fa fa-users form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag" id="imageChangeFlag" value="1" />
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<input type="hidden" name="oldImg" id="oldImg" value="<?php echo $post['userImage']; ?>" />
								<label for="userImage">
<?php
									$imgPath = ($post['userImage'] != '') ? base_url().MY_PROFILE_IMAGE_PATH.$post['userImage'] : base_url().'images/no_flag.jpg';
?>
									<img class="uploadImageClass" src="<?php echo $imgPath; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'userImage',
									'name' => 'userImage',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo MY_PROFILE_WIDTH; ?> X <?php echo MY_PROFILE_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessage" style="color:#ff0000"></span>
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
									'onclick' => "window.location = '".base_url()."admin/dashboard/index'"
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

<script type="text/javascript">
	$('#userImage').on('change' , function(){
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
					if(!(this.height >= <?php echo MY_PROFILE_HEIGHT; ?> || this.width >= <?php echo MY_PROFILE_WIDTH; ?>))
					{
						$('#imgWidthErrorFlag').val('2');
						$('#imgErrorMessage').text('Image size should be less than 500 X 500 pixel');
						return false;
					}
					else
					{
						$('#imgWidthErrorFlag').val('1');
						$('#imageChangeFlag').val('2');
						$('#imgErrorMessage').text('');
						return true;
					}
				}
			}
		}
	});

	$(window).ready(function(){
		jQuery.validator.addMethod("validData",function(value,element){
			if(/[()+<,>\"\'%&;]/.test(value)){
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
		},"<?php echo str_replace(array('**width**' , '**height**') , array(MY_PROFILE_WIDTH , MY_PROFILE_HEIGHT) , $this->lang->line('minimum_image_dimension')); ?>");

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

		$('#myProfileForm').validate({
			errorElement : 'span',
			rules : {
				userName : {
					required : true ,
					validData :true
				},
				userEmail : {
					required : true,
					validData : true
				},
				userId : {
					required : true,
					validData : true
				},
				userImage : {
					required : {
						depends : function(element){
							if($('#imageChangeFlag').val() == 2 || $.trim($('#oldImg').val()) != '')
								return false;
							else
								return true;
						}
					},
					checkImageWidth : true,
					checkImageExt : true
				}
			},
			messages : {
				userName : {
					required : "<?php echo str_replace('**field**' , 'Name' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				userEmail : {
					required : "<?php echo str_replace('**field**' , 'Email' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				userId : {
					required : "<?php echo str_replace('**field**' , 'User Id' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				userImage : {
					required : "<?php echo $this->lang->line('required_upload_image'); ?>"
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