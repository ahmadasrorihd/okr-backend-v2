<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tender extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('M_Tender','m');
		$this->load->model('M_Utils', 'm_utils');
	}
	
	public function getAllTender() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getAllTender();
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getAllTenderByUserId($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getAllTenderByUserId($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getActivityTender($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getActivityTender($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getDetailTender($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getDetailTender($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function getTenderParticipant($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getTenderParticipant($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function createTender() {
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
					$description = $this->input->post('description');
					$pagu = $this->input->post('pagu');
					$batas_pendaftaran = $this->input->post('batas_pendaftaran');
					$provinsi = $this->input->post('provinsi');
                    $kota = $this->input->post('kota');
                    $persyaratan = $this->input->post('persyaratan');
                    // daftar topic
                    // 1. 0 = all
                    // 2. 2 = personil
                    // 3. 3 = bujp
                    // 4. 4 = mitrabisnis
                    // 5. 5 = regulator
                    // 6. 6 = organisasi
                    $this->m_utils->send_notif('Info tender baru - '.$title, $description, '0', $user_id, '3');
					$resp = $this->m->createTender($user_id, $title, $description, $pagu, $batas_pendaftaran, $provinsi, $kota, $persyaratan);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function updateTender() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$tender_id = $this->input->post('tender_id');
					$user_id = $this->input->post('user_id');
					$title = $this->input->post('title');
					$description = $this->input->post('description');
					$pagu = $this->input->post('pagu');
					$batas_pendaftaran = $this->input->post('batas_pendaftaran');
					$provinsi = $this->input->post('provinsi');
					$kota = $this->input->post('kota'); 
					$persyaratan = $this->input->post('persyaratan');
					$resp = $this->m->updateTender($tender_id, $user_id, $title, $description, $pagu, $batas_pendaftaran, $provinsi, $kota, $persyaratan);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function update_job() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$job_id = $this->input->post('job_id');
					$user_id = $this->input->post('user_id');
					$title = $this->input->post('title');
					$desc = $this->input->post('desc');
					$image = $this->input->post('image');
					$job_open_date = $this->input->post('job_open_date');
					$job_close_date = $this->input->post('job_close_date');
					$range_salary = $this->input->post('range_salary');
					$responsibility = $this->input->post('responsibility');
					$benefit = $this->input->post('benefit');
                    $requirement = $this->input->post('requirement');
                    
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/image/job/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_job_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    // 0 = untuk notif global
                    $this->m_utils->send_notif('Info tender baru - '.$title, $desc, '0', $user_id, 'all');
                    if($this->upload->do_upload('image'))
					{
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                        $sql_update = 'update t_job set status=0 where job_id='.$job_id.'';
                        $exe_update = $this->db->query($sql_update);
                        $sql = 'insert into t_job (owner_id, title, description, image, job_open_date, job_close_date, range_salary, responsibility, benefit, requirement, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'","'.$picture.'", "'.$job_open_date.'", "'.$job_close_date.'", "'.$range_salary.'", "'.$responsibility.'", "'.$benefit.'", "'.$requirement.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'job updated.'));
					}
					else
					{
                        $picture = "default.png";
                        $sql_update = 'update t_job set status=0 where job_id='.$job_id.'';
                        $exe_update = $this->db->query($sql_update);
                        $sql = 'insert into t_job (owner_id, title, description, image, job_open_date, job_close_date, range_salary, responsibility, benefit, requirement, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'","'.$picture.'", "'.$job_open_date.'", "'.$job_close_date.'", "'.$range_salary.'", "'.$responsibility.'", "'.$benefit.'", "'.$requirement.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'job updated.'));
					}
				}
			}
		}
    }
    
    public function deleteTender() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
                    $tender_id = $this->input->post('tender_id');
                    $user_id = $this->input->post('user_id');
					$resp = $this->m->deleteTender($tender_id, $user_id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function postParticipantTender() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
                    $user_id = $this->input->post('user_id');
                    $tender_id = $this->input->post('tender_id');
                    $response = $this->m->postParticipantTender($user_id,$tender_id);
					$this->m_utils->json_output($response['status'],$response);
				}
			}
		}
    }
}
