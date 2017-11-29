<?php
	class Front_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		//This function is ysed to get program details to show banner in front end
		public function getProgramDetails($languageId = NULL)
		{
			$this->db->select('a.program_id , a.program_image , b.program_title , b.program_short_description');
			$this->db->from(TABLE_PROGRAM . ' a');
			$this->db->join(TABLE_PROGRAM_LANGUAGE . ' b' , 'a.program_id = b.program_id AND b.language_id = '.$languageId , 'left');
			$this->db->where('a.program_status' , 1);
			$this->db->where('a.delete_flag' , 0);
			return $this->db->get()->result_array();
		}

		//This function is used to get the details of junior summer courses from DB as added from back-end
		function getJuniorSummerCourseDetails($languageId = NULL , $id = NULL)
		{
			$result = $this->db->select('a.course_master_id , a.course_image , b.course_name , b.corse_description')
							->from(TABLE_COURSE_MASTER.' a')
							->join(TABLE_COURSE_LANGUAGE.' b' , 'a.course_master_id = b.course_id AND b.language_id = '.$languageId , 'left')
							->where('a.course_master_id' , $id)
							->get()->row_array();
			$result['course_specification'] = $this->db->select('specification_option , specification_value')
													->where('course_id' , $id)
													->get(TABLE_COURSE_SPECIFICATION)->result_array();
			$result['course_feature'] = $this->db->select('feature_title , feature_description , feature_image')
													->where('course_id' , $id)
													->get(TABLE_COURSE_FEATURE)->result_array();
			return $result;
		}

		//Function is used to get all destination details (region and centre)
		function getDestinationDetails($isRegion = NULL , $regionId = NULL)
		{
			$returnArr = array();
			if($isRegion == 1)
				$returnArr['region'] = $this->db->select('region_id , region_name')
												->get(TABLE_REGION_MASTER)->result_array();
			$this->db->select('centre_id , centre_name , centre_image');
			if($regionId != '')
				$this->db->where('region_id' , $regionId);
			$returnArr['centre'] = $this->db->get(TABLE_CENTRE_MASTER)->result_array();
			return $returnArr;
		}

		//Function is used to get course details form database and show on the homepage
		function getCourseDetails($languageId = NULL)
		{
			return $this->db->select('a.course_master_id , a.course_front_image , b.course_name')
							->from(TABLE_COURSE_MASTER . ' a')
							->join(TABLE_COURSE_LANGUAGE . ' b' , 'a.course_master_id = b.course_id AND b.language_id = '.$languageId , 'left')
							->where('a.course_status' , 1)
							->where('a.delete_flag' , 0)
							->get()->result_array();
		}
	}
?>