<?php
	class Extra_activity_model extends CI_Model
	{
		//This is the construct
		public function __construct()
		{
			parent::__construct();
		}

		//This function is used to get the extra activity details for the selected date , centre and group
		private function getExtraActivity()
		{
			$returnArr = $this->db->select('a.*')
							->from(TABLE_EXTRA_DAY_ACTIVITY_DETAILS.' a')
							->join(TABLE_EXTRA_DAY_ACTIVITY.' b' , 'a.extra_day_activity_id = b.extra_day_activity_id' , 'left')
							->where('b.centre_id' , $this->input->post('centre_id'))
							->where('b.group_name' , $this->input->post('group_name'))
							->where('b.date' , date('Y-m-d' , strtotime($this->input->post('date'))))
							->order_by('extra_day_activity_details_id' , 'asc')
							->get()->result_array();
			return (!empty($returnArr)) ? $returnArr : $this->getMasterActivity();
		}

		//This function is used to get the master activity details for the selected date and centre
		public function getMasterActivity()
		{
			return $this->db->select('a.*')
							->from(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' a')
							->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
							->where('b.centre_id' , $this->input->post('centre_id'))
							->where('b.date' , date('Y-m-d' , strtotime($this->input->post('date'))))
							->order_by('fixed_day_activity_details_id' , 'asc')
							->get()->result_array();
		}

		//This function is used to delete the old extra activity and add the new one
		public function updateActivity()
		{
			$extraActivity = $this->db->select('extra_day_activity_id')
					->where('centre_id' , $this->input->post('centre_id'))
					->where('group_name' , $this->input->post('group_name'))
					->where('date' , date('Y-m-d' , strtotime($this->input->post('date'))))
					->get(TABLE_EXTRA_DAY_ACTIVITY)->row_array();
			if(!empty($extraActivity))
			{
				$this->db->where('extra_day_activity_id' , $extraActivity['extra_day_activity_id'])
						->delete(TABLE_EXTRA_DAY_ACTIVITY_DETAILS);
				$extraActivityId = $extraActivity['extra_day_activity_id'];
			}
			else
			{
				$data = array(
					'centre_id' => $this->input->post('centre_id'),
					'group_name' => $this->input->post('group_name'),
					'date' => date('Y-m-d' , strtotime($this->input->post('date')))
				);
				$this->db->insert(TABLE_EXTRA_DAY_ACTIVITY , $data);
				$extraActivityId = $this->db->insert_id();
			}
			$programNameArr = $this->input->post('program_name');
			$locationArr = $this->input->post('location');
			$activityArr = $this->input->post('activity');
			$fromTimeArr = $this->input->post('from_time');
			$toTimeArr = $this->input->post('to_time');
			$managedByArr = $this->input->post('managed_by');
			if(!empty($programNameArr))
			{
				foreach($programNameArr as $key => $value)
				{
					$data = array(
						'program_name' => $value,
						'location' => $locationArr[$key],
						'activity' => $activityArr[$key],
						'from_time' => $fromTimeArr[$key],
						'to_time' => $toTimeArr[$key],
						'managed_by' => $managedByArr[$key],
						'extra_day_activity_id' => $extraActivityId
					);
					$this->db->insert(TABLE_EXTRA_DAY_ACTIVITY_DETAILS , $data);
				}
			}
		}

		/**
		*This function is used to get the group reference number from booking table according to -
		*arrval and departure date , centre name , with active and confirm status - to show in the
		*group reference dropdown
		*
		*@param NONE
		*@return Array $returnArr : dropdown array with id as key and reference number as value
		*/
		public function getGroupReference()
		{
			$returnArr = array(
				'' => 'Please select group'
			);
			$result = $this->db->select("id_book as id , concat(id_year , '_' , id_book) as name" , FALSE)
								->where("'".date('Y-m-d' , strtotime($this->input->post('date')))."' between arrival_date and departure_date" , NULL , FALSE)
								->where("(status = 'confirmed' OR status = 'active')")
								->where('id_centro' , $this->input->post('centre_id'))
								->get(TABLE_PLUS_BOOK)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr[$value['id']] = $value['name'];
			}
			return $returnArr;
		}

		/**
		*This function is used to prepare the html for the extra activity details to show
		*
		*@param NONE
		*@return String $htmlStr : the html string
		*/
		public function createActivityDetails()
		{
			$htmlStr = '';
			$detailsArr = $this->getExtraActivity();
			if(!empty($detailsArr))
			{
				foreach($detailsArr as $value)
					$htmlStr.= $this->createHtml($value , count($detailsArr));
			}
			return $htmlStr;
		}

		/**
		*This function is used to create the dynamic HTML string for the extra activity details section
		*
		*@param Array $data : the values for the field
		*@param Array $globalCount : the count of the total element
		*@return String $htmlStr : the html string
		*/
		public function createHtml($data = array() , $globalCount = NULL)
		{
			$htmlStr = '<div class="addMoreWrapper">
							<div class="form-group form-border-box-wrapper">
								<div class="form-group col-lg-4 marginRightClass">
									<label>Type of activity</label>
									<input name="program_name[]" value="'.$data['program_name'].'" class="form-control" placeholder="Program Name" type="text">
									<span class="error showErrorMsg"></span>
								</div>
								<div class="form-group col-lg-4 marginRightClass">
									<label>Location</label>
									<input name="location[]" value="'.$data['location'].'" class="form-control" placeholder="Location" type="text">
									<span class="error showErrorMsg"></span>
								</div>
								<div class="form-group col-lg-4 marginRightClass">
									<label>Activity</label>
									<input name="activity[]" value="'.$data['activity'].'" class="form-control" placeholder="Activity" type="text">
									<span class="error showErrorMsg"></span>
								</div>
								<div class="form-group col-lg-4 marginRightClass">
									<label>From time</label>
									<div class="input-append date timepicker" style="width: 90%;">
										<input name="from_time[]" value="'.$data['from_time'].'" class="form-control" placeholder="From Time" data-format="hh:mm:ss" type="text">
										<span class="add-on" style="height:34px;">
											<i class="fa fa-lg fa-clock icon-time"></i>
										</span>
									</div>
									<span class="error showErrorMsg"></span>
								</div>
								<div class="form-group col-lg-4 marginRightClass">
									<label>To time</label>
									<div class="input-append date timepicker" style="width: 90%;">
										<input name="to_time[]" value="'.$data['to_time'].'" class="form-control" placeholder="To Time" data-format="hh:mm:ss" type="text">
										<span class="add-on" style="height:34px;">
											<i class="fa fa-lg fa-clock icon-time"></i>
										</span>
									</div>
									<span class="error showErrorMsg"></span>
								</div>
								<div class="form-group col-lg-4 marginRightClass">
									<label>Managed by</label>
									<input name="managed_by[]" value="'.$data['managed_by'].'" class="form-control" placeholder="Managed by" type="text">
									<span class="error showErrorMsg"></span>
								</div>
							</div>
							<div style="float: right; margin-top:-12px;">
								<i class="fa fa-lg fa-plus-circle add_section addMoreTable" aria-hidden="true"></i>';
			if($globalCount > 1)
				$htmlStr.= '<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>';
			$htmlStr.= '</div><br>
						</div>';
			return $htmlStr;
		}
	}
