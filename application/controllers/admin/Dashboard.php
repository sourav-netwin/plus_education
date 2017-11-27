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
			$this->template->admin_view('admin/dashboard');
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
							$uploadData = $this->image_upload->do_upload('./uploads/users/' , 'userImage' , 100 , 1024 , 768);
							if($uploadData['errorFlag'] == 0)
							{
								//Delete old file
								if(file_exists('./uploads/users/'.$post['userImage']))
									unlink('./uploads/users/'.$post['userImage']);

								$post['userImage'] = $uploadData['fileName'];
								$this->session->set_userdata('user_image' , $post['userImage']);
							}
							else
								$imageError = $uploadData['errorMessage'];
						}
						if($imageError == '')
						{
							$this->Admin_model->updateUserData($this->session->userdata('user_id') , $post);
							redirect(base_url().'admin/dashboard/index?success=my_profile');
						}
					}
				}
				else
					$post = $this->Admin_model->getUserData($this->session->userdata('user_id'));
				$data['post'] = $post;
				$data['imageError'] = $imageError;
				$this->template->admin_view('admin/my_profile' , $data);
			}
			else
				redirect(base_url().'admin/dashboard/index');
		}
	}
?>