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
						'centre_id' => $centreInfo['centreId']
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
	}

