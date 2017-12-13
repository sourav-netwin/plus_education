<?php
	//This function is used to get top header details from admin panel CMS section
	function getTopheaderMenu()
	{
		$CI = &get_instance();
		$CI->load->model('Content_model' , '' , TRUE);
		return $CI->Content_model->getTopheaderMenu();
	}
?>