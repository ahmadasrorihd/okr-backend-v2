<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Dashboard', 'm');
        $this->load->model('M_Utils', 'm_utils');
    }

    public function getDashboard($groupId, $companyId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->getDashboard($groupId, $companyId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function deleteDashboard()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $id = $this->input->post('id');
                    $sql = 'delete from t_dashboard where id=' . $id . '';
                    $query = $this->db->query($sql);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'data deleted'));
                }
            }
        }
    }

    public function createDashboard()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $id = $this->input->post('id');
                    $title = $this->input->post('title');
                    $description = $this->input->post('description');
                    $url = $this->input->post('url');
                    $company_id = $this->input->post('company_id');
                    $group_id = $this->input->post('group_id');
                    $user_id = $this->input->post('user_id');
                    $isEdit = $this->input->post('isEdit');
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    if ($isEdit == "true") {
                        $sql = 'update t_dashboard set title="' . $title . '", description="' . $description . '", url="' . $url . '", group_id="' . $group_id . '", company_id="' . $company_id . '", created_by="' . $created_by . '", modified_date="' . $modified_date . '", modified_by="' . $modified_by . '" where id="' . $id . '"';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'data updated.'));
                    } else {
                        $sql = 'insert into t_dashboard (title, description, url, group_id, company_id, created_date, created_by, modified_date, modified_by) values ("' . $title . '", "' . $description . '", "' . $url . '", "' . $group_id . '", ' . $company_id . ', "' . $created_date . '", "' . $created_by . '", "' . $modified_date . '", "' . $modified_by . '")';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'data created.'));
                    }
                }
            }
        }
    }
}
