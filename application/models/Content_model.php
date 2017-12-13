<?php
	class Content_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		//This function is used to get the top header menu details from database as per the admin panel CMS section
		public function getTopheaderMenu()
		{
			$returnArr = array();
			$result = $this->db->select('mnu_menuid as id , mnu_parent_menu_id as parent_id , mnu_menu_name as name , cont_url_name as url')
							->join(TABLE_CONTENT_MST , 'cont_menuid = mnu_menuid' , 'left')
							->where('mnu_type' , 'Top')
							->order_by('mnu_sequence')
							->get(TABLE_MENU_MST)->result_array();
			if(!empty($result))
			{
				foreach($result as $key => $value)
					$menuNameArr[$value['id']] = array(
						'name' => $value['name'],
						'url' => $value['url']
					);

				foreach($result as $key => $value)
				{
					if($value['parent_id'] != 0)
					{
						unset($result[$key]);
						$referenceArr[$value['parent_id']][] = $menuNameArr[$value['id']];
					}
				}
				foreach($result as $key => $value)
				{
					$returnArr[$key]['name'] = $value['name'];
					$returnArr[$key]['url'] = $value['url'];
					if (array_key_exists($value['id'] , $referenceArr))
						$returnArr[$key]['submenu'] = $referenceArr[$value['id']];
				}
			}
			return array_merge($returnArr);
		}

		//This function is used to get the details of cms pages from database
		function getCmsPageDetails($pageName = NULL)
		{
			return $this->db->select('cont_browser_title , cont_page_title , cont_meta_description , cont_keywords ,
								cont_content')
							->where('cont_url_name' , $pageName)
							->get(TABLE_CONTENT_MST)->row_array();
		}
	}
