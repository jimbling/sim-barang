<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengeluaran Bulan_<?= $namaBulan ?>_<?= $tahun ?>
    </title>
    <link href="../../assets/dist/css/cetak-laporan-persediaan.css" rel="stylesheet" type="text/css">
    <script>
        // Jalankan pencetakan saat halaman dimuat
        window.onload = function() {
            window.print();
        };
    </script>
</head>

<body>
    <div class="col-sm-10">
        <img src="../../assets/dist/img/<?php echo $dataPengaturan['kop_surat'] ?>" width="450px">
    </div>
    <div class="container-fluid">

        <h2>
            <center><b>L A P O R A N

        </h2>
        <h2>
            <center><b>REKAPITULASI DATA PENGELUARAN BARANG HABIS PAKAI LABORATORIUM KEPERAWATAN
                    <P>Bulan : <?= $namaBulan ?> Tahun: <?= $tahun ?>
                </b></CENTER>
        </h2>

        <div class="gradient-line"></div>
        <br>

        <div class="table-container page-break-before">
            <table class="table table-border">
                <thead class="thead">
                    <tr>
                        <th>No</th>
                        <th>Kode Pinjam</th>
                        <th>Tanggal</th>
                        <th>Nama Pengguna</th>
                        <th>Keperluan</th>
                        <th>Nama Barang</th>
                        <th>Ambil Barang</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data_pengeluaran)) : ?>
                        <tr>
                            <td colspan="7" style="text-align: center; ">
                                Tidak ada data pengeluaran barang persediaan Laboratorim Keperawatan pada <strong> Bulan: <?= $namaBulan ?> Tahun: <?= $tahun ?></strong>.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1; ?>
                        <?php foreach ($data_pengeluaran as $index => $peminjaman) : ?>
                            <tr>
                                <?php if ($index === 0 || $peminjaman['peminjaman_id'] !== $data_pengeluaran[$index - 1]['peminjaman_id']) : ?>
                                    <!-- Tampilkan data hanya sekali dalam satu kelompok peminjaman_id -->
                                    <th class="text-center" scope="row" style="vertical-align: middle; " rowspan="<?= count(array_filter($data_pengeluaran, function ($item) use ($peminjaman) {
                                                                                                                        return $item['peminjaman_id'] === $peminjaman['peminjaman_id'];
                                                                                                                    })); ?>">
                                        <?= $i++; ?>
                                    </th>
                                    <td style="text-align: left; vertical-align: middle; " rowspan="<?= count(array_filter($data_pengeluaran, function ($item) use ($peminjaman) {
                                                                                                        return $item['peminjaman_id'] === $peminjaman['peminjaman_id'];
                                                                                                    })); ?>">
                                        <?= $peminjaman['kode_pinjam']; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle; " rowspan="<?= count(array_filter($data_pengeluaran, function ($item) use ($peminjaman) {
                                                                                                            return $item['peminjaman_id'] === $peminjaman['peminjaman_id'];
                                                                                                        })); ?>">
                                        <?php
                                        $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($peminjaman['tanggal_pinjam'])
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

                                        echo $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y');
                                        ?>
                                    </td>
                                    <td style="text-align: left; vertical-align: middle; " rowspan="<?= count(array_filter($data_pengeluaran, function ($item) use ($peminjaman) {
                                                                                                        return $item['peminjaman_id'] === $peminjaman['peminjaman_id'];
                                                                                                    })); ?>">
                                        <?php
                                        // Contoh data
                                        $peminjamanData = $peminjaman['nama_peminjam'];

                                        // Memisahkan string berdasarkan tanda "-"
                                        $splitData = explode('-', $peminjamanData);

                                        // Mengambil elemen kedua setelah pemisahan
                                        $namaPeminjam = isset($splitData[1]) ? trim($splitData[1]) : '';

                                        // Menampilkan nama peminjam
                                        echo $namaPeminjam;
                                        ?>
                                    </td>
                                    <td style="text-align: left; vertical-align: middle; " rowspan="<?= count(array_filter($data_pengeluaran, function ($item) use ($peminjaman) {
                                                                                                        return $item['peminjaman_id'] === $peminjaman['peminjaman_id'];
                                                                                                    })); ?>">
                                        <?= $peminjaman['keperluan']; ?>
                                    </td>
                                <?php endif; ?>

                                <!-- Tampilkan data yang berulang -->
                                <td style="text-align: left; vertical-align: middle; ">
                                    <?= $peminjaman['nama_barang']; ?>
                                </td>
                                <td style="text-align: left; vertical-align: middle; ">
                                    <?= $peminjaman['ambil_barang']; ?>
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