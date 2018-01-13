<?php
	class Login extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			$this->load->helper(array('language' , 'form'));
			$this->lang->load('general_lang' , 'english');
			$this->lang->load('message_lang' , 'english');
			$this->load->model('Front_model' , '' , TRUE);
		}

		//Function is used to show login page
		public function index()
		{
			if($this->session->userdata('logged_in'))
				redirect(base_url().'plus-walking-tour');
			else
			{
				$this->load->helper('captcha');
				$vals = array(
					'word' => rand_string(5),
					'img_path' => './images/captcha/',
					'img_url' => base_url().'images/captcha/',
					'img_width' => 275,
					'img_height' => 45,
					'expiration' => 7200,
					'font_size' => 60,
					'colors' => array(
						'background' => array(255, 255, 255),
						'border' => array(255, 255, 255),
						'text' => array(0, 0, 0),
						'grid' => array(179, 217, 255)
					)
				);
				$data['captcha'] = create_captcha($vals);
				$this->session->set_userdata('admin_login_captcha_word', $data['captcha']['word']);
				$data['page_title'] = 'Login | '.$this->lang->line('plus_educational_developments');
				$this->load->view('login' , $data);
			}
		}

		/*Function is used to check whether login details is valid or not . If valid then redirect to
		the dashboard page , otherwise show login page with error messages*/
		function logged()
		{
			if($_POST)
			{
				$error = array();

				//Check values are empty
				if(!trim($this->input->post('centre')))
					$error[] = str_replace('**field**' , 'centre' , lang('please_enter_dynamic'));
				if(!trim($this->input->post('userPassword')))
					$error[] = str_replace('**field**' , 'password' , lang('please_enter_dynamic'));

				//Check for the token
				if(!$this->input->post('csrf_token'))
					$error[] = lang('csrf_error_message');
				else
				{
					if(!checkToken($this->input->post('csrf_token')))
						$error[] = lang('csrf_error_message');
				}

				//Check for the capcha
				if($this->input->post('capchaName') !== $this->session->userdata('admin_login_captcha_word'))
					$error[] = str_replace('**field**' , 'correct captcha' , lang('please_enter_dynamic'));

				//Check for the xss filtering
				$xssArray = array($this->input->post('userName') , $this->input->post('userPassword'));
				if (!xssExpressionMatch($xssArray))
					$error[] = 'Please enter valid data.';

				//Check user is valid or not from DB
				if(trim($this->input->post('centre')) && trim($this->input->post('userPassword')))
				{
					$userData = $this->Front_model->verify();
					if(empty($userData))
						$error[] = "Username or password does not matched.";
				}

				if(empty($error))
				{
					$centreArr = getCentreDropdownForPlusVideo();
					$newData = array(
						'logged_in' => TRUE,
						'centre' => $userData['nome_centri'],
						'centre_id' => $userData['id']
					);
					$this->session->set_userdata($newData);
					redirect(base_url().'plus-walking-tour');
				}
				else
				{
					$this->load->helper('captcha');
					$vals = array(
						'word' => rand_string(5),
						'img_path' => './images/captcha/',
						'img_url' => base_url().'images/captcha/',
						'img_width' => 275,
						'img_height' => 45,
						'expiration' => 7200,
						'font_size' => 60,
						'colors' => array(
							'background' => array(255, 255, 255),
							'border' => array(255, 255, 255),
							'text' => array(0, 0, 0),
							'grid' => array(179, 217, 255)
						)
					);
					$data['errors'] = $error;
					$data['captcha'] = create_captcha($vals);
					$this->session->set_userdata('admin_login_captcha_word', $data['captcha']['word']);
					$data['page_title'] = 'Login | '.$this->lang->line('plus_educational_developments');
					$this->load->view('login' , $data);
				}
			}
			else
				redirect(base_url().'login' , 'refresh');
		}

		//This function is used to logout from the admin panel
		function logout()
		{
			$this->session->sess_destroy();
			redirect(base_url().'login' , 'refresh');
		}

	}
?>