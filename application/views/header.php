<!-----------Header Section Start------------>
<div class="top-nav w3-agiletop" style="position: relative;z-index: 100;">
	<div class="container navigation-container">
		<div class="navbar-header w3llogo">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
			</button>
			<a href="<?php echo base_url(); ?>"><img class="website-logo-image" src="<?php echo base_url(); ?>images/logo_plus.png"></a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<div class="w3menu navbar-right">
<?php
				$headerMenuDetails = getHeaderMenu();
?>
				<ul class="nav navbar">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('junior_usa_summer_programmes'); ?><b class="caret"></b></a>
						<ul class="dropdown-menu agile_short_dropdown usa-summer-program-menu">
							<li>
								<div class="row">
<?php
									if(!empty($headerMenuDetails['usaSummerProgram']))
									{
										foreach($headerMenuDetails['usaSummerProgram'] as $key => $value)
										{
?>
											<div class="col-md-6">
												<h5 class="menu-heading li-menu-title-small"><?php echo ucwords(strtolower(str_replace('_' , ' ' , $key))); ?></h5>
												<ul>
<?php
													foreach($value as $centreValue)
														echo '<li><a href="'.base_url().'dashboard/junior_centre/'.$centreValue['id'].'">'.ucwords(strtolower($centreValue['centre'])).'</a></li>';
?>
													<li><a class="about-experience-class" href=""><?php echo 'About the '.strtolower(str_replace('_' , ' ' , $key)); ?></a></li>
												</ul>
											</div>
<?php
										}
									}
?>
								</div>
							</li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('junior_europe_summer_programmes'); ?><b class="caret"></b></a>
						<ul class="dropdown-menu agile_short_dropdown europe-summer-program-menu">
							<li>
								<div class="row">
<?php
									if(!empty($headerMenuDetails['europeSummerProgram']))
									{
										$siNo = 1;
										foreach($headerMenuDetails['europeSummerProgram'] as $programKey => $programValue)
										{
?>
											<div class="col-md-<?php echo ($siNo == 3 || $siNo == 5) ? 3 : 2; ?>">
												<h5 class="menu-heading li-menu-title"><?php echo ucwords(strtolower(str_replace('_' , ' ' , $programKey))); ?></h5>
												<ul>
<?php
													foreach($programValue as $regionKey => $regionValue)
													{
?>
														<li>
															<img class="country-flag-menu" src="<?php echo base_url().COUNTRY_FLAG_IMAGE.strtolower($regionKey).'.png'; ?>" />
															<span><?php echo ucwords(strtolower(str_replace('_' , ' ' , $regionKey))); ?></span>
														</li>
<?php
														foreach($regionValue as $centreValue)
															echo '<li><a href="'.base_url().'dashboard/junior_centre/'.$centreValue['id'].'">'.ucwords(strtolower(str_replace('_' , ' ' , $centreValue['centre']))).'</a></li>';
														echo "<hr>";
													}
?>
													<li><a class="about-experience-class" href=""><?php echo 'About the '.strtolower(str_replace('_' , ' ' , $programKey)); ?></a></li>
												</ul>
											</div>
<?php
											$siNo++;
										}
									}
?>
								</div>
							</li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('junior_mini_stay_programmes'); ?><b class="caret"></b></a>
						<ul class="dropdown-menu agile_short_dropdown junior-mini-stay-program-menu">
							<li>
								<div class="row">
									<div class="col-md-3">
										<h5 class="menu-heading li-menu-title-small">
											<img class="country-flag-menu" src="<?php echo base_url(); ?>images/country_flag_icon/united_kingdom.png" />
											<?php echo $this->lang->line('uk_residential'); ?>
										</h5>
										<ul>
											<li><a href=""><?php echo $this->lang->line('london'); ?></a></li>
											<li><a href=""><?php echo $this->lang->line('herforshire'); ?></a></li>
											<li><a href=""><?php echo $this->lang->line('oxford'); ?></a></li>
											<li><a href=""><?php echo $this->lang->line('norwich'); ?></a></li>
											<li><a href=""><?php echo $this->lang->line('derby'); ?></a></li>
											<li><a href=""><?php echo $this->lang->line('windosr'); ?></a></li>
											<li><a href=""><?php echo $this->lang->line('canterbury'); ?></a></li>
											<li><a href=""><?php echo $this->lang->line('southend_of_sea'); ?></a></li>
										</ul>
									</div>
									<div class="col-md-3">
										<h5 class="menu-heading li-menu-title-small">
											<img class="country-flag-menu" src="<?php echo base_url(); ?>images/country_flag_icon/united_kingdom.png" />
											<?php echo $this->lang->line('uk_family_stay'); ?>
										</h5>
										<ul>
											<li><a href=""><?php echo $this->lang->line('london'); ?></a></li>
											<li><a href=""><?php echo $this->lang->line('oxford'); ?></a></li>
										</ul>
									</div>
									<div class="col-md-3">
										<h5 class="menu-heading li-menu-title-small">
											<img class="country-flag-menu" src="<?php echo base_url(); ?>images/country_flag_icon/scotland.png" />
											<?php echo $this->lang->line('scotland_residential'); ?>
										</h5>
										<ul>
											<li><a href=""><?php echo $this->lang->line('stirling'); ?></a></li>
										</ul>
									</div>
									<div class="col-md-3">
										<h5 class="menu-heading li-menu-title-small">
											<img class="country-flag-menu" src="<?php echo base_url(); ?>images/country_flag_icon/usa.png" />
											<?php echo $this->lang->line('usa_family_stay'); ?>
										</h5>
										<ul>
											<li><a href=""><?php echo $this->lang->line('new_york'); ?></a></li>
										</ul>
									</div>
								</div>
							</li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('adult_courses'); ?><b class="caret"></b></a>
						<ul class="dropdown-menu agile_short_dropdown agent-dropdown-menu adult-courses-program-menu">
							<li><a href=""><?php echo $this->lang->line('uk_university_placement'); ?></a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!-----------Header Section End------------>