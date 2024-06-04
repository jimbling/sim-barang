<?php

namespace App\Services;

use App\Models\PengaturanModel;

class SettingsService
{
    public function getPengaturan()
    {
        $pengaturanModel = new PengaturanModel();
        return $pengaturanModel->find(1); // Sesuaikan dengan id pengaturan yang sesuai
    }

    public function getNamaKampus()
    {
        $pengaturan = $this->getPengaturan();
        if ($pengaturan) {
            return $pengaturan['nama_kampus'];
        }
        return null;
    }

    public function getNomorHP()
    {
        $pengaturan = $this->getPengaturan();
        if ($pengaturan) {
            return $pengaturan['no_hp'];
        }
        return null;
    }
}
