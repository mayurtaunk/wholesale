<?php

class Purchase extends CI_Controller {
	function __construct() {
		parent::__construct();


	}


	public function index() {
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		$data['list'] = array(
			'heading' => array('ID', 'Party Name', 'Date', 'Bill No', 'Amount'),
			'link_col'=> "id" ,
			'link_url'=> "purchase/edit/");
		if($this->session->userdata('key')==1)
		{
			
			$query = $this->db->query('SELECT PU.id,DATE_FORMAT(PU.date,"%W, %M %e, %Y") as  datetime,PU.bill_no,P.name, PU.date, PU.bill_no, PU.amount	 
								   FROM purchases PU INNER JOIN parties P 
								   ON PU.party_id = P.id
								   WHERE PU.company_id='. $this->session->userdata('company_id'));
		}
		else
		{
			$query = $this->db->query('SELECT PU.id,DATE_FORMAT(PU.date,"%W, %M %e, %Y") as  datetime,PU.bill_no,P.name, PU.date, PU.bill_no, PU.amount	 
								   FROM purchases PU INNER JOIN parties P 
								   ON PU.party_id = P.id 
								   WHERE PU.recieved=1 and PU.company_id='. $this->session->userdata('company_id'));

		}
		$data['fields']= array('id','name','date','bill_no','amount');
		$data['link_col'] = 'id';
		$data['rows'] = $query->result_array();
		$data['page'] = "list";
		$data['title'] = "Purchase List";
		$data['link'] = "purchase/edit/";
		$data['link_url'] = 'purchase/edit/';
		$data['button_text']='Add New Purchase';
		$this->firephp->info($data);
		$this->load->view('index',$data);
	}

	public function edit($id) {
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		//$this->firephp->info($_POST);exit;
		$this->load->library(array('form_validation'));
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('party_id', 'Party Name', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('bill_no', 'Bill No', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|is_natural_no_zero');
		$query = $this->db->query("SELECT PU.id, PU.party_id, P.name, PU.date, PU.bill_no, PU.amount,PU.recieved	
								   FROM purchases PU INNER JOIN parties P 
								   ON PU.party_id = P.id
								   WHERE PU.id = $id");
		$row = $query->result_array();
		//$this->firephp->info($_POST);exit;
		if($query->num_rows() == 0) {
			$row = array(
				'party_id' => 0,
				'name' => '',
				'date' => date('d-m-Y'),
				'bill_no' => '',
				'amount' => 0,
				'recieved' =>($this->session->userdata('key')==1) ? 0 : 1 
				);
			$data['id'] = 0;
			$data['row'] =  $row; 
		}

		else {
			$data['id'] =  $id;
			$data['row'] = $row[0];
		}
		
		$query = $this->db->query("SELECT PD.id, PD.product_id, P.name, PD.barcode, PD.mrp, 							  PD.purchase_price	, PD.quantity
									   FROM purchase_details PD INNER JOIN products P
									   ON PD.product_id = P.id
									   WHERE PD.purchase_id = $id");
		$data['purchase_details'] = $query->result_array();
			
		$data['page'] = "purchase_edit";
		
		if ($this->form_validation->run() == false) {

			$data['focus_id'] = 'Name';
			$data['title'] = 'Purchase Edit';
			//$data['page'] = 'party_edit';
		
			$this->load->view('index', $data);
		}
		else {
			
			//$this->firephp->info($_POST);exit;
			$data = array(
				'id'	=> $this->input->post('id'),
				'company_id'=>$this->session->userdata('company_id'),
				'party_id' => $this->input->post('party_id'),
				'date' => date_format(date_create($this->input->post('date')), "Y-m-d"),
				'bill_no' => $this->input->post('bill_no'),
				'amount' => $this->input->post('amount'),
				'recieved'=>($this->input->post('recieved')) ? 1 : 0,
				/*'id2'=> ($this->input->post('id')==0 && $this->input->post('recieved')==1) ? $this->radhe->getid('purchases','id2') : 0*/
			);
				//$this->firephp->info($data); exit;
				
			
			if ($data['id'] == 0) {
				$this->db->insert('purchases', $data);
				$query = $this->db->query('SELECT LAST_INSERT_ID()');
				$new_id = $query->row_array();
				$id = $new_id['LAST_INSERT_ID()'];
			}
			else {
				$this->db->update('purchases', $data, "id = '" . $data['id'] . "'");
				$id = $data['id'];
			}


			$product_ids = $this->input->post('product_id');
			$delete_ids  = $this->input->post('delete_id');
			$new_product_ids = $this->input->post('new_product_id');

			if($product_ids != null) {
				$barcodes = $this->input->post('barcode');
				$mrps 	  = $this->input->post('mrp');
				$purchase_prices = $this->input->post('purchase_price');
				$quantities = $this->input->post('quantity');
				foreach ($product_ids as $pdid => $product_id) {
					if(!in_array($pdid, $delete_ids)) {
						$row = array('purchase_id' => $id,
									 'product_id'  => $product_id,
									 'barcode'     => $barcodes[$pdid],
									 'mrp'  	   => $mrps[$pdid],
									 'purchase_price' => $purchase_prices[$pdid],
									 'quantity'    => $quantities[$pdid],
								);


					$this->db->update('purchase_details', $row, array('id' => $pdid));
					}
				}
			}
			foreach ($delete_ids as $key => $value) {
				 $this->db->delete('purchase_details', array('id' => $value)); 
			}
			

		 	if($new_product_ids !=  array('0'=>'')) {
			 	$barcodes = $this->input->post('new_barcode');
				$mrps 	  = $this->input->post('new_mrp');
				$purchase_prices = $this->input->post('new_purchase_price');
				$quantities = $this->input->post('new_quantity');
				foreach ($new_product_ids as $pdid => $product_id) {
					
						$row = array('purchase_id' => $id,
									 'product_id'  => $product_id,
									 'barcode'     => $barcodes[$pdid],
									 'mrp'  	   => $mrps[$pdid],
									 'purchase_price' => $purchase_prices[$pdid],
									 'quantity'    => $quantities[$pdid],
									 'sold'		   => 0
								);

					$this->db->insert('purchase_details', $row);	
				}
			}
			
			redirect("purchase/edit/".$id."");
		}
	}

	function _getautocomplete($sql, $db = null) {
		$newline = array("\n", "\r\n", "\r");
		
		$data = array();
		if ($db == null)
			$query = $this->db->query($sql);
		else
			$query = $db->query($sql);
		$rows = $query->result_array();
		if ($rows) {
			foreach ($rows as $row) {
				if (count($row) == 1) {
					foreach($row as $k => $v)
						$data[] = '"' . addslashes(str_replace($newline, ' ', $v)) . '"';
				}
				else {
					$sdata = array();
					foreach($row as $k => $v)
						$sdata[] = '"' . $k . '": "' . addslashes(str_replace($newline, ' ', $v)) . '"';
					$data[] = '{' . join(',', $sdata) . '}';
				}
			}
		}
		echo '[' . join(',', $data) . ']';
	}


	function ajaxParty() {
		
			$search = strtolower($this->input->get('term'));
		
			$sql = "SELECT id, name
			FROM parties
			WHERE name LIKE '%$search%' 
			ORDER BY name";
			$this->_getautocomplete($sql);
		
	}

	function ajaxProduct() {
		
			$search = strtolower($this->input->get('term'));
		
			$sql = "SELECT id, name
			FROM products
			WHERE active = 1 AND name LIKE '%$search%' 
			ORDER BY name";
			$this->_getautocomplete($sql);
		
	}

}