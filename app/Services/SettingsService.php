<?php

namespace App\Services;

use App\Models\PengaturanModel;

class SettingsService
{
    public function getNamaKampus()
    {
        $pengaturanModel = new PengaturanModel();
        $pengaturan = $pengaturanModel->find(1); // Sesuaikan dengan id pengaturan yang sesuai
        if ($pengaturan) {
            return $pengaturan['nama_kampus'];
        }
        return null;
    }
}
