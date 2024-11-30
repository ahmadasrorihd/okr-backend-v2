<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Detail_user','m_detail_user');
		$this->load->model('M_Utils', 'm_utils');
	}
	
	public function index()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->get_all_data();
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

	public function get_user($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->get_user($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function getUserByRole()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->getUserByRole();
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}

	public function get_detail_user($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->user_detail_data($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getDetailUser($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->getDetailUser($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function update_data()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'||$method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$nama = $this->input->post('nama');
					$foto = $this->input->post('foto');
					$nik = $this->input->post('nik');
					$alamat = $this->input->post('alamat');
					$kota = $this->input->post('kota');
					$provinsi = $this->input->post('provinsi');
					$gender = $this->input->post('gender');
					$phone = $this->input->post('phone');
					$no_kta = $this->input->post('no_kta');
					$jabatan = $this->input->post('jabatan');
					$masa_berlaku = $this->input->post('masa_berlaku');
					$kota_penerbitan = $this->input->post('kota_penerbitan');
                    $tgl_penerbitan = $this->input->post('tgl_penerbitan');
                    
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/user_profile/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_user_profile_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    //aktivasi otomatis belum ada validasi data
                    $sql_update = 'update t_user set status=1 where user_id='.$user_id.'';
                    $query = $this->db->query($sql_update);
					if($this->upload->do_upload('foto'))
					{
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$q  = $this->db->select('*')->from('t_user_detail')->where('user_id',$user_id)->get()->row();
						if($q == ""){
                            $sql_create = 'insert into t_user_detail (user_id, nama, foto, nik, alamat, kota, provinsi, gender, phone, no_kta, jabatan, masa_berlaku, kota_penerbitan, tgl_penerbitan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'","'.$nama.'","'.$picture.'", "'.$nik.'", "'.$alamat.'", "'.$kota.'", "'.$provinsi.'", "'.$gender.'", "'.$phone.'", "'.$no_kta.'", "'.$jabatan.'", "'.$masa_berlaku.'", "'.$kota_penerbitan.'", "'.$tgl_penerbitan.'","'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}else {
                            $sql_update = 'update t_user_detail set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);
                            $sql_create = 'insert into t_user_detail (user_id, nama, foto, nik, alamat, kota, provinsi, gender, phone, no_kta, jabatan, masa_berlaku, kota_penerbitan, tgl_penerbitan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'","'.$nama.'","'.$picture.'", "'.$nik.'", "'.$alamat.'", "'.$kota.'", "'.$provinsi.'", "'.$gender.'", "'.$phone.'", "'.$no_kta.'", "'.$jabatan.'", "'.$masa_berlaku.'", "'.$kota_penerbitan.'", "'.$tgl_penerbitan.'","'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}
					}
					else
					{
                        $picture = "default.png";
                        $sql_update = 'update t_user_detail set status=0 where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update);
                        $sql_create = 'insert into t_user_detail (user_id, nama, foto, nik, alamat, kota, provinsi, gender, phone, no_kta, jabatan, masa_berlaku, kota_penerbitan, tgl_penerbitan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'","'.$nama.'","'.$picture.'", "'.$nik.'", "'.$alamat.'", "'.$kota.'", "'.$provinsi.'", "'.$gender.'", "'.$phone.'", "'.$no_kta.'", "'.$jabatan.'", "'.$masa_berlaku.'", "'.$kota_penerbitan.'", "'.$tgl_penerbitan.'","'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
					}
				}
			}
		}
    }

    public function updateDetailUser()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'||$method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$nama = $this->input->post('nama');
					$foto = $this->input->post('foto');
					$nik = $this->input->post('nik');
					$alamat = $this->input->post('alamat');
					$kota = $this->input->post('kota');
					$provinsi = $this->input->post('provinsi');
					$gender = $this->input->post('gender');
					$no_kta = $this->input->post('no_kta');
					$jabatan = $this->input->post('jabatan');
					$masa_berlaku = $this->input->post('masa_berlaku');
					$kota_penerbitan = $this->input->post('kota_penerbitan');
                    $tgl_penerbitan = $this->input->post('tgl_penerbitan');
                    
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/user_profile/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_user_profile_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    //aktivasi otomatis belum ada validasi data
                    $sql_update = 'update t_user set status=1 where user_id='.$user_id.'';
                    $query = $this->db->query($sql_update);
					if($this->upload->do_upload('foto'))
					{
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$q  = $this->db->select('*')->from('t_user_detail')->where('user_id',$user_id)->get()->row();
						if($q == ""){
                            $sql_create = 'insert into t_user_detail (user_id, nama, foto, nik, alamat, kota, provinsi, gender, no_kta, jabatan, masa_berlaku, kota_penerbitan, tgl_penerbitan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'","'.$nama.'","'.$picture.'", "'.$nik.'", "'.$alamat.'", "'.$kota.'", "'.$provinsi.'", "'.$gender.'", "'.$no_kta.'", "'.$jabatan.'", "'.$masa_berlaku.'", "'.$kota_penerbitan.'", "'.$tgl_penerbitan.'","'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}else {
                            $sql_update = 'update t_user_detail set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);
                            $sql_create = 'insert into t_user_detail (user_id, nama, foto, nik, alamat, kota, provinsi, gender, no_kta, jabatan, masa_berlaku, kota_penerbitan, tgl_penerbitan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'","'.$nama.'","'.$picture.'", "'.$nik.'", "'.$alamat.'", "'.$kota.'", "'.$provinsi.'", "'.$gender.'", "'.$no_kta.'", "'.$jabatan.'", "'.$masa_berlaku.'", "'.$kota_penerbitan.'", "'.$tgl_penerbitan.'","'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}
					}
					else
					{
                        $picture = "default.png";
                        $sql_update = 'update t_user_detail set status=0 where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update);
                        $sql_create = 'insert into t_user_detail (user_id, nama, foto, nik, alamat, kota, provinsi, gender, no_kta, jabatan, masa_berlaku, kota_penerbitan, tgl_penerbitan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'","'.$nama.'","'.$picture.'", "'.$nik.'", "'.$alamat.'", "'.$kota.'", "'.$provinsi.'", "'.$gender.'", "'.$no_kta.'", "'.$jabatan.'", "'.$masa_berlaku.'", "'.$kota_penerbitan.'", "'.$tgl_penerbitan.'","'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
					}
				}
			}
		}
    }
    
    public function get_detail_user_company($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->user_detail_data_company($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}

    public function update_data_company()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'||$method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$nama = $this->input->post('nama');
					$bentuk_usaha = $this->input->post('bentuk_usaha');
					$bidang_usaha = $this->input->post('bidang_usaha');
					$alamat = $this->input->post('alamat');
					$kota = $this->input->post('kota');
					$provinsi = $this->input->post('provinsi');
					$phone = $this->input->post('phone');
					$fax = $this->input->post('fax');
					$website = $this->input->post('website');
					$akta_pendirian_notaris = $this->input->post('akta_pendirian_notaris');
					$akta_perubahan_terakhir = $this->input->post('akta_perubahan_terakhir');
					$npwp = $this->input->post('npwp');
					$nppkp = $this->input->post('nppkp');
					$siup = $this->input->post('siup');
					$tdp = $this->input->post('tdp');
					$domisili_perusahaan = $this->input->post('domisili_perusahaan');
					$corporate_layer = $this->input->post('corporate_layer');
					$sio_mabes = $this->input->post('sio_mabes');
                    $sio_disnaker = $this->input->post('sio_disnaker');
                    
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/user_profile/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_user_profile_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    //aktivasi otomatis belum ada validasi data
                    $sql_update = 'update t_user set status=1 where user_id='.$user_id.'';
                    $query = $this->db->query($sql_update);

					if($this->upload->do_upload('foto'))
					{
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$q  = $this->db->select('*')->from('t_user_detail_company')->where('user_id',$user_id)->get()->row();
						if($q == ""){
                            $sql_create = 'insert into t_user_detail_company (user_id, nama, foto, bentuk_usaha, bidang_usaha, alamat, kota, provinsi, phone, fax, website, akta_pendirian_notaris, akta_perubahan_terakhir, npwp, nppkp, siup, tdp, domisili_perusahaan, corporate_layer, sio_mabes, sio_disnaker, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$nama.'", "'.$picture.'", "'.$bentuk_usaha.'", "'.$bidang_usaha.'", "'.$alamat.'", "'.$kota.'", "'.$provinsi.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$akta_pendirian_notaris.'", "'.$akta_perubahan_terakhir.'", "'.$npwp.'", "'.$nppkp.'", "'.$siup.'", "'.$tdp.'", "'.$domisili_perusahaan.'","'.$corporate_layer.'", "'.$sio_mabes.'", "'.$sio_disnaker.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}else {
                            $sql_update = 'update t_user_detail_company set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);
                            $sql_create = 'insert into t_user_detail_company (user_id, nama, foto, bentuk_usaha, bidang_usaha, alamat, kota, provinsi, phone, fax, website, akta_pendirian_notaris, akta_perubahan_terakhir, npwp, nppkp, siup, tdp, domisili_perusahaan, corporate_layer, sio_mabes, sio_disnaker, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$nama.'", "'.$picture.'", "'.$bentuk_usaha.'", "'.$bidang_usaha.'", "'.$alamat.'", "'.$kota.'", "'.$provinsi.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$akta_pendirian_notaris.'", "'.$akta_perubahan_terakhir.'", "'.$npwp.'", "'.$nppkp.'", "'.$tdp.'", "'.$domisili_perusahaan.'", "'.$siup.'", "'.$corporate_layer.'", "'.$sio_mabes.'", "'.$sio_disnaker.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}
					}
					else
					{
                        $picture = "default.png";
                        $sql_update = 'update t_user_detail_company set status=0 where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update);
                        $sql_create = 'insert into t_user_detail_company (user_id, nama, foto, bentuk_usaha, bidang_usaha, alamat, kota, provinsi, phone, fax, website, akta_pendirian_notaris, akta_perubahan_terakhir, npwp, nppkp, siup, tdp, domisili_perusahaan, corporate_layer, sio_mabes, sio_disnaker, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$nama.'", "'.$picture.'", "'.$bentuk_usaha.'", "'.$bidang_usaha.'", "'.$alamat.'", "'.$kota.'", "'.$provinsi.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$akta_pendirian_notaris.'", "'.$akta_perubahan_terakhir.'", "'.$npwp.'", "'.$nppkp.'", "'.$siup.'", "'.$tdp.'", "'.$domisili_perusahaan.'", "'.$corporate_layer.'", "'.$sio_mabes.'", "'.$sio_disnaker.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
					}
				}
			}
		}
    }

    public function getDetailUserPersonil($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->userDetailPersonil($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getDetailUserBujp($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->userDetailDataBujp($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }

    public function getJumlahPersonilBujp($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->getJumlahPersonilBujp($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function getDetailUserMitraBisnis($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->userDetailDataMitraBisnis($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function getDetailUserOrganisasi($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->userDetailDataOrganisasi($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
    }
    
    public function getDetailUserRegulator($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				if($response['status'] == 200){
					$resp = $this->m_detail_user->userDetailDataRegulator($id);
					$this->m_utils->json_output($response['status'],$resp);
				}
			}
		}
	}
    
	public function update_data_personil()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'||$method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$no_kta = $this->input->post('no_kta');
					$no_ktp = $this->input->post('no_ktp');
					$company_id = $this->input->post('company_id');
					$tgl_mulai_kontrak = $this->input->post('tgl_mulai_kontrak');
					$tgl_berakhir_kontrak = $this->input->post('tgl_berakhir_kontrak');
					$tempat_lahir = $this->input->post('tempat_lahir');
					$tanggal_lahir = $this->input->post('tgl_lahir');
					$no_npwp = $this->input->post('no_npwp');
					$no_bpjst = $this->input->post('no_bpjst');
					$alamat = $this->input->post('alamat');
					$kota_id = $this->input->post('kota_id');
					$provinsi_id = $this->input->post('provinsi_id');
					$phone_1 = $this->input->post('phone_1');
					$phone_2 = $this->input->post('phone_2');
					$nama = $this->input->post('nama');
					$personil_classification = $this->input->post('personil_classification');
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/user_profile/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_user_profile_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    //aktivasi otomatis belum ada validasi data
                    $sql_update = 'update t_user set status=1 where user_id='.$user_id.'';
                    $query = $this->db->query($sql_update);
					if($this->upload->do_upload('foto'))
					{
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$q  = $this->db->select('*')->from('t_user_detail_personil')->where('user_id',$user_id)->get()->row();
						if($q == ""){
                            $sql_update = 'update t_user_detail_personil set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);
                            $sql_create = 'insert into t_user_detail_personil (user_id, nama, personil_classification, foto, no_kta, no_ktp, company_id, tgl_mulai_kontrak, tgl_berakhir_kontrak, tempat_lahir, tanggal_lahir, no_npwp, no_bpjst, alamat, kota_id, provinsi_id, phone_1, phone_2, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'","'.$nama.'","'.$personil_classification.'", "'.$picture.'", "'.$no_kta.'", "'.$no_ktp.'", "'.$company_id.'", "'.$tgl_mulai_kontrak.'", "'.$tgl_berakhir_kontrak.'", "'.$tempat_lahir.'", "'.$tanggal_lahir.'", "'.$no_npwp.'", "'.$no_bpjst.'", "'.$alamat.'", "'.$kota_id.'", "'.$provinsi_id.'", "'.$phone_1.'", "'.$phone_2.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}else {
                            $sql_update = 'update t_user_detail_personil set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);
                            $sql_create = 'insert into t_user_detail_personil (user_id, nama, personil_classification, foto, no_kta, no_ktp, company_id, tgl_mulai_kontrak, tgl_berakhir_kontrak, tempat_lahir, tanggal_lahir, no_npwp, no_bpjst, alamat, kota_id, provinsi_id, phone_1, phone_2, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'","'.$nama.'","'.$personil_classification.'", "'.$picture.'", "'.$no_kta.'", "'.$no_ktp.'", "'.$company_id.'", "'.$tgl_mulai_kontrak.'", "'.$tgl_berakhir_kontrak.'", "'.$tempat_lahir.'", "'.$tanggal_lahir.'", "'.$no_npwp.'", "'.$no_bpjst.'", "'.$alamat.'", "'.$kota_id.'", "'.$provinsi_id.'", "'.$phone_1.'", "'.$phone_2.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}
					}
					else
					{
                        $picture = "default.png";
                        $sql_update = 'update t_user_detail_personil set status=0 where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update);
                        $sql_create = 'insert into t_user_detail_personil (user_id, nama, personil_classification, foto, no_kta, no_ktp, company_id, tgl_mulai_kontrak, tgl_berakhir_kontrak, tempat_lahir, tanggal_lahir, no_npwp, no_bpjst, alamat, kota_id, provinsi_id, phone_1, phone_2, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'","'.$nama.'","'.$personil_classification.'", "'.$picture.'", "'.$no_kta.'", "'.$no_ktp.'", "'.$company_id.'", "'.$tgl_mulai_kontrak.'", "'.$tgl_berakhir_kontrak.'", "'.$tempat_lahir.'", "'.$tanggal_lahir.'", "'.$no_npwp.'", "'.$no_bpjst.'", "'.$alamat.'", "'.$kota_id.'", "'.$provinsi_id.'", "'.$phone_1.'", "'.$phone_2.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
					}
				}
			}
		}
    } 

    public function updateDataPersonil()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'||$method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$nama = $this->input->post('nama');
                    $nik = $this->input->post('nik');
                    $alamat = $this->input->post('alamat');
                    $provinsi_id = $this->input->post('provinsi_id');
                    $kabupaten_id = $this->input->post('kabupaten_id');
                    $gender = $this->input->post('gender');
                    $no_kta = $this->input->post('no_kta');
                    $jabatan = $this->input->post('jabatan');
                    $masa_berlaku = $this->input->post('masa_berlaku');
                    $kota_penerbitan = $this->input->post('kota_penerbitan');
                    $tgl_penerbitan = $this->input->post('tgl_penerbitan');
                    
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/user_profile/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_user_profile_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    //aktivasi otomatis belum ada validasi data
                    $sql_update = 'update t_user set status=1 where user_id='.$user_id.'';
                    $query = $this->db->query($sql_update);

					if($this->upload->do_upload('foto'))
					{
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$q  = $this->db->select('*')->from('t_user_detail_personil')->where('user_id',$user_id)->get()->row();
						if($q == ""){
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user);

                            $sql_create = 'insert into t_user_detail_personil (user_id, nik, alamat, provinsi_id, kabupaten_id, gender, no_kta, jabatan, masa_berlaku, kota_penerbitan, tgl_penerbitan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$nik.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$gender.'", "'.$no_kta.'", "'.$jabatan.'", "'.$masa_berlaku.'", "'.$kota_penerbitan.'", "'.$tgl_penerbitan.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}else {
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user);
                            
                            $sql_update = 'update t_user_detail_personil set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);

                            $sql_create = 'insert into t_user_detail_personil (user_id, nik, alamat, provinsi_id, kabupaten_id, gender, no_kta, jabatan, masa_berlaku, kota_penerbitan, tgl_penerbitan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$nik.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$gender.'", "'.$no_kta.'", "'.$jabatan.'", "'.$masa_berlaku.'", "'.$kota_penerbitan.'", "'.$tgl_penerbitan.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}
					}
					else
					{
                        // $picture = "default.png";
                        $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'" where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update_user);
                        
                        $sql_update = 'update t_user_detail_personil set status=0 where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update);

                        $sql_create = 'insert into t_user_detail_personil (user_id, nik, alamat, provinsi_id, kabupaten_id, gender, no_kta, jabatan, masa_berlaku, kota_penerbitan, tgl_penerbitan, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$nik.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$gender.'", "'.$no_kta.'", "'.$jabatan.'", "'.$masa_berlaku.'", "'.$kota_penerbitan.'", "'.$tgl_penerbitan.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
					}
				}
			}
		}
    }

    public function updateDataBujp()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'||$method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$nama = $this->input->post('nama');
                    $alamat = $this->input->post('alamat');
                    $provinsi_id = $this->input->post('provinsi_id');
					$kabupaten_id = $this->input->post('kabupaten_id');
					$phone = $this->input->post('phone');
					$fax = $this->input->post('fax');
					$website = $this->input->post('website');
					$siup = $this->input->post('siup');
                    
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/user_profile/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_user_profile_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    //aktivasi otomatis belum ada validasi data
                    $sql_update = 'update t_user set status=1 where user_id='.$user_id.'';
                    $query = $this->db->query($sql_update);

					if($this->upload->do_upload('foto'))
					{
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$q  = $this->db->select('*')->from('t_user_detail_bujp')->where('user_id',$user_id)->get()->row();
						if($q == ""){
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user);
                            
                            $sql_create = 'insert into t_user_detail_bujp (user_id, siup, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$siup.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}else {
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user);
                            
                            $sql_update = 'update t_user_detail_bujp set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);
                            
                            $sql_create = 'insert into t_user_detail_bujp (user_id, siup, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$siup.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}
					}
					else
					{
                        // $picture = "default.png";
                        $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'" where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update_user);
                        
                        $sql_update = 'update t_user_detail_bujp set status=0 where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update);

                        $sql_create = 'insert into t_user_detail_bujp (user_id, siup, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$siup.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
					}
				}
			}
		}
    }
    
    public function updateDataMitraBisnis()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'||$method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$nama = $this->input->post('nama');
					$alamat = $this->input->post('alamat');
					$provinsi_id = $this->input->post('provinsi_id');
					$kabupaten_id = $this->input->post('kabupaten_id');
					$phone = $this->input->post('phone');
					$fax = $this->input->post('fax');
					$website = $this->input->post('website');
                    
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/user_profile/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_user_profile_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    //aktivasi otomatis belum ada validasi data
                    $sql_update = 'update t_user set status=1 where user_id='.$user_id.'';
                    $query = $this->db->query($sql_update);

					if($this->upload->do_upload('foto'))
					{
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$q  = $this->db->select('*')->from('t_user_detail_mitra_bisnis')->where('user_id',$user_id)->get()->row();
						if($q == ""){    
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user);

                            $sql_create = 'insert into t_user_detail_mitra_bisnis (user_id, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}else {
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user);
                            
                            $sql_update = 'update t_user_detail_mitra_bisnis set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);
                            
                            $sql_create = 'insert into t_user_detail_mitra_bisnis (user_id, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}
					}
					else
					{
                        // $picture = "default.png";
                        $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'" where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update_user);
                        
                        $sql_update = 'update t_user_detail_mitra_bisnis set status=0 where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update);

                        $sql_create = 'insert into t_user_detail_mitra_bisnis (user_id, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
					}
				}
			}
		}
    }
    
    public function updateDataOrganisasi()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'||$method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$nama = $this->input->post('nama');
					$alamat = $this->input->post('alamat');
					$provinsi_id = $this->input->post('provinsi_id');
					$kabupaten_id = $this->input->post('kabupaten_id');
					$phone = $this->input->post('phone');
					$fax = $this->input->post('fax');
					$website = $this->input->post('website');
                    
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/user_profile/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_user_profile_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    //aktivasi otomatis belum ada validasi data
                    $sql_update = 'update t_user set status=1 where user_id='.$user_id.'';
                    $query = $this->db->query($sql_update);

					if($this->upload->do_upload('foto'))
					{
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$q  = $this->db->select('*')->from('t_user_detail_organisasi')->where('user_id',$user_id)->get()->row();
						if($q == ""){   
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user); 

                            $sql_create = 'insert into t_user_detail_organisasi (user_id, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}else {
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user);
                            
                            $sql_update = 'update t_user_detail_organisasi set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);
                            
                            $sql_create = 'insert into t_user_detail_organisasi (user_id, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}
					}
					else
					{
                        // $picture = "default.png";
                        $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'" where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update_user);
                        
                        $sql_update = 'update t_user_detail_mitra_bisnis set status=0 where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update);

                        $sql_create = 'insert into t_user_detail_mitra_bisnis (user_id, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
					}
				}
			}
		}
    }
    
    public function updateDataRegulator()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'||$method != 'POST'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$user_id = $this->input->post('user_id');
					$nama = $this->input->post('nama');
					$alamat = $this->input->post('alamat');
					$provinsi_id = $this->input->post('provinsi_id');
					$kabupaten_id = $this->input->post('kabupaten_id');
					$phone = $this->input->post('phone');
					$fax = $this->input->post('fax');
					$website = $this->input->post('website');
                    
                    $image_date = date("YmdHis");
					$config['upload_path'] = 'file/image/user_profile/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '10096000';
					$config['max_height'] = '3648';
					$config['max_width'] = '6724';
					$config['file_name'] = 'image_user_profile_'.$user_id.'_'.$image_date;
					$this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $created_date = date("Y-m-d H:i:s");
                    $modified_date = date("Y-m-d H:i:s");
                    $created_by = $user_id;
                    $modified_by = $user_id;
                    $status = '1';

                    //aktivasi otomatis belum ada validasi data
                    $sql_update = 'update t_user set status=1 where user_id='.$user_id.'';
                    $query = $this->db->query($sql_update);

					if($this->upload->do_upload('foto'))
					{
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$q  = $this->db->select('*')->from('t_user_detail_regulator')->where('user_id',$user_id)->get()->row();
						if($q == ""){    
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user);

                            $sql_create = 'insert into t_user_detail_regulator (user_id, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}else {
                            $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'", photo="'.$picture.'" where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update_user);
                            
                            $sql_update = 'update t_user_detail_regulator set status=0 where user_id='.$user_id.'';
                            $query = $this->db->query($sql_update);
                            
                            $sql_create = 'insert into t_user_detail_regulator (user_id, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                            $query = $this->db->query($sql_create);
                            
                            return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
						}
					}
					else
					{
                        // $picture = "default.png";
                        $sql_update_user = 'update t_user set nama_lengkap="'.$nama.'" where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update_user);
                        
                        $sql_update = 'update t_user_detail_regulator set status=0 where user_id='.$user_id.'';
                        $query = $this->db->query($sql_update);

                        $sql_create = 'insert into t_user_detail_regulator (user_id, alamat, provinsi_id, kabupaten_id, phone, fax, website, created_date, created_by, modified_date, modified_by, status) values ("'.$user_id.'", "'.$alamat.'", "'.$provinsi_id.'", "'.$kabupaten_id.'", "'.$phone.'", "'.$fax.'", "'.$website.'", "'.$created_date.'", "'.$created_by.'", "'.$modified_date.'", "'.$modified_by.'", "'.$status.'")';
                        $query = $this->db->query($sql_create);
                        
                        return $this->m_utils->json_output(201,array('status' => 201,'message' => 'data updated.'));
					}
				}
			}
		}
    }
	
	public function get_company($role_id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->m_utils->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->m_utils->check_auth_client();
			if($check_auth_client == true){
				$response = $this->m_utils->auth();
				$respStatus = $response['status'];
				if($response['status'] == 200){	
					$resp = $this->m_detail_user->get_company($role_id);
					$this->m_utils->json_output($respStatus,$resp);
				}
			}
		}
	}
}
