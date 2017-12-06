<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Template
	{
		public function __construct()
		{
			$CI = &get_instance();
			$CI->lang->load('general_lang' , 'english');
		}

		//This function is used to load front-end view pages
		public function view($view_page = NULL , $data = array())
		{
			$CI = &get_instance();
			$data['view_page'] = $view_page;
			$data['page_title'] = $data['page_title'].' | '.$CI->lang->line('plus_educational_developments');
			$CI->load->view('template' , $data);
		}
	}
?>