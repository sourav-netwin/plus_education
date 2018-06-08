<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');
	require APPPATH . 'libraries/REST_Controller.php';

	/*
	*Author : S.D
	*Purpose : Group Leader's survey Functionality
	*Date : 23-05-2018
	*Dependency: Gl_survey_model.php
	*/
	class Gl_survey extends REST_Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->lang->load('message' , 'english');
			$this->load->model('webservices/Gl_survey_model' , '' , TRUE);

			$apiKey = $this->post('api_key');
			validateApiKey($apiKey);
			$data = array();
		}

		/**
		*This function is used to return the survey listing for the group leader's survey
		*
		*@author S.D
		*@since 28th May , 2018
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function survey_listing_post()
		{
			$data['list'] = array(
				array(
					'reportType' => 'report1',
					'reportName' => 'Take survey 1'
				),
				array(
					'reportType' => 'report2',
					'reportName' => 'Take survey 2'
				)
			);
			$data['status'] = $this->lang->line('SUCCESS');
			$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
			$this->response($data , 200);
		}

		/**
		*This function is used to return the survey details if in progress , otherwise send false for the first time
		*
		*@author S.D
		*@since 28th May , 2018
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function select_survey_post()
		{
			$uuid = $this->post('uuid');
			$reportType = $this->post('reportType');
			if(!empty($uuid) && !empty($reportType))
			{
				$reportTypeName = ($reportType == 'report1') ? 'Report 1' : 'Report 2';
				$surveyGlUser = $this->Gl_survey_model->getSurveyUserdata($uuid , $reportTypeName);
				if($surveyGlUser)
					$data = $this->survey();
				else
				{
					$data['userEmail'] = $this->Gl_survey_model->getSurveyUserEmail($uuid);
					$data['status'] = $this->lang->line('SUCCESS');
					$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
					$data['surveyStatus'] = 'notstarted';
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
		*This function is used to return the survey details with question/option/answer
		*
		*@author S.D
		*@since 28th May , 2018
		*@access private
		*@param NONE
		*@return NONE
		*/
		private function survey()
		{
			$data = array();
			$uuid = $this->post('uuid');
			$reportType = $this->post('reportType');
			if($uuid != '')
			{
				$userData = $this->Gl_survey_model->getUserdata($uuid);
				if($userData)
				{
					if($reportType == "report1" || $reportType == "report2")
					{
						$currDate = date("Y-m-d");
						$arrivalDate = date("Y-m-d" , strtotime($userData->data_arrivo_campus));
						$departureDate = date("Y-m-d" , strtotime($userData->data_partenza_campus));
						$survey2Date = date("Y-m-d" , strtotime('-6 days' , strtotime($departureDate)));

						$allowSurvey = FALSE;
						if($reportType == "report1")
						{
							$reportTypeName = 'Report 1';
							$reportTitle = "Group Leader Report 1";
							if ($arrivalDate <= $currDate)
								$allowSurvey = TRUE;
							else
							{
								$data['status'] = $this->lang->line('FAIL');
								$data['message'] = $this->lang->line('gl_survey_error_msg').date("d/m/Y" , strtotime($arrivalDate));
							}
						}
						elseif($reportType == "report2")
						{
							$reportTypeName = 'Report 2';
							$reportTitle = "Group Leader Report 2";
							if($survey2Date <= $currDate)
							{
								$allowSurvey = TRUE;
								$report1SurveryUser = $this->Gl_survey_model->getSurveyUserdata($uuid , 'Report 1');
								if($report1SurveryUser)
									$glEmailId = $report1SurveryUser->su_email;
							}
							else
							{
								$data['status'] = $this->lang->line('FAIL');
								$data['message'] = $this->lang->line('gl_survey_error_msg').date("d/m/Y" , strtotime($survey2Date));
							}
						}

						if($allowSurvey)
						{
							$surveyUserData = $this->Gl_survey_model->getSurveyUserdata($uuid , $reportTypeName);
							$surveyUserId = $surveyUserData->su_id;
							$surveyQuestions = $this->Gl_survey_model->getServeyQuestions($reportTypeName , $surveyUserId);
							$data['status'] = $this->lang->line('SUCCESS');
							$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
							$data['surveyUserId'] = $surveyUserId;
							$data['surveyStatus'] = $surveyUserData->su_survey_status;
							$data['userEmail'] = $surveyUserData->su_email;
							$data['surveyQuestions'] = $surveyQuestions;
						}
					}
					else
					{
						$data['status'] = $this->lang->line('FAIL');
						$data['message'] = $this->lang->line('invalid_report_type');
					}
				}
				else
				{
					$data['status'] = $this->lang->line('FAIL');
					$data['message'] = $this->lang->line('invalid_gl_login');
				}
			}
			else
			{
				$data['status'] = $this->lang->line('FAIL');
				$data['message'] = $this->lang->line('invalid_gl_login');
			}
			return $data;
		}

		/**
		* Function is used to start a group leader survey
		*
		*@access public
		*@author S.D
		*@since 23th May , 2018
		*@param NONE
		*@return NONE
		*/
		public function startsurvey_post()
		{
			$uuid = $this->post('uuid');
			$reportType = $this->post('reportType');
			$glName = $this->post('glName');
			$glEmail = $this->post('glEmail');
			$campusId = $this->post('campusId');

			if(!empty($uuid) &&
				!empty($reportType) &&
				!empty($glName) &&
				!empty($glEmail) &&
				!empty($campusId)
			)
			{
				$reportTypeName = ($reportType == 'report1') ? 'Report 1' : 'Report 2';
				$insertArr = array(
					'su_group_leader_uuid' => $uuid,
					'su_report' => $reportTypeName,
					'su_name' => $glName,
					'su_email' => $glEmail,
					'su_campus_id' => $campusId,
					'su_survey_status' => 'Inprogress'
				);
				$returnId = $this->Gl_survey_model->startSurvey($insertArr);
				if($returnId)
					$data = $this->survey();
				else
				{
					$data['status'] = $this->lang->line('FAIL');
					$data['message'] = $this->lang->line('unable_submit_test');
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
		* Function is used to log the questions & answer selected by group leader
		*
		*@access public
		*@author S.D
		*@since 23th May , 2018
		*@param NONE
		*@return NONE
		*/
		public function loganswer_post()
		{
			$type = $this->post('type');
			$surveyUserId = $this->post('surveyUserId');
			$questionId = $this->post('questionId');
			$answerValue = $this->post('answerValue');

			if(!empty($type) &&
				!empty($surveyUserId) &&
				!empty($questionId) &&
				!empty($answerValue)
			)
			{
				$returnId = $this->Gl_survey_model->logSurveyAnswer($type , $surveyUserId , $questionId , $answerValue);
				if($returnId)
				{
					$data['status'] = $this->lang->line('SUCCESS');
					$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
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
				$data['message'] = $this->lang->line('please_pass_required');
			}
			$this->response($data , 200);
		}

		/**
		* Function is used to complete the group leader survey
		*
		*@access public
		*@author S.D
		*@since 23th May , 2018
		*@param NONE
		*@return NONE
		*/
		public function markascompleted_post()
		{
			$surveyUserId = $this->post('surveyUserId');
			if(!empty($surveyUserId))
			{
				$returnId = $this->Gl_survey_model->markSurveyAsCompleted($surveyUserId);
				if($returnId)
				{
					$data['status'] = $this->lang->line('SUCCESS');
					$data['message'] = $this->lang->line('VALID_TOKEN_MESSAGE');
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
				$data['message'] = $this->lang->line('please_pass_required');
			}
			$this->response($data , 200);
		}
	}

