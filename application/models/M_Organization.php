<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Organization extends CI_Model
{

    public function check_is_leader_group($groupId, $userId)
    {
        $sql = 'select role from t_group_assignment where user_id=' . $userId . ' and group_id=' . $groupId . '';
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

    public function get_company_employee($id)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/user_profile/';
        $sql = 'select a.*, CONCAT("' . $base . '", a.photo) as photo, b.name as group_name from t_user a left join t_group b on a.group_id=b.id where a.company_id="' . $id . '" and not a.role_id=2 order by a.nama_lengkap ASC';
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

    public function get_non_group_member($id, $type)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/user_profile/';
        if ($type == "teams") {
            $sql = 'select user_id, group_id, company_id, nama_lengkap, CONCAT("' . $base . '", photo) as photo from t_user where company_id="' . $id . '" order by nama_lengkap ASC';
        } else {
            $sql = 'select user_id, group_id, company_id, nama_lengkap, CONCAT("' . $base . '", photo) as photo from t_user where company_id="' . $id . '" and group_id=0 order by nama_lengkap ASC';
        }
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

    public function get_filter($typeFilter, $companyId)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/user_profile/';
        if ($typeFilter == "All") {
            $sql = 'select distinct (a.okr_result_id), b.title from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.company_id=' . $companyId . '';
        } else if ($typeFilter == "2") {
            $sql = 'select distinct (a.group_id) as id, b.name as name from t_activity_result a join t_group b on a.group_id=b.id where a.company_id=' . $companyId . '';
        } else {
            $sql = 'select distinct (a.user_id) as id, b.nama_lengkap as name from t_activity_result a join t_user b on a.user_id=b.user_id where a.company_id=' . $companyId . '';
        }
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

    public function get_group_member($id)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/user_profile/';
        $sql = 'select a.id, a.group_id, a.user_id, a.role, a.created_date, b.nama_lengkap, CONCAT("' . $base . '", b.photo) as photo from t_group_assignment a join t_user b on a.user_id=b.user_id where a.group_id="' . $id . '" order by a.role ASC';
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

    public function get_all_group($id)
    {
        $sql = 'select * from t_group where company_id=' . $id . ' order by created_date DESC';
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

    public function getAllJobByUserId($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/job/';
        $base_profile = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.job_id, a.owner_id, a.title, a.description,  CONCAT("' . $base . '", a.image) as image, a.job_open_date, a.job_close_date, a.range_salary, a.responsibility, a.benefit, a.requirement, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap as nama, CONCAT("' . $base_profile . '", b.photo) as profile_image  from t_job a join t_user b on a.owner_id=b.user_id where a.status=1 and a.owner_id=' . $id . ' order by a.job_id DESC';
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

    public function get_job_detail($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/job/';
        $base_profile = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.job_id, a.owner_id, a.title, a.description,  CONCAT("' . $base . '", a.image) as image, a.job_open_date, a.job_close_date, a.range_salary, a.responsibility, a.benefit, a.requirement, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap as nama, CONCAT("' . $base_profile . '", b.photo) as profile_image  from t_job a join t_user b on a.owner_id=b.user_id where a.status=1 and b.status=1 and a.job_id=' . $id . '';
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

    public function post_participant($user_id, $job_id)
    {
        $sql_cek = 'select * from t_job_participant where participant_id=' . $user_id . ' and job_id=' . $job_id . '';
        $query = $this->db->query($sql_cek);
        $result = $query->row();
        if ($query->num_rows() > 0) {
            return array('status' => 302, 'message' => 'already apply');
        } else {
            $created_date = date("Y-m-d H:i:s");
            $modified_date = date("Y-m-d H:i:s");
            $created_by = $user_id;
            $modified_by = $user_id;
            $status = '1';

            $sql = 'insert into t_job_participant (job_id, participant_id, created_date, created_by, modified_date, modified_by, status) values ("' . $job_id . '", "' . $user_id . '", "' . $created_date . '", "' . $created_by . '", "' . $modified_date . '", "' . $modified_by . '", "' . $status . '")';
            $query = $this->db->query($sql);
            return array('status' => 200, 'message' => 'post participant success.');
        }
    }

    public function get_job_participant($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.job_participant_id, a.job_id, a.participant_id, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap, CONCAT("' . $base . '", b.photo) as foto from t_job_participant a join t_user b on a.participant_id=b.user_id  where job_id=' . $id . ' and b.status=1';
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

    public function getActivityJob($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select c.title, c.description, c.owner_id, a.job_participant_id, a.job_id, a.participant_id, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap as nama, CONCAT("' . $base . '", b.photo) as foto from t_job_participant a join t_job c on a.job_id=c.job_id join t_user b on c.owner_id=b.user_id where a.participant_id=' . $id . ' and b.status=1';
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
