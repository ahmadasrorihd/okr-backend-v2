<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qna extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Qna','m');
		$this->load->model('M_Utils', 'm_utils');
	}
	
	public function create_qna()
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
					$target_id = $this->input->post('target_id');
					$title = $this->input->post('title');
                    $description = $this->input->post('description');
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/qna_attachment/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'qna_attachment'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

					if($this->upload->do_upload('attachment'))
					{
						$uploadData = $this->upload->data();
						$attachment = $uploadData['file_name'];
                        $sql_create = 'insert into t_qna (user_id, target_id, title, description, attachment, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$target_id.'", "'.$title.'", "'.$description.'", "'.$attachment.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data created.'));
					}
					else
					{
						$attachment = "";
                        $sql_create = 'insert into t_qna (user_id, target_id, title, description, attachment, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$target_id.'", "'.$title.'", "'.$description.'", "'.$attachment.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data created.'));
					}
				}
			}
		}
	}

	public function get_qna($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
                    $resp = $this->m->get_qna($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}

	public function reply_qna()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
                    $qna_id = $this->input->post('qna_id');
                    $user_id = $this->input->post('user_id');
                    $reply_text = $this->input->post('reply_text');
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/qna_attachment/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'qna_attachment'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

					if($this->upload->do_upload('attachment'))
					{
						$uploadData = $this->upload->data();
						$attachment = $uploadData['file_name'];
                        $sql_create = 'insert into t_qna_reply (qna_id, user_id, reply_text, attachment, created_date, created_by, modified_date, modified_by, status) values ("'.$qna_id.'", "'.$user_id.'", "'.$reply_text.'", "'.$attachment.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data created.'));
					}
					else
					{
						$attachment = "";
                        $sql_create = 'insert into t_qna_reply (qna_id, user_id, reply_text, attachment, created_date, created_by, modified_date, modified_by, status) values ("'.$qna_id.'", "'.$user_id.'", "'.$reply_text.'", "'.$attachment.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data created.'));
					}
				}
			}
		}
	}

	public function get_reply_qna($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_reply_qna($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function delete_qna($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'DELETE'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->delete_qna($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function delete_qna_reply($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'DELETE'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->delete_qna_reply($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}
}
