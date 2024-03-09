<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\PengaturanService;

class Kampus extends BaseController
{
    public function index()
    {
        $pengaturanService = new PengaturanService();
        $data_pengaturan = $pengaturanService->getNamaKampus();

        // Kirim data ke view
        return view('setting_data', $data_pengaturan);
    }
}
