<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Radhe {
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
}

/* End of file Radhe.php */