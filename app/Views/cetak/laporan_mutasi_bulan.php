<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Mutasi Barang Persediaan Bulan_<?= $namaBulan ?>_<?= $tahun ?>
    </title>
    <link href="../../assets/dist/css/cetak-laporan-stok.css" rel="stylesheet" type="text/css">
    <script>
        // Jalankan pencetakan saat halaman dimuat
        window.onload = function() {
            window.print();
        };
    </script>

</head>
<style>
    @media print {

        /* Pengaturan agar konten tidak terpotong ke halaman berikutnya */
        .page-break {
            page-break-inside: avoid;
        }

        /* Pengaturan agar elemen ini dimulai di halaman baru */
        .page-break-before {
            page-break-before: always;
        }
    }
</style>

<body>
    <div class="col-sm-10">
        <img src="../../assets/dist/img/<?php echo $dataPengaturan['kop_surat'] ?>" width="450px">
    </div>
    <div class="container-fluid">

        <h2>
            <center><b>L A P O R A N

        </h2>
        <h2>
            <center><b> REKAP MUTASI BARANG HABIS PAKAI LABORATORIUM KEPERAWATAN
                    <P>Bulan : <?= $namaBulan ?> Tahun: <?= $tahun ?>
                </b></CENTER>
        </h2>

        <div class="gradient-line"></div>
        <br>

        <div class="table-container page-break-before">
            <table class="table table-border">
                <thead class="thead">
                    <tr>
                        <th style="font-size: 14px;">#</th>
                        <th style="font-size: 14px;">Nama Barang</th>
                        <th style="font-size: 14px;">Harga Satuan</th>
                        <th style="font-size: 14px;">Jumlah Penerimaan</th>
                        <th style="font-size: 14px;">Pengeluaran Dengan Peminjaman</th>
                        <th style="font-size: 14px;">Pengeluaran Tanpa Peminjaman</th>
                        <th style="font-size: 14px;">Sisa Stok</th>
                    </tr>

                </thead>
                <tbody>
                    <tr>
                        <th style="font-size: 10px; font-style: italic;">1</th>
                        <th style="font-size: 10px; font-style: italic;">2</th>
                        <th style="font-size: 10px; font-style: italic;">3</th>
                        <th style="font-size: 10px; font-style: italic;">4</th>
                        <th style="font-size: 10px; font-style: italic;">5</th>
                        <th style="font-size: 10px; font-style: italic;">6</th>
                        <th style="font-size: 10px; font-style: italic;">4-(5+6)</th>
                    </tr>
                    <?php
                    // Menentukan jumlah barang yang unik
                    $uniqueBarangIds = array_unique(array_merge(array_column($data_penerimaan, 'barang_id'), array_column($data_pengeluaran, 'barang_id'), array_column($data_pengeluaran_murni, 'barang_id')));
                    $count = count($uniqueBarangIds);

                    // Variabel untuk menyimpan total masing-masing kolom
                    $totalJumlahPenerimaan = 0;
                    $totalJumlahPengeluaran = 0;
                    $totalJumlahPengeluaranMurni = 0;
                    $totalSisaStok = 0;
                    ?>

                    <?php for ($i = 0; $i < $count; $i++) : ?>
                        <?php
                        $barangId = $uniqueBarangIds[$i];
                        $penerimaanIndex = array_search($barangId, array_column($data_penerimaan, 'barang_id'));
                        $pengeluaranIndex = array_search($barangId, array_column($data_pengeluaran, 'barang_id'));
                        $pengeluaranMurniIndex = array_search($barangId, array_column($data_pengeluaran_murni, 'barang_id'));

                        $jumlahPenerimaan = $penerimaanIndex !== false ? $data_penerimaan[$penerimaanIndex]['jumlah_barang'] : 0;
                        $jumlahPengeluaran = $pengeluaranIndex !== false ? $data_pengeluaran[$pengeluaranIndex]['ambil_barang'] : 0;
                        $jumlahPengeluaranMurni = $pengeluaranMurniIndex !== false ? $data_pengeluaran_murni[$pengeluaranMurniIndex]['ambil_barang_murni'] : 0;
                        $sisaStok = $jumlahPenerimaan - ($jumlahPengeluaran + $jumlahPengeluaranMurni);

                        // Menambahkan nilai ke total
                        $totalJumlahPenerimaan += $jumlahPenerimaan;
                        $totalJumlahPengeluaran += $jumlahPengeluaran;
                        $totalJumlahPengeluaranMurni += $jumlahPengeluaranMurni;
                        $totalSisaStok += $sisaStok;
                        ?>

                        <tr>
                            <td><?= $i + 1; ?></td>
                            <!-- Menampilkan Nama Barang -->
                            <td style="text-align: left;"><?= $penerimaanIndex !== false ? $data_penerimaan[$penerimaanIndex]['nama_barang'] : ($pengeluaranIndex !== false ? $data_pengeluaran[$pengeluaranIndex]['nama_barang'] : ''); ?></td>
                            <td style="text-align: right;">
                                <?php
                                $harga_satuan = $penerimaanIndex !== false ? $data_penerimaan[$penerimaanIndex]['harga_satuan'] : ($pengeluaranIndex !== false ? $data_pengeluaran[$pengeluaranIndex]['harga_satuan'] : '');
                                echo 'Rp. ' . number_format($harga_satuan, 0, ',', '.');
                                ?>
                            </td>
                            <!-- Kolom untuk Jumlah Penerimaan -->
                            <td><?= $jumlahPenerimaan; ?></td>
                            <!-- Kolom untuk Jumlah Pengeluaran -->
                            <td width="15%"><?= $jumlahPengeluaran; ?></td>
                            <!-- Kolom untuk Jumlah Pengeluaran Murni -->
                            <td width="15%"><?= $jumlahPengeluaranMurni; ?></td>
                            <!-- Kolom untuk Sisa Stok -->
                            <td><?= $sisaStok; ?></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong><?= $totalJumlahPenerimaan; ?></strong></td>
                        <td><strong><?= $totalJumlahPengeluaran; ?></strong></td>
                        <td><strong><?= $totalJumlahPengeluaranMurni; ?></strong></td>
                        <td><strong><?= $totalSisaStok; ?></strong></td>
                    </tr>
                </tfoot>
            </table>

        </div>




        <div class="container page-break">
            <table class="table table-no-border text-center">
                <thead>
                    <tr>
                        <th style="width: 50%;">

                            <p><?php echo $dataPengaturan['ttd_3'] ?></p>
                            <br></br>

                            <p class="underlined-text"><b> <?php echo $dataPengaturan['nama_ttd_3'] ?></b></p>
                            <p>NIK. <?php echo $dataPengaturan['id_ttd_3'] ?>
                        </th>
                        <th style="width: 50%;">
                            <p><?php echo $dataPengaturan['ttd_2'] ?>
                                <br></br>

                            <p class="underlined-text"><b> <?php echo $dataPengaturan['nama_laboran'] ?></b></p>
                            <p>NIK. <?php echo $dataPengaturan['nik_laboran'] ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Isi tabel sesuai kebutuhan -->
                </tbody>
            </table>
        </div>


        <div class="container">
            <table class="table table-no-border text-center">
                <thead>
                    <tr>
                        <th style="width: 100%;">
                            <p>Mengetahui
                            <p><?php echo $dataPengaturan['ttd_4'] ?>
                                <br></br>

                            <p class="underlined-text"><b> <?php echo $dataPengaturan['nama_ttd_4'] ?></b>
                            <p>NIK. <?php echo $dataPengaturan['id_ttd_4'] ?></p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Isi tabel sesuai kebutuhan -->
                </tbody>
            </table>
        </div>





    </div>





</body>

</html>