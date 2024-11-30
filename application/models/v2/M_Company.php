<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Company extends CI_Model
{


    public function getAllCompany()
    {
        $sql = 'select * from t_company';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Berhasil",
                'data' => $result
            );
        } else {
            return array(
                'status' => 204,
                'message' => "Data Kosong",
                'data' => $result
            );
        }
    }

}
