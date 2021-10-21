<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_page extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('Model_product', 'product');
	}
	public function index()
	{
		$data = array();

		$this->frontend->default('home_page', $data);
	}
	
}
