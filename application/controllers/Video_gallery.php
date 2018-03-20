<?php
	class Video_gallery extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->helper('frontend');
			$this->load->helper('download');
			$this->lang->load('message' , 'english');
			$this->load->model('Walking_tour_model' , '' , TRUE);
			checkAdminLogin();
		}

		//This function is used to show the video gallery page
		function index()
		{
			$data['videoDetails'] = $this->Front_model->commonGetData('plus_walking_tour_id , video , description' , 'centre_id = '.$this->session->userdata('centre_id') , TABLE_PLUS_WALKING_TOUR , 'plus_walking_tour_id' , 'asc' , 2);
			$data['activityDetails'] = $this->Front_model->commonGetData("plus_activity_id , name , description , front_image , date_format(added_date , '%d-%m-%Y') as added_date , show_type , show_text" , 'centre_id = '.$this->session->userdata('centre_id').' AND status=1 AND delete_flag=0' , TABLE_PLUS_ACTIVITY_MANAGEMENT , 'sequence' , 'asc' , 2);
			$data['centreDetails'] = $this->Front_model->commonGetData('icon_class , title , details' , 'centre_id = '.$this->session->userdata('centre_id') , TABLE_WALKING_TOUR_CENTRE_DETAILS , 'sequence' , 'asc' , 2);
			$data['viewPage'] = 'plus_video/video_activity';
			$data['showLeftMenu'] = 1;
			$this->load->view('plus_video/template' , $data);
		}

		//This function is used to save the image in the local directory for video image
		function save_file()
		{
			if($this->input->post('fileName'))
			{
				if(!is_dir('./'.PLUS_WALKING_TOUR_FRONT_IMAGE))
					mkdir('./'.PLUS_WALKING_TOUR_FRONT_IMAGE , DIR_PERMISSION , TRUE);
				file_put_contents('./'.PLUS_WALKING_TOUR_FRONT_IMAGE.$this->input->post('fileName') , file_get_contents($this->input->post('binaryImg')));
				echo '';
			}
		}

		//This function is used to force download a file
		public function force_download($id = NULL)
		{
			$id = base64_decode(str_replace('_' , '=' , preg_replace_callback('/-[a-z]-/' , function($match){return strtoupper(str_replace('-' , '' , $match[0]));} , $id)));
			$videoFile = $this->Front_model->commonGetData('video' , 'plus_walking_tour_id = '.$id , TABLE_PLUS_WALKING_TOUR , 'plus_walking_tour_id' , 'asc' , 1);
			$fileName = './'.PLUS_WALKING_TOUR_DOWNLOAD_FILE.$videoFile['video'];
			header("Content-Length: ".filesize($fileName));
			header('Content-Description: File Transfer');
			header("Content-Type: application/video/mp4;");
			header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			$this->readfile_chunked($fileName);
		}

		//This function is used to download the file by chunk the file byte
		protected function readfile_chunked($filename = NULL , $retbytes = TRUE)
		{
			$chunksize = 1*(1024*1024);
			$buffer = '';
			$cnt = 0;
			$handle = fopen($filename , 'rb');
			if($handle === false)
				return false;
			while(!feof($handle))
			{
				$buffer = fread($handle , $chunksize);
				echo $buffer;
				if($retbytes)
					$cnt += strlen($buffer);
			}
			$status = fclose($handle);
			if($retbytes && $status)
				return $cnt;
			return $status;
		}

		//This function is used to download activity files
		function download_activity_file($id = NULL)
		{
			if($id)
			{
				$id = base64_decode(str_replace('_' , '=' , preg_replace_callback('/-[a-z]-/' , function($match){return strtoupper(str_replace('-' , '' , $match[0]));} , $id)));
				$result = $this->Front_model->commonGetData('file_name' , 'plus_activity_file_id = '.$id , TABLE_PLUS_ACTIVITY_MANAGEMENT_FILES , '' , 'asc' , 1);
				if(file_exists('./'.ACTIVITY_ACCESS_FILE.$result['file_name']))
					force_download($result['file_name'] , file_get_contents('./'.ACTIVITY_ACCESS_FILE.$result['file_name']));
			}
		}

		//This function is used to get the centre detila for any centre and download the details in a text file .
		function download_centre_details()
		{
			if(!is_dir('./'.WALKING_TOUR_CENTRE_DETAILS_FILE))
				mkdir('./'.WALKING_TOUR_CENTRE_DETAILS_FILE , DIR_PERMISSION , TRUE);
			$result = $this->Front_model->commonGetData('icon_class , title , details' , 'centre_id = '.$this->session->userdata('centre_id') , TABLE_WALKING_TOUR_CENTRE_DETAILS , 'sequence' , 'asc' , 2);
			$fp = fopen('./'.WALKING_TOUR_CENTRE_DETAILS_FILE.str_replace(' ' , '_' , strtolower($this->session->userdata('centre'))).'.txt' , 'w');
			if(!empty($result))
			{
				foreach($result as $value)
				{
					$text = strip_tags($value['title']).' : '."\n";
					$text.= trim(strip_tags($value['details']))."\n\n\n";
					fwrite($fp , $text);
				}
			}
			fclose($fp);
			force_download(str_replace(' ' , '_' , strtolower($this->session->userdata('centre'))).'.txt' , file_get_contents('./'.WALKING_TOUR_CENTRE_DETAILS_FILE.str_replace(' ' , '_' , strtolower($this->session->userdata('centre'))).'.txt'));
		}

		//This function is used to get the details for day to day activity and show in the front end
		function get_day_activity()
		{
			$post = array();
			$groupDropdownArr = array('' => 'Please select group');
			if($this->input->post('flag') == 'search')
			{
				$post['centre_id'] = $this->input->post('centre_id');
				$post['group_id'] = $this->input->post('group_id');
				$post['from_date'] = $this->input->post('from_date');
				$post['to_date'] = $this->input->post('to_date');
				$post['htmlStr'] = $this->Walking_tour_model->getActivityDetails();
				$groupDropdownArr = $this->Walking_tour_model->getGroupDropdown(1);
				$this->session->set_userdata('activitySpecialGroup' , $post['group_id']);
			}
			$data['post'] = $post;
			$data['groupDropdown'] = $groupDropdownArr;
			$data['centreDetails'] = $this->Front_model->commonGetData('icon_class , title , details' , 'centre_id = '.$this->session->userdata('centre_id') , TABLE_WALKING_TOUR_CENTRE_DETAILS , 'sequence' , 'asc' , 2);
			$data['viewPage'] = 'plus_video/day_to_day_activity';
			$data['showLeftMenu'] = 1;
			$this->load->view('plus_video/template' , $data);
		}

		/**
		*This function is used to get the group dropdown details acording to the centre and the active/confirm status
		*
		*@param NONE
		*@return NONE
		*/
		public function get_group()
		{
			if($this->input->post('centre_id') != '')
			{
				echo $this->Walking_tour_model->getGroupDropdown();
			}
		}

		/**
		*This function is used to get the activity details and show it in pdf format
		*
		*@param NONE
		*@return NONE
		*/
		function open_pdf()
		{
			$showText = '';
			$htmlStr = '<style>
							.previewTable{
								padding: 20px;
							}
							.previewTable thead tr:first-child{
								background-color: #b9b9ec;
							}
							.previewTable thead tr:last-child{
								background-color: #b49c9c;
							}
							.previewTable tbody tr{
								background-color: #fff;
							}
							.showCentrePreview{
								font-size: 22px;
								font-weight: bold;
								padding-top: 22px;
								color: #000;
							}
							.previewTable td{
								padding : 5px;
							}
							.previewTable th, .previewTable td {
								color: #000 !important;
							}
						</style>';
			if($this->session->userdata('activitySpecialGroup') != '')
			{
				$result = $this->Front_model->commonGetData("concat(id_year , '_' , id_book) as name" , 'id_book = '.$this->session->userdata('activitySpecialGroup') , TABLE_PLUS_BOOK);
				$showText = '(For '.$result['name'].')';
			}
			$htmlStr.= '<table>
							<tr>
								<td><img src="'.base_url().'images/logo_plus.png" /></td>
								<td><p class="showCentrePreview">'.$this->session->userdata('centre').'&nbsp;&nbsp;'.$showText.'</p></td>
							</tr>
						</table>';
			$htmlStr.= $this->session->userdata('activityHtmlStr');

			//Use dompdf to download the details in pdf file
			require_once(DOM_PDF_CONFIG_FILE);
			spl_autoload_register('DOMPDF_autoload');
			$dompdf = new DOMPDF();
			$dompdf->load_html($htmlStr);
			$dompdf->render();
			$dompdf->stream(strtolower($this->session->userdata('centre')).".pdf", array("Attachment" => 0, 'compress' => 0));
		}
	}
