<?php 

class Sale_report extends CI_controller {
	function __construct() {
		parent::__construct();
	}

	function index() {
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1) {
			redirect('main/login');
		}

		if($this->input->post('submit')) {

			$data['product_id']   = $this->input->post('product_id');
			$data['product_name'] = $this->input->post('product_name');
			$data['from_date'] 	  = $this->input->post('from_date');
			$data['to_date']	  = $this->input->post('to_date');
			$sql="";
			if($data['product_id'] != 0)
			{
				if($this->session->userdata('key') == "1")
				{
					$sql = "SELECT DATE_FORMAT(S.datetime,'%d-%m-%Y') AS date, P.name AS product , SUM(SD.quantity) as quantity 
						FROM sales S INNER JOIN sale_details SD ON S.id = SD.sale_id 
						INNER JOIN purchase_details PD ON PD.id = SD.purchase_detail_id
						INNER JOIN products P ON P.id = PD.product_id 
						WHERE PD.product_id = ".$data['product_id']." AND
						DATE_FORMAT(S.datetime, '%d-%m-%Y') >= '".$data['from_date']."' AND
						DATE_FORMAT(S.datetime, '%d-%m-%Y') <= '".$data['to_date']."' AND
						P.company_id=". $this->session->userdata('company_id');
			
				}
				else
				{
					$sql = "SELECT DATE_FORMAT(S.datetime,'%d-%m-%Y') AS date, P.name AS product , SUM(SD.quantity) as quantity 
						FROM sales S INNER JOIN sale_details SD ON S.id = SD.sale_id 
						INNER JOIN purchase_details PD ON PD.id = SD.purchase_detail_id
						INNER JOIN purchases PU ON PD.purchase_id = PU.id 
						INNER JOIN products P ON P.id = PD.product_id 
						WHERE PD.product_id = ".$data['product_id']." AND
						DATE_FORMAT(S.datetime, '%d-%m-%Y') >= '".$data['from_date']."' AND
						DATE_FORMAT(S.datetime, '%d-%m-%Y') <= '".$data['to_date']."' AND
						PU.recieved = 1 AND
						P.company_id=". $this->session->userdata('company_id');
					
				}
				
			}
			else
			{
				if($this->session->userdata('key') == "1")
				{

					$sql = "SELECT DATE_FORMAT(S.datetime,'%d-%m-%Y') AS date, P.name AS product, SUM(SD.quantity) as quantity
						FROM sales S INNER JOIN sale_details SD ON S.id = SD.sale_id 
						INNER JOIN purchase_details PD ON PD.id = SD.purchase_detail_id
						INNER JOIN products P ON P.id = PD.product_id 
						WHERE DATE_FORMAT(S.datetime, '%d-%m-%Y') >= '".$data['from_date']."' AND
						DATE_FORMAT(S.datetime, '%d-%m-%Y') <= '".$data['to_date']."' AND
						P.company_id=". $this->session->userdata('company_id'). " GROUP BY PD.product_id";
				}
				else
				{
					$sql = "SELECT DATE_FORMAT(S.datetime,'%d-%m-%Y') AS date, P.name AS product, SUM(SD.quantity) as quantity
						FROM sales S INNER JOIN sale_details SD ON S.id = SD.sale_id 
						INNER JOIN purchase_details PD ON PD.id = SD.purchase_detail_id
						INNER JOIN purchases PU ON PD.purchase_id = PU.id
						INNER JOIN products P ON P.id = PD.product_id 
						WHERE DATE_FORMAT(S.datetime, '%d-%m-%Y') >= '".$data['from_date']."' AND
						DATE_FORMAT(S.datetime, '%d-%m-%Y') <= '".$data['to_date']."' AND
						PU.recieved = 1 AND
						P.company_id=". $this->session->userdata('company_id'). " GROUP BY PD.product_id";
				}

			}
				
			$query = $this->db->query($sql);
			$data['rows'] = $query->result_array();

		}
		else 
		{
			$data['product_id']   = 0;
			$data['product_name'] = '';
			$data['from_date']	  = date('d-m-Y');
			$data['to_date']	  = date('d-m-Y');
		}

		$data['page'] = "reports/sale_report";
		$data['page_title'] = "Sale Report";
		$this->load->view('index',$data);
	}
}