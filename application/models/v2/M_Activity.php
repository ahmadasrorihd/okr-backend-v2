<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Activity extends CI_Model
{

    public function getAllActivityByUserId($userId)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/evidence/';
        $sql = 'select * from t_presence where user_id='.$userId.'';
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

    public function getActivityStatusByUserId($userid)
    {
        $where = 'user_id="' . $userid . '" and clock_in=(select max(clock_in) from t_presence where user_id="' . $userid . '")';
        $q  = $this->db->select('id, user_id, clock_in, created_date, status')->from('t_presence')->where($where)->get()->row();
        if ($q == "") {
            return array('status' => 200, 'message' => 'Belum ada data absen.', 'user_id' => $userid, 'status' => 'out');
        } else {
            $id             = $q->id;
            $user_id             = $q->user_id;
            $clock_in             = $q->clock_in;
            $created_date        = $q->created_date;
            $status              = $q->status;
            return array('status' => 200, 'message' => 'Data absen ditemukan.', 'id' => $id, 'clock_in' => $clock_in, 'user_id' => $user_id, 'created_date' => $created_date, 'status' => $status);
        }
    }

    public function get_presence_data_by_okr_id($id, $userId)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/evidence/';
        $sql = 'SELECT a.*, CONCAT("' . $base . '", a.evidence) as evidence, b.title as title_okr, c.name as customer_name, d.nama_lengkap FROM t_presence a left join t_okr b on a.okr_result_id=b.id left join t_customer c on a.customer_id=c.id left join t_user d on a.user_id=d.user_id WHERE  a.okr_result_id="' . $id . '" and a.user_id="' . $userId . '"';
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

    public function get_presence_data($id, $start_date, $end_date, $groupId)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/evidence/';
        $sql = 'SELECT a.*, CONCAT("' . $base . '", a.evidence) as evidence, b.title as title_okr, c.name as customer_name, d.nama_lengkap FROM t_presence a left join t_okr b on a.okr_result_id=b.id left join t_customer c on a.customer_id=c.id left join t_user d on a.user_id=d.user_id WHERE  a.group_id="' . $groupId . '" AND a.created_date BETWEEN "' . $start_date . '" AND "' . $end_date . '"';
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

    public function get_present_location($id, $current_date)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/evidence/';
        $sql = 'SELECT a.*, CONCAT("' . $base . '", a.evidence) as evidence, b.title as title_okr, c.name as customer_name, d.nama_lengkap FROM t_presence a left join t_okr b on a.okr_result_id=b.id left join t_customer c on a.customer_id=c.id left join t_user d on a.user_id=d.user_id WHERE  a.group_id="' . $id . '" AND a.created_date="' . $current_date . '"';
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

    public function get_presence_data_for_spv($groupId, $userId)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/evidence/';
        $sql = 'select a.*, CONCAT("' . $base . '", a.evidence) as evidence, b.nama_lengkap, c.title as title_okr, c.sheet_url from t_presence a left join t_user b on a.user_id=b.user_id left join t_okr c on a.okr_result_id=c.id where a.group_id=' . $groupId . ' and a.approval="pending" and a.status="out"';
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

    public function get_activity_detail($id)
    {
        //$sql = 'select a.okr_result_id, a.progress, a.presence_id, b.objective_id, b.key_result_id, b.minimum_achivement, c.clock_in, c.clock_out, c.approval, c.title, c.description, c.evidence, c.location_clock_in, c.location_clock_out, c.note, d.title as objective_title, d.type, e.title as key_result_title from t_activity_result a join t_okr_result b on a.okr_result_id=b.id join t_presence c on a.presence_id=c.id join t_objective d on b.objective_id=d.id join t_key_result e on b.key_result_id=e.id where a.presence_id="' . $id . '"';
        $sql = 'select a.clock_in, a.clock_out, a.approval, a.title, a.description, a.evidence, a.location_clock_in, a.location_clock_out, a.note, a.created_date, b.progress, b.okr_result_id, c.objective_id, c.key_result_id, c.minimum_achivement, d.title as objective, d.type, e.title as key_result from t_presence a left join t_activity_result b on a.id=b.presence_id left join t_okr_result c on b.okr_result_id=c.id left join t_objective d on c.objective_id=d.id left join t_key_result e on c.key_result_id=e.id where a.id="' . $id . '"';
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

    public function delete_job($job_id, $user_id)
    {
        $modified_date = date("Y-m-d H:i:s");
        $sql = 'update t_job set modified_date="' . $modified_date . '", modified_by=' . $user_id . ',status=0 where job_id=' . $job_id . '';
        $query = $this->db->query($sql);
        return array('status' => 200, 'message' => 'job deleted.');
    }


    public function update_job($job_id, $user_id, $title, $desc, $job_open_date, $job_close_date, $range_salary, $responsibility, $benefit, $requirement)
    {
        $sql = 'update t_job set user_id="' . $user_id . '", title="' . $title . '", desc="' . $desc . '", job_open_date="' . $job_open_date . '", job_close_date="' . $job_close_date . '", range_salary="' . $range_salary . '", responsibility="' . $responsibility . '", benefit="' . $benefit . '", requirement="' . $requirement . '"';
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }
}
