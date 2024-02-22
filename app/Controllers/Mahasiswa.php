<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\MahasiswaModel;

class Mahasiswa extends BaseController
{
    protected $mahasiswaModel;

    public function __construct()
    {

        $this->mahasiswaModel = new MahasiswaModel();
    }
    public function index()
    {

        $currentYear = date('Y');
        $csrfToken = csrf_hash();
        $mahasiswaModel = new MahasiswaModel();
        $dataMhs = $mahasiswaModel->getMahasiswa();

        $data = [
            'judul' => 'Data Mahasiswa | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'data_mahasiswa' => $dataMhs,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengaturan/daftar_mahasiswa', $data);
    }

    public function addMhs()
    {
        Session();

        // Mendapatkan data dari form
        $nim = $this->request->getPost('nim');
        $nama_lengkap = $this->request->getPost('nama_lengkap');

        // Validasi data
        if (empty($nim) || empty($nama_lengkap)) {
            // Jika ada bidang yang kosong, kembalikan ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->withInput()->with('error', 'NIM dan Nama Lengkap harus diisi.');
        }

        // Menyiapkan data untuk disimpan
        $data = [
            'nim' => $nim,
            'nama_lengkap' => $nama_lengkap,
        ];
        $mahasiswaModel = new MahasiswaModel();
        // Menyimpan data ke dalam database
        $mahasiswaModel->insertMahasiswa($data);

        // Redirect ke halaman data mahasiswa setelah berhasil disimpan
        return redirect()->to('/data/mahasiswa');
    }

    public function edit($id)
    {
        // Ambil data dari form input
        $nim = $this->request->getPost('nim_edit');
        $nama_lengkap = $this->request->getPost('nama_lengkap_edit');
        // Data valid, simpan ke dalam database
        $data = [
            'nim' => $nim,
            'nama_lengkap' => $nama_lengkap,
        ];

        // Panggil model untuk melakukan update data
        $this->mahasiswaModel->updateMahasiswa($id, $data);

        // Redirect atau tampilkan pesan sukses
        session()->setFlashData('pesanEditMhs', 'Data Mahasiswa berhasil diubah');
        return redirect()->to('/data/mahasiswa')->with('success', 'Data siswa berhasil diubah.');
    }

    public function get_detail($id)
    {
        $mahasiswaModel = new MahasiswaModel();
        $data['detail'] = $mahasiswaModel->getdetail($id);

        // Return JSON response
        return $this->response->setJSON($data['detail']);
    }

    public function delete()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $mahasiswaModel = new MahasiswaModel();

            foreach ($ids as $id) {
                // Hapus item berdasarkan ID
                $mahasiswaModel->delete($id);
            }

            session()->setFlashData('pesanHapusMhs', 'Post berhasil dihapus');
            return redirect()->to('data/mahasiswa')->with('success', 'Data pengguna berhasil disimpan.');
        } else {
            // Tangani jika tidak ada ID yang diberikan
            return redirect()->back();
        }
    }

    public function importData()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        $request = service('request');

        if ($request->getMethod() === 'post' && $request->getFile('excel_file')->isValid()) {
            $excelFile = $request->getFile('excel_file');

            // Pastikan folder penyimpanan untuk file Excel sudah ada
            $uploadPath = WRITEPATH . 'uploads/mahasiswa';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Pindahkan file yang diunggah ke folder penyimpanan
            $excelFileName = $excelFile->getRandomName();
            $excelFile->move($uploadPath, $excelFileName);

            // Proses file Excel (menggunakan library PhpSpreadsheet)
            $spreadsheet = IOFactory::load($uploadPath . '/' . $excelFileName);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            $mahasiswaModel = new \App\Models\MahasiswaModel();

            foreach ($rows as $row) {
                // Buat data barang dari baris Excel
                $nim = $row[0];
                $nama_lengkap = $row[1];


                // Menyiapkan data untuk disimpan
                $data = [
                    'nim' => $nim,
                    'nama_lengkap' => $nama_lengkap,

                ];

                // Menyimpan data ke dalam database
                $mahasiswaModel->insertMahasiswa($data);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diimpor']);
        }

        return redirect()->to('/data/mahasiswa')->with('error', 'Terjadi kesalahan dalam pengunggahan data.');
    }

    public function cari()
    {
        $keyword = $this->request->getPost('keyword');
        $mahasiswaModel = new MahasiswaModel();

        // Gunakan model untuk melakukan pencarian
        $searchResults = $mahasiswaModel->searchMahasiswa($keyword);

        // Lakukan pencarian berdasarkan $keyword

        // Mengembalikan hasil pencarian (misalnya, dalam format JSON)
        return $this->response->setJSON($searchResults);
    }
}
