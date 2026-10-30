<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NeracaModel extends CI_Model
{
    public function data($bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM v_neraca_mutasi WHERE bulan = '" . $bulan . "' AND tahun = '" . $tahun . "'");
    }
    public function data_penyesuaian($bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM v_neraca_penyesuaian WHERE bulan = '" . $bulan . "' AND tahun = '" . $tahun . "'");
    }
    public function data_saldo($bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM v_neraca_saldo WHERE bulan = '" . $bulan . "' AND tahun = '" . $tahun . "'");
    }
    public function data_saldo_($bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM v_neraca_saldo_ WHERE bulan = '" . $bulan . "' AND tahun = '" . $tahun . "'");
    }
    public function jenis()
    {
        return $this->db->query("SELECT * FROM m1_jenis");
    }
    public function cek($bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM saldo WHERE bulan ='" . $bulan . "' AND tahun = '" . $tahun . "'");
    }
    public function tambah($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return true;
        }
        return false;
    }
    public function update($table, $data, $where)
    {
        if ($this->db->update($table, $data, $where)) {
            return true;
        }
        return false;
    }
}
