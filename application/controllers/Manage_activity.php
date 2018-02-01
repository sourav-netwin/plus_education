<?php
	class Manage_activity extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->output->delete_cache();
			$this->lang->load('message' , 'english');
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->helper('frontend');
			$this->load->library('image_upload');
			checkAdminLogin();
			if($this->session->userdata('campusManager') != 1)
			{
				session_destroy();
				redirect('login');
			}
		}

		//This function is used to show the listing page for manage activity
		public function index()
		{
			$data['activityDetails'] = $this->Front_model->getActivityDetails();
			$data['viewPage'] = 'plus_video/manage_activity';
			$data['showLeftMenu'] = 0;
			$this->load->view('plus_video/template' , $data);
		}

		//Function is used to update program status through ajax call
		public function update_status()
		{
			if($this->input->post('activity_id'))
			{
				$data = array(
					'status' => ($this->input->post('status') == 1) ? 0 : 1
				);
				$this->Front_model->commonUpdate(TABLE_PLUS_ACTIVITY_MANAGEMENT , 'plus_activity_id = '.$this->input->post('activity_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to perform both add and edit operation for manage activity module
		function add_edit($id = NULL)
		{
			$imageError = '';
			if($this->input->post('flag'))
			{
				$file_name = $this->input->post('oldImg');
				//For the pdf file
				if($_FILES['file_name']['name'] != '')
				{
					$uploadData = $this->image_upload->do_upload('./'.ACTIVITY_ACCESS_FILE , 'file_name' , '' , '' , '' , 1);
					if($uploadData['errorFlag'] == 0)
					{
						//Delete old file
						if($this->input->post('flag') == 'es' && $file_name != '')
						{
							if(file_exists('./'.ACTIVITY_ACCESS_FILE.$file_name))
								unlink('./'.ACTIVITY_ACCESS_FILE.$file_name);
						}
						$file_name = $uploadData['fileName'];
					}
					else
						$imageError = $uploadData['errorMessage'];
				}

				//Add/update record in database
				if($imageError == '')
				{
					$updateData = array(
						'name' => $this->input->post('name'),
						'centre_id' => $this->input->post('centre_id'),
						'file_name' => $file_name,
						'description' => $this->input->post('description')
					);
					if($this->input->post('flag') == 'as')
					{
						$updateData['added_date'] = date('Y-m-d');
						$this->Front_model->commonAdd(TABLE_PLUS_ACTIVITY_MANAGEMENT , $updateData);
						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Activity' , $this->lang->line('add_success_message')));
					}
					elseif($this->input->post('flag') == 'es')
					{
						$this->Front_model->commonUpdate(TABLE_PLUS_ACTIVITY_MANAGEMENT , 'plus_activity_id = '.$id , $updateData);
						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Activity' , $this->lang->line('edit_success_message')));
					}
					redirect('/manage_activity');
				}
			}
			if($id != '')
			{
				$post = $this->Front_model->commonGetData('plus_activity_id , name , centre_id , file_name , description' , 'plus_activity_id = '.$id , TABLE_PLUS_ACTIVITY_MANAGEMENT , 1);
				$data['post'] = $post;
			}
			$data['id'] = $id;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['imageError'] = $imageError;
			$data['viewPage'] = 'plus_video/manage_activity_add_edit';
			$data['showLeftMenu'] = 0;
			$this->load->view('plus_video/template' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);
			$this->Front_model->commonUpdate(TABLE_PLUS_ACTIVITY_MANAGEMENT , 'plus_activity_id = '.$id , $updateData);
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'Activity' , $this->lang->line('delete_success_message')));
			redirect('/manage_activity');
		}
	}
?>