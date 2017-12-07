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
					<div class="col-lg-<?php echo 12/count($centreDetails['program']); ?>">
						<a style="cursor: pointer;" class="centreProgram" data-ref_id="program_<?php echo $value['program_id']; ?>">
						<img style="margin:0 auto;width: 160px;" class="img-rounded img-responsive1" src="<?php echo ADMIN_PANEL_URL.PROGRAM_COURSE_IMAGE_PATH.$value['program_course_logo']; ?>">
						</a>
					</div>
<?php
				}
			}
?>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!-----------------Choose the program section (END)------------------->


<!-----------------Main Body section (Start)------------------->
<div class="centre-container-wrapper">
	<div class="container text-center">
		<div class="col-lg-12">
			<div class="row">
				<!-------------Left Section Start-------------->
				<div class="col-lg-6 text-left">
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapse-title" aria-expanded="true">
										CENTRE DESCRIPTION
										<i class="fa fa-minus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true">
								<div class="panel-body">
									<?php echo $centreDetails['centre_description']; ?>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed collapse-title" aria-expanded="false">
										MAPS
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
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
						<!----------Dates section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" class="collapsed collapse-title" aria-expanded="false">
										DATES
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseOne2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="panel-body">
									<table class="table table-striped show-date-table">
										<tbody>
											<tr>
												<th style="background-color:#ddd; color:#fff">Arrival Dates</th>
												<th style="background-color:#ddd; color:#fff">Weeks</th>
												<th style="background-color:#ddd; color:#fff">Programmes</th>
												<th style="background-color:#ddd; color:#fff">Overnight</th>
											</tr>
											<tr>
												<td style="background-color:#fff;">20-06-2018 </td>
												<td style="background-color:#fff;">2/3/4 weeks</td>
												<td style="background-color:#fff;">Classic; Classic Premium</td>
												<td style="background-color:#fff;"></td>
											</tr>
											<tr>
												<td style="background-color:#f9f9f9;">27-06-2018 </td>
												<td style="background-color:#f9f9f9;">2/3/4 weeks</td>
												<td style="background-color:#f9f9f9;">Classic; Classic Premium</td>
												<td style="background-color:#f9f9f9;"></td>
											</tr>
											<tr>
												<td style="background-color:#fff;">04-07-2018 </td>
												<td style="background-color:#fff;">2/3/4 weeks</td>
												<td style="background-color:#fff;">Classic; Classic Premium</td>
												<td style="background-color:#fff;"></td>
											</tr>
											<tr>
												<td style="background-color:#f9f9f9;">18-07-2018 </td>
												<td style="background-color:#f9f9f9;">2/3/4 weeks</td>
												<td style="background-color:#f9f9f9;">Classic; Classic Premium</td>
												<td style="background-color:#f9f9f9;"></td>
											</tr>
											<tr>
												<td style="background-color:#fff;">31-07-2018 </td>
												<td style="background-color:#fff;">2 weeks</td>
												<td style="background-color:#fff;">Classic; Classic Premium</td>
												<td style="background-color:#fff;"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!----------Dates section END---------->

						<!----------Accomodation section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo2" class="collapsed collapse-title" aria-expanded="false">
										ACCOMMODATION
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseTwo2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="panel-body">
									<p class="MsoNormal" style="font-weight: normal;">
										Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.
									</p>
									<div style="clear:both;" class="row">
										<div class="col-12">
											<h2 style="padding-left:4px;margin: 0px 4px;" class="negativo">On Campus</h2>
											<div style="padding:4px; background-color:#fafafa">
												<img class="img-responsive inside-box-image" src="http://www.plus-ed.com/apps/images/collegefrontale.jpg">
												<p>Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to  ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment
												where students from around the world live together
												and get to use English as the only true way of global
												communication.
												The residences are supervised by staff who are on hand
												to helps students day and night. Each residential centre
												differs slightly in the room and bathroom type, so please
												take a look at the programme pages in this brochure.
												Residential accommodation is popular with parents who
												are sending younger children or those who want their
												children to experience the tremendous fun of college life<br></p>
											</div>
										</div>
										<div class="col-12">
											<h2 style="padding-left:4px;margin: 0px 4px;" class="negativo">Home Stay</h2>
											<div style="padding:4px; background-color:#fafafa">
												<img class="img-responsive inside-box-image" src="http://www.plus-ed.com/apps/images/casafamiglia.jpg">
												<p>Our hosts have been chosen for their interest in
												welcoming young people from around the world. They are
												picked because of the care and comfort they can offer to
												students who may be travelling overseas for the first time.
												Choosing to stay in home stay is the right option for those
												who want to experience real life living in that country: it
												will give a student the opportunity to use English in a real
												environment and integrate with the family. Home stay is
												often the first choice for slightly older students.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!----------Accomodation section END---------->

						<!----------Course section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseThree2" class="collapsed collapse-title" aria-expanded="false">
										COURSE
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseThree2" class="panel-collapse collapse" aria-expanded="false" style="">
								<div class="panel-body">
									<div style="clear:both;" class="row">
										<div class="col-12">
											<div style="padding:4px; background-color:#fafafa">
												<img class="img-responsive inside-box-image" src="http://www.twenty19.com/blog/wp-content/uploads/2017/06/2015117-18245511-4544-group-study1.jpg">
												<ul style="font-weight: normal;margin-top: 10px;">
													<li>
														<span style="text-indent: -18pt;">- Placement test - written and oral test</span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- 15 hours English lessons per week</span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- Maximum class size 15 students</span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- PLUS end of course certificate </span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!----------Course section END---------->

						<!----------SOCIAL PROGRAMMES AND SPORT section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseFour2" class="collapsed collapse-title" aria-expanded="false">
										SOCIAL PROGRAMMES AND SPORT
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseFour2" class="panel-collapse collapse" aria-expanded="false" style="">
								<div class="panel-body">
									<div style="clear:both;" class="row">
										<div class="col-12">
											<div style="padding:4px; background-color:#fafafa">
												<img class="img-responsive inside-box-image" src="https://studentaffairs.jhu.edu/recreation/wp-content/uploads/sites/24/2017/04/ice-hockey-team.jpg">
												<p style="margin-top: 10px;">Once students are on the campus our PLUS staff will organise the following events: </p>
												<ul style="font-weight: normal;">
													<li>
														<span style="text-indent: -18pt;">- Welcome and Farewell Party </span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- Themed Disco Nights </span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- Karaoke and Talent Shows </span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- Treasure Hunt </span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- Movie Night </span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- Sports: Football, Basketball, Volleyball </span>
													</li>
													<li>
														<span style="text-indent: -18pt;">- Dance Sessions with professional choreographers. </span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!----------SOCIAL PROGRAMMES AND SPORT section END---------->

						<!----------WALKING TOUR section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseFive2" class="collapsed collapse-title" aria-expanded="false">
										WALKING TOUR
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseFive2" class="panel-collapse collapse" aria-expanded="false" style="">
								<div class="panel-body">
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.Many desktop publishing packages and web page editors now use Lorem Ipsum .</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
								</div>
							</div>
						</div>
						<!----------WALKING TOUR section END---------->

						<!----------TRAVEL CARD section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseSix2" class="collapsed collapse-title" aria-expanded="false">
										TRAVEL CARD
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseSix2" class="panel-collapse collapse" aria-expanded="false" style="">
								<div class="panel-body">
									<div class="col-md-12">
										<div class="col-md-3">
											<img class="pull-left img-rounded img-responsive" src="http://plus-ed.com/apps/img/sg_8.jpg" alt="Travelcard" title="Travelcard">
										</div>
										<div class="col-md-9">
											<p>Students are provided with a daily travelcard on their planned visits to London.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!----------TRAVEL CARD section END---------->

						<!----------PLUS TEAM section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseSeven2" class="collapsed collapse-title" aria-expanded="false">
										PLUS TEAM
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseSeven2" class="panel-collapse collapse" aria-expanded="false" style="">
								<div class="panel-body">
									<div class="col-12">
										<div style="padding:4px; background-color:#fafafa">
											<img class="img-responsive inside-box-image" src="https://www.kintecglobal.com/uploads/team-banner-img.jpg">
											<p style="margin-top: 10px;">The members of our team have been carefully selected for their responsible and caring attitude and for being fun-loving and outgoing. They are the people you can turn to at any time for assistance. Our PLUS Team will ensure that students enjoy their holidays in an exciting and safe environment. PLUS promises a wonderful, memorable and enriching summer camp experience. </p>
											<ul style="font-weight: normal;margin-top: 10px;">
												<li>
													<span style="text-indent: -18pt;">- Qualified, experienced choreographers who are skilled to teach a variety of dance sessions.</span>
												</li>
												<li>
													<span style="text-indent: -18pt;">- Sports Leaders who are trained and experienced to a professional level.</span>
												</li>
												<li>
													<span style="text-indent: -18pt;">- Enthusiastic and energetic Activity Leaders who stimulate and entertain students.</span>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!----------PLUS TEAM section END---------->

