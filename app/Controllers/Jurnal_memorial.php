<?php

namespace App\Controllers;

use App\Libraries\CetakPdf;
use App\Models\JurnalMemorial;
use App\Models\LoginModel;

class Jurnal_memorial extends BaseController
{
    protected JurnalMemorial $jurnalMemorial;
    protected LoginModel $loginModel;

    public function __construct()
    {
        $this->jurnalMemorial = new JurnalMemorial();
        $this->loginModel     = new LoginModel();
    }

    public function getNamaBulan(int|string $bulan): string
    {
        $nama = [
            '1'  => 'Januari',
            '2'  => 'Februari',
            '3'  => 'Maret',
            '4'  => 'April',
            '5'  => 'Mei',
            '6'  => 'Juni',
            '7'  => 'Juli',
            '8'  => 'Agustus',
            '9'  => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        return $nama[(string) (int) $bulan] ?? '';
    }

    public function index()
    {
        $data['title'] = 'Jurnal Memorial';

        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        if (empty($bulan) || empty($tahun)) {
            $bulan = (int) date('m');
            $tahun = date('Y');
        }

        $data['nama_bulan']  = $this->getNamaBulan($bulan);
        $data['bulan']       = $bulan;
        $data['tahun']       = $tahun;
        $data['data_jurnal'] = $this->jurnalMemorial->data($bulan, $tahun);
        $data['action']      = '<a target="_blank" class="btn btn-default" href="' . site_url('jurnal_memorial/cetak/' . $bulan . '/' . $tahun) . '"><i class="fas fa-print"> Cetak</i></a>';

        return view('header', $data)
            . view('menu')
            . view('jurnal_memorial/jurnal_memorial', $data)
            . view('footer');
    }

    public function ubah_debet()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'debet'      => $this->request->getPost('jml_debet_edt'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('user_id'),
            ];

            if (! $this->jurnalMemorial->edit('jurnal_memorial', $data, ['id' => $this->request->getPost('id_debet_edt')])) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Jurnal Debet Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Jurnal Debet Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function ubah_kredit()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $data = [
                'kredit'     => $this->request->getPost('jml_kredit_edt'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('user_id'),
            ];

            if (! $this->jurnalMemorial->edit('jurnal_memorial', $data, ['id' => $this->request->getPost('id_kredit_edt')])) {
                throw new \Exception('Failed');
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Jurnal Kredit Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Ubah Jurnal Kredit Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back();
        }
    }

    public function cetak($bulan, $tahun)
    {
        $data['title']       = 'Jurnal Memorial';
        $data['nama_bulan']  = $this->getNamaBulan($bulan);
        $data['bulan']       = $bulan;
        $data['tahun']       = $tahun;
        $data['data_jurnal'] = $this->jurnalMemorial->data($bulan, $tahun);
        $data['action']      = '<a target="blank" class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url('jurnal_memorial/konfersi/' . $bulan . '/' . $tahun) . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url('jurnal_memorial/export/' . $bulan . '/' . $tahun) . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        return view('jurnal_memorial/cetak_jurnal_memorial', $data);
    }

    public function konfersi($bulan, $tahun)
    {
        $data['nama_bulan']  = $this->getNamaBulan($bulan);
        $data['bulan']       = $bulan;
        $data['tahun']       = $tahun;
        $data['data_jurnal'] = $this->jurnalMemorial->data($bulan, $tahun);

        return view('jurnal_memorial/xls_jurnal_memorial', $data);
    }

    public function export($bulan, $tahun)
    {
        $data['nama_bulan']  = $this->getNamaBulan($bulan);
        $data['bulan']       = $bulan;
        $data['tahun']       = $tahun;
        $data['title']       = 'Jurnal Memorial';
        $data['data_jurnal'] = $this->jurnalMemorial->data($bulan, $tahun);

        $pdf = new CetakPdf();
        $pdf->setPaper('A4', 'landscape');
        $pdf->filename = 'jurnal_memorial_' . $bulan . '_' . $tahun . '.pdf';
        $pdf->loadView('jurnal_memorial/pdf-jurnal-memorial', $data);
    }
}

