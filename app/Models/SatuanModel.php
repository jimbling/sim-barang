<?php

namespace App\Models;

use CodeIgniter\Model;

class SatuanModel extends Model
{
    protected $table = 'tbl_satuan';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'nama_satuan'];


    public function getSatuan()
    {
        return $this->findAll();
    }

    public function insertSatuan($data)
    {
        return $this->insert($data);
    }
    public function updateSatuan($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }
}
