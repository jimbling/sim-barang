<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianbarangModel extends Model
{
    protected $table = 'tbl_riwayat_pengembalian';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'peminjaman_id', 'barang_id', 'kode_kembali', 'tanggal_kembali', 'keterangan'];



    public function deleteByPeminjamanId($peminjamanId)
    {
        // Hapus data dari tabel berdasarkan peminjaman_id
        return $this->where('peminjaman_id', $peminjamanId)->delete();
    }

    public function findPeminjamanBarangIdsByKodeKembali($kodeKembali)
    {
        $result = $this->where('kode_kembali', $kodeKembali)->findAll();

        if (empty($result)) {
            return null;
        }

        $peminjamanIds = [];
        $barangIds = [];

        foreach ($result as $row) {
            $peminjamanIds[] = $row['peminjaman_id'];
            $barangIds[] = $row['barang_id'];
        }

        return [
            'peminjaman_ids' => $peminjamanIds,
            'barang_ids' => $barangIds
        ];
    }

    public function getAllDataWithRelations()
    {
        // Menggunakan query builder untuk melakukan join tabel
        $builder = $this->db->table($this->table);
        $builder->select('tbl_riwayat_pengembalian.*, tbl_peminjaman.*, tbl_barang.*');
        $builder->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_pengembalian.peminjaman_id');
        $builder->join('tbl_barang', 'tbl_barang.id = tbl_riwayat_pengembalian.barang_id');
        $query = $builder->get();

        // Mengembalikan hasil query dalam bentuk array
        return $query->getResultArray();
    }

    public function getAllDataWithRelationsByKodePinjam($kodePinjam)
    {
        // Menggunakan query builder untuk melakukan join tabel
        $builder = $this->db->table($this->table);
        $builder->select('tbl_riwayat_pengembalian.*, tbl_peminjaman.*, tbl_barang.*');
        $builder->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_pengembalian.peminjaman_id');
        $builder->join('tbl_barang', 'tbl_barang.id = tbl_riwayat_pengembalian.barang_id');
        $builder->where('tbl_peminjaman.kode_pinjam', $kodePinjam);
        $query = $builder->get();

        // Mengembalikan hasil query dalam bentuk array
        return $query->getResultArray();
    }
    public function savePengembalian($peminjamanId, $barangIds, $kodeKembali, $tanggalKembali, $keterangan)
    {
        // Mulai transaksi
        $this->transStart();

        // Simpan data pengembalian
        $pengembalianData = [
            'peminjaman_id' => $peminjamanId,
            'kode_kembali' => $kodeKembali,
            'tanggal_kembali' => $tanggalKembali,
            'keterangan' => $keterangan
        ];
        $this->insert($pengembalianData);
        $pengembalianId = $this->insertID(); // Mendapatkan ID dari pengembalian yang baru saja disimpan

        // Simpan detail barang yang dipilih
        foreach ($barangIds as $barangId) {
            $detailData = [
                'peminjaman_id' => $peminjamanId,
                'barang_id' => $barangId,
                'kode_kembali' => $kodeKembali,
                'tanggal_kembali' => $tanggalKembali,
                'keterangan' => $keterangan,

            ];
            $this->insert($detailData);
        }

        // Commit transaksi
        $this->transComplete();
    }

    public function simpanPengembalianDanBarang($data, $barangIds)
    {
        $builder = $this->db->table($this->table);

        // Mulai transaksi database
        $this->db->transStart();

        // Simpan data pengembalian barang
        $builder->insert($data);

        // Ambil ID pengembalian barang yang baru saja disimpan
        $pengembalianId = $this->db->insertID();

        // Simpan data barang yang dikembalikan
        foreach ($barangIds as $barangId) {
            $builder->insert([
                'peminjaman_id' => $data['peminjaman_id'],
                'barang_id' => $barangId,
                'kode_kembali' => $data['kode_kembali'],
                'tanggal_kembali' => $data['tanggal_kembali'],
                'keterangan' => $data['keterangan']
            ]);
        }

        // Selesaikan transaksi database
        $this->db->transComplete();

        // Kembalikan status transaksi
        return $this->db->transStatus();
    }

    public function getRiwayatPengembalianBarang($year, $userId = null)
    {
        // Periksa apakah pengguna adalah admin
        $isAdmin = $this->isAdmin($userId);

        $this->select('ROW_NUMBER() OVER() AS no, 
           tbl_riwayat_pengembalian.id as riwayat_id, 
           tbl_peminjaman.id as peminjaman_id, 
           tbl_peminjaman.kode_pinjam, 
           tbl_peminjaman.user_id, 
           tbl_peminjaman.nama_peminjam, 
           tbl_peminjaman.tanggal_pinjam, 
           tbl_peminjaman.keperluan, 
           kode_kembali, 
           tanggal_kembali, 
           keterangan, 
           tbl_barang.nama_barang,
           tbl_barang.kode_barang,
           tbl_riwayat_pengembalian.peminjaman_id,
           tbl_riwayat_pengembalian.barang_id'); // Memilih peminjaman_id dan barang_id dari tbl_riwayat_pengembalian

        $this->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_pengembalian.peminjaman_id');
        $this->join('tbl_barang', 'tbl_barang.id = tbl_riwayat_pengembalian.barang_id'); // Join dengan tbl_barang

        $this->orderBy('tanggal_kembali', 'DESC');
        $this->like('tanggal_kembali', $year, 'after');

        // Jika pengguna bukan admin, filter data berdasarkan user_id
        if (!$isAdmin && $userId !== null) {
            $this->where('tbl_peminjaman.user_id', $userId);
        }

        $result = $this->findAll();

        return $result;
    }



    public function hapusBerdasarkanKodeKembali($kodeKembali)
    {
        return $this->where('kode_kembali', $kodeKembali)->delete();
    }

    private function isAdmin($userId)
    {
        // Query ke database atau model untuk mendapatkan level pengguna berdasarkan user_id
        $user = $this->db->table('tbl_user')->where('id', $userId)->get()->getRow();

        // Jika pengguna tidak ditemukan, atau level tidak ada, maka tidak dianggap sebagai admin
        if (!$user || !isset($user->level)) {
            return false;
        }

        // Jika level pengguna adalah 'Admin', maka dianggap sebagai admin
        return ($user->level == 'Admin');
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

        // Tambahkan join ke tbl_barang
        $this->join('tbl_barang', 'tbl_barang.id = tbl_riwayat_pengembalian.barang_id');

        // Memberikan alias untuk kolom id dari setiap tabel
        $this->select('tbl_riwayat_pengembalian.id as riwayat_id, tbl_peminjaman.id as peminjaman_id, tbl_peminjaman.kode_pinjam, tbl_peminjaman.nama_peminjam, tbl_peminjaman.nama_dosen, tbl_peminjaman.nama_ruangan, tbl_peminjaman.tanggal_pinjam, tbl_peminjaman.keperluan, kode_kembali, tanggal_kembali, keterangan, tbl_barang.nama_barang, tbl_barang.kode_barang');

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

        // Menggunakan metode join untuk menggabungkan tbl_riwayat_pengembalian dengan tbl_peminjaman
        $this->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_riwayat_pengembalian.peminjaman_id');

        // Tambahkan join ke tbl_barang
        $this->join('tbl_barang', 'tbl_barang.id = tbl_riwayat_pengembalian.barang_id');

        // Memberikan alias untuk kolom id dari setiap tabel
        $this->select('tbl_riwayat_pengembalian.id as riwayat_id, tbl_peminjaman.id as peminjaman_id, tbl_peminjaman.kode_pinjam, tbl_peminjaman.nama_peminjam, tbl_peminjaman.nama_dosen, tbl_peminjaman.nama_ruangan, tbl_peminjaman.tanggal_pinjam, tbl_peminjaman.keperluan, kode_kembali, tanggal_kembali, keterangan, tbl_barang.nama_barang, tbl_barang.kode_barang');

        // Menambahkan filter berdasarkan tahun
        $this->where('YEAR(tbl_riwayat_pengembalian.tanggal_kembali)', $year);

        // Jika pengguna yang sedang login bukan admin, terapkan filter berdasarkan user_id
        if ($level !== 'Admin') {
            $this->where('tbl_peminjaman.user_id', $userId);
        }

        // Mengambil data yang dibutuhkan
        $result = $this->findAll();

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

    public function getLastIdFromAngka()
    {
        $query = $this->db->query("SELECT id_angka FROM tbl_angka_kembali ORDER BY id_angka DESC LIMIT 1");
        $row = $query->getRow();

        if ($row) {
            return $row->id_angka;
        }

        return 0; // Jika tabel kosong
    }

    public function generateKodeKembali()
    {
        // Ambil nilai nilai_kode_pinjam dari database
        $nilai_kode_kembali = $this->db->table('tbl_pengaturan')->select('nilai_kode_kembali')->get()->getRow()->nilai_kode_kembali;
        // Ganti getLastId() dengan getLastIdFromAngka() untuk mengambil last ID dari tbl_angka
        $lastId = $this->getLastIdFromAngka();

        // Menghasilkan kode kembali dengan format yang sesuai
        $nextId = $lastId + 1;
        $kode_kembali = $nilai_kode_kembali . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        return $kode_kembali;
    }

    public function updateIdAngka()
    {
        $angkaModel = new \App\Models\AngkakembaliModel();

        // Dapatkan nilai terakhir dari tbl_angka
        $lastIdAngka = $angkaModel->getLastIdFromAngka();

        // Tambahkan 1
        $newIdAngka = $lastIdAngka + 1;

        // Update nilai pada tbl_angka
        $angkaModel->update($lastIdAngka, ['id_angka' => $newIdAngka]);
    }
}
