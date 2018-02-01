<script src="<?php echo base_url(); ?>js/admin/jquery.cookie.js"></script>
<!---------------------- COURSES Section Start ---------------------->
<div class="services-bottom">
	<div class="container">
		<div class="agileits-heading">
			<h3 class="agileits-title"><?php echo $this->lang->line('courses'); ?></h3>
		</div>

		<div class="welcome-agileinfo">
			<div class="col-md-12 agile-welcome-left" style="padding-right: 0;">
<?php
				if(!empty($courseDetails))
				{
					foreach($courseDetails as $key => $value)
					{
?>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 welcome-w3imgs">
							<figure class="effect-chico">
								<img src="<?php echo ADMIN_PANEL_URL.COURSE_FRONT_IMAGE_PATH.$value['course_front_image']; ?>" />
								<span class="show-destination-class" style="display: block;">
									<span class="figcaptionWrapperClass">
										<p class="figcaption-title-class-courses"><?php echo $value['course_name']; ?></p>
									</span>
								</span>
								<figcaption>
									<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
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
									</p></div>
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
			<div class="col-md-12 agile-welcome-left" style="padding-right: 0;">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="<?php echo ADMIN_PANEL_URL.CAMPUS_LIFE_IMAGE_PATH; ?>1509337714.jpg" />
						<span class="show-destination-class" style="display: block;">
							<span class="figcaptionWrapperClass">
								<p class="figcaption-title-class-courses"><?php echo $this->lang->line('accomodation'); ?></p>
							</span>
						</span>
						<figcaption>
							<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
								<?php echo $this->lang->line('accomodation'); ?><br>
								<a class="btn view-details-btn" data-title="<?php echo $this->lang->line('accomodation'); ?>" href="<?php echo getUrlCampusLife($this->config->item('homeAccomodationCmsId')); ?>"><?php echo $this->lang->line('view_details'); ?></a>
							</p></div>
						</figcaption>
					</figure>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="<?php echo ADMIN_PANEL_URL.CAMPUS_LIFE_IMAGE_PATH; ?>1507207271.jpg" />
						<span class="show-destination-class" style="display: block;">
							<span class="figcaptionWrapperClass">
								<p class="figcaption-title-class-courses"><?php echo $this->lang->line('activities_on_campus'); ?></p>
							</span>
						</span>
						<figcaption>
							<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
								<?php echo $this->lang->line('activities_on_campus'); ?><br>
								<a class="btn view-details-btn" data-title="<?php echo $this->lang->line('activities_on_campus'); ?>" href="<?php echo getUrlCampusLife($this->config->item('homeActivityCmsId')); ?>"><?php echo $this->lang->line('view_details'); ?></a>
							</p></div>
						</figcaption>
					</figure>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 welcome-w3imgs">
					<figure class="effect-chico">
						<img src="<?php echo ADMIN_PANEL_URL.CAMPUS_LIFE_IMAGE_PATH; ?>1507715829.jpg" />
						<span class="show-destination-class" style="display: block;">
							<span class="figcaptionWrapperClass">
								<p class="figcaption-title-class-courses"><?php echo $this->lang->line('our_team'); ?></p>
							</span>
						</span>
						<figcaption>
							<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
								<?php echo $this->lang->line('our_team'); ?><br>
								<a class="btn view-details-btn" data-title="<?php echo $this->lang->line('our_team'); ?>" href="<?php echo getUrlCampusLife($this->config->item('homeOurTeamCmsId')); ?>"><?php echo $this->lang->line('view_details'); ?></a>
							</p></div>
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
			<div class="col-md-12 agile-welcome-left" style="padding-right: 0;">
<?php
				if(!empty($usaProgram))
				{
					foreach($usaProgram as $value)
					{
?>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 welcome-w3imgs">
							<figure class="effect-chico">
								<img src="<?php echo ADMIN_PANEL_URL.PROGRAM_FRONT_IMAGE_PATH.$value['image']; ?>" />
								<span class="show-destination-class" style="display: block;">
									<span class="figcaptionWrapperClass">
										<p class="figcaption-title-class-courses"><?php echo $value['name']; ?></p>
									</span>
								</span>
								<figcaption>
									<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
										<?php echo $value['name']; ?><br>
										<a target="_blank" class="btn view-details-btn" href="<?php echo base_url().'program#'.strtolower(str_replace(array(' ' , '_') , array('-' , '-') , $value['name'])); ?>"><?php echo $this->lang->line('view_details'); ?></a>
									</p></div>
								</figcaption>
							</figure>
						</div>
<?php
					}
				}
?>
				<div class="clearfix"> </div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!---------------------- USA Programmes Section END ---------------------->

<!---------------------- Europe Programmes Section Start ---------------------->
<div class="services-bottom">
	<div class="container">
		<div class="agileits-heading">
			<h3 class="agileits-title"><?php echo $this->lang->line('europe_programmes'); ?></h3>
		</div>
		<div class="welcome-agileinfo">
<?php
			if(!empty($europeProgram))
			{
				foreach($europeProgram as $key => $value)
				{
?>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 welcome-w3imgs">
						<figure class="effect-chico">
							<img src="<?php echo ADMIN_PANEL_URL.PROGRAM_FRONT_IMAGE_PATH.$value['image']; ?>" />
							<span class="show-destination-class" style="display: block;">
								<span class="figcaptionWrapperClass">
									<p class="figcaption-title-class-courses"><?php echo $value['name']; ?></p>
								</span>
							</span>
							<figcaption>
								<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
									<?php echo $value['name']; ?><br>
									<a target="_blank" class="btn view-details-btn" href="<?php echo base_url().'program#'.strtolower(str_replace(array(' ' , '_') , array('-' , '-') , $value['name'])); ?>"><?php echo $this->lang->line('view_details'); ?></a>
								</p></div>
							</figcaption>
						</figure>
					</div>
<?php
					if(($key+1) % 3 == 0)
						echo "<div style='margin-top:30px;' class='col-lg-12 col-md-12'></div>";
				}
			}
?>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 welcome-w3imgs">
				<figure class="effect-chico">
					<img src="<?php echo base_url(); ?>images/addon.jpg" />
					<span class="show-destination-class" style="display: block;">
						<span class="figcaptionWrapperClass">
							<p class="figcaption-title-class-courses"><?php echo $this->lang->line('add_on_package'); ?></p>
						</span>
					</span>
					<figcaption>
						<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">
							<?php echo $this->lang->line('add_on_package'); ?><br>
							<a target="_blank" class="btn view-details-btn" href="<?php echo base_url().'program#add-on'; ?>"><?php echo $this->lang->line('view_details'); ?></a>
						</p></div>
					</figcaption>
				</figure>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!---------------------- Europe Programmes Section End ---------------------->

<script>
	$(document).ready(function(){
		$(document).on('mouseenter' , '.effect-chico' , function(){
			$(this).find('.show-destination-class').css('display' , 'none');
		});
		$(document).on('mouseleave' , '.effect-chico' , function(){
			$(this).find('.show-destination-class').css('display' , 'block');
		});
	});
</script>
