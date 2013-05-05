<?php

class Dashboard extends CI_Controller {
	function __construct() {
		parent::__construct();


	}

	public function index() {
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		
		$data['page']  = "dashboard";
		$data['title'] = "Dashboard";
		$this->load->view('index',$data);
	}

}