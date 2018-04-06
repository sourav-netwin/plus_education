<?php
	class Extra_activity_model extends CI_Model
	{
		//This is the construct
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the activity details - date and time slot wise
		*
		*@param Array $idArr : id array
		*@return Array
		*/
		public function getActivityDetails($idArr = array())
		{
			$returnArr = array();
			$result = $this->db->select('extra_day_activity_details_id as id , activity as name , from_time , to_time , extra_day_activity_id')
							->where_in('extra_day_activity_id' , $idArr)
							->order_by('from_time' , 'asc')
							->get(TABLE_EXTRA_DAY_ACTIVITY_DETAILS)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr[date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['extra_day_activity_id']][] = $value;
			}
			return $returnArr;
		}

		/**
		*This function is used to get the master activity details to copy the same to
		*the extra activity table
		*
		*@param NONE
		*@return Array
		*/
		public function getMaterActivityDetails()
		{
			$returnArr = array();
			$dateRange = $this->db->select('arrival_date , departure_date')
								->where('id_book' , $this->input->post('group_reference_id'))
								->get(TABLE_PLUS_BOOK)->row_array();
			$masterDetails = $this->db->select('master_activity_id , arrival_date , departure_date')
										->where('centre_id' , $this->input->post('centre_id'))
										->where('student_group' , $this->input->post('student_group'))
										->where("(
													(
														'".date('Y-m-d' , strtotime($dateRange['arrival_date']))."' >= cast(arrival_date AS DATE)
														AND
														'".date('Y-m-d' , strtotime($dateRange['arrival_date']))."' <= cast(departure_date AS DATE)
													)
													OR
													(
														'".date('Y-m-d' , strtotime($dateRange['departure_date']))."' >= cast(arrival_date AS DATE)
														AND
														'".date('Y-m-d' , strtotime($dateRange['departure_date']))."' <= cast(departure_date AS DATE)
													)
												)")
										->get(TABLE_MASTER_ACTIVITY)->row_array();
			if(!empty($masterDetails))
			{
				$result = $this->db->select('a.date , b.program_name , b.location , b.activity , b.from_time , b.to_time , b.managed_by')
								->from(TABLE_FIXED_DAY_ACTIVITY.' a')
								->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
								->where("cast(a.date as DATE) between '".$dateRange['arrival_date']."' AND '".$dateRange['departure_date']."'")
								->order_by('cast(a.date as DATE)' , 'asc')
								->get()->result_array();
				if(!empty($result))
				{
					foreach($result as $value)
					{
						if($value['date'] == $dateRange['arrival_date'])
						{
							$returnArr[$value['date']] = $this->db->select('b.program_name , b.location , b.activity , b.from_time , b.to_time , b.managed_by')
																	->from(TABLE_FIXED_DAY_ACTIVITY.' a')
																	->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
																	->where("cast(a.date as DATE) = '".$masterDetails['arrival_date']."'")
																	->where('a.master_activity_id' , $masterDetails['master_activity_id'])
																	->order_by('cast(a.date as DATE)' , 'asc')
																	->get()->result_array();
						}
						elseif($value['date'] == $dateRange['departure_date'])
						{
							$returnArr[$value['date']] = $this->db->select('b.program_name , b.location , b.activity , b.from_time , b.to_time , b.managed_by')
																	->from(TABLE_FIXED_DAY_ACTIVITY.' a')
																	->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
																	->where("cast(a.date as DATE) = '".$masterDetails['departure_date']."'")
																	->where('a.master_activity_id' , $masterDetails['master_activity_id'])
																	->order_by('cast(a.date as DATE)' , 'asc')
																	->get()->result_array();
						}
						else
						{
							$returnArr[$value['date']][] = array(
								'program_name' => $value['program_name'],
								'location' => $value['location'],
								'activity' => $value['activity'],
								'from_time' => $value['from_time'],
								'to_time' => $value['to_time'],
								'managed_by' => $value['managed_by']
							);
						}
					}
				}
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
			$this->db->where_in('extra_day_activity_details_id' , $this->input->post('activityIdArr'))
					->update(TABLE_EXTRA_DAY_ACTIVITY_DETAILS , $data);
		}
	}
