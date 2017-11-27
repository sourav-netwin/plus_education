<?php
	class Course extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->lang->load('message_lang' , 'english');
			$this->load->helper('backend');
			$this->load->model('Admin_model' , '' , TRUE);
			$this->load->library('image_upload');
			checkAdminLogin();
		}

		//This function is used to show listing page for the course
		public function index()
		{
			$this->template->admin_view('admin/course_list');
		}

		//This function is used to get all course details from DB and display in datatable
		public function get_course()
		{
			if($this->input->post())
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->Admin_model->getCourseDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_filtered'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}

		//Function is used to update program status through ajax call
		public function update_status()
		{
			if($this->input->post())
			{
				$data = array(
					'course_status' => ($this->input->post('course_status') == 1) ? 0 : 1
				);
				$this->Admin_model->updateCourse($this->input->post('course_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to add courses in DB
		public function add()
		{
			$imageError = '';
			if($this->input->post())
			{
				if($_FILES['course_image']['name'] != '')
				{
					$uploadData = $this->image_upload->do_upload('./uploads/course/' , 'course_image' , 500 , 1920 , 550);
					if($uploadData['errorFlag'] == 0)
					{
						$this->Admin_model->addCourse($this->input->post() , $uploadData['fileName']);
						redirect(base_url().'admin/course/index?success=add');
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
			}
			$data['imageError'] = $imageError;
			$this->template->admin_view('admin/course_add' , $data);
		}

		//This function is used to show edit page and edit record from DB
		function edit($id = NULL)
		{
			$imageError = '';
			if($this->input->post())
			{
				$file_name = $this->input->post('oldImg');
				if($this->input->post('imageChangeFlag') == 2)
				{
					$uploadData = $this->image_upload->do_upload('./uploads/program/' , 'program_image' , 500 , 1920 , 550);

					if($uploadData['errorFlag'] == 0)
					{
						//Delete old file
						if(file_exists('./uploads/program/'.$file_name))
							unlink('./uploads/program/'.$file_name);
						$file_name = $uploadData['fileName'];
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
				if($imageError == '')
				{
					$this->Admin_model->updateCourseData($id , $this->input->post() , $file_name);
					redirect(base_url().'admin/course/index?success=edit');
				}
			}

			$post = $this->Admin_model->getEditCourseData($id , 1);
			$data['post'] = $post;
			$data['imageError'] = $imageError;
			$this->template->admin_view('admin/course_edit' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$this->Admin_model->deleteCourse($id);
			redirect(base_url().'admin/course/index?success=delete');
		}

		//Function is used to get all the features related to the selected course
		function get_course_feature()
		{
			$str = '';
			$feature_arr = $this->Admin_model->getCourseFeature($this->input->post('course_id'));

			if(!empty($feature_arr))
			{
				foreach($feature_arr as $key => $value)
				{
					$str.= '<div id="add_more_wrapper_'.($key+1).'" class="add_more_wrapper border-box">
								<div class="form-group">
									<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Title<span class="required">*</span></label>
									<div class="col-md-9 col-sm-9 col-xs-12">';
					$inputFieldAttribute = array(
						'name' => 'feature_title['.($key+1).']',
						'id' => 'feature_title['.($key+1).']',
						'class' => 'form-control',
						'placeholder' => 'Title',
						'value' => $value['feature_title']
					);
					$str.= form_input($inputFieldAttribute);
					$str.= '</div>
							<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">';
					$inputFieldAttribute = array(
						'name' => 'feature_description['.($key+1).']',
						'id' => 'feature_description['.($key+1).']',
						'class' => 'form-control summernote',
						'placeholder' => 'Title',
						'value' => $value['feature_description']
					);
					$str.= form_textarea($inputFieldAttribute);
					$str.= '</div></div>
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="hidden" name="imageChangeFlag['.($key+1).']" id="imageChangeFlag['.($key+1).']" value="1" />
									<input type="hidden" id="imgWidthErrorFlag['.($key+1).']" value="1" />
									<input type="hidden" name="oldImg['.($key+1).']" id="oldImg['.($key+1).']" value="'.$value['feature_image'].'" />
									<label for="feature_image_'.($key+1).'">';
					$imgPath = ($value['feature_image'] != '') ? base_url().'uploads/course_feature/'.$value['feature_image'] : base_url().'images/no_flag.jpg';
					$str.= '<img height="50" width="180" class="uploadImageProgramClass" src="'.$imgPath.'"/></label>';
					$inputFieldAttribute = array(
						'id' => 'feature_image_'.($key+1),
						'name' => 'feature_image['.($key+1).']',
						'type' => 'file',
						'style' => 'visibility: hidden;',
						'class' => 'feature_image_class'
					);
					$str.= form_input($inputFieldAttribute);
					$str.= '<small style="display:block">
								( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; image size should be less than 800 X 500 pixel )
							</small>
							<span id="imgErrorMessage['.($key+1).']" style="color:#ff0000"></span>
							</div></div></div>';
					if(count($feature_arr) == ($key + 1))
						$str.= '<div style="float: right;"><i class="fa fa-lg fa-plus-circle add_more_icon" aria-hidden="true" data-block_no='.($key+1).'></i></div><div class="clearfix"></div>';
					else
						$str.= '<div style="float: right;"><i class="fa fa-lg fa-minus-circle remove_more_icon" aria-hidden="true" data-block_no='.($key+1).'></i></div><div class="clearfix"></div>';
				}
			}
			else
			{
				$str.= '<div id="add_more_wrapper_1" class="add_more_wrapper border-box">
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Title<span class="required">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">';
				$inputFieldAttribute = array(
					'name' => 'feature_title[1]',
					'id' => 'feature_title[1]',
					'class' => 'form-control',
					'placeholder' => 'Title'
				);
				$str.= form_input($inputFieldAttribute);
				$str.= '</div>
						<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">';
				$inputFieldAttribute = array(
					'name' => 'feature_description[1]',
					'id' => 'feature_description[1]',
					'class' => 'form-control summernote',
					'placeholder' => 'Title'
				);
				$str.= form_textarea($inputFieldAttribute);
				$str.= '</div></div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag[1]" id="imageChangeFlag[1]" value="1" />
								<input type="hidden" id="imgWidthErrorFlag[1]" value="1" />
								<label for="feature_image_1">';
				$imgPath = base_url().'images/no_flag.jpg';
				$str.= '<img height="50" width="180" class="uploadImageProgramClass" src="'.$imgPath.'"/></label>';
				$inputFieldAttribute = array(
					'id' => 'feature_image_1',
					'name' => 'feature_image[1]',
					'type' => 'file',
					'style' => 'visibility: hidden;',
					'class' => 'feature_image_class'
				);
				$str.= form_input($inputFieldAttribute);
				$str.= '<small style="display:block">
							( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; image size should be less than 800 X 500 pixel )
						</small>
						<span id="imgErrorMessage[1]" style="color:#ff0000"></span>
						</div></div></div>';
				$str.= '<div style="float: right;"><i class="fa fa-lg fa-plus-circle add_more_icon" aria-hidden="true" data-block_no=1></i></div><div class="clearfix"></div>';
			}

			$data['total_record'] = (count($feature_arr) == 0) ? 1 : count($feature_arr);
			$data['str'] = $str;
			echo json_encode($data);
		}
	}
?>