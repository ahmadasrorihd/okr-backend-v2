<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Common','m');
		$this->load->model('M_Utils', 'm_utils');
	}
	
	public function get_common_header()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$resp = $this->m->get_common_header();
					$this->m_utils->json_output($respStatus,$resp);
				}
			}
		}
	}
	
		public function get_common_detail($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$resp = $this->m->get_common_detail($id);
					$this->m_utils->json_output($respStatus,$resp);
				}
			}
		}
    }
    
    public function get_level() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_level();
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}

	public function get_provinsi() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_provinsi();
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}

	public function get_kota($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_kota($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}

	public function get_personil_classification($id) {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m->get_personil_classification($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}
}