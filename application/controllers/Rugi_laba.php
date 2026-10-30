<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rugi_laba extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('RugiLaba');
        $this->load->model('LoginModel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        }
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
        $data['title'] = 'Rugi Laba';

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        if ($bulan == "" || $tahun == "") {
            $bulan = (int) date('m');
            $tahun = date('Y');
        }

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['data_rugi_laba'] = $this->RugiLaba->data($bulan, $tahun)->result_array();
        $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $data['action'] = '<a target="_blank" class="btn btn-sm btn-default" href="' . site_url() . 'rugi_laba/cetak/' . $bulan . '/' . $tahun . '"><i class="fas fa-print"> Cetak</i></a>';

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('rugi_laba/rugi_laba', $data);
        $this->load->view('footer');
    }
    public function cetak($bulan, $tahun)
    {
        $data['title'] = 'Rugi Laba';

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['data_rugi_laba'] = $this->RugiLaba->data($bulan, $tahun)->result_array();
        $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $data['action'] = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url() . 'rugi_laba/konfersi/' . $bulan . '/' . $tahun . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url() . 'rugi_laba/export/' . $bulan . '/' . $tahun . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        $this->load->view('rugi_laba/cetak_rugi_laba', $data);

        $activity_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'activity' => 'Lihat Laporan Rugi Laba',
            'times' => date('Y-m-d H:i:s')
        );

        $this->LoginModel->tambah('activity_log', $activity_data);
    }
    public function konfersi($bulan, $tahun)
    {
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['data_rugi_laba'] = $this->RugiLaba->data($bulan, $tahun)->result_array();
        $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $this->load->view('rugi_laba/xls_rugi_laba', $data);
    }
    public function export($bulan, $tahun)
    {
        $data['title'] = 'Rugi Laba';
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['data_rugi_laba'] = $this->RugiLaba->data($bulan, $tahun)->result_array();
        $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $this->load->library('cetak_pdf');

        $this->cetak_pdf->setPaper('A4', 'landscape');
        $this->cetak_pdf->filename = 'rugi_laba_' . $bulan . '_' . $tahun . '.pdf';
        $this->cetak_pdf->load_view('rugi_laba/pdf-rugi-laba', $data);
    }
}
