<?php
	class Activity_program_model extends CI_Model
	{
		//This is the construuctor
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the master activity details - date and time slot wise
		*
		*@param Array $idArr : fixed activity id array
		*@return Array
		*/
		public function getMasterActivityDetails($idArr = array())
		{
			$returnArr = array();
			$result = $this->db->select('activity as name , from_time , to_time , fixed_day_activity_id')
							->where_in('fixed_day_activity_id' , $idArr)
							->order_by('from_time' , 'asc')
							->get(TABLE_FIXED_DAY_ACTIVITY_DETAILS)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr[date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['fixed_day_activity_id']][] = $value['name'];
			}
			return $returnArr;
		}

		/**
		*This function is used to get the extra activity details - date and time slot wise
		*
		*@param Array $idArr : extra activity id array
		*@return Array
		*/
		public function getExtraActivityDetails($idArr = array())
		{
			$returnArr = array();
			$result = $this->db->select('activity as name , from_time , to_time , extra_day_activity_id')
							->where_in('extra_day_activity_id' , $idArr)
							->order_by('from_time' , 'asc')
							->get(TABLE_EXTRA_DAY_ACTIVITY_DETAILS)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr[date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['extra_day_activity_id']][] = $value['name'];
			}
			return $returnArr;
		}

		/**
		*This function is used to get the activity basic details to show in the pdf formatted report heading
		*
		*@param NONE
		*@return Array
		*/
		public function getPdfHeader()
		{
			$returnArr = array();
			if($this->session->userdata('reportType') == 1)
			{
				$returnArr = $this->db->select('a.activity_name , b.group_name')
									->from(TABLE_MASTER_ACTIVITY.' a')
									->join(TABLE_STUDENT_GROUP.' b' , 'a.student_group = b.student_group_id' , 'left')
									->where('a.master_activity_id' , $this->session->userdata('selectType'))
									->get()->row_array();
			}
			elseif($this->session->userdata('reportType') == 2)
			{
				$returnArr = $this->db->select("b.group_name , concat(c.id_year , '_' , c.id_book) as group_reference")
									->from(TABLE_EXTRA_MASTER_ACTIVITY.' a')
									->join(TABLE_STUDENT_GROUP.' b' , 'a.student_group = b.student_group_id' , 'left')
									->join(TABLE_PLUS_BOOK.' c' , 'a.group_reference_id = c.id_book' , 'left')
									->where('a.centre_id' , $this->session->userdata('centre_id'))
									->where('a.student_group' , $this->session->userdata('student_group'))
									->where('a.group_reference_id' , $this->session->userdata('selectType'))
									->get()->row_array();
				if(empty($returnArr))
				{
					$result = $this->db->select("concat(id_year , '_' , id_book) as group_reference")
										->where('id_book' , $this->session->userdata('selectType'))
										->get(TABLE_PLUS_BOOK)->row_array();
					$returnArr['group_reference'] = $result['group_reference'];
					$result = $this->db->select('group_name')
									->where('student_group_id' , $this->session->userdata('student_group'))
									->get(TABLE_STUDENT_GROUP)->row_array();
					$returnArr['group_name'] = $result['group_name'];
				}
			}
			return $returnArr;
		}

		/**
		*This function is used to get the master activity details for any group reference id
		*
		*@param Staring $arrivalDate : The arrival date
		*@param Staring $departureDate : The departure date
		*@return Array
		*/
		public function getMasterActivityForGroup($arrivalDate = NULL , $departureDate = NULL)
		{
			$finalReturnArr = $returnArr = array();
			$masterDetails = $this->db->select('master_activity_id , arrival_date , departure_date')
									->where('centre_id' , $this->input->post('centre_id'))
									->where('student_group' , $this->input->post('student_group'))
									->where("(
												(
													'".date('Y-m-d' , strtotime($arrivalDate))."' >= cast(arrival_date AS DATE)
													AND
													'".date('Y-m-d' , strtotime($arrivalDate))."' <= cast(departure_date AS DATE)
												)
												AND
												(
													'".date('Y-m-d' , strtotime($departureDate))."' >= cast(arrival_date AS DATE)
													AND
													'".date('Y-m-d' , strtotime($departureDate))."' <= cast(departure_date AS DATE)
												)
											)")
									->get(TABLE_MASTER_ACTIVITY)->row_array();
			if(!empty($masterDetails) && isset($masterDetails['master_activity_id']))
			{
				$result = $this->db->select('a.date , a.fixed_day_activity_id , b.activity , b.from_time , b.to_time')
									->from(TABLE_FIXED_DAY_ACTIVITY.' a')
									->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
									->where('a.master_activity_id' , $masterDetails['master_activity_id'])
									->where("(cast(a.date as DATE) between '".date('Y-m-d' , strtotime($arrivalDate))."' AND '".date('Y-m-d' , strtotime($departureDate))."' OR
												cast(a.date as DATE) = '".$masterDetails['arrival_date']."' OR
												cast(a.date as DATE) = '".$masterDetails['departure_date']."')")
									->order_by('cast(a.date as DATE)' , 'asc')
									->get()->result_array();
				if(!empty($result))
				{
					foreach($result as $value)
					{
						$finalReturnArr['datesArr'][$value['fixed_day_activity_id']] = $value['date'];
						$returnArr[$value['date']][] = array(
							'activity' => $value['activity'],
							'from_time' => $value['from_time'],
							'to_time' => $value['to_time'],
							'fixed_day_activity_id' => $value['fixed_day_activity_id']
						);
					}

					$finalReturnArr['datesArr'] = array_flip($finalReturnArr['datesArr']);
					//Set arrival dates activity(for group) to the master activity
					$returnArr[date('Y-m-d' , strtotime($arrivalDate))] = $returnArr[$masterDetails['arrival_date']];
					if(date('Y-m-d' , strtotime($arrivalDate)) != $masterDetails['arrival_date'])
					{
						unset($returnArr[$masterDetails['arrival_date']]);
						$finalReturnArr['datesArr'][date('Y-m-d' , strtotime($arrivalDate))] = $finalReturnArr['datesArr'][$masterDetails['arrival_date']];
						unset($finalReturnArr['datesArr'][$masterDetails['arrival_date']]);
					}
					//Set departure dates activity(for group) to the master activity
					$returnArr[date('Y-m-d' , strtotime($departureDate))] = $returnArr[$masterDetails['departure_date']];
					if(date('Y-m-d' , strtotime($departureDate)) != $masterDetails['departure_date'])
					{
						unset($returnArr[$masterDetails['departure_date']]);
						$finalReturnArr['datesArr'][date('Y-m-d' , strtotime($departureDate))] = $finalReturnArr['datesArr'][$masterDetails['departure_date']];
						unset($finalReturnArr['datesArr'][$masterDetails['departure_date']]);
					}
					$finalReturnArr['datesArr'] = array_flip($finalReturnArr['datesArr']);

					//prepare activity details array date and timeslot wise
					foreach($returnArr as $dateValue => $detailsValue)
					{
						foreach($detailsValue as $value)
						{
							if($value['activity'] != '')
								$finalReturnArr['details'][date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['fixed_day_activity_id']][] = $value['activity'];
						}
					}
					ksort($finalReturnArr['details']);
				}
			}
			return $finalReturnArr;
		}

		/**
		*This function is used to get the master activity details for any group reference id(for export data)
		*
		*@param Staring $arrivalDate : The arrival date
		*@param Staring $departureDate : The departure date
		*@return Array
		*/
		public function getMasterActivityGroupExportData($arrivalDate = NULL , $departureDate = NULL)
		{
			$finalReturnArr = $returnArr = array();
			$masterDetails = $this->db->select('master_activity_id , arrival_date , departure_date')
									->where('centre_id' , $this->session->userdata('centre_id'))
									->where('student_group' , $this->session->userdata('student_group'))
									->where("(
												(
													'".date('Y-m-d' , strtotime($arrivalDate))."' >= cast(arrival_date AS DATE)
													AND
													'".date('Y-m-d' , strtotime($arrivalDate))."' <= cast(departure_date AS DATE)
												)
												AND
												(
													'".date('Y-m-d' , strtotime($departureDate))."' >= cast(arrival_date AS DATE)
													AND
													'".date('Y-m-d' , strtotime($departureDate))."' <= cast(departure_date AS DATE)
												)
											)")
									->get(TABLE_MASTER_ACTIVITY)->row_array();
			if(!empty($masterDetails) && isset($masterDetails['master_activity_id']))
			{
				$result = $this->db->select('a.date , a.fixed_day_activity_id , b.activity , b.from_time , b.to_time')
									->from(TABLE_FIXED_DAY_ACTIVITY.' a')
									->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
									->where('a.master_activity_id' , $masterDetails['master_activity_id'])
									->where("(cast(a.date as DATE) between '".date('Y-m-d' , strtotime($arrivalDate))."' AND '".date('Y-m-d' , strtotime($departureDate))."' OR
												cast(a.date as DATE) = '".$masterDetails['arrival_date']."' OR
												cast(a.date as DATE) = '".$masterDetails['departure_date']."')")
									->order_by('cast(a.date as DATE)' , 'asc')
									->get()->result_array();
				if(!empty($result))
				{
					foreach($result as $value)
					{
						$finalReturnArr['datesArr'][$value['fixed_day_activity_id']] = $value['date'];
						$returnArr[$value['date']][] = array(
							'activity' => $value['activity'],
							'from_time' => $value['from_time'],
							'to_time' => $value['to_time'],
							'fixed_day_activity_id' => $value['fixed_day_activity_id']
						);
					}

					$finalReturnArr['datesArr'] = array_flip($finalReturnArr['datesArr']);
					//Set arrival dates activity(for group) to the master activity
					$returnArr[date('Y-m-d' , strtotime($arrivalDate))] = $returnArr[$masterDetails['arrival_date']];
					unset($returnArr[$masterDetails['arrival_date']]);
					$finalReturnArr['datesArr'][date('Y-m-d' , strtotime($arrivalDate))] = $finalReturnArr['datesArr'][$masterDetails['arrival_date']];
					unset($finalReturnArr['datesArr'][$masterDetails['arrival_date']]);

					//Set departure dates activity(for group) to the master activity
					$returnArr[date('Y-m-d' , strtotime($departureDate))] = $returnArr[$masterDetails['departure_date']];
					unset($returnArr[$masterDetails['departure_date']]);
					$finalReturnArr['datesArr'][date('Y-m-d' , strtotime($departureDate))] = $finalReturnArr['datesArr'][$masterDetails['departure_date']];
					unset($finalReturnArr['datesArr'][$masterDetails['departure_date']]);
					$finalReturnArr['datesArr'] = array_flip($finalReturnArr['datesArr']);

					//prepare activity details array date and timeslot wise
					foreach($returnArr as $dateValue => $detailsValue)
					{
						foreach($detailsValue as $value)
						{
							if($value['activity'] != '')
								$finalReturnArr['details'][date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['fixed_day_activity_id']][] = $value['activity'];
						}
					}
				}
			}
			return $finalReturnArr;
		}
	}
?>