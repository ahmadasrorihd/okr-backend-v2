<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Version extends CI_Model {
	
    public function get_version($flag)
    {
        $sql = 'select * from t_version_apps where flag="'.$flag.'"';
        $query = $this->db->query($sql);
        return array(
          'status' => 200,
          'message' => "Berhasil",
          'data' => $query->result());
    }
	
}
