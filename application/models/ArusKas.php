<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ArusKas extends CI_Model
{
    public function data_kas_masuk($bulan, $tahun)
    {
        return $this->db->query("SELECT jenis, kode, nama, sum(penerimaan) as penerimaan
        FROM v_uang_masuk WHERE tahun = '" . $tahun . "'
        AND bulan = '" . $bulan . "' GROUP BY kode");
    }
    public function data_kas_keluar($bulan, $tahun)
    {
        return $this->db->query("SELECT jenis, kode, nama, sum(pengeluaran) as pengeluaran
        FROM v_uang_keluar WHERE tahun = '" . $tahun . "'
        AND bulan = '" . $bulan . "' GROUP BY kode");
    }

    public function jumlah_sebelumnya($bulan, $tahun)
    {
        return $this->db->query("SELECT (SELECT jumlah FROM v_saldo
        WHERE kode = '1001' AND tahun = '" . $tahun . "' AND bulan = '" . $bulan . "') as penerimaan_sebelumnya");
    }

    public function cek($bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM jurnal_memorial WHERE tahun = '" . $tahun . "' AND bulan = '" . $bulan . "'");
    }

    public function getAkun()
    {
        return $this->db->query("SELECT kode, nama FROM m2_item")->result_array();
    }

    public function getKasMasuk($kode, $bulan, $tahun)
    {
        return $this->db->query("SELECT nama, sum(penerimaan) as penerimaan
        FROM v_uang_masuk WHERE kode = '" . $kode . "' AND tahun = '" . $tahun . "'
        AND bulan = '" . $bulan . "' GROUP BY kode")->row();
    }
    public function getKasKeluar($kode, $bulan, $tahun)
    {
        return $this->db->query("SELECT nama, sum(pengeluaran) as pengeluaran
        FROM v_uang_keluar WHERE kode = '" . $kode . "' AND tahun = '" . $tahun . "'
        AND bulan = '" . $bulan . "' GROUP BY kode")->row();
    }
    public function getSumKasMasuk($bulan, $tahun)
    {
        return $this->db->query("SELECT nama, sum(penerimaan) as penerimaan
        FROM v_uang_masuk WHERE tahun = '" . $tahun . "'
        AND bulan = '" . $bulan . "'")->row();
    }
    public function getSumKasKeluar($bulan, $tahun)
    {
        return $this->db->query("SELECT nama, sum(pengeluaran) as pengeluaran
        FROM v_uang_keluar WHERE tahun = '" . $tahun . "'
        AND bulan = '" . $bulan . "'")->row();
    }

    public function tambah($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return true;
        }
        return false;
    }
    public function update($data, $where)
    {
        if ($this->db->update('jurnal_memorial', $data, $where)) {
            return true;
        }
        return false;
    }
    public function cek_kas($data, $type)
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
}
