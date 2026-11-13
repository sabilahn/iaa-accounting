<?php

namespace App\Models;

use CodeIgniter\Model;

class RugiLaba extends Model
{
    public function data($bulan, $tahun): array
    {
        return $this->db->query(
            "SELECT * FROM v_rugi_laba WHERE jenis IN ('40','50') AND bulan = ? AND tahun = ?",
            [$bulan, $tahun]
        )->getResultArray();
    }

    public function jumlah($bulan, $tahun): array
    {
        return $this->db->query(
            "SELECT (SELECT sum(jml_kredit) FROM v_rugi_laba WHERE jenis = '40' AND bulan = ? AND tahun = ?) AS pendapatan,
                    (SELECT sum(jml_debet) FROM v_rugi_laba WHERE jenis = '50' AND bulan = ? AND tahun = ?) AS biaya",
            [$bulan, $tahun, $bulan, $tahun]
        )->getResultArray();
    }
}

