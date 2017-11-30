<?php
	class Junior_centre extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('message_lang' , 'english');
			$this->load->helper('backend');
			$this->load->model('Admin_model' , '' , TRUE);
			$this->load->library('image_upload');
			checkAdminLogin();
		}

		//This function is used to show listing page for the course
		public function index()
		{
			$this->template->admin_view('admin/junior_centre_list');
		}

		//This function is used to get all course details from DB and display in datatable
		public function get_junior_centre()
		{
			if($this->input->post())
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->Admin_model->getjuniorCentreDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

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
					'junior_centre_status' => ($this->input->post('junior_centre_status') == 1) ? 0 : 1
				);
				$this->Admin_model->updateJuniorCentre($this->input->post('junior_centre_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to add junior centre in DB
		public function add()
		{
			$imageError = '';
			if($this->input->post())
			{
				if($_FILES['centre_banner']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.JUNIOR_CENTRE_IMAGE_PATH , 'centre_banner' , UPLOAD_IMAGE_SIZE , JUNIOR_CENTRE_WIDTH , JUNIOR_CENTRE_HEIGHT);

				if($uploadData['errorFlag'] == 0)
				{
					$this->Admin_model->addJuniorCentre($this->input->post() , $uploadData['fileName']);
					$this->_handleCropping($uploadData['fileName'] , 'add');
					redirect(base_url().'admin/junior_centre/index?success=add');
				}
				else
				{
					$imageError = $uploadData['errorMessage'];
					$imageErrorHome = $uploadDataFront['errorMessage'];
				}
			}
			$data['imageError'] = $imageError;
			$this->template->admin_view('admin/junior_centre_add' , $data);
		}

		//This function is used to show edit page and edit record from DB
		function edit($id = NULL)
		{
			$imageError = '';
			if($this->input->post())
			{
				$file_name = $this->input->post('oldImg');
				if($this->input->post('imageChangeFlag') == 2)
				{
					$uploadData = $this->image_upload->do_upload('./'.JUNIOR_CENTRE_IMAGE_PATH , 'centre_banner' , UPLOAD_IMAGE_SIZE , JUNIOR_CENTRE_WIDTH , JUNIOR_CENTRE_HEIGHT);
					if($uploadData['errorFlag'] == 0)
					{
						//Delete old file
						if(file_exists('./'.JUNIOR_CENTRE_IMAGE_PATH.$file_name))
							unlink('./'.JUNIOR_CENTRE_IMAGE_PATH.$file_name);
						if(file_exists('./'.JUNIOR_CENTRE_IMAGE_PATH.getThumbnailName($file_name)))
							unlink('./'.JUNIOR_CENTRE_IMAGE_PATH.getThumbnailName($file_name));
						$file_name = $uploadData['fileName'];
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
				if($imageError == '')
				{
					$this->Admin_model->updateJuniorCentre($id , $this->input->post() , $file_name , 1);
					if($this->input->post('imageChangeFlag') == 2)
						$this->_handleCropping($file_name , 'edit');
					redirect(base_url().'admin/junior_centre/index?success=edit');
				}
			}

			$post = $this->Admin_model->getEditJuniorCentreData($id);
			$data['post'] = $post;
			$data['imageError'] = $imageError;
			$this->template->admin_view('admin/junior_centre_edit' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);
			$this->Admin_model->updateJuniorCentre($id , $updateData);
			redirect(base_url().'admin/junior_centre/index?success=delete');
		}

		/****************Image Cropping functionality Start******************/
		public function _handleCropping($fileName = NULL , $flag = NULL)
		{
			$this->cropInit($fileName , $flag);
			$this->cropping->image();
			exit();
		}

		public function process($action = NULL)
		{
			$this->cropInit();
			$this->cropping->process($action);
		}

		public function cropInit($file_name = NULL , $flag = NULL)
		{
			$param = array();
			if(empty($file_name))
				$param = $this->session->userdata("cropData");
			else
			{
				$param = array(
					'imageAbsPath' => FCPATH . JUNIOR_CENTRE_IMAGE_PATH,
					'imageDestPath' => FCPATH . JUNIOR_CENTRE_IMAGE_PATH,
					'imageName' => $file_name,
					'imageNewName' => $file_name,
					'imagePath' => base_url() . JUNIOR_CENTRE_IMAGE_PATH,
					'imageWidth' => JUNIOR_CENTRE_WIDTH,
					'imageHeight' => JUNIOR_CENTRE_HEIGHT,
					'thumbWidth' => JUNIOR_CENTRE_THUMB_WIDTH,
					'thumbHeight' => JUNIOR_CENTRE_THUMB_HEIGHT,
					'redirectTo' => 'admin/junior_centre/index?success='.$flag,
					'formCallbackAction' => 'admin/junior_centre/process'
				);
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/******************Image Cropping functionality End*********************/
	}
?>