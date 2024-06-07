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
use App\Models\PihakluarDetailModel;
use App\Models\ReservasibarangModel;
use App\Models\NotificationModel;
use App\Models\AlertModel;
use App\Models\PengeluaranmurniModel;


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
    protected $notificationModel;
    protected $alertModel;
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
        $this->pihakluardetailModel = new PihakluarDetailModel();
        $this->reservasibarangModel = new ReservasibarangModel();
        $this->notificationModel = new NotificationModel();
        $this->alertModel = new AlertModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }

    public function adminpanel()
    {
        session();
        $currentYear = date('Y');
        $csrfToken = csrf_hash();
        $namaKampus = $this->settingsService->getNamaKampus();

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
        $notificationModel = new AlertModel();

        $alertModel = $notificationModel->getNotificationsToShow();
        $peminjamanModel = new PeminjamanModel();

        // Kata-kata yang dicari
        $keywords = ['Praktek Pembelajaran', 'Pengabdian Masyarakat', 'Penelitian', 'Belajar Mandiri', 'Kegiatan Lainnya'];

        // Inisialisasi array untuk menyimpan jumlah data berdasarkan keperluan
        $jumlahDataByKeperluan = [];

        // Menghitung jumlah data berdasarkan keperluan untuk tahun berjalan
        foreach ($keywords as $keyword) {
            $jumlahDataByKeperluan[$keyword] = $peminjamanModel->getByKeperluanKeyword($keyword, $currentYear);
        }

        $model = new PengeluaranmurniModel();

        // Waktu 12 jam yang lalu dari sekarang
        $waktu12JamLalu = date('Y-m-d H:i:s', strtotime('-12 hours'));

        // Mencari data baru berdasarkan waktu pembuatan dalam 12 jam terakhir
        $queryDataBaru = $model->where('created_at >', $waktu12JamLalu)->findAll();

        // Mencari jumlah total data dalam database
        $jumlahTotalData = $model->countAll();

        // Jumlah data baru dalam 12 jam terakhir
        $jumlahDataBaru = count($queryDataBaru);

        $data = [
            'judul' => "SIM Lab | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,
            'data_peminjaman' => $barangByStatus,
            'data_pengeluaran' => $dataPengeluaran,
            'jumlah_peminjaman' => $dataPeminjaman,
            'jumlah_barangRusak' => $jumlahBarangRusak,
            'jumlah_barangBaik' => $jumlahBarangBaik,
            'jumlah_data_by_keperluan' => $jumlahDataByKeperluan,
            'jumlah_booking' => $dataBooking,
            'bhp_baru' => $jumlahDataBaru,
            'keywords' => $keywords,
            'data_pinjamLuar' => $completeData,
            'alert' => $alertModel
        ];

        // Kirim data ke view atau lakukan hal lain sesuai kebutuhan
        return view('dashboard_admin', $data);
    }

    public function dashboard_user()
    {
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        // Memanggil fungsi untuk menghitung jumlah peminjaman berdasarkan user_id
        $userId = session()->get('id'); // Ambil user_id dari sesi
        $jumlahPeminjaman = $peminjamanbarangModel->countUniquePeminjamanByDate($userId);

        // Menghitung jumlah baris dari hasil peminjaman
        $jumlahBaris = count($jumlahPeminjaman);

        $pengeluaranModel = new PengeluaranModel();
        $dataPengeluaran = $pengeluaranModel->getAllPengeluaran();

        $data = [
            'judul' => "SIM Lab | $namaKampus",
            'currentYear' => $currentYear,
            'data_peminjaman' => $barangByStatus,
            'data_pengeluaran' =>  $dataPengeluaran,
            'jumlah_peminjaman' => $jumlahPeminjaman,
            'jumlah_baris' => $jumlahBaris, // Menambahkan jumlah baris ke dalam data
        ];

        // Kirim data ke view atau lakukan hal lain sesuai kebutuhan
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

    public function update_tanggal_kembali($id)
    {
        if ($this->request->isAJAX()) {
            $tanggalKembali = $this->request->getPost('tanggalKembali');

            // Ubah format tanggal
            $tanggalKembali = date('Y-m-d H:i:s', strtotime($tanggalKembali));

            $peminjamanModel = new PeminjamanModel();
            $peminjamanModel->updateTanggalKembali($id, $tanggalKembali);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Tanggal kembali berhasil diperbarui.']);
        } else {
            // Handle request if not AJAX
            return redirect()->back();
        }
    }

    public function get_data_peminjaman($id)
    {
        $peminjamanModel = new PeminjamanModel();
        $data = $peminjamanModel->find($id); // Mengambil data berdasarkan ID

        return $this->response->setJSON($data); // Mengembalikan data dalam format JSON
    }

    public function getTanggalKembali($id)
    {
        $peminjamanModel = new PeminjamanModel();
        $data = $peminjamanModel->find($id); // Mengambil data berdasarkan ID

        return $this->response->setJSON($data); // Mengembalikan data dalam format JSON
    }

    public function tampilkanData()
    {
        session();
        $model = new PengeluaranmurniModel();
        $jumlahDataBaru = $model->hitungDataBaru();
        return view('dashboard_admin', ['jumlahDataBaru' => $jumlahDataBaru]);
    }
}
