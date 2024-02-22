<?php

namespace App\Controllers;

use App\Models\BarangPersediaanModel;
use App\Models\SatuanModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BarangPersediaan extends BaseController
{
    protected $barangpersediaanModel;
    protected $satuanModel;

    public function __construct()
    {

        $this->barangpersediaanModel = new BarangPersediaanModel();
        $this->satuanModel = new SatuanModel();
    }
    public function masterBarang()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $barangpersediaanModel = new BarangPersediaanModel();
        $dataBarangPersediaan = $barangpersediaanModel->getBarangPersediaan();

        $satuanModel = new SatuanModel();
        $dataSatuan = $satuanModel->getSatuan();
        // Mendapatkan daftar barang yang dikelompokkan berdasarkan nama_barang
        $data = [
            'judul' => 'Persediaan Barang | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_barang_persediaan' => $dataBarangPersediaan,
            'data_satuan' => $dataSatuan,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('persediaan/master_barang_persediaan', $data);
    }

    public function exportToExcel()
    {
        $barangpersediaanModel = new BarangPersediaanModel();
        $dataBarangPersediaan = $barangpersediaanModel->getBarangPersediaanbyStock();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set the column headers
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'ID')
            ->setCellValue('C1', 'Nama Barang')
            ->setCellValue('D1', 'Stok')
            ->setCellValue('E1', 'Harga Satuan')
            ->setCellValue('F1', 'Jumlah Harga');

        // Populate the data
        $row = 2;
        $no = 1; // Nomor urut awal
        foreach ($dataBarangPersediaan as $barang) {
            $jumlahHarga = $barang['stok'] * $barang['harga_satuan']; // Perkalian stok dengan harga satuan
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $row, $no)
                ->setCellValue('B' . $row, $barang['id'])
                ->setCellValue('C' . $row, $barang['nama_barang'])
                ->setCellValue('D' . $row, $barang['stok'])
                ->setCellValue('E' . $row, $barang['harga_satuan'])
                ->setCellValue('F' . $row, $jumlahHarga); // Mengisi kolom Jumlah Harga dengan hasil perkalian
            $row++;
            $no++; // Increment nomor urut
        }

        // Set the column widths
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);

        // Set the title
        $spreadsheet->getActiveSheet()->setTitle('Barang Persediaan');

        // Create a writer for Xlsx
        $writer = new Xlsx($spreadsheet);

        // Save the file to the public directory
        $filename = 'export_barang_persediaan.xlsx';
        $path = FCPATH . 'excel/' . $filename; // Sesuaikan path sesuai kebutuhan
        $writer->save($path);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Send file to browser
        $writer->save('php://output');
        exit();
    }



    public function addBarang()
    {
        Session();

        // Mendapatkan data dari form
        $prodi = $this->request->getPost('prodi');
        $kelompok_barang = $this->request->getPost('kelompok_barang');
        $nama_barang = $this->request->getPost('nama_barang');
        $satuan = $this->request->getPost('satuan');

        // Menyiapkan data untuk disimpan
        $data = [
            'prodi' => $prodi,
            'kelompok_barang' => $kelompok_barang,
            'nama_barang' => $nama_barang,
            'satuan' => $satuan,
        ];

        // Menyimpan data ke dalam database
        $barangpersediaanModel = new BarangPersediaanModel();
        $barangpersediaanModel->insertBarangPersediaan($data);

        // Mendapatkan ID dari data yang baru ditambahkan
        $id_barang = $barangpersediaanModel->insertID();

        // Membuat format kode_barang
        $kode_barang = 'YKY-Lab-Persed-' . str_pad($id_barang, 4, '0', STR_PAD_LEFT);

        // Memperbarui data dengan menambahkan kode_barang
        $barangpersediaanModel->update($id_barang, ['kode_barang' => $kode_barang]);

        session()->setFlashData('pesanAddBarangSatuan', 'Data barang baru berhasil ditambahkan');
        return redirect()->to('/barang/persediaan/master');
    }



    public function stokOpname()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $barangpersediaanModel = new BarangPersediaanModel();
        $dataBarangPersediaan = $barangpersediaanModel->getBarangPersediaanbyStock();


        // Mendapatkan daftar barang yang dikelompokkan berdasarkan nama_barang
        $data = [
            'judul' => 'Stock Opname | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_barang_persediaan' => $dataBarangPersediaan,
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('persediaan/stok_opname', $data);
    }

    public function edit($id)
    {
        // Ambil data dari form input
        $nama_barang = $this->request->getPost('nama_barang_edit');
        $jumlah_barang = $this->request->getPost('jumlah_barang_edit');
        // Data valid, simpan ke dalam database
        $data = [
            'nama_barang' => $nama_barang,
            'jumlah_barang' => $jumlah_barang,
        ];

        // Panggil model untuk melakukan update data
        $this->barangModel->updateBarang($id, $data);

        // Redirect atau tampilkan pesan sukses
        session()->setFlashData('pesanEditPostsKategori', 'Kategori berhasil diubah');
        return redirect()->to('/barang')->with('success', 'Data siswa berhasil diubah.');
    }


    public function delete()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $barangpersediaanModel = new BarangPersediaanModel();

            foreach ($ids as $id) {
                // Hapus item berdasarkan ID
                $barangpersediaanModel->delete($id);
            }

            session()->setFlashData('pesanHapusPosts', 'Post berhasil dihapus');
            return redirect()->to('barang/persediaan/master')->with('success', 'Data pengguna berhasil disimpan.');
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

        if ($request->getMethod() === 'post' && $request->getFile('excel_file_persediaan')->isValid()) {
            $excelFile = $request->getFile('excel_file_persediaan');

            // Pastikan folder penyimpanan untuk file Excel sudah ada
            $uploadPath = WRITEPATH . 'uploads/persediaan';
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

            $barangpersediaanModel = new \App\Models\BarangPersediaanModel();

            foreach ($rows as $row) {
                // Buat data barang dari baris Excel
                $nama_barang = $row[1];
                $satuan = $row[2];
                $prodi = $row[3];
                $kelompok_barang = $row[4];
                $stok = $row[5];
                $harga_satuan = $row[6];

                // Menyiapkan data untuk disimpan
                $data = [
                    'nama_barang' => $nama_barang,
                    'satuan' => $satuan,
                    'prodi' => $prodi,
                    'kelompok_barang' => $kelompok_barang,
                    'stok' => $stok,
                    'harga_satuan' => $harga_satuan,
                ];

                // Menyimpan data ke dalam database
                $id_barang = $barangpersediaanModel->insertBarangPersediaan($data);

                // Membuat kode_barang dengan format YKY-Lab-Persed-001
                $kode_barang = 'YKY-Lab-Persed-' . str_pad($id_barang, 4, '0', STR_PAD_LEFT);

                // Perbarui data untuk menyertakan kode_barang
                $data['kode_barang'] = $kode_barang;
                $barangpersediaanModel->update($id_barang, $data);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diimpor']);
        }

        return redirect()->to('/barang/persediaan/master')->with('error', 'Terjadi kesalahan dalam pengunggahan data.');
    }

    protected function generateKodeBarang($id)
    {
        // Format: YKY-Lab-Persed-000001
        return 'YKY-Lab-Persed-' . str_pad($id, 2, '0', STR_PAD_LEFT);
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
        return view('daftar_barang', $data);
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
        return view('daftar_barang_rusak', $data);
    }
}
