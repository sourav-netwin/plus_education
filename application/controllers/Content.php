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

		/**
		*This function is used to show CMS dynamic pages / to show the webview
		*
		*@access public
		*@param String $pageName : The page name
		*@param Integer $typeFlag : If 1 : Then show for app webview
		*@return NONE
		*/
		public function index($pageName = NULL , $typeFlag = NULL)
		{
			if($pageName != '')
			{
				$data = $this->Content_model->getCmsPageDetailsByName($pageName);
				$data['show_banner'] = 0;
				$data['page_title'] = (isset($data['cont_browser_title'])) ? $data['cont_browser_title'] : '';
				if($typeFlag == 1)
					$this->load->view('webservice/template' , $data);
				else
					$this->template->view('content' , $data);
			}
		}
	}
