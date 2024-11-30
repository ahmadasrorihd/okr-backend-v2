<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Banner extends CI_Model {


    public function get_all_data()
    {
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/banner/';
        $sql = 'select banner_id, user_id, title, description, CONCAT("'.$base.'", image) as image, url, expired_date, created_date from t_banner where status=1';
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

    public function delete_banner($id, $user_id)
    {
        $modified_date = date("Y-m-d H:i:s");
        $sql = 'update t_banner set status=0, modified_date="'.$modified_date.'", modified_by='.$user_id.' where banner_id='.$id.' and user_id='.$user_id.'';
        $query = $this->db->query($sql);
        return array(
          'status' => 200,
          'message' => "banner deleted");
    }

    public function get_banner_by_user($id)
    {
        $base = $this->config->base_url().'uploads/ciapi_dev/file/image/banner/';
        $sql = 'select banner_id, user_id, title, description, CONCAT("'.$base.'", image) as image, url, expired_date, created_date, status from t_banner where user_id='.$id.'';
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

}
