<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranmurniModel extends Model
{
    protected $table = 'tbl_pengeluaran_murni';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $allowedFields = ['id', 'nama_pengguna_barang', 'tanggal_penggunaan', 'keperluan', 'created_at', 'updated_at'];




    public function getPengeluaranMurniById($id)
    {
        return $this->find($id);
    }

    public function getPengeluaranMurni()
    {
        // Menggunakan orderBy untuk mengurutkan berdasarkan kolom 'created_at' (ganti dengan kolom yang sesuai)
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function insertPengeluaranMurni($data)
    {
        return $this->insert($data);
    }
    public function updatePeminjamanBarang($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }

    public function hapus($id)
    {
        return $this->where('id', $id)->delete();
    }
    public function getUniqueYears()
    {
        return $this->distinct()->select('YEAR(tanggal_penggunaan) as tahun')->orderBy('tahun', 'ASC')->findAll();
    }
}
