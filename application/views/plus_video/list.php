<!--------------Datatable CSS and JS---------------->
<link href="<?php echo base_url(); ?>css/admin/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/admin/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>js/admin/dataTables.bootstrap.min.js"></script>

<!------------custom javascript for for master modules------------>
<script>
	var pageType = 'list';
	var baseUrl = "<?php echo base_url(); ?>";
	var actionColumnNo = "<?php echo $moduleArr['list']['actionColumn']['columnNo']; ?>";
	var moduleName = "<?php echo $moduleName; ?>";
</script>
<script src="<?php echo base_url(); ?>js/admin/master.js?v=0.2"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<?php showSessionMessageIfAny($this);?>
					</div>
				</div>
				<div class="x_content box-body">
					<h3><?php echo $moduleArr['title']; ?></h3><hr>
					<table id="datatable" class="table table-striped table-bordered">
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
