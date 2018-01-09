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
					<div class="col-md-4 resent-grid recommended-grid slider-top-grids">
						<div class="resent-grid-img recommended-grid-img">
							<a data-fancybox data-caption="Facility" href="https://vimeo.com/203451945"><img src="<?php echo base_url(); ?>images/plus_video/img1.jpg" alt="" /></a>
							<div class="time">
								<p>1:32</p>
							</div>
						</div>
						<div class="resent-grid-info recommended-grid-info">
							<h3><a class="title title-info">Pellentesque vitae pulvinar tortor nullam interdum metus a imperdiet</a></h3>
						</div>
					</div>
					<div class="col-md-4 resent-grid recommended-grid slider-top-grids">
						<div class="resent-grid-img recommended-grid-img">
							<a data-fancybox data-caption="Location" href="https://vimeo.com/203452026"><img src="<?php echo base_url(); ?>images/plus_video/img2.jpg" alt="" /></a>
							<div class="time">
								<p>1:04</p>
							</div>
						</div>
						<div class="resent-grid-info recommended-grid-info">
							<h3><a class="title title-info">Interdum pellentesque vitae pulvinar tortor nullam metus a imperdiet</a></h3>
						</div>
					</div>
					<div class="col-md-4 resent-grid recommended-grid slider-top-grids">
						<div class="resent-grid-img recommended-grid-img">
							<a  data-fancybox data-caption="Program" href="https://vimeo.com/203452195"><img src="<?php echo base_url(); ?>images/plus_video/img3.jpg" alt="" /></a>
							<div class="time">
								<p>2:22</p>
							</div>
						</div>
						<div class="resent-grid-info recommended-grid-info">
							<h3><a class="title title-info">Nullam interdum metus a imperdiet pellentesque vitae pulvinar tortor</a></h3>
						</div>
					</div>
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
						'fullScreen',
						'close',
						'download'
					]
				});

				$(".nav-pills a").click(function(){
					$(this).tab('show');
				});
			});
		</script>
	</body>
</html>