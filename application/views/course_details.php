<script src="<?php echo base_url(); ?>js/admin/jquery.cookie.js"></script>
<?php
	if($referenceFunctionName == '')
	{
?>
		<link href="<?php echo base_url(); ?>css/datepicker.css" type="text/css" rel="stylesheet" media="all">
		<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>
		<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>

		<!---------------Sweet Alert CSS and JS----------------->
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/sweetalert.css">
		<script src="<?php echo base_url(); ?>js/admin/sweetalert.min.js"></script>

		<script>
			$(document).ready(function(){
				$('.datepicker').datepicker({
					format: "dd/mm/yyyy",
					autoclose: true,
					endDate: new Date()
				});

				$.validator.addMethod('checkRegExp', function(value , element , param){
					return ((value != '') && value.match(param));
				} , "<?php echo $this->lang->line('valid_data_error_msg'); ?>");

				$('#applicationFormId').validate({
					errorElement : 'span',
					errorClass : 'error text-danger',
					errorPlacement : function(error , element){
						if(element.is(":radio"))
							error.insertAfter('.radioErrorMsg');
						else
							error.insertAfter(element);
					},
					rules : {
						field_value_41 : {
							required : true
						}
					},
					messages : {
						field_value_41 : {
							required : "<?php echo str_replace('**field**' , 'Address' , $this->lang->line('please_enter_dynamic')); ?>"
						}
					}
				});
<?php
				if(!empty($formDetails))
				{
					foreach($formDetails as $value)
					{
						if($value['required_flag'] == 1)
						{
?>
							$( "input[name='field_value_<?php echo $value['manage_application_form_id']; ?>']" ).rules( "add", {
								required: true,
								messages: {
									required: "<?php echo str_replace('**field**' , $value['label_name'] , $this->lang->line('please_enter_dynamic')); ?>"
								}
							});
<?php
						}
						if($value['field_type'] == 'name')
						{
?>
							$( "input[name='field_value_<?php echo $value['manage_application_form_id']; ?>']" ).rules( "add", {
								checkRegExp: /^[A-Za-z.\s]*$/
							});
<?php
						}
						elseif($value['field_type'] == 'mobile')
						{
?>
							$( "input[name='field_value_<?php echo $value['manage_application_form_id']; ?>']" ).rules( "add", {
								checkRegExp: /^[+]?[0-9]{10,20}$/
							});
<?php
						}
						elseif($value['field_type'] == 'email')
						{
?>
							$( "input[name='field_value_<?php echo $value['manage_application_form_id']; ?>']" ).rules( "add", {
								checkRegExp: /^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-za-z]{2,}$/
							});
<?php
						}
					}
				}
?>
			});
		</script>
<?php
	}
?>

<div class="w3ls-banner-1" style="background: url(<?php echo ADMIN_PANEL_URL.COURSE_IMAGE_PATH.$courseDetails['course_image']; ?>)no-repeat center;"></div>
<div class="welcome welcome-title">
	<div class="container">
		<h2 class="agileits-title about-title"><?php echo $courseDetails['course_name']; ?></h2><hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
<?php
			$className = (!empty($courseDetails['course_specification'])) ? 'col-lg-8 col-md-8 col-sm-12 col-xs-12 junior-course-main-summary' : 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
?>
			<div class="<?php echo $className; ?>">
				<p>
					<?php echo $courseDetails['corse_description']; ?>
				</p>
			</div>
<?php
				if(!empty($courseDetails['course_specification']))
				{
?>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
<?php
						foreach($courseDetails['course_specification'] as $value)
						{
?>
							<p>
								<i class="fa fa-hand-o-right" aria-hidden="true"></i>
								&nbsp;&nbsp;<?php echo $value['specification_option']; ?> : <?php echo $value['specification_value']; ?>
							</p>
<?php
						}
?>
					</div>
<?php
				}
?>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<?php
				if(!empty($courseDetails['course_feature']))
				{
					foreach($courseDetails['course_feature'] as $key => $value)
					{
?>
						<div class="w3_agile_team_grid">
							<div class="hover14 column">
								<figure><img src="<?php echo ADMIN_PANEL_URL.COURSE_FEATURE_IMAGE_PATH.$value['feature_image']; ?>" class="img-responsive courseFeatureImage" /></figure>
							</div>
							<div class="vc_row">
								<div class="vc_custom_heading">
									<div class="col-lg-11 col-md-11" style="margin-top: 4px;">
										<h3 class="vc_custom_heading_text"><?php echo $value['feature_title']; ?></h3>
									</div>
									<div class="col-lg-1 col-md-1">
										<i class="fa fa-lg fa-chevron-circle-down showDetails" aria-hidden="true" data-ref_id="<?php echo 'box'.($key+1); ?>"></i>
									</div>
								</div>
								<span class="box-detail-text" id="<?php echo 'box'.($key+1); ?>" style="display: none;">
									<?php echo html_entity_decode($value['feature_description']); ?>
								</span>
							</div>
						</div>
<?php
						if(ceil(count($courseDetails['course_feature'])/2) == ($key+1))
							echo '</div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';
					}
				}
