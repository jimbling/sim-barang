<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penerimaan Bulan_<?= $namaBulan ?>_<?= $tahun ?>
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
            <center><b>REKAPITULASI DATA PENERIMAAN BARANG HABIS PAKAI LABORATORIUM KEPERAWATAN
                    <P>Bulan : <?= $namaBulan ?> Tahun: <?= $tahun ?>
                </b></CENTER>
        </h2>

        <div class="gradient-line"></div>
        <br>

        <div class="table-container page-break-before">
            <table class="table table-border">
                <thead class="thead">
                    <tr>
                        <th>Tanggal Penerimaan</th>
                        <th>Jenis Perolehan</th>
                        <th>Petugas</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah Barang</th>
                        <th>Jumlah Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalJumlahHargaKelompok = 0;
                    $totalJumlahHarga = 0;

                    $prevPenerimaanId = null; // Variabel bantu untuk menyimpan nilai penerimaan_id sebelumnya
                    $rowspanCount = 0; // Variabel bantu untuk menghitung jumlah baris yang memiliki nilai penerimaan_id yang sama

                    // Pengecekan untuk menampilkan pesan jika tidak ada data
                    if (empty($data_peminjaman)) {
                        echo '<tr><td colspan="8">Tidak ada data Penerimaan Barang Persediaan Laboratorium Keperawatan<strong> Bulan  ' . $namaBulan . ' Tahun ' . $tahun . ' </strong> </td></tr>';
                    } else {
                        foreach ($data_peminjaman as $index => $row) :
                            // Jika penerimaan_id berubah, hitung jumlah baris yang memiliki nilai penerimaan_id yang sama
                            if ($prevPenerimaanId !== $row['penerimaan_id']) {
                                $rowspanCount = count(array_filter($data_peminjaman, function ($item) use ($row) {
                                    return $item['penerimaan_id'] === $row['penerimaan_id'];
                                }));
                            }

                    ?>
                            <tr>
                                <!-- Tampilkan data hanya sekali dalam satu kelompok penerimaan_id -->
                                <?php if ($prevPenerimaanId !== $row['penerimaan_id']) : ?>
                                    <td rowspan="<?= $rowspanCount; ?>">

                                        <?php
                                        $tanggal_penerimaan = \CodeIgniter\I18n\Time::parse($row['tanggal_penerimaan'])
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

                                        $bulan = $nama_bulan[$tanggal_penerimaan->format('F')];

                                        // Format the date to display only the date without time
                                        $formattedDate = $tanggal_penerimaan->format('d ') . $bulan . $tanggal_penerimaan->format(' Y');

                                        echo $formattedDate;
                                        ?>

                                    <td rowspan="<?= $rowspanCount; ?>"><?= $row['jenis_perolehan']; ?></td>
                                    <td rowspan="<?= $rowspanCount; ?>"><?= $row['petugas']; ?></td>
                                <?php endif; ?>

                                <!-- Tampilkan data yang berulang -->
                                <td><?= $row['kode_barang']; ?></td>
                                <td><?= $row['nama_barang']; ?></td>
                                <td>Rp. <?= number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
                                <td><?= $row['jumlah_barang']; ?> <?= $row['satuan']; ?></td>
                                <td>Rp. <?= number_format($row['jumlah_harga'], 0, ',', '.'); ?></td>
                            </tr>

                    <?php
                            // Akumulasi total jumlah harga kelompok
                            $totalJumlahHargaKelompok += $row['jumlah_harga'];

                            // Cek apakah ini baris terakhir atau penerimaan_id berubah
                            if ($index === count($data_peminjaman) - 1 || $row['penerimaan_id'] !== $data_peminjaman[$index + 1]['penerimaan_id']) {
                                echo '<tr><td colspan="7" style="text-align: right;" class="highlighted"><strong>Jumlah Penerimaan</strong></td><td><strong>Rp. ' . number_format($totalJumlahHargaKelompok, 0, ',', '.') . '</strong></td></tr>';
                                // Reset total untuk kelompok baru
                                $totalJumlahHargaKelompok = 0;
                            }

                            // Akumulasi total jumlah harga keseluruhan
                            $totalJumlahHarga += $row['jumlah_harga'];

                            // Simpan nilai penerimaan_id saat ini untuk digunakan pada iterasi selanjutnya
                            $prevPenerimaanId = $row['penerimaan_id'];
                        endforeach;
                    }
                    ?>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" style="text-align: right;"><strong>TOTAL KESELURUHAN PENERIMAAN</strong></td>
                        <td><strong>Rp. <?= number_format($totalJumlahHarga, 0, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot>
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