<?php
	class Dashboard extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('general_lang' , 'english');
			$this->load->model('Front_model' , '' , TRUE);
		}

		//This function is used to show home page
		public function index()
		{
			$data['bannerDetails'] = $this->Front_model->getProgramDetails(1);
			$data['show_banner'] = 1;
			$this->template->view('dashboard' , $data);
		}

		//This function is used to show JUNIOR SUMMER COURSES page
		public function junior_summer_courses()
		{
			$languageId = 1;
			$this->Front_model->getJuniorSummerCourseDetails($languageId);
			$data['show_banner'] = 0;
			$this->template->view('junior_summer_courses' , $data);
		}

		//This function is used to show junior summer course centre template
		public function junior_centre()
		{
			$data['show_banner'] = 0;
			$this->template->view('junior_centre' , $data);
		}
	}
?>