<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

use App\Models\PenerimaanModel;
use App\Models\PenerimaanPersediaanModel;
use App\Models\SatuanModel;
use App\Models\BarangPersediaanModel;
use App\Models\DosenTendikModel;
use App\Models\PeminjamanbarangModel;
use App\Models\PengeluaranModel;
use App\Models\PengeluaranmurniModel;
use App\Models\PengeluaranmurniDetailModel;
use App\Models\MahasiswaModel;
use App\Models\PengaturanModel;
use App\Models\StokBulananModel;





class PengeluaranMurni extends BaseController
{
    protected $penerimaanModel;
    protected $penerimaanpersediaanModel;
    protected $satuanModel;
    protected $barangpersediaanModel;
    protected $dosentendikModel;
    protected $peminjamanbarangModel;
    protected $pengeluaranModel;
    protected $pengeluaranmurniModel;
    protected $pengeluaranmurnidetailModel;
    protected $mahasiswaModel;
    protected $pengaturanModel;
    protected $settingsService;
    protected $stokBulananModel;

    public function __construct()
    {
        $this->penerimaanModel = new PenerimaanModel();
        $this->penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $this->satuanModel = new SatuanModel();
        $this->barangpersediaanModel = new BarangPersediaanModel();
        $this->dosentendikModel = new DosenTendikModel();
        $this->peminjamanbarangModel = new PeminjamanbarangModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->pengeluaranmurniModel = new PengeluaranmurniModel();
        $this->pengeluaranmurnidetailModel = new PengeluaranmurniDetailModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->stokBulananModel = new StokBulananModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }




    public function daftarPengeluaranMurni()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $dataBarang = $penerimaanpersediaanModel->tampilkanData();

        $pengeluaranModel = new PengeluaranModel();
        $dataPengeluaran = $pengeluaranModel->getAllPengeluaran();
        $mahasiswaModel = new MahasiswaModel();
        $dataMahasiswa = $mahasiswaModel->getMahasiswa();
        $dosentendikModel = new DosenTendikModel();
        $dataDosenTendik = $dosentendikModel->getDosenTendik();
        $pengeluaranmurniModel = new PengeluaranmurniModel();
        $pengeluaranMurni = $pengeluaranmurniModel->getPengeluaranMurni();




        $data = [
            'judul' => "Pengeluaran Persediaan | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,
            'data_peminjaman' => $dataBarang,
            'data_pengeluaran' => $dataPengeluaran,
            'data_mahasiswa' => $dataMahasiswa,
            'data_dosen_tendik' => $dataDosenTendik,
            'data_pengeluaran_murni' => $pengeluaranMurni,
        ];

