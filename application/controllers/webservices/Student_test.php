<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/*
	*Author : S.D
	*Purpose : Student's test Functionality
	*Date : 15-05-2018
	*Dependency: Student_test_model.php
	*/
	class Student_test extends REST_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->lang->load('message' , 'english');
			$this->load->model('webservices/Student_test_model' , '' , TRUE);

			$apiKey = $this->post('api_key');
			validateApiKey($apiKey);
			$data = array();
		}

		/**
		*This function is used to return the test details with question/option/answer/timing
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function english_test_post()
		{
			$data = array();
			$userUUID = $this->post('uuid');
			if($userUUID != '')
			{
				$testId = TESTID;
				$remainingTime = REMAINING_TIME;
				$runningTestId = 0;
				$runningTestId = 0;
				$currentTestAttempt = 0;
				$testSubmitedStatus = 0;
				$checkAlreadySubmitted = $this->Student_test_model->checkAlreadySubmited($testId , $userUUID);

				if(!empty($checkAlreadySubmitted))
				{
					$runningTestId = $checkAlreadySubmitted->ts_id;
					$remainingTime = $checkAlreadySubmitted->ts_remaining_time;
					$testSubmitedStatus = ($checkAlreadySubmitted->ts_test_status == "Completed" ? 1 : 0);
					$currentTestAttempt = $checkAlreadySubmitted->ts_attempt_count;
				}
				//If any student attempt test for more than 2 times
				if($currentTestAttempt > 2)
				{
					$data['status'] = $this->lang->line('FAIL');
					$data['message'] = $this->lang->line('test_attempt_exceed');
				}
				else
				{
					$data['status'] = $this->lang->line('SUCCESS');
					$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
					$data['testDetails']['runningTestId'] = $runningTestId;
					$data['testDetails']['remainingTime'] = $remainingTime;

					//Send time in secs
					$tempTimeArr = explode(':' , $remainingTime);
					$data['testDetails']['remainingTimeSec'] = ($tempTimeArr[0] * 60) + $tempTimeArr[1];

					$data['testDetails']['testAlreadySubmitted'] = $testSubmitedStatus;
					$data['testDetails']['currentTestAttempt'] = $currentTestAttempt;

					$testQuestionData = $this->Student_test_model->getTestQuestions($testId , $userUUID);
					$data['testDetails']['testId'] = $testQuestionData[0]['test_id'];
					$data['testDetails']['testTitle'] = $testQuestionData[0]['test_title'];
					if(!empty($testQuestionData))
					{
						foreach($testQuestionData as $key => $QuestionDatavalue)
						{
							$data['question'][$key]['questionId'] = $QuestionDatavalue['tque_id'];
							$data['question'][$key]['questionText'] = $QuestionDatavalue['tque_question'];
							$data['question'][$key]['stdMarkedOption'] = $QuestionDatavalue['std_marked_option'];
							$data['question'][$key]['options'] = array_map(function($arrValue){$tempArr = explode('#' , $arrValue);return array('optionId' => $tempArr[0] , 'optionText' => $tempArr[1]);} , explode('||' , $QuestionDatavalue['que_options']));
						}
					}

					//Prepare data for test instruction
					$data['testInstruction']['instructionTitle'] = $this->lang->line('instructionTitleLang');
					$data['testInstruction']['instructionMessage'] = $this->lang->line('instructionMessageLang');
					$data['testInstruction']['instructionWarning'] = $this->lang->line('instructionWarningLang');
					$data['testInstruction']['instructionNotes'] = $this->lang->line('instructionNotesLang');
				}
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('invalid_student_login');
			}
			$this->response($data , 200);
		}

		/**
		*This function is used to enter the necessary data in the DB after start an test
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function test_started_post()
		{
			$testId = $this->post('testId');
			$remainingTime = $this->post('remainingTime');
			$userUUID = $this->post('uuid');
			$testSubmitId = 0;
			if(!empty($userUUID))
			{
				if(!empty($testId))
				{
					$testSubmitId = $this->Student_test_model->testStarted($testId , $userUUID , $remainingTime);
					$data['status'] = $this->lang->line('SUCCESS');
					$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
					$data['testSubmitId'] = $testSubmitId;
				}
				else
				{
					$data['status'] = $this->lang->line('FAIL');
					$data['message'] = $this->lang->line('testid_missing');
				}
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('invalid_student_login');
			}
			$this->response($data , 200);
		}

		/**
		*This function is used to update the timing for any test
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function upatetimer_post()
		{
			$runningTestId = $this->post('runningTestId');
			$remainingTime = $this->post('remainingTime');
			$timeUpdated = 0;
			if(!empty($runningTestId))
			{
				$timeUpdated = $this->Student_test_model->upatetimer($runningTestId , $remainingTime);
				$data['status'] = $this->lang->line('SUCCESS');
				$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('running_testid_missing');
			}
			$this->response($data , 200);
		}

		/**
		*This function is used to log question and answer
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		function logquesanswer_post()
		{
			$questionId = $this->post('questionId');
			$optionId = $this->post('optionId');
			$userUUID = $this->post('uuid');
			if(!empty($userUUID))
			{
				if(!empty($questionId) && !empty($optionId))
				{
					$result = $this->Student_test_model->updateQuestionAnswer($questionId, $optionId, $userUUID);
					if($result)
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
					$data['message'] = $this->lang->line('question_option_missing');
				}
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('invalid_student_login');
			}
			$this->response($data , 200);
		}

		/**
		*This function is used to submit students test
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		function submittest_post()
		{
			$testId = $this->post('testId');
			$testSubmittedDate = date("Y-m-d H:i:s");
			$userUUID = $this->post('uuid');
			if(!empty($userUUID))
			{
				if(!empty($testId))
				{
					$result = $this->Student_test_model->submitTest($testId , $userUUID , $testSubmittedDate);
					if($result > 0)
					{
						// Add total test score in course director language knowledge section.
						$this->Student_test_model->addTestScore($testId , $userUUID);
						$data['status'] = $this->lang->line('SUCCESS');
						$data['message'] = $this->lang->line('test_submit_success');
						$data['imagePath'] = ADMIN_PANEL_URL."img/tuition/hp_summer.jpg";
						$data['titleText'] = $this->lang->line('submit_test_title_text');
						$data['descriptionText'] = $this->lang->line('submit_test_description_text');
					}
					elseif($result == -1)
					{
						$data['status'] = $this->lang->line('FAIL');
						$data['message'] = $this->lang->line('already_test_submitted');
					}
					else
					{
						$data['status'] = $this->lang->line('FAIL');
						$data['message'] = $this->lang->line('unable_submit_test');
					}
				}
				else
				{
					$data['status'] = $this->lang->line('FAIL');
					$data['message'] = $this->lang->line('unable_submit_test');
				}
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('invalid_student_login');
			}
			$this->response($data , 200);
		}

		/**
		*This function is used to reset the test attempt(Only for our testing reference)
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function reset_test_post()
		{
			$testId = $this->post('testId');
			if(!empty($testId))
			{
				$updateData = array(
					'ts_attempt_count' => 0,
					'ts_test_status' => 'Running'
				);
				$this->db->where('ts_id' , $testId)
						->update(TABLE_TEST_SUBMITTED , $updateData);
				$data['status'] = $this->lang->line('SUCCESS');
				$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('testid_missing');
			}
			$this->response($data , 200);
		}

		/**
		*This function is used to reset the test question/options(Only for our testing reference)
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function reset_question_option_post()
		{
			$userUUID = $this->post('uuid');
			if(!empty($userUUID))
			{
				$this->db->where('tans_uuid' , $userUUID)
						->delete(TABLE_TEST_ANSWERS);
				$data['status'] = $this->lang->line('SUCCESS');
				$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('invalid_student_login');
			}
			$this->response($data , 200);
		}

		/**
		*This function is used to reset the test time and set it to the default one(Only for our testing reference)
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function reset_test_time_post()
		{
			$testSubmitId = $this->post('testSubmitId');
			if(!empty($testSubmitId))
			{
				$updateData = array(
					'ts_remaining_time' => REMAINING_TIME
				);
				$this->db->where('ts_id' , $testSubmitId)
						->update(TABLE_TEST_SUBMITTED , $updateData);
				$data['status'] = $this->lang->line('SUCCESS');
				$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('testid_missing');
			}
			$this->response($data , 200);
		}
	}

