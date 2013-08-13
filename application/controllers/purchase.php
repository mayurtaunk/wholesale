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
		/*pagination Start*/
		$this->load->library('pagination');
		$config['base_url'] = base_url().'index.php/purchase/index/';
		$config['total_rows'] = $this->db->count_all('purchases');
		$config['per_page'] = 7;
		$config['num_links']=20;
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		/*pagination Setting End*/

		/*Prepare List View Start*/
		$data['list'] = array(
			'heading' => array('ID', 'Party Name', 'Date', 'Bill No', 'Amount'),
			'link_col'=> "id" ,
			'link_url'=> "purchase/edit/");
		$data['cname'] = 'purchase';
		$data['dta'] =  $this->session->userdata['search_purchase'];
		$sqlquery="";
		$data['help']="Please enter Party name OR Bill Number";
		$data['hhelp'] ="| Ex. Shukla | Ex. G32";
		$skey=$this->session->userdata('search_purchase');
		if($this->session->userdata('key') == "1")
		{
			$uri=($this->uri->segment(3) == null) ? 0 : $this->uri->segment(3);
			$sqlquery = "SELECT PU.id,DATE_FORMAT(PU.date,'%W, %M %e, %Y') as  datetime,PU.bill_no,P.name, PU.date, PU.bill_no, PU.amount	 
								   FROM purchases PU INNER JOIN parties P 
								   ON PU.party_id = P.id
								   WHERE (P.name LIKE '%". $skey .  "%' OR PU.bill_no LIKE '%" .$skey. "%') AND PU.company_id=". $this->session->userdata('company_id') . "
								   LIMIT ". $uri ." , ". $config['per_page'];
			
		}
		else
		{
			$uri=($this->uri->segment(3) == null) ? 0 : $this->uri->segment(3);
			$sqlquery = "SELECT PU.id,DATE_FORMAT(PU.date,'%W, %M %e, %Y') as  datetime,PU.bill_no,P.name, PU.date, PU.bill_no, PU.amount	 
								   FROM purchases PU INNER JOIN parties P 
								   ON PU.party_id = P.id
								   WHERE (P.name LIKE '%". $skey .  "%' OR PU.bill_no LIKE '%" .$skey. "%') AND PU.company_id=". $this->session->userdata('company_id') . "
								   AND recieved=1 LIMIT ". $uri ." , ". $config['per_page'];
		}
		$query = $this->db->query($sqlquery);
		$data['rows']=$query->result_array();
		/*Prepare List View End*/

		$data['link_col'] = 'id';
		$data['fields']= array('id','name','date','bill_no','amount');
		$data['link_col'] = 'id';
		$data['rows'] = $query->result_array();
		$data['page'] = "list";
		$data['title'] = "Purchase List";
		$data['link'] = "purchase/edit/";
		$data['link_url'] = 'purchase/edit/';
		$data['button_text']='Add New Purchase';
		$this->load->view('index',$data);
	}

	public function edit($id) 
	{
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		$this->load->library(array('form_validation'));
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('party_id', 'Party Name', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('bill_no', 'Bill No', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
		$this->form_validation->set_rules('amountpaid', 'Amount Paid', 'trim|required');
		$query = $this->db->query("SELECT PU.id, PU.party_id, P.name, PU.date, PU.bill_no, ROUND(PU.amount,2) AS amount, PU.recieved,PU.amount_paid	
								   FROM purchases PU INNER JOIN parties P 
								   ON PU.party_id = P.id
								   WHERE PU.id =". $id . " AND P.company_id=". $this->session->userdata('company_id'));
		$row = $query->result_array();
		if($query->num_rows() == 0) {
			$row = array(
				'party_id' => 0,
				'name' => '',
				'date' => date('d-m-Y'),
				'bill_no' => '',
				'amount' => 0,
				'amount_paid'=>0,
				'recieved' =>($this->session->userdata('key')==1) ? 0 : 1 
				);
			$data['id'] = 0;
			$data['row'] =  $row; 
		}
		else 
		{
			$data['id'] =  $id;
			$data['row'] = $row[0];
		}
		
		$query = $this->db->query("SELECT PD.id, PD.product_id, P.name, PD.barcode, PD.mrp, PD.mrponpro, PD.vatper, PD.purchase_price, PD.quantity
									   FROM purchase_details PD INNER JOIN products P
									   ON PD.product_id = P.id
									   WHERE PD.purchase_id =". $id . " AND P.company_id=". $this->session->userdata('company_id'));
		$data['purchase_details'] = $query->result_array();
			
		$data['page'] = "purchase_edit";
		
		if ($this->form_validation->run() == false) {

			$data['focus_id'] = 'Name';
			$data['title'] = 'Purchase Edit';
			$this->load->view('index', $data);
		}
		else 
		{
			$setrec = $this->input->post('recieved');
			$data = array(
				'id' => $this->input->post('id'),
				'company_id'=>$this->session->userdata('company_id'),
				'party_id' => $this->input->post('party_id'),
				'date' => date_format(date_create($this->input->post('date')), "Y-m-d"),
				'bill_no' => $this->input->post('bill_no'),
				'amount' => $this->input->post('amount'),
				'amount_paid' => $this->input->post('amountpaid'),
				'recieved'=>($setrec != null) ? 1 : 0,
				/*'id2'=> ($this->input->post('id')==0 && $this->input->post('recieved')==1) ? $this->radhe->getid('purchases','id2') : 0*/
			);
			if ($data['id'] == 0) 
			{
				$this->db->insert('purchases', $data);
				$query = $this->db->query('SELECT LAST_INSERT_ID()');
				$new_id = $query->row_array();
				$id = $new_id['LAST_INSERT_ID()'];
			}
			else 
			{
				$this->db->update('purchases', $data, "id = '" . $data['id'] . "'");
				$id = $data['id'];
			}


			$product_ids = $this->input->post('product_id');
			
			if($this->input->post('delete_id'))
			{
				$delete_ids  = $this->input->post('delete_id');	
			}
			else
			{
				$delete_ids = array();
			}
			$new_product_ids = $this->input->post('new_product_id');

			if($product_ids != null) {
				$barcodes = $this->input->post('barcode');
				$mrps 	  = $this->input->post('mrp');
				$mrponpros 	  = $this->input->post('mrponpro');
				$pervats 	  = $this->input->post('vatper');
				$purchase_prices = $this->input->post('purchase_price');
				$quantities = $this->input->post('quantity');

				foreach ($product_ids as $pdid => $product_id) {
					if(!in_array($pdid, $delete_ids)) {
						$row = array('purchase_id' => $id,
									 'product_id'  => $product_id,
									 'barcode'     => $barcodes[$pdid],
									 'mrp'  	   => $mrps[$pdid],
									 'mrponpro'  	   => $mrponpros[$pdid],
									 'purchase_price' => $purchase_prices[$pdid],
									 'vatper' => $pervats[$pdid],
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
				$mrponpros 	  = $this->input->post('new_mrponpro');
				$vatpers 	  = $this->input->post('new_vatper');
				$purchase_prices = $this->input->post('new_purchase_price');
				$quantities = $this->input->post('new_quantity');
				foreach ($new_product_ids as $pdid => $product_id) {
					
						$row = array('purchase_id' => $id,
									 'product_id'  => $product_id,
									 'barcode'     => $barcodes[$pdid],
									 'mrp'  	   => $mrps[$pdid],
									 'mrponpro'  	   => $mrponpros[$pdid],
									 'vatper'  	   => $vatpers[$pdid],
									 'purchase_price' => $purchase_prices[$pdid],
									 'quantity'    => $quantities[$pdid],
									 'sold'		   => 0
								);

					$this->db->insert('purchase_details', $row);	
				}
			}
			$totalamount = $this->radhe->getrowarray('select sum(purchase_price * quantity + (purchase_price * quantity * (vatper/100))) as sum from purchase_details where purchase_id='.$id);
			$udata = array(
				'amount' => $totalamount['sum']
				);

			
			$this->db->update('purchases', $udata, "id = '" . $id . "'");
			
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
			WHERE name LIKE '%$search%' AND company_id=". $this->session->userdata('company_id').
			" ORDER BY name";
			$this->_getautocomplete($sql);
		
	}

	function ajaxProduct() {
		
			$search = strtolower($this->input->get('term'));
			$sql = "SELECT id, name
			FROM products
			WHERE active = 1 AND name LIKE '%$search%' AND company_id=".$this->session->userdata('company_id'). 
			" ORDER BY name";
			$this->_getautocomplete($sql);
	}
	function search() {
		
			$search = strtolower($this->input->get('term'));
			$data =array (
						'search_purchase' => $this->input->get('term')
					);
			$this->session->set_userdata($data);	
	}

}