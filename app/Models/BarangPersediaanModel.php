<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangPersediaanModel extends Model
{
    protected $table = 'tbl_persediaan_barang';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $allowedFields = ['id', 'kode_barang', 'nama_barang', 'harga_satuan', 'satuan', 'prodi', 'kelompok_barang', 'stok', 'created_at', 'updated_at'];

    // Define the relationship with tbl_peminjaman
    public function getNamaBarangById($barangId)
    {
        return $this->select('nama_barang')->where('id', $barangId)->first();
    }

    public function peminjaman()
    {
        return $this->hasMany('App\Models\PeminjamanModel', 'barang_id');
    }

    public function getNamaBarang($barangId)
    {
        // Fetch the name of the barang based on the ID
        $query = $this->select('nama_barang')->where('id', $barangId)->get();

        // Check if the query has results
        if ($query->getResult()) {
            return $query->getRow()->nama_barang;
        } else {
            // Return an empty string or handle the case when the barang is not found
            return '';
        }
    }

    public function getHargaSatuan($barangId)
    {
        // Ambil data harga_satuan berdasarkan barang_id
        $query = $this->select('harga_satuan')
            ->where('id', $barangId)
            ->first();

        return ($query) ? $query['harga_satuan'] : null;
    }

    public function tambahHargaSatuan($barangId, $hargaSatuan)
    {
        $this->update($barangId, ['harga_satuan' => $hargaSatuan]);

        return true;
    }

    public function findNamaBarangByHargaSatuan($hargaSatuan)
    {
        // Gantilah 'nama_tabel' dengan nama tabel yang sesuai
        $query = $this->select('nama_barang')
            ->where('harga_satuan', $hargaSatuan)
            ->get();

        if ($query->resultID->num_rows > 0) {
            return $query->getRow()->nama_barang;
        }

        return null;
    }
    public function getBarangPersediaanbyStock()
    {
        // Menggunakan orderBy untuk mengurutkan data berdasarkan stok secara descending (terbanyak dahulu)
        return $this->orderBy('stok', 'DESC')->findAll();
    }

    public function getBarangPersediaan()
    {
        // Menggunakan orderBy untuk mengurutkan data berdasarkan created_at secara descending (terbaru dahulu)
        return $this->orderBy('created_at', 'DESC')->findAll();
    }



    public function insertBarangPersediaan($data)
    {
        $this->insert($data);
        return $this->db->insertID(); // Mengembalikan id_barang yang dihasilkan
    }
    public function updateBarangPersediaan($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }

    public function getLastBarangId()
    {
        return $this->selectMax('barang_id', 'last_id')->first();
    }

    public function generateKodeBarang($lastId)
    {
        $prefix = 'YKY-Lab-Persed-';
        $nextId = $lastId['last_id'] + 1;

        // Format nomor urut ke dalam 5 digit dengan leading zero
        $formattedId = sprintf('%05d', $nextId);

        return $prefix . $formattedId;
    }

    public function getStokByBarangId($barangId)
    {
        return $this->where('id', $barangId)->get()->getRow()->stok;
    }

    public function updateStok($barangId, $stokBaru)
    {
        $this->set('stok', $stokBaru)->where('id', $barangId)->update();
    }

    public function kembalikanJumlahBarang($barangId, $ambilBarang)
    {
        // Dapatkan data barang yang akan diupdate
        $barang = $this->find($barangId);

        // Kembalikan jumlah_barang
        $data = [
            'jumlah_barang' => $barang['jumlah_barang'] + $ambilBarang,
        ];

        // Update data barang
        $this->update($barangId, $data);
    }

    public function getStokById($barangId)
    {
        // Ambil data stok berdasarkan id barang
        $result = $this->db->table('nama_tabel_barang')
            ->select('stok')
            ->where('id', $barangId)
            ->get()
            ->getRow();

        // Cek apakah data ditemukan
        if ($result) {
            return $result->stok;
        } else {
            return 0; // Atau nilai default lainnya
        }
    }
}
