<!DOCTYPE HTML>
<html>
	<head>
		<title>Plus Video</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Plus Video" />

		<link href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/plus_video/dashboard.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/plus_video/style.css" rel='stylesheet' type='text/css' media="all" />
		<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/plus_video/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
		<script src="<?php echo base_url(); ?>js/jquery-2.1.0.js"></script>

		<!-------------------Jquery fancybox CSS and JS--------------------->
		<link href="<?php echo base_url(); ?>css/jquery.fancybox.css" type="text/css" rel="stylesheet" media="all">
		<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>

		<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>

		<style>
			video {
				max-width: 100%;
				height: auto;
			}
		</style>
	</head>

	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div id="navbar" class="navbar-collapse collapse">
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
			<div class="main-grids">
				<div class="top-grids">
					<div class="recommended-info">
						<h3>Plus Video for <?php echo $this->session->userdata('centre'); ?></h3>
					</div>
<?php
						if(!empty($videoDetails))
						{
							foreach($videoDetails as $key => $value)
							{
?>
								<div style="margin-top: 30px;" class="col-md-4 resent-grid recommended-grid slider-top-grids">
									<div class="resent-grid-img recommended-grid-img">
										<a data-fancybox data-caption="Facility" id="videoImage_<?php echo ($key+1); ?>" href="<?php echo ADMIN_PANEL_URL.PLUS_WALKING_TOUR.$value['video']; ?>"></a>
									</div>
									<div style="border-top: 1px solid #C1C1C1;" class="resent-grid-info recommended-grid-info">
										<h3><a class="title title-info"><?php echo $value['description']; ?></a></h3>
									</div>
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

			<div class="footer">
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
						'close'
					]
				});

				$(".nav-pills a").click(function(){
					$(this).tab('show');
				});

<?php
				if(!empty($videoDetails))
				{
					foreach($videoDetails as $key => $value)
					{
?>
						showImageAt('<?php echo ADMIN_PANEL_URL.PLUS_WALKING_TOUR.$value['video']; ?>' , 8 , 'videoImage_<?php echo ($key+1); ?>');
<?php
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
				function showImageAt(url , secs , wrapperId)
				{
					var duration;
					getVideoImage(
						url,
						function(totalTime) {
							duration = totalTime;
							return secs;
						},
						function(img, secs, event) {
							if (event.type == 'seeked') {
								document.getElementById(wrapperId).appendChild(img);
							}
						}
					);
				}
			});
		</script>
	</body>
</html>