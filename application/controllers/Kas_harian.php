<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kas_harian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('KasHarian');
        $this->load->model('NeracaModel');
        $this->load->model('LoginModel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        }
    }

    public function getSaldo2($start, $end)
    {

        $data_kas = array();
        $saldo = 0;

        while (strtotime($start) <= strtotime($end)) {

            $list_masuk = array();
            $list_keluar = array();

            $uang_masuk = $this->KasHarian->dataKas('uang_masuk', $start)->result_array();
            $uang_keluar = $this->KasHarian->dataKas('uang_keluar', $start)->result_array();

            foreach ($uang_masuk as $masuk) {
                array_push($list_masuk, [$masuk['kode_akun'], $masuk['uraian'], $masuk['jumlah']]);
            }

            foreach ($uang_keluar as $keluar) {
                array_push($list_keluar, [$keluar['kode_akun'], $keluar['uraian'], $keluar['jumlah']]);
            }

            if (count($list_masuk) > count($list_keluar)) {
                for ($i = 0; $i < count($list_masuk); $i++) {
                    if ($i < count($list_keluar)) {
                        $saldo += $list_masuk[$i][2] - $list_keluar[$i][2];
                        array_push($data_kas, [
                            $start, $list_masuk[$i][0], $list_masuk[$i][1], $list_masuk[$i][2],
                            $list_keluar[$i][0], $list_keluar[$i][1], $list_keluar[$i][2], $saldo
                        ]);
                    } else {
                        $saldo += $list_masuk[$i][2];
                        array_push($data_kas, [
                            $start, $list_masuk[$i][0], $list_masuk[$i][1], $list_masuk[$i][2],
                            '-', '-', '-', $saldo
                        ]);
                    }
                }
            } else {
                for ($i = 0; $i < count($list_keluar); $i++) {
                    if ($i < count($list_masuk)) {
                        $saldo += $list_masuk[$i][2] - $list_keluar[$i][2];
                        array_push($data_kas, [
                            $start, $list_masuk[$i][0], $list_masuk[$i][1], $list_masuk[$i][2],
                            $list_keluar[$i][0], $list_keluar[$i][1], $list_keluar[$i][2], $saldo
                        ]);
                    } else {
                        $saldo -= $list_keluar[$i][2];
                        array_push($data_kas, [
                            $start, '-', '-', '-',
                            $list_keluar[$i][0], $list_keluar[$i][1], $list_keluar[$i][2], $saldo
                        ]);
                    }
                }
            }
            $start = date("Y-m-d", strtotime("+1 day", strtotime($start)));
        }

        return $data_kas;
    }

    public function getJumlah($tanggal)
    {

        $kas_masuk = $this->KasHarian->getJumlah('uang_masuk', $tanggal)->row();
        $kas_keluar = $this->KasHarian->getJumlah('uang_keluar', $tanggal)->row();


        $saldo_awal = $kas_masuk->jumlah - $kas_keluar->jumlah;

        return $saldo_awal;
    }

    public function getSaldo($start, $end, $tanggal)
    {

        $data_kas = array();
        $saldo_awal = $this->getJumlah($tanggal);
        $saldo = $saldo_awal;

        while (strtotime($start) <= strtotime($end)) {

            $get_kas = $this->KasHarian->dataKas($start)->result_array();

            foreach ($get_kas as $kas) {
                if ($kas['type'] == 0) {
                    $saldo += $kas['jumlah'];
                    array_push($data_kas, [$start, $kas['kode_akun'], $kas['uraian'], $kas['jumlah'], '-', $saldo]);
                } else {
                    $saldo -= $kas['jumlah'];
                    array_push($data_kas, [$start, $kas['kode_akun'], $kas['uraian'], '-', $kas['jumlah'], $saldo]);
                }
            }

            $start = date("Y-m-d", strtotime("+1 day", strtotime($start)));
        }

        return array($saldo_awal, $data_kas);
    }

    public function getNamaBulan($bulan)
    {

        $nama = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        return $nama[$bulan];
    }

    public function index()
    {
        $data['title'] = 'Kas Harian';

        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $tanggal = '';

        if ($tahun == "" || $bulan == "") {
            $bulan = (int) date('m');
            $tahun = date('Y');
        }

        if ($bulan == 1) {
            $tanggal = ($tahun - 1) . '-12-31';
        } else {
            $tanggal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01' . '-1 day'));
        }

        $start = $tahun . '-' . $bulan . '-01';
        
        if ($bulan == 12) {
            $end = explode(' ', date('Y-m-d H:i:s', strtotime($tahun . '-12-31')))[0];
        } else {
            $end = explode(' ', date('Y-m-d H:i:s', strtotime($tahun . '-' . ($bulan + 1) . '-01' . '-1 day')))[0];
        }

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['nama_bulan'] = $this->getNamaBulan($bulan);
        $data['data_kas'] = $this->getSaldo($start, $end, $tanggal)[1];
        $data['saldo_awal'] = $this->getSaldo($start, $end, $tanggal)[0];
        $data['action'] = '<a target="_blank" href="' . site_url() . 'kas_harian/cetak/' . $start . '/' . $end . '" class="btn btn-default" data-target="_blank"><i class="fas fa-print"> Cetak</i></a>';

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('kas_harian/kas_harian', $data);
        $this->load->view('footer');
    }

    public function cetak($start, $end)
    {

        $data['title'] = 'Kas Harian';

        $tahun = explode('-', $end)[0];
        $bulan = explode('-', $end)[1];
        $tanggal = '';

        if ($bulan == 1) {
            $tanggal = ($tahun - 1) . '-12-31';
        } else {
            $tanggal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01' . '-1 day'));
        }

        $data['tahun'] = $tahun;
        $data['nama_bulan'] = $this->getNamaBulan((int)$bulan);

        $data['data_kas'] = $this->getSaldo($start, $end, $tanggal)[1];
        $data['saldo_awal'] = $this->getSaldo($start, $end, $tanggal)[0];

        $data['action'] = '<a target="blank" class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url() . 'kas_harian/konfersi/' . $start . '/' . $end . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url() . 'kas_harian/export/' . $start . '/' . $end . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        $this->load->view('kas_harian/cetak_kas_harian', $data);
    }

    public function konfersi($start, $end)
    {
        $tahun = explode('-', $end)[0];
        $bulan = explode('-', $end)[1];

        $tanggal = '';

        if ($bulan == 1) {
            $tanggal = ($tahun - 1) . '-12-31';
        } else {
            $tanggal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01' . '-1 day'));
        }

        $data['tahun'] = $tahun;
        $data['nama_bulan'] = $this->getNamaBulan((int)$bulan);

        $data['data_kas'] = $this->getSaldo($start, $end, $tanggal)[1];
        $data['saldo_awal'] = $this->getSaldo($start, $end, $tanggal)[0];

        $this->load->view('kas_harian/xls_kas_harian', $data);
    }
    public function export($start, $end)
    {
        $data['title'] = 'Kas Harian';

        $tahun = explode('-', $end)[0];
        $bulan = explode('-', $end)[1];

        $tanggal = '';

        if ($bulan == 1) {
            $tanggal = ($tahun - 1) . '-12-31';
        } else {
            $tanggal = date('Y-m-d H:i:s', strtotime($tahun . '-' . $bulan . '-01' . '-1 day'));
        }

        $data['tahun'] = $tahun;
        $data['nama_bulan'] = $this->getNamaBulan((int)$bulan);

        $data['data_kas'] = $this->getSaldo($start, $end, $tanggal)[1];
        $data['saldo_awal'] = $this->getSaldo($start, $end, $tanggal)[0];

        $this->load->library('cetak_pdf');

        $this->cetak_pdf->setPaper('A4', 'landscape');
        $this->cetak_pdf->filename = 'kas_harian_' . $tahun . '.pdf';
        $this->cetak_pdf->load_view('kas_harian/pdf-kas-harian', $data);
    }
}
