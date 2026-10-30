<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rincian_dan_rangkuman extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('RincianDanRangkuman');
        $this->load->model('LoginModel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        }
    }
    public function index()
    {
    }
    public function uang_masuk()
    {
        $data['title'] = 'Uang Masuk';
        $data['data_uang_masuk'] = $this->RincianDanRangkuman->data('uang_masuk')->result_array();
        $data['data_item'] = $this->RincianDanRangkuman->item('50')->result_array();

        foreach ($data['data_uang_masuk'] as $i => $uang_masuk) {

            $data['data_uang_masuk'][$i]['action'] = '<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal' . $uang_masuk['id'] . ' "><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal' . $uang_masuk['id'] . ' "><i class="fa fa-trash"></i></button>';
        }

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('rincian_dan_rangkuman/uang_masuk', $data);
        $this->load->view('footer');
    }
    public function tambah_uang_masuk()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'kode_akun' => $_POST['kode_masuk'],
                'tanggal' => $_POST['tgl_masuk'],
                'uraian' => $_POST['uraian_masuk'],
                'jumlah' => $_POST['jml_masuk'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id')
            ];

            $masuk_add = $this->RincianDanRangkuman->tambah('uang_masuk', $data);
            if (!$masuk_add) {
                throw new \Exception('Failed');
            }
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah Uang Masuk Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah Uang Masuk Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function ubah_uang_masuk()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'tanggal' => $_POST['tgl_masuk_edt'],
                'uraian' => $_POST['uraian_masuk_edt'],
                'jumlah' => $_POST['jml_masuk_edt'],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id')
            ];

            $masuk_edt = $this->RincianDanRangkuman->edit('uang_masuk', $data, array('id' => $_POST['id_masuk_edt']));
            if (!$masuk_edt) {
                throw new \Exception('Failed');
            }
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Uang Masuk Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Uang Masuk Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_uang_masuk()
    {
        $this->RincianDanRangkuman->hapus('uang_masuk', array('id' => $_POST['id_masuk_hps']));

        $this->session->set_flashdata('success', 'Sukses! Data berhasil dihapus.');

        $activity_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'activity' => 'Hapus Uang Masuk Berhasil',
            'times' => date('Y-m-d H:i:s')
        );

        $this->LoginModel->tambah('activity_log', $activity_data);

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function uang_keluar()
    {
        $data['title'] = 'Uang Keluar';
        $data['data_uang_keluar'] = $this->RincianDanRangkuman->data('uang_keluar')->result_array();
        $data['data_item'] = $this->RincianDanRangkuman->item('40')->result_array();

        foreach ($data['data_uang_keluar'] as $i => $uang_keluar) {

            $data['data_uang_keluar'][$i]['action'] = '<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal' . $uang_keluar['id'] . ' "><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal' . $uang_keluar['id'] . ' "><i class="fa fa-trash"></i></button>';
        }

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('rincian_dan_rangkuman/uang_keluar', $data);
        $this->load->view('footer');
    }
    // public function data_keluar()
    // {
    //     $data = $this->RincianDanRangkuman->uang_keluar()->result_array();
    //     echo json_encode($data);
    // }
    public function tambah_uang_keluar()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'kode_akun' => $_POST['kode_keluar'],
                'tanggal' => $_POST['tgl_keluar'],
                'uraian' => $_POST['uraian_keluar'],
                'jumlah' => $_POST['jml_keluar'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id')
            ];

            $keluar_add = $this->RincianDanRangkuman->tambah('uang_keluar', $data);
            if (!$keluar_add) {
                throw new \Exception('Failed');
            }
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah Uang Keluar Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah Uang Keluar Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function ubah_uang_keluar()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'tanggal' => $_POST['tgl_keluar_edt'],
                'uraian' => $_POST['uraian_keluar_edt'],
                'jumlah' => $_POST['jml_keluar_edt'],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id')
            ];

            $keluar_edt = $this->RincianDanRangkuman->edit('uang_keluar', $data, array('id' => $_POST['id_keluar_edt']));
            if (!$keluar_edt) {
                throw new \Exception('Failed');
            }
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Uang Keluar Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Uang Keluar Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_uang_keluar()
    {
        $this->RincianDanRangkuman->hapus('uang_keluar', array('id' => $_POST['id_keluar_hps']));

        $this->session->set_flashdata('success', 'Sukses! Data berhasil dihapus.');
        $activity_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'activity' => 'Hapus Uang Keluar Berhasil',
            'times' => date('Y-m-d H:i:s')
        );

        $this->LoginModel->tambah('activity_log', $activity_data);

        redirect($_SERVER['HTTP_REFERER']);
    }
}
