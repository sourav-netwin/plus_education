<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>

<!---------------Date picker css and js-------------->
<link href="<?php echo base_url(); ?>css/datepicker.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function(){
	$('.datepicker').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true
	});
});
</script>

<div class="col-lg-9 col-md-9 col-sm-6 col-xs-12" style="padding: 0;">
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
										<div class="col-lg-6">
											<label class="control-label custom-control-label col-lg-3">Centre<span class="required">*</span></label>
											<div class="col-lg-9">
<?php
												$centreId = isset($post['centre_id']) ? $post['centre_id'] : '';
												echo form_dropdown('centre_id' , getCentreDropdownForPlusVideo($this->session->userdata('centre_id')) , $centreId , 'class="form-control" id="centre_id"');
?>
											</div>
										</div>
										<div class="col-lg-6">
											<label class="control-label custom-control-label col-lg-3">Group</label>
											<div class="col-lg-9">
<?php
												$groupId = isset($post['group_id']) ? $post['group_id'] : '';
												echo form_dropdown('group_id' , $groupDropdown , $groupId , 'class="form-control" id="group_id"');
?>
											</div>
										</div>
										<div class="clearfix"></div><br>
										<div class="col-lg-6">
											<label class="control-label custom-control-label col-lg-3">From<span class="required">*</span></label>
											<div class="col-lg-9">
<?php
												$fieldAttribute = array(
													'name' => 'from_date',
													'class' => 'form-control datepicker',
													'value' => isset($post['from_date']) ? $post['from_date'] : '',
													'placeholder' => 'dd-m-yyyy',
													'id' => 'from_date'
												);
												echo form_input($fieldAttribute);
?>
												<span class="error customError"></span>
											</div>
										</div>
										<div class="col-lg-6">
											<label class="control-label custom-control-label col-lg-3">To<span class="required">*</span></label>
											<div class="col-lg-9">
<?php
												$fieldAttribute = array(
													'name' => 'to_date',
													'class' => 'form-control datepicker',
													'value' => isset($post['to_date']) ? $post['to_date'] : '',
													'placeholder' => 'dd-m-yyyy',
													'id' => 'to_date'
												);
												echo form_input($fieldAttribute);
?>
											</div>
										</div>
										<div class="col-lg-6 col-lg-offset-4" style="padding-left: 30px;padding-top: 25px;">
											<button class="btn btn-warning" type="submit">
												<i class="fa fa-search"></i>  Search
											</button>
<?php
											if(isset($post['htmlStr']))
											{
?>
												<button class="btn btn-success" type="button" style="margin-left: 10px;" onclick="window.open('<?php echo base_url().'video_gallery/open_pdf'; ?>' , '_blank')">
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
<?php
								if(isset($post['htmlStr']))
									echo $post['htmlStr'];
?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		//This is to check the validation for the search fields using jquery validator
		$('#searchForm').validate({
			errorElement : 'span',
			rules : {
				centre_id : {
					required : true
				},
				from_date : {
					required : true
				},
				to_date : {
					required : true
				}
			},
			submitHandler : function(){
				var dateArr1 = $('#from_date').val().split('-');
				var dateArr2 = $('#to_date').val().split('-');
				if(new Date(dateArr1[2] , dateArr1[1]-1 , dateArr1[0]) > new Date(dateArr2[2] , dateArr2[1]-1 , dateArr2[0]))
				{
					$('.customError').text('<?php echo $this->lang->line('from_to_error_date'); ?>').css('display' , 'block');
					return false;
				}
				else
				{
					$('.customError').text('');
					return true;
				}
			}
		});

		//On change of the centre dropdown , it will get the group dropdown values through ajax call
		$(document).on('change' , '#centre_id' , function(){
			$.ajax({
				url : '<?php echo base_url(); ?>video_gallery/get_group',
				type : 'POST',
				data : {'centre_id' : $(this).val() , 'csrf_test_name' : $.cookie('csrf_cookie_name')},
				success : function(response){
					$('#group_id').empty();
					$('#group_id').append(response);
				}
			});
		});
	});
</script>