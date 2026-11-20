<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\RincianDanRangkuman;

class Rincian_dan_rangkuman extends BaseController
{
    protected RincianDanRangkuman $rincianModel;
    protected LoginModel $loginModel;

    public function __construct()
    {
        $this->rincianModel = new RincianDanRangkuman();
        $this->loginModel   = new LoginModel();
    }

    public function index()
    {
        return redirect()->to(base_url('rincian_dan_rangkuman/uang_masuk'));
    }

    public function uang_masuk()
    {
        $data['title']           = 'Uang Masuk';
        $data['data_uang_masuk'] = $this->rincianModel->data('uang_masuk');
        $data['data_item']       = $this->rincianModel->item('50');

        foreach ($data['data_uang_masuk'] as $i => $uangMasuk) {
            $id = esc($uangMasuk['id']);
            $data['data_uang_masuk'][$i]['action'] = '<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal' . $id . '"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal' . $id . '"><i class="fa fa-trash"></i></button>';
        }

        return view('header', $data)
            . view('menu')
            . view('rincian_dan_rangkuman/uang_masuk', $data)
            . view('footer');
    }

    public function tambah_uang_masuk()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'kode_akun'  => $this->request->getPost('kode_masuk'),
                'tanggal'    => $this->request->getPost('tgl_masuk'),
                'uraian'     => $this->request->getPost('uraian_masuk'),
                'jumlah'     => str_replace('.', '', (string) $this->request->getPost('jml_masuk')),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => session()->get('user_id'),
            ];

            if (! $this->rincianModel->tambah('uang_masuk', $data)) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah Uang Masuk Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah Uang Masuk Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function ubah_uang_masuk()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'tanggal'    => $this->request->getPost('tgl_masuk_edt'),
                'uraian'     => $this->request->getPost('uraian_masuk_edt'),
                'jumlah'     => str_replace('.', '', (string) $this->request->getPost('jml_masuk_edt')),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('user_id'),
            ];

            if (! $this->rincianModel->edit('uang_masuk', $data, ['id' => $this->request->getPost('id_masuk_edt')])) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Uang Masuk Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Uang Masuk Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function hapus_uang_masuk()
    {
        $this->rincianModel->hapus('uang_masuk', ['id' => $this->request->getPost('id_masuk_hps')]);

        session()->setFlashdata('success', 'Sukses! Data berhasil dihapus.');

        $this->loginModel->tambah('activity_log', [
            'user_id'  => session()->get('user_id'),
            'activity' => 'Hapus Uang Masuk Berhasil',
            'times'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back();
    }

    public function uang_keluar()
    {
        $data['title']            = 'Uang Keluar';
        $data['data_uang_keluar'] = $this->rincianModel->data('uang_keluar');
        $data['data_item']        = $this->rincianModel->item('40');

        foreach ($data['data_uang_keluar'] as $i => $uangKeluar) {
            $id = esc($uangKeluar['id']);
            $data['data_uang_keluar'][$i]['action'] = '<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal' . $id . '"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal' . $id . '"><i class="fa fa-trash"></i></button>';
        }

        return view('header', $data)
            . view('menu')
            . view('rincian_dan_rangkuman/uang_keluar', $data)
            . view('footer');
    }

    public function tambah_uang_keluar()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'kode_akun'  => $this->request->getPost('kode_keluar'),
                'tanggal'    => $this->request->getPost('tgl_keluar'),
                'uraian'     => $this->request->getPost('uraian_keluar'),
                'jumlah'     => str_replace('.', '', (string) $this->request->getPost('jml_keluar')),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => session()->get('user_id'),
            ];

            if (! $this->rincianModel->tambah('uang_keluar', $data)) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah Uang Keluar Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Tambah Uang Keluar Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function ubah_uang_keluar()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'tanggal'    => $this->request->getPost('tgl_keluar_edt'),
                'uraian'     => $this->request->getPost('uraian_keluar_edt'),
                'jumlah'     => str_replace('.', '', (string) $this->request->getPost('jml_keluar_edt')),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('user_id'),
            ];

            if (! $this->rincianModel->edit('uang_keluar', $data, ['id' => $this->request->getPost('id_keluar_edt')])) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Uang Keluar Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Uang Keluar Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function hapus_uang_keluar()
    {
        $this->rincianModel->hapus('uang_keluar', ['id' => $this->request->getPost('id_keluar_hps')]);

        session()->setFlashdata('success', 'Sukses! Data berhasil dihapus.');
        $this->loginModel->tambah('activity_log', [
            'user_id'  => session()->get('user_id'),
            'activity' => 'Hapus Uang Keluar Berhasil',
            'times'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back();
    }
}

