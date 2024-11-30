<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Feed extends CI_Model {


	public function getAllFeed()
	{
        $base_content = $this->config->base_url().'uploads/ciapi_dev/file/content/';
        $base_profile = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.id, a.user_id, a.title, a.description,  CONCAT("'.$base_content.'", a.content) as content, a.content_type, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap,  CONCAT("'.$base_profile.'", b.photo) as profile from t_feed a join t_user b on a.user_id=b.user_id where a.status=1 order by a.id DESC';
        $query = $this->db->query($sql);
        $result = $query->result();
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $result);
    }

    public function getMyFeed($id)
	{
        $base_content = $this->config->base_url().'uploads/ciapi_dev/file/content/';
        $base_profile = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.id, a.user_id, a.title, a.description,  CONCAT("'.$base_content.'", a.content) as content, a.content_type, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap,  CONCAT("'.$base_profile.'", b.photo) as profile from t_feed a join t_user b on a.user_id=b.user_id where a.status=1 and a.user_id='.$id.' order by a.id DESC';
        $query = $this->db->query($sql);
        $result = $query->result();
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $result);
    }

    public function getDetailFeed($id)
	{
        $base_content = $this->config->base_url().'uploads/ciapi_dev/file/content/';
        $base_profile = $this->config->base_url().'uploads/ciapi_dev/file/image/user_profile/';
		$sql = 'select a.id, a.user_id, a.title, a.description,  CONCAT("'.$base_content.'", a.content) as content, a.content_type, a.created_date, a.created_by, a.modified_date, a.modified_by, a.status, b.nama_lengkap,  CONCAT("'.$base_profile.'", b.photo) as profile from t_feed a join t_user b on a.user_id=b.user_id where a.id='.$id.' and a.status=1';
        $query = $this->db->query($sql);
        $result = $query->result();
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $result);
    }

    public function deleteFeed($id, $user_id)
	{
        $modified_date = date("Y-m-d H:i:s");
		$sql = 'update t_feed set modified_date="'.$modified_date.'", modified_by='.$user_id.',status=0 where id='.$id.'';
        $query = $this->db->query($sql);
        return array('status' => 200,'message' => 'feed deleted.');
	}

}
