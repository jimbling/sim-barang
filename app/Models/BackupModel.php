<?php

namespace App\Models;

use CodeIgniter\Model;

class BackupModel extends Model
{
    protected $table = 'tbl_backup';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $allowedFields = ['id', 'nama_file', 'file_zip', 'ukuran', 'ukuran_zip', 'created_at', 'updated_at'];

    public function getBackup()
    {
        return $this->findAll();
    }

    public function insertBackup($data)
    {
        return $this->insert($data);
    }

    public function getdetail($id)
    {
        return $this->find($id);
    }

    public function getLatestBackups($limit = 4)
    {
        return $this->orderBy('created_at', 'DESC')->findAll($limit);
    }

    public function deleteExpiredBackups()
    {
        // Mendapatkan data backup yang sudah kadaluarsa
        $expiredBackups = $this->getExpiredBackups();

        // Inisialisasi penghitung jumlah yang berhasil dihapus
        $deletedCount = 0;

        // Looping melalui data backup yang sudah kadaluarsa
        foreach ($expiredBackups as $backup) {
            // Mendapatkan path file yang akan dihapus
            $filePathNamaFile = 'database/backup/' . $backup['nama_file'];
            $filePathFileZip = WRITEPATH . 'backup/' . $backup['file_zip'];

            // Menghapus file nama_file jika ada
            if (file_exists($filePathNamaFile) && !unlink($filePathNamaFile)) {
                // Jika penghapusan file gagal, log error dan lanjutkan ke backup berikutnya
                log_message('error', "Gagal menghapus file: $filePathNamaFile");
                continue; // Melanjutkan ke loop berikutnya jika penghapusan gagal
            }

            // Menghapus file file_zip jika ada
            if (file_exists($filePathFileZip) && !unlink($filePathFileZip)) {
                // Jika penghapusan file gagal, log error dan lanjutkan ke backup berikutnya
                log_message('error', "Gagal menghapus file: $filePathFileZip");
                continue; // Melanjutkan ke loop berikutnya jika penghapusan gagal
            }

            // Jika file berhasil dihapus, hapus entri dari database
            if ($this->delete($backup['id'])) {
                $deletedCount++;
            } else {
                // Jika penghapusan entri database gagal, log error
                log_message('error', "Gagal menghapus entri backup ID: " . $backup['id']);
            }
        }

        // Mengembalikan jumlah data backup yang berhasil dihapus
        return $deletedCount;
    }




    public function getExpiredBackups()
    {
        // Menghitung tanggal 60 hari yang lalu
        $expiredDate = date('Y-m-d', strtotime('-30 days'));

        // Membuat query untuk menampilkan file backup yang sudah berusia 60 hari
        $query = $this->where('created_at <', $expiredDate)->findAll();

        return $query;
    }
}
