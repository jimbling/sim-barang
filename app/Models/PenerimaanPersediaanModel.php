<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaanPersediaanModel extends Model
{
    protected $table = 'tbl_persediaan_penerimaan_detail';
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $allowedFields = ['id', 'penerimaan_id', 'barang_id', 'jumlah_barang', 'harga_satuan', 'jumlah_harga', 'diambil', 'cek_stok', 'created_at', 'updated_at'];




    public function getDataByMonth($bulan)
    {
        return $this->where('MONTH(tanggal_penerimaan)', $bulan)
            ->findAll();
    }

    public function getHargaSatuan($penerimaanId, $barangId)
    {
        return $this->where(['penerimaan_id' => $penerimaanId, 'barang_id' => $barangId])->first();
    }

    public function getPenerimaanPersediaan()
    {
        // Menyusun query dengan select, join, dan groupBy
        $this->select('
        tbl_persediaan_penerimaan_detail.penerimaan_id,
        tbl_persediaan_penerimaan_detail.barang_id,
        tbl_persediaan_penerimaan_detail.jumlah_barang,
        tbl_persediaan_penerimaan_detail.harga_satuan,
        tbl_persediaan_penerimaan_detail.jumlah_harga,
        tbl_persediaan_penerimaan.tanggal_penerimaan,
        tbl_persediaan_penerimaan.jenis_perolehan,
        tbl_persediaan_penerimaan.petugas,
        tbl_persediaan_barang.nama_barang,
        tbl_persediaan_barang.prodi,
        tbl_persediaan_barang.kelompok_barang,
        tbl_persediaan_barang.stok,
        tbl_persediaan_barang.satuan,
        SUM(tbl_persediaan_penerimaan_detail.jumlah_harga) as total_jumlah_harga
    ');

        // Melakukan join dengan tabel tbl_persediaan_penerimaan dan tbl_persediaan_barang
        $this->join('tbl_persediaan_penerimaan', 'tbl_persediaan_penerimaan.id = tbl_persediaan_penerimaan_detail.penerimaan_id');
        $this->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_persediaan_penerimaan_detail.barang_id');

        // Mengelompokkan berdasarkan penerimaan_id
        $this->groupBy('tbl_persediaan_penerimaan_detail.penerimaan_id');

        // Mengurutkan berdasarkan tanggal_penerimaan secara descending (terbaru)
        $this->orderBy('tbl_persediaan_penerimaan.tanggal_penerimaan', 'DESC');

        // Mengambil semua data yang ditemukan
        return $this->findAll();
    }


    public function insertPenerimaanPersed($data)
    {
        return $this->db->table('tbl_persediaan_penerimaan_detail')->insert($data);
    }






    public function getDetailPenerimaanById($penerimaan_id)
    {
        $this->select('
        tbl_persediaan_penerimaan_detail.id,
        tbl_persediaan_penerimaan_detail.penerimaan_id,
        tbl_persediaan_penerimaan_detail.barang_id,
        tbl_persediaan_penerimaan_detail.jumlah_barang,
        tbl_persediaan_penerimaan_detail.harga_satuan,
        tbl_persediaan_penerimaan_detail.jumlah_harga,
        tbl_persediaan_penerimaan.tanggal_penerimaan,
        tbl_persediaan_penerimaan.jenis_perolehan,
        tbl_persediaan_penerimaan.petugas,
        tbl_persediaan_barang.nama_barang,
        tbl_persediaan_barang.prodi,
        tbl_persediaan_barang.kelompok_barang,
        tbl_persediaan_barang.stok,
        tbl_persediaan_barang.satuan,
    ');

        $this->join('tbl_persediaan_penerimaan', 'tbl_persediaan_penerimaan.id = tbl_persediaan_penerimaan_detail.penerimaan_id');
        $this->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_persediaan_penerimaan_detail.barang_id');

        $this->where('tbl_persediaan_penerimaan_detail.penerimaan_id', $penerimaan_id);

        $result = $this->findAll();



        return $result;
    }


    public function updateRuangan($id, $data)
    {
        return $this->set($data)->where('id', $id)->update();
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }

    public function updateStokBarang($barangId, $jumlahBarang)
    {
        $this->db->table('tbl_persediaan_barang')
            ->where('id', $barangId)
            ->set('stok', 'stok + ' . $jumlahBarang, false)
            ->update();
    }

    public function hapusDataBarangByPenerimaanId($penerimaanId)
    {
        $this->where('penerimaan_id', $penerimaanId)->delete();
    }

    public function tampilkanData()
    {
        $builder = $this->db->table('tbl_persediaan_penerimaan_detail');
        $builder->select('tbl_persediaan_penerimaan_detail.*, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.stok');
        $builder->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_persediaan_penerimaan_detail.barang_id');


        $query = $builder->get();
        $result = $query->getResult();

        return $result;
    }

    public function updateStokAndInsertDetail($barangId, $jumlahDiambil)
    {
        // Ambil data persediaan berdasarkan barang_id
        $persediaan = $this->where('barang_id', $barangId)->first();

        if ($persediaan) {
            // Kurangi jumlah_barang dengan $jumlahDiambil
            $persediaan['jumlah_barang'] -= $jumlahDiambil;

            // Isi nilai ke kolom cek_stok
            $persediaan['cek_stok'] = $persediaan['jumlah_barang'] == 0 ? 'Stok Habis' : 'Stok Tersedia';

            // Update data persediaan
            $this->update($persediaan['id'], $persediaan);

            // Insert data pengeluaran detail
            $pengeluaranDetailData = [
                'penerimaan_id' => $persediaan['penerimaan_id'],
                'barang_id' => $persediaan['barang_id'],
                'jumlah_barang' => $jumlahDiambil,
                'harga_satuan' => $persediaan['harga_satuan'],
                'satuan' => $persediaan['satuan'],
                'jumlah_harga' => $jumlahDiambil * $persediaan['harga_satuan'],
                'diambil' => $jumlahDiambil,
                'cek_stok' => $persediaan['cek_stok'],
            ];

            $this->insert($pengeluaranDetailData);
        }
    }

    public function hapusByPenerimaanId($penerimaanId)
    {
        // Ambil data penerimaan berdasarkan penerimaan_id
        $penerimaanData = $this->where('penerimaan_id', $penerimaanId)->findAll();

        // Jika ada data penerimaan dengan penerimaan_id yang sama
        if ($penerimaanData) {
            // Ambil semua barang_id yang terkait dengan penerimaan_id
            $barangIds = array_column($penerimaanData, 'barang_id');

            // Kurangi stok pada tbl_persediaan_barang untuk setiap barang_id
            $barangModel = new BarangPersediaanModel();
            foreach ($penerimaanData as $data) {
                $barangId = $data['barang_id'];
                $jumlahBarang = $data['jumlah_barang'];

                // Ambil data barang berdasarkan ID
                $barang = $barangModel->find($barangId);

                // Jika barang ditemukan
                if ($barang) {
                    // Kurangi stok sesuai dengan jumlah_barang pada penerimaan
                    $stokBaru = $barang['stok'] - $jumlahBarang;

                    // Update stok pada tbl_persediaan_barang
                    $barangModel->update($barangId, ['stok' => $stokBaru]);
                }
            }

            // Hapus semua data penerimaan dengan penerimaan_id yang sama
            $this->where('penerimaan_id', $penerimaanId)->delete();

            // Hapus juga data penerimaan induk
            $penerimaanModel = new PenerimaanModel();
            $penerimaanModel->delete($penerimaanId);
        }
    }

    public function getUniqueYears()
    {
        return $this->distinct()->select('YEAR(tanggal_penerimaan) as tahun')->from('tbl_persediaan_penerimaan')->orderBy('tahun', 'ASC')->findAll();
    }

    public function getDataByMonthAndYear($month, $year)
    {
        return $this->select('tbl_persediaan_penerimaan.id as penerimaan_id, tbl_persediaan_penerimaan.tanggal_penerimaan, tbl_persediaan_penerimaan.jenis_perolehan, tbl_persediaan_penerimaan.petugas, tbl_persediaan_barang.kode_barang, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.satuan, tbl_persediaan_penerimaan_detail.harga_satuan, tbl_persediaan_penerimaan_detail.jumlah_barang, tbl_persediaan_penerimaan_detail.jumlah_harga')
            ->join('tbl_persediaan_penerimaan', 'tbl_persediaan_penerimaan.id = tbl_persediaan_penerimaan_detail.penerimaan_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_persediaan_penerimaan_detail.barang_id')
            ->where('MONTH(tbl_persediaan_penerimaan.tanggal_penerimaan)', $month)
            ->where('YEAR(tbl_persediaan_penerimaan.tanggal_penerimaan)', $year)
            ->groupBy(['tbl_persediaan_penerimaan.id', 'tbl_persediaan_penerimaan.tanggal_penerimaan', 'tbl_persediaan_penerimaan.jenis_perolehan', 'tbl_persediaan_penerimaan.petugas', 'tbl_persediaan_barang.kode_barang', 'tbl_persediaan_barang.nama_barang', 'tbl_persediaan_barang.satuan', 'tbl_persediaan_penerimaan_detail.harga_satuan', 'tbl_persediaan_penerimaan_detail.jumlah_barang', 'tbl_persediaan_penerimaan_detail.jumlah_harga'])
            ->findAll();
    }

    public function getDataBYear($year)
    {
        return $this->select('tbl_persediaan_penerimaan.id as penerimaan_id, tbl_persediaan_penerimaan.tanggal_penerimaan, tbl_persediaan_penerimaan.jenis_perolehan, tbl_persediaan_penerimaan.petugas, tbl_persediaan_barang.kode_barang, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.satuan,tbl_persediaan_penerimaan_detail.harga_satuan, tbl_persediaan_penerimaan_detail.jumlah_barang, tbl_persediaan_penerimaan_detail.jumlah_harga')
            ->join('tbl_persediaan_penerimaan', 'tbl_persediaan_penerimaan.id = tbl_persediaan_penerimaan_detail.penerimaan_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_persediaan_penerimaan_detail.barang_id')
            ->where('YEAR(tbl_persediaan_penerimaan.tanggal_penerimaan)', $year)
            ->groupBy(['tbl_persediaan_penerimaan.id', 'tbl_persediaan_penerimaan.tanggal_penerimaan', 'tbl_persediaan_penerimaan.jenis_perolehan', 'tbl_persediaan_penerimaan.petugas', 'tbl_persediaan_barang.kode_barang', 'tbl_persediaan_barang.nama_barang', 'tbl_persediaan_barang.satuan', 'tbl_persediaan_penerimaan_detail.harga_satuan', 'tbl_persediaan_penerimaan_detail.jumlah_barang', 'tbl_persediaan_penerimaan_detail.jumlah_harga'])
            ->findAll();
    }

    public function getBarangDataByMonthAndYear($month, $year)
    {
        return $this->select('tbl_persediaan_penerimaan_detail.barang_id, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.harga_satuan, tbl_persediaan_barang.satuan,SUM(tbl_persediaan_penerimaan_detail.jumlah_barang) as jumlah_barang')
            ->join('tbl_persediaan_penerimaan', 'tbl_persediaan_penerimaan.id = tbl_persediaan_penerimaan_detail.penerimaan_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_persediaan_penerimaan_detail.barang_id')
            ->where('MONTH(tbl_persediaan_penerimaan.tanggal_penerimaan)', $month)
            ->where('YEAR(tbl_persediaan_penerimaan.tanggal_penerimaan)', $year)
            ->groupBy('tbl_persediaan_penerimaan_detail.barang_id')
            ->findAll();
    }

    public function getBarangDataByYear($year)
    {
        return $this->select('tbl_persediaan_penerimaan_detail.barang_id, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.harga_satuan,tbl_persediaan_barang.satuan, SUM(tbl_persediaan_penerimaan_detail.jumlah_barang) as jumlah_barang')
            ->join('tbl_persediaan_penerimaan', 'tbl_persediaan_penerimaan.id = tbl_persediaan_penerimaan_detail.penerimaan_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_persediaan_penerimaan_detail.barang_id')
            ->where('YEAR(tbl_persediaan_penerimaan.tanggal_penerimaan)', $year)
            ->groupBy('tbl_persediaan_penerimaan_detail.barang_id')
            ->findAll();
    }

    public function getAllBarangDataUntilYear($year)
    {
        return $this->select('tbl_persediaan_penerimaan_detail.barang_id, tbl_persediaan_barang.nama_barang, tbl_persediaan_barang.harga_satuan, tbl_persediaan_barang.satuan, SUM(tbl_persediaan_penerimaan_detail.jumlah_barang) as jumlah_barang')
            ->join('tbl_persediaan_penerimaan', 'tbl_persediaan_penerimaan.id = tbl_persediaan_penerimaan_detail.penerimaan_id')
            ->join('tbl_persediaan_barang', 'tbl_persediaan_barang.id = tbl_persediaan_penerimaan_detail.barang_id')
            ->where('YEAR(tbl_persediaan_penerimaan.tanggal_penerimaan) <=', $year)
            ->groupBy('tbl_persediaan_penerimaan_detail.barang_id')
            ->findAll();
    }
}
