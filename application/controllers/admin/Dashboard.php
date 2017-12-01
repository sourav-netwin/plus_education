<?php
	class Dashboard extends CI_Controller
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

		//This function is used to show dashboard
		public function index()
		{
			$data['page_title'] = 'Dashboard';
			$this->template->admin_view('admin/dashboard' , $data);
		}

		//This function is used to show profile information of the user
		function my_profile()
		{
			$imageError = '';
			if($this->session->userdata('user_id') != '')
			{
				if($this->input->post())
				{
					$post['userName'] = $this->input->post('userName');
					$post['userEmail'] = $this->input->post('userEmail');
					$post['userId'] = $this->input->post('userId');
					$post['userImage'] = $this->input->post('oldImg');

					$this->form_validation->set_error_delimiters('<div class="error">' , '</div>');
					$this->form_validation->set_rules('userName' , 'Name' , 'required|max_length[100]');
					$this->form_validation->set_rules('userEmail' , 'Email' , 'required|max_length[50]');
					$this->form_validation->set_rules('userId' , 'User Id' , 'required|max_length[50]');
					if($this->form_validation->run() === TRUE)
					{
						if($this->input->post('imageChangeFlag') == 2)
						{
							$uploadData = $this->image_upload->do_upload('./'.MY_PROFILE_IMAGE_PATH , 'userImage' , UPLOAD_IMAGE_SIZE , MY_PROFILE_WIDTH , MY_PROFILE_HEIGHT);
							if($uploadData['errorFlag'] == 0)
							{
								//Delete old file
								if(file_exists('./'.MY_PROFILE_IMAGE_PATH.$post['userImage']))
									unlink('./'.MY_PROFILE_IMAGE_PATH.$post['userImage']);
								if(file_exists('./'.MY_PROFILE_IMAGE_PATH.getThumbnailName($post['userImage'])))
									unlink('./'.MY_PROFILE_IMAGE_PATH.getThumbnailName($post['userImage']));

								$post['userImage'] = $uploadData['fileName'];
								$this->session->set_userdata('user_image' , $post['userImage']);
							}
							else
								$imageError = $uploadData['errorMessage'];
						}
						if($imageError == '')
						{
							$this->Admin_model->updateUserData($this->session->userdata('user_id') , $post);
							if($this->input->post('imageChangeFlag') == 2)
								$this->_handleCropping($post['userImage']);
							redirect(base_url().'admin/dashboard/index?success=my_profile');
						}
					}
				}
				else
					$post = $this->Admin_model->getUserData($this->session->userdata('user_id'));
				$data['post'] = $post;
				$data['imageError'] = $imageError;
				$data['page_title'] = 'My Profile';
				$this->template->admin_view('admin/my_profile' , $data);
			}
			else
				redirect(base_url().'admin/dashboard/index');
		}

		/****************Image Cropping functionality Start******************/
		public function _handleCropping($fileName = NULL)
		{
			$this->cropInit($fileName);
			$this->cropping->image();
			exit();
		}

		public function process($action = NULL)
		{
			$this->cropInit();
			$this->cropping->process($action);
		}

		public function cropInit($file_name = NULL)
		{
			$param = array();
			if(empty($file_name))
				$param = $this->session->userdata("cropData");
			else
			{
				$param = array(
					'imageAbsPath' => FCPATH . MY_PROFILE_IMAGE_PATH,
					'imageDestPath' => FCPATH . MY_PROFILE_IMAGE_PATH,
					'imageName' => $file_name,
					'imageNewName' => $file_name,
					'imagePath' => base_url() . MY_PROFILE_IMAGE_PATH,
					'imageWidth' => MY_PROFILE_WIDTH,
					'imageHeight' => MY_PROFILE_HEIGHT,
					'thumbWidth' => MY_PROFILE_THUMB_WIDTH,
					'thumbHeight' => MY_PROFILE_THUMB_HEIGHT,
					'redirectTo' => 'admin/dashboard/index?success=my_profile',
					'formCallbackAction' => 'admin/dashboard/process'
				);
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/******************Image Cropping functionality End*********************/
	}
?>