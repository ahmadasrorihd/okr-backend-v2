<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Banner','m');
		$this->load->model('M_Utils', 'm_utils');
	}

	public function get_banner()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_all_data();
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function delete_banner()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
                    $id = $this->input->post('banner_id');
					$user_id = $this->input->post('user_id');
					$resp = $this->m->delete_banner($id, $user_id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function get_banner_by_user($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_banner_by_user($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function create_banner()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$title = $this->input->post('title');
                    $description = $this->input->post('description');
                    $url = $this->input->post('url');
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/banner/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'banner_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';
                    $expired_date = date("Y-m-d H:i:s");

					if($this->upload->do_upload('image'))
					{
						$uploadData = $this->upload->data();
						$image = $uploadData['file_name'];
                        $sql_create = 'insert into t_banner (user_id, title, description, image, url, expired_date, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$title.'", "'.$description.'", "'.$image.'", "'.$url.'", "'.$expired_date.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data created.'));
					}
					else
					{
                        $picture = "default.png";
                        $sql_create = 'insert into t_banner (user_id, title, description, image, url, expired_date, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$title.'", "'.$description.'", "'.$image.'", "'.$url.'", "'.$expired_date.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data created.'));
					}
				}
			}
		}
	}
	
}
