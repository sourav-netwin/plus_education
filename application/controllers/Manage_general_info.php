<?php
	class Manage_general_info extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			$this->lang->load('message' , 'english');
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->model('Manage_general_info_model' , '' , TRUE);
			$this->load->helper('frontend');
			$this->load->library('image_upload');
			checkAdminLogin();
			if($this->session->userdata('campusManager') != 1)
			{
				session_destroy();
				redirect('login');
			}
		}

		/**
		*This function is used to show the listing page for general info
		*
		*@author S.D
		*@since 7th June , 2018
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function index()
		{
			$data['activityDetails'] = $this->Manage_general_info_model->getActivityDetails();
			$data['viewPage'] = 'plus_video/manage_general_info';
			$data['showLeftMenu'] = 0;
			$this->load->view('plus_video/template' , $data);
		}

		/**
		*Function is used to update general info status through ajax call
		*
		*@author S.D
		*@since 7th June , 2018
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function update_status()
		{
			if($this->input->post('general_info_id'))
			{
				$data = array(
					'status' => ($this->input->post('status') == 1) ? 0 : 1
				);
				$this->Front_model->commonUpdate(TABLE_GENERAL_INFO , 'plus_general_info_id = '.$this->input->post('general_info_id') , $data);
				echo TRUE;
			}
		}

		/**
		*This function is used to perform both add and edit operation for manage general info module
		*
		*@author S.D
		*@since 7th June , 2018
		*@access public
		*@param Integer $id : THis i sthe id
		*@return NONE
		*/
		public function add_edit($id = NULL)
		{
			if($this->input->post('flag'))
			{
				$file_name = array();
				//Upload New files(for add multiple files)
				if(!empty($_FILES['file_name']['name']) && $imageError == '')
				{
					$fileArr = $_FILES;
					$notUploadFileArr = ($this->input->post('notUploadFile') != '') ? explode(',' , $this->input->post('notUploadFile')) : array();
					foreach($_FILES['file_name']['name'] as $key => $value)
					{
						if(!(in_array($key , $notUploadFileArr)))
						{
							$_FILES['file_name[]']['name']= $fileArr['file_name']['name'][$key];
							$_FILES['file_name[]']['type']= $fileArr['file_name']['type'][$key];
							$_FILES['file_name[]']['tmp_name']= $fileArr['file_name']['tmp_name'][$key];
							$_FILES['file_name[]']['error']= $fileArr['file_name']['error'][$key];
							$_FILES['file_name[]']['size']= $fileArr['file_name']['size'][$key];
							$uploadData = $this->image_upload->do_upload('./'.GENERAL_INFO_ACCESS_FILE , 'file_name[]' , '' , '' , '' , 2);
							if($uploadData['errorFlag'] == 0)
								$file_name[] = $uploadData['fileName'];
						}
					}
				}

				//Add or update record in main table
				$updateData = array(
					'name' => $this->input->post('name'),
					'centre_id' => $this->input->post('centre_id'),
					'description' => $this->input->post('description'),
					'front_image' => $this->input->post('front_image'),
					'show_type' => $this->input->post('show_type'),
					'show_text' => $this->input->post('show_text')
				);
				if($this->input->post('flag') == 'as')
				{
					$countArr = $this->Front_model->commonGetData('count(*) as total' , 'centre_id = '.$this->input->post('centre_id') , TABLE_GENERAL_INFO);
					$updateData['added_date'] = date('Y-m-d');
					$updateData['sequence'] = ($countArr['total'] + 1);
					$insertId = $this->Front_model->commonAdd(TABLE_GENERAL_INFO , $updateData);
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'General info' , $this->lang->line('add_success_message')));
				}
				elseif($this->input->post('flag') == 'es')
				{
					$this->Front_model->commonUpdate(TABLE_GENERAL_INFO , 'plus_general_info_id = '.$id , $updateData);

					//Delete files
					$deleteEditFileArr = ($this->input->post('deleteEditFile') != '') ? explode(',' , $this->input->post('deleteEditFile')) : array();
					if(!empty($deleteEditFileArr))
					{
						foreach($deleteEditFileArr as $value)
							$this->delete_file($value);
					}
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'General info' , $this->lang->line('edit_success_message')));
				}

				//Add new uploaded file recoerd in the database
				if(!empty($file_name))
				{
					foreach($file_name as $value)
					{
						$insertData = array(
							'file_name' => $value,
							'plus_general_info_id' => ($this->input->post('flag') == 'as') ? $insertId : $id
						);
						$this->Front_model->commonAdd(TABLE_GENERAL_INFO_FILE , $insertData);
					}
				}
				redirect('/manage_general_info');
			}
			if($id != '')
			{
				$post = $this->Front_model->commonGetData('plus_general_info_id , name , centre_id , description , front_image , show_type , show_text' , 'plus_general_info_id = '.$id , TABLE_GENERAL_INFO , '' , 'asc' , 1);
				$post['files'] = $this->Front_model->commonGetData('plus_general_info_file_id , file_name' , 'plus_general_info_id = '.$id , TABLE_GENERAL_INFO_FILE , '' , 'asc' , 2);
				$data['post'] = $post;
			}

			//Get the images from photo gallery section
			$data['photoGallery'] = $this->Front_model->commonGetData('activity_photo_gallery_id , image_name' , 'centre_id = '.$this->session->userdata('centre_id').' AND status = 1 AND delete_flag = 0' , TABLE_ACTIVITY_PHOTO_GALLERY , 'added_date' , 'desc' , 2);

			$data['id'] = $id;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['viewPage'] = 'plus_video/manage_general_info_add_edit';
			$data['showLeftMenu'] = 0;
			$this->load->view('plus_video/template' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);
			$this->Front_model->commonUpdate(TABLE_GENERAL_INFO , 'plus_general_info_id = '.$id , $updateData);
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'general info' , $this->lang->line('delete_success_message')));
			redirect('/manage_general_info');
		}

		//This function is used to delete the file from directory as well as from database
		function delete_file($id = NULL)
		{
			if($id)
			{
				$result = $this->Front_model->commonGetData('file_name' , 'plus_general_info_file_id = '.$id , TABLE_GENERAL_INFO_FILE , '' , 'asc' , 1);
				if(file_exists('./'.GENERAL_INFO_ACCESS_FILE.$result['file_name']))
					unlink('./'.GENERAL_INFO_ACCESS_FILE.$result['file_name']);
				$this->Front_model->commonDelete(TABLE_GENERAL_INFO_FILE , 'plus_general_info_file_id = '.$id);
			}
			return TRUE;
		}

		/**
		*This function is used to change sequence for daily activities
		*
		*@param NONE
		*@return NONE
		*/
		public function change_sequence()
		{
			if($this->input->post('currentId'))
			{
				$this->Front_model->commonUpdate(TABLE_GENERAL_INFO , 'plus_general_info_id = '.$this->input->post('currentId') , array('sequence' => $this->input->post('referenceSequence')));
				$this->Front_model->commonUpdate(TABLE_GENERAL_INFO , 'plus_general_info_id = '.$this->input->post('referenceId') , array('sequence' => $this->input->post('currentSequence')));
				echo '';
			}
		}
	}
?>