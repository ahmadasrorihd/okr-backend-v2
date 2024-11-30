<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Register extends CI_Model {
	
	public function register($role_id, $nama_lengkap, $email, $foto)
	{
		$q  = $this->db->select('*')->from('t_user')->where('email',$email)->get()->row();
		if ($q!="") {
			return array('status' => 302,'message' => 'email already taken.');
		} else {
			$created_date = date("Y-m-d H:i:s");
			$modified_date = date("Y-m-d H:i:s");
			$created_by = "1";
			$modified_by = "1";
			$sql = 'insert into t_user (nama_lengkap, email, role_id, photo, created_date, created_by, modified_date, modified_by, status) values ("'.$nama_lengkap.'","'.$email.'","'.$role_id.'","'.$foto.'","'.$created_date.'","'.$created_by.'","'.$modified_date.'","'.$modified_by.'",0)';
			$query = $this->db->query($sql);
			return array(
			'status' => 201,
			'message' => "user has been created");
		}
	}
}
