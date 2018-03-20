<?php
/*---------------For manage fixed activity module(Start)---------------*/
	$lang['manage_fixed_activity']['dbName'] = TABLE_FIXED_DAY_ACTIVITY;
	$lang['manage_fixed_activity']['key'] = 'fixed_day_activity_id';
	$lang['manage_fixed_activity']['title'] = 'Master Activity';
	$lang['manage_fixed_activity']['list'] = array(
		'centre_id' => array(
			'columnTitle' => 'Centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'columnNo' => 1
		),
		'date' => array(
			'columnTitle' => 'Date',
			'type' => 'date',
			'columnNo' => 2
		)
	);
	$lang['manage_fixed_activity']['list']['actionColumn'] = array(
		'columnNo' => 3,
		'actionType' => array('edit')
	);
/*---------------For manage fixed activity module(End)---------------*/

/*---------------For manage Centre(Start)---------------*/
	$lang['centre']['dbName'] = TABLE_CENTRE;
	$lang['centre']['key'] = 'id';
	$lang['centre']['dropdown'] = array(
		'key' => 'id',
		'value' => 'nome_centri'
	);
/*---------------For manage Centre(End)---------------*/
?>