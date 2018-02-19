<!------------------Header image section (Start)------------------->
<div class="w3ls-banner-1" style="background: url(<?php echo ADMIN_PANEL_URL.JUNIOR_CENTRE_IMAGE_PATH.$centreDetails['centre_banner']; ?>)no-repeat center;"></div>
<div style="padding-top: 140px;height: 370px;" class="carousel-caption">
	<h2 class="hero-heading"><span style="background-color: rgba(0, 0, 0, 0.5);padding:10px"><?php echo $centreDetails['centre_name']; ?></span></h2>
	<div class="school-img-inner-icon" style="margin-top: 50px;">
		<a style="color:#fff" class="icon-inner-play icon-inner-camera bannerRefIcon" href="#media" data-ref_id = "refPhotogalleryId">
			<i class="fa-2x fa fa-camera foto-icon-class" aria-hidden="true"></i>
			<label>Foto</label>
		</a>
		<a style="color:#fff" class="icon-inner-play no-youtube-popup bannerRefIcon" href="#media" data-ref_id = "refVideoId">
			<i class="fa-2x fa fa-play video-icon-class" aria-hidden="true"></i>
			<label>Video</label>
		</a>
	</div>
</div>
<!------------------Header image section (END)------------------->


<!-----------------Choose the program section (Start)------------------->
<div class="container-fluid text-center">
	<div style="margin-top:30px;margin-bottom:30px" class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="choose-program-title"><strong>CHOOSE THE PROGRAM</strong></h1>
			</div>
		</div>
		<div style="padding-top:20px" class="row">
<?php
			if(!empty($centreDetails['program']))
			{
				foreach($centreDetails['program'] as $value)
				{
?>
					<div class="col-lg-<?php echo ceil(12/count($centreDetails['program'])); ?>">
						<a style="cursor: pointer;" class="centreProgram" data-ref_id="program_<?php echo $value['program_id']; ?>">
						<img style="margin:0 auto;width: 200px;" class="img-rounded img-responsive1" src="<?php echo ADMIN_PANEL_URL.PROGRAM_COURSE_IMAGE_PATH.$value['program_course_logo']; ?>">
						</a>
					</div>
<?php
				}
				if(array_key_exists('addon' , $centreDetails['program']))
					unset($centreDetails['program']['addon']);
			}
?>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!-----------------Choose the program section (END)------------------->


<!-----------------Main Body section (Start)------------------->
<div class="centre-container-wrapper" style="padding-left: 0;padding-right: 0;">
	<div class="container text-center" style="padding-left: 0;padding-right: 0;">
		<div class="col-lg-12">
			<div class="row">
				<!-------------Left Section Start-------------->
				<div class="col-lg-6 text-left">
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapse-title" aria-expanded="false">
										CENTRE DESCRIPTION
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="panel-body">
									<?php echo $centreDetails['centre_description']; ?>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed collapse-title" aria-expanded="true">
										MAPS
										<i class="fa fa-minus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse in" aria-expanded="true">
								<div class="panel-body">
									<div id="map" style="width: 100%;height: 350px;"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-------------Left Section End-------------->

				<!-------------Right Section Start-------------->
				<div class="col-lg-6 text-left">
					<div class="panel-group" id="accordion2">
