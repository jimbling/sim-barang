<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

use App\Models\PenerimaanModel;
use App\Models\PenerimaanPersediaanModel;
use App\Models\SatuanModel;
use App\Models\BarangPersediaanModel;
use App\Models\DosenTendikModel;





class Penerimaan extends BaseController
{
    protected $penerimaanModel;
    protected $penerimaanpersediaanModel;
    protected $satuanModel;
    protected $barangpersediaanModel;
    protected $dosentendikModel;
    protected $settingsService;

    public function __construct()
    {
        $this->penerimaanModel = new PenerimaanModel();
        $this->penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $this->satuanModel = new SatuanModel();
        $this->barangpersediaanModel = new BarangPersediaanModel();
        $this->dosentendikModel = new DosenTendikModel();
        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }

    public function daftarPenerimaan()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $penerimaanpersediaanModel = new PenerimaanPersediaanModel();
        $dataPenerimaan = $penerimaanpersediaanModel->getPenerimaanPersediaan();
        $dataBarang = $penerimaanpersediaanModel->tampilkanData();

        $satuanModel = new SatuanModel();
        $dataSatuan = $satuanModel->getSatuan();
        // Mendapatkan daftar barang yang dikelompokkan berdasarkan nama_barang


        $data = [
            'judul' => "Penerimaan Persediaan | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_penerimaan' => $dataPenerimaan,
            'data_satuan' =>  $dataSatuan,
            'data_barang' =>  $dataBarang,

        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('penerimaan/daftar_penerimaan', $data);
    }

    public function addPenerimaan()
    {

        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $satuanModel = new SatuanModel();
        $dataSatuan = $satuanModel->getSatuan();

        $barangpersediaanModel = new BarangPersediaanModel();
        $dataBarang = $barangpersediaanModel->getBarangPersediaan();

        $dosentendikModel = new DosenTendikModel();
        $dataDosenTendik = $dosentendikModel->getDosenTendik();

        // Menyiapkan data untuk disimpan
        $data = [
            'judul' => "Barang Persediaan | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data
            'data_satuan' =>  $dataSatuan,
            'barang_persediaan' => $dataBarang,
            'dosen_tendik' => $dataDosenTendik,

        ];

        return view('penerimaan/tambah_penerimaan', $data);
    }

    public function ProsesTambahPenerimaan()
    {
        session();
        $penerimaanModel = new PenerimaanModel();
        $persediaanDetailModel = new PenerimaanPersediaanModel();

        // Proses input penerimaan
        try {
            $tanggalPenerimaan = new \DateTime($this->request->getPost('tanggal_penerimaan'));
        } catch (\Exception $e) {
            // Tanggal tidak valid, tampilkan pesan kesalahan
            return redirect()->to(base_url('penerimaan/tambahBaru'))->withInput()->with('errorMessages', 'Format tanggal tidak valid.');
        }

        // Ambil nilai jenis_perolehan
        $jenisPerolehan = $this->request->getPost('jenis_perolehan');

        // Jika jenis_perolehan adalah "Pembelian", tambahkan detail_pembelian
        if ($jenisPerolehan === 'Pembelian') {
            $detailPembelian = $this->request->getPost('detail_pembelian');
            $jenisPerolehan .= ' - ' . $detailPembelian;
        }

        $penerimaanData = [
            'tanggal_penerimaan' => $tanggalPenerimaan->format('Y-m-d H:i:s'), // Sesuaikan format yang sesuai dengan basis data
            'jenis_perolehan' => $jenisPerolehan,
            'petugas' => $this->request->getPost('petugas'),
        ];

        $penerimaanId = $penerimaanModel->insertPenerimaan($penerimaanData);

        // Proses input penerimaan persediaan detail
        $barangIds = $this->request->getPost('barang_id');
        $jumlahBarangs = $this->request->getPost('jumlah_barang');
        $hargaSatuans = $this->request->getPost('harga_satuan');
        $jumlahHargas = $this->request->getPost('jumlah_harga');

        $failedBarangs = []; // Initialize an array to store failed barang names

        foreach ($barangIds as $key => $barangId) {
            // Cek apakah harga_satuan lama ada
            $barangPersediaanModel = new BarangPersediaanModel();
            $hargaSatuanLama = $barangPersediaanModel->getHargaSatuan($barangId);

            // Jika harga_satuan lama tidak ada atau sama dengan harga_satuan baru atau harga_satuan lama sama dengan 0, proses penyimpanan
            if (!$hargaSatuanLama || $hargaSatuans[$key] == 0 || $hargaSatuans[$key] == $hargaSatuanLama) {
                $persediaanDetailData = [
                    'penerimaan_id' => $penerimaanId,
                    'barang_id' => $barangId,
                    'jumlah_barang' => $jumlahBarangs[$key],
                    'harga_satuan' => $hargaSatuans[$key],
                    'jumlah_harga' => $jumlahHargas[$key],
                    // tambahkan field lainnya sesuai kebutuhan
                ];

                $persediaanDetailModel->insertPenerimaanPersed($persediaanDetailData);
                // Update stok di tbl_persediaan_barang
                $persediaanDetailModel->updateStokBarang($persediaanDetailData['barang_id'], $persediaanDetailData['jumlah_barang']);
                // Tambahkan nilai harga_satuan ke dalam tabel tbl_persediaan_barang
                $barangPersediaanModel->tambahHargaSatuan($barangId, $hargaSatuans[$key]);
            } else {
                // Fetch the name of the barang for the error message
                $namaBarang = $barangPersediaanModel->getNamaBarang($barangId);

                // Collect the failed barang names in the array
                $failedBarangs[] = $namaBarang;
            }
        }

        // Check if there are failed barang names and construct the error message accordingly
        if (!empty($failedBarangs)) {
            $errorMessage = 'Harga satuan untuk barang : ' . implode(', ', $failedBarangs) . ' sudah ada, namun berbeda. Silahkan tambahkan data barang baru dengan nama yang sama. Pada pilihan akan ditandai dengan (Barang Baru).';
            return redirect()->to(base_url('penerimaan/tambahBaru'))->withInput()->with('errorMessages', $errorMessage);
        }

        // Redirect ke halaman daftar penerimaan
        session()->setFlashData('pesanAddBarangSatuan', 'Kategori berhasil diubah');
        return redirect()->to('/penerimaan/daftar')->with('success', 'Data siswa berhasil diubah.');
    }








    public function get_detail($penerimaan_id)
    {
        $penerimaanpersediaanModel = new PenerimaanPersediaanModel();

        // Get details of the penerimaan
        $data['detail'] = $penerimaanpersediaanModel->getDetailPenerimaanById($penerimaan_id);

        // Calculate total_harga
        $totalHarga = 0;
        foreach ($data['detail'] as $item) {
            $totalHarga += $item['jumlah_harga'];
        }

        // Add total_harga to data
        $data['total_harga'] = $totalHarga;

        // Return JSON response
        return $this->response->setJSON($data);
    }



    public function hapusPenerimaan($penerimaanId)
    {
        $penerimaanModel = new PenerimaanPersediaanModel();
        $penerimaanModel->hapusByPenerimaanId($penerimaanId);

        // Tambahkan logika atau tindakan lain yang sesuai dengan kebutuhan Anda
    }
}