?>
			</div>
		</div>
<!-----------For Adult course : show brochure and application form(Start)-------->
<?php
		if($referenceFunctionName == '')
		{
?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
<!----------------------For Application form section Start------------------>
<?php
			if(!empty($formDetails))
			{
?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="w3_agile_team_grid" style="width: 100%;">
						<div class="vc_row">
							<div class="vc_custom_heading">
								<div class="col-lg-11 col-md-11" style="margin-top: 4px;">
									<h3 class="vc_custom_heading_text">University Enquiry Form</h3>
								</div>
								<div class="col-lg-1 col-md-1">
									<i class="fa fa-lg fa-chevron-circle-down showDetails" aria-hidden="true" data-ref_id="applicationForm"></i>
								</div>
							</div>
							<span class="box-detail-text" id="applicationForm" style="display: none;">
								<div class="panel-body">
									<div class="col-md-12">
										<u>Please can you answer the following questions to enable us to understand your interests:</u>
									</div>
									<div class="clearfix"></div>
									<br><br>
<?php
									$formAttribute = array(
										'id' => 'applicationFormId',
										'method' => 'post'
									);
									echo form_open('' , $formAttribute);
										foreach($formDetails as $value)
										{
?>
											<div class="form-group">
												<label class="control-label custom-control-label col-xs-12">
													<?php echo $value['label_name']; ?>
													<?php echo ($value['required_flag'] == 1) ? '<span class="required">*</span>' : ''; ?>
												</label>
												<div class="col-xs-12">
													<?php echo showFormField($value); ?>
												</div>
											</div>
											<div class="clearfix"></div><br>
<?php
										}
?>
										<div class="form-group">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input value="Submit" class="btn btn-success" type="submit">
											</div>
										</div>
									<?php echo form_close(); ?>
								</div>
							</span>
						</div>
					</div>
				</div>
<?php
			}
?>
<!----------------------For Application form section End------------------>
<!------------------------For Brochure section Start--------------------------->
<?php
			if(!empty($brochureDetails))
			{
?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="w3_agile_team_grid" style="width: 100%;">
						<div class="vc_row">
							<div class="vc_custom_heading">
								<div class="col-lg-11 col-md-11" style="margin-top: 4px;">
									<h3 class="vc_custom_heading_text">Brochure</h3>
								</div>
								<div class="col-lg-1 col-md-1">
									<i class="fa fa-lg fa-chevron-circle-down showDetails" aria-hidden="true" data-ref_id="brochureId"></i>
								</div>
							</div>
							<span class="box-detail-text" id="brochureId" style="display: none;">
								<div class="panel-body">
<?php
									foreach($brochureDetails as $value)
									{
?>
										<div class="col-md-12">
											<div class="col-md-11">
												<p><?php echo $value['file_description']; ?></p>
											</div>
											<div class="col-md-1">
												<a target="_blank" href="<?php echo ADMIN_PANEL_URL.ADULT_COURSE_BROCHURE.$value['file_name']; ?>">
													<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
												</a>
											</div>
										</div>
										<div class="clearfix"></div><hr>
<?php
									}
?>
								</div>
							</span>
						</div>
					</div>
				</div>
<?php
			}
?>
<!------------------------For Brochure section End--------------------------->
			</div>
<?php
		}
?>
<!-----------For Adult course : show brochure and application form(End)-------->

