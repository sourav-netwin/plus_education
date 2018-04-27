<?php
	/*
	This model is used to perform all the database related operations for all the master modules.
	Developed by : S.D
	Date : 14th February , 2018
	*/
	class Mastermodel extends CI_Model
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
		}

		//This function is used to get the module wise language array details from master_lang.php
		public function getModule($moduleName = NULL)
		{
			$moduleArr = array();
			if($moduleName != '')
				$moduleArr = lang($moduleName);
			return $moduleArr;
		}

		//This function is used to get the module details from database and perpare proper data to show in the datatable
		public function getDatatable($moduleName = NULL , $start = NULL , $length = NULL , $searchString = NULL , $orderColumn = NULL , $orderDir = NULL)
		{
			$resultData = array();
			$moduleArr = $this->getModule($moduleName);
			$this->db->select($this->getSelectColumn($moduleArr , 'list' , $moduleName));
			$this->db->from($moduleArr['dbName']);
			if(isset($moduleArr['listWhere']))
				$this->db->where($moduleArr['listWhere']);

			//For searching
			if($searchString != '')
			{
				foreach($moduleArr['list'] as $key => $value)
				{
					if($key != 'actionColumn' && $value['type'] == 'text')
						$this->db->where("(".$key." LIKE '%".$searchString."%')");
				}
			}

			//For Ordering
			if($orderColumn != '' && $orderDir != '')
			{
				foreach($moduleArr['list'] as $key => $value)
				{
					if($value['columnNo'] == $orderColumn)
						$this->db->order_by($key , $orderDir);
				}
			}

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $key => $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group'>";
					if(in_array('edit' , $moduleArr['list']['actionColumn']['actionType']))
					{
						$url = ($moduleName == 'manage_fixed_activity') ? 'master_activity/add_edit/'.$value[$moduleArr['key']] : 'master/add_edit/'.$moduleName.'/'.$value[$moduleArr['key']];
						if($moduleName == 'manage_activity_photogallery')
						{
							if($value['added_type'] == 2)
								$actionStr.= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().$url.'" data-toggle="tooltip" data-original-title="Edit '.$moduleArr['title'].'"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
						}
						else
							$actionStr.= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().$url.'" data-toggle="tooltip" data-original-title="Edit '.$moduleArr['title'].'"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					}
					if(in_array('status' , $moduleArr['list']['actionColumn']['actionType']))
					{
						$statusClass = ($value[$moduleArr['statusField']] == 1) ? 'fa-check-square-o' : 'fa-square-o';
						if($moduleName == 'manage_activity_photogallery')
						{
							if($value['added_type'] == 2)
								$actionStr.= '<a data-module="'.$moduleName.'" data-module_title="'.$moduleArr['title'].'" data-status="'.$value[$moduleArr['statusField']].'" data-id="'.$value[$moduleArr['key']].'" data-toggle="tooltip" data-original-title="Change Status for '.$moduleArr['title'].'" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon statusIcon"><span><i class="fa '.$statusClass.'" aria-hidden="true"></i></span></a>';
						}
						else
							$actionStr.= '<a data-module="'.$moduleName.'" data-module_title="'.$moduleArr['title'].'" data-status="'.$value[$moduleArr['statusField']].'" data-id="'.$value[$moduleArr['key']].'" data-toggle="tooltip" data-original-title="Change Status for '.$moduleArr['title'].'" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon statusIcon"><span><i class="fa '.$statusClass.'" aria-hidden="true"></i></span></a>';
					}

					//For master activity module(copy master activity for groups)
					if($moduleName == 'manage_fixed_activity')
					{
						$copyIconArr = $this->showCopyActivityIcon($value);
						if($copyIconArr['show'] == 1)
							$actionStr.= '<a data-id="'.$value[$moduleArr['key']].'" data-toggle="tooltip" data-original-title="Copy master activity" class="btn btn-xs btn-success btn-wd-24 copyMasterActivity"><span><i class="fa fa-copy" aria-hidden="true"></i></span></a>';
					}

					$actionStr.= "</div>";

					$resultData[$key][0] = $siNo++;
					foreach($moduleArr['list'] as $fieldKey => $fieldValue)
					{
						if($fieldKey == 'actionColumn')
							$resultData[$key][$fieldValue['columnNo']] = $actionStr;
						elseif($fieldValue['type'] == 'text')
							$resultData[$key][$fieldValue['columnNo']] = $value[$fieldKey];
						elseif($fieldValue['type'] == 'image')
							$resultData[$key][$fieldValue['columnNo']] = "<img src = '".ADMIN_PANEL_URL.$fieldValue['uploadPath'].getThumbnailName($value[$fieldKey])."' width = ".$fieldValue['thumbWidth']." height = ".$fieldValue['thumbHeight']." />";
						elseif($fieldValue['type'] == 'date')
							$resultData[$key][$fieldValue['columnNo']] = date('d-m-Y' , strtotime($value[$fieldKey]));
						elseif($fieldValue['type'] == 'dropdown')
							$resultData[$key][$fieldValue['columnNo']] = $this->dropdown($fieldValue['module'] , 1 , $value[$fieldKey]);
						elseif($fieldValue['type'] == 'link')
							$resultData[$key][$fieldValue['columnNo']] = '<a href = "'.$value[$fieldKey].'" target="_blank">'.$value[$fieldKey].'</a>';
						elseif($fieldValue['type'] == 'datetime')
							$resultData[$key][$fieldValue['columnNo']] = date('d-m-Y H:i:s' , strtotime($value[$fieldKey]));
					}
				}
			}

			$count_all = $this->db->select('count(*) as total')->get($moduleArr['dbName'])->row_array();
			return array(
				'count_all' => $count_all['total'],
				'data' => $resultData
			);
		}

		//This function is used to get the form data to show in the edit page
		function getFormData($moduleName = NULL , $id = NULL)
		{
			$moduleArr = $this->getModule($moduleName);
			$result = $this->db->select($this->getSelectColumn($moduleArr , 'edit' , $moduleName))
							->where($moduleArr['key'] , $id)
							->get($moduleArr['dbName'])->row_array();
			//For sub table
			foreach($moduleArr['field'] as $key => $value)
			{
				if($value['type'] == 'subtable')
				{
					$subtableArr = $this->getModule($key);
					$result[$key] = $this->db->select($this->getSelectColumn($subtableArr , 'edit' , $moduleName))
											->where($subtableArr['foreignKey'] , $id)
											->order_by($subtableArr['key'] , 'asc')
											->get($subtableArr['dbName'])->result_array();
				}
				if($value['type'] == 'date')
					$result[$key] = date('d-m-Y' , strtotime($result[$key]));
			}
			return $result;
		}

		//This function is used to return the select columns for any module (listing/add_edit page)
		private function getSelectColumn($moduleArr = array() , $type = NULL , $module = NULL)
		{
			$selectStr = $moduleArr['key'];
			if(isset($moduleArr['statusField']))
				$selectStr.= ','.$moduleArr['statusField'];
			if($type == 'list')
			{
				if(array_key_exists('actionColumn' , $moduleArr['list']))
					unset($moduleArr['list']['actionColumn']);
				$selectStr.= ','.implode(',' , array_keys($moduleArr['list']));
				if($module == 'manage_activity_photogallery')
					$selectStr.= ',added_type';
			}
			if($type == 'edit')
			{
				foreach($moduleArr['field'] as $key => $value)
				{
					if($value['type'] == 'subtable')
						unset($moduleArr['field'][$key]);
				}
				$selectStr.= ','.implode(',' , array_keys($moduleArr['field']));
				if($module == 'manage_activity_photogallery')
					$selectStr.= ',added_type';
			}
			return $selectStr;
		}

		//This function is used to create the form field for master modules(add/edit page)
		public function setFormField($fieldKey = NULL , $fieldValue = array() , $post = array() , $fileUploadError = array() , $subTableFlag = NULL)
		{
			$fieldStr = '';
			if(!empty($fieldValue))
			{
				if($fieldValue['type'] == 'text')
				{
					$data = array(
						'name' => ($subTableFlag == 1) ? $fieldKey.'[]' : $fieldKey,
						'id' => $fieldKey,
						'placeholder' => isset($fieldValue['placeholder']) ? $fieldValue['placeholder'] : '',
						'class' => 'form-control',
						'value' => isset($post[$fieldKey]) ? $post[$fieldKey] : ''
					);
					$fieldStr.= form_input($data).form_error($fieldKey);
				}
				elseif($fieldValue['type'] == 'textarea')
				{
					$data = array(
						'name' => $fieldKey,
						'id' => $fieldKey,
						'class' => (isset($fieldValue['summernote']) && $fieldValue['summernote'] == 1) ? 'form-control summernote' : 'form-control',
						'value' => isset($post[$fieldKey]) ? $post[$fieldKey] : '',
						'rows' => $fieldValue['rows']
					);
					$fieldStr.= form_textarea($data).form_error($fieldKey);
					if(isset($fieldValue['summernote']) && $fieldValue['summernote'] == 1)
						$fieldStr.= '<span id="'.$fieldKey.'_descriptionErrorMessage" style="color:#ff0000"></span>';
				}
				elseif($fieldValue['type'] == 'file' && $fieldValue['fileType'] == 'image')
				{
					$fieldStr.= '<input type="hidden" name="'.$fieldKey.'_changeFlag" id="'.$fieldKey.'_changeFlag" value="1" />';
					$fieldStr.= '<input type="hidden" id="'.$fieldKey.'_widthErrorFlag" value="1" />';
					$oldImageName = isset($post[$fieldKey]) ? $post[$fieldKey] : '';
					$fieldStr.= '<input type="hidden" name="'.$fieldKey.'_oldImg" id="'.$fieldKey.'_oldImg" value="'.$oldImageName.'" />';
					$fieldStr.= '<label for="'.$fieldKey.'">';
					$imagePath = isset($post[$fieldKey]) ? ADMIN_PANEL_URL.$fieldValue['uploadPath'].getThumbnailName($post[$fieldKey]) : base_url().'images/no_flag.jpg';
					$fieldStr.= '<img height="'.$fieldValue['thumbHeight'].'" width="'.$fieldValue['thumbWidth'].'" class="uploadImageProgramClass" id="'.$fieldKey.'_onChangeImage" src="'.$imagePath.'"/>';
					$fieldStr.= '</label>';
					$data = array(
						'name' => $fieldKey,
						'id' => $fieldKey,
						'type' => 'file',
						'style' => 'visibility: hidden;'
					);
					$fieldStr.= form_input($data);
					$fieldStr.= '<small style="display:block">';
					$fieldStr.= '( Note: Only JPG|JPEG images are allowed <br> &amp; Image dimension should be greater or equal to '.$fieldValue['width'].' X '.$fieldValue['height'].' pixel )';
					$errorMessage = (!empty($fileUploadError)) ? implode("<br>" , $fileUploadError) : '';
					$fieldStr.= '</small><span id="'.$fieldKey.'_customErrorMessage" style="color:#ff0000">'.$errorMessage.'</span>';
				}
				elseif($fieldValue['type'] == 'dropdown')
				{
					$dropdownValue = isset($post[$fieldKey]) ? $post[$fieldKey] : '';
					$fieldStr.= form_dropdown($fieldKey , $this->dropdown($fieldValue['module'] , 2) , $dropdownValue , 'class = "form-control" id="'.$fieldKey.'"');
					$fieldStr.= form_error($fieldKey);
				}
				elseif($fieldValue['type'] == 'date')
				{
					$data = array(
						'name' => $fieldKey,
						'id' => $fieldKey,
						'placeholder' => isset($fieldValue['placeholder']) ? $fieldValue['placeholder'] : '',
						'class' => 'form-control datepicker',
						'value' => isset($post[$fieldKey]) ? $post[$fieldKey] : ''
					);
					$fieldStr.= form_input($data).form_error($fieldKey);
				}
				elseif($fieldValue['type'] == 'time')
				{
					$fieldStr.= '<div class="input-append date timepicker">';
					$data = array(
						'name' => ($subTableFlag == 1) ? $fieldKey.'[]' : $fieldKey,
						'id' => $fieldKey,
						'placeholder' => isset($fieldValue['placeholder']) ? $fieldValue['placeholder'] : '',
						'data-format' => 'hh:mm:ss',
						'value' => isset($post[$fieldKey]) ? $post[$fieldKey] : ''
					);
					$fieldStr.= form_input($data).form_error($fieldKey);
					$fieldStr.= '<span class="add-on" style="height:30px;"><i class="fa fa-lg fa-clock"></i></span>';
					$fieldStr.= '</div>';
				}
			}
			return $fieldStr;
		}

		//This function is used to get the dynamic dropdown array or value name from another module
		private function dropdown($moduleName = NULL , $flag = 1 , $dropdownId = NULL)
		{
			$moduleArr = $this->getModule($moduleName);
			$this->db->select($moduleArr['dropdown']['key'].' as dropdown_key , '.$moduleArr['dropdown']['value'].' as dropdown_value');
			if($flag == 1)
			{
				$this->db->where($moduleArr['dropdown']['key'] , $dropdownId);
				$result = $this->db->get($moduleArr['dbName'])->row_array();
				return isset($result['dropdown_value']) ? $result['dropdown_value'] : '';
			}
			else
			{
				$returnArr = array(
					'' => $this->lang->line('please_select_dropdown')
				);
				$this->db->order_by($moduleArr['dropdown']['value'] , 'asc');
				if(isset($moduleArr['listWhere']))
					$this->db->where($moduleArr['listWhere']);
				$result = $this->db->get($moduleArr['dbName'])->result_array();
				if(!empty($result))
				{
					foreach($result as $value)
						$returnArr[$value['dropdown_key']] = $value['dropdown_value'];
				}
				return $returnArr;
			}
		}

		//This function is used to get the dynamic sub table designing for master modules
		public function createSubtable($moduleName = NULL , $post = array() , $globalCount = 1)
		{
			$fieldStr = '<div class="subTableWrapper col-lg-8" style="padding-left: 0;"><div class="border-box">';
			$moduleArr = $this->getModule($moduleName);
			if(!empty($moduleArr['field']))
			{
				foreach($moduleArr['field'] as $fieldKey => $fieldValue)
				{
					$fieldStr.= '<div class="form-group">
									<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12" style="margin-left:10px;">';
					$fieldStr.= $fieldValue['fieldLabel'];
					$fieldStr.= (strpos($fieldValue['validation'] , 'required') !== FALSE) ? '<span class="required">*</span>' : '';
					$fieldStr.= '</label>';
					$fieldStr.= '<div class="col-md-9 col-sm-9 col-xs-12">';
					$fieldStr.= $this->setFormField($fieldKey , $fieldValue , $post , '' , 1);
					$fieldStr.= '<span class="error showErrorMessage"></span></div>';
					$fieldStr.= '<div class="clearfix"></div>';
					$fieldStr.= '</div>';
				}
			}
			$fieldStr.= '</div>';
			$fieldStr.= '<div style="float: right;">
							<i class="fa fa-lg fa-plus-circle add_section addMoreTable" aria-hidden="true"></i>';
			if($globalCount > 1)
				$fieldStr.= '<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>';
			$fieldStr.= '</div><br><br></div>';
			return $fieldStr;
		}

		/**
		*This function is used to check if copy master activity icon should in the listing page ot not
		*
		*@param Array $data : Master activity details
		*@return Array
		*/
		private function showCopyActivityIcon($data = array())
		{
			$returnArr = array();
			unset($data['master_activity_id']);
			unset($data['student_group']);
			$masterGroup = $this->db->select('student_group')
							->where($data)
							->where("student_group != ''")
							->get(TABLE_MASTER_ACTIVITY)->result_array();
			$studentGroup = $this->db->select('student_group_id , group_name')
									->where('centre_id' , $data['centre_id'])
									->get(TABLE_STUDENT_GROUP)->result_array();
			if(count($studentGroup) > count($masterGroup))
				$returnArr['show'] = 1;
			else
				$returnArr['show'] = 2;
			return $returnArr;
		}
	}

