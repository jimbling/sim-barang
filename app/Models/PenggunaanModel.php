<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaanModel extends Model
{
    protected $table = 'tbl_penggunaan_barang';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'penggunaan'];
    public function getPenggunaan()
    {
        return $this->findAll();
    }

    public function insertPenggunaan($data)
    {
        return $this->insert($data);
    }
    public function updatePenggunaan($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }
}
