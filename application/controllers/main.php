<?php

class Main extends CI_Controller {
	
	public function index() 
	{
		$this->login();
	}
	public function login()
	{
		$this->load->view('login');
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('main/login');
	}
	public function signup()
	{
		$this->load->view('signup');
	}
	public function login_validation()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username','Username','required|trim|xss_clean|callback_validate_credentials');
		$this->form_validation->set_rules('password','Password','required|md5|trim');
		if($this->form_validation->run())
		{
			$this->master();
		}	
		else
		{
			$this->load->view('login');
		}
	}
	public function signup_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','Username','required|trim|xss_clean|is_unique[users.username]');
		$this->form_validation->set_rules('email',"Email",
			'required|trim|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password',"Password",
			'required|trim');
		$this->form_validation->set_rules('cpassword',"Confirm Password",
			'required|trim|matches[password]');
		$this->form_validation->set_rules('fullname',"Full Name",'required|trim');
		if ($this->form_validation->run())
		{
			$this->load->model('model_users');
			$this->model_users->add_user();
			redirect('main/login');

		}
		else
		{
			$this->load->view('signup');
		}
	}
	public function validate_credentials()
	{
		$this->load->model('model_users');
		if($this->model_users->can_log_in()){
			return true;
		}
		else
		{
				$this->form_validation->set_message('validate_credentials','Incorrect Username/password');
				return false;
		}

	}
	public function master()
	{
		$canlog=$this->radhe->canlogin();
		/*$this->firephp->info($canlog);exit;
*/		if($canlog==1)
		{
			redirect('dashboard');

		}
		else
		{
			$this->load->view("login");
		}

	}
	function _getautocomplete($sql, $db = null) {
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
	function search() {
		
			$search = strtolower($this->input->get('term'));
			$sql = "SELECT id, name
			FROM products
			WHERE active = 1 AND name LIKE '%$search%' AND company_id=".$this->session->userdata('company_id'). 
			" ORDER BY name";
			$this->_getautocomplete($sql);
	}
	
}