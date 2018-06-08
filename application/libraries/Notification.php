<?php
	/**
	*This class is used to manage all the push notification functionality for
	*both android and ios devices
	*
	*@author S.D
	*@category Library
	*@since 29th May , 2018
	*/
	class Notification
	{
		//This is the global instance
		private $ci;

		//This is the constructor
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->ci->load->model('PushNotificationModel' , '' , TRUE);
		}

		/**
		*This function is used to prepare push notification data and user and send accordingly
		*
		*@access public
		*@author S.D
		*@since 29th May , 2018
		*@param Array $userIdArr
		*@param Array $data
		*@return NONE
		*/
		public function initialize($userIdArr = array() , $data = array())
		{
			$userData = $this->ci->PushNotificationModel->getUserDeviceData($userIdArr);
			$androidUser = $iosUser = array();

			//Store users depending upon devices : android or ios
			if(!empty($userData))
			{
				foreach($userData as $userValue)
				{
					if($userValue['device_type'] == 'A')
						$androidUser[] = $userValue;
					elseif($userValue['device_type'] == 'I')
						$iosUser[] = $userValue;
				}
			}

			//Here is the notification messages need to push
			$notificationMessageArr = array(
				'title' => $data['title'],
				'message' => $data['message']
			);

			//Send notification for android
			if(!empty($androidUser))
			{
				$groupUserdata = $this->groupUserData($androidUser);
				$deviceTokenArray = $groupUserdata['deviceTokenArray'];
				$deviceUserIdArr = $groupUserdata['deviceUserIdArr'];
				$deviceIdArr = $groupUserdata['deviceIdArr'];

				if(!empty($deviceTokenArray))
				{
					foreach($deviceTokenArray as $key => $tokenValue)
					{
						$notificationHistoryId = $this->pushNotificationAndroid($tokenValue , $notificationMessageArr , $deviceIdArr[$key]);
						//Save the notification data user wise in the DB
						$this->ci->PushNotificationModel->saveUserNotification($data , $deviceUserIdArr[$key] , $notificationHistoryId , $deviceIdArr[$key]);
					}
				}
			}
			//Send notification for ios
			if(!empty($iosUser))
			{
				$groupUserdata = $this->groupUserData($iosUser);
				$deviceTokenArray = $groupUserdata['deviceTokenArray'];
				$deviceUserIdArr = $groupUserdata['deviceUserIdArr'];
				$deviceIdArr = $groupUserdata['deviceIdArr'];

				if(!empty($deviceTokenArray))
				{
					foreach($deviceTokenArray as $key => $tokenValue)
					{
						$notificationHistoryId = $this->pushNotificationIos($tokenValue , $notificationMessageArr , $deviceIdArr[$key]);
						//Save the notification data user wise in the DB
						$this->ci->PushNotificationModel->saveUserNotification($data , $deviceUserIdArr[$key] , $notificationHistoryId , $deviceIdArr[$key]);
					}
				}
			}
		}

		/**
		*This function is used to create groupping for user data as per the max fcm limit
		*
		*@access private
		*@author S.D
		*@since 29th May , 2018
		*@param Array $userIdArr
		*@return Array : groupped array
		*/
		private function groupUserData($userIdArr = array())
		{
			$tempCount = 1;
			$tempGroup = 0;
			$returnArr = array();
			foreach($userIdArr as $userValue)
			{
				$returnArr['deviceTokenArray'][$tempGroup][] = $userValue['device_id'];
				$returnArr['deviceUserIdArr'][$tempGroup][] = $userValue['user_id'];
				$returnArr['deviceIdArr'][$tempGroup][] = $userValue['user_device_id'];
				if(FCM_MAX_LIMIT === $tempCount)
				{
					$tempCount = 1;
					$tempGroup++;
				}
				else
					$tempCount++;
			}
			return $returnArr;
		}

		/**
		*This function is used to send push notification for android device
		*
		*@access private
		*@author S.D
		*@since 29th May , 2018
		*@param Array $deviceTokenArr : The device token array
		*@param Array $data : The pushed data(title & message)
		*@param Array $deviceIdArr : The device id array
		*@return NONE
		*/
		private function pushNotificationAndroid($deviceTokenArr = array() , $data = array() , $deviceIdArr = array())
		{
			$responseStr = '';
			$fields = array(
				'registration_ids' => $deviceTokenArr,
				'data' => $data
			);
			$headers = array(
				'Authorization:key=' . GOOGLE_FCM_KEY,
				'Content-Type: application/json'
			);
			return $this->callCurl($fields , $headers , $deviceTokenArr , $deviceIdArr);
		}

		/**
		*This function is used to send push notification for ios device
		*
		*@access private
		*@author S.D
		*@since 29th May , 2018
		*@param Array $deviceTokenArr : The device token array
		*@param Array $data : The pushed data(title & message)
		*@param Array $deviceIdArr : The device id array
		*@return NONE
		*/
		private function pushNotificationIos($deviceTokenArr = array() , $data = array() , $deviceIdArr = array())
		{
			$responseStr = '';
			$fields = array(
				'registration_ids' => $deviceTokenArr,
				'notification' => array(
					'body' => $data['message'],
					'title' => $data['title'],
					'sound' => "default",
				)
			);
			$headers = array(
				'Authorization:key=' . IOS_FCM_KEY,
				'Content-Type: application/json'
			);
			return $this->callCurl($fields , $headers , $deviceTokenArr , $deviceIdArr);
		}

		/**
		*This function is used to call google fcm url through curl to send the notification to the real
		*devices . Also it will insert the notification history details in the DB .
		*
		*@access private
		*@author S.D
		*@since 29th May , 2018
		*@param Array $fields : The fields array
		*@param Array $headers : The headers array
		*@param Array $deviceTokenArr :  The device token array
		*@param Array $deviceIdArr : The device id array
		*@return Integer : The notification history id
		*/
		private function callCurl($fields = array() , $headers = array() , $deviceTokenArr = array() , $deviceIdArr = array())
		{
			$responseStr = '';
			$ch = curl_init();
			curl_setopt($ch , CURLOPT_URL , FCM_ANDROID_URL);
			curl_setopt($ch , CURLOPT_POST , true);
			curl_setopt($ch , CURLOPT_HTTPHEADER , $headers);
			curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
			curl_setopt($ch , CURLOPT_SSL_VERIFYHOST , 0);
			curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
			curl_setopt($ch , CURLOPT_POSTFIELDS , json_encode($fields));
			$result = curl_exec($ch);
			curl_close($ch);

			if($result === FALSE)
				$responseStr = 'Curl failed: '.curl_error($ch);
			else
				$responseStr = $result;

			//Save the notification history in the DB
			$notificationHistoryId = $this->ci->PushNotificationModel->saveNotificationHistory(json_encode($fields) , $responseStr , implode(' , ' , $deviceIdArr));
			return $notificationHistoryId;
		}
	}
