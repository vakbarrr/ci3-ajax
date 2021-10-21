<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feature extends CI_Controller {
  public function __construct()
  {
      parent::__construct();
  }
	public function index()
	{
        $data = array();
        $this->frontend->default('feature', $data);
	}
}