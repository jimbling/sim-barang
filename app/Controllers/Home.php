<?php

namespace App\Controllers;

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
use App\Models\PihakluarDetailModel;
use App\Models\ReservasibarangModel;


class Home extends BaseController
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
    protected $pihakluardetailModel;
    protected $reservasibarangModel;


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
        $this->pihakluardetailModel = new PihakluarDetailModel();
        $this->reservasibarangModel = new ReservasibarangModel();
    }

    public function adminpanel()
    {
        session();
        $currentYear = date('Y');
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $pengeluaranModel = new PengeluaranModel();
        $dataPengeluaran = $pengeluaranModel->getAllPengeluaran();

        $peminjamanbarangModel = new PeminjamanbarangModel();
        $dataPeminjaman = $peminjamanbarangModel->hitungJumlahPeminjaman();

        $reservasibarangModel = new ReservasibarangModel();
        $dataBooking = $reservasibarangModel->hitungJumlahBooking();

        $barangModel = new BarangModel();
        $jumlahBarangRusak = $barangModel->hitungJumlahBarangRusak();
        $jumlahBarangBaik = $barangModel->hitungJumlahBarangBaik();

        $pihakluarDetailModel = new PihakluarDetailModel();
        $completeData = $pihakluarDetailModel->getCompleteData();

        $peminjamanModel = new PeminjamanModel();

        // Kata-kata yang dicari
        $keywords = ['Praktek Pembelajaran', 'Pengabdian Masyarakat', 'Penelitian', 'Belajar Mandiri', 'Kegiatan Lainnya'];

        // Inisialisasi array untuk menyimpan jumlah data berdasarkan keperluan
        $jumlahDataByKeperluan = [];

        // Menghitung jumlah data berdasarkan keperluan untuk tahun berjalan
        foreach ($keywords as $keyword) {
            $jumlahDataByKeperluan[$keyword] = $peminjamanModel->getByKeperluanKeyword($keyword, $currentYear);
        }

        $data = [
            'judul' => 'SIM Barang Lab Keperawatan | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'data_peminjaman' => $barangByStatus,
            'data_pengeluaran' => $dataPengeluaran,
            'jumlah_peminjaman' => $dataPeminjaman,
            'jumlah_barangRusak' => $jumlahBarangRusak,
            'jumlah_barangBaik' => $jumlahBarangBaik,
            'jumlah_data_by_keperluan' => $jumlahDataByKeperluan,
            'jumlah_booking' => $dataBooking,
            'keywords' => $keywords,
            'data_pinjamLuar' => $completeData,
        ];

        // Kirim data ke view atau lakukan hal lain sesuai kebutuhan
        return view('dashboard_admin', $data);
    }

    public function dashboard_user()
    {

        $currentYear = date('Y');
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $pengeluaranModel = new PengeluaranModel();
        $dataPengeluaran = $pengeluaranModel->getAllPengeluaran();


        $data = [
            'judul' => 'SIM Barang Lab Keperawatan | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'data_peminjaman' => $barangByStatus,
            'data_pengeluaran' =>  $dataPengeluaran,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('dashboard_user', $data);
    }

    public function bookingBaru()
    {
        session();
        $reservasibarangModel = new ReservasibarangModel();
        $dataBooking = $reservasibarangModel->hitungJumlahBooking();


        $data = [
            'jumlah_booking' => $dataBooking,
        ];

        // Kirim data ke view atau lakukan hal lain sesuai kebutuhan
        return view('tema/header', $data);
    }
}
