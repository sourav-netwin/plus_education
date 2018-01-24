<!DOCTYPE html>
<html>
	<head>
		<title>Plus Video</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Plus Walking Tour" />

		<link href="<?php echo base_url(); ?>css/custom.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/style.css" rel='stylesheet' type='text/css' media="all" />

		<link rel="stylesheet" href="<?php echo base_url().'css/plus_video'; ?>/w3.css">
		<link rel="stylesheet" href="<?php echo base_url().'css/plus_video'; ?>/w3-theme-blue-grey.css">
		<link rel="stylesheet" href="<?php echo base_url().'css'; ?>/font-awesome.min.css">
		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
		<script src="<?php echo base_url(); ?>js/jquery-2.1.0.js"></script>
		<script src="<?php echo base_url(); ?>js/bootstrap.js"></script>
		<script src="<?php echo base_url(); ?>js/admin/jquery.cookie.js"></script>

		<!-------------------Jquery fancy scrol CSS and JS--------------------->
		<link href="<?php echo base_url(); ?>css/plus_video/jquery.custom-scrollbar.css" type="text/css" rel="stylesheet" media="all">
		<script src="<?php echo base_url(); ?>js/admin/jquery.custom-scrollbar.js"></script>

		<!-------------------Jquery fancybox CSS and JS--------------------->
		<link href="<?php echo base_url(); ?>css/jquery.fancybox.css" type="text/css" rel="stylesheet" media="all">
		<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>
	</head>

	<body class="w3-theme-l5">
		<!-------------Header Section Start------------>
		<nav class="navbar navbar-inverse" style="background-color: #4d636f;border-color: #4d636f;">
			<div class="container-fluid" style="border: 0;">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand w3-bar-item w3-button w3-padding-large w3-theme-d4">
						<img style="width: 100px;" src="http://localhost/plus_educational_development/images/logo_plus.png">
					</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li>
							<a href="#" class="w3-hover-white">
								<i class="fa fa-video-camera" aria-hidden="true"></i> Plus Video
							</a>
						</li>
						<li>
							<a href="#" class="w3-hover-white">
								<i class="fa fa-tasks" aria-hidden="true"></i> Daily Activity
							</a>
						</li>
						<li>
							<a href="#" class="w3-hover-white">
								<i class="fa fa-cog" aria-hidden="true"></i> Manage Activity
							</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="<?php echo base_url(); ?>login/logout" class="w3-hover-white">
								<i class="fa fa-power-off" style="margin-right: 5px;" aria-hidden="true"></i> Logout
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-------------Header Section End------------>

		<div class="w3-container w3-content" style="max-width:1400px;">
			<div class="w3-row">
				<!----------Left Menu Section Start----------->
				<div class="w3-col m3 leftMenu">
					<div class="w3-card w3-round w3-white">
						<div class="w3-container">
							<h4 class="w3-center"><?php echo $this->session->userdata('centre'); ?></h4>
							<p class="w3-center"><img src="<?php echo base_url().'images/' ?>avatar3.png" class="w3-circle" style="height:106px;width:106px"></p>
							<hr>
							<p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p>
							<p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> London, UK</p>
							<p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> April 1, 1988</p>
						</div>
					</div><br>

					<div class="w3-card w3-round">
						<div class="w3-white">
							<button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> My Groups</button>
							<div id="Demo1" class="w3-hide w3-container">
								<p>Some text..</p>
							</div>
							<button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> My Events</button>
							<div id="Demo2" class="w3-hide w3-container">
								<p>Some other text..</p>
							</div>
							<button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> My Photos</button>
							<div id="Demo3" class="w3-hide w3-container">
								<div class="w3-row-padding">
									<br>
									<div class="w3-half">
										<img src="https://www.w3schools.com/w3images/lights.jpg" style="width:100%" class="w3-margin-bottom">
									</div>
									<div class="w3-half">
										<img src="https://www.w3schools.com/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
									</div>
									<div class="w3-half">
										<img src="https://www.w3schools.com/w3images/mountains.jpg" style="width:100%" class="w3-margin-bottom">
									</div>
									<div class="w3-half">
										<img src="https://www.w3schools.com/w3images/forest.jpg" style="width:100%" class="w3-margin-bottom">
									</div>
									<div class="w3-half">
										<img src="https://www.w3schools.com/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
									</div>
									<div class="w3-half">
										<img src="https://www.w3schools.com/w3images/fjords.jpg" style="width:100%" class="w3-margin-bottom">
									</div>
								</div>
							</div>
						</div>
					</div>
					<br>

					<div class="w3-container w3-display-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
						<span onclick="this.parentElement.style.display='none'" class="w3-button w3-theme-l3 w3-display-topright">
							<i class="fa fa-remove"></i>
						</span>
						<p><strong>Hey!</strong></p>
						<p>People are looking at your profile. Find out who.</p>
					</div>
				</div>
				<!----------Left Menu Section End----------->

				<div class="w3-col m9">
					<!---------------Plus Video section Start-------------->
					<div class="w3-row-padding">
						<div class="w3-col m12">
							<div class="w3-card w3-round w3-white">
								<div class="w3-container w3-padding">
									<h6 class="w3-opacity" style="font-weight: bold;font-size: 20px;">Plus Video</h6>
<?php
									if(!empty($videoDetails))
									{
										foreach($videoDetails as $key => $value)
										{
?>
											<div style="margin-top: 30px;" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 welcome-w3imgs">
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
							</div>
						</div>
					</div>
					<!---------------Plus Video section End-------------->

					<!----------------Daily Activity Section Start---------------->
<?php
					if($activityDetails)
					{
						foreach($activityDetails as $value)
						{
?>
							<div class="w3-container w3-card w3-white w3-round w3-margin"><br>
								<img src="<?php echo base_url().'images/'; ?>avatar2.png" class="w3-left w3-circle w3-margin-right" style="width:60px">
								<span class="w3-right w3-opacity">
									<i class="fa fa-clock-o" aria-hidden="true" style="margin-right: 5px;"></i>
									Posted On : <span style="color: #000;"><?php echo $value['added_date']; ?></span>
								</span>
								<h4><?php echo $value['name']; ?></h4><br>
								<hr class="w3-clear">
								<p>
									<?php echo $value['description']; ?>
								</p><br>
								<a target="_blank" href="<?php echo ADMIN_PANEL_URL.ACTIVITY_FILE_PATH.$value['file_name']; ?>">
									<button type="button" class="w3-button w3-theme-d1 w3-margin-bottom">
										<i class="fa fa-file-pdf-o"></i>  Download Pdf
									</button>
								</a>
							</div>
<?php
						}
					}
					else
						echo "<div style='font-size: 16px;color: red;text-align: center;'>No activity available</div>";
?>
					<!----------------Daily Activity Section End---------------->
				</div>
			</div>
		</div>

		<div class="footer" style="background: #3B4142;padding: 1em 3em;">
			<div class="footer-grids">
				<div class="text-center" style="color: #FFF;font-size: 14px;text-decoration: none;">©2017 The Develovers. All Rights Reserved.</div>
			</div>
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

			function myFunction(id)
			{
				var x = document.getElementById(id);
				if(x.className.indexOf("w3-show") == -1)
				{
					x.className += " w3-show";
					x.previousElementSibling.className += " w3-theme-d1";
				}
				else
				{
					x.className = x.className.replace("w3-show", "");
					x.previousElementSibling.className = x.previousElementSibling.className.replace(" w3-theme-d1", "");
				}
			}
		</script>
	</body>
</html>
