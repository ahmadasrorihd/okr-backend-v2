<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presence extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Presence', 'm');
        $this->load->model('M_Utils', 'm_utils');
    }

    public function getPresenceDataByOkrId($id, $userId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_presence_data_by_okr_id($id, $userId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getPresenceData()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $groupId = $this->input->post('group_id');
                    $user_id = $this->input->post('user_id');
                    $start_date = $this->input->post('start_date');
                    $end_date = $this->input->post('end_date');
                    $resp = $this->m->get_presence_data($user_id, $start_date, $end_date, $groupId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getPresentLocation()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $company_id = $this->input->post('group_id');
                    $current_date = $this->input->post('current_date');
                    $resp = $this->m->get_present_location($company_id, $current_date);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getPresenceDataForSPV($groupId, $userId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_presence_data_for_spv($groupId, $userId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getActivityDetail($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_activity_detail($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getStatusPresence($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_status_presence($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function create_presence()
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
                    $okr_result_id = $this->input->post('okr_result_id');
                    $progress = $this->input->post('progressGetResult');
                    $value = $this->input->post('valueGetResult');
                    $presenceType = $this->input->post('presenceType');
                    $skalaPoint = $this->input->post('skalaPointGetResult');
                    $user_id = $this->input->post('user_id');
                    $group_id = $this->input->post('group_id');
                    $clock_in = $this->input->post('clock_in');
                    $clock_out = $this->input->post('clockOutGetResult');
                    $date = $this->input->post('created_date');
                    $title = $this->input->post('title');
                    $description = $this->input->post('description');
                    $status = $this->input->post('status');
                    $location_clock_in = $this->input->post('location_clock_in');
                    $location_clock_out = $this->input->post('location_clock_out');
                    $customer_id = $this->input->post('customerIdGET');

                    if ($status == "in") {
                        $sql = 'insert into t_presence (id, user_id, group_id, clock_in, created_date, status, location_clock_in, presence_type) values (' . $id . ', ' . $user_id . ', ' . $group_id . ', "' . $clock_in . '","' . $date . '", "' . $status . '", "' . $location_clock_in . '", "' . $presenceType . '")';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Clock In Success'));
                    } else {
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
                                $sql = 'update t_presence set clock_out="' . $clock_out . '", status="out", title="' . $title . '", description="' . $description . '", location_clock_out="' . $location_clock_out . '", okr_result_id=' . $okr_result_id . ', progress=' . $progress . ', value=' . $value . ', point=' . $skalaPoint . ', customer_id=' . $customer_id . ', evidence="' . $content . '"  where id=' . $id . '';
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
                                $sql = 'update t_presence set clock_out="' . $clock_out . '", status="out", title="' . $title . '", description="' . $description . '", location_clock_out="' . $location_clock_out . '", okr_result_id=' . $okr_result_id . ', progress=' . $progress . ', value=' . $value . ', point=' . $skalaPoint . ', customer_id=' . $customer_id . ', evidence="' . $content . '" where id=' . $id . '';
                                $query = $this->db->query($sql);
                                return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Clock Out Success'));
                            }
                        }
                    }
                }
            }
        }
    }

    public function approveAll()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    $current_date = date("Y-m-d H:i:s");
                    foreach ($data as $user) {
                        $modified_by = $user['modified_by'];
                        $id = $user['id'];
                        $user_id = $user['user_id'];
                        $approval = $user['approval'];

                        $where = '(id="' . $id . '")';
                        $q  = $this->db->select('*')->from('t_presence')->where($where)->get()->row();
                        if ($q == "") {
                        } else {
                            $id  = $q->id;
                            $okr_result_id  = $q->okr_result_id;
                            $progress_added  = $q->progress;
                            $point_added  = $q->point;
                            $user_id  = $q->user_id;

                            // update approval status
                            $sql_presence = 'update t_presence set approval="' . $approval . '" where id=' . $id . '';
                            $query_presence = $this->db->query($sql_presence);

                            // get current progress from table
                            $where_okr = '(user_id="' . $user_id . '" and okr_result_id="' . $okr_result_id . '")';
                            $sql_get_progress  = $this->db->select('*')->from('t_activity_result')->where($where_okr)->get()->row();
                            $progress_get = $sql_get_progress->progress;
                            $total_point_get = $sql_get_progress->total_point;
                            $progress_total = $progress_get + $progress_added;
                            $point_total = $total_point_get + $point_added;

                            // update progress
                            $sql_update_okr = 'update t_activity_result set progress=' . $progress_total . ', total_point=' . $point_total . ', modified_date="' . $current_date . '", modified_by=' . $modified_by . ' where user_id=' . $user_id . ' and okr_result_id=' . $okr_result_id . '';
                            $query_update_okr = $this->db->query($sql_update_okr);
                        }
                    }
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'approve success'));
                }
            }
        }
    }

    public function approval_presence()
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
                    $approval = $this->input->post('approval');
                    $note = $this->input->post('note');
                    $current_date = date("Y-m-d H:i:s");
                    if ($approval == "approved") {
                        $where = '(id="' . $id . '")';
                        $q  = $this->db->select('*')->from('t_presence')->where($where)->get()->row();
                        if ($q == "") {
                            return array('status' => 404, 'message' => 'data tidak ditemukan.');
                        } else {
                            $id  = $q->id;
                            $okr_result_id  = $q->okr_result_id;
                            $progress_added  = $q->progress;
                            $point_added  = $q->point;
                            $user_id  = $q->user_id;

                            // update approval status
                            $sql_presence = 'update t_presence set approval="approved", note="' . $note . '" where id=' . $id . '';
                            $query_presence = $this->db->query($sql_presence);

                            // get current progress from table
                            $where_okr = '(user_id="' . $user_id . '" and okr_result_id="' . $okr_result_id . '")';
                            $sql_get_progress  = $this->db->select('*')->from('t_activity_result')->where($where_okr)->get()->row();
                            $progress_get = $sql_get_progress->progress;
                            $total_point_get = $sql_get_progress->total_point;
                            $progress_total = $progress_get + $progress_added;
                            $point_total = $total_point_get + $point_added;

                            // update progress
                            $sql_update_okr = 'update t_activity_result set progress=' . $progress_total . ', total_point=' . $point_total . ', modified_date="' . $current_date . '", modified_by=' . $user_id . ' where user_id=' . $user_id . ' and okr_result_id=' . $okr_result_id . '';
                            $query_update_okr = $this->db->query($sql_update_okr);
                            return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'presence approved.'));
                        }
                    } else {
                        // update approval status
                        $sql_presence = 'update t_presence set approval="rejected", note="' . $note . '" where id=' . $id . '';
                        $query_presence = $this->db->query($sql_presence);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'presence rejected.'));
                    }
                }
            }
        }
    }

    public function presenceApproval()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $current_date = date("Y-m-d H:i:s");
                    $id = $this->input->post('id');
                    $approval = $this->input->post('approval');
                    $note = $this->input->post('note');
                    $sql_update = 'update t_presence set approval="' . $approval . '", note="' . $note . '"  where id=' . $id . '';
                    $exe_update = $this->db->query($sql_update);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'presence updated'));
                }
            }
        }
    }
}
