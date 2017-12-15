<?php
	class Content_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		//This function is used to get the top header menu details from database as per the admin panel CMS section
		public function getTopheaderMenu($parentId = 0)
		{
			$returnArr = array();
			$result = $this->db->select('mnu_menuid as id , mnu_parent_menu_id as parent_id , mnu_menu_name as name ,
										 cont_url_name as url , cont_content_type as type , cont_pdf_file as pdf , cont_external_url
										  as external_url')
							->join(TABLE_CONTENT_MST , 'cont_menuid = mnu_menuid' , 'left')
							->where('mnu_type' , 'Top')
							->where('mnu_parent_menu_id' , $parentId)
							->order_by('mnu_sequence')
							->get(TABLE_MENU_MST)->result_array();
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					if($value['id'])
					{
						$childArr = $this->getTopheaderMenu($value['id'] , $returnArr);
						if($childArr)
							$value['submenu'] = $childArr;
						array_push($returnArr , $value);
					}
				}
			}
			return $returnArr;
		}

		//This function is used to get the details of cms pages from database
		function getCmsPageDetails($pageName = NULL)
		{
			return $this->db->select('cont_browser_title , cont_page_title , cont_meta_description , cont_keywords ,
								cont_content')
							->where('cont_url_name' , $pageName)
							->get(TABLE_CONTENT_MST)->row_array();
		}

		//This function is used to get the header menu details from database as per the junior centre management
		function getHeaderMenuDetails()
		{
			$returnArr = array(
				'usaSummerProgram' => array(),
				'europeSummerProgram' => array()
			);
			$result = $this->db->select('b.id as id , b.nome_centri as centre , b.located_in as region , d.program_course_name as program')
								->from(TABLE_JUNIOR_CENTRE.' a')
								->join(TABLE_CENTRE.' b' , 'a.centre_id = b.id' , 'left')
								->join(TABLE_JUNIOR_CENTRE_PROGRAM.' c' , 'c.junior_centre_id = a.junior_centre_id' , 'left')
								->join(TABLE_PROGRAM_COURSE.' d' , 'c.program_id = d.program_course_id' , 'left')
								->where('a.junior_centre_status' , 1)
								->where('a.delete_flag' , 0)
								->order_by('b.nome_centri')
								->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$programWiseMenu[str_replace(' ' , '_' , $value['program'])][] = $value;

				//Separate junior usa summer courses
				$juniorUsaPrograms = array(
					'EXPERIENCE' => $programWiseMenu['EXPERIENCE'],
					'CLASSIC_SUPERIOR' => $programWiseMenu['CLASSIC_SUPERIOR']
				);
				unset($programWiseMenu['EXPERIENCE']);
				unset($programWiseMenu['CLASSIC_SUPERIOR']);

				foreach($programWiseMenu as $key => $value)
				{
					foreach($value as $subvalue)
						$juniorEuropePrograms[$key][str_replace(' ' , '_' , $subvalue['region'])][] = $subvalue;
				}

				$returnArr = array(
					'usaSummerProgram' => $juniorUsaPrograms,
					'europeSummerProgram' => $juniorEuropePrograms
				);
			}
			return $returnArr;
		}

		//This function is used to get the details of footer menu details from DB as per the admin panel CMS
		function getFooterDetails($parentId = 0)
		{
			$returnArr = array();
			$result = $this->db->select('mnu_menuid as id , mnu_parent_menu_id as parent_id , mnu_menu_name as name ,
										 cont_url_name as url , cont_content_type as type , cont_pdf_file as pdf , cont_external_url
										  as external_url')
							->join(TABLE_CONTENT_MST , 'cont_menuid = mnu_menuid' , 'left')
							->where('mnu_type' , 'Footer')
							->where('mnu_parent_menu_id' , $parentId)
							->order_by('mnu_sequence')
							->get(TABLE_MENU_MST)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
				{
					$subMenuArr = $this->getFooterDetails($value['id']);
					if(!empty($subMenuArr))
						$value['subMenu'] = $subMenuArr;
					array_push($returnArr , $value);
				}
			}
			return $returnArr;
		}

		//This function isused to get the footer address from DB as per the CMS section
		function getFooterAddress()
		{
			$result = $this->db->select('cont_content as address')
								->where('cont_contentid' , 9)
								->get(TABLE_CONTENT_MST)->row_array();
			return $result['address'];
		}
	}
