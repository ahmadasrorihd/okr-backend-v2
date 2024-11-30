<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Regulation extends CI_Model {


	public function getAllRegulation()
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/regulation/';
        $base_user = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.regulation_id, a.user_id, a.title, a.description,  CONCAT("'.$base.'", a.attachment) as attachment, a.created_date, a.created_by, a.modified_date, a.modified_by, CONCAT("'.$base_user.'", b.photo) as profile, b.nama_lengkap from t_regulation a join t_user b on a.user_id=b.user_id where a.status=1';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Berhasil",
                'data' => $result);
        } else {
            return array(
                'status' => 204,
                'message' => "Data Kosong",
                'data' => $result);
        }
    }

    public function getAllRegulationByUserId($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/regulation/';
        $base_user = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.regulation_id, a.user_id, a.title, a.description,  CONCAT("'.$base.'", a.attachment) as attachment, a.created_date, a.created_by, a.modified_date, a.modified_by, CONCAT("'.$base_user.'", b.photo) as profile, b.nama_lengkap from t_regulation a join t_user b on a.user_id=b.user_id where a.status=1 and a.user_id='.$id.' order by a.regulation_id DESC';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Berhasil",
                'data' => $result);
        } else {
            return array(
                'status' => 204,
                'message' => "Data Kosong",
                'data' => $result);
        }
    }

    public function getDetailRegulation($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/regulation/';
        $base_user = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.regulation_id, a.user_id, a.title, a.description,  CONCAT("'.$base.'", a.attachment) as attachment, a.created_date, a.created_by, a.modified_date, a.modified_by, CONCAT("'.$base_user.'", b.photo) as profile, b.nama_lengkap from t_regulation a join t_user b on a.user_id=b.user_id where a.status=1 and a.regulation_id='.$id.'';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Berhasil",
                'data' => $result);
        } else {
            return array(
                'status' => 204,
                'message' => "Data Kosong",
                'data' => $result);
        }
    }

    public function get_training_detail($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/training/';
		$sql = 'select a.training_id, a.owner_id, a.title, a.description,  CONCAT("'.$base.'", a.image) as image, a.date, a.location, a.kota, a.provinsi, a.created_date, a.created_by, a.modified_date, a.modified_by, b.nama from t_training a join t_user_detail_company b on a.owner_id=b.user_id where a.status=1 and a.training_id='.$id.' and b.status=1';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Berhasil",
                'data' => $result);
        } else {
            return array(
                'status' => 204,
                'message' => "Data Kosong",
                'data' => $result);
        }
    }

    public function post_participant($user_id, $job_id)
	{
        $sql_cek = 'select * from t_training_participant where participant_id='.$user_id.' and training_id='.$job_id.'';
        $query = $this->db->query($sql_cek);
        $result = $query->row();
        if ($query->num_rows() > 0) {
			return array('status' => 302,'message' => 'anda sudah terdaftar pada training ini');
		} else {
            $created_date = date("Y-m-d H:i:s");
            $modified_date = date("Y-m-d H:i:s");
            $created_by = $user_id;
            $modified_by = $user_id;
            $status = '1';
    
            $sql = 'insert into t_training_participant (training_id, participant_id, created_date, created_by, modified_date, modified_by, status) values ("'.$job_id.'", "'.$user_id.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
            $query = $this->db->query($sql);
            return array('status' => 200,'message' => 'berhasil mendaftar training ini');
        }
    }

    public function get_training_participant($id)
	{
		$sql = 'select * from t_training_participant where training_id='.$id.'';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Berhasil",
                'data' => $result);
        } else {
            return array(
                'status' => 204,
                'message' => "Data Kosong",
                'data' => $result);
        }
    }

    public function getActivityTraining($id)
	{
		$sql = 'select * from t_training_participant where participant_id='.$id.'';
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return array(
                'status' => 200,
                'message' => "Berhasil",
                'data' => $result);
        } else {
            return array(
                'status' => 204,
                'message' => "Data Kosong",
                'data' => $result);
        }
    }
    
    public function deleteRegulation($regulation_id, $user_id)
	{
        $modified_date = date("Y-m-d H:i:s");
		$sql = 'update t_regulation set modified_date="'.$modified_date.'", modified_by='.$user_id.',status=0 where regulation_id='.$regulation_id.'';
        $query = $this->db->query($sql);
        return array('status' => 200,'message' => 'regulation deleted.');
	}
	
	
	public function update_job($job_id, $user_id, $title, $desc, $job_open_date, $job_close_date, $range_salary, $responsibility, $benefit, $requirement) 
	{
		$sql = 'update t_job set user_id="'.$user_id.'", title="'.$title.'", desc="'.$desc.'", job_open_date="'.$job_open_date.'", job_close_date="'.$job_close_date.'", range_salary="'.$range_salary.'", responsibility="'.$responsibility.'", benefit="'.$benefit.'", requirement="'.$requirement.'"';
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $query->result());
	}
}
