<?php
	/**
	*This model is used to manage all the database related operations for the student's survey modules
	*
	*@package Student_survey_model Class
	*@category Model
	*@author S.D
	*/
	class Student_survey_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*Function to get the user data from the given id
		*
		*@access public
		*@author S.D
		*@since 21th May , 2018
		*@param Integer $id
		*@return array
		*/
		public function getUserdata($id = NULL)
		{
			$this->db->select('a.id_prenotazione,a.uuid,a.cognome,a.nome,a.tipo_pax,a.pax_dob,a.data_arrivo_campus,a.data_partenza_campus,b.id_centro,c.nome_centri,b.weeks,d.businessname,a.gl_rif')
					->from('plused_rows as a')
					->join('plused_book as b', 'a.id_book = b.id_book', 'left')
					->join('centri as c', 'b.id_centro = c.id', 'left')
					->join('agenti as d', 'b.id_agente = d.id')
					->where('a.tipo_pax', 'STD')
					->where('a.id_prenotazione', $id);
			$result = $this->db->get();
			if($result->num_rows())
			{
				$resulArray = $result->result_array();
				return $resulArray[0];
			}
			else
				return 0;
		}

		/**
		*Function to get the details of the test from its name
		*
		*@access public
		*@author S.D
		*@since 21th May , 2018
		*@param string $tesType
		*@return array
		*/
		function getTestDetails($tesType = NULL)
		{
			$this->db->select('*')
					-> from('plused_test_student')
					-> where('test_type' , $tesType);
			$result = $this->db->get();
			if($result->num_rows() > 0)
			{
				$resultArray = $result->result_array();
				return $resultArray[0];
			}
			else
				return FALSE;
		}

		/**
		*Get the submitted week list by the student
		*
		*@access public
		*@author S.D
		*@since 21th May , 2018
		*@param string $uuid
		*@param string $test
		*@return array
		*/
		function getSTDFilledWeeks($uuid = NULL , $test = NULL)
		{
			$this->db->select('ts_week')
					->from('plused_test_submited')
					->where('ts_uuid' , $uuid)
					->where('ts_test_id' , $test);
			$result = $this->db->get();
			if($result->num_rows() > 0)
				return $result->result_array();
			else
				return FALSE;
		}

		/**
		*Function to get the question and options
		*
		*@access public
		*@author S.D
		*@since 21th May , 2018
		*@param string $type
		*@param string $uuid
		*@param string $week
		*@return array
		*/
		function getQuestions($type = NULL , $uuid = NULL , $week = NULL)
		{
			$this->db->select('b.tque_section, b.tque_question, d.opt_text, d.opt_id, e.trans_survey_value')
					->from('plused_test_student as a')
					->join('plused_test_question as b' , 'b.tque_test_id = a.test_id')
					->join('plused_test_student as c' , 'c.test_id=b.tque_test_id')
					->join('plused_test_options as d' , 'd.opt_que_id=b.tque_id')
					->join('plused_test_answers as e' , "e.tans_opt_id=d.opt_id AND e.tans_uuid='" . $uuid . "' AND e.tans_week = '" . $week . "'", 'left')
					->where('c.test_type' , $type);
			$result = $this->db->get();
			if($result -> num_rows() > 0)
				return $result->result_array();
			return FALSE;
		}

		/**
		*Function to store temporarily the survey details
		*
		*@access public
		*@author S.D
		*@since 21th May , 2018
		*@param Array $data
		*@return Boolean
		*/
		public function storeStudentSurvey($data = array())
		{
			$this->db->select('count(*) as count , tans_id')
					->from('plused_test_answers')
					->where('tans_uuid' , $data['tans_uuid'])
					->where('tans_week' , $data['tans_week'])
					->where('tans_opt_id' , $data['tans_opt_id'])
					->limit(1);
			$result = $this->db->get();
			if($result->num_rows() > 0)
			{
				$resultArray = $result->result_array();
				if(!$resultArray[0]['tans_id'])
				{
					if($this->db->insert('plused_test_answers' , $data))
						return TRUE;
					else
						return FALSE;
				}
				else
				{
					$this->db->where('tans_id' , $resultArray[0]['tans_id']);
					$updateData = array(
						'trans_survey_value' => $data['trans_survey_value']
					);
					if($this->db->update('plused_test_answers' , $updateData))
						return TRUE;
					else
						return FALSE;
				}
			}
			else
				return FALSE;
		}

		/**
		*Function to finally submit the survey details
		*
		*@access public
		*@author S.D
		*@since 21th May , 2018
		*@param Array $data
		*@return Boolean
		*/
		public function insertSurvey($data = array())
		{
			$this->db->select('tans_opt_id')
					->from('plused_test_answers')
					->where('tans_uuid' , $data['ts_uuid'])
					->where('tans_week' , $data['ts_week']);
			$result = $this->db->get();
			if($result->num_rows() > 0)
			{
				$resultArray = $result->result_array();
				$notIn = array();
				foreach($resultArray as $value)
					$notIn[] = $value['tans_opt_id'];
				$this->db->select('tque_id')
						->from('plused_test_question as a')
						->join('plused_test_options as b' , 'b.opt_que_id=a.tque_id')
						->where_not_in('b.opt_id' , $notIn)
						->where('a.tque_test_id' , $data['ts_test_id']);
				$result = $this->db->get();
				if($result->num_rows() > 0)
				{
					$resultArray = $result->result_array();
					foreach($resultArray as $val)
					{
						$insData = array(
							'tans_opt_id' => $val['tque_id'],
							'tans_uuid' => $data['ts_uuid'],
							'tans_week' => $data['ts_week'],
							'trans_survey_value' => 0
						);
						$this->db->insert('plused_test_answers' , $insData);
					}
				}
			}
			else
			{
				$this->db->select('tque_id')
						->from('plused_test_question as a')
						->join('plused_test_options as b' , 'b.opt_que_id=a.tque_id')
						->where('a.tque_test_id' , $data['ts_test_id']);
				$result = $this->db->get();
				if($result->num_rows() > 0)
				{
					$resultArray = $result->result_array();
					foreach ($resultArray as $val)
					{
						$insData = array(
							'tans_opt_id' => $val['tque_id'],
							'tans_uuid' => $data['ts_uuid'],
							'tans_week' => $data['ts_week'],
							'trans_survey_value' => 0
						);
						$this->db->insert('plused_test_answers' , $insData);
					}
				}
			}
			if($this->db->insert('plused_test_submited' , $data))
				return TRUE;
			else
				return FALSE;
		}

	}
