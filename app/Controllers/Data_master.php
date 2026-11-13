<?php

namespace App\Controllers;

use App\Models\DataMaster;
use App\Models\LoginModel;

class Data_master extends BaseController
{
    protected DataMaster $dataMaster;
    protected LoginModel $loginModel;

    public function __construct()
    {
        $this->dataMaster = new DataMaster();
        $this->loginModel = new LoginModel();
    }

    public function index()
    {
        return redirect()->to(base_url('data_master/jenis_akun'));
    }

    public function jenis_akun()
    {
        $data['title']      = 'Jenis Akun';
        $data['data_jenis'] = $this->dataMaster->jenis();

        foreach ($data['data_jenis'] as $i => $jenis) {
            $kode = esc($jenis['kode']);
            $data['data_jenis'][$i]['action'] = '<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal' . $kode . '"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal' . $kode . '"><i class="fa fa-trash"></i></button>';
        }

        return view('header', $data)
            . view('menu')
            . view('data_master/jenis_akun', $data)
            . view('footer');
    }

    public function tambah_jenis()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'kode_parent' => $this->request->getPost('kode'),
                'kode'        => $this->request->getPost('kode_jenis'),
                'nama'        => $this->request->getPost('nama_jenis'),
                'created_at'  => date('Y-m-d H:i:s'),
                'created_by'  => session()->get('user_id'),
            ];

            $jenisAdd = $this->dataMaster->tambah('m1_jenis', $data);
            if (! $jenisAdd) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah Jenis Akun Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah Jenis Akun Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function ubah_jenis()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'kode_parent' => $this->request->getPost('kode_edt'),
                'kode'        => $this->request->getPost('kode_jenis_edt'),
                'nama'        => $this->request->getPost('nama_jenis_edt'),
                'updated_at'  => date('Y-m-d H:i:s'),
                'updated_by'  => session()->get('user_id'),
            ];

            $jenisEdt = $this->dataMaster->edit('m1_jenis', $data, ['kode' => $this->request->getPost('id_jenis')]);
            if (! $jenisEdt) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Jenis Akun Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Jenis Akun Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function hapus_jenis()
    {
        $idJenis = $this->request->getPost('id_jenis_hps');

        $this->dataMaster->hapus('m1_jenis', ['kode' => $idJenis]);

        $this->loginModel->tambah('activity_log', [
            'user_id'  => session()->get('user_id'),
            'activity' => 'Hapus Jenis Akun Berhasil',
            'times'    => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Sukses! Data berhasil dihapus.');
        return redirect()->back();
    }

    public function item_akun()
    {
        $data['title']      = 'Item Akun';
        $data['data_jenis'] = $this->dataMaster->jenis();
        $data['data_item']  = $this->dataMaster->item();

        foreach ($data['data_item'] as $i => $item) {
            $kode = esc($item['kode']);
            $data['data_item'][$i]['action'] = '<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal' . $kode . '"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal' . $kode . '"><i class="fa fa-trash"></i></button>';
        }

        return view('header', $data)
            . view('menu')
            . view('data_master/item_akun', $data)
            . view('footer');
    }

    public function tambah_item()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'kode_parent' => $this->request->getPost('kode'),
                'kode'        => $this->request->getPost('kode_item'),
                'nama'        => $this->request->getPost('nama_item'),
                'created_at'  => date('Y-m-d H:i:s'),
                'created_by'  => session()->get('user_id'),
            ];

            $itemAdd = $this->dataMaster->tambah('m2_item', $data);
            if (! $itemAdd) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah Item Akun Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah Item Akun Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function ubah_item()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'kode_parent' => $this->request->getPost('kode_edt'),
                'kode'        => $this->request->getPost('kode_item_edt'),
                'nama'        => $this->request->getPost('nama_item_edt'),
                'updated_at'  => date('Y-m-d H:i:s'),
                'updated_by'  => session()->get('user_id'),
            ];

            $itemEdt = $this->dataMaster->edit('m2_item', $data, ['kode' => $this->request->getPost('id_item')]);
            if (! $itemEdt) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Item Akun Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Item Akun Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function hapus_item()
    {
        $idItem = $this->request->getPost('id_item_hps');

        $this->dataMaster->hapus('m2_item', ['kode' => $idItem]);

        session()->setFlashdata('success', 'Sukses! Data berhasil dihapus.');

        $this->loginModel->tambah('activity_log', [
            'user_id'  => session()->get('user_id'),
            'activity' => 'Hapus Item Akun Berhasil',
            'times'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back();
    }
}

