<?php
	class master_activity_model extends CI_Model
	{
		//This is the construuctor
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the master activity details to show in the activity report(Both Report and filter Dropdown)
		*
		*@param Integer $centreId : Centre id
		*@param Date $arrivalDate : The arrival date
		*@param Date $departureDate : The departure date
		*@param String $whereCondition : Where condition(for filter search)
		*@param String $fieldName : To select the unique field
		*@param Integer $filterDropdownFlag : To get the dropdown array or not
		*@return Array
		*/
		public function getActivityReport($centreId = NULL , $arrivalDate = NULL , $departureDate = NULL , $whereCondition = NULL , $fieldName = NULL , $filterDropdownFlag = NULL)
		{
			if($fieldName != '')
				$this->db->select('distinct '.$fieldName.' as '.$fieldName , FALSE);
			$this->db->where('centre_id' , $centreId);
			$this->db->where("cast(date as DATE) between '".date('Y-m-d' , strtotime($arrivalDate))."' and '".date('Y-m-d' , strtotime($departureDate))."' ");
			if($whereCondition != '')
				$this->db->where($whereCondition);
			if($fieldName != '')
				$this->db->order_by($fieldName);
			else
				$this->db->order_by('date asc , from_time asc');
			$result = $this->db->get(ACTIVITY_REPORT_PROGRAM)->result_array();
			if($fieldName != '')
				return $result;
			$returnArr = array();
			$returnArr['details'] = $result;

			//Prepare filter dropdown through recursion
			if($filterDropdownFlag == 1)
			{
				$returnArr['dropdownArr']['groupNameValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'group_name' , $filterDropdownFlag);
				$returnArr['dropdownArr']['groupReferenceValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'group_reference' , $filterDropdownFlag);
				$returnArr['dropdownArr']['dateValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'date' , $filterDropdownFlag);
				$returnArr['dropdownArr']['programNameValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'program_name' , $filterDropdownFlag);
				$returnArr['dropdownArr']['locationValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'location' , $filterDropdownFlag);
				$returnArr['dropdownArr']['activityValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'activity' , $filterDropdownFlag);
				$returnArr['dropdownArr']['fromTimeValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'from_time' , $filterDropdownFlag);
				$returnArr['dropdownArr']['toTimeValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'to_time' , $filterDropdownFlag);
				$returnArr['dropdownArr']['managedByValue'] = getContractPersonDropdown();
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
	}
?>