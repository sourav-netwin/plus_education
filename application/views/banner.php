<!---------------------Banner Section Start---------------------->
<div class="w3ls-banner">
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
<?php
			for($i = 0 ; $i < count($bannerDetails) ; $i++)
			{
?>
				<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
<?php
			}
?>
		</ol>

		<div class="carousel-inner">
<?php
			foreach($bannerDetails as $key => $value)
			{
?>
				<div class="item <?php echo ($key == 0) ? 'active' : ''; ?>">
					<img src="<?php echo base_url(); ?>uploads/program/<?php echo $value['program_image']; ?>" style="width:100%;">
					<div class="carousel-caption">
						<div class="hero-heading">
							<span><?php echo $value['program_title']; ?></span>
							<p class="lead"><?php echo $value['program_short_description']; ?></p>
							<p class="learn-more-button-wrapper"><a class="btn btn-lg hero-button" href="">Learn More</a></p>
						</div>
					</div>
				</div>
<?php
			}
?>
		</div>
		<a class="left carousel-control carousel-control-left-btn" href="#myCarousel" data-slide="prev">
			<span>&lt;</span>
		</a>
		<a class="right carousel-control carousel-control-right-btn" href="#myCarousel" data-slide="next">
			<span>&gt;</span>
		</a>
	</div>
</div>
<!---------------------Banner Section End---------------------->