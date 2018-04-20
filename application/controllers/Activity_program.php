<?php
	class Activity_program extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->model('Activity_program_model' , '' , TRUE);
			$this->load->helper('frontend');
			$this->load->helper('download');
			$this->lang->load('message' , 'english');
			checkAdminLogin();
		}

		//This function is used to get the details for day to day activity and show in the front end
		function get_day_activity()
		{
			$post = array();
			$groupDropdownArr = array('' => 'Please select group');
			$selectDropdownArr = array('' => 'Please select');
			if($this->input->post('flag') == 'search')
			{
				$post['centre_id'] = $this->input->post('centre_id');
				$post['student_group'] = $this->input->post('student_group');
				$post['reportType'] = $this->input->post('reportType');
				$post['selectType'] = $this->input->post('selectType');

				$this->session->set_userdata($post);

				//Prepare dropdown array
				$result = $this->get_dropdown(2 , 1);
				if(!empty($result))
				{
					foreach($result as $value)
						$groupDropdownArr[$value['id']] = $value['name'];
				}
				if($this->input->post('reportType') == 1)
					$result = $this->get_dropdown(3 , 1);
				elseif($this->input->post('reportType') == 2)
					$result = $this->get_dropdown(1 , 1);
				if(!empty($result))
				{
					foreach($result as $value)
						$selectDropdownArr[$value['id']] = $value['name'];
				}

				//Prepare activity program report
				if($this->input->post('reportType') == 1)
				{
					$masterDetails = $this->Front_model->commonGetData("date_format(arrival_date , '%d-%m-%Y') as arrival_date , date_format(departure_date , '%d-%m-%Y') as departure_date" , 'master_activity_id = '.$this->input->post('selectType') , TABLE_MASTER_ACTIVITY , 1);
					$post['arrival_date'] = $masterDetails['arrival_date'];
					$post['departure_date'] = $masterDetails['departure_date'];
					$result = $this->Front_model->commonGetData("fixed_day_activity_id as id , date_format(date , '%d-%m-%Y') as date" , 'master_activity_id = '.$this->input->post('selectType') , TABLE_FIXED_DAY_ACTIVITY , 'cast(date as DATE)' , 'asc' , 2);
					if(!empty($result))
					{
						foreach($result as $value)
							$post['datesArr'][$value['id']] = $value['date'];
						$post['details'] = $this->Activity_program_model->getMasterActivityDetails(array_keys($post['datesArr']));
					}
				}
				elseif($this->input->post('reportType') == 2)
				{
					$result = $this->Front_model->commonGetData("date_format(arrival_date , '%d-%m-%Y') as arrival_date , date_format(departure_date , '%d-%m-%Y') as departure_date" , 'id_book = '.$this->input->post('selectType') , TABLE_PLUS_BOOK , 1);
					$post['arrival_date'] = $result['arrival_date'];
					$post['departure_date'] = $result['departure_date'];
					$masterDetails = $this->Front_model->commonGetData('extra_master_activity_id' , "centre_id = '".$this->input->post('centre_id')."' AND student_group = '".$this->input->post('student_group')."' AND group_reference_id = '".$this->input->post('selectType')."'" , TABLE_EXTRA_MASTER_ACTIVITY , 1);
					if(isset($masterDetails['extra_master_activity_id']) && $masterDetails['extra_master_activity_id'] != '')
					{
						$result = $this->Front_model->commonGetData("extra_day_activity_id as id , date_format(date , '%d-%m-%Y') as date" , 'extra_master_activity_id = '.$masterDetails['extra_master_activity_id'] , TABLE_EXTRA_DAY_ACTIVITY , 'cast(date as DATE)' , 'asc' , 2);
						if(!empty($result))
						{
							foreach($result as $value)
								$post['datesArr'][$value['id']] = $value['date'];
							$post['details'] = $this->Activity_program_model->getExtraActivityDetails(array_keys($post['datesArr']));
						}
					}
					else
					{
						$referenceArr = $this->Activity_program_model->getMasterActivityForGroup($post['arrival_date'] , $post['departure_date']);
						if(!empty($referenceArr))
						{
							$post['datesArr'] = $referenceArr['datesArr'];
							$post['details'] = $referenceArr['details'];
						}
						else
							$data['errorMessage'] = 'No activity found';
					}
				}
			}
			$data['post'] = $post;
			$data['selectDropdownArr'] = $selectDropdownArr;
			$data['groupDropdown'] = $groupDropdownArr;
			$data['centreDetails'] = $this->Front_model->commonGetData('icon_class , title , details' , 'centre_id = '.$this->session->userdata('centre_id') , TABLE_WALKING_TOUR_CENTRE_DETAILS , 'sequence' , 'asc' , 2);
			$data['viewPage'] = 'plus_video/day_to_day_activity';
			$data['showLeftMenu'] = 2;
			$this->load->view('plus_video/template' , $data);
		}

		/**
		*This function is used to get the student's group and the group reference dropdown values
		*through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function get_dropdown($dropdownType = NULL , $returnType = NULL)
		{
			$data = array();
			if($this->input->post('centre_id'))
			{
				if($dropdownType == 1)
					$data = $this->Front_model->commonGetData("id_book as id , concat(id_year , '_' , id_book) as name" , "(status = 'confirmed' OR status = 'active') AND id_centro = ".$this->input->post('centre_id') , TABLE_PLUS_BOOK , 'id_book' , 'asc' , 2);
				elseif($dropdownType == 2)
					$data = $this->Front_model->commonGetData("group_name as name , student_group_id as id" , 'centre_id = '.$this->input->post('centre_id').' AND delete_flag=0' , TABLE_STUDENT_GROUP , 'group_name' , 'asc' , 2);
				elseif($dropdownType == 3)
					$data = $this->Front_model->commonGetData("activity_name as name , master_activity_id as id" , 'centre_id = '.$this->input->post('centre_id').' AND student_group = '.$this->input->post('student_group') , TABLE_MASTER_ACTIVITY , 'activity_name' , 'asc' , 2);
			}
			if($returnType == 1)
				return $data;
			else
				echo json_encode($data);
		}

		/**
		*This function is used to export the activity program in excel format
		*
		*@param NONE
		*@return NONE
		*/
		public function export_to_excel()
		{
			$activityDetails = $this->prepare_export_data();

			//Load Library for php excel loader
			$this->load->library('excel_180');

			//Create object for php excel active sheet
			$newsheet = $this->excel_180->createSheet(0);
			$newsheet->setTitle("Activity Program");

			//Prepare header section
			$newsheet->setCellValue("D1" , $this->session->userdata('centre'));
			$newsheet->mergeCells('D1:E1');
			$newsheet->getStyle('D1:E1')->getFont()->setSize(20)->getColor()->setRGB('273878');

			//Place company logo in the header
			/*$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Plus_logo');
			$objDrawing->setDescription('Plus_logo');
			$objDrawing->setPath('./images/logo_plus.png');
			$objDrawing->setCoordinates('B1');
			//setOffsetX works properly
			$objDrawing->setOffsetX(3);
			$objDrawing->setOffsetY(5);
			//set width, height
			$objDrawing->setResizeProportional(false);
			$objDrawing->setWidth(186);
			$objDrawing->setHeight(53);
			$objDrawing->setWorksheet($newsheet);
			$newsheet->mergeCells('B1:C1');
			$newsheet->getRowDimension(1)->setRowHeight(45);*/

			//Day column
			$newsheet->setCellValue("B4" , 'Day');
			$newsheet->mergeCells('B4:C4');
			$this->columnStyling($newsheet , 'B4:C4');
			$this->addCellColor($newsheet , 'B4:C4' , 'ACB7E1');
			$newsheet->getColumnDimension('B')->setWidth(20);
			$newsheet->getColumnDimension('C')->setWidth(20);

			//Dynamic dates column
			if(!empty($activityDetails['datesArr']))
			{
				$columnAsciiCode = 68;
				foreach($activityDetails['datesArr'] as $dateValue)
				{
					$newsheet->setCellValue($this->getCellName($columnAsciiCode).'4' , date('d-M-Y' , strtotime($dateValue)));
					$newsheet->getColumnDimension($this->getCellName($columnAsciiCode))->setWidth(30);
					$this->columnStyling($newsheet , $this->getCellName($columnAsciiCode).'4');
					$this->addCellColor($newsheet , $this->getCellName($columnAsciiCode).'4' , 'ACB7E1');
					$columnAsciiCode++;
				}
			}

			//Add from and To time column
			$newsheet->setCellValue('B5' , 'From');
			$this->columnStyling($newsheet , 'B5');
			$this->addCellColor($newsheet , 'B5' , '95A5A6');
			$newsheet->setCellValue('C5' , 'To');
			$this->columnStyling($newsheet , 'C5');
			$this->addCellColor($newsheet , 'C5' , '95A5A6');

			//Dynamic week names column
			if(!empty($activityDetails['datesArr']))
			{
				$columnAsciiCode = 68;
				foreach($activityDetails['datesArr'] as $dateValue)
				{
					$newsheet->setCellValue($this->getCellName($columnAsciiCode).'5' , date('l' , strtotime($dateValue)));
					$this->columnStyling($newsheet , $this->getCellName($columnAsciiCode).'5');
					$this->addCellColor($newsheet , $this->getCellName($columnAsciiCode).'5' , '95A5A6');
					$columnAsciiCode++;
				}
			}

			//Add dynamic time slot wise activity details
			if(!empty($activityDetails['details']))
			{
				$tempRowNo = 6;
				foreach($activityDetails['details'] as $timeSlot => $detailsValue)
				{
					//Add from and to time value in the column
					$tempArr = explode('-' , $timeSlot);
					$newsheet->setCellValue('B'.$tempRowNo , $tempArr[0]);
					$this->columnStyling($newsheet , 'B'.$tempRowNo);
					$newsheet->setCellValue('C'.$tempRowNo , $tempArr[1]);
					$this->columnStyling($newsheet , 'C'.$tempRowNo);
					$columnAsciiCode = 68;
					foreach($activityDetails['datesArr'] as $dateKey => $dateValue)
					{
						$activityNames = (isset($detailsValue[$dateKey]) && !(empty($detailsValue[$dateKey]))) ? implode(' / ' , $detailsValue[$dateKey]) : '';
						$newsheet->setCellValue($this->getCellName($columnAsciiCode).$tempRowNo , $activityNames);
						$this->columnStyling($newsheet , $this->getCellName($columnAsciiCode).$tempRowNo);
						$columnAsciiCode++;
					}
					$newsheet->getRowDimension($tempRowNo)->setRowHeight(45);
					$tempRowNo++;
				}
			}

			//Set header to download the excel file
			/*header('Content-type : application/vnd.ms-excel');
			header('Content-Disposition : attachment ; filename='.str_replace(' ' , '_' , strtolower($this->session->userdata('centre'))).'.xlsx');
			header('Pragma : no-cache');
			header('Expires : 0');

			//Write into excel and download
			$writerObj = PHPExcel_IOFactory::CreateWriter($this->excel_180 , 'Excel2007');
			$writerObj->save('php://output');
			exit;*/

			$writeObj = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
			header('Content-Type: application/application/vnd.ms-excel');
			header('Content-Disposition : attachment ; filename='.str_replace(' ' , '_' , strtolower($this->session->userdata('centre'))).'.xlsx');
			header('Cache-Control: max-age=0');
			$writeObj->save('php://output');
			exit;
		}

		/**
		*This function is used to add background color to the particular column
		*
		*@param Object $newsheet
		*@param String $cells
		*@param String $color
		*@return NONE
		*/
		private function addCellColor($newsheet = NULL , $cells = NULL , $color = NULL)
		{
			$newsheet->getStyle($cells)->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					'rgb' => $color
				)
			));
		}

		/**
		*This function is used to add proper style in the heading columns
		*
		*@param Object $newsheet
		*@param String $cells
		*@return NONE
		*/
		private function columnStyling($newsheet = NULL , $cells = NULL)
		{
			//Set font size
			$newsheet->getStyle($cells)->getFont()->setSize(13);

			//Make text centre
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);
			$newsheet->getStyle($cells)->applyFromArray($style);

			//Add border to the column
			$border_style= array(
				'borders' => array(
					'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
					'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			);
			$newsheet->getStyle($cells)->applyFromArray($border_style);
		}

		/**
		*This function is used to return the excel column name by using ASCII code
		*
		*@param Integer $asciiCode
		*@return String
		*/
		private function getCellName($asciiCode = NULL)
		{
			if($asciiCode > 90)
			{
				$tempFlag = 0;
				$tempCount = $asciiCode;
				while(1)
				{
					if($tempCount > 90)
					{
						$tempFlag++;
						$tempCount = $tempCount-26;
					}
					else
						break;
				}
				return chr(64+$tempFlag).chr($tempCount);
			}
			else
				return chr($asciiCode);
		}

		/**
		*This function is used to prepare the export data to downlioad in excel or pdf format
		*
		*@param NONE
		*@return Array
		*/
		private function prepare_export_data()
		{
			$returnArr = array();
			if($this->session->userdata('reportType') == 1)
			{
				$result = $this->Front_model->commonGetData("fixed_day_activity_id as id , date_format(date , '%d-%m-%Y') as date" , 'master_activity_id = '.$this->session->userdata('selectType') , TABLE_FIXED_DAY_ACTIVITY , 'cast(date as DATE)' , 'asc' , 2);
				if(!empty($result))
				{
					foreach($result as $value)
						$returnArr['datesArr'][$value['id']] = $value['date'];
					$returnArr['details'] = $this->Activity_program_model->getMasterActivityDetails(array_keys($returnArr['datesArr']));
				}
			}
			elseif($this->session->userdata('reportType') == 2)
			{
				$masterDetails = $this->Front_model->commonGetData('extra_master_activity_id' , 'centre_id = '.$this->session->userdata('centre_id').' AND student_group = '.$this->session->userdata('student_group').' AND group_reference_id = '.$this->session->userdata('selectType') , TABLE_EXTRA_MASTER_ACTIVITY , 1);
				if(isset($masterDetails['extra_master_activity_id']) && $masterDetails['extra_master_activity_id'] != '')
				{
					$result = $this->Front_model->commonGetData("extra_day_activity_id as id , date_format(date , '%d-%m-%Y') as date" , 'extra_master_activity_id = '.$masterDetails['extra_master_activity_id'] , TABLE_EXTRA_DAY_ACTIVITY , 'cast(date as DATE)' , 'asc' , 2);
					if(!empty($result))
					{
						foreach($result as $value)
							$returnArr['datesArr'][$value['id']] = $value['date'];
						$returnArr['details'] = $this->Activity_program_model->getExtraActivityDetails(array_keys($returnArr['datesArr']));
					}
				}
				else
				{
					$result = $this->Front_model->commonGetData("date_format(arrival_date , '%d-%m-%Y') as arrival_date , date_format(departure_date , '%d-%m-%Y') as departure_date" , 'id_book = '.$this->session->userdata('selectType') , TABLE_PLUS_BOOK , 1);
					$returnArr = $this->Activity_program_model->getMasterActivityGroupExportData($result['arrival_date'] , $result['departure_date']);
				}
			}
			return $returnArr;
		}

		/**
		*This function is used to export the activity program in pdf format
		*
		*@param NONE
		*@return NONE
		*/
		public function export_to_pdf()
		{
			$data['activityDetails'] = $this->prepare_export_data();
			$data['headerInfo'] = $this->Activity_program_model->getPdfHeader();
			$viewPageContent = $this->load->view('plus_video/activity_pdf' , $data , TRUE);

			//Use dompdf to download the details in pdf file
			require_once(DOM_PDF_CONFIG_FILE);
			spl_autoload_register('DOMPDF_autoload');
			$dompdf = new DOMPDF();
			$dompdf->load_html($viewPageContent);
			$dompdf->render();
			$dompdf->stream(strtolower($this->session->userdata('centre')).".pdf", array("Attachment" => 0, 'compress' => 0));
		}
	}
