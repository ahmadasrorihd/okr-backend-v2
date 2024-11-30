<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Training extends CI_Model {


	public function get_all_training()
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/training/';
        $base_profile = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.training_id, a.owner_id, a.title, a.description, a.syarat, a.materi, a.fasilitas, CONCAT("'.$base.'", a.image) as image, a.date, a.location, c.name as provinsi, d.name as kota, a.created_date, a.created_by, a.modified_date, a.modified_by, b.nama_lengkap as nama, CONCAT("'.$base_profile.'", b.photo) as profile from t_training a join t_user b on a.owner_id=b.user_id join t_locate_provinsi c on a.provinsi_id=c.id join t_locate_kabupaten d on a.kota_id=d.id where a.status=1 order by a.training_id DESC';
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

    public function getAllTrainingByUserId($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/training/';
        $base_profile = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.training_id, a.owner_id, a.title, a.description, a.syarat, a.materi, a.fasilitas, CONCAT("'.$base.'", a.image) as image, a.date, a.location, c.name as provinsi, d.name as kota, a.created_date, a.created_by, a.modified_date, a.modified_by, b.nama_lengkap as nama, CONCAT("'.$base_profile.'", b.photo) as profile from t_training a join t_user b on a.owner_id=b.user_id join t_locate_provinsi c on a.provinsi_id=c.id join t_locate_kabupaten d on a.kota_id=d.id where a.status=1 and a.owner_id='.$id.' order by a.training_id DESC';
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
        $base_profile = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.training_id, a.owner_id, a.title, a.description, a.syarat, a.materi, a.fasilitas, CONCAT("'.$base.'", a.image) as image, a.date, a.location, a.provinsi_id, a.kota_id, c.name as provinsi, d.name as kota, a.created_date, a.created_by, a.modified_date, a.modified_by, b.nama_lengkap as nama, CONCAT("'.$base_profile.'", b.photo) as profile from t_training a join t_user b on a.owner_id=b.user_id join t_locate_provinsi c on a.provinsi_id=c.id join t_locate_kabupaten d on a.kota_id=d.id where a.status=1 and a.training_id='.$id.'';
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
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.training_participant_id, a.training_id, a.participant_id, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap, CONCAT("'.$base.'", b.photo) as foto  from t_training_participant a join t_user b on a.participant_id=b.user_id where training_id='.$id.'';
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
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select c.title, c.description, c.owner_id, a.training_participant_id, a.training_id, a.participant_id, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap as nama, CONCAT("'.$base.'", b.photo) as foto from t_training_participant a join t_training c on a.training_id=c.training_id join t_user b on c.owner_id=b.user_id where a.participant_id='.$id.' and b.status=1';
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
    
    public function delete_training($training_id, $user_id)
	{
        $modified_date = date("Y-m-d H:i:s");
		$sql = 'update t_training set modified_date="'.$modified_date.'", modified_by='.$user_id.',status=0 where training_id='.$training_id.'';
        $query = $this->db->query($sql);
        return array('status' => 200,'message' => 'training deleted.');
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
