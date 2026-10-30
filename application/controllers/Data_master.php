<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_master extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataMaster');
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
    public function jenis_akun()
    {
        $data['title'] = 'Jenis Akun';
        $data['data_jenis'] = $this->DataMaster->jenis()->result_array();

        foreach ($data['data_jenis'] as $i => $jenis) {

            $data['data_jenis'][$i]['action'] = '<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal' . $jenis['kode'] . ' "><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal' . $jenis['kode'] . ' "><i class="fa fa-trash"></i></button>';
        }

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('data_master/jenis_akun', $data);
        $this->load->view('footer');
    }
    public function tambah_jenis()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'kode_parent' => $_POST['kode'],
                'kode' => $_POST['kode_jenis'],
                'nama' => $_POST['nama_jenis'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id')
            ];

            $jenis_add = $this->DataMaster->tambah('m1_jenis', $data);
            if (!$jenis_add) {
                throw new \Exception('Failed');
            }
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah Jenis Akun Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah Jenis Akun Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function ubah_jenis()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'kode_parent' => $_POST['kode_edt'],
                'kode' => $_POST['kode_jenis_edt'],
                'nama' => $_POST['nama_jenis_edt'],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id')
            ];

            $jenis_edt = $this->DataMaster->edit('m1_jenis', $data, array('kode' => $_POST['id_jenis']));
            if (!$jenis_edt) {
                throw new \Exception('Failed');
            }

            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Jenis Akun Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Jenis Akun Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_jenis()
    {
        $id_jenis = $this->input->post('id_jenis_hps');

        $this->DataMaster->hapus('m1_jenis', array('kode' => $id_jenis));

        $activity_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'activity' => 'Hapus Jenis Akun Berhasil',
            'times' => date('Y-m-d H:i:s')
        );

        $this->LoginModel->tambah('activity_log', $activity_data);

        $this->session->set_flashdata('success', 'Sukses! Data berhasil dihapus.');

        redirect($_SERVER['HTTP_REFERER']);
    }
    public function item_akun()
    {
        $data['title'] = 'Item Akun';
        $data['data_jenis'] = $this->DataMaster->jenis()->result_array();
        $data['data_item'] = $this->DataMaster->item()->result_array();

        foreach ($data['data_item'] as $i => $item) {

            $data['data_item'][$i]['action'] = '<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal' . $item['kode'] . ' "><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal' . $item['kode'] . ' "><i class="fa fa-trash"></i></button>';
        }

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('data_master/item_akun', $data);
        $this->load->view('footer');
    }
    public function tambah_item()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'kode_parent' => $_POST['kode'],
                'kode' => $_POST['kode_item'],
                'nama' => $_POST['nama_item'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id')
            ];

            $item_add = $this->DataMaster->tambah('m2_item', $data);
            if (!$item_add) {
                throw new \Exception('Failed');
            }

            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah Item Akun Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah Item Akun Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function ubah_item()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'kode_parent' => $_POST['kode_edt'],
                'kode' => $_POST['kode_item_edt'],
                'nama' => $_POST['nama_item_edt'],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id')
            ];

            $item_edt = $this->DataMaster->edit('m2_item', $data, array('kode' => $_POST['id_item']));
            if (!$item_edt) {
                throw new \Exception('Failed');
            }

            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Item Akun Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Item Akun Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_item()
    {
        $id_item = $this->input->post('id_item_hps');

        $this->DataMaster->hapus('m2_item', array('kode' => $id_item));

        $this->session->set_flashdata('success', 'Sukses! Data berhasil dihapus.');

        $activity_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'activity' => 'Hapus Item Akun Berhasil',
            'times' => date('Y-m-d H:i:s')
        );

        $this->LoginModel->tambah('activity_log', $activity_data);

        redirect($_SERVER['HTTP_REFERER']);
    }
}
