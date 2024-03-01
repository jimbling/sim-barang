<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranmurniModel extends Model
{
    protected $table = 'tbl_pengeluaran_murni';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $allowedFields = ['id', 'user_id', 'nama_pengguna_barang', 'tanggal_penggunaan', 'keperluan', 'created_at', 'updated_at'];




    public function getPengeluaranMurniById($id)
    {
        return $this->find($id);
    }

    public function getPengeluaranMurni()
    {
        // Dapatkan user_id dari sesi
        $session = session();
        $user_id = $session->get('id');
        $user_level = $session->get('level');

        // Jika pengguna adalah admin, tampilkan semua data
        if ($user_level == 'Admin') {
            return $this->orderBy('created_at', 'DESC')->findAll();
        } else {
            // Filter berdasarkan user_id dari sesi
            return $this->orderBy('created_at', 'DESC')
                ->where('user_id', $user_id)
                ->findAll();
        }
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
