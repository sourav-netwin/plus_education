<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/*
	*Author : S.D
	*Purpose : Contact us details
	*Date : 25-04-2018
	*Dependency: Content_model.php
	*/
	class Contact_us extends REST_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->config->load('cms_static_id');
			$this->load->model('Content_model' , '' , TRUE);
			$this->lang->load('message' , 'english');

			$apiKey = $this->post('api_key');
			validateApiKey($apiKey);
			$returnArr = array();
		}

		/**
		*This function is used to get the contact us page details
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function get_page_post()
		{
			$data = $this->Content_model->getCmsPageDetailsByName($this->config->item('contactUsSlug'));
			$returnArr['status'] = $this->lang->line('SUCCESS');
			$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			$returnArr['content'] = $data['cont_content'];
			$this->response($returnArr , 200);
		}
	}

