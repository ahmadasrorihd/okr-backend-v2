<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Regulation extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('M_Regulation','m');
		$this->load->model('M_Utils', 'm_utils');
	}
	
	public function getAllRegulation() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getAllRegulation();
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getAllRegulationByUserId($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getAllRegulationByUserId($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getDetailRegulation($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getDetailRegulation($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getActivityTraining($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getActivityTraining($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function get_training_participant($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_training_participant($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

	
	public function createRegulation() {
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
					$desc = $this->input->post('description');
					$attachment = $this->input->post('attachment');
                    
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/regulation/';
					$config['allowed_types'] = 'pdf';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'regulation_attachment_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    // daftar topic
                    // 1. 0 = all
                    // 2. 2 = personil
                    // 3. 3 = bujp
                    // 4. 4 = mitrabisnis
                    // 5. 5 = regulator
                    // 6. 6 = organisasi
                    $this->m_utils->send_notif('Info regulasi baru - '.$title, $desc, '0', $user_id, '0');
					if($this->upload->do_upload('attachment'))
					{
						// $this->upload->do_upload('cover');
						$uploadData = $this->upload->data();
                        $attachment = $uploadData['file_name'];
                        $sql = 'insert into t_regulation (user_id, title, description, attachment, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'","'.$attachment.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        $query = $this->db->query($sql);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'regulation created.'));
					}
					else
					{
                        $attachment = "default.png";
                        $sql = 'insert into t_regulation (user_id, title, description, attachment, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'","'.$attachment.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        $query = $this->db->query($sql);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'regulation created.'));
					}
				}
			}
		}
    }
    
    public function updateRegulation() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$regulation_id = $this->input->post('regulation_id');
					$user_id = $this->input->post('user_id');
					$title = $this->input->post('title');
					$desc = $this->input->post('description');
					$attachment = $this->input->post('attachment');
                    
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/regulation/';
					$config['allowed_types'] = 'pdf';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'regulation_attachment_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					if($this->upload->do_upload('attachment'))
					{
						// $this->upload->do_upload('cover');
						$uploadData = $this->upload->data();
                        $attachment = $uploadData['file_name'];
                        $sql = 'update t_regulation set user_id='.$user_id.', title="'.$title.'", description="'.$desc.'", attachment="'.$attachment.'", created_date="'.$created_date.'", created_by='.$created_by.', modified_date="'.$modified_date.'", modified_by='.$modified_by.', status='.$status.' where regulation_id='.$regulation_id.'';
                        $query = $this->db->query($sql);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'regulation updated'));
					}
					else
					{
                        $sql = 'update t_regulation set user_id='.$user_id.', title="'.$title.'", description="'.$desc.'", created_date="'.$created_date.'", created_by='.$created_by.', modified_date="'.$modified_date.'", modified_by='.$modified_by.', status='.$status.' where regulation_id='.$regulation_id.'';
                        $query = $this->db->query($sql);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'regulation updated'));
					}
				}
			}
		}
    }
    
    public function deleteRegulation() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
                    $regulation_id = $this->input->post('regulation_id');
                    $user_id = $this->input->post('user_id');
					$resp = $this->m->deleteRegulation($regulation_id, $user_id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}
}
