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

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

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
					$actionStr = '<a href="'.base_url().'admin/program/edit/'.$value['program_id'].'"><i class="fa fa-lg fa-pencil-square-o global-list-icon" aria-hidden="true"></i></a>';
					$actionStr .= '<a href="'.base_url().'admin/program/delete/'.$value['program_id'].'" onclick="return confirm_delete()"><i style="margin-left: 9px;" class="fa fa-lg fa-trash-o global-list-icon" aria-hidden="true"></i></a>';
					$statusClass = ($value['program_status'] == 1) ? 'fa-check-circle-o' : 'fa-times-circle-o';
					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().PROGRAM_IMAGE_PATH.getThumbnailName($value['program_image'])."' width = 180 height = 50 />",
						2 => $value['program_title'],
						3 => $value['program_short_description'],
						4 => '<i class="fa fa-lg '.$statusClass.' global-list-status-icon" aria-hidden="true" data-toggle="modal" data-target="#programStatus" data-status_type = '.$value['program_status'].' data-program_id = '.$value['program_id'].' ></i>',
						5 => $actionStr
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
			$insertData = array(
				'program_image' => $fileName,
				'program_status' => 1
			);
			$this->db->insert(TABLE_PROGRAM , $insertData);
			$programId = $this->db->insert_id();

			$insertData = array(
				'language_id' => $data['language_id'],
				'program_title' => $data['program_title'],
				'program_short_description' => $data['program_short_description'],
				'program_description' => $data['program_description'],
				'program_id' => $programId
			);
			$this->db->insert(TABLE_PROGRAM_LANGUAGE , $insertData);
		}

		//This function is used to get data from DB to show in edit page
		function getEditProgramData($id = NULL , $languageId = 1)
		{
			$this->db->select('a.program_id , a.program_image , b.program_title , b.program_short_description , b.program_description , b.language_id');
			$this->db->from(TABLE_PROGRAM . ' a');
			$this->db->join(TABLE_PROGRAM_LANGUAGE . ' b' , 'a.program_id = b.program_id AND b.language_id = '.$languageId , 'left');
			$this->db->where('b.program_id' , $id);
			return $this->db->get()->row_array();
		}

		//This function is used to update program data in DB
		function updateProgramData($id = NULL , $data = NULL , $fileName = NULL)
		{
			$updateData = array(
				'program_image' => $fileName
			);
			$this->db->where('program_id' , $id)
					->update(TABLE_PROGRAM , $updateData);

			$updateData = array(
				'language_id' => $data['language_id'],
				'program_title' => $data['program_title'],
				'program_short_description' => $data['program_short_description'],
				'program_description' => $data['program_description'],
				'program_id' => $id
			);
			$this->db->where('program_id' , $id)
					->update(TABLE_PROGRAM_LANGUAGE , $updateData);
		}

		//This function is used to delete record from DB for program module
		function deleteProgram($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);

			$this->db->where('program_id' , $id)
					->update(TABLE_PROGRAM , $updateData);
		}

		//This function is used to get program details from DB and show through datatable
		function getCourseDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL , $languageId = 1)
		{
			$resultData = array();
			$colomnArr = array('a.course_master_id' , 'a.course_image' , 'b.course_name' , 'a.course_status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_COURSE_MASTER . ' a');
			$this->db->join(TABLE_COURSE_LANGUAGE . ' b' , 'a.course_master_id = b.course_id AND b.language_id = '.$languageId , 'left');

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[2]." LIKE '%".$search_string."%')");

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
					$actionStr = '<a href="'.base_url().'admin/course/edit/'.$value['course_master_id'].'"><i class="fa fa-lg fa-pencil-square-o global-list-icon" aria-hidden="true"></i></a>';
					$actionStr .= '<a href="'.base_url().'admin/course/delete/'.$value['course_master_id'].'" onclick="return confirm_delete()"><i style="margin-left: 9px;" class="fa fa-lg fa-trash-o global-list-icon" aria-hidden="true"></i></a>';
					$actionStr .= '<i style="margin-left: 9px;" id="manageFeature" class="fa fa-lg fa-briefcase global-list-icon" aria-hidden="true" data-toggle="modal" data-target="#courseFeature" data-course_id = '.$value['course_master_id'].' ></i>';
					$statusClass = ($value['course_status'] == 1) ? 'fa-check-circle-o' : 'fa-times-circle-o';
					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().COURSE_IMAGE_PATH.getThumbnailName($value['course_image'])."' width = 180 height = 50 />",
						2 => $value['course_name'],
						3 => '<i class="fa fa-lg '.$statusClass.' global-list-status-icon" aria-hidden="true" data-toggle="modal" data-target="#courseStatus" data-status_type = '.$value['course_status'].' data-course_id = '.$value['course_master_id'].' ></i>',
						4 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_COURSE_MASTER)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//Function is used to update program realated record in DB
		function updateCourse($id = NULL , $data = NULL)
		{
			$this->db->where('course_master_id' , $id)
					->update(TABLE_COURSE_MASTER , $data);
		}

		//Function is used to add courses related data(main table and multi-language wise + sub table) in DB
		function addCourse($data = NULL , $fileName = NULL , $frontFileName = NULL)
		{
			$insertData = array(
				'course_image' => $fileName,
				'course_front_image' => $frontFileName,
				'course_status' => 1
			);
			$this->db->insert(TABLE_COURSE_MASTER , $insertData);
			$courseId = $this->db->insert_id();

			$insertData = array(
				'language_id' => $data['language_id'],
				'course_name' => $data['course_name'],
				'corse_description' => $data['corse_description'],
				'course_id' => $courseId
			);
			$this->db->insert(TABLE_COURSE_LANGUAGE , $insertData);

			if(!empty($data['specification_option']))
			{
				foreach($data['specification_option'] as $key => $value)
				{
					$insertData = array(
						'specification_option' => $data['specification_option'][$key],
						'specification_value' => $data['specification_value'][$key],
						'course_id' => $courseId
					);
					$this->db->insert(TABLE_COURSE_SPECIFICATION , $insertData);
				}
			}
		}

		//This function is used to get data from DB to show in edit page
		function getEditCourseData($id = NULL , $languageId = 1)
		{
			$this->db->select('a.course_master_id , a.course_image , a.course_front_image , b.course_name , b.corse_description , b.language_id');
			$this->db->from(TABLE_COURSE_MASTER . ' a');
			$this->db->join(TABLE_COURSE_LANGUAGE . ' b' , 'a.course_master_id = b.course_id AND b.language_id = '.$languageId , 'left');
			$this->db->where('a.course_master_id' , $id);
			$result = $this->db->get()->row_array();
			$result['specification'] = $this->db->select('specification_option , specification_value')
												->where('course_id' , $id)
												->get(TABLE_COURSE_SPECIFICATION)->result_array();
			return $result;
		}

		//This function is used to update program data in DB
		function updateCourseData($id = NULL , $data = NULL , $fileName = NULL , $fileNameFront = NULL)
		{
			$updateData = array(
				'course_image' => $fileName,
				'course_front_image' => $fileNameFront
			);
			$this->db->where('course_master_id' , $id)
					->update(TABLE_COURSE_MASTER , $updateData);

			$updateData = array(
				'language_id' => $data['language_id'],
				'course_name' => $data['course_name'],
				'corse_description' => $data['corse_description'],
				'course_id' => $id
			);
			$this->db->where('course_id' , $id)
					->update(TABLE_COURSE_LANGUAGE , $updateData);

			$this->db->where('course_id' , $id)
					->delete(TABLE_COURSE_SPECIFICATION);
			if(!empty($data['specification_option']))
			{
				foreach($data['specification_option'] as $key => $value)
				{
					$insertData = array(
						'specification_option' => $data['specification_option'][$key],
						'specification_value' => $data['specification_value'][$key],
						'course_id' => $id
					);
					$this->db->insert(TABLE_COURSE_SPECIFICATION , $insertData);
				}
			}
		}

		//This function is used to delete record from DB for course module
		function deleteCourse($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);

			$this->db->where('course_master_id' , $id)
					->update(TABLE_COURSE_MASTER , $updateData);
		}

		//Function is used to get all course features from DB
		function getCourseFeature($id = NULL)
		{
			return $this->db->select('feature_title , feature_description , feature_image , course_id')
							->where('course_id' , $id)
							->get(TABLE_COURSE_FEATURE)->result_array();
		}

		//This function is used to delete old feature data and insert the new one
		function updateCourseFeature($id =  NULL , $data = NULL)
		{
			$data = array_merge($data);
			$this->db->where('course_id' , $id)->delete(TABLE_COURSE_FEATURE);
			$this->db->insert_batch(TABLE_COURSE_FEATURE , $data);
		}

		//This function is used to get program course details from DB and show through datatable
		function getProgramCourseDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL)
		{
			$resultData = array();
			$colomnArr = array('a.program_course_id' , 'a.program_course_name' , 'a.program_course_logo' , 'a.program_course_status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_PROGRAM_COURSE . ' a');

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[1]." LIKE '%".$search_string."%')");

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
					$actionStr = '<a href="'.base_url().'admin/program_course/edit/'.$value['program_course_id'].'"><i class="fa fa-lg fa-pencil-square-o global-list-icon" aria-hidden="true"></i></a>';
					$actionStr .= '<a href="'.base_url().'admin/program_course/delete/'.$value['program_course_id'].'" onclick="return confirm_delete()"><i style="margin-left: 9px;" class="fa fa-lg fa-trash-o global-list-icon" aria-hidden="true"></i></a>';
					$statusClass = ($value['program_course_status'] == 1) ? 'fa-check-circle-o' : 'fa-times-circle-o';
					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().PROGRAM_COURSE_IMAGE_PATH.getThumbnailName($value['program_course_logo'])."' width = 90 height = 87 />",
						2 => $value['program_course_name'],
						3 => '<i class="fa fa-lg '.$statusClass.' global-list-status-icon" aria-hidden="true" data-toggle="modal" data-target="#programStatus" data-status_type = '.$value['program_course_status'].' data-program_id = '.$value['program_course_id'].' ></i>',
						4 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_PROGRAM_COURSE)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//Function is used to add program course related data in DB
		function addProgramCourse($data = NULL)
		{
			$this->db->insert(TABLE_PROGRAM_COURSE , $data);
		}

		//Function is used to update program realated record in DB
		function updateProgramCourse($id = NULL , $data = NULL)
		{
			$this->db->where('program_course_id' , $id)
					->update(TABLE_PROGRAM_COURSE , $data);
		}

		//This function is used to get data from DB to show in edit page
		function getEditProgramCourseData($id = NULL)
		{
			return $this->db->select('program_course_id , program_course_name , program_course_description , program_course_logo')
							->where('program_course_id' , $id)
							->get(TABLE_PROGRAM_COURSE)->row_array();
		}

		//This function is used to get junior centre details from DB and show through datatable
		function getjuniorCentreDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL)
		{
			$resultData = array();
			$colomnArr = array('a.junior_centre_id' , 'b.centre_name' , 'a.centre_banner' , 'a.junior_centre_status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_JUNIOR_CENTRE . ' a');
			$this->db->join(TABLE_CENTRE_MASTER.' b' , 'a.centre_id = b.centre_id' , 'left');

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[1]." LIKE '%".$search_string."%')");

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
					$actionStr = '<a href="'.base_url().'admin/junior_centre/edit/'.$value['junior_centre_id'].'"><i class="fa fa-lg fa-pencil-square-o global-list-icon" aria-hidden="true"></i></a>';
					$actionStr .= '<a href="'.base_url().'admin/junior_centre/delete/'.$value['junior_centre_id'].'" onclick="return confirm_delete()"><i style="margin-left: 9px;" class="fa fa-lg fa-trash-o global-list-icon" aria-hidden="true"></i></a>';
					$statusClass = ($value['junior_centre_status'] == 1) ? 'fa-check-circle-o' : 'fa-times-circle-o';
					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().JUNIOR_CENTRE_IMAGE_PATH.getThumbnailName($value['centre_banner'])."' width = 180 height = 50 />",
						2 => $value['centre_name'],
						3 => '<i class="fa fa-lg '.$statusClass.' global-list-status-icon" aria-hidden="true" data-toggle="modal" data-target="#juniorCentreStatus" data-status_type = '.$value['junior_centre_status'].' data-junior_centre_id = '.$value['junior_centre_id'].' ></i>',
						4 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_JUNIOR_CENTRE)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//Function is used to add junior centre related data in DB
		function addJuniorCentre($data = NULL , $fileName = NULL)
		{
			$insertData = array(
				'centre_id' => $data['centre_id'],
				'centre_address' => $data['centre_address'],
				'centre_description' => $data['centre_description'],
				'centre_banner' => $fileName
			);
			$this->db->insert(TABLE_JUNIOR_CENTRE , $insertData);
			$id = $this->db->insert_id();

			//Add multiple program data
			if(!empty($data['centre_program']))
			{
				foreach($data['centre_program'] as $value)
				{
					$insertData = array(
						'program_id' => $value,
						'junior_centre_id' => $id
					);
					$this->db->insert(TABLE_JUNIOR_CENTRE_PROGRAM , $insertData);
				}
			}
		}

		//Function is used to update junior program realated record in DB
		function updateJuniorCentre($id = NULL , $data = NULL , $fileName = NULL , $flag = NULL)
		{
			if($flag == 1)
			{
				$updateData = array(
					'centre_id' => $data['centre_id'],
					'centre_address' => $data['centre_address'],
					'centre_description' => $data['centre_description'],
					'centre_banner' => $fileName
				);
				$this->db->where('junior_centre_id' , $id)
						->update(TABLE_JUNIOR_CENTRE , $updateData);

				//Update multiple program data
				$this->db->where('junior_centre_id' , $id)
						->delete(TABLE_JUNIOR_CENTRE_PROGRAM);
				if(!empty($data['centre_program']))
				{
					foreach($data['centre_program'] as $value)
					{
						$insertData = array(
							'program_id' => $value,
							'junior_centre_id' => $id
						);
						$this->db->insert(TABLE_JUNIOR_CENTRE_PROGRAM , $insertData);
					}
				}
			}
			else
			{
				$this->db->where('junior_centre_id' , $id)
						->update(TABLE_JUNIOR_CENTRE , $data);
			}
		}

		//This function is used to get data from DB to show in edit page
		function getEditJuniorCentreData($id = NULL)
		{
			$result = $this->db->select('junior_centre_id , centre_id , centre_banner , centre_description , centre_address')
							->where('junior_centre_id' , $id)
							->get(TABLE_JUNIOR_CENTRE)->row_array();
			$result['centre_program'] = $this->db->select('program_id')
											->where('junior_centre_id' , $id)
											->get(TABLE_JUNIOR_CENTRE_PROGRAM)->result_array();
			$result['centre_program'] = array_column($result['centre_program'] , 'program_id');
			return $result;
		}
	}
?>