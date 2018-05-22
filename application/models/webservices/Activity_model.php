<?php
	/**
	*This class is used to manage all the database related operations for activity webservice
	*
	*@author S.D
	*@category Model
	*@package Activity_model.php
	*/
	class Activity_model extends CI_Model
	{
		//This is constructor
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the activity details for one centre
		*
		*@access public
		*@param Integer $centreId : The centre id
		*@return Array
		*/
		public function getActivityDetails($centreId = NULL)
		{
			$returnArr = array();
			$result = $this->db->select("a.plus_activity_id as id , a.name , a.description , date_format(a.added_date , '%d-%m-%Y') as date ,
										 a.show_type , a.show_text , b.image_name")
							->from(TABLE_PLUS_ACTIVITY_MANAGEMENT.' a')
							->join(TABLE_ACTIVITY_PHOTO_GALLERY.' b' , 'a.front_image = b.activity_photo_gallery_id' , 'left')
							->where('a.centre_id' , $centreId)
							->where('a.status' , 1)
							->where('a.delete_flag' , 0)
							->order_by('a.sequence' , 'asc')
							->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$returnArr[$key] = $value;
					$returnArr[$key]['description'] = strip_tags($value['description']);
					$returnArr[$key]['fixed_background_image'] =  base_url().'images/bg_image.jpg';
					$returnArr[$key]['image_name'] = ADMIN_PANEL_URL.ACTIVITY_PHOTOGALLERY_IMAGE_PATH.$value['image_name'];
					$returnArr[$key]['files'] = $this->getActivityFiles($value['id']);
				}
			}
			return $returnArr;
		}

		/**
		*This function is used to get the multiple file details against one activity
		*
		*@access private
		*@param Ineger $id : Activity id
		*@return Array
		*/
		private function getActivityFiles($id = NULL)
		{
			$returnArr = array();
			$result = $this->db->select('file_name')
							->where('plus_activity_id' , $id)
							->get(TABLE_PLUS_ACTIVITY_MANAGEMENT_FILES)->result_array();
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$returnArr[$key]['filePath'] = ADMIN_PANEL_URL.ACTIVITY_FILE_PATH.$value['file_name'];
					$returnArr[$key]['fileExtension'] = pathinfo($value['file_name'] , PATHINFO_EXTENSION);
				}
			}
			return $returnArr;
		}
	}
