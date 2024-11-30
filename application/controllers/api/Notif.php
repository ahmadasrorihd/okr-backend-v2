<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notif extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Utils', 'm');
	}

	public function get_notif($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_notif($id);
					$this->m->json_output($response['status'],$resp);
				}
			}
		}
	}
	
	public function update_notif()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m->auth();
				if($response['status'] == 200){
                    $notif_id = $this->input->post('notif_id');
                    $resp = $this->m->update_notif($notif_id);
					$this->m->json_output($response['status'],$resp);
				}
			}
		}
	}

	public function delete_notif()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m->auth();
				if($response['status'] == 200){
                    $notif_id = $this->input->post('notif_id');
                    $resp = $this->m->delete_notif($notif_id);
					$this->m->json_output($response['status'],$resp);
				}
			}
		}
    }
	
	public function send_notif()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m->auth();
				if($response['status'] == 200){
                    $title = $this->input->post('title');
                    $description = $this->input->post('description');
                    $user_id_target = $this->input->post('user_id_target');
                    $user_id_pengirim = $this->input->post('user_id_pengirim');
                    $type = 'all';
                    $resp = $this->m->send_notif($title, $description, $user_id_target, $user_id_pengirim, $type);
					$this->m->json_output($response['status'],$resp);
				}
			}
		}
	}
	
	public function send_email()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m->auth();
				if($response['status'] == 200){
                    $email_to = $this->input->post('email_to');
                    $subject = $this->input->post('subject');
                    $message = $this->input->post('message');
                    $resp = $this->m->send_email($email_to, $subject, $message);
					$this->m->json_output($response['status'],$resp);
				}
			}
		}
	}

}
