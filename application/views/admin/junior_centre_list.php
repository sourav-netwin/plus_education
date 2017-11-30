<link href="<?php echo base_url(); ?>css/admin/dataTables.bootstrap.min.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/admin/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>js/admin/dataTables.bootstrap.min.js"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-5 successMessage">
<?php
			$message = '';
			if($this->input->get('success') == 'add')
				$message = str_replace('**module**' , 'Junior Centre' , $this->lang->line('add_success_message'));
			elseif($this->input->get('success') == 'edit')
				$message = str_replace('**module**' , 'Junior Centre' , $this->lang->line('edit_success_message'));
			elseif($this->input->get('success') == 'delete')
				$message = str_replace('**module**' , 'Junior Centre' , $this->lang->line('delete_success_message'));
			echo $message;
?>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Junior Centre List</h2>
					<div class="buttons pull-right">
						<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/junior_centre/add"><i class="fa fa-plus" aria-hidden="true"></i> Add Junior Centre</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>SI No.</th>
								<th>Image</th>
								<th>Centre Name</th>
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
<div class="modal fade" id="juniorCentreStatus" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Junior Centre</h4>
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

<script type = "text/javascript">
	$(document).ready(function(){
		var table = $("#datatable").DataTable({
			processing : true,
			stateSave : true,
			serverSide : true,
			ajax : {
				url : '<?php echo base_url(); ?>admin/junior_centre/get_junior_centre',
				type : 'POST'
			},
			aoColumnDefs: [
				{"bSortable" : false , "aTargets" : [1,3,4]}
			]
		});

		$(document).on('click' , '.global-list-status-icon' , function(e){
			var message = ($(this).data('status_type') == 1) ? '<?php echo str_replace("**module**" , "Centre" , $this->lang->line("inactive_confirmation")); ?>' : '<?php echo str_replace("**module**" , "Centre" , $this->lang->line("active_confirmation")); ?>';
			$('#statusUpdateMessage').text(message);
			$('#statusUpdateMessage').append('<input type="hidden" id="junior_centre_id" value="'+$(this).data('junior_centre_id')+'"><input type="hidden" id="junior_centre_status" value="'+$(this).data('status_type')+'">');
			$('#juniorCentreStatus').modal();
		});

		$(document).on('click' , '#updateStatusBtn' , function(){
			$.ajax({
				url : '<?php echo base_url(); ?>admin/junior_centre/update_status',
				type : 'POST',
				data : {'junior_centre_id' : $('#junior_centre_id').val() , 'junior_centre_status' : $('#junior_centre_status').val()},
				success : function(){
					$('#juniorCentreStatus').modal('hide');
					table.ajax.reload();
				}
			});
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
