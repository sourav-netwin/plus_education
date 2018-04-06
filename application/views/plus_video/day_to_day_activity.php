<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>

<link href="<?php echo base_url(); ?>css/custom.css" type="text/css" rel="stylesheet" media="all">
<script>
	var baseUrl = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url(); ?>js/admin/activity_program.js"></script>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
	<div class="w3-row-padding customPaddingClass">
		<div class="w3-col m12 customPaddingClass">
			<div class="w3-card w3-round w3-white">
				<div class="w3-container w3-padding">
					<h6 class="w3-opacity" style="font-weight: bold;font-size: 20px;">
						<i class="fa fa-calendar" aria-hidden="true" style="margin-right: 10px;"></i>Activity Programme
						<a style="float: right;margin-left: 10px;" href="<?php echo base_url(); ?>extra_activity">
							<button class="btn btn-danger">
								<i class="fa fa-cogs"></i>&nbsp;&nbsp;Manage Extra Activity
							</button>
						</a>
						<a style="float: right;" href="<?php echo base_url(); ?>master/index/manage_fixed_activity">
							<button class="btn btn-gap btn-primary">
								<i class="fa fa-shield"></i>&nbsp;&nbsp;Manage Master Activity
							</button>
						</a>
					</h6>

				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div><br>

	<div class="w3-row-padding customPaddingClass">
		<div class="w3-col m12 customPaddingClass">
			<div class="right_col" role="main">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_content">
								<!----------For search section Start---------->
								<div class="border-box col-lg-12">
<?php
									$formAttribute = array(
										'class' => 'form-horizontal form-label-left show-custom-error-tag',
										'method' =>'post',
										'id' => 'searchForm'
									);
									echo form_open_multipart('' , $formAttribute);
?>
										<input type="hidden" name="flag" value="search" />
										<div class="col-lg-4">
											<label class="control-label custom-control-label col-lg-3">Centre<span class="required">*</span></label>
											<div class="col-lg-9">
<?php
												$centreId = isset($post['centre_id']) ? $post['centre_id'] : '';
												echo form_dropdown('centre_id' , getCentreDropdownForPlusVideo($this->session->userdata('centre_id')) , $centreId , 'class="form-control" id="centre_id"');
?>
											</div>
										</div>
										<div class="col-lg-4">
											<label class="control-label custom-control-label col-lg-3">Group</label>
											<div class="col-lg-9">
<?php
												$studentGroupId = isset($post['student_group']) ? $post['student_group'] : '';
												echo form_dropdown('student_group' , $groupDropdown , $studentGroupId , 'class="form-control" id="student_group"');
?>
											</div>
										</div>
										<div class="col-lg-4">
											<label class="control-label custom-control-label col-lg-3">Type<span class="required">*</span></label>
											<div class="col-lg-9">
<?php
												$reportType = isset($post['reportType']) ? $post['reportType'] : '';
												echo form_dropdown('reportType' , getReportTypeDropdown() , $reportType , 'class="form-control" id="reportType"');
?>
											</div>
										</div>
										<div class="clearfix"></div><br>
										<div class="col-lg-4">
											<label class="control-label custom-control-label col-lg-3">Activity<span class="required">*</span></label>
											<div class="col-lg-9">
<?php
												$selectType = isset($post['selectType']) ? $post['selectType'] : '';
												echo form_dropdown('selectType' , $selectDropdownArr , $selectType , 'class="form-control" id="selectType"');
?>
											</div>
										</div>
										<div class="col-lg-4">
											<label class="control-label custom-control-label col-lg-5">Arrival date</label>
											<div class="col-lg-7">
<?php
												$inputAttribute = array(
													'name' => 'arrival_date',
													'class' => 'form-control',
													'id' => 'arrival_date',
													'placeholder' => 'dd-mm-yyyy',
													'value' => isset($post['arrival_date']) ? $post['arrival_date'] : '',
													'disabled' => 'disabled'
												);
												echo form_input($inputAttribute);
?>
											</div>
										</div>
										<div class="col-lg-4">
											<label class="control-label custom-control-label col-lg-5">Departure date</label>
											<div class="col-lg-7">
<?php
												$inputAttribute = array(
													'name' => 'departure_date',
													'class' => 'form-control',
													'id' => 'departure_date',
													'placeholder' => 'dd-mm-yyyy',
													'value' => isset($post['departure_date']) ? $post['departure_date'] : '',
													'disabled' => 'disabled'
												);
												echo form_input($inputAttribute);
?>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-lg-6 col-lg-offset-5" style="padding-left: 30px;padding-top: 25px;">
											<button class="btn btn-warning" type="submit">
												<i class="fa fa-search"></i>  Search
											</button>
<?php
											if(!empty($post['datesArr']) && !empty($post['details']))
											{
?>
												<button class="btn btn-success" type="button" style="margin-left: 10px;" onclick="window.open('<?php echo base_url().'activity_program/export_to_excel'; ?>' , '_blank')">
													<i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export to excel
												</button>
												<button class="btn btn-danger" type="button" style="margin-left: 10px;" onclick="window.open('<?php echo base_url().'activity_program/export_to_pdf'; ?>' , '_blank')">
													<i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export to pdf
												</button>
<?php
											}
?>
										</div>
										<div class="clearfix"></div><br>
									<?php echo form_close(); ?>
								</div>
								<div class="clearfix"></div><br>
								<!----------For search section End---------->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-----------Show Activity program report Start------------>
	<div class="x_panel">
		<div class="x_content">
			<div class="box box-primary">
				<div class="box-body">
					<div class="col-lg-12">
						<div id="previewContainer">
<?php
							if(!empty($post['datesArr']) && !empty($post['details']))
							{
?>
								<div style="width:100%;overflow:scroll;">
									<table class="table table-striped table-bordered activityProgramTable">
										<thead>
											<tr>
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
											foreach($post['details'] as $timeSlot => $detailsValue)
											{
?>
												<tr>

													<td class="tdStartTime">
<?php
														$tempArr = explode('-' , $timeSlot);
														echo $tempArr[0];
?>
													</td>
													<td class="tdFinishTime">
<?php
														$tempArr = explode('-' , $timeSlot);
														echo $tempArr[1];
?>
													</td>
<?php
													foreach($post['datesArr'] as $datesId => $dateValue)
													{
?>
														<td>
<?php
															if(isset($detailsValue[$datesId]))
															{
																echo implode(' / ' , $detailsValue[$datesId]);
															}
?>
														</td>
<?php
													}
?>
												</tr>
<?php
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
	<!-----------Show Activity program report End------------>
</div>