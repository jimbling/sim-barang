<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

use App\Models\BarangModel;
use App\Models\PeminjamanModel;
use App\Models\PeminjamanbarangModel;
use App\Models\MahasiswaModel;
use App\Models\RiwayatPeminjamanModel;
use App\Models\RuanganModel;
use App\Models\PenggunaanModel;
use App\Models\PembelajaranModel;
use App\Models\PengeluaranModel;
use App\Models\BarangPersediaanModel;
use App\Models\PengaturanModel;
use App\Models\DosenTendikModel;
use App\Models\PenerimaanPersediaanModel;
use App\Models\PengembalianbarangModel;
use App\Models\PengeluaranmurniModel;
use App\Models\PengeluaranmurniDetailModel;


class Laporan extends BaseController
{
    protected $barangModel;
    protected $peminjamanModel;
    protected $peminjamanbarangModel;
    protected $mahasiswaModel;
    protected $riwayatpeminjamanModel;
    protected $ruanganModel;
    protected $penggunaanModel;
    protected $pembelajaranModel;
    protected $pengeluaranModel;
    protected $barangPersediaanModel;
    protected $pengaturanModel;
    protected $dosentendikModel;
    protected $pengeluaranmurniModel;
    protected $pengeluaranmurnidetailModel;
    protected $settingsService;

    public function __construct()
    {

        $this->barangModel = new BarangModel();
        $this->peminjamanModel = new PeminjamanModel();
        $this->peminjamanbarangModel = new PeminjamanbarangModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->riwayatpeminjamanModel = new RiwayatPeminjamanModel();
        $this->ruanganModel = new RuanganModel();
        $this->penggunaanModel = new PenggunaanModel();
        $this->pembelajaranModel = new PembelajaranModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->barangPersediaanModel = new BarangPersediaanModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->dosentendikModel = new DosenTendikModel();
        $this->pengeluaranmurniModel = new PengeluaranmurniModel();
        $this->pengeluaranmurnidetailModel = new PengeluaranmurniDetailModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }

