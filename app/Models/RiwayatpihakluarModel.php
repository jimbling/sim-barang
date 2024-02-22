<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatpihakluarModel extends Model
{
    protected $table = 'pihakluar_riwayat_peminjaman';
    protected $primaryKey = 'id';
    protected $allowedFields = ['peminjaman_id', 'barang_id', 'lama_pinjam'];

    public function insertRiwayatPeminjaman($data)
    {
        return $this->insert($data);
    }
    public function getCompleteData()
    {
        return $this->db->table($this->table)
            ->join('pihakluar_peminjaman', 'pihakluar_peminjaman.id = pihakluar_riwayat_peminjaman.peminjaman_id')
            ->join('tbl_barang', 'tbl_barang.id = pihakluar_riwayat_peminjaman.barang_id')
            ->select('pihakluar_riwayat_peminjaman.peminjaman_id, GROUP_CONCAT(pihakluar_riwayat_peminjaman.barang_id) as barang_ids, GROUP_CONCAT(tbl_barang.nama_barang) as nama_barangs, pihakluar_peminjaman.*, tbl_barang.*')
            ->groupBy('pihakluar_riwayat_peminjaman.peminjaman_id')
            ->get()
            ->getResultArray();
    }

    public function getGroupedData($peminjaman_id)
    {
        return $this->db->table($this->table)
            ->join('pihakluar_peminjaman', 'pihakluar_peminjaman.id = pihakluar_riwayat_peminjaman.peminjaman_id')
            ->join('tbl_barang', 'tbl_barang.id = pihakluar_riwayat_peminjaman.barang_id')
            ->select('pihakluar_riwayat_peminjaman.peminjaman_id, pihakluar_riwayat_peminjaman.lama_pinjam, tbl_barang.id as barang_id, tbl_barang.nama_barang, tbl_barang.kode_barang, tbl_barang.harga_sewa, pihakluar_peminjaman.*')
            ->where('pihakluar_riwayat_peminjaman.peminjaman_id', $peminjaman_id)
            ->get()
            ->getResultArray();
    }

    public function hapus($peminjamanId)
    {
        // Hapus data pada tabel tbl_peminjaman_barang berdasarkan peminjaman_id
        $this->where('peminjaman_id', $peminjamanId)->delete();

        // Hapus data pada tabel pihakluar_peminjaman_detail berdasarkan peminjaman_id
        $riwayatpihakluarModel = new RiwayatpihakluarModel();
        $riwayatpihakluarModel->where('peminjaman_id', $peminjamanId)->delete();

        // Hapus data pada tabel pihakluar_peminjaman berdasarkan peminjaman_id
        $pihakLuarModel = new PihakluarPeminjamanModel();
        $pihakLuarModel->where('id', $peminjamanId)->delete();
    }
}
