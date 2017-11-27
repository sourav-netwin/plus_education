<!----------Bootstrap CSS and JS---------->
<link href="<?php echo base_url(); ?>css/admin/dataTables.bootstrap.min.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/admin/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>js/admin/dataTables.bootstrap.min.js"></script>

<!----------Summernote CSS and JS--------->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-5 successMessage">
<?php
			$message = '';
			if($this->input->get('success') == 'add')
				$message = str_replace('**module**' , 'Course' , $this->lang->line('add_success_message'));
			elseif($this->input->get('success') == 'edit')
				$message = str_replace('**module**' , 'Course' , $this->lang->line('edit_success_message'));
			elseif($this->input->get('success') == 'delete')
				$message = str_replace('**module**' , 'Course' , $this->lang->line('delete_success_message'));
			echo $message;
?>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Course List</h2>
					<div class="buttons pull-right">
						<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/course/add"><i class="fa fa-plus" aria-hidden="true"></i> Add Course</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>SI No.</th>
								<th>Image</th>
								<th>Course Name</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!---------------------Status Modal Start--------------------->
<div class="modal fade" id="courseStatus" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Course</h4>
			</div>
			<div class="modal-body">
				<p id = "statusUpdateMessage"></p>
			</div>
			<div class="modal-footer">
				<button type="button" id="updateStatusBtn" class="btn btn-info">Update</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!---------------------Status Modal End--------------------->

<!---------------------Feature Modal Start--------------------->
<div class="modal fade" id="courseFeature" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Course Feature</h4>
			</div>
			<div class="modal-body">
<?php
				$formAttribute = array(
					'class' => 'form-horizontal form-label-left show-custom-error-tag',
					'id' => 'courseFeatures',
					'method' =>'post'
				);
				echo form_open_multipart(base_url().'admin/course/feature' , $formAttribute);
?>
					<input type="hidden" id="global_more_count" value="1" />
					<div id="featureContainer"></div>
				<?php echo form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="submit" id="updateFeatureBtn" class="btn btn-info">Update</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!---------------------Feature Modal End--------------------->

