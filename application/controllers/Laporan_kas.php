<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_kas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('LaporanKas');
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

            $uang_masuk = $this->LaporanKas->dataKas('uang_masuk', $start)->result_array();
            $uang_keluar = $this->LaporanKas->dataKas('uang_keluar', $start)->result_array();

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

    public function getSaldo($start, $end)
    {

        $data_kas = array();
        $saldo = 0;

        while (strtotime($start) <= strtotime($end)) {

            $get_kas = $this->LaporanKas->dataKas($start)->result_array();

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

        return $data_kas;
    }
    public function index()
    {
        $data['title'] = 'Laporan Kas';
        $tahun = $this->input->post('tahun');
        if ($tahun == "") {
            $tahun = date('Y');
        }

        $start = $tahun . '-01-01';
        if ($tahun != date('Y')) {
            $end = $tahun . '-12-31';
        } else {
            $end = $tahun . '-' . date('m-d');
        }

        $saldo_awal = $this->NeracaModel->cek(1, 2020)->row()->jumlah;


        $data['tahun'] = $tahun;
        $data['data_kas'] = $this->getSaldo($start, $end);
        $data['action'] = '<a target="_blank" href="' . site_url() . 'laporan_kas/cetak/' . $start . '/' . $end . '" class="btn btn-primary" data-target="_blank"><i class="fas fa-print"> Cetak</i></a>';

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('laporan_kas/laporan_kas', $data);
        $this->load->view('footer');
    }

    public function cetak($start, $end)
    {

        $data['title'] = 'Laporan Kas';

        $data['tahun'] = explode('-', $end)[0];

        $data['data_kas'] = $this->getSaldo($start, $end);

        $data['action'] = '<a target="blank" class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url() . 'laporan_kas/konfersi/' . $start . '/' . $end . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url() . 'laporan_kas/export/' . $start . '/' . $end . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        $this->load->view('laporan_kas/cetak_laporan_kas', $data);

        $activity_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'activity' => 'Lihat Laporan Kas',
            'times' => date('Y-m-d H:i:s')
        );

        $this->LoginModel->tambah('activity_log', $activity_data);
    }

    public function konfersi($start, $end)
    {
        $data['tahun'] = explode('-', $end)[0];

        $data['data_kas'] = $this->getSaldo($start, $end);

        $this->load->view('laporan_kas/xls_laporan_kas', $data);
    }
    public function export($start, $end)
    {
        $data['title'] = 'Laporan Kas';

        $tahun = explode('-', $end)[0];

        $data['tahun'] = $tahun;

        $data['data_kas'] = $this->getSaldo($start, $end);

        $this->load->library('cetak_pdf');

        $this->cetak_pdf->setPaper('A4', 'landscape');
        $this->cetak_pdf->filename = 'laporan_kas_' . $tahun . '.pdf';
        $this->cetak_pdf->load_view('laporan_kas/pdf-laporan-kas', $data);
    }
}
