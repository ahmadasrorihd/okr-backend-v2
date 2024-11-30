<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Location extends CI_Model {


	public function get_provinsi()
	{
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
		$sql = 'select * from m_common_detail where id_com_header=10 and val_3="'.$id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
		return array(
		'status' => 200,
		'message' => "Berhasil",
		'data' => $result);
    }
}
