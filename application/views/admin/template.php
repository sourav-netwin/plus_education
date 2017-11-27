<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo $this->lang->line('plus_educational_developments'); ?></title>

		<link href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/admin/nprogress.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/admin/prettify.min.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/admin/custom.min.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/admin/style.css" type="text/css" rel="stylesheet" media="all">

		<script src="<?php echo base_url(); ?>js/jquery-2.1.0.js"></script>
		<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>
	</head>

	<body class="nav-md">
		<div class="container body">
			<div class="main_container">

				<!---------------------Left Menu Section------------------->
				<?php $this->load->view('admin/left_menu'); ?>

				<!---------------------Header Section------------------->
				<?php $this->load->view('admin/header'); ?>

				<!---------------Main Body section--------------->
				<?php $this->load->view($view_page); ?>

				<!---------------Footer section--------------->
				<?php $this->load->view('admin/footer'); ?>

				<script src="<?php echo base_url(); ?>js/bootstrap.js"></script>
				<script src="<?php echo base_url(); ?>js/admin/custom.min.js"></script>
			</div>
		</div>
	</body>
</html>