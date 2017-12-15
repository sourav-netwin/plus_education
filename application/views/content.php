<?php
	if($cont_meta_description != '')
		echo '<meta name="description" content="'.$cont_meta_description.'">';
	if($cont_keywords)
		echo '<meta name="keywords" content="'.$cont_keywords.'">';
?>
<div class="container">
	<h1 class="cmsPageTitle"><?php echo $cont_page_title; ?></h1>
	<div class="welcome-agileinfo">
		<div class="col-md-12 agile-welcome-left">
<?php
			if($cont_content)
				echo $cont_content;
?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>