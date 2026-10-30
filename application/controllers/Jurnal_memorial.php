<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal_memorial extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('JurnalMemorial');
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

        $data['title'] = 'Jurnal Memorial';

        // $data['tahun'] = $tahun;

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        if ($bulan == "" || $tahun == "") {
            $bulan = (int) date('m');
            $tahun = date('Y');
        }


        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['data_jurnal'] = $this->JurnalMemorial->data($bulan, $tahun)->result_array();

        $data['action'] = '<a target="_blank" class="btn btn-default" href="' . site_url() . 'jurnal_memorial/cetak/' . $bulan . '/' . $tahun . '"><i class="fas fa-print"> Cetak</i></a>';

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('jurnal_memorial/jurnal_memorial', $data);
        $this->load->view('footer');
    }

    public function ubah_debet()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'debet' => $_POST['jml_debet_edt'],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id')
            ];

            $debet_edt = $this->JurnalMemorial->edit('jurnal_memorial', $data, array('id' => $_POST['id_debet_edt']));
            if (!$debet_edt) {
                throw new \Exception('Failed');
            }

            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Jurnal Debet Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Jurnal Debet Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);

            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function ubah_kredit()
    {
        $this->db->trans_begin();
        try {
            $data = [
                'kredit' => $_POST['jml_kredit_edt'],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id')
            ];

            $kredit_edt = $this->JurnalMemorial->edit('jurnal_memorial', $data, array('id' => $_POST['id_kredit_edt']));
            if (!$kredit_edt) {
                throw new \Exception('Failed');
            }

            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Jurnal Kredit Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Ubah Jurnal Kredit Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function cetak($bulan, $tahun)
    {
        $data['title'] = 'Jurnal Memorial';

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['data_jurnal'] = $this->JurnalMemorial->data($bulan, $tahun)->result_array();

        $data['action'] = '<a target="blank" class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url() . 'jurnal_memorial/konfersi/' . $bulan . '/' . $tahun . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url() . 'jurnal_memorial/export/' . $bulan . '/' . $tahun . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        $this->load->view('jurnal_memorial/cetak_jurnal_memorial', $data);
    }

    public function konfersi($bulan, $tahun)
    {
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['data_jurnal'] = $this->JurnalMemorial->data($bulan, $tahun)->result_array();

        $this->load->view('jurnal_memorial/xls_jurnal_memorial', $data);
    }
    public function export($bulan, $tahun)
    {
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['title'] = 'Jurnal Memorial';

        $data['data_jurnal'] = $this->JurnalMemorial->data($bulan, $tahun)->result_array();

        $this->load->library('cetak_pdf');

        $this->cetak_pdf->setPaper('A4', 'landscape');
        $this->cetak_pdf->filename = 'jurnal_memorial_' . $bulan . '_' . $tahun . '.pdf';
        $this->cetak_pdf->load_view('jurnal_memorial/pdf-jurnal-memorial', $data);
    }
}
