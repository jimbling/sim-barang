<?php

namespace App\Models;

use CodeIgniter\Model;

class AlertModel extends Model
{
    protected $table = 'alert_status'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';
    protected $allowedFields = ['message', 'hidden', 'show_date'];

    public function getNotificationsToShow()
    {
        $today = date('Y-m-d');

        return $this->where('show_date =', $today)
            ->where('hidden', 0)
            ->findAll();
    }



    public function markAsHidden($id)
    {
        $this->update($id, ['hidden' => true]);
    }

    public function resetHiddenStatusAfter30Days()
    {
        $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));

        // Perbarui semua data yang masih ditandai sebagai hidden dan show_date lebih dari 30 hari yang lalu
        $this->where('hidden', true)
            ->where('show_date <=', $thirtyDaysAgo)
            ->set(['hidden' => false])
            ->update();
    }
}
