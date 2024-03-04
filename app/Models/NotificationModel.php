<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'message', 'read_status', 'jenis_pesan', 'created_at', 'updated_at'];

    public function getUserNotifications($userId)
    {
        // Hanya mengambil notifikasi yang belum dibaca
        return $this->where('user_id', $userId)
            ->where('read_status', 0)
            ->orderBy('created_at', 'desc')
            ->findAll();
    }

    public function markAsRead($notificationId)
    {
        // Memperbarui read_status menjadi 1 (telah dibaca) untuk notifikasi dengan ID tertentu
        $this->where('id', $notificationId)
            ->set(['read_status' => 1])
            ->update();
    }
}
