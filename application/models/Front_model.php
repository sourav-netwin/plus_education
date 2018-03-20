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