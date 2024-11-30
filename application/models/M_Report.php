<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Report extends CI_Model
{

    public function getMyReport($user_id)
    {
        $base = $this->config->base_url() . 'rm/file/content/';
        $sql = 'select *, CONCAT("' . $base . '", evidence) as evidence from t_report where user_id=' . $user_id . '';
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

    public function getAllReport()
    {
        $base = $this->config->base_url() . 'rm/file/content/';
        $sql = 'select *, CONCAT("' . $base . '", evidence) as evidence from t_report';
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
