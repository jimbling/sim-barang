<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengembalian Tahun_<?= $tahun ?>
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
        <img src="../../assets/dist/img/<?php echo $dataPengaturan['kop_surat'] ?>" width="450px">
    </div>
    <div class="container-fluid">

        <h2>
            <center><b>L A P O R A N

        </h2>
        <h2>
            <center><b>REKAPITULASI DATA PENGEMBALIAN BARANG LABORATORIUM KEPERAWATAN
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
                        <th>Kode Kembali</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Dosen</th>
                        <th>Ruangan</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Keperluan</th>
                        <th>Barang</th>
                    </tr>
                </thead>
                <?php
                // Definisikan array nama bulan
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
                ?>
                <tbody class="table-border">
                    <?php if (empty($groupedDataByYear)) : ?>
                        <tr>
                            <td colspan="9" style="text-align: center;">Tidak ada data pengembalian pada bulan: <?= $namaBulan ?> Tahun: <?= $tahun ?></td>
                        </tr>
                    <?php else : ?>
                        <?php $number = 1; ?>
                        <?php foreach ($groupedDataByYear as $kodeKembali => $items) : ?>
                            <?php $firstItem = reset($items); ?>
                            <tr>
                                <td><?= $number; ?></td>
                                <td><?= $firstItem['kode_kembali']; ?></td>
                                <td><?= $firstItem['nama_peminjam']; ?></td>
                                <td><?= $firstItem['nama_dosen']; ?></td>
                                <td><?= $firstItem['nama_ruangan']; ?></td>
                                <td>
                                    <?php
                                    $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($firstItem['tanggal_pinjam'])
                                        ->setTimezone('Asia/Jakarta');
                                    $bulan = $nama_bulan[$tanggal_pinjam->format('F')];
                                    echo $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y - H:i') . ' WIB';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $tanggal_kembali = \CodeIgniter\I18n\Time::parse($firstItem['tanggal_kembali'])
                                        ->setTimezone('Asia/Jakarta');
                                    $bulan = $nama_bulan[$tanggal_kembali->format('F')];
                                    echo $tanggal_kembali->format('d ') . $bulan . $tanggal_kembali->format(' Y - H:i') . ' WIB';
                                    ?>
                                </td>
                                <td width='12%'><?= $firstItem['keperluan']; ?></td>
                                <td style="text-align: left;">
                                    <?php $barangNumber = 1; ?>
                                    <?php foreach ($items as $item) : ?>
                                        <?php
                                        // Pisahkan string nama_barang dan kode_barang berdasarkan koma
                                        $barangArray = explode(",", $item['nama_barang']);
                                        $kodeBarangArray = explode(",", $item['kode_barang']);

                                        // Tampilkan setiap barang dengan nomor urut menggunakan <p>
                                        foreach ($barangArray as $key => $barang) {
                                            echo '<p>' . $barangNumber++ . '. ' . htmlspecialchars($barang) . ' - ' . htmlspecialchars($kodeBarangArray[$key]) . '</p>';
                                        }
                                        ?>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <?php $number++; // Increment the number for the next group 
                            ?>
                        <?php endforeach; ?>
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




    </div>





</body>

</html>