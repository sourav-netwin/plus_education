<?php
	class Video_gallery extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->helper('frontend');
			checkAdminLogin();
		}

		//This function is used to show the video gallery page
		function index()
		{
			$data['videoDetails'] = $this->Front_model->commonGetData('plus_walking_tour_id , video , description' , 'centre_id = '.$this->session->userdata('centre_id') , TABLE_PLUS_WALKING_TOUR , 'plus_walking_tour_id' , 'asc' , 2);
			$this->load->view('plus_video' , $data);
		}

		//This function is used to save the image in the local directory for video image
		function save_file()
		{
			if($this->input->post('fileName'))
			{
				if(!is_dir('./'.PLUS_WALKING_TOUR_FRONT_IMAGE))
					mkdir('./'.PLUS_WALKING_TOUR_FRONT_IMAGE , '0777');
				file_put_contents('./'.PLUS_WALKING_TOUR_FRONT_IMAGE.$this->input->post('fileName') , file_get_contents($this->input->post('binaryImg')));
				echo '';
			}
		}

		//This function is used to force download a file
		public function force_download($id = NULL)
		{
			$videoFile = $this->Front_model->commonGetData('video' , 'plus_walking_tour_id = '.$id , TABLE_PLUS_WALKING_TOUR , 'plus_walking_tour_id' , 'asc' , 1);
			$fileName = './'.PLUS_WALKING_TOUR_DOWNLOAD_FILE.$videoFile['video'];
			header("Content-Length: ".filesize($fileName));
			header('Content-Description: File Transfer');
			header("Content-Type: application/video/mp4;");
			//header('Content-Type: application/octet-stream');
			header("Content-Disposition: attachment; filename='".basename($fileName)."'");
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

	}
