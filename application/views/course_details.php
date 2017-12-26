<div class="w3ls-banner-1" style="background: url(<?php echo ADMIN_PANEL_URL.COURSE_IMAGE_PATH.$courseDetails['course_image']; ?>)no-repeat center;"></div>

<div class="welcome welcome-title">
	<div class="container">
		<h2 class="agileits-title about-title"><?php echo $courseDetails['course_name']; ?></h2><hr>
		<div class="col-lg-12">
<?php
			$className = (!empty($courseDetails['course_specification'])) ? 'col-lg-8 junior-course-main-summary' : 'col-lg-12';
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
					<div class="col-lg-4">
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
	</div>
</div>

<div class="team">
	<div class="container">
		<div class="w3_agile_team_grids">
			<div class="col-lg-12">
				<div class="col-lg-6">
<?php
					if(!empty($courseDetails['course_feature']))
					{
						foreach($courseDetails['course_feature'] as $key => $value)
						{
?>
							<div class="col-md-12 w3_agile_team_grid">
								<div class="hover14 column">
									<figure><img style="height: 230px;" src="<?php echo ADMIN_PANEL_URL.COURSE_FEATURE_IMAGE_PATH.$value['feature_image']; ?>" class="img-responsive" /></figure>
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
								echo '</div><div class="col-lg-6">';
						}
					}
?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-----------------Destination Section Start------------------->
<?php
		if($referenceFunctionName != '')
		{
?>
			<div class="container destination_container">
				<h1 class="destination_heading">DESTINATIONS</h1><hr>
				<ul class="nav nav-pills" style="padding-left: 350px;">
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
							<div class="col-md-12 agile-welcome-left">
<?php
								if(!empty($destinationDetails['centre']))
								{
									foreach($destinationDetails['centre'] as $key => $value)
									{
?>
										<div class="col-sm-3 col-xs-3 welcome-w3imgs">
											<figure class="effect-chico">
												<?php $centreImage = ($value['centre_image'] != '') ? $value['centre_image'] : 'front_default.jpg'; ?>
												<img src="<?php echo ADMIN_PANEL_URL.CENTRE_MASTER_IMAGE_PATH.$centreImage; ?>" />
												<span class="show-destination-class"><p><?php echo $value['centre_name']; ?></p></span>
												<figcaption>
													<p class="figcaption-title-class-destination"><?php echo $value['centre_name']; ?></p>
													<p><a class="btn view-details-btn" href="<?php echo base_url().$referenceFunctionName.'/'.str_replace(' ' , '-' , $value['centre_name']); ?>"><?php echo $this->lang->line('read_more'); ?></a></p>
												</figcaption>
											</figure>
										</div>
<?php
										if(($key+1) % 4 == 0)
											echo '<div class="clearfix" style="margin-bottom: 30px;"></div>';
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
			</div>
<?php
		}
?>
<!-----------------Destination Section End------------------->

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
				data : {'region_id' : $(this).data('region_id') ,'table_name' : $(this).data('table_name') , 'reference_function_name' : $(this).data('reference_function_name')},
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
	});
</script>
</script>