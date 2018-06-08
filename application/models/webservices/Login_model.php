<?php
	/**
	*This class is used to the manage all the login related checking and get data from
	*database for both student and GL
	*
	*@package Login_model Class
	*@category Model
	*@author S.D
	*/
	class Login_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to check the student logged in data is valid or not and
		*return the details of the student
		*
		*@access public
		*@param String $userFirstName
		*@param String $userSurname
		*@param String $userDob
		*@param Integer $centreId
		*@return Array
		*/
		public function checkStudentLogin($userFirstName = NULL , $userSurname = NULL , $userDob = NULL , $centreId = NULL)
		{
			return $this->db->select('a.*')
						->from(TABLE_PLUSED_ROWS.' a')
						->join(TABLE_PLUS_BOOK.' b' , 'a.id_book = b.id_book' , 'left')
						->where('a.nome' , $userFirstName)
						->where('a.cognome' , $userSurname)
						->where("CAST(a.pax_dob AS DATE) = '".date('Y-m-d' , strtotime($userDob))."'")
						->where('a.tipo_pax' , 'STD')
						->where('b.id_centro' , $centreId)
						->order_by('id_prenotazione' , 'DESC')
						->get()->row_array();
		}

		/**
		*This function is used to check the GL logged in data is valid or not and
		*return the details of the GL
		*
		*@access public
		*@param String $userFirstName
		*@param String $userSurname
		*@param String $userDob
		*@param Integer $bookingId
		*@return Array
		*/
		public function checkGlLogin($userFirstName = NULL , $userSurname = NULL , $userDob = NULL , $bookingId = NULL)
		{
			return $this->db->select('a.*')
						->from(TABLE_PLUSED_ROWS.' a')
						->where('a.nome' , $userFirstName)
						->where('a.cognome' , $userSurname)
						->where("CAST(a.pax_dob AS DATE) = '".date('Y-m-d' , strtotime($userDob))."'")
						->where('a.tipo_pax' , 'GL')
						->where('a.id_book' , $bookingId)
						->order_by('id_prenotazione' , 'DESC')
						->get()->row_array();
		}

		/**
		*This function is used to get the bookings(formatting with year , centre name and booking id)
		*with the help of group leader name , surname and dob
		*
		*@access public
		*@param String $userFirstName
		*@param String $userSurname
		*@param String $userDob
		*@return Array
		*/
		public function getBookingsForLogin($userFirstName = NULL , $userSurname = NULL , $userDob = NULL , $centreId = NULL)
		{
			$arrivalYear = '2018';
			return $this->db->select('CONCAT(a.id_year , "_" , a.id_book , " - " , c.nome_centri) as booking_id , a.id_book' , false)
						->from(TABLE_PLUSED_ROWS.' a')
						->join(TABLE_PLUS_BOOK.' b' , 'a.id_book = b.id_book' , 'left')
						->join(TABLE_CENTRE.' c' , 'b.id_centro = c.id' , 'left')
						->where('a.nome' , $userFirstName)
						->where('a.cognome' , $userSurname)
						->where("CAST(a.pax_dob AS DATE) = '".date('Y-m-d' , strtotime($userDob))."'")
						->where('a.tipo_pax' , 'GL')
						->where('YEAR(a.data_partenza_campus)' , $arrivalYear)
						->order_by('id_prenotazione' , 'DESC')
						->get()->result_array();
		}

		/**
		*This function is get the centre id and name from database
		*
		*@access public
		*@param NONE
		*@return Array
		*/
		function getCentreDetails()
		{
			return $this->db->select('id as id , nome_centri as name')
						->where('attivo' , 1)
						->or_where('(is_mini_stay = 1 and attivo = 0)')
						//Statically get centre temporary(To get the LONDON TWICHENHAM centre)
						->or_where('id' , 45)
						->order_by('nome_centri' , 'asc')
						->get(TABLE_CENTRE)->result_array();
		}

		/**
		*This function is used to get the full centre image path to show in the dashboard
		*
		*@access public
		*@param Integer $id : Can be centre id or the plused_rows primary key
		*@param Integer $type : If 1 then centre id & 2 then primary key
		*@return Array
		*/
		public function getCentreImage($id = NULL , $type = NULL)
		{
			$returnArr = array();
			if($type == 1)
				$centreId = $id;
			elseif($type == 2)
			{
				$result = $this->db->select('b.id_centro')
								->from(TABLE_PLUSED_ROWS.' a')
								->join(TABLE_PLUS_BOOK.' b' , 'a.id_book = b.id_book' , 'left')
								->where('a.id_prenotazione' , $id)
								->get()->row_array();
				$centreId = $result['id_centro'];
			}

			$result = $this->db->select('centre_banner , path , nome_centri')
							->from(TABLE_CENTRE)
							->join("((SELECT centre_id , centre_banner , '".JUNIOR_MINISTAY_IMAGE_PATH."' as path from frontweb_junior_ministay)union (select centre_id , centre_banner , '".JUNIOR_CENTRE_IMAGE_PATH."' as path from frontweb_junior_centre))t" , 't.centre_id=id' , 'left')
							->where('id' , $centreId)
							->get()->row_array();
			if(!empty($result))
			{
				$returnArr = array(
					'centreId' => $centreId,
					'centreName' => $result['nome_centri'],
					'originalCentreImage' => ADMIN_PANEL_URL.$result['path'].$result['centre_banner'],
					'thumbCentreImage' => ADMIN_PANEL_URL.$result['path'].getThumbnailName($result['centre_banner']),
				);
			}
			return $returnArr;
		}

		/**
		*This function is used to get the user details using the user id
		*
		*@access public
		*@author S.D
		*@since 23rd May , 2018
		*@param Integer $userId
		*@return Array
		*/
		public function getUserData($userId = NULL)
		{
			return $this->db->select("concat(nome , ' ' , cognome) as user_name , uuid , date_format(pax_dob , '%d/%m/%Y') as dob" , FALSE)
							->where('id_prenotazione' , $userId)
							->get(TABLE_PLUSED_ROWS)->row_array();
		}

		/**
		*This function is used to save the device information into the database
		*
		*@author S.D
		*@since 30th May , 2018
		*@access public
		*@param String $deviceType : (A = for android & I = for ios)
		*@param String $deviceId : The device id
		*@param Integer $userId : The user id
		*@return NONE
		*/
		public function saveDeviceInfo($deviceType = NULL , $deviceId = NULL , $userId = NULL)
		{
			$result = $this->db->select('user_device_id')
							->where('user_id' , $userId)
							->where('device_type' , $deviceType)
							->get(TABLE_USER_DEVICES)->row_array();
			if(!empty($result))
			{
				$updateData = array(
					'device_id' => $deviceId
				);
				$this->db->where('user_device_id' , $result['user_device_id'])
						->update(TABLE_USER_DEVICES , $updateData);
			}
			else
			{
				$insertData = array(
					'user_id' => $userId,
					'device_id' => $deviceId,
					'device_type' => $deviceType,
					'created_on' => date('Y-m-d H:i:s')
				);
				$this->db->insert(TABLE_USER_DEVICES , $insertData);
			}
		}
	}
