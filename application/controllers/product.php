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
		$data['list'] = array(
			'heading' => array('ID', 'Name', 'Category', 'Active'),
			'link_col'=> "id" ,
			'link_url'=> base_url('product/edit'));
		
		$query = $this->db->query('SELECT id, name, category, active FROM products');
		$data['link'] = 'product/edit/';
		$data['rows'] = $query->result_array();
		
		$data['page']     = "list";
		$data['title'] = "Product List";
		$data['fields']   = array('id','name','category','active');
		$data['link_col'] = 'id';
		$data['link_url'] = 'product/edit/';
		$data['button_text']='Add New Product';
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
		$query = $this->db->query("SELECT name, category, active FROM products WHERE id = $id");
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
					'active' => $this->input->post('active')
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
}