<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RincianDanRangkuman extends CI_Model
{
    public function data($table)
    {
        return $this->db->query("SELECT m2_item.kode, m2_item.nama, id, kode_akun,tanggal, uraian, jumlah FROM m2_item JOIN $table ON m2_item.kode = $table.kode_akun ORDER BY $table.created_at DESC");
    }
    public function item($kode)
    {
        return $this->db->query("SELECT * FROM m2_item WHERE kode_parent != '" . $kode . "'");
    }
    public function tambah($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return true;
        }
        return false;
    }
    public function edit($table, $data, $where)
    {
        if ($this->db->update($table, $data, $where)) {
            return true;
        }
        return false;
    }
    public function hapus($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
