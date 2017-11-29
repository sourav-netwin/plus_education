<div class="w3ls-banner-1" style="background: url(<?php echo base_url().'uploads/course/'.$courseDetails['course_image']; ?>)no-repeat center;"></div>

<div class="welcome welcome-title">
	<div class="container">
		<h2 class="agileits-title about-title"><?php echo $courseDetails['course_name']; ?></h2><hr>
		<div class="col-lg-12">
			<div class="col-lg-8 junior-course-main-summary">
				<p>
					<?php echo $courseDetails['corse_description']; ?>
				</p>
			</div>
			<div class="col-lg-4">
<?php
				if(!empty($courseDetails['course_specification']))
				{
					foreach($courseDetails['course_specification'] as $value)
					{
?>
						<p>
							<i class="fa fa-hand-o-right" aria-hidden="true"></i>
							&nbsp;&nbsp;<?php echo $value['specification_option']; ?> : <?php echo $value['specification_value']; ?>
						</p>
<?php
					}
				}
?>
			</div>
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
									<figure><img style="height: 230px;" src="<?php echo base_url().'uploads/course_feature/'.$value['feature_image']; ?>" class="img-responsive" /></figure>
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
									<p class="box-detail-text" id="<?php echo 'box'.($key+1); ?>" style="display: none;">
										<?php echo html_entity_decode($value['feature_description']); ?>
									</p>
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
<div class="container destination_container">
	<h1 class="destination_heading">DESTINATIONS</h1><hr>
	<ul class="nav nav-pills" style="padding-left: 350px;">
		<li class="active"><a href="#reg_all" data-region_id=''>ALL</a></li>
<?php
		if(!empty($destinationDetails['region']))
		{
			foreach($destinationDetails['region'] as $value)
			{
?>
				<li><a data-region_id = <?php echo $value['region_id']; ?> href="#reg_<?php echo $value['region_id']; ?>"><?php echo $value['region_name']; ?></a></li>
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
									<img src="<?php echo base_url().'uploads/centre/'.$value['centre_image']; ?>" />
									<figcaption>
										<p class="figcaption-title-class-destination"><?php echo $value['centre_name']; ?></p>
										<p><a class="btn view-details-btn" href="<?php echo base_url(); ?>dashboard/junior_centre"><?php echo $this->lang->line('read_more'); ?></a></p>
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
				echo '<div id="reg_'.$value['region_id'].'" class="tab-pane fade"></div>';
			}
		}
?>
	</div>
</div>
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
				url : '<?php echo base_url(); ?>dashboard/get_centre',
				type : 'POST',
				data : {'region_id' : $(this).data('region_id')},
				success : function(response){
					$($tabId).empty();
					$($tabId).append(response);
				}
			});
			$(this).tab('show');
		});
	});
</script>
</script>