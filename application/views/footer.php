<?php
	$footerDetails = getFooterDetails();
	$this->config->load('cms_static_id');
?>
<!---------------------- Footer Section Start ---------------------->
<div class="footer footer-heading-container" style="padding-left: 0;padding-right: 0;">
	<div class="container">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<img src="http://plus-ed.com/htmlsite/assets/img/logo/logo_plus.png" class="logo" alt="Repute">
			<p class = "footer-logo-name"><?php echo $this->lang->line('plus_full_form'); ?></p>
			<br>
			<address class="margin-bottom-30px">
				<?php echo $footerDetails['address']; ?>
			</address>
		</div>
<?php
		if(!empty($footerDetails['footerDetails']))
		{
			foreach($footerDetails['footerDetails'] as $key => $parentValue)
			{
				$paddingStyle = ($parentValue['id'] == $this->config->item('usefulInformationId')) ? 'padding-left:0' : 'padding:0';
				$paddingStyle='';
?>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="<?php echo $paddingStyle; ?>">
					<h3 class="footer-heading"><?php echo $parentValue['name']; ?></h3>
					<ul class="list-unstyled footer-nav">
<?php
						if(!empty($parentValue['subMenu']))
						{
							foreach($parentValue['subMenu'] as $childValue)
							{
								$url = getUrlForTopHeader($childValue);
								if($childValue['id'] == $this->config->item('policiesId'))
									echo '<li class="policy-li-wrapper"><h3 class="footer-heading">'.$childValue['name'].'</h3></li>';
								else
								{
									$styleStr = ($childValue['id'] == $this->config->item('visaInformationId')) ? 'font-weight : bold;' : '';
?>
									<li><a style="<?php echo $styleStr; ?>" href="<?php echo $url; ?>" <?php echo getTarget($childValue); ?>><?php echo $childValue['name']; ?></a></li>
<?php
								}
							}
						}
?>
					</ul>
				</div>
<?php
			}
		}
?>
		<div class="clearfix"> </div>
		<div class="text-center copyright">
			<?php echo $this->lang->line('footer_copy_rights_text'); ?>
		</div>
	</div>
</div>
<!---------------------- Footer Section END ---------------------->
