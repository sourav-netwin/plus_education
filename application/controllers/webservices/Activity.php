<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/**
	*This class is used to manage the webservice for the activity
	*
	*@package Activity.php
	*@author : S.D
	*@category Controller
	*Dependency: Activity_model.php
	*Last Modified 05-03-2018
	*/
	class Activity extends REST_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->lang->load('message' , 'english');
			$this->load->model('webservices/Activity_model' , '' , TRUE);

			$apiKey = $this->post('api_key');
			validateApiKey($apiKey);
			$returnArr = array();
		}

		/**
		*This function is used to get the activity details to show in the activity section
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function get_activity_post()
		{
			$centreId = $this->post('centre_id');
			//Check the centre availability
			if($centreId != '')
			{
				$returnArr['status'] = $this->lang->line('SUCCESS');
				$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				$returnArr['activity_details'] = $this->Activity_model->getActivityDetails($centreId);
			}
			else
			{
				$returnArr['status'] = $this->lang->line('FAIL');
				$returnArr['message'] = $this->lang->line('no_centre_selected');
			}
			$this->response($returnArr , 200);
		}

		/**
		*This function is used to get the general information details to show in the general information section
		*
		*@access public
		*@author S.D
		*@since 7th June, 2016
		*@param NONE
		*@return NONE
		*/
		public function get_general_info_post()
		{
			$centreId = $this->post('centre_id');
			//Check the centre availability
			if($centreId != '')
			{
				$returnArr['status'] = $this->lang->line('SUCCESS');
				$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				$returnArr['activity_details'] = $this->Activity_model->getgeneralInfoDetails($centreId);
			}
			else
			{
				$returnArr['status'] = $this->lang->line('FAIL');
				$returnArr['message'] = $this->lang->line('no_centre_selected');
			}
			$this->response($returnArr , 200);
		}
	}
