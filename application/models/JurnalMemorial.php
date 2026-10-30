<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JurnalMemorial extends CI_Model
{
    public function data($bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM v_jurnal_memorial WHERE bulan = '" . $bulan . "' AND tahun = '" . $tahun . "'");
    }

    public function edit($table, $data, $where)
    {
        if ($this->db->update($table, $data, $where)) {
            return true;
        }
        return false;
    }
}
