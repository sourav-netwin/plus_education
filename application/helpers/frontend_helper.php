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
			$CI = &get_instance();
			if($data['id'] == $CI->config->item('homePageId'))
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
				'id' => 'field_value_'.$data['manage_application_form_id'],
				'class' => 'form-control'
			);
			if($data['field_type'] == 'date')
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
				'id' => 'field_value_'.$data['manage_application_form_id'],
				'class' => 'form-control',
				'rows' => 2
			);
			$fieldStr.= form_textarea($fieldProperities);
		}
		elseif($data['field_type'] == 'radio')
		{
			$arr = explode(',' , $data['multiple_value']);
			foreach($arr as $value)
				$fieldStr.= '<input style="margin-left: 20px;" type="radio" name="field_value_'.$data['manage_application_form_id'].'" id="field_value_'.$data['manage_application_form_id'].'" value="'.$value.'">'.$value;
			$fieldStr.= '<div class="radioErrorMsg"></div>';
		}
		elseif($data['field_type'] == 'dropdown')
		{
			$requiredFlag = ($data['required_flag'] == 1) ? 'required' : '';
			$requiredFlag = '';
			$arr = explode(',' , $data['multiple_value']);
			$fieldStr.= form_dropdown('field_value_'.$data['manage_application_form_id'] , $arr , '' , 'id="field_value_'.$data['manage_application_form_id'].'" class="form-control"');
		}
		return $fieldStr;
	}

	//This function is used to get the details of centre to show in the plus video login page dropdown
	function getCentreDropdownForPlusVideo($centreId = NULL)
	{
		$data[''] = 'Please select centre';
		$CI = &get_instance();
		$CI->db->select('id , nome_centri');
		$CI->db->join(TABLE_CENTRE , 'id = centre');
		if($centreId != '')
			$CI->db->where('id' , $centreId);
		$CI->db->order_by('nome_centri' , 'asc');
		$result = $CI->db->get(TABLE_PLUS_VIDEO)->result_array();
		if(!empty($result))
		{
			foreach($result as $value)
				$data[$value['id']] = $value['nome_centri'];
		}
		return $data;
	}

	//Function is used to create the name of the thumb image
	if(!function_exists('getThumbnailName'))
	{
		function getThumbnailName($thumbnailImage = NULL)
		{
			if(!empty($thumbnailImage))
			{
				$thumbnailImage = pathinfo($thumbnailImage);
				if(COUNT($thumbnailImage)){
					$extn = $thumbnailImage['extension'];
					$filename = $thumbnailImage['filename'];
					$thumbnailImage = $filename."_thumb.".$extn;
				}
			}
			return $thumbnailImage;
		}
	}

	function showSessionMessageIfAny($CI)
	{
		$success_message = $CI->session->flashdata('success_message');
		$error_message = $CI->session->flashdata('error_message');
		if(!empty($success_message))
		{
?>
			<div class="session-message">
				<div class="alert alert-success alert-dismissable text-center">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $success_message ?>
				</div>
			</div>
<?php
		}
		if(!empty($error_message))
		{
?>
			<div class="session-message">
				<div class="alert alert-danger alert-dismissable text-center">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $error_message ?>
				</div>
			</div>
<?php
		}
	}

	//This function is used to get the url for the cms pages using id(for home page campus life section)
	function getUrlCampusLife($id = NULL , $type = 'url')
	{
		if($id)
		{
			$CI = &get_instance();
			if($type == 'url')
			{
				$result = $CI->db->select('cont_url_name')
								->where('cont_menuid' , $id)
								->get(TABLE_CONTENT_MST)->row_array();
				return base_url().'content/'.$result['cont_url_name'];
			}
			elseif($type == 'name')
			{
				$result = $CI->db->select('mnu_menu_name')
								->where('mnu_menuid' , $id)
								->get(TABLE_MENU_MST)->row_array();
				return $result['mnu_menu_name'];
			}
		}
	}

	//This function is used to get the all file details from DB and show in the daily activity section
	function showDailyActivityFiles($id = NULL)
	{
		if($id)
		{
			$CI = &get_instance();
			$result = $CI->Front_model->commonGetData('plus_activity_file_id , file_name' , 'plus_activity_id = '.$id , TABLE_PLUS_ACTIVITY_MANAGEMENT_FILES , '' , 'asc' , 2);
			$returnArr = array();
			if(!empty($result))
			{
				foreach($result as $value)
				{
					if(strtolower(pathinfo($value['file_name'] , PATHINFO_EXTENSION)) == 'jpg'
					||strtolower(pathinfo($value['file_name'] , PATHINFO_EXTENSION)) == 'jpeg'
					||strtolower(pathinfo($value['file_name'] , PATHINFO_EXTENSION)) == 'png'
					)
						$className = 'fa fa-image';
					elseif(strtolower(pathinfo($value['file_name'] , PATHINFO_EXTENSION)) == 'doc'
					||strtolower(pathinfo($value['file_name'] , PATHINFO_EXTENSION)) == 'docx'
					)
						$className = 'fa fa-file-text-o';
					elseif(strtolower(pathinfo($value['file_name'] , PATHINFO_EXTENSION)) == 'xls'
					||strtolower(pathinfo($value['file_name'] , PATHINFO_EXTENSION)) == 'xlsx'
					)
						$className = 'fa fa-file-excel-o';
					elseif(strtolower(pathinfo($value['file_name'] , PATHINFO_EXTENSION)) == 'pdf')
						$className = 'fa fa-file-pdf-o';
					$returnArr[] = array(
						'id' => $value['plus_activity_file_id'],
						'className' => $className
					);
				}
			}
			return $returnArr;
		}
	}

	//This function is used to check whether any slug is for extra menu or not(in junior centre/junior mini stay module)
	function checkExtraMenuSlug($slugName = NULL)
	{
		$CI = &get_instance();
		$result = $CI->db->select('extra_section_id')
						->where('slug' , $slugName)
						->get(TABLE_PLUS_EXTRA_SECTION)->row_array();
		return (!empty($result)) ? TRUE : FALSE;
	}

	//This function is used to get the extra menu details to show in the centre details page
	function getExtraMenuDetails($slugName = NULL , $centreId = NULL , $type = NULL)
	{
		$CI = &get_instance();
		return $CI->db->select('b.description , b.file_name')
						->from(TABLE_PLUS_EXTRA_SECTION.' a')
						->join(TABLE_PLUS_EXTRA_SECTION_CONTENT.' b' , 'a.extra_section_id = b.extra_section_id' , 'left')
						->where('a.slug' , $slugName)
						->where('a.course_id' , $type)
						->where('b.centre_id' , $centreId)
						->get()->result_array();
	}

	//This function is used to get the cms page content with the help of ids(To show the download instruction)
	function getCmsContentById($id = NULL)
	{
		if($id)
		{
			$CI = &get_instance();
			$result = $CI->db->select('cont_content')
							->where('cont_menuid' , $id)
							->get(TABLE_CONTENT_MST)->row_array();
			if(!empty($result))
				return str_replace(TINYMCE_CURRENT_CONFIG_PATH , ADMIN_PANEL_URL.TINYMCE_IMAGE_PATH , $result['cont_content']);
		}
	}

	//This function is used to get the details for the adult course to show in the header
	function getAdultCourses()
	{
		$CI = &get_instance();
		return $CI->db->select('title , slug')
					->where('status' , 1)
					->where('delete_flag' , 0)
					->get(TABLE_PLUS_MANAGE_ADULT_COURSE)->result_array();
	}
?>