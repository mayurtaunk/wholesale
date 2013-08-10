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
			'heading' => array('Name', 'Stock', 'Whole Seller', 'Contact')
		);

/*		$sql="SELECT PR.name, 
					 (SUM(PD.quantity) - SUM(SD.quantity)) As stock,
					 PA.name as partyname,
					 PA.contact
					 FROM purchases P INNER JOIN purchase_details PD ON P.id = PD.purchase_id
					 INNER JOIN sale_details SD ON PD.id = SD.purchase_detail_id
					 INNER JOIN products PR ON PD.product_id = PR.id
					 INNER JOIN parties PA ON PA.id = P.party_id
					 WHERE P.company_id=".$this->session->userdata('company_id'). 
					 " GROUP BY PR.id";*/
		$sql="SELECT PR.name, 
                     CASE 
                     WHEN (SUM(SD.quantity)) IS NULL THEN PD.quantity 
                     ELSE (pd.quantity - sum(sd.quantity)) 
                     END AS stock,
					 PA.name as partyname,
					 PA.contact
					 FROM products PR
					 INNER JOIN purchase_details PD ON PR.id = PD.product_id
					 INNER JOIN purchases P ON P.id=PD.purchase_id
					 INNER JOIN parties PA ON PA.id=P.party_id
					 LEFT OUTER JOIN sale_details SD ON PD.id = SD.purchase_detail_id
					 WHERE P.company_id=".$this->session->userdata('company_id'). 
					 " GROUP BY PR.name ORDER BY stock";			 
		/*$sql="SELECT PR.name, 
					 (PD.quantity - (SELECT CASE WHEN SUM(SD.quantity) = null THEN 0 ELSE SUM(SD.quantity) END AS quantity)) as stock,
					 PA.name as partyname,
					 PA.contact
					 FROM products PR
					 INNER JOIN purchase_details PD ON PR.id = PD.product_id
					 INNER JOIN purchases P ON P.id=PD.purchase_id
					 INNER JOIN parties PA ON PA.id=P.party_id
					 LEFT OUTER JOIN sale_details SD ON PD.id = SD.purchase_detail_id
					 WHERE P.company_id=".$this->session->userdata('company_id'). 
					 " GROUP BY PR.name ORDER BY stock";			 */
		$dt=$this->radhe->getresultarray($sql);
		/*$this->db->select("SELECT PR.name, 
					 SUM(PD.quantity)-SUM(SD.quantity) As stock,
					 PA.name,
					 PA.contact,
					 FROM purchases P INNER JOIN purchase_details PD ON P.id = PD.purchase_id
					 INNER JOIN sale_details SD ON PD.id = SD.purchase_detail_id
					 INNER JOIN products PR ON PD.product_id = PR.id
					 INNER JOIN parties PA ON PA.id = P.party_id",false);
		$this->db->where('P.company_id', $this->session->userdata['company_id']);
		//$this->db->group_by("PD.product_id");
		//$this->db->order_by("id", "desc"); 
		*/
		$query = $this->db->get('sales', $config['per_page'],$this->uri->segment(3));
		$data['rows']=$dt;
		$data['page'] = 'list';
		$data['title'] = "Sales List";
		$data['link'] = "sales/edit/";
		$data['fields']= array('name','stock','partyname','contact');
		$data['link_col'] = 'id';
		$data['link_url'] = 'sales/edit/';
		$data['button_text']='New Bill';
		/*Prepare List View End*/
		$data['page']  = "dashboard";
		$data['title'] = "Dashboard";
		$this->load->view('index',$data);
	}

}