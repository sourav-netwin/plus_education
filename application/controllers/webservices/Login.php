<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/*
	*Author : S.D
	*Purpose : Login Functionality
	*Date : 26-04-2018
	*Dependency: Login_model.php
	*/
	class Login extends REST_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->lang->load('message' , 'english');
			$this->load->model('webservices/Login_model' , '' , TRUE);
			$this->load->model('Front_model' , '' , TRUE);

			$apiKey = $this->post('api_key');
			validateApiKey($apiKey);
			$returnArr = array();
		}

		/**
		*This function is used to check login for both student and GL . If it found
		*correct user then it will return the user information
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function check_login_post()
		{
			//Type of user(1 : Student & 2 : GL)
			$type = $this->post('type');
			$userFirstName = $this->post('first_name');
			$userSurname = $this->post('surname');
			$userDob = $this->post('dob');
			$userData = array();
			$roleId = $roleName = '';

			//Check the valid date format
			if(isItValidDate($userDob , 'd-m-Y'))
			{
				//For student
				if($type == 1)
				{
					$referenceId = $centreId = $this->post('centre_id');
					$userData = $this->Login_model->checkStudentLogin($userFirstName , $userSurname , $userDob , $centreId);
					//502 = Pax users STD(STUDENTS FOR TEST/SURVEY)
					$roleId = 502;
					$roleName = 'Student';
				}
				//For GL
				elseif($type == 2)
				{
					$bookingId = $this->post('booking_id');
					$userData = $this->Login_model->checkGlLogin($userFirstName , $userSurname , $userDob , $bookingId);
					//501 = Pax users GL(Group Leader)
					$roleId = 501;
					$roleName = 'Group Leader';
					$referenceId = $userData['id_prenotazione'];
				}

				if(!empty($userData))
				{
					//Save the device information(for both android and ios in the database
					$deviceType = $this->post('deviceType');
					$deviceId = $this->post('deviceId');
					if(!empty($deviceType) && !empty($deviceId))
						$this->Login_model->saveDeviceInfo($deviceType , $deviceId , $userData['uuid']);

					$centreInfo = $this->Login_model->getCentreImage($referenceId , $type);
					$returnArr = array(
						'username' => "--",
						'uuid' => $userData['uuid'],
						'pax_dob' => $userData['pax_dob'],
						'mainfirstname' => $userData['nome'],
						'mainfamilyname' => $userData['cognome'],
						'businessname' => $userData['nome'],
						'id' => $userData['id_prenotazione'],
						'email' => '',
						'country' => '',
						'role' => $roleId,
						'ruolo' => $roleName,
						'logged_in' => TRUE,
						'originalCentreImage' => $centreInfo['originalCentreImage'],
						'thumbCentreImage' => $centreInfo['thumbCentreImage'],
						'centre_id' => $centreInfo['centreId'],
						'centreName' => $centreInfo['centreName']
					);
					$returnArr['status'] = $this->lang->line('SUCCESS');
					$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				}
				else
				{
					$returnArr['status'] = $this->lang->line('FAIL');
					$returnArr['message'] = $this->lang->line('invalid_credentials');
				}
			}
			else
			{
				$returnArr['status'] = $this->lang->line('FAIL');
				$returnArr['message'] = $this->lang->line('booking_not_available');
			}
			$this->response($returnArr , 200);
		}

		/**
		*This function is used to get the bookings for Group Leader login with the
		*help of name and date of birth
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function get_booking_post()
		{
			$userFirstName = $this->post('first_name');
			$userSurname = $this->post('surname');
			$userDob = $this->post('dob');
			//Check the valid date format
			if(isItValidDate($userDob , 'd-m-Y'))
			{
				$returnArr['status'] = $this->lang->line('SUCCESS');
				$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				$returnArr['bookings'] = $this->Login_model->getBookingsForLogin($userFirstName , $userSurname , $userDob);
			}
			else
			{
				$returnArr['status'] = $this->lang->line('FAIL');
				$returnArr['message'] = $this->lang->line('booking_not_available');
			}
			$this->response($returnArr , 200);
		}

		/**
		*This function is used to get all the active centre to show in the student's login
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function get_centre_post()
		{
			$returnArr['status'] = $this->lang->line('SUCCESS');
			$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			$returnArr['centre'] = $this->Login_model->getCentreDetails();
			$this->response($returnArr , 200);
		}

		/**
		*This function is used to get the user profile details to show in the my profile section
		*
		*@access public
		*@author S.D
		*@since 23rd May , 2018
		*@param NONE
		*@return NONE
		*/
		public function my_profile_post()
		{
			$userId = $this->post('userId');
			if(!empty($userId))
			{
				$userData = $this->Login_model->getUserData($userId);
				$returnArr['status'] = $this->lang->line('SUCCESS');
				$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				$returnArr['userPhoto'] = ADMIN_PANEL_URL.'lte/dist/img/avatar5.png';
				$returnArr['userName'] = $userData['user_name'];
				$returnArr['userDob'] = $userData['dob'];
				$returnArr['userUuid'] = $userData['uuid'];
			}
			else
			{
				$returnArr['status'] = $this->lang->line('FAIL');
				$returnArr['message'] = $this->lang->line('invalid_credentials');
			}
			$this->response($returnArr , 200);
		}

		/**
		*This function is used to complete the logout functionality
		*
		*@access public
		*@author S.D
		*@since 6th June , 2018
		*@param NONE
		*@return NONE
		*/
		public function logout_post()
		{
			$uuid = $this->post('uuid');
			$deviceType = $this->post('deviceType');
			if(!empty($uuid) && !empty($deviceType))
			{
				$this->Front_model->commonDelete(TABLE_USER_DEVICES , "user_id = '".$uuid."' AND device_type = '".$deviceType."'");
				$returnArr['status'] = $this->lang->line('SUCCESS');
				$returnArr['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			}
			else
			{
				$returnArr['status'] = $this->lang->line('FAIL');
				$returnArr['message'] = $this->lang->line('please_pass_required');
			}
			$this->response($returnArr , 200);
		}
	}

