<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/*
	*Author : S.D
	*Purpose : CMS page details details
	*Date : 1-06-2018
	*/
	class Cms_page extends REST_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->config->load('cms_static_id');
			$this->lang->load('message' , 'english');

			$apiKey = $this->post('api_key');
			validateApiKey($apiKey);
			$returnArr = array();
		}

		/**
		*This function is used to get the CMS page(contact us / faq / aap intro) details
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function get_page_post()
		{
			$data = array(
				array(
					'pageType' => 'Contact us',
					'pageUrl' => base_url().'content/'.$this->config->item('contactUsSlug').'/1'
				),
				array(
					'pageType' => 'FAQ',
					'pageUrl' => base_url().'content/'.$this->config->item('faqSlug').'/1'
				),
				array(
					'pageType' => 'App Intro',
					'pageUrl' => base_url().'content/'.$this->config->item('aapIntroSlug').'/1'
				)
			);
			$returnArr['pageInfo'] = array_merge($data);
			$returnArr['status'] = $this->lang->line('SUCCESS');
			$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			$this->response($returnArr , 200);
		}
	}

