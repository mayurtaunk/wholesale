<?php

class Transaction extends CI_Controller {
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
			'heading' => array('ID', 'account_id', 'date', 'amount'),
			'link_col'=> "id" ,
			'link_url'=> "transaction/edit/");
		$query = $this->db->query('SELECT id, account_id, date, amount FROM Transactions');

		$data['rows'] = $query->result_array();
		$data['page'] = "list";
		$data['title'] = "Transaction List";
		$data['link'] = "Transaction/edit/";
		$data['fields']= array('id','account_id','date','amount');
		$data['link_col'] = 'id';
		$data['link_url'] = 'Transaction/edit/';
		$data['button_text']='Add New Transaction';
		$this->load->view('index',$data);
	}

	public function edit($id) {
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		$this->load->library(array('form_validation'));
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('accountnumber', 'Account Number', 'trim|required');
		$this->form_validation->set_rules('payto', 'Pay to', 'trim|required');
		$this->form_validation->set_rules('particular', 'Particular', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|regex_match[/^[0-9(),-]+$/]|xss_clean');
		$this->form_validation->set_rules('remarks', 'Remarks', 'trim|required');
		$query = $this->db->query("SELECT id,account_id , type,particular,amount,remarks FROM transactions WHERE id = $id");
		$row = $query->result_array();

		if($query->num_rows() == 0) {
			$row = array(
				'account_id' => '',
				'type' => '',
				'particular' => '',
				'amount' => '',
				'remarks' => ''
				);
			$data['id'] = 0;
			$data['row'] =  $row; 
		}

		else {
			$data['id'] =  $id;
			$data['row'] = $row[0];
		}

		
		$data['page'] = "Transaction";

		if ($this->form_validation->run() == false) {
			
			
			$data['focus_id'] = 'Name';
			$data['title'] = 'Start transaction';
			$data['page'] = 'transaction';		
			$this->load->view('index', $data);
		}
		else {
			
				$data = array(
					'id'=>$this->input->post('id'),
					'account_id' => $this->input->post('accountid'),
					'type' => $this->input->post('type'),
					'particular' => $this->input->post('particular'),
					'amount' => $this->input->post('amount'),
					'remarks' => $this->input->post('remarks'),
				);
			
				
			
			if ($data['id'] == 0) {
				$this->firephp->info($data);exit;
				$this->db->insert('transactions', $data);
				$query = $this->db->query('SELECT LAST_INSERT_ID()');
				$new_id = $query->row_array();
				$id = $new_id['LAST_INSERT_ID()'];
			}
			else {
				$this->db->update('transactions', $data, "id = '" . $data['id'] . "'");
				$id = $data['id'];
			}
			
			
			redirect("transaction/edit/".$id."");
		}
	}
	function _getautocomplete($sql, $db = null) 
	{
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
	function ajaxaccountnumber() 
	{
		
			$search = strtolower($this->input->get('term'));	
			$sql = "SELECT id, account_no
			FROM accounts 
			WHERE account_no LIKE '%$search%' 
			ORDER BY account_no";
			$this->_getautocomplete($sql);
		
	}
}