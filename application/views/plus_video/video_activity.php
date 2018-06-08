<!-------------------Jquery fancy scrol CSS and JS--------------------->
<link href="<?php echo base_url(); ?>css/plus_video/jquery.custom-scrollbar.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/admin/jquery.custom-scrollbar.js"></script>

<div class="col-lg-9 col-md-9 col-sm-6 col-xs-12" style="padding: 0;">
	<!---------------Plus Video section Start-------------->
	<div class="plusVideoWraper">
		<div class="w3-row-padding customPaddingClass">
			<div class="w3-col m12 customPaddingClass">
				<div class="w3-card w3-round w3-white">
					<div class="w3-container w3-padding">
						<h6 class="w3-opacity" style="font-weight: bold;font-size: 20px;">
							<i class="fa fa-video-camera" aria-hidden="true" style="margin-right: 10px;"></i>Plus Video
						</h6>
					</div>
				</div>
			</div>
		</div>
		<div class="w3-row-padding customPaddingClass" style="margin-top: 16px;">
			<div class="w3-col m12 customPaddingClass">
				<div class="w3-card w3-round w3-white">
					<div class="w3-container w3-padding">
<?php
						if(!empty($videoDetails))
						{
							foreach($videoDetails as $key => $value)
							{
?>
								<div style="margin-top: 30px;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 welcome-w3imgs">
									<figure class="effect-chico" style="margin: 0;">
<?php
										$imgFile = ADMIN_PANEL_URL.WALKING_TOUR_VIDEO_IMAGE_PATH.$value['video_image'];
?>
										<img style="width: 100%;" src="<?php echo $imgFile; ?>" id="videoImage_<?php echo ($key+1); ?>" />
										<figcaption>
											<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
												<a target="_blank" href="<?php echo $value['video']; ?>">
													<i style="color: #FFFFFF;" class="fa-2x fa fa-play video-icon-class" aria-hidden="true"></i>
												</a>
											</p></div>
										</figcaption>
									</figure>
									<p id="modern-skin-demo" class="modern-skin demo videoDescription"><?php echo $value['description']; ?></p>
								</div>
<?php
							}
						}
						else
							echo "<div style='font-size: 16px;color: red;text-align: center;'>".$this->lang->line('no_video_available')."</div>";
?>
						<div class="clearfix"></div>
					</div>
					<div class="waitClass" style="display: none;">
						<img src='<?php echo base_url(); ?>images/loader.gif' class="waitClassImg" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<!---------------Plus Video section End-------------->

	<!----------------Daily Activity Section Start---------------->
	<div class="dailyActivityWrapper" style="display: none;">
		<div class="w3-row-padding customPaddingClass">
			<div class="w3-col m12 customPaddingClass">
				<div class="w3-card w3-round w3-white">
					<div class="w3-container w3-padding">
						<h6 class="w3-opacity" style="font-weight: bold;font-size: 20px;">
							<i class="fa fa-tasks" aria-hidden="true" style="margin-right: 10px;"></i>Daily Activity
						</h6>
					</div>
				</div>
			</div>
		</div>
<?php
		if($activityDetails)
		{
			foreach($activityDetails as $key => $value)
			{
?>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="w3-container w3-card w3-white w3-round w3-margin customMarginClass" style="margin-left: 0 !important;margin-right: 0!important;min-height: 697px;"><br>
<?php
						if($value['show_type'] == 1)
						{
?>
							<div class="w3ls-banner-1" style="background: url(<?php echo getPhotogalleryFullImagePath($value['front_image']); ?>)no-repeat center;"></div>
<?php

						}
						else
						{
?>
							<div class="w3ls-banner-1 figcaptionWrapperClass" style="background: url(<?php echo base_url().'images/bg_image.jpg'; ?>)no-repeat center;">
								<p class="figcaption-title-class-courses text-center" style="color: #fff;font-size: 20px;">
<?php
									echo implode(' ' , array_map(function($value){
																	if(strlen($value) > 20)
																		return chunk_split($value , 20).' ';
																	else
																		return $value;
																} , explode(' ' , $value['show_text'])));
?>
								</p>
							</div>
<?php
						}
?>
						<span class="w3-right w3-opacity" style="margin-top:10px;">
							<i class="fa fa-clock-o" aria-hidden="true" style="margin-right: 5px;"></i>
							Posted On : <span style="color: #000;"><?php echo $value['added_date']; ?></span>
						</span>
						<h4><?php echo $value['name']; ?></h4>
						<hr class="w3-clear">
						<div style="overflow-y: scroll;height: 150px;">
							<?php echo $value['description']; ?>
						</div><br>
<?php
						$filesArr = showDailyActivityFiles($value['plus_activity_id']);
						if(!empty($filesArr))
						{
							foreach($filesArr as $filesArrValue)
							{
?>
								<a href="<?php echo base_url().'video_gallery/download_activity_file/'.str_replace('=' , '_' , preg_replace_callback('/[A-Z]/' , function($match){return '-'.strtolower($match[0]).'-';} , base64_encode($filesArrValue['id']))); ?>">
									<button type="button" class="w3-button w3-theme-d1 w3-margin-bottom">
										<i class="<?php echo $filesArrValue['className']; ?>"></i>  Download file
									</button>
								</a>
<?php
							}
						}
						else
							echo "<div class='w3-margin-bottom' style='font-size: 16px;color: red;text-align: center;'>".$this->lang->line('no_file_available')."</div>";
?>
					</div>
				</div>
<?php
				if(($key+1)%2 == 0)
					echo '<div class="clearfix"></div>';
			}
		}
		else
			echo "<div style='font-size: 16px;color: red;text-align: center;'>".$this->lang->line('no_activity_available')."</div>";
