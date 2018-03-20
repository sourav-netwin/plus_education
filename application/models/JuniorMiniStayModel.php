<?php
	/**
	*This class is used to manage the database related operations for the junior mini stay module
	*
	*@category Model
	*@author S.D
	*/
	class JuniorMiniStayModel extends CI_Model
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the junior mini stay sentre details from DB
		*
		*@param String $centreName : The name of the centre
		*@return Array $result : The details array
		*/
		function getJuniorMiniStayDetails($centreName = NULL)
		{
			$result = $this->db->select('a.centre_id , a.junior_ministay_id , b.nome_centri as centre_name , a.centre_banner , b.page_1 as centre_description ,
										b.center_latitude as centre_latitude , b.center_longitude as centre_longitude , a.accomodation_show_flag ,
										a.plus_team_show_flag , a.course_show_flag , b.school_name , b.address , b.post_code,a.accommodation , a.course')
							->from(TABLE_JUNIOR_MINISTAY.' a')
							->join(TABLE_CENTRE.' b' , 'a.centre_id = b.id' , 'left')
							->where('b.nome_centri' , str_replace('-' , ' ' , $centreName))
							->get()->row_array();
			$centreId = $result['centre_id'];
			$result['photo_gallery'] = $this->db->select('a.short_description , a.description , a.photo')
												->from(TABLE_JUNIOR_MINISTAY_PHOTOGALLERY.' a')
												->join(TABLE_JUNIOR_MINISTAY.' b' , 'a.junior_ministay_id = b.junior_ministay_id' , 'left')
												->where('b.centre_id' , $centreId)
												->order_by('a.sequence' , 'asc')
												->get()->result_array();
			$result['video_gallery'] = $this->db->select('a.video_url , a.description , a.video_image')
												->from(TABLE_JUNIOR_MINISTAY_VIDEO_GALLERY.' a')
												->join(TABLE_JUNIOR_MINISTAY.' b' , 'a.junior_ministay_id = b.junior_ministay_id' , 'left')
												->where('b.centre_id' , $centreId)
												->order_by('a.sequence' , 'asc')
												->get()->result_array();
			$result['accommodation'] = ($result['accomodation_show_flag'] == 1) ? $result['accommodation'] : '';
			$result['course'] = ($result['course_show_flag'] == 1) ? $result['course'] : '';
			if($result['plus_team_show_flag'] == 1)
				$result['plus_team'] = $this->db->select('cont_content as details')
													->where('cont_menuid' , $this->config->item('plusTeamCmsId'))
													->get(TABLE_CONTENT_MST)->row_array();
			$result['factsheet'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_MINISTAY_FACT_SHEET. ' a')
										->join(TABLE_JUNIOR_MINISTAY.' b' , 'a.junior_ministay_id = b.junior_ministay_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['activity_program'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_MINISTAY_ACTIVITY_PROGRAM. ' a')
										->join(TABLE_JUNIOR_MINISTAY.' b' , 'a.junior_ministay_id = b.junior_ministay_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['menu'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_MINISTAY_MENU. ' a')
										->join(TABLE_JUNIOR_MINISTAY.' b' , 'a.junior_ministay_id = b.junior_ministay_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['walking_tour'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_MINISTAY_WALKING_TOUR. ' a')
										->join(TABLE_JUNIOR_MINISTAY.' b' , 'a.junior_ministay_id = b.junior_ministay_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['addon'] = $this->db->select('a.file_name , a.file_description')
										->from(TABLE_JUNIOR_MINISTAY_ADDON. ' a')
										->join(TABLE_JUNIOR_MINISTAY.' b' , 'a.junior_ministay_id = b.junior_ministay_id' , 'left')
										->where('b.centre_id' , $centreId)
										->get()->result_array();
			$result['program'] = $this->db->select('a.program_id , b.program_course_name , a.program_details as program_course_description , b.program_course_logo , b.sequence_slug')
										->from(TABLE_JUNIOR_MINISTAY_PROGRAM.' a')
										->join(TABLE_PROGRAM_COURSE.' b' , 'a.program_id = b.program_course_id' , 'left')
										->where('a.junior_ministay_id' , $result['junior_ministay_id'])
										->get()->result_array();
			$result['dates'] = $this->db->select("a.date , a.overnight ,
													(select GROUP_CONCAT(b.week order by b.week) from ".TABLE_JUNIOR_MINISTAY_DATES_WEEK." b
													where a.junior_ministay_dates_id=b.junior_ministay_dates_id) as week , (select
													group_concat(d.program_course_name) from ".TABLE_JUNIOR_MINISTAY_DATES_PROGRAM."
													c join ".TABLE_PROGRAM_COURSE." d on c.program_id=d.program_course_id where
													a.junior_ministay_dates_id=c.junior_ministay_dates_id) as program")
										->from(TABLE_JUNIOR_MINISTAY_DATES.' a')
										->join(TABLE_JUNIOR_MINISTAY.' e' , 'a.junior_ministay_id = e.junior_ministay_id' , 'left')
										->where('e.centre_id' , $centreId)
										->order_by('a.date' , 'asc')
										->get()->result_array();
			$result['international_mix'] = $this->db->select('a.country_name , a.percentage , a.color_code')
													->from(TABLE_JUNIOR_MINISTAY_INTERNATIONAL_MIX.' a')
													->join(TABLE_JUNIOR_MINISTAY.' b' , 'a.junior_ministay_id = b.junior_ministay_id' , 'left')
													->where('b.centre_id' , $centreId)
													->get()->result_array();
			//Customize program array
			$customizeProgram = array();
			if(!empty($result['program']))
			{
				foreach($result['program'] as $value)
					$customizeProgram[$value['sequence_slug']] = $value;
			}
			$result['program'] = $customizeProgram;

			//If addon is availbale for any centre then add one program for addon to show in choose program section
			if(!empty($result['addon']))
				$result['program']['addon'] = array(
					'program_id' => 'addon',
					'program_course_name' => 'ADD ON',
					'program_course_logo' => 'addon.jpg'
				);
			return $result;
		}
	}
