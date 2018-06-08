<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/*
	*Author : S.D
	*Purpose : Student's survey Functionality
	*Date : 21-05-2018
	*Dependency: Student_survey_model.php
	*/
	class Student_survey extends REST_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->lang->load('message' , 'english');
			$this->load->model('webservices/Student_survey_model' , '' , TRUE);

			$apiKey = $this->post('api_key');
			validateApiKey($apiKey);
			$data = array();
		}

		/**
		*This function is used to return the survey details with question/option/answer
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function survey_post()
		{
			$data = array();
			$userId = $this->post('userId');
			if($userId != '')
			{
				$data['status'] = $this->lang->line('SUCCESS');
				$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');

				$userData = $this->Student_survey_model->getUserdata($userId);
				$testDetails = $this->Student_survey_model->getTestDetails('Survey');
				$filledWeek = $this->Student_survey_model->getSTDFilledWeeks($userData['uuid'] , $testDetails['test_id']);

				//User Information
				$data['userInfo']['campusName'] = $userData['nome_centri'];
				$data['userInfo']['studentName'] = $userData['nome'].' '.$userData['cognome'];
				$data['userInfo']['groupLeader'] = $userData['gl_rif'];
				$data['userInfo']['travellingWith'] = $userData['businessname'];

				//Survey details
				$data['surveyInfo']['surveyId'] = $testDetails['test_id'];
				$data['surveyInfo']['surveyTitle'] = $testDetails['test_title'];

				$weekNo = $this->diffInWeeks($userData['data_arrivo_campus'] , date('Y-m-d', strtotime($userData['data_partenza_campus'].' -1 day')));
				$weekStart = array();
				$weekDay = 7;
				$currDate = date("Y-m-d");

				//Split the weeks from the date range and save in an array
				for($i = 1 ; $i <= $weekNo ; $i++)
				{
					if($i == 1)
						$weekStart[$i] = date('Y-m-d' , strtotime($userData['data_arrivo_campus']));
					else
					{
						if(date('Y-m-d' , strtotime($weekStart[$i - 1] . ' +7 days')) > $userData['data_partenza_campus'])
							$weekStart[$i] = $userData['data_partenza_campus'];
						else
							$weekStart[$i] = date('Y-m-d', strtotime($weekStart[$i - 1] . ' +7 days'));
					}
				}

				//fetch the dates from the week date string and store in array(Already filled up survey)
				$filledDates = array();
				if(!empty($filledWeek))
				{
					foreach($filledWeek as $dates)
					{
						$dateArr = explode('_' , $dates['ts_week']);
						$filledDates[] = $dateArr[1];
					}
				}

				//Separate the completed and pending survey
				$data['completed'] = $data['pending'] = array();
				foreach($weekStart as $key => $value)
				{
					$tempWeekSend = $key.'_'.$value;
					//For completed
					if(in_array($value , $filledDates))
					{
						$data['completed'][$key]['frontTitle'] = 'Week '.$key;
						$data['completed'][$key]['title'] = $testDetails['test_title'].' (Week '.$key.')';
						$data['completed'][$key]['weekSend'] = $tempWeekSend;
						$data['completed'][$key]['fromDate'] = $value;
						$data['completed'][$key]['toDate'] = date('Y-m-d' , strtotime($value . ' +6 days'));
						$data['completed'][$key]['questions'] = $this->getQuestion($userData['uuid'] , $tempWeekSend);
					}
					//For pending
					else
					{
						$data['pending'][$key]['frontTitle'] = 'Week '.$key;
						$data['pending'][$key]['title'] = $testDetails['test_title'].' (Week '.$key.')';
						$data['pending'][$key]['weekSend'] = $tempWeekSend;
						$data['pending'][$key]['fromDate'] = $value;
						$data['pending'][$key]['toDate'] = date('Y-m-d' , strtotime($value . ' +6 days'));
						$data['pending'][$key]['questions'] = $this->getQuestion($userData['uuid'] , $tempWeekSend);
					}
				}
				$data['pending'] = array_values($data['pending']);
				$data['completed'] = array_values($data['completed']);
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('invalid_student_login');
			}
			$this->response($data , 200);
		}

		/**
		* Function to get the week number from the from and to dates
		*
		*@access private
		*@author S.D
		*@since 21th May , 2018
		*@param date $from
		*@param date $to
		*@return integer
		*/
		private function diffInWeeks($from = NULL , $to = NULL)
		{
			$day = 24 * 3600;
			$from = strtotime($from);
			$to = strtotime($to) + $day;
			$diff = abs($to - $from);
			$weeks = ceil($diff / $day / 7);
			$days = $diff / $day - $weeks * 7;
			$out = array();
			return $weeks;
		}

		/**
		*Function is used to get the questions according to any survey
		*
		*@access private
		*@author S.D
		*@since 21th May , 2018
		*@param String $uuid
		*@param String $weekSend
		*@return Array
		*/
		private function getQuestion($uuid = NULL , $weekSend = NULL)
		{
			$returnArr = array();
			$questionArr = $this->Student_survey_model->getQuestions('Survey' , $uuid , $weekSend);
			return $questionArr;
		}

		/**
		*Function to save the clicked survey values
		*
		*@access public
		*@author S.D
		*@since 21th May , 2018
		*@param NONE
		*@return NONE
		*/
		public function store_survey_post()
		{
			$clickValue = $this->post('clickValue');
			$optionId = $this->post('optionId');
			$uuid = $this->post('uuid');
			$weekSend = $this->post('weekSend');
			if(!empty($clickValue) &&
				!empty($optionId) &&
				!empty($uuid) &&
				!empty($weekSend)
			)
			{
				$insertData = array(
					'tans_opt_id' => $optionId,
					'tans_uuid' => $uuid,
					'tans_week' => $weekSend,
					'trans_survey_value' => $clickValue
				);
				$tempStatus = $this->Student_survey_model->storeStudentSurvey($insertData);
				if($tempStatus)
				{
					$data['status'] = $this->lang->line('SUCCESS');
					$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				}
				else
				{
					$data['status'] = $this->lang->line('FAIL');
					$data['message'] = $this->lang->line('unable_save_answer');
				}
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('please_pass_required');
			}
			$this->response($data , 200);
		}

		/**
		*Function to final submit the survey and save the details
		*
		*@access public
		*@author S.D
		*@since 21th May , 2018
		*@param NONE
		*@return NONE
		*/
		public function submit_survey_post()
		{
			$testId = $this->post('testId');
			$uuid = $this->post('uuid');
			$weekSend = $this->post('weekSend');
			if(!empty($testId) &&
				!empty($uuid) &&
				!empty($weekSend)
			)
			{
				$insertData = array(
					'ts_uuid' => $uuid,
					'ts_test_id' => $testId,
					'ts_week' => $weekSend,
					'ts_submitted_on' => date('Y-m-d H:i:s')
				);
				$tempStatus = $this->Student_survey_model->insertSurvey($insertData);
				if($tempStatus)
				{
					$data['status'] = $this->lang->line('SUCCESS');
					$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
				}
				else
				{
					$data['status'] = $this->lang->line('FAIL');
					$data['message'] = $this->lang->line('unable_save_answer');
				}
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('please_pass_required');
			}
			$this->response($data , 200);
		}

		/**
		*This function is used to reset the survey attempt(Only for our testing reference)
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function reset_survey_post()
		{
			$uuid = $this->post('uuid');
			$weekSend = $this->post('weekSend');
			if(!empty($uuid) && !empty($weekSend))
			{
				$this->db->where('ts_uuid' , $uuid)
						->where('ts_week' , $weekSend)
						->where('ts_test_id' , 1)
						->delete('plused_test_submited');
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
		*This function is used to reset the attempt options(Only for our testing reference)
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function reset_survey_options_post()
		{
			$uuid = $this->post('uuid');
			$weekSend = $this->post('weekSend');
			if(!empty($uuid) && !empty($weekSend))
			{
				$this->db->where('tans_uuid' , $uuid)
						->where('tans_week' , $weekSend)
						->delete('plused_test_answers');
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

