<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Users extends BaseController
{
    protected LoginModel $loginModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }

    public function index()
    {
        return redirect()->to(base_url('users/list'));
    }

    public function list()
    {
        $data['title']     = 'IAA Accounting | Setting';
        $data['user_list'] = $this->loginModel->userList();

        foreach ($data['user_list'] as $i => $user) {
            $data['user_list'][$i]['action'] = '<span data-toggle="modal" data-target="#resetModal' . esc($user['user_id']) . '"><button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Kembalikan password"><i class="fas fa-sync"></i></button></span>';
        }

        return view('header', $data)
            . view('menu')
            . view('users/list', $data)
            . view('footer');
    }

    public function tambah()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'user_id'  => $this->request->getPost('id_user'),
                'username' => $this->request->getPost('username'),
                'userpass' => md5((string) $this->request->getPost('userpass')),
            ];

            $userAdd = $this->loginModel->tambah('user_account', $data);
            if (! $userAdd) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah User Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah User Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function reset()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $idUser  = $this->request->getPost('id_reset');
            $userAdd = $this->loginModel->ubahPassword(
                ['user_id' => $idUser],
                ['userpass' => md5('12345')]
            );

            if (! $userAdd) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Reset Password Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Password berhasil dikembalikan menjadi 12345');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Reset Password Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function activity()
    {
        $data['title']      = 'IAA Accounting | Setting';
        $data['activities'] = $this->loginModel->activityList();

        return view('header', $data)
            . view('menu')
            . view('users/activity', $data)
            . view('footer');
    }
}

