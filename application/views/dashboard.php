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
					foreach($courseDetails as $key => $value)
					{
?>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 welcome-w3imgs">
							<figure class="effect-chico">
								<img src="<?php echo ADMIN_PANEL_URL.COURSE_FRONT_IMAGE_PATH.$value['course_front_image']; ?>" />
								<figcaption class="figcaptionWrapperClass">
									<p class="figcaption-title-class-courses">
<?php
										echo $value['course_name'];
										if($value['course_master_id'] == JUNIOR_SUMMER_ID)
											$url = base_url().'junior-summer-courses';
										elseif($value['course_master_id'] == JUNIOR_MINISTAY_ID)
											$url = base_url().'junior-mini-stay';
										elseif($value['course_master_id'] == ADULT_COURSE_ID)
											$url = base_url().'adult-course';
										else
											$url = '';
?>
										<br><a class="btn view-details-btn" href="<?php echo$url; ?>"><?php echo $this->lang->line('view_details'); ?></a>
									</p>
								</figcaption>
							</figure>
						</div>
<?php
						if(($key+1) % 2 == 0)
							echo "<div style='margin-top:30px;' class='col-lg-12 col-md-12'></div>";
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
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1509337714.jpg" alt=" " />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-courses">
								<?php echo $this->lang->line('accomodation'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
						</figcaption>
					</figure>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507207271.jpg" alt=" " />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-courses">
								<?php echo $this->lang->line('activities_on_campus'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
						</figcaption>
					</figure>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507715829.jpg" alt=" " />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-courses">
								<?php echo $this->lang->line('our_team'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
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
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="<?php echo base_url(); ?>images/g3.jpg" alt=" " />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-courses">
								<?php echo $this->lang->line('experience'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
						</figcaption>
					</figure>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="<?php echo base_url(); ?>images/g1.jpg" alt=" " />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-courses">
								<?php echo $this->lang->line('classic_superior'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
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
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 agile-welcome-left">
				<div class="col-sm-6 col-xs-6 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507207212.jpg" alt=" " />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-europe-program">
								<?php echo $this->lang->line('classic'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
						</figcaption>
					</figure>
					<figure class="effect-chico welcome-img2">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507208042.jpg" alt=" " />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-europe-program">
								<?php echo $this->lang->line('premium_academy'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
						</figcaption>
					</figure>
				</div>
				<div class="col-sm-6 col-xs-6 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="<?php echo base_url(); ?>images/g6.jpg" alt=" " />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-europe-program">
								<?php echo $this->lang->line('classic_plus_academy'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
						</figcaption>
					</figure>
					<figure class="effect-chico welcome-img2">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/home-boxes/1507208179.jpg" alt=" " />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-europe-program">
								<?php echo $this->lang->line('premium_weekend'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
						</figcaption>
					</figure>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 agile-welcome-left">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 welcome-w3imgs">
					<figure class="effect-chico welcome-img2 large-image-europe-program">
						<img src="http://www.studytoursinternational.com/apps/images/cdl/promotional/1507886325.jpg" alt=" " class="europe-program-right-box-image" />
						<figcaption class="figcaptionWrapperClass">
							<p class="figcaption-title-class-europe-program-right-box">
								<?php echo $this->lang->line('add_on_package'); ?><br>
								<a class="btn view-details-btn" href=""><?php echo $this->lang->line('view_details'); ?></a>
							</p>
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
