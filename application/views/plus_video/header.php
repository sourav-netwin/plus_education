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
				<img style="width: 100px;" src="<?php echo base_url(); ?>images/logo_plus.png">
			</a>
		</div>
		<div class="collapse navbar-collapse videoActivityHeader" id="myNavbar">
			<ul class="nav navbar-nav navbar-left headerWrapper">
				<li>
					<a href="<?php echo base_url().'plus-walking-tour?plus-video'; ?>" class="w3-hover-white plus-video">
						<i class="fa fa-video-camera" aria-hidden="true"></i> Plus Video
					</a>
				</li>
				<li>
					<a href="<?php echo base_url().'plus-walking-tour?daily-activity'; ?>" class="w3-hover-white daily-activity">
						<i class="fa fa-tasks" aria-hidden="true"></i> Daily Activity
					</a>
				</li>
				<li>
					<a href="<?php echo base_url().'plus-walking-tour?general-info'; ?>" class="w3-hover-white general-info">
						<i class="fa fa-info-circle" aria-hidden="true"></i> General Info
					</a>
				</li>
<?php
				if($this->session->userdata('campusManager') == 1)
				{
?>
					<li>
						<a href="<?php echo base_url().'manage_activity'; ?>" class="w3-hover-white manage-activity">
							<i class="fa fa-cog" aria-hidden="true"></i> Manage Activity
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().'manage_general_info'; ?>" class="w3-hover-white manage-general-info">
							<i class="fa fa-cogs" aria-hidden="true"></i> Manage General Info
						</a>
					</li>
					<li>
					<a href="<?php echo base_url().'plus-walking-tour/day-to-day-activity'; ?>" class="w3-hover-white day-to-day-activity">
						<i class="fa fa-calendar" aria-hidden="true"></i> Activity Programme
					</a>
				</li>
<?php
				}
?>
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