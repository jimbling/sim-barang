<?php

namespace App\Controllers;

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
    }

    public function index()
    {

        $currentYear = date('Y');
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
            'judul' => 'Daftar Pengembalian | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'data_peminjaman' => $barangByStatus,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengembalian/kembali_daftar', $data);
    }

    public function riwayat()
    {
        $pengembalianbarangModel = new PengembalianbarangModel();

        // Mengambil tahun dari inputan pengguna, jika tidak ada maka gunakan tahun saat ini
        $selectedYear = $this->request->getVar('tahun') ?? date('Y');

        // Mengambil tahun-tahun unik dari tanggal_kembali di tabel
        $availableYears = $pengembalianbarangModel->getAvailableYears();

        // Mendapatkan data berdasarkan tahun yang dipilih
        $dataKembali = $pengembalianbarangModel->getDataByYear($selectedYear);

        $data = [
            'judul' => 'Daftar Pinjam | Akper "YKY" Yogyakarta',
            'currentYear' => $selectedYear,
            'selectedYear' => $selectedYear,
            'data_kembali' => $dataKembali,
            'availableYears' => $availableYears,
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengembalian/kembali_daftar', $data);
    }


    public function addKembali()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');

        $peminjamanbarangModel = new PeminjamanbarangModel();
        $dataPeminjaman = $peminjamanbarangModel->getPeminjamanBarang();

        $data = [
            'judul' => 'Form Pengembalian | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_peminjaman' => $dataPeminjaman,
            'kode_pinjam' => $this->peminjamanModel->generateKodePinjam(),
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengembalian/kembali_form', $data);
    }

    public function prosesPengembalian()
    {
        // Ambil data dari formulir
        $peminjamanId = $this->request->getPost('peminjaman_id');
        $keterangan = $this->request->getPost('keterangan');
        $nama_barang = $this->request->getPost('nama_barang');

        // Dapatkan data peminjaman untuk mendapatkan nama_peminjam dan tanggal_pinjam
        $peminjamanModel = new PeminjamanModel();
        $peminjamanData = $peminjamanModel->find($peminjamanId);

        if (!$peminjamanData) {
            // Handle jika data peminjaman tidak ditemukan
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $nama_peminjam = $peminjamanData['nama_peminjam'];
        $tanggal_pinjam = $peminjamanData['tanggal_pinjam'];

        // Simpan data pengembalian ke dalam model
        $pengembalianbarangModel = new PengembalianbarangModel();
        $data = [
            'peminjaman_id' => $peminjamanId,
            'keterangan' => $keterangan,
            'nama_barang' => $nama_barang,
            'tanggal_kembali' => date('Y-m-d H:i:s'), // Tanggal dan waktu saat ini
            'tanggal_pinjam' => $tanggal_pinjam // Tanggal pinjam dari data peminjaman
        ];
        $pengembalianbarangModel->insertPengembalianBarang($data);

        // Hapus data peminjaman yang sesuai
        $this->hapusPeminjaman($peminjamanId);

        setlocale(LC_TIME, 'id_ID'); // Atur lokal ke bahasa Indonesia
        $timestamp = time(); // Dapatkan waktu saat ini

        // Ubah format tanggal dan waktu ke format yang diinginkan
        $tanggal_waktu = strftime('%d %B %Y %H:%M:%S', $timestamp);
        $tanggal_waktu .= ' WIB'; // Tambahkan informasi zona waktu

        // Gunakan dalam pesan flash data
        session()->setFlashData('pesanAddPengembalian', 'Pengembalian berhasil dilakukan oleh ' . $nama_peminjam . ' pada tanggal ' . $tanggal_waktu . '.');
        // Redirect atau lakukan operasi lainnya setelah penyimpanan dan penghapusan
        return redirect()->to('/kembali/riwayat');
    }



    // Tambahkan metode hapusPeminjaman
    protected function hapusPeminjaman($peminjamanId)
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
}
