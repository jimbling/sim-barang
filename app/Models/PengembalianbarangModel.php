<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianbarangModel extends Model
{
    protected $table = 'tbl_riwayat_pengembalian';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'peminjaman_id', 'kode_kembali', 'tanggal_kembali', 'keterangan', 'nama_barang'];

    public function getRiwayatPengembalianBarang()
    {
        // Menggunakan metode join untuk menggabungkan tbl_riwayat_pengembalian dengan tbl_peminjaman
        $this->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_pengembalian.peminjaman_id');

        // Memberikan alias untuk kolom id dari setiap tabel
        $this->select('tbl_riwayat_pengembalian.id as riwayat_id, tbl_peminjaman.id as peminjaman_id, tbl_peminjaman.kode_pinjam, tbl_peminjaman.nama_peminjam,tbl_peminjaman.tanggal_pinjam, tbl_peminjaman.keperluan, kode_kembali, tanggal_kembali, keterangan, nama_barang');

        // Menambahkan orderBy untuk mengurutkan berdasarkan tanggal_kembali secara descending
        $this->orderBy('tanggal_kembali', 'ASC');

        // Mengambil data yang dibutuhkan
        $result = $this->findAll();

        return $result;
    }

    public function insertPengembalianBarang($data)
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

    public function hapusByPeminjamanId($peminjamanId)
    {
        // Ambil data barang_id yang terkait dengan peminjaman_id
        $barangIds = $this->select('barang_id')->where('peminjaman_id', $peminjamanId)->findAll();

        // Pindahkan data ke tbl_riwayat_peminjaman
        $riwayatpeminjamanModel = new \App\Models\RiwayatPeminjamanModel();
        foreach ($barangIds as $barangId) {
            $riwayatData = [
                'peminjaman_id' => $peminjamanId,
                'barang_id' => $barangId['barang_id'],

            ];
            $riwayatpeminjamanModel->insertRiwayatPeminjaman($riwayatData);
        }

        // Ubah status_barang menjadi 0 pada tabel tbl_barang untuk setiap barang_id
        foreach ($barangIds as $barangId) {
            $this->db->table('tbl_barang')->set('status_barang', 0)->where('id', $barangId['barang_id'])->update();
        }

        // Hapus data pada tabel tbl_peminjaman_barang berdasarkan peminjaman_id
        return $this->where('peminjaman_id', $peminjamanId)->delete();
    }

    public function hapusRiwayatPengembalian($id)
    {
        return $this->delete($id);
    }

    public function getDataByMonthAndYear($month, $year)
    {
        // Menggunakan metode join untuk menggabungkan tbl_riwayat_pengembalian dengan tbl_peminjaman
        $this->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_pengembalian.peminjaman_id');

        // Memberikan alias untuk kolom id dari setiap tabel
        $this->select('tbl_riwayat_pengembalian.id as riwayat_id, tbl_peminjaman.id as peminjaman_id, tbl_peminjaman.kode_pinjam, tbl_peminjaman.nama_peminjam, tbl_peminjaman.nama_dosen, tbl_peminjaman.nama_ruangan, tbl_peminjaman.tanggal_pinjam, tbl_peminjaman.keperluan, kode_kembali, tanggal_kembali, keterangan, nama_barang');

        // Menambahkan filter berdasarkan bulan dan tahun
        $this->where('MONTH(tbl_riwayat_pengembalian.tanggal_kembali)', $month);
        $this->where('YEAR(tbl_riwayat_pengembalian.tanggal_kembali)', $year);

        // Mengambil data yang dibutuhkan
        $result = $this->findAll();

        return $result;
    }


    public function getDataByYear($year)
    {
        // Dapatkan user_id dan level dari sesi
        $session = session();
        $userId = $session->get('id');
        $level = $session->get('level');

        // Kueri untuk mendapatkan data berdasarkan tahun
        $query = $this->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_pengembalian.peminjaman_id')
            ->select('tbl_riwayat_pengembalian.id as riwayat_id, tbl_peminjaman.id as peminjaman_id, tbl_peminjaman.kode_pinjam, tbl_peminjaman.nama_peminjam, tbl_peminjaman.nama_dosen, tbl_peminjaman.nama_ruangan, tbl_peminjaman.tanggal_pinjam, tbl_peminjaman.keperluan, kode_kembali, tanggal_kembali, keterangan, nama_barang')
            ->where('YEAR(tbl_riwayat_pengembalian.tanggal_kembali)', $year)
            ->orderBy('tanggal_kembali', 'DESC');

        // Jika pengguna yang sedang login bukan admin, terapkan filter berdasarkan user_id
        if ($level !== 'Admin') {
            $query->where('tbl_peminjaman.user_id', $userId);
        }

        // Mengambil data yang dibutuhkan
        $result = $query->findAll();

        return $result;
    }


    public function getAvailableYears()
    {
        // Mengambil tahun-tahun unik dari kolom tanggal_kembali
        $query = $this->select('YEAR(tanggal_kembali) AS tahun')->distinct()->orderBy('tahun', 'DESC')->findAll();

        $years = [];
        foreach ($query as $row) {
            $years[] = $row['tahun'];
        }

        return $years;
    }
}
