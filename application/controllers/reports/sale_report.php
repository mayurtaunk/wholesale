<?php 

class Sale_report extends CI_controller {
	function __construct() {
		parent::__construct();
	}

	function index() {
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}

		$data['page'] = "reports/sale_report";
		$data['title'] = "Sale Report";
		$this->load->view('index',$data);
	
	}
}