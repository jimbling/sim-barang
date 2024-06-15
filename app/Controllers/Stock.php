<?php

namespace App\Controllers;

use App\Models\PenerimaanPersediaanModel;
use App\Models\PengeluaranModel;
use App\Models\PengeluaranmurniDetailModel;
use App\Models\StokBulananModel;
use App\Models\PengaturanModel;
use App\Models\PeminjamanbarangModel;
use App\Models\RiwayatPeminjamanModel;

class Stock extends BaseController
{
    protected $penerimaanModel;
    protected $pengeluaranModel;
    protected $pengeluaranMurniDetailModel;
    protected $stokBulananModel;
    protected $pengaturanModel;
    protected $peminjamanbarangModel;
    protected $riwayatPeminjamanModel;

    public function __construct()
    {
        $this->penerimaanModel = new PenerimaanPersediaanModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->pengeluaranMurniDetailModel = new PengeluaranmurniDetailModel();
        $this->stokBulananModel = new StokBulananModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->peminjamanbarangModel = new PeminjamanbarangModel();
        $this->riwayatPeminjamanModel = new RiwayatPeminjamanModel();
    }

    public function getDataStok()
    {

        $currentYear = date('Y');
        $pengaturanModel = new PengaturanModel();
        $dataPengaturan = $pengaturanModel->getDataById(1);
        $peminjamanbarangModel = new PeminjamanbarangModel();
        $barangByStatus = $peminjamanbarangModel->getPeminjamanBarang();

        $penerimaanModel = new PenerimaanPersediaanModel();
        $pengeluaranModel = new PengeluaranModel();
        $riwayatPeminjamanModel = new RiwayatPeminjamanModel();
        $years = $riwayatPeminjamanModel->getUniqueYears();

        $bulan = $this->request->getGet('bulan');
        $year = $this->request->getGet('tahun');
        $stokBulananModel = new StokBulananModel();
        $stockAwal = $stokBulananModel->getDataBulanTahunSebelumnya($bulan, $year);



        // Lanjutkan proses seperti biasa
        $bulanOptions = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $month = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $namaBulan = $bulanOptions[$month];

        // Konversi nama bulan menjadi angka bulan
        $bulanAngka = array_search($namaBulan, $bulanOptions);
        if (!$bulanAngka) {
            $bulanAngka = '01'; // Default jika nama bulan tidak ditemukan
        }

        // Mendapatkan data penerimaan dan pengeluaran
        $penerimaanBarangData = $penerimaanModel->getBarangDataByMonthAndYear($month, $year);
        $pengeluaranBarangData = $pengeluaranModel->getBarangDataByMonthAndYear($month, $year);
        $pengeluaranMurniModel = new PengeluaranmurniDetailModel();
        $pengeluaranMurniData = $pengeluaranMurniModel->getBarangDataByMonthAndYear($month, $year);

        // Menentukan jumlah barang yang unik
        $uniqueBarangIds = array_unique(array_merge(
            array_column($penerimaanBarangData, 'barang_id'),
            array_column($pengeluaranBarangData, 'barang_id'),
            array_column($pengeluaranMurniData, 'barang_id'),
            array_column($stockAwal, 'barang_id') // Tambahkan barang_id dari stok awal
        ));

        $barangList = [];

        foreach ($uniqueBarangIds as $barangId) {
            $barangInfo = [
                'barang_id' => $barangId,
                'nama_barang' => '',
                'harga_satuan' => 0,
                'jumlah_saldo_awal' => 0,
                'jumlah_penerimaan' => 0,
                'jumlah_penerimaan_total' => 0,
                'jumlah_pengeluaran' => 0,
                'jumlah_pengeluaran_murni' => 0,
                'sisa_stok' => 0,
                'satuan' => 'Pcs',
            ];

            // Cari data penerimaan untuk barang ini
            $penerimaanIndex = array_search($barangId, array_column($penerimaanBarangData, 'barang_id'));
            if ($penerimaanIndex !== false) {
                $barangInfo['nama_barang'] = $penerimaanBarangData[$penerimaanIndex]['nama_barang'];
                $barangInfo['harga_satuan'] = $penerimaanBarangData[$penerimaanIndex]['harga_satuan'];
                $barangInfo['jumlah_penerimaan'] = $penerimaanBarangData[$penerimaanIndex]['jumlah_barang'];
            }

            // Cari data pengeluaran untuk barang ini
            $pengeluaranIndex = array_search($barangId, array_column($pengeluaranBarangData, 'barang_id'));
            if ($pengeluaranIndex !== false) {
                $barangInfo['nama_barang'] = $pengeluaranBarangData[$pengeluaranIndex]['nama_barang'];
                $barangInfo['harga_satuan'] = $pengeluaranBarangData[$pengeluaranIndex]['harga_satuan'];
                $barangInfo['jumlah_pengeluaran'] = $pengeluaranBarangData[$pengeluaranIndex]['ambil_barang'];
            }

            // Cari data pengeluaran murni untuk barang ini
            $pengeluaranMurniIndex = array_search($barangId, array_column($pengeluaranMurniData, 'barang_id'));
            if ($pengeluaranMurniIndex !== false) {
                $barangInfo['nama_barang'] = $pengeluaranMurniData[$pengeluaranMurniIndex]['nama_barang'];
                $barangInfo['harga_satuan'] = $pengeluaranMurniData[$pengeluaranMurniIndex]['harga_satuan'];
                $barangInfo['jumlah_pengeluaran_murni'] = $pengeluaranMurniData[$pengeluaranMurniIndex]['ambil_barang_murni'];
            }

            // Cari saldo awal untuk barang ini dari stok awal
            foreach ($stockAwal as $saldo) {
                if ($saldo->barang_id == $barangId) {
                    $barangInfo['jumlah_saldo_awal'] = $saldo->sisa_stok;
                    // Ambil harga_satuan dari stok awal jika belum diisi
                    if ($barangInfo['harga_satuan'] == 0) {
                        $barangInfo['harga_satuan'] = $saldo->harga_satuan;
                    }
                    break;
                }
            }

            // Cari data setok untuk memperbarui nama_barang dan satuan jika ada
            foreach ($stockAwal as $saldo) {
                if ($saldo->barang_id == $barangId) {
                    $barangInfo['nama_barang'] = $saldo->nama_barang;
                    $barangInfo['satuan'] = $saldo->satuan;
                    break;
                }
            }

            // Hitung jumlah penerimaan total (termasuk saldo awal)
            $barangInfo['jumlah_penerimaan_total'] = $barangInfo['jumlah_saldo_awal'] + $barangInfo['jumlah_penerimaan'];

            // Hitung sisa stok
            $barangInfo['sisa_stok'] = $barangInfo['jumlah_penerimaan_total'] - ($barangInfo['jumlah_pengeluaran'] + $barangInfo['jumlah_pengeluaran_murni']);

            // Tambahkan ke daftar barang
            $barangList[] = $barangInfo;
        }

        // Totalkan saldo awal dari semua barang
        $totalJumlahSaldo = array_sum(array_column($barangList, 'jumlah_saldo_awal'));
        $totalJumlahPenerimaan = array_sum(array_column($barangList, 'jumlah_penerimaan'));
        $totalJumlahPengeluaran = array_sum(array_column($barangList, 'jumlah_pengeluaran'));
        $totalJumlahPengeluaranMurni = array_sum(array_column($barangList, 'jumlah_pengeluaran_murni'));
        $totalSisaStok = array_sum(array_column($barangList, 'sisa_stok'));

        // Siapkan data untuk dikirim dalam respon JSON
        $responseData = [
            'currentYear' => $currentYear,
            'barangList' => $barangList,
            'totalJumlahPenerimaan' => $totalJumlahPenerimaan,
            'totalJumlahPengeluaran' => $totalJumlahPengeluaran,
            'totalJumlahPengeluaranMurni' => $totalJumlahPengeluaranMurni,
            'totalSisaStok' => $totalSisaStok,
            'totalSaldoAwal' => $totalJumlahSaldo,
            'years' => $years,
            'namaBulan' => $namaBulan,
            'bulanAngka' => $bulanAngka,
            'tahun' => $year,
            'dataPengaturan' => $dataPengaturan,

        ];

        // Kembalikan data sebagai JSON
        return $this->response->setJSON($responseData);
    }
}
