<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Template
	{
		public function view($view_page = NULL , $data = array())
		{
			$CI = &get_instance();
			$data['view_page'] = $view_page;
			$CI->load->view('template' , $data);
		}

		public function admin_view($view_page = NULL , $data = array())
		{
			$CI = &get_instance();
			$data['view_page'] = $view_page;
			$CI->load->view('admin/template' , $data);
		}
	}
?>