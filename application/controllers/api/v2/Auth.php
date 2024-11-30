<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('v2/M_Auth');
        $this->load->model('M_Utils');
    }

    public function login()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->M_Utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->M_Utils->check_auth_client();
            if ($check_auth_client == true) {
                $check_no_auth = $this->M_Utils->check_no_auth();
                if ($check_no_auth == true) {
                    $email = $this->input->post('email');
                    $password = $this->input->post('password');
                    $device_name = $this->input->post('device_name');
                    $device_version = $this->input->post('device_version');
                    $firebase_token = $this->input->post('firebase_token');
                    $response = $this->M_Auth->login($email, $password, $device_name, $device_version, $firebase_token);
                    $this->M_Utils->json_output($response['status'], $response);
                }
            }
        }
    }
}
