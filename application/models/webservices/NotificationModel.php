<?php
	/**
	*This class is used to manage all the notification related operations in the database
	*
	*@author S.D
	*@category Model
	*@since 1st June , 2018
	*@package NotificationModel.php
	*/
	class NotificationModel extends CI_Model
	{
		//This is constructor
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the notification details from database
		*
		*@author S.D
		*@since 1st june , 2018
		*@access public
		*@param String $uuid : The user uuid
		*@param String $deviceType : The device type(A/I)
		*@return Array
		*/
		public function getNotificationDetails($uuid = NULL , $deviceType = NULL)
		{
			return $this->db->select('a.user_notification_id , a.title , a.message , a.created_on')
					->from(TABLE_USER_NOTIFICATION.' a')
					->join(TABLE_USER_DEVICES.' b' , 'a.user_device_id = b.user_device_id' , 'left')
					->where('b.user_id' , $uuid)
					->where('b.device_type' , $deviceType)
					->where('a.is_read' , 0)
					->get()->result_array();
		}

		/**
		*This function is used to change the read status for a notification in the database
		*
		*@author S.D
		*@since 1st june , 2018
		*@access public
		*@param Interger $notificatioId : The notification id
		*@return NONE
		*/
		public function makeRead($notificatioId = NULL)
		{
			$data = array(
				'is_read' => 1
			);
			$this->db->where('user_notification_id' , $notificatioId)
					->update(TABLE_USER_NOTIFICATION , $data);
		}
	}
