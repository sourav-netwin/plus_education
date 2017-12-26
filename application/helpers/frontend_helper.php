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
		$headerMenu = $CI->Content_model->getJuniorSummerHeaderMenuDetails();
		$headerMenu['juniorMiniStay'] = $CI->Content_model->getMiniStayHeaderMenuDetails();
		return $headerMenu;
	}

	//This function is used to get the deatails of footer section from CMS admin panel
	function getFooterDetails()
	{
		$CI = &get_instance();
		$CI->load->model('Content_model' , '' , TRUE);
		$CI->config->load('cms_static_id');
		$data['footerDetails'] = $CI->Content_model->getFooterDetails();
		$data['address'] = $CI->Content_model->getCmsPageDetailsById($CI->config->item('footerAddressId'));
		return $data;
	}

	//This function is used to set the target for anchor tag(if there is any pdf file then open in new tab)
	function getTarget($data = array())
	{
		if(!empty($data))
			return ($data['type'] == 2) ? 'target=_blank' : '';
	}

	//This function is used to get the program details for the junior mini stay courses
	function getMiniStayProgramdetails($id = NULL)
	{
		$CI = &get_instance();
		return $CI->db->select('program_name , logo')
						->where('junior_ministay_static_program_id' , $id)
						->get(TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM)->row_array();
	}
?>