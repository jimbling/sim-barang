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
use App\Models\StokBulananModel;


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

        // Mendapatkan nama bulan berdasarkan nilai bulan dari array
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
        $namaBulan = $bulanOptions[$month];

        // Mendapatkan data dari model berdasarkan bulan dan tahun
        $pengembalianbarangModel = new PengembalianbarangModel();
        $dataByMonthYear = $pengembalianbarangModel->getDataByMonthAndYear($month, $year);

        // Inisialisasi array untuk mengelompokkan data berdasarkan kode_kembali
        $groupedData = [];

        // Mengelompokkan data berdasarkan kode_kembali
        foreach ($dataByMonthYear as $data) {
            $kodeKembali = $data['kode_kembali'];
            $groupedData[$kodeKembali][] = $data;
        }

        // Mengirimkan data ke view
        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'groupedData' => $groupedData, // Mengirimkan data yang telah dikelompokkan
            'dataPengaturan' => $dataPengaturan,
            'namaBulan' => $namaBulan,
            'tahun' => $year,
        ];

        // Load view laporan_pengembalian_bulan.php dengan data yang dikirimkan
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
        // Inisialisasi array untuk mengelompokkan data berdasarkan kode_kembali
        $groupedData = [];

        // Mengelompokkan data berdasarkan kode_kembali
        foreach ($dataByYear as $data) {
            $kodeKembali = $data['kode_kembali'];
            $groupedData[$kodeKembali][] = $data;
        }


        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'groupedDataByYear' => $groupedData, // Mengirimkan data yang telah dikelompokkan
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

        // Tahun mulai (misalnya, 2023)
        $tahunMulai = 2023;
        // Tahun saat ini
        $tahunSekarang = date('Y');
        // Generate array tahun dari tahunMulai hingga tahunSekarang
        $years = range($tahunMulai, $tahunSekarang);

        // Data bulan
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

        // Menyusun data yang akan dikirim ke view
        $data = [
            'judul' => 'Laporan Stock Opname | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'years' => $years,
            'bulanOptions' => $bulanOptions, // Menambahkan bulan options ke view
        ];

        // Kirim data ke view atau lakukan hal lain sesuai kebutuhan
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
        // Konversi nama bulan menjadi angka bulan


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

    public function lihatMutasiBulan()
    {
        $currentYear = date('Y');
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $penerimaanModel = new PenerimaanPersediaanModel();
        $pengeluaranModel = new PengeluaranModel();
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();

        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');
        $stokBulananModel = new StokBulananModel();
        $stockAwal = $stokBulananModel->getDataBulanTahunSebelumnya($bulan, $year);

        // Memeriksa apakah data sudah ada untuk bulan dan tahun tertentu
        $isDataExists = $stokBulananModel->checkIfDataExists($bulan, $year);

        // Lanjutkan proses seperti biasa
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
        $namaBulan = $bulanOptions[$month];

        // Konversi nama bulan menjadi angka bulan
        $bulanAngka = array_search($namaBulan, $bulanOptions);
        if (!$bulanAngka) {
            $bulanAngka = '01'; // Default jika nama bulan tidak ditemukan
        }

        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanBarangData = $penerimaanModel->getBarangDataByMonthAndYear($month, $year);
        $pengeluaranBarangData = $pengeluaranModel->getBarangDataByMonthAndYear($month, $year);
        $pengeluaranMurniModel = new PengeluaranmurniDetailModel();
        $pengeluaranMurniData = $pengeluaranMurniModel->getBarangDataByMonthAndYear($month, $year);

        // Menentukan jumlah barang yang unik
        $uniqueBarangIds = array_unique(array_merge(
            array_column($penerimaanBarangData, 'barang_id'),
            array_column($pengeluaranBarangData, 'barang_id'),
            array_column($pengeluaranMurniData, 'barang_id'),
            array_column($stockAwal, 'barang_id') // Tambahkan barang_id dari stok awal
        ));

        $barangList = [];

        foreach ($uniqueBarangIds as $barangId) {
            $barangInfo = [
                'barang_id' => $barangId,
                'nama_barang' => '',
                'harga_satuan' => 0,
                'jumlah_saldo_awal' => 0,
                'jumlah_penerimaan' => 0,
                'jumlah_penerimaan_total' => 0,
                'jumlah_pengeluaran' => 0,
                'jumlah_pengeluaran_murni' => 0,
                'sisa_stok' => 0,
                'satuan' => 'Pcs',
            ];

            // Cari data penerimaan untuk barang ini
            $penerimaanIndex = array_search($barangId, array_column($penerimaanBarangData, 'barang_id'));
            if ($penerimaanIndex !== false) {
                $barangInfo['nama_barang'] = $penerimaanBarangData[$penerimaanIndex]['nama_barang'];
                $barangInfo['harga_satuan'] = $penerimaanBarangData[$penerimaanIndex]['harga_satuan'];
                $barangInfo['jumlah_penerimaan'] = $penerimaanBarangData[$penerimaanIndex]['jumlah_barang'];
            }

            // Cari data pengeluaran untuk barang ini
            $pengeluaranIndex = array_search($barangId, array_column($pengeluaranBarangData, 'barang_id'));
            if ($pengeluaranIndex !== false) {
                $barangInfo['nama_barang'] = $pengeluaranBarangData[$pengeluaranIndex]['nama_barang'];
                $barangInfo['harga_satuan'] = $pengeluaranBarangData[$pengeluaranIndex]['harga_satuan'];
                $barangInfo['jumlah_pengeluaran'] = $pengeluaranBarangData[$pengeluaranIndex]['ambil_barang'];
            }

            // Cari data pengeluaran murni untuk barang ini
            $pengeluaranMurniIndex = array_search($barangId, array_column($pengeluaranMurniData, 'barang_id'));
            if ($pengeluaranMurniIndex !== false) {
                $barangInfo['nama_barang'] = $pengeluaranMurniData[$pengeluaranMurniIndex]['nama_barang'];
                $barangInfo['harga_satuan'] = $pengeluaranMurniData[$pengeluaranMurniIndex]['harga_satuan'];
                $barangInfo['jumlah_pengeluaran_murni'] = $pengeluaranMurniData[$pengeluaranMurniIndex]['ambil_barang_murni'];
            }

            // Cari saldo awal untuk barang ini dari stok awal
            foreach ($stockAwal as $saldo) {
                if ($saldo->barang_id == $barangId) {
                    $barangInfo['jumlah_saldo_awal'] = $saldo->sisa_stok;
                    // Ambil harga_satuan dari stok awal jika belum diisi
                    if ($barangInfo['harga_satuan'] == 0) {
                        $barangInfo['harga_satuan'] = $saldo->harga_satuan;
                    }
                    break;
                }
            }

            // Cari data setok untuk memperbarui nama_barang dan satuan jika ada
            foreach ($stockAwal as $saldo) {
                if ($saldo->barang_id == $barangId) {
                    $barangInfo['nama_barang'] = $saldo->nama_barang;
                    $barangInfo['satuan'] = $saldo->satuan;
                    break;
                }
            }

            // Hitung jumlah penerimaan total (termasuk saldo awal)
            $barangInfo['jumlah_penerimaan_total'] = $barangInfo['jumlah_saldo_awal'] + $barangInfo['jumlah_penerimaan'];

            // Hitung sisa stok
            $barangInfo['sisa_stok'] = $barangInfo['jumlah_penerimaan_total'] - ($barangInfo['jumlah_pengeluaran'] + $barangInfo['jumlah_pengeluaran_murni']);

            // Tambahkan ke daftar barang
            $barangList[] = $barangInfo;
        }
        // Totalkan saldo awal dari semua barang
        $totalJumlahSaldo = array_sum(array_column($barangList, 'jumlah_saldo_awal'));

        $totalJumlahPenerimaan = array_sum(array_column($barangList, 'jumlah_penerimaan'));
        $totalJumlahPengeluaran = array_sum(array_column($barangList, 'jumlah_pengeluaran'));
        $totalJumlahPengeluaranMurni = array_sum(array_column($barangList, 'jumlah_pengeluaran_murni'));
        $totalSisaStok = array_sum(array_column($barangList, 'sisa_stok'));

        $data = [
            'judul' => 'Lihat Stok Bulanan | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'barangList' => $barangList,
            'totalJumlahPenerimaan' => $totalJumlahPenerimaan,
            'totalJumlahPengeluaran' => $totalJumlahPengeluaran,
            'totalJumlahPengeluaranMurni' => $totalJumlahPengeluaranMurni,
            'totalSisaStok' => $totalSisaStok,
            'totalSaldoAwal' => $totalJumlahSaldo,
            'years' => $years,
            'namaBulan' => $namaBulan,
            'bulanAngka' => $bulanAngka,
            'tahun' => $year,
            'dataPengaturan' => $dataPengaturan,
            'setok' => $stockAwal,
            'isDataExists' => $isDataExists // Menyertakan status apakah data sudah ada
        ];

        // Update nama_barang dan satuan dari setok ke barangList
        foreach ($barangList as &$barang) {
            foreach ($stockAwal as $saldo) {
                if ($saldo->barang_id == $barang['barang_id']) {
                    $barang['nama_barang'] = $saldo->nama_barang;
                    $barang['satuan'] = $saldo->satuan;
                    break;
                }
            }
        }

        return view('persediaan/stok_bulanan', $data);
    }


    public function cetakDaftarMutasiPersediaan()
    {
        $currentYear = date('Y');
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $penerimaanModel = new PenerimaanPersediaanModel();
        $pengeluaranModel = new PengeluaranModel();
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();

        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');
        $stokBulananModel = new StokBulananModel();
        $stockAwal = $stokBulananModel->getDataBulanTahunSebelumnya($bulan, $year);

        // Memeriksa apakah data sudah ada untuk bulan dan tahun tertentu
        $isDataExists = $stokBulananModel->checkIfDataExists($bulan, $year);

        // Lanjutkan proses seperti biasa
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
        $namaBulan = $bulanOptions[$month];

        // Konversi nama bulan menjadi angka bulan
        $bulanAngka = array_search($namaBulan, $bulanOptions);
        if (!$bulanAngka) {
            $bulanAngka = '01'; // Default jika nama bulan tidak ditemukan
        }

        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanBarangData = $penerimaanModel->getBarangDataByMonthAndYear($month, $year);
        $pengeluaranBarangData = $pengeluaranModel->getBarangDataByMonthAndYear($month, $year);
        $pengeluaranMurniModel = new PengeluaranmurniDetailModel();
        $pengeluaranMurniData = $pengeluaranMurniModel->getBarangDataByMonthAndYear($month, $year);

        // Menentukan jumlah barang yang unik
        $uniqueBarangIds = array_unique(array_merge(
            array_column($penerimaanBarangData, 'barang_id'),
            array_column($pengeluaranBarangData, 'barang_id'),
            array_column($pengeluaranMurniData, 'barang_id'),
            array_column($stockAwal, 'barang_id') // Tambahkan barang_id dari stok awal
        ));

        $barangList = [];

        foreach ($uniqueBarangIds as $barangId) {
            $barangInfo = [
                'barang_id' => $barangId,
                'nama_barang' => '',
                'harga_satuan' => 0,
                'jumlah_saldo_awal' => 0,
                'jumlah_penerimaan' => 0,
                'jumlah_penerimaan_total' => 0,
                'jumlah_pengeluaran' => 0,
                'jumlah_pengeluaran_murni' => 0,
                'sisa_stok' => 0,
                'satuan' => 'Pcs',
            ];

            // Cari data penerimaan untuk barang ini
            $penerimaanIndex = array_search($barangId, array_column($penerimaanBarangData, 'barang_id'));
            if ($penerimaanIndex !== false) {
                $barangInfo['nama_barang'] = $penerimaanBarangData[$penerimaanIndex]['nama_barang'];
                $barangInfo['harga_satuan'] = $penerimaanBarangData[$penerimaanIndex]['harga_satuan'];
                $barangInfo['jumlah_penerimaan'] = $penerimaanBarangData[$penerimaanIndex]['jumlah_barang'];
            }

            // Cari data pengeluaran untuk barang ini
            $pengeluaranIndex = array_search($barangId, array_column($pengeluaranBarangData, 'barang_id'));
            if ($pengeluaranIndex !== false) {
                $barangInfo['nama_barang'] = $pengeluaranBarangData[$pengeluaranIndex]['nama_barang'];
                $barangInfo['harga_satuan'] = $pengeluaranBarangData[$pengeluaranIndex]['harga_satuan'];
                $barangInfo['jumlah_pengeluaran'] = $pengeluaranBarangData[$pengeluaranIndex]['ambil_barang'];
            }

            // Cari data pengeluaran murni untuk barang ini
            $pengeluaranMurniIndex = array_search($barangId, array_column($pengeluaranMurniData, 'barang_id'));
            if ($pengeluaranMurniIndex !== false) {
                $barangInfo['nama_barang'] = $pengeluaranMurniData[$pengeluaranMurniIndex]['nama_barang'];
                $barangInfo['harga_satuan'] = $pengeluaranMurniData[$pengeluaranMurniIndex]['harga_satuan'];
                $barangInfo['jumlah_pengeluaran_murni'] = $pengeluaranMurniData[$pengeluaranMurniIndex]['ambil_barang_murni'];
            }

            // Cari saldo awal untuk barang ini dari stok awal
            foreach ($stockAwal as $saldo) {
                if ($saldo->barang_id == $barangId) {
                    $barangInfo['jumlah_saldo_awal'] = $saldo->sisa_stok;
                    // Ambil harga_satuan dari stok awal jika belum diisi
                    if ($barangInfo['harga_satuan'] == 0) {
                        $barangInfo['harga_satuan'] = $saldo->harga_satuan;
                    }
                    break;
                }
            }

            // Cari data setok untuk memperbarui nama_barang dan satuan jika ada
            foreach ($stockAwal as $saldo) {
                if ($saldo->barang_id == $barangId) {
                    $barangInfo['nama_barang'] = $saldo->nama_barang;
                    $barangInfo['satuan'] = $saldo->satuan;
                    break;
                }
            }

            // Hitung jumlah penerimaan total (termasuk saldo awal)
            $barangInfo['jumlah_penerimaan_total'] = $barangInfo['jumlah_saldo_awal'] + $barangInfo['jumlah_penerimaan'];

            // Hitung sisa stok
            $barangInfo['sisa_stok'] = $barangInfo['jumlah_penerimaan_total'] - ($barangInfo['jumlah_pengeluaran'] + $barangInfo['jumlah_pengeluaran_murni']);

            // Tambahkan ke daftar barang
            $barangList[] = $barangInfo;
        }
        // Totalkan saldo awal dari semua barang
        $totalJumlahSaldo = array_sum(array_column($barangList, 'jumlah_saldo_awal'));

        $totalJumlahPenerimaan = array_sum(array_column($barangList, 'jumlah_penerimaan'));
        $totalJumlahPengeluaran = array_sum(array_column($barangList, 'jumlah_pengeluaran'));
        $totalJumlahPengeluaranMurni = array_sum(array_column($barangList, 'jumlah_pengeluaran_murni'));
        $totalSisaStok = array_sum(array_column($barangList, 'sisa_stok'));

        $data = [
            'judul' => 'Lihat Stok Bulanan | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'barangList' => $barangList,
            'totalJumlahPenerimaan' => $totalJumlahPenerimaan,
            'totalJumlahPengeluaran' => $totalJumlahPengeluaran,
            'totalJumlahPengeluaranMurni' => $totalJumlahPengeluaranMurni,
            'totalSisaStok' => $totalSisaStok,
            'totalSaldoAwal' => $totalJumlahSaldo,
            'years' => $years,
            'namaBulan' => $namaBulan,
            'bulanAngka' => $bulanAngka,
            'tahun' => $year,
            'dataPengaturan' => $dataPengaturan,
            'setok' => $stockAwal,
            'isDataExists' => $isDataExists // Menyertakan status apakah data sudah ada
        ];

        // Update nama_barang dan satuan dari setok ke barangList
        foreach ($barangList as &$barang) {
            foreach ($stockAwal as $saldo) {
                if ($saldo->barang_id == $barang['barang_id']) {
                    $barang['nama_barang'] = $saldo->nama_barang;
                    $barang['satuan'] = $saldo->satuan;
                    break;
                }
            }
        }

        return view('cetak/cetak_daf_mutasi_persediaan', $data);
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

    public function simpanStokBulanan()
    {
        $stokBulananModel = new \App\Models\StokBulananModel();

        $barangIds = $this->request->getPost('barang_id');
        $hargaSatuans = $this->request->getPost('harga_satuan');
        $sisaStoks = $this->request->getPost('sisa_stok');
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $dataToInsert = [];
        foreach ($barangIds as $index => $barangId) {
            $dataToInsert[] = [
                'barang_id' => $barangId,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'harga_satuan' => $hargaSatuans[$index],
                'sisa_stok' => $sisaStoks[$index],
            ];
        }

        if ($stokBulananModel->insertBatch($dataToInsert)) {
            return redirect()->to('laporan/stock')->with('success', 'Data stok bulanan berhasil disimpan.');
        } else {
            return redirect()->to('laporan/stock')->with('error', 'Gagal menyimpan data stok bulanan.');
        }
    }

    public function hapusStokBulanan()
    {
        // Ambil bulan dan tahun dari input form
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        // Instansiasi model
        $stokBulananModel = new StokBulananModel();

        // Hapus data berdasarkan bulan dan tahun
        $result = $stokBulananModel->hapusDataBerdasarkanBulanTahun($bulan, $tahun);

        // Redirect dengan pesan sukses atau gagal
        if ($result) {
            return redirect()->back()->with('message', 'Data stok bulanan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data stok bulanan.');
        }
    }

    public function cetakStokBulanan()
    {

        $currentYear = date('Y');
        $currentYear = date('Y');

        // Tahun mulai (misalnya, 2023)
        $tahunMulai = 2023;
        // Tahun saat ini
        $tahunSekarang = date('Y');
        // Generate array tahun dari tahunMulai hingga tahunSekarang
        $years = range($tahunMulai, $tahunSekarang);
        $data = [
            'judul' => 'Cetak Stok Bulanan | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'years' => $years
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('cetak/cetak_stok_bulanan', $data);
    }

    public function cetakStok()
    {

        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);

        $data = [
            'base_url' => base_url(),
            'dataPengaturan' => $dataPengaturan,

        ];

        return view('cetak/cetak_stok', $data);
    }
}
