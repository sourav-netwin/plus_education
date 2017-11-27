<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo $this->lang->line('plus_educational_developments'); ?></title>

		<link href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/font-awesome.min.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/admin/nprogress.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/admin/custom.min.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/admin/style.css" type="text/css" rel="stylesheet" media="all">

		<script src="<?php echo base_url(); ?>js/jquery-2.1.0.js"></script>
		<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>
	</head>

	<body class="login">
		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">
					<form id="loginCmsForm" action="<?php echo base_url(); ?>index.php/admin/login/logged" autocomplete="off" method="post">
						<h1> Login </h1>
						<div>
							<input type="text" class="form-control" placeholder="Username" name="userName" id="userName" autocomplete="off" />
						</div>
						<div>
							<input type="password" class="form-control" placeholder="Password" name="userPassword" id="userPassword" autocomplete="off" />
						</div>
<?php
						if(!empty($captcha) && $captcha['image'] != '')
						{
?>
							<div class="capchaImage">
								<?php echo $captcha['image']; ?>
							</div>
							<div class="capchaText">
								<input type="text" class="form-control" placeholder="Enter captcha" name="capchaName" id="capchaName" autocomplete="off" />
							</div>
<?php
						}
						if(isset($errors) && !empty($errors))
						{
							foreach($errors as $errorText)
								echo '<span class="error" style="margin-bottom:15px;">'.$errorText.'</span>';
						}
?>
						<input type='hidden' name="csrf_token" class="csrf_token" value="<?php echo generateToken('loginCmsForm'); ?>"/>
						<div>
							<button id="submitBtn" class="btn btn-default submit" type="submit">Log in</button>
							<a class="reset_pass" href="#">Lost your password?</a>
						</div>
						<div class="clearfix"></div>

						<div class="separator">
							<div class="clearfix"></div><br />
							<div>
								<img src="<?php echo base_url(); ?>images/logo_plus.png"><br /><br />
								<p>©2017 The Developers. All Rights Reserved.</p>
							</div>
						</div>
					</form>
				</section>
			</div>
		</div>
		<script type = "text/javascript">
			$(document).ready(function(){
				jQuery.validator.addMethod("validData",function(value,element){
					if(/[()+<,>\"\'%&;]/.test(value)){
							return false;
					}else{
						return true;
					}
				},"Please enter valid data.");

				$("#loginCmsForm").validate({
					errorElement: "span",
					rules:{
						userName:{
							required: true,
							validData: true
						},
						userPassword: {
							required: true,
							validData: true
						},
						capchaName: {
							required: true,
							validData: true
						}
					},
					messages: {
						userName :{
							required: "Please enter username.",
						},
						userPassword :{
							required: "Please enter password.",
						},
						capchaName :{
							required: "Please enter capcha.",
						}
					}
				});

				$('#submitBtn').on('click' , function(){
					var $form = $('#loginCmsForm');
					$form.validate();
					if(!$form.valid())
						return false;
					else
					{
						var encrypted_pass_data = Base64.encode($('#userPassword').val());
						$('#userPassword').val(encrypted_pass_data);
					}
				});
			});
		</script>
	</body>
</html>
