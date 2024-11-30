<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Register','m_register');
		$this->load->model('M_Utils','m_utils');
	}

	// public function register()
	// {
	// 	$method = $_SERVER['REQUEST_METHOD'];
	// 	if($method != 'POST'){
	// 		$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
	// 	} else {
	// 		$check_auth_client = $this->m_utils->check_auth_client();
	// 		if($check_auth_client == true){
	// 			$role_id = $this->input->post('role_id');
	// 			$nama_lengkap = $this->input->post('nama_lengkap');
	// 			$email = $this->input->post('username');
	// 			$foto = $this->input->post('foto');
	// 			$response = $this->m_register->register($role_id,$nama_lengkap,$email,$foto);
	// 			$this->m_utils->json_output($response['status'],$response);
	// 		}
	// 	}
    // }
    
	public function register() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
                $role_id = $this->input->post('role_id');
                $nama_lengkap = $this->input->post('nama_lengkap');
                $email = $this->input->post('username');
            
                $created_date = date("Y-m-d H:i:s");
                $modified_date = date("Y-m-d H:i:s");
                $status = '1';
                $image_date = date("YmdHis");
                $config['upload_path'] = 'file/image/user_profile/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size']      = '10096000';
                $config['max_height'] = '3648';
                $config['max_width'] = '6724';
                $config['file_name'] = 'image_user_profile_'.$image_date;
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('foto'))
                {
                    // $this->upload->do_upload('cover');
                    $uploadData = $this->upload->data();
                    $foto = $uploadData['file_name'];
                    $q  = $this->db->select('*')->from('t_user')->where('email',$email)->get()->row();
                    if ($q!="") {
                        return $this->m_utils->json_output(302,array('status' => 302,'message' => 'email atau no telepon sudah terdaftar, silahkan login'));
                    } else {
                        $created_date = date("Y-m-d H:i:s");
                        $modified_date = date("Y-m-d H:i:s");
                        $created_by = "1";
                        $modified_by = "1";
                        $sql = 'insert into t_user (nama_lengkap, email, role_id, photo, created_date, created_by, modified_date, modified_by, status) values ("'.$nama_lengkap.'","'.$email.'","'.$role_id.'","'.$foto.'","'.$created_date.'","'.$created_by.'","'.$modified_date.'","'.$modified_by.'",0)';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'user has been created'));
                    }
                }
                else
                {
                    $foto = "default.png";
                    $q  = $this->db->select('*')->from('t_user')->where('email',$email)->get()->row();
                    if ($q!="") {
                        return $this->m_utils->json_output(302,array('status' => 302,'message' => 'email atau no telepon sudah terdaftar, silahkan login'));
                    } else {
                        $created_date = date("Y-m-d H:i:s");
                        $modified_date = date("Y-m-d H:i:s");
                        $created_by = "1";
                        $modified_by = "1";
                        $sql = 'insert into t_user (nama_lengkap, email, role_id, photo, created_date, created_by, modified_date, modified_by, status) values ("'.$nama_lengkap.'","'.$email.'","'.$role_id.'","'.$foto.'","'.$created_date.'","'.$created_by.'","'.$modified_date.'","'.$modified_by.'",0)';
                        $query = $this->db->query($sql);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'user has been created'));
                    }
                }
				
			}
		}
    }
}
