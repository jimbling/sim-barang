<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPeminjamanModel extends Model
{
    protected $table = 'tbl_riwayat_peminjaman';
    protected $primaryKey = 'id';
    protected $allowedFields = ['peminjaman_id', 'barang_id'];

    public function insertRiwayatPeminjaman($data)
    {
        return $this->insert($data);
    }
    public function getRiwayatPinjamBarang()
    {
        return $this->select('
                          tbl_peminjaman.id as peminjaman_id, 
                          kode_pinjam, 
                          nama_peminjam, 
                          nama_ruangan, 
                          tanggal_pinjam, 
                          keperluan, 
                          GROUP_CONCAT(CONCAT(tbl_barang.nama_barang, " - ", tbl_barang.kode_barang)) as barang_dipinjam')
            ->join('tbl_barang', 'tbl_barang.id = tbl_riwayat_peminjaman.barang_id')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_peminjaman.peminjaman_id')
            ->groupBy('peminjaman_id')
            ->orderBy('tanggal_pinjam', 'desc') // Menambahkan orderBy
            ->findAll();
    }

    public function getRiwayatPeminjaman($year)
    {
        return $this->select('
                ROW_NUMBER() OVER() AS no,
                tbl_peminjaman.id as peminjaman_id, 
                kode_pinjam, 
                nama_peminjam, 
                nama_ruangan, 
                tanggal_pinjam, 
                keperluan, 
                GROUP_CONCAT(CONCAT(tbl_barang.nama_barang, " - ", tbl_barang.kode_barang)) as barang_dipinjam')
            ->join('tbl_barang', 'tbl_barang.id = tbl_riwayat_peminjaman.barang_id')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_peminjaman.peminjaman_id')
            ->where('YEAR(tbl_peminjaman.tanggal_pinjam)', $year)
            ->groupBy('tbl_riwayat_peminjaman.peminjaman_id')
            ->orderBy('tanggal_pinjam', 'DESC') // Menambahkan orderBy untuk mengurutkan berdasarkan tanggal_pinjam secara descending
            ->findAll();
    }


    public function hapusByPeminjamanId($peminjamanId)
    {
        // Ambil data barang_id yang terkait dengan peminjaman_id
        $barangIds = $this->select('barang_id')->where('peminjaman_id', $peminjamanId)->findAll();



        // Hapus data pada tabel tbl_peminjaman_barang berdasarkan peminjaman_id
        return $this->where('peminjaman_id', $peminjamanId)->delete();
    }

    public function getDataByMonthAndYear($month, $year)
    {
        return $this->select('tbl_peminjaman.kode_pinjam, tbl_peminjaman.nama_ruangan, tbl_peminjaman.keperluan, tbl_peminjaman.nama_peminjam,  tbl_peminjaman.nama_dosen, tbl_peminjaman.tanggal_pinjam, GROUP_CONCAT(CONCAT(tbl_barang.kode_barang, " - ", tbl_barang.nama_barang) SEPARATOR ", ") as kode_nama_barang_concat')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_peminjaman.peminjaman_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_riwayat_peminjaman.barang_id')
            ->where('MONTH(tbl_peminjaman.tanggal_pinjam)', $month)
            ->where('YEAR(tbl_peminjaman.tanggal_pinjam)', $year)
            ->groupBy('tbl_riwayat_peminjaman.peminjaman_id')
            ->findAll();
    }

    public function getDataByYear($year)
    {
        return $this->select('tbl_peminjaman.kode_pinjam, tbl_peminjaman.nama_ruangan, tbl_peminjaman.keperluan, tbl_peminjaman.nama_peminjam, tbl_peminjaman.nama_dosen,tbl_peminjaman.tanggal_pinjam, GROUP_CONCAT(CONCAT(tbl_barang.kode_barang, " - ", tbl_barang.nama_barang) SEPARATOR ", ") as kode_nama_barang_concat')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_peminjaman.peminjaman_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_riwayat_peminjaman.barang_id')
            ->where('YEAR(tbl_peminjaman.tanggal_pinjam)', $year)
            ->groupBy('tbl_riwayat_peminjaman.peminjaman_id')
            ->findAll();
    }

    public function getUniqueYears()
    {
        return $this->distinct()->select('YEAR(tanggal_pinjam) as tahun')->from('tbl_peminjaman')->orderBy('tahun', 'ASC')->findAll();
    }

    public function getAvailableYears()
    {
        // Mengambil tahun-tahun unik dari kolom tanggal_pinjam
        $query = $this->select('YEAR(tanggal_pinjam) AS tahun')->from('tbl_peminjaman')->distinct()->orderBy('tahun', 'DESC')->findAll();

        $years = [];
        foreach ($query as $row) {
            $years[] = $row['tahun'];
        }

        return $years;
    }
}
