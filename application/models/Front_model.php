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
			$this->db->from(TABLE_JUNIOR_CENTRE);
			$this->db->join(TABLE_CENTRE , 'id = centre_id' , 'left');
			if($regionId != '')
				$this->db->where('located_in' , str_replace('_' , ' ' , $regionId));
			$this->db->where('attivo' , 1);
			$returnArr['centre'] = $this->db->get()->result_array();
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
			$result['addon'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_CENTRE_ADDON. ' a')
										->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['factsheet'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_CENTRE_FACTSHEET. ' a')
										->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['activity_program'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_CENTRE_ACTIVITY_PROGRAM. ' a')
										->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['menu'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_CENTRE_MENU. ' a')
										->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['walking_tour'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_CENTRE_WALKING_TOUR. ' a')
										->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['social_program_sports'] = $this->db->select('jn_cpsg_text as details')
													->where('jn_cpsg_idc' , $centreId)
													->where('jn_cpsg_ids' , 6)
													->get(TABLE_CENTRI_PSG)->row_array();
			$result['travel_card'] = $this->db->select('jn_cpsg_text as details')
													->where('jn_cpsg_idc' , $centreId)
													->where('jn_cpsg_ids' , 8)
													->get(TABLE_CENTRI_PSG)->row_array();
			$result['dates'] = $this->db->select("a.date , a.overnight ,
													(select GROUP_CONCAT(b.week) from ".TABLE_JUNIOR_CENTRE_DATES_WEEK." b
													where a.junior_centre_dates_id=b.junior_centre_dates_id) as week , (select
													group_concat(d.program_course_name) from ".TABLE_JUNIOR_CENTRE_DATES_PROGRAM."
													c join ".TABLE_PROGRAM_COURSE." d on c.program_id=d.program_course_id where
													a.junior_centre_dates_id=c.junior_centre_dates_id) as program")
										->from(TABLE_JUNIOR_CENTRE_DATES.' a')
										->join(TABLE_JUNIOR_CENTRE.' e' , 'a.junior_centre_id = e.junior_centre_id' , 'left')
										->where('e.centre_id' , $centreId)
										->get()->result_array();
			$result['accomodation'] = $this->db->select('cont_content as details')
												->where('cont_menuid' , 9)
												->get(TABLE_CONTENT_MST)->row_array();
			$result['plus_team'] = $this->db->select('cont_content as details')
												->where('cont_menuid' , 10)
												->get(TABLE_CONTENT_MST)->row_array();
			$result['photo_gallery'] = $this->db->select('a.short_description , a.description , a.photo')
												->from(TABLE_JUNIOR_CENTRE_PHOTO_GALLERY.' a')
												->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
												->where('b.centre_id' , $centreId)
												->get()->result_array();
			$result['video_gallery'] = $this->db->select('a.video_url , a.description , a.video_image')
												->from(TABLE_JUNIOR_CENTRE_VIDEO_GALLERY.' a')
												->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
												->where('b.centre_id' , $centreId)
												->get()->result_array();
			$result['international_mix'] = $this->db->select('a.country_name , a.percentage , a.color_code')
													->from(TABLE_JUNIOR_CENTRE_INTERNATIONAL_MIX.' a')
													->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
													->where('b.centre_id' , $centreId)
													->get()->result_array();
			$result['course'] = $this->db->select('cont_content as details')
												->where('cont_menuid' , 11)
												->get(TABLE_CONTENT_MST)->row_array();
			return $result;
		}
	}
?>