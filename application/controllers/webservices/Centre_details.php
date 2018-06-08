<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/**
	*This class is used to send the centre details to show in the aap
	*
	*@package Centre_details.php
	*@author : S.D
	*@category Controller
	*@since 4th June , 2018
	*/
	class Centre_details extends REST_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->lang->load('message' , 'english');
			$this->load->model('Front_model' , '' , TRUE);

			$apiKey = $this->post('api_key');
			validateApiKey($apiKey);
			$returnArr = array();
		}

		/**
		*This function is used to get the centre details to show in the aap centre details section
		*
		*@author S.D
		*@since 4th June , 2018
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function get_details_post()
		{
			$centreId = $this->post('centreId');
			//Check the centre availability
			if(!empty($centreId))
			{
				$returnArr['status'] = $this->lang->line('SUCCESS');
				$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				$result = $this->Front_model->commonGetData('icon_class , title , details' , 'centre_id = '.$centreId , TABLE_WALKING_TOUR_CENTRE_DETAILS , 'sequence' , 'asc' , 2);
				if(!empty($result))
				{
					foreach($result as $key => $value)
					{
						$returnArr['centreDetails'][$key]['icon_class'] = $value['icon_class'];
						$returnArr['centreDetails'][$key]['title'] = $value['title'];
						$returnArr['centreDetails'][$key]['details'] = str_replace("\t" , '' , $value['details']);
					}
				}
			}
			else
			{
				$returnArr['status'] = $this->lang->line('FAIL');
				$returnArr['message'] = $this->lang->line('no_centre_selected');
			}
			$this->response($returnArr , 200);
		}

		/**
		*This function is used to get the centre details pdf file link to download
		*
		*@author S.D
		*@since 5th June , 2018
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function get_file_link_post()
		{
			$centreId = $this->post('centreId');
			//Check the centre availability
			if(!empty($centreId))
			{
				$data['centreInfo'] = $this->Front_model->getCentreDetails($centreId);
				$fileName = './'.CENTRE_DETAILS_FILE_PATH.strtolower($data['centreInfo']['nome_centri']).'.pdf';

				if(!file_exists($fileName))
				{
					$data['centreDetails'] = $this->Front_model->commonGetData('icon_class , title , details' , 'centre_id = '.$centreId , TABLE_WALKING_TOUR_CENTRE_DETAILS , 'sequence' , 'asc' , 2);
					$viewPageContent = $this->load->view('plus_video/download_centre_details' , $data , TRUE);
					create_pdf($viewPageContent , strtolower($data['centreInfo']['nome_centri']).'.pdf' , FALSE);
				}
				$returnArr['status'] = $this->lang->line('SUCCESS');
				$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				$returnArr['downloadUrl'] = base_url().CENTRE_DETAILS_FILE_PATH.strtolower($data['centreInfo']['nome_centri']).'.pdf';
			}
			else
			{
				$returnArr['status'] = $this->lang->line('FAIL');
				$returnArr['message'] = $this->lang->line('no_centre_selected');
			}
			$this->response($returnArr , 200);
		}
	}
