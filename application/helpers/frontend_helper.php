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

	//This function is used to show the form field for application form in adult course
	function showFormField($data = array())
	{
		$fieldStr = '';
		$fieldStr.= '<input type="hidden" name="idArr[]" value="'.$data['manage_application_form_id'].'" >';
		$fieldStr.= '<input type="hidden" name="field_name_'.$data['manage_application_form_id'].'" value="'.$data['label_name'].'" >';
		if($data['field_type'] == 'text' || $data['field_type'] == 'date' || $data['field_type'] == 'email')
		{
			$fieldProperities = array(
				'name' => 'field_value_'.$data['manage_application_form_id'],
				'class' => 'form-control',
				'type' => $data['field_type']
			);
			if($data['required_flag'] == 1)
				$fieldProperities['required'] = 'required';
			$fieldStr.= form_input($fieldProperities);
		}
		elseif($data['field_type'] == 'textarea')
		{
			$fieldProperities = array(
				'name' => 'field_value_'.$data['manage_application_form_id'],
				'class' => 'form-control',
				'rows' => 2
			);
			if($data['required_flag'] == 1)
				$fieldProperities['required'] = 'required';
			$fieldStr.= form_textarea($fieldProperities);
		}
		elseif($data['field_type'] == 'radio')
		{
			$requiredFlag = ($data['required_flag'] == 1) ? 'required' : '';
			$arr = explode(',' , $data['multiple_value']);
			foreach($arr as $value)
				$fieldStr.= '<input style="margin-left: 20px;" type="radio" name="field_value_'.$data['manage_application_form_id'].'" value="'.$value.'" '.$requiredFlag.'>'.$value;
		}
		elseif($data['field_type'] == 'dropdown')
		{
			$requiredFlag = ($data['required_flag'] == 1) ? 'required' : '';
			$arr = explode(',' , $data['multiple_value']);
			$fieldStr.= form_dropdown('field_value_'.$data['manage_application_form_id'] , $arr , '' , 'class="form-control" '.$requiredFlag);
		}
		return $fieldStr;
	}
?>