<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengembalian_<?php foreach ($peminjamanBarangDetails as $peminjamanBarangDetail) : ?>
        <?= $peminjamanBarangDetails[0]['kode_pinjam']; ?>
    <?php endforeach; ?>
    </title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css?v=3.2.0">
    <link href="../../assets/dist/css/cetak.css" rel="stylesheet" type="text/css">
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
        <div class="container mt-2">
            <h3>
                <center><b>F O R M U L I R

                        </h4>
                        <h5>
                            <center><b>PENGEMBALIAN BARANG LABORATORIUM KEPERAWATAN
                                </b></CENTER>
                        </h5>
        </div>
        <div class="gradient-line"></div>
        <br>
        <div>
            <h5>Identitas Peminjam:</h5>

            <table class="table table-sm table-borderless">
                <?php if (!empty($peminjamanBarangDetails)) : ?>
                    <tr>
                        <td width="30%">Kode Pinjam </td>
                        <td width="5%">:</td>
                        <td><?= $peminjamanBarangDetails[0]['kode_pinjam']; ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Nama Peminjam </td>
                        <td width="5%">:</td>
                        <td><?= $peminjamanBarangDetails[0]['nama_peminjam']; ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Tanggal Peminjaman </td>
                        <td width="5%">:</td>
                        <td><?php
                            $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($peminjamanBarangDetails[0]['tanggal_pinjam'])
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

                            // Format the date without using Carbon
                            $formattedDate = $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y - H:i') . ' WIB';

                            echo $formattedDate;
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Tanggal Pengembalian </td>
                        <td width="5%">:</td>
                        <td><?php
                            $tanggal_kembali = \CodeIgniter\I18n\Time::parse($peminjamanBarangDetails[0]['tanggal_pengembalian'])
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

                            $bulan = $nama_bulan[$tanggal_kembali->format('F')];

                            // Format the date without using Carbon
                            $formattedDate = $tanggal_kembali->format('d ') . $bulan . $tanggal_kembali->format(' Y - H:i') . ' WIB';

                            echo $formattedDate;
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Nama Dosen </td>
                        <td width="5%">:</td>
                        <td><?= $peminjamanBarangDetails[0]['nama_dosen']; ?></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Data peminjaman tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <br>
        <div class="underlined-text mb-2">
            <h5>
                <strong>Daftar Peminjaman Barang Laboratorium: </strong>
            </h5>
        </div>
        <table class="table table-border">
            <thead class="table table-border">
                <tr>
                    <th>#</th>
                    <th>Tempat Penggunaan</th>
                    <th>Keperluan</th>
                    <th>Nama Barang Yang Dipinjam</th>
                </tr>
            </thead>
            <tbody class="table-border">
                <?php
                $counter = 1; // Initialize a counter variable

                foreach ($peminjamanBarangDetails as $peminjamanBarangDetail) :
                    // Split the values by comma
                    $barang_dipinjam_values = explode(',', $peminjamanBarangDetail['barang_dipinjam']);
                    $item_counter = 1; // Initialize a counter for each item
                ?>
                    <tr>
                        <td style="text-align: center; vertical-align: middle;">
                            <?= $counter; ?>
                        </td>
                        <td style="text-align: center; vertical-align: middle;" class="narrow-column"><?= $peminjamanBarangDetail['nama_ruangan']; ?></td>
                        <td style="text-align: center; vertical-align: middle;" class="narrow-column"><?= $peminjamanBarangDetail['keperluan']; ?></td>
                        <td style="text-align: left; vertical-align: middle;">
                            <?php foreach ($barang_dipinjam_values as $value) : ?>
                                <?= $item_counter . '. ' . $value; ?>
                                <!-- Objek kotak yang lebih besar -->
                                <div class="large-checkbox"></div>
                                <br>
                                <hr style="margin: 2px 0;"> <!-- HR untuk memisahkan data -->
                            <?php
                                $item_counter++; // Increment item counter
                            endforeach; ?>
                        </td>
                    </tr>
                <?php
                    $counter++;
                endforeach;
                ?>
            </tbody>
        </table>


        <br>






    </div>



    <br>
    <p> Pada hari ini ........................................ tanggal ........................................ bulan ........................................ tahun ........................................
    <p> telah dikembalikan barang laboratoirum keperawatan oleh : <u><?php
                                                                        // Contoh data
                                                                        $peminjamanData = $peminjamanBarangDetails[0]['nama_peminjam'];

                                                                        // Memisahkan string berdasarkan tanda "-"
                                                                        $splitData = explode('-', $peminjamanData);

                                                                        // Mengambil elemen kedua setelah pemisahan
                                                                        $namaPeminjam = isset($splitData[1]) ? trim($splitData[1]) : '';

                                                                        // Menampilkan nama peminjam
                                                                        echo $namaPeminjam;
                                                                        ?></u>, berupa data barang-barang yang sudah terceklis pada formulir diatas.
    <p>Barang-barang tersebut telah diterima dalam keadaan Baik/Rusak oleh : <u><?php echo $dataPengaturan['nama_laboran'] ?></u>.

    <div class="container mt-2 mb-2">
        <div class="row">
            <div class="col page-break">
                <p> </p>
                <p> Peminjam </p>

                <br>

                <br>
                </br>
                <p class="underlined-text"><b><?php
                                                // Contoh data
                                                $peminjamanData = $peminjamanBarangDetails[0]['nama_peminjam'];

                                                // Memisahkan string berdasarkan tanda "-"
                                                $splitData = explode('-', $peminjamanData);

                                                // Mengambil elemen kedua setelah pemisahan
                                                $namaPeminjam = isset($splitData[1]) ? trim($splitData[1]) : '';

                                                // Menampilkan nama peminjam
                                                echo $namaPeminjam;
                                                ?></b></p>

            </div>
            <div class="col page-break">

                <p> Mengetahui,</p>
                <p> Laboran </p>

                <br>
                </br>
                <p class="underlined-text"><b> <?php echo $dataPengaturan['nama_laboran'] ?></b></p>
                NIK. <?php echo $dataPengaturan['nik_laboran'] ?>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <p> Data barang yang sudah terceklis adalah barang yang sudah dikembalikan.
        <br>
    <p>Catatan / Keterangan Tambahan :

</body>

</html>