<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlertModel;

class Alert extends BaseController
{

    protected $notificationModel;
    public function __construct()
    {

        $this->notificationModel = new AlertModel();
    }
    public function getNotificationsToShow()
    {
        $alertModel = new AlertModel();
        $notifications = $alertModel->getNotificationsToShow();
        // Panggil fungsi resetHiddenStatusAfter30Days
        $this->notificationModel->resetHiddenStatusAfter30Days();
        // Mengirimkan respons JSON
        return $this->response->setJSON($notifications);
    }

    public function updateAlertHiddenStatus($id)
    {
        // Ambil data notifikasi yang akan diubah
        $notification = $this->notificationModel->find($id);

        // Jika data ditemukan
        if ($notification) {
            // Atur nilai hidden menjadi true untuk notifikasi lama
            $this->notificationModel->update($id, ['hidden' => true]);

            // Tambahkan data baru ke database
            $newNotification = [
                'message' => 'Silakan lakukan backup database',
                'show_date' => date('Y-m-d', strtotime('+7 days')), // Menambahkan 7 hari dari tanggal saat ini
                'hidden' => false
            ];
            $this->notificationModel->insert($newNotification);

            // Mengirimkan respons JSON bahwa penambahan berhasil
            return $this->response->setJSON(['status' => 'success']);
        } else {
            // Mengirimkan respons JSON bahwa data tidak ditemukan
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data notifikasi tidak ditemukan']);
        }
    }
}
