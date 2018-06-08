<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/**
	*This class is used to get the walking tour web service
	*
	*@category Controller
	*@author S.D
	*Last modified : 7th May , 2018
	*/
	class Walking_tour extends REST_Controller
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
		*This function is used to get the plus walking tour details
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function get_video_post()
		{
			$centreId = $this->post('centre_id');
			//Check the centre availability
			if($centreId != '')
			{
				$data['status'] = $this->lang->line('SUCCESS');
				$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				$data['video_details'] = $this->Front_model->commonGetData("video as video_url , description ,
					concat('".ADMIN_PANEL_URL.WALKING_TOUR_VIDEO_IMAGE_PATH."' , video_image) as
					video_image" , 'centre_id = '.$centreId.' AND status = 1 AND delete_flag = 0' ,
					TABLE_PLUS_WALKING_TOUR , 'plus_walking_tour_id' , 'asc' , 2);
				if(!empty($data['video_details']))
				{
					foreach($data['video_details'] as $key => $value)
						$data['video_details'][$key]['videoName'] = basename($value['video_url']);
				}
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('no_centre_selected');
			}
			$this->response($data , 200);
		}
	}
