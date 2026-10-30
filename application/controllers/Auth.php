<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("LoginModel");//login model
    }
    public function index()
    {
        if ($this->LoginModel->logged_id()) {
            redirect('dashboard');
        }

        $data['title'] = 'IAA Accounting | Login Page';

        $data['user_list'] = $this->LoginModel->user_list();

        $this->load->view('users/login', $data);
    }
    public function login()
    {
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('userpass', 'userpass', 'required');

        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username', TRUE);
            $userpass = MD5($this->input->post('userpass', TRUE));
            $cek = $this->LoginModel->cek_login('user_account', array('username' => $username), array('userpass' => $userpass));
            if ($cek != FALSE) {
                foreach ($cek as $auth) {
                    $session_data = array(
                        'user_id' => $auth->user_id,
                        'username' => $auth->username,
                        'userpass' => $auth->userpass,
                        'role' => $auth->role,
                        'status' => 'login',
                        'bulan'  => (int) date('m'),
                        'tahun' => date('Y')
                    );

                    $activity_data = array(
                        'user_id' => $auth->user_id,
                        'activity' => 'Login Berhasil',
                        'times' => date('Y-m-d H:i:s')
                    );

                    $this->LoginModel->tambah('activity_log', $activity_data);

                    $this->session->set_userdata($session_data);
                    redirect('dashboard');
                }
            } else {
                $this->session->set_flashdata('gagal', '<div class=text-center><i class="fa fa-exclamation-circle"></i> Username atau password salah</div>');
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }
    public function ubah_password()
    {
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        } else {
            $this->load->view('users/ubah_pass');
        }
    }
    public function update_password()
    {
        $this->db->trans_begin();
        try {
            $session_id = $this->session->userdata('user_id');
            $session_pass = $this->session->userdata('userpass');

            $this->form_validation->set_rules('o_userpass', 'Password Lama', 'required|trim');
            $this->form_validation->set_rules('n_userpass', 'Pasrword Baru', 'required|trim|matches[c_userpass]');
            $this->form_validation->set_rules('c_userpass', 'Konfirmasi Password Baru', 'required|trim|matches[n_userpass]');

            $o_userpass = md5($this->input->post('o_userpass'));
            $n_userpass = $this->input->post('n_userpass');

            if ($this->form_validation->run() == true) {
                if ($o_userpass == $session_pass) {
                    $userpass = array('userpass' => md5($n_userpass));
                    $where = array('user_id' => $session_id);
                    $this->LoginModel->ubah_password($where, $userpass);

                    $activity_data = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'activity' => 'Ubah Password Berhasil',
                        'times' => date('Y-m-d H:i:s')
                    );

                    $this->LoginModel->tambah('activity_log', $activity_data);
                    $this->db->trans_commit();
                    redirect('auth/logout');
                } else {
                    $this->session->set_flashdata('error1', 'Password lama salah!');
                    $this->load->view('users/ubah_pass');
                }
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan! Pastikan input anda benar!');
                $this->load->view('users/ubah_pass');
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            redirect('dashboard');
        }
    }

    public function logout()
    {
        $activity_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'activity' => 'Logout',
            'times' => date('Y-m-d H:i:s')
        );

        $this->LoginModel->tambah('activity_log', $activity_data);

        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}
