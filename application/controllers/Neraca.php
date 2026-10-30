<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Neraca extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('NeracaModel');
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
    }
    public function neraca_mutasi()
    {
        $data['title'] = 'Neraca Mutasi';

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        if ($bulan == "" || $tahun == "") {
            $bulan = (int) date('m');
            $tahun = date('Y');
        }

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;


        $data['neraca_mutasi'] = $this->NeracaModel->data($bulan, $tahun)->result_array();

        // $data['action'] = '<a class="btn btn-sm btn-default" href="' . site_url() . 'neraca/simpan_saldo/' . $bulan . '/' . $tahun . '"><i class="fas fa-save"> Simpan Saldo Akhir</i></a>
        // <a target="_blank" class="btn btn-sm btn-default" href="' . site_url() . 'neraca/cetak_mutasi/' . $bulan . '/' . $tahun . '"><i class="fas fa-print"> Cetak</i></a>';
        
        $data['action'] = '<a target="_blank" class="btn btn-sm btn-default" href="' . site_url() . 'neraca/cetak_mutasi/' . $bulan . '/' . $tahun . '"><i class="fas fa-print"> Cetak</i></a>';

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('neraca/neraca_mutasi', $data);
        $this->load->view('footer');
    }

    public function neraca_penyesuaian()
    {
        $data['title'] = 'Neraca Penyesuaian';

        if(!$this->input->post('bulan') && !$this->input->post('bulan')){
            $bulan = $_SESSION['bulan'];
            $tahun = $_SESSION['tahun'];    
        }else{
            $_SESSION['bulan'] = $_POST['bulan'];        
            $_SESSION['tahun'] = $_POST['tahun'];

            $bulan = $_SESSION['bulan'];
            $tahun = $_SESSION['tahun'];  
        }

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['neraca_penyesuaian'] = $this->NeracaModel->data_penyesuaian($bulan, $tahun)->result_array();

        $data['action'] = '<a class="btn btn-sm btn-default" href="' . site_url() . 'neraca/simpan_saldo/' . $bulan . '/' . $tahun . '"><i class="fas fa-save"> Simpan Saldo Akhir</i></a>
        <a target="_blank" class="btn btn-sm btn-default" href="' . site_url() . 'neraca/cetak_penyesuaian/' . $bulan . '/' . $tahun . '"><i class="fas fa-print"> Cetak</i></a>';

        $data['bulan'] = $_SESSION['bulan'];
        $data['tahun'] = $_SESSION['tahun'];
        
        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('neraca/neraca_penyesuaian', $data);
        $this->load->view('footer');
    }

    public function neraca_saldo()
    {
        $data['title'] = 'Neraca Saldo';

        if(!$this->input->post('bulan') && !$this->input->post('bulan')){
            $bulan = $_SESSION['bulan'];
            $tahun = $_SESSION['tahun'];    
        }else{
            $_SESSION['bulan'] = $_POST['bulan'];        
            $_SESSION['tahun'] = $_POST['tahun'];

            $bulan = $_SESSION['bulan'];
            $tahun = $_SESSION['tahun'];  
        }

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['neraca_saldo'] = $this->NeracaModel->data_saldo_($bulan, $tahun)->result_array();
        $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $data['action'] = '<a target="_blank" class="btn btn-default" href="' . site_url() . 'neraca/cetak_saldo/' . $bulan . '/' . $tahun . '"><i class="fas fa-print"> Cetak</i></a>';

        $data['bulan'] = $_SESSION['bulan'];
        $data['tahun'] = $_SESSION['tahun'];

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('neraca/neraca_saldo', $data);
        $this->load->view('footer');
    }

    public function cetak_mutasi($bulan, $tahun)
    {
        $data['title'] = 'Neraca Mutasi';

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['neraca_mutasi'] = $this->NeracaModel->data($bulan, $tahun)->result_array();
        $data['data_jenis'] = $this->NeracaModel->jenis()->result_array();

        $data['action'] = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url() . 'neraca/konfersi_mutasi/' . $bulan . '/' . $tahun . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url() . 'neraca/export_mutasi/' . $bulan . '/' . $tahun . '"><i class="fas fa-exchange-alt"> Konversi ke PDF</i></a>';

        $this->load->view('neraca/cetak_neraca_mutasi', $data);
    }

    public function cetak_penyesuaian($bulan, $tahun)
    {
        $data['title'] = 'Neraca Penyesuaian';

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['neraca_penyesuaian'] = $this->NeracaModel->data_penyesuaian($bulan, $tahun)->result_array();
        $data['data_jenis'] = $this->NeracaModel->jenis()->result_array();

        $data['action'] = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url() . 'neraca/konfersi_penyesuaian/' . $bulan . '/' . $tahun . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url() . 'neraca/export_penyesuaian/' . $bulan . '/' . $tahun . '"><i class="fas fa-exchange-alt"> Konversi ke PDF</i></a>';

        $this->load->view('neraca/cetak_neraca_penyesuaian', $data);
    }

    public function cetak_saldo($bulan, $tahun)
    {
        $data['title'] = 'Neraca Saldo';

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['neraca_mutasi'] = $this->NeracaModel->data_saldo_($bulan, $tahun)->result_array();
        $data['data_jenis'] = $this->NeracaModel->jenis()->result_array();
        $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $data['action'] = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url() . 'neraca/konfersi_saldo/' . $bulan . '/' . $tahun . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url() . 'neraca/export_saldo/' . $bulan . '/' . $tahun . '"><i class="fas fa-exchange-alt"> Konversi ke PDF</i></a>';

        $this->load->view('neraca/cetak_neraca_saldo', $data);

    }
    public function konfersi_mutasi($bulan, $tahun)
    {
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['neraca_mutasi'] = $this->NeracaModel->data($bulan, $tahun)->result_array();
        $data['data_jenis'] = $this->NeracaModel->jenis()->result_array();
        // $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $this->load->view('neraca/xls_neraca_mutasi', $data);
    }
    public function konfersi_penyesuaian($bulan, $tahun)
    {
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['neraca_penyesuaian'] = $this->NeracaModel->data_penyesuaian($bulan, $tahun)->result_array();
        $data['data_jenis'] = $this->NeracaModel->jenis()->result_array();
        // $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $this->load->view('neraca/xls_neraca_penyesuaian', $data);
    }
    public function konfersi_saldo($bulan, $tahun)
    {
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['neraca_mutasi'] = $this->NeracaModel->data_saldo_($bulan, $tahun)->result_array();
        $data['data_jenis'] = $this->NeracaModel->jenis()->result_array();
        $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $this->load->view('neraca/xls_neraca_saldo', $data);
    }
    public function export_mutasi($bulan, $tahun)
    {
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['title'] = 'Neraca Mutasi';

        $data['neraca_mutasi'] = $this->NeracaModel->data($bulan, $tahun)->result_array();
        $data['data_jenis'] = $this->NeracaModel->jenis()->result_array();
        // $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $this->load->library('cetak_pdf');

        $this->cetak_pdf->setPaper('A4', 'landscape');
        $this->cetak_pdf->filename = 'neraca_mutasi_' . $bulan . '_' . $tahun . '.pdf';
        $this->cetak_pdf->load_view('neraca/pdf-neraca-mutasi', $data);
    }
    public function export_penyesuaian($bulan, $tahun)
    {
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['title'] = 'Neraca Penyesuaian';

        $data['neraca_penyesuaian'] = $this->NeracaModel->data_penyesuaian($bulan, $tahun)->result_array();
        $data['data_jenis'] = $this->NeracaModel->jenis()->result_array();
        // $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $this->load->library('cetak_pdf');

        $this->cetak_pdf->setPaper('A4', 'landscape');
        $this->cetak_pdf->filename = 'neraca_penyesuaian_' . $bulan . '_' . $tahun . '.pdf';
        $this->cetak_pdf->load_view('neraca/pdf-neraca-penyesuaian', $data);
    }

    public function export_saldo($bulan, $tahun)
    {
        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['title'] = 'Neraca Saldo';

        $data['neraca_mutasi'] = $this->NeracaModel->data_saldo_($bulan, $tahun)->result_array();
        $data['data_jenis'] = $this->NeracaModel->jenis()->result_array();
        $data['data_jumlah'] = $this->RugiLaba->jumlah($bulan, $tahun)->result_array();

        $this->load->library('cetak_pdf');

        $this->cetak_pdf->setPaper('A4', 'landscape');
        $this->cetak_pdf->filename = 'neraca_saldo_' . $bulan . '_' . $tahun . '.pdf';
        $this->cetak_pdf->load_view('neraca/pdf-neraca-saldo', $data);
    }

    public function simpan_saldo($bulan, $tahun)
    {
        $data_neraca = $this->NeracaModel->data_penyesuaian($bulan, $tahun)->result_array();

        if ($bulan == '12') {
            $bulanAdd = 1;
            $tahunAdd = $tahun + 1;
        } else {
            $bulanAdd = $bulan + 1;
            $tahunAdd = $tahun;
        }

        $this->db->trans_begin();
        try {
            if ($data_neraca) {
                $cek = $this->NeracaModel->cek($bulanAdd, $tahunAdd)->result_array();

                if ($cek) {
                    foreach ($data_neraca as $neraca) {
                        $data_update = [
                            'jumlah' => $neraca['saldo_akhir'] ?: 0,
                            // 'type' => $neraca['type'] ?: 0,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => $this->session->userdata('user_id')
                        ];
                        $this->NeracaModel->update('saldo',$data_update, array('kode_akun' => $neraca['kode'], 'bulan' => $bulanAdd, 'tahun' => $tahunAdd));
                        $this->NeracaModel->update('saldo_neraca_saldo',$data_update, array('kode_akun' => $neraca['kode'], 'bulan' => $bulan, 'tahun' => $tahun));
                    }
                } else if (!$cek) {
                    foreach ($data_neraca as $neraca) {
                        $data_tambah = [
                            'kode_akun' => $neraca['kode'],
                            'jumlah' => $neraca['saldo_akhir'] ?: 0,
                            'type' => $neraca['type'] ?: 0,
                            'bulan' => $bulanAdd,
                            'tahun' => $tahunAdd,
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => $this->session->userdata('user_id')
                        ];

                        $this->NeracaModel->tambah('saldo', $data_tambah);
                        $this->NeracaModel->tambah('saldo_neraca_saldo', $data_tambah);
                    }
                } else {
                    throw new Exception();
                }

                $activity_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'activity' => 'Simpan Saldo Berhasil',
                    'times' => date('Y-m-d H:i:s')
                );

                $this->LoginModel->tambah('activity_log', $activity_data);

                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $activity_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'activity' => 'Simpan Saldo Gagal',
                    'times' => date('Y-m-d H:i:s')
                );

                $this->LoginModel->tambah('activity_log', $activity_data);
                $this->session->set_flashdata('error', 'Gagal! Tidak dapat menyimpan data.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();

            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Simpan Saldo Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->session->set_flashdata('error', $th->getMessage());
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function update_penyesuaian(){
        $debet = $_POST['jml_debet'];
        $kredit = $_POST['jml_kredit'];
        $kode = $_POST['kode'];
        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];

        $this->db->trans_begin();
        try {
            $data_update = [
                'debet' => $debet,
                'kredit' => $kredit,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id')
            ];
            $this->NeracaModel->update('jurnal_penyesuaian',$data_update, ['kode_akun' => $kode, 'bulan' => $bulan, 'tahun' => $tahun]);

            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Update Jurnal Penyesuaian Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $th->getMessage());
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    public function update_saldo()
    {
        $jml_shu = $this->input->post('jml_shu');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        // var_dump($jml_shu);
        // die;

        if ($bulan == '12') {
            $bulanUpdate = 1;
            $tahunUpdate = $tahun + 1;
        } else {
            $bulanUpdate = $bulan + 1;
            $tahunUpdate = $tahun;
        }

        $this->db->trans_begin();
        try {

            // if ($jml_shu != '0') {
            $data_update = [
                'jumlah' => $jml_shu,
                // 'type' => 'kredit',
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id')
            ];
            $this->NeracaModel->update('saldo',$data_update, array('kode_akun' => '3004', 'bulan' => $bulanUpdate, 'tahun' => $tahunUpdate));
            $this->NeracaModel->update('saldo_neraca_saldo',$data_update, array('kode_akun' => '3004', 'bulan' => $bulanUpdate, 'tahun' => $tahunUpdate));

            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Sesuaikan Saldo Berhasil',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
            redirect($_SERVER['HTTP_REFERER']);
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $th->getMessage());
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
