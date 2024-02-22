<?php

namespace App\Models;

use CodeIgniter\Model;

class PihakluarPeminjamanModel extends Model
{
    protected $table = 'pihakluar_peminjaman';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $allowedFields = ['id', 'nama_peminjam', 'tanggal_pinjam', 'tanggal_kembali', 'kode_pinjam', 'nama_instansi', 'alamat_instansi', 'no_telp', 'email', 'no_invoice', 'created_at', 'updated_at'];

    public function getPihakluarPeminjaman()
    {
        return $this->findAll();
    }

    public function insertPihakluarPeminjaman($data)
    {
        return $this->insert($data);
    }
    public function updatePihakluarPeminjaman($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }


    public function getLastIdFromAngka()
    {
        $query = $this->db->query("SELECT id_angka FROM tbl_angka_pihakluar ORDER BY id_angka DESC LIMIT 1");
        $row = $query->getRow();

        if ($row) {
            return $row->id_angka;
        }

        return 0; // Jika tabel kosong
    }

    public function generateKodePinjam()
    {
        // Ganti getLastId() dengan getLastIdFromAngka() untuk mengambil last ID dari tbl_angka
        $lastId = $this->getLastIdFromAngka();

        // Menghasilkan kode pinjam dengan format yang sesuai
        $nextId = $lastId + 1;
        $kode_pinjam = 'YKY-PL-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        return $kode_pinjam;
    }

    public function updateIdAngka()
    {
        $angkaluarModel = new \App\Models\AngkaluarModel();

        // Dapatkan nilai terakhir dari tbl_angka
        $lastIdAngka = $angkaluarModel->getLastIdFromAngka();

        // Tambahkan 1
        $newIdAngka = $lastIdAngka + 1;

        // Update nilai pada tbl_angka
        $angkaluarModel->update($lastIdAngka, ['id_angka' => $newIdAngka]);
    }

    public function hapusBerdasarkanPeminjamanId($peminjamanId)
    {
        // Hapus data pada tabel pihakluar_peminjaman berdasarkan peminjaman_id
        return $this->where('peminjaman_id', $peminjamanId)->delete();
    }
}
