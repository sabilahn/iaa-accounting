<?php

namespace App\Models;

use CodeIgniter\Model;

class JurnalMemorial extends Model
{
    public function data($bulan, $tahun): array
    {
        return $this->db->query(
            'SELECT * FROM v_jurnal_memorial WHERE bulan = ? AND tahun = ?',
            [$bulan, $tahun]
        )->getResultArray();
    }

    public function edit(string $table, array $data, array $where): bool
    {
        return (bool) $this->db->table($table)->where($where)->update($data);
    }
}

