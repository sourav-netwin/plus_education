<?php
	class Extra_activity_model extends CI_Model
	{
		//This is the construct
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Front_model' , '' , TRUE);
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
													AND
													(
														'".date('Y-m-d' , strtotime($dateRange['departure_date']))."' >= cast(arrival_date AS DATE)
														AND
														'".date('Y-m-d' , strtotime($dateRange['departure_date']))."' <= cast(departure_date AS DATE)
													)
												)")
										->get(TABLE_MASTER_ACTIVITY)->row_array();
			if(!empty($masterDetails))
			{
				$result = $this->db->select('a.date , b.fixed_day_activity_details_id , b.program_name , b.location , b.activity , b.from_time , b.to_time')
								->from(TABLE_FIXED_DAY_ACTIVITY.' a')
								->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
								->where('a.master_activity_id' , $masterDetails['master_activity_id'])
								->where("(cast(a.date as DATE) between '".$dateRange['arrival_date']."' AND '".$dateRange['departure_date']."' OR
											cast(a.date as DATE) = '".$masterDetails['arrival_date']."' OR
											cast(a.date as DATE) = '".$masterDetails['departure_date']."')")
								->order_by('cast(a.date as DATE)' , 'asc')
								->get()->result_array();
				if(!empty($result))
				{
					foreach($result as $value)
					{
						$managedByArr = (isset($value['fixed_day_activity_details_id'])) ? $this->Front_model->commonGetData('managed_by_name , type' , 'fixed_day_activity_details_id = '.$value['fixed_day_activity_details_id'] , TABLE_FIXED_DAY_MANAGED_BY , 'managed_by_name' , 'asc' , 2) : array();
						$returnArr[$value['date']][] = array(
							'program_name' => $value['program_name'],
							'location' => $value['location'],
							'activity' => $value['activity'],
							'from_time' => $value['from_time'],
							'to_time' => $value['to_time'],
							'managed_by' => $managedByArr
						);
					}
				}
				//Set arrival dates activity(for group) to the master activity
				$returnArr[$dateRange['arrival_date']] = $returnArr[$masterDetails['arrival_date']];
				unset($returnArr[$masterDetails['arrival_date']]);
				//Set departure dates activity(for group) to the master activity
				$returnArr[$dateRange['departure_date']] = $returnArr[$masterDetails['departure_date']];
				unset($returnArr[$masterDetails['departure_date']]);
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
