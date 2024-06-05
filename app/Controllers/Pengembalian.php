<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

use App\Models\BarangModel;
use App\Models\PeminjamanModel;
use App\Models\PeminjamanbarangModel;
use App\Models\MahasiswaModel;
use App\Models\PengembalianbarangModel;
use App\Models\RiwayatPeminjamanModel;
use App\Models\RuanganModel;
use App\Models\PenggunaanModel;



class Pengembalian extends BaseController
{
    protected $barangModel;
    protected $peminjamanModel;
    protected $peminjamanbarangModel;
    protected $mahasiswaModel;
    protected $riwayatpeminjamanModel;
    protected $ruanganModel;
    protected $penggunaanModel;
    protected $pengembalianbarangModel;
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
        $this->pengembalianbarangModel = new PengembalianbarangModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjecto
    }

    public function index()
    {

        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        // Memeriksa izin penghapusan berdasarkan kondisi
        $userLevel = session()->get('level');
        foreach ($barangByStatus as &$dataKembali) {
            // Jika level adalah "Admin", berikan izin penghapusan
            if ($userLevel == 'Admin') {
                $dataKembali['allow_delete'] = true;
            } else {
                // Jika level adalah "User", cegah penghapusan
                $dataKembali['allow_delete'] = false;
            }
        }

        $data = [
            'judul' => "Daftar Pengembalian | $namaKampus",
            'currentYear' => $currentYear,
            'data_peminjaman' => $barangByStatus,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengembalian/kembali_daftar', $data);
    }

    public function riwayat()
    {
        $pengembalianbarangModel = new PengembalianbarangModel();
        $namaKampus = $this->settingsService->getNamaKampus();
        $selectedYear = $this->request->getVar('tahun') ?? date('Y');
        $availableYears = $pengembalianbarangModel->getAvailableYears();
        $userId = session()->get('id'); // Ambil userId dari sesi
        $riwayatPengembalian = $this->pengembalianbarangModel->getRiwayatPengembalianBarang($selectedYear, $userId);

        // Susun data berdasarkan kode_kembali
        $groupedData = [];
        foreach ($riwayatPengembalian as $riwayat) {
            $kodeKembali = $riwayat['kode_kembali'];
            $groupedData[$kodeKembali]['kode_kembali'] = $kodeKembali;
            $groupedData[$kodeKembali]['nama_peminjam'] = $riwayat['nama_peminjam'];
            $groupedData[$kodeKembali]['tanggal_pinjam'] = $riwayat['tanggal_pinjam'];
            $groupedData[$kodeKembali]['tanggal_kembali'] = $riwayat['tanggal_kembali'];
            $groupedData[$kodeKembali]['keperluan'] = $riwayat['keperluan'];
            $groupedData[$kodeKembali]['riwayat'][] = [
                'nama_barang' => $riwayat['nama_barang'],
                'kode_barang' => $riwayat['kode_barang'] // Tambahkan kode_barang di sini
            ];
        }

        $data = [
            'judul' => "Daftar Pinjam | $namaKampus",
            'currentYear' => $selectedYear,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
            'groupedRiwayatPengembalian' => $groupedData, // Gunakan data yang telah dikelompokkan
        ];

        return view('pengembalian/kembali_daftar', $data);
    }

    public function addKembali()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $peminjamanbarangModel = new PeminjamanbarangModel();
        $dataPeminjaman = $peminjamanbarangModel->getPeminjamanBarang();

        $data = [
            'judul' => "Form Pengembalian | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_peminjaman' => $dataPeminjaman,
            'kode_kembali' => $this->pengembalianbarangModel->generateKodeKembali(),
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengembalian/kembali_form', $data);
    }

    public function prosesPengembalian()
    {
        // Membaca data dari form
        $peminjamanId = $this->request->getPost('peminjaman_id');
        $keterangan = $this->request->getPost('keterangan');
        $barangIds = $this->request->getPost('barang_id');
        $kode_kembali = $this->request->getPost('kode_kembali');

        // Dapatkan data peminjaman untuk mendapatkan nama_peminjam dan tanggal_pinjam
        $peminjamanModel = new PeminjamanModel();
        $peminjamanData = $peminjamanModel->find($peminjamanId);

        if (!$peminjamanData) {
            // Handle jika data peminjaman tidak ditemukan
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $nama_peminjam = $peminjamanData['nama_peminjam'];

        // Menyiapkan data untuk disimpan
        $dataToInsert = [];
        foreach ($barangIds as $barangId) {
            $dataToInsert[] = [
                'peminjaman_id' => $peminjamanId,
                'barang_id' => $barangId,
                'kode_kembali' => $kode_kembali, // Anda perlu mengganti ini dengan cara yang sesuai
                'tanggal_kembali' => date('Y-m-d H:i:s'), // Tanggal dan waktu saat ini
                'keterangan' => $keterangan
            ];
        }

        // Menyimpan data ke dalam database
        $pengembalianModel = new PengembalianbarangModel();
        $pengembalianModel->insertBatch($dataToInsert);

        // Update nilai pada tbl_angka
        $this->pengembalianbarangModel->updateIdAngka();
        // Hapus data peminjaman yang sesuai
        // Mendapatkan daftar barang_id yang dipilih dari checkbox
        $barangIdsToDelete = $this->request->getPost('barang_id');

        // Memanggil metode hapusPeminjaman yang berada di dalam kontroler
        $this->hapusPeminjaman($peminjamanId, $barangIdsToDelete);

        setlocale(LC_TIME, 'id_ID'); // Atur lokal ke bahasa Indonesia
        $timestamp = time(); // Dapatkan waktu saat ini

        // Ubah format tanggal dan waktu ke format yang diinginkan
        $tanggal_waktu = strftime('%d %B %Y %H:%M:%S', $timestamp);
        $tanggal_waktu .= ' WIB'; // Tambahkan informasi zona waktu

        // Gunakan dalam pesan flash data
        session()->setFlashData('pesanAddPengembalian', 'Pengembalian berhasil dilakukan oleh ' . $nama_peminjam . ' pada tanggal ' . $tanggal_waktu . '.');
        // Redirect ke halaman tertentu
        return redirect()->to('/kembali/riwayat');
    }

    protected function hapusPeminjaman($peminjamanId, $barangIdsToDelete)
    {
        // Membuat instance model
        $peminjamanbarangModel = new \App\Models\PeminjamanbarangModel();

        // Melakukan pengecekan apakah peminjaman dengan ID tersebut ada dalam database
        $data_peminjaman = $peminjamanbarangModel->where('peminjaman_id', $peminjamanId)->findAll();

        if ($data_peminjaman) {
            // Jika peminjaman ditemukan, panggil fungsi hapusByPeminjamanId untuk menghapus data terkait
            $peminjamanbarangModel->hapusByPeminjamanId($peminjamanId, $barangIdsToDelete);

            // Set pesan flash data untuk sukses
            session()->setFlashData('pesanHapusPeminjaman', 'Data Peminjaman berhasil dihapus.');
        } else {
            // Jika peminjaman tidak ditemukan, set pesan flash data untuk kesalahan
            session()->setFlashData('error', 'Data peminjaman tidak ditemukan.');
        }
    }




    public function hapus($id)
    {
        // Cari barang berdasarkan ID
        $dataKembali = $this->pengembalianbarangModel->find($id);

        // Memeriksa izin penghapusan berdasarkan level pengguna
        $userLevel = session()->get('level');
        $flashData = [];

        if ($userLevel == 'Admin') {
            // Jika barang ditemukan, hapus
            if ($dataKembali) {
                $this->pengembalianbarangModel->delete($id);
                $flashData['status'] = 'success';
                $flashData['message'] = 'Barang dengan ID ' . $id . ' telah dihapus.';
            } else {
                $flashData['status'] = 'error';
                $flashData['message'] = 'Barang dengan ID ' . $id . ' tidak ditemukan.';
            }
        } else {
            // Jika level bukan "Admin", berikan pesan bahwa penghapusan tidak diizinkan
            $flashData['status'] = 'error';
            $flashData['message'] = 'Anda tidak memiliki izin untuk menghapus barang.';
        }

        session()->setFlashData('flashData', $flashData);
        return redirect()->to('/kembali/riwayat'); // Ganti dengan URL yang sesuai dengan rute Anda.
    }

    public function hapusKembaliKode($kodeKembali)
    {
        // Panggil metode model untuk melakukan penghapusan berdasarkan kode kembali
        $this->pengembalianbarangModel->hapusBerdasarkanKodeKembali($kodeKembali);
        // Redirect kembali ke halaman yang sesuai
        return redirect()->to(base_url('kembali/riwayat'));
    }
}
