<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tbl_user';
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'user_nama', 'user_password', 'level', 'full_nama', 'type', 'created_at', 'updated_at'];


    public function getUserIDByNimNik($nim_nik)
    {
        // Cari user berdasarkan nim/nik di kolom user_nama
        $user = $this->where('user_nama', $nim_nik)->first();

        // Jika user ditemukan, kembalikan user_id
        if ($user) {
            return $user['id'];
        }

        // Jika tidak ditemukan, kembalikan null
        return null;
    }

    public function getUserByType($type)
    {
        return $this->where('type', $type)->findAll();
    }

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
        return $this->whereNotIn('id', [1, 2])->findAll();
    }
    public function getAdminUser()
    {
        return $this->whereIn('id', [1, 2])->findAll();
    }

    // public function getUser()
    // {
    //     // Mengambil session
    //     $session = session();
    //     // Mengambil user_id dari session
    //     $userId = $session->get('id');

    //     // Jika user_id ada dalam session
    //     if ($userId) {
    //         // Mencari data berdasarkan user_id
    //         return $this->where('id', $userId)->findAll();
    //     } else {
    //         // Jika tidak ada user_id dalam session, kembalikan null atau data kosong sesuai kebutuhan
    //         return null; // atau return [];
    //     }
    // }

    public function updateUser($akunId, $data)
    {
        return $this->db->table('tbl_user')
            ->where('id', $akunId) // Ubah 'user_id' menjadi 'id'
            ->update($data);
    }
}
