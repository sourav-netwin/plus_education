<?php
	class master_activity_model extends CI_Model
	{
		//This is the construuctor
		public function __construct()
		{
			parent::__construct();
		}

		//This function is used to get the details fields for the activity details(Add more section)
		public function getAddMoreField($post = array() , $globalCount = NULL)
		{
			$htmlStr = '<div class="addMoreWrapper"><div class="form-group form-border-box-wrapper">
							<h4 style="margin-bottom: 20px;"><u>Activity Details : </u></h4>
							<div class="form-group"><label>Type of activity</label>';
			$inputAttribute = array(
				'name' => 'program_name[]',
				'class' => 'form-control',
				'placeholder' => 'Program Name',
				'value' => (isset($post['program_name'])) ? $post['program_name'] : ''
			);
			$htmlStr.= form_input($inputAttribute);
			$htmlStr.= '<span class="error showErrorMsg"></span></div><div class="form-group"><label>Location</label>';
			$inputAttribute = array(
				'name' => 'location[]',
				'class' => 'form-control',
				'placeholder' => 'Location',
				'value' => (isset($post['location'])) ? $post['location'] : ''
			);
			$htmlStr.= form_input($inputAttribute);
			$htmlStr.= '<span class="error showErrorMsg"></span></div><div class="form-group"><label>Activity</label>';
			$inputAttribute = array(
				'name' => 'activity[]',
				'class' => 'form-control',
				'placeholder' => 'Activity',
				'value' => (isset($post['activity'])) ? $post['activity'] : ''
			);
			$htmlStr.= form_input($inputAttribute);
			$htmlStr.= '<span class="error showErrorMsg"></span></div><div class="form-group"><label>From time</label>';
			$htmlStr.= '<div class="input-append date timepicker" style="width: 90%;">';
			$inputAttribute = array(
				'name' => 'from_time[]',
				'class' => 'form-control',
				'placeholder' => 'From Time',
				'value' => (isset($post['from_time'])) ? $post['from_time'] : '',
				'data-format' => 'hh:mm:ss'
			);
			$htmlStr.= form_input($inputAttribute);
			$htmlStr.= '<span class="add-on" style="height:34px;"><i class="fa fa-lg fa-clock icon-time"></i></span></div>';
			$htmlStr.= '<span class="error showErrorMsg"></span></div><div class="form-group"><label>To time</label>';
			$htmlStr.= '<div class="input-append date timepicker" style="width: 90%;">';
			$inputAttribute = array(
				'name' => 'to_time[]',
				'class' => 'form-control',
				'placeholder' => 'To Time',
				'value' => (isset($post['to_time'])) ? $post['to_time'] : '',
				'data-format' => 'hh:mm:ss'
			);
			$htmlStr.= form_input($inputAttribute);
			$htmlStr.= '<span class="add-on" style="height:34px;"><i class="fa fa-lg fa-clock icon-time"></i></span></div>';
			$htmlStr.= '<span class="error showErrorMsg"></span></div><div class="form-group"><label>Managed by</label>';
			$inputAttribute = array(
				'name' => 'managed_by[]',
				'class' => 'form-control',
				'placeholder' => 'Managed by',
				'value' => (isset($post['managed_by'])) ? $post['managed_by'] : ''
			);
			$htmlStr.= form_input($inputAttribute);
			$htmlStr.= '<span class="error showErrorMsg"></span></div></div>';
			$htmlStr.= '<div style="float: right; margin-top:-12px;">
							<i class="fa fa-lg fa-plus-circle add_section addMoreTable" aria-hidden="true"></i>';
			if($globalCount > 1)
				$htmlStr.= '<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>';
			$htmlStr.= '</div><br></div>';
			return $htmlStr;
		}

		//this function is used to get the data to show in the edit page
		public function getData($id = NULL)
		{
			$result = $this->db->select("centre_id , date_format(date , '%d-%c-%Y') as date" , FALSE)
							->where('fixed_day_activity_id' , $id)
							->get(TABLE_FIXED_DAY_ACTIVITY)->row_array();
			$result['details'] = $this->db->where('fixed_day_activity_id' , $id)
										->order_by('fixed_day_activity_details_id' , 'asc')
										->get(TABLE_FIXED_DAY_ACTIVITY_DETAILS)->result_array();
			return $result;
		}

		//This function is used to get the details of activities according to the date and perpare the proper report to preview
		public function previewActivity()
		{
			$htmlStr = '';
			$previewArr = $referenceArr = array();
			$centreName = $this->db->select('nome_centri')
								->where('id' , $this->input->post('centre_id'))
								->get(TABLE_CENTRE)->row_array();
			$result = $this->db->select('a.date , b.from_time , b.to_time , b.activity')
								->from(TABLE_FIXED_DAY_ACTIVITY.' a')
								->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
								->where("cast(a.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
								->where('centre_id' , $this->input->post('centre_id'))
								->order_by('b.from_time' , 'asc')
								->get()->result_array();
			if(!empty($result))
			{
				$dateResult = $this->db->select('a.date')
									->from(TABLE_FIXED_DAY_ACTIVITY.' a')
									->where("cast(a.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
									->where('centre_id' , $this->input->post('centre_id'))
									->order_by('a.date' , 'asc')
									->get()->result_array();
				foreach($dateResult as $value)
					$referenceArr[] = $value['date'];

				foreach($result as $key => $value)
					$previewArr[date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['date']] = $value['activity'];

				//Prepare the HTML for the preview
				$htmlStr.= '<div>
								<div class="col-lg-4"><img src="'.base_url().'images/logo_plus.png" /></div>
								<div class="col-lg-6">
									<p class="showCentrePreview">'.
										strtoupper($centreName['nome_centri']).'&nbsp;&nbsp;'.date('Y' , strtotime($referenceArr[0]))
									.'</p>
								</div>
							</div>
							<div style="width:100%;overflow:scroll;">
							<table class="table table-bordered previewTable" width="100%">
								<thead>
									<tr>
										<th align="center" colspan="2">Day</th>';
				foreach($referenceArr as $dateValue)
					$htmlStr.= '<th>'.date('d-M-Y' , strtotime($dateValue)).'</th>';
				$htmlStr.= '</tr>
								<tr>
									<th>From</th>
									<th>To</th>';
				foreach($referenceArr as $dateValue)
					$htmlStr.= '<th>'.date('l' , strtotime($dateValue)).'</th>';
				$htmlStr.= '</tr>
							</thead>
							<tbody>';
				foreach($previewArr as $key => $value)
				{
					$timeArr = explode('-' , $key);
					$htmlStr.= '<tr style="height: 50px;">
									<td>'.$timeArr[0].'</td>
									<td>'.$timeArr[1].'</td>';
					foreach($referenceArr as $dateValue)
					{
						$showValue = (isset($value[$dateValue])) ? $value[$dateValue] : '';
						$htmlStr.= '<td>'.$showValue.'</td>';
					}
					$htmlStr.= '</tr>';
				}
				$htmlStr.= '</tbody>
						</table></div>';
			}
			return $htmlStr;
		}

		//This function is used to get the master activity details to show in the activity report
		public function getActivityReport($whereCondition = NULL)
		{
			$this->db->select('a.date , b.*');
			$this->db->from(TABLE_FIXED_DAY_ACTIVITY.' a');
			$this->db->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left');
			$this->db->where("cast(a.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'");
			$this->db->where('centre_id' , $this->input->post('centre_id'));
			if($whereCondition != '')
				$this->db->where($whereCondition);
			$this->db->order_by('a.date asc , b.from_time asc');
			return $this->db->get()->result_array();
		}

		//This function is usd to get the dropdown details for the activity report filers
		public function getActivityFilterDropdown()
		{
			$returnArr = array();
			$result = $this->db->select('distinct date as date' , FALSE)
							->where('centre_id' , $this->input->post('centre_id'))
							->where("cast(date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
							->order_by('date' , 'asc')
							->get(TABLE_FIXED_DAY_ACTIVITY)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['dateValue'][] = $value['date'];
			}
			$result = $this->db->select('distinct a.program_name as program_name' , FALSE)
								->from(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' a')
								->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
								->where('b.centre_id' , $this->input->post('centre_id'))
								->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
								->order_by('a.program_name' , 'asc')
								->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['proramName'][] = $value['program_name'];
			}
			$result = $this->db->select('distinct a.location as location' , FALSE)
								->from(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' a')
								->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
								->where('b.centre_id' , $this->input->post('centre_id'))
								->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
								->order_by('a.location' , 'asc')
								->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['location'][] = $value['location'];
			}
			$result = $this->db->select('distinct a.activity as activity' , FALSE)
								->from(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' a')
								->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
								->where('b.centre_id' , $this->input->post('centre_id'))
								->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
								->order_by('a.activity' , 'asc')
								->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['activity'][] = $value['activity'];
			}
			$result = $this->db->select('distinct a.from_time as from_time' , FALSE)
								->from(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' a')
								->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
								->where('b.centre_id' , $this->input->post('centre_id'))
								->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
								->order_by('a.from_time' , 'asc')
								->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['fromTime'][] = $value['from_time'];
			}
			$result = $this->db->select('distinct a.to_time as to_time' , FALSE)
								->from(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' a')
								->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
								->where('b.centre_id' , $this->input->post('centre_id'))
								->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
								->order_by('a.to_time' , 'asc')
								->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['toTime'][] = $value['to_time'];
			}
			$result = $this->db->select('distinct a.managed_by as managed_by' , FALSE)
								->from(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' a')
								->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
								->where('b.centre_id' , $this->input->post('centre_id'))
								->where("cast(b.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('start_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('end_date')))."'")
								->order_by('a.managed_by' , 'asc')
								->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr['managedBy'][] = $value['managed_by'];
			}
			return $returnArr;
		}

		//This function is usd to get the activity details to show in the exported excel file
		public function getExportActivity()
		{
			$returnArr = array();
			$this->db->select('a.date , b.*');
			$this->db->from(TABLE_FIXED_DAY_ACTIVITY.' a');
			$this->db->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left');
			$this->db->where("cast(a.date as DATE) between '".date('Y-m-d' , strtotime($this->session->userdata('start_date')))."' AND '".date('Y-m-d' , strtotime($this->session->userdata('end_date')))."'");
			$this->db->where('centre_id' , $this->session->userdata('centre_id'));
			if($this->session->userdata('whereCondition') != '')
				$this->db->where($this->session->userdata('whereCondition'));
			$this->db->order_by('a.date asc , b.from_time asc');
			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$returnArr[$key]['Date'] = date('d-M-Y' , strtotime($value['date']));
					$returnArr[$key]['Type of activity'] = $value['program_name'];
					$returnArr[$key]['Location'] = $value['location'];
					$returnArr[$key]['Activity'] = $value['activity'];
					$returnArr[$key]['From time'] = date('H:i' , strtotime($value['from_time']));
					$returnArr[$key]['To time'] = date('H:i' , strtotime($value['to_time']));
					$returnArr[$key]['Managed by'] = $value['managed_by'];
				}
			}
			return $returnArr;
		}

		/**
		*This function is used to check is there any duplicate activity present
		*for a centre and dates(check for copy activity)
		*
		*@param Array $dateArr : date array
		*@param Integer $id : master activity id
		*@return Array
		*/
		public function getDuplicateActivity($dateArr = array() , $id = NULL)
		{
			return $this->db->select('count(*) as total')
							->where('centre_id = (select centre_id from '.TABLE_FIXED_DAY_ACTIVITY.' where fixed_day_activity_id = '.$id.')')
							->where_in('date' , $dateArr)
							->get(TABLE_FIXED_DAY_ACTIVITY)->row_array();
		}
	}
?>