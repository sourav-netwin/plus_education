<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Image_upload
	{
		public function __construct()
		{
			$CI = &get_instance();
			$CI->load->library('upload');
		}

		//Function is used to upload image through codeigniter file upload library
		public function do_upload($uploadPath = NULL , $fieldName = NULL , $max_size = NULL , $max_width = NULL , $max_height = NULL)
		{
			$ext = pathinfo($_FILES[$fieldName]['name'] , PATHINFO_EXTENSION);
			if(!is_dir($uploadPath))
				mkdir($uploadPath , '0777');

			$returnData = array();
			$CI = &get_instance();
			$config['file_name'] = strtotime(date("Y-m-d h:i:s")).'.'.$ext;
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = $max_size;
			$config['max_width'] = $max_width;
			$config['max_height'] = $max_height;

			$CI->upload->initialize($config);
			if(!$CI->upload->do_upload($fieldName))
			{
				$returnData['errorFlag'] = 1;
				$returnData['errorMessage'] = $CI->upload->display_errors();
			}
			else
			{
				$data = $CI->upload->data();
				$returnData['errorFlag'] = 0;
				$returnData['fileName'] = $data['file_name'];
			}

			return $returnData;
		}
	}
?>