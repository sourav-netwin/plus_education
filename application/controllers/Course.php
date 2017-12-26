<?php
	class Course extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('general_lang' , 'english');
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->helper('frontend');
		}

		//This function is used to show home page
		public function index()
		{
			$languageId = 1;
			$data['bannerDetails'] = $this->Front_model->getBannerDetails($languageId);
			$data['courseDetails'] = $this->Front_model->getCourseDetails($languageId);
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
				$pageTitle = 'Adult Course';

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
						$str.= '<div class="col-sm-3 col-xs-3 welcome-w3imgs">
									<figure class="effect-chico">
										<img src="'.ADMIN_PANEL_URL.CENTRE_MASTER_IMAGE_PATH.$centreImage.'" />
										<span class="show-destination-class"><p>'.$value['centre_name'].'</p></span>
										<figcaption>
											<p class="figcaption-title-class-destination">'.$value['centre_name'].'</p>
											<p><a class="btn view-details-btn" href="'.base_url().$this->input->post('reference_function_name').'/'.str_replace(' ' , '-' , $value['centre_name']).'">'.$this->lang->line('read_more').'</a></p>
										</figcaption>
									</figure>
								</div>';
						if(($key+1) % 4 == 0)
							$str.= '<div class="clearfix" style="margin-bottom: 30px;"></div>';
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
	}
?>