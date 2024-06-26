<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;
use App\Models\PembelajaranModel;


class Pembelajaran extends BaseController
{
    protected $pembelajaranModel;
    protected $settingsService;

    public function __construct()
    {

        $this->pembelajaranModel = new PembelajaranModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }

    public function index()
    {

        $currentYear = date('Y');
        $csrfToken = csrf_hash();
        $namaKampus = $this->settingsService->getNamaKampus();

        $pembelajaranModel = new PembelajaranModel();
        $dataPembelajaran     = $pembelajaranModel->getPembelajaran();

        $data = [
            'judul' => "Data Praktek Pembelajaran | $namaKampus",
            'currentYear' => $currentYear,
            'data_pembelajaran' => $dataPembelajaran,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengaturan/daftar_pembelajaran', $data);
    }

    public function addPembelajaran()
    {
        // Mendapatkan data dari form
        $namaPembelajaran = $this->request->getPost('views_namaPembelajaran');

        // Validasi input
        $validation = \Config\Services::validation();

        // Aturan validasi
        $validation->setRules([
            'views_namaPembelajaran' => [
                'label' => 'Nama Pembelajaran',
                'rules' => 'required|is_unique[tbl_praktek_pembelajaran.nama_pembelajaran]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'is_unique' => '{field} sudah ada, silakan pilih nama yang lain.'
                ]
            ]
        ]);

        // Menyiapkan data untuk disimpan
        $data = [
            'nama_pembelajaran' => $namaPembelajaran,
        ];

        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            // Ambil pesan error
            $errors = $validation->getErrors();

            // Kirimkan respon JSON dengan kesalahan validasi
            return $this->response->setJSON([
                'success' => false,
                'errors' => $errors
            ]);
        }

        // Jika validasi berhasil, simpan data
        $pembelajaranModel = new PembelajaranModel();
        $pembelajaranModel->insertPembelajaran($data);

        // Kirimkan respon JSON dengan pesan sukses
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Data pembelajaran berhasil ditambahkan.'
        ]);
    }




    public function delete()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $pembelajaranModel = new PembelajaranModel();

            foreach ($ids as $id) {
                // Hapus item berdasarkan ID
                $pembelajaranModel->delete($id);
            }

            session()->setFlashData('pesanHapusPembelajaran', 'Nama Pembelajaran berhasil dihapus');
            return redirect()->to('data/pembelajaran')->with('success', 'Data pembelajaran berhasil disimpan.');
        } else {
            // Tangani jika tidak ada ID yang diberikan
            return redirect()->back();
        }
    }
}
