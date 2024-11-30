<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Auth','m_auth');
        $this->load->model('M_Role','m_role');
		$this->load->model('M_Utils', 'm_utils');
	}
    
    public function get_role()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
					$response = $this->m_role->get_user_role();
					$this->m_utils->json_output($response['status'],$response);
			}
		}
	}
}
