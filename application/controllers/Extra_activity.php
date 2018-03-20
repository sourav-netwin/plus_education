<?php
	class Extra_activity extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('general_lang' , 'english');
			$this->lang->load('message_lang' , 'english');
			$this->load->model('Front_model' , '' , TRUE);
			$this->load->model('Extra_activity_model' , '' , TRUE);
			$this->load->model('Content_model' , '' , TRUE);
			$this->load->helper('frontend');
		}

		//This function is used to show the extra activity management page
		function index()
		{
			$post = array();
			if($this->input->post('centre_id'))
			{
				$post['centre_id'] = $this->input->post('centre_id');
				$post['date'] = $this->input->post('date');
				$post['masterActivity'] = $this->Extra_activity_model->getMasterActivity();
				$centreResult = $this->Front_model->commonGetData('nome_centri' , "id = '".$this->input->post('centre_id')."'" , TABLE_CENTRE , 1);
				$post['centreDetails'] = $centreResult['nome_centri'];
				$post['groupReference'] = $this->Extra_activity_model->getGroupReference();
			}
			$data['post'] = $post;
			$data['viewPage'] = 'plus_video/extra_activity';
			$data['showLeftMenu'] = 2;
			$this->load->view('plus_video/template' , $data);
		}

		//This function is used to update the data in the database for extra activity
		function update()
		{
			$this->Extra_activity_model->updateActivity();
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'Extra activity' , $this->lang->line('edit_success_message')));
			redirect('/extra_activity');
		}

		/**
		*This function is used to get the extra activity details according to the centre , date and
		*group reference number through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function get_activity_details()
		{
			if($this->input->post('centre_id'))
			{
				$data['htmlStr'] = $this->Extra_activity_model->createActivityDetails();
				echo json_encode($data);
			}
		}

		/**
		*This function is used to get the master activity details according to the details id
		*through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function get_master_activity()
		{
			if($this->input->post('id'))
			{
				$result = $this->Front_model->commonGetData('*' , 'fixed_day_activity_details_id = '.$this->input->post('id') , TABLE_FIXED_DAY_ACTIVITY_DETAILS , 1);
				$data['htmlStr'] = $this->Extra_activity_model->createHtml($result , 2);
				echo json_encode($data);
			}
		}
	}
