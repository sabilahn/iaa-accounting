<?php

namespace App\Controllers;

use App\Libraries\CetakPdf;
use App\Models\ArusKas;
use App\Models\LoginModel;

class Arus_kas extends BaseController
{
    protected ArusKas $arusKas;
    protected LoginModel $loginModel;

    public function __construct()
    {
        $this->arusKas    = new ArusKas();
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
        $data['title'] = 'Arus Kas';

        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        if (empty($bulan) || empty($tahun)) {
            $bulan = (int) date('m');
            $tahun = date('Y');
        }

        $data['nama_bulan']      = $this->getNamaBulan($bulan);
        $data['data_kas_masuk']  = $this->arusKas->data_kas_masuk($bulan, $tahun);
        $data['data_kas_keluar'] = $this->arusKas->data_kas_keluar($bulan, $tahun);
        $data['data_jumlah']     = $this->arusKas->jumlah_sebelumnya($bulan, $tahun);
        $data['bulan']           = $bulan;
        $data['tahun']           = $tahun;
        $data['action']          = '<a class="btn btn-sm btn-default" href="' . site_url('arus_kas/simpan_jurnal/' . $bulan . '/' . $tahun) . '"><i class="fas fa-save"> Simpan Pada Jurnal</i></a>
        <a target="_blank" class="btn btn-sm btn-default" href="' . site_url('arus_kas/cetak/' . $bulan . '/' . $tahun) . '"><i class="fas fa-print"> Cetak</i></a>';

        return view('header', $data)
            . view('menu')
            . view('arus_kas/arus_kas', $data)
            . view('footer');
    }

    public function cetak($bulan, $tahun)
    {
        $data['title']           = 'Arus Kas';
        $data['bulan']           = $bulan;
        $data['tahun']           = $tahun;
        $data['nama_bulan']      = $this->getNamaBulan($bulan);
        $data['data_kas_masuk']  = $this->arusKas->data_kas_masuk($bulan, $tahun);
        $data['data_kas_keluar'] = $this->arusKas->data_kas_keluar($bulan, $tahun);
        $data['data_jumlah']     = $this->arusKas->jumlah_sebelumnya($bulan, $tahun);
        $data['action']          = '<a class="btn btn-light" onclick="cetak()"><i class="fas fa-print"> Cetak</i></a>
        <a class="btn btn-light" id="konfersi" href="' . site_url('arus_kas/konfersi/' . $bulan . '/' . $tahun) . '"><i class="fas fa-exchange-alt"> Konversi ke XLS</i></a>
        <a target="_blank" class="btn btn-light" id="konfersi" href="' . site_url('arus_kas/export/' . $bulan . '/' . $tahun) . '"><i class="fas fa-file"> Konversi ke PDF</i></a>';

        $this->loginModel->tambah('activity_log', [
            'user_id'  => session()->get('user_id'),
            'activity' => 'Lihat Laporan Arus Kas',
            'times'    => date('Y-m-d H:i:s'),
        ]);

        return view('arus_kas/cetak_arus_kas', $data);
    }

    public function konfersi($bulan, $tahun)
    {
        $data['bulan']           = $bulan;
        $data['tahun']           = $tahun;
        $data['nama_bulan']      = $this->getNamaBulan($bulan);
        $data['data_kas_masuk']  = $this->arusKas->data_kas_masuk($bulan, $tahun);
        $data['data_kas_keluar'] = $this->arusKas->data_kas_keluar($bulan, $tahun);
        $data['data_jumlah']     = $this->arusKas->jumlah_sebelumnya($bulan, $tahun);

        return view('arus_kas/xls_arus_kas', $data);
    }

    public function export($bulan, $tahun)
    {
        $data['bulan']           = $bulan;
        $data['tahun']           = $tahun;
        $data['title']           = 'Arus Kas';
        $data['nama_bulan']      = $this->getNamaBulan($bulan);
        $data['data_kas_masuk']  = $this->arusKas->data_kas_masuk($bulan, $tahun);
        $data['data_kas_keluar'] = $this->arusKas->data_kas_keluar($bulan, $tahun);
        $data['data_jumlah']     = $this->arusKas->jumlah_sebelumnya($bulan, $tahun);

        $pdf = new CetakPdf();
        $pdf->setPaper('A4', 'landscape');
        $pdf->filename = 'arus_kas_' . $bulan . '_' . $tahun . '.pdf';
        $pdf->loadView('arus_kas/pdf-arus-kas', $data);
    }

