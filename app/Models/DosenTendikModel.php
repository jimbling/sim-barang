<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenTendikModel extends Model
{
    protected $table = 'tbl_dosen_tendik';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'nik', 'nama_lengkap', 'jabatan'];

    public function copyDataToUser($selectedIds)
    {
        // Ambil data berdasarkan ID yang dipilih
        $selectedData = $this->whereIn('id', $selectedIds)->findAll();

        // Lakukan iterasi untuk setiap data yang dipilih
        foreach ($selectedData as $data) {
            // Lakukan penyalinan data ke tabel tbl_user
            $userData = [
                'user_nama' => $data['nik'],
                'user_password' => password_hash($data['nik'], PASSWORD_DEFAULT), // Menggunakan password_hash untuk mengenkripsi password
                'full_nama' => $data['nama_lengkap'],
                'level' => 'User', // Tambahkan level "User" di sini
                'type' => 'Dosen_Tendik' // Tambahkan level "User" di sini
            ];

            // Masukkan data ke dalam tabel tbl_user
            // Pastikan model untuk tabel tbl_user telah dibuat dan disertakan pada file yang sesuai
            // Misalnya, jika model untuk tbl_user bernama UserModel, tambahkan ini di atas namespace:
            // use App\Models\UserModel;
            // Gantilah 'UserModel' dengan nama model yang sesuai
            $userModel = new UserModel(); // Sesuaikan dengan nama model yang digunakan
            $userModel->insert($userData);
        }
    }



    public function get_data($nik)
    {
        // Lakukan query berdasarkan NIK
        $query = $this->where('nik', $nik)
            ->first();

        return $query; // Kembalikan hasil query
    }

    public function getDosenTendikbyNik($nik)
    {
        return $this->where('nik', $nik)->findAll();
    }

    public function getDosenTendik()
    {
        return $this->findAll();
    }

    public function getDosen()
    {
        // Menampilkan data yang memiliki jabatan=Dosen
        return $this->where('jabatan', 'Dosen')->findAll();
    }

    public function insertDosenTendik($data)
    {
        return $this->insert($data);
    }
    public function updateDosenTendik($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }
}
