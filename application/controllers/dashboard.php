<?php

class Dashboard extends CI_Controller {
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
		$config['base_url'] = base_url().'index.php/dashboard/index/';
		$config['total_rows'] = $this->db->count_all('sales');
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
			'heading' => array('Product', 'Available', 'Party', 'Contact')
		);
		$this->db->select('id, DATE_FORMAT(datetime,"%W, %M %e, %Y") as  datetime, less,CONCAT("INR ", FORMAT(amount, 2)) AS amount',false);
		$this->db->where('company_id', $this->session->userdata['company_id']);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get('sales', $config['per_page'],$this->uri->segment(3));
		$data['rows']=$query->result_array();
		$data['page'] = 'list';
		$data['title'] = "Sales List";
		$data['link'] = "sales/edit/";
		$data['fields']= array('id','datetime','less','amount');
		$data['link_col'] = 'id';
		$data['link_url'] = 'sales/edit/';
		$data['button_text']='New Bill';
		/*Prepare List View End*/
		$data['page']  = "dashboard";
		$data['title'] = "Dashboard";
		$this->load->view('index',$data);
	}

}