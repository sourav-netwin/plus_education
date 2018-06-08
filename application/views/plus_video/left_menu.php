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
<?php
			if(!empty($centreDetails))
			{
				foreach($centreDetails as $value)
				{
?>
					<p style="font-size: 14px;">
						<i class="fa <?php echo $value['icon_class']; ?> fa-fw w3-margin-right w3-text-theme" style="font-size: 18px;"></i>
						<span style="font-weight: bold;font-size: 16px;"><?php echo $value['title']; ?></span>
					</p>
					<?php echo $value['details']; ?>
					<hr>
<?php
				}
			}
?>
			<a target="_blank" href="<?php echo base_url(); ?>video_gallery/download_centre_details/<?php echo $this->session->userdata('centre_id'); ?>">
				<button type="button" class="w3-button w3-theme-d1 w3-margin-bottom">
					<i class="fa fa-cloud-download"></i> &nbsp;Download
				</button>
			</a>
		</div>
	</div><br>

	<div class="w3-card w3-round">
		<div class="w3-white">
			<button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align">
				<i class="fa fa-download fa-fw w3-margin-right"></i> Instruction for walking tour
			</button>
			<div id="Demo1" class="w3-hide w3-container">
				<p>
					<div class="panel-group">
						<div class="panel panel-default">
							<div class="panel-heading"><i class="fa fa-lg fa-desktop" style="color: #4623c7;"></i>&nbsp;&nbsp;For Desktop</div>
							<div class="panel-body">
								<?php echo getCmsContentById($this->config->item('desktopInstructionCmsId')); ?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><i class="fa fa-lg fa-android" style="color: green;"></i>&nbsp;&nbsp;For Android</div>
							<div class="panel-body">
								<?php echo getCmsContentById($this->config->item('androidInstructionCmsId')); ?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><i class="fa fa-lg fa-apple" style="color: #ff4a4a;"></i>&nbsp;&nbsp;For IOS</div>
							<div class="panel-body">
								<?php echo getCmsContentById($this->config->item('iosInstructionCmsId')); ?>
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