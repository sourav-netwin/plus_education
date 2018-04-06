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
			$this->db->select($this->getSelectColumn($moduleArr , 'list'));
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
						$actionStr.= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().$url.'" data-toggle="tooltip" data-original-title="Edit '.$moduleArr['title'].'"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					}
					if(in_array('delete' , $moduleArr['list']['actionColumn']['actionType']))
						$actionStr.= '<a class="btn btn-xs btn-danger btn-wd-24" href="'.base_url().'index.php/frontweb/master/delete/'.$moduleName.'/'.$value[$moduleArr['key']].'" onclick="return confirm_delete(\''.$moduleArr['title'].'\')" data-toggle="tooltip" data-original-title="Delete '.$moduleArr['title'].'"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					if(in_array('status' , $moduleArr['list']['actionColumn']['actionType']))
					{
						$statusClass = ($value[$moduleArr['statusField']] == 1) ? 'fa-check-square-o' : 'fa-square-o';
						$actionStr.= '<a data-module="'.$moduleName.'" data-module_title="'.$moduleArr['title'].'" data-status="'.$value[$moduleArr['statusField']].'" data-id="'.$value[$moduleArr['key']].'" data-toggle="tooltip" data-original-title="Change Status for '.$moduleArr['title'].'" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon statusIcon"><span><i class="fa '.$statusClass.'" aria-hidden="true"></i></span></a>';
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
							$resultData[$key][$fieldValue['columnNo']] = "<img src = '".base_url().$fieldValue['uploadPath'].getThumbnailName($value[$fieldKey])."' width = 180 height = 50 />";
						elseif($fieldValue['type'] == 'date')
							$resultData[$key][$fieldValue['columnNo']] = date('d-m-Y' , strtotime($value[$fieldKey]));
						elseif($fieldValue['type'] == 'dropdown')
							$resultData[$key][$fieldValue['columnNo']] = $this->dropdown($fieldValue['module'] , 1 , $value[$fieldKey]);
					}
				}
			}

			$count_all = $this->db->select('count(*) as total')->get($moduleArr['dbName'])->row_array();
			return array(
				'count_all' => $count_all['total'],
				'data' => $resultData
			);
		}

		//This function is used to return the select columns for any module (listing/add_edit page)
		private function getSelectColumn($moduleArr = array() , $type = NULL)
		{
			$selectStr = $moduleArr['key'];
			if(isset($moduleArr['statusField']))
				$selectStr.= ','.$moduleArr['statusField'];
			if($type == 'list')
			{
				if(array_key_exists('actionColumn' , $moduleArr['list']))
					unset($moduleArr['list']['actionColumn']);
				$selectStr.= ','.implode(',' , array_keys($moduleArr['list']));
			}
			if($type == 'edit')
			{
				foreach($moduleArr['field'] as $key => $value)
				{
					if($value['type'] == 'subtable')
						unset($moduleArr['field'][$key]);
				}
				$selectStr.= ','.implode(',' , array_keys($moduleArr['field']));
			}
			return $selectStr;
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
				$result = $this->db->get($moduleArr['dbName'])->result_array();
				if(!empty($result))
				{
					foreach($result as $value)
						$returnArr[$value['dropdown_key']] = $value['dropdown_value'];
				}
				return $returnArr;
			}
		}
	}
