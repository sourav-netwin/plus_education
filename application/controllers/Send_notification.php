<?php
	/**
	*This controller is used to send the push notification for student's survey after 5
	*and 12 days later of student's arrival on the campus . This file will run as cron .
	*
	*@category Controller
	*@author S.D
	*@since 6th June , 2018
	*/
	class Send_notification extends CI_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Front_model' , '' , TRUE);
			$this->lang->load('message' , 'english');
			$this->load->library('notification');
		}

		/**
		*This function is used to send the first notification means after 5 days
		*
		*@author S.D
		*@since 6th June , 2018
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function first_notification()
		{
			$this->prepare(5);
		}

		/**
		*This function is used to send the second notification means after 12 days
		*
		*@author S.D
		*@since 6th June , 2018
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function second_notification()
		{
			$this->prepare(12);
		}

		/**
		*This function is used to prepare users to send notification dynamically
		*
		*@author S.D
		*@since 6th June , 2018
		*@access private
		*@param Integer $day : The interval day
		*@return NONE
		*/
		private function prepare($day = NULL)
		{
			$result = $this->Front_model->commonGetData('uuid' , "datediff('".date('Y-m-d')."' , date_format(data_arrivo_campus , '%Y-%m-%d')) = ".$day." AND tipo_pax='STD'" , TABLE_PLUSED_ROWS , 'id_prenotazione' , 'asc' , 2);
			if(!empty($result))
			{
				foreach($result as $value)
					$userIdArr[] = $value['uuid'];
				$notificationData = array(
					'title' => $this->lang->line('available_survey_title'),
					'message' => $this->lang->line('survey_notification_message'),
					'notification_type' => $this->lang->line('survey_notification_type')
				);
				$this->notification->initialize($userIdArr , $notificationData);
			}

		}
	}
