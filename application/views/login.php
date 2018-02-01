<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo $page_title; ?></title>

		<link href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/font-awesome.min.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/admin/nprogress.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/admin/custom.min.css" type="text/css" rel="stylesheet" media="all">
		<link href="<?php echo base_url(); ?>css/admin/style.css" type="text/css" rel="stylesheet" media="all">

		<script src="<?php echo base_url(); ?>js/jquery-2.1.0.js"></script>
		<script src="<?php echo base_url(); ?>js/admin/jquery.validate.min.js"></script>
		<script src="<?php echo base_url(); ?>js/admin/jquery.base64.min.js"></script>
		<script>var baseUrl = "<?php echo base_url(); ?>";</script>
		<script src="<?php echo base_url(); ?>js/admin/particles_custom.js"></script>
	</head>

	<body class="login" style="background: url(<?php echo base_url(); ?>/images/banner.jpg)no-repeat 0px 0px;">
		<div class="login_wrapper">
			<div class="container">
				<div id="login-box">
					<div class="backBorder">
						<div class="logo">
							<img style="border-radius: 0;" src="<?php echo base_url(); ?>images/logo_plus.png" class="img img-responsive img-circle center-block"/>
						</div>
						<div class="controls">
<?php
							$formAttribute = array(
								'id' => 'loginCmsForm',
								'autocomplete' => 'off',
								'method' => 'POST'
							);
							echo form_open(base_url()."login/logged" , $formAttribute);
?>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div>
										<?php echo form_dropdown('centre' , getCentreDropdownForPlusVideo() , '' , 'class="form-control customInputClass dropdownClass" id="centre"'); ?>
									</div>
									<div>
										<input type="password" class="form-control customInputClass" placeholder="Password" name="userPassword" id="userPassword" autocomplete="off" />
									</div>
<?php
									if(!empty($captcha) && $captcha['image'] != '')
									{
?>
										<div class="capchaImage">
											<?php echo $captcha['image']; ?>
										</div>
										<div class="capchaText">
											<input type="text" class="form-control customInputClass" placeholder="Enter captcha" name="capchaName" id="capchaName" autocomplete="off" />
										</div>
<?php
									}
?>
									<div style="color: #fff;font-size: 15px;">
										Login As Campus Manager
										<input type="checkbox" style="margin-left: 5px;" name="campusManager" value="1" />
									</div>
<?php
									if(isset($errors) && !empty($errors))
									{
										echo '<div style="margin-top : 30px;">';
										foreach($errors as $errorText)
											echo '<span class="error" style="margin-bottom:15px;">'.$errorText.'</span>';
										echo '</div>';
									}
?>
									<div>
										<button id="submitBtn" class="btn btn-default btn-block btn-custom" type="submit">Login</button>
									</div>
								</div>
								<div class="clearfix"></div>
							<?php echo form_close(); ?>
						</div>
					</div>
					<div class="separator">
						<p style="color: #fff;" class="text-center">©2017 The Developers. All Rights Reserved.</p>
					</div>
				</div>
			</div>
		</div>

		<div id="particles-js"></div>

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
						centre:{
							required: true
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
						centre :{
							required: "<?php echo str_replace('**field**' , 'centre' , lang('please_enter_dynamic')); ?>",
						},
						userPassword :{
							required: "<?php echo str_replace('**field**' , 'password' , lang('please_enter_dynamic')); ?>",
						},
						capchaName :{
							required: "<?php echo str_replace('**field**' , 'capcha' , lang('please_enter_dynamic')); ?>",
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
						var encrypted_pass_data = $.base64.encode($('#userPassword').val());
						$('#userPassword').val(encrypted_pass_data);
					}
				});
			});
		</script>
	</body>
</html>
