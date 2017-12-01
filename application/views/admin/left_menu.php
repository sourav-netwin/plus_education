<!---------------------Left Menu Section Start------------------->
<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="<?php echo base_url(); ?>admin/dashboard" class="site_title">
				<img class="website-logo-image" src="<?php echo base_url(); ?>images/logo_plus.png">
			</a>
		</div>
		<div class="clearfix"></div>

		<div class="profile clearfix">
			<div class="profile_pic">
				<img src="<?php echo base_url().MY_PROFILE_IMAGE_PATH.getThumbnailName($this->session->userdata('user_image')); ?>" class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Welcome,</span>
				<h2><?php echo $this->session->userdata('user_name'); ?></h2>
			</div>
		</div>
		<br />

		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<div class="menu_section">
				<h3>General</h3>
				<ul class="nav side-menu">
					<li>
						<a href="<?php echo base_url(); ?>admin/dashboard/index"><i class="fa fa-home"></i> Home</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>admin/program/index"><i class="fa fa-sliders"></i> Manage Program Banner</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>admin/course/index"><i class="fa fa-sliders"></i> Manage Course</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>admin/program_course/index"><i class="fa fa-sliders"></i> Manage Course Program</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>admin/junior_centre/index"><i class="fa fa-sliders"></i> Manage Junior Centre</a>
					</li>
					<!-- <li>
						<a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="form.html">General Form</a></li>
							<li><a href="form_advanced.html">Advanced Components</a></li>
							<li><a href="form_validation.html">Form Validation</a></li>
							<li><a href="form_wizards.html">Form Wizard</a></li>
							<li><a href="form_upload.html">Form Upload</a></li>
							<li><a href="form_buttons.html">Form Buttons</a></li>
						</ul>
					</li> -->
				</ul>
			</div>
		</div>
	</div>
</div>
<!---------------------Left Menu Section End------------------->