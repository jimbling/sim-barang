<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

use App\Models\PengaturanModel;
use App\Models\UserModel;
use Ifsnop\Mysqldump\Mysqldump;
use App\Models\BackupModel;

class Pengaturan extends BaseController
{
    protected $pengaturanModel;
    protected $userModel;
    protected $backupModel;
    protected $settingsService;

    public function __construct()
    {
        $this->pengaturanModel = new PengaturanModel();
        $this->userModel = new UserModel();
        $this->backupModel = new BackupModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }
    public function index()
    {

        $currentYear = date('Y');
        $csrfToken = csrf_hash();
        $namaKampus = $this->settingsService->getNamaKampus();

        $pengguna = $this->userModel->getAdminUser();

        $pengaturanModel = new PengaturanModel();
        $dataCetak = $pengaturanModel->getDataById(1);


        $data = [
            'judul' => "Setting Data | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'dataCetak' => $dataCetak,
            'data_pengguna' => $pengguna,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengaturan/setting_data', $data);
    }

    public function pengguna()
    {
        $currentYear = date('Y');
        $csrfToken = csrf_hash();
        $namaKampus = $this->settingsService->getNamaKampus();

        // Ambil nilai tipe pengguna dari form jika ada
        $selectedType = $this->request->getGet('type');

        // Panggil metode di model untuk mengambil data pengguna
        if (!empty($selectedType)) {
            // Jika tipe pengguna dipilih, ambil data pengguna berdasarkan tipe yang dipilih
            $pengguna = $this->userModel->getUserByType($selectedType);
        } else {
            // Jika tidak ada tipe yang dipilih, ambil semua data pengguna
            $pengguna = $this->userModel->getUser();
        }

        $data = [
            'judul' => "Setting Data | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_pengguna' => $pengguna,
        ];

        // Kirim data pengguna ke view
        return view('pengaturan/pengguna', $data);
    }

    public function settingUser()
    {

        $currentYear = date('Y');
        $csrfToken = csrf_hash();
        $namaKampus = $this->settingsService->getNamaKampus();

        // Ambil ID pengguna dari sesi
        $userId = session('id');

        // Panggil metode di model untuk mengambil data pengguna berdasarkan ID pengguna yang login
        $pengguna = $this->userModel->getUserById($userId);

        $data = [
            'judul' => "Profile Pengguna | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_pengguna' => $pengguna,
        ];

        // Kirim data pengguna ke view
        return view('pengaturan/setting_user', $data);
    }

    public function getUserById($userId)
    {
        // Panggil metode di model untuk mengambil data pengguna berdasarkan ID
        $user = $this->userModel->find($userId);

        // Buat array untuk menyimpan data pengguna
        $userData = [];

        // Periksa apakah pengguna ditemukan
        if ($user) {
            // Jika pengguna ditemukan, tambahkan data ke array
            $userData = [
                'id' => $user['id'],
                'user_nama' => $user['user_nama'],
                'level' => $user['level'],
                'full_nama' => $user['full_nama'],
                'type' => $user['type']
                // tambahkan kolom lainnya sesuai kebutuhan
            ];
        } else {
            // Jika pengguna tidak ditemukan, set data pengguna ke null
            $userData = null;
        }

        // Kembalikan data pengguna dalam format JSON
        return json_encode($userData);
    }

    public function updateUser()
    {
        // Ambil data yang dikirim melalui AJAX
        $userId = $this->request->getPost('id');
        $fullName = $this->request->getPost('full_nama');
        $userName = $this->request->getPost('user_nama');
        $password = $this->request->getPost('user_password');

        // Lakukan validasi data jika diperlukan

        // Validasi password
        if (!empty($password)) {
            // Panjang minimal 8 karakter
            if (strlen($password) < 8) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Password harus memiliki panjang minimal 8 karakter.']);
            }

            // Mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus
            if (!preg_match('/[A-Z]/', $password)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Password harus mengandung setidaknya satu huruf besar.']);
            }

            if (!preg_match('/[a-z]/', $password)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Password harus mengandung setidaknya satu huruf kecil.']);
            }

            if (!preg_match('/[0-9]/', $password)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Password harus mengandung setidaknya satu angka.']);
            }

            if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Password harus mengandung setidaknya satu karakter khusus (!@#$%^&*()\-_=+{};:,<.>).']);
            }
        }

        // Panggil model untuk mendapatkan data pengguna berdasarkan ID
        $userModel = new UserModel();
        $userData = $userModel->find($userId);

        // Hash password baru menggunakan password_hash() PHP function
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $dataToUpdate = [
            'full_nama' => $fullName,
            'user_nama' => $userName,
            'user_password' => $hashedPassword
            // tambahkan kolom lainnya sesuai kebutuhan
        ];

        // Panggil model untuk melakukan pembaruan data
        $updated = $userModel->update($userId, $dataToUpdate);

        if ($updated) {
            // Jika berhasil, kirim respon berhasil
            return $this->response->setJSON(['status' => 'success']);
        } else {
            // Jika gagal, kirim respon gagal
            return $this->response->setJSON(['status' => 'error']);
        }
    }


