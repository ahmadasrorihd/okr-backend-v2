<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('v2/M_Group', 'm');
        $this->load->model('M_Utils', 'm_utils');
    }

    public function getAllGroupByCompanyId($companyId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->getAllGroupByCompanyId($companyId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function createGroup()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    
                    $company_id = $this->input->post('company_id');
                    $name = $this->input->post('name');
                    $type = $this->input->post('type');
                    $description = $this->input->post('description');
                    $user_id = $this->input->post('user_id');
                    $current_date = date("Y-m-d H:i:s");

                    $sql = 'insert into t_group (company_id, name, type, description, created_date, created_by, modified_date, modified_by) values ("' . $company_id . '", "' . $name . '", "' . $type . '", "' . $description . '", "' . $current_date . '", "' . $user_id . '", "' . $current_date . '", ' . $user_id . ')';
                    $query = $this->db->query($sql);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'group created.'));
                }
            }
        }
    }
}
