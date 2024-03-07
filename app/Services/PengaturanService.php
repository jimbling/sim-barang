<?php

namespace App\Services;

use App\Models\PengaturanModel;

class PengaturanService
{
    protected $pengaturanModel;

    public function __construct()
    {
        $this->pengaturanModel = new PengaturanModel();
    }

    public function getNamaKampus()
    {
        $pengaturan = $this->pengaturanModel->first(); // Mengambil baris pertama dari tabel
        if ($pengaturan) {
            return [
                'nama_kampus' => $pengaturan['nama_kampus'],
                'website' => $pengaturan['website']
            ];
        } else {
            return [
                'nama_kampus' => "Nama Kampus Default",
                'website' => "Website Default"
            ];
        }
    }
}
