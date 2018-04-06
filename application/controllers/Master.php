<?php
	class Master extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('message' , 'english');
			$this->lang->load('master' , 'english');
			$this->load->helper('language');
			$this->load->model('Mastermodel' , '' , TRUE);
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->helper('frontend');
			checkAdminLogin();
			if($this->session->userdata('campusManager') != 1)
			{
				session_destroy();
				redirect('login');
			}
		}

		//This function is used to show the listing page
		public function index($moduleName = NULL)
		{
			$data['moduleName'] = $moduleName;
			$data['moduleArr'] = $this->Mastermodel->getModule($moduleName);
			$data['viewPage'] = 'plus_video/list';
			$data['showLeftMenu'] = 0;
			$this->load->view('plus_video/template' , $data);
		}

		//This function is used to get details from database and show in the datatable
		public function datatable()
		{
			if($this->input->post('draw'))
			{
				$responseArr = array();
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');

				//Get the details customized data
				$programData = $this->Mastermodel->getDatatable($this->input->post('moduleName') , $this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir']);

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_all'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}
	}
?>