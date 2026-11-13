<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table      = 'user_account';
    protected $primaryKey = 'user_id';
    protected $returnType = 'array';

    public function loggedId()
    {
        return session()->get('user_id');
    }

    public function cekLogin(string $table, array $username, array $userpass)
    {
        $query = $this->db->table($table)
            ->select('*')
            ->where($username)
            ->where($userpass)
            ->limit(1)
            ->get();

        $results = $query->getResult();
        if (empty($results)) {
            return false;
        }

        return $results;
    }

    public function tambah(string $table, array $data): bool
    {
        return (bool) $this->db->table($table)->insert($data);
    }

    public function ubahPassword(array $where, array $data): bool
    {
        return (bool) $this->db->table('user_account')->where($where)->update($data);
    }

    public function userList(): array
    {
        return $this->db->query('SELECT * FROM user_account')->getResultArray();
    }

    public function activityList(): array
    {
        return $this->db->query('SELECT * FROM v_activity')->getResultArray();
    }
}

