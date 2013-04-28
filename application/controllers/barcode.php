<?php

class Barcode extends CI_Controller {
	public function index() 
	{
		$data['page'] = "barcode_print";
		$this->load->view('index',$data);
	}
	public function print_barcode() 
	{
		$this->firephp->info($_POST);exit;
		$data['page'] = "barcode_print";
		$this->load->view('index',$data);
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
		$this->firephp->info($data);exit;
	}


	function ajaxBarcode() {
		
			$search = strtolower($this->input->get('term'));
			$sql = "SELECT barcode as name,id
			FROM purchase_details
			WHERE barcode LIKE '%$search%' 
			ORDER BY barcode";
			$this->_getautocomplete($sql);
		
	}
}