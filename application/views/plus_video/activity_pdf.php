<style>
	.left{
		float: left;
		text-align: left;
		display: inline;
		position: absolute;
	}
	.right{
		float: right;
		text-align: center;
		display: inline;
		margin-top: 0;
		position: absolute;
		left: 30%;
	}
	.activityTable{
		position: absolute;
		top: 10%;
		border: 1px solid #311e6b;
		border-collapse: collapse;
	}
	.activityTable th,td{
		border: 1px solid #311e6b;
		padding: 0px;
		width: 85px;
		font-size : 13px;
		font-weight : normal;
		text-align : center;
	}
</style>

<div style="position: relative;">
	<div class="left">
		<img src="<?php echo base_url(); ?>images/logo_plus.png">
	</div>
	<div class="right">
		<span style="font-size: 21px;color: #515169;font-family: cursive;"><?php echo $this->session->userdata('centre'); ?></span><br>
		<span style="font-size: 21px;color: #515169;font-family: cursive;"><?php echo ($this->session->userdata('reportType') == 1) ? $headerInfo['activity_name'] : 'Group Reference : '.$headerInfo['group_reference']; ?></span><br>
		<span style="font-size: 21px;color: #515169;font-family: cursive;"><?php echo $headerInfo['group_name']; ?></span>
	</div>
</div>

<?php
	$subDatesArr = array_chunk($activityDetails['datesArr'] , 7 , TRUE);
	if(!empty($subDatesArr))
	{
		foreach($subDatesArr as $datesValue)
		{
?>
			<table class="activityTable">
				<thead>
					<tr style="background-color: #7e7ebb;">
						<th colspan="2" >Date</th>
<?php
						foreach($datesValue as $id => $value)
							echo '<th>'.date('d-M' , strtotime($value)).'</th>';
?>
					</tr>
					<tr style="background-color: #95A5A6;">
						<th style="width: 45px;">Start</th>
						<th style="width: 45px;">Finish</th>
<?php
						foreach($datesValue as $id => $value)
							echo '<th>'.date('l' , strtotime($value)).'</th>';
?>
					</tr>
				</thead>
				<tbody>
<?php
					if(!empty($activityDetails['details']))
					{
						foreach($activityDetails['details'] as $timeSlot => $details)
						{
							$tempArr = explode('-' , $timeSlot);
?>
							<tr>
								<td style="width: 45px;"><?php echo $tempArr[0]; ?><</td>
								<td style="width: 45px;"><?php echo $tempArr[1]; ?></td>
<?php
								foreach($datesValue as $id => $value)
								{
									$showValue = (isset($details[$id])) ? implode(' / ' , $details[$id]) : '';
									echo '<td>'.$showValue.'</td>';
								}
?>
							</tr>
<?php
						}
					}
?>
				</tbody>
			</table>
			<div style="page-break-after:always;"></div>
<?php
		}
	}
?>