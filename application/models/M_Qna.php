<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Qna extends CI_Model {


	public function get_qna($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/qna_attachment/';
        $base_profile = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.status, a.qna_id, a.user_id as user_id_pengirim, a.target_id as user_id_penerima, a.title, a.description, CONCAT("'.$base.'", a.attachment) as attachment, a.created_date, b.nama_lengkap as nama_penerima, CONCAT("'.$base_profile.'", b.photo) as foto_penerima, c.nama_lengkap as nama_pengirim, CONCAT("'.$base_profile.'", c.photo) as foto_pengirim from t_qna a join t_user b on a.target_id=b.user_id join t_user c on a.user_id=c.user_id where a.status=1 and a.user_id='.$id.' or a.target_id='.$id.'';
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

	public function get_reply_qna($id)
	{
        //mengambil reply qna berdasarkan qna id
        $base = $this->config->base_url().'uploads/ciapi_dev/file/qna_attachment/';
        $base_foto = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.qna_reply_id, a.qna_id, a.user_id, a.reply_text, CONCAT("'.$base.'", a.attachment) as attachment, a.created_date, b.nama_lengkap, CONCAT("'.$base_foto.'", b.photo) as foto from t_qna_reply a join t_user b on a.user_id=b.user_id where a.qna_id='.$id.' and a.status=1';
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

    public function delete_qna($id)
	{
        //delete = mengubah status dari 1 menjadi 0
		$sql = 'update t_qna set status=0 where qna_id='.$id.'';
		$query = $this->db->query($sql);
        return array(
			'status' => 201,
			'message' => "data deleted");
    }
    
    public function delete_qna_reply($id)
	{
        //delete = mengubah status dari 1 menjadi 0
		$sql = 'update t_qna_reply set status=0 where qna_reply_id='.$id.'';
		$query = $this->db->query($sql);
        return array(
			'status' => 201,
			'message' => "data deleted");
	}
}
