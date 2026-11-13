<?php

namespace App\Controllers;

use App\Libraries\CetakPdf;
use App\Models\LoginModel;
use App\Models\RugiLaba;

class Rugi_laba extends BaseController
{
    protected RugiLaba $rugiLaba;
    protected LoginModel $loginModel;

    public function __construct()
    {
        $this->rugiLaba   = new RugiLaba();
        $this->loginModel = new LoginModel();
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
        $data['title'] = 'Rugi Laba';

        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        if (empty($bulan) || empty($tahun)) {
            $bulan = (int) date('m');
            $tahun = date('Y');
        }

        $data['nama_bulan']     = $this->getNamaBulan($bulan);
        $data['bulan']          = $bulan;
        $data['tahun']          = $tahun;
        $data['data_rugi_laba'] = $this->rugiLaba->data($bulan, $tahun);
        $data['data_jumlah']    = $this->rugiLaba->jumlah($bulan, $tahun);
        $data['action']         = '<a target="_blank" class="btn btn-sm btn-default" href="' . site_url('rugi_laba/cetak/' . $bulan . '/' . $tahun) . '"><i class="fas fa-print"> Cetak</i></a>';

        return view('header', $data)
            . view('menu')
            . view('rugi_laba/rugi_laba', $data)
            . view('footer');
    }

    public function cetak($bulan, $tahun)
    {
        $data['title']          = 'Rugi Laba';
        $data['nama_bulan']     = $this->getNamaBulan($bulan);
        $data['bulan']          = $bulan;
        $data['tahun']          = $tahun;
        $data['data_rugi_laba'] = $this->rugiLaba->data($bulan, $tahun);
        $data['data_jumlah']    = $this->rugiLaba->jumlah($bulan, $tahun);
        $data['action']         = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url('rugi_laba/konfersi/' . $bulan . '/' . $tahun) . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url('rugi_laba/export/' . $bulan . '/' . $tahun) . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        $this->loginModel->tambah('activity_log', [
            'user_id'  => session()->get('user_id'),
            'activity' => 'Lihat Laporan Rugi Laba',
            'times'    => date('Y-m-d H:i:s'),
        ]);

        return view('rugi_laba/cetak_rugi_laba', $data);
    }

    public function konfersi($bulan, $tahun)
    {
        $data['nama_bulan']     = $this->getNamaBulan($bulan);
        $data['bulan']          = $bulan;
        $data['tahun']          = $tahun;
        $data['data_rugi_laba'] = $this->rugiLaba->data($bulan, $tahun);
        $data['data_jumlah']    = $this->rugiLaba->jumlah($bulan, $tahun);

        return view('rugi_laba/xls_rugi_laba', $data);
    }

    public function export($bulan, $tahun)
    {
        $data['title']          = 'Rugi Laba';
        $data['nama_bulan']     = $this->getNamaBulan($bulan);
        $data['bulan']          = $bulan;
        $data['tahun']          = $tahun;
        $data['data_rugi_laba'] = $this->rugiLaba->data($bulan, $tahun);
        $data['data_jumlah']    = $this->rugiLaba->jumlah($bulan, $tahun);

        $pdf = new CetakPdf();
        $pdf->setPaper('A4', 'landscape');
        $pdf->filename = 'rugi_laba_' . $bulan . '_' . $tahun . '.pdf';
        $pdf->loadView('rugi_laba/pdf-rugi-laba', $data);
    }
}

