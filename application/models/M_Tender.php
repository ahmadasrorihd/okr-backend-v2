<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Tender extends CI_Model {


	public function getAllTender()
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.tender_id, a.user_id, a.title, a.description, a.pagu, a.batas_pendaftaran, c.name as provinsi, d.name as kota, a.persyaratan,  b.nama_lengkap, CONCAT("'.$base.'", b.photo) as photo from t_tender a join t_user b on a.user_id=b.user_id join t_locate_provinsi c on a.provinsi=c.id join t_locate_kabupaten d on a.kota=d.id where a.status=1';
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

    public function getAllTenderByUserId($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.tender_id, a.user_id, a.title, a.description, a.pagu, a.batas_pendaftaran, c.name as provinsi, d.name as kota, a.persyaratan,  b.nama_lengkap, CONCAT("'.$base.'", b.photo) as photo from t_tender a join t_user b on a.user_id=b.user_id join t_locate_provinsi c on a.provinsi=c.id join t_locate_kabupaten d on a.kota=d.id where a.status=1 and a.user_id='.$id.' order by a.tender_id DESC';
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

    public function getDetailTender($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
        $base_profile = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.tender_id, a.user_id, a.title, a.description, a.pagu, a.batas_pendaftaran, c.name as provinsi, c.id as provinsi_id, d.name as kota, d.id as kota_id, a.persyaratan,  b.nama_lengkap, CONCAT("'.$base.'", b.photo) as photo from t_tender a join t_user b on a.user_id=b.user_id join t_locate_provinsi c on a.provinsi=c.id join t_locate_kabupaten d on a.kota=d.id where a.status=1 and a.tender_id='.$id.'';
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

    public function updateTender($tender_id, $user_id, $title, $description, $pagu, $batas_pendaftaran, $provinsi, $kota, $persyaratan)
	{
        $created_date = date("Y-m-d H:i:s");
        $modified_date = date("Y-m-d H:i:s");
        $created_by = $user_id;
        $modified_by = $user_id;
        $status = '1';

        // $sql_update = 'update t_tender set status=0 where tender_id='.$tender_id.'';
        $sql_update = 'update t_tender set user_id='.$user_id.', title="'.$title.'", description="'.$description.'", pagu="'.$pagu.'", batas_pendaftaran="'.$batas_pendaftaran.'", provinsi='.$provinsi.', kota='.$kota.', persyaratan="'.$persyaratan.'", modified_date="'.$modified_date.'", modified_by='.$modified_by.', status='.$status.' where tender_id='.$tender_id.'';
        $query = $this->db->query($sql_update);
        // $sql = 'insert into t_tender (user_id, title, description, pagu, batas_pendaftaran, provinsi, kota, persyaratan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$title.'" , "'.$description.'", "'.$pagu.'", "'.$batas_pendaftaran.'", "'.$provinsi.'", "'.$kota.'", "'.$persyaratan.'","'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
        // $query = $this->db->query($sql);
        return array('status' => 200,'message' => 'tender updated.');
    }

    public function createTender($user_id, $title, $description, $pagu, $batas_pendaftaran, $provinsi, $kota, $persyaratan)
	{
        $created_date = date("Y-m-d H:i:s");
        $modified_date = date("Y-m-d H:i:s");
        $created_by = $user_id;
        $modified_by = $user_id;
        $status = '1';

        $sql = 'insert into t_tender (user_id, title, description, pagu, batas_pendaftaran, provinsi, kota, persyaratan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$title.'" , "'.$description.'", "'.$pagu.'", "'.$batas_pendaftaran.'", "'.$provinsi.'", "'.$kota.'", "'.$persyaratan.'","'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
        $query = $this->db->query($sql);
        return array('status' => 201,'message' => 'tender created.');
    }

    public function postParticipantTender($user_id, $tender_id)
	{
        $sql_cek = 'select * from t_tender_participant where user_id='.$user_id.' and tender_id='.$tender_id.'';
        $query = $this->db->query($sql_cek);
        $result = $query->row();
		if ($query->num_rows() > 0) {
			return array('status' => 302,'message' => 'already apply');
		} else {
            $created_date = date("Y-m-d H:i:s");
            $modified_date = date("Y-m-d H:i:s");
            $created_by = $user_id;
            $modified_by = $user_id;
            $status = '1';
    
            $sql = 'insert into t_tender_participant (tender_id, user_id, created_date, created_by, modified_date, modified_by, status) values ("'.$tender_id.'", "'.$user_id.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
            $query = $this->db->query($sql);
            return array('status' => 200,'message' => 'post participant success.');
        }
    }

    public function getTenderParticipant($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.tender_participant_id, a.tender_id, a.user_id, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap as nama_lengkap, CONCAT("'.$base.'", b.photo) as foto from t_tender_participant a join t_user b on a.user_id=b.user_id  where a.tender_id='.$id.' and b.status=1';
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

    public function getActivityTender($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select c.title, c.description, c.user_id, a.tender_participant_id, a.tender_id, a.user_id, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap as nama, CONCAT("'.$base.'", b.photo) as foto from t_tender_participant a join t_tender c on a.tender_id=c.tender_id join t_user b on c.user_id=b.user_id where a.user_id='.$id.' and b.status=1';
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
    
    public function deleteTender($tender_id, $user_id)
	{
        $modified_date = date("Y-m-d H:i:s");
		$sql = 'update t_tender set modified_date="'.$modified_date.'", modified_by='.$user_id.',status=0 where tender_id='.$tender_id.'';
        $query = $this->db->query($sql);
        return array('status' => 200,'message' => 'tender deleted.');
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
