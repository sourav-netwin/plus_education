<?php
	class Content extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Content_model' , '' , TRUE);
		}

		public function index($pageName = NULL)
		{
			if($pageName != '')
			{
				$pageContent = $this->Content_model->getCmsPageDetails($pageName);
				echo "<pre>";print_r($pageContent);die('popopo = ');
			}
		}
	}
