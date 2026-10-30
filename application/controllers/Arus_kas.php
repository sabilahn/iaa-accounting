<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arus_kas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ArusKas');
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
        $data['title'] = 'Arus Kas';

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        if ($bulan == "" || $tahun == "") {
            $bulan = (int) date('m');
            $tahun = date('Y');
        }

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['data_kas_masuk'] = $this->ArusKas->data_kas_masuk($bulan, $tahun)->result_array();
        $data['data_kas_keluar'] = $this->ArusKas->data_kas_keluar($bulan, $tahun)->result_array();

        $data['data_jumlah'] = $this->ArusKas->jumlah_sebelumnya($bulan, $tahun)->result_array();

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['action'] = '<a class="btn btn-sm btn-default" href="' . site_url() . 'arus_kas/simpan_jurnal/' . $bulan . '/' . $tahun . '"><i class="fas fa-save"> Simpan Pada Jurnal</i></a>
        <a target="_blank" class="btn btn-sm btn-default" href="' . site_url() . 'arus_kas/cetak/' . $bulan . '/' . $tahun . '"><i class="fas fa-print"> Cetak</i></a>';

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('arus_kas/arus_kas', $data);
        $this->load->view('footer');
    }

    public function cetak($bulan, $tahun)
    {
        $data['title'] = 'Arus Kas';

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        // var_dump($bulan);
        // die;

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['data_kas_masuk'] = $this->ArusKas->data_kas_masuk($bulan, $tahun)->result_array();
        $data['data_kas_keluar'] = $this->ArusKas->data_kas_keluar($bulan, $tahun)->result_array();

        $data['data_jumlah'] = $this->ArusKas->jumlah_sebelumnya($bulan, $tahun)->result_array();

        $data['action'] = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url() . 'arus_kas/konfersi/' . $bulan . '/' . $tahun . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url() . 'arus_kas/export/' . $bulan . '/' . $tahun . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        $this->load->view('arus_kas/cetak_arus_kas', $data);

        $activity_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'activity' => 'Lihat Laporan Arus Kas',
            'times' => date('Y-m-d H:i:s')
        );

        $this->LoginModel->tambah('activity_log', $activity_data);
    }

    public function konfersi($bulan, $tahun)
    {
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['data_kas_masuk'] = $this->ArusKas->data_kas_masuk($bulan, $tahun)->result_array();
        $data['data_kas_keluar'] = $this->ArusKas->data_kas_keluar($bulan, $tahun)->result_array();

        $data['data_jumlah'] = $this->ArusKas->jumlah_sebelumnya($bulan, $tahun)->result_array();

        $this->load->view('arus_kas/xls_arus_kas', $data);
    }

    public function export($bulan, $tahun)
    {
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['title'] = 'Arus Kas';

        $data['nama_bulan'] = $this->getNamaBulan($bulan);

        $data['data_kas_masuk'] = $this->ArusKas->data_kas_masuk($bulan, $tahun)->result_array();
        $data['data_kas_keluar'] = $this->ArusKas->data_kas_keluar($bulan, $tahun)->result_array();

        $data['data_jumlah'] = $this->ArusKas->jumlah_sebelumnya($bulan, $tahun)->result_array();

        $this->load->library('cetak_pdf');

        $this->cetak_pdf->setPaper('A4', 'landscape');
        $this->cetak_pdf->filename = 'arus_kas_' . $bulan . '_' . $tahun . '.pdf';
        $this->cetak_pdf->load_view('arus_kas/pdf-arus-kas', $data);
    }

    public function cek($data, $type)
    {
        if ($data == null) {
            return 0;
        } else {
            if ($type == 1) {
                return $data->penerimaan;
            } else {
                return $data->pengeluaran;
            }
        }
    }
    public function simpan_jurnal($bulan, $tahun)
    {
        $data_kas_masuk = $this->ArusKas->data_kas_masuk($bulan, $tahun)->result_array();
        $data_kas_keluar = $this->ArusKas->data_kas_keluar($bulan, $tahun)->result_array();

        $this->db->trans_begin();
        try {
            if ($data_kas_masuk || $data_kas_keluar) {
                $cek = $this->ArusKas->cek($bulan, $tahun)->result_array();

                $data_akun = $this->ArusKas->getAkun();

                if ($cek) {
                    foreach ($data_akun as $akun) {

                        if ($akun['kode'] == '1001') {
                            $kas_masuk = $this->ArusKas->getSumKasMasuk($bulan, $tahun);
                            $kas_keluar = $this->ArusKas->getSumKasKeluar($bulan, $tahun);

                            if ($kas_masuk == null) {
                                $kas_masuk = 0;
                            }
                            if ($kas_keluar == null) {
                                $kas_keluar = 0;
                            }

                            $data_update = [
                                'debet' => $this->cek($kas_masuk, 1),
                                'kredit' => $this->cek($kas_keluar, 2),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => $this->session->userdata('user_id')
                            ];

                            // var_dump($data_update);
                            // die;
                        } else {
                            $kas_masuk = $this->ArusKas->getKasMasuk($akun['kode'], $bulan, $tahun);
                            $kas_keluar = $this->ArusKas->getKasKeluar($akun['kode'], $bulan, $tahun);

                            $data_update = [
                                'debet' => $this->cek($kas_keluar, 2),
                                'kredit' => $this->cek($kas_masuk, 1),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => $this->session->userdata('user_id')
                            ];
                        }

                        $this->ArusKas->update($data_update, array('kode_akun' => $akun['kode'], 'bulan' => $bulan, 'tahun' => $tahun));
                    }
                } else if (!$cek) {
                    foreach ($data_akun as $akun) {

                        if ($akun['kode'] == '1001') {
                            $kas_masuk = $this->ArusKas->getSumKasMasuk($bulan, $tahun);
                            $kas_keluar = $this->ArusKas->getSumKasKeluar($bulan, $tahun);

                            if ($this->cek($kas_masuk, 1) == null) {
                                $jml_kas_masuk = 0;
                            } else {
                                $jml_kas_masuk = $this->cek($kas_masuk, 1);
                            }

                            if ($this->cek($kas_keluar, 2) == null) {
                                $jml_kas_keluar = 0;
                            } else {
                                $jml_kas_keluar = $this->cek($kas_keluar, 2);
                            }

                            $data_tambah = [
                                'kode_akun' => $akun['kode'],
                                'debet' => $jml_kas_masuk,
                                'kredit' => $jml_kas_keluar,
                                'bulan' => $bulan,
                                'tahun' => $tahun,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $this->session->userdata('user_id')
                            ];

                            $data_penyesuaian = [
                                'kode_akun' => $akun['kode'],
                                'debet' => 0,
                                'kredit' => 0,
                                'bulan' => $bulan,
                                'tahun' => $tahun,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $this->session->userdata('user_id')
                            ];

                        } else {
                            $kas_masuk = $this->ArusKas->getKasMasuk($akun['kode'], $bulan, $tahun);
                            $kas_keluar = $this->ArusKas->getKasKeluar($akun['kode'], $bulan, $tahun);

                            $data_tambah = [
                                'kode_akun' => $akun['kode'],
                                'debet' => $this->cek($kas_keluar, 2),
                                'kredit' => $this->cek($kas_masuk, 1),
                                'bulan' => $bulan,
                                'tahun' => $tahun,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $this->session->userdata('user_id')
                            ];

                            $data_penyesuaian = [
                                'kode_akun' => $akun['kode'],
                                'debet' => 0,
                                'kredit' => 0,
                                'bulan' => $bulan,
                                'tahun' => $tahun,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $this->session->userdata('user_id')
                            ];
                        }

                        $this->ArusKas->tambah('jurnal_memorial', $data_tambah);
                        $this->ArusKas->tambah('jurnal_penyesuaian',$data_penyesuaian);
                    }
                } else {
                    throw new Exception();
                }
                $activity_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'activity' => 'Simpan Jurnal Berhasil',
                    'times' => date('Y-m-d H:i:s')
                );

                $this->LoginModel->tambah('activity_log', $activity_data);

                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Sukses! Data berhasil disimpan.');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('error', 'Gagal! Tidak ada data pada bulan ini');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } catch (\Throwable $th) {
            $activity_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'activity' => 'Simpan Jurnal Gagal',
                'times' => date('Y-m-d H:i:s')
            );

            $this->LoginModel->tambah('activity_log', $activity_data);
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $th->getMessage());
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