        return view('pengeluaran/daftar_pengeluaran_murni', $data);
    }

    public function simpanPermintaan()
    {
        $session = session();

        // Mendapatkan data dari session
        $userId = $session->get('id');

        // Mendapatkan data dari form
        $nama_pengguna = $this->request->getPost('nama_pengguna_barang');
        $tanggal_penggunaan = $this->request->getPost('tanggal_penggunaan');
        $keperluan = $this->request->getPost('keperluan');

        // Validasi data input
        $validation = [
            'nama_pengguna_barang' => 'required',
            'keperluan' => 'required',
        ];

        if (!$this->validate([
            'nama_pengguna_barang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama pengguna harus diisi',
                ]
            ],
            'keperluan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keperluan harus diisi',
                ]
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Proses input penerimaan
        try {
            $tanggalPenggunaan = new \DateTime($this->request->getPost('tanggal_penggunaan'));
        } catch (\Exception $e) {
            // Tanggal tidak valid, tampilkan pesan kesalahan
            return redirect()->to(base_url('penerimaan/tambahBaru'))->withInput()->with('errorMessages', 'Format tanggal tidak valid.');
        }
        // Menyiapkan data untuk disimpan
        $data = [
            'nama_pengguna_barang' => $nama_pengguna,
            'tanggal_penggunaan' => $tanggalPenggunaan->format('Y-m-d'), // Sesuaikan format yang sesuai dengan basis data
            'keperluan' => $keperluan,
            'user_id' => $userId, // Menambahkan user_id ke dalam data
        ];

        $pengeluaranmurniModel = new PengeluaranmurniModel();
        // Menyimpan data ke dalam database
        $pengeluaranmurniModel->insertPengeluaranMurni($data);

        return redirect()->to('/pengeluaran/bhp');
    }


    public function addPengeluaranTanpaPeminjaman($id)
    {
        session();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $satuanModel = new SatuanModel();
        $dataSatuan = $satuanModel->getSatuan();

        $pengeluaranmurniModel = new PengeluaranmurniModel();
        $dataPengeluaranMurni = $pengeluaranmurniModel->getdetail($id);

        $penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $dataBarang = $penerimaanpersediaanModel->tampilkanData();

        $mahasiswaModel = new MahasiswaModel();
        $dataMahasiswa = $mahasiswaModel->getMahasiswa();
        $dosentendikModel = new DosenTendikModel();
        $dataDosenTendik = $dosentendikModel->getDosenTendik();

        $userLevel = session('level');
        $pengeluaranmurnidetailModel = new PengeluaranmurniDetailModel();
        $detailPengeluaranMurni = $pengeluaranmurnidetailModel->getDetailWithNamaBarang($id);

        $dataBarangTerpilih = [];
        foreach ($detailPengeluaranMurni as $detail) {
            $dataBarangTerpilih[] = [
                'id' => $detail->id,
                'barang_id' => $detail->barang_id,
                'nama_barang' => $detail->nama_barang,
                'jumlah_barang' => $detail->ambil_barang_murni,
            ];
        }

        // Mendapatkan bulan dan tahun dari tanggal_penggunaan
        $tanggalPenggunaan = $dataPengeluaranMurni['tanggal_penggunaan'];
        $timestamp = strtotime($tanggalPenggunaan);
        $bulan = date('m', $timestamp);
        $tahun = date('Y', $timestamp);

        // Mengambil data dari StokBulananModel berdasarkan bulan dan tahun
        $stokBulananModel = new StokBulananModel();
        $dataStokBulanan = $stokBulananModel->tampilkanDataStokBulanan($bulan, $tahun);

        $data = [
            'judul' => "Tambah Pengeluaran Tanpa Peminjaman | $namaKampus",
            'currentYear' => $currentYear,
            'data_satuan' => $dataSatuan,
            'barang_persediaan' => $dataStokBulanan,
            'data_mahasiswa' => $dataMahasiswa,
            'data_dosen_tendik' => $dataDosenTendik,
            'data_pengeluaran_murni' => $dataPengeluaranMurni,
            'detail_pengeluaran_murni' => $detailPengeluaranMurni,
            'data_barang_terpilih' => $dataBarangTerpilih,
            'id' => $id,
        ];

        // Pemeriksaan waktu created_at hanya untuk level 'user'
        if ($userLevel == 'User') {
            $waktuPembuatan = strtotime($dataPengeluaranMurni['created_at']);
            $waktuSekarang = time();
            $selisihWaktu = $waktuSekarang - $waktuPembuatan;

            if ($selisihWaktu > (24 * 60 * 60)) {
                session()->setFlashData('custom_error_message', 'Maaf, Anda tidak dapat mengakses halaman ini karena sudah melebihi 24 jam.');
                return redirect()->to(base_url('pengeluaran/bhp'));
            }
        }

        return view('pengeluaran/minta_barang', $data);
    }



    public function getDataByPenggunaId($penggunaId)
    {
        $data = $this->pengeluaranmurnidetailModel->getDataByPenggunaId($penggunaId);

        // You may need to adjust this based on the actual structure of your data
        $data = json_encode($data);

        return $data;
    }

    public function ProsesTambahPengeluaranMurni()
    {
        // Validasi data input
        $validationRules = [
            'ambil_barang_murni.*' => 'required|greater_than[0]',
        ];

        $validationMessages = [
            'ambil_barang_murni.*' => [
                'required' => 'Isikan jumlah barang yang diambil.',
                'greater_than' => 'Nilai harus lebih dari 0.',
            ],
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $pengeluaranmurnidetailModel = new PengeluaranmurniDetailModel();

        // Mendapatkan data dari formulir
        // Proses penyimpanan data ke database

        $penggunaId = $this->request->getPost('id');
        $barangIds = $this->request->getPost('barang_id');
        $hargaSatuan = $this->request->getPost('harga_satuan');
        $ambilBarang = $this->request->getPost('ambil_barang_murni');
        $jumlahHarga = $this->request->getPost('jumlah_harga');

        // Array untuk menyimpan data yang valid
        $newData = [];

        // Loop untuk menyimpan setiap barang ke database
        for ($i = 0; $i < count($barangIds); $i++) {
            $data = [
                'pengguna_id' => $penggunaId,
                'barang_id' => $barangIds[$i],
                'harga_satuan' => $hargaSatuan[$i],
                'ambil_barang_murni' => $ambilBarang[$i],
                'jumlah_harga' => $jumlahHarga[$i],
            ];

            // Ambil data nama_barang dari model PersediaanBarangModel
            $persediaanModel = new BarangPersediaanModel();
            $namaBarang = $persediaanModel->getNamaBarangById($barangIds[$i]);

            // Tambahkan data nama_barang ke dalam array
            $data['nama_barang'] = $namaBarang['nama_barang'];

            // Simpan data ke database
            $insertId = $this->pengeluaranmurnidetailModel->insertPengeluaranmurniDetail($data);

            // Ambil id yang baru saja di-generate oleh database
            $data['id'] = $insertId;

            // Update stok barang
            $this->pengeluaranModel->updateStok($barangIds[$i], $ambilBarang[$i]);

            // Tambahkan data baru ke dalam array
            $newData[] = $data;
        }

        // Kembalikan respons berupa data baru dalam format JSON
        return $this->response->setJSON($newData);
    }






    public function hapusPengeluaranMurni($id)
    {
        $pengeluaranmurniModel = new PengeluaranmurniModel();
        $result = $pengeluaranmurniModel->hapus($id);

        if ($result) {
            // Data berhasil dihapus
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil dihapus.',
            ];
        } else {
            // Terjadi kesalahan saat menghapus data
            $response = [
                'status' => 'error',
                'message' => 'Gagal menghapus data. Harap Hapus Data Barang terlebih dahulu.',
            ];
        }

        // Kirim respons JSON ke frontend
        return $this->response->setJSON($response);
    }


    public function hapusDataBarangMurni($id)
    { {
            $dataHapus = $this->pengeluaranmurnidetailModel->find($id);

            if (empty($dataHapus)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
            }

            $ambilBarang = $dataHapus['ambil_barang_murni'];

            if ($this->pengeluaranmurnidetailModel->delete($id)) {
                // Kembalikan stok barang
                $barangModel = new BarangPersediaanModel();

                // Ambil stok sekarang
                $stokSekarang = $barangModel->getStokByBarangId($dataHapus['barang_id']);

                // Hitung stok setelah dikembalikan
                $stokBaru = $stokSekarang + $ambilBarang;




                // Update stok menggunakan metode update
                $barangModel->updateStok($dataHapus['barang_id'], ['stok' => $stokBaru]);

                return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menghapus data']);
            }
        }
    }


    public function get_detail($penggunaId)
    {
        $pengeluaranmurnidetailModel = new PengeluaranmurniDetailModel();

        // Get details of the penerimaan
        $data['detail'] = $pengeluaranmurnidetailModel->getDataDetailPermintaanByPenggunaId($penggunaId);

        // Calculate total_harga
        $totalHarga = 0;
        foreach ($data['detail'] as $item) {
            $totalHarga += $item->jumlah_harga; // Ubah menjadi objek dari array
        }

        // Add total_harga to data
        $data['total_harga'] = $totalHarga;

        // Return JSON response
        return $this->response->setJSON($data);
    }

    public function cetakPengeluaranMurni($penggunaId)
    {
        $pengeluaranmurnidetailModel = new PengeluaranmurniDetailModel();
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);

        // Get peminjaman barang data by peminjaman_id
        $peminjamanBarangDetails = $pengeluaranmurnidetailModel->getDataDetailPermintaanByPenggunaId($penggunaId);

        $data = [
            'peminjamanBarangDetails' => $peminjamanBarangDetails,
            'dataPengaturan' => $dataPengaturan,
        ];


        return view('cetak/cetak_permintaan_barang', $data);
    }
}
