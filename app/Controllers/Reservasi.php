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
use App\Models\ReservasiModel;
use App\Models\ReservasibarangModel;
use App\Models\NotificationModel;


class Reservasi extends BaseController
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
    protected $reservasiModel;
    protected $reservasibarangModel;
    protected $notificationModel;
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
        $this->reservasiModel = new ReservasiModel();
        $this->reservasibarangModel = new ReservasibarangModel();
        $this->notificationModel = new NotificationModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }

    public function index()
    {
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();
        $reservasibarangModel = new ReservasibarangModel();
        $barangByStatus = $reservasibarangModel->getReservasiPeminjaman();

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
            'judul' => "Booking Alat | $namaKampus",
            'currentYear' => $currentYear,
            'data_reservasi' => $barangByStatus,
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('reservasi/reservasi_daftar', $data);
    }



    public function addReservasi()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $barangModel = new BarangModel();
        $barangByStatus = $barangModel->getBarangByStatus();

        // Dapatkan nim dari sesi aktif setelah pengguna berhasil login
        $nim = session()->get('user_nama'); // Sesuaikan dengan kunci sesi yang tepat
        $nik = session()->get('user_nama'); // Sesuaikan dengan kunci sesi yang tepat

        // Gunakan nim untuk memanggil fungsi di model yang akan mengembalikan data mahasiswa sesuai dengan nim yang telah diidentifikasi
        $mahasiswaModel = new MahasiswaModel();
        $dataMahasiswa = $mahasiswaModel->getMahasiswaByNim($nim); // Menggunakan fungsi yang telah disesuaikan sebelumnya

        $dosentendikModel = new DosenTendikModel();
        $dataDosenTendik = $dosentendikModel->getDosenTendikbyNik($nik);
        $dataDosen = $dosentendikModel->getDosen();

        $ruanganModel = new RuanganModel();
        $dataRuangan = $ruanganModel->getRuangan();

        $pembelajaranModel = new PembelajaranModel();
        $dataPembelajaran = $pembelajaranModel->getPembelajaran();

        $penggunaanModel = new PenggunaanModel();
        $dataPenggunaan = $penggunaanModel->getPenggunaan();

        $peminjamanId = $this->request->getPost('reservasi_id');

        $data = [
            'judul' => "Booking Alat | $namaKampus",
            'currentYear' => $currentYear,
            'data_barang' => $barangByStatus,
            'data_mahasiswa' => $dataMahasiswa,
            'data_dosen_tendik' => $dataDosenTendik,
            'data_dosen' => $dataDosen,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_ruangan' => $dataRuangan,
            'data_penggunaan' => $dataPenggunaan,
            'data_pembelajaran' =>  $dataPembelajaran,
            'kode_reservasi' => $this->reservasiModel->generateKodeReservasi(),
        ];

        session()->setFlashData('pesanAddPeminjaman', 'Peminjaman berhasil dilakukan.');
        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('reservasi/reservasi_form', $data);
    }

    public function simpanReservasi()
    {
        // Validasi input
        $validationRules = [

            'nama_peminjam' => 'required',
            'nama_ruangan' => 'required',
            'nama_dosen' => 'required',
            'keperluan' => 'required',
            'barang' => 'required',
            'tanggal_penggunaan' => 'required',
            'tanggal_pengembalian' => 'required',
        ];

        $validationMessages = [

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
            'tanggal_penggunaan' => [
                'required' => 'Pilih minimal satu barang.',
            ],
            'tanggal_pengembalian' => [
                'required' => 'Pilih minimal satu barang.',
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            // Jika validasi gagal, kembalikan pesan error
            return redirect()->to('pinjam/form')->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $tanggalPenggunaan = new \DateTime($this->request->getPost('tanggal_penggunaan'));
            $tanggalKembali = new \DateTime($this->request->getPost('tanggal_pengembalian'));
        } catch (\Exception $e) {
            // Tanggal tidak valid, tampilkan pesan kesalahan
            return redirect()->to(base_url('reservasi/tambah'))->withInput()->with('errorMessages', 'Format tanggal tidak valid.');
        }
        // Ambil data dari formulir
        // Ambil ID pengguna yang sedang login dari sesi
        $session = session();
        $userId = $session->get('id');

        // Ambil data dari formulir dan tambahkan ID pengguna
        $dataPeminjaman = [
            'user_id' => $userId,
            'kode_reservasi' => $this->request->getPost('kode_reservasi'),
            'nama_peminjam' => $this->request->getPost('nama_peminjam'),
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'nama_dosen' => $this->request->getPost('nama_dosen'),
            'tanggal_pinjam' => date('Y-m-d H:i:s'), // Mendapatkan tanggal dan waktu saat ini
            'tanggal_pengembalian' => $tanggalKembali->format('Y-m-d H:i:s'),
            'tanggal_penggunaan' => $tanggalPenggunaan->format('Y-m-d H:i:s'), // Sesuaikan format yang sesuai dengan basis data
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
        $reservasiId = $this->reservasiModel->insert($dataPeminjaman);

        // Update nilai pada tbl_angka
        $this->reservasiModel->updateIdAngka();

        // Ambil data barang yang dipilih
        $barangIds = $this->request->getPost('barang');

        // Simpan relasi peminjaman dan barang
        foreach ($barangIds as $barangId) {
            $dataPeminjamanBarang = [
                'reservasi_id' => $reservasiId,
                'barang_id' => $barangId,
            ];
            $this->reservasibarangModel->insert($dataPeminjamanBarang);

            // Update status_barang menjadi 1 pada tbl_barang
            $this->barangModel->update($barangId, ['status_barang' => 1]);
        }
        // Pengiriman email ke admin
        $this->kirimEmailAdmin($reservasiId);

        // Redirect atau tampilkan pesan sukses
        return redirect()->to('reservasi')->with('success', 'Peminjaman berhasil!');
    }

    private function kirimEmailAdmin($reservasiId)
    {
        // Ambil informasi reservasi berdasarkan ID
        $reservasi = $this->reservasiModel->find($reservasiId);

        // Lakukan pengecekan jika reservasi ditemukan
        if ($reservasi) {
            // Load library email
            $email = \Config\Services::email();

            // Konfigurasi email
            $email->setFrom('notifikasi@jimbling.my.id', 'Sistem SIM-Barang');
            $email->setTo('jimbling05@gmail.com');

            $email->setSubject('Booking Alat Baru');

            // Isi email dengan informasi reservasi
            $email->setMessage('Booking alat baru telah dibuat dengan rincian sebagai berikut: <br>'
                . 'Nama Peminjam: ' . $reservasi['nama_peminjam'] . '<br>'
                . 'Nama Ruangan: ' . $reservasi['nama_ruangan'] . '<br>'
                . 'Nama Dosen: ' . $reservasi['nama_dosen'] . '<br>'
                . 'Keperluan: ' . $reservasi['keperluan'] . '<br>'
                . 'Tanggal Penggunaan: ' . $reservasi['tanggal_penggunaan'] . '<br>'
                . 'Tanggal Kembali: ' . $reservasi['tanggal_pengembalian']);


            // Kirim email
            $email->send();
        }
    }

    public function hapus($reservasiId)
    {
        // Periksa apakah ada data yang dikirim melalui POST
        if ($_POST) {
            // Ambil data pesan dari POST
            $message = $this->request->getPost('message');

            $reservasiModel = new ReservasiModel();
            $reservasibarangModel = new ReservasibarangModel();

            // Ambil data reservasi berdasarkan ID
            $reservasiData = $reservasiModel->find($reservasiId);
            if (!$reservasiData) {
                return $this->response->setJSON(['success' => false, 'message' => 'Reservasi dengan ID tersebut tidak ditemukan.']);
            }

            // Kirim notifikasi kepada pengguna bahwa reservasi telah ditolak
            $userId = $reservasiData['user_id'];
            $this->sendDitolak($userId, $message);

            // Setelah notifikasi dikirim, hapus data reservasi
            $reservasibarangModel->hapusDataReservasi($reservasiId);

            return $this->response->setJSON(['success' => true, 'message' => 'Reservasi berhasil ditolak']);
        } else {
            // Handle jika tidak ada data yang dikirim melalui POST
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada data yang dikirim']);
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

    public function cetakReservasi($reservasiId)
    {
        $reservasibarangModel = new ReservasibarangModel();
        // Get peminjaman barang data by peminjaman_id
        $reservasiPeminjamanDetails = $reservasibarangModel->getReservasiPeminjamanByReservasiId($reservasiId);

        $data = [
            'data_reservasi' => $reservasiPeminjamanDetails,

        ];

        return view('cetak/cetak_data_reservasi', $data);
    }





    public function moveDataById($reservasiId)
    {
        $reservasiModel = new ReservasiModel();
        $reservasibarangModel = new ReservasibarangModel();
        $peminjamanModel = new PeminjamanModel();
        $peminjamanBarangModel = new PeminjamanBarangModel();

        // Ambil data reservasi berdasarkan ID
        $reservasiData = $reservasiModel->find($reservasiId);
        if (!$reservasiData) {
            return "Reservasi dengan ID tersebut tidak ditemukan.";
        }

        // Memindahkan data dari tabel reservasi ke tabel peminjaman
        $peminjamanData = [
            'kode_pinjam' => $this->peminjamanModel->generateKodePinjam(),
            'user_id' => $reservasiData['user_id'],
            'nama_peminjam' => $reservasiData['nama_peminjam'],
            'nama_ruangan' => $reservasiData['nama_ruangan'],
            'tanggal_pinjam' => $reservasiData['tanggal_penggunaan'],
            'tanggal_pengembalian' => $reservasiData['tanggal_pengembalian'],
            'keperluan' => $reservasiData['keperluan'],
            'nama_dosen' => $reservasiData['nama_dosen'],
            'created_at' => $reservasiData['created_at'],
            'updated_at' => $reservasiData['updated_at'],
        ];
        $peminjamanModel->insert($peminjamanData);
        // Update nilai pada tbl_angka
        $this->peminjamanModel->updateIdAngka();
        // Ambil ID terbaru yang baru saja dimasukkan ke tabel peminjaman
        $newPeminjamanId = $peminjamanModel->getInsertID();

        // Ambil data reservasi barang berdasarkan ID reservasi
        $reservasibarangData = $reservasibarangModel->where('reservasi_id', $reservasiId)->findAll();

        // Memindahkan data dari tabel reservasi barang ke tabel peminjaman barang
        foreach ($reservasibarangData as $reservasibarang) {
            $peminjamanBarangData = [
                'peminjaman_id' => $newPeminjamanId, // Menggunakan ID terbaru dari tabel peminjaman
                'barang_id' => $reservasibarang['barang_id']
            ];
            $peminjamanBarangModel->insert($peminjamanBarangData);
            // Update status_barang menjadi 1 pada tbl_barang
            $this->barangModel->update($reservasibarang, ['status_barang' => 1]);
        }

        // Setelah berhasil memindahkan data, hapus data dari tabel reservasi
        $reservasibarangModel->hapusDaftarReservasi($reservasiId);
        // Kirim notifikasi kepada pengguna bahwa reservasi telah di-acc dan diproses masuk ke peminjamanModel
        $userId = $reservasiData['user_id'];
        $message = "Booking alat telah disetujui dan diproses masuk ke peminjaman.";
        $this->sendNotification($userId, $message);

        return "Data berhasil dipindahkan untuk reservasi ID: $reservasiId.";
    }

    public function sendNotification($userId, $message)
    {
        $notificationModel = new NotificationModel(); // Gantilah dengan model yang sesuai

        // Data notifikasi
        $notificationData = [
            'user_id' => $userId,
            'message' => $message,
            'read_status' => 0, // 0 untuk belum dibaca
            'jenis_pesan' => 'disetujui',
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Simpan notifikasi ke dalam tabel
        $notificationModel->insert($notificationData);
    }

    public function sendDitolak($userId, $message)
    {
        $notificationModel = new NotificationModel(); // Gantilah dengan model yang sesuai

        // Data notifikasi
        $notificationData = [
            'user_id' => $userId,
            'message' => $message,
            'read_status' => 0, // 0 untuk belum dibaca
            'jenis_pesan' => 'ditolak',
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Simpan notifikasi ke dalam tabel
        $notificationModel->insert($notificationData);
    }

    public function getUserNotifications()
    {
        // Pastikan hanya user yang login yang dapat mengakses notifikasi mereka sendiri
        $userId = session()->get('id');

        // Buat instance dari model notifikasi
        $notificationModel = new NotificationModel();

        // Panggil method dari model untuk mendapatkan notifikasi pengguna
        $notifications = $notificationModel->getUserNotifications($userId);

        // Set tipe konten response menjadi JSON
        $response = service('response');
        $response->setContentType('application/json');

        // Kembalikan notifikasi dalam format JSON
        return $response->setBody(json_encode($notifications));
    }



    public function markAsRead()
    {
        $notificationId = $this->request->getPost('notification_id');

        // Pastikan hanya user yang login yang dapat membaca notifikasi
        $userId = session()->get('id');

        // Buat instance dari model notifikasi
        $notificationModel = new NotificationModel();

        // Periksa apakah notifikasi dengan ID tertentu dimiliki oleh pengguna yang sedang login
        $notification = $notificationModel->find($notificationId);
        if ($notification && $notification['user_id'] == $userId) {
            // Tandai notifikasi sebagai telah dibaca
            $notificationModel->markAsRead($notificationId);
            // Kembalikan respons sebagai konfirmasi
            return $this->response->setJSON(['success' => true]);
        } else {
            // Tidak ada notifikasi yang sesuai atau pengguna tidak memiliki akses
            return $this->response->setJSON(['success' => false, 'message' => 'Notifikasi tidak ditemukan atau Anda tidak memiliki izin untuk mengaksesnya.']);
        }
    }
}
