<?php

namespace App\Controllers;

use App\Libraries\CetakPdf;
use App\Models\LoginModel;
use App\Models\NeracaModel;
use App\Models\RugiLaba;

class Neraca extends BaseController
{
    protected NeracaModel $neracaModel;
    protected RugiLaba $rugiLaba;
    protected LoginModel $loginModel;

    public function __construct()
    {
        $this->neracaModel = new NeracaModel();
        $this->rugiLaba    = new RugiLaba();
        $this->loginModel  = new LoginModel();
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
        return redirect()->to(base_url('neraca/neraca_mutasi'));
    }

    private function resolvePeriod(): array
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        if (empty($bulan) || empty($tahun)) {
            $bulan = (int) date('m');
            $tahun = date('Y');
        }

        return [$bulan, $tahun];
    }

    public function neraca_mutasi()
    {
        $data['title'] = 'Neraca Mutasi';
        [$bulan, $tahun] = $this->resolvePeriod();

        $data['nama_bulan']    = $this->getNamaBulan($bulan);
        $data['bulan']         = $bulan;
        $data['tahun']         = $tahun;
        $data['neraca_mutasi'] = $this->neracaModel->data($bulan, $tahun);
        $data['action']        = '<a target="_blank" class="btn btn-sm btn-default" href="' . site_url('neraca/cetak_mutasi/' . $bulan . '/' . $tahun) . '"><i class="fas fa-print"> Cetak</i></a>';

        return view('header', $data)
            . view('menu')
            . view('neraca/neraca_mutasi', $data)
            . view('footer');
    }

    public function neraca_penyesuaian()
    {
        $data['title'] = 'Neraca Penyesuaian';
        [$bulan, $tahun] = $this->resolvePeriod();

        $data['nama_bulan']         = $this->getNamaBulan($bulan);
        $data['neraca_penyesuaian'] = $this->neracaModel->data_penyesuaian($bulan, $tahun);
        $data['action']             = '<a class="btn btn-sm btn-default" href="' . site_url('neraca/simpan_saldo/' . $bulan . '/' . $tahun) . '"><i class="fas fa-save"> Simpan Saldo Akhir</i></a>
        <a target="_blank" class="btn btn-sm btn-default" href="' . site_url('neraca/cetak_penyesuaian/' . $bulan . '/' . $tahun) . '"><i class="fas fa-print"> Cetak</i></a>';
        $data['bulan']              = $bulan;
        $data['tahun']              = $tahun;

        return view('header', $data)
            . view('menu')
            . view('neraca/neraca_penyesuaian', $data)
            . view('footer');
    }

    public function neraca_saldo()
    {
        $data['title'] = 'Neraca Saldo';
        [$bulan, $tahun] = $this->resolvePeriod();

        $data['nama_bulan']   = $this->getNamaBulan($bulan);
        $data['neraca_saldo'] = $this->neracaModel->data_saldo_($bulan, $tahun);
        $data['data_jumlah']  = $this->rugiLaba->jumlah($bulan, $tahun);
        $data['action']       = '<a target="_blank" class="btn btn-default" href="' . site_url('neraca/cetak_saldo/' . $bulan . '/' . $tahun) . '"><i class="fas fa-print"> Cetak</i></a>';
        $data['bulan']        = $bulan;
        $data['tahun']        = $tahun;

        return view('header', $data)
            . view('menu')
            . view('neraca/neraca_saldo', $data)
            . view('footer');
    }

    public function cetak_mutasi($bulan, $tahun)
    {
        $data['title']         = 'Neraca Mutasi';
        $data['nama_bulan']    = $this->getNamaBulan($bulan);
        $data['bulan']         = $bulan;
        $data['tahun']         = $tahun;
        $data['neraca_mutasi'] = $this->neracaModel->data($bulan, $tahun);
        $data['data_jenis']    = $this->neracaModel->jenis();
        $data['action']        = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url('neraca/konfersi_mutasi/' . $bulan . '/' . $tahun) . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url('neraca/export_mutasi/' . $bulan . '/' . $tahun) . '"><i class="fas fa-exchange-alt"> Konversi ke PDF</i></a>';

        return view('neraca/cetak_neraca_mutasi', $data);
    }

    public function cetak_penyesuaian($bulan, $tahun)
    {
        $data['title']              = 'Neraca Penyesuaian';
        $data['nama_bulan']         = $this->getNamaBulan($bulan);
        $data['bulan']              = $bulan;
        $data['tahun']              = $tahun;
        $data['neraca_penyesuaian'] = $this->neracaModel->data_penyesuaian($bulan, $tahun);
        $data['data_jenis']         = $this->neracaModel->jenis();
        $data['action']             = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url('neraca/konfersi_penyesuaian/' . $bulan . '/' . $tahun) . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url('neraca/export_penyesuaian/' . $bulan . '/' . $tahun) . '"><i class="fas fa-exchange-alt"> Konversi ke PDF</i></a>';

        return view('neraca/cetak_neraca_penyesuaian', $data);
    }

    public function cetak_saldo($bulan, $tahun)
    {
        $data['title']         = 'Neraca Saldo';
        $data['nama_bulan']    = $this->getNamaBulan($bulan);
        $data['bulan']         = $bulan;
        $data['tahun']         = $tahun;
        $data['neraca_mutasi'] = $this->neracaModel->data_saldo_($bulan, $tahun);
        $data['data_jenis']    = $this->neracaModel->jenis();
        $data['data_jumlah']   = $this->rugiLaba->jumlah($bulan, $tahun);
        $data['action']        = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url('neraca/konfersi_saldo/' . $bulan . '/' . $tahun) . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url('neraca/export_saldo/' . $bulan . '/' . $tahun) . '"><i class="fas fa-exchange-alt"> Konversi ke PDF</i></a>';

        return view('neraca/cetak_neraca_saldo', $data);
    }

    public function konfersi_mutasi($bulan, $tahun)
    {
        $data['nama_bulan']    = $this->getNamaBulan($bulan);
        $data['bulan']         = $bulan;
        $data['tahun']         = $tahun;
        $data['neraca_mutasi'] = $this->neracaModel->data($bulan, $tahun);
        $data['data_jenis']    = $this->neracaModel->jenis();

        return view('neraca/xls_neraca_mutasi', $data);
    }

    public function konfersi_penyesuaian($bulan, $tahun)
    {
        $data['nama_bulan']         = $this->getNamaBulan($bulan);
        $data['bulan']              = $bulan;
        $data['tahun']              = $tahun;
        $data['neraca_penyesuaian'] = $this->neracaModel->data_penyesuaian($bulan, $tahun);
        $data['data_jenis']         = $this->neracaModel->jenis();

        return view('neraca/xls_neraca_penyesuaian', $data);
    }

    public function konfersi_saldo($bulan, $tahun)
    {
        $data['nama_bulan']    = $this->getNamaBulan($bulan);
        $data['bulan']         = $bulan;
        $data['tahun']         = $tahun;
        $data['neraca_mutasi'] = $this->neracaModel->data_saldo_($bulan, $tahun);
        $data['data_jenis']    = $this->neracaModel->jenis();
        $data['data_jumlah']   = $this->rugiLaba->jumlah($bulan, $tahun);

        return view('neraca/xls_neraca_saldo', $data);
    }

    public function export_mutasi($bulan, $tahun)
    {
        $data['nama_bulan']    = $this->getNamaBulan($bulan);
        $data['bulan']         = $bulan;
        $data['tahun']         = $tahun;
        $data['title']         = 'Neraca Mutasi';
        $data['neraca_mutasi'] = $this->neracaModel->data($bulan, $tahun);
        $data['data_jenis']    = $this->neracaModel->jenis();

        $pdf = new CetakPdf();
        $pdf->setPaper('A4', 'landscape');
        $pdf->filename = 'neraca_mutasi_' . $bulan . '_' . $tahun . '.pdf';
        $pdf->loadView('neraca/pdf-neraca-mutasi', $data);
    }

    public function export_penyesuaian($bulan, $tahun)
    {
        $data['nama_bulan']         = $this->getNamaBulan($bulan);
        $data['bulan']              = $bulan;
        $data['tahun']              = $tahun;
        $data['title']              = 'Neraca Penyesuaian';
        $data['neraca_penyesuaian'] = $this->neracaModel->data_penyesuaian($bulan, $tahun);
        $data['data_jenis']         = $this->neracaModel->jenis();

        $pdf = new CetakPdf();
        $pdf->setPaper('A4', 'landscape');
        $pdf->filename = 'neraca_penyesuaian_' . $bulan . '_' . $tahun . '.pdf';
        $pdf->loadView('neraca/pdf-neraca-penyesuaian', $data);
    }

    public function export_saldo($bulan, $tahun)
    {
        $data['nama_bulan']    = $this->getNamaBulan($bulan);
        $data['bulan']         = $bulan;
        $data['tahun']         = $tahun;
        $data['title']         = 'Neraca Saldo';
        $data['neraca_mutasi'] = $this->neracaModel->data_saldo_($bulan, $tahun);
        $data['data_jenis']    = $this->neracaModel->jenis();
        $data['data_jumlah']   = $this->rugiLaba->jumlah($bulan, $tahun);

        $pdf = new CetakPdf();
        $pdf->setPaper('A4', 'landscape');
        $pdf->filename = 'neraca_saldo_' . $bulan . '_' . $tahun . '.pdf';
        $pdf->loadView('neraca/pdf-neraca-saldo', $data);
    }

    public function simpan_saldo($bulan, $tahun)
    {
        $dataNeraca = $this->neracaModel->data_penyesuaian($bulan, $tahun);

        if ((int) $bulan === 12) {
            $bulanAdd = 1;
            $tahunAdd = (int) $tahun + 1;
        } else {
            $bulanAdd = (int) $bulan + 1;
            $tahunAdd = (int) $tahun;
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            if ($dataNeraca) {
                $cek = $this->neracaModel->cek($bulanAdd, $tahunAdd);

                if ($cek) {
                    foreach ($dataNeraca as $neraca) {
                        $dataUpdate = [
                            'jumlah'     => $neraca['saldo_akhir'] ?: 0,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => session()->get('user_id'),
                        ];
                        $this->neracaModel->updateTable('saldo', $dataUpdate, ['kode_akun' => $neraca['kode'], 'bulan' => $bulanAdd, 'tahun' => $tahunAdd]);
                        $this->neracaModel->updateTable('saldo_neraca_saldo', $dataUpdate, ['kode_akun' => $neraca['kode'], 'bulan' => $bulan, 'tahun' => $tahun]);
                    }
                } else {
                    foreach ($dataNeraca as $neraca) {
                        $dataTambah = [
                            'kode_akun'  => $neraca['kode'],
                            'jumlah'     => $neraca['saldo_akhir'] ?: 0,
                            'type'       => $neraca['type'] ?: 0,
                            'bulan'      => $bulanAdd,
                            'tahun'      => $tahunAdd,
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => session()->get('user_id'),
                        ];
                        $this->neracaModel->tambah('saldo', $dataTambah);
                        $this->neracaModel->tambah('saldo_neraca_saldo', $dataTambah);
                    }
                }

                $this->loginModel->tambah('activity_log', [
                    'user_id'  => session()->get('user_id'),
                    'activity' => 'Simpan Saldo Berhasil',
                    'times'    => date('Y-m-d H:i:s'),
                ]);

                $db->transCommit();
                session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
                return redirect()->back();
            }

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Simpan Saldo Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            session()->setFlashdata('error', 'Gagal! Tidak dapat menyimpan data.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Simpan Saldo Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function update_penyesuaian()
    {
        $debet  = str_replace('.', '', (string) $this->request->getPost('jml_debet'));
        $kredit = str_replace('.', '', (string) $this->request->getPost('jml_kredit'));
        $kode   = $this->request->getPost('kode');
        $bulan  = $this->request->getPost('bulan');
        $tahun  = $this->request->getPost('tahun');

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $dataUpdate = [
                'debet'      => $debet,
                'kredit'     => $kredit,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('user_id'),
            ];
            $this->neracaModel->updateTable('jurnal_penyesuaian', $dataUpdate, ['kode_akun' => $kode, 'bulan' => $bulan, 'tahun' => $tahun]);

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Update Jurnal Penyesuaian Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function update_saldo()
    {
        $jmlShu = $this->request->getPost('jml_shu');
        $bulan  = $this->request->getPost('bulan');
        $tahun  = $this->request->getPost('tahun');

        if ((int) $bulan === 12) {
            $bulanUpdate = 1;
            $tahunUpdate = (int) $tahun + 1;
        } else {
            $bulanUpdate = (int) $bulan + 1;
            $tahunUpdate = (int) $tahun;
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $dataUpdate = [
                'jumlah'     => $jmlShu,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('user_id'),
            ];
            $this->neracaModel->updateTable('saldo', $dataUpdate, ['kode_akun' => '3004', 'bulan' => $bulanUpdate, 'tahun' => $tahunUpdate]);
            $this->neracaModel->updateTable('saldo_neraca_saldo', $dataUpdate, ['kode_akun' => '3004', 'bulan' => $bulanUpdate, 'tahun' => $tahunUpdate]);

            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Sesuaikan Saldo Berhasil',
                'times'    => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();
            session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }
}

