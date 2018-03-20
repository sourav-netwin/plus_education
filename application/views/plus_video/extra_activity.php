<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>

<!---------------Sweet Alert CSS and JS----------------->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/sweetalert.css">
<script src="<?php echo base_url(); ?>js/admin/sweetalert.min.js"></script>

<!----------Datepicker CSS and JS--------->
<link href="<?php echo base_url(); ?>css/datepicker.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>

<!----------Timepicker CSS and JS--------->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/bootstrap-combined.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/bootstrap-datetimepicker.min.css">
<script src="<?php echo base_url(); ?>js/admin/bootstrap-datetimepicker.min.js"></script>
<script>
	$(document).ready(function(){
		$('.datepicker').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true
		});

		$('.timepicker').datetimepicker({
			pickDate: false
		});
	});
</script>

<script>
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
</script>
<script src="<?php echo base_url(); ?>js/admin/extra_activity.js?v=0.1"></script>

<div class="right_col" role="main" style="padding-left: 20px;">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="box box-primary">
						<div class="box-body">
							<h3>Extra activity </h3>
							<div class="border-box col-lg-12">
								<div class="row">
									<div class="col-lg-4" style="float: right;">
										<?php showSessionMessageIfAny($this);?>
									</div>
								</div>
<?php
								$formAttribute = array(
									'class' => 'form-horizontal form-label-left show-custom-error-tag',
									'method' =>'post',
									'id' => 'searchForm'
								);
								echo form_open_multipart('extra_activity/index' , $formAttribute);
?>
									<div class="col-lg-4">
										<label class="control-label custom-control-label col-lg-3">Select centre<span class="required">*</span></label>
										<div class="col-lg-9">
<?php
											$centreId = isset($post['centre_id']) ? $post['centre_id'] : '';
											echo form_dropdown('centre_id' , getCentreDropdownForPlusVideo($this->session->userdata('centre_id')) , $centreId , 'class="form-control" id="centre_id"');
?>
										</div>
									</div>
									<div class="col-lg-4">
										<label class="control-label custom-control-label col-lg-3">Select date<span class="required">*</span></label>
										<div class="col-lg-9">
<?php
											$fieldAttribute = array(
												'name' => 'date',
												'class' => 'form-control datepicker',
												'value' => isset($post['date']) ? $post['date'] : '',
												'placeholder' => 'dd-mm-yyyy'
											);
											echo form_input($fieldAttribute);
?>
										</div>
									</div>
									<div class="col-lg-4" style="padding-left: 30px;padding-top: 25px;">
										<button class="btn btn-warning" type="submit">
											<i class="fa fa-search"></i>&nbsp;&nbsp;Search
										</button>
									</div>
									<div class="clearfix"></div><br>
								<?php echo form_close(); ?>
								<!--------Show master table Start--------->
<?php
								if(!empty($post['masterActivity']))
								{
?>
									<div class="col-lg-12">
										<div class="previewContainer">
											<div>
												<div class="col-lg-4"><img src="<?php echo base_url(); ?>images/logo_plus.png" /></div>
												<div class="col-lg-6">
													<p class="showCentrePreview"><?php echo $post['centreDetails'].'&nbsp;&nbsp;'.date('Y' , strtotime($post['date'])).'&nbsp;(Master activity)';; ?></p>
												</div>
											</div>
											<div style="width:100%;overflow:scroll;">
												<table class="table table-bordered previewTable" width="100%">
													<thead>
														<tr>
															<th colspan="2" align="center">Day</th>
															<th><?php echo date('d-M-Y' , strtotime($post['date'])); ?></th>
															<th>Pick</th>
														</tr>
														<tr>
															<th>From</th>
															<th>To</th>
															<th><?php echo date('l' , strtotime($post['date'])); ?></th>
															<th>Pick</th>
														</tr>
													</thead>
													<tbody>
<?php
														foreach($post['masterActivity'] as $value)
														{
?>
															<tr style="height: 50px;">
																<td><?php echo date('H:i' , strtotime($value['from_time'])); ?></td>
																<td><?php echo date('H:i' , strtotime($value['to_time'])); ?></td>
																<td><?php echo $value['activity']; ?></td>
																<td><button data-ref_id="<?php echo $value['fixed_day_activity_details_id']; ?>" class="btn btn-warning pickRecord">Pick</button></td>
															</tr>
<?php
														}
?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="clearfix"></div><br>
<?php
								}
?>
								<!--------Show master table End--------->
							</div>
							<div class="clearfix"></div><br>
<?php
							$formAttribute = array(
								'class' => 'form-horizontal form-label-left show-custom-error-tag',
								'method' =>'post',
								'id' => 'extraActivityForm'
							);
							echo form_open_multipart('extra_activity/update' , $formAttribute);
								if(isset($post['masterActivity']) && !empty($post['masterActivity']))
								{
?>
									<div class="box-body">
										<div class="col-lg-12">
											<h4 style="color: #786a6a;">
												<i class="fa fa-tasks" aria-hidden="true"></i>
												&nbsp;Activity details group wise
											</h4><br>
											<div class="form-group">
												<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Centre<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="form-control">
														<?php echo $post['centreDetails'] ?>
														<input type="hidden" name="centre_id" value="<?php echo $post['centre_id']; ?>" />
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Date<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="form-control">
														<?php echo $post['date'] ?>
														<input type="hidden" name="date" value="<?php echo $post['date']; ?>" />
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Group<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
<?php
													echo form_dropdown('group_name' , $post['groupReference'] , '' , 'class = "form-control" id="group_name"');
?>
												</div>
											</div>
										</div>
										<div class="clearfix"></div><br>
										<div class="activityDetailsContainer"></div>
									</div>
<?php
									if(count($post['groupReference']) > 1)
									{
?>
										<div class="form-group">
											<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
<?php
												$inputFieldAttribute = array(
													'class' => 'btn btn-success',
													'value' => 'Update'
												);
												echo form_submit($inputFieldAttribute);
?>
											</div>
										</div>
<?php
									}
								}
								else
									echo '<div style="font-size: 16px;color: red;text-align: center;">No activity available</div>';
?>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
