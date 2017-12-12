<!-------------Load CSS and JS for lightbox------------>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/lightbox.css">
<script src="<?php echo base_url(); ?>js/lightbox-plus-jquery.min.js"> </script>

<!-----------------Media Section Start------------------->
<div class="col-lg-12" id="media">
	<h1 class="destination_heading">MEDIA</h1><hr>
	<ul class="nav nav-pills" style="padding-left: 420px;">
		<li class="active"><a data-toggle="tab" id='refPhotogalleryId' href="#photo">PHOTGALLERY</a></li>
		<li><a data-toggle="tab" id='refVideoId' href="#video">VIDEO</a></li>
	</ul>
	<div class="tab-content" style="margin-left: -15px;margin-right: -15px;">
		<div id="photo" class="tab-pane fade in active">
			<div class="gallery">
				<div class="gallery-grids">
<?php
					if(!empty($centreDetails['photo_gallery']))
					{
						foreach($centreDetails['photo_gallery'] as $value)
						{
?>
							<div class="col-md-4 gallery-grid">
								<div class="grid">
									<figure class="effect-apollo">
										<a class="example-image-link" href="<?php echo ADMIN_PANEL_URL.PHOTO_GALLERY_IMAGE_PATH.$value['photo']; ?>" data-lightbox="example-set" data-title="<?php echo $value['description']; ?>">
											<img src="<?php echo ADMIN_PANEL_URL.PHOTO_GALLERY_IMAGE_PATH.$value['photo']; ?>" />
											<figcaption>
												<p><?php echo $value['short_description']; ?></p>
											</figcaption>
										</a>
									</figure>
								</div>
							</div>
<?php
						}
					}
?>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<div id="video" style="margin-top: 60px;" class="tab-pane fade">
<?php
			if(!empty($centreDetails['video_gallery']))
			{
				foreach($centreDetails['video_gallery'] as $value)
				{
?>
					<div class="col-sm-4 col-xs-4 welcome-w3imgs">
						<figure class="effect-chico">
							<img src="<?php echo ADMIN_PANEL_URL.VIDEO_GALLERY_IMAGE_PATH.$value['video_image']; ?>" alt=" " />
							<figcaption>
								<p class="figcaption-title-class-destination">
									<a data-ref_url = "<?php echo $value['video_url']; ?>" style="color:#fff;margin-top: 10px;cursor: pointer;" class="icon-inner-play no-youtube-popup videoModalClass">
										<i class="fa-2x fa fa-play video-icon-class" aria-hidden="true"></i>
									</a>
								</p>
							</figcaption>
						</figure>
						<p><?php echo $value['description']; ?></p>
					</div>
<?php
				}
			}
?>
		</div>
	</div>
</div>
<!-----------------Media Section End------------------->

<!-------------Video Modal Start------------>
<div class="modal fade" id="myVideoModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body videoModalBodyClass"></div>
		</div>
	</div>
</div>
<!-------------Video Modal END------------>

<script src="<?php echo base_url(); ?>js/modal.js"> </script>
<script src="<?php echo base_url(); ?>js/bootstrap-tab.js"> </script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.videoModalClass').on('click' , function(){
			if($(this).data('ref_url').indexOf('www.youtube.com') != -1)
				var str = '<iframe src="'+$(this).data('ref_url')+'" allowfullscreen="" width="550" height="300" frameborder="0"></iframe>';
			else
				var str = '<video width="550" controls>\
								<source src="'+$(this).data('ref_url')+'">\
							</video>';
			$('.videoModalBodyClass').empty();
			$('.videoModalBodyClass').append(str);
			$("#myVideoModal").modal();
		});

		$(".nav-pills a").click(function(){
			$(this).tab('show');
		});

	});
</script>
