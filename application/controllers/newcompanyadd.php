<?php

class Newcompanyadd extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		

	}
	public function edit($id)
	{
		$this->load->library(array('form_validation'));
		$this->form_validation->set_error_delimiters('', '');	
		$this->form_validation->set_rules('code', 'Company Code', 'trim|required|is_unique[companies.code]');	
		$this->form_validation->set_rules('cname', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('caddress', 'Company Address', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('contact', 'Contact', 'trim|required');
		$this->form_validation->set_rules('mobileno', 'Mobile No', 'trim|required|regex_match[/^[0-9(),-]+$/]|xss_clean|max_length[10]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('panno', 'Pan Number', 'trim|required');
		$this->form_validation->set_rules('servicetaxno', 'Service Tax Number', 'trim|required');
		$row = array(
				'userid' => $id,
				'code' => '',
				'name' => '',
				'address' => '',
				'city'=>'',
				'contact'=>'',
				'mobile'=>'',
				'email'=>'',
				'pan_no'=>'',
				'service_tax_no'=>'',
				'compniescol'=>''
				);
			$data['row'] =  $row; 
		if ($this->form_validation->run() == false) 
		{	
			$data['focus_id'] = 'code';
			$data['title'] = 'Company Edit';	
			//redirect("newcompanyadd/edit/".$id."");
			$this->load->view('newcompany', $data);
		}
		else 
		{
				
				$data = array(
					'code'	=> $this->input->post('code'),
					'name' => $this->input->post('cname'),
					'address' => $this->input->post('caddress'),
					'city' => $this->input->post('city'),
					'contact' => $this->input->post('contact'),
					'mobile' => $this->input->post('mobileno'),
					'email'=>$this->input->post('email'),
					'pan_no'=>$this->input->post('panno'),
					'service_tax_no'=>$this->input->post('servicetaxno'),
					'userid'=>$this->input->post('userid')
				);
			
				$this->db->insert('companies', $data);

				$query = $this->db->query('SELECT LAST_INSERT_ID()');
				$new_id = $query->row_array();
				$uid = $new_id['LAST_INSERT_ID()'];
				$udata= array(
					'company_id' => $uid
					);
				$this->db->update('users', $udata, "id = '" . $id . "'");
			redirect("main");
			/*redirect("party/edit/".$id."");*/
		}	
		
	}
	public function newcompany()
	{
		$this->load->library(array('form_validation'));
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('code', 'Company Code', 'trim|required|is_unique[companies.code]');	
		$this->form_validation->set_rules('cname', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('caddress', 'Company Address', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('contact', 'Contact', 'trim|required');
		$this->form_validation->set_rules('mobileno', 'Mobile No', 'trim|required|regex_match[/^[0-9(),-]+$/]|xss_clean|max_length[10]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('panno', 'Pan Number', 'trim|required');
		$this->form_validation->set_rules('servicetaxno', 'Service Tax Number', 'trim|required');
		$row = array(
				'code' => '',
				'name' => '',
				'address' => '',
				'city'=>'',
				'contact'=>'',
				'mobile'=>'',
				'email'=>'',
				'pan_no'=>'',
				'service_tax_no'=>'',
				'compniescol'=>''
				);
			$data['id'] = 0;
			$data['row'] =  $row; 
		if ($this->form_validation->run() == false) 
		{	
			$data['focus_id'] = 'code';
			$data['title'] = 'Company Edit';
			$data['page'] = 'newcompany';	
			$this->load->view('newcompany', $data);
		}
		else 
		{
				
				$data = array(
					'code'	=> $this->input->post('code'),
					'name' => $this->input->post('cname'),
					'address' => $this->input->post('caddress'),
					'city' => $this->input->post('city'),
					'contact' => $this->input->post('contact'),
					'mobile' => $this->input->post('mobileno'),
					'email'=>$this->input->post('email'),
					'pan_no'=>$this->input->post('panno'),
					'service_tax_no'=>$this->input->post('servicetaxno'),
					'userid'=>$this->session->userdata('userid')
				);
				//$this->firephp->info($data);exit;
			if ($id == 0) {
				$this->db->insert('companies', $data);
				$query = $this->db->query('SELECT LAST_INSERT_ID()');
				$new_id = $query->row_array();
				$id = $new_id['LAST_INSERT_ID()'];
			}
			else 
			{
				$this->db->update('companies', $data, "id = '" . $id . "'");
				$id = $data['id'];
			}
			
			redirect("main");
			/*redirect("party/edit/".$id."");*/
		}
	}
	
}