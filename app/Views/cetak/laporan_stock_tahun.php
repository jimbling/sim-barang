<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Opname Bulan_<?= $tahun ?>
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
        <img src="../../assets/dist/img/kop-yky.png" width="400px">
    </div>
    <div class="container-fluid">

        <h2>
            <center><b>L A P O R A N

        </h2>
        <h2>
            <center><b> STOCK OPNAME BARANG HABIS PAKAI LABORATORIUM KEPERAWATAN
                    <P>Tahun: <?= $tahun ?>
                </b></CENTER>
        </h2>

        <div class="gradient-line"></div>
        <br>

        <div class="table-container page-break-before">
            <table class="table table-border">
                <thead class="thead">
                    <tr>
                        <th>No.</th>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah Barang</th>
                    </tr>
                </thead>
                <tbody class="table-border">
                    <?php if (empty($stockDataTahun)) : ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Tidak Ada Data Stock Opname Barang Habis Pakai Laboratorium Keperawatan pada <strong>Tahun: <?= $tahun ?> </strong></td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1;
                        $totalStok = 0; ?>
                        <?php foreach ($stockDataTahun as $data) : ?>
                            <tr>
                                <th><?= $i++; ?></th>
                                <td><?= $data['barang_id']; ?></td>
                                <td style="text-align: left;"><?= $data['nama_barang']; ?></td>
                                <td style="text-align: right;">Rp. <?= number_format($data['harga_satuan'], 0, ',', '.'); ?></td>
                                <td><?= $data['stok_barang']; ?></td>

                            </tr>
                            <?php $totalStok += $data['stok_barang']; ?>
                        <?php endforeach; ?>
                        <tr>
                            <th colspan="4" style="text-align: right;"><strong>TOTAL STOK</strong></th>
                            <td><strong><?= $totalStok; ?></strong></td>
                        </tr>
                    <?php endif; ?>
                </tbody>

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