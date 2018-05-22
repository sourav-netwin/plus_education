<div class="w3ls-banner-1" style="background: url(<?php echo ADMIN_PANEL_URL.ADULT_COURSE_IMAGE_PATH.$courseDetails['image']; ?>)no-repeat center;"></div>
<div class="welcome welcome-title">
	<div class="container">
		<h2 class="agileits-title about-title"><?php echo $courseDetails['title']; ?></h2><hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<p>
					<?php echo $courseDetails['description']; ?>
				</p>
			</div>
		</div>
		<div class="clearfix"></div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<?php
				if(!empty($courseFeature))
				{
					foreach($courseFeature as $key => $value)
					{
?>
						<div class="w3_agile_team_grid">
							<div class="hover14 column">
								<figure><img src="<?php echo ADMIN_PANEL_URL.ADULT_COURSE_FEATURE_IMAGE_PATH.$value['feature_image']; ?>" class="img-responsive courseFeatureImage" /></figure>
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
									<?php echo str_replace(TINYMCE_ADULT_CONFIG_PATH , ADMIN_PANEL_URL.TINYMCE_IMAGE_PATH , $value['feature_description']); ?>
								</span>
							</div>
						</div>
<?php
						if(ceil(count($courseFeature)/2) == ($key+1))
							echo '</div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';
					}
				}
?>
			</div>
		</div>
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
	});
</script>