<?php
						if(!empty($centreDetails['program']))
						{
							foreach($centreDetails['program'] as $value)
							{
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
?>
						<!----------Add ON section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseThirteen2" class="collapsed collapse-title" aria-expanded="false">
										Add ON
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseThirteen2" class="panel-collapse collapse" aria-expanded="false" style="">
								<div class="panel-body">
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.Many desktop publishing packages and web page editors now use Lorem Ipsum .</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
								</div>
							</div>
						</div>
						<!----------Add ON section END---------->

						<!----------Fact Sheet section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseFourteen2" class="collapsed collapse-title" aria-expanded="false">
										Fact Sheet
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseFourteen2" class="panel-collapse collapse" aria-expanded="false" style="">
								<div class="panel-body">
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.Many desktop publishing packages and web page editors now use Lorem Ipsum .</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
								</div>
							</div>
						</div>
						<!----------Fact Sheet section END---------->

						<!----------Activity Programmes section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseFifteen2" class="collapsed collapse-title" aria-expanded="false">
										Activity Programmes
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapseFifteen2" class="panel-collapse collapse" aria-expanded="false" style="">
								<div class="panel-body">
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.Many desktop publishing packages and web page editors now use Lorem Ipsum .</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
								</div>
							</div>
						</div>
						<!----------Activity Programmes section END---------->

						<!----------Menu section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapsesixteen2" class="collapsed collapse-title" aria-expanded="false">
										Menu
										<i class="fa fa-plus pull-right switch-icon"></i>
									</a>
								</h4>
							</div>
							<div id="collapsesixteen2" class="panel-collapse collapse" aria-expanded="false" style="">
								<div class="panel-body">
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.Many desktop publishing packages and web page editors now use Lorem Ipsum .</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
									<div class="col-md-12">
										<div class="col-md-11">
											<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
										</div>
										<div class="col-md-1">
											<a target="_blank" href="/vision_ag/downloads/canterbury_6/01.Canterbury_Factsheet.pdf">
												<i class="fa fa-lg fa-file-pdf-o" style="font-size: 30px;color: red;" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div class="clearfix"></div><hr>
								</div>
							</div>
						</div>
						<!----------Menu section END---------->

						<!----------International Mix section Start---------->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion2" href="#collapseseventeen2" class="collapsed collapse-title" aria-expanded="false">
										International Mix
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
<script>
	function initMap()
	{
		var uluru = {lat : <?php echo $centreDetails['centre_latitude']; ?> , lng : <?php echo $centreDetails['centre_longitude']; ?>};
		var map = new google.maps.Map(document.getElementById('map') , {
			zoom : 17,
			center : uluru
		});
		var marker = new google.maps.Marker({
			position : uluru,
			map : map
		});
		google.maps.event.trigger(map , 'resize');
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&callback=initMap"></script>
<!---------------------Google Map Script (End)-------------------->

<script type="text/javascript">
	$(document).ready(function(){
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
<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/worldHigh.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<!-- <script src="<?php echo base_url(); ?>map/ammap.js"></script>
<script src="<?php echo base_url(); ?>map/worldHigh.js"></script>
<script src="<?php echo base_url(); ?>map/light.js"></script> -->

<script type = "text/javascript">
	var map = AmCharts.makeChart("chartdiv" , {
		"type" : "map",
		"theme" : "light",
		"dataProvider" : {
			"map": "worldHigh",
			"zoomLevel": 3.5,
			"zoomLongitude": 10,
			"zoomLatitude": 52,
			"areas": [ {
				"title": "Austria",
				"id": "AT",
				"color": "#67b7dc",
				"customData": "1995",
				"groupId": "before2004"
			}, {
				"title": "Ireland",
				"id": "IE",
				"color": "#67b7dc",
				"customData": "1973",
				"groupId": "before2004"
			}, {
				"title": "Denmark",
				"id": "DK",
				"color": "#67b7dc",
				"customData": "1973",
				"groupId": "before2004"
			}, {
				"title": "Finland",
				"id": "FI",
				"color": "#67b7dc",
				"customData": "67.92%",
				"groupId": "before2004"
			}, {
				"title": "Sweden",
				"id": "SE",
				"color": "#67b7dc",
				"customData": "1995",
				"groupId": "before2004"
			}, {
				"title": "Great Britain",
				"id": "GB",
				"color": "#67b7dc",
				"customData": "35.5%",
				"groupId": "before2004"
			  }, {
				"title": "Italy",
				"id": "IT",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "France",
				"id": "FR",
				"color": "#67b7dc",
				"customData": "20%",
				"groupId": "before2004"
			}, {
				"title": "Spain",
				"id": "ES",
				"color": "#67b7dc",
				"customData": "1986",
				"groupId": "before2004"
			}, {
				"title": "Greece",
				"id": "GR",
				"color": "#67b7dc",
				"customData": "1981",
				"groupId": "before2004"
			}, {
				"title": "Germany",
				"id": "DE",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "Belgium",
				"id": "BE",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "Luxembourg",
				"id": "LU",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "Netherlands",
				"id": "NL",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "Portugal",
				"id": "PT",
				"color": "#67b7dc",
				"customData": "1986",
				"groupId": "before2004"
			}, {
				"title": "Lithuania",
				"id": "LT",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Latvia",
				"id": "LV",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Czech Republic ",
				"id": "CZ",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Slovakia",
				"id": "SK",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Slovenia",
				"id": "SI",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Estonia",
				"id": "EE",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Hungary",
				"id": "HU",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Cyprus",
				"id": "CY",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Malta",
				"id": "MT",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Poland",
				"id": "PL",
				"color": "#ebdb8b",
				"customData": "13.7%",
				"groupId": "2004"
			}, {
				"title": "Romania",
				"id": "RO",
				"color": "#83c2ba",
				"customData": "4.9%",
				"groupId": "2007"
			}, {
				"title": "Bulgaria",
				"id": "BG",
				"color": "#83c2ba",
				"customData": "2007",
				"groupId": "2007"
			}, {
				"title": "Croatia",
				"id": "HR",
				"color": "#db8383",
				"customData": "2013",
				"groupId": "2013"
			}]
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