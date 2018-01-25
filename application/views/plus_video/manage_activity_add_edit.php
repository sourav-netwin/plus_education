<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>

<!------------custom javascript for program course------------>
<script>
	var pageType = 'add_edit';
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var pdf_type_error_msg = "<?php echo $this->lang->line("pdf_type_error_msg"); ?>";
	var required_upload_file = "<?php echo $this->lang->line("required_upload_file"); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
	var delete_confirmation = "<?php echo $this->lang->line("delete_confirmation"); ?>";
</script>
<script src="<?php echo base_url(); ?>js/admin/manage_activity.js"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'activityDetails',
						'method' =>'post'
					);
					echo form_open_multipart(base_url().'manage_activity/add_edit/'.$id , $formAttribute);
?>
						<input type="hidden" name="flag" value="<?php echo $flag; ?>" />
						<div class="box box-primary"><div class="box-body">
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Activity name<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'name',
									'id' => 'name',
									'class' => 'form-control',
									'placeholder' => 'Activity Name',
									'value' => isset($post['name']) ? $post['name'] : ''
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select centre<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$centreValue = isset($post['centre_id']) ? $post['centre_id'] : '';
								echo form_dropdown('centre_id' , getCentreDetails() , $centreValue , 'class="form-control" id="centre_id"');
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'description',
									'id' => 'description',
									'class' => 'form-control',
									'rows' => '2',
									'value' => isset($post['description']) ? $post['description'] : ''
								);
								echo form_textarea($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload File <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="oldImg" id="oldImg" value="<?php echo isset($post['file_name']) ? $post['file_name'] : ''; ?>" />
								<input type="hidden" name="editUploadFlag" id="editUploadFlag" value="<?php echo isset($post['file_name']) ? 2 : 1; ?>" />
								<div class="showFileUploadWrapper" style="display: <?php echo isset($post['file_name']) ? 'none' : 'block'; ?>">
<?php
									$inputFieldAttribute = array(
										'id' => 'file_name',
										'name' => 'file_name',
										'type' => 'file'
									);
									echo form_input($inputFieldAttribute);
?>
									<small style="display:block">
										( Note: Only pdf files are allowed )
									</small>
									<span id="imgErrorMessage" style="color:#ff0000"><?php echo ($imageError != '') ? $imageError : ''; ?></span>
								</div>
<?php
								if(isset($post['file_name']))
								{
?>
									<div class="showPdfWrapper">
										<div class="col-lg-4" style="border: 1px solid #ccc;padding: 10px;">
											<a data-toggle="tooltip" data-original-title="Open File" href="<?php echo ADMIN_PANEL_URL.ACTIVITY_FILE_PATH.$post['file_name']; ?>" target="_blank">
												<i style="font-size: 30px;color: red;" class="fa fa-file-pdf-o" aria-hidden="true"></i>
												<br>(<?php echo $post['file_name']; ?>)
											</a>
										</div>
										<div class="col-lg-3" style="margin-top: 20px;">
											<i data-toggle="tooltip" data-original-title="Remove File" style="font-size: 30px;color: green;cursor: pointer;" class="fa fa-times-circle-o removePdfFile" aria-hidden="true"></i>
										</div>
										<div class="clearfix"></div>
									</div>
<?php
								}
?>
							</div>
						</div>

						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<?php
								$inputFieldAttribute = array(
									'class' => 'btn btn-success',
									'value' => ($id != '') ? 'Update' : 'Submit'
								);
								echo form_submit($inputFieldAttribute);

								$inputFieldAttribute = array(
									'class' => 'btn btn-primary',
									'content' => 'Cancel',
									'onclick' => "window.location = '".base_url()."manage_activity'",
									'style' => 'margin-left: 10px;'
								);
								echo form_button($inputFieldAttribute);
?>
							</div>
						</div>
						</div></div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>