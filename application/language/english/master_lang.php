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
	$lang['manage_fixed_activity']['listWhere'] = 'centre_id = '.$_SESSION['centre_id'];
	$lang['manage_fixed_activity']['addHide'] = 1;
/*---------------For manage fixed activity module(End)---------------*/

/*---------------For manage Centre(Start)---------------*/
	$lang['centre']['dbName'] = TABLE_CENTRE;
	$lang['centre']['key'] = 'id';
	$lang['centre']['dropdown'] = array(
		'key' => 'id',
		'value' => 'nome_centri'
	);
	$lang['centre']['listWhere'] = '(((attivo = 1) OR (is_mini_stay = 1 AND attivo = 0)) AND id='.$_SESSION['centre_id'].')';
/*---------------For manage Centre(End)---------------*/

/*---------------For manage student group module(Start)---------------*/
	$lang['manage_student_group']['dbName'] = TABLE_STUDENT_GROUP;
	$lang['manage_student_group']['key'] = 'student_group_id';
	$lang['manage_student_group']['dropdown'] = array(
		'key' => 'student_group_id',
		'value' => 'group_name'
	);
/*---------------For manage student group module(End)---------------*/

/*---------------For manage activity photo gallery module(Start)---------------*/
	$lang['manage_activity_photogallery']['dbName'] = TABLE_ACTIVITY_PHOTO_GALLERY;
	$lang['manage_activity_photogallery']['key'] = 'activity_photo_gallery_id';
	$lang['manage_activity_photogallery']['title'] = 'Activity Photo Gallery';
	$lang['manage_activity_photogallery']['list'] = array(
		'image_name' => array(
			'columnTitle' => 'Image',
			'type' => 'image',
			'uploadPath' => ACTIVITY_PHOTOGALLERY_IMAGE_PATH,
			'columnNo' => 1,
			'thumbHeight' => ACTIVITY_PHOTOGALLERY_IMAGE_THUMB_HEIGHT,
			'thumbWidth' => ACTIVITY_PHOTOGALLERY_IMAGE_THUMB_WIDTH
		),
		'centre_id' => array(
			'columnTitle' => 'Centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'columnNo' => 2
		),
		'added_date' => array(
			'columnTitle' => 'Added date',
			'type' => 'datetime',
			'columnNo' => 3
		)
	);
	$lang['manage_activity_photogallery']['list']['actionColumn'] = array(
		'columnNo' => 4,
		'actionType' => array('edit' , 'delete' , 'status')
	);
	$lang['manage_activity_photogallery']['listWhere'] = 'delete_flag = 0';
	$lang['manage_activity_photogallery']['statusField'] = 'status';
	$lang['manage_activity_photogallery']['field'] = array(
		'centre_id' => array(
			'fieldLabel' => 'Select centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'validation' => 'required'
		),
		'image_name' => array(
			'fieldLabel' => 'Upload image',
			'type' => 'file',
			'fileType' => 'image',
			'validation' => 'imageRequired|checkImageExt|checkImageWidth',
			'uploadPath' => ACTIVITY_PHOTOGALLERY_IMAGE_PATH,
			'width' => ACTIVITY_PHOTOGALLERY_IMAGE_WIDTH,
			'height' => ACTIVITY_PHOTOGALLERY_IMAGE_HEIGHT,
			'thumbHeight' => ACTIVITY_PHOTOGALLERY_IMAGE_THUMB_HEIGHT,
			'thumbWidth' => ACTIVITY_PHOTOGALLERY_IMAGE_THUMB_WIDTH
		)
	);
	$lang['manage_activity_photogallery']['addedDateField'] = 'added_date';
	$lang['manage_activity_photogallery']['listWhere'] = 'centre_id = '.$_SESSION['centre_id'];
/*---------------For manage activity photo gallery module(End)---------------*/
?>