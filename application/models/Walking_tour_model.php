<?php
	class Walking_tour_model extends CI_Model
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the values from database for the groups and create
		*the select tag options and return the html
		*
		*@param NONE
		*@return String $htmlStr : html string
		*/
		public function getGroupDropdown($flag = NULL)
		{
			$htmlStr = '<option value="">Please select group</option>';
			$returnAr = array('' => 'Please select group');
			$result = $this->db->select("id_book as id , concat(id_year , '_' , id_book) as name")
								->where('id_centro' , $this->input->post('centre_id'))
								->where("(status = 'active' or status = 'confirmed')")
								->get(TABLE_PLUS_BOOK)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
				{
					if($flag == 1)
						$returnAr[$value['id']] = $value['name'];
					else
						$htmlStr.= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
				}

			}
			return ($flag == 1) ? $returnAr : $htmlStr;
		}

		/**
		*This function is used to get the day to day activity details from database for both master and extra
		*
		*@param NONE
		*@return String $htmlStr : html string
		*/
		public function getActivityDetails()
		{
			$masterDateResult = $this->db->select('a.date')
									->from(TABLE_FIXED_DAY_ACTIVITY.' a')
									->where("cast(a.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('to_date')))."'")
									->where('centre_id' , $this->input->post('centre_id'))
									->order_by('a.date' , 'asc')
									->get()->result_array();
			if(!empty($masterDateResult))
			{
				if($this->input->post('group_id') != '')
				{
					$masterActivityResult = $this->db->select('a.date , b.from_time , b.to_time , b.activity')
													->from(TABLE_FIXED_DAY_ACTIVITY.' a')
													->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
													->where("cast(a.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('to_date')))."'")
													->where('a.centre_id' , $this->input->post('centre_id'))
													->where("cast(a.date as DATE) not in
																(select (case when group_concat(date) is not null then group_concat(date) else '' end)
																from ".TABLE_EXTRA_DAY_ACTIVITY." where centre_id = '".$this->input->post('centre_id')."'
																and cast(date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('from_date')))."' AND
																'".date('Y-m-d' , strtotime($this->input->post('to_date')))."' AND group_name = '".$this->input->post('group_id')."')"
															)
													->order_by('b.from_time' , 'asc')
													->get()->result_array();
					$extraActivityResult = $this->db->select('a.date , b.from_time , b.to_time , b.activity')
													->from(TABLE_EXTRA_DAY_ACTIVITY.' a')
													->join(TABLE_EXTRA_DAY_ACTIVITY_DETAILS.' b' , 'a.extra_day_activity_id = b.extra_day_activity_id' , 'left')
													->where("cast(a.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('to_date')))."'")
													->where('a.centre_id' , $this->input->post('centre_id'))
													->where('a.group_name' , $this->input->post('group_id'))
													->order_by('b.from_time' , 'asc')
													->get()->result_array();
					$activityResult = array_merge($masterActivityResult , $extraActivityResult);
				}
				else
				{
					$activityResult = $this->db->select('a.date , b.from_time , b.to_time , b.activity')
											->from(TABLE_FIXED_DAY_ACTIVITY.' a')
											->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' b' , 'a.fixed_day_activity_id = b.fixed_day_activity_id' , 'left')
											->where("cast(a.date as DATE) between '".date('Y-m-d' , strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d' , strtotime($this->input->post('to_date')))."'")
											->where('centre_id' , $this->input->post('centre_id'))
											->order_by('b.from_time' , 'asc')
											->get()->result_array();
				}
				//Create date reference array
				foreach($masterDateResult as $value)
					$referenceArr[] = $value['date'];
				//Create preview array
				foreach($activityResult as $key => $value)
					$previewArr[date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['date']] = $value['activity'];
				ksort($previewArr);
				return $this->previewActivity($referenceArr , $previewArr , $this->input->post('centre_id'));
			}
		}

		/**
		*This function is used to perpare the proper report to preview for activities
		*
		*@param Array $referenceArr : For the unique dates
		*@param Array $previewArr : date and time wise activity array
		*@return String $htmlStr : html string
		*/
		private function previewActivity($referenceArr = array() , $previewArr = array() , $centreId = NULL)
		{
			$htmlStr = '';
			$centreName = $this->db->select('nome_centri')
								->where('id' , $centreId)
								->get(TABLE_CENTRE)->row_array();

			//Prepare the HTML for the preview
			$headerSectionStr = '<div>
									<div class="col-lg-4"><img src="'.base_url().'images/logo_plus.png" /></div>
									<div class="col-lg-6">
										<p class="showCentrePreview">'.
											strtoupper($centreName['nome_centri']).'&nbsp;&nbsp;'.date('Y' , strtotime($referenceArr[0]))
										.'</p>
									</div>
								</div>';

			$htmlStr.= '<div style="width:100%;overflow:scroll;margin-top: 75px;">
						<table border="1" class="table table-bordered previewTable" width="100%">
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

			//Save the main designing in session to use in export pdf option
			$this->session->set_userdata('activityHtmlStr' , $htmlStr);
			$htmlStr = $headerSectionStr.$htmlStr;
			return $htmlStr;
		}
	}
