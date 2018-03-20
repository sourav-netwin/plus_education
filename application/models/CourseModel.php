<?php
	/**
	*This class is used to manage the database related operations for the course related modules
	*
	*@category Model
	*@author S.D
	*/
	class CourseModel extends CI_Model
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the details of courses from DB as added from back-end
		*
		*@param Integer $languageId : Language id (Default is english)
		*@param Integer $id : course id
		*@return Array $result : The details array
		*/
		function getDetailsCourses($languageId = NULL , $id = NULL)
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

		/**
		*Function is used to get all destination details for courses (region and centre)
		*
		*@param String $tableName : database table name
		*@param Integer $isRegion : flag to check region is needed
		*@param Integer $regionId : region id
		*@return Array $returnArr : Destination details array
		*/
		function getDestinationDetails($tableName = NULL , $isRegion = NULL , $regionId = NULL)
		{
			$returnArr = array();
			if($tableName == TABLE_JUNIOR_CENTRE)
				$statusFieldName = 'junior_centre_status';
			elseif($tableName == TABLE_JUNIOR_MINISTAY)
				$statusFieldName = 'junior_ministay_status';

			if($isRegion == 1)
				$returnArr['region'] = $this->db->select('distinct(located_in) as region')
												->from($tableName)
												->join(TABLE_CENTRE , 'id = centre_id' , 'left')
												->where("located_in != ''")
												->where("(".$statusFieldName." = 1 AND ".$tableName.".delete_flag=0)")
												->where('((attivo = 1) or (is_mini_stay = 1 and attivo = 0))')
												->get()->result_array();
			$this->db->select("id as centre_id , nome_centri as centre_name , website_image as centre_image");
			$this->db->from($tableName);
			$this->db->join(TABLE_CENTRE , 'id = centre_id' , 'left');
			if($regionId != '')
				$this->db->where('located_in' , str_replace('_' , ' ' , $regionId));
			$this->db->where("(".$statusFieldName." = 1 AND ".$tableName.".delete_flag=0)");
			$this->db->where('((attivo = 1) or (is_mini_stay = 1 and attivo = 0))');
			$returnArr['centre'] = $this->db->get()->result_array();
			return $returnArr;
		}

		/**
		*Function is used to get course details form database and show on the homepage
		*
		*@param Integer $languageId : Language id (Default is english)
		*@return Array
		*/
		public function getCourseDetails($languageId = NULL)
		{
			return $this->db->select('a.course_master_id , a.course_front_image , b.course_name')
							->from(TABLE_COURSE_MASTER . ' a')
							->join(TABLE_COURSE_LANGUAGE . ' b' , 'a.course_master_id = b.course_id AND b.language_id = '.$languageId , 'left')
							->where('a.course_status' , 1)
							->where('a.delete_flag' , 0)
							->get()->result_array();
		}
	}
