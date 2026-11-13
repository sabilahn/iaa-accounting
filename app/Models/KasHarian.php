<?php

namespace App\Models;

use CodeIgniter\Model;

class KasHarian extends Model
{
    public function dataKas(string $tanggal): array
    {
        return $this->db->query(
            "SELECT uang_masuk.kode_akun, uang_masuk.tanggal, uang_masuk.uraian, uang_masuk.jumlah, 0 as type
             FROM uang_masuk WHERE tanggal = ? AND kode_akun != ''
             UNION
             SELECT uang_keluar.kode_akun, uang_keluar.tanggal, uang_keluar.uraian, uang_keluar.jumlah, 1 as type
             FROM uang_keluar WHERE tanggal = ? AND kode_akun != ''",
            [$tanggal, $tanggal]
        )->getResultArray();
    }

    public function dataKas2(string $table, string $tanggal): array
    {
        return $this->db->table($table)->getWhere(['tanggal' => $tanggal])->getResultArray();
    }

    public function getJumlah(string $table, string $tanggal): ?object
    {
        return $this->db->query(
            "SELECT SUM(jumlah) as jumlah FROM {$table} WHERE tanggal <= ? AND kode_akun != ''",
            [$tanggal]
        )->getRow();
    }
}

