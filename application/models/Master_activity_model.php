<?php
	class master_activity_model extends CI_Model
	{
		//This is the construuctor
		public function __construct()
		{
			parent::__construct();
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
	}
?>