<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        }
        $this->load->model('LoginModel');
    }
    public function index()
    {
    }
    public function list()
    {
        $data['title'] = 'IAA Accounting | Setting';

        $data['user_list'] = $this->LoginModel->user_list();
        foreach ($data['user_list'] as $i => $user) {

            $data['user_list'][$i]['action'] = '<span data-toggle="modal" data-target="#resetModal' . $user['user_id'] . ' "><button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Kembalikan password" ><i class="fas fa-sync"></i></button></span>';
        }

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('users/list', $data);
        $this->load->view('footer');
    }
    public function tambah()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'user_id' => $_POST['id_user'],
                'username' => $_POST['username'],
                'userpass' => md5($_POST['userpass'])
            ];

            $user_add = $this->LoginModel->tambah('user_account', $data);
            if (!$user_add) {
                throw new \Exception('Failed');
            }
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah User Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Tambah User Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function reset()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'userpass' => md5('12345')
            ];

            $id_user = $this->input->post('id_reset');
            $user_add = $this->LoginModel->ubah_password(array('user_id' => $id_user), $data);
            if (!$user_add) {
                throw new \Exception('Failed');
            }
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Reset Password Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Password berhasil dikembalikan menjadi 12345');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Reset Password Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function activity()
    {
        $data['title'] = 'IAA Accounting | Setting';

        $data['activities'] = $this->LoginModel->activity_list();

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('users/activity', $data);
        $this->load->view('footer');
    }
}
