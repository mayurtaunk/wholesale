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

		$data['product_id']   = 0;
		$data['product_name'] = '';
		$data['from_date']	  = date('d-m-Y');
		$data['to_date']	  = date('d-m-Y');

		$data['page'] = "reports/sale_report";
		$data['page_title'] = "Sale Report";
		$this->load->view('index',$data);
	}
}