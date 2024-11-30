<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_Model
{

    public function login($email, $password, $device_name, $device_version, $firebase_token)
    {
        $base = $this->config->base_url() . 'rm/file/image/user_profile/';
        $where = '(email="' . $email . '" and password = "' . md5($password) . '")';
        $q  = $this->db->select('*')->from('t_user')->where($where)->get()->row();
        if ($q == "") {
            return array('status' => 404, 'message' => 'email atau password salah.');
        } else {
            $user_id              = $q->user_id;
            $nama_lengkap            = $q->nama_lengkap;
            $role_id            = $q->role_id;
            $group_id            = $q->group_id;
            $status_user            = $q->status_user;
            $jabatan            = $q->jabatan;
            $photo            = $q->photo;
            $employee_type            = $q->employee_type;
            $company_id            = $q->company_id;
            $phone            = $q->phone;
            $nik            = $q->nik;
            $apps_script_url            = $q->apps_script_url;
            $email        = $q->email;

            $token = '';
            $expired_at = date("Y-m-d H:i:s", strtotime('+1 week'));
            $created_at = date("Y-m-d H:i:s");
            $updated_at = date("Y-m-d H:i:s");
            $last_login = date('Y-m-d H:i:s');
            $created_by = $user_id;
            $modified_by = $user_id;
            $status = '1';
            $sql  = $this->db->select('user_id')->from('t_user_token')->where('user_id', $user_id)->get()->row();
            if ($sql == "") {
                //need manual encryption for password
                do {
                    $bytes = random_bytes(15);
                    $token .= str_replace(['.', '/', '='], '', base64_encode($bytes));
                } while (strlen($token) < 15);
                $this->db->trans_start();
                $this->db->where('user_id', $user_id)->update('t_user', array('last_login' => $last_login, 'firebase_token' => $firebase_token));
                $this->db->insert('t_user_token', array('user_id' => $user_id, 'token' => $token, 'device_name' => $device_name, 'device_version' => $device_version, 'expired_at' => $expired_at, 'created_date' => $created_at, 'created_by' => $created_by, 'modified_date' => $updated_at, 'modified_by' => $modified_by, 'status' => $status));
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return array('status' => 500, 'message' => 'Internal server error.');
                } else {
                    $this->db->trans_commit();
                    return array(
                        'status' => 200,
                        'message' => 'Successfully login',
                        'user_id' => $user_id,
                        'role_id' => $role_id,
                        'group_id' => $group_id,
                        'status_user' => $status_user,
                        'jabatan' => $jabatan,
                        'photo' => $photo,
                        'employee_type' => $employee_type,
                        'company_id' => $company_id,
                        'phone' => $phone,
                        'nik' => $nik,
                        'nama_lengkap' => $nama_lengkap,
                        'token' => $token,
                        'apps_script_url' => $apps_script_url,
                        'email' => $email
                    );
                }
            } else {
                do {
                    $bytes = random_bytes(15);
                    $token .= str_replace(['.', '/', '='], '', base64_encode($bytes));
                } while (strlen($token) < 15);
                $this->db->trans_start();
                $this->db->where('user_id', $user_id)->update('t_user', array('last_login' => $last_login, 'firebase_token' => $firebase_token));
                $this->db->where('user_id', $user_id)->update('t_user_token', array('status' => '0', 'modified_date' => $updated_at));
                $this->db->insert('t_user_token', array('user_id' => $user_id, 'token' => $token, 'device_name' => $device_name, 'device_version' => $device_version, 'expired_at' => $expired_at, 'created_date' => $created_at, 'created_by' => $created_by, 'modified_date' => $updated_at, 'modified_by' => $modified_by, 'status' => $status));
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return array('status' => 500, 'message' => 'Internal server error.');
                } else {
                    $this->db->trans_commit();
                    return array(
                        'status' => 200,
                        'message' => 'Successfully login',
                        'user_id' => $user_id,
                        'role_id' => $role_id,
                        'group_id' => $group_id,
                        'status_user' => $status_user,
                        'jabatan' => $jabatan,
                        'photo' => $photo,
                        'employee_type' => $employee_type,
                        'company_id' => $company_id,
                        'phone' => $phone,
                        'nik' => $nik,
                        'nama_lengkap' => $nama_lengkap,
                        'token' => $token,
                        'apps_script_url' => $apps_script_url,
                        'email' => $email
                    );
                }
            }
        }
    }
}
