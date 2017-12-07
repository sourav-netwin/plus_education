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
				$returnArr['region'] = $this->db->select('distinct(located_in) as region')
												->where("located_in != ''")
												->where('attivo' , 1)
												->get(TABLE_CENTRE)->result_array();
			$this->db->select("id as centre_id , nome_centri as centre_name , website_image as centre_image");
			if($regionId != '')
				$this->db->where('located_in' , str_replace('_' , ' ' , $regionId));
			$this->db->where('attivo' , 1);
			$returnArr['centre'] = $this->db->get(TABLE_CENTRE)->result_array();
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

		//This function is used to get junior centre details , centre wise and show in details page
		function getJuniorCentreDetails($centreId = NULL)
		{
			$result = $this->db->select('a.junior_centre_id , b.nome_centri as centre_name , a.centre_banner , b.page_1 as centre_description ,
										b.center_latitude as centre_latitude , b.center_longitude as centre_longitude')
							->from(TABLE_JUNIOR_CENTRE.' a')
							->join(TABLE_CENTRE.' b' , 'a.centre_id = b.id' , 'left')
							->where('a.centre_id' , $centreId)
							->get()->row_array();
			$result['program'] = $this->db->select('a.program_id , b.program_course_name , b.program_course_description , b.program_course_logo')
										->from(TABLE_JUNIOR_CENTRE_PROGRAM.' a')
										->join(TABLE_PROGRAM_COURSE.' b' , 'a.program_id = b.program_course_id' , 'left')
										->where('a.junior_centre_id' , $result['junior_centre_id'])
										->get()->result_array();
			return $result;
		}
	}
?>