    public function update()
    {
        // Mengambil data yang dikirimkan melalui POST
        $id = $this->request->getPost('id');
        $full_nama = $this->request->getPost('full_nama');
        $user_nama = $this->request->getPost('user_nama');
        $user_password = $this->request->getPost('user_password');

        // Validasi data jika diperlukan

        // Lakukan pembaruan data ke database menggunakan model UserModel
        $userModel = new \App\Models\UserModel();

        // Lakukan hashing password di dalam model
        $data = [
            'full_nama' => $full_nama,
            'user_nama' => $user_nama,
            'user_password' => password_hash($user_password, PASSWORD_DEFAULT), // Gunakan password_hash
        ];

        // Memperbarui data pengguna
        $userModel->updateUser($id, $data);

        // Pesan respons
        $response = [
            'status' => 'success',
            'message' => 'Data berhasil diperbarui',
            'redirect' => '/data/pengaturan', // Tambahkan informasi pengalihan
        ];

        // Kirim respons JSON ke JavaScript
        session()->setFlashData('pesanAkun', 'Data berhasil diperbaharui');
        return redirect()->to('/data/pengaturan')->with('success', 'Data siswa berhasil diubah.');
    }


    public function updateData()
    {
        session();
        $data = json_decode($this->request->getBody(), true); // Ambil data dari permintaan POST

        $id = 1; // Ganti dengan ID data yang ingin Anda perbarui

        // Panggil model untuk memperbarui data
        $this->pengaturanModel->updatePengaturan($id, $data);
        session()->setFlashData('pesanDataCetak', 'Data berhasil diperbaharui');

        // Berikan respons jika diperlukan
        return $this->response->setJSON(['message' => 'Data berhasil diperbaharui']);
    }

    public function delete()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $userModel = new UserModel();

            foreach ($ids as $id) {
                // Hapus item berdasarkan ID
                $userModel->delete($id);
            }

