<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Daftar Mutasi Barang Persediaan_Bulan_<?= $namaBulan ?>_Tahun_<?= $tahun ?>
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
                    <P> Bulan: <?= $namaBulan ?> Tahun: <?= $tahun ?>
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
                        <th style="font-size: 14px;">Saldo Awal</th>
                        <th style="font-size: 14px;">Jumlah Penerimaan</th>
                        <th style="font-size: 14px;">Pengeluaran Dengan Peminjaman</th>
                        <th style="font-size: 14px;">Pengeluaran Tanpa Peminjaman</th>
                        <th style="font-size: 14px;">Sisa Stok</th>
                        <th style="font-size: 14px;">Satuan</th>
                    </tr>

                </thead>
                <tbody>
                    <tr>
                        <th style="font-size: 10px; font-style: italic;">#</th>
                        <th style="font-size: 10px; font-style: italic;">1</th>
                        <th style="font-size: 10px; font-style: italic;">2</th>
                        <th style="font-size: 10px; font-style: italic;">3</th>
                        <th style="font-size: 10px; font-style: italic;">4</th>
                        <th style="font-size: 10px; font-style: italic;">5</th>
                        <th style="font-size: 10px; font-style: italic;">6</th>
                        <th style="font-size: 10px; font-style: italic;">(3+4)-(5+6)</th>
                        <th style="font-size: 10px; font-style: italic;"></th>
                    </tr>
                    <?php foreach ($barangList as $index => $barang) : ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td style="text-align: left;"><?= $barang['nama_barang']; ?></td>
                            <td style="text-align: right;">Rp. <?= number_format($barang['harga_satuan'], 0, ',', '.'); ?></td>
                            <td><?= $barang['jumlah_saldo_awal']; ?></td>
                            <td><?= $barang['jumlah_penerimaan']; ?></td>
                            <td width="15%"><?= $barang['jumlah_pengeluaran']; ?></td>
                            <td width="15%"><?= $barang['jumlah_pengeluaran_murni']; ?></td>
                            <td><?= $barang['sisa_stok']; ?></td>
                            <td><?= $barang['satuan']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong><?= $totalSaldoAwal; ?></strong></td>
                        <td><strong><?= $totalJumlahPenerimaan; ?></strong></td>
                        <td><strong><?= $totalJumlahPengeluaran; ?></strong></td>
                        <td><strong><?= $totalJumlahPengeluaranMurni; ?></strong></td>
                        <td><strong><?= $totalSisaStok; ?></strong></td>
                        <td><strong></strong></td>

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