<script type = "text/javascript">
	$(document).ready(function(){
		var table = $("#datatable").DataTable({
			processing : true,
			stateSave : true,
			serverSide : true,
			ajax : {
				url : '<?php echo base_url(); ?>admin/course/get_course',
				type : 'POST'
			},
			aoColumnDefs: [
				{"bSortable" : false , "aTargets" : [1,3,4]}
			]
		});

		//Show status page
		$(document).on('click' , '.global-list-status-icon' , function(e){
			var message = ($(this).data('status_type') == 1) ? '<?php echo str_replace("**module**" , "Course" , $this->lang->line("inactive_confirmation")); ?>' : '<?php echo str_replace("**module**" , "Course" , $this->lang->line("active_confirmation")); ?>';
			$('#statusUpdateMessage').text(message);
			$('#statusUpdateMessage').append('<input type="hidden" id="course_id" value="'+$(this).data('course_id')+'"><input type="hidden" id="course_status" value="'+$(this).data('status_type')+'">');
			$('#programStatus').modal();
		});

		//After click on the update button , update status
		$(document).on('click' , '#updateStatusBtn' , function(){
			$.ajax({
				url : '<?php echo base_url(); ?>admin/course/update_status',
				type : 'POST',
				data : {'course_id' : $('#course_id').val() , 'course_status' : $('#course_status').val()},
				success : function(){
					$('#courseStatus').modal('hide');
					table.ajax.reload();
				}
			});
		});

		//Show all feature details
		$(document).on('click' , '#manageFeature' , function(){
			$.ajax({
				url : '<?php echo base_url(); ?>admin/course/get_course_feature',
				data : {'course_id' : $(this).data('course_id')},
				type : 'POST',
				dataType : 'JSON',
				success : function(respond){
					$('#global_more_count').val(respond.total_record);
					$('#featureContainer').empty();
					$('#featureContainer').append(respond.str);
					$('.summernote').summernote({
						height: 200
					});
				}
			});
		});

		//After click on the plus icon it will append same rows
		$(document).on('click' , '.add_more_icon' , function(){
			$(this).attr('class' , 'fa fa-lg fa-minus-circle remove_more_icon');
			$('#global_more_count').val((parseInt($('#global_more_count').val())+1));
			var dynamic_count = $('#global_more_count').val();
			var str = '<div id="add_more_wrapper_'+dynamic_count+'" class="add_more_wrapper border-box">\
						<div class="form-group">\
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Title<span class="required">*</span></label>\
							<div class="col-md-9 col-sm-9 col-xs-12">\
								<input name="feature_title['+dynamic_count+']" id="feature_title['+dynamic_count+']" class="form-control" placeholder="Title" type="text">\
							</div><div class="clearfix"></div>\
						</div>\
						<div class="form-group">\
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>\
							<div class="col-md-9 col-sm-9 col-xs-12">\
								<textarea name="feature_description['+dynamic_count+']" id="feature_description['+dynamic_count+']" class="form-control summernote"></textarea>\
							</div>\
						</div>\
						<div class="form-group">\
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>\
							<div class="col-md-6 col-sm-6 col-xs-12">\
								<input type="hidden" name="imageChangeFlag['+dynamic_count+']" id="imageChangeFlag['+dynamic_count+']" value="1" />\
								<input type="hidden" id="imgWidthErrorFlag['+dynamic_count+']" value="1" />\
								<label for="feature_image_'+dynamic_count+'">\
									<img height="50" width="180" class="uploadImageProgramClass" src="<?php echo base_url(); ?>images/no_flag.jpg"/>\
								</label>\
								<input class="feature_image_class" name="feature_image['+dynamic_count+']" id="feature_image_'+dynamic_count+'" style="visibility: hidden;" type="file">\
								<small style="display:block">\
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; image size should be less than 800 X 500 pixel )\
								</small>\
								<span id="imgErrorMessage['+dynamic_count+']" style="color:#ff0000"></span>\
							</div>\
						</div>\
					</div>\
					<div style="float: right;"><i class="fa fa-lg fa-plus-circle add_more_icon" aria-hidden="true" data-block_no='+dynamic_count+'></i></div><div class="clearfix"></div>';
					$('#featureContainer').append(str);
					$('.summernote').summernote({
						height: 200
					});
		});

		//After click on the minus icon it will delete that row
		$(document).on('click' , '.remove_more_icon' , function(){
			$('#add_more_wrapper_'+$(this).data('block_no')).remove();
			$(this).parent().remove();
		});

		//After click on the update button , check validation and update value for features
		$(document).on('click' , '#updateFeatureBtn' , function(){
			alert('here');
		});

		$(document).on('change' , '.feature_image_class' , function(){
			var ref_arr = $(this).attr('id').split('_');
			var $img_source = $(this).parent().find('.uploadImageProgramClass');
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
						$img_source.attr('src' , this.src);
						if(!(this.height == 500 && this.width == 800))
						{alert('wrong');
							$('#imgWidthErrorFlag['+ref_arr[2]+']').val('2');
							$('#imgErrorMessage['+ref_arr[2]+']').text("<?php echo str_replace(array('**width**' , '**height**') , array('800' , '500') , $this->lang->line('exact_image_size')); ?>");
							return false;
						}
						else
						{
							$('#imgWidthErrorFlag['+ref_arr[2]+']').val('1');
							$('#imgErrorMessage['+ref_arr[2]+']').text('');
							$('#imageChangeFlag['+ref_arr[2]+']').val('2');
							return true;
						}
					}
				}
			}
		});

	});

	function confirm_delete()
	{
		if(confirm('<?php echo $this->lang->line('delete_confirmation'); ?>'))
			return true;
		else
			return false;
	}
</script>
