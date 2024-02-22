<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanbarangModel extends Model
{
    protected $table = 'tbl_peminjaman_barang';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'peminjaman_id', 'barang_id'];


    public function hitungJumlahPeminjaman()
    {
        $result = $this->selectCount('DISTINCT(peminjaman_id)', 'jumlah_peminjaman', false)->get()->getRowArray();
        return $result['jumlah_peminjaman'];
    }

    public function getPeminjamanBarang()
    {
        // Dapatkan user_id dan level dari sesi
        $session = session();
        $userId = $session->get('id');
        $level = $session->get('level');

        // Kueri untuk mendapatkan data peminjaman barang
        $query = $this->select('
                tbl_peminjaman.id as peminjaman_id, 
                kode_pinjam, 
                nama_peminjam, 
                nama_ruangan, 
                tanggal_pinjam, 
                keperluan, 
                GROUP_CONCAT(tbl_barang.id) as barang_ids,
                GROUP_CONCAT(CONCAT(tbl_barang.nama_barang, " - ", tbl_barang.kode_barang)) as barang_dipinjam,
                tbl_peminjaman_barang.barang_id,
                tbl_peminjaman.created_at')
            ->join('tbl_barang', 'tbl_barang.id = tbl_peminjaman_barang.barang_id')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_peminjaman_barang.peminjaman_id')
            ->groupBy('peminjaman_id')
            ->orderBy('tanggal_pinjam', 'DESC'); // Mengurutkan berdasarkan tanggal_pinjam secara descending

        // Jika pengguna yang sedang login bukan admin, terapkan filter berdasarkan user_id
        if ($level !== 'Admin') {
            $query->where('tbl_peminjaman.user_id', $userId); // Filter berdasarkan user_id
        }

        return $query->findAll();
    }

    public function getPeminjamanBarang24Jam()
    {
        // Mendapatkan waktu sekarang
        $now = date('Y-m-d H:i:s');

        // Mendapatkan waktu 24 jam yang lalu
        $twentyFourHoursAgo = date('Y-m-d H:i:s', strtotime('-24 hours', strtotime($now)));

        return $this->select('
                    tbl_peminjaman.id as peminjaman_id, 
                    kode_pinjam, 
                    nama_peminjam, 
                    nama_ruangan, 
                    tanggal_pinjam, 
                    keperluan, 
                    GROUP_CONCAT(tbl_barang.id) as barang_ids,
                    GROUP_CONCAT(CONCAT(tbl_barang.nama_barang, " - ", tbl_barang.kode_barang)) as barang_dipinjam,
                    tbl_peminjaman_barang.barang_id,
                    tbl_peminjaman.created_at') // Menambahkan kolom created_at
            ->join('tbl_barang', 'tbl_barang.id = tbl_peminjaman_barang.barang_id')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_peminjaman_barang.peminjaman_id')
            ->where('tbl_peminjaman.created_at >=', $twentyFourHoursAgo) // Filter hanya data yang dibuat dalam 24 jam terakhir
            ->groupBy('peminjaman_id')
            ->orderBy('tanggal_pinjam', 'DESC')
            ->findAll();
    }



    public function getPeminjamanBarangByPeminjamanId($peminjamanId)
    {
        return $this->select('
                    tbl_peminjaman.id as peminjaman_id, 
                    kode_pinjam, 
                    nama_peminjam, 
                    nama_ruangan, 
                    tanggal_pinjam, 
                    nama_dosen,
                    keperluan, 
                    GROUP_CONCAT(tbl_barang.id) as barang_ids,
                    GROUP_CONCAT(CONCAT(tbl_barang.nama_barang, " - ", tbl_barang.kode_barang)) as barang_dipinjam,
                    tbl_peminjaman_barang.barang_id') // Menambahkan kolom barang_id
            ->join('tbl_barang', 'tbl_barang.id = tbl_peminjaman_barang.barang_id')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_peminjaman_barang.peminjaman_id')
            ->where('tbl_peminjaman_barang.peminjaman_id', $peminjamanId)
            ->groupBy('peminjaman_id')
            ->findAll();
    }
    public function insertPeminjamanBarang($data)
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

    public function hapusDataPeminjaman($peminjamanId)
    {
        // Periksa apakah ada peminjaman_id yang sama di tbl_pengeluaran_persediaan
        $pengeluaranPersediaanModel = new PengeluaranModel();
        $pengeluaranExists = $pengeluaranPersediaanModel->where('peminjaman_id', $peminjamanId)->first();

        // Jika tidak ada peminjaman_id yang sama di tbl_pengeluaran_persediaan
        if (!$pengeluaranExists) {
            // Ambil data barang_id yang terkait dengan peminjaman_id
            $barangIds = $this->select('barang_id')->where('peminjaman_id', $peminjamanId)->findAll();

            // Ubah status_barang menjadi 0 pada tabel tbl_barang untuk setiap barang_id
            foreach ($barangIds as $barangId) {
                $this->db->table('tbl_barang')->set('status_barang', 0)->where('id', $barangId['barang_id'])->update();
            }

            // Hapus data pada tabel tbl_peminjaman_barang berdasarkan peminjaman_id
            $this->where('peminjaman_id', $peminjamanId)->delete();

            // Hapus data pada tabel tbl_peminjaman berdasarkan id
            $peminjamanModel = new PeminjamanModel();
            $peminjamanModel->where('id', $peminjamanId)->delete();
        } else {
            // Jika ada peminjaman_id yang sama di tbl_pengeluaran_persediaan, lemparkan pengecualian dengan pesan kesalahan
            throw new \Exception("Tidak dapat menghapus peminjaman karena sudah ada pengeluaran terkait.");
        }
    }

    public function barang()
    {
        return $this->belongsToMany('App\Models\BarangModel', 'tbl_riwayat_pengembalian', 'peminjaman_id', 'barang_id');
    }

    public function getDataByKodePinjam($kodePinjam)
    {
        return $this->select('
                tbl_peminjaman.id as peminjaman_id, 
                kode_pinjam, 
                nama_peminjam, 
                nama_ruangan, 
                tanggal_pinjam, 
                keperluan, 
                GROUP_CONCAT(tbl_barang.id) as barang_ids,
                GROUP_CONCAT(CONCAT(tbl_barang.nama_barang, " - ", tbl_barang.kode_barang)) as barang_dipinjam,
                tbl_peminjaman_barang.barang_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_peminjaman_barang.barang_id')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_peminjaman_barang.peminjaman_id')
            ->where('kode_pinjam', $kodePinjam) // Tambahkan kondisi untuk kode_pinjam
            ->groupBy('peminjaman_id')
            ->findAll();
    }
}
