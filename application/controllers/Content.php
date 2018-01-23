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

		/*This function is used to get the details for the cms content from database
		and show in the front page through ajax call*/
		function get_content()
		{
			if($this->input->post('id'))
			{
				$id = base64_decode(str_replace('_' , '=' , preg_replace_callback('/-[a-z]-/' , function($match){return strtoupper(str_replace('-' , '' , $match[0]));} , $this->input->post('id'))));
				$result = $this->Front_model->commonGetData('cont_content' , 'cont_menuid = '.$id , TABLE_CONTENT_MST , 'cont_menuid' , 'asc' , 1);
				echo $result['cont_content'];
			}
		}

	}
