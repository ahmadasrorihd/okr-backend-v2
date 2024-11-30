<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Menu extends CI_Model {

    public function get_menu($id)
    {
        $sql = 'SELECT a.menu_id, b.menu_name, b.menu_image FROM t_menu_access a JOIN t_menu b ON a.menu_id=b.menu_id WHERE a.role_id='.$id.'';
        $query = $this->db->query($sql);
        return array(
          'status' => 200,
          'message' => "Berhasil",
          'data' => $query->result());
    }
}
