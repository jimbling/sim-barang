<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

class Unauthorized extends BaseController
{
    protected $settingsService;
    public function __construct()
    {
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }

    public function index()
    {

        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $data = [
            'judul' => "Bukan Hak Akses | $namaKampus",
            'currentYear' => $currentYear,
        ];

        return view('unauthorized', $data);
    }
}
