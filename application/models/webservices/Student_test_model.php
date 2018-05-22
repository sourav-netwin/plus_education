<?php
	/**
	*This model is used to manage all the database related operations for the student's test modules
	*
	*@package Student_test_model Class
	*@category Model
	*@author S.D
	*/
	class Student_test_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to check student has already submitted the same test or not?
		*
		*@access public
		*@param Integer $testId
		*@param String $userUUID
		*@return Integer
		*/
		public function checkAlreadySubmited($testId = NULL , $userUUID = NULL)
		{
			if(!empty($testId) && !empty($userUUID))
			{
				$this->db->where('ts_uuid' , $userUUID);
				$this->db->where('ts_test_id' , $testId);
				$result = $this->db->get(TABLE_TEST_SUBMITTED);
				if($result->num_rows())
					return $result->row();
				else
					return 0;
			}
			else
				return 0;
		}

		/**
		*This functon list the all question available for test and answer given by student if any
		*
		*@access public
		*@param Integer $testId
		*@param String $userUUID
		*@return Mixed
		*/
		public function getTestQuestions($testId = 0 , $userUUID = NULL)
		{
			if(!empty($testId))
			{
				//get the previously attemped questions count
				$countResult = $this->db->select('count(tque_id) as total')
								->from(TABLE_TEST_QUESTION)
								->join(TABLE_TEST_ANSWERS , "tque_id = tans_ques_id AND tans_uuid ='".$userUUID."'" , 'left')
								->where('tque_test_id' , $testId)
								->where('tans_uuid' , $userUUID)
								->where('tans_id !=' , NULL)
								->get()->row_array();

				//Set one variable to get the count
				$this->db->query("SET @count = ".$countResult['total']);

				$this->db->where('test_id' , $testId);
				$this->db->where('test_type' , 'Test');
				$this->db->select("test_id , test_title , tque_id , tque_test_id , concat((@count := @count + 1) , '. ' , tque_question) as tque_question ,
								 tque_section , group_concat(opt_id , '#' , opt_text ORDER BY opt_id SEPARATOR '||') as que_options,
								tans_opt_id as std_marked_option", false);
				$this->db->join(TABLE_TEST_QUESTION , 'test_id = tque_test_id');
				$this->db->join(TABLE_TEST_OPTIONS , 'tque_id = opt_que_id');
				$this->db->join(TABLE_TEST_ANSWERS , "tque_id = tans_ques_id AND tans_uuid = '".$userUUID."'", 'LEFT');

				//Get only those questions which is not attempted by student previously
				$this->db->where('tans_opt_id' , NULL);
				$this->db->group_by('tque_id');
				$result = $this->db->get(TABLE_TEST_STUDENT);
				if($result->num_rows())
					return $result->result_array();
			}
			else
				return 0;
		}

		/**
		*This functon is used to insert test data into database after start a test
		*
		*@access public
		*@param Integer $testId
		*@param String $userUUID
		*@param String $remainingTime
		*@return Mixed
		*/
		public function testStarted($testId = NULL , $userUUID = NULL , $remainingTime = NULL)
		{
			$testSubmitId = 0;
			if(!empty($testId) && !empty($userUUID))
			{
				$whereArr = array(
					'ts_uuid' => $userUUID,
					'ts_test_id' => $testId
				);
				$this->db->where($whereArr);
				$result = $this->db->get(TABLE_TEST_SUBMITTED);
				if($result->num_rows())
				{
					$testRow = $result->row();
					$testSubmitId = $testRow->ts_id;
					// update time remaining
					$updateArray = array(
						'ts_remaining_time' => $remainingTime,
						'ts_test_status' => 'Running'
					);
					$this->db->flush_cache();
					$this->db->set('ts_attempt_count' , 'ts_attempt_count+1' , FALSE);
					$this->db->where('ts_id' , $testSubmitId);
					$this->db->update(TABLE_TEST_SUBMITTED , $updateArray);
				}
				else
				{
					$insertData = array(
						'ts_uuid' => $userUUID,
						'ts_test_id' => $testId,
						'ts_remaining_time' => $remainingTime,
						'ts_attempt_count' => 1,
						'ts_test_status' => 'Running'
					);
					$this->db->insert(TABLE_TEST_SUBMITTED , $insertData);
					$testSubmitId = $this->db->insert_id();
				}
			}
			return $testSubmitId;
		}

		/**
		*This functon is used to update the timing in every 10 secs
		*
		*@access public
		*@param Integer $runningTestId
		*@param String $remainingTime
		*@return NONE
		*/
		function upatetimer($runningTestId = NULL , $remainingTime = NULL)
		{
			$updateArray = array(
				'ts_remaining_time' => $remainingTime
			);
			$this->db->where('ts_id' , $runningTestId);
			$this->db->update(TABLE_TEST_SUBMITTED , $updateArray);
		}

		/**
		*This function used to update answer agains students uuid and test question
		*
		*@access public
		*@param Integer $questionId
		*@param Integer $optionId
		*@param String $userUUID
		*@return Integer
		*/
		public function updateQuestionAnswer($questionId = NULL , $optionId = NULL , $userUUID = NULL)
		{
			$whereData = array(
				'tans_uuid' => $userUUID,
				'tans_ques_id' => $questionId
			);
			$this->db->where($whereData);
			$result = $this->db->get(TABLE_TEST_ANSWERS);
			if($result->num_rows())
			{
				// udpate the answer
				$updateData = array(
					'tans_opt_id' => $optionId,
					'tans_uuid' => $userUUID,
					'tans_ques_id' => $questionId
				);
				$this->db->where($whereData);
				$this->db->update(TABLE_TEST_ANSWERS , $updateData);
				return 1;
			}
			else
			{
				// add new record
				$insertData = array(
					'tans_opt_id' => $optionId,
					'tans_uuid' => $userUUID,
					'tans_ques_id' => $questionId
				);
				$this->db->insert(TABLE_TEST_ANSWERS , $insertData);
				return 1;
			}
		}

		/**
		*This function is used to submit students test finally.
		*
		*@access public
		*@param Integer $testId
		*@param String $userUUID
		*@param String $testSubmittedDate
		*@return Integer
		*/
		public function submitTest($testId = NULL , $userUUID = NULL , $testSubmittedDate = NULL)
		{
			if(!empty($testId) && !empty($userUUID) && !empty($testSubmittedDate))
			{
				$whereArr = array(
					'ts_uuid' => $userUUID,
					'ts_test_id' => $testId
				);
				$this->db->where($whereArr);
				$result = $this->db->get(TABLE_TEST_SUBMITTED);
				if($result->num_rows())
				{
					$testRow = $result->row();
					$testSubmitId = $testRow->ts_id;
					// update time remaining
					$updateArray = array(
						'ts_submitted_on' => $testSubmittedDate,
						'ts_test_status' => 'Completed'
					);
					$this->db->flush_cache();
					$this->db->where('ts_id' , $testSubmitId);
					$this->db->update(TABLE_TEST_SUBMITTED , $updateArray);
					return 1;
				}
				else
				{
					$this->db->flush_cache();
					$insertData = array(
						'ts_uuid' => $userUUID,
						'ts_test_id' => $testId,
						'ts_submitted_on' => $testSubmittedDate,
						'ts_test_status' => 'Completed'
					);
					$this->db->insert(TABLE_TEST_SUBMITTED , $insertData);
					return $this->db->insert_id();
				}
			}
			else
				return 0;
		}

		/**
		*This function will save test score for language knowledge
		*
		*@access public
		*@param Integer $testId
		*@param String $userUUID
		*@return Integer
		*/
		public function addTestScore($testId = NULL , $userUUID = NULL)
		{
			$result = $this->getStudentTestScore($testId , $userUUID);
			if($result)
			{
				$totalQuestion = $result->total_questions;
				$correctAnswer = $result->correct_answers;
				if(empty($correctAnswer))
					$correctAnswer = 0;
				// check old record
				$this->db->where('lk_uuid' , $userUUID);
				$resultData = $this->db->get(TABLE_LANGUAGE_KNOWLEDGE);
				$updateRow = array(
					'lk_lang_knowledge' => $correctAnswer,
					'lk_english_test_score' => $correctAnswer,
					'lk_uuid' => $userUUID
				);
				if($resultData->num_rows())
				{
					// update data
					$row = $resultData->row();
					$lk_id = $row->lk_id;
					if($lk_id)
					{
						$this->db->flush_cache();
						$updateRow = array(
							'lk_lang_knowledge' => $row->lk_oral_test + $row->lk_listening_comprehension + $correctAnswer,
							'lk_english_test_score' => $correctAnswer,
							'lk_uuid' => $userUUID
						);
						$this->db->where('lk_id' , $lk_id);
						$this->db->update(TABLE_LANGUAGE_KNOWLEDGE , $updateRow);
						$result = 1;
					}
					else
					{
						$this->db->flush_cache();
						$this->db->insert(TABLE_LANGUAGE_KNOWLEDGE , $updateRow);
						$result = 1;
					}
				}
				else
				{
					$this->db->flush_cache();
					$this->db->insert(TABLE_LANGUAGE_KNOWLEDGE , $updateRow);
					$result = 1;
				}
			}
			else
				$result = 0;
			return $result;
		}

		/**
		*Retrive students test score
		*
		*@access public
		*@param Integer $testId
		*@param String $userUUID
		*@return Integer
		*/
		public function getStudentTestScore($testId = NULL , $userUUID = NULL)
		{
			$this->db->select("COUNT(tque_id) AS total_questions ,
			SUM(CASE WHEN opt_correct_answer = 1 AND opt_id = tans_opt_id THEN 1 ELSE 0 END) AS correct_answers", false);
			$this->db->join(TABLE_TEST_STUDENT , 'ts_test_id = test_id');
			$this->db->join(TABLE_TEST_QUESTION , 'test_id = tque_test_id');
			$this->db->join(TABLE_TEST_OPTIONS , 'tque_id = opt_que_id');
			$this->db->join(TABLE_TEST_ANSWERS , 'tque_id = tans_ques_id AND ts_uuid = tans_uuid' , 'LEFT');
			$this->db->where('test_type' , 'Test');
			$this->db->where('opt_correct_answer' , 1);
			$this->db->where('test_id' , $testId);
			$this->db->where('ts_uuid' , $userUUID);
			$result = $this->db->get(TABLE_TEST_SUBMITTED);
			if($result->num_rows())
				return $result->row();
			return 0;
		}
	}
