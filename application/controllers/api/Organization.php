<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Organization extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Organization', 'm');
        $this->load->model('M_Utils', 'm_utils');
    }

    public function changePhoto()
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
                    $phone = $this->input->post('phone');
                    $base = $this->config->base_url() . '/ciapi_dev/file/image/user_profile/';
                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/image/user_profile/';
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    $config['max_size'] = '0';
                    $config['max_height'] = '0';
                    $config['max_width'] = '0';
                    $config['file_name'] = 'img_profile_' . $userId . '_' . $image_date;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('profile')) {
                        $uploadData = $this->upload->data();
                        $content = $uploadData['file_name'];
                        $sql = 'update t_user set photo="' . $content . '", phone="' . $phone . '"  where user_id=' . $userId . '';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(200, array('status' => 200, 'message' => 'Photo updated', 'photo' => $base . $content,  'phone' => $phone));
                    } else {
                        $sql = 'update t_user set phone="' . $phone . '"  where user_id=' . $userId . '';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(200, array('status' => 200, 'message' => 'phone updated', 'photo' => '-', 'phone' => $phone));
                    }
                }
            }
        }
    }

    public function checkIsLeaderGroup($groupId, $userId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->check_is_leader_group($groupId, $userId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getCompanyEmployee($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_company_employee($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getNonGroupMember()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $companyId = $this->input->post('company_id');
                    $type = $this->input->post('type');
                    $resp = $this->m->get_non_group_member($companyId, $type);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getFilter($typeFilter, $companyId)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_filter($typeFilter, $companyId);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getAllMemberGroup($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_group_member($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getAllGroup($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m->get_all_group($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getAllJobByUserId($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m_job->getAllJobByUserId($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getActivityJob($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m_job->getActivityJob($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function get_job_detail($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m_job->get_job_detail($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function get_job_participant($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->m_utils->auth();
                if ($response['status'] == 200) {
                    $resp = $this->m_job->get_job_participant($id);
                    $this->m_utils->json_output($response['status'], $resp);
                }
            }
        }
    }

    public function create_group()
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
                    $isEdit = $this->input->post('isEdit');
                    $user_id = $this->input->post('user_id');
                    $name = $this->input->post('name');
                    $description = $this->input->post('description');
                    $company_id = $this->input->post('company_id');
                    $type = $this->input->post('jenis');
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    if ($isEdit == "true") {
                        $sql = 'update t_group set name="' . $name . '", description="' . $description . '", modified_date="' . $modified_date . '", modified_by="' . $modified_by . '" where id=' . $id . '';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'group updated.'));
                    } else {
                        $sql = 'insert into t_group (name, description, company_id, created_by, created_date, modified_by, modified_date, type) values ("' . $name . '", "' . $description . '", "' . $company_id . '", "' . $created_by . '", "' . $created_date . '", "' . $modified_by . '", "' . $modified_date . '", "' . $type . '")';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'group created.'));
                    }
                }
            }
        }
    }

    public function create_employee()
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
                    $actor = $this->input->post('actor');
                    $nik = $this->input->post('nik');
                    $name = $this->input->post('employeeName');
                    $email = $this->input->post('emailEmployee');
                    $password = $this->input->post('password');
                    $phone = $this->input->post('employeePhone');
                    $employee_type = $this->input->post('employee_type');
                    $company_id = $this->input->post('company_id');
                    $isEdit = $this->input->post('isEdit');

                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $actor;
                    $modified_by = $actor;
                    if ($isEdit == "true") {
                        $sql = 'update t_user set nama_lengkap="' . $name . '", email="' . $email . '", phone="' . $phone . '", employee_type="' . $employee_type . '", nik="' . $nik . '", modified_by="' . $modified_by . '", modified_date="' . $modified_date . '" where user_id=' . $user_id . '';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'employee updated.'));
                    } else {
                        $sql = 'insert into t_user (nama_lengkap, photo, email, password, group_id, company_id, nik, phone, employee_type, created_by, created_date, modified_by, modified_date) values ("' . $name . '","default.png", "' . $email . '", "' . md5($password) . '", "0", "' . $company_id . '", "' . $nik . '", "' . $phone . '", "' . $employee_type . '", "' . $created_by . '", "' . $created_date . '", "' . $modified_by . '", "' . $modified_date . '")';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'employee created.'));
                    }
                }
            }
        }
    }

    public function create_group_assignment()
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
                        $group_id = $user['group_id'];
                        $user_id = $user['user_id'];
                        $role = $user['role'];
                        $author = $user['author'];
                        $type = $user['type'];
                        $where = '(user_id=' . $user_id . ' and group_id = ' . $group_id . ')';
                        $q  = $this->db->select('id')->from('t_group_assignment')->where($where)->get()->row();
                        if ($q == "") {
                            $sql = 'insert into t_group_assignment (group_id, user_id, role, created_by, created_date, modified_by, modified_date) values ("' . $group_id . '", "' . $user_id . '", "' . $role . '", "' . $author . '", "' . $created_date . '", "' . $author . '", "' . $modified_date . '")';
                            $query = $this->db->query($sql);
                            if ($type == "group") {
                                $sql = 'update t_user set group_id=' . $group_id . ' where user_id=' . $user_id . '';
                                $query = $this->db->query($sql);
                            }
                        }
                    }
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'member added'));
                }
            }
        }
    }

    public function update_job()
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
                    $title = $this->input->post('title');
                    $desc = $this->input->post('desc');
                    $image = $this->input->post('image');
                    $job_open_date = $this->input->post('job_open_date');
                    $job_close_date = $this->input->post('job_close_date');
                    $range_salary = $this->input->post('range_salary');
                    $responsibility = $this->input->post('responsibility');
                    $benefit = $this->input->post('benefit');
                    $requirement = $this->input->post('requirement');

                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    $image_date = date("YmdHis");
                    $config['upload_path'] = 'file/image/job/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size']      = '10096000';
                    $config['max_height'] = '3648';
                    $config['max_width'] = '6724';
                    $config['file_name'] = 'image_job_' . $user_id . '_' . $image_date;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) {
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                        // $sql_update = 'update t_job set status=0 where job_id='.$job_id.'';
                        $sql_update = 'update t_job set owner_id=' . $user_id . ', title="' . $title . '", description="' . $desc . '", image="' . $picture . '", job_open_date="' . $job_open_date . '", job_close_date="' . $job_close_date . '", range_salary="' . $range_salary . '", responsibility="' . $responsibility . '", benefit="' . $benefit . '", requirement="' . $requirement . '", modified_date="' . $modified_date . '", modified_by="' . $modified_by . '", status="' . $status . '"  where job_id=' . $job_id . '';
                        $exe_update = $this->db->query($sql_update);
                        // $sql = 'insert into t_job (owner_id, title, description, image, job_open_date, job_close_date, range_salary, responsibility, benefit, requirement, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'","'.$picture.'", "'.$job_open_date.'", "'.$job_close_date.'", "'.$range_salary.'", "'.$responsibility.'", "'.$benefit.'", "'.$requirement.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        // $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'job updated.'));
                    } else {
                        $sql_update = 'update t_job set owner_id=' . $user_id . ', title="' . $title . '", description="' . $desc . '", job_open_date="' . $job_open_date . '", job_close_date="' . $job_close_date . '", range_salary="' . $range_salary . '", responsibility="' . $responsibility . '", benefit="' . $benefit . '", requirement="' . $requirement . '", modified_date="' . $modified_date . '", modified_by="' . $modified_by . '", status="' . $status . '"  where job_id=' . $job_id . '';
                        $exe_update = $this->db->query($sql_update);
                        // $sql = 'insert into t_job (owner_id, title, description, image, job_open_date, job_close_date, range_salary, responsibility, benefit, requirement, created_date, created_by, modified_date, modified_by, status) values ('.$user_id.', "'.$title.'", "'.$desc.'","'.$picture.'", "'.$job_open_date.'", "'.$job_close_date.'", "'.$range_salary.'", "'.$responsibility.'", "'.$benefit.'", "'.$requirement.'", "'.$created_date.'", '.$created_by.', "'.$modified_date.'", '.$modified_by.', '.$status.')';
                        // $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'job updated.'));
                    }
                }
            }
        }
    }

    public function delete_employee()
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
                    $sql = 'delete from t_user where user_id=' . $id . '';
                    $query = $this->db->query($sql);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'data deleted'));
                }
            }
        }
    }

    public function delete_group()
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
                    $sql = 'delete from t_group where id=' . $id . '';
                    $query = $this->db->query($sql);
                    $sql_reset_group = 'update t_user set group_id=0 where group_id=' . $id . '';
                    $query_reset = $this->db->query($sql_reset_group);

                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'data deleted'));
                }
            }
        }
    }

    public function removeGroupMember()
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
                    $groupId = $this->input->post('group_id');
                    $sql = 'delete from t_group_assignment where group_id=' . $groupId . ' and user_id=' . $userId . '';
                    $query = $this->db->query($sql);
                    $sql_reset_group = 'update t_user set group_id=0 where group_id=' . $groupId . ' and user_id=' . $userId . '';
                    $query_reset = $this->db->query($sql_reset_group);

                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'member removed'));
                }
            }
        }
    }

    public function delete_job()
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

    public function post_participant()
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
                    $job_id = $this->input->post('job_id');
                    $response = $this->m_job->post_participant($user_id, $job_id);
                    $this->m_utils->json_output($response['status'], $response);
                }
            }
        }
    }
}
