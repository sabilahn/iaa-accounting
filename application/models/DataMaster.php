<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataMaster extends CI_Model
{
    public function jenis()
    {
        return $this->db->query("SELECT * FROM m1_jenis");
    }
    public function item()
    {
        return $this->db->query("SELECT * FROM m2_item");
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
