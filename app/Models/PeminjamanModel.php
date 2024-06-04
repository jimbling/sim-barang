<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'tbl_peminjaman';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $allowedFields = ['id', 'user_id', 'kode_pinjam', 'nama_peminjam', 'nama_ruangan', 'tanggal_pinjam', 'tanggal_pengembalian', 'keperluan', 'nama_dosen', 'created_at'];

    public function updateTanggalKembali($id, $tanggalKembali)
    {
        // Lakukan pembaruan tanggal_kembali dalam database
        $this->where('id', $id)
            ->set('tanggal_pengembalian', $tanggalKembali)
            ->update();
    }

    public function getByKeperluanKeyword($keyword, $year = null)
    {
        // Membuat objek builder
        $builder = $this->db->table($this->table);

        // Mencari jumlah data yang memenuhi kriteria secara parsial
        $builder->like('keperluan', $keyword);

        // Menambahkan filter tahun jika tahun diberikan
        if (!empty($year)) {
            $builder->where('YEAR(tanggal_pinjam)', $year);
        }

        $count = $builder->countAllResults();

        return $count;
    }

    // Define the relationship with tbl_persediaan_barang
    public function barangPersediaan()
    {
        return $this->belongsTo('App\Models\BarangPersediaanModel', 'barang_id');
    }

    public function getPeminjaman($id)
    {
        return $this->find($id);
    }

    public function insertPeminjaman($data)
    {
        return $this->insert($data);
    }
    public function updatePeminjaman($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }

    public function groupByNamaBarang()
    { {
            $query = $this->select('nama_barang, kode_barang, SUM(jumlah_barang) as total_jumlah')
                ->where('status_barang', '0')
                ->groupBy('nama_barang')
                ->findAll();

            return $query;
        }
    }

    public function getDetailBarangByNama($nama_barang)
    {
        return $this->where('nama_barang', $nama_barang)
            ->where('status_barang', 0) // Tambahkan kondisi ini
            ->findAll();
    }

    public function getLastIdFromAngka()
    {
        $query = $this->db->query("SELECT id_angka FROM tbl_angka ORDER BY id_angka DESC LIMIT 1");
        $row = $query->getRow();

        if ($row) {
            return $row->id_angka;
        }

        return 0; // Jika tabel kosong
    }

    public function generateKodePinjam()
    {
        // Ambil nilai nilai_kode_pinjam dari database
        $nilai_kode_pinjam = $this->db->table('tbl_pengaturan')->select('nilai_kode_pinjam')->get()->getRow()->nilai_kode_pinjam;

        // Ganti getLastId() dengan getLastIdFromAngka() untuk mengambil last ID dari tbl_angka
        $lastId = $this->getLastIdFromAngka();

        // Menghasilkan kode pinjam dengan format yang sesuai dengan nilai_kode_pinjam dari database
        $nextId = $lastId + 1;
        $kode_pinjam = $nilai_kode_pinjam . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        return $kode_pinjam;
    }

    public function updateIdAngka()
    {
        $angkaModel = new \App\Models\AngkaModel();

        // Dapatkan nilai terakhir dari tbl_angka
        $lastIdAngka = $angkaModel->getLastIdFromAngka();

        // Tambahkan 1
        $newIdAngka = $lastIdAngka + 1;

        // Update nilai pada tbl_angka
        $angkaModel->update($lastIdAngka, ['id_angka' => $newIdAngka]);
    }
}
