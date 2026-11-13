<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Auth extends BaseController
{
    protected LoginModel $loginModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }

    public function index()
    {
        if ($this->loginModel->loggedId()) {
            return redirect()->to(base_url('dashboard'));
        }

        $data['title']     = 'IAA Accounting | Login Page';
        $data['user_list'] = $this->loginModel->userList();

        return view('users/login', $data);
    }

    public function login()
    {
        $rules = [
            'username' => 'required',
            'userpass' => 'required',
        ];

        if ($this->validate($rules)) {
            $username = (string) $this->request->getPost('username');
            $userpass = md5((string) $this->request->getPost('userpass'));

            $cek = $this->loginModel->cekLogin(
                'user_account',
                ['username' => $username],
                ['userpass' => $userpass]
            );

            if ($cek !== false) {
                foreach ($cek as $auth) {
                    $sessionData = [
                        'user_id'  => $auth->user_id,
                        'username' => $auth->username,
                        'userpass' => $auth->userpass,
                        'role'     => $auth->role,
                        'status'   => 'login',
                        'bulan'    => (int) date('m'),
                        'tahun'    => date('Y'),
                    ];

                    $activityData = [
                        'user_id'  => $auth->user_id,
                        'activity' => 'Login Berhasil',
                        'times'    => date('Y-m-d H:i:s'),
                    ];

                    $this->loginModel->tambah('activity_log', $activityData);

                    session()->set($sessionData);
                    return redirect()->to(base_url('dashboard'));
                }
            } else {
                session()->setFlashdata('gagal', '<div class="text-center"><i class="fa fa-exclamation-circle"></i> Username atau password salah</div>');
                return redirect()->to(base_url('auth'));
            }
        }

        return redirect()->to(base_url('auth'));
    }

    public function ubah_password()
    {
        if (session()->get('status') !== 'login') {
            return redirect()->to(base_url('auth'));
        }

        return view('users/ubah_pass');
    }

    public function update_password()
    {
        if (session()->get('status') !== 'login') {
            return redirect()->to(base_url('auth'));
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $sessionId   = session()->get('user_id');
            $sessionPass = session()->get('userpass');

            $rules = [
                'o_userpass' => 'required|trim',
                'n_userpass' => 'required|trim|matches[c_userpass]',
                'c_userpass' => 'required|trim|matches[n_userpass]',
            ];

            $oUserpass = md5((string) $this->request->getPost('o_userpass'));
            $nUserpass = (string) $this->request->getPost('n_userpass');

            if ($this->validate($rules)) {
                if ($oUserpass === $sessionPass) {
                    $this->loginModel->ubahPassword(
                        ['user_id' => $sessionId],
                        ['userpass' => md5($nUserpass)]
                    );

                    $activityData = [
                        'user_id'  => $sessionId,
                        'activity' => 'Ubah Password Berhasil',
                        'times'    => date('Y-m-d H:i:s'),
                    ];

                    $this->loginModel->tambah('activity_log', $activityData);
                    $db->transCommit();
                    return redirect()->to(base_url('auth/logout'));
                }

                session()->setFlashdata('error1', 'Password lama salah!');
                return view('users/ubah_pass');
            }

            session()->setFlashdata('error', 'Terjadi kesalahan! Pastikan input anda benar!');
            return view('users/ubah_pass');
        } catch (\Throwable $th) {
            $db->transRollback();
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function logout()
    {
        $activityData = [
            'user_id'  => session()->get('user_id'),
            'activity' => 'Logout',
            'times'    => date('Y-m-d H:i:s'),
        ];

        if ($activityData['user_id']) {
            $this->loginModel->tambah('activity_log', $activityData);
        }

        session()->destroy();
        return redirect()->to(base_url('auth'));
    }
}

