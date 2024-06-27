<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

use App\Models\PengaturanModel;
use App\Models\UserModel;
use Ifsnop\Mysqldump\Mysqldump;
use App\Models\BackupModel;
use ZipArchive;

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
        // Mengambil data yang dikirimkan melalui POST dengan alias
        $id = $this->request->getPost('id');
        $fullName = $this->request->getPost('fullName'); // Alias untuk full_nama
        $username = $this->request->getPost('username'); // Alias untuk user_nama
        $password = $this->request->getPost('password'); // Alias untuk user_password

        // Pemetaan alias ke kolom database asli
        $data = [
            'full_nama' => $fullName,
            'user_nama' => $username,
            'user_password' => password_hash($password, PASSWORD_DEFAULT), // Hashing password
        ];

        // Lakukan pembaruan data ke database menggunakan model UserModel
        $userModel = new \App\Models\UserModel();
        $userModel->updateUser($id, $data);

        // Pesan respons
        $response = [
            'status' => 'success',
            'message' => 'Data berhasil diperbarui',
            'redirect' => '/data/pengaturan',
        ];

        // Kirim respons JSON ke JavaScript
        session()->setFlashData('pesanAkun', 'Data berhasil diperbaharui');
        return redirect()->to('/data/pengguna')->with('success', 'Data pengguna berhasil diubah.');
    }

    public function updateAdmin()
    {
        // Validasi input
        $validation = $this->validate([
            'fullName' => 'required',
            'username' => 'required',
            'password' => [
                'rules' => 'permit_empty|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).*$/]',
                'errors' => [
                    'min_length' => 'Password harus memiliki setidaknya 8 karakter.',
                    'regex_match' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka.'
                ]
            ],
        ]);

        // Jika validasi gagal, kirimkan pesan error menggunakan session flashdata
        if (!$validation) {
            $errors = $this->validator->getErrors();
            $errorMessage = '';

            // Buat pesan error yang lebih spesifik
            foreach ($errors as $field => $error) {
                $errorMessage .= $error . ' '; // Gabungkan pesan error
            }

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => trim($errorMessage) // Hapus spasi di awal dan akhir pesan
                ]);
            } else {
                return redirect()->back()->withInput()->with('errors', $errors);
            }
        }

        // Mengambil data yang dikirimkan melalui POST dengan alias
        $id = $this->request->getPost('id');
        $fullName = $this->request->getPost('fullName'); // Alias untuk full_nama
        $username = $this->request->getPost('username'); // Alias untuk user_nama
        $userEmail = $this->request->getPost('userEmail'); // Alias untuk user_nama
        $password = $this->request->getPost('password'); // Alias untuk user_password

        // Pemetaan alias ke kolom database asli
        $data = [
            'full_nama' => $fullName,
            'user_nama' => $username,
            'email' => $userEmail,
        ];

        // Jika password tidak kosong, tambahkan ke data
        if (!empty($password)) {
            $data['user_password'] = password_hash($password, PASSWORD_DEFAULT); // Hashing password
        }

        // Lakukan pembaruan data ke database menggunakan model UserModel
        $userModel = new \App\Models\UserModel();
        $updateStatus = $userModel->update($id, $data);

        // Periksa apakah pembaruan berhasil
        if ($updateStatus) {
            $successMessage = 'Data pengguna berhasil diperbaharui';
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'success', 'message' => $successMessage]);
            } else {
                session()->setFlashData('success', $successMessage);
            }
        } else {
            $errorMessage = 'Data pengguna gagal diperbaharui';
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => $errorMessage]);
            } else {
                session()->setFlashData('errors', [$errorMessage]);
            }
        }

        // Redirect ke halaman pengaturan
        return redirect()->to('/data/pengaturan');
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

    public function restoreFiles()
    {
        try {
            // Memeriksa jika ada file yang di-upload
            $uploadedFile = $this->request->getFile('fileZip');

            if ($uploadedFile && $uploadedFile->isValid()) {
                // Ambil tipe MIME file yang di-upload
                $mimeType = $uploadedFile->getClientMimeType();
                $allowedMimeTypes = ['application/zip', 'application/x-zip-compressed', 'multipart/x-zip'];

                // Validasi: apakah file ZIP (dengan beberapa tipe MIME yang mungkin)
                if (!in_array($mimeType, $allowedMimeTypes)) {
                    throw new \Exception("File yang di-upload bukan file ZIP. Tipe MIME diterima: " . $mimeType);
                }

                // Lokasi penyimpanan sementara
                $temporaryPath = WRITEPATH . 'uploads/';
                $uploadedFile->move($temporaryPath, $uploadedFile->getClientName());

                // Path file ZIP yang di-upload
                $zipFilePath = $temporaryPath . $uploadedFile->getClientName();

                // Lokasi tujuan untuk ekstraksi
                $extractTo = FCPATH . 'uploads/';

                // Membuka dan mengekstrak file ZIP
                $zip = new ZipArchive();
                if ($zip->open($zipFilePath) === TRUE) {
                    $zip->extractTo($extractTo);
                    $zip->close();

                    // Hapus file ZIP setelah ekstraksi berhasil
                    unlink($zipFilePath);

                    // Pesan sukses setelah restore
                    $pesan = "File ZIP berhasil di-upload dan direstore.";
                    session()->setFlashData('pesan', $pesan);

                    // Redirect ke halaman /pemeliharaan dengan pesan sukses
                    return redirect()->to('/pemeliharaan')->with('success', $pesan);
                } else {
                    throw new \Exception("Gagal membuka file ZIP.");
                }
            } else {
                throw new \Exception("Tidak ada file yang di-upload atau file tidak valid.");
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani dan berikan pesan error
            $pesan = "Terjadi kesalahan saat melakukan restore: " . $e->getMessage();
            session()->setFlashData('pesan', $pesan);
            return redirect()->to('/pemeliharaan')->with('error', $pesan);
        }
    }
}
