<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('M_News','m');
		$this->load->model('M_Utils', 'm_utils');
	}
	
	public function get_all_news() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_all_news();
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getNewsByUserId($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getNewsByUserId($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
	
	public function getDetailNews($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_detail_news($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
	public function create_news() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$user_id = $this->input->post('user_id');
					$title = $this->input->post('title');
					$desc = $this->input->post('desc');
                    
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/image/news/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_news_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                                        // daftar topic
                    // 1. 0 = all
                    // 2. 2 = personil
                    // 3. 3 = bujp
                    // 4. 4 = mitrabisnis
                    // 5. 5 = regulator
                    // 6. 6 = organisasi
                    $this->m_utils->send_notif('Info berita terbaru - '.$title, $desc, '0', $user_id, '0');
					if($this->upload->do_upload('image'))
					{
						// $this->upload->do_upload('cover');
						$uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                        $sql = 'insert into t_news (user_id, title, description, image, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'", "'.$picture.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        $query = $this->db->query($sql);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'news created.'));
					}
					else
					{
                        $picture = "default.png";
						$uploadData = $this->upload->data();
                        $sql = 'insert into t_news (user_id, title, description, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        $query = $this->db->query($sql);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'news created.'));
					}
				}
			}
		}
    }
    
    public function update_news() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$news_id = $this->input->post('news_id');
					$user_id = $this->input->post('user_id');
					$title = $this->input->post('title');
					$desc = $this->input->post('desc');
                    
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/image/news/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_news_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('image'))
					{
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                        $sql_update = 'update t_news set title="'.$title.'", description="'.$desc.'", image="'.$picture.'", modified_date="'.$modified_date.'", modified_by="'.$modified_by.'" where news_id='.$news_id.'';
                        $exe_update = $this->db->query($sql_update);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'news updated'));
					}
					else
					{
                        $picture = "default.png";
                        $sql_update = 'update t_news set title="'.$title.'", description="'.$desc.'", modified_date="'.$modified_date.'", modified_by="'.$modified_by.'" where news_id='.$news_id.'';
                        $exe_update = $this->db->query($sql_update);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'news updated'));
					}
				}
			}
		}
    }
    
    public function delete_news() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
                    $news_id = $this->input->post('news_id');
                    $user_id = $this->input->post('user_id');
					$resp = $this->m->delete_news($news_id, $user_id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function post_participant() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
                    $user_id = $this->input->post('user_id');
                    $job_id = $this->input->post('job_id');
                    $response = $this->m_job->post_participant($user_id,$job_id);
					$this->m_utils->json_output($response['status'],$response);
				}
			}
		}
    }
}
