<?php
	class Admin_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		//This function is used to verify whether user name and password is present in DB or not
		public function verify($userName = NULL , $userPassword = NULL)
		{
			return $this->db->select('users_id , userName , userImage')
								->where('userId' , $userName)
								->where('userPassword' , md5($userPassword))
								->get(TABLE_USERS)->row_array();
		}

		//This function is used to get user data from DB for update profile
		function getUserData($userId = NULL)
		{
			return $this->db->where('users_id' , $userId)
							->get(TABLE_USERS)->row_array();
		}

		//Function is used to update user data in DB
		function updateUserData($id = NULL , $data = NULL)
		{
			$this->db->where('users_id' , $id)
					->update(TABLE_USERS , $data);
		}

		//This function is used to get program details from DB and show through datatable
		function getProgramDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL , $languageId = 1)
		{
			$resultData = array();
			$colomnArr = array('a.program_id' , 'a.program_image' , 'b.program_title' , 'b.program_short_description' , 'a.program_status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_PROGRAM . ' a');
			$this->db->join(TABLE_PROGRAM_LANGUAGE . ' b' , 'a.program_id = b.program_id AND b.language_id = '.$languageId , 'left');

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[2]." LIKE '%".$search_string."%' OR ".$colomnArr[3]." LIKE '%".$search_string."%')");

			//For Ordering
			if($order_column != '' && $order_dir != '')
				$this->db->order_by($colomnArr[$order_column] , $order_dir);

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = 1;
				foreach($result as $value)
				{
					$statusClass = ($value['program_status'] == 1) ? 'fa-check-circle-o' : 'fa-times-circle-o';
					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url()."uploads/program/".$value['program_image']."' width = 180 height = 50 />",
						2 => $value['program_title'],
						3 => $value['program_short_description'],
						4 => '<i class="fa fa-lg '.$statusClass.' global-list-status-icon" aria-hidden="true" data-toggle="modal" data-target="#programStatus" data-status_type = '.$value['program_status'].' data-program_id = '.$value['program_id'].' ></i>',
						5 => '<i class="fa fa-lg fa-pencil-square-o global-list-icon" aria-hidden="true"></i><i style="margin-left: 9px;" class="fa fa-lg fa-trash-o global-list-icon" aria-hidden="true"></i>'
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_PROGRAM)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//Function is used to update program realated record in DB
		function updateProgram($id = NULL , $data = NULL)
		{
			$this->db->where('program_id' , $id)
					->update(TABLE_PROGRAM , $data);
		}

		//Function is used to add program related data(main table and multi-language wise) in DB
		function addProgram($data = NULL , $fileName = NULL)
		{
			if($data['selected_language'] != '')
			{
				$insertData = array(
					'program_image' => $fileName,
					'program_status' => 1
				);
				$this->db->insert(TABLE_PROGRAM , $insertData);
				$programId = $this->db->insert_id();

				$languageArr = explode(',' , $data['selected_language']);
				foreach($languageArr as $languageId)
				{
					$insertData = array(
						'language_id' => $languageId,
						'program_title' => $data['program_title'][$languageId],
						'program_short_description' => $data['program_short_description'][$languageId],
						'program_description' => $data['program_description'][$languageId],
						'program_id' => $programId
					);
					$this->db->insert(TABLE_PROGRAM_LANGUAGE , $insertData);
				}
			}
		}
	}
?>