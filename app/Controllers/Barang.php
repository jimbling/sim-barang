<?php

namespace App\Controllers;

use App\Models\BarangModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Barang extends BaseController
{
    protected $barangModel;

    public function __construct()
    {

        $this->barangModel = new BarangModel();
    }
    public function masterBarang()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $barangModel = new BarangModel();
        $dataBarang = $barangModel->getBarang();
        // Mendapatkan daftar barang yang dikelompokkan berdasarkan nama_barang
        $groupedBarang = $barangModel->groupByNamaBarang();
        $data = [
            'judul' => 'Master Barang | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_barang' => $dataBarang,
            'grupBarang' => $groupedBarang
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('barang-lab/master_barang', $data);
    }

    public function addBarang()
    {
        Session();

        // Mendapatkan data dari form
        $kode_barang = $this->request->getPost('kode_barang');
        $nama_barang = $this->request->getPost('nama_barang');
        $jumlah_barang = $this->request->getPost('jumlah_barang');
        $slug = url_title($this->request->getVar('nama_barang'), '-', true);
        // Menyiapkan data untuk disimpan
        $data = [
            'nama_barang' => $nama_barang,
            'jumlah_barang' => $jumlah_barang,
            'kode_barang' => $kode_barang,
            'slug' => $slug,
        ];
        $barangModel = new BarangModel();
        // Menyimpan data ke dalam database
        $barangModel->insertBarang($data);

        return redirect()->to('/barang/master');
    }


    public function get_detail($id)
    {
        $barangModel = new BarangModel();
        $data['detail'] = $barangModel->getdetail($id);

        // Return JSON response
        return $this->response->setJSON($data['detail']);
    }

    public function edit($id)
    {
        // Ambil data dari form input
        $nama_barang = $this->request->getPost('nama_barang_edit');
        $jumlah_barang = $this->request->getPost('jumlah_barang_edit');
        $kondisi_barang = $this->request->getPost('kondisi_barang_edit');
        $disewakan = $this->request->getPost('disewakan_edit');
        $harga_sewa = $this->request->getPost('harga_sewa_edit');
        // Data valid, simpan ke dalam database
        $data = [
            'nama_barang' => $nama_barang,
            'jumlah_barang' => $jumlah_barang,
            'kondisi_barang' => $kondisi_barang,
            'disewakan' => $disewakan,
            'harga_sewa' => $harga_sewa,
        ];

        // Panggil model untuk melakukan update data
        $this->barangModel->updateBarang($id, $data);

        // Redirect atau tampilkan pesan sukses
        session()->setFlashData('pesanEditBarang', 'Data barang berhasil diubah');
        return redirect()->to('/barang/master')->with('success', 'Data siswa berhasil diubah.');
    }


    public function delete()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $barangModel = new BarangModel();

            foreach ($ids as $id) {
                // Hapus item berdasarkan ID
                $barangModel->delete($id);
            }

            session()->setFlashData('pesanHapusPosts', 'Post berhasil dihapus');
            return redirect()->to('/barang/master')->with('success', 'Data pengguna berhasil disimpan.');
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
            $uploadPath = WRITEPATH . 'uploads/barang_lab';
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

            $barangModel = new \App\Models\BarangModel();

            foreach ($rows as $row) {
                // Buat data barang dari baris Excel
                $kode_barang = $row[0];
                $nama_barang = $row[1];
                $jumlah_barang = $row[2];

                // Menyiapkan data untuk disimpan
                $data = [
                    'nama_barang' => $nama_barang,
                    'jumlah_barang' => $jumlah_barang,
                    'kode_barang' => $kode_barang,
                ];

                // Menyimpan data ke dalam database
                $barangModel->insertBarang($data);
                // Mengisi kolom "slug" berdasarkan "nama_barang"
                $slug = url_title($nama_barang, '-', true); // Gunakan karakter strip sebagai pemisah, true untuk menghindari karakter yang tidak valid
                $barangModel->update($barangModel->insertID(), ['slug' => $slug]);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diimpor']);
        }

        return redirect()->to('/barang/master')->with('error', 'Terjadi kesalahan dalam pengunggahan data.');
    }

    public function daftarBarang()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $barangModel = new BarangModel();
        $groupedBarang = $barangModel->groupByNamaBarang();

        // Mendapatkan detail barang untuk setiap kelompok
        $detailBarang = [];
        foreach ($groupedBarang as $all_post) {
            $detailBarang[$all_post['nama_barang']] = $barangModel->getDetailBarangByNama($all_post['nama_barang']);
        }

        $data = [
            'judul' => 'Daftar Barang | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,
            'grupBarang' => $groupedBarang,
            'detailBarang' => $detailBarang, // Menambahkan detail barang ke dalam data
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('barang-lab/daftar_barang', $data);
    }

    public function daftarBarangRusak()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $barangModel = new BarangModel();
        $barangRusak = $barangModel->groupByNamaBarangRusak();

        // Mendapatkan detail barang untuk setiap kelompok
        $detailBarang = [];
        foreach ($barangRusak as $barang_rusak) {
            $detailBarang[$barang_rusak['nama_barang']] = $barangModel->groupByNamaBarangRusak($barang_rusak['nama_barang']);
        }

        $data = [
            'judul' => 'Daftar Barang Rusak | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,
            'data_barang_rusak' => $barangRusak,
            'detailBarang' => $detailBarang, // Menambahkan detail barang ke dalam data
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('barang-lab/daftar_barang_rusak', $data);
    }

    public function daftarBarangDisewakan()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $barangModel = new BarangModel();
        $barangDisewakan = $barangModel->getDaftarBarangDisewakan();

        // Mendapatkan detail barang untuk setiap kelompok
        $detailBarang = [];
        foreach ($barangDisewakan as $barang_disewakan) {
            $detailBarang[$barang_disewakan['nama_barang']] = $barangModel->getDaftarBarangDisewakan($barang_disewakan['nama_barang']);
        }

        $data = [
            'judul' => 'Daftar Barang Disewakan | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,
            'data_barang_disewakan' => $barangDisewakan,
            'detailBarang' => $detailBarang, // Menambahkan detail barang ke dalam data
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('barang-lab/daftar_barang_disewakan', $data);
    }
}
