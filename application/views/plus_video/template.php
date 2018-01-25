<!DOCTYPE html>
<html>
	<head>
		<title>Plus Video</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Plus Walking Tour" />

		<link href="<?php echo base_url(); ?>css/admin/style.css" type="text/css" rel="stylesheet" media="all">
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
		<style>
			video {
				max-width: 100%;
				height: auto;
			}
		</style>
		<?php header("Cache-Control: no-cache, must-revalidate"); ?>
	</head>

	<body class="w3-theme-l5">
		<!-------------Load header view-------------->
		<?php $this->load->view('plus_video/header'); ?>

		<div class="w3-container w3-content" style="max-width:1400px;">
			<div class="w3-row">
				<!---------------Load left menu view--------------->
<?php
				if($showLeftMenu == 1)
					$this->load->view('plus_video/left_menu');
?>

				<!------------Load main view page dynamically------------>
				<?php $this->load->view($viewPage); ?>
			</div>
		</div>

		<!-------------Load footer view-------------->
		<?php $this->load->view('plus_video/footer'); ?>

		<script type="text/javascript">
			$(document).ready(function(){
				//Highlight the selected menu from header section
				$('.headerWrapper').find('li a').css('color' , '#9d9d9d');
				var currentUrl = window.location.href;
				if(currentUrl.indexOf('daily-activity') != -1)
				{
					$('.daily-activity').css('color' , '#000').css('background-color' , '#fff');
					$('.plusVideoWraper').css('display' , 'none');
					$('.dailyActivityWrapper').css('display' , 'block');
				}
				else if(currentUrl.indexOf('manage_activity') != -1)
					$('.manage-activity').css('color' , '#000').css('background-color' , '#fff');
				else
				{
					$('.plus-video').css('color' , '#000').css('background-color' , '#fff');
					$('.plusVideoWraper').css('display' , 'block');
					$('.dailyActivityWrapper').css('display' , 'none');
				}
			});

			//This function is used to hide/show the instruction section details
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
