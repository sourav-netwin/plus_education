<!-----------Top header Section Start------------>
<div class="top-nav header-w3layoutstop">
	<div class="container">
		<div class="navbar-header w3llogo">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<div class="w3menu navbar-right">
				<ul class="nav navbar top-header-menu">
<?php
					$topHeaderMenu = getTopheaderMenu();
					if(!empty($topHeaderMenu))
					{
						foreach($topHeaderMenu as $value)
						{
							if($value['name'] == 'Home')
								$url = base_url();
							elseif($value['url'] != '')
								$url = base_url().'content/'.$value['url'];
							else
								$url = '';
							if(!empty($value['submenu']))
							{
?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $value['name']; ?><b class="caret"></b></a>
									<ul class="dropdown-menu agile_short_dropdown brochure-dropdown-menu">
<?php
										foreach($value['submenu'] as $subMenuValue)
										{
?>
											<li><a href="<?php $subMenuValue['url']; ?>"><?php echo $subMenuValue['name']; ?></a></li>
<?php
										}
?>
									</ul>
								</li>
<?php
							}
							else
							{
?>
								<li><a href="<?php echo $url; ?>"><?php echo $value['name']; ?></a></li>
<?php
							}
						}
					}
?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('agent_area'); ?><b class="caret"></b></a>
						<ul class="dropdown-menu agile_short_dropdown agent-dropdown-menu">
							<li><a href=""><?php echo $this->lang->line('login'); ?></a></li>
							<li><a href=""><?php echo $this->lang->line('retrieve_password'); ?></a></li>
							<li><a href=""><?php echo $this->lang->line('register'); ?></a></li>
						</ul>
					</li>
					<li><a href=""><i class="fa fa-globe" aria-hidden="true"></i><?php echo $this->lang->line('english'); ?></a></li>
				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!-----------Top header Section End------------>