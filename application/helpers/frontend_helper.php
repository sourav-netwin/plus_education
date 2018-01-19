<?php
	/*Function is used to check whether any user is logged in to the system or not . If any user
	will not login to the system then it will redirect to the login page*/
	function checkAdminLogin()
	{
		$CI = &get_instance();
		if($CI->session->userdata('logged_in'))
			return TRUE;
		else
			redirect(base_url().'login');
	}

	//This function is used to generate random string of provided length
	function rand_string($length = NULL)
	{
		$chars = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		return substr(str_shuffle($chars) , 0 , $length);
	}

	//Function is used to check if there is any unwanted character is present or not
	function xssExpressionMatch($aCheckData = NULL)
	{
		foreach($aCheckData as $sData)
		{
			if(preg_match("/[()+<,>\"\'%&;]/i", $sData))
				return false;
		}
		return true;
	}

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
				$url = 'javascript:void(0);';
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
		$CI = &get_instance();
		$CI->lang->load('message' , 'english');
		$fieldStr = '';
		$fieldStr.= '<input type="hidden" name="idArr[]" value="'.$data['manage_application_form_id'].'" >';
		$fieldStr.= '<input type="hidden" name="field_name_'.$data['manage_application_form_id'].'" value="'.$data['label_name'].'" >';
		if($data['field_type'] == 'text'
			|| $data['field_type'] == 'date'
			|| $data['field_type'] == 'name'
			|| $data['field_type'] == 'mobile'
			|| $data['field_type'] == 'email')
		{
			$fieldProperities = array(
				'name' => 'field_value_'.$data['manage_application_form_id'],
				'class' => 'form-control'
			);
			if($data['required_flag'] == 1)
				$fieldProperities['required'] = 'required';

			if($data['field_type'] == 'name')
			{
				$fieldProperities['pattern'] = '[A-Za-z.\s]*';
				$fieldProperities['title'] = $CI->lang->line('name_validation_message');
			}
			elseif($data['field_type'] == 'mobile')
			{
				$fieldProperities['pattern'] = '[+]?[0-9]{10,20}';
				$fieldProperities['title'] = $CI->lang->line('mobile_number_validation_message');
			}
			elseif($data['field_type'] == 'email')
			{
				$fieldProperities['pattern'] = '[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-za-z]{2,}';
				$fieldProperities['title'] = $CI->lang->line('email_validation_message');
			}
			elseif($data['field_type'] == 'date')
			{
				$fieldProperities['placeholder'] = 'dd/mm/yyyy';
				$fieldProperities['class'] = 'form-control datepicker';
			}

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

	//This function is used to get the details of centre to show in the plus video login page dropdown
	function getCentreDropdownForPlusVideo()
	{
		$data[''] = 'Please select centre';
		$CI = &get_instance();
		$result = $CI->db->select('id , nome_centri')
						->join(TABLE_CENTRE , 'id = centre')
						->order_by('nome_centri' , 'asc')
						->get(TABLE_PLUS_VIDEO)->result_array();
		if(!empty($result))
		{
			foreach($result as $value)
				$data[$value['id']] = $value['nome_centri'];
		}
		return $data;
	}
?>