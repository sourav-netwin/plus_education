<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $page_title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="<?php echo $this->lang->line('plus_educational_developments'); ?>" />

		<link href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/style.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/custom.css?v=0.1" type="text/css" rel="stylesheet" media="all">

		<script src="<?php echo base_url(); ?>js/jquery-2.1.0.js"></script>
		<script src="<?php echo base_url(); ?>js/bootstrap.js"></script>

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400italic,400,600,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,300italic,400italic,700,400,300' rel='stylesheet' type='text/css'>

	</head>
	<body>
		<div class="container">
			<div class="welcome-agileinfo">
				<div class="col-md-12 agile-welcome-left">
<?php
					if($cont_content)
						echo str_replace(TINYMCE_CURRENT_CONFIG_PATH , ADMIN_PANEL_URL.TINYMCE_IMAGE_PATH , $cont_content);
?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</body>
</html>
