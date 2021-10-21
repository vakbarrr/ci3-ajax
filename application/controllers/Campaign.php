<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Campaign extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data = array();
		$this->frontend->default('campaign', $data);
	}
}
