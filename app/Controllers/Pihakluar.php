<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

use App\Models\BarangModel;
use App\Models\PihakluarPeminjamanModel;
use App\Models\PihakluarDetailModel;
use App\Models\RiwayatpihakluarModel;

class Pihakluar extends BaseController
{
    protected $barangModel;
    protected $pihakluarpeminjamanModel;
    protected $pihakluardetailModel;
    protected $riwayatpihakluarModel;
    protected $settingsService;

    public function __construct()
    {

        $this->barangModel = new BarangModel();
        $this->pihakluarpeminjamanModel = new PihakluarPeminjamanModel();
        $this->pihakluardetailModel = new PihakluarDetailModel();
        $this->riwayatpihakluarModel = new RiwayatpihakluarModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }

    public function index()
    {
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $barangModel = new BarangModel();
        $barangByStatus = $barangModel->getBarangDisewakan();


        $data = [
            'judul' => "Pihak Luar | $namaKampus",
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'currentYear' => $currentYear,
            'data_barang' => $barangByStatus,
            'kode_pinjam' => $this->pihakluarpeminjamanModel->generateKodePinjam(),
        ];

        return view('pihak-luar/daftar', $data);
    }

    public function prosesPeminjaman()
    {
        // Validasi input
        $validationRules = [
            'kode_pinjam' => 'required',
            'nama_peminjam' => 'required',
            'nama_instansi' => 'required',
            'alamat_instansi' => 'required',
            'no_telp' => 'required',
            'email' => 'required|valid_email',
            'tanggal_pinjam' => 'required|valid_date',
            'tanggal_kembali' => 'required|valid_date',
            'barang' => 'required',
        ];

        $validationMessages = [
            'kode_pinjam' => [
                'required' => 'Kode Peminjaman harus diisi.',
            ],
            'nama_peminjam' => [
                'required' => 'Nama Peminjam harus diisi.',
            ],
            'nama_instansi' => [
                'required' => 'Nama Instansi harus diisi.',
            ],
            'alamat_instansi' => [
                'required' => 'Alamat Instansi harus diisi.',
            ],
            'no_telp' => [
                'required' => 'Nomor Telepon harus diisi.',
            ],
            'email' => [
                'required' => 'Email harus diisi.',
                'valid_email' => 'Format Email tidak valid.',
            ],
            'tanggal_pinjam' => [
                'required' => 'Tanggal Pinjam harus diisi.',
                'valid_date' => 'Format Tanggal Pinjam tidak valid.',
            ],
            'tanggal_kembali' => [
                'required' => 'Tanggal Kembali harus diisi.',
                'valid_date' => 'Format Tanggal Kembali tidak valid.',
            ],
            'barang' => [
                'required' => 'Pilih minimal satu barang.',
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            // Jika validasi gagal, kembalikan pesan error
            return redirect()->to(base_url('penerimaan/tambahBaru'))->withInput()->with('errorMessages', $this->validator->getErrors());
        }

        try {
            $tanggalPinjam = new \DateTime($this->request->getPost('tanggal_pinjam'));
            $tanggalKembali = new \DateTime($this->request->getPost('tanggal_kembali'));
        } catch (\Exception $e) {
            // Tanggal tidak valid, tampilkan pesan kesalahan
            return redirect()->to(base_url('penerimaan/tambahBaru'))->withInput()->with('errorMessages', 'Format tanggal tidak valid.');
        }

        // Hitung lama_pinjam dalam satuan hari
        $lamaPinjam = $tanggalPinjam->diff($tanggalKembali)->days;

        // Jika tanggal_pinjam dan tanggal_kembali sama, atur lama_pinjam menjadi 1 hari
        if ($tanggalPinjam == $tanggalKembali) {
            $lamaPinjam = 1;
        }

        // Ambil ID terakhir dari tabel
        $lastId = $this->pihakluarpeminjamanModel->selectMax('id')->get()->getRow()->id;

        // Set ID baru dengan menambahkan 1
        $newId = $lastId + 1;

        // Ambil data dari formulir
        $dataPeminjaman = [
            'kode_pinjam' => $this->request->getPost('kode_pinjam'),
            'nama_peminjam' => $this->request->getPost('nama_peminjam'),
            'nama_instansi' => $this->request->getPost('nama_instansi'),
            'alamat_instansi' => $this->request->getPost('alamat_instansi'),
            'no_telp' => $this->request->getPost('no_telp'),
            'email' => $this->request->getPost('email'),
            'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'),
            'tanggal_kembali' => $tanggalKembali->format('Y-m-d'),
            'lama_pinjam' => $lamaPinjam,
        ];

        // Masukkan ID baru ke dalam data peminjaman
        $dataPeminjaman['no_invoice'] = 'INV-' . date('YmdHis') . '-' . $newId;

        // Simpan data peminjaman
        $peminjamanId = $this->pihakluarpeminjamanModel->insert($dataPeminjaman);


        $this->pihakluarpeminjamanModel->updateIdAngka();

        // Ambil data barang yang dipilih
        $barangIds = $this->request->getPost('barang');

        // Simpan relasi peminjaman dan barang
        foreach ($barangIds as $barangId) {
            // Hitung lama_pinjam untuk setiap barang (mungkin lama_pinjam berbeda-beda untuk setiap barang)
            // Anda bisa menghitung lama_pinjam berdasarkan kebutuhan bisnis Anda
            $dataPeminjamanBarang = [
                'peminjaman_id' => $peminjamanId,
                'barang_id' => $barangId,
                'lama_pinjam' => $lamaPinjam, // Atau Anda dapat menghitung lama_pinjam yang berbeda untuk setiap barang
            ];
            $this->pihakluardetailModel->insert($dataPeminjamanBarang);
            // Update status_barang menjadi 1 pada tbl_barang
            $this->barangModel->update($barangId, ['status_barang' => 1]);
        }

        // Redirect ke halaman invoice dengan nomor peminjaman_id
        return redirect()->to(base_url("pihakluar/invoice/{$peminjamanId}"))->with('success', 'Peminjaman berhasil!');
    }

