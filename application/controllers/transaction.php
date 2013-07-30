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
		/*Pagination Configuration*/
		$this->load->library('pagination');
		$config['base_url'] = base_url().'index.php/transaction/index/';
		$config['total_rows'] = $this->db->count_all('transactions');
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
		/*Pagination Configuration*/

		$data['list'] = array(
			'heading' => array('Account Number', 'Date', 'Amount','Type'),
			'link_url'=> "transaction/edit/");
		// $this->db->select('account_id,DATE_FORMAT(date,"%W, %M %e, %Y")as date,CONCAT("INR ", FORMAT(amount, 2)) AS amount,type',false);
		// $this->db->order_by("date", "desc");
		// $query = $this->db->get('transactions', $config['per_page'],$this->uri->segment(3));

		$query = $this->db->query("SELECT A.account_no , DATE_FORMAT(T.date,'%W, %M %e, %Y')as date, T.amount, T.type FROM transactions T 
								   INNER JOIN accounts A ON T.account_id = A.id 
								   ORDER BY date DESC
								   LIMIT ".$config['per_page']);
		$data['rows']=$query->result_array();
		$data['page'] = "list";
		$data['title'] = "Transaction List";
		$data['link'] = "transaction/edit/";
		$data['fields']= array('account_no','date','amount','type');
		$data['link_url'] = 'transaction/edit/';
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
		$this->form_validation->set_rules('particular', 'Particular', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|regex_match[/^[0-9(),-]+$/]|xss_clean');
		$this->form_validation->set_rules('remarks', 'Remarks', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$data['id'] = $id; 
		$row = array(
					'account_id' => '',
					'type' => '',
					'particular' => '',
					'amount' => '',
					'remarks' => ''
					);
		$data['row'] =  $row;
				
		$data['page'] = "Transaction";
		if($data['id'] == 0)
		{
				$data['itemval']='';
				$data['preadonly']= 'false';
				$data['showtype']='true';
		}
		if($data['id'] == 'lightbill') 
		{
				$data['itemval']='Light Bill';
				$data['preadonly'] = 'true';
				$data['showtype']='false';
		}
		if($data['id'] == 'telephonebill') 
		{
				$data['itemval']='Telephone Bill';
				$data['preadonly'] = 'true';
				$data['showtype']='false';
		}
		if($data['id'] == 'employeesalary') 
		{
				$data['itemval']='Employee Salary';
				$data['preadonly'] = 'true';
				$data['showtype']='false';
		}
		if($data['id'] == 'taxes') 
		{
				$data['itemval']='Tax';
				$data['preadonly'] = 'true';
				$data['showtype']='false';
		}
		if($data['id'] == 'other') 
		{
				$data['itemval']='MISC';
				$data['preadonly'] = 'true';
				$data['showtype']='false';
		}
		if($data['id'] == 'inbound') 
		{
				$data['itemval']='INBOUND';
				$data['preadonly'] = 'true';
				$data['showtype']='false';
		}
		//$this->firephp->info($_POST);exit;
		if ($this->form_validation->run() == false) {
			$data['focus_id'] = 'Name';
			$data['title'] = 'Start transaction';
			$data['page'] = 'transaction_edit';	
			$row = array(
				'account_id' => $this->input->post('account_id'),
				'type' => $this->input->post('type'),
				'particular' => $this->input->post('particular'),
				'amount' => $this->input->post('amount'),
				'remarks' => $this->input->post('remarks')
			);
			$itemval = $this->input->post('particular');
			$data['row']=$row;
			$this->load->view('index', $data);
		}
		else 
		{
			if ($data['id'] == "0") 
			{			

				$this->radhe->set_trans($this->input->post('accountid'),$this->input->post('type'),$this->input->post('particular'),$this->input->post('amount'),$this->input->post('remarks'));
			}
			elseif ($data['id'] == "inbound")  
			{
				$this->radhe->set_trans($this->input->post('accountid'),"credit",$this->input->post('particular'),$this->input->post('amount'),$this->input->post('remarks'));	
			}
			else
			{
				$this->radhe->set_trans($this->input->post('accountid'),"debit",$this->input->post('particular'),$this->input->post('amount'),$this->input->post('remarks'));
			}
			redirect("transaction");


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
			WHERE account_no LIKE '%$search%' and company_id=".$this->session->userdata('company_id'). 
			" ORDER BY account_no";
			$this->_getautocomplete($sql);
		
	}
}