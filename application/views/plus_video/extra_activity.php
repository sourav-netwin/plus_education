<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>
<link href="<?php echo base_url(); ?>css/custom.css?v=0.7" type="text/css" rel="stylesheet" media="all">

<!---------------Sweet Alert CSS and JS----------------->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/sweetalert.css">
<script src="<?php echo base_url(); ?>js/admin/sweetalert.min.js"></script>

<!----------Datepicker CSS and JS--------->
<link href="<?php echo base_url(); ?>css/datepicker.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>

<!----------Jquery ui css/js--------->
<link href="<?php echo base_url(); ?>css/admin/jquery-ui.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/admin/jquery-ui.js"></script>

<script>
	var baseUrl = "<?php echo base_url(); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
	var delete_confirmation = "<?php echo $this->lang->line("delete_confirmation"); ?>";
</script>
<script src="<?php echo base_url(); ?>js/admin/extra_activity.js?v=1.3"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-lg-12">
<?php
							$formAttribute = array(
								'class' => 'form-horizontal form-label-left show-custom-error-tag',
								'method' =>'post',
								'id' => 'extraActivityForm'
							);
							echo form_open_multipart('extra_activity/index' , $formAttribute);
?>
								<div class="col-lg-6 form-group">
									<label class="control-label custom-control-label col-lg-4">Select centre<span class="required">*</span></label>
									<div class="col-lg-8">
<?php
										$centreId = (isset($post['centre_id'])) ? $post['centre_id'] : '';
										echo form_dropdown('centre_id' , getCentreDropdownForPlusVideo($this->session->userdata('centre_id')) , $centreId , 'class="form-control" id="centre_id"');
?>
										<span class="error showErrorMessage"></span>
									</div>
								</div>
								<div class="col-lg-6 form-group">
									<label class="control-label custom-control-label col-lg-4">Student group</label>
									<div class="col-lg-8">
<?php
										$groupId = (isset($post['student_group'])) ? $post['student_group'] : '';
										echo form_dropdown('student_group' , $groupDropdown , $groupId , 'class="form-control" id="student_group"');
?>
										<span class="error showErrorMessage"></span>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-6 form-group">
									<label class="control-label custom-control-label col-lg-4">Group reference<span class="required">*</span></label>
									<div class="col-lg-8">
<?php
										$groupReferenceId = (isset($post['group_reference_id'])) ? $post['group_reference_id'] : '';
										echo form_dropdown('group_reference_id' , $groupReferenceDropdown , $groupReferenceId , 'class="form-control" id="group_reference_id"');
?>
										<span class="error showErrorMessage"></span>
									</div>
								</div>
								<div class="col-lg-6 form-group">
									<button type="submit" class="btn btn-info" id="generateTable" style="margin-left: 15px;">
										<i class="fa fa-plus"></i>&nbsp;&nbsp;Generate Table
									</button>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-6 form-group">
									<label class="control-label custom-control-label col-lg-4">Arrival date</label>
									<div class="col-lg-8">
<?php
										$inputAttribute = array(
											'name' => 'arrival_date',
											'id' => 'arrival_date',
											'class' => 'form-control',
											'value' => (isset($post['arrival_date'])) ? $post['arrival_date'] : '',
											'placeholder' => 'dd-mm-yyyy',
											'disabled' => 'disabled'
										);
										echo form_input($inputAttribute);
?>
									</div>
								</div>
								<div class="col-lg-6 form-group">
									<label class="control-label custom-control-label col-lg-4">Departure date</label>
									<div class="col-lg-8">
<?php
										$inputAttribute = array(
											'name' => 'departure_date',
											'id' => 'departure_date',
											'class' => 'form-control',
											'value' => (isset($post['departure_date'])) ? $post['departure_date'] : '',
											'placeholder' => 'dd-mm-yyyy',
											'disabled' => 'disabled'
										);
										echo form_input($inputAttribute);
?>
									</div>
								</div>
								<div class="clearfix"></div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
				<div class="x_content box-body"></div>
			</div>
			<div class="clearfix"></div>

			<div class="x_panel">
				<div class="x_content">
					<div class="box box-primary">
						<div class="box-body">
							<div class="col-lg-12">
								<div id="previewContainer">
									<input type="hidden" id="globalCount" value="<?php echo (!empty($post['details'])) ? count($post['details']) : 1; ?>" />
