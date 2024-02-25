<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\UserModel;
use App\Models\DosenTendikModel;

class DosenTendik extends BaseController
{
    protected $dosentendikModel;
    protected $userModel;

    public function __construct()
    {

        $this->dosentendikModel = new DosenTendikModel();
        $this->userModel = new UserModel();
    }
    public function index()
    {

        $currentYear = date('Y');
        $csrfToken = csrf_hash();
        $dosentendikModel = new DosenTendikModel();
        $dataDosenTendik = $dosentendikModel->getDosenTendik();

        $data = [
            'judul' => 'Dosen dan Tendik | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
            'dosen_tendik' => $dataDosenTendik,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('pengaturan/daftar_dosen_tendik', $data);
    }

    public function getDataDosenTendik()
    {
        $request = $this->request;

        // Your code to fetch data from the model
        $model = new DosenTendikModel();
        $data = $model->findAll();

        $json_data = array(
            "draw"            => intval($request->getPost('draw')),
            "recordsTotal"    => count($data),
            "recordsFiltered" => count($data),
            "data"            => $data
        );

        return $this->response->setJSON($json_data);
    }

    public function addDosenTendik()
    {
        Session();

        // Mendapatkan data dari form
        $nik = $this->request->getPost('nik');
        $nama_lengkap = $this->request->getPost('nama_lengkap');
        $jabatan = $this->request->getPost('jabatan');

        // Validasi data
        if (empty($nik) || empty($nama_lengkap)) {
            // Jika ada bidang yang kosong, kembalikan ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->withInput()->with('error', 'NIK dan Nama Lengkap harus diisi.');
        }
        // Menyiapkan data untuk disimpan
        $data = [
            'nik' => $nik,
            'nama_lengkap' => $nama_lengkap,
            'jabatan' => $jabatan,
        ];
        $dosentendikModel = new DosenTendikModel();
        // Menyimpan data ke dalam database
        $dosentendikModel->insertDosenTendik($data);

        return redirect()->to('/data/dosen_tendik');
    }

    public function edit($id)
    {
        // Ambil data dari form input
        $nik = $this->request->getPost('nik_edit');
        $nama_lengkap = $this->request->getPost('nama_lengkap_edit');
        $jabatan = $this->request->getPost('jabatan_edit');
        // Data valid, simpan ke dalam database
        $data = [
            'nik' => $nik,
            'nama_lengkap' => $nama_lengkap,
            'jabatan' => $jabatan,
        ];

        // Panggil model untuk melakukan update data
        $this->dosentendikModel->updateDosenTendik($id, $data);

        // Redirect atau tampilkan pesan sukses
        session()->setFlashData('pesanEditDosenTendik', 'Data Dosen/Tendik berhasil diubah');
        return redirect()->to('/data/dosen_tendik')->with('success', 'Data siswa berhasil diubah.');
    }

    public function get_detail($id)
    {
        $dosentendikModel = new DosenTendikModel();
        $data['detail'] = $dosentendikModel->getdetail($id);

        // Return JSON response
        return $this->response->setJSON($data['detail']);
    }

    public function delete()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $dosentendikModel = new DosenTendikModel();

            foreach ($ids as $id) {
                // Hapus item berdasarkan ID
                $dosentendikModel->delete($id);
            }

            session()->setFlashData('pesanHapusDosenTendik', 'Post berhasil dihapus');
            return redirect()->to('data/dosen_tendik')->with('success', 'Data pengguna berhasil disimpan.');
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
            $uploadPath = WRITEPATH . 'uploads/dosen_tendik';
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

            $dosentendikModel = new \App\Models\DosenTendikModel();

            foreach ($rows as $row) {
                // Buat data barang dari baris Excel
                $nik = $row[0];
                $nama_lengkap = $row[1];
                $jabatan = $row[2];


                // Menyiapkan data untuk disimpan
                $data = [
                    'nik' => $nik,
                    'nama_lengkap' => $nama_lengkap,
                    'jabatan' => $jabatan,


                ];

                // Menyimpan data ke dalam database
                $dosentendikModel->insertDosenTendik($data);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diimpor']);
        }

        return redirect()->to('/data/mahasiswa')->with('error', 'Terjadi kesalahan dalam pengunggahan data.');
    }

    public function buatAkun()
    {
        // Ambil data yang dipilih dari form (checkbox)
        $selectedIds = $this->request->getVar('selected_ids');

        if (!empty($selectedIds)) {
            // Instansiasi model
            $dosenTendikModel = new DosenTendikModel();
            $userModel = new UserModel(); // Sesuaikan dengan nama model yang digunakan untuk tabel tbl_user

            // Lakukan validasi bahwa kolom user_nama harus unik
            $selectedData = $dosenTendikModel->whereIn('id', $selectedIds)->findAll();
            $errors = []; // Inisialisasi array untuk menyimpan pesan kesalahan

            foreach ($selectedData as $data) {
                $existingUser = $userModel->where('user_nama', $data['nik'])->first();
                if ($existingUser) {
                    // Tambahkan pesan kesalahan ke dalam array dengan format HTML
                    $errorMessage = "Tidak dapat membuat Akun Login karena user dengan NIK <strong>{$data['nik']}</strong> (nama lengkap: <strong>{$data['nama_lengkap']}</strong>) sudah ada.";
                    $errors[] = $errorMessage;
                }
            }

            // Jika ada pesan kesalahan, kirim respons JSON dengan daftar pesan kesalahan
            if (!empty($errors)) {
                return $this->response->setJSON(['success' => false, 'errors' => $errors]);
            }

            // Memanggil method copyDataToUser dari model DosenTendikModel
            $dosenTendikModel->copyDataToUser($selectedIds);

            // Berikan respons sukses
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil disalin ke tabel user.']);
        } else {
            // Berikan respons jika tidak ada data yang dipilih
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada data yang dipilih.']);
        }
    }
}
