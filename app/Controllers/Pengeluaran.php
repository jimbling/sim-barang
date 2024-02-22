<?php

namespace App\Controllers;

use App\Models\PenerimaanModel;
use App\Models\PenerimaanPersediaanModel;
use App\Models\SatuanModel;
use App\Models\BarangPersediaanModel;
use App\Models\DosenTendikModel;
use App\Models\PeminjamanbarangModel;
use App\Models\PengeluaranModel;
use App\Models\PengeluaranmurniModel;
use App\Models\PengeluaranmurniDetailModel;
use App\Models\MahasiswaModel;





class Pengeluaran extends BaseController
{
    protected $penerimaanModel;
    protected $penerimaanpersediaanModel;
    protected $satuanModel;
    protected $barangpersediaanModel;
    protected $dosentendikModel;
    protected $peminjamanbarangModel;
    protected $pengeluaranModel;
    protected $pengeluaranmurniModel;
    protected $pengeluaranmurnidetailModel;
    protected $mahasiswaModel;

    public function __construct()
    {
        $this->penerimaanModel = new PenerimaanModel();
        $this->penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $this->satuanModel = new SatuanModel();
        $this->barangpersediaanModel = new BarangPersediaanModel();
        $this->dosentendikModel = new DosenTendikModel();
        $this->peminjamanbarangModel = new PeminjamanbarangModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->pengeluaranmurniModel = new PengeluaranmurniModel();
        $this->pengeluaranmurnidetailModel = new PengeluaranmurniDetailModel();
        $this->mahasiswaModel = new MahasiswaModel();
    }

    public function daftarPengeluaran()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $dataBarang = $penerimaanpersediaanModel->tampilkanData();

        $pengeluaranModel = new PengeluaranModel();
        $dataPengeluaran = $pengeluaranModel->getAllPengeluaran();

        // Memeriksa izin penghapusan berdasarkan kondisi
        $userLevel = session()->get('level');
        if ($userLevel == 'User') {
            $currentTime = time();
            foreach ($dataPengeluaran as &$peminjaman) {
                $createdTime = strtotime($peminjaman['created_at']);
                $timeDifference = $currentTime - $createdTime;
                $timeLimit = 24 * 3600; // 10 menit dalam detik

                // Nonaktifkan tombol hapus jika batasan waktu terlampaui
                $peminjaman['allow_delete'] = ($timeDifference <= $timeLimit);
            }
        }

        $data = [
            'judul' => 'Pengeluaran Persediaan | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,
            'data_peminjaman' => $dataBarang,
            'data_pengeluaran' => $dataPengeluaran,
        ];

