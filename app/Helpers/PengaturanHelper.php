<?php

if (!function_exists('getNamaKampus')) {
    function getNamaKampus()
    {
        $pengaturanModel = new \App\Models\PengaturanModel();
        $pengaturan = $pengaturanModel->first(); // Mendapatkan data pertama dari pengaturan
        return $pengaturan ? $pengaturan['nama_kampus'] : '';
    }
}
