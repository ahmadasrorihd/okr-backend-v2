<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Common extends CI_Model {
	
	public function get_common_header()
	{
		$sql = 'select * from m_common_header';
		$query = $this->db->query($sql);
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $query->result());
	}
	
		public function get_common_detail($id)
	{
		$sql = 'select * from m_common_detail WHERE id_com_header='.$id.'';
		$query = $this->db->query($sql);
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $query->result());
    }
    
    public function get_level()
	{
		//id_com_header=id provinsi di indonesia
		$sql = 'select * from m_common_detail where id_com_header=15';
        $query = $this->db->query($sql);
        $result = $query->result();
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $result);
	}

	public function get_provinsi()
	{
		//id_com_header=id provinsi di indonesia
		$sql = 'select * from m_common_detail where id_com_header=9';
        $query = $this->db->query($sql);
        $result = $query->result();
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $result);
	}
	
	public function get_kota($id)
	{
		//val_3 = id provinsi yg dipilih
		$sql = 'select * from m_common_detail where id_com_header=10 and val_3="'.$id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $result);
	}
	
	public function get_personil_classification($id)
	{
		// val_1=2 untuk id personil classification
		$sql = 'select * from m_common_detail where id_com_header=20 and val_1=2';
        $query = $this->db->query($sql);
        $result = $query->result();
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $result);
    }
}
