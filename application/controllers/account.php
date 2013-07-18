<?php

class Account extends CI_Controller {
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
		$config['base_url'] = base_url().'index.php/account/index/';
		$config['total_rows'] = $this->db->count_all('accounts');
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
			'heading' => array('ID','Account_no','name','Balance'),
			'link_col'=> "ID" ,
			'link_url'=> "account/edit/");
		$this->db->select('id,account_no,name,CONCAT("INR ", FORMAT(balance, 2)) AS balance',false);
		$this->db->order_by("account_no", "desc"); 
		$query = $this->db->get('accounts', $config['per_page'],$this->uri->segment(3));
		$data['rows']=$query->result_array();
		$data['page'] = "list";
		$data['title'] = "Bank Account List";
		$data['link'] = "account/edit/";
		$data['fields']= array('id','account_no','name','balance');
		$data['link_col'] = 'id';
		$data['link_url'] = 'account/edit/';
		$data['button_text']='Add New Account';
		$this->load->view('index',$data);
	}
	public function validate_mobile()
		{
			//$this->firephp->info($this->radhe->_validate_phone_number($this->input->post('b_details_mobile'))); exit;
			return $this->radhe->_validate_phone_number($this->input->post('b_details_mobile'));
		}
	public function edit($id) {
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		$this->load->library(array('form_validation'));
		$this->form_validation->set_error_delimiters('', '');
		//$this->form_validation->set_rules('b_details_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('b_details_acc_no', 'Account No', 'trim|required|numeric');
		//$this->form_validation->set_rules('b_details_bank', 'Bank Name', 'trim|required');
		//$this->form_validation->set_rules('b_details_state', 'Bank State', 'trim|required');
		//$this->form_validation->set_rules('b_details', 'Bank Branch', 'trim|required');*/
		$this->form_validation->set_rules('b_details_mobile','Mobile No','required|trim|numeric|max_length[10]callback_validate_mobile');
		$this->form_validation->set_rules('b_details_mobile','Mobile No','required|numeric');
		$query = $this->db->query("SELECT id, holder_name, account_no, bank, branch, balance FROM accounts WHERE id = $id");
		$row = $query->result_array();
		
		if($query->num_rows() == 0) {
			$row = array(
				'name' => '',
				'account_no' => '',
				'bankname' => '',
				'state' => '',
				'branch' => '',
				'mobileno' => '',
				'balance'=>''
				);
			$data['id'] = 0;
			$data['row'] =  $row; 
		}
		else {
			//$this->firephp->info($row[0]);exit;
			$data['id'] =  $id;
			$data['row'] = $row[0];

		}
		$data['page'] = "add_bank";
		//$this->firephp->info($data); exit;

		if ($this->form_validation->run() == false) {
			$data['focus_id'] = 'Name';
			$data['title'] = 'Bank Account';
			$data['page'] = 'add_bank';
			$this->load->view('index', $data);
			$this->form_validation->set_message('_validate_phone_number', 'Invalid Phone.');
		}
		else {
			
				//$this->firephp->info($_POST); exit;
		
				$data = array(
					'id'	=> $this->input->post('id'),
					'name' => $this->input->post('b_details_name'),
					'account_no' => $this->input->post('b_details_acc_no'),
					'bankname' => $this->input->post('b_details_bank'),
					'branch' => $this->input->post('b_details_state'),
					'state' => $this->input->post('b_details'),
					'mobileno' => $this->input->post('b_details_mobile'),
					'company_id' => 1,
					'balance'=>$this->input->post('b_details_op')
				);
			
			if ($data['id'] == 0) {
				$this->db->insert('bank_details', $data);
				$query = $this->db->query('SELECT LAST_INSERT_ID()');
				$new_id = $query->row_array();
				$id = $new_id['LAST_INSERT_ID()'];
			}
			else {
				$this->db->update('bank_details', $data, "id = '" . $data['id'] . "'");
				$id = $data['id'];
			}
			redirect("bank/edit/".$id."");
		}
	}
}