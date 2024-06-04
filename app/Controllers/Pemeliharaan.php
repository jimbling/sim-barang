<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

use App\Models\PengaturanModel;
use App\Models\UserModel;
use Ifsnop\Mysqldump\Mysqldump;
use App\Models\BackupModel;

class Pemeliharaan extends BaseController
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
        $backupModel = new BackupModel();
        $dbBackup = $backupModel->getLatestBackups();
        $expiredBackups = $backupModel->getExpiredBackups();

        $data = [
            'judul' => "Setting Data | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'dataCetak' => $dataCetak,
            'data_pengguna' => $pengguna,
            'backup_db' => $dbBackup,
            'backup_kadaluarsa' => $expiredBackups
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengaturan/pemeliharaan', $data);
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

    public function backup()
    {
        try {
            $tglSekarang = date('Y-m-dHis');
            $dump = new Mysqldump('mysql:host=localhost;dbname=yky_pinjam;port=3306', 'root', '');
            $dumpFile = 'database/backup/db-' . $tglSekarang . '.sql';
            $dump->start($dumpFile);

            // Mengukur ukuran file yang dihasilkan dalam byte
            $ukuranFile = filesize($dumpFile);

            // Menggunakan basename() untuk mendapatkan nama file tanpa folder
            $namaFileTanpaFolder = basename($dumpFile);

            // Setelah backup berhasil, simpan nama file dan ukuran file ke dalam database
            $backupModel = new BackupModel();
            $data = [
                'nama_file' => $namaFileTanpaFolder,
                'ukuran' => $ukuranFile, // Menyimpan ukuran file dalam byte
            ];
            $backupModel->insertBackup($data);

            $pesan = "Backup Berhasil...";
            session()->setFlashData('pesan', $pesan);

            // Kembalikan nama file sebagai response JSON
            return $this->response->setJSON(['nama_file' => $namaFileTanpaFolder, 'ukuran' => $ukuranFile]);
        } catch (\Exception $e) {
            $pesan = "mysqldump error-php error" . $e->getMessage();
            session()->setFlashData('pesan', $pesan);
            return redirect()->to('/data/pengaturan')->with('success', 'Data siswa berhasil diubah.');
        }
    }


    public function unduh($namaFile)
    {
        // Tentukan path lengkap ke file backup
        $fileBackup = 'database/backup/' . $namaFile;

        // Pastikan file ada sebelum mencoba mengirimkannya
        if (file_exists($fileBackup)) {
            // Tentukan header untuk memicu unduhan
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($fileBackup) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileBackup));
            readfile($fileBackup);
            exit;
        } else {
            // Jika file tidak ditemukan, tampilkan pesan atau lakukan sesuatu yang sesuai
            echo "File tidak ditemukan";
        }
    }

    public function deleteExpiredBackups()
    {
        if ($this->request->getMethod() === 'post') {
            // Menjalankan proses penghapusan hanya jika permintaan adalah POST
            $backupModel = new BackupModel();

            // Menghapus semua backup yang sudah kadaluarsa
            $deletedCount = $backupModel->deleteExpiredBackups();

            // Setelah penghapusan berhasil, set pesan sukses
            if ($deletedCount > 0) {
                $pesan = "Total $deletedCount backup kadaluarsa berhasil dihapus.";
                session()->setFlashData('pesan', $pesan);
            } else {
                $pesan = "Tidak ada backup yang kadaluarsa untuk dihapus.";
                session()->setFlashData('pesan', $pesan);
            }
        }

        return redirect()->to('/pemeliharaan'); // Redirect kembali ke halaman pengaturan setelah selesai
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
        $data = $this->request->getJSON(true); // Mengambil data dari permintaan POST dalam format JSON

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
            // Tangani jika tidak ada ID yang diberikan
            return redirect()->back();
        }
    }

    public function getAllBackups()
    {
        $backupModel = new BackupModel();
        $allBackups = $backupModel->findAll();

        return $this->response->setJSON($allBackups);
    }

    public function getLatestBackups()
    {
        $backupModel = new BackupModel();
        $latestBackups = $backupModel->getLatestBackups();

        return $this->response->setJSON($latestBackups);
    }
}
