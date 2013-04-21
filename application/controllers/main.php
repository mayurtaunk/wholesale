<?php

class Main extends CI_Controller {
	
	public function index() {
		$this->login();
	}
	public function login(){
		$this->load->view('login');
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('main/login');
	}
	public function signup(){
		$this->load->view('signup');
	}
	public function login_validation(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username','Username','required|trim|xss_clean|callback_validate_credentials');
		$this->form_validation->set_rules('password','Password','required|md5|trim');
		if($this->form_validation->run()){
			$data =array (
					'username' => $this->input->post('email'),
					'is_logged_in' => 1
				);
			$this->session->set_userdata($data);
			$this->master();
		}	
		else
		{
			$this->load->view('login');
		}
	}
	public function signup_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email',"Email",
			'required!trim|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password',"Password",
			'required!trim');
		$this->form_validation->set_rules('cpassword',"Confirm Password",
			'required!trim|matches[password]');
		
		$this->form_validation->set_message('is_unique',"Email ID already exists");
		if ($this->form_validation->run())
		{
			$this->load->model('model_users');
			$this->model_users->add_user();
			echo "pass";

		}
		else
		{
			$this->load->view('signup');
		}
	}
	public function validate_credentials(){
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
	public function master(){
		if($this->session->userdata('is_logged_in'))
		{
			$this->load->view('index');
		}
		else
		{
			$this->load->view('login');
		}

	}
}