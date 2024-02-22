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
}
