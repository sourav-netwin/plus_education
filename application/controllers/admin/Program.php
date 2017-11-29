<?php
	class Program extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('general_lang' , 'english');
			$this->lang->load('message_lang' , 'english');
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
					$uploadData = $this->image_upload->do_upload('./uploads/program/' , 'program_image' , 6000 , 1920 , 500);
					if($uploadData['errorFlag'] == 0)
					{
						$this->Admin_model->addProgram($this->input->post() , $uploadData['fileName']);
						$this->_handleCropping($uploadData['fileName'] , 'add');
						redirect(base_url().'admin/program/index?success=add');
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
			}
			$data['imageError'] = $imageError;
			$this->template->admin_view('admin/program_add' , $data);
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
					$uploadData = $this->image_upload->do_upload('./uploads/program/' , 'program_image' , 500 , 1920 , 550);

					if($uploadData['errorFlag'] == 0)
					{
						//Delete old file
						if(file_exists('./uploads/program/'.$file_name))
							unlink('./uploads/program/'.$file_name);
						$file_name = $uploadData['fileName'];
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
				if($imageError == '')
				{
					$this->Admin_model->updateProgramData($id , $this->input->post() , $file_name);
					redirect(base_url().'admin/program/index?success=edit');
				}
			}

			$post = $this->Admin_model->getEditProgramData($id , 1);
			$data['post'] = $post;
			$data['imageError'] = $imageError;
			$this->template->admin_view('admin/program_edit' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$this->Admin_model->deleteProgram($id);
			redirect(base_url().'admin/program/index?success=delete');
		}




























/*---------------------------Image Cropping functionality Start-------------------------*/

		// function test(){
			// $file_name = "my-test.jpg";
			// $this->_handleCropping($file_name);
		// }

		public function _handleCropping($fileName = NULL , $flag = NULL)
		{
			// $oldImage = $this->input->post("oldImage");
			// if(!empty($oldImage))
			// {
				// @unlink(PROGRAM_IMAGE_PATH . $oldImage);
				// // Note: getThumbnailName defined this in helper to get
				// // thumnail image eg. sample.jpg to sample_thumb.jpg
				// $thumbnailImage = getThumbnailName($oldImage);
				// if(!empty($thumbnailImage))
					// @unlink(PROGRAM_IMAGE_PATH . $thumbnailImage);
			// }
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
					'imageAbsPath' => FCPATH . PROGRAM_IMAGE_PATH,
					'imageDestPath' => FCPATH . PROGRAM_IMAGE_PATH,
					'imageName' => $file_name,
					'imageNewName' => $file_name,
					'imagePath' => base_url() . PROGRAM_IMAGE_PATH,
					'imageWidth' => PROGRAM_WIDTH,
					'imageHeight' => PROGRAM_HEIGHT,
					'thumbWidth' => PROGRAM_THUMB_WIDTH,
					'thumbHeight' => PROGRAM_THUMB_HEIGHT,
					'redirectTo' => 'admin/program',
					'formCallbackAction' => 'admin/program/process?success='.$flag
				);
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}

/*---------------------------Image Cropping functionality End-------------------------*/

	}
?>