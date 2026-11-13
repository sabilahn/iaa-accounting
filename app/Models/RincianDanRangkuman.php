<?php

namespace App\Models;

use CodeIgniter\Model;

class RincianDanRangkuman extends Model
{
    public function data(string $table): array
    {
        return $this->db->query(
            "SELECT m2_item.kode, m2_item.nama, id, kode_akun, tanggal, uraian, jumlah
             FROM m2_item
             JOIN {$table} ON m2_item.kode = {$table}.kode_akun
             ORDER BY {$table}.created_at DESC"
        )->getResultArray();
    }

    public function item(string $kode): array
    {
        return $this->db->query('SELECT * FROM m2_item WHERE kode_parent != ?', [$kode])->getResultArray();
    }

    public function tambah(string $table, array $data): bool
    {
        return (bool) $this->db->table($table)->insert($data);
    }

    public function edit(string $table, array $data, array $where): bool
    {
        return (bool) $this->db->table($table)->where($where)->update($data);
    }

    public function hapus(string $table, array $where): bool
    {
        return (bool) $this->db->table($table)->where($where)->delete();
    }
}

