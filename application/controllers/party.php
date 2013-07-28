<?php

class Party extends CI_Controller {
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
			'heading' => array('ID', 'Name', 'Address', 'Contact'),
			'link_col'=> "id" ,
			'link_url'=> "party/edit/");
		
		$query = $this->db->query('SELECT id, name, address, contact FROM parties');

		$data['rows'] = $query->result_array();
		$data['page'] = "list";
		$data['title'] = "Party List";
		$data['link'] = "party/edit/";
		$data['fields']= array('id','name','address','contact');
		$data['link_col'] = 'id';
		$data['link_url'] = 'party/edit/';
		$data['button_text']='Add New Party';
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
		$this->form_validation->set_rules('name', 'Party Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim');
		//$this->form_validation->set_rules('contact', 'Contact', 'trim');

		$this->form_validation->set_rules('contact', 'Contact', 'required|regex_match[/^[0-9(),-]+$/]|xss_clean');
		$query = $this->db->query("SELECT name, address, contact FROM parties WHERE id = $id");
		$row = $query->result_array();

		if($query->num_rows() == 0) {
			$row = array(
				'name' => '',
				'address' => '',
				'contact' => '',
				'company_id'=>$this->session->userdata('company_id')
				);
			$data['id'] = 0;
			$data['row'] =  $row; 
		}

		else {
			$data['id'] =  $id;
			$data['row'] = $row[0];
		}

		
		$data['page'] = "party_edit";
		//$this->firephp->info($data); exit;

		if ($this->form_validation->run() == false) {
			
			
			$data['focus_id'] = 'Name';
			$data['title'] = 'Party Edit';
			$data['page'] = 'party_edit';
	
			
			$this->load->view('index', $data);
		}
		else {
			
				//$this->firephp->info($_POST); exit;
		
				$data = array(
					'id'	=> $this->input->post('id'),
					'name' => $this->input->post('name'),
					'address' => $this->input->post('address'),
					'contact' => $this->input->post('contact'),
					'company_id'=>$this->session->userdata('company_id')
				);
			
				
			
			if ($data['id'] == 0) {
				$this->db->insert('parties', $data);
				$query = $this->db->query('SELECT LAST_INSERT_ID()');
				$new_id = $query->row_array();
				$id = $new_id['LAST_INSERT_ID()'];
			}
			else {
				$this->db->update('parties', $data, "id = '" . $data['id'] . "'");
				$id = $data['id'];
			}
			
			redirect("party");
			/*redirect("party/edit/".$id."");*/
		}
	}
}