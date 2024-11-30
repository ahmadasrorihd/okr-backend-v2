<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activity extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('v2/M_Activity', 'm');
        $this->load->model('M_Utils', 'm_utils');
    }

    public function getAllActivityByUserId($userId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->getAllActivityByUserId($userId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getActivityStatusByUserId($userId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->getActivityStatusByUserId($userId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function clockIn()
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
                    $user_id = $this->input->post('user_id');
                    $clock_in = $this->input->post('clock_in');
                    $created_date = $this->input->post('created_date');
                    $status = $this->input->post('status');
                    $location_clock_in = $this->input->post('location_clock_in');
                    $current_date = date("Y-m-d H:i:s");


                    $sql = 'insert into t_presence (id, user_id, clock_in, created_date, status, location_clock_in, created_by, modified_date, modified_by) values (' . $id . ', ' . $user_id . ', "' . $clock_in . '","' . $created_date . '", "' . $status . '", "' . $location_clock_in . '", "' . $user_id . '", "' . $current_date . '", "' . $user_id . '")';
                    $query = $this->db->query($sql);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Clock In Success'));
                }
            }
        }
    }

    public function clockOut()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $user_id = $this->input->post('user_id');
                    $clock_out = $this->input->post('clock_out');
                    $activity = $this->input->post('activity');
                    $location_clock_out = $this->input->post('location_clock_out');

                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/image/evidence/';
                    $config['allowed_types'] = 'avi|wmv|flv|mp4|jpg|png';
                    $config['max_size'] = '0';
                    $config['max_height'] = '0';
                    $config['max_width'] = '0';
                    $config['file_name'] = 'img_evidence_' . $user_id . '_' . $image_date;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('evidence')) {
                        $uploadData = $this->upload->data();
                        $content = $uploadData['file_name'];
                        $where = '(user_id="' . $user_id . '" and status = "in")';
                        $q  = $this->db->select('*')->from('t_presence')->where($where)->get()->row();
                        if ($q == "") {
                            return array('status' => 404, 'message' => 'data tidak ditemukan.');
                        } else {
                            $id  = $q->id;
                            $sql = 'update t_presence set clock_out="' . $clock_out . '", status="out", activity="' . $activity . '", location_clock_out="' . $location_clock_out . '", evidence="' . $content . '"  where id=' . $id . '';
                            $query = $this->db->query($sql);
                            return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Clock Out Success'));
                        }
                    } else {
                        $content = "default.png";
                        $where = '(user_id="' . $user_id . '" and status = "in")';
                        $q  = $this->db->select('*')->from('t_presence')->where($where)->get()->row();
                        if ($q == "") {
                            return array('status' => 404, 'message' => 'data tidak ditemukan.');
                        } else {
                            $id  = $q->id;
                            $sql = 'update t_presence set clock_out="' . $clock_out . '", status="out", activity="' . $activity . '", location_clock_out="' . $location_clock_out . '", evidence="' . $content . '" where id=' . $id . '';
                            $query = $this->db->query($sql);
                            return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Clock Out Success'));
                        }
                    }
                }
            }
        }
    }
}
