<?php
	class master_activity_model extends CI_Model
	{
		//This is the construuctor
		public function __construct()
		{
			parent::__construct();
		}

		//This function is used to get the master activity details to show in the activity report
		public function getActivityReport($whereCondition = NULL)
		{
			$this->db->select("b.date , c.program_name , c.location , c.activity , c.from_time , c.to_time , d.managed_by_name as managed_by" , FALSE);
			$this->db->from(TABLE_MASTER_ACTIVITY.' a');
			$this->db->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.master_activity_id = b.master_activity_id' , 'left');
			$this->db->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' c' , 'b.fixed_day_activity_id = c.fixed_day_activity_id' , 'left');
			$this->db->join(TABLE_FIXED_DAY_MANAGED_BY.' d' , 'c.fixed_day_activity_details_id = d.fixed_day_activity_details_id' , 'left');
			$this->db->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'");
			$this->db->where('a.centre_id' , $this->input->post('centre_id'));
			$this->db->where('a.student_group' , $this->input->post('student_group'));
			if($whereCondition != '')
				$this->db->where($whereCondition);
			$this->db->order_by('b.date asc , c.from_time asc');
			return $this->db->get()->result_array();
		}

		//This function is usd to get the dropdown details for the activity report filers
		public function getActivityFilterDropdown()
		{
			$returnArr = array();
			$result = $this->db->select('distinct b.date as date' , FALSE)
							->from(TABLE_MASTER_ACTIVITY.' a')
							->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.master_activity_id = b.master_activity_id' , 'left')
							->where('a.centre_id' , $this->input->post('centre_id'))
							->where('a.student_group' , $this->input->post('student_group'))
							->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
							->order_by('b.date' , 'asc')
							->get(TABLE_FIXED_DAY_ACTIVITY)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['dateValue'][] = $value['date'];
			}
			$result = $this->getDistinctActivityEntity('program_name');
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['proramName'][] = $value['program_name'];
			}
			$result = $this->getDistinctActivityEntity('location');
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['location'][] = $value['location'];
			}
			$result = $this->getDistinctActivityEntity('activity');
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['activity'][] = $value['activity'];
			}
			$result = $this->getDistinctActivityEntity('from_time');
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['fromTime'][] = $value['from_time'];
			}
			$result = $this->getDistinctActivityEntity('to_time');
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['toTime'][] = $value['to_time'];
			}
			$result = getContractPersonDropdown();
			unset($result['']);
			$returnArr['managedBy'] = $result;
			return $returnArr;
		}

		//This function is usd to get the activity details to show in the exported excel file
		public function getExportActivity()
		{
			$returnArr = array();
			$this->db->select("b.date , c.program_name , c.location , c.activity , c.from_time , c.to_time , d.managed_by_name as managed_by" , FALSE);
			$this->db->from(TABLE_MASTER_ACTIVITY.' a');
			$this->db->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.master_activity_id = b.master_activity_id' , 'left');
			$this->db->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' c' , 'b.fixed_day_activity_id = c.fixed_day_activity_id' , 'left');
			$this->db->join(TABLE_FIXED_DAY_MANAGED_BY.' d' , 'c.fixed_day_activity_details_id = d.fixed_day_activity_details_id' , 'left');
			$this->db->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->session->userdata('start_date')))."' AND '".date('Y-m-d' , strtotime($this->session->userdata('end_date')))."'");
			$this->db->where('a.centre_id' , $this->session->userdata('centre_id'));
			$this->db->where('a.student_group' , $this->session->userdata('student_group'));
			if($this->session->userdata('whereCondition') != '')
				$this->db->where($this->session->userdata('whereCondition'));
			$this->db->order_by('b.date asc , c.from_time asc');
			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$returnArr[$key]['Date'] = date('d-M-Y' , strtotime($value['date']));
					$returnArr[$key]['Type of activity'] = $value['program_name'];
					$returnArr[$key]['Location'] = $value['location'];
					$returnArr[$key]['Activity'] = $value['activity'];
					$returnArr[$key]['From time'] = date('H:i' , strtotime($value['from_time']));
					$returnArr[$key]['To time'] = date('H:i' , strtotime($value['to_time']));
					$returnArr[$key]['Managed by'] = $value['managed_by'];
				}
			}
			return $returnArr;
		}

		/**
		*This function is used to get the activity details - date and time slot wise
		*
		*@param Array $idArr : fixed activity id array
		*@return Array
		*/
		public function getActivityDetails($idArr = array())
		{
			$returnArr = array();
			$result = $this->db->select('fixed_day_activity_details_id as id , activity as name , from_time , to_time , fixed_day_activity_id')
							->where_in('fixed_day_activity_id' , $idArr)
							->order_by('from_time' , 'asc')
							->get(TABLE_FIXED_DAY_ACTIVITY_DETAILS)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr[date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['fixed_day_activity_id']][] = $value;
			}
			return $returnArr;
		}

		/**
		*This function is used to update timing for activity details
		*
		*@param NONE
		*@return NONE
		*/
		public function updateActivityTiming()
		{
			$data[$this->input->post('fieldName')] = $this->input->post('time');
			$this->db->where_in('fixed_day_activity_details_id' , $this->input->post('activityIdArr'))
					->update(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $data);
		}

		/**
		*This function is used to select distinct column from database for showing the activity details in the dropdown
		*
		*@param String $fieldName : The database field name
		*@return Array
		*/
		private function getDistinctActivityEntity($fieldName = NULL)
		{
			return $this->db->select('distinct c.'.$fieldName.' as '.$fieldName , FALSE)
							->from(TABLE_MASTER_ACTIVITY.' a')
							->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.master_activity_id = b.master_activity_id' , 'left')
							->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' c' , 'b.fixed_day_activity_id = c.fixed_day_activity_id' , 'left')
							->where('a.centre_id' , $this->input->post('centre_id'))
							->where('a.student_group' , $this->input->post('student_group'))
							->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
							->order_by('c.'.$fieldName , 'asc')
							->get()->result_array();
		}
	}
?>