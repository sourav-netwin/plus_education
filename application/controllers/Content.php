<?php
	class Content extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Content_model' , '' , TRUE);
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->helper('frontend');
		}

		//This function is used to show CMS dynamic pages
		public function index($pageName = NULL)
		{
			if($pageName != '')
			{
				$data = $this->Content_model->getCmsPageDetailsByName($pageName);
				$data['show_banner'] = 0;
				$data['page_title'] = $data['cont_browser_title'];
				$this->template->view('content' , $data);
			}
		}
	}
