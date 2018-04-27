<!--------------Datatable CSS and JS---------------->
<link href="<?php echo base_url(); ?>css/admin/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/admin/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>js/admin/dataTables.bootstrap.min.js"></script>
<link href="<?php echo base_url(); ?>css/custom.css?v=0.7" rel="stylesheet">

<!---------------Sweet Alert CSS and JS----------------->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/sweetalert.css">
<script src="<?php echo base_url(); ?>js/admin/sweetalert.min.js"></script>

<!------------custom javascript for for master modules------------>
<script>
	var pageType = 'list';
	var baseUrl = "<?php echo base_url(); ?>";
	var actionColumnNo = "<?php echo $moduleArr['list']['actionColumn']['columnNo']; ?>";
	var moduleName = "<?php echo $moduleName; ?>";
	var inactive_confirmation = "<?php echo $this->lang->line("inactive_confirmation"); ?>";
	var active_confirmation = "<?php echo $this->lang->line("active_confirmation"); ?>";
</script>
<script src="<?php echo base_url(); ?>js/admin/master.js?v=0.2"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-sm-6 btn-create">
							<h3><?php echo $moduleArr['title']; ?></h3>
						</div>
<?php
						if(!(isset($moduleArr['addHide']) && $moduleArr['addHide'] == 1))
						{
?>
							<div class="col-sm-6 btn-create">
								<a style="float: right;" class="btn btn-primary" href="<?php echo base_url(); ?>master/add_edit/<?php echo $moduleName; ?>">
									<i class="fa fa-plus" aria-hidden="true"></i> Add <?php echo strtolower($moduleArr['title']); ?>
								</a>
							</div>
<?php
						}
?>
						<div class="col-lg-5" style="float: right">
							<?php showSessionMessageIfAny($this);?>
						</div>
					</div>
				</div>
				<div class="clearfix"></div><hr>
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered masterTable">
						<thead>
							<tr>
								<th>Si no.</th>
<?php
								if(!empty($moduleArr['list']))
								{
									foreach($moduleArr['list'] as $key => $value)
									{
										if($key == 'actionColumn')
											echo '<th>Action</th>';
										else
											echo '<th>'.$value['columnTitle'].'</th>';
									}

								}
?>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
