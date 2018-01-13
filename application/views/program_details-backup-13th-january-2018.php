<div class="welcome welcome-title">
	<div class="container">
		<hr><h2 class="agileits-title about-title">Program Details</h2><hr>
	</div>
</div>

<div class="team">
	<div class="container">
		<div class="w3_agile_team_grids">
			<div class="col-lg-12">
				<div class="col-lg-6">
<?php
					if(!empty($programDetails))
					{
						foreach($programDetails as $key => $value)
						{
?>
							<div class="col-md-12 w3_agile_team_grid">
								<div class="hover14 column" style="border-top: 1px solid #ccc;border-left: 1px solid #ccc;border-right: 1px solid #ccc;">
									<figure style="text-align: center;">
										<img style="display: inline;width:146px;" src="<?php echo $value['logo']; ?>" class="img-responsive12" />
									</figure>
								</div>
								<div class="vc_row boxSectionClass">
									<div class="vc_custom_heading">
										<div class="col-lg-11 col-md-11" style="margin-top: 4px;">
											<h3 class="vc_custom_heading_text"><?php echo ucwords(strtolower(str_replace('_' , ' ' , $value['name']))); ?></h3>
										</div>
										<div class="col-lg-1 col-md-1">
											<i class="fa fa-lg fa-chevron-circle-down showDetails" aria-hidden="true" data-ref_id="<?php echo strtolower(str_replace(array(' ' , '_') , array('-' , '-') , $value['name'])); ?>"></i>
										</div>
									</div>
									<span class="box-detail-text" id="<?php echo strtolower(str_replace(array(' ' , '_') , array('-' , '-') , $value['name'])); ?>" style="display: none;">
										<?php echo html_entity_decode($value['description']); ?>
									</span>
								</div>
							</div>
<?php
							if(ceil(count($programDetails)/2) == ($key+1))
								echo '</div><div class="col-lg-6">';
						}
					}
?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var currentUrl = window.location.href.split('#');
		$('.showDetails').each(function(){
			if($(this).attr('data-ref_id') == currentUrl[1])
			{
				$(this).attr('class' , 'fa fa-lg fa-chevron-circle-up showDetails');
				$('#'+$(this).attr('data-ref_id')).css('display' , 'block');
			}
		});

		$('.showDetails').on('click' , function(){
			if($('#'+$(this).data('ref_id')).css('display') == 'none')
			{
				$('#'+$(this).data('ref_id')).css('display' , 'block');
				$(this).attr('class' , 'fa fa-lg fa-chevron-circle-up showDetails');
			}
			else
			{
				$('#'+$(this).data('ref_id')).css('display' , 'none');
				$(this).attr('class' , 'fa fa-lg fa-chevron-circle-down showDetails');
			}
		});
	});
</script>
</script>