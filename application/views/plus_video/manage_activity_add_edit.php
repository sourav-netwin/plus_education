<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>

<!---------------Sweet Alert CSS and JS----------------->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/sweetalert.css">
<script src="<?php echo base_url(); ?>js/admin/sweetalert.min.js"></script>

<!------------custom javascript for program course------------>
<script>
	var pageType = 'add_edit';
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var activity_file_type_error_msg = "<?php echo $this->lang->line("activity_file_type_error_msg"); ?>";
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
						<input type="hidden" id="fileTypeErrorFlag" value="1" />
						<input type="hidden" name="notUploadFile" id="notUploadFile" value="" />
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
								echo form_dropdown('centre_id' , getCentreDropdownForPlusVideo($this->session->userdata('centre_id')) , $centreValue , 'class="form-control" id="centre_id"');
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
								<label for="file_name">
									<span class="addFileBtn">
										<i class="fa fa-plus"></i> Add files...
									</span>
								</label>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG|PDF|DOC|XLS files are allowed )
								</small>
<?php
								$inputFieldAttribute = array(
									'id' => 'file_name',
									'name' => 'file_name[]',
									'type' => 'file',
									'multiple' => 'multiple',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="listUploadedFileWrapper"></div>

						<!-----------Static HTML for the dynamic content Start--------->
						<div class="sampleHtmlContainer" style="display: none;">
							<div class="form-group listUploadedFile_dynamicCount">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12"></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div style="overflow-x: scroll;">
										<table role="presentation" class="table table-striped">
											<tbody class="files">
												<tr class="template-upload fade in">
													<td align="left" style="width: 40%;">
														<span class="preview dynamicContentClass">
															<img src="<?php echo base_url(); ?>images/no_flag.jpg" class="uploadImageActivityClass" width="160" height="60"/>
														</span>
													</td>
													<td align="left">
														<p class="name uploadedFileName"></p>
													</td>
													<td align="right">
														<button class="btn btn-danger deleteUploadFile" data-ref_id = "dynamicCount" />
															<i class="fa fa-trash-o" aria-hidden="true"></i> Delete
														</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="waitClass" style="display: none;">
							<img src='<?php echo base_url(); ?>images/loader.gif' class="waitClassImg" />
						</div>
						<!-----------Static HTML for the dynamic content End--------->

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