<?php

namespace App\Models;

use CodeIgniter\Model;

class PihakluarDetailModel extends Model
{
    protected $table = 'pihakluar_peminjaman_detail';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'peminjaman_id', 'barang_id', 'lama_pinjam'];

    public function getGroupedData($peminjaman_id)
    {
        return $this->db->table($this->table)
            ->join('pihakluar_peminjaman', 'pihakluar_peminjaman.id = pihakluar_peminjaman_detail.peminjaman_id')
            ->join('tbl_barang', 'tbl_barang.id = pihakluar_peminjaman_detail.barang_id')
            ->select('pihakluar_peminjaman_detail.peminjaman_id, pihakluar_peminjaman_detail.lama_pinjam, tbl_barang.id as barang_id, tbl_barang.nama_barang, tbl_barang.kode_barang, tbl_barang.harga_sewa, pihakluar_peminjaman.*')
            ->where('pihakluar_peminjaman_detail.peminjaman_id', $peminjaman_id)
            ->get()
            ->getResultArray();
    }
    public function getCompleteData()
    {
        return $this->db->table($this->table)
            ->join('pihakluar_peminjaman', 'pihakluar_peminjaman.id = pihakluar_peminjaman_detail.peminjaman_id')
            ->join('tbl_barang', 'tbl_barang.id = pihakluar_peminjaman_detail.barang_id')
            ->select('pihakluar_peminjaman_detail.peminjaman_id, GROUP_CONCAT(pihakluar_peminjaman_detail.barang_id) as barang_ids, GROUP_CONCAT(tbl_barang.nama_barang) as nama_barangs, pihakluar_peminjaman.*, tbl_barang.*, pihakluar_peminjaman.created_at as pihakluar_created_at')
            ->groupBy('pihakluar_peminjaman_detail.peminjaman_id')
            ->get()
            ->getResultArray();
    }

    public function getPihakluarDetail()
    {
        return $this->findAll();
    }

    public function insertgetPihakluarDetail($data)
    {
        return $this->insert($data);
    }
    public function updategetPihakluarDetail($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }

    public function ProsesKembali($peminjamanId)
    {
        // Ambil data barang_id dan lama_pinjam yang terkait dengan peminjaman_id
        $barangData = $this->select('barang_id, lama_pinjam')->where('peminjaman_id', $peminjamanId)->findAll();

        // Pindahkan data ke tbl_riwayat_peminjaman
        $riwayatpihakluarModel = new \App\Models\RiwayatpihakluarModel();
        foreach ($barangData as $data) {
            $riwayatData = [
                'peminjaman_id' => $peminjamanId,
                'barang_id' => $data['barang_id'],
                'lama_pinjam' => $data['lama_pinjam'],
            ];
            $riwayatpihakluarModel->insertRiwayatPeminjaman($riwayatData);
        }

        // Ubah status_barang menjadi 0 pada tabel tbl_barang untuk setiap barang_id
        foreach ($barangData as $data) {
            $this->db->table('tbl_barang')->set('status_barang', 0)->where('id', $data['barang_id'])->update();
        }

        // Hapus data pada tabel tbl_peminjaman_barang berdasarkan peminjaman_id
        return $this->where('peminjaman_id', $peminjamanId)->delete();
    }

    public function hapus($peminjamanId)
    {
        // Ambil data barang yang akan dihapus dari tabel tbl_peminjaman_barang
        $barangData = $this->select('barang_id')->where('peminjaman_id', $peminjamanId)->findAll();

        // Ubah status_barang menjadi 0 pada tabel tbl_barang untuk setiap barang_id
        foreach ($barangData as $data) {
            $this->db->table('tbl_barang')->set('status_barang', 0)->where('id', $data['barang_id'])->update();
        }

        // Hapus data pada tabel tbl_peminjaman_barang berdasarkan peminjaman_id
        $this->where('peminjaman_id', $peminjamanId)->delete();

        // Hapus data pada tabel pihakluar_peminjaman_detail berdasarkan peminjaman_id
        $pihakLuarDetailModel = new PihakluarDetailModel();
        $pihakLuarDetailModel->where('peminjaman_id', $peminjamanId)->delete();

        // Hapus data pada tabel pihakluar_peminjaman berdasarkan peminjaman_id
        $pihakLuarModel = new PihakluarPeminjamanModel();
        $pihakLuarModel->where('id', $peminjamanId)->delete();
    }
}
