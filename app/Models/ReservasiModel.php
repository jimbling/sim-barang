<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasiModel extends Model
{
    protected $table = 'tbl_reservasi';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $allowedFields = ['id', 'user_id', 'kode_reservasi', 'nama_peminjam', 'nama_ruangan', 'tanggal_pinjam', 'tanggal_pengembalian', 'tanggal_penggunaan', 'keperluan', 'nama_dosen', 'created_at', 'updated_at', 'confirmed'];





    public function insertReservasi($data)
    {
        // Simpan data peminjaman
        $reservasiId = $this->insert($data);

        // Kirim email ke admin
        $this->kirimEmailAdmin($data);

        return $reservasiId;
    }


    public function getLastIdFromAngka()
    {
        $query = $this->db->query("SELECT id_angka FROM tbl_angka_reservasi ORDER BY id_angka DESC LIMIT 1");
        $row = $query->getRow();

        if ($row) {
            return $row->id_angka;
        }

        return 0; // Jika tabel kosong
    }

    public function generateKodeReservasi()
    {
        // Ganti getLastId() dengan getLastIdFromAngka() untuk mengambil last ID dari tbl_angka_reservasi
        $lastId = $this->getLastIdFromAngka();

        // Menghasilkan kode pinjam dengan format yang sesuai
        $nextId = $lastId + 1;
        $kode_reservasi = 'RSV-YKY-LAB-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        return $kode_reservasi;
    }

    public function updateIdAngka()
    {
        $angkareservasiModel = new \App\Models\AngkareservasiModel();

        // Dapatkan nilai terakhir dari tbl_angka_reservasi
        $lastIdAngka = $angkareservasiModel->getLastIdFromAngka();

        // Tambahkan 1
        $newIdAngka = $lastIdAngka + 1;

        // Update nilai pada tbl_angka_reservasi
        $angkareservasiModel->update($lastIdAngka, ['id_angka' => $newIdAngka]);
    }
}
