<?php

namespace App\Models;

use CodeIgniter\Model;

class BackupModel extends Model
{
    protected $table = 'tbl_backup';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true; // Pastikan ini true
    protected $useTimestamps = true; // Sesuaikan dengan kebutuhan Anda
    protected $allowedFields = ['id', 'nama_file', 'ukuran', 'created_at', 'updated_at'];

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
    public function getLatestBackups($limit = 2)
    {
        return $this->orderBy('created_at', 'DESC')->findAll($limit);
    }
}
