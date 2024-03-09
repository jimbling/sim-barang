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
                'website' => $pengaturan['website'],
                'logo' => $pengaturan['logo'],
                'alamat' => $pengaturan['alamat'],
                'no_telp' => $pengaturan['no_telp'],
                'email' => $pengaturan['email'],
                'nama_bank' => $pengaturan['nama_bank'],
                'no_rekening' => $pengaturan['no_rekening'],
                'atas_nama' => $pengaturan['atas_nama']
            ];
        } else {
            return [
                'nama_kampus' => "Nama Kampus Default",
                'website' => "Website Default",
                'logo' => "Logo Default",
                'alamat' => "Alamat Default",
                'no_telp' => "No Telp Default",
                'email' => "Email Default",
                'nama_bank' => "Bank Default",
                'no_rekening' => "No Rek Default",
                'atas_nama' => "Nama Default",
            ];
        }
    }
}
