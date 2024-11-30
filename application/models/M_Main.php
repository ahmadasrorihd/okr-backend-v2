<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Main extends CI_Model
{

    public function getMyReport($user_id)
    {
        $base = $this->config->base_url() . 'rm/file/content/';
        $sql = 'select a.*, CONCAT("' . $base . '", a.evidence) as evidence, a.teknisi_id, b.nama as nama_teknisi from t_report a left join t_user b on a.teknisi_id=b.id where a.user_id="' . $user_id . '" order by a.id DESC';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Data ditemukan",
                'data' => $result
            );
        } else {
            return array(
                'status' => 200,
                'message' => "Data Kosong",
                'data' => $result
            );
        }
    }

    public function getMyNotif($user_id)
    {
        $sql = 'select * from t_notification where destination_id="' . $user_id . '" order by id DESC';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Data ditemukan",
                'data' => $result
            );
        } else {
            return array(
                'status' => 200,
                'message' => "Data Kosong",
                'data' => $result
            );
        }
    }

    public function getRepair($reportId)
    {
        $base = $this->config->base_url() . 'rm/file/content/';
        $sql = 'select *, CONCAT("' . $base . '", evidence) as evidence from t_repair where report_id=' . $reportId . '';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Data ditemukan",
                'data' => $result
            );
        } else {
            return array(
                'status' => 200,
                'message' => "Data Kosong",
                'data' => $result
            );
        }
    }

    public function getAllReport($startDate, $endDate)
    {
        $base = $this->config->base_url() . 'rm/file/content/';
        $sql = 'select a.*, CONCAT("' . $base . '", a.evidence) as evidence, a.teknisi_id, b.nama as nama_teknisi from t_report a left join t_user b on a.teknisi_id=b.id where a.date>="' . $startDate . '" and a.date<="' . $endDate . '" order by a.id DESC';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Data ditemukan",
                'data' => $result
            );
        } else {
            return array(
                'status' => 200,
                'message' => "Data Kosong",
                'data' => $result
            );
        }
    }

    public function getAllUser()
    {
        $sql = 'select * from t_user';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Data ditemukan",
                'data' => $result
            );
        } else {
            return array(
                'status' => 200,
                'message' => "Data Kosong",
                'data' => $result
            );
        }
    }
}
