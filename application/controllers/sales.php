<?php

class Sales extends CI_Controller {
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
		$config['base_url'] = base_url().'index.php/sales/index/';
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
			'heading' => array('ID', 'DateTime', 'Party Name' ,'Discount', 'Amount')
		);
		$data['rows']="";
		$data['help']="Please enter Party name OR Bill Date(yyyy-mm-dd)";
		$data['hhelp'] ="| Ex. Shukla | Ex. 2013-08-11";
		$skey=$this->session->userdata('search_sales');
		if($this->session->userdata('key') == "1")
		{
			$query = $this->db->query("SELECT 
										S.id, S.party_name,
										DATE_FORMAT(S.datetime,'%W, %M %e, %Y') as  datetime, 
										S.less,
										CONCAT('INR ', FORMAT(SUM(SD.price), 2)) AS amount
										FROM sales S 
										INNER JOIN sale_details SD ON S.id = SD.sale_id
										WHERE S.company_id=" . $this->session->userdata('company_id') . " 
										AND SD.sale_id=S.id 
										AND (S.party_name LIKE '%" . $skey . "%' OR S.datetime LIKE '%" . $skey . "%')
										GROUP BY S.id"
									 );
			$data['rows']=$query->result_array();
		}	
		else
		{
			$query = $this->db->query("SELECT 
										S.id, 
										S.party_name,
										DATE_FORMAT(S.datetime,'%W, %M %e, %Y') AS  datetime, 
										S.less,
										CONCAT('INR ', FORMAT(SUM(SD.price), 2)) AS amount
										FROM sales S 
										INNER JOIN sale_details SD ON S.id = SD.sale_id
										INNER JOIN purchase_details PD ON PD.id = SD.purchase_detail_id
										INNER JOIN purchases P ON PD.purchase_id = P.id
										WHERE S.company_id=" . $this->session->userdata('company_id') . "
										AND P.recieved = 1 
										AND SD.sale_id=S.id
										AND (S.party_name LIKE '%" . $skey . "%' OR S.datetime LIKE '%" . $skey . "%')
										GROUP BY S.id"
									);
			
			$data['rows']=$query->result_array();
		}
		$data['page'] = 'list';
		$data['title'] = "Sales List";
		$data['link'] = "sales/edit/";
		$data['fields']= array('id','datetime','party_name','less','amount');
		$data['link_col'] = 'id';
		$data['link_url'] = 'sales/edit/';
		$data['button_text']='New Bill';
		$data['cname'] = 'sales';
		$data['dta'] =  $this->session->userdata['search_sales'];
		/*Prepare List View End*/

		$this->load->view('index',$data);
	}
	public function edit($id)
	{
		/*Verfiy User Start*/
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		/*Uerify User End*/

		$this->load->library('radhe');
		$this->load->helper('date');
		$format = 'DATE_ATOM';
		$time = time();
			
		/*Get Delete Ids to Delete selected Delete Checkbox*/
		$delete_ids  = $this->input->post('delete_id');
		if($delete_ids!=null)
		{
			foreach ($delete_ids as $key => $value) 
			{
				$crnpdid=$this->radhe->getrowarray('select purchase_detail_id from sale_details where id='.$value);
				$row = array('sold' =>0);
				$this->db->update('purchase_details',$row, array('id' => $crnpdid['purchase_detail_id'])); 
				$this->db->delete('sale_details', array('id' => $value));
			}	
		}
		/*Deletion End*/

		/*Data Validation*/		
		$this->load->library(array('form_validation'));
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('sel_barcode', 'sel_barcode', 'required|trim');
		
		/*Data Valdiation End*/
		
		/*Intialization of Variables*/
		$total=0;
		$item=0;
		/*Intialization End*/
		if($this->session->userdata('key') == "1")
		{
			$data['sale_details']= $this->radhe->getresultarray("SELECT pr.name,pr.id,pd.barcode,pd.mrp,pd.mrponpro,pd.vatper,sd.id,sd.sale_id,sd.price,sd.quantity,sd.purchase_detail_id
								   FROM sale_details sd 
								   INNER JOIN purchase_details pd ON sd.purchase_detail_id = pd.id 
								   INNER JOIN products pr ON pd.product_id=pr.id 
								   where sd.sale_id=".$id. " AND pr.company_id=". $this->session->userdata('company_id'));		
		}
		else
		{
			$data['sale_details']= $this->radhe->getresultarray("SELECT pr.name,pr.id,pd.barcode,pd.mrp,pd.mrponpro,pd.vatper,sd.id,sd.sale_id,sd.price,sd.quantity,sd.purchase_detail_id
								   FROM sale_details sd 
								   INNER JOIN purchase_details pd ON sd.purchase_detail_id = pd.id 
								   INNER JOIN products pr ON pd.product_id=pr.id 
								   INNER JOIN purchases P ON PD.purchase_id=P.id
								   where P.recieved = 1 AND sd.sale_id=".$id. " AND pr.company_id=". $this->session->userdata('company_id'));	
		}

		
		foreach ($data['sale_details'] as $key => $value) 
		{
				$total=$total+$value['price'];
				$item=$item+$value['quantity'];
		}
		$data['noproavail']=0;
		$query = $this->db->query("SELECT id, party_name, party_contact,disnote,less,amount,amount_recieved
									FROM sales 
								   	WHERE id =".$id. " AND company_id=". $this->session->userdata('company_id'));
		$row = $query->result_array();
		if($query->num_rows() == 0) 
		{
			$row = array(
				'party_name' => '',
				'party_contact' => '',
				'amount_recieved' => '',
			);
			$data['total']=0;
			$data['item']=0;
			$data['discount']=0;
			$data['topay']=0;
			$data['id'] = 0;
			$data['disnote']="";
			$data['row'] =  $row; 
		}
		else 
		{
			$getrow=$row[0];
			$data['total']=$total;
			$data['item']=$item;
			$data['discount']=$getrow['less'];
			$data['topay']=($total-$data['discount']);
			$data['disnote']=$getrow['disnote'];
			$data['id'] =  $id;
			$data['row'] = $row[0];
			//$this->firephp->info($data['row']);exit;
		}
		
		/*Check Validaion and go Ahead*/
		if ($this->form_validation->run() == false) 
		{
			$data['focus_id'] = 'barcode';
			$data['title'] = 'Sale Edit';
			$data['page'] = "sales";
			/*if just Updation is required for data*/
			if ($id != 0) 
			{
				$sumofprices=$this->radhe->getrowarray('select sum(price) as price from sale_details where sale_id='.$id);
				$topayjustupd= $sumofprices['price']-$this->input->post('discount');
				if($_POST != null)
				{

					$updatequery = array(
						'party_name' => $this->input->post('party_name'),
						'party_contact' => $this->input->post('customer_contact'),
						'type' => 0,
						'datetime' => standard_date($format, $time),
						'less' => $this->input->post('discount'),
						'amount' => $topayjustupd,
						'amount_recieved' => $this->input->post('paid'),
						'disnote' => $this->input->post('disnote')
					);
					$this->db->update('sales', $updatequery, "id = '" . $id . "'");	
				}
				
			}
			/*Updation End*/
			$this->load->view('index', $data);
		}
		else 
		{
			if ($data['id'] == 0) 
			{
				$query=$this->db->query('SELECT MAX(id2) FROM sales');
				$new_id=$query->row_array();
				$genid=$new_id['MAX(id2)'];
				$new_id == '' ? $genid=1 : $genid=$genid+1;
				$insertquery = array(
					'company_id'=>$this->session->userdata('company_id'),
					'party_name' => $this->input->post('party_name'),
					'party_contact' => $this->input->post('customer_contact'),
					'type' => 0,
					'id2' => $genid,
					'datetime' => standard_date($format, $time),
					'less' => $this->input->post('discount'),
					'amount' => $this->input->post('total'),
					'amount_recieved' => $this->input->post('paid'), 
					'disnote' => $this->input->post('disnote')

				);
				$this->db->insert('sales', $insertquery);
				$query = $this->db->query('SELECT LAST_INSERT_ID()');
				$new_id = $query->row_array();
				$id = $new_id['LAST_INSERT_ID()'];
			}
			else
			{
				$sumofprices=$this->radhe->getrowarray('select sum(price) as price from sale_details where sale_id='.$id);
				$topayjustupd= $sumofprices['price']-$this->input->post('discount');
				$updatequery = array(
					'party_name' => $this->input->post('party_name'),
					'party_contact' => $this->input->post('customer_contact'),
					'type' => 0,
					'datetime' => standard_date($format, $time),
					'less' => $this->input->post('discount'),
					'amount' => $topayjustupd,
					'amount_recieved' => $this->input->post('paid'),
					'disnote' => $this->input->post('disnote')
				);
				$this->db->update('sales', $updatequery, "id = '" . $id . "'");
			}
			$sales_detail_ids = $this->input->post('sales_detail_id');
			$flag=0;
			$tosell=$this->input->post('sel_qty');
			if($sales_detail_ids != null) 
			{	

				$barcodes = $this->input->post('barcode');
				$purchase_detail_ids = $this->input->post('purchase_detail_id');
				$prices 	  = $this->input->post('price');
				$quantities = $this->input->post('quantity');	
				foreach ($sales_detail_ids as $sdid => $sale_details_id) 
				{	
					$new_id=$this->radhe->getrowarray('select barcode,mrp from purchase_details where id='. $purchase_detail_ids[$sdid]);
					$purids=$this->radhe->getcommasepresultarray($this->radhe->getresultarray('select id from purchase_details where barcode="'. $barcodes[$sdid].'" and sold <>1'),'id');
					if($purids != null)
					{
						if($this->input->post('sel_barcode')==$new_id['barcode'])
						{
							$flag=1;
							$ststaus=$this->radhe->getstockstatus($purids,$id);
							if($ststaus !=0 )
							{
								$sameprods=$this->radhe->getresultarray('select id from purchase_details where barcode="'. $barcodes[$sdid].'" and sold<>1');
								foreach ($sameprods as $key => $value) 
								{
									if($tosell != 0)
									{
										$thisprod=$this->radhe->getrowarray('select mrp from purchase_details where id='.$value['id']);
										$currstockstat=$this->radhe->getstockstatus($value['id'],$id);
										if($currstockstat==0)
										{
											$row = array('sold' => '1');
												$this->db->update('purchase_details',$row,"id = '" . $value['id'] . "'");
										}
										elseif($currstockstat >= $tosell)
										{							
											$currtotalitems = $quantities[$sdid] + $tosell;
											$currprice = $currtotalitems * $thisprod['mrp'];
											if(in_array($value['id'], $purchase_detail_ids))
											{
												$row = array(
													'price' => $currprice,
													'quantity' => $currtotalitems);
												$this->db->update('sale_details',$row,"id = '" . $sdid . "'");
											}
											else
											{
												$row = array(
													'sale_id' =>$id,
													'purchase_detail_id' => $value['id'],
													'price' => $tosell * $thisprod['mrp'],
													'quantity' => $tosell);
												$this->db->insert('sale_details',$row);		
											}
											if($currstockstat == $tosell)
											{
												$row1 = array('sold' => '1');
												$this->db->update('purchase_details',$row1,"id = '" . $value['id'] . "'");	
											}
											$tosell=0;	
										}
										elseif ($currstockstat < $tosell) 
										{		
											$currtotalitems=$quantities[$sdid]+$currstockstat;
											$currprice=$currtotalitems * $thisprod['mrp'];
											if(in_array($value['id'], $purchase_detail_ids))
											{
												$row = array(
													'price' => $currprice,
													'quantity' => $currtotalitems);
												$this->db->update('sale_details',$row,"id = '" . $sdid . "'");	
											}
											else
											{
												$row = array(
													'sale_id' =>$id,
													'purchase_detail_id' => $value['id'],
													'price' => $tosell * $thisprod['mrp'],
													'quantity' => $tosell);
												$this->db->insert('sale_details',$row);		
											}
											$row1 = array('sold' => '1');
											$this->db->update('purchase_details',$row1,"id = '" . $value['id'] . "'");
											$tosell=$tosell-$currstockstat;
										}
									}
								}		
							}
						}
					}
				}
			}	
			
			if($this->input->post('purchase_autocomplete_id') != null && $flag==0)
			{
				$new_id=$this->radhe->getrowarray('select barcode from purchase_details where id='. $this->input->post('purchase_autocomplete_id'));
				$purids=$this->radhe->getcommasepresultarray($this->radhe->getresultarray('select id from purchase_details where barcode="'. $new_id['barcode'].'" and sold <>1'),'id');
				$ststaus=$this->radhe->getstockstatus($purids,$id);
				if($ststaus != 0)
				{	
					$sameprods=$this->radhe->getresultarray('select id from purchase_details where barcode="'. $new_id['barcode'].'" and sold<>1');
					foreach ($sameprods as $key => $value) 
					{
						if($tosell <> 0)
						{
							$thisprod=$this->radhe->getrowarray('select mrp from purchase_details where id='.$value['id']);
							$currstockstat=$this->radhe->getstockstatus($value['id'],$id);
							if($currstockstat==0)
							{
								$row = array('sold' => '1');
								$this->db->update('purchase_details',$row,"id = '" . $value['id'] . "'");
							}
							elseif($currstockstat >= $tosell)
							{
								$currtotalitems = $tosell;
								$currprice = $currtotalitems * $thisprod['mrp'];
								$row = array(
									'sale_id' =>$id,
									'purchase_detail_id' => $value['id'],
									'price' => $currprice,
									'quantity' => $currtotalitems);
								$this->db->insert('sale_details',$row);		
								if($currstockstat == $tosell)
								{
									$row1 = array('sold' => '1');
									$this->db->update('purchase_details',$row1,"id = '" . $value['id'] . "'");	
								}
								$tosell=0;
							}
							elseif ($currstockstat < $tosell) 
							{
							
								$currtotalitems=$currstockstat;
								$currprice=$currtotalitems * $thisprod['mrp'];
				
								$row = array(
									'sale_id' =>$id,
									'purchase_detail_id' => $value['id'],
									'price' => $currprice,
									'quantity' => $currtotalitems);
								$this->db->insert('sale_details',$row);		
								$row1 = array('sold' => '1');
								$this->db->update('purchase_details',$row1,"id = '" . $value['id'] . "'");
								$tosell=$tosell-$currstockstat;
							}
						}
						
					}			
				}
			}
			
			$sumofprices=$this->radhe->getrowarray('select sum(price) as price from sale_details where sale_id='.$id);
			$topay= $sumofprices['price']-$this->input->post('discount');
			//$this->firephp->info($sumofprices);exit;
			$updateqfin = array(
				'less' => $this->input->post('discount'),
				'amount' => $topay,
				'disnote' =>$this->input->post('disnote')
			);
			$this->db->update('sales', $updateqfin, "id = '" . $id . "'");
			$this->load->view('index',$data);
			redirect("sales/edit/".$id."");
		}	
		
	}
	function preview($id) {
		$canlog=$this->radhe->canlogin();
		if ($canlog!=1)
		{
			redirect('main/login');
		}
		$this->load->library('radhe');
		$data['company_details'] = $this->radhe->getrowarray('select * from companies where id='. $this->session->userdata('company_id'));
		$data['sale'] = $this->radhe->getrowarray('select * from sales where id='.$id);
		$data['sale_details'] = $this->radhe->getresultarray('select P.name, PD.product_id, PD.mrponpro, PD.mrp, PD.vatper, SD.quantity, SD.price from sale_details SD INNER JOIN purchase_details PD ON PD.id=SD.purchase_detail_id INNER JOIN products P ON P.id=PD.product_id where sale_id='.$id);
		$data['total_qty']=$this->radhe->getrowarray('select sum(quantity) as qty from sale_details where sale_id='.$id);
		$data['total_pay']=$this->radhe->getrowarray('select sum(price) as pay from sale_details where sale_id='.$id);
		//$this->firephp->info($data['sale']);
		//$this->firephp->info($data['sale_details']);exit;
		$data['max_items'] = 20;
		$this->load->view('sales_print',$data);
		//$this->load->library('report');
		//$this->report->set_printer(array('name' => Settings::get('printer_name')));
		//$this->report->render("sales_print", $data);
		//$this->report->output(Report::PREVIEW, 'sale.txt');
	}

	function _getautocomplete($sql, $db = null) 
	{
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
	function ajaxBarcode() 
	{
		
			$search = strtolower($this->input->get('term'));	
			$sql = "SELECT distinct PD.id, PD.barcode 
			FROM purchase_details PD INNER JOIN purchases P ON P.id = PD.purchase_id 
			WHERE PD.barcode LIKE '%$search%' AND PD.sold = 0 AND P.company_id = ".$this->session->userdata['company_id'].
			" ORDER BY PD.barcode";
			$this->_getautocomplete($sql);
		
	}
	function search() {
		
			$search = strtolower($this->input->get('term'));
			$data =array (
						'search_sales' => $this->input->get('term')
					);
			$this->session->set_userdata($data);	
	}
}