<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/*
	*Author : S.D
	*Purpose : Get the notification details to show in the aap
	*Date : 1-06-2018
	*/
	class Notification extends REST_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->config->load('cms_static_id');
			$this->lang->load('message' , 'english');
			$this->load->model('webservices/NotificationModel' , '' , TRUE);

			$apiKey = $this->post('api_key');
			validateApiKey($apiKey);
			$data = array();
		}

		/**
		*This function is used to get the notification details
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function get_notification_post()
		{
			$uuid = $this->post('uuid');
			$deviceType = $this->post('deviceType');
			if(!empty($uuid) && !empty($deviceType))
			{
				$notificationDetailsArr = array();
				$result = $this->NotificationModel->getNotificationDetails($uuid , $deviceType);
				if(!empty($result))
				{
					foreach($result as $key => $value)
					{
						$notificationDetailsArr[$key] = array(
							'notificationId' => $value['user_notification_id'],
							'notificationTitle' => $value['title'],
							'notificationMessage' => $value['message'],
							'notificationDate' => date('H:m , d/m/Y' , strtotime($value['created_on']))
						);
					}
				}
				$data['notificationDetails'] = $notificationDetailsArr;
				$data['status'] = $this->lang->line('SUCCESS');
				$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('please_pass_required');
			}
			$this->response($data , 200);
		}

		/**
		*This function is used to change the flag in the database to read a notification
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function read_notification_post()
		{
			$notificatioId = $this->post('notificationId');
			if(!empty($notificatioId))
			{
				$this->NotificationModel->makeRead($notificatioId);
				$data['status'] = $this->lang->line('SUCCESS');
				$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('please_pass_required');
			}
			$this->response($data , 200);
		}
	}

