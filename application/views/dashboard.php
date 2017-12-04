<!---------------------- COURSES Section Start ---------------------->
<div class="services-bottom">
	<div class="container">
		<div class="agileits-heading">
			<h3 class="agileits-title"><?php echo $this->lang->line('courses'); ?></h3>
		</div>

		<div class="welcome-agileinfo">
			<div class="col-md-12 agile-welcome-left">
<?php
				if(!empty($courseDetails))
				{
					foreach($courseDetails as $value)
					{
?>
						<div class="col-sm-6 col-xs-6 welcome-w3imgs">
							<figure class="effect-chico">
								<img src="<?php echo base_url().COURSE_FRONT_IMAGE_PATH.$value['course_front_image']; ?>" />
								<figcaption>
									<p class="figcaption-title-class-courses"><?php echo $value['course_name']; ?></p>
									<p><a class="btn view-details-btn" href="<?php echo base_url(); ?>dashboard/junior_summer_courses/<?php echo $value['course_master_id']; ?>"><?php echo $this->lang->line('view_details'); ?></a></p>
								</figcaption>
							</figure>
						</div>
<?php
					}
				}
?>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!---------------------- COURSES Section END ---------------------->


<!---------------------- Campus Life Section Start ---------------------->
<div class="services-bottom">
	<div class="container">
		<div class="agileits-heading">
			<h3 class="agileits-title"><?php echo $this->lang->line('campus_life'); ?></h3>
		</div>
		<div class="welcome-agileinfo">
			<div class="col-md-12 agile-welcome-left">
				<div class="col-sm-4 col-xs-4 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1509337714.jpg" alt=" " />
						<figcaption>
							<p class="figcaption-title-class-campus"><?php echo $this->lang->line('accomodation'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
				</div>
				<div class="col-sm-4 col-xs-4 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507207271.jpg" alt=" " />
						<figcaption>
							<p class="figcaption-title-class-campus"><?php echo $this->lang->line('activities_on_campus'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
				</div>
				<div class="col-sm-4 col-xs-4 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507715829.jpg" alt=" " />
						<figcaption>
							<p class="figcaption-title-class-campus"><?php echo $this->lang->line('our_team'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!---------------------- Campus Life Section END ---------------------->


<!---------------------- USA Programmes Section Start ---------------------->
<div class="services-bottom">
	<div class="container">
		<div class="agileits-heading">
			<h3 class="agileits-title"><?php echo $this->lang->line('usa_programmes'); ?></h3>
		</div>

		<div class="welcome-agileinfo">
			<div class="col-md-12 agile-welcome-left">
				<div class="col-sm-6 col-xs-6 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="<?php echo base_url(); ?>images/g3.jpg" alt=" " />
						<figcaption>
							<p class="figcaption-title-class-courses"><?php echo $this->lang->line('experience'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
				</div>
				<div class="col-sm-6 col-xs-6 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="<?php echo base_url(); ?>images/g1.jpg" alt=" " />
						<figcaption>
							<p class="figcaption-title-class-courses"><?php echo $this->lang->line('classic_superior'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!---------------------- USA Programmes Section END ---------------------->


<!---------------------- Europe Programmes Section Start ---------------------->
<div class="welcome">
	<div class="container">
		<h3 class="agileits-title"><?php echo $this->lang->line('europe_programmes'); ?></h3>
		<div class="welcome-agileinfo">
			<div class="col-md-8 agile-welcome-left">
				<div class="col-sm-6 col-xs-6 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507207212.jpg" alt=" " />
						<figcaption>
							<p class="figcaption-title-class-europe-program"><?php echo $this->lang->line('classic'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
					<figure class="effect-chico welcome-img2">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507208042.jpg" alt=" " />
						<figcaption>
							<p class="figcaption-title-class-europe-program"><?php echo $this->lang->line('premium_academy'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
				</div>
				<div class="col-sm-6 col-xs-6 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="<?php echo base_url(); ?>images/g6.jpg" alt=" " />
						<figcaption>
							<p class="figcaption-title-class-europe-program"><?php echo $this->lang->line('classic_plus_academy'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
					<figure class="effect-chico welcome-img2">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507208179.jpg" alt=" " />
						<figcaption>
							<p class="figcaption-title-class-europe-program"><?php echo $this->lang->line('premium_weekend'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="col-md-4 agile-welcome-left">
				<div class="welcome-w3imgs">
					<figure class="effect-chico welcome-img2 large-image-europe-program" style="width: 96%;">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/promotional/1507886325.jpg" alt=" " class="europe-program-right-box-image" />
						<figcaption>
							<p class="figcaption-title-class-europe-program-right-box"><?php echo $this->lang->line('add_on_package'); ?></p>
							<p><a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a></p>
						</figcaption>
					</figure>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!---------------------- Europe Programmes Section END ---------------------->
