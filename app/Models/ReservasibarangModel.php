<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasibarangModel extends Model
{
    protected $table = 'tbl_reservasi_barang';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'reservasi_id', 'barang_id'];

    public function hitungJumlahBooking()
    {
        $result = $this->selectCount('DISTINCT(reservasi_id)', 'jumlah_booking', false)->get()->getRowArray();
        return $result['jumlah_booking'];
    }

    public function getReservasiPeminjaman()
    {
        // Dapatkan user_id dan level dari sesi
        $session = session();
        $userId = $session->get('id');
        $level = $session->get('level');

        // Kueri untuk mendapatkan data reservasi/peminjaman
        $query = $this->select('
                tbl_reservasi.id as reservasi_id, 
                kode_reservasi, 
                nama_peminjam, 
                nama_ruangan, 
                tanggal_pinjam, 
                tanggal_penggunaan,
                keperluan, 
                GROUP_CONCAT(tbl_barang.id) as barang_ids,
                GROUP_CONCAT(CONCAT(tbl_barang.nama_barang, " - ", tbl_barang.kode_barang)) as barang_dipinjam,
                tbl_reservasi_barang.barang_id,
                tbl_reservasi.created_at')
            ->join('tbl_barang', 'tbl_barang.id = tbl_reservasi_barang.barang_id')
            ->join('tbl_reservasi', 'tbl_reservasi.id = tbl_reservasi_barang.reservasi_id')
            ->groupBy('reservasi_id')
            ->orderBy('tanggal_pinjam', 'DESC'); // Mengurutkan berdasarkan tanggal_pinjam secara descending

        // Jika pengguna yang sedang login adalah admin, tidak perlu filter berdasarkan user_id
        if ($level !== 'Admin') {
            $query->where('tbl_reservasi.user_id', $userId); // Filter berdasarkan user_id
        }

        return $query->findAll();
    }




    public function getReservasiPeminjamanByReservasiId($reservasiId)
    {
        return $this->select('
                    tbl_reservasi.id as reservasi_id, 
                    kode_reservasi, 
                    nama_peminjam, 
                    nama_ruangan, 
                    tanggal_pinjam, 
                    tanggal_penggunaan,
                    nama_dosen,
                    keperluan, 
                    GROUP_CONCAT(tbl_barang.id) as barang_ids,
                    GROUP_CONCAT(CONCAT(tbl_barang.nama_barang, " - ", tbl_barang.kode_barang)) as barang_dipinjam,
                    tbl_reservasi_barang.barang_id') // Menambahkan kolom barang_id
            ->join('tbl_barang', 'tbl_barang.id = tbl_reservasi_barang.barang_id')
            ->join('tbl_reservasi', 'tbl_reservasi.id = tbl_reservasi_barang.reservasi_id')
            ->where('tbl_reservasi_barang.reservasi_id', $reservasiId)
            ->groupBy('reservasi_id')
            ->findAll();
    }
    public function insertReservasiBarang($data)
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
        // Ambil data barang_id yang terkait dengan reservasi_id
        $barangIds = $this->select('barang_id')->where('reservasi_id', $peminjamanId)->findAll();

        // Pindahkan data ke tbl_riwayat_peminjaman
        $riwayatpeminjamanModel = new \App\Models\RiwayatPeminjamanModel();
        foreach ($barangIds as $barangId) {
            $riwayatData = [
                'reservasi_id' => $peminjamanId,
                'barang_id' => $barangId['barang_id'],

            ];
            $riwayatpeminjamanModel->insertRiwayatPeminjaman($riwayatData);
        }

        // Ubah status_barang menjadi 0 pada tabel tbl_barang untuk setiap barang_id
        foreach ($barangIds as $barangId) {
            $this->db->table('tbl_barang')->set('status_barang', 0)->where('id', $barangId['barang_id'])->update();
        }

        // Hapus data pada tabel tbl_reservasi_barang berdasarkan reservasi_id
        return $this->where('reservasi_id', $peminjamanId)->delete();
    }

    public function hapusDataReservasi($reservasiId)
    {
        // Ambil data barang_id yang terkait dengan reservasi_id
        $barangIds = $this->select('barang_id')->where('reservasi_id', $reservasiId)->findAll();

        // Ubah status_barang menjadi 0 pada tabel tbl_barang untuk setiap barang_id
        foreach ($barangIds as $barangId) {
            $this->db->table('tbl_barang')->set('status_barang', 0)->where('id', $barangId['barang_id'])->update();
        }

        // Hapus data pada tabel tbl_reservasi_barang berdasarkan reservasi_id
        $this->where('reservasi_id', $reservasiId)->delete();

        // Hapus data pada tabel tbl_reservasi berdasarkan id
        $reservasiModel = new ReservasiModel();
        $reservasiModel->where('id', $reservasiId)->delete();
    }

    public function hapusDaftarReservasi($reservasiId)
    {
        // Hapus data pada tabel tbl_reservasi_barang berdasarkan reservasi_id
        $this->where('reservasi_id', $reservasiId)->delete();

        // Hapus data pada tabel tbl_reservasi berdasarkan id
        $reservasiModel = new ReservasiModel();
        $reservasiModel->delete($reservasiId);
    }

    public function barang()
    {
        return $this->belongsToMany('App\Models\BarangModel', 'tbl_riwayat_pengembalian', 'reservasi_id', 'barang_id');
    }

    public function getDataByKodePinjam($kodePinjam)
    {
        return $this->select('
                tbl_reservasi.id as reservasi_id, 
                kode_reservasi, 
                nama_peminjam, 
                nama_ruangan, 
                tanggal_pinjam, 
                tanggal_penggunaan,
                keperluan, 
                GROUP_CONCAT(tbl_barang.id) as barang_ids,
                GROUP_CONCAT(CONCAT(tbl_barang.nama_barang, " - ", tbl_barang.kode_barang)) as barang_dipinjam,
                tbl_reservasi_barang.barang_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_reservasi_barang.barang_id')
            ->join('tbl_reservasi', 'tbl_reservasi.id = tbl_reservasi_barang.reservasi_id')
            ->where('kode_reservasi', $kodePinjam) // Tambahkan kondisi untuk kode_reservasi
            ->groupBy('reservasi_id')
            ->findAll();
    }
}
