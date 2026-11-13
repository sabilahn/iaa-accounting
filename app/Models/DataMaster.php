<?php

namespace App\Models;

use CodeIgniter\Model;

class DataMaster extends Model
{
    public function jenis(): array
    {
        return $this->db->query('SELECT * FROM m1_jenis')->getResultArray();
    }

    public function item(): array
    {
        return $this->db->query('SELECT * FROM m2_item')->getResultArray();
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

