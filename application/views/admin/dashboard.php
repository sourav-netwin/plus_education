<!---------------Main dashboard Body section Start--------------->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Dashboard</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
<?php
						if($this->input->get('success') == 'my_profile')
						{
?>
							<span class="successMessage">Your Profile is successfully updated .</span>
<?php
						}
?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!---------------Main dashboard Body section End--------------->