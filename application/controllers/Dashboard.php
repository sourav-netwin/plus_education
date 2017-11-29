<?php
	class Dashboard extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('general_lang' , 'english');
			$this->load->model('Front_model' , '' , TRUE);
		}

		//This function is used to show home page
		public function index()
		{
			$data['bannerDetails'] = $this->Front_model->getProgramDetails(1);
			$data['show_banner'] = 1;
			$this->template->view('dashboard' , $data);
		}

		//This function is used to show JUNIOR SUMMER COURSES page
		public function junior_summer_courses()
		{
			$languageId = 1;
			$data['courseDetails'] = $this->Front_model->getJuniorSummerCourseDetails($languageId);
			$data['destinationDetails'] = $this->Front_model->getDestinationDetails(1);
			$data['show_banner'] = 0;
			$this->template->view('junior_summer_courses' , $data);
		}

		//This function is used to get dynamic centre from DB according to region and load accordingly
		function get_centre()
		{
			if($this->input->post())
			{
				$centreDetails = $this->Front_model->getDestinationDetails(2 , $this->input->post('region_id'));
				if(!empty($centreDetails['centre']))
				{
					$str = '<div class="welcome-agileinfo" style="margin-top: 2em;">
								<div class="col-md-12 agile-welcome-left">';
					foreach($centreDetails['centre'] as $key => $value)
					{
						$str.= '<div class="col-sm-3 col-xs-3 welcome-w3imgs">
									<figure class="effect-chico">
										<img src="'.base_url().'uploads/centre/'.$value['centre_image'].'" />
										<figcaption>
											<p class="figcaption-title-class-destination">'.$value['centre_name'].'</p>
											<p><a class="btn view-details-btn" href="'.base_url().'dashboard/junior_centre">'.$this->lang->line('read_more').'</a></p>
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
		public function junior_centre()
		{
			$data['show_banner'] = 0;
			$this->template->view('junior_centre' , $data);
		}
	}
?>