    public function invoice($peminjaman_id)
    {
        $pihakluarDetailModel = new PihakluarDetailModel();
        $completeData = $pihakluarDetailModel->getCompleteData();


        $pihakluarDetailModel = new PihakluarDetailModel();
        $groupedData = $pihakluarDetailModel->getGroupedData($peminjaman_id);

        $barangModel = new BarangModel();
        $barangByStatus = $barangModel->getBarangDisewakan();
        $currentYear = date('Y');

        $data = [
            'currentYear' => $currentYear,
            'data_barang' => $barangByStatus,
            'data_pinjamLuar' => $groupedData,
        ];

        return view('pihak-luar/invoice', $data);
    }

    public function cetakInvoice($peminjaman_id)
    {
        $pihakluarDetailModel = new PihakluarDetailModel();
        $completeData = $pihakluarDetailModel->getCompleteData();


        $riwayatpihakluarModel = new RiwayatpihakluarModel();
        $groupedData = $riwayatpihakluarModel->getGroupedData($peminjaman_id);

        $barangModel = new BarangModel();
        $barangByStatus = $barangModel->getBarangDisewakan();
        $currentYear = date('Y');

        $data = [
            'currentYear' => $currentYear,
            'data_barang' => $barangByStatus,
            'data_pinjamLuar' => $groupedData,
        ];

        return view('pihak-luar/cetak_invoice', $data);
    }

    public function daftarpinjamLuar()
    {
        $pihakluarDetailModel = new PihakluarDetailModel();
        $completeData = $pihakluarDetailModel->getCompleteData();


        $barangModel = new BarangModel();
        $barangByStatus = $barangModel->getBarangDisewakan();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $data = [
            'judul' => "Data Pinjam Pihak Luar | $namaKampus",
            'currentYear' => $currentYear,
            'data_barang' => $barangByStatus,
            'data_pinjamLuar' => $completeData,
        ];

        return view('pihak-luar/pinjam_luar_daftar', $data);
    }

    public function kembalikan($peminjamanId)
    {
        // Membuat instance model
        $pihakluardetailModel = new \App\Models\PihakluarDetailModel();

        // Melakukan pengecekan apakah peminjaman dengan ID tersebut ada dalam database
        $data_peminjaman = $pihakluardetailModel->where('peminjaman_id', $peminjamanId)->findAll();

        if ($data_peminjaman) {
            // Jika peminjaman ditemukan, panggil fungsi hapusByPeminjamanId untuk menghapus data terkait
            $pihakluardetailModel->ProsesKembali($peminjamanId);

            // Set pesan flash data untuk sukses
            session()->setFlashData('pesanHapusPeminjaman', 'Data Peminjaman berhasil dihapus.');

            // Redirect kembali ke halaman /pinjam/daftar setelah penghapusan
            return redirect()->to('/pinjam/pihakluar');
        } else {
            // Jika peminjaman tidak ditemukan, set pesan flash data untuk kesalahan
            session()->setFlashData('error', 'Data peminjaman tidak ditemukan.');

            // Redirect kembali ke halaman /pinjam/daftar setelah penghapusan (opsional)
            return redirect()->to('/pinjam/daftar');
        }
    }

    public function hapus($peminjamanId)
    {
        // Buat instance dari model TblPeminjamanBarangModel
        $peminjamanModel = new PihakluarDetailModel();

        // Panggil fungsi hapus pada model untuk menghapus data
        $peminjamanModel->hapus($peminjamanId);

        // Redirect atau tampilkan pesan sukses atau sesuai kebutuhan Anda
        return redirect()->to('/pinjam/daftar')->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function riwayatpinjamLuar()
    {
        $riwayatpihakluarModel = new RiwayatpihakluarModel();
        $completeData = $riwayatpihakluarModel->getCompleteData();


        $barangModel = new BarangModel();
        $barangByStatus = $barangModel->getBarangDisewakan();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $data = [
            'judul' => "Riwayat Peminjaman Pihak Luar | $namaKampus",
            'currentYear' => $currentYear,
            'data_barang' => $barangByStatus,
            'data_pinjamLuar' => $completeData,
        ];

        return view('pihak-luar/riwayat_pinjam_luar_daftar', $data);
    }

    public function hapusRiwayat($peminjamanId)
    {
        // Buat instance dari model TblPeminjamanBarangModel
        $riwayatpihakluarModel = new RiwayatpihakluarModel();

        // Panggil fungsi hapus pada model untuk menghapus data
        $riwayatpihakluarModel->hapus($peminjamanId);

        // Redirect atau tampilkan pesan sukses atau sesuai kebutuhan Anda
        return redirect()->to('/pinjam/pihakluar/riwayat')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
