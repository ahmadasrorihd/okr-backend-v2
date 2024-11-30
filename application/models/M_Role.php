<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Role extends CI_Model {

    public function get_user_role()
    {
        $sql = "SELECT * FROM t_user_role where t_user_role.user_role_name <> 'admin'";
        $query = $this->db->query($sql);
        return array(
          'status' => 200,
          'message' => "Success",
          'data' => $query->result());
    }
}
