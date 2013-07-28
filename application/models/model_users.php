<?php
class Model_users extends CI_Model {
	public function can_log_in() {
		$this->db->where('password',md5($this->input->post('password')));
		$this->db->where('username',$this->input->post('username'));
		$query =$this->db->get('users');
		$tdata =$query->row_array();
		if($tdata['company_id'] != null) {
			$defval = $this->radhe->getrowarray("SELECT value FROM settings WHERE name ='default_company' AND user_id = ".$tdata['id']);
			if($query->num_rows() == 1) {
				$data =array (
						'userid' => $tdata['id'],
						'key' => $tdata['key'],
						'is_logged_in' => 1,
						'company_id' => $defval['value']
					);
				$this->session->set_userdata($data);
				return true;
			}
			else
				return false;
		}
		else
			$this->load('company_edit');
	}
	public function add_user(){
		$data = array(
			'email'    => $this->input->post('email'),
			'password' => md5($this->input->post('password')),
			'username' => $this->input->post('username'),
			'fullname' => $this->input->post('fullname')
		);
		$query = $this->db->insert('users',$data);
		if ($query){
			return true;
		}
		else{
			return false;
		}
	}
}