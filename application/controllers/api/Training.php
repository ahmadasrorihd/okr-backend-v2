<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('M_Training','m');
		$this->load->model('M_Utils', 'm_utils');
	}
	
	public function get_all_training() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_all_training();
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getAllTrainingByUserId($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->getAllTrainingByUserId($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function get_training_detail($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_training_detail($id);
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
                    $job_id = $this->input->post('training_id');
                    $response = $this->m->post_participant($user_id,$job_id);
					$this->m_utils->json_output($response['status'],$response);
				}
			}
		}
    }
	
	public function create_training() {
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
					$syarat = $this->input->post('syarat');
					$materi = $this->input->post('materi');
					$fasilitas = $this->input->post('fasilitas');
					$image = $this->input->post('image');
					$date = $this->input->post('date');
					$location = $this->input->post('location');
					$kota = $this->input->post('kota');
					$provinsi = $this->input->post('provinsi');
                    
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/image/training/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_training_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    // daftar topic
                    // 1. 0 = all
                    // 2. 2 = personil
                    // 3. 3 = bujp
                    // 4. 4 = mitrabisnis
                    // 5. 5 = regulator
                    // 6. 6 = organisasi
                    $this->m_utils->send_notif('Info training baru - '.$title, $desc, '0', $user_id, '2');
					if($this->upload->do_upload('image'))
					{
						// $this->upload->do_upload('cover');
						$uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                        $sql = 'insert into t_training (owner_id, title, description, syarat, materi, fasilitas, image, date, location, kota_id, provinsi_id, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'", "'.$syarat.'", "'.$materi.'", "'.$fasilitas.'","'.$picture.'", "'.$date.'", "'.$location.'", "'.$kota.'", "'.$provinsi.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        $query = $this->db->query($sql);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'training created.'));
					}
					else
					{
                        $picture = "default.png";
                        $sql = 'insert into t_training (owner_id, title, description, syarat, materi, fasilitas, image, date, location, kota_id, provinsi_id, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'", "'.$syarat.'", "'.$materi.'", "'.$fasilitas.'","'.$picture.'", "'.$date.'", "'.$location.'", "'.$kota.'", "'.$provinsi.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        $query = $this->db->query($sql);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'training created.'));
					}
				}
			}
		}
    }
    
    public function update_training() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$training_id = $this->input->post('training_id');
					$user_id = $this->input->post('user_id');
					$title = $this->input->post('title');
					$desc = $this->input->post('desc');
					$image = $this->input->post('image');
					$date = $this->input->post('date');
					$location = $this->input->post('location');
					$kota = $this->input->post('kota');
					$provinsi = $this->input->post('provinsi');
                    $syarat = $this->input->post('syarat');
					$materi = $this->input->post('materi');
                    $fasilitas = $this->input->post('fasilitas');
                    
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/image/training/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_training_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('image'))
					{
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                        $sql_update = 'update t_training set owner_id="'.$user_id.'", title="'.$title.'", description="'.$desc.'", syarat="'.$syarat.'", materi="'.$materi.'", fasilitas="'.$fasilitas.'", image="'.$picture.'", date="'.$date.'", location="'.$location.'", kota_id="'.$kota.'", provinsi_id="'.$provinsi.'", modified_date="'.$modified_date.'", modified_by="'.$modified_by.'", status="'.$status.'"  where training_id='.$training_id.'';
                        $exe_update = $this->db->query($sql_update);

                        // $sql = 'insert into t_training (owner_id, title, description, syarat, materi, fasilitas, image, date, location, kota_id, provinsi_id, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'", "'.$syarat.'", "'.$materi.'", "'.$fasilitas.'","'.$picture.'", "'.$date.'", "'.$location.'", "'.$kota.'", "'.$provinsi.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        // $query = $this->db->query($sql);

						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'training updated.'));
					}
					else
					{
						// $sql_update = 'update t_training set status=0 where training_id='.$training_id.'';
                        // $exe_update = $this->db->query($sql_update);
                        // $sql = 'insert into t_training (owner_id, title, description, syarat, materi, fasilitas, image, date, location, kota_id, provinsi_id, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'", "'.$syarat.'", "'.$materi.'", "'.$fasilitas.'","'.$picture.'", "'.$date.'", "'.$location.'", "'.$kota.'", "'.$provinsi.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        // $query = $this->db->query($sql);
                        $sql_update = 'update t_training set owner_id="'.$user_id.'", title="'.$title.'", description="'.$desc.'", syarat="'.$syarat.'", materi="'.$materi.'", fasilitas="'.$fasilitas.'", date="'.$date.'", location="'.$location.'", kota_id="'.$kota.'", provinsi_id="'.$provinsi.'", modified_date="'.$modified_date.'", modified_by="'.$modified_by.'", status="'.$status.'"  where training_id='.$training_id.'';
                        $exe_update = $this->db->query($sql_update);
						return $this->m_utils->json_output(201,array('status' => 201,'message' => 'training updated.'));
					}
				}
			}
		}
    }
    
    public function delete_training() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
                    $training_id = $this->input->post('training_id');
                    $user_id = $this->input->post('user_id');
					$resp = $this->m->delete_training($training_id, $user_id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}
}
