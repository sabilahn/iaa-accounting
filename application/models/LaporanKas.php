<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanKas extends CI_Model
{
    public function dataKas($tanggal)
    {
        return $this->db->query("SELECT uang_masuk.kode_akun, uang_masuk.tanggal, uang_masuk.uraian, uang_masuk.jumlah, 0 as type FROM uang_masuk WHERE tanggal = '" . $tanggal . "' UNION SELECT uang_keluar.kode_akun, uang_keluar.tanggal, uang_keluar.uraian, uang_keluar.jumlah, 1 as type FROM uang_keluar WHERE tanggal = '" . $tanggal . "'");
    }
    public function dataKas2($table, $tanggal)
    {
        return $this->db->get_where($table, array('tanggal' => $tanggal));
    }
}
