<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Report', 'm');
        $this->load->model('M_Utils', 'm_utils');
    }

    public function getAllReport()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->getAllReport();
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getMyReport($user_id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->getAllReport($user_id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function createReport()
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
                    $description = $this->input->post('description');
                    $user_id = $this->input->post('user_id');
                    $status = $this->input->post('status');
                    $note = $this->input->post('note');
                    $estimationDate = $this->input->post('estimation_date');
                    $isEdit = $this->input->post('isEdit');
                    if ($isEdit == "true") {
                        $sql = 'update t_report set note="' . $note . '", estimate_date="' . $estimationDate . '" where id="' . $id . '"';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Report updated'));
                    } else {
                        $created_at = date("Y-m-d H:i:s");
                        $image_date = date("YmdHis");
                        $config['upload_path'] = 'file/content/';
                        $config['allowed_types'] = 'jpg|jpeg|png|';
                        $config['max_size']      = '0';
                        $config['max_height'] = '3648';
                        $config['max_width'] = '6724';
                        $config['file_name'] = 'image_report_' . $user_id . '_' . $image_date;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('evidence')) {
                            $uploadData = $this->upload->data();
                            $evidence = $uploadData['file_name'];
                            $sql = 'insert into t_report (id, description, evidence, user_id, created_at, status) values ("' . $id . '", "' . $description . '", "' . $evidence . '", "' . $user_id . '", "' . $created_at . '", "' . $status . '")';
                            $query = $this->db->query($sql);
                            return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Report created'));
                        }
                    }
                }
            }
        }
    }

    public function deleteReport()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $job_id = $this->input->post('job_id');
                    $user_id = $this->input->post('user_id');
                    $resp = $this->m_job->delete_job($job_id, $user_id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }
}
