<?php

namespace App\Models;

use CodeIgniter\Model;

class NeracaModel extends Model
{
    public function data($bulan, $tahun): array
    {
        return $this->db->query(
            'SELECT * FROM v_neraca_mutasi WHERE bulan = ? AND tahun = ?',
            [$bulan, $tahun]
        )->getResultArray();
    }

    public function data_penyesuaian($bulan, $tahun): array
    {
        return $this->db->query(
            'SELECT * FROM v_neraca_penyesuaian WHERE bulan = ? AND tahun = ?',
            [$bulan, $tahun]
        )->getResultArray();
    }

    public function data_saldo($bulan, $tahun): array
    {
        return $this->db->query(
            'SELECT * FROM v_neraca_saldo WHERE bulan = ? AND tahun = ?',
            [$bulan, $tahun]
        )->getResultArray();
    }

    public function data_saldo_($bulan, $tahun): array
    {
        return $this->db->query(
            'SELECT * FROM v_neraca_saldo_ WHERE bulan = ? AND tahun = ?',
            [$bulan, $tahun]
        )->getResultArray();
    }

    public function jenis(): array
    {
        return $this->db->query('SELECT * FROM m1_jenis')->getResultArray();
    }

    public function cek($bulan, $tahun): array
    {
        return $this->db->query(
            'SELECT * FROM saldo WHERE bulan = ? AND tahun = ?',
            [$bulan, $tahun]
        )->getResultArray();
    }

    public function tambah(string $table, array $data): bool
    {
        return (bool) $this->db->table($table)->insert($data);
    }

    public function updateTable(string $table, array $data, array $where): bool
    {
        return (bool) $this->db->table($table)->where($where)->update($data);
    }
}

