<?php

namespace App\Models;

use CodeIgniter\Model;

class RuanganModel extends Model
{
    protected $table = 'tbl_ruangan';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'nama_ruangan'];
    public function getRuangan()
    {
        return $this->findAll();
    }

    public function insertRuangan($data)
    {
        return $this->insert($data);
    }
    public function updateRuangan($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }
}
