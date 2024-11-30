<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Main', 'm');
        $this->load->model('M_Utils', 'm_utils');
    }

    public function getAllUser()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->getAllUser();
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getAllReport()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $startDate = $this->input->post('start_date');
                    $endDate = $this->input->post('end_date');
                    $resp = $this->m->getAllReport($startDate, $endDate);
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
                    $resp = $this->m->getMyReport($user_id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getMyNotif($user_id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->getMyNotif($user_id);
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
                    $jenis = $this->input->post('jenis');
                    $teknisiId = $this->input->post('teknisi_id');
                    $description = $this->input->post('description');
                    $user_id = $this->input->post('user_id');
                    $status = $this->input->post('status');
                    $note = $this->input->post('note');
                    $estimationDate = $this->input->post('estimation_date');
                    $isEdit = $this->input->post('isEdit');
                    if ($isEdit == "true") {
                        $this->m_utils->send_notif('Work order baru #' . $id, $description, $teknisiId, $user_id, '0');
                        $sql = 'update t_report set teknisi_id="' . $teknisiId . '", status="' . $status . '", note="' . $note . '", estimate_date="' . $estimationDate . '" where id="' . $id . '"';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Report updated'));
                    } else {
                        $this->m_utils->send_notif('Komplain baru', $description, '3', $user_id, '0');
                        $created_at = date("Y-m-d H:i:s");
                        $date = date("Y-m-d");
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
                            $sql = 'insert into t_report (id, jenis_laporan, description, evidence, user_id, created_at, date, status) values ("' . $id . '", "' . $jenis . '", "' . $description . '", "' . $evidence . '", "' . $user_id . '", "' . $created_at . '", "' . $date . '", "' . $status . '")';
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

    public function createRepair()
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
                    $reportId = $this->input->post('report_id');
                    $user_id = $this->input->post('user_id');
                    $senderId = $this->input->post('sender_id');
                    $description = $this->input->post('description');
                    $isEdit = $this->input->post('isEdit');
                    $created_at = date("Y-m-d H:i:s");
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/content/';
                    $config['allowed_types'] = 'jpg|jpeg|png|';
                    $config['max_size']      = '0';
                    $config['max_height'] = '3648';
                    $config['max_width'] = '6724';
                    $config['file_name'] = 'image_repair_' . $user_id . '_' . $image_date;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $sqlUpdate = 'update t_report set status="done" where id="' . $reportId . '"';
                    $this->m_utils->send_notif('No Tiket #' . $reportId . ' telah selesai', $description, $senderId, $user_id, '0');
                    $queryUpdate = $this->db->query($sqlUpdate);
                    if ($isEdit == "true") {
                        if ($this->upload->do_upload('evidence')) {
                            $uploadData = $this->upload->data();
                            $evidence = $uploadData['file_name'];
                            $sql = 'update t_repair set description="' . $description . '", evidence="' . $evidence . '" where id="' . $id . '"';
                            $query = $this->db->query($sql);
                            return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Repair updated'));
                        }
                    } else {
                        if ($this->upload->do_upload('evidence')) {
                            $uploadData = $this->upload->data();
                            $evidence = $uploadData['file_name'];
                            $sql = 'insert into t_repair (report_id, user_id, description, evidence, created_date) values ("' . $reportId . '", "' . $user_id . '", "' . $description . '", "' . $evidence . '", "' . $created_at . '")';
                            $query = $this->db->query($sql);
                            return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Repair created'));
                        }
                    }
                }
            }
        }
    }

    public function getRepair($reportId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->getRepair($reportId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }
}
