<?php

class Company extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		/*User Validation Start*/
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		/*User Validation End*/

		/*pagination Start*/
		$this->load->library('pagination');
		$config['base_url'] = base_url().'index.php/company/index/';
		$config['total_rows'] = $this->db->count_all('companies');
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
			'heading' => array('ID', 'Code', 'Name', 'Pan Number', 'Service Tax Number')
		);
		$this->db->select('id, code, name, pan_no, service_tax_no',false);
		$this->db->where('id', $this->session->userdata['company_id']);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get('companies', $config['per_page'],$this->uri->segment(3));
		$data['rows']=$query->result_array();
		$data['page'] = 'list';
		$data['title'] = "Company List";
		$data['link'] = "company/edit/";
		$data['fields']= array('id','code','name','pan_no','service_tax_no');
		$data['link_col'] = 'id';
		$data['link_url'] = 'company/edit/';
		$data['button_text']='Add Company';
		/*Prepare List View End*/

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
		if($id == 0)
		{
			$this->form_validation->set_rules('code', 'Company Code', 'trim|required|is_unique[companies.code]');	
		}
		$this->form_validation->set_rules('cname', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('caddress', 'Company Address', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('contact', 'Contact', 'trim|required');
		$this->form_validation->set_rules('mobileno', 'Mobile No', 'trim|required|regex_match[/^[0-9(),-]+$/]|xss_clean|max_length[10]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('panno', 'Pan Number', 'trim|required');
		$this->form_validation->set_rules('servicetaxno', 'Service Tax Number', 'trim|required');
		$query = $this->db->query("SELECT code, name, address, city, contact, mobile, email, pan_no, service_tax_no, compniescol 
									FROM companies 
									WHERE id =".$id);
		$row = $query->result_array();

		if($query->num_rows() == 0) {
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
		}
		else 
		{
			$data['id'] =  $id;
			$data['row'] = $row[0];
		}
		$data['page'] = "company_edit";
		if ($this->form_validation->run() == false) 
		{	
			$data['focus_id'] = 'code';
			$data['title'] = 'Company Edit';
			$data['page'] = 'company_edit';	
			$this->load->view('index', $data);
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
					'user_id'=>$this->session->userdata('userid')
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
			
			redirect("company");
			/*redirect("party/edit/".$id."");*/
		}	
		
	}
	
}