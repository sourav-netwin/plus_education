<?php
	class Program extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('general_lang' , 'english');
			$this->load->helper('backend');
			$this->load->model('Admin_model' , '' , TRUE);
			$this->load->library('image_upload');
			checkAdminLogin();
		}

		//This function is used to show listing page for all programs
		public function index()
		{
			$this->template->admin_view('admin/program_list');
		}

		//This function is used to get all program details from DB and display in datatable
		public function get_program()
		{
			if($this->input->post())
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->Admin_model->getProgramDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_filtered'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}

		//Function is used to update program status through ajax call
		public function update_status()
		{
			if($this->input->post())
			{
				$data = array(
					'program_status' => ($this->input->post('program_status') == 1) ? 0 : 1
				);
				$this->Admin_model->updateProgram($this->input->post('program_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to add program in DB
		public function add()
		{
			$imageError = '';
			if($this->input->post())
			{
				if($_FILES['program_image']['name'] != '')
				{
					$uploadData = $this->image_upload->do_upload('./uploads/program/' , 'program_image' , 500 , 1920 , 550);
					if($uploadData['errorFlag'] == 0)
					{
						$this->Admin_model->addProgram($this->input->post() , $uploadData['fileName']);
						redirect(base_url().'admin/program/index?success=add');
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
			}
			$data['imageError'] = $imageError;
			$this->template->admin_view('admin/program_add' , $data);
		}
	}
?>