<?php
/*---------------For manage fixed activity module(Start)---------------*/
	$lang['manage_fixed_activity']['dbName'] = TABLE_MASTER_ACTIVITY;
	$lang['manage_fixed_activity']['key'] = 'master_activity_id';
	$lang['manage_fixed_activity']['title'] = 'Master Activity';
	$lang['manage_fixed_activity']['list'] = array(
		'centre_id' => array(
			'columnTitle' => 'Centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'columnNo' => 1
		),
		'student_group' => array(
			'columnTitle' => 'Student\'s group',
			'type' => 'dropdown',
			'module' => 'manage_student_group',
			'columnNo' => 2
		),
		'activity_name' => array(
			'columnTitle' => 'Activity name',
			'type' => 'text',
			'columnNo' => 3
		),
		'arrival_date' => array(
			'columnTitle' => 'Arrival date',
			'type' => 'date',
			'columnNo' => 4
		),
		'departure_date' => array(
			'columnTitle' => 'Departure date',
			'type' => 'date',
			'columnNo' => 5
		)
	);
	$lang['manage_fixed_activity']['list']['actionColumn'] = array(
		'columnNo' => 6,
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

/*---------------For manage student group module(Start)---------------*/
	$lang['manage_student_group']['dbName'] = TABLE_STUDENT_GROUP;
	$lang['manage_student_group']['key'] = 'student_group_id';
	$lang['manage_student_group']['dropdown'] = array(
		'key' => 'student_group_id',
		'value' => 'group_name'
	);
/*---------------For manage student group module(End)---------------*/
?>