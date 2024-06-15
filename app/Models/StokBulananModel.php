<?php

namespace App\Models;

use CodeIgniter\Model;

class StokBulananModel extends Model
{
    protected $table = 'tbl_stok_bulanan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['barang_id', 'bulan', 'tahun', 'harga_satuan', 'sisa_stok'];

    // Fungsi untuk mendapatkan informasi barang terkait
    public function getBarangInfo($barang_id)
    {
        $barangModel = new BarangPersediaanModel();
        return $barangModel->find($barang_id);
    }
    public function getSaldoAkhirBulanSebelumnya($barangId, $bulan, $tahun)
    {
        // Konversi bulan dan tahun ke bulan sebelumnya
        $date = new \DateTime("$tahun-$bulan-01");
        $date->modify('-1 month');
        $previousMonth = $date->format('m');
        $previousYear = $date->format('Y');

        // Query untuk mendapatkan saldo akhir dari bulan sebelumnya
        return $this->where('barang_id', $barangId)
            ->where('bulan', $previousMonth)
            ->where('tahun', $previousYear)
            ->first();
    }

    public function getDataByBulanTahun($bulan, $tahun)
    {
        return $this->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->findAll();
    }

    public function getDataBulanTahunSebelumnya($bulan, $tahun)
    {
        // Menghitung bulan dan tahun sebelumnya
        $bulanSebelumnya = $bulan - 1;
        $tahunSebelumnya = $tahun;

        if ($bulanSebelumnya == 0) {
            // Jika bulan sebelumnya adalah Desember, tahun sebelumnya adalah tahun sekarang - 1
            $bulanSebelumnya = 12;
            $tahunSebelumnya = $tahun - 1;
        }

        // Membuat kueri untuk mendapatkan data dengan join ke tabel barang
        $query = $this->db->table('tbl_stok_bulanan')
            ->select('tbl_stok_bulanan.*, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.satuan')
            ->join('tbl_persediaan_barang', 'tbl_stok_bulanan.barang_id = tbl_persediaan_barang.id', 'left')
            ->where('tbl_stok_bulanan.bulan', $bulanSebelumnya)
            ->where('tbl_stok_bulanan.tahun', $tahunSebelumnya)
            ->get();

        return $query->getResult();
    }

    public function checkIfDataExists($bulan, $tahun)
    {
        return $this->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->countAllResults() > 0;
    }

    public function hapusDataBerdasarkanBulanTahun($bulan, $tahun)
    {
        // Hapus data stok bulanan berdasarkan bulan dan tahun
        return $this->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->delete();
    }
}
