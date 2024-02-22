<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaanModel extends Model
{
    protected $table = 'tbl_persediaan_penerimaan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'tanggal_penerimaan', 'jenis_perolehan', 'petugas'];


    public function getPenerimaan()
    {
        return $this->findAll();
    }
    public function insertPenerimaan($data)
    {
        return $this->insert($data);
    }
    public function updatePenerimaan($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }
    public function hapusPenerimaanById($penerimaanId)
    {
        // Ambil data penerimaan berdasarkan ID
        $penerimaan = $this->find($penerimaanId);

        // Jika penerimaan ditemukan
        if ($penerimaan) {
            // Kurangi stok pada tbl_persediaan_barang
            $barangModel = new BarangPersediaanModel();
            $barangId = $penerimaan['barang_id'];
            $jumlahBarang = $penerimaan['jumlah_barang'];

            // Ambil data barang berdasarkan ID
            $barang = $barangModel->find($barangId);

            // Jika barang ditemukan
            if ($barang) {
                // Kurangi stok sesuai dengan jumlah_barang pada penerimaan
                $stokBaru = $barang['stok'] - $jumlahBarang;

                // Update stok pada tbl_persediaan_barang
                $barangModel->update($barangId, ['stok' => $stokBaru]);
            }

            // Hapus data penerimaan
            $this->delete($penerimaanId);
        }
    }
}
