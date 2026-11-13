<?php

namespace App\Models;

use CodeIgniter\Model;

class ArusKas extends Model
{
    public function data_kas_masuk($bulan, $tahun): array
    {
        return $this->db->query(
            'SELECT jenis, kode, nama, sum(penerimaan) as penerimaan
             FROM v_uang_masuk WHERE tahun = ? AND bulan = ? GROUP BY kode',
            [$tahun, $bulan]
        )->getResultArray();
    }

    public function data_kas_keluar($bulan, $tahun): array
    {
        return $this->db->query(
            'SELECT jenis, kode, nama, sum(pengeluaran) as pengeluaran
             FROM v_uang_keluar WHERE tahun = ? AND bulan = ? GROUP BY kode',
            [$tahun, $bulan]
        )->getResultArray();
    }

    public function jumlah_sebelumnya($bulan, $tahun): array
    {
        return $this->db->query(
            "SELECT (SELECT jumlah FROM v_saldo WHERE kode = '1001' AND tahun = ? AND bulan = ?) as penerimaan_sebelumnya",
            [$tahun, $bulan]
        )->getResultArray();
    }

    public function cek($bulan, $tahun): array
    {
        return $this->db->query(
            'SELECT * FROM jurnal_memorial WHERE tahun = ? AND bulan = ?',
            [$tahun, $bulan]
        )->getResultArray();
    }

    public function getAkun(): array
    {
        return $this->db->query('SELECT kode, nama FROM m2_item')->getResultArray();
    }

    public function getKasMasuk(string $kode, $bulan, $tahun): ?object
    {
        return $this->db->query(
            'SELECT nama, sum(penerimaan) as penerimaan
             FROM v_uang_masuk WHERE kode = ? AND tahun = ? AND bulan = ? GROUP BY kode',
            [$kode, $tahun, $bulan]
        )->getRow();
    }

    public function getKasKeluar(string $kode, $bulan, $tahun): ?object
    {
        return $this->db->query(
            'SELECT nama, sum(pengeluaran) as pengeluaran
             FROM v_uang_keluar WHERE kode = ? AND tahun = ? AND bulan = ? GROUP BY kode',
            [$kode, $tahun, $bulan]
        )->getRow();
    }

    public function getSumKasMasuk($bulan, $tahun): ?object
    {
        return $this->db->query(
            'SELECT nama, sum(penerimaan) as penerimaan
             FROM v_uang_masuk WHERE tahun = ? AND bulan = ?',
            [$tahun, $bulan]
        )->getRow();
    }

    public function getSumKasKeluar($bulan, $tahun): ?object
    {
        return $this->db->query(
            'SELECT nama, sum(pengeluaran) as pengeluaran
             FROM v_uang_keluar WHERE tahun = ? AND bulan = ?',
            [$tahun, $bulan]
        )->getRow();
    }

    public function tambah(string $table, array $data): bool
    {
        return (bool) $this->db->table($table)->insert($data);
    }

    public function updateJurnal(array $data, array $where): bool
    {
        return (bool) $this->db->table('jurnal_memorial')->where($where)->update($data);
    }
}

