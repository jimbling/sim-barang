<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelajaranModel extends Model
{
    protected $table = 'tbl_praktek_pembelajaran';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'nama_pembelajaran'];
    public function getPembelajaran()
    {
        return $this->findAll();
    }

    public function insertPembelajaran($data)
    {
        return $this->insert($data);
    }
    public function updatePembelajaran($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }
}
