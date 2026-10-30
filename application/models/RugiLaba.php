<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RugiLaba extends CI_Model
{
    public function data($bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM v_rugi_laba where jenis in ('40','50') AND bulan = '" . $bulan . "' AND tahun = '" . $tahun . "'");
    }
    public function jumlah($bulan, $tahun)
    {
        return $this->db->query("SELECT (SELECT sum(jml_kredit) FROM v_rugi_laba WHERE jenis = '40' and bulan = '" . $bulan . "' and tahun = '" . $tahun . "') as pendapatan,
        (SELECT sum(jml_debet) FROM v_rugi_laba WHERE jenis = '50' and bulan = '" . $bulan . "' and tahun = '" . $tahun . "') as biaya");
    }
}
