<?php

class Upload extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    /*    $this->load->helper(array('form', 'url'));*/
    }

    function index()
    {

        $this->load->view('upload', array('error' => ' ' ));
    }

    function do_upload()
    {
        $config['upload_path'] = './img/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config); 
        $imgData = file_get_contents('./img/'.$this->input->post('userfile'));
        $data = array(
            'img' =>  mysql_real_escape_string($imgData)
            );
       
        $this->db->insert('uploadtest', $data);
        $dt=$this->radhe->getrowarray('select * from uploadtest');
        header("Content-type: image/jpeg");
        echo mysql_result($db, 0);
        //$this->firephp->info($dt);
    }
}
?>