    public function cek($data, int $type): float
    {
        if (empty($data) || ! is_object($data)) {
            return 0.0;
        }

        return ($type === 1)
            ? (float) ($data->penerimaan ?? 0)
            : (float) ($data->pengeluaran ?? 0);
    }

    public function simpan_jurnal($bulan, $tahun)
    {
        $dataKasMasuk  = $this->arusKas->data_kas_masuk($bulan, $tahun);
        $dataKasKeluar = $this->arusKas->data_kas_keluar($bulan, $tahun);

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            if ($dataKasMasuk || $dataKasKeluar) {
                $cek      = $this->arusKas->cek($bulan, $tahun);
                $dataAkun = $this->arusKas->getAkun();

                if ($cek) {
                    foreach ($dataAkun as $akun) {
                        if ($akun['kode'] == '1001') {
                            $kasMasuk  = $this->arusKas->getSumKasMasuk($bulan, $tahun);
                            $kasKeluar = $this->arusKas->getSumKasKeluar($bulan, $tahun);

                            $dataUpdate = [
                                'debet'      => $this->cek($kasMasuk, 1),
                                'kredit'     => $this->cek($kasKeluar, 2),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => session()->get('user_id'),
                            ];
                        } else {
                            $kasMasuk  = $this->arusKas->getKasMasuk($akun['kode'], $bulan, $tahun);
                            $kasKeluar = $this->arusKas->getKasKeluar($akun['kode'], $bulan, $tahun);

                            $dataUpdate = [
                                'debet'      => $this->cek($kasKeluar, 2),
                                'kredit'     => $this->cek($kasMasuk, 1),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => session()->get('user_id'),
                            ];
                        }

                        $this->arusKas->updateJurnal($dataUpdate, [
                            'kode_akun' => $akun['kode'],
                            'bulan'     => $bulan,
                            'tahun'     => $tahun,
                        ]);
                    }
                } else {
                    foreach ($dataAkun as $akun) {
                        if ($akun['kode'] == '1001') {
                            $kasMasuk  = $this->arusKas->getSumKasMasuk($bulan, $tahun);
                            $kasKeluar = $this->arusKas->getSumKasKeluar($bulan, $tahun);

                            $dataTambah = [
                                'kode_akun'  => $akun['kode'],
                                'debet'      => $this->cek($kasMasuk, 1),
                                'kredit'     => $this->cek($kasKeluar, 2),
                                'bulan'      => $bulan,
                                'tahun'      => $tahun,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => session()->get('user_id'),
                            ];
                        } else {
                            $kasMasuk  = $this->arusKas->getKasMasuk($akun['kode'], $bulan, $tahun);
                            $kasKeluar = $this->arusKas->getKasKeluar($akun['kode'], $bulan, $tahun);

                            $dataTambah = [
                                'kode_akun'  => $akun['kode'],
                                'debet'      => $this->cek($kasKeluar, 2),
                                'kredit'     => $this->cek($kasMasuk, 1),
                                'bulan'      => $bulan,
                                'tahun'      => $tahun,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => session()->get('user_id'),
                            ];
                        }

                        $dataPenyesuaian = [
                            'kode_akun'  => $akun['kode'],
                            'debet'      => 0,
                            'kredit'     => 0,
                            'bulan'      => $bulan,
                            'tahun'      => $tahun,
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => session()->get('user_id'),
                        ];

                        $this->arusKas->tambah('jurnal_memorial', $dataTambah);
                        $this->arusKas->tambah('jurnal_penyesuaian', $dataPenyesuaian);
                    }
                }

                $this->loginModel->tambah('activity_log', [
                    'user_id'  => session()->get('user_id'),
                    'activity' => 'Simpan Jurnal Berhasil',
                    'times'    => date('Y-m-d H:i:s'),
                ]);

                $db->transCommit();
                session()->setFlashdata('success', 'Sukses! Data berhasil disimpan.');
                return redirect()->back();
            }

            session()->setFlashdata('error', 'Gagal! Tidak ada data pada bulan ini');
            return redirect()->back();
        } catch (\Throwable $th) {
            $db->transRollback();
            $this->loginModel->tambah('activity_log', [
                'user_id'  => session()->get('user_id'),
                'activity' => 'Simpan Jurnal Gagal',
                'times'    => date('Y-m-d H:i:s'),
            ]);
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->back();
        }
    }
}

