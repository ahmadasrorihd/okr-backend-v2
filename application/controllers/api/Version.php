<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Version extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Auth', 'm_auth');
        $this->load->model('M_Version', 'm_version');
        $this->load->model('M_Utils', 'm_utils');
    }

    public function get_version($flag)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $resp = $this->m_version->get_version($flag);
                $this->m_utils->json_output($resp['status'], $resp);
            }
        }
    }

    public function create()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->m_utils->check_auth_client();
            if ($check_auth_client == true) {
                $flag = $this->input->post('flag');
                $changelog = $this->input->post('changelog');
                $versionName = $this->input->post('version_name');
                $versionCode = $this->input->post('version_code');
                $user_id = $this->input->post('user_id');
                $current_timestamp = date("Y-m-d H:i:s");
                $image_date = date("YmdHis");
                $config['upload_path'] = 'file/download/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '0';
                $config['max_height'] = '0';
                $config['max_width'] = '0';
                if ($flag == "android") {
                    $config['file_name'] = 'apps_version_' . $user_id . '_' . $image_date . '.apk';
                } else {
                    $config['file_name'] = 'apps_version_' . $user_id . '_' . $image_date;
                }
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('apps')) {
                    $uploadData = $this->upload->data();
                    $content = $uploadData['file_name'];
                    $sql = 'insert into t_version (flag, release_date, filename, changelog, version_name, version_code, created_at, created_by, modified_at, modified_by) values ("' . $flag . '", "' . $current_timestamp . '", "' . $content . '", "' . $changelog . '", "' . $versionName . '", "' . $versionCode . '", "' . $current_timestamp . '", "' . $user_id . '", "' . $current_timestamp . '", "' . $user_id . '")';
                    $query = $this->db->query($sql);
                    return $this->m_utils->json_output(201, array('status' => 201, 'message' => 'Upload success'));
                } else {
                    return $this->m_utils->json_output(400, array('status' => 400, 'message' => 'Failed to upload'));
                }
            }
        }
    }
}
