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
        // Menghitung tanggal 60 hari yang lalu
        $expiredDate = date('Y-m-d', strtotime('-30 days'));

        // Mengambil data backup yang sudah kadaluarsa
        $expiredBackups = $this->where('created_at <', $expiredDate)->findAll();

        // Looping melalui data backup yang sudah kadaluarsa
        foreach ($expiredBackups as $backup) {
            // Mendapatkan nama file backup
            $namaFile = $backup['nama_file'];

            // Menghapus file sumber jika ada
            $filePath = 'database/backup/' . $namaFile; // Sesuaikan dengan path file Anda
            if (file_exists($filePath)) {
                unlink($filePath); // Menghapus file
            }
        }

        // Menghapus data backup yang sudah kadaluarsa dari database
        $this->where('created_at <', $expiredDate)->delete();

        // Mengembalikan jumlah data backup yang berhasil dihapus
        return count($expiredBackups);
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
