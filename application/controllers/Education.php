<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Education extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data = array();
		$this->frontend->default('education', $data);
	}
}
