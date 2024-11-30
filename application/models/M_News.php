<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_News extends CI_Model {


	public function get_all_news()
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/news/';
		$sql = 'select news_id, user_id, title, description, CONCAT("'.$base.'", image) as image, url, created_date, created_by, modified_date, modified_by, status from t_news where status=1 order by news_id DESC';
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
    
    public function getNewsByUserId($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/news/';
		$sql = 'select news_id, user_id, title, description, CONCAT("'.$base.'", image) as image, url, created_date, created_by, modified_date, modified_by, status from t_news where status=1 and user_id='.$id.' order by news_id DESC';
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
	
	public function get_detail_news($id)
	{
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/news/';
		$sql = 'select news_id, user_id, title, description, CONCAT("'.$base.'", image) as image, url, created_date, created_by, modified_date, modified_by, status from t_news where status=1 and news_id='.$id.'';
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
        $created_date = date("Y-m-d H:i:s");
        $modified_date = date("Y-m-d H:i:s");
        $created_by = $user_id;
        $modified_by = $user_id;
        $status = '1';

		$sql = 'insert into t_job_participant (job_id, participant_id, created_date, created_by, modified_date, modified_by, status) values ("'.$job_id.'", "'.$user_id.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_date.'", "'.$status.'")';
        $query = $this->db->query($sql);
        return array('status' => 200,'message' => 'post participant success.');
    }

    public function get_job_participant($id)
	{
		$sql = 'select * from t_job_participant  where job_id='.$id.'';
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
    
    public function delete_news($news_id, $user_id)
	{
        $modified_date = date("Y-m-d H:i:s");
		$sql = 'update t_news set modified_date="'.$modified_date.'", modified_by='.$user_id.',status=0 where news_id='.$news_id.'';
        $query = $this->db->query($sql);
        return array('status' => 200,'message' => 'news deleted.');
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
