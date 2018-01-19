<!-----------Header Section Start------------>
<div class="top-nav w3-agiletop headerWrapperClass" style="position: relative;z-index: 100;">
	<div class="container navigation-container">
		<div class="navbar-header w3llogo">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?php echo base_url(); ?>"><img class="website-logo-image" src="<?php echo base_url(); ?>images/logo_plus.png"></a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
			<div class="w3menu navbar-right">
<?php
				$headerMenuDetails = getHeaderMenu();
?>
				<ul class="nav navbar">
<!------------------Show home menu on first place for small screens---------------->
<?php
					$topHeaderMenu = getTopheaderMenu();
					if(!empty($topHeaderMenu))
					{
						foreach($topHeaderMenu as $value)
						{
							if($value['id'] == $this->config->item('homeMenuId'))
							{
								$url = getUrlForTopHeader($value);
?>
								<li class="mobile_responsive_menu"><a href="<?php echo $url; ?>"><?php echo $value['name']; ?></a></li>
<?php
							}
						}
					}
?>

<!----------------------Show header menus Start------------------------->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle juniorUsaSummerTitleClass" data-toggle="dropdown"><?php echo $this->lang->line('junior_usa_summer_programmes'); ?><b class="caret"></b></a>
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
														echo '<li><a href="'.base_url().'junior-summer-courses/'.str_replace(' ' , '-' , $centreValue['centre']).'">'.ucwords(strtolower($centreValue['centre'])).'</a></li>';
?>
													<li><a target="_blank" class="about-experience-class" href="<?php echo base_url().'program#'.strtolower(str_replace(array(' ' , '_') , array('-' , '-') , $key)); ?>"><?php echo 'About the '.strtolower(str_replace('_' , ' ' , $key)); ?></a></li>
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
						<a href="#" class="dropdown-toggle juniorEuropeSummerTitleClass" data-toggle="dropdown"><?php echo $this->lang->line('junior_europe_summer_programmes'); ?><b class="caret"></b></a>
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
															echo '<li><a href="'.base_url().'junior-summer-courses/'.str_replace(' ' , '-' , $centreValue['centre']).'">'.ucwords(strtolower($centreValue['centre'])).'</a></li>';
														echo "<hr>";
													}
?>
													<li><a target="_blank" class="about-experience-class" href="<?php echo base_url().'program#'.strtolower(str_replace(array(' ' , '_') , array('-' , '-') , $programKey)); ?>"><?php echo 'About the '.strtolower(str_replace('_' , ' ' , $programKey)); ?></a></li>
<?php
													if(ucwords(strtolower(str_replace('_' , ' ' , $programKey))) == 'Classic'
														|| ucwords(strtolower(str_replace('_' , ' ' , $programKey))) == 'Classic Plus Academy'
														|| ucwords(strtolower(str_replace('_' , ' ' , $programKey))) == 'Classic Premium Plus Academy')
														echo '<li><a target="_blank" class="about-experience-class" href="'.base_url().'program#add-on">Available Add on</a></li>';
?>
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
<?php
									if(!empty($headerMenuDetails['juniorMiniStay']))
									{
										foreach($headerMenuDetails['juniorMiniStay'] as $key => $value)
										{
											$programdetails = getMiniStayProgramdetails($key);
?>
											<div class="col-md-3">
												<h5 class="menu-heading li-menu-title-small">
													<img class="country-flag-menu" src="<?php echo base_url(); ?>images/country_flag_icon/<?php echo $programdetails['logo']; ?>" />
													<?php echo $programdetails['program_name']; ?>
												</h5>
												<ul>
<?php
													foreach($value as $centreValue)
														echo '<li><a href="'.base_url().'junior-mini-stay/'.str_replace(' ' , '-' , $centreValue).'">'.ucwords(strtolower($centreValue)).'</a></li>';
														echo '<li><a target="_blank" class="about-experience-class" href="'.base_url().'program#add-on">Available Add on</a></li>';
?>
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
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('adult_courses'); ?><b class="caret"></b></a>
						<ul class="dropdown-menu agile_short_dropdown agent-dropdown-menu adult-courses-program-menu">
							<li><a href=""><?php echo $this->lang->line('uk_university_placement'); ?></a></li>
						</ul>
					</li>
<!----------------------Show header menus End------------------------->

<!---------Show top header menus with header menus for small screen Start---------->
<?php
					$topHeaderMenu = getTopheaderMenu();
					if(!empty($topHeaderMenu))
					{
						foreach($topHeaderMenu as $value)
						{
							if(!empty($value['submenu']))
							{
?>
								<li class="dropdown mobile_responsive_menu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $value['name']; ?><b class="caret"></b></a>
									<ul class="dropdown-menu agile_short_dropdown" style="min-width: 245px;">
<?php
										foreach($value['submenu'] as $subMenuValue)
										{
											$url = getUrlForTopHeader($subMenuValue);
?>
											<li><a target="_blank" href="<?php echo $url; ?>"><?php echo $subMenuValue['name']; ?></a></li>
<?php
										}
?>
									</ul>
								</li>
<?php
							}
							elseif($value['id'] != $this->config->item('homeMenuId'))
							{
								$url = getUrlForTopHeader($value);
?>
								<li class="mobile_responsive_menu"><a href="<?php echo $url; ?>"><?php echo $value['name']; ?></a></li>
<?php
							}
						}
					}
?>
					<li class="dropdown mobile_responsive_menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('agent_area'); ?><b class="caret"></b></a>
						<ul class="dropdown-menu agile_short_dropdown">
							<li><a href="javascript:void(0);"><?php echo $this->lang->line('login'); ?></a></li>
							<li><a href="javascript:void(0);"><?php echo $this->lang->line('retrieve_password'); ?></a></li>
							<li><a href="javascript:void(0);"><?php echo $this->lang->line('register'); ?></a></li>
						</ul>
					</li>
					<li class="mobile_responsive_menu"><a href="javascript:void(0);"><i class="fa fa-globe" aria-hidden="true"></i><?php echo $this->lang->line('english'); ?></a></li>

<!---------Show top header menus with header menus for small screen End---------->

				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!-----------Header Section End------------>

<script>
	$(document).ready(function(){
		$('.usa-summer-program-menu').find('a').each(function(){
			if($(this).attr('href') == window.location.href)
				$('.juniorUsaSummerTitleClass').attr('style' , 'color: #F44336;border-radius: 2px;transform: scale(1.1);');
		});
		$('.europe-summer-program-menu').find('a').each(function(){
			if($(this).attr('href') == window.location.href)
				$('.juniorEuropeSummerTitleClass').attr('style' , 'color: #F44336;border-radius: 2px;transform: scale(1.1);');
		});
	});
</script>