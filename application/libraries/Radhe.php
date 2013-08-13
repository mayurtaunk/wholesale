<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Radhe {
    function getautocomplete($sql, $db = null) 
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
    function _validate_phone_number($value) {
        $value = trim($value);
        $match = '/^\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/';
        $replace = '/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/';
        $return = '($1) $2-$3';
        if (preg_match($match, $value)) 
        {
            return preg_replace($replace, $return, $value);
        } 
        else 
        {
            //
            return false;
        }
    }
    public function set_trans($account_id,$type,$particular,$amount,$remarks)
    {
                $CI =& get_instance();
                $CI->load->helper('date');
                $format = 'DATE_ATOM';
                $time = time();
                $data = array(
                    'account_id' =>$account_id,
                    'date'=> standard_date($format, $time),
                    'type' => $type,
                    'particular' => $particular,
                    'amount'=>$amount,
                    'remarks'=>$remarks,
                    'type1'=>$CI->session->userdata('key'),
                    'company_id'=>$CI->session->userdata('company_id')
                );
                
                $CI->db->insert('transactions', $data);
                $bal=$this->getrowarray('select balance from accounts where account_no='.$account_id);
                if($type == 'credit')
                {
                    $sum=$bal['balance']+$amount;
                    $udata= array(
                    'balance'=> $sum);
                    $CI->db->update('accounts', $udata, "account_no = '" . $account_id . "'");
                }
                elseif($type =='debit')
                {
                    $sum=$bal['balance']-$amount;
                    $udata= array(
                    'balance'=> $sum);
                    $CI->db->update('accounts', $udata, "account_no = '" . $account_id . "'");
                }
                
    }
    public function canlogin()
    {
        $CI =& get_instance();
        if($CI->session->userdata('is_logged_in')==1)
        {
            return 1;
        } 
        else
        {
            return 0;
        }
            
    }
    public function getcommasepresultarray($query,$field)
    {
    	$purids='';
		foreach ($query as $key => $value) {
		$purids=$purids. ',' .$value[$field];
		}
		$purids=substr($purids,1);
		return $purids;
    }
    public function getcommaseprowarray($query)
    {
        $purids='';
        foreach ($query as $key => $value) {
        $purids=$purids. ',' .$value;
        }
        $purids=substr($purids,1);
        return $purids;
    }
    public function getresultarray($graquery)
    {
    	$CI =& get_instance();
    	$graans=$CI->db->query($graquery);
    	return $graans->result_array();
    }
    public function getrowarray($growaquery)
    {	
    	$CI =& get_instance();
    	$growaans=$CI->db->query($growaquery);
    	return $growaans->row_array();	
    }
    public function getstockstatus($purids,$id)
    {
        $tsdata=$this->getrowarray('SELECT SUM(quantity) as "TOTAL_SOLD" FROM sale_details where purchase_detail_id IN('.$purids.')');
        $tadata=$this->getrowarray('SELECT SUM(quantity) as "TOTAL_AVAIL" FROM purchase_details where id IN('.$purids.')');
        $totalsold=($tsdata['TOTAL_SOLD'] == null) ? 0 : $tsdata['TOTAL_SOLD'] ;
        $totalavail=$tadata['TOTAL_AVAIL'];     
        $netavail=$totalavail-$totalsold;
        return $netavail;
    }
    public function getid($tbname,$field)
    {
        $tsdata=$this->getrowarray('select max('.$field.') as "max" from '.$tbname);
        if ($tsdata['max']!=null)
        {
            return $tsdata['max']+1;
        }
        else
        {
            return 1;
        }
    }
}

/* End of file Radhe.php */