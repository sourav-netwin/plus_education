<?php
	class Front_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->config->load('cms_static_id');
		}

		//This function is ysed to get program details to show banner in front end
		public function getBannerDetails($languageId = NULL)
		{
			$this->db->select('a.program_id , a.program_image , b.program_title , b.program_short_description , b.more_link');
			$this->db->from(TABLE_PROGRAM . ' a');
			$this->db->join(TABLE_PROGRAM_LANGUAGE . ' b' , 'a.program_id = b.program_id AND b.language_id = '.$languageId , 'left');
			$this->db->where('a.program_status' , 1);
			$this->db->where('a.delete_flag' , 0);
			return $this->db->get()->result_array();
		}

		//This function is used to get the details of courses from DB as added from back-end
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

		//Function is used to get all destination details for courses (region and centre)
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
		function getJuniorCentreDetails($centreName = NULL)
		{
			$result = $this->db->select('a.centre_id , a.junior_centre_id , b.nome_centri as centre_name , a.centre_banner , b.page_1 as centre_description ,
										b.center_latitude as centre_latitude , b.center_longitude as centre_longitude , b.school_name , b.address , b.post_code,
										a.accommodation , a.course')
							->from(TABLE_JUNIOR_CENTRE.' a')
							->join(TABLE_CENTRE.' b' , 'a.centre_id = b.id' , 'left')
							->where('b.nome_centri' , str_replace('-' , ' ' , $centreName))
							->get()->row_array();
			$centreId = $result['centre_id'];
			$result['program'] = $this->db->select('a.program_id , b.program_course_name , a.program_details as program_course_description , b.program_course_logo , b.sequence_slug')
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
													(select GROUP_CONCAT(b.week order by b.week) from ".TABLE_JUNIOR_CENTRE_DATES_WEEK." b
													where a.junior_centre_dates_id=b.junior_centre_dates_id) as week , (select
													group_concat(d.program_course_name) from ".TABLE_JUNIOR_CENTRE_DATES_PROGRAM."
													c join ".TABLE_PROGRAM_COURSE." d on c.program_id=d.program_course_id where
													a.junior_centre_dates_id=c.junior_centre_dates_id) as program")
										->from(TABLE_JUNIOR_CENTRE_DATES.' a')
										->join(TABLE_JUNIOR_CENTRE.' e' , 'a.junior_centre_id = e.junior_centre_id' , 'left')
										->where('e.centre_id' , $centreId)
										->order_by('a.date' , 'asc')
										->get()->result_array();
			$result['plus_team'] = $this->db->select('cont_content as details')
												->where('cont_menuid' , $this->config->item('plusTeamCmsId'))
												->get(TABLE_CONTENT_MST)->row_array();
			$result['photo_gallery'] = $this->db->select('a.short_description , a.description , a.photo')
												->from(TABLE_JUNIOR_CENTRE_PHOTO_GALLERY.' a')
												->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
												->where('b.centre_id' , $centreId)
												->order_by('a.sequence' , 'asc')
												->get()->result_array();
			$result['video_gallery'] = $this->db->select('a.video_url , a.description , a.video_image')
												->from(TABLE_JUNIOR_CENTRE_VIDEO_GALLERY.' a')
												->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
												->where('b.centre_id' , $centreId)
												->order_by('a.sequence' , 'asc')
												->get()->result_array();
			$result['international_mix'] = $this->db->select('a.country_name , a.percentage , a.color_code')
													->from(TABLE_JUNIOR_CENTRE_INTERNATIONAL_MIX.' a')
													->join(TABLE_JUNIOR_CENTRE.' b' , 'a.junior_centre_id = b.junior_centre_id' , 'left')
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

		//This function is used to get the junior mini stay sentre details from DB
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

		//This function is used to get the program details from DB for all programs(including add on)
		function getProgramDetails()
		{
			$programDetails = $this->db->select("program_course_name as name , program_course_description as description ,
										concat('".ADMIN_PANEL_URL.PROGRAM_COURSE_IMAGE_PATH."' , program_course_logo) as logo")
							->where(array(
										'program_course_status' => 1,
										'delete_flag' => 0
									))
							->get(TABLE_PROGRAM_COURSE)->result_array();
			$addonDetails = $this->db->select("'Add on' as name , cont_content as description,
												'".ADMIN_PANEL_URL.PROGRAM_COURSE_IMAGE_PATH."addon.jpg' as logo")
									->where('cont_menuid' , $this->config->item('addOnCmsId'))
									->get(TABLE_CONTENT_MST)->row_array();
			array_push($programDetails , $addonDetails);
			return $programDetails;
		}

		//This is a common function used to get the data from database
		function commonGetData($select = NULL , $whereCondition = NULL , $tableName = NULL , $orderByField = NULL , $orderByType = 'asc' , $flag = 1)
		{
			if($select != '')
				$this->db->select($select);
			if($whereCondition != '')
				$this->db->where($whereCondition);
			if($orderByField != '')
				$this->db->order_by($orderByField , $orderByType);
			if($flag == 1)
				return $this->db->get($tableName)->row_array();
			else
				return $this->db->get($tableName)->result_array();
		}

		//This is a common function to add data in database
		function commonAdd($tableName = NULL , $data = NULL)
		{
			if($tableName != '')
				$this->db->insert($tableName , $data);
			return $this->db->insert_id();
		}

		//This function is used to check the authentication for plus walking tour section
		function verify()
		{
			$fieldName = ($this->input->post('campusManager') == 1) ? 'manager_password' : 'password';
			return $this->db->select('id , nome_centri , centre_banner , path')
							->join(TABLE_CENTRE , 'id=centre' , 'left')
							->join("((SELECT centre_id , centre_banner , '".JUNIOR_MINISTAY_IMAGE_PATH."' as path from frontweb_junior_ministay)union (select centre_id , centre_banner , '".JUNIOR_CENTRE_IMAGE_PATH."' as path from frontweb_junior_centre))t" , 't.centre_id=id' , 'left')
							->where('centre' , $this->input->post('centre'))
							->where($fieldName , base64_decode($this->input->post('userPassword')))
							->get(TABLE_PLUS_VIDEO)->row_array();
		}

		//This function is used to get activity details from DB and show through datatable
		function getActivityDetails()
		{
			$resultData = array();
			$colomnArr = array('a.plus_activity_id' , 'a.name' , 'b.nome_centri' , 'a.added_date' , 'a.status' , 'a.front_image');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_PLUS_ACTIVITY_MANAGEMENT . ' a');
			$this->db->join(TABLE_CENTRE.' b' , 'a.centre_id = b.id' , 'left');
			$this->db->where('a.delete_flag' , 0);
			if($this->session->userdata('centre_id') != '')
				$this->db->where('b.id' , $this->session->userdata('centre_id'));
			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().'manage_activity/add_edit/'.$value['plus_activity_id'].'" data-toggle="tooltip" data-original-title="Edit Activity"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a class="btn btn-xs btn-danger btn-wd-24" href="'.base_url().'manage_activity/delete/'.$value['plus_activity_id'].'" onclick="return confirm_delete()" data-toggle="tooltip" data-original-title="Delete activity"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					$statusClass = ($value['status'] == 1) ? 'fa-check-square-o' : 'fa-square-o';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Change Status for activity" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon"><span><i class="fa '.$statusClass.'" aria-hidden="true" data-toggle="modal" data-target="#juniorCentreStatus" data-status_type = '.$value['status'].' data-activity_id = '.$value['plus_activity_id'].' ></i></span></a>';
					$actionStr .="</div>";

					$resultData[] = array(
						0 => $siNo++,
						1 => $value['name'],
						2 => $value['nome_centri'],
						3 => date('d-m-Y' , strtotime($value['added_date'])),
						4 => $actionStr
					);
				}
			}
			return $resultData;
		}

		//This is a common function to update record to database
		function commonUpdate($tableName = NULL , $whreCondition = NULL , $data = NULL)
		{
			if($tableName != '')
			{
				$this->db->where($whreCondition)
						->update($tableName , $data);
			}
		}

		//This is a common function to delete record from database
		function commonDelete($tableName = NULL , $whreCondition = NULL)
		{
			if($tableName != '')
			{
				$this->db->where($whreCondition)
						->delete($tableName);
			}
		}
	}
?>