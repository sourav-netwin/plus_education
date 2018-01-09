<?php
	class Video_gallery extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper('frontend');
			checkAdminLogin();
		}

		//This function is used to show the video gallery page
		function index()
		{
			$this->load->view('plus_video');
		}

		function getVideoDetails()
		{
			$ch = curl_init("http://vimeo.com/api/v2/video/203452787/json");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$res = curl_exec($ch);
			$obj = json_decode($res, true);
			echo "<pre>";print_r($obj);die('pop');
		}

		function vimeoApi()
		{
			require_once( APPPATH.'third_party\vimeo.php-1.3.0'.DIRECTORY_SEPARATOR.'autoload.php');
			$client_id = '0f4f509b6fae54c629a042fea38528dd44fe9c8e'; //'Client identifier' in my app
			$client_secret = 'RjW6My4B0KBe9vZFuA0aTGhCcyO7Hf6oqQ8ekwKXg3tpk/AwjotXj1D1IJyuVde0od1TpMYhs46E+2r+jHQ17g/fyVBevIIgeQjG45IffkOM8oJmafQCcv1Kqo4Jy1yC'; // 'Client secrets' in my app
			$lib = new \Vimeo\Vimeo($client_id, $client_secret);

			// Set the access token (from my Vimeo API app)
			$lib->setToken('f76202db96349d44d30a111021a597b9');
			$response = $lib->request('/videos/250069370', array(), 'GET');
			echo "<pre>";print_r($response);die('popop');
		}
	}
