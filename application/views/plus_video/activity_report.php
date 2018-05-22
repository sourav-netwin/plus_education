<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>
<link href="<?php echo base_url(); ?>css/custom.css?v=0.7" type="text/css" rel="stylesheet" media="all">

<!----------Datepicker CSS and JS--------->
<link href="<?php echo base_url(); ?>css/datepicker.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>

<!------------custom javascript for for master modules------------>
<script>
	var baseUrl = "<?php echo base_url(); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
	var start_end_date_validation = "<?php echo $this->lang->line("start_end_date_validation"); ?>";
</script>
<script src="<?php echo base_url(); ?>js/admin/master_activity.js?v=2.2"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-lg-12">
<?php
							$formAttribute = array(
								'class' => 'show-custom-error-tag',
								'id' => 'activityReportForm',
								'method' =>'post'
							);
							echo form_open_multipart('master_activity/report' , $formAttribute);
?>
								<input type="hidden" name="flag" value="search">
								<div class="col-lg-12">
									<div class="col-lg-6 form-group">
										<label class="control-label custom-control-label col-lg-4">Arrival date<span class="required">*</span></label>
										<div class="col-lg-8">
<?php
											$inputAttribute = array(
												'name' => 'start_date',
												'id' => 'start_date',
												'class' => 'form-control datepicker',
												'placeholder' => 'dd-mm-yyyy',
												'value' => (isset($post['start_date'])) ? $post['start_date'] : ''
											);
											echo form_input($inputAttribute);
?>
											<span class="error showErrorMessage"></span>
										</div>
									</div>
									<div class="col-lg-6 form-group">
										<label class="control-label custom-control-label col-lg-4">Departure date<span class="required">*</span></label>
										<div class="col-lg-8">
<?php
											$inputAttribute = array(
												'name' => 'end_date',
												'id' => 'end_date',
												'class' => 'form-control datepicker',
												'placeholder' => 'dd-mm-yyyy',
												'value' => (isset($post['end_date'])) ? $post['end_date'] : ''
											);
											echo form_input($inputAttribute);
?>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="col-lg-6 form-group">
										<label class="control-label custom-control-label col-lg-4">Select centre<span class="required">*</span></label>
										<div class="col-lg-8">
<?php
											$centreId = (isset($post['centre_id'])) ? $post['centre_id'] : '';
											echo form_dropdown('centre_id' , getCentreDropdownForPlusVideo($this->session->userdata('centre_id')) , $centreId , 'class="form-control" id="centre_id"');
?>
										</div>
									</div>
									<div class="col-lg-5 form-group" style="margin-left: 15px;">
										<button class="btn btn-warning" type="submit">
											<i class="fa fa-search"></i>&nbsp;&nbsp;Search
										</button>
<?php
										if(!empty($post))
										{
?>
											<button class="btn btn-success" type="button" style="margin-left: 10px;" onclick="window.location='export_to_excel'">
												<i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export to excel
											</button>
<?php
										}
?>
									</div>
								</div>
							<?php echo form_close(); ?>
						</div>
						<div class="form-conrol"></div>
					</div>
				</div>
				<div class="x_content box-body">
<?php
					if(!empty($post))
					{
?>
						<table id="datatable" class="table table-striped table-bordered masterTable">
							<thead>
								<tr>
									<th>Student's group</th>
									<th>Group reference</th>
									<th>Date</th>
									<th>Type of activity</th>
									<th>Location</th>
									<th>Activity</th>
									<th>From time</th>
									<th>To time</th>
									<th>Name</th>
								</tr>
								<tr>
									<th>
										<select data-field_ref = 'group_name' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['groupNameValue']))
											{
												foreach($post['dropdownArr']['groupNameValue'] as $value)
												{
													if(trim($value['group_name']))
														echo '<option value="'.$value['group_name'].'">'.$value['group_name'].'</option>';
												}
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'group_reference' class="form-control filterDropdown">
											<option value="">All</option>
											<option value="not_master">Not Master</option>
<?php
											if(!empty($post['dropdownArr']['groupReferenceValue']))
											{
												foreach($post['dropdownArr']['groupReferenceValue'] as $value)
												{
													if(trim($value['group_reference']))
														echo '<option value="'.$value['group_reference'].'">'.$value['group_reference'].'</option>';
												}
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'date' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['dateValue']))
											{
												foreach($post['dropdownArr']['dateValue'] as $value)
												{
													if(trim($value['date']))
														echo '<option value="'.$value['date'].'">'.date('d-M-Y' , strtotime($value['date'])).'</option>';
												}
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'program_name' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['programNameValue']))
											{
												foreach($post['dropdownArr']['programNameValue'] as $value)
												{
													if(trim($value['program_name']))
														echo '<option value="'.$value['program_name'].'">'.$value['program_name'].'</option>';
												}
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'location' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['locationValue']))
											{
												foreach($post['dropdownArr']['locationValue'] as $value)
												{
													if(trim($value['location']))
														echo '<option value="'.$value['location'].'">'.$value['location'].'</option>';
												}
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'activity' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['activityValue']))
											{
												foreach($post['dropdownArr']['activityValue'] as $value)
												{
													if(trim($value['activity']))
														echo '<option value="'.$value['activity'].'">'.$value['activity'].'</option>';
												}
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'from_time' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['fromTimeValue']))
											{
												foreach($post['dropdownArr']['fromTimeValue'] as $value)
												{
													if(trim($value['from_time']))
														echo '<option value="'.$value['from_time'].'">'.date('H:i' , strtotime($value['from_time'])).'</option>';
												}
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'to_time' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['toTimeValue']))
											{
												foreach($post['dropdownArr']['toTimeValue'] as $value)
												{
													if(trim($value['to_time']))
														echo '<option value="'.$value['to_time'].'">'.date('H:i' , strtotime($value['to_time'])).'</option>';
												}
											}
?>
										</select>
									</th>
									<th>
										<select data-field_ref = 'managed_by_name' class="form-control filterDropdown">
											<option value="">All</option>
<?php
											if(!empty($post['dropdownArr']['managedByValue']))
											{
												foreach($post['dropdownArr']['managedByValue'] as $value)
												{
													if(trim($value))
														echo '<option value="'.$value.'">'.$value.'</option>';
												}
											}
?>
										</select>
									</th>
								</tr>
							</thead>
							<tbody class="activityreportBody">
<?php
								if(!empty($post['details']))
								{
									foreach($post['details'] as $value)
									{
										$styleStr = ($value['extra_flag'] == 2) ? 'background-color: #9fb48e' : '';
?>
										<tr style="<?php echo $styleStr; ?>">
											<td><?php echo $value['group_name']; ?></td>
											<td><?php echo $value['group_reference']; ?></td>
											<td><?php echo date('d-M-Y' , strtotime($value['date'])); ?></td>
											<td><?php echo $value['program_name']; ?></td>
											<td><?php echo $value['location']; ?></td>
											<td><?php echo $value['activity']; ?></td>
											<td><?php echo date('H:i' , strtotime($value['from_time'])); ?></td>
											<td><?php echo date('H:i' , strtotime($value['to_time'])); ?></td>
											<td><?php echo $value['managed_by_name']; ?></td>
										</tr>
<?php
									}
								}
?>
							</tbody>
						</table>
<?php
					}
?>
				</div>
			</div>
		</div>
	</div>
</div>
