<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'tbl_barang';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'kode_barang', 'nama_barang', 'slug', 'jumlah_barang', 'status_barang', 'kondisi_barang', 'disewakan', 'harga_sewa', 'created_at', 'updated_at', 'deleted_at'];


    public function getBarangDisewakan()
    {
        return $this->where(['disewakan' => 'Ya', 'status_barang' => 0])->findAll();
    }

    public function getDaftarBarangDisewakan()
    {
        return $this->where(['disewakan' => 'Ya'])->findAll();
    }

    public function getBarang()
    {
        return $this->findAll();
    }

    public function insertBarang($data)
    {
        return $this->insert($data);
    }
    public function updateBarang($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }

    public function groupByNamaBarang()
    {
        $query = $this->select('id, slug, nama_barang, kode_barang, SUM(jumlah_barang) as total_jumlah')
            ->where('status_barang', '0')
            ->where('kondisi_barang', 'baik') // Tambahkan kondisi where untuk kondisi_barang
            ->groupBy('slug')
            ->findAll();

        return $query;
    }

    public function getDetailBarangByNama($nama_barang)
    {
        return $this->where('nama_barang', $nama_barang)
            ->where('status_barang', 0) // Tambahkan kondisi ini
            ->findAll();
    }

    public function getDetailBarangBySlug($slug)
    {
        return $this->where('slug', $slug)
            ->where('status_barang', 0)
            ->findAll();
    }

    public function getBarangByStatus()
    {
        return $this->where('status_barang', 0)
            ->where('kondisi_barang', 'baik') // Tambahkan kondisi where untuk kondisi_barang
            ->findAll();
    }
    public function groupByNamaBarangRusak()
    {
        $query = $this->select('id, nama_barang, kode_barang, SUM(jumlah_barang) as total_jumlah')
            ->where('kondisi_barang', 'rusak') // Tambahkan kondisi where untuk kondisi_barang
            ->groupBy('nama_barang')
            ->findAll();

        return $query;
    }

    public function groupByNamaBarangDisewakan()
    {
        $query = $this->select('id, nama_barang, kode_barang, SUM(jumlah_barang) as total_jumlah')
            ->where('disewakan', 'Ya') // Tambahkan kondisi where untuk kondisi_barang
            ->groupBy('nama_barang')
            ->findAll();

        return $query;
    }

    public function hitungJumlahBarangRusak()
    {
        return $this->where('kondisi_barang', 'rusak')->countAllResults();
    }

    public function hitungJumlahBarangBaik()
    {
        return $this->where('kondisi_barang', 'baik')->countAllResults();
    }
}
