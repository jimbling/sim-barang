<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;
use App\Models\SatuanModel;


class Satuan extends BaseController
{
    protected $satuanModel;
    protected $settingsService;

    public function __construct()
    {

        $this->satuanModel = new SatuanModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }

    public function index()
    {

        $currentYear = date('Y');
        $csrfToken = csrf_hash();
        $namaKampus = $this->settingsService->getNamaKampus();

        $satuanModel = new SatuanModel();
        $dataSatuan = $satuanModel->getSatuan();

        $data = [
            'judul' => "Data Satuan Barang | $namaKampus",
            'currentYear' => $currentYear,
            'data_satuan' => $dataSatuan,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('persediaan/daftar_satuan', $data);
    }

    public function addSatuan()
    {
        Session();

        // Mendapatkan data dari form
        $nama_satuan = $this->request->getPost('nama_satuan');


        // Menyiapkan data untuk disimpan
        $data = [
            'nama_satuan' => $nama_satuan,

        ];
        $satuanModel = new SatuanModel();
        // Menyimpan data ke dalam database
        $satuanModel->insertSatuan($data);

        return redirect()->to('/barang/satuan');
    }




    public function delete()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $satuanModel = new SatuanModel();

            foreach ($ids as $id) {
                // Hapus item berdasarkan ID
                $satuanModel->delete($id);
            }

            session()->setFlashData('pesanHapusSatuan', 'Post berhasil dihapus');
            return redirect()->to('barang/satuan')->with('success', 'Data pengguna berhasil disimpan.');
        } else {
            // Tangani jika tidak ada ID yang diberikan
            return redirect()->back();
        }
    }
}
