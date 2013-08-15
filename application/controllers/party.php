<?php

class Party extends CI_Controller {
	function __construct() {
		parent::__construct();


	}


	public function index() {
		$sudata =array (
						'current_tab' => 'party'
					);
		$this->session->set_userdata($sudata);
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		/*pagination Start*/
		$this->load->library('pagination');
		$config['base_url'] = base_url().'index.php/party/index/';
		$config['total_rows'] = $this->db->count_all('parties');
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
			'heading' => array('ID', 'Name', 'Address', 'Contact'),
			'link_col'=> "id" ,
			'link_url'=> "party/edit/");
		$uri=($this->uri->segment(3) == null) ? 0 : $this->uri->segment(3);
		$sqlquery="";
		$data['help']="Please enter party name";
		$data['hhelp'] ="| Ex. Shukla";
		$sqlquery = "SELECT id,name,address,contact	 
					 FROM parties 
					 WHERE name LIKE '%" . $this->session->userdata('search_party') . "%' 
					 AND company_id=". $this->session->userdata('company_id') . "
					 ORDER BY id LIMIT ". $uri ." , ". $config['per_page'];	
		$query = $this->db->query($sqlquery);
		$data['rows']=$query->result_array();
		$data['page'] = 'list';
		$data['title'] = "Party List";
		$data['link'] = "party/edit/";
		$data['fields']= array('id','name','address','contact');
		$data['link_col'] = 'id';
		$data['link_url'] = 'party/edit/';
		$data['button_text']='Add New Party';
		$data['cname'] = 'party';
		$data['dta'] =  $this->session->userdata['search_party'];
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
		$this->form_validation->set_rules('name', 'Party Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim');
		//$this->form_validation->set_rules('contact', 'Contact', 'trim');

		$this->form_validation->set_rules('contact', 'Contact', 'required|regex_match[/^[0-9(),-]+$/]|xss_clean');
		$query = $this->db->query("SELECT name, address, contact FROM parties WHERE id =". $id. " AND company_id=".$this->session->userdata('company_id'));
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
	function search() {
		
			$search = strtolower($this->input->get('term'));
			$data =array (
						'search_party' => $this->input->get('term')
					);
			$this->session->set_userdata($data);	
	}
}