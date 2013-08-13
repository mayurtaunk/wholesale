<?php

class Product extends CI_Controller {
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
		$config['base_url'] = base_url().'index.php/product/index/';
		$config['total_rows'] = $this->db->count_all('products');
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
		$uri=($this->uri->segment(3) == null) ? 0 : $this->uri->segment(3);
		$sqlquery="";
		$data['help']="Please enter product name";
		$data['hhelp'] ="| Ex. Data communication";
		$sqlquery = "SELECT id,name,category,active	 
					 FROM products 
					 WHERE name LIKE '%" . $this->session->userdata('search_product') . "%'
					 AND company_id=". $this->session->userdata('company_id') . " 
					 ORDER BY id LIMIT ". $uri ." , ". $config['per_page'];	
		$query = $this->db->query($sqlquery);
		$data['rows']=$query->result_array();
		$data['page'] = 'list';
		$data['title'] = "Product List";
		$data['link'] = "product/edit/";
		$data['fields']= array('id','name','category','active');
		$data['link_col'] = 'id';
		$data['link_url'] = 'product/edit/';
		$data['button_text']='Add new Product';
		$data['cname'] = 'product';
		$data['dta'] =  $this->session->userdata['search_product'];
		/*Prepare List View End*/
		$data['list'] = array(
			'heading' => array('ID', 'Name', 'Category', 'Active'),
			'link_col'=> "id" ,
			'link_url'=> base_url('product/edit'));
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
		$this->form_validation->set_rules('name', 'Party Name', 'trim|required');
		$this->form_validation->set_rules('category', 'category', 'trim');
		$this->form_validation->set_rules('active', 'active', 'trim');
		$query = $this->db->query("SELECT name, category, active FROM products WHERE id =". $id. " AND company_id=".$this->session->userdata('company_id'));
		$row = $query->result_array();

		if($query->num_rows() == 0) {
			$row = array(
				'name' => '',
				'category' => '',
				'active' => ''
				);
			$data['id'] = 0;
			$data['row'] =  $row; 
		}

		else {
			$data['id'] =  $id;
			$data['row'] = $row[0];
		}

		
		$data['page'] = "product_edit";
		//$this->firephp->info($data); exit;

		if ($this->form_validation->run() == false) {
			
			
			$data['focus_id'] = 'Name';
			$data['title'] = 'Product Edit';
			$data['page'] = 'product_edit';
	
			
			$this->load->view('index', $data);
		}
		else {
			
				//$this->firephp->info($_POST); exit;
		
				$data = array(
					'id'	=> $this->input->post('id'),
					'name' => $this->input->post('name'),
					'category' => $this->input->post('category'),
					'active' => $this->input->post('active'),
					'company_id'=>$this->session->userdata('company_id')
				);
			
				
			
			if ($data['id'] == 0) {
				$this->db->insert('products', $data);
				$query = $this->db->query('SELECT LAST_INSERT_ID()');
				$new_id = $query->row_array();
				$id = $new_id['LAST_INSERT_ID()'];
			}
			else {
				$this->db->update('products', $data, "id = '" . $data['id'] . "'");
				$id = $data['id'];
			}
			
			
			redirect("product");
		}
	}	
	function search() {
		
			$search = strtolower($this->input->get('term'));
			$data =array (
						'search_product' => $this->input->get('term')
					);
			$this->session->set_userdata($data);	
	}
}