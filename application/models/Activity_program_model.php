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
			}
			return $returnArr;
		}
	}
?>