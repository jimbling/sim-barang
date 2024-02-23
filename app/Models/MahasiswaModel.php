<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'tbl_mhs';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'nim', 'nama_lengkap', 'created_at', 'deleted_at'];

    public function getMahasiswaByNim($nim)
    {
        return $this->where('nim', $nim)->findAll();
    }
    public function getMahasiswa()
    {
        return $this->findAll();
    }

    public function insertMahasiswa($data)
    {
        return $this->insert($data);
    }
    public function updateMahasiswa($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }

    public function searchMahasiswa($keyword)
    {
        // Lakukan pencarian berdasarkan $keyword
        return $this->like('nama_lengkap', $keyword)->findAll();
    }

    public function copyDataToUser($selectedIds)
    {
        // Ambil data berdasarkan ID yang dipilih
        $selectedData = $this->whereIn('id', $selectedIds)->findAll();

        // Lakukan iterasi untuk setiap data yang dipilih
        foreach ($selectedData as $data) {
            // Lakukan penyalinan data ke tabel tbl_user
            $userData = [
                'user_nama' => $data['nim'],
                'user_password' => password_hash($data['nim'], PASSWORD_DEFAULT), // Menggunakan password_hash untuk mengenkripsi password
                'full_nama' => $data['nama_lengkap'],
                'level' => 'User', // Tambahkan level "User" di sini
                'type' => 'Mahasiswa' // Tambahkan level "User" di sini
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
}
