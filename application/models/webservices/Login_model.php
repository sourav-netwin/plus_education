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
						->order_by('nome_centri' , 'asc')
						->get(TABLE_CENTRE)->result_array();
		}
	}