        return view('pengeluaran/daftar_pengeluaran', $data);
    }


    public function addPengeluaran()
    {

        $currentYear = date('Y');

        $satuanModel = new SatuanModel();
        $dataSatuan = $satuanModel->getSatuan();

        $penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $dataBarang = $penerimaanpersediaanModel->tampilkanData();

        $peminjamanbarangModel = new PeminjamanbarangModel();
        $dataPeminjaman = $peminjamanbarangModel->getPeminjamanBarang24Jam();


        // Menyiapkan data untuk disimpan
        $data = [
            'judul' => 'Tambah Pengeluaran | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'data_satuan' =>  $dataSatuan,
            'barang_persediaan' => $dataBarang,
            'data_peminjaman' => $dataPeminjaman,
        ];

        return view('pengeluaran/tambah_pengeluaran', $data);
    }





    public function getDataByPeminjamanId($peminjamanId)
    {
        $data = $this->pengeluaranModel->getPengeluaranByPeminjamanId($peminjamanId);

        // You may need to adjust this based on the actual structure of your data
        $data = json_encode($data);

        return $data;
    }

    public function getDataByPenggunaId($penggunaId)
    {
        $data = $this->pengeluaranmurnidetailModel->getDataByPenggunaId($penggunaId);

        // You may need to adjust this based on the actual structure of your data
        $data = json_encode($data);

        return $data;
    }

    public function ProsesTambahPengeluaran()
    {
        // Validasi input di sini jika diperlukan

        $pengeluaranModel = new PengeluaranModel();

        // Mendapatkan data dari formulir
        // Proses penyimpanan data ke database
        $peminjamanId = $this->request->getPost('peminjaman_id');
        $barangIds = $this->request->getPost('barang_id');
        $hargaSatuan = $this->request->getPost('harga_satuan');
        $ambilBarang = $this->request->getPost('ambil_barang');
        $jumlahHarga = $this->request->getPost('jumlah_harga');


        // Lakukan loop untuk menyimpan setiap barang ke database
        for ($i = 0; $i < count($barangIds); $i++) {
            $data = [
                'peminjaman_id' => $peminjamanId,
                'barang_id' => $barangIds[$i],
                'harga_satuan' => $hargaSatuan[$i],
                'ambil_barang' => $ambilBarang[$i],
                'jumlah_harga' => $jumlahHarga[$i],
            ];

            // Simpan data ke database
            $this->pengeluaranModel->insert($data);
            // Update stok barang
            $this->pengeluaranModel->updateStok($barangIds[$i], $ambilBarang[$i]);
        }

        // Dapatkan data baru yang disimpan
        $dataBaru = $this->pengeluaranModel->getPengeluaranByPeminjamanId($peminjamanId);

        // Kembalikan data baru ke tampilan
        echo json_encode(['status' => 'success', 'data' => $dataBaru]);
        exit();
    }


    public function get_detail($penerimaan_id)
    {
        $penerimaanpersediaanModel = new PenerimaanPersediaanModel();

        // Get details of the penerimaan
        $data['detail'] = $penerimaanpersediaanModel->getDetailPenerimaanById($penerimaan_id);

        // Calculate total_harga
        $totalHarga = 0;
        foreach ($data['detail'] as $item) {
            $totalHarga += $item['jumlah_harga'];
        }

        // Add total_harga to data
        $data['total_harga'] = $totalHarga;

        // Return JSON response
        return $this->response->setJSON($data);
    }

    public function hapusData($id)
    {
        // Dapatkan data yang akan dihapus
        $dataHapus = $this->pengeluaranModel->find($id);

        // Simpan nilai ambil_barang
        $ambilBarang = $dataHapus['ambil_barang'];

        // Hapus data berdasarkan ID
        $this->pengeluaranModel->delete($id);

        // Kembalikan nilai ambil_barang ke stok pada tabel persediaan barang
        $barangModel = new BarangPersediaanModel();

        // Dapatkan data barang berdasarkan barang_id
        $barangData = $barangModel->find($dataHapus['barang_id']);

        // Jumlahkan nilai ambil_barang ke stok
        $stokBaru = $barangData['stok'] + $ambilBarang;

        // Update nilai stok pada tabel persediaan barang
        $barangModel->update($dataHapus['barang_id'], ['stok' => $stokBaru]);

        // Dapatkan data baru yang disimpan
        $peminjamanId = $this->request->getPost('peminjaman_id');
        $dataBaru = $this->pengeluaranModel->getPengeluaranByPeminjamanId($peminjamanId);

        // Kembalikan data baru ke tampilan
        echo json_encode(['status' => 'success', 'data' => $dataBaru]);
        exit();
    }





    public function hapusPenerimaan($penerimaanId)
    {
        $penerimaanModel = new PenerimaanModel();
        $penerimaanModel->hapusPenerimaanById($penerimaanId);

        // Tambahkan logika atau tindakan lain yang sesuai dengan kebutuhan Anda
    }

    public function hapus($peminjamanId)
    {
        // Membuat instance model
        $peminjamanbarangModel = new \App\Models\PeminjamanbarangModel();

        // Melakukan pengecekan apakah peminjaman dengan ID tersebut ada dalam database
        $data_peminjaman = $peminjamanbarangModel->where('peminjaman_id', $peminjamanId)->findAll();

        if ($data_peminjaman) {
            // Jika peminjaman ditemukan, panggil fungsi hapusByPeminjamanId untuk menghapus data terkait
            $peminjamanbarangModel->hapusByPeminjamanId($peminjamanId);

            // Set pesan flash data untuk sukses
            session()->setFlashData('pesanHapusPeminjaman', 'Data Peminjaman berhasil dihapus.');

            // Redirect kembali ke halaman /pinjam/daftar setelah penghapusan
            return redirect()->to('/pinjam/daftar');
        } else {
            // Jika peminjaman tidak ditemukan, set pesan flash data untuk kesalahan
            session()->setFlashData('error', 'Data peminjaman tidak ditemukan.');

            // Redirect kembali ke halaman /pinjam/daftar setelah penghapusan (opsional)
            return redirect()->to('/pinjam/daftar');
        }
    }

    public function hapusDataByPeminjaman($peminjamanId)
    {
        // Membuat instance model
        $pengeluaranModel = new PengeluaranModel();

        // Memanggil metode hapusPeminjaman dari model
        $pengeluaranModel->hapusPeminjaman($peminjamanId);

        // Proses lain setelah penghapusan, jika diperlukan
    }
}
