<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Course</h2>
					<ul class="nav navbar-right panel_toolbox"></ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'courseDetails',
						'method' =>'post'
					);
					echo form_open_multipart(base_url().'admin/course/edit/'.$post['course_master_id'] , $formAttribute);
?>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Language<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								echo form_dropdown('language_id' , getLanguageDetails() , $post['language_id'] , 'class="form-control" id="language_id"');
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Program Title<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'course_name',
									'id' => 'course_name',
									'class' => 'form-control',
									'placeholder' => 'Program Title',
									'value' => $post['course_name']
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
									'name' => 'corse_description',
									'id' => 'corse_description',
									'class' => 'form-control',
									'value' => $post['corse_description']
								);
								echo form_textarea($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag" id="imageChangeFlag" value="1" />
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<input type="hidden" name="oldImg" id="oldImg" value="<?php echo $post['course_image']; ?>" />
								<label for="course_image">
<?php
									$imgPath = ($post['course_image'] != '') ? base_url().'uploads/course/'.$post['course_image'] : base_url().'images/no_flag.jpg';
?>
									<img height="50" width="180" class="uploadImageProgramClass" src="<?php echo $imgPath; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'course_image',
									'name' => 'course_image',
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
						<div class="ln_solid"></div>

						<!-------------------------Course Specification Section Start-------------------------->
						<div class="x_title">
							<h2>Course Specification</h2>
							<ul class="nav navbar-right panel_toolbox"></ul>
							<div class="clearfix"></div>
						</div>
						<input type="hidden" id="global_more_count" value="<?php echo count($post['specification']); ?>" />
						<div class="form-group">
<?php
							if(!empty($post['specification']))
							{
								foreach($post['specification'] as $key => $value)
								{
?>
									<div id="add_more_wrapper_<?php echo ($key+1); ?>" class="add_more_wrapper">
										<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Specification<span class="required">*</span></label>
										<div class="col-md-3 col-sm-3 col-xs-12">
<?php
											$inputFieldAttribute = array(
												'name' => 'specification_option['.($key+1).']',
												'id' => 'specification_option['.($key+1).']',
												'class' => 'form-control',
												'placeholder' => 'Specification Option',
												'value' => $value['specification_option']
											);
											echo form_input($inputFieldAttribute);
?>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-12">
<?php
											$inputFieldAttribute = array(
												'name' => 'specification_value['.($key+1).']',
												'id' => 'specification_value['.($key+1).']',
												'class' => 'form-control',
												'placeholder' => 'Specification Value',
												'value' => $value['specification_value']
											);
											echo form_input($inputFieldAttribute);
?>
										</div>
										<div class="col-md-1 col-sm-1">
<?php
											$class_name = (($key+1) == count($post['specification'])) ? 'fa fa-lg fa-plus-circle add_more_icon' : 'fa fa-lg fa-minus-circle remove_more_icon';
?>
											<i class="<?php echo $class_name; ?>" aria-hidden="true"></i>
										</div>
										<div class="clearfix"></div>
									</div>
<?php
								}
							}
?>
						</div>
						<div class="ln_solid"></div>
<!------------------------Course Specification Section END--------------------------->

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
									'onclick' => "window.location = '".base_url()."admin/course/index'"
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
		},"<?php echo str_replace(array('**width**' , '**height**') , array('1920' , '500') , $this->lang->line('exact_image_size')); ?>");

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

		$('#courseDetails').validate({
			errorElement : 'span',
			rules : {
				language_id : {
					required : true ,
				},
				course_name : {
					required : true,
					validData : true
				},
				corse_description : {
					required : true,
					validData : true
				},
				course_image : {
					checkImageWidth : true,
					checkImageExt : true
				}
			},
			messages : {
				language_id : {
					required : "<?php echo str_replace('**field**' , 'Language' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				course_name : {
					required : "<?php echo str_replace('**field**' , 'Course Title' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				corse_description : {
					required : "<?php echo str_replace('**field**' , 'Course Description' , $this->lang->line('please_enter_dynamic')); ?>"
				}
			}
		});

		$('#course_image').on('change' , function(){
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
						if(!(this.height == 500 && this.width == 1920))
						{
							$('#imgWidthErrorFlag').val('2');
							$('#imgErrorMessage').text("<?php echo str_replace(array('**width**' , '**height**') , array('1920' , '500') , $this->lang->line('exact_image_size')); ?>");
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

		//After click on the plus icon it will append same rows
		$(document).on('click' , '.add_more_icon' , function(){
			$(this).attr('class' , 'fa fa-lg fa-minus-circle remove_more_icon');
			$('#global_more_count').val((parseInt($('#global_more_count').val())+1));
			var dynamic_count = $('#global_more_count').val();
			var str = '<div id="add_more_wrapper_'+dynamic_count+'" class="add_more_wrapper">\
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Specification<span class="required">*</span></label>\
							<div class="col-md-3 col-sm-3 col-xs-12">\
								<input type="text" name="specification_option['+dynamic_count+']" value="" id="specification_option['+dynamic_count+']" class="form-control" placeholder="Specification Option">\
							</div>\
							<div class="col-md-3 col-sm-3 col-xs-12">\
								<input type="text" name="specification_value['+dynamic_count+']" value="" id="specification_value['+dynamic_count+']" class="form-control" placeholder="Specification Value">\
							</div>\
							<div class="col-md-1 col-sm-1">\
								<i class="fa fa-lg fa-plus-circle add_more_icon" aria-hidden="true"></i>\
							</div>\
							<div class="clearfix"></div>\
						</div>';
			$('#'+$(this).parent().parent().attr('id')).after(str);
			$("input[name*='specification_option["+dynamic_count+"]']").rules("add", {
				required : true ,
				validData : true ,
				messages : {
					required: "<?php echo str_replace('**field**' , 'Specification Option' , $this->lang->line('please_enter_dynamic')); ?>"
				}
			});
			$("input[name*='specification_value["+dynamic_count+"]']").rules("add", {
				required : true ,
				validData : true ,
				messages : {
					required: "<?php echo str_replace('**field**' , 'Specification Value' , $this->lang->line('please_enter_dynamic')); ?>"
				}
			});
		});

		//After click on the minus icon it will delete that row
		$(document).on('click' , '.remove_more_icon' , function(){
			$('#'+$(this).parent().parent().attr('id')).empty();
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