            session()->setFlashData('pesanHapusMhs', 'Post berhasil dihapus');
            return redirect()->to('data/mahasiswa')->with('success', 'Data pengguna berhasil disimpan.');
        } else {

            return redirect()->back();
        }
    }

    public function kopsurat()
    {
        $model = new PengaturanModel();

        if ($this->request->getMethod() === 'post') {
            $existingData = $model->first();

            // Ambil file yang diunggah
            $file = $this->request->getFile('kop_surat');

            // Validasi file ekstensi
            if ($file->isValid() && !$file->hasMoved()) {
                // Validasi ekstensi file yang diijinkan
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
                $fileExtension = $file->getClientExtension();

                if (in_array($fileExtension, $allowedExtensions)) {
                    $newName = $file->getRandomName();
                    $newLocation = 'assets/dist/img' . DIRECTORY_SEPARATOR;
                    $file->move($newLocation, $newName);

                    // Perbarui nama file dalam database
                    $model->update($existingData['id'], ['kop_surat' => $newName]);
                    session()->setFlashData('pesanDataCetak', 'Data berhasil diperbaharui');
                    return redirect()->to('/data/pengaturan');
                } else {
                    session()->setFlashData('pesanError', 'Jenis file tidak diijinkan.');
                    return redirect()->to('/data/pengaturan');
                }
            } else {
                session()->setFlashData('pesanError', 'Terjadi kesalahan dalam pengunggahan file.');
                return redirect()->to('/data/pengaturan');
            }
        }

        return view('upload_form');
    }

    public function logo()
    {
        $model = new PengaturanModel();

        if ($this->request->getMethod() === 'post') {
            $existingData = $model->first();

            // Ambil file yang diunggah
            $file = $this->request->getFile('logo');

            // Validasi file ekstensi
            if ($file->isValid() && !$file->hasMoved()) {
                // Validasi ekstensi file yang diijinkan
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
                $fileExtension = $file->getClientExtension();

                if (in_array($fileExtension, $allowedExtensions)) {
                    $newName = $file->getRandomName();
                    $newLocation = 'assets/dist/img' . DIRECTORY_SEPARATOR;
                    $file->move($newLocation, $newName);

                    // Perbarui nama file dalam database
                    $model->update($existingData['id'], ['logo' => $newName]);
                    session()->setFlashData('pesanLogo', 'Data berhasil diperbaharui');
                    return redirect()->to('/data/pengaturan');
                } else {
                    session()->setFlashData('pesanError', 'Jenis file tidak diijinkan.');
                    return redirect()->to('/data/pengaturan');
                }
            } else {
                session()->setFlashData('pesanError', 'Terjadi kesalahan dalam pengunggahan file.');
                return redirect()->to('/data/pengaturan');
            }
        }

        return view('upload_form');
    }

    public function favicon()
    {
        $model = new PengaturanModel();

        if ($this->request->getMethod() === 'post') {
            $existingData = $model->first();

            // Ambil file yang diunggah
            $file = $this->request->getFile('favicon');

            // Validasi file ekstensi
            if ($file->isValid() && !$file->hasMoved()) {
                // Validasi ekstensi file yang diijinkan
                $allowedExtensions = ['ico'];
                $fileExtension = $file->getClientExtension();

                if (in_array($fileExtension, $allowedExtensions)) {
                    // Tentukan nama file
                    $newName = 'favicon.ico';
                    $newLocation = 'assets/dist/img/ilustrasi' . DIRECTORY_SEPARATOR;

                    // Pindahkan file ke lokasi yang ditentukan dan ganti file lama jika sudah ada
                    $file->move($newLocation, $newName, true);

                    // Perbarui nama file dalam database
                    $model->update($existingData['id'], ['favicon' => $newName]);

                    session()->setFlashData('pesanLogo', 'Data berhasil diperbaharui');
                    return redirect()->to('/data/pengaturan');
                } else {
                    session()->setFlashData('pesanError', 'Jenis file tidak diijinkan.');
                    return redirect()->to('/data/pengaturan');
                }
            } else {
                session()->setFlashData('pesanError', 'Terjadi kesalahan dalam pengunggahan file.');
                return redirect()->to('/data/pengaturan');
            }
        }

        return view('upload_form');
    }

    public function uploadLogoBank()
    {
        $model = new PengaturanModel();

        if ($this->request->getMethod() === 'post') {
            $existingData = $model->first();

            // Ambil file yang diunggah
            $file = $this->request->getFile('logo_bank');

            // Validasi file ekstensi
            if ($file->isValid() && !$file->hasMoved()) {
                // Validasi ekstensi file yang diijinkan
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
                $fileExtension = $file->getClientExtension();

                if (in_array($fileExtension, $allowedExtensions)) {
                    $newName = $file->getRandomName();
                    $newLocation = 'assets/dist/img' . DIRECTORY_SEPARATOR;
                    $file->move($newLocation, $newName);

                    // Perbarui nama file dalam database
                    $model->update($existingData['id'], ['logo_bank' => $newName]);
                    session()->setFlashData('pesanLogo', 'Data berhasil diperbaharui');
                    return redirect()->to('/data/pengaturan');
                } else {
                    session()->setFlashData('pesanError', 'Jenis file tidak diijinkan.');
                    return redirect()->to('/data/pengaturan');
                }
            } else {
                session()->setFlashData('pesanError', 'Terjadi kesalahan dalam pengunggahan file.');
                return redirect()->to('/data/pengaturan');
            }
        }

        return view('upload_form');
    }

    public function uploadRestoreFile()
    {
        $file = $this->request->getFile('sqlFile');

        if ($file->isValid() && !$file->hasMoved()) {
            // Validasi ekstensi file
            $extension = $file->getClientExtension();
            if ($extension !== 'sql') {
                session()->setFlashdata('error', 'Hanya file dengan ekstensi .sql yang diizinkan.');
                return redirect()->to('/pemeliharaan');
            }

            $filePath = $file->getTempName();
            // Panggil fungsi restoreDatabase Anda
            $restoreResult = $this->restoreDatabase($filePath);

            if ($restoreResult) {
                // Menyimpan pesan sukses dalam session flash data
                session()->setFlashdata('success', 'Database berhasil di-restore.');
            } else {
                // Menyimpan pesan error dalam session flash data
                session()->setFlashdata('error', 'Gagal melakukan restore database.');
            }
        } else {
            session()->setFlashdata('error', 'Gagal mengunggah file.');
        }

        return redirect()->to('/pemeliharaan');
    }

    private function restoreDatabase($filePath)
    {
        // Mendapatkan koneksi ke database
        $db = \Config\Database::connect();

        try {
            // Menonaktifkan pemeriksaan foreign key sementara
            $db->query('SET FOREIGN_KEY_CHECKS=0');

            // Ambil semua tabel di database
            $tables = $db->listTables();

            // Hapus semua tabel
            foreach ($tables as $table) {
                $db->query("DROP TABLE IF EXISTS $table");
            }

            // Baca file SQL dan eksekusi query
            $sql = file_get_contents($filePath);
            $queries = explode(';', $sql);

            foreach ($queries as $query) {
                if (trim($query) !== '') {
                    $db->query($query);
                }
            }

            // Mengaktifkan kembali pemeriksaan foreign key
            $db->query('SET FOREIGN_KEY_CHECKS=1');

            // Mengembalikan true jika proses berhasil
            return true;
        } catch (\Exception $e) {
            // Tampilkan pesan error
            session()->setFlashdata('error', 'Failed to restore database: ' . $e->getMessage());
            return false;
        }
    }
}