<?php
						if(!empty($sequenceSetting))
						{
							foreach($sequenceSetting as $sequenceValue)
							{
								if($sequenceValue['slug'] == $this->config->item('dates'))
								{
?>
									<!----------Dates section Start---------->
<?php
									if(!empty($centreDetails['dates']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapseOne2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
												<div class="panel-body" style="overflow-x: scroll;">
													<table class="table table-striped show-date-table">
														<tbody>
															<tr>
																<th style="background-color:#ddd; color:#fff">Arrival Dates</th>
																<th style="background-color:#ddd; color:#fff">Weeks</th>
																<th style="background-color:#ddd; color:#fff">Programmes</th>
																<th style="background-color:#ddd; color:#fff">Overnight</th>
															</tr>
<?php
															foreach($centreDetails['dates'] as $value)
															{
?>
																<tr>
																	<td style="background-color:#fff;"><?php echo date('d-m-Y' , strtotime($value['date'])); ?></td>
																	<td style="background-color:#fff;"><?php echo str_replace(',' , '/' , $value['week']).' weeks'; ?></td>
																	<td style="background-color:#fff;"><?php echo str_replace(',' , ' ; ' , $value['program']); ?></td>
																	<td style="background-color:#fff;"><?php echo $value['overnight']; ?></td>
																</tr>
<?php
															}
?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------Dates section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('accommodation'))
								{
?>
									<!----------Accomodation section Start---------->
<?php
									if(!empty($centreDetails['accomodation']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapseTwo2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
												<div class="panel-body">
													<?php echo str_replace(TINYMCE_CURRENT_CONFIG_PATH , ADMIN_PANEL_URL.TINYMCE_IMAGE_PATH , $centreDetails['accomodation']['details']); ?>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------Accomodation section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('social_program_sport'))
								{
?>
									<!----------SOCIAL PROGRAMMES AND SPORT section Start---------->
<?php
									if(!empty($centreDetails['social_program_sports']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapseFour2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapseFour2" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
													<div style="clear:both;" class="row">
														<div class="col-12">
															<div style="padding:4px; background-color:#fafafa">
																<?php echo $centreDetails['social_program_sports']['details']; ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------SOCIAL PROGRAMMES AND SPORT section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('course'))
								{
?>
									<!----------Course section Start---------->
<?php
									if(!empty($centreDetails['course']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapseThree2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapseThree2" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
													<?php echo str_replace(TINYMCE_CURRENT_CONFIG_PATH , ADMIN_PANEL_URL.TINYMCE_IMAGE_PATH , $centreDetails['course']['details']); ?>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------Course section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('walking_tour'))
								{
?>
									<!----------WALKING TOUR section Start---------->
<?php
									if(!empty($centreDetails['walking_tour']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapseFive2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapseFive2" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
<?php
													foreach($centreDetails['walking_tour'] as $value)
													{
?>
														<div class="col-md-12">
															<div class="col-md-11">
																<p><?php echo $value['file_description']; ?></p>
															</div>
															<div class="col-md-1">
																<a target="_blank" href="<?php echo ADMIN_PANEL_URL.WALKING_TOUR_FILE_PATH.$value['file_name']; ?>">
																	<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
																</a>
															</div>
														</div>
														<div class="clearfix"></div><hr>
<?php
													}
?>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------WALKING TOUR section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('travel_card'))
								{
?>
									<!----------TRAVEL CARD section Start---------->
<?php
									if(!empty($centreDetails['travel_card']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapseSix2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapseSix2" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
													<?php echo $centreDetails['travel_card']['details']; ?>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------TRAVEL CARD section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('plus_team'))
								{
?>
									<!----------PLUS TEAM section Start---------->
<?php
									if(!empty($centreDetails['plus_team']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapseSeven2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapseSeven2" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
													<?php echo str_replace(TINYMCE_CURRENT_CONFIG_PATH , ADMIN_PANEL_URL.TINYMCE_IMAGE_PATH , $centreDetails['plus_team']['details']); ?>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------PLUS TEAM section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('add_on'))
								{
?>
									<!----------Add ON section Start---------->
<?php
									if(!empty($centreDetails['addon']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#program_addon" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="program_addon" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
<?php
													foreach($centreDetails['addon'] as $value)
													{
?>
														<div class="col-md-12">
															<div class="col-md-11">
																<p><?php echo $value['file_description']; ?></p>
															</div>
															<div class="col-md-1">
																<a target="_blank" href="<?php echo ADMIN_PANEL_URL.ADD_ON_FILE_PATH.$value['file_name']; ?>">
																	<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
																</a>
															</div>
														</div>
														<div class="clearfix"></div><hr>
<?php
													}
?>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------Add ON section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('fact_sheet'))
								{
?>
									<!----------Fact Sheet section Start---------->
<?php
									if(!empty($centreDetails['factsheet']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapseFourteen2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapseFourteen2" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
<?php
													foreach($centreDetails['factsheet'] as $value)
													{
?>
														<div class="col-md-12">
															<div class="col-md-11">
																<p><?php echo $value['file_description']; ?></p>
															</div>
															<div class="col-md-1">
																<a target="_blank" href="<?php echo ADMIN_PANEL_URL.FACTSHEET_FILE_PATH.$value['file_name']; ?>">
																	<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
																</a>
															</div>
														</div>
														<div class="clearfix"></div><hr>
<?php
													}
?>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------Fact Sheet section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('activity_program'))
								{
?>
									<!----------Activity Programmes section Start---------->
<?php
									if(!empty($centreDetails['activity_program']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapseFifteen2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapseFifteen2" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
<?php
													foreach($centreDetails['activity_program'] as $value)
													{
?>
														<div class="col-md-12">
															<div class="col-md-11">
																<p><?php echo $value['file_description']; ?></p>
															</div>
															<div class="col-md-1">
																<a target="_blank" href="<?php echo ADMIN_PANEL_URL.ACTIVITY_PROGRAM_FILE_PATH.$value['file_name']; ?>">
																	<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
																</a>
															</div>
														</div>
														<div class="clearfix"></div><hr>
<?php
													}
?>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------Activity Programmes section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('menu'))
								{
?>
									<!----------Menu section Start---------->
<?php
									if(!empty($centreDetails['menu']))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#collapsesixteen2" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="collapsesixteen2" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
<?php
													foreach($centreDetails['menu'] as $value)
													{
?>
														<div class="col-md-12">
															<div class="col-md-11">
																<p><?php echo $value['file_description']; ?></p>
															</div>
															<div class="col-md-1">
																<a target="_blank" href="<?php echo ADMIN_PANEL_URL.MENU_FILE_PATH.$value['file_name']; ?>">
																	<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
																</a>
															</div>
														</div>
														<div class="clearfix"></div><hr>
<?php
													}
?>
												</div>
											</div>
										</div>
<?php
									}
?>
									<!----------Menu section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('international_mix'))
								{
?>
									<!----------International Mix section Start---------->
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion2" href="#collapseseventeen2" class="collapsed collapse-title" aria-expanded="false">
													<?php echo $sequenceValue['name']; ?>
													<i class="fa fa-plus pull-right switch-icon"></i>
												</a>
											</h4>
										</div>
										<div id="collapseseventeen2" class="panel-collapse collapse" aria-expanded="false" style="">
											<div class="panel-body">
												<div id="chartdiv"></div>
											</div>
										</div>
									</div>
									<!----------International Mix section END---------->
<?php
								}
								elseif($sequenceValue['slug'] == $this->config->item('classic'))
								{
									if(array_key_exists($this->config->item('classic') , $centreDetails['program']))
									{
										$value = $centreDetails['program'][$this->config->item('classic')];
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#program_<?php echo $value['program_id']; ?>" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $value['program_course_name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="program_<?php echo $value['program_id']; ?>" class="panel-collapse collapse" aria-expanded="false">
												<div class="panel-body">
													<?php echo $value['program_course_description']; ?>
												</div>
											</div>
										</div>
<?php
									}
								}
								elseif($sequenceValue['slug'] == $this->config->item('classic_premium'))
								{
									if(array_key_exists($this->config->item('classic_premium') , $centreDetails['program']))
									{
										$value = $centreDetails['program'][$this->config->item('classic_premium')];
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#program_<?php echo $value['program_id']; ?>" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $value['program_course_name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="program_<?php echo $value['program_id']; ?>" class="panel-collapse collapse" aria-expanded="false">
												<div class="panel-body">
													<?php echo $value['program_course_description']; ?>
												</div>
											</div>
										</div>
<?php
									}
								}
								elseif($sequenceValue['slug'] == $this->config->item('classic_plus_academy'))
								{
									if(array_key_exists($this->config->item('classic_plus_academy') , $centreDetails['program']))
									{
										$value = $centreDetails['program'][$this->config->item('classic_plus_academy')];
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#program_<?php echo $value['program_id']; ?>" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $value['program_course_name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="program_<?php echo $value['program_id']; ?>" class="panel-collapse collapse" aria-expanded="false">
												<div class="panel-body">
													<?php echo $value['program_course_description']; ?>
												</div>
											</div>
										</div>
<?php
									}
								}
								elseif($sequenceValue['slug'] == $this->config->item('classic_premium_plus_academy'))
								{
									if(array_key_exists($this->config->item('classic_premium_plus_academy') , $centreDetails['program']))
									{
										$value = $centreDetails['program'][$this->config->item('classic_premium_plus_academy')];
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#program_<?php echo $value['program_id']; ?>" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $value['program_course_name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="program_<?php echo $value['program_id']; ?>" class="panel-collapse collapse" aria-expanded="false">
												<div class="panel-body">
													<?php echo $value['program_course_description']; ?>
												</div>
											</div>
										</div>
<?php
									}
								}
								elseif($sequenceValue['slug'] == $this->config->item('experience'))
								{
									if(array_key_exists($this->config->item('experience') , $centreDetails['program']))
									{
										$value = $centreDetails['program'][$this->config->item('experience')];
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#program_<?php echo $value['program_id']; ?>" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $value['program_course_name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="program_<?php echo $value['program_id']; ?>" class="panel-collapse collapse" aria-expanded="false">
												<div class="panel-body">
													<?php echo $value['program_course_description']; ?>
												</div>
											</div>
										</div>
<?php
									}
								}
								elseif($sequenceValue['slug'] == $this->config->item('classic_superior'))
								{
									if(array_key_exists($this->config->item('classic_superior') , $centreDetails['program']))
									{
										$value = $centreDetails['program'][$this->config->item('classic_superior')];
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#program_<?php echo $value['program_id']; ?>" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $value['program_course_name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="program_<?php echo $value['program_id']; ?>" class="panel-collapse collapse" aria-expanded="false">
												<div class="panel-body">
													<?php echo $value['program_course_description']; ?>
												</div>
											</div>
										</div>
<?php
									}
								}
								elseif($sequenceValue['slug'] == $this->config->item('classic_premium_plus_weekend_away'))
								{
									if(array_key_exists($this->config->item('classic_premium_plus_weekend_away') , $centreDetails['program']))
									{
										$value = $centreDetails['program'][$this->config->item('classic_premium_plus_weekend_away')];
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#program_<?php echo $value['program_id']; ?>" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $value['program_course_name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="program_<?php echo $value['program_id']; ?>" class="panel-collapse collapse" aria-expanded="false">
												<div class="panel-body">
													<?php echo $value['program_course_description']; ?>
												</div>
											</div>
										</div>
<?php
									}
								}
								/*---------------For extra menus Start--------------*/
								elseif(checkExtraMenuSlug($sequenceValue['slug']))
								{
									$extraMenuDetails = getExtraMenuDetails($sequenceValue['slug'] , $centreDetails['junior_centre_id'] , 1);
									if(!empty($extraMenuDetails))
									{
?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $sequenceValue['slug']; ?>" class="collapsed collapse-title" aria-expanded="false">
														<?php echo $sequenceValue['name']; ?>
														<i class="fa fa-plus pull-right switch-icon"></i>
													</a>
												</h4>
											</div>
											<div id="<?php echo $sequenceValue['slug']; ?>" class="panel-collapse collapse" aria-expanded="false" style="">
												<div class="panel-body">
<?php
													foreach($extraMenuDetails as $value)
													{
?>
														<div class="col-md-12">
															<div class="col-md-11">
																<p><?php echo $value['description']; ?></p>
															</div>
															<div class="col-md-1">
																<a target="_blank" href="<?php echo ADMIN_PANEL_URL.EXTRA_SECTION_FILE_PATH.$value['file_name']; ?>">
																	<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
																</a>
															</div>
														</div>
														<div class="clearfix"></div><hr>
<?php
													}
?>
												</div>
											</div>
										</div>
<?php
									}
								}
								/*---------------For extra menus End--------------*/
							}
						}
?>
					</div>
				</div>
				<!-------------Right Section END-------------->
			</div>
		</div>
		<div class="clearfix"></div>

		<!------------------Load Media Section------------------->
		<?php $this->load->view('media'); ?>

	</div>
</div>
<!-----------------Main Body section (END)------------------->


<!---------------------Google Map Script (Start)------------------->
<?php
	$centreDetails['city'] = '';
	if(($pos = strpos($centreDetails['address'] , "#")) !== FALSE)
	{
		$centreDetails['city'] = substr($centreDetails['address'] , $pos+1);
		$centreDetails['address'] = substr($centreDetails['address'] , 0 , $pos);
	}
?>
<input type="hidden" id="actualAddress" name="actualAddress" value="<?php echo $centreDetails['school_name'] ?>, <?php echo $centreDetails['address'] ?>, <?php echo $centreDetails['city'] ?> <?php echo $centreDetails['post_code'] ?>">

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&sensor=false"></script>
<script>
	var geocoder;
	var map;

	function initialize()
	{
		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(-34.397, 150.644);
		var mapOptions = {
			zoom : 17,
			center : latlng,
			mapTypeId : google.maps.MapTypeId.HYBRID
		}
		map = new google.maps.Map(document.getElementById("map"), mapOptions);
	}

	function codeAddress()
	{
		var address = document.getElementById('actualAddress').value;
		geocoder.geocode( { 'address': address}, function(results, status) {
			if(status == google.maps.GeocoderStatus.OK)
			{
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location
				});
			}
			else
				alert('Geocode was not successful for the following reason: ' + status);
		});
	}
</script>
<!---------------------Google Map Script (End)-------------------->

<script type="text/javascript">
	$(document).ready(function(){
		//Call Google map functions
		initialize();
		codeAddress();

		$(document).on('click' , '.bannerRefIcon' , function(){
			$('#'+$(this).data('ref_id')).tab('show');
		});

		$('.switch-icon').on('click' , function(){
			$($(this).parent().data('parent')).find('.switch-icon').attr('class' , 'fa fa-plus pull-right switch-icon');
			if($(this).parent().attr('aria-expanded') == 'true')
				$(this).attr('class' , 'fa fa-plus pull-right switch-icon');
			else
				$(this).attr('class' , 'fa fa-minus pull-right switch-icon');
		});

		$('.centreProgram').click(function(){
			//Make all the open section closed first
			$('#accordion2').find('.switch-icon').attr('class' , 'fa fa-plus pull-right switch-icon');
			$('#accordion2').find('.collapse-title').attr('class' , 'collapse-title collapsed').attr('aria-expanded' , 'false');
			$('#accordion2').find('.panel-collapse').attr('class' , 'panel-collapse collapse').attr('aria-expanded' , 'false').attr('style' , 'height: 0px');

			$('#'+$(this).data('ref_id')).parent().find('.switch-icon').attr('class' , 'fa fa-minus pull-right switch-icon');
			$('#'+$(this).data('ref_id')).parent().find('.switch-icon').parent().attr('aria-expanded' , 'true');
			$('#'+$(this).data('ref_id')).attr('class' , 'panel-collapse collapse in');
			$('#'+$(this).data('ref_id')).attr('aria-expanded' , 'true');
			$('#'+$(this).data('ref_id')).removeAttr('style');
			 $('html,body').animate({
				scrollTop : ($('#'+$(this).data('ref_id')).offset().top)-40
			} , 600);
		});
	});
</script>

<!------------------------------Map JS Section Start-------------------------->
<script src="<?php echo base_url(); ?>js/map/ammap.js"></script>
<script src="<?php echo base_url(); ?>js/map/worldHigh.js"></script>
<script src="<?php echo base_url(); ?>js/map/light.js"></script>

<script type = "text/javascript">
	var map = AmCharts.makeChart("chartdiv" , {
		"type" : "map",
		"theme" : "light",
		"dataProvider" : {
			"map": "worldHigh",
			"zoomLevel": 3.5,
			"zoomLongitude": 10,
			"zoomLatitude": 52,
			"areas": [
<?php
				if(!empty($centreDetails['international_mix']))
				{
					foreach($centreDetails['international_mix'] as $value)
					{
						$arr = explode('-' , $value['country_name']);
?>
						{
							"title": "<?php echo $arr[0]; ?>",
							"id": "<?php echo $arr[1]; ?>",
							"color": "<?php echo $value['color_code']; ?>",
							"customData": "<?php echo $value['percentage']; ?>"
						},
<?php
					}
				}
?>
			]
		},
		"areasSettings": {
			"rollOverOutlineColor": "#FFFFFF",
			"rollOverColor": "#CC0000",
			"alpha": 0.8,
			"unlistedAreasAlpha": 0.1,
			"balloonText": "[[title]] [[customData]]"
		},
		"legend": {
			"width": "100%",
			"marginRight": 27,
			"marginLeft": 27,
			"equalWidths": false,
			"backgroundAlpha": 0.5,
			"backgroundColor": "#FFFFFF",
			"borderColor": "#ffffff",
			"borderAlpha": 1,
			"top": 450,
			"left": 0,
			"horizontalGap": 10
		},
		"export": {
			"enabled": false
		}
	});
</script>
<!------------------------------Map JS Section END-------------------------->