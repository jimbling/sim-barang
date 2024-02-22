<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tbl_user';
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'user_nama', 'user_password', 'level', 'full_nama', 'created_at', 'updated_at'];

    public function get_data($username, $password)
    {
        $user = $this->where('user_nama', $username)->first();

        if ($user && password_verify($password, $user['user_password'])) {
            return $user;
        }

        return null;
    }



    public function get($id = null)
    {
        $this->db->from('tbl_user');
        if ($id != null) {
            $this->db->where('user_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function getUser()
    {
        return $this->findAll();
    }

    public function updateUser($akunId, $data)
    {
        return $this->db->table('tbl_user')
            ->where('id', $akunId) // Ubah 'user_id' menjadi 'id'
            ->update($data);
    }
}
