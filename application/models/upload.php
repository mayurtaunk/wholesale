<?php
class Upload extends CI_Model{
    function saves($filename, $filedata, $post_id){
        $this->db->query("INSERT INTO tbl_files SET file_data='$filedata', filename='$filename', postid='$post_id'");
    }
}
?>