<?php
									if(!empty($post['datesArr']) && !empty($post['details']))
									{
?>
										<div style="width:100%;overflow:scroll;">
											<table class="table table-striped table-bordered activityProgramTable">
												<thead>
													<tr>
														<th class="actionColumn" rowspan="2">Action</th>
														<th class="timeColumn" colspan="2">Date</th>
<?php
														foreach($post['datesArr'] as $dateValue)
															echo "<th>".date('d-M-Y' , strtotime($dateValue))."</th>";
?>
													</tr>
													<tr>
														<th>Start</th>
														<th>Finish</th>
<?php
														foreach($post['datesArr'] as $dateValue)
															echo "<th>".date('l' , strtotime($dateValue))."</th>";
?>
													</tr>
												</thead>
												<tbody>
<?php
													$tempCount = 1;
													foreach($post['details'] as $timeSlot => $detailsValue)
													{
?>
														<tr data-reference = "<?php echo $tempCount; ?>">
															<td>
																<i class="fa fa-lg fa-plus-circle add_section addMoreTable" aria-hidden="true"></i>
<?php
																if(count($post['details']) > 1)
																	echo '<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>';
?>
															</td>
															<td class="tdStartTime">
<?php
																$tempArr = explode('-' , $timeSlot);
																echo createTimingDropdown($tempArr[0]);
?>
															</td>
															<td class="tdFinishTime">
<?php
																$tempArr = explode('-' , $timeSlot);
																echo createTimingDropdown($tempArr[1]);
?>
															</td>
<?php
															foreach($post['datesArr'] as $datesId => $dateValue)
															{
?>
																<td class="<?php echo (isset($detailsValue[$datesId])) ? 'multipleDetails' : 'enterDetails'; ?>" data-parent_id="<?php echo $datesId; ?>" data-date="<?php echo $dateValue; ?>">
																	<span class="droppableItem"></span>
<?php
																	if(isset($detailsValue[$datesId]))
																	{
																		foreach($detailsValue[$datesId] as $activityDetails)
																		{
?>
																			<div>
																				<span class="draggableItem" data-id="<?php echo $activityDetails['id']; ?>"><?php echo $activityDetails['name']; ?></span>
																				<br><i class="fa fa-trash-o deleteActivityDetails"></i>
																			</div><hr>
<?php
																		}
																		echo '<i class="fa fa-plus-square addMoreActivityDetails"></i>';
																	}
?>
																</td>
<?php
															}
?>
														</tr>
<?php
														$tempCount++;
													}
?>
												</tbody>
											</table>
										</div>
<?php
									}
									elseif(isset($errorMessage))
										echo '<p style="color: red;font-size: 18px;">'.$errorMessage.'</p>';
?>
								</div>
							</div>
							<div class="clearfix"></div><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!---------------------Manage Activity details modal Start----------------->
<div class="modal fade" id="activityDetailsModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title modalTitle"></h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'activityDetailsForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<input type="hidden" name="activityDetailsFlag" id="activityDetailsFlag" />
				<input type="hidden" name="activityDetailsParentId" id="activityDetailsParentId" />
				<input type="hidden" name="activityDetailsId" id="activityDetailsId" />
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Type of activity<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'program_name',
								'id' => 'program_name',
								'class' => 'form-control',
								'placeholder' => 'Type of activity'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Location<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'location',
								'id' => 'location',
								'class' => 'form-control',
								'placeholder' => 'Location'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Activity<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'activity',
								'id' => 'activity',
								'class' => 'form-control',
								'placeholder' => 'Activity'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Start time<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'from_time',
								'id' => 'from_time',
								'class' => 'form-control',
								'placeholder' => 'Start time',
								'readonly' => TRUE
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Finish time<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'to_time',
								'id' => 'to_time',
								'class' => 'form-control',
								'placeholder' => 'Finish time',
								'readonly' => TRUE
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Managed by</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							echo form_dropdown('managed_by' , getContractPersonDropdown() , '' , 'class = "form-control" id = "managed_by"');
?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
