<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Bulan_<?= $namaBulan ?>_<?= $tahun ?>
    </title>
    <link href="../../assets/dist/css/cetak-laporan.css" rel="stylesheet" type="text/css">
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
            <center><b>REKAPITULASI DATA PEMINJAMAN BARANG LABORATORIUM KEPERAWATAN
                    <P>Bulan : <?= $namaBulan ?> Tahun: <?= $tahun ?>
                </b></CENTER>
        </h2>

        <div class="gradient-line"></div>
        <br>

        <div class="table-container page-break-before">
            <table class="table table-border">
                <thead class="thead">
                    <tr>
                        <th>No.</th>
                        <th>Kode Pinjam</th>
                        <th>Nama Peminjam</th>
                        <th>Dosen Pengampu</th>
                        <th>Ruangan</th>
                        <th>Tanggal Pinjam</th>
                        <th>Keperluan</th>
                        <th>Barang</th>
                    </tr>
                </thead>
                <tbody class="table-border ">
                    <?php if (empty($data_peminjaman)) : ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">Tidak Ada Data Peminjaman Barang Laboratorium Keperawatan pada <strong>Bulan: <?= $namaBulan ?> Tahun: <?= $tahun ?> </strong></td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1; // Deklarasi di luar loop foreach 
                        ?>
                        <?php foreach ($data_peminjaman as $data) : ?>
                            <tr>
                                <th class="text-center" scope="row" style="vertical-align: middle; font-size: 13px;"><?= $i++; ?></th>
                                <td><?= $data['kode_pinjam']; ?></td>
                                <td width="12%"><?= $data['nama_peminjam']; ?></td>
                                <td width="12%"><?= $data['nama_dosen']; ?></td>
                                <td width="12%"><?= $data['nama_ruangan']; ?></td>
                                <td width="12%"> <?php
                                                    $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($data['tanggal_pinjam'])
                                                        ->setTimezone('Asia/Jakarta');

                                                    $nama_bulan = [
                                                        'January' => 'Januari',
                                                        'February' => 'Februari',
                                                        'March' => 'Maret',
                                                        'April' => 'April',
                                                        'May' => 'Mei',
                                                        'June' => 'Juni',
                                                        'July' => 'Juli',
                                                        'August' => 'Agustus',
                                                        'September' => 'September',
                                                        'October' => 'Oktober',
                                                        'November' => 'November',
                                                        'December' => 'Desember',
                                                    ];

                                                    $bulan = $nama_bulan[$tanggal_pinjam->format('F')];

                                                    echo $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y - H:i') . ' WIB';
                                                    ?>

                                </td>
                                <td width="15%"><?= $data['keperluan']; ?></td>
                                <td style="text-align: left;">
                                    <?php
                                    $barang_concat = $data['kode_nama_barang_concat'];
                                    $barang_array = explode(',', $barang_concat);

                                    foreach ($barang_array as $index => $barang) {
                                        echo ($index + 1) . ". " . $barang;

                                        // Tambahkan <br> kecuali untuk elemen terakhir
                                        if ($index < count($barang_array) - 1) {
                                            echo "<br>";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>



        <br>
        <div class="container">
            <table class="table table-no-border text-center">
                <thead>
                    <tr>
                        <th style="width: 50%;">

                            <p><?php echo $dataPengaturan['ttd_3'] ?></p>
                            <p class="jarak-ttd"></p>

                            <p class="underlined-text"><b> <?php echo $dataPengaturan['nama_ttd_3'] ?></b></p>
                            <p>NIK. <?php echo $dataPengaturan['id_ttd_3'] ?>
                        </th>
                        <th style="width: 50%;">
                            <p><?php echo $dataPengaturan['ttd_2'] ?>
                            <p class="jarak-ttd"></p>

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
                            <p class="jarak-ttd"></p>

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