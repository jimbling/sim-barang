<?php

namespace App\Helpers;

use App\Models\PengaturanModel;

class SettingsHelper
{
    public static function getNamaKampus()
    {
        $pengaturanModel = new PengaturanModel();
        $pengaturan = $pengaturanModel->find(1); // Sesuaikan dengan id pengaturan yang sesuai
        if ($pengaturan) {
            return $pengaturan['nama_kampus'];
        }
        return null;
    }
}
