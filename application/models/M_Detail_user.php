<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Detail_user extends CI_Model
{


    public function get_all_data()
    {
        $sql = 'select * from t_user_detail_personil';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function get_user($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select user_id, nama_lengkap, CONCAT("' . $base . '", photo) as photo, status from t_user where company_id=' . $id . '';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function getUserByRole()
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select user_id, role_id, nama_lengkap, CONCAT("' . $base . '", photo) as image, email, status from t_user where status=1';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function user_detail_data($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.user_detail_personil_id, a.user_id, a.nama, a.personil_classification, CONCAT("' . $base . '", a.foto) as foto, a.no_kta, a.no_ktp, a.company_id, b.nama as company_name, a.tgl_mulai_kontrak, a.tgl_berakhir_kontrak, a.tempat_lahir, a.tanggal_lahir, a.no_npwp, a.no_bpjst, a.alamat, a.kota_id as kota, a.provinsi_id as provinsi, a.phone_1, a.phone_2, a.created_date, a.created_by, a.modified_date, a.modified_by from t_user_detail_personil a join t_user_detail_company b on a.company_id=b.user_id where a.user_id=' . $id . ' and b.status=1 and a.status=1';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function getDetailUser($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.user_detail_id, a.user_id, a.nama, CONCAT("' . $base . '", a.foto) as foto, a.nik, a.alamat, d.name as kota, c.name as provinsi, a.gender, a.no_kta, a.jabatan, a.masa_berlaku, a.kota_penerbitan, a.tgl_penerbitan, a.created_by, a.modified_date, a.modified_by, b.login_type, b.email as username from t_user_detail a join t_user b on a.user_id=b.user_id join t_locate_provinsi c on a.provinsi_id=c.id join t_locate_kabupaten d on a.kota_id=d.id where a.user_id=' . $id . ' and a.status=1';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function user_detail_data_company($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select user_id, nama, CONCAT("' . $base . '", foto) as foto, bentuk_usaha, bidang_usaha, alamat, kota, provinsi, phone, fax, website, akta_pendirian_notaris, akta_perubahan_terakhir, npwp, nppkp, siup, tdp, domisili_perusahaan, corporate_layer, sio_mabes, sio_disnaker from t_user_detail_company where status=1 and user_id=' . $id . '';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function userDetailPersonil($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.user_id, a.nama_lengkap, CONCAT("' . $base . '", a.photo) as photo, a.created_date as joined_date, b.nik, b.alamat, c.name as provinsi, c.id as provinsi_id, d.name as kota, d.id as kota_id, b.gender, b.no_kta, b.jabatan, b.masa_berlaku, b.kota_penerbitan, b.tgl_penerbitan from t_user a join t_user_detail_personil b on a.user_id=b.user_id join t_locate_provinsi c on b.provinsi_id=c.id join t_locate_kabupaten d on b.kabupaten_id=d.id where b.status=1 and b.user_id=' . $id . '';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function userDetailDataBujp($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.user_id, a.nama_lengkap, CONCAT("' . $base . '", a.photo) as photo, a.created_date as joined_date, b.siup, b.alamat, c.name as provinsi, c.id as provinsi_id, d.name as kota, d.id as kota_id, b.phone, b.fax, b.website from t_user a join t_user_detail_bujp b on a.user_id=b.user_id join t_locate_provinsi c on b.provinsi_id=c.id join t_locate_kabupaten d on b.kabupaten_id=d.id where b.status=1 and b.user_id=' . $id . '';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function getJumlahPersonilBujp($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.id, a.bujp_id, a.personil_id, b.nama_lengkap, CONCAT("' . $base . '", b.photo) as photo from t_man_power a join t_user b on a.personil_id=b.user_id where a.bujp_id=' . $id . '';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function userDetailDataMitraBisnis($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.user_id, a.nama_lengkap, CONCAT("' . $base . '", a.photo) as photo, a.created_date as joined_date, b.alamat, c.name as provinsi, c.id as provinsi_id, d.name as kota, d.id as kota_id, b.phone, b.fax, b.website from t_user a join t_user_detail_mitra_bisnis b on a.user_id=b.user_id join t_locate_provinsi c on b.provinsi_id=c.id join t_locate_kabupaten d on b.kabupaten_id=d.id where b.status=1 and b.user_id=' . $id . '';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function userDetailDataOrganisasi($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.user_id, a.nama_lengkap, CONCAT("' . $base . '", a.photo) as photo, a.created_date as joined_date, b.alamat, c.name as provinsi, c.id as provinsi_id, d.name as kota, d.id as kota_id, b.phone, b.fax, b.website from t_user a join t_user_detail_organisasi b on a.user_id=b.user_id join t_locate_provinsi c on b.provinsi_id=c.id join t_locate_kabupaten d on b.kabupaten_id=d.id where b.status=1 and b.user_id=' . $id . '';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function userDetailDataRegulator($id)
    {
        $base = $this->config->base_url() . 'uploads/ciapi_dev/file/image/user_profile/';
        $sql = 'select a.user_id, a.nama_lengkap, CONCAT("' . $base . '", a.photo) as photo, a.created_date as joined_date, b.alamat, c.name as provinsi, c.id as provinsi_id, d.name as kota, d.id as kota_id, b.phone, b.fax, b.website from t_user a join t_user_detail_regulator b on a.user_id=b.user_id join t_locate_provinsi c on b.provinsi_id=c.id join t_locate_kabupaten d on b.kabupaten_id=d.id where b.status=1 and b.user_id=' . $id . '';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }

    public function get_company($role_id)
    {
        $sql = 'select a.user_id, b.nama from t_user a join t_user_detail_company b on a.user_id=b.user_id where a.role_id=' . $role_id . ' and b.status=1';
        $query = $this->db->query($sql);
        return array(
            'status' => 200,
            'message' => "Berhasil",
            'data' => $query->result()
        );
    }
}
