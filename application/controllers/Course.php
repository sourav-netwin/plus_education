<?php
	class Course extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('general_lang' , 'english');
			$this->lang->load('message_lang' , 'english');
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->model('Content_model' , '' , TRUE);
			$this->load->helper('frontend');
		}

		//This function is used to show home page
		public function index()
		{
			$languageId = 1;
			$data['bannerDetails'] = $this->Front_model->getBannerDetails($languageId);
			$data['courseDetails'] = $this->Front_model->getCourseDetails($languageId);
			$data['usaProgram'] = $this->Content_model->getUsaEuropeProgram('USA');
			$data['europeProgram'] = $this->Content_model->getUsaEuropeProgram('United Kingdom');
			$data['show_banner'] = 1;
			$data['page_title'] = 'Home';
			$this->template->view('dashboard' , $data);
		}

		//This function is used to show course details page
		public function course_details($id = NULL)
		{
			$languageId = 1;
			$tableName = $pageTitle = $referenceFunctionName = '';
			if($id == JUNIOR_SUMMER_ID)
			{
				$tableName = TABLE_JUNIOR_CENTRE;
				$pageTitle = 'Junior Summer Courses';
				$referenceFunctionName = 'junior-summer-courses';
			}
			elseif($id == JUNIOR_MINISTAY_ID)
			{
				$tableName = TABLE_JUNIOR_MINISTAY;
				$pageTitle = 'Junior Mini Stay Courses';
				$referenceFunctionName = 'junior-mini-stay';
			}
			elseif($id == ADULT_COURSE_ID)
			{
				$pageTitle = 'Adult Course';
				$data['brochureDetails'] = $this->Front_model->commonGetData('file_name, , file_description' , 'course_id = '.ADULT_COURSE_ID , TABLE_ADULT_COURSE_BROCHURE , '' , '' , 2);
				$data['formDetails'] = $this->Front_model->commonGetData('*' , '' , TABLE_MANAGE_APPLICATION_FORM , 'sequence' , 'asc' , 2);
			}

			$data['courseDetails'] = $this->Front_model->getDetailsCourses($languageId , $id);
			if($id == JUNIOR_SUMMER_ID || $id == JUNIOR_MINISTAY_ID)
				$data['destinationDetails'] = $this->Front_model->getDestinationDetails($tableName , 1);
			$data['show_banner'] = 0;
			$data['page_title'] = $pageTitle;
			$data['tableName'] = $tableName;
			$data['referenceFunctionName'] = $referenceFunctionName;
			$this->template->view('course_details' , $data);
		}

		//This function is used to get dynamic centre from DB according to region and load accordingly
		function get_centre()
		{
			if($this->input->post())
			{
				$str = '';
				$centreDetails = $this->Front_model->getDestinationDetails($this->input->post('table_name') , 2 , $this->input->post('region_id'));
				if(!empty($centreDetails['centre']))
				{
					$str = '<div class="welcome-agileinfo" style="margin-top: 2em;">
								<div class="col-md-12 agile-welcome-left">';
					foreach($centreDetails['centre'] as $key => $value)
					{
						$centreImage = ($value['centre_image'] != '') ? $value['centre_image'] : 'front_default.jpg';
						$str.= '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6  welcome-w3imgs" style="margin-top: 30px;">
									<figure class="effect-chico">
										<img src="'.ADMIN_PANEL_URL.CENTRE_MASTER_IMAGE_PATH.$centreImage.'" />
										<span class="show-destination-class"><span class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">'.$value['centre_name'].'</p></span></span>
										<figcaption>
											<div class="figcaptionWrapperClass"><p class="figcaption-title-class-courses">'.$value['centre_name'].'<br>
											<a class="btn view-details-btn" href="'.base_url().$this->input->post('reference_function_name').'/'.strtolower(str_replace(' ' , '-' , $value['centre_name'])).'">'.$this->lang->line('read_more').'</a></p></div>
										</figcaption>
									</figure>
								</div>';
					}
					$str.= '<div class="clearfix"></div></div><div class="clearfix"></div></div>';
				}
				echo $str;
			}
		}

		//This function is used to show junior summer course centre template
		public function junior_centre($centreName = NULL)
		{
			$data['centreDetails'] = $this->Front_model->getJuniorCentreDetails($centreName);
			$data['show_banner'] = 0;
			$data['page_title'] = 'Junior Centre';
			$data['photoGalleryPath'] = PHOTO_GALLERY_IMAGE_PATH;
			$data['videoGalleryImagePath'] = VIDEO_GALLERY_IMAGE_PATH;
			$this->template->view('junior_centre' , $data);
		}

		//This function is used to show the junior mini stay centre pages in details
		function junior_ministay($centreName = NULL)
		{
			$data['centreDetails'] = $this->Front_model->getJuniorMiniStayDetails($centreName);
			$data['show_banner'] = 0;
			$data['page_title'] = 'Junior Mini Stay';
			$data['photoGalleryPath'] = MINISTAY_PHOTO_GALLERY_IMAGE_PATH;
			$data['videoGalleryImagePath'] = MINISTAY_VIDEO_GALLERY_IMAGE_PATH;
			$this->template->view('junior_ministay' , $data);
		}

		//This function is used to show the all program details page
		function show_program_details()
		{
			$data['programDetails'] = $this->Front_model->getProgramDetails();
			$data['show_banner'] = 0;
			$data['page_title'] = 'Program Details';
			$this->template->view('program_details' , $data);
		}

		//This function is used to save the application form data in the database and send mail to admin
		function manage_application_form()
		{
			if($this->input->post('idArr'))
			{
				$applicationFormdata = array();
				$userData = $this->Front_model->commonGetData('count(distinct(user)) as total' , '' , TABLE_APPLICATION_FORM_DATA , '' , '' , 1);
				$idArr = $this->input->post('idArr');
				foreach($idArr as $value)
				{
					$insertData = array(
						'field_name' => $this->input->post('field_name_'.$value),
						'field_value' => $this->input->post('field_value_'.$value),
						'user' => ($userData['total'] + 1),
						'added_date' => date('Y-m-d H:i:s')
					);
					array_push($applicationFormdata , $insertData);
					$this->Front_model->commonAdd(TABLE_APPLICATION_FORM_DATA , $insertData);
				}
				$data['applicationFormdata'] = $applicationFormdata;
				//$this->load->view('email_template' , $data);
				echo '';
			}
		}

		function test()
		{
			// $this->load->library('email');
			// $this->email->from('genknooz9@gmail.com', 'plus-ed.com');
			// $this->email->to('myfkact786@gmail.com');
			// $this->email->subject('test');
			// $this->email->message('test');
			// $this->email->send();
		}
	}
?>