<?php $footerDetails = getFooterDetails(); ?>
<!---------------------- Footer Section Start ---------------------->
<div class="footer footer-heading-container">
	<div class="container footer-section-container">
		<div class="row">
			<div class="col-md-3 first-footer-box">
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
						if($key == 0)
							$className = 'second-footer-box';
						elseif($key == 1)
							$className = 'third-footer-box';
						elseif($key == 2)
							$className = 'fourth-footer-box';
?>
						<div class="col-md-3 <?php echo $className; ?>">
							<h3 class="footer-heading"><?php echo $parentValue['name']; ?></h3>
							<div class="row margin-bottom-30px">
								<div class="col-xs-8">
									<ul class="list-unstyled footer-nav">
<?php
										foreach($parentValue['subMenu'] as $childValue)
										{
											$url = getUrlForTopHeader($childValue);
											if($childValue['id'] == 25)
												echo '<li class="policy-li-wrapper"><h3 class="footer-heading">'.$childValue['name'].'</h3></li>';
											else
											{
												$styleStr = ($childValue['id'] == 24) ? 'font-weight : bold;' : '';
?>
												<li><a style="<?php echo $styleStr; ?>" href="<?php echo $url; ?>"><?php echo $childValue['name']; ?></a></li>
<?php
											}
										}
?>
									</ul>
								</div>
							</div>
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
</div>
<!---------------------- Footer Section END ---------------------->
