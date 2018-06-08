<?php
	/**
	*This model is used to manage all the database related operations for the Group leader's survey modules
	*
	*@package Gl_survey_model Class
	*@category Model
	*@author S.D
	*/
	class Gl_survey_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*Function to get the user data from the given uuid
		*
		*@access public
		*@author S.D
		*@since 23rd May , 2018
		*@param String $uuid
		*@return array
		*/
		public function getUserdata($uuid = NULL)
		{
			$this->db->where('tipo_pax' , 'GL');
			$this->db->where('uuid' , $uuid);
			$this->db->select('id_prenotazione,uuid,cognome,nome,tipo_pax,pax_dob,data_arrivo_campus,data_partenza_campus,id_centro,nome_centri');
			$this->db->join('plused_book' , 'plused_rows.id_book = plused_book.id_book' , 'left');
			$this->db->join('centri' , 'plused_book.id_centro = centri.id' , 'left');
			$result = $this->db->get("plused_rows");
			if ($result->num_rows())
				return $result->row();
			else
				return 0;
		}

		/**
		*Function to get the survey user data from the given uuid and report type
		*
		*@access public
		*@author S.D
		*@since 23rd May , 2018
		*@param String $uuid
		*@param String $reportType
		*@return array
		*/
		public function getSurveyUserdata($uuid = NULL , $reportType = NULL)
		{
			if(!empty($uuid) && !empty($reportType))
			{
				$this->db->where('su_group_leader_uuid' , $uuid);
				$this->db->where('su_report' , $reportType);
				$result = $this->db->get('plused_survey_users');
				if($result->num_rows())
					return $result->row();
				return 0;
			}
		}

		/**
		*Function to get the survey questions & answer for specific user and report type
		*
		*@access public
		*@author S.D
		*@since 23rd May , 2018
		*@param String $reportType
		*@param Integer $surveyUserId
		*@return array
		*/
		public function getServeyQuestions($reportType = NULL , $surveyUserId = NULL)
		{
			if(!empty($reportType) && !empty($surveyUserId))
			{
				$this->db->where('que_report' , $reportType);
				$this->db->order_by('que_section_sequence , que_number' , 'asc');
				$this->db->join('plused_survey_answers' , 'plused_survey_questions.que_id = ans_que_id AND plused_survey_answers.ans_su_id = '.$surveyUserId , 'left');
				$result = $this->db->get('plused_survey_questions');
				if($result->num_rows())
					return $result->result_array();
			}
			return 0;
		}

		/**
		*Function to insert survey user data to start a group leader survey
		*
		*@access public
		*@author S.D
		*@since 23rd May , 2018
		*@param Array $insertArray
		*@return array
		*/
		public function startSurvey($insertArray = array())
		{
			$result = 0;
			if(!empty($insertArray))
			{
				$this->db->insert('plused_survey_users' , $insertArray);
				$result = $this->db->insert_id();
			}
			return $result;
		}

		/**
		*This function is used to store answers in the database
		*
		*@access public
		*@author S.D
		*@since 23rd May , 2018
		*@param String $type
		*@param Integer $surveyUserId
		*@param Integer $questionId
		*@param String $answerValue
		*@return Integer
		*/
		public function logSurveyAnswer($type = NULL , $surveyUserId = NULL , $questionId = NULL , $answerValue = NULL)
		{
			$insertArray = array();
			if($type == 'comment' || $type == 'text')
			{
				$insertArray = array(
					'ans_su_id' => $surveyUserId,
					'ans_que_id' => $questionId,
					'ans_yes_no' => '',
					'ans_comment' => $answerValue
				);
			}
			elseif($type == 'yesno')
			{
				$answerValue = trim($answerValue);
				if(empty($answerValue))
					$answerValue = 0;
				$insertArray = array(
					'ans_su_id' => $surveyUserId,
					'ans_que_id' => $questionId,
					'ans_yes_no' => $answerValue,
					'ans_comment' => ''
				);
			}
			$lastId = 0;
			if(!empty($insertArray))
			{
				$whereArr = array(
					'ans_su_id' => $surveyUserId,
					'ans_que_id' => $questionId
				);
				$this->db->where($whereArr);
				$this->db->select('ans_id');
				$result = $this->db->get('plused_survey_answers');
				if($result->num_rows())
				{
					$ansId = $result->row()->ans_id;
					$this->db->flush_cache();
					$this->db->where('ans_id' , $ansId);
					$this->db->update('plused_survey_answers' , $insertArray);
					$lastId = $ansId;
				}
				else
				{
					$this->db->flush_cache();
					$this->db->insert('plused_survey_answers' , $insertArray);
					$lastId = $this->db->insert_id();
				}
			}
			return $lastId;
		}

		/**
		*This function is used to mark group leader survey as completed
		*
		*@access public
		*@author S.D
		*@since 23rd May , 2018
		*@param Integer $surveyUserId
		*@return Integer
		*/
		function markSurveyAsCompleted($surveyUserId = 0)
		{
			if($surveyUserId)
			{
				$this->db->where('su_id' , $surveyUserId);
				$updateArray = array(
					'su_survey_date' => date("Y-m-d H:i:s"),
					'su_survey_status' => 'Completed'
				);
				$this->db->update('plused_survey_users' , $updateArray);
				return $surveyUserId;
			}
			return 0;
		}

		/**
		*Function is used to get the survey user  email id from the uuid
		*
		*@access public
		*@author S.D
		*@since 1st June , 2018
		*@param String $uuid
		*@return array
		*/
		public function getSurveyUserEmail($uuid = NULL)
		{
			$result = $this->db->select('su_email')
								->where('su_group_leader_uuid' , $uuid)
								->get('plused_survey_users')->row_array();
			return (isset($result['su_email'])) ? $result['su_email'] : '';
		}
	}
