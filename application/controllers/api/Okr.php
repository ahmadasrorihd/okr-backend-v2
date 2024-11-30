<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Okr extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Okr', 'm');
        $this->load->model('M_Utils', 'm_utils');
    }

    public function removeOkrAssignment()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $userId = $this->input->post('user_id');
                    $groupId = $this->input->post('okr_result_id');
                    $sql = 'delete from t_activity_result where okr_result_id=' . $groupId . ' and user_id=' . $userId . '';
                    $query = $this->db->query($sql);

                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Assignment removed'));
                }
            }
        }
    }

    public function getOkrProgress($okrResultId, $userId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_okr_progress($okrResultId, $userId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getOkr($id, $type)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_okr($id, $type);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getDashboardOkr($companyId, $type)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_dashboard($companyId, $type);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getObjective($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_objective($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getKeyResult($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_key_result($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getKpi($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_kpi($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getOkrByGroupId($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_all_okr_by_group($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getLeaderBoardByGroupId()
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
                    $groupId = $this->input->post('group_id');
                    $resp = $this->m->get_leaderboard_by_group($groupId, $startDate, $endDate);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getOkrByUserId()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $type = $this->input->post('type');
                    $startDate = $this->input->post('start_date');
                    $endDate = $this->input->post('end_date');
                    $userId = $this->input->post('user_id');
                    $resp = $this->m->get_all_okr_by_user_id($type, $userId, $startDate, $endDate);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getOkrAssignee($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_okr_assignee($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function create_activity()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $okr_result_id = $this->input->post('okr_result_id');
                    $progress = $this->input->post('progress');
                    $user_id = $this->input->post('user_id');
                    $presence_id = $this->input->post('presence_id');
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $sql = 'insert into t_activity_result (okr_result_id, progress, user_id, presence_id, created_date, created_by, modified_date, modified_by) values ("' . $okr_result_id . '", "' . $progress . '", "' . $user_id . '", "' . $presence_id . '", "' . $created_date . '", ' . $created_by . ', "' . $modified_date . '", ' . $modified_by . ')';
                    $query = $this->db->query($sql);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'activity created.'));
                }
            }
        }
    }

    public function create_objective()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $isEdit = $this->input->post('isEdit');
                    $id = $this->input->post('id');
                    $title = $this->input->post('title');
                    $description = $this->input->post('description');
                    $start_date = $this->input->post('start_date');
                    $end_date = $this->input->post('end_date');
                    $company_id = $this->input->post('company_id');
                    $type = $this->input->post('type');
                    $user_id = $this->input->post('user_id');
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    if ($isEdit == "true") {
                        $sql = 'update t_objective set title="' . $title . '", description="' . $description . '", start_date="' . $start_date . '", end_date="' . $end_date . '", company_id="' . $company_id . '", modified_date="' . $modified_date . '", modified_by="' . $modified_by . '" where id="' . $id . '"';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'objective updated.'));
                    } else {
                        $sql = 'insert into t_objective (title, description, start_date, end_date, company_id, created_date, created_by, modified_date, modified_by, type) values ("' . $title . '", "' . $description . '", "' . $start_date . '", "' . $end_date . '", "' . $company_id . '", "' . $created_date . '", "' . $created_by . '", "' . $modified_date . '", "' . $modified_by . '", "' . $type . '")';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'objective created.'));
                    }
                }
            }
        }
    }

    public function assign_okr()
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
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    foreach ($data as $user) {
                        $okr_result_id = $user['okr_result_id'];
                        $user_id = $user['user_id'];
                        $created_by = $user['created_by'];
                        $group_id = $user['group_id'];
                        $company_id = $user['company_id'];
                        $where = '(user_id=' . $user_id . ' and okr_result_id = ' . $okr_result_id . ')';
                        $q  = $this->db->select('id')->from('t_activity_result')->where($where)->get()->row();
                        if ($q == "") {
                            $sql = 'insert into t_activity_result (okr_result_id, progress, total_point, user_id, group_id, company_id, created_by, created_date, modified_by, modified_date) values ("' . $okr_result_id . '", "0", "0", "' . $user_id . '", "' . $group_id . '", "' . $company_id . '", "' . $created_by . '", "' . $created_date . '", "' . $created_by . '", "' . $modified_date . '")';
                            $query = $this->db->query($sql);
                        }
                    }
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'member added'));
                }
            }
        }
    }

    public function delete_okr()
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
                    $sql = 'delete from t_okr where id=' . $id . '';
                    $query = $this->db->query($sql);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'data deleted'));
                }
            }
        }
    }

    public function create_okr()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $title = $this->input->post('nama');
                    $description = $this->input->post('description');
                    $start_date = $this->input->post('start_date_okr');
                    $end_date = $this->input->post('end_date');
                    $objective_type = $this->input->post('objective_type');
                    $okr_type = $this->input->post('okr_type');
                    $company_id = $this->input->post('company_id');
                    $objective_id = $this->input->post('objectiveId');
                    $alert_achievement = $this->input->post('alertAchievement');
                    $pointTarget = $this->input->post('pointTarget');
                    $pointScale = $this->input->post('pointScale');
                    $surveyUrl = $this->input->post('surveyUrl');
                    $gSheetUrl = $this->input->post('gSheetUrl');
                    $user_id = $this->input->post('user_id');
                    $id = $this->input->post('id');
                    $isEdit = $this->input->post('isEdit');
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    if ($isEdit == "true") {
                        $sql = 'update t_okr set title="' . $title . '", description="' . $description . '", target_point="' . $pointTarget . '", skala_point="' . $pointScale . '", survey_url="' . $surveyUrl . '", sheet_url="' . $gSheetUrl . '", start_date="' . $start_date . '", end_date="' . $end_date . '", company_id="' . $company_id . '", created_by="' . $created_by . '", modified_date="' . $modified_date . '", modified_by="' . $modified_by . '" where id="' . $id . '"';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'objective updated.'));
                    } else {
                        $sql = 'insert into t_okr (title, description, start_date, end_date, objective_type, okr_type, company_id, created_date, created_by, modified_date, modified_by, objective_id, alert_achievement, target_point, skala_point, survey_url, sheet_url) values ("' . $title . '", "' . $description . '", "' . $start_date . '", "' . $end_date . '", "' . $objective_type . '", "' . $okr_type . '", ' . $company_id . ', "' . $created_date . '", "' . $created_by . '", "' . $modified_date . '", "' . $modified_by . '", ' . $objective_id . ', ' . $alert_achievement . ', ' . $pointTarget . ', ' . $pointScale . ', "' . $surveyUrl . '", "' . $gSheetUrl . '")';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => '' . $okr_type . ' created.'));
                    }
                }
            }
        }
    }

    public function create_key_result()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $title = $this->input->post('title');
                    $description = $this->input->post('description');
                    $start_date = $this->input->post('start_date');
                    $end_date = $this->input->post('end_date');
                    $company_id = $this->input->post('company_id');
                    $objective_id = $this->input->post('objective_id');
                    $alert_achievement = $this->input->post('alert_achievement');
                    $user_id = $this->input->post('user_id');
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;

                    $sql = 'insert into t_key_result (title, description, start_date, end_date, company_id, created_date, created_by, modified_date, modified_by, objective_id, alert_achievement) values ("' . $title . '", "' . $description . '", "' . $start_date . '", "' . $end_date . '", "' . $company_id . '", "' . $created_date . '", "' . $created_by . '", "' . $modified_date . '", "' . $modified_by . '", "' . $objective_id . '", "' . $alert_achievement . '")';
                    $query = $this->db->query($sql);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'key result created.'));
                }
            }
        }
    }

    public function create_kpi()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $name = $this->input->post('name');
                    $description = $this->input->post('description');
                    $start_date = $this->input->post('start_date');
                    $end_date = $this->input->post('end_date');
                    $company_id = $this->input->post('company_id');
                    $objective_id = $this->input->post('objective_id');
                    $user_id = $this->input->post('user_id');
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;

                    $sql = 'insert into t_kpi (name, description, start_date, end_date, company_id, created_date, created_by, modified_date, modified_by, objective_id) values ("' . $name . '", "' . $description . '", "' . $start_date . '", "' . $end_date . '", "' . $company_id . '", "' . $created_date . '", "' . $created_by . '", "' . $modified_date . '", "' . $modified_by . '", "' . $objective_id . '")';
                    $query = $this->db->query($sql);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'kpi created.'));
                }
            }
        }
    }

    public function update_progress()
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
                    $progress = $this->input->post('progress');
                    $sql_update = 'update t_activity_result set progress=' . $progress . '  where id=' . $id . '';
                    $exe_update = $this->db->query($sql_update);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'progress updated.'));
                }
            }
        }
    }
}
