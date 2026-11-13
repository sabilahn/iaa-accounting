<?php

namespace App\Controllers;

use App\Libraries\CetakPdf;
use App\Models\LaporanKas;
use App\Models\LoginModel;

class Laporan_kas extends BaseController
{
    protected LaporanKas $laporanKas;
    protected LoginModel $loginModel;

    public function __construct()
    {
        $this->laporanKas = new LaporanKas();
        $this->loginModel = new LoginModel();
    }

    public function getSaldo(string $start, string $end): array
    {
        $dataKas = [];
        $saldo   = 0.0;

        while (strtotime($start) <= strtotime($end)) {
            $getKas = $this->laporanKas->dataKas($start);

            foreach ($getKas as $kas) {
                if ((int) $kas['type'] === 0) {
                    $saldo += (float) $kas['jumlah'];
                    $dataKas[] = [$start, $kas['kode_akun'], $kas['uraian'], $kas['jumlah'], '-', $saldo];
                } else {
                    $saldo -= (float) $kas['jumlah'];
                    $dataKas[] = [$start, $kas['kode_akun'], $kas['uraian'], '-', $kas['jumlah'], $saldo];
                }
            }

            $start = date('Y-m-d', strtotime('+1 day', strtotime($start)));
        }

        return $dataKas;
    }

    public function index()
    {
        $data['title'] = 'Laporan Kas';
        $tahun         = $this->request->getPost('tahun');
        if (empty($tahun)) {
            $tahun = date('Y');
        }

        $start = $tahun . '-01-01';
        $end   = ($tahun != date('Y')) ? $tahun . '-12-31' : $tahun . '-' . date('m-d');

        $data['tahun']    = $tahun;
        $data['data_kas'] = $this->getSaldo($start, $end);
        $data['action']   = '<a target="_blank" href="' . site_url('laporan_kas/cetak/' . $start . '/' . $end) . '" class="btn btn-primary" data-target="_blank"><i class="fas fa-print"> Cetak</i></a>';

        return view('header', $data)
            . view('menu')
            . view('laporan_kas/laporan_kas', $data)
            . view('footer');
    }

    public function cetak(string $start, string $end)
    {
        $data['title']    = 'Laporan Kas';
        $data['tahun']    = explode('-', $end)[0];
        $data['data_kas'] = $this->getSaldo($start, $end);
        $data['action']   = '<a target="blank" class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url('laporan_kas/konfersi/' . $start . '/' . $end) . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url('laporan_kas/export/' . $start . '/' . $end) . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        $this->loginModel->tambah('activity_log', [
            'user_id'  => session()->get('user_id'),
            'activity' => 'Lihat Laporan Kas',
            'times'    => date('Y-m-d H:i:s'),
        ]);

        return view('laporan_kas/cetak_laporan_kas', $data);
    }

    public function konfersi(string $start, string $end)
    {
        $data['tahun']    = explode('-', $end)[0];
        $data['data_kas'] = $this->getSaldo($start, $end);

        return view('laporan_kas/xls_laporan_kas', $data);
    }

    public function export(string $start, string $end)
    {
        $data['title']    = 'Laporan Kas';
        $tahun            = explode('-', $end)[0];
        $data['tahun']    = $tahun;
        $data['data_kas'] = $this->getSaldo($start, $end);

        $pdf = new CetakPdf();
        $pdf->setPaper('A4', 'landscape');
        $pdf->filename = 'laporan_kas_' . $tahun . '.pdf';
        $pdf->loadView('laporan_kas/pdf-laporan-kas', $data);
    }
}

