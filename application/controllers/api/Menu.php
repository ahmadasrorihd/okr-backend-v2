<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Auth','m_auth');
		$this->load->model('M_Menu','m_menu');
		$this->load->model('M_Utils', 'm_utils');
	}

	public function get_menu($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_menu->get_menu($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}
}
