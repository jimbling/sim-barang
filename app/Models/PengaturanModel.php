<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table = 'tbl_pengaturan';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'nama_kampus', 'website', 'alamat', 'no_telp', 'email', 'nama_bank', 'no_rekening', 'atas_nama', 'ttd_1', 'nama_direktur', 'nik_dir', 'ttd_2', 'nama_laboran', 'nik_laboran', 'ttd_3', 'nama_ttd_3', 'id_ttd_3', 'ttd_4', 'nama_ttd_4', 'id_ttd_4', 'kop_surat', 'logo', 'favicon', 'logo_bank'];


    public function getPengaturan()
    {
        return $this->findAll();
    }

    public function insertPengaturan($data)
    {
        return $this->insert($data);
    }
    public function updatePengaturan($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }
    public function getDataById($id)
    {
        return $this->find($id); // Mengambil data berdasarkan ID
    }
}
