<?php

namespace App\Controllers;

use App\Libraries\CetakPdf;
use App\Models\KasHarian;

class Kas_harian extends BaseController
{
    protected KasHarian $kasHarian;

    public function __construct()
    {
        $this->kasHarian = new KasHarian();
    }

    public function getJumlah(string $tanggal): float
    {
        $kasMasuk  = $this->kasHarian->getJumlah('uang_masuk', $tanggal);
        $kasKeluar = $this->kasHarian->getJumlah('uang_keluar', $tanggal);

        return (float) ($kasMasuk->jumlah ?? 0) - (float) ($kasKeluar->jumlah ?? 0);
    }

    public function getSaldo(string $start, string $end, string $tanggal): array
    {
        $dataKas   = [];
        $saldoAwal = $this->getJumlah($tanggal);
        $saldo     = $saldoAwal;

        while (strtotime($start) <= strtotime($end)) {
            $getKas = $this->kasHarian->dataKas($start);

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

        return [$saldoAwal, $dataKas];
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

    private function computeRange(int $bulan, int $tahun): array
    {
        if ($bulan === 1) {
            $tanggal = ($tahun - 1) . '-12-31';
        } else {
            $tanggal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 -1 day'));
        }

        $start = $tahun . '-' . $bulan . '-01';
        if ($bulan === 12) {
            $end = date('Y-m-d', strtotime($tahun . '-12-31'));
        } else {
            $end = date('Y-m-d', strtotime($tahun . '-' . ($bulan + 1) . '-01 -1 day'));
        }

        return [$start, $end, $tanggal];
    }

    public function index()
    {
        $data['title'] = 'Kas Harian';

        $tahun = $this->request->getPost('tahun');
        $bulan = $this->request->getPost('bulan');

        if (empty($tahun) || empty($bulan)) {
            $bulan = (int) date('m');
            $tahun = (int) date('Y');
        } else {
            $bulan = (int) $bulan;
            $tahun = (int) $tahun;
        }

        [$start, $end, $tanggal] = $this->computeRange($bulan, $tahun);
        [$saldoAwal, $dataKas]   = $this->getSaldo($start, $end, $tanggal);

        $data['tahun']      = $tahun;
        $data['bulan']      = $bulan;
        $data['nama_bulan'] = $this->getNamaBulan($bulan);
        $data['data_kas']   = $dataKas;
        $data['saldo_awal'] = $saldoAwal;
        $data['action']     = '<a target="_blank" href="' . site_url('kas_harian/cetak/' . $start . '/' . $end) . '" class="btn btn-default" data-target="_blank"><i class="fas fa-print"> Cetak</i></a>';

        return view('header', $data)
            . view('menu')
            . view('kas_harian/kas_harian', $data)
            . view('footer');
    }

    public function cetak(string $start, string $end)
    {
        $data['title'] = 'Kas Harian';

        $parts   = explode('-', $end);
        $tahun   = (int) $parts[0];
        $bulan   = (int) $parts[1];
        $tanggal = ($bulan === 1)
            ? ($tahun - 1) . '-12-31'
            : date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 -1 day'));

        [$saldoAwal, $dataKas] = $this->getSaldo($start, $end, $tanggal);

        $data['tahun']      = $tahun;
        $data['nama_bulan'] = $this->getNamaBulan($bulan);
        $data['data_kas']   = $dataKas;
        $data['saldo_awal'] = $saldoAwal;
        $data['action']     = '<a target="blank" class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url('kas_harian/konfersi/' . $start . '/' . $end) . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url('kas_harian/export/' . $start . '/' . $end) . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        return view('kas_harian/cetak_kas_harian', $data);
    }

    public function konfersi(string $start, string $end)
    {
        $parts   = explode('-', $end);
        $tahun   = (int) $parts[0];
        $bulan   = (int) $parts[1];
        $tanggal = ($bulan === 1)
            ? ($tahun - 1) . '-12-31'
            : date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 -1 day'));

        [$saldoAwal, $dataKas] = $this->getSaldo($start, $end, $tanggal);

        $data['tahun']      = $tahun;
        $data['nama_bulan'] = $this->getNamaBulan($bulan);
        $data['data_kas']   = $dataKas;
        $data['saldo_awal'] = $saldoAwal;

        return view('kas_harian/xls_kas_harian', $data);
    }

    public function export(string $start, string $end)
    {
        $data['title'] = 'Kas Harian';

        $parts   = explode('-', $end);
        $tahun   = (int) $parts[0];
        $bulan   = (int) $parts[1];
        $tanggal = ($bulan === 1)
            ? ($tahun - 1) . '-12-31'
            : date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01 -1 day'));

        [$saldoAwal, $dataKas] = $this->getSaldo($start, $end, $tanggal);

        $data['tahun']      = $tahun;
        $data['nama_bulan'] = $this->getNamaBulan($bulan);
        $data['data_kas']   = $dataKas;
        $data['saldo_awal'] = $saldoAwal;

        $pdf = new CetakPdf();
        $pdf->setPaper('A4', 'landscape');
        $pdf->filename = 'kas_harian_' . $tahun . '.pdf';
        $pdf->loadView('kas_harian/pdf-kas-harian', $data);
    }
}