    // Halaman Pilihan untuk cetak
    public function laporanPeminjaman()
    {

        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $pengeluaranModel = new PengeluaranModel();
        $dataPengeluaran = $pengeluaranModel->getAllPengeluaran();

        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();


        $data = [
            'judul' => "Laporan Peminjaman | | $namaKampus",
            'currentYear' => $currentYear,
            'data_peminjaman' => $barangByStatus,
            'data_pengeluaran' =>  $dataPengeluaran,
            'years' => $years,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('cetak/cetak_laporan_peminjaman', $data);
    }

    // Cetak Laporan Peminjaman Berdasarakan Bulan dan Tahun
    public function cetakPinjamBulanTahun()
    {
        $namaKampus = $this->settingsService->getNamaKampus();

        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');

        $bulanOptions = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $month = str_pad($bulan, 2, '0', STR_PAD_LEFT);

        // Mendapatkan nama bulan berdasarkan nilai bulan dari array
        $namaBulan = $bulanOptions[$month];
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $dataByMonthYear = $riwayatPeminjamanModel->getDataByMonthAndYear($month, $year);

        $data = [
            'judul' => "Daftar Pinjam | $namaKampus",
            'data_peminjaman' => $dataByMonthYear,
            'dataPengaturan' => $dataPengaturan,
            'namaBulan' => $namaBulan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_peminjaman_bulan', $data);
    }

    // Cetak Laporan Peminjaman Berdasarakan Tahun
    public function cetakPinjamTahun()
    {
        $namaKampus = $this->settingsService->getNamaKampus();

        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $year = $this->request->getGet('tahun');


        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $dataByMonthYear = $riwayatPeminjamanModel->getDataByYear($year);

        $data = [
            'judul' => "Daftar Pinjam | $namaKampus",
            'data_peminjaman' => $dataByMonthYear,
            'dataPengaturan' => $dataPengaturan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_peminjaman_tahun', $data);
    }


    // Halaman depan pilihan bulan dan tahun
    public function laporanPersediaan()
    {

        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $pengeluaranModel = new PengeluaranModel();
        $dataPengeluaran = $pengeluaranModel->getAllPengeluaran();

        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();

        $pengeluaranmurniModel = new PengeluaranmurniModel();
        $tahunMurni = $pengeluaranmurniModel->getUniqueYears();


        $data = [
            'judul' => "Laporan Persediaan | $namaKampus",
            'currentYear' => $currentYear,
            'data_peminjaman' => $barangByStatus,
            'data_pengeluaran' =>  $dataPengeluaran,
            'years' => $years,
            'tahun_murni' => $tahunMurni,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('cetak/cetak_laporan_persediaan', $data);
    }

    // Cetak Laporan Penerimaan Barang Persediaan Berdasarakan Bulan dan Tahun
    public function cetakPenerimaanBulanTahun()
    {
        $namaKampus = $this->settingsService->getNamaKampus();

        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');

        $bulanOptions = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $month = str_pad($bulan, 2, '0', STR_PAD_LEFT);

        // Mendapatkan nama bulan berdasarkan nilai bulan dari array
        $namaBulan = $bulanOptions[$month];
        $penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $dataByMonthYear = $penerimaanpersediaanModel->getDataByMonthAndYear($month, $year);

        $data = [
            'judul' => "Daftar Pinjam | $namaKampus",
            'data_peminjaman' => $dataByMonthYear,
            'dataPengaturan' => $dataPengaturan,
            'namaBulan' => $namaBulan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_penerimaan_bulan', $data);
    }

    // Cetak Laporan Penerimaan Barang Persediaan Tahun
    public function cetakPenerimaanTahun()
    {
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $year = $this->request->getGet('tahun');


        $penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $dataByYear = $penerimaanpersediaanModel->getDataBYear($year);

        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'data_peminjaman' => $dataByYear,
            'dataPengaturan' => $dataPengaturan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_penerimaan_tahun', $data);
    }

    // Cetak Laporan Pengeluaran Barang Persediaan Berdasarakan Bulan dan Tahun
    public function cetakPengeluaranBulanTahun()
    {
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');

        $bulanOptions = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $month = str_pad($bulan, 2, '0', STR_PAD_LEFT);

        // Mendapatkan nama bulan berdasarkan nilai bulan dari array
        $namaBulan = $bulanOptions[$month];
        $pengeluaranModel = new PengeluaranModel();
        $dataByMonthYear = $pengeluaranModel->getDataByMonthAndYear($month, $year);

        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'data_pengeluaran' => $dataByMonthYear,
            'dataPengaturan' => $dataPengaturan,
            'namaBulan' => $namaBulan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_pengeluaran_bulan', $data);
    }

    // Cetak Laporan Penerimaan Barang Persediaan Tahun
    public function cetakPengeluaranTahun()
    {
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $year = $this->request->getGet('tahun');


        $pengeluaranModel = new PengeluaranModel();
        $dataByYearPengeluaran = $pengeluaranModel->getDataByYear($year);

        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'data_pengeluaranTahun' => $dataByYearPengeluaran,
            'dataPengaturan' => $dataPengaturan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_pengeluaran_tahun', $data);
    }


    // Cetak Laporan Pengembalian Barang Berdasarakan Bulan dan Tahun
    public function cetakKembaliBulanTahun()
    {
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');

        $bulanOptions = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $month = str_pad($bulan, 2, '0', STR_PAD_LEFT);

        // Mendapatkan nama bulan berdasarkan nilai bulan dari array
        $namaBulan = $bulanOptions[$month];
        $pengembalianbarangModel = new PengembalianbarangModel();
        $dataByMonthYear = $pengembalianbarangModel->getDataByMonthAndYear($month, $year);

        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'data_pengeluaran' => $dataByMonthYear,
            'dataPengaturan' => $dataPengaturan,
            'namaBulan' => $namaBulan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_pengembalian_bulan', $data);
    }

    // Cetak Laporan Pengembalian Barang Berdasarakan  Tahun
    public function cetakKembaliTahun()
    {
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $year = $this->request->getGet('tahun');


        $pengembalianbarangModel = new PengembalianbarangModel();
        $dataByYear = $pengembalianbarangModel->getDataByYear($year);

        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'data_pengeluaran' => $dataByYear,
            'dataPengaturan' => $dataPengaturan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_pengembalian_tahun', $data);
    }


    // Halaman depan pilihan Bulan dan Tahun untuk cetak Stock Opname
    public function laporanStockOpname()
    {
        $currentYear = date('Y');

        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();


        $data = [
            'judul' => 'Laporan Stock Opname | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'years' => $years,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('cetak/cetak_laporan_stock', $data);
    }



    // Cetak Laporan Stock Opname Barang Persediaan Berdasarakan Bulan dan Tahun
    public function laporanStockOpnameBulan()
    {
        $currentYear = date('Y');
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $penerimaanModel = new \App\Models\PenerimaanPersediaanModel();
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();

        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');

        $bulanOptions = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $month = str_pad($bulan, 2, '0', STR_PAD_LEFT);

        // Mendapatkan nama bulan berdasarkan nilai bulan dari array
        $namaBulan = $bulanOptions[$month];

        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanBarangData = $penerimaanModel->getAllBarangDataUntilYear($year);
        $pengeluaranBarangData = $pengeluaranModel->getBarangDataByMonthAndYear($month, $year);
        // Mendapatkan data pengeluaran murni
        $pengeluaranMurniModel = new \App\Models\PengeluaranmurniDetailModel();
        $pengeluaranMurniData = $pengeluaranMurniModel->getBarangDataByMonthAndYear($month, $year);

        // Menggabungkan data penerimaan, pengeluaran dengan peminjaman, dan pengeluaran murni
        $combinedData = $this->combineData($penerimaanBarangData, $pengeluaranBarangData, $pengeluaranMurniData);

        // Menghitung stok barang
        $stockData = $this->calculateStock($combinedData);



        $data = [
            'judul' => 'Laporan Peminjaman | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'data_penerimaan' => $penerimaanBarangData,
            'data_pengeluaran' => $pengeluaranBarangData,
            'years' => $years,
            'stockData' => $stockData, // Menambahkan data stok ke array data
            'namaBulan' => $namaBulan,
            'tahun' => $year,
            'dataPengaturan' => $dataPengaturan,
            'data_pengeluaran_murni' => $pengeluaranMurniData,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('cetak/laporan_stock_bulan', $data);
    }




    public function laporanStockOpnameTahun()
    {
        $currentYear = date('Y');
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $penerimaanModel = new \App\Models\PenerimaanPersediaanModel();
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();


        $year = $this->request->getGet('tahun');



        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanBarangData = $penerimaanModel->getBarangDataByYear($year);
        $pengeluaranBarangData = $pengeluaranModel->getBarangDataByYear($year);

        // Mendapatkan data pengeluaran murni
        $pengeluaranMurniModel = new \App\Models\PengeluaranmurniDetailModel();
        $pengeluaranMurniData = $pengeluaranMurniModel->getBarangDataByYear($year);
        // Menggabungkan data penerimaan dan pengeluaran berdasarkan barang_id
        $combinedData = $this->combineData($penerimaanBarangData, $pengeluaranBarangData, $pengeluaranMurniData);

        // Menghitung stok barang
        $stockDataTahun = $this->calculateStock($combinedData);

        $data = [
            'judul' => 'Laporan Peminjaman | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'data_penerimaan' => $penerimaanBarangData,
            'data_pengeluaran' => $pengeluaranBarangData,
            'years' => $years,
            'stockDataTahun' => $stockDataTahun, // Menambahkan data stok ke array data
            'tahun' => $year,
            'dataPengaturan' => $dataPengaturan,
            'data_pengeluaran_murni' => $pengeluaranMurniData,
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('cetak/laporan_stock_tahun', $data);
    }

    public function laporanStockRekapOpname()
    {
        $currentYear = date('Y');
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $penerimaanModel = new \App\Models\PenerimaanPersediaanModel();
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();


        $year = $this->request->getGet('tahun');



        $penerimaanModel = new \App\Models\PenerimaanPersediaanModel();
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $pengeluaranmurnidetailModel = new \App\Models\PengeluaranmurniDetailModel();

        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanData = $penerimaanModel->getAllBarangDataUntilYear($year);
        $pengeluaranData = $pengeluaranModel->getAllBarangDataUntilYear($year);
        $pengeluaranMurniData = $pengeluaranmurnidetailModel->getBarangDataByYear($year);


        // Menggabungkan data penerimaan dan pengeluaran berdasarkan barang_id
        $combinedDataUntilYear = $this->combineData($penerimaanData, $pengeluaranData, $pengeluaranMurniData);

        // Menghitung stok barang
        $stockDataUntilYear = $this->calculateStock($combinedDataUntilYear);

        $data = [
            'judul' => 'Laporan Peminjaman | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'data_penerimaan' => $penerimaanData,
            'data_pengeluaran' => $pengeluaranData,
            'years' => $years,
            'stockDataRekap' => $stockDataUntilYear, // Menambahkan data stok ke array data
            'tahun' => $year,
            'dataPengaturan' => $dataPengaturan,
            'data_pengeluaran_murni' => $pengeluaranMurniData,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('cetak/laporan_stock_rekap', $data);
    }


    public function calculateStockByMonthAndYear($month, $year)
    {
        $penerimaanModel = new \App\Models\PenerimaanPersediaanModel();
        $pengeluaranModel = new \App\Models\PengeluaranModel();

        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanData = $penerimaanModel->getBarangDataByMonthAndYear($month, $year);
        $pengeluaranData = $pengeluaranModel->getBarangDataByMonthAndYear($month, $year);

        // Menggabungkan data penerimaan dan pengeluaran berdasarkan barang_id
        $combinedData = $this->combineData($penerimaanData, $pengeluaranData);

        // Menghitung stok barang
        $stockData = $this->calculateStock($combinedData);

        // Lakukan sesuatu dengan data stok barang
        // ...

        return $stockData;
    }


    // Fungsi untuk menggabungkan data penerimaan dan pengeluaran
    protected function combineData($penerimaanData, $pengeluaranData, $pengeluaranMurniData)
    {
        $combinedData = [];

        // Menggabungkan data penerimaan
        foreach ($penerimaanData as $penerimaan) {
            $barangId = $penerimaan['barang_id'];

            $combinedData[$barangId]['barang_id'] = $barangId;
            $combinedData[$barangId]['nama_barang'] = $penerimaan['nama_barang'];
            $combinedData[$barangId]['harga_satuan'] = $penerimaan['harga_satuan'];
            $combinedData[$barangId]['jumlah_barang'] = $penerimaan['jumlah_barang'];
            $combinedData[$barangId]['ambil_barang'] = 0; // Set nilai default 0
            $combinedData[$barangId]['ambil_barang_murni'] = 0; // Set nilai default 0
            // Tambahkan informasi satuan barang ke dalam array combinedData
            $combinedData[$barangId]['satuan'] = $penerimaan['satuan']; // Anda harus memastikan bahwa informasi satuan tersedia dalam $penerimaanData
        }

        // Menggabungkan data pengeluaran
        foreach ($pengeluaranData as $pengeluaran) {
            $barangId = $pengeluaran['barang_id'];

            if (!isset($combinedData[$barangId])) {
                $combinedData[$barangId]['barang_id'] = $barangId;
                $combinedData[$barangId]['nama_barang'] = $pengeluaran['nama_barang'];
                $combinedData[$barangId]['harga_satuan'] = $pengeluaran['harga_satuan'];
                $combinedData[$barangId]['jumlah_barang'] = 0;
                $combinedData[$barangId]['ambil_barang'] = 0;
                $combinedData[$barangId]['ambil_barang_murni'] = 0;
                // Tambahkan informasi satuan barang ke dalam array combinedData
                $combinedData[$barangId]['satuan'] = $pengeluaran['satuan']; // Anda harus memastikan bahwa informasi satuan tersedia dalam $pengeluaranData
            }

            $combinedData[$barangId]['ambil_barang'] += $pengeluaran['ambil_barang'];
        }

        // Menggabungkan data pengeluaran murni
        foreach ($pengeluaranMurniData as $pengeluaranMurni) {
            $barangId = $pengeluaranMurni['barang_id'];

            if (!isset($combinedData[$barangId])) {
                $combinedData[$barangId]['barang_id'] = $barangId;
                $combinedData[$barangId]['nama_barang'] = $pengeluaranMurni['nama_barang'];
                $combinedData[$barangId]['harga_satuan'] = $pengeluaranMurni['harga_satuan'];
                $combinedData[$barangId]['jumlah_barang'] = 0;
                $combinedData[$barangId]['ambil_barang'] = 0;
                // Tambahkan informasi satuan barang ke dalam array combinedData
                $combinedData[$barangId]['satuan'] = $pengeluaranMurni['satuan']; // Anda harus memastikan bahwa informasi satuan tersedia dalam $pengeluaranMurniData
            }

            $combinedData[$barangId]['ambil_barang'] += $pengeluaranMurni['ambil_barang_murni'];
        }

        return $combinedData;
    }




    // Fungsi untuk menghitung stok barang
    protected function calculateStock($combinedData)
    {
        $stockData = [];

        foreach ($combinedData as $barangData) {
            // Menghitung stok barang dengan memperhitungkan pengeluaran dan pengeluaran murni
            $stokBarang = $barangData['jumlah_barang'] - ($barangData['ambil_barang'] + $barangData['ambil_barang_murni']);

            $stockData[] = [
                'barang_id' => $barangData['barang_id'],
                'nama_barang' => $barangData['nama_barang'],
                'harga_satuan' => $barangData['harga_satuan'],
                'satuan' => $barangData['satuan'],
                'stok_barang' => $stokBarang,
            ];
        }

        return $stockData;
    }


    public function calculateStockByYear($year)
    {
        $penerimaanModel = new \App\Models\PenerimaanPersediaanModel();
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $pengeluaranMurniModel = new \App\Models\PengeluaranmurniDetailModel();

        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanData = $penerimaanModel->getBarangDataByYear($year);
        $pengeluaranData = $pengeluaranModel->getBarangDataByYear($year);
        $pengeluaranMurniData = $pengeluaranMurniModel->getBarangDataByYear($year);
        // Menggabungkan data penerimaan dan pengeluaran berdasarkan barang_id
        $combinedData = $this->combineData($penerimaanData, $pengeluaranData, $pengeluaranMurniData);

        // Menghitung stok barang
        $stockDataTahun = $this->calculateStock($combinedData);

        // Lakukan sesuatu dengan data stok barang
        // ...

        return $stockDataTahun;
    }

    public function calculateStockUntilYear($year)
    {
        $penerimaanModel = new \App\Models\PenerimaanPersediaanModel();
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $pengeluaranMurniModel = new \App\Models\PengeluaranmurniDetailModel();

        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanData = $penerimaanModel->getAllBarangDataUntilYear($year);
        $pengeluaranData = $pengeluaranModel->getAllBarangDataUntilYear($year);
        $pengeluaranMurniData = $pengeluaranMurniModel->getBarangDataByYear($year);

        // Menggabungkan data penerimaan dan pengeluaran berdasarkan barang_id
        $combinedDataUntilYear = $this->combineData($penerimaanData, $pengeluaranData,  $pengeluaranMurniData);

        // Menghitung stok barang
        $stockDataUntilYear = $this->calculateStock($combinedDataUntilYear);

        // Lakukan sesuatu dengan data stok barang
        // ...

        return $stockDataUntilYear;
    }

    // Cetak Laporan Mutasi Barang Persediaan Berdasarakan Bulan dan Tahun
    public function laporanMutasiBulan()
    {
        $currentYear = date('Y');
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $penerimaanModel = new \App\Models\PenerimaanPersediaanModel();
        $pengeluaranModel = new \App\Models\PengeluaranModel();
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();

        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');

        $bulanOptions = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $month = str_pad($bulan, 2, '0', STR_PAD_LEFT);

        // Mendapatkan nama bulan berdasarkan nilai bulan dari array
        $namaBulan = $bulanOptions[$month];

        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanBarangData = $penerimaanModel->getAllBarangDataUntilYear($year);
        $pengeluaranBarangData = $pengeluaranModel->getBarangDataByMonthAndYear($month, $year);
        $pengeluaranMurniModel = new \App\Models\PengeluaranmurniDetailModel();
        $pengeluaranMurniData = $pengeluaranMurniModel->getBarangDataByMonthAndYear($month, $year);



        $data = [
            'judul' => 'Laporan Peminjaman | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'data_penerimaan' => $penerimaanBarangData,
            'data_pengeluaran' => $pengeluaranBarangData,
            'years' => $years,
            'namaBulan' => $namaBulan,
            'tahun' => $year,
            'dataPengaturan' => $dataPengaturan,
            'data_pengeluaran_murni' => $pengeluaranMurniData,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('cetak/laporan_mutasi_bulan', $data);
    }


    public function cetakPengeluaranMurniBT()
    {
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');

        $bulanOptions = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $month = str_pad($bulan, 2, '0', STR_PAD_LEFT);

        // Mendapatkan nama bulan berdasarkan nilai bulan dari array
        $namaBulan = $bulanOptions[$month];
        $pengeluaranmurnidetailModel = new PengeluaranmurniDetailModel();
        $dataByMonthYear = $pengeluaranmurnidetailModel->getDataByMonthAndYear($month, $year);

        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'data_pengeluaran' => $dataByMonthYear,
            'dataPengaturan' => $dataPengaturan,
            'namaBulan' => $namaBulan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_pengeluaran_murni_bulan', $data);
    }

    public function cetakPengeluaranMurniT()
    {
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $year = $this->request->getGet('tahun');


        $pengeluaranmurnidetailModel = new PengeluaranmurniDetailModel();
        $dataByYearPengeluaran = $pengeluaranmurnidetailModel->getDataByYear($year);

        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'data_pengeluaranTahun' => $dataByYearPengeluaran,
            'dataPengaturan' => $dataPengaturan,
            'tahun' => $year,
        ];

        // Load view laporan_peminjaman_bulan.php
        return view('cetak/laporan_pengeluaran_murni_tahun', $data);
    }
}
