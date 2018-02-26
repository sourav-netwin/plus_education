<!-------------------Jquery fancy scrol CSS and JS--------------------->
<link href="<?php echo base_url(); ?>css/plus_video/jquery.custom-scrollbar.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/admin/jquery.custom-scrollbar.js"></script>

<!-------------------Jquery fancybox CSS and JS--------------------->
<link href="<?php echo base_url(); ?>css/jquery.fancybox.css" type="text/css" rel="stylesheet" media="all">
<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>

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
										if(file_exists('./'.PLUS_WALKING_TOUR_FRONT_IMAGE.str_replace(substr($value['video'] , (strpos($value['video'] , '.') + 1) , strlen($value['video'])) , 'png' , $value['video'])))
											$imgFile = base_url().PLUS_WALKING_TOUR_FRONT_IMAGE.str_replace(substr($value['video'] , (strpos($value['video'] , '.') + 1) , strlen($value['video'])) , 'png' , $value['video']);
										else
											$imgFile = '';
?>
										<img style="width: 100%;" src="<?php echo $imgFile; ?>" id="videoImage_<?php echo ($key+1); ?>" />
										<figcaption>
											<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
												<a data-fancybox data-refid="<?php echo str_replace('=' , '_' , preg_replace_callback('/[A-Z]/' , function($match){return '-'.strtolower($match[0]).'-';} , base64_encode($value['plus_walking_tour_id']))); ?>" href="<?php echo ADMIN_PANEL_URL.PLUS_WALKING_TOUR.$value['video']; ?>">
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
							echo "<div style='font-size: 16px;color: red;text-align: center;'>No videos available</div>";
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
			foreach($activityDetails as $value)
			{
?>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="w3-container w3-card w3-white w3-round w3-margin customMarginClass" style="margin-left: 0 !important;margin-right: 0!important;"><br>
<?php
						if($value['show_type'] == 1)
						{
?>
							<div class="w3ls-banner-1" style="background: url(<?php echo ADMIN_PANEL_URL.ACTIVITY_FRONT_IMAGE_PATH.$value['front_image']; ?>)no-repeat center;"></div>
<?php

						}
						else
						{
?>
							<div class="w3ls-banner-1 figcaptionWrapperClass" style="background: url(<?php echo base_url().'images/bg_image.jpg'; ?>)no-repeat center;">
								<p class="figcaption-title-class-courses text-center" style="color: #fff;font-size: 20px;"><?php echo $value['show_text']; ?></p>
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
						<p style="overflow-y: scroll;height: 150px;">
							<?php echo $value['description']; ?>
						</p><br>
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
?>
					</div>
				</div>
<?php
			}
		}
		else
			echo "<div style='font-size: 16px;color: red;text-align: center;'>No activity available</div>";
?>
	</div>
	<!----------------Daily Activity Section End---------------->
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("[data-fancybox]").fancybox({
			buttons : [
				'download',
				'close'
			],
			afterShow : function(instance , current){
				$('.fancybox-button--download').attr('href' , '<?php echo base_url().'video_gallery/force_download/'; ?>'+current.opts.$orig.attr("data-refid"));
			}
		});

<?php
		if(!empty($videoDetails))
		{
			foreach($videoDetails as $key => $value)
			{
				if(!file_exists('./'.PLUS_WALKING_TOUR_FRONT_IMAGE.str_replace(substr($value['video'] , (strpos($value['video'] , '.') + 1) , strlen($value['video'])) , 'png' , $value['video'])))
				{
?>
					showImageAt('<?php echo ADMIN_PANEL_URL.PLUS_WALKING_TOUR.$value['video']; ?>' , 8 , 'videoImage_<?php echo ($key+1); ?>' , '<?php echo str_replace(substr($value['video'] , (strpos($value['video'] , '.') + 1) , strlen($value['video'])) , 'png' , $value['video']); ?>');
<?php
				}
			}
		}
?>
		function getVideoImage(path, secs, callback)
		{
			var me = this, video = document.createElement('video');
			video.onloadedmetadata = function(){
				if('function' === typeof secs){
					secs = secs(this.duration);
				}
				this.currentTime = Math.min(Math.max(0, (secs < 0 ? this.duration : 0) + secs), this.duration);alert('pop = '+currentTime);
			};
			video.onseeked = function(e) {
				var canvas = document.createElement('canvas');
				canvas.height = 245;
				canvas.width = 435;
				var ctx = canvas.getContext('2d');
				ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
				var img = new Image();
				img.src = canvas.toDataURL();
				callback.call(me, img, this.currentTime, e);
			};
			video.onerror = function(e) {
				callback.call(me, undefined, undefined, e);
			};
			video.src = path;
		}
		function showImageAt(url , secs , wrapperId , fileName)
		{
			$('.waitClass').css('display' , 'block');
			var duration;
			getVideoImage(
				url,
				function(totalTime) {
					duration = totalTime;
					return secs;
				},
				function(img, secs, event) {
					if (event.type == 'seeked') {
						$('#'+wrapperId).attr('src' , img.src);
						//Save the binary images
						$.ajax({
							url : '<?php echo base_url(); ?>video_gallery/save_file',
							data : {'fileName' : fileName , 'binaryImg' : img.src , csrf_test_name: $.cookie('csrf_cookie_name')},
							type : 'POST',
							success : function(response){
								$('.waitClass').css('display' , 'none');
							}
						});
					}
				}
			);
		}

		//For custom scrolbar
		$(".demo").customScrollbar();
	});
</script>