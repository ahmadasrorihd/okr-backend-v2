<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Okr extends CI_Model
{

    public function get_okr_assignee($id)
    {
        $base = $this->config->base_url() . 'ciapi_dev/file/image/user_profile/';
        $sql = 'select a.user_id, a.nama_lengkap, CONCAT("' . $base . '", a.photo) as photo from t_user a join t_activity_result b on a.user_id=b.user_id where b.okr_result_id="' . $id . '" order by nama_lengkap ASC';
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

    public function get_dashboard($id, $type)
    {
        if ($type == "1") {
            $sql = 'select distinct (a.okr_result_id), avg(a.progress) as progress , b.title, b.start_date, b.end_date from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.company_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date group by a.okr_result_id order by a.progress DESC';
            $sql_achive = 'select count(okr_result_id) as achieve from t_activity_result where company_id=' . $id . ' group by okr_result_id having avg(progress)>=100';
            $sql_not_achive = 'select count(distinct a.okr_result_id) as not_achieve  from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.company_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date group by a.okr_result_id having avg(a.progress)<100';
            $sql_avg = 'select avg(a.progress) as progress from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.company_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date';
        } else if ($type == "2") {
            $sql = 'select distinct (a.okr_result_id), avg(a.progress) as progress, b.title, b.start_date, b.end_date from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.group_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date group by a.okr_result_id order by a.progress DESC';
            $sql_achive = 'select count(distinct a.okr_result_id) as achieve from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.group_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date group by a.okr_result_id having avg(a.progress)>=100';
            $sql_not_achive = 'select count(distinct a.okr_result_id) as not_achieve from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.group_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date group by a.okr_result_id having avg(a.progress)<100';
            $sql_avg = 'select avg(a.progress) as progress from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.group_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date';
        } else {
            $sql = 'select distinct (a.okr_result_id), avg(a.progress) as progress, b.title, b.start_date, b.end_date from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.user_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date group by a.okr_result_id order by a.progress DESC';
            $sql_achive = 'select count(distinct a.okr_result_id) as achieve from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.user_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date group by a.okr_result_id having avg(a.progress)>=100';
            $sql_not_achive = 'select count(distinct a.okr_result_id) as not_achieve from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.user_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date group by a.okr_result_id having avg(a.progress)<100';
            $sql_avg = 'select avg(a.progress) as progress from t_activity_result a join t_okr b on a.okr_result_id=b.id where a.user_id=' . $id . ' and CURDATE() >= b.start_date and CURDATE() <= b.end_date';
        }

        $query_avg = $this->db->query($sql_avg);
        $result_avg = $query_avg->result();
        $query_achieve = $this->db->query($sql_achive);
        $result_achieve = $query_achieve->result();
        $query_not_achieve = $this->db->query($sql_not_achive);
        $result_not_achieve = $query_not_achieve->result();

        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Berhasil",
                'achieve' => $result_achieve,
                'not_achieve' => $result_not_achieve,
                'avg' => $result_avg,
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

    public function get_okr($id, $type)
    {

        $sql = 'select a.*, b.nama_lengkap from t_okr a left join t_user b on a.created_by=b.user_id where a.okr_type="' . $type . '" and a.company_id=' . $id . ' order by a.id DESC';

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

    public function get_okr_progress($okrResultId, $userId)
    {

        $sql = 'select progress, total_point from t_activity_result where okr_result_id=' . $okrResultId . ' and user_id=' . $userId . '';

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

    public function get_objective($id)
    {
        $sql = 'select * from t_objective where company_id=' . $id . '';
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

    public function get_key_result($id)
    {
        $sql = 'select * from t_key_result where company_id=' . $id . '';
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

    public function get_kpi($id)
    {
        $sql = 'select * from t_kpi where company_id=' . $id . '';
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

    public function get_all_okr_by_group($id)
    {
        $sql = 'select a.id, a.start_date, a.end_date, a.minimum_achivement, b.title as objective_title, b.type, c.title as key_result_title from t_okr_result a join t_objective b on a.objective_id=b.id join t_key_result c on a.key_result_id=c.id';
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

    public function get_leaderboard_by_group($id, $startDate, $endDate)
    {
        $sql = 'SELECT a.user_id, SUM( a.total_point ) as performance, b.nama_lengkap, d.role FROM t_activity_result a join t_user b on a.user_id=b.user_id join t_okr c on a.okr_result_id=c.id join t_group_assignment d on a.user_id=d.user_id where a.group_id="' . $id . '" and c.start_date >= "' . $startDate . '" and c.end_date <= "' . $endDate . '" and not d.role=1 GROUP BY user_id order by performance DESC';
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

    public function get_all_okr_by_user_id($type, $id, $startDate, $endDate)
    {
        if ($type == "leaderboard") {
            $sql = 'select b.okr_result_id, a.id, a.okr_type, a.title, a.description, a.start_date, a.end_date, a.alert_achievement, a.target_point, b.progress, b.total_point from t_okr a join t_activity_result b on a.id=b.okr_result_id where a.start_date >= "' . $startDate . '" and a.end_date <= "' . $endDate . '" and b.user_id="' . $id . '"';
        } else {
            $sql = 'select b.okr_result_id, a.id, a.okr_type, a.title, a.description, a.start_date, a.end_date, a.alert_achievement, a.target_point, target_point, skala_point, survey_url, sheet_url, b.progress from t_okr a join t_activity_result b on a.id=b.okr_result_id where CURDATE() >= a.start_date and CURDATE() <= a.end_date and b.user_id="' . $id . '"';
        }

        $sql_backup = 'select a.okr_result_id, a.progress, b.objective_id, b.key_result_id, b.minimum_achivement, c.title as objective, c.type, d.title as key_result from t_activity_result a join t_okr_result b on a.okr_result_id=b.id join t_objective c on b.objective_id=c.id join t_key_result d on b.key_result_id=d.id where a.user_id="' . $id . '"';
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
