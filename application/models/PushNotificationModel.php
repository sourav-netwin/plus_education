<?php
	/**
	*This class is used to manage the database related operations for push notification functionality
	*
	*@category Model
	*@author S.D
	*@since 25th May , 2018
	*/
	class PushNotificationModel extends CI_Model
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the user device data from database
		*
		*@access public
		*@author S.D
		*@since 25th May , 2018
		*@param Integer $userIdArr : The user id array
		*@return Array $returnArr : The details array
		*/
		public function getUserDeviceData($userIdArr = array())
		{
			$this->db->select('user_device_id , user_id , device_id , device_type');
			$this->db->where_in('user_id' , $userIdArr);
			return $this->db->get(TABLE_USER_DEVICES)->result_array();
		}

		/**
		*This function is used to save the notification history in the database
		*
		*@access public
		*@author S.D
		*@since 29th May , 2018
		*@param mixed $sendMessage : The send data
		*@param mixed $responseMessage : The response data
		*@param String $users : The users
		*@return Integer
		*/
		public function saveNotificationHistory($sendMessage = NULL , $responseMessage = NULL , $users = NULL)
		{
			$insertData = array(
				'message_string' => $sendMessage,
				'response_string' => $responseMessage,
				'user_list' => $users
			);
			$this->db->insert(TABLE_PUSH_NOTIFICATION_HISTORY , $insertData);
			return $this->db->insert_id();
		}

		/**
		*This function is used to save the user wise notification data
		*
		*@access public
		*@author S.D
		*@since 29th May , 2018
		*@param Array $data : The notification data
		*@param Array $userArr : The user array
		*@param Integer $notificationHistoryId : notification history id
		*@param Array $idArr : The user device id array
		*@return Boolean
		*/
		public function saveUserNotification($data = array() , $userArr = array() , $notificationHistoryId = NULL , $idArr = array())
		{
			if(!empty($userArr))
			{
				foreach($userArr as $key => $userId)
				{
					$insertData = array(
						'title' => $data['title'],
						'message' => $data['message'],
						'user_id' => $userId,
						'created_on' => date('Y-m-d H:i:s'),
						'notification_type' => $data['notification_type'],
						'push_notification_history_id' => $notificationHistoryId,
						'user_device_id' => $idArr[$key]
					);
					$this->db->insert(TABLE_USER_NOTIFICATION , $insertData);
				}
			}
			return TRUE;
		}
	}
