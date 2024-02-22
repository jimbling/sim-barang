<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenTendikModel extends Model
{
    protected $table = 'tbl_dosen_tendik';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'nik', 'nama_lengkap', 'jabatan'];


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
