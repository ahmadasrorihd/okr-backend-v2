<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Dashboard extends CI_Model
{

    public function getDashboard($groupId, $companyId)
    {
        $sql = 'select * from t_dashboard where group_id=' . $groupId . ' and company_id=' . $companyId . '';

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
