<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranModel extends Model
{
    protected $table = 'tbl_pengeluaran_persediaan';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $allowedFields = ['id', 'peminjaman_id', 'barang_id', 'ambil_barang', 'harga_satuan', 'jumlah_harga'];

    public function getPengeluaranByPeminjamanId($peminjamanId)
    {
        $builder = $this->db->table('tbl_pengeluaran_persediaan');
        $builder->select('tbl_pengeluaran_persediaan.*, tbl_persediaan_barang.nama_barang');
        $builder->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_persediaan.barang_id');
        $builder->where('tbl_pengeluaran_persediaan.peminjaman_id', $peminjamanId);

        return $builder->get()->getResult();
    }

    public function getByPeminjamanId($peminjamanId)
    {
        // Join dengan tabel barang untuk mendapatkan nama barang
        $this->join('tbl_barang', 'tbl_barang.id = tbl_pengeluaran_persediaan.barang_id');

        // Ambil data berdasarkan peminjaman_id
        return $this->where('peminjaman_id', $peminjamanId)->first();
    }

    public function getDataByPeminjamanId($peminjamanId)
    {
        return $this->where('peminjaman_id', $peminjamanId)
            ->findAll();
    }



    public function barang()
    {
        return $this->belongsTo(BarangPersediaanModel::class, 'barang_id');
    }

    public function getAllPengeluaran()
    {
        $builder = $this->db->table('tbl_pengeluaran_persediaan');
        $builder->select('
        tbl_pengeluaran_persediaan.peminjaman_id,
        tbl_peminjaman.kode_pinjam,
        tbl_peminjaman.nama_peminjam,
        tbl_peminjaman.nama_ruangan,
        tbl_peminjaman.keperluan,
        tbl_peminjaman.tanggal_pinjam,
        tbl_peminjaman.created_at as tanggal_peminjaman,
        tbl_pengeluaran_persediaan.barang_id,
        tbl_persediaan_barang.nama_barang,
        tbl_pengeluaran_persediaan.ambil_barang,
        tbl_pengeluaran_persediaan.harga_satuan,
        tbl_pengeluaran_persediaan.jumlah_harga,
        SUM(tbl_pengeluaran_persediaan.ambil_barang) as total_ambil_barang,
        AVG(tbl_pengeluaran_persediaan.harga_satuan) as rata_rata_harga_satuan,
        SUM(tbl_pengeluaran_persediaan.jumlah_harga) as total_jumlah_harga
    ');
        $builder->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_pengeluaran_persediaan.peminjaman_id');
        $builder->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_persediaan.barang_id');
        $builder->groupBy('tbl_pengeluaran_persediaan.peminjaman_id, tbl_pengeluaran_persediaan.barang_id');
        $query = $builder->get();

        $result = $query->getResultArray();

        // Proses hasil query untuk mengelompokkan berdasarkan peminjaman_id
        $groupedResult = [];
        foreach ($result as $row) {
            $peminjamanId = $row['peminjaman_id'];
            if (!isset($groupedResult[$peminjamanId])) {
                $groupedResult[$peminjamanId] = [
                    'peminjaman_id' => $peminjamanId,
                    'kode_pinjam' => $row['kode_pinjam'],
                    'nama_peminjam' => $row['nama_peminjam'],
                    'nama_ruangan' => $row['nama_ruangan'],
                    'keperluan' => $row['keperluan'],
                    'tanggal_pinjam' => $row['tanggal_pinjam'],
                    'created_at' => $row['tanggal_peminjaman'], // Tambahkan 'created_at' di sini
                    'barang' => [],
                ];
            }

            $groupedResult[$peminjamanId]['barang'][] = [
                'barang_id' => $row['barang_id'],
                'nama_barang' => $row['nama_barang'],
                'ambil_barang' => $row['ambil_barang'],
                'harga_satuan' => $row['harga_satuan'],
                'jumlah_harga' => $row['jumlah_harga'],
            ];
        }

        // Urutkan berdasarkan created_at yang terbaru
        usort($groupedResult, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $groupedResult;
    }



    public function insertPengeluaranBarang($data)
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

    public function hapusDataByPeminjamanId($peminjamanId)
    {
        return $this->where('peminjaman_id', $peminjamanId)->delete();
    }



    public function insertPengeluaran($peminjaman_id, $barang_id, $jumlah_barang, $harga_satuan, $jumlah_harga)
    {
        return $this->insert([
            'peminjaman_id' => $peminjaman_id,
            'barang_id' => $barang_id,
            'jumlah_barang' => $jumlah_barang,
            'harga_satuan' => $harga_satuan,
            'jumlah_harga' => $jumlah_harga,
        ]);
    }

    public function updateStok($barangId, $ambilBarang)
    {
        $persediaanModel = new BarangPersediaanModel(); // Ganti dengan nama model persediaan Anda

        // Dapatkan stok terbaru
        $stokBarang = $persediaanModel->getStokByBarangId($barangId);

        // Kurangi stok dengan jumlah barang yang diambil
        $stokTerbaru = $stokBarang - $ambilBarang;

        // Perbarui stok di tabel persediaan_barang
        $persediaanModel->updateStok($barangId, $stokTerbaru);
    }

    public function hapusPeminjaman($peminjaman_id)
    {
        // Ambil data berdasarkan peminjaman_id
        $pengeluaran = $this->where('peminjaman_id', $peminjaman_id)->findAll();

        // Looping untuk mengembalikan nilai ambil_barang ke dalam kolom stok
        foreach ($pengeluaran as $data) {
            $barang_id = $data['barang_id'];
            $ambil_barang = $data['ambil_barang'];

            // Ambil data barang berdasarkan barang_id
            $barangModel = new BarangPersediaanModel();
            $barang = $barangModel->find($barang_id);

            // Update nilai stok
            $stok_sebelumnya = $barang['stok'];
            $stok_setelah_hapus = $stok_sebelumnya + $ambil_barang;

            // Update stok pada tabel persediaan_barang
            $barangModel->update($barang_id, ['stok' => $stok_setelah_hapus]);

            // Hapus data pengeluaran
            $this->delete($data['id']);
        }

        return true; // Berhasil menghapus peminjaman
    }

    public function getDataByMonthAndYear($month, $year)
    {
        return $this->select('tbl_peminjaman.id as peminjaman_id, tbl_peminjaman.tanggal_pinjam, tbl_peminjaman.kode_pinjam, tbl_peminjaman.nama_peminjam, tbl_peminjaman.keperluan, tbl_persediaan_barang.kode_barang, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.satuan,tbl_pengeluaran_persediaan.ambil_barang')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_pengeluaran_persediaan.peminjaman_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_persediaan.barang_id')
            ->where('MONTH(tbl_peminjaman.tanggal_pinjam)', $month)
            ->where('YEAR(tbl_peminjaman.tanggal_pinjam)', $year)
            ->groupBy(['tbl_peminjaman.id', 'tbl_peminjaman.tanggal_pinjam', 'tbl_peminjaman.kode_pinjam', 'tbl_peminjaman.nama_peminjam', 'tbl_peminjaman.keperluan',  'tbl_persediaan_barang.kode_barang', 'tbl_persediaan_barang.nama_barang', 'tbl_persediaan_barang.satuan', 'tbl_pengeluaran_persediaan.ambil_barang'])
            ->findAll();
    }

    public function getDataByYear($year)
    {
        return $this->select('tbl_peminjaman.id as peminjaman_id, tbl_peminjaman.tanggal_pinjam, tbl_peminjaman.kode_pinjam, tbl_peminjaman.nama_peminjam, tbl_peminjaman.keperluan, tbl_persediaan_barang.kode_barang, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.satuan, tbl_pengeluaran_persediaan.ambil_barang')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_pengeluaran_persediaan.peminjaman_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_persediaan.barang_id')
            ->where('YEAR(tbl_peminjaman.tanggal_pinjam)', $year)
            ->groupBy(['tbl_peminjaman.id', 'tbl_peminjaman.tanggal_pinjam', 'tbl_peminjaman.kode_pinjam', 'tbl_peminjaman.nama_peminjam', 'tbl_peminjaman.keperluan', 'tbl_persediaan_barang.kode_barang', 'tbl_persediaan_barang.nama_barang', 'tbl_persediaan_barang.satuan', 'tbl_pengeluaran_persediaan.ambil_barang'])
            ->findAll();
    }

    public function getBarangDataByMonthAndYear($month, $year)
    {
        return $this->select('tbl_pengeluaran_persediaan.barang_id, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.harga_satuan, tbl_persediaan_barang.satuan, SUM(tbl_pengeluaran_persediaan.ambil_barang) as ambil_barang')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_pengeluaran_persediaan.peminjaman_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_persediaan.barang_id')
            ->where('MONTH(tbl_peminjaman.tanggal_pinjam)', $month)
            ->where('YEAR(tbl_peminjaman.tanggal_pinjam)', $year)
            ->groupBy('tbl_pengeluaran_persediaan.barang_id')
            ->findAll();
    }

    public function getBarangDataByYear($year)
    {
        return $this->select('tbl_pengeluaran_persediaan.barang_id, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.harga_satuan, tbl_persediaan_barang.harga_satuan, SUM(tbl_pengeluaran_persediaan.ambil_barang) as ambil_barang')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_pengeluaran_persediaan.peminjaman_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_persediaan.barang_id')
            ->where('YEAR(tbl_peminjaman.tanggal_pinjam)', $year)
            ->groupBy('tbl_pengeluaran_persediaan.barang_id')
            ->findAll();
    }

    public function getAllBarangDataUntilYear($year)
    {
        return $this->select('tbl_pengeluaran_persediaan.barang_id, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.harga_satuan, tbl_persediaan_barang.harga_satuan, SUM(tbl_pengeluaran_persediaan.ambil_barang) as ambil_barang')
            ->join('tbl_peminjaman', 'tbl_peminjaman.id = tbl_pengeluaran_persediaan.peminjaman_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_pengeluaran_persediaan.barang_id')
            ->where('YEAR(tbl_peminjaman.tanggal_pinjam)<=', $year)
            ->groupBy('tbl_pengeluaran_persediaan.barang_id')
            ->findAll();
    }
}
