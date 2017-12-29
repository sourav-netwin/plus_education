<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Plus Educational Developments</title>
	</head>
	<body style="margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">
		<div style="width:100%;max-width:800px;margin:0 auto;position:relative;display:block;" id="warpper">
			<div style="width:100%;margin:0 ;float:left;" id="warpper_in">
				<div class="top_header" style="background-color: #587691;padding: 10px 0 10px 10px;width:98%;max-width:800px;height:100%;float:left;">
					<img style="width:135px;float:left;height:auto;" src="<?php echo base_url(); ?>images/email_logo.png" alt=""/>
				</div>
				<div style="width:94%;float:left;padding:3%;" class="mid_content">
					<p>Dear Admin,</p>
			 		<p>Please find the following application form details.</p>
					<div class="vc_row" style="border: 1px solid #ccc;">
						<div style="font-size: 16px !important;font-family: 'FrutigerLTPro-Roman' !important;font-weight: 500 !important;color: #666666;text-align: center;" class="vc_custom_heading">
							<h3 class="vc_custom_heading_text">University Enquiry Form</h3>
						</div>
						<span style="display: block;color: #999 !important;font-weight: normal !important;padding-left: 5px;padding-right: 5px;text-transform: none !important;border-top: 1px solid #ccc;padding-top: 5px;">
							<div class="panel-body" style="padding: 15px;">
<?php
								if(!empty($applicationFormdata))
								{
									foreach($applicationFormdata as $value)
									{
?>
										<div class="form-group">
											<label style="font-weight: bold;">
												<?php echo $value['field_name']; ?>
											</label>
											<div class="col-xs-12">
												<span style="display: block;width: 97%;font-family: 'Open Sans', sans-serif;padding: 5px 12px;font-size: 14px;line-height: 1.429;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;">
													<?php echo $value['field_value']; ?>
												</span>
											</div>
										</div><br>
<?php
									}
								}
?>
							</div>
						</span>
					</div>
					<p>The PLUS Team<p>
				</div>
			</div>
		</div>
	</body>
</html>