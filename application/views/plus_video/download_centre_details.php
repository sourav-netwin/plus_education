<style>
	.centreHeader{
		text-align: center;
		font-family: "Open Sans", sans-serif;
		font-weight: normal;
		font-size: 20px;
		color: #000000;
	}
	.centreImage{
		width: 100%;
	}
	.hrLine{
		border-bottom: 1px solid #000;
	}
	.titleClass{
		font-weight: bold;
		font-size: 16px;
		font-family: "Open Sans", sans-serif;
		margin-left: 16px;
		color: #000000;
	}

	body a:hover, body a:focus {
		text-decoration: none;
		outline: none;
	}
	body{
		font-family: "Open Sans", sans-serif;
		color: #999999;
	}
	body a {
		text-decoration: none;
		outline: none;
		color: #999999;
	}
</style>

<h4 class="centreHeader"><?php echo $centreInfo['nome_centri']; ?></h4>
<p>
	<?php $imgName = ($centreInfo['centre_banner'] != '') ? ADMIN_PANEL_URL.$centreInfo['path'].$centreInfo['centre_banner'] : base_url().'images/default_centre.jpg'; ?>
	<img class="centreImage" src="<?php echo $imgName; ?>">
</p>
<div class="hrLine"></div><br>

<?php
	if(!empty($centreDetails))
	{
		foreach($centreDetails as $key => $value)
		{
?>
			<p>
				<img style="width: 20px;" src="<?php echo base_url(); ?>images/plus_icon/<?php echo $value['icon_class']; ?>.png" />
				<span class="titleClass"><?php echo $value['title']; ?></span>
			</p>
			<p>
				<?php echo $value['details']; ?>
			</p>
<?php
			if(($key + 1) != count($centreDetails))
				echo "<div class='hrLine'></div><br>";
		}
	}
?>
