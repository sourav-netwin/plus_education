<!-----------Top header Section Start------------>
<div class="top-nav w3-agiletop topHeaderWrapperClass" style="background: #333333;">
	<div class="container">
		<div class="navbar-header w3llogo">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse topHeaderNavbar" id="bs-example-navbar-collapse-1">
			<div class="w3menu navbar-right">
				<ul class="nav navbar top-header-menu">
<?php
					$topHeaderMenu = getTopheaderMenu();
					if(!empty($topHeaderMenu))
					{
						foreach($topHeaderMenu as $value)
						{
							if(!empty($value['submenu']) && ($value['id'] != $this->config->item('homePageId')))
							{
?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $value['name']; ?><b class="caret"></b></a>
									<ul class="dropdown-menu agile_short_dropdown" style="min-width: 245px;">
<?php
										foreach($value['submenu'] as $subMenuValue)
										{
											$url = getUrlForTopHeader($subMenuValue);
?>
											<li><a <?php if($subMenuValue['type'] == 2 || $subMenuValue['type'] == 3){ ?> target="_blank" <?php } ?> href="<?php echo $url; ?>"><?php echo $subMenuValue['name']; ?></a></li>
<?php
										}
?>
									</ul>
								</li>
<?php
							}
							else
							{
								$url = getUrlForTopHeader($value);
?>
								<li><a href="<?php echo $url; ?>"><?php echo $value['name']; ?></a></li>
<?php
							}
						}
					}
?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('agent_area'); ?><b class="caret"></b></a>
						<ul class="dropdown-menu agile_short_dropdown">
							<li><a target="_blank" href="<?php echo ADMIN_PANEL_URL.'index.php/vauth/agents'; ?>"><?php echo $this->lang->line('login'); ?></a></li>
							<li><a target="_blank" href="<?php echo ADMIN_PANEL_URL.'index.php/vauth/forgotpassword/agents'; ?>"><?php echo $this->lang->line('retrieve_password'); ?></a></li>
							<li><a target="_blank" href="<?php echo ADMIN_PANEL_URL.'index.php/agents/register'; ?>"><?php echo $this->lang->line('register'); ?></a></li>
						</ul>
					</li>
					<li><a href="javascript:void(0);"><i class="fa fa-globe" aria-hidden="true"></i><?php echo $this->lang->line('english'); ?></a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!-----------Top header Section End------------>

<script>
	$(document).ready(function(){
		$('.top-header-menu').find('a').each(function(){
			if($(this).attr('href') == window.location.href)
				$(this).attr('style' , 'color: white !important;font-size: 13px !important;');
		});
	});
</script>