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
use App\Models\PengembalianbarangModel;

class Peminjaman extends BaseController
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
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }



    public function index()
    {
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $pengeluaranModel = new PengeluaranModel();
        $dataPengeluaran = $pengeluaranModel->getAllPengeluaran();

        // Memeriksa izin penghapusan berdasarkan kondisi
        $userLevel = session()->get('level');

        // Check if $dataPengeluaran is not empty before attempting to iterate over it
        if (!empty($barangByStatus) && $userLevel == 'User') {
            $currentTime = time();
            foreach ($barangByStatus as &$dataPinjam) {
                $createdTime = strtotime($dataPinjam['created_at']);
                $timeDifference = $currentTime - $createdTime;
                $timeLimit = 10 * 60; // 10 menit dalam detik

                // Nonaktifkan tombol hapus jika batasan waktu terlampaui
                $dataPinjam['allow_delete'] = ($timeDifference <= $timeLimit);
            }
        }

        $data = [
            'judul' => "Daftar Pinjam | $namaKampus",
            'currentYear' => $currentYear,
            'data_peminjaman' => $barangByStatus,
            'data_pengeluaran' =>  $dataPengeluaran,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('peminjaman/pinjam_daftar', $data);
    }


    public function riwayat()
    {
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $pengembalianBarang = new PengembalianbarangModel();

        // Mengambil tahun dari inputan pengguna, jika tidak ada maka gunakan tahun saat ini
        $selectedYear = $this->request->getVar('tahun') ?? date('Y');

        // Mengambil tahun-tahun unik dari tanggal_kembali di tabel
        $availableYears = $riwayatPeminjamanModel->getAvailableYears();

        // Mendapatkan data berdasarkan tahun yang dipilih
        $namaKampus = $this->settingsService->getNamaKampus();

        // Mendapatkan semua data dengan relasi
        $semuaData = $pengembalianBarang->getAllDataWithRelations();

        // Kelompokkan data berdasarkan kode_pinjam
        $groupedData = [];
        foreach ($semuaData as $data) {
            $kodePinjam = $data['kode_pinjam'];
            if (!isset($groupedData[$kodePinjam])) {
                $groupedData[$kodePinjam] = [];
            }
            $groupedData[$kodePinjam][] = $data;
        }

        $data = [
            'judul' => "Daftar Pinjam | $namaKampus",
            'currentYear' => $selectedYear,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
            'grouped_data' => $groupedData,
        ];

        // Kirim data ke tampilan
        return view('peminjaman/pinjam_riwayat', $data);
    }

    public function riwayatUser()
    {
        $session = session();
        $userId = $session->get('id');

        if (is_null($userId)) {
            echo 'User ID tidak ditemukan dalam sesi. Pastikan pengguna telah login.';
            return;
        }

        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $dataPeminjaman = $riwayatPeminjamanModel->getPeminjamanByUserId($userId);

        // Mengelompokkan barang berdasarkan peminjaman_id
        $groupedPeminjaman = [];
        foreach ($dataPeminjaman as $item) {
            $peminjamanId = $item['peminjaman_id'];

            if (!isset($groupedPeminjaman[$peminjamanId])) {
                $groupedPeminjaman[$peminjamanId] = [
                    'kode_pinjam' => $item['kode_pinjam'],
                    'nama_peminjam' => $item['nama_peminjam'],
                    'nama_ruangan' => $item['nama_ruangan'],
                    'tanggal_pinjam' => $item['tanggal_pinjam'],
                    'keperluan' => $item['keperluan'],
                    'barang_dipinjam' => []
                ];
            }

            $groupedPeminjaman[$peminjamanId]['barang_dipinjam'][] = $item['nama_barang'] . ' - ' . $item['kode_barang'];
        }

        $data = [
            'judul' => "Daftar Pinjam | " . $this->settingsService->getNamaKampus(),
            'currentYear' => date('Y'),
            'data_peminjaman' => $groupedPeminjaman,
        ];

        return view('peminjaman/pinjam_riwayat_user', $data);
    }

    // public function detailKodeKembali($kodeKembali)
    // {
    //     $pengembalianBarang = new PengembalianbarangModel();
    //     $groupedData = $pengembalianBarang->getAllDataWithRelationsByKodePinjam($kodeKembali); // Menggunakan metode yang sesuai

    //     // Kirim data detail ke klien dalam format JSON
    //     return $this->response->setJSON($groupedData);
    // }

    public function riwayatKodePinjam($kodeKembali)
    {
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $pengembalianBarang = new PengembalianbarangModel();

        // Mengambil tahun dari inputan pengguna, jika tidak ada maka gunakan tahun saat ini
        $selectedYear = $this->request->getVar('tahun') ?? date('Y');

        // Mengambil tahun-tahun unik dari tanggal_kembali di tabel
        $availableYears = $riwayatPeminjamanModel->getAvailableYears();

        // Mendapatkan data berdasarkan tahun yang dipilih
        $namaKampus = $this->settingsService->getNamaKampus();

        // Mendapatkan semua data dengan relasi
        $semuaData = $pengembalianBarang->getAllDataWithRelationsByKodePinjam($kodeKembali);

        // Kelompokkan data berdasarkan kode_pinjam
        $groupedData = [];
        foreach ($semuaData as $data) {
            $kodePinjam = $data['kode_pinjam'];
            if (!isset($groupedData[$kodePinjam])) {
                $groupedData[$kodePinjam] = [];
            }
            $groupedData[$kodePinjam][] = $data;
        }

        // Membuat instance dari model yang dibutuhkan
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $peminjamanBarangModel = new PeminjamanbarangModel();

        // Mendapatkan data dari masing-masing model berdasarkan kode pinjam
        $dataRiwayat = $riwayatPeminjamanModel->getRiwayatPeminjamanData($kodePinjam);
        $dataPeminjamanBarang = $peminjamanBarangModel->getPeminjamanBarangData($kodePinjam);

        // Gabungkan data dari kedua tabel menjadi satu array
        $combinedData = array_merge($dataRiwayat, $dataPeminjamanBarang);

        $data = [
            'judul' => "Daftar Pinjam | $namaKampus",
            'currentYear' => $selectedYear,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
            'grouped_data' => $groupedData,
            'semua_data' => $combinedData,
        ];

        // Kirim data ke tampilan
        return view('peminjaman/kembali_kode', $data);
    }

    public function cetakDetailPinjam($kodeKembali)
    {
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $pengembalianBarang = new PengembalianbarangModel();
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        // Mengambil tahun dari inputan pengguna, jika tidak ada maka gunakan tahun saat ini
        $selectedYear = $this->request->getVar('tahun') ?? date('Y');

        // Mengambil tahun-tahun unik dari tanggal_kembali di tabel
        $availableYears = $riwayatPeminjamanModel->getAvailableYears();

        // Mendapatkan data berdasarkan tahun yang dipilih
        $namaKampus = $this->settingsService->getNamaKampus();

        // Mendapatkan semua data dengan relasi
        $semuaData = $pengembalianBarang->getAllDataWithRelationsByKodePinjam($kodeKembali);

        // Kelompokkan data berdasarkan kode_pinjam
        $groupedData = [];
        foreach ($semuaData as $data) {
            $kodePinjam = $data['kode_pinjam'];
            if (!isset($groupedData[$kodePinjam])) {
                $groupedData[$kodePinjam] = [];
            }
            $groupedData[$kodePinjam][] = $data;
        }

        // Membuat instance dari model yang dibutuhkan
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $peminjamanBarangModel = new PeminjamanbarangModel();

        // Mendapatkan data dari masing-masing model berdasarkan kode pinjam
        $dataRiwayat = $riwayatPeminjamanModel->getRiwayatPeminjamanData($kodePinjam);
        $dataPeminjamanBarang = $peminjamanBarangModel->getPeminjamanBarangData($kodePinjam);

        // Gabungkan data dari kedua tabel menjadi satu array
        $combinedData = array_merge($dataRiwayat, $dataPeminjamanBarang);


        $data = [
            'judul' => "Daftar Pinjam | $namaKampus",
            'currentYear' => $selectedYear,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
            'grouped_data' => $groupedData,
            'dataPengaturan' => $dataPengaturan,
            'semua_data' => $combinedData,

        ];

        // Kirim data ke tampilan
        return view('cetak/cetak_detail_peminjaman', $data);
    }


    public function getRiwayatPeminjaman()
    {
        $requestData = $this->request->getVar();
        $draw = isset($requestData['draw']) ? intval($requestData['draw']) : 1; // Menggunakan nilai default 1 jika 'draw' tidak ada
        $year = $requestData['tahun'] ?? date('Y');

        // Panggil metode untuk mendapatkan data riwayat peminjaman berdasarkan tahun
        $riwayatPeminjaman = $this->riwayatpeminjamanModel->getRiwayatPeminjaman($year);

        // Format data sesuai spesifikasi DataTables
        $response = [
            "draw" => $draw, // Menggunakan nilai 'draw' yang telah diperiksa
            "recordsTotal" => count($riwayatPeminjaman),
            "recordsFiltered" => count($riwayatPeminjaman), // Jumlah total data setelah filter (jika ada)
            "data" => $riwayatPeminjaman
        ];

        // Mengembalikan data dalam format JSON
        return $this->response->setJSON($response);
    }


    public function addPinjam()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $barangModel = new BarangModel();
        $barangByStatus = $barangModel->getBarangByStatus();

        $mahasiswaModel = new MahasiswaModel();
        $dataMahasiswa = $mahasiswaModel->getMahasiswa();
        $dosentendikModel = new DosenTendikModel();
        $dataDosenTendik = $dosentendikModel->getDosenTendik();
        $dataDosen = $dosentendikModel->getDosen();

        $ruanganModel = new RuanganModel();
        $dataRuangan = $ruanganModel->getRuangan();

        $pembelajaranModel = new PembelajaranModel();
        $dataPembelajaran = $pembelajaranModel->getPembelajaran();

        $penggunaanModel = new PenggunaanModel();
        $dataPenggunaan = $penggunaanModel->getPenggunaan();

        $peminjamanId = $this->request->getPost('peminjaman_id');





        $data = [
            'judul' => "Peminjaman | $namaKampus",
            'currentYear' => $currentYear,
            'data_barang' => $barangByStatus,
            'data_mahasiswa' => $dataMahasiswa,
            'data_dosen_tendik' => $dataDosenTendik,
            'data_dosen' => $dataDosen,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_ruangan' => $dataRuangan,
            'data_penggunaan' => $dataPenggunaan,
            'data_pembelajaran' =>  $dataPembelajaran,
            'kode_pinjam' => $this->peminjamanModel->generateKodePinjam(),

        ];
        session()->setFlashData('pesanAddPeminjaman', 'Peminjaman berhasil dilakukan.');
        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('peminjaman/pinjam_form', $data);
    }

    public function prosesPeminjaman()
    {
        // Validasi input
        $validationRules = [
            'kode_pinjam' => 'required',
            'nama_peminjam' => 'required',
            'nama_ruangan' => 'required',
            'nama_dosen' => 'required',
            'keperluan' => 'required',
            'barang' => 'required',
        ];

        $validationMessages = [
            'kode_pinjam' => [
                'required' => 'Kode Peminjaman harus diisi.',
            ],
            'nama_peminjam' => [
                'required' => 'Nama Peminjam harus diisi.',
            ],
            'nama_ruangan' => [
                'required' => 'Nama Ruangan harus diisi.',
            ],
            'nama_dosen' => [
                'required' => 'Nama Dosen harus diisi.',
            ],
            'keperluan' => [
                'required' => 'Keperluan harus diisi.',
            ],
            'barang' => [
                'required' => 'Pilih minimal satu barang.',
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            // Jika validasi gagal, kembalikan pesan error
            return redirect()->to('pinjam/form')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil nilai nama_peminjam dari form
        $nama_peminjam = $this->request->getPost('nama_peminjam');

        // Pisahkan nilai nim/nik dari nama
        $nilai_terpisah = explode('-', $nama_peminjam);

        // Ambil nim/nik
        $nim_nik = $nilai_terpisah[0];
        // Ambil data dari formulir
        // Load model UserModel
        $userModel = new \App\Models\UserModel();

        // Cari user_id berdasarkan nim/nik di kolom user_nama
        $user_id = $userModel->getUserIDByNimNik($nim_nik);

        // Jika user_id ditemukan, gunakan nilainya. Jika tidak, biarkan null.
        $dataPeminjaman = [
            'kode_pinjam' => $this->request->getPost('kode_pinjam'),
            'nama_peminjam' => $nama_peminjam,
            'user_id' => $user_id,
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'nama_dosen' => $this->request->getPost('nama_dosen'),
            'tanggal_pinjam' => date('Y-m-d H:i:s'), // Mendapatkan tanggal dan waktu saat ini
        ];

        // Pilihan pertama
        $keperluan = $this->request->getPost('keperluan');

        // Pilihan kedua (jika terpilih)
        $pembelajaran = $this->request->getPost('pembelajaran');

        // Gabungkan nilai dari pilihan pertama dan pilihan kedua (jika terpilih)
        if (!empty($pembelajaran)) {
            $keperluan .= ' - ' . $pembelajaran;
        }

        // Tambahkan nilai keperluan ke dalam data peminjaman
        $dataPeminjaman['keperluan'] = $keperluan;

        // Simpan data peminjaman
        $peminjamanId = $this->peminjamanModel->insert($dataPeminjaman);

        // Update nilai pada tbl_angka
        $this->peminjamanModel->updateIdAngka();

        // Ambil data barang yang dipilih
        $barangIds = $this->request->getPost('barang');

        // Simpan relasi peminjaman dan barang
        foreach ($barangIds as $barangId) {
            $dataPeminjamanBarang = [
                'peminjaman_id' => $peminjamanId,
                'barang_id' => $barangId,
            ];
            $this->peminjamanbarangModel->insert($dataPeminjamanBarang);

            // Update status_barang menjadi 1 pada tbl_barang
            $this->barangModel->update($barangId, ['status_barang' => 1]);
        }


        // Redirect atau tampilkan pesan sukses
        return redirect()->to('pinjam/daftar')->with('success', 'Peminjaman berhasil!');
    }



    public function hapus($peminjamanId)
    {
        // Membuat instance model
        $peminjamanbarangModel = new \App\Models\PeminjamanbarangModel();
        $pengembalianbarangModel = new \App\Models\PengembalianbarangModel();
        $peminjamanModel = new \App\Models\PeminjamanModel(); // Tambahkan model peminjaman

        try {
            // Cek apakah ada data di tbl_riwayat_pengembalian yang terkait dengan peminjaman_id
            $pengembalianTerkait = $pengembalianbarangModel->where('peminjaman_id', $peminjamanId)->findAll();

            if (!empty($pengembalianTerkait)) {
                // Jika ada data terkait, batalkan penghapusan dan kirim pesan error

                // Mengambil kode_pinjam berdasarkan peminjaman_id
                $peminjaman = $peminjamanModel->find($peminjamanId);
                $kodePinjam = $peminjaman['kode_pinjam']; // Ambil kode_pinjam dari hasil query

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Masih ada data pada pengembalian. Hapus terlebih dahulu data pengembalian, dengan Kode Pinjam: ' . $kodePinjam . '.'
                ]);
            }

            // Menghapus data dari tabel riwayat peminjaman
            $deletedDataPinjam = $peminjamanbarangModel->deleteByPeminjamanId($peminjamanId);

            // Memeriksa apakah penghapusan dari riwayat peminjaman berhasil
            if ($deletedDataPinjam) {
                // Hapus data dari tabel peminjaman juga
                $deletedPeminjaman = $peminjamanModel->delete($peminjamanId);

                if ($deletedPeminjaman) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Data Peminjaman berhasil dihapus.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Gagal menghapus data Peminjaman.'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menghapus data Peminjaman.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ]);
        }
    }

    public function hapusRiwayat($peminjamanId)
    {
        // Membuat instance model
        $riwayatPeminjamanModel = new \App\Models\RiwayatPeminjamanModel();
        $pengembalianbarangModel = new \App\Models\PengembalianbarangModel();
        $peminjamanModel = new \App\Models\PeminjamanModel(); // Tambahkan model peminjaman

        try {
            // Cek apakah ada data di tbl_riwayat_pengembalian yang terkait dengan peminjaman_id
            $pengembalianTerkait = $pengembalianbarangModel->where('peminjaman_id', $peminjamanId)->findAll();

            if (!empty($pengembalianTerkait)) {
                // Jika ada data terkait, batalkan penghapusan dan kirim pesan error

                // Mengambil kode_pinjam berdasarkan peminjaman_id
                $peminjaman = $peminjamanModel->find($peminjamanId);
                $kodePinjam = $peminjaman['kode_pinjam']; // Ambil kode_pinjam dari hasil query

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Masih ada data pada pengembalian. Hapus terlebih dahulu data pengembalian, dengan Kode Pinjam: ' . $kodePinjam . '.'
                ]);
            }

            // Menghapus data dari tabel riwayat peminjaman
            $deletedRiwayat = $riwayatPeminjamanModel->deleteByPeminjamanId($peminjamanId);

            // Memeriksa apakah penghapusan dari riwayat peminjaman berhasil
            if ($deletedRiwayat) {
                // Hapus data dari tabel peminjaman juga
                $deletedPeminjaman = $peminjamanModel->delete($peminjamanId);

                if ($deletedPeminjaman) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Data Peminjaman berhasil dihapus.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Gagal menghapus data Peminjaman.'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menghapus data Peminjaman.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ]);
        }
    }




    public function getDataBarang()
    {
        $peminjamanId = $this->request->getPost('peminjaman_id');

        $pengeluaranModel = new PengeluaranModel();
        $dataBarang = $pengeluaranModel->getDataByPeminjamanId($peminjamanId);

        $data['dataBarang'] = $dataBarang;

        return view('peminjaman/pinjam_daftar', $data); // Ganti 'your_modal_view' dengan nama view Anda
    }

    public function get_detail($peminjamanId)
    {
        $pengeluaranModel = new \App\Models\PengeluaranModel();

        // Get details of the pengeluaran
        $data['detail'] = $pengeluaranModel->getDataByPeminjamanId($peminjamanId);

        // Return JSON response
        return $this->response->setJSON($data);
    }

    public function cetakPinjamPersediaan($peminjamanId)
    {
        $pengeluaranModel = new PengeluaranModel();
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);

        // Get data pengeluaran based on peminjaman_id
        $groupedPengeluaran = $this->getGroupedPengeluaran($peminjamanId);

        // Get peminjaman barang data by peminjaman_id
        $peminjamanBarangDetails = $peminjamanbarangModel->getPeminjamanBarangByPeminjamanId($peminjamanId);

        // Check if $groupedPengeluaran is not empty and has at least one element
        if (!empty($groupedPengeluaran) && array_key_exists(0, $groupedPengeluaran)) {
            // Fetch additional information related to barangPersediaan and peminjaman
            foreach ($groupedPengeluaran as &$pengeluaran) {
                $barangPersediaanModel = new BarangPersediaanModel();
                $barangPersediaan = $barangPersediaanModel->find($pengeluaran->barang_id);

                // Attach additional information to the pengeluaran data
                $pengeluaran->barangPersediaan = $barangPersediaan;
            }
        } else {
            // If $groupedPengeluaran is empty or does not have an index 0, proceed with printing peminjaman data only
            return view('cetak/cetak_data_pinjam_persed', [
                'groupedPengeluaran' => [],
                'peminjamanBarangDetails' => $peminjamanBarangDetails,
                'dataPengaturan' => $dataPengaturan,
            ]);
        }

        // You can now use $groupedPengeluaran and $peminjamanBarangDetails in your view or further processing
        // For example, passing them to a view
        return view('cetak/cetak_data_pinjam_persed', [
            'groupedPengeluaran' => $groupedPengeluaran,
            'peminjamanBarangDetails' => $peminjamanBarangDetails,
            'dataPengaturan' => $dataPengaturan,
        ]);
    }

    public function cetakFormPengembalian($peminjamanId)
    {
        $pengeluaranModel = new PengeluaranModel();
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);

        // Get data pengeluaran based on peminjaman_id
        $groupedPengeluaran = $this->getGroupedPengeluaran($peminjamanId);

        // Get peminjaman barang data by peminjaman_id
        $peminjamanBarangDetails = $peminjamanbarangModel->getPeminjamanBarangByPeminjamanId($peminjamanId);

        // Check if $groupedPengeluaran is not empty and has at least one element
        if (!empty($groupedPengeluaran) && array_key_exists(0, $groupedPengeluaran)) {
            // Fetch additional information related to barangPersediaan and peminjaman
            foreach ($groupedPengeluaran as &$pengeluaran) {
                $barangPersediaanModel = new BarangPersediaanModel();
                $barangPersediaan = $barangPersediaanModel->find($pengeluaran->barang_id);

                // Attach additional information to the pengeluaran data
                $pengeluaran->barangPersediaan = $barangPersediaan;
            }
        } else {
            // If $groupedPengeluaran is empty or does not have an index 0, proceed with printing peminjaman data only
            return view('cetak/cetak_form_kembali', [
                'groupedPengeluaran' => [],
                'peminjamanBarangDetails' => $peminjamanBarangDetails,
                'dataPengaturan' => $dataPengaturan,
            ]);
        }

        // You can now use $groupedPengeluaran and $peminjamanBarangDetails in your view or further processing
        // For example, passing them to a view
        return view('cetak/cetak_form_kembali', [
            'groupedPengeluaran' => $groupedPengeluaran,
            'peminjamanBarangDetails' => $peminjamanBarangDetails,
            'dataPengaturan' => $dataPengaturan,
        ]);
    }

    public function cetakFormPengembalianRiwayat($peminjamanId)
    {
        $pengeluaranModel = new PengeluaranModel();
        $riwayatpeminjamanModel = new RiwayatPeminjamanModel();
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);

        // Get data pengeluaran based on peminjaman_id
        $groupedPengeluaran = $this->getGroupedPengeluaran($peminjamanId);

        // Get peminjaman barang data by peminjaman_id
        $peminjamanBarangDetails = $riwayatpeminjamanModel->getPeminjamanBarangByPeminjamanId($peminjamanId);

        // Check if $groupedPengeluaran is not empty and has at least one element
        if (!empty($groupedPengeluaran) && array_key_exists(0, $groupedPengeluaran)) {
            // Fetch additional information related to barangPersediaan and peminjaman
            foreach ($groupedPengeluaran as &$pengeluaran) {
                $barangPersediaanModel = new BarangPersediaanModel();
                $barangPersediaan = $barangPersediaanModel->find($pengeluaran->barang_id);

                // Attach additional information to the pengeluaran data
                $pengeluaran->barangPersediaan = $barangPersediaan;
            }
        } else {
            // If $groupedPengeluaran is empty or does not have an index 0, proceed with printing peminjaman data only
            return view('cetak/cetak_form_kembali_riwayat', [
                'groupedPengeluaran' => [],
                'peminjamanBarangDetails' => $peminjamanBarangDetails,
                'dataPengaturan' => $dataPengaturan,
            ]);
        }

        // You can now use $groupedPengeluaran and $peminjamanBarangDetails in your view or further processing
        // For example, passing them to a view
        return view('cetak/cetak_form_kembali_riwayat', [
            'groupedPengeluaran' => $groupedPengeluaran,
            'peminjamanBarangDetails' => $peminjamanBarangDetails,
            'dataPengaturan' => $dataPengaturan,
        ]);
    }

    protected function getGroupedPengeluaran($peminjamanId)
    {
        $pengeluaranModel = new PengeluaranModel();
        return $pengeluaranModel->getPengeluaranByPeminjamanId($peminjamanId);
    }

    public function edit($id)
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $peminjamanModel = new PeminjamanModel();
        $barangByStatus = $peminjamanModel->getPeminjaman($id);

        $pengeluaranModel = new PengeluaranModel();
        $dataPengeluaran = $pengeluaranModel->getAllPengeluaran();

        $mahasiswaModel = new MahasiswaModel();
        $dataMahasiswa = $mahasiswaModel->getMahasiswa();
        $dosentendikModel = new DosenTendikModel();
        $dataDosenTendik = $dosentendikModel->getDosenTendik();
        $dataDosen = $dosentendikModel->getDosen();

        $ruanganModel = new RuanganModel();
        $dataRuangan = $ruanganModel->getRuangan();

        $pembelajaranModel = new PembelajaranModel();
        $dataPembelajaran = $pembelajaranModel->getPembelajaran();

        $penggunaanModel = new PenggunaanModel();
        $dataPenggunaan = $penggunaanModel->getPenggunaan();

        $data = [
            'judul' => "Edit Peminjaman | $namaKampus",
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'currentYear' => $currentYear,
            'data_peminjaman' => $barangByStatus,
            'data_pengeluaran' =>  $dataPengeluaran,
            'data_barang' => $barangByStatus,
            'data_mahasiswa' => $dataMahasiswa,
            'data_dosen_tendik' => $dataDosenTendik,
            'data_dosen' => $dataDosen,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_ruangan' => $dataRuangan,
            'data_penggunaan' => $dataPenggunaan,
            'data_pembelajaran' =>  $dataPembelajaran,
        ];


        return view('peminjaman/pinjam_edit', $data);
    }
}
