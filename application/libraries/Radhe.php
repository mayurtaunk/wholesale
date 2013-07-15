<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Radhe {
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
    public function set_trans($type,$particular,$type1,$vchtype,$vchno,$debit,$credit,$ref,$other_info,$company_id,$type2)
    {
                $CI =& get_instance();
                $CI->load->helper('date');
                $format = 'DATE_ATOM';
                $time = time();
                $data = array(
                    't_date' => standard_date($format, $time),
                    'type' => $type,
                    'particular' => $particular,
                    'type1' => $type1,
                    'vchtype' => $vchtype,
                    'vchno' => $vchno,
                    'credit'=>$debit,
                    'debit'=>$credit,
                    'ref_no'=>$ref,
                    'other_details'=>$other_info,
                    'company_id'=>$company_id,
                    'type2'=>$type2
                );
                $CI->db->insert('transactions', $data);
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