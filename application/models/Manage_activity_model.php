<?php
	/**
	* This class is usd to manage all the database related operations for the manage activity module
	*
	*@category	Model
	*@author	S.D
	*/
	class Manage_activity_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the details of daily activity to show in the listing page
		*
		*@param NONE
		*@return Array $resultData : details of the activity
		*/
		public function getActivityDetails()
		{
			$resultData = array();
			$colomnArr = array('a.plus_activity_id' , 'a.name' , 'b.nome_centri' , 'a.added_date' , 'a.status' , 'a.front_image' , 'a.sequence');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_PLUS_ACTIVITY_MANAGEMENT . ' a');
			$this->db->join(TABLE_CENTRE.' b' , 'a.centre_id = b.id' , 'left');
			$this->db->where('a.delete_flag' , 0);
			if($this->session->userdata('centre_id') != '')
				$this->db->where('b.id' , $this->session->userdata('centre_id'));
			$this->db->order_by('sequence' , 'asc');
			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $key => $value)
				{
					$sequenceStr = '<span>';
					if(($key+1) != count($result))
						$sequenceStr.= '<i class="fa fa-arrow-circle-down moveDown changeSequenceIcon"></i>';
					if($key != 0)
					{
						$style = (($key+1) == count($result)) ? '42px' : '20px';
						$sequenceStr.= '<i class="fa fa-arrow-circle-up moveUp changeSequenceIcon" style="margin-left : '.$style.'"></i>';
					}
					$sequenceStr.= '</span>';

					$actionStr ="<div class='btn-group custom-btn-group'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().'manage_activity/add_edit/'.$value['plus_activity_id'].'" data-toggle="tooltip" data-original-title="Edit Activity"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a class="btn btn-xs btn-danger btn-wd-24" href="'.base_url().'manage_activity/delete/'.$value['plus_activity_id'].'" onclick="return confirm_delete()" data-toggle="tooltip" data-original-title="Delete activity"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					$statusClass = ($value['status'] == 1) ? 'fa-check-square-o' : 'fa-square-o';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Change Status for activity" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon"><span><i class="fa '.$statusClass.'" aria-hidden="true" data-toggle="modal" data-target="#juniorCentreStatus" data-status_type = '.$value['status'].' data-activity_id = '.$value['plus_activity_id'].' ></i></span></a>';
					$actionStr .="</div>";

					$resultData[] = array(
						0 => $siNo++,
						1 => $value['name'],
						2 => $value['nome_centri'],
						3 => date('d-m-Y' , strtotime($value['added_date'])),
						4 => $sequenceStr,
						5 => $actionStr,
						6 => $value['plus_activity_id'],
						7 => $value['sequence']
					);
				}
			}
			return $resultData;
		}

		/**
		*This function is used to get the user uuid list for the selected centre in plus
		*walking tour module(to send notification)
		*
		*@access public
		*@author S.D
		*@since 31th May , 2018
		*@param Integer $centreId : The centre id
		*@return NONE
		*/
		public function getUserUuid($centreId = NULL)
		{
			$returnArr = array();
			$userIdArr = $this->db->select('a.uuid')
							->from(TABLE_PLUSED_ROWS.' a')
							->join(TABLE_PLUS_BOOK.' b' , 'a.id_book = b.id_book' , 'left')
							->join(TABLE_USER_DEVICES.' c' , 'c.user_id = a.uuid' , 'left')
							->where('b.id_centro' , $centreId)
							->where('c.user_id != ' , '')
							->order_by('id_prenotazione' , 'DESC')
							->get()->result_array();
			if(!empty($userIdArr))
			{
				foreach($userIdArr as $value)
					$returnArr[] = $value['uuid'];
			}
			return $returnArr;
		}
	}
?>