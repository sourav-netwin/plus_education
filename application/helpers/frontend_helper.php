<?php
	//This function is used to get top header details from admin panel CMS section
	function getTopheaderMenu()
	{
		$CI = &get_instance();
		$CI->load->model('Content_model' , '' , TRUE);
		return $CI->Content_model->getTopheaderMenu();
	}

	//This function  is used to get the proper url for all the top menu section
	function getUrlForTopHeader($data = array())
	{
		if(!empty($data))
		{
			if($data['name'] == 'Home')
				$url = base_url();
			elseif($data['type'] == 3)
				$url = $data['external_url'];
			elseif($data['type'] == 2)
				$url = ADMIN_PANEL_URL.CAMPUS_CONTENT_PDF_FILE.$data['pdf'];
			elseif($data['type'] == 1 && $data['url'] != '')
				$url = base_url().'content/'.$data['url'];
			else
				$url = '';
			return $url;
		}
	}

	//This function is used to get the details of the header menu to show in the frontend header section
	function getHeaderMenu()
	{
		$CI = &get_instance();
		$CI->load->model('Content_model' , '' , TRUE);
		return $CI->Content_model->getHeaderMenuDetails();
	}
?>