?>
	</div>
	<!----------------Daily Activity Section End---------------->

	<!----------------Genaral info Section Start---------------->
	<div class="generalInfoWrapper" style="display: none;">
		<div class="w3-row-padding customPaddingClass">
			<div class="w3-col m12 customPaddingClass">
				<div class="w3-card w3-round w3-white">
					<div class="w3-container w3-padding">
						<h6 class="w3-opacity" style="font-weight: bold;font-size: 20px;">
							<i class="fa fa-info-circle" aria-hidden="true" style="margin-right: 10px;"></i>General Info
						</h6>
					</div>
				</div>
			</div>
		</div>
<?php
		if($generalInfoDetails)
		{
			foreach($generalInfoDetails as $key => $value)
			{
?>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="w3-container w3-card w3-white w3-round w3-margin customMarginClass" style="margin-left: 0 !important;margin-right: 0!important;min-height: 697px;"><br>
<?php
						if($value['show_type'] == 1)
						{
?>
							<div class="w3ls-banner-1" style="background: url(<?php echo getPhotogalleryFullImagePath($value['front_image']); ?>)no-repeat center;"></div>
<?php

						}
						else
						{
?>
							<div class="w3ls-banner-1 figcaptionWrapperClass" style="background: url(<?php echo base_url().'images/bg_image.jpg'; ?>)no-repeat center;">
								<p class="figcaption-title-class-courses text-center" style="color: #fff;font-size: 20px;">
<?php
									echo implode(' ' , array_map(function($value){
																	if(strlen($value) > 20)
																		return chunk_split($value , 20).' ';
																	else
																		return $value;
																} , explode(' ' , $value['show_text'])));
?>
								</p>
							</div>
<?php
						}
?>
						<span class="w3-right w3-opacity" style="margin-top:10px;">
							<i class="fa fa-clock-o" aria-hidden="true" style="margin-right: 5px;"></i>
							Posted On : <span style="color: #000;"><?php echo $value['added_date']; ?></span>
						</span>
						<h4><?php echo $value['name']; ?></h4>
						<hr class="w3-clear">
						<div style="overflow-y: scroll;height: 150px;">
							<?php echo $value['description']; ?>
						</div><br>
<?php
						$filesArr = showGeneralInfoFiles($value['plus_general_info_id']);
						if(!empty($filesArr))
						{
							foreach($filesArr as $filesArrValue)
							{
?>
								<a href="<?php echo base_url().'video_gallery/download_general_info_file/'.str_replace('=' , '_' , preg_replace_callback('/[A-Z]/' , function($match){return '-'.strtolower($match[0]).'-';} , base64_encode($filesArrValue['id']))); ?>">
									<button type="button" class="w3-button w3-theme-d1 w3-margin-bottom">
										<i class="<?php echo $filesArrValue['className']; ?>"></i>  Download file
									</button>
								</a>
<?php
							}
						}
						else
							echo "<div class='w3-margin-bottom' style='font-size: 16px;color: red;text-align: center;'>".$this->lang->line('no_file_available')."</div>";
?>
					</div>
				</div>
<?php
				if(($key+1)%2 == 0)
					echo '<div class="clearfix"></div>';
			}
		}
		else
			echo "<div style='font-size: 16px;color: red;text-align: center;'>".$this->lang->line('no_activity_available')."</div>";
?>
	</div>
	<!----------------Genaral info Section End---------------->

</div>

<script type="text/javascript">
	$(document).ready(function(){
		//For custom scrolbar
		$(".demo").customScrollbar();
	});
</script>