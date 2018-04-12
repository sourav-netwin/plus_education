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

		//This function is used to get the activity details and show in the report
		public function report()
		{
			$post = array();
			$groupDropdown = array('' => 'Please select group');
			if($this->input->post('flag') == 'search')
			{
				$post['centre_id'] = $this->input->post('centre_id');
				$post['student_group'] = $this->input->post('student_group');
				$post['start_date'] = $this->input->post('start_date');
				$post['end_date'] = $this->input->post('end_date');

				//Prepare group dropdown
				$result = $this->get_group_dropdown(1);
				if(!empty($result))
				{
					foreach($result as $value)
						$groupDropdown[$value['student_group_id']] = $value['group_name'];
				}

				//Save the post value for in session for the export to excel option
				$this->session->set_userdata('centre_id' , $this->input->post('centre_id'));
				$this->session->set_userdata('student_group' , $this->input->post('student_group'));
				$this->session->set_userdata('start_date' , $this->input->post('start_date'));
				$this->session->set_userdata('end_date' , $this->input->post('end_date'));
				$this->session->set_userdata('whereCondition' , '');

				$post['details'] = $this->Master_activity_model->getActivityReport();
				$post['dropdownArr'] = $this->Master_activity_model->getActivityFilterDropdown();
			}
			$data['post'] = $post;
			$data['groupDropdown'] = $groupDropdown;
			$data['viewPage'] = 'plus_video/activity_report';
			$data['showLeftMenu'] = 0;
			$this->load->view('plus_video/template' , $data);
		}

		//This function is usd to get the activity report ater filter search through the dropdown filter in ajax call
		public function filter_search()
		{
			if($this->input->post('centre_id'))
			{
				$whereCondition = ($this->input->post('whereCondition') != '') ? implode(' AND ' , $this->input->post('whereCondition')) : NULL;

				//Save the post value for in session for the export to excel option
				$this->session->set_userdata('centre_id' , $this->input->post('centre_id'));
				$this->session->set_userdata('student_group' , $this->input->post('student_group'));
				$this->session->set_userdata('start_date' , $this->input->post('start_date'));
				$this->session->set_userdata('end_date' , $this->input->post('end_date'));
				$this->session->set_userdata('whereCondition' , $whereCondition);

				$data['details'] = $this->Master_activity_model->getActivityReport($whereCondition);
				echo json_encode($data);
			}
		}

		//This function is used to export the activity details in excel
		public function export_to_excel()
		{
			$centreDetails = $this->Front_model->commonGetdata('nome_centri' , 'id = '.$this->session->userdata('centre_id') , TABLE_CENTRE , 1);
			$data = $this->Master_activity_model->getExportActivity();
			$this->load->library('export');
			$this->export->to_excel($data , str_replace(' ' , '_' , strtolower($centreDetails['nome_centri'])));
		}

		/**
		*This function is used to get the student gropup dropdown according to the centre(in acivity report module)
		*
		*@param NONE
		*@return NONE
		*/
		public function get_group_dropdown($returnType = NULL)
		{
			$data = array();
			if($this->input->post('centre_id'))
				$data = $this->Front_model->commonGetData("group_name , student_group_id" , 'centre_id = '.$this->input->post('centre_id').' AND delete_flag=0' , TABLE_STUDENT_GROUP , 'group_name' , 'asc' , 2);
			if($returnType == 1)
				return $data;
			else
				echo json_encode($data);
		}

		/**
		*This function is used to perform the add/edit operation for master activity module
		*
		*@param Integer $id : master activity id
		*@return NONE
		*/
		public function add_edit($id = NULL)
		{
			$post = array();
			$groupDropdown = array('' => 'Please select group');
			if($this->input->post('flag'))
			{
				if($this->input->post('flag') == 'as')
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('add_success_message')));
				else
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('edit_success_message')));
				redirect('/master/index/manage_fixed_activity');
			}

			if($id != '')
			{
				$post = $this->Front_model->commonGetData("centre_id , activity_name , date_format(arrival_date , '%d-%m-%Y') as arrival_date ,
								date_format(departure_date , '%d-%m-%Y') as departure_date , student_group" , 'master_activity_id = '.$id , TABLE_MASTER_ACTIVITY , 1);

				//Prepare group dropdown
				$result = $this->Front_model->commonGetData("group_name , student_group_id" , 'centre_id = '.$post['centre_id'].' AND delete_flag=0' , TABLE_STUDENT_GROUP , 'group_name' , 'asc' , 2);
				if(!empty($result))
				{
					foreach($result as $value)
						$groupDropdown[$value['student_group_id']] = $value['group_name'];
				}

				$result = $this->Front_model->commonGetData("fixed_day_activity_id as id , date_format(date , '%d-%m-%Y') as date" , 'master_activity_id = '.$id , TABLE_FIXED_DAY_ACTIVITY , 'cast(date as DATE)' , 'asc' , 2);

				if(!empty($result))
				{
					foreach($result as $value)
						$post['datesArr'][$value['id']] = $value['date'];
					$post['details'] = $this->Master_activity_model->getActivityDetails(array_keys($post['datesArr']));
				}
				//echo "<pre>";print_r($post);die('popp');
			}
			$data['post'] = $post;
			$data['id'] = $id;
			$data['groupDropdown'] = $groupDropdown;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['viewPage'] = 'plus_video/master_activity';
			$data['showLeftMenu'] = 0;
			$this->load->view('plus_video/template' , $data);
		}

		/**
		*This function is used to get the activity details through ajax to show in the activity modal popup form
		*
		*@param NONE
		*@return NONE
		*/
		public function get_activity_details()
		{
			$data = array();
			if($this->input->post('id'))
			{
				$data = $this->Front_model->commonGetData("*" , 'fixed_day_activity_details_id = '.$this->input->post('id') , TABLE_FIXED_DAY_ACTIVITY_DETAILS , 1);
				$data['managed_by'] = $this->Front_model->commonGetData("managed_by_name" , 'fixed_day_activity_details_id = '.$this->input->post('id').' AND type = 1' , TABLE_FIXED_DAY_MANAGED_BY , 'managed_by_name' , 'asc' , 2);
				$data['managed_by_text'] = $this->Front_model->commonGetData("managed_by_name" , 'fixed_day_activity_details_id = '.$this->input->post('id').' AND type = 2' , TABLE_FIXED_DAY_MANAGED_BY , 'managed_by_name' , 'asc' , 2);
			}
			echo json_encode($data);
		}

		/**
		*This function is used to perform add or edit operations for the activity details through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function activity_details_add_edit()
		{
			if($this->input->post('activityDetailsFlag'))
			{
				$managedByDropdownArr = $this->input->post('managed_by');
				$managedByTextArr = $this->input->post('managed_by_text');

				$insertData = array(
					'program_name' => $this->input->post('program_name'),
					'location' => $this->input->post('location'),
					'activity' => $this->input->post('activity'),
					'from_time' => $this->input->post('from_time'),
					'to_time' => $this->input->post('to_time'),
					'fixed_day_activity_id' => $this->input->post('activityDetailsParentId')
				);
				if($this->input->post('activityDetailsFlag') == 'as')
				{
					$activityDetailsId = $this->Front_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $insertData);
					//For managd by dropdown value(save into the database)
					if(!empty($managedByDropdownArr))
					{
						foreach($managedByDropdownArr as $value)
						{
							if(isset($value) && $value != '')
							{
								$insertData = array(
									'managed_by_name' => $value,
									'type' => 1,
									'fixed_day_activity_details_id' => $activityDetailsId
								);
								$this->Front_model->commonAdd(TABLE_FIXED_DAY_MANAGED_BY , $insertData);
							}
						}
					}
					//For managd by textbox value(save into the database)
					if(!empty($managedByTextArr))
					{
						foreach($managedByTextArr as $value)
						{
							if(isset($value) && $value != '')
							{
								$insertData = array(
									'managed_by_name' => $value,
									'type' => 2,
									'fixed_day_activity_details_id' => $activityDetailsId
								);
								$this->Front_model->commonAdd(TABLE_FIXED_DAY_MANAGED_BY , $insertData);
							}
						}
					}
				}
				else
				{
					$this->Front_model->commonUpdate(TABLE_FIXED_DAY_ACTIVITY_DETAILS , "fixed_day_activity_id = ".$this->input->post('activityDetailsParentId')." AND fixed_day_activity_details_id = ".$this->input->post('activityDetailsId') , $insertData);
					$this->Front_model->commonDelete(TABLE_FIXED_DAY_MANAGED_BY , 'fixed_day_activity_details_id = '.$this->input->post('activityDetailsId'));
					//For managd by dropdown value(save into the database)
					if(!empty($managedByDropdownArr))
					{
						foreach($managedByDropdownArr as $value)
						{
							if(isset($value) && $value != '')
							{
								$insertData = array(
									'managed_by_name' => $value,
									'type' => 1,
									'fixed_day_activity_details_id' => $this->input->post('activityDetailsId')
								);
								$this->Front_model->commonAdd(TABLE_FIXED_DAY_MANAGED_BY , $insertData);
							}
						}
					}
					//For managd by textbox value(save into the database)
					if(!empty($managedByTextArr))
					{
						foreach($managedByTextArr as $value)
						{
							if(isset($value) && $value != '')
							{
								$insertData = array(
									'managed_by_name' => $value,
									'type' => 2,
									'fixed_day_activity_details_id' => $this->input->post('activityDetailsId')
								);
								$this->Front_model->commonAdd(TABLE_FIXED_DAY_MANAGED_BY , $insertData);
							}
						}
					}
				}
				echo ($this->input->post('activityDetailsFlag') == 'as') ? $activityDetailsId : $this->input->post('activityDetailsId');
			}
		}

		/**
		*This function is used to delete activity details from database through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function delete_activity_details()
		{
			if($this->input->post('id'))
			{
				$this->Front_model->commonDelete(TABLE_FIXED_DAY_ACTIVITY_DETAILS , 'fixed_day_activity_details_id = '.$this->input->post('id'));
				$this->Front_model->commonDelete(TABLE_FIXED_DAY_MANAGED_BY , 'fixed_day_activity_details_id = '.$this->input->post('id'));
				echo '';
			}

		}

		/**
		*This function is used to update activity timing through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function update_activity_time()
		{
			if($this->input->post('fieldName'))
			{
				$this->Master_activity_model->updateActivityTiming();
				echo '';
			}
		}

		/**
		*This function is used to copy one master activity details and add new activity(for drag/drop)
		*
		*@param NONE
		*@return NONE
		*/
		public function copy_activity_details()
		{
			$data = array();
			if($this->input->post('id'))
			{
				$result = $this->Front_model->commonGetData("program_name , location , activity" , 'fixed_day_activity_details_id = '.$this->input->post('id') , TABLE_FIXED_DAY_ACTIVITY_DETAILS , 1);
				$managedByResult = $this->Front_model->commonGetData('managed_by_name , type' , 'fixed_day_activity_details_id = '.$this->input->post('id') , TABLE_FIXED_DAY_MANAGED_BY , 'managed_by_name' , 'asc' , 2);
				$insertData = array(
					'program_name' => $result['program_name'],
					'location' => $result['location'],
					'activity' => $result['activity'],
					'from_time' => $this->input->post('from_time'),
					'to_time' => $this->input->post('to_time'),
					'fixed_day_activity_id' => $this->input->post('fixed_day_activity_id')
				);
				$detailsId = $this->Front_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $insertData);
				if(!empty($managedByResult))
				{
					foreach($managedByResult as $value)
					{
						$value['fixed_day_activity_details_id'] = $detailsId;
						$this->Front_model->commonAdd(TABLE_FIXED_DAY_MANAGED_BY , $value);
					}
				}
				$data['id'] = $detailsId;
				$data['name'] = $result['activity'];
			}
			echo json_encode($data);
		}
	}
?>