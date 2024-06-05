<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranmurniDetailModel extends Model
{
    protected $table = 'tbl_pengeluaran_murni_detail';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'barang_id', 'pengguna_id', 'ambil_barang_murni', 'harga_satuan', 'jumlah_harga'];

    public function getDataPermintaanByPenggunaId($penggunaId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_pengeluaran_murni_detail.*, tbl_persediaan_barang.nama_barang');
        $builder->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_murni_detail.barang_id');
        $builder->where('tbl_pengeluaran_murni_detail.pengguna_id', $penggunaId);

        $query = $builder->get();

        return $query->getResult();
    }

    public function getDataPengeluaranMurniByPenggunaId($penggunaId)
    {
        $builder = $this->db->table('tbl_pengeluaran_murni');
        $builder->select('tbl_pengeluaran_murni.*, tbl_pengeluaran_murni_detail.nama_pengguna_barang, tbl_pengeluaran_murni_detail.tanggal_penggunaan, tbl_pengeluaran_murni_detail.keperluan');
        $builder->join('tbl_pengeluaran_murni_detail', 'tbl_pengeluaran_murni_detail.pengguna_id = tbl_pengeluaran_murni.id');
        $builder->where('tbl_pengeluaran_murni_detail.pengguna_id', $penggunaId);

        $query = $builder->get();

        return $query->getResult();
    }

    public function getDataDetailPermintaanByPenggunaId($penggunaId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_pengeluaran_murni_detail.*, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.satuan, tbl_pengeluaran_murni.nama_pengguna_barang, tbl_pengeluaran_murni.tanggal_penggunaan, tbl_pengeluaran_murni.keperluan');
        $builder->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_murni_detail.barang_id');
        $builder->join('tbl_pengeluaran_murni', 'tbl_pengeluaran_murni.id = tbl_pengeluaran_murni_detail.pengguna_id');
        $builder->where('tbl_pengeluaran_murni_detail.pengguna_id', $penggunaId);

        $query = $builder->get();

        return $query->getResult();
    }


    public function getDetailWithNamaBarang($penggunaId)
    {
        $builder = $this->db->table('tbl_pengeluaran_murni_detail');
        $builder->select('tbl_pengeluaran_murni_detail.*, tbl_persediaan_barang.nama_barang, tbl_pengeluaran_murni_detail.id as detail_id');
        $builder->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_murni_detail.barang_id');
        $builder->where('tbl_pengeluaran_murni_detail.pengguna_id', $penggunaId);

        return $builder->get()->getResult();
    }

    public function getBarangData($barangId)
    {
        return $this->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_murni_detail.barang_id')
            ->where('tbl_pengeluaran_murni_detail.barang_id', $barangId)
            ->get()
            ->getRowArray();
    }

    public function getPengeluaranByPenggunaId($penggunaId)
    {
        $builder = $this->db->table('tbl_pengeluaran_murni_detail');
        $builder->select('tbl_pengeluaran_murni_detail.*, tbl_persediaan_barang.nama_barang');
        $builder->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_murni_detail.barang_id');
        $builder->where('tbl_pengeluaran_murni_detail.pengguna_id', $penggunaId);

        return $builder->get()->getResult();
    }

    public function getDataByPenggunaId($penggunaId)
    {
        return $this->where('pengguna_id', $penggunaId)
            ->findAll();
    }

    public function insertPengeluaranmurniDetail($data)
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


    public function getDataByMonthAndYear($month, $year)
    {
        return $this->select('tbl_pengeluaran_murni.id as pengguna_id, tbl_pengeluaran_murni.tanggal_penggunaan,  tbl_pengeluaran_murni.nama_pengguna_barang, tbl_pengeluaran_murni.keperluan,  tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.satuan, tbl_pengeluaran_murni_detail.ambil_barang_murni')
            ->join('tbl_pengeluaran_murni', 'tbl_pengeluaran_murni.id = tbl_pengeluaran_murni_detail.pengguna_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_murni_detail.barang_id')
            ->where('MONTH(tbl_pengeluaran_murni.tanggal_penggunaan)', $month)
            ->where('YEAR(tbl_pengeluaran_murni.tanggal_penggunaan)', $year)
            ->groupBy(['tbl_pengeluaran_murni.id', 'tbl_pengeluaran_murni.tanggal_penggunaan', 'tbl_pengeluaran_murni.nama_pengguna_barang', 'tbl_pengeluaran_murni.keperluan', 'tbl_persediaan_barang.nama_barang', 'tbl_persediaan_barang.satuan', 'tbl_pengeluaran_murni_detail.ambil_barang_murni'])
            ->findAll();
    }

    public function getDataByYear($year)
    {
        return $this->select('tbl_pengeluaran_murni.id as pengguna_id, tbl_pengeluaran_murni.tanggal_penggunaan, tbl_pengeluaran_murni.nama_pengguna_barang, tbl_pengeluaran_murni.keperluan,  tbl_persediaan_barang.nama_barang,  tbl_persediaan_barang.satuan, tbl_pengeluaran_murni_detail.ambil_barang_murni')
            ->join('tbl_pengeluaran_murni', 'tbl_pengeluaran_murni.id = tbl_pengeluaran_murni_detail.pengguna_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_murni_detail.barang_id')
            ->where('YEAR(tbl_pengeluaran_murni.tanggal_penggunaan)', $year)
            ->groupBy(['tbl_pengeluaran_murni.id', 'tbl_pengeluaran_murni.tanggal_penggunaan', 'tbl_pengeluaran_murni.nama_pengguna_barang', 'tbl_pengeluaran_murni.keperluan',  'tbl_persediaan_barang.nama_barang', 'tbl_persediaan_barang.satuan', 'tbl_pengeluaran_murni_detail.ambil_barang_murni'])
            ->findAll();
    }

    public function getBarangDataByMonthAndYear($month, $year)
    {
        return $this->select('tbl_pengeluaran_murni_detail.barang_id, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.harga_satuan, tbl_persediaan_barang.satuan, SUM(tbl_pengeluaran_murni_detail.ambil_barang_murni) as ambil_barang_murni')
            ->join('tbl_pengeluaran_murni', 'tbl_pengeluaran_murni.id = tbl_pengeluaran_murni_detail.pengguna_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_murni_detail.barang_id')
            ->where('MONTH(tbl_pengeluaran_murni.tanggal_penggunaan)', $month)
            ->where('YEAR(tbl_pengeluaran_murni.tanggal_penggunaan)', $year)
            ->groupBy('tbl_pengeluaran_murni_detail.barang_id')
            ->findAll();
    }

    public function getBarangDataByYear($year)
    {
        return $this->select('tbl_pengeluaran_murni_detail.barang_id, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.harga_satuan, tbl_persediaan_barang.satuan, SUM(tbl_pengeluaran_murni_detail.ambil_barang_murni) as ambil_barang_murni')
            ->join('tbl_pengeluaran_murni', 'tbl_pengeluaran_murni.id = tbl_pengeluaran_murni_detail.pengguna_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_murni_detail.barang_id')
            ->where('YEAR(tbl_pengeluaran_murni.tanggal_penggunaan)', $year)
            ->groupBy('tbl_pengeluaran_murni_detail.barang_id')
            ->findAll();
    }
}
