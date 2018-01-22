<!DOCTYPE HTML>
<html>
	<head>
		<title>Plus Video</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Plus Walking Tour" />

		<link href="<?php echo base_url(); ?>css/admin/style.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/custom.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/plus_video/dashboard.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/plus_video/style.css" rel='stylesheet' type='text/css' media="all" />
		<link href="<?php echo base_url(); ?>css/style.css" rel='stylesheet' type='text/css' media="all" />
		<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/plus_video/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
		<link href="<?php echo base_url(); ?>css/style.css" rel='stylesheet' type='text/css' media="all" />
		<script src="<?php echo base_url(); ?>js/jquery-2.1.0.js"></script>
		<script src="<?php echo base_url(); ?>js/admin/jquery.cookie.js"></script>

		<!-------------------Jquery fancy scrol CSS and JS--------------------->
		<link href="<?php echo base_url(); ?>css/plus_video/jquery.custom-scrollbar.css" type="text/css" rel="stylesheet" media="all">
		<script src="<?php echo base_url(); ?>js/admin/jquery.custom-scrollbar.js"></script>

		<!-------------------Jquery fancybox CSS and JS--------------------->
		<link href="<?php echo base_url(); ?>css/jquery.fancybox.css" type="text/css" rel="stylesheet" media="all">
		<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400italic,400,600,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,300italic,400italic,700,400,300' rel='stylesheet' type='text/css'>

		<style>
			video {
				max-width: 100%;
				height: auto;
			}
		</style>

		<?php header("Cache-Control: no-cache, must-revalidate"); ?>
	</head>

	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid" style="border: 0;">
				<div id="navbar" class="navbar-collapse collapse" style="background-color: #fff;">
					<img style="width: 200px;" src="<?php echo base_url(); ?>images/logo_plus.png" />
					<div class="header-top-right">
						<div class="signin">
							<a href="<?php echo base_url(); ?>login/logout" style="background: #ea3868;">
								<i class="fa fa-power-off" style="margin-right: 5px;" aria-hidden="true"></i>Logout
							</a>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</nav>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main">
			<div style="padding-bottom: 30px;">
				<div class="top-grids">
					<div class="recommended-info" style="padding-left: 15px;">
						<h1 class="destination_heading" style="font-size: 22px;margin: 0;">Plus Video for <?php echo $this->session->userdata('centre'); ?></h1>
					</div>
<?php
						if(!empty($videoDetails))
						{
							foreach($videoDetails as $key => $value)
							{
?>
								<div style="margin-top: 30px;" class="col-sm-4 col-xs-4 welcome-w3imgs">
									<figure class="effect-chico">
<?php
										if(file_exists('./'.PLUS_WALKING_TOUR_FRONT_IMAGE.str_replace(substr($value['video'] , (strpos($value['video'] , '.') + 1) , strlen($value['video'])) , 'png' , $value['video'])))
											$imgFile = base_url().PLUS_WALKING_TOUR_FRONT_IMAGE.str_replace(substr($value['video'] , (strpos($value['video'] , '.') + 1) , strlen($value['video'])) , 'png' , $value['video']);
										else
											$imgFile = '';
?>
										<img src="<?php echo $imgFile; ?>" id="videoImage_<?php echo ($key+1); ?>" />
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

					<!---------------Daily Activity Section Start----------------->
					<br><hr style="border-top: 3px double #8c8b8b;"><br>
					<div class="recommended-info" style="padding-left: 15px;">
						<h1 class="destination_heading" style="font-size: 22px;margin: 0;">Daily Activity for <?php echo $this->session->userdata('centre'); ?></h1>
					</div>
<?php
					if($activityDetails)
					{
						foreach($activityDetails as $value)
						{
?>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 w3_agile_mail_right" style="margin-top: 30px;">
								<div class="w3_agileits_mail_right_grid">
									<h4 style="padding-top: 5%;font-size: 2.3em;"><?php echo $value['name']; ?></h4>
									<p id="modern-skin-demo" class="modern-skin demo videoDescription" style="height: 135px;">
										<?php echo $value['description']; ?>
									</p>
									<h5 style="float: right;text-transform: none;margin: 0;">
										<i class="fa fa-clock-o" aria-hidden="true" style="margin-right: 5px;"></i>
										Posted On : <span style="color: #000;"><?php echo $value['added_date']; ?></span>
									</h5>
									<div class="w3_agileits_mail_right_grid_pos">
										<a target="_blank" href="<?php echo ADMIN_PANEL_URL.ACTIVITY_FILE_PATH.$value['file_name']; ?>">
											<img class="img-responsive" src="<?php echo base_url().'images/pdf_icon'; ?>">
										</a>
									</div>
								</div>
							</div>
<?php
						}
					}
					else
						echo "<div style='font-size: 16px;color: red;text-align: center;'>No activity available</div>";
?>
					<div class="clearfix"></div>
					<!---------------Daily Activity Section End----------------->

					<div class="waitClass" style="display: none;">
						<img src='<?php echo base_url(); ?>images/loader.gif' class="waitClassImg" />
					</div>
				</div>
			</div>

			<div class="footer" style="background: #3B4142;padding: 2em 3em;">
				<div class="footer-grids">
					<div class="text-center" style="color: #FFF;font-size: 14px;text-decoration: none;">©2017 The Develovers. All Rights Reserved.</div>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>

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
	</body>
</html>