<!-----------------Destination Section Start------------------->
<?php
		if($referenceFunctionName != '')
		{
?>
				<div class="clearfix"></div>
				<h3 class="agileits-title" style="font-size: 24px;padding-top: 30px;padding-bottom: 15px;">DESTINATIONS</h3><hr>
				<ul style="z-index: 10000;" class="nav nav-pills col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-0">
					<li class="active"><a data-reference_function_name = "<?php echo $referenceFunctionName; ?>" data-table_name = "<?php echo $tableName; ?>" href="#reg_all" data-region_id=''>ALL</a></li>
<?php
					if(!empty($destinationDetails['region']))
					{
						foreach($destinationDetails['region'] as $value)
						{
							$showRegion = $value['region'];
							if($tableName == TABLE_JUNIOR_MINISTAY && $value['region'] == 'United Kingdom')
								$showRegion = 'Junior Europe';
?>
							<li><a data-reference_function_name = "<?php echo $referenceFunctionName; ?>" data-table_name = "<?php echo $tableName; ?>" data-region_id = <?php echo str_replace(' ' , '_' , $value['region']); ?> href="#reg_<?php echo str_replace(' ' , '_' , $value['region']); ?>"><?php echo $showRegion; ?></a></li>
<?php
						}
					}
?>
				</ul>
				<div class="tab-content">
					<div id="reg_all" class="tab-pane fade in active">
						<div class="welcome-agileinfo" style="margin-top: 2em;">
							<div class="col-md-12 agile-welcome-left" style="padding-right: 0;">
<?php
								if(!empty($destinationDetails['centre']))
								{
									foreach($destinationDetails['centre'] as $key => $value)
									{
?>
										<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 welcome-w3imgs" style="margin-top: 30px;">
											<figure class="effect-chico">
												<?php $centreImage = ($value['centre_image'] != '') ? $value['centre_image'] : 'front_default.jpg'; ?>
												<img src="<?php echo ADMIN_PANEL_URL.CENTRE_MASTER_IMAGE_PATH.$centreImage; ?>" />
												<span class="show-destination-class">
													<span class="figcaptionWrapperClass">
														<p class="figcaption-title-class-courses"><?php echo $value['centre_name']; ?></p>
													</span>
												</span>
												<figcaption>
													<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
														<?php echo $value['centre_name']; ?><br>
														<a class="btn view-details-btn" href="<?php echo base_url().$referenceFunctionName.'/'.strtolower(str_replace(' ' , '-' , $value['centre_name'])); ?>"><?php echo $this->lang->line('read_more'); ?></a>
													</p></div>
												</figcaption>
											</figure>
										</div>
<?php
									}
								}
?>
								<div class="clearfix"> </div>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
<?php
					if(!empty($destinationDetails['region']))
					{
						foreach($destinationDetails['region'] as $value)
						{
							echo '<div id="reg_'.str_replace(' ' , '_' , $value['region']).'" class="tab-pane fade"></div>';
						}
					}
?>
				</div>
<?php
		}
?>
<!-----------------Destination Section End------------------->
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.showDetails').on('click' , function(){
			if($('#'+$(this).data('ref_id')).css('display') == 'none')
			{
				$('#'+$(this).data('ref_id')).css('display' , 'block');
				$(this).attr('class' , 'fa fa-lg fa-chevron-circle-up showDetails');
			}
			else
			{
				$('#'+$(this).data('ref_id')).css('display' , 'none');
				$(this).attr('class' , 'fa fa-lg fa-chevron-circle-down showDetails');
			}
		});

		$(".nav-pills a").click(function(){
			var $tabId = $(this).attr('href');
			$.ajax({
				url : '<?php echo base_url(); ?>course/get_centre',
				type : 'POST',
				data : {'region_id' : $(this).data('region_id') ,'table_name' : $(this).data('table_name') , 'reference_function_name' : $(this).data('reference_function_name') , 'csrf_test_name' : $.cookie('csrf_cookie_name')},
				success : function(response){
					$($tabId).empty();
					$($tabId).append(response);
				}
			});
			$(this).tab('show');
		});

		$(document).on('mouseenter' , '.effect-chico' , function(){
			$(this).find('.show-destination-class').css('display' , 'none');
		});
		$(document).on('mouseleave' , '.effect-chico' , function(){
			$(this).find('.show-destination-class').css('display' , 'block');
		});

		//After submit the application form , save the value in database
		$('#applicationFormId').on('submit' , function(e){
			if($(this).valid())
			{
				e.preventDefault();
				var formData = new FormData(this);
				formData.append('csrf_test_name' , $.cookie('csrf_cookie_name'));
				$.ajax({
					url : '<?php echo base_url(); ?>course/manage_application_form',
					data : formData,
					type : 'POST',
					contentType: false,
					cache: false,
					processData: false,
					success : function(response){
						document.getElementById('applicationFormId').reset();
						swal("Thanks!", 'Form Submitted Successfully.', "success");
					}
				});
			}
		});
	});
</script>