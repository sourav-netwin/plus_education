<?php
	class Master_activity extends CI_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('message' , 'english');
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->model('Master_activity_model' , '' , TRUE);
			$this->load->helper('frontend');
			checkAdminLogin();
			if($this->session->userdata('campusManager') != 1)
			{
				session_destroy();
				redirect('login');
			}
		}

		//This function is used to perform the add/edit operation for master activity module
		public function add_edit($id = NULL)
		{
			$post = array();
			if($this->input->post('flag'))
			{
				//Insert or update data
				$insertData = array(
					'centre_id' => $this->input->post('centre_id'),
					'date' => date('Y-m-d' , strtotime($this->input->post('date')))
				);
				if($this->input->post('flag') == 'as')
				{
					$insertId = $this->Front_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY , $insertData);
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('add_success_message')));
				}
				else
				{
					$this->Front_model->commonUpdate(TABLE_FIXED_DAY_ACTIVITY , 'fixed_day_activity_id = '.$id , $insertData);
					//Delete the old record from the subtable
					$this->Front_model->commonDelete(TABLE_FIXED_DAY_ACTIVITY_DETAILS , 'fixed_day_activity_id = '.$id);
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('edit_success_message')));
				}

				//Prepare data for subtables(activity details)
				$programNameArr = $this->input->post('program_name');
				$locationArr = $this->input->post('location');
				$activityArr = $this->input->post('activity');
				$fromTimeArr = $this->input->post('from_time');
				$toTimeArr = $this->input->post('to_time');
				$managedByArr = $this->input->post('managed_by');
				if(!empty($programNameArr))
				{
					foreach($programNameArr as $key => $value)
					{
						$insertData = array(
							'program_name' => $value,
							'location' => $locationArr[$key],
							'activity' => $activityArr[$key],
							'from_time' => $fromTimeArr[$key],
							'to_time' => $toTimeArr[$key],
							'managed_by' => $managedByArr[$key],
							'fixed_day_activity_id' => ($this->input->post('flag') == 'as') ? $insertId : $id
						);
						$this->Front_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $insertData);
					}
				}
				redirect('/master/index/manage_fixed_activity');
			}

			//Get data to show in the edit page
			if($id != '')
				$post = $this->Master_activity_model->getData($id);

			$data['post'] = $post;
			$data['id'] = $id;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['viewPage'] = 'plus_video/master_activity';
			$data['showLeftMenu'] = 0;
			$this->load->view('plus_video/template' , $data);
		}

		//This function is used to check if any duplicate data is present for the centre and date
		public function duplicate()
		{
			if($this->input->post('flag'))
			{
				$whereCondition = "centre_id = '".$this->input->post('centre_id')."' AND date = '".date('Y-m-d' , strtotime($this->input->post('date')))."'";
				if($this->input->post('flag') == 'es')
					$whereCondition.= " AND fixed_day_activity_id != '".$this->input->post('id')."'";
				$result = $this->Front_model->commonGetData('COUNT(*) as total' , $whereCondition , TABLE_FIXED_DAY_ACTIVITY , 1);
				echo json_encode($result);
			}
		}

		//This function is used to search the activities for the selected date and show in the preview section
		public function search_activity()
		{
			$data = array();
			if($this->input->post('centre_id'))
				$data['htmlStr'] = $this->Master_activity_model->previewActivity();
			echo json_encode($data);
		}
	}
?>