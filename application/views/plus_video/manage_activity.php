<!--------------Datatable CSS and JS---------------->
<link href="<?php echo base_url(); ?>css/admin/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/admin/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>js/admin/dataTables.bootstrap.min.js"></script>

<!---------------Sweet Alert CSS and JS----------------->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/sweetalert.css">
<script src="<?php echo base_url(); ?>js/admin/sweetalert.min.js"></script>

<!------------custom javascript for program course------------>
<script>
	var pageType = 'list';
	var inactive_confirmation = "<?php echo $this->lang->line("inactive_confirmation"); ?>";
	var active_confirmation = "<?php echo $this->lang->line("active_confirmation"); ?>";
	var delete_confirmation = "<?php echo $this->lang->line("delete_confirmation"); ?>";
</script>
<script src="<?php echo base_url(); ?>js/admin/manage_activity.js?v=0.1"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 15px;">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<a class="btn btn-primary" href="<?php echo base_url(); ?>/manage_activity/add_edit"><i class="fa fa-plus" aria-hidden="true"></i> Add activity</a>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<?php showSessionMessageIfAny($this);?>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="overflow-x: scroll;">
			<table id="datatable" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Si no.</th>
						<th>Front Image</th>
						<th>Activity Name</th>
						<th>Centre</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
<?php
				if(!empty($activityDetails))
				{
?>
					<tbody>
<?php
						foreach($activityDetails as $value)
						{
?>
							<tr>
								<td><?php echo $value['0']; ?></td>
								<td><?php echo $value['1']; ?></td>
								<td><?php echo $value['2']; ?></td>
								<td><?php echo $value['3']; ?></td>
								<td><?php echo $value['4']; ?></td>
								<td><?php echo $value['5']; ?></td>
							</tr>
<?php
						}
?>
					</tbody>
<?php
				}
?>
			</table>
		</div>
	</div>
</div>
