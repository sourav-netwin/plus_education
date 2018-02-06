<style>
	.iosInstruction li{
		margin-top:25px;
	}
</style>
<!----------Left Menu Section Start----------->
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 leftMenu" style="padding: 0;">
	<div class="w3-card w3-round w3-white">
		<div class="w3-container">
			<h4 class="w3-center"><?php echo $this->session->userdata('centre'); ?></h4>
			<p class="w3-center">
				<?php $imgPath = ($this->session->userdata('image') != '') ? ADMIN_PANEL_URL.$this->session->userData('path').getThumbnailName($this->session->userdata('image')) : base_url().'images/default_centre.jpg'; ?>
				<img src="<?php echo $imgPath; ?>" style="width: 100%;">
			</p>
			<hr>
			<p style="font-size: 14px;">
				<i class="fa fa-home fa-fw w3-margin-right w3-text-theme" style="font-size: 18px;"></i>
				Professional Linguistic Upper Studies
			</p>
			<p style="font-size: 14px;">
				<i class="fa fa-map-marker fa-fw w3-margin-right w3-text-theme" style="font-size: 18px;"></i>
				8-10 Grosvenor Gardens
			</p>
			<p style="font-size: 14px;">
				<i class="fa fa-building-o fa-fw w3-margin-right w3-text-theme" style="font-size: 18px;"></i>
				Mezzanine floor
			</p>
			<p style="font-size: 14px;">
				<i class="fa fa-globe fa-fw w3-margin-right w3-text-theme" style="font-size: 18px;"></i>
				London, SW1W 0DH
			</p>
			<p style="font-size: 14px;">
				<i class="fa fa-phone fa-fw w3-margin-right w3-text-theme" style="font-size: 18px;"></i>
				<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>
			</p>
			<p style="font-size: 14px;">
				<i class="fa fa-fax fa-fw w3-margin-right w3-text-theme" style="font-size: 18px;"></i>
				<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>
			</p>
			<p style="font-size: 14px;">
				<i class="fa fa-envelope fa-fw w3-margin-right w3-text-theme" style="font-size: 18px;"></i>
				<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>
			</p>
		</div>
	</div><br>

	<div class="w3-card w3-round">
		<div class="w3-white">
			<button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align">
				<i class="fa fa-download fa-fw w3-margin-right"></i> Instruction
			</button>
			<div id="Demo1" class="w3-hide w3-container">
				<p>
					<!-- <ul style="margin-left:5px;">
						<li>
							For Desktop : Direct Download.
						</li>
						<li>
							For Android device : Direct Download.
						</li>
						<li>
							For IOS device : Download through 'Document 6' app .
						</li>
					</ul> -->
					<div class="panel-group">
						<div class="panel panel-default">
							<div class="panel-heading"><i class="fa fa-lg fa-desktop" style="color: #4623c7;"></i>&nbsp;&nbsp;For Desktop</div>
							<div class="panel-body">Direct Download</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><i class="fa fa-lg fa-android" style="color: green;"></i>&nbsp;&nbsp;For Android</div>
							<div class="panel-body">Direct Download</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><i class="fa fa-lg fa-apple" style="color: #ff4a4a;"></i>&nbsp;&nbsp;For IOS</div>
							<div class="panel-body">
								<ol class="iosInstruction">
									<li>
										Go to App Store&nbsp;&nbsp;
										<img style="width: 70px;height: 60px;" src="<?php echo base_url(); ?>images/instruction/app_store.png" />
									</li>
									<li>
										Open and search for Document by Readdle
										<img style="width: 100%;margin-left: -40px;" src="<?php echo base_url(); ?>images/instruction/document.png" />
									</li>
									<li>
										Click OPEN to Download
									</li>
									<li>
										Click on the button on the bottom right hand side (indicated)
										<img style="width: 100%;margin-left: -25px;" src="<?php echo base_url(); ?>images/instruction/main_screen.png" />
									</li>
									<li>
										Insert the following link
										<u style="color: blue;">http://plus-ed.com/betaweb/plus-walking-tour</u>
									</li>
									<li>
										Select YOUR Centre
									</li>
									<li>
										Insert the password (provided by the PLUS Campus Manager)
									</li>
									<li>
										Click on your walking tour or activity plan
									</li>
									<li>
										Choose the file you wish to download
									</li>
									<li>
										Click on the Harrow to save it on your IOS (Red Circle)
										<img style="width: 100%;margin-left: -25px;" src="<?php echo base_url(); ?>images/instruction/download.png" />
									</li>
									<li>
										Once the download is terminated you can view the walking tour <b>OFF LINE</b>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</p>
			</div>
		</div>
	</div>
	<br>

	<div class="w3-container w3-display-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
		<span onclick="this.parentElement.style.display='none'" class="w3-button w3-theme-l3 w3-display-topright">
			<i class="fa fa-remove"></i>
		</span>
		<p><strong>Welcome!</strong></p>
		<p>You can access both videos and daily activity .</p>
	</div>
</div>
<!----------Left